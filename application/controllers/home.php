<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->load->model('thread_model');
    }

    public function index()
    {
        if ($this->input->post()) {
            $data['threads'] = $this->thread_model->get_threads($this->input->post('latitude'), $this->input->post('longitude'), $this->input->post('radius'));
        } else {
            $data['threads'] = $this->thread_model->get_threads();
        }

        $this->load->view('home', $data);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */