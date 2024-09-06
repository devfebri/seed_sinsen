	<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class H3_md_ms_target_ahm extends Honda_Controller {

	protected $folder = "h3";
    protected $page   = "h3_md_ms_target_ahm";
    protected $title  = "Master Target AHM";

	public function __construct()
	{		
		parent::__construct();
		//===== Load Database =====
		$this->load->database();
		$this->load->helper('url');
		//===== Load Model =====
		$this->load->model('m_admin');
		$this->load->model('H3_md_ms_target_sales_in_out_ahm_model', 'target_sales_in_out');		
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
		
		$this->template($data);	
	}

	public function add()
	{				
		
		$data['mode']    = 'insert';
		$data['set']     = "form";
		$data['target_ahm'] = '';
		$data['target_ahm_detail'] = '';
		$data['produk'] = $this->db->query('SELECT DISTINCT(produk) FROM ms_h3_md_setting_kelompok_produk');
		$this->template($data);	
	}

	public function save()
	{

		// var_dump($this->input->post());
		// die;

		$this->db->trans_start();
		// $this->validate();

		$data = $this->input->post();

		$this->target_sales_in_out->insert(
			$this->clean_data($data)
		);
		$id_target_dealer = $this->db->insert_id();
		
		
		$this->db->trans_complete();

		if($this->db->trans_status()){
			$result = $this->target_sales_in_out->find($id_target_dealer);
			send_json($result);
		}else{
		  	$this->output->set_status_header(400);
		}
	}

	public function validate(){
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('start_date', 'Periode Awal', 'required');
		$this->form_validation->set_rules('end_date', 'Periode Akhir', 'required');
		$this->form_validation->set_rules('produk', 'Jenis Target Dealer', 'required');
		$this->form_validation->set_rules('target_global', 'Target Dealer Global', 'required');

		$target_dealer_detail = $this->input->post('target_dealer_detail');
			foreach ($target_dealer_detail as $each) {
				$cek_data_dealer = $this->db->select('tsd.id, md.nama_dealer')
				->from('ms_h3_md_target_sales_in_dealer as ts')
				->join('ms_h3_md_target_sales_in_dealer_detail as tsd','ts.id=tsd.id_target_sales_in_dealer')
				->join('ms_dealer as md', 'md.id_dealer = tsd.id_dealer')
				->where('ts.produk', $this->input->post('produk'))
				->where('ts.start_date', $this->input->post('start_date'))
				->where('ts.end_date', $this->input->post('end_date'))
				->where('tsd.id_dealer', $each['id_dealer'])
				// ->where('tsd.target_dealer', $each['target_dealer'])
				->where('tsd.id_target_sales_in_dealer !=', $this->input->post('id'))
				->get()->row_array();
			}
			if(!empty($cek_data_dealer)){
				send_json([
        	        'error_type' => 'validation_error',
        	        'message' => 'Dealer '. $cek_data_dealer['nama_dealer'] . ' telah terdaftar.'
        	    ], 422);
			}

        if (!$this->form_validation->run())
        {
			$this->output->set_status_header(400);
			send_json([
				'error_type' => 'validation_error',
				'message' => 'Data tidak valid',
				'errors' => $this->form_validation->error_array()
			]);
        }
    }

	public function detail(){
		
		$data=array();
		$data['mode']    = 'detail';
		$data['set']     = "form";
		$data['target_ahm'] = $this->db
		->select('ts.*')
		->from('ms_h3_md_target_sales_in_out_ahm as ts')
		->where('ts.id', $this->input->get('id'))
		->get()->row();

		$data['target_ahm_detail'] = $this->db
		->select('tsd.id')
		->select('tsd.jenis_target_part')
		->select('tsd.id_kelompok_part_produk')
		->select('tsd.target_ahm')
		->select('mkp.nama_kelompok_part_produk')
		->from('ms_h3_md_target_sales_in_out_ahm_detail as tsd')
		->join('ms_kelompok_part_produk as mkp', 'mkp.id_kelompok_part_produk=tsd.id_kelompok_part_produk')
		->where('tsd.id_target_sales_in_out_ahm', $this->input->get('id'))
		->get()->result_array()
		;
			
		foreach($data['target_ahm_detail'] as $key=>$row){
				$data['target_ahm_detail'][+$key]['kel_produk_mdp'] = $this->db->query("select id_kelompok_part from ms_kelompok_part mkp where mkp.id_kelompok_part_produk ={$row['id_kelompok_part_produk']} order by id_kelompok_part ASC")->result_array();
		}
		$this->template($data);	
		
	}

	public function edit(){
		$data['mode']    = 'edit';
		$data['set']     = "form";
		$data['id']			= $this->input->get('id');
		$data['target_ahm'] = $this->db
		->select('ts.*')
		->from('ms_h3_md_target_sales_in_out_ahm as ts')
		->where('ts.id', $this->input->get('id'))
		->get()->row();

		$data['target_ahm_detail'] = $this->db
		->select('tsd.id')
		->select('tsd.jenis_target_part')
		->select('tsd.id_kelompok_part_produk')
		->select('tsd.target_ahm')
		->select('mkp.nama_kelompok_part_produk')
		->from('ms_h3_md_target_sales_in_out_ahm_detail as tsd')
		->join('ms_kelompok_part_produk as mkp', 'mkp.id_kelompok_part_produk=tsd.id_kelompok_part_produk')
		->where('tsd.id_target_sales_in_out_ahm', $this->input->get('id'))
		->get()->result_array();

		foreach ($data['target_ahm_detail'] as $key => $row) {
			$data['target_ahm_detail'][+$key]['kel_produk_mdp'] = $this->db->query("select id_kelompok_part from ms_kelompok_part mkp where mkp.id_kelompok_part_produk ={$row['id_kelompok_part_produk']} order by id_kelompok_part ASC")->result_array();
		}

		$this->template($data);	
	}

	public function update()
	{		
		
		$data = $this->input->post();
		$data = $this->clean_data($data);
		$this->target_sales_in_out->update($data,$data['id']);
		if ($this->db->trans_status()) {
			$result = $this->target_sales_in_out->find($data['id']);
			send_json($result);
		} else {
			$this->output->set_status_header(400);
		}

	}

}