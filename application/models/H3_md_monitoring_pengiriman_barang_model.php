<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class H3_md_monitoring_pengiriman_barang_model extends CI_Model{
		public function __construct()
        {
            parent::__construct();
        }

        public function query($start_date,$end_date)
        {

            //  var_dump($start_date);
            //  die;
            $query=$this->db
            ->select('so.id_sales_order')
            ->select('do.id_do_sales_order')
            ->select('do.id as id_do_sales_order_int')
            ->select('d.nama_dealer')
            ->select('d.kode_dealer_md')
            ->select('do.status')
            ->select('so.produk')
            ->select('date_format(do.tanggal, "%d/%m/%Y") as tanggal_do')
            ->select('kab.kabupaten')
            ->select('d.daerah_h3')
            ->from('tr_h3_md_sales_order as so')
            ->join('tr_h3_md_do_sales_order as do', 'do.id_sales_order_int = so.id')
            ->join('ms_dealer as d', 'd.id_dealer = so.id_dealer')
            ->join('ms_kelurahan as kel', 'kel.id_kelurahan = d.id_kelurahan', 'left')
            ->join('ms_kecamatan as kec', 'kec.id_kecamatan = kel.id_kecamatan', 'left')
            ->join('ms_kabupaten as kab', 'kab.id_kabupaten = kec.id_kabupaten', 'left')
            ->where('do.tanggal >=',$start_date)
            ->where('do.tanggal <=',$end_date);

            $data=array();
            $index=1;

            foreach($this->db->get()->result_array() as $row){
                $picking_list = $this->db->select('id_picking_list')
                    ->select('id as id_picking_list_int')
                    ->select('date_format(tanggal, "%d/%m/%Y") as tanggal_pl')
                    ->select('date_format(tanggal_mulai_scan, "%d/%m/%Y") as tanggal_scan_pl')
                    ->from('tr_h3_md_picking_list')
                    ->where('id_ref_int', $row['id_do_sales_order_int'])
                    ->get()->row_array();
                if (isset($picking_list)) {
                    $packing_sheet = $this->db->select('no_faktur')
                        ->select('date_format(tgl_faktur, "%d/%m/%Y") as tanggal_faktur')
                        ->select('id_packing_sheet')
                        ->select('date_format(tgl_packing_sheet, "%d/%m/%Y") as tanggal_ps')
                        ->select('id as id_packing_sheet_int')
                        ->from('tr_h3_md_packing_sheet')
                        ->where('id_picking_list_int', $picking_list['id_picking_list_int'])
                        ->get()->row_array();
                }
                if (isset($packing_sheet)) {
                    $surat_jalan = $this->db->select('sp.id_surat_pengantar')
                    ->select('date_format(sp.tanggal, "%d/%m/%Y") as tanggal_sp')
                    ->select('date_format(sp.tgl_dealer_terima_barang, "%d/%m/%Y") as tanggal_dealer_terima_barang')
                    ->select('me.nama_ekspedisi')
                    ->from('tr_h3_md_surat_pengantar sp')
                    ->join('tr_h3_md_surat_pengantar_items spi', 'sp.id=spi.id_surat_pengantar_int')
                    ->join('ms_h3_md_ekspedisi me', 'me.id = sp.id_ekspedisi ')
                    ->where('spi.id_packing_sheet_int', $packing_sheet['id_packing_sheet_int'])
                    ->get()->row_array();
                }
                $row['id_picking_list']    = '';
                $row['tanggal_pl']         = '';
                $row['tanggal_scan_pl']    = '';
                $row['tanggal_faktur']    =  '';
                $row['no_faktur']         =  '';
                $row['id_packing_sheet']  =  '';
                $row['tanggal_ps']        =  '';
                $row['id_surat_pengantar']    =  '';
                $row['tanggal_dealer_terima_barang']         =  '';
                $row['nama_ekspedisi']  =  '';
                $row['tanggal_sp']        =  '';
                $row['lead_times'] = 0;
                if (isset($picking_list)) {
                    $row['id_picking_list']    = $picking_list['id_picking_list'];
                    $row['tanggal_pl']         = $picking_list['tanggal_pl'];
                    $row['tanggal_scan_pl']    = $picking_list['tanggal_scan_pl'];
                }

                if (isset($packing_sheet)) {
                    $row['tanggal_faktur']    = $packing_sheet['tanggal_faktur'];
                    $row['no_faktur']         = $packing_sheet['no_faktur'];
                    $row['id_packing_sheet']  = $packing_sheet['id_packing_sheet'];
                    $row['tanggal_ps']        = $packing_sheet['tanggal_ps'];
                }

                if (isset($surat_jalan)) {
                    $row['id_surat_pengantar']              = $surat_jalan['id_surat_pengantar'];
                    $row['tanggal_dealer_terima_barang']    = $surat_jalan['tanggal_dealer_terima_barang'];
                    $row['nama_ekspedisi']                  = $surat_jalan['nama_ekspedisi'];
                    $row['tanggal_sp']                      = $surat_jalan['tanggal_sp'];


                    $row['lead_times'] = $row['tanggal_sp'] - $row['tanggal_do'];
                }
                // $row['index'] = $this->input->post('start') + $index;
                $data[] = $row;
                $index++;
            }
            // var_dump($data[0]);
            // die;


       
            return $data;
        }

	}	
?>