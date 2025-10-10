<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Model_user');
        $this->data['error'] = '';
    }

    public function index(){
        $this->load->view('register');
        $this->load->view('layout/footer');
    }

    public function register() {
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        // Initialize error messages
        $this->data['error'] = '';

        if ($this->validate_username($username) && $this->validate_password($password) && $this->validate_email($email)) {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $this->db->insert('utilisateur', array('nom' => $username, 'email' => $email, 'mot_de_passe' => $password));
            redirect('albums');
        } else {
            // Pass $this->data to the view
            $this->load->view('register', $this->data);
            // Clear error message after use
            $this->data['error'] = '';
        }
    }

    public function validate_username($username) {
        if (strlen($username) > 30) {
            $this->data['error'] .= 'Username: maximum of 30 characters.<br>';
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $this->data['error'] .= 'Username: no special characters.<br>';
            return false;
        }

        return true;
    }

    public function validate_password($password) {
        if (strlen($password) < 5) {
            $this->data['error'] .= 'Password: minimum of 5 characters.<br>';
            return false;
        }

        if (strlen($password) >= 250) {
            $this->data['error'] .= 'Password: maximum of 250 characters.<br>';
            return false;
        }

        return true;
    }

    public function validate_email($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->data['error'] .= 'Email: invalid or already in use.<br>';
            return false;
        }

        $query = $this->db->get_where('utilisateur', array('email' => $email));

        $exists = $query->row();
        if ($exists == null) {
            return true;
        } else {
            $this->data['error'] .= 'Email: invalid or already in use.<br>';
            return false;
        }
    }
}
?>
