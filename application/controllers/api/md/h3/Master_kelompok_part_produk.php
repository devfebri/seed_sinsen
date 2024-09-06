<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Master_kelompok_part_produk extends CI_Controller

{
    public function index()
    {
        $this->make_datatables();
        $this->limit();

        $data = array();
        $index = 1;
        foreach ($this->db->get()->result_array() as $row) {
            $row['index'] = $this->input->post('start') + $index . '.';
            $kel_produk_mdp=$this->db->query("select id_kelompok_part from ms_kelompok_part mkp where mkp.id_kelompok_part_produk ={$row['id_kelompok_part_produk']} order by id_kelompok_part asc")->result();

            $row['kel_barang_mdp']='';
            foreach($kel_produk_mdp as $row1){
                $row['kel_barang_mdp'].= '<span class="pull-right-container">
                                            <small class="label bg-green">' . $row1->id_kelompok_part . '</small>
                                        </span> ';
            }
            $row['action']= '<button class="btn btn-warning btn-flat" title"Edit Data" onclick="edit('.$row["id_kelompok_part_produk"].')">edit</button>';
            $index++;
            $data[] = $row;
        }
        $output=array(
            'draw' => intval($this->input->post('draw')),
            'recordsFiltered' => $this->recordsFiltered(),
            'recordsTotal' => $this->recordsTotal(),
            'data' => $data
        );
        echo json_encode($output);
    }

    public function make_query()
    {
        $this->db
        ->select('kp.*')
        ->from('ms_kelompok_part_produk as kp')
        ;
    }

    public function make_datatables()
    {
        $this->make_query();

        $search = trim($this->input->post('search') ['value']);
        if ($search != '') {
            $this->db->group_start();
            $this->db->like('kp.nama_kelompok_part_produk', $search);
            // $this->db->or_like('kp.kelompok_part', $search);
            $this->db->group_end();
        }

        if (isset($_POST["order"])) {
            $indexColumn = $_POST['order']['0']['column'];
            $name = $_POST['columns'][$indexColumn]['name'];
            $data = $_POST['columns'][$indexColumn]['data'];
            $this->db->order_by( $name != '' ? $name : $data , $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('kp.nama_kelompok_part_produk', 'ASC');
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
        return $this->db->get()->num_rows();
    }
}
