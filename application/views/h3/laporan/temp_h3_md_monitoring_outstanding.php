<?php

$no = date('d/m/y_Hi');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Monitoring PO Dealer_" . $no . " WIB.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<caption>
    <center><b>Laporan Monitoring Report <br> Periode <?php echo $start_date . " s/d " . $end_date ?> <br> </b></center>
</caption><br>
<table border="1">
    <tr>
        <th align="center">No</th>
        <th align="center">No PO</th>
        <th align="center">Part Number</th>
        <th align="center">Nama Part</th>
        <th align="center">Tanggal Packing Sheet</th>
        <th align="center">No Packing Sheet</th>
        <th align="center">Kode Karton</th>
        <th align="center">Tanggal SL AHM</th>
        <th align="center">Qty PO</th>
        <th align="center">Qty Unfill </th>
        <th align="center">Qty Intransit </th>
        <th align="center">Qty On Hand </th>
    </tr>
    <?php
    $itemPart = [];
    
    if ($report->num_rows() > 0) {
        // var_dump($report->result());
        // die;
        foreach($report->result() as $key=>$row){
            $number=++$key;
            $qty_onhand = $this->stock_int->qty_diterima($row->id_part_int, $row->packing_sheet_number_int, $row->no_doos);
            // var_dump($qty_onhand);
            $surat_jalan = $this->db->query("SELECT psl.surat_jalan_ahm,date_format(psl.created_at, '%d/%m/%Y') as created_at from tr_h3_md_psl_items psli join tr_h3_md_psl psl on psli.surat_jalan_ahm_int=psl.id where psli.packing_sheet_number_int = 158")->row_array();
            if ($surat_jalan['surat_jalan_ahm'] != null) {
                $qty_intransit = 1;
                $qty_intransit = $row->packing_sheet_quantity - $qty_onhand;
                $tanggal_surat_jalan_ahm = $surat_jalan['created_at'];
                $qty_unfill = 0;
            } else {
                $qty_intransit = 0;
                $tanggal_surat_jalan_ahm = "-";
                $qty_unfill = $surat_jalan['packing_sheet_quantity'];
            }
            // var_dump($row); 
            echo "
                <tr>
                    <td>$number</td>
                    <td>$row->id_purchase_order</td>
                    <td>'$row->id_part</td>
                    <td>$row->nama_part</td>
                    <td align='center'>$row->packing_sheet_date</td>
                    <td>$row->packing_sheet_number</td>
                    <td>$row->no_doos</td>
                    <td align='center'>$tanggal_surat_jalan_ahm</td>
                    <td align='center'>$row->qty_order</td>
                    <td align='center'>$qty_unfill</td>
                    <td align='center'>$qty_intransit</td>
                    <td align='center'>$qty_onhand</td>
                </tr>
            ";
        }
    }
     
    ?>
</table>