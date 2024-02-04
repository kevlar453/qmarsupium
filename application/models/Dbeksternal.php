<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbeksternal extends CI_Model {

    function __construct(){
    parent::__construct();
    $this->load->model('akuntansi','',TRUE);
    $this->load->helper('url','form');
//    $this->load->library('database');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
    }

    public function view(){
      return $this->db->get('qtemp_akun_all')->result();
    }

    public function upload_file($filename){
      $this->load->library('upload');

      $config['upload_path'] = './dapur0/semstorage/';
      $config['allowed_types'] = 'xls'|'xlsx';
      $config['max_size']	= '2048';
      $config['overwrite'] = true;
      $config['file_name'] = $filename;

      $this->upload->initialize($config);
      if($this->upload->do_upload('file')){
        $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
        return $return;
      }else{
        $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
        return $return;
      }
    }

    public function insert_multiple($data){
      $this->dbmain->insert_batch('qtemp_akun_all', $data);
    }

    public function loaddata($dataarray = FALSE) {
//      $this->dbmain->query('TRUNCATE qtemp_akun_all');
      $idpegawai = $this->session->userdata('pgpid');
      $this->dbmain->where('temp0_col10',$idpegawai);
      $this->dbmain->delete('qtemp_akun_all');
        for ($i = 1; $i < count($dataarray); $i++) {
            $data = array(
                'temp0_col1' => $dataarray[$i]['ecol1'],
                'temp0_col2' => $dataarray[$i]['ecol2'],
                'temp0_col3' => $dataarray[$i]['ecol3'],
                'temp0_col4' => $dataarray[$i]['ecol4'],
                'temp0_col6' => $dataarray[$i]['ecol5'],
                'temp0_col7' => $dataarray[$i]['ecol6'],
                'temp0_col8' => $dataarray[$i]['ecol7'],
                'temp0_col9' => $dataarray[$i]['ecol8'],
                'temp0_col10' => $idpegawai
            );
                $this->dbmain->insert('qtemp_akun_all', $data);
                $this->dbmain->where('temp0_col3','');
                $this->dbmain->delete('qtemp_akun_all');

//                $this->dbmain->where('temp0_ur',1);
//                $this->dbmain->delete('qtemp_akun_all');
        }
        $this->cdataexcel();
      }

      public function cdataexcel(){
        $idpegawai = $this->session->userdata('pgpid');
        $this->dbmain->query('SET foreign_key_checks=0');
        $this->dbmain->select('temp0_col4');
        $this->dbmain->from('qtemp_akun_all');
        $this->dbmain->where('temp0_col10',$idpegawai);
        $this->dbmain->group_by('temp0_col4');
        $query = $this->dbmain->get();
        $cekper = $query->result_array();
        foreach ($cekper as $ckper) {
          $ckanama = $this->akuntansi->get_per($ckper['temp0_col4']);
          if($ckanama){
            $crossper = $ckanama['ka_nama'];
            $this->dbmain->where('temp0_col4',$ckper['temp0_col4']);
            $this->dbmain->update('qtemp_akun_all',array('temp0_col5'=>$crossper));
          }
        }
        $qtest1 = array();
        $this->dbmain->select('akjur_nomor');
        $this->dbmain->from('qmain_akun_jur');
        $this->dbmain->group_by('akjur_nomor');
        $query = $this->dbmain->get();
        $qurt1 = $query->result_array();
        foreach($qurt1 as $qts1){
          $qtest1[] .= $qts1['akjur_nomor'];
        }
        $this->dbmain->where_in('temp0_col6',$qtest1);
        $this->dbmain->where('temp0_col10',$idpegawai);
        $this->dbmain->delete('qtemp_akun_all');

        $this->dbmain->select('*');
        $this->dbmain->from('qtemp_akun_all');
        $this->dbmain->where('temp0_col10',$idpegawai);
        $this->dbmain->group_by('temp0_col6');
        $query = $this->dbmain->get();
        $filljur = $query->result_array();
        foreach ($filljur as $fljur) {
          $data = array(
            'akjur_nomor' => $fljur['temp0_col6'],
            'akjur_jns' => $fljur['temp0_col1'],
            'akjur_tgl' => $fljur['temp0_col2'],
            'akjur_ket' => $fljur['temp0_col3'],
            'akjur_akses' => $fljur['temp0_col10']

        );
            $this->dbmain->insert('qmain_akun_jur', $data);
        }

        $this->dbmain->select('*');
        $this->dbmain->from('qtemp_akun_all');
        $this->dbmain->where('temp0_col10',$idpegawai);
//        $this->dbmain->group_by('temp0_col6');
        $query = $this->dbmain->get();
        $filltrx = $query->result_array();
        foreach ($filltrx as $fltrx) {
          $data = array(
            'aktrx_nomor' => $fltrx['temp0_col4'],
            'aktrx_nojur' => $fltrx['temp0_col6'],
            'aktrx_nama' => $fltrx['temp0_col5'],
            'aktrx_jns' => $fltrx['temp0_col7'],
            'aktrx_ket' => $fltrx['temp0_col8'],
            'aktrx_jum' => $fltrx['temp0_col9'],
            'aktrx_akses' => $fltrx['temp0_col10']
          );
            $datalawan = array(
              'aktrx_nomor' => '111.01.00.00',
              'aktrx_nojur' => $fltrx['temp0_col6'],
              'aktrx_nama' => 'Kas Umum Dewan Paroki',
              'aktrx_jns' => $fltrx['temp0_col7']=='D'?'K':'D',
              'aktrx_ket' => $fltrx['temp0_col8'],
              'aktrx_jum' => $fltrx['temp0_col9'],
              'aktrx_akses' => $fltrx['temp0_col10']
        );
        $this->dbmain->insert('qmain_akun_trx', $data);
        if($fltrx['temp0_col1']!='09' && $fltrx['temp0_col1']!='10'){
          $this->dbmain->insert('qmain_akun_trx', $datalawan);
        }
      }
      $this->dbmain->query('SET foreign_key_checks=1');
    }


}
