
<script>
var randomScalingFactor = function() {
    return Math.round(Math.random() * 100);
};
var randomColorFactor = function() {
    return Math.round(Math.random() * 255);
};
var randomColor = function(opacity) {
    return 'rgba(' + randomColorFactor() + ',' + randomColorFactor() + ',' + randomColorFactor() + ',' + (opacity || '.3') + ')';
};
//var $progress = $('#animationProgress');
var config = {
    type: 'line',
    data: {
        labels: ["0"],
        datasets: [
          {label: "Debet ", data: [0]},
          {label: "Kredit ", data: [0]}
      ]
    },
    options: {
        tooltips: {
            mode: 'label',
        },
        scales: {
            xAxes: [{
                scaleLabel: {
                    show: true,
                    labelString: 'Hari'
                }
            }],
            yAxes: [{
                scaleLabel: {
                    show: true,
                    labelString: 'Jumlah'
                },
            }]
        }
    }
};
$.each(config.data.datasets, function(i, dataset) {
    dataset.borderColor = randomColor(0.4);
    dataset.backgroundColor = randomColor(0.5);
    dataset.pointBorderColor = randomColor(0.7);
    dataset.pointBackgroundColor = randomColor(0.5);
    dataset.pointBorderWidth = 1;
});
$(document).ajaxStop($.unblockUI);
$(document).ready(function (){
  setCookie('seto','4');
  catat('Buka modul Buku Besar');
  var ca1 = '111.01.00.00';
  var ca2 = $('#fl_tgl1').val();
  var ca3 = $('#fl_tgl2').val();
  cekreport();
  fillgrid(ca1,ca2,ca3);
  var ctx = document.getElementById("chart_buku").getContext("2d");
  window.myLine = new Chart(ctx, config);

});

$("#saringbuku").click(function (e){
    var d1 = $('#fl_jenis').val();
    var d2 = $('#fl_tgl1').val();
    var d3 = $('#fl_tgl2').val();
    table.destroy();
    fillgrid(d1,d2,d3);
    setchart(d1,d2,d3);
});

$('#fl_jenis').select2({
  tags: true,
  multiple: false,
  tokenSeparators: [',', ' '],
  minimumInputLength: -1,
  minimumResultsForSearch: 10,
placeholder: "Perkiraan/Akun",
  ajax: {
    url: '<?php echo base_url();?>markas/core1/get_nmr2',
    type: "post",
    dataType: 'json',
    delay: 250,
    data: function (params) {
      return {
        searchTerm: params.term,
        param1:0,
        param2:''
      };
    },
    processResults: function (data) {
      return {
        results: $.map(data, function(obj) {
          return {
            id: obj.ka_3+'.'+obj.ka_4+'.'+obj.ka_5,
            text: obj.ka_nama
          };
        })
      };
    },
    cache: true
  }
});


function toDate(dateStr) {
    var parts = dateStr.split("-");
    return new Date(parts[2], parts[1] - 1, parts[0]);
}

