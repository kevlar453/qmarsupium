

<script type="text/javascript">// <![CDATA[
 $(document).ready(function(){

 //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

 $('#pilnegara').change(function(){
    $("#pilprop > option").remove();
        var optprp = $('<option />');
        optprp.val('');
        optprp.text('-PROPINSI-');
        $('#pilprop').append(optprp);
    $("#pilkab > option").remove();
        var optkab = $('<option />');
        optkab.val('');
        optkab.text('-KABUPATEN-');
        $('#pilkab').append(optkab);
    $("#pilkec > option").remove();
        var optkec = $('<option />');
        optkec.val('');
        optkec.text('-KECAMATAN-');
        $('#pilkec').append(optkec);
    $("#pildesa > option").remove();
        var optdes = $('<option />');
        optdes.val('');
        optdes.text('-DESA-');
        $('#pildesa').append(optdes);
    var pilnegara = $('#pilnegara').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'markas/prosespx/get_propinsi/';?>"+pilnegara,

        success: function(propinsi) {
            $.each(propinsi,function(id,propinsi) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(propinsi);
                $('#pilprop').append(opt);
            });
        }
    });
});

  $('#pilprop').change(function(){
    $("#pilkab > option").remove();
        var optkab = $('<option />');
        optkab.val('');
        optkab.text('-KABUPATEN-');
        $('#pilkab').append(optkab);
    $("#pilkec > option").remove();
        var optkec = $('<option />');
        optkec.val('');
        optkec.text('-KECAMATAN-');
        $('#pilkec').append(optkec);
    $("#pildesa > option").remove();
        var optdes = $('<option />');
        optdes.val('');
        optdes.text('-DESA-');
        $('#pildesa').append(optdes);
    var pilprop = $('#pilprop').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'markas/prosespx/get_kabupaten/';?>"+pilprop,

        success: function(kabupaten) {
            $.each(kabupaten,function(id,kabupaten) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(kabupaten);
                $('#pilkab').append(opt);
            });
        }
    });
});

  $('#pilkab').change(function(){
    $("#pilkec > option").remove();
        var optkec = $('<option />');
        optkec.val('');
        optkec.text('-KECAMATAN-');
        $('#pilkec').append(optkec);
    $("#pildesa > option").remove();
        var optdes = $('<option />');
        optdes.val('');
        optdes.text('-DESA-');
        $('#pildesa').append(optdes);
    var pilkab = $('#pilkab').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'markas/prosespx/get_kecamatan/';?>"+pilkab,
        success: function(kecamatan) {
            $.each(kecamatan,function(id,kecamatan) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(kecamatan);
                $('#pilkec').append(opt);
            });
        }
    });
});

  $('#pilkec').change(function(){
    $("#pildesa > option").remove();
        var optdes = $('<option />');
        optdes.val('');
        optdes.text('-DESA-');
        $('#pildesa').append(optdes);
    var pilkec = $('#pilkec').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'markas/prosespx/get_desa/';?>"+pilkec,

        success: function(desa) {
            $.each(desa,function(id,desa) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(desa);
                $('#pildesa').append(opt);
            });
        }
    });
});

  $('#tgllahir').change(function(){
  var dateString = $("#tgllahir").val();
  var now = new Date();
  var today = new Date(now.getFullYear(),now.getMonth(),now.getDate());

  var yearNow = now.getFullYear();
  var monthNow = now.getMonth();
  var dateNow = now.getDate();

  var dob = new Date(dateString.substring(6,10),
                     dateString.substring(3,5)-1,
                     dateString.substring(0,2)
                     );
  var yearDob = dob.getFullYear();
  var monthDob = dob.getMonth();
  var dateDob = dob.getDate();
  var age = {};

  yearAge = yearNow - yearDob;

  if (monthNow >= monthDob)
    var monthAge = monthNow - monthDob;
  else {
    yearAge--;
    var monthAge = 12 + monthNow -monthDob;
  }

  if (dateNow >= dateDob)
    var dateAge = dateNow - dateDob;
  else {
    monthAge--;
    var dateAge = 31 + dateNow - dateDob;

    if (monthAge < 0) {
      monthAge = 11;
      yearAge--;
    }
  }

  age = {
      years: yearAge,
      months: monthAge,
      days: dateAge
      };


  if ( (age.years > 0) && (age.months > 0) && (age.days > 0) )
    $("#duth").val(age.years),
    $("#dubl").val(age.months),
    $("#duhr").val(age.days);

    else if ( (age.years == 0) && (age.months == 0) && (age.days > 0) )
    $("#duth").val('0'),
    $("#dubl").val('0'),
    $("#duhr").val(age.days);
  else if ( (age.years > 0) && (age.months == 0) && (age.days == 0) )
    $("#duth").val(age.years),
    $("#dubl").val('0'),
    $("#duhr").val('0');
  else if ( (age.years > 0) && (age.months > 0) && (age.days == 0) )
    $("#duth").val(age.years),
    $("#dubl").val(age.months),
    $("#duhr").val('0');
  else if ( (age.years == 0) && (age.months > 0) && (age.days > 0) )
    $("#duth").val('0'),
    $("#dubl").val(age.months),
    $("#duhr").val(age.days);
  else if ( (age.years > 0) && (age.months == 0) && (age.days > 0) )
    $("#duth").val(age.years),
    $("#dubl").val('0'),
    $("#duhr").val(age.days);
  else if ( (age.years == 0) && (age.months > 0) && (age.days == 0) )
    $("#duth").val('0'),
    $("#dubl").val(age.months),
    $("#duhr").val('0');
  else
    $("#duth").val('0'),
    $("#dubl").val('0'),
    $("#duhr").val('0');

    });

});

function save()
{
var url;

        url = "<?php echo site_url('person/ajax_update')?>";
        sip = "<?php echo site_url('markas/prosespx/cekpx?rmod=edit&name='.$hasil['pxpidrs'].''); ?>";

    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#formrm1').serialize(),
        dataType: "JSON",
        success: function(data)
        { //alert(JSON.stringify(data));
            new PNotify({
                        title: 'SIP!!!',
                        type: 'success',
                        text: 'Data perubahan tersimpan',
                        styling: 'bootstrap3'
                              });
            $('#drm').val(data.data['pxpidrs']);
            $('#dnama').val(data.data['pxpnama']);
            $('#dalamat').val(data.data['pxpalamat']);
            $('#drt').val(data.data['pxprtrw'].substring(0, 2));
            $('#drw').val(data.data['pxprtrw'].substring(2));
            $('#tgllahir').val(data.data['pxptglhr'].substring(8,10)+'-'+data.data['pxptglhr'].substring(5,7)+'-'+data.data['pxptglhr'].substring(0,4));
            $('#dtlp').val(data.data['pxptelp']);
            $('#dhp').val(data.data['pxphp']);
//        window.location = sip;
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            new PNotify({
                        title: 'Kesalahan Sistim',
                        type: 'danger',
                        text: 'Data perubahan tidak tersimpan',
                        styling: 'bootstrap3'
                              });
        }
    });
}

 // ]]>
</script>
