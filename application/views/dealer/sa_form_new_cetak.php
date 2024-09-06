<?php
$cek_nama_pembawa_pemilik = explode(',', $row->tipe_coming);
if (in_array('milik', $cek_nama_pembawa_pemilik)) {
  $nama_pembawa_pemilik = $row->nama_customer;
} else {
  $nama_pembawa_pemilik = $row->nama_pembawa;
}
$dealer = dealer($id_dealer);
// send_json($row);
?>
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>Cetak Form Service Advisor</title>
  <style>
    @media print {
      @page {
        sheet-size: 215mm 328mm;
        margin-left: 0.5cm;
        margin-right: 0.5cm;
        margin-bottom: 0.5cm;
        margin-top: 0.5cm;
        height: 100%;
      }

      .text-center {
        text-align: center;
      }

      .table {
        width: 100%;
        max-width: 100%;
        border-collapse: collapse;
        /*border-collapse: separate;*/
      }

      .bottom-right {
        position: absolute;
        /* bottom: 8px;
        right: 16px; */
      }

      .table-bordered tr td {
        border: 1px solid black;
      }

      .bordered {
        border: 1px solid black;
      }

      body {
        font-family: "Arial";
        font-size: 9pt;
      }

      .bold {
        font-weight: bold;
      }
    }
  </style>
</head>

