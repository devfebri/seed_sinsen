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
    if ($set == "view") {
    ?>

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">

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
    } else if ($set == 'detail') {
    ?>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="dealer/voucher_lcr_d">
              <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
            </a>
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <form class="form-horizontal">
            <div class="box-body">
              <div class="form-group">
                <label for="field-1" class="col-sm-4 control-label">Nomor Surat</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" disabled value="<?= $header->no_surat ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="field-1" class="col-sm-4 control-label">Nama Dealer</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" disabled value="<?= $header->nama_dealer ?>">
                </div>
              </div>
              <?php
                $tgl_assign = $header->tgl_assign_dealer;
              if ($tgl_assign) {
                $newDateAssign = date("d/m/Y H:i:s", strtotime($tgl_assign));
              } else {
                $newDateAssign = '';
              }
              $tgl_terima = $header->tgl_terima_dealer;
                if($tgl_terima){
                  $newDateTerima = date("d/m/Y H:i:s", strtotime($tgl_terima));
                }else{
                  $newDateTerima='';
                }
              ?>
              <div class="form-group">
                <label for="field-1" class="col-sm-4 control-label">Tanggal Penyerahan Dealer</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" disabled value="<?= $newDateAssign ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="field-1" class="col-sm-4 control-label">Tanggal Terima Dealer</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" disabled value="<?= $newDateTerima ?>">
                </div>
              </div>
            </div>
          </form>

        </div>
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
                <th>Status</th>
                <!-- <th>Aksi</th> -->
              </tr>
            </thead>
          </table>

        </div><!-- /.box-body -->
      </div><!-- /.box -->
    <?php
    } ?>
  </section>
</div>

<script>
  function tampildatasurat() {
    // ini data voucher lcr
    let table = $('#datatable_surat').DataTable({
      // responsive: true,
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?= base_url('/dealer/voucher_lcr_d/ambildatasurat') ?>",
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

  function tampildata() {
    // ini data voucher lcr
    let table = $('#datatable_server').DataTable({
      // responsive: true,
      scrollX: true,
      processing: true,
      serverSide: true,
      ajax: {
        url: "<?= base_url('/dealer/voucher_lcr_d/ambildata') ?>",
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
          data: 'status',
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


  $(document).ready(function() {
    <?php if ($set == 'detail'): ?>
      tampildata();
    <?php endif; ?>
    <?php if ($set == 'view'): ?>
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