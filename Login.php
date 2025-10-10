<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Model_user');
    }

    public function index(){
        $this->load->view('login');
        $this->load->view('layout/footer');
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
    
        // Vérifier les informations d'identification
        if ($this->validate_credentials($email, $password)) {
            // Informations d'identification valides, créer une session
            $user_id = $this->get_user_id($email);
            $user_name = $this->get_user_name($email);
            $this->session->set_userdata('user_id', $user_id);
            $this->session->set_userdata('user_name', $user_name);
            redirect('albums'); // Rediriger vers la page de tableau de bord ou autre page après la connexion
        } else {
            // Informations d'identification invalides, afficher un message d'erreur
            $data['error'] = 'Invalid username or password';
            $this->load->view('login', $data);
        }
    }

    public function validate_credentials($email, $password) {
        // Retrieve the hashed password from the database based on the provided email
        $query = $this->db->get_where('utilisateur', array('email' => $email));
        $user = $query->row();
    
        // Check if a user with the provided email exists
        if ($user) {
            // Verify if the provided password matches the hashed password retrieved from the database
            if (password_verify($password, $user->mot_de_passe)) {
                // Password is verified, return true
                return true;
            }
        }
    
        // Either the user doesn't exist or the password is incorrect, return false
        return false;
    }

    public function get_user_id($email) {
        // Récupération de l'ID de l'utilisateur à partir de la base de données en fonction du nom d'utilisateur
        $query = $this->db->get_where('utilisateur', array('email' => $email));
        $user = $query->row();
        return ($user) ? $user->id : false;
    }

    public function get_user_name($email) {
        $query = $this->db->get_where('utilisateur', array('email' => $email));
        $user = $query->row(); // Utiliser row() pour récupérer une seule ligne
        
        if ($user) {
            return $user->nom; // Accéder à la propriété nom
        } else {
            return false; // Retourner false si aucun utilisateur trouvé
        }
    }

    public function logout() {
        // Supprimer les données de session de l'utilisateur
        $this->session->unset_userdata('user_id');
        
        // Rediriger l'utilisateur vers la page de connexion ou une autre page appropriée
        redirect('albums');
    }

    
}
?>