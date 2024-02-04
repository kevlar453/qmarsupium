<body class="nav-md">
  <?php
  $swakses = '';
  ?>
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo base_url();?>" class="site_title" id="top"><i class="fa fa-ambulance animated pulse infinite"></i> <span>Q-HMS 2017</span></a>
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
                if($kodejob=='444'||$kodejob=='222'||(int)$kodesu>=1){
                  $swakses = $kodejob!='444'?'&kodejob1=444':'';
                  ?>
                  <li><a><i class="fa fa-money"></i> Kasir <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area1'.$swakses; ?>">Dashboard</a></li>
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area2'.$swakses; ?>">Rincian</a></li>
                    </ul>
                  </li>
                  <?php
              }
                if($kodejob=='222'&&$kodejob!='000'||(int)$kodesu>=1){
                  $swakses = $kodejob!='222'?'&kodejob1=222':'';
                ?>
                  <li><a><i class="fa fa-calculator"></i> Akuntansi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area1'.$swakses; ?>">Dashboard</a></li>
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area2'.$swakses; ?>" >Transaksi</a></li>
                      <li><a><i class="fa fa-file"></i> Laporan <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?php echo base_url().'markas/core1/?rmod=area81'.$swakses; ?>">Transaksi</a></li>
                          <li><a href="<?php echo base_url().'markas/core1/?rmod=area4'.$swakses; ?>" >Buku Besar</a></li>
                          <?php
                          if((int)$kodesu>=1){
                            ?>
                            <li><a href="<?php echo base_url().'markas/core1/?rmod=area82'.$swakses; ?>" >Neraca</a></li>
                            <?php
                          }
                          ?>
                          <li><a href="<?php echo base_url().'markas/core1/?rmod=area83'.$swakses; ?>">Billing</a></li>
                        </ul>
                      </li>
                      <li><a><i class="fa fa-gear"></i> Pengaturan <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <li><a href="<?php echo base_url().'markas/core1/?rmod=area5'.$swakses; ?>">Saldo Awal</a></li>
                          <li><a href="<?php echo base_url().'markas/core1/?rmod=area7'.$swakses; ?>" >Perkiraan</a></li>
                        </ul>
                      </li>
                    </ul>
                  </li>
                  <?php
                }
                if($kodejob=='111'||(int)$kodesu>=1){
                  $swakses = $kodejob!='111'?'&kodejob1=111':'';
                  ?>
                  <li><a><i class="fa fa-gears"></i> Sekretariat <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area1'.$swakses; ?>">Kehadiran</a></li>
<!--
                                        <li><a href="<?php echo base_url().'markas/core1/?rmod=area2'.$swakses; ?>" >Rekap Absen</a></li>
-->
                    </ul>
                  </li>
                  <?php
                }
                if($kodejob=='000'||(int)$kodesu>=1){
                  $swakses = $kodejob!='000'?'&kodejob1=000':'';
                  ?>
                  <li><a><i class="fa fa-clipboard"></i> Informasi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/person/?rmod=area1'.$swakses; ?>">Registrasi</a></li>
                      <li><a href="<?php echo base_url().'markas/person/?rmod=area2'.$swakses; ?>" >Daftar Px</a></li>
                      <li><a href="<?php echo base_url().'markas/person/?rmod=area5'.$swakses; ?>" >Laporan</a></li>
                    </ul>
                  </li>
                  <?php
                }
                if($akses=='2009.07.007'||(int)$kodesu>=1){
                  $swakses = $kodejob!='222'?'&kodejob1=222':'';
                  ?>
                  <li><a><i class="fa fa-users"></i> SDM <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area6'.$swakses; ?>" >Dokter</a></li>
                    </ul>
                  </li>
                  <?php
                }
                if($idpeg==$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')||$idpeg=='2013.07.013'|| $idpeg=='2012.09.026' ||(int)$kodesu>=1){
                  $swakses = $kodejob!='222'?'&kodejob1=222':'';
                  ?>
                  <li><a><i class="fa fa-file-text"></i> Rekam Medik <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area01'.$swakses; ?>" >Dashboard</a></li>
                      <li><a href="<?php echo base_url().'markas/core1/?rmod=area02'.$swakses; ?>" >Data Pasien</a></li>
                    </ul>
                  </li>
                  <?php
                }
                ?>
                  <?php
                if((int)$kodesu>=0){
                  ?>
                  <li><a href="<?php echo base_url().'markas/corex'; ?>"><i id="doksign" class="fa fa-cog flip"></i>Dokumentasi TIK</a></li>
                  <?php
                }
                  ?>
              </ul>
            </div>
            <div class="menu_section">
              <h3>Add On</h3>
              <ul class="nav side-menu">
                <li><a><i class="fa fa-bug"></i>Administrasi <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <div id="useraktif"></div>
                  </ul>
                </li>
                <li><a><i class="fa fa-windows"></i> Pelayanan <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <div id="yanaktif"></div>
                  </ul>
                </li>
              </ul>
            </div>
          </div>
          <!-- /sidebar menu -->
          <!-- /menu footer buttons -->
          <div class="sidebar-footer hidden-small">
            <a href="#top" data-toggle="tooltip" data-placement="top" title="Keatas" >
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
                <ul class="dropdown-menu dropdown-usermenu pull-right">
                  <?php
                  if($idpeg==$this->dbcore1->routekey('aDB1RDlhVm55U21LYjZrNm8vc1BHUT09','d')||$idpeg=='2013.07.013'||$idpeg=='2012.09.026'||(int)$kodesu>=1){
                    $swakses = $kodejob!='111'?'&kodejob1=111':'';
                    ?>
                    <li><a href="<?php echo base_url().'markas/core1/?rmod=area3'.$swakses; ?>"><span class="badge bg-red pull-right"><i class="fa fa-smile-o"></i></span> Profil</a></li>
                    <?php
                  }
                  ?>
                    <li>
                      <a href="#" data-toggle="modal" data-target=".bs-example-modal-lg"><span class="badge bg-red pull-right"><i class="fa fa-envelope"></i></span> Buat Pesan</a>
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
