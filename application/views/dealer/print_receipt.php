<base href="<?php echo base_url(); ?>" />
<style>
  .isi {
    height: 25px;
    padding-left: 4px;
    padding-right: 4px;
  }

  .text-rata-kanan {
    float: left;
    width: 100%;
    text-align: right;
  }
</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      <?php echo $title; ?>
    </h1>
    <ol class="breadcrumb">
      <li><a href="panel/home"><i class="fa fa-home"></i> Dashboard</a></li>
      <li class="">Pembayaran</li>
      <li class="active"><?php echo ucwords(str_replace("_", " ", $isi)); ?></li>
    </ol>
  </section>

  <section class="content">

    <?php
    if ($set == "form") {
      $form     = '';
      $disabled = '';
      $readonly = '';
      if ($mode == 'insert') {
        if ($jenis_invoice == 'tjs') {
          $form = 'save_tjs';
        } elseif ($jenis_invoice == 'dp') {
          $form = 'save_dp';
        } elseif ($jenis_invoice == 'pelunasan') {
          $form = 'save_pelunasan';
        }
      } elseif ($mode == 'edit') {
        // $readonly ='readonly';
        $form = 'save_edit';
      } elseif ($mode == 'detail') {
        $disabled = 'disabled';
      }
    ?>
      <script src="<?= base_url("assets/vue/vue.min.js") ?>" type="text/javascript"></script>
      <script src="<?= base_url("assets/vue/accounting.js") ?>" type="text/javascript"></script>
      <script src="<?= base_url("assets/vue/vue-numeric.min.js") ?>" type="text/javascript"></script>

      <script>
        Vue.use(VueNumeric.default);
        Vue.filter('toCurrency', function(value) {
          value = parseInt(value);
          return accounting.formatMoney(value, "", 0, ".", ",");
          return value;
        });
      </script>
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title">
            <a href="dealer/print_receipt">
              <button class="btn bg-maroon btn-flat margin"><i class="fa fa-eye"></i> View Data</button>
            </a>
          </h3>
          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <form class="form-horizontal" id="form_" action="dealer/print_receipt/<?= $form ?>" method="post" enctype="multipart/form-data">
                <div class="box-body">
                  <div class="form-group" v-if="jenis_invoice=='tjs'">
                    <label for="inputEmail3" class="col-sm-2 control-label">ID Tanda Jadi Sementara</label>
                    <div class="col-sm-4">
                      <input type="text" name='id_invoice' required class="form-control" value="<?= isset($row->id_invoice_tjs) ? $row->id_invoice_tjs : '' ?>" autocomplete="off" readonly>
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl. Tanda Jadi Sementara</label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" value="<?= isset($row->tgl_tjs) ? $row->tgl_tjs  : '' ?>" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="form-group" v-if="jenis_invoice=='dp'">
                    <label for="inputEmail3" class="col-sm-2 control-label">ID Credit</label>
                    <div class="col-sm-4">
                      <input type="text" name='id_invoice' id='id_invoice' required class="form-control" value="<?= isset($row->id_invoice_dp) ? $row->id_invoice_dp : '' ?>" autocomplete="off" readonly>
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl. Credit</label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" value="<?= isset($row->tgl_invoice_dp) ? $row->tgl_invoice_dp  : '' ?>" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="form-group" v-if="jenis_invoice=='pelunasan'">
                    <label for="inputEmail3" class="col-sm-2 control-label">ID Cash</label>
                    <div class="col-sm-4">
                      <input type="text" name='id_invoice' id='id_invoice' required class="form-control" value="<?= isset($row->id_inv_pelunasan) ? $row->id_inv_pelunasan : '' ?>" autocomplete="off" readonly>
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label">Tgl. Cash</label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" value="<?= isset($row->tgl_inv_pelunasan) ? $row->tgl_inv_pelunasan  : '' ?>" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="form-group" v-if="jenis_invoice=='dp' || jenis_invoice=='pelunasan'">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">ID SO</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control" name="id_sales_order" value="<?= isset($row->id_sales_order) ? $row->id_sales_order : '' ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Tgl. SO</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control" name="tgl_spk" value="<?= isset($row->tgl_so) ? $row->tgl_so : '' ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">No. SPK</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control" id='no_spk' name="no_spk" value="<?= $row->no_spk ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Tgl. SPK</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control" name="tgl_spk" value="<?= $row->tgl_spk ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Sales People ID</label></label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" name="id_flp_md" value="<?= $row->id_flp_md ?>" autocomplete="off" readonly>
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Sales People ID</label></label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" name="nama_lengkap" value="<?= $row->nama_lengkap ?>" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Pelanggan</label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" name="nama_konsumen" value="<?= $row->nama_konsumen ?>" autocomplete="off" readonly>
                    </div>
                    <label for="inputEmail3" class="col-sm-2 control-label">No. KTP</label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" name="no_ktp" value="<?= $row->no_ktp ?>" autocomplete="off" readonly>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Tipe Pembayaran</label>
                    <div class="col-sm-4">
                      <input type="text" required class="form-control" name="jenis_beli" value="<?= $row->jenis_beli ?>" autocomplete="off" readonly>
                    </div>
                    <div class="" v-if="jenis_invoice=='tjs'">
                      <label for="inputEmail3" class="col-sm-2 control-label">Amount TJS</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control text-rata-kanan" name="tanda_jadi" :value='tanda_jadi | toCurrency' autocomplete="off" readonly>
                      </div>
                    </div>
                    <div class="form-input" v-if="jenis_invoice=='dp' || jenis_invoice=='pelunasan'">
                      <label for="inputEmail3" class="col-sm-2 control-label">Total Diskon</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control text-rata-kanan" value="<?= isset($row->diskon) ? mata_uang_rp($row->diskon) : '' ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" v-if="jenis_invoice=='dp' || jenis_invoice=='pelunasan'">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Amount TJS</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control text-rata-kanan" value="<?= isset($row->amount_tjs) ? mata_uang_rp($row->amount_tjs) : '' ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Amount DP</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control text-rata-kanan" value="<?= isset($row->amount_dp) ? mata_uang_rp($row->amount_dp) : '' ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" v-if="jenis_invoice=='dp' || jenis_invoice=='pelunasan'">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Total Harga Unit</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control text-rata-kanan" value="<?= isset($row->total_bayar) ? mata_uang_rp($row->total_bayar) : '' ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Sisa Pelunasan</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control text-rata-kanan" value="<?= isset($row->sisa_pelunasan) ? mata_uang_rp($row->sisa_pelunasan) : '' ?>" autocomplete="off" readonly>
                      </div>
                    </div>
                  </div>
                  <div class="form-group" v-if="jenis_invoice=='dp' || jenis_invoice=='pelunasan'">
                    <div class="form-input">
                      <label for="inputEmail3" class="col-sm-2 control-label">Akumulasi Penerimaan</label>
                      <div class="col-sm-4">
                        <input type="text" required class="form-control text-rata-kanan" value="<?= isset($row->summary_terima) ? mata_uang_rp($row->summary_terima) : '' ?>" autocomplete="off" readonly>
                      </div>
                      <div class="col-sm-1">
                        <button class="btn btn-primary btn-flat" type='button' onclick="showModalRiwayatPenerimaanPembayaran()">Riwayat Penerimaan</button>
                      </div>
                    </div>
                  </div>
                  <button style="font-size: 11pt;font-weight: 540;width: 100%" class="btn btn-info btn-flat btn-sm" disabled>Detail Kendaraan</button><br><br>
                  <table class="table table-bordered table-hover table-condensed table-stripped" style='margin-bottom:20px'>
                    <thead>
                      <th>No.</th>
                      <th>Kode Tipe Unit</th>
                      <th>Deskripsi Unit</th>
                      <th>Kode Warna</th>
                      <th>Deskripsi Warna</th>
                      <th>Qty</th>
                      <th>Harga</th>
                      <th>Tot. Diskon</th>
                      <th>Total Harga</th>
                      <th>DP</th>
                    </thead>
                    <tbody>
                      <tr v-for="(dt, index) of details">
                        <td>{{index+1}}</td>
                        <td>{{dt.id_tipe_kendaraan}}</td>
                        <td>{{dt.tipe_ahm}}</td>
                        <td>{{dt.id_warna}}</td>
                        <td>{{dt.warna}}</td>
                        <td align='right'>{{dt.qty==null?1:dt.qty}}</td>
                        <td align='right'>{{parseInt(dt.harga_tunai) | toCurrency}}</td>
                        <td align='right'>{{dt.diskon | toCurrency}}</td>
                        <td align='right'>{{dt.total_bayar | toCurrency}}</td>
                        <td align='right'>{{dt.dp_stor | toCurrency}}</td>
                      </tr>
                    </tbody>
                  </table>
                  <button v-if="mode=='insert' || mode=='detail_tjs' || mode=='insert_dp' || mode=='insert_pelunasan'" class="btn btn-primary btn-flat col-sm-12 col-xs-12 col-lg-12  col-md-12 " disabled style='font-size:12pt;margin-bottom:20px'>Detail Penerimaan</button>
                  <div class="form-group" v-if="mode=='insert' || mode=='detail_tjs' || mode=='insert_dp' || mode=='insert_pelunasan'">
                    <label for="inputEmail3" class="col-sm-2 control-label">Note</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="note" value="<?= isset($row->note) ? $row->note : '' ?>" autocomplete="off" :disabled="mode=='detail_tjs'">
                    </div>
                  </div>
                  <div class="form-group" v-if="mode=='insert' || mode=='detail_tjs' || mode=='insert_dp' || mode=='insert_pelunasan'">
                    <div class="col-md-12">
                      <table class="table table-bordered">
                        <thead>
                          <th>Metode Penerimaan</th>
                          <th>Nominal Penerimaan</th>
                          <th>Tanggal</th>
                          <th>Nama Bank</th>
                          <th>No. BG / Cek</th>
                          <th v-if="mode=='insert'" width='7%'>Aksi</th>
                        </thead>
                        <tbody>
                          <tr v-for="(dtl, index) of dt_bayar">
                            <td>{{dtl.metode_penerimaan}}</td>
                            <td align='right'>{{dtl.nominal|toCurrency}}</td>
                            <td>{{dtl.tgl_terima}}</td>
                            <td>{{dtl.bank}}</td>
                            <td>{{dtl.no_bg_cek}}</td>
                            <td v-if="mode=='insert'" align='center'>
                              <button type="button" @click.prevent="editPenerimaan(index)" class="btn btn-warning btn-flat btn-xs"><i class="fa fa-edit"></i></button>
                              <button type="button" @click.prevent="delPenerimaan(index)" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i></button>
                            </td>
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr v-if="dt_bayar.length>0">
                            <td colspan=4><b>Total</b></td>
                            <td align='right'><b>{{total | toCurrency}}</b></td>
                            <td v-if="mode=='insert'"></td>
                          </tr>
                          <tr v-if="mode=='insert'">
                            <td>
                              <select v-model="bayar.metode_penerimaan" class="form-control isi2">
                                <option value="">-choose-</option>
                                <option value="cash">Cash</option>
                                <option value="kredit_transfer">Kredit/Transfer</option>
                                <option value="bg_cek">BG / Cek</option>
                              </select>
                            </td>
                            <td>
                              <vue-numeric style="float: left;width: 100%;text-align: right;" class="form-control isi2" v-model="bayar.nominal" v-bind:minus="false" :empty-value="0" separator="." onkeypress="return number_only(event)" />
                            </td>
                            <td>
                              <input id="tgl_terima" type="text" class="form-control datepicker isi2" onchange="setTglTerima()">
                            </td>
                            <td>
                              <select v-model="bayar.id_bank" id="id_bank" class="form-control isi2" onchange="setBank()">
                                <option value="">-choose-</option>
                                <?php $bank = $this->db->get('ms_bank');
                                foreach ($bank->result() as $val) { ?>
                                  <option value="<?= $val->id_bank ?>"><?= $val->bank ?></option>
                                <?php } ?>
                              </select>
                            </td>
                            <td>
                              <input type="text" class="form-control isi2" v-model="bayar.no_bg_cek">
                            </td>
                            <td align='center'>
                              <button type="button" @click.prevent="addPenerimaan" class="btn btn-sm btn-primary btn-flat"><i class="fa fa-plus"></i></button>
                            </td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <div v-if="total>sisa_pelunasan">
                    <button class="btn btn-info btn-flat col-sm-12 col-xs-12 col-lg-12  col-md-12 " disabled style='font-size:12pt;margin-bottom:20px'>Pencatatan Kelebihan Pembayaran</button>
                    <div class='col-sm-12'>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">COA</label>
                        <div class="col-sm-3">
                          <input type="text" class="form-control" name="kode_coa" autocomplete="off" readonly placeholder='Klik untuk memilih' onclick="showModalCOADealer()" id="kode_coa" value="<?= isset($row->kode_coa) ? $row->kode_coa : '' ?>">
                        </div>
                        <div class="col-sm-7">
                          <input type="text" class="form-control" autocomplete="off" readonly id="coa" value="<?= isset($row->coa) ? $row->coa : '' ?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Nominal</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control text-rata-kanan" autocomplete="off" v-model='nominal_lebih' value="<?= isset($row->nominal_lebih) ? $row->nominal_lebih : '' ?>" readonly>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Keterangan</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="keterangan_lebih" autocomplete="off" value="<?= isset($row->keterangan_lebih) ? $row->keterangan_lebih : '' ?>" :disabled="mode!='insert'">
                        </div>
                      </div>
                    </div>
                  </div>
                </div><!-- /.box-body -->
                <div>

                  <div class=" box-footer" v-if="mode!='detail'">
                    <div class="col-sm-12" v-if="mode=='insert'||mode=='edit'" align="center">
                      <button id="submitBtn" type="button" name="save" value="save" class="btn btn-info btn-flat"><i class="fa fa-save"></i> Save All</button>
                    </div>
                  </div><!-- /.box-footer -->
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.box -->
      <?php
      $data['data'] = ['modalCOADealer'];
      $this->load->view('dealer/h2_api_finance', $data);
      ?>
      <?php
      if ($jenis_invoice != 'tjs') {
        $data['data'] = ['modalRiwayatPenerimaanPembayaran', 'riwayat_no_spk'];
        $this->load->view('dealer/h1_dealer_api', $data);
      }
      ?>

      <script>
        function pilihCOADealer(params) {
          $('#kode_coa').val(params.kode_coa)
          $('#coa').val(params.coa)
        }

        function showModalCOADealer(to) {
          coa_to = to
          $('#modalCOADealer').modal('show');
        }
        var form_ = new Vue({
          el: '#form_',
          data: {
            mode: '<?= $mode ?>',
            bayar: {
              metode_penerimaan: '',
              nominal: 0,
              tgl_terima: '',
              id_bank: '',
              bank: '',
              no_bg_cek: '',
            },
            jenis_invoice: '<?= $jenis_invoice ?>',
            dt_bayar: <?= isset($dt_bayar) ? json_encode($dt_bayar) : '[]' ?>,
            tanda_jadi: <?= isset($row->tanda_jadi) ? json_encode($row->tanda_jadi) : 0 ?>,
            sisa: <?= isset($row->sisa_pelunasan) ? json_encode($row->sisa_pelunasan) : 0 ?>,
            details: <?= isset($details) ? json_encode($details) : '[]' ?>,
          },
          methods: {
            clearPenerimaan: function() {
              this.bayar = {
                metode_penerimaan: '',
                nominal: 0,
                tgl_terima: '',
                id_bank: '',
                bank: '',
                no_bg_cek: '',
              }
              $('#tgl_terima').val('');
            },
            addPenerimaan: function() {
              // if (this.dealers.length > 0) {
              //   for (dl of this.dealers) {
              //     if (dl.id_dealer === this.dealer.id_dealer) {
              //         alert("Dealer Sudah Dipilih !");
              //         this.clearPenerimaan();
              //         return;
              //     }
              //   }
              // }
              // if (this.dealer.id_dealer=='') 
              // {
              //   alert('Pilih Dealer !');
              //   return false;
              // }
              let total = parseInt(this.total) + parseInt(this.bayar.nominal);
              if (form_.sisa_pelunasan < total) {
                if (confirm('Terdapat kelebihan pembayaran, apakah ingin melanjutkan ?') === true) {
                  this.pushPenerimaan();
                } else {
                  return false;
                }
              } else {
                this.pushPenerimaan()
              }

            },
            pushPenerimaan: function() {
              this.dt_bayar.push(this.bayar);
              this.clearPenerimaan();
            },
            delPenerimaan: function(index) {
              this.dt_bayar.splice(index, 1);
            },
            editPenerimaan: function(index) {
              this.bayar = this.dt_bayar[index];
              $('#tgl_terima').val(this.bayar.tgl_terima);
              this.dt_bayar.splice(index, 1);
            },
            getDealer: function() {
              var el = $('#dealer').find('option:selected');
              var id_dealer = el.attr("id_dealer");
              form_.dealer.id_dealer = id_dealer;
            }
          },
          computed: {
            total: function() {
              tot = 0
              for (dt of this.dt_bayar) {
                tot += parseInt(dt.nominal);
              }
              return parseInt(tot)
            },
            nominal_lebih: function() {
              amount = 0;
              if (this.jenis_invoice == 'tjs') {
                amount = parseInt(this.tanda_jadi);
              } else if (this.jenis_invoice == 'dp' || this.jenis_invoice == 'pelunasan') {
                amount = parseInt(this.sisa_pelunasan);
              }
              tot = this.total - amount;
              return parseInt(tot);
            },
            sisa_pelunasan: function() {
              sisa = 0;
              if (this.jenis_invoice === 'tjs') {
                sisa = this.tanda_jadi;
              } else if (this.jenis_invoice === 'dp' || this.jenis_invoice == 'pelunasan') {
                sisa = this.sisa;
              }
              return sisa;
            }
          }
        });

        function setBank() {
          let bank = $("#id_bank option:selected").text();
          form_.bayar.bank = bank;
        }

        function setTglTerima() {
          let tgl = $('#tgl_terima').val();
          form_.bayar.tgl_terima = tgl;
        }

        $('#submitBtn').click(function() {
          $('#form_').validate({
            rules: {
              'checkbox': {
                required: true
              }
            },
            highlight: function(input) {
              $(input).parents('.form-group').addClass('has-error');
            },
            unhighlight: function(input) {
              $(input).parents('.form-group').removeClass('has-error');
            }
          })
          var values = {
            dt_bayar: form_.dt_bayar,
            jenis_invoice: form_.jenis_invoice,
            nominal_lebih: form_.nominal_lebih,
            sisa: form_.sisa
          };
          var form = $('#form_').serializeArray();
          for (field of form) {
            values[field.name] = field.value;
          }
          if ($('#form_').valid()) // check if form is valid
          {
            if (values.dt_bayar.length == 0) {
              alert('Tentukan detail penerimaan !')
              return false;
            }
            if (form_.jenis_invoice == 'tjs') {
              if (form_.total < form_.tanda_jadi) {
                alert('Jumlah penerimaan kurang dari amount TJS !')
                return false;
              }
            }
            if (confirm("Apakah anda yakin ?") == true) {
              $.ajax({
                beforeSend: function() {
                  $('#submitBtn').html('<i class="fa fa-spinner fa-spin"></i> Process');
                  $('#submitBtn').attr('disabled', true);
                },
                url: '<?= base_url('dealer/print_receipt/' . $form) ?>',
                type: "POST",
                data: values,
                cache: false,
                dataType: 'JSON',
                success: function(response) {
                  if (response.status == 'sukses') {
                    window.location = response.link;
                  } else {
                    alert(response.pesan);
                    $('#submitBtn').attr('disabled', false);
                  }
                  $('#submitBtn').html('<i class="fa fa-save"></i> Save All');
                },
                error: function() {
                  alert("something went wrong !");
                  $('#submitBtn').attr('disabled', false);
                  $('#submitBtn').html('<i class="fa fa-save"></i> Save All');
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
    <?php } elseif ($set == "index") { ?>

      <div class="box">
        <div class="box-body">
          <div class="nav-tabs-custom" style="margin-bottom: 20px">
            <ul class="nav nav-tabs">
              <li class="active"><a href="<?= base_url('dealer/print_receipt') ?>">Tanda Jadi Sementara</a></li>
              <li class=""><a href="<?= base_url('dealer/print_receipt/dp') ?>">Credit</a></li>
              <li class=""><a href="<?= base_url('dealer/print_receipt/pelunasan') ?>">Cash</a></li>
            </ul>
          </div>
          <hr style="margin-top: 0px">
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
                <th>ID Invoice TJS</th>
                <th>ID SPK</th>
                <th>No. Kwitansi</th>
                <th>Nama Konsumen</th>
                <th>Tipe Pembelian</th>
                <th>Amount</th>
                <th>Creation Date</th>
                <th>Status</th>
                <th width="3%">Action</th>
              </tr>
            </thead>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
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
              url: "<?php echo site_url('dealer/print_receipt/fetch_tjs'); ?>",
              type: "POST",
              dataSrc: "data",
              data: function(d) {
                // d.start_date = $('#start_date').val();
                // d.end_date = $('#end_date').val();
                d.<?php echo $this->security->get_csrf_token_name(); ?> = '<?php echo $this->security->get_csrf_hash(); ?>';
                return d;
              },
            },
            "columnDefs": [{
                "targets": [7, 2],
                "orderable": false
              },
              {
                "targets": [7, 8],
                "className": 'text-center'
              },
              // // { "targets":[0],"checkboxes":{'selectRow':true}}
              {
                "targets": [5],
                "className": 'text-right'
              },
              // // { "targets":[2,4,5], "searchable": false } 
            ],
          });
        });
      </script>
    <?php } elseif ($set == "index_dp") { ?>

      <div class="box">
        <div class="box-body">
          <div class="nav-tabs-custom" style="margin-bottom: 10px">
            <ul class="nav nav-tabs">
              <li class=""><a href="<?= base_url('dealer/print_receipt') ?>">Tanda Jadi Sementara</a></li>
              <li class="active"><a href="<?= base_url('dealer/print_receipt/dp') ?>">Credit</a></li>
              <li class=""><a href="<?= base_url('dealer/print_receipt/pelunasan') ?>">Cash</a></li>
              </li>
            </ul>
          </div>
          <hr style="margin-top: 20px">
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
                <th>ID Credit</th>
                <th>ID SO</th>
                <th>No. SPK</th>
                <th>Nama Konsumen</th>
                <th>Amount DP</th>
                <th>Total Harga</th>
                <th>Akumulasi Penerimaan</th>
                <th>Sisa</th>
                <th>Creation Date</th>
                <th>Status</th>
                <th width="5%">Action</th>
              </tr>
            </thead>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <?php
      $data['data'] = ['modalRiwayatPenerimaanPembayaran', 'riwayat_no_spk'];
      $this->load->view('dealer/h1_dealer_api', $data);
      ?>
      <script>
        $(document).ready(function() {
          var dataTable = $('#datatable_server').DataTable({
            "processing": true,
            "serverSide": true,
            "scrollX": true,
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
              url: "<?php echo site_url('dealer/print_receipt/fetch_dp'); ?>",
              type: "POST",
              dataSrc: "data",
              data: function(d) {
                d.summary_terima = true;
                return d;
              },
            },
            "columnDefs": [{
                "targets": [10],
                "orderable": false
              },
              {
                "targets": [9, 10],
                "className": 'text-center'
              },
              // // { "targets":[0],"checkboxes":{'selectRow':true}}
              {
                "targets": [4, 5, 6, 7],
                "className": 'text-right'
              },
              // // { "targets":[2,4,5], "searchable": false } 
            ],
          });
        });
      </script>
    <?php } elseif ($set == "index_pelunasan") { ?>

      <div class="box">
        <div class="box-body">
          <div class="nav-tabs-custom" style="margin-bottom: 10px">
            <ul class="nav nav-tabs">
              <li class=""><a href="<?= base_url('dealer/print_receipt') ?>">Tanda Jadi Sementara</a></li>
              <li class=""><a href="<?= base_url('dealer/print_receipt/dp') ?>">Credit</a></li>
              <li class="active"><a href="<?= base_url('dealer/print_receipt/pelunasan') ?>">Cash</a></li>
            </ul>
          </div>
          <hr style="margin-top: 20px">
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
                <th>ID Cash</th>
                <th>ID SO</th>
                <th>No. SPK</th>
                <th>Nama Konsumen</th>
                <th>Total Harga</th>
                <th>Akumulasi Penerimaan</th>
                <th>Sisa</th>
                <th>Creation Date</th>
                <th>Status</th>
                <th width="5%">Action</th>
              </tr>
            </thead>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
      <?php
      $data['data'] = ['modalRiwayatPenerimaanPembayaran', 'riwayat_no_spk'];
      $this->load->view('dealer/h1_dealer_api', $data);
      ?>
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
              url: "<?php echo site_url('dealer/print_receipt/fetch_pelunasan'); ?>",
              type: "POST",
              dataSrc: "data",
              data: function(d) {
                // d.start_date = $('#start_date').val();
                d.summary_terima = true;
                return d;
              },
            },
            "columnDefs": [{
                "targets": [9],
                "orderable": false
              },
              {
                "targets": [8, 9],
                "className": 'text-center'
              },
              // // { "targets":[0],"checkboxes":{'selectRow':true}}
              {
                "targets": [4, 5, 6],
                "className": 'text-right'
              },
              // // { "targets":[2,4,5], "searchable": false } 
            ],
          });
        });
      </script>
    <?php }  ?>
  </section>
</div>