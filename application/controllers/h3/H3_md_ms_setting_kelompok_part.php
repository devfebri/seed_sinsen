<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class H3_md_ms_setting_kelompok_part extends Honda_Controller {

	protected $folder = "h3";
    protected $page   = "h3_md_ms_setting_kelompok_part";
    protected $title  = "Master Setting Kelompok Part";

	public function __construct()
	{		
		parent::__construct();
		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
		//===== Load Model =====
		$this->load->model('m_admin');
		$this->load->model('H3_md_ms_setting_kelompok_part_model', 'setting_kelompok_part');
		//===== Load Library =====
		$this->load->library('upload');
		$this->load->library('form_validation');
		//---- cek session -------//		
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

	public function index()
	{				
		$data['set']	= "index";
		$data['part']	= $this->db->query('select id,id_kelompok_part from ms_kelompok_part');
		$this->template($data);	
	}

	public function add()
	{
		
		if($this->input->post('id')){
			//* Edit data
			$data=[
				'id_kelompok_part_produk'	=> $this->input->post('id',true),
				'nama_kelompok_part_produk'	=> $this->input->post('kel_part_produk'),
				'kel_barang_mdp'			=>	$this->input->post('kel_barang_mdp'),
			];
			$this->setting_kelompok_part->updateMsPartProduk($data);
			$msg = [
					'sukses' => 'data kelompok produk berhasil diubah'
				];
			echo json_encode($msg);
		}else{
			//* tambah data
			$data=[
				'nama_kelompok_part_produk'	=> $this->input->post('kel_part_produk'),
			];
			$this->setting_kelompok_part->insert($data);
			$insert_id=$this->db->insert_id();
			foreach($this->input->post('kel_barang_mdp') as $row){
				$dataUpdate = [
					'id_kelompok_part_produk'=>$insert_id,
				];
				$this->setting_kelompok_part->updateMsPart($row,$dataUpdate);
			}
			$msg = [
				'sukses' => 'data kelompok produk berhasil disimpan'
			];
			echo json_encode($msg);
		}
	}
	
	public function edit(){
		if ($this->input->is_ajax_request() == true) {
			$id = $this->input->post('id', true);
			$dataKelProduk = $this->setting_kelompok_part->ambilData($id);
			$idKelProduk= $dataKelProduk["id_kelompok_part_produk"];
			$data['id_kelompok_part_produk']=$dataKelProduk["id_kelompok_part_produk"];
			$data['nama_kelompok_part_produk']= $dataKelProduk["nama_kelompok_part_produk"];
			$data['data_kel_part']=$this->db->query('select mkp.id_kelompok_part from ms_kelompok_part mkp where mkp.id_kelompok_part_produk = '. $idKelProduk)->result_array();
			$dataSelected=$this->db->query("select mkpp.id_kelompok_part_produk,mkp.id_kelompok_part from ms_kelompok_part_produk mkpp 
				join ms_kelompok_part mkp on mkp.id_kelompok_part_produk =mkpp.id_kelompok_part_produk 
				WHERE mkpp.id_kelompok_part_produk ={$id} ")->result_array();
			$semuaKel = $this->db->query('select mkp.id_kelompok_part from ms_kelompok_part mkp')->result_array();
			$semuaKelSelect=array();
			foreach($semuaKel as $row){
				$select='';
				foreach($dataSelected as $row1){
					if($row['id_kelompok_part']==$row1['id_kelompok_part']){
						$select = 'selected';
					}
				}
				$row['select']=$select;
				$semuaKelSelect[]=$row;
			}
			$data['data_fix']=$semuaKelSelect;
			echo json_encode($data);
		}
	}
	
}
