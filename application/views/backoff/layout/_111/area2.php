<div class="right_col" role="main">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2>Isi Jurnal <small>(Pengguna Aktif)</small></h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li><a title="Data: <?php echo $operator['pgpnama']?>"><i class="fa fa-question"></i></a></li>
              </ul>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="container cropper">
                      <?php
                      echo form_open('core1/akharian/area2',array('id'=>'transaksi','data-parsley-validate class'=>'form-horizontal form-label-left'));
                      ?>
                      <div class="input-group input-group-sm">
                          <?php
                              echo form_label('JURNAL','fj_noacc',array('class'=>'input-group-addon')); ?> <?php echo form_error('fj_noacc');
                              echo form_dropdown('fj_jenis', $jjenis, '#', 'id="fj_jenis" class="select2_single form-control" style="float: left;" onchange = "new PNotify({
                                  title: \'Informasi\',
                                  type: \'warning\',
                                  text: \'Jenis jurnal berubah\',
                                  styling: \'bootstrap3\'
                                  });"');
                          ?>

                      </div>
                      <div class="input-group input-group-sm">
                          <?php
                              echo form_label('NO.Jurnal','fj_jns',array('class'=>'input-group-addon')); ?> <?php echo form_error('fj_jns');
                              echo form_input(array('id' => 'fj_nomor', 'name' => 'fj_nomor','class'=>'form-control','onkeyup'=>'this.value = this.value.toUpperCase();', 'data-inputmask'=>'\'mask\': \'aaa999.99.99\'','required'=>'required'));
                              echo '<span class="input-group-addon">TGL</span>';
                          ?>
                          <input id="fj_tgl" name="fj_tgl" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
                          <input id="fj_sts" name="fj_sts" type="hidden" value="0">
                          <input id="fj_akses" name="fj_akses" type="hidden" value="<?php echo $akses; ?>">
                      </div>
                      <div class="input-group input-group-sm">
                          <?php
                              echo form_label('KETERANGAN','fj_ket',array('class'=>'input-group-addon')); ?> <?php echo form_error('fj_ket');
                              echo form_input(array('id' => 'fj_ket', 'name' => 'fj_ket','class'=>'form-control' ,'placeholder' => 'Keterangan (optional)','onchange' => 'new PNotify({
                                  title: \'Informasi\',
                                  type: \'info\',
                                  text: \'Keterangan berubah\',
                                  styling: \'bootstrap3\'
                              });'));
                          ?>
                      </div>
                      <div class="form-group">
                          <input type="submit" class="btn btn-success" id="exampleInputPassword2" value="TAMBAH">
                      </div>
                      <?php
                      echo form_close();
                      ?>
              </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 col-sm-12 col-xs-12">
      <div class="x_panel">
          <div class="x_title">
              <h2>Data Tersimpan</h2>
              <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                  <li><a title="Semua Data"><i class="fa fa-question"></i></a></li>
              </ul>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <div class="container cropper">
                      <?php
                      echo form_open('',array('id'=>'tupdate','data-parsley-validate class'=>'form-horizontal form-label-left'));
                      ?>
                      <div class="input-group input-group-sm">
                          <?php
                              echo form_label('Transaksi per','inf_tgl',array('class'=>'input-group-addon'));
                              echo form_input(array('id' => 'info_tgl', 'name' => 'info_tgl','class'=>'form-control datepicker','value'=>date("d-m-Y",now())));
                          ?>

                      </div>
                      <table id="terupdate" class="display" cellspacing="0" width="100%">
                          <thead>
                              <tr>
			            		<th>Jml Jurnal</th>
			            		<th>Debet</th>
			            		<th>Kredit</th>
			            	</tr>
			            </thead>
                          <tbody>
                              <tr>
			            		<td>
                                      <?php
                                      echo form_input(array('up_jml' => 'up_jml', 'name' => 'up_jml','class'=>'form-control', 'value' => '---','readonly' => 'readonly'));
                                      ?>
                                  </td>
			            		<td>
                                      <?php
                                      echo form_input(array('id' => 'up_dbt', 'name' => 'up_dbt','class'=>'form-control', 'value' => '---','readonly' => 'readonly'));
                                      ?>
                                  </td>
			            		<td>
                                      <?php
                                      echo form_input(array('id' => 'up_krd', 'name' => 'up_krd','class'=>'form-control', 'value' => '---','readonly' => 'readonly'));
                                      ?>
                                  </td>
			            	</tr>
                          </tbody>
                          <tfoot>
			            	<tr>
			            		<th>---</th>
			            		<th>---</th>
			            		<th>---</th>
			            	</tr>
                          </tfoot>
					</table>
                      <?php
                      echo form_close();
                      ?>
                      <button type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target=".mdisitransaksi" title="Daftar transaksi hari ini"><i class="glyphicon glyphicon-briefcase"></i></button>
                      <button type="button" class="btn btn-sm btn-warning pull-right" data-toggle="modal" data-target=".mdisikode" title="Kode yang sudah dipakai"><i class="glyphicon glyphicon-question-sign"></i></button>
              </div>
          </div>
        </div>
      </div>


      <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
          <div class="x_title">
              <h2>Daftar Jurnal </h2>
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
                                  <th>Tanggal</th>
			            		<th>No.Jurnal</th>
			            		<th>Keterangan</th>
			            		<th>Nilai</th>
			            		<th>Pilihan</th>
			            	</tr>
			            </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
			            	<tr>
			            		<th>Tanggal</th>
			            		<th>No.Jurnal</th>
			            		<th>Keterangan</th>
			            		<th>Nilai</th>
			            		<th>Pilihan</th>
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
      <!-- /page content -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
      <div class="modal-content">
      <?php
          echo form_open('core1/akharian/area3',array('id'=>'etransaksi','data-parsley-validate class'=>'form-horizontal form-label-left'));
      ?>

          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Koreksi Transaksi</h4>
          </div>
          <div class="modal-body">
                      <div class="input-group input-group-sm">
                          <?php
                              echo form_label('JURNAL','fj_noacc',array('class'=>'input-group-addon')); ?> <?php echo form_error('fj_noacc');
                              echo form_dropdown('fj_jenis', $jjenis, '#', 'id="fj_jenis" class="select2_single form-control" style="width: 100%;float: left;"');
                          ?>

                      </div>
                      <div class="input-group input-group-sm">
                          <?php
                              echo form_label('NO.Jurnal','fj_jns',array('class'=>'input-group-addon')); ?> <?php echo form_error('fj_jns');
                              echo form_input(array('id' => 'fj_nomor', 'name' => 'fj_nomor','class'=>'form-control','onkeyup'=>'this.value = this.value.toUpperCase();', 'data-inputmask'=>'\'mask\': \'aaa999.99.99\'','required'=>'required')).'</div><div class="input-group input-group-sm">';
                              echo form_label('Tgl','fl_tgl',array('class'=>'input-group-addon')); ?> <?php echo form_error('fj_tgl');
                          ?>
                          <input id="fj_tgl" name="fj_tgl" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
                          <input id="fj_sts" name="fj_sts" type="hidden" value="0">
                          <input id="fj_akses" name="fj_akses" type="hidden" value="<?php echo $akses; ?>">
                      </div>
                      <div class="input-group input-group-sm">
                          <?php
                              echo form_label('KET','fj_ket',array('class'=>'input-group-addon')); ?> <?php echo form_error('fj_ket');
                              echo form_input(array('id' => 'fj_ket', 'name' => 'fj_ket','class'=>'form-control' ,'placeholder' => 'Keterangan'));
                          ?>
                      </div>
          </div>
          <div class="modal-footer">
              <input type="submit" class="btn btn-success" id="gantiData" value="GANTI">
          </div>
      <?php
      echo form_close();
      ?>
      </div>
  </div>
