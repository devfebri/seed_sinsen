<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tes_api extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('function_helper');
		$this->load->model('M_tes_api', 'm_api');
    }

    function read()
    {
         
        $validasi =  validasi();
        $ins_log = $validasi['activity'];

        if ($validasi['status'] == 1) {

			$filter['id_dealer']    = $validasi['id_dealer'];
			$filter['fromTime'] = $validasi['post']['fromTime'];
            $filter['toTime'] = $validasi['post']['toTime'];

            $cek_invoice           = $this->m_api->getInvoiceSPK($filter);
            $ins_log['data_count'] = $cek_invoice->num_rows();
            $new_inv = [];
            foreach ($cek_invoice->result() as $rs) {
                $new_inv[] = $rs;
            }
            $result = [
                'status' => 1,
                'message' => null,
                'data' => $new_inv
            ];
        } else {
            unset($validasi['activity']);
            $result = $validasi;
        }

        $ins_log['pinpoint'] = "inv1";
        $ins_log['kategori'] = "H1";
        $ins_log['type']     = "read";
        send_json($result);
    }

	function read_1()
    {
         
        $validasi =  validasi();
        $ins_log = $validasi['activity'];

        if ($validasi['status'] == 1) {

			$filter['id_dealer']    = $validasi['id_dealer'];
			$filter['fromTime'] = $validasi['post']['fromTime'];
            $filter['toTime'] = $validasi['post']['toTime'];

            $cek_invoice           = $this->m_api->sl_details($filter);
            $ins_log['data_count'] = $cek_invoice->num_rows();
            $new_inv = [];
            foreach ($cek_invoice->result() as $rs) {
                $new_inv[] = $rs;
            }
            $result = [
                'status' => 1,
                'message' => null,
                'data' => $new_inv
            ];
        } else {
            unset($validasi['activity']);
            $result = $validasi;
        }

        $ins_log['pinpoint'] = "inv1";
        $ins_log['kategori'] = "H1";
        $ins_log['type']     = "read";
        send_json($result);
    }
}
?>