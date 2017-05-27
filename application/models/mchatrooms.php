<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MChatRooms extends CI_Model{

    var $table = 'chat_rooms';

    function __construct(){
        parent::__construct();
        $this->load->database();
    }
      
    public function listChatRooms($limit, $start,$userId) {
        
        $query = $this->db->query("SELECT m.*, cr.*,u.*, (SELECT COUNT(mm.message_id) from messages mm
                                    WHERE mm.status ='0' AND mm.chat_room_id = m.chat_room_id AND mm.user_id = '0'
                                   ) unreadCount,
                                    m.created_at AS m_created_at, m.status AS m_status,
                                    u.avatar AS u_image, cr.name as title,
                                    (SELECT u1.fullname 
                                        FROM user u1, chat_rooms cr1, member_rooms mr1 
                                        WHERE mr1.user_id <> '$userId'
                                            AND mr1.user_id = u1.id 
                                            AND cr1.chat_room_id = mr1.chat_room_id 
                                            AND cr1.chat_room_id = cr.chat_room_id) as name,
                                    (SELECT u1.avatar 
                                        FROM user u1, chat_rooms cr1, member_rooms mr1 
                                        WHERE mr1.user_id <> '$userId'
                                            AND mr1.user_id = u1.id 
                                            AND cr1.chat_room_id = mr1.chat_room_id 
                                            AND cr1.chat_room_id = cr.chat_room_id) as u_image

                                    from messages m, chat_rooms cr, user u 

                                    WHERE u.id = m.user_id 
                                    AND m.chat_room_id = cr.chat_room_id 
                                    AND cr.chat_room_id IN (SELECT chat_room_id FROM member_rooms WHERE user_id = '$userId' ) 
                                    AND m.message_id IN (SELECT max(message_id) AS message_id FROM messages GROUP BY chat_room_id )
                                   
                                    ORDER BY m.created_at 
                                    DESC LIMIT ".$start.",".$limit."");
        return   $query->result(); 
   }

    public function checkChatRoomCount($userId1,$userId2)
    {   
        $query = $this->db->query("SELECT COUNT(*) as jml FROM chat_rooms cr 
                                    WHERE type = 1 
                                    AND chat_room_id 
                                    IN (SELECT chat_room_id FROM member_rooms 
                                            WHERE user_id 
                                            IN ($userId1,$userId2) 
                                            GROUP BY chat_room_id 
                                            HAVING COUNT(chat_room_id) = 2 
                                        )");
        $tes = $query->row(); 
        $r = $tes->jml;
        return $r; 
    }

     public function getIdChatRoom($userId1,$userId2)
    {   
        $query = $this->db->query("SELECT chat_room_id FROM chat_rooms cr 
                                    WHERE type = 1 
                                    AND chat_room_id 
                                    IN (SELECT chat_room_id FROM member_rooms 
                                            WHERE user_id 
                                            IN ($userId1,$userId2) 
                                            GROUP BY chat_room_id 
                                            HAVING COUNT(chat_room_id) = 2 
                                        )");
        $tes = $query->row(); 
        $r = $tes->chat_room_id;
        return $r; 
    }

    public function getId()
    {   
        $query = $this->db->query("SELECT max(chat_room_id) as chat_room_id FROM chat_rooms");
        return  $query->result(); 
    }

    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

  

}