<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
              <h2>Administrator</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="container cropper">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="word-wrap: break-word;">
                      <div id="dokwell" class="slideInDown animated" style="word-wrap: break-word;">
                        <?php
                        $txtwell = '<blockquote class="red">Selamat Datang!<br />Dokumentasi Administrasi hanya dapat diakses oleh pengguna yang masuk dalam kategori admin.Silahkan memilih dokumen dari menu yang ada disebelah kiri.</blockquote>';
                        $well = $this->session->userdata('pgsu')>0?$txtwell:$this->dbcore1->routekey($txtwell);
                        echo $well;
                        ?>
                      </div>
                    </div>
                </div>
                <?php
                if($this->session->userdata('pgsu')>1){
                ?>
                <div class="container cropper">
                    <div class="col-md-12 col-sm-12 col-xs-12 slideInUp animated well" id="fdok">
                        <?php
                        echo form_open('markas/corex/isi_pesan',array('id'=>'frmdoc','data-parsley-validate class'=>'form-horizontal form-label-left'));
                        ?>
                        <div class="input-group input-group-xs col-md-12 col-sm-12 col-xs-12">
                          <div class="col-md-4 col-sm-12 col-xs-12">
                                <?php
                                echo form_label('Kode Dokumen','ps_judul',array('class'=>'input-group'));
                                echo form_input(array('id' => 'ps_judul', 'name' => 'ps_judul','class'=>'form-control text-center'));
                                echo form_label('Bahasan','ps_desc',array('class'=>'input-group'));
                              echo form_textarea(array('id' => 'ps_desc', 'name' => 'ps_desc','class'=>'form-control','cols' => 100));
                                ?>
                                <hr />
                          </div>
                          <div class="col-md-8 col-sm-12 col-xs-12">
                          <?php
                          echo form_textarea(array('id' => 'ps_ket', 'name' => 'ps_ket','class'=>'form-control','cols' => 400));
                          ?>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <hr/>
                            <div>
                              <button type="button" class="btn btn-default col-md-4 col-md-4 col-sm-4 col-xs-4">BATAL</button>
                            </div>
                            <div>
                              <button type="button" class="btn btn-primary pull-right col-md-6 col-md-6 col-sm-6 col-xs-6" id="btndoc">SIMPAN</button>
                            </div>
                          </div>
                        </div>
                        </div>
                        <?php
                        echo form_close();
                        ?>
                      </div>
                </div>
<?php
}
?>
            </div>
        </div>
    </div>
</div>
