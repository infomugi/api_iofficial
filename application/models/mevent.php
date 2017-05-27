<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MEvent extends CI_Model{

    var $table = 'event';

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function listEvent($limit, $start) {
        $query = $this->db->query("SELECT e.*, u.fullname as u_name, u.avatar as u_image, (select count(id) from event) as event_count 
            FROM event e, user u 
            WHERE u.id = e.user_id ORDER BY e.created_date DESC
            LIMIT 0,3 ");
        return   $query->result(); 
    }


    

}