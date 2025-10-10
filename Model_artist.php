<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_artist extends CI_Model {
    public function __construct(){
        $this->load->database();
    }

    public function getArtists(){
        $query = $this->db->get('artist');
        return $query->result();
    }

    public function getArtistById($id){
        $query = $this->db->query(
            "SELECT album.name,album.id,year,artist.name as artistName, artist.id as artistId, genre.name as genreName,jpeg 
            FROM album 
            JOIN artist ON album.artistid = artist.id
            JOIN genre ON genre.id = album.genreid
            JOIN cover ON cover.id = album.coverid
            WHERE artist.id = $id;
            "
        );
    return $query->result();
    }

    public function getArtistByNameAZ() {
        $this->db->order_by('name', 'ASC');
        $query = $this->db->get('artist');
        return $query->result();
        }

    public function getArtistByNameZA() {
        $this->db->order_by('name', 'DESC');
        $query = $this->db->get('artist');
        return $query->result();
        }

    public function search($input) {
        $input = '%' . $input . '%';
        $sql = "SELECT * FROM artist WHERE name LIKE ?";
        $query = $this->db->query($sql, array($input));
        return $query->result();
    }
}
?>