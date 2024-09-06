<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher_lcr extends CI_Controller
{

	var $folder 	=   "master";
	var $page		=	"voucher_lcr";
	var $title  	=   "Master Voucher LCR";

	public function __construct()
	{
		parent::__construct();

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
		//===== Load Model =====
		$this->load->model('m_admin');
		//===== Load Library =====
		// $this->load->library('upload');
		$this->load->helper('tgl_indo');
		$this->load->model('H2_md_voucher_lcr_model', 'm_voucher');
	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if ($name == "") {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "panel'>";
		} else {
			$this->load->view('template/header', $data);
			$this->load->view('template/aside');
			$this->load->view($this->folder . "/" . $this->page);
			$this->load->view('template/footer');
		}
	}

	public function index()
	{
		$data['isi']        = $this->page;
		$data['title']      = $this->title;
		$data['set']        = "view";
		
		$this->template($data);
	}
	

	public function add()
	{
		$data['isi']    = $this->page;
		$data['title']	= $this->title;
		$data['set']	= "add";
		$data['dealer']	= $this->m_voucher->dealer();
		$data['row'] 	= [
			'id'     		=> '',
			'kode_voucher'     		=> '',
			'nilai_voucher'     	=> '',
			'no_surat'     			=> '',
			'id_dealer'     		=> '',
			'start_date'     		=> '',
			'end_date'     			=> '',
			'qty'     				=> '',
			'expired_date'     		=> '',
			'status'				=> '',
			'tgl_assign_dealer'		=> '',
		];
		$this->template($data);
	}

	public function add_surat_pengantar()
	{
		$data['isi']    = $this->page;
		$data['title']	= 'Surat Pengantar';
		$data['set']		= "add_surat_pengantar";
		$data['dealer']	= $this->m_voucher->dealer();
		$data['no_surat'] = $this->m_voucher->generateNomorSurat();
		$data['row'] 	= [
			'id'     		=> '',
			'kode_voucher'     		=> '',
			'nilai_voucher'     	=> '',
			'no_surat'     			=> '',
			'id_dealer'     		=> '',
			'start_date'     		=> '',
			'end_date'     			=> '',
			'qty'     				=> '',
			'expired_date'     		=> '',
			'status'				=> '',
			'tgl_assign_dealer'		=> '',
		];
		$this->template($data);
	}
	
	public function simpan()
	{
		$updated_at = date('Y-m-d H:i:s');
		if($this->input->post('save')=='insert'){
			$data 	= [
				'kode_voucher'     		=> $this->input->post('kode_voucher'),
				'nilai_voucher'     	=> $this->input->post('nilai_voucher'),
				'no_surat'     			=> $this->input->post('no_surat'),
				'id_dealer'     		=> $this->input->post('kode_dealer_md'),
				'start_date'     		=> $this->input->post('periode_filter_start'),
				'end_date'     			=> $this->input->post('periode_filter_end'),
				'qty'     				=> $this->input->post('qty'),
				'status'				=> 'new',
			];
			$respon = $this->m_voucher->simpan($data);
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/voucher_lcr'>";
		}else if($this->input->post('save')=='edit'){
			$data 	= [
				'start_date'     		=> $this->input->post('periode_filter_start'),
				'end_date'     			=> $this->input->post('periode_filter_end'),
				'expired_date'     		=> $this->input->post('tgl_expired'),
				'status'				=> $this->input->post('status'),
				'updated_at'			=> $updated_at,
			];
			
			$respon=$this->m_voucher->update($data);
			$id=$this->input->post('ids');
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/voucher_lcr/detail?id_voucher=$id'>";
		}
		

		
	}
	public function save() 
	{
		$kode_voucher=$this->input->post('kode_voucher');
		$nilai_voucher=$this->input->post('nilai_voucher');
		$qty=$this->input->post('qty');
		$valKodeVoucher=0;
		$valNilaiVoucher=0;
		$valQty=0;

		foreach($kode_voucher as $row){
			if($row==''||$row==null){
				++$valKodeVoucher;
			}
		}
		foreach($nilai_voucher as $row1){
			if ($row1 == '' || $row1 == null) {
				++$valNilaiVoucher;
			}
		}
		foreach ($qty as $row2) {
			if ($row2 == '' || $row2 == null) {
				++$valQty;
			}
		}
		$validasiKodeVoucher=array();
		foreach($kode_voucher as $key=>$row3){
			$this->db->select('vl.kode_voucher');
			$this->db->from('tr_h2_voucher_lcr vl');
			$this->db->where('vl.kode_voucher =',$row3);
			$cek=$this->db->get()->row();
			if($cek != null) {
				$validasiKodeVoucher[$key] = $cek->kode_voucher;
			}
		}

		$cekDuplicate = array_diff_assoc($kode_voucher, array_unique($kode_voucher));
		if($validasiKodeVoucher){
			$msg = [
				'failed' => 1,
				'datavalidasi'=>implode(", ", $validasiKodeVoucher)
			];
			echo json_encode($msg);
		}else if($cekDuplicate){
			$msg = [
				'failed' => 2,
				'dataduplicate' => implode(", ", $cekDuplicate)
			];
			echo json_encode($msg);
		}else{
			if ($valKodeVoucher == 0 && $valNilaiVoucher == 0 && $valQty == 0 && $this->input->post('periode_filter') != '' && $this->input->post('periode_filter_start') != '' && $this->input->post('periode_filter_end') != '') {
				$this->m_voucher->save();
				$_SESSION['pesan'] 	= "Data has been saved successfully";
				$_SESSION['tipe'] 	= "success";
				$msg = [
					'success' => 'Voucher LCR berhasil disimpan'
				];
				echo json_encode($msg);
			} else {
				$msg = [
					'failed' => 3
				];
				echo json_encode($msg);
			}
		}
	}
	public function save_surat_pengantar()
	{
		$no_surat		= $this->input->post('no_surat');
		$kode_voucher 	= $this->input->post('kode_voucher');
		$dealer       	= $this->input->post('kode_dealer_md');
		$valKodeVoucher = 0;
		
		foreach ($kode_voucher as $row) {
			if ($row == '' || $row == null) {
				++$valKodeVoucher;
			}
		}
		$validasiKodeVoucher = array();
		foreach ($kode_voucher as $key => $row3) {
			$this->db->select('vl.kode_voucher');
			$this->db->from('tr_h2_voucher_lcr vl');
			$this->db->where('vl.kode_voucher =', $row3);
			$this->db->where('vl.status =','new');
			$cek = $this->db->get()->row();
			if ($cek != null) {
				$validasiKodeVoucher[$key] = $cek->kode_voucher;
			}
		}
		$jmlValidasiVoucher= count($validasiKodeVoucher);
		$jmlKodeVoucher=count($kode_voucher);
		$cekData = array_diff_assoc($kode_voucher, array_unique($validasiKodeVoucher));
		$dataTidakAdaDiDatabase= implode(", ", $cekData);
		
		$cekDuplicate = array_diff_assoc($kode_voucher, array_unique($kode_voucher));
		if ($cekDuplicate) {
			$msg = [
				'failed' => 1,
				'dataDuplicate' => implode(", ", $cekDuplicate)
			];
			echo json_encode($msg);
		} else if ($jmlKodeVoucher==$jmlValidasiVoucher&& $dealer!=''&& $valKodeVoucher==0) {
			// var_dump('success');
			// die;
			$this->m_voucher->save_surat();
			$_SESSION['pesan'] 	= "Data has been saved successfully";
			$_SESSION['tipe'] 	= "success";
			$msg = [
				'success' => 'Surat Pengantar berhasil disimpan'
			];
			echo json_encode($msg);
		}else if($kode_voucher!=$jmlValidasiVoucher&&$cekData!=''){
			$msg = [
				'failed' => 2,
				'dataValidasiDB' => implode(", ", $cekData)
			];
			echo json_encode($msg);
		}else {
			$msg = [
				'failed' => 3,
			];
			echo json_encode($msg);
		}
	}

	public function detail()
	{
		
		$data['isi']    = $this->page;
		$data['title']	= $this->title;
		$id_voucher = $this->input->get('id_voucher');
		$data['dealer']	= $this->m_voucher->dealer();
		$respon=$this->m_voucher->getQueryDetail($id_voucher);
		if ($respon->num_rows() > 0) {
			$data['row'] = $respon->row_array();
			$data['set']		= "form";
			$data['mode']		= "detail";	
			$this->template($data);
		} else {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/voucher_lcr'>";
		}
	}

	public function edit()
	{
		$data['isi']    = $this->page;
		$data['title']	= $this->title;
		$id_voucher = $this->input->get('id_voucher');

		$data['dealer']	= $this->m_voucher->dealer();
		$respon = $this->m_voucher->getQueryDetail($id_voucher);
		if ($respon->num_rows() > 0) {
			$data['row'] = $respon->row_array();
			$data['set']		= "form";
			$data['mode']		= "edit";
			// send_json($data);
			$this->template($data);
		} else {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/voucher_lcr'>";
		}
	}
	
	public function proses_import()
	{
		$filenya = 'uploads/voucher_lcr/import_data_voucher.xlsx';
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

		// Fungsi untuk melakukan proses upload file
		$return = array();
		$this->load->library('upload'); // Load librari upload

		$config['upload_path'] = './uploads/voucher_lcr/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size'] = '2048';
		$config['overwrite'] = true;
		$config['file_name'] = 'import_data_voucher';
		// var_dump($this->upload->do_upload('import_file'));
		// die;
		$this->upload->initialize($config); // Load konfigurasi uploadnya
		if ($this->upload->do_upload('import_file')) { // Lakukan upload dan Cek jika proses upload berhasil
			// Jika berhasil :
			$return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
			// return $return;
		} else {
			// Jika gagal :
			$return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
			// return $return;
		}
		// print_r($return);exit();
		
		$excelreader = new PHPExcel_Reader_Excel2007();
		$loadexcel = $excelreader->load($filenya); // Load file yang telah diupload ke folder excel
		$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);
		// var_dump($sheet);
		// die;
		// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
		$data = array();
		$error = '';

		$numrow = 1;
		
		foreach ($sheet as $row) {
			// Cek $numrow apakah lebih dari 1
			// Artinya karena baris pertama adalah nama-nama kolom
			// Jadi dilewat saja, tidak usah diimport

			if ($numrow > 1) {
				// Kita push (add) array data ke variabel data

				if (!empty($row['A']) and !empty($row['B'])) {

					//validasi array 
					$kode_voucher = $row['A'];
					$cek_kode_voucher = $this->db->get_where('tr_h2_voucher_lcr', array('kode_voucher' => $kode_voucher));
					if ($cek_kode_voucher->num_rows() > 0) {

						// tambahkan list error
						$error .= "<b>Kode Voucher : $kode_voucher </b> sudah ada di database <br> silahkan dicek kembali dan import ulang.";
						$_SESSION['pesan'] 	= $error;
						$_SESSION['tipe'] 	= "error";
						echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/voucher_lcr'>";
						exit();
					} else {


						array_push($data, array(
							'kode_voucher'		=> $row['A'],
							'nilai_voucher'		=> $row['B'],
							'qty'				=> $row['C'],
							'start_date' 		=> $row['D'],
							'end_date'			=> $row['E'],
							'status'			=> 'new',
						));
					}
				}
			}

			$numrow++; // Tambah 1 setiap kali looping
		}

		$simpan = $this->db->insert_batch('tr_h2_voucher_lcr', $data);
		unlink($filenya);
		if ($simpan) {
			$_SESSION['pesan'] 	= "Data has been import successfully <br>";
			$_SESSION['tipe'] 	= "success";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/voucher_lcr'>";
		} else {
			$_SESSION['pesan'] 	= $error;
			$_SESSION['tipe'] 	= "error";
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "master/voucher_lcr'>";
		}
	}

	public function surat_pengantar(){
		$data['isi']        = $this->page;
		$data['title']      = 'Surat Pengantar';
		$data['set']        = "surat_pengantar";

		$this->template($data);
	}
	function ambildata()
	{
		$set='voucher';
		if ($this->input->is_ajax_request() == true) {

			$list = $this->m_voucher->get_datatables($set);
			$data = array();
			$no = $_POST['start'];

			foreach ($list as $row) {
				$id = $row['id'];
				$no++;
				$row['action']  = "<a href=\"master/voucher_lcr/detail?id_voucher=$id\" class=\"btn btn-xs btn-flat btn-info\">View</a>";

				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->m_voucher->count_all($set),
				"recordsFiltered" => $this->m_voucher->count_filtered($set),
				"data" => $data,
			);
			//output dalam format JSON
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	function ambildatasurat()
	{
		$set='surat';
		if ($this->input->is_ajax_request() == true) {

			$list = $this->m_voucher->get_datatables($set);
			$data = array();
			$no = $_POST['start'];

			foreach ($list as $row) {
				$id = $row['no_surat'];
				$no++;
				$row['action']  = "<a href=\"master/voucher_lcr/surat_pengantar_cetak?no_surat=$id\" class=\"btn btn-xs btn-flat btn-warning\">Cetak</a>";
				$date = date_create($row['tgl_assign_dealer']);
				
				$row['tgl_penyerahan']=
				date_format($date, "d/m/Y H:i:s");
				$data[] = $row;
			}

			$output = array(
				"draw" => $_POST['draw'],
				"recordsTotal" => $this->m_voucher->count_all($set),
				"recordsFiltered" => $this->m_voucher->count_filtered($set),
				"data" => $data,
			);
			//output dalam format JSON
			echo json_encode($output);
		} else {
			exit('Maaf data tidak bisa ditampilkan');
		}
	}

	function surat_pengantar_cetak()
	{
		
		$no_surat= $this->input->get('no_surat');
		$data=[];
		$data['header']=$this->db->query("	
			select no_surat , md.nama_dealer , md.pic,date(tgl_assign_dealer) as tgl_penyerahan , count(1) as jumlah_vocer
			from tr_h2_voucher_lcr thvl 
			JOIN ms_dealer md on md.id_dealer =thvl.id_dealer
			where no_surat ='" . $no_surat . "' 
			group by no_surat")->row();

		$data['voucher']= $this->db->query("
			select vl.kode_voucher from tr_h2_voucher_lcr vl 
			WHERE vl.no_surat = '".$no_surat."'")->result_array();

		
		$jml1	= count($data['voucher']);
		 $hasil=ceil($jml1 / 4);
		 $p1=$hasil*1; //2
		 $p2=$hasil*2; //4
		 $p3=$hasil*3; //6
		//  var_dump($hasil);
		//  die;
		if($jml1<=10){
			$data['voucher1'] = array_slice($data['voucher'], 0, 10);
			$data['voucher2'] = 0;
			$data['voucher3'] = 0;
			$data['voucher4'] = 0;
		}else if($jml1<=20){
			$data['voucher1'] = array_slice($data['voucher'], 0, 10);
			$data['voucher2'] = array_slice($data['voucher'], 10, 10);
			$data['voucher3'] = 0;
			$data['voucher4'] = 0;

		}else if($jml1<=30){
			$data['voucher1'] = array_slice($data['voucher'], 0, 10);
			$data['voucher2'] = array_slice($data['voucher'], 10, 10);
			$data['voucher3'] = array_slice($data['voucher'], 20, 10);
			$data['voucher4'] = 0;

		}else if($jml1<=40){
			$data['voucher1'] = array_slice($data['voucher'], 0, 10);
			$data['voucher2'] = array_slice($data['voucher'], 10, 10);
			$data['voucher3'] = array_slice($data['voucher'], 20, 10);
			$data['voucher3'] = array_slice($data['voucher'], 30, 10);
		}else{
			$data['voucher1'] = array_slice($data['voucher'], 0, $hasil);
			$data['voucher2'] = array_slice($data['voucher'], $p1, $hasil);
			$data['voucher3'] = array_slice($data['voucher'], $p2, $hasil);
			$data['voucher4'] = array_slice($data['voucher'], $p3, $hasil);
		}
		
		
		$data['tglskrg']=date('d F Y');
		require_once APPPATH . 'third_party/mpdf/mpdf.php';
		$mpdf = new Mpdf();
		$html = $this->load->view('master/voucher_lcr_cetak', $data, true);
		$mpdf->WriteHTML($html);
		$mpdf->Output("{$data['purchase_order']['id_purchase_order']}.pdf", "I");
	}
}
