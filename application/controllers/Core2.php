<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth,User-Agent, X-File-Size, X-Requested-With, If-Modified-Since,X-File-Name, Cache-Control");


//defined('BASEPATH') OR exit('No direct script access allowed');

class Core2 extends CI_Controller {


  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->model('absen_model','',TRUE);
    $this->load->model('akuntansi','',TRUE);
//    $this->load->model('transisi','',TRUE);
    $this->load->helper('url','form');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
  }

    function index() {
        $rmoda = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'';
        $idpeg = $this->session->userdata('pgpid');
        $akpeg = $this->session->userdata('pgakses');
        if(!isset($_GET['kodejob'])){
          $akpeg1 = $akpeg;
        } else {
          $akpeg1 = $_GET['kodejob'];
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
        if($idpeg!='' && $rmoda!='xxx' && $rmoda!='yyy') {
          $thn = date("Y");
//          $thn = '2017';
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
              'dafkodejur' => $akpeg=='222'?$this->akuntansi->carikodejur():'',
              'pjenis' => $akpeg=='222'?$this->akuntansi->get_ka5('L'):'',
//              'dkpoli' => $this->transisi->get_dkpoli(),
              'dkbangsal' => '',
              'jjenis' => $akpeg=='222'?$this->akuntansi->jur_jenis():'',
              'jjenis2' => $akpeg=='222'?$this->akuntansi->jur_jenis2():'',
              's1' => $akpeg=='222'?$this->akuntansi->j_hit():'',
              's2' => $akpeg=='222'?$this->akuntansi->t_hit():'',
              'akses' => $idpeg,
              'cgroup' => $this->dbcore1->get_peggroup($akpeg),
              'grbardeb' => $this->akuntansi->get_info($thn.'paktrx_jum'),
              'grbarkre' => $this->akuntansi->get_info($thn.'qaktrx_jum'),
              'idpeg' => $idpeg
            );
            $this->load->view('backoff/rm_infor',$data);
          } elseif($rmoda=='xxx' || $rmoda=='yyy') {
            if(!empty($this->session->userdata('pgpid'))) {
              $sess_array = array(
                  'set_value' => ''
              );
              $this->session->unset_userdata('pgpid', $sess_array);
              session_destroy();
              redirect('core2/?rmod=yyy', 'refresh');
            }
            $this->absen_model->get_act_absen();
            $this->absen_model->sar_act_absen();
            $data = array(
              'jumv1' => 0,
              'jumv2' => 0,
              'jumv3' => 0,
              'jumv4' => 0,
              'jumv5' => 0,
              'jumv6' => 0,
              'isiabsen' => $this->absen_model->get_isi_abs()
            );
            if($rmoda=='xxx') {
//              $this->load->view('frontoff/_000/informasi',$data);
              $this->load->view('frontoff/login');
            } elseif($rmoda=='yyy') {
              $this->load->view('frontoff/_000/info-000',$data);
            }
          } elseif($rmoda=='rrr') {
            $this->load->view('frontoff/login');
          } elseif($rmoda=='xyz') {
            $this->load->view('frontoff/loginy');
          } else  {
            $this->load->view('frontoff/login');
        }
    }

    function getpegawai($perunit = FALSE){
      $crdok = $this->absen_model->cpegawai($perunit);
      if($crdok){
        foreach($crdok as $dok):
          echo '<h2>'.$dok['temp3_unit'].' : </h2>';
          echo '<h1>'.$dok['temp3_nama'].'</h1>';
          echo '<hr />';
          if($dok['temp3_unit']){
            $this->load->model('dbcore1','',TRUE);
            $carant1 = strtolower($dok['temp3_unit']);
            $carant2 = $dok['temp3_nama'];
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
    }

    function getdokter($pol = FALSE){
      $crdok = $this->dbcore1->cdokter($pol);
      foreach($crdok as $dok):
        echo '<strong>'.strtoupper($dok['dokter']).' : </strong> ';
      endforeach;
    }

    function getdokantri($pol = FALSE){
      $this->load->model('dbcore1','',TRUE);
      $crdok = $this->dbcore1->cantri($pol);
          if($crdok){
            foreach($crdok as $hslant){
              echo $hslant['jumant'];
            }
          } else {
            echo 000;
          }
    }

    function getkamart($kmr = FALSE){
      $this->load->model('dbcore1','',TRUE);
      $crkmrt = $this->dbcore1->getkamartot($kmr);
          if($crkmrt){
            foreach($crkmrt as $ckmt){
              $crkmri = $this->dbcore1->getkamarisi($kmr);
              if($crkmri){
                foreach($crkmri as $ckmi){
                  $isi = $ckmi['jtksr'];
                }
              } else {
                $isi = 0;
              }
              echo $ckmt['jtksr'] - $isi;
            }
          } else {
            echo 0;
          }
    }

    function getkamari($kmr = FALSE){
      $this->load->model('dbcore1','',TRUE);
      $crkmrt = $this->dbcore1->getkamarisi($kmr);
          if($crkmrt){
            foreach($crkmrt as $ckmt){
              echo $ckmt['jtksr'];
            }
          } else {
            echo 0;
          }
    }

    function login_user() {
        $this->load->model('dbcore1');
        $nika = $this->input->post('nik');
        $nik1 = str_replace($this->dbcore1->routekey('SFl1eVZ0cFZ2LzNtK21FYUcxYVBJZz09','d'), '', $nika);
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
          if($idpeg == $this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d') && substr($nika,-6)!=$this->dbcore1->routekey('SFl1eVZ0cFZ2LzNtK21FYUcxYVBJZz09','d')){
            $datalog = array(
              'log_idpeg' => $idpeg,
              'log_ket' => 'Masuk dgn id: '.$idpeg.', ip: '.$this->dbcore1->get_client_ip()
            );
/*
$hcinet=$this->dbcore1->cinet();
if($hcinet){
$this->dbcore1->routedqt('**'.$this->dbcore1->routekey('WXVhb2lhMVN2S3psOUR4V0ZsNDR3SExuR1gxS0pNalJJSExhMjFPd3lRST0=','d').'** '.$this->dbcore1->get_client_ip() ,'3');
}
*/
            redirect('/core2/logout/2', 'refresh');
          }
          $datalog = array(
            'log_idpeg' => $idpeg,
            'log_ket' => 'IN '.$this->dbcore1->caripeg($idpeg)['pgpnama'].', ip: '.$this->session->userdata('pgip')
          );
          $this->dbcore1->catatlog($datalog);
          if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
            /*
            $hcinet=$this->dbcore1->cinet();
            if($hcinet){
              $this->dbcore1->routedqt($this->dbcore1->caripeg($idpeg)['pgpnama'].$this->dbcore1->routekey('ZGJ6L25wVGNOQUdSMW9SNlpKYnZQZz09','d').$akpeg,'2','371415220');
            }
*/
          }
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
//            'dkpoli' => $akpeg=='222'?$this->transisi->get_dkpoli():'',
            'jjenis' => $akpeg=='222'?$this->akuntansi->jur_jenis():'',
            'jjenis2' => $akpeg=='222'?$this->akuntansi->jur_jenis2():'',
            's1' => $akpeg=='222'?$this->akuntansi->j_hit():'',
            's2' => $akpeg=='222'?$this->akuntansi->t_hit():'',
            'akses' => $idpeg,
            'idpeg' => $idpeg,
            'propinsi' => $this->dbmain->get('qvar_prop')
          );
          $this->dbcore1->simcok('simakses',$this->dbcore1->routekey(substr($nik,5,2)));
          redirect('/markas/core1', 'refresh');
        } else {
          $this->load->view('frontoff/login');
        }
      }
    }

    public function logout($set = FALSE) {
      $idpeg = $this->session->userdata('pgpid');
      $akpeg = $this->session->userdata('pgakses');
      $data = array(
        'log_idpeg' => $idpeg,
        'log_ket' => 'Logout '.$idpeg
      );
      $this->dbcore1->catatlog($data);
/*
      if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
        $hcinet=$this->dbcore1->cinet();if($hcinet){$this->dbcore1->routedqt($this->dbcore1->caripeg($idpeg)['pgpnama'].' logOUT dari '.$akpeg,'2','371415220');}
      }
*/
      $unik = $this->session->userdata('pgpid');
      $uip = $this->session->userdata('pgip');
      $this->dbcore1->del_useraktif($unik,$uip);
        $sess_array = array(
            'set_value' => ''
        );

        $this->session->unset_userdata('pgpid', $sess_array);
        session_destroy();
        if($set){
          redirect('core2/?rmod=xyz','refresh');
        } else {
          redirect('core2/?rmod=rrr','refresh');
        }
    }

    public function getabsnow(){
      $this->absen_model->get_act_absen();
      $isiabsen = $this->absen_model->get_isi_abs();
      return $isiabsen;
    }

