<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth,User-Agent, X-File-Size, X-Requested-With, If-Modified-Since,X-File-Name, Cache-Control");

defined('BASEPATH') OR exit('No direct script access allowed');

class Proeksternal extends CI_Controller {
  private $filename = "import_data"; // Kita tentukan nama filenya

	public function __construct() {
		parent::__construct();
		$this->load->model('dbcore1','',TRUE);
    $this->load->model('dbeksternal','',TRUE);
    $this->load->model('akuntansi','',TRUE);
		$this->load->helper('url','form');
	}

	public function index() {
//    $data['siswa'] = $this->SiswaModel->view();
//    $this->load->view('view', $data);

    $rmoda = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'';
    $idpeg = $this->session->userdata('pgpid');
    $akpeg = $this->session->userdata('pgakses');
    if(!isset($_GET['kodejob1'])){
      $akpeg1 = $akpeg;
    } else {
      $akpeg1 = $_GET['kodejob1'];
    }
    $supeg = $this->session->userdata('pgsu');
    switch ($akpeg) {
      case '111':
      $vtitle = 'Kepegawaian';
      break;

      case '222':
      $vtitle = 'Administrasi';
      break;

      default:
      $vtitle = 'Pasien RM';
      break;
    }
    if($idpeg!='') {
//          $idpeg = $this->session->userdata('pgpid');
$thn = date("Y");
$hrni = date("Y-m-d");
        $data = array(
            'qtitle' => $vtitle,
            'rmmod' => $rmoda,
            'hasil' => '',
            'periksa' => '',
            'operator' => $this->dbcore1->caripeg($idpeg),
            'kodejob' => $akpeg,
            'kodejob1' => $akpeg1,
            'kodesu' => $supeg,
            'dafkodejur' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->carikodejur():'',
            'pjenis' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_ka5('L'):'',
            'dkpoli' => $this->transisi->get_dkpoli(),
            'dkbangsal' => '',
            'jjenis' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis():'',
//            'jjenis2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis2():'',
            'jka1' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka1():'',
            'jka2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka2():'',
            'jka3' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka3():'',
            'jka4' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka4():'',
            's1' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->j_hit():'',
            's2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->t_hit():'',
            'akses' => $idpeg,
//            'cgroup' => $this->pecahcgroup($akpeg),
//            'cekabsen' => $this->absen_model->cek_data_absen($hrni),
            'grbardeb' => $this->akuntansi->get_info($thn.'paktrx_jum'),
            'grbarkre' => $this->akuntansi->get_info($thn.'qaktrx_jum'),
            'idpeg' => $idpeg
        );
        $this->load->view('backoff/rm_infor',$data);
    } else {
        $this->load->view('frontoff/login');
    }
  }

  public function proses() {
    $config['upload_path'] = './dapur0/semstorage/';
    $config['allowed_types'] = 'xls';
    $config['max_size'] = '10000';
    $this->load->library('upload', $config);

    if ( $this->upload->do_upload('file')) {
      $upload_data = $this->upload->data();

      $this->load->library('Excel_reader');

      $this->excel_reader->setOutputEncoding('230787');
      $file = $upload_data['full_path'];
      $this->excel_reader->read($file);
      error_reporting(E_ALL ^ E_NOTICE);

      $data = $this->excel_reader->sheets[0];
      $dataexcel = Array();
      for ($i = 1; $i <= $data['numRows']; $i++) {
        if ($data['cells'][$i][2] == '')
        break;
        $dataexcel[$i - 1]['ecol1'] = $data['cells'][$i][1];
        $dataexcel[$i - 1]['ecol2'] = $data['cells'][$i][3];
        //                 $dataexcel[$i - 1]['ecol2'] = date('Y-m-d',strtotime($data['cells'][$i][3]));
        $dataexcel[$i - 1]['ecol3'] = $data['cells'][$i][4];
        $dataexcel[$i - 1]['ecol4'] = $data['cells'][$i][5];
        $dataexcel[$i - 1]['ecol5'] = str_replace('/','.',$data['cells'][$i][6]);
        $dataexcel[$i - 1]['ecol6'] = $data['cells'][$i][7];
        $dataexcel[$i - 1]['ecol7'] = $data['cells'][$i][8];
        $dataexcel[$i - 1]['ecol8'] = $data['cells'][$i][9];
      }

      $this->load->model('dbeksternal');
      $this->dbeksternal->loaddata($dataexcel);

      $file = $upload_data['file_name'];
      $path = './dapur0/semstorage/' . $file;
      unlink($path);
    }
    //          $this->dbeksternal->cdataexcel();
    /*          $isiexcel = $this->dbeksternal->cdataexcel();
    foreach ($isiexcel as $iexc) {
    # code...
    }
    */
    redirect('markas/core1/?rmod=area2','refresh');
  }

