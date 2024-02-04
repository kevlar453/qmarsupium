<?php
$here=base_url()."core2/?rmod=xxx";
$next=base_url()."core2/?rmod=yyy";
$home=base_url();
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="IE=edge" http-equiv="X-UA-Compatible">
  <meta content="width=device-width,initial-scale=1" name="viewport">
  <meta http-equiv="refresh" content="308; url=<?php echo $next;?>" />
  <title>RSKSA Information Board</title>
  <link href="<?php echo base_url()."dapur1/"; ?>vendor/4boot/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo base_url();?>dapur0/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="<?php echo base_url()."dapur1/"; ?>vendor/4boot/css/ionicons.min.css" rel="stylesheet">
<!--
  <link href="<?php echo base_url()."dapur1/"; ?>vendor/4boot/css/magnific-popup.css" rel="stylesheet">
-->
  <link href="<?php echo base_url()."dapur1/"; ?>vendor/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="<?php echo base_url()."dapur1/"; ?>vendor/owlcarousel/assets/owl.theme.default.min.css" rel="stylesheet">
  <link href="<?php echo base_url()."dapur1/"; ?>vendor/4boot/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>vendor/odometer/themes/odometer-theme-car.css" />
  <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>vendor/flipclock/flipclock.css" />
  <!--[if lt IE 9]>
  <script src=https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js>
  </script>
  <script src=https://oss.maxcdn.com/respond/1.4.2/respond.min.js>
  </script>
  <![endif]-->
  <!--[if IE]>
  <style>.flip-container.hover .back,.flip-container:hover .back{backface-visibility:visible!important}</style>
  <![endif]-->
  <!-- Animate css -->
  <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>css/animate.css">

</head>
<body>
  <div id="preloader">
    <div class="loader">
      <span></span>
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="home-page">
    <div class="introduction text_logo_intro">
      <div class="intro-content">
        <h1 class="animated slideInLeft">Selamat<br/>Datang di</h1>
        <span>RS</span>
        <span class="number animated jackInTheBox">K</span>
        <p class="text-capitalize slogan-text animated slideInRight">St. Antonius Ampenan</p>
      </div>
      <div class="other-content filter">
        <h1 class="animated slideInLeft">24 JAM</h1>
        <div class="nougd">621397</div>
<!--
        <span class="number animated jackInTheBox">K</span>
-->
        <p class="text-capitalize slogan-text animated slideInRight">Layanan UGD</p>
      </div>
      <div class="qbanner1 owl-carousel owl-theme">
        <?php
              foreach ($isiabsen as $pabs) {
                $jdisp = strlen($pabs['temp0_ket']);
                $vardisp = substr($pabs['temp0_ket'],0,2);
                if($vardisp=='04'||$vardisp=='10'||$vardisp=='13'||$vardisp=='14'||$vardisp=='15'){
                  switch ($vardisp) {
                    case '04':
                    echo '<div class="item tlabelp"><h2>Dokter Anda: </h2></div>';
                    echo '<div class="item tnamap"><h3>'.substr($pabs['temp0_ket'],2,$jdisp-2).'</h3></div>';
                      break;

                    case '10':
                    echo '<div class="item tlabelp"><h2>Laboratorium: </h2></div>';
                    echo '<div class="item tnamap"><h3>'.substr($pabs['temp0_ket'],2,$jdisp-2).'</h3></div>';
                      break;

                    case '13':
                    echo '<div class="item tlabelp"><h2>Radiologi: </h2></div>';
                    echo '<div class="item tnamap"><h3>'.substr($pabs['temp0_ket'],2,$jdisp-2).'</h3></div>';
                      break;

                    case '14':
                    echo '<div class="item tlabelp"><h2>Kasir: </h2></div>';
                    echo '<div class="item tnamap"><h3>'.substr($pabs['temp0_ket'],2,$jdisp-2).'</h3></div>';
                      break;

                    case '15':
                    echo '<div class="item tlabelp"><h2>Rekam Medis: </h2></div>';
                    echo '<div class="item tnamap"><h3>'.substr($pabs['temp0_ket'],2,$jdisp-2).'</h3></div>';
                      break;

                    default:
                    echo '<div class="item tlabelp"><h2>RSK St. Antonius Ampenan</h2></div>';
                    echo '<div class="item tlabelp"><h3>Pelayanan Terbaik</h3></div>';
                      break;
                  }

                }
              }
              ?>
              <div class="item"><h3>Kesehatan itu penting</h3></div>
              <div class="item"><h3>Konsultasikan dengan kami</h3></div>
              <div class="item"><h3>Jika ada masalah kesehatan</h3></div>
              <div class="item"><h3>Update Informasi Kami</h3></div>
              <div class="item"><h4>http://www.rskantonius-lombok.org</h3></div>
              <div class="item"><h3>Jangan Lupa!</h3></div>
              <div class="item"><h4>http://www.rskantonius-lombok.org</h3></div>
              <div class="item"><h3> </h3></div>
              <div class="item"><h2>Terima Kasih Kunjungannya!</h2></div>
