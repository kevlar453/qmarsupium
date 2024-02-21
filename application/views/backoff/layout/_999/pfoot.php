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
                var logo = "<?php echo base64_encode(file_get_contents(base_url().'/dapur0/images/logokop.png'))?>";



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
