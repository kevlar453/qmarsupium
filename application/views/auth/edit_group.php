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
              <h1><?php echo lang('edit_group_heading');?></h1>
              <p><?php echo lang('edit_group_subheading');?></p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
							<div class="container cropper">
								<div class="col-md-3 col-sm-3 col-xs-12 profile_left">
								</div>
								<div class="col-md-9 col-sm-12 col-xs-12">


                  <div id="infoMessage"><?php echo $message;?></div>

                  <?php echo form_open(current_url());?>
                  <div class="col-md-5 col-sm-12 col-xs-12">
                    <p>
                      <?php echo lang('edit_group_name_label', 'group_name');?> <br />
                      <?php echo form_input($group_name);?>
                    </p>
                  </div>

                  <div class="col-md-5 col-sm-12 col-xs-12">
                    <p>
                      <?php echo lang('edit_group_desc_label', 'description');?> <br />
                      <?php echo form_input($group_description);?>
                    </p>
                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <p><?php echo form_submit('submit', lang('edit_group_submit_btn'),'class="btn btn-success pull-right"');?></p>
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
