<?php
defined('BASEPATH') or exit('No direct script access allowed');

class H3_md_ms_target_internal_md extends Honda_Controller
{

    protected $folder = "h3";
    protected $page   = "h3_md_ms_target_internal_md";
    protected $title  = "Master Target Internal MD";

    public function __construct()
    {
        parent::__construct();
        //===== Load Database =====
        $this->load->database();
        $this->load->helper('url');
        //===== Load Model =====
        $this->load->model('m_admin');
        $this->load->model('H3_md_ms_target_internal_md_model', 'target_internal_md');
        //===== Load Library =====
        $this->load->library('upload');
        $this->load->library('form_validation');
        //---- cek session -------//		
        $name = $this->session->userdata('nama');
        $auth = $this->m_admin->user_auth($this->page, "select");
        $sess = $this->m_admin->sess_auth();
        if ($name == "" or $auth == 'false') {
            echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "denied'>";
        } elseif ($sess == 'false') {
            echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "crash'>";
        }
    }

    public function index()
    {
        $data['set']    = "index";
        $this->template($data);
    }

    public function add()
    {
        $data['mode']    = 'insert';
        $data['set']     = "form";
        $data['produk'] = $this->db->query('SELECT DISTINCT(produk) FROM ms_h3_md_setting_kelompok_produk');
        $this->template($data);
    }

