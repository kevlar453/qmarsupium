<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <button class="btn btn-info pull-left helum" onclick="cekback();"><i class="fa fa-arrow-left red"></i> Jurnal</button>
                <h2>Isi Transaksi</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-4 col-sm-12 col-xs-12">
                    <div class="container cropper">
                      <?php
                      echo form_open('/markas/core1/akharian/area3',array('id'=>'transaksi','data-parsley-validate class'=>'form-horizontal form-label-left'));
                      ?>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        echo form_label('No.Jurnal','ft_nojur',array('class'=>'input-group')); ?> <?php echo form_error('ft_jurno');
                        echo form_input(array('id' => 'ft_nojur', 'name' => 'ft_nojur','class'=>'form-control', 'value' => '','readonly' => 'readonly'));
                        ?>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        echo form_label('Tgl','ft_jurtg',array('class'=>'input-group')); ?> <?php echo form_error('ft_jurtg');
                        echo form_input(array('id' => 'ft_jurtg', 'name' => 'ft_jurtg','class'=>'form-control', 'value' => '','readonly' => 'readonly'));
                        ?>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        echo form_label('Posisi','ft_jns',array('class'=>'input-group'));
                        ?>
                        <select id="ft_jns" name="ft_jns" class="form-control"></select>;
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        echo form_label('Jns Perkiraan','ft_nmr1',array('class'=>'input-group'));
                        ?>
                        <select class="form-control" id="ft_nmr1" name="ft_nmr1"></select>
                      </div>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <?php
                        echo form_label('Perkiraan','ft_nmr2',array('class'=>'input-group'));
                        ?>
                        <select id="ft_nmr2" name="ft_nmr2" class="form-control" style="width: 100%;float: left;"></select>;
                      </div>
                      <div id="ft_nmrx" class="input-group input-group-sm"></div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        echo form_label('Uraian','ft_ket',array('class'=>'input-group'));
                        echo form_input(array('id' => 'ft_ket', 'name' => 'ft_ket','class'=>'form-control' ,'placeholder' => 'Keterangan (optional)'));
                        ?>
                      </div>
                      <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php
                        echo form_label('Jumlah','ft_jum',array('class'=>'input-group'));
                        echo form_input(array('id' => 'ft_jum', 'name' => 'ft_jum','class'=>'form-control decimal','required'=>'required','data-parsley-validation-threshold'=>'1'));
                        ?>
                      </div>
                      <div class="input-group input-group-sm">
                        <input id="ft_mark1" name="ft_mark1" type="hidden" value="n">
                        <input id="ft_urut" name="ft_urut" type="hidden">
                        <input id="ft_nama" name="ft_nama" type="hidden">
                        <input id="ft_akses" name="ft_akses" type="hidden" value="<?php echo $akses; ?>">
                      </div>
                      <?php
                      echo form_close();
                      ?>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <hr/>
                        <button class="btn btn-success" id="submitTrx" onclick="gotransaksi()">TAMBAH</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12">
                    <div class="container cropper">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                            <table id="tfillgrid" class="display table-compact table-striped table-hover dt-responsive table-full-width" cellspacing="0" width="100%">
                        <thead>
                          <tr>
                            <th>Kode</th>
                            <th>Perkiraan Utama/Lawan</th>
                            <th>Uraian</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Opsi</th>
                          </tr>
                        </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                          <tr>
                            <th></th>
                            <th></th>
                            <th>Total</th>
                            <th>Debet</th>
                            <th>Kredit</th>
                            <th>Opsi</th>
                          </tr>
                                </tfoot>
                </table>
                <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <!-- /page content -->
