<script>
$(document).ajaxStop($.unblockUI);
  $(document).ready(function (){
    catat('Buka modul Isi Detail Transaksi');
    $('.close').click(function(){
      reload_table();
    });
    form_cok();
    fillgrid();

    //------sementara---------------
/*
    var ka3 = $('#ft_nmr1').val();
    var kj = 'K';
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>markas/core1/get_nmr2/'+ka3+kj,
            success: function(data) {
                var data1 = JSON.parse(data);
                $("#ft_nmr2 > option").remove();
                $("#ft_nmr2").empty().append('<option value="000.00.000"></option>').val('--Pilih--').trigger('change');
                $.each(data1,function(id,data1) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(data1.replace('_',' '));
                    $('#ft_nmr2').append(opt);
                });
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

        var jns = decode_cookie(getCookie('trx_jns'));
        var kj = $('#ft_jns').val();
        $('#ft_nmr2').val('');
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'markas/core1/get_nmr1/';?>"+jns+kj,
            success: function(gka3) {
                var gka = JSON.parse(gka3);
                $("#ft_nmr1 > option").remove();
                $.each(gka,function(id,gka) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(gka.replace('_',' '));
                    $('#ft_nmr1').append(opt);
                });
            }
        });
*/
    //------sementara---------------
});

/*

$('#ft_nmr1').change(function(){
    $("#ft_nmr2").empty().append('<option value="000.00.000"></option>').val('--Pilih--').trigger('change');
    var ka3 = $('#ft_nmr1').val();
    var kj = $('#ft_jns').val();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>markas/core1/get_nmr2/'+ka3+kj,
        success: function(data) {
            var data1 = JSON.parse(data);
            $.each(data1,function(id,data1) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(data1);
                $('#ft_nmr2').append(opt);
            });
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            new PNotify({
                title: 'Kesalahan Sistim',
                type: 'danger',
                text: 'Gagal menyusun data #ft_nmr2_2',
                styling: 'bootstrap3'
            });
        catat("Gagal menyusun data #ft_nmr2_2");
        }
    });
});

$('#ft_nmr1').change(function(){

    $("#fte_nmr2").empty().append('<option value="000.00.000"></option>').val('--Pilih--').trigger('change');
    var ka3 = $('#ft_nmr1').val();
    var kj = $('#fte_jns').val();
    $.ajax({
        type: "POST",
        url: '<?php echo base_url();?>markas/core1/get_nmr2/'+ka3+kj,
        success: function(data) {
            var data1 = JSON.parse(data);
            $.each(data1,function(id,data1) {
                var opt = $('<option />');
                opt.val(id);
                opt.text(data1);
                $('#fte_nmr2').append(opt);
            });
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            new PNotify({
                title: 'Kesalahan Sistim',
                type: 'danger',
                text: 'Gagal menyusun data',
                styling: 'bootstrap3'
            });
        }
    });
});
*/

$("#transaksi").submit(function (e){
  e.preventDefault();
  var url = $(this).attr('action');
  var data = $(this).serialize();
  var detcat1 = $('#ft_ket').val();
  var detcat2 = $('#ft_jum').val();
  $.ajax({
      url:url,
      type:'POST',
      data:data
  }).done(function (data){
      $('#ft_nmr2').val('');
      $('#ft_nama').val('');
      $('#ft_ket').val('');
      $('#ft_jum').val('');
  catat("Isi data " + detcat1 + " " + detcat2);
  });
    fillgrid();
});

