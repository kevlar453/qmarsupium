<script>

$(document).ready(function (){
//  init_IonRangeSlider();
  catat('Buka modul Rincian Billing HIS');
  setCookie('pilnil','global');
  rerata('');
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
          if(obj.varid.substr(-2) != '00'){
            return {
              id: obj.varid,
              text: obj.varnama
            };
          }
        })
      };
    },
    cache: true
  }
}).on('select2:select', function(e) {
  $('#isian').addClass('hidden');
  $('#isian').removeClass('show');
  $('#kelregio').removeClass('hidden');
  $('#kelregio').addClass('show');
  setCookie('pilnil','regio1');
  setCookie('pilnild1',$('#pilreg').val());
  $('#pilpart').val('').trigger('change');
  $('#pilpar').val('').trigger('change');
  rerata('regio');
});

$('#pilpart').select2({
  tags: true,
  multiple: false,
  tokenSeparators: [',', ' '],
  minimumInputLength: -1,
  minimumResultsForSearch: 10,
  placeholder: "Pilih Paroki",
  ajax: {
    url: '<?php echo base_url(); ?>markas/penilaian/getparnl',
    type: "post",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
        prm: 'periode'
      };
    },
    processResults: function (data) {
      return {
        results: $.map(data, function(obj) {
          return {
            id: obj.qnil_periode,
            text: obj.qnil_periode
          };
        })
      };
    },
    cache: true
  }
}).on('select2:select', function(e) {
  $('#pilpar').val('').trigger('change');
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
          if(obj.varid.substr(-2) != '00'){
            return {
              id: obj.varid,
              text: obj.varnama
            };
          }
        })
      };
    },
    cache: true
  }
}).on('select2:select', function(e) {
  $('#kelregio').removeClass('show');
  $('#kelregio').addClass('hidden');
  $('#isian').removeClass('hidden');
  $('#isian').addClass('show');
  setisian($('#pilpar').val(),$('#pilpart').val());
});

function setisian(kdpar,peri){
var clrisi = document.getElementById('a1');
$('#a1').empty();
  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>markas/penilaian/ckelompok",
    cache: false,
    async: false,
    data: jQuery.param({
      param1:'b'
    }),
    success: function(data1){
      $.ajax({
        type: "post",
        url: "<?php echo base_url(); ?>markas/penilaian/ckelompok",
        cache: false,
        async: false,
        data: jQuery.param({
          param1:'c'
        }),
        success: function(data2){
          $.ajax({
            type: "post",
            url: "<?php echo base_url(); ?>markas/penilaian/ckelompok",
            cache: false,
            async: false,
            data: jQuery.param({
              param1:'d'
            }),
            success: function(data3){
              $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>markas/penilaian/getnilpar",
                cache: false,
                async: false,
                data: jQuery.param({
                  param1:kdpar,
                  param2:peri
                }),
                success: function(datapar){
                  var elem = JSON.parse(data1);
                  var selem = JSON.parse(data2);
                  var delem = JSON.parse(data3);
                  var dtparoki = JSON.parse(datapar);
                  for (let i = 0; i <= elem.length-1; i++) {
                    var $diva = $('<div />');
                    var $anca = $('<a />');
                    var $hdra = $('<h4 />');

                    var $divb = $('<div />');
                    var $divc = $('<div />');

                    $diva.attr('class','panel');
                    $diva.attr('id','pan'+i);

                    $anca.attr("class","panel-heading");
                    $anca.attr("role","tab");
                    $anca.attr("id","heading"+i);
                    $anca.attr("data-toggle","collapse");
                    $anca.attr("data-parent","#accordion");
                    $anca.attr("href","#collapse"+i);
                    $anca.attr("aria-expanded","false");
                    $anca.attr("aria-controls","collapse"+i);

                    $hdra.text(elem[i].qnilb_kodeb+' '+elem[i].qnilb_nama);

                    $divb.attr("id","collapse"+i);
                    $divb.attr("class","panel-collapse collapse");
                    $divb.attr("role","tabpanel");
                    $divb.attr("aria-labelledby","heading"+i);

                    $divc.attr('class','panel-body');
                    $divc.attr('id','pbody'+i);

                    $('#a1').append($diva);
                    $('#pan'+i).append($anca);
                    $('#heading'+i).append($hdra);
                    $('#pan'+i).append($divb);
                    $('#collapse'+i).append($divc);
                    for (let j = 0; j <= selem.length-1; j++) {
                      var $hdrb = $('<h4 />');

                      if(elem[i].qnilb_kodeb == selem[j].qnilc_kodeb){

                      $hdrb.text(selem[j].qnilc_kodec+' '+selem[j].qnilc_nama);

                        $('#pbody'+i).append($hdrb);

                        for (let k = 0; k <= delem.length-1; k++) {
                          var $lbla = $('<label />');
                          var $inpa = $('<input />');
                          var isidt = '';

                          if(selem[j].qnilc_kodec == delem[k].qnild_kodec){

                          $lbla.attr('for','i'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());
                          $lbla.attr('class','control-label col-md-12');
                          $lbla.text(delem[k].qnild_koded+' '+delem[k].qnild_nama);

                          $inpa.attr("id",'i'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());
                          $inpa.attr("type","text");
                          $inpa.attr("class","range10");
                          for (let l = 0; l < dtparoki.length-1; l++) {
                            if(dtparoki[l].qnil_kode == delem[k].qnild_koded){
                              console.log(dtparoki[l].qnil_kode+'|'+delem[k].qnild_koded);
                              isidt = dtparoki[l].qnil_nilai;
                            }
                          }
                          $inpa.attr("value",isidt);
                          $inpa.attr("name","range");

                          $('#pbody'+i).append($lbla);
                          $('#pbody'+i).append($inpa);
                          }
                        }
                        $('.panel-heading').addClass('collapsed');
                        init_IonRangeSlider();
                      }
                    }
                  }
                }
              });
            }
          });
        }
      });
    }
  });
}

