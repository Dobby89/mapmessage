<?php
class Thread extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function get_threads()
    {
        $query = $this->db->get('thread');

        return $query->result_array();
    }
}