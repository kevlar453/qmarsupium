        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Registrasi Pasien</h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Identitas Pasien</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?php
                    echo form_open('prosespx/cekpx','id="userForm" data-parsley-validate class="form-horizontal form-label-left"');
                    echo '<div class="form-group">';
                    // Name Field
                    echo form_label('Nomor RM <span class="required">*</span>');
                    $data_name = array(
                      'name' => 'name',
                      'class' => 'form-control',
                      'placeholder' => 'Nomor Rekam Medik',
                      'id' => 'name',
                      'autofocus' => 'autofocus'
                      );
                      echo '<div class="input-group">';
                      echo form_input($data_name);
                      echo '<span class="input-group-btn">';
                      echo form_button('submit', 'Periksa',array('class'=>'submit btn btn-success'));
                      echo '</span>';
                      echo '</div>';
                      echo '</div>';
                      echo form_close();
                      ?>
                  
                  </div>
                  </div>
                  </div>

                  <div class="x_panel">
                  <div class="x_content">
                    <br />
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="profil" role="tab" data-toggle="tab" aria-expanded="true">Profil</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="rajal" data-toggle="tab" aria-expanded="false">Riwayat Rajal</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="ranap" data-toggle="tab" aria-expanded="false">Riwayat Ranap</a>
                        </li>
                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profil">


                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <br />
                    <?php

