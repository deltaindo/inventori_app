<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

date_default_timezone_set('Asia/Jakarta');

class Report extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        // login
        if ($this->session->userdata('email')) {
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->session->set_userdata($data);
            $this->load->vars($data);
        } else {
            redirect('auth');
        }

        // variabel global
        $this->kantor           = $this->session->userdata('id_kantor');
    }

    /**
     * Generates a report of jurnal barang masuk and downloads it as an Excel file.
     *
     * @return void
     */
    public function report_jurnal_masuk_barang()
    {
        $this->db->select('jurnal_barang_masuk.id,jurnal_barang_masuk.kode_barang_masuk,master_barang.nama_barang,master_kategori.nama_kategori,master_lokasi.nama_lokasi,master_kantor.nama_kantor,master_merek.nama_merek,jurnal_barang_masuk.tanggal_masuk,jurnal_barang_masuk.jenis_pakai,jurnal_barang_masuk.status_barang, jurnal_barang_masuk.jumlah_masuk,master_satuan.nama_satuan, jurnal_barang.keterangan, jurnal_barang_masuk.harga_barang, jurnal_barang_masuk.total, jurnal_barang_masuk.keterangan as deskripsi');
        $this->db->from('jurnal_barang');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_kategori', 'jurnal_barang.id_kategori = master_kategori.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->join('jurnal_barang_masuk', 'jurnal_barang.id = jurnal_barang_masuk.id_jurnal_barang');
        $this->db->where('master_kantor.id', $this->kantor);
        $this->db->order_by('jurnal_barang_masuk.id', 'DESC');
        $data['jurnal_barang_masuk'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Jurnal Barang Masuk');

        // Set title header
        $sheet->mergeCells('A1:O1');
        $sheet->setCellValue('A1', 'Report Jurnal Barang Masuk');
        $sheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Barang Masuk');
        $sheet->setCellValue('C2', 'Nama Barang');
        $sheet->setCellValue('D2', 'Nama Merek');
        $sheet->setCellValue('E2', 'Spesifikasi');
        $sheet->setCellValue('F2', 'Lokasi');
        $sheet->setCellValue('G2', 'Kantor');
        $sheet->setCellValue('H2', 'Tanggal Masuk');
        $sheet->setCellValue('I2', 'Jenis Pakai');
        $sheet->setCellValue('J2', 'Kategori');
        $sheet->setCellValue('K2', 'Status Barang');
        $sheet->setCellValue('L2', 'Jumlah Masuk');
        $sheet->setCellValue('M2', 'Harga Asset');
        $sheet->setCellValue('N2', 'Total Harga Asset');
        $sheet->setCellValue('O2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:O2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:O2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:O2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['jurnal_barang_masuk'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_barang_masuk']);
            $sheet->setCellValue('C' . $baris, $item['nama_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_merek']);
            $sheet->setCellValue('E' . $baris, $item['keterangan']);
            $sheet->setCellValue('F' . $baris, $item['nama_lokasi']);
            $sheet->setCellValue('G' . $baris, $item['nama_kantor']);
            $sheet->setCellValue('H' . $baris, $item['tanggal_masuk']);
            $sheet->setCellValue('I' . $baris, $item['jenis_pakai']);
            $sheet->setCellValue('J' . $baris, $item['nama_kategori']);
            $sheet->setCellValue('K' . $baris, $item['status_barang']);
            $sheet->setCellValue('L' . $baris, $item['jumlah_masuk'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('M' . $baris, $item['harga_barang']);
            $sheet->setCellValue('O' . $baris, $item['deskripsi']);
            $sheet->getStyle('M' . $baris)->getNumberFormat()->setFormatCode('Rp #,##');
            $sheet->setCellValue('N' . $baris, $item['total']);
            $sheet->getStyle('N' . $baris)->getNumberFormat()->setFormatCode('Rp #,##');
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:O' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'O') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = "Report_Jurnal_Masuk_Barang_{$currentDateTime}.xlsx";

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generate a report of inventory items in Excel format.
     *
     * This function retrieves data from the database and generates an Excel spreadsheet
     * containing information about inventory items. The report includes details such
     * as the item's code, product code, name, brand, specifications, date of entry,
     * employee name, department, date of assignment, number of assets, inventory
     * description, and return date.
     *
     * @return void
     */
    public function report_inventaris_barang()
    {
        $this->db->select('
                            jurnal_inventaris.id,
                            jurnal_inventaris.kode_inventaris,
                            jurnal_barang.kode_barang,
                            master_barang.nama_barang,
                            master_satuan.nama_satuan,
                            master_merek.nama_merek,
                            jurnal_barang.keterangan as spesifikasi,
                            jurnal_barang_masuk.tanggal_masuk,
                            master_karyawan.nama_karyawan,
                            master_divisi.nama_divisi,
                            jurnal_inventaris.tanggal_assign,
                            jurnal_inventaris.jumlah_assets,
                            jurnal_inventaris.keterangan,
                            jurnal_inventaris.tanggal_return
        ');
        $this->db->from('jurnal_inventaris');
        $this->db->join('master_karyawan', 'jurnal_inventaris.id_karyawan = master_karyawan.id', 'left');
        $this->db->join('master_divisi', 'master_karyawan.id_divisi = master_divisi.id', 'left');
        $this->db->join('jurnal_barang_masuk', 'jurnal_inventaris.id_jurnal_barang_masuk = jurnal_barang_masuk.id', 'left');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id', 'left');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id', 'left');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id', 'left');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id', 'left');
        $this->db->where('master_divisi.id_kantor', $this->kantor);
        $this->db->order_by('jurnal_inventaris.id', 'DESC');
        $data['inventaris'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Jurnal Inventaris Barang');

        // Set title header
        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'Report Jurnal Inventaris Barang');
        $sheet->getStyle('A1:M1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Kode Inventaris');
        $sheet->setCellValue('C2', 'Kode Barang');
        $sheet->setCellValue('D2', 'Nama Barang');
        $sheet->setCellValue('E2', 'Merek');
        $sheet->setCellValue('F2', 'Spesifikasi');
        $sheet->setCellValue('G2', 'Masuk Assets');
        $sheet->setCellValue('H2', 'Nama Karyawan');
        $sheet->setCellValue('I2', 'Divisi');
        $sheet->setCellValue('J2', 'Tanggal Assign');
        $sheet->setCellValue('K2', 'Jumlah Assets');
        $sheet->setCellValue('L2', 'Keterangan Inventaris');
        $sheet->setCellValue('M2', 'Tanggal Return');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:M2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:M2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:M2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['inventaris'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_inventaris']);
            $sheet->setCellValue('C' . $baris, $item['kode_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_barang']);
            $sheet->setCellValue('E' . $baris, $item['nama_merek']);
            $sheet->setCellValue('F' . $baris, $item['spesifikasi']);
            $sheet->setCellValue('G' . $baris, $item['tanggal_masuk']);
            $sheet->setCellValue('H' . $baris, $item['nama_karyawan']);
            $sheet->setCellValue('I' . $baris, $item['nama_divisi']);
            $sheet->setCellValue('J' . $baris, $item['tanggal_assign']);
            $sheet->setCellValue('K' . $baris, $item['jumlah_assets'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('L' . $baris, $item['keterangan']);
            $sheet->setCellValue('M' . $baris, $item['tanggal_return'] == null ? '-' : $item['tanggal_return']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:M' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'M') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = "Report_Jurnal_Inventaris_Barang_{$currentDateTime}.xlsx";

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates a report of the inventory journal for a specific warehouse.
     *
     * This function retrieves the inventory journal data for a specific warehouse
     * and generates an Excel report of the data. The report includes the following
     * columns: No, Kode Barang, Nama Barang, Merek, Jenis Assets, Lokasi, Kantor,
     * Spesifikasi, Jumlah Masuk, Jumlah Keluar, Stok Akhir, and Tanggal Update.
     *
     * @return void
     */
    public function report_jurnal_stok_barang()
    {
        $this->db->select('
                            jurnal_stok_barang.id, 
                            jurnal_barang.kode_barang, 
                            master_barang.nama_barang, 
                            master_merek.nama_merek, 
                            master_lokasi.nama_lokasi, 
                            master_satuan.nama_satuan, 
                            master_kantor.nama_kantor,
                            master_kategori.nama_kategori,  
                            jurnal_stok_barang.jumlah_masuk, 
                            jurnal_stok_barang.jumlah_keluar, 
                            jurnal_stok_barang.stok_akhir, 
                            jurnal_stok_barang.tanggal_update,
                            jurnal_barang.keterangan
        ');

        $this->db->from('jurnal_stok_barang');
        $this->db->join('jurnal_barang', 'jurnal_stok_barang.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_kategori', 'jurnal_barang.id_kategori = master_kategori.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');

        $this->db->where('master_kantor.id', $this->kantor);

        $this->db->group_by('
            jurnal_stok_barang.id, 
            jurnal_barang.kode_barang, 
            master_barang.nama_barang, 
            master_merek.nama_merek, 
            master_lokasi.nama_lokasi, 
            master_satuan.nama_satuan, 
            master_kantor.nama_kantor,
            master_kategori.nama_kategori,  
            jurnal_stok_barang.jumlah_masuk, 
            jurnal_stok_barang.jumlah_keluar, 
            jurnal_stok_barang.stok_akhir, 
            jurnal_stok_barang.tanggal_update
        ');

        $this->db->order_by('jurnal_stok_barang.id', 'DESC');
        $data['jurnal_stok'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Jurnal Stok Barang');

        // Set title header
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', 'Report Jurnal Stok Barang');
        $sheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Kode Barang');
        $sheet->setCellValue('C2', 'Nama Barang');
        $sheet->setCellValue('D2', 'Merek');
        $sheet->setCellValue('E2', 'Jenis Assets');
        $sheet->setCellValue('F2', 'Lokasi');
        $sheet->setCellValue('G2', 'Kantor');
        $sheet->setCellValue('H2', 'Spesifikasi');
        $sheet->setCellValue('I2', 'Jumlah Masuk');
        $sheet->setCellValue('J2', 'Jumlah Keluar');
        $sheet->setCellValue('K2', 'Stok Akhir');
        $sheet->setCellValue('L2', 'Tanggal Update');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:L2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:L2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:L2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['jurnal_stok'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_barang']);
            $sheet->setCellValue('C' . $baris, $item['nama_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_merek']);
            $sheet->setCellValue('E' . $baris, $item['nama_kategori']);
            $sheet->setCellValue('F' . $baris, $item['nama_lokasi']);
            $sheet->setCellValue('G' . $baris, $item['nama_kantor']);
            $sheet->setCellValue('H' . $baris, $item['keterangan']);
            $sheet->setCellValue('I' . $baris, $item['jumlah_masuk'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('J' . $baris, $item['jumlah_keluar'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('K' . $baris, $item['stok_akhir'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('L' . $baris, $item['tanggal_update'] == null ? '-' : $item['tanggal_update']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:L' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Jurnal_Stok_Barang_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates a report of the history of inventory and exports it as an Excel file.
     *
     * This function retrieves data from the database and populates an Excel spreadsheet
     * with the following information:
     * - Barang Masuk (Item Code)
     * - Nama Barang (Product Name)
     * - Nama Merek (Brand Name)
     * - Spesifikasi (Specification)
     * - Karyawan (Employee)
     * - Divisi (Division)
     * - Tanggal Assign (Assignment Date)
     * - Kondisi Awal (Initial Condition)
     * - Jumlah Assets (Number of Assets)
     * - Status Assets (Asset Status)
     * - Keterangan Inventaris (Inventory Description)
     * - Jenis Pakai (Type of Use)
     * - Tanggal Return (Return Date)
     * - Kondisi Akhir (Final Condition)
     *
     * The data is retrieved from the following tables:
     * - jurnal_inventaris
     * - history_assets
     * - master_karyawan
     * - master_divisi
     * - jurnal_barang_masuk
     * - jurnal_barang
     * - master_barang
     * - master_merek
     * - master_satuan
     * - master_lokasi
     * - master_kantor
     *
     * The report is filtered by the current kantor (office) ID.
     *
     * The report is ordered by the jurnal_inventaris.id in descending order.
     *
     * The generated Excel file is downloaded with the filename
     * "Report_History_Inventaris_YYYYMMDD_HHMMSS.xlsx".
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function report_history_inventaris()
    {
        $this->db->select('
                            jurnal_inventaris.id,
                            master_barang.nama_barang,
                            master_karyawan.nama_karyawan,
                            master_divisi.nama_divisi,
                            master_merek.nama_merek,
                            master_satuan.nama_satuan,
                            jurnal_inventaris.tanggal_assign,
                            jurnal_inventaris.tanggal_return,
                            history_assets.kondisi_awal,
                            history_assets.kondisi_akhir,
                            jurnal_inventaris.jumlah_assets,
                            jurnal_inventaris.status_assets,
                            jurnal_inventaris.keterangan as keterangan_inventaris,
                            jurnal_barang_masuk.jenis_pakai,
                            jurnal_barang_masuk.kode_barang_masuk as kode_barang,
                            jurnal_barang.keterangan as spesifikasi
        ');
        $this->db->from('jurnal_inventaris');
        $this->db->join('history_assets', 'history_assets.id_jurnal_inventaris = jurnal_inventaris.id');
        $this->db->join('master_karyawan', 'master_karyawan.id = jurnal_inventaris.id_karyawan');
        $this->db->join('master_divisi', 'master_divisi.id = master_karyawan.id_divisi');
        $this->db->join('jurnal_barang_masuk', 'jurnal_barang_masuk.id = jurnal_inventaris.id_jurnal_barang_masuk');
        $this->db->join('jurnal_barang', 'jurnal_barang.id = jurnal_barang_masuk.id_jurnal_barang');
        $this->db->join('master_barang', 'master_barang.id = jurnal_barang.id_barang');
        $this->db->join('master_merek', 'master_merek.id = jurnal_barang.id_merek');
        $this->db->join('master_satuan', 'master_satuan.id = jurnal_barang.id_satuan');
        $this->db->join('master_lokasi', 'master_lokasi.id = jurnal_barang.id_lokasi');
        $this->db->join('master_kantor', 'master_kantor.id = master_lokasi.id_kantor');

        $this->db->where('master_kantor.id', $this->kantor);

        $this->db->order_by('jurnal_inventaris.id', 'DESC');
        $data['history_inventaris'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report History Inventaris');

        // Set title header
        $sheet->mergeCells('A1:O1');
        $sheet->setCellValue('A1', 'Report History Inventaris');
        $sheet->getStyle('A1:O1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:O1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Barang Masuk');
        $sheet->setCellValue('C2', 'Nama Barang');
        $sheet->setCellValue('D2', 'Nama Merek');
        $sheet->setCellValue('E2', 'Spesifikasi');
        $sheet->setCellValue('F2', 'Karyawan');
        $sheet->setCellValue('G2', 'Divisi');
        $sheet->setCellValue('H2', 'Tanggal Assign');
        $sheet->setCellValue('I2', 'Kondisi Awal');
        $sheet->setCellValue('J2', 'Jumlah Assets');
        $sheet->setCellValue('K2', 'Status Assets');
        $sheet->setCellValue('L2', 'Keterangan Inventaris');
        $sheet->setCellValue('M2', 'Jenis Pakai');
        $sheet->setCellValue('N2', 'Tanggal Return');
        $sheet->setCellValue('O2', 'Kondisi Akhir');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:O2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:O2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:O2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['history_inventaris'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_barang']);
            $sheet->setCellValue('C' . $baris, $item['nama_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_merek']);
            $sheet->setCellValue('E' . $baris, $item['spesifikasi']);
            $sheet->setCellValue('F' . $baris, $item['nama_karyawan']);
            $sheet->setCellValue('G' . $baris, $item['nama_divisi']);
            $sheet->setCellValue('H' . $baris, $item['tanggal_assign']);
            $sheet->setCellValue('I' . $baris, $item['kondisi_awal']);
            $sheet->setCellValue('J' . $baris, $item['jumlah_assets'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('K' . $baris, $item['status_assets']);
            $sheet->setCellValue('L' . $baris, $item['keterangan_inventaris']);
            $sheet->setCellValue('M' . $baris, $item['jenis_pakai']);
            $sheet->setCellValue('N' . $baris, $item['tanggal_return'] == Null ? '-' : $item['tanggal_return']);
            $sheet->setCellValue('O' . $baris, $item['kondisi_akhir'] == Null ? '-' : $item['kondisi_akhir']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:O' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'O') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_History_Inventaris_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generate a report of assets inventory and download it as an Excel file.
     *
     * @return void
     */
    public function report_assets_inventaris()
    {
        $this->db->select('
            jurnal_barang_masuk.kode_barang_masuk,
            jurnal_barang.kode_barang,
            master_barang.nama_barang,
            master_merek.nama_merek,
            jurnal_barang.keterangan as spesifikasi,
            jurnal_barang_masuk.tanggal_masuk,
            jurnal_barang_masuk.jenis_pakai,
            jurnal_barang_masuk.status_barang,
            jurnal_barang_masuk.jumlah_masuk,
            master_satuan.nama_satuan
        ');

        $this->db->from('jurnal_barang_masuk');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->group_start();
        $this->db->where('jurnal_barang_masuk.jenis_pakai', 'Inventaris');
        $this->db->or_where('jurnal_barang_masuk.jenis_pakai', 'Peminjaman');
        $this->db->group_end();
        $this->db->order_by('jurnal_barang_masuk.id', 'DESC');
        $data['assets_report'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Assets Inventaris');

        // Set title header
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'Report Assets Inventaris');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Barang Masuk');
        $sheet->setCellValue('C2', 'Kode Barang');
        $sheet->setCellValue('D2', 'Barang');
        $sheet->setCellValue('E2', 'Merek');
        $sheet->setCellValue('F2', 'Spesifikasi');
        $sheet->setCellValue('G2', 'Tanggal Masuk');
        $sheet->setCellValue('H2', 'Jenis Pakai');
        $sheet->setCellValue('I2', 'Status Barang');
        $sheet->setCellValue('J2', 'Jumlah Masuk');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:J2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:J2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['assets_report'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_barang_masuk']);
            $sheet->setCellValue('C' . $baris, $item['kode_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_barang']);
            $sheet->setCellValue('E' . $baris, $item['nama_merek']);
            $sheet->setCellValue('F' . $baris, $item['spesifikasi']);
            $sheet->setCellValue('G' . $baris, $item['tanggal_masuk']);
            $sheet->setCellValue('H' . $baris, $item['jenis_pakai']);
            $sheet->setCellValue('I' . $baris, $item['status_barang']);
            $sheet->setCellValue('J' . $baris, $item['jumlah_masuk'] . ' ' . $item['nama_satuan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:J' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Assets_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Exports data from the 'master_lokasi' table as an Excel file.
     *
     * This function retrieves data from the 'master_lokasi' table and its related
     * table 'master_kantor'. It joins the tables based on the 'id_kantor' column
     * and applies a filter to only retrieve data for the current kantor. The data
     * is then populated into an Excel spreadsheet and downloaded as a file.
     *
     * @return void
     */
    public function export_excel_lokasi()
    {
        $this->db->select('master_lokasi.id, master_kantor.nama_kantor, master_lokasi.nama_lokasi, master_lokasi.keterangan');
        $this->db->from('master_lokasi');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->order_by('master_lokasi.id', 'DESC');
        $data['lokasi_report'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Data Lokasi');

        // Set title header
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'Report Data Lokasi');
        $sheet->getStyle('A1:D1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Kantor');
        $sheet->setCellValue('C2', 'Nama Lokasi');
        $sheet->setCellValue('D2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:D2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:D2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:D2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['lokasi_report'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['nama_kantor']);
            $sheet->setCellValue('C' . $baris, $item['nama_lokasi']);
            $sheet->setCellValue('D' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:D' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'D') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Data_Lokasi_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates an Excel report of the master barang data.
     *
     * This function retrieves the master barang data from the database and generates an Excel report.
     * The report includes the following columns:
     * - No: The serial number of the barang.
     * - Nama Barang: The name of the barang.
     *
     * The report is downloaded as an Excel file with the filename "Report_Data_Barang_YYYYMMDD_HHMMSS.xlsx",
     * where YYYYMMDD_HHMMSS is the current date and time in the format YYYYMMDD_HHMMSS.
     *
     * @return void
     */
    public function report_excel_barang()
    {
        $this->db->order_by('id', 'DESC');
        $data['report_barang'] = $this->db->get('master_barang')->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Data Master Barang');

        // Set title header
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', 'Report Data Master Barang');
        $sheet->getStyle('A1:D1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:D1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Barang');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:B2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:B2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:B2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['report_barang'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['nama_barang']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:B' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'B') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Data_Barang_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates an Excel report of the master satuan data and downloads it.
     *
     * @return void
     */
    public function report_excel_satuan()
    {
        $this->db->order_by('id', 'DESC');
        $data['report_satuan'] = $this->db->get('master_satuan')->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Data Master Satuan');

        // Set title header
        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'Report Data Master Satuan');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Satuan');
        $sheet->setCellValue('C2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:C2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:C2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:C2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['report_satuan'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['nama_satuan']);
            $sheet->setCellValue('C' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:C' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Data_Master_Satuan_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates an Excel report of the master merek data and prompts the user to download it.
     *
     * This function retrieves the master merek data from the database, sorts it in descending order by the 'id' column,
     * and stores it in the '$data' variable. It then creates a new Spreadsheet object and sets the active sheet's title
     * to 'Report Data Master Merek'. The function sets the title header with the text 'Report Data Master Merek' in bold
     * and centered. It sets the header cells with the labels 'No', 'Nama Merek', and 'Keterangan'. The header cells are
     * styled with bold font and a background color. The function populates the data from the '$data' variable into the
     * spreadsheet, starting from the cell 'A3'. The data is populated row by row, with the 'No' column incrementing by 1
     * for each row. The function applies a thin border style to all cells in the spreadsheet. The function sets the
     * auto size for all columns in the spreadsheet. The function generates a filename with the current date and time in
     * the format 'YYYYMMDD_HHMMSS' and sets the headers for download. Finally, the function saves the spreadsheet as an
     * Excel file and prompts the user to download it.
     *
     * @throws None
     * @return void
     */
    public function report_excel_merek()
    {
        $this->db->order_by('id', 'DESC');
        $data['report_merek'] = $this->db->get('master_merek')->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Data Master Merek');

        // Set title header
        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'Report Data Master Merek');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Merek');
        $sheet->setCellValue('C2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:C2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:C2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:C2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['report_merek'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['nama_merek']);
            $sheet->setCellValue('C' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:C' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Data_Master_Merek_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates an Excel report of the master category data and prompts the user to download it.
     *
     * This function retrieves the master category data from the database, sorts it in descending order by ID,
     * and stores it in the `$data['report_kategori']` array. It then creates a new Spreadsheet object,
     * sets the title of the sheet to "Report Data Master Kategori", and sets the title header to "Report Data Master Kategori"
     * in bold, 15-point font, and centered horizontally. The header also spans across columns A to C.
     * The function then sets the header row with the column names "No", "Nama Kategori", and "Keterangan".
     * The header row is styled with bold font and a background color of gray.
     *
     * The function populates the data rows starting from row 3 with the category data.
     * Each row contains the category number, name, and description.
     * The data rows are styled with a thin border.
     *
     * The function sets the auto size for all columns.
     *
     * The function generates a filename with the current date and time in the format "YYYYMMDD_HHMMSS.xlsx".
     *
     * The function sets the appropriate headers for downloading the Excel file and saves the Spreadsheet object
     * to the output stream. Finally, the function exits the script.
     *
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function report_excel_kategori()
    {
        $this->db->order_by('id', 'DESC');
        $data['report_kategori'] = $this->db->get('master_kategori')->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Data Master Kategori');

        // Set title header
        $sheet->mergeCells('A1:C1');
        $sheet->setCellValue('A1', 'Report Data Master Kategori');
        $sheet->getStyle('A1:C1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:C1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Nama Kategori');
        $sheet->setCellValue('C2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:C2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:C2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:C2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['report_kategori'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['nama_kategori']);
            $sheet->setCellValue('C' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:C' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'C') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Data_Master_Kategori_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates a report of journal items for a specific office location and exports it as an Excel file.
     *
     * @return void
     */
    public function report_jurnal_barang()
    {
        $this->db->select('jurnal_barang.id,jurnal_barang.kode_barang,jurnal_barang.keterangan, master_barang.nama_barang, master_lokasi.nama_lokasi, master_kantor.nama_kantor, master_merek.nama_merek, master_kategori.nama_kategori, master_satuan.nama_satuan');
        $this->db->from('jurnal_barang');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_kategori', 'jurnal_barang.id_kategori = master_kategori.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->where('master_kantor.id', $this->kantor);
        $this->db->order_by('jurnal_barang.id', 'DESC');
        $data['report_jurnal_barang'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Jurnal Barang');

        // Set title header
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', 'Report Jurnal Barang');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Kode Barang');
        $sheet->setCellValue('C2', 'Nama Barang');
        $sheet->setCellValue('D2', 'Merek');
        $sheet->setCellValue('E2', 'Lokasi');
        $sheet->setCellValue('F2', 'Kantor');
        $sheet->setCellValue('G2', 'Satuan');
        $sheet->setCellValue('H2', 'Kategori');
        $sheet->setCellValue('I2', 'Spesifikasi');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:I2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:I2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['report_jurnal_barang'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_barang']);
            $sheet->setCellValue('C' . $baris, $item['nama_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_merek']);
            $sheet->setCellValue('E' . $baris, $item['nama_lokasi']);
            $sheet->setCellValue('F' . $baris, $item['nama_kantor']);
            $sheet->setCellValue('G' . $baris, $item['nama_satuan']);
            $sheet->setCellValue('H' . $baris, $item['nama_kategori']);
            $sheet->setCellValue('I' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:I' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Jurnal_Barang_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generate a report of jurnal alat peraga (equipment) in Excel format.
     *
     * This function retrieves data from the database and creates an Excel spreadsheet
     * containing the report. The report includes information such as the code of the
     * equipment, the code of the item, the name of the item, the brand, the specifications,
     * the destination of allocation, the date of purchase, the date of calibration,
     * the expiration date of calibration, the quantity, and the description.
     *
     * @return void
     */
    public function report_jurnal_alat_peraga()
    {
        $this->db->select('
                            jurnal_alat_peraga.id,
                            jurnal_alat_peraga.kode_alat_peraga,
                            jurnal_barang.kode_barang,
                            master_barang.nama_barang,
                            master_merek.nama_merek,
                            master_satuan.nama_satuan,
                            jurnal_barang.keterangan as spesifikasi,
                            jurnal_alat_peraga.alokasi_tujuan,
                            jurnal_alat_peraga.tanggal_beli,
                            jurnal_alat_peraga.tanggal_kalibrasi,
                            jurnal_alat_peraga.masa_berlaku_kalibrasi,
                            jurnal_alat_peraga.jumlah,
                            jurnal_alat_peraga.keterangan
        ');
        $this->db->from('jurnal_alat_peraga');
        $this->db->join('jurnal_barang_masuk', 'jurnal_alat_peraga.id_jurnal_barang_masuk = jurnal_barang_masuk.id');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->order_by('jurnal_alat_peraga.id', 'DESC');
        $data['alat_peraga'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Jurnal Alat Peraga');

        // Set title header
        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', 'Report Jurnal Alat Peraga');
        $sheet->getStyle('A1:L1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Kode Alat Peraga');
        $sheet->setCellValue('C2', 'Kode Barang');
        $sheet->setCellValue('D2', 'Nama Barang');
        $sheet->setCellValue('E2', 'Merek');
        $sheet->setCellValue('F2', 'Spesifikasi');
        $sheet->setCellValue('G2', 'Alokasi Tujuan');
        $sheet->setCellValue('H2', 'Tanggal Beli');
        $sheet->setCellValue('I2', 'Tanggal Kalibrasi');
        $sheet->setCellValue('J2', 'Masa Kalibrasi');
        $sheet->setCellValue('K2', 'Jumlah');
        $sheet->setCellValue('L2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:L2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:L2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:L2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['alat_peraga'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_alat_peraga']);
            $sheet->setCellValue('C' . $baris, $item['kode_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_barang']);
            $sheet->setCellValue('E' . $baris, $item['nama_merek']);
            $sheet->setCellValue('F' . $baris, $item['spesifikasi']);
            $sheet->setCellValue('G' . $baris, $item['alokasi_tujuan']);
            $sheet->setCellValue('H' . $baris, $item['tanggal_beli']);
            $sheet->setCellValue('I' . $baris, $item['tanggal_kalibrasi']);
            $sheet->setCellValue('J' . $baris, $item['masa_berlaku_kalibrasi']);
            $sheet->setCellValue('K' . $baris, $item['jumlah'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('L' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:L' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Jurnal_Barang_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generates a report of jurnal alat peserta and exports it as an Excel file.
     *
     * @return void
     */
    public function report_jurnal_alat_peserta()
    {
        $this->db->select('
                            jurnal_alat_peserta.id,
                            jurnal_alat_peserta.kode_alat_peserta,
                            jurnal_barang.kode_barang,
                            master_barang.nama_barang,
                            master_merek.nama_merek,
                            master_satuan.nama_satuan,
                            jurnal_barang.keterangan as spesifikasi,
                            jurnal_alat_peserta.tujuan_barang_keluar,
                            jurnal_alat_peserta.tanggal_keluar,
                            jurnal_alat_peserta.jumlah,
                            jurnal_alat_peserta.keterangan
        ');
        $this->db->from('jurnal_alat_peserta');
        $this->db->join('jurnal_barang_masuk', 'jurnal_alat_peserta.id_jurnal_barang_masuk = jurnal_barang_masuk.id');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->order_by('jurnal_alat_peserta.id', 'DESC');
        $data['alat_peserta'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Jurnal Alat Perserta');

        // Set title header
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', 'Report Jurnal Alat Peserta');
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Jurnal Alat Peserta');
        $sheet->setCellValue('C2', 'Kode Barang');
        $sheet->setCellValue('D2', 'Nama Barang');
        $sheet->setCellValue('E2', 'Merek');
        $sheet->setCellValue('F2', 'Spesifikasi');
        $sheet->setCellValue('G2', 'Tujuan Barang Keluar');
        $sheet->setCellValue('H2', 'Tanggal Keluar');
        $sheet->setCellValue('I2', 'Jumlah Keluar');
        $sheet->setCellValue('J2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:J2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:J2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:J2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['alat_peserta'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_alat_peserta']);
            $sheet->setCellValue('C' . $baris, $item['kode_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_barang']);
            $sheet->setCellValue('E' . $baris, $item['nama_merek']);
            $sheet->setCellValue('F' . $baris, $item['spesifikasi']);
            $sheet->setCellValue('G' . $baris, $item['tujuan_barang_keluar']);
            $sheet->setCellValue('H' . $baris, $item['tanggal_keluar']);
            $sheet->setCellValue('I' . $baris, $item['jumlah'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('J' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:J' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Jurnal_Alat_Peserta_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Generate a report of the office supplies journal for the current office.
     *
     * This function retrieves data from the database and generates an Excel spreadsheet
     * containing the information of the office supplies journal. The report includes
     * the following columns: No, Kode ATK, Kode Barang, Nama Barang, Merek, Spesifikasi,
     * Nama Karyawan, Divisi, Tanggal Pengambilan, Jumlah Pengambilan, and Keterangan.
     *
     * @return void
     */
    public function report_jurnal_alat_tulis_kantor()
    {
            $this->db->select('
                            jurnal_alat_tulis_kantor.id,
                            jurnal_alat_tulis_kantor.kode_alat_tulis_kantor,
                            jurnal_barang.kode_barang,
                            master_barang.nama_barang,
                            master_merek.nama_merek,
                            master_satuan.nama_satuan,
                            master_karyawan.nama_karyawan,
                            master_divisi.nama_divisi,
                            jurnal_barang.keterangan as spesifikasi,
                            jurnal_alat_tulis_kantor.tanggal_pengambilan,
                            jurnal_alat_tulis_kantor.jumlah_pengambilan,
                            jurnal_alat_tulis_kantor.keterangan
            ');
            $this->db->from('jurnal_alat_tulis_kantor');
            $this->db->join('jurnal_barang_masuk', 'jurnal_alat_tulis_kantor.id_jurnal_barang_masuk = jurnal_barang_masuk.id');
            $this->db->join('master_karyawan', 'jurnal_alat_tulis_kantor.id_karyawan = master_karyawan.id');
            $this->db->join('master_divisi', 'master_karyawan.id_divisi = master_divisi.id');
            $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
            $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
            $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
            $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
            $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
            $this->db->where('master_lokasi.id_kantor', $this->kantor);
            $this->db->order_by('jurnal_alat_tulis_kantor.id', 'DESC');
            $data['alat_tulis_kantor'] = $this->db->get()->result_array();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Report Jurnal Alat Tulis Kantor');

            // Set title header
            $sheet->mergeCells('A1:K1');
            $sheet->setCellValue('A1', 'Report Jurnal Alat Tulis Kantor');
            $sheet->getStyle('A1:K1')->getFont()->setBold(true)->setSize(15);
            $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Set header
            $sheet->setCellValue('A2', 'No');
            $sheet->setCellValue('B2', 'Kode ATK');
            $sheet->setCellValue('C2', 'Kode Barang');
            $sheet->setCellValue('D2', 'Nama Barang');
            $sheet->setCellValue('E2', 'Merek');
            $sheet->setCellValue('F2', 'Spesifikasi');
            $sheet->setCellValue('G2', 'Nama Karyawan');
            $sheet->setCellValue('H2', 'Divisi');
            $sheet->setCellValue('I2', 'Tanggal Pengambilan');
            $sheet->setCellValue('J2', 'Jumlah Pengambilan');
            $sheet->setCellValue('K2', 'Keterangan');

            // Apply bold style and background color to header
            $sheet->getStyle('A2:K2')->getFont()->setBold(true)->setSize(12);;
            $sheet->getStyle('A2:K2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
            $sheet->getStyle('A2:K2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

            // Populate data
            $baris = 3;
            $no = 1;
            foreach ($data['alat_tulis_kantor'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_alat_tulis_kantor']);
            $sheet->setCellValue('C' . $baris, $item['kode_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_barang']);
            $sheet->setCellValue('E' . $baris, $item['nama_merek']);
            $sheet->setCellValue('F' . $baris, $item['spesifikasi']);
            $sheet->setCellValue('G' . $baris, $item['nama_karyawan']);
            $sheet->setCellValue('H' . $baris, $item['nama_divisi']);
            $sheet->setCellValue('I' . $baris, $item['tanggal_pengambilan']);
            $sheet->setCellValue('J' . $baris, $item['jumlah_pengambilan'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('K' . $baris, $item['keterangan']);
            $baris++;
            }

            // Apply border style to all cells
            $styleArray = [
            'borders' => [
            'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ];
            $sheet->getStyle('A2:K' . ($baris - 1))->applyFromArray($styleArray);

            // Set auto size for all columns
            foreach (range('A', 'K') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Generate filename with current date and time
            $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
            $filename = 'Report_Jurnal_Alat_Tulis_' . $currentDateTime . '.xlsx';

            // Set headers for download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
    }

    /**
     * Generates a report of peminjaman inventaris in an Excel spreadsheet.
     *
     * This function retrieves data from the database tables jurnal_pinjam_inventaris,
     * jurnal_barang_masuk, master_karyawan, master_divisi, jurnal_barang, master_barang,
     * master_merek, master_satuan, and master_lokasi. The data is then used to populate
     * an Excel spreadsheet with the following columns: No, Kode Peminjaman, Kode Barang,
     * Nama Barang, Merk, Spesifikasi, Nama Karyawan, Divisi, Tujuan Pinjam,
     * Tanggal Pinjam, Jumlah Pinjam, Kondisi Pinjam, Tanggal Kembali, Kondisi Kembali,
     * Status, and Kata Keterangan.
     *
     * The generated spreadsheet is then downloaded as a file named 'Report_Jurnal_Peminjaman_Inventaris_{currentDateTime}.xlsx'.
     *
     * @return void
     */
    public function report_jurnal_peminjaman_inventaris()
    {
        $this->db->select('
                jurnal_pinjam_inventaris.id,
                jurnal_pinjam_inventaris.kode_pinjam_inventaris,
                jurnal_barang.kode_barang,
                master_barang.nama_barang,
                master_merek.nama_merek,
                master_satuan.nama_satuan,
                master_karyawan.nama_karyawan,
                master_divisi.nama_divisi,
                jurnal_barang.keterangan as spesifikasi,
                jurnal_pinjam_inventaris.tujuan_pinjam,
                jurnal_pinjam_inventaris.tanggal_pinjam,
                jurnal_pinjam_inventaris.jumlah_pinjam,
                jurnal_pinjam_inventaris.kondisi_pinjam,
                jurnal_pinjam_inventaris.tanggal_kembali,
                jurnal_pinjam_inventaris.kondisi_kembali,
                jurnal_pinjam_inventaris.status,
                jurnal_pinjam_inventaris.keterangan,
        ');
        $this->db->from('jurnal_pinjam_inventaris');
        $this->db->join('jurnal_barang_masuk', 'jurnal_pinjam_inventaris.id_jurnal_barang_masuk = jurnal_barang_masuk.id');
        $this->db->join('master_karyawan', 'jurnal_pinjam_inventaris.id_karyawan = master_karyawan.id');
        $this->db->join('master_divisi', 'master_karyawan.id_divisi = master_divisi.id');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->order_by('jurnal_pinjam_inventaris.id', 'DESC');
        $data['pinjam_inventaris'] = $this->db->get()->result_array();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Report Peminjaman Inventaris');

        // Set title header
        $sheet->mergeCells('A1:P1');
        $sheet->setCellValue('A1', 'Report Peminjaman Inventaris');
        $sheet->getStyle('A1:P1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:P1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Kode Peminjaman');
        $sheet->setCellValue('C2', 'Kode Barang');
        $sheet->setCellValue('D2', 'Nama Barang');
        $sheet->setCellValue('E2', 'Merek');
        $sheet->setCellValue('F2', 'Spesifikasi');
        $sheet->setCellValue('G2', 'Nama Karyawan');
        $sheet->setCellValue('H2', 'Divisi');
        $sheet->setCellValue('I2', 'Tujuan Pinjam');
        $sheet->setCellValue('J2', 'Tanggal Pinjam');
        $sheet->setCellValue('K2', 'Jumlah Pinjam');
        $sheet->setCellValue('L2', 'Kondisi Pinjam');
        $sheet->setCellValue('M2', 'Tanggal Kembali');
        $sheet->setCellValue('N2', 'Kondisi Kembali');
        $sheet->setCellValue('O2', 'Status');
        $sheet->setCellValue('P2', 'Keterangan');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:P2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:P2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:P2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['pinjam_inventaris'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_pinjam_inventaris']);
            $sheet->setCellValue('C' . $baris, $item['kode_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_barang']);
            $sheet->setCellValue('E' . $baris, $item['nama_merek']);
            $sheet->setCellValue('F' . $baris, $item['spesifikasi']);
            $sheet->setCellValue('G' . $baris, $item['nama_karyawan']);
            $sheet->setCellValue('H' . $baris, $item['nama_divisi']);
            $sheet->setCellValue('I' . $baris, $item['tujuan_pinjam']);
            $sheet->setCellValue('J' . $baris, $item['tanggal_pinjam']);
            $sheet->setCellValue('K' . $baris, $item['jumlah_pinjam'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('L' . $baris, $item['kondisi_pinjam']);
            $sheet->setCellValue('M' . $baris, $item['tanggal_kembali'] == null ? '-' : $item['tanggal_kembali']);
            $sheet->setCellValue('N' . $baris, $item['kondisi_kembali'] == null ? '-' : $item['kondisi_kembali']);
            $sheet->setCellValue('O' . $baris, $item['status']);
            $sheet->setCellValue('P' . $baris, $item['keterangan']);
            $baris++;
        }

        // Apply border style to all cells
        $styleArray = [
            'borders' => [
                    'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $sheet->getStyle('A2:P' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'P') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Generate filename with current date and time
        $currentDateTime = date('Ymd_His'); // Format: YYYYMMDD_HHMMSS
        $filename = 'Report_Jurnal_Peminjaman_Inventaris_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
