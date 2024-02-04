<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>SDM</h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <input type="text" class="form-control" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          </div>

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Profil Pegawai <small>Activity report</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                <div class="profile_img">
                    <div id="crop-avatar">
                        <div id="potone"></div>
                    </div>
                </div>
                <h3><?php echo $operator['pgpnama'];?></h3>

                <ul class="list-unstyled user_data">
                    <li><i class="fa fa-map-marker user-profile-icon"></i> <?php echo $operator['pgpalamat'];?>
                    </li>

                    <li>
                        <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $operator['pgpktp'];?>
                    </li>

                    <li class="m-top-xs">
                        <i class="fa fa-external-link user-profile-icon"></i>
                        <a href="mailto:<?php echo $operator['pgpemail'];?>" target="_blank"><?php echo $operator['pgpemail'];?></a>
                    </li>
                </ul>

                <a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>Edit Profile</a>
                <br />

            </div>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2><i class="fa fa-bars"></i> Perpesanan</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">

                  <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                      <li role="presentation" class="active"><a href="#tab_content11" id="home-tabb" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Diterima</a>
                      </li>
                      <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tabb" data-toggle="tab" aria-controls="profile" aria-expanded="false">Dibuat</a>
                      </li>
                    </ul>
                    <div id="myTabContent2" class="tab-content">
                      <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                          <div id="dafpesan3untuk"></div>
                      </div>
                      <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                        <div id="dafpesan3oleh"></div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
