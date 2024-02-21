<?php
$this->load->view('backoff/layout/_999/head');
$this->load->view('backoff/layout/_999/qmenu');
?>


  <div class="right_col" role="main">
      <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <h1><?php echo lang('deactivate_heading');?></h1>
              <p><?php echo sprintf(lang('deactivate_subheading'), $user->username);?></p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
							<div class="container cropper">
								<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
								</div>
								<div class="col-md-9 col-sm-12 col-xs-12">



                  <?php echo form_open("auth/deactivate/".$user->id);?>

                    <p>
                    	<?php echo lang('deactivate_confirm_y_label', 'confirm');?>
                      <input type="radio" name="confirm" value="yes" checked="checked" />
                      <?php echo lang('deactivate_confirm_n_label', 'confirm');?>
                      <input type="radio" name="confirm" value="no" />
                    </p>

                    <?php echo form_hidden($csrf); ?>
                    <?php echo form_hidden(array('id'=>$user->id)); ?>

                    <p><?php echo form_submit('submit', lang('deactivate_submit_btn'));?></p>

                  <?php echo form_close();?>

								</div>
							</div>
      </div>

	      	</div>
	    </div>
	</div>
	<?php
	$this->load->view('backoff/layout/_999/'.$mod.'foot');
	?>

<script>
</script>

</body>
</html>