</div>

<div class="modal fade mdisikode" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="modalInfo">Kode Yang Ada:</h4>
          </div>
          <div class="modal-body">
                <?php
                foreach($dafkodejur as $dfjur){
                    if(floatval($dfjur['jum'])<=25){
                        $btn = '<button type="button" class="btn btn-xs btn-default">';
                    } elseif(floatval($dfjur['jum'])>25 && floatval($dfjur['jum'])<=50){
                        $btn = '<button type="button" class="btn btn-xs btn-info">';
                    } elseif(floatval($dfjur['jum'])>50 && floatval($dfjur['jum'])<=200){
                        $btn = '<button type="button" class="btn btn-xs btn-primary">';
                    } else{
                        $btn = '<button type="button" class="btn btn-xs btn-danger">';
                    }
                    echo $btn.$dfjur['kode'].' ('.$dfjur['jum'].')</button>';
                };
                ?>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
      </div>
      <div class="clearfix"></div>
  </div>
</div>

<div class="modal fade mdisitransaksi" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="modalInfo">Transaksi hari ini:</h4>
          </div>
          <div class="modal-body">
            <table id="isitrxupdate" class="display table table-striped bootstrap-datatable dt-responsive nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>No.Akun</th>
                        <th>Nama Akun</th>
                        <th>Keterangan</th>
                        <th>Debet</th>
                        <th>Kredit</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                      <th>No.Akun</th>
                      <th>Nama Akun</th>
                      <th>Keterangan</th>
                      <th>Debet</th>
                      <th>Kredit</th>
                    </tr>
                </tfoot>
            </table>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
      </div>
      <div class="clearfix"></div>
  </div>
</div>
