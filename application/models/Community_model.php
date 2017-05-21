<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Community Model
class Community_model extends CI_Model
{

    public $table = 'setting';
    public $id = 'id_site';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    
    /* ---------------------------------------------------------------- 
    Nama 	: Get Index All Setting  
    Fungsi 	: Menampilkan semua data pada tabel Community
    ---------------------------------------------------------------- */
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Detail Data Setting  
    Fungsi 	: Menampilkan detail data pada tabel Community
    Ket 		: // id : (Adalah Primary Key dari Tabel Community) 
    ---------------------------------------------------------------- */
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Total Data Setting  
    Fungsi 	: Menampilkan total data pada tabel Community
    Ket 		: // keyword : (Adalah kata kunci pencarian data pada tabel Community) 
    ---------------------------------------------------------------- */
    function get_total_rows($keyword = NULL) {
        $this->db->like('id_site', $keyword);
        $this->db->or_like('name', $keyword);
        $this->db->or_like('description', $keyword);
        $this->db->or_like('keywords', $keyword);
        $this->db->or_like('favicon', $keyword);
        $this->db->or_like('logo', $keyword);
        $this->db->or_like('address', $keyword);
        $this->db->or_like('phone', $keyword);
        $this->db->or_like('email', $keyword);
        $this->db->or_like('facebook', $keyword);
        $this->db->or_like('instagram', $keyword);
        $this->db->or_like('twitter', $keyword);
        $this->db->or_like('status', $keyword);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get List Limit Setting  
    Fungsi 	: Menampilkan data dengan pengaturan jumlah tampil data Community
    Ket 		: // start : (Inisasi Mulai Menampilkan Data Community) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Community)
    ---------------------------------------------------------------- */
    function get_limit_data($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_site');
        $this->db->or_like('name');
        $this->db->or_like('description');
        $this->db->or_like('keywords');
        $this->db->or_like('favicon');
        $this->db->or_like('logo');
        $this->db->or_like('address');
        $this->db->or_like('phone');
        $this->db->or_like('email');
        $this->db->or_like('facebook');
        $this->db->or_like('instagram');
        $this->db->or_like('twitter');
        $this->db->or_like('status');
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Pencarian Setting  
    Fungsi 	: Mencari data pada tabel Community
    Ket 	 	: // start : (Inisasi Mulai Menampilkan Data Community) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Community)
    	 	 	  // keyword : (Adalah kata kunci pencarian data pada tabel Community) 
    ---------------------------------------------------------------- */
    function get_search($limit, $start, $keyword) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('name', $keyword);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }    

    /* ---------------------------------------------------------------- 
    Nama 	: Simpan Setting  
    Fungsi 	: Menyimpan data pada tabel Community
    ---------------------------------------------------------------- */
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Edit Setting  
    Fungsi 	: Update data pada tabel Community
    ---------------------------------------------------------------- */
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Hapus Setting  
    Fungsi 	: Delete data pada tabel Community
    ---------------------------------------------------------------- */
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function get_name($name)
    {
        $this->db->where('name', $name);
        return $this->db->get($this->table)->row();
    }      

}
