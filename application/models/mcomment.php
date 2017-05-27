<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MComment extends CI_Model{

    var $table = 'post_comment';

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
      


    public function listComment($limit, $start,$postId) {
        
        $query = $this->db->query("SELECT c.*,u.avatar,u.fullname FROM post_comment c, user u, post p WHERE  c.user_id = u.id AND p.id = '$postId' AND c.post_id = p.id  order by created_date desc ");
        return   $query->result(); 
   }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }


 public function totalComment($id)
    {   
        $query = $this->db->query("SELECT count(id) as total FROM post_comment where post_id=".$id);
        $data = $query->row(); 
        return $data->total;
    }        

    //Update Total ke Posting
    public function updateTotalComment($id)
    {
        $total = $this->totalComment($id);
        $this->db->set('comment_count', $total);
        $this->db->where('id', $id);
        $this->db->update('post');
        return $this->db->affected_rows();
    }  

  

}