<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thread extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('thread_model');
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
}

/* End of file thread.php */
/* Location: ./application/controllers/thread.php */