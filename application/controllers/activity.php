<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Activity extends CI_Controller {

	// Informasi Type
	// 1 = Posting
	// 2 = Komentar
	// 3 = Like

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('mpost');
		$this->load->model('muser');
		$this->load->model('mwidget');
		$this->load->model('mcomment');
		$this->load->model('mactivity');
	}


	public function index() 
	{   
		$this->load->view('home');
	}

	public function listMy()
	{
		$user_id =  5;
		$limit =  $this->input->post('limit');
		$start =  $this->input->post('start');

		$data = $this->mactivity->myactivity($user_id);
		$output = array(
			"feed" => $data,
			);

		echo $this->mwidget->json($output);
	} 



}