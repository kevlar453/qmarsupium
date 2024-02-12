<!-- page content -->
<div class="right_col" role="main">
<!--new1-----start----    -->
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
              <h2>Transaksi</h2>
              <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
          </div>
              <div class="x_content">
                <div class="container cropper">
                <div class="col-md-6 col-md-12 col-sm-12 col-xs-12">
                  <div class="page-title">
                    <div class="full-width">
                      <h3>Rentang Waktu</h3>
                    </div>
                  </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                        <?php
                        echo form_open('',array('id'=>'bill1','data-parsley-validate class'=>'form-horizontal form-label-left'));
                        ?>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                              <?php
                                  echo form_label('Tgl.Awal','fl_tgl1',array('class'=>'input-group')); ?> <?php echo form_error('fl_tgl1');
                              ?>
                              <input id="fl_tgl1" name="fl_tgl1" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                              <?php
                                  echo form_label('Tgl.Akhir','fl_tgl2',array('class'=>'input-group')); ?> <?php echo form_error('fl_tgl2');
                              ?>
                              <input id="fl_tgl2" name="fl_tgl2" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" value="<?php echo date("d-m-Y",now());?>">
                            </div>


                            </div>
                            <div class="col-md-6 col-sm-12 col-xs-12">
                              <div class="form-group">
                                  <input type="button" class="btn btn-success" id="saringbill1" value="SARING">
                              </div>
                          </div>
                          <?php
                          echo form_close();
                          ?>
                      </div>
                </div>
                <div class="col-md-6 col-md-12 col-sm-12 col-xs-12">
                  <div class="page-title">
                    <div class="full-width">
                      <h3>Pilihan</h3>
                    </div>
                  </div>
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <label for="piljurnal">Buku Kas</label>
                    <select class="select2_single form-control" id="piljurnal" name="piljurnal"></select>
                    <hr/>
                    <div class="lapdetail">
                      <div id="buttable" style="width:100%;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>


    <div class="col-md-12 col-sm-12 col-xs-12">
        <!--new1-----end----    -->
        <div class="x_panel">
            <div class="x_title">
                <h2>Rincian</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                      <table id="tfillgrid" class="display table-compact table-striped table-hover table-responsive table-full-width nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                <th>Tgl</th>
                                <th>No.Akun</th>
                                <th>No.Jurnal</th>
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
                                <th>Tgl</th>
                                <th>No.Akun</th>
                                <th>No.Jurnal</th>
                                <th>Nama Akun</th>
                                <th>Keterangan</th>
                                <th>Debet</th>
                                <th>Kredit</th>
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
