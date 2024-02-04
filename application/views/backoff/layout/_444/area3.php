<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php
            echo form_open('',array('id'=>'transaksi','data-parsley-validate class'=>'form-horizontal form-label-left'));
        ?>
        <div class="x_panel">
            <div class="x_title">
                <h2>Rincian Tagihan Pasien <span id="pxnoreg"></span></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a data-toggle="modal" data-target=".bs-example-modal-kmr" ><i class="fa fa-question animated infinite tada red"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="col-md-6 col-sm-6 col-xs-12 profile_details">
                  <div class="well profile_view">
                  <div class="col-sm-12">
                    <h4 class="brief"><i id="pxjenis"></i></h4>
                    <div class="left col-xs-12">
                      <h2 id="pxnama"></h2>
                      <p><strong>Waktu: </strong> <span id="pxwktin"></span> / <span id="pxwktout"></span></p>
                      <ul class="list-unstyled">
                        <li><i class="fa fa-building"></i> Alamat: <span id="pxalm"></span></li>
                        <li><i class="fa fa-fire"></i> Umur: <span id="pxumur"></span></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-xs-12 bottom text-center">
                    <div class="col-xs-12 col-sm-16 emphasis">
                      <p class="ratings">
                        <a>Total Tagihan: <span id="pxjum" class="pull-right"></span></a>
                      </p>
                      <hr/>
                      <p class="ratings">
                        <a><center><span id="pxterb"></span></center></a>
                      </p>
                    </div>
<!--                    <div class="col-xs-12 col-sm-6 emphasis">
                      <button type="button" class="btn btn-success btn-xs"> <i class="fa fa-user">
                        </i> <i class="fa fa-comments-o"></i> </button>
                      <button type="button" class="btn btn-primary btn-xs">
                        <i class="fa fa-user"> </i> View Profile
                      </button>
                    </div> -->
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-md-3 col-sm-3 col-xs-4">
                <a href="#" id="kamar" class="col-md-4 col-md-4 col-sm-4 col-xs-6 btn btn-warning animated fadeInUp" onclick="" title="BANGSAL"><img src="<?php echo base_url(); ?>dapur0/images/bangsal.png" class="img-responsive"/></a>
                <a href="#" id="dokter" class="col-md-4 col-md-4 col-sm-4 col-xs-6  btn btn-info animated fadeInUp" onclick="" title="DOKTER"><img src="<?php echo base_url(); ?>dapur0/images/dokter.png" class="img-responsive"/></a>
                <a href="#" id="tindakan" class="col-md-4 col-md-4 col-sm-4 col-xs-6  btn btn-danger animated fadeInUp" onclick="" title="TINDAKAN"><img src="<?php echo base_url(); ?>dapur0/images/tindakan.png" class="img-responsive" /></a>
                <a href="#" id="perawat" class="col-md-4 col-md-4 col-sm-4 col-xs-6  btn btn-warning animated fadeInUp" onclick="" title="PERAWAT"><img src="<?php echo base_url(); ?>dapur0/images/perawat.png" class="img-responsive" /></a>
              </div>
              <div class="col-md-3 col-md-3 col-sm-3 col-xs-4">
                <a href="#" id="farmasi" class="col-md-4 col-md-4 col-sm-4 col-xs-6  btn btn-info animated fadeInUp" onclick="" title="FARMASI"><img src="<?php echo base_url(); ?>dapur0/images/farmasi.png" class="img-responsive" /></a>
                <a href="#" id="pendukung" class="col-md-4 col-md-4 col-sm-4 col-xs-6  btn btn-success animated fadeInUp" onclick="" title="PENDUKUNG"><img src="<?php echo base_url(); ?>dapur0/images/operasi.png" class="img-responsive" /></a>
                <a href="#" id="penmed" class="col-md-4 col-md-4 col-sm-4 col-xs-6  btn btn-success animated fadeInUp" onclick="" title="PENUNJANG MEDIK"><img src="<?php echo base_url(); ?>dapur0/images/laborat.png" class="img-responsive" /></a>
                <a href="#" id="sewa" class="col-md-4 col-md-4 col-sm-4 col-xs-6  btn btn-danger animated fadeInUp" onclick="" title="SEWA"><img src="<?php echo base_url(); ?>dapur0/images/ambulance.png" class="img-responsive" /></a>
              </div>
            </div>
        </div>
        <?php
        echo form_close();
        ?>

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
                        <table id="tfillgrid" class="compact table-striped bootstrap-datatable dt-responsive nowrap" cellspacing="0" width="100%">
				            <thead>
				            	<tr>
				            		<th>Kelompok</th>
				            		<th>Tgl.Input</th>
				            		<th>Item</th>
				            		<th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Mark1</th>
                        <th>Mark2</th>
				            	</tr>
				            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
				            	<tr>
                        <th>Kelompok</th>
				            		<th>Tgl.Input</th>
				            		<th>Item</th>
				            		<th>Jumlah</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Mark1</th>
                        <th>Mark2</th>
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
