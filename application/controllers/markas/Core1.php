<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth,User-Agent, X-File-Size, X-Requested-With, If-Modified-Since,X-File-Name, Cache-Control");

//defined('BASEPATH') OR exit('No direct script access allowed');

class Core1 extends CI_Controller {


  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->model('absen_model','',TRUE);
    $this->load->model('akuntansi','',TRUE);
    $this->load->model('person_model','',TRUE);
    $this->load->helper('url','form');
    $this->dbmain = $this->load->database('default',TRUE);
  }

    function index() {
        $rmoda = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'';
        $idpeg = $this->session->userdata('pgpid');
        $akpeg = $this->session->userdata('pgakses');
        $this->dbcore1->delcok('jnsperk');
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
          $vtitle = 'QMARSUPIUM - 2024';
          break;
        }
        if($idpeg!='') {
$thn = date("Y");
$hrni = date("Y-m-d");
$this->dbcore1->simcok('qtitle',$this->dbcore1->routekey($vtitle));
            $data = array(
                'rmmod' => $rmoda,
                'hasil' => '',
                'periksa' => '',
                'operator' => $this->dbcore1->caripeg($idpeg),
                'kodejob' => $akpeg,
                'kodejob1' => $akpeg1,
                'kodesu' => $supeg,
                'dafkodejur' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->carikodejur():'',
//                'pjenis' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_ka5('','',''):'',
                'dkbangsal' => '',
                'jjenis' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis():'',
//                'jjenis2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis2():'',
                'jka1' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka1():'',
                'jka2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka2():'',
                'jka3' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka3():'',
                'jka4' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka4():'',
                'akses' => $idpeg,
                'cgroup' => $this->pecahcgroup($akpeg),
                'idpeg' => $idpeg
            );
            $this->load->view('backoff/rm_infor',$data);
        } else {
            $this->load->view('frontoff/login');
        }
    }

    function list_jur(){
  		$transactionss = $this->akuntansi->jur_jenis_all();
  		echo (json_encode($transactionss));
    }

    function hitjur($vhit = FALSE){
      if($vhit=='J'){
        $data = $this->akuntansi->j_hit();
      } else {
        $data = $this->akuntansi->t_hit();
      }
      echo json_encode($data);
    }

    function cnamapeg($nikpeg = FALSE){
        $data = $this->dbcore1->caripeg($nikpeg);
      echo json_encode($data['pgpnama']);
    }

    function hitsel(){
        $data = $this->akuntansi->s_hit();
      echo json_encode($data);
    }

    function detsel(){
        $datads = $this->akuntansi->ds_hit();
        $data = array();
        foreach ($datads as $dds) {
          $data[] .= '<a href="'.base_url()."markas/core1/trxharian/".$dds.'"><strong>'.$dds.'</strong></a> ';
        }
      echo json_encode($data);
    }


    function getakungraf($varakun = FALSE){
      $thn = date("Y");
      $list1 = $this->akuntansi->get_info($thn.$varakun);
      $data = array();
      foreach ($list1 as $dtakun) {
        $data[] .= $dtakun['aktrx_jum'];
      }
      echo json_encode($data);
    }

function pecahcgroup($kdpeggrp = FALSE){
  $isicgroup = $this->dbcore1->get_peggroup(substr($kdpeggrp,0,1));
  $arcgroup = array();
  foreach($isicgroup as $icgrp){
    $namapeg = $this->dbcore1->caripeg($icgrp['qaknik']);
    $arcgroup[$icgrp['qaknik']] = $namapeg['pgpnama'];
  }
  $arcgroup['0000.00.000'] = 'SEMUA';
  return $arcgroup;
}
//----------------------------------------------- Absensi start
public function data_absen(){
  $rmoda = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'';
  $idpeg = $this->session->userdata('pgpid');
  $akpeg = $this->session->userdata('pgakses');
  $supeg = $this->session->userdata('pgsu');
  $vtitle = 'Kepegawaian';

  $this->load->model('Absen_model');
      $this->Absen_model->get_data_absen();
      $this->dbcore1->simcok('qtitle',$this->dbcore1->routekey($vtitle));

      $data = array(
          'rmmod' => $rmoda,
          'hasil' => '',
          'periksa' => '',
          'dtabsen' => '---',
          'operator' => $this->dbcore1->caripeg($idpeg),
          'kodejob' => $akpeg,
          'kodesu' => $supeg,
          'akses' => $idpeg,
      );
      $this->load->view('backoff/rm_infor',$data);
  }


