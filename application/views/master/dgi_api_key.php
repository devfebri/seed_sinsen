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
      if ($mode == 'insert') {
        $form = 'save';
      }
      if ($mode == 'setting') {
        $form = 'save';
      }
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
            <a href="master/dgi_api_key">
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
          <div class="row">
            <div class="col-md-12">
              <form id="form_" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">ID Dealer</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="id_dealer" id="id_dealer" autocomplete="off" value="<?= isset($row) ? $row->id_dealer : '' ?>" readonly required onclick="showModalDealer()">
                      </div>
                    </div>
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Nama dealer</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="nama_dealer" id="nama_dealer" autocomplete="off" value="<?= isset($row) ? $row->nama_dealer : '' ?>" readonly required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">API Key</label>
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="api_key" id="api_key" autocomplete="off" value="<?= isset($row) ? $row->api_key : '' ?>" readonly required>
                      </div>
                    </div>
                    <div class="form-ipnut">
                      <label for="inputEmail3" class="col-sm-2 control-label">Secret Key</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control" name="secret_key" id="secret_key" autocomplete="off" value="<?= isset($row) ? $row->secret_key : '' ?>" readonly required>
                      </div>
                    </div>
                    <div class="col-sm-1">
                      <button type='button' class='btn btn-primary btn-flat' id='btnGenerate' onclick='generateKey()'><i class='fa fa-refresh'></i></button>
                    </div>
                  </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  <div class="col-sm-12" align="center" v-if="mode=='insert' || mode=='edit'">
                    <button type="button" id="submitBtn" name="save" value="save" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save</button>
                  </div>
                </div><!-- /.box-footer -->
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.box -->
      <?php
      $data['data'] = ['modalDealer'];
      $this->load->view('dealer/h2_api', $data); ?>
      <script>
        function pilihDealer(params) {
          $('#id_dealer').val(params.kode_dealer_md)
          $('#nama_dealer').val(params.nama_dealer)
        }
        var form_ = new Vue({
          el: '#form_',
          data: {
            mode: '<?= $mode ?>',
          },
          methods: {

          }
        })

        function generateKey() {
          values = {
            id_dealer: $('#id_dealer').val()
          }
          $.ajax({
            beforeSend: function() {
              $('#btnGenerate').attr('disabled', true);
              $('#btnGenerate').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            url: '<?= base_url('master/dgi_api_key/generateKey') ?>',
            type: "POST",
            data: values,
            cache: false,
            dataType: 'JSON',
            success: function(response) {
              $('#btnGenerate').html('<i class="fa fa-refresh"></i>');
              $('#btnGenerate').attr('disabled', false);
              if (response.status == 'sukses') {
                $('#api_key').val(response.data.api_key);
                $('#secret_key').val(response.data.secret_key);
              } else {
                $('#btnGenerate').attr('disabled', false);
                alert(response.pesan);
              }
            },
            error: function() {
              alert("failure");
              $('#btnGenerate').attr('disabled', false);

            }
          });
        }

        $('#submitBtn').click(function() {
          $('#form_').validate({
            rules: {
              'checkbox': {
                required: true
              }
            },
            highlight: function(input) {
              $(input).parents('.form-input').addClass('has-error');
            },
            unhighlight: function(input) {
              $(input).parents('.form-input').removeClass('has-error');
            }
          })
          var values = {};
          var form = $('#form_').serializeArray();
          for (field of form) {
            values[field.name] = field.value;
          }
          if ($('#form_').valid()) // check if form is valid
          {

            if (confirm("Apakah anda yakin ?") == true) {
              $.ajax({
                beforeSend: function() {
                  $('#submitBtn').attr('disabled', true);
                  $('#submitBtn').html('<i class="fa fa-spinner fa-spin"></i> Process');
                },
                url: '<?= base_url('master/dgi_api_key/' . $form) ?>',
                type: "POST",
                data: values,
                cache: false,
                dataType: 'JSON',
                success: function(response) {
                  $('#submitBtn').html('<i class="fa fa-save"></i> Save');
                  if (response.status == 'sukses') {
                    window.location = response.link;
                  } else {
                    $('#submitBtn').attr('disabled', false);
                    alert(response.pesan);
                  }
                },
                error: function() {
                  alert("failure");
                  $('#submitBtn').attr('disabled', false);

                },
                statusCode: {
                  500: function() {
                    alert('fail');
                    $('#submitBtn').attr('disabled', false);

                  }
                }
              });
            } else {
              return false;
            }
          } else {
            alert('Silahkan isi field required !')
          }
        })
      </script>

    <?php
    } elseif ($set == "form_setting") {
    ?>
     <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/dgi_api_key">
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
          <div class="row">
            <div class="col-md-12">
              <form id="form_" class="form-horizontal" action="master/dgi_api_key/saveDealerGroupDetail" method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group">
                      <label for="field-1" class="col-sm-2 control-label">Dealer Group *</label>            
                      <div class="col-sm-3">
                        <select name="dealer_group" id="dealer_group" class="form-control" required>
													<option value="">Pilih Dealer Group</option>
													<option value="Astra">Astra</option>
													<option value="NSS">NSS</option>
													<option value="Patria">Patria</option>
													<option value="TDM">TDM</option>
													<option value="Daya">Daya</option>
												</select>
                      </div>                  
                    </div>
                  <div class="form-group">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">API Key</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control" name="api_key_group" id="api_key_set" autocomplete="off" value="<?= isset($row) ? $row->api_key : '' ?>" readonly required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-ipnut">
                      <label for="inputEmail3" class="col-sm-2 control-label">Secret Key</label>
                      <div class="col-sm-3">
                        <input type="text" class="form-control" name="secret_key_group" id="secret_key_set" autocomplete="off" value="<?= isset($row) ? $row->secret_key : '' ?>" readonly required>
                      </div>
                    </div>
                    <div class="col-sm-1">
                      <button type='button' class='btn btn-primary btn-flat' id='btnGenerate_set' onclick='generateKeySetting()'><i class='fa fa-refresh'></i></button>
                    </div>
                  </div>
                  <div class="form-group">
                      <div class="form-input">
                          <label for="inputEmail3" class="col-sm-2 control-label">ID Dealer</label>
                          <div class="col-sm-3">
                              <input type="text" class="form-control" name="id_dealer" id="id_dealer_group" autocomplete="off" value="<?= isset($row) ? $row->id_dealer : '' ?>" readonly required onclick="showModalDealer()">
                          </div>
                      </div>
                      <div class="form-input">
                          <label for="inputEmail3" class="col-sm-2 control-label">Nama dealer</label>
                          <div class="col-sm-3">
                              <input type="text" class="form-control" name="nama_dealer_group" id="nama_dealer_group" autocomplete="off" value="<?= isset($row) ? $row->nama_dealer : '' ?>" readonly required>
                          </div>
                      </div>
                      <div class="form-input">
                          <div class="col-sm-1">
                              <button type="button" class="btn btn-primary btn-block" id="tambah"><i class="fa fa-plus"></i></button>
                          </div>
                      </div>
                  </div>
                
                <!-- /.form-group -->
                </div><!-- /.box-body -->
                <button class="btn btn-block btn-info btn-flat" disabled> DETAIL DEALER </button>
                <br>
                <table class="table table-bordered" id="detailDealer">
                    <thead>
                        <tr>
                            <td width="10%">Kode Dealer</td>
                            <td width="25%">Nama Dealer</td>
                            <td width="25%">Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <div class="box-footer">
                  <div class="col-sm-12" align="center">
                  <button type="submit" name="save" value="save" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save</button>
                  </div>
                </div><!-- /.box-footer -->
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.box -->
      <?php
      $data['data'] = ['modalDealer'];
      $this->load->view('dealer/h2_api', $data); ?>
      <script>
        // function pilihDealer(params) {
        //     $('#id_dealer').val(params.kode_dealer_md)
        //     $('#nama_dealer').val(params.nama_dealer)
        //   }
        function generateKeySetting() {
          $.ajax({
            beforeSend: function() {
              $('#btnGenerate_set').attr('disabled', true);
              $('#btnGenerate_set').html('<i class="fa fa-spinner fa-spin"></i>');
            },
            url: '<?= base_url('master/dgi_api_key/generateKey') ?>',
            type: "POST",
            // data: values,
            cache: false,
            dataType: 'JSON',
            success: function(response) {
              $('#btnGenerate_set').html('<i class="fa fa-refresh"></i>');
              $('#btnGenerate_set').attr('disabled', false);
              if (response.status == 'sukses') {
                $('#api_key_set').val(response.data.api_key);
                $('#secret_key_set').val(response.data.secret_key);
              } else {
                $('#btnGenerate_set').attr('disabled', false);
                alert(response.pesan);
              }
            },
            error: function() {
              alert("failure");
              $('#btnGenerate_set').attr('disabled', false);

            }
          });
        }
      </script>
      
      <script>
        function pilihDealer(params) {
            $('#id_dealer_group').val(params.kode_dealer_md);
            $('#nama_dealer_group').val(params.nama_dealer);
        }

        $(document).ready(function() {
            $('tfoot').hide();

            $(document).keypress(function(event) {
                if (event.which == 13) {
                    event.preventDefault();
                }
            });
        
                $(document).on('click', '#tambah', function(e) {
                e.preventDefault();
                
                const idDealer = $('#id_dealer_group').val();
                const namaDealer = $('#nama_dealer_group').val();

                if (idDealer && namaDealer) {
                  const newRow = `
                      <tr>
                          <td>${idDealer}</td>
                          <td>${namaDealer}</td>
                          <td><button type="button" class="btn btn-danger" onclick="removeDealer(this)">Remove</button></td>
                          <input type="hidden" name="dealers[][id_dealer]" value="${idDealer}">
                      </tr>
                  `;
                  $('#detailDealer tbody').append(newRow);
                  $('tfoot').show();
                  resetForm();
              } else {
                  alert('Silakan pilih dealer terlebih dahulu');
              }
            });
        });

        function removeDealer(button) {
            $(button).closest('tr').remove();
            if ($('table#detailDealer tbody tr').length == 0) {
                $('tfoot').hide();
            }
        }

        function resetForm() {
            $('#id_dealer').val('');
            $('#nama_dealer').val('');
        }

        function removeDealer(button) {
            $(button).closest('tr').remove();
            if ($('table#detailDealer tbody tr').length == 0) {
                $('tfoot').hide();
            }
        }
</script>
      
    <?php
    } elseif ($set == "view") {
    ?>

      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/dgi_api_key/add" class="btn bg-blue btn-flat margin"><i class="fa fa-plus"></i>&nbsp;&nbsp; Create New</a>
          </h3>
          <h3 class="box-title">
            <a href="master/dgi_api_key_group" class="btn bg-yellow btn-flat margin"><i class="fa fa-object-group" aria-hidden="true"></i>&nbsp;&nbsp; Dealer Group</a>
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
                <th>ID Dealer</th>
                <th>Nama Dealer</th>
                <th>API Key</th>
                <th>Secret Key</th>
                <th>Created Date</th>
                <th>Modified Date</th>
                <th>Active</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
          <script>
            $(document).ready(function() {
              var dataTable = $('#datatable_server').DataTable({
                "processing": true,
                "serverSide": true,
                "language": {
                  "infoFiltered": "",
                  "processing": "<p style='font-size:20pt;background:#d9d9d9b8;color:black;width:100%'><i class='fa fa-refresh fa-spin'></i></p>",
                },
                "order": [],
                "lengthMenu": [
                  [10, 25, 50, 75, 100],
                  [10, 25, 50, 75, 100]
                ],
                "ajax": {
                  url: "<?php echo site_url('master/dgi_api_key/fetch'); ?>",
                  type: "POST",
                  dataSrc: "data",
                  data: function(d) {
                    return d;
                  },
                },
                "columnDefs": [
                  // // { "targets":[2],"orderable":false},
                  {
                    "targets": [6, 7],
                    "className": 'text-center'
                  },
                  // // // { "targets":[0],"checkboxes":{'selectRow':true}}
                  // // { "targets":[4],"className":'text-right'}, 
                  // // // { "targets":[2,4,5], "searchable": false } 
                ],
              });
            });
          </script>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    <?php
    }
    ?>
  </section>
</div>