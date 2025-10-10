<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Model_user extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Chargement de la base de données
        $this->load->database();
    }

    public function is_logged_in() {
        return $this->session->has_userdata('user_id');
    }

}
?>
