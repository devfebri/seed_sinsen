<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher_lcr_d extends CI_Controller
{

  var $folder = "dealer";
  var $page   = "voucher_lcr_d";
  var $title  = "Voucher LCR";

  public function __construct()
  {
    parent::__construct();

    //===== Load Database =====
    $this->load->database();
    $this->load->helper('url');
    //===== Load Model =====
    $this->load->model('m_admin');
    $this->load->model('H2_md_voucher_lcr_d_model', 'm_voucher');
    //===== Load Library =====
    $this->load->helper('tgl_indo');

    //---- cek session -------//		
    $name = $this->session->userdata('nama');
    $auth = $this->m_admin->user_auth($this->page, "select");
    $sess = $this->m_admin->sess_auth();
    if ($name == "" or $auth == 'false' or $sess == 'false') {
      echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "panel'>";
    }
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
    $data['isi']       = $this->page;
    $data['title']     = $this->title;
    $data['set']       = "view";
    $this->template($data);
  }
  function ambildatasurat()
  {
    $set='surat';
    if ($this->input->is_ajax_request() == true) {
      
      $list = $this->m_voucher->get_datatables($set);
      $data = array();
      $no = $_POST['start'];

      foreach ($list as $row) {
        $id = $row['no_surat'];
        $no++;
        if($row['status']=='intransit'){
          $row['action']  = "<a href=\"dealer/voucher_lcr_d/confirm?id_surat=$id\" onclick=\"return confirm('Status semua voucher yang ada disurat ini akan berubah menjadi stock, Apa anda yakin ?')\" class=\"btn btn-xs btn-flat btn-primary\">Confirm</a>";
          $row['action']  .= "<a href=\"dealer/voucher_lcr_d/detail?id_surat=$id\" class=\"btn btn-xs btn-flat btn-info\">view</a>";
        }else{
          
          $row['action']  = "<a href=\"dealer/voucher_lcr_d/detail?id_surat=$id\" class=\"btn btn-xs btn-flat btn-info\">view</a>";
        }
        $date = date_create($row['tgl_assign_dealer']);

        $row['tgl_penyerahan'] =
          date_format($date, "d/m/Y H:i:s");
        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_voucher->count_all($set),
        "recordsFiltered" => $this->m_voucher->count_filtered($set),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } else {
      exit('Maaf data tidak bisa ditampilkan');
    }
  }
  function ambildata()
  {
    $set = 'voucher';
    if ($this->input->is_ajax_request() == true) {

      $list = $this->m_voucher->get_datatables($set);
      $data = array();
      $no = $_POST['start'];

      foreach ($list as $row) {
        $id = $row['id'];
        $no++;
        $row['action']  = "<a href=\"master/voucher_lcr/detail?id_voucher=$id\" class=\"btn btn-xs btn-flat btn-info\">View</a>";

        $data[] = $row;
      }

      $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->m_voucher->count_all($set),
        "recordsFiltered" => $this->m_voucher->count_filtered($set),
        "data" => $data,
      );
      //output dalam format JSON
      echo json_encode($output);
    } else {
      exit('Maaf data tidak bisa ditampilkan');
    }
  }

  function confirm() {
    // $id_surat=$this->input->get('id_surat');
    $created = date('Y-m-d H:i:s');
    $data   = [
      'tgl_terima_dealer'         => $created,
      'status'                    => 'stock'
    ];
    $this->m_voucher->updateDealerConfirm($data);
    echo "<meta http-equiv='refresh' content='0; url=" . base_url() . "dealer/voucher_lcr_d/'>";
  }

  function detail() {
    $data['header']=$this->m_voucher->getDataSurat();
    $no_surat=$this->input->get('id_surat');
    $id_dealer      = $this->m_admin->cari_dealer();
    
    $data['isi']       = $this->page;
    $data['title']     = $this->title;
    $data['set']       = "detail";
    $this->template($data);
    
  }
}
