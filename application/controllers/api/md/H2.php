<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class H2 extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    //===== Load Database =====
    $this->load->database();
    $this->load->helper('url');
    //===== Load Model =====
    $this->load->model('m_admin');
    $this->load->model('m_h2_md_api', 'm_api');
    $this->load->model('m_h2_md_claim', 'm_claim');
    $this->load->model('m_h2_work_order', 'm_wo');
  }

  public function getAllParts()
  {
    $fetch_data = $this->make_query_getAllParts();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihPart(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';

      $sub_array[] = $rs->id_part;
      $sub_array[] = $rs->nama_part;
      $sub_array[] = $rs->kelompok_vendor;
      $sub_array[] = mata_uang_rp($rs->harga_dealer_user);
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getAllParts(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getAllParts($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'part_oli' => isset($_POST['part_oli']) ? $_POST['part_oli'] : '',
      'id_tipe_kendaraan' => isset($_POST['id_tipe_kendaraan']) ? $_POST['id_tipe_kendaraan'] : '',
      'search' => $this->input->post('search')['value'],
    ];
    if ($recordsFiltered == true) {
      return $this->m_api->fetch_getAllParts($filter)->num_rows();
    } else {
      return $this->m_api->fetch_getAllParts($filter)->result();
    }
  }

  public function getJasa()
  {
    $fetch_data = $this->make_query_getJasa();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihJasa(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';

      $sub_array[] = $rs->id_jasa;
      $sub_array[] = $rs->deskripsi;
      $sub_array[] = $rs->type;
      $sub_array[] = $rs->kategori;
      $sub_array[] = $rs->tipe_motor;
      $sub_array[] = mata_uang_rp($rs->harga);
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getJasa(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getJasa($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'search' => $this->input->post('search')['value'],
      'id_dealer' => $this->m_admin->cari_dealer(),
    ];
    if ($recordsFiltered == true) {
      return $this->m_api->fetch_getJasa($filter)->num_rows();
    } else {
      return $this->m_api->fetch_getJasa($filter)->result();
    }
  }

  public function getAHASS()
  {
    $fetch_data = $this->make_query_getAHASS();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihAHASS(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';

      $sub_array[] = $rs->kode_dealer_md;
      $sub_array[] = $rs->nama_dealer;
      $sub_array[] = $rs->nama_pic_dealer;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getAHASS(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getAHASS($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'search' => $this->input->post('search')['value'],
    ];
    if ($recordsFiltered == true) {
      return $this->m_api->fetch_getAHASS($filter)->num_rows();
    } else {
      return $this->m_api->fetch_getAHASS($filter)->result();
    }
  }

  public function getKaryawanMD()
  {
    $fetch_data = $this->make_query_getKaryawanMD();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihKaryawanMD(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';

      $sub_array[] = $rs->id_karyawan;
      $sub_array[] = $rs->nama_lengkap;
      $sub_array[] = $rs->jabatan;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getKaryawanMD(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getKaryawanMD($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'search' => $this->input->post('search')['value'],
    ];
    if ($recordsFiltered == true) {
      return $this->m_api->fetch_getKaryawanMD($filter)->num_rows();
    } else {
      return $this->m_api->fetch_getKaryawanMD($filter)->result();
    }
  }
  public function getKabupaten()
  {
    $fetch_data = $this->make_query_getKabupaten();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihKabupaten(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';

      $sub_array[] = $rs->id_kabupaten;
      $sub_array[] = $rs->kabupaten;
      $sub_array[] = $rs->provinsi;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getKabupaten(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getKabupaten($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'search' => $this->input->post('search')['value'],
      'id_provinsi' => $this->input->post('id_provinsi'),
    ];
    if ($recordsFiltered == true) {
      return $this->m_api->fetch_getKabupaten($filter)->num_rows();
    } else {
      return $this->m_api->fetch_getKabupaten($filter)->result();
    }
  }

  public function getSymptom()
  {
    $fetch_data = $this->make_query_getSymptom();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihSymptom(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';

      $sub_array[] = $rs->id_symptom;
      $sub_array[] = $rs->symptom_id;
      $sub_array[] = $rs->symptom_en;
      $sub_array[] = $rs->id_kelompok_symptom;
      $sub_array[] = $rs->deskripsi_id;
      $sub_array[] = $rs->deskripsi_en;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getSymptom(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getSymptom($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'search' => $this->input->post('search')['value'],
    ];
    if ($recordsFiltered == true) {
      return $this->m_api->fetch_getSymptom($filter)->num_rows();
    } else {
      return $this->m_api->fetch_getSymptom($filter)->result();
    }
  }
  public function getLKH()
  {
    $fetch_data = $this->make_query_getLKH();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihLKH(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->id_lkh;
      $sub_array[] = $rs->tgl_lkh;
      $sub_array[] = $rs->kode_dealer_md;
      $sub_array[] = $rs->nama_dealer;
      $sub_array[] = $rs->no_claim_c2;
      $sub_array[] = $rs->id_tipe_kendaraan;
      $sub_array[] = $rs->tema;
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getLKH(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getLKH($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'search' => $this->input->post('search')['value'],
      'order_column' => 'modalLKH',
      'id_rekap_claim_null' => true,
    ];
    if ($recordsFiltered == true) {
      return $this->m_claim->getLKH($filter)->num_rows();
    } else {
      return $this->m_claim->getLKH($filter)->result();
    }
  }
  public function getDealer()
  {
    $fetch_data = $this->make_query_getDealer();
    $data = array();
    foreach ($fetch_data as $rs) {
      $sub_array = array();
      $link        = '<button data-dismiss=\'modal\' onClick=\'return pilihDealer(' . json_encode($rs) . ')\' class="btn btn-success btn-xs">Pilih</button>';
      $sub_array[] = $rs->kode_dealer_md;
      $sub_array[] = $rs->nama_dealer;
      $sub_array[] = '';
      $sub_array[] = $link;
      $data[]      = $sub_array;
    }
    $output = array(
      "draw"            =>     intval($_POST["draw"]),
      "recordsFiltered" =>     $this->make_query_getDealer(true),
      "data"            =>     $data
    );
    echo json_encode($output);
  }

  public function make_query_getDealer($recordsFiltered = null)
  {
    $start        = $this->input->post('start');
    $length       = $this->input->post('length');
    $limit        = "LIMIT $start, $length";

    if ($recordsFiltered == true) $limit = '';

    $filter = [
      'limit'  => $limit,
      'order'  => isset($_POST['order']) ? $_POST["order"] : '',
      'search' => $this->input->post('search')['value'],
      'order_column' => 'modalDealer',
    ];
    if ($recordsFiltered == true) {
      return $this->m_api->getDealer($filter)->num_rows();
    } else {
      return $this->m_api->getDealer($filter)->result();
    }
  }
}