  function exjson(){
    $cekusr = $this->dbcore1->routekey(get_cookie('simcek1'),'d');
    $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('jspil',$this->dbcore1->routekey($cekkop));
    $this->load->library('javascript');
    $path = './dapur0/semstorage/post/'.$cekkop.date('Ymdh').str_replace('.','',$cekusr).'.qbk';
    $path2 = $cekkop.date('Ymdh').str_replace('.','',$cekusr).'.qbk';
    //array induk
    $isidata = array();
    //array var_ka-5
    $isidata['arrvar_ka5'] = $this->akuntansi->jur_jenis3();
    //array var_jur
    $isidata['arrvar_jur'] = $this->akuntansi->jur_jenis_all();
    //array akun_jur
    $isidata['arrakn_jur'] = $this->akuntansi->exj_post();
    //array akun_trx
    $isidata['arrakn_trx'] = $this->akuntansi->ext_post();
    //array jur_posting
    $isidata['arrakn_post'] = $this->akuntansi->c_post();
    $cvdataisi = json_encode($isidata, JSON_PRETTY_PRINT);
    write_file($path,$this->dbcore1->routekey($cvdataisi),'wb');
    $defile = $this->dbcore1->routekey(read_file($path),'d');
//    write_file($path,$cvdataisi,'wb');
//    $defile = read_file($path);
    //$this->dbcore1->delcok('jspil');
//    $this->downex($path);

//$this->downex($path2);
echo $path2;
  }

  function download_plus_headers($filename)
  {
    // disable caching
  	$now = gmdate("D, d M Y H:i:s");
    header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
  	header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
  	header("Last-Modified: {$now} GMT");

  	// force download
  	header("Content-Type: application/force-download");
  	header("Content-Type: application/octet-stream");
  	header("Content-Type: application/download");
    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
    echo read_file('./dapur0/semstorage/post/'.$filename);

//    force_download('/dapur0/semstorage/post/'.$filename,NULL,TRUE);
  }

  function hpsback($filename){
    unlink('./dapur0/semstorage/post/'.$filename);
  }

