<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master_target_ahm_sales_in_out extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('m_admin');
    }

    public function index()
    {
        $this->benchmark->mark('data_start');
        $this->make_datatables();
        $this->limit();
         
        $data = array();
        foreach ($this->db->get()->result_array() as $row) {
            $row = html_escape($row);
            $row['action'] = $this->load->view('additional/md/h3/action_ahm_target_sales_in_out', [
                'data' => json_encode($row),
                'id_dealer' => $row['id_part'],
                // 'kelompok_part' => $row['kelompok_part'],
            ], true);

            $data[] = $row;
        }
        $this->benchmark->mark('data_end');

        send_json([
            'draw' => intval($this->input->post('draw')),
            'recordsFiltered' => $this->recordsFiltered(),
            'recordsFiltered_time' => floatval($this->benchmark->elapsed_time('recordsFiltered_start', 'recordsFiltered_end')),
            'recordsTotal' => $this->recordsTotal(),
            'recordsTotal_time' => floatval($this->benchmark->elapsed_time('recordsTotal_start', 'recordsTotal_end')),
            'data' => $data,
            'data_time' => floatval($this->benchmark->elapsed_time('data_start', 'data_end'))
        ]);
    }

    // public function make_query()
    // {
       
    //     $this->db
    //     ->select('kelpart.id_kelompok_part as kelompok_part')
    //     ->from('ms_h3_md_setting_kelompok_produk as kelpart')
    //     ->where('kelpart.produk','Parts');
       
    // }

    public function make_query()
    {
       
        $this->db
        ->select('kelpart.id_kelompok_part as kelompok_part')
        ->select('mp.id_part as id_part')
        ->select('mp.nama_part  as nama_part')
        ->from('ms_h3_md_setting_kelompok_produk as kelpart')
        ->join('ms_part as mp', 'mp.kelompok_part_int=kelpart.id_kelompok_part_int')
        ->where('kelpart.produk','Parts');
       
    }

    public function make_datatables()
    {
        $this->make_query();

        $search = trim($this->input->post('search') ['value']);
        if ($search != '') {
            $this->db->group_start();
            $this->db->like('kelompok_part', $search);
            $this->db->group_end();
        }

        if (isset($_POST["order"])) {
            $indexColumn = $_POST['order']['0']['column'];
            $name = $_POST['columns'][$indexColumn]['name'];
            $data = $_POST['columns'][$indexColumn]['data'];
            $this->db->order_by($name != '' ? $name : $data, $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('kelompok_part', 'ASC');
        }
    }

    private function limit()
    {
        if ($_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
    }

    public function recordsFiltered()
    {
        $this->benchmark->mark('recordsFiltered_start');
        $this->make_datatables();
        $record = $this->db->get()->num_rows();
        $this->benchmark->mark('recordsFiltered_end');

        return $record;
    }

    public function recordsTotal()
    {
        $this->benchmark->mark('recordsTotal_start');
        $this->make_query();
        $record = $this->db->count_all_results();
        $this->benchmark->mark('recordsTotal_end');

        return $record;
    }
}