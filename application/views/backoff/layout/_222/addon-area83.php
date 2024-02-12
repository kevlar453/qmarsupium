<script>
  $(document).ajaxStop($.unblockUI);
  $(document).ready(function (){
    catat('Buka modul Rincian Billing HIS');
    setCookie('seto','83');
        fillgrid('0');
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

  $('.umum').click(function(e){
    var pumum = new Particles('.umum');
      table.destroy();
    pumum.disintegrate({
      duration: 1000,
      type: 'triangle',
      complete: function(){
        fillgrid('0');
        pumum.integrate({
          duration: 2000
        });
      }
    });
  });

  $('.bpjs').click(function(e){
    var pbpjs = new Particles('.bpjs');
      table.destroy();
    pbpjs.disintegrate({
      duration: 1000,
      type: 'circle',
      complete: function(){
        fillgrid('1');
        pbpjs.integrate({
          duration: 2000
        });
      }
    });
  });

  $('.repair').click(function(e){
    var repair = new Particles('.repair');
      table.destroy();
    repair.disintegrate({
      duration: 1000,
      type: 'circle',
      complete: function(){
        repdatbil();
        repair.integrate({
          duration: 2000
        });
      }
    });
  });

  function repdatbil(){
    var f1 = toDate($('#fl_tgl1').val());
    var f2 = toDate($('#fl_tgl2').val());
    var t1 = $('#fl_tgl1').val();
    var t2 = $('#fl_tgl2').val();
    var td1 = f1.toISOString().split('T')[0];
    var td2 = f2.toISOString().split('T')[0];
    $.blockUI();
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>markas/core1/cpostri/' + td1 + td2 + 'umum',
        success: function(data) {
          location.reload();
        }
    });
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>markas/core1/cpostri/' + td1 + td2 + 'bpjs',
        success: function(data) {
          location.reload();
        }
    });

  }

  function toDate(dateStr) {
      var parts = dateStr.split("-");
      return new Date(parts[2], parts[1] - 1, parts[0]);
  }
  //---------------------------------#
  function fillgrid(katper){
    var f1 = toDate($('#fl_tgl1').val());
    var f2 = toDate($('#fl_tgl2').val());
    var t1 = $('#fl_tgl1').val();
    var t2 = $('#fl_tgl2').val();
    var td1 = f1.toISOString().split('T')[0];
    var td2 = f2.toISOString().split('T')[0];
    var url = '<?php echo base_url(); ?>markas/core1/fillbillpost/'+td1+td2+katper;
    var tglctk = new Date();
    var jsDate = tglctk.getDate()+'-'+(tglctk.getMonth()+1)+'-'+tglctk.getFullYear();
    var jsDate2 = tglctk.getDate()+(tglctk.getMonth()+1)+tglctk.getFullYear();

    $.blockUI();
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
        .column(8)
        .data()
        .reduce(function(t51, t52) {
          var t51 = intVal(t51) + intVal(t52);
          var t51 = t51.toFixed(2);
          return t51;
        }, 0);

        $(api.column(0).footer()).css('text-align','left');
        $(api.column(0).footer()).html('GRAND TOTAL');
        $(api.column(1).footer()).css('text-align','right');
        $(api.column(1).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(Math.ceil(+total5)));
        $(api.column(2).footer()).html('');
        $(api.column(3).footer()).html('');
        $(api.column(4).footer()).html('');
        $(api.column(5).footer()).html('');
        $(api.column(6).footer()).html('');
        $(api.column(7).footer()).html('');
        $(api.column(8).footer()).html('');
        $(api.column(9).footer()).html('');
        $(api.column(10).footer()).html('');
        $(api.column(11).footer()).html('');
        $(api.column(12).footer()).html('');
//        $('#prosjpxri').text($.fn.dataTable.render.number('.', ',', 0, 'Rp. ').display(Math.ceil(total5/100)*100));
      },
      "ajax": {
        "url": url,
        "type": "POST"
      },
      "scrollX": true,
      "scrollY": 600,
      "scroller": {
        loadingIndicator: true,
      },
      "lengthMenu": [[50,100, 200, -1], [50,100, 200, "All"]],
      "paging": true,
//      "destroy": true,
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
        "aria": {
          "sortAscending":  ": activate to sort column ascending",
          "sortDescending": ": activate to sort column descending"
        }
      },
      "processing": false,
      "serverSide": true,
      "order": [],
      "dom": '<"top"Blf>rt<"bottom"lip><"clear">',
      "buttons": [
      {
        extend: 'excel',
        messageBottom: 'QHMS-2017@RSK St. Antonius Ampenan',
        footer: true,
        title: 'Rekap_Rincian_Pasien_' + td1 + '_' + td2,
        text: '<i class="fa fa-file-excel-o"></i>',
        titleAttr: 'Export: EXCEL',
        filename: 'Rekap_Rincian_Pasien_' + td1 + '_' + td2,
        sheetName: td1 + '_' + td2,
        exportOptions: {
          columns: [5,0,1,2,3,4,6,10,11,12,7,8,9],
          orthogonal: 'export'
        }
      }
      ],
      "columnDefs": [
      {
        targets: [ 0,1,2,3,4,5,6,7,8,9 ],
        "orderable": false
      },
      {
        targets: [ 8,9 ],
        "render": $.fn.dataTable.render.number( '.', ',', 0),

        createdCell: function (td, cellData, rowData, row, col)
        {
          $(td).css('text-align', 'right');
          if ( cellData < 0 ) {
            $(td).css('color', 'red');
          }
        }
      }
      ]
    });
  }

  function reload_table(){
      table.ajax.reload(null,false);
  }
</script>