//----------------------------------------------- Absensi End

    function propinsi(){
        $negaraID = $_GET['id'];
        $propinsi   = $this->dbmain->get_where('qvar_prop',array('id_neg'=>$negaraID));
        echo "<div class='input-group input-group-sm'><label for='dprp' class='input-group-addon'>PROPINSI</label>";
        echo "<select name='dprp' id='propinsi' onChange='loadKabupaten()' class='form-control'><option value=''>-PROPINSI-</option>";
        foreach ($propinsi->result() as $p)
        {
            echo "<option value='$p->id'>".strtoupper($p->namaprp)."</option>";
        }
        echo "</select></div>";
    }

    function kabupaten(){
        $propinsiID = $_GET['id'];
        $kabupaten   = $this->dbmain->get_where('qvar_kab',array('id_prp'=>$propinsiID));
        echo "<div class='input-group input-group-sm'><label for='dktkab' class='input-group-addon'>KOTA/KAB</label>";
        echo "<select name='dktkab' id='kabupaten' onChange='loadKecamatan()' class='form-control'><option value=''>-KOTA/KAB-</option>";
        foreach ($kabupaten->result() as $k)
        {
            echo "<option value='$k->id'>".strtoupper($k->namakab)."</option>";
        }
        echo "</select></div>";
    }

    function kecamatan(){
        $kabupatenID = $_GET['id'];
        $kecamatan   = $this->dbmain->get_where('qvar_kec',array('id_kab'=>$kabupatenID));
        echo "<div class='input-group input-group-sm'><label for='dkec' class='input-group-addon'>KEC</label>";
        echo "<select name='dkec' id='kecamatan' onChange='loadDesa()' class='form-control'><option value=''>-KECAMATAN-</option>";
        foreach ($kecamatan->result() as $k)
        {
            echo "<option value='$k->id'>".strtoupper($k->namakec)."</option>";
        }
        echo"</select></div>";
    }

    function desa(){
        $kecamatanID = $_GET['id'];
        $desa   = $this->dbmain->get_where('qvar_desa',array('id_kec'=>$kecamatanID));
        echo "<div class='input-group input-group-sm'><label for='dkel' class='input-group-addon'>DESA</label>";
        echo "<select name='dkel' id='desa' class='form-control'><option value=''>-DESA-</option>";
        foreach ($desa->result() as $d)
        {
            echo "<option value='$d->id'>".strtoupper($d->namades)."</option>";
        }
        echo"</select></div>";
    }

    public function warn_nojur($cnojur = FALSE){
      $idn = $this->akuntansi->carinojur($cnojur);
      if($idn){
        echo $idn['akjur_ket'];
      }
    }

    public function cek_nojur(){
      $idn = $this->akuntansi->get_lastjur($this->input->post('cnojur'));
      $nakhir = floatval(substr($idn['lastjur'],-3));
      if($idn){
        $gotnum = str_pad($nakhir+1, 3, '0', STR_PAD_LEFT);
      }
      echo $gotnum;
    }

  public function filpxh($id) {
    $id==''?$id='y':$id;
    $this->dbcore1->simcok('qtitle',$this->dbcore1->routekey('Input Jurnal'));
      $data = array(
        'rmmod' => 'daftar',
        'qpxgh' => $this->dbcore1->qpxg_hrf(),
        'dpx0' => $this->dbcore1->qpxtot($id),
        'dpx1' => $this->dbcore1->qpxjtot($id)
      );
    $this->load->view('backoff/rm_infor',$data);
  }

  public function regpx($reg) {
    $this->dbcore1->simcok('qtitle',$this->dbcore1->routekey('Input Jurnal'));
      $data = array(
        'rmmod' => 'area2',
        'dpx1' => $this->dbcore1->qpxjtot($reg)
      );
    $this->load->view('backoff/rm_infor',$data);
  }

  function filltemp1($ar = FALSE){
    $idpeg = $this->session->userdata('pgpid');
    $this->akuntansi->_deltbner($idpeg);
      $this->akuntansi->_isitbner1($ar,$idpeg);
      $list = $this->akuntansi->filltemp1($ar,$idpeg);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $jurnal) {
        $no++;
        $row = array();
        $row[] = $jurnal->temp1_noper;
        $row[] = $jurnal->temp1_perk;
        $row[] = floatval($jurnal->temp1_da);
        $row[] = floatval($jurnal->temp1_ka);
        $row[] = floatval($jurnal->temp1_db);
        $row[] = floatval($jurnal->temp1_kb);
        $row[] = floatval($jurnal->temp1_dc);
        $row[] = floatval($jurnal->temp1_kc);
        $data[] = $row;
      }

  $output = array(
          "draw" => $_POST['draw'],
//          "recordsTotal" => $this->akuntansi->count_all($ar),
//          "recordsFiltered" => $this->akuntansi->count_filtered($ar),
          "data" => $data
      );
  echo json_encode($output);

      }

      public function upabsen($tghrni = FALSE) {
        $this->absen_model->get_sts_absen($tghrni);
        exit;
      }


      function fillabsen($rnga = FALSE){
          $list = $this->absen_model->isiabsen($rnga);
          $data = array();
          $no = $_POST['start'];
          foreach ($list as $absen) {
            $anik = $absen->temp2_nik;
            $atgl = $absen->temp2_tgl;
            $anama = $absen->pgpnama;
            $abts0 = '05:30:00';
            $abts1 = '07:00:00';
            $abts2 = '07:30:00';
            $abts3 = '08:30:00';
            $abts4 = '09:00:00';
            $abts5 = '14:00:00';
            $abts6 = '21:00:00';
            $acts1 = '14:30:00';
            $acts2 = '20:30:00';
            $cwkt1 = $this->absen_model->carwktpeg($anik.'x');
            $checkTime = strtotime($abts0);
            foreach ($cwkt1 as $wkt1) {
              $awktx = strtotime($wkt1->temp2_tgl);
              if($awktx>=strtotime($abts1) - 45*60 && $awktx<=strtotime($abts1)+ 45*60 && $awktx<strtotime($abts2) && $awktx>strtotime($abts0)) {
                $checkTime = strtotime($abts1);
              } elseif($awktx>=strtotime($abts2) - 45*60 && $awktx<=strtotime($abts2) + 45*60 && $awktx<strtotime($abts3) && $awktx>strtotime($abts1)) {
                $checkTime = strtotime($abts2);
              } elseif($awktx>=strtotime($abts3) - 45*60 && $awktx<=strtotime($abts3) + 45*60 && $awktx<strtotime($abts4) && $awktx>strtotime($abts2)) {
                $checkTime = strtotime($abts3);
              } elseif($awktx>=strtotime($abts4) - 45*60 && $awktx<=strtotime($abts4) + 45*60 && $awktx<strtotime($abts5) && $awktx>strtotime($abts3)) {
                $checkTime = strtotime($abts4);
              } elseif($awktx>=strtotime($abts5) - 45*60 && $awktx<=strtotime($abts5) + 45*60 && $awktx<strtotime($abts6) && $awktx>strtotime($abts4)) {
                $checkTime = strtotime($abts5);
              } elseif($awktx>=strtotime($abts6) - 45*60 && $awktx<=strtotime($abts6) + 45*60 && $awktx>strtotime($abts5)) {
                $checkTime = strtotime($abts6);
              } elseif($awktx>=strtotime($abts0) - 45*60 && $awktx<=strtotime($abts0) + 45*60 && $awktx<strtotime($abts1)) {
                $checkTime = strtotime($abts0);
              }
              $awkt1 = date("H:i",$awktx);
            }
            $cwkt2 = $this->absen_model->carwktpeg($anik.'y');
            foreach ($cwkt2 as $wkt2) {
              $awkty = $wkt2->temp2_tgl;
              $awkt2 = date("H:i",strtotime($awkty));
            }

            $awkt2 = (date("H",strtotime($awkty))<=date("H",strtotime($awktx)))?'---':$awkt2;
            $wktin = $awktx;

            $diff = $checkTime - $wktin;
            $aparam = ($diff < 0)? ('Lewat '.abs($diff)/60) : 'Tepat!';


            $no++;
            $row = array();
            $row[] = date("d",strtotime($atgl));
            $row[] = $anik;
            $row[] = $anama;
            $row[] = $awkt1;
            $row[] = $awkt2;
            $row[] = $aparam;
            $data[] = $row;
          }
      $output = array(
              "draw" => $_POST['draw'],
//              "recordsTotal" => $this->akuntansi->count_all($ar),
//              "recordsFiltered" => $this->akuntansi->count_filtered($ar),
              "data" => $data
          );
      echo json_encode($output);
          }

      function getcharttgl($zona = FALSE){
        $settgl = $zona;
        $listtg = $this->akuntansi->chartbuku($settgl);
        $data = array();
        foreach ($listtg as $crtgl1) {
          if(strlen($zona)>1) {
            $data[] .= date('d',strtotime($crtgl1->akjur_tgl));
          } else {
            $data[] .= date('m|y',strtotime($crtgl1->akjur_tgl));
          }
        }
        echo json_encode($data);
      }

      function getchartdata($zona = FALSE){
        $settgl = $zona;
        $list1 = $this->akuntansi->chartbuku($settgl);
        $data = array();
        foreach ($list1 as $crtgl) {
          if(strlen($zona)>11) {
            $tgljur = $zona.$crtgl->akjur_tgl;
            $list2 = $this->akuntansi->chartbuku($tgljur);
            $jdtjum=0;
            if($list2){
              $jdtjum = $list2['aktrx_jum'];
            }
              $data[] .= $jdtjum;
          } else {
            $dttgl = date('mY',strtotime($crtgl->akjur_tgl));
            $tgljur = $zona.$dttgl;
            $list2 = $this->akuntansi->chartbuku($tgljur);
            $jdtjum=0;
            if($list2){
              $jdtjum = $list2['aktrx_jum'];
            }
              $data[] .= $jdtjum;
          }
        }
        echo json_encode($data);
      }

  function fillgrid($ar = FALSE){
      $ling = substr($ar,0,5);
      $list = $this->akuntansi->fillgrid($ar);
      $data = array();
      $no = $_POST['start'];
      $l_hit = 0;
      $ar2 = substr($ar,0,17);
      $nj = substr($ar2,5-strlen($ar2));
      if($ling=='area4'){
        $l_saldo1 = $this->akuntansi->get_pers($nj);
        $saldeb = $this->akuntansi->fillgrid4saldod($ar);
        $salkre = $this->akuntansi->fillgrid4saldok($ar);
        $l_saldo = ($l_saldo1?$l_saldo1['ka_saldoawal']:0)+$saldeb-$salkre;
        $no = 0;
        $row = array();
        $row[] = '---';
        $row[] = $no>=1?$no:'---';
        $row[] = '';
        $row[] = '';
        $row[] = 'Saldo Awal';
        $row[] = $l_saldo>0?abs(floatval($l_saldo)):0;
        $row[] = $l_saldo<0?abs(floatval($l_saldo)):0;
        $row[] = $l_saldo;
        $data[] = $row;
      }
      foreach ($list as $jurnal) {
          if($ling=='area2'){
              if(strlen($ar)==5){
                $cor = $jurnal->akjur_sts;
                $nojur = $jurnal->akjur_nomor;
                $urai = $jurnal->akjur_ket;
                $htg = $this->akuntansi->jumhit($nojur);
//                $hit = $htg>0?$htg:'<i class="glyphicon glyphicon-question-sign" style="color:#FF0000;"></i>';
                $jml = $this->akuntansi->jumnil($nojur);
                $jum1 =  number_format(floatval($jml));
                $jum = $jum1!=0?'<span style="color:#FF0000;">'.$jum1.'</span>':$jum1;
                $edit = base_url()."markas/core1/trxharian/".$nojur;
                $tgl = date("d/m/Y",strtotime($jurnal->akjur_tgl));
                $ipost = $jurnal->akjur_post;
              } elseif(strlen($ar)==25) {
                $tgl = date("d/m/Y",strtotime($jurnal->akjur_tgl));
                $trxno = $jurnal->aktrx_nomor;
                $trxjur = $jurnal->aktrx_nojur;
                $trxnm = $jurnal->aktrx_nama;
                $trxket = !$jurnal->aktrx_ket?$jurnal->akjur_ket:$jurnal->aktrx_ket;
                $trxdbt = $jurnal->aktrx_jns=='D'?$jurnal->aktrx_jum:0;
                $trxkre = $jurnal->aktrx_jns=='K'?$jurnal->aktrx_jum:0;
                  $ipost = $jurnal->aktrx_post;
              }

              $no++;
              $row = array();
              if(strlen($ar)==25){
                $row[] = $tgl;
              }
              $row[] = strlen($ar)==5?$tgl:$trxno;
              $row[] = strlen($ar)==5?$nojur:$trxjur;
              $row[] = strlen($ar)==5?strtoupper($urai):$trxnm;
              $row[] = strlen($ar)==5?($jum):strtoupper($trxket);
              $row[] = strlen($ar)==5?($cor==1?'X':$htg):$trxdbt;
              if(strlen($ar)==25){
                $row[] = $trxkre;
              } else {
                $row[] = $ipost==0?'X':'<i class="fa fa-check blue"></i>';
              }
              $data[] = $row;
          } elseif($ling=='area3') {
            $cort = substr($jurnal->aktrx_nomor,-1);
              $nourt = $jurnal->aktrx_urut;
              $notrx = $jurnal->aktrx_nomor;
              $notrxh = substr($notrx,0,12);
              $nojur = $jurnal->aktrx_nojur;
              $nama = $jurnal->aktrx_mark!=1?$jurnal->aktrx_nama:('<span style="color:#FF0000;"><del>'.$jurnal->aktrx_nama.'</del></span>');
              $urai = $jurnal->aktrx_mark!=1?$jurnal->aktrx_ket:('<span style="color:#FF0000;"><del>'.$jurnal->aktrx_ket.'</del></span>');
              $jns = $jurnal->aktrx_jns;
              $jum = floatval($jurnal->aktrx_jum);

              if($jurnal->aktrx_mark!=1){
                  $ganti='<div class="btn-group"><a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Koreksi" onclick="hapustransaksi('."'".$notrx.$nojur."'".')"><i class="glyphicon glyphicon-alert"></i></a></div>';
                  $ketjum = '';

              } else {
                  $ganti= '-';
                  $ketjum = $jns.': '.$jum;
                  $jum = 0;
              }


              $no++;
              $row = array();
              $row[] = $notrxh;
              $row[] = $jns=='K'?'<span class="purple pull-right">'.$nama.'</span>':'<span class="purple pull-left">'.$nama.'</span>';
              $row[] = $jns=='K'?'<span class="pull-right">'.strtoupper($urai).$ketjum.'</span>':strtoupper($urai).$ketjum;
              $row[] = $jns=='D'?$jum:0;
              $row[] = $jns=='K'?$jum:0;
              $row[] = '<span class="pull-right">'.$ganti.'</span>';
              $data[] = $row;

          } else {
            $l_tgl = $jurnal->akjur_tgl;
            $l_jns = $jurnal->aktrx_jns;
            $l_nojur = $jurnal->aktrx_nojur;
            $l_urai = $jurnal->akjur_ket;
            $l_jum = $jurnal->aktrx_jum;
            if($l_jns=='K'){
              $l_saldo = $l_saldo-$l_jum;
            } else {
              $l_saldo = $l_saldo+$l_jum;
            }
            $l_grp = $jurnal->aktrx_nomor;

            $no++;
            $row = array();
            if($ling=='area4') {
              $row[] = $l_grp;
            }
            $row[] = $no;
            $row[] = date("d/m/Y",strtotime($l_tgl));
            $row[] = $l_nojur;
            $row[] = strtoupper($l_urai);
            $row[] = $l_jns=='D'?floatval($l_jum):0;
            $row[] = $l_jns=='K'?floatval($l_jum):0;
            $row[] = floatval($l_saldo);
            $data[] = $row;
          }
      }

  $output = array(
          "draw" => $_POST['draw'],
          "recordsTotal" => $this->akuntansi->count_all($ar),
          "recordsFiltered" => $this->akuntansi->count_filtered($ar),
          "data" => $data
      );
  echo json_encode($output);
      }

      function filltrans($ar = FALSE){
        $as = 'cpoli005dpolikia2017-04-242017-06-24';
        $list = $this->transisi->filltrans($ar);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $jurnal) {
          $dk_tgl = $jurnal->tglinput;
          $dk_rm = $jurnal->rm;
          $dk_px = $jurnal->firstname;
          $dk_dok = $jurnal->namadokter;
          $dk_trf = floatval($jurnal->tarif);

          $no++;
          $row = array();
          $row[] = $no;
          $row[] = date("d/m/Y",strtotime($dk_tgl));
          $row[] = $dk_rm;
          $row[] = $dk_px;
          $row[] = $dk_dok;
          $row[] = $dk_trf;
          $data[] = $row;
          }

          $output = array(
            "draw" => $_POST['draw'],
            "data" => $data
          );
          echo json_encode($output);
        }

      function fillbill($ar = FALSE){
        $list = $this->transisi->fillbill($ar);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bill) {
          $bl_tgb = $bill->tglinput;
          if($bill->asal==''){
            $bl_asla = $this->transisi->get_dkbangsal($bill->noreg);
            $bl_asl = $bl_asla;
          } else {
            $bl_asl = $bill->asal;
          }
          $bl_inp = $bill->id;
          $bl_nm = $bill->firstname;
          $bl_reg = $bill->noreg;
          $bl_itm = $bill->item;
          $bl_jbi = strtoupper($bill->keterangan);
          $bl_dbi = $bill->ket==''?$bl_jbi:strtoupper($bill->ket);
          $bl_tot = floatval($bill->total);

          $no++;
          $row = array();
          $row[] = $no;
          $row[] = date("d/m",strtotime($bl_tgb));
          $row[] = $bl_asl;
          $row[] = $bl_inp;
          $row[] = $bl_nm;
          $row[] = $bl_reg;
          $row[] = $bl_itm;
          $row[] = $bl_jbi;
          $row[] = $bl_dbi;
          $row[] = $bl_tot;
          $data[] = $row;
          }

          $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->transisi->lapbill_all($ar),
            "recordsFiltered" => $this->transisi->lapbill_filtered($ar),
            "data" => $data
          );
          echo json_encode($output);
        }

        function fillqbill($ar = FALSE){
            $idpeg = $this->session->userdata('pgpid');
            $clrdet = $this->transisi->cleanrek($idpeg,'detail');
          $list = $this->transisi->fillqbill($ar);

          $data = array();
          $no = $_POST['start'];
          foreach ($list as $rekmn) {
            $bl_tgmsk = date("d/m",strtotime($rekmn->qbmain_tglmasuk));
            $bl_tgklr = date("d/m",strtotime($rekmn->qbmain_tglkeluar));
            $kmr = $rekmn->qbmain_kmr;
            $kls = $rekmn->qbmain_kls;
            if(substr($rekmn->qbmain_reg,0,2)=='ri'){
              $yos = array('0'=>'1','1'=>'2','2'=>'3','3'=>'4','4'=>'5','5'=>'6','6'=>'25','7'=>'24','8'=>'20','9'=>'22','10'=>'23','11'=>'17','12'=>'18','13'=>'19','14'=>'15');
              $hel = array('0'=>'14','1'=>'16','2'=>'21','3'=>'14A','4'=>'B14','5'=>'B16','6'=>'B21');
              $mik = array('0'=>'7','1'=>'8','2'=>'9','3'=>'10','4'=>'11','5'=>'12');
              if(array_search($rekmn->qbmain_bsl,$yos)!==false){
                $bangsal = 'Yosefa';
              } elseif(array_search($rekmn->qbmain_bsl,$hel)!==false){
                $bangsal = 'Helena';
              } else {
                $bangsal = 'Mikaela';
              }

              $bl_asla = $this->transisi->get_dkbangsal(substr($rekmn->qbmain_reg,-16));
              $bl_asl = strtoupper('('.$rekmn->qbmain_bsl.') '.$bangsal);
            } else {
              if(strlen($rekmn->qbmain_poli)==8){
                $bl_asla = $this->transisi->get_dkpoli($rekmn->qbmain_poli);
                $bl_asl = $bl_asla;
              } else {
                $bl_asl = strtoupper($rekmn->qbmain_poli);
              }
              $bl_tgklr = '---';
              $kmr = '---';
              $kls = '---';
            }
            $bl_inp = $rekmn->qbmain_idrs;
            $bl_nm = $rekmn->pxpnama;
            $bl_reg = $rekmn->qbmain_prn.substr($rekmn->qbmain_reg,-16);
            $bl_itm = $bl_tgklr;
            $bl_jbi = $kmr;
            $bl_dbi = $kls;
//            $bl_tot = floatval($rekmn->qbmain_adm);
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bl_tgmsk;
            $row[] = $bl_itm;
//            $row[] = $bl_asl;
            $row[] = $bl_inp;
            $row[] = $bl_reg;
            $row[] = $rekmn->qbmain_prn=='0'?'<a href="'.base_url()."markas/core1/detrekening/".$bl_reg.'" class="btn btn-info">'.$bl_nm.' <i class="fa fa-file"></i></a>':'<a href="'.base_url()."markas/core1/detrekening/".$bl_reg.'" class="btn btn-success">'.$bl_nm.' <i class="fa fa-file"></i></a>';
//            $row[] = $bl_jbi;
//            $row[] = $bl_dbi;
//            $row[] = $ganti;
            $data[] = $row;
            }

            $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->transisi->lapqbill_all($ar),
              "recordsFiltered" => $this->transisi->lapqbill_filtered($ar),
              "data" => $data
            );
            echo json_encode($output);
          }

        function fillrawat($ar = FALSE){
          $perjum = strlen($ar);
          $perjns = substr($ar,0,2);
          $pertgl = substr($ar,-20);
          $perpol = substr($ar,2,$perjum-22);
          $perpl1 = substr($perpol,0,8);
          $perpl2 = substr($perpol,8-strlen($perpol));
          $list = $this->transisi->fillrawat($ar);

          $data = array();
          $no = $_POST['start'];
          foreach ($list as $rwt) {
            if($perjns == 'ri') {
              $yos = array('0'=>'1','1'=>'2','2'=>'3','3'=>'4','4'=>'5','5'=>'6','6'=>'25','7'=>'24','8'=>'20','9'=>'22','10'=>'23','11'=>'17','12'=>'18','13'=>'19','14'=>'15');
              $hel = array('0'=>'14','1'=>'16','2'=>'21','3'=>'14A','4'=>'B14','5'=>'B16','6'=>'B21');
              $mik = array('0'=>'7','1'=>'8','2'=>'9','3'=>'10','4'=>'11','5'=>'12');
              if(array_search($rwt->kamar,$yos)!==false){
                $bangsal = 'Yosefa';
              } elseif(array_search($rwt->kamar,$hel)!==false){
                $bangsal = 'Helena';
              } else {
                $bangsal = 'Mikaela';
              }
            } else {
              if(strlen($rwt->asal)==8){
                $nmpoli = $this->transisi->get_dkpoli($rwt->asal);
                if(substr($rwt->asal,0,8)!='cpoli999'){
                  $ddiag = $this->transisi->get_crdiag($rwt->noreg.$perpl2);
                  $cdiag = '['.$ddiag['kddiag'].'] '.$ddiag['diag'];
                } else {
                  $cdiag = '---';
                }
              } else {
                $nmpoli = strtoupper($rwt->asal);
                $cdiag = '---';
              }
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $rwt->noreg;
            $row[] = $rwt->id;
            $row[] = $rwt->firstname;
            if($perjns=='ri'){
              $row[] = $rwt->tglmasuk;
              $row[] = $rwt->tglkeluar;
              $row[] = $bangsal;
              $row[] = $rwt->kamar;
              $row[] = $rwt->kelas;
            } else {
              $row[] = $rwt->tglperiksa;
              $row[] = $nmpoli;
              $row[] = $cdiag;
              $row[] = '---';
              $row[] = '---';
            }
            $data[] = $row;
            }

            $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->transisi->laprawat_all($ar),
              "recordsFiltered" => $this->transisi->laprawat_filtered($ar),
              "data" => $data
            );
            echo json_encode($output);
          }

          function detrekening($nmrj = FALSE){
            $idpeg = $this->session->userdata('pgpid');
            $akpeg = $this->session->userdata('pgakses');
            if(!isset($_GET['kodejob1'])){
              $akpeg1 = $akpeg;
            } else {
              $akpeg1 = $_GET['kodejob1'];
            }
            $akpeg1 = $akpeg!='444'?'444':$akpeg;
            $supeg = $this->session->userdata('pgsu');
            $this->dbcore1->simcok('qtitle',$this->dbcore1->routekey('Rekening'));
            $this->dbcore1->simcok('kodesu',$this->dbcore1->routekey($supeg));
            $data = array(
              'rmmod' => 'area3',
              'hasil' => '',
              'periksa' => '',
              'operator' => $this->dbcore1->caripeg($idpeg),
              'kodejob' => $akpeg,
              'kodejob1' => $akpeg1,
              'kodesu' => $supeg,
              'rek_reg' => substr($nmrj,1),
              'asuransi' => substr($nmrj,0,1),
              'cgroup' => $this->pecahcgroup($akpeg),
              'akses' => $supeg,
              'idpeg' => $idpeg
            );
            $this->load->view('backoff/rm_infor',$data);
          }

          function cekdtrek($nmrj = FALSE){
            $opsirek = array();
            $yos = array('0'=>'1','1'=>'2','2'=>'3','3'=>'4','4'=>'5','5'=>'6','6'=>'25','7'=>'24','8'=>'20','9'=>'22','10'=>'23','11'=>'17','12'=>'18','13'=>'19','14'=>'15');
            $hel = array('0'=>'14','1'=>'16','2'=>'21','3'=>'14A','4'=>'B14','5'=>'B16','6'=>'B21');
            $mik = array('0'=>'7','1'=>'8','2'=>'9','3'=>'10','4'=>'11','5'=>'12');
            $rekhist = $this->transisi->get_kbang($nmrj);
              if($rekhist) {
              foreach ($rekhist as $rhist){
                if(substr($rhist->kode,0,2)=='PA'){
                  $qbangsal = $this->transisi->caribangsal($nmrj,$rhist->kode);
                  if($qbangsal) {
                    foreach ($qbangsal as $qbsl) { //isi each detail bangsal kamar
                      if(array_search($qbsl->kamar,$yos)!==false){
                        $nbangsal = 'Yosefa';
                      } elseif(array_search($qbsl->kamar,$hel)!==false){
                        $nbangsal = 'Helena';
                      } else {
                        $nbangsal = 'Mikaela';
                      }
                      $nbangsal = '" class="btn btn-warning"><h1><span class="glyphicon glyphicon-bed" aria-hidden="true"></span></h1>'.$nbangsal;
                    }
                  }
                } elseif(substr($rhist->kode,0,2)=='cp'){
                  $nbangsal = 'Poliklinik';
                  $nbangsal = '" class="btn btn-info"><h1><span class="glyphicon glyphicon-file" aria-hidden="true"></span></h1>'.$nbangsal;
                }
                $opsirek[] .= '<a href="'.$rhist->kode.$nbangsal.'</a>';
              }
            }
            echo json_encode($opsirek);
          }


          function rekpasien($totreg = FALSE,$jnstrans = FALSE,$typx = FALSE){
            $jentrans = substr($jnstrans,0,4);
            $stharga = 0;
            $minkls= array();
            $pminkls='';
            $nmrj = substr($totreg,1);
            $idpeg = $this->session->userdata('pgpid');
            if($jentrans != 'post'){
              $clrdet = $this->transisi->cleanrek($idpeg,'detail');
              $qbdetail = $this->transisi->carirek($nmrj,'detail',$idpeg);
            } else {
              $qbdetail = $this->transisi->carirek($nmrj,$jentrans);
            }
            if($qbdetail===false) {
            $qbmain = $this->transisi->carirek($nmrj,'main');
            foreach ($qbmain as $mrek) {
              $pminkls=$mrek->qbmain_kls;
              if(substr($mrek->qbmain_reg,0,2)=='rj'){
                $riwayatpoli = $this->transisi->get_kpoli($nmrj);
                if($riwayatpoli){
                  foreach ($riwayatpoli as $chpoli) {
                    if($chpoli->tglinput !=''){
                      $this->rekrajal($totreg,$chpoli->kodepoli,$idpeg,$chpoli->tglinput,substr($mrek->qbmain_reg,0,2),$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
                    }
                  }
                }
                $tdrawat = 'rj';
              } else {
                $qyos = array('0'=>'1','1'=>'2','2'=>'3','3'=>'4','4'=>'5','5'=>'6','6'=>'25','7'=>'24','8'=>'20','9'=>'22','10'=>'23','11'=>'17','12'=>'18','13'=>'19','14'=>'15');
                $qhel = array('0'=>'21','1'=>'16','2'=>'14','3'=>'14A','4'=>'B14','5'=>'B16','6'=>'B21');
                $qmik = array('0'=>'7','1'=>'8','2'=>'9','3'=>'10','4'=>'11','5'=>'12');
                if(array_search($mrek->qbmain_kmr,$qyos)!==false){
                  $qnbangsal = 'Yosefa';
                } elseif(array_search($mrek->qbmain_kmr,$qhel)!==false){
                  $qnbangsal = 'Helena';
                } else {
                  $qnbangsal = 'Mikaela';
                }
                switch ($pminkls) {
                  case '1':
                  $klrawat = 'satu';
                    break;

                  case '2':
                  $klrawat = 'dua';
                    break;

                  case '3':
                  $klrawat = 'tiga';
                    break;

                  default:
                  $klrawat = $pminkls;
                  $pminkls='0';
                    break;
                }
                $minkls[] .= (int)$pminkls;
                if(substr($totreg,0,1)!='0' && min($minkls)==0){
                  $extra = 0.25;
                } else {
                  $extra = 0;
                }

                $urut = 1;

                $riwayatpoli = $this->transisi->get_kpoli($nmrj);
                if($riwayatpoli){
                  foreach ($riwayatpoli as $chpoli) {
                    if($chpoli->tglinput !=''){
                      $this->rekrajal($totreg,$chpoli->kodepoli,$idpeg,$chpoli->tglinput,'ri',$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
                    }
                  }
                }
                $riwayatkmop = $this->transisi->get_kkmop($nmrj);
                if($riwayatkmop){
                  foreach ($riwayatkmop as $chkmop) {
                      $this->rekkmop($totreg,$chkmop->kodekmop,$idpeg,$extra,$chkmop->tglinput,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
                  }
                }
                $databang = $this->transisi->get_kbang($nmrj);
                if($databang){
                  foreach($databang as $bang){
                    switch ($bang->kodebangsal) {
                      case 'PAV2':
                        $tbbang = 'dbangsaldua';
                        break;

                      default:
                        $tbbang = 'dbangsal';
                        break;
                    }
                    $riwayatbang = $this->transisi->hsl_gbang($tbbang,$nmrj);
                    if($riwayatbang){
                      foreach ($riwayatbang as $chbang) {
                          $this->rekranap($totreg,$chbang->kodebangsal,$idpeg,$extra,$chbang->tglinput,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
                      }
                      $tdrawat = $chbang->kodebangsal;
                    }

                  }
                }

                }
              }

              if(substr($mrek->qbmain_reg,0,2)=='ri'){
                $this->rekpenmed($totreg,substr($mrek->qbmain_reg,0,2),min($minkls),$idpeg,$extra,$tdrawat,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
              $this->rekadmin($totreg,substr($mrek->qbmain_reg,0,2),$extra,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
              $this->rektambahan($totreg,substr($mrek->qbmain_reg,0,2),$extra,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
              } else {
              $this->rekpenmed($totreg,substr($mrek->qbmain_reg,0,2),'',$idpeg,0,$tdrawat,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
              $this->rekadmin($totreg,substr($mrek->qbmain_reg,0,2),0,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
              $this->rektambahan($totreg,substr($mrek->qbmain_reg,0,2),0,$jentrans,strtoupper(substr($mrek->qbmain_reg,0,2)));
              }

            }
          }

          function rektambahan($totreg = FALSE,$jpx = FALSE,$extra = FALSE,$jentrans = FALSE,$typx = FALSE){
            $nmrj = substr($totreg,1);
            $normpas = '';
              $idpeg = $this->session->userdata('pgpid');
              $qsewa1 = $this->transisi->carisewa($nmrj);
              $jsewa1tot = 0;
              if($qsewa1){
                $jsewa1 = 0;
                if($jentrans != 'post'){
                  foreach ($qsewa1 as $sw1) { // isi detail bangsal farmasi
                    $qsat = $sw1->tarip + ($sw1->tarip * $extra);
                    $qjum = 1;
                    $datas1 = array(
                      'qbdet_idrs' => $sw1->id,
                      'qbdet_reg' => $sw1->noreg,
                      'qbdet_kat' => 'BIAYA LAIN',
                      'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($sw1->tanggal)),
                      'qbdet_item' => strtoupper($sw1->jenis).' - '.$sw1->jasa,
                      'qbdet_hrg' => $qsat,
                      'qbdet_jum' => $qjum,
                      'qbdet_thrg' => round($qsat),
                      'qbdet_jns' => 'ADMIN',
                      'qbdet_sjns' => strtoupper($sw1->jenis),
                      'qbdet_dok' => '---',
                      'qbdet_akses' => $idpeg
                    );
                    $this->transisi->simpqbildet($datas1);
                    $jsewa1tot = $jsewa1tot + $qsat;
                  }
                } else {
                  foreach ($qsewa1 as $sw1) { // isi detail bangsal farmasi
                    $qsat = $sw1->tarip + ($sw1->tarip * $extra);
                    $qjum = 1;
                    $datas1 = array(
                      'qbpost_idrs' => $sw1->id,
                    'qbpost_reg' => $typx.$totreg,
                      'qbpost_kat' => 'BIAYA LAIN',
                      'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($sw1->tanggal)),
                      'qbpost_item' => strtoupper($sw1->jenis).' - '.$sw1->jasa,
                      'qbpost_hrg' => $qsat,
                      'qbpost_jum' => $qjum,
                      'qbpost_thrg' => round($qsat),
                      'qbpost_jns' => 'ADMIN',
                      'qbpost_sjns' => strtoupper($sw1->jenis),
                      'qbpost_dok' => '---',
                      'qbpost_akses' => $idpeg
                    );
                    $this->transisi->simpqbilpost($datas1);
                  }
                }
                $jsewa1 = $jsewa1tot;
                $normpas = $sw1->id;
              } else {
                $jsewa1 = 0;
              }

              $qsewa2 = $this->transisi->carilain($nmrj);
              $jsewa2tot = 0;
              if($qsewa2){
                $jsewa2 = 0;
                if($jentrans != 'post'){
                  foreach ($qsewa2 as $sw2) { // isi detail bangsal farmasi
                    $cekracik = explode(' ',strtolower($sw2->item));
                    $isijenis = 'ADMIN';
                    $qsat = $sw2->rupiah + ($sw2->rupiah * $extra);
                    $qjum = $sw2->jumlah;
                    $datas2 = array(
                      'qbdet_idrs' => $sw2->id,
                      'qbdet_reg' => $sw2->noreg,
                      'qbdet_kat' => 'BIAYA LAIN',
                      'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($sw2->tglinput)),
                      'qbdet_item' => $sw2->item,
                      'qbdet_hrg' => $qsat,
                      'qbdet_jum' => $qjum,
                      'qbdet_thrg' => round($qsat * $qjum),
                      'qbdet_jns' => $isijenis,
                      'qbdet_sjns' => strtoupper($sw2->ket),
                      'qbdet_dok' => '---',
                      'qbdet_akses' => $idpeg
                    );
                    $this->transisi->simpqbildet($datas2);
                    $jsewa2tot = $jsewa2tot + round($qsat * $qjum);
                  }
                } else {
                  foreach ($qsewa2 as $sw2) { // isi detail bangsal farmasi
                    $cekracik = explode(' ',strtolower($sw2->item));
                    $isijenis = 'ADMIN';
                    $qsat = $sw2->rupiah + ($sw2->rupiah * $extra);
                    $qjum = $sw2->jumlah;
                    $datas2 = array(
                      'qbpost_idrs' => $sw2->id,
                    'qbpost_reg' => $typx.$totreg,
                      'qbpost_kat' => 'BIAYA LAIN',
                      'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($sw2->tglinput)),
                      'qbpost_item' => $sw2->item,
                      'qbpost_hrg' => $qsat,
                      'qbpost_jum' => $qjum,
                      'qbpost_thrg' => round($qsat * $qjum),
                      'qbpost_jns' => $isijenis,
                      'qbpost_sjns' => strtoupper($sw2->ket),
                      'qbpost_dok' => '---',
                      'qbpost_akses' => $idpeg
                    );
                    $this->transisi->simpqbilpost($datas2);
                  }
                }
                $jsewa2 = $jsewa2tot;
                $normpas = $sw2->id;
              } else {
                $jsewa2 = 0;
              }
              if($jentrans != 'post'){
                $datasw = array(
                  'qbdet_idrs' => $normpas,
                  'qbdet_reg' => $nmrj,
                  'qbdet_kat' => 'BIAYA LAIN',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $jsewa1 + $jsewa2,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'SW',
                  'qbdet_akses' => $idpeg
                );
                if($jsewa1 + $jsewa2>0){
                  $this->transisi->simpqbildet($datasw);
                }
              }
            }

          function rekadmin($totreg = FALSE,$jpx = FALSE,$extra = FALSE,$jentrans = FALSE,$typx = FALSE){
            $nmrj = substr($totreg,1);
            $jadmper=0;
            $jadmkar=0;
            $normpas = '';
            $idpeg = $this->session->userdata('pgpid');
            $qadm = $this->transisi->cariadmin($nmrj,$jpx);
            $jadmtot = 0;
            if($qadm){
              $jadmper = 0;
              if($jentrans != 'post'){
                foreach ($qadm as $adm) { // isi detail bangsal farmasi
                  $qsat = $adm->rupiah + ($adm->rupiah * $extra);
                  $qjum = $adm->jumlah;
                  $datad = array(
                    'qbdet_idrs' => $adm->id,
                    'qbdet_reg' => $adm->noreg,
                    'qbdet_kat' => 'ADMINISTRASI',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($adm->tglinput)),
                    'qbdet_item' => $jpx=='ri'?$adm->item:'Administrasi Rawat Jalan',
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat),
                    'qbdet_jns' => 'ADMIN',
                    'qbdet_sjns' => 'PERAWATAN',
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datad);
                  $jadmper = $qsat;
                  $normpas = $adm->id;
                }
              } else {
                foreach ($qadm as $adm) { // isi detail bangsal farmasi
                  $qsat = $adm->rupiah + ($adm->rupiah * $extra);
                  $qjum = $adm->jumlah;
                  $datad = array(
                    'qbpost_idrs' => $adm->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'ADMINISTRASI',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($adm->tglinput)),
                    'qbpost_item' => $jpx=='ri'?$adm->item:'Administrasi Rawat Jalan',
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat),
                    'qbpost_jns' => 'ADMIN',
                    'qbpost_sjns' => 'PERAWATAN',
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datad);
                }
              }
            }

            $qkrpoli = $this->transisi->carikrpol($nmrj);
            if($qkrpoli){
              $jadmkar = 0;
              if($jentrans != 'post'){
                foreach ($qkrpoli as $qkpl) { // isi detail poli farmasi
                  $qsat = $qkpl->jumlah + ($qkpl->jumlah * $extra);
                  $qjum = 1;
                  $dataadk = array(
                    'qbdet_idrs' => $qkpl->id,
                    'qbdet_reg' => $nmrj,
                    'qbdet_kat' => 'ADMINISTRASI',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qkpl->tgl)),
                    'qbdet_item' => 'Kartu Pasien',
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'ADMIN',
                    'qbdet_sjns' => 'KARTU',
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($dataadk);
                  $jadmkar = $qsat;
                  $normpas = $qkpl->id;
                }
              } else {
                foreach ($qkrpoli as $qkpl) { // isi detail poli farmasi
                  $qsat = $qkpl->jumlah + ($qkpl->jumlah * $extra);
                  $qjum = 1;
                  $dataadk = array(
                    'qbpost_idrs' => $qkpl->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'ADMINISTRASI',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qkpl->tgl)),
                    'qbpost_item' => 'Kartu Pasien',
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'ADMIN',
                    'qbpost_sjns' => 'KARTU',
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($dataadk);
                }
              }

            }

            if($jentrans != 'post'){
              $jadmtot = $jadmper + $jadmkar;
              if($jadmtot>0){
                $datada = array(
                  'qbdet_idrs' => $normpas,
                  'qbdet_reg' => $nmrj,
                  'qbdet_kat' => 'ADMINISTRASI',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $jadmtot,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'DA',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($datada);
              }
            }
          }

          function rekranap($totreg = FALSE,$kdbang = FALSE,$idpeg = FALSE,$extra = FALSE,$tgmpx = FALSE,$jentrans = FALSE,$typx = FALSE){
            $stharga = 0;
            $nmrj = substr($totreg,1);

            $qbangsal = $this->transisi->caribangsal($nmrj,$kdbang,$tgmpx);
            if($qbangsal) {
            $yos = array('0'=>'1','1'=>'2','2'=>'3','3'=>'4','4'=>'5','5'=>'6','6'=>'25','7'=>'24','8'=>'20','9'=>'22','10'=>'23','11'=>'17','12'=>'18','13'=>'19','14'=>'15');
            $hel = array('0'=>'14','1'=>'16','2'=>'21','3'=>'14A','4'=>'B14','5'=>'B16','6'=>'B21');
            $mik = array('0'=>'7','1'=>'8','2'=>'9','3'=>'10','4'=>'11','5'=>'12');
              if($jentrans != 'post'){
                foreach ($qbangsal as $qbsl) { //isi each detail bangsal kamar
                  switch ($qbsl->kelas) {
                    case '1':
                    $klrwt = 'satu';
                      break;

                    case '2':
                    $klrwt = 'dua';
                      break;

                    case '3':
                    $klrwt = 'tiga';
                      break;

                    default:
                    $klrwt = $qbsl->kelas;
                      break;
                  }
                  if(array_search($qbsl->kamar,$yos)!==false){
                    $nbangsal = 'Yosefa';
                  } elseif(array_search($qbsl->kamar,$hel)!==false){
                    $nbangsal = 'Helena';
                  } else {
                    $nbangsal = 'Mikaela';
                  }
                  $datab1 = array(
                    'qbdet_idrs' => $qbsl->id,
                    'qbdet_reg' => $qbsl->noreg,
                    'qbdet_kat' => 'KAMAR',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qbsl->tglinput)),
                    'qbdet_item' => $nbangsal.' - '.$qbsl->kamar.' Kelas '.$qbsl->kelas,
                    'qbdet_hrg' => $qbsl->hargabangsal,
                    'qbdet_jum' => 1,
                    'qbdet_thrg' => round($qbsl->hargabangsal),
                    'qbdet_jns' => 'TKAMAR',
                    'qbdet_sjns' => 'TBED',
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  if($qbsl->hargabangsal>0){
                    $this->transisi->simpqbildet($datab1);
                    $stharga = $stharga + $qbsl->hargabangsal;
                  }
                }
                // isi subttotal bangsal kamar
                $datab1a = array(
                  'qbdet_idrs' => $qbsl->id,
                  'qbdet_reg' => $qbsl->noreg,
                  'qbdet_kat' => 'KAMAR',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'B1A',
                  'qbdet_akses' => $idpeg
                );
                if($stharga>0){
                  $this->transisi->simpqbildet($datab1a);
                }
              $stharga = 0;
              } else {
                foreach ($qbangsal as $qbsl) { //isi each detail bangsal kamar
                  switch ($qbsl->kelas) {
                    case '1':
                    $klrwt = 'satu';
                      break;

                    case '2':
                    $klrwt = 'dua';
                      break;

                    case '3':
                    $klrwt = 'tiga';
                      break;

                    default:
                    $klrwt = $qbsl->kelas;
                      break;
                  }
                  if(array_search($qbsl->kamar,$yos)!==false){
                    $nbangsal = 'Yosefa';
                  } elseif(array_search($qbsl->kamar,$hel)!==false){
                    $nbangsal = 'Helena';
                  } else {
                    $nbangsal = 'Mikaela';
                  }
                  $datab1 = array(
                    'qbpost_idrs' => $qbsl->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'KAMAR',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qbsl->tglinput)),
                    'qbpost_item' => $nbangsal.' - '.$qbsl->kamar.' Kelas '.$qbsl->kelas,
                    'qbpost_hrg' => $qbsl->hargabangsal,
                    'qbpost_jum' => 1,
                    'qbpost_thrg' => round($qbsl->hargabangsal),
                    'qbpost_jns' => 'TKAMAR',
                    'qbpost_sjns' => 'TBED',
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  if($qbsl->hargabangsal>0){
                    $this->transisi->simpqbilpost($datab1);
                  }
              }
            }
            $klrwt = substr($klrwt,0,3)=='vip'?'vip':$klrwt;

            $qtbang = $this->transisi->caritbang($totreg,$kdbang,$klrwt,$tgmpx);
            if($qtbang){
              if($jentrans != 'post'){
                    $kdtkat = 'TIN.BANG';
                    $kdtjns = 'TINDAKAN';
                foreach ($qtbang as $qtbg) { // isi detail bangsal farmasi
                  $qsat = $qtbg->tdharga + ($qtbg->tdharga * $extra);
                  $qjum = 1;
                  $itemdet = str_replace('BPJS - ','',str_replace('UMUM - ','',$qtbg->tdnamatindakan));
                  $ardok = explode(' ',strtolower($itemdet));
                  if(array_search('dr.',$ardok)!==false || array_search('dr',$ardok)!==false || array_search('dokter',$ardok)!==false){
                    $kdtkat = 'JASA MEDIS';
                    $kdtjns = 'DOKTER';
                    $jasabang = 'JASMED';
                    $itemdet = str_replace('* ','',str_replace('- ','',$qtbg->dokter));
                  } elseif(strtolower(substr($itemdet,0,3))=='pmi') {
                    $jasabang = 'PMI';
                  } else {
                    $jasabang = 'TINPER';
                  }
                  $aritemdet = explode(' ',strtolower($itemdet));
                  if(array_search('adm', $aritemdet) !== false || array_search('admin', $aritemdet) !== false || array_search('administrasi', $aritemdet) !== false || array_search('biaya', $aritemdet) !== false){
                    $kdtkat = 'ADMINISTRASI';
                    $kdtjns = 'ADMIN';
                    $kdtsjn = 'PERAWATAN';
                  } else {
                    $kdtsjn = $jasabang;
                  }
                  $datab3 = array(
                    'qbdet_idrs' => $qtbg->id,
                    'qbdet_reg' => $qtbg->noreg,
                    'qbdet_kat' => $kdtkat,
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qtbg->tglinput)),
                    'qbdet_item' => $itemdet,
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => $kdtjns,
                    'qbdet_sjns' => $kdtsjn,
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  if($qtbg->tdharga > 0){
                    $this->transisi->simpqbildet($datab3);
                  }
                  $stharga = $stharga + round($qsat * $qjum);
                }
                // isi subttotal bangsal farmasi
                $datab3a = array(
                  'qbdet_idrs' => $qtbg->id,
                  'qbdet_reg' => $qtbg->noreg,
                  'qbdet_kat' => 'TIN.BANG',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'B3A',
                  'qbdet_akses' => $idpeg
                );
                if($stharga > 0){
                  $this->transisi->simpqbildet($datab3a);
                }
                $stharga = 0;
              } else {
                foreach ($qtbang as $qtbg) { // isi detail bangsal farmasi
                  $qsat = $qtbg->tdharga + ($qtbg->tdharga * $extra);
                  $qjum = 1;
                  $kdtkat = 'TIN.BANG';
                  $kdtjns = 'TINDAKAN';
                  $itemdet = str_replace('BPJS - ','',str_replace('UMUM - ','',$qtbg->tdnamatindakan));
                  $ardok = explode(' ',strtolower($itemdet));
                  if(array_search('dr.',$ardok)!==false || array_search('dr',$ardok)!==false || array_search('dokter',$ardok)!==false){
                    $kdtkat = 'JASA MEDIS';
                    $kdtjns = 'DOKTER';
                    $jasabang = 'JASMED';
                        $itemdet = str_replace('* ','',str_replace('- ','',$qtbg->dokter));
                  } elseif(strtolower(substr($itemdet,0,3))=='pmi') {
                    $jasabang = 'PMI';
                  } else {
                    $jasabang = 'TINPER';
                  }
                  $aritemdet = explode(' ',strtolower($itemdet));
                  if(array_search('adm', $aritemdet) !== false || array_search('admin', $aritemdet) !== false || array_search('administrasi', $aritemdet) !== false || array_search('biaya', $aritemdet) !== false){
                    $kdtkat = 'ADMINISTRASI';
                    $kdtjns = 'ADMIN';
                    $kdtsjn = 'PERAWATAN';
                  } else {
                    $kdtsjn = $jasabang;
                  }
                  $datab3 = array(
                    'qbpost_idrs' => $qtbg->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => $kdtkat,
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qtbg->tglinput)),
                    'qbpost_item' => $itemdet,
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => $kdtjns,
                    'qbpost_sjns' => $kdtsjn,
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  if($qtbg->tdharga > 0){
                    $this->transisi->simpqbilpost($datab3);
                  }
                }
              }
            }

          }

            $qfbang = $this->transisi->carifbang($totreg,$kdbang,$tgmpx);
            if($qfbang){
              if($jentrans != 'post'){
                foreach ($qfbang as $qfbg) { // isi detail bangsal farmasi
                  $qsat = $qfbg->inhargajual + ($qfbg->inhargajual * $extra);
                  $qjum = $qfbg->jumlah;
                  $datab2 = array(
                    'qbdet_idrs' => $qfbg->id,
                    'qbdet_reg' => $qfbg->noreg,
                    'qbdet_kat' => 'FRM.BANG',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qfbg->tglinput)),
                    'qbdet_item' => $qfbg->innamaobat,
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'FARMASI',
                    'qbdet_sjns' => strtoupper($qfbg->injenisbarang),
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datab2);
                  $stharga = $stharga + round($qsat * $qjum);
                }
                // isi subttotal bangsal farmasi
                $datab2a = array(
                  'qbdet_idrs' => $qfbg->id,
                  'qbdet_reg' => $qfbg->noreg,
                  'qbdet_kat' => 'FRM.BANG',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'B2A',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($datab2a);
              } else {
                foreach ($qfbang as $qfbg) { // isi detail bangsal farmasi
                  $qsat = $qfbg->inhargajual + ($qfbg->inhargajual * $extra);
                  $qjum = $qfbg->jumlah;
                  $datab2 = array(
                    'qbpost_idrs' => $qfbg->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'FRM.BANG',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qfbg->tglinput)),
                    'qbpost_item' => $qfbg->innamaobat,
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'FARMASI',
                    'qbpost_sjns' => strtoupper($qfbg->injenisbarang),
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datab2);
                }
              }
              $stharga = 0;
            }

            $qfapo = $this->transisi->carifapo($totreg,'Ranap',$tgmpx);
            if($qfapo){
              if($jentrans != 'post'){
                foreach ($qfapo as $qap) { // isi detail poli farmasi
                  $qsat = $qap->hargajual + ($qap->hargajual * $extra);
                  $qjum = $qap->jumlah;
                  $dataf1 = array(
                    'qbdet_idrs' => $qap->id,
                    'qbdet_reg' => $qap->noreg,
                    'qbdet_kat' => 'FRM.APOTEK BANGSAL',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qap->tglinput)),
                    'qbdet_item' => $qap->namaobat,
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'FARMASI',
                    'qbdet_sjns' => strtoupper($qap->jenisbarang),
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($dataf1);
                  $stharga = $stharga + round($qsat * $qjum);
                }
                // isi subttotal poli
                $dataf1a = array(
                  'qbdet_idrs' => $qap->id,
                  'qbdet_reg' => $qap->noreg,
                  'qbdet_kat' => 'FRM.APOTEK BANGSAL',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'F1A',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($dataf1a);
                $stharga = 0;
              } else {
                foreach ($qfapo as $qap) { // isi detail poli farmasi
                  $qsat = $qap->hargajual + ($qap->hargajual * $extra);
                  $qjum = $qap->jumlah;
                  $dataf1 = array(
                    'qbpost_idrs' => $qap->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'FRM.APOTEK BANGSAL',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qap->tglinput)),
                    'qbpost_item' => $qap->namaobat,
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'FARMASI',
                    'qbpost_sjns' => strtoupper($qap->jenisbarang),
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($dataf1);
                  $stharga = $stharga + round($qsat * $qjum);
                }
              }
            }

            $qdbangsal = $this->transisi->caridbangsal($totreg,$kdbang,$tgmpx);
            if($qdbangsal){
              if($jentrans != 'post'){
                foreach ($qdbangsal as $qdbsl) { // isi detail bangsal dokter
                  $qsat = $qdbsl->taripdokter + ($qdbsl->taripdokter * $extra);
                  $qjum = 1;
                  $datab3 = array(
                    'qbdet_idrs' => $qdbsl->id,
                    'qbdet_reg' => $qdbsl->noreg,
                    'qbdet_kat' => 'JASA MEDIS',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qdbsl->tglinput)),
                    'qbdet_item' => preg_replace(array("/-/","/\*/"),'',$qdbsl->namadokter),
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'DOKTER',
                    'qbdet_sjns' => 'JASMED',
                    'qbdet_dok' => $qdbsl->kodedokter,
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datab3);
                  $stharga = $stharga + round($qsat * $qjum);
                }
                // isi subttotal bangsal farmasi
                $datab3a = array(
                  'qbdet_idrs' => $qdbsl->id,
                  'qbdet_reg' => $qdbsl->noreg,
                  'qbdet_kat' => 'JASA MEDIS',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'B3A',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($datab3a);
                $stharga = 0;
              } else {
                foreach ($qdbangsal as $qdbsl) { // isi detail bangsal dokter
                  $qsat = $qdbsl->taripdokter + ($qdbsl->taripdokter * $extra);
                  $qjum = 1;
                  $datab3 = array(
                    'qbpost_idrs' => $qdbsl->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'JASA MEDIS',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qdbsl->tglinput)),
                    'qbpost_item' => preg_replace(array("/-/","/\*/"),'',$qdbsl->namadokter),
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'DOKTER',
                    'qbpost_sjns' => 'JASMED',
                    'qbpost_dok' => $qdbsl->kodedokter,
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datab3);
                }
              }
            }

          }

          function rekrajal($totreg = FALSE,$kdpol = FALSE,$idpeg = FALSE,$tgmpx = FALSE,$israjal = FALSE,$jentrans = FALSE,$typx = FALSE){
            $stharga = 0;
            $nmrj = substr($totreg,1);
            $kdasr = substr($totreg,0,1);
            switch ($kdasr) {
              case '1':
                $asur = 'bpjs';
                break;

              default:
                $asur = 'rs';
                break;
            }
            if(substr($kdpol,0,2)=='cp'){
              $kdapo = 'Rajal';
            }
            $qfapo = $this->transisi->carifapo($totreg,$kdapo,$tgmpx);
            if($qfapo){
              if($jentrans != 'post'){
                foreach ($qfapo as $qap) { // isi detail poli farmasi
                  $dataf1 = array(
                    'qbdet_idrs' => $qap->id,
                    'qbdet_reg' => $qap->noreg,
                    'qbdet_kat' => 'FRM.APOTEK POLI',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qap->tglinput)),
                    'qbdet_item' => $qap->namaobat,
                    'qbdet_hrg' => $qap->hargajual,
                    'qbdet_jum' => $qap->jumlah,
                    'qbdet_thrg' => round($qap->hargajual * $qap->jumlah),
                    'qbdet_jns' => 'FARMASI',
                    'qbdet_sjns' => strtoupper($qap->jenisbarang),
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($dataf1);
                  $stharga = $stharga + $qap->hargajual * $qap->jumlah;
                }

                $dataf1a = array(
                  'qbdet_idrs' => $qap->id,
                  'qbdet_reg' => $qap->noreg,
                  'qbdet_kat' => 'FRM.APOTEK POLI',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'F1A',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($dataf1a);
              } else {
                foreach ($qfapo as $qap) { // isi detail poli farmasi
                  $dataf1 = array(
                    'qbpost_idrs' => $qap->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'FRM.APOTEK POLI',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qap->tglinput)),
                    'qbpost_item' => $qap->namaobat,
                    'qbpost_hrg' => $qap->hargajual,
                    'qbpost_jum' => $qap->jumlah,
                    'qbpost_thrg' => round($qap->hargajual * $qap->jumlah),
                    'qbpost_jns' => 'FARMASI',
                    'qbpost_sjns' => strtoupper($qap->jenisbarang),
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($dataf1);
                }
              }
              $stharga = 0;
            }

            $crntdpol = $this->transisi->carantritpol();
            if($crntdpol){
              foreach ($crntdpol as $hctdpol) {
                $qpoli = $this->transisi->carifpoli($totreg,$kdpol,$tgmpx,$hctdpol['kodepoli'],$hctdpol['antrian']);
                if($qpoli){
                  if($jentrans != 'post'){
                    foreach ($qpoli as $qpl) { // isi detail poli farmasi
                      $datap1 = array(
                        'qbdet_idrs' => $qpl->id,
                        'qbdet_reg' => $qpl->noreg,
                        'qbdet_kat' => 'FRM.POLI',
                        'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qpl->tglinput)),
                        'qbdet_item' => $qpl->innamaobat,
                        'qbdet_hrg' => $qpl->inhargajual,
                        'qbdet_jum' => $qpl->jumlah,
                        'qbdet_thrg' => round($qpl->inhargajual * $qpl->jumlah),
                        'qbdet_jns' => 'FARMASI',
                        'qbdet_sjns' => strtoupper($qpl->injenisbarang),
                        'qbdet_dok' => '---',
                        'qbdet_akses' => $idpeg
                      );
                      $this->transisi->simpqbildet($datap1);
                      $stharga = $stharga + $qpl->inhargajual * $qpl->jumlah;
                    }

                    $datap1a = array(
                      'qbdet_idrs' => $qpl->id,
                      'qbdet_reg' => $qpl->noreg,
                      'qbdet_kat' => 'FRM.POLI',
                      'qbdet_tginput' => date('Y-m-d H:i:s'),
                      'qbdet_hrg' => $stharga,
                      'qbdet_jns' => 'SUBTOTAL',
                      'qbdet_sjns' => 'B3A',
                      'qbdet_akses' => $idpeg
                    );
                    $this->transisi->simpqbildet($datap1a);
                  } else {
                    foreach ($qpoli as $qpl) { // isi detail poli farmasi
                      $datap1 = array(
                        'qbpost_idrs' => $qpl->id,
                        'qbpost_reg' => $typx.$totreg,
                        'qbpost_kat' => 'FRM.POLI',
                        'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qpl->tglinput)),
                        'qbpost_item' => $qpl->innamaobat,
                        'qbpost_hrg' => $qpl->inhargajual,
                        'qbpost_jum' => $qpl->jumlah,
                        'qbpost_thrg' => round($qpl->inhargajual * $qpl->jumlah),
                        'qbpost_jns' => 'FARMASI',
                        'qbpost_sjns' => strtoupper($qpl->injenisbarang),
                        'qbpost_dok' => '---',
                        'qbpost_akses' => $idpeg
                      );
                      $this->transisi->simpqbilpost($datap1);
                    }
                  }
                  $stharga = 0;
                }
              }

            }

            $crntdpol = $this->transisi->carantritpol();
            if($crntdpol){
              foreach ($crntdpol as $hctdpol) {
                $qtpoli = $this->transisi->caritpoli($totreg,$kdpol,$tgmpx,$hctdpol['kodepoli'],$hctdpol['antrian']);
                if($qtpoli){
                  if($jentrans != 'post'){
                        $kdtkat = 'TIN.POLI';
                        $kdtjns = 'TINDAKAN';
                    foreach ($qtpoli as $qtp) { // isi detail poli farmasi
                      $qsat = $qtp->tdharga;
                      $qjum = 1;
                      $itemdet = str_replace('BPJS - ','',str_replace('UMUM - ','',$qtp->tdnama));
                      $ardok = explode(' ',strtolower($itemdet));
                      if(array_search('dr.',$ardok)!==false || array_search('dr',$ardok)!==false || array_search('dokter',$ardok)!==false){
                        $kdtkat = 'JASA MEDIS';
                        $kdtjns = 'DOKTER';
                        $jasapoli = 'JASMED';
                        $itemdet = str_replace('* ','',str_replace('- ','',$qtp->dokter));
                      } elseif(array_search('imunisasi',$ardok)!==false){
                        $jasapoli = 'VAKSINASI';
                      } elseif(strtolower(substr($itemdet,0,3))=='pmi') {
                        $jasapoli = 'PMI';
                      } elseif(strtolower(substr($itemdet,-3))=='ekg') {
                        $jasapoli = 'ECG';
                      } else {
                        $jasapoli = 'TINPER';
                      }
                      $aritemdet = explode(' ',strtolower($itemdet));
                      if(array_search('adm', $aritemdet) !== false || array_search('admin', $aritemdet) !== false || array_search('administrasi', $aritemdet) !== false || array_search('biaya', $aritemdet) !== false){
                        $kdtkat = 'ADMINISTRASI';
                        $kdtjns = 'ADMIN';
                        $kdtsjn = 'PERAWATAN';
                      } else {
                        $kdtsjn = $jasapoli;
                      }
                      $datap3 = array(
                        'qbdet_idrs' => $qtp->id,
                        'qbdet_reg' => $qtp->noreg,
                        'qbdet_kat' => $kdtkat,
                        'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qtp->tglinput)),
                        'qbdet_item' => $itemdet,
                        'qbdet_hrg' => $qsat,
                        'qbdet_jum' => $qjum,
                        'qbdet_thrg' => round($qsat * $qjum),
                        'qbdet_jns' => $kdtjns,
                        'qbdet_sjns' => $kdtsjn,
                        'qbdet_dok' => '---',
                        'qbdet_akses' => $idpeg
                      );
                      $this->transisi->simpqbildet($datap3);
                      $stharga = $stharga + round($qsat * $qjum);
                    }
                    $datap3a = array(
                      'qbdet_idrs' => $qtp->id,
                      'qbdet_reg' => $qtp->noreg,
                      'qbdet_kat' => 'TIN.POLI',
                      'qbdet_tginput' => date('Y-m-d H:i:s'),
                      'qbdet_hrg' => $stharga,
                      'qbdet_jns' => 'SUBTOTAL',
                      'qbdet_sjns' => 'P3A',
                      'qbdet_akses' => $idpeg
                    );
                    $this->transisi->simpqbildet($datap3a);
                  } else {
                    foreach ($qtpoli as $qtp) { // isi detail poli farmasi
                      $qsat = $qtp->tdharga;
                      $qjum = 1;
                      $kdtkat = 'TIN.POLI';
                      $kdtjns = 'TINDAKAN';
                      $itemdet = str_replace('BPJS - ','',str_replace('UMUM - ','',$qtp->tdnama));
                      $ardok = explode(' ',strtolower($itemdet));
                      if(array_search('dr.',$ardok)!==false || array_search('dr',$ardok)!==false || array_search('dokter',$ardok)!==false){
                        $kdtkat = 'JASA MEDIS';
                        $kdtjns = 'DOKTER';
                        $jasapoli = 'JASMED';
                        $itemdet = str_replace('* ','',str_replace('- ','',$qtp->dokter));
                      } elseif(array_search('imunisasi',$ardok)!==false){
                        $jasapoli = 'VAKSINASI';
                      } elseif(strtolower(substr($itemdet,0,3))=='pmi') {
                        $jasapoli = 'PMI';
                      } elseif(strtolower(substr($itemdet,-3))=='ekg') {
                        $jasapoli = 'ECG';
                      } else {
                        $jasapoli = 'TINPER';
                      }
                      $aritemdet = explode(' ',strtolower($itemdet));
                      if(array_search('adm', $aritemdet) !== false || array_search('admin', $aritemdet) !== false || array_search('administrasi', $aritemdet) !== false || array_search('biaya', $aritemdet) !== false){
                        $kdtkat = 'ADMINISTRASI';
                        $kdtjns = 'ADMIN';
                        $kdtsjn = 'PERAWATAN';
                      } else {
                        $kdtsjn = $jasapoli;
                      }
                      $datap3 = array(
                        'qbpost_idrs' => $qtp->id,
                        'qbpost_reg' => $typx.$totreg,
                        'qbpost_kat' => $kdtkat,
                        'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qtp->tglinput)),
                        'qbpost_item' => $itemdet,
                        'qbpost_hrg' => $qsat,
                        'qbpost_jum' => $qjum,
                        'qbpost_thrg' => round($qsat * $qjum),
                        'qbpost_jns' => $kdtjns,
                        'qbpost_sjns' => $kdtsjn,
                        'qbpost_dok' => '---',
                        'qbpost_akses' => $idpeg
                      );
                      $this->transisi->simpqbilpost($datap3);
                    }
                  }
                  $stharga = 0;
                }
              }
            }
          }

          function rekkmop($totreg = FALSE,$kdok = FALSE,$idpeg = FALSE,$extra = FALSE,$tgmpx = FALSE,$jentrans = FALSE,$typx = FALSE){
            $stharga = 0;
            $nmrj = substr($totreg,1);
            $kdasr = substr($totreg,0,1);
            switch ($kdasr) {
              case '1':
                $asur = 'bpjs';
                break;

              default:
                $asur = 'rs';
                break;
            }
            $qkkmop = $this->transisi->carikkmop($nmrj,$tgmpx);
            if($qkkmop) {
              if($jentrans != 'post'){
                foreach ($qkkmop as $qkop) { // isi detail kmop kamar
                  $qsat = $qkop->hrkmop + ($qkop->hrkmop * $extra);
                  $qjum = 1;
                  $datao1 = array(
                    'qbdet_idrs' => $qkop->id,
                    'qbdet_reg' => $qkop->noreg,
                    'qbdet_kat' => 'KAMAR.TINDAKAN',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qkop->tglinput)),
                    'qbdet_item' => $qkop->nmkmop,
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'KAMAR.TIN',
                    'qbdet_sjns' => 'TBED',
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datao1);
                  $stharga = $stharga + round($qsat * $qjum);
                }
              } else {
                foreach ($qkkmop as $qkop) { // isi detail kmop kamar
                  $qsat = $qkop->hrkmop + ($qkop->hrkmop * $extra);
                  $qjum = 1;
                  $datao1 = array(
                    'qbpost_idrs' => $qkop->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'KAMAR.TINDAKAN',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qkop->tglinput)),
                    'qbpost_item' => $qkop->nmkmop,
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'KAMAR.TIN',
                    'qbpost_sjns' => 'TBED',
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datao1);
                }
              }

              if($jentrans != 'post'){
                $datao1a = array(
                  'qbdet_idrs' => $qkop->id,
                  'qbdet_reg' => $qkop->noreg,
                  'qbdet_kat' => 'KAMAR.TINDAKAN',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'O1A',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($datao1a);
              }
              $stharga = 0;
            }
            $qfkmop = $this->transisi->carifkmop($totreg,$tgmpx);
            if($qfkmop) {
              if($jentrans != 'post'){
                foreach ($qfkmop as $qfok) { // isi detail kmop farmasi
                  $qsat = $qfok->inhargajual + ($qfok->inhargajual * $extra);
                  $qjum = $qfok->jumlah;
                  $datao2 = array(
                    'qbdet_idrs' => $qfok->id,
                    'qbdet_reg' => $qfok->noreg,
                    'qbdet_kat' => 'FRM.KMOP',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qfok->tglinput)),
                    'qbdet_item' => $qfok->innamaobat,
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'FARMASI',
                    'qbdet_sjns' => strtoupper($qfok->injenisbarang),
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datao2);
                  $stharga = $stharga + round($qsat * $qjum);
                }
              } else {
                foreach ($qfkmop as $qfok) { // isi detail kmop farmasi
                  $qsat = $qfok->inhargajual + ($qfok->inhargajual * $extra);
                  $qjum = $qfok->jumlah;
                  $datao2 = array(
                    'qbpost_idrs' => $qfok->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'FRM.KMOP',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qfok->tglinput)),
                    'qbpost_item' => $qfok->innamaobat,
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'FARMASI',
                    'qbpost_sjns' => strtoupper($qfok->injenisbarang),
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datao2);
                }
              }

