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


<!-- save -->
<div class="box box-default"><!-- /.box1 -->
  <div class="box-header with-border"><!-- /.box-header -->
    <h3 class="box-title">
      <a href="master/event_lokasi">
        <button <?php echo $this->m_admin->set_tombol($id_menu,$group,"select"); ?> class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
      </a>
    </h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body"><!-- /.box3 -->
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

    <!-- form save -->
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" action="master/event_lokasi/save" method="post" enctype="multipart/form-data">
                <div class="box-body">          

                        <input type="hidden" readonly name="id_spot_btl" id="id_spot_btl">     

                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Spot BTL</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Lokasi Event" name="spot_btl" required autocomplete="off">
                          </div>  
                          <label for="inputEmail3" class="col-sm-2 control-label">Kelurahan Domisili</label>
                          <div class="col-sm-4">
                            <input type="hidden" readonly name="id_kelurahan" id="id_kelurahan">
                            <input required type="text" onpaste="return false" onkeypress="return nihil(event)" name="kelurahan" data-toggle="modal" placeholder="Kelurahan Domisili" data-target="#Kelurahanmodal" class="form-control" id="kelurahan" onchange="take_kec()" autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Alamat</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Alamat Lokasi" name="alamat" id="alamat" required autocomplete="off">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Provinsi Domisili</label>
                          <div class="col-sm-4">
                            <input type="hidden" name="id_provinsi" id="id_provinsi">
                            <input type="text" class="form-control" readonly placeholder="Provinsi Domisili" id="provinsi" name="provinsi" required>
                          </div>  
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Kota/Kabupaten Domisili</label>
                          <div class="col-sm-4">
                          <input type="hidden" name="id_kabupaten" id="id_kabupaten">
                          <input type="text" class="form-control" readonly placeholder="Kota/Kabupaten Domisili" id="kabupaten" name="kabupaten" required>
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Kecamatan Domisili</label>
                          <div class="col-sm-4">
                            <input type="hidden" name="id_kecamatan" id="id_kecamatan">
                            <input type="text" class="form-control" readonly id="kecamatan" placeholder="Kecamatan Domisili" name="kecamatan" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label label for="inputEmail3" class="col-sm-2 control-label">Latitude *</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Latitude" name="latitude" required autocomplete="off">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">Start Date *</label>
                          <div class="col-sm-4">
                            <input type="date" class="form-control" placeholder="Start Date" name="start_date" id="startDate" required>
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Longitude *</label>
                          <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Longitude" name="longitude" required autocomplete="off">
                          </div>
                          <label for="inputEmail3" class="col-sm-2 control-label">End Date *</label>
                          <div class="col-sm-4">
                            <input type="date" class="form-control" placeholder="End Date" name="end_date" id="endDate" required>
                          </div>
                    </div>        
                    <div class="form-group">
                      <label for="field-1" class="col-sm-2 control-label">Status Location *</label>            
                      <div class="col-sm-2">
                        <select name="status" id="status" class="form-control">
													<option value="">Pilih Status</option>
													<option value="1">Public Area</option>
													<option value="2">Mall</option>
													<option value="3">Pasar</option>
													<option value="4">SPBU</option>
													<option value="5">Minimarket</option>
													<option value="6">Bank</option>
													<option value="7">Instansi</option>
												</select>
                      </div>                  
                    </div>
                    <div class="form-group">
                      <label for="field-1" class="col-sm-2 control-label"></label>            
                      <div class="col-sm-2">
                        <div id="label-switch" class="make-switch" data-on-label="<i class='entypo-check'></i>" data-off-label="<i class='entypo-cancel'></i>">
                          <input type="checkbox" class="flat-red" name="active" value="1" checked>
                          Active
                        </div>
                      </div>                  
                    </div>                                                
                  </div><!-- /.box-body -->
                  <div class="box-footer">
                    <div class="col-sm-2">
                      
                    </div>
                    <div class="col-sm-10">
                      <button type="submit" name="save" value="save" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save</button>
                      <button type="reset" class="btn btn-default btn-flat"><i class="fa fa-refresh"></i> Cancel</button>                
                    </div>
                </div><!-- /.box-footer -->
              </form>
            </div>
          </div>
  </div><!-- /.box3 -->
