<!-- page content -->
<div class="right_col" role="main">
<!--new1-----start----    -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Pengaturan Saldo Awal</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="container cropper">
                    <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">

                        <?php
                        echo form_open('markas/core1/akatur/area2',array('id'=>'perbaharui','data-parsley-validate class'=>'form-horizontal form-label-left'));
                        ?>
                        <div class="input-group input-group-sm">
                            <?php
                                echo form_label('PERKIRAAN','fa_noacc',array('class'=>'input-group-addon')); ?> <?php echo form_error('fa_noacc');
                                echo form_dropdown(array('id'=>'fa_per','class'=>'select2_single form-control','style'=>'float: left;'));
                            ?>

                        </div>
                        <div class="input-group input-group-sm">
                            <?php
                                echo form_label('Jumlah','fl_jum',array('class'=>'input-group-addon')); ?> <?php echo form_error('fl_jum');
                                echo form_input(array('id' => 'fa_jum', 'name' => 'fa_jum','class'=>'form-control decimal' ,'placeholder' => 'Jumlah (Rp)','required'=>'required','data-parsley-validation-threshold'=>'1'));
                            ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-success" id="exampleInputPassword2" value="PERBAHARUI">
                        </div>
                        <?php
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!--new1-----end----    -->
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar Saldo Awal</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                        <table id="tsaldo" class="display table-compact table-striped table-hover table-responsive table-full-width" cellspacing="0" width="100%">
                            <thead>
                                <tr>
				            		<th>No Akun</th>
				            		<th>Nama Perkiraan</th>
				            		<th>Saldo Awal</th>
				            		<th>Pilihan</th>
				            	</tr>
				            </thead>
                            <tbody>
                            </tbody>
                            <tfoot>
				            	<tr>
				            		<td>No</td>
				            		<td>Nama Perkiraan</td>
				            		<td>Saldo Awal</td>
				            		<td>Pilihan</td>
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
