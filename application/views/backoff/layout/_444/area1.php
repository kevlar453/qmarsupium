<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Resume</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12">
        <div class="">
          <div class="x_content">
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <div style="height:80vh;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:10vh;">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"">
                    <?php
                        echo form_label('Regio','fa_noacc',array('class'=>''));
                        echo form_dropdown(array('id'=>'pilreg','class'=>'select2_single form-control','style'=>'float: left;'));
                    ?>
                    </div>
                  </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:70vh;">
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="padding-bottom:1vh;">
                    <?php
                        echo form_label('Periode','pilpart',array('class'=>''));
                        echo form_dropdown(array('id'=>'pilpart','class'=>'select2_single form-control','style'=>'float: left;'));
                    ?>
                    </div>
                      <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="padding-bottom:1vh;">
                    <?php
                        echo form_label('Paroki','pilpar',array('class'=>''));
                        echo form_dropdown(array('id'=>'pilpar','class'=>'select2_single form-control','style'=>'float: left;'));
                    ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 hidden" style="overflow-y:scroll;height:55vh;padding-top:1vh;" id="isian">
                      <!-- start accordion -->
                      <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                        <div class="isi1" id="a1"></div>
                      </div>
                      <!-- end of accordion -->

                    </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <div id="keuskupan" style="height:80vh;"></div>
                </div>
              </div>
            </div>
            <div class="row" id='kelregio'>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a1"></h3>
                  <hr/>
                  <div id="reg_a1" style="height:50vh;"></div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a2"></h3>
                  <hr/>
                  <div id="reg_a2" style="height:50vh;"></div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a3"></h3>
                  <hr/>
                  <div id="reg_a3" style="height:50vh;"></div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a4"></h3>
                  <hr/>
                  <div id="reg_a4" style="height:50vh;"></div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a5"></h3>
                  <hr/>
                  <div id="reg_a5" style="height:50vh;"></div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a6"></h3>
                  <hr/>
                  <div id="reg_a6" style="height:50vh;"></div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a7"></h3>
                  <hr/>
                  <div id="reg_a7" style="height:50vh;"></div>
                </div>
              </div>
              <div class="animated fadeInUp col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="tile-stats">
                  <h3 id="jdl_a8"></h3>
                  <hr/>
                  <div id="reg_a8" style="height:50vh;"></div>
                </div>
              </div>
            </div>

            <div class="row">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
