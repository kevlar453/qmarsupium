<script type="text/javascript">// <![CDATA[

 $(document).ready(function(){
       $('.datepicker').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
   $('#pilpoli').change(function(){
//    $("#pilprop > option").remove(); 
    var pilpoli = $('#pilpoli').val(); 
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'prosespx/get_poli/';?>"+pilpoli, 

        success: function(dokteru) {
            $.each(dokteru,function(id,propinsi) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(propinsi);
                $('#pilprop').append(opt);
            });
        }
    });
});

  $('#pilnegara').change(function(){
    $("#pilprop > option").remove(); 
    var pilnegara = $('#pilnegara').val(); 
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'prosespx/get_propinsi/';?>"+pilnegara, 

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
    var pilprop = $('#pilprop').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'prosespx/get_kabupaten/';?>"+pilprop,

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
    var pilkab = $('#pilkab').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'prosespx/get_kecamatan/';?>"+pilkab,
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
    var pilkec = $('#pilkec').val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'prosespx/get_desa/';?>"+pilkec,

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
});
 // ]]>
</script>