  function imjson(){
    $cekusr = $this->dbcore1->routekey(get_cookie('simcek1'),'d');
    $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('jspil',$this->dbcore1->routekey($cekkop));
    $config['upload_path'] = './dapur0/semstorage/';
    $config['allowed_types'] = '*';
    $config['max_size'] = 0;
    $this->load->library('upload', $config);

    if ( $this->upload->do_upload('fileqbk')) {
      $upload_data = $this->upload->data();
      $path2 = './dapur0/semstorage/post/filerestore.bak';

      $file = $upload_data['file_name'];
      $path = './dapur0/semstorage/' . $file;
//      $defile = read_file($path);
      $defile = $this->dbcore1->routekey(read_file($path),'d');
      write_file($path2,$defile,'wb');
//      redirect('markas/core1/?rmod=area2','refresh');
//str_replace('[', '', str_replace(']', '', json_encode(json_decode($defile)->arrakn_post)));
$arrpost = str_replace('[', '', str_replace(']', '', json_encode(json_decode($defile)->arrakn_jur)));

$arrpost = json_decode($defile)->arrakn_jur;
$carrpost = array();
foreach ($arrpost as $ap) {
  $carrpost[] = $ap->akjur_nomor;
}
$this->akuntansi->clear_dataup($carrpost);

$tarrpost = json_decode($defile)->arrakn_jur;
foreach ($tarrpost as $apt) {
$tcarr = array(
  "akjur_nomor"=>$apt->akjur_nomor,
  "akjur_jns"=>$apt->akjur_jns,
  "akjur_tgl"=>$apt->akjur_tgl,
  "akjur_ket"=>$apt->akjur_ket,
  "akjur_sts"=>$apt->akjur_sts,
  "akjur_post"=>$apt->akjur_post,
  "akjur_akses"=>$apt->akjur_akses,
  "akjur_kopar"=>$apt->akjur_kopar
);
$this->akuntansi->insjur_dataup($tcarr);
}

$tarrpost = json_decode($defile)->arrakn_trx;
foreach ($tarrpost as $apt) {
$tcarr = array(
  "aktrx_nomor"=>$apt->aktrx_nomor,
  "aktrx_nojur"=>$apt->aktrx_nojur,
  "aktrx_nama"=>$apt->aktrx_nama,
  "aktrx_jns"=>$apt->aktrx_jns,
  "aktrx_ket"=>$apt->aktrx_ket,
  "aktrx_jum"=>(int)$apt->aktrx_jum,
  "aktrx_akses"=>$apt->aktrx_akses,
  "aktrx_mark"=>$apt->aktrx_mark,
  "aktrx_post"=>$apt->aktrx_post,
  "akjur_kopar"=>$apt->akjur_kopar
);
$this->akuntansi->instrx_dataup($tcarr);
}

$tarrpost = json_decode($defile)->arrakn_jur;
foreach ($tarrpost as $apt) {
$tcarr = array(
  "akjur_nomor"=>$apt->akjur_nomor,
  "akjur_jns"=>$apt->akjur_jns,
  "akjur_tgl"=>$apt->akjur_tgl,
  "akjur_ket"=>$apt->akjur_ket,
  "akjur_sts"=>$apt->akjur_sts,
  "akjur_post"=>0,
  "akjur_akses"=>$apt->akjur_akses,
  "akjur_kopar"=>$apt->akjur_kopar
);
$this->akuntansi->insjurpost_dataup($tcarr);
}

$tarrpost = json_decode($defile)->arrakn_trx;
foreach ($tarrpost as $apt) {
$tcarr = array(
  "aktrx_nomor"=>$apt->aktrx_nomor,
  "aktrx_nojur"=>$apt->aktrx_nojur,
  "aktrx_nama"=>$apt->aktrx_nama,
  "aktrx_jns"=>$apt->aktrx_jns,
  "aktrx_ket"=>$apt->aktrx_ket,
  "aktrx_jum"=>(int)$apt->aktrx_jum,
  "aktrx_akses"=>$apt->aktrx_akses,
  "aktrx_mark"=>$apt->aktrx_mark,
  "aktrx_post"=>0,
  "akjur_kopar"=>$apt->akjur_kopar
);
$this->akuntansi->instrxpost_dataup($tcarr);
}

      unlink($path);

redirect('markas/core1/?rmod=area2','refresh');


//$karrpost = $this->akuntansi->post_dataup($arrpost);
//redirect('markas/core1/?rmod=area2','refresh');
//echo json_encode($tcarr);



/* aman insert jur
*/
/* aman cek post jur+trx
$arrpost = json_decode($defile)->arrakn_post;
$carrpost = array();
foreach ($arrpost as $ap) {
  $carrpost[] = $ap->akjur_nomor;
}
$this->akuntansi->post_dataup($carrpost);
*/
//echo json_encode($testpost_j);
//      echo str_replace('[', '', str_replace(']', '', json_encode(json_decode($defile)->arrakn_post)));
//      unlink($path);
//return $this->downex($path);
    } else {
      redirect('markas/core1/?rmod=area1','refresh');
//echo 'FALSE';
    }

  }


  function downex($path){
    force_download($path,NULL,TRUE);
  }


}
