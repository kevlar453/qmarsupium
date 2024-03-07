<script>
  var today = new Date();
  var sekarang = new Date().getTime();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();

$(document).ready(function (){
  $('#kelregio').removeClass('show');
  $('#kelregio').addClass('hidden');
  catat('Buka modul nilai');
  iudata('pilnil','global');
$('#pilpart').val(yyyy);
  rerata('');
});


$('input').each(function(){
    var self = $(this),
      label = self.next(),
      label_text = label.text();

    label.remove();
    self.iCheck({
      checkboxClass: 'icheckbox_line-blue',
      radioClass: 'iradio_line-blue',
      insert: '<div class="icheck_line-icon"></div>' + label_text
    });
  });

  $('input').on('ifChecked', function(event){
    var valrad = $(this).val();
    $('#kelregio').removeClass('show');
    $('#kelregio').addClass('hidden');
    $('#pilreg').val('').trigger('change');
    $('#pilpar').val('').trigger('change');
    $('#pilpart').val(yyyy);
    $('#isian').addClass('hidden');
    $('#isian').removeClass('show');
    iudata('pilnil',valrad);
    setTimeout(function(){
rerata(valrad);
geserke('#utama');
    },100);
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
  iudata('pilnil','detregio');
  iudata('pilnild1',$('#pilreg').val());
$('#pilpart').val(yyyy);
$('#pilpar').val('').trigger('change');
setTimeout(function(){
rerata('detregio',$('#pilreg').val());
geserke('#utama');
},100);
});

$('#pilpart').on('keyup',function(){
  dudata('tmppar');
  $('#pilpar').val('').trigger('change');
  $('#isian').removeClass('hidden');
  $('#isian').addClass('show');
  $('#a1').empty();
})

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
  if($('#pilpart').val().length == 4){
    iudata('periode',$('#pilpart').val());
    iudata('pilnil','detparoki');
    iudata('pilnild1',$('#pilpar').val());
    iudata('tmppar',$('#pilpar').val());
    $('#pilreg').val('').trigger('change');
    $('#kelregio').addClass('show');
    $('#kelregio').removeClass('hidden');
    setTimeout(function(){
rerata('detparoki',$('#pilpar').val());
setisian($('#pilpar').val(),$('#pilpart').val());
geserke('#utama');
    },100);
  }


});

function kliksim(){
  var cekcls = $('#setnil').serializeArray();
    $.ajax({
        url:'/markas/penilaian/simnilai',
        type:'POST',
        cache: false,
        async: false,
        data: jQuery.param({
          datut:cekcls,
          perut:$('#pilpart').val()
        }),
        success: function(dt1){
          $('#kelregio').removeClass('show');
          $('#kelregio').addClass('hidden');
          $('#isian').removeClass('hidden');
          $('#isian').addClass('show');
          if($('#pilpart').val().length == 4){
            iudata('periode',$('#pilpart').val());
            iudata('pilnil','detparoki');
            iudata('pilnild1',$('#pilpar').val());
            iudata('tmppar',$('#pilpar').val());
            $('#pilreg').val('').trigger('change');
            $('#kelregio').addClass('show');
            $('#kelregio').removeClass('hidden');
            setTimeout(function(){
rerata('detparoki',$('#pilpar').val());
setisian($('#pilpar').val(),$('#pilpart').val());
geserke('#utama');
            },100);
          }
        }
    }).done(function (data){
    });
}


