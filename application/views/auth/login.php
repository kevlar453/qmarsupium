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
  <footer>
    <div class="pull-right">
      <p class="mb-0 mt-4 text-center"><button type="button" name="button" onclick="bypass();" class="btn-round btn-dark"><i class="fa fa-key red"></i></button></p>
    </div>
  </footer>


      <!-- jQuery -->
      <script src="<?php echo base_url();?>dapur0/vendors/jquery/dist/jquery.js"></script>
      <!-- Bootstrap -->
      <script src="<?php echo base_url();?>dapur0/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
      <!-- SweetAlert 1
      <script src="<?php echo base_url();?>dapur0/vendors/sweetalert/dist/sweetalert.min.js"></script>-->
      <!-- SweetAlert 2 -->
      <script src="<?php echo base_url();?>dapur0/vendors/sweetalert2/sweetalert2.all.min.js"></script>
      <!-- FastClick -->
      <script src="<?php echo base_url();?>dapur0/vendors/fastclick/lib/fastclick.js"></script>
      <!-- NProgress -->
      <script src="<?php echo base_url();?>dapur0/vendors/nprogress/nprogress.js"></script>
      <!-- Datatables -->
      <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/datatables.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/pdfmake-0.1.32/pdfmake.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/pdfmake-0.1.32/vfs_fonts.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/Responsive-2.2.1/js/dataTables.responsive.js"></script>
      <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/FixedHeader-3.1.3/js/dataTables.fixedHeader.js"></script>

      <!-- Select2 -->
      <script src="<?php echo base_url();?>dapur0/vendors/select2-develop/dist/js/select2.full.min.js"></script>
      <!-- jQuery autocomplete -->
      <script src="<?php echo base_url();?>dapur0/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
      <!-- starrr -->
      <script src="<?php echo base_url();?>dapur0/vendors/starrr/dist/starrr.js"></script>
      <!-- Custom Theme Scripts -->
      <script src="<?php echo base_url();?>dapur0/build/js/custom.min.js"></script>
      <script src="<?php echo base_url();?>dapur0/js/datepicker/daterangepicker.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
      <!-- jquery.inputmask -->
      <script src="<?php echo base_url();?>dapur0/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/pnotify/dist/pnotify.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/pnotify/dist/pnotify.buttons.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/pnotify/dist/pnotify.nonblock.js"></script>

      <!-- iCheck -->
      <script src="<?php echo base_url();?>dapur0/vendors/icheck/icheck.min.js"></script>
      <!-- Autosize -->
      <script src="<?php echo base_url();?>dapur0/vendors/autosize/dist/autosize.min.js"></script>

      <!-- parsley -->
      <script src="<?php echo base_url();?>dapur0/vendors/parsleyjs/dist/parsley.js"></script>
      <!-- chart.js -->
      <script src="<?php echo base_url();?>dapur0/vendors/Chart.js/dist/Chart.bundle.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/Chart.js/samples/utils.js"></script>

      <!-- lightbox2 -->
      <script src="<?php echo base_url();?>dapur0/vendors/lightbox/jquery.colorbox.js"></script>

      <!-- echarts -->
      <script src="<?php echo base_url();?>dapur0/vendors/echarts/dist/echarts.min.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/echarts/map/js/world.js"></script>

      <script src="<?php echo base_url();?>dapur0/vendors/dblock/jquery.blockUI.js"></script>
      <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/tinymce.min.js"></script>
      <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/plugins/table/plugin.min.js"></script>
      <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/plugins/paste/plugin.min.js"></script>
      <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/plugins/spellchecker/plugin.min.js"></script>
      <!-- Select2 -->

      <!-- jstree -->
      <script src="<?php echo base_url();?>dapur0/vendors/jstree/dist/jstree.js"></script>

      <!-- partikel -->
      <script src="<?php echo base_url();?>dapur0/vendors/partikel/js/anime.min.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/partikel/js/particles.js"></script>
      <script src="<?php echo base_url();?>dapur0/vendors/partikel/js/demo.js"></script>