function saringdet(partgl){
  table.destroy();
  var gourl = '<?php echo base_url();?>markas/reports/hitbulan';
  $.ajax({
      url: gourl,
      type: 'POST',
      data: jQuery.param({
        blnthn: partgl
      }),
      success: function(itahun) {
        fillgrid($('#fl_jenis').val(),'1-'+partgl.substr(4,partgl.length-4)+'-'+partgl.substr(0,4),itahun+'-'+partgl.substr(4,partgl.length-4)+'-'+partgl.substr(0,4));
        setchart($('#fl_jenis').val(),'1-'+partgl.substr(4,partgl.length-4)+'-'+partgl.substr(0,4),itahun+'-'+partgl.substr(4,partgl.length-4)+'-'+partgl.substr(0,4));
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

function cekreport(){
  var gourl = '<?php echo base_url();?>markas/reports/get_keu';
  $.ajax({
      url: gourl,
      type: 'POST',
      data: jQuery.param({
        katcari: 'thn',
        valcari:''
      }),
      success: function(itahun) {
        if(itahun != ''){
          var isidata = JSON.parse(itahun);
          var icel = '';
          for (var i = 0; i <= isidata.length-1; i++) {
            icel += '<div><button class="btn btn-app red pull-right" onclick="cekdetreport(\''+isidata[i].waktu+'\')">'+isidata[i].waktu+'</btn></div>';
            icel += '<div id="list'+isidata[i].waktu+'"  class="tagsinput" style="width:100%;"></div>';
            icel += '<hr/>';
          }
          $('#buttable').append(icel);
        } else {
          $("#myNav").css('width','100%');
          $('.sidebar').css('opacity',0);
          swal({
            title: "Data Kosong",
            text: "Halaman dapat dibuka jika sudah ada data yang diposting!",
            type: "warning",
            timer: 5000,
            showCancelButton: false,
            showConfirmButton: true,
            closeOnConfirm: false,
            animation: "pop"
          },
          function(inputValue){
            setTimeout(function(){
              location.replace('/markas/core1');
            }, 1000);
          });
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

function cekdetreport(piltahun){
  var gourl = '<?php echo base_url();?>markas/reports/get_keu';
  $.ajax({
      url: gourl,
      type: 'POST',
      data: jQuery.param({
        katcari: 'bln',
        valcari: piltahun
      }),
      success: function(itahun) {
        var isidata = JSON.parse(itahun);
        var icel = '';
        $('.bulan').remove();
        for (var i = 0; i <= isidata.length-1; i++) {
          icel += '<div class="bulan"><button class="btn btn-app btn-sm" onclick="saringdet(\''+piltahun+isidata[i].angka+'\')">'+isidata[i].huruf+'</btn></div>';
        }
        $('#list'+piltahun).append(icel);
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

//---------------------------------#


function setchart(g1,g2,g3){
    var kode = g1;
    var td1 = toDate(g2).toISOString().split('T')[0];
    var td2 = toDate(g3).toISOString().split('T')[0];
    var ktx1 = $('#fl_jenis  option:selected').text();
var ktx = ktx1.replace('&',' DAN ');

    var url1 = "<?php echo base_url(); ?>markas/core1/getchartdata/area4"+kode+td1+td2;
    var url2 = "<?php echo base_url(); ?>markas/core1/getcharttgl/area4"+kode+td1+td2;
    $.ajax({
      type: "POST",
      url: url1+"D",
      data: {"data":"check"},
      success: function(data1){
        $.ajax({
          type: "POST",
          url: url1+"K",
          data: {"data":"check"},
          success: function(data2){
            $.ajax({
              type: "POST",
              url: url2,
              data: {"data":"check"},
              success: function(data3){
                config.data.datasets = [
                  {label: "Debet ", data: JSON.parse(data1)},
                  {label: "Kredit ", data: JSON.parse(data2)}
                ];
                config.data.labels = JSON.parse(data3);
                $.each(config.data.datasets, function(i, dataset) {
                    dataset.borderColor = randomColor(0.4);
                    dataset.backgroundColor = randomColor(0.5);
                    dataset.pointBorderColor = randomColor(0.7);
                    dataset.pointBackgroundColor = randomColor(0.5);
                    dataset.pointBorderWidth = 1;
                });
                window.myLine.update();
              }
            });
          }
        });
      }
    });
}

    function fillgrid(f1,f2,f3){
        $.blockUI();
        var kode = f1;
        var t1 = f2;
        var t2 = f3;
        var td1 = toDate(f2).toISOString().split('T')[0];
        var td2 = toDate(f3).toISOString().split('T')[0];
        var ktx1 = $('#fl_jenis  option:selected').text();
        var ktx = ktx1.replace('&',' DAN ');
        var url = "<?php echo base_url(); ?>markas/core1/fillgrid/area4"+kode+td1+td2;
        var tglctk = new Date();
        var jsDate = tglctk.getDate()+'-'+(tglctk.getMonth()+1)+'-'+tglctk.getFullYear();
        var jsDate2 = tglctk.getDate()+(tglctk.getMonth()+1)+tglctk.getFullYear();
        var implogo = "<?php echo base64_encode(file_get_contents(base_url().'/dapur0/images/logokop.png'))?>";

        table = $('#tfillgrid').DataTable({
          "footerCallback": function(row, data, start, end, display) {
              var api = this.api(), data;
              var intVal = function(i) {
                  return typeof i === 'string' ?
                      i.replace(/[^\d\-\.\/a-zA-Z]/g,'') * 1 :
                      typeof i === 'number' ?
                      i : 0;
              };
              total5 = api
                  .column(5)
                  .data()
                  .reduce(function(a, b) {
                      var a = intVal(a) + intVal(b);
                      var a = a.toFixed(2);
                      return a;
                  }, 0);
              total6 = api
                  .column(6)
                  .data()
                  .reduce(function(c, d) {
                      var c = intVal(c) + intVal(d);
                      var c = c.toFixed(2);
                      return c;
                  }, 0);
                  total7 = total5-total6
              $(api.column(0).footer()).html('');
              $(api.column(1).footer()).html('');
              $(api.column(2).footer()).html('');
              $(api.column(3).footer()).html('');
              $(api.column(4).footer()).html('TOTAL');
              $(api.column(5).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total5));
              $(api.column(6).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total6));
              $(api.column(7).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total7));
          },
          "lengthMenu": [[50, 100, -1], [50, 100, "All"]],
          "language":{
            "decimal":        ",",
            "thousands":      ".",
              "emptyTable":     "Belum ada data",
              "info":           "Data ke _START_ s/d _END_ dari _TOTAL_ data",
              "infoEmpty":      "Data ke 0 s/d 0 dari 0 data",
              "infoFiltered":   "(Disaring dari _MAX_ data)",
              "infoPostFix":    "",
              "lengthMenu":     "Tampilkan _MENU_ data",
              "search":         "Cari:",
              "zeroRecords":    "Tidak ada data yang cocok",
              "paginate": {
                  "first":      "Awal",
                  "last":       "Akhir",
                  "next":       ">",
                  "previous":   "<"
              },
              "aria": {
                  "sortAscending":  ": activate to sort column ascending",
                  "sortDescending": ": activate to sort column descending"
              }
          },
          "processing": false,
          "serverSide": true,
          "order": [],
          "dom": '<"row bg-warning"<"col-sm-4"l><"col-sm-4"B><"col-sm-4"f>t<"col-sm-6"i>>',
            "buttons": [
            {
                "extend": 'print',
                "message": 'Laporan Buku Besar',
                "text": '<i class="fa fa-print"></i>',
                "titleAttr": 'Export: CETAK',
                "customize": function (win) {
                    $(win.document.body).find('table').addClass('display').css('font-size', '10px');
                    $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                        $(this).css('background-color','#e2e2e2');
                    });
                    $(win.document.body).find('h1').css('text-align','center');
                },
                "exportOptions": {
                    columns: ':visible'
                },
                format: {
                              body: function(data, row, column, node) {
                                  data = $('<p>' + data + '</p>').text();
                                  return $.isNumeric(data.replace(',', '')) ? data.replace(',', '') : data;
                              }
                          }
            },
            {
                extend: 'excel',
                footer: true,
                title: kode + '_' + ktx.substring(15,ktx.length),
                text: '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Export: EXCEL',
                filename: kode + '_' + ktx.substring(15,ktx.length),
                sheetName: kode,
                customize: function(xlsx) {
                  var sheet = xlsx.xl.worksheets['sheet1.xml'];
                  var downrows = 4;
                  var clRow = $('row', sheet);
                  var msg;
                  //update Row
                  clRow.each(function() {
                    var attr = $(this).attr('r');
                    var ind = parseInt(attr);
                    ind = ind + downrows;
                    $(this).attr("r", ind);
                  });

                  // Update  row > c
                  $('row c ', sheet).each(function() {
                    var attr = $(this).attr('r');
                    var pre = attr.substring(0, 1);
                    var ind = parseInt(attr.substring(1, attr.length));
                    ind = ind + downrows;
                    $(this).attr("r", pre + ind);
                  });

                  function Addrow(index, data) {

                    msg = '<row xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" r="' + index + '">';
                    for (var i = 0; i < data.length; i++) {
                      var key = data[i].k;
                      var value = data[i].v;
                      msg += '<c t="inlineStr" r="' + key + index + '">';
                      msg += '<is>';
                      msg += '<t>' + value + '</t>';
                      msg += '</is>';
                      msg += '</c>';
                    }
                    msg += '</row>';
                    return msg;
                  }
                  var r1 = Addrow(1, [{
                    k: 'A',
                    v: ktx.substring(15,ktx.length)
                  }, {
                    k: 'B',
                    v: ktx
                  }]);
                  var r2 = Addrow(2, [{
                    k: 'A',
                    v: 'Kode Akun : ' + kode
                  }]);
                  var r3 = Addrow(3, [{
                    k: 'A',
                    v: 'Periode : ' + t1 + ' - ' + t2
                  }]);

                  sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + r3 + sheet.childNodes[0].childNodes[1].innerHTML;
                },
                exportOptions: {
                    columns: [1,2,3,4,5,6,7],
                    orthogonal: 'export'

                }
            },
            {
                "extend": 'copy',
                "message": 'Disalin dari QMARSUPIUM 2024, AR Setontong',
                "text": '<i class="fa fa-clone"></i>',
                "titleAttr": 'Export: SALIN'
            },
            {
              "extend": 'pdfHtml5',
              "title": 'Periode ' + t1 + ' s/d ' + t2,
              "text": '<i class="fa fa-file-pdf-o"></i>',
              "titleAttr": 'Export: PDF',
                "pageSize": 'A4',
                "header": true,
                "footer": true,
                "customize": function ( doc ) {
                    var bod = []; // this will become our new body (an array of arrays(lines))
                    doc.content[1].table.body.forEach(function(line, i){
                        if( i < doc.content[1].table.body.length-1){
                          if(i < 1){
                            bod.push([
                              {text:line[1].text, style:'tableHeader'},
                              {text:line[2].text, style:'tableHeader'},
                              {text:line[3].text, style:'subheader'},
                              {text:line[4].text, style:'subheader'},
                              {text:line[5].text, style:'subheader'},
                              {text:line[6].text, style:'subheader'},
                              {text:line[7].text, style:'subheader'}
                            ]);
                          } else {
                            bod.push([
                              {text:line[1].text, style:'defaultStyle1'},
                              {text:line[2].text, style:'defaultStyle1'},
                              {text:line[3].text, style:'defaultStyle1'},
                              {text:line[4].text, style:'defaultStyle1'},
                              {text:line[5].text, style:'defaultStyle2'},
                              {text:line[6].text, style:'defaultStyle2'},
                              {text:line[7].text, style:'defaultStyle2'}
                            ]);
                          }
                        }
                        else{
                            bod.push([{text:'', style:'lastLine', colSpan: 3},'','',
                            {text:'TOTAL', style:'lastLine'},
                            {text:line[5].text, style:'lastLine'},
                            {text:line[6].text, style:'lastLine'},
                            {text:line[7].text, style:'lastLine'}]);
                        }

                    }
                  );

                  doc.pageMargins = [50, 20, 20,20 ];
                  doc.content[1].table.headerRows = 1;
                  doc.content[1].table.widths = ['3%','12%','14%','35%','12%','12%','12%'];
                  doc.content[1].table.body = bod;
                  var objLayout = {};
                  objLayout['hLineWidth'] = function(i) { return .5; };
                  objLayout['vLineWidth'] = function(i) { return .5; };
                  objLayout['hLineColor'] = function(i) { return '#aaa'; };
                  objLayout['vLineColor'] = function(i) { return '#aaa'; };
                  objLayout['paddingLeft'] = function(i) { return 4; };
                  objLayout['paddingRight'] = function(i) { return 4; };
                  doc.content[1].layout = objLayout;

                  doc.content[2] = [{
                    table: {
                      // headers are automatically repeated if the table spans over multiple pages
                      // you can declare how many rows should be treated as headers
                      headerRows: 0,
                      widths: ['5%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '10%', '5%'],
                      heights: 20,

                      body: [
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      [{
                        text: '',
                        rowSpan: 11
                      }, {
                        text: 'Keterangan',
                        rowSpan: 5,
                        colSpan: 2,
                        bold: true,
                        style: 'defaultStyle1'
                      }, '', {
                        text: ':',
                        rowSpan: 5,
                        alignment: 'right',
                        bold: true,
                        style: 'defaultStyle1'
                      }, {
                        text: '---.',
                        rowSpan: 5,
                        colSpan: 6,
                        bold: true,
                        style: 'defaultStyle1'
                      }, '', '', '', '', '', {
                        text: '',
                        rowSpan: 11
                      }],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', {
                        text: '\nDisetujui,',
                        colSpan: 3,
                        style: 'defaultStyle3'
                      }, '', '', {
                        text: '\nDiperiksa,\n\n\n\n\n\n',
                        colSpan: 3,
                        style: 'defaultStyle3'
                      }, '', '', {
                        text: '\nDibuat,',
                        colSpan: 3,
                        style: 'defaultStyle3'
                      }, '', '', ''],
                      ['', '', '', '', '', '', '', '', '', '', ''],
                      ['', {
                        text: '(______________________________)',
                        colSpan: 3,
                        bold: true,
                        style: 'defaultStyle3'
                      }, '', '', {
                        text: '(______________________________)',
                        colSpan: 3,
                        bold: true,
                        style: 'defaultStyle3'
                      }, '', '', {
                        text: '(______________________________)',
                        colSpan: 3,
                        bold: true,
                        style: 'defaultStyle3'
                      }, '', '', '']
                      ]
                    },
                    layout: {
                      hLineWidth: function(i, node) {
                        return .5;
                      },
                      vLineWidth: function(i, node) {
                        return .5;
                      },
                      hLineColor: function(i, node) {
                        return '#fff';
                      },
                      vLineColor: function(i, node) {
                        return '#fff';
                      }
                    }
                  }];


                  var logo = 'data:image/png;base64,'+implogo;

                  var tglctk = new Date();
                  var jsDate = tglctk.getDate()+'-'+(tglctk.getMonth()+1)+'-'+tglctk.getFullYear();
                  doc['footer']=(function(page, pages) {
                    return {
                      columns: [{
                        text: 'QMARSUPIUM 2024 @AR Setontong ('+jsDate.toString()+')',
                        fontSize: 6,
                        alignment: 'left',
                        margin:[20]
                      },
                      {
                        alignment: 'right',
                        text: [{text: page.toString(),italics: true},' dari ',{ text: pages.toString(), italics: true }],
                        fontSize: 6,
                        alignment: 'right',
                        margin:[0,0,20]
                      }
                    ]}
                  });

                  doc.content.splice( 0, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    fontSize: 14,
                    bold: true,
                    alignment: 'left',
                    image: logo,
                    width: 120
                  } );

                  doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    fontSize: 12,
                    bold: true,
                    alignment: 'center',
                    text: 'Buku Besar ' + ktx
                  } );

                  doc.styles = {
                      subheader: {
//                        rows: 2,
                        color: '#ffffff',
                        fontSize: 9,
                        alignment: 'center',
                        fontweight: 'bold',
                        fillColor: '#006600'
                      },
                      tableHeader: {
                          bold: true,
                          rows: 2,
                          color: '#ffffff',
                          fontSize: 9,
                          alignment: 'center',
                          fontweight: 'bold',
                          fillColor: '#006600'
                      },
                      lastLine: {
                          bold: true,
                          fontSize: 9,
                          color: 'black'
                      },
                      defaultStyle1: {
                      fontSize: 9,
                      alignment: 'left'
                      },
                      defaultStyle2: {
                      fontSize: 9,
                      alignment: 'right'
                      }
                  }

                }
            }
        ],
            "ajax": {
                "url": url,
                "type": "POST"
            },
        scrollY: 400,
        scroller: {
            loadingIndicator: true
        },
            "columnDefs": [
              {
                  "targets": [ 0,1,4,5,6,7 ],
                  "orderable": false
              },
                {
                    targets: [ 5,6,7 ],
                    "render": $.fn.dataTable.render.number( '.', ',', 0),

                    createdCell: function (td, cellData, rowData, row, col)
                    {
                      $(td).css('text-align', 'right');
                        if ( cellData < 0 ) {
                            $(td).css('color', 'red');
                          }
                    }
                }
            ],
        });
        $('.dt-button').addClass('btn btn-icon btn-success heartbeat animated delay-1s');
        $('.btn').removeClass('dt-button');
        catat("Saring Buku Besar " + kode + " range: " + td1 + " to " + td2);
        $.unblockUI();
    }

    function reload_table(){
        table.ajax.reload(null,false); //reload datatable ajax
    }

</script>
