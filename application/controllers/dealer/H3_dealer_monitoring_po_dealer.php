<?php
defined('BASEPATH') or exit('No direct script access allowed');

class H3_dealer_monitoring_po_dealer extends CI_Controller
{

    var $folder = "dealer";
    var $page   = "h3_dealer_monitoring_po_dealer";
    var $isi    = "Monitoring PO Dealer";
    var $title  = "Monitoring PO Dealer";

    public function __construct()
    {
        parent::__construct();
        //===== Load Database =====
        $this->load->database();
        $this->load->helper('url');
        //===== Load Model =====
        $this->load->model('m_admin');
        //===== Load Library =====		
        // $this->load->library('pdf');		
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

    protected function template($data)
    {
        $name = $this->session->userdata('nama');
        if ($name == "") {
            echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "panel'>";
        } else {
            $data['id_menu'] = $this->m_admin->getMenu($this->page);
            $data['group']     = $this->session->userdata("group");
            $this->load->view('template/header', $data);
            $this->load->view('template/aside');
            $this->load->view($this->folder . "/" . $this->page);
            $this->load->view('template/footer');
        }
    }

    public function index()
    {
        $data['isi']    = $this->isi;
        $data['title']    = $this->title;
        $data['set']    = "view";
        $this->template($data);
    }

    public function downloadReport()
    {
        
        $data['id_dealer']  = $id_dealer    = $this->m_admin->cari_dealer();
        $data['start_date'] = $start_date   = $this->input->post('tgl1');
        $data['end_date']   = $end_date     = $this->input->post('tgl2');
        $data['type']       =  $type        = $this->input->post('type');
        
      
        $data['report'] = $this->db->query("
                select 
                    po.tanggal_order as tgl_po_dealer,
                    po.submit_at  as tgl_submit_dealer_to_md, 
                    po.tanggal_po_ahm as tgl_po_md_to_ahm,
                    po.submit_at  as tgl_dealer_terima_barang,
                    po.id as leadtime_supply,
                    po.id as no_po_htl_dealer,
                    po.id as tgl_po,
                    cus.nama_customer as nama_konsumen,
                    cus.alamat  as alamat_konsumen,
                    cus.no_hp  as no_tlp,
                    cus.email  as email,
                    cus.no_rangka  as no_rangka,
                    cus.no_mesin as no_mesin,
                    po_parts.id_part  as part_number,
                    p.nama_part  as deskripsi,
                    po_parts.kuantitas as jml_order,
                    po.status as status,
                    p.kelompok_part as kelompok_part,
                    po.po_type,
                    po.created_at,
                    reqdoc.id_customer,
                    po.po_id,
                    po.id_booking,
                    p.id_part_int
                FROM tr_h3_dealer_purchase_order as po
                inner join tr_h3_dealer_request_document as reqdoc on reqdoc.id_booking = po.id_booking 
                JOIN ms_customer_h23 as cus on cus.id_customer = reqdoc.id_customer 
                JOIN tr_h3_dealer_purchase_order_parts as po_parts on po_parts.po_id =po.po_id 
                JOIN ms_part as p on p.id_part_int = po_parts.id_part_int
                WHERE po.po_type = 'HLO' and po.created_at  >= '$start_date 00:00:00' and po.created_at  <='$end_date 23:59:59' and po.id_dealer='$id_dealer';
			");
      
       
            $this->load->view("dealer/laporan/temp_h3_monitoring_po_dealer", $data);


    }
}
