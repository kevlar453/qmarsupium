<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true ");
header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Depth,User-Agent, X-File-Size, X-Requested-With, If-Modified-Since,X-File-Name, Cache-Control");

defined('BASEPATH') OR exit('No direct script access allowed');

class Proeksternal extends CI_Controller {
  private $filename = "import_data"; // Kita tentukan nama filenya

	public function __construct() {
		parent::__construct();
		$this->load->model('dbcore1','',TRUE);
    $this->load->model('dbeksternal','',TRUE);
    $this->load->model('akuntansi','',TRUE);
    $this->load->model('proreports','',TRUE);
		$this->load->helper('url','form');
	}

	public function index() {
//    $data['siswa'] = $this->SiswaModel->view();
//    $this->load->view('view', $data);

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
      $vtitle = 'Pasien RM';
      break;
    }
    if($idpeg!='') {
//          $idpeg = $this->session->userdata('pgpid');
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
//            'jjenis2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->jur_jenis2():'',
            'jka1' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka1():'',
            'jka2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka2():'',
            'jka3' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka3():'',
            'jka4' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->get_vka4():'',
            's1' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->j_hit():'',
            's2' => $akpeg=='222'||$akpeg1=='222'?$this->akuntansi->t_hit():'',
            'akses' => $idpeg,
//            'cgroup' => $this->pecahcgroup($akpeg),
//            'cekabsen' => $this->absen_model->cek_data_absen($hrni),
            'grbardeb' => $this->akuntansi->get_info($thn.'paktrx_jum'),
            'grbarkre' => $this->akuntansi->get_info($thn.'qaktrx_jum'),
            'idpeg' => $idpeg
        );
        $this->load->view('backoff/rm_infor',$data);
    } else {
        $this->load->view('frontoff/login');
    }
  }

  public function proses() {
    $config['upload_path'] = './dapur0/semstorage/';
    $config['allowed_types'] = 'xls';
    $config['max_size'] = '10000';
    $this->load->library('upload', $config);

    if ( $this->upload->do_upload('file')) {
      $upload_data = $this->upload->data();

      $this->load->library('Excel_reader');

      $this->excel_reader->setOutputEncoding('230787');
      $file = $upload_data['full_path'];
      $this->excel_reader->read($file);
      error_reporting(E_ALL ^ E_NOTICE);

      $data = $this->excel_reader->sheets[0];
      $dataexcel = Array();
      for ($i = 1; $i <= $data['numRows']; $i++) {
        if ($data['cells'][$i][2] == '')
        break;
        $dataexcel[$i - 1]['ecol1'] = $data['cells'][$i][1];
        $dataexcel[$i - 1]['ecol2'] = $data['cells'][$i][3];
        //                 $dataexcel[$i - 1]['ecol2'] = date('Y-m-d',strtotime($data['cells'][$i][3]));
        $dataexcel[$i - 1]['ecol3'] = $data['cells'][$i][4];
        $dataexcel[$i - 1]['ecol4'] = $data['cells'][$i][5];
        $dataexcel[$i - 1]['ecol5'] = str_replace('/','.',$data['cells'][$i][6]);
        $dataexcel[$i - 1]['ecol6'] = $data['cells'][$i][7];
        $dataexcel[$i - 1]['ecol7'] = $data['cells'][$i][8];
        $dataexcel[$i - 1]['ecol8'] = $data['cells'][$i][9];
      }

      $this->load->model('dbeksternal');
      $this->dbeksternal->loaddata($dataexcel);

      $file = $upload_data['file_name'];
      $path = './dapur0/semstorage/' . $file;
      unlink($path);
    }
    //          $this->dbeksternal->cdataexcel();
    /*          $isiexcel = $this->dbeksternal->cdataexcel();
    foreach ($isiexcel as $iexc) {
    # code...
    }
    */
    redirect('markas/core1/?rmod=area2','refresh');
  }

  function expkey($idcek = FALSE){
    $this->load->library('javascript');
    $nama =str_replace('.','',$idcek).'.qkey';
    $path = './dapur0/semstorage/post/'.$nama;
    //array induk
    $aldata = array();
    $aldata['alamat'] = $nama;
    $isidata = array();
    //array kopar
    $isidata['users'] = $this->proreports->get_user($idcek);

    $cvdataisi = json_encode($isidata, JSON_PRETTY_PRINT);
    write_file($path,$cvdataisi,'wb');
    //$this->downex($path2);
    echo json_encode($aldata);
  }


  function exjson(){
    $cekusr = $this->dbcore1->routekey(get_cookie('simcek1'),'d');
    $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('jspil',$this->dbcore1->routekey($cekkop));
    $this->load->library('javascript');
    $path2 = $cekkop.date('Ymdh').str_replace('.','',$cekusr).'.qbk';
    $pathA = './dapur0/semstorage/post/'.$cekkop.date('Ymdh').str_replace('.','',$cekusr).'.part';
    $pathB = './dapur0/semstorage/post/'.$cekkop.date('Ymdh').str_replace('.','',$cekusr).'.qbk';
    //array induk
    $isidata = array();
    //array kopar
    $isidata['kopar'] = array('kodepar'=>$cekkop);
    //array var_ka-5
    $isidata['arrvar_ka5'] = $this->akuntansi->jur_jenis3();
    //array var_jur
    $isidata['arrvar_jur'] = $this->akuntansi->jur_jenis_all();
    //array akun_jur
    $isidata['arrakn_jur'] = $this->akuntansi->exj_part();
    //array akun_trx
    $isidata['arrakn_trx'] = $this->akuntansi->ext_part();
    //array jur_posting
    //    $isidata['arrakn_post'] = $this->akuntansi->c_post();
    $cvdataisi = json_encode($isidata, JSON_PRETTY_PRINT);
    //     write_file($path,$this->dbcore1->routekey($cvdataisi),'wb');
    write_file($pathA,$cvdataisi,'wb');
    //    $defile = $this->dbcore1->routekey(read_file($pathA),'d');
    $defile = read_file($pathA);
    //    $defile2 = read_file($pathA);

    //    $arrpost = json_decode($defile)->arrakn_jur;
    $carrpost = array();
    //    foreach ($arrpost as $ap) {
    //      $carrpost[] = $ap->akjur_nomor;
    //    }
    //    $this->akuntansi->clear_dataup($carrpost);

    //    $setjum = array();
    $arrarrvar_ka5 = json_decode($defile)->arrvar_ka5;
    $isidata['arrarrvar_ka5'] = array('jum_ka5'=>count($arrarrvar_ka5));

    $arrarrakn_jur = json_decode($defile)->arrakn_jur;
    $isidata['arrarrakn_jur'] = array('jum_jur'=>count($arrarrakn_jur));

    $arrarrakn_trx = json_decode($defile)->arrakn_trx;
    $isidata['arrarrakn_trx'] = array('jum_trx'=>count($arrarrakn_trx));

    $arrarrakn_jur = json_decode($defile)->arrakn_jur;
    $isidata['arrarrakn_jur'] = array('jum_jurp'=>count($arrarrakn_jur));

    $arrarrakn_trx = json_decode($defile)->arrakn_trx;
    $isidata['arrarrakn_trx'] = array('jum_trxp'=>count($arrarrakn_trx));

    //    write_file($pathB,$this->dbcore1->routekey($defile),'wb');
    $defile2 = json_encode($isidata, JSON_PRETTY_PRINT);
    //write_file($pathB,$this->dbcore1->routekey($defile2),'wb');
    write_file($pathB,$defile2,'wb');

    //$this->dbcore1->delcok('jspil');
    //    $this->downex($path);
    unlink($pathA);

    //$this->downex($path2);
    echo $path2;
  }

  function download_plus_headers($filename = FALSE)
  {
    if(!$filename){
      $filename = $this->input->post('nmfile');
    }
    // disable caching
  	$now = gmdate("D, d M Y H:i:s");
    header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
  	header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
  	header("Last-Modified: {$now} GMT");

  	// force download
  	header("Content-Type: application/force-download");
  	header("Content-Type: application/octet-stream");
  	header("Content-Type: application/download");
    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
    echo $this->dbcore1->routekey(read_file('./dapur0/semstorage/post/'.$filename));

    unlink('./dapur0/semstorage/post/'.$filename);

//    force_download('/dapur0/semstorage/post/'.$filename,NULL,TRUE);
  }

  function hpsback($filename){
//    unlink('./dapur0/semstorage/post/'.$filename);
  }

  function imjson(){
    $cekusr = $this->dbcore1->routekey(get_cookie('simcek1'),'d');
    $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('jspil',$this->dbcore1->routekey($cekkop));
    $config['upload_path'] = './dapur0/semstorage/';
    $config['allowed_types'] = '*';
    $config['max_size'] = 0;
    $this->load->library('upload', $config);

    if ( $this->upload->do_upload('fileqbk')) {
      $upload_data = $this->upload->data();
      $path2 = './dapur0/semstorage/post/filerestore.bak';

      $file = $upload_data['file_name'];
      $path = './dapur0/semstorage/' . $file;
      $defile = $this->dbcore1->routekey(read_file($path),'d');
      write_file($path2,$defile,'wb');

      $arrpost = json_decode($defile)->arrakn_jur;
      $carrpost = array();
      foreach ($arrpost as $ap) {
        $carrpost[] = $ap->akjur_nomor;
      }
      $this->akuntansi->clear_dataup($carrpost);

      $setjum = array();
      $arrarrvar_ka5 = json_decode($defile)->arrvar_ka5;
      $setjum['arrarrvar_ka5'] = count($arrarrvar_ka5);

      $arrarrakn_jur = json_decode($defile)->arrakn_jur;
      $setjum['arrarrakn_jur'] = count($arrarrakn_jur);

      $arrarrakn_trx = json_decode($defile)->arrakn_trx;
      $setjum['arrarrakn_trx'] = count($arrarrakn_trx);

      $arrarrakn_jur = json_decode($defile)->arrakn_jur;
      $setjum['arrarrakn_jur'] = count($arrarrakn_jur);

      $arrarrakn_trx = json_decode($defile)->arrakn_trx;
      $setjum['arrarrakn_trx'] = count($arrarrakn_trx);

      echo json_encode($setjum);

    }
  }

  function prosesimj001(){
    $cekusr = $this->dbcore1->routekey(get_cookie('simcek1'),'d');
    $cekkel = $this->dbcore1->routekey(get_cookie('simakses'),'d');
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('jspil',$this->dbcore1->routekey($cekkop));
    $config['upload_path'] = './dapur0/semstorage/';
    $config['allowed_types'] = '*';
    $config['max_size'] = 0;
    $this->load->library('upload', $config);

    if ( $this->upload->do_upload('fileqbk')) {
      $upload_data = $this->upload->data();
      $path2 = './dapur0/semstorage/post/filerestore.bak';

      $file = $upload_data['file_name'];
      $path = './dapur0/semstorage/' . $file;
      $defile = $this->dbcore1->routekey(read_file($path),'d');
      $arrcek = json_decode($defile)->kopar;
      if($arrcek->kodepar != $cekkop){
        $this->dbcore1->simcok('nofile','GAGAL');
        redirect('markas/core1/?rmod=area2','refresh');
      }

      write_file($path2,$defile,'wb');
      $this->dbcore1->simcok('cfile',$file);
      $this->dbcore1->simcok('vfile','002');
//      $this->dbcore1->simcok('cfile',$file);
//      $arrpost = str_replace('[', '', str_replace(']', '', json_encode(json_decode($defile)->arrakn_jur)));
//$hitwkt = (int)json_decode($defile)['arrarrvar_ka5']+(int)json_decode($defile)['arrarrakn_jur']+(int)json_decode($defile)['arrarrakn_trx'];
$this->dbcore1->simcok('hitjum',15000);
$this->dbcore1->simcok('detproses','pre-sync');
      $arrpost = json_decode($defile)->arrakn_jur;
      $carrpost = array();
      foreach ($arrpost as $ap) {
        $carrpost[] = $ap->akjur_nomor;
      }
      $this->akuntansi->clear_dataup($carrpost);

      $arrpost = json_decode($defile)->arrvar_ka5;
      $setka5 = array();
      $this->dbcore1->simcok('detproses','variabel');
      $hitjum = 0;
      foreach ($arrpost as $ap) {
        $carrpost = array();
        if(substr($ap->ka_5,0,2) == $cekkel){
            $carrpost[] = $ap->ka_1;
            $carrpost[] = $ap->ka_2;
            $carrpost[] = $ap->ka_3;
            $carrpost[] = $ap->ka_4;
            $carrpost[] = $ap->ka_5;
            $carrpost[] = $ap->ka_nama;
            $carrpost[] = (int)$ap->ka_saldoawal;

          $setka5[] = $carrpost;
          $hitjum++;
        }
      }
      if($hitjum >0){
        $this->akuntansi->inska5_dataup($setka5);
      }


      redirect('markas/core1/?rmod=area2','refresh');
    } else {
      redirect('markas/core1/?rmod=area1','refresh');
    }
  }

  function prosesimj002(){
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('vfile','003');
    $file = $this->dbcore1->getcok('cfile');
    $path = './dapur0/semstorage/' . $file;
    $defile = $this->dbcore1->routekey(read_file($path),'d');
          $tarrpost = json_decode($defile)->arrakn_jur;
          $setjur = array();
          $this->dbcore1->simcok('detproses','jurnal');
          $jumhit = 0;
          foreach ($tarrpost as $apt) {
            $jcarr = array();
            if($apt->akjur_kopar == $cekkop){
                $jcarr[] = $apt->akjur_nomor;
                $jcarr[] = $apt->akjur_jns;
                $jcarr[] = $apt->akjur_tgl;
                $jcarr[] = $apt->akjur_ket;
                $jcarr[] = $apt->akjur_sts;
                $jcarr[] = $apt->akjur_post;
                $jcarr[] = $apt->akjur_akses;
                $jcarr[] = $apt->akjur_kopar;

              $setjur[] = $jcarr;
              $jumhit++;
            }
          }
          if($jumhit>0){
            $this->akuntansi->insjur_dataup($setjur);
          }
//            redirect('markas/core1/?rmod=area2','refresh');
  }

  function prosesimj003(){
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('vfile','004');
    $file = $this->dbcore1->getcok('cfile');
    $path = './dapur0/semstorage/' . $file;
    $defile = $this->dbcore1->routekey(read_file($path),'d');
    $tarrpost = json_decode($defile)->arrakn_trx;
    $settrx = array();
    $this->dbcore1->simcok('detproses','transaksi');
    $jumhit = 0;
    foreach ($tarrpost as $apt) {
      $tcarr = array();
      if($apt->akjur_kopar == $cekkop){
          $tcarr[] = $apt->aktrx_nomor;
          $tcarr[] = $apt->aktrx_nojur;
          $tcarr[] = $apt->aktrx_nama;
          $tcarr[] = $apt->aktrx_jns;
          $tcarr[] = $apt->aktrx_ket;
          $tcarr[] = (int)$apt->aktrx_jum;
          $tcarr[] = $apt->aktrx_akses;
          $tcarr[] = $apt->aktrx_mark;
          $tcarr[] = $apt->aktrx_post;
          $tcarr[] = $apt->akjur_kopar;

        $settrx[] = $tcarr;
        $jumhit++;
      }
    }
    if($jumhit>0){
      $this->akuntansi->instrx_dataup($settrx);
    }
//    redirect('markas/core1/?rmod=area2','refresh');
  }

  function prosesimj004(){
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $this->dbcore1->simcok('vfile','005');
    $file = $this->dbcore1->getcok('cfile');
    $path = './dapur0/semstorage/' . $file;
    $defile = $this->dbcore1->routekey(read_file($path),'d');
    $tarrpost = json_decode($defile)->arrakn_jur;
    $setjurp = array();
    $this->dbcore1->simcok('detproses','jurnal-terposting');
    $jumhit = 0;
    foreach ($tarrpost as $apt) {
      $jpcarr = array();
      if($apt->akjur_sts == 0 && $apt->akjur_post == 1 && $apt->akjur_kopar == $cekkop){
          $jpcarr[] = $apt->akjur_nomor;
          $jpcarr[] = $apt->akjur_jns;
          $jpcarr[] = $apt->akjur_tgl;
          $jpcarr[] = $apt->akjur_ket;
          $jpcarr[] = $apt->akjur_sts;
          $jpcarr[] = 0;
          $jpcarr[] = $apt->akjur_akses;
          $jpcarr[] = $apt->akjur_kopar;

        $setjurp[] = $jpcarr;
        $jumhit++;
      }
    }
    if($jumhit>0){
      $this->akuntansi->insjurpost_dataup($setjurp);
    }
//    redirect('markas/core1/?rmod=area2','refresh');
  }

  function prosesimj005(){
    $cekkop = $this->dbcore1->routekey(get_cookie('simkop'),'d');
    $file = $this->dbcore1->getcok('cfile');
    $path = './dapur0/semstorage/' . $file;
    $defile = $this->dbcore1->routekey(read_file($path),'d');
    $tarrpost = json_decode($defile)->arrakn_trx;
    $settrxp = array();
    $jumhit = 0;
    foreach ($tarrpost as $apt) {
      $tpcarr = array();
      if($apt->aktrx_mark == 0 && $apt->aktrx_post == 1 && $apt->akjur_kopar == $cekkop){
          $tpcarr[] = $apt->aktrx_nomor;
          $tpcarr[] = $apt->aktrx_nojur;
          $tpcarr[] = $apt->aktrx_nama;
          $tpcarr[] = $apt->aktrx_jns;
          $tpcarr[] = $apt->aktrx_ket;
          $tpcarr[] = (int)$apt->aktrx_jum;
          $tpcarr[] = $apt->aktrx_akses;
          $tpcarr[] = $apt->aktrx_mark;
          $tpcarr[] = 0;
          $tpcarr[] = $apt->akjur_kopar;

        $settrxp[] = $tpcarr;
        $jumhit++;
      }
      $this->dbcore1->simcok('detproses','transaksi-terposting');
    }
    if($jumhit > 0){
      $this->akuntansi->instrxpost_dataup($settrxp);
    }
    $this->dbcore1->delcok('cfile');
    $this->dbcore1->delcok('vfile');

    unlink($path);
//    redirect('markas/core1/?rmod=area2','refresh');
  }


  function downex($path){
    force_download($path,NULL,TRUE);
  }


}
