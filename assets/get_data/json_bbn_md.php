<?php 
function cari_id(){	
	$conn 					= mysqli_connect("123.100.226.36","sinarsen_root","success2019**","sinarsen_honda");
	$th 						= date("y");
	$bln 						= date("m");		
	$tgl 						= date("d");		
	$pr_num 				= mysqli_query($conn,"SELECT * FROM ms_bbn_dealer ORDER BY id_bbn_dealer DESC LIMIT 0,1");						
	if(mysqli_num_rows($pr_num)>0){
		$row 	= mysqli_fetch_array($pr_num,MYSQLI_ASSOC);
		$pan  = strlen($row['id_bbn_dealer'])-5;
		$id 	= substr($row['id_bbn_dealer'],$pan,5)+1;	
		if($id < 10){
				$kode1 = $th.$bln.$tgl."/BBN-D-MD/0000".$id;          
    }elseif($id>9 && $id<=99){
				$kode1 = $th.$bln.$tgl."/BBN-D-MD/000".$id;                    
    }elseif($id>99 && $id<=999){
				$kode1 = $th.$bln.$tgl."/BBN-D-MD/00".$id;          					          
    }elseif($id>999){
				$kode1 = $th.$bln.$tgl."/BBN-D-MD/0".$id;                    
    }
		$kode = $kode1;
	}else{
		$kode = $th.$bln.$tgl."/BBN-D-MD/"."00001";
	} 	
	return $kode;
}



$conn 					= mysqli_connect("123.100.226.36","sinarsen_root","success2019**","sinarsen_honda");
$json = file_get_contents('http://www.sinarsentosa.co.id/sharing/get_bbn_dealer_md.php');
$obj = json_decode($json,true);
// //print_r($obj);
$no = 0;
foreach($obj as $array){
	$id_tipe_kendaraan =  $array['id_tipe_kendaraan'];
	$biaya_bbn =  $array['biaya_bbn'];
	$biaya_instansi =  $array['biaya_instansi'];
	$biaya_instansi =  $array['biaya_instansi'];
	$active =  $array['active'];
	if($active == 'f') $active = 0;
		else $active = 1;
	$date 		= gmdate("y-m-d h:i:s", time()+60*60*7);
	$login_id	= 1;
	$cek = mysqli_query($conn,"SELECT * FROM ms_bbn_dealer WHERE id_tipe_kendaraan = '$id_tipe_kendaraan'");
	$jum = mysqli_num_rows($cek);
	if($jum == 0){			
		$id = cari_id();
		mysqli_query($conn,"INSERT INTO ms_bbn_dealer VALUES ('$id','$id_tipe_kendaraan','$biaya_bbn','$biaya_instansi','$date','$login_id','0000-00-00 00:00:00','0','$active')");			 									
	}else{
		mysqli_query($conn,"UPDATE ms_bbn_dealer SET biaya_bbn = '$biaya_bbn', biaya_instansi = '$biaya_instansi', active = '$active' WHERE id_tipe_kendaraan = '$id_tipe_kendaraan'");			 									
	}  
	$no++;
}
echo $no." Data berhasil dieksekusi";
?>
