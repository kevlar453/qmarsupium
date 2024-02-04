<!-- page content -->
<div class="right_col" role="main">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Dokumentasi:</h2>
                <div class="clearfix"></div>
                <?php echo '<blockquote class="red slideInRight animated">'.strtoupper($jdok).'</blockquote>';$parm1 = (int)$this->session->userdata('pgsu')>=1?'O':'C';?>
            </div>
            <div class="x_content">
            <div class="table-responsive">

              <table id="tfillgrid" class="table table-condensed table-condensed" cellspacing="0" style="table-layout: <?php echo $parm1=='O'?'auto':'fixed';?>; width: 100%;word-wrap: break-word;">
                <thead>
                  <tr>
                    <th>Identifikasi</th>
                    <th>Paparan</th>
                  </tr>
                </thead>
                <tbody> 
                </tbody>
                <tfoot>
                    <th></th>
                    <th><?php echo $parm1=='O'?$this->dbcore1->routekey('TDk2REdjTGVzSDVOMlVBZk5NVTFxQT09','d','6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b').$this->dbcore1->routekey('cFZ1T0MwdzFYUSsyYUVhZmhNZmVhQT09','d','6b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b'):'TDk2REdjTGVzSDVOMlVBZk5NVTFxQT096b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4bcFZ1T0MwdzFYUSsyYUVhZmhNZmVhQT096b86b273ff34fce19d6b804eff5a3f5747ada4eaa22f1d49c01e52ddb7875b4b';?></th>
                </tfoot>
              </table>

            </div>
            </div>
        </div>
    </div>
</div>
