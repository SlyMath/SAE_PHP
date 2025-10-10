<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');                                             

class Model_song extends CI_Model {
	public function __construct(){
		$this->load->database();
	}

	public function getSong() {
        $sql = "
            SELECT
                s.id AS songId,
                s.name AS songname,
                a.name AS artistname,
                al.name AS albumName,
                t.duration AS duration
            FROM
                song s
            JOIN
                track t ON s.id = t.songId
            JOIN
                album al ON t.albumId = al.id
            JOIN
                artist a ON al.artistId = a.id
        ";
    
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getSongAZ() {
        $sql = "
            SELECT
                s.id AS songId,
                s.name AS songname,
                a.name AS artistname,
                al.name AS albumName,
                t.duration AS duration
            FROM
                song s
            JOIN
                track t ON s.id = t.songId
            JOIN
                album al ON t.albumId = al.id
            JOIN
                artist a ON al.artistId = a.id
            ORDER BY songname ASC
        ";
    
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getSongZA() {
        $sql = "
            SELECT
                s.id AS songId,
                s.name AS songname,
                a.name AS artistname,
                al.name AS albumName,
                t.duration AS duration
            FROM
                song s
            JOIN
                track t ON s.id = t.songId
            JOIN
                album al ON t.albumId = al.id
            JOIN
                artist a ON al.artistId = a.id
            ORDER BY songname DESC
        ";
    
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function search($input) {
        $input = '%' . $input . '%';
        $sql = "
            SELECT DISTINCT
                s.id AS songId,
                s.name AS songname,
                a.name AS artistname,
                al.name AS albumName,
                t.duration AS duration
            FROM
                song s
            JOIN
                track t ON s.id = t.songId
            JOIN
                album al ON t.albumId = al.id
            JOIN
                artist a ON al.artistId = a.id
            WHERE
                s.name LIKE ?
        ";
        $query = $this->db->query($sql, array($input));
        return $query->result();
    }

    public function getSongGenre($genreId)
    {
        $sql = "SELECT 
                s.id AS songId,
                s.name AS songname,
                a.name AS artistname,
                al.name AS albumName,
                t.duration AS duration
            FROM
                song s
            JOIN track t ON t.songId = s.id
            JOIN album al ON al.id = t.albumId
            JOIN genre g ON g.id = al.genreId
            JOIN artist a ON a.id = al.artistId
            WHERE g.id = ?
        ";

        $query = $this->db->query($sql, array($genreId));

        return $query->result();
    }

    
}


