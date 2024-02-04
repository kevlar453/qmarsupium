<?php
$here=base_url()."core2/?rmod=xxx";
$next=base_url()."core2/?rmod=xxx";
$home=base_url();
?>

<!DOCTYPE html>
<html lang="id">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="1200; url=<?php echo $next;?>" />

    <title>QHMS 2017</title>

    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,300,600,700' rel='stylesheet' type='text/css'>

    <!-- Revolution css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()."dapur1/"; ?>vendor/rs-plugin/css/settings.css" media="screen"/>
    <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>vendor/rs-plugin/css/extralayer.css">

    <!-- ImageFlow -->
    <link href="<?php echo base_url();?>dapur0/vendors/imageflow/imageflow.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>dapur0/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Animate css -->
    <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>css/animate.css">


    <!-- Custom Style css -->
    <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>css/hover.css">
    <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>css/style.css">
    <link rel="stylesheet" href="<?php echo base_url()."dapur1/"; ?>css/responsive.css">
  </head>

  <body>
    <!--
<audio  autoplay="autoplay" loop="loop" volume="1.0">
<source src="http://192.168.0.1:8003/stream.ogg" type="audio/ogg">
Your browser does not support the audio element.
</audio>
-->
    <div id="lside1">
      <div class="scroll-left">
      <h1>POLIKLINIK</h1>
    </div>
    <div id="titles">
      <div id="titlecontent">
        <div id="dokter1"></div>
      </div>
    </div>

          </div>


          <div id="lside2">
            <h1>
              <span><div class="animated pulse infinite judul red" style="font-size:110%; color:red;">UGD 24 JAM:</div></span><br />
              <span><h2 style="font-size:80%;">0370-621397</h2></span><br />
              <span><div class="animated pulse infinite judul" style="font-size:110%; color:navy;">PENGADUAN:</div> </span><br />
              <span><h2 style="font-size:80%;">0370-636767</h2></span>
            </h1>
                </div>


    <div id="main">
      <div id="disp_gambar" class="imageflow">
        <img src="../../../dapur0/images/inform/1.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/2.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/3.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/4.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/5.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/6.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/7.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/8.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/9.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/10.jpg" width="100%" height="90%"/>
        <img src="../../../dapur0/images/inform/11.jpg" width="100%" height="90%"/>
      </div>
    </div>
    <div id="coverbesar">
      <div class="animate one">
        <h1 class="judul"><span>R</span><span>S</span><span>K</span><span>&nbsp;</span><span>S</span><span>t</span><span>.</span><span> </span><span>A</span><span>n</span><span>t</span><span>o</span><span>n</span><span>i</span><span>u</span><span>s</span><span>&nbsp;</span><span>A</span><span>m</span><span>p</span><span>e</span><span>n</span><span>a</span><span>n</span></h1>
      </div>
      <div class="animated flipInX infinite">
        <h1>
          <span>h</span><span>t</span><span>t</span><span>p</span><span>:</span><span>/</span><span>/</span><span>w</span><span>w</span><span>w</span><span>.</span><span>r</span><span>s</span><span>k</span><span>a</span><span>n</span><span>t</span><span>o</span><span>n</span><span>i</span><span>u</span><span>s</span><span>-</span><span>l</span><span>o</span><span>m</span><span>b</span><span>o</span><span>k</span><span>.</span><span>o</span><span>r</span><span>g</span>

        </h1>
      </div>

<!--
      <center><a onclick="document.location.href='<?php echo $home;?>'" ><h1 class="judul">RSK St. Antonius Ampenan</h1></a></center>
