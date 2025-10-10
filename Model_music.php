<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');                                             

class Model_music extends CI_Model {
	public function __construct(){
		$this->load->database();
	}

	public function getAlbums(){
		$query = $this->db->query(
			"SELECT album.name,album.id,year,artist.name as artistName, genre.name as genreName,jpeg 
			FROM album 
			JOIN artist ON album.artistid = artist.id
			JOIN genre ON genre.id = album.genreid
			JOIN cover ON cover.id = album.coverid
			ORDER BY year
			"
		);
	return $query->result();
	}

	public function getAlbumsAZ() {
        $query = $this->db->query(
			"SELECT album.name,album.id,year,artist.name as artistName, genre.name as genreName,jpeg 
			FROM album 
			JOIN artist ON album.artistid = artist.id
			JOIN genre ON genre.id = album.genreid
			JOIN cover ON cover.id = album.coverid
			ORDER BY album.name;
			"
		);
        return $query->result();
    }

	public function getAlbumsZA() {
		$query = $this->db->query(
		"SELECT album.name,album.id,year,artist.name as artistName, genre.name as genreName,jpeg 
				FROM album 
				JOIN artist ON album.artistid = artist.id
				JOIN genre ON genre.id = album.genreid
				JOIN cover ON cover.id = album.coverid
				ORDER BY album.name DESC"
			);
			return $query->result();
		}
	

	public function getAlbumsByNewest() {
		$query = $this->db->query(
			"SELECT album.name,album.id,year,artist.name as artistName, genre.name as genreName,jpeg 
			FROM album 
			JOIN artist ON album.artistid = artist.id
			JOIN genre ON genre.id = album.genreid
			JOIN cover ON cover.id = album.coverid
			ORDER BY album.year DESC;
			"
		);
        return $query->result();
    }

    public function getAlbumsByOldest() {
        $query = $this->db->query(
			"SELECT album.name,album.id,year,artist.name as artistName, genre.name as genreName,jpeg 
			FROM album 
			JOIN artist ON album.artistid = artist.id
			JOIN genre ON genre.id = album.genreid
			JOIN cover ON cover.id = album.coverid
			ORDER BY album.year ASC;
			"
		);
        return $query->result();
    }
	
	public function search($input) {
        $input = '%' . $input . '%';
        $sql = "SELECT album.name, album.id, year, artist.name AS artistName, genre.name AS genreName, jpeg 
			FROM album 
			JOIN artist ON album.artistid = artist.id
			JOIN genre ON genre.id = album.genreid
			JOIN cover ON cover.id = album.coverid
			WHERE album.name LIKE ?
			ORDER BY year";
        $query = $this->db->query($sql, array($input));
        return $query->result();
    }

	public function getAlbumById($id) {
		// Il faut : cover de l'album*, nom de l'album*, artiste de l'album*, année de sortie de l'album*,
		// titre de chaque musique, durée de chaque musique, id de chaque musique
		
		$sql = "SELECT
		t.duration AS trackDuration, 
    	s.id AS songId,
    	s.name AS songName
		FROM 
		album al
		JOIN artist a ON al.artistId = a.id
		JOIN cover c ON al.coverId = c.id
		JOIN track t ON al.id = t.albumId
		JOIN song s ON t.songId = s.id
		WHERE al.id = ?
		";

		$query = $this->db->query($sql, array($id));

		return $query->result();
	}

	public function getAlbumDetailsById($id) 
	{
		$sql = "SELECT
		c.jpeg AS albumCover,
		al.name AS albumName,
		a.name AS artistName,
		al.year AS albumYear,
		al.id AS albumId
		FROM 
		album al
		JOIN artist a ON al.artistId = a.id
		JOIN cover c ON al.coverId = c.id 
		WHERE al.id = ?
		";

		$query = $this->db->query($sql, array($id));

		return $query->result();
	}

	public function getAlbumsByGenre($genreId)
	{
		$query = $this->db->query(
			"SELECT album.name,album.id,year,artist.name as artistName, genre.name as genreName,jpeg 
			FROM album 
			JOIN artist ON album.artistid = artist.id
			JOIN genre ON genre.id = album.genreid
			JOIN cover ON cover.id = album.coverid
			WHERE album.genreId = $genreId
			"
		);
        return $query->result();
	}

	public function getGenre()
	{
		
		$query = $this->db->query(
			'SELECT *
			FROM genre'
		);

		return $query->result();

	}

}



// LET ME WORK IN PISSSSSS !!!