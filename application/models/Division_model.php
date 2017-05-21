<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// Division Model
class Division_model extends CI_Model
{

    public $table = 'division';
    public $id = 'id_division';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    // datatables
        function json() {
            $this->datatables->select('id_division,name,description,status');
            $this->datatables->from('division');
        //add this line for join
        //$this->datatables->join('table2', 'division.field = table2.field');
            $this->datatables->add_column('action', anchor(site_url('division/read/$1'),'Read')." | ".anchor(site_url('division/update/$1'),'Update')." | ".anchor(site_url('division/delete/$1'),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'), 'id_division');
            return $this->datatables->generate();
        }

    
    /* ---------------------------------------------------------------- 
    Nama 	: Get Index All Division  
    Fungsi 	: Menampilkan semua data pada tabel Division
    ---------------------------------------------------------------- */
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Detail Data Division  
    Fungsi 	: Menampilkan detail data pada tabel Division
    Ket 		: // id : (Adalah Primary Key dari Tabel Division) 
    ---------------------------------------------------------------- */
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Total Data Division  
    Fungsi 	: Menampilkan total data pada tabel Division
    Ket 		: // keyword : (Adalah kata kunci pencarian data pada tabel Division) 
    ---------------------------------------------------------------- */
    function get_total_rows($keyword = NULL) {
        $this->db->like('id_division', $keyword);
	$this->db->or_like('name', $keyword);
	$this->db->or_like('description', $keyword);
	$this->db->or_like('status', $keyword);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get List Limit Division  
    Fungsi 	: Menampilkan data dengan pengaturan jumlah tampil data Division
    Ket 		: // start : (Inisasi Mulai Menampilkan Data Division) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Division)
    ---------------------------------------------------------------- */
    function get_limit_data($limit, $start = 0) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_division');
	$this->db->or_like('name');
	$this->db->or_like('description');
	$this->db->or_like('status');
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Get Pencarian Division  
    Fungsi 	: Mencari data pada tabel Division
    Ket 	 	: // start : (Inisasi Mulai Menampilkan Data Division) 
    	 	 	  // limit : (Jumlah Batas Menampilkan Data Division)
    	 	 	  // keyword : (Adalah kata kunci pencarian data pada tabel Division) 
    ---------------------------------------------------------------- */
    function get_search($limit, $start, $keyword) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_division', $keyword);
	$this->db->or_like('name', $keyword);
	$this->db->or_like('description', $keyword);
	$this->db->or_like('status', $keyword);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }    

    /* ---------------------------------------------------------------- 
    Nama 	: Simpan Division  
    Fungsi 	: Menyimpan data pada tabel Division
    ---------------------------------------------------------------- */
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Edit Division  
    Fungsi 	: Update data pada tabel Division
    ---------------------------------------------------------------- */
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    /* ---------------------------------------------------------------- 
    Nama 	: Hapus Division  
    Fungsi 	: Delete data pada tabel Division
    ---------------------------------------------------------------- */
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
