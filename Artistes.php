<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artistes extends CI_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->model('Model_artist');
        $this->load->model('Model_user');
    }

    public function index(){
        $artists = $this->Model_artist->getArtists();
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
    }

    public function view($id){
        // Prends les albums d'un artist en particuler et les envoie a la vue.
        $albums = $this->Model_artist->getArtistById($id);
        $this->load->view('layout/header');
        $this->load->view('artists/view', ['albums' => $albums]);
        $this->load->view('layout/footer');
    }
    
    public function sortAZ() {
        $artists = $this->Model_artist->getArtistByNameAZ();
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
        }
    
    public function sortZA() {
        $artists = $this->Model_artist->getArtistByNameZA();
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
        }

    public function search() {
        $input = $this->input->get('query'); // Retrieve the query from GET request
        $artists = $this->Model_artist->search($input);
        $this->load->view('layout/header');
        $this->load->view('artists_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
    }
}
?>