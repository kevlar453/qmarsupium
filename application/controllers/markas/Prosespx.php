<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prosespx extends CI_Controller {

  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->model('transisi','',TRUE);
    $this->load->helper('url','form');
//    $this->load->library('session');
    $this->load->database();
  }

	public function index() {
    $cek1 = isset($_GET['name'])==TRUE?$_GET["name"]:$this->input->post('name');
    $cek2 = isset($_GET['rmod'])==TRUE?$_GET["rmod"]:$this->input->post('rmod');
    $hcari = $this->dbcore1->caripx($cek1);
    $arsip = $this->dbcore1->cariarsip($hcari['pxpidrs']);
    $idpeg = $this->session->userdata('pgpid');
    $akpeg = $this->session->userdata('pgakses');
		if(!isset($_GET['kodejob1'])){
			$akpeg1 = $akpeg;
		} else {
			$akpeg1 = $_GET['kodejob1'];
		}
    $akpeg1 = $akpeg!='000'?'000':$akpeg;
    $supeg = $this->session->userdata('pgsu');
      $data = array(
      	'qtitle' => 'Pasien RM',
      	'rmmod' => $cek2,
      	'hasil' => $hcari,
      	'arsip' => $arsip,
      	'arsipoprt' => $this->dbcore1->namaoprt($arsip['pdpoprt']),
      	'arsippinjam' => $this->dbcore1->namapinjam($arsip['pdppinjam']),
        'operator' => $this->dbcore1->caripeg($idpeg),
        'kodejob' => $akpeg,
        'kodejob1' => $akpeg1,
        'kodesu' => $supeg,
        'akses' => $idpeg,
        'idpeg' => $idpeg,
        'vkunjung' => $this->dbcore1->tbumum('qvar_umum','varid',$hcari['pxpkunjungan']),
        'lagama' => $this->dbcore1->get_agama(),
        'lsuku' => $this->dbcore1->get_suku(),
        'ldik' => $this->dbcore1->get_pendidikan(),
        'lkrj' => $this->dbcore1->get_pekerjaan(),
        'poliklinik' => $this->dbcore1->get_poliklinik(),
        'negara' => $this->dbcore1->get_negara(),
        'propinsi' => $this->dbcore1->get_propinsi($hcari['pxpneg']),
        'kabupaten' => $this->dbcore1->get_kabupaten($hcari['pxpprp']),
        'kecamatan' => $this->dbcore1->get_kecamatan($hcari['pxpkab']),
        'desa' => $this->dbcore1->get_desa($hcari['pxpkec'])
      );
		$this->load->view('backoff/rm_infor',$data);


/*
    $this->db->select('*');
    $this->db->from('qmain_pxprofile_pri');
    $query = $this->db->get();
    $data = array(
      'qtitle' => 'Pasien RM',
      'rmmod' => isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'',
      'periksa' => '',
      'poliklinik' => $this->db->order_by('varid','asc')->get('qvar_poli'),
      'result' => $query->result()
    );
		$this->load->view('backoff/rm_infor',$data);
*/
	}

  function hisrawat($pxdata = FALSE){
    $pxrm = substr($pxdata,0,6);
    $pxjen = substr($pxdata,-2);
    $list = $this->transisi->hisrawat($pxdata);

    $data = array();
    $no = $_POST['start'];
    foreach ($list as $rwt) {
      if($pxjen == 'ri') {
        $yos = array('0'=>'1','1'=>'2','2'=>'3','3'=>'4','4'=>'5','5'=>'6','6'=>'25','7'=>'24','8'=>'20','9'=>'22','10'=>'23','11'=>'17','12'=>'18','13'=>'19','14'=>'15');
        $hel = array('0'=>'21','1'=>'16','2'=>'14','3'=>'14A','4'=>'B14','5'=>'B16','6'=>'B21');
        $mik = array('0'=>'7','1'=>'8','2'=>'9','3'=>'10','4'=>'11','5'=>'12');
        if(array_search($rwt->kamar,$yos)){
          $bangsal = 'Yosefa';
        } elseif(array_search($rwt->kamar,$hel)){
          $bangsal = 'Helena';
        } else {
          $bangsal = 'Mikaela';
        }
        if($rwt->asal=='PAV2'){
          $varbang = 'dbangsaldua';
        } else {
          $varbang = 'dbangsal';
        }
        $regis = $rwt->noreg;
        $tglprik = date('d-m-Y',strtotime($rwt->tglmasuk));
        $nmasal = $bangsal;
        $ddiag = $this->transisi->get_crdiag($rwt->noreg.$varbang);
        $cdiag = '['.$ddiag['kddiag'].'] '.$ddiag['diag'];
        $ddok = $this->transisi->get_crdok($rwt->noreg.$varbang);
        $cdok = '['.$ddok['kddok'].'] '.$ddok['nmdok'];
      } else {
        if($rwt){
          $regis = $rwt->noreg;
          $nmasal = strtoupper($rwt->namapoli);
          $ddiag = $this->transisi->get_crdiag($rwt->noreg.str_replace('antrian','d',$rwt->antrian));
          $cdiag = '['.$ddiag['kddiag'].'] '.$ddiag['diag'];
          $ddok = $this->transisi->get_crdok($rwt->noreg.str_replace('antrian','d',$rwt->antrian));
          $cdok = '['.$ddok['kddok'].'] '.$ddok['nmdok'];
          $tglprik = date('d-m-Y',strtotime($rwt->tglperiksa));
        } else {
          $regis = '---';
          $nmasal = '---';
          $cdiag = '---';
          $cdok = '---';
          $tglprik = '---';
        }
      }

      $no++;
      $row = array();
      $row[] = $no;
      $row[] = $regis;
      $row[] = $nmasal;
      $row[] = $tglprik;
      $row[] = $cdiag;
      $row[] = $cdok;
      $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->transisi->lappxrm_all($pxdata),
        "recordsFiltered" => $this->transisi->lappxrm_filtered($pxdata),
        "data" => $data
      );
      echo json_encode($output);
    }


	public function cekpx()	{
    $cek1 = isset($_GET['name'])==TRUE?$_GET["name"]:$this->input->post('name');
    $hcari = $this->dbcore1->caripx($cek1);
    $arsip = $this->dbcore1->cariarsip($hcari['pxpidrs']);
    $idpeg = $this->session->userdata('pgpid');
    $akpeg = $this->session->userdata('pgakses');
		if(!isset($_GET['kodejob1'])){
			$akpeg1 = $akpeg;
		} else {
			$akpeg1 = $_GET['kodejob1'];
		}
    $supeg = $this->session->userdata('pgsu');
      $data = array(
      	'qtitle' => 'Pasien RM',
      	'rmmod' => isset($_GET['rmod'])==TRUE?$_GET["rmod"]:'',
      	'hasil' => $hcari,
      	'arsip' => $arsip,
      	'arsipoprt' => $this->dbcore1->namaoprt($arsip['pdpoprt']),
      	'arsippinjam' => $this->dbcore1->namapinjam($arsip['pdppinjam']),
        'operator' => $this->dbcore1->caripeg($idpeg),
        'kodejob' => $akpeg,
        'kodejob1' => $akpeg1,
        'kodesu' => $supeg,
        'akses' => $idpeg,
        'idpeg' => $idpeg,
        'vkunjung' => $this->dbcore1->tbumum('qvar_umum','varid',$hcari['pxpkunjungan']),
        'lagama' => $this->dbcore1->get_agama(),
        'lsuku' => $this->dbcore1->get_suku(),
        'ldik' => $this->dbcore1->get_pendidikan(),
        'lkrj' => $this->dbcore1->get_pekerjaan(),
        'poliklinik' => $this->dbcore1->get_poliklinik(),
        'negara' => $this->dbcore1->get_negara(),
        'propinsi' => $this->dbcore1->get_propinsi($hcari['pxpneg']),
        'kabupaten' => $this->dbcore1->get_kabupaten($hcari['pxpprp']),
        'kecamatan' => $this->dbcore1->get_kecamatan($hcari['pxpkab']),
        'desa' => $this->dbcore1->get_desa($hcari['pxpkec'])
      );
		$this->load->view('backoff/rm_infor',$data);

//Either you can print value or you can send value to database
//echo json_encode($data);
	}

