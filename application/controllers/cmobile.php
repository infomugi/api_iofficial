<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();
class CMobile extends CI_Controller {

  public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->model('mnews');
        $this->load->model('mnewstype'); 
        $this->load->model('mtelegram'); 
        $this->load->model('mpolicestation'); 
        $this->load->model('muser'); 
        $this->load->model('mprofile'); 
        $this->load->model('mactivity'); 
    }

  public function index() 
  {   
      // $data['content'] = 'home';
      $this->load->view('home');

    }

   public function updateShow()
  {
    $id = $this->input->post('id');
      $data = array(
        'STATUS' => "SHOW",
      );
    $this->mnews->update(array('ID' => $this->input->post('id')), $data);
     $response["success"] = 1;
     echo json_encode($response);
  }


public function getKontributor()
  {
    $data = $this->muser->getDataKontributor();
    $output = array(
            "info" => $data,
        );
    echo json_encode($output);
  }


public function simpanBerita()
  {
    $response = array();
  
    if ((isset($_POST['judul']) && isset($_POST['alamat']) && isset($_POST['desk']) && isset($_POST['idTipeBerita']) && isset($_POST['userId'])) && ( $_POST['judul']!="" && $_POST['alamat']!="" && $_POST['desk']!="" && $_POST['idTipeBerita']!="" && $_POST['long']!="" && $_POST['lat']!="" && $_POST['userId']!="" )) {
        
        $userId =$_POST['userId'];
        $judul = $_POST['judul'];
        $alamat = $_POST['alamat'];
        $path = $this->input->post('gambar');
        $desk = $_POST['desk'];
        $format = substr($this->input->post('gambar'), -3);
        $pLat = $_POST['lat'];
        $pLong = $_POST['long'];
        $idTipeBerita = $_POST['idTipeBerita'];
        $idTipeBerita = explode(',', $idTipeBerita);


        $data['id'] = $this->mnews->getId();
        foreach ($data['id'] as $key) {
          $idBaru = $key->newsId + 1;
        }
        date_default_timezone_set('Asia/Jakarta');
        $newsDate=date("Y-m-d H:i:s");
          $result = mysql_query("INSERT INTO news(ID, TITLE, ADDRESS, DESCRIPTION, IMAGE, LONGITUDE, LATITUDE , CREATED_BY, CREATED_AT, STATUS) VALUES('$idBaru', '$judul', '$alamat', '$desk','$idBaru.$format','$pLong', '$pLat', '$userId', '$newsDate','HIDE')");
 
        for ($i=0; $i < count($idTipeBerita) ; $i++) { 
             $result1 =mysql_query( "insert into news_type_news values ('$idBaru','$idTipeBerita[$i]')");
        }
             
        // cek data udah masuk belum
        if ($result && $result1) {
            // kalo sukses
            $response["success"] = 1;
            $response["message"] = "Pendaftaran anda berhasil";
            $response["idBerita"] = $idBaru;
            $response["judul"] = $_POST['judul'];
            $response["alamat"] = $_POST['alamat'];
            $response["desk"] = $_POST['desk'];
            $response["idTipeBerita"] = $_POST['idTipeBerita'];
            $response["long"] = $_POST['long'];
            $response["lat"] = $_POST['lat'];

            $status = "";
            $msg = "";      
                $this->load->library('image_lib');
                $url = './public/images/berita/'; 
                if($_FILES['uploaded_file']['error']==4)  //if No file was uploaded. 
                    return false;        
                $config['upload_path'] = $url."original/";        
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = TRUE;
               
                $config['file_name'] = $idBaru;
                
                $this->load->library('upload');
                $this->upload->initialize($config);
                
                if( $this->upload->do_upload('foto') )
                {    
                    $files = $this->upload->data();
                    $fileNameResize = $config['upload_path'].$files['file_name'];
                    $size =  array(                
                                array('name'    => 'avatar','width'    => 29, 'height'    => 29, 'quality'    => '100%'),
                                // array('name'    => 'big','width'    =>900, 'height'    => 900, 'quality'    => '100%'),
                                array('name'    => 'big','width'    =>1240, 'height'    => 1240, 'quality'    => '100%')
                            );
                    $resize = array();
                    foreach($size as $r){                
                        $resize = array(
                            "width"         => $r['width'],
                            "height"        => $r['height'],
                            "quality"       => $r['quality'],
                            "source_image"  => $fileNameResize,
                            "new_image"     => $url.$r['name'].'/'.$files['file_name']
                        );
                        $this->image_lib->initialize($resize); 
                        if(!$this->image_lib->resize())                    
                            die($this->image_lib->display_errors());
                    }            
                    echo "resize oke";
                    $response["success"] = 1;

                } 
                else{ 
                  $response["success_foto"] = 0;
                  $response["message_foto"] =  $this->upload->display_errors();
                  $msg = $this->upload->display_errors();
                }    
                $filename = $imgName;
              if (file_exists('public/images/berita/original/'. $filename.'.jpg')) {
                 unlink('public/images/berita/original/'. $filename.'.jpg'); 
              } 
              else if (file_exists('public/images/berita/original/'. $filename.'.png')) {
                 unlink('public/images/berita/original/'. $filename.'.png'); 
              }    
              else if (file_exists('public/images/berita/original/'. $filename.'.gif')) {
                 unlink('public/images/berita/original/'. $filename.'.gif'); 
              }    
              else if (file_exists('public/images/berita/original/'. $filename.'.jpeg')) {
                 unlink('public/images/berita/original/'. $filename.'.jpeg'); 
              }     
              
           

        } else {
            // fkalo gagal
            $response["success"] = 0;
            $response["message"] = "Sistem mendeteksi kesalahan, silahkan coba lagi";
       
        }
    }
    else {
        $response["success"] = 0;
        $response["message"] = "Silahkan lengkapi aksi sebelum memulai permintaan anda";
        $response["judul"] = $_POST['judul'];
        $response["alamat"] = $_POST['alamat'];
        $response["desk"] = $_POST['desk'];
        $response["idTipeBerita"] = $_POST['idTipeBerita'];
        $response["long"] = $_POST['long'];
        $response["lat"] = $_POST['lat'];
        // echoing JSON response
      
    }

      echo json_encode($response);
  }




   public function updateHide()
  {
    $id = $this->input->post('id');
      $data = array(
        'STATUS' => "HIDE",
      );
    $this->mnews->update(array('ID' => $this->input->post('id')), $data);
     $response["success"] = 1;
     echo json_encode($response);
  }



    public function ajaxAddTidakdipakai()
  {
    $response = array();
  
    if ((isset($_POST['judul']) && isset($_POST['alamat']) && isset($_POST['desk']) && isset($_POST['idTipeBerita']) && isset($_POST['long'])&& isset($_POST['lat']) && isset($_POST['userId'])) && ( $_POST['judul']!="" && $_POST['alamat']!="" && $_POST['desk']!="" && $_POST['idTipeBerita']!="" && $_POST['long']!="" && $_POST['lat']!="" && $_POST['userId']!="" )) {
        
        $userId =$_POST['userId'];
        $judul = $_POST['judul'];
        $alamat = $_POST['alamat'];
        $desk = $_POST['desk'];
        $path = $this->input->post('gambar');
        $format = substr($this->input->post('gambar'), -3);
        $pLat = $_POST['lat'];
        $pLong = $_POST['long'];
        $idTipeBerita = $_POST['idTipeBerita'];
        $idTipeBerita = explode(',', $idTipeBerita);


        $data['id'] = $this->mnews->getId();
        foreach ($data['id'] as $key) {
          $idBaru = $key->newsId + 1;
        }
        date_default_timezone_set('Asia/Jakarta');
        $newsDate=date("Y-m-d H:i:s");
        if($path =="kosong"){
           $result = mysql_query("INSERT INTO news(ID, TITLE, ADDRESS, DESCRIPTION, IMAGE, LONGITUDE, LATITUDE , CREATED_BY, CREATED_AT, STATUS) VALUES('$idBaru', '$judul', '$alamat', '$desk','back.jpg','$pLong', '$pLat', '$userId', '$newsDate','HIDE')");
        }else{
          $result = mysql_query("INSERT INTO news(ID, TITLE, ADDRESS, DESCRIPTION, IMAGE, LONGITUDE, LATITUDE , CREATED_BY, CREATED_AT, STATUS) VALUES('$idBaru', '$judul', '$alamat', '$desk','$idBaru.$format','$pLong', '$pLat', '$userId', '$newsDate','HIDE')");
        }



        //  if(isset($_POST['gambar']) && substr($this->input->post('gambar'), -3) != 'ong'){
        // }else{
         
        // }
        for ($i=0; $i < count($idTipeBerita) ; $i++) { 
             $result1 =mysql_query( "insert into news_type_news values ('$idBaru','$idTipeBerita[$i]')");
        }
             
        // cek data udah masuk belum
        if ($result && $result1) {
            // kalo sukses
            $response["success"] = 1;
            $response["message"] = "Pendaftaran anda berhasil";
            $response["idBerita"] = $idBaru;
             $response["judul"] = $_POST['judul'];
        $response["alamat"] = $_POST['alamat'];
        $response["desk"] = $_POST['desk'];
         $response["idTipeBerita"] = $_POST['idTipeBerita'];
         $response["long"] = $_POST['long'];
          $response["lat"] = $_POST['lat'];

        } else {
            // fkalo gagal
            $response["success"] = 0;
            $response["message"] = "Sistem mendeteksi kesalahan, silahkan coba lagi";
            
       
        }
    }
    else {
        $response["success"] = 0;
        $response["message"] = "Silahkan lengkapi aksi sebelum memulai permintaan anda";
        $response["judul"] = $_POST['judul'];
        $response["alamat"] = $_POST['alamat'];
        $response["desk"] = $_POST['desk'];
         $response["idTipeBerita"] = $_POST['idTipeBerita'];
         $response["long"] = $_POST['long'];
          $response["lat"] = $_POST['lat'];


        // echoing JSON response
      
    }
      echo json_encode($response);

  }

 public function ajaxAdd()
  {
    $response = array();
  
    if ((isset($_POST['judul']) && isset($_POST['alamat']) && isset($_POST['desk']) && isset($_POST['idTipeBerita']) && isset($_POST['long'])&& isset($_POST['lat']) && isset($_POST['userId'])) && ( $_POST['judul']!="" && $_POST['alamat']!="" && $_POST['desk']!="" && $_POST['idTipeBerita']!="" && $_POST['long']!="" && $_POST['lat']!="" && $_POST['userId']!="" )) {
        
        $userId =$_POST['userId'];
        $judul = $_POST['judul'];
        $alamat = $_POST['alamat'];
        $path = $this->input->post('gambar');
        $desk = $_POST['desk'];
        $format = substr($this->input->post('gambar'), -3);
        $pLat = $_POST['lat'];
        $pLong = $_POST['long'];
        $idTipeBerita = $_POST['idTipeBerita'];
        $idTipeBerita = explode(',', $idTipeBerita);


        $data['id'] = $this->mnews->getId();
        foreach ($data['id'] as $key) {
          $idBaru = $key->newsId + 1;
        }
        date_default_timezone_set('Asia/Jakarta');
        $newsDate=date("Y-m-d H:i:s");
          if($path =="kosong"){
           $result = mysql_query("INSERT INTO news(ID, TITLE, ADDRESS, DESCRIPTION, IMAGE, LONGITUDE, LATITUDE , CREATED_BY, CREATED_AT, STATUS) VALUES('$idBaru', '$judul', '$alamat', '$desk','back.jpg','$pLong', '$pLat', '$userId', '$newsDate','HIDE')");
        }else{
          $result = mysql_query("INSERT INTO news(ID, TITLE, ADDRESS, DESCRIPTION, IMAGE, LONGITUDE, LATITUDE , CREATED_BY, CREATED_AT, STATUS) VALUES('$idBaru', '$judul', '$alamat', '$desk','$idBaru.$format','$pLong', '$pLat', '$userId', '$newsDate','SHOW')");
        }
        for ($i=0; $i < count($idTipeBerita) ; $i++) { 
             $result1 =mysql_query( "insert into news_type_news values ('$idBaru','$idTipeBerita[$i]')");
        }
             
        // cek data udah masuk belum
        if ($result && $result1) {
            // kalo sukses
            $response["success"] = 1;
            $response["message"] = "Pendaftaran anda berhasil";
            $response["idBerita"] = $idBaru;
             $response["judul"] = $_POST['judul'];
        $response["alamat"] = $_POST['alamat'];
        $response["desk"] = $_POST['desk'];
         $response["idTipeBerita"] = $_POST['idTipeBerita'];
         $response["long"] = $_POST['long'];
          $response["lat"] = $_POST['lat'];

        } else {
            // fkalo gagal
            $response["success"] = 0;
            $response["message"] = "Sistem mendeteksi kesalahan, silahkan coba lagi";
            
       
        }
    }
    else {
        $response["success"] = 0;
        $response["message"] = "Silahkan lengkapi aksi sebelum memulai permintaan anda";
        $response["judul"] = $_POST['judul'];
        $response["alamat"] = $_POST['alamat'];
        $response["desk"] = $_POST['desk'];
         $response["idTipeBerita"] = $_POST['idTipeBerita'];
         $response["long"] = $_POST['long'];
          $response["lat"] = $_POST['lat'];


        // echoing JSON response
      
    }
      echo json_encode($response);

  }