/*              $datao2a = array(
                'qbdet_idrs' => $qfok->id,
                'qbdet_reg' => $qfok->noreg,
                'qbdet_kat' => 'FRM.KMOP',
                'qbdet_tginput' => date('Y-m-d H:i:s'),
                'qbdet_hrg' => $stharga,
                'qbdet_jns' => 'SUBTOTAL',
                'qbdet_sjns' => 'O2A',
                'qbdet_akses' => $idpeg
              );
              $this->transisi->simpqbildet($datao2a); */
            }
            $qskmop = $this->transisi->cariskmop($totreg,$tgmpx);
            if($qskmop) {
              if($jentrans != 'post'){
                foreach ($qskmop as $qsok) { // isi detail kmop farmasi
                  $qsat = $qsok->inhargajual + ($qsok->inhargajual * $extra);
                  $qjum = $qsok->jumlah;
                  $datao6 = array(
                    'qbdet_idrs' => $qsok->id,
                    'qbdet_reg' => $qsok->noreg,
                    'qbdet_kat' => 'FRM.KMOP',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qsok->tglinput)),
                    'qbdet_item' => $qsok->innamaalat,
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'FARMASI',
                    'qbdet_sjns' => 'ALAT KESEHATAN',
                    'qbdet_dok' => '---',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datao6);
                  $stharga = $stharga + round($qsat * $qjum);
                }
              } else {
                foreach ($qskmop as $qsok) { // isi detail kmop farmasi
                  $qsat = $qsok->inhargajual + ($qsok->inhargajual * $extra);
                  $qjum = $qsok->jumlah;
                  $datao6 = array(
                    'qbpost_idrs' => $qsok->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'FRM.KMOP',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qsok->tglinput)),
                    'qbpost_item' => $qsok->innamaalat,
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'FARMASI',
                    'qbpost_sjns' => 'ALAT KESEHATAN',
                    'qbpost_dok' => '---',
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datao6);
                }
              }
              if($jentrans != 'post'){
                $datao6a = array(
                  'qbdet_idrs' => $qsok->id,
                  'qbdet_reg' => $qsok->noreg,
                  'qbdet_kat' => 'FRM.KMOP',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'O6A',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($datao6a);
              }
              $stharga = 0;
            }
            $qdkmop = $this->transisi->caridkmop($totreg,$tgmpx);
            if($qdkmop) {
              if($jentrans != 'post'){
                foreach ($qdkmop as $qdop) { // isi detail kmop dokter
                  $qsat = $qdop->taripdokter + ($qdop->taripdokter * $extra);
                  $qjum = 1;
                  $datao3 = array(
                    'qbdet_idrs' => $qdop->id,
                    'qbdet_reg' => $qdop->noreg,
                    'qbdet_kat' => 'JASA MEDIS',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qdop->tglinput)),
                    'qbdet_item' => preg_replace(array("/-/","/\*/"),'',$qdop->namadokter),
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'DOKTER',
                    'qbdet_sjns' => $qdop->ket=='operator'?'BEDAH':'JASMED',
                    'qbdet_dok' => $qdop->kodedokter,
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datao3);
                  $stharga = $stharga + round($qsat * $qjum);
                }
                // isi subtotal kmop farmasi
                $datao3a = array(
                  'qbdet_idrs' => $qdop->id,
                  'qbdet_reg' => $qdop->noreg,
                  'qbdet_kat' => 'JASA MEDIS',
                  'qbdet_tginput' => date('Y-m-d H:i:s'),
                  'qbdet_hrg' => $stharga,
                  'qbdet_jns' => 'SUBTOTAL',
                  'qbdet_sjns' => 'O3A',
                  'qbdet_akses' => $idpeg
                );
                $this->transisi->simpqbildet($datao3a);
              } else {
                foreach ($qdkmop as $qdop) { // isi detail kmop dokter
                  $qsat = $qdop->taripdokter + ($qdop->taripdokter * $extra);
                  $qjum = 1;
                  $datao3 = array(
                    'qbpost_idrs' => $qdop->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'JASA MEDIS',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qdop->tglinput)),
                    'qbpost_item' => preg_replace(array("/-/","/\*/"),'',$qdop->namadokter),
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'DOKTER',
                    'qbpost_sjns' => $qdop->ket=='operator'?'BEDAH':'JASMED',
                    'qbpost_dok' => $qdop->kodedokter,
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datao3);
                }
              }
              $stharga = 0;
            }
            $qpkmop = $this->transisi->caripkmop($totreg,'round',$tgmpx);
            $jpkmop1 = 0;
            $jpkmop2 = 0;
            $nrmpas = '';
            if($qpkmop) {
              if($jentrans != 'post'){
                foreach ($qpkmop as $qpop) { // isi detail kmop dokter
                  $qsat = $qpop->taripperawat + ($qpop->taripperawat * $extra);
                  $qjum = 1;
                  $datao4 = array(
                    'qbdet_idrs' => $qpop->id,
                    'qbdet_reg' => $qpop->noreg,
                    'qbdet_kat' => 'JASA MEDIS',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qpop->tglinput)),
                    'qbdet_item' => preg_replace(array("/-/","/\*/"),'',$qpop->namaperawat),
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'PERAWAT',
                    'qbdet_sjns' => 'JASMED',
                    'qbdet_dok' => $qpop->kodeperawat,
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datao4);
                  $jpkmop1 = $jpkmop1 + round($qsat * $qjum);
                }
              } else {
                foreach ($qpkmop as $qpop) { // isi detail kmop dokter
                  $qsat = $qpop->taripperawat + ($qpop->taripperawat * $extra);
                  $qjum = 1;
                  $datao4 = array(
                    'qbpost_idrs' => $qpop->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'JASA MEDIS',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qpop->tglinput)),
                    'qbpost_item' => preg_replace(array("/-/","/\*/"),'',$qpop->namaperawat),
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'PERAWAT',
                    'qbpost_sjns' => 'JASMED',
                    'qbpost_dok' => $qpop->kodeperawat,
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datao4);
                }
              }
              $nrmpas = $qpop->id;
            } else {
              $jpkmop1 = 0;
            }
            $qokmop = $this->transisi->caripkmop($totreg,'assis',$tgmpx);
            if($qokmop) {
              if($jentrans != 'post'){
                foreach ($qokmop as $qoop) { // isi detail kmop dokter
                  $qsat = $qoop->tarip + ($qoop->tarip * $extra);
                  $qjum = 1;
                  $datao5 = array(
                    'qbdet_idrs' => $qoop->id,
                    'qbdet_reg' => $qoop->noreg,
                    'qbdet_kat' => 'JASA MEDIS',
                    'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qoop->tglinput)),
                    'qbdet_item' => preg_replace(array("/-/","/\*/"),'',$qoop->namaperawat),
                    'qbdet_hrg' => $qsat,
                    'qbdet_jum' => $qjum,
                    'qbdet_thrg' => round($qsat * $qjum),
                    'qbdet_jns' => 'PERAWAT',
                    'qbdet_sjns' => 'JASMED',
                    'qbdet_dok' => $qoop->kodeperawat,
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datao5);
                  $jpkmop2 = $jpkmop2 + round($qsat * $qjum);
                }
              } else {
                foreach ($qokmop as $qoop) { // isi detail kmop dokter
                  $qsat = $qoop->tarip + ($qoop->tarip * $extra);
                  $qjum = 1;
                  $datao5 = array(
                    'qbpost_idrs' => $qoop->id,
                    'qbpost_reg' => $typx.$totreg,
                    'qbpost_kat' => 'JASA MEDIS',
                    'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qoop->tglinput)),
                    'qbpost_item' => preg_replace(array("/-/","/\*/"),'',$qoop->namaperawat),
                    'qbpost_hrg' => $qsat,
                    'qbpost_jum' => $qjum,
                    'qbpost_thrg' => round($qsat * $qjum),
                    'qbpost_jns' => 'PERAWAT',
                    'qbpost_sjns' => 'JASMED',
                    'qbpost_dok' => $qoop->kodeperawat,
                    'qbpost_akses' => $idpeg
                  );
                  $this->transisi->simpqbilpost($datao5);
                }
              }
              $nrmpas = $qoop->id;
            } else {
              $jpkmop2 = 0;
            }
            if($jentrans != 'post'){
              $stharga = $jpkmop1 + $jpkmop2;
              $datao5a = array(
                'qbdet_idrs' => $nrmpas,
                'qbdet_reg' => substr($totreg,1),
                'qbdet_kat' => 'JASA MEDIS',
                'qbdet_tginput' => date('Y-m-d H:i:s'),
                'qbdet_hrg' => $stharga,
                'qbdet_jns' => 'SUBTOTAL',
                'qbdet_sjns' => 'O5A',
                'qbdet_akses' => $idpeg
              );
              if($stharga>0){
                $this->transisi->simpqbildet($datao5a);
              }
            }

            $stharga = 0;
          }

          function rekpenmed($totreg=FALSE,$tpmed=FALSE,$isimin=FALSE,$idpeg=FALSE,$extra=FALSE,$tdrawat = FALSE,$jentrans = FALSE,$typx = FALSE){
            $jlab=0;
            $jrad=0;
            $jgiz=0;
            $jusg=0;
            $stharga = 0;
            $itemlab = FALSE;
            $nmrj = substr($totreg,1);
            $kdasr = substr($totreg,0,1);
            $riwayatpmed = $this->transisi->get_kpmed($nmrj);
            if($riwayatpmed){
              foreach ($riwayatpmed as $chpmed) {
                $jpmed = substr(strtolower($chpmed->hasil),0,3);
                $apmed = substr(strtolower($chpmed->asalpasien),0,3);
                $tgmpx = $chpmed->tglinput;

                switch ($kdasr) {
                  case '1':
                    $asur = 'bpjs';
                    break;

                  default:
                    $asur = 'rs';
                    break;
                }

                $kdpenj = $jpmed;
                $tottinpenmed = 0;
                $normpas = '';
                if($kdpenj == 'lab'){
                  $jlab = 0;
                  $cekpaket = $this->transisi->caripaket($nmrj);

                  if($cekpaket){
                    foreach ($cekpaket as $cpkt) {
                      if($cpkt->p_rajal=='1'){
                        $tpmed = 'rj';
                      } elseif($cpkt->p_ranap=='1'){
                        $tpmed = 'ri';
                      }

                      $itemlab = $this->transisi->isilab($totreg,$jpmed,$apmed,$tpmed,$isimin,$cpkt->tanggal,$tdrawat,$cpkt->pemeriksaan);
                      if($itemlab) {
                        foreach ($itemlab as $pxlab) {
                          if($jentrans != 'post'){
                            if($pxlab->utarip > 0){
                              $qsat = $pxlab->utarip + ($pxlab->utarip * $extra);
                              $qjum = 1;
                              $datal1 = array(
                                'qbdet_idrs' => $pxlab->id,
                                'qbdet_reg' => $pxlab->noreg,
                                'qbdet_kat' => 'TIN.PMED',
                                'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($pxlab->jaminput)),
                                'qbdet_item' => $pxlab->pemeriksaan,
                                'qbdet_hrg' => $qsat,
                                'qbdet_jum' => $qjum,
                                'qbdet_thrg' => round($qsat * $qjum),
                                'qbdet_jns' => 'TINDAKAN',
                                'qbdet_sjns' => 'LAB',
                                'qbdet_dok' => '---',
                                'qbdet_akses' => $idpeg
                              );
                              $this->transisi->simpqbildet($datal1);
                              $jlab = $jlab + round($qsat * $qjum);
                    $normpas = $pxlab->id;
                            }
                          } else {
                            if($pxlab->utarip > 0){
                              $qsat = $pxlab->utarip + ($pxlab->utarip * $extra);
                              $qjum = 1;
                              $datal1 = array(
                                'qbpost_idrs' => $pxlab->id,
                    'qbpost_reg' => $typx.$totreg,
                                'qbpost_kat' => 'TIN.PMED',
                                'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($pxlab->jaminput)),
                                'qbpost_item' => $pxlab->pemeriksaan,
                                'qbpost_hrg' => $qsat,
                                'qbpost_jum' => $qjum,
                                'qbpost_thrg' => round($qsat * $qjum),
                                'qbpost_jns' => 'TINDAKAN',
                                'qbpost_sjns' => 'LAB',
                                'qbpost_dok' => '---',
                                'qbpost_akses' => $idpeg
                              );
                              $this->transisi->simpqbilpost($datal1);
                            }
                          }
                        }
                      }
                    }
                  } else {
                    $normpas = '';
                    $jlab = 0;
                  }
                } elseif($kdpenj == 'rad') {
                  $itemrad = $this->transisi->isirad($totreg,$jpmed,$apmed,$tpmed,$isimin,$tgmpx,$tdrawat);
                  if($itemrad) {
                    $normpas = '';
                    $jrad = 0;
                      if($jentrans != 'post'){
                        foreach ($itemrad as $pxrad) {
                          $qsat = $pxrad->utarip + ($pxrad->utarip * $extra);
                          $qjum = 1;
                          $datar1 = array(
                            'qbdet_idrs' => $pxrad->id,
                            'qbdet_reg' => $pxrad->noreg,
                            'qbdet_kat' => 'TIN.PMED',
                            'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($pxrad->jaminput)),
                            'qbdet_item' => $pxrad->pemeriksaan,
                            'qbdet_hrg' => $qsat,
                            'qbdet_jum' => $qjum,
                            'qbdet_thrg' => round($qsat * $qjum),
                            'qbdet_jns' => 'TINDAKAN',
                            'qbdet_sjns' => 'RAD',
                            'qbdet_dok' => '---',
                            'qbdet_akses' => $idpeg
                          );
                          $this->transisi->simpqbildet($datar1);
                          $jrad = $jrad + round($qsat * $qjum);
                        }
                      } else {
                        foreach ($itemrad as $pxrad) {
                          $qsat = $pxrad->utarip + ($pxrad->utarip * $extra);
                          $qjum = 1;
                          $datar1 = array(
                            'qbpost_idrs' => $pxrad->id,
                    'qbpost_reg' => $typx.$totreg,
                            'qbpost_kat' => 'TIN.PMED',
                            'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($pxrad->jaminput)),
                            'qbpost_item' => $pxrad->pemeriksaan,
                            'qbpost_hrg' => $qsat,
                            'qbpost_jum' => $qjum,
                            'qbpost_thrg' => round($qsat * $qjum),
                            'qbpost_jns' => 'TINDAKAN',
                            'qbpost_sjns' => 'RAD',
                            'qbpost_dok' => '---',
                            'qbpost_akses' => $idpeg
                          );
                          $this->transisi->simpqbilpost($datar1);
                        }
                      }
                    $normpas = $pxrad->id;
                  } else {
                    $normpas = '';
                    $jrad = 0;
                  }
                } elseif($kdpenj == 'giz') {
                  $itemgiz = $this->transisi->isigiz($totreg,$jpmed,$apmed,$tpmed,$isimin,$tgmpx,$tdrawat);
                  if($itemgiz) {
                    $normpas = '';
                    $jgiz = 0;
                      if($jentrans != 'post'){
                        foreach ($itemgiz as $pxgiz) {
                          $qsat = $pxgiz->utarip + ($pxgiz->utarip * $extra);
                          $qjum = 1;
                          $datag1 = array(
                            'qbdet_idrs' => $pxgiz->id,
                            'qbdet_reg' => $pxgiz->noreg,
                            'qbdet_kat' => 'TIN.PMED',
                            'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($pxgiz->jaminput)),
                            'qbdet_item' => $pxgiz->pemeriksaan,
                            'qbdet_hrg' => $qsat,
                            'qbdet_jum' => $qjum,
                            'qbdet_thrg' => round($qsat * $qjum),
                            'qbdet_jns' => 'TINDAKAN',
                            'qbdet_sjns' => 'GIZ',
                            'qbdet_dok' => '---',
                            'qbdet_akses' => $idpeg
                          );
                          $this->transisi->simpqbildet($datag1);
                          $jgiz = $jgiz + round($qsat * $qjum);
                        }
                      } else {
                        foreach ($itemgiz as $pxgiz) {
                          $qsat = $pxgiz->utarip + ($pxgiz->utarip * $extra);
                          $qjum = 1;
                          $datag1 = array(
                            'qbpost_idrs' => $pxgiz->id,
                    'qbpost_reg' => $typx.$totreg,
                            'qbpost_kat' => 'TIN.PMED',
                            'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($pxgiz->jaminput)),
                            'qbpost_item' => $pxgiz->pemeriksaan,
                            'qbpost_hrg' => $qsat,
                            'qbpost_jum' => $qjum,
                            'qbpost_thrg' => round($qsat * $qjum),
                            'qbpost_jns' => 'TINDAKAN',
                            'qbpost_sjns' => 'GIZ',
                            'qbpost_dok' => '---',
                            'qbpost_akses' => $idpeg
                          );
                          $this->transisi->simpqbilpost($datag1);
                          $jgiz = $jgiz + round($qsat * $qjum);
                        }
                      }
                      $normpas = $pxgiz->id;
                  } else {
                    $normpas = '';
                    $jgiz = 0;
                  }
                } elseif($kdpenj == 'usg') {
                  $itemusg = $this->transisi->isiusg($totreg,$jpmed,$apmed,$tpmed,$isimin,$tgmpx,$tdrawat);
                  if($itemusg) {
                    $normpas = '';
                    $jusg = 0;
                    if($jentrans != 'post'){
                      foreach ($itemusg as $pxusg) {
                        $qsat = $pxusg->utarip + ($pxusg->utarip * $extra);
                        $qjum = 1;
                        $datau1 = array(
                          'qbdet_idrs' => $pxusg->id,
                          'qbdet_reg' => $pxusg->noreg,
                          'qbdet_kat' => 'TIN.PMED',
                          'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($pxusg->jaminput)),
                          'qbdet_item' => $pxusg->pemeriksaan,
                          'qbdet_hrg' => $qsat,
                          'qbdet_jum' => $qjum,
                          'qbdet_thrg' => round($qsat * $qjum),
                          'qbdet_jns' => 'TINDAKAN',
                          'qbdet_sjns' => 'USG',
                          'qbdet_dok' => '---',
                          'qbdet_akses' => $idpeg
                        );
                        $this->transisi->simpqbildet($datau1);
                        $jusg = $jusg + round($qsat * $qjum);
                      }

                    } else {
                      foreach ($itemusg as $pxusg) {
                        $qsat = $pxusg->utarip + ($pxusg->utarip * $extra);
                        $qjum = 1;
                        $datau1 = array(
                          'qbpost_idrs' => $pxusg->id,
                    'qbpost_reg' => $typx.$totreg,
                          'qbpost_kat' => 'TIN.PMED',
                          'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($pxusg->jaminput)),
                          'qbpost_item' => $pxusg->pemeriksaan,
                          'qbpost_hrg' => $qsat,
                          'qbpost_jum' => $qjum,
                          'qbpost_thrg' => round($qsat * $qjum),
                          'qbpost_jns' => 'TINDAKAN',
                          'qbpost_sjns' => 'USG',
                          'qbpost_dok' => '---',
                          'qbpost_akses' => $idpeg
                        );
                        $this->transisi->simpqbilpost($datau1);
                      }
                    }
                    $normpas = $pxusg->id;
                  } else {
                    $normpas = '';
                    $jusg = 0;
                  }
                }
              }
              $datau1a = array(
                'qbdet_idrs' => $normpas,
                'qbdet_reg' => $nmrj,
                'qbdet_kat' => 'TIN.PMED',
                'qbdet_tginput' => date('Y-m-d H:i:s'),
                'qbdet_hrg' => $jlab+$jrad+$jgiz+$jusg,
                'qbdet_jns' => 'SUBTOTAL',
                'qbdet_sjns' => 'U1A',
                'qbdet_akses' => $idpeg
              );
              $this->transisi->simpqbildet($datau1a);
              $stharga = 0;
              if($itemlab){
                $qfpmed = $this->transisi->carifpmed($totreg,$jpmed,$apmed,$tpmed,$isimin,$tgmpx,$tdrawat);
                if($qfpmed) {
                  if($jentrans != 'post'){
                    foreach ($qfpmed as $qfpm) {
                      $qsat = $qfpm->inhargajual + ($qfpm->inhargajual * $extra);
                      $qjum = $qfpm->pmjumlah;
                      $datam1 = array(
                        'qbdet_idrs' => $qfpm->pmid,
                        'qbdet_reg' => $qfpm->pmnoreg,
                        'qbdet_kat' => 'FRM.PMED',
                        'qbdet_tginput' => date('Y-m-d H:i:s',strtotime($qfpm->pmtglinput)),
                        'qbdet_item' => $qfpm->innamaobat,
                        'qbdet_hrg' => $qsat,
                        'qbdet_jum' => $qjum,
                        'qbdet_thrg' => round($qsat * $qjum),
                        'qbdet_jns' => 'FARMASI',
                        'qbdet_sjns' => strtoupper($qfpm->injenisbarang),
                        'qbdet_dok' => '---',
                        'qbdet_akses' => $idpeg
                      );
                      $this->transisi->simpqbildet($datam1);
                      $stharga = $stharga + round($qsat * $qjum);
                    }
                  $datam1a = array(
                    'qbdet_idrs' => $qfpm->pmid,
                    'qbdet_reg' => $qfpm->pmnoreg,
                    'qbdet_kat' => 'FRM.PMED',
                    'qbdet_tginput' => date('Y-m-d H:i:s'),
                    'qbdet_hrg' => $stharga,
                    'qbdet_jns' => 'SUBTOTAL',
                    'qbdet_sjns' => 'M1A',
                    'qbdet_akses' => $idpeg
                  );
                  $this->transisi->simpqbildet($datam1a);
                  $stharga = 0;

                  } else {
                    foreach ($qfpmed as $qfpm) {
                      $qsat = $qfpm->inhargajual + ($qfpm->inhargajual * $extra);
                      $qjum = $qfpm->pmjumlah;
                      $datam1 = array(
                        'qbpost_idrs' => $qfpm->pmid,
                    'qbpost_reg' => $typx.$totreg,
                        'qbpost_kat' => 'FRM.PMED',
                        'qbpost_tginput' => date('Y-m-d H:i:s',strtotime($qfpm->pmtglinput)),
                        'qbpost_item' => $qfpm->innamaobat,
                        'qbpost_hrg' => $qsat,
                        'qbpost_jum' => $qjum,
                        'qbpost_thrg' => round($qsat * $qjum),
                        'qbpost_jns' => 'FARMASI',
                        'qbpost_sjns' => strtoupper($qfpm->injenisbarang),
                        'qbpost_dok' => '---',
                        'qbpost_akses' => $idpeg
                      );
                      $this->transisi->simpqbilpost($datam1);
                    }
                  }
                }
              }
            }

          }

          function fillbillpost($ar = FALSE){
            $list = $this->transisi->fillbpost($ar);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $jbilpost) {
              $itemdet = str_replace('UMUM - ','',$jbilpost->qbpost_item);
              $itemdet = str_replace('BPJS - ','',$itemdet);
              $mark = $jbilpost->qbpost_jns=='SUBTOTAL'?1:0;
              $cqbmain = $this->transisi->carirek(substr($jbilpost->qbpost_reg,-16),'main');
              foreach ($cqbmain as $cqbm) {
                if (substr($jbilpost->qbpost_reg,0,2)=='RJ') {
                  if (strlen($cqbm->qbmain_poli)==8) {
                    $aspx = $this->transisi->get_dkpoli($cqbm->qbmain_poli,'cnpol')['namapoli'];
                  } else {
                    $aspx = 'APS';
                  }
                } else {
                  $yos = array('0'=>'1','1'=>'2','2'=>'3','3'=>'4','4'=>'5','5'=>'6','6'=>'25','7'=>'24','8'=>'20','9'=>'22','10'=>'23','11'=>'17','12'=>'18','13'=>'19','14'=>'15');
                  $hel = array('0'=>'14','1'=>'16','2'=>'21','3'=>'14A','4'=>'B14','5'=>'B16','6'=>'B21');
                  $mik = array('0'=>'7','1'=>'8','2'=>'9','3'=>'10','4'=>'11','5'=>'12');
                      if(array_search($cqbm->qbmain_kmr,$yos)!==false){
                        $nbangsal = 'Yosefa';
                      } elseif(array_search($cqbm->qbmain_kmr,$hel)!==false){
                        $nbangsal = 'Helena';
                      } else {
                        $nbangsal = 'Mikaela';
                      }
                      $aspx = $nbangsal;
                  }
                }
              $no++;
              $row = array();
              $row[] = substr($jbilpost->qbpost_reg,0,2);
              $row[] = substr($jbilpost->qbpost_reg,2,1)=='0'?'PRIBADI':'BPJS';
              $row[] = $aspx;
//              $row[] = substr($jbilpost->qbpost_reg,0,2)=='RJ'?$cqbmain->qbmain_poli:$cqbmain->qbmain_bsl;
              $row[] = $jbilpost->qbpost_idrs;
              $row[] = substr($jbilpost->qbpost_reg,-16);
              $row[] = $mark==0?date('d-M-y',strtotime($jbilpost->qbpost_tginput)):'';
              $row[] = $itemdet;
              $row[] = $mark==0?$jbilpost->qbpost_jum:$jbilpost->qbpost_jns.' '.$jbilpost->qbpost_kat.' :';
              $row[] = $jbilpost->qbpost_hrg;
              $row[] = $mark==0?$jbilpost->qbpost_thrg:'';
              $row[] = $jbilpost->qbpost_kat;
              $row[] = $jbilpost->qbpost_jns;
              $row[] = $jbilpost->qbpost_sjns;
              $data[] = $row;
            }

            $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->transisi->fillbpost_all($ar),
              "recordsFiltered" => $this->transisi->fillbpost_filtered($ar),
              "data" => $data
            );
            echo json_encode($output);
          }

          function fillbilldet($ar = FALSE){
            $list = $this->transisi->fillbdet($ar);
            $data = array();
            $no = $_POST['start'];
            foreach ($list as $jbildet) {
              $itemdet = str_replace('UMUM - ','',$jbildet->qbdet_item);
              $itemdet = str_replace('BPJS - ','',$itemdet);
              $mark = $jbildet->qbdet_jns=='SUBTOTAL'?1:0;
              $no++;
              $row = array();
              $row[] = $jbildet->qbdet_kat;
              $row[] = $mark==0?date('d-M-y',strtotime($jbildet->qbdet_tginput)):'';
              $row[] = $itemdet;
              $row[] = $mark==0?$jbildet->qbdet_jum:$jbildet->qbdet_jns.' '.$jbildet->qbdet_kat.' :';
              $row[] = $jbildet->qbdet_hrg;
              $row[] = $mark==0?$jbildet->qbdet_thrg:'';
              $row[] = $jbildet->qbdet_jns;
              $row[] = $jbildet->qbdet_sjns;
              $data[] = $row;
            }

            $output = array(
              "draw" => $_POST['draw'],
              "recordsTotal" => $this->transisi->fillbdet_all($ar),
              "recordsFiltered" => $this->transisi->fillbdet_filtered($ar),
              "data" => $data
            );
            echo json_encode($output);
          }

          function biopx($nikpeg = FALSE){
            $abio = array();
              $dbio = $this->transisi->caribiopx($nikpeg);
              if($dbio){
                echo json_encode($dbio);
              }
          }


    function variabel(){
        $list = $this->akuntansi->cvariabel();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $isika5) {
                $ka5nmr = /*$isika5->ka_1.'.'.$isika5->ka_2.'.'.*/$isika5->ka_3.'.'.$isika5->ka_4.'.'.$isika5->ka_5;
                $ka5nama = $isika5->ka_nama;
                $ka5up = date('d/m/Y H:i',strtotime($isika5->ka_up));

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $ka5nmr;
                $row[] = $ka5nama;
                $row[] = $ka5up;
                $data[] = $row;
        }

    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->akuntansi->vari_all(),
            "recordsFiltered" => $this->akuntansi->vari_filtered(),
            "data" => $data
          );
          echo json_encode($output);
        }

    function saldo(){
        $list = $this->akuntansi->csaldo();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $saldo) {
                $nama = $saldo->ka_nama;
                $jml = $saldo->ka_saldoawal;
                $jum1 =  floatval($jml);
                $jum = $jum1==0?'<span style="color:#FF0000;">'.number_format($jum1).'</span>':number_format($jum1);
                    $ganti = '~next~';
                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $nama;
                $row[] = $jum;
                $row[] = '<span class="pull-right">'.$ganti.'</span>';
                $data[] = $row;
        }

    $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->akuntansi->saldo_all(),
            "recordsFiltered" => $this->akuntansi->saldo_filtered(),
            "data" => $data
          );
          echo json_encode($output);
        }

        public function posting1($id = FALSE){
          if(!$id){
            $id = $this->input->post('idjur');
          }
          $this->akuntansi->trx_posting($id,$this->dbcore1->routekey(get_cookie('simkop'),'d'));
          exit;
        }


  public function koreksi2($id = FALSE){
    if(!$id){
      $id = $this->input->post('idjur');
    }
    $dptcor = 0;
    $dt = new DateTime();
    $tgcor = $dt->format('m');
    $carkor = $this->akuntansi->get_lastkor();
    if($carkor){
      $dptcor = intval($carkor['nmrjur']);
      $hascor = $dptcor + 1;
      $hcor = sprintf('%03d',$hascor);
    } else {
      $hcor = sprintf('%03d',1);
    }
    $ncor = 'C'.$dt->format('y').'.'.$tgcor.'.'.$hcor;

    if(strlen($id)==10){
      $nojur1 = $id;
      $nojur2 = $ncor;
      $korjur = $this->akuntansi->get_korjur($nojur1);
      foreach($korjur as $korj){
        $isikorj = array(
          'akjur_nomor' => $nojur2,
          'akjur_jns' => $korj['akjur_jns'],
          'akjur_tgl' => $dt->format('Y-m-d'),
          'akjur_ket' => 'Koreksi Jurnal '.$nojur1,
          'akjur_sts' => '1',
          'akjur_akses' => $korj['akjur_akses'],
          'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')
        );
        $this->akuntansi->jur_koreksi($isikorj,$nojur1);
      }

      $kortrx = $this->akuntansi->get_kortrx($nojur1);
      foreach($kortrx as $kort){
        $isikort = array(
          'aktrx_nomor' => $kort['aktrx_nomor'],
          'aktrx_nojur' => $nojur2,
          'aktrx_nama' => $kort['aktrx_nama'],
          'aktrx_jns' => $kort['aktrx_jns']=='D'?'K':'D',
          'aktrx_ket' => $kort['aktrx_ket'],
          'aktrx_jum' => $kort['aktrx_jum'],
          'aktrx_akses' => $kort['aktrx_akses'],
          'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),
          'aktrx_mark' => 1
        );
        $updkort = array(
          'aktrx_nama' => $kort['aktrx_nama'],
          'aktrx_ket' => $kort['aktrx_ket'],
          'aktrx_akses' => $kort['aktrx_akses'],
          'aktrx_mark' => 1
        );
        $this->akuntansi->trx_koreksi($isikort,$nojur1,$kort['aktrx_nomor'],$updkort);
      }
//      echo json_encode(array("status" => TRUE));
    } else {
      return false;
    }
