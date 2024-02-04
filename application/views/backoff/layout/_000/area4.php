<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Rubah Data Pasien</h3>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <div id="myTabContent" class="tab-content">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <br />
                                    <?php
                                    $swakses = $kodejob!='000'?'&kodejob1=000':'';
                                        if($hasil==''){
                                        echo '<h2>TIDAK ADA DATA</h2> '.$cek1;
                                        echo '</div>';
                                        } else{
                                            if(isset($_GET['rmod'])==TRUE){
                                            $rmmod=$_GET["rmod"]=='area4'?'area3':'area4';
                                            };

                                        $pilneg=$hasil['pxpneg'];
                                        //  foreach($hasil as $row):
                                        $jk = $hasil['pxpjk']=='100'?'<a href="#" title="Laki-Laki"><i class="fa fa-male blue"></i></a>':'<a href="#" title="Perempuan"><i class="fa fa-female pink"></i></a>';
                                        $jk==''?'<a href="#" title="Tidak Jelas"><i class="fa fa-question"></i></a>':$jk;
                                        $piljkl = $hasil['pxpjk']=='100'?'checked':'';
                                        $piljkp = $hasil['pxpjk']=='101'?'checked':'';
                                    ?>
                                    <p class="lead">Data Pasien (<?php echo $vkunjung['varnama'].')'; ?></p>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <?php
                                            echo form_open('submit_ctrl',array('id'=>'formrm1','class'=>'form-horizontal form-label-left'));
                                        ?>

                                        <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                                            <div class="container cropper">
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                        echo form_label('NO. RM','drm',array('class'=>'input-group-addon')); ?> <?php echo form_error('drm');
                                                        echo form_input(array('id' => 'drm', 'name' => 'drm','class'=>'form-control', 'readonly' => 'readonly' ,'value' => $hasil['pxpidrs']));
                                                    ?>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                        echo form_label('NO. JKN','djkn',array('class'=>'input-group-addon')); ?> <?php echo form_error('djkn');
                                                        echo form_input(array('id' => 'djkn', 'name' => 'djkn','class'=>'form-control', 'placeholder' => 'NMR PESERTA JKN','value' => $hasil['pxpidjkn']));
                                                    ?>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                        echo form_label('NO. KTP','djkn',array('class'=>'input-group-addon')); ?> <?php echo form_error('dktp');
                                                        echo form_input(array('id' => 'dktp', 'name' => 'dktp','class'=>'form-control', 'placeholder' => 'NMR IDENTITAS KTP/SIM' ,'value' => $hasil['pxpidpri']));
                                                    ?>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                        echo form_label('NAMA','dnama',array('class'=>'input-group-addon')); ?> <?php echo form_error('dnama');
                                                        echo form_input(array('id' => 'dnama', 'name' => 'dnama','class'=>'form-control' ,'value' => $hasil['pxpnama'],'onchange' => 'new PNotify({
                                                                                        title: \'Informasi\',
                                                                                        type: \'info\',
                                                                                        text: \'Anda merubah nama pasien\',
                                                                                        styling: \'bootstrap3\'
                                                                                    });'));
                                                    ?>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <label class="input-group-addon">JenKel</label>
                                                    <input class="flat input-group-addon" type="radio" name="djk" id="djkl" value="100" <?php echo $piljkl;?>> Laki-Laki &nbsp;
                                                    <input class="flat input-group-addon" type="radio" name="djk" id="djkp" value="101" <?php echo $piljkp;?>> Perempuan
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                        echo form_label('LAHIR','dtlhr',array('class'=>'input-group-addon')); ?> <?php echo form_error('dtlhr');
                                                        echo form_input(array('id' => 'dtlhr', 'name' => 'dtlhr','class'=>'form-control','value'=>$hasil['pxptplhr'],'onchange' => 'new PNotify({
                                                                                        title: \'Informasi\',
                                                                                        type: \'info\',
                                                                                        text: \'Anda merubah tempat lahir pasien\',
                                                                                        styling: \'bootstrap3\'
                                                                                    });'));
                                                        echo '<span class="input-group-addon">TGL</span>';
                                                    ?>
                                                    <input id="tgllahir" name="tgllahir" placeholder="HH/BB/TTTT" class="form-control datepicker" type="text" onchange = "new PNotify({
                                                                                    title: 'Informasi',
                                                                                    type: 'info',
                                                                                    text: 'Anda merubah tanggal lahir pasien',
                                                                                    styling: 'bootstrap3'
                                                                                });" value="<?php echo date("d-m-Y",strtotime($hasil['pxptglhr']));?>">
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                        echo form_label('UMUR','duth',array('class'=>'input-group-addon')); ?> <?php echo form_error('duth');
                                                        echo form_input(array('id' => 'duth', 'name' => 'duth','class'=>'form-control','value'=>$hasil['pxputh']));
                                                        echo '<span class="input-group-addon">THN</span>';
                                                        echo form_input(array('id' => 'dubl', 'name' => 'dubl','class'=>'form-control','value'=>$hasil['pxpubl']));
                                                        echo '<span class="input-group-addon">BLN</span>';
                                                        echo form_input(array('id' => 'duhr', 'name' => 'duhr','class'=>'form-control','value'=>$hasil['pxpuhr']));
                                                        echo '<span class="input-group-addon">HR</span>';
                                                    ?>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                        echo form_label('TELP','dtlp',array('class'=>'input-group-addon')); ?> <?php echo form_error('dtlp');
                                                        echo form_input(array('id' => 'dtlp', 'name' => 'dtlp','class'=>'form-control' ,'value' => $hasil['pxptelp'],'onchange' => 'new PNotify({
                                                                                        title: \'Informasi\',
                                                                                        type: \'info\',
                                                                                        text: \'Anda merubah data kontak pasien\',
                                                                                        styling: \'bootstrap3\'
                                                                                    });'));
                                                        echo '<span class="input-group-addon">HP</span>';
                                                        echo form_input(array('id' => 'dhp', 'name' => 'dhp','class'=>'form-control' ,'value' => $hasil['pxphp'],'onchange' => 'new PNotify({
                                                                                        title: \'Informasi\',
                                                                                        type: \'info\',
                                                                                        text: \'Anda merubah data kontak pasien\',
                                                                                        styling: \'bootstrap3\'
                                                                                    });'));
                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                                            <div class="container cropper">
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                    echo form_label('ALAMAT','dalamat',array('class'=>'input-group-addon')); ?> <?php echo form_error('dalamat');
                                                    echo form_textarea(array('id' => 'dalamat', 'name' => 'dalamat','class'=>'form-control' ,'rows' => '2', 'value' => $hasil['pxpalamat'],'onchange' => 'new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah alamat pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });'));
                                                    ?>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <?php
                                                    echo form_label('RT','drt',array('class'=>'input-group-addon')); ?> <?php echo form_error('drt');
                                                    echo form_input(array('id' => 'drt', 'name' => 'drt','class'=>'form-control','value'=>substr($hasil['pxprtrw'],0,2),'onchange' => 'new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data RT pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });'));
                                                    echo form_label('RW','drw',array('class'=>'input-group-addon')); ?> <?php echo form_error('drw');
                                                    echo form_input(array('id' => 'drw', 'name' => 'drw','class'=>'form-control','value'=>substr($hasil['pxprtrw'],2),'onchange' => 'new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data RW pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });'));
                                                    ?>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <label for="pilnegara" class="input-group-addon">NEGARA</label>
                                                    <?php
                                                        if($hasil['pxpneg']==''){
                                                        $selneg='#';
                                                        $negara['#'] = 'Pilih';
                                                        }else{
                                                        $selneg = $hasil['pxpneg'];
                                                        }
                                                        echo form_dropdown('pilnegara', $negara, $selneg, 'id="pilnegara" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                        title: \'Informasi\',
                                                                                        type: \'info\',
                                                                                        text: \'Anda merubah data Negara pasien\',
                                                                                        styling: \'bootstrap3\'
                                                                                    });"');
                                                    ?>
                                                    <div id="dafpilnegara" style="position: relative; float: left;"></div>
                                                    <label for="pilprop" class="input-group-addon">PROP</label>
                                                    <?php
                                                        if($hasil['pxpprp']==''){
                                                        $selprp='#';
                                                        $propinsi['#'] = 'Pilih';
                                                        }else{
                                                        $selprp = $hasil['pxpprp'];
                                                        }
                                                        echo form_dropdown('pilprop', $propinsi, $selprp, 'id="pilprop" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data Propinsi pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });"');
                                                    ?>
                                                    <div id="dafpilprop" style="position: relative; float: left;"></div>
                                                </div>
                                                <div class="input-group input-group-sm">
                                                    <label for="pilkab" class="input-group-addon">KOTA/KAB</label>
                                                    <?php
                                                        if($hasil['pxpkab']==''){
                                                        $selkab='#';
                                                        $kabupaten['#'] = 'Pilih';
                                                        }else{
                                                        $selkab = $hasil['pxpkab'];
                                                        }
                                                        echo form_dropdown('pilkab', $kabupaten, $selkab, 'id="pilkab" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data Kabupaten pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });"');
                                                    ?>
                                                    <div id="dafpilkab" style="position: relative; float: left;"></div>
                                                    <label for="pilkec" class="input-group-addon">KEC</label>
                                                    <?php
                                                        if($hasil['pxpkec']==''){
                                                        $selkec='#';
                                                        $kecamatan['#'] = 'Pilih';
                                                        }else{
                                                        $selkec = $hasil['pxpkec'];
                                                        }
                                                        echo form_dropdown('pilkec', $kecamatan, $selkec, 'id="pilkec" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data Kecamatan pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });"');
                                                    ?>
                                                    <div id="dafpilkec" style="position: relative; float: left;"></div>
                                                </div>

                                                <div class="input-group input-group-sm">
                                                    <label for="pildes" class="input-group-addon">DESA</label>
                                                    <?php
                                                        if($hasil['pxpdes']==''){
                                                        $seldes='#';
                                                        $desa['#'] = 'Pilih';
                                                        }else{
                                                        $seldes = $hasil['pxpdes'];
                                                        }
                                                        echo form_dropdown('pildesa', $desa, $seldes, 'id="pildesa" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data desa pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });"');
                                                    ?>
                                                    <div id="dafpildes" style="position: relative; float: left;"></div>
                                                </div>

                                                <div class="input-group input-group-sm">
                                                    <label for="dagama" class="input-group-addon">AGAMA</label>
                                                    <?php
                                                        if($hasil['pxpagama']==''){
                                                        $selagm='#';
                                                        $lagama['#'] = 'Pilih';
                                                        }else{
                                                        $selagm = $hasil['pxpagama'];
                                                        }
                                                        echo form_dropdown('dagama', $lagama, $selagm, 'id="dagama" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data agama pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });"');
                                                    ?>
                                                    <div id="dagama" style="position: relative; float: left;"></div>
                                                    <?php
                                                        echo '<span class="input-group-addon">SUKU</span>';
                                                        if($hasil['pxpsuku']==''){
                                                        $selsuku='#';
                                                        $lsuku['#'] = 'Pilih';
                                                        }else{
                                                        $selsuku = $hasil['pxpsuku'];
                                                        }
                                                        echo form_dropdown('dsuku', $lsuku, $selsuku, 'id="dsuku" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                    title: \'Informasi\',
                                                                                    type: \'info\',
                                                                                    text: \'Anda merubah data suku pasien\',
                                                                                    styling: \'bootstrap3\'
                                                                                });"');
                                                    ?>
                                                    <div id="dsuku" style="position: relative; float: left;"></div>
                                                </div>

                                                <div class="input-group input-group-sm">
                                                    <label for="ddik" class="input-group-addon">PENDIDIKAN</label>
                                                    <?php
                                                        if($hasil['pxpdik']==''){
                                                        $seldik='#';
                                                        $ldik['#'] = 'Pilih';
                                                        }else{
                                                        $seldik= $hasil['pxpdik'];
                                                        }
                                                        echo form_dropdown('ddik', $ldik, $seldik, 'id="ddik" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                        title: \'Informasi\',
                                                                                        type: \'info\',
                                                                                        text: \'Anda merubah data pendidikan pasien\',
                                                                                        styling: \'bootstrap3\'
                                                                                    });"');
                                                    ?>
                                                    <div id="ddik" style="position: relative; float: left;"></div>
                                                </div>

                                                <div class="input-group input-group-sm">
                                                    <label for="dkrj" class="input-group-addon">PEKERJAAN</label>
                                                    <?php
                                                        if($hasil['pxpkrj']==''){
                                                        $selkrj='#';
                                                        $lkrj['#'] = 'Pilih';
                                                        }else{
                                                        $selkrj = $hasil['pxpkrj'];
                                                        }
                                                        echo form_dropdown('dkrj', $lkrj, $selkrj, 'id="dkrj" class="form-control" style="float: left;" onchange = "new PNotify({
                                                                                        title: \'Informasi\',
                                                                                        type: \'info\',
                                                                                        text: \'Anda merubah data pekerjaan pasien\',
                                                                                        styling: \'bootstrap3\'
                                                                                    });"');
                                                    ?>
                                                    <div id="dkrj" style="position: relative; float: left;"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                            echo form_close();
                                        ?>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <hr />
                                            <button type="button" class="btn btn-default" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="glyphicon glyphicon-tags"></i> Riwayat Arsip</button>
                                            <a class="btn btn-sm btn-primary" href="<?php echo site_url('markas/prosespx/cekpx?rmod='.$rmmod.'&name='.$hasil['pxpidrs'].$swakses.''); ?>" title="Detail" ><i class="glyphicon glyphicon-folder-open"></i> Detail Data</a>
                                            <button type="button" class="btn btn-sm btn-success" id="btnSave" onclick="save();"><i class="glyphicon glyphicon-floppy-disk"></i> Simpan</button>

                                    </div>


<!-- #############Large Modal Sementara Dihilangkan############### -->

                  <!-- Small modal -->

                                    <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                                    </button>
                                                    <h4 class="modal-title" id="myModalLabel2">Masuk Layanan</h4>
                                                </div>

                                                <div class="modal-body">
                                                    <?php
                                                        echo form_open('submit_ctrl',array('id'=>'berobat','class'=>'form-horizontal form-label-left'));
                                                    ?>
                                                    <div class="input-group input-group-sm">
                                                        <label for="pilpoli" class="input-group-addon">POLIKLINIK</label>
                                                        <?php
                                                            $poliklinik['#'] = 'Pilih';
                                                            echo form_dropdown('pilpoli', $poliklinik, '#', 'id="pilpoli" class="form-control" style="float: left;"');
                                                        ?>
                                                        <div id="dafpilpoli" style="position: relative; float: left;"></div>
                                                    </div>
                                                    <?php
                                                    echo form_close();
                                                    ?>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                                    <button type="button" class="btn btn-primary">Simpan</button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                  <!-- /modals -->
                                    <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="ln_solid"></div>
        <!-- /page content -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