    public function save()
    {
        $this->db->trans_start();
        $this->validate();

        $data = $this->input->post([
            'start_date', 'end_date', 'produk', 'target_global_sales_in', 'target_global_sales_out'
        ]);

        $this->target_internal_md->insert(
            $this->clean_data($data)
        );
        $id_target_dealer = $this->db->insert_id();

        $target_dealer_detail = $this->input->post('target_dealer_detail');
        if (count($target_dealer_detail) > 0) {
            foreach ($target_dealer_detail as $each) {
                $data = [
                    'id_target_internal_md' => $id_target_dealer,
                    'id_dealer' => $each['id_dealer'],
                    'target_dealer_sales_in' => $each['target_dealer_sales_in'],
                    'target_dealer_sales_out' => $each['target_dealer_sales_out']
                ];

                $this->db->insert('ms_h3_md_target_internal_md_detail', $data);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $result = $this->target_internal_md->find($id_target_dealer);
            send_json($result);
        } else {
            $this->output->set_status_header(400);
        }
    }

    public function validate()
    {
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('start_date', 'Periode Awal', 'required');
        $this->form_validation->set_rules('end_date', 'Periode Akhir', 'required');
        $this->form_validation->set_rules('produk', 'Jenis Target Dealer', 'required');
        $this->form_validation->set_rules('target_global_sales_in', 'Target Dealer Global (Sales In)', 'required');
        $this->form_validation->set_rules('target_global_sales_out', 'Target Dealer Global (Sales Out)', 'required');

        $target_dealer_detail = $this->input->post('target_dealer_detail');
        foreach ($target_dealer_detail as $each) {
            $cek_data_dealer = $this->db->select('tsd.id, md.nama_dealer')
                ->from('ms_h3_md_target_internal_md as ts')
                ->join('ms_h3_md_target_internal_md_detail as tsd', 'ts.id=tsd.id_target_internal_md')
                ->join('ms_dealer as md', 'md.id_dealer = tsd.id_dealer')
                ->where('ts.produk', $this->input->post('produk'))
                ->where('ts.start_date', $this->input->post('start_date'))
                ->where('ts.end_date', $this->input->post('end_date'))
                ->where('tsd.id_dealer', $each['id_dealer'])
                // ->where('tsd.target_dealer', $each['target_dealer'])
                ->where('tsd.id_target_internal_md !=', $this->input->post('id'))
                ->get()->row_array();
        }
        if (!empty($cek_data_dealer)) {
            send_json([
                'error_type' => 'validation_error',
                'message' => 'Dealer ' . $cek_data_dealer['nama_dealer'] . ' telah terdaftar.'
            ], 422);
        }

        if (!$this->form_validation->run()) {
            $this->output->set_status_header(400);
            send_json([
                'error_type' => 'validation_error',
                'message' => 'Data tidak valid',
                'errors' => $this->form_validation->error_array()
            ]);
        }
    }

    public function detail()
    {
        $data['mode']    = 'detail';
        $data['set']     = "form";
        $data['target_dealer'] = $this->db
            ->select('ts.*')
            ->from('ms_h3_md_target_internal_md as ts')
            ->where('ts.id', $this->input->get('id'))
            ->get()->row();

        $data['target_dealer_detail'] = $this->db
            ->select('tsd.id')
            ->select('tsd.id_dealer')
            ->select('tsd.target_dealer_sales_in')
            ->select('tsd.target_dealer_sales_out')
            ->select('d.nama_dealer')
            ->select('d.kode_dealer_md')
            ->select('d.alamat')
            ->select('d.h1')
            ->select('d.h2')
            ->select('d.h3')
            ->select('kab.kabupaten')
            ->select('kab.id_kabupaten')
            ->from('ms_h3_md_target_internal_md_detail as tsd')
            ->join('ms_dealer as d', 'd.id_dealer = tsd.id_dealer')
            ->join('ms_kelurahan as kel', 'kel.id_kelurahan = d.id_kelurahan')
            ->join('ms_kecamatan as kec', 'kec.id_kecamatan = kel.id_kecamatan')
            ->join('ms_kabupaten as kab', 'kab.id_kabupaten = kec.id_kabupaten')
            ->join('ms_provinsi as prov', 'prov.id_provinsi = kab.id_provinsi')
            ->where('tsd.id_target_internal_md', $this->input->get('id'))
            ->get()->result_array();

        $this->template($data);
    }

    public function edit()
    {
        $data['mode']    = 'edit';
        $data['set']     = "form";
        $data['target_dealer'] = $this->db
            ->select('ts.*')
            ->from('ms_h3_md_target_internal_md as ts')
            ->where('ts.id', $this->input->get('id'))
            ->get()->row();

        $data['target_dealer_detail'] = $this->db
            ->select('tsd.id')
            ->select('tsd.id_dealer')
            ->select('tsd.target_dealer_sales_in')
            ->select('tsd.target_dealer_sales_out')
            ->select('d.nama_dealer')
            ->select('d.kode_dealer_md')
            ->select('d.alamat')
            ->select('d.h1')
            ->select('d.h2')
            ->select('d.h3')
            ->select('kab.kabupaten')
            ->select('kab.id_kabupaten')
            ->from('ms_h3_md_target_internal_md_detail as tsd')
            ->join('ms_dealer as d', 'd.id_dealer = tsd.id_dealer')
            ->join('ms_kelurahan as kel', 'kel.id_kelurahan = d.id_kelurahan')
            ->join('ms_kecamatan as kec', 'kec.id_kecamatan = kel.id_kecamatan')
            ->join('ms_kabupaten as kab', 'kab.id_kabupaten = kec.id_kabupaten')
            ->join('ms_provinsi as prov', 'prov.id_provinsi = kab.id_provinsi')
            ->where('tsd.id_target_internal_md', $this->input->get('id'))
            ->get()->result_array();

        $this->template($data);
    }

    public function update()
    {
        // var_dump($this->input->post());
        // die;
        $this->validate();

        $this->db->trans_start();
        $data = $this->input->post([
            'start_date', 'end_date', 'produk', 'target_global_sales_in', 'target_global_sales_out'
        ]);
        $data = $this->clean_data($data);
        $this->target_internal_md->update($data, $this->input->post(['id']));
        $id_target_dealer = $this->input->post('id');

        $this->db->delete('ms_h3_md_target_internal_md_detail', array('id_target_internal_md' => $id_target_dealer));
        $target_dealer_detail = $this->input->post('target_dealer_detail');
        if (count($target_dealer_detail) > 0) {
            $data = $this->getOnly([
                'id_dealer', 'target_dealer_sales_in', 'target_dealer_sales_out'
            ], $target_dealer_detail, [
                'id_target_internal_md' => $id_target_dealer
            ]);
            $this->db->insert_batch('ms_h3_md_target_internal_md_detail', $data);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            $result = $this->target_internal_md->find($this->input->post('id'));
            send_json($result);
        } else {
            $this->output->set_status_header(500);
        }
    }
}
