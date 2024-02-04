<!-- page content -->
<div class="right_col" role="main">
<!--new1-----start----    -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <?php
            echo form_open('',array('id'=>'bill1','class'=>'form-horizontal form-label-left'));
        ?>
        <div class="x_panel">
            <div class="x_title">
                <h2>Laporan</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="container cropper">
                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
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

                        <div class="form-group">
                            <input type="submit" class="btn btn-success" id="saringbill1" value="SARING">
                        </div>
                    </div>
<!--                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                        <blockquote>Jenis buku yang tidak memiliki Saldo Awal, tidak akan dimunculkan dalam daftar</blockquote>
                    </div> -->
                </div>
            </div>
        </div>
        <?php
        echo form_close();
        ?>

        <!--new1-----end----    -->
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar Pasien RM</h2>
                <button class="btn btn-default" onclick="reload_table()"><i class="glyphicon glyphicon-refresh"></i> Reload</button>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                      <table id="tbpasien" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                              <tr>
                                <th>JK</th>
                                <th>NAMA</th>
                                <th>UMUR</th>
                                <th>ALAMAT</th>
                                <th>LAHIR</th>
                                <th>KONTAK</th>
                                <th>AGAMA</th>
                                <th>PENDIDIKAN</th>
                                <th>PEKERJAAN</th>
                                <th>SUKU</th>
                                <th>KUNJUNGAN</th>
                                <th style="width:125px;">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>JK</th>
                                <th>NAMA</th>
                                <th>UMUR</th>
                                <th>ALAMAT</th>
                                <th>LAHIR</th>
                                <th>KONTAK</th>
                                <th>AGAMA</th>
                                <th>PENDIDIKAN</th>
                                <th>PEKERJAAN</th>
                                <th>SUKU</th>
                                <th>KUNJUNGAN</th>
                                <th style="width:125px;">Action</th>
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
