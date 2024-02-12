<!-- page content -->
<div class="right_col" role="main">
<!--new1-----start----    -->
<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_title">
              <h2>Arus Kas</h2>
              <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
          </div>
            <div class="x_content">
                <div class="container cropper">
                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="full-width">
                        <h2>Rentang Waktu</h2>
                        <div class="clearfix"></div>
                      </div>
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

                        <div class="col-md-12 col-sm-12 col-xs-12">
                          <hr/>
                            <input type="button" class="btn btn-success" id="saringbill1" value="SARING">
                        </div>
                        <?php
                        echo form_close();
                        ?>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-12">
                      <div class="full-width">
                        <h2>Bulan</h2>
                        <div class="clearfix"></div>
                      </div>
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
        <!--new1-----end----    -->
        <div class="col-md-12 col-sm-12 col-xs-12">
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
                                <th rowspan="2">No</th>
                                <th rowspan="2">Acc.Grp1</th>
                                <th rowspan="2">Acc.Grp2</th>
                                <th rowspan="2">Acc.Det</th>
                                <th rowspan="2" style="text-align:center">Nama Perkiraan</th>
                                <th colspan="2" style="text-align:center">Saldo Awal</th>
                                <th colspan="2" style="text-align:center">Mutasi</th>
                                <th colspan="2" style="text-align:center">Saldo Akhir</th>
                              </tr>
                              <tr>
                                <th style="text-align:center">Debet</th>
                                <th style="text-align:center">Kredit</th>
                                <th style="text-align:center">Debet</th>
                                <th style="text-align:center">Kredit</th>
                                <th style="text-align:center">Debet</th>
                                <th style="text-align:center">Kredit</th>
                              </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                              <tr>
                                <th>---</th>
                                <th>---</th>
                                <th>---</th>
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
