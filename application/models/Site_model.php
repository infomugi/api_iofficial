<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site_model extends CI_Model {

	public function name(){
		return "I Official Management";
	}

	public function json($data){
		header('Content-Type: application/json');
		return json_encode($data);
	}
}

