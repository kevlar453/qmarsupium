<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Core2 extends CI_Controller {


  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->model('absen_model','',TRUE);
    $this->load->model('akuntansi','',TRUE);
    $this->load->model('transisi','',TRUE);
    $this->load->helper('url','form');
//    $this->load->library('session');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
//      $this->output->enable_profiler(TRUE);
  }

    function index() {
        $rmoda = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'';
        $idpeg = $this->session->userdata('pgpid');
        $akpeg = $this->session->userdata('pgakses');
        $supeg = $this->session->userdata('pgsu');
        switch ($akpeg) {
          case '111':
          $vtitle = 'Kepegawaian';
          break;

          case '222':
          $vtitle = 'Keuangan';
          break;

          default:
          $vtitle = 'Pasien RM';
          break;
        }
        if($idpeg!='') {
          $thn = date("Y");
          $hrni = date("Y-m-d");
            $data = array(
                'qtitle' => $vtitle,
                'rmmod' => $rmoda,
                'hasil' => '',
                'periksa' => '',
                'operator' => $this->dbcore1->caripeg($idpeg),
                'kodejob' => $akpeg,
                'kodesu' => $supeg,
                'dafkodejur' => $akpeg=='222'?$this->akuntansi->carikodejur():'',
                'pjenis' => $akpeg=='222'?$this->akuntansi->get_ka5('L'):'',
                'dkpoli' => $this->transisi->get_dkpoli(),
                'dkbangsal' => '',
                'jjenis' => $akpeg=='222'?$this->akuntansi->jur_jenis():'',
                'jjenis2' => $akpeg=='222'?$this->akuntansi->jur_jenis2():'',
                's1' => $akpeg=='222'?$this->akuntansi->j_hit():'',
                's2' => $akpeg=='222'?$this->akuntansi->t_hit():'',
                'akses' => $idpeg,
                'cekabsen' => $this->absen_model->cek_data_absen($hrni),
                'grbardeb' => $this->akuntansi->get_info($thn.'paktrx_jum'),
                'grbarkre' => $this->akuntansi->get_info($thn.'qaktrx_jum')
            );
//            $this->absen_model->get_log_absen();

//            $this->absen_model->get_sts_absen();
            $this->load->view('backoff/rm_infor',$data);
          } elseif($rmoda=='xxx' && !$idpeg) {
            $data = array(
              'jumv1' => $this->dbcore1->cjv1(),
              'jumv2' => $this->dbcore1->cjv2(),
              'jumv3' => $this->dbcore1->cjv3(),
              'jumv4' => $this->dbcore1->cjv4(),
              'jumv5' => $this->dbcore1->cjv5(),
              'jumv6' => $this->dbcore1->cjv6(),
              'hdokter' => $this->dbcore1->cdokter()
            );
              $this->load->view('frontoff/_000/informasi',$data);
            } elseif($rmoda=='xxy' && !$idpeg) {
              $data = array(
                'jumv1' => $this->dbcore1->cjv1(),
                'jumv2' => $this->dbcore1->cjv2(),
                'jumv3' => $this->dbcore1->cjv3(),
                'jumv4' => $this->dbcore1->cjv4(),
                'jumv5' => $this->dbcore1->cjv5(),
                'jumv6' => $this->dbcore1->cjv6(),
                'hdokter' => $this->dbcore1->cdokter()
              );
                $this->load->view('frontoff/_000/info-000',$data);
          } else {
                $this->load->view('frontoff/login');
        }
    }

    function getdokter(){
      $crdok = $this->dbcore1->cdokter();
      foreach($crdok as $dok):
        echo '<h2>'.$dok['poliklinik'].' : </h2>';
        echo '<h1>'.$dok['dokter'].'</h1>';
        echo '<hr />';
        if($dok['poliklinik']){
          $this->load->model('dbcore1','',TRUE);
          $carant1 = strtolower($dok['poliklinik']);
          $carant2 = $dok['dokter'];
          $hant = $this->dbcore1->cantri($carant1,$carant2);
          if($hant){
            foreach($hant as $hslant){
              echo '<h2>antrian: '.$hslant['jumant'].'</h2><br />';
            }
          } else {
            echo '<h2>antrian: -</h2><br />';
          }
        }
      endforeach;
    }

    function show_login( $show_error = false ) {
        $data['error'] = $show_error;
        $this->load->view('frontoff/login',$data);
    }

    function login_user() {
        $this->load->model('dbcore1');
        $nik1 = $this->input->post('nik');
        $aks = $this->input->post('kdakses');
        if(strlen($nik1)==11 || strlen($nik1)==3){
            $nik = $nik1.$aks;
        } elseif(strlen($nik1)==9) {
            $nik = substr($nik1,0,4).'.'.substr($nik1,4,2).'.'.substr($nik1,6,3).$aks;
        } else {
          $nik='';
          redirect('/', 'refresh');
        }

        if(strlen($nik)==12){
        if($this->dbcore1->validate_user($nik)) {
            $idpeg = $this->session->userdata('pgpid');
            $akpeg = $this->session->userdata('pgakses');
            $supeg = $this->session->userdata('pgsu');
            $vtitle = $akpeg=='000'?'Pasien RM':'Akuntansi';
            $data = array(
                'qtitle' => $vtitle,
                'rmmod' => isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'',
                'hasil' => '',
                'periksa' => '',
                'operator' => $this->dbcore1->caripeg($idpeg),
                'kodejob' => $akpeg,
                'kodesu' => $supeg,
                'dafkodejur' => $akpeg=='222'?$this->akuntansi->carikodejur():'',
                'pjenis' => $akpeg=='222'?$this->akuntansi->get_ka5():'',
                'dkpoli' => $akpeg=='222'?$this->transisi->get_dkpoli():'',
                'jjenis' => $akpeg=='222'?$this->akuntansi->jur_jenis():'',
                'jjenis2' => $akpeg=='222'?$this->akuntansi->jur_jenis2():'',
                's1' => $akpeg=='222'?$this->akuntansi->j_hit():'',
                's2' => $akpeg=='222'?$this->akuntansi->t_hit():'',
                'akses' => $idpeg,
                'propinsi' => $this->dbmain->get('qvar_prop')
            );
            redirect('/', 'refresh');
//            $this->load->view('frontoff/rm_infor',$data);
        } else {
            $this->load->view('frontoff/login');
        }
      }
    }

    public function logout() {
        $sess_array = array(
            'set_value' => ''
        );

        $this->session->unset_userdata('pgpid', $sess_array);
        session_destroy();
        redirect('/', 'refresh');
    }

}
