<?php
$infor=base_url()."core2/?rmod=rrr";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="refresh" content="120; url=<?php echo $infor;?>" />

  <title>QHMS 2017</title>

  <!-- Bootstrap -->
  <link href="<?php echo base_url();?>dapur0/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="<?php echo base_url();?>dapur0/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Animate.css -->
  <link href="<?php echo base_url();?>dapur0/build/css/animate.min.css" rel="stylesheet">

  <!-- Custom Theme Style -->
  <link href="<?php echo base_url();?>dapur0/build/css/custom.min.css" rel="stylesheet">
</head>
<body class="login">
  <div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>
    <div class="login_wrapper">
      <div class="animate form login_form">
        <section class="login_content">
          <?php
          echo form_open('core2/login_user','id="userForm" data-parsley-validate class="form-horizontal form-label-left"');
          echo '<h1>SELAMAT DATANG</h1>';
          ?>
            <div class="form-group">
              <?php
              $lakses=array();
              $lakses = array('0'=>'Rekam Medik','1'=>'Kepegawaian','2'=>'Administrasi','4'=>'Kasir');
              echo form_dropdown('kdakses' ,$lakses, '#', 'id="kdakses" class="select2_single form-control animated fadeInUp" style="float: left;"');
              echo form_input(array('id' => 'nik', 'name' => 'nik','type'=>'password','class'=>'form-control animated fadeInUp', 'placeholder'=>'Pilih MENU, Isi KODE, Tekan ENTER','required'=>'required'));
              ?>
            </div>
              <?php
              echo form_close();
              ?>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1 class="animated slideInRight"><i class="fa fa-ambulance"></i> <span class="red">Q</span>HMS 2017</h1>
                  <marquee>Untuk menjaga kestabilan sistim, lima menit tanpa aktifitas akan otomatis <i>logout</i>. <span class="blue">Silahkan login ulang!</span></marquee>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>

      <!-- jQuery -->
      <script src="<?php echo base_url();?>dapur0/vendors/jquery/dist/jquery.min.js"></script>
      <script type="text/javascript">
      $(document).ready(function(){
        $('#nik').keyup(function(){
          var valnik = $('#nik').val();
          var len = valnik.length;
          if (len < 3 || len > 8) {
            valnik = valnik.substring(0, 11);
            $("#nik").css("color", "blue");
          } else {
            $("#nik").css("color", "red");
          };
        })
      });
    </script>
  </body>
</html>
