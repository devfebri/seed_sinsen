<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Cetek Surat Pengantar</title>
    <style>
        @media print {
            @page {
                sheet-size: 210mm 297mm;
                margin-left: 2.54cm;
                margin-right: 2.54cm;
                margin-bottom: 2.54cm;
                margin-top: 2.54cm;
            }

            .text-bold {
                font-weight: bold;
            }

            .text-center {
                text-align: center;
            }

            .text-left {
                text-align: left;
            }

            .text-right {
                text-align: right;
            }

            .table {
                width: 100%;
                max-width: 100%;
                border-collapse: collapse;
                /*border-collapse: separate;*/
            }

            .table-bordered tr td {
                border: 1px solid black;
                padding-left: 6px;
                padding-right: 6px;
            }

            body {
                font-family: "Arial";
                font-size: 10pt;
            }

            .top-line td {
                vertical-align: text-top;
            }

            table.small-text td {
                font-size: 10pt;
            }

            .line-through {
                text-decoration: line-through;
            }

            p {
                line-height: 1.5;
            }

            .center {
                margin-left: auto;
                margin-right: auto;
            }

        }
    </style>
</head>

<body>
    <table class="table" style='margin-bottom: 15px;'>
        <tr>
            <td class='text-center text-bold' style='border-bottom: 1px solid black; font-size:16px;'>TANDA TERIMA <br> VOUCHER LAYANAN CEK RANGKA (LCR) <br> &nbsp;
            <td>
        </tr>
    </table>

    <table class="table" style='margin-bottom: 15px;'>
        <tr>
            <td width='16%'>No Surat</td>
            <td width='1%'>:</td>
            <td width='83%'><?= $header->no_surat ?></td>
        </tr>
        <tr>
            <td width='16%'>Kepada</td>
            <td width='1%'>:</td>
            <td width='83%'><?= $header->nama_dealer ?></td>
        </tr>
        <tr>
            <td width='25%'>Tanggal Penyerahan</td>
            <td width='1%'>:</td>
            <td width='74%'><?= $header->tgl_penyerahan ?></td>
        </tr>
        <tr>
            <td width='16%'>Up</td>
            <td width='1%'>:</td>
            <td width='83%'><?= $header->pic ?></td>
        </tr>
    </table>
    <?php


    function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } else if ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim(penyebut($nilai));
        } else {
            $hasil = trim(penyebut($nilai));
        }
        return $hasil;
    }


    $angka = $header->jumlah_vocer;
    ?>
    <p style="text-align: justify;
  text-justify: inter-word;">
        <b>Salam Satu Hati.</b> <br>
        Sehubungan dengan surat No. 2074/SINSEN/TSD/VIII/2024 untuk meningkatkan Pencapaian Layanan Cek
        Rangka ( LCR ) maka dengan ini kami menyerahkan <b><?= $header->jumlah_vocer ?> ( <?= ucfirst(terbilang($angka))  ?> ) Lembar </b> Voucher LCR.
        Voucher ini diberikan khusus kepada konsumen yang unit sepada motornya masuk kedalam program LCR
        namun menolak untuk dilakukan treatment pelapisan antikarat (sebagai kompensasi waktu tunggu atas pengerjaan tersebut).
        Diharapkan program Voucher ini dapat dimanfaatkan dan dimaksimalkan dengan baik, agar dapat meningkatkan
        pencapaian Layanan Cek Rangka. <br><br>
        Berikut adalah rincian Kode Voucher : <br>



    </p>
    <table style="margin-left: auto;
                margin-right: auto;font-size:9pt;vertical-align: top;width:100%">
        <tr>
            <?php if (count($voucher1) != 0): ?>
                <td style="width: 25%;">
                    <table>
                        <?php foreach ($voucher1 as $key => $v1) {
                            echo
                            '<tr>
                                <td style="width: 30%;text-align: center;">' . ++$key . '</td>
                                <td style="width: 70%;text-align: center;">' . $v1["kode_voucher"] . '</td>
                            </tr>';
                        } ?>
                    </table>
                </td>
            <?php endif;
            if (count($voucher2) != 0): ?>
                <td style="width: 25%;">
                    <table >
                        <?php foreach ($voucher2 as $v2) {
                            echo
                            '<tr>
                                <td style="width: 30%;text-align: center;">' . ++$key . '</td>
                                <td style="width: 70%;text-align: center;">' . $v2["kode_voucher"] . '</td>
                            </tr>';
                        } ?>
                    </table>
                </td>
            <?php else: ?>
                <td style="width: 25%;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 30%;text-align: center;"></td>
                            <td style="width: 70%;text-align: center;"></td>
                        </tr>
                    </table>
                </td>
            <?php endif;
            if (count($voucher3) != 0): ?>
                <td style="width: 25%;">
                    <table >
                        <?php foreach ($voucher3 as $v3) {
                            echo
                            '<tr>
                                <td style="width: 30%;text-align: center;">' . ++$key . '</td>
                                <td style="width: 70%;text-align: center;">' . $v3["kode_voucher"] . '</td>
                            </tr>';
                        } ?>
                    </table>
                </td>
            <?php else: ?>
                <td style="width: 25%;">
                    <table >
                        <tr>
                            <td style="width: 30%;text-align: center;"></td>
                            <td style="width: 70%;text-align: center;"></td>
                        </tr>
                    </table>
                </td>
            <?php endif;
            if (count($voucher4) != 0): ?>
                <td style="width: 25%;">
                    <table style="width: 100%;">
                        <?php foreach ($voucher4 as $v4) {
                            echo
                            '<tr>
                                <td style="width: 30%;text-align: center;">' . ++$key . '</td>
                                <td style="width: 70%;text-align: center;">' . $v4["kode_voucher"] . '</td>
                            </tr>';
                        } ?>
                    </table>
                </td>
            <?php else: ?>
                <td style="width: 25%;">
                    <table >
                        <tr>
                            <td style="width: 30%;text-align: center;"></td>
                            <td style="width: 70%;text-align: center;"></td>
                        </tr>
                    </table>
                </td>
            <?php endif; ?>
        </tr>
    </table>
    <p>
        Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.
    </p>
    <p style="margin-top: 40px;">
        Jambi, <?= $tglskrg ?>
    </p>
    <table class="table">
        <tr>
            <td width="33.33%" class="text-center">Yang Menyerahkan,</td>
            <td width="33.33%" class="text-center">Diketahui,</td>
            <td width="33.33%" class="text-center">Yang Menerima,</td>
        </tr>
        <tr>
            <td width="33.33%" class="text-center">
                <br><br><br><br>
                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
            </td>
            <td width="33.33%" class="text-center">
                <br><br><br><br>
                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
            </td>
            <td width="33.33%" class="text-center">
                <br><br><br><br>
                <u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
            </td>
        </tr>
    </table>

</body>

</html>