exit;
  }

  public function koreksi3($id = FALSE){
    if($id){
      $notrx1 = substr($id,0,12);
      $nojur = substr($id,12-strlen($id));
      $notrx2 = $notrx1;
      $kortrx = $this->akuntansi->get_kortrx2($notrx1,$nojur);
      foreach($kortrx as $kort){
        $isikort = array(
          'aktrx_nomor' => $notrx2,
          'aktrx_nojur' => $nojur,
          'aktrx_nama' => $kort['aktrx_nama'],
          'aktrx_jns' => $kort['aktrx_jns']=='D'?'K':'D',
          'aktrx_ket' => $kort['aktrx_ket'],
          'aktrx_jum' => $kort['aktrx_jum'],
          'aktrx_akses' => $kort['aktrx_akses'],
          'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),
          'aktrx_mark' => 1
        );
        $trxkort = array(
          'aktrx_nomor' => $notrx1,
          'aktrx_ket' => $kort['aktrx_ket'],
          'aktrx_akses' => $kort['aktrx_akses'],
          'aktrx_mark' => 1
        );
        $this->akuntansi->trx_koreksi2($isikort,$trxkort,$notrx1.$nojur);
      }
      echo json_encode(array("status" => TRUE));
    } else {
      return false;
    }

  }

  public function hapus_area3($id)
  {
    $this->akuntansi->trx_hapus($id);
    echo json_encode(array("status" => TRUE));
  }

        function fillgrid_trx(){
            echo $this->akuntansi->fillgrid_trx();
        }


    function trxharian(){
      $nmrj = $this->dbcore1->routekey($this->dbcore1->getcok('idjur'),'d');
      $idpeg = $this->session->userdata('pgpid');
      $akpeg = $this->session->userdata('pgakses');
      if(!isset($_GET['kodejob1'])){
        $akpeg1 = $akpeg;
      } else {
        $akpeg1 = $_GET['kodejob1'];
      }
      $akpeg1 = $akpeg!='222'?'222':$akpeg;
      $this->dbcore1->simcok('operator',$this->dbcore1->routekey($this->dbcore1->caripeg($idpeg)));
      $this->dbcore1->simcok('kodejob',$this->dbcore1->routekey($akpeg));
      $this->dbcore1->simcok('kodejob1',$this->dbcore1->routekey($akpeg1));
      $this->dbcore1->simcok('kodesu',$this->dbcore1->routekey($supeg));
      $this->dbcore1->simcok('akses',$this->dbcore1->routekey($idpeg));
      $this->dbcore1->simcok('idpeg',$this->dbcore1->routekey($idpeg));
      $supeg = $this->session->userdata('pgsu');
      $qjur = $this->akuntansi->carijur($nmrj);
      $this->dbcore1->simcok('jur_nmr',$this->dbcore1->routekey($qjur['akjur_nomor']));
      $this->dbcore1->simcok('jur_akses',$this->dbcore1->routekey($qjur['akjur_akses']));
      $this->dbcore1->simcok('jur_tgl',$this->dbcore1->routekey($qjur['akjur_tgl']));
      $this->dbcore1->simcok('trx_jns',$this->dbcore1->routekey($qjur['akjur_jns']));
      $this->dbcore1->simcok('cgroup',$this->dbcore1->routekey($this->pecahcgroup($akpeg)));
      $this->dbcore1->simcok('qtitle',$this->dbcore1->routekey('Transaksi'));
      $this->dbcore1->simcok('rmmod',$this->dbcore1->routekey('area3'));
      $this->dbcore1->simcok('jnsjur',$this->dbcore1->routekey('D'));
    }


    public function list_kel(){
      $frmkel = $this->akuntansi->trx_jenis($this->input->post('searchTerm'),$this->input->post('param1'),$this->input->post('param2'),$this->dbcore1->routekey($this->dbcore1->getcok('trx_jns'),'d'));
      echo json_encode($frmkel);
    }

    public function list_paroki(){
      $frmkel = $this->dbcore1->get_paroki($this->input->post('searchTerm'),$this->input->post('param1'),$this->input->post('param2'),$this->dbcore1->routekey($this->dbcore1->getcok('trx_jns'),'d'));
      echo json_encode($frmkel);
    }

    public function list_ka5(){
      $frmkel = $this->akuntansi->get_ka5($this->input->post('searchTerm'),$this->input->post('param1'),$this->input->post('param2'),$this->dbcore1->routekey($this->dbcore1->getcok('trx_jns'),'d'));
      echo json_encode($frmkel);
    }


    public function hapus_area2b($id){
      $this->dbmain->where('akjur_nomor', $id);
      $this->dbmain->delete('qmain_akun_jur');
      echo '<div class="alert alert-info">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>Waduh!</strong> Satu data telah terhapus.
      </div>';
      exit;
    }

    public function cek_jbol(){
      $hhit = $this->dbcore1->ju_hit($this->input->post('noakr'));
      echo $hhit == 0?'001':str_pad($hhit+1, 3, '0', STR_PAD_LEFT);
    }



    function akharian($jtrx = FALSE) {
            $mark = $this->input->post('ft_mark1');
        if($jtrx=='area2'){
            $data = array(
              'akjur_nomor' => $this->input->post('fj_nomor'),
              'akjur_jns' => $this->input->post('fj_jenis'),
              'akjur_tgl' => date("Y-m_d",strtotime($this->input->post('fj_tgl'))),
              'akjur_ket' => $this->input->post('fj_ket'),
              'akjur_sts' => $this->input->post('fj_sts'),
              'akjur_akses' => $this->input->post('fj_akses'),
              'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')
              );
        } else {
            if(isset($_POST['ft_mark1'])==TRUE){
                $mark1 = $this->input->post('ft_mark1');
            } else {
                $mark1 = '';
            }
            if(isset($_POST['fte_mark1'])==TRUE){
                $mark2 = $this->input->post('fte_mark1');
            } else {
                $mark2 = '';
            }
            $mark = $mark1.$mark2;

            if($mark=='u'){
                $urut = $this->input->post('fte_urut');
                $nmr2 = 'fte_nmr2';
                $nojur = 'fte_nojur';
                $jns = 'fte_jns';
                $ket = 'fte_ket';
                $jum = 'fte_jum';
                $akses = 'fte_akses';
            } else {
                $urut = '';
                $nmr2 = 'ft_nmr2';
                $nojur = 'ft_nojur';
                $jns = 'ft_jns';
                $ket = 'ft_ket';
                $jum = 'ft_jum';
                $akses = 'ft_akses';
            }
            $nama = $this->akuntansi->get_per($this->input->post($nmr2));
            $data = array(
                'aktrx_urut' => $urut,
                'aktrx_nomor' => $this->input->post($nmr2),
                'aktrx_nojur' => $this->input->post($nojur),
                'aktrx_nama' => $nama['ka_nama'],
                'aktrx_jns' => $this->input->post($jns),
                'aktrx_ket' => $this->input->post($ket),
                'aktrx_jum' => str_replace(',','',$this->input->post($jum)),
                'aktrx_akses' => $this->input->post($akses),
                'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')
            );

        }
            $this->akuntansi->tambah_trx($data,$jtrx.$mark);
    }

    function akatur($jtrx = FALSE) {
        if($jtrx=='area2'){
            $data = array(
              'ka_3' => substr($this->input->post('fa_per'),0,3),
              'ka_4' => substr($this->input->post('fa_per'),4,2),
              'ka_5' => $this->dbcore1->routekey(get_cookie('simakses'),'d').'.'.substr($this->input->post('fa_per'),-2),
              'ka_saldoawal' => (substr($this->input->post('fa_per'),0,1)=='2'||substr($this->input->post('fa_per'),0,1)=='4'||substr($this->input->post('fa_per'),0,1)=='6')?(-1)*floatval(str_replace(',','',$this->input->post('fa_jum'))):floatval(str_replace(',','',$this->input->post('fa_jum'))),
              );
        } elseif($jtrx=='sistem'){
          $data = array(
            'qt_var1' => $this->input->post('fa_vket'),
            'qt_var2' => $this->input->post('fa_vvar'),
            'qt_akses' => $this->input->post('ft_akses')
            );
          $this->akuntansi->isi_variabel($data,'i');
        } else {
            $urut = $mark=='u'?$this->input->post('ft_urut'):'';
            $nama = $this->akuntansi->get_per($this->input->post('ft_nmr2'));
            $data = array(
                'aktrx_urut' => $urut,
                'aktrx_nomor' => $this->input->post('ft_nmr2'),
                'aktrx_nojur' => $this->input->post('ft_nojur'),
                'aktrx_nama' => $nama['ka_nama'],
                'aktrx_jns' => $this->input->post('ft_jns'),
                'aktrx_ket' => $this->input->post('ft_ket'),
                'aktrx_jum' => $this->input->post('ft_jum'),
                'aktrx_akses' => $this->input->post('ft_akses')
            );

        }
            if($jtrx!='sistem'){
              $this->akuntansi->update_ka5($data,$jtrx);
            }
    }

    function simpanperk($id = FALSE){
      $idpeg = $this->session->userdata('pgpid');

      if($id){
        $kdperk1 = str_replace('%2C', ',', $id);
        $kdperk2 = str_replace('%20', ' ', $kdperk1);
        $kdak = substr($id,0,2);
        $jidperk = strlen($kdperk2);
        $kdperk = substr($kdperk2,2-$jidperk);

        switch ($kdak) {
          case '01':
          $data = array(
            'ka_1' => substr($kdperk,0,3),
            'ka_nama' => strtoupper(substr($kdperk,3,$jidperk-5))
          );
          break;

          case '02':
          $data = array(
            'ka_1' => substr($kdperk,0,1).'00',
            'ka_2' => substr($kdperk,0,3),
            'ka_nama' => strtoupper(substr($kdperk,3,$jidperk-5))
          );
          break;

          case '03':
          $data = array(
            'ka_1' => substr($kdperk,0,1).'00',
            'ka_2' => substr($kdperk,0,2).'0',
            'ka_3' => substr($kdperk,0,3),
            'ka_nama' => strtoupper(substr($kdperk,3,$jidperk-5))
          );
          break;

          default:
          $data1 = array(
            'ka_1' => substr($kdperk,0,1).'00',
            'ka_2' => substr($kdperk,0,2).'0',
            'ka_3' => substr($kdperk,0,3),
            'ka_4' => substr($kdperk,4,2),
            'ka_nama' => strtoupper(substr($kdperk,12,$jidperk-14))
          );
          $this->akuntansi->isi_perkiraan($data1,'i','04');
          $data = array(
            'ka_1' => substr($kdperk,0,1).'00',
            'ka_2' => substr($kdperk,0,2).'0',
            'ka_3' => substr($kdperk,0,3),
            'ka_4' => substr($kdperk,4,2),
            'ka_5' => substr($kdperk,7,5),
            'ka_nama' => strtoupper(substr($kdperk,12,$jidperk-14))
          );
          $kdak = '05';
          break;
        }

        $kdbar = substr($kdperk,0,1).'00.'.substr($kdperk,0,2).'0.'.substr($kdperk,0,3).'.'.substr($kdperk,4,2).'.'.substr($kdperk,7,5);
        $this->akuntansi->isi_perkiraan($data,'i',$kdak);
        if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
          $hcinet=$this->dbcore1->cinet();
          if($hcinet){
            $this->dbcore1->routedqt($this->dbcore1->caripeg($pegid)['pgpnama'].' isi/update Kode Akun '.$kdbar,'1');
          }
        }
        echo json_encode(array("status" => TRUE));
      } else {
        return false;
      }
    }

    function simpanjkp($id = FALSE){

      if($id){
        $kdperk1 = str_replace('%20', '',str_replace('%2C', '',str_replace(',', '', $id)));
        $jjkp = substr($id,0,1);
        $kjkp = substr($id,1,3);
        $jidjkp = strlen($kdperk1);
        $kdjkp = substr($kdperk1,4-$jidjkp);
        $akdjkp = str_split($kdjkp,2);
        $jakdjkp = count($akdjkp);
        $i = 0;
        for($i=0;$i<=$jakdjkp-1;$i++){
          $data = array(
            'akjkp_kdj' => $akdjkp[$i],
            'akjkp_tr' => $jjkp,
            'akjkp_kdp' => $kjkp
          );
        $this->akuntansi->isi_jkp($data);
        }
        echo json_encode(array("status" => var_dump($akdjkp)));
      } else {
        return false;
      }
//      exit;
    }


    function get_7ka1($ka = FALSE){
        echo json_encode($this->akuntansi->get_vka1($ka));
    }
    function get_7ka2($ka = FALSE){
        echo json_encode($this->akuntansi->get_vka2($ka));
    }
    function get_7ka3($ka = FALSE){
        echo json_encode($this->akuntansi->get_vka3($ka));
    }
    function get_7ka4($ka = FALSE){
        echo json_encode($this->akuntansi->get_vka4($ka));
    }
    function get_7vjur(){
        echo json_encode($this->akuntansi->get_vjur());
    }

    function get_perklist($varl = FALSE){
      $prkl = array();
      $prkl[] = array('id'=>'akun','parent'=>'#','text'=>'Kode Akun');

      switch ($varl) {
        case '02':
        $vcka1 = $this->akuntansi->get_vka1('list');
        foreach ($vcka1 as $vck1) {
          $prkl[] = array(
            'icon'=>'glyphicon glyphicon-queen navy',
            'id'=>$vck1->ka_1,
            'parent'=>'akun',
            'text'=>'['.$vck1->ka_1.'] '.$vck1->ka_nama
          );
        }

        $vcka2 = $this->akuntansi->get_vka2('list');
        foreach ($vcka2 as $vck2) {
          $prkl[] = array(
            'icon'=>'glyphicon glyphicon-bishop navy',
            'id'=>$vck2->ka_2.$vck2->ka_2,
            'parent'=>$vck2->ka_1,
            'text'=>'['.$vck2->ka_2.'] '.$vck2->ka_nama
          );
        }
          break;

          case '03':
          $vcka = $this->akuntansi->get_vka1('list');
          foreach ($vcka as $vck) {
            $prkl[] = array(
              'icon'=>'glyphicon glyphicon-queen navy',
              'id'=>$vck->ka_1,
              'parent'=>'akun',
              'text'=>'['.$vck->ka_1.'] '.$vck->ka_nama
            );
          }

          $vcka1 = $this->akuntansi->get_vka2('list');
          foreach ($vcka1 as $vck1) {
            $prkl[] = array(
              'icon'=>'glyphicon glyphicon-bishop navy',
              'id'=>$vck1->ka_1.$vck1->ka_2,
              'parent'=>$vck1->ka_1,
              'text'=>'['.$vck1->ka_2.'] '.$vck1->ka_nama
            );
          }

          $vcka2 = $this->akuntansi->get_vka3('list');
          foreach ($vcka2 as $vck2) {
            if($vck2->ka_2!='480'){
              $prkl[] = array(
                'icon'=>'glyphicon glyphicon-knight navy',
                'id'=>$vck2->ka_ur.$vck2->ka_3,
                'parent'=>$vck2->ka_1.$vck2->ka_2,
                'text'=>'['.$vck2->ka_2.'.'.$vck2->ka_3.'] '.$vck2->ka_nama
              );
            }
          }
            break;

            case '04':
            $vcka = $this->akuntansi->get_vka1('list');
            foreach ($vcka as $vck) {
              $prkl[] = array(
                'icon'=>'glyphicon glyphicon-queen navy',
                'id'=>$vck->ka_1,
                'parent'=>'akun',
                'text'=>'['.$vck->ka_1.'] '.$vck->ka_nama
              );
            }

            $vcka1 = $this->akuntansi->get_vka2('list');
            foreach ($vcka1 as $vck1) {
              $prkl[] = array(
                'icon'=>'glyphicon glyphicon-bishop navy',
                'id'=>$vck1->ka_1.$vck1->ka_2,
                'parent'=>$vck1->ka_1,
                'text'=>'['.$vck1->ka_2.'] '.$vck1->ka_nama
              );
            }

            $vcka2 = $this->akuntansi->get_vka3('list');
            foreach ($vcka2 as $vck2) {
              if($vck2->ka_2!='480'){
                $prkl[] = array(
                  'icon'=>'glyphicon glyphicon-knight navy',
                  'id'=>$vck2->ka_1.$vck2->ka_2.$vck2->ka_3,
                  'parent'=>$vck2->ka_1.$vck2->ka_2,
                  'text'=>'['.$vck2->ka_2.'.'.$vck2->ka_3.'] '.$vck2->ka_nama
                );
              }
            }

            $vcka3 = $this->akuntansi->get_vka4a();
            foreach ($vcka3 as $vck3) {
              if($vck3->ka_2!='480' && $vck3->ka_2!='170'){
                $prkl[] = array(
                  'icon'=>'glyphicon glyphicon-pawn navy',
                  'id'=>$vck3->ka_3.$vck3->ka_4,
                  'parent'=>$vck3->ka_1.$vck3->ka_2.$vck3->ka_3,
                  'text'=>'['.$vck3->ka_3.'.'.$vck3->ka_4.'] '.$vck3->ka_nama
                );
              }
            }
              break;

        default:
        $vcka = $this->akuntansi->get_vka1('list');
        foreach ($vcka as $vck) {
          $prkl[] = array(
            'icon'=>'glyphicon glyphicon-queen navy',
            'id'=>$vck->ka_1,
            'parent'=>'akun',
            'text'=>'['.$vck->ka_1.'] '.$vck->ka_nama
          );
        }
          break;
      }
        echo json_encode($prkl);
    }

        function get_nmr2($ka = FALSE){
          $frmkel = $this->akuntansi->get_ka5($this->input->post('searchTerm')!=''?$this->input->post('searchTerm'):false,$this->input->post('param1'),$this->input->post('param1')==1?$this->dbcore1->routekey($this->dbcore1->getcok('jnsperk'),'d'):false);
          echo json_encode($frmkel);
        }

        function get_nmr1($ka = FALSE){
            echo json_encode($this->akuntansi->get_ka3($ka));
        }

        function get_perkiraan($per = FALSE){
            echo json_encode($this->akuntansi->get_per($per));
        }

        function caritrx($trx = FALSE){
            echo json_encode($this->akuntansi->get_trx($trx));
        }

        function info($area = FALSE){
            echo json_encode($this->akuntansi->get_info($area));
        }

        function caritrxdet($trx = FALSE){
            echo json_encode($this->akuntansi->get_kortrx($trx));
        }


