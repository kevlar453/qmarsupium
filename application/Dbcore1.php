<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Dbcore1 extends CI_Model{

  function __construct() {
    parent::__construct();
    $this->load->helper('url','form');
//    $this->load->library('session');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
//      $this->output->enable_profiler(TRUE);
  }

//----------------------------------LOGIN


function validate_user( $nik ) {
  $caksawal = substr($nik,-1);
    if(strlen($nik)>3){
        // Build a query to retrieve the user's details
        // based on the received username and password
        $this->dbmain->select('qmain_akses.*');
        $this->dbmain->select('qmain_pgprofile_peg.*');
        $this->dbmain->from('qmain_akses');
        $this->dbmain->where('qaknik',substr($nik,0,11) );
        $this->dbmain->join('qmain_pgprofile_peg', 'qmain_pgprofile_peg.pgpid = qmain_akses.qaknik','left');
        $login = $this->dbmain->get()->result();

        // The results of the query are stored in $login.
        // If a value exists, then the user account exists and is validated
        if ( is_array($login) && count($login) == 1 ) {
            // Set the users details into the $details property of this class
            $this->details = $login[0];
            // Call set_session to set the user's session vars via CodeIgniter
            $this->set_session($caksawal);
            return true;
        }
    } else {
            $this->set_sessionx($nik);
            return true;
    }

    return false;
}

var $details;

function set_session($awal = FALSE) {
  $cak1 = substr($this->details->qakjob,0,1);
  $cak2 = substr($this->details->qakjob,1,1);
  $cak3 = substr($this->details->qakjob,-1);

if($awal==$cak1||$awal==$cak2||$awal==$cak3){
  $job ='';
  for($i=0;$i<=2;$i++){
    $job .= $awal;
  }
    $this->session->set_userdata( array(
            'pgpid'=>$this->details->pgpid,
            'pgakses'=>$job,
            'pgsu'=>$this->details->qaksu,
            'pgip'=>$this->get_client_ip(),
            'isLoggedIn'=>true
        )
    );
} else {
  return false;
}
}

function set_sessionx($nmr = FALSE) {
if($nmr=='222'){
  $this->session->set_userdata( array(
          'pgpid'=>'0000.00.'.$nmr,
          'pgakses'=>$nmr,
          'pgsu'=>'2',
          'isLoggedIn'=>true
      )
  );
} else {
  return false;
}

}

function get_client_ip() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}


