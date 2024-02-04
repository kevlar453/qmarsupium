<script>
$(document).ready(function (){
    //datepicker
    $('.datepicker').datepicker({
        autoclose: true,
        minDate: '0',
        format: "dd-mm-yyyy",
        changeMonth: true,
        changeYear: true,
        todayHighlight: true,
        orientation: "top auto",
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down"
        },
        onSelect: function(selectedDate) {
                 alert( picker.val() );
             }
    });

    $("#cekpoli").submit(function (e){
        e.preventDefault();
        var c1 = $('#fl_jenis').val();
        var c2 = toDate($('#fl_tgl1').val());
        var c3 = toDate($('#fl_tgl2').val());
    filltrans(c1,c2,c3);
    });

});

function toDate(dateStr) {
    var parts = dateStr.split("-");
    return new Date(parts[2], parts[1] - 1, parts[0]);
}
    function filltrans(f1,f2,f3){
//      alert(f1+'/'+f2+'/'+f3);
        var kode = f1;
        var t1 = $('#fl_tgl1').val();
        var t2 = $('#fl_tgl2').val();
        var td1 = f2.toISOString().split('T')[0];
        var td2 = f3.toISOString().split('T')[0];
        var ktx = $('#fl_jenis  option:selected').text();
        var url = "<?php echo base_url(); ?>markas/core1/filltrans/"+kode+td1+td2;
//        alert(kode+'/'+td1+'/'+td2);
        table = $('#dktabel').DataTable({
            "lengthMenu": [[24, 48, 72, -1], [24, 48, 72, "All"]],
            "paging": true,
            "destroy": true,
            "responsive": true,
            "language":
            {
                "emptyTable":     "Belum ada data",
                "info":           "Total _TOTAL_ data",
                "infoEmpty":      "Data ke 0 s/d 0 dari 0 data",
                "infoFiltered":   "(Disaring dari _MAX_ data)",
                "infoPostFix":    "",
                "lengthMenu":     "Tampilkan _MENU_ data",
                "loadingRecords": "<span class='glyphicon glyphicon-eye-open' aria-hidden='true'></span>",
                "processing":     "<span class='glyphicon glyphicon-refresh' aria-hidden='true'></span>",
                "search":         "Cari:",
                "zeroRecords":    "Tidak ada data yang cocok "+url,
                "paginate":
                {
                    "first":      "Awal",
                    "last":       "Akhir",
                    "next":       ">",
                    "previous":   "<"
                },
                "aria":
                {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            "processing": true,
            "serverSide": true,
            "order": [],
            "dom": '<"top"Bi>rt<"bottom"lp><"clear">',
            "buttons": [
                "pageLength",
                {
                    "extend": 'colvis',
                        "text": 'Kolom',
                        "collectionLayout": 'two-column'
                },
            {
                "extend": 'print',
                "message": 'Data Jasa Layanan Dokter',
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
                "title": 'Data Jasa Layanan Dokter ' + t1 + ' s/d ' + t2,
//                "title": 'Buku Besar ',
                "text": 'PDF',
                "pageSize": 'A4',
                "footer": true,
                "exportOptions": {
                    columns: [ 0, 1, 2, 3, 4, 5],
                    stripNewlines: false,
                    //                    text: 'noBorders:', fontSize: 9, bold: true, pageBreak: 'before', margin: [0, 0, 0, 8]
                },
                "customize": function ( doc ) {
                    var cols = [];
                    cols[0] = {text: 'HIS 2017', fontSize: 6, alignment: 'left', margin:[20] };
                    cols[1] = {text: 'RSK St. Antonius Ampenan', fontSize: 6, alignment: 'right', margin:[0,0,20] };
                    var objFooter = {};
                    objFooter['columns'] = cols;
                    doc['footer']=objFooter;

                    doc.defaultStyle.fontSize = 8;
                    doc.styles.tableHeader.fontSize = 8;
                    doc.styles.tableFooter.fontSize = 8;
                    doc.content[1].table.widths = ['3%','10%','12%','30%','15%','15%'];
                    doc.content.splice( 1, 0, {
                        margin: [ 0, 0, 0, 12 ],
                        fontSize: 14,
                        bold: true,
                        alignment: 'center',
                        text: '-- '+ktx+' --'
                    } );
/*                    doc['defaultStyle']={
                            bold:!0,
                            fontSize:8,
                            color:'navy',
                            fillColor:'#E0E8BA',
                            alignment:'left'
                    };
                    doc['styles']={
                        margin: [ 0, 0, 0, 12 ]
                        ,
                        tableHeader: {
                            bold:!0,
                            fontSize:9,
                            color:'black',
                            fillColor:'#F0F8FF',
                            alignment:'center'
                        }
                    }; */
                }

            }
        ],
            "ajax": {
                "url": url,
                "type": "POST"
            },
            "columnDefs": [
                {
                    "targets": [ 5 ],
                    "render": $.fn.dataTable.render.number( '.', ',', 2),
                    "createdCell": function (td, cellData, rowData, row, col)
                    {
                        $(td).css('text-align', 'right');
                        if ( cellData < 0 ) {
                            $(td).css('color', 'red');
                        }
                    }
                }
            ],
            "footerCallback": function(row, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[^\d\-\.\/a-zA-Z]/g,'') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        var a = intVal(a) + intVal(b);
                        var a = a.toFixed(2);
                        return a;
                    }, 0);

                // Update footer
                $(api.column(5).footer()).html(+total);
            }
        });
//        table.destroy();
    }

$.fn.dataTable.Api.register( 'column().data().sum()', function () {
    return this.reduce( function (a, b) {
        var x = parseFloat( a ) || 0;
        var y = parseFloat( b ) || 0;
        return x + y;
    } );
} );
/*

setInterval( function () {
    table.ajax.reload();
}, 30000 );
*/

    function reload_table(){
        table.ajax.reload(null,false); //reload datatable ajax
    }

</script>
