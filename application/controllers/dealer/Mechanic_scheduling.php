<?php
date_default_timezone_set('Asia/Jakarta');
defined('BASEPATH') or exit('No direct script access allowed');

class Mechanic_scheduling extends CI_Controller
{

	var $folder = "dealer";
	var $page   = "mechanic_scheduling";
	var $title  = "Mechanic Scheduling";

	public function __construct()
	{
		parent::__construct();
		//---- cek session -------//		
		$name = $this->session->userdata('nama');
		if ($name == "") {
			echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "panel'>";
		}

		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
		//===== Load Model =====
		$this->load->model('m_admin');
		//===== Load Library =====
		// $this->load->library('upload');
		$this->load->library('form_validation');
		$this->load->helper('tgl_indo');
		$this->load->helper('terbilang');
		$this->load->model('m_h2_master', 'mh2');
		$this->load->model('m_h2_work_order', 'm_wo');
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
		$data['isi']     = $this->page;
		$data['title']   = $this->title;
		$data['set']     = "index";
		$this->template($data);
	}

	function loadWO()
	{
		$tgl    = gmdate("Y-m-d", time() + 60 * 60 * 7);
		$filter = [
			'id_work_order_not_null' => 'y',
			'id_karyawan_dealer_not_null' => true,
			'status_wo_not' => 'closed',
		];
		$data = $this->m_wo->get_sa_form($filter);
		// $data = $this->m_wo->get_sa_form(null,$tgl,"'open','pause'");
		foreach ($data->result() as $rs) {
			$cek_parts = $this->mh2->cekWONeedParts($rs->id_work_order);
			$status = '';
			$color = '';
			if ($rs->status_wo == 'open') {
				if ($rs->start_at == null) {
					$color = 'red';
					$status = 'New Work Order';
					if ($cek_parts > 0) {
						$filter        = ['good_issue_null' => 'ya', 'id_work_order' => $rs->id_work_order];
						$cek_good    = $this->m_wo->get_kirim_wo($filter);
						if ($cek_good->num_rows() > 0) {
							continue;
						}
					}
				} elseif ($rs->last_stats == null) {
					$color = 'red';
					$status = 'New Work Order';
					if ($cek_parts > 0) {
						$filter        = ['good_issue_null' => 'ya', 'id_work_order' => $rs->id_work_order];
						$cek_good    = $this->m_wo->get_kirim_wo($filter);
						if ($cek_good->num_rows() > 0) {
							continue;
						}
					}
				} elseif ($rs->last_stats == 'pause') {
					$color = '#ff7600';
					$status = 'On A Break';
				} elseif ($rs->last_stats == 'end') {
					$color = '#16a03a';
					$status = 'End';
				} else {
					$color = '#0089ff';
					$status = 'Working';
				}
			}
			if ($rs->status_wo == 'pause') {
				$color = '#ff7600';
				$status = 'On A Break';
				if ($rs->last_stats == 'end') {
					$color = '#16a03a';
					$status = 'End';
				}
			}
			if ($rs->status_wo == 'closed') {
				$color = 'red';
				$status = 'Closed';
			}
			if ($rs->status_wo == 'pending') {
				$color = 'red';
				$status = 'Pending';
			}
			if ($rs->status_wo == 'cancel') {
				$color = 'red';
				$status = 'Cancel';
			}

			// set waktu pekerjaan
			$waktu_pekerjaan  = '';			
			$get_wo = $this->m_wo->get_sa_form(['id_work_order'=>$rs->id_work_order]);
			if($get_wo->num_rows() >0){
				$get_wo                    = $get_wo->row();
				$id_work_order = $rs->id_work_order;
				$tot_waktu_berjalan_simpan = $this->mh2->get_tot_waktu($id_work_order);
				$last_waktu                = $this->mh2->get_last_waktu_wo($id_work_order);
				$tot_waktu_berjalan_real   = 0;
				if ($last_waktu->num_rows() > 0) {
					$last_waktu = $last_waktu->row();
					if ($last_waktu->stats == 'start' || $last_waktu->stats == 'resume') {
						$waktu                   = gmdate("Y-m-d H:i:s");
						$tot_waktu_berjalan_real = strtotime($waktu) - strtotime($last_waktu->set_at);
					}
				}
				$get_wo->etr = $get_wo->etr / 60;

				$te          = ($get_wo->etr * 60) - ($tot_waktu_berjalan_simpan + $tot_waktu_berjalan_real);
				$over        = $te < 0 ? abs($te) : 0;
				$te          = $te < 0 ? 0 : $te;
				$get_wo->etr = $this->selisih($get_wo->etr * 60);
				$get_wo->te  = $this->selisih($te);
				$get_wo->to  = $this->selisih($over);
				
				$waktu_pekerjaan = $get_wo->te;
				if($over>0){
					$waktu_pekerjaan = $get_wo->to;
				}
			}

			$rs_ = [
				'id_antrian' => $rs->id_antrian,
				'id_work_order' => $rs->id_work_order,
				'nama_customer' => $rs->nama_customer,
				'no_polisi'     => $rs->no_polisi,
				'status'        => $status,
				'nama_lengkap'  => $rs->nama_lengkap,
				'id_pit'        => $rs->id_pit,
				'jenis_pit'     => $rs->jenis_pit,
				'etr'           => $rs->etr,
				'tgl_servis'    => $rs->tgl_servis,
				'id_type'        => $rs->id_type,
				'waktu_pekerjaan' => $waktu_pekerjaan,
				'color'			=> $color
			];
			$result[] = $rs_;
		}
		if (isset($result)) {
			$result = ['status' => 'sukses', 'data' => $result];
		} else {
			$result = ['status' => 'error', 'pesan' => 'Data work order kosong !'];
		}
		echo json_encode($result);
	}

