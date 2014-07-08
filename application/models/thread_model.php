<?php
class thread_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
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
}