</div><!-- /.box1 -->
      <div class="modal fade" id="Kelurahanmodal">
        <div class="modal-dialog" role="document" style="width: 50%;">
          <div class="modal-content">
            <div class="modal-header">
              Search Kelurahan
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <table id="table" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Kabupaten</th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
<?php 

}elseif ($set == "edit") {
  $row = $dt_location;
  if ($form == 'edit') {
    $readonly = '';
    $mode_edit = 'true';
    $disabled = '';
  }
?>
<!-- form edit -->
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">
      <a href="master/event_lokasi">
        <button <?php echo $this->m_admin->set_tombol($id_menu, $group, "select"); ?> class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
      </a>
    </h3>
    <div class="box-tools pull-right">
      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
    </div>
  </div><!-- /.box-header -->
  <div class="box-body">
    <?php if (isset($_SESSION['pesan']) && $_SESSION['pesan'] <> '') { ?>
    <div class="alert alert-<?php echo $_SESSION['tipe']; ?> alert-dismissable">
      <strong><?php echo $_SESSION['pesan']; ?></strong>
      <button class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>  
      </button>
    </div>
    <?php $_SESSION['pesan'] = ''; } ?>
    <?php if (isset($error_message)) { ?>
    <div class="alert alert-danger">
      <strong><?php echo $error_message; ?></strong>
    </div>
    <?php } ?>
    <div class="row">
      <div class="col-md-12">
      <form class="form-horizontal" action="master/event_lokasi/update" method="post" enctype="multipart/form-data">
          <div class="box-body">          
              <input type="hidden" readonly name="id_spot_btl_int" id="id_spot_btl_int" value="<?= $row->id_spot_btl_int ?>">     
              <div class="form-group">
              <label for="spot_btl" class="col-sm-2 control-label">Spot BTL ID</label>
                <div class="col-sm-4">
                <input type="text" readonly class="form-control" name="id_spot_btl" id="id_spot_btl" value="<?= $row->id_spot_btl ?>">
                </div>
              </div>     

              <div class="form-group">
                  <label for="spot_btl" class="col-sm-2 control-label">Spot BTL</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" placeholder="Lokasi Event" name="spot_btl" required value="<?= $row->spot_btl ?>">
                  </div>  
                  <label for="kelurahan" class="col-sm-2 control-label">Kelurahan Domisili</label>
                  <div class="col-sm-4">
                      <input type="hidden" readonly name="id_kelurahan" id="id_kelurahan" value="<?= $row->id_kelurahan ?>">
                      <input type="text" value="<?= $row->kelurahan ?>" required type="text" onpaste="return false" onkeypress="return nihil(event)" autocomplete="off" name="kelurahan" data-toggle="modal" placeholder="Kelurahan Domisili" data-target="#Kelurahanmodal" class="form-control" id="kelurahan" onchange="take_kec()" <?= $readonly ?>>
                  </div>
              </div>
              
              <div class="form-group">
                  <label for="alamat" class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" placeholder="Alamat Lokasi" name="alamat" id="alamat" required value="<?= $row->alamat ?>">
                  </div>
                  <label for="provinsi" class="col-sm-2 control-label">Provinsi Domisili</label>
                  <div class="col-sm-4">
                      <input type="hidden" name="id_provinsi" id="id_provinsi" value="<?= $row->id_provinsi ?>">
                      <input type="text" class="form-control" readonly placeholder="Provinsi Domisili" id="provinsi" name="provinsi" required value="<?= $row->provinsi ?>">
                  </div>  
              </div>

              <div class="form-group">
                  <label for="kabupaten" class="col-sm-2 control-label">Kota/Kabupaten Domisili</label>
                  <div class="col-sm-4">
                      <input type="hidden" name="id_kabupaten" id="id_kabupaten" value="<?= $row->id_kabupaten ?>">
                      <input type="text" class="form-control" readonly placeholder="Kota/Kabupaten Domisili" id="kabupaten" name="kabupaten" required value="<?= $row->kabupaten ?>">
                  </div>
                  <label for="kecamatan" class="col-sm-2 control-label">Kecamatan Domisili</label>
                  <div class="col-sm-4">
                      <input type="hidden" name="id_kecamatan" id="id_kecamatan" value="<?= $row->id_kecamatan ?>">
                      <input type="text" class="form-control" readonly id="kecamatan" placeholder="Kecamatan Domisili" name="kecamatan" required value="<?= $row->kecamatan ?>">
                  </div>
              </div>

              <div class="form-group">
                  <label for="latitude" class="col-sm-2 control-label">Latitude *</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" placeholder="Latitude" name="latitude" required value="<?= $row->latitude ?>">
                  </div>
                  <label for="startDate" class="col-sm-2 control-label">Start Date *</label>
                  <div class="col-sm-4">
                      <input type="date" class="form-control" placeholder="Start Date" name="start_date" id="startDate" required value="<?= $row->start_date ?>">
                  </div>
              </div>

              <div class="form-group">
                  <label for="longitude" class="col-sm-2 control-label">Longitude *</label>
                  <div class="col-sm-4">
                      <input type="text" class="form-control" placeholder="Longitude" name="longitude" required value="<?= $row->longitude ?>">
                  </div>
                  <label for="endDate" class="col-sm-2 control-label">End Date *</label>
                  <div class="col-sm-4">
                      <input type="date" class="form-control" placeholder="End Date" name="end_date" id="endDate" required value="<?= $row->end_date ?>">
                  </div>
              </div>

              <div class="form-group">
                  <label for="status" class="col-sm-2 control-label">Status Location *</label>            
                  <div class="col-sm-2">
                      <select name="status" id="status" class="form-control">
                          <option value="">Pilih Status</option>
                          <option value="1" <?= $row->status == 1 ? 'selected' : '' ?>>Public Area</option>
                          <option value="2" <?= $row->status == 2 ? 'selected' : '' ?>>Mall</option>
                          <option value="3" <?= $row->status == 3 ? 'selected' : '' ?>>Pasar</option>
                          <option value="4" <?= $row->status == 4 ? 'selected' : '' ?>>SPBU</option>
                          <option value="5" <?= $row->status == 5 ? 'selected' : '' ?>>Minimarket</option>
                          <option value="6" <?= $row->status == 6 ? 'selected' : '' ?>>Bank</option>
                          <option value="7" <?= $row->status == 7 ? 'selected' : '' ?>>Instansi</option>
                      </select>
                  </div>                  
              </div>
              <div class="form-group">
                <label for="field-1" class="col-sm-2 control-label"></label>            
                <div class="col-sm-2">
                  <div id="label-switch" class="make-switch" data-on-label="<i class='entypo-check'></i>" data-off-label="<i class='entypo-cancel'></i>">
                    <?php 
                    if($row->active=='1'){
                    ?>
                    <input type="checkbox" class="flat-red" name="active" value="1" checked>
                    <?php }else{ ?>
                    <input type="checkbox" class="flat-red" name="active" value="1">
                    <?php } ?>
                    Active
                  </div>
                </div>                  
              </div>   
          </div><!-- /.box-body -->

          <div class="box-footer">
              <div class="col-sm-2">
              </div>
              <div class="col-sm-10">
                  <button type="submit" name="save" value="save" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save</button>
                  <button type="reset" class="btn btn-default btn-flat"><i class="fa fa-refresh"></i> Cancel</button>                
              </div>
          </div><!-- /.box-footer -->
      </form>
      </div>
    </div>
  </div>
</div><!-- /.box -->
      <div class="modal fade" id="Kelurahanmodal">
        <div class="modal-dialog" role="document" style="width: 50%;">
          <div class="modal-content">
            <div class="modal-header">
              Search Kelurahan
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
              <table id="table" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Kabupaten</th>
                    <th width="1%"></th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        <?php

        }elseif($set=="view"){

        ?>
        <div class="box">

            <div class="box-header with-border">
                    <div class="form-row align-items-center">
                        <div class="col-md-4 col-sm-12">
                          <form method="get" id="exportForm" action="<?= site_url('master/event_lokasi/exportExcel'); ?>">
                                  <input type="text" id="searchInput" name="search" placeholder="Search data event..." class="form-control" autocomplete="off">
                                  <!-- <input type="text" id="startDate" name="startDate" placeholder="Start Date" class="form-control mt-2" autocomplete="off"> -->
                                  <!-- <input type="text" id="endDate" name="endDate" placeholder="End Date" class="form-control mt-2" autocomplete="off"> -->
                                  
                                  <select id="statusFilter" name="status" class="form-control mt-3">
                                      <option value="">Pilih Status</option>
                                      <option value="1">Public Area</option>
                                      <option value="2">Mall</option>
                                      <option value="3">Pasar</option>
                                      <option value="4">SPBU</option>
                                      <option value="5">Mini Market</option>
                                      <option value="6">Bank</option>
                                      <option value="7">Instansi</option>
                                  </select>
                          </form>
                          <div class="row-sm-4 row-md-3" style="margin-top:10px;">
                                    <a href="master/event_lokasi/add">
                                      <button <?php echo $this->m_admin->set_tombol($id_menu,$group,"insert"); ?> class="btn bg-blue btn-flat margin"><i class="fa fa-plus"></i>&nbsp;&nbsp; Add New</button>
                                    </a>   
                                    <button id="exportButton" onclick="return confirm('Apakah anda yakin ?')" class="btn bg-maroon mt-3"><i class="fa fa-download"></i>&nbsp;&nbsp; Download Excel</button>
                                    <button class="btn bg-blue btn-flat margin" onClick="window.location.reload();"><i class="fa fa-refresh"></i>&nbsp;&nbsp; Refresh </button> 
                                  </div>
                        </div>
                    </div>
              <div class="box-tools pull-right"> 
                  <button id="searchButton" class="btn bg-blue mt-3"><i class="fa fa-search"></i>&nbsp;&nbsp; Search</button>                  
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
                  <table id="eventLokasiTbl" class="table table-bordered table-hover table-responsive">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Spot BTL ID</th>
                              <th>Spot BTL</th>
                              <th>Status Lokasi</th>
                              <th>Kecamatan</th>
                              <th>Kelurahan</th>
                              <th>Active</th>
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
    var table = $('#eventLokasiTbl').DataTable({
        "processing": true,
        "serverSide": true,
        "searching": false,
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 100],
        "ajax": {
            "url": "<?= base_url('master/event_lokasi/jsonEventLokasi') ?>",
            "type": "POST",
            "data": function(d) {
                d.search['value'] = $('#searchInput').val();
                d.startDate = $('#startDate').val();
                d.endDate = $('#endDate').val();
                d.status = $('#statusFilter').val();
            },
            "error": function(xhr, error, code) {
                console.error('Data fetching error:', error);
            }
        },
        "createdRow": function(row, data, dataIndex) {
            $('td', row).addClass('align-middle');
        },
        "columns": [
            { "data": 'id_spot_btl_int' },
            { "data": 'id_spot_btl' },
            { "data": 'spot_btl' },
            {
                    "data": "status",
                    "render": function (data, type, row) {
                        return formatStatus(data);
                    }
            },
            { "data": 'kecamatan' },
            { "data": 'kelurahan' },
            {
                "data": "active",
                "render": function (data, type, row) {
                    if (row.active === '1') {
                        return "<i class='glyphicon glyphicon-ok'></i>";
                    } else {
                        return "<i class='glyphicon glyphicon-remove'></i>";
                    }
                }
            },
            { 
                "data": null,
                "defaultContent": "<button class='editBtn btn btn-primary' title='Edit Data'><i class='fa fa-edit'></i></button>"
            }
        ]
    });

    $('#searchButton').on('click', function () {
            table.ajax.reload();
    });
    
    $('#eventLokasiTbl').on('click', '.editBtn', function(e) {
      e.preventDefault();
      var data = table.row($(this).parents('tr')).data();
      var id_spot_btl = data.id_spot_btl;
      window.location.href = "<?= site_url('master/event_lokasi/edit?id_spot=');?>" + id_spot_btl;
    });
    

    $(document).ready(function() {
        $('#exportButton').click(function(e) {
          e.preventDefault();
          $('#exportForm').submit();
        });

    });

    function formatStatus(status) {
        return status == 1 ? 'Public Area' : status == 2 ? 'Mall' : status == 3 ? 'Pasar' : status == 4 ? 'SPBU' : status == 5 ? 'Mini Market' : status == 6 ? 'Bank' : status == 7 ? 'Instansi'  : 'No Location';
    }
        
});
</script>

