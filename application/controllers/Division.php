<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

// Division Controller
class Division extends REST_Controller
{
    //Setting Request per hour per user/key

    function __construct()
    {
        parent::__construct();

        //Load Model Division
        $this->load->model('Division_model');
        
        //Konfigurasi Request Division
        $big = 4;
        $medium = 3;
        $small = 2;

        //Method Controller Division
        $this->methods['index_get']['limit'] = $big; 
        $this->methods['listDivision_get']['limit'] = $big; 
        $this->methods['view_get']['limit'] = $big; 
        $this->methods['search_get']['limit'] = $big; 
        $this->methods['save_get']['limit'] = $medium; 
        $this->methods['edit_get']['limit'] = $medium; 
        $this->methods['delete_get']['limit'] = $small; 
        
    }

    

 
    /* ---------------------------------------------------------------- 
    Nama 	: Index Division
    Fungsi 	: Menampilkan Semua data pada tabel Division
    ---------------------------------------------------------------- */
    public function index_get()
    {
        $division = $this->Division_model->get_all();
        $total = $this->Division_model->get_total_rows();

        $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.', 
        'pageTitle' => 'Index Division',
        'total_result' => $total,
        'data' => $division,
        );

        $this->response($response, REST_Controller::HTTP_OK);
    }

    

 
    /* ---------------------------------------------------------------- 
    Nama 	: List Limit Division
    Fungsi 	: Menampilkan Semua data dengan Limit pada tabel Division
    Request 	: // start : (Inisasi Mulai Menampilkan Data Division) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Division)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function listDivision_get()
    {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        $division = $this->Division_model->get_limit_data($limit,$start);
        $total = $this->Division_model->get_total_rows();

        $response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.', 
        'pageTitle' => 'List Division',
        'total_result' => $total,
        'data' => $division,
        );

        $this->response($response, REST_Controller::HTTP_OK);

    }

    

  
    /* ---------------------------------------------------------------- 
    Nama 	: Detail Division  
    Fungsi 	: Menampilkan detail data pada tabel Division]
    Request 	: // id_division : (Adalah Primary Key dari Tabel Division) 
    Method 	: POST    
    ---------------------------------------------------------------- */
    public function view_get() 
    {
        $id = $this->input->post('id_division');
        $row = $this->Division_model->get_by_id($id);
        if ($row) {

            $data = array(
		'id_division' => $row->id_division,
		'name' => $row->name,
		'description' => $row->description,
		'status' => $row->status,
	    );

            $response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',   
            'pageTitle' => 'Detail Division',       
            'data' => $data,
            );
            $this->response($response, REST_Controller::HTTP_OK);

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data not Found.';
            $this->response($response, REST_Controller::HTTP_NOT_FOUND); 
        }
    }
    

 
    /* ---------------------------------------------------------------- 
    Nama 	: Pencarian Division 
    Fungsi 	: Mencari data pada tabel Division
    Request 	: // start : (Inisasi Mulai Menampilkan Data Division) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Division)
    	 	 	  // keyword : (Merupakan Kata Kunci dalam Pencarian Data Division)
    // Method 	: POST
    ---------------------------------------------------------------- */
    public function search_get() 
    {
        $start = $this->input->post('start');
        $limit = $this->input->post('limit');
        $keyword = $this->input->post('keyword');

        $row = $this->Division_model->get_search($limit, $start, $keyword);
        if ($row) {
            $total = $this->Division_model->get_total_rows($keyword);
            $response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',          
            'pageTitle' => 'Search Division',
            'total_result' => $total,
            'data' => $row,
            );
            $this->response($response, REST_Controller::HTTP_OK);

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data '.$keyword.' not Found.';
            $this->response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }    
    

 
    /* ---------------------------------------------------------------- 
    Nama 	: Simpan Division 
    Fungsi 	: Menambahkan data pada tabel Division  
    Request 	: 
				 // Name
				 // Description
				 // Status
    // Method 	: POST 
    ---------------------------------------------------------------- */

    public function save_get() 
    {
        $data = array(
		'name' => $this->input->post('name'),
		'description' => $this->input->post('description'),
		'status' => $this->input->post('status'),
	    );


        if($data){
            $insert = $this->Division_model->insert($data);
            $response = array(
            'status' => 'success',
            'message' => 'Data saved successfully.',          
            'pageTitle' => 'Add Division',
            );

            $this->set_response($response, REST_Controller::HTTP_CREATED);

        }else{

            $response['status'] = 'failed';
            $response['message'] = 'Data failed to save.';
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);

        }
    }
    

 
    /* ---------------------------------------------------------------- 
    Nama 	: Edit Division 
    Fungsi 	: Memperbaharui data pada tabel Division
    Request 	: // id_division : (Adalah Primary Key dari Tabel Division) 
    Method 	: POST   
    ---------------------------------------------------------------- */
    public function edit_get() 
    {
        $id = $this->input->post('id_division');
        $row = $this->Division_model->get_by_id($id);

        if ($row) {

            $data = array(
		'name' => $this->input->post('name'),
		'description' => $this->input->post('description'),
		'status' => $this->input->post('status'),
	    );


            if($data){

                $update = $this->Division_model->update($id, $data);
                $response = array(
                'status' => 'success',
                'message' => 'Data saved successfully.',          
                'pageTitle' => 'Update Division',
                );
                $this->response($response, REST_Controller::HTTP_OK);

            }else{

                $response['status'] = 'failed';
                $response['message'] = 'Data failed to save.';
                $this->response($response, REST_Controller::HTTP_BAD_REQUEST);

            }

        } else {

            $response['status'] = 'failed';
            $response['message'] = 'Data not found.';
            $this->response($response, REST_Controller::HTTP_NOT_FOUND);
        }
    }
    

 
    /* ---------------------------------------------------------------- 
    Nama 	: Hapus Division 
    Fungsi 	: Menghapus data pada tabel Division
    Request 	: // id_division : (Adalah Primary Key dari Tabel Division) 
    Method 	: POST      
    ---------------------------------------------------------------- */ 
    public function remove_get() 
    {
        $id = $this->input->post('id_division');
        $row = $this->Division_model->get_by_id($id);

        if ($row) {
            $this->Division_model->delete($id);
            $response = array(
            'status' => 'success',
            'message' => 'Data delete successfully.',          
            'pageTitle' => 'Delete Division',
            );
            $this->set_response($response, REST_Controller::HTTP_NO_CONTENT);

        } else {
            $response['status'] = 'failed';
            $response['message'] = 'Data not found.';
            $this->response($response, REST_Controller::HTTP_BAD_REQUEST);
        }

    }
    

}

