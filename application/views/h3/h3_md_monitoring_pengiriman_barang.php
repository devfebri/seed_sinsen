<script src="<?= base_url("assets/vue/qs.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/vue/axios.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/vue/vue.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/vue/accounting.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/vue/vue-numeric.min.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/panel/lodash.min.js") ?>"></script>
<script src="<?= base_url("assets/panel/humanize-duration.js") ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?= base_url("assets/panel/moment.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/panel/daterangepicker.min.js") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/panel/daterangepicker.css") ?>" />
<script>
  Vue.use(VueNumeric.default);
</script>
<base href="<?php echo base_url(); ?>" />

<body>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1><?= $title; ?></h1>
      <?= $breadcrumb ?>
    </section>
    <section class="content">

      <?php
      if ($set == 'index') {
      ?>
        <div class="box">
          <div class="box-body">
            <?php if ($this->input->get('history') != null) : ?>
              <a href="h3/<?= $isi ?>">
                <button class="btn bg-maroon btn-flat margin"><i class="fa fa-history"></i> Non-History</button>
              </a>
            <?php else : ?>
              <a href="h3/<?= $isi ?>?history=true">
                <button class="btn bg-maroon btn-flat margin"><i class="fa fa-history"></i> History</button>
              </a>
            <?php endif; ?>
            <a href="h3/<?= $isi ?>/excel">
              <button class="btn bg-yellow btn-flat margin"><i class="fa fa-download"></i> Excel</button>
            </a>
            <div class="container-fluid">
              <form class='form-horizontal'>
                <div class="row">
                  <!-- edit by febri : left-->
                  <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">Kode Customer</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input id='kode_customer_filter' type="text" class="form-control" disabled>
                          <input type="hidden" id="id_customer_filter">
                          <div class="input-group-btn">
                            <button class="btn btn-flat btn-primary" id='filter_customer_modal' type="button" data-toggle='modal' data-target='#h3_md_dealer_filter_monitoring_supply'><i class="fa fa-search"></i></button>
                            <button class="btn btn-flat btn-danger hidden" id='reset_filter_customer'><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $this->load->view('modal/h3_md_dealer_filter_monitoring_supply'); ?>
                    <script>
                      function pilih_dealer_filter_monitoring_supply(data) {
                        $('#nama_customer_filter').val(data.nama_dealer);
                        $('#kode_customer_filter').val(data.kode_dealer_md);
                        $('#id_customer_filter').val(data.id_dealer);
                        // $('#kabupaten_customer_filter').val(data.kabupaten);

                        $('#filter_customer_modal').addClass('hidden');
                        $('#reset_filter_customer').removeClass('hidden');

                        monitoring_supply_do.draw();
                        h3_md_dealer_filter_monitoring_supply_datatable.draw();
                      }

                      $(document).ready(function() {
                        $('#reset_filter_customer').click(function(e) {
                          e.preventDefault();

                          $('#nama_customer_filter').val('');
                          $('#kode_customer_filter').val('');
                          $('#id_customer_filter').val('');
                          // $('#kabupaten_customer_filter').val('');

                          $('#filter_customer_modal').removeClass('hidden');
                          $('#reset_filter_customer').addClass('hidden');

                          monitoring_supply_do.draw();
                          h3_md_dealer_filter_monitoring_supply_datatable.draw();
                        })
                      });
                    </script>

                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">Nama Customer</label>
                      <div class="col-sm-8">
                        <input id='nama_customer_filter' type="text" class="form-control" disabled>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">Kabupaten Customer</label>
                      <div class="col-sm-8">
                        <!-- <input type="text" class="form-control" id="kabupaten_customer_filter" readonly> -->
                        <div class="input-group">
                          <input id='nama_kabupaten_filter' type="text" class="form-control" disabled>
                          <input id='id_kabupaten_filter' type="hidden" disabled>
                          <div class="input-group-btn">
                            <button class="btn btn-flat btn-primary" type="button" data-toggle='modal' data-target='#h3_md_kabupaten_filter_monitoring_supply'>
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <?php $this->load->view('modal/h3_md_kabupaten_filter_monitoring_supply'); ?>
                      <script>
                        function pilih_kabupaten_filter_monitoring_supply(data, type) {
                          if (type == 'add_filter') {
                            $('#nama_kabupaten_filter').val(data.kabupaten);
                            $('#id_kabupaten_filter').val(data.id_kabupaten);
                          } else if (type == 'reset_filter') {
                            $('#nama_kabupaten_filter').val('');
                            $('#id_kabupaten_filter').val('');
                          }
                          monitoring_supply_do.draw();
                          h3_md_kabupaten_filter_monitoring_supply_datatable.draw();
                        }
                      </script>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">Wilayah</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input id='nama_wilayah_filter' type="text" class="form-control" disabled>
                          <input id='id_wilayah_filter' type="hidden" disabled>
                          <div class="input-group-btn">
                            <button class="btn btn-flat btn-primary" type="button" data-toggle='modal' data-target='#h3_md_wilayah_filter_monitoring_supply'>
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $this->load->view('modal/h3_md_wilayah_filter_monitoring_supply'); ?>
                    <script>
                      function pilih_wilayah_filter_monitoring_supply(data, type) {
                        if (type == 'add_filter') {
                          $('#nama_wilayah_filter').val(data.daerah_h3);
                          $('#id_wilayah_filter').val(data.id_daerah);
                        } else if (type == 'reset_filter') {
                          $('#nama_wilayah_filter').val('');
                          $('#id_wilayah_filter').val('');
                        }
                        monitoring_supply_do.draw();
                        h3_md_wilayah_filter_monitoring_supply_datatable.draw();
                      }
                    </script>

                  </div>

                  <div class="col-sm-12 col-lg-6">
                    <div class="form-group">
                      <label class="control-label col-sm-4 no-padding-x">Periode Sales</label>
                      <div class="col-sm-8">
                        <input id='periode_po_filter' type="text" class="form-control" readonly>
                        <input id='periode_po_filter_start' type="hidden" disabled>
                        <input id='periode_po_filter_end' type="hidden" disabled>
                      </div>
                      <script>
                        $('#periode_po_filter').daterangepicker({
                          opens: 'left',
                          autoUpdateInput: false,
                          locale: {
                            format: 'DD/MM/YYYY'
                          }
                        }, function(start, end, label) {
                          $('#periode_po_filter_start').val(start.format('YYYY-MM-DD'));
                          $('#periode_po_filter_end').val(end.format('YYYY-MM-DD'));
                          monitoring_supply_do.draw();
                        }).on('apply.daterangepicker', function(ev, picker) {
                          $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                        }).on('cancel.daterangepicker', function(ev, picker) {
                          $(this).val('');
                          $('#periode_po_filter_start').val('');
                          $('#periode_po_filter_end').val('');
                          monitoring_supply_do.draw();
                        });
                      </script>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">No DO</label>
                      <div class="col-sm-8">
                        <input id='no_do_filter' type="text" class="form-control">
                      </div>
                      <script>
                        $(document).ready(function() {
                          $('#no_do_filter').on("keyup", _.debounce(function() {
                            monitoring_supply_do.draw();
                          }, 500));
                        });
                      </script>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">Status</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input id="status" type="text" class="form-control" placeholder="0 Status" disabled>
                          <div class="input-group-btn">
                            <button class="btn btn-flat btn-primary" type="button" id="btnModalStatus">
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                      <?php $this->load->view('modal/h3_md_status_filter_monitoring_pengiriman_barang_index'); ?>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">Kelompok Barang</label>
                      <div class="col-sm-8">
                        <select id="kelompok_barang_filter" class="form-control">
                          <option value="">-Pilih-</option>
                          <option value="Parts">Parts</option>
                          <option value="Oil">Oil</option>
                          <option value="Acc">Accesories</option>
                          <option value="Apparel">Apparel</option>
                          <option value="Tools">Tools</option>
                          <option value="Other">Other</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4 align-middle">Leadtime</label>
                      <div class="col-sm-8">
                        <div class="input-group">
                          <input id='leadtime_filter' type="hidden" class="form-control" disabled>
                          <input id='leadtime_filter_show' type="text" class="form-control" disabled>
                          <div class="input-group-btn">
                            <button class="btn btn-flat btn-primary" type="button" data-toggle='modal' data-target='#h3_md_leadtime_filter_monitoring_supply'>
                              <i class="fa fa-search"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $this->load->view('modal/h3_md_leadtime_filter_monitoring_supply'); ?>
                    <script>
                      function pilih_leadtime_filter_monitoring_supply(data, type) {
                        if (type == 'add_filter') {
                          // alert(data.leadtime);
                          $('#leadtime_filter').val(parseInt(data.leadtime));
                          if (data.leadtime == 99) {
                            $('#leadtime_filter_show').val(0);
                          } else if (data.leadtime == 30) {
                            $('#leadtime_filter_show').val('>30');
                          } else {
                            $('#leadtime_filter_show').val(parseInt(data.leadtime));
                          }
                        } else if (type == 'reset_filter') {
                          $('#leadtime_filter').val('');
                          $('#leadtime_filter_show').val('');
                        }
                        monitoring_supply_do.draw();
                        h3_md_leadtime_filter_monitoring_supply_datatable.draw();
                      }
                    </script>
                  </div>

                </div>

              </form>
            </div>
            <table id="monitoring_supply_do" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Customer</th>
                  <th>Kode Customer</th>
                  <th>Wilayah</th>
                  <th>Kabupaten</th>
                  <th>Kelompok Barang</th>
                  <th>No. DO</th>
                  <th>Tgl DO</th>
                  <th>No. PL</th>
                  <th>Tgl PL</th>
                  <th>Tgl Scan PL</th>
                  <th>No. PS</th>
                  <th>Tgl PS</th>
                  <th>No. Faktur</th>
                  <th>Tgl Faktur</th>
                  <th>No. Surat Jalan</th>
                  <th>Ekspedisi</th>
                  <th>Tgl Kirim</th>
                  <th>Tgl Terima</th>
                  <th>Status Barang</th>
                  <th>Lead Times (Hari)</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
            <script>
              $(document).ready(function() {

                //! febri : searching status
                function empty(array) {
                  array.length = 0;
                }
                var status_filter = []
                $('.status_filter').click(function() {
                  empty(status_filter);
                  let jmldata = $('.status_filter:checked');
                  if (jmldata.length === 0) {
                    monitoring_supply_do.draw();
                    $('#status').val('0 Status');
                  } else {
                    $(jmldata).each(function(i) {
                      status_filter[i] = this.value;
                    });
                    monitoring_supply_do.draw();
                    $('#status').val(jmldata.length + ' Status');
                  }

                });
                $('#btnModalStatus').click(function() {
                  $('#h3_md_status_filter_monitoring_pengiriman_barang_index').modal('show');

                });
                //! febri : end

                //! febri : filter kelompok barang
                $('#kelompok_barang_filter').on('change', function() {
                  monitoring_supply_do.draw();
                });
                //! febri : end



                monitoring_supply_do = $('#monitoring_supply_do').DataTable({

                  processing: true,
                  serverSide: true,
                  searching: false,
                  ordering: false,
                  scrollX: true,
                  order: [],
                  ajax: {
                    url: "<?= base_url('api/md/h3/monitoring_supply_do') ?>",
                    dataSrc: "data",
                    type: "POST",
                    data: function(d) {
                      d.id_customer_filter = $('#id_customer_filter').val();
                      d.alamat_customer_filter = $('#alamat_customer_filter').val();
                      d.id_salesman_filter = $('#id_salesman_filter').val();
                      d.no_do_filter = $('#no_do_filter').val();
                      d.periode_po_filter_start = $('#periode_po_filter_start').val();
                      d.periode_po_filter_end = $('#periode_po_filter_end').val();
                      d.nama_wilayah_filter = $('#nama_wilayah_filter').val();
                      d.status_filter = status_filter;
                      d.kelompok_barang_filter = $('#kelompok_barang_filter').val();
                      d.leadtime_filter = $('#leadtime_filter').val();
                      d.history = <?= $this->input->get('history') != null ? '1' : '0' ?>;

                    }
                  },
                  columns: [{
                      data: 'index',
                      orderable: false,
                      width: '3%'
                    },
                    {
                      data: 'nama_dealer'
                    },
                    {
                      data: 'kode_dealer_md'
                    },
                    {
                      data: 'daerah_h3'
                    },
                    {
                      data: 'kabupaten'
                    },
                    {
                      data: 'produk'
                    },
                    {
                      data: 'id_do_sales_order'
                    },
                    {
                      data: 'tanggal_do'
                    },
                    {
                      data: 'id_picking_list'
                    },
                    {
                      data: 'tanggal_pl'
                    },
                    {
                      data: 'tanggal_scan_pl'
                    },
                    {
                      data: 'id_packing_sheet'
                    },
                    {
                      data: 'tanggal_ps'
                    },
                    {
                      data: 'no_faktur'
                    },
                    {
                      data: 'tanggal_faktur'
                    },
                    {
                      data: 'id_surat_pengantar'
                    },
                    {
                      data: 'nama_ekspedisi'
                    },
                    {
                      data: 'tanggal_sp'
                    },
                    {
                      data: 'tanggal_dealer_terima_barang'
                    },
                    {
                      data: 'status'
                    },
                    {
                      data: 'lead_times'
                    },
                  ],

                });
              });
            </script>
          </div><!-- /.box-body -->
        </div><!-- /.box -->

      <?php
      } elseif ($set == 'excel') {
      ?>

        <div class="box box-default">
          <div class="box-header with-border">
            <div class="row">
              <div class="col-md-12">
                <form class="form-horizontal" id="frm" method="post" action="h3/h3_md_monitoring_pengiriman_barang/downloadExcel" enctype="multipart/form-data">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Start Date</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control datepicker" name="start_date" value="<?= date('Y-m-d') ?>" id="tanggal1">
                      </div>
                      <label for="inputEmail3" class="col-sm-2 control-label">End Date</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control datepicker" name="end_date" value="<?= date('Y-m-d') ?>" id="tanggal2">
                      </div>
                    </div>

                    <!-- <div class="form-group">
                <div class="col-sm-2">
                    <button type="submit" name="process" value="excel" class="btn bg-maroon btn-block btn-flat"><i class="fa fa-download"></i> Download .xls</button>                                                      
                  </div>   
  		            <div class="col-sm-2">
                    <button type="submit" name="process" value="csv" class="btn bg-blue btn-block btn-flat"><i class="fa fa-download"></i> Download .csv</button>                                                      
                  </div>
                </div>              -->
                  </div><!-- /.box-body -->
                  <div class="modal-footer">
                    <div class="col-sm-12" align="center">
                      <button type="submit" name="process" value="excel" class="btn btn-success btn-flat"><i class="fa fa-download"></i> Download .xls</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div><!-- /.box -->


      <?php
      }
      ?>

    </section>
  </div>