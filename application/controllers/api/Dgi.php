<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Dgi extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    //===== Load Database =====
    $this->load->database();
    $this->load->helper('url');
    //===== Load Model =====
    $this->load->model('m_admin');
    $this->load->model('m_dgi_api', 'm_dgi');
  }

  public function getProspek()
  {
    $fetch_data = $this->make_query_getProspek();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihProspek(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->id_prospek;
      $sub_array[] = $rs->tgl_prospek;
      $sub_array[] = $rs->nama_konsumen;
      $sub_array[] = $rs->no_hp;
      $sub_array[] = $rs->sumber_prospek;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getProspek(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getProspek($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'            => $limit,
      'order'            => isset($_POST['order']) ? $_POST["order"] : '',
      'group_by_prospek' => isset($_POST['group_by_prospek']) ? $_POST["group_by_prospek"] : NULL,
      'start'            => isset($_POST['start_date']) ? $_POST["start_date"] : NULL,
      'end'              => isset($_POST['end_date']) ? $_POST["end_date"] : NULL,
      'id_karyawan_dealer' => isset($_POST['id_karyawan_dealer']) ? $_POST["id_karyawan_dealer"] : NULL,
      'order_column'     => 'modalProspek',
      'search'           => $this->input->post('search')['value'],
    ];
    if ($filter['start'] == NULL) {
      if ($recordsFiltered == true) {
        return 0;
      } else {
        return [];
      }
    } else {
      if ($recordsFiltered == true) {
        return $this->m_dgi->fetch_getProspek($filter)->num_rows();
      } else {
        return $this->m_dgi->fetch_getProspek($filter)->result();
      }
    }
  }

  public function getKaryawanDealer()
  {
    $fetch_data = $this->make_query_getKaryawanDealer();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihKaryawanDealer(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->id_karyawan_dealer;
      $sub_array[] = $rs->id_flp_md;
      $sub_array[] = $rs->honda_id;
      $sub_array[] = $rs->nama_lengkap;
      $sub_array[] = $rs->jabatan;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getKaryawanDealer(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getKaryawanDealer($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'order_column' => 'modalKaryawanDealer',
      'search' => $this->input->post('search')['value'],
      'id_jabatan'  => isset($_POST['id_jabatan']) ? $_POST["id_jabatan"] : '',
      'id_dealer' => isset($_POST['id_dealer']) ? $_POST['id_dealer'] : dealer()->id_dealer
    ];
    if (isset($_POST['filter_not_in_team_structure'])) {
      $filter['filter_not_in_team_structure'] = true;
    }
    if (isset($_POST['active'])) {
      $filter['active'] = $_POST['active'];
    }
    if (isset($_POST['filter_sales_coordinator_not_in_team_structure'])) {
      $filter['filter_sales_coordinator_not_in_team_structure'] = true;
    }
    if ($recordsFiltered == true) {
      return $this->m_dgi->fetch_getKaryawanDealer($filter)->num_rows();
    } else {
      return $this->m_dgi->fetch_getKaryawanDealer($filter)->result();
    }
  }

  public function getSPK()
  {
    $fetch_data = $this->make_query_getSPK();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihSPK(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->no_spk;
      $sub_array[] = $rs->id_customer;
      $sub_array[] = $rs->nama_konsumen;
      $sub_array[] = $rs->no_ktp;
      $sub_array[] = $rs->alamat;
      $sub_array[] = $rs->id_tipe_kendaraan;
      $sub_array[] = $rs->id_warna;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getSPK(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getSPK($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'order_column' => 'modalSPK',
      'search' => $this->input->post('search')['value'],
      'spk_so_generate_list_unit' => isset($_POST['spk_so_generate_list_unit']) ? true : false,
      'finco_not_null'  => isset($_POST['finco_not_null']) ? true : false,
      'spk_id_so_not_null'  => isset($_POST['spk_id_so_not_null']) ? true : false,
      'periode' => $this->input->post('periode'),
      'start' => date_ymd($this->input->post('start_date')),
      'end' => date_ymd($this->input->post('end_date')),
    ];
    if ($recordsFiltered == true) {
      return $this->m_dgi->getSPK($filter)->num_rows();
    } else {
      return $this->m_dgi->getSPK($filter)->result();
    }
  }

  public function getDelivery()
  {
    $fetch_data = $this->make_query_getDelivery();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihDelivery(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->id_generate;
      $sub_array[] = $rs->tgl_pengiriman;
      $sub_array[] = $rs->driver;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getDelivery(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getDelivery($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'delivery_document_id_not_null'  => isset($_POST['delivery_document_id_not_null']) ? $_POST["delivery_document_id_not_null"] : '',
      'order_column' => 'modalDelivery',
      'join_generate_list' => true,
      'group_id_generate' => true,
      'periode' => $this->input->post('periode'),
      'start' => date_ymd($this->input->post('start_date')),
      'end' => date_ymd($this->input->post('end_date')),
      'search' => $this->input->post('search')['value'],
    ];

    if ($recordsFiltered == true) {
      return $this->m_dgi->getSalesOrder($filter)->num_rows();
    } else {
      return $this->m_dgi->getSalesOrder($filter)->result();
    }
  }

  public function getSalesOrder()
  {
    $fetch_data = $this->make_query_getSalesOrder();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihSalesOrder(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->id_sales_order;
      $sub_array[] = $rs->no_spk;
      $sub_array[] = $rs->nama_konsumen;
      $sub_array[] = $rs->no_mesin;
      $sub_array[] = $rs->no_rangka;
      $sub_array[] = $rs->id_tipe_kendaraan;
      $sub_array[] = $rs->id_warna;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getSalesOrder(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getSalesOrder($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'delivery_document_id_not_null'  => isset($_POST['delivery_document_id_not_null']) ? $_POST["delivery_document_id_not_null"] : '',
      'finco_not_null'  => isset($_POST['finco_not_null']) ? $_POST["finco_not_null"] : '',
      'join_generate_list'  => isset($_POST['join_generate_list']) ? $_POST["join_generate_list"] : '',
      'order_column' => 'modalDelivery',
      'search' => $this->input->post('search')['value'],
      'periode' => $this->input->post('periode'),
      'start' => date_ymd($this->input->post('start_date')),
      'end' => date_ymd($this->input->post('end_date')),
    ];

    if ($recordsFiltered == true) {
      return $this->m_dgi->getSalesOrder($filter)->num_rows();
    } else {
      return $this->m_dgi->getSalesOrder($filter)->result();
    }
  }
  public function getPO()
  {
    $fetch_data = $this->make_query_getPO();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihPO(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->no_po;
      $sub_array[] = $rs->source;
      $sub_array[] = $rs->tahun . '-' . $rs->bulan;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getPO(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getPO($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'order_column' => 'modalPO',
      'search' => $this->input->post('search')['value'],
    ];

    if ($recordsFiltered == true) {
      return $this->m_dgi->getUnitInbound($filter)->num_rows();
    } else {
      return $this->m_dgi->getUnitInbound($filter)->result();
    }
  }

  public function getSJ()
  {
    $fetch_data = $this->make_query_getSJ();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihSJ(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->no_surat_jalan;
      $sub_array[] = $rs->tgl_surat;
      $sub_array[] = $rs->no_do;
      $sub_array[] = $rs->no_po;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getSJ(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getSJ($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'order_column' => 'modalSJ',
      'search' => $this->input->post('search')['value'],
    ];

    if ($recordsFiltered == true) {
      return $this->m_dgi->getUnitInbound($filter)->num_rows();
    } else {
      return $this->m_dgi->getUnitInbound($filter)->result();
    }
  }

  public function getPOPart()
  {
    $fetch_data = $this->make_query_getPOPart();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihPO(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->po_id;
      $sub_array[] = $rs->tanggal_order;
      $sub_array[] = $rs->id_customer;
      $sub_array[] = $rs->nama_customer;
      $sub_array[] = mata_uang_rp($rs->uang_muka);
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getPOPart(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getPOPart($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'order_column' => 'modalPOPart',
      'search' => $this->input->post('search')['value'],
    ];
    if (isset($_POST['po_type'])) {
      $filter['po_type'] = $_POST['po_type'];
    }
    if ($recordsFiltered == true) {
      return $this->m_dgi->getPOPart($filter)->num_rows();
    } else {
      return $this->m_dgi->getPOPart($filter)->result();
    }
  }
  public function getPODealerPart()
  {
    $fetch_data = $this->make_query_getPODealerPart();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihPO(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->po_id;
      $sub_array[] = $rs->po_type;
      $sub_array[] = $rs->tanggal_order;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getPODealerPart(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getPODealerPart($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'order_column' => 'modalPODealerPart',
      'search' => $this->input->post('search')['value'],
      'po_type'  => isset($_POST['po_type']) ? $_POST["po_type"] : '',
    ];
    if (isset($_POST['po_type'])) {
      $filter['po_type'] = $_POST['po_type'];
    }
    if ($recordsFiltered == true) {
      return $this->m_dgi->getPOPart($filter)->num_rows();
    } else {
      return $this->m_dgi->getPOPart($filter)->result();
    }
  }
  public function getTeamSales()
  {
    $fetch_data = $this->make_query_getTeamSales();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihTeam(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->id_team;
      $sub_array[] = $rs->nama_team;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getTeamSales(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getTeamSales($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'order_column' => 'view',
      'search' => $this->input->post('search')['value'],
      'id_dealer' => dealer()->id_dealer,
    ];

    if (isset($_POST['active'])) {
      $filter['active'] = $_POST['active'];
    }
    if (isset($_POST['team_not_in_team_structure'])) {
      $filter['team_not_in_team_structure'] = $_POST['team_not_in_team_structure'];
    }
    // send_json($filter);
    if ($recordsFiltered == true) {
      return $this->m_dgi->getTeamSales($filter)->num_rows();
    } else {
      return $this->m_dgi->getTeamSales($filter)->result();
    }
  }
}
