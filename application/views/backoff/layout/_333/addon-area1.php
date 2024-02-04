<script>
    $(document).ready(function (){
        fillgrid();
        fillinfo();
        filltrxinfo();
        $('#info_tgl').change(function(){
          fillinfo();
          filltrxinfo();
        });
        $(":input").inputmask();

        //datepicker
        $('.datepicker').datepicker({
            autoclose: true,
            format: "dd-mm-yyyy",
            todayHighlight: true,
            orientation: "top auto",
            todayBtn: true,
            todayHighlight: true,
        });

        $("#transaksi").submit(function (e){
            e.preventDefault();
            var url = $(this).attr('action');
            var data = $(this).serialize();
            $.ajax({
                url:url,
                type:'POST',
                data:data
            }).done(function (data){
                reload_table();
            });
        });
    });

    function fillgrid(){
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
            "processing": true,
            "serverSide": true,
            "order": [],
            "dom": 'Bfrtip',
            "buttons": [
                "pageLength",
                {
                    "extend": 'colvis',
                    "text": 'Kolom',
                    "collectionLayout": 'two-column'
                },
            {
                "extend": 'print',
                "message": 'Daftar Transaksi',
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
                "title": 'Daftar Transaksi',
                "text": 'PDF',
                "pageSize": 'A4',
                "exportOptions": {
                    columns: [ 0, 1, 2, 3]
                },
                "customize": function ( doc ) {
                    doc.content[1].table.widths = ['15%','20%','50%','15%'];
                }
            }
            ],
            "ajax": {
            "url": "<?php echo base_url(); ?>markas/core1/fillgrid/area2",
            "type": "POST"
            },
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

    function hapusjurnal(id){
      swal({
        title: "Koreksi Jurnal " + id + " !",
        text: "NO. Jurnal Koreksi: (HHH123.12.12)",
        type: "input",
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "pop",
        inputPlaceholder: "Nomor Jurnal"
      },
      function(inputValue){
        if (inputValue === false) return false;

        if (inputValue === "") {
          swal.showInputError("Masukkan Nomor Jurnal Koreksi!");
          return false
        }
        setTimeout(function(){
          $.ajax({
              url : "<?php echo base_url(); ?>markas/core1/koreksi2/"+ id + inputValue,
              type: "POST",
              dataType: "JSON",
              success: function(data){
                swal({
                  title:"Sukses!",
                  text:"Jurnal " + id + " dikoresi dgn jurnal " + inputValue,
                  type:"success",
                  timer: 2000,
                  showConfirmButton: false
                });
                reload_table();
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                swal({
                  title:"Gagal!",
                  text:"Proses Koreksi " + id + " dengan " + inputValue + " gagal. Mohon coba lagi!",
                  type:"warning",
                  timer: 1000,
                  showConfirmButton: false
                });
//                swal("Maaf!", "Proses Koreksi " + id + " dengan " + inputValue + " gagal. Mohon coba lagi!", "danger");
              }
          })
        }, 3000);

//        swal("Berhasil!", "NO. Jurnal Koreksi: " + inputValue, "success");
      });
    }

//---------------------------- start --- info
    function fillinfo(){
        var ctgl = $('#info_tgl').val();
//        var idx = toDate(id);
//        var idy = idx.toISOString().split('T')[0];
//        alert(id);
        $.ajax({
            url : "<?php echo site_url('markas/core1/info');?>/" + ctgl + "Daktrx_jum",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var jumjur1 = new Intl.NumberFormat().format(data.aktrx_jum);
                $('[name="up_dbt"]').val(jumjur1);
            }
        });
        $.ajax({
            url : "<?php echo site_url('markas/core1/info');?>/" + ctgl + "Kaktrx_jum",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var jumjur2 = new Intl.NumberFormat().format(data.aktrx_jum);
                $('[name="up_krd"]').val(jumjur2);
            }
        });
        $.ajax({
            url : "<?php echo site_url('markas/core1/info');?>/" + ctgl + "xaktrx_jum",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                var jumjur3 = data.aktrx_jum;
                $('[name="up_jml"]').val(jumjur3);
            }
        });
    }

    function filltrxinfo(){
      var itgl = $('#info_tgl').val();

        tbinfo = $('#isitrxupdate').DataTable({
//            "lengthMenu": [[24, 48, 72, -1], [24, 48, 72, "All"]],
//            "paging": true,
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
                "pageLength",
                {
                    "extend": 'colvis',
                    "text": 'Kolom',
                    "collectionLayout": 'two-column'
                },
            {
                "extend": 'print',
                "message": 'Daftar Transaksi',
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
                "title": 'Daftar Transaksi',
                "text": 'PDF',
                "pageSize": 'A4',
                "exportOptions": {
                    columns: [ 0, 1, 2, 3]
                },
                "customize": function ( doc ) {
                    doc.content[1].table.widths = ['15%','20%','50%','15%'];
                }
            }
            ],
            "ajax": {
            "url": "<?php echo base_url(); ?>markas/core1/fillgrid/area2" + itgl,
            "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [ -1 ],
                    "orderable": false
                }
            ]
        });
        reload_table()
    }

//---------------------------- end ----- info

    setInterval( function () {
        table.ajax.reload();
        tbinfo.ajax.reload();
    }, 30000 );

    $.listen('parsley:field:validate', function() {
      validateFront();
    });
    $('#transaksi #exampleInputPassword2').on('click', function() {
      $('#transaksi').parsley().validate();
      validateFront();
    });
    var validateFront = function() {
      if (true === $('#transaksi').parsley().isValid()) {
        $('.bs-callout-info').removeClass('hidden');
        $('.bs-callout-warning').addClass('hidden');
      } else {
        $('.bs-callout-info').addClass('hidden');
        $('.bs-callout-warning').removeClass('hidden');
      }
    };
    try {
      hljs.initHighlightingOnLoad();
    } catch (err) {}

</script>