//----------------Absen

//----------------Absen
function getuser(){
$unik = $this->session->userdata('pgpid');
$uip = $this->session->userdata('pgip');
$this->dbcore1->del_useraktif($unik,$uip);
  $data = array(
    'qusnik' => $this->session->userdata('pgpid'),
    'qussu' => $this->session->userdata('pgsu'),
    'qusip' => $this->session->userdata('pgip')
    );
    $this->dbcore1->isi_useraktif($data);

  $cruser = $this->dbcore1->call_useraktif();
  if($cruser) {
  foreach($cruser as $usak){
    $nuser = $this->dbcore1->caripeg($usak['qusnik']);
    switch ($usak['qussu']) {
      case '2':
        $bgd = 'fa-shield';
        break;

      case '1':
        $bgd = 'fa-key';
        break;

      default:
      $bgd = 'fa-user';
        break;
    }
    echo '<li data-toggle="tooltip" data-placement="top" title="'.$usak['qusip'].'" class="tambahan blue"><a href="#"><span class="badge bg-blue pull-right"><i class="fa '.$bgd.'"></i> </span>'.$nuser['pgpnama'].'</a></li>';
  }
  }
}

function getyanabsen(){
  $cryan = $this->absen_model->get_isi_abs();
  foreach($cryan as $pabs) {
    $jdisp = strlen($pabs['temp0_ket']);
    $vardisp = substr($pabs['temp0_ket'],0,2);

      switch ($vardisp) {
        case '04':
        $bgd = 'fa-user-md';
        $yanmed = 'Dokter';
          break;

        case '10':
        case '19':
        $bgd = 'fa-flask';
        $yanmed = 'Laboratorium';
          break;

        case '14':
        $bgd = 'fa-money';
        $yanmed = 'Kasir';
          break;

        case '15':
        $bgd = 'fa-file-text';
        $yanmed = 'Rekam Medis';
          break;

        default:
        $bgd = 'fa-user';
        $yanmed = 'Pelayanan Medis';
          break;
      }
      echo '<li data-toggle="tooltip" data-placement="top" title="'.$yanmed.'"><i class="fa '.$bgd.'"></i> '.substr($pabs['temp0_ket'],2,$jdisp-2).'</li>';
  }
}

