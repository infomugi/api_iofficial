<?php
class mmail extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	function sendMail($page,$to,$title,$data,$url,$button) {
		$ci = get_instance();
		$ci->load->library('email');
		$config['protocol'] = "smtp";
			$config['smtp_host'] = "srv24.niagahoster.com";
			$config['smtp_port'] = "465";
			$config['smtp_user'] = "sawarga@wefay.com";
			$config['smtp_pass'] = "cFPNQ24[{&e_";

		//$config['smtp_host'] = "ssl://smtp.gmail.com";
		//$config['smtp_port'] = "465";
		//$config['smtp_user'] = "sawarga.wefay@gmail.com";
		//$config['smtp_pass'] = "sawargaw3f4y4622";			
		$config['charset'] = "utf-8";
		$config['mailtype'] = "html";
		$config['newline'] = "\r\n";

			//Content
		$datas['title'] = $title;
		$datas['content'] = $data;
		$datas['url'] = $url;
		$datas['button'] = $button;

		$ci->email->initialize($config);
		$ci->email->from('sawarga@wefay.com', 'SAWARGA');
		$list = array($to);
		$ci->email->to($list);
		$ci->email->subject($title);
		$this->email->message($this->load->view('notification',$datas,TRUE));
		
		if ($this->email->send()) {

			$response["success"] = 1;
			$response["message"] = "Sent.";
		} else {
			$response["success"] = 0;
			$response["message"] = "Failed.";
			
		}
	}		

}