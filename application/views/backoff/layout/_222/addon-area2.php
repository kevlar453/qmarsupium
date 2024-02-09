<script>
    $(document).ready(function (){
      catat('Buka modul Isi Transaksi');
        fillgrid();
        fillinfo();
        plus_excel();
    });

    $('#info_tgl').change(function(){
      fillinfo();
    });

    $("#transaksi").submit(function (e){
      var optisi = $('#fj_ket').val();
        e.preventDefault();
        var url = $(this).attr('action');
        var data = $(this).serialize();
        var detcat1 = $('#fj_nomor').val();
        var detcat2 = $('#fj_ket').val();
        if(optisi != ''){
          $.ajax({
              url:url,
              type:'POST',
              data:data
          }).done(function (data){
            table.ajax.reload();
//            tbinfo.ajax.reload();
          });
        } else {
          swal("Awas!", 'Data harus dilengkapi' , "error");
        }
        catat("Isi data " + detcat1 + " " + detcat2);
    });

    $("#kirimexcel").click(function (){
      $('#upexcelprog').removeClass('hidden');
      $('#isiexcel').addClass('hidden');
    });


      $('#tfillgrid').on('click', 'tbody tr', function() {
        var data = table.row(this).data();
        var ctrx = data[1];
        var ccor = data[4];
        var cpost = data[5];

        $.ajax({
         type: "post",
         url: "<?php echo base_url(); ?>markas/core1/caritrxdet/"+ctrx,
//         data: {id:id},
         cache: false,
         async: false,
         success: function(data){
           if(data){
             var isidet = JSON.parse(data);
             var jumdata = isidet.length-1;
             var jumdet = 0;
             var dettbl = '';
             var dettblcol = '';
             var jdlmod = '';
             var addt = '';
             var nilai = 0;
             for (var i = 0; i <= jumdata; i++) {
               nilai = parseFloat(isidet[i].aktrx_jum);
               jdlmod = isidet[i].aktrx_nomor;
               dettbl += '<tr>';
                 dettbl += '<td>'+isidet[i].aktrx_nomor+'</td>';
                 dettbl += '<td style="text-align:left;">'+isidet[i].aktrx_nama+'</td>';
                 dettbl += '<td>'+(isidet[i].aktrx_jns=='D'?Intl.NumberFormat().format(nilai.toFixed(2)):0)+'</td>';
                 dettbl += '<td>'+(isidet[i].aktrx_jns=='K'?Intl.NumberFormat().format(nilai.toFixed(2)):0)+'</td>';
               dettbl += '</tr>';
             }
             if(ccor != 'X'){
               addt = "<a class=\"btn btn-lg btn-warning\" href=\"javascript:void(0)\" title=\"Koreksi\" onclick=\"hapusjurnal('"+ctrx+"')\">Koreksi</a><a class=\"btn btn-lg btn-info\" onclick=\"godetail('"+ctrx+"')\">Detail</a><a class=\"btn btn-lg btn-success\" onclick=\"gopost('"+ctrx+"')\">Posting</a>";
             }
             swal({
               title: "Transaksi " + ctrx,
//               text: isidet[0][1],
               text: "<div class=\"table-responsive\"><table id=\"filltambah\" class=\"table table-condensed table-striped table-hover dt-responsive\" style=\"font-size:1em;margin:5px;width:100%;\"><thead><tr><th>Kode</th><th>Uraian</th><th>Debet</th><th>Kredit</th></tr></thead><tbody>"+dettbl+"</tbody></table></div><hr/>" + (cpost=='X'?addt:'Sudah Posting'),
               html: true,
               allowOutsideClick:true,
               showCancelButton: false,
               confirmButtonColor: "#DD6B55",
               confirmButtonText: "Tutup",
               closeOnConfirm: false
             });
         }
             }
         });
      });

      $('#fj_tgl').change(function(){
        $('#fj_nomor').val('');
        $('#ft_jnsjur').val('X').trigger('change');
      });

      $('#fj_jenis').change(function(){
          $('#fj_nomor').val('');
      });

      $('#ft_jnsjur').change(function(){

        function pad(s) { return (s < 10) ? '0' + s : s; }
        var d = $('#fj_tgl').val().split("-");
        var valjns = $('#fj_jenis  option:selected').text();
        var valjnsjur = $('#ft_jnsjur  option:selected').val();
        var arrjns = valjns.split(' ');
        var semnomor = '';

        if(arrjns[0].replace('[','').replace(']','').length == 2){
          semnomor = arrjns[0].replace('[','').replace(']','')+valjnsjur+'.'+d[1];
        } else if(arrjns[0].replace('[','').replace(']','').length == 3) {
          semnomor = arrjns[0].replace('[','').replace(']','')+'.'+d[1];
        }

        if(valjnsjur == 'X')
        $('#fj_nomor').val('');

        $.ajax({
         type: "post",
         url: "<?php echo base_url(); ?>markas/core1/cek_nojur",
         cache: false,
         async: false,
         data: jQuery.param({
           cnojur: semnomor+'.'+d[2].substr(0,4)
         }),
         success: function(data){
           if(valjnsjur != 'X')
           $('#fj_nomor').val(semnomor+'.'+data);
         }
         });



      });

      function godetail(keycari) {
        $.blockUI();
         var id = keycari;
         if(id){
           setCookie('idjur',id);
           $.ajax({
             type: "post",
             url: '<?php echo base_url()."markas/core1/trxharian";?>',
             data: jQuery.param({
               nmjur:id
             }),
             success: function(data){
               $('.right_col').addClass('fadeOutLeft animated');
               setTimeout(function(){
                 location.assign("<?php echo base_url().'/markas/core1/?rmod=area3'?>")
               },1000);
             }
           });
         }

      }

      function toDate(dateStr) {
        if (typeof dateStr != "string" && dateStr && esNumero(tglahir.getTime())) {
            dateStr = formatDate(dateStr, "dd-MM-yyyy");
        }
        var values = dateStr.split("-");
        var dia = values[2];
        var mes = values[1];
        var ano = values[0];
          return dia + '-' + mes + '-' + ano;
      }

      function convertDate(inputFormat) {
        function pad(s) { return (s < 10) ? '0' + s : s; }
        var d = new Date(inputFormat);
        return [d.getFullYear(), pad(d.getMonth()+1), pad(d.getDate())].join('-');
      }


    function prosescari(keycari) {
       var id = keycari;
       if(id){
         $.ajax({
          type: "post",
          url: "<?php echo base_url(); ?>markas/core1/warn_nojur/"+id,
          data: {id:id},
          cache: false,
          async: false,
          success: function(data){
            if(data){
              var awas = 'Nomor Jurnal ' + id + ' sudah terpakai, dengan uraian: ' +data;
              swal("Awas!", awas , "error");
              $('#fj_nomor').val('');
          }
              }
          });
       }

    }

    function prosescarix(keycari) {
        if (!keycari) return;
        $.ajax({
            url: "<?php echo base_url(); ?>markas/core1/warn_nojur/"+ keycari,
            type: "POST",
            success: function (data) {
              if(data){
                swal("Perhatian!", "Nomor Jurnal sudah terpakai", "error");
                $('#ft_nomor').val('');
              }
            }
        });
    }

    function fillgrid(){
        table = $('#tfillgrid').DataTable({
          "createdRow": function(row, data, dataIndex){
            if( data[4] ==  'X'){
              $(row).css('font-style','italic');
              $(row).css('font-weight','bold');
              $(row).css('background-color','#f2a1a1');
              $(row).css('color','#767676');
            }
          },

            "lengthMenu": [[24, 48, 72, -1], [24, 48, 72, "All"]],
            "language":{
                "decimal":        ",",
                "thousands":      ".",
                "emptyTable":     "Belum ada data",
                "info":           "Data ke _START_ s/d _END_ dari _TOTAL_ data",
                "infoEmpty":      "Data ke 0 s/d 0 dari 0 data",
                "infoFiltered":   "(Disaring dari _MAX_ data)",
                "infoPostFix":    "",
                "lengthMenu":     "Tampilkan _MENU_ data",
                "loadingRecords": "Memuat...",
                "processing":     "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>",
                "search":         "Cari:",
                "zeroRecords":    "Tidak ada data yang cocok"
              },
            "processing": true,
            "serverSide": true,
            "order": [],
            "dom": '<"top">frt<"bottom"i><"clear">',
            "buttons": [
            {
                  "extend": 'print',
                  "message": 'Daftar Transaksi',
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
                "title": 'Daftar Transaksi',
                "text": '<i class="fa fa-file-excel-o"></i>',
                "titleAttr": 'Export: EXCEL',
              },
              {
                  "extend": 'copy',
                  "message": 'Disalin dari Q-MARSUPIUM 2024',
                  "text": '<i class="fa fa-clone"></i>',
                  "titleAttr": 'Export: SALIN'
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
            scrollY: 300,
            scroller: {
                loadingIndicator: true
            },
            "columnDefs": [
                {
                    "targets": [ -1 ],
                    "orderable": false
                }
            ]
        });
        $('.dt-button').addClass('btn btn-icon btn-success heartbeat animated delay-1s');
        $('.btn').removeClass('dt-button');
        table.ajax.reload();
//        tbinfo.ajax.reload();
    }

    function reload_table(){
        table.ajax.reload(null,false);
    }


    function hapusjurnal(id){
      swal({
          title: "Koreksi Jurnal?",
          text: "Belum ada fitur UNDO untuk proses ini!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, lajutkan!",
          closeOnConfirm: false
      }, function (isConfirm) {
          if (!isConfirm) return;
          $.ajax({
              url: "<?php echo base_url(); ?>markas/core1/koreksi2/",
              type: "POST",
              data:jQuery.param({
                idjur:id
              }),
              success: function (data) {
                swal({
                  title: "Sukses!",
                  text: "Jurnal BERHASIL dikoreksi.",
                  type: "success"
                });
              },
              error: function (xhr, ajaxOptions, thrownError) {
                swal("Gangguan!", "Jurnal GAGAL koreksi gagal!", "error");
              }
          });
          reload_table();
      }
    );
    catat("COR " + id);
  }

  function gopost(id){
    swal({
        title: "Posting Jurnal?",
        text: "Jurnal dan transaksinya sudah benar dan siap lapor.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, lajutkan!",
        closeOnConfirm: false
    }, function (isConfirm) {
        if (!isConfirm) return;
        $.ajax({
            url: "<?php echo base_url(); ?>markas/core1/posting1/",
            type: "POST",
            data:jQuery.param({
              idjur:id
            }),
            success: function (data) {
              swal({
                title: "Sukses!",
                text: "Jurnal BERHASIL diposting.",
                type: "success"
              });
            },
            error: function (xhr, ajaxOptions, thrownError) {
              swal("Gangguan!", "Jurnal GAGAL posting!", "error");
            }
        });
        reload_table();
    }
  );
  catat("POST " + id);
}

//---------------------------- start --- info
    function fillinfo(){
        var ctgl = $('#info_tgl').val();
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

//---------------------------- end ----- info
/*
    setInterval( function () {
        table.ajax.reload();
        tbinfo.ajax.reload();
    }, 300000 );
*/
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

    function plus_excel(){
      $.ajax({
        url: '<?php echo base_url(); ?>markas/core1/list_jur',
        type: "post",
        dataType: 'json',
        success: function(data)
        {
            var isijurn = JSON.parse(JSON.stringify(data));
            var btab = '<ul>';
            for (var i = 0; i <= isijurn.length-1; i++) {
              btab += '<li>['+isijurn[i].akjur_kode+'] '+isijurn[i].akjur_nama+'</li>'
            }
            btab += '</ul>';
            $('#cekisijur').append(btab);
        }
      })

    }


</script>