function isi_log($isi = FALSE){
  $idpeg = $this->session->userdata('pgpid');
  $data = array(
    'log_idpeg' => $idpeg,
    'log_ket' => str_replace('%2C',',',str_replace('%20',' ',$this->input->post('aisi')))
  );
  if($this->dbcore1->catatlog($data)){
    echo $this->dbcore1->routekey('6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b','d');
  }
}

function goroute(){
  $param1 = $this->input->post('prm1');
  $param2 = $this->input->post('prm2');
  if(!$param2){
    $hasil = $this->dbcore1->routekey($param1);
  } else {
    $hasil = $this->dbcore1->routekey($param1,$param2);
  }
  echo $hasil;
}

function simpkwit($serkwit = FALSE){
  $idpeg = $this->session->userdata('pgpid');
  $nmopr = $this->dbcore1->caripeg($pegid);
  $data = array(
    'qbcet_idrs' =>substr($serkwit,31,6),
    'qbcet_reg' =>substr($serkwit,15,16),
    'qbcet_kwit' =>substr($serkwit,0,15),
    'qbcet_jum' =>substr($serkwit,37),
    'qbcet_tgakses' => date("Y-m-d h:i:s"),
    'qbcet_akses' => $idpeg
  );
  $this->dbcore1->catatkwit($data);
}

