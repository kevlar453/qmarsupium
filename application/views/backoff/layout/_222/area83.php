<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
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
                        <?php
                        if($kodesu>=1){
                          ?>

                        <div class="grid__item theme-9">
                          <button class="repair btn btn-danger"><img src="<?php echo base_url(); ?>dapur0/images/penmed.png" width="50px" height="auto"/></button>
                        </div>
                        <?php
                      }

                          ?>
                    </div>
                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                      <div id="prosjpxri"><h2>Catatan!!!</h2><h3 class="animated infinite pulse"><strong class="red">PERCOBAAN</strong> Rekapitulasi Billing</h3><h3>Mohon informasi jika ditemui kesalahan.</h3></div>
                    </div>
                </div>
            </div>

        <div class="x_panel">
            <div class="x_title">
              <h2 class="grid__item theme-9">
      					<button class="helum particles-button"><i class="fa fa-hand-o-left red"></i> Kembali</button>
      				</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                        <table id="tfillgrid"  class="display table table-striped nowrap" cellspacing="0" width="100%">
				            <thead>
				            	<tr>
                        <th>RJ/RI</th>
                        <th>Klaim</th>
                        <th>Asal</th>
                        <th>No.RM</th>
                        <th>Register</th>
                        <th>Tgl.Input</th>
				            		<th>Item</th>
				            		<th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Kat-1</th>
                        <th>Kat-2</th>
                        <th>Kat-3</th>
				            	</tr>
				            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
				            	<tr>
                        <th>RJ/RI</th>
                        <th>Klaim</th>
                        <th>Asal</th>
                        <th>No.RM</th>
                        <th>Register</th>
                        <th>Tgl.Input</th>
                        <th>Item</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Kat-1</th>
                        <th>Kat-2</th>
                        <th>Kat-3</th>
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

        <div class="modal animated slideInUp bs-example-modal-kmr" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-rinci">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" onclick="loadpesan();"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Aturan Pakai Modul Rincian</h4>
            </div>
            <div class="modal-body" data-spy="scroll">
              <div class="col-md-12">
                  <div class="">
                      <div class="x_content">
                          <div class="row">
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                      <div class="count" id="jjur">#1</div>
                                      <h3>Akses Rincian</h3>
                                      <p>
                                        <ul>
                                          <li>Pilih MENU KASIR</li>
                                          <li>Klik RINCIAN</li>
                                        </ul>
                                      </p>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                    <img src="<?php echo base_url(); ?>dapur0/images/inform/k1.png" class="imgzoom img-responsive"/>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                      <div class="count" id="jjur">#2</div>
                                      <h3>Akses Rincian</h3>
                                      <p>Adalah...</p>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                    <img src="<?php echo base_url(); ?>dapur0/images/inform/k2.png" class="imgzoom img-responsive"/>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                      <div class="count" id="jjur">#3</div>
                                      <h3>Akses Rincian</h3>
                                      <p>Adalah...</p>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                    <img src="<?php echo base_url(); ?>dapur0/images/inform/k3.png" class="imgzoom img-responsive"/>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                      <div class="count" id="jjur">#4</div>
                                      <h3>Akses Rincian</h3>
                                      <p>Adalah...</p>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                    <img src="<?php echo base_url(); ?>dapur0/images/inform/k4.png" class="imgzoom img-responsive"/>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                      <div class="count" id="jjur">#5</div>
                                      <h3>Akses Rincian</h3>
                                      <p>Adalah...</p>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                    <img src="<?php echo base_url(); ?>dapur0/images/inform/k5.png" class="imgzoom img-responsive"/>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                      <div class="count" id="jjur">#6</div>
                                      <h3>Akses Rincian</h3>
                                      <p>Adalah...</p>
                                  </div>
                              </div>
                              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                  <div class="tile-stats">
                                    <img src="<?php echo base_url(); ?>dapur0/images/inform/k6.png" class="imgzoom img-responsive"/>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="tile-stats">
                                </div>
                              </div>
                            </div>

                  </div>
              </div>
          </div>
            </div>
            <div class="modal-footer">
              <!--
              <button type="button" class="col-md-4 col-md-4 col-sm-4 col-xs-6 btn btn btn-default" data-dismiss="modal">Tutup</button>
              <button type="button" class="col-md-4 col-md-4 col-sm-4 col-xs-6 btn btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-paper-plane"></i> BARU</button>
-->
            </div>

          </div>
        </div>
        </div>