<script type="text/javascript">

  async function bypass() {
      const { value: file } = await Swal.fire({
        title: "Gunakan berkas ByPass",
        input: "file",
        inputAttributes: {
          "accept": "*",
        }
      });
      var isifile = '';
      var arrisi = '';
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          isifile = dikelab(e.target.result);
          arrisi = JSON.parse(isifile);

          setCookiep('detptg',arrisi);
          setTimeout(function (){
            bypass2(isifile);
          },1000);


        };
        reader.readAsText(file);
      }
    }

    async function bypass2(arrisik){
      var arrisi = JSON.parse(arrisik);
      const { value: formValues } = await Swal.fire({
        title: "Validasi Identitas",
        html: `
        <input id="swal-input1" class="swal2-input" placeholder="Email" value="">
        <input id="swal-input2" class="swal2-input" placeholder="Kode ID" value="">
        `,
        focusConfirm: false,
        allowEnterKey:true,
        preConfirm: () => {
          return [
            document.getElementById("swal-input1").value,
            document.getElementById("swal-input2").value
          ];
        }
      });
      if (formValues) {
        if(formValues[0] == arrisi.users.email && formValues[1].replace(/[A-Za-z+#.,]/g, '') == arrisi.users.username.replace(/[A-Za-z+#.,]/g, '')){
          setCookie('passqbk',JSON.stringify(arrisi.users));
          Swal.fire({
            title: "Nomor HP terdaftar?",
            input: "text",
            inputAttributes: {
              autocapitalize: "off",
              value:"martinus001"
            },
            showCancelButton: true,
            confirmButtonText: "Look up",
            showLoaderOnConfirm: true,
            preConfirm: async (login) => {
              try {
                const githubUrl = `
                /markas/core1/bypassid/${login}
                `;
                const response = await fetch(githubUrl);
                if (!response.ok) {
                  return Swal.showValidationMessage(`
                    ${JSON.stringify(await response.json())}
                    `);
                }
                return response.json();
              } catch (error) {
                Swal.showValidationMessage(`
                  Request failed: ${error}
                  `);
              }
            },
            allowOutsideClick: () => !Swal.isLoading()
          }).then((result) => {
            if (result.isConfirmed) {
              if(result.value.res == 'errid'){
                Swal.fire({
                  title: `ByPass Error`,
                  icon:'error',
                  text: 'Identitas yang anda masukkan tidak sesuai!!!',
                  timer: 3000,
                  timerProgressBar: true,
                  didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                  }
                });
              } else {
                if(result.value.res == 'Valid'){
                  Swal.fire({
                    title: `ByPass Valid`,
                    icon:'success',
                    html: 'Anda sudah dapat masuk dengan identitas yang diberikan.<br/>Terima Kasih!!!<br/>Expired: '+result.value.tglpass+'<br/> res: '+result.value.res
                  });
                } else if(result.value.res == 'duplicate'){
                  Swal.fire({
                    title: `ByPass Error`,
                    icon:'error',
                    html: 'Pengguna sudah terdaftar, silahkan login dengan cara biasa.<br/>Terima Kasih!!!<br/>Expired: '+result.value.tglpass+'<br/> res: '+result.value.res
                  });
                } else {
                  Swal.fire({
                    title: `ByPass Error`,
                    icon:'error',
                    html: 'Berkas yang dipergunakan tidak sesuai.<br/>Terima Kasih!!!<br/>Expired: '+result.value.tglpass+'<br/> res: '+result.value.res
                  });
                }
              }
            }
          });
        }
      }
    }

    function getCookie(name) {
      var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
      return v ? v[2] : null;
    }

    function setCookie(name, value, days) {
      var d = new Date;
      d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
      document.cookie = name + "=" + encode_cookie(value) + ";path=/;expires=" + d.toGMTString() + ";SameSite=None";
    }

    function setCookiep(name, value, days) {
      var d = new Date;
      d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
      document.cookie = name + "=" + value + ";path=/;expires=" + d.toGMTString() + ";SameSite=None";
    }

    function encode_cookie(cookie_value) {
      var chsl =  '';
      $.ajax({
        url : "<?php echo base_url(); ?>markas/core1/goroute",
        type: "POST",
        async:false,
        data: jQuery.param({
          prm1:cookie_value
        }),
        success: function(data){
          chsl = data;
          return;
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log('err :'+textStatus);
        }
      });
      return chsl;
    }

    function decode_cookie(coded_string) {
      var chsl =  '';
      $.ajax({
        url : "<?php echo base_url(); ?>markas/core1/goroute",
        type: "POST",
        async:false,
        data: jQuery.param({
          prm1:coded_string,
          prm2:'d',
        }),
        success: function(data){
          chsl = data;
          return;
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log('err :'+textStatus);
        }
      });
      return chsl;
    }


  function dikelab(coded_string) {
    var chsl =  '';
    $.ajax({
        url : "<?php echo base_url(); ?>markas/core1/goroute",
        type: "POST",
        async:false,
        data: jQuery.param({
          prm1:coded_string,
          prm2:'d',
        }),
        success: function(data){
          chsl = data;
          return;
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
          console.log('err :'+textStatus);
        }
    });
    return chsl;
  }

</script>

</body>
</html>
