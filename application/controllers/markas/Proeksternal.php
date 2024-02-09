<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proeksternal extends CI_Controller {
  private $filename = "import_data"; // Kita tentukan nama filenya

	public function __construct() {
		parent::__construct();
		$this->load->model('dbcore1','',TRUE);
    $this->load->model('dbeksternal','',TRUE);
    $this->load->model('akuntansi','',TRUE);
    $this->load->model('transisi','',TRUE);
		$this->load->model('person_model','',TRUE);
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

}
