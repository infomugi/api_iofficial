<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class Comment extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('mcomment');
    $this->load->model('muser');
    $this->load->model('mnotificationlist');
    $this->load->model('mwidget');
  }

  public function index()
  {
    $data = array(
      'appName'=> 'IOfficial',
      'pageTitle'=> 'Comments List',
      'credit'=> 'Wefay Studio',
      'documentation'=> 'https://documenter.getpostman.com/collection/view/1629295-88ee1558-b420-79f9-ebc7-aa9c908a3d4d#8e63b526-955d-4cdc-f99b-1302758180db',
      );

    $this->load->view('index', $data);
  }

  public function listComment()
  {
    $start =$_POST['start'];
    $limit =$_POST['limit'];
    $postId =$_POST['postId'];

    $data = $this->mcomment->listComment($limit,$start,$postId);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 

  public function sendComment()
  {
    // $this->_validate_pesan();


    date_default_timezone_set('Asia/Jakarta');
    $newsDate=date("Y-m-d H:i:s");

    $comment = $this->input->post('comment');

    $data = array(
      'created_date' => $newsDate,
      'post_id' => $this->input->post('postId'),
      'user_id' => $this->input->post('userId'),
      'status' => "1",
      'comment' => $this->mwidget->filter($comment),
      );

    $dataNotif = array(
      'created_date' => $newsDate,
      'subject_id' =>$this->input->post('userId'),
      'type' => 2 ,
      'object_id' => $this->input->post('postId'),
      'status' => 1,
      'description' => " commented your post: ".$comment,
      );

    $insert = $this->mnotificationlist->save($dataNotif);
    $insert = $this->mcomment->save($data);
    $total = $this->mcomment->totalComment( $this->input->post('postId'));
    $update = $this->mcomment->updateTotalComment( $this->input->post('postId'));  


    $regId = $this->muser->getRegIdComment($this->input->post('postId'));
    $this->sendNotification($comment, $regId,2);
    echo json_encode(array("success" => "1", "pesan" => $regId));
  }

  public function sendComment1()
  {
    // $this->_validate_pesan();


    date_default_timezone_set('Asia/Jakarta');
    $newsDate=date("Y-m-d H:i:s");

    $comment = "Keren beb";

    $data = array(
      'created_date' => $newsDate,
      'post_id' => 4,
      'user_id' => 2,
      'status' => 1,
      'comment' => $comment,
      );

    
    $regId = $this->muser->getRegIdComment(4);
    $this->sendNotification($comment, $regId,"2.jpg");
    $insert = $this->mcomment->save($data);
    $total = $this->mcomment->totalComment( 2);
    $update = $this->mcomment->updateTotalComment( 2); 
    echo json_encode(array("success" => "1", "pesan" => $regId));
  }


  public function sendNotification($message, $regId, $chatRoomId) {

        // optional payload
    $payload = array();
    $payload['team'] = 'India';
    $payload['score'] = '5.6';

        // notification title
    $title = 'Someone comment your post';

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
        // echo json_encode($result);
    return $result;
  }



}