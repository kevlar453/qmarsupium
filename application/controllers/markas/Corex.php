<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corex extends CI_Controller {


  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->helper('url','form');
    $this->dbmain = $this->load->database('default',TRUE);
  }

    function index() {
        $idpeg = $this->session->userdata('pgpid');
        $akpeg = $this->session->userdata('pgakses');
        $vtitle = 'Isi Dokumen';
        if($idpeg!='') {
          $thn = date("Y");
          $hrni = date("Y-m-d");
          $data = array(
            'mnovr' => $this->dbcore1->qmenu(),
            'idpeg' => $idpeg,
            'qtitle' => $vtitle,
            'mod' => 'q'
          );
            $this->load->view('backoff/qvault',$data);
        } else {
            $this->load->view('frontoff/login');
        }
    }

    function goread($doku = FALSE,$dokjud = FALSE) {
      $idpeg = $this->session->userdata('pgpid');
      $akpeg = $this->session->userdata('pgakses');
      $vtitle = 'Baca Dokumen';
      if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
        $hcinet=$this->dbcore1->cinet();
        if($hcinet){
          $this->dbcore1->routedqt(date("d/m/Y H:i").' '.$this->dbcore1->caripeg($idpeg)['pgpnama'].' buka Dokumen '.strip_tags($this->dbcore1->routekey($dokjud,'d')));
        }
      }
      if($idpeg!='') {
        $thn = date("Y");
        $hrni = date("Y-m-d");
        $data = array(
          'mnovr' => $this->dbcore1->qmenu(),
          'idpeg' => $idpeg,
          'qtitle' => $vtitle,
          'ndok' => $this->dbcore1->routekey($doku,'d'),
          'jdok' => $this->dbcore1->routekey($dokjud,'d'),
          'mod' => 'p'
        );
        $this->load->view('backoff/qvault',$data);
      } else {
        $this->load->view('frontoff/login');
      }
    }

    function isi_pesan(){
      $pegid = $this->session->userdata('pgpid');
      $pegaks = substr($this->session->userdata('pgakses'),0,1);
      $simpdesc = $this->dbcore1->routekey($this->input->post('ps_desc'),'e');
      $simpisi = $this->dbcore1->routekey(str_replace('../','/',$this->input->post('ps_ket')),'e');
        $data = array(
          'qvault_docnum' => $this->input->post('ps_judul'),
          'qvault_docdesc' => $simpdesc,
          'qvault_docisi' => $simpisi,
          'qvault_eye' => $this->session->userdata('pgkey')
        );
          $this->dbcore1->simppesan($data,'q');
/*          
          if($idpeg!=$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
            $hcinet=$this->dbcore1->cinet();
            if($hcinet){
              $this->dbcore1->routedqt(strip_tags(str_replace('../','',$this->input->post('ps_ket'))));
            }
          }
*/
    }

    function filldok($ndoku = FALSE){
      $list = $this->dbcore1->filldoku($ndoku);
      $data = array();
      foreach ($list as $idoku) {
        $dokdes = $idoku->qvault_docdesc;
        $dokisi = $idoku->qvault_docisi;
        $dokkey = $idoku->qvault_eye;
        $row = array();
        $row[] = (int)$this->session->userdata('pgsu')>=1?$this->dbcore1->routekey($dokdes,'d',$dokkey):$dokdes;
        $row[] = (int)$this->session->userdata('pgsu')>=1?$this->dbcore1->routekey($dokisi,'d',$dokkey):$dokisi;
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "data" => $data
      );
      echo json_encode($output);
    }

    function cek_doknew(){
      $isinew = $this->dbcore1->cekdoknew();
        return $isinew;
    }
}
