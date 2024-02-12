<?php
$infor=base_url()."core2/?rmod=xxx";
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="60; url=<?php echo $infor;?>" />

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

  <body class="login" style="background-color:#1f2029;">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">

        <div class="animate fadeIn form login_form" style="background-color:#efefef;margin:20px;padding:20px;border-radius:40px;">
          <section class="login_content">

                   <?php
                    echo form_open('core2/login_user','id="userForm" data-parsley-validate class="form-horizontal form-label-left"');
                    echo '<h1>VERIFIKASI PENGGUNA</h1>';
                    ?>
                    <div class="form-group">
                    <?php
                    $lakses=array();
                    $lakses = array('0'=>'Rekam Medik','1'=>'Kepegawaian','2'=>'Administrasi','4'=>'Kasir');
                    // Name Field
                    ?>
                    <input type="hidden" id="kdakses" name="kdakses" value="2">
                    <?php
                      //echo form_dropdown('kdakses' ,$lakses, '#', 'id="kdakses" class="select2_single form-control animated fadeInUp" style="float: left;"');
                          echo form_input(array('id' => 'nik', 'name' => 'nik','type'=>'password','class'=>'form-control animated fadeInUp', 'placeholder'=>'Isi KODE ID, Tekan ENTER','required'=>'required','style'=>'text-align:center'));
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
                  <h1 class="animated slideInRight"><i class="fa fa-universal-access"></i> Q MARSUPIUM</h1>
                  <p>@2024</p>
                </div>
                <div>
                  <h2 class="animated slideInLeft"><a href="<?php echo base_url().'auth/logout'?>" class="btn btn-danger btn-round"><i class="fa fa-lock white"></i></a></h2>
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
cleancok();
});

function cleancok(){
  deleteCookie('akses');
  deleteCookie('idjur');
  deleteCookie('idpeg');
  deleteCookie('jnsjur');
  deleteCookie('jur_akses');
  deleteCookie('jur_nmr');
  deleteCookie('jur_tgl');
  deleteCookie('kodejob');
  deleteCookie('kodejob1');
  deleteCookie('kodesu');
  deleteCookie('qtitle');
  deleteCookie('rmmod');
  deleteCookie('trx_jns');
  deleteCookie('simakses');
  deleteCookie('simkop');
  deleteCookie('precor');
}

function setCookie(name, value, days) {
  var d = new Date;
  d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
  document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString();
}


function deleteCookie(name) {
  setCookie(name, '', -1);
}

</script>

  </body>
</html>