function isi_pesan(){
  $pegid = $this->session->userdata('pgpid');
  $pegaks = substr($this->session->userdata('pgakses'),0,1);
  $cgroup = $this->dbcore1->get_peggroup($pegaks);
  $psnall = $this->input->post('ps_tuk');
    if($psnall!='0000.00.000'){if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
      $hcinet=$this->dbcore1->cinet();if($hcinet){$this->dbcore1->routedqt('Pesan, dari '.$this->dbcore1->caripeg($pegid)['pgpnama'].' untuk '.$this->dbcore1->caripeg($psnall)['pgpnama'],'1');}}
      $data = array(
        'psn_oleh' => $pegid,
        'psn_untuk' => $this->input->post('ps_tuk'),
        'psn_group' => $this->session->userdata('pgakses'),
        'psn_jdl' => $this->input->post('ps_jdl'),
        'psn_isi' => str_replace('../..','',$this->input->post('ps_ket'))
      );
      $this->dbcore1->simppesan($data);
      if($this->input->post('ps_tuk')==$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
        $this->load->library('email');
        $this->email->from('antoniusamp@gmail.com', 'QHMS-Administrasi');
        $this->email->to('ymakarius@gmail.com');
        $this->email->subject('Pesan dari '.$this->dbcore1->caripeg($pegid)['pgpnama'].': '.$this->input->post('ps_jdl'));
        $this->email->message(str_replace('../..','https://antoniusamp.ddns.net',$this->input->post('ps_ket')));
        $this->email->send();
      }
    } else {if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
      $hcinet=$this->dbcore1->cinet();if($hcinet){$this->dbcore1->routedqt('Pesan, dari '.$this->dbcore1->caripeg($pegid)['pgpnama'].' untuk SEMUA','1');}}
      foreach ($cgroup as $cgg) {
        if ($cgg['qaknik']!=$pegid){
      $data = array(
        'psn_oleh' => $pegid,
        'psn_untuk' => $cgg['qaknik'],
        'psn_group' => $this->session->userdata('pgakses'),
        'psn_jdl' => $this->input->post('ps_jdl'),
        'psn_isi' => str_replace('../..','',$this->input->post('ps_ket'))
      );
      $this->dbcore1->simppesan($data);
      if($cgg['qaknik']==$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
        $this->load->library('email');
        $this->email->from('antoniusamp@gmail.com', 'QHMS-Administrasi');
        $this->email->to('ymakarius@gmail.com');
        $this->email->subject('Pesan dari '.$this->dbcore1->caripeg($pegid)['pgpnama'].': '.$this->input->post('ps_jdl'));
        $this->email->message(str_replace('../..','https://antoniusamp.ddns.net',$this->input->post('ps_ket')));
        $this->email->send();
      }
      }
    }
  }
}