if($hasil==''){
  echo '<h2>TIDAK ADA DATA</h2>';
  echo '</div>';
} else{
$pilneg=$hasil['pxpneg'];
//  foreach($hasil as $row):
$jk = $hasil['pxpjk']=='100'?'<a href="#" title="Laki-Laki"><i class="fa fa-male blue"></i></a>':'<a href="#" title="Perempuan"><i class="fa fa-female red"></i></a>';
$jk==''?'<a href="#" title="Tidak Jelas"><i class="fa fa-question"></i></a>':$jk;
?>
<p class="lead">Data Pasien (<?php echo $vkunjung['varnama'].') - '.$hasil['pxpidrs']; ?></p>
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <th>Nama</th><th>:</th>
        <td><?php echo $hasil['pxpnama'].' '.$jk; ?></td>
      </tr>
      <tr>
        <th>Alamat</th><th>:</th>
        <td><?php echo $hasil['pxpalamat']; ?></td>
      </tr>
      <tr>
        <th></th><td></td>
        <td>
        <?php echo $hasil['pxprtrw']==''?'':'RT.'.substr($hasil['pxprtrw'],0,2).'/RW.'.substr($hasil['pxprtrw'],2).', '; ?>
        <?php echo $hasil['vdes']==''?'':$hasil['vdes'].', '; ?>
        <?php echo $hasil['vkec']==''?'':$hasil['vkec'].', '; ?>
        <?php echo $hasil['vkab']==''?'':$hasil['vkab'].', '; ?>
        <?php echo $hasil['vprp']==''?'':$hasil['vprp'].', '; ?>
        <?php echo $hasil['vneg']==''?'':$hasil['vneg']; ?>
        <?php echo $hasil['pxpkdpos']==''?'':' - '.$hasil['pxpkdpos']; ?></td>
      </tr>
      <tr>
        <th>Tetala</th><th>:</th>
        <td><?php echo $hasil['pxptplhr'].', '.date("d/m/Y",strtotime($hasil['pxptglhr'])); ?></td>
      </tr>
      <tr>
        <th>Umur</th><th>:</th>
        <td><?php echo $hasil['pxputh'].' th, '.$hasil['pxpubl'].' bln'; ?></td>
      </tr>
      <tr>
        <th>Kontak</th><th>:</th>
        <td><?php echo $hasil['pxptelp']==''?'':$hasil['pxptelp'].' / '; ?>
        <?php echo $hasil['pxphp']==''?'':$hasil['pxphp']; ?></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
<div class="table-responsive">
  <table class="table">
    <tbody>
      <tr>
        <th>Nama Ayah</th><th>:</th>
        <td><?php echo $hasil['pxknmayah']; ?></td>
      </tr>
      <tr>
        <th>Nama Ibu</th><th>:</th>
        <td><?php echo $hasil['pxknmibu']; ?></td>
      </tr>
      <tr>
        <th>Pendidikan</th><th>:</th>
        <td><?php echo $hasil['vdik']; ?></td>
      </tr>
      <tr>
        <th>Pekerjaan</th><th>:</th>
        <td><?php echo $hasil['vkrj']; ?></td>
      </tr>
      <tr>
        <th>Status</th><th>:</th>
        <td><?php echo $hasil['vsts']; ?></td>
      </tr>
      <tr>
        <th>Pekerjaan Suami</th><th>:</th>
        <td><?php echo $hasil['pxkkrjpsgn']; ?></td>
      </tr>
      <tr>
        <th>Umur Suami</th><th>:</th>
        <td><?php echo $hasil['pxkupsgn']; ?></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
</div>


<!-- ############################ -->

                  <!-- modals -->
                  <!-- Large modal -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg">Edit Data</button>

                  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Detail Data <?php echo $hasil['pxpidrs']; ?></h4>
                        </div>
                        <div class="modal-body">

<?php 
echo form_open('submit_ctrl',array('id'=>'form','class'=>'form-horizontal form-label-left'));
?>
<div class="container cropper">
<div class="docs-data col-md-6 col-sm-6 col-xs-12">
<div class="input-group input-group-sm">
<?php
echo form_label('NO. RM','drm',array('class'=>'input-group-addon')); ?> <?php echo form_error('drm');
echo form_input(array('id' => 'drm', 'name' => 'drm','class'=>'form-control' ,'value' => $hasil['pxpidrs']));
?>
</div>
<div class="input-group input-group-sm">
<?php
echo form_label('NAMA','dnama',array('class'=>'input-group-addon')); ?> <?php echo form_error('dnama');
echo form_input(array('id' => 'dnama', 'name' => 'dnama','class'=>'form-control' ,'value' => $hasil['pxpnama']));
?>
</div>

<div class="input-group input-group-sm">
    <label for="tgllahir" class="input-group-addon">Tgl Lahir</label>
    <input name="tgllahir" placeholder="BB/HH/TTTT" class="form-control datepicker" type="text" value="<?php echo date("m/d/Y",strtotime($hasil['pxptglhr']));?>">
</div>
<div class="input-group input-group-sm">
<?php
echo form_label('UMUR','duth',array('class'=>'input-group-addon')); ?> <?php echo form_error('duth');
echo form_input(array('id' => 'duth', 'name' => 'duth','class'=>'form-control','value'=>$hasil['pxputh']));
echo '<span class="input-group-addon">THN</span>';
echo form_input(array('id' => 'dubl', 'name' => 'dubl','class'=>'form-control','value'=>$hasil['pxpubl']));
echo '<span class="input-group-addon">BLN</span>';
echo form_input(array('id' => 'duhr', 'name' => 'duhr','class'=>'form-control','value'=>$hasil['pxpuhr']));
echo '<span class="input-group-addon">HR</span>';
?>
</div>

<div class="input-group input-group-sm">
<?php
echo form_label('ALAMAT','dalamat',array('class'=>'input-group-addon')); ?> <?php echo form_error('dalamat');
echo form_textarea(array('id' => 'dalamat', 'name' => 'dalamat','class'=>'form-control' ,'rows' => '2', 'value' => $hasil['pxpalamat']));
?>
</div>
<div class="input-group input-group-sm">
<?php
echo form_label('RT','drt',array('class'=>'input-group-addon')); ?> <?php echo form_error('drt');
echo form_input(array('id' => 'drt', 'name' => 'drt','class'=>'form-control','value'=>substr($hasil['pxprtrw'],0,2)));
echo form_label('RW','drw',array('class'=>'input-group-addon')); ?> <?php echo form_error('drw');
echo form_input(array('id' => 'drw', 'name' => 'drw','class'=>'form-control','value'=>substr($hasil['pxprtrw'],2)));
?>
</div>

<div class="input-group input-group-sm">
  <label for="pilnegara" class="input-group-addon">NEGARA</label>
<?php 
if($hasil['pxpneg']==''){
  $selneg='#';
  $negara['#'] = 'Pilih'; 
}else{
  $selneg = $hasil['pxpneg']; 
}
?>
<?php echo form_dropdown('pilnegara', $negara, $selneg, 'id="pilnegara" class="form-control" style="float: left;"'); ?>
  <div id="dafpilnegara" style="position: relative; float: left;"></div>
  <label for="pilprop" class="input-group-addon">PROP</label>
<?php 
if($hasil['pxpprp']==''){
  $selprp='#';
  $propinsi['#'] = 'Pilih'; 
}else{
  $selprp = $hasil['pxpprp']; 
}
?>
<?php echo form_dropdown('pilprop', $propinsi, $selprp, 'id="pilprop" class="form-control" style="float: left;"'); ?>
  <div id="dafpilprop" style="position: relative; float: left;"></div>
</div>

<div class="input-group input-group-sm">
  <label for="pilkab" class="input-group-addon">KOTA/KAB</label>
<?php 
if($hasil['pxpkab']==''){
  $selkab='#';
$kabupaten['#'] = 'Pilih'; 
}else{
$selkab = $hasil['pxpkab']; 
}
?>
<?php echo form_dropdown('pilkab', $kabupaten, $selkab, 'id="pilkab" class="form-control" style="float: left;"'); ?>
  <div id="dafpilkab" style="position: relative; float: left;"></div>
  <label for="pilkec" class="input-group-addon">KEC</label>
<?php 
if($hasil['pxpkec']==''){
  $selkec='#';
$kecamatan['#'] = 'Pilih'; 
}else{
$selkec = $hasil['pxpkec']; 
}
?>
<?php echo form_dropdown('pilkec', $kecamatan, $selkec, 'id="pilkec" class="form-control" style="float: left;"'); ?>
  <div id="dafpilkec" style="position: relative; float: left;"></div>
</div>

<div class="input-group input-group-sm">
  <label for="pildes" class="input-group-addon">DESA</label>
<?php 
if($hasil['pxpdes']==''){
  $seldes='#';
$desa['#'] = 'Pilih'; 
}else{
$seldes = $hasil['pxpdes']; 
}
?>
<?php echo form_dropdown('pildesa', $desa, $seldes, 'id="pildesa" class="form-control" style="float: left;"'); ?>
  <div id="dafpildes" style="position: relative; float: left;"></div>
</div>

<div class="input-group input-group-sm">
<label for="agama" class="input-group-addon">AGAMA</label>
<?php 
if($hasil['pxpagama']==''){
  $selagm='#';
  $lagama['#'] = 'Pilih'; 
}else{
  $selagm = $hasil['pxpagama']; 
}
?>
<?php echo form_dropdown('agama', $lagama, $selagm, 'id="agama" class="form-control" style="float: left;"'); ?>
  <div id="agama" style="position: relative; float: left;"></div>
</div>


</div>
</div>
<?php
  echo form_close(); 
?>

                        </div>


                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>

                      </div>
                    </div>
                  </div>

                  <!-- Small modal -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Kirim</button>

                  <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Modal title</h4>
                        </div>
                        <div class="modal-body">

<?php 
echo form_open('submit_ctrl',array('id'=>'berobat','class'=>'form-horizontal form-label-left'));
?>
<div class="input-group input-group-sm">
  <label for="pilpoli" class="input-group-addon">POLIKLINIK</label>
<?php 
  $poliklinik['#'] = 'Pilih'; 
echo form_dropdown('pilpoli', $poliklinik, '#', 'id="pilpoli" class="form-control" style="float: left;"'); ?>
  <div id="dafpilpoli" style="position: relative; float: left;"></div>
</div>

<?php
echo form_close(); 
?>


                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- /modals -->
<?php
//  endforeach;
}
?>



                  </div>




                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="rajal">


                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="ranap">
                          <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                            booth letterpress, commodo enim craft beer mlkshk </p>
                        </div>
                      </div>
                    </div>
                  </div>
                      <div class="ln_solid"></div>
                  </div>


              </div>

            </div>

          </div>

        </div>
        <!-- /page content -->


