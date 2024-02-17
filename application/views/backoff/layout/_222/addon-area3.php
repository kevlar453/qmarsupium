<script>
$(document).ajaxStop($.unblockUI);
  $(document).ready(function (){
    catat('Buka modul Isi Detail Transaksi');
/*
    $('.close').click(function(){
      reload_table();
    });
*/
    form_cok();
    fillgrid();
    setTimeout(function(){
      if(varopta == '00'){
        $('.opta2').text('Valid');
        $('.panatas').addClass('fadeOut animated delay-1s');
        setTimeout(function(){
          $('.panatas').addClass('hide');
        },500);
      } else {
        $('.opta2').text('Post');
        $('.panatas').removeClass('hide');
      }
        $("#myNav").css('height','0%');
        $('.sidebar').css('opacity',1);
    },1000);

});

function gotransaksi(){
//  e.preventDefault();
  var url = $("#transaksi").attr('action');
  var dataser = $("#transaksi").serialize();
  var detcat1 = $('#ft_ket').val();
  var detcat2 = $('#ft_jum').val();
  if(parseInt(detcat2.replace(',',''))>0){
    $.ajax({
        url:url,
        type:'POST',
        data:dataser,
        success: function(data){
          $('#ft_nmr1').val('').trigger('change');
          $('#ft_nmr2').val('').trigger('change');
          $('#ft_nama').val('');
          $('#ft_ket').val('');
          $('#ft_jum').val('');
        },
    }).done(function (data){
      table.ajax.reload();
//            tbinfo.ajax.reload();
    });
  } else {
    console.log('Cek nilai: '+parseInt(detcat2.replace(',','')));
  }
};

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
  Swal.fire({
    title: "Koreksi Transaksi!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, koreksi!"
  }).then((result) => {
    if (result.isConfirmed) {
      $.blockUI();
      setTimeout(function(){
        $.ajax({
            url : "<?php echo base_url(); ?>markas/core1/koreksi3/"+ id,
            type: "POST",
            dataType: "JSON",
            success: function(data){
              swal.fire({
                title:"Sukses!",
                icon:"success",
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
              });
              setTimeout(function(){
                $.unblockUI();
                fillgrid();
              },2000);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              swal.fire({
                title:"Gagal!",
                text:"Proses Koreksi " + id  + " gagal. Mohon coba lagi!",
                icon:"warning",
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false
              });
            }
        })
      }, 3000);
    }
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
//            table = $('#tfillgrid').DataTable();
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
//              "destroy": true,
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

              "dom": '<"top">rt<"bottom"><"clear">',
              "buttons": [],

              // Load data for the table's content from an Ajax source
              "ajax":{
              "url": url,
              "type": "POST"
              },
              scrollY: 400,
              scroller: {
                  loadingIndicator: true
              },
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
          $('.dt-button').addClass('btn btn-icon btn-success heartbeat animated delay-1s');
          $('.btn').removeClass('dt-button');
          reload_table();
        }
//        reload_table();
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
$.listen('parsley:field:validate', function() {
  validateFront();
});
$('#transaksi #submitTrx').on('click', function() {
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
