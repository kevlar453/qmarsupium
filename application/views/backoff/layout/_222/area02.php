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
                            echo form_label('Jenis','fl_jn1',array('class'=>'input-group-addon'));
                            echo form_dropdown('ft_jn1', array('ri' => 'RAWAT INAP','rj' => 'RAWAT JALAN'), 'ri', 'id="ft_jn1" class="form-control"');
                            echo '<span class="input-group-addon piljen">Poli</span>';
                            echo form_dropdown('ft_jn2', $dkpoli, '#', 'id="ft_jn2" class="form-control piljen" style="float: left;"');
                            ?>

                        </div>
                        <div class="input-group input-group-sm">
                            <?php
                            echo form_label('Tgl.Awal','fl_tgl1',array('class'=>'input-group-addon'));
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
                <h2>Rekapitulasi Jumlah Pasien</h2>
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
                                <th>No</th>
        				            		<th>Register</th>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Keluar</th>
                                <th>Bangsal</th>
        				            		<th>Kamar</th>
        				            		<th>Kelas</th>
                              </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>No</th>
        				            		<th>Register</th>
                                <th>No. RM</th>
                                <th>Nama</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Keluar</th>
                                <th>Bangsal</th>
        				            		<th>Kamar</th>
        				            		<th>Kelas</th>
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
