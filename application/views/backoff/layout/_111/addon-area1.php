<script>
$(document).ajaxStop($.unblockUI);
    $(document).ready(function (){
        fillgrid();

        $('#fj_tgl1').change(function(){
          fillgrid();
        });

        $('#fj_tgl2').change(function(){
          fillgrid();
        });

        $('#dbag').change(function(){
          fillgrid();
        });

        $('#djam').change(function(){
          fillgrid();
        });

    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        format: "dd-mm-yyyy",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

    $("#upabsen").submit(function (e){
    //    e.preventDefault();
    //    $.blockUI();
        $.ajax({
            url:url,
            type:'POST',
            data:data
        }).done(function (data){
            reload_table();
        });
    });


    $("#upabsenx").click(function (e){
      var vartg = toDate($('#fj_tcek').val());
      var tgcek = vartg.toISOString().split('T')[0];
      e.preventDefault();

      swal({
          title: "Perbaharui Data Presensi?",
          text: "............................!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, lajutkan!",
          closeOnConfirm: true
      }, function (isConfirm) {
          if (!isConfirm) return;
          $.blockUI();
          $.ajax({
              url: "<?php echo base_url(); ?>markas/core1/upabsen/" + tgcek,
              type: "POST",
              success: function (data) {
                swal({
                  title: "Sukses!",
                  text: "Data Diperbaharui",
    //              imageUrl: "http://localhost/dapur0/images/antonpng.png"
                });
              },
              error: function (xhr, ajaxOptions, thrownError) {
                swal("Gangguan!", "Pembaharuan Gagal!", "error");
              }
          });
      });

    //        reload_table();
    });


});




function toDate(dateStr) {
    var parts = dateStr.split("-");
    return new Date(parts[2], parts[1] - 1, parts[0]);
}


    function fillgrid(){
      $.blockUI();
      var f1 = toDate($('#fj_tgl1').val());
      var f2 = toDate($('#fj_tgl2').val());
      var v1 = $('#dbag').val();
      var v2 = $('#djam').val();
      var td1 = f1.toISOString().split('T')[0];
      var td2 = f2.toISOString().split('T')[0];
      var url = "<?php echo base_url(); ?>markas/core1/fillabsen/"+td1+td2+v1;

        table = $('#tfillgrid').DataTable({
            "lengthMenu": [[24, 48, 72, -1], [24, 48, 72, "All"]],
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
            "destroy": true,
            "processing": true,
            "serverSide": true,
            "order": [],
            "dom": 'Bfrtip',
            "ajax": {
            "url": url,
            "type": "POST"
            },
            "buttons": [
                "pageLength",
                {
                    "extend": 'colvis',
                    "text": 'Kolom',
                    "collectionLayout": 'two-column'
                },
            {
                "extend": 'print',
                "message": 'Daftar Dinas Karyawan',
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
                "title": 'Daftar Dinas Karyawan',
                "text": 'PDF',
                "pageSize": 'A4',
                "exportOptions": {
                    columns: [ 0, 1, 2, 3, 4, 5]
                },
                "customize": function ( doc ) {
                    doc.content[1].table.widths = ['15%','20%','20%','20%','20%','20%'];
                }
            }
            ],
            "columnDefs": [
                {
                    "targets": [ -1 ],
                    "orderable": false
                }
            ]
        });
        reload_table()
    }

    function reload_table(){
        table.ajax.reload(null,false);
    }

/*
    setInterval( function () {
        table.ajax.reload();
        tbinfo.ajax.reload();
    }, 120000 );
*/
    $.listen('parsley:field:validate', function() {
      validateFront();
    });

</script>
