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
    $this->dbmain = $this->load->database('default',TRUE);
  }

    function index() {
      $rmoda = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'';
        $idpeg = $this->session->userdata('pgpid');
        $akpeg = $this->session->userdata('pgakses');
        $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
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
                      'dkbangsal' => '',
                      'jjenis' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis():'',
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

    function cekrekening(){
      $cekrek = $this->akuntansi->jur_jenis3();
      if(!$cekrek){
//        return json_encode($cekrek);
        echo 'NONE';
      }
    }

    function defrekening(){
//      $defrek = 'SIP';
      $defrek = $this->akuntansi->susundef();
      if($defrek){
        echo json_encode($defrek);
      }
    }

    function hitjur($vhit = FALSE){
      if($vhit=='J'){
        $data = $this->akuntansi->j_hit();
      } else {
        $data = $this->akuntansi->t_hit();
      }
      echo json_encode($data);
    }

    function hitpost(){
      $data = $this->akuntansi->j_post();
      echo json_encode($data);
    }


    function cnamapeg($nikpeg = FALSE){
        $data = $this->dbcore1->caripeg($nikpeg);
      echo json_encode($data['pgpnama']);
    }

    function bypassid($konfirmasi = FALSE){
      $idpass = json_decode($this->dbcore1->routekey($this->dbcore1->getcok('passqbk'),'d'),true);
      $tglcek = strtotime(date('Y-m').'-'.days_in_month(substr($idpass['kadaluarsa'],5,2),substr($idpass['kadaluarsa'],0,4))) - strtotime($idpass['kadaluarsa']);
      $hcek = TRUE;
      if($konfirmasi == $idpass['phone']){
        $cekusr = $this->dbcore1->cek_useraktif($idpass['email']);
        if(!$cekusr){
          $regb = $this->dbcore1->regbypass();
          if($regb){
            echo json_encode(array('tglpass'=>days_in_month(substr($idpass['kadaluarsa'],5,2),substr($idpass['kadaluarsa'],0,4)).'/'.date('m/Y'),'res'=>$tglcek>0?'Valid':'Expired'));
            } else {
              echo json_encode(array('res'=>'errid'));
            }
        } else {
          echo json_encode(array('res'=>'duplicate'));
        }
      } else {
        echo json_encode(array('res'=>'errid'));
      }
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

    public function cek_update(){
      $isitgl = $this->akuntansi->tgupdate();
      echo date('d-m-Y H:i',strtotime($isitgl['isijam'])).' ['.$isitgl['varnama'].']';
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
    $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $ling = substr($ar,0,5);
      $list = $this->akuntansi->fillgrid($ar);
      $data = array();
      $lstval = array();
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
      $rnwar = date('md').'fc';
      foreach ($list as $jurnal) {
          if($ling=='area2'){
              if(strlen($ar)==5){
                $cor = $jurnal->akjur_sts;
                $nojur = $jurnal->akjur_nomor;
                $urai = $jurnal->akjur_ket;
                $htg = $this->akuntansi->jumhit($nojur);
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

              $cnmpar = $this->akuntansi->caribag($jurnal->akjur_kopar);
              $clstval = $this->akuntansi->carival(strlen($ar)==5?$nojur:$trxjur,$jurnal->akjur_kopar);

              $no++;
              $row = array();
              if(strlen($ar)==25){
                $row[] = $tgl;
              }

              $row[] = strlen($ar)==5?$tgl:$trxno;
              $row[] = strlen($ar)==5?$nojur:$trxjur;
              $row[] = strlen($ar)==5?($cekkel == '00'?'<span style="color:#'.$rnwar.'">['.str_replace('Paroki ','',$cnmpar['varnama']).']</span> '.strtoupper($urai):strtoupper($urai)):($cekkel == '00'?'<span style="color:#'.$rnwar.'">['.str_replace('Paroki ','',$cnmpar['varnama']).']</span> '.$trxnm:$trxnm);
              $row[] = strlen($ar)==5?($clstval?'-':$jum):strtoupper($trxket);
              $row[] = strlen($ar)==5?($cor==1?'X':$htg):$trxdbt;
              if(strlen($ar)==25){
                $row[] = $trxkre;
              } else {
                $row[] = $ipost==0?'X':'+';
              }
              $data[] = $row;
              if(strlen($ar) == 5){
                if($jum == 0 && $cor != 1 && $ipost == 0){
                  $lstval[] = $row;
                }
              }
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

//      $this->dbcore1->simcok('lstval','lstval');

  echo json_encode($output);
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
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
        $list = $this->akuntansi->cvariabel();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $isika5) {
          $idakses = $this->dbcore1->routekey(get_cookie('simakses'),'d');
          $idkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
                $ka5nmr = /*$isika5->ka_1.'.'.$isika5->ka_2.'.'.*/$isika5->ka_3.'.'.$isika5->ka_4.'.'.$isika5->ka_5;
                $ka5nama = $isika5->ka_nama;
                $ka5up = date('d/m/Y H:i',strtotime($isika5->ka_up));
                $cnmpar = $this->akuntansi->caribag(substr($idkop,0,2).substr($isika5->ka_5,0,2));

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $ka5nmr;
                $row[] = $cekkel == '00'?'['.str_replace('Paroki ','',$cnmpar['varnama']).'] '.$ka5nama:$ka5nama;
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
                $row[] = $saldo->ka_3.'.'.$saldo->ka_4.'.'.$saldo->ka_5;
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
      $prm = $this->input->post('param');
    }

    if($prm == ''){
      $cekpst = $this->akuntansi->trx_posting($id,$this->dbcore1->routekey(get_cookie('simkop'),'d'));
    } else {
      $cekpst = $this->akuntansi->batch_posting($prm,$this->dbcore1->routekey(get_cookie('simkop'),'d'));
    }
    echo json_encode($cekpst);
  }


  public function koreksi2($id = FALSE){
    if(!$id){
      $id = $this->input->post('idjur');
      $add1 = $this->input->post('param');
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
          'akjur_kopar'=>$add1 == ''?$this->dbcore1->routekey(get_cookie('simkop'),'d'):$add1,
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
          'akjur_kopar'=>$add1 == ''?$this->dbcore1->routekey(get_cookie('simkop'),'d'):$add1,
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
          $cekkopar = strip_tags($this->input->post('param'));
            echo json_encode($this->akuntansi->get_kortrx($trx,$cekkopar!=''?$cekkopar:FALSE));
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

//-------------------userdata---START----
public function simudata(){
  $nmudata = $this->input->post('nmu');
  $nludata = $this->input->post('nlu');
  $cekudata = $this->session->userdata($nmudata);
  if($cekudata != ''){
    $this->deludata($nmudata);
  }
  $this->session->set_userdata(
    array(
      $nmudata=>$nludata
    )
  );
  $konfudata = $this->session->userdata($nmudata);
  if($konfudata != ''){
    echo $konfudata;
  }
}

public function deludata($nmudata = FALSE){
  if(!$nmudata){
    $nmudata = $this->input->post('nmu');
  }
  $sess_array = array(
      'set_value' => ''
  );

  $this->session->unset_userdata($nmudata, $sess_array);
//  session_destroy();
$konfudata = $this->session->userdata($nmudata);
if($konfudata != ''){
  echo $konfudata;
}

}
//-------------------userdata---END------

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
