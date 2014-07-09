<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Geolocation extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function save_location()
    {
        $json = array('errors' => false);

        if($this->input->is_ajax_request()){

            if($this->input->post()) {

                if($this->input->post('lat') && $this->input->post('long')){

                    $this->session->set_userdata('user_latitude', floatval($this->input->post('lat')));
                    $this->session->set_userdata('user_longitude', floatval($this->input->post('long')));
                }
            }
        }

        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function get_location()
    {
        $location = array();
        $location['latitude'] = $this->session->userdata('user_latitude');
        $location['longitude'] = $this->session->userdata('user_longitude');

        return $location;
    }
}

/* End of file geolocation.php */
/* Location: ./application/controllers/geolocation.php */