-->
      <!--
      <a onclick="document.location.href='<?php echo $home;?>'" ><center><img src="<?php echo base_url();?>dapur0/images/logorsk.png" width="30%" height="auto" /></center></a>
    -->
    <table>
      <tr>
        <td>
          <div id="info" class="animate two">
            <h1>GIERLINGS</h1>
            <h1>ANTONIUS</h1>
            <h1>GODELIVA</h1>
            <h1>KELAS I</h1>
            <h1>KELAS II</h1>
            <h1>KELAS III</h1>
        </div>
        </td>
        <td>
          <div id="info">
            <h1>: <span class="txt-rotate" data-period="2000"
                 data-rotate='[ "Executive 24 dan 25", "2 kamar 1 bed per kamar", "Terisi <?php echo $jumv1['jv1']; ?> bed", "Kosong <?php echo 2-$jumv1['jv1']; ?> bed" ]'></span>
            </h1>
            <h1>: <span class="txt-rotate" data-period="3000"
                 data-rotate='[ "President 1, 2, 3, 4, 5, 6, 7 dan 8", "8 kamar 1 bed per kamar", "Terisi <?php echo $jumv2['jv2']; ?> bed", "Kosong <?php echo 8-$jumv2['jv2']; ?> bed" ]'></span>
            </h1>
            <h1>: <span class="txt-rotate" data-period="4000"
                 data-rotate='[ "VIP 20, 21, 22, dan 23", "4 kamar 1 bed per kamar", "Terisi <?php echo $jumv3['jv3']; ?> bed", "Kosong <?php echo 4-$jumv3['jv3']; ?> bed" ]'></span>
            </h1>
            <h1>: <span class="txt-rotate" data-period="5000"
                 data-rotate='[ "Standart", "5 kamar 2 bed per kamar", "Terisi <?php echo $jumv4['jv4']; ?> bed", "Kosong <?php echo 10-$jumv4['jv4']; ?> bed" ]'></span>
            </h1>
            <h1>: <span class="txt-rotate" data-period="6000"
                 data-rotate='[ "Standart", "3 kamar 4 bed per kamar", "Terisi <?php echo $jumv5['jv5']; ?> bed", "Kosong <?php echo 12-$jumv5['jv5']; ?> bed" ]'></span>
            </h1>
            <h1>: <span class="txt-rotate" data-period="7000"
                 data-rotate='[ "Standart", "3 kamar 6 bed per kamar", "Terisi <?php echo $jumv6['jv6']; ?> bed", "Kosong <?php echo 18-$jumv6['jv6']; ?> bed" ]'></span>
            </h1>
        </div>
        </td>
      </tr>
    </table>
    </div>
    <div class="a animated wobble infinite">
      <img src="<?php echo base_url()."dapur0/"; ?>images/antonpng.png" width="100%" height="auto"/>
    </div>

    <div id="coverbawah">
      <div class="container">
        <h1 class="heading" data-target-resolver></h1>
      </div>
  </div>
<div id="qmedia">
<!--
Aquarium:
<iframe width="560" height="315" src="https://www.youtube.com/embed/n0Jh66jZmbo" frameborder="0" allowfullscreen></iframe>
Ocean:
<iframe width="560" height="315" src="https://www.youtube.com/embed/KzTTF_WNTfM" frameborder="0" allowfullscreen></iframe>

Donald:
<iframe width="560" height="315" src="https://www.youtube.com/embed/bEEevULaXes" frameborder="0" allowfullscreen></iframe>
<iframe width="560" height="315" src="https://www.youtube.com/embed/zIiW2NmJUQU" frameborder="0" allowfullscreen></iframe>
<iframe width="560" height="315" src="https://www.youtube.com/embed/lB3vauaOPlE" frameborder="0" allowfullscreen></iframe>

