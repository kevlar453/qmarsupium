        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Registrasi Pasien</h3>
              </div>
            </div>

            <div class="clearfix"></div>
            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Identitas Pasien</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <?php
                    echo form_open('prosespx/cekpx','id="userForm" data-parsley-validate class="form-horizontal form-label-left"');
                    echo '<div class="form-group">';
                    // Name Field
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
                      echo '<span class="input-group-btn">';
                      echo form_submit('submit', 'Periksa', "class='submit btn btn-success'");
                      echo '</span>';
                      echo '</div>';
                    ?>
                  
                  </div>
                  </div>
                  </div>

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

<?php
echo form_close();
?>

                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <br />
                    <?php
if($hasil==''){
  echo '<h2>TIDAK ADA DATA</h2>';
  echo '</div>';
} else{
echo '<div class="col-md-12 col-sm-12 col-xs-12">';
  foreach($hasil as $row):

                    echo form_open('prosespx/cekpx','id="userForm" data-parsley-validate class="form-horizontal form-label-left input_mask"');
                    ?>

                      
                      <?php
                      echo '<div class="form-group">';
                      $data_lnama = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Nama <span class="required">*</span>','nama',$data_lnama);
                      $data_nama = array(
                        'name' => 'nama',
                        'class' => 'form-control',
                        'value' => $row->firstname,
                        'placeholder' => 'Nama Lengkap',
                        'id' => 'nama'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_nama);
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group">';
                      $data_lalmt = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Alamat <span class="required">*</span>','alamat',$data_lalmt);
                      $data_almt = array(
                        'name' => 'alamat',
                        'class' => 'form-control',
                        'value' => $row->alamat,
                        'placeholder' => 'Alamat',
                        'id' => 'alamat'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_almt);
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';

//---------------------------------------------
                      echo '<div class="col-md-6 col-sm-6 col-xs-6">';
                      echo '<div class="form-group">';
                      $data_lrtrw = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('RT-RW','rtrw',$data_lrtrw);
                      $data_rtrw = array(
                        'name' => 'rtrw',
                        'class' => 'form-control',
                        'value' => $row->rtrw,
                        'placeholder' => 'RT-RW',
                        'id' => 'rtrw'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_rtrw);
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group">';
                      $data_lkec = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Kecamatan','kec',$data_lkec);
                      $data_kec = array(
                        'name' => 'kec',
                        'class' => 'form-control',
                        'value' => $row->kecamatan,
                        'placeholder' => 'KECAMATAN',
                        'id' => 'kec'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_kec);
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group">';
                      $data_lkel = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );

                      echo form_label('Kelurahan','kel',$data_lkel);
                      $data_kel = array(
                        'name' => 'kel',
                        'class' => 'form-control',
                        'value' => $row->kelurahan,
                        'placeholder' => 'KELURAHAN',
                        'id' => 'kel'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_kel);
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
//---------------------------
//---------------------------

                      echo '<div class="col-md-6 col-sm-6 col-xs-6">';

                      echo '<div class="form-group">';
                      $data_lkot = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Kodya','kec',$data_lkot);
                      $data_kot = array(
                        'name' => 'kot',
                        'class' => 'form-control',
                        'value' => $row->kotamadya,
                        'placeholder' => 'KOTAMADYA',
                        'id' => 'kot'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_kot);
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group">';
                      $data_lkab = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Kabupaten','kab',$data_lkab);
                      $data_kab = array(
                        'name' => 'kab',
                        'class' => 'form-control',
                        'value' => $row->kabupaten,
                        'placeholder' => 'KABUPATEN',
                        'id' => 'kab'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_kab);
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group">';
                      $data_lpro = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Propinsi','pro',$data_lpro);
                      $data_pro = array(
                        'name' => 'pro',
                        'class' => 'form-control',
                        'value' => $row->propinsi,
                        'placeholder' => 'PROPINSI',
                        'id' => 'pro'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_pro);
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group">';
                      $data_lkdpos = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Kd. POS','kdpos',$data_lkdpos);
                      $data_kdpos = array(
                        'name' => 'kdpos',
                        'class' => 'form-control',
                        'value' => $row->kodepos,
                        'placeholder' => 'Kode POS',
                        'id' => 'kdpos'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_kdpos);
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';
//---------------
//---------------                      
                      echo '<div class="col-md-6 col-sm-6 col-xs-6">';
                      echo '<div class="form-group">';
                      $data_lhp = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );

                      echo form_label('HP','hp',$data_lhp);
                      $data_hp = array(
                        'name' => 'hp',
                        'class' => 'form-control',
                        'value' => $row->hp,
                        'placeholder' => 'HAND PHONE',
                        'id' => 'hp'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_hp);
                      echo '</div>';
                      echo '</div>';

                      echo '<div class="form-group">';
                      $data_ltlp = array(
                        'class' => 'control-label col-md-3 col-sm-3 col-xs-12'
                        );
                      echo form_label('Telp Rumah','trmh',$data_ltlp);
                      $data_tlp = array(
                        'name' => 'tlp',
                        'class' => 'form-control',
                        'value' => $row->telp,
                        'placeholder' => 'TELEPON RUMAH',
                        'id' => 'tlp'
                        );
                      echo '<div class="col-md-9 col-sm-9 col-xs-12">';
                      echo form_input($data_tlp);
                      echo '</div>';
                      echo '</div>';
                      echo '</div>';




                      ?>


<?php
  endforeach;
}
echo form_close();
?>
                  </div>



                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="rajal">
                          <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                            booth letterpress, commodo enim craft beer mlkshk aliquip</p>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="ranap">
                          <p>xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo
                            booth letterpress, commodo enim craft beer mlkshk </p>
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


