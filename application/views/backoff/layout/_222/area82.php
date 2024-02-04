<!-- page content -->
<div class="right_col" role="main">
<!--new1-----start----    -->
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="col-md-6 col-md-12 col-sm-12 col-xs-12">
            <?php
            echo form_open('',array('id'=>'bill1','data-parsley-validate class'=>'form-horizontal form-label-left'));
            ?>
              <div class="x_title">
                  <h2>Rentang Waktu</h2>
                  <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <div class="container cropper">
                      <div class="col-md-12 col-sm-12 col-xs-12">
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

                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <hr/>
                              <input type="button" class="btn btn-success" id="saringbill1" value="SARING">
                          </div>
                      </div>
                  </div>
              </div>
              <?php
              echo form_close();
              ?>
          </div>
          <div class="col-md-6 col-md-12 col-sm-12 col-xs-12">
            <div class="x_title">
                <h2>Bulan</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="container cropper">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="lapdetail">
                          <div id="buttable" style="width:100%;">
                          </div>
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
                <h2>Neraca Rugi Laba</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                      <table id="tfillgrid" class="display table table-striped nowrap" cellspacing="0" width="100%">
                          <thead>
                              <tr>
                                <th rowspan="2">NO</th>
                                <th rowspan="2">Nama Perkiraan</th>
                                <th colspan="2">Saldo Awal</th>
                                <th colspan="2">Mutasi</th>
                                <th colspan="2">Saldo Akhir</th>
                              </tr>
                              <tr>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                              <tr>
                                <th>---</th>
                                <th>---</th>
                                <th>Debet</th>
                                <th>Kredit</th>
                                <th>Debet</th>
                                <th>Kredit</th>
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
