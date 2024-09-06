<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Monitoring_supply_do extends CI_Controller
{
    private $dateStart= '2024-01-01';
    public function __construct(){
        parent::__construct();
        $this->load->model('h3_md_sales_order_model', 'sales_order');
    }

    public function index()
    {
        $this->make_datatables();
        $this->limit();

        $data = array();
        $index = 1;
        foreach ($this->db->get()->result_array() as $row) {
           
            $picking_list = $this->db->select('id_picking_list')
                                        ->select('id as id_picking_list_int')
                                        ->select('date_format(tanggal, "%d/%m/%Y") as tanggal_pl')
                                        ->select('date_format(tanggal_mulai_scan, "%d/%m/%Y") as tanggal_scan_pl')
                                        ->from('tr_h3_md_picking_list')
                                        ->where('id_ref_int',$row['id_do_sales_order_int'])
                                        ->get()->row_array();   
                                        

            if(isset($picking_list)){
                $packing_sheet = $this->db->select('*')
                    ->select('date_format(tgl_faktur, "%d/%m/%Y") as tanggal_faktur')
                    ->select('id_packing_sheet')
                    ->select('date_format(tgl_packing_sheet, "%d/%m/%Y") as tanggal_ps')
                    ->select('id as id_packing_sheet_int')
                    ->from('tr_h3_md_packing_sheet')
                    ->where('id_picking_list_int',$picking_list['id_picking_list_int'])
                    ->get()->row_array();
            }
            // var_dump($picking_list);
            //     die;  
            

            if(isset($packing_sheet)){
                $surat_jalan = $this->db->select('sp.id_surat_pengantar')
                    ->select('date_format(sp.tanggal, "%d/%m/%Y") as tanggal_sp')
                    ->select('date_format(sp.tgl_dealer_terima_barang, "%d/%m/%Y") as tanggal_dealer_terima_barang')
                    ->select('me.nama_ekspedisi')
                    ->select('spi.id_packing_sheet_int')
                    ->from('tr_h3_md_surat_pengantar sp')
                    ->join('tr_h3_md_surat_pengantar_items spi','sp.id=spi.id_surat_pengantar_int')
                    ->join('ms_h3_md_ekspedisi me','me.id = sp.id_ekspedisi ')
                    ->where('spi.id_packing_sheet_int',$packing_sheet['id_packing_sheet_int'])
                    ->get()->row_array();
                // var_dump($surat_jalan);
                // die;  
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

            if(isset($picking_list)){
                $row['id_picking_list']    = $picking_list['id_picking_list'];
                $row['tanggal_pl']         = $picking_list['tanggal_pl'];
                $row['tanggal_scan_pl']    = $picking_list['tanggal_scan_pl'];
            }  
            
            if(isset($packing_sheet)){
                $row['tanggal_faktur']    = $packing_sheet['tanggal_faktur'];
                $row['no_faktur']         = $packing_sheet['no_faktur'];
                $row['id_packing_sheet']  = $packing_sheet['id_packing_sheet'];
                $row['tanggal_ps']        = $packing_sheet['tanggal_ps'];
            }  

            if(isset($surat_jalan)){
                $row['id_surat_pengantar']              = $surat_jalan['id_surat_pengantar'];
                $row['tanggal_dealer_terima_barang']    = $surat_jalan['tanggal_dealer_terima_barang'];
                $row['nama_ekspedisi']                  = $surat_jalan['nama_ekspedisi'];
                $row['tanggal_sp']                      = $surat_jalan['tanggal_sp'];

                
                $row['lead_times'] = $row['tanggal_sp'] - $row['tanggal_do'];
            }
            
            $row['list_do'] = $this->load->view('additional/action_list_do_monitoring_supply', [
                'id_sales_order' => $row['id_sales_order'],
            ], true);

            $row['id_sales_order'] = $this->load->view('additional/action_open_so_monitoring_supply', [
                'id_sales_order' => $row['id_sales_order'],
            ], true);

            $row['index'] = $this->input->post('start') + $index;
            // var_dump($row);
            // die;
            $data[] = $row;

            $index++;
            
        }
       
        send_json([
            'draw' => intval($this->input->post('draw')),
            'recordsFiltered' => $this->recordsFiltered(),
            'recordsTotal' => $this->recordsTotal(),
            'data' => $data,
        ]);
    }

    public function make_query()
    {
        
        $this->db->reset_query();

        $this->db
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
        ->join('tr_h3_md_do_sales_order as do','do.id_sales_order_int = so.id')
        ->join('ms_dealer as d', 'd.id_dealer = so.id_dealer')
        ->join('ms_kelurahan as kel', 'kel.id_kelurahan = d.id_kelurahan', 'left')
        ->join('ms_kecamatan as kec', 'kec.id_kecamatan = kel.id_kecamatan', 'left')
        ->join('ms_kabupaten as kab', 'kab.id_kabupaten = kec.id_kabupaten', 'left')
        ;

        if($this->input->post('history') != null AND $this->input->post('history') == 1){
            $this->db->group_start();
                $this->db->where('left(so.created_at,10) <=', $this->dateStart);
                // $this->db->or_where('left(dso.created_at,10) <=', '2023-09-08');
            $this->db->group_end();
        }else{
            $this->db->group_start();
                $this->db->where('left(so.created_at,10) >', $this->dateStart);
                    // $this->db->where('dso.status =', 'On Process');
                    // $this->db->or_where('left(so.created_at,10) <=', '2023-09-08');
            $this->db->group_end();
        }

        if ($this->input->post('id_customer_filter')) {
            $this->db->where('so.id_dealer', $this->input->post('id_customer_filter'));
        }

        // if ($this->input->post('id_salesman_filter')) {
        //     $this->db->where('so.id_salesman', $this->input->post('id_salesman_filter'));
        // }

        if ($this->input->post('no_do_filter')) {
            $this->db->like('do.id_do_sales_order', $this->input->post('no_do_filter'));
        }

        if ($this->input->post('alamat_customer_filter')) {
            $this->db->like('d.alamat', $this->input->post('alamat_customer_filter'));
        }

        if ($this->input->post('nama_wilayah_filter')) {
            $this->db->like('d.daerah_h3', $this->input->post('nama_wilayah_filter'));
        }

        if ($this->input->post('id_kabupaten_filter')) {
            $this->db->like('kab.id_kabupaten', $this->input->post('id_kabupaten_filter'));
        }

        if ($this->input->post('kelompok_barang_filter')) {
            $this->db->like('so.produk', $this->input->post('kelompok_barang_filter'));
        }
        
        if ($this->input->post('status_filter') != null and count($this->input->post('status_filter')) > 0) {
            $this->db->where_in('do.status', $this->input->post('status_filter'));
        }
        
        if ($this->input->post('leadtime_filter')) {
            if($this->input->post('leadtime_filter') == '30'){
                $this->db->where('do.status', 'Shipping List');
            } else if ($this->input->post('leadtime_filter') == '99') {
                $this->db->where('(SELECT SUM(date_format(sp.tanggal, "%d/%m/%Y")-date_format(do.tanggal, "%d/%m/%Y")) as leadtimes
                    FROM tr_h3_md_sales_order as s 
                    JOIN tr_h3_md_do_sales_order as do ON do.id_sales_order_int = s.id 
                    JOIN ms_dealer as d ON d.id_dealer = s.id_dealer
                    JOIN tr_h3_md_picking_list as pl on pl.id_ref_int =do.id
                    JOIN tr_h3_md_packing_sheet as ps on ps.id_picking_list_int =pl.id 
                    join tr_h3_md_surat_pengantar_items as spi on spi.id_packing_sheet_int = ps.id 
                    join tr_h3_md_surat_pengantar as sp on sp.id=spi.id_surat_pengantar_int 
                    where s.id=so.id
                    group by s.id)=0 AND ( left(so.created_at,10) > "' . $this->dateStart . '" )');
                $this->db->or_where('(SELECT SUM(date_format(sp.tanggal, "%d/%m/%Y")-date_format(do.tanggal, "%d/%m/%Y")) as leadtimes
                    FROM tr_h3_md_sales_order as s 
                    JOIN tr_h3_md_do_sales_order as do ON do.id_sales_order_int = s.id 
                    JOIN ms_dealer as d ON d.id_dealer = s.id_dealer
                    JOIN tr_h3_md_picking_list as pl on pl.id_ref_int =do.id
                    JOIN tr_h3_md_packing_sheet as ps on ps.id_picking_list_int =pl.id 
                    join tr_h3_md_surat_pengantar_items as spi on spi.id_packing_sheet_int = ps.id 
                    join tr_h3_md_surat_pengantar as sp on sp.id=spi.id_surat_pengantar_int 
                    where s.id=so.id
                    group by s.id) IS NULL AND ( left(so.created_at,10) > "'.$this->dateStart.'" )');
            }
            else{
                $this->db->where('(SELECT SUM(date_format(sp.tanggal, "%d/%m/%Y")-date_format(do.tanggal, "%d/%m/%Y")) as leadtimes
                    FROM tr_h3_md_sales_order as s 
                    JOIN tr_h3_md_do_sales_order as do ON do.id_sales_order_int = s.id 
                    JOIN ms_dealer as d ON d.id_dealer = s.id_dealer
                    JOIN tr_h3_md_picking_list as pl on pl.id_ref_int =do.id
                    JOIN tr_h3_md_packing_sheet as ps on ps.id_picking_list_int =pl.id 
                    join tr_h3_md_surat_pengantar_items as spi on spi.id_packing_sheet_int = ps.id 
                    join tr_h3_md_surat_pengantar as sp on sp.id=spi.id_surat_pengantar_int 
                    where s.id=so.id
                    group by s.id)='. $this->input->post('leadtime_filter'));
            }
        }

        $periode_po_filter_start = $this->input->post('periode_po_filter_start');
        $periode_po_filter_end = $this->input->post('periode_po_filter_end');
        if($periode_po_filter_start != null and $periode_po_filter_end != null){            
            $this->db->group_start();
            $this->db->where(sprintf('do.tanggal between "%s" and "%s"', $periode_po_filter_start, $periode_po_filter_end), null, false);
            $this->db->group_end();
        }

        
    }

    public function make_datatables()
    {
        $this->make_query();

        if (isset($_POST["order"])) {
            $indexColumn = $_POST['order']['0']['column'];
            $name = $_POST['columns'][$indexColumn]['name'];
            $data = $_POST['columns'][$indexColumn]['data'];
            $this->db->order_by( $name != '' ? $name : $data , $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('so.created_at', 'desc');
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
