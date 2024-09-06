<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
class M_event_location extends CI_Model {
    protected $table = 'ms_event_location';
    // private $_table = "ms_event_location";
    public function __construct()
    {
      parent::__construct();
      $this->load->database();
    }
    private $_table = 'ms_event_location';
    var $column_order = array('id_spot_btl_int', 'id_spot_btl', 'spot_btl', 'status', 'kecamatan', 'kelurahan');
    var $column_search = array('id_spot_btl', 'spot_btl', 'status', 'kecamatan', 'kelurahan');
    var $order = array('id_spot_btl' => 'asc');

    private function _getEventLocation($startDate = null, $endDate = null, $status = null, $searchValue = null)
    {
        $this->db->from($this->_table);
        $i = 0;

        if ($startDate && $endDate) {
            $this->db->where('start_date >=', $startDate);
            $this->db->where('end_date <=', $endDate);
        }

        if ($status !== null && $status !== '') {
            $this->db->where('status', $status);
        }

        $searchValue = $searchValue ? $searchValue : @$_POST['search']['value'];
    
        if ($searchValue && strlen($searchValue)) {
            foreach ($this->column_search as $item) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $searchValue);
                } else {
                    $this->db->or_like($item, $searchValue);
                }
                if (count($this->column_search) - 1 === $i) {
                    $this->db->group_end();
                }
                $i++;
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

    public function getEventLocation($startDate = null, $endDate = null, $status = null)
    {
        $this->_getEventLocation($startDate, $endDate, $status);
        if (@$_POST['length'] != -1) {
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function countFilterEventLocation($startDate = null, $endDate = null, $status = null)
    {
        $this->_getEventLocation($startDate, $endDate,$status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAllEventLocation()
    {
        $this->db->from($this->_table);
        return $this->db->count_all_results();
    }

    public function exportToExcel($startDate = null, $endDate = null, $status = null, $searchValue = null)
    {
        $this->_getEventLocation($startDate, $endDate, $status, $searchValue);
        $query = $this->db->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Spot BTL ID');
        $sheet->setCellValue('B1', 'Spot BTL');
        $sheet->setCellValue('C1', 'Status BTL');
        $sheet->setCellValue('D1', 'Alamat');
        $sheet->setCellValue('E1', 'ID Provinsi');
        $sheet->setCellValue('F1', 'Provinsi');
        $sheet->setCellValue('G1', 'ID Kabupaten');
        $sheet->setCellValue('H1', 'Kabupaten');
        $sheet->setCellValue('I1', 'ID Kecamatan');
        $sheet->setCellValue('J1', 'Kecamatan');
        $sheet->setCellValue('K1', 'ID Kelurahan');
        $sheet->setCellValue('L1', 'Kelurahan');
        $sheet->setCellValue('M1', 'Longitude');
        $sheet->setCellValue('N1', 'Latitude');
        $sheet->setCellValue('O1', 'Start Date');
        $sheet->setCellValue('P1', 'End Date');

        $headerStyle = [
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['rgb' => '92D050']
            ],
            'font' => [
                'bold' => true,
                'color' => ['rgb' => '000000']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER
            ]
        ];

        $bodyStyle = [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT
            ]
        ];

        $sheet->getStyle('A1:P1')->applyFromArray($headerStyle);
        // $sheet->getStyle('A:P')->applyFromArray($bodyStyle);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(35);
        $sheet->getColumnDimension('C')->setWidth(10);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(30);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(30);
        $sheet->getColumnDimension('M')->setWidth(25);
        $sheet->getColumnDimension('N')->setWidth(25);
        $sheet->getColumnDimension('O')->setWidth(15);
        $sheet->getColumnDimension('P')->setWidth(15);

        $rowNumber = 2;
        foreach ($query->result() as $row) {
            $sheet->setCellValue('A' . $rowNumber, $row->id_spot_btl);
            $sheet->setCellValue('B' . $rowNumber, $row->spot_btl);
            $sheet->setCellValue('C' . $rowNumber, $row->status);
            $sheet->setCellValue('D' . $rowNumber, $row->alamat);
            $sheet->setCellValue('E' . $rowNumber, $row->id_provinsi);
            $sheet->setCellValue('F' . $rowNumber, $row->provinsi);
            $sheet->setCellValue('G' . $rowNumber, $row->id_kabupaten);
            $sheet->setCellValue('H' . $rowNumber, $row->kabupaten);
            $sheet->setCellValue('I' . $rowNumber, $row->id_kecamatan);
            $sheet->setCellValue('J' . $rowNumber, $row->kecamatan);
            $sheet->setCellValue('K' . $rowNumber, $row->id_kelurahan);
            $sheet->setCellValue('L' . $rowNumber, $row->kelurahan);
            $sheet->setCellValue('M' . $rowNumber, $row->longitude);
            $sheet->setCellValue('N' . $rowNumber, $row->latitude);
            $sheet->setCellValue('O' . $rowNumber, $row->start_date);
            $sheet->setCellValue('P' . $rowNumber, $row->end_date);
            $rowNumber++;
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'Event_Lokasi_' . date('YmdHis') . '.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), 'List_Transaksi_') . '.xlsx';
        $writer->save($temp_file);

        return $temp_file;
    }

    public function _getKelurahan()
    {
        $query = $this->db->query("SELECT 
                    k.id_kelurahan, k.kelurahan, 
                    kc.id_kecamatan, kc.kecamatan, 
                    kb.id_kabupaten, kb.kabupaten, 
                    p.id_provinsi, p.provinsi
                FROM 
                    ms_kelurahan k
                JOIN 
                    ms_kecamatan kc ON k.id_kecamatan = kc.id_kecamatan
                JOIN 
                    ms_kabupaten kb ON kc.id_kabupaten = kb.id_kabupaten
                JOIN 
                    ms_provinsi p ON kb.id_provinsi = p.id_provinsi");
        return $query->result();
    }

    public function insert_event_location($data) {
        $this->db->insert('ms_event_location', $data);
    }

    public function get_event_location_by_id($id_spot_btl) {
        $this->db->where('id_spot_btl', $id_spot_btl);
        $query = $this->db->get('ms_event_location');
        return $query->row();
    }
    
    public function update_event_location($id_spot_btl, $data) {
        $this->db->where('id_spot_btl', $id_spot_btl);
        $this->db->update('ms_event_location', $data);
    }

}