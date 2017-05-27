<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MPost extends CI_Model{

    var $table = 'post';

    function __construct(){
        parent::__construct();
        $this->load->database();
    }



    public function listPost($limit, $start, $userId) {
        $query = $this->db->query("SELECT t.*, u.fullname as u_name, u.avatar as u_image 
            FROM post t, user u 
            WHERE u.id = t.user_id  ORDER BY t.created_date DESC
            LIMIT $start,$limit");
        return   $query->result(); 
    }

    public function listMyPost($limit, $start,$userId) {

        $query = $this->db->query("SELECT t.*, u.fullname as u_name, u.avatar as u_image 
            FROM post t, user u 
            WHERE u.id = t.user_id AND u.id = '$userId' ORDER BY t.created_date DESC
            LIMIT $start,$limit");
        return   $query->result(); 
    }

    function getId()
    {   
        $query = $this->db->query("SELECT max(id) as postId FROM post");
        return   $query->result(); 
    }

    function getImageName($id)
    {   
        $query = $this->db->query("SELECT image FROM post where id =".$id);
        $tes = $query->row(); 
        $r = $tes->image;
        return $r; 
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }




}