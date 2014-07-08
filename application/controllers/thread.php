<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thread extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('thread_model');
    }

    public function get_a_thread($id) {

        if($id) {

            $this->load->model('comment_model');

            $data['thread'] = $this->thread_model->get_a_thread($id);
            $data['comments'] = $this->comment_model->get_comments_by_thread_id($id);

            $this->load->view('thread', $data);
        }
    }

    public function get_nearby_threads()
    {
        $json = array('errors' => false);
        $json['threads'] = array();

        if($this->input->is_ajax_request()){

            // Handle POST events
            if($this->input->post()) {

                if($this->input->post('lat') && $this->input->post('long')){
                    $orig_lat = $this->input->post('lat');
                    $orig_long = $this->input->post('long');
                }

                if($this->input->post('radius')){
                    $radius = $this->input->post('radius');
                }

                foreach($this->thread_model->get_threads($orig_lat, $orig_long, $radius) as $thread){

                    $thread['title'] = htmlentities($thread['title']);
                    $thread['href'] = site_url('threads/'.$thread['id']);

                    $thread['html'] = $this->load->view('partials/thread_list', array('thread' => $thread), true);

                    $json['threads'][] = $thread;
                }

                if(count($json['threads']) < 1){
                    $json['errors']['error'] = 'No threads found';
                }

            } else {
                $json['errors']['error'] = 'No data found';
            }
        } else {

            // Request has not come from an ajax request so send elsewhere
            redirect('home/index');
            exit();
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function create_thread() {

        // include form helper and library
        $this->load->helper('form');
        $this->load->library('form_validation');

        // set up form validation rules
        $this->form_validation->set_rules('url', 'URL', 'trim');
        $this->form_validation->set_rules('thread_title', 'Title', 'trim|required|max_length[225]');
        $this->form_validation->set_rules('thread_content', 'Description', 'trim');
        $this->form_validation->set_error_delimiters('<li>', '</li>');

        if ($this->input->post() && $this->form_validation->run()) {

            if($this->input->post('email_address') == '') { // honeypot field check, if this is filled in, it shouldn't be processed (spam)

                if($this->thread_model->create_thread($this->input->post())) { // check if thread has been successfully added to the database

                    $this->session->set_flashdata('success', 'Success! Your thread has been posted.');
                } else {
                    $this->session->set_flashdata('error', 'Sorry, there was an error. Please try again.');
                }
            }
        } else {
            $this->session->set_flashdata('error', 'You done goofed.');
        }

        redirect($this->input->post('url'));
    }
}

/* End of file thread.php */
/* Location: ./application/controllers/thread.php */