public function ajaxAddAS()
  {
    $response = array();
  
    if ((isset($_POST['judul']) && isset($_POST['alamat']) && isset($_POST['desk']) && isset($_POST['idTipeBerita']) && isset($_POST['long'])&& isset($_POST['lat']) && isset($_POST['userId'])) && ( $_POST['judul']!="" && $_POST['alamat']!="" && $_POST['desk']!="" && $_POST['idTipeBerita']!="" && $_POST['long']!="" && $_POST['lat']!="" && $_POST['userId']!="" )) {
        
        $userId =$_POST['userId'];
        $judul = $_POST['judul'];
        $alamat = $_POST['alamat'];
        $path = $this->input->post('gambar');
        $desk = $_POST['desk'];
        $format = substr($this->input->post('gambar'), -3);
        $pLat = $_POST['lat'];
        $pLong = $_POST['long'];
        $idTipeBerita = $_POST['idTipeBerita'];
        $idTipeBerita = explode(',', $idTipeBerita);
        $catBerita =$_POST['catBerita'];
        $provinsi =$_POST['provinsi'];
        $kota = $_POST['kota'];


        $data['id'] = $this->mnews->getId();
        foreach ($data['id'] as $key) {
          $idBaru = $key->newsId + 1;
        }
        date_default_timezone_set('Asia/Jakarta');
        $newsDate=date("Y-m-d H:i:s");
        
          $result = mysql_query("INSERT INTO news(ID, TITLE, ADDRESS,PROVINSI,KOTA,DESCRIPTION, IMAGE, LONGITUDE, LATITUDE , CREATED_BY, CREATED_AT, STATUS, CAT_BERITA) VALUES('$idBaru', '$judul', '$alamat','$provinsi','$kota', '$desk','$idBaru.$format','$pLong', '$pLat', '$userId', '$newsDate','HIDE', '$catBerita')");
        
        for ($i=0; $i < count($idTipeBerita) ; $i++) { 
             $result1 =mysql_query( "insert into news_type_news values ('$idBaru','$idTipeBerita[$i]')");
        }
             
        // cek data udah masuk belum
        if ($result && $result1) {
            // kalo sukses
            $response["success"] = 1;
            $response["message"] = "Pendaftaran anda berhasil";
            $response["idBerita"] = $idBaru;
             $response["judul"] = $_POST['judul'];
        $response["alamat"] = $_POST['alamat'];
        $response["desk"] = $_POST['desk'];
         $response["idTipeBerita"] = $_POST['idTipeBerita'];
         $response["long"] = $_POST['long'];
          $response["lat"] = $_POST['lat'];

        } else {
            // fkalo gagal
            $response["success"] = 0;
            $response["message"] = "Sistem mendeteksi kesalahan, silahkan coba lagi";
            
       
        }
    }
    else {
        $response["success"] = 0;
        $response["message"] = "Silahkan lengkapi aksi sebelum memulai permintaan anda";
        $response["judul"] = $_POST['judul'];
        $response["alamat"] = $_POST['alamat'];
        $response["desk"] = $_POST['desk'];
         $response["idTipeBerita"] = $_POST['idTipeBerita'];
         $response["long"] = $_POST['long'];
          $response["lat"] = $_POST['lat'];


        // echoing JSON response
      
    }
      echo json_encode($response);

  }