//----------------------------------END LOGIN

 function caripeg($id = FALSE) {
     if(substr($id,0,7)!='0000.00'){
        $this->dbmain->from('qmain_pgprofile_peg');
        $this->dbmain->where('pgpid',$id);
        $query = $this->dbmain->get();
            if($query -> num_rows() >= 1){
                return $query->row_array();
            }
            else {
                return false;
            }
     } else {
                return array('pgpnama'=>'Konsultan');
     }
 }

 /* Olah Data Pasien */
 function namaoprt($oprt = FALSE) {
    $this->dbmain->from('qmain_pgprofile_peg');
    $this->dbmain->where('pgpid',$oprt);
    $query = $this->dbmain->get();
        if($query -> num_rows() >= 1){
            return $query->row_array();
        }
        else {
            return false;
        }
 }

 function namapinjam($pinjam = FALSE) {
    $this->dbmain->from('qmain_pgprofile_peg');
    $this->dbmain->where('pgpid',$pinjam);
    $query = $this->dbmain->get();
        if($query -> num_rows() >= 1){
            return $query->row_array();
        }
        else {
            return false;
        }
 }

 function cariarsip($arsip){
 $this->dbmain->where('pdpidpx',$arsip);
 $this->dbmain->limit(1);
 $this->dbmain->order_by('pdpid','DESC');
 $query = $this->dbmain->get('qvar_dtpx');
        if($query -> num_rows() >= 1){
            return $query->row_array();
        }
        else {
            return false;
        }
 }

 function caripx($id = FALSE) {
    $this->dbmain->select('qmain_pxprofile_pri.*');
    $this->dbmain->select('DATE_FORMAT(CURDATE(), \'%Y\') - DATE_FORMAT(qmain_pxprofile_pri.pxptglhr, \'%Y\') - (DATE_FORMAT(CURDATE(), \'00-%m-%d\') < DATE_FORMAT(qmain_pxprofile_pri.pxptglhr, \'00-%m-%d\')) AS pxputh');
    $this->dbmain->select('TIMESTAMPDIFF( MONTH, qmain_pxprofile_pri.pxptglhr, CURDATE() ) % 12 AS pxpubl');
    $this->dbmain->select('FLOOR( TIMESTAMPDIFF( DAY, qmain_pxprofile_pri.pxptglhr, CURDATE() ) % 30.4375 ) AS pxpuhr');
    $this->dbmain->select('qmain_pxprofile_kel.*');
    $this->dbmain->select('qmain_pxprofile_tgg.*');
    $this->dbmain->select('qvar_desa.namades as vdes');
    $this->dbmain->select('qvar_kec.namakec as vkec');
    $this->dbmain->select('qvar_kab.namakab as vkab');
    $this->dbmain->select('qvar_prop.namaprp as vprp');
    $this->dbmain->select('qvar_negara.varnama as vneg');
    $this->dbmain->select('qvar_pekerjaan.varnama as vkrj');
    $this->dbmain->select('qvar_pendidikan.varnama as vdik');
    $this->dbmain->select('qvar_umum.varnama as vsts');
    $this->dbmain->select('qvar_suku.varnama as vsuku');
    $this->dbmain->select('qvar_agama.varnama as vagama');
    $this->dbmain->from('qmain_pxprofile_pri');
    $this->dbmain->join('qmain_pxprofile_kel', 'qmain_pxprofile_kel.pxkidrs = qmain_pxprofile_pri.pxpidrs','left');
    $this->dbmain->join('qmain_pxprofile_tgg', 'qmain_pxprofile_tgg.pxtidrs = qmain_pxprofile_pri.pxpidrs','left');
    $this->dbmain->join('qvar_desa', 'qvar_desa.id = qmain_pxprofile_pri.pxpdes','left');
    $this->dbmain->join('qvar_kec', 'qvar_kec.id = qmain_pxprofile_pri.pxpkec','left');
    $this->dbmain->join('qvar_kab', 'qvar_kab.id = qmain_pxprofile_pri.pxpkab','left');
    $this->dbmain->join('qvar_prop', 'qvar_prop.id = qmain_pxprofile_pri.pxpprp','left');
    $this->dbmain->join('qvar_negara', 'qvar_negara.varid = qmain_pxprofile_pri.pxpneg','left');
    $this->dbmain->join('qvar_pendidikan', 'qvar_pendidikan.varid = qmain_pxprofile_pri.pxpdik','left');
    $this->dbmain->join('qvar_pekerjaan', 'qvar_pekerjaan.varid = qmain_pxprofile_pri.pxpkrj','left');
    $this->dbmain->join('qvar_umum', 'qvar_umum.varid = qmain_pxprofile_pri.pxpstskw','left');
    $this->dbmain->join('qvar_suku', 'qvar_suku.varid = qmain_pxprofile_pri.pxpsuku','left');
    $this->dbmain->join('qvar_agama', 'qvar_agama.varid = qmain_pxprofile_pri.pxpagama','left');
    if(strlen($id)==6){
    $this->dbmain->where('qmain_pxprofile_pri.pxpidrs',$id);
    } else {
    $this->dbmain->where('qmain_pxprofile_pri.pxpidjkn',$id);
    }
    $query = $this->dbmain->get();
        if($query -> num_rows() >= 1){
            return $query->row_array();
        }
        else {
            return false;
        }
 }

 function tbumum($vtb = FALSE, $vcl = FALSE, $vid = FALSE){
    $query = $this->dbmain->get_where($vtb,array($vcl=>$vid));
        if($query->num_rows() >= 1){
            return $query->row_array();
        }
        else {
            return false;
        }

 }

/* End Olah Data Pasien*/

function get_agama() {
 $this->dbmain->select('varid, varnama');
 $query = $this->dbmain->get('qvar_agama');

$lagama = array();

if ($query -> result()) {
 foreach ($query->result() as $agm) {
 $lagama[$agm -> varid] = $agm -> varnama;
 }
 return $lagama;
 } else {
 return FALSE;
 }
 }

function get_suku() {
 $this->dbmain->select('varid, varnama');
 $query = $this->dbmain->get('qvar_suku');

$lsuku= array();

if ($query -> result()) {
 foreach ($query->result() as $sku) {
 $lsuku[$sku -> varid] = $sku -> varnama;
 }
 return $lsuku;
 } else {
 return FALSE;
 }
 }

function get_pendidikan() {
 $this->dbmain->select('varid, varnama');
 $query = $this->dbmain->get('qvar_pendidikan');

$lsuku= array();

if ($query -> result()) {
 foreach ($query->result() as $dik) {
 $lpendidikan[$dik -> varid] = $dik -> varnama;
 }
 return $lpendidikan;
 } else {
 return FALSE;
 }
 }

