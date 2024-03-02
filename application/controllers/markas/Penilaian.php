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

    function getparnl(){
      $frmpar = $this->dbnilai->getparnil($this->input->post('searchTerm'),$this->input->post('prm'));
      echo json_encode($frmpar);
    }

    function getnilpar(){
      $detnilpar = $this->dbnilai->getparnildet($this->input->post('param1'),$this->input->post('param2'));
      echo json_encode($detnilpar);
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

    function ckelompok(){
      $prm = $this->input->post('param1');
      $hslkode = $this->dbnilai->gkode($prm);
      echo json_encode($hslkode);
    }


    function setindikator(){
      $coknil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnil'),'d');
      $lstisi = $this->dbnilai->getregio();
      $cmax = array();

      if($coknil == 'global'){
        $lstisid1 = $this->dbnilai->gisi();
        if($lstisid1){
          $arrval1 = array();
          foreach ($lstisid1 as $isid1) {
            $arrval1[] = $isid1->dettot;
          }
          $cmax = array_merge($arrval1,$cmax);
          $hslarrisi1[]=array(
            'value'=>$arrval1,
            'name'=>'Keuskupan Ketapang'
          );
        }
      } else {
        $cokdnil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnild1'),'d');
          if($lstisi){
            foreach ($lstisi as $isi1) {
              if($isi1['varid'] == $cokdnil){
                $lstisid1 = $this->dbnilai->gisi($isi1['varid']);
                if($lstisid1){
                  $arrval1 = array();
                  foreach ($lstisid1 as $isid1) {
                    $arrval1[] = $isid1->dettot;
                  }
                  if(substr($isi1['varid'],-2)!='00'){
                    $cmax = array_merge($arrval1,$cmax);
                    $hslarrisi1[]=array(
                      'value'=>$arrval1,
                      'name'=>$isi1['varnama']
                    );
                    $hslarrisi2[]=$isi1['varnama'];
                  }
                }
              }
            }
          }
      }

      $lstindi = $this->dbnilai->gindikator();
      foreach ($lstindi as $sar) {
        $detarr = array(
          'text'=>$sar->qnilb_nama,
          'max'=>max($cmax)
        );
        $hslarr[] = $detarr;
      }
      $hslarrkir = array(
        'indi'=> $hslarr,
        'isi1'=> $hslarrisi1,
        'isi2'=> '',
        'isi3'=>$cmax
      );
      $this->dbcore1->delcok('pilnil');
      echo json_encode($hslarrkir);
    }

    function cindikator($pindi = false,$pindipar = FALSE){
      if(!$pindi){
        $pindi = $this->input->post('param1');
        $pindipar = $this->input->post('param2');
      }
      $coknil = $this->dbcore1->routekey($this->dbcore1->getcok('pilnil'),'d');

      $cmax = array();

      $lstisi = $coknil == 'regio'?$this->dbnilai->getregio($pindi):$this->dbnilai->getparoki($pindi);

        if($lstisi){
          foreach ($lstisi as $isi1) {
            $lstisid1 = $this->dbnilai->gisi($isi1['varid'],$pindipar);
            if($lstisid1){
              $arrval1 = array();
              foreach ($lstisid1 as $isid1) {
                $arrval1[] = $isid1->dettot;
              }
              if(substr($isi1['varid'],-2)!='00'){
                $cmax = array_merge($arrval1,$cmax);
                $hslarrisi1[]=array(
                  'value'=>$arrval1,
                  'name'=>$isi1['varnama']
                );
                $hslarrisi2[]=$isi1['varnama'];
              }
            }

          }
        }
        $lstindi = $this->dbnilai->gindikator($pindipar);
        foreach ($lstindi as $sar) {
          $detarr = array(
            'text'=>$sar->qnilc_nama,
            'max'=>max($cmax)
          );
          $hslarr[] = $detarr;
        }
        $hslarrkir = array(
          'indi'=> $hslarr,
          'isi1'=> $hslarrisi1,
          'isi2'=> $hslarrisi2,
          'isi3'=>$cmax
        );
        //      $this->dbcore1->delcok('pilnil');
        echo json_encode($hslarrkir);

      }

}