</div>
        <div class="social-media">
<video width="100%" height="100%" loop autoplay>
<!--  <source src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/img/cucitangan2.webm" type="video/webm"> -->
<!--  <source src="/akses3/video/waktu.mp4" type="video/mp4"> -->
 <source src="https://www.youtube.com/watch?v=nk38uvgEWkM" type="video/mp4">

</video>
        </div>
        <div class="qbanner2">
          <img src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/img/128.gif" />
        </div>
    </div>

    <div class="four_nav_item menu">
      <div class="menu_button profile-btn" data-url_target=about_us>
        <div class="mask mask1" style=background-image:url(<?php echo base_url()."dapur1/"; ?>vendor/4boot/img/about.jpg)></div>
        <div class=heading>
          <!-- <i class="hidden-xs ion-ios-people-outline"></i> -->
          <div class="c-table">
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">+</h2></div>
              <div class="ccol kiri merah"><span class="area-dokterk igd">IGD</span></div>
              <div class="ccol odok kanan merah"><span id="jpx-igd" class="odometer animated pulse infinite">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">N</h2></div>
              <div class="ccol kiri biru"><span class="area-dokterk pum">Poli Umum</span></div>
              <div class="ccol odok kanan biru"><span id="jpx-pum" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">A</h2></div>
              <div class="ccol kiri merah"><span class="area-dokterk pki">Poli KIA</span></div>
              <div class="ccol odok kanan merah"><span id="jpx-pki" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">I</h2></div>
              <div class="ccol kiri biru"><span class="area-dokterk pgi">Poli Gigi</span></div>
              <div class="ccol odok kanan biru"><span id="jpx-pgi" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">R</h2></div>
              <div class="ccol kiri merah"><span class="area-dokterk aku">Poli Akupunktur</span></div>
              <div class="ccol odok kanan merah"><span id="jpx-aku" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">T</h2></div>
              <div class="ccol kiri biru"><span class="area-dokterk aku">Sp. Obgyn</span></div>
              <div class="ccol odok kanan biru"><span id="jpx-gyn" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">N</h2></div>
              <div class="ccol kiri merah"><span class="area-dokterk ort">Sp. Orthopedi</span></div>
              <div class="ccol odok kanan merah"><span id="jpx-ort" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">A</h22></div>
              <div class="ccol kiri biru"><span class="area-dokterk dlm">Sp. Peny.Dalam</span></div>
              <div class="ccol odok kanan biru"><span id="jpx-dlm" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol namabag hijau"><h2 class="animated rubberBand infinite">+</h2></div>
              <div class="ccol kiri merah"><span class="area-dokterk dbh">Sp. Bedah</span></div>
              <div class="ccol odok kanan merah"><span id="jpx-bdh" class="odometer">0</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="menu_button service-btn" data-url_target=service>
        <div class="mask mask2" style=background-image:url(<?php echo base_url()."dapur1/"; ?>vendor/4boot/img/service.jpg)>
        </div>
        <div class=heading>
          <!--<i class="hidden-xs ion-ios-lightbulb-outline"></i> -->
          <h2>Bangsal Yosefa</h2>
          <hr/>
          <div class="c-table">
            <div class="ct-cell">
              <div class="chead">Kelas</div><div class="chead">Terisi</div><div class="chead">Kosong</div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter">VVIP</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-yvvip1" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-yvvip0" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">VIP</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-yvip1" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-yvip0" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">KLS-1</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-ykl11" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-ykl10" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">KLS-2</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-ykl21" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-ykl20" class="odometer">0</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="menu_button portfolio-btn" data-url_target=portfolio>
        <div class="mask mask3" style=background-image:url(<?php echo base_url()."dapur1/"; ?>vendor/4boot/img/portfolio.jpg)>
        </div>
        <div class=heading>
          <h2>Bangsal Mikaela</h2>
          <hr/>
          <div class="c-table">
            <div class="ct-cell">
              <div class="chead">Kelas</div><div class="chead">Terisi</div><div class="chead">Kosong</div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">VVIP</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-mvvip1" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-mvvip0" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">KLS-2</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-mkl21" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-mkl20" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">KLS-3</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-mkl31" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-mkl30" class="odometer">0</span></div>
            </div>
          </div>
        </div>
      </div>
      <div class="menu_button contact-btn" data-url_target=contact>
        <div class="mask mask4" style=background-image:url(<?php echo base_url()."dapur1/"; ?>vendor/4boot/img/contact.jpg)></div>
        <div class=heading>
          <h2>Bangsal Helena</h2>
          <hr/>
          <div class="c-table">
            <div class="ct-cell">
              <div class="chead">Kelas</div><div class="chead">Terisi</div><div class="chead">Kosong</div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">VIP</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-hvip1" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-hvip0" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">KLS-1</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-hkl11" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-hkl10" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">KLS-2</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-hkl21" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-hkl20" class="odometer">0</span></div>
            </div>
            <div class="ct-cell">
              <div class="ccol kiri biru"><span class="area-dokter igd">KLS-3</span></div>
              <div class="ccol odo kanan hijau"><span id="jpx-hkl31" class="odometer">0</span></div>
              <div class="ccol odo kanan merah"><span id="jpx-hkl30" class="odometer">0</span></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/js/jquery-2.1.3.min.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/js/modernizr.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/js/jquery.easing.min.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/js/jquery.mixitup.min.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/js/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/owlcarousel/owl.carousel.min.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/4boot/js/script.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/odometer/odometer.js"></script>
  <script src="<?php echo base_url()."dapur1/"; ?>vendor/flipclock/flipclock.js"></script>

  <script type="text/javascript">
  $(document).on('ready', function () {
        loadantrian();
        loadkamar();
//        loadabsen();

    var animationEnd = (function(el) {
      var animations = {
        animation: 'animationend',
        OAnimation: 'oAnimationEnd',
        MozAnimation: 'mozAnimationEnd',
        WebkitAnimation: 'webkitAnimationEnd',
      };

      for (var t in animations) {
        if (el.style[t] !== undefined) {
          return animations[t];
        }
      }
    })(document.createElement('div'));


    setInterval( function () {
      $('.mask1').addClass('animated pulse').one(animationEnd, function(){
        $(this).removeClass('animated pulse');
      });
    }, 5000 );
    setInterval( function () {
      $('.mask2').addClass('animated pulse').one(animationEnd, function(){
        $(this).removeClass('animated pulse');
      });
    }, 5250 );
    setInterval( function () {
      $('.mask3').addClass('animated pulse').one(animationEnd, function(){
        $(this).removeClass('animated pulse');
      });
      $('.nougd').addClass('animated tada').one(animationEnd, function(){
        $(this).removeClass('animated tada');
      });
    }, 6000 );
    setInterval( function () {
      $('.mask4').addClass('animated pulse').one(animationEnd, function(){
        $(this).removeClass('animated pulse');
      });
    }, 6250 );

    setInterval( function () {
      loadantrian();
      loadkamar()
//      $('.menu_button').addClass('animated pulse');
}, 30000 );

$('.owl-carousel').owlCarousel({
  animateOut: 'zoomOutDown',
  animateIn: 'flipInX',
  items:1,
  stagePadding:30,
  smartSpeed:1450,
    loop:true,
    autoplay:true,
    autoWidth:false,
    center:true,
    dots:false
});

  });

    function loadabsen() {
      $.get("<?php echo base_url(); ?>core2/getabsnow", function (jdabs) {
        $('#pegaktif').html(jdabs)
      });
    }

    function loadantrian() {
      $.get("<?php echo base_url(); ?>core2/getdokantri/igd", function (igd) {
        $('#jpx-igd').html(igd)
      });
      $.get("<?php echo base_url(); ?>core2/getdokantri/umum", function (pum) {
        $('#jpx-pum').html(pum)
      });
      $.get("<?php echo base_url(); ?>core2/getdokantri/kia", function (pki) {
        $('#jpx-pki').html(pki)
      });
      $.get("<?php echo base_url(); ?>core2/getdokantri/gigi", function (pgi) {
        $('#jpx-pgi').html(pgi)
      });

      $.get("<?php echo base_url(); ?>core2/getdokantri/obgyn", function (gyn) {
        $('#jpx-gyn').html(gyn)
      });
      $.get("<?php echo base_url(); ?>core2/getdokantri/jantung", function (aku) {
        $('#jpx-aku').html(aku)
      });
      $.get("<?php echo base_url(); ?>core2/getdokantri/orto", function (ort) {
        $('#jpx-ort').html(ort)
      });
      $.get("<?php echo base_url(); ?>core2/getdokantri/dalam", function (dlm) {
        $('#jpx-dlm').html(dlm)
      });
      $.get("<?php echo base_url(); ?>core2/getdokantri/bedah", function (bdh) {
        $('#jpx-bdh').html(bdh)
      });
    }

    function loadkamar() {
      $.get("<?php echo base_url(); ?>core2/getkamari/11", function (yvvip1) {
        $('#jpx-yvvip1').html(yvvip1)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/11", function (yvvip0) {
        $('#jpx-yvvip0').html(yvvip0)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/12", function (yvip1) {
        $('#jpx-yvip1').html(yvip1)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/12", function (yvip0) {
        $('#jpx-yvip0').html(yvip0)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/13", function (ykl11) {
        $('#jpx-ykl11').html(ykl11)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/13", function (ykl10) {
        $('#jpx-ykl10').html(ykl10)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/14", function (ykl21) {
        $('#jpx-ykl21').html(ykl21)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/14", function (ykl20) {
        $('#jpx-ykl20').html(ykl20)
      });

      $.get("<?php echo base_url(); ?>core2/getkamari/21", function (mvvip1) {
        $('#jpx-mvvip1').html(mvvip1)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/21", function (mvvip0) {
        $('#jpx-mvvip0').html(mvvip0)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/24", function (mkl21) {
        $('#jpx-mkl21').html(mkl21)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/24", function (mkl20) {
        $('#jpx-mkl20').html(mkl20)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/25", function (mkl31) {
        $('#jpx-mkl31').html(mkl31)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/25", function (mkl30) {
        $('#jpx-mkl30').html(mkl30)
      });

      $.get("<?php echo base_url(); ?>core2/getkamari/32", function (hvip1) {
        $('#jpx-hvip1').html(hvip1)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/32", function (hvip0) {
        $('#jpx-hvip0').html(hvip0)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/33", function (hkl11) {
        $('#jpx-hkl11').html(hkl11)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/33", function (hkl10) {
        $('#jpx-hkl10').html(hkl10)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/34", function (hkl21) {
        $('#jpx-hkl21').html(hkl21)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/34", function (hkl20) {
        $('#jpx-hkl20').html(hkl20)
      });
      $.get("<?php echo base_url(); ?>core2/getkamari/35", function (hkl31) {
        $('#jpx-hkl31').html(hkl31)
      });
      $.get("<?php echo base_url(); ?>core2/getkamart/35", function (hkl30) {
        $('#jpx-hkl30').html(hkl30)
      });

    }


  </script>
  <script type="text/javascript">
    var clock;

    $(document).ready(function() {
      clock = $('.clock').FlipClock({
        clockFace: 'TwelveHourClock'
      });
    });
  </script>

</body>
</html>
