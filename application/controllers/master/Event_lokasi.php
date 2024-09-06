<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_lokasi extends CI_Controller {

    var $tables =   "ms_event_location";	
		var $folder =   "master";
		var $page		=		"event_lokasi";
    var $pk     =   "id_spot_btl";
    var $title  =   "Master Data Event Lokasi";

	public function __construct()
	{		
		parent::__construct();
		
		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
		//===== Load Model =====
		$this->load->model('m_admin');		
		$this->load->model('m_event_location');		
		//===== Load Library =====
		$this->load->library('upload');
		
		$name = $this->session->userdata('nama');
		$auth = $this->m_admin->user_auth($this->page,"select");		
		$sess = $this->m_admin->sess_auth();						
		if($name=="" OR $auth=='false')
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."denied'>";
		}elseif($sess=='false'){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."crash'>";
		}

	}
	protected function template($data)
	{
		$name = $this->session->userdata('nama');
		if($name=="")
		{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."panel'>";
		}else{						
			$data['id_menu'] = $this->m_admin->getMenu($this->page);
			$data['group'] 	= $this->session->userdata("group");
			$this->load->view('template/header',$data);
			$this->load->view('template/aside');			
			$this->load->view($this->folder."/".$this->page);		
			$this->load->view('template/footer');
		}
	}


	public function index()
	{			
		// $this->jsonEventLokasi();
		$data['isi']    = $this->page;		
		$data['title']	= $this->title;															
		$data['set']	= "view";
		$this->template($data);	
	}

	public function add()
	{				
		$data['isi']    = $this->page;		
		$data['title']	= $this->title;		
		$data['set']	= "insert";								
		$this->template($data);	
	}

	public function save() {
		$spot_btl = $this->input->post('spot_btl');
        $alamat = $this->input->post('alamat');
        $id_kelurahan = $this->input->post('id_kelurahan');
        $kelurahan = $this->input->post('kelurahan');
        $id_provinsi = $this->input->post('id_provinsi');
        $provinsi = $this->input->post('provinsi');
        $id_kabupaten = $this->input->post('id_kabupaten');
        $kabupaten = $this->input->post('kabupaten');
        $id_kecamatan = $this->input->post('id_kecamatan');
        $kecamatan = $this->input->post('kecamatan');
        $longitude = $this->input->post('longitude');
        $latitude = $this->input->post('latitude');
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $status = $this->input->post('status');
        $active = $this->input->post('active');
		$waktu 			= gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		$login_id		= $this->session->userdata('id_user');
        
        $id_spot_btl = $this->get_id_spot_btl($id_kelurahan,'');
        
        $data = array(
            'id_spot_btl' => $id_spot_btl,
            'spot_btl' => $spot_btl,
            'alamat' => $alamat,
            'id_provinsi' => $id_provinsi,
            'provinsi' => $provinsi,
            'id_kabupaten' => $id_kabupaten,
            'kabupaten' => $kabupaten,
            'id_kelurahan' => $id_kelurahan,
            'kelurahan' => $kelurahan,
            'id_kecamatan' => $id_kecamatan,
            'kecamatan' => $kecamatan,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'status' => $status,
            'active' => $active,
            'created_at' => $waktu,
			'created_by'=> $login_id
        );
		$ktg_notif      = $this->db->get_where('ms_notifikasi_kategori', ['id_notif_kat' => 10])->row();
		$notif = [
			'id_notif_kat' => $ktg_notif->id_notif_kat,
			'id_referensi' => $id_spot_btl,
			'judul'        => "Event Baru Dari MD",
			'pesan'        => "Terdapat Event yang diinisiasi oleh Main Dealer, klik untuk melihat detail.",
			'link'         => $ktg_notif->link . '/detail?nt=y&id=' . $id_spot_btl,
			'status'       => 'baru',
		];

		$this->db->trans_begin();
        $this->m_event_location->insert_event_location($data);
		$this->db->insert('tr_notifikasi', $notif);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$rsp = [
				'status' => 'error',
				'pesan' => ' Something went wrong'
			];
		} else {
			$this->db->trans_commit();
			$rsp = [
				'status' => 'sukses',
				'link' => base_url('master/event_lokasi/add')
			];
			$_SESSION['pesan'] 	= "Data has been saved successfully";
			$_SESSION['tipe'] 	= "success";
		}
		echo json_encode($rsp);

		return redirect('master/event_lokasi/add');
    }
	public function edit($id_spot_btl = null) {
		$data['isi']   = $this->page;
		$data['title'] = "Edit " . $this->title;
		$data['set']   = "edit";
		$data['form']  = "edit";
		$id_spot_btl 		= $this->input->get("id_spot");
		$ev_location = $this->db->get_where('ms_event_location', ['id_spot_btl' => $id_spot_btl]);
		if ($ev_location->num_rows() > 0) {
			$row = $data['dt_location'] = $ev_location->row();
			if (isset($_GET['set'])) {
			}
			// send_json($data);
			$dt_kk = $this->db->query("
			SELECT * 
			FROM ms_kelurahan kel
			LEFT JOIN ms_kecamatan kec ON kec.id_kecamatan=kel.id_kecamatan
			LEFT JOIN ms_kabupaten kab ON kab.id_kabupaten=kec.id_kabupaten
			LEFT JOIN ms_provinsi prov ON prov.id_provinsi=kab.id_provinsi WHere kel.id_kelurahan='{$row->id_kelurahan}'
			")->row();
			$data['dt_location']->kelurahan = $dt_kk->kelurahan;
			$data['dt_location']->kecamatan = $dt_kk->kecamatan;
			$data['dt_location']->kabupaten = $dt_kk->kabupaten;
			$data['dt_location']->provinsi =$dt_kk->provinsi;
			$this->template($data);
		}
	}
	
	public function update() {
		$id_spot_btl_int = $this->input->post('id_spot_btl_int');
		$spot_btl = $this->input->post('spot_btl');
		$alamat = $this->input->post('alamat');
		$id_kelurahan = $this->input->post('id_kelurahan');
		$kelurahan = $this->input->post('kelurahan');
		$id_provinsi = $this->input->post('id_provinsi');
		$provinsi = $this->input->post('provinsi');
		$id_kabupaten = $this->input->post('id_kabupaten');
		$kabupaten = $this->input->post('kabupaten');
		$id_kecamatan = $this->input->post('id_kecamatan');
		$kecamatan = $this->input->post('kecamatan');
		$longitude = $this->input->post('longitude');
		$latitude = $this->input->post('latitude');
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$status = $this->input->post('status');
		$active = $this->input->post('active');

		$waktu 			= gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		$login_id		= $this->session->userdata('id_user');
		

		$id_spot_btl = $this->get_id_spot_btl($id_kelurahan,'');
		$data = array(
			'id_spot_btl' => $id_spot_btl,
			'spot_btl' => $spot_btl,
			'alamat' => $alamat,
			'id_provinsi' => $id_provinsi,
			'provinsi' => $provinsi,
			'id_kabupaten' => $id_kabupaten,
			'kabupaten' => $kabupaten,
			'id_kelurahan' => $id_kelurahan,
			'kelurahan' => $kelurahan,
			'id_kecamatan' => $id_kecamatan,
			'kecamatan' => $kecamatan,
			'longitude' => $longitude,
			'latitude' => $latitude,
			'start_date' => $start_date,
			'end_date' => $end_date,
			'status' => $status,
			'active' => $active,
			'updated_at' => $waktu,
			'updated_by' => $login_id,
		);
	
		$this->db->where('id_spot_btl_int', $id_spot_btl_int);
		$this->db->update('ms_event_location', $data);
		
		$_SESSION['pesan'] = "Data has been updated successfully";
		$_SESSION['tipe'] = "success";
		redirect('master/event_lokasi');
	}
    private function get_id_spot_btl($id_kelurahan) {
		$th_bln = date('Y-m');
	
		$get_data = $this->db->query("SELECT * FROM ms_event_location
			WHERE LEFT(created_at,7)='$th_bln' 
			AND id_kelurahan = '$id_kelurahan'
			ORDER BY created_at DESC LIMIT 1");
		
		if ($get_data->num_rows() > 0) {
			$row = $get_data->row();
			$id_spot_btl = substr($row->id_spot_btl, -4);
			$new_kode = 'E20/' . $id_kelurahan . '/' . sprintf("%'.04d", $id_spot_btl + 1);
		} else {
			$new_kode = 'E20/' . $id_kelurahan . '/' . '0001';
		}
	
		$i = 0;
		while ($i < 1) {
			$cek = $this->db->get_where('ms_event_location', ['id_spot_btl' => $new_kode])->num_rows();
			if ($cek > 0) {
				$neww = substr($new_kode, -4);
				$new_kode = 'E20/' . $id_kelurahan . '/' . sprintf("%'.04d", $neww + 1);
				$i = 0;
			} else {
				$i++;
			}
		}
	
		return strtoupper($new_kode);
	}
	
	

	public function take_kec()
	{
		$id_kelurahan	= $this->input->post('id_kelurahan');		
		$sql = 'SELECT kelurahan, id_kecamatan, kode_pos FROM ms_kelurahan WHERE id_kelurahan = ?';
		$data = $this->db->query($sql, array(htmlentities($id_kelurahan)));
		if($data->num_rows()>0){
			$dt_kel			= $data->row();
			$kelurahan 		= $dt_kel->kelurahan;
			$id_kecamatan = $dt_kel->id_kecamatan;
			$dt_kec				= $this->db->query("SELECT id_kabupaten, kecamatan FROM ms_kecamatan WHERE id_kecamatan = '$id_kecamatan'")->row();
			$kecamatan 		= $dt_kec->kecamatan;
			$id_kabupaten = $dt_kec->id_kabupaten;
			$dt_kab				= $this->db->query("SELECT id_provinsi, kabupaten FROM ms_kabupaten WHERE id_kabupaten = '$id_kabupaten'")->row();
			$kabupaten  	= $dt_kab->kabupaten;
			$id_provinsi  = $dt_kab->id_provinsi;
			$dt_pro				= $this->db->query("SELECT provinsi FROM ms_provinsi WHERE id_provinsi = '$id_provinsi'")->row();
			$provinsi  		= $dt_pro->provinsi;

			echo $id_kecamatan . "|" . $kecamatan . "|" . $id_kabupaten . "|" . $kabupaten . "|" . $id_provinsi . "|" . $provinsi . "|" . $kelurahan . "|" . $kode_pos;
		}else{
			echo  "|||||||";
		}
	}

	public function ajax_list()
	{
		$list = $this->m_kelurahan->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $isi) {
			$cek = $this->m_admin->getByID("ms_kecamatan", "id_kecamatan", $isi->id_kecamatan);
			$kabupaten = '';
			if ($cek->num_rows() > 0) {
				$t = $cek->row();
				$kecamatan = $t->kecamatan;
				$kab = $this->db->get_where('ms_kabupaten', ['id_kabupaten' => $t->id_kabupaten]);
				$kabupaten = $kab->num_rows() > 0 ? $kab->row()->kabupaten : '';
			} else {
				$kecamatan = "";
			}
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $isi->id_kelurahan . '-' . $isi->kelurahan;
			$row[] = $kecamatan;
			$row[] = $kabupaten;
			$row[] = "<button title=\"Choose\" data-dismiss=\"modal\" onclick=\"chooseitem('$isi->id_kelurahan')\" class=\"btn btn-flat btn-success btn-sm\"><i class=\"fa fa-check\"></i></button>";
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->m_kelurahan->count_all(),
			"recordsFiltered" => $this->m_kelurahan->count_filtered(),
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function jsonEventLokasi()
	{
		$startDate = $this->input->post('startDate');
		$endDate = $this->input->post('endDate');
		$status = $this->input->post('status');
		$dataEvent = $this->m_event_location->getEventLocation($startDate, $endDate, $status);
		$data = array();

		foreach ($dataEvent as $e_location) {
			$row = array();
			$row['id_spot_btl_int'] = $e_location->id_spot_btl_int;
			$row['id_spot_btl'] = $e_location->id_spot_btl;
			$row['spot_btl'] = $e_location->spot_btl;
			$row['status'] = $e_location->status;
			$row['alamat'] = $e_location->alamat;
			$row['id_provinsi'] = $e_location->id_provinsi;
			$row['id_kabupaten'] = $e_location->id_kabupaten;
			$row['id_kecamatan'] = $e_location->id_kecamatan;
			$row['kecamatan'] = $e_location->kecamatan;
			$row['id_kelurahan'] = $e_location->id_kelurahan;
			$row['kelurahan'] = $e_location->kelurahan;
			$row['longitude'] = $e_location->longitude;
			$row['latitude'] = $e_location->latitude;
			$row['start_date'] = $e_location->start_date;
			$row['end_date'] = $e_location->end_date;
			$row['active'] = $e_location->active;

			$data[] = $row;
		}

		$result = array(
			'draw' => @$_POST['draw'],
			'recordsTotal' => $this->m_event_location->countAllEventLocation(),
			'recordsFiltered' => $this->m_event_location->countFilterEventLocation($startDate, $endDate, $status),
			'data' => $data,
		);

		echo json_encode($result);
	}
	public function exportExcel()
    {
        $startDate = $this->input->get('startDate');
        $endDate = $this->input->get('endDate');
        $status = $this->input->get('status');
        $searchValue = $this->input->get('search');

        $temp_file = $this->m_event_location->exportToExcel($startDate, $endDate, $status, $searchValue);

        $filename = 'Event_Lokasi_' . date('YmdHis') . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Content-Length: ' . filesize($temp_file));

        readfile($temp_file);

        unlink($temp_file);
    }

	public function getKelurahanName($id_kelurahan) {
		$this->load->model('m_event_location');
		$kelurahan = $this->m_event_location->getKelurahanById($id_kelurahan);
		echo json_encode($kelurahan);
	}

	public function getKecamatanName($id_kecamatan) {
		$this->load->model('m_event_location');
		$kecamatan = $this->m_event_location->getKecamatanById($id_kecamatan);
		echo json_encode($kecamatan);
	}
	
}