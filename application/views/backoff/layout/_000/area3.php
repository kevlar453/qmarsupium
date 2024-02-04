<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
              <a href="<?php
              $swakses = $kodejob!='000'?'&kodejob1=000':'';
              echo base_url().'markas/prosespx/cekpx?rmod=area1&name='.$hasil['pxpidrs'].$swakses;
              ?>" title="Detail" ><i class="glyphicon glyphicon-triangle-left"></i> Kembali</a>
                <h3>Detail Pasien</h3>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
                        <br />
                        <div class="" role="tabpanel" data-example-id="togglable-tabs">
                            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#tab_content1" id="profil" role="tab" data-toggle="tab" aria-expanded="true">Profil</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="rajal" data-toggle="tab" aria-expanded="false">Riwayat Rajal</a>
                                </li>
                                <li role="presentation" class=""><a href="#tab_content3" role="tab" id="ranap" data-toggle="tab" aria-expanded="false">Riwayat Ranap</a>
                                </li>
                            </ul>
                            <div id="myTabContent" class="tab-content">
                                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="profil">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <br />
                                        <?php
                                            if($hasil==''){
                                            echo '<h2>TIDAK ADA DATA</h2> ';
                                            echo '</div>';
                                            } else{
                                                if(isset($_GET['rmod'])==TRUE){
                                                $rmmod=$_GET["rmod"]=='area4'?'area3':'area4';
                                                };

                                            $pilneg=$hasil['pxpneg'];
                                            //  foreach($hasil as $row):
                                            $jk = $hasil['pxpjk']=='100'?'<a href="#" title="Laki-Laki"><i class="fa fa-male blue"></i></a>':'<a href="#" title="Perempuan"><i class="fa fa-female pink"></i></a>';
                                            $jk==''?'<a href="#" title="Tidak Jelas"><i class="fa fa-question"></i></a>':$jk;
                                        ?>
                                        <p class="lead">Data Pasien (<?php echo $vkunjung['varnama'].') - '.$hasil['pxpidrs']; ?></p>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table class="myTable">
                                                    <tbody>
                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Nama</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxpnama'].' '.$jk; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Nama Ayah</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxknmayah']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Alamat</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxpalamat']; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Nama Ibu</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxknmibu']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th></th><th></th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8">
                                                            <?php echo $hasil['pxprtrw']==''?'':'RT.'.substr($hasil['pxprtrw'],0,2).'/RW.'.substr($hasil['pxprtrw'],2).', '; ?>
                                                            <?php echo $hasil['vdes']==''?'':$hasil['vdes'].', '; ?>
                                                            <?php echo $hasil['vkec']==''?'':$hasil['vkec'].', '; ?>
                                                            <?php echo $hasil['vkab']==''?'':$hasil['vkab'].', '; ?>
                                                            <?php echo $hasil['vprp']==''?'':$hasil['vprp'].', '; ?>
                                                            <?php echo $hasil['vneg']==''?'':$hasil['vneg']; ?>
                                                            <?php echo $hasil['pxpkdpos']==''?'':' - '.$hasil['pxpkdpos']; ?></td>

                                                            <th class="col-md-2 col-sm-2 col-xs-6">Pendidikan</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['vdik']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Tetala</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxptplhr'].', '.date("d/m/Y",strtotime($hasil['pxptglhr'])); ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Pekerjaan</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['vkrj']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Umur</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxputh'].' th, '.$hasil['pxpubl'].' bln'; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Status</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['vsts']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Kontak</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxptelp']==''?'':$hasil['pxptelp'].' / '; ?>
                                                            <?php echo $hasil['pxphp']==''?'':$hasil['pxphp']; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Pekerjaan Suami</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxkkrjpsgn']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Agama</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['vagama']==''?'':$hasil['vagama']; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Umur Suami</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['pxkupsgn']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Suku</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $hasil['vsuku']==''?'':$hasil['vsuku']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="ln_solid"></div>
                                        <p class="lead">Arsip Rekam Medis</p>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <div class="table-responsive">
                                                <table class="myTable">
                                                    <tbody>
                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Petugas</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $arsipoprt['pgpnama']; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Tgl Arsip</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $arsip['pdptgl']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">No.Rak</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo substr($arsip['pdppos'],0,2); ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">No.Bar</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo substr($arsip['pdppos'],2); ?></td>
                                                        </tr>
<?php
if($arsippinjam!='' && $arsip['pdpdiberikan']!='1950-06-13'){
?>
                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Peminjam</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $arsippinjam['pgpnama']; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Tgl Pinjam</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $arsip['pdpdiberikan']; ?></td>
                                                        </tr>

                                                        <tr>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Keterangan</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $arsip['pdpket']; ?></td>
                                                            <th class="col-md-2 col-sm-2 col-xs-6">Tgl Kembali</th><th>:</th>
                                                            <td class="col-md-4 col-sm-4 col-xs-8"><?php echo $arsip['pdpditerima']; ?></td>
                                                        </tr>
<?php
}
?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="ln_solid"></div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <a class="btn btn-sm btn-warning pull-right" href="<?php echo site_url('markas/prosespx/cekpx?rmod='.$rmmod.'&name='.$hasil['pxpidrs'].$swakses.''); ?>" title="Detail" ><i class="glyphicon glyphicon-pencil"></i> Rubah Data</a>
                                        </div>
                                    </div>

                                    <?php
                                        }
                                    ?>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="rajal">
                                  <table id="tbrajal" class="display" cellspacing="0" width="100%">
                                      <thead>
                                          <tr>
                                            <th>NO</th>
                                            <th>REGISTER</th>
                                            <th>POLIKLINIK</th>
                                            <th>TGL.PERIKSA</th>
                                            <th>DIAGNOSA</th>
                                            <th>DOKTER</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <th>NO</th>
                                            <th>REGISTER</th>
                                            <th>POLIKLINIK</th>
                                            <th>TGL.PERIKSA</th>
                                            <th>DIAGNOSA</th>
                                            <th>DOKTER</th>
                    				            	</tr>
                                      </tfoot>
                                    </table>
                                  <div class="clearfix"></div>

                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="ranap">
                                  <table id="tbranap" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                        <thead>
                                          <tr>
                                            <th>NO</th>
                                            <th>REGISTER</th>
                                            <th>BANGSAL</th>
                                            <th>TGL.MASUK</th>
                                            <th>DIAGNOSA</th>
                                            <th>DOKTER</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <th>NO</th>
                                            <th>REGISTER</th>
                                            <th>BANGSAL</th>
                                            <th>TGL.MASUK</th>
                                            <th>DIAGNOSA</th>
                                            <th>DOKTER</th>
                                          </tr>
                                        </tfoot>
                                      </table>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                </div>
            </div>
        </div>
    </div>
</div>

                            <!-- /page content -->