$('#ft_jns').select2({
    minimumResultsForSearch: -1,
	placeholder: "D/K",
  data: [
    {id:"D",text:"DEBET"},{id:"K",text:"KREDIT"}
  ],
  }).on('select2:select', function(e) {
    var kj = $('#ft_jns').val();
    var jns = setCookie('jnsjur',kj);
    $('#ft_nmr1').val('').trigger('change');
    $('#ft_nmr2').val('').trigger('change');
  });

  $('#ft_nmr1').select2({
    tags: true,
    multiple: false,
    tokenSeparators: [',', ' '],
    minimumInputLength: -1,
    minimumResultsForSearch: 10,
  placeholder: "Kelompok Perkiraan/Akun",
    ajax: {
      url: '<?php echo base_url(); ?>markas/core1/list_kel',
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
    var kj = $('#ft_nmr1').val();
    var jns = setCookie('jnsperk',kj);
    $('#ft_nmr2').val('').trigger('change');
  });

  $('#ft_nmr2').select2({
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
          param1:1,
          param2:decode_cookie(getCookie('jnsperk'))
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


function form_cok(){
  var cnojur = decode_cookie(getCookie('jur_nmr'));
  var ctgjur = decode_cookie(getCookie('jur_tgl'));
  $('#ft_nojur').val(cnojur);
  $('#ft_jurtg').val(convertDate(ctgjur));
  $('#ft_jns').val(decode_cookie(getCookie('jnsjur'))).trigger('change');


}

function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax
}

function hapustransaksi(id){
  swal({
    title: "Koreksi Transaksi!",
    showCancelButton: true,
    closeOnConfirm: false,
    animation: "pop"
  },
  function(inputValue){
    setTimeout(function(){
      $.ajax({
          url : "<?php echo base_url(); ?>markas/core1/koreksi3/"+ id,
          type: "POST",
          dataType: "JSON",
          success: function(data){
            swal({
              title:"Sukses!",
              type:"success",
              timer: 2000,
              showConfirmButton: false
            });
            fillgrid();
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            swal({
              title:"Gagal!",
              text:"Proses Koreksi " + id  + " gagal. Mohon coba lagi!",
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
  catat("COR " + id);
}

function cekback(){
  $.blockUI();
  $('.right_col').addClass('slideOutLeft animated');
}

function convertDate(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat);
  return [pad(d.getDate()), pad(d.getMonth()+1), d.getFullYear()].join('-');
}

        function fillgrid(){
        var njur = decode_cookie(getCookie('jur_nmr'));
        var url = "<?php echo base_url(); ?>markas/core1/fillgrid/area3"+njur;
        if ( $.fn.dataTable.isDataTable( '#tfillgrid' ) ) {
            table = $('#tfillgrid').DataTable();
            location.reload();
        }
        else {
//        $.blockUI();
          table = $('#tfillgrid').DataTable({
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(), data;
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[^\d\-\.\/a-zA-Z]/g,'') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };
                total3 = api
                    .column(3)
                    .data()
                    .reduce(function(c, d) {
                        var c = intVal(c) + intVal(d);
                        var c = c.toFixed(2);
                        return c;
                    }, 0);
                total4 = api
                    .column(4)
                    .data()
                    .reduce(function(c, d) {
                        var c = intVal(c) + intVal(d);
                        var c = c.toFixed(2);
                        return c;
                    }, 0);
                $(api.column(0).footer()).html('');
                $(api.column(1).footer()).html('');
                $(api.column(2).footer()).html('TOTAL');
                if(total3 != total4){
                  $(api.column(3).footer()).css('background-color','red');
                  $(api.column(4).footer()).css('background-color','red');
                  $(api.column(3).footer()).css('color','#fff');
                  $(api.column(4).footer()).css('color','#fff');
                }
                $(api.column(3).footer()).css('text-align','right');
                $(api.column(3).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total3));
                $(api.column(4).footer()).css('text-align','right');
                $(api.column(4).footer()).html($.fn.dataTable.render.number('.', ',', 0, '').display(+total4));
                $(api.column(5).footer()).html('');
            },
              "lengthMenu": [[24, 48, 72, -1], [24, 48, 72, "All"]],
              "destroy": true,
              "paging": true,
              "language":{
              "decimal":        ".",
              "emptyTable":     "Belum ada data",
              "info":           "Data ke _START_ s/d _END_ dari _TOTAL_ data",
              "infoEmpty":      "Data ke 0 s/d 0 dari 0 data",
              "infoFiltered":   "(Disaring dari _MAX_ data)",
              "infoPostFix":    "",
              "thousands":      ",",
              "lengthMenu":     "Tampilkan _MENU_ data",
              "loadingRecords": "Memuat...",
                  "processing":     "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>",
              "search":         "Cari:",
              "zeroRecords":    "Tidak ada data yang cocok"
            },
              "processing": true, //Feature control the processing indicator.
              "serverSide": true, //Feature control DataTables' server-side processing mode.
              "order": [], //Initial no order.

              "dom": '<"top">rt<"bottom"i><"clear">',
              "buttons": [
              {
                  "extend": 'print',
                  "message": 'Daftar Transaksi'
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
                  "extend": 'pdf',
                  "message": 'Daftar Transaksi',
                  "exportOptions": {
                      columns: ':visible'
                  }
              },
                  "colvis"
          ],

              // Load data for the table's content from an Ajax source
              "ajax":{
              "url": url,
              "type": "POST",
              error: function (jqXHR, textStatus, errorThrown)
              {
                  new PNotify({
                      title: 'Kesalahan Sistim',
                      type: 'danger',
                      text: 'Gagal menyusun data',
                      styling: 'bootstrap3'
                  });
              }
            },

              //Set column definition initialisation properties.
              "columnDefs": [
                {
                  targets: [ 0,1,2,3,4,5 ],
                  orderable: false
                  },
                      {
                          targets: [ 3,4 ],
                          render: $.fn.dataTable.render.number( '.', ',', 0),

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
        reload_table();
      }

/*
$.fn.dataTable.Api.register( 'column().data().sum()', function () {
    return this.reduce( function (a, b) {
        var x = parseFloat( a ) || 0;
        var y = parseFloat( b ) || 0;
        return x + y;
    } );
} );


setInterval( function () {
    table.ajax.reload();
}, 40000 );
*/

</script>