function get_propinsi($negara){
// $this->load->model('city_model');
 header('Content-Type: application/x-json; charset=utf-8');
 echo(json_encode($this->dbcore1->get_propinsi($negara)));
}

function get_kabupaten($propinsi){
// $this->load->model('city_model');
 header('Content-Type: application/x-json; charset=utf-8');
 echo(json_encode($this->dbcore1->get_kabupaten($propinsi)));
}

function get_kecamatan($kabupaten){
// $this->load->model('city_model');
 header('Content-Type: application/x-json; charset=utf-8');
 echo(json_encode($this->dbcore1->get_kecamatan($kabupaten)));
}

function get_desa($kecamatan){
// $this->load->model('city_model');
 header('Content-Type: application/x-json; charset=utf-8');
 echo(json_encode($this->dbcore1->get_desa($kecamatan)));
}

                public function deleteDomain($id)
                  {
                    //echo $id;die;
                    $this->db->where('id',$id);
                    $this->db->delete('ml_subdomains');
                    die;

                  }
                public function updateDomain($id)
                {
                        $data = array('subdomain_name'=>$this->input->post('domain_name'),
                        'user_name'=>$this->input->post('user_name'),
                        'email'=>$this->input->post('email'),
                        'contact_no'=>$this->input->post('contact_no'),
                        'price'=>$this->input->post('price'),
                        );
                        //echo "<pre>";
                        //print_r($data);die;
                        $this->db->where('id',$id);
                        $this->db->update('ml_subdomains',$data);
                        $this->db->select('*');
                        $this->db->where('id',$id);
                        $this->db->from('ml_subdomains');
                        $query = $this->db->get();
                        $result = $query->result();
                        //print_r($result );
                        //echo $result[0]->id;die;
                        echo $html = "<tr id='domain".$id."'>
                        <td style='width:360px'>".$result[0]->user_name."</td>
                        <td style='width:360px'>".$result[0]->contact_no."</td>
                        <td style='width:360px'>".$result[0]->email."</td>
                        <td style='width:360px'>".$result[0]->price."</td>
                        <td style='width:360px'>
                        <a href='javascript:void(0)' title='Edit' onclick='editDomain(".$id.")' class='icon-1 info-tooltip'>Edit</a>
                        <a href='javascript:void(0)' onclick='deleteDomain(".$id.")'  title='Delete' class='icon-2 info-tooltip'>Delete</a>
                    <a href='javascript:void(0) class='hide' id='".$id."'></a>
                    </td>
                    </tr>";
            }

        public function editDomain($id){
        $isineg = $this->dbcore1->get_negara();
    $this->db->select('qmain_pxprofile_pri.*');
    $this->db->select('DATE_FORMAT(CURDATE(), \'%Y\') - DATE_FORMAT(qmain_pxprofile_pri.pxptglhr, \'%Y\') - (DATE_FORMAT(CURDATE(), \'00-%m-%d\') < DATE_FORMAT(qmain_pxprofile_pri.pxptglhr, \'00-%m-%d\')) AS pxputh');
    $this->db->select('TIMESTAMPDIFF( MONTH, qmain_pxprofile_pri.pxptglhr, CURDATE() ) % 12 AS pxpubl');
    $this->db->select('FLOOR( TIMESTAMPDIFF( DAY, qmain_pxprofile_pri.pxptglhr, CURDATE() ) % 30.4375 ) AS pxpuhr');
    $this->db->select('qmain_pxprofile_kel.*');
    $this->db->select('qmain_pxprofile_tgg.*');
    $this->db->select('LEFT(qvar_dtpx.pdppos,2) as vdtrak');
    $this->db->select('RIGHT(qvar_dtpx.pdppos,2) as vdtbar');
    $this->db->select('qvar_dtpx.varUPDATE as vdtup');
    $this->db->select('qvar_desa.namades as vdes');
    $this->db->select('qvar_kec.namakec as vkec');
    $this->db->select('qvar_kab.namakab as vkab');
    $this->db->select('qvar_prop.namaprp as vprp');
    $this->db->select('qvar_negara.varnama as vneg');
    $this->db->select('qvar_pekerjaan.varnama as vkrj');
    $this->db->select('qvar_pendidikan.varnama as vdik');
    $this->db->select('qvar_umum.varnama as vsts');
    $this->db->select('qvar_suku.varnama as vsuku');
    $this->db->select('qvar_agama.varnama as vagama');
    $this->db->from('qmain_pxprofile_pri');
    $this->db->join('qmain_pxprofile_kel', 'qmain_pxprofile_kel.pxkidrs = qmain_pxprofile_pri.pxpidrs','left');
    $this->db->join('qmain_pxprofile_tgg', 'qmain_pxprofile_tgg.pxtidrs = qmain_pxprofile_pri.pxpidrs','left');
    $this->db->join('qvar_desa', 'qvar_desa.id = qmain_pxprofile_pri.pxpdes','left');
    $this->db->join('qvar_kec', 'qvar_kec.id = qmain_pxprofile_pri.pxpkec','left');
    $this->db->join('qvar_kab', 'qvar_kab.id = qmain_pxprofile_pri.pxpkab','left');
    $this->db->join('qvar_prop', 'qvar_prop.id = qmain_pxprofile_pri.pxpprp','left');
    $this->db->join('qvar_negara', 'qvar_negara.varid = qmain_pxprofile_pri.pxpneg','left');
    $this->db->join('qvar_pendidikan', 'qvar_pendidikan.varid = qmain_pxprofile_pri.pxpdik','left');
    $this->db->join('qvar_pekerjaan', 'qvar_pekerjaan.varid = qmain_pxprofile_pri.pxpkrj','left');
    $this->db->join('qvar_umum', 'qvar_umum.varid = qmain_pxprofile_pri.pxpstskw','left');
    $this->db->join('qvar_suku', 'qvar_suku.varid = qmain_pxprofile_pri.pxpsuku','left');
    $this->db->join('qvar_agama', 'qvar_agama.varid = qmain_pxprofile_pri.pxpagama','left');
    $this->db->join('qvar_dtpx', 'qvar_dtpx.pdpidpx = qmain_pxprofile_pri.pxpidrs','left');
    $this->db->where('qmain_pxprofile_pri.pxpidrs',$id);
                $query = $this->db->get();
                $result = $query->result();
                //print_r($result );die;

if($result[0]->pxpneg==''){
  $selneg='#';
  $negara['#'] = 'Pilih';
}else{
$negara = $this->dbcore1->get_negara();
  $selneg = $result[0]->pxpneg;
}

if($result[0]->pxpprp==''){
  $selprp='#';
  $propinsi['#'] = 'Pilih';
}else{
$propinsi = $this->dbcore1->get_propinsi($result[0]->pxpneg);
  $selprp = $result[0]->pxpprp;
}

if($result[0]->pxpkab==''){
  $selkab='#';
$kabupaten['#'] = 'Pilih';
}else{
$kabupaten = $this->dbcore1->get_kabupaten($result[0]->pxpprp);
$selkab = $result[0]->pxpkab;
}
if($result[0]->pxpkec==''){
  $selkec='#';
$kecamatan['#'] = 'Pilih';
}else{
$kecamatan = $this->dbcore1->get_kecamatan($result[0]->pxpkab);
$selkec = $result[0]->pxpkec;
}
if($result[0]->pxpdes==''){
  $seldes='#';
$desa['#'] = 'Pilih';
}else{
$desa = $this->dbcore1->get_desa($result[0]->pxpkec);
$seldes = $result[0]->pxpdes;
}

echo $html = '<div class="table-responsive" id="myForm'.$result[0]->pxpidrs.'">
                <form method="POST" role="form">
                <table class="updatedData'.$id.'">
    <tbody>
      <tr>
        <th class="col-md-2 col-sm-2 col-xs-6">Nama</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="inama" class="form-control" value="'.$result[0]->pxpnama.'"></td>
        <th class="col-md-2 col-sm-2 col-xs-6">Nama Ayah</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="user_name" class="form-control" value="'.$result[0]->pxknmayah.'"></td>
      </tr>
      <tr>
        <th class="col-md-2 col-sm-2 col-xs-6">Alamat</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="ialamat" class="form-control" value="'.$result[0]->pxpalamat.'"></td>
        <th class="col-md-2 col-sm-2 col-xs-6">Nama Ibu</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="user_name" class="form-control" value="'.$result[0]->pxknmibu.'"></td>
      </tr>
      <tr>
        <th class="col-md-2 col-sm-2 col-xs-6"></th><td></td>
        <td class="col-md-4 col-sm-4 col-xs-8">

'.
form_dropdown('pilnegara', $negara, $selneg, 'id="pilnegara" class="form-control"').
form_dropdown('pilprop', $propinsi, $selprp, 'id="pilprop" class="form-control"').
form_dropdown('pilkab', $kabupaten, $selkab, 'id="pilkab" class="form-control"').
form_dropdown('pilkec', $kecamatan, $selkec, 'id="pilkec" class="form-control"').
form_dropdown('pildesa', $desa, $seldes, 'id="pildesa" class="form-control"')
.'</div>

</td>
        <th class="col-md-2 col-sm-2 col-xs-6">Pendidikan</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="user_name" class="form-control" value="'.$result[0]->vdik.'"></td>
      </tr>
      <tr>
        <th class="col-md-2 col-sm-2 col-xs-6">Tetala</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="ilahir" class="form-control" value="'.$result[0]->pxptglhr.'"></td>
        <th class="col-md-2 col-sm-2 col-xs-6">Pekerjaan</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="user_name" class="form-control" value="'.$result[0]->vkrj.'"></td>
      </tr>
      <tr>
        <th class="col-md-2 col-sm-2 col-xs-6">Umur</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8">-----</td>
        <th class="col-md-2 col-sm-2 col-xs-6">Status</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="user_name" class="form-control" value="'.$result[0]->vsts.'"></td>
      </tr>
      <tr>
        <th class="col-md-2 col-sm-2 col-xs-6">Kontak</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="itelp" class="form-control" value="'.$result[0]->pxptelp.'">
        <input type="text" name="ihp" class="form-control" value="'.$result[0]->pxphp.'"></td>
      </tr>
      <tr>
        <th class="col-md-2 col-sm-2 col-xs-6">Agama</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="iagama" class="form-control" value="'.$result[0]->pxpagama.'"></td>
        <th class="col-md-2 col-sm-2 col-xs-6">Pekerjaan Suami</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="user_name" class="form-control" value="'.$result[0]->pxkkrjpsgn.'"></td>
      </tr>
      <tr>
        <th>Suku</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="isuku" class="form-control" value="'.$result[0]->pxpsuku.'"></td>
        <th class="col-md-2 col-sm-2 col-xs-6">Umur Suami</th><th>:</th>
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="user_name" class="form-control" value="'.$result[0]->pxkupsgn.'"></td>
      </tr>
</tbody>
  </table>

  </form>
<hr />
  <input type="button" value="Simpan" onclick="updateDomain('.$result[0]->pxpidrs.')" class="btn btn-success" />
            <a href=""   title="Batalkan" class="btn btn-default icon-1 info-tooltip">Batal</a>
            <a href="javascript:void(0)" class="hide" id="hide'.$result[0]->pxpidrs.'">Silahkan bersabar...</a>

  </div>
</div>
</div>';
            die;

          }


}
