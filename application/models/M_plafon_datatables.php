<?php

defined('BASEPATH') or exit('No direct script access allowed');

class M_plafon_datatables extends CI_Model
{
    var $table = "ms_plafon";
    var $column_order = array('','ms_plafon.tgl','ms_dealer.nama_dealer','ms_dealer.kode_dealer_md','ms_plafon.plafon','ms_plafon.plafon1','ms_plafon.status','ms_plafon.op1','ms_plafon.op2','ms_plafon.op3','ms_plafon.plafon1','ms_plafon.plafon2','ms_plafon.id_plafon'); //field yang ada di table user
    var $column_search   = array('ms_plafon.tgl','ms_dealer.nama_dealer','ms_dealer.kode_dealer_md','ms_plafon.plafon','ms_plafon.plafon1','ms_plafon.status','ms_plafon.op1','ms_plafon.op2','ms_plafon.op3','ms_plafon.plafon1','ms_plafon.plafon2','ms_plafon.id_plafon'); //field yang diizin untuk pencarian 
    var $order = array('ms_plafon.id_plafon' => 'desc'); 
   
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {   
        $this->db->select('ms_plafon.tgl,ms_dealer.nama_dealer,ms_dealer.kode_dealer_md,ms_plafon.plafon,ms_plafon.plafon1,ms_plafon.status,ms_plafon.created_at,ms_plafon.op1,ms_plafon.op2,ms_plafon.op3,ms_plafon.plafon1,ms_plafon.plafon2,ms_plafon.id_plafon')        
        ->from('ms_plafon')
        ->join('ms_dealer','ms_dealer.id_dealer = ms_plafon.id_dealer');
        $i = 0;

        foreach ($this->column_search as $item) {
            if($_POST['search']['value']) 
            {
                if($i===0)
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }


        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }

        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }


    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->_get_datatables_query();
        return $this->db->count_all_results();
    }



}

