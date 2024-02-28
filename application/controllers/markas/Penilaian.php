<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth,User-Agent, X-File-Size, X-Requested-With, If-Modified-Since,X-File-Name, Cache-Control");

//defined('BASEPATH') OR exit('No direct script access allowed');

class Penilaian extends CI_Controller {


  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->model('dbnilai','',TRUE);
    $this->load->helper('url','form','parse');
    $this->dbmain = $this->load->database('default',TRUE);
  }

    function index() {

    }

    function getreg(){
      $frmkel = $this->dbnilai->getregio($this->input->post('searchTerm'));
      echo json_encode($frmkel);
    }

    function getpar(){
      $frmkel = $this->dbnilai->getparoki($this->input->post('searchTerm'),$this->input->post('prm'));
      echo json_encode($frmkel);
    }

    function ckategori(){
      $pindi = $this->input->post('param');
      $lstindi = $this->dbnilai->gkategori($pindi);
      if($lstindi){
        $hslarr = array();
        foreach ($lstindi as $sar) {
          $detarr = array(
            'text'=>$sar->qnilb_nama,
            'max'=>200
          );
          $hslarr[] = $detarr;
        }
        echo json_encode($hslarr);
      }
    }


    function cindikator($pindi = false){
      if(!$pindi){
        $pindi = $this->input->post('param');
      }

      $lstisi = $this->dbnilai->getregio($pindi);
      if($lstisi){
        foreach ($lstisi as $isi1) {
          $lstisid1 = $this->dbnilai->gisi($isi1['varid']);
          if($lstisid1){
            $arrval1 = array();
            foreach ($lstisid1 as $isid1) {
              $arrval1[] = $isid1->dettot;
            }
            $hslarrisi1[]=array(
              'value'=>$arrval1,
              'name'=>$isi1['varnama']
            );
            if(substr($isi1['varid'],-2)!='00'){
              $hslarrisi2[]=$isi1['varnama'];
            }
          }

        }
      }
      $lstindi = $this->dbnilai->gindikator($pindi);
      foreach ($lstindi as $sar) {
        $detarr = array(
          'text'=>$sar->qnilb_nama,
          'max'=>150
        );
        $hslarr[] = $detarr;
      }
      $hslarrkir = array(
        'indi'=> $hslarr,
        'isi1'=> $hslarrisi1,
        'isi2'=> $hslarrisi2,
      );
      echo json_encode($hslarrkir);
    }

    function cisi($pisi = false){
      if(!$pisi){
        $pisi = $this->input->post('param');
      }
      $lstisi = $this->dbnilai->gisi($pisi);
      if($lstisi){
        $hslarr = array(
          'value'=>$lstisi,
          'name'=>'Keuskupan'
        );
        if(!$pisi){
          echo json_encode($hslarr);
        } else {
          return $hslarr;
        }
      }
    }

}
