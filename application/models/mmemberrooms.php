<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MMemberRooms extends CI_Model{

    var $table = 'member_rooms';

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
      
   

    public function getId()
    {   
        $query = $this->db->query("SELECT max(member_rooms_id) as member_rooms_id FROM member_rooms");
        return  $query->result(); 
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

  

}