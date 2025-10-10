<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Model_user');
		$this->load->model('Model_playlist');
		$this->load->model('Model_song');
		$this->load->model('Model_music');
		$this->load->model('Model_artist');
	}
	public function index(){
        $playlist = $this->Model_playlist->getPlaylist();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlist, 'genres' => $genres]);
		$this->load->view('layout/footer');
	}

	public function addPlaylist() {
		$this->load->view('layout/header');
		$this->load->view('add_playlist');
		$this->load->view('layout/footer');
	}

	public function addNewPlaylist() {
		$playlistName = $this->input->post('Playlist_name');
	
		// Vérifier si un fichier a été téléchargé
		if (isset($_FILES['Playlist_image']) && $_FILES['Playlist_image']['error'] == UPLOAD_ERR_OK) {
			$fileTmpPath = $_FILES['Playlist_image']['tmp_name'];
			$fileName = $_FILES['Playlist_image']['name'];
			$fileType = $_FILES['Playlist_image']['type'];
			$fileNameCmps = explode(".", $fileName);
			$fileExtension = strtolower(end($fileNameCmps));
	
			// Vérifiez si le fichier est un JPEG
			if ($fileExtension == 'jpg' || $fileExtension == 'jpeg') {
				$jpegData = file_get_contents($fileTmpPath);
			} else {
				// Gestion des erreurs pour les formats non supportés
				$error = "Only JPG files are allowed.";
				$this->load->view('some_view', ['error' => $error]);
				return;
			}
		} else {
			// Utiliser l'image par défaut
			$defaultPath = APPPATH . 'assets/images/default_cover.jpg';
			if (file_exists($defaultPath)) {
				$jpegData = file_get_contents($defaultPath);
			} else {
				// Gestion de l'erreur si l'image par défaut n'existe pas
				$error = "Default image not found.";
				$this->load->view('error', ['error' => $error]);
				return;
			}
		}
	
		// Appeler le modèle pour ajouter la playlist
		$this->Model_playlist->addPlaylist($playlistName, $jpegData);
	
		// Récupérer la liste des playlists
		$playlist = $this->Model_playlist->getPlaylist();
		$genres = $this->Model_music->getGenre();
		// Charger les vues
		$this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlist, 'genres' => $genres]);
		$this->load->view('layout/footer');
	}
	
	public function deletePlaylist($playlistId) {
		$this->Model_playlist->deletePlaylist($playlistId);
		$playlist = $this->Model_playlist->getPlaylist();
		$this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlist]);
		$this->load->view('layout/footer');
	}

	public function view($playlistId) {
		$data['playlist'] = $this->Model_playlist->getPlaylistById($playlistId);
		$data['songs'] = $this->Model_playlist->getSongById($playlistId);
		$data['playlistId'] = $playlistId; // Ajout de $playlistId à $data
		$this->load->view('layout/header');
		$this->load->view('playlist/view', $data);
		$this->load->view('layout/footer');
	}

	public function sortAZ() {
		$playlist = $this->Model_playlist->getPlaylistByNameAZ();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlist, 'genres' => $genres]);
		$this->load->view('layout/footer');
	}

	public function sortZA() {
		$playlist = $this->Model_playlist->getPlaylistByNameZA();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlist, 'genres' => $genres]);
		$this->load->view('layout/footer');
	}

	public function search() {
        $input = $this->input->get('query'); // Retrieve the query from GET request
        $playlists = $this->Model_playlist->search($input);
		$genres = $this->Model_music->getGenre();
        $this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlists, 'genres' => $genres]);
		$this->load->view('layout/footer');
    }

	public function addSongPlaylist($songId, $playlistId) {
		$this->Model_playlist->addSong($playlistId, $songId);
		$data['songs'] = $this->Model_song->getSong();
		$data['playlistId'] = $playlistId; // Ajout de $playlistId à $data
		$this->load->view('layout/header');
		$this->load->view('songs_list', $data); // Passer $data à la vue
		$this->load->view('layout/footer');
	}

	public function deleteSongPlaylist($playlistId, $songId) {
		$this->Model_playlist->deleteSong($playlistId, $songId);
		$data['playlist'] = $this->Model_playlist->getPlaylistById($playlistId);
		$data['songs'] = $this->Model_playlist->getSongById($playlistId);
		$data['playlistId'] = $playlistId; // Ajout de $playlistId à $data
		$this->load->view('layout/header');
		$this->load->view('playlist/view', $data);
		$this->load->view('layout/footer');
	}

	public function addSongFromAlbum($albumId, $songId) {
		$playlist = $this->Model_playlist->getPlaylist();
		$this->load->view('layout/header');
		$this->load->view('select_playlist', array('albumId' => $albumId, 'songId' => $songId, 'playlists' => $playlist));
		$this->load->view('layout/footer');
	}

	public function addSongFromAlbumToPlaylist($albumId, $playlistId, $songId)
	{
		$this->Model_playlist->addSong($playlistId, $songId);
		$songs = $this->Model_music->getAlbumById($albumId);
		$album = $this->Model_music->getAlbumDetailsById($albumId);
		$data[] = [
			'album' => $album,
			'songs' => $songs
		];
        $this->load->view('layout/header');
        $this->load->view('albums/view', ['data' => $data, 'playlistId', $albumId]);
        $this->load->view('layout/footer');
	}

	public function addAlbum($albumId)
	{
		$playlist = $this->Model_playlist->getPlaylist();
		$this->load->view('layout/header');
		$this->load->view('select_playlist_for_album', array('albumId' => $albumId, 'playlists' => $playlist));
		$this->load->view('layout/footer');
	}

	public function addAlbumToPlaylist($albumId, $playlistId)
	{
		$this->Model_playlist->addAlbum($playlistId, $albumId);
		$songs = $this->Model_music->getAlbumById($albumId);
		$album = $this->Model_music->getAlbumDetailsById($albumId);
		$data[] = [
			'album' => $album,
			'songs' => $songs
		];
        $this->load->view('layout/header');
        $this->load->view('albums/view', ['data' => $data, 'playlistId', $albumId]);
        $this->load->view('layout/footer');
	}

	public function duplicatePlaylist($playlistId)
	{
		$playlist = $this->Model_playlist->getPlaylistExcpetId($playlistId);
		$this->load->view('layout/header');
		$this->load->view('select_playlist_for_playlist', array('playlistId' => $playlistId, 'playlists' => $playlist));
		$this->load->view('layout/footer');
	}

	public function addPlaylistToPlaylist($id, $playlistId) // $id est la playlist a ajouter a $playlistId
	{
		$this->Model_playlist->addPlaylistToPlaylist($playlistId, $id);
		$data['playlist'] = $this->Model_playlist->getPlaylistById($id);
		$data['songs'] = $this->Model_playlist->getSongById($id);
		$data['playlistId'] = $playlistId; // Ajout de $playlistId à $data
		$this->load->view('layout/header');
		$this->load->view('playlist/view', $data);
		$this->load->view('layout/footer');
	}
	

	public function addArtistAlbumsView($artistId)
	{
		$playlists = $this->Model_playlist->getPlaylist();
        $this->load->view('layout/header');
		$this->load->view('select_playlist_for_artist', array('artistId' => $artistId, 'playlists' => $playlists));
		$this->load->view('layout/footer');
	}

	public function addArtistAlbums($artistId, $playlistId)
	{
		$this->Model_playlist->addArtistAlbums($playlistId, $artistId);
		$albums = $this->Model_artist->getArtistById($artistId);
        $this->load->view('layout/header');
        $this->load->view('artists/view', ['albums' => $albums]);
        $this->load->view('layout/footer');
	}

	public function addSongPlaylistView($songId)
	{
		$playlists = $this->Model_playlist->getPlaylist();
        $this->load->view('layout/header');
		$this->load->view('select_playlist_for_song', array('songId' => $songId, 'playlists' => $playlists));
		$this->load->view('layout/footer');
	}

	public function generatePlaylistByGenre($genreId, $playlistId, $limit)
	{
		$this->Model_playlist->generateRandomPlaylistByGenre($genreId, $playlistId, $limit);
		$playlist = $this->Model_playlist->getPlaylist();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlist, 'genres' => $genres]);
		$this->load->view('layout/footer');
	}

	public function generatePlaylist($playlistId, $limit)
	{
		$this->Model_playlist->generateRandomPlaylist($playlistId, $limit);
		$playlist = $this->Model_playlist->getPlaylist();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('playlist_list', ['playlists' => $playlist, 'genres' => $genres]);
		$this->load->view('layout/footer');
	}

}

