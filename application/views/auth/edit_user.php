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
              <h1><?php echo lang('edit_user_heading');?></h1>
              <p><?php echo lang('edit_user_subheading');?></p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
							<div class="container cropper">
								<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                  <div id="infoMessage"><?php echo $message;?></div>
								</div>
								<div class="col-md-9 col-sm-12 col-xs-12">



                  <?php echo form_open(uri_string());?>

                  <div class="col-md-5 col-sm-12 col-xs-12 profile_left">
                    <p>
                      <?php echo lang('edit_user_fname_label', 'first_name');?> <br />
                      <?php echo form_input($first_name);?>
                    </p>
  								</div>

                  <div class="col-md-5 col-sm-12 col-xs-12 profile_left">
                    <p>
                      <?php echo lang('edit_user_lname_label', 'last_name');?> <br />
                      <?php echo form_input($last_name);?>
                    </p>
                </div>

                <div class="col-md-5 col-sm-12 col-xs-12 profile_left">
                  <p>
                    <?php echo lang('edit_user_phone_label', 'phone');?> <br />
                    <?php echo form_input($phone);?>
                  </p>
              </div>

              <div class="col-md-12 col-sm-12 col-xs-12 profile_left">
                <div class="col-md-5 col-sm-12 col-xs-12 profile_left">
                  <p>
                    <?php echo lang('edit_user_password_label', 'password');?> <br />
                    <?php echo form_input($password);?>
                  </p>
                </div>

                <div class="col-md-5 col-sm-12 col-xs-12 profile_left">
                  <p>
                    <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?><br />
                    <?php echo form_input($password_confirm);?>
                  </p>
                </div>
              </div>

          <div class="col-md-12 col-sm-12 col-xs-12 profile_left" style="padding-left:40px;">
            <h4><?php echo lang('edit_user_groups_heading');?></h4>
            <?php foreach ($groups as $group):?>
            <label class="checkbox">
              <?php
              $gID=$group['id'];
              $checked = null;
              $item = null;
              foreach($currentGroups as $grp) {
              if ($gID == $grp->id) {
              $checked= ' checked="checked"';
              break;
              }
              }
              ?>
              <input type="checkbox" name="groups[]" class="" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
              <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
            </label>
            <?php endforeach?>


        </div>

        <div class="col-md-12 col-sm-12 col-xs-12 profile_left">
          <?php echo form_hidden('id', $user->id);?>
          <?php echo form_hidden($csrf); ?>
          <p><?php echo form_submit('submit', lang('edit_user_submit_btn'),'class="btn btn-success pull-right"');?></p>
      </div>

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
