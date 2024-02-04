<footer>
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
    <!-- SweetAlert -->
    <script src="<?php echo base_url();?>dapur0/vendors/sweetalert/dist/sweetalert.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>dapur0/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>dapur0/vendors/nprogress/nprogress.js"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/datatables.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/pdfmake-0.1.32/pdfmake.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/pdfmake-0.1.32/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url();?>dapur0/vendors/select2/dist/js/select2.full.min.js"></script>
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
    <script src="<?php echo base_url();?>dapur0/vendors/iCheck/icheck.min.js"></script>
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

    <script>
    var ampm = "AM";
    var pegid = '<?php echo $idpeg;?>';
    var ptid = pegid.split('.').join('');
    $.ajax({
            url:"<?php echo base_url().'dapur0/images/foto/'; ?>" + ptid + ".png",
            error: function()
            {
              $(".profile_pic").html('<img src="<?php echo base_url(); ?>dapur0/images/foto/user.png" alt="..." class="img-circle profile_img">');
            },
            success: function()
            {
              $(".profile_pic").html('<img src="<?php echo base_url(); ?>dapur0/images/foto/' + ptid + '.png" alt="..." class="img-circle profile_img">');
            }
        });

        $('.helum').click(function(){
          var particles = new Particles('.helum');
          particles.disintegrate({
            duration: 1000,
            delay: 100,
            type: 'triangle',
            complete: function(){
              history.back()
            }
          });
        });

    $(document).ready(function() {
      var pegnik = "<?php echo $idpeg;?>";
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

      $('a[href*="#"]')
          .not('[href="#"]')
          .not('[href="#0"]')
          .click(function(event) {

              if (
                  location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
                  location.hostname == this.hostname
              ) {

                  var target = $(this.hash);
                  target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');

                  if (target.length) {

                      event.preventDefault();
                      $('html, body').animate({
                          scrollTop: target.offset().top
                      }, 1000, function() {

                          var $target = $(target);
                          $target.focus();
                          if ($target.is(":focus")) {
                              return false;
                          } else {
                              $target.attr('tabindex', '-1');
                              $target.focus();
                          };
                      });
                  }
              }
          });

      tinymce.init({
        selector: '#ps_ket',
        statusbar: false,
        theme: "modern",
        plugins : 'autoresize',
        width: '100%',
        height: 400,
        autoresize_min_height: 400,
        autoresize_max_height: 800,
          images_upload_url: '<?php echo base_url(); ?>markas/core1/postacceptor',
          images_upload_base_path: '<?php echo base_url(); ?>',
          images_upload_credentials: true,
          plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor importcss colorpicker textpattern"
          ],
          toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
          style_formats: [
            {title: 'Bold text', format: 'h1'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
          ],

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

      tinymce.init({
        selector: '#ps_desc',
        theme: "modern",
        plugins : 'autoresize',
        menubar:false,
        statusbar: false,
        width: '100%',
        height: 210,
        autoresize_min_height: 120,
        autoresize_max_height: 200,
          images_upload_url: '<?php echo base_url(); ?>markas/core1/postacceptor',
          images_upload_base_path: '<?php echo base_url(); ?>',
          images_upload_credentials: true,
          plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor importcss colorpicker textpattern"
          ],
          toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
          style_formats: [
            {title: 'Bold text', format: 'h1'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
          ],

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

      function showImage(e) {
          $.colorbox({
              href: $(e.currentTarget).attr("src"),
              overlayClose: true,
              opacity: 0.8,
              closeButton: true
          });
      }
    </script>

<script>
    $("#btndoc").click(function(e) {
        e.preventDefault();
        tinyMCE.triggerSave();
        var url = $('#frmdoc').attr('action');
        var data = $('#frmdoc').serialize();
        $.ajax({
            url: url,
            type: 'POST',
            data: data,
            success: function(data) {
                $('#fdok').removeClass('slideInUp');
                $('#fdok').removeClass('animated');
                $('#fdok').addClass('flipOutY');
                $('#fdok').addClass('animated');
                tinyMCE.activeEditor.setContent('');
                swal({
                    title: "Dokumen Tersimpan!",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
                setTimeout(function(){
                  location.reload();
                }, 5000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal({
                    title: "Gagal!",
                    text: "Terjadi kesalahan penyimpanan dokumen!",
                    type: "warning",
                    timer: 1000,
                    showConfirmButton: false
                });
            }
        });

    });

</script>
