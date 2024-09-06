<style type="text/css">
  .myTable1 {
    margin-bottom: 0px;
  }

  .myt {
    margin-top: 0px;
  }

  .isi {
    height: 25px;
    padding-left: 4px;
    padding-right: 4px;
  }
</style>
<base href="<?php echo base_url(); ?>" />

<script type="text/javascript" src="<?= base_url("assets/panel/moment.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/panel/daterangepicker.min.js") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/panel/daterangepicker.css") ?>" />

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="panel/home"><i class="fa fa-home"></i> Dashboard</a></li>
      <li class="">Master</li>
      <li class="">Master H2</li>
      <li class="active"><?php echo ucwords(str_replace("_", " ", $isi)); ?></li>
    </ol>
  </section>
  <section class="content">
    <?php
    if ($set == "form") {
      $form = '';
      $disabled = '';
      $readonly = '';
      if ($mode == 'edit') {
        $form = 'save_edit';
        $readonly = 'readonly';
      }
      if ($mode == 'detail') {
        $form = '';
        $disabled = 'disabled';
      }
    ?>
      <script src="<?= base_url("assets/vue/vue.min.js") ?>" type="text/javascript"></script>
      <script src="<?= base_url("assets/vue/accounting.js") ?>" type="text/javascript"></script>
      <script src="<?= base_url("assets/vue/vue-numeric.min.js") ?>" type="text/javascript"></script>
      <script>
        Vue.use(VueNumeric.default);
        Vue.filter('toCurrency', function(value) {
          // console.log("type value ke currency filter" ,  value, typeof value, typeof value !== "number");
          if (typeof value !== "number") {
            return value;
          }
          return accounting.formatMoney(value, "", 0, ".", ",");
          return value;
        });
      </script>
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/voucher_lcr">
              <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
            </a>
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php
          if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
          ?>
            <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
              <strong><?php echo $_SESSION['pesan'] ?></strong>
              <button class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
            </div>
          <?php
          }
          $_SESSION['pesan'] = '';

          ?>
          <?php echo form_open(base_url() . "master/voucher_lcr/simpan", array('class' => 'form-horizontal')); ?>
          <div class="row">
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Periode</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="periode_filter" id="periode_filter" <?= $disabled ?> <?php if ($row['start_date']) { ?> value="<?= date("d/m/Y", strtotime($row['start_date'])) ?> - <?= date("d/m/Y", strtotime($row['end_date'])) ?>" <?php } ?> readonly>
                    <input id='periode_filter_start' name="periode_filter_start" value="<?= $row['start_date'] ?>" type="hidden" readonly>
                    <input id='periode_filter_end' name="periode_filter_end" type="hidden" value="<?= $row['end_date'] ?>" readonly>
                  </div>
                  <script>
                    $('#periode_filter').daterangepicker({
                      opens: 'left',
                      autoUpdateInput: false,
                      locale: {
                        format: 'DD/MM/YYYY'
                      }
                    }, function(start, end, label) {
                      $('#periode_filter_start').val(start.format('YYYY-MM-DD'));
                      $('#periode_filter_end').val(end.format('YYYY-MM-DD'));
                    }).on('apply.daterangepicker', function(ev, picker) {
                      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                    }).on('cancel.daterangepicker', function(ev, picker) {
                      $(this).val('');
                      $('#periode_filter_start').val('');
                      $('#periode_filter_end').val('');
                    });
                  </script>
                </div>
                <?php if ($mode == 'detail'): ?>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Qty</label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control" name="qty" id="qty" <?= $disabled ?> value="<?= $row['qty'] ?>" required>
                    </div>
                  </div>
                <?php endif; ?>
                <!-- <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Tanggal Assign Dealer</label>// created at
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="tgl_assign_dealer" id="tgl_assign_dealer" required>
                    </div>
                  </div> -->
                <!-- <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Tanggal Terima Dealer</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="tgl_terima_dealer" id="tgl_terima_dealer" required>
                    </div>
                  </div> -->
                <!-- <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Tanggal Penyerahan Customer</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="tgl_penyerahan_customer" id="tgl_penyerahan_customer" required>
                    </div>
                  </div> -->

                <?php if ($mode == 'edit'): ?>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Tanggal Expired</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="tgl_expired" id="tgl_expired" <?= $disabled ?> value="<?= $row['expired_date'] ?>" required>
                    </div>
                  </div>
                <?php endif; ?>
                <!-- <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Tanggal Redeem</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="tgl_penyerahan_customer" id="tgl_penyerahan_customer" required>
                    </div>
                  </div> -->
              </div>

            </div>
            <div class="col-md-6">
              <div class="box-body">
                <input type="hidden" class="form-control" name="ids" id="ids" value="<?= $row['id'] ?>">
                <?php if ($mode == 'detail'): ?>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Kode Voucher</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="kode_voucher" id="kode_voucher" autocomplete="off" <?= $disabled ?> value="<?= $row['kode_voucher'] ?>" required>

                    </div>
                  </div>
                <?php endif; ?>

                <?php if ($mode == 'edit' || $mode == 'detail'): ?>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Nilai Voucher</label>
                    <div class="col-sm-8">
                      <input type="number" class="form-control" name="nilai_voucher" id="nilai_voucher" autocomplete="off" <?= $disabled ?> value="<?= $row['nilai_voucher'] ?>" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Status</label>
                    <div class="col-sm-8">
                      <select name="status" id="status" class="form-control" <?= $disabled ?> required>
                        <option value="">-choose-</option>
                        <option <?php if ($row['status'] == 'new') {
                                  echo 'selected';
                                } ?> value="new">New</option>
                        <option <?php if ($row['status'] == 'cancel') {
                                  echo 'selected';
                                } ?> value="cancel">Cancel</option>
                      </select>
                    </div>
                  </div>
                <?php endif; ?>
                <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nomor Surat</label>
                  <div class="col-sm-8">  
                    <input type="text" class="form-control" name="no_surat" id="no_surat" value="<?= $row['no_surat'] ?>" <?= $disabled ?> required>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nama Dealer </label>
                  <div class="col-sm-8">
                    <select name="kode_dealer_md" id="kode_dealer_md" class="form-control select2" <?= $disabled ?> required>
                      <option value="">-choose-</option>
                      <?php
                      foreach ($dealer as $dl) {
                        if ($dl['id_dealer'] == $row['id_dealer']) {
                          echo '<option selected value="' . $dl['id_dealer'] . '">' . $dl['kode_dealer_md'] . ' - ' . $dl['nama_dealer'] . '</option>';
                        } else {
                          echo '<option value="' . $dl['id_dealer'] . '">' . $dl['kode_dealer_md'] . ' - ' . $dl['nama_dealer'] . '</option>';
                        }
                      }

                      ?>
                    </select>
                  </div>
                </div> -->
                <!-- <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">id Customer</label>
                    <div class="col-sm-8">
                      <select name="id_type" id="id_type" class="form-control select2" <?= $disabled ?> required>
                        <option value="">-choose-</option>
                        <?php foreach ($customer as $row) {
                          echo '<option value="">' . $row->nama_customer . '</option>';
                        } ?>
                      </select>
                    </div>
                  </div> -->
                <!-- <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">id Work Order</label>
                    <div class="col-sm-8">
                      <select name="id_type" id="id_type" class="form-control select2" <?= $disabled ?> required>
                        <option value="">-choose-</option>
                        <?php $dt_type = $this->db->get('ms_h2_jasa_type');
                        foreach ($dt_type->result() as $rs) {
                          $select = isset($row) ? $row->id_type == $rs->id_type ? 'selected' : '' : '';
                          if ($rs->active == 1) {
                        ?>
                            <option value="<?= $rs->id_type ?>" <?= $select ?>><?= $rs->id_type . ' | ' . $rs->deskripsi ?></option>
                        <?php
                          }
                        } ?>
                      </select>
                    </div>
                  </div> -->

              </div>
            </div>

            <div class="col-md-12">
              <div class="box-footer">
                <div align="center">
                  <?php if ($mode == 'detail') {
                    $id_v = $row['id'];
                    echo '<a href="master/voucher_lcr/edit?id_voucher=' . $id_v . '"  class="btn btn-warning btn-flat"><i class="fa fa-edit"></i> Edit</a>';
                  } else if ($mode == 'edit' || $mode == 'insert') {
                    echo '<button type="submit" id="submitBtn" name="save" value="' . $mode . '" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save</button>';
                  } ?>

                </div>
              </div><!-- /.box-footer -->
            </div>

          </div>
          <?php echo form_close(); ?>
        </div>
      </div><!-- /.box -->

    <?php
    } elseif ($set == "view") {
    ?>

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/voucher_lcr/add">
              <button class="btn bg-blue btn-flat margin"><i class="fa fa-plus"></i> Add New</button>
            </a>
            <a href="#" data-toggle="modal" data-target="#importData" class="btn bg-green btn-flat margin"> <i class="fa fa-upload"></i> Import Data
            </a>
            <a href="master/voucher_lcr/surat_pengantar">
              <button class="btn bg-blue btn-flat margin"><i class="fa fa-folder-open-o"></i> Surat Pengantar</button>
            </a>
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php
          if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
          ?>
            <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
              <strong><?php echo $_SESSION['pesan'] ?></strong>
              <button class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
            </div>
          <?php
          }
          $_SESSION['pesan'] = '';
          ?>
          <table id="datatable_server" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>ID</th>
                <th>Kode Voucher</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Nilai Voucher</th>
                <th>Qty</th>
                <th>Kode Dealer MD</th>
                <th>Nomor Surat</th>
                <th>Tgl Expired</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
          </table>

        </div><!-- /.box-body -->
      </div><!-- /.box -->

      <!-- Modal -->
      <div id="importData" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header alert-success">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Import Data Voucher</h4>
            </div>
            <div class="modal-body">
              <p style="text-align: right;">
                <a href="uploads/voucher_lcr/template_import_data_voucher.xlsx" target="_blank" class="btn btn-info btn-sm">Download Template</a>
              </p>
              <form action="master/voucher_lcr/proses_import" method="POST" enctype="multipart/form-data">

                <div class="form-group">
                  <label for="field-1" class="col-sm-4 control-label">Upload File</label>
                  <div class="col-sm-6">
                    <input type="file" class="form-control" id="importFile" name="import_file">
                  </div>
                </div>
                <br><br>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Upload</button>
              </form>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
    <?php
    } elseif ($set == 'add') { ?>
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/voucher_lcr">
              <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
            </a>
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="notification">

          </div>

          <?php echo form_open(base_url() . "master/voucher_lcr/save", array('class' => 'form-horizontal formsimpan')); ?>
          <div class="row">
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Periode</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="periode_filter" id="periode_filter" <?php if ($row['start_date']) { ?> value="<?= date("d/m/Y", strtotime($row['start_date'])) ?> - <?= date("d/m/Y", strtotime($row['end_date'])) ?>" <?php } ?> readonly>
                    <input id='periode_filter_start' name="periode_filter_start" value="<?= $row['start_date'] ?>" type="hidden" readonly>
                    <input id='periode_filter_end' name="periode_filter_end" type="hidden" value="<?= $row['end_date'] ?>" readonly>
                  </div>
                  <script>
                    $('#periode_filter').daterangepicker({
                      opens: 'left',
                      autoUpdateInput: false,
                      locale: {
                        format: 'DD/MM/YYYY'
                      }
                    }, function(start, end, label) {
                      $('#periode_filter_start').val(start.format('YYYY-MM-DD'));
                      $('#periode_filter_end').val(end.format('YYYY-MM-DD'));
                    }).on('apply.daterangepicker', function(ev, picker) {
                      $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                    }).on('cancel.daterangepicker', function(ev, picker) {
                      $(this).val('');
                      $('#periode_filter_start').val('');
                      $('#periode_filter_end').val('');
                    });
                  </script>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="tableFixHead">
                      <table id="tableDetail" class="table table-condensed table-responsive">
                        <thead>
                          <tr>
                            <!-- <th><input type="checkbox" class="minimal-red"></th> -->
                            <th>Kode Voucher</th>
                            <th>Nilai Voucher</th>
                            <th style="width: 15%;">Qty</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="tBody">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <button type="button" id="btnAddRow" class="pull-right btn btn-flat btn-info btn-sm"><i class="fa fa-plus"></i></button>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-footer">
                <div align="center">
                  <button type="submit" id="submitBtn" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save</button>
                </div>
              </div><!-- /.box-footer -->
            </div>

          </div>
          <?php echo form_close(); ?>
        </div>
      </div><!-- /.box -->
    <?php } else if ($set == 'surat_pengantar') {
    ?>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/voucher_lcr">
              <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> Voucher LCR</button>
            </a>
            <a href="master/voucher_lcr/add_surat_pengantar">
              <button class="btn bg-blue btn-flat margin"><i class="fa fa-plus"></i> Add New</button>
            </a>

          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <?php
          if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') {
          ?>
            <div class="alert alert-<?php echo $_SESSION['tipe'] ?> alert-dismissable">
              <strong><?php echo $_SESSION['pesan'] ?></strong>
              <button class="close" data-dismiss="alert">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
              </button>
            </div>
          <?php
          }
          $_SESSION['pesan'] = '';
          ?>
          <table id="datatable_surat" class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>No</th>
                <th>Nomor Surat</th>
                <th>Nama Dealer</th>
                <th>Jumlah Voucher</th>
                <th>Tgl Penyerahan</th>
                <!-- <th>Tgl Diterima</th> -->
                <th>Aksi</th>
              </tr>
            </thead>
          </table>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    <?php
    } else if ($set == 'add_surat_pengantar') { ?>
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/voucher_lcr/surat_pengantar">
              <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
            </a>
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div id="notification">

          </div>

          <?php echo form_open(base_url() . "master/voucher_lcr/save_surat_pengantar", array('class' => 'form-horizontal formsimpansurat')); ?>
          <div class="row">
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nomor Surat </label>
                  <div class="col-sm-8">
                    <input type="text" name="no_surat" value="<?= $no_surat ?>" class="form-control" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Nama Dealer </label>
                  <div class="col-sm-8">
                    <select name="kode_dealer_md" id="kode_dealer_md" class="form-control select2" required>
                      <option value="">-choose-</option>
                      <?php
                      foreach ($dealer as $dl) {
                        if ($dl['id_dealer'] == $row['id_dealer']) {
                          echo '<option selected value="' . $dl['id_dealer'] . '">' . $dl['kode_dealer_md'] . ' - ' . $dl['nama_dealer'] . '</option>';
                        } else {
                          echo '<option value="' . $dl['id_dealer'] . '">' . $dl['kode_dealer_md'] . ' - ' . $dl['nama_dealer'] . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-body">
                <div class="form-group">
                  <div class="col-sm-12">
                    <div class="tableFixHead">
                      <table id="tableDetail" class="table table-condensed table-responsive">
                        <thead>
                          <tr>
                            <th>Kode Voucher</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody id="tBodySurat">
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12">
                    <button type="button" id="btnAddRowSurat" class="pull-right btn btn-flat btn-info btn-sm"><i class="fa fa-plus"></i></button>

                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="box-footer">
                <div align="center">
                  <button type="submit" id="submitBtn" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save</button>
                </div>
              </div><!-- /.box-footer -->
            </div>

          </div>
          <?php echo form_close(); ?>
        </div>
      </div><!-- /.box -->
    <?php } ?>
  </section>
</div>

<script>
  function tampildata() {
    // ini data voucher lcr
    let table = $('#datatable_server').DataTable({
      // responsive: true,
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?= base_url('/master/voucher_lcr/ambildata') ?>",
        dataSrc: "data",
        type: "POST",
        data: function(data) {}
      },
      columns: [{
          data: null,
          sortable: false,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1
          },
        }, {
          data: 'id',
        },
        {
          data: 'kode_voucher'
        },
        {
          data: 'start_date'
        },
        {
          data: 'end_date'
        },
        {
          data: 'nilai_voucher'
        },
        {
          data: 'qty'
        },
        {
          data: 'kode_dealer_md'
        },
        {
          data: 'no_surat'
        },
        {
          data: 'expired_date'
        },
        {
          data: 'nama_customer',
        },
        {
          data: 'status',
        },
        {
          data: 'action',
          orderable: false,
          width: '3%',
          className: 'text-center'
        },
      ],
      columnDefs: [{
        targets: '_all',
        render: function(data, type, row) {
          if (type === 'display') {
            if (isNaN(data) && moment(data, 'YYYY-MM-DD', true).isValid()) {
              return moment(data).format('MM/DD/YYYY');
            }
          }
          return data;
        }
      }, {
        "targets": [1],
        "visible": false,
        "searchable": false
      }],
      order: [
        [1, 'desc']
      ]
    });
  }

  function tampildatasurat() {
    // ini data surat pengantar
    let table = $('#datatable_surat').DataTable({
      // responsive: true,
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?= base_url('/master/voucher_lcr/ambildatasurat') ?>",
        dataSrc: "data",
        type: "POST",
        data: function(data) {}
      },
      columns: [{
          data: null,
          sortable: false,
          render: function(data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1
          },
        },
        {
          data: 'no_surat'
        },
        {
          data: 'nama_dealer'
        },
        {
          data: 'jml_voucher'
        },
        {
          data: 'tgl_penyerahan',
        },
        // {
        //   data: 'tgl_terima_dealer',
        // },
        {
          data: 'action',
          orderable: false,
          width: '3%',
          className: 'text-center'
        },
      ],

      order: [
        [1, 'desc']
      ]
    });
  }

  $(document).ready(function() {
    <?php if ($set == 'view'): ?>
      tampildata();
    <?php endif; ?>
    <?php if ($set == 'surat_pengantar'): ?>
      tampildatasurat();
    <?php endif; ?>
    // INI UNTUK JQUERY KODE VOUCHER
    let count = 1;
    $('#btnAddRow').on('click', function() {
      addRow();
      $('#kode_voucher-' + count).focus();
      count++;
    });
    $(document).on('keypress', function(e) {
      if (e.which == 13) {
        addRow();
        $('#kode_voucher-' + count).focus();
        count++;
      }
    });

    function addRow() {
      let dynamicRowHTML = `
      <tr class="remove">
				<td><input type="text" style="text-transform:uppercase" name="kode_voucher[]" id="kode_voucher-` + count + `" data-id="` + count + `"  class="form-control harga-` + count + `" required></td>
				<td><input type="number" min="0"  name="nilai_voucher[]" id="nilai_voucher-` + count + `" data-id="` + count + `" class="form-control " ></td>
				<td><input type="number" min="0" name="qty[]" id="qty-` + count + `" data-id="` + count + `" class="form-control"></td>
				<td><a href="javascript:void(0)" class="removeBtn btn btn-danger" >Remove</a></td>
			</tr>`;
      $('#tBody').append(dynamicRowHTML);
    }
    $(document).on("click", ".removeBtn", function() {
      $(this).closest("tr").remove();
      var sum_value = 0;
      $('.value').each(function() {
        sum_value += +$(this).val();
        $('#total').val(sum_value);
      });
    });
    $('.formsimpan').submit(function(e) {
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
          console.log(response);
          console.log(response.failed);
          if (response.failed == 1) {
            let HTMLnotification = `
            <div class="alert alert-info" >
             <button class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>  
                </button>
              <h4 class="alert-heading">Kode Voucher LCR dibawah sudah pernah terpakai :</h4>
              <hr>
              <p>` + response.datavalidasi + `</p>
             
            </div>
            `;
            $('#notification').append(HTMLnotification);
          } else if (response.failed == 2) {
            let HTMLnotification = `
            <div class="alert alert-warning" >
             <button class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>  
                </button>
              <h4 class="alert-heading">Kode Voucher LCR Duplicate :</h4>
              <hr>
              <p>` + response.dataduplicate + `</p>
            </div>
            `;
            $('#notification').append(HTMLnotification);
          }
          if (response.failed == 3) {
            let HTMLnotification = `
            <div class="alert alert-danger alert-dismissable">
                <strong>Voucher LCR gagal disimpan, periksa kembali data inputan</strong>
                <button class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>  
                </button>
            </div>`;
            $('#notification').append(HTMLnotification);
          }
          if (response.success) {
            window.location = "master/voucher_lcr";
          }

        }
      });
      return false;
    });
    // END VOUCHER


    // INI UNTUK JQUERY SURAT PENGANTAR
    let counts = 1;
    $('#btnAddRowSurat').on('click', function() {
      addRowSurat();
      $('#kode_voucher-' + counts).focus();
      counts++;
    });
    $(document).on('keypress', function(e) {
      if (e.which == 13) {
        addRowSurat();
        $('#kode_voucher-' + counts).focus();
        counts++;
      }
    });

    function addRowSurat() {
      let dynamicRowHTML = `
      <tr class="remove">
				<td><input type="text" style="text-transform:uppercase" name="kode_voucher[]" id="kode_voucher-` + counts + `" data-id="` + counts + `"  class="form-control harga-` + counts + `" required></td>
				<td><a href="javascript:void(0)" class="removeBtnSurat btn btn-danger" >Remove</a></td>
			</tr>`;
      $('#tBodySurat').append(dynamicRowHTML);
    }
    $(document).on("click", ".removeBtnSurat", function() {
      $(this).closest("tr").remove();
      var sum_value = 0;
      $('.value').each(function() {
        sum_value += +$(this).val();
        $('#total').val(sum_value);
      });
    });
    $('.formsimpansurat').submit(function(e) {
      $.ajax({
        type: "post",
        url: $(this).attr('action'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
          console.log(response);
          console.log(response.failed);
          if (response.failed == 1) {
            // input data duplicate query
            let HTMLnotification = `
            <div class="alert alert-danger" >
             <button class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>  
                </button>
              <h4 class="alert-heading">Kode Voucher Duplicate :</h4>
              <hr>
              <p>` + response.dataDuplicate + `</p>
            </div>
            `;
            $('#notification').append(HTMLnotification);
          } else if (response.failed == 2) {
            // tidak ada didalam database atau status selain new
            let HTMLnotification = `
            <div class="alert alert-danger" >
             <button class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>  
                </button>
              <h4 class="alert-heading">Kode Voucher tidak ditemukan atau sudah pernah dipakai:</h4>
              <hr>
              <p>` + response.dataValidasiDB + `</p>
            </div>
            `;
            $('#notification').append(HTMLnotification);
          } else if (response.failed == 3) {
            let HTMLnotification = `
            <div class="alert alert-danger alert-dismissable">
                <strong>Surat Pengantar gagal disimpan, hubungi IT untuk melanjutkan</strong>
                <button class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>  
                </button>
            </div>`;
            $('#notification').append(HTMLnotification);
          }
          if (response.success) {
            window.location = "master/voucher_lcr/surat_pengantar";
          }

        }
      });
      return false;
    });
    // END SURAT PENGANTAR
  });
</script>