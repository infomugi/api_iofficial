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
		$data = array(
			'appName'=> 'IOfficial',
			'pageTitle'=> 'Activity List',
			'credit'=> 'Wefay Studio',
			'documentation'=> 'https://documenter.getpostman.com/collection/view/1629295-88ee1558-b420-79f9-ebc7-aa9c908a3d4d#8e63b526-955d-4cdc-f99b-1302758180db',
			);

		$this->load->view('index', $data);
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