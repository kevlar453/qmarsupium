<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Rincian Perawatan</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                  <li id="chisaduh"><a class="collapse-link"><i class="fa fa-heart animated infinite tada red"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="container cropper">
                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                      <?php
                          echo form_open('',array('id'=>'bill1','class'=>'form-horizontal form-label-left'));
                      ?>
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
                        <?php
                        echo form_close();
                        ?>
                        <div class="grid__item theme-9">
                          <button class="umum btn btn-info"><img src="<?php echo base_url(); ?>dapur0/images/logorsk.png" width="50px" height="auto"/></button>
                        </div>
                        <div class="grid__item theme-10">
                          <button class="bpjs btn btn-success"><img src="<?php echo base_url(); ?>dapur0/images/logobpjs.png" width="50px" height="auto"/></button>
                        </div>
                    </div>
                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                      <div id="prosjpxri"><h2>Catatan!!!</h2><h3 class="animated infinite pulse"><strong class="red">SAVE</strong> Data Billing</h3><h3>Sebelum menggunakan Modul ini.</h3></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar Rincian Perawatan</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                      <table id="tfillgrid" class="display table-striped" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th>No</th>
        				            		<th>Masuk</th>
                                <th>Keluar</th>
                                <th>No RM</th>
                                <th>No. Reg</th>
                                <th>Nama Px</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>No</th>
        				            		<th>Masuk</th>
                                <th>Keluar</th>
                                <th>No RM</th>
                                <th>No. Reg</th>
                                <th>Nama Px</th>
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
