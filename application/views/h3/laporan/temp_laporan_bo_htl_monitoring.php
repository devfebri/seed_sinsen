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
$date_now = date('d-m-Y');


$query = $laporan_bo_htl_monitoring->result_array();

$total_bo = array_sum(array_column($query, 'bo'));

//* total dealer
$arr = array();
foreach ($query as $key => $item) {
	$arr[$item['id_dealer']][$key] = $item;
}
ksort($arr, SORT_NUMERIC);
$total_dealer = count($arr);

//* total po
$arr1 = array();
foreach ($query as $key => $item) {
	$arr1[$item['id_purchase_order']][$key] = $item;
}
ksort($arr1, SORT_NUMERIC);
$total_po = count($arr1);
?>
<center>
	<?php if ($id_dealer != 'all') { ?>
		<caption><b>HOTLINE BACK ORDER REPORT
				<br> PT. SINAR SENTOSA PRIMATAMA - ABUNJANI
				<br> Periode <?php echo $start_date_2 . " s/d " . $end_date_2 ?></b><br><br></caption>

	<?php } else { ?>
		<caption><b>HOTLINE BACK ORDER REPORT
				<br> PT. SINAR SENTOSA PRIMATAMA - ABUNJANI
				<br> Periode <?php echo $start_date_2 . " s/d " . $end_date_2 ?>
			</b><br><br></caption>
	<?php } ?>
</center>
<caption style="caption-side: left;text-align:left;"><b>Dibuat Tanggal : <?= $date_now ?> &nbsp;&nbsp; Total BO : <?= $total_bo ?> &nbsp;&nbsp; Total Dealer : <?= $total_dealer ?>&nbsp; &nbsp; Total PO Hotline : <?= $total_po ?></b></caption>
<table border="1">

	<tr>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>No</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>No. Hotline Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Nama Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Kota</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>No. Hotline Main Dealer</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>P/N</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Description</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Qty</b></td>
		<td style="vertical-align : middle;text-align:center;" colspan="2"><b>Tgl Order</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>ETD MD</b></td>
		<td style="vertical-align : middle;text-align:center;" rowspan="2"><b>Keterangan</b></td>
	</tr>
	<tr>
		<td style="vertical-align : middle;text-align:center;"><b>Dealer-MD</b></td>
		<td style="vertical-align : middle;text-align:center;"><b>MD-AHM</b></td>
	</tr>
	<?php
	foreach ($laporan_bo_htl_monitoring->result() as $key => $row) {
		$nomor = ++$key;
		echo "
			<tr>
				<td style='vertical-align : middle;text-align:center;'>$nomor</td>
				<td style='vertical-align : middle;text-align:center;'>$row->po_id</td>
				<td style='vertical-align : middle;text-align:center;'>$row->nama_dealer</td>
				<td style='vertical-align : middle;text-align:center;'>$row->alamat</td>
				<td style='vertical-align : middle;text-align:center;'>$row->id_purchase_order</td>
				<td style='vertical-align : middle;text-align:center;'>$row->id_part</td>
				<td style='vertical-align : middle;text-align:center;'>$row->nama_part</td>
				<td style='vertical-align : middle;text-align:center;'>$row->qty_order</td>
				<td style='vertical-align : middle;text-align:center;'>$row->tanggal_po_md</td>
				<td style='vertical-align : middle;text-align:center;'>$row->tanggal_po_ahm</td>
				<td style='vertical-align : middle;text-align:center;'>$row->etd_ahm_to_md</td>
				<td style='vertical-align : middle;text-align:center;'></td>
			</tr>
			";
	}
	?>
</table>