<body>
  <table class="table table-borderedx">
    <tr>
      <td colspan=4 class='bordered' align='center'>
        <table class="table">
          <tr>
            <td width="15%" align='left'>
              <img src="<?= base_url('assets/panel/icon/honda.jpg') ?>" width='100'>
            </td>
            <td align='center' style="font-size:11pt;">
              <?= $dealer->kode_dealer_md ?> - <?= $dealer->nama_dealer ?> <br>
              Alamat : <font style="text-decoration:underline"><?= $dealer->alamat ?> <?= $dealer->no_telp ?></font><br>
              Booking Service & Service Kunjung : <?= $dealer->contact_booking_service ?>
            </td>
            <td width="15%" align='right'>
              <img src="<?= base_url('assets/panel/icon/ahass_jaminan.jpg') ?>" width='100'>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan=4 align='right' class='bordered'><b style='font-size:13pt'>FORM SERVICE ADVISOR &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><b style='font-size:14pt;font-weight:400'><?= substr($row->id_sa_form, -5) ?></b>&nbsp;&nbsp;</td>
    </tr>
    <tr>
      <td colspan=4 class='bordered'>
        <table>
          <tr>
            <!-- Data Motor -->
            <td style='width:36%; vertical-align:top'>
              <table style='font-size:8pt'>

                <tr>
                  <td colspan=2 style="font-size: 9pt;"><b>Data Motor</b></td>
                </tr>
                <tr>
                  <td></td>
                  <td>
                    &nbsp;<img src="<?= base_url('assets/panel/icon/unchecked-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;"> Listrik &nbsp;
                    <img src="<?= base_url('assets/panel/icon/unchecked-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;"> Bensin
                  </td>
                </tr>
                <tr>
                  <td>No. Urut</td>
                  <td>: <?= $row->id_antrian_short ?></td>
                </tr>
                <tr>
                  <td>Tgl. Servis</td>
                  <td>: <?= $row->tgl_servis ?></td>
                </tr>
                <tr>
                  <td>No. Mesin</td>
                  <td>: <?= $row->no_mesin ?></td>
                </tr>
                <tr>
                  <td>No. Seri Baterai EV</td>
                  <td>: <?= $row->serial_number_battery ?></td>
                </tr>
                <tr>
                  <td>No. Rangka</td>
                  <td>: <?= $row->no_rangka ?></td>
                </tr>
                <tr>
                  <td>No. Polisi</td>
                  <td>: <?= $row->no_polisi ?></td>
                </tr>
                <tr>
                  <td>Type</td>
                  <td>: <?= $row->tipe_ahm ?></td>
                </tr>
                <tr>
                  <td>Tahun</td>
                  <td>: <?= $row->tahun_produksi ?></td>
                </tr>
                <tr>
                  <td>KM</td>
                  <td>: <?= mata_uang_rp($row->km_terakhir) ?></td>
                </tr>
                <tr>
                  <td>* Email</td>
                  <td>: <?= $row->email ?></td>
                </tr>
                <tr>
                  <td>* Sosmed</td>
                  <td>: <?= $row->facebook ?></td>
                </tr>
              </table>
            </td>
            <!-- Data Pembawa -->
            <td style='vertical-align:top;width:36%'>
              <table style='font-size:8pt'>
                <tr>
                  <td colspan=2 style="font-size: 9pt;"><b>Data Pembawa</b></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>: <?= $row->nama_pembawa ?></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>: <?= $row->alamat_pembawa ?></td>
                </tr>
                <tr>
                  <td>Kel/Kec</td>
                  <td>: <?= $row->kelurahan_pembawa . '/' . $row->kecamatan_pembawa ?></td>
                </tr>
                <tr>
                  <td>No. Telp/HP</td>
                  <td>: <?= '/' . $row->no_hp_pembawa ?></td>
                </tr>
              </table>
              <table>
                <tr>
                  <td colspan=2 style="font-size: 9pt;"><br> <b>Data Pemilik</b></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>: <?= $row->nama_customer ?></td>
                </tr>
                <tr>
                  <td>Alamat</td>
                  <td>: <?= $row->alamat ?></td>
                </tr>
                <tr>
                  <td>Kel/Kec</td>
                  <td>: <?= $row->kelurahan . '/' . $row->kecamatan ?></td>
                </tr>
                <tr>
                  <td>No. Telp/HP</td>
                  <?php $no_telp = (string)$row->no_telp == '' ? '-' : $row->no_telp; ?>
                  <td>: <?= $no_telp . '/' . $row->no_hp ?></td>
                </tr>
              </table>
            </td>
            <!-- Alasan Ke AHASS & Data Lainnya -->
            <td style='vertical-align:top;width:28%'>
              <table style='font-size:9pt'>
                <tr>
                  <td>Dari Dealer Sendiri :
                    Ya <img src="<?= base_url('assets/panel/icon/checked-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;"> &nbsp;
                    Tidak <img src="<?= base_url('assets/panel/icon/unchecked-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;"></td>
                </tr>
                <tr>
                  <td>Hubungan Pembawa & <br> Pemilik : <?= $row->hubungan_dengan_pemilik == '' ? '-' : $row->hubungan_dengan_pemilik ?></td>
                </tr>
                <tr>
                  <td style="font-size: 9pt;"><br><br> <b>Alasan Ke AHASS</b></td>
                </tr>
                <tr>
                  <td>
                    <div class="<?= $row->alasan_ke_ahass == 'Inisiatif sendiri' ? 'bold' : '' ?>">a. Inisiatif Sendiri</div>
                    <div class="<?= $row->alasan_ke_ahass == 'SMS' ? 'bold' : '' ?>">b. SMS Reminder</div>
                    <div class="<?= $row->alasan_ke_ahass == 'Telepon' ? 'bold' : '' ?>">c. Telp Reminder</div>
                    <div class="<?= $row->alasan_ke_ahass == 'Stiker Reminder' ? 'bold' : '' ?>">d. Sticker Reminder</div>
                    <div class="<?= $row->alasan_ke_ahass == 'Lainnya' ? 'bold' : '' ?>">e. Lainnya</div>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td class='bordered bold' style='font-size:9pt;text-align:center;width:18%'>Kondisi Awal SMH</td>
      <td class='bordered bold' style='font-size:9pt;text-align:center'>Pekerjaan</td>
      <td class='bordered bold' style='font-size:9pt;text-align:center'>Estimasi Biaya</td>
      <td class='bordered bold' style='font-size:9pt;text-align:center;border-bottom-style: hidden;'>Saran Perawatan</td>
    </tr>
    <tr>
      <td rowspan=4 class='bordered' align='center' style='padding-top:5px;vertical-align:top'>
        <table>
          <tr>
            <td style="text-align: left;">Bensin</td>
          </tr>
          <tr>
            <td class='bordered' style='padding:10px'>

              <img src="<?= base_url('assets/panel/icon/fuel-' . (int)$row->informasi_bensin . '.png') ?>" width='100'>
            </td>
          </tr>
          <tr>
            <td style="text-align: left;">Listrik</td>
          </tr>
          <tr>
            <td class='bordered' style='padding:10px'>
              <img src="<?= base_url('assets/panel/icon/fuel-listrik.png') ?>" width='100' alt="snow" style="position: relative;">
              <div style="position: absolute;top: 44.7%;left: 10%;font-size:14pt;"><?php if($row->soc != null){echo $row->soc.' %';} ?></div>
            </td>
          </tr>
        </table>
        <?= $row->catatan_tambahan ?>
      </td>
      <td class='bordered' style="vertical-align:top;font-size:8pt;">
        <ol>
          <?php foreach ($pekerjaan as $pkj) { ?>
            <li><?= $pkj->deskripsi ?></li>
          <?php } ?>
        </ol>
      </td>
      <td class='bordered' style="vertical-align:top;font-size:8pt;">
        <ol>
          <?php foreach ($pekerjaan as $pkj) { ?>
            <li>Rp. <?= mata_uang_rp($pkj->harga) ?></li>
          <?php } ?>
        </ol>
      </td>
      <td rowspan=8 class='bordered' style="vertical-align:top;text-align:center;width:30%">
        <style>
          .febri {
            border: 1px solid black;
            margin: 0;
            /* padding: 0; */
          }
        </style>
        <table style="font-size: 8pt;margin-top:0;margin-top:-5px;">
          <tr>
            <td>Periode Ganti (KM)</td>
            <td>Sparepart</td>
            <td colspan="2">Motor</td>
          </tr>
          <?php foreach ($saran_ganti_utama as $sgs) { ?>
            <tr>
              <td class='febri' style="width: 25%;"><?= $sgs->periode_ganti ?></td>
              <td class='febri'><?= $sgs->sparepart ?></td>
              <td class='febri' <?php if ($sgs->sparepart == 'Busi' || $sgs->sparepart == 'Rantai' || $sgs->sparepart == 'Drive Belt' || $sgs->sparepart == 'Coolant' || $sgs->sparepart == 'Filter Udara') {
                                  echo 'style="background-color: black;"';
                                } ?>>Listrik</td>
              <td class='febri'>Bensin</td>
            </tr>
          <?php } ?>
        </table>
        <div class='bold' style="font-size: 9pt;">Paket Tambahan</div>
        <table style="font-size: 8pt;margin-top:0;width:100%">
          <?php foreach ($saran_ganti_tambahan as $sgs) { ?>
            <tr>
              <td class='febri' style="width: 25%;"><?= $sgs->periode_ganti ?></td>
              <td class='febri'><?= $sgs->sparepart ?></td>
              <td class='febri' style="background-color: black;">Listrik</td>
              <td class='febri'>Bensin</td>
            </tr>
          <?php } ?>
        </table>
      </td>
    </tr>
    <tr>
      <td class='bordered bold' style='font-size:9pt;text-align:center;height:20px'>Suku Cadang</td>
      <td class='bordered bold' style='font-size:9pt;text-align:center'>Estimasi Harga</td>
    </tr>
    <tr>
      <td class='bordered' style='vertical-align:top;font-size:8pt;'>
        <ol>
          <?php foreach ($parts as $pkj) { ?>
            <li><?= $pkj->nama_part ?></li>
          <?php } ?>
        </ol>
      </td>
      <td class='bordered' style='vertical-align:top;font-size:8pt;'>
        <ol>
          <?php foreach ($parts as $pkj) { ?>
            <li>Rp. <?= mata_uang_rp($pkj->harga) ?></li>
          <?php } ?>
        </ol>
      </td>
    </tr>
    <tr>
      <td class='bordered bold' style='font-size:9pt;text-align:center;height:20px'>Total Harga</td>
      <td class='bordered bold' style='font-size:9pt;'>Rp. <?= mata_uang_rp($row->grand_total) ?></td>
    </tr>
    <tr>
      <td colspan=3 class='bordered bold' style='font-size:9pt;text-align:center;height:20px'>Keluhan Konsumen</td>
    </tr>
    <tr>
      <td colspan=3 class='bordered' style='font-size:9pt;text-align:left;vertical-align:top'><?= $row->keluhan_konsumen ?></td>
    </tr>
    <tr>
      <td colspan=3 class='bordered bold' style='font-size:9pt;text-align:center;height:20px'>Analisa Service Advisor</td>
    </tr>
    <tr>
      <td colspan=3 class='bordered' style='font-size:9pt;text-align:left;vertical-align:top'><?= $row->rekomendasi_sa ?></td>
    </tr>
  </table>

  </td>
  </tr>
  </table>

  <table style='font-size:8pt;'>
    <tr>
      <td style='width:60%;font-size:8pt;vertical-align:top'>
        <div class="">Apabila ada tambahan <b>PEKERJAAN/PERGANTIAN PART</b> di luar daftar di atas maka : </div>
        <div class="">
          <?php $chk_pekerjaan = $row->konfirmasi_pekerjaan_tambahan == 'via_no_hp' ? 'checked' : 'unchecked'; ?>
          <img src="<?= base_url('assets/panel/icon/' . $chk_pekerjaan . '-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;">&nbsp;&nbsp;Konfirmasi dulu/telp. ke : <?= $row->no_hp_pembawa ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php $chk_pekerjaan = $row->konfirmasi_pekerjaan_tambahan == 'langsung' ? 'checked' : 'unchecked'; ?>
          <img src="<?= base_url('assets/panel/icon/' . $chk_pekerjaan . '-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;">&nbsp;&nbsp;Langsung dikerjakan
        </div>
        <div>Part bekas dibawa konsumen :
          <img src="<?= base_url('assets/panel/icon/unchecked-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;"> Ya &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <img src="<?= base_url('assets/panel/icon/unchecked-checkbox.png') ?>" width='15' height='15' style="margin-bottom: -3px;"> Tidak
        </div>
      </td>
      <td>
        <div class="bold">Syarat Dan Ketentuan</div>
        <div>
          <ol>
            <li>Formulir ini adalah surat kuasa pekerjaan/PKB</li>
            <li>Bengkel tidak bertanggung jawab terhadap sepeda motor yang tidak diambil dalam 30 hari</li>
            <li>Bengkel tidak bertanggung jawab jika terjadi Force Majeure</li>
          </ol>
        </div>
      </td>
    </tr>
  </table>


  <div class="" style='font-size:8pt'>Dengan ini saya menyatakan bahwa data yang saya berikan dalam formulir ini adalah sesuai dengan kenyataan, lengkap dan benar.</div>

  <div class="" style='font-size:8pt; text-align:justify;'>
    Saya menyadari bahwa dalam rangka senantiasa meningkatkan kualitas produk dan layanan purna jual kepada konsumen, maka kepada PT. CITRA KARYA INTISENTOSA I (AHASS) dan PT. SINAR SENTOSA PRIMATAMA (Main Dealer), dengan ini saya memberikan :
    <ol type="a" style="margin-top:0;margin-bottom:2px;">
      <li>
        Izin kepada PT. SINAR SENTOSA PRIMATAMA selaku Main Dealer yang dalam hal ini berperan sebagai koordinator wilayah dalam hal pelaksanaan kegiatan penyediaan layanan purna jual sesuai dengan ketentuan Undang-Undang Perlindungan
        Konsumen sebagai prasyarat garansi produk untuk melakukan pengumpulan, penyimpanan, dan melakukan kegiatan analisa data berkaitan dengan Produk Sepeda Motor Konsumen dan kualitas layanan yang menjadi preferensi konsumen.
      </li>
      <li>
        Izin kepada PT. CITRA KARYA INTISENTOSA I (AHASS) untuk menggunakan Data Pribadi Konsumen sebagaimana dalam formulir service ini untuk dapat menginformasikan dan berkomunikasi dengan Konsumen melalui berbagai sarana/kanal
        komunikasi (termasuk media sosial) perihal dan dengan tujuan menyampaikan promosi dan informasi lain yang bermanfaat untuk konsumen serta melakukan kajian untuk memahami produk/layanan yang menjadi preferensi konsumen.
      </li>
    </ol>
  </div>
  <table style="width:100%">
    <tr>
      <!-- Persetujuan Pekerjaan -->
      <td>
        <table class='table table-bordered' style='font-size:9pt'>
          <tr>
            <td colspan=2><b>Persetujuan Pekerjaan + Biaya + Waktu</b></td>
          </tr>
          <tr>
            <td style='height:70px;font-size:7pt;vertical-align:bottom;text-align:center;font-style: italic'>Konsumen Ttd</td>
            <td style='height:70px;font-size:7pt;vertical-align:bottom;text-align:center;font-style: italic'>Service Advisor Ttd</td>
          </tr>
        </table>
      </td>
      <!-- Tambahan Pekerjaan -->
      <td>
        <table class='table table-bordered' style='font-size:9pt'>
          <tr>
            <td><b>Tambahan Pekerjaan</b></td>
          </tr>
          <tr>
            <td style='height:70px;font-size:7pt;vertical-align:bottom;text-align:center;font-style: italic'>Konsumen Ttd</td>
          </tr>
        </table>
      </td>
      <!-- Tambahan Pekerjaan -->
      <td>
        <table class='table table-bordered' style='font-size:9pt'>
          <tr>
            <td><b>OK</b></td>
            <td><b>Paraf Final Ins.</b></td>
          </tr>
          <tr>
            <td colspan=2 style='height:70px;font-size:7pt;vertical-align:top;text-align:center'></td>
          </tr>
        </table>
      </td>
      <td>
        <table class='table table-bordered' style='font-size:9pt'>
          <tr>
            <td colspan=2><b>Penyerahan Motor Oleh SA</b></td>
          </tr>
          <tr>
            <td style='width:15px;height:70px;vertical-align:middle;font-size:13pt'>OK</td>
            <td style='height:70px;font-size:7pt;vertical-align:bottom;text-align:center;font-style: italic'>Konsumen Ttd</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <table class='table'>
    <tr>
      <!-- Saran Mekanik -->
      <td style='vertical-align:top;width:70%;'>
        <table class='table table-bordered table-fixed' style='font-size:9pt;vertical-align:top; width:100%'>
          <tr>
            <td colspan=2 style="text-align: center;"><b>Saran Teknisi</b></td>
          </tr>
          <tr>
            <td style='height:62px;vertical-align:top;text-align:left'><?= $row->saran_mekanik ?></td>
            <td style='width:25%;vertical-align:bottom;text-align:left;font-style: italic;font-size:7pt;'>Nama Teknisi : <?= $row->mekanik ?></td>
          </tr>
        </table>
      </td>
      <!-- Estimasi Waktu -->
      <td style="vertical-align:top;">
        <table class='table' style="vertical-align: top;">
          <tr>
            <td class='bordered' align='center' style="font-size: 9pt;"><b>Estimasi Waktu</b></td>
          </tr>
          <tr>
            <td class='bordered' style="height:60px;">
              <table>
                <tr>
                  <td>Pendaftaran</td>
                  <td>: <?= substr($row->estimasi_waktu_daftar, -8) ?></td>
                </tr>
                <tr>
                  <td>Dikerjakan</td>
                  <td>: <?= substr($wo->start_at, -8) ?></td>
                </tr>
                <tr>
                  <td>Selesai</td>
                  <td>: <?= substr($wo->closed_at, -8) ?></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>

  <table class='table'>
    <tr>
      <td>
        <div class="bold" style='font-size:9pt'>Garansi :</div>
        <div class="" style='font-size:8pt'>- 500 Km/1 minggu untuk Servis Reguler</div>
        <div class="" style='font-size:8pt'>- 1.000 Km/1 Bulan untuk Bongkar Mesin Reguler</div>
        <div class="" style='font-size:8pt'>- 1.000 Km/1 Bulan untuk Servis Tipe Motor Tertentu*</div>
        <div class="" style='font-size:8pt'>- 1.500 Km/45 Hari untuk Bongkar Mesin Tipe Motor Tertentu*</div>

        <div class="bold" style='font-size:11pt;padding-top:55px;'>SERVIS RUTIN DI AHASS MOTOR TERAWAT KANTONG HEMAT</div>
        <div style="font-size: 7pt;font-style:italic">* Khusus Type CBR Series, CRF Series, Forza, SH150i, Super CUB 125, ST125 Dax</div>
        <div style="font-size: 7pt;font-style:italic">&nbsp; Honda EV, Monkey, CT125 (sewaktu-waktu dapat berubah/disesuaikan)</div>
      </td>
      <td align='right'>
        <img src="<?= base_url('assets/panel/icon/servis-pasti-dari-yg-ahli.png') ?>" style="text-align: center;" width='300'>
      </td>
    </tr>
  </table>
</body>

</html>