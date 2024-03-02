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
      $coknil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnil'),'d');
      $this->dbmain->select('*');
      if($coknil == 'global' || $coknil == 'regio1'){
        $this->dbmain->from('qvar_nilai_b');
      } else {
        $this->dbmain->from('qvar_nilai_c');
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
      $coknil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnil'),'d');
      $cokdnil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnild1'),'d');
      if($coknil == 'paroki'){
        $this->dbmain->select('sum(qnil_nilai) as dettot');
      } else {
        $this->dbmain->select('avg(qnil_nilai) as dettot');
      }
      $this->dbmain->from('qmain_nilai');
      if($param2){
        if($coknil == 'regio'){
          $this->dbmain->where(array('qnil_kodereg'=>$param1,'left(qnil_kode,3)'=>$param2));
          $this->dbmain->group_by('left(qnil_kode,5)');
        } else {
          if($cokdnil){
            $this->dbmain->where(array('qnil_kodepar'=>$param1,'left(qnil_kode,3)'=>$param2));
            $this->dbmain->group_by('left(qnil_kode,5)');
          } else {
            $this->dbmain->where(array('qnil_kodepar'=>$param1,'left(qnil_kode,5)'=>$param2));
          }
        }
      } else {
        if($cokdnil){
          $this->dbmain->where(array('qnil_kodereg'=>$cokdnil));
        }
        $this->dbmain->group_by('left(qnil_kode,3)');
      }
      $qry2 = $this->dbmain->get();
      $hqry2 = $qry2->result();
      return $hqry2;
    }

    public function getregio($filterData = FALSE,$prm1 = FALSE){
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_umum');
      $this->dbmain->where('left(varid,1)','R');
      if($prm1){
        $this->dbmain->like('varnama',$filterData);
      }
      $query = $this->dbmain->get();
      return $query->result_array();
    }


    public function getparoki($filterData = FALSE,$prm1 = FALSE){
      $cokdnil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnild1'),'d');
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_bagian');
      if($cokdnil){
        $this->dbmain->where('vartggjwb',$cokdnil);
      }
      if($prm1){
        $this->dbmain->like('varnama',$filterData);
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

  }
