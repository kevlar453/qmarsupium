<!-- compose -->
<div class="modal animated fadeIn bs-example-modal-psn" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog modal-lg">
  <div class="modal-content">

    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" onclick="loadpesan();"><span aria-hidden="true">×</span>
      </button>
      <h4 class="modal-title" id="myModalLabel">Daftar Pesan</h4>
    </div>
    <div class="modal-body" data-spy="scroll">
      <ul class="list-unstyled timeline widget">
        <div id="dafpesan"></div>
      </ul>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target=".bs-example-modal-lg"><i class="fa fa-paper-plane"></i> BARU</button>
    </div>

  </div>
</div>
</div>
<!-- /compose -->

<!-- Small modal -->
<div class="modal animated fadeInUp bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Pesan Anda</h4>
      </div>
      <div class="modal-body">
        <?php
        echo form_open('markas/core1/isi_pesan',array('id'=>'krmpesan','data-parsley-validate class'=>'form-horizontal form-label-left'));
        ?>
        <div class="input-group input-group-sm">
              <?php
              echo form_label('Judul','lt_ur',array('class'=>'input-group-addon'));
              echo form_input(array('id' => 'ps_jdl', 'name' => 'ps_jdl','class'=>'form-control' ,'placeholder' => 'Harus diisi'));
                  echo '<span class="input-group-addon">Untuk</span>';
                  echo form_dropdown('ps_tuk', $cgroup, '0000.00.000', 'id="ps_tuk" class="form-control" style="float: left;"');
              ?>
        </div>
        <div class="input-group input-group-xs">
          <?php
          echo form_textarea(array('id' => 'ps_ket', 'name' => 'ps_ket','class'=>'form-control'));
          ?>
        </div>
        <?php
        echo form_close();
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
        <button type="button" class="btn btn-primary" id="kirimpsn"  data-dismiss="modal">KIRIM</button>
      </div>

    </div>
  </div>
</div>
<!-- /modals -->

<!-- footer content -->

        <footer>
          <div class="pull-left">
            <h2 class="small">Update Terakhir: <span id="cekupdate"></span></h2>
          </div>
            <div class="pull-right">
                Q-MARSUPIUM 2024, Created by AR Setontong. Use for presentation purpose only. <br />
                <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
            </div>
            <div class="clearfix"></div>
        </footer>
<!-- /footer content -->

    </div>
