<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class Post extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url'));
    $this->load->model('mpost');
    $this->load->model('muser');
    $this->load->model('mwidget');
  }

  public function index()
  {
    $data = array(
      'appName'=> 'IOfficial',
      'pageTitle'=> 'API Post (News)',
      'credit'=> 'Wefay Studio',
      'documentation'=> 'https://documenter.getpostman.com/collection/view/1629295-88ee1558-b420-79f9-ebc7-aa9c908a3d4d#8e63b526-955d-4cdc-f99b-1302758180db',
      );

    $this->load->view('index', $data);
  }

  
  public function listPost()
  {
    $start =$_POST['start'];
    $limit =$_POST['limit'];
    $userId =$_POST['userId'];

    $data = $this->mpost->listPost($limit,$start,$userId);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 

  public function listMyPost()
  {
    $start =$_POST['start'];
    $limit =$_POST['limit'];
    $userId =$_POST['user_id'];

    $data = $this->mpost->listMyPost($limit,$start,$userId);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 



  public function userLikeList()
  {
    $start =$_POST['start'];
    $limit =$_POST['limit'];

    $data = $this->muser->listUsers($limit,$start);
    $output = array(
      "feed" => $data,
      );
    echo json_encode($output);
  } 

  public function save()
  {
    $data['id'] = $this->mpost->getId();
    foreach ($data['id'] as $key) {
      $idBaru = $key->postId + 1;
    }

    date_default_timezone_set('Asia/Jakarta');
    $newsDate=date("Y-m-d H:i:s");
    $data = array(
      'id' => $idBaru,
      'created_date' => $newsDate,
      'user_id' => $this->input->post('user_id'),
      'description' => $this->mwidget->filter($this->input->post('description')),
      'like_count' => 0,
      'comment_count' => 0,
      'status' => 0,
      );

    $insert = $this->mpost->save($data);
    $response["success"] = 1;
    $response["idBaru"] = $idBaru;
    $response["message"] = "Success.";
    echo json_encode($response);
  }




  public function like($like)
  {
   $response["status"] = 1;
   echo json_encode($response);
 }


 public function upload(){
  $idBaru = $_POST['id_baru'];
  $target_path_folder = "./images/post/big/";
  echo $fileName = $idBaru .time() . basename( $_FILES['club_image']['name']);
  $imageName = $this->mpost->getImageName($idBaru);
  if($imageName != ""){
   $data = array(
    'image' => $imageName.",".$fileName,
    );
   $this->mpost->update(array('id' => $idBaru), $data);
 }else{
  $data = array(
    'image' => $fileName,
    );
  $this->mpost->update(array('id' => $idBaru), $data);
}

$target_path = $target_path_folder .$fileName;

if(move_uploaded_file($_FILES['club_image']['tmp_name'], $target_path)) {
  $response["success"] = 1;
  $response["message"] = "Success.";

} else{
  $response["success"] = 0;
  $response["message"] = "Upload failed";
}

echo json_encode($response);

}



}