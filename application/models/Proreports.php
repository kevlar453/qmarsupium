<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proreports extends CI_Model {

    function __construct(){
    parent::__construct();
    $this->load->model('proreports','',TRUE);
    $this->load->helper('url','form','parse');
//    $this->load->library('database');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
    }

    var $table1 = 'qmain_akun_jur';
    var $table2 = 'qmain_akun_trx';

    var $column_search6 = array('temp1_noper','temp1_perk');
    var $column_order6 = array('temp1_ur','temp1_urut',null);
    var $order6 = array('temp1_ur' => 'asc');

    function _get_datatables_query4($idpeg = FALSE){
            $this->dbmain->select('*');
            $this->dbmain->from('qtemp_akun_neraca');
            $this->dbmain->where('temp1_akses',$idpeg);
            $this->dbmain->where('temp1_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
            $i = 0;
            foreach ($this->column_search6 as $item){
                if($_POST['search']['value']){
                    if($i===0){
                        $this->dbmain->group_start();
                        $this->dbmain->like($item, $_POST['search']['value']);
                    } else {
                        $this->dbmain->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search6) - 1 == $i)
                        $this->dbmain->group_end();
                }
                $i++;
            }

            if(isset($_POST['order'])){
                $this->dbmain->order_by($this->column_order6[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } elseif(isset($this->order6)) {
                $order6 = $this->order6;
                $this->dbmain->order_by(key($order6), $order6[key($order6)]);
            }
    }


    public function filltemp1($ar = FALSE,$nikar = FALSE){
      $this->_get_datatables_query4($nikar);
      if($_POST['length'] != -1)
      $this->dbmain->limit($_POST['length'], $_POST['start']);
      $query = $this->dbmain->get();
      return $query->result();
      exit;
    }

    function _deltbner($id = FALSE){
       $this->dbmain->where('temp1_akses', $id);
      $this->dbmain->where('temp1_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
       $this->dbmain->delete('qtemp_akun_neraca');
    }

    public function _isitbner1($range = FALSE,$nikpeg = FALSE){
      $ct1 = substr($range,0,10);
      $ct2 = substr($range,-10);
      $groupjur = array('0'=>'410','1'=>'610','2'=>'420','3'=>'620','4'=>'150','5'=>'620');
      $jturut = 1;
      for ($i=0; $i < count($groupjur); $i++) {
        $this->dbmain->select('concat(ka_3,".",ka_4) as aktrx_nomor,ka_nama as aktrx_nama');
        $this->dbmain->from('qvar_akun_ka4');
        $this->dbmain->where('ka_2',$groupjur[$i]);
        $query = $this->dbmain->get();
        $jtrx = array();

        $tida = 0;
        $tika = 0;
        $tidb = 0;
        $tikb = 0;
        $tidc = 0;
        $tikc = 0;

        $tnida = 0;
        $tnika = 0;
        $tnidb = 0;
        $tnikb = 0;
        $tnidc = 0;
        $tnikc = 0;

        if ($query->result()) {
          $li = 0;
          $nom1 = '';
          $nom2 = '';
            foreach ($query->result() as $jt) {
              $jumloop = count($query->result());
              $crup = 0;
              $nom1 = substr($jt->aktrx_nomor,0,3);
              $crup = floatval($this->_cariupner($jt->aktrx_nomor));
              $crsum1 = floatval($this->_carsumner1($ct1,$jt->aktrx_nomor));
              $crsum2 = floatval($this->_carsumner2($ct1,$jt->aktrx_nomor));
              $upd = $crup>0?$crup:0;
              $upk = $crup>0?0:$crup;
              $ida = abs($upd + $crsum1);
              $ika = abs($upk + $crsum2);
              $idb = floatval($this->_cariupner1($jt->aktrx_nomor,$range));
              $ikb = floatval($this->_cariupner2($jt->aktrx_nomor,$range));
              $ic = ($ida - $ika) + $idb - $ikb;
              $idc = $ic>0?abs($ic):0;
              $ikc = $ic>0?0:abs($ic);

              $tida += $ida;
              $tika += $ika;
              $tidb += $idb;
              $tikb += $ikb;
              $tidc += $idc;
              $tikc += $ikc;

              if($nom1 != $nom2) {
                $nom2 = '';
                $crtsum1 = floatval($this->_carsumner1($ct1,substr($jt->aktrx_nomor,0,3),'cek'));
                $crtsum2 = floatval($this->_carsumner2($ct1,substr($jt->aktrx_nomor,0,3),'cek'));
                $updt = $crup>0?$crup:0;
                $upkt = $crup>0?0:$crup;
                $tnida = abs($updt + $crtsum1);
                $tnika = abs($upkt + $crtsum2);
                $tnidb = floatval($this->_cariupner1(substr($jt->aktrx_nomor,0,3),$range,'cek'));
                $tnikb = floatval($this->_cariupner2(substr($jt->aktrx_nomor,0,3),$range,'cek'));
                $tnic = ($tnida - $tnika) + $tnidb - $tnikb;
                $tnidc = $tnic>0?abs($tnic):0;
                $tnikc = $tnic>0?0:abs($tnic);
                $this->dbmain->insert('qtemp_akun_neraca', array('temp1_urut'=>str_pad($jturut, 2, '0', STR_PAD_LEFT),'temp1_noper'=>substr($jt->aktrx_nomor,0,3),'temp1_perk'=>'SUBTOTAL-1','temp1_da'=>$tnida,'temp1_ka'=>$tnika,'temp1_db'=>$tnidb,'temp1_kb'=>$tnikb,'temp1_dc'=>$tnidc,'temp1_kc'=>$tnikc,'temp1_akses'=>$nikpeg,'temp1_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
                $jturut++;
              }
              $this->dbmain->insert('qtemp_akun_neraca', array('temp1_urut'=>str_pad($jturut, 2, '0', STR_PAD_LEFT),'temp1_noper'=>$jt->aktrx_nomor,'temp1_perk'=>$jt->aktrx_nama,'temp1_da'=>$ida,'temp1_ka'=>$ika,'temp1_db'=>$idb,'temp1_kb'=>$ikb,'temp1_dc'=>$idc,'temp1_kc'=>$ikc,'temp1_akses'=>$nikpeg,'temp1_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
              $nom2 = substr($jt->aktrx_nomor,0,3);

              $li++;
              if($li == $jumloop) {
                $this->dbmain->insert('qtemp_akun_neraca', array('temp1_urut'=>str_pad($jturut+1, 2, '0', STR_PAD_LEFT),'temp1_noper'=>'','temp1_perk'=>'SUBTOTAL-2','temp1_da'=>$tida,'temp1_ka'=>$tika,'temp1_db'=>$tidb,'temp1_kb'=>$tikb,'temp1_dc'=>$tidc,'temp1_kc'=>$tikc,'temp1_akses'=>$nikpeg,'temp1_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
                $tida = 0;
                $tika = 0;
                $tidb = 0;
                $tikb = 0;
                $tidc = 0;
                $tikc = 0;
                $nom2 = '';
                $jturut++;
              }
              $jturut++;
            }
        } else {
            return FALSE;
        }
      }

    }

    public function _cariupner($ncarup1 = FALSE){
      $this->dbmain->select('sum(ka_saldoawal) as ka_saldoawal');
      $this->dbmain->from('qvar_akun_ka5');
      $this->dbmain->where('concat(ka_3,".",ka_4)',$ncarup1);
      $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
      $this->dbmain->group_by('concat(ka_3,".",ka_4)');
//      $this->dbmain->where('concat(ka_3,\'.\',ka_4,\'.\',ka_5)',$ncarup1);
      $query = $this->dbmain->get();
      foreach($query->result() as $upner1){
        return $upner1->ka_saldoawal;
      }
    }

    public function _carsumner1($partg = FALSE,$parnojur = FALSE,$param = FALSE){
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      if($param){
        $this->dbmain->where('LEFT(aktrx_nomor,3)',$parnojur);
      } else{
        $this->dbmain->where('LEFT(aktrx_nomor,6)',$parnojur);
      }
      if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
        $this->dbmain->where('aktrx_post','1');
      } else {
        $this->dbmain->where('aktrx_post','0');
      }
      $this->dbmain->where('aktrx_jns','D');
      $this->dbmain->where('aktrx_mark','0');
      $this->dbmain->where('aktrx_post','1');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl <',$partg);
      $this->dbmain->group_by('left(aktrx_nomor,6)');
      $query = $this->dbmain->get();
      foreach($query->result() as $upsumner){
        return $upsumner->aktrx_jum;
      }
    }

    public function _carsumner2($partg = FALSE,$parnojur = FALSE,$param = FALSE){
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      if($param){
        $this->dbmain->where('LEFT(aktrx_nomor,3)',$parnojur);
      } else{
        $this->dbmain->where('LEFT(aktrx_nomor,6)',$parnojur);
      }
      if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
        $this->dbmain->where('aktrx_post','1');
      } else {
        $this->dbmain->where('aktrx_post','0');
      }
      $this->dbmain->where('aktrx_jns','K');
      $this->dbmain->where('aktrx_mark','0');
      $this->dbmain->where('aktrx_post','1');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl <',$partg);
      $this->dbmain->group_by('left(aktrx_nomor,6)');
      $query = $this->dbmain->get();
      foreach($query->result() as $upsumner){
        return $upsumner->aktrx_jum;
      }
    }

    public function _cariupner1($ncarup2 = FALSE,$rgu1 = FALSE,$param = FALSE){
      $ct1 = substr($rgu1,0,10);
      $ct2 = substr($rgu1,-10);
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $this->dbmain->where('qmain_akun_jur.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
      if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
        $this->dbmain->where('aktrx_post','1');
      } else {
        $this->dbmain->where('aktrx_post','0');
      }
      $this->dbmain->where('aktrx_jns','D');
      $this->dbmain->where('aktrx_mark','0');
      if($param){
        $this->dbmain->where('left(aktrx_nomor,3)',$ncarup2);
        $this->dbmain->group_by('left(aktrx_nomor,3)');
      } else{
        $this->dbmain->where('left(aktrx_nomor,6)',$ncarup2);
        $this->dbmain->group_by('left(aktrx_nomor,6)');
      }
      $query = $this->dbmain->get();
      foreach($query->result() as $upner2){
        return $upner2->aktrx_jum;
      }
    }

    public function _cariupner2($ncarup3 = FALSE,$rgu1 = FALSE, $param = FALSE){
      $ct1 = substr($rgu1,0,10);
      $ct2 = substr($rgu1,-10);
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $this->dbmain->where('qmain_akun_jur.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
      if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
        $this->dbmain->where('aktrx_post','1');
      } else {
        $this->dbmain->where('aktrx_post','0');
      }
      $this->dbmain->where('aktrx_jns','K');
      $this->dbmain->where('aktrx_mark','0');
      if($param){
        $this->dbmain->where('left(aktrx_nomor,3)',$ncarup3);
        $this->dbmain->group_by('left(aktrx_nomor,3)');
      } else{
        $this->dbmain->where('left(aktrx_nomor,6)',$ncarup3);
        $this->dbmain->group_by('left(aktrx_nomor,6)');
      }
      $query = $this->dbmain->get();
      foreach($query->result() as $upner3){
        return $upner3->aktrx_jum;
      }
    }

    public function hitungtrx($param1 = FALSE,$param2 = FALSE,$param3 = FALSE){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      if($param1 == 'thn'){
        $this->dbmain->select('YEAR(akjur_tgl) as waktu');
      } else {
        $this->dbmain->select('MONTH(akjur_tgl) as waktu');
      }
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
      $this->dbmain->join('qmain_akun_jur'.($cekkel == '00'?'_post':''),'qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_nomor=qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur','left');
        if($cekkel != '00'){
          if($param3 == '2'){
            $this->dbmain->where('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark','0');
          }
          $this->dbmain->where('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        }
      if($param3 != '81'){
        if($param3 == '2'){
          $this->dbmain->where('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post','0');
        } else {
          $this->dbmain->where('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post','1');
        }
      }
      if($param1 == 'thn'){
        $this->dbmain->group_by('YEAR(akjur_tgl)');
      } else {
        $this->dbmain->where('YEAR(akjur_tgl)',$param2);
        $this->dbmain->group_by('MONTH(akjur_tgl)');
      }
      $query = $this->dbmain->get();
      if($param1 == 'thn'){
        return $query->result();
      } else {
        foreach($query->result() as $cwaktu){
          $wkt[] = array(
            'huruf' => nama_bulan($cwaktu->waktu),
            'angka' => $cwaktu->waktu
          );
        }
        return $wkt;
      }
    }

    public function setperi($setkeu = FALSE){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('concat(MONTH(qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl),"-",RIGHT(YEAR(qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl),2)) as peri');
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
      $this->dbmain->join('qmain_akun_jur'.($cekkel == '00'?'_post':''),'qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_nomor=qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur','left');
        if($cekkel != '00'){
          $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
        } else {
          $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
        }
      $this->dbmain->group_by('LEFT(qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl,7)');
      $kelperi = $this->dbmain->get();
      if($kelperi){
        return $kelperi->result_array();
      }
    }

    public function setkm($setkeu = FALSE){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('SUM(aktrx_jum) as jkm');
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
      $this->dbmain->join('qmain_akun_jur'.($cekkel == '00'?'_post':''),'qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_nomor=qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur','left');
      $this->dbmain->where(array('aktrx_jns'=>'D','LEFT(aktrx_nomor,1)'=>'1','aktrx_mark'=>'0'));
      if($cekkel != '00'){
        $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
      } else {
        $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
      }
      $this->dbmain->group_by('LEFT(qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl,7)');
      $kelkm = $this->dbmain->get();
      if($kelkm){
        return $kelkm->result_array();
      }
    }

    public function setkk($setkeu = FALSE){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('SUM(aktrx_jum) as jkk');
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
      $this->dbmain->join('qmain_akun_jur'.($cekkel == '00'?'_post':''),'qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_nomor=qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur','left');
      $this->dbmain->where(array('aktrx_jns'=>'K','LEFT(aktrx_nomor,1)'=>'1','aktrx_mark'=>'0'));
      if($cekkel != '00'){
        $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
      } else {
        $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
      }
      $this->dbmain->group_by('LEFT(qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl,7)');
      $kelkk = $this->dbmain->get();
      if($kelkk){
        return $kelkk->result_array();
      }
    }

    public function settm($setkeu = FALSE){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('SUM(aktrx_jum) as jtm');
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
      $this->dbmain->join('qmain_akun_jur'.($cekkel == '00'?'_post':''),'qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_nomor=qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur','left');
      $this->dbmain->where(array('aktrx_jns'=>'D','LEFT(aktrx_nomor,1)'=>'6','aktrx_mark'=>'0'));
      if($cekkel != '00'){
        $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
      } else {
        $this->dbmain->where(array('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark'=>0,'qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_post'=>1));
      }
      $this->dbmain->group_by('LEFT(qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl,7)');
      $kelkk = $this->dbmain->get();
      if($kelkk){
        return $kelkk->result_array();
      }
    }

    function get_user($cekidentity = FALSE){
    $this->dbmain->select('*,NOW() as kadaluarsa');
    $this->dbmain->from('users');
    $this->dbmain->where('username',$cekidentity);
    $this->dbmain->join('users_groups','users_groups.user_id=users.username','left');
    $this->dbmain->join('groups','groups.id=users_groups.group_id','left');
    $this->dbmain->join('qmain_pgprofile_peg','qmain_pgprofile_peg.pgpid=users.username','left');
    $query = $this->dbmain->get();
           if($query -> num_rows() >= 1){
               return $query->row_array();
           }
           else {
               return false;
           }
           exit;
    }


}
