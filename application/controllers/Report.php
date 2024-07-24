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
        $this->db->select('jurnal_barang_masuk.id,jurnal_barang_masuk.kode_barang_masuk,master_barang.nama_barang,master_kategori.nama_kategori,master_lokasi.nama_lokasi,master_kantor.nama_kantor,master_merek.nama_merek,jurnal_barang_masuk.tanggal_masuk,jurnal_barang_masuk.jenis_pakai,jurnal_barang_masuk.status_barang, jurnal_barang_masuk.jumlah_masuk,master_satuan.nama_satuan, jurnal_barang_masuk.keterangan, jurnal_barang_masuk.harga_barang, jurnal_barang_masuk.total');
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
        $this->db->select('jurnal_inventaris.id,
                            jurnal_inventaris.kode_inventaris,
                            jurnal_barang.kode_barang,
                            master_barang.nama_barang,
                            master_satuan.nama_satuan,
                            master_merek.nama_merek,
                            jurnal_barang_masuk.keterangan as spesifikasi,
                            jurnal_barang_masuk.tanggal_masuk,
                            master_karyawan.nama_karyawan,
                            master_divisi.nama_divisi,
                            jurnal_inventaris.tanggal_assign,
                            jurnal_inventaris.jumlah_assets,
                            jurnal_inventaris.keterangan,
                            jurnal_inventaris.tanggal_return');
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
}
