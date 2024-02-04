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
            $("#potone").html('<img class="imgzoom img-responsive avatar-view" src="<?php echo base_url(); ?>dapur0/images/foto/' + ptid + '.png" alt="Foto Pegawai">');
          }
          $(".profile_pic").html('<img src="<?php echo base_url(); ?>dapur0/images/foto/' + ptid + '.png" alt="..." class="img-circle profile_img">');
        }
    });

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

$(".angka").inputmask('decimal', {
    rightAlign: false
});
$(".decimal").inputmask({
    'alias': 'decimal',
    'groupSeparator': ',',
    'autoGroup': true,
    'digits': 3,
    'digitsOptional': false,
    'placeholder': '0.000',
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
    function showImage(e) {
        $.colorbox({
            href: $(e.currentTarget).attr("src"),
            overlayClose: true,
            opacity: 0.8,
            closeButton: true
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
              if (pegid != '2015.02.030') {
                  setTimeout(onUserInactivity, 1000 * 300)

                  function onUserInactivity() {
                      window.location.href = "<?php echo base_url(); ?>core2/logout"
                  }
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
        }

        setInterval(function() {
            setup();
            loadpesan();
            $.get("<?php echo base_url(); ?>markas/core1/getuser", function(jduser) {
                $("#useraktif").html(jduser);
            });

            $.get("<?php echo base_url(); ?>markas/core1/getyanabsen", function(jdyanmed) {
                $("#yanaktif").html(jdyanmed);
            });
        }, 30000);
