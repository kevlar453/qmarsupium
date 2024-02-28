<script>
  $(document).ready(function (){
    catat('Buka modul Rincian Billing HIS');
    perdana('keuskupan');
  });

  $('#pilreg').select2({
    tags: true,
    multiple: false,
    tokenSeparators: [',', ' '],
    minimumInputLength: -1,
    minimumResultsForSearch: 10,
  placeholder: "Pilih Regio",
    ajax: {
      url: '<?php echo base_url(); ?>markas/penilaian/getreg',
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term
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
    var kj = $('#pilreg').val();
    $('#pilpar').val('').trigger('change');
    perdana(kj);
  });

  $('#pilpar').select2({
    tags: true,
    multiple: false,
    tokenSeparators: [',', ' '],
    minimumInputLength: -1,
    minimumResultsForSearch: 10,
  placeholder: "Pilih Paroki",
    ajax: {
      url: '<?php echo base_url(); ?>markas/penilaian/getpar',
      type: "post",
      dataType: 'json',
      delay: 250,
      data: function (params) {
        return {
          searchTerm: params.term,
          prm: $('#pilreg').val()
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

  });


function perdana(pilkat){
  var chart = echarts.init(document.getElementById(pilkat));
  var dindikator;
  var disi;
  var dkateg;
  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>markas/penilaian/cindikator",
    cache: false,
    async: false,
    data: jQuery.param({
      param:pilkat
    }),
    success: function(data1){
      dindikator = JSON.parse(data1);
      return dindikator;
    }
  });
  console.log('idi: '+dindikator);
  console.log('isi: '+JSON.stringify(dindikator.isi));
  chart.setOption({
      tooltip: {},
      legend: {
          data: dindikator.isi2
      },
      radar: {
          // shape: 'circle',
          indicator: dindikator.indi
      },
      series: [{
          name: 'Penilaian Paroki',
          type: 'radar',
          itemStyle: {
                normal: {
                    areaStyle: {
                        type: 'default'
                    }
                }
            },
            toolbox: {
        show : true,
        feature : {
            mark : {show: true},
            dataView : {show: true, readOnly: false},
            restore : {show: true},
            saveAsImage : {show: true}
        }
    },
          label: {
              normal: {
                  show: true
              }
          },
          calculable : true,
          data : dindikator.isi1
      }]
  });
}

</script>
