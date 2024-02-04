<!-- page content -->
<div class="right_col" role="main"><!--new1-----start----    -->
  <div class="col-md-6 col-md-6 col-sm-6 col-xs-6">
    <?php
    echo form_open('',array('id'=>'cekpoli','class'=>'form-horizontal form-label-left'));
    ?>
    <div class="x_panel">
      <div class="x_title">
        <h2>Profil Poloklinik</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="container cropper">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-group input-group-sm">
              <?php
              echo form_label('Tgl.Awal','fl_tgl1',array('class'=>'input-group-addon')); ?> <?php echo form_error('fl_tgl1');
              ?>
              <input id="fl_tgl1" name="fl_tgl1" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
              <?php
              echo '<span class="input-group-addon">Tgl.Akhir</span>';
              ?>
              <input id="fl_tgl2" name="fl_tgl2" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
            </div>
            <div class="input-group input-group-sm">
              <?php
              echo form_label('Poliklinik','fl_noacc',array('class'=>'input-group-addon')); ?> <?php echo form_error('fl_noacc');
              echo form_dropdown('fl_jenis', $dkpoli, '#', 'id="fl_jenis" class="select2_single form-control" style="float: left;"');
              ?>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-success" id="exampleInputPassword2" value="SARING">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    echo form_close();
    ?>
  </div>
  <div class="col-md-6 col-md-6 col-sm-6 col-xs-6">
    <?php
    echo form_open('',array('id'=>'cekbangsal','class'=>'form-horizontal form-label-left'));
    ?>
    <div class="x_panel">
      <div class="x_title">
        <h2>Profil Bangsal</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="container cropper">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="input-group input-group-sm">
              <?php
              echo form_label('Tgl.Awal','fm_tgl1',array('class'=>'input-group-addon')); ?> <?php echo form_error('fm_tgl1');
              ?>
              <input id="fm_tgl1" name="fm_tgl1" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
              <?php
              echo '<span class="input-group-addon">Tgl.Akhir</span>';
              ?>
              <input id="fm_tgl2" name="fm_tgl2" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
            </div>
            <div class="input-group input-group-sm">
              <?php
              echo form_label('Bangsal','fm_noacc',array('class'=>'input-group-addon')); ?> <?php echo form_error('fm_noacc');
              echo form_dropdown('fm_jenis', $dkbangsal, '#', 'id="fm_jenis" class="select2_single form-control" style="float: left;"');
              ?>
            </div>
            <div class="form-group">
              <input type="submit" class="btn btn-success" id="exampleInputPassword2" value="SARING">
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    echo form_close();
    ?>
  </div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <!--new1-----end----    -->
    <div class="x_panel">
      <div class="x_title">
        <h2>Data Pelayanan Dokter</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="container cropper">
            <table id="dktabel" class="display table-striped dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tgl.Input</th>
	            		<th>No.RM</th>
	            		<th>Nama Pasien</th>
	            		<th>Nama Dokter</th>
	            		<th>Tarif</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <tr>
                  <th>No</th>
                  <th>Tgl.Input</th>
	            		<th>No.RM</th>
	            		<th>Nama Pasien</th>
	            		<th>Nama Dokter</th>
	            		<th>Tarif</th>
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
