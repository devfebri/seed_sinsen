<?php
defined('BASEPATH') or exit('No direct script access allowed');

class H2_list_ar extends CI_Controller
{

  var $folder = "dealer";
  var $page   = "h2_list_ar";
  var $title  = "List AR";

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
    $this->load->model('m_h2_dealer_laporan', 'm_lap');
    $this->load->model('m_h2_billing', 'm_bil');
    $this->load->model('m_h2_finance', 'm_fin');


    //===== Load Library =====
    $this->load->library('upload');
    $this->load->helper('tgl_indo');
    $this->load->helper('terbilang');
  }
  protected function template($data)
  {
    $name = $this->session->userdata('nama');
    if ($name == "") {
      echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "panel'>";
    } else {
      $this->load->view('template/header', $data);
      $this->load->view('template/aside');
      $page = $this->page;
      if (isset($data['mode'])) {
        if ($data['mode'] == 'detail_wo') {
          $page = 'sa_form';
        }
        if ($data['mode'] == 'detail_njb') {
          $page = 'njb';
        }
        if ($data['mode'] == 'detail_nsc') {
          $page = 'nsc';
        }
      }
      $this->load->view($this->folder . "/" . $page);
      $this->load->view('template/footer');
    }
  }

  public function index()
  {
    $data['isi']   = $this->page;
    $data['title'] = $this->title;
    $data['set']   = "index";
    $this->template($data);
  }

  public function fetch()
  {
    $fetch_data = $this->make_query();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $sub_array[] = $rs->tgl_invoice;
      $sub_array[] = $rs->tgl_jatuh_tempo;
      $sub_array[] = $rs->nama_customer;
      // $sub_array[] = $rs->no_nsc;
      // // $sub_array[] = $rs->no_njb;
      $sub_array[] = '<a target="_blank" href="dealer/' . $this->page . '/detail_nsc?id=' . $rs->no_nsc . '">' . $rs->no_nsc . '</a>';;
      $sub_array[] = '<a target="_blank" href="dealer/' . $this->page . '/detail_njb?id=' . $rs->no_njb . '">' . $rs->no_njb . '</a>';;
      $sub_array[] = 'Rp. ' . mata_uang_rp((int) $rs->nilai_jasa);
      $sub_array[] = 'Rp. ' . mata_uang_rp((int) $rs->nilai_oli);
      $sub_array[] = 'Rp. ' . mata_uang_rp((int) $rs->nilai_part);
      $sub_array[] = 'Rp. ' . mata_uang_rp((int) $rs->total_bayar);
      $sub_array[] = 'Rp. ' . mata_uang_rp((int) $rs->dibayar);
      $sub_array[] = 'Rp. ' . mata_uang_rp((int) $rs->sisa);
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST['order'] : '',
      'sisa_lebih_besar'  => isset($_POST['sisa_lebih_besar']) ? $_POST['sisa_lebih_besar'] : '',
      'search' => $this->input->post('search')['value'],
      'order_column' => 'list_ar',
    ];
    if ($recordsFiltered == true) {
      return $this->m_bil->get_njb_nsc_print($filter)->num_rows();
    } else {
      return $this->m_bil->get_njb_nsc_print($filter)->result();
    }
  }

  public function detail_njb()
  {
    $data['isi']   = $this->page;
    $data['title'] = 'Detail NJB';
    $data['mode']  = 'detail_njb';
    $data['set']   = "form";
    $no_njb = $this->input->get('id');

    $filter = ['no_njb' => $no_njb];
    $get_wo = $this->m_wo->get_sa_form($filter);

    if ($get_wo->num_rows() > 0) {
      $row = $data['row'] = $get_wo->row();
      $data['pkp'] = $row->pkp_njb;
      // send_json($data);
      $this->template($data);
    } else {
      $_SESSION['pesan']   = "Data not found !";
      $_SESSION['tipe']   = "danger";
      echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dealer/njb'>";
    }
  }

  public function detail_nsc()
  {
    $data['isi']   = $this->page;
    $data['title'] = 'Detail NSC';
    $data['mode']  = 'detail_nsc';
    $data['set']   = "form";
    $no_nsc = $this->input->get('id');

    $filter = ['no_nsc' => $no_nsc];
    $get_nsc = $this->m_bil->getNSC($filter);

    if ($get_nsc->num_rows() > 0) {
      $nsc = $get_nsc->row();
      $filter = ['id_referensi' => $nsc->id_referensi];
      $wo = $this->m_wo->get_sa_form($filter)->row();
      $nsc->tgl_servis         = $wo->tgl_servis;
      $nsc->id_karyawan_dealer = $wo->id_karyawan_dealer;
      $nsc->nama_lengkap       = $wo->nama_lengkap;
      $nsc->kd_dealer_so       = $wo->kode_dealer_md;
      $nsc->dealer_so          = $wo->nama_dealer;
      $nsc->tipe_ahm           = $wo->tipe_ahm;
      $nsc->no_polisi          = $wo->no_polisi;
      $filter = ['no_nsc' => $nsc->no_nsc];
      $nsc->parts = $this->m_bil->getNSCParts($filter)->result();
      $data['row'] = $nsc;
      $data['pkp'] = $nsc->pkp;
      $data['tampil_ppn'] = $nsc->tampil_ppn;
      // send_json($nsc);
      $this->template($data);
    } else {
      $_SESSION['pesan']   = "Data not found !";
      $_SESSION['tipe']   = "danger";
      echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dealer/nsc'>";
    }
  }

  function inject_tot_part()
  {
    $where = "WHERE 1=1 ";
    $where = "WHERE 1=1 AND tot_nsc!=(tot_nsc_oli+tot_nsc_part) ";
    if ($this->input->get('no_nsc') != '') {
      $no_nsc = $this->input->get('no_nsc');
      $where .= " AND no_nsc='$no_nsc'";
    }
    if (!isset($_GET['count'])) {
      $where .= " LIMIT 1500";
    }
    $nsc = $this->db->query("SELECT no_nsc,tot_nsc_part,tot_nsc_oli FROM tr_h23_nsc $where ");
    if (isset($_GET['count'])) {
      send_json($nsc->num_rows());
    }
    foreach ($nsc->result() as $ns) {
      $filter_part = [
        'no_nsc' => $ns->no_nsc,
        'group_by_no_nsc' => true,
        'group_by_no_nsc_only_grand' => true,
        'kelompok_part_not_in' => "'OIL'"
      ];
      $get_part = $this->m_bil->getNSCParts($filter_part);
      $nilai_part = 0;
      if ($get_part->num_rows() > 0) {
        $nilai_part = $get_part->row()->gt;
      }

      $filter_oli = [
        'no_nsc' => $ns->no_nsc,
        'group_by_no_nsc' => true,
        'group_by_no_nsc_only_grand' => true,
        'kelompok_part_in' => "'OIL'"
      ];
      $get_oli = $this->m_bil->getNSCParts($filter_oli);
      $nilai_oli = 0;
      if ($get_oli->num_rows() > 0) {
        $nilai_oli = $get_oli->row()->gt;
      }
      $upd[] = ['no_nsc' => $ns->no_nsc, 'tot_nsc_part' => $nilai_part, 'tot_nsc_oli' => $nilai_oli];
    }
    if (isset($_GET['cek'])) {
      send_json($upd);
    }
    if (isset($upd)) {
      $this->db->update_batch('tr_h23_nsc', $upd, 'no_nsc');
      echo $this->db->affected_rows();
    }
  }
}
