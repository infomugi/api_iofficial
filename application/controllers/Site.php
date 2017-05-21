<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

// User Controller
// Created by    : Mugi Rachmat 
// Site          : www.infomugi.com
// Date          : 2017-05-21 01:20:34

class Site extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
}

public function index()
{
    $data = array(
        'pageTitle'=> 'IOfficial API Documentation',
        'credit'=> 'Wefay Studio',
        );
    
    $this->load->view('index', $data);
}


}

