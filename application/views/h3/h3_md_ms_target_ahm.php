<script src="<?= base_url("assets/panel/lodash.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/panel/moment.min.js") ?>"></script>
<script type="text/javascript" src="<?= base_url("assets/panel/daterangepicker.min.js") ?>"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/panel/daterangepicker.css") ?>" />

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
    <?php

    if ($set == "form") {
      $form     = '';
      $disabled = '';
      if ($mode == 'insert') {
        $form = 'save';
      }
      if ($mode == 'detail') {
        $disabled = 'disabled';
        $form = 'detail';
      }
      if ($mode == 'edit') {
        $form = 'update';
      } ?>

      <div id="app" class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="h3/<?= $isi ?>">
              <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
            </a>
          </h3>
        </div><!-- /.box-header -->
        <!-- <div class="overlay">
          <i class="text-light-blue fa fa-refresh fa-spin"></i>
        </div> -->

        <div class="box-body">
          <form class="form-horizontal">
            <div class="row">
              <div class="box-body">
                <?php
                if ($mode == 'detail'  || $mode == 'edit') {
                  $tg_sales_in = $target_ahm->target_global_sales_in;
                  $tg_sales_ins = "Rp " . number_format($tg_sales_in, 0, ",", ".");
                  $tg_sales_out = $target_ahm->target_global_sales_out;
                  $tg_sales_outs = "Rp " . number_format($tg_sales_out, 0, ",", ".");
                } else {
                  $tg_sales_ins = '';
                  $tg_sales_in = '';
                  $tg_sales_outs = '';
                  $tg_sales_out = '';
                }
                echo  form_open_multipart("#", ['class' => 'formsimpan']);
                ?>
                <div class="col-md-6">
                  <?php
                  if ($mode == 'edit') {
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                  }
                  ?>
                  <div class="form-group">
                    <label class="control-label col-sm-5">Target Global Sales In</label>
                    <div class="col-sm-7">
                      <input type="text" <?php if ($mode == 'detail') {
                                            echo 'disabled';
                                          } ?> class="form-control " id="tg_sales_ins" placeholder="Rp 0" value="<?= $tg_sales_ins ?>" maxlength="9" required>
                      <input type="hidden" id="tg_sales_in" name="tg_sales_in" value="<?= $tg_sales_in ?>">
                      <script>

                      </script>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-5">Target Global Sales Out</label>
                    <div class="col-sm-7">
                      <input type="text" <?php if ($mode == 'detail') {
                                            echo 'disabled';
                                          } ?> class="form-control " id="tg_sales_outs" placeholder="Rp 0" value="<?= $tg_sales_outs ?>" maxlength="9" required>
                      <input type="hidden" id="tg_sales_out" name="tg_sales_out" value="<?= $tg_sales_out ?>">
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Periode</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control pull-right" name="periode_target_ahm" id="periode_target_ahm" readonly>
                      <input type="hidden" name="start_date" id="start_date" required>
                      <input type="hidden" name="end_date" id="end_date" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-4">Jenis Target AHM</label>
                    <div class="col-sm-8">
                      <select <?php if ($mode == 'detail') {
                                echo 'disabled';
                              } ?> id="jenisTarget" name="jenis_target" class="form-control">
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
                </div>
                <script>
                  $('#jenisTarget').on('change', function() {
                    var val = $(this).val();
                    if (val == 'Parts') {
                      $('#tabelParts').show();
                    } else {
                      $('#tabelParts').hide();
                    }
                  });
                </script>

                <!-- febri : tabel sales in dan sales out -->
                <div class="col-md-12 " style="display: none;" id="tabelParts">
                  <div class="form-group" style="margin: 10px;">
                    <label for="" class="control-label">Target Sales In</label>
                    <table class="table">
                      <thead>
                        <tr>
                          <td width='30%'>Kelompok Produk</td>
                          <td width='49%'>Kelompok Barang MDP</td>
                          <td width='15%'>Target Sales In</td>
                          <td width="3%"></td>
                          <?php if ($mode != 'detail') {
                            echo '<td  width="3%"></td>';
                          } ?>
                        </tr>
                      </thead>
                      <tbody id="tbodySalesIn">
                        <!-- <td>
                            <button class="btn btn-flat btn-sm btn-info"><i class="fa fa-eye"></i></button>
                          </td> -->
                      </tbody>


                    </table>
                    <?php
                    if ($mode != 'detail') {
                      echo '     
                        <div class="row">
                          <div class="col-sm-12 text-right">
                            <button class="btn btn-flat btn-sm btn-primary margin btnTambahSubParts" type="button" data-target="Target Sales In"><i class=" fa fa-plus"></i></button>
                          </div>
                        </div>
                        ';
                    }
                    ?>
                  </div>
                  <div class="form-group" style="margin: 10px;">
                    <label for="" class="control-label">Target Sales Out</label>
                    <table class="table">
                      <thead>
                        <tr>

                          <td width='30%'>Kelompok Produk</td>
                          <td width='49%'>Kelompok Barang MDP</td>
                          <td width='15%'>Target Sales Out</td>
                          <td width="3%"></td>
                          <td v-if='mode != "detail"' width="3%"></td>
                        </tr>
                      </thead>
                      <tbody id="tbodySalesOut">
                      </tbody>

                    </table>
                    <?php
                    if ($mode != 'detail') {
                      echo '     
                        <div class="row">
                          <div class="col-sm-12 text-right">
                            <button class="btn btn-flat btn-sm btn-primary margin btnTambahSubParts" type="button" data-target="Target Sales Out"><i class=" fa fa-plus"></i></button>
                          </div>
                        </div>
                        ';
                    }
                    ?>
                  </div>

                  <?php echo form_close(); ?>

                  <!-- febri : Modal -->
                  <div id="modal_target_ahm" class="modal modalPart" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel">Pilih Part </h4>
                        </div>
                        <div class="modal-body">
                          <table class="table table-striped table-bordered table-hover table-condensed" id="dataPart" style="width: 100%">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>Kelompok Produk</th>
                                <th>Kelompok Barang MDP</th>
                                <!-- <th>Target</th> -->
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                          <script>
                            $(document).ready(function() {
                              h3_md_target_ahm_datatable = $('#dataPart').DataTable({
                                processing: true,
                                serverSide: true,
                                order: [],
                                ajax: {
                                  url: '<?= base_url('api/md/h3/Master_target_ahm_sales_in_out') ?>',
                                  dataSrc: 'data',
                                  type: 'POST',
                                  data: function(d) {
                                    // d.selected_id_dealer = _.chain(app.target_dealer_detail)
                                    //   .map(function(dealer) {
                                    //     return _.pick(dealer, ['id_dealer']);
                                    //   })
                                    //   .value();

                                    // d.selected_id_dealer = 103;
                                  }
                                },
                                columns: [{
                                    data: null,
                                    orderable: false,
                                    width: '3%'
                                  },
                                  {
                                    data: 'nama_kelompok_part_produk'
                                  },
                                  {
                                    data: 'kel_barang_mdp',

                                  },
                                  {
                                    data: 'action',
                                    orderable: false,
                                    widht: '3%',
                                    className: 'text-center'
                                  }
                                ],
                              });

                              h3_md_target_ahm_datatable.on('draw.dt', function() {
                                var info = h3_md_target_ahm_datatable.page.info();
                                h3_md_target_ahm_datatable.column(0, {
                                  search: 'applied',
                                  order: 'applied',
                                  page: 'applied'
                                }).nodes().each(function(cell, i) {
                                  cell.innerHTML = i + 1 + info.start + ".";
                                });
                              });
                            });
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>

                  <script>
                    //! febri:  Added data successfully
                    let countIn = 1;
                    let countOut = 1;
                    let target = '';
                    $('.btnTambahSubParts').click(function() {
                      $('#modal_target_ahm').modal('show');
                      target = $(this).data('target');
                      // alert(target);
                    });

                    function pilih_ahm_target_sales_in_out(data) {
                      data = _.pick(data, ['id_kelompok_part_produk', 'nama_kelompok_part_produk', 'kel_barang_mdp1']);
                      // console.log(data.kel_barang_mdp1);
                      var mode = <?php echo json_encode($mode) ?>;


                      if (target == 'Target Sales In') {
                        let dynamicRowHTML = `<tr class="remove salesIn-` + countIn + `" data-id="` + countIn + `">`;
                        dynamicRowHTML += `<td>` + data['nama_kelompok_part_produk'] + `</td>`;
                        dynamicRowHTML += `<td>`;
                        $.each(data.kel_barang_mdp1, function(index, value) {
                          dynamicRowHTML += `<span class="pull-right-container">
                                            <small class="label bg-green">` + value.id_kelompok_part + `</small>
                                        </span> `;
                        });
                        dynamicRowHTML += `</td>`;
                        dynamicRowHTML += `<td><input type="text"  id="targetIn-` + countIn + `" class="form-control targetRupiahIn" data-id="` + countIn + `" maxlength="9" required><input type="hidden" name="target[]" class="form-control targetIn-` + countIn + `"><input type="hidden" name="id_kelompok_part_produk[]"  value="` + data['id_kelompok_part_produk'] + `" class="form-control" required><input type="hidden" name="jenis_target_part[]"  value="` + target + `" class="form-control" required></td>`;
                        if (mode != 'detail') {
                          dynamicRowHTML += `<td><button class="btn btn-flat btn-sm btn-danger removeBtn" data-id="` + countIn + `" ><i class="fa fa-trash-o"></i></button></td>`;
                        }
                        dynamicRowHTML += `</tr>`;
                        $('#tbodySalesIn').append(dynamicRowHTML);
                        countIn++;
                      } else if (target == 'Target Sales Out') {
                        let dynamicRowHTML = `<tr class="remove salesOut-` + countOut + `">`;
                        dynamicRowHTML += `<td>` + data['nama_kelompok_part_produk'] + `</td>`;
                        dynamicRowHTML += `<td>`;
                        $.each(data.kel_barang_mdp1, function(index, value) {
                          dynamicRowHTML += `<span class="pull-right-container">
                                            <small class="label bg-green">` + value.id_kelompok_part + `</small>
                                        </span> `;
                        });
                        dynamicRowHTML += `</td>`;
                        dynamicRowHTML += `<td><input type="text"  id="targetOut-` + countOut + `" class="form-control targetRupiahOut" data-id="` + countOut + `"  maxlength="9" required><input type="hidden" name="target[]" class="form-control targetOut-` + countOut + `"><input type="hidden" name="id_kelompok_part_produk[]"  value="` + data['id_kelompok_part_produk'] + `" class="form-control" required><input type="hidden" name="jenis_target_part[]"  value="` + target + `" class="form-control" required></td>`;
                        if (mode != 'detail') {
                          dynamicRowHTML += `<td><button class="btn btn-flat btn-sm btn-danger removeBtn" ><i class="fa fa-trash-o"></i></button></td>`;
                        }
                        dynamicRowHTML += `</tr>`;
                        $('#tbodySalesOut').append(dynamicRowHTML);
                        countOut++;
                      }

                    }
                    $(document).ready(function() {
                      //* solved add
                      //! febri : target global sales in
                      $(document).on("focus", "#tg_sales_ins", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).keypress(function(e) {
                          if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
                        });
                        $(this).val($('#tg_sales_in').val());

                      }).on("blur", "#tg_sales_ins", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).val(formatRupiahAppend(isi));
                        $('#tg_sales_in').val(isi);
                      });

                      //! febri : target global sales out
                      $(document).on("focus", "#tg_sales_outs", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).keypress(function(e) {
                          if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
                        });
                        $(this).val($('#tg_sales_out').val());
                      }).on("blur", "#tg_sales_outs", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).val(formatRupiahAppend(isi));
                        $('#tg_sales_out').val(isi);
                      });

                      //! febri : target parts sales in
                      $(document).on("focus", ".targetRupiahIn", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).keypress(function(e) {
                          if (String.fromCharCode(e.keyCode).match(/[^0-9]/g)) return false;
                        });
                        $(this).val($('.targetIn-' + id).val());
                      }).on("blur", ".targetRupiahIn", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).val(formatRupiahAppend(isi));
                        $('.targetIn-' + id).val(isi);
                      });

                      //! febri : target parts sales out
                      $(document).on("focus", ".targetRupiahOut", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).val($('.targetOut-' + id).val());

                      }).on("blur", ".targetRupiahOut", function() {
                        var id = $(this).data('id'),
                          isi = $(this).val();
                        $(this).val(formatRupiahAppend(isi));
                        $('.targetOut-' + id).val(isi);
                      });

                      //! febri : old
                      // $(document).on("change", ".targetRupiahOut", function() {
                      //   var id = $(this).data('id'),
                      //     isi = $(this).val();
                      //   $(this).val(formatRupiahAppend(isi));
                      //   $('.targetOut-' + id).val(isi);
                      // });

                      var formatRupiahAppend = function(num) {
                        var str = num.toString().replace("", ""),
                          parts = false,
                          output = [],
                          i = 1,
                          formatted = null;
                        if (str.indexOf(".") > 0) {
                          parts = str.split(".");
                          str = parts[0];
                        }
                        str = str.split("").reverse();
                        for (var j = 0, len = str.length; j < len; j++) {
                          if (str[j] != ",") {
                            output.push(str[j]);
                            if (i % 3 == 0 && j < (len - 1)) {
                              output.push(".");
                            }
                            i++;
                          }
                        }
                        formatted = output.reverse().join("");
                        return ("Rp " + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
                      };

                      // Removing Row on click to Remove button
                      $(document).on("click", ".removeBtn", function() {
                        $(this).closest("tr").remove();
                      });
                    });
                    //! end
                  </script>

                  <!-- febri : end modal -->
                </div>
                <!-- febri : end tabel sales in dan sales out -->

                <div class="col-sm-12 ">
                  <?php

                  if ($mode == 'insert') {
                    echo '<button class="btn btn-flat btn-sm btn-primary" type="submit" >Simpan</button>';
                  } elseif ($mode == 'edit') {
                    echo '<button class="btn btn-flat btn-sm btn-warning" type="submit">Perbarui</button>';
                  } elseif ($mode == 'detail') {
                    echo '<a href="h3/' . $isi . '/edit?id=' . $target_ahm->id . '" class="btn btn-flat btn-sm btn-warning">Edit</a>';
                  }
                  ?>

                </div>


              </div>
            </div>
          </form>
        </div>
      </div>
      <script>
        $("form").submit(function(e) {
          var isi = <?php echo json_encode($isi) ?>;
          var form = <?php echo json_encode($form) ?>;
          url = 'h3/' + isi + '/' + form;

          // console.log(url);
          $.ajax({
            type: "post",
            url: url,
            data: new FormData(this),
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
              toastr.success('Data berhasil ditambah.');
              window.location = 'h3/<?= $isi ?>';
            },
            error: function(xhr, ajaxOptions, thrownError) {
              alert('error');
              // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
          });
          return false;
        });

        $(function() {
          var mode = <?= json_encode($mode) ?>;

          config = {
            opens: 'left',
            autoUpdateInput: mode == 'detail' || mode == 'edit',
            locale: {
              format: 'DD/MM/YYYY'
            }
          };

          if (mode == 'detail' || mode == 'edit') {
            var target_ahm = <?= json_encode($target_ahm) ?>;
            var target_ahm_detail = <?= json_encode($target_ahm_detail) ?>;
            config.startDate = new Date(target_ahm.start_date);
            config.endDate = new Date(target_ahm.end_date);
            $('#start_date').val(target_ahm.start_date);
            $('#end_date').val(target_ahm.end_date);

            $('#jenisTarget').val(target_ahm.jenis_target).change();
            if (target_ahm.jenis_target == 'Parts') {
              $('#tabelParts').show();
              if (mode != 'detail') {
                var modes = '';
              } else {
                var modes = 'disabled';
              }

              $.each(target_ahm_detail, function(index, value) {
                  // console.log(value);
                if (value.jenis_target_part == 'Target Sales In') {
                  let dynamicRowHTML = `<tr class="remove salesIn-` + countIn + `">`;
                  dynamicRowHTML += `<td>` + value.nama_kelompok_part_produk + `</td>`;
                  dynamicRowHTML += `<td>`;
                  $.each(value.kel_produk_mdp, function(index, value1) {
                    dynamicRowHTML += `<span class="pull-right-container">
                                            <small class="label bg-green">` + value1.id_kelompok_part + `</small>
                                        </span> `;
                  });
                  dynamicRowHTML += `</td>`;
                  dynamicRowHTML += `<td><input type="text"  id="targetIn-` + countIn + `" class="form-control targetRupiahIn" ` + modes + ` value="Rp ` + (value.target_ahm / 1000).toFixed(3) + `"  maxlength="9" required><input type="hidden" name="target[]" value="` + value.target_ahm + `" class="form-control targetIn-` + countIn + `"><input type="hidden" name="id_kelompok_part_produk[]"  value="` + value.id_kelompok_part_produk + `" class="form-control" required><input type="hidden" name="jenis_target_part[]"  value="` + value.jenis_target_part + `" class="form-control" required></td>`;
                  if (mode != 'detail') {
                    dynamicRowHTML += `<td><button class="btn btn-flat btn-sm btn-danger removeBtn" ><i class="fa fa-trash-o"></i></button></td>`;
                  }
                  dynamicRowHTML += `</tr>`;
                  $('#tbodySalesIn').append(dynamicRowHTML)
                    ++countIn;
                } else if (value.jenis_target_part == 'Target Sales Out') {
                  let dynamicRowHTML = `<tr class="remove salesOut-` + countOut + `">`;
                  dynamicRowHTML += `<td>` + value.nama_kelompok_part_produk + `</td>`;
                  dynamicRowHTML += `<td>`;
                  $.each(value.kel_produk_mdp, function(index, value1) {
                    dynamicRowHTML += `<span class="pull-right-container">
                                            <small class="label bg-green">` + value1.id_kelompok_part + `</small>
                                        </span> `;
                  });
                  dynamicRowHTML += `</td>`;
                  dynamicRowHTML += `<td><input type="text"  id="targetOut-` + countOut + `" class="form-control targetRupiahOut" ` + modes + ` value="Rp ` + (value.target_ahm / 1000).toFixed(3) + `" data-id="` + countOut + `"  maxlength="9" required><input type="hidden" name="target[]" value="` + value.target_ahm + `" class="form-control targetOut-` + countOut + `"><input type="hidden" name="id_kelompok_part_produk[]"  value="` + value.id_kelompok_part_produk + `" class="form-control" required><input type="hidden" name="jenis_target_part[]"  value="` + value.jenis_target_part + `" class="form-control" required></td>`;
                  if (mode != 'detail') {
                    dynamicRowHTML += `<td><button class="btn btn-flat btn-sm btn-danger removeBtn" ><i class="fa fa-trash-o"></i></button></td>`;
                  }
                  dynamicRowHTML += `</tr>`;
                  $('#tbodySalesOut').append(dynamicRowHTML);
                  ++countOut;
                  // alert(index + ": " + value.id);
                }

              });
            }

          }

          $('#periode_target_ahm').daterangepicker(config).on('apply.daterangepicker', function(ev, picker) {
            // alert(picker.endDate.format('YYYY-MM-DD'));  
            // $(this).val('ok');
            start = picker.startDate.format('YYYY-MM-DD');
            end = picker.endDate.format('YYYY-MM-DD');
            $('#start_date').val(start);
            $('#end_date').val(end);
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
          }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            alert('false');
          });
        });
      </script>




    <?php
    } elseif ($set == "index") {
    ?>
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="h3/<?= $isi ?>/add">
              <button class="btn bg-blue btn-flat margin"><i class="fa fa-plus"></i> Add New</button>
            </a>
            <!-- <?php if ($this->input->get('history') != null) : ?>
              <a href="h3/<?= $isi ?>">
                <button class="btn bg-maroon btn-flat margin"><i class="fa fa-history"></i> Non-History</button>
              </a>
            <?php else : ?>
              <a href="h3/<?= $isi ?>?history=true">
                <button class="btn bg-maroon btn-flat margin"><i class="fa fa-history"></i> History</button>
              </a>
            <?php endif; ?> -->
          </h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="container-fluid no-padding">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">

                  <table id="master_target_sales_in_out" class="table table-bordered table-hover table-condensed">
                    <thead>
                      <tr>
                        <th>No.</th>
                        <th>Jenis Target AHM</th>
                        <th>Periode awal</th>
                        <th>Periode akhir</th>
                        <th>Target Global Sales In</th>
                        <th>Target Global Sales Out</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                  <script>
                    date_render = function(data) {
                      return moment(data).format('DD/MM/YYYY');
                    }

                    rupiah_render = function(data) {
                      if (data != null) return 'Rp ' + data.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
                    }

                    $(document).ready(function() {
                      master_target_ahm = $('#master_target_sales_in_out').DataTable({
                        processing: true,
                        serverSide: true,
                        order: [],
                        ajax: {
                          url: "<?= base_url('api/md/h3/master_target_ahm') ?>",
                          dataSrc: "data",
                          type: "POST",
                          data: function(d) {
                            d.filter_produk = $('#filter_produk').val();
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
                            data: 'jenis_target',
                            orderable: false
                          },
                          {
                            data: 'start_date',
                            render: date_render
                          },
                          {
                            data: 'end_date',
                            render: date_render
                          },
                          {
                            data: 'target_global_sales_in',
                            render: rupiah_render
                          },
                          {
                            data: 'target_global_sales_out',
                            render: rupiah_render
                          },
                          {
                            data: 'action',
                            width: '3%',
                            orderable: false,
                            className: 'text-center'
                          },
                        ],
                      });
                    });
                  </script>
                </div>
              </div>

            </div>
          </div>




        </div><!-- /.box-body -->
      </div><!-- /.box -->
    <?php } ?>
  </section>
</div>

<script>

</script>