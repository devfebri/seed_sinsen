<script src="<?= base_url("assets/vue/qs.min.js") ?>" type="text/javascript"></script>
<style>
  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #3c8dbc;
  }
</style>
<base href="<?php echo base_url(); ?>" />
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
    <?= $breadcrumb ?>
  </section>
  <section class="content">

    <div class="box">
      <div class="box-header with-border">
        <div class="container-fluid no-padding">
          <div class="col-md-6">
            <button class="btn bg-blue btn-flat margin" id="btn-tambah"><i class="fa fa-plus"></i> Add New</button>

          </div>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table id="master_kelompok_part_produk" class="table table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kelompok Produk</th>
              <th style="width:60%;">Kelompok Barang</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div><!-- /.box-body -->
    </div><!-- /.box -->
    <div class="modal fade" id="modal-add-update">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Tambah Kelompok Part</h4>
          </div>
          <?php echo  form_open_multipart(base_url() . "h3/h3_md_ms_setting_kelompok_part/add", ['class' => 'formsimpan form-horizontal']); ?>
          <div class="modal-body">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-2 control-label">Kelompok Produk</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="kel_part_produk" id="kel_part_produk" required>
                <input type="hidden" class="form-control" name="id" id="id">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword3" class="col-sm-2 control-label">Kelompok Barang MDP</label>
              <div class="col-sm-10">
                <select class="form-control select2 kel_barang_mdp" multiple="multiple" name="kel_barang_mdp[]" style="width: 100%;">

                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
          <?php echo form_close() ?>
        </div>

      </div>

    </div>
  </section>
</div>

<script>
  function tampildata() {
    let master_kelompok_part_produk = $('#master_kelompok_part_produk').DataTable({
      responsive: true,
      destroy: true,
      processing: true,
      serverSide: true,
      order: [],
      ajax: {
        url: "<?= base_url('api/md/h3/master_kelompok_part_produk') ?>",
        type: "POST",
        data: function(d) {
          d.history = <?= $this->input->get('history') != null ? '1' : '0' ?>;
        }
      },
      createdRow: function(row, data, index) {
        $('td', row).addClass('align-middle');
      },
      columns: [{
          data: 'index',
          orderable: false,
          width: '3%'
        },
        {
          data: 'nama_kelompok_part_produk'
        },
        {
          data: 'kel_barang_mdp',
          orderable: false,
        },
        {
          data: 'action',
          width: '3%',
          orderable: false,
          className: 'text-center'
        },
      ],
    });
  }

  function edit(id) {
    $('#modal-add-update').modal('show');
    $.ajax({
      type: 'post',
      url: "<?= base_url('h3/h3_md_ms_setting_kelompok_part/edit') ?>",
      data: {
        id: id
      },
      dataType: "json",
      success: function(response) {

        $('#kel_part_produk').val(response.nama_kelompok_part_produk);
        $('#id').val(response.id_kelompok_part_produk);
        $('.kel_barang_mdp').val('').change();
        var arrayFromPHP = <?php echo json_encode($part->result()) ?>;
        let dataKelompok = '';

        $.each(response.data_fix, function(key, value) {
          // console.log(value);
          if (value.select == 'selected') {
            dataKelompok += '<option selected value="' + value.id_kelompok_part + '">' + value.id_kelompok_part + '</option>';
          } else {
            dataKelompok += '<option value="' + value.id_kelompok_part + '">' + value.id_kelompok_part + '</option>';
          }

        });
        $('.kel_barang_mdp').empty().append(dataKelompok);
      }
    });


  }
  $('#btn-tambah').on('click', function() {
    $('#id').val('');
    $('#kel_part_produk').val('');
    $('.kel_barang_mdp').val('').change();
    var arrayFromPHP = <?php echo json_encode($part->result()) ?>;
    let dataKelompok = '';
    $.each(arrayFromPHP, function(key, value) {
      dataKelompok += '<option value="' + value['id_kelompok_part'] + '">' + value['id_kelompok_part'] + '</option>';
    });
    $('.kel_barang_mdp').empty().append(dataKelompok);
    $('#modal-add-update').modal('show');
  });


  $(document).ready(function() {
    tampildata();

    $('.formsimpan').submit(function(e) {
      // alert($('.kel_barang_mdp').val());

      $.ajax({
        type: 'POST',
        url: $(this).attr('action'),
        data: new FormData(this),
        dataType: "json",
        contentType: false,
        cache: false,
        processData: false,
        success: function(response) {
          tampildata();
          $('#modal-add-update').modal('hide');
        },
        error: function(xhr, ajaxOptions, thrownError) {
          alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
      });
      return false;
    })
  })
</script>