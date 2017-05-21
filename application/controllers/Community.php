<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

// Community Controller
// Created by    : Mugi Rachmat 
// Site          : www.infomugi.com
// Date          : 2017-05-21 01:55:40

class Community extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('Site_model');
		$this->load->model('Community_model');
		date_default_timezone_set('Asia/Jakarta');
	}

	

	
    /* ---------------------------------------------------------------- 
    Nama 	: Index Setting
    Fungsi 	: Menampilkan Semua data pada tabel Community
    ---------------------------------------------------------------- */
    public function index()
    {
    	$community = $this->Community_model->get_all();
    	$total = $this->Community_model->get_total_rows();

    	$response = array(
    		'status' => 'success',
    		'message' => 'Data retrieved successfully.', 
    		'pageTitle' => 'Index Setting',
    		'total_result' => $total,
    		'data' => $community,
    		);

    	echo $this->Site_model->json($response);
    }

    

    
    /* ---------------------------------------------------------------- 
    Nama 	: List Limit Setting
    Fungsi 	: Menampilkan Semua data dengan Limit pada tabel Community
    Request 	: // start : (Inisasi Mulai Menampilkan Data Community) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Community)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function listCommunity()
    {
    	$start = $this->input->post('start');
    	$limit = $this->input->post('limit');
    	$community = $this->Community_model->get_limit_data($limit,$start);
    	$total = $this->Community_model->get_total_rows();

    	$response = array(
    		'status' => 'success',
    		'message' => 'Data retrieved successfully.', 
    		'pageTitle' => 'List Setting',
    		'total_result' => $total,
    		'data' => $community,
    		);

    	echo $this->Site_model->json($response);

    }

    

    
    /* ---------------------------------------------------------------- 
    Nama 	: Detail Setting  
    Fungsi 	: Menampilkan detail data pada tabel Community]
    Request 	: // id_site : (Adalah Primary Key dari Tabel Community) 
    Method 	: POST    
    ---------------------------------------------------------------- */
    public function view() 
    {
    	$id = $this->input->post('id_community');
    	$row = $this->Community_model->get_by_id($id);
    	if ($row) {

    		$data = array(
    			'id_site' => $row->id_site,
    			'name' => $row->name,
    			'description' => $row->description,
    			'keywords' => $row->keywords,
    			'favicon' => $row->favicon,
    			'logo' => $row->logo,
    			'address' => $row->address,
    			'phone' => $row->phone,
    			'email' => $row->email,
    			'facebook' => $row->facebook,
    			'instagram' => $row->instagram,
    			'twitter' => $row->twitter,
    			'status' => $row->status,
    			);

    		$response = array(
    			'status' => 'success',
    			'message' => 'Data retrieved successfully.',   
    			'pageTitle' => 'Detail Setting',       
    			'data' => $data,
    			);

    		echo $this->Site_model->json($response);            

    	} else {

    		$response['status'] = 'failed';
    		$response['message'] = 'Data not Found.';
    		echo $this->Site_model->json($response);            
    	}
    }
    

    
    /* ---------------------------------------------------------------- 
    Nama 	: Pencarian Setting 
    Fungsi 	: Mencari data pada tabel Community
    Request 	: // start : (Inisasi Mulai Menampilkan Data Community) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Community)
    	 	 	  // keyword : (Merupakan Kata Kunci dalam Pencarian Data Community)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function search() 
    {
    	$start = $this->input->post('start');
    	$limit = $this->input->post('limit');
    	$keyword = $this->input->post('keyword');

    	$row = $this->Community_model->get_search($limit, $start, $keyword);
    	if ($row) {
    		$total = $this->Community_model->get_total_rows($keyword);
    		$response = array(
    			'status' => 'success',
    			'message' => 'Data retrieved successfully.',          
    			'pageTitle' => 'Search Setting',
    			'total_result' => $total,
    			'data' => $row,
    			);

    	} else {

    		$response['status'] = 'failed';
    		$response['message'] = 'Data '.$keyword.' not Found.';
    	}
    	echo $this->Site_model->json($response);            
    }    
    

    
    /* ---------------------------------------------------------------- 
    Nama 	: Simpan Setting 
    Fungsi 	: Menambahkan data pada tabel Community  
    Request 	: 
				 // Name
				 // Description
				 // Keywords
				 // Favicon
				 // Logo
				 // Address
				 // Phone
				 // Email
				 // Facebook
				 // Instagram
				 // Twitter
				 // Status
    // Method 	: POST 
    ---------------------------------------------------------------- */

    public function save() 
    {
    	$data = array(
    		'name' => $this->input->post('name'),
    		'description' => $this->input->post('description'),
    		'keywords' => $this->input->post('keywords'),
    		'favicon' => $this->input->post('favicon'),
    		'logo' => $this->input->post('logo'),
    		'address' => $this->input->post('address'),
    		'phone' => $this->input->post('phone'),
    		'email' => $this->input->post('email'),
    		'facebook' => $this->input->post('facebook'),
    		'instagram' => $this->input->post('instagram'),
    		'twitter' => $this->input->post('twitter'),
    		'status' => $this->input->post('status'),
    		);


    	if($data){
    		$insert = $this->Community_model->insert($data);
    		$response = array(
    			'status' => 'success',
    			'message' => 'Data saved successfully.',          
    			'pageTitle' => 'Add Setting',
    			);

    	}else{

    		$response['status'] = 'failed';
    		$response['message'] = 'Data failed to save.';

    	}
    	echo $this->Site_model->json($response);  
    }
    

    
    /* ---------------------------------------------------------------- 
    Nama 	: Edit Setting 
    Fungsi 	: Memperbaharui data pada tabel Community
    Request 	: // id_site : (Adalah Primary Key dari Tabel Community) 
    Method 	: POST   
    ---------------------------------------------------------------- */
    public function edit() 
    {
    	$id = $this->input->post('id_community');
    	$row = $this->Community_model->get_by_id($id);

    	if ($row) {

    		$data = array(
    			'name' => $this->input->post('name'),
    			'description' => $this->input->post('description'),
    			'keywords' => $this->input->post('keywords'),
    			'favicon' => $this->input->post('favicon'),
    			'logo' => $this->input->post('logo'),
    			'address' => $this->input->post('address'),
    			'phone' => $this->input->post('phone'),
    			'email' => $this->input->post('email'),
    			'facebook' => $this->input->post('facebook'),
    			'instagram' => $this->input->post('instagram'),
    			'twitter' => $this->input->post('twitter'),
    			'status' => $this->input->post('status'),
    			);


    		if($data){

    			$update = $this->Community_model->update($id, $data);
    			$response = array(
    				'status' => 'success',
    				'message' => 'Data saved successfully.',          
    				'pageTitle' => 'Update Setting',
    				);

    		}else{

    			$response['status'] = 'failed';
    			$response['message'] = 'Data failed to save.';

    		}

    	} else {

    		$response['status'] = 'failed';
    		$response['message'] = 'Data not found.';
    	}
    	echo $this->Site_model->json($response);  
    }

    

    
    /* ---------------------------------------------------------------- 
    Nama 	: Upload Setting 
    Fungsi 	: Mengunggah file ke direktori dan disimpan di tabel Community
    Method 	: POST   
    ---------------------------------------------------------------- */
    public function upload() 
    {
    	$idBaru = $_POST['id_baru'];
    	$target_path_folder = './images/community/big/';
    	echo $fileName = $idBaru.time().basename($_FILES['club_image']['name']);
    	$imageName = $this->Community_model->getImageName($idBaru);

    	if($imageName != ''){
    		$data = array(
    			'image' => $imageName.','.$fileName,
    			);
    		$this->Community_model->update(array('id' => $idBaru), $data);

    	}else{
    		$data = array(
    			'image' => $fileName,
    			);
    		$this->Community_model->update(array('id' => $idBaru), $data);

    	}
    	$target_path = $target_path_folder .$fileName;

    	if(move_uploaded_file($_FILES['club_image']['tmp_name'], $target_path)) {

    		$response['status'] = 'success';
    		$response['message'] = 'Upload successfully.';

    	} else{

    		$response['status'] = 'failed';
    		$response['message'] = 'Upload failed.';
    	}

    	echo $this->Site_model->json($response);
    }



    
