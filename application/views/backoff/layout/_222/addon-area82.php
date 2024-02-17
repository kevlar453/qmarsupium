<script>
$(document).ajaxStop($.unblockUI);
$(document).ready(function (){
  setCookie('seto','82');
  catat('Buka modul Neraca');
  cekreport();
  fillgrid($('#fl_tgl1').val(),$('#fl_tgl2').val());
  setTimeout(function(){
    if(varopta == '00'){
      $('.opta2').text('Valid');
      $('.panatas').addClass('hide');
    } else {
      $('.opta2').text('Posting');
      $('.panatas').removeClass('hide');
    }
      $("#myNav").css('height','0%');
      $('.sidebar').css('opacity',1);
  },1000);
});


$("#saringbill1").click(function (e){
    table.destroy();
    fillgrid($('#fl_tgl1').val(),$('#fl_tgl2').val());
});

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
        fillgrid('1-'+partgl.substr(4,partgl.length-4)+'-'+partgl.substr(0,4),itahun+'-'+partgl.substr(4,partgl.length-4)+'-'+partgl.substr(0,4));
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

function toDate(dateStr) {
    var parts = dateStr.split("-");
    return new Date(parts[2], parts[1] - 1, parts[0]);
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
          swal.fire({
            title: "Data Kosong",
            text: "Halaman dapat dibuka jika sudah ada data yang "+(varopta=='00'?'diperiksa':'diposting')+"!",
            type: "warning",
            timer: 5000,
            timerProgressBar: true,
            showCancelButton: false,
            showConfirmButton: false,
            closeOnConfirm: false,
            animation: "pop"
          });
          setTimeout(function(){
            location.replace('/markas/core1');
          }, 5000);
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
function fillgrid(ftgawal,ftgakhir){
  $.blockUI();
  var f1 = toDate(ftgawal);
  var f2 = toDate(ftgakhir);
      var t1 = ftgawal;
      var t2 = ftgakhir;
      var td1 = f1.toISOString().split('T')[0];
      var td2 = f2.toISOString().split('T')[0];
      var url = "<?php echo base_url(); ?>markas/core1/filltemp1/"+td1+td2;
      var implogo = "<?php echo base64_encode(file_get_contents(base_url().'/dapur0/images/logokop.png'))?>";
//      var data = $(this).serialize();

  table = $('#tfillgrid').DataTable({
    "footerCallback": function(row, data, start, end, display) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function(i) {
            return typeof i === 'string' ?
                i.replace(/[^\d\-\.\/a-zA-Z]/g,'') * 1 :
                typeof i === 'number' ?
                i : 0;
        };

        // Total over all pages 2
        total2 = api
            .column(2)
            .data()
            .reduce(function(a2, b2) {
                var a2 = intVal(a2) + intVal(b2);
                var a2 = a2.toFixed(2);
                return a2;
            }, 0);

        // Total over all pages 3
        total3 = api
            .column(3)
            .data()
            .reduce(function(a3, b3) {
                var a3 = intVal(a3) + intVal(b3);
                var a3 = a3.toFixed(2);
                return a3;
            }, 0);

        // Total over all pages 4
        total4 = api
            .column(4)
            .data()
            .reduce(function(a4, b4) {
                var a4 = intVal(a4) + intVal(b4);
                var a4 = a4.toFixed(2);
                return a4;
            }, 0);

        // Total over all pages 5
        total5 = api
            .column(5)
            .data()
            .reduce(function(a5, b5) {
                var a5 = intVal(a5) + intVal(b5);
                var a5 = a5.toFixed(2);
                return a5;
            }, 0);

            // Total over all pages 5
            total6 = api
                .column(6)
                .data()
                .reduce(function(a6, b6) {
                    var a6 = intVal(a6) + intVal(b6);
                    var a6 = a6.toFixed(2);
                    return a6;
                }, 0);

                // Total over all pages 5
                total7 = api
                    .column(7)
                    .data()
                    .reduce(function(a7, b7) {
                        var a7 = intVal(a7) + intVal(b7);
                        var a7 = a7.toFixed(2);
                        return a7;
                    }, 0);

        // Update footer
        $(api.column(0).footer()).html('TOTAL');
        $(api.column(1).footer()).html('');
        $(api.column(2).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total2));
        $(api.column(3).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total3));
        $(api.column(4).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total4));
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
//        "processing":     "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>",
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
//          "destroy": true,
    "processing": false,
    "serverSide": true,
    "order": [],
    "dom": '<"row bg-warning"<"col-sm-4"l><"col-sm-4"B><"col-sm-4"f>t<"col-sm-6"i>>',
      "buttons": [
      {
            "extend": 'print',
            "message": 'Laporan Transaksi',
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
                columns: 'visible'
            }
        },
        {
            extend: 'excel',
            messageBottom: 'QMARSUPIUM @AR Setontong',
            footer: true,
            title: 'Neraca Percobaan ' + t1 + ' s/d ' + t2,
            text: '<i class="fa fa-file-excel-o"></i>',
            titleAttr: 'Export: EXCEL',
            filename: 'Neraca Percobaan_' + t1 + '_' + t2,
            sheetName: t1 + '|' + t2,
/*            customize: function(xlsx) {
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
                v: 'Neraca Percobaan '
              }]);
              var r2 = Addrow(3, [{
                k: 'A',
                v: 'Periode : ' + t1 + ' s/d ' + t2
              }]);

              sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2 + sheet.childNodes[0].childNodes[1].innerHTML;
            }, */
            exportOptions: {
                columns: [0,1,2,3,4,5,6,7],
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
//            "download": 'open',
            "orientation":'portrait',
              "exportOptions": {
              "columns": ':visible',
              "modifier": {
                page: 'current'
              },
              "stripNewlines": false
            },
            "customize": function ( doc ) {
                var bod = [];
                bod.push([
                  {text:'', style:'tableHeader',colSpan:2},
                  {},
                  {text:'Saldo Awal', style:'tableHeader',colSpan: 2},
                  {},
                  {text:'Mutasi', style:'tableHeader',colSpan: 2},{},{text:'Saldo Akhir', style:'tableHeader',colSpan: 2},{}]);
                doc.content[1].table.body.forEach(function(line, i){
                    if( i < doc.content[1].table.body.length-1){
                      if(i < 1){
                        bod.push([
                          {text:line[0].text, style:'tableHeader'},
                          {text:line[1].text, style:'tableHeader'},
                          {text:line[2].text, style:'subheader'},
                          {text:line[3].text, style:'subheader'},
                          {text:line[4].text, style:'subheader'},
                          {text:line[5].text, style:'subheader'},
                          {text:line[6].text, style:'subheader'},
                          {text:line[7].text, style:'subheader'}
                        ]);
                      } else {
                        bod.push([
                          {text:line[0].text, style:'defaultStyle1'},
                          {text:line[1].text, style:'defaultStyle1'},
                          {text:line[2].text, style:'defaultStyle2'},
                          {text:line[3].text, style:'defaultStyle2'},
                          {text:line[4].text, style:'defaultStyle2'},
                          {text:line[5].text, style:'defaultStyle2'},
                          {text:line[6].text, style:'defaultStyle2'},
                          {text:line[7].text, style:'defaultStyle2'}
                        ]);
                      }
                    }
                    else{
                        bod.push([
                          {text:line[0].text, style:'lastLine',colSpan:2},{},
                          {text:line[2].text, style:'lastLine'},
                          {text:line[3].text, style:'lastLine'},
                          {text:line[4].text, style:'lastLine'},
                          {text:line[5].text, style:'lastLine'},
                          {text:line[6].text, style:'lastLine'},
                          {text:line[7].text, style:'lastLine'}
                        ]);
                    }

                }
              );
              doc.pageMargins = [50, 20, 20,20 ];
              doc.content[1].table.headerRows = 2;
              doc.content[1].table.widths = ['11%','29%','10%','10%','10%','10%','10%','10%'];
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

              var logo =  'data:image/png;base64,'+implogo;
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

              doc.content.splice(0, 1, {
                columns: [{
                    width: '52%',
                    fontSize: 9,
                    bold: true,
                    alignment: 'left',
                    image: logo,
                    //                  text: '<!!----------!!>',
                    width: 120
                  },
                  {
                    width: '38%',
                    alignment: 'right',
                    bold: true,
                    fontSize: 8,
                    text: ''
                  },
                  {
                    width: '2%',
                    fontSize: 8,
                    text: ''
                  },
                  {
                    width: '5%',
                    alignment: 'right',
                    fontSize: 8,
                    text: ''
                  }
                ],
                columnGap: 2
              }, {
                columns: [{
                    width: '10%',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: 'Periode'
                  },
                  {
                    width: '5%',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: ':\n'
                  },
                  {
                    width: '20%',
                    alignment: 'right',
                    fontSize: 8,
                    text: t1 + ' s/d ' + t2
                  },
                  {
                    width: 'auto',
                    alignment: 'right',
                    fontSize: 8,
                    text: ''
                  },
                  {
                    width: 'auto',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: ''
                  },
                  {
                    width: 'auto',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: ''
                  },
                  {
                    width: 'auto',
                    alignment: 'right',
                    fontSize: 8,
                    text: ''
                  }
                ],
                columnGap: 2
              });

              doc.content.splice(1, 0, {
                columns: [{
                    width: '10%',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: 'Jns Laporan\nKode\n\n'
                  },
                  {
                    width: '2%',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: ':\n:\n\n'
                  },
                  {
                    width: '53%',
                    alignment: 'left',
                    fontSize: 8,
                    text: 'Neraca Rugi Laba' + '\n' + '_____________________' + '\n\n'
                  },
                  {
                    width: '10%',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: ''
                  },
                  {
                    width: '2%',
                    alignment: 'left',
                    fontSize: 8,
                    bold: true,
                    text: ''
                  },
                  {
                    width: '25%',
                    alignment: 'left',
                    fontSize: 8,
                    text: ''
                  }
                ]
              }, {
                columns: [{
                  width: '100%',
                  alignment: 'center',
                  fontSize: 14,
                  bold: true,
                  text: 'Laporan Neraca Rugi Laba' + '\n\n'
                }],
                columnGap: 2
              });


                              doc.styles = {
                                subtotal1a: {
                                  bold: true,
                                  italics:true,
                                  color: '#454545',
                                  fontSize: '7',
                                  alignment: 'center',
                                  fontweight: 'bold',
                                  fillColor: '#dadada'
                                },
                                subtotal1b: {
                                  bold: true,
                                  italics:true,
                                  color: '#454545',
                                  fontSize: '7',
                                  alignment: 'right',
                                  fontweight: 'bold',
                                  fillColor: '#dadada'
                                },
                                subtotal2: {
                                  bold: true,
                                  color: '#000',
                                  fontSize: '7',
                                  alignment: 'right',
                                  fontweight: 'bold',
                                  fillColor: '#a7a7a7'
                                },
                                subheader: {
                                  bold: true,
                                  rows: 2,
                                  color: '#ffffff',
                                  fontSize: '9',
                                  alignment: 'center',
                                  fontweight: 'bolder',
                                  fillColor: '#006600'
                                },
                                  tableHeader: {
                                      bold: true,
              //                        fontSize: 10.5,
              //                        color: 'black'
                                      rows: 2,
                                      color: '#ffffff',
                                      fontSize: '9',
                                      alignment: 'center',
                                      fontweight: 'bolder',
                                      fillColor: '#006600'
                                  },
                                  lastLine: {
                                      bold: true,
                                      fontSize: 8,
                                      alignment: 'right',
                                      color: '#ffffff',
                                      fontweight: 'bold',
                                      fillColor: '#006600'
                                  },
                                  defaultStyle1: {
                                  fontSize: 7,
                                  alignment: 'left'
              //                    color: 'blue'
                                  },
                                  defaultStyle2: {
                                  fontSize: 7,
                                  alignment: 'right'


              //                    color: 'blue'
                                  }
                              }

                          }
                      }
                  ],
    "columnDefs": [
        {
            targets: [ 2,3,4,5,6,7 ],
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
        "ajax": {
        "url": url,
        "type": "POST"
        },
        "deferRender": false,
        scrollY: 600,
        scroller: {
            loadingIndicator: true
        },
    });

    $('.dt-button').addClass('btn btn-icon btn-success heartbeat animated delay-1s');
    $('.btn').removeClass('dt-button');
    $.unblockUI();
//    reload_table()
}
//---------------------------------------///
//---------------------------------------///



function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax
}

//---------------------------------#


function fillgrid2(){
  var f1 = toDate($('#fl_tgl1').val());
  var f2 = toDate($('#fl_tgl2').val());
      var t1 = $('#fl_tgl1').val();
      var t2 = $('#fl_tgl2').val();
      var td1 = f1.toISOString().split('T')[0];
      var td2 = f2.toISOString().split('T')[0];
      var url = "<?php echo base_url(); ?>markas/core1/fillgrid/area2"+td1+td2;


    table = $('#tfillgrid').DataTable({
      "lengthMenu": [[50,100, 200, -1], [50,100, 200, "All"]],
      "paging": true,
      "destroy": true,
      "responsive": true,
      "ajax": {
          "url": url,
          "type": "POST"
      },
        "language":{
          "sLoadingRecords" : '<span style="width:100%;"><img src="http://www.snacklocal.com/images/ajaxload.gif"></span>',
            "decimal":        ",",
            "emptyTable":     "Belum ada data",
            "info":           "Data ke _START_ s/d _END_ dari _TOTAL_ data",
            "infoEmpty":      "Data ke 0 s/d 0 dari 0 data",
            "infoFiltered":   "(Disaring dari _MAX_ data)",
            "infoPostFix":    "",
            "thousands":      ".",
            "lengthMenu":     "Tampilkan _MENU_ data",
            "loadingRecords": "Memuat...",
            "processing":     "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>",
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
        "processing": true,
        "serverSide": true,
        "order": [],
        "dom": 'Bfrtip',
        "buttons": [
            {
                "extend": 'colvis',
                    "text": 'Kolom',
                    "collectionLayout": 'two-column'
            },
        {
            "extend": 'print',
            "message": 'Laporan Buku Besar',
            "customize": function (win) {
                $(win.document.body).find('table').addClass('display').css('font-size', '10px');
                $(win.document.body).find('tr:nth-child(odd) td').each(function(index){
                    $(this).css('background-color','#e2e2e2');
                });
                $(win.document.body).find('h1').css('text-align','center');
            },
            "exportOptions": {
                columns: ':visible'
            }
        },
        {
            "extend": 'excel',
            "message": 'Daftar Transaksi'
        },
        {
            "extend": 'copy',
            "message": 'Disalin dari HIS-2017 RSK St. Antonius Ampenan'
        },
        {
            "extend": 'pdfHtml5',
            "title": 'Transaksi Tgl ' + t1 + ' s/d ' + t2,
            "text": 'PDF',
            "pageSize": 'A4',
            "footer": true,
            "exportOptions": {
              columns: [ 0, 1, 2, 3, 4, 5],
                stripNewlines: false,
            },
            "customize": function ( doc ) {
                var cols = [];
                cols[0] = {text: 'QHMS 2017', fontSize: 6, alignment: 'left', margin:[20] };
                cols[1] = {text: 'RSK St. Antonius Ampenan', fontSize: 6, alignment: 'right', margin:[0,0,20] };
                var objFooter = {};
                objFooter['columns'] = cols;
                doc['footer']=objFooter;

                doc.defaultStyle.fontSize = 8;
                doc.styles.tableHeader.fontSize = 8;
                doc.styles.tableFooter.fontSize = 8;
                doc.content[1].table.widths = ['10%','10%','25%','25%','15%','15%'];
                doc.content.splice( 1, 0, {
                    margin: [ 0, 0, 0, 12 ],
                    fontSize: 14,
                    bold: true,
                    alignment: 'center',
                    text: '-- XXX --'
                } );
            }

        }
    ]
    });
//        table.destroy();
    reload_table();
}

//=========================================================

</script>
