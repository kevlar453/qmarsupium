<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akuntansi extends CI_Model {

    function __construct(){
    parent::__construct();
    $this->load->model('akuntansi','',TRUE);
    $this->load->model('dbcore1','',TRUE);
    $this->load->helper('url','form');
//    $this->load->library('database');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
    }

//    var $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
//    var $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    var $table1 = 'qmain_akun_jur';
    var $table2 = 'qmain_akun_trx';

    var $column_search1 = array('akjur_tgl','akjur_nomor','akjur_ket','akjur_nomor');
    var $column_order1 = array('akjur_tgl','akjur_nomor','akjur_ket','akjur_nomor',null);
    var $order1 = array('akjur_sts' => 'desc','akjur_up' => 'desc');
    var $column_search2 = array('qmain_akun_jur.akjur_tgl','qmain_akun_trx.aktrx_nojur','qmain_akun_trx.aktrx_nomor','qmain_akun_trx.aktrx_ket','qmain_akun_trx.aktrx_nama');
    var $column_order2 = array('aktrx_nojur','aktrx_nomor','aktrx_ket','aktrx_nama',null);
    var $order2 = array('aktrx_nojur' => 'asc');
    var $column_search3 = array('akjur_nomor','akjur_ket');
    var $column_order3 = array('akjur_tgl','aktrx_nomor','akjur_ket',null);
    var $order3 = array('akjur_tgl' => 'asc','aktrx_nomor' => 'asc');
    var $column_search4 = array('ka_nama','ka_saldoawal');
    var $column_order4 = array('ka_nama','ka_saldoawal',null);
    var $order4 = array('ka_nama' => 'asc');

    var $column_search5 = array('ka_nama','ka_1');
    var $column_order5 = array('ka_1','ka_2','ka_3',null);
    var $order5 = array('ka_nama' => 'asc');

    var $column_search6 = array('temp1_noper','temp1_perk');
    var $column_order6 = array('temp1_noper','temp1_perk',null);
    var $order6 = array('temp1_noper' => 'asc');

    function jur_jenis_all() {
        $this->dbmain->select('*');
        $query = $this->dbmain->get('qvar_akun_jur');
        $jjur = array();
        return $query->result();
    }

    function jur_jenis() {
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_akun_jur');
      $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        $query = $this->dbmain->get();
        $jjur = array();
        $ctjur = $query->row_array();

        if ($ctjur>1) {
            foreach ($query->result() as $jj) {
                $jjur[$jj->akjur_kode] = '['.$jj->akjur_kode2.'] '.$jj->akjur_nama;
            }
            return $jjur;
        } else {
            return FALSE;
        }
    }

    function jur_jenis2() {
        $this->dbmain->select('*');
        $this->dbmain->from('qvar_akun_ka5');
        $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
        $query = $this->dbmain->get();
        $jjur2 = array();
        $ctjur2 = $query->row_array();

        if ($ctjur2>1) {
            foreach ($query->result() as $jj) {
                $idper = $jj->ka_3.'.'.$jj->ka_4.'.'.$jj->ka_5;
                $nmper = $jj->ka_nama;
                $slper = $jj->ka_saldoawal;
                $jjur2[$idper] = $nmper;
            }
            return $jjur2;
        } else {
            return FALSE;
        }
    }

    function j_hit() {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('*');
      $this->dbmain->from('qmain_akun_jur'.($cekkel == '00'?'_post':''));
        if($cekkel != '00'){
          $this->dbmain->where(array('akjur_sts'=>0,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
        } else {
          $this->dbmain->where(array('akjur_sts'=>0));
        }
      $query = $this->dbmain->get();
      $jhit = $query->num_rows();

            return $jhit;
        exit;
    }

    function t_hit() {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
        $this->dbmain->select('*');
        $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
          if($cekkel != '00'){
            $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
          }
        $this->dbmain->where(array('aktrx_mark'=>0));
//        $this->dbmain->group_by('aktrx_nojur');
        $query = $this->dbmain->get();
        $thit = $query->num_rows();

            return $thit;
        exit;
    }

    function s_hit() {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
        if($cekkel != '00'){
          $this->dbmain->where(array('aktrx_mark'=>0,'aktrx_jns'=>'D','akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
        } else {
          $this->dbmain->where(array('aktrx_mark'=>0,'aktrx_jns'=>'D'));
        }
      $query = $this->dbmain->get();
      $dhit = $query->row_array();

      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
      if($cekkel != '00'){
        $this->dbmain->where(array('aktrx_mark'=>0,'aktrx_jns'=>'K','akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
      } else {
        $this->dbmain->where(array('aktrx_mark'=>0,'aktrx_jns'=>'K'));
      }
      $query = $this->dbmain->get();
      $khit = $query->row_array();
      $shit = $dhit['aktrx_jum'] - $khit['aktrx_jum'];

            return number_format($shit);
        exit;
    }

    function ds_hit() {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $datads = array();
      $this->dbmain->select('aktrx_nojur');
      $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
        if($cekkel != '00'){
          $this->dbmain->where(array('aktrx_mark'=>0,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
        } else {
          $this->dbmain->where(array('aktrx_mark'=>0));
        }
      $this->dbmain->group_by('aktrx_nojur');
      $query = $this->dbmain->get();
      $gjur = $query->result();
      if($gjur){
        foreach ($gjur as $gjr) {
          $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
          $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
          if($cekkel != '00'){
            $this->dbmain->where(array('aktrx_nojur'=>$gjr->aktrx_nojur,'aktrx_jns'=>'K','akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
          } else {
            $this->dbmain->where(array('aktrx_nojur'=>$gjr->aktrx_nojur,'aktrx_jns'=>'K'));
          }
          $query = $this->dbmain->get();
          $kjur = $query->row_array();
          if($kjur){

            $this->dbmain->select('sum(aktrx_jum)-'.$kjur['aktrx_jum'].' as aktrx_jum');
            $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
            if($cekkel != '00'){
              $this->dbmain->where(array('aktrx_nojur'=>$gjr->aktrx_nojur,'aktrx_jns'=>'D','akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
            } else {
              $this->dbmain->where(array('aktrx_nojur'=>$gjr->aktrx_nojur,'aktrx_jns'=>'D'));
            }
            $query = $this->dbmain->get();
            $djur = $query->row_array();

            $ghit = $djur['aktrx_jum']; // - $kjur['aktrx_jum'];

            if($ghit!=0){
              $datads[] .= $gjr->aktrx_nojur;
            }
          } else {
            exit;
          }
        }
        return $datads;
      }
      exit;
    }


    public function trx_jenis($filterData = FALSE,$param1 = FALSE,$param2 = FALSE,$param3 = FALSE){
      if($param2 == 'D'){
        $this->dbmain->select('akjur_debet');
      } else {
        $this->dbmain->select('akjur_kredit');
      }
      $this->dbmain->from('qvar_akun_jur');
      $this->dbmain->where('akjur_kode',$param3);
      $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $query1 = $this->dbmain->get();
      if($param2 == 'D'){
        $resq1 = explode(',',$query1->row_array()['akjur_debet']);
      } else {
        $resq1 = explode(',',$query1->row_array()['akjur_kredit']);
      }

      $this->dbmain->select('*');
      $this->dbmain->from('qvar_akun_ka3');
      $this->dbmain->where_in('ka_3',$resq1);
      $this->dbmain->like('ka_nama',$filterData);
      $this->dbmain->order_by('ka_3','asc');
      $query = $this->dbmain->get();
      return $query->result_array();
    }

    function chartbuku($zona = FALSE) {
      if(strlen($zona)>11){
        $area = substr($zona,-11);
        $arkd = substr($area,0,1);
        $artgls = substr($area,-10);
        $ct1 = substr($zona,17,10);
        $ct2 = substr($zona,27,10);
        $nj = substr($zona,5,12);
        if($arkd == 'D' || $arkd == 'K'){
          $kolom = 'sum(aktrx_jum) as aktrx_jum';
        } else {
          $kolom = 'akjur_tgl';
        }
      } else {
        if(strlen($zona)>1){
          $kolom = 'sum(aktrx_jum) as aktrx_jum';
          $arkd = substr($zona,0,1);
          $arbln = substr($zona,1,2);
          $arthn = substr($zona,-4);
        } else {
          $kolom = 'akjur_tgl';
        }
      }
      $this->dbmain->select($kolom);
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where(array('aktrx_mark'=>0));
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
        $this->dbmain->where('aktrx_post','1');
      } else {
        $this->dbmain->where('aktrx_post','0');
      }
      if(strlen($zona)>11) {
        $this->dbmain->where(array('aktrx_nomor'=>$nj));
        if($arkd == 'D' || $arkd == 'K'){
          $this->dbmain->where(array('akjur_tgl'=>$artgls,'aktrx_jns'=>$arkd));
        } else {
          $this->dbmain->where('qmain_akun_jur.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
        }
        $this->dbmain->group_by('akjur_tgl');
      } else {
        if(strlen($zona)>1){
          $this->dbmain->where(array('aktrx_jns'=>$arkd));
          $this->dbmain->where(array('MONTH(akjur_tgl)'=>$arbln,'YEAR(akjur_tgl)'=>$arthn));
        } else {
          $this->dbmain->group_by('YEAR(akjur_tgl),MONTH(akjur_tgl)');
        }
        $this->dbmain->order_by('YEAR(akjur_tgl)');
      }

      $query = $this->dbmain->get();
      if(strlen($zona)>11){
        if($arkd == 'D' || $arkd == 'K'){
          return $query->row_array();
        } else {
          return $query->result();
        }
      } else {
        if(strlen($zona)>1){
          return $query->row_array();
        } else {
          return $query->result();
        }
      }



          exit;

    }

    function _get_datatables_query($are){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
        $nik = $this->session->userdata('pgpid');
        $area = substr($are,0,5);
        $xtgl = substr($are,5,10);
        $ytgl = substr($are,-10);

        if($area=='area2'){
          $cekfil = $this->dbcore1->routekey(get_cookie('piljur'),'d');
          if(strlen($are)==25){
            $tginfo1 = date("Y-m-d",strtotime($xtgl));
            $tginfo2 = date("Y-m-d",strtotime($ytgl));
            $this->dbmain->select('*');
            $this->dbmain->from($this->table2.($cekkel == '00'?'_post':''));
            $this->dbmain->join('qmain_akun_jur'.($cekkel == '00'?'_post':''), 'qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_nomor = qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur','left');
            $this->dbmain->where('qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl BETWEEN \''. $tginfo1.'\' + INTERVAL 1 DAY and \''. $tginfo2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
            $this->dbmain->where('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_mark',0);
            if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
              $this->dbmain->where('aktrx_post','1');
            } else {
              $this->dbmain->where('aktrx_post','0');
            }
            if($cekkel != '00'){
              $this->dbmain->where('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
            }
            if($cekfil != ''){
              $this->dbmain->where('LEFT(qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur,2)',substr($cekfil,0,2));
            }
            $i = 0;
            foreach ($this->column_search2 as $item){
            if($_POST['search']['value']){
                if($i===0) // first loop
                {
                    $this->dbmain->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->dbmain->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->dbmain->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search2) - 1 == $i) //last loop
                    $this->dbmain->group_end(); //close bracket
            }
            $i++;
            }

            if(isset($_POST['order'])){
              $this->dbmain->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
            elseif(isset($this->order2)){
              $order2 = $this->order2;
              $this->dbmain->order_by(key($order2), $order2[key($order2)]);
            }

          } elseif(strlen($are)==5) {
            $this->dbmain->select('akjur_tgl,akjur_nomor,akjur_sts,akjur_ket,akjur_post,akjur_kopar');
            $this->dbmain->from($this->table1.($cekkel == '00'?'_post':''));
              if($cekkel != '00'){
                $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
              }
            if($this->session->userdata('pgsu')=='0'){
              $this->dbmain->where('akjur_akses',$nik);
            }
            $i = 0;
            foreach ($this->column_search1 as $item) // loop column
            {
                if($_POST['search']['value']) // if datatable send POST for search
                {
                    if($i===0) // first loop
                    {
                        $this->dbmain->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->dbmain->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->dbmain->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search1) - 1 == $i) //last loop
                        $this->dbmain->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($_POST['order'])) // here order processing
            {
                $this->dbmain->order_by($this->column_order1[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
            else if(isset($this->order1))
            {
                $order1 = $this->order1;
                $this->dbmain->order_by(key($order1), $order1[key($order1)]);
            }
          }

        } elseif($area=='area3') {
            $ar2 = $are;
            $nj = substr($ar2,5-strlen($ar2));
            $this->dbmain->select('*');
            $this->dbmain->where('aktrx_nojur',$nj);
            $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
            $this->dbmain->from($this->table2.($cekkel == '00'?'_post':''));
            $i = 0;
            foreach ($this->column_search2 as $item){
                if($_POST['search']['value']){
                    if($i===0) // first loop
                    {
                        $this->dbmain->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->dbmain->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->dbmain->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search2) - 1 == $i) //last loop
                        $this->dbmain->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($_POST['order'])){
                $this->dbmain->order_by($this->column_order2[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            }
            elseif(isset($this->order2)){
                $order2 = $this->order2;
                $this->dbmain->order_by(key($order2), $order2[key($order2)]);
            }
        } elseif($area=='area4') {
            $ar1 = substr($are,-20);
            $ct1 = substr($ar1,0,10);
            $ct2 = substr($ar1,-10);
            $ar2 = substr($are,0,-20);
            $nj = substr($ar2,5-strlen($ar2));

            $this->dbmain->select('*');
//            $this->dbmain->select('akjur_tgl','aktrx_nojur','aktrx_ket','aktrx_jum');
            $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
            $this->dbmain->join('qmain_akun_jur'.($cekkel == '00'?'_post':''),'qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_nomor=qmain_akun_trx'.($cekkel == '00'?'_post':'').'.aktrx_nojur','left');
            $this->dbmain->where('qmain_akun_jur'.($cekkel == '00'?'_post':'').'.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
            $this->dbmain->where(array('aktrx_nomor'=>$nj,'aktrx_mark'=>0));
              if($cekkel != '00'){
                $this->dbmain->where('qmain_akun_trx'.($cekkel == '00'?'_post':'').'.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
              }
            if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
              $this->dbmain->where('aktrx_post','1');
            } else {
              $this->dbmain->where('aktrx_post','0');
            }
            $i = 0;
            foreach ($this->column_search3 as $item){
                if($_POST['search']['value']){
                    if($i===0) // first loop
                    {
                        $this->dbmain->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                        $this->dbmain->like($item, $_POST['search']['value']);
                    }
                    else
                    {
                        $this->dbmain->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search3) - 1 == $i) //last loop
                        $this->dbmain->group_end(); //close bracket
                }
                $i++;
            }

            if(isset($_POST['order'])){
                $this->dbmain->order_by($this->column_order3[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } elseif(isset($this->order3)){
                $order3 = $this->order3;
                $this->dbmain->order_by(key($order3), $order3[key($order3)]);
            }
        }
    }

    function _get_datatables_query2(){
            $this->dbmain->select('ka_nama,ka_saldoawal');
            $this->dbmain->from('qvar_akun_ka5');
            $this->dbmain->where('ka_saldoawal !=',0);
            $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
            $i = 0;
            foreach ($this->column_search4 as $item){
                if($_POST['search']['value']){
                    if($i===0){
                        $this->dbmain->group_start();
                        $this->dbmain->like($item, $_POST['search']['value']);
                    } else {
                        $this->dbmain->or_like($item, $_POST['search']['value']);
                    }
                    if(count($this->column_search4) - 1 == $i)
                        $this->dbmain->group_end();
                }
                $i++;
            }

            if(isset($_POST['order'])){
                $this->dbmain->order_by($this->column_order4[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
            } elseif(isset($this->order4)) {
                $order4 = $this->order4;
                $this->dbmain->order_by(key($order4), $order4[key($order4)]);
            }
    }

    function _get_datatables_query3(){
      $idakses = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $idkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_akun_ka5');
      if($idakses != '00'){
        $this->dbmain->where('LEFT(ka_5,2)',$idakses);
      }
      $i = 0;
      foreach ($this->column_search5 as $item){
          if($_POST['search']['value']){
              if($i===0){
                  $this->dbmain->group_start();
                  $this->dbmain->like($item, $_POST['search']['value']);
              } else {
                  $this->dbmain->or_like($item, $_POST['search']['value']);
              }
              if(count($this->column_search5) - 1 == $i)
                  $this->dbmain->group_end();
          }
          $i++;
      }

      if(isset($_POST['order'])){
          $this->dbmain->order_by($this->column_order5[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } elseif(isset($this->order5)) {
          $order5 = $this->order5;
          $this->dbmain->order_by(key($order5), $order5[key($order5)]);
      }
    }

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


	function count_filtered($ar)
	{
		$this->_get_datatables_query($ar);
		$query = $this->dbmain->get();
		return $query->num_rows();
	}

	public function count_all($ar) {
        $area = substr($ar,0,5);
        $ar2 = substr($ar,0,-20);
        $kodper = substr($ar2,5-strlen($ar2));
		if($area=='area2'){
      if(strlen($ar)==5){
        $this->dbmain->from('qmain_akun_jur');
      } elseif(strlen($ar)==25){
        $this->dbmain->from('qmain_akun_trx');
      }
      $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
    } elseif($area=='area3'){
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
    }elseif($area=='area4'){
      if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
        $this->dbmain->get_where('qmain_akun_trx',array('aktrx_nojur'=>$kodper,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),'aktrx_post'=>'1'));
      } else {
        $this->dbmain->get_where('qmain_akun_trx',array('aktrx_nojur'=>$kodper,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d'),'aktrx_post'=>'0'));
      }

    }
    return $this->dbmain->count_all_results();
	}

	function saldo_filtered()
	{
		$this->_get_datatables_query2();
		$query = $this->dbmain->get();
		return $query->num_rows();
	}

	public function saldo_all() {
            $this->dbmain->from('qvar_akun_ka5');
            $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
		return $this->dbmain->count_all_results();
	}

  function vari_filtered()
	{
		$this->_get_datatables_query3();
		$query = $this->dbmain->get();
		return $query->num_rows();
	}

	public function vari_all() {
            $this->dbmain->from('qvar_akun_ka5');
            $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
		return $this->dbmain->count_all_results();
	}

    public function fillgrid($ar = FALSE){
		$this->_get_datatables_query($ar);
		if($_POST['length'] != -1)
		$this->dbmain->limit($_POST['length'], $_POST['start']);

		$query = $this->dbmain->get();
		return $query->result();

        exit;
    }

    public function fillgrid4saldo($are = FALSE) {
      $saldeb = $this->fillgrid4saldod($are);
      $salkre = $this->fillgrid4saldok($are);
      return $saldeb - $salkre;
      exit;
    }


    public function fillgrid4saldod($are = FALSE) {
      $ar1 = substr($are,-20);
      $ctawal = '2023-01-01';
      $ct1 = substr($ar1,0,10);
      $ar2 = substr($are,0,-20);
      $nj = substr($ar2,5-strlen($ar2));
      if($ct1!=$ctawal) {
        $this->dbmain->select('sum(aktrx_jum) as jumdbt');
        $this->dbmain->from('qmain_akun_trx');
        $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
        $this->dbmain->where('qmain_akun_jur.akjur_tgl <=',$ct1);
        if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
          $this->dbmain->where('aktrx_post','1');
        } else {
          $this->dbmain->where('aktrx_post','0');
        }
        $this->dbmain->where('aktrx_nomor',$nj);
        $this->dbmain->where('aktrx_jns','D');
        $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        $query = $this->dbmain->get();
        foreach($query->result() as $sald){
          return $sald->jumdbt;
        }
      } else {
        return 0;
      }
    }

    public function fillgrid4saldok($are = FALSE) {
      $ar1 = substr($are,-20);
      $ctawal = '2023-01-01';
      $ct1 = substr($ar1,0,10);
      $ar2 = substr($are,0,-20);
      $nj = substr($ar2,5-strlen($ar2));
      if($ct1!=$ctawal) {
        $this->dbmain->select('sum(aktrx_jum) as jumkrd');
        $this->dbmain->from('qmain_akun_trx');
        $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
        $this->dbmain->where('akjur_tgl<=',$ct1);
        if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
          $this->dbmain->where('aktrx_post','1');
        } else {
          $this->dbmain->where('aktrx_post','0');
        }
        $this->dbmain->where('aktrx_nomor',$nj);
        $this->dbmain->where('aktrx_jns','K');
        $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        $query = $this->dbmain->get();
        foreach($query->result() as $salk){
          return $salk->jumkrd;
        }
      } else {
        return 0;
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
//       exit;
    }

    public function _cekbuku($rtgl = FALSE){
      $ct1 = substr($rtgl,0,10);
      $ct2 = substr($rtgl,-10);
      $this->dbmain->select('aktrx_nomor,aktrx_nama');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
      $this->dbmain->where('LENGTH(aktrx_nama) >',5);
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $this->dbmain->group_by('aktrx_nomor');
      $this->dbmain->order_by('qmain_akun_jur.akjur_tgl,aktrx_nomor');
      $query = $this->dbmain->get();
      return $query->result();
      exit;
    }

    public function _isitbner1($range = FALSE,$nikpeg = FALSE){
      $ct1 = substr($range,0,10);
      $ct2 = substr($range,-10);
      $this->dbmain->select('aktrx_nomor,aktrx_nama');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
//      $this->dbmain->where('LENGTH(aktrx_nama) >',5);
$this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
if($this->dbcore1->routekey(get_cookie('seto'),'d')!='81'){
  $this->dbmain->where('aktrx_post','1');
} else {
  $this->dbmain->where('aktrx_post','0');
}
      $this->dbmain->group_by('aktrx_nomor');
      $this->dbmain->order_by('qmain_akun_jur.akjur_tgl,aktrx_nomor');
      $query = $this->dbmain->get();

      $jtrx = array();

      if ($query->result()) {
          foreach ($query->result() as $jt) {
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
            $this->dbmain->insert('qtemp_akun_neraca', array('temp1_noper'=>$jt->aktrx_nomor,'temp1_perk'=>$jt->aktrx_nama,'temp1_da'=>$ida,'temp1_ka'=>$ika,'temp1_db'=>$idb,'temp1_kb'=>$ikb,'temp1_dc'=>$idc,'temp1_kc'=>$ikc,'temp1_akses'=>$nikpeg,'temp1_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
          }
      } else {
          return FALSE;
      }
//      exit;
    }

    public function _carsumner1($partg = FALSE,$parnojur = FALSE){
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $this->dbmain->where('aktrx_nomor',$parnojur);
      $this->dbmain->where('aktrx_jns','D');
      $this->dbmain->where('aktrx_mark','0');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl <',$partg);
      $query = $this->dbmain->get();
      foreach($query->result() as $upsumner){
        return $upsumner->aktrx_jum;
      }
    }

    public function _carsumner2($partg = FALSE,$parnojur = FALSE){
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $this->dbmain->where('aktrx_nomor',$parnojur);
      $this->dbmain->where('aktrx_jns','K');
      $this->dbmain->where('aktrx_mark','0');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl <',$partg);
      $query = $this->dbmain->get();
      foreach($query->result() as $upsumner){
        return $upsumner->aktrx_jum;
      }
    }

    public function _cariupner($ncarup1 = FALSE){
      $this->dbmain->select('ka_saldoawal');
      $this->dbmain->from('qvar_akun_ka5');
      $this->dbmain->where('concat(ka_3,\'.\',ka_4,\'.\',ka_5)',$ncarup1);
      $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
      $query = $this->dbmain->get();
      foreach($query->result() as $upner1){
        return $upner1->ka_saldoawal;
      }
    }
    public function _cariupner1($ncarup2 = FALSE,$rgu1 = FALSE){
      $ct1 = substr($rgu1,0,10);
      $ct2 = substr($rgu1,-10);
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $this->dbmain->where('aktrx_nomor',$ncarup2);
      $this->dbmain->where('aktrx_jns','D');
      $this->dbmain->where('aktrx_mark','0');
      $query = $this->dbmain->get();
      foreach($query->result() as $upner2){
        return $upner2->aktrx_jum;
      }

    }

    public function _cariupner2($ncarup3 = FALSE,$rgu1 = FALSE){
      $ct1 = substr($rgu1,0,10);
      $ct2 = substr($rgu1,-10);
      $this->dbmain->select('sum(aktrx_jum) as aktrx_jum');
      $this->dbmain->from('qmain_akun_trx');
      $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
      $this->dbmain->where('qmain_akun_jur.akjur_tgl BETWEEN \''. $ct1.'\' + INTERVAL 1 DAY and \''. $ct2 .'\' + INTERVAL 1 DAY', NULL, FALSE);
      $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $this->dbmain->where('aktrx_nomor',$ncarup3);
      $this->dbmain->where('aktrx_jns','K');
      $this->dbmain->where('aktrx_mark','0');
      $query = $this->dbmain->get();
      foreach($query->result() as $upner3){
        return $upner3->aktrx_jum;
      }
    }
/*
UPDATE qtemp_akun_neraca SET temp1_dc=temp1_da+temp1_db-temp1_kb;
UPDATE qtemp_akun_neraca SET temp1_kc=temp1_ka+temp1_db-temp1_kb;
*/
    function _uptbner1() {
        $this->dbmain->select('qvar_akun_ka5.ka_saldoawal');
        $this->dbmain->where('concat(qvar_akun_ka5.ka_3,\'.\',qvar_akun_ka5.ka_4,\'.\',qvar_akun_ka5.ka_5)',$kd1);
        $this->dbmain->join('qvar_akun_ka3', 'qvar_akun_ka3.ka_3 = qvar_akun_jkp.akjkp_kdp','left');
        $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
        $query = $this->dbmain->get('qvar_akun_jkp');
        $jtrx = array();

        if ($query->result()) {
            foreach ($query->result() as $jt) {
                $jtrx[$jt->akjkp_kdp] = $jt->ka_nama;
            }
            return $jtrx;
        } else {
            return FALSE;
        }
    }



    public function csaldo(){
		$this->_get_datatables_query2();
		if($_POST['length'] != -1)
		$this->dbmain->limit($_POST['length'], $_POST['start']);

		$query = $this->dbmain->get();
		return $query->result();

        exit;
    }

    public function cvariabel(){
		$this->_get_datatables_query3();
		if($_POST['length'] != -1)
		$this->dbmain->limit($_POST['length'], $_POST['start']);

		$query = $this->dbmain->get();
		return $query->result();

        exit;
    }


//---------------------------------------dataTables-----END
	public function trx_hapus($id)
	{
		$this->dbmain->where('aktrx_urut', $id);
		$this->dbmain->delete('qmain_akun_trx');
	}

    function carikodejur(){
        $this->dbmain->select('left(akjur_nomor,3) as kode,count(akjur_nomor) as jum');
        $this->dbmain->from('qmain_akun_jur');
        $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        $this->dbmain->group_by('left(akjur_nomor,3)');
        $this->dbmain->order_by('left(akjur_nomor,3)');
        $query = $this->dbmain->get();
        return $query->result_array();
        exit;
    }

    function jumhit($jur){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      if($cekkel != '00'){
        $this->dbmain->where(array('aktrx_nojur'=>$jur,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
      } else {
        $this->dbmain->where(array('aktrx_nojur'=>$jur));
      }
		$query1 = $this->dbmain->get($this->table2.($cekkel == '00'?'_post':''));
        $nilai1 = $query1->num_rows();

		$nilai = $nilai1;
        return $nilai;
        exit;
    }

    function jumnil($jur){
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
        $this->dbmain->select_sum('aktrx_jum');
        if($cekkel != '00'){
          $this->dbmain->where(array('aktrx_nojur'=>$jur,'aktrx_jns'=>'D','akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
        } else {
          $this->dbmain->where(array('aktrx_nojur'=>$jur,'aktrx_jns'=>'D'));
        }
		$query1 = $this->dbmain->get($this->table2.($cekkel == '00'?'_post':''));
        $nilai1 = $query1->row_array();
        $this->dbmain->select_sum('aktrx_jum');
        if($cekkel != '00'){
          $this->dbmain->where(array('aktrx_nojur'=>$jur,'aktrx_jns'=>'K','akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
        } else {
          $this->dbmain->where(array('aktrx_nojur'=>$jur,'aktrx_jns'=>'K'));
        }
		$query2 = $this->dbmain->get($this->table2.($cekkel == '00'?'_post':''));
        $nilai2 = $query2->row_array();

		$nilai = $nilai1['aktrx_jum']-$nilai2['aktrx_jum'];
        return $nilai;
        exit;
    }


    function tambah_trx($data,$are) {
        $ar = substr($are,0,5);
        $mk = substr($are,-1);

        if($ar=='area2'){
            return $this->dbmain->insert('qmain_akun_jur', $data);
        } else {
            if($mk == 'n'){
                return $this->dbmain->insert('qmain_akun_trx', $data);
            } else {
        $this->dbmain->query('SET foreign_key_checks=0');
                $this->dbmain->where('aktrx_urut', $data['aktrx_urut']);
        $this->dbmain->update('qmain_akun_trx', $data);
        $this->dbmain->query('SET foreign_key_checks=1');

            }
        }
        return FALSE;
        exit;
    }

    function update_ka5($data,$are) {
        $this->dbmain->query('SET foreign_key_checks=0');
        $this->dbmain->where(array('ka_3'=>$data['ka_3'],'ka_4'=>$data['ka_4'],'ka_5'=>$data['ka_5'],'LEFT(ka_5,2)'=>$this->dbcore1->routekey(get_cookie('simakses'),'d')));
        $this->dbmain->update('qvar_akun_ka5', $data);
        $this->dbmain->query('SET foreign_key_checks=1');

        exit;
    }

    function isi_variabel($data,$ketvar) {
      if($ketvar=='i'){
        return $this->dbmain->insert('qvar_tools', $data);
      } else {
        $this->dbmain->where(array('qt_var2'=>$data['qt_var2']));
        $this->dbmain->update('qvar_tools', $data);
      }
        exit;
    }

    function isi_jkp($data) {
        return $this->dbmain->insert('qvar_akun_jkp', $data);
        exit;
    }

    function isi_perkiraan($data,$ketvar,$jakun) {
      if($ketvar=='i'){
        switch ($jakun) {
          case '01':
          return $this->dbmain->insert('qvar_akun_ka1', $data);
          break;

          case '02':
          return $this->dbmain->insert('qvar_akun_ka2', $data);
          break;

          case '03':
          return $this->dbmain->insert('qvar_akun_ka3', $data);
          break;

          case '04':
          return $this->dbmain->insert('qvar_akun_ka4', $data);
          break;

          default:
          return $this->dbmain->insert('qvar_akun_ka5', $data);
          break;
        }
      } /* else {
        $this->dbmain->where(array('qt_var2'=>$data['qt_var2']));
        $this->dbmain->update('qvar_tools', $data);
      } */
        exit;
    }


    function carijur($id) {
        $this->dbmain->from('qmain_akun_jur');
        $this->dbmain->where('akjur_nomor',$id);
        $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        $query = $this->dbmain->get();
        $crjur = $query->num_rows();
        if($crjur >= 1){
            return $query->row_array();
        } else {
            return false;
        }
    }

    function caribag($id) {
      $this->dbmain->select('varnama');
        $this->dbmain->from('qvar_bagian');
        $this->dbmain->where('varid',$id);
        $query = $this->dbmain->get();
        $crjur = $query->num_rows();
        if($crjur >= 1){
            return $query->row_array();
        } else {
            return false;
        }
    }

    function get_ka5($filterData = FALSE,$param1 = FALSE,$param2 = FALSE){
        $this->dbmain->select('*');
        $this->dbmain->from('qvar_akun_ka5');
        if($filterData){
          $this->dbmain->like('ka_nama',$filterData);
        }
        if($param2){
          $this->dbmain->where('ka_3',$param2);
        }
        $this->dbmain->where('LEFT(ka_5,2)',$this->dbcore1->routekey(get_cookie('simakses'),'d'));
        $this->dbmain->order_by('ka_3','asc');
        $this->dbmain->order_by('ka_5','asc');
        $query = $this->dbmain->get();
        return $query->result_array();
      }

    function get_vka1($ka = FALSE) {
        $this->dbmain->select('*');
        $this->dbmain->from('qvar_akun_ka1');
        if($ka!='list'){
          $this->dbmain->where(array('ka_1'=>$ka));
        }
        $query = $this->dbmain->get();
        if($ka!='list'){
          $jtrx = $query->row_array();
        } else {
          $jtrx = $query->result();
        }
        if($jtrx){
          return $jtrx;
        } else {
          return FALSE;
        }
    }

    function get_vka2($ka = FALSE) {
        $this->dbmain->select('*');
        $this->dbmain->from('qvar_akun_ka2');
        if($ka!='list'){
          $this->dbmain->where(array('ka_1'=>substr($ka,0,1).'00','ka_2'=>$ka));
        }
        $query = $this->dbmain->get();
        if($ka!='list'){
          $jtrx = $query->row_array();
        } else {
          $jtrx = $query->result();
        }
        if($jtrx){
          return $jtrx;
        } else {
          return FALSE;
        }
    }

    function get_vka3($ka = FALSE) {
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_akun_ka3');
      if($ka!='list'){
        $this->dbmain->where(array('ka_1'=>substr($ka,0,1).'00','ka_2'=>substr($ka,0,2).'0','ka_3'=>$ka));
      }
      $query = $this->dbmain->get();
      if($ka!='list'){
        $jtrx = $query->row_array();
      } else {
        $jtrx = $query->result();
      }
      if($jtrx){
        return $jtrx;
      } else {
        return FALSE;
      }
    }

    function get_vka4($ka = FALSE) {
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_akun_ka5');
      if($ka!='list'){
        $this->dbmain->where(array('ka_1'=>substr($ka,0,1).'00','ka_2'=>substr($ka,0,2).'0','ka_3'=>substr($ka,0,3),'ka_4'=>substr($ka,4,2),'ka_5'=>substr($ka,-5)));
      }
      $query = $this->dbmain->get();
      if($ka!='list'){
        $jtrx = $query->row_array();
      } else {
        $jtrx = $query->result();
      }
      if($jtrx){
        return $jtrx;
      } else {
        return FALSE;
      }
    }

    function get_vka4a() {
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_akun_ka4');
      $query = $this->dbmain->get();
        $jtrx = $query->result();
      if($jtrx){
        return $jtrx;
      } else {
        return FALSE;
      }
    }

    function get_vjur() {
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_akun_jur');
      $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
//      $this->dbmain->where(array('akjur_kode'=>$ka));
      $query = $this->dbmain->get();
      $jtrx = array();

      if ($query->result()) {
          foreach ($query->result() as $jt) {
              if($jt->akjur_kode){
                $jtrx[$jt->akjur_kode] = '['.$jt->akjur_kode.'] '.$jt->akjur_nama;
              }
          }
          return $jtrx;
      } else {
          return FALSE;
      }
    }

    function get_lastjur($kajur) {
      $this->dbmain->select('MAX(akjur_nomor) as lastjur');
      $this->dbmain->from('qmain_akun_jur');
      $this->dbmain->where(array('LEFT(akjur_nomor,6)'=>substr($kajur,0,6),'YEAR(akjur_tgl)'=>substr($kajur,-4),'MONTH(akjur_tgl)'=>substr($kajur,4,2)));
      $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
      $query = $this->dbmain->get();
      if ($query->num_rows()>0) {
        return $query->row_array();
      } else {
          return FALSE;
      }
    }

    function get_ka3($kd1 = FALSE) {
        $this->dbmain->select('akjkp_kdp,ka_nama');
        $this->dbmain->from('qvar_akun_jkp');
            $this->dbmain->where(array('akjkp_kdj'=>substr($kd1,0,2),'akjkp_tr'=>substr($kd1,-1)));
        $this->dbmain->join('qvar_akun_ka3', 'qvar_akun_ka3.ka_3 = qvar_akun_jkp.akjkp_kdp','left');
        $this->dbmain->order_by('akjkp_kdp','asc');
        $query = $this->dbmain->get();
        $jtrx = array();

        if ($query->result()) {
            foreach ($query->result() as $jt) {
                if($jt->ka_nama){
                  $jtrx[$jt->akjkp_kdp] = '['.$jt->akjkp_kdp.'] '.$jt->ka_nama;
                }
            }
            return $jtrx;
        } else {
            return FALSE;
        }
    }



    public function get_per($per = false) {
        $ka3 = substr($per,0,3);
        $ka4 = substr($per,4,2);
        $ka5 = substr($per,-5);
        $this->dbmain->select('ka_nama');
        $this->dbmain->where(array('ka_3'=>$ka3,'ka_4'=>$ka4,'ka_5'=>$ka5,'LEFT(ka_5,2)'=>$this->dbcore1->routekey(get_cookie('simakses'),'d')));
        $query = $this->dbmain->get('qvar_akun_ka5');
        if($query->num_rows() >= 1){
            $nm = $query->row_array();
            return $nm;
        } else {
            return $this->dbmain->last_query();
        }
        exit;
    }

    function get_pers($per = false) {
        $ka3 = substr($per,0,3);
        $ka4 = substr($per,4,2);
        $ka5 = substr($per,-5);
        $this->dbmain->select('ka_saldoawal');
        $this->dbmain->where(array('ka_3'=>$ka3,'ka_4'=>$ka4,'ka_5'=>$ka5,'LEFT(ka_5,2)'=>$this->dbcore1->routekey(get_cookie('simakses'),'d')));
        $query = $this->dbmain->get('qvar_akun_ka5');
        if($query->result()){
            $nm = $query->row_array();
            return $nm;
        } else {
          return false;
//            return $this->dbmain->last_query();
        }
//        exit;
    }


//iki.....
    function get_trx($tr = false) {
        $tr1 = substr($tr,0,12);
        $tr2 = substr($tr,12-strlen($tr));
        $this->dbmain->select('*');
        $this->dbmain->from('qmain_akun_jur');
        $this->dbmain->where(array('akjur_nomor'=>$tr2,'aktrx_nomor'=>$tr1));
        $this->dbmain->join('qmain_akun_trx','qmain_akun_trx.aktrx_nojur=qmain_akun_jur.akjur_nomor','left');
        $this->dbmain->where('qmain_akun_jur.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        $query = $this->dbmain->get();
        if($query->num_rows() >= 1){
            $dtrx = $query->row_array();
            return $dtrx;
        } else {
            return $this->dbmain->last_query();
        }
        exit;
    }

    function get_kortrx($tr = false) {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
        $this->dbmain->select('*');
        $this->dbmain->from('qmain_akun_trx'.($cekkel == '00'?'_post':''));
          if($cekkel != '00'){
            $this->dbmain->where(array('aktrx_nojur'=>$tr,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
          } else {
            $this->dbmain->where(array('aktrx_nojur'=>$tr));
          }
        $query = $this->dbmain->get();
        if($query->num_rows() >= 1){
            $dtrx = $query->result_array();
            return $dtrx;
        } else {
            return $this->dbmain->last_query();
        }
        exit;
    }

    function carinojur($nojur = FALSE) {
      $this->dbmain->select('*');
      $this->dbmain->from('qmain_akun_jur');
      $this->dbmain->where(array('akjur_nomor'=>$nojur,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
      $query = $this->dbmain->get();
//        $query = $this->dbmain->get();
        if($query->num_rows() >= 1){
            return $query->row_array();
        } else {
            return false;
        }
        exit;
    }

    function get_kortrx2($tr = false,$jur = false) {
        $this->dbmain->select('*');
        $this->dbmain->from('qmain_akun_trx');
        $this->dbmain->where(array('aktrx_nomor'=>$tr,'aktrx_nojur'=>$jur,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
        $query = $this->dbmain->get();
        if($query->num_rows() >= 1){
            $dtrx = $query->result_array();
            return $dtrx;
        } else {
            return $this->dbmain->last_query();
        }
        exit;
    }

    function get_korjur($tr = false) {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
        $this->dbmain->select('*');
        $this->dbmain->from('qmain_akun_jur'.($cekkel == '00'?'_post':''));
        $this->dbmain->where(array('akjur_nomor'=>$tr));
        if($cekkel != '00'){
          $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        } else {
          $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('precor'),'d'));
        }
        $query = $this->dbmain->get();
        if($query->num_rows() >= 1){
            $djur = $query->result_array();
            return $djur;
        } else {
            return false;
        }
        exit;
    }

    function get_lastkor() {
      $cekusr = $this->dbcore1->routekey(get_cookie('simcek1'),'d');
      $cekusrak = substr($cekusr,5,2);
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $dt = new DateTime();
      $cartg = $dt->format('Y-m-d');
      $this->dbmain->select('RIGHT(akjur_nomor,3) as nmrjur');
           $this->dbmain->from('qmain_akun_jur'.($cekkel == '00'?'_post':''));
           $this->dbmain->where(array('LEFT(akjur_nomor,1)'=>'C','akjur_tgl'=>$cartg));
          if($cekkel != '00'){
            $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
          } else {
            $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('precor'),'d'));
          }
           $this->dbmain->order_by('akjur_nomor','desc');
           $this->dbmain->limit(1);
           $query = $this->dbmain->get();
               if($query -> num_rows() >= 1){
                   return $query->row_array();
               }
               else {
                   return false;
               }
    }

    public function jur_koreksi($koreksian = FALSE,$njur1 = FALSE) {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      if($koreksian){
        $this->dbmain->query('SET foreign_key_checks=0');
        $this->dbmain->insert('qmain_akun_jur'.($cekkel == '00'?'_post':''),$koreksian);
        $this->dbmain->query('SET foreign_key_checks=1');
      }
      if($njur1){
        $this->dbmain->query('SET foreign_key_checks=0');
        $this->dbmain->where('akjur_nomor', $njur1);
        if($cekkel != '00'){
          $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
        } else {
          $this->dbmain->where('akjur_kopar',$this->dbcore1->routekey(get_cookie('precor'),'d'));
        }
        $this->dbmain->update('qmain_akun_jur'.($cekkel == '00'?'_post':''), array('akjur_sts'=>'1'));
        $this->dbmain->query('SET foreign_key_checks=1');
      }
//      return false;
    }

    public function batch_posting($param = FALSE,$parnomor = FALSE){
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->select('akjur_nomor');
      $this->dbmain->from('qmain_akun_jur');
      $this->dbmain->where(array('akjur_sts'=>'0','akjur_post'=>'0','year(akjur_tgl)'=>substr($param,0,4),'month(akjur_tgl)'=>substr($param,4-strlen($param))));
      $qry1 = $this->dbmain->get()->result();
      $dtvar1 = array();
      $chitg = 0;
      $dhit = 0;
      foreach ($qry1 as $qu1) {
        $this->dbmain->select('aktrx_nojur,sum(if(aktrx_jns="D",aktrx_jum,-aktrx_jum)) as aktrx_jum');
        $this->dbmain->from('qmain_akun_trx');
        $this->dbmain->where(array('aktrx_nojur'=>$qu1->akjur_nomor,'aktrx_post'=>'0','aktrx_mark'=>'0'));
        $this->dbmain->group_by('aktrx_nojur');
        $qry1a = $this->dbmain->get()->row_array();

        $chitg = (int)$qry1a['aktrx_jum'];

            if($chitg == 0){
              $this->trx_posting($qu1->akjur_nomor,$cekkop);
              $dtvar1[] = $qu1->akjur_nomor;
            }
/*
        $this->dbmain->select('aktrx_nojur,aktrx_jum');
        $this->dbmain->from('qmain_akun_trx');
        $this->dbmain->where(array('aktrx_nojur'=>$qu1->akjur_nomor,'aktrx_jns'=>'K','aktrx_post'=>'0','aktrx_mark'=>'0'));
        $qry1b = $this->dbmain->get()->row_array();
*/
      }

      return $dtvar1;

    }

    public function trx_posting($jurnomor = FALSE,$parnomor = FALSE) {
      $this->dbmain->query('SET foreign_key_checks=0');
      if(substr($parnomor,-2) != '00'){
        $this->dbmain->select('aktrx_nomor,aktrx_nojur,aktrx_nama,aktrx_jns,aktrx_ket,aktrx_jum,aktrx_akses,akjur_kopar');
        $this->dbmain->from('qmain_akun_trx');
        $this->dbmain->where(array('aktrx_nojur'=> $jurnomor,'akjur_kopar'=>$parnomor));
        $query1 = $this->dbmain->get()->result();
        foreach ($query1 as $qtrx1) {
          $ins1 = $this->dbmain->insert('qmain_akun_trx_post',$qtrx1);
        }

        if($ins1){
          $this->dbmain->select('akjur_nomor,akjur_jns,akjur_tgl,akjur_ket,akjur_akses,akjur_kopar');
          $this->dbmain->from('qmain_akun_jur');
          $this->dbmain->where(array('akjur_nomor'=> $jurnomor,'akjur_kopar'=>$parnomor));
          $query2 = $this->dbmain->get();
          $ins2 = $this->dbmain->insert('qmain_akun_jur_post',$query2->row_array());

          if($ins2){
            $this->dbmain->where(array('aktrx_nojur'=> $jurnomor,'akjur_kopar'=>$parnomor));
            $this->dbmain->update('qmain_akun_trx', array('aktrx_post'=>1));
            $this->dbmain->where(array('akjur_nomor'=> $jurnomor,'akjur_kopar'=>$parnomor));
            $this->dbmain->update('qmain_akun_jur', array('akjur_post'=>1));
          }
        }
      } else {
        $sql1 = "UPDATE qmain_akun_trx_post SET aktrx_post=1,aktrx_nomor=concat(LEFT(aktrx_nomor,7),'00',RIGHT(aktrx_nomor,3)) WHERE aktrx_nojur='".$jurnomor."' AND akjur_kopar='".$this->dbcore1->routekey(get_cookie('precor'),'d')."'";
        $this->dbmain->query($sql1);
        $this->dbmain->where(array('akjur_nomor'=> $jurnomor,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('precor'),'d')));
        $this->dbmain->update('qmain_akun_jur_post', array('akjur_post'=>1));
      }

      $this->dbmain->query('SET foreign_key_checks=1');
    }

    public function trx_koreksi($koreksian = FALSE,$jurnomor = FALSE,$kornomor = FALSE,$korupdtx = FALSE) {
      $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
      $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
      $this->dbmain->query('SET foreign_key_checks=0');
      $this->dbmain->insert('qmain_akun_trx'.($cekkel == '00'?'_post':''),$koreksian);
        if($cekkel != '00'){
          $this->dbmain->where(array('aktrx_nomor'=> $kornomor,'aktrx_nojur'=> $jurnomor,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
        } else {
          $this->dbmain->where(array('aktrx_nomor'=> $kornomor,'aktrx_nojur'=> $jurnomor,'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('precor'),'d')));
        }
      $this->dbmain->update('qmain_akun_trx'.($cekkel == '00'?'_post':''), $korupdtx);
      $this->dbmain->query('SET foreign_key_checks=1');
//      return false;

    }

    public function trx_koreksi2($koreksian = FALSE,$kordata = FALSE,$kornomor = FALSE) {
      $this->dbmain->query('SET foreign_key_checks=0');
      $this->dbmain->insert('qmain_akun_trx',$koreksian);
      $this->dbmain->where(array('aktrx_nomor'=> substr($kornomor,0,12),'aktrx_nojur'=>substr($kornomor,12-strlen($kornomor)),'akjur_kopar'=>$this->dbcore1->routekey(get_cookie('simkop'),'d')));
      $this->dbmain->update('qmain_akun_trx', $kordata);
      $this->dbmain->query('SET foreign_key_checks=1');
      return false;

    }

    function get_info($area = false) {
//      $area = '28-04-2017paktrx_jum';
      if(strlen($area)>16){
        $nik = substr($area,0,10);
        $kin = substr($area,10-strlen($area));
        $kinx = substr($kin,0,1);
        $ktg = date("Y-m-d",strtotime($nik));
      } else {
        $nik = substr($area,0,4);
        $kin = substr($area,4-strlen($area));
        $kinx = substr($kin,0,1);
        $ktg = $nik;
      }

        switch($kinx){
          case 'p':
          case 'q':
          $kin1 = $kinx=='p'?'D':'K';
          $kin2 = 'sum('.substr($kin,1-strlen($kin)).') as '.substr($kin,1-strlen($kin));
          $this->dbmain->select($kin2);
          $this->dbmain->from($this->table2);
          $this->dbmain->join('qmain_akun_jur','qmain_akun_jur.akjur_nomor=qmain_akun_trx.aktrx_nojur','left');
          $this->dbmain->where('qmain_akun_trx.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
          $this->dbmain->where(array('aktrx_jns'=>$kin1,'aktrx_mark<>'=>1));
          $this->dbmain->group_by(array('MONTH(akjur_tgl)','YEAR(akjur_tgl)'));
          $query = $this->dbmain->get();
          if($query->num_rows() >= 1){
              $dtrx = $query->result_array();
              return $dtrx;
          } else {
              return $this->dbmain->last_query();
          }
          break;

          case 'x':
          $kin2 = 'count('.substr($kin,1-strlen($kin)).') as '.substr($kin,1-strlen($kin));
//            $this->dbmain->where(array('aktrx_akses'=>$nik,'left(akjur_up,10)'=>$ktg));
$this->dbmain->select($kin2);
$this->dbmain->from($this->table1);
$this->dbmain->join('qmain_akun_trx','qmain_akun_trx.aktrx_nojur=qmain_akun_jur.akjur_nomor','left');
$this->dbmain->where('qmain_akun_jur.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
$this->dbmain->where(array('akjur_tgl'=>$ktg));
$query = $this->dbmain->get();
if($query->num_rows() >= 1){
    $dtrx = $query->row_array();
    return $dtrx;
} else {
    return $this->dbmain->last_query();
}
          break;

          default:
          $kin1 = $kinx=='p'?'D':'K';
          $kin2 = 'sum('.substr($kin,1-strlen($kin)).') as '.substr($kin,1-strlen($kin));
//            $this->dbmain->where(array('aktrx_jns'=>$kin1,'aktrx_akses'=>$nik,'left(akjur_up,10)'=>$ktg));
$this->dbmain->select($kin2);
$this->dbmain->from($this->table1);
$this->dbmain->join('qmain_akun_trx','qmain_akun_trx.aktrx_nojur=qmain_akun_jur.akjur_nomor','left');
$this->dbmain->where('qmain_akun_jur.akjur_kopar',$this->dbcore1->routekey(get_cookie('simkop'),'d'));
$this->dbmain->where(array('aktrx_jns'=>$kin1,'akjur_tgl'=>$ktg,'aktrx_mark<>'=>1));
$query = $this->dbmain->get();
if($query->num_rows() >= 1){
    $dtrx = $query->row_array();
    return $dtrx;
} else {
    return $this->dbmain->last_query();
}
          break;

        }
        exit;
    }

    //--------------------------------


}
