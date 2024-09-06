<?php
$no = date('d/m/y_Hi');
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Report Monitoring Pengiriman Barang_".$start_date." s/d ".$end_date.".xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<h4><b><center> Report Monitoring Pengiriman Barang <br> <?php echo $start_date . " s/d " . $end_date ?></center></b></h4>

<table border="1">
	<tr>
		<td align="center"><b>No</b></td>
		<td align="center"><b>Nama Customer</b></td>
		<td align="center"><b>Kode Customer</b></td>
		<td align="center"><b>Wilayah</b></td>
		<td align="center"><b>Kabupaten</b></td>
		<td align="center"><b>Kelompok Barang</b></td>
		<td align="center"><b>Np. DO</b></td>
		<td align="center"><b>Tgl DO</b></td>
		<td align="center"><b>No. PL</b></td>
		<td align="center"><b>Tgl PL</b></td>
		<td align="center"><b>Tgl Scan PL</b></td>
		<td align="center"><b>No. PS</b></td>
		<td align="center"><b>Tgl PS</b></td>
		<td align="center"><b>No. Faktur</b></td>
		<td align="center"><b>Tgl Faktur</b></td>
		<td align="center"><b>No. Surat Jalan</b></td>
		<td align="center"><b>Ekspedisi</b></td>
		<td align="center"><b>Tgl Kirim</b></td>
		<td align="center"><b>Tgl Terima</b></td>
		<td align="center"><b>Status Barang</b></td>
		<td align="center"><b>LeadTimes (Hari)</b></td>
	</tr>
	<?php
	$i=0;
	foreach ($query as $key=>$row) {
	?>
		<tr>
			<td align="center"><?= ++$key ?></td>
			<td align="center"><?= $row['nama_dealer'] ?></td>	
			<td align="center"><?= $row['kode_dealer_md'] ?></td>
			<td align="center"><?= $row['daerah_h3'] ?></td>
			<td align="center"><?= $row['kabupaten'] ?></td>
			<td align="center"><?= $row['produk'] ?></td>
			<td align="center"><?= $row['id_do_sales_order'] ?></td>
			<td align="center"><?= $row['tanggal_do'] ?></td>
			<td align="center"><?= $row['id_picking_list'] ?></td>
			<td align="center"><?= $row['tanggal_pl'] ?></td>
			<td align="center"><?= $row['tanggal_scan_pl'] ?></td>
			<td align="center"><?= $row['id_packing_sheet'] ?></td>
			<td align="center"><?= $row['tanggal_ps'] ?></td>
			<td align="center"><?= $row['no_faktur'] ?></td>
			<td align="center"><?= $row['tanggal_faktur'] ?></td>
			<td align="center"><?= $row['id_surat_pengantar'] ?></td>
			<td align="center"><?= $row['nama_ekspedisi'] ?></td>
			<td align="center"><?= $row['tanggal_sp'] ?></td>
			<td align="center"><?= $row['tanggal_dealer_terima_barang'] ?></td>
			<td align="center"><?= $row['status'] ?></td>
			<td align="center"><?= $row['lead_times'] ?></td>
		</tr>	
	<?php
	}
	?>

</table>