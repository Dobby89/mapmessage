<?php
class thread_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function get_a_thread($id) {

        $query = $this->db->get_where('thread', array('id' => $id));

        return $query->row_array();
    }

    function get_threads($orig_lat = null, $orig_long = null, $bounding_distance = 25, $options = array())
    {
        if ($orig_lat && $orig_long) {

            $query = $this->db->query('SELECT *,
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( '.$orig_lat.' ) ) + COS( RADIANS( `latitude` ) )
            * COS( RADIANS( '.$orig_lat.' )) * COS( RADIANS( `longitude` ) - RADIANS( '.$orig_long.' )) ) * 6380 AS `distance`
            FROM `thread`
            WHERE
            ACOS( SIN( RADIANS( `latitude` ) ) * SIN( RADIANS( '.$orig_lat.' ) ) + COS( RADIANS( `latitude` ) )
            * COS( RADIANS( '.$orig_lat.' )) * COS( RADIANS( `longitude` ) - RADIANS( '.$orig_long.' )) ) * 6380 < '.$bounding_distance.'
            ORDER BY `distance`');

        } else {

            $query = $this->db->get('thread');

        }

        return $query->result_array();
    }

    public function create_thread($data){

        // remove items from post array
        unset($data['email_address']);
        unset($data['url']);
        unset($data['submit']);

        // remove form field prefix from all form fields
        $clean_data = array();
        foreach($data as $key => $value){
            $clean_data[str_replace('thread_', '', $key)] = $value;
        }

        $this->load->helper('date');
        $clean_data['date'] = date('Y-m-d H:i:s', now());

        if ($this->db->insert('thread', $clean_data)) {
            return true;
        } else {
            return false;
        }
    }
}