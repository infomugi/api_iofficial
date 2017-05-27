<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class NotificationList extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('mnotificationlist');
        $this->load->model('muser');
    }

  public function index() 
  {   
      // $data['content'] = 'home';
      $this->load->view('home');

  }

  public function listNotification()
  {
      $userId =$_POST['userId'];
      $start =$_POST['start'];
      $limit =$_POST['limit'];
      // $limit =$_POST['post_id'];
      // $limit =$_POST['type'];

      $data = $this->mnotificationlist->listNotification($limit,$start,$userId);
      $output = array(
              "feed" => $data,
          );
      echo json_encode($output);
  } 

}