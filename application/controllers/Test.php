    <?php
         
            class Test extends CI_Controller {
             
  function __construct() {
    parent::__construct();
    $this->load->model('dbcore1','',TRUE);
    $this->load->helper('url','form');
    $this->load->library('session');
    $this->load->database();
  }
                  
                  
                 public function index()
                  {
                    //echo "hello";die;
                    $this->db->select('*');
                    $this->db->from('qmain_pxprofile_pri');
                    $query = $this->db->get();
                    $data['result'] = $query->result();
                    $this->load->view('frontoff/rm_infor',$data);
                     
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
        public function editDomain($id)
          {    
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
        <td class="col-md-4 col-sm-4 col-xs-8"><input type="text" name="irtrw" class="form-control" value="'.$result[0]->pxprtrw.'">
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
