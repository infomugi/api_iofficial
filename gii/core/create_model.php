<?php 

$string = "<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// " . $c . " Model
class " . $m . " extends CI_Model
{

    public \$table = '$table_name';
    public \$id = '$pk';
    public \$order = 'DESC';

    function __construct()
    {
        parent::__construct();
        \$this->load->database();
    }";

    if ($jenis_tabel <> 'reguler_table') {

        $column_all = array();
        foreach ($all as $row) {
            $column_all[] = $row['column_name'];
        }
        $columnall = implode(',', $column_all);

        $string .="\n\n    // datatables
        function json() {
            \$this->datatables->select('".$columnall."');
            \$this->datatables->from('".$table_name."');
        //add this line for join
        //\$this->datatables->join('table2', '".$table_name.".field = table2.field');
            \$this->datatables->add_column('action', anchor(site_url('".$c_url."/read/\$1'),'Read').\" | \".anchor(site_url('".$c_url."/update/\$1'),'Update').\" | \".anchor(site_url('".$c_url."/delete/\$1'),'Delete','onclick=\"javasciprt: return confirm(\\'Are You Sure ?\\')\"'), '$pk');
            return \$this->datatables->generate();
        }";
    }

    $string .="\n\n    
    /* ---------------------------------------------------------------- 
    Nama \t: Get Index All ".ucfirst($table_name)."  
    Fungsi \t: Menampilkan semua data pada tabel ".ucfirst($c_url)."
    ---------------------------------------------------------------- */
    function get_all()
    {
        \$this->db->order_by(\$this->id, \$this->order);
        return \$this->db->get(\$this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama \t: Get Detail Data ".ucfirst($table_name)."  
    Fungsi \t: Menampilkan detail data pada tabel ".ucfirst($c_url)."
    Ket \t\t: // id : (Adalah Primary Key dari Tabel ".ucfirst($c_url).") 
    ---------------------------------------------------------------- */
    function get_by_id(\$id)
    {
        \$this->db->where(\$this->id, \$id);
        return \$this->db->get(\$this->table)->row();
    }

    /* ---------------------------------------------------------------- 
    Nama \t: Get Total Data ".ucfirst($table_name)."  
    Fungsi \t: Menampilkan total data pada tabel ".ucfirst($c_url)."
    Ket \t\t: // keyword : (Adalah kata kunci pencarian data pada tabel ".ucfirst($c_url).") 
    ---------------------------------------------------------------- */
    function get_total_rows(\$keyword = NULL) {
        \$this->db->like('$pk', \$keyword);";

        foreach ($non_pk as $row) {
            $string .= "\n\t\$this->db->or_like('" . $row['column_name'] ."', \$keyword);";
        }    

        $string .= "\n\t\$this->db->from(\$this->table);
        return \$this->db->count_all_results();
    }

    /* ---------------------------------------------------------------- 
    Nama \t: Get List Limit ".ucfirst($table_name)."  
    Fungsi \t: Menampilkan data dengan pengaturan jumlah tampil data ".ucfirst($c_url)."
    Ket \t\t: // start : (Inisasi Mulai Menampilkan Data ".ucfirst($c_url).") 
    \t \t \t  // limit : (Jumlah Batas Menampilkan Data ".ucfirst($c_url).")
    ---------------------------------------------------------------- */
    function get_limit_data(\$limit, \$start = 0) {
        \$this->db->order_by(\$this->id, \$this->order);
        \$this->db->like('$pk');";

        foreach ($non_pk as $row) {
            $string .= "\n\t\$this->db->or_like('" . $row['column_name'] ."');";
        }    

        $string .= "\n\t\$this->db->limit(\$limit, \$start);
        return \$this->db->get(\$this->table)->result();
    }

    /* ---------------------------------------------------------------- 
    Nama \t: Get Pencarian ".ucfirst($table_name)."  
    Fungsi \t: Mencari data pada tabel ".ucfirst($c_url)."
    Ket \t \t: // start : (Inisasi Mulai Menampilkan Data ".ucfirst($c_url).") 
    \t \t \t  // limit : (Jumlah Batas Menampilkan Data ".ucfirst($c_url).")
    \t \t \t  // keyword : (Adalah kata kunci pencarian data pada tabel ".ucfirst($c_url).") 
    ---------------------------------------------------------------- */
    function get_search(\$limit, \$start, \$keyword) {
        \$this->db->order_by(\$this->id, \$this->order);
        \$this->db->like('$pk', \$keyword);";

        foreach ($non_pk as $row) {
            $string .= "\n\t\$this->db->or_like('" . $row['column_name'] ."', \$keyword);";
        }    

        $string .= "\n\t\$this->db->limit(\$limit, \$start);
        return \$this->db->get(\$this->table)->result();
    }    

    /* ---------------------------------------------------------------- 
    Nama \t: Simpan ".ucfirst($table_name)."  
    Fungsi \t: Menyimpan data pada tabel ".ucfirst($c_url)."
    ---------------------------------------------------------------- */
    function insert(\$data)
    {
        \$this->db->insert(\$this->table, \$data);
    }

    /* ---------------------------------------------------------------- 
    Nama \t: Edit ".ucfirst($table_name)."  
    Fungsi \t: Update data pada tabel ".ucfirst($c_url)."
    ---------------------------------------------------------------- */
    function update(\$id, \$data)
    {
        \$this->db->where(\$this->id, \$id);
        \$this->db->update(\$this->table, \$data);
    }

    /* ---------------------------------------------------------------- 
    Nama \t: Hapus ".ucfirst($table_name)."  
    Fungsi \t: Delete data pada tabel ".ucfirst($c_url)."
    ---------------------------------------------------------------- */
    function delete(\$id)
    {
        \$this->db->where(\$this->id, \$id);
        \$this->db->delete(\$this->table);
    }

}
";

$hasil_model = createFile($string, $target."models/" . $m_file);

?>