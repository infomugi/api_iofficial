<?php
class mwidget extends CI_Model {

	public function __construct()
	{
		$this->load->database();
	}

	public function alert($page,$status,$message){
		$response = array();
		if($status==1){
			$response = array(
				'success'=> 1,
				'type'=> "success",
				'status'=> $page . " Telah Ditemukan",
				'message'=> $message,
				);
			return $response;

		}elseif($status==2){
			$response = array(
				'success'=> 1,
				'type'=> "info",
				'status'=> "Hasil Pencarian " . $page . " Tidak Ditemukan",
				'message'=> $message,				
				);
			return $response;

		}elseif($status==3){

			$response = array(
				'success'=> 0,
				'type'=> "warning",
				'status'=> "Form ".$page." Silahkan Dilengkapi",
				'message'=> $message,				
				);
			return $response;

		}elseif($status==4){

			$response = array(
				'success'=> 1,
				'type'=> "info",
				'status'=> "Data ".$page." Berhasil Tersimpan",
				'message'=> $message,				
				);
			return $response;

		}elseif($status==5){

			$response = array(
				'success'=> 0,
				'type'=> "info",
				'status'=> "Gagal Menyimpan Data ".$page,
				'message'=> $message,				
				);
			return $response;	

		}elseif($status==6){

			$response = array(
				'success'=> 1,
				'type'=> "info",
				'status'=> "Permintaan ".$page." Terkirim",
				'message'=> $message,				
				);
			return $response;

		}elseif($status==7){

			$response = array(
				'success'=> 0,
				'type'=> "danger",
				'status'=> "Permintaan ".$page." Gagal Terkirim",
				'message'=> $message,				
				);
			return $response;									

		}else{

			$response = array(
				'success'=> 0,
				'type'=> "danger",
				'message'=> "Tidak Diketahui",
				);
			return $response;

		}
	}

	public function json($data){
		$json = json_encode($data, JSON_PRETTY_PRINT);
		return "<pre>" . $json . "</pre>";
	}

	public function filter($text){
	$daftarkatakotor = "anjing,sialan,tolol,bego,idiot,setan,iblis,bagong,babi,sia,goblog,goblok,anjink,berengsek,jadah,bajingan,kontol,kelamin"; 
	$katasensor = "***"; 
	    $kalimat = preg_replace('/[ \t]+/', ' ', preg_replace('/\s*$^\s*/m', ' ', $text));
	    $katas = array();
	    $katas = explode(" ",$kalimat); 
	    $katakotor = explode(",",$daftarkatakotor);
	    $i = 0;
	    $kata = "";
	    for ($i=0;$i<count($katas);$i++){
	    	$kata = $katas[$i];
	    	if (in_array(strtolower(preg_replace("/[^A-Za-z0-9 ]/", '', $katas[$i])),$katakotor)){
	    		$kalimat = str_replace($kata,$katasensor,$kalimat);     
	    	}
	    }
	    return $kalimat;
	}	

}