</div>

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

    <script src="<?php echo base_url();?>dapur0/vendors/moment/min/moment.min.js"></script>
    <!-- Ion.RangeSlider -->
    <script src="<?php echo base_url();?>dapur0/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js"></script>


        <!-- echarts -->
        <script src="<?php echo base_url();?>dapur0/vendors/echarts/dist/echarts.min.js"></script>
        <script src="<?php echo base_url();?>dapur0/vendors/echarts/map/js/world.js"></script>

        <?php
         if(isset($kodejob) && $kodejob == '444'){
          ?>
          <script src="<?php echo base_url();?>dapur0/vendors/echarts/test/esl.js"></script>
          <script src="<?php echo base_url();?>dapur0/vendors/echarts/test/config.js"></script>
          <script src="<?php echo base_url();?>dapur0/vendors/echarts/test/config.js"></script>
          <script src="<?php echo base_url();?>dapur0/vendors/echarts/test/config.js"></script>
          <script src="<?php echo base_url();?>dapur0/vendors/echarts/test/config.js"></script>

          <?php
        }
        ?>


    <script>
      var varopta = decode_cookie(getCookie('simakses'));
    var ampm = "AM";
    var pegid = '<?php echo $idpeg;?>';
    var ptid = pegid.split('.').join('');
    var varea = '<?php echo $rmmod;?>';
    var vjob = '<?php echo $kodejob1;?>';
    $.ajax({
            url:"<?php echo base_url().'dapur0/images/foto/'; ?>" + ptid + ".png",
            error: function()
            {
              if(varea=='area3' && vjob=='111'){
                $("#potone").html('<img class="imgzoom img-responsive avatar-view" src="<?php echo base_url(); ?>dapur0/images/foto/user.png" alt="Foto Pegawai">');
              }
              $(".profile_pic").html('<img src="<?php echo base_url(); ?>dapur0/images/foto/user.png" alt="..." class="img-circle profile_img">');
            },
            success: function()
            {
              if(varea=='area3' && vjob=='111'){
                $("#potone").html('<img class="imgzoom img-responsive avatar-view" src="<?php echo base_url().'dapur0/images/foto/' . str_replace('.','',$idpeg) . '.png'; ?>" alt="Foto Pegawai">');
              }
              $(".profile_pic").html('<img src="<?php echo base_url(); ?>dapur0/images/foto/' + ptid + '.png" alt="..." class="img-circle profile_img">');
            }
        });

        $('.helum').on('click',function(){
          var particles = new Particles('.helum');
          particles.disintegrate({
            duration: 700,
            delay: 10,
            type: 'triangle',
            complete: function(){
              history.back()
            }
          });
        });


    $(document).ready(function() {
      $.unblockUI();
//      $("#myNav").css('height','100%');
//      $('.sidebar').css('opacity',0);
      var pegnik = "<?php echo $idpeg;?>";
        $.ajax({
            url: "<?php echo base_url().'markas/corex/cek_doknew'?>",
            type: 'POST',
            success: function() {
                $('#doksign').addClass('red');
                $('#doksign').addClass('animated');
            }
        });
        deleteCookie('jspil');

//      setup();
      loadpesan();
//      cekuserak();
      loadsalam(pegnik);
      $('#headjudul').text(decode_cookie(getCookie('qtitle')));
    });
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        minDate: '0',
        format: "dd-mm-yyyy",
        changeMonth: true,
        changeYear: true,
        todayHighlight: true,
        orientation: "top auto",
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        onSelect: function(selectedDate) {
                 alert( picker.val() );
             }
    });

    $(":input").inputmask();
    $(".select2_single").select2({
        placeholder: "Pilihan/Keyword",
        allowClear: true

    });
    $(".select2_group").select2({

    });
    $(".select2_multiple").select2({
        maximumSelectionLength: 10,
        placeholder: "With Max Selection limit 4",
        allowClear: true
    });

    $("#kirimpsn").click(function(e) {
        e.preventDefault();
        tinyMCE.triggerSave();
        var url = $('#krmpesan').attr('action');
        var data = $('#krmpesan').serialize();
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(data) {
                swal.fire({
                    title: "Pesan Terkirim!",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                loadpesan();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan pengiriman pesan!",
                    type: "warning",
                    timer: 1000,
                    showConfirmButton: false
                });
            }
        });

    });

      $(".angka").inputmask('decimal', {
          rightAlign: false
      });
      $(".decimal").inputmask({
          'alias': 'decimal',
          'groupSeparator': ',',
          'autoGroup': true,
          'digits': 2,
          'digitsOptional': false,
          'placeholder': '0.00',
          rightAlign: true,
          clearMaskOnLostFocus: !1
      });
      // Select all links with hashes
      $('a[href*="#"]')
          // Remove links that don't actually link to anything
          .not('[href="#"]')
          .not('[href="#0"]')
          .click(function(event) {
              // On-page links
              if (
                  location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
                  location.hostname == this.hostname
              ) {
                  // Figure out element to scroll to
                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                  // Does a scroll target exist?
                  if (target.length) {
                      // Only prevent default if animation is actually gonna happen
                      event.preventDefault();
                      $('html, body').animate({
                          scrollTop: target.offset().top
                      }, 1000, function() {
                          // Callback after animation
                          // Must change focus!
                          var $target = $(target);
                          $target.focus();
                          if ($target.is(":focus")) { // Checking if the target was focused
                              return false;
                          } else {
                              $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                              $target.focus(); // Set focus again
                          };
                      });
                  }
              }
          });

      tinymce.init({
          selector: '#ps_ket',
          width: "100%",
          height: "140",
          images_upload_url: '<?php echo base_url(); ?>markas/core1/postacceptor',
          images_upload_base_path: '<?php echo base_url(); ?>',
          images_upload_credentials: true,
          plugins: 'image code',
          toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',

          style_formats: [{
              title: 'Bold text',
              format: 'h1'
          }, {
              title: 'Red text',
              inline: 'span',
              styles: {
                  color: '#ff0000'
              }
          }, {
              title: 'Red header',
              block: 'h1',
              styles: {
                  color: '#ff0000'
              }
          }, {
              title: 'Example 1',
              inline: 'span',
              classes: 'example1'
          }, {
              title: 'Example 2',
              inline: 'span',
              classes: 'example2'
          }, {
              title: 'Table styles'
          }, {
              title: 'Table row 1',
              selector: 'tr',
              classes: 'tablerow1'
          }],

          image_title: true,
          automatic_uploads: true,
          file_picker_types: 'image',
          image_class_list: [{
              title: 'Responsive',
              value: 'imgzoom img-responsive animated bounceIn'
          }],
          file_picker_callback: function(cb, value, meta) {
              var input = document.createElement('input');
              input.setAttribute('type', 'file');
              input.setAttribute('accept', 'image/*');

              input.onchange = function() {
                  var file = this.files[0];

                  var reader = new FileReader();
                  reader.onload = function() {
                      var id = 'blobid' + (new Date()).getTime();
                      var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                      var base64 = reader.result.split(',')[1];
                      var blobInfo = blobCache.create(id, file, base64);
                      blobCache.add(blobInfo);

                      cb(blobInfo.blobUri(), {
                          title: file.name
                      });
                  };
                  reader.readAsDataURL(file);
              };

              input.click();
          }
      });

      if (!window.console) {
          window.console = {
              log: function() {
                  tinymce.$('<div></div>').text(tinymce.grep(arguments).join(' ')).appendTo(document.body);
              }
          };
      }



      function loadsalam(idnik) {
          $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>markas/core1/cnamapeg/' + idnik,
              success: function(data) {
                  var today = new Date()
                  var curHr = today.getHours()
                  if (curHr < 12) {
                      var salam = 'Selamat Pagi,';
                  } else if (curHr < 15) {
                      var salam = 'Selamat Siang,';
                  } else if (curHr < 19) {
                      var salam = 'Selamat Sore,';
                  } else {
                      var salam = 'Selamat Malam,';
                  }
                  $('#salam_jam').text(salam);
                  $('#salam_nama').addClass('animated tada');
                  $('#salam_nama').text(JSON.parse(data));
              }
          });
      }

      function showImage(e) {
          $.colorbox({
              href: $(e.currentTarget).attr("src"),
              overlayClose: true,
              opacity: 0.8,
              closeButton: true
          });
      }

      function catat(isicatat) {
          if (isicatat) {
              $.ajax({
                url: "<?php echo base_url(); ?>markas/core1/isi_log/",
                type: 'POST',
                data: {
                  aisi: isicatat
                },
                success: function(fwcatat) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
//                  alert(textStatus);
                }
              });
          }
      }


      function loadpesan(cekid) {
          var pegid = '<?php echo $idpeg;?>';
          var pegak = '<?php echo $kodejob;?>';
          if(cekid){
            var cekpsnid = '/' + cekid;
          } else {
            var cekpsnid = '';
          }
          $.ajax({
            type: 'GET',
            url: 'https://8.8.8.8',
            success: function(data) {
            },
            error: function(x, t, m) {
              if(t==="timeout") {
                $("#icopengguna").removeClass('red');
                $("#icopengguna").addClass('blue');
              } else {
                $("#icopengguna").removeClass('blue');
                $("#icopengguna").addClass('red');
              }
            }
          });

          var gourl1 = '<?php echo base_url();?>markas/core1/getpesan';
          var gourl2 = '<?php echo base_url();?>markas/core1/getidpesan';
          $.ajax({
              url: gourl1,
              type: 'POST',
              data: jQuery.param({
                varpeg: pegid + pegak + cekpsnid
              }),
              success: function(jdpesan) {
                if(cekid=='X'){
                  $("#dafpesan3oleh").html(jdpesan);
                } else if(cekid=='Y'){
                  $("#dafpesan3untuk").html(jdpesan);
                } else {
                  $("#dafpesan").html(jdpesan);
                  $.ajax({
                      url: gourl2,
                      type: 'POST',
                      data: jQuery.param({
                        varpeg: pegid + pegak + cekpsnid
                      }),
                      success: function(jdidpesan) {
                        if (jdidpesan.substr(0, 9) == 'pesanbaru') {
                            var jmlstpsn = jdidpesan.length;
                            var posjmlpsn = jdidpesan.substr(9, jmlstpsn - 9);
                            $("#tandan").html(posjmlpsn);
                            $("#tandan").addClass('infinite');
                            $("#tandan").removeClass('hidden');
                            $("#tanda").removeClass('green');
                            $("#tanda").addClass('red');
                            $("#tanda").addClass('fa-envelope');
                            $("#tanda").removeClass('fa-envelope-o');
                        } else {
                            $("#tandan").removeClass('infinite');
                            $("#tandan").addClass('hidden');
                            $("#tanda").removeClass('red');
                            $("#tanda").addClass('green');
                            $("#tanda").removeClass('fa-envelope');
                            $("#tanda").addClass('fa-envelope-o');
                        }
                      },
                      error: function (jqXHR, textStatus, errorThrown)
                      {
                          new PNotify({
                              title: 'Kesalahan Sistim',
                              type: 'danger',
                              text: 'Gagal menyusun data #ft_nmr2_1',
                              styling: 'bootstrap3'
                          });
                      catat("Gagal menyusun data #ft_nmr2_1");
                      }
                  });
                }
                $(".tags").addClass('animated bounceInLeft');
                  $(".imgzoom").on("click", showImage);
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  new PNotify({
                      title: 'Kesalahan Sistim',
                      type: 'danger',
                      text: 'Gagal menyusun data #ft_nmr2_1',
                      styling: 'bootstrap3'
                  });
              catat("Gagal menyusun data #ft_nmr2_1");
              }
          });
      }

      function pesanmark() {
          var pegid = '<?php echo $idpeg;?>';
          var kdpsnpeg = pegid + '<?php echo $kodejob;?>';

          $.ajax({
              url: "<?php echo base_url(); ?>markas/core1/setmkpesan",
              type: 'POST',
              data: jQuery.param({
                varpeg: kdpsnpeg
              }),
              success: function(data) {
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                  new PNotify({
                      title: 'Kesalahan Sistim',
                      type: 'danger',
                      text: 'Gagal menyusun data #ft_nmr2_1',
                      styling: 'bootstrap3'
                  });
              catat("Gagal menyusun data #ft_nmr2_1");
              }
          });


      }

      function cekuserak() {
          var pegid = '<?php echo $idpeg;?>';
          var time2;
          window.onload = resetTimer;
          document.onmousemove = resetTimer;
          document.onkeypress = resetTimer;

//          function logout() {
            if (pegid != '2015.02.030') {
                  setTimeout(onUserInactivity, 1000 * 30000)

                  function onUserInactivity() {
                      window.location.href = "<?php echo base_url(); ?>core2/logout"
                  }
              }
//          }

          function coverup(){
            cindbubbles('bstart');
          }

          function resetTimer() {
//            $("#myNav").css('width','0%');
//            $('.sidebar').css('opacity',1);
        time2 = setTimeout(coverup, 3000)
          }
      }

    function parseHour(hour) {
      if (hour > 11) {
        hour = hour - 12;
        ampm = "PM"
      }
      if (hour == 0) {
          hour = 12;
      }
      hour = (hour < 10 ? '0' : '') + hour;
      return hour
    }

    function parseSecond(secs) {
        secs = (secs < 10 ? '0' : '') + secs;
        return secs;
    }

    function setup() {
        var todayDate = new Date();
        $("#hours").text(parseHour(todayDate.getHours()));
        $("#minutes").text(parseSecond(todayDate.getMinutes()));
        $("#ampm").text(ampm);
        $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>markas/core1/cek_update",
        cache: false,
        async: false,
        success: function(data){
          $('#cekupdate').text(data);
        }
        });
    }

    $(document).ajaxStart(function () {
      cindbubbles('bstart');
    });

    $(document).ajaxStop(function () {
      cindbubbles('bstop');
    });

    $(document).ajaxError(function () {
      cindbubbles('bkaco');
    });

    function cindbubbles(warna){
      var ccol = warna;
      var bArray = [];
      var sArray = [6, 12, 16, 40];
      for (var i = 0; i < $(".sidebar-footer").width(); i++) {
        bArray.push(i);
      }
      function randomValue(arr) {
        return arr[Math.floor(Math.random() * arr.length)];
      }
        var size = randomValue(sArray);
        $(".sidebar-footer").append(
          '<div class="individual-bubble '+ ccol +'" style="opacity:.2;left: ' +
            randomValue(bArray) +
            "px; width: " +
            size +
            "px; height:" +
            size +
            'px;"></div>'
        );
          $(".individual-bubble").animate(
          {
            bottom: "100%",
            opacity: "-=0.2"
          },
          6000,
          function() {
            $(this).remove();
          }
        );
    }

    function getCookie(name) {
      var v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
      return v ? v[2] : null;
    }

    function setCookie(name, value, days) {
      var d = new Date;
      d.setTime(d.getTime() + 24 * 60 * 60 * 1000 * days);
      document.cookie = name + "=" + encode_cookie(value) + ";path=/;expires=" + d.toGMTString() + ";SameSite=None;secure";
    }

    function deleteCookie(name) {
      setCookie(name, '', -1);
    }

    /*coded*/

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

    function encode(str) {
      var encoded = "";
      for (i=0; i<str.length;i++) {
        var a = str.charCodeAt(i);
        var b = a ^ 51;    // bitwise XOR with any number, e.g. 123
        encoded = encoded+String.fromCharCode(b);
      }
      return encoded;
    }

    function decode_cookie1(coded_string) {

      // This variable holds the decoded cookie value
      var cookie_value = ""

      // Use + to split the coded string into an array
      var code_array = coded_string.split("+")

      // Loop through the array
      for (var counter = 0; counter < code_array.length; counter++) {

        // Convert the code into a character and
        // add it to the cookie value string
        cookie_value += String.fromCharCode(code_array[counter])
      }
      return cookie_value
    }

    function encode1(str) {
      var encoded = "";
      for (i=0; i<str.length;i++) {
        var a = str.charCodeAt(i);
        var b = a ^ 51;    // bitwise XOR with any number, e.g. 123
        encoded = encoded+String.fromCharCode(b);
      }
      return encoded;
    }


    setInterval(function() {
      loadpesan();
/* stop smtr
        setup();
        loadpesan();
        $.get("<?php echo base_url(); ?>markas/core1/getuser", function(jduser) {
          $(".tambahan").remove();
          $("#mntool").append(jduser);
        });
*/
/*
        $.get("<?php echo base_url(); ?>markas/core1/getyanabsen", function(jdyanmed) {
            $("#yanaktif").html(jdyanmed);
        });
*/
    }, 30000);

    function inWords(n, custom_join_character) {

    	var string = n.toString(),
    		units, tens, scales, start, end, chunks, chunksLen, chunk, ints, i, word, words;

    	var and = custom_join_character || '';

    	/* Is number zero? */
    	if (parseInt(string) === 0) {
    		return 'nol';
    	}

    	/* Array of units as words */
    	units = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan ', 'sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];

    	/* Array of tens as words */
    	tens = ['', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];

    	/* Array of scales as words */
    	scales = [, 'ribu', 'juta', 'milyar', 'triliun', 'quadrillion', 'quintillion', 'sextillion', 'septillion', 'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion ', ' tredecillion ', ' quatttuor-decillion ', ' quindecillion ', ' sexdecillion ', ' septen-decillion ', ' octodecillion ', ' novemdecillion ', ' vigintillion ', ' centillion '];

    	/* Split user arguemnt into 3 digit chunks from right to left */
    	start = string.length;
    	chunks = [];
    	while (start > 0) {
    		end = start;
    		chunks.push(string.slice((start = Math.max(0, start - 3)), end));
    	}

    	/* Check if function has enough scale words to be able to stringify the user argument */
    	chunksLen = chunks.length;
    	if (chunksLen > scales.length) {
    		return '';
    	}

    	/* Stringify each integer in each chunk */
    	words = [];
    	for (i = 0; i < chunksLen; i++) {

    		chunk = parseInt(chunks[i]);

    		if (chunk) {

    			/* Split chunk into array of individual integers */
    			ints = chunks[i].split('').reverse().map(parseFloat);

    			/* If tens integer is 1, i.e. 10, then add 10 to units integer */
    			if (ints[1] === 1) {
    				ints[0] += 10;
    			}

    			/* Add scale word if chunk is not zero and array item exists */
    			if ((word = scales[i])) {
    				words.push(word);
    			}

    			/* Add unit word if array item exists */
    			if ((word = units[ints[0]])) {
    				words.push(word);
    			}

    			/* Add tens word if array item exists */
    			if ((word = tens[ints[1]])) {
    				words.push(word);
    			}

    			/* Add 'and' string after units or tens integer if: */
    			if (ints[0] || ints[1]) {

    				/* Chunk has a hundreds integer or chunk is the first of multiple chunks */
    				if (ints[2] || !i && chunksLen) {
    					words.push(and);
    				}

    			}

    			/* Add hundreds word if array item exists */
    			if ((word = units[ints[2]])) {
    				words.push(word + ' ratus');
    			}

    		}

    	}

    	duit = words.reverse().join(' ');
    	ejaan = duit.replace('satu ratus', 'seratus');
    	if (ejaan.substr(0, 9) == 'satu ribu') {
    		ejaan = ejaan.replace('satu ribu', 'seribu');
    	}
    	return ejaan;
    }

    </script>