function rerata(pilglob,pildet){
$.blockUI();
  var elid = 'utama';
  var dindikator;
  var disi;
  var dkateg;
  var pilket = '';
//  $('#'+elid).empty();


  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>markas/penilaian/setindikator",
    cache: false,
    async: false,
    success: function(data1){
//      alert(JSON.stringify(data1[0]));
      if(data1[0] == "\n"){
if(pilglob == 'detparoki'){
  Swal.fire({
    title: "Tidak Ada Data",
    icon: "error",
    text: "Penilaian untuk wilayah ini belum diisi. Isi sekarang?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ya",
    cancelButtonText: "Tidak"
  }).then((result) => {
    if (result.isConfirmed) {
      $('#kelregio').removeClass('show');
      $('#kelregio').addClass('hidden');
      $('#isian').removeClass('hidden');
      $('#isian').addClass('show');
      $.unblockUI();
      pilket = 'block';
      setisian();
      return pilket;
    } else {
      dudata('pilnil');
      dudata('pilnild1');
      dudata('periode');
      location.reload();
    }
  });//          alert(JSON.stringify(data1));
} else {
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
//              alert(JSON.stringify(data1));
//  location.reload();
  },2000);
}
$.unblockUI();

      } else {
        dindikator = JSON.parse(data1);
        return dindikator;
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
//      location.reload();
    }
  });

  var dom = document.getElementById(elid);
  var myChart = echarts.init(dom);
  option = {
      title : {
          text: 'Keuskupan Ketapang',
          subtext: 'Penilaian Paroki'
      },
      tooltip : {
          trigger: 'axis'
      },
      legend: {
          orient : 'vertical',
          x : 'right',
          y : 'bottom',
          data:dindikator.isi2
      },
      toolbox: {
          show : true,
          feature : {
              restore : {show: true,title:'muat'},
              saveAsImage : {show: true,title:'simpan'}
          }
      },
      polar : [
         {
             indicator : dindikator.indi,
             scale: false,
             type: 'circle',
             radius: '80%',
             axisLabel: {
                 show: true,
                 textStyle: {
                     color: '#bbb'
                 }
             },
          }
      ],
      calculable : false,
      series : [
          {
            name: 'Nilai',
            type: 'radar',
            itemStyle: {
                normal: {
                    areaStyle: {
                        type: 'default'
                    }
                }
            },
              data : dindikator.isi1,
              name : '张三',
                    itemStyle: {
                        normal: {
                            color: function(params) {
                                var value = params.data
                                return isNaN(value)
                                       ? undefined
                                       : (value >= 5 ? 'green' : 'red')
                            },
                            label: {
                                show: true,
                                formatter:function(params) {
                                    return params.value;
                                }
                            },
                            areaStyle: {
                                type: 'default'
                            }
                        }
                    }
          }
      ]
  };


  myChart.setOption(option);
  $.unblockUI();
  if(pilglob.substr(0,3)=='det' && pilket == ''){
    perdana(pilglob,pildet);
  }
}

function perdana(pilkat,pildet){
  $.blockUI();
  var jumloop = 8;
  var isikelp;
  var isikeld;
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

      iudata('pilnil',pilkat);
      iudata('pilnild1',pildet);
      return isikelp;
    },
    error: function(jqXHR, textStatus, errorThrown) {
    }
  });

  for (let i = 1; i <= jumloop; i++) {
    var elid = 'reg_a'+i;
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
          Swal.fire({
            title: "Tidak Ada Data",
            icon: "error",
            text: "Penilaian untuk wilayah ini belum diisi. Isi sekarang?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak"
          }).then((result) => {
            if (result.isConfirmed) {
              $('#kelregio').removeClass('show');
              $('#kelregio').addClass('hidden');
              $('#isian').removeClass('hidden');
              $('#isian').addClass('show');
              $.unblockUI();
              pilket = 'block';
              setisian();
              return pilket;
            } else {
              dudata('pilnil');
              dudata('pilnild1');
              dudata('periode');
              location.reload();
            }
          });//          alert(JSON.stringify(data1));
        } else {
          dindikator = JSON.parse(data1);
          return dindikator;
        }
      }
    });

    var dom = document.getElementById(elid);
    var myChart = echarts.init(dom);

    option = {
        title : {
            text: 'Keuskupan Ketapang',
            subtext: 'Penilaian Paroki'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            orient : 'vertical',
            x : 'right',
            y : 'bottom',
            data:dindikator.isi2
        },
        toolbox: {
            show : true,
            feature : {
                restore : {show: true,title:'muat'},
                saveAsImage : {show: true,title:'simpan'}
            }
        },
        polar : [
           {
               indicator : dindikator.indi,
               type: 'circle',
               radius: '80%',
               axisLabel: {
                   show: true,
                   textStyle: {
                       color: '#bbb'
                   }
               },
            }
        ],
        calculable : true,
        series : [
            {
              name: 'Nilai',
              type: 'radar',
              itemStyle: {
                  normal: {
                      areaStyle: {
                          type: 'default'
                      }
                  }
              },
                data : dindikator.isi1,
                name : '张三',
                      itemStyle: {
                          normal: {
                              color: function(params) {
                                  var value = params.data
                                  return isNaN(value)
                                         ? undefined
                                         : (value >= 5 ? 'green' : 'red')
                              },
                              label: {
                                  show: true,
                                  formatter:function(params) {
                                      return params.value;
                                  }
                              },
                              areaStyle: {
                                  type: 'default'
                              }
                          }
                      }
            }
        ]
    };

    myChart.setOption(option);
  }
  iudata('pilnil','global');
  dudata('pilnild1');
  $.unblockUI();
}


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
                  var $frmnil = $('<form />');
                  var $inpsub = $('<button />');

                  $frmnil.attr('id','setnil');
                  $frmnil.attr('action','/markas/penilaian/simnilai');
                  $frmnil.attr('method','post');

