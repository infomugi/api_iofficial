<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class Event extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('mevent');
        $this->load->model('muser');
    }

  public function index() 
  {   
      // $data['content'] = 'home';
      $this->load->view('home');

  }

  public function listEvent()
  {
      $start =$_POST['start'];
      $limit =$_POST['limit'];

      $data = $this->mevent->listEvent($limit,$start);
      $output = array(
              "feed" => $data,
          );
      echo json_encode($output);
  } 

}