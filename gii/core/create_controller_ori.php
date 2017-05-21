<?php
$string = "<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// " . $c . " Controller
class " . $c . " extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        \$this->load->model('Site_model');
        \$this->load->model('$m');
        date_default_timezone_set('Asia/Jakarta');";
        $string .= "
    }";

    $string .= "

    \n\n 
    /* ---------------------------------------------------------------- 
    Nama \t: Index ".ucfirst($table_name)."
    Fungsi \t: Menampilkan Semua data pada tabel ".ucfirst($c_url)."
    ---------------------------------------------------------------- */
    public function index()
    {
        \$$c_url = \$this->" . $m . "->get_all();
        \$total = \$this->" . $m . "->get_total_rows();

        \$response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.', 
        'pageTitle' => 'Index ".ucfirst($table_name)."',
        'total_result' => \$total,
        'data' => \$$c_url,
        );

        echo \$this->Site_model->json(\$response);
    }

    \n\n 
    /* ---------------------------------------------------------------- 
    Nama \t: List Limit ".ucfirst($table_name)."
    Fungsi \t: Menampilkan Semua data dengan Limit pada tabel ".ucfirst($c_url)."
    Request \t: // start : (Inisasi Mulai Menampilkan Data ".ucfirst($c_url).") 
    \t \t \t  // limit : (Jumlah Batas Menampilkan Data ".ucfirst($c_url).")
    // Method \t: POST
    ---------------------------------------------------------------- */
    public function list".ucfirst($c_url)."()
    {
        \$start = \$this->input->post('start');
        \$limit = \$this->input->post('limit');
        \$$c_url = \$this->" . $m . "->get_limit_data(\$limit,\$start);
        \$total = \$this->" . $m . "->get_total_rows();

        \$response = array(
        'status' => 'success',
        'message' => 'Data retrieved successfully.', 
        'pageTitle' => 'List ".ucfirst($table_name)."',
        'total_result' => \$total,
        'data' => \$$c_url,
        );

        echo \$this->Site_model->json(\$response);

    }

    \n\n  
    /* ---------------------------------------------------------------- 
    Nama \t: Detail ".ucfirst($table_name)."  
    Fungsi \t: Menampilkan detail data pada tabel ".ucfirst($c_url)."]
    Request \t: // $pk : (Adalah Primary Key dari Tabel ".ucfirst($c_url).") 
    Method \t: POST    
    ---------------------------------------------------------------- */
    public function view() 
    {
        \$id = \$this->input->post('$pk');
        \$row = \$this->" . $m . "->get_by_id(\$id);
        if (\$row) {

            \$data = array(";
            foreach ($all as $row) {
                $string .= "\n\t\t'" . $row['column_name'] . "' => \$row->" . $row['column_name'] . ",";
            }
            $string .= "\n\t    );

            \$response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',   
            'pageTitle' => 'Detail ".ucfirst($table_name)."',       
            'data' => \$data,
            );

        } else {

            \$response['status'] = 'failed';
            \$response['message'] = 'Data not Found.';
        }
        echo \$this->Site_model->json(\$response);            
    }
    \n\n 
    /* ---------------------------------------------------------------- 
    Nama \t: Pencarian ".ucfirst($table_name)." 
    Fungsi \t: Mencari data pada tabel ".ucfirst($c_url)."
    Request \t: // start : (Inisasi Mulai Menampilkan Data ".ucfirst($c_url).") 
    \t \t \t  // limit : (Jumlah Batas Menampilkan Data ".ucfirst($c_url).")
    \t \t \t  // keyword : (Merupakan Kata Kunci dalam Pencarian Data ".ucfirst($c_url).")
    // Method \t: POST
    ---------------------------------------------------------------- */
    public function search() 
    {
        \$start = \$this->input->post('start');
        \$limit = \$this->input->post('limit');
        \$keyword = \$this->input->post('keyword');

        \$row = \$this->" . $m . "->get_search(\$limit, \$start, \$keyword);
        if (\$row) {
            \$total = \$this->" . $m . "->get_total_rows(\$keyword);
            \$response = array(
            'status' => 'success',
            'message' => 'Data retrieved successfully.',          
            'pageTitle' => 'Search ".ucfirst($table_name)."',
            'total_result' => \$total,
            'data' => \$row,
            );

        } else {

            \$response['status'] = 'failed';
            \$response['message'] = 'Data '.\$keyword.' not Found.';
        }
        echo \$this->Site_model->json(\$response);            
    }    
    \n\n 
    /* ---------------------------------------------------------------- 
    Nama \t: Simpan ".ucfirst($table_name)." 
    Fungsi \t: Menambahkan data pada tabel ".ucfirst($c_url)."  
    Request \t: ";
    foreach ($non_pk as $row) {
        $string .= "\n\t\t\t\t // " . ucfirst($row['column_name']);
    }
    $string .= "
    // Method \t: POST 
    ---------------------------------------------------------------- */

    public function save() 
    {
        \$data = array(";
        foreach ($non_pk as $row) {
            $string .= "\n\t\t'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "'),";
        }
        $string .= "\n\t    );


        if(\$data){
            \$insert = \$this->".$m."->insert(\$data);
            \$response = array(
            'status' => 'success',
            'message' => 'Data saved successfully.',          
            'pageTitle' => 'Add ".ucfirst($table_name)."',
            );

        }else{

            \$response['status'] = 'failed';
            \$response['message'] = 'Data failed to save.';

        }
        echo \$this->Site_model->json(\$response);  
    }
    \n\n 
    /* ---------------------------------------------------------------- 
    Nama \t: Edit ".ucfirst($table_name)." 
    Fungsi \t: Memperbaharui data pada tabel ".ucfirst($c_url)."
    Request \t: // $pk : (Adalah Primary Key dari Tabel ".ucfirst($c_url).") 
    Method \t: POST   
    ---------------------------------------------------------------- */
    public function edit() 
    {
        \$id = \$this->input->post('$pk');
        \$row = \$this->".$m."->get_by_id(\$id);

        if (\$row) {

            \$data = array(";
            foreach ($non_pk as $row) {
                $string .= "\n\t\t'" . $row['column_name'] . "' => \$this->input->post('" . $row['column_name'] . "'),";
            }
            $string .= "\n\t    );


            if(\$data){

                \$update = \$this->".$m."->update(\$id, \$data);
                \$response = array(
                'status' => 'success',
                'message' => 'Data saved successfully.',          
                'pageTitle' => 'Update ".ucfirst($table_name)."',
                );

            }else{

                \$response['status'] = 'failed';
                \$response['message'] = 'Data failed to save.';

            }

        } else {

            \$response['status'] = 'failed';
            \$response['message'] = 'Data not found.';
        }
        echo \$this->Site_model->json(\$response);  
    }
    \n\n 
    /* ---------------------------------------------------------------- 
    Nama \t: Hapus ".ucfirst($table_name)." 
    Fungsi \t: Menghapus data pada tabel ".ucfirst($c_url)."
    Request \t: // $pk : (Adalah Primary Key dari Tabel ".ucfirst($c_url).") 
    Method \t: POST      
    ---------------------------------------------------------------- */ 
    public function delete() 
    {
        \$id = \$this->input->post('$pk');
        \$row = \$this->".$m."->get_by_id(\$id);

        if (\$row) {
            \$this->".$m."->delete(\$id);
            \$response = array(
            'status' => 'success',
            'message' => 'Data delete successfully.',          
            'pageTitle' => 'Delete ".ucfirst($table_name)."',
            );

        } else {
            \$response['status'] = 'failed';
            \$response['message'] = 'Data not found.';
        }

        echo \$this->Site_model->json(\$response);            
    }
    ";

    if ($export_excel == '1') {
        $string .= "\n\n    public function excel()
        {
            \$this->load->helper('exportexcel');
            \$namaFile = \"$table_name.xls\";
            \$judul = \"$table_name\";
            \$tablehead = 0;
            \$tablebody = 1;
            \$nourut = 1;
        //penulisan header
            header(\"Pragma: public\");
            header(\"Expires: 0\");
            header(\"Cache-Control: must-revalidate, post-check=0,pre-check=0\");
            header(\"Content-Type: application/force-download\");
            header(\"Content-Type: application/octet-stream\");
            header(\"Content-Type: application/download\");
            header(\"Content-Disposition: attachment;filename=\" . \$namaFile . \"\");
            header(\"Content-Transfer-Encoding: binary \");

            xlsBOF();

            \$kolomhead = 0;
            xlsWriteLabel(\$tablehead, \$kolomhead++, \"No\");";
            foreach ($non_pk as $row) {
                $column_name = label($row['column_name']);
                $string .= "\n\txlsWriteLabel(\$tablehead, \$kolomhead++, \"$column_name\");";
            }
            $string .= "\n\n\tforeach (\$this->" . $m . "->get_all() as \$data) {
                \$kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
                xlsWriteNumber(\$tablebody, \$kolombody++, \$nourut);";
                foreach ($non_pk as $row) {
                    $column_name = $row['column_name'];
                    $xlsWrite = $row['data_type'] == 'int' || $row['data_type'] == 'double' || $row['data_type'] == 'decimal' ? 'xlsWriteNumber' : 'xlsWriteLabel';
                    $string .= "\n\t    " . $xlsWrite . "(\$tablebody, \$kolombody++, \$data->$column_name);";
                }
                $string .= "\n\n\t    \$tablebody++;
                \$nourut++;
            }

            xlsEOF();
            exit();
        }";
    }

    if ($export_word == '1') {
        $string .= "\n\n    public function word()
        {
            header(\"Content-type: application/vnd.ms-word\");
            header(\"Content-Disposition: attachment;Filename=$table_name.doc\");

            \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
            );

            \$this->load->view('" . $c_url ."/". $v_doc . "',\$data);
        }";
    }

    if ($export_pdf == '1') {
        $string .= "\n\n    function pdf()
        {
            \$data = array(
            '" . $table_name . "_data' => \$this->" . $m . "->get_all(),
            'start' => 0
            );

            ini_set('memory_limit', '32M');
            \$html = \$this->load->view('" . $c_url ."/". $v_pdf . "', \$data, true);
            \$this->load->library('pdf');
            \$pdf = \$this->pdf->load();
            \$pdf->WriteHTML(\$html);
            \$pdf->Output('" . $table_name . ".pdf', 'D'); 
        }";
    }

    $string .= "\n\n}\n\n";




    $hasil_controller = createFile($string, $target . "controllers/" . $c_file);

    ?>