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
              <h1><?php echo lang('create_user_heading');?></h1>
              <p><?php echo lang('create_user_subheading');?></p>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div class="container cropper">
                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                  </div>
                    <div class="col-md-9 col-sm-12 col-xs-12">


            <div id="infoMessage"><?php echo $message;?></div>

            <?php echo form_open("auth/create_user");?>

            <div class="col-md-6 col-sm-12 col-xs-12">
              <p>
                <?php echo lang('create_user_fname_label', 'first_name');?> <br />
                <?php echo form_input($first_name);?>
              </p>
            </div>
            <div class="col-md-6 col-sm-12 col-xs-12">
              <p>
                <?php echo lang('create_user_lname_label', 'last_name');?> <br />
                <?php echo form_input($last_name);?>
              </p>
            </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                        <?php echo lang('create_user_company_label', 'company');?>
                        <?php echo form_dropdown($company);?>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <?php
                  if($identity_column!=='email') {
                    echo '<p>';
                    echo lang('create_user_identity_label', 'identity');
                    echo '<br />';
                    echo form_error('identity');
                    echo form_input($identity);
                    echo '</p>';
                  }
                  ?>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <p>
                        <?php echo lang('create_user_email_label', 'email');?>
                        <?php echo form_input($email);?>
                  </p>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <p>
                        <?php echo lang('create_user_phone_label', 'phone');?> <br />
                        <?php echo form_input($phone);?>
                  </p>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <p>
                        <?php echo lang('create_user_password_label', 'password');?> <br />
                        <?php echo form_input($password);?>
                  </p>
                </div>
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <p>
                        <?php echo lang('create_user_password_confirm_label', 'password_confirm');?> <br />
                        <?php echo form_input($password_confirm);?>
                  </p>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                  <p class="pull-right"><?php echo form_submit('submit', lang('create_user_submit_btn'),array('class'=>'btn btn-success'));?></p>
            <?php echo form_close();?>
            <a href="/markas/corex" class="btn btn-dark">Batal</a>
          </div>

          </div>
        </div>
      </div>

	      	</div>
	    </div>
	</div>
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

<script>
var ampm = "AM";

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

});

$(":input").inputmask();

$('#company').select2({
  tags: true,
  multiple: false,
  tokenSeparators: [',', ' '],
  minimumInputLength: -1,
  minimumResultsForSearch: 10,
placeholder: "Pilih Paroki",
  ajax: {
    url: '<?php echo base_url(); ?>markas/core1/list_paroki',
    type: "post",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
        param1:1,
        param2:''
      };
    },
    processResults: function (data) {
      return {
        results: $.map(data, function(obj) {
          return {
            id: obj.varid,
            text: obj.varnama
          };
        })
      };
    },
    cache: true
  }
}).on('select2:select', function(e) {
  var kj = $('#company').val();
  var d = new Date();

  $.ajax({
      type: "POST",
      url: '<?php echo base_url();?>markas/core1/cek_jbol',
      data: jQuery.param({
        noakr: d.getFullYear()+'.'+kj.substr(-2)
      }),
      success: function(data) {

        $('#identity').val(d.getFullYear()+'.'+kj.substr(-2)+'.'+data);
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          new PNotify({
              title: 'Kesalahan Sistim',
              type: 'danger',
              text: 'Gagal menyusun data #ft_nmr2_2',
              styling: 'bootstrap3'
          });
      catat("Gagal menyusun data #ft_nmr2_2");
      }
  });
});


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



function showImage(e) {
    $.colorbox({
        href: $(e.currentTarget).attr("src"),
        overlayClose: true,
        opacity: 0.8,
        closeButton: true
    });
}

</script>

</body>
</html>
