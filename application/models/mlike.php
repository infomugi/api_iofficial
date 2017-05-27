<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MLike extends CI_Model{

    var $table = 'post_like';
    function __construct(){
        parent::__construct();
        $this->load->database();
    }

    public function listLike($postid,$limit,$start) {
        $this->db->select('
            post_like.created_date as date,
            user.fullname as u_name, 
            user.avatar as u_image'
            );
        $this->db->from('post_like');
        $this->db->join('user', 'post_like.user_id = user.id');
        $this->db->where('post_like.post_id', $postid);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result(); 
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

    public function delete($id){
        $this->db->delete($this->table, array('id' => $id));      
        return $this->db->affected_rows();
    }


    public function deleteLike($userId,$postId){
     
        $this->db->where(array('user_id' => $userId,'post_id' => $postId));
        $this->db->delete($this->table);
    }

    //Menghitung Jumlah Komentar
    public function totalLike($id)
    {   
        $query = $this->db->query("SELECT count(id) as total FROM post_like where post_id=".$id);
        $data = $query->row(); 
        return $data->total;
    }        

    //Update Total ke Posting
    public function updateTotalLike($id)
    {
        $total = $this->totalLike($id);
        $this->db->set('like_count', $total);
        $this->db->where('id', $id);
        $this->db->update('post');
        return $this->db->affected_rows();
    }     

}