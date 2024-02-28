<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbnilai extends CI_Model {

    function __construct(){
    parent::__construct();
    $this->load->helper('url','form','parse');
    $this->dbmain = $this->load->database('default',TRUE);
    }

    function gindikator($param1 = FALSE){
      $this->dbmain->select('*');
      $this->dbmain->from('qvar_nilai_b');
      $query = $this->dbmain->get();
      $setarr = $query->result();
      return $setarr;
    }

    function gisi($param1 = FALSE){
        $this->dbmain->select('sum(qnil_nilai) as dettot');
        $this->dbmain->from('qmain_nilai');
        $this->dbmain->where('qnil_kodereg',$param1);
        $this->dbmain->group_by('left(qnil_kode,3)');
        $qry2 = $this->dbmain->get();
        $hqry2 = $qry2->result();
//        $arrisi[] = (int)$hqry2['dettot'];

      return $hqry2;
    }

    public function getregio($filterData = FALSE){
        $this->dbmain->select('*');

      $this->dbmain->from('qvar_umum');
      $this->dbmain->where('left(varid,1)','R');
      $query = $this->dbmain->get();
      return $query->result_array();
    }

    public function getparoki($filterData = FALSE,$prm1 = FALSE){
        $this->dbmain->select('*');

      $this->dbmain->from('qvar_bagian');
      $this->dbmain->where('vartggjwb',$prm1);
      $this->dbmain->like('varnama',$filterData);
      $query = $this->dbmain->get();
      return $query->result_array();
    }


}