function get_pekerjaan() {
 $this->dbmain->select('varid, varnama');
 $query = $this->dbmain->get('qvar_pekerjaan');

$lpekerjaan= array();

if ($query -> result()) {
 foreach ($query->result() as $krj) {
 $lpekerjaan[$krj -> varid] = $krj -> varnama;
 }
 return $lpekerjaan;
 } else {
 return FALSE;
 }
 }

function get_poliklinik() {
 $this->dbmain->select('varid, varnama');
 $query = $this->dbmain->get('qvar_bagian');

$poliklinik = array();

if ($query -> result()) {
 foreach ($query->result() as $poli) {
 $poliklinik[$poli -> varid] = $poli -> varnama;
 }
 return $poliklinik;
 } else {
 return FALSE;
 }
 }

function get_negara() {
 $this->dbmain->select('varid, varnama');
 $query = $this->dbmain->get('qvar_negara');

$negara = array();

if ($query -> result()) {
 foreach ($query->result() as $neg) {
 $negara[$neg -> varid] = $neg -> varnama;
 }
 return $negara;
 } else {
 return FALSE;
 }
 }

function get_propinsi($negara = null){
 $this->dbmain->select('id, namaprp');

 if($negara != NULL){
 $this->dbmain->where('id_neg', $negara);
 }

 $query = $this->dbmain->get('qvar_prop');

 $propinsi = array();

 if($query->result()){
 foreach ($query->result() as $prop) {
 $propinsi[$prop->id] = $prop->namaprp;
 }
 return $propinsi;
 }else{
 return FALSE;
 }
}

function get_kabupaten($propinsi = null){
 $this->dbmain->select('id, namakab');

 if($propinsi != NULL){
 $this->dbmain->where('id_prp', $propinsi);
 }

 $query = $this->dbmain->get('qvar_kab');

 $kabupaten = array();

 if($query->result()){
 foreach ($query->result() as $kab) {
 $kabupaten[$kab->id] = $kab->namakab;
 }
 return $kabupaten;
 }else{
 return FALSE;
 }
}

function get_kecamatan($kabupaten = null){
 $this->dbmain->select('id, namakec');

 if($kabupaten != NULL){
 $this->dbmain->where('id_kab', $kabupaten);
 }

 $query = $this->dbmain->get('qvar_kec');

 $kecamatan = array();

 if($query->result()){
 foreach ($query->result() as $kec) {
 $kecamatan[$kec->id] = $kec->namakec;
 }
 return $kecamatan;
 }else{
 return FALSE;
 }
}

function get_desa($kecamatan = null){
 $this->dbmain->select('id, namades');

 if($kecamatan != NULL){
 $this->dbmain->where('id_kec', $kecamatan);
 }

 $query = $this->dbmain->get('qvar_desa');

 $desa = array();

 if($query->result()){
 foreach ($query->result() as $des) {
 $desa[$des->id] = $des->namades;
 }
 return $desa;
 }else{
 return FALSE;
 }
}

/* data info */

function call_useraktif(){
$this->dbmain->select('*');
$this->dbmain->from('qmain_user');
//$this->dbmain->where('status','true');
$query = $this->dbmain->get();
       if($query -> num_rows() >= 1){
           return $query->result_array();
       }
       else {
           return false;
       }
}


function isi_useraktif($data = FALSE) {
  return $this->dbmain->insert('qmain_user', $data);
  exit;
}

function del_useraktif($cunik = FALSE,$cuip = FALSE){
  $this->dbmain->where(array('qusnik'=> $cunik,'qusip'=>$cuip));
  $this->dbmain->delete('qmain_user');
//  return $this->dbmain->query('TRUNCATE qmain_user');
//  exit;

}

function catatlog($data = FALSE) {
  return $this->dbmain->insert('qvar_temp_log', $data);
  exit;
}

function get_peggroup($grp = FALSE) {
 $this->dbmain->like('qakjob',$grp);
 $query = $this->dbmain->get('qmain_akses');
 $ggroup = $query->result_array();
 return $ggroup;
 }

function simppesan($data = FALSE){
  return $this->dbmain->insert('qmain_pesan',$data);
  exit;
}

function dafpesan($psgrp = FALSE,$psnik = FALSE,$pswkt = FALSE){
  $this->dbmain->where(array('psn_group'=>$psgrp,'psn_untuk'=>$psnik));
  if($pswkt){
    $this->dbmain->where(array('DATE(psn_wkt)'=>$pswkt));
  }
  $this->dbmain->order_by('psn_wkt','desc');
  $query = $this->dbmain->get('qmain_pesan');
  $listpsn = $query->result_array();
  return $listpsn;

}

/**/
}
