<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Songs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Model_song');
        $this->load->model('Model_user');
        $this->load->model('Model_music');
    }

    public function index(){
        $songs = $this->Model_song->getSong();

        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('songs_list',['songs'=>$songs, 'genres'=>$genres]);
		$this->load->view('layout/footer');
    }

    public function sortAZ() {
        $songs = $this->Model_song->getSongAZ();
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('songs_list',['songs'=>$songs, 'genres'=>$genres]);
		$this->load->view('layout/footer');
        }
    
    public function sortZA() {
        $songs = $this->Model_song->getSongZA();
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('songs_list',['songs'=>$songs, 'genres'=>$genres]);
		$this->load->view('layout/footer');
        }

    public function sortGenre($genreId)
	{
		$songs = $this->Model_song->getSongGenre($genreId);
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('songs_list',['songs'=>$songs, 'genres'=>$genres]);
		$this->load->view('layout/footer');
	}

    public function search() {
        $input = $this->input->get('query'); // Retrieve the query from GET request
        $songs = $this->Model_song->search($input);
        $genres = $this->Model_music->getGenre();
		$this->load->view('layout/header');
		$this->load->view('songs_list',['songs'=>$songs, 'genres'=>$genres]);
		$this->load->view('layout/footer');
    }

}
?>
