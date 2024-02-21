<body class="nav-md">
  <?php
  $swakses = '';
  ?>
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col menu_fixed">
  <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo base_url();?>markas/core1" class="site_title" id="top"><i class="fa fa-universal-access animated pulse infinite"></i> <span>Q-MARSUPIUM 2024</span></a>
          </div>

          <div class="clearfix"></div>
          <br />
          <br />
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <?php if($mod == 'q'){?>
              <h3>DAFTAR ISI</h3>
            <?php } else {?>
              <h2 class="grid__item theme-9">
                <button class="balikneh particles-button"><i class="fa fa-hand-o-left red"></i> Kembali</button>
              </h2>
              <?php };?>
              <ul class="nav side-menu">
                <?php
                if(!empty($mnovr)){
                ?>
                  <li><a><i class="fa fa-money"></i> Dokumentasi <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      foreach ($mnovr as $ovr) {
                      ?>
                      <li><a href="<?php echo base_url().'markas/corex/goread/'.$this->dbcore1->routekey($ovr->qvault_docnum).'/'.$ovr->qvault_docdesc; ?>" title="<?php echo strip_tags($this->dbcore1->routekey($ovr->qvault_docdesc,'d'));?>"><?php echo $ovr->qvault_docnum;?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                <?php
                }
                ?>

                <li><a><i class="fa fa-users"></i> Akun <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php
                  if((int)$this->dbcore1->routekey(get_cookie('simakses'),'d')=='00'){
                    ?>
                    <li><a href="<?php echo base_url()?>auth/create_user" title="">Baru</a></li>
                    <?php
                  }
                    ?>
                    <li><a href="<?php echo base_url()?>auth/listuser" title="">Daftar</a></li>
                  </ul>
                </li>
                <li><a><i class="fa fa-cogs"></i> Sistim <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="#" title="">Baru</a></li>
                    <li><a href="#" title="">Daftar</a></li>
                  </ul>
                </li>
                <?php
                if(!empty($mnpwd)){
                ?>
                  <li><a><i class="fa fa-money"></i> Password <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      foreach ($mnpwd as $pwd) {
                      ?>
                      <li><a href="<?php echo base_url().'markas/corex/goread/'.$this->dbcore1->routekey($pwd->qvault_docnum).'/'.$pwd->qvault_docdesc; ?>" title="<?php echo strip_tags($this->dbcore1->routekey($pwd->qvault_docdesc,'d'));?>"><?php echo $pwd->qvault_docnum;?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                <?php
                }
                ?>
                <?php
                if(!empty($mnsvr)){
                ?>
                  <li><a><i class="fa fa-money"></i> Password <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      foreach ($mnsvr as $svr) {
                      ?>
                      <li><a href="<?php echo base_url().'markas/corex/goread/'.$this->dbcore1->routekey($svr->qvault_docnum).'/'.$svr->qvault_docdesc; ?>" title="<?php echo strip_tags($this->dbcore1->routekey($svr->qvault_docdesc,'d'));?>"><?php echo $svr->qvault_docnum;?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                <?php
                }
                ?>
                <?php
                if(!empty($mnkom)){
                ?>
                  <li><a><i class="fa fa-money"></i> Password <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      foreach ($mnkom as $kom) {
                      ?>
                      <li><a href="<?php echo base_url().'markas/corex/goread/'.$this->dbcore1->routekey($kom->qvault_docnum).'/'.$kom->qvault_docdesc; ?>" title="<?php echo strip_tags($this->dbcore1->routekey($kom->qvault_docdesc,'d'));?>"><?php echo $kom->qvault_docnum;?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                <?php
                }
                ?>
                <?php
                if(!empty($mnapp)){
                ?>
                  <li><a><i class="fa fa-money"></i> Password <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      foreach ($mnapp as $app) {
                      ?>
                      <li><a href="<?php echo base_url().'markas/corex/goread/'.$this->dbcore1->routekey($app->qvault_docnum).'/'.$app->qvault_docdesc; ?>" title="<?php echo strip_tags($this->dbcore1->routekey($app->qvault_docdesc,'d'));?>"><?php echo $app->qvault_docnum;?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                <?php
                }
                ?>
                <?php
                if(!empty($mninv)){
                ?>
                  <li><a><i class="fa fa-money"></i> Password <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <?php
                      foreach ($mninv as $inv) {
                      ?>
                      <li><a href="<?php echo base_url().'markas/corex/goread/'.$this->dbcore1->routekey($inv->qvault_docnum).'/'.$inv->qvault_docdesc; ?>" title="<?php echo strip_tags($this->dbcore1->routekey($inv->qvault_docdesc,'d'));?>"><?php echo $inv->qvault_docnum;?></a></li>
                      <?php
                      }
                      ?>
                    </ul>
                  </li>
                <?php
                }
                ?>
              </ul>
            </div>
          </div>
          <div class="sidebar-footer hidden-small">
            <a href="<?php echo base_url();?>" data-toggle="tooltip" data-placement="top" title="Keluar" >
              <span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span>
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
      <div class="top_nav">
        <div class="nav_menu">
          <nav class="" role="navigation">
            <div class="nav toggle">
              <a id="menu_toggle"><i class="glyphicon glyphicon-move"></i></a>
            </div>
      </nav>
  </div>
</div>
<!-- /top navigation -->
