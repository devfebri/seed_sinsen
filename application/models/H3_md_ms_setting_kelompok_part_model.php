<?php

class H3_md_ms_setting_kelompok_part_model extends Honda_Model{

    protected $table = 'ms_kelompok_part_produk';

    public function insert($data){
        parent::insert($data);
    }

    public function updateMsPart($id,$dataUpdate){
        $this->db->where('id_kelompok_part', $id);
        $this->db->update('ms_kelompok_part',$dataUpdate);
    }

    public function ambilData($id){
        return $this->db->query("select mkpp.id_kelompok_part_produk,mkpp.nama_kelompok_part_produk from ms_kelompok_part_produk mkpp 
            where mkpp.id_kelompok_part_produk ={$id}")->row_array();
    }

    public function updateMsPartProduk($data){
        // var_dump($data);
        // die;
        $datas = array(
            'nama_kelompok_part_produk' => $data['nama_kelompok_part_produk'],
        );
        $this->db->trans_start();
        $this->db->where('id_kelompok_part_produk', $data['id_kelompok_part_produk']);
        $this->db->update('ms_kelompok_part_produk', $datas);
        $this->db->trans_complete();

        // reset data
        $resetMsPart = array(
            'id_kelompok_part_produk' => null,
        );
        $this->db->trans_start();
        $this->db->where('id_kelompok_part_produk', $data['id_kelompok_part_produk']);
        $this->db->update('ms_kelompok_part', $resetMsPart);
        $this->db->trans_complete();

        // perubahan data
        $perubahanMsPart = array(
            'id_kelompok_part_produk' => $data['id_kelompok_part_produk'],
        );
        foreach($data['kel_barang_mdp'] as $row){
            $this->db->trans_start();
            $this->db->from('ms_kelompok_part');
            $this->db->where('id_kelompok_part',$row);
            $this->db->update('ms_kelompok_part', $perubahanMsPart);
            $this->db->trans_complete();
        }
    }

}
