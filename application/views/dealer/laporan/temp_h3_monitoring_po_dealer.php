<?php

$no = date('d/m/y_Hi');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Monitoring PO Dealer_" . $no . " WIB.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<caption>
    <center><b>Hotline Order Monitoring Report <br> Periode <?php echo $start_date . " s/d " . $end_date ?> <br> </b></center>
</caption><br>
<table border="1">
    <tr>
        <th align="center">No PO HTL Dealer</th>
        <th align="center">Tgl PO Dealer</th>
        <th align="center">Tanggal Submit Dealer to MD</th>
        <th align="center">Tgl Dealer Terima Barang</th>
        <th align="center">No Penerimaan Barang</th>
        <th align="center">Tgl Dealer Terbit NSC</th>
        <th align="center">No NSC AHASS</th>
        <th align="center">Nama Konsumen</th>
        <th align="center">Alamat Konsumen </th>
        <th align="center">No Telp Konsumen</th>
        <th align="center">Email Konsumen</th>
        <th align="center">No Rangka </th>
        <th align="center">No Mesin</th>
        <th align="center">Item No</th>
        <th align="center">Part Number</th>
        <th align="center">Deskripsi</th>
        <th align="center">Order</th>
        <th align="center">Supply</th>
        <th align="center">BO</th>
        <th align="center">Status Barang</th>
        <th align="center">Kelompok Part</th>
    </tr>

    <?php
    $itemPart = [];
    if ($report->num_rows() > 0) {
        foreach ($report->result() as $key => $row) {

            $nsc = $this->db->query("
            SELECT nsc.tgl_nsc as tgl_nsc , nsc.no_nsc as no_nsc FROM tr_h3_dealer_sales_order as so  
                LEFT JOIN tr_h23_nsc as nsc on nsc.id_referensi = so.nomor_so 
                join tr_h23_nsc_parts nscp on nsc.no_nsc=nscp.no_nsc 
                WHERE so.booking_id_reference = '$row->id_booking' and nscp.id_part_int='$row->id_part_int'
            ")->row();

            $gr = $this->db->query("
                SELECT SUM(grp.qty) as supply,gr.tanggal_receipt as tgl_penerimaan, gr.id_good_receipt  FROM tr_h3_dealer_good_receipt gr 
                join tr_h3_dealer_good_receipt_parts grp on gr.id_good_receipt = grp.id_good_receipt 
                WHERE gr.nomor_po ='$row->po_id' AND grp.id_part_int = '$row->id_part_int' AND grp.qty > 0
            ")->row();

            $po_id = $row->po_id;
            if (!isset($itemPart[$po_id])) {
                $itemPart[$po_id] = 1;
            }
            $item = $itemPart[$po_id];

            $bo = $row->jml_order - $gr->supply;
            if ($bo != 0) {
                $s_barang = 'Belum Selesai';
            } else {
                $s_barang = 'Selesai';
            }
            if ($nsc != null) {
                $tglnsc = $nsc->tgl_nsc;
                $nonsc = $nsc->no_nsc;
            } else {
                $tglnsc = '';
                $nonsc = '';
            }

            $tgl_po_dealer = date('d/m/Y', strtotime($row->tgl_po_dealer));
            $tgl_submit_dealer_to_md = date('d/m/Y', strtotime($row->tgl_submit_dealer_to_md));
            $tgl_penerimaan = date('d/m/Y', strtotime($gr->tgl_penerimaan));
            echo "
 			<tr>
                
                <td>$row->po_id</td>
                <td>$tgl_po_dealer</td>
                <td>$tgl_submit_dealer_to_md</td>
                <td>$tgl_penerimaan</td>
                <td>$gr->id_good_receipt</td>
                <td>$tglnsc</td>
                <td>$nonsc</td>
                <td>$row->nama_konsumen</td>
                <td>$row->alamat_konsumen</td>
                <td>'$row->no_tlp</td>
                <td>$row->email</td>
                <td>$row->no_rangka</td>
                <td>$row->no_mesin</td>
                <td align='center'>$item</td>
                <td>$row->part_number</td>
                <td>$row->deskripsi</td>
                <td align='center'>$row->jml_order</td>
                <td align='center'>$gr->supply</td>
                <td align='center'>$bo</td>
                <td align='center'>$s_barang</td>
                <td align='center'>$row->kelompok_part</td>
 			</tr>
	 	";
            $itemPart[$po_id]++;
        }
    } else {

        echo "<td colspan='27' style='text-align:center'> Maaf, Tidak Ada Data </td>";
    }

    ?>

</table>