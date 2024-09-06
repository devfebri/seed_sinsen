<?php
$no = date('d/m/y_Hi');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Monitoring Hotline Order Dealer_" . $no . " WIB.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<?php $start_date_2 = date("d-m-Y", strtotime($start_date));
$end_date_2 = date("d-m-Y", strtotime($end_date)); ?>

<center>
	<?php if ($id_dealer != 'all') { ?>
		<caption><b>HOTLINE ORDER MONITORING REPORT
				<br> <?php echo $laporan_htl_dph_md->row()->nama_dealer ?>
				<br> Periode <?php echo $start_date_2 . " s/d " . $end_date_2 ?></b><br><br></caption>

	<?php } else { ?>
		<caption><b>HOTLINE ORDER MONITORING REPORT
				<br> Periode <?php echo $start_date_2 . " s/d " . $end_date_2 ?>
			</b><br><br></caption>
	<?php } ?>
</center>

<caption style="caption-side: left;text-align:left;"><b>DIPENUHI OLEH MAIN DEALER</b></caption>
<table border="1">
	<tr>
		<td style="vertical-align : middle;text-align:center;"><b>No</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Cust</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>No. Hotline Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Nama Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Kota</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>P/N</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Description</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Qty</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Tgl Order Dealer-MD</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>ETD MD</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Tgl Dipenuhi</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>Keterangan</b></td>
	</tr>
	<?php
	foreach ($laporan_htl_dph_md->result() as $key => $row) {
		// $data_bo2 = isset($data_bo[$key]) ? $data_bo[$key] : (object) array('bo' => '', 'tgl_dipenuhi' => '');
		$nomor = ++$key;
		echo "
			<tr>
				<td style='vertical-align : middle;text-align:center;'>$nomor</td>
				<td style='vertical-align : middle;text-align:center;'>$row->nama_customer</td>
				<td style='vertical-align : middle;text-align:center;'>$row->po_id</td>
				<td style='vertical-align : middle;text-align:center;'>$row->nama_dealer</td>
				<td style='vertical-align : middle;text-align:center;'>$row->alamat</td>
				<td style='vertical-align : middle;text-align:center;'>$row->id_part</td>
				<td style='vertical-align : middle;text-align:center;'>$row->nama_part</td>
				<td style='vertical-align : middle;text-align:center;'>$row->kuantitas</td>
				<td style='vertical-align : middle;text-align:center;'>$row->tgl_po_dealer</td>
				<td style='vertical-align : middle;text-align:center;'>$row->etd_ahm_to_md</td>
				<td style='vertical-align : middle;text-align:center;'>$row->tgl_dipenuhi</td>
				<td style='vertical-align : middle;text-align:center;'></td>
			</tr>
			";
	}
	?>
</table>