public function jsonType()
  {
    $data = $this->mnewstype->getData();
    $output = array(
            "data" => $data,
        );
    echo json_encode($output);
  }


public function getProvinsi()
  {
    $data = $this->mnewstype->getDataProvinsi();
    $output = array(
            "data" => $data,
        );
    echo json_encode($output);
  }

public function getKota($id)
  {
    $data = $this->mnewstype->getDataKota($id);
    $output = array(
            "data" => $data,
        );
    echo json_encode($output);
  }

    public function getNewsJSON()
    {
      if (isset($_GET['start']) &&  isset($_GET['limit'])){
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $data = $this->mnews->getData($limit,$start);
      }
      $output = array(
              "info" => $data,
          );
      echo json_encode($output);
    }


 public function getNewsJSONSlider()
    {
      if (isset($_GET['start']) &&  isset($_GET['limit'])){
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $data = $this->mnews->getDataSlider($limit,$start);
      }
      $output = array(
              "info" => $data,
          );
      echo json_encode($output);
    }

    public function getNewsJSONApproval()
    {
      if (isset($_GET['start']) &&  isset($_GET['limit'])){
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $data = $this->mnews->getDataApproval($limit,$start);
      }
      $output = array(
              "info" => $data,
          );
      echo json_encode($output);
    }


    public function getTelegramJSONBK()
    {
      if (isset($_GET['start']) &&  isset($_GET['limit'])){
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $data = $this->mtelegram->getData($limit,$start);
      }
      $output = array(
              "infotelegram" => $data,
          );
      echo json_encode($output);
    }

     public function getTelegramJSON()
    {
      if (isset($_GET['start']) &&  isset($_GET['limit'])){
        $start = $_GET['start'];
        $limit = $_GET['limit'];
        $data = array();
        $row = array();
        $list = $this->mtelegram->getData($limit,$start);
        $json = '{"infotelegram":[';
        $no;
        foreach ($list as $key) {
          $no++;
          $dataUser = $this->muser->getByTelp($key->TELP);
          $query = $this->db->query("select NAME as NAMA, USER_PHOTO from user where TELP = ".$key->TELP);
          $row = $query->row();
           if ($key->IMAGE == 'back.jpg'){
               if($query->num_rows() > 0)
                {
                     if($no == 1){
                        $json = $json.'{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($row->NAMA).',"USER_PHOTO":'.json_encode($row->USER_PHOTO).'}';
                       }else{
                        $json = $json.',{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($row->NAMA).',"USER_PHOTO":'.json_encode($row->USER_PHOTO).'}';
                      }
                       
                 }else{
                    if($no == 1){
                        $json = $json.'{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($key->CALLSIGN).',"USER_PHOTO":"back.jpg"}';
                       }else{
                        $json = $json.',{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($key->CALLSIGN).',"USER_PHOTO":"back.jpg"}';
                      }
                 }

            }else{
               if($query->num_rows() > 0)
                  {
                       if($no == 1){
                          $json = $json.'{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($row->NAMA).',"USER_PHOTO":'.json_encode($row->USER_PHOTO).'}';
                         }else{
                          $json = $json.',{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($row->NAMA).',"USER_PHOTO":'.json_encode($row->USER_PHOTO).'}';
                        }
                         
                   }else{
                      if($no == 1){
                          $json = $json.'{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($key->CALLSIGN).',"USER_PHOTO":"back.jpg"}';
                         }else{
                          $json = $json.',{"ID":'.json_encode($key->ID).',"TELP":'.json_encode($key->TELP).',"DESCRIPTION":'.json_encode($key->DESCRIPTION).',"IMAGE":'.json_encode($key->IMAGE).',"CALLSIGN":'.json_encode($key->CALLSIGN).',"DATE":'.json_encode($key->DATE).',"STATUS":'.json_encode($key->STATUS).',"NAMA":'.json_encode($key->CALLSIGN).',"USER_PHOTO":"back.jpg"}';
                        }
                   }

            }

          $data[] = $row;
        }
        
      }
      $json = $json.']}';
      echo ($json);
    }




    public function createMobileNews()
    {
        $statusSimpan ="add";
        $this->_validate();

        $data['id'] = $this->mnews->getId();
        foreach ($data['id'] as $key) {
            $idBaru = $key->newsId + 1;
        }
        date_default_timezone_set('Asia/Jakarta');
        $newsDate=date("Y-m-d H:i:s");

        if($this->input->post('gambar') !=''){
            $data = array(
                'ID' => $idBaru,
                'TELP' => $this->input->post('telp'),
                'IMAGE' => $idBaru.substr($this->input->post('gambar'), -4),
                'DESCRIPTION' => $this->input->post('desk'),
                'SUMBER' => "W",
                'CREATED_AT' => $newsDate,
                'CREATED_BY' =>  $this->input->post('callsign'),
            );
        }else{
            $data = array(
                'ID' => $idBaru,
                'TELP' => $this->input->post('telp'),
                'IMAGE' => 'back.jpg',
                'SUMBER' => "W",
                'DESCRIPTION' => $this->input->post('desk'),
                'CREATED_AT' => $newsDate,
                'CREATED_BY' =>  $this->input->post('callsign'),
            );
        }

        $insert = $this->mnews->save($data);
        // foreach($this->input->post('jenisBerita') as $jenis){
        // $this->mnewstypenews->save($idBaru,$jenis);
        // }
        echo json_encode(array("status" => "sukses", "idBerita" => $idBaru,"idBaru" => $idBaru, "success" => 1));
    }

    public function showData()
    {               
          $total_row = $this->mnews->rowCount();
          $list = $this->mnews->getData(6, 0);
            foreach ($list as $data) {
                if ($data->IMAGE == "back.jpg" && $data->SUMBER == 'T'){
                    echo('
                     
                     <li class="clearfix">
                          <div class="pull-right">
                              <div class="content-share">
                                <div class="social-share">
                                  <a title="Mengirim via telegram">
                                    <i class="fa fa-send"></i>
                                  </a>
                                </div>
                            </div>
                          </div>

                        <h5><a ><b>'.$data->CREATED_BY.'</b>&nbsp; "'.$data->DESCRIPTION.'"</a></h5>
                        <!-- <span class="post-date">'.$data->DESCRIPTION.'</span> -->
                        <p>
                          <span class="post-date">
                            <i class="fa fa-calendar">&nbsp;</i>'.$data->CREATED_AT.'
                          </span>
                          <span class="post-comment">
                            <i class="fa fa-phone"></i>
                            <a href="#" class="meta-comments">'.$data->TELP.'</a>
                          </span>
                        </p>
                      </li>
                    
                    ');
                }if ($data->IMAGE == "back.jpg" && $data->SUMBER == 'W'){
                    echo('
                       <li class="clearfix">
                          <div class="pull-right">
                              <div class="content-share">
                                <div class="social-share">
                                  <a title="Mengirim via website">
                                    <i class="fa fa-globe"></i>
                                  </a>
                                </div>
                            </div>
                          </div>
                        
                        <h5><a ><b>'.$data->CREATED_BY.'</b>&nbsp; "'.$data->DESCRIPTION.'"</a></h5>
                        <!-- <span class="post-date">'.$data->DESCRIPTION.'</span> -->
                        <p>
                          <span class="post-date">
                            <i class="fa fa-calendar">&nbsp;</i>'.$data->CREATED_AT.'
                          </span>
                          <span class="post-comment">
                            <i class="fa fa-phone"></i>
                            <a href="#" class="meta-comments">'.$data->TELP.'</a>
                          </span>
                        </p>
                      </li>
                    
                    ');
                }if ($data->IMAGE == "back.jpg" && $data->SUMBER == 'S'){
                    echo('
                       <li class="clearfix">
                          <div class="pull-right">
                              <div class="content-share">
                                <div class="social-share">
                                  <a title="Mengirim via SMS">
                                    <i class="fa fa-envelope"></i>
                                  </a>
                                </div>
                            </div>
                          </div>

                        <h5><a ><b>'.$data->CREATED_BY.'</b>&nbsp; "'.$data->DESCRIPTION.'"</a></h5>
                        <!-- <span class="post-date">'.$data->DESCRIPTION.'</span> -->
                        <p>
                          <span class="post-date">
                            <i class="fa fa-calendar">&nbsp;</i>'.$data->CREATED_AT.'
                          </span>
                          <span class="post-comment">
                            <i class="fa fa-phone"></i>
                            <a href="#" class="meta-comments">'.$data->TELP.'</a>
                          </span>
                        </p>
                      </li>
                    ');
                }

                 if ($data->IMAGE != "back.jpg" && $data->SUMBER == 'T'){
                    echo('
                     
                     <li class="clearfix">
                          <div class="pull-right">
                              <div class="content-share">
                                <div class="social-share">
                                  <a title="Mengirim via telegram">
                                    <i class="fa fa-send"></i>
                                  </a>
                                </div>
                            </div>
                          </div>
                          <a href="'.base_url().'public/front/images/berita/big/'.$data->IMAGE.'">
                         <img width="100" height="100" src="'.base_url().'public/front/images/berita/big/'.$data->IMAGE.'" alt=""/> </a>
                          <h5><a ><b>'.$data->CREATED_BY.'</b></a></h5>
                          <p>
                            <span class="post-date">
                              <i class="fa fa-calendar">&nbsp;</i>'.$data->CREATED_AT.' 
                            </span>
                            <span class="post-comment">
                              <i class="fa fa-phone"></i>
                              <a href="#" class="meta-comments">'.$data->TELP.' </a>
                            </span>
                          </p>
                        </li>
                    
                    ');
                }if ($data->IMAGE != "back.jpg" && $data->SUMBER == 'W'){
                    echo('
                       <li class="clearfix">
                          <div class="pull-right">
                              <div class="content-share">
                                <div class="social-share">
                                  <a title="Mengirim via website">
                                    <i class="fa fa-globe"></i>
                                  </a>
                                </div>
                            </div>
                          </div>

                            <a href="'.base_url().'public/front/images/berita/big/'.$data->IMAGE.'">
                         <img width="100" height="100" src="'.base_url().'public/front/images/berita/big/'.$data->IMAGE.'" alt=""/> </a>
                          <h5><a ><b>'.$data->CREATED_BY.'</b>&nbsp; "'.$data->DESCRIPTION.'"</a></h5>
                          <p>
                            <span class="post-date">
                              <i class="fa fa-calendar">&nbsp;</i>'.$data->CREATED_AT.' 
                            </span>
                            <span class="post-comment">
                              <i class="fa fa-phone"></i>
                              <a href="#" class="meta-comments">'.$data->TELP.' </a>
                            </span>
                          </p>
                        </li>
                    
                    ');
                }if ($data->IMAGE != "back.jpg" && $data->SUMBER == 'S'){
                    echo('
                       <li class="clearfix">
                          <div class="pull-right">
                              <div class="content-share">
                                <div class="social-share">
                                  <a title="Mengirim via SMS">
                                    <i class="fa fa-envelope"></i>
                                  </a>
                                </div>
                            </div>
                          </div>

                            <a href="'.base_url().'public/front/images/berita/big/'.$data->IMAGE.'">
                         <img width="100" height="100" src="'.base_url().'public/front/images/berita/big/'.$data->IMAGE.'" alt=""/> </a>
                          <h5><a ><b>'.$data->CREATED_BY.'</b></a></h5>
                          <p>
                            <span class="post-date">
                              <i class="fa fa-calendar">&nbsp;</i>'.$data->CREATED_AT.' 
                            </span>
                            <span class="post-comment">
                              <i class="fa fa-phone"></i>
                              <a href="#" class="meta-comments">'.$data->TELP.' </a>
                            </span>
                          </p>
                        </li>
                    
                    ');
                }
            }
    }

   
    function locationImageUpload()
    {  

        $this->load->library('image_lib');
        $url = './public/images/berita/';    //path image 
        if($_FILES['gambar']['error']==4)  //if No file was uploaded. 
            return false;        
        $config['upload_path'] = $url."original/";        
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = TRUE;
       
        $config['file_name'] = $_POST['newsId'];
        
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if( $this->upload->do_upload('gambar') )
        {    
            $files = $this->upload->data();
            $fileNameResize = $config['upload_path'].$files['file_name'];
            $size =  array(                
                        array('name'    => 'avatar','width'    => 30, 'height'    => 30, 'quality'    => '100%'),
                        array('name'    => 'big','width'    =>1024, 'height'    => 1024, 'quality'    => '100%')
                    );
            $resize = array();
            foreach($size as $r){                
                $resize = array(
                    "width"         => $r['width'],
                    "height"        => $r['height'],
                    "quality"       => $r['quality'],
                    "source_image"  => $fileNameResize,
                    "new_image"     => $url.$r['name'].'/'.$files['file_name']
                );
                $this->image_lib->initialize($resize); 
                if(!$this->image_lib->resize())                    
                die($this->image_lib->display_errors());
            }            
            // echo "resize oke";

        } 
        else{ 
            $status="errorUpload";
            $msg = $this->upload->display_errors();
        }    
        $filename = $_POST['newsId'];
          if (file_exists('public/images/berita/original/' . $filename.'.jpg')) {
             unlink('public/images/berita/original/' . $filename.'.jpg'); 
          } 
          else if (file_exists('public/images/berita/original/' . $filename.'.png')) {
             unlink('public/images/berita/original/' . $filename.'.png'); 
          }    
          else if (file_exists('public/images/berita/original/' . $filename.'.gif')) {
             unlink('public/images/berita/original/' . $filename.'.gif'); 
          }    
          else if (file_exists('public/images/berita/original/' . $filename.'.jpeg')) {
             unlink('public/images/berita/original/' . $filename.'.jpeg'); 
          }     
          // echo json_encode(array('status' => $status, 'msg' => $msg));
    }


   
  public function newsImageUpload()
  {   
 
    $status = "";
    $msg = "";      
        $this->load->library('image_lib');
        $url = './public/images/berita/'; 
        if($_FILES['uploaded_file']['error']==4)  //if No file was uploaded. 
            return false;        
        $config['upload_path'] = $url."original/";        
        $config['allowed_types'] = '*';
        $config['overwrite'] = TRUE;
       
        $config['file_name'] = $_GET['IMG_NAME'];
        
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if( $this->upload->do_upload('foto') )
        {    
            $files = $this->upload->data();
            $fileNameResize = $config['upload_path'].$files['file_name'];
            $size =  array(                
                        array('name'    => 'avatar','width'    => 29, 'height'    => 29, 'quality'    => '100%'),
                        // array('name'    => 'big','width'    =>900, 'height'    => 900, 'quality'    => '100%'),
                        array('name'    => 'big','width'    =>1240, 'height'    => 1240, 'quality'    => '100%')
                    );
            $resize = array();
            foreach($size as $r){                
                $resize = array(
                    "width"         => $r['width'],
                    "height"        => $r['height'],
                    "quality"       => $r['quality'],
                    "source_image"  => $fileNameResize,
                    "new_image"     => $url.$r['name'].'/'.$files['file_name']
                );
                $this->image_lib->initialize($resize); 
                if(!$this->image_lib->resize())                    
                    die($this->image_lib->display_errors());
            }            
            echo "resize oke";

        } 
        else{ 
          $status="errorUpload";
          $msg = $this->upload->display_errors();
        }    
        $filename = $imgName;
      if (file_exists('public/images/berita/original/'. $filename.'.jpg')) {
         unlink('public/images/berita/original/'. $filename.'.jpg'); 
      } 
      else if (file_exists('public/images/berita/original/'. $filename.'.png')) {
         unlink('public/images/berita/original/'. $filename.'.png'); 
      }    
      else if (file_exists('public/images/berita/original/'. $filename.'.gif')) {
         unlink('public/images/berita/original/'. $filename.'.gif'); 
      }    
      else if (file_exists('public/images/berita/original/'. $filename.'.jpeg')) {
         unlink('public/images/berita/original/'. $filename.'.jpeg'); 
      }     
          echo json_encode(array('status' => $status, 'msg' => $msg));
    }





    public function newsVideoUpload()
    {   
   
  move_uploaded_file($_FILES['foto']['tmp_name'], "./public/videos/berita/" .$_GET['IMG_NAME'].".". substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.')+1));
         echo json_encode("success");

      
      }




       public function imageUpload()
  {   
 
    $status = "";
    $msg = "";      
        $this->load->library('image_lib');
        $url = './public/images/berita/'; 
        if($_FILES['uploaded_file']['error']==4)  //if No file was uploaded. 
            return false;        
        $config['upload_path'] = $url."original/";        
        $config['allowed_types'] = 'gif|jpg|png';
        $config['overwrite'] = TRUE;
       
        $config['file_name'] = $_GET['IMG_NAME'];
        
        $this->load->library('upload');
        $this->upload->initialize($config);
        
        if( $this->upload->do_upload('foto') )
        {    
            $files = $this->upload->data();
            $fileNameResize = $config['upload_path'].$files['file_name'];
            $size =  array(                
                        array('name'    => 'avatar','width'    => 29, 'height'    => 29, 'quality'    => '100%'),
                        // array('name'    => 'big','width'    =>900, 'height'    => 900, 'quality'    => '100%'),
                        array('name'    => 'big','width'    =>1240, 'height'    => 1240, 'quality'    => '100%')
                    );
            $resize = array();
            foreach($size as $r){                
                $resize = array(
                    "width"         => $r['width'],
                    "height"        => $r['height'],
                    "quality"       => $r['quality'],
                    "source_image"  => $fileNameResize,
                    "new_image"     => $url.$r['name'].'/'.$files['file_name']
                );
                $this->image_lib->initialize($resize); 
                if(!$this->image_lib->resize())                    
                    die($this->image_lib->display_errors());
            }            
            echo "resize oke";

        } 
        else{ 
          $status="errorUpload";
          $msg = $this->upload->display_errors();
        }    
        $filename = $imgName;
      if (file_exists('public/images/berita/original/'. $filename.'.jpg')) {
         unlink('public/images/berita/original/'. $filename.'.jpg'); 
      } 
      else if (file_exists('public/images/berita/original/'. $filename.'.png')) {
         unlink('public/images/berita/original/'. $filename.'.png'); 
      }    
      else if (file_exists('public/images/berita/original/'. $filename.'.gif')) {
         unlink('public/images/berita/original/'. $filename.'.gif'); 
      }    
      else if (file_exists('public/images/berita/original/'. $filename.'.jpeg')) {
         unlink('public/images/berita/original/'. $filename.'.jpeg'); 
      }     
          echo json_encode(array('status' => $status, 'msg' => $msg));
    }

    public function imageUploads()
    {   
      if (isset($_FILES['gambar']) || isset($_POST['gambar'])) {
          // Example:
          move_uploaded_file($_FILES['gambar']['tmp_name'], "public/images/berita/big/" .$_POST['newsId']. substr($_FILES['gambar']['name'], -3));
          echo 'successful';
      }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['success'] = 1;

        if($this->input->post('callsign') == '')
        {
            $data['inputerror'][] = 'callsign';
            $data['error_string'][] = 'Sialhkan isi callsign';
            $data['success'] = 0;
        }

        if($this->input->post('telp') == '')
        {
            $data['inputerror'][] = 'telp';
            $data['error_string'][] = 'Silahkan isi Telepon';
            $data['success'] = 0;
        }

        if($this->input->post('desk') == '')
        {
            $data['inputerror'][] = 'desk';
            $data['error_string'][] = 'Silahkan isi deskripsi';
            $data['success'] = 0;
        }


        if($data['success'] == 0)
        {
            echo json_encode($data);
            exit();
        }
    }


     public function uploadImageVideoivUpload()
    {   
          move_uploaded_file($_FILES['foto']['tmp_name'], "./public/images/berita/big/" .$_POST['idBerita']. substr($_FILES['foto']['name'], strrpos($_FILES['foto']['name'], '.')+1));
         echo json_encode("success");
    }


    public function upload()
    {   
      if (isset($_FILES['myFile'])) {
          // Example:
          move_uploaded_file($_FILES['myFile']['tmp_name'], "public/images/berita/big/" . $_FILES['myFile']['name']);
          echo 'successful';
      }
    }

    public function uploadUser()
    {   
      if (isset($_FILES['myFile'])) {
          // Example:
          move_uploaded_file($_FILES['myFile']['tmp_name'], "public/images/user/big/" . $_FILES['myFile']['name']);
          echo 'successful';
      }
    }


    

    public function login()
   { 

    $response = array();
  
        
      $userName =$_POST['user'];
      $password = $_POST['password'];
      $query = $this->db->query("select USER_ID, USERNAME, NAME, USER_PHOTO,TELP,STATUS
                                FROM user WHERE USERNAME = 'admin' and PASSWORD = md5('admin') ");

            if($query->num_rows() > 0)
            {
              $row = $query->row();
              $response["success"] = 1;
              $response["message"] = "Ada";
              $response["username"] = $row->USERNAME;
              $response["nama"] = $row->NAME;
              $response["userphoto"] = $row->USER_PHOTO;
              $response["telp"] = $row->TELP;
              $response["status"] = $row->STATUS;
              $response["id"] = $row->USER_ID;
            
            }else{
              $response["success"] = 0;
              $response["message"] = "Tidak Ada";
            }
      
    
   
    echo json_encode($response);


  }

  public function addUser()
  {
    if(isset($_POST['nama']) && isset($_POST['username']) && isset($_POST['password'])){
      
      $format = $_POST['format'];
      $userName =$_POST['username'];
      $query = $this->db->query("select USER_ID FROM user WHERE USERNAME = "."'".$userName."'");
          if($query->num_rows() > 0)
          {
            $response["success"] = 3;
            $response["message"] = "Tidak Ada";
            $response["idUser"] = 0;
          }else{
            $data['id'] = $this->muser->getId();
            foreach ($data['id'] as $key) {
              $idBaru = $key->userId + 1;
            }
            $data = array(
                'USER_ID' => $idBaru,
                'NAME' => $this->input->post('nama'),
                'USER_PHOTO' => $idBaru.".".$format,
                'USERNAME' => $this->input->post('username'),
                'PASSWORD' => md5($this->input->post('password')),
                'STATUS' => '1',
              );

              $insert = $this->muser->save($data);
              $response["success"] = 1;
              $response["message"] = "Ada";
              $response["idUser"] = $idBaru;
          }
    }
    else{
      $response["success"] = 0;
      $response["message"] = "Tidak Ada";
      $response["idUser"] = 0;
    }
    echo json_encode($response);
  }

  public function updateUser()
  {
    if(isset($_POST['nama']) && isset($_POST['id'])){

      // if ($_POST['format'] == "" || !isset($_POST['format'])){
      //    $data = array(
      //       'NAME' => $this->input->post('nama'),
      //      );
      //  }else{
           $data = array(
            'NAME' => $this->input->post('nama'),
            // 'USER_PHOTO' => $this->input->post('id').".jpg",
           );
       // }
            
        $nama;
        $foto;


        $this->muser->update(array('USER_ID' => $this->input->post('id')), $data);
        $query = $this->muser->getById($this->input->post('id'));
        // foreach ($query as $key) {
          $nama = $query->NAME;
          $foto = $query->USER_PHOTO;
        // }
          $response["success"] = 1;
          $response["message"] = "Ada";
          $response["idUser"] =  $this->input->post('id');
          $response["nama"] =  $nama;
          $response["foto"] = $foto;
    }else{
      $response["success"] = 0;
      $response["message"] = "Tidak Ada";
      $response["idUser"] = 0;
   }
    echo json_encode($response);
  }

 public function updateAkunUser()
  {
    if(isset($_POST['nama']) != "" || isset($_POST['id']) != "") {
       $ptn = "/^0/";  // Regex
       $str = $this->input->post('telepon'); 
       $rpltxt = "62"; 

          $userName =$_POST['username'];
           $data['id'] = $this->muser->getIdPass($this->input->post('id'));
                  foreach ($data['id'] as $key) {
                    $password = $key->PASSWORD;
                    $uname = $key->USERNAME;
                  }

                  if($uname!=$_POST['username']){
                     $query = $this->db->query("select USER_ID FROM user WHERE USERNAME = '".$userName."'");
                      if($query->num_rows() > 0)
                      {
                        $response["success"] = 3;
                        $response["message"] = "Username sudah digunakan";
                        $response["idUser"] = $this->input->post('id')." & ".$uname." & ".$_POST['username'];
                        echo json_encode($response);
                        exit();
                      }else{
                        
                          $id = $this->input->post('id');
                            if ($password == md5($this->input->post('password'))){
                               if ($this->input->post('konpasswordbaru') == $this->input->post('passwordbaru')){
                                  
                                  if ($password == md5($this->input->post('passwordbaru'))){
                                    $data = array(
                                    'NAME' => $this->input->post('nama'),
                                    'USERNAME' => $this->input->post('username'),
                                    'TELP' => preg_replace($ptn, $rpltxt, $str),
                                    );
                                  }else{
                                      if( $_POST['konpasswordbaru'] != "" || $_POST['passwordbaru'] != ""){
                                       $data = array(
                                        'NAME' => $this->input->post('nama'),
                                        'USERNAME' => $this->input->post('username'),
                                        'TELP' => preg_replace($ptn, $rpltxt, $str),
                                        'PASSWORD' => md5($this->input->post('passwordbaru')),
                                      );
                                    }else{
                                      $data = array(
                                        'NAME' => $this->input->post('nama'),
                                        'USERNAME' => $this->input->post('username'),
                                        'TELP' => preg_replace($ptn, $rpltxt, $str),
                                      );
                                    }
                                  }
                                   $this->muser->update(array('USER_ID' => $this->input->post('id')), $data);
                                    $query = $this->muser->getById($this->input->post('id'));
                                      $response["success"] = 1;
                                      $response["message"] = "Akun berhasil dirubah".$_POST['konpasswordbaru'].$_POST['passwordbaru'];
                                      $response["idUser"] =  $this->input->post('id');
                                      $response["nama"] = $query->NAME;
                                      $response["foto"] = $query->USER_PHOTO;
                                      $response["telp"] = $query->TELP;
                                      $response["status"] = $query->STATUS;
                                      echo json_encode($response);
                                      exit();

                                }else{
                                    $response["success"] = 0;
                                    $response["message"] = "Password baru dan konfirmasi password tidak sama";
                                    $response["idUser"] = 0;
                                    echo json_encode($response);
                                    exit();
                                }

                               
                            }else{
                                $response["success"] = 0;
                                $response["message"] = "Silahkan input password lama Anda dengan benar";
                                $response["idUser"] = 0;
                                $response["passlama"] =$password." dan ".md5($this->input->post('password'));
                                echo json_encode($response);
                                exit();
                            }
                      }
                  }else{
                          $id = $this->input->post('id');
                            if ($password == md5($this->input->post('password'))){
                               if ($this->input->post('konpasswordbaru') == $this->input->post('passwordbaru')){
                                  
                                  if ($password == md5($this->input->post('passwordbaru'))){
                                    $data = array(
                                    'NAME' => $this->input->post('nama'),
                                    'USERNAME' => $this->input->post('username'),
                                    'TELP' => preg_replace($ptn, $rpltxt, $str),
                                    );
                                  }else{
                                      if( $_POST['konpasswordbaru'] != "" || $_POST['passwordbaru'] != ""){
                                       $data = array(
                                        'NAME' => $this->input->post('nama'),
                                        'USERNAME' => $this->input->post('username'),
                                        'TELP' => preg_replace($ptn, $rpltxt, $str),
                                        'PASSWORD' => md5($this->input->post('passwordbaru')),
                                      );
                                    }else{
                                      $data = array(
                                        'NAME' => $this->input->post('nama'),
                                        'USERNAME' => $this->input->post('username'),
                                        'TELP' =>preg_replace($ptn, $rpltxt, $str),
                                      );
                                    }
                                  }
                                    $this->muser->update(array('USER_ID' => $this->input->post('id')), $data);
                                    $query = $this->muser->getById($this->input->post('id'));
                                      $response["success"] = 1;
                                      $response["message"] = "Akun berhasil dirubah".$_POST['konpasswordbaru'].$_POST['passwordbaru'];
                                      $response["idUser"] =  $this->input->post('id');
                                      $response["nama"] = $query->NAME;
                                      $response["foto"] = $query->USER_PHOTO;
                                      $response["telp"] = $query->TELP;
                                      $response["status"] = $query->STATUS;
                                      echo json_encode($response);
                                       exit();

                                }else{
                                    $response["success"] = 0;
                                    $response["message"] = "Password baru dan konfirmasi password tidak sama";
                                    $response["idUser"] = 0;
                                    echo json_encode($response);
                                    exit();
                                }

                               
                            }else{
                                $response["success"] = 0;
                                $response["message"] = "Silahkan input password lama Anda dengan benar";
                                $response["idUser"] = 0;
                                $response["passlama"] =$password." dan ".md5($this->input->post('password'));
                                echo json_encode($response);
                                exit();
                            }

                  }
             
    }else{
      $response["success"] = 0;
      $response["message"] = "Lengkapi pengisian form";
      $response["idUser"] = 0;
      echo json_encode($response);
      exit();
   }
    
  }


  public function updateAkunUserTidakDipakai()
  {
    if($_POST['nama'] != "" || $_POST['id'] != ""  ){
          $userName =$_POST['username'];
           $data['id'] = $this->muser->getIdPass($this->input->post('id'));
                  foreach ($data['id'] as $key) {
                    $password = $key->PASSWORD;
                    $uname = $key->USERNAME;
                  }

                  if($uname!=$_POST['username']){
                     $query = $this->db->query("select USER_ID FROM user WHERE USERNAME = '".$userName."' AND USERNAME <> '".$uname."'");
                      if($query->num_rows() > 0)
                      {
                        $response["success"] = 3;
                        $response["message"] = "Username sudah digunakan";
                        $response["idUser"] = $uname." & ".$_POST['username'];
                        echo json_encode($response);
                        exit();
                      }else{
                        
                          $id = $this->input->post('id');
                            if ($password == md5($this->input->post('password'))){
                               if ($this->input->post('konpasswordbaru') == $this->input->post('passwordbaru')){
                                  
                                  if ($password == md5($this->input->post('passwordbaru'))){
                                    $data = array(
                                    'NAME' => $this->input->post('nama'),
                                    'USERNAME' => $this->input->post('username'),
                                    'TELP' => $this->input->post('telepon'),
                                    );
                                  }else{
                                    if( $_POST['konpasswordbaru'] != "" || $_POST['passwordbaru'] != ""){
                                       $data = array(
                                        'NAME' => $this->input->post('nama'),
                                        'USERNAME' => $this->input->post('username'),
                                        'TELP' => $this->input->post('telepon'),
                                        'PASSWORD' => md5($this->input->post('passwordbaru')),
                                      );
                                    }else{
                                      $data = array(
                                        'NAME' => $this->input->post('nama'),
                                        'USERNAME' => $this->input->post('username'),
                                        'TELP' => $this->input->post('telepon'),
                                      );
                                    }

                                     
                                  }
                                   $this->muser->update(array('USER_ID' => $this->input->post('id')), $data);
                                    $query = $this->muser->getById($this->input->post('id'));
                                      $response["success"] = 1;
                                      $response["message"] = "Akun berhasil dirubah";
                                      $response["idUser"] =  $this->input->post('id');
                                      $response["nama"] = $query->NAME;
                                      $response["foto"] = $query->USER_PHOTO;
                                      $response["telp"] = $query->TELP;
                                      $response["status"] = $query->STATUS;
                                      echo json_encode($response);
                                      exit();

                                }else{
                                    $response["success"] = 0;
                                    $response["message"] = "Password baru dan konfirmasi password tidak sama";
                                    $response["idUser"] = 0;
                                    echo json_encode($response);
                                    exit();
                                }

                               
                            }else{
                                $response["success"] = 0;
                                $response["message"] = "Silahkan input password lama Anda dengan benar";
                                $response["idUser"] = 0;
                                $response["passlama"] =$password." dan ".md5($this->input->post('password'));
                                echo json_encode($response);
                                exit();
                            }
                      }
                  }else{
                          $id = $this->input->post('id');
                            if ($password == md5($this->input->post('password'))){
                               if ($this->input->post('konpasswordbaru') == $this->input->post('passwordbaru')){
                                  
                                  if ($password == md5($this->input->post('passwordbaru'))){
                                    $data = array(
                                    'NAME' => $this->input->post('nama'),
                                    'USERNAME' => $this->input->post('username'),
                                    'TELP' => $this->input->post('telepon'),
                                    );
                                  }else{
                                      $data = array(
                                      'NAME' => $this->input->post('nama'),
                                      'USERNAME' => $this->input->post('username'),
                                      'TELP' => $this->input->post('telepon'),
                                      'PASSWORD' => md5($this->input->post('passwordbaru')),
                                    );
                                  }
                                    $this->muser->update(array('USER_ID' => $this->input->post('id')), $data);
                                    $query = $this->muser->getById($this->input->post('id'));
                                      $response["success"] = 1;
                                      $response["message"] = "Akun berhasil dirubah";
                                      $response["idUser"] =  $this->input->post('id');
                                      $response["nama"] = $query->NAME;
                                      $response["foto"] = $query->USER_PHOTO;
                                      $response["telp"] = $query->TELP;
                                      $response["status"] = $query->STATUS;
                                      echo json_encode($response);
                                       exit();

                                }else{
                                    $response["success"] = 0;
                                    $response["message"] = "Password baru dan konfirmasi password tidak sama";
                                    $response["idUser"] = 0;
                                    echo json_encode($response);
                                    exit();
                                }

                               
                            }else{
                                $response["success"] = 0;
                                $response["message"] = "Silahkan input password lama Anda dengan benar";
                                $response["idUser"] = 0;
                                $response["passlama"] =$password." dan ".md5($this->input->post('password'));
                                echo json_encode($response);
                                exit();
                            }

                  }
             
    }else{
      $response["success"] = 0;
      $response["message"] = "Lengkapi pengisian form";
      $response["idUser"] = 0;
      echo json_encode($response);
      exit();
   }
    
  }


  public function getNewsJSONID()
  {
    if (isset($_GET['id'])){
      $id = $_GET['id'];
      $data = $this->mnews->getNewsJSONID($id);
    }
    $output = array(
            "info" => $data,
        );
    echo json_encode($output);
  }



  public function jsonTypeID($id)
  {
    if (isset($_GET['id'])){
      $id = $_GET['id'];
      $data = $this->mnewstype->getDataDetail($id);
    }
    $output = array(
            "info" => $data,
        );
    echo json_encode($output);
  }

  public function getPSJSONID()
  {
    if (isset($_GET['latit']) && isset($_GET['longit'])){
      $latit = $_GET['latit'];
      $longit = $_GET['longit'];
      $data = $this->mpolicestation->getPSJSONID($latit,$longit);
    }
    $output = array( 
            "info" => $data,
        );
    echo json_encode($output);
  }

  


}