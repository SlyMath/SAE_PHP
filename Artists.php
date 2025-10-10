<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artists extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Model_artist');
    }

    public function index(){
        $artists = $this->Model_artist->getArtists();
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
    }

    public function view($id){
        $artist = $this->Model_artist->getArtistById($id);
        $this->load->view('layout/header');
        $this->load->view('artist_detail', ['artist' => $artist]);
        $this->load->view('layout/footer');
    }
    
    public function sortAZ() {
        $artists = $this->Model_artist->getArtistByNameAZ();
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
        }
    
    public function sortZA() {
        $artist = $this->Model_artist->getArtistByNameZA();
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists]);
        $this->load->view('layout/header');
        }
}
?>

