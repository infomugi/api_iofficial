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
			'appName'=> 'IOfficial',
			'pageTitle'=> 'API Documentation',
			'credit'=> 'Wefay Studio',
			'documentation'=> 'https://documenter.getpostman.com/collection/view/1629295-88ee1558-b420-79f9-ebc7-aa9c908a3d4d#8e63b526-955d-4cdc-f99b-1302758180db',
			);

		$this->load->view('index', $data);
	}


}

