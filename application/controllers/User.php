<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

// User Controller
// Created by    : Mugi Rachmat 
// Site          : www.infomugi.com
// Date          : 2017-05-21 01:20:34

class User extends CI_Controller
{
  function __construct()
  {
    parent::__construct();
    $this->load->model('Site_model');
    $this->load->model('User_model');
    $this->load->model('muser');
    date_default_timezone_set('Asia/Jakarta');
  }




    /* ---------------------------------------------------------------- 
    Nama 	: Index User
    Fungsi 	: Menampilkan Semua data pada tabel User
    ---------------------------------------------------------------- */
    public function index()
    {
      $user = $this->User_model->get_all();
      $total = $this->User_model->get_total_rows();

      $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.', 
        'pageTitle' => 'Index User',
        'total_result' => $total,
        'data' => $user,
        );

      echo $this->Site_model->json($response);
    }

    

    
    /* ---------------------------------------------------------------- 
    Nama 	: List Limit User
    Fungsi 	: Menampilkan Semua data dengan Limit pada tabel User
    Request 	: // start : (Inisasi Mulai Menampilkan Data User) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data User)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function listUser()
    {
      $start = $this->input->post('start');
      $limit = $this->input->post('limit');
      $user = $this->User_model->get_limit_data($limit,$start);
      $total = $this->User_model->get_total_rows();

      $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.', 
        'pageTitle' => 'List User',
        'total_result' => $total,
        'data' => $user,
        );

      echo $this->Site_model->json($response);

    }

    

    
    /* ---------------------------------------------------------------- 
    Nama 	: Detail User  
    Fungsi 	: Menampilkan detail data pada tabel User]
    Request 	: // id_user : (Adalah Primary Key dari Tabel User) 
    Method 	: POST    
    ---------------------------------------------------------------- */
    public function view() 
    {
      $id = $this->input->post('id_user');
      $row = $this->User_model->get_by_id($id);
      if ($row) {

        $data = array(
          'id_user' => $row->id_user,
          'create_time' => $row->create_time,
          'update_time' => $row->update_time,
          'visit_time' => $row->visit_time,
          'fullname' => $row->fullname,
          'gender' => $row->gender,
          'birth' => $row->birth,
          'email' => $row->email,
          'username' => $row->username,
          'password' => $row->password,
          'level' => $row->level,
          'division' => $row->division,
          'image' => $row->image,
          'ipaddress' => $row->ipaddress,
          'active' => $row->active,
          'status' => $row->status,
          );

        $response = array(
          'status' => 'success',
          'message' => 'Data retrieved successfully.',   
          'pageTitle' => 'Detail User',       
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
    Nama 	: Pencarian User 
    Fungsi 	: Mencari data pada tabel User
    Request 	: // start : (Inisasi Mulai Menampilkan Data User) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data User)
    	 	 	  // keyword : (Merupakan Kata Kunci dalam Pencarian Data User)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function search() 
    {
      $start = $this->input->post('start');
      $limit = $this->input->post('limit');
      $keyword = $this->input->post('keyword');

      $row = $this->User_model->get_search($limit, $start, $keyword);
      if ($row) {
        $total = $this->User_model->get_total_rows($keyword);
        $response = array(
          'status' => 'success',
          'message' => 'Data retrieved successfully.',          
          'pageTitle' => 'Search User',
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
    Nama 	: Simpan User 
    Fungsi 	: Menambahkan data pada tabel User  
    Request 	: 
				 // Create_time
				 // Update_time
				 // Visit_time
				 // Fullname
				 // Gender
				 // Birth
				 // Email
				 // Username
				 // Password
				 // Level
				 // Division
				 // Image
				 // Ipaddress
				 // Active
				 // Status
    // Method 	: POST 
    ---------------------------------------------------------------- */

    public function save() 
    {
      $data = array(
        'create_time' => $this->input->post('create_time'),
        'update_time' => $this->input->post('update_time'),
        'visit_time' => $this->input->post('visit_time'),
        'fullname' => $this->input->post('fullname'),
        'gender' => $this->input->post('gender'),
        'birth' => $this->input->post('birth'),
        'email' => $this->input->post('email'),
        'username' => $this->input->post('username'),
        'password' => $this->input->post('password'),
        'level' => $this->input->post('level'),
        'division' => $this->input->post('division'),
        'image' => $this->input->post('image'),
        'ipaddress' => $this->input->post('ipaddress'),
        'active' => $this->input->post('active'),
        'status' => $this->input->post('status'),
        );


      if($data){
        $insert = $this->User_model->insert($data);
        $response = array(
          'status' => 'success',
          'message' => 'Data saved successfully.',          
          'pageTitle' => 'Add User',
          );

      }else{

        $response['status'] = 'failed';
        $response['message'] = 'Data failed to save.';

      }
      echo $this->Site_model->json($response);  
    }
    

    
    /* ---------------------------------------------------------------- 
    Nama 	: Edit User 
    Fungsi 	: Memperbaharui data pada tabel User
    Request 	: // id_user : (Adalah Primary Key dari Tabel User) 
    Method 	: POST   
    ---------------------------------------------------------------- */
    public function edit() 
    {
      $id = $this->input->post('id_user');
      $row = $this->User_model->get_by_id($id);

      if ($row) {

        $data = array(
          'create_time' => $this->input->post('create_time'),
          'update_time' => $this->input->post('update_time'),
          'visit_time' => $this->input->post('visit_time'),
          'fullname' => $this->input->post('fullname'),
          'gender' => $this->input->post('gender'),
          'birth' => $this->input->post('birth'),
          'email' => $this->input->post('email'),
          'username' => $this->input->post('username'),
          'password' => $this->input->post('password'),
          'level' => $this->input->post('level'),
          'division' => $this->input->post('division'),
          'image' => $this->input->post('image'),
          'ipaddress' => $this->input->post('ipaddress'),
          'active' => $this->input->post('active'),
          'status' => $this->input->post('status'),
          );


        if($data){

          $update = $this->User_model->update($id, $data);
          $response = array(
            'status' => 'success',
            'message' => 'Data saved successfully.',          
            'pageTitle' => 'Update User',
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
    Nama 	: Upload User 
    Fungsi 	: Mengunggah file ke direktori dan disimpan di tabel User
    Method 	: POST   
    ---------------------------------------------------------------- */
    public function upload() 
    {
     $idBaru = $_POST['id_baru'];
     $target_path_folder = './images/user/big/';
     echo $fileName = $idBaru.time().basename($_FILES['club_image']['name']);
     $imageName = $this->User_model->getImageName($idBaru);

     if($imageName != ''){
       $data = array(
         'image' => $imageName.','.$fileName,
         );
       $this->User_model->update(array('id' => $idBaru), $data);

     }else{
      $data = array(
        'image' => $fileName,
        );
      $this->User_model->update(array('id' => $idBaru), $data);

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
Nama 	: Hapus User 
Fungsi 	: Menghapus data pada tabel User
Request 	: // id_user : (Adalah Primary Key dari Tabel User) 
Method 	: POST      
---------------------------------------------------------------- */ 
public function delete() 
{
  $id = $this->input->post('id_user');
  $row = $this->User_model->get_by_id($id);

  if ($row) {
    $this->User_model->delete($id);
    $response = array(
      'status' => 'success',
      'message' => 'Data delete successfully.',          
      'pageTitle' => 'Delete User',
      );

  } else {
    $response['status'] = 'failed';
    $response['message'] = 'Data not found.';
    $response['pageTitle'] = 'Delete User';
  }

  echo $this->Site_model->json($response);            
}


public function login()
{ 
  $response = array();
  
  $username = $this->input->post('username');
  $password = $this->input->post('password');
  $email = $this->input->post('email');

  if($username!="" || $email!="" && $password!=""){

    $query = $this->db->query(
      "SELECT * FROM user 
      WHERE username = '$username' || email = '$email' 
      and password = md5('$password') "
      );

    if($query->num_rows() > 0)
    {
      $row = $query->row();
      $data = array(
        'id_user' => $row->id_user,
        'create_time' => $row->create_time,
        'update_time' => $row->update_time,
        'visit_time' => $row->visit_time,
        'fullname' => $row->fullname,
        'gender' => $row->gender,
        'birth' => $row->birth,
        'email' => $row->email,
        'username' => $row->username,
        'password' => $row->password,
        'level' => $row->level,
        'division' => $row->division,
        'image' => $row->image,
        'ipaddress' => $row->ipaddress,
        'active' => $row->active,
        'status' => $row->status,
        );

      $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.',   
        'pageTitle' => 'Profile User',       
        'data' => $data,
        );

    }else{

      $response["status"] = "failed";
      $response["message"] = "Sorry, your account has not been registered.";
      $response["pageTitle"] = "Profile User";

    }

  }else{

    $response["status"] = "failed";
    $response["message"] = "Username & Password cannot be blank.";
    $response["pageTitle"] = "Profile User";

  }
  
  echo $this->Site_model->json($response);

}

public function checkEmail() 
{
  $email = $this->input->post('email');
  $row = $this->User_model->get_email($email);
  if ($row) {

    $response = array(
      'status' => 'success',
      'message' => 'Sorry, this email '.$row->email.' is taken by another account.',   
      'pageTitle' => 'Check Email',       
      );

  } else {

    $response['status'] = 'failed';
    $response['message'] = 'Sorry, Data not found';
    $response['pageTitle'] = 'Check Email';
  }

  echo $this->Site_model->json($response);            
}

public function signup() 
{

  $username = $this->input->post('username');
  $row = $this->User_model->get_username($username);
  if ($row) {

    $response['status'] = 'failed';
    $response['message'] = 'Sorry, the username is already used by another account.';
    $response['pageTitle'] = 'Register Member';
    echo $this->Site_model->json($response); 

  } else {

    $data = array(
      'create_time' => date("Y-m-d H:i:s"),
      'update_time' => date("Y-m-d H:i:s"),
      'visit_time' => date("Y-m-d H:i:s"),
      'fullname' => $this->input->post('fullname'),
      'gender' => "",
      'birth' => "",
      'email' => $this->input->post('email'),
      'username' => $this->input->post('username'),
      'password' => md5($this->input->post('password')),
      'level' => 3,
      'division' => "",
      'image' => "avatar.png",
      'ipaddress' => "",
      'active' => 1,
      'status' => 1,
      'community_id' => "",
      'gcm_registration_id' => $this->input->post('regId'),
      'field_one' => "",
      'field_two' => "",
      'field_three' => "",
      'field_four' => "",
      'field_five' => "",
      );


    if($data){
      $insert = $this->User_model->insert($data);
      $response = array(
        'status' => 'success',
        'message' => 'Data saved successfully.',          
        'pageTitle' => 'Register Member',
        );

    }else{

      $response['status'] = 'failed';
      $response['message'] = 'Data failed to save.';
      $response['pageTitle'] = 'Register Member';

    }
    echo $this->Site_model->json($response);  
  }


}


public function updateRegId()
{
  $userId = $this->input->post('userId');
  $regId = $this->input->post('regId');
  $data = array(
    'gcm_registration_id' =>  $regId,
    );
  $this->muser->update(array('id' => $userId), $data);
  $response["success"] = 1;
  echo json_encode($response);
}


public function forgotPassword() 
{
  $email = $this->input->post('email');
  $row = $this->User_model->get_email($email);
  if ($row) {

    $response = array(
      'status' => 'success',
      'message' => 'Hi '.$row->fullname.' We sent email to recovery your account.',   
      'pageTitle' => 'Forgot Password',       
      );

  } else {

    $response['status'] = 'failed';
    $response['message'] = 'Sorry, Data not found';
    $response['pageTitle'] = 'Forgot Password';
  }

  echo $this->Site_model->json($response);   

}


}

