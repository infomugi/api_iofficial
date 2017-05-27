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
    $data = array(
      'appName'=> 'IOfficial',
      'pageTitle'=> 'Event List',
      'credit'=> 'Wefay Studio',
      'documentation'=> 'https://documenter.getpostman.com/collection/view/1629295-88ee1558-b420-79f9-ebc7-aa9c908a3d4d#8e63b526-955d-4cdc-f99b-1302758180db',
      );

    $this->load->view('index', $data);
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