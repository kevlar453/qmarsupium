<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Person_model extends CI_Model {

	function __construct(){
	parent::__construct();
	$this->load->helper('url','form');
//    $this->load->library('session');
	$this->dbmain = $this->load->database('default',TRUE);
	}

	var $table = 'qmain_pxprofile_pri';
	var $column_order = array('pxpjk','pxpnama','pxptglhr','pxpalamat','pxprtrw','pxpdes','pxpkec','pxpkab','pxpprp',null); //set column field database for datatable orderable
	var $column_search = array('pxpnama','pxpidrs'); //set column field database for datatable searchable just firstname , lastname , address are searchable
	var $order = array('pxpidrs' => 'desc'); // default order

	private function _get_datatables_query()
	{

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
	$this->dbmain->from($this->table);
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

		$i = 0;

		foreach ($this->column_search as $item) // loop column
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

				if(count($this->column_search) - 1 == $i) //last loop
					$this->dbmain->group_end(); //close bracket
			}
			$i++;
		}

		if(isset($_POST['order'])) // here order processing
		{
			$this->dbmain->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->dbmain->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->dbmain->limit($_POST['length'], $_POST['start']);

		$query = $this->dbmain->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->dbmain->get();
		return $query->num_rows();
	}

	public function count_all() {
		$this->dbmain->from($this->table);
		return $this->dbmain->count_all_results();
	}

	public function cektransrm($id) {
        $this->dbmain->from('qvar_dtpx');
        $this->dbmain->where('pdpidpx',$id);
        $query = $this->dbmain->get();
            if($query -> num_rows() >= 1){
                return $query->row_array();
            } else {
                return false;
            }
	}

	public function get_by_id($id) {
    $this->dbmain->select('qmain_pxprofile_pri.*');
    $this->dbmain->select('LEFT(qmain_pxprofile_pri.pxprtrw,2) AS pxprt');
    $this->dbmain->select('RIGHT(qmain_pxprofile_pri.pxprtrw,2) AS pxprw');
    $this->dbmain->select('DATE_FORMAT(CURDATE(), \'%Y\') - DATE_FORMAT(qmain_pxprofile_pri.pxptglhr, \'%Y\') - (DATE_FORMAT(CURDATE(), \'00-%m-%d\') < DATE_FORMAT(qmain_pxprofile_pri.pxptglhr, \'00-%m-%d\')) AS pxputh');
    $this->dbmain->select('TIMESTAMPDIFF( MONTH, qmain_pxprofile_pri.pxptglhr, CURDATE() ) % 12 AS pxpubl');
    $this->dbmain->select('FLOOR( TIMESTAMPDIFF( DAY, qmain_pxprofile_pri.pxptglhr, CURDATE() ) % 30.4375 ) AS pxpuhr');
    $this->dbmain->select('qmain_pxprofile_kel.*');
    $this->dbmain->select('qmain_pxprofile_tgg.*');
    $this->dbmain->select('qvar_desa.namades as vdes');
    $this->dbmain->select('qvar_suku.varnama as vsuku');
    $this->dbmain->select('qvar_kec.namakec as vkec');
    $this->dbmain->select('qvar_kab.namakab as vkab');
    $this->dbmain->select('qvar_prop.namaprp as vprp');
    $this->dbmain->select('qvar_negara.varnama as vneg');
    $this->dbmain->select('qvar_pekerjaan.varnama as vkrj');
    $this->dbmain->select('qvar_pendidikan.varnama as vdik');
    $this->dbmain->select('qvar_umum.varnama as vsts');
    $this->dbmain->select('qvar_agama.varnama as vagama');
	$this->dbmain->from($this->table);
    $this->dbmain->join('qmain_pxprofile_kel', 'qmain_pxprofile_kel.pxkidrs = qmain_pxprofile_pri.pxpidrs','left');
    $this->dbmain->join('qmain_pxprofile_tgg', 'qmain_pxprofile_tgg.pxtidrs = qmain_pxprofile_pri.pxpidrs','left');
    $this->dbmain->join('qvar_desa', 'qvar_desa.id = qmain_pxprofile_pri.pxpdes','left');
    $this->dbmain->join('qvar_kec', 'qvar_kec.id = qmain_pxprofile_pri.pxpkec','left');
    $this->dbmain->join('qvar_kab', 'qvar_kab.id = qmain_pxprofile_pri.pxpkab','left');
    $this->dbmain->join('qvar_prop', 'qvar_prop.id = qmain_pxprofile_pri.pxpprp','left');
    $this->dbmain->join('qvar_negara', 'qvar_negara.varid = qmain_pxprofile_pri.pxpneg','left');
    $this->dbmain->join('qvar_suku', 'qvar_suku.varid = qmain_pxprofile_pri.pxpsuku','left');
    $this->dbmain->join('qvar_pendidikan', 'qvar_pendidikan.varid = qmain_pxprofile_pri.pxpdik','left');
    $this->dbmain->join('qvar_pekerjaan', 'qvar_pekerjaan.varid = qmain_pxprofile_pri.pxpkrj','left');
    $this->dbmain->join('qvar_umum', 'qvar_umum.varid = qmain_pxprofile_pri.pxpstskw','left');
    $this->dbmain->join('qvar_agama', 'qvar_agama.varid = qmain_pxprofile_pri.pxpagama','left');
		$this->dbmain->where('pxpidrs',$id);
		$query = $this->dbmain->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->dbmain->insert($this->table, $data);
		return $this->dbmain->insert_id();
	}

	public function update($where, $data)
	{
		$this->dbmain->update($this->table, $data, $where);
//		return $this->dbmain->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->dbmain->where('pxpidrs', $id);
		$this->dbmain->delete($this->table);
	}

//--------------------------------
	public function savearsip($data)
	{
		$this->dbmain->insert('qvar_dtpx', $data);
		return $this->dbmain->insert_id();
	}

	public function updatearsip($where, $data)
	{
		$this->dbmain->update('qvar_dtpx', $data, $where);
//		return $this->dbmain->affected_rows();
	}

//--------------------------------


}