/* ---------------------------------------------------------------- 
Nama 	: Hapus Setting 
Fungsi 	: Menghapus data pada tabel Community
Request 	: // id_site : (Adalah Primary Key dari Tabel Community) 
Method 	: POST      
---------------------------------------------------------------- */ 
public function delete() 
{
	$id = $this->input->post('id_community');
	$row = $this->Community_model->get_by_id($id);

	if ($row) {
		$this->Community_model->delete($id);
		$response = array(
			'status' => 'success',
			'message' => 'Data delete successfully.',          
			'pageTitle' => 'Delete Setting',
			);

	} else {
		$response['status'] = 'failed';
		$response['message'] = 'Data not found.';
	}

	echo $this->Site_model->json($response);            
}


public function signup() 
{

  $name = $this->input->post('name');
  $row = $this->Community_model->get_name($name);
  if ($row){

    $response['status'] = 'failed';
    $response['message'] = 'Sorry, the community name is already registered.';
    $response['pageTitle'] = 'Register Community';
    echo $this->Site_model->json($response); 

}else{

    $data = array(
        'name' => $this->input->post('name'),
        'description' => "",
        'keywords' => "",
        'favicon' => "",
        'logo' => "",
        'address' => $this->input->post('address'),
        'phone' => $this->input->post('phone'),
        'email' => $this->input->post('email'),
        'facebook' => "",
        'instagram' => "",
        'twitter' => "",
        'status' => 1,
        );


    if($data){

      $insert = $this->Community_model->insert($data);

      $response = array(
        'status' => 'success',
        'message' => 'Data saved successfully.',          
        'pageTitle' => 'Register Community',
        );
      echo $this->Site_model->json($response); 

  }else{

      $response['status'] = 'failed';
      $response['message'] = 'Data failed to save.';
      $response['pageTitle'] = 'Register Community';

  }
  echo $this->Site_model->json($response);  
}


}


}

