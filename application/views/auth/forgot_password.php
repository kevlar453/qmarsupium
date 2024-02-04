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

	<div class="section">
		<div class="container">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
<!--
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
                -->
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">


                      <h1><?php echo lang('forgot_password_heading');?></h1>
                      <p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label);?></p>

                      <div id="infoMessage"><?php echo $message;?></div>

                      <?php echo form_open("auth/forgot_password");?>

                            <p>
                            	<label for="identity"><?php echo (($type=='email') ? sprintf(lang('forgot_password_email_label'), $identity_label) : sprintf(lang('forgot_password_identity_label'), $identity_label));?></label>
                              <div  class="form-group">
                            	<?php echo form_input($identity);?>
                              <i class="input-icon uil fas fa-envelope"></i>
                            </div>
                            </p>

                            <p><?php echo form_submit('submit', lang('forgot_password_submit_btn'), array('class'=>'btn'));?></p>

                      <?php echo form_close();?>

                      <div>
                        <a href="<?php echo base_url().'auth/login'?>" class="link">Kembali</a>
                      </div>


				      					</div>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
											<h4 class="mb-4 pb-3">Sign Up</h4>
											<div class="form-group">
												<input type="text" name="logname" class="form-style" placeholder="Your Full Name" id="logname" autocomplete="off">
												<i class="input-icon fas fa-user"></i>
											</div>
											<div class="form-group mt-2">
												<input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
												<i class="input-icon fas fa-envelope"></i>
											</div>
											<div class="form-group mt-2">
												<input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
												<i class="input-icon fas fa-lock"></i>
											</div>
											<a href="#" class="btn mt-4">submit</a>
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
<script src="<?php echo base_url(); ?>plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
