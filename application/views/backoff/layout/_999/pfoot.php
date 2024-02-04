<footer>
    <div class="pull-right">
        Q-MARSUPIUM 2024, Created by AR Setontong. Use for presentation purpose only. <br />
        <p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds.</p>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->

    </div>
</div>

    <!-- jQuery -->
    <script src="<?php echo base_url();?>dapur0/vendors/jquery/dist/jquery.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url();?>dapur0/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- SweetAlert -->
    <script src="<?php echo base_url();?>dapur0/vendors/sweetalert/dist/sweetalert.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url();?>dapur0/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?php echo base_url();?>dapur0/vendors/nprogress/nprogress.js"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/datatables.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/pdfmake-0.1.32/pdfmake.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>dapur0/vendors/DataTables/pdfmake-0.1.32/vfs_fonts.js"></script>

    <!-- Select2 -->
    <script src="<?php echo base_url();?>dapur0/vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="<?php echo base_url();?>dapur0/vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="<?php echo base_url();?>dapur0/vendors/starrr/dist/starrr.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url();?>dapur0/build/js/custom.min.js"></script>
    <script src="<?php echo base_url();?>dapur0/js/datepicker/daterangepicker.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <!-- jquery.inputmask -->
    <script src="<?php echo base_url();?>dapur0/vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/pnotify/dist/pnotify.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- iCheck -->
    <script src="<?php echo base_url();?>dapur0/vendors/iCheck/icheck.min.js"></script>
    <!-- Autosize -->
    <script src="<?php echo base_url();?>dapur0/vendors/autosize/dist/autosize.min.js"></script>

    <!-- parsley -->
    <script src="<?php echo base_url();?>dapur0/vendors/parsleyjs/dist/parsley.js"></script>
    <!-- chart.js -->
    <script src="<?php echo base_url();?>dapur0/vendors/Chart.js/dist/Chart.bundle.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/Chart.js/samples/utils.js"></script>

    <!-- lightbox2 -->
    <script src="<?php echo base_url();?>dapur0/vendors/lightbox/jquery.colorbox.js"></script>

    <!-- echarts -->
    <script src="<?php echo base_url();?>dapur0/vendors/echarts/dist/echarts.min.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/echarts/map/js/world.js"></script>

    <script src="<?php echo base_url();?>dapur0/vendors/dblock/jquery.blockUI.js"></script>
    <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/tinymce.min.js"></script>
    <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/plugins/table/plugin.min.js"></script>
    <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/plugins/paste/plugin.min.js"></script>
    <script src="<?php echo base_url()."dapur0/vendors/tinymce/"; ?>js/tinymce/plugins/spellchecker/plugin.min.js"></script>
    <!-- Select2 -->

    <!-- jstree -->
    <script src="<?php echo base_url();?>dapur0/vendors/jstree/dist/jstree.js"></script>

    <!-- partikel -->
    <script src="<?php echo base_url();?>dapur0/vendors/partikel/js/anime.min.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/partikel/js/particles.js"></script>
    <script src="<?php echo base_url();?>dapur0/vendors/partikel/js/demo.js"></script>

    <script>
    $(document).ajaxStop($.unblockUI);
      $(document).ready(function (){
        var nmrdok = "<?php echo $ndok;?>";
        filldokumen(nmrdok);
      });

        $('.balikneh').click(function(){
          var particles = new Particles('.balikneh');
          particles.disintegrate({
            duration: 1000,
            delay: 50,
            type: 'triangle',
            complete: function(){
              location.assign("<?php echo base_url().'markas/corex';?>")
//              history.back()
            }
          });
        });


      function showImage(e) {
          $.colorbox({
              href: $(e.currentTarget).attr("src"),
              overlayClose: true,
              opacity: 0.8,
              closeButton: true
          });
      }

      function reload_table(){
          table.ajax.reload(null,false); //reload datatable ajax
      }

    function filldokumen(nodok){
    var url = '<?php echo base_url(); ?>markas/corex/filldok/' + nodok;
    if ( $.fn.dataTable.isDataTable( '#tfillgrid' ) ) {
        table = $('#tfillgrid').DataTable();
        location.reload();
    }
    else {
      $.blockUI();
      var tglctk = new Date();
      var jsDate = tglctk.getDate()+'-'+(tglctk.getMonth()+1)+'-'+tglctk.getFullYear();
      var jsDate2 = tglctk.getDate()+(tglctk.getMonth()+1)+tglctk.getFullYear();

      table = $('#tfillgrid').DataTable({
        "ajax": {
          "url": url,
          "type": "POST"
        },
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
//        "responsive": true,
//        "autoWidth": false,
        "order": [],
        "dom": '<"top"B>rt<"bottom"><"clear">',
          "buttons": [

            {
              "extend": 'pdfHtml5',
              "title": 'DokTIK' + nodok.replace(/[.^\-\.]/g,'') + jsDate.replace(/[.^\-\.]/g,''),
              "text": '<i class="fa fa-file-pdf-o"></i>',
              "titleAttr": 'Export: PDF',
              "pageSize": 'A4',
              "header": true,
              "footer": true,
              "download": 'download',
              "exportOptions": {
                orthogonal: 'export',
                modifier: {
                  page: 'current',
                  pageMargins: [ 150, 150, 150, 150 ],
                  margin: [ 0, 0, 0, 120 ],
                  alignment: 'center',
                  columns: [{width:35},{width:65}]
                },
                columns: [0,1]
              },
              "customize": function ( doc ) {
                doc.content.splice(0, 1, {
                  text: [
                    { text: '\n-----ooOOOoo-----\n' + '\n\n',bold:true,fontSize:11 }
                  ],
                  margin: [0, 0, 0, 12],
                  alignment: 'center'
                });
                var lastColX=null;
                var lastColY=null;
                var bod = [];
                var bod1 = [];
                doc.content[1].table.body.forEach(function(line, i){
                    if(lastColX != line[0].text && line[0].text != ''){
                        if(i == 0){
                          bod.push([
                            {text:'Identifikasi', style:'tableHeader'},
                            {text:'Paparan', style:'tableHeader'}
                          ]);
                        } else {
                          bod.push([
                            {text:line[0].text, style:'defaultStyle1'},
                            {text:line[1].text, style:'defaultStyle4'}
                          ]);
                        }
                        //Update last
                        lastColX=line[0].text;
                    }

                }
              );


                //Overwrite the old table body with the new one.
                doc.pageMargins = [50, 20, 20,20 ];
                doc.content[1].table.headerRows = 1;
                doc.content[1].table.widths = ['35%','65%'];

                doc.content[1].table.body = bod;
                doc.content[1].table.dontBreakRows = false;
                var objLayout = {};
                objLayout['hLineWidth'] = function(i) { return .5; };
                objLayout['vLineWidth'] = function(i) { return .5; };
                objLayout['hLineColor'] = function(i) { return '#bbb'; };
                objLayout['vLineColor'] = function(i) { return '#bbb'; };
                objLayout['paddingLeft'] = function(i) { return 4; };
                objLayout['paddingRight'] = function(i) { return 4; };
                doc.content[1].layout = objLayout;
                var logo = 'data:image/png;base64,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';
                var logok = 'data:image/png;base64,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';



                var tglctk = new Date();
                var jsDate = tglctk.getDate()+'-'+(tglctk.getMonth()+1)+'-'+tglctk.getFullYear();

                doc.content.splice( 0, 0, {
                  columns: [{
                    margin: [ 0, 0, 12, 12 ],
                    width:'40%',
                    fontSize: 9,
                    bold: true,
                    alignment: 'left',
                    image: logo,
                    width: 220
                  },
                      {width: '10%',alignment: 'center',text: ''},
                      {width: '15%',margin: [12, 0, 0, 12],fontSize: 9,text: 'No.Dokumen\n\n'},
                      {width: '2%',margin: [12, 0, 0, 12],fontSize: 9,text: ':\n\n'},
                      {width: '33%',margin: [12, 0, 0, 12],fontSize: 9,text: nodok + '\n\n'}
                  ],
                  columnGap: 2
                });

                doc['footer']=(function(page, pages) {
                  return {
                    columns: [{
                      text: 'QHMS 2017@RSK St. Antonius Ampenan ('+jsDate.toString()+')',
                      fontSize: 6,
                      alignment: 'left',
                      margin:[40]
                    },
                    {
                      alignment: 'right',
                      text: [{text: 'Dokumentasi Bag.TIK  Hal. ' + page.toString(),italics: true},' dari ',{ text: pages.toString(), italics: true }],
                      fontSize: 6,
                      alignment: 'right',
                      margin:[0,0,40]
                    }
                  ]}
                }
              );
                doc.styles = {
                    subheader: {
                      color: '#ffffff',
                      fontSize: 9,
                      alignment: 'center',
                      fontweight: 'bold',
                      fillColor: '#008800'
                    },
                    tableHeader: {
                        bold: true,
                        color: '#ffffff',
                        fontSize: 10,
                        alignment: 'center',
                        fontweight: 'bold',
                        fillColor: '#006600'
                    },
                    lastLine: {
                      color: '#000000',
                      fontSize: 9,
                      alignment: 'right',
                      fontweight: 'bold',
                      fillColor: '#ddd'
                    },
                    defaultStyle1: {
                    fontSize: 9,
                    alignment: 'left'
                    },
                    defaultStyle2: {
                    fontSize: 9,
                    alignment: 'right'
                    },
                    defaultStyle3: {
                    fontSize: 9,
                    alignment: 'center'
                    },
                    defaultStyle4: {
                    fontSize: 9,
                    alignment: 'justify'
                    }
                }

              }

          }
      ],
      "columnDefs": [
        {
          targets: [ 0,1 ],
          "orderable": false
          }
          ]
      });
  }
    reload_table();
    $(".imgzoom").on("click", showImage);
  }

    </script>