<script>
        function chooseitem(id_kelurahan) {
          document.getElementById("id_kelurahan").value = id_kelurahan;
          take_kec();
          $("#Kelurahanmodal").modal("hide");
        }
        function take_kec() {
          var id_kelurahan = $("#id_kelurahan").val();
          $.ajax({
            url: "<?php echo site_url('dealer/spk/take_kec') ?>",
            type: "POST",
            data: "id_kelurahan=" + id_kelurahan,
            cache: false,
            success: function(msg) {
              data = msg.split("|");
              $("#id_kecamatan").val(data[0]);
              $("#kecamatan").val(data[1]);
              $("#id_kabupaten").val(data[2]);
              $("#kabupaten").val(data[3]);
              $("#id_provinsi").val(data[4]);
              $("#provinsi").val(data[5]);
              $("#kelurahan").val(data[6]);
            }
          })
        }
</script>
<?
if ($set !== "view") { ?> 
<!-- 1 -->
      <script type="text/javascript">
        var table;
        $(document).ready(function() {
          table = $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "ajax": {
              "url": "<?php echo site_url('dealer/spk/ajax_list') ?>",
              "type": "POST"
            },
            "columnDefs": [{
              "targets": [0],
              "orderable": false,
            }, ],
          });
        });
      </script>

<?}?>
</div>
