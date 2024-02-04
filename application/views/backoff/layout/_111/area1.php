<?php
$s1 = isset($s1)==TRUE?$s1:'-';
$s2 = isset($s2)==TRUE?$s2:'-';
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Summary</h3>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="">
                    <div class="x_content">
                        <div class="row">
                            <div class="animated flipInY col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                <div class="tile-stats">
                                  <?php
                                  echo form_open('',array('id'=>'transaksi','data-parsley-validate class'=>'form-horizontal form-label-left'));
                                  ?>
                                  <div class="input-group input-group-sm">
                                      <?php
                                          echo form_label('Mulai Tgl','fl_tgl1',array('class'=>'input-group-addon'));
                                          ?>
                                          <input id="fj_tgl1" name="fj_tgl1" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
                                          <?php
                                          echo '<span class="input-group-addon">Sampai Tgl</span>';
                                      ?>
                                      <input id="fj_tgl2" name="fj_tgl2" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
                                      <input id="fj_akses" name="fj_akses" type="hidden" value="<?php echo $akses; ?>">
                                  </div>
                                  <div class="form-group">
                                  <?php
                                  $sbag=array();
                                  $sbag = array(
                                    '00' => 'Semua Bagian/Unit',
                                    '01' => 'Administrasi',
                                    '03' => 'Binatu',
                                    '04' => 'Dokter',
                                    '05' => 'Farmasi',
                                    '06' => 'Gizi',
                                    '07' => 'Kebidanan',
                                    '08' => 'Perawat',
                                    '09' => 'Poli Kopang',
                                    '10' => 'Laboratorium',
                                    '11' => 'IPRS',
                                    '12' => 'Poli Gigi',
                                    '14' => 'Radiologi',
                                    '15' => 'Rekam Medis',
                                    '16' => 'Sekretariat',
                                    '17' => 'Pm. Perawat',
//                                    '18' => 'Keluar',
//                                    '20' => 'TIK',
                                    '21' => 'PKRS'
                                  );
                                  // Name Field
                                    echo form_dropdown('dbag' ,$sbag, '#', 'id="dbag" class="select2_single form-control" style="float: left;"');
//                                        echo form_input(array('id' => 'nik', 'name' => 'nik','type'=>'password','class'=>'form-control', 'placeholder'=>'Pilih Bagian/Unit'));
                                    ?>
                                  </div>
                                    <div class="form-group">
                                    <?php
                                    $sjam=array();
                                    $sjam = array(
                                      '00' => 'Semua Jam',
                                      'PG' => 'Dinas Pagi',
                                      'SR' => 'Dinas Sore',
                                      'ML' => 'Dinas Malam',
                                      'ST' => 'Setengah Hari',
                                      'LP' => 'Lepas Dns. Malam',
                                      'LB' => 'Libur',
                                      'CT' => 'Cuti Tahunan',
                                      'CM' => 'Suti Melahirkan',
                                      'CH' => 'Cuti Hari Raya',
                                      'SI' => 'Ijin Sakit',
                                    );
                                    // Name Field
                                      echo form_dropdown('djam' ,$sjam, '#', 'id="djam" class="select2_single form-control" style="float: left;"');
  //                                        echo form_input(array('id' => 'nik', 'name' => 'nik','type'=>'password','class'=>'form-control', 'placeholder'=>'Pilih Bagian/Unit'));
                                      ?>
                                    </div>
                                    <?php
                                    if($akses=='2015.02.030'){
                                    ?>

                                    <div class="form-group">
                                      <?php
                                      if($cekabsen){
                                        $monvar = date("d-m-Y",strtotime($cekabsen['temp2_tgl']));
                                        $monab = 'IMPORT Terakhir: '.date("d-m-Y",strtotime($cekabsen['temp2_tgl']));
                                      } else {
                                        $monvar = date("d-m-Y");
                                        $monab = 'IMPORT SEMUA DATA';
                                      }
                                      ?>
                                      <input id="fj_tcek" name="fj_tcek" type="hidden" value="<?php echo $monvar;?>">
                                      <button  type="button" class="btn btn-sm btn-danger pull-right"id="upabsenx"><?php echo $monab; ?></button>
                                    </div>

                                    <?php
                                  }
                                    echo form_close();
                                    ?>
                                </div>
                              </div>
                            </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Absen Karyawan Tgl <?php echo date("d-m-Y")?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        <li><a title="Data: <?php echo $operator['pgpnama']?>"><i class="fa fa-question"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="container cropper">
                            <table id="tfillgrid" class="display table table-striped bootstrap-datatable dt-responsive nowrap" cellspacing="0" width="100%">
                              <thead>
                                <tr>
                                  <th>Tgl</th>
                                  <th>NIK</th>
          				            		<th>Nama</th>
          				            		<th>Log-1</th>
          				            		<th>Log-2</th>
          				            		<th>Ket</th>
                                </tr>
                              </thead>
                              <tbody>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th>Tgl</th>
                                  <th>NIK</th>
          				            		<th>Nama</th>
          				            		<th>Log-1</th>
          				            		<th>Log-2</th>
          				            		<th>Ket</th>
                                </tr>
                              </tfoot>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div><!--/row-->
        </div>

        </div>
    </div>
</div>
<!-- /page content -->
