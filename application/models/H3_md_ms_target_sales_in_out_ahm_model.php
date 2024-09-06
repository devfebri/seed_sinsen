<?php

class H3_md_ms_target_sales_in_out_ahm_model extends Honda_Model{

    protected $table = 'ms_h3_md_target_sales_in_out_ahm';

    public function insert($data){
		$data['created_at'] = date('Y-m-d H:i:s', time());
		$data['created_by'] = $this->session->userdata('id_user');


		//! target sales in out header

		$dataHeader=array(
			'start_date'=>$data['start_date'],
			'end_date'=>$data['end_date'],
			'jenis_target'=>$data['jenis_target'],
			'target_global_sales_in'=>$data['tg_sales_in'],
			'target_global_sales_out'=>$data['tg_sales_out'],
			'created_at'=>$data['created_at'],
			'created_by'=>$data['created_by']
		);
		$this->db->trans_start();
		$this->db->insert('ms_h3_md_target_sales_in_out_ahm',$dataHeader);
		$headerId = $this->db->insert_id();
		$this->db->trans_complete();

		

		//! target sales in out detail
		$jenisTarget=$this->input->post('jenis_target');
		if($jenisTarget=='Parts'){
			$target=$this->input->post('target');
			$dataarray=$this->input->post();
			// var_dump($dataarray);
			// die;	
			if (count($target) > 0) {
				foreach ($target as $item => $value) {
					$dataDetail = array(
						'id_target_sales_in_out_ahm' => $headerId,
						'jenis_target_part' => $dataarray['jenis_target_part'][$item],
						'id_kelompok_part_produk' => $dataarray['id_kelompok_part_produk'][$item],
						'target_ahm' => $dataarray['target'][$item]
					);
	
					$this->db->insert('ms_h3_md_target_sales_in_out_ahm_detail', $dataDetail);
				}
			}
		}
	}

    public function update($data, $condition){
		$data['updated_at'] = date('Y-m-d H:i:s', time());
		$data['updated_by'] = $this->session->userdata('id_user');

		//! febri : update header
		$dataHeader = array(
			'target_global_sales_in' => $data['tg_sales_in'],
			'target_global_sales_out' => $data['tg_sales_out'],
			'start_date' => $data['start_date'],
			'end_date' => $data['end_date'],
			'jenis_target' => $data['jenis_target'],
			'updated_at' => $data['updated_at'],
			'updated_by' => $data['updated_by']
		);
		$this->db->trans_start();
		$this->db->where('id', $data['id']);
		$this->db->update('ms_h3_md_target_sales_in_out_ahm', $dataHeader);
		$this->db->trans_complete();

		$this->db->trans_start();
		$this->db->delete('ms_h3_md_target_sales_in_out_ahm_detail', array('id_target_sales_in_out_ahm' => $data['id']));
		$this->db->trans_complete();
		
		$jenisTarget = $data['jenis_target'];
		// var_dump($data);
		// die;
		
		if ($jenisTarget == 'Parts') {
			$target = $data['target'];
			
			if (count($target) > 0) {
				foreach ($target as $item => $value) {
					$dataDetail = array(
						'id_target_sales_in_out_ahm' => $data['id'],
						'jenis_target_part' => $data['jenis_target_part'][$item],
						'id_kelompok_part_produk' => $data['id_kelompok_part_produk'][$item],
						'target_ahm' => $data['target'][$item]
					);

					$this->db->insert('ms_h3_md_target_sales_in_out_ahm_detail', $dataDetail);
				}
			}
		}
	}

}
