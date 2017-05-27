<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MActivity extends CI_Model{

    var $table = 'activity';
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function myactivity($user_id,$limit,$start) {
        $this->db->select('
            created_date as date,
            description as description'
            );
        $this->db->from('activity');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result(); 
    }    

    // public function myactivity($user_id,$limit,$start) {
    //     $this->db->select('
    //         activity.created_date as date,
    //         activity.description as description, 
    //         user.fullname as u_name, 
    //         user.avatar as u_image'
    //         );
    //     $this->db->from('activity');
    //     $this->db->join('user', 'activity.user_id = user.id');
    //     $this->db->where('activity.user_id', $user_id);
    //     $this->db->limit($limit, $start);
    //     $query = $this->db->get();
    //     return $query->result(); 
    // }

    public function save($userid,$description,$type,$status)
    {
        date_default_timezone_set('Asia/Jakarta');
        $newsDate=date("Y-m-d H:i:s");
        $data = array(
            'created_date' => $newsDate,
            'user_id' => $userid,
            'user_id' => $userid,
            'description' => $description,
            'type' => $type,
            'status' => $status,
            );

        return $this->db->insert($this->table, $data);
    }     

    //Mencari Nama Orang yang Di Pasif
    public function findUser($id)
    {   
        $query = $this->db->query("SELECT fullname FROM user where id=".$id);
        $data = $query->row(); 
        return $data->fullname;
    }  

    //Mencari Nama Orang yang Di Pasif
    public function findPost($id)
    {   
        $query = $this->db->query("SELECT description FROM post where id=".$id);
        $data = $query->row(); 
        return $data->description;
    }          

}