function getpesan($varpeg = FALSE,$varjen = FALSE){

  $pegid = substr($this->input->post('varpeg'),0,11);
  $crgrp = substr($this->input->post('varpeg'),-3);
  if($this->input->post('varpeg')) {
  $ispesan = $this->dbcore1->dafpesanall($crgrp,$pegid);
} else {
  $ispesan = $this->dbcore1->dafpesan($crgrp,$pegid);
}
  if($ispesan){
    if($this->input->post('varjen')){
      echo '<div id="scrollable" style="width:100%;height:300px;overflow:auto;"><ul class="list-unstyled timeline">';
      foreach ($ispesan as $ipes) {
        $drpeg = $this->dbcore1->caripeg($ipes['psn_oleh']);
        $topeg = $this->dbcore1->caripeg($ipes['psn_untuk']);
        $psntag = $ipes['psn_mark']=='1'?'<div class="tags"><a href="" class="tag">Dibaca</a></div>':'<div class="tags"><a href="" class="tag"><strong class="red animated flash infinite">Terkirim</strong></a></div>';
        if($this->input->post('varjen')=='X' && $pegid == $ipes['psn_oleh']) {
          echo '<li><div class="block">'.$psntag.'<div class="block_content">';
          echo '<h2 class="title"><a>'.$ipes['psn_jdl'].'</a></h2><div class="byline"><span>'.date('d/m/Y H:i',strtotime($ipes['psn_wkt'])).'</span> untuk <a>'.$topeg['pgpnama'].'</a></div>';
          echo $ipes['psn_isi'].'</div></div></li>';
        } elseif($this->input->post('varjen')=='Y' && $pegid == $ipes['psn_untuk'] && $pegid != $ipes['psn_oleh']) {
          echo '<li><div class="block">'.$psntag.'<div class="block_content">';
          echo '<h2 class="title"><a>'.$ipes['psn_jdl'].'</a></h2><div class="byline"><span>'.date('d/m/Y H:i',strtotime($ipes['psn_wkt'])).'</span> dari <a>'.$drpeg['pgpnama'].'</a></div>';
          echo $ipes['psn_isi'].'</div></div></li>';
        }
      }
      echo '</ul></div>';
    } else {
      echo '<div id="scrollable" style="width:100%;height:300px;overflow:auto;"><ul class="messages">';
      foreach ($ispesan as $ipes) {
        $psnjdle = strlen($ipes['psn_jdl'])==0?'Belum Ada Judul':$ipes['psn_jdl'];
        $nmpeg = $this->dbcore1->caripeg($ipes['psn_oleh']);
        if($pegid != $ipes['psn_oleh']) {
          echo '<li><img src="'.base_url().'dapur0/images/foto/'.str_replace('.','',$ipes['psn_oleh']).'.png" class="avatar" alt="Avatar"><div class="message_date"><h4 class="date text-info">'.date('d',strtotime($ipes['psn_wkt'])).'</h4><p class="month">'.date('M',strtotime($ipes['psn_wkt'])).'</p><h4 class="year">'.date('y',strtotime($ipes['psn_wkt'])).'</h4></div>';
        if($ipes['psn_mark']==0){
          echo '<div class="message_wrapper"><h4 class="heading" style="color:#FF0000;">'.$psnjdle.'</h4>';
        } else {
          echo '<div class="message_wrapper"><h4 class="heading">'.$psnjdle.'</h4>';
        }
        echo '<p class="message">'.$ipes['psn_isi'].'</p><br /></div></li>';
        }
      }
    }
    echo '</ul></div>';
  }
}

function cekinet(){
  $inet = FALSE;
//    $connected = @fsockopen("google.com", 80);
    $connected = @fsockopen('8.8.8.8', "80", $errno, $errstr, 10);
    if ($connected){
//        $is_conn = true; //action when connected
        fclose($connected);
        $inet = 'sambung';
        $data = array(
          'qper_nil' => 1
        );
    }else{
//        $is_conn = false; //action in connection failure
        $inet = 'putus';
        $data = array(
          'qper_nil' => 0
        );
    }
    $this->dbcore1->patroli('INET',$data);
echo $inet;
}

function is_url_exist($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}

function getidpesan($varpeg = FALSE){
  $pegid = substr($this->input->post('varpeg'),0,11);
  $crgrp = substr($this->input->post('varpeg'),-3);
  $dtpesan = $this->dbcore1->dafpesan($crgrp,$pegid,0);
  $jpsn = 0;
  if($dtpesan){
    foreach ($dtpesan as $dtpsn) {
      $jpsn++;
    }
    echo 'pesanbaru'.$jpsn;
    $jamemail = date('H:i');
    if($jamemail=='12:45'){
      $this->load->library('email');

      $this->email->from('antoniusamp@gmail.com', 'QHMS-Administrasi');
      $this->email->to('ymakarius@gmail.com');
//      $this->email->cc('another@another-example.com');
//      $this->email->bcc('them@their-example.com');

      $this->email->subject('Pesan belum dibaca');
      $this->email->message($this->dbcore1->caripeg($pegid)['pgpnama'].' mempunyai '.$jpsn.' pesan yang belum dibaca.');

      $this->email->send();
    }
  } else {
    return false;
  }
}

function setmkpesan($varpeg = FALSE){
  $pegid = substr($this->input->post('varpeg'),0,11);
  $crgrp = substr($this->input->post('varpeg'),-3);
  $wktps = date('Y-m-d');
$mkpesan = $this->dbcore1->markpesan($crgrp,$pegid,$wktps,1);
exit;
}

function chisri($jenpas = FALSE){
  $hchisri = $this->transisi->cjumaduh($jenpas);
  $hchmsri = $this->transisi->cjumqbilri($jenpas);
  if($hchisri!=$hchmsri){
    echo 'Jumlah px RI HIS '.$hchisri['jumpx'].' | Jumlah px RI HMS '.$hchmsri['jumpx'];
  } else {
    echo 'proses';
  }
}

function cat_cetak($reg = FALSE){
  $cnokwit = $this->transisi->ckwitansi($reg);
  if(!$reg){
    if($cnokwit['jkwit']==0){
      $durk = 1;
    } else {
      $durk = $cnokwit['jkwit']+1;
    }
    $urkwit = str_pad($durk, 4, '0', STR_PAD_LEFT);
      echo 'KW'.date('Ym').'-'.$urkwit;
  } else {
    if($cnokwit['jkwit']>0){
      echo 'tercetak';
    }
  }
}


function cpostri($jenpas = FALSE){
  $hchisri = $this->transisi->cjumqbilri($jenpas,'y','post');
  $jenpx = substr($jenpas,20);
    switch ($jenpx) {
      case 'bpjs':
      $kdpas = '1';
      $dbpas = 'askesdata';
      break;

      default:
      $kdpas = '0';
      $dbpas = 'his';
      break;
    }
    if($hchisri){
    foreach ($hchisri as $pxhri) {
      $this->rekpasien($kdpas.$pxhri['qbmain_reg'],'post'.substr($jenpas,0,20));


    }
  }
//    $this->transisi->delhmsri();
}

function format_interval(DateInterval $interval) {
    $result = "";
    if ($interval->y) { $result .= $interval->format("%y th "); }
    if ($interval->m) { $result .= $interval->format("%m bln "); }
    if ($interval->d) { $result .= $interval->format("%d hr "); }
    if ($interval->h) { $result .= $interval->format("%h jam "); }
    if ($interval->i) { $result .= $interval->format("%i mnt "); }
    if ($interval->s) { $result .= $interval->format("%s dtk "); }
    return $result;
}

function cpostpx($jenpas = FALSE){
  $idpeg = $this->session->userdata('pgpid');
  $hcinet = $this->dbcore1->cinet();
  if($hcinet){
  $regpx = substr($jenpas,1);
  $namaop = $this->dbcore1->caripeg($idpeg)['pgpnama'];
  $namapx = $this->transisi->caribiopx($regpx)['bionama'];
  $wktin = strtotime($this->transisi->caribiopx($regpx)['bioupd']);
  $wktou = strtotime($this->transisi->cjnoreg($regpx)['wktup']);
  $first_date = new DateTime($this->transisi->cjnoreg($regpx)['wktup']);
  $second_date = new DateTime($this->transisi->caribiopx($regpx)['bioupd']);
  $difference = $first_date->diff($second_date);
  $wlyn = $this->format_interval($difference);
  $this->rekpasien($jenpas,'post');
  if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
    $hcinet=$this->dbcore1->cinet();if($hcinet){$this->dbcore1->routedqt($namaop.' CTKBILL-'.strtoupper($this->transisi->caribiopx($regpx)['bioper']).' '.$regpx.' | '.$namapx. PHP_EOL .'Pelayanan '.$wlyn,'1');}
    }
  }
  $this->transisi->cleanrek($idpeg,'detail');
}

function cpostrj($jenpas = FALSE){
  $hchisrj = $this->transisi->cjumqbilrj($jenpas,'y');
  $jenpx = substr($jenpas,20);
    switch ($jenpx) {
      case 'bpjs':
      $kdpas = '1';
      $dbpas = 'askesdata';
      break;

      default:
      $kdpas = '0';
      $dbpas = 'his';
      break;
    }
    if($hchisrj){
    foreach ($hchisrj as $pxhrj) {
      $this->rekpasien($kdpas.$pxhrj['qbmain_reg'],'post');
    }
  }
}

function phisri($jenpas = FALSE){
  $hchisri = $this->transisi->cjumaduh($jenpas,'y');
  $jenpx = substr($jenpas,20);
  switch ($jenpx) {
    case 'bpjs':
    $kdpas = '1';
    $dbpas = 'askesdata';
    break;

    default:
    $kdpas = '0';
    $dbpas = 'his';
    break;
  }
  if($hchisri){
  foreach ($hchisri as $pxhri) {
    $vekg = 0;
    $vusg = 0;
    $vrad = 0;
    $vlab = 0;
    $vgiz = 0;

    $ckpenmed = $this->transisi->get_kpmed($pxhri['noreg']);
    if($ckpenmed){
      foreach ($ckpenmed as $crpmed)
      $jpmed = substr(strtolower($crpmed->hasil),0,3);
      switch ($jpmed) {
        case 'usg':
          $vusg = 1;
          break;

        case 'rad':
          $vrad = 1;
          break;

        case 'lab':
          $vlab = 1;
          break;

        case 'giz':
          $vgiz = 1;
          break;

        default:
          $vekg = 0;
          break;
        }
      }
      $dtri = array(
        'qbmain_idrs' => $pxhri['id'],
        'qbmain_reg' => 'ri'.$pxhri['noreg'],
        'qbmain_tglmasuk' => $pxhri['tglmasuk'],
        'qbmain_tglkeluar' => $pxhri['tglkeluar'],
        'qbmain_bsl' => $pxhri['asal'],
        'qbmain_kmr' => $pxhri['kamar'],
        'qbmain_kls' => $pxhri['kelas'],
        'qbmain_ekg' => $vekg,
        'qbmain_usg' => $vusg,
        'qbmain_rad' => $vrad,
        'qbmain_lab' => $vlab,
        'qbmain_giz' => $vgiz,
        'qbmain_hae' => 0,
        'qbmain_adm' => 0,
        'qbmain_prn' => $kdpas
      );
      $this->transisi->simphmsri($dtri);
    }
  }
  $this->transisi->delhmsri();
}

function chisrj($jenpas = FALSE){
  $hchisrj = $this->transisi->cjumaduh1($jenpas);
  $hchmsrj = $this->transisi->cjumqbilrj($jenpas);
  if($hchisrj!=$hchmsrj){
    echo 'Jumlah px RJ HIS '.$hchisrj['jumpx'].' | Jumlah px RJ HMS '.$hchmsrj['jumpx'];
  } else {
    echo 'proses';
  }
}

function phisrj($jenpas = FALSE){
  $hchisrj = $this->transisi->cjumaduh1($jenpas,'y');
  if($hchisrj){
    if($jenpas){
      switch (substr($jenpas,20)) {
        case 'bpjs':
        $kdpas = '1';
        $dbpas = 'askesdata';
        break;

        default:
        $kdpas = '0';
        $dbpas = 'his';
        break;
      }
    }
      foreach ($hchisrj as $pxhrj) {
        $vekg = 0;
        $vusg = 0;
        $vrad = 0;
        $vlab = 0;
        $vgiz = 0;

        $ckpenmed = $this->transisi->get_kpmed($pxhrj['noreg']);
        if($ckpenmed){
          foreach ($ckpenmed as $crpmed)
          $jpmed = substr(strtolower($crpmed->hasil),0,3);
          switch ($jpmed) {
            case 'usg':
              $vusg = 1;
              break;

            case 'rad':
              $vrad = 1;
              break;

            case 'lab':
              $vlab = 1;
              break;

            case 'giz':
              $vgiz = 1;
              break;

            default:
              $vekg = 0;
              break;
          }
        }
          $dtrj = array(
            'qbmain_idrs' => $pxhrj['id'],
            'qbmain_reg' => 'rj'.$pxhrj['noreg'],
            'qbmain_tglmasuk' => $pxhrj['tglperiksa'],
            'qbmain_tglkeluar' => date('Y-m-d'),
            'qbmain_poli' => $pxhrj['asal'],
            'qbmain_ekg' => $vekg,
            'qbmain_usg' => $vusg,
            'qbmain_rad' => $vrad,
            'qbmain_lab' => $vlab,
            'qbmain_giz' => $vgiz,
            'qbmain_hae' => 0,
            'qbmain_adm' => 0,
            'qbmain_prn' => $kdpas
          );
          $this->transisi->simphmsrj($dtrj);
      }
      $this->transisi->delhmsrj();
      }
}

function upjumpx($pol = FALSE){
//  $this->load->model('dbcore1','',TRUE);
$data = array();
for($i = 1; $i <=  date('d'); $i++) {
  $uptgl = str_pad($i, 2, '0', STR_PAD_LEFT);
  $crrj = $this->dbcore1->cjumpxn($pol,$uptgl);
//  foreach($crdok as $hslant){
    $jmlpx = $crrj['jumant'];
    $data[] .= $jmlpx;
//  }
}
echo json_encode($data);
}

function upjumpi($bgs = FALSE){
//  $this->load->model('dbcore1','',TRUE);
$data = array();
for($i = 1; $i <=  date('d'); $i++) {
  $uptgl = str_pad($i, 2, '0', STR_PAD_LEFT);
  $crri = $this->dbcore1->cjumpxm($bgs,$uptgl);
//  foreach($crdok as $hslant){
    $jmlpx = $crri['jumant'];
    $data[] .= $jmlpx;
//  }
}
echo json_encode($data);
}

function upjumtgl(){
  // for each day in the month
  for($i = 1; $i <=  date('d'); $i++)
  {
     // add the date to the dates array
     $dates[] = str_pad($i, 2, '0', STR_PAD_LEFT);
  }

echo json_encode($dates);

}

//--------------------------RM
public function ajax_list() {
  $list = $this->person_model->get_datatables();
  $data = array();
  $no = $_POST['start'];
  foreach ($list as $person) {

          $jk = $person->pxpjk=='100'?'<a href="#" title="Laki-Laki"><i class="fa fa-male blue"></i></a>':'<a href="#" title="Perempuan"><i class="fa fa-female pink"></i></a>';
          $jk==''?'<a href="#" title="Tidak Jelas"><i class="fa fa-question"></i></a>':$jk;

          $almt=$person->pxpalamat==''?'<i class="fa fa-question-circle" style="color:#FF0000;"></i>':strtoupper($person->pxpalamat);
          $rtrw=$person->pxprtrw==''?'<br />RT/RW: <i class="fa fa-question-circle" style="color:#FF0000;"></i>, ':'<br />RT. '.substr($person->pxprtrw,2).'/RW. '.substr($person->pxprtrw,-2);
          $kel=$person->vdes==''?'Kel. <i class="fa fa-question-circle" style="color:#FF0000;"></i>, ':'Kel. '.strtoupper($person->vdes).', ';
          $kec=$person->vkec==''?'Kec. <i class="fa fa-question-circle" style="color:#FF0000;"></i>, ':'Kec. '.strtoupper($person->vkec).', ';
          $kab=$person->vkab==''?'Kab. <i class="fa fa-question-circle" style="color:#FF0000;"></i>, ':'Kab. '.strtoupper($person->vkab).', ';
          $prp=$person->vprp==''?'Prop. <i class="fa fa-question-circle" style="color:#FF0000;"></i>, ':'Prop. '.strtoupper($person->vprp);
          $kunj=$this->dbcore1->tbumum('qvar_umum','varid',$person->pxpkunjungan);

    $no++;
    $row = array();
    $row[] = $jk;
    $row[] = $person->pxpnama;
    $row[] = $person->pxputh.' th, '.$person->pxpubl.' bln, '.$person->pxpuhr.' hr';
    $row[] = $almt.$rtrw.' '.$kel.$kec.$kab.$prp;
    $row[] = $person->pxptplhr.', '.date("d-M-Y",strtotime($person->pxptglhr));
    $row[] = 'Telp. '.$person->pxptelp.' HP. '.$person->pxphp;
    $row[] = $person->vagama;
    $row[] = $person->vdik;
    $row[] = $person->vkrj;
    $row[] = $person->vsuku;
    $row[] = $kunj['varnama'];
    $row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Arsip" onclick="prosesarsip('."'".$person->pxpidrs."'".')"><i class="glyphicon glyphicon-tags"></i> Arsip</a><a class="btn btn-sm btn-primary" href="'.site_url("markas/prosespx/cekpx?rmod=area3&name=$person->pxpidrs").'" title="Detail" ><i class="glyphicon glyphicon-pencil"></i> Detail Data</a>';
//          <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

    $data[] = $row;
  }

  $output = array(
          "draw" => $_POST['draw'],
          "recordsTotal" => $this->person_model->count_all(),
          "recordsFiltered" => $this->person_model->count_filtered(),
          "data" => $data
      );
  //output to json format
  echo json_encode($output);
}

public function postacceptor(){
  $pegid = $this->session->userdata('pgpid');
  $imdate = str_replace('.', '', $pegid).date('YmdHis');
   $accepted_origins = array("http://localhost", "http://192.168.1.1", "http://192.168.40.10");
  $imageFolder = "dapur0/semstorage/";

  reset ($_FILES);
  $temp = current($_FILES);
  if (is_uploaded_file($temp['tmp_name'])){
    if (isset($_SERVER['HTTP_ORIGIN'])) {
      // same-origin requests won't set an origin. If the origin is set, it must be valid.
      if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      } else {
        header("HTTP/1.1 403 Origin Denied");
        return;
      }
    }
    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }
    $filetowrite = $imageFolder . $imdate.".".strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION));
    move_uploaded_file($temp['tmp_name'], $filetowrite);
    echo json_encode(array('location' => $filetowrite));
  } else {
    header("HTTP/1.1 500 Server Error");
  }

}


//==================cookies start=================
public function simcok($coknm = false, $cokisi = false)
{
    if (!$coknm)
    {
        $coknm = $this
            ->input
            ->post('nmcok');
        $cokisi = $this
            ->input
            ->post('nlcok');
    }
    $this->dbcore1->simcok($coknm, $cokisi);
}

public function getcok($coknm = false)
{
    if (!$coknm)
    {
        $coknm = $this
            ->input
            ->post('nmcok');
    }
    return $this->dbcore1->getcok($coknm);
}

public function delcok($coknm = false)
{
    if (!$coknm)
    {
        $coknm = $this
            ->input
            ->post('nmcok');
    }
    $this->dbcore1->delcok($coknm);
}

//==================cookies end===================
}
