<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChatRooms extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('mchatrooms'); 
        $this->load->model('mmemberrooms'); 
    }

    public function index() 
    {   
      echo "welcome to chat room API";
    }

    public function listChatRooms()
    {
        $start = $_POST['start'];
        $limit = $_POST['limit'];
        $userId =$_POST['userId'];

        $data = $this->mchatrooms->listChatRooms( $limit, $start,$userId);
        $output = array(
                "feed" => $data,
            );
        echo json_encode($output);
    } 

    public function addChatRoom()
    {
      // $userId[] = $this->input->post('userId1');
      // $userId[] = $this->input->post('userId2');
      // $type = $this->input->post('type');
      $userId = array($this->input->post('userId1'),$this->input->post('userId2'));
      $type = 1;



      $jumlah = $this->mchatrooms->checkChatRoomCount($this->input->post('userId1'),$this->input->post('userId2'));

      if($jumlah < 1){

          $data['id'] = $this->mchatrooms->getId();
          foreach ($data['id'] as $key) {
            $idBaru = $key->chat_room_id + 1;
          }

          date_default_timezone_set('Asia/Jakarta');
          $newsDate=date("Y-m-d H:i:s");

          $data = array(
            'chat_room_id' => $idBaru,
            'name' => "",
            'type' => $type,
            'created_at' => $newsDate
          );

          $insert = $this->mchatrooms->save($data);


          for ($i=0; $i < count($userId) ; $i++) { 
             $data['idm'] = $this->mmemberrooms->getId();
              foreach ($data['idm'] as $key) {
                $idBaruM = $key->member_rooms_id + 1;
              }

               $datam = array(
                'member_rooms_id' => $idBaruM,
                'chat_room_id' => $idBaru,
                'user_id' => $userId[$i],
                'status' => 1,
                'created_at' => $newsDate
              );

              $insert = $this->mmemberrooms->save($datam);
          }

      }else{
         $idBaru = $this->mchatrooms->getIdChatRoom($this->input->post('userId1'),$this->input->post('userId2'));
      }

      echo json_encode(array("success" => "1", "pesan" => $regId, "chat_room_id" => $idBaru));
    }

  

}