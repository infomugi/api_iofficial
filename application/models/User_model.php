<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// User Model
class User_model extends CI_Model
{

    public $table = 'user';
    public $id = 'id_user';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    
    /* ---------------------------------------------------------------- 
    Nama 	: Get Index All User  
    Fungsi 	: Menampilkan semua data pada tabel User
    ---------------------------------------------------------------- */
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Detail Data User  
    Fungsi 	: Menampilkan detail data pada tabel User
    Ket 		: // id : (Adalah Primary Key dari Tabel User) 
    ---------------------------------------------------------------- */
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Total Data User  
    Fungsi 	: Menampilkan total data pada tabel User
    Ket 		: // keyword : (Adalah kata kunci pencarian data pada tabel User) 
    ---------------------------------------------------------------- */
    function get_total_rows($keyword = NULL) {
        $this->db->like('id_user', $keyword);
        $this->db->or_like('create_time', $keyword);
        $this->db->or_like('update_time', $keyword);
        $this->db->or_like('visit_time', $keyword);
        $this->db->or_like('fullname', $keyword);
        $this->db->or_like('gender', $keyword);
        $this->db->or_like('birth', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('username', $keyword);
        $this->db->or_like('password', $keyword);
        $this->db->or_like('level', $keyword);
        $this->db->or_like('division', $keyword);
        $this->db->or_like('image', $keyword);
        $this->db->or_like('ipaddress', $keyword);
        $this->db->or_like('active', $keyword);
        $this->db->or_like('status', $keyword);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get List Limit User  
    Fungsi 	: Menampilkan data dengan pengaturan jumlah tampil data User
    Ket 		: // start : (Inisasi Mulai Menampilkan Data User) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data User)
    ---------------------------------------------------------------- */
    function get_limit_data($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_user');
        $this->db->or_like('create_time');
        $this->db->or_like('update_time');
        $this->db->or_like('visit_time');
        $this->db->or_like('fullname');
        $this->db->or_like('gender');
        $this->db->or_like('birth');
        $this->db->or_like('email');
        $this->db->or_like('username');
        $this->db->or_like('password');
        $this->db->or_like('level');
        $this->db->or_like('division');
        $this->db->or_like('image');
        $this->db->or_like('ipaddress');
        $this->db->or_like('active');
        $this->db->or_like('status');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Pencarian User  
    Fungsi 	: Mencari data pada tabel User
    Ket 	 	: // start : (Inisasi Mulai Menampilkan Data User) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data User)
    	 	 	  // keyword : (Adalah kata kunci pencarian data pada tabel User) 
    ---------------------------------------------------------------- */
    function get_search($limit, $start, $keyword) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_user', $keyword);
        $this->db->or_like('fullname', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('username', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }    

    /* ---------------------------------------------------------------- 
    Nama 	: Simpan User  
    Fungsi 	: Menyimpan data pada tabel User
    ---------------------------------------------------------------- */
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Edit User  
    Fungsi 	: Update data pada tabel User
    ---------------------------------------------------------------- */
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Hapus User  
    Fungsi 	: Delete data pada tabel User
    ---------------------------------------------------------------- */
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function get_email($email)
    {
        $this->db->where('email', $email);
        return $this->db->get($this->table)->row();
    }   

    function get_username($username)
    {
        $this->db->where('username', $username);
        return $this->db->get($this->table)->row();
    }        

}
