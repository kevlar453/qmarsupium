<script>
$(document).ajaxStop($.unblockUI);
    $(document).ready(function (){
      catat('Buka modul Buku Besar');
        fillgrid();
        hidform();
        hidpesan();
        $('#hlak1').addClass('fadeOutUp hidden'); $('#hlak1').removeClass('fadeInDown');
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
//    $jlak = array('00'=>'-Pilih Akun-','01'=>'Group GL-1','02'=>'Group GL-2','03'=>'Group GL-3','04'=>'Group GL-4');

    $('#fa_jlak').select2({
      minimumResultsForSearch: -1,
  	placeholder: "-Pilih Akun-",
    data: [
      {id:'01',text:'Group GL-1'},
      {id:'02',text:'Group GL-2'},
      {id:'03',text:'Group GL-3'},
      {id:'04',text:'Group GL-4'}
    ],
    }).on('select2:select', function(e) {
      var piljlak = $('#fa_jlak').val();
      switch (piljlak) {
        case '01':
        hidform();
        $("#falak01").removeClass("hidden");
          break;
        case '02':
        hidform();
        $("#falak02").removeClass("hidden");
          break;
        case '03':
        hidform();
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>markas/core1/get_7vjur',
            success: function(data1) {
                var data2 = JSON.parse(data1);
                $.each(data2,function(id,data2) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(data2);
                    $('#fa_jlak131').append(opt);
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
        $.ajax({
            type: "POST",
            url: '<?php echo base_url();?>markas/core1/get_7vjur',
            success: function(data3) {
                var data4 = JSON.parse(data3);
                $.each(data4,function(id,data4) {
                    var opt = $('<option />');
                    opt.val(id);
                    opt.text(data4);
                    $('#fa_jlak132').append(opt);
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
        $("#falak03").removeClass("hidden");
        $("#falak13").removeClass("hidden");
        $("#falak23").removeClass("hidden");
          break;
        case '04':
        hidform();
        $("#falak04").removeClass("hidden");
          break;
        default:
        hidform();
        break;

      }
      var vglpsn1 = $('#fa_jlak option:selected').text();
      var glpsn1 = '<i class="fa fa-chevron-circle-right green"></i> <strong>' + vglpsn1 + '</strong> dipilih. Masukkan Kode Akun!';
      $('#glmark1').html(glpsn1);
      $('#glmark1').removeClass('hidden');
      ceklist(piljlak);
    });

    $('#fa_lak1').keyup(function() {
      var isilak1 = $('#fa_lak1').val();
      var jisilak1 = isilak1.length;
      if(jisilak1==3){
        $('#hlak1').removeClass('hidden fadeOutUp'); $('#hlak1').addClass('fadeInDown');
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka1/'; ?>" + isilak1,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              if(data!=false){
                var jslak1 = '<i class="fa fa-chevron-circle-right"> </i> <strong>[' + isilak1 + '] ' + data.ka_nama + '</strong>';
                $('#hlak1').html(jslak1);
                banform();
                var glpsn2 = jslak1 + ' sudah terpakai. Masukkan Kode Akun lain!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              } else {
                $('#hlak1').html('<strong>[' + isilak1 + '] ' + 'Belum Terpakai</strong>');
                relform();
                var vglpsn2 = '<i class="fa fa-chevron-circle-right green"></i> <strong>[' + isilak1 + '] ' + 'Belum Terpakai</strong>';
                var glpsn2 = vglpsn2 + '. Masukkan Nama Akun!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              }
            }
        });
      } else {
        banform();
        $('#hlak1').addClass('fadeOutUp hidden'); $('#hlak1').removeClass('fadeInDown');
        $('#glmark2').addClass('hidden');
      }

    });

    $('#fa_lak2').keyup(function() {
      var isilak2 = $('#fa_lak2').val();
      var jisilak2 = isilak2.length;
      if(jisilak2==1){
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka1/'; ?>" + isilak2.substr(0,1) + '00',
            type: "GET",
            dataType: "JSON",
            success: function(data1) {
              if(!data1){
//                    $('#hlak1').html(jslak1);
//                    banform();
//                    var vglpsn2 = data.ka_nama;
                var glpsn2c = '<h4 class="animated flash"><i class="fa fa-chevron-circle-right red"></i> Tidak ditemukan <strong>Kode Akun [' + isilak2.substr(0,1) + '00' + ']</strong> pada Group GL-1. Mohon isi dulu Group GL-1 sebelum mengisi Group GL-2!</h4>';
                $('#glmark2').html(glpsn2c);
                $('#glmark2').removeClass('hidden');
                $('#glmark2').addClass('red');
                $('#fa_lak2').val('');
                banform();
              } else {
                $('#glmark2').removeClass('red');
                $('#glmark2').addClass('hidden');
              }
            }
        });
      } else if(jisilak2==3){
        $('#glmark2').removeClass('red');
        $('#hlak1').removeClass('hidden fadeOutUp'); $('#hlak1').addClass('fadeInDown');
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka2/'; ?>" + isilak2,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              if(data!=false){
                var jslak2 = '<i class="fa fa-chevron-circle-right"></i> <strong>[' + isilak2 + '] ' + data.ka_nama + '</strong>';
                $('#hlak1').html(jslak2);
                banform();
                var glpsn2 = jslak2 + ' sudah terpakai. Masukkan Kode Akun lain!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              } else if (isilak2.substr(-1)=='0' && isilak2.substr(-2)!='00'){
                $('#hlak1').html('<strong>[' + isilak2 + '] ' + 'Belum Terpakai</strong>');
                relform();
                var vglpsn2 = '<i class="fa fa-chevron-circle-right green"></i> <strong>[' + isilak2 + '] ' + 'Belum Terpakai</strong>';
                var glpsn2 = vglpsn2 + '. Masukkan Nama Akun!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              } else {
                $('#hlak1').html('<strong>[' + isilak2 + '] ' + 'Belum Terpakai</strong>');
                relform();
                var vglpsn2 = '<i class="fa fa-chevron-circle-right green"></i> <strong>[' + isilak2 + '] ' + 'Belum Terpakai</strong> tetapi tidak menggunakan <strong class="red">FORMAT</strong> yang disarankan.';
                var glpsn2 = vglpsn2 + '. Masukkan Nama Akun!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              }
            }
        });
      } else {
        banform();
        $('#hlak1').addClass('fadeOutUp hidden'); $('#hlak1').removeClass('fadeInDown');
        $('#glmark2').addClass('hidden');
      }

    });

    $('#fa_lak3').keyup(function() {
      var isilak3 = $('#fa_lak3').val();
      var jisilak3 = isilak3.length;
      if(jisilak3==1){
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka1/'; ?>" + isilak3.substr(0,1) + '00',
            type: "GET",
            dataType: "JSON",
            success: function(data1) {
              if(!data1){
                var glpsn3c = '<h4 class="animated flash"><i class="fa fa-chevron-circle-right red"></i> Tidak ditemukan <strong>Kode Akun [' + isilak3.substr(0,1) + '00' + ']</strong> pada Group GL-1. Mohon isi dulu Group GL-1 sebelum mengisi Group GL-2!</h4>';
                $('#glmark2').html(glpsn3c);
                $('#glmark2').removeClass('hidden');
                $('#glmark2').addClass('red');
                $('#fa_lak3').val('');
              } else {
                $('#glmark2').removeClass('red');
                $('#glmark2').addClass('hidden');
              }
            }
        });
      } else if(jisilak3==2){
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka2/'; ?>" + isilak3.substr(0,2) + '0',
            type: "GET",
            dataType: "JSON",
            success: function(data2) {
              if(!data2){
                var glpsn3c = '<h4 class="animated flash"><i class="fa fa-chevron-circle-right red"></i> Tidak ditemukan <strong>Kode Akun [' + isilak3.substr(0,2) + '0' + ']</strong> pada Group GL-2. Mohon isi dulu Group GL-2 sebelum mengisi Group GL-3!</h4>';
                $('#glmark2').html(glpsn3c);
                $('#glmark2').removeClass('hidden');
                $('#glmark2').addClass('red');
                $('#fa_lak3').val('');
              } else {
                $('#glmark2').removeClass('red');
                $('#glmark2').addClass('hidden');
              }
            }
        });
      } else if(jisilak3==3){
        $('#hlak1').removeClass('hidden fadeOutUp'); $('#hlak1').addClass('fadeInDown');
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka3/'; ?>" + isilak3,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              if(data!=false){
                var jslak3 = '<i class="fa fa-chevron-circle-right red"></i> <strong>[' + isilak3 + '] ' + data.ka_nama + '</strong>';
                $('#hlak1').html(jslak3);
                banform();
                var glpsn2 = jslak3 + '. Masukkan Kode Akun lain!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              } else {
                $('#hlak1').html('<strong>[' + isilak3 + '] ' + 'Belum Terpakai</strong>');
                relform();
                var vglpsn2 = '<i class="fa fa-chevron-circle-right green"></i> <strong>[' + isilak3 + '] ' + 'Belum Terpakai</strong>';
                var glpsn2 = vglpsn2 + '. Masukkan Nama Akun!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              }
            }
        });
      } else {
        banform();
        $('#hlak1').addClass('fadeOutUp hidden'); $('#hlak1').removeClass('fadeInDown');
        $('#glmark2').addClass('hidden');
      }
    });

    $('#fa_lak4').keyup(function() {
      var isilak4 = $('#fa_lak4').val();
      var jisilak4 = isilak4.length;
      if(jisilak4==1){
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka1/'; ?>" + isilak4.substr(0,1) + '00',
            type: "GET",
            dataType: "JSON",
            success: function(data1) {
              if(!data1){
                var glpsn4c = '<h4 class="animated flash"><i class="fa fa-chevron-circle-right red"></i> Tidak ditemukan <strong>Kode Akun [' + isilak4.substr(0,1) + '00' + ']</strong> pada Group GL-1. Mohon isi dulu Group GL-1 sebelum mengisi Group GL-2!</h4>';
                $('#glmark2').html(glpsn4c);
                $('#glmark2').removeClass('hidden');
                $('#glmark2').addClass('red');
                $('#fa_lak4').val('');
              } else {
                $('#glmark2').removeClass('red');
                $('#glmark2').addClass('hidden');
              }
            }
        });
      } else if(jisilak4==2){
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka2/'; ?>" + isilak4.substr(0,2) + '0',
            type: "GET",
            dataType: "JSON",
            success: function(data2) {
              if(!data2){
                var glpsn4c = '<h4 class="animated flash"><i class="fa fa-chevron-circle-right red"></i> Tidak ditemukan <strong>Kode Akun [' + isilak4.substr(0,2) + '0' + ']</strong> pada Group GL-2. Mohon isi dulu Group GL-2 sebelum mengisi Group GL-3!</h4>';
                $('#glmark2').html(glpsn4c);
                $('#glmark2').removeClass('hidden');
                $('#glmark2').addClass('red');
                $('#fa_lak4').val('');
              } else {
                $('#glmark2').removeClass('red');
                $('#glmark2').addClass('hidden');
              }
            }
        });
      } else if(jisilak4==3){
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka3/'; ?>" + isilak4,
            type: "GET",
            dataType: "JSON",
            success: function(data3) {
              if(!data3){
                var glpsn4c = '<h4 class="animated flash"><i class="fa fa-chevron-circle-right red"></i> Tidak ditemukan <strong>Kode Akun [' + isilak4 + ']</strong> pada Group GL-3. Mohon isi dulu Group GL-3 sebelum mengisi Group GL-4!</h4>';
                $('#glmark2').html(glpsn4c);
                $('#glmark2').removeClass('hidden');
                $('#glmark2').addClass('red');
                $('#fa_lak4').val('');
              } else {
                $('#glmark2').removeClass('red');
                $('#glmark2').addClass('hidden');
              }
            }
        });
      } else if(jisilak4==12){
        $('#hlak1').removeClass('hidden fadeOutUp'); $('#hlak1').addClass('fadeInDown');
        $.ajax({
            url : "<?php echo base_url().'markas/core1/get_7ka4/'; ?>" + isilak4,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
              if(data!=false){
                var jslak4 = '<i class="fa fa-chevron-circle-right red"></i> <strong>[' + isilak4 + '] ' + data.ka_nama + '</strong>';
                $('#hlak1').html(jslak4);
                banform();
                var glpsn2 = jslak4 + '. Masukkan Kode Akun lain!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              } else {
                $('#hlak1').html('<strong>[' + isilak4 + '] ' + 'Belum Terpakai</strong>');
                relform();
                var vglpsn2 = '<i class="fa fa-chevron-circle-right green"></i> <strong>[' + isilak4 + '] ' + 'Belum Terpakai</strong>';
                var glpsn2 = vglpsn2 + '. Masukkan Nama Akun!';
                $('#glmark2').html(glpsn2);
                $('#glmark2').removeClass('hidden');
              }
            }
        });
      } else {
        banform();
        $('#hlak1').addClass('fadeOutUp hidden'); $('#hlak1').removeClass('fadeInDown');
        $('#glmark2').addClass('hidden');
      }

    });

    function ceklist(vlist){
      $.jstree.destroy();
      $('#listperk').jstree({
        'core' : {
          'destroy':true,
          'data' : {
            "url" : "<?php echo base_url();?>markas/core1/get_perklist/" + vlist,
            "dataType" : "json"
          }

        }
      });
    }


    function banform(){
      $('#hlak1').addClass('alert-danger');
      $('#hlak1').removeClass('alert-success');
      $('#tbsimperk').addClass('disabled');
      $("#falak05").addClass("hidden");

    }

    function relform(){
      $('#hlak1').removeClass('alert-danger');
      $('#hlak1').addClass('alert-success');
      $('#tbsimperk').removeClass('disabled');
      $("#falak05").removeClass("hidden");
    }

    function hidform(){
      $("#falak01").addClass("hidden");
      $("#falak02").addClass("hidden");
      $("#falak03").addClass("hidden");
      $("#falak13").addClass("hidden");
      $("#falak23").addClass("hidden");
      $("#falak04").addClass("hidden");
      $("#falak05").addClass("hidden");
    }

    function hidpesan(){
      $("#glmark1").addClass("hidden");
      $("#glmark2").addClass("hidden");
      $("#glmark3").addClass("hidden");
      $("#glmark4").addClass("hidden");
    }

    function testmulti(){
      var mul1 =$('#fa_jlak131').val();
      var mul2 =$('#fa_jlak132').val();
      $("#glmark1").html(mul1);
      $("#glmark2").html(mul2);
      $("#glmark1").removeClass("hidden");
      $("#glmark2").removeClass("hidden");

    }

    function simpperkiraan(){

      var piljlak = $('#fa_jlak').val();
      var kdnper1 = $('#fa_nak1').val();
      var kdnper = kdnper1.replace(",","%2C");
      switch (piljlak) {
        case '01':
        var kdper1 = $('#fa_lak1').val();
        var kodeper = kdper1 + kdnper;
          break;

        case '02':
        var kdper2 = $('#fa_lak2').val();
        var kodeper = kdper2 + kdnper;
          break;

        case '03':
        var kdper3 = $('#fa_lak3').val();
        var kdper131 = $('#fa_jlak131').val();
        var kdper132 = $('#fa_jlak132').val();
        var kdper13 = kdper131.toString();
        var kdper23 = kdper132.toString();
        var kodeper = kdper3 + kdnper;
        var kodeper13 = 'D' + kdper3 + kdper13;
        var kodeper23 = 'K' + kdper3 + kdper23;
          break;

        default:
        var kdper4 = $('#fa_lak4').val();
        var kodeper = kdper4 + kdnper;
        break;
      }

      var detcat1 = kodeper;
      var detcat2 = $('#fa_jlak option:selected').text();
      swal.fire({
        title: 'Yakin???',
        showCancelButton: true,
        closeOnConfirm: false,
        animation: "pop"
      },
      function(inputValue){
          $.ajax({
              url : "<?php echo base_url(); ?>markas/core1/simpanperk/" + piljlak + kodeper,
              type: "POST",
              dataType: "JSON",
              success: function(data) {
                swal.fire({
                  title:"Perkiraan Tersimpan!",
                  type:"success",
                  timer: 2000,
                  showConfirmButton: false
                });
                if(piljlak=='03'){
                  if(kodeper13.length>4){
                    $.ajax({
                        url : "<?php echo base_url(); ?>markas/core1/simpanjkp/" + kodeper13.replace(",","%2C"),
                        type: "POST",
                        dataType: "JSON"
                    });
                  }
                  if(kodeper23.length>4){
                    $.ajax({
                        url : "<?php echo base_url(); ?>markas/core1/simpanjkp/" + kodeper23.replace(",","%2C"),
                        type: "POST",
                        dataType: "JSON"
                    });
                  }
                  $('#fa_lak1').val('');
                  $('#fa_lak2').val('');
                  $('#fa_lak3').val('');
                  $('#fa_lak4').val('');
                  $('#fa_nak1').val('');
                  hidform();
                  reload_table();

                } else {
                  $('#fa_lak1').val('');
                  $('#fa_lak2').val('');
                  $('#fa_lak3').val('');
                  $('#fa_lak4').val('');
                  $('#fa_nak1').val('');
                  hidform();
                  reload_table();
                }

              },
              error: function (jqXHR, textStatus, errorThrown) {
                swal.fire({
                  title:"Gagal!",
                  text:"Proses penyimpanan gagal. Mohon coba lagi!",
                  type:"warning",
                  timer: 1000,
                  showConfirmButton: false
                });
              }
          });
          catat("Isi kode akun " + detcat2 + " " + detcat1);
      });

    }


    function fillgrid(){
      $.blockUI();

      var url = "<?php echo base_url(); ?>markas/core1/variabel";

      table = $('#tvariabel').DataTable({
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
            "message": 'Daftar Perkiraan',
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
            "message": 'Daftar Perkiraan',
            "footer": true,
            "title": 'Perkiraan',
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
            "messageBottom": 'Daftar Perkiraan',
            "title": 'Dokumen Akuntansi',
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
                      {text:line[3].text, style:'tableHeader'}
                    ]);
                  } else {
                    bod.push([
                      {text:line[0].text, style:'defaultStyle1'},
                      {text:line[1].text, style:'defaultStyle1'},
                      {text:line[2].text, style:'defaultStyle1'},
                      {text:line[3].text, style:'defaultStyle1'}
                    ]);
                  }
                } else {
                    bod.push([
                    {text:line[0].text, style:'lastLine'},
                    {text:line[1].text, style:'lastLine'},
                    {text:line[2].text, style:'lastLine'},
                    {text:line[3].text, style:'lastLine'}
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
              doc.content[1].table.widths = ['5%','10%','70%','15%'];
              doc.content[1].table.body = bod;
              var objLayout = {};
              objLayout['hLineWidth'] = function(i) { return .5; };
              objLayout['vLineWidth'] = function(i) { return .5; };
              objLayout['hLineColor'] = function(i) { return '#aaa'; };
              objLayout['vLineColor'] = function(i) { return '#aaa'; };
              objLayout['paddingLeft'] = function(i) { return 4; };
              objLayout['paddingRight'] = function(i) { return 4; };
              doc.content[1].layout = objLayout;

              var logo =  'data:image/jpeg;base64,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';
              var tglctk = new Date();
              var jsDate = tglctk.getDate()+'-'+(tglctk.getMonth()+1)+'-'+tglctk.getFullYear();
              doc['footer']=(function(page, pages) {
                return {
                  columns: [{
                    text: 'QHMS 2017 @RSK St. Antonius Ampenan ('+jsDate.toString()+')',
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
                alignment: 'center',
                image: logo,
                width: 240
              } );

              doc.content.splice( 1, 0, {
                margin: [ 0, 0, 0, 12 ],
                fontSize: 12,
                bold: true,
                alignment: 'center',
                text: 'Daftar Perkiraan'
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
                  fontSize: 10,
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
      });
      $('.dt-button').addClass('btn btn-icon btn-success heartbeat animated delay-1s');
      $('.btn').removeClass('dt-button');
    }

    function reload_table(){
        table.ajax.reload(null,false);
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
/*
    setInterval( function () {
        table.ajax.reload();
        tbinfo.ajax.reload();
    }, 30000 );
*/
</script>
