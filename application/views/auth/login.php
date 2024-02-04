<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>QMarsupium-2024</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/auth/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/auth/css/style.css">

</head>
<body>
	<a href="/" class="logo" target="_self">
		<img src="/dist/img/arlogo.png" alt="">
	</a>
  <section class="section main-banner" id="top" data-section="section1">
      <video autoplay muted loop id="bg-video">
        <source src="/dist/img/earth.mp4" type="video/mp4" />
      </video>

      <div class="video-overlay header-text">
          <div class="caption col-md-3 col-sm-12 col-xs-12">

            <div class="text-center align-self-center py-5">
    					<div class="section pb-5 pt-5 pt-sm-2 text-center">
                <h4 class="mb-4 pb-3"><?php echo lang('login_heading');?></h4>
                <p><?php echo lang('login_subheading');?></p>
                <div id="infoMessage"><?php echo $message;?></div>

                <?php echo form_open("auth/login");?>

                											<div class="form-group">
                												<input type="text" name="identity" class="form-style" placeholder="Surel" id="identity" autocomplete="off">
                												<i class="input-icon uil fas fa-envelope"></i>
                											</div>
                											<div class="form-group mt-2">
                												<input type="password" name="password" class="form-style" placeholder="Kata Sandi" id="password" autocomplete="off">
                												<i class="input-icon uil fas fa-lock"></i>
                											</div>
                											<div class="form-group mt-2">
                    <?php echo form_checkbox('remember', '1', FALSE, array('id'=>'remember','class'=>'form-style'));?>
                											</div>

                <?php echo form_submit('submit', lang('login_submit_btn'),array('class'=>'btn mt-4'));?>
                                            				<p class="mb-0 mt-4 text-center"><a href="forgot_password" class="link"><?php echo lang('login_forgot_password');?></a></p>

                <?php echo form_close();?>
    			      	</div>
    		      	</div>


          </div>
      </div>
  </section>

<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
