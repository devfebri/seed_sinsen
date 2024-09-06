<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
class M_dgi_api_group extends CI_Model {
    protected $table = 'ms_dgi_api_key_group';
    // private $_table = "ms_event_location";
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
    private $_table = 'ms_dgi_api_key_group';
    private $column_order = array('dealer_group', 'api_key_group', 'secret_key_group');
    private $column_search = array('dealer_group', 'api_key_group', 'secret_key_group');
    private $order = array('dealer_group' => 'asc');

    private function _getGetApiKeyGroup($startDate = null, $endDate = null, $status = null) {
        $this->db->from($this->_table);
        if ($startDate && $endDate) {
            $this->db->where('start_date >=', $startDate);
            $this->db->where('end_date <=', $endDate);
        }
        if ($status !== null && $status !== '') {
            $this->db->where('status', $status);
        }
    
        $searchValue = @$_POST['search']['value'];
        if ($searchValue && strlen($searchValue)) {
            foreach ($this->column_search as $i => $item) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $searchValue);
                } else {
                    $this->db->or_like($item, $searchValue);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
        }
    
        if (isset($_POST['order'])) {
            $this->db->order_by(
                $this->column_order[$_POST['order'][0]['column']],
                $_POST['order'][0]['dir']
            );
        } else {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    public function getGetApiKeyGroup($startDate = null, $endDate = null, $status = null) {
        $this->_getGetApiKeyGroup($startDate, $endDate, $status);
        if (@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function countFilterApiGroup($startDate = null, $endDate = null, $status = null) {
        $this->_getGetApiKeyGroup($startDate, $endDate, $status);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    public function countAllApiGroup() {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    public function getDetailsByDealerGroup($dealer_group) {
        $this->db->from($this->_table);
        $this->db->where('dealer_group', $dealer_group);
        $query = $this->db->get();
        return $query->result();
    }
    
}