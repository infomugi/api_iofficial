<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MMessage extends CI_Model{

    var $table = 'messages';

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
    

    public function getId()
    {   
        $query = $this->db->query("SELECT max(message_id) as messageId FROM messages");
        return  $query->result(); 
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function listChat($limit, $start,$chatRoomId) {
        $query = $this->db->query("SELECT m.*, cr.*,u.*, (SELECT COUNT(mm.message_id) from messages mm
            WHERE mm.status ='0' AND mm.chat_room_id = m.chat_room_id AND mm.user_id = '0'
            ) unreadCount,
            m.created_at AS m_created_at, m.status AS m_status,
            u.avatar AS u_image, cr.name as title from messages m, chat_rooms cr, user u 

            WHERE u.id = m.user_id 
            AND m.chat_room_id = cr.chat_room_id 
            AND cr.chat_room_id = '$chatRoomId'
            GROUP BY m.message_id
            ORDER BY m.created_at 
            DESC LIMIT $start,$limit");
        return   $query->result(); 
    }


    

}