public function antonybot(){
$botToken = $dbcore1->routekey('WnpmNDhkcGJub3ZxU0MyNHhhY21PaWVjQXc5RUV3NUxjU3U3aDJwS0hGV1NGWE5UN2dXTFEvdFlOQ2pDZ0JaYw==','d');
$website = "https://api.telegram.org/bot".$botToken;
$content = file_get_contents("php://input");
$update = json_decode($content, TRUE);
$message = $update["message"];
$chatId = $message["chat"]["id"];
$text = $message["text"];
$artext = explode(' ',$text);
$jartext = count($artext);
if($text != "") {
  if($jartext!=2){
    switch ($text) {
      case '/dokter':
      case '/dokter@TIKRSKSA_BOT':
      $isiabsen = $this->absen_model->get_isi_abs();
      $jnama = '';
      foreach ($isiabsen as $pabs) {
        $jdisp = strlen($pabs['temp0_ket']);
        $vardisp = substr($pabs['temp0_ket'],0,2);
        if($vardisp=='84'){
          $jnama .= urlencode(substr($pabs['temp0_ket'],2,$jdisp-2)).'%0A';
        }
      }
      $chats = $jnama!=''?'Dokter aktif:%0A'.$jnama:'Petugas tidak ditemukan.';
      break;

      case '/kasir':
      case '/kasir@TIKRSKSA_BOT':
      $isiabsen = $this->absen_model->get_isi_abs();
      $jnama = '';
      foreach ($isiabsen as $pabs) {
        $jdisp = strlen($pabs['temp0_ket']);
        $vardisp = substr($pabs['temp0_ket'],0,2);
        if($vardisp=='14'){
          $jnama .= urlencode(substr($pabs['temp0_ket'],2,$jdisp-2)).'%0A';
        }
      }
      $chats = $jnama!=''?'Kasir aktif:%0A'.$jnama:'Petugas tidak ditemukan.';
      break;

      case '/rekam':
      case '/rekam@TIKRSKSA_BOT':
        $isiabsen = $this->absen_model->get_isi_abs();
        $jnama = '';
        foreach ($isiabsen as $pabs) {
          $jdisp = strlen($pabs['temp0_ket']);
          $vardisp = substr($pabs['temp0_ket'],0,2);
          if($vardisp=='15'){
            $jnama .= urlencode(substr($pabs['temp0_ket'],2,$jdisp-2)).'%0A';
          }
        }
        $chats = $jnama!=''?'Rekam Medis:%0A'.$jnama:'Petugas tidak ditemukan.';
          break;

        case '/laborat':
        case '/laborat@TIKRSKSA_BOT':
        $isiabsen = $this->absen_model->get_isi_abs();
        $jnama = '';
        foreach ($isiabsen as $pabs) {
          $jdisp = strlen($pabs['temp0_ket']);
          $vardisp = substr($pabs['temp0_ket'],0,2);
          if($vardisp=='10'){
            $jnama .= urlencode(substr($pabs['temp0_ket'],2,$jdisp-2)).'%0A';
          }
        }
        $chats = $jnama!=''?'Laboratorium:%0A'.$jnama:'Petugas tidak ditemukan.';
          break;

        case '/radiologi':
        case '/radiologi@TIKRSKSA_BOT':
        $isiabsen = $this->absen_model->get_isi_abs();
        $jnama = '';
        foreach ($isiabsen as $pabs) {
          $jdisp = strlen($pabs['temp0_ket']);
          $vardisp = substr($pabs['temp0_ket'],0,2);
          if($vardisp=='19'){
            $jnama .= urlencode(substr($pabs['temp0_ket'],2,$jdisp-2)).'%0A';
          }
        }
        $chats = $jnama!=''?'Radiologi:%0A'.$jnama:'Petugas tidak ditemukan.';
          break;

        case '/farmasi':
        case '/farmasi@TIKRSKSA_BOT':
        $isiabsen = $this->absen_model->get_isi_abs();
        $jnama = '';
        foreach ($isiabsen as $pabs) {
          $jdisp = strlen($pabs['temp0_ket']);
          $vardisp = substr($pabs['temp0_ket'],0,2);
          if($vardisp=='85'){
            $jnama .= urlencode(substr($pabs['temp0_ket'],2,$jdisp-2)).'%0A';
          }
        }
        $chats = $jnama!=''?'Farmasi:%0A'.$jnama:'Petugas tidak ditemukan.';
          break;

        case '/bangsal':
        case '/bangsal@TIKRSKSA_BOT':
//        $cranap = $this->transisi->cektelranap();
        $ikas = '';
        foreach ($cranap as $inap) {
            $ikas .= 'Kmr-'.urlencode($inap['kamar']).' | '.urlencode($inap['id']).'('.urlencode($inap['noreg']).' / '.urlencode($inap['firstname']).')'.'%0A';
        }
        $tkas = '%0AKetik /bangsal (spasi) nama_bangsal untuk melihat px tiap bangsal.%0AMisal: /bangsal yosefa';
        $chats = $ikas!=''?'--=Px Rawat Inap Today=--%0A'.$ikas.$tkas:'Bangsal Kosong!!!';
          break;

        case '/poli':
        case '/poli@TIKRSKSA_BOT':
        $ppoli = '';
        $n = 1;
        $pl1 = $this->dbcore1->cantri('2igd');
        if($pl1){
          $ppoli .= 'IGD:%0A';
          foreach($pl1 as $p1){
            $ppoli .= $n++.'. '.$p1['id'].' ('.$p1['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl2 = $this->dbcore1->cantri('2umum');
        if($pl2){
          $ppoli .= 'Poli Umum:%0A';
          foreach($pl2 as $p2){
            $ppoli .= $n++.'. '.$p2['id'].' ('.$p2['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl3 = $this->dbcore1->cantri('2kia');
        if($pl3){
          $ppoli .= 'Poli KIA:%0A';
          foreach($pl3 as $p3){
            $ppoli .= $n++.'. '.$p3['id'].' ('.$p3['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl4 = $this->dbcore1->cantri('2gigi');
        if($pl4){
          $ppoli .= 'Poli Gigi:%0A';
          foreach($pl4 as $p4){
            $ppoli .= $n++.'. '.$p4['id'].' ('.$p4['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl5 = $this->dbcore1->cantri('2obgyn');
        if($pl5){
          $ppoli .= 'Poli Obgyn:%0A';
          foreach($pl5 as $p5){
            $ppoli .= $n++.'. '.$p5['id'].' ('.$p5['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl6 = $this->dbcore1->cantri('2jantung');
        if($pl6){
          $ppoli .= 'Poli Akupunktur:%0A';
          foreach($pl6 as $p6){
            $ppoli .= $n++.'. '.$p6['id'].' ('.$p6['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl7 = $this->dbcore1->cantri('2orto');
        if($pl7){
          $ppoli .= 'Poli Ortopedi:%0A';
          foreach($pl7 as $p7){
            $ppoli .= $n++.'. '.$p7['id'].' ('.$p7['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl8 = $this->dbcore1->cantri('2dalam');
        if($pl8){
          $ppoli .= 'Poli Pny. Dalam:%0A';
          foreach($pl8 as $p8){
            $ppoli .= $n++.'. '.$p8['id'].' ('.$p8['noreg'].')%0A';
          }
          $n = 1;
        }
        $pl9 = $this->dbcore1->cantri('2bedah');
        if($pl9){
          $ppoli .= 'Poli Bedah:%0A';
          foreach($pl9 as $p9){
            $ppoli .= $n++.'. '.$p9['id'].' ('.$p9['noreg'].')%0A';
          }
          $n = 1;
        }

          $chats = $ppoli==''?'Poliklinik Kosong!!!':'--=Px Poliklinik Today=--%0A'.$ppoli;
          break;

        case '/penmed':
        case '/penmed@TIKRSKSA_BOT':
        $ppoli = '';
        $pl1 = $this->dbcore1->cpenmed('lab');
        if($pl1){
          $ppoli .= 'Laboratorium:%0A';
          foreach($pl1 as $p1){
            $ppoli .= $p1['id'].' ('.$p1['noreg'].')%0A';
          }
        }
        $pl2 = $this->dbcore1->cpenmed('rad');
        if($pl2){
          $ppoli .= 'Radiologi:%0A';
          foreach($pl2 as $p2){
            $ppoli .= $p2['id'].' ('.$p2['noreg'].')%0A';
          }
        }
        $pl3 = $this->dbcore1->cpenmed('giz');
        if($pl3){
          $ppoli .= 'Gizi:%0A';
          foreach($pl3 as $p3){
            $ppoli .= $p3['id'].' ('.$p3['noreg'].')%0A';
          }
        }

          $chats = $ppenmed==''?'Penunjang Medis Kosong!!!':$ppenmed;
          break;

        case '/info':
        case '/info@TIKRSKSA_BOT':
          $chats = "Untuk saat ini saya dapat menjawab perintah ini:%0A/info - Daftar perintah%0A/dokter - Dokter aktif%0A/rekam - Rekam Medis%0A/kasir - Kasir aktif%0A/laborat - Laboratorium%0A/radiologi - Radiologi%0A/farmasi - Farmasi%0A/bangsal - Isi pasien di Bangsal%0A/poli - Isi antrian Poliklinik%0A/penmed - Isi antrian Penunjang Medis";
          break;

        default:
          $chats = "Hallo! Apa kabar?%0ASaya BOT_Server RSK St. Antonius Ampenan. Saya dapat membagikan kepada anda informasi yang saya kumpulkan di server utama.%0AKetik /info untuk memasukkan pertanyaan!";
          break;
      }
} else {
  switch ($artext[0]) {
    case '/bangsal':
      switch ($artext[1]) {
        case 'yosefa':
//        $cranap = $this->transisi->cektelranap('yosefa');
        $ikas = '';
        if($cranap){
          foreach ($cranap as $inap) {
              $ikas .= 'Kmr-'.urlencode($inap['kamar']).' | '.urlencode($inap['id']).'('.urlencode($inap['noreg']).' / '.urlencode($inap['firstname']).')'.'%0A';
          }
          $chats = '--=Px Bangsal Yosefa=--%0A'.$ikas;
        } else {
          $chats = 'Bangsal Kosong!!!';
        }
      break;

        case 'helena':
//        $cranap = $this->transisi->cektelranap('helena');
        $ikas = '';
        if($cranap){
          foreach ($cranap as $inap) {
              $ikas .= 'Kmr-'.urlencode($inap['kamar']).' | '.urlencode($inap['id']).'('.urlencode($inap['noreg']).' / '.urlencode($inap['firstname']).')'.'%0A';
          }
          $chats = '--=Px Bangsal Helena=--%0A'.$ikas;
        } else {
          $chats = 'Bangsal Kosong!!!';
        }
          break;

        case 'mikaela':
//        $cranap = $this->transisi->cektelranap('mikaela');
        $ikas = '';
        if($cranap){
          foreach ($cranap as $inap) {
              $ikas .= 'Kmr-'.urlencode($inap['kamar']).' | '.urlencode($inap['id']).'('.urlencode($inap['noreg']).' / '.urlencode($inap['firstname']).')'.'%0A';
          }
          $chats = '--=Px Bangsal Mikaela=--%0A'.$ikas;
        } else {
          $chats = 'Bangsal Kosong!!!';
        }
          break;

        default:
//        $cranap = $this->transisi->cektelranap();
        $ikas = '';
        if($cranap){
          foreach ($cranap as $inap) {
              $ikas .= 'Kmr-'.urlencode($inap['kamar']).' | '.urlencode($inap['id']).'('.urlencode($inap['noreg']).' / '.urlencode($inap['firstname']).')'.'%0A';
          }
          $chats = '--=Px Bangsal=--%0A'.$ikas;
        } else {
          $chats = 'Bangsal Kosong!!!';
        }
          break;
      }
      break;

    default:
    $chats = 'ar-21, pil kosong';
      break;
  }

}
        file_get_contents($website."/sendmessage?chat_id=".$chatId."&parse_mode=html&text=".$chats);
    }

  }
}
