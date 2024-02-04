<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Pengaturan Kode Akun</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="container cropper">
                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                        <?php
                        echo form_open('',array('id'=>'simpperk','class'=>'form-horizontal form-label-left'));
                        ?>
                        <div class="input-group input-group-sm">
                            <?php
                              echo form_label('Jenis Akun','fl_jlak',array('class'=>'input-group-addon'));
                              echo form_dropdown(array('id'=>'fa_jlak','class'=>'select2_single form-control','style'=>'float: left;'));
                            ?>
                        </div>
                        <div class="input-group input-group-sm animated fadeInDown hidden" id="falak01">
                            <?php
                                echo form_label('Kode Akun','fl_lak1',array('id'=>'fl_lak1','class'=>'input-group-addon'));
                                echo form_input(array('id' => 'fa_lak1', 'name' => 'fa_lak1','class'=>'form-control angka' ,'placeholder' => '3 digit kode','required'=>'required','maxlength'=>'3','pattern'=>'[0-9]{3}'));
                                echo form_label('Hanya isi dengan angka, format #00','fl_lak01',array('id'=>'fl_lak01','class'=>'input-group-addon'));
                            ?>
                        </div>
                        <div class="input-group input-group-sm animated fadeInDown hidden" id="falak02">
                            <?php
                                echo form_label('Kode Akun','fl_lak2',array('id'=>'fl_lak2','class'=>'input-group-addon'));
                                echo form_input(array('id' => 'fa_lak2', 'name' => 'fa_lak2','class'=>'form-control angka' ,'placeholder' => '3 digit kode','required'=>'required','maxlength'=>'3','pattern'=>'[0-9]{3}'));
                                echo form_label('Hanya isi dengan angka, format ##0','fl_lak02',array('id'=>'fl_lak02','class'=>'input-group-addon'));
                            ?>
                        </div>
                        <div class="input-group input-group-sm animated fadeInDown hidden" id="falak03">
                            <?php
                                echo form_label('Kode Akun','fl_lak3',array('id'=>'fl_lak3','class'=>'input-group-addon'));
                                echo form_input(array('id' => 'fa_lak3', 'name' => 'fa_lak3','class'=>'form-control angka' ,'placeholder' => '3 digit kode','required'=>'required','maxlength'=>'3','pattern'=>'[0-9]{3}'));
                                echo form_label('Hanya isi dengan angka, format ###','fl_lak03',array('id'=>'fl_lak03','class'=>'input-group-addon'));
                            ?>
                        </div>
                        <div class="input-group input-group-sm animated fadeInDown hidden" id="falak13">
                            <?php
                            echo form_label('Sisi Debet','fl_lak13',array('id'=>'fl_lak13','class'=>'input-group-addon'));
//                            echo form_label('Sisi Debet','fl_lak13',array('id'=>'fl_lak13'));
                            echo form_multiselect('fa_jlak131', '---', '#', 'id="fa_jlak131" class="select2_group form-control"');
                            ?>
                          </div>
                            <div class="input-group input-group-sm animated fadeInDown hidden" id="falak23">
                            <?php
                            echo form_label('Sisi Kredit','fl_lak23',array('id'=>'fl_lak23','class'=>'input-group-addon'));
//                            echo form_label('Sisi Kredit','fl_lak23',array('id'=>'fl_lak23'));
                            echo form_multiselect('fa_jlak132', '---', '#', 'id="fa_jlak132" class="select2_group form-control"');
                            ?>
                        </div>
                        <div class="input-group input-group-sm animated fadeInDown hidden" id="falak04">
                            <?php
                                echo form_label('Kode Akun','fl_lak4',array('id'=>'fl_lak4','class'=>'input-group-addon'));
                                echo form_input(array('id' => 'fa_lak4', 'name' => 'fa_lak4','class'=>'form-control' ,'placeholder' => '9 digit kode','required'=>'required','maxlength'=>'12','pattern'=>'[0-9.]{12}'));
                                echo form_label('Hanya isi dengan angka, format ###.##.##.##','fl_lak04',array('id'=>'fl_lak04','class'=>'input-group-addon'));
                            ?>
                        </div>
                        <div class="input-group input-group-sm animated fadeInDown hidden" id="falak05">
                            <?php
                                echo form_label('Nama Akun','fl_nak1',array('id'=>'fl_nak1','class'=>'input-group-addon'));
                                echo form_input(array('id' => 'fa_nak1', 'name' => 'fa_nak1','class'=>'form-control' ,'placeholder' => 'Nama Akun','required'=>'required','maxlength'=>'255','pattern'=>'[A-Az-z0-9]{5,}'));
                            ?>
                        </div>
                        <div id="hlak1" class="alert animated">---</div>

                        <?php
                        echo '<div class="form-group"><a id="tbsimperk" class="btn btn-success disabled" href="javascript:void(0)" title="Simpan" onclick="simpperkiraan();">SIMPAN</a></div>';
                        echo form_close();
                        ?>

                    </div>
                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                      <p>
                        <strong>Cara pengisian:</strong><br/>
                          <div><i class="fa fa-chevron-circle-right green"></i> Pilih <strong>Group GL</strong> (ada 4 pilihan)</div>
                          <div id="glmark1" class="animated flipInX"> Preparing result...</div>
                          <div id="glmark2" class="animated flipInX"> Preparing result...</div>
                          <div id="glmark3" class="animated flipInX"> Preparing result...</div>
                          <div id="glmark4" class="animated flipInX"> Preparing result...</div>
                      </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="x_panel">
            <div class="x_title">
                <h2>Kode Akun</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">

                      <!-- start accordion -->
                      <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel">
                          <a class="panel-heading" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <h4 class="panel-title">Struktur Kode Akun</h4>
                          </a>
                          <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                              <div id="listperk"></div>
                            </div>
                          </div>
                        </div>
                        <div class="panel">
                          <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <h4 class="panel-title">Daftar Perkiraan</h4>
                          </a>
                          <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                            <div class="panel-body">
                              <table id="tvariabel" class="display table-compact table-striped table-hover table-responsive table-full-width" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th>No</th>
            				            		<th>Nomor Perkiraan</th>
            				            		<th>Nama Perkiraan</th>
            				            		<th>Update</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th>No</th>
                                    <th>Nomor Perkiraan</th>
                                    <th>Nama Perkiraan</th>
                                    <th>Update</th>
                                  </tr>
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- end of accordion -->

                      <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div><!--/row-->
    </div>
</div>
        <!-- /page content -->
