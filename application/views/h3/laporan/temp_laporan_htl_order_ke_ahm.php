<?php
$no = date('d/m/y_Hi');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Monitoring Hotline Order Dealer_" . $no . " WIB.xls");
header("Pragma: no-cache");
header("Expires: 0");

?>
<?php
$start_date_2 = date("d-m-Y", strtotime($start_date));
$end_date_2 = date("d-m-Y", strtotime($end_date));
?>
<center>
	<?php if ($id_dealer != 'all') { ?>
		<caption><b>HOTLINE ORDER MONITORING REPORT
				<br> <?php echo $laporan_htl_order_ke_ahm->row()->nama_dealer ?>
				<br> Periode <?php echo $start_date_2 . " s/d " . $end_date_2 ?></b><br><br></caption>

	<?php } else { ?>
		<caption><b>HOTLINE ORDER MONITORING REPORT
				<br> Periode <?php echo $start_date_2 . " s/d " . $end_date_2 ?>
			</b><br><br></caption>
	<?php } ?>
</center>
<caption style="caption-side: left;text-align:left;"><b>DITERUSKAN KE AHM </b></caption>
<table border="1">

	<tr>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>No</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Cust</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>No. Hotline Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Nama Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Kota</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>No. Hotline Main Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>P/N</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Description</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Qty</b></td>
		<td style="vertical-align : middle;text-align:center;" colspan="2"><b>Tgl Order</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>ETD AHM</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>ETD MD</b></td>
		<td style="vertical-align : middle;text-align:center;" colspan="3"><b>PENERIMAAN BARANG DARI AHM</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Keterangan</b></td>
	</tr>
	<tr>
		<td style="vertical-align : middle;text-align:center;"><b>Dealer-MD</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>MD-AHM</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>No.</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Tgl PS</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Tgl Faktur</b></td>
	</tr>
	<?php
	// var_dump($laporan_htl_order_ke_ahm->result());
	// die;
	foreach ($laporan_htl_order_ke_ahm->result() as $key => $row) {
		// $data_po2 = isset($data_po[$key]) ? $data_po[$key] : (object) array('tgl_packing_sheet_ahm' => '', 'tgl_parts_diterima_md' => '');
		$nomor = ++$key;
		echo "
		<tr>
			<td style='vertical-align : middle;text-align:center;'>$nomor</td>
			<td style='vertical-align : middle;text-align:center;'>$row->nama_customer</td>
			<td style='vertical-align : middle;text-align:center;'>$row->referensi_po_hotline</td>
			<td style='vertical-align : middle;text-align:center;'>$row->nama_dealer</td>
			<td style='vertical-align : middle;text-align:center;'>$row->alamat</td>
			<td style='vertical-align : middle;text-align:center;'>$row->id_purchase_order</td>
			<td style='vertical-align : middle;text-align:center;'>$row->id_part</td>
			<td style='vertical-align : middle;text-align:center;'>$row->nama_part</td>
			<td style='vertical-align : middle;text-align:center;'>$row->qty_order</td>
			<td style='vertical-align : middle;text-align:center;'>$row->tanggal_po_md</td>
			<td style='vertical-align : middle;text-align:center;'>$row->tanggal_po_ahm</td>
			<td style='vertical-align : middle;text-align:center;'>$row->etd_ahm_to_md</td>
			<td style='vertical-align : middle;text-align:center;'>$row->eta_dealer</td>
			<td style='vertical-align : middle;text-align:center;'>$row->no_penerimaan_barang</td>
			<td style='vertical-align : middle;text-align:center;'>$row->packing_sheet_date</td>
			<td style='vertical-align : middle;text-align:center;'>$row->invoice_date</td>
			<td style='vertical-align : middle;text-align:center;'></td>
			<td></td>
		</tr>
		";
	}
	?>
</table>