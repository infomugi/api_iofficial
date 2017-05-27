<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('muser'); 
    $this->load->model('mmail'); 
    $this->load->model('mnotificationlist'); 
  }

  public function index()
  {
    $data = array(
      'appName'=> 'IOfficial',
      'pageTitle'=> 'Account List',
      'credit'=> 'Wefay Studio',
      'documentation'=> 'https://documenter.getpostman.com/collection/view/1629295-88ee1558-b420-79f9-ebc7-aa9c908a3d4d#8e63b526-955d-4cdc-f99b-1302758180db',
      );

    $this->load->view('index', $data);
  }

  public function listUsers()
  {
    $start =$_POST['start'];
    $limit =$_POST['limit'];

    $data = $this->muser->listUsers($limit,$start);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 


  public function contactList()
  {
    $start =$_POST['start'];
    $limit =1000;
    $userId =$_POST['userId'];

    $data = $this->muser->contactList($limit,$start,$userId);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 

  public function login()
  { 

    $response = array();

    $username = $_POST['username'];
    $password =$_POST['password'];
    $query = $this->db->query(
      "SELECT * FROM user 
      WHERE username = '$username' and password = md5('$password') "
      );

    if($query->num_rows() > 0)
    {
      $row = $query->row();
      $response["success"] = 1;
      $response["message"] = "Ada";
      $response["username"] = $row->username;
      $response["password"] = $row->password;
      $response["fullname"] = $row->fullname;
      $response["avatar"] = $row->avatar;
      $response["cover"] = $row->cover;
      $response["id"] = $row->id;
      $response["email"] = $row->email;
      $response["status"] = $row->status;
      $regId = $this->input->post('regId');
      $data = array(
        'gcm_registration_id' =>  $regId,
        );
      $this->muser->update(array('id' => $row->id), $data);
    }else{
      $response["success"] = 0;
      $response["message"] = "Sorry, your account has not been registered.";
    }

    echo json_encode($response);

  }


  public function checkEmail()
  { 

    $response = array();

    $email = $_POST['email'];
    $query = $this->db->query(
      "SELECT * FROM user 
      WHERE email = '$email'"
      );

    if($query->num_rows() > 0)
    {
      $row = $query->row();
      $response["success"] = 0;
      $response["message"] = "Sorry, this email is taken by another account.";
    }else{
     $response["success"] = 1;
     $response["message"] = "Ada";
   }

   echo json_encode($response);

 }


 public function sendEmail($idBaru,$kodev,$name,$email)
 {
   $config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'ssl://smtp.gmail.com',
    'smtp_port' => 465,
          'smtp_user' => 'sawarga.wefay@gmail.com', // change it to yours
          'smtp_pass' => 'sawargaw3f4y4622', // change it to yours
          'mailtype' => 'html',
          'charset'   => 'iso-8859-1',
          'wordwrap' => TRUE
          );


   $this->load->library('email', $config);
   $data['nama'] = $name;
   $data['kode'] = $kodev;
   $this->email->initialize($config);
   $this->email->set_newline("\r\n");
   $this->email->from('sawarga');
   $this->email->to('3108.firmanmaulana@gmail.com');
   $this->email->subject("Account verification");
   $this->load->helper('url');
   $this->email->message($this->load->view('email',$data,TRUE));
   if($this->email->send())
   {
          // echo 'Email send.';
   }
   else
   {
         // show_error($this->email->print_debugger());
    $response["success"] = 3;
    $response["message"] = "Sorry, the email can not be used.";
    exit();
  }

}


public function send_email() 
{
  $email="3108.firmanmaulana@gmail.com";
  $subject="Baru nih";
  $message= "";
  $name= "Firman Maulana";
  $this->sendEmail(1,'12312387ujwwefwe',$name,$email);
}



function rand_string($length ) {
  error_reporting(0);
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";  
  $size = strlen( $chars );
  for( $i = 0; $i < $length; $i++ ) {
    $satr .= $chars[ rand( 0, $size - 1 ) ];
  }
  return $satr;
}


public function register()
{
  $username =$_POST['username'];
  $query = $this->db->query("select id FROM user WHERE username = '$username'");
  if($query->num_rows() > 0)
  {
    $response["success"] = 3;
    $response["message"] = "Sorry, the username is already used by another account.";
  }else{
    $data['id'] = $this->muser->getId();
    foreach ($data['id'] as $key) {
      $idBaru = $key->userId + 1;
    }
    $kodev = $this->rand_string(10);

            // $config['protocol'] = "smtp";
            // $config['smtp_host'] = "srv24.niagahoster.com";
            // $config['smtp_port'] = "465";
            // $config['smtp_user'] = "sawarga@wefay.com";
            // $config['smtp_pass'] = "cFPNQ24[{&e_";
            // $config['charset'] = "utf-8";
            // $config['mailtype'] = "html";
            // $config['newline'] = "\r\n";

            //   $this->load->library('email', $config);
            //   $data['nama'] = $_POST['name'];
            //   $data['kode'] = $kodev.$idBaru;
            //   $this->email->initialize($config);
            //   $this->email->set_newline("\r\n");
            //   $this->email->from('sawarga');
            //   $this->email->to($this->input->post('email'));
            //   $this->email->subject("Account confirmation");
            //   $this->load->helper('url');
            //   $this->email->message($this->load->view('email',$data,TRUE));
            //   if($this->email->send())
            //    {

            //    }
            //  else
            //   {
            //    // show_error($this->email->print_debugger());
            //     $response["success"] = 3;
            //     $response["message"] = "Sorry, the email can not be used.";
            //   }
    date_default_timezone_set('Asia/Jakarta');
    $newsDate=date("Y-m-d H:i:s");
    $data = array(
      'id' => $idBaru,
      'created_date' => $newsDate,
      'updated_date' => "",
      'last_visit' => "",
      'fullname' => $this->input->post('name'),
      'email' => $this->input->post('email'),
      'phone_number' => $this->input->post('phone_number'),
      'username' => $this->input->post('username'),
      'password' => md5($this->input->post('password')),
      'gender' => $this->input->post('gender'),
      'status' => "1",
      'birth' => $this->input->post('dob'),
      'address' => "",
      'small_family_id' => "",
      'avatar' => "",
      'cover' => "",
      'gcm_registration_id' => $this->input->post('regId'),
      'email_token' => $kodev.$idBaru,

      'status' => '0',
      );

    $insert = $this->muser->save($data);
    $response["success"] = 1;
    $response["message"] = "You have successfully created an account.";
  }

  echo json_encode($response);
}


public function updateRegId()
{
  $userId = $this->input->post('userId');
  $regId = $this->input->post('regId');
  $data = array(
    'gcm_registration_id' =>  $regId,
    );
  $this->muser->update(array('id' => $userId), $data);
  $response["success"] = 1;
  echo json_encode($response);
}

public function emailConfirmation($kode)
{
  $data = array(
    'status' =>  '1',
    );
  $this->muser->update(array('random_number' => $kode), $data);
  $response["success"] = 1;
  echo json_encode($response);
}

// public function sendEmailInvitation()
// { 
//   $response = array();

//   $email = $this->input->post('email');
//   $sdrt = $this->input->post('sdrt');
//   $userid1 = $this->input->post('userid1');
//   $userid2 = $this->input->post('userid2');

//   $query1 = $this->muser->findBypk($userid1);
//   $query2 = $this->muser->findBypk($userid2);

//   $row1 = $query1->row();
//   $row2 = $query2->row();

//   if($query2->num_rows() > 0){

//     $data = array(
//       'user_relasi_id' => $userid2,
//       'user_id' => $userid1,
//       'sdrt' => $sdrt,
//       );

//     //Send Mail
//     $this->mmail->sendMail(
//       "Invite",
//       $row2->email, 
//       "Hi ".$row2->fullname."",
//       "I'd like to invite you to Sawarga. To join me on Sawarga from your mobile device, click Confirmation button: ",
//       base_url()."index.php/user/confirmation/smallfamilyid/".$row1->small_family_id,
//       "Confirmation"
//       );     

//     $invite = $this->msdrt->save($data);

//     $response["success"] = 1;
//     $response["message"] = "Success.";

//   }else{

//     //Send Mail
//     $this->mmail->sendMail(
//       "Invite",
//       $email, 
//       "Hi ".$email."",
//       $row1->fullname." telah mengundang anda untuk bergabung di sawarga, silahkan registrasi untuk membuat akun sawarga",
//       base_url()."index.php/user/signup/smallfamilyid/".$row1->small_family_id,
//       "Registrasi"
//       );  

//     $response["success"] = 1;
//     $response["message"] = "Sent.";

//   }

//   echo json_encode($response);

// }

public function signup($smallfamilyid) 
{
  $data = array(
    'appName' => "Sawarga",
    'pageTitle' => "Register",
    );

  $data['id'] = $this->muser->getId();
  foreach ($data['id'] as $key) {
    $idBaru = $key->userId + 1;
  }
  $kodev = $this->rand_string(10);

  $config = Array(
    'protocol' => 'smtp',
    'smtp_host' => 'srv24.niagahoster.com',
    'smtp_port' => 465,
              'smtp_user' => 'sawarga@wefay.com', // change it to yours
              'smtp_pass' => 'cFPNQ24[{&e_', // change it to yours
              'mailtype' => 'html',
              'charset'   => 'iso-8859-1',
              'wordwrap' => TRUE
              );


  $this->load->library('email', $config);
  $data['nama'] = $_POST['name'];
  $data['kode'] = $kodev.$idBaru;
  $this->email->initialize($config);
  $this->email->set_newline("\r\n");
  $this->email->from('sawarga');
  $this->email->to($this->input->post('email'));
  $this->email->subject("Account Confirmation");
  $this->load->helper('url');
  $this->email->message($this->load->view('email',$data,TRUE));
  if($this->email->send())
  {
    date_default_timezone_set('Asia/Jakarta');
    $newsDate=date("Y-m-d H:i:s");
    $data = array(
      'id' => $idBaru,
      'created_date' => $newsDate,
      'updated_date' => "",
      'last_visit' => "",
      'fullname' => $this->input->post('name'),
      'email' => $this->input->post('email'),
      'phone_number' => "",
      'username' => $this->input->post('username'),
      'password' => md5($this->input->post('password')),
      'gender' => "",
      'status' => "1",
      'birth' => "",
      'address' => "",
      'small_family_id' => $smallfamilyid,
      'avatar' => "",
      'cover' => "",
      'gcm_registration_id' => "",
      'email_token' => "",
      'status' => '0',
      );

    $insert = $this->muser->save($data);
    $response["success"] = 1;
    $response["message"] = "You have successfully created an account.";
  }
  
  $this->load->view('theme/front_header', $data);
  $this->load->view('dashboard/form', $data);
  $this->load->view('theme/front_footer', $data); 

}


// NOTIF SEMENTARA
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
    //    echo json_encode($result);
  return $result;
}


}