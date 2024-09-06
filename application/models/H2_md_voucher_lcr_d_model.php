<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class H2_md_voucher_lcr_d_model extends CI_Model{

  // var $table = 'tr_log_generate_customer_list_fol_up as a';
  var $table = 'tr_h2_voucher_lcr'; //nama tabel dari database
  var $column_order = array( 'kode_voucher', 'start_date', 'end_date', 'nilai_voucher','qty','id_dealer','no_surat','tgl_asign_dealer','tgl_terima_dealer','tgl_penyerahan_customer','nama_customer',  null); //Sesuaikan dengan field
  var $column_search = array('kode_voucher', 'nilai_voucher', 'qty', 'status'); //field yang diizin untuk pencarian 
  var $order = array('vl.id' => 'DESC'); // default order 

    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
    private function _get_datatables_query($set)
    {
    if ($set == 'voucher') {
      $this->db->select('vl.id')
        ->select('vl.kode_voucher')
        ->select('vl.start_date')
        ->select('vl.end_date')
        ->select('vl.nilai_voucher')
        ->select('vl.qty')
        ->select('md.kode_dealer_md')
        ->select('vl.no_surat')
        ->select('vl.expired_date')
        ->select('mch.nama_customer')
        ->select('vl.status')
        ->select('vl.tgl_assign_dealer')
        ->select('vl.tgl_terima_dealer')
        ->from('tr_h2_voucher_lcr vl')
        ->join('ms_customer_h23 mch', 'mch.id_customer = vl.id_customer', 'left')
        ->join('ms_dealer md', 'md.id_dealer = vl.id_dealer', 'left')
        ->where('vl.id_dealer =', $this->m_admin->cari_dealer());

      $i = 0;

      foreach ($this->column_search as $item) // looping awal
      {
        if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
        {
          if ($i === 0) // looping awal
          {
            $this->db->group_start();
            $this->db->like($item, $_POST['search']['value']);
          } else {
            $this->db->or_like($item, $_POST['search']['value']);
          }
          if (count($this->column_search) - 1 == $i)
            $this->db->group_end();
        }
        $i++;
      }
      if (isset($_POST["order"])) {
        $indexColumn = $_POST['order']['0']['column'];
        $name = $_POST['columns'][$indexColumn]['name'];
        $data = $_POST['columns'][$indexColumn]['data'];
        $this->db->order_by($name != '' ? $name : $data, $_POST['order']['0']['dir']);
      } else {
        $this->db->order_by('vl.id', 'ASC');
      }
    } else if ($set == 'surat') {


      $test = $this->db->select('vl.no_surat')
        ->select('vl.tgl_assign_dealer')
        ->select('count(1) as jml_voucher')
        ->select('vl.tgl_terima_dealer')
        ->select('md.nama_dealer')
        ->select('vl.status')
        ->from('tr_h2_voucher_lcr vl')
        ->join('ms_dealer md', 'md.id_dealer=vl.id_dealer')
        ->where('vl.id_dealer =', $this->m_admin->cari_dealer())
        ->group_by('vl.no_surat');

      // var_dump($test->get()->result());
      // die;

      $i = 0;

      foreach ($this->column_search as $item) // looping awal
      {
        if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
        {
          if ($i === 0) // looping awal
          {
            $this->db->group_start();
            $this->db->like($item, $_POST['search']['value']);
          } else {
            $this->db->or_like($item, $_POST['search']['value']);
          }
          if (count($this->column_search) - 1 == $i)
            $this->db->group_end();
        }
        $i++;
      }
      if (isset($_POST["order"])) {
        $indexColumn = $_POST['order']['0']['column'];
        $name = $_POST['columns'][$indexColumn]['name'];
        $data = $_POST['columns'][$indexColumn]['data'];
        $this->db->order_by($name != '' ? $name : $data, $_POST['order']['0']['dir']);
      } else {
        $this->db->order_by('vl.id', 'ASC');
      }
    }
      
     
    }

    function get_datatables($set)
    {
      $this->_get_datatables_query($set);
      if ($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
      $query = $this->db->get()->result_array();

      return $query;
    }
    

    function count_filtered($set)
    {
      $this->_get_datatables_query($set);
      $query = $this->db->get();

      return $query->num_rows();
    }

    public function count_all($set)
    {

      $this->_get_datatables_query($set);
      return $this->db->count_all_results();
    }

    public function dealer()
    {
      return $this->db->query('SELECT id_dealer,kode_dealer_md, nama_dealer from ms_dealer md where active = 1 and h2 =1' )->result_array();
    }

    public function getQueryDetail($id_voucher)
    {
      $this->db->select('vl.id');
      $this->db->select('vl.kode_voucher');
      $this->db->select('vl.start_date');
      $this->db->select('vl.end_date');
      $this->db->select('vl.nilai_voucher');
      $this->db->select('vl.qty');
      $this->db->select('md.kode_dealer_md');
      $this->db->select('vl.no_surat');
      $this->db->select('vl.expired_date');
      $this->db->select('mch.nama_customer');
      $this->db->select('vl.status');
      $this->db->select('vl.id_dealer');
      $this->db->select('vl.tgl_assign_dealer');
      $this->db->from('tr_h2_voucher_lcr vl');
      $this->db->join('ms_customer_h23 mch', 'mch.id_customer = vl.id_customer','left');
      $this->db->join('ms_dealer md', 'md.id_dealer = vl.id_dealer','left');
      $this->db->where('vl.id',$id_voucher);
      $query=$this->db->get();
      return $query;
    }

    public function updateDealerConfirm($data)
    {
      // $this->db->where('id', array($this->input->post('ids')));
    $this->db->update('tr_h2_voucher_lcr', $data, array('no_surat' => $this->input->get('id_surat')));
    }

    public function getDataSurat(){
      $data = $this->db->select('vl.no_surat')
      ->select('vl.tgl_assign_dealer')
      ->select('count(1) as jml_voucher')
      ->select('vl.tgl_terima_dealer')
      ->select('md.nama_dealer')
      ->select('vl.tgl_terima_dealer')
      ->from('tr_h2_voucher_lcr vl')
      ->join('ms_dealer md', 'md.id_dealer=vl.id_dealer')
      ->where('vl.id_dealer =', $this->m_admin->cari_dealer())
      ->where('vl.no_surat =', $this->input->get('id_surat'))
      
      ->group_by('vl.no_surat')->get()->row();
      return $data;
      // var_dump($data);
      // die;
      
    }

  }
?>