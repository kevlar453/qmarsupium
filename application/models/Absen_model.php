<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen_model extends CI_Model {

  function __construct(){
  parent::__construct();
  $this->load->model('dbcore1','',TRUE);
  $this->load->model('absen_model','',TRUE);
  $this->load->helper('url','form');
  $this->load->helper('parse');
  $this->dbmain = $this->load->database('default',TRUE);
//  $this->dbhis= $this->load->database('dbhis', TRUE);
  }

var $finger = 'antoniusamp.ddns.net';

  var $table1 = 'qtemp_finger_all';
  var $table2 = 'qmain_pgprofile_peg';

var $column_search1 = array('qtemp_finger_all.temp2_tgl','qtemp_finger_all.temp2_nik','qmain_pgprofile_peg.pgpnama','qtemp_finger_all.temp2_ket');
  var $column_order1 = array('qtemp_finger_all.temp2_tgl','qtemp_finger_all.temp2_nik','qmain_pgprofile_peg.pgpnama','qtemp_finger_all.temp2_ket',null);
var $order1 = array('qtemp_finger_all.temp2_nik,qtemp_finger_all.temp2_tgl' => 'asc');

  function _get_absen_query($atgl = FALSE, $abag = FALSE){
      $nik = $this->session->userdata('pgpid');
//      $area = substr($are,0,5);
      $xtgl = substr($atgl,0,10)==''?date("Y-m-d"):substr($atgl,0,10);
      $ytgl = substr($atgl,-10)==''?date("Y-m-d"):substr($atgl,-10);

          $this->dbmain->select('qtemp_finger_all.temp2_tgl as temp2_tgl,qtemp_finger_all.temp2_nik as temp2_nik,qmain_pgprofile_peg.pgpnama as pgpnama,qtemp_finger_all.temp2_ket as temp2_ket');
          $this->dbmain->from($this->table1);
          $this->dbmain->join($this->table2,$this->table2.'.pgpid='.$this->table1.'.temp2_nik','left');
//          $this->dbmain->where(array('temp2_tgl >='=>$xtgl,'temp2_tgl <='=>$ytgl));
          $this->dbmain->where('LEFT(`'.$this->table1.'`.`temp2_tgl`,10) BETWEEN \''. $xtgl.'\' + INTERVAL 1 DAY and \''. $ytgl .'\' + INTERVAL 1 DAY', NULL, FALSE);
          if($abag!='00'){
            $this->dbmain->where($this->table2.'.pgpidfing1',$abag);
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


  public function isiabsen($tg12 = FALSE){
  $this->_get_absen_query(substr($tg12,0,20),substr($tg12,-2));
  if($_POST['length'] != -1)
  $this->dbmain->limit($_POST['length'], $_POST['start']);
  $query = $this->dbmain->get();
  return $query->result();
      exit;
  }

  public function cek_data_absen($btgl = FALSE){
//    $btgl = date("Y-m-d");
    $this->dbmain->select('temp2_tgl');
    $this->dbmain->from($this->table1);
    $this->dbmain->where('LEFT(temp2_tgl,10) <>',$btgl);
    $this->dbmain->order_by('temp2_tgl','desc');
    $this->dbmain->limit(1);
    $data = $this->dbmain->get();
//      $data = $this->dbmain->result_array();
    return $data->row_array();
//      exit;
  }

  function cariidpeg($PIN = FALSE, $bagunit = FALSE){
      $data = $this->dbmain->get_where('qmain_pgprofile_peg', array('pgpidfing1' => $bagunit,'pgpidfing2' => $PIN));
//      $data = $this->dbmain->result_array();
    return $data->result();
//      exit;
  }

    public function carstspeg($NIK = FALSE){
        $data = $this->dbmain->get_where('data_finger', array('nikrsk' => $NIK));
        return $data->result();
    }

    public function carwktpeg($NIK = FALSE){
      $this->dbmain->select('temp2_tgl');
      $this->dbmain->from($this->table1);
      $this->dbmain->where('temp2_nik',substr($NIK,0,11));
      if(substr($NIK,-1)=='x'){
        $this->dbmain->order_by('temp2_tgl','asc');
      } else {
        $this->dbmain->order_by('temp2_tgl','desc');
      }
      $this->dbmain->limit(1);
        $data = $this->dbmain->get();
        return $data->result();
        exit;
    }

    public function get_data_absen(){
//  		error_reporting(0);
          $IP = $this->finger;
          $Key = 'ampenanlombok';
          $sPIN = 1;
          if($IP){
            $this->dbmain->query('TRUNCATE data_finger');
          $Connect = @fsockopen($IP, "81", $errno, $errstr, 10);
              if($Connect){
                  $soap_request="<GetAllUserInfo><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey></GetAllUserInfo>";
                  $newLine="\r\n";
                  fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                  fputs($Connect, "Content-Type: text/xml".$newLine);
                  fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                  fputs($Connect, $soap_request.$newLine);
                  $buffer="";
                  while($Response=fgets($Connect, 1024)){
                      $buffer=$buffer.$Response;
                  }
                  $buffer = Parse_Data($buffer,"<GetAllUserInfoResponse>","</GetAllUserInfoResponse>");
                  $buffer = explode("\r\n",$buffer);
                  $abspeg[] = array();
                  for($a=0;$a<count($buffer);$a++){
                      $data = Parse_Data($buffer[$a],"<Row>","</Row>");
                      $PIN = Parse_Data($data,"<PIN>","</PIN>");
                      $PIN2 = Parse_Data($data,"<PIN2>","</PIN2>");
                      $Name = Parse_Data($data,"<Name>","</Name>");
                      $WorkCode = Parse_Data($data,"<WorkCode>","</WorkCode>");
                      $Status = Parse_Data($data,"<Status>","</Status>");
                      $Verified = Parse_Data($data,"<Verified>","</Verified>");

                      if ($PIN2) {
                        $carinik = $this->cariidpeg($PIN2);
                        if ($carinik) {
                          foreach ($carinik as $cnk) {
//                            $abspeg[] = array('pin'=>$cnk->pgpid,'name'=>$cnk->pgpnama,'status'=>'X');
                            $lhtdt = $this->carstspeg($cnk->pgpid);
                            if(!$lhtdt){
                              $ins = array(
                                      "pin"       =>  $PIN,
                                      "pin2" =>  $PIN2,
                                      "name"		=>  $cnk->pgpnama,
                                      "status"		=>  $Status,
                                      "nikrsk"		=>  $cnk->pgpid
                                      );
                            	$this->dbmain->insert('data_finger', $ins);
                            }
                          }
                        }
                      }
                    }
//                    return $abspeg;
                  }
                }
              }

              public function get_sts_absen($ststg = FALSE){
          //  		error_reporting(0);
                    $IP = $this->finger;
                    $Key = 'ampenanlombok';
                    $sPIN = 1;
                    $tgcek = date("Y-m-d",strtotime($ststg));
                    $tgbts = date("Y-m-t");
                    $query = $this->dbmain->select('*')->from($this->table1)->get();
                    $vartgcek = $query->num_rows() >= 1?'1':'0';

                    if($IP){
/*
                      $nbln = date("m");
                      $blnwingi = strtotime('previous month');
                      $sblnwingi = date('Y-m-01', $blnwingi);
                      $eblnwingi = date('Y-m-t', $blnwingi);
*/
                    $Connect = @fsockopen($IP, "81", $errno, $errstr, 10);
                        if($Connect){
                          $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
                            $newLine="\r\n";
                            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
                            fputs($Connect, "Content-Type: text/xml".$newLine);
                            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
                            fputs($Connect, $soap_request.$newLine);
                            $buffer="";
                            while($Response=fgets($Connect, 1024)){
                                $buffer=$buffer.$Response;
                            }
                            $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
                            $buffer = explode("\r\n",$buffer);
                            $abspeg[] = array();
                            if($vartgcek=='0'){
                              $this->dbmain->query('TRUNCATE qtemp_finger_all');
                            }
                            for($a=0;$a<count($buffer);$a++){
                                $data = Parse_Data($buffer[$a],"<Row>","</Row>");
                                $PIN = Parse_Data($data,"<PIN>","</PIN>");
                                $Status = Parse_Data($data,"<Status>","</Status>");
                                $DateTime = Parse_Data($data,"<DateTime>","</DateTime>");
//                                $Verified = Parse_Data($data,"<Verified>","</Verified>");
//                                $WorkCode = Parse_Data($data,"<WorkCode>","</WorkCode>");
//$dbln  = date("m",strtotime($DateTime))==$bln?'1':'0';

                                $dtgl  = (strtotime($DateTime)>=strtotime($tgcek) && strtotime($DateTime)<=strtotime($tgbts))?'1':'0';
                                if($vartgcek=='1'){
                                  if ($dtgl=='1') {
//                                    $query = $this->dbmain->select('*')->from($this->table1)->where('LEFT(temp2_tgl,10)',date("Y-m-d",strtotime($DateTime)))->get();
//                                    if($query->num_rows() == 0){
                                    $cnik = $this->cariidpeg($PIN);
                                    if ($cnik){
                                      foreach ($cnik as $cnk) {
                                        $ins = array(
                                          "temp2_nik" => $cnk->pgpid,
                                          "temp2_tgl"  =>  date("Y-m-d H:i:s",strtotime($DateTime)),
                                          "temp2_ket"  =>  '---'
                                        );
                                          $this->dbmain->insert('qtemp_finger_all', $ins);
                                      }
                                    }
//                                  }
                                }
                                } else {
                                  if ($PIN) {
                                    $cnik = $this->cariidpeg($PIN);
                                    if ($cnik){
                                      foreach ($cnik as $cnk) {
                                        $ins = array(
                                          "temp2_nik" => $cnk->pgpid,
                                          "temp2_tgl"  =>  date("Y-m-d H:i:s",strtotime($DateTime)),
                                          "temp2_ket"  =>  '---'
                                        );
                                        $this->dbmain->insert('qtemp_finger_all', $ins);
                                      }
                                    }
                                  }
                                }
                              }
                            }
                          }
                        }



//---------------------------------START SOURCES

//--------------------------------START ABSEN AKTIF
function idpegall($PIN = FALSE){
    $data = $this->dbmain->get_where('qmain_pgprofile_peg', array('pgpidfing2' => $PIN));
//      $data = $this->dbmain->result_array();
  return $data->result();
//      exit;
}

public function get_act_absen(){
  $jskr = date('Y-m-d H:i:s');
  $dskr = date('H:i:s');
  $gskr = date('Y-m-d');
/*
  $jdw1a = date('04:30:00');
  $jdw1b = date('H:i:s',strtotime('+5 hour',strtotime($jdw1a)));
*/

  $jdw1a = date('06:00:00');
  $jdw1b = date('10:30:00');
  $jdw2a = date('10:31:00');
  $jdw2b = date('18:30:00');
  $jdw3a = date('18:31:00');
  $jdw3b = date('23:59:00');

  $jdwp = date('00:00:00');
  $jdwq = date('06:00:00');
  $jdwr = date('13:55:00');
  $jdws = date('20:00:00');
  $jdwt = date('23:59:00');


if($dskr > $jdwq && $dskr <= $jdwr){
  $settm = 'p';
} elseif($dskr > $jdwr && $dskr <= $jdws) {
  $settm = 's';
} elseif($dskr > $jdws && $dskr <= $jdwt) {
  $settm = 'm1';
} else {
  $settm = 'm2';
}

  $qtest1 = array();
  $qtest2 = array();
  $qtest3 = array();
  $qtest4 = array();
  $qtesta = array();
  $qtestb = array();
  $qtestc = array();
  $qtestd = array();
  $list1=array('84','85','10','19','14','15');

      $IP = $this->finger;
      $Key = 'ampenanlombok';
      $sPIN = 1;
      $dt = date("Y-m-d");
      $dt1 = date('Y-m-d',strtotime("-1 days"));
      $tgcek1 = date('Y-m-d',strtotime("-2 days"));
//      $tgcek = $dt->format('Y-m-d');
$tgcek = date('Y-m-d',strtotime("-1 days"));
    if($IP){
    $Connect = @fsockopen($IP, "81", $errno, $errstr, 10);
        if($Connect){

          $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine="\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer="";
            while($Response=fgets($Connect, 1024)){
                $buffer=$buffer.$Response;
            }
            $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
            $buffer = explode("\r\n",$buffer);
            $abspeg[] = array();
            $this->dbmain->query('TRUNCATE qtemp_finger_all');
            $this->dbmain->query('TRUNCATE qtemp_finger_aktif');
            $this->dbmain->query('TRUNCATE qtemp_finger_sem');
            for($a=0;$a<count($buffer);$a++){
                $data = Parse_Data($buffer[$a],"<Row>","</Row>");
                $PIN = Parse_Data($data,"<PIN>","</PIN>");
                $Status = Parse_Data($data,"<Status>","</Status>");
                $DateTime = Parse_Data($data,"<DateTime>","</DateTime>");
                $tglabs  = date("Y-m-d",strtotime($DateTime));

                    $cnik = $this->idpegall($PIN);
                    if ($cnik){
                      foreach ($cnik as $cnk) {

                        $tgabs = date("Y-m-d H:i:s",strtotime($DateTime));
                        $jmabs = date("H:i:s",strtotime($DateTime));
                        $grpid = strlen($cnk->pgpidfing1)==1?'0'.$cnk->pgpidfing1:$cnk->pgpidfing1;
                        if($grpid=='84'||$grpid=='85'||$grpid=='10'||$grpid=='14'||$grpid=='15'||$grpid=='19'){

                          if($settm=='m1'){
                            if($tglabs==$dt){
                              $insp = array(
                                "temp1_nik" => $cnk->pgpid,
                                "temp1_tgl"  => $tgabs,
                                "temp1_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw1a && $jmabs < $jdw1b){
                                $this->dbmain->insert('qtemp_finger_sem', $insp);
                              }
                              $inss = array(
                                "temp2_nik" => $cnk->pgpid,
                                "temp2_tgl"  => $tgabs,
                                "temp2_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw1b && $jmabs < $jdw2b){
                                $this->dbmain->insert('qtemp_finger_all', $inss);
                              }
                              $insm = array(
                                "temp0_nik" => $cnk->pgpid,
                                "temp0_tgl"  =>  $tgabs,
                                "temp0_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw3a && $jmabs < $jdw3b){
                                $this->dbmain->insert('qtemp_finger_aktif', $insm);
                              }
                            }
                          } elseif($settm=='m2'){
                            if($tglabs==$dt1){
                              $insp = array(
                                "temp1_nik" => $cnk->pgpid,
                                "temp1_tgl"  => $tgabs,
                                "temp1_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw1a && $jmabs < $jdw1b){
                                $this->dbmain->insert('qtemp_finger_sem', $insp);
                              }
                              $inss = array(
                                "temp2_nik" => $cnk->pgpid,
                                "temp2_tgl"  => $tgabs,
                                "temp2_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw1b && $jmabs < $jdw2b){
                                $this->dbmain->insert('qtemp_finger_all', $inss);
                              }
                              $insm = array(
                                "temp0_nik" => $cnk->pgpid,
                                "temp0_tgl"  =>  $tgabs,
                                "temp0_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw3a && $jmabs < $jdw3b){
                                $this->dbmain->insert('qtemp_finger_aktif', $insm);
                              }
                            }
                          } elseif($settm=='p'){
                            if($tglabs==$dt1){
                              $insp = array(
                                "temp1_nik" => $cnk->pgpid,
                                "temp1_tgl"  => $tgabs,
                                "temp1_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw2a && $jmabs < $jdw2b){
                                $this->dbmain->insert('qtemp_finger_sem', $insp);
                              }
                              $inss = array(
                                "temp2_nik" => $cnk->pgpid,
                                "temp2_tgl"  => $tgabs,
                                "temp2_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw3a && $jmabs < $jdw3b){
                                $this->dbmain->insert('qtemp_finger_all', $inss);
                              }
                              } elseif($tglabs==$dt){
                              $insm = array(
                                "temp0_nik" => $cnk->pgpid,
                                "temp0_tgl"  =>  $tgabs,
                                "temp0_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw1a && $jmabs < $jdw1b){
                                $this->dbmain->insert('qtemp_finger_aktif', $insm);
                              }
                            }
                          }elseif($settm=='s'){
                            if($tglabs==$dt1){
                              $insp = array(
                                "temp1_nik" => $cnk->pgpid,
                                "temp1_tgl"  => $tgabs,
                                "temp1_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw3a && $jmabs < $jdw3b){
                                $this->dbmain->insert('qtemp_finger_sem', $insp);
                              }
                            } elseif($tglabs==$dt){
                              $inss = array(
                                "temp2_nik" => $cnk->pgpid,
                                "temp2_tgl"  => $tgabs,
                                "temp2_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw1a && $jmabs < $jdw1b){
                                $this->dbmain->insert('qtemp_finger_all', $inss);
                              }
                              $insm = array(
                                "temp0_nik" => $cnk->pgpid,
                                "temp0_tgl"  =>  $tgabs,
                                "temp0_ket"  =>  $grpid.$cnk->pgpnama
                              );
                              if($jmabs > $jdw2a && $jmabs < $jdw2b){
                                $this->dbmain->insert('qtemp_finger_aktif', $insm);
                              }
                            }
                          }

                        }

                      }
                    }

                }

              }
            }

            $this->dbmain->select('max(temp1_ur) as urt,temp1_nik');
            $this->dbmain->from('qtemp_finger_sem');
            $this->dbmain->group_by('temp1_nik');
            $query = $this->dbmain->get();
            $qurt1 = $query->result_array();
            foreach($qurt1 as $qts1){
              $qtest1[] .= $qts1['temp1_nik'];
              $qtesta[] .= (int)$qts1['urt'];
            }
            $this->dbmain->where_not_in('temp1_ur',$qtesta);
            $this->dbmain->delete('qtemp_finger_sem');
            $this->dbmain->where_in('temp2_nik',$qtest1);
            $this->dbmain->delete('qtemp_finger_all');

            $this->dbmain->select('max(temp2_ur) as urt,temp2_nik');
            $this->dbmain->from('qtemp_finger_all');
            $this->dbmain->group_by('temp2_nik');
            $query = $this->dbmain->get();
            $qurt2 = $query->result_array();
            foreach($qurt2 as $qts2){
              $qtest2[] .= $qts2['temp2_nik'];
              $qtestb[] .= (int)$qts2['urt'];
            }
            $this->dbmain->where_not_in('temp2_ur',$qtestb);
            $this->dbmain->delete('qtemp_finger_all');
            $this->dbmain->where_in('temp0_nik',$qtest2);
            $this->dbmain->delete('qtemp_finger_aktif');

            $this->dbmain->select('max(temp0_ur) as urt,temp0_nik');
            $this->dbmain->from('qtemp_finger_aktif');
            $this->dbmain->group_by('temp0_nik');
            $query = $this->dbmain->get();
            $qurt3 = $query->result_array();
            foreach($qurt3 as $qts3){
              $qtest3[] .= $qts3['temp0_nik'];
              $qtestc[] .= (int)$qts3['urt'];
            }

            $this->dbmain->where_not_in('temp0_ur',$qtestc);
            $this->dbmain->delete('qtemp_finger_aktif');
            }


          public function sar_act_absen(){
            $jskr = date('Y-m-d H:i:s');
            $qtest1 = array();
            $qtest2 = array();
            $qtest3 = array();
            $qtest4 = array();
            $list1=array('84','85','10','19','14','15');
          }

          public function get_isi_abs(){
            $this->dbmain->select('temp0_ket');
            $this->dbmain->from('qtemp_finger_aktif');
            $this->dbmain->order_by('temp0_ket');
            $query = $this->dbmain->get();
            return $query->result_array();
            exit;
          }

//--------------------------------END ABSEN AKTIF

public function cpegawai($bagunit = FALSE){
  $this->get_now_absen($bagunit);
  $this->dbmain->select('*');
  $this->dbmain->from('qtemp_finger_'.$bagunit);
  //$this->dbmain->where('status','true');
  $query = $this->dbmain->get();
  if($query -> num_rows() >= 1){
    return $query->result_array();
  }
  else {
    return false;
  }
}


// GET ABSENDOKTER---------------------------START
function get_now_absen($unit = FALSE){
  $dbts1 = date("H:i",strtotime('07:00:00'));
  $dbts2 = date("H:i",strtotime('14:00:00'));
  $dbts3 = date("H:i",strtotime('21:00:00'));
  $IP = 'rskantonius.ddns.net';
  $Key = 'ampenanlombok';
  $sPIN = 1;
  if($IP){
$ntgl = date("Y-m-d");
$njam = date("H:i");
$npkl = date("Y-m-t H:i");
if(strtotime($njam)>=strtotime($dbts1) && strtotime($njam)<strtotime($dbts2)){
  $goljam = $dbts1;
} elseif(strtotime($njam)>=strtotime($dbts2) && strtotime($njam)<strtotime($dbts3)){
  $goljam = $dbts2;
} else {
  $goljam = $dbts3;
}
    $Connect = @fsockopen($IP, "81", $errno, $errstr, 10);
    if($Connect){
      $this->dbmain->query('TRUNCATE qtemp_finger_'.$unit);
      $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
      $newLine="\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
      fputs($Connect, "Content-Type: text/xml".$newLine);
      fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
      fputs($Connect, $soap_request.$newLine);
      $buffer="";
      while($Response=fgets($Connect, 1024)){
        $buffer=$buffer.$Response;
      }
      $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
      $buffer = explode("\r\n",$buffer);
      for($a=0;$a<count($buffer);$a++){
        $data = Parse_Data($buffer[$a],"<Row>","</Row>");
        $PIN = Parse_Data($data,"<PIN>","</PIN>");
        $DateTime = Parse_Data($data,"<DateTime>","</DateTime>");
        $dtgl  = (date("Y-m-d H:i",strtotime($DateTime))>=$npkl)?'1':'0';
        $cnik = $this->cariidpeg($PIN,$unit);
        if ($PIN && $cnik && $dtgl = '1'){
            foreach ($cnik as $cnk) {
                $ins = array(
                  "temp3_kdfing" => $PIN,
                  "temp3_nama"  =>  $cnk->pgpnama.' - '.$goljam,
                  "temp3_unit"  =>  'IGD'
                  );
                  $this->dbmain->insert('qtemp_finger_'.$unit, $ins);
        }
      }
    }
  }
}
}
// GET ABSENDOKTER---------------------------END

public function get_log_absen(){

  $IP = $this->finger;
  $Key = 'ampenanlombok';
  $sPIN = 1;
  if($IP){
/*
    $nbln = date("m");
    $blnwingi = strtotime('previous month');
    $sblnwingi = date('Y-m-01', $blnwingi);
    $eblnwingi = date('Y-m-t', $blnwingi);
*/
    $Connect = @fsockopen($IP, "81", $errno, $errstr, 10);
    if($Connect){
      $this->dbmain->query('TRUNCATE qtemp_finger_all');
      $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
      $newLine="\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
      fputs($Connect, "Content-Type: text/xml".$newLine);
      fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
      fputs($Connect, $soap_request.$newLine);
      $buffer="";
      while($Response=fgets($Connect, 1024)){
        $buffer=$buffer.$Response;
      }
      $buffer = Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
      $buffer = explode("\r\n",$buffer);
      for($a=0;$a<count($buffer);$a++){
        $data = Parse_Data($buffer[$a],"<Row>","</Row>");
        $PIN = Parse_Data($data,"<PIN>","</PIN>");
        $DateTime = Parse_Data($data,"<DateTime>","</DateTime>");
        $Verified = Parse_Data($data,"<Verified>","</Verified>");
        $Status = Parse_Data($data,"<Status>","</Status>");
        //$dbln  = date("m",strtotime($DateTime))==$bln?'1':'0';

//        $dtgl  = (strtotime($DateTime)>=strtotime($sblnwingi) && strtotime($DateTime)<=strtotime($eblnwingi))?'1':'0';
//        if ($PIN && $dtgl=='1'){
          if ($PIN){
          $cnik = $this->cariidpeg($PIN);
          if ($cnik){
            foreach ($cnik as $cnk) {
                $ins = array(
                  "temp2_nik" => $cnk->pgpid,
                  "temp2_tgl"  =>  date("Y-m-d H:i:s",strtotime($DateTime)),
                  "temp2_ket"  =>  '---'
                  );
                $this->dbmain->insert('qtemp_finger_all', $ins);
          }
        }
      }
    }
  }
}
}
//-----------------------------------END SOURCES

}

/* End of file Absen_model.php */
/* Location: ./application/models/Absen_model.php */
