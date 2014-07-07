<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    public function index()
    {
        $this->load->model('Thread');


        $data['threads'] = $this->Thread->get_threads();

        $this->load->view('home', $data);
    }
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */