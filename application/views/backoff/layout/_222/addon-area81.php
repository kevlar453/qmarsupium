<script>
$(document).ajaxStop($.unblockUI);
$(document).ready(function (){
  setCookie('seto','81');
  fillgrid($('#fl_tgl1').val(),$('#fl_tgl2').val());
  cekreport();
});

$("#saringbill1").click(function (e){
    table.destroy();
    fillgrid($('#fl_tgl1').val(),$('#fl_tgl2').val());
});

$('#piljurnal').select2({
    tags: true,
    multiple: false,
    tokenSeparators: [',', ' '],
    minimumResultsForSearch: -1,
//    minimumResultsForSearch: 10,
	placeholder: "Search for an Item",
    ajax: {
      url: '<?php echo base_url(); ?>markas/core1/list_jur',
      type: "post",
      dataType: 'json',
      delay: 250,
/*      data: function (params) {
        return {
          searchTerm: params.term,
          param:1
        };
      },
*/      processResults: function (data) {
        return {
          results: $.map(data, function(obj) {
            return {
                id: obj.akjur_kode2,
                text: obj.akjur_nama
            };
          })
        };
      },
      cache: true
    }
  }).on('select2:select', function(evt) {
    setCookie('piljur',$('#piljurnal').val());
  });


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
        var isidata = JSON.parse(itahun);
        var icel = '';
        for (var i = 0; i <= isidata.length-1; i++) {
          icel += '<div><button class="btn btn-app red pull-right" onclick="cekdetreport(\''+isidata[i].waktu+'\')">'+isidata[i].waktu+'</btn></div>';
          icel += '<div id="list'+isidata[i].waktu+'"  class="tagsinput" style="width:100%;"></div>';
          icel += '<hr/>';
        }
        $('#buttable').append(icel);
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
          icel += '<div class="bulan"><button class="btn btn-app btn-sm" onclick="saringdet(\''+piltahun+isidata[i].angka+'\')">'+isidata[i].huruf.substr(0,3)+'</btn></div>';
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
//---------------------------------#
function fillgrid(ftgawal,ftgakhir){
  $.blockUI();
  var f1 = toDate(ftgawal);
  var f2 = toDate(ftgakhir);
  var t1 = ftgawal;
  var t2 = ftgakhir;
  var td1 = f1.toISOString().split('T')[0];
  var td2 = f2.toISOString().split('T')[0];
  var url = "<?php echo base_url(); ?>markas/core1/fillgrid/area2"+td1+td2;
  var implogo = "<?php echo base64_encode(file_get_contents(base_url().'/dapur0/images/logokop.png'))?>";

  table = $('#tfillgrid').DataTable({
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
          columns: ':visible'
        }
      },
      {
        "extend": 'excel',
        "message": 'Daftar Transaksi',
        "footer": true,
        "title": 'Transaksi ' + t1 + ' s/d ' + t2,
        "text": '<i class="fa fa-file-excel-o"></i>',
        "titleAttr": 'Export: EXCEL',
      },
      {
        "extend": 'copy',
        "message": 'Disalin dari QMARSUPIUM 2024, AR Setontong',
        "text": '<i class="fa fa-clone"></i>',
        "titleAttr": 'Export: SALIN'
      },
      {
        "extend": 'pdfHtml5',
        "messageBottom": 'Daftar Transaksi',
        "title": 'Periode ' + t1 + ' s/d ' + t2,
        "text": '<i class="fa fa-file-pdf-o"></i>',
        "titleAttr": 'Export: PDF',
        "pageSize": 'A4',
        "header": true,
        "footer": true,
        "exportOptions": {
          "columns": ':visible',
          "modifier": {
            page: 'current'
          },
          "stripNewlines": false
        },
        "customize": function ( doc ) {
          var bod = [];
          doc.content[1].table.body.forEach(function(line, i){
            if( i < doc.content[1].table.body.length-1){
              if(i < 1){
                bod.push([
                {text:line[0].text, style:'tableHeader'},
                {text:line[1].text, style:'tableHeader'},
                {text:line[2].text, style:'tableHeader'},
                {text:line[3].text, style:'tableHeader'},
                {text:line[4].text, style:'tableHeader'},
                {text:line[5].text, style:'tableHeader'},
                {text:line[6].text, style:'tableHeader'}
                ]);
              } else {
                bod.push([
                {text:line[0].text, style:'defaultStyle1'},
                {text:line[1].text, style:'defaultStyle1'},
                {text:line[2].text, style:'defaultStyle1'},
                {text:line[3].text, style:'defaultStyle1'},
                {text:line[4].text, style:'defaultStyle1'},
                {text:line[5].text, style:'defaultStyle2'},
                {text:line[6].text, style:'defaultStyle2'}
                ]);
              }
            }

          }
          );

          doc.pageMargins = [50, 20, 20,20 ];
          doc.content[1].table.headerRows = 1;
          doc.content[1].table.widths = ['10%','11%','10%','auto','auto','12%','12%'];
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

          var logo =  'data:image/jpeg;base64,'+implogo;
          var tglctk = new Date();
          var jsDate = tglctk.getDate()+'-'+(tglctk.getMonth()+1)+'-'+tglctk.getFullYear();
          doc['footer']=(function(page, pages) {
            return {
              columns: [{
                text: 'QMARSUPIUM @AR Setontong ('+jsDate.toString()+')',
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

            doc.defaultStyle.fontSize = 8;
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
              text: 'Daftar Transaksi'
            } );

            doc.styles = {
              subheader: {
                rows: 2,
                color: '#ffffff',
                fontSize: '9',
                alignment: 'center',
                fontweight: 'bold',
                fillColor: '#006600'
              },
              tableHeader: {
                bold: true,
                rows: 2,
                color: '#ffffff',
                fontSize: '9',
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
                fontSize: 8,
                alignment: 'left'
              },
              defaultStyle2: {
                fontSize: 8,
                alignment: 'right'
              },
              tandaTangan: {
                bold: true,
                rows: 10,
                fontSize: 10,
                color: 'black',
                alignment: 'center'
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
          "targets": [ 3,4,5,6 ],
          "orderable": false
        },
        {
          "targets": [ 5,6 ],
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
      $.unblockUI();
      $('.dt-button').addClass('btn btn-icon btn-success heartbeat animated delay-1s');
      $('.btn').removeClass('dt-button');
    }

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
        "language":{
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
    ],
    "ajax": {
        "url": url,
        "type": "POST"
    }
    });
//        table.destroy();
    reload_table();
}

//=========================================================

</script>
