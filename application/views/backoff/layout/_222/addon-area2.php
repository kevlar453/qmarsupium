<script>
    $(document).ready(function (){
      setCookie('seto','2');
      catat('Buka modul Isi Transaksi');
      fillgrid('');
      plus_excel();
      setTimeout(function(){
        if(varopta == '00'){
          $('#tgexp').addClass('hidden');
          $('.opta2').text('Valid');
          $('.panatas').addClass('fadeOut animated delay-1s');
          setTimeout(function(){
            $('.panatas').addClass('hide');
          },500);
        } else {
          $('#tgexp').removeClass('hidden');
          cekreport();
          $('.opta2').text('Post');
          $('.panatas').removeClass('hide');
        }
          $("#myNav").css('height','0%');
          $('.sidebar').css('opacity',1);
      },1000);
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
          swal.fire("Awas!", 'Data harus dilengkapi' , "error");
        }
        catat("Isi data " + detcat1 + " " + detcat2);
    });

    $("#kirimexcel").click(function (){
      $('#upexcelprog').removeClass('hidden');
      $('#isiexcel').addClass('hidden');
    });

    $("#impqbk").submit(function (e){
//        e.preventDefault();
        $('#tutupmodal').click();
        catat("Export data");
        $.blockUI();
    });

      $('#tfillgrid').on('click', 'tbody tr', function() {
        var data = table.row(this).data();
        var ctagl = data[0];
        var ctrx = data[1];
        var cpar1 = data[2];
        var cpar = data[2].split(']');
        var cselisih = data[3];
        var ccor = data[4];
        var cpost = data[5];

        $.ajax({
         type: "post",
         url: "<?php echo base_url(); ?>markas/core1/caritrxdet/"+ctrx,
         cache: false,
         async: false,
        data:jQuery.param({
          param: (varopta == '00'?cpar[0].replace('[',''):'')
        }),
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
            var getkop = '';
            var tswal = '';
             for (var i = 0; i <= jumdata; i++) {
               nilai = parseFloat(isidet[i].aktrx_jum);
               jdlmod = isidet[i].aktrx_nomor;
               dettbl += '<tr>';
                 dettbl += '<td>'+isidet[i].aktrx_nomor+'</td>';
                 dettbl += '<td style="text-align:left;">'+isidet[i].aktrx_nama+'</td>';
                 dettbl += '<td>'+(isidet[i].aktrx_jns=='D'?Intl.NumberFormat().format(nilai.toFixed(2)):0)+'</td>';
                 dettbl += '<td>'+(isidet[i].aktrx_jns=='K'?Intl.NumberFormat().format(nilai.toFixed(2)):0)+'</td>';
               dettbl += '</tr>';
              getkop = isidet[i].aktrx_nomor;
             }
//            setCookie('precor','01'+getkop.substr(7,2));

            if(varopta != '00'){
              if(ccor != 'X' && cpost == 'X'){
                addt = "<a class=\"btn btn-sm btn-warning\" href=\"javascript:void(0)\" title=\"Koreksi\" onclick=\"hapusjurnal('"+ctrx+"')\">Koreksi</a><a class=\"btn btn-sm btn-info\" onclick=\"godetail('"+ctrx+"')\">Detail</a>"+(cselisih == 0?"<a class=\"btn btn-sm btn-success\" onclick=\"gopost('"+ctrx+"')\">Posting</a>":"");
              } else if (ccor == 'X' && cpost == 'X') {
                tswal = 'error';
               addt = '<span class="red">'+cpar1+'</span>';
              } else if (ccor == 'X' && cpost == '+') {
                tswal = 'error';
               addt = "Dikoreksi petugas keuskupan.<br/><span class='purple'>Silahkan posting transaksi pengganti sebelum tanggal tutup buku jika diperlukan.</span>";
              } else if (cselisih == '-' && cpost == '+') {
                tswal = 'success';
               addt = "Data valid";
              } else {
                tswal = 'info';
               addt = "Sudah diposting.<br><span class=\"purple\">Menunggu validasi.</span>";
             }
            } else {
              if(ccor != 'X' && cpost == 'X'){
                addt = "<a class=\"btn btn-sm btn-warning\" href=\"javascript:void(0)\" title=\"Koreksi\" onclick=\"hapusjurnal('"+ctrx+"')\">Koreksi</a><a class=\"btn btn-sm btn-success\" onclick=\"gopost('"+ctrx+"')\">Valid</a>";
              } else if (ccor == 'X' && cpost == 'X') {
                tswal = 'error';
                addt = "Mendapat koreksi.<br/><span class='blue'>Akan dikirim transaksi perbaikan jika ada.</span>";
              } else {
                tswal = 'success';
              addt = "Sudah divalidasi.";
            }
            }



             swal.fire({
               title: "Transaksi " + ctrx,
               icon: tswal,
               html: "<div class=\"table-responsive\" style=\"padding:2em;\"><table id=\"filltambah\" class=\"table table-condensed table-striped table-full-width nowrap\" cellspacing=\"0\" width=\"100%\"><thead><tr><th colspan=\"2\">"+(varopta == '00'?(cpar[0]+"]"):"")+"</th><th colspan=\"2\">"+ctagl+"</th></tr><tr><th>Kode</th><th>Uraian</th><th>Debet</th><th>Kredit</th></tr></thead><tbody>"+dettbl+"</tbody></table></div><hr/>" + addt + "<hr/>",
              width: 600,
              position: "top",
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

      $('#fj_tgl').on('change',function(){
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

      function exfile(){
        var url = '<?php echo base_url(); ?>markas/proeksternal/exjson';
        $.ajax({
          type: 'POST',
          url: url,
          success: function(data1){
            var idata = data1;

            swal.fire({
              title: "Unduh berkas?",
              type: "info",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
            },
            function(){
              location.assign('<?php echo base_url(); ?>markas/proeksternal/download_plus_headers/'+idata);
              setTimeout(function(){
                $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url(); ?>markas/proeksternal/hpsback/'+idata,
                  success: function(data1){
                    swal.fire({
                        title: "Pencadangan berhasil!",
                        type: "success",
                        text: idata,
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    });
                    location.reload();
                  }
                });
              },5000);
            });
          }
        });
      }

      function imfile(){
        var url = '<?php echo base_url(); ?>markas/proeksternal/imjson';
        $.ajax({
          type: 'POST',
          url: url,
          success: function(data1){
            var idata = data1;
            swal.fire({
                title: "Data berhasil diekspor!",
                type: "success",
                text: idata,
                timer: 5000,
                timerProgressBar: true,
                showConfirmButton: false
            });
          }
        });
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
                swal.fireel += '<div id="list'+isidata[i].waktu+'"  class="tagsinput" style="width:100%;"></div>';
                  icel += '<hr/>';
                }
                $('#buttable').append(icel);
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
                icel += '<div class="bulan"><button class="btn btn-app btn-sm" onclick="gopost(\''+piltahun+isidata[i].angka+'\')">'+isidata[i].huruf+'</btn></div>';
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
        function pad(s) { return (s < 10) ? '0' + s : s; }
        var gourl = '<?php echo base_url();?>markas/reports/hitbulan';
        $.ajax({
            url: gourl,
            type: 'POST',
            data: jQuery.param({
              blnthn: partgl
            }),
            success: function(itahun) {
              fillgrid(partgl.substr(0,4)+'-'+pad(partgl.substr(4,partgl.length-4))+'-01'+partgl.substr(0,4)+'-'+pad(partgl.substr(4,partgl.length-4))+'-'+pad(itahun));
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
              swal.fire("Awas!", awas , "error");
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
                swal.fire("Perhatian!", "Nomor Jurnal sudah terpakai", "error");
                $('#ft_nomor').val('');
              }
            }
        });
    }

    function fillgrid(rentang){
        table = $('#tfillgrid').DataTable({
          "createdRow": function(row, data, dataIndex){
            if(data[4] ==  'X' && data[5] ==  'X'){
              $(row).css('font-style','italic');
//              $(row).css('font-weight','bold');
              $(row).css('background-color','#febdbd');
              $(row).css('color','#767676');
            } else if(data[4] ==  'X' && data[5] ==  '+'){
              $(row).css('font-style','italic');
              $(row).css('font-weight','bold');
              $(row).css('background-color','#fbacac');
              $(row).css('color','#767676');
            } else if(data[3] !=  '-' && data[5] ==  '+'){
              $(row).css('font-style','italic');
              $(row).css('font-weight','bold');
              $(row).css('background-color','#edeebd');
              $(row).css('color','#767676');
            } else if(data[3] ==  '-' && data[5] ==  '+'){
              $(row).css('font-style','italic');
              $(row).css('font-weight','bold');
              $(row).css('background-color','#d7ffd7');
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
            "url": "<?php echo base_url(); ?>markas/core1/fillgrid/area2"+(rentang != ''?rentang:''),
            "type": "POST"
            },
            scrollY: (varopta == '00'?500:400),
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
        reload_table();
//        tbinfo.ajax.reload();
    }

    function reload_table(){
        table.ajax.reload(null,false);
    }


    function hapusjurnal(id){
      var loop1 = '';
      var loop2 = decode_cookie(getCookie('simkop'));
      var loop3 = decode_cookie(getCookie('simakses'));
      console.log('p1: '+loop1+', '+loop2+', '+loop3);
      $.ajax({
       type: "post",
       url: "<?php echo base_url(); ?>markas/core1/caritrxdet/"+id,
       cache: false,
       async: false,
      data:jQuery.param({
        param: ''
      }),
       success: function(data){
        if(data){
          var detdata = JSON.parse(data);
          loop1 = detdata[0].akjur_kopar;
          console.log('p2: '+loop1+', '+loop2+', '+loop3);

          Swal.fire({
            title: "Koreksi Jurnal?",
            text: "Belum ada fitur UNDO untuk proses ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, lajutkan!",
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url: "<?php echo base_url(); ?>markas/core1/koreksi2/",
                  type: "POST",
                  delay: 500,
                  cache: false,
                  async: false,
                  data:jQuery.param({
                    idjur:id,
                    param: loop1
                  }),
                  success: function (data) {
                    console.log('p3: '+loop1+', '+loop2+', '+loop3);
                    if(varopta == '00'){
                      setCookie('simkop',loop1);
                      setCookie('simakses',loop1.substr(-2));
                      $.ajax({
                          url: "<?php echo base_url(); ?>markas/core1/koreksi2/",
                          type: "POST",
                          delay: 500,
                          cache: false,
                          async: false,
                          data:jQuery.param({
                            idjur:id,
                            param:''
                          }),
                          success: function (data2) {
                            console.log('p4: '+loop1+', '+loop2+', '+loop3);
                              setCookie('simkop',loop2);
                              setCookie('simakses',loop3);
                              swal.fire({
                                title: "Sukses!",
                                text: "Jurnal BERHASIL dikoreksi.",
                                icon: "success",
                                timer: 1000,
                                timerProgressBar: true,
                              });
                          },
                          error: function (xhr, ajaxOptions, thrownError) {
                            swal.fire("Gangguan!", "Jurnal GAGAL koreksi gagal!", "error");
                          }
                      });
                    } else {
                      swal.fire({
                        title: "Sukses!",
                        text: "Jurnal BERHASIL dikoreksi.",
                        icon: "success",
                        timer: 1000,
                        timerProgressBar: true,
                      });
                    }
                  },
                  error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Gangguan!", "Jurnal GAGAL koreksi gagal!", "error");
                  }
              });
              reload_table();
            }
          });
        }
      }
    });
    catat("COR " + id);
    }

  function gopost(id){
    Swal.fire({
      title: "Posting Jurnal?",
      text: varopta == '00'?"Jurnal dan tansaksinya sudah valid?":"Jurnal dan transaksinya sudah benar dan siap lapor.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Ya, lajutkan!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
            url: "<?php echo base_url(); ?>markas/core1/posting1/",
            type: "POST",
            data:jQuery.param({
              idjur:id.length == 10?id:'',
              param: id.length == 10?'':id
            }),
            success: function (data) {
              if(varopta != '00' && id.length != 10){
                $('#buttable').empty();
                cekreport();
              }
              swal.fire({
                title: "Sukses!",
                icon: "success",
                text: JSON.parse(data) === null?(varopta == '00'?"Jurnal BERHASIL divalidasi.":"Jurnal BERHASIL diposting."):"",
                timer: 1000,
                timerProgressBar: true,
                type: "success"
              });
            },
            error: function (xhr, ajaxOptions, thrownError) {
              swal.fire("Gangguan!", "Jurnal GAGAL posting!", "error");
            }
        });

        reload_table();
      }
    });
  catat("POST " + id);
}

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
