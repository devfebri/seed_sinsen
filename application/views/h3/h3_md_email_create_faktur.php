<?php $this->load->view('email/header'); ?>

<body class="">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
        <tr>
            <td>&nbsp;</td>
            <td class="container">
                <div class="content">
                    <table role="presentation" class="main">
                        <tr>
                            <td height="2" style="width:33.3%;background: rgb(255,0,0);
  background: linear-gradient(90deg, rgba(255,0,0,1) 0%, rgba(255,188,188,1) 50%, rgba(255,0,0,1) 100%);line-height:2px;font-size:2px;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td class="wrapper">
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td align="center">
                                            <p style="border-bottom: 1px solid #D0D0D0;"><img src="<?= base_url('assets/panel/images/logo_sinsen.jpg') ?>" alt="SINARSENTOSA" height="60px">
                                        </td>
                                    </tr>
                                </table>
                                <table>
                                    <tr>
                                        <td>
                                            Kepada Yth,<br>
                                            Bapak/ibu owner <br>
                                            <?= $faktur['nama_dealer'] ?><br>
                                            <br>
                                            Salam satu hati, <br>
                                            Berikut terlampir faktur pembelian spareparts/AHM Oil dengan rincian Sebagai Berikut : <br>


                                            <table style="margin-top: 20px;" class="table">
                                                <tr>
                                                    <td style='border-top: 1px solid black; border-bottom: 1px solid black;'>Tanggal Faktur</td>
                                                    <td style='border-top: 1px solid black; border-bottom: 1px solid black;'>No. Faktur</td>
                                                    <td style='border-top: 1px solid black; border-bottom: 1px solid black;'>Tanggal Jatuh Tempo</td>
                                                    <td style='border-top: 1px solid black; border-bottom: 1px solid black;' class='text-right'>Nilai Faktur</td>
                                                </tr>

                                                <tr>
                                                    <td style='border-top: 1px solid black;' class='text-right'><?= $faktur['tgl_faktur'] ?></td>
                                                    <td style='border-top: 1px solid black;' class='text-right'><?= $faktur['no_faktur'] ?></td>
                                                    <td style='border-top: 1px solid black;' class='text-right'><?= $faktur['tgl_jatuh_tempo'] ?></td>
                                                    <td style='border-top: 1px solid black;' class='text-right'>Rp <?= number_format($faktur['total'], 0, ',', '.') ?></td>
                                                </tr>

                                            </table>
                                            <br>
                                            Silakan download file dibawah ini <br>
                                            Sekian dan terimakasih <br>
                                            <br>
                                            Hormat kami,<br>
                                            PT. Sinar Sentosa Primatama
                                        </td>
                                    </tr>

                                </table>
                    </table>
                    <?php $this->load->view('email/footer'); ?>