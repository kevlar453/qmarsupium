<!-- page content -->
<div class="right_col" role="main">
<!--new1-----start----    -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Registrasi</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-md-6 col-sm-6 col-xs-12">
                    <div class="container cropper">
                      <?php
                      echo form_open('markas/prosespx','id="userForm" data-parsley-validate class="form-horizontal form-label-left"');
                      echo '<div class="form-group">';
                      echo form_label('Nomor RM <span class="required">*</span>');
                      $data_name = array(
                        'name' => 'name',
                        'class' => 'form-control',
                        'placeholder' => 'Nomor Rekam Medik',
                        'id' => 'name',
                        'autofocus' => 'autofocus'
                        );
                        echo '<div class="input-group">';
                        echo form_input($data_name);
                        echo '<input id="rmod" name="rmod" type="hidden" value="area1">';
                        echo '<span class="input-group-btn">';
                        echo form_button('submit', 'Tekan ENTER',array('class'=>'submit btn btn-danger','disabled'=>'disabled'));
                        echo '</span>';
                        echo '</div>';
                        echo '</div>';
                        echo form_close();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo form_close();
        ?>

        <!--new1-----end----    -->
        <div class="x_panel">
            <div class="x_title">
                <h2>Data Pasien</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="container cropper">
                      <?php
                      if($hasil==''){
                        echo '<h2>TIDAK ADA DATA</h2>';
                      } else {
                      $pilneg=$hasil['pxpneg'];
                      $jk = $hasil['pxpjk']=='100'?'<a href="#" title="Laki-Laki"><i class="fa fa-male blue"></i></a>':'<a href="#" title="Perempuan"><i class="fa fa-female red"></i></a>';
                      $jk==''?'<a href="#" title="Tidak Jelas"><i class="fa fa-question"></i></a>':$jk;
                      ?>
                      <p class="lead">Pasien: <?php echo $vkunjung['varnama'].', RM:  '.$hasil['pxpidrs'].', Update:  '.date('d-m-Y H:i',strtotime($hasil['pxpUPDATE'])); ?></p>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            <tr>
                              <th>Nama</th><th>:</th>
                              <td><?php echo $hasil['pxpnama'].' '.$jk; ?></td>
                            </tr>
                            <tr>
                              <th>Alamat</th><th>:</th>
                              <td><?php echo $hasil['pxpalamat']; ?></td>
                            </tr>
                            <tr>
                              <th></th><td></td>
                              <td>
                              <?php echo $hasil['pxprtrw']==''?'':'RT.'.substr($hasil['pxprtrw'],0,2).'/RW.'.substr($hasil['pxprtrw'],2).', '; ?>
                              <?php echo $hasil['vdes']==''?'':$hasil['vdes'].', '; ?>
                              <?php echo $hasil['vkec']==''?'':$hasil['vkec'].', '; ?>
                              <?php echo $hasil['vkab']==''?'':$hasil['vkab'].', '; ?>
                              <?php echo $hasil['vprp']==''?'':$hasil['vprp'].', '; ?>
                              <?php echo $hasil['vneg']==''?'':$hasil['vneg']; ?>
                              <?php echo $hasil['pxpkdpos']==''?'':' - '.$hasil['pxpkdpos']; ?></td>
                            </tr>
                            <tr>
                              <th>Tetala</th><th>:</th>
                              <td><?php echo $hasil['pxptplhr'].', '.date("d/m/Y",strtotime($hasil['pxptglhr'])); ?></td>
                            </tr>
                            <tr>
                              <th>Umur</th><th>:</th>
                              <td><?php echo $hasil['pxputh'].' th, '.$hasil['pxpubl'].' bln'; ?></td>
                            </tr>
                            <tr>
                              <th>Kontak</th><th>:</th>
                              <td><?php echo $hasil['pxptelp']==''?'':$hasil['pxptelp'].' / '; ?>
                              <?php echo $hasil['pxphp']==''?'':$hasil['pxphp']; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      </div>
                      <?php
                      if($arsip['pdpdiberikan']=='' && $arsip['pdpditerima']==''){
                      $ars_head = '<th colspan=2 class="red">BELUM DIARSIPKAN</th>';
                      $rak= '-';
                      $bar = '-';
                      $oprt = '-';
                      } elseif ($arsip['pdpdiberikan']!='' && $arsip['pdpditerima']=='1950-06-13'){
                      $ars_head = '<th colspan=2 class="red">DIPINJAM - '.$arsipoprt['pgpnama'].' ('.date("d/m/Y",strtotime($arsip['pdpdiberikan'])).')</th>';
                      $rak= 'OUT';
                      $bar = 'OUT';
                      $oprt = $arsipoprt['pgpnama'];
                      } else {
                      $ars_head = '<th colspan=2 class="green">ADA</th>';
                      $rak= $arsip['pdpdiberikan']!='' && $arsip['pdpditerima']=='1950-06-13'?'OUT':substr($arsip['pdppos'],0,2);
                      $bar = $arsip['pdpdiberikan']!='' && $arsip['pdpditerima']=='1950-06-13'?'OUT':substr($arsip['pdppos'],2);
                      $oprt = $arsipoprt['pgpnama'];
                      }
                      ?>
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th class="green">STATUS</th><?php echo $ars_head; ?>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <th class="green">No.RAK</th><th>:</th>
                              <td><?php echo $rak; ?></td>
                            </tr>
                            <tr>
                              <th class="green">No.BAR</th><th>:</th>
                              <td><?php echo $bar; ?></td>
                            </tr>
                            <tr>
                              <th class="green">Pengarsip</th><th>:</th>
                              <td><?php echo $oprt; ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      <a class="btn btn-sm btn-default" href="javascript:void(0)" title="Arsip" onclick="prosesarsip("<?php echo $hasil['pxpidrs']; ?>")"><i class="glyphicon glyphicon-tags"></i> Arsip</a>
                      <a class="btn btn-sm btn-primary" href="<?php
                      $swakses = $kodejob!='000'?'&kodejob1=000':'';
                      echo base_url().'markas/prosespx/cekpx?rmod=area3&name='.$hasil['pxpidrs'].$swakses;
                      ?>" title="Detail" ><i class="glyphicon glyphicon-pencil"></i> Detail Data</a>
                      <?php
                      }
                      ?>
						<div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div><!--/row-->


      </div>
    </div>

        <!-- /page content -->
