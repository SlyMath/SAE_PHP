<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Model_song');
    }

    public function index(){
        $artists = $this->Model_song->getSong();
        $this->load->view('layout/header');
        $this->load->view('songs_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
    }

    public function sortAZ() {
        $artists = $this->Model_song->getSongAZ();
        $this->load->view('layout/header');
        $this->load->view('songs_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
        }
    
    public function sortZA() {
        $artists = $this->Model_song->getsongZA();
        $this->load->view('layout/header');
        $this->load->view('songs_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
        }

    public function search() {
        $input = $this->input->get('query'); // Retrieve the query from GET request
        $artists = $this->Model_song->search($input);
        $this->load->view('layout/header');
        $this->load->view('songs_list', ['artists' => $artists]);
        $this->load->view('layout/footer');
    }

}
?>
