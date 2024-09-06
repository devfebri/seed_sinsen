<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leadtime_h3_filter_monitoring_supply extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $rows = $this->make_datatables();
            // var_dump($_POST);
            // die;
        $data = array();
        foreach ($rows as $row) {
            
            $sub_array = (array) $row;
            $sub_array['action'] = $this->load->view('additional/md/h3/action_leadtime_filter_monitoring_supply', [
                'data' => json_encode($row),
                'leadtime' => $row['leadtime']
            ], true);
            $data[] = $sub_array;
        }
        
        // array_slice($data, 0, 9);
        
        send_json([
            'draw' => intval($this->input->post('draw')),
            'recordsFiltered' => $this->get_filtered_data(),
            'data' => $data
        ]);
    }
    
    public function make_array() {
        $i = 0;
        $value = [];
        while ($i < 31) {
            if($i==0){
                $value[$i] = array('leadtime' => 99);
            }else{
                $value[$i] = array('leadtime' => $i);
            }
            $i++;
        }
        return $value;
    }

    public function make_datatables() {
        
        // $this->session->unset_userdata($this->make_array());
        // var_dump($this->input->post('search')['value']);
        // die;

        $search = $this->input->post('search')['value'];
        if ($search != '') {
            $array= array($search);
        }else{
            $array=$this->make_array();
        }
        if (isset($_POST["order"])) {
            $indexColumn = $_POST['order']['0']['column'];
            $name = $_POST['columns'][$indexColumn]['leadtime'];
            // $data = $_POST['columns'][$indexColumn]['data'];
            // $this->db->order_by($name != '' ? $name : $data, $_POST['order']['0']['dir']);
        } else {
            // $this->db->order_by('d.daerah', 'ASC');
        }



        $start = isset($_POST['start']) ? intval($_POST['start']) : 0;
        $length = isset($_POST['length']) ? intval($_POST['length']) : 10;
        $test=array_slice($array, $start, $length);
        return $test;

    }

    public function get_filtered_data() {
        $array = $this->make_array();
        return count($array);
    }
}
