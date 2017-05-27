<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MNotificationList extends CI_Model{

    var $table = 'notification_list';

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    
    public function listNotification($limit, $start,$userId) {
        $query = $this->db->query("SELECT u.id, n.type, u.fullname,
            p.id as post_id, 
            p.created_date as post_date,       
            p.image, n.created_date,
            n.object_id as obj, 
            u.avatar,
            u.id as anunginvite,
            n.description
            FROM user u, post p, notification_list n
            WHERE u.id = n.subject_id
            AND ((u.id <> '$userId'
            AND p.id = n.object_id
            AND p.user_id = '$userId') OR (n.object_id  = '$userId'))
            AND n.status = 1 
            GROUP BY n.id ORDER BY n.created_date DESC
            LIMIT 0,30
            ");
        return   $query->result(); 
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function delete($userId,$postId){

        $this->db->where(array('subject_id' => $userId,'object_id' => $postId));
        $this->db->delete($this->table);
    }

    


    

}