//                  $inpsub.attr('type','submit');
                  $inpsub.attr('class','btn btn-success');
                  $inpsub.attr('onclick','kliksim()');
                  $inpsub.text("Simpan");

                  $('#a1').append($frmnil);
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

                    $('#setnil').append($diva);
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
                          var $divketa = $('<div />');
                          var $divketb = $('<div />');
                          var $divketc = $('<div />');
                          var $lbla = $('<label />');
                          var $inpa = $('<input />');
                          var $inpb = $('<input />');
                          var isidt = '';

                          if(selem[j].qnilc_kodec == delem[k].qnild_kodec){

                          $lbla.attr('for','k'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());
                          $lbla.attr('class','control-label col-md-6');
                          $lbla.text(delem[k].qnild_koded+' '+delem[k].qnild_nama);

                          $inpa.attr("id",'i'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());
                          $inpa.attr("name",'i'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());
                          $inpa.attr("type","text");
                          $inpa.attr("class","range10 form-control");
                          for (let l = 0; l < dtparoki.length-1; l++) {
                            if(dtparoki[l].qnil_kode == delem[k].qnild_koded){
//                              console.log(dtparoki[l].qnil_kode+'|'+delem[k].qnild_koded);
                              isidt = dtparoki[l].qnil_nilai > 0?dtparoki[l].qnil_nilai:0;
                            }
                          }
                          $inpa.attr("value",isidt);
                          $inpa.attr("onchange","trfval(this.value,this.id);");

                          $inpb.attr("id",'k'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());
                          $inpb.attr("name",'k'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());
                          $inpb.attr("type","text");
                          $inpb.attr("class","form-control isinor");
                          $inpb.attr("value",isidt?isidt:0);
                          $inpb.attr("maxlength",2);
                          if(datapar != '[]'){
                            $inpb.attr("readonly","readonly");
                          }

                          $divketa.attr('class','col-lg-10 col-md-10 col-sm-9 col-xs-9');
                          $divketa.attr("id",'d1'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());

                          $divketb.attr('class','col-lg-2 col-md-2 col-sm-3 col-xs-3');
                          $divketb.attr("id",'d2'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());

                          $divketc.attr('class','col-lg-12 col-md-12 col-sm-12 col-xs-12');
                          $divketc.attr("id",'d3'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase());

                          $('#pbody'+i).append($divketa);
                          $('#pbody'+i).append($divketb);
                          $('#pbody'+i).append($divketc);
                          $('#d1'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase()).append($lbla);
                          $('#d2'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase()).append($inpb);
                          $('#d3'+delem[k].qnild_koded.replace(/[\s,.\/-]+/g, "").toLowerCase()).append($inpa);
                          }
                        }
                        $('.panel-heading').addClass('collapsed');
                        if(datapar == '[]'){
                          $('#a1').append($inpsub);
                          init_IonRangeSlider();
                        } else {
                          init_IonRangeSlider(true);
                        }
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

function trfval(valu,idval){
var idb = idval.replace('i','k');
$('#'+idb).val(valu);
}
function init_IonRangeSlider(ibool) {

  if( typeof ($.fn.ionRangeSlider) === 'undefined'){ return; }
  console.log('init_IonRangeSlider');
  $(".range10").ionRangeSlider({
    type:"single",
    min: 0,
    max: 10,
//    from: 5,
    grid: true,
    grid_snap:true,
    hide_min_max: false,
			  keyboard: true,
    force_edges: true,
    disable:(ibool?ibool:(varopta=='00'?false:true)),
    step:1
  });

};

function iudata(nmdat,nldat){
  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>markas/core1/simudata",
    cache: false,
    async: false,
    data: jQuery.param({
      nmu:nmdat,
      nlu:nldat
    }),
    success: function(datau){
    },
    error: function(jqXHR, textStatus, errorThrown) {
    }
  });
}

function dudata(nmdat){
  $.ajax({
    type: "post",
    url: "<?php echo base_url(); ?>markas/core1/deludata",
    cache: false,
    async: false,
    data: jQuery.param({
      nmu:nmdat
    }),
    success: function(datau){
    },
    error: function(jqXHR, textStatus, errorThrown) {
    }
  });
}

</script>
