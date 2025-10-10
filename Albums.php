<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Albums extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('Model_music');
		$this->load->model('Model_user');
		$this->load->model('Model_album');
	}
	public function index(){
		$albums = $this->Model_music->getAlbums();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
	}

	public function sortAZ() {
		$albums = $this->Model_music->getAlbumsAZ();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
	}

	public function sortZA() {
		$albums = $this->Model_music->getAlbumsZA();
		$genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
		}
	

	public function sortSongAZ($album_id) {
		$tracks = $this->Model_album->getSongAZ($album_id);
		$this->load->view('layout/header');
		$this->load->view('albums/view', ['tracks'=>$tracks, 'album_id' => $album_id]);
		$this->load->view('layout/footer');
		}

	public function sortSongZA($album_id) {
		$tracks = $this->Model_album->getSongZA($album_id);
		$this->load->view('layout/header');
		$this->load->view('albums/view', ['tracks'=>$tracks, 'album_id' => $album_id]);
		$this->load->view('layout/footer');
		}
	
	public function sortNewest() {
        $albums = $this->Model_music->getAlbumsByNewest();
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
    }

    public function sortOldest() {
        $albums = $this->Model_music->getAlbumsByOldest();
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
    }

	public function search() {
        $input = $this->input->get('query'); // Retrieve the query from GET request
        $albums = $this->Model_music->search($input);
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
    }

	public function view($id) {
        $songs = $this->Model_music->getAlbumById($id);
		$album = $this->Model_music->getAlbumDetailsById($id);
		$data[] = [
			'album' => $album,
			'songs' => $songs
		];
        $this->load->view('layout/header');
        $this->load->view('albums/view', ['data' => $data, 'playlistId', $id]);
        $this->load->view('layout/footer');
    
    }


    public function albums_by_artist($artistId) {
        $albums = $this->Model_music->getAlbumsByArtistId($artistId);
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
    }


	public function sortGenre($genreId)
	{
		$albums = $this->Model_music->getAlbumsByGenre($genreId);
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('albums_list',['albums'=>$albums, 'genres'=>$genres]);
		$this->load->view('layout/footer');
	}
}