	function dt_modal_wo()
	{
		$id_work_order = $this->input->post('id_work_order');
		$filter = ['id_work_order' => $id_work_order];
		$get_wo = $this->m_wo->get_sa_form($filter);
		if ($get_wo->num_rows() > 0) {
			$get_wo                    = $get_wo->row();

			$tot_waktu_berjalan_simpan = $this->mh2->get_tot_waktu($id_work_order);
			$last_waktu                = $this->mh2->get_last_waktu_wo($id_work_order);
			$tot_waktu_berjalan_real   = 0;
			if ($last_waktu->num_rows() > 0) {
				$last_waktu = $last_waktu->row();
				if ($last_waktu->stats == 'start' || $last_waktu->stats == 'resume') {
					$waktu                   = gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
					$tot_waktu_berjalan_real = strtotime($waktu) - strtotime($last_waktu->set_at);
				}
			}
			$get_wo->etr = $get_wo->etr / 60;

			$te          = ($get_wo->etr * 60) - ($tot_waktu_berjalan_simpan + $tot_waktu_berjalan_real);
			$over        = $te < 0 ? abs($te) : 0;
			$te          = $te < 0 ? 0 : $te;
			$get_wo->etr = $this->selisih($get_wo->etr * 60);
			$get_wo->te  = $this->selisih($te);
			$get_wo->to  = $this->selisih($over);
			$result = ['status' => 'sukses', 'data' => $get_wo];
		} else {
			$result = ['status' => 'error', 'pesan' => 'Data Work Order tidak ditemukan !'];
		}
		echo json_encode($result);
	}
	function setClock()
	{
		$id_work_order = $this->input->post('id_work_order');
		$stats         = $this->input->post('stats');
		$waktu         = gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		$login_id      = $this->session->userdata('id_user');
		$post = $this->input->post();

		if ($stats == 'start') {
			$data = [
				'start_at' => $waktu,
				'start_by' => $login_id
			];
			$ins_waktu = [
				'id_work_order' => $id_work_order,
				'set_at' => $waktu,
				'set_by' => $login_id,
				'stats' => 'start',
				'detik' => 0
			];

			// Cek Booking Apakah Dari Customer App, Jika Iya Lakukan Update Status=2 (servis sedang berlangsung)
			$book = $this->db->query("SELECT book.id_booking 
              FROM tr_h2_manage_booking book 
              JOIN tr_h2_sa_form sa ON sa.id_booking=book.id_booking
							JOIN tr_h2_wo_dealer wo ON wo.id_sa_form=sa.id_sa_form
              WHERE wo.id_work_order='$id_work_order' AND IFNULL(customer_apps_booking_number,'')!=''
              ")->row();
			if ($book != null) {
				$upd_book = ['customer_apps_status' => 2, 'updated_at' => waktu_full()];
			}
		}
		if ($stats == 'pause') {
			$data = ['status' => 'pause'];
			$get_last_set = $this->mh2->get_last_waktu_wo($id_work_order)->row()->set_at;
			$detik = strtotime($waktu) - strtotime($get_last_set);
			$ins_waktu = [
				'id_work_order' => $id_work_order,
				'set_at' => $waktu,
				'set_by' => $login_id,
				'stats'  => 'pause',
				'detik'  => $detik
			];
		}
		if ($stats == 'pending') {
			$data = ['status' => 'pending'];
			$get_last_set = $this->mh2->get_last_waktu_wo($id_work_order)->row()->set_at;
			$detik = strtotime($waktu) - strtotime($get_last_set);
			$ins_waktu = [
				'id_work_order' => $id_work_order,
				'set_at' => $waktu,
				'set_by' => $login_id,
				'stats'  => 'pending',
				'detik'  => $detik
			];
		}
		if ($stats == 'resume') {
			$data = ['status' => 'open'];
			$ins_waktu = [
				'id_work_order' => $id_work_order,
				'set_at' => $waktu,
				'set_by' => $login_id,
				'stats'  => 'resume',
				'detik'  => 0
			];
		}
		// send_json($stats);
		if ($stats == 'closed') {
			// send_json($post);
			// $data = ['status'=>'closed'];
			//Cek Jika Ada HLO Belum Selesai
			$filter = [
				'id_work_order' => $id_work_order,
				'select' => 'id_booking',
				'not_exists_picking_slip' => true,
				'group_by' => 'id_booking'
			];
			$cek_hlo_belum_selesai = $this->m_wo->getHLOWOParts($filter);
			if ($cek_hlo_belum_selesai->num_rows() > 0) {
				$result = [
					'status' => 'error',
					'pesan' => 'Masih ada parts HLO yang belum selesai di proses !',
				];
				echo json_encode($result);
				die();
			}
			$filter = [
				'id_work_order' => $id_work_order,
				'select' => 'nomor_so',
				'jenis_order' => 'reguler',
				'nomor_so_null' => true
			];
			$cek_reg_belum_selesai = $this->m_wo->getWOParts($filter);

			if ($cek_reg_belum_selesai->num_rows() > 0) {
				$result = [
					'status' => 'error',
					'pesan' => 'Masih ada parts reguler yang belum selesai di proses !',
				];
				echo json_encode($result);
				die();
			}

			$cek_stat_wo = $this->db->get_where('tr_h2_wo_dealer', ['id_work_order' => $id_work_order])->row()->status;
			$detik = 0;
			if ($cek_stat_wo == 'open') {
				$get_last_set = $this->mh2->get_last_waktu_wo($id_work_order)->row()->set_at;
				$detik = strtotime($waktu) - strtotime($get_last_set);
			}
			$ins_waktu = [
				'id_work_order' => $id_work_order,
				'set_at' => $waktu,
				'set_by' => $login_id,
				'stats'  => 'end',
				'detik'  => $detik
			];
		}
		// $tes = ['status' => 'error', 'pesan' => 'Tes', 'ins_waktu' => $ins_waktu, 'upd' => $data];

		$this->db->trans_begin();
		if (isset($data)) {
			$this->db->update('tr_h2_wo_dealer', $data, ['id_work_order' => $id_work_order]);
		}
		if (isset($ins_waktu)) {
			if ($id_work_order == NULL) {
				$rsp_error = [
					'status' => 'error',
					'pesan' => 'Terjadi kesalahan. ID Work Order kosong. Silahkan refresh halaman '
				];
				echo json_encode($rsp_error);
				die();
			}
			$this->db->insert('tr_h2_wo_dealer_waktu', $ins_waktu);
		}

		if (isset($upd_book)) {
			$this->db->update('tr_h2_manage_booking', $upd_book, ['id_booking' => $book->id_booking]);
			$this->load->library('mokita');
			$this->load->model('m_h2_booking');
			$request = $this->m_h2_booking->service_process($id_work_order, 2);
			$this->mokita->service_process($request);
		}
		
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
				'data_sheduling' => null
			];
		}
		echo json_encode($rsp);
	}

	function selisih($detik)
	{
		$jumlah_jam = floor($detik / 3600);

		//Untuk menghitung jumlah dalam satuan menit:
		$sisa = $detik % 3600;
		$jumlah_menit = floor($sisa / 60);

		//Untuk menghitung jumlah dalam satuan detik:
		$sisa = $sisa % 60;
		$jumlah_detik = floor($sisa / 1);

		return $jumlah_jam . ' jam ' . $jumlah_menit . ' menit ' . $jumlah_detik . ' detik';
	}

	function save()
	{
		$waktu     = gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
		$tgl       = date("Y-m-d");
		$login_id  = $this->session->userdata('id_user');
		$id_dealer = $this->m_admin->cari_dealer();
		$id_absen  = $this->get_id_absen();
		$tanggal   = $this->input->post('tanggal');

		$ins_data 		= [
			'id_absen' => $id_absen,
			'tanggal'    => $tanggal,
			'id_dealer'  => $id_dealer,
			'created_at' => $waktu,
			'created_by' => $login_id,
		];

		$absen = $this->input->post('absen');
		foreach ($absen as $keys => $val) {
			$ins_details[] = [
				'id_absen' => $id_absen,
				'id_karyawan_dealer' => $val['id_karyawan_dealer'],
				'aktif' => $val['aktif'] == 'true' ? 1 : null,
			];
		}
		// $result = ['ins_data'=>$ins_data,'ins_details'=>$ins_details];
		// echo json_encode($result);
		// exit();
		$this->db->trans_begin();
		$this->db->insert('tr_h2_absen_mekanik', $ins_data);
		if (isset($ins_details)) {
			$this->db->insert_batch('tr_h2_absen_mekanik_detail', $ins_details);
		}
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
				'link' => base_url('dealer/absen_mekanik')
			];
			$_SESSION['pesan'] 	= "Data berhasil disimpan.";
			$_SESSION['tipe'] 	= "success";
			// echo "<meta http-equiv='refresh' content='0; url=".base_url()."dealer/mutasi_stok/add'>";
		}
		echo json_encode($rsp);
	}

	public function get_id_absen()
	{
		$th        = date('y');
		$bln       = date('m');
		$tgl       = date('Y-m');
		$thbln     = date('ymd');
		$id_dealer = $this->m_admin->cari_dealer();
		$dealer    = $this->db->get_where('ms_dealer', ['id_dealer' => $id_dealer])->row();
		$get_data  = $this->db->query("SELECT id_absen FROM tr_h2_absen_mekanik
			WHERE id_dealer='$id_dealer'
			AND LEFT(created_at,7)='$tgl'
			ORDER BY created_at DESC LIMIT 0,1");
		if ($get_data->num_rows() > 0) {
			$row        = $get_data->row();
			$last_number = substr($row->id_absen, -4);
			$new_kode   = $dealer->kode_dealer_md . '/' . $thbln . '/ABS/' . sprintf("%'.04d", $last_number + 1);
			$i = 0;
			while ($i < 1) {
				$cek = $this->db->get_where('tr_h2_absen_mekanik', ['id_absen' => $new_kode])->num_rows();
				if ($cek > 0) {
					$gen_number    = substr($new_kode, -4);
					$new_kode = $dealer->kode_dealer_md . '/' . $thbln . '/ABS/' . sprintf("%'.04d", $gen_number + 1);
					$i = 0;
				} else {
					$i++;
				}
			}
		} else {
			$new_kode = $dealer->kode_dealer_md . '/' . $thbln . '/ABS/0001';
		}
		return strtoupper($new_kode);
	}

	function showDetailAbsensi()
	{
		$tanggal = $this->input->post('tanggal');
		$filter[]  = ['tanggal' => $tanggal];
		if (isset($_POST['cek_tanggal'])) {
			if ($_POST['cek_tanggal'] == 'y') {
				$cek_tanggal = $this->mh2->get_absen_mekanik($filter);
				if ($cek_tanggal->num_rows() > 0) {
					$result = ['status' => 'error', 'pesan' => 'Absensi untuk tanggal ' . $tanggal . ' sudah ada !'];
					echo json_encode($result);
					exit();
				}
			}
		}
		$get_abs = $this->mh2->get_detail_absen_mekanik(null, $tanggal);
		if ($get_abs->num_rows() == 0) {
			$result = ['status' => 'error', 'pesan' => 'Data karyawan tidak ditemukan !'];
		} else {
			$result = ['status' => 'sukses', 'data' => $get_abs->result()];
		}
		echo json_encode($result);
	}
}
