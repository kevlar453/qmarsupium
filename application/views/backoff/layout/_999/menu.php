<body class="nav-md">
  <?php
  $swakses = '';
  ?>
  <div class="container body">
    <div class="main_container">
      <div id="myNav" class="overlay  slideInDown animated" style="opacity:.8;">

        <center>
        <div class="overlay-content center">
          <h1>Q-MARSUPIUM</h1>
          <h2>A beautiful support for your bussiness</h2>
          <blockquote>Sistem ini dibuat untuk mempermudah pekerjaan pemasukkan, pengolahan, dan analisa data keuangan yang akuntabel.</blockquote>
        </div>
      </center>

      </div>


      <div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo base_url();?>" class="site_title" id="top"><i class="fa fa-universal-access animated pulse infinite"></i> <span>Q-MARSUPIUM</span></a>
          </div>
          <div class="clearfix"></div>
          <!-- menu profile quick info -->
          <div class="profile clearfix">
            <div class="profile_pic"></div>
            <div class="profile_info">
              <span id="salam_jam"></span>
              <h2 id="salam_nama"></h2>
            </div>
          </div>
          <!-- menu profile quick info -->
          <div class="clearfix"></div>
          <br />
          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <h3>MENU</h3>
              <ul class="nav side-menu">

                <?php
                if($kodejob=='444'){
                  ?>
                <li><a href="<?php echo base_url().'markas/core1/?rmod=area1'.$swakses; ?>">Dashboard</a></li>
                <li><a href="<?php echo base_url().'markas/core1/?rmod=area2'.$swakses; ?>" >Penilaian</a></li>
                <?php
              }
              ?>


                <?php
                if($kodejob=='222'){
                  ?>
                  <li><a href="<?php echo base_url().'markas/core1/?rmod=area1'.$swakses; ?>">Dashboard</a></li>
                  <li><a href="<?php echo base_url().'markas/core1/?rmod=area2'.$swakses; ?>" >Transaksi</a></li>
                  <li><a><i class="fa fa-file"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area81'.$swakses; ?>">Transaksi</a></li>
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area4'.$swakses; ?>" >Buku Besar</a></li>
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area82'.$swakses; ?>" >Neraca</a></li>
                      <li><a href="#" class="dark">[L1] Posisi Keuangan</a></li>
                      <li><a href="#"  class="dark">[L2] Aktivitas Keuangan</a></li>
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area84'.$swakses; ?>" >[L3] Arus Kas</a></li>
                      <li><a href="#"  class="dark">[L4] Realisasi</a></li>
                      <li><a href="#"  class="dark">[L5] Rekap Wajib</a></li>
                      <li><a href="#"  class="dark">[L6] Rekap Alokasi</a></li>

                    </ul>
                  </li>
                  <li><a><i class="fa fa-gear"></i> Pengaturan <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area5'.$swakses; ?>">Saldo Awal</a></li>
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area7'.$swakses; ?>" >Perkiraan</a></li>
                    </ul>
                  </li>
                  <?php
                }
                ?>


                <li><a href="<?php echo base_url().'markas/corex'; ?>"><i id="doksign" class="fa fa-info flip"></i>Admin</a></li>
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a href="#" onclick="geserke('.right_col')" data-toggle="tooltip" data-placement="top" title="Keatas" >
              <span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Jam">
              <number id="hours">12</number>
            </a>
            <a data-toggle="tooltip" data-placement="top" title="Menit">
              <number id="minutes">45</number>
            </a>
            <a data-toggle="tooltip" data-placement="top">
              <number id="ampm">AM</number>
            </a>
          </div>
        </div>
      </div>
      <!-- top navigation -->
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="glyphicon glyphicon-move"></i></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                  <i id="icopengguna" class="glyphicon glyphicon-user blue animated infinite pulse"></i>
                </a>
                <ul class="dropdown-menu dropdown-usermenu pull-right" id="mntool">
                  <?php
                  if($idpeg==$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')||(int)$kodesu>=1){
                    $swakses = $kodejob!='111'?'&kodejob1=111':'';
                    ?>
                    <li><a href="<?php echo base_url().'markas/core1/?rmod=area3'.$swakses; ?>"><span class="badge bg-green pull-right"><i class="fa fa-smile-o"></i></span> Profil</a></li>
                    <?php
                  }
                  ?>
                    <li>
                      <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"><span class="badge bg-green pull-right"><i class="fa fa-envelope"></i></span> Buat Pesan</a>
                    </li>
                    <li>
                      <a href="<?php echo base_url();?>core2/logout"><span class="badge bg-red pull-right"><i class="fa fa-sign-out"></i></span> Keluar</a>
                    </li>
                    <div id="useraktif"></div>
                </ul>
              </li>
              <li role="presentation" class="dropdown">
                <a class="dropdown-toggle info-number" data-toggle="modal" data-target=".bs-example-modal-psn" onclick="pesanmark();">
                  <i  id="tanda" class="fa fa-envelope-o"></i>
                  <span  id="tandan" class="badge bg-green tada green animated">0</span>
                </a>
              </li>
          </ul>
      </nav>
  </div>
</div>
<!-- /top navigation -->
