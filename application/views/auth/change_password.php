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
              <h1><?php echo lang('change_password_heading');?></h1>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
							<div class="container cropper">
								<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
								</div>
								<div class="col-md-9 col-sm-12 col-xs-12">


                  <div id="infoMessage"><?php echo $message;?></div>

                  <?php echo form_open("auth/change_password");?>

                        <p>
                              <?php echo lang('change_password_old_password_label', 'old_password');?> <br />
                              <?php echo form_input($old_password);?>
                        </p>

                        <p>
                              <label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label> <br />
                              <?php echo form_input($new_password);?>
                        </p>

                        <p>
                              <?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?> <br />
                              <?php echo form_input($new_password_confirm);?>
                        </p>

                        <?php echo form_input($user_id);?>
                        <p><?php echo form_submit('submit', lang('change_password_submit_btn'));?></p>

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
