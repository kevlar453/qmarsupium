<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbnilai extends CI_Model {

    function __construct(){
    parent::__construct();
    $this->load->helper('url','form','parse');
    $this->dbmain = $this->load->database('default',TRUE);
    }

    function gkode($param1 = FALSE){
      $this->dbmain->select('*');
        $this->dbmain->from('qvar_nilai_'.$param1);
      $query = $this->dbmain->get();
      $setarr = $query->result();
      return $setarr;
    }


    function gindikator($param1 = FALSE){
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_nilai_b');
      if($param1){
        $this->dbmain->where('qnilb_kodeb',$param1);
      }

      $query = $this->dbmain->get();
      $setarr = $query->result();
      return $setarr;
    }

    function gindikator2($param1 = FALSE){
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_nilai_c');
      if($param1){
        $this->dbmain->where('qnilc_kodeb',$param1);
      }

      $query = $this->dbmain->get();
      $setarr = $query->result();
      return $setarr;
    }


function getparnildet($param1 = FALSE,$param2 = FALSE){
  $this->dbmain->select('*');
  $this->dbmain->from('qmain_nilai');
  $this->dbmain->where(array('qnil_kodepar'=>$param1,'qnil_periode'=>$param2));
  $qry2 = $this->dbmain->get();
  $hqry2 = $qry2->result();
  return $hqry2;
}

    function gisi($param1 = FALSE,$param2 = FALSE){
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
//      if($coknil == 'paroki'){
//        $this->dbmain->select('sum(qnil_nilai) as dettot');
//      } else {
        $this->dbmain->select('avg(qnil_nilai) as dettot,qnil_kode,qvar_umum.varnama as nmreg,qvar_bagian.varnama as nmpar,qnil_periode as periode');
//      }
      $this->dbmain->from('qmain_nilai');
      $this->dbmain->join('qvar_umum','qvar_umum.varid=qmain_nilai.qnil_kodereg','left');
      $this->dbmain->join('qvar_bagian','qvar_bagian.varid=qmain_nilai.qnil_kodepar','left');
      if($param2){
        if($coknil == 'regio'){
          $this->dbmain->where(array('qnil_kodereg'=>$param1,'left(qnil_kode,3)'=>$param2));
          $this->dbmain->group_by('left(qnil_kode,5)');
        } else {
          if(strlen($cokdnil) == 3){
            $this->dbmain->where(array('qnil_kodepar'=>$param1));
            $this->dbmain->group_by('left(qnil_kode,5)');
          } else if(strlen($cokdnil) == 4){
            $this->dbmain->where(array('qnil_kodepar'=>$param1,'left(qnil_kode,5)'=>$param2));
            $this->dbmain->group_by('left(qnil_kode,5)');
          } else {
            $this->dbmain->where(array('qnil_kodepar'=>$param1));
            $this->dbmain->group_by('left(qnil_kode,3)');
          }
        }
      } else {
        /*
        if($cokdnil != '' && $coknil != 'paroki1'){
          $this->dbmain->where(array('qnil_kodereg'=>$cokdnil));
        } else if($coknil == 'paroki1'){
          $this->dbmain->where(array('qnil_kodepar'=>$cokdnil));
        }
        */
        if($cokdnil != ''){
          if($coknil == 'detregio'){
            $this->dbmain->where(array('qnil_kodereg'=>$param1));
            $this->dbmain->group_by('left(qnil_kode,3)');
          } else {
            $this->dbmain->where(array('qnil_kodepar'=>$param1));
            $this->dbmain->group_by('left(qnil_kode,3)');
          }
        } else {
          $this->dbmain->where(array('qnil_kodereg'=>$param1));
          $this->dbmain->group_by('left(qnil_kode,3)');
        }
      }
      $qry2 = $this->dbmain->get();
      $hqry2 = $qry2->result();
      return $hqry2;
    }

    function gisi2($param1 = FALSE,$param2 = FALSE){
      $cokper = $this->session->userdata('periode');
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
      $this->dbmain->select('avg(qnil_nilai) as dettot,qnil_kode,qvar_umum.varnama as nmreg,qvar_bagian.varnama as nmpar,qnil_periode as periode');
      $this->dbmain->from('qmain_nilai');
      $this->dbmain->join('qvar_umum','qvar_umum.varid=qmain_nilai.qnil_kodereg','left');
      $this->dbmain->join('qvar_bagian','qvar_bagian.varid=qmain_nilai.qnil_kodepar','left');
      if($cokper != ''){
        $this->dbmain->where(array('qnil_periode'=>$cokper));
      }
      if($param2){
        $this->dbmain->where(array('qnil_kodepar'=>$param1,'left(qnil_kode,3)'=>$param2));
        $this->dbmain->group_by('left(qnil_kode,5)');
      } else {
        /*
        if($cokdnil != '' && $coknil != 'paroki1'){
          $this->dbmain->where(array('qnil_kodereg'=>$cokdnil));
        } else if($coknil == 'paroki1'){
          $this->dbmain->where(array('qnil_kodepar'=>$cokdnil));
        }
        */
        if($cokdnil != ''){
        }
        $this->dbmain->where(array('qnil_kodereg'=>$param1));
        $this->dbmain->group_by('left(qnil_kode,3)');
      }
      $qry2 = $this->dbmain->get();
      $hqry2 = $qry2->result();
      return $hqry2;
    }

    function gisi3($param1 = FALSE,$param2 = FALSE){
      $this->dbmain->select('avg(qnil_nilai) as dettot,qnil_kode,qvar_umum.varnama as nmreg,qvar_bagian.varnama as nmpar,qnil_periode as periode');
      $this->dbmain->from('qmain_nilai');
      $this->dbmain->join('qvar_umum','qvar_umum.varid=qmain_nilai.qnil_kodereg','left');
      $this->dbmain->join('qvar_bagian','qvar_bagian.varid=qmain_nilai.qnil_kodepar','left');
      if($param1){
        $this->dbmain->where(array('qnil_periode'=>$param1));
      }
      if($param2){
        if(strlen($param2)==3){
          $this->dbmain->where(array('qnil_kodereg'=>$param2));
          $this->dbmain->group_by('qnil_periode');
        } else {
          $this->dbmain->where(array('qnil_kodepar'=>$param2));
          $this->dbmain->group_by('qnil_kodepar');
        }
      } else {
        $this->dbmain->group_by('qnil_kodereg');
      }
      $qry2 = $this->dbmain->get();
      $hqry2 = $qry2->result();
      return $hqry2;
    }


    function getperiode(){
      $this->dbmain->select('qnil_periode');
      $this->dbmain->from('qmain_nilai');
      $this->dbmain->group_by('qnil_periode');
      $qry = $this->dbmain->get();
      return $qry->result();
    }


    public function getregio($filterData = FALSE,$prm1 = FALSE){
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_umum');
      $this->dbmain->where(array('left(varid,1)'=>'R','right(varid,2)<>'=>'00'));
      if(strlen($cokdnil)==3){
        $this->dbmain->where(array('varid'=>$cokdnil));
      }
      if($prm1){
        $this->dbmain->like('varnama',$filterData);
      }
      $query = $this->dbmain->get();
      return $query->result_array();
    }


    public function getparoki($filterData = FALSE,$prm1 = FALSE){
      $coknil = $this->session->userdata('pilnil');
      $cokdnil = $this->session->userdata('pilnild1');
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_bagian');
      if($cokdnil != ''){
        if($coknil == 'detregio'){
          $this->dbmain->where('vartggjwb',$cokdnil);
        } else {
          $this->dbmain->where('varid',$cokdnil);
        }
      }
      if($filterData != ''){
        if($prm1 && $prm1 == 'paroki'){
          $this->dbmain->like('varid',$filterData);
        } else {
          $this->dbmain->like('varnama',$filterData);
        }
      }
      $query = $this->dbmain->get();
      return $query->result_array();
    }

    public function getparnil($filterData = FALSE,$prm1 = FALSE){
      $this->dbmain->select('*');
      $this->dbmain->from('qmain_nilai');
      if($prm1 == 'periode'){
        $this->dbmain->group_by('qnil_periode');
      }
      $query = $this->dbmain->get();
      return $query->result_array();
    }

    function tambah_nil($data) {
      return $this->dbmain->insert('qmain_nilai', $data);
      exit;
    }

  }
