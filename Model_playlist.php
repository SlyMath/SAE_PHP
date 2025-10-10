<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_playlist extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getPlaylist(){
        $userId = $this->session->userdata('user_id');
        $this->db->where('user_id', $userId);
        $query = $this->db->get('playlist');
        return $query->result();
    }

    public function getPlaylistById($id) {
        $userId = $this->session->userdata('user_id');
        
        $this->db->where('id', $id);
        $this->db->where('user_id', $userId);
        $query = $this->db->get('playlist');
        
        return $query->row();
    }

    public function getSongById($id) {
        $userId = $this->session->userdata('user_id');
        $sql = "
        SELECT 
    t.duration AS track_duration, 
    s.id AS songId,
    s.name AS songName,
    al.name AS albumName,
    a.name AS artistName
FROM 
    playlist p
JOIN 
    playlist_item pi ON p.id = pi.playlist_id
JOIN 
    track t ON pi.songId = t.songId
JOIN 
    song s ON pi.songId = s.id
JOIN 
    album al ON t.albumId = al.id
JOIN 
    artist a ON al.artistId = a.id
WHERE 
    p.id = ? AND p.user_id = $userId
GROUP BY
    s.name
        ";
        
        $query = $this->db->query($sql, array($id));

        return $query->result();
    }
    

    public function getPlaylistByNameAZ() {
        $this->db->order_by('nom', 'ASC');
        $query = $this->db->get_where('playlist', array('user_id' => $this->session->userdata('user_id')));
        return $query->result();
        }

    public function getPlaylistByNameZA() {
        $this->db->order_by('nom', 'DESC');
        $query = $this->db->get_where('playlist', array('user_id' => $this->session->userdata('user_id')));
        return $query->result();
        }

    public function search($input) {
        $input = '%' . $input . '%';
        $userid = $this->session->userdata('user_id');
        $sql = "SELECT * FROM playlist WHERE user_id = ? AND nom LIKE ?";
        $query = $this->db->query($sql, array($userid, $input));
        return $query->result();
    }

    public function addPlaylist($nom, $jpeg) {
        $data = array(
            'nom' => $nom,
            'user_id' => $this->session->userdata('user_id'),
            'jpeg' => $jpeg
        );

        return $this->db->insert('playlist', $data);
    }

    public function deletePlaylist($playlistId) {
        // Start transaction
        $this->db->trans_start();

        // Delete playlist items
        $this->db->where('playlist_id', $playlistId);
        $this->db->delete('playlist_item');

        // Delete the playlist
        $this->db->where('id', $playlistId);
        $this->db->delete('playlist');

        // Complete the transaction
        $this->db->trans_complete();

        return $this->db->trans_status(); // Return true if successful, false otherwise
    }

    public function addSong($playlistId, $songId) {
    
        // Données à insérer
        $data = array(
            'playlist_id' => $playlistId,
            'songId' => $songId,
        );
    
        // Insertion des données dans la table playlist_item
        $this->db->insert('playlist_item', $data);
        
        // Vérifier si l'insertion a réussi
        if ($this->db->affected_rows() > 0) {
            return true; // Succès
        } else {
            return false; // Échec
        }
    }

    public function deleteSong($playlistId, $songId) {
        // Clause WHERE pour spécifier les lignes à supprimer
        $this->db->where('playlist_id', $playlistId);
        $this->db->where('songId', $songId);
    
        // Supprimer les données de la table playlist_item
        $this->db->delete('playlist_item');
    
        // Vérifier si la suppression a réussi
        if ($this->db->affected_rows() > 0) {
            return true; // Succès
        } else {
            return false; // Échec
        }
    }

    public function addAlbum($playlistId, $albumId) {
    
        $sql = 'SELECT
        song.id
        FROM
        song
        JOIN track ON track.songId = song.id
        JOIN album ON album.id = track.albumId
        WHERE album.id = ?
        ';

        $query = $this->db->query($sql, array($albumId));
        $songs = $query->result();
        // Insertion des données dans la table playlist_item
        
        foreach ($songs as $song)
        {
            $data = 
            [
                'playlist_id' => $playlistId,
                'songId' => $song->id
            ];
            $this->db->insert('playlist_item', $data);
        }
        
        
        // Vérifier si l'insertion a réussi
        if ($this->db->affected_rows() > 0) {
            return true; // Succès
        } else {
            return false; // Échec
        }
    }

    public function getPlaylistExcpetId($playlistId)
    {
        $userId = $this->session->userdata('user_id');
        $this->db->where('user_id', $userId);
        $this->db->where('id !=', $playlistId);
        $query = $this->db->get('playlist');
        return $query->result();
    }

    public function addPlaylistToPlaylist($playlistId, $id)
    {
        $sql = 'SELECT
        songId
        FROM
        playlist_item
        JOIN playlist ON playlist.id = playlist_item.playlist_id 
        WHERE playlist_item.playlist_id = ?
        ';

        $query = $this->db->query($sql, array($id));
        $songs = $query->result();
        // Insertion des données dans la table playlist_item
        
        foreach ($songs as $song)
        {
            $data = 
            [
                'playlist_id' => $playlistId,
                'songId' => $song->songId
            ];
            $this->db->insert('playlist_item', $data);
        }
        
        
        // Vérifier si l'insertion a réussi
        if ($this->db->affected_rows() > 0) {
            return true; // Succès
        } else {
            return false; // Échec
        }
    }

    public function addArtistAlbums($playlistId, $artistId)
    {
        $sql = "SELECT
        song.id as songId
        FROM song
        JOIN track ON track.songId = song.id
        JOIN album ON album.id = track.albumId
        JOIN artist ON artist.id = album.artistId
        WHERE artist.id = ?";

        $query = $this->db->query($sql, array($artistId));
        $songs = $query->result();

        foreach ($songs as $song)
        {
            $data = 
            [
                'playlist_id' => $playlistId,
                'songId' => $song->songId
            ];
            $this->db->insert('playlist_item', $data);
        }

        if ($this->db->affected_rows() > 0) {
            return true; // Succès
        } else {
            return false; // Échec
        }
    }

    public function generateRandomPlaylistByGenre($genreId, $playlistId, $limit)
    {
        $sql = "SELECT 
            s.id AS songId
        FROM
            song s
        JOIN track t ON t.songId = s.id
        JOIN album al ON al.id = t.albumId
        JOIN genre g ON g.id = al.genreId
        JOIN artist a ON a.id = al.artistId
        WHERE g.id = ?
        ORDER BY RAND()
        LIMIT ?";

        $query = $this->db->query($sql, array($genreId, (int)$limit));
        $songs = $query->result();

        foreach ($songs as $song)
        {
            $data = 
            [
                'playlist_id' => $playlistId,
                'songId' => $song->songId
            ];
            $this->db->insert('playlist_item', $data);
        }

        if ($this->db->affected_rows() > 0) {
            return true; // Succès
        } else {
            return false; // Échec
        }
    }

    public function generateRandomPlaylist($playlistId, $limit)
    {
        $sql = "SELECT 
            s.id AS songId
        FROM
            song s
        ORDER BY RAND()
        LIMIT ?";

        $query = $this->db->query($sql, array((int)$limit));
        $songs = $query->result();

        foreach ($songs as $song)
        {
            $data = 
            [
                'playlist_id' => $playlistId,
                'songId' => $song->songId
            ];
            $this->db->insert('playlist_item', $data);
        }

        if ($this->db->affected_rows() > 0) {
            return true; // Succès
        } else {
            return false; // Échec
        } 
    }

}
?>

