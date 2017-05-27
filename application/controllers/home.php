<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class Home extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

   public function index() 
   {   
      // $data['content'] = 'home';
      // $this->load->view('home');
    echo 'home';

   }

 

}