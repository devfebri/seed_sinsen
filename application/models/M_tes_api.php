<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_tes_api extends CI_Model
{

function getInvoiceSPK($filter)
  {

    $where = '';

    if($filter['id_dealer'] == ""){
        $where = "WHERE dl.kode_dealer_md = dl.kode_dealer_md"; 
    }elseif($filter['id_dealer'] == $filter['id_dealer']){
        if (($filter['id_dealer'])!='') {
        $where = "WHERE dl.kode_dealer_md in ({$filter['id_dealer']}) ";
        }
    }

    if (isset($filter['fromTime']) && isset($filter['toTime'])) {
       $where .= " AND inv.created_at BETWEEN '{$filter['fromTime']}' AND '{$filter['toTime']}'";
      }
      
    return $this->db->query("SELECT inv.id_invoice idInvoice,inv.id_spk idSPK,inv.id_customer idCustomer,rc.amount AS Amount,inv.jenis_beli tipePembayaran,cara_bayar caraBayar, inv.status AS Status,Note,dl.kode_dealer_md dealerId,inv.created_at createdTime,inv.updated_at AS modifiedTime 
      FROM tr_invoice_tjs inv
      JOIN tr_h1_dealer_invoice_receipt rc ON rc.id_invoice=inv.id_invoice
      JOIN ms_dealer dl ON dl.id_dealer=inv.id_dealer
      $where
    ");
  }

  public function sl_details($filter)
  {
      // $filter_dealer = '';
      // if ($id_dealer!='all') {
      //      $filter_dealer = "and nsc.id_dealer='$id_dealer'";
      // }
      $where = '';

      if($filter['id_dealer'] == ""){
          $where = "WHERE md.kode_dealer_md = md.kode_dealer_md"; 
      }elseif($filter['id_dealer'] == $filter['id_dealer']){
          if (($filter['id_dealer'])!='') {
          $where = "WHERE md.kode_dealer_md in ({$filter['id_dealer']}) ";
          }
      }
      if (isset($filter['fromTime']) && isset($filter['toTime'])) {
        $where .= " AND nsc.created_at BETWEEN '{$filter['fromTime']}' AND '{$filter['toTime']}'";
       }
      $sl_details = $this->db->query("SELECT 
      md.nama_dealer namaDealer, (CASE WHEN nsc.referensi='work_order' THEN 'WO' ELSE 'Direct Sales' END) AS referensi, md.kode_dealer_ahm kodeDealer, skp.produk , mp.kelompok_part kelParts, nscp.id_part idPart, mp.nama_part namaPart, SUM(nscp.qty) as Kuantitas, 
      nscp.harga_beli hargaBeli, (CASE WHEN md.h1 = 1 and md.h2 = 1 and md.h3 = 1 then 'H123' WHEN md.h1 = 0 and md.h2 = 1 and md.h3 = 1 THEN 'H23' 
          WHEN md.h1 = 0 and md.h2 = 0 and md.h3 = 1 THEN 'H3' ELSE '-' END) as Status, SUM(CASE WHEN nscp.tipe_diskon='Percentage' 
          then ((nscp.harga_beli*nscp.qty)-(nscp.harga_beli*nscp.diskon_value/100))
          WHEN nscp.tipe_diskon='Value' then ((nscp.harga_beli*nscp.qty)-nscp.diskon_value) ELSE nscp.harga_beli*nscp.qty END) as totalPenjualan, nsc.created_at createtAt
          FROM tr_h23_nsc nsc
          JOIN tr_h23_nsc_parts nscp on nscp.no_nsc=nsc.no_nsc 
          JOIN ms_part mp on mp.id_part_int=nscp.id_part_int 
          JOIN ms_h3_md_setting_kelompok_produk skp on skp.id_kelompok_part=mp.kelompok_part 
          JOIN ms_dealer md on md.id_dealer=nsc.id_dealer
          $where
          and mp.kelompok_part !='FED OIL' 
          GROUP BY nsc.id_dealer, mp.id_part, nsc.referensi
          ORDER BY md.nama_dealer");
      return $sl_details;
  }
}