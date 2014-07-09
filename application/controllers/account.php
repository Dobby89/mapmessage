<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('thread_model');
        $this->load->model('user_model');

        // include form helper and library
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->load->library('SimpleLoginSecure');
    }

    public function index() {

        redirect('account/login');
    }

    public function dashboard() {

        $this->load->view('account/dashboard');
    }

    public function create_account() {

        if($this->session->userdata('logged_in')) {

            // the user is already logged in, so redirect to their dashboard
            redirect('account/dashboard');
        }

        // set up form validation rules
        $this->form_validation->set_rules('url', 'URL', 'trim');
        $this->form_validation->set_rules('user_username', 'Username', 'trim|required|max_length[225]|alpha_dash|is_unique[users.username]');
        $this->form_validation->set_rules('user_email', 'Email', 'required|valid_email|matches[user_email_confirm]|is_unique[users.email]');
        $this->form_validation->set_rules('user_email_confirm', 'Password Confirmation', 'required');
        $this->form_validation->set_rules('user_password', 'Password', 'required|matches[user_password_confirm]');
        $this->form_validation->set_rules('user_password_confirm', 'Password Confirmation', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->input->post() && $this->form_validation->run()) { // the user is trying to create an account

            if($this->input->post('email_address') == '') { // honeypot field check, if this is filled in, it shouldn't be processed (spam)

                $user_data = $this->input->post();

                // create user and log them in
                if($this->simpleloginsecure->create($user_data['user_email'], $user_data['user_password'], true, $user_data['user_username'])) {

                    $this->session->set_flashdata('success', 'Success! You have been logged in.');
                    redirect('account/dashboard');

                } else {

                    $this->session->set_flashdata('error', 'Couldn\'t create account. Try again.');
                    redirect('account/create');
                }
            }
        } else { // the user is not trying to create an account, so show the form
            $this->load->view('account/create');
        }
    }

    public function login() {

        if($this->session->userdata('logged_in')) {

            // the user is already logged in, so redirect to their dashboard
            redirect('account/dashboard');
        }

        // set up form validation rules
        $this->form_validation->set_rules('url', 'URL', 'trim');
        $this->form_validation->set_rules('user_email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('user_password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->input->post() && $this->form_validation->run()) { // the user is trying to login

            $user_data = $this->input->post();

            // attempt to login
            if($this->simpleloginsecure->login($user_data['user_email'], $user_data['user_password'])) {

                // success

            } else {

                // failed login
                redirect('account/login');
            }

        } else { // the user is not trying to login, so show the form

            $this->load->view('account/login');
        }
    }

    public function logout() {

        // logout
        $this->simpleloginsecure->logout();
        redirect();
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */