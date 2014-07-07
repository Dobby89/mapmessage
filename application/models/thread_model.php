<?php
class thread_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function get_threads($orig_lat = null, $orig_long = null, $bounding_distance = 25, $options = array())
    {
        if ($orig_lat && $orig_long) {

            $query = $this->db->query('SELECT
            *
            ,((ACOS(SIN('.$orig_lat.' * PI() / 180) * SIN(`latitude` * PI() / 180) + COS('.$orig_lat.' * PI() / 180) * COS(`latitude` * PI() / 180) * COS(('.$orig_long.' - `longitude`) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS `distance`
            FROM `thread`
            WHERE
            (
                `latitude` BETWEEN ('.$orig_lat.' - '.$bounding_distance.') AND ('.$orig_lat.' + '.$bounding_distance.')
                AND `longitude` BETWEEN ('.$orig_long.' - '.$bounding_distance.') AND ('.$orig_long.' + '.$bounding_distance.')
            )
            ORDER BY `distance` ASC
            limit 25');

        } else {

            $query = $this->db->get('thread');

        }

        return $query->result_array();
    }
}