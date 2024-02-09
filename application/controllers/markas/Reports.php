<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth,User-Agent, X-File-Size, X-Requested-With, If-Modified-Since,X-File-Name, Cache-Control");

//defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {


  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->model('absen_model','',TRUE);
    $this->load->model('akuntansi','',TRUE);
    $this->load->model('proreports','',TRUE);
//    $this->load->model('transisi','',TRUE);
    $this->load->model('person_model','',TRUE);
    $this->load->helper('url','form','parse');
    $this->dbmain = $this->load->database('default',TRUE);
//    $this->dbhis= $this->load->database('dbhis', TRUE);
  }

    function index() {
        $rmoda = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'';
        $idpeg = $this->session->userdata('pgpid');
        $akpeg = $this->session->userdata('pgakses');
        if(!isset($_GET['kodejob1'])){
          $akpeg1 = $akpeg;
        } else {
          $akpeg1 = $_GET['kodejob1'];
        }
        $supeg = $this->session->userdata('pgsu');
        switch ($akpeg) {
          case '111':
          $vtitle = 'Kepegawaian';
          break;

          case '222':
          $vtitle = 'Administrasi';
          break;

          default:
          $vtitle = 'QMARSUPIUM - 2024';
          break;
        }
        if($idpeg!='') {
$thn = date("Y");
$hrni = date("Y-m-d");
            $data = array(
                'qtitle' => $vtitle,
                'rmmod' => $rmoda,
                'hasil' => '',
                'periksa' => '',
                'operator' => $this->dbcore1->caripeg($idpeg),
                'kodejob' => $akpeg,
                'kodejob1' => $akpeg1,
                'kodesu' => $supeg,
                'dafkodejur' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->carikodejur():'',
                'pjenis' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_ka5('L'):'',
                'dkpoli' => $this->transisi->get_dkpoli(),
                'dkbangsal' => '',
                'jjenis' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis():'',
//                'jjenis2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis2():'',
                'jka1' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka1():'',
                'jka2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka2():'',
                'jka3' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka3():'',
                'jka4' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka4():'',
                'akses' => $idpeg,
                'cgroup' => $this->pecahcgroup($akpeg),
                'cekabsen' => $this->absen_model->cek_data_absen($hrni),
                'idpeg' => $idpeg
            );
            $this->load->view('backoff/rm_infor',$data);
        } else {
            $this->load->view('frontoff/login');
        }
    }

    function get_keu(){
      $iparam1 = $this->input->post('katcari');
      $iparam2 = $this->input->post('valcari');
      $iparam3 = $this->dbcore1->routekey(get_cookie('seto'),'d');
      $hitdata = $this->proreports->hitungtrx($iparam1,$iparam2,$iparam3);
      if($hitdata){
        echo json_encode($hitdata);
      } else {
        return false;
      }
    }

    function cgbulan(){
      echo json_encode(nama_bulan($this->input->post('blnnum')));
    }

    function hitbulan(){
      $partgl = $this->input->post('blnthn');
      echo json_encode(days_in_month(substr($partgl,4,strlen($partgl)-4),substr($partgl,0,4)));
    }


    function filltemp1($ar = FALSE){
      $idpeg = $this->session->userdata('pgpid');
      $this->proreports->_deltbner($idpeg);
      $this->proreports->_isitbner1($ar,$idpeg);
      $list = $this->proreports->filltemp1($ar,$idpeg);
      $data = array();
      $no = $_POST['start'];
      foreach ($list as $jurnal) {
        if($jurnal->temp1_noper != ''){
          $getnamaka2 = $this->akuntansi->get_vka2(substr($jurnal->temp1_noper,0,2).'0');
          $getnamaka3 = $this->akuntansi->get_vka3(substr($jurnal->temp1_noper,0,3));
          $setnamaka2 = $getnamaka2['ka_nama'];
          $setnamaka3 = $getnamaka3['ka_nama'];
        }
        if($jurnal->temp1_perk=='SUBTOTAL-1'){
          $kirimperk = '>'.$setnamaka3;
          $setnamaka2 = 'SUBTOTAL-1';
          $setnamaka3 = '';
        } else if($jurnal->temp1_perk=='SUBTOTAL-2'){
          $kirimperk = '*'.$setnamaka2;
          $setnamaka2 = 'SUBTOTAL-2';
          $setnamaka3 = '';
        } else {
          $kirimperk = '-'.$jurnal->temp1_perk;
        }
        $no++;
        $row = array();
        $row[] = $jurnal->temp1_urut;
        $row[] = $setnamaka2;
        $row[] = $setnamaka3;
        $row[] = $jurnal->temp1_noper;
        $row[] = $kirimperk;
        $row[] = floatval($jurnal->temp1_da);
        $row[] = floatval($jurnal->temp1_ka);
        $row[] = floatval($jurnal->temp1_db);
        $row[] = floatval($jurnal->temp1_kb);
        $row[] = floatval($jurnal->temp1_dc);
        $row[] = floatval($jurnal->temp1_kc);
        $data[] = $row;
      }

    $output = array(
            "draw" => $_POST['draw'],
  //          "recordsTotal" => $this->akuntansi->count_all($ar),
  //          "recordsFiltered" => $this->akuntansi->count_filtered($ar),
            "data" => $data
        );
    echo json_encode($output);

        }

        public function hitcharts()
        {
            $arrch = [];
            $arrperi[] = 'periode';
            $cekset = $this->dbcore1->routekey(get_cookie('simakses'),'d');
            $setperi = $this
                ->proreports
                ->setperi($cekset);
            foreach ($setperi as $gperi)
            {
                $arrperi[] = $gperi['peri'];
            }
            $arrkm[] = 'Kas Masuk';
            $setkm = $this
                ->proreports
                ->setkm($cekset);
            foreach ($setkm as $gkm)
            {
                $arrkm[] = $gkm['jkm'];
            }
            $arrkk[] = 'Kas Keluar';
            $setkk = $this
                ->proreports
                ->setkk($cekset);
            foreach ($setkk as $gkk)
            {
                $arrkk[] = $gkk['jkk'];
            }
            $arrtm[] = 'By/Beban';
            $settm = $this
                ->proreports
                ->settm($cekset);
            foreach ($settm as $gtm)
            {
                $arrtm[] = $gtm['jtm'];
            }
            $arrch[] = $arrperi;
            $arrch[] = $arrkm;
            $arrch[] = $arrkk;
            $arrch[] = $arrtm;
            echo json_encode($arrch, true);
        }

}