function init_IonRangeSlider() {

  if( typeof ($.fn.ionRangeSlider) === 'undefined'){ return; }
  console.log('init_IonRangeSlider');
  $(".range10").ionRangeSlider({
    min: 0,
    max: 10,
//    from: 5,
    grid: true,
    grid_snap:true,
    hide_min_max: false,
			  keyboard: true,
    force_edges: true,
    step:1
  });

};


function rerata(pilglob){
  var elid = 'keuskupan';
  var chart = echarts.init(document.getElementById(elid));
  var dindikator;
  var disi;
  var dkateg;
//  $('#'+elid).empty();

  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>markas/penilaian/setindikator",
    cache: false,
    async: false,
    success: function(data1){
//      alert(JSON.stringify(data1[0]));
      if(data1[0] == "\n"){
        deleteCookie('pilnil');
        deleteCookie('pilnild1');
        swal.fire({
          title: "Tidak Ada Data",
          icon: "error",
          text: "Penilaian untuk wilayah ini belum diisi.",
          timer: 2000,
          timerProgressBar: true,
          allowOutsideClick:false,
          showConfirmButton: false
        });
        setTimeout(function(){
//          alert(JSON.stringify(data1));
//          location.reload();
        },2000);
      } else {
        dindikator = JSON.parse(data1);
        return dindikator;
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
//      location.reload();
    }
  });
    chart.setOption({
    tooltip: {},
    legend: {
      data: dindikator.isi2
    },
    radar: {
      shape: 'circle',
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

  if (pilglob != 'regio') {
    setCookie('pilnil','regio');
  } else {
    setCookie('pilnil','paroki');
  }
  perdana();
}

function perdana(pilkat,pildet){
  var jumloop = 8;
  var isikelp;
  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>markas/penilaian/ckelompok",
    cache: false,
    async: false,
    data: jQuery.param({
      param1:'b'
    }),
    success: function(data1){
      isikelp = JSON.parse(data1);
      return isikelp;
    },
    error: function(jqXHR, textStatus, errorThrown) {
//      location.reload();
    }
  });

  for (let i = 1; i <= jumloop; i++) {
    var elid = 'reg_a'+i;
    var chart = echarts.init(document.getElementById(elid));
    var dindikator;
    var disi;
    var dkateg;
    $('#jdl_a'+i).text(isikelp[i-1].qnilb_kodeb+' '+isikelp[i-1].qnilb_nama);
    $.ajax({
      type: "post",
      url: "<?php echo base_url(); ?>markas/penilaian/cindikator",
      cache: false,
      async: false,
      data: jQuery.param({
        param1:pilkat,
        param2:isikelp[i-1].qnilb_kodeb
      }),
      success: function(data1){
        if(data1[0] == "\n"){
          deleteCookie('pilnil');
          deleteCookie('pilnild1');
          swal.fire({
            title: "Tidak Ada Data",
            icon: "error",
            text: "Penilaian untuk wilayah ini belum diisi.",
            timer: 2000,
            timerProgressBar: true,
            allowOutsideClick:false,
            showConfirmButton: false
          });
          setTimeout(function(){
//            alert(JSON.stringify(data1));
//            location.reload();
          },2000);
        } else {
          dindikator = JSON.parse(data1);
          return dindikator;
        }
      }
    });

    chart.setOption({
      tooltip: {},
      legend: {
        data: dindikator.isi2,
        x : 'center',
        y : 'bottom',
      },
      radar: {
        shape: 'circle',
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
        calculable : true,
        polar : [
            {
                indicator : dindikator.indi
            }
        ],
        label: {
          normal: {
            show: true
          }
        },
        data : dindikator.isi1
      }]
    });
  }
  setCookie('pilnil','global');
  deleteCookie('pilnild1');
}

</script>
