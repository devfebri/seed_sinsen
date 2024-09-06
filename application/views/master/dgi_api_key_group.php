<base href="<?php echo base_url(); ?>" />
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="panel/home"><i class="fa fa-home"></i> Dashboard</a></li>
      <li class="">Master Data</li>
      <li class="">Promosi</li>
      <li class="active"><?php echo ucwords(str_replace("_", " ", $isi)); ?></li>
    </ol>
  </section>
  <section class="content">
      <div class="box-body">
      <?php 
      if($set=="insert"){
      ?>
<div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="master/dgi_api_key_group">
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
              <form id="form_" class="form-horizontal" action="master/dgi_api_key_group/saveDealerGroupDetail" method="post" enctype="multipart/form-data">
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
                  <div class="form-group">
                <label for="field-1" class="col-sm-2 control-label"></label>
                    <div class="col-sm-2">
                        <div id="label-switch" class="make-switch" data-on-label="<i class='entypo-check'></i>" data-off-label="<i class='entypo-cancel'></i>">
                            <input type="hidden" name="active" value="0">
                            <input type="checkbox" class="flat-red" name="active" value="1" checked>
                            Active
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
      </div>
      <?php
      $data['data'] = ['modalDealer'];
      $this->load->view('dealer/h2_api', $data); ?>
      <script>
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
</script>
<?php 
}elseif($set=="detail"){
    ?>
            <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <a href="master/dgi_api_key_group">
                            <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
                            </a>
                        </h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                        </div>
                        <?php if (!empty($detail)) { ?>
                            <h3>Dealer Group :&nbsp; <strong><?= $detail[0]->dealer_group ?></strong></h3>
                        <?php } ?>
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
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <!-- <th>ID Dealer INT</th> -->
                                    <th>Dealer Group</th>
                                    <th>ID Dealer</th>
                                    <th>API Key Group</th>
                                    <th>Secret Key Group</th>
                                    <th>Active</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($detail as $item) { ?>
                                    <tr>
                                        <!-- <td><?= $item->id_dealer_int ?></td> -->
                                        <td><?= $item->dealer_group ?></td>
                                        <td><?= $item->id_dealer ?></td>
                                        <td><?= $item->api_key_group ?></td>
                                        <td><?= $item->secret_key_group ?></td>
                                        <td>
                                            <?php if ($item->active == 1): ?>
                                                <i class="fa fa-check"></i>
                                            <?php else: ?>
                                                <i class="fa fa-remove"></i>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->
            </div>
          </div>
    <?php
    }elseif($set=="view"){
?>
        <div class="box">
                <div class="box-header with-border">
                    <div class="form-row align-items-center">
                        <div class="col-md-4 col-sm-12">
                          <form method="get" id="exportForm" action="<?= site_url('master/dgi_api_key_group/exportExcel'); ?>">
                                  <input type="text" id="searchInput" name="search" placeholder="Search Dealer Group..." class="form-control" autocomplete="off">
                          </form>
                            <div class="row-sm-4 row-md-3" style="margin-top:10px;">
                                   <a href="master/dgi_api_key">
                                        <button class="btn bg-red btn-flat margin"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp; Back</button>
                                    </a>
                                    <button class="btn bg-blue btn-flat margin" onClick="window.location.reload();"><i class="fa fa-refresh"></i>&nbsp;&nbsp; Refresh </button> 
                                    <a href="master/dgi_api_key_group/add">
                                        <button <?php echo $this->m_admin->set_tombol($id_menu,$group,"insert"); ?> class="btn bg-blue btn-flat margin"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add New</button>
                                    </a>   
                                    
                            </div>
                        </div>
                    </div>
                    <div class="box-tools pull-right"> 
                        <button id="searchButton" class="btn bg-blue" style="margin-top: 5px;"><i class="fa fa-search"></i>&nbsp;&nbsp; Search</button>                  
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
                <div class="table-responsive">
                  <table id="dataAPI" class="table table-bordered table-hover table-responsive">
                      <thead>
                          <tr>
                              <th>Dealer Group</th>
                              <th>API Key Group</th>
                              <th>Secret Key Group</th>
                              <th width="10%">Action</th>
                          </tr>
                      </thead>
                      <tbody>

                      </tbody>
                  </table>
                </div>
            </div><!-- /.box-body -->
        </div>
      </div>
<?php
}
?>
</section>
<script>
$(document).ready(function() {
    var table = $('#dataAPI').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "pageLength": 1000,
        // "lengthMenu": [10, 25, 50, 100],
        "ajax": {
            "url": "<?= base_url('master/dgi_api_key_group/jsonApiGroup') ?>",
            "type": "POST",
            "data": function(d) {
                d.search.value = $('#searchInput').val();
            },
            "error": function(xhr, error, code) {
                console.error('Data fetching error:', error);
            }
        },
        "columns": [
            { "data": 'dealer_group' },
            { "data": 'api_key_group' },
            { "data": 'secret_key_group' },
            { 
                "data": null,
                "render": function(data, type, row) {
                    return `<button class='detailBtn btn btn-primary' title='Detail Data' data-dealer-group='${data.dealer_group}'><i class='fa fa-eye'></i></button>`;
                }
            }
        ],
        // "order": [[0, 'asc']],
        // "rowGroup": {
        //     "dataSrc": 'dealer_group'
        // }
    });

    $('#searchButton').on('click', function () {
        table.ajax.reload();
    });

    $('#dataAPI').on('click', '.detailBtn', function() {
        var dealerGroup = $(this).data('dealer-group');
        window.location.href = '<?= base_url('master/dgi_api_key_group/detail/') ?>' + dealerGroup;
    });
});
</script>
</div>
