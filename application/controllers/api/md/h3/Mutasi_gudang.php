<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Mutasi_gudang extends CI_Controller
{
    public function index()
    {
        $this->make_datatables();
        $this->limit();

        $data = array();
        foreach ($this->db->get()->result_array() as $row) {
            $row['action'] = '<a href="h3/h3_md_mutasi_gudang/riwayat_mutasi?id_part='. $row['id_part'].'" class="btn btn-xs btn-flat btn-info">View</a>';
            $data[] = $row;
        }
        send_json([
            'draw' => intval($this->input->post('draw')),
            'data' => $data,
            'recordsFiltered' => $this->recordsFiltered(),
            'recordsTotal' => $this->recordsTotal(),
        ]);
    }

    public function make_query()
    {
        $this->db
            ->select('mg.id_part')
            ->select('p.nama_part')
            ->select("(select date_format(created_at, '%d/%m/%Y %H:%i:%s') from tr_h3_md_mutasi_gudang as c WHERE c.id_part = p.id_part  order by created_at DESC limit 1) as last_mutasi")
            ->from('tr_h3_md_mutasi_gudang as mg')
            ->join('ms_part as p','mg.id_part=p.id_part')
            ->group_by('id_part')
            ->order_by('nama_part','asc');

        
        if ($this->input->post('history') != null and $this->input->post('history') == 1) {
            $this->db->group_start();
            $this->db->where('left(mg.created_at,10) <=', '2023-09-30');
            $this->db->group_end();
        } else {
            $this->db->group_start();
            $this->db->where('left(mg.created_at,10) >', '2023-10-01');
            $this->db->group_end();
        }
    }

    public function make_datatables()
    {
        $this->make_query();

        $search = trim($this->input->post('search') ['value']);
        if ($search != '') {
            $this->db->group_start();
            $this->db->like('mg.id_mutasi_gudang', $search);
            $this->db->group_end();
        }

        if (isset($_POST["order"])) {
            $indexColumn = $_POST['order']['0']['column'];
            $name = $_POST['columns'][$indexColumn]['name'];
            $data = $_POST['columns'][$indexColumn]['data'];
            $this->db->order_by( $name != '' ? $name : $data , $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('mg.created_at', 'desc');
        }
    }

    public function limit(){
        if ($_POST["length"] != - 1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
    }

    public function recordsFiltered()
    {
        $this->make_datatables();
        return $this->db->get()->num_rows();
    }

    public function recordsTotal(){
        $this->make_query();
        return $this->db->count_all_results();
    }
}
