<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_album extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function get_album_details($album_id) {
        // Construire la requête avec une jointure entre les tables 'track' et 'song'
        $this->db->select('track.*, song.name as song_name');
        $this->db->from('track');
        $this->db->join('song', 'track.songId = song.id');
        $this->db->where('track.albumId', $album_id);
        $query = $this->db->get();
    
        return $query->result();
    }

    public function getSongAZ($album_id) {
        $this->db->select('track.*, song.name as song_name');
        $this->db->from('track');
        $this->db->join('song', 'track.songId = song.id');
        $this->db->where('track.albumId', $album_id);
        $this->db->order_by('song.name', 'ASC');
        $query = $this->db->get();
    
        return $query->result();
    }

    public function getSongZA($album_id) {
        $this->db->select('track.*, song.name as song_name');
        $this->db->from('track');
        $this->db->join('song', 'track.songId = song.id');
        $this->db->where('track.albumId', $album_id);
        $this->db->order_by('song.name', 'DESC');
        $query = $this->db->get();
    
        return $query->result();
    }

    
}
?>