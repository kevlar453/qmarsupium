<script>
$(document).ajaxStop($.unblockUI);
    $(document).ready(function (){
      catat('Buka modul Buku Besar');
        fillgrid();
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

    $('#fa_per').select2({
      tags: true,
      multiple: false,
      tokenSeparators: [',', ' '],
      minimumInputLength: -1,
      minimumResultsForSearch: 10,
    placeholder: "Kelompok Perkiraan/Akun",
      ajax: {
        url: '<?php echo base_url(); ?>markas/core1/list_ka5',
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
          return {
            searchTerm: params.term,
            param1:1,
            param2:decode_cookie(getCookie('jnsjur'))
          };
        },
        processResults: function (data) {
          return {
            results: $.map(data, function(obj) {
              return {
                id: obj.ka_3,
                text: obj.ka_nama
              };
            })
          };
        },
        cache: true
      }
    }).on('select2:select', function(e) {
/*
      var kj = $('#ft_nmr1').val();
      var jns = setCookie('jnsperk',kj);
      $('#ft_nmr2').val('').trigger('change');
*/
    });

    $("#perbaharui").submit(function (e){
        e.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        var detcat1 = $('#fa_per').val();
        var detcat2 = $('#fa_jum').val();
        $.ajax({
            url:url,
            type:'POST',
            data:data
        }).done(function (data){
            reload_table();
        });
        catat("Isi data " + detcat1 + " " + detcat2);
    });

    function fillgrid(){
      var url = "<?php echo base_url(); ?>markas/core1/saldo";
      var implogo = "<?php echo base64_encode(file_get_contents(base_url().'/dapur0/images/logokop.png'))?>";

      table = $('#tsaldo').DataTable({
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
            "message": 'Daftar Saldo Awal',
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
            "message": 'Daftar Saldo Awal',
            "footer": true,
            "title": 'Saldo Awal',
            "text": '<i class="fa fa-file-excel-o"></i>',
            "titleAttr": 'Export: EXCEL',
          },
          {
            "extend": 'copy',
            "message": 'Disalin dari QHMS-2017 RSK St. Antonius Ampenan',
            "text": '<i class="fa fa-clone"></i>',
            "titleAttr": 'Export: SALIN'
          },
          {
            "extend": 'pdfHtml5',
            "messageBottom": 'Daftar Saldo Awal',
            "title": 'Dokumen Akuntansi',
            "text": '<i class="fa fa-file-pdf-o"></i>',
            "titleAttr": 'Export: PDF',
            "pageSize": 'A4',
            "header": true,
            "footer": true,
            "exportOptions": {
              "columns": [0,1,2],
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
                      {text:line[2].text, style:'tableHeader'}
                    ]);
                  } else {
                    bod.push([
                      {text:line[0].text, style:'defaultStyle1'},
                      {text:line[1].text, style:'defaultStyle1'},
                      {text:line[2].text, style:'defaultStyle2'}
                    ]);
                  }
                } else {
                    bod.push([
                    {text:line[0].text, style:'lastLine'},
                    {text:line[1].text, style:'lastLine'},
                    {text:line[2].text, style:'lastLine'}
                  ]);
/*
                    bod.push([
                      {text:'Disetujui,', style:'tandaTangan',colSpan:3},
                      {},
                      {},
                      {text:'Dibuat,', style:'tandaTangan',colSpan:3},
                      {},
                      {}
                    ]);
                    */
                  }
                }
              );

              doc.pageMargins = [50, 20, 20,20 ];
              doc.content[1].table.headerRows = 1;
              doc.content[1].table.widths = ['5%','70%','25%'];
              doc.content[1].table.body = bod;
              var objLayout = {};
              objLayout['hLineWidth'] = function(i) { return .5; };
              objLayout['vLineWidth'] = function(i) { return .5; };
              objLayout['hLineColor'] = function(i) { return '#aaa'; };
              objLayout['vLineColor'] = function(i) { return '#aaa'; };
              objLayout['paddingLeft'] = function(i) { return 4; };
              objLayout['paddingRight'] = function(i) { return 4; };
              doc.content[1].layout = objLayout;

              var logo =  'data:image/jpeg;base64,'+implogo;
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
                text: 'Daftar Saldo Awal'
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
                  alignment: 'right',
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
                  rows: 5,
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
        scrollY: 600,
        scroller: {
          loadingIndicator: true
        },
        "columnDefs": [
          {
              "targets": [ 0,-1 ],
              "orderable": false
          },
            {
                targets: [ 2 ],
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
    }

    function reload_table(){
        table.ajax.reload(null,false);
    }

    function hapusjurnal(id){
        if(confirm('Jurnal akan dihapus?')){
            $.ajax({
                url : "<?php echo base_url(); ?>markas/core1/hapus_area2/"+id,
                type: "POST",
                dataType: "JSON",
                success: function(data){
                reload_table();
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Gagal hapus data');
                }
            });
        }
    }

//---------------------------- start --- info
    function fillinfo(){
        var id = "<?php echo $akses;?>";
        $.ajax({
            url : "<?php echo site_url('markas/core1/info');?>/" + id + "Daktrx_jum",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var jumjur1 = new Intl.NumberFormat().format(data.aktrx_jum);
                $('[name="up_dbt"]').val(jumjur1);
            }
        });
        $.ajax({
            url : "<?php echo site_url('markas/core1/info');?>/" + id + "Kaktrx_jum",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var jumjur2 = new Intl.NumberFormat().format(data.aktrx_jum);
                $('[name="up_krd"]').val(jumjur2);
            }
        });
        $.ajax({
            url : "<?php echo site_url('markas/core1/info');?>/" + id + "xaktrx_jum",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var jumjur3 = data.aktrx_jum;
                $('[name="up_jml"]').val(jumjur3);
            }
        });
    }

//---------------------------- end ----- info

    setInterval( function () {
        table.ajax.reload();
        tbinfo.ajax.reload();
    }, 30000 );

</script>
