<?php
class comment_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    function get_comments_by_thread_id($thread_id)
    {
        $query = $this->db->get_where('comment', array('thread_id' => $thread_id));

        //echo $this->db->last_query();
        return $query->result_array();
    }
}