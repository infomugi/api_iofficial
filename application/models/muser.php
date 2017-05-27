<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MUser extends CI_Model{

	var $table = 'user';
	var $column = array('id','name','username','password'); //set column field database for order and search
	var $order = array('id' => 'desc'); // default order 


    function __construct(){
        parent::__construct();
        $this->load->database();
    }
	

   function getId()
	{	
		$query = $this->db->query("SELECT max(id) as userId ,password FROM user");
		return	 $query->result(); 
	}

public function getIdRelation($userId1,$userId2)
	{	
		$query = $this->db->query("SELECT id FROM user_relasi WHERE user_id1 = '$userId1' AND user_id2 = '$userId2' ");
		$tes = $query->row(); 
		$r = $tes->id;
		return $r; 
	}

    public function listUsers($limit, $start) 
    {
    $query = $this->db->query("SELECT * from user ORDER BY name
                                LIMIT 0,10 ");
    return   $query->result(); 
   }


    public function contactList($limit, $start,$userId) 
    {
    $query = $this->db->query("SELECT * from user WHERE id <> '$userId' ORDER BY fullname
                                LIMIT $start,$limit ");
    return   $query->result(); 
   }



	public function getById($id)
	{
		$this->db->FROM($this->table);
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	public function getRegId($id,$rid)
	{	
		$query = $this->db->query("select gcm_registration_id from user where id IN (SELECT user_id from member_rooms where chat_room_id ='$rid' AND id<>'$id')");
		$tes = $query->row(); 
		$r = $tes->gcm_registration_id;
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

	public function deleteById($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}

public function getRegIdComment($postId)
	{	
		$query = $this->db->query("select gcm_registration_id from user where id IN (SELECT user_id from post where id ='$postId')");
		$tes = $query->row(); 
		$r = $tes->gcm_registration_id;
		return $r; 
	}

	public function findBypk($id){
		$this->db->where('id', $id);
		return $this->db->get($this->table);
	}	
public function findByPin($id){
		$this->db->where('email_token', $id);
		return $this->db->get($this->table);
	}	


}