Play:
-->
<iframe width="100%" height="100%" src="https://www.youtube.com/embed/lB3vauaOPlE?rel=0&autoplay=1" fullscreen="0" frameborder="0" autoplay></iframe>
</div>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>dapur0/vendors/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/imageflow/imageflow.js"></script>
  <script type="text/javascript">
  var TxtRotate = function(el, toRotate, period) {
    this.toRotate = toRotate;
    this.el = el;
    this.loopNum = 0;
    this.period = parseInt(period, 10) || 5000;
    this.txt = '';
    this.tick();
    this.isDeleting = false;
  };

  TxtRotate.prototype.tick = function() {
    var i = this.loopNum % this.toRotate.length;
    var fullTxt = this.toRotate[i];

    if (this.isDeleting) {
      this.txt = fullTxt.substring(0, this.txt.length - 1);
    } else {
      this.txt = fullTxt.substring(0, this.txt.length + 1);
    }

    this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';

    var that = this;
    var delta = 300 - Math.random() * 100;

    if (this.isDeleting) { delta /= 4; }

    if (!this.isDeleting && this.txt === fullTxt) {
      delta = this.period;
      this.isDeleting = true;
    } else if (this.isDeleting && this.txt === '') {
      this.isDeleting = false;
      this.loopNum++;
      delta = 500;
    }

    setTimeout(function() {
      that.tick();
    }, delta);
  };


    $(document).on('ready', function () {
      loaddokter();
      animateDiv();
      $('.one').addClass('red');
      var elements = document.getElementsByClassName('txt-rotate');
      for (var i=0; i<elements.length; i++) {
        var toRotate = elements[i].getAttribute('data-rotate');
        var period = elements[i].getAttribute('data-period');
        if (toRotate) {
          new TxtRotate(elements[i], JSON.parse(toRotate), period);
        }
      }
      // INJECT CSS
      var css = document.createElement("style");
      css.type = "text/css";
      css.innerHTML = ".txt-rotate > .wrap { border-right: 0.1em solid #f23 }";
      document.body.appendChild(css);
  });

  setInterval( function () {
    $('.animate').addClass('loaded');
    $('.one').addClass('loaded');
    $('.letter').addClass('loaded');
    $('.reg-text').addClass('loaded');
    loaddokter();// function that make ajax reqesut for checking new records.
  }, 10000 );

  function loaddokter() {
    $.get("<?php echo base_url(); ?>core2/getdokter", function (jddokter) {
      // update the textarea with the time
      $("#dokter1").html(jddokter);
    });
  }

    function makeNewPosition(){

        // Get viewport dimensions (remove the dimension of the div)
        var h = $(window).height() - 50;
        var w = $(window).width() - 50;

        var nh = Math.floor(Math.random() * h);
        var nw = Math.floor(Math.random() * w);

        return [nh,nw];

    }

    function animateDiv(){
        var newq = makeNewPosition();
        var oldq = $('.a').offset();
        var speed = calcSpeed([oldq.top, oldq.left], newq);

        $('.a').animate({ top: newq[0], left: newq[1] }, speed, function(){
          animateDiv();
        });

    };

    function calcSpeed(prev, next) {

        var x = Math.abs(prev[1] - next[1]);
        var y = Math.abs(prev[0] - next[0]);

        var greatest = x > y ? x : y;

        var speedModifier = 0.1;

        var speed = Math.ceil(greatest/speedModifier);

        return speed;

    }


  </script>
  <script type="text/javascript">
  const resolver = {
  resolve: function resolve(options, callback) {
    // The string to resolve
    const resolveString = options.resolveString || options.element.getAttribute('data-target-resolver');
    const combinedOptions = Object.assign({}, options, {resolveString: resolveString});

    function getRandomInteger(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    };

    function randomCharacter(characters) {
      return characters[getRandomInteger(0, characters.length - 1)];
    };

    function doRandomiserEffect(options, callback) {
      const characters = options.characters;
      const timeout = options.timeout;
      const element = options.element;
      const partialString = options.partialString;

      let iterations = options.iterations;

      setTimeout(() => {
        if (iterations >= 0) {
          const nextOptions = Object.assign({}, options, {iterations: iterations - 1});

          // Ensures partialString without the random character as the final state.
          if (iterations === 0) {
            element.textContent = partialString;
          } else {
            // Replaces the last character of partialString with a random character
            element.textContent = partialString.substring(0, partialString.length - 1) + '_' + randomCharacter(characters);
          }

          doRandomiserEffect(nextOptions, callback)
        } else if (typeof callback === "function") {
          callback();
        }
      }, options.timeout);
    };

    function doResolverEffect(options, callback) {
      const resolveString = options.resolveString;
      const characters = options.characters;
      const offset = options.offset;
      const partialString = resolveString.substring(0, offset);
      const combinedOptions = Object.assign({}, options, {partialString: partialString});

      doRandomiserEffect(combinedOptions, () => {
        const nextOptions = Object.assign({}, options, {offset: offset + 1});

        if (offset <= resolveString.length) {
          doResolverEffect(nextOptions, callback);
        } else if (typeof callback === "function") {
          callback();
        }
      });
    };

    doResolverEffect(combinedOptions, callback);
  }
}

/* Some GLaDOS quotes from Portal 2 chapter 9: The Part Where He Kills You
 * Source: http://theportalwiki.com/wiki/GLaDOS_voice_lines#Chapter_9:_The_Part_Where_He_Kills_You
 */
const strings = [
  'RSK. St. Antonius Ampenan adalah',
  'karya kerasulan Gereja dan lembaga kesehatan non profit',
  'yang menjunjung tinggi martabat manusia,',
  'menghormati dan membela kehidupan sejak dini',
  'berdasarkan nilai-nilai, moral',
  'dan spiritualitas Katolik, Pancasila',
  'dan mau bekerjasama secara profesional',
  'dengan semua pihak yang berkehendak baik',
  'demi melayani,',
  'meningkatkan dan membangun derajat',
  'kesehatan masyarakat dan kesejahteraan karyawannya'
];

let counter = 0;

const options = {
  // Initial position
  offset: 0,
  // Timeout between each random character
  timeout: 2,
  // Number of random characters to show
  iterations: 14,
  // Random characters to pick from
  characters: ['S','A','N','T','O','-','A','N','T','O','N','I','U','S'],
  // String to resolve
  resolveString: strings[counter],
  // The element
  element: document.querySelector('[data-target-resolver]')
}

// Callback function when resolve completes
function callback() {
  setTimeout(() => {
    counter ++;

    if (counter >= strings.length) {
      counter = 0;
    }

    let nextOptions = Object.assign({}, options, {resolveString: strings[counter]});
    resolver.resolve(nextOptions, callback);
  }, 3000);
}

resolver.resolve(options, callback);
  </script>
  <script type="text/javascript">
  domReady(function()
  {
//      var instanceOne = new ImageFlow();
//      instanceOne.init({ ImageFlowID: 'disp_gambar' });
      var circular_3 = new ImageFlow();
      circular_3.init({
          ImageFlowID: 'disp_gambar',
          circular: true,
//          reflections: false,
          reflectionP: 0.5,
          slider: false,
          captions: false,
          xStep: 150,
          imageFocusM: 4.0,
          startID: 1,
          slideshow: true,
          slideshowAutoplay: true,
          opacity: true,
          opacityArray: [9, 4, 3, 2, 1]
      });
  });
  </script>
<!-- Text Tengah -->
  </body>
</html>
