<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('dbcore1','',TRUE);
    $this->load->model('absen_model','',TRUE);
    $this->load->model('akuntansi','',TRUE);
    $this->load->model('transisi','',TRUE);
		$this->load->model('person_model','',TRUE);
		$this->load->helper('url','form');
//    $this->dbmain = $this->load->database('default',TRUE);
	}

	public function index() {
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
//						'dafkodejur' => $akpeg=='222'?$this->akuntansi->carikodejur():'',
//						'pjenis' => $akpeg=='222'?$this->akuntansi->get_ka5('L'):'',
						'dkpoli' => $this->transisi->get_dkpoli(),
						'dkbangsal' => '',
//						'jjenis' => $akpeg=='222'?$this->akuntansi->jur_jenis():'',
//						'jjenis2' => $akpeg=='222'?$this->akuntansi->jur_jenis2():'',
//						'jka1' => $akpeg=='222'?$this->akuntansi->get_vka1():'',
//						'jka2' => $akpeg=='222'?$this->akuntansi->get_vka2():'',
//						'jka3' => $akpeg=='222'?$this->akuntansi->get_vka3():'',
//						'jka4' => $akpeg=='222'?$this->akuntansi->get_vka4():'',
//						's1' => $akpeg=='222'?$this->akuntansi->j_hit():'',
//						's2' => $akpeg=='222'?$this->akuntansi->t_hit():'',
						'akses' => $idpeg,
//						'cekabsen' => $this->absen_model->cek_data_absen($hrni),
//						'grbardeb' => floatval($this->akuntansi->get_info($thn.'paktrx_jum')),
//						'grbarkre' => floatval($this->akuntansi->get_info($thn.'qaktrx_jum')),
						'idpeg' => $idpeg
				);
				$this->load->view('backoff/rm_infor',$data);
		} else {
				$this->load->view('frontoff/login');
		}
	}

	public function ajax_list() {
		$list = $this->person_model->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {

            $jk = $person->pxpjk=='100'?'<a href="#" title="Laki-Laki"><i class="fa fa-male blue"></i></a>':'<a href="#" title="Perempuan"><i class="fa fa-female pink"></i></a>';
            $jk==''?'<a href="#" title="Tidak Jelas"><i class="fa fa-question"></i></a>':$jk;

            $almt=$person->pxpalamat==''?'<i class="fa fa-question-circle red"></i>':strtoupper($person->pxpalamat);
            $rtrw=$person->pxprtrw==''?'<br />RT/RW: <i class="fa fa-question-circle red"></i>, ':'<br />RT. '.substr($person->pxprtrw,2).'/RW. '.substr($person->pxprtrw,-2);
            $kel=$person->vdes==''?'Kel. <i class="fa fa-question-circle red"></i>, ':'Kel. '.strtoupper($person->vdes).', ';
            $kec=$person->vkec==''?'Kec. <i class="fa fa-question-circle red"></i>, ':'Kec. '.strtoupper($person->vkec).', ';
            $kab=$person->vkab==''?'Kab. <i class="fa fa-question-circle red"></i>, ':'Kab. '.strtoupper($person->vkab).', ';
            $prp=$person->vprp==''?'Prop. <i class="fa fa-question-circle red"></i>, ':'Prop. '.strtoupper($person->vprp);
            $kunj=$this->dbcore1->tbumum('qvar_umum','varid',$person->pxpkunjungan);

			$no++;
			$row = array();
			$row[] = $jk;
			$row[] = $person->pxpnama;
			$row[] = $person->pxputh.' th, '.$person->pxpubl.' bln, '.$person->pxpuhr.' hr';
			$row[] = $almt.$rtrw.' '.$kel.$kec.$kab.$prp;
			$row[] = $person->pxptplhr.', '.date("d-M-Y",strtotime($person->pxptglhr));
			$row[] = 'Telp. '.$person->pxptelp.' HP. '.$person->pxphp;
			$row[] = $person->vagama;
			$row[] = $person->vdik;
			$row[] = $person->vkrj;
			$row[] = $person->vsuku;
			$row[] = $kunj['varnama'];
			$row[] = '<a class="btn btn-sm btn-default" href="javascript:void(0)" title="Arsip" onclick="prosesarsip('."'".$person->pxpidrs."'".')"><i class="glyphicon glyphicon-tags"></i> Arsip</a><a class="btn btn-sm btn-primary" href="'.site_url("markas/prosespx/cekpx?rmod=area3&name=$person->pxpidrs").'" title="Detail" ><i class="glyphicon glyphicon-pencil"></i> Detail Data</a>';
//				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$person->id."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person_model->count_all(),
						"recordsFiltered" => $this->person_model->count_filtered(),
						"data" => $data
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->person_model->get_by_id($id);
		$data->pxptglhr = ($data->pxptglhr == '0000-00-00') ? '' : $data->pxptglhr; // if 0000-00-00 set tu empty for datepicker compatibility
		echo json_encode($data);
	}

	public function editarsip($id)
	{
		if($this->person_model->cektransrm($id)){
		$data = $this->person_model->cektransrm($id);
		} else {
		$data = $this->person_model->get_by_id($id);
		};
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$this->_validate();
		$data = array(
				'firstName' => $this->input->post('firstName'),
				'lastName' => $this->input->post('lastName'),
				'gender' => $this->input->post('gender'),
				'address' => $this->input->post('address'),
				'tgllahir' => $this->input->post('tgllahir'),
			);
		$insert = $this->person_model->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update() {
//		$this->_validate();
$tgll = $this->input->post('tgllahir');
		$data = array(
				'pxpidrs' => $this->input->post('drm'),
				'pxpidjkn' => $this->input->post('djkn'),
				'pxpidpri' => $this->input->post('dktp'),
				'pxpnama' => strtoupper($this->input->post('dnama')),
				'pxptplhr' => $this->input->post('dtlhr'),
				'pxptglhr' => substr($tgll,6,4).'-'.substr($tgll,3,2).'-'.substr($tgll,0,2),
				'pxpalamat' => $this->input->post('dalamat'),
				'pxprtrw' => $this->input->post('drt').$this->input->post('drw'),
				'pxptelp' => $this->input->post('dtlp'),
				'pxphp' => $this->input->post('dhp'),
				'pxpagama' => $this->input->post('dagama'),
				'pxpjk' => $this->input->post('djk'),
				'pxpsuku' => $this->input->post('dsuku'),
				'pxpdes' => $this->input->post('pildesa'),
				'pxpkec' => $this->input->post('pilkec'),
				'pxpkab' => $this->input->post('pilkab'),
				'pxpprp' => $this->input->post('pilprop'),
				'pxpneg' => $this->input->post('pilnegara'),
				'pxpdik' => $this->input->post('ddik'),
				'pxpkrj' => $this->input->post('dkrj')
			);
		$this->person_model->update(array('pxpidrs' => $this->input->post('drm')), $data);
		echo json_encode(array("status" => TRUE,'data' => $data));
	}

	public function update_dtpx() {
$pos1 = strlen($this->input->post('drak'))==1?'0'.$this->input->post('drak'):$this->input->post('drak');
$pos2 = strlen($this->input->post('dbar'))==1?'0'.$this->input->post('dbar'):$this->input->post('dbar');

		$data = array(
				'pdpidpx' => $this->input->post('drm'),
				'pdptgl' => $this->input->post('dtgl'),
				'pdppos' => $pos1.$pos2,
				'pdpoprt' => $this->input->post('doprt'),
			);
		$this->person_model->savearsip($data);
		echo json_encode(array("status" => TRUE,'data' => $data));
	}

	public function ajax_delete($id)
	{
		$this->person_model->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}


	private function _validate()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		if($this->input->post('firstName') == '')
		{
			$data['inputerror'][] = 'firstName';
			$data['error_string'][] = 'First name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('lastName') == '')
		{
			$data['inputerror'][] = 'lastName';
			$data['error_string'][] = 'Last name is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('tgllahir') == '')
		{
			$data['inputerror'][] = 'tgllahir';
			$data['error_string'][] = 'Date of Birth is required';
			$data['status'] = FALSE;
		}

		if($this->input->post('gender') == '')
		{
			$data['inputerror'][] = 'gender';
			$data['error_string'][] = 'Please select gender';
			$data['status'] = FALSE;
		}

		if($this->input->post('address') == '')
		{
			$data['inputerror'][] = 'address';
			$data['error_string'][] = 'Addess is required';
			$data['status'] = FALSE;
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}
	}

}
