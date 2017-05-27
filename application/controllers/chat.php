<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class Chat extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('mmessage');
    $this->load->model('muser');
    $this->load->model('mwidget');
  }

  public function index()
  {
    $data = array(
      'appName'=> 'IOfficial',
      'pageTitle'=> 'Chat List',
      'credit'=> 'Wefay Studio',
      'documentation'=> 'https://documenter.getpostman.com/collection/view/1629295-88ee1558-b420-79f9-ebc7-aa9c908a3d4d#8e63b526-955d-4cdc-f99b-1302758180db',
      );

    $this->load->view('index', $data);
  }

  public function listChat()
  {
    $start =$_POST['start'];
    $limit =$_POST['limit'];
    $chatRoomId =$_POST['chatRoomsId'];

    $data = $this->mmessage->listChat($limit,$start,$chatRoomId);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 

  public function listChatNotif()
  {
    $start ='0';
    $limit ='1';
    $chatRoomId =$_POST['chatRoomsId'];

    $data = $this->mmessage->listChat($limit,$start,$chatRoomId);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 

  private function _validate_pesan()
  {
    $data = array();
    $data['error_string'] = array();
    $data['inputerror'] = array();
    $data['status'] = TRUE;

    if($this->input->post('isiPesan') == '')
    {
      $data['inputerror'][] = 'isiPesan';
      $data['error_string'][] = 'Sialhkan isi isiPesan';
      $data['status'] = FALSE;
    }


    if($data['status'] === FALSE)
    {
      echo json_encode($data);
      exit();
    }
  }
  


  public function sendMessage()
  {
    // $this->_validate_pesan();

    $data['id'] = $this->mmessage->getId();
    foreach ($data['id'] as $key) {
      $idBaru = $key->messageId + 1;
    }
    date_default_timezone_set('Asia/Jakarta');
    $newsDate=date("Y-m-d H:i:s");

    $data = array(
      'message_id' => $idBaru,
      'created_at' => $newsDate,
      'user_id' => $this->input->post('userId'),
      'chat_room_id' => $this->input->post('chatRoomsId'),
      'file' => "",
      'status' => "1",
      'message' => $this->mwidget->filter($this->input->post('isiPesan')),
      );

    $isiPesan = $this->mwidget->filter($this->input->post('isiPesan'));
    $regId = $this->muser->getRegId($this->input->post('userId'),$this->input->post('chatRoomsId'));
    $this->sendNotification($isiPesan, $regId,$this->input->post('chatRoomsId'));
    $insert = $this->mmessage->save($data);
    echo json_encode(array("success" => "1", "pesan" => $regId));
  }

  public function sendMessage1()
  {
    // $this->_validate_pesan();

    $data['id'] = $this->mmessage->getId();
    foreach ($data['id'] as $key) {
      $idBaru = $key->messageId + 1;
    }
    date_default_timezone_set('Asia/Jakarta');
    $newsDate=date("Y-m-d H:i:s");

    $data = array(
      'message_id' => $idBaru,
      'created_at' => $newsDate,
      'user_id' => '2',
      'chat_room_id' => '2',
      'file' => "",
      'status' => "1",
      'message' => 'Eta Logistik Tea',
      );

    $chatRoomId = '2';

    $isiPesan = 'Eta Logistik Tea';
    $regId = $this->muser->getRegId('2','1');
    $this->sendNotification($isiPesan, 'c3BPi6QLWPg:APA91bHNjU6t5voqbKvNVQKQ95ZXEit427cboVTP8koAHfcWsgqY__MY3AJKtzEBipDkaK1g87bgnmQrwIFr0ubub1z5rVnt-MYGrRX3sPssbRBZ2ye96qRi5lZvsVNurHKD8GMkg2N7',$chatRoomId);
    $insert = $this->mmessage->save($data);
    echo json_encode(array("status" => "sukses", "idBaru" => $regId));
  }

  public function sendNotification($message, $regId, $chatRoomId) {

        // optional payload
    $payload = array();
    $payload['team'] = 'India';
    $payload['score'] = '5.6';

        // notification title
    $title = 'Inbox';

        // notification message
    $message = $message;


    $json = '';
    $response = '';
    $res = array();
    $res['data']['title'] = $title;
    $res['data']['is_background'] =FALSE;
    $res['data']['message'] = $message;
    $res['data']['image'] ='';
    $res['data']['payload'] = $payload;
    $res['data']['timestamp'] = date('Y-m-d G:i:s');
    $res['data']['chat_room_id'] = $chatRoomId;

        // if ($this_type == 'topic') {
        //     $json = $this->getPush();
        //     $response = $firebase->sendToTopic('global', $json);
        // } else if ($this_type == 'individual') {
    $json = $res;
    $this->send($regId,$json);
        // }
  }

  public function kirimNotif(){
    $this->sendNotification('isinya', 'AAAAlV2XBtM:APA91bGBXnXXGYhLm7ss2A_Ysr2RUwDqAtrOBdIe5SChL8oE2gXI71DUP-zDSIP5m188JMfQm0cBH35JU_8slR2_V_jym0uD0orwtMKJAOFXBBnuCtShGD9nT0u8HkdD2rAnNKq8qETu');
  }

  public function send($to, $message) {
    $fields = array(
      'to' => $to,
      'data' => $message,
      );
    return $this->sendPushNotification($fields);
  }

  public function sendPushNotification($fields) {

        // Set POST variables
    $url = 'https://fcm.googleapis.com/fcm/send';

    $headers = array(
      'Authorization: key=' . 'AAAAlV2XBtM:APA91bGBXnXXGYhLm7ss2A_Ysr2RUwDqAtrOBdIe5SChL8oE2gXI71DUP-zDSIP5m188JMfQm0cBH35JU_8slR2_V_jym0uD0orwtMKJAOFXBBnuCtShGD9nT0u8HkdD2rAnNKq8qETu',
      'Content-Type: application/json'
      );
        // Open connection
    $ch = curl_init();

        // Set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
    $result = curl_exec($ch);
    if ($result === FALSE) {
      die('Curl failed: ' . curl_error($ch));
    }

        // Close connection
    curl_close($ch);
    echo json_encode($result);
    return $result;
  }

}