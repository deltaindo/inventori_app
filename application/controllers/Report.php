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

    public function report_jurnal_masuk_barang()
    {
        $this->db->select('jurnal_barang_masuk.id,jurnal_barang_masuk.kode_barang_masuk,master_barang.nama_barang,master_kategori.nama_kategori,master_lokasi.nama_lokasi,master_kantor.nama_kantor,master_merek.nama_merek,jurnal_barang_masuk.tanggal_masuk,jurnal_barang_masuk.jenis_pakai,jurnal_barang_masuk.status_barang, jurnal_barang_masuk.jumlah_masuk,master_satuan.nama_satuan, jurnal_barang.keterangan, jurnal_barang_masuk.harga_barang, jurnal_barang_masuk.total');
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
        $sheet->mergeCells('A1:N1');
        $sheet->setCellValue('A1', 'Report Jurnal Barang Masuk');
        $sheet->getStyle('A1:N1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:N1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

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

        // Apply bold style and background color to header
        $sheet->getStyle('A2:N2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:N2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:N2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

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
            $sheet->getStyle('M' . $baris)->getNumberFormat()->setFormatCode('Rp #,##0.00');
            $sheet->setCellValue('N' . $baris, $item['total']);
            $sheet->getStyle('N' . $baris)->getNumberFormat()->setFormatCode('Rp #,##0.00');
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
        $sheet->getStyle('A2:N' . ($baris - 1))->applyFromArray($styleArray);

        // Set auto size for all columns
        foreach (range('A', 'N') as $columnID) {
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
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'Report Jurnal Stok Barang');
        $sheet->getStyle('A1:K1')->getFont()->setBold(true)->setSize(15);
        $sheet->getStyle('A1:K1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Set header
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Kode Barang');
        $sheet->setCellValue('C2', 'Nama Barang');
        $sheet->setCellValue('D2', 'Merek');
        $sheet->setCellValue('E2', 'Lokasi');
        $sheet->setCellValue('F2', 'Kantor');
        $sheet->setCellValue('G2', 'Spesifikasi');
        $sheet->setCellValue('H2', 'Jumlah Masuk');
        $sheet->setCellValue('I2', 'Jumlah Keluar');
        $sheet->setCellValue('J2', 'Stok Akhir');
        $sheet->setCellValue('K2', 'Tanggal Update');

        // Apply bold style and background color to header
        $sheet->getStyle('A2:K2')->getFont()->setBold(true)->setSize(12);;
        $sheet->getStyle('A2:K2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:K2')->getFill()->getStartColor()->setARGB('FFB0B0B0'); // Warna abu-abu

        // Populate data
        $baris = 3;
        $no = 1;
        foreach ($data['jurnal_stok'] as $item) {
            $sheet->setCellValue('A' . $baris, $no++);
            $sheet->setCellValue('B' . $baris, $item['kode_barang']);
            $sheet->setCellValue('C' . $baris, $item['nama_barang']);
            $sheet->setCellValue('D' . $baris, $item['nama_merek']);
            $sheet->setCellValue('E' . $baris, $item['nama_lokasi']);
            $sheet->setCellValue('F' . $baris, $item['nama_kantor']);
            $sheet->setCellValue('G' . $baris, $item['keterangan']);
            $sheet->setCellValue('H' . $baris, $item['jumlah_masuk'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('I' . $baris, $item['jumlah_keluar'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('J' . $baris, $item['stok_akhir'] . ' ' . $item['nama_satuan']);
            $sheet->setCellValue('K' . $baris, $item['tanggal_update']);
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
        $filename = 'Report_Jurnal_Stok_Barang_' . $currentDateTime . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

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
        $this->db->where('jurnal_barang_masuk.jenis_pakai', 'Inventaris');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
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
}
