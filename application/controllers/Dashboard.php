<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

date_default_timezone_set('Asia/Jakarta');

class Dashboard extends CI_Controller
{
    public $gudang;
    public function __construct()
    {

        parent::__construct();
        $this->load->model('stok');
        $this->db->select_sum('harga');
        $query = $this->db->get('pralatan_praktek');
        $data['total'] = $query->row()->harga;
        $this->db->select_sum('harga');
        $query = $this->db->get('pralatan_kantor');
        $data['total_kantor'] = $query->row()->harga;
        $this->load->vars($data);

        // login
        if ($this->session->userdata('email')) {
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $this->session->set_userdata($data);
            $this->load->vars($data);
        } else {
            redirect('auth');
        }

        // variabel global
        $this->gudang = $this->session->userdata('id_gudang');
    }
    public function index()
    {
        $data['tittle'] = 'Dashboard';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/daftar_produk');
        $this->load->view('template/footer');
    }

    public function daftar_produk()
    {
        $this->form_validation->set_rules('kalibrasi', 'kalibrasi', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->pralatan_praktek();
        } else {
            $data['tittle'] = 'Daftar Produk';
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'keterangan' => $this->input->post('kalibrasi'), 'kategori' => 'praktik'])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang]);
            $data['total_assets'] = $query->row()->harga;


            $data['kalibrasi'] = $result->row()->total;

            $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang])->num_rows();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/daftar_produk', $data);
            $this->load->view('template/footer');
        }
    }

    public function pralatan_riksa_uji()
    {

        $this->form_validation->set_rules('kalibrasi', 'kalibrasi', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Pralatan Riksa Uji';
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'riksa'])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'riksa']);
            $data['total_assets'] = $query->row()->harga;


            $data['kalibrasi'] = $result->row()->total;
            $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'riksa'])->num_rows();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/pralatan_riksa_uji', $data);
            $this->load->view('template/footer');
        } else {
            $data['tittle'] = 'Pralatan Riksa Uji';
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'keterangan' => $this->input->post('kalibrasi'), 'kategori' => 'riksa'])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'riksa']);
            $data['total_assets'] = $query->row()->harga;


            $data['kalibrasi'] = $result->row()->total;
            $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'riksa'])->num_rows();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/pralatan_riksa_uji', $data);
            $this->load->view('template/footer');
        }
    }

    public function pralatan_praktek()
    {
        $data['tittle'] = 'Pralatan Praktik';
        $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'praktik'])->result_array();
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'praktik']);
        $data['total_assets'] = $query->row()->harga;

        // $query = "SELECT COUNT(*) as total FROM pralatan_praktek WHERE id_gudang = $this->gudang AND keterangan = 'Habis' AND kategori = 'praktik'";
        // $result = $this->db->query($query);
        // $data['kalibrasi'] = $result->row()->total;

        $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang, 'kategori' => 'praktik'])->num_rows();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/daftar_produk', $data);
        $this->load->view('template/footer');
    }



    public function opname_peralatan()
    {
        $this->form_validation->set_rules('stok[]', 'Stok', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Stok Opname';
            $selected = $this->input->post('id');
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_kantor');
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_praktek');
            $data['total_kantor'] = $query->row()->harga;
            if (isset($selected)) {
                $data['produk'] = $this->db->where_in('kode_barang', $selected)->get('pralatan_praktek')->result_array();
            } else {
                redirect('dashboard/daftar_produk');
            }
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/opname_peralatan', $data);
            $this->load->view('template/footer');
        } else {
            $id = $this->input->post('id');
            $stok = $this->input->post('stok');
            $tgl_kalibrasi = $this->input->post('tanggal_kalibrasi');
            $masa_berlaku = $this->input->post('masa_berlaku');

            foreach ($id as $key => $value) {
                $this->db->set('jumlah', $stok[$key]);
                $this->db->set('tanggal_kalibrasi', $tgl_kalibrasi[$key]);
                $this->db->set('masa_berlaku_kalibrasi', $masa_berlaku[$key]);
                $this->db->where('kode_barang', $value);
                $this->db->update('pralatan_praktek');
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function opname_peserta()
    {

        $this->form_validation->set_rules('stok[]', 'Stok', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Stok Opname';
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_kantor');
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_praktek');
            $data['total_kantor'] = $query->row()->harga;
            $selected = $this->input->post('id');
            if (isset($selected)) {
                $data['produk'] = $this->db->where_in('kode_barang', $selected)->get('perlengkapan_peserta')->result_array();
            } else {
                redirect($_SERVER['HTTP_REFERER']);
            }
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/opname_peserta', $data);
            $this->load->view('template/footer');
        } else {
            $id = $this->input->post('id');
            $stok = $this->input->post('stok');
            $nama = $this->input->post('nama');
            $lokasi = $this->input->post('lokasi_barang');
            $masuk = $this->input->post('masuk');
            $awal = $this->input->post('awal');
            $keluar = $this->input->post('keluar');

            foreach ($id as $key => $value) {
                $this->db->set('stok_awal', $stok[$key] + $masuk[$key]);


                $this->db->where('kode_barang', $value);
                $this->db->update('perlengkapan_peserta');
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
            redirect('dashboard/perlengkapan_atk');
        }
    }

    public function import()
    {
        $upload_file = $_FILES['file']['name'];
        $ektensi = pathinfo($upload_file, PATHINFO_EXTENSION);
        if ($ektensi == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($ektensi == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreedsheet    = $reader->load($_FILES['file']['tmp_name']);
        $sheetdata      = $spreedsheet->getActiveSheet()->toArray();
        $jumlahsheet    = count($sheetdata);

        if ($jumlahsheet > 1) {
            $data = array();
            for ($i = 1; $i < $jumlahsheet; $i++) {
                $kode_barang    = isset($sheetdata[$i][1]) ? $sheetdata[$i][1] : '';
                $nama_barang    = isset($sheetdata[$i][2]) ? $sheetdata[$i][2] : '';
                $jumlah         = isset($sheetdata[$i][3]) ? $sheetdata[$i][3] : '';
                $nilai_beli     = isset($sheetdata[$i][4]) ? $sheetdata[$i][4] : '';
                $tanggal_beli   = isset($sheetdata[$i][5]) ? $sheetdata[$i][5] : '';
                $lokasi_barang  = isset($sheetdata[$i][6]) ? $sheetdata[$i][6] : '';
                $keterangan     = isset($sheetdata[$i][7]) ? $sheetdata[$i][7] : '';

                if (empty($nilai_beli)) {
                    $nilai_beli = 0;
                }

                if (!empty($nama_barang) && !empty($jumlah)) {

                    $query = $this->db->get_where('pralatan_kantor', ['nama_barang' => $nama_barang]);
                    $existing_data = $query->row();

                    if (!$existing_data) {
                        $data[] = array(
                            'kode_barang'   => 'KTR-' . substr(uniqid(), -3) . $i,
                            'nama_barang'   => $nama_barang,
                            'jumlah'        => $jumlah,
                            'harga'         => $nilai_beli,
                            'tgl_beli'      => $tanggal_beli,
                            'lokasi_barang' => $lokasi_barang,
                            'keterangan'    => $keterangan,
                            'id_gudang'     => $this->gudang
                        );
                    } else {
                        continue;
                    }
                }
            }
            $this->db->insert_batch('pralatan_kantor', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Client Berhasil Di Import</div>');
            redirect('dashboard/perlengkapan_kantor');
        }
    }

    public function barang_masuk()
    {
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->barang_masukk();
        } else {
            $bulan = date('Y-m', strtotime($this->input->post('tanggal')));
            $data['tittle'] = 'Barang Masuk';
            $this->db->select('barang_masuk.id, perlengkapan_peserta.kode_barang, perlengkapan_peserta.nama_barang, barang_masuk.tanggal_masuk, barang_masuk.jumlah');
            $this->db->from('perlengkapan_peserta');
            $this->db->join('barang_masuk', 'perlengkapan_peserta.kode_barang = barang_masuk.kode_barang');
            $this->db->like('barang_masuk.tanggal_masuk', $bulan);
            $query = $this->db->get()->result_array();
            $data['produk'] = $query;
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/barang_masuk', $data);
            $this->load->view('template/footer');
        }
    }

    private function barang_masukk()
    {
        $data['tittle'] = 'Barang Masuk';
        $this->db->select('barang_masuk.id,perlengkapan_peserta.kode_barang, perlengkapan_peserta.nama_barang, barang_masuk.tanggal_masuk, barang_masuk.jumlah');
        $this->db->from('perlengkapan_peserta');
        $this->db->join('barang_masuk', 'perlengkapan_peserta.kode_barang = barang_masuk.kode_barang');
        $query = $this->db->get()->result_array();
        $data['produk'] = $query;
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/barang_masuk', $data);
        $this->load->view('template/footer');
    }

    public function import_praktek()
    {
        $upload_file = $_FILES['file']['name'];
        $ektensi = pathinfo($upload_file, PATHINFO_EXTENSION);
        if ($ektensi == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($ektensi == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }


        $spreedsheet    = $reader->load($_FILES['file']['tmp_name']);
        $sheetdata      = $spreedsheet->getActiveSheet()->toArray();
        $jumlahsheet    = count($sheetdata);

        if ($jumlahsheet > 1) {
            $data = array();
            for ($i = 1; $i < $jumlahsheet; $i++) {

                $kode_barang            = isset($sheetdata[$i][1]) ? $sheetdata[$i][1] : '';
                $nama_barang            = isset($sheetdata[$i][2]) ? $sheetdata[$i][2] : '';
                $jumlah                 = isset($sheetdata[$i][3]) ? $sheetdata[$i][3] : '';
                $harga                  = isset($sheetdata[$i][4]) ? $sheetdata[$i][4] : '';
                $tanggal_beli           = isset($sheetdata[$i][5]) ? $sheetdata[$i][5] : '';

                $tanggal_kalibrasi      = isset($sheetdata[$i][6]) ? $sheetdata[$i][6] : '';
                $masa_berlaku_kalibrasi = isset($sheetdata[$i][7]) ? $sheetdata[$i][7] : '';
                $lokasi_barang          = isset($sheetdata[$i][8]) ? $sheetdata[$i][8] : '';
                $keterangan             = isset($sheetdata[$i][9]) ? $sheetdata[$i][9] : '';
                $kategori               = isset($sheetdata[$i][10]) ? $sheetdata[$i][10] : '';

                $hasil                  = '';
                $beli                   = strtotime($tanggal_beli);
                $tanggal_beli           = date('Y-m-d', $beli);
                $kalibrasi              = strtotime($tanggal_kalibrasi);
                $tanggal_kalibrasi      = date('Y-m-d', $kalibrasi);
                $berlaku                = strtotime($masa_berlaku_kalibrasi);
                $masa_berlaku_kalibrasi = date('Y-m-d', $berlaku);

                // format tanggal

                $masa_berlaku_kalibrasi_timestamp = strtotime($masa_berlaku_kalibrasi); // konversi tanggal masa berlaku kalibrasi ke format timestamp
                if (!$masa_berlaku_kalibrasi_timestamp) {
                    $hasil = 'Invalid date'; // error handling jika tanggal tidak valid
                } else {
                    $today_timestamp = strtotime('today'); // konversi tanggal saat ini ke format timestamp
                    $hasil = ($masa_berlaku_kalibrasi_timestamp > $today_timestamp) ? 'Aktif' : 'Habis'; // bandingkan kedua tanggal dan atur nilai $keterangan
                }

                if (empty($harga)) {
                    $harga = 0;
                }

                if (!empty($nama_barang) && !empty($jumlah)) {

                    $query = $this->db->get_where('pralatan_kantor', ['nama_barang' => $nama_barang]);
                    $existing_data = $query->row();

                    if (!$existing_data) {
                        $data[] = array(
                            'kode_barang'               => 'BRG-' . substr(uniqid(), -3) . $i,
                            'nama_barang'               => $nama_barang,
                            'jumlah'                    => $jumlah,
                            'tgl_beli'                  => $tanggal_beli,
                            'harga'                     => $harga,
                            'tanggal_kalibrasi'         => $tanggal_kalibrasi,
                            'masa_berlaku_kalibrasi'    => $masa_berlaku_kalibrasi,
                            'lokasi_barang'             => $lokasi_barang,
                            'keterangan'                => $hasil,
                            'kategori'                  => $kategori,
                            'id_gudang'                 => $this->gudang
                        );
                    } else {
                        continue;
                    }
                }
            }
            $this->db->insert_batch('pralatan_praktek', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Client Berhasil Di Import</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function import_peserta()
    {
        $upload_file = $_FILES['file']['name'];
        $ektensi = pathinfo($upload_file, PATHINFO_EXTENSION);
        if ($ektensi == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($ektensi == 'xls') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreedsheet = $reader->load($_FILES['file']['tmp_name']);
        $sheetdata = $spreedsheet->getActiveSheet()->toArray();
        $jumlahsheet = count($sheetdata);

        if ($jumlahsheet > 1) {
            $data = array();
            for ($i = 1; $i < $jumlahsheet; $i++) {
                $kode_barang = isset($sheetdata[$i][1]) ? trim($sheetdata[$i][1]) : '';
                $nama_barang = isset($sheetdata[$i][2]) ? trim($sheetdata[$i][2]) : '';
                $jumlah = isset($sheetdata[$i][3]) ? trim($sheetdata[$i][3]) : '';
                $harga = isset($sheetdata[$i][4]) ? trim($sheetdata[$i][4]) : '';
                $tgl_beli = isset($sheetdata[$i][5]) ? trim($sheetdata[$i][5]) : '';
                $lokasi = isset($sheetdata[$i][6]) ? trim($sheetdata[$i][6]) : '';
                $awal = isset($sheetdata[$i][7]) ? trim($sheetdata[$i][7]) : '';
                $masuk = isset($sheetdata[$i][8]) ? trim($sheetdata[$i][8]) : '';
                $keluar = isset($sheetdata[$i][9]) ? trim($sheetdata[$i][9]) : '';
                $akhir = isset($sheetdata[$i][10]) ? trim($sheetdata[$i][10]) : '';
                $vendor = isset($sheetdata[$i][11]) ? trim($sheetdata[$i][11]) : '';
                $keterangan = isset($sheetdata[$i][12]) ? trim($sheetdata[$i][12]) : '';
                $kategori = isset($sheetdata[$i][13]) ? trim($sheetdata[$i][13]) : '';
                $beli = strtotime($tgl_beli);
                $tanggal_beli = date('Y-m-d', $beli);
                // Cek apakah baris kosong atau hanya berisi judul tabel
                // || empty($harga) || empty($tgl_beli)
                if (empty($nama_barang)) {
                    continue;
                }

                // $query = $this->db->get_where('perlengkapan_peserta', ['nama_barang' => $nama_barang]);
                // $existing_data = $query->row();
                // if(!$existing_data) {
                $data[] = array(
                    'kode_barang' => 'BRG-' . substr(uniqid(), -3) . $i,
                    'nama_barang' => $nama_barang,
                    'jumlah' => $jumlah,
                    'harga' => $harga,
                    'tgl_beli' => $tanggal_beli,
                    'lokasi' => $lokasi,
                    'stok_awal' => $awal,
                    'masuk' => $masuk,
                    'jumlah_barang_keluar' => $keluar,
                    'stok_akhir' => $akhir,
                    'vendor' => $vendor,
                    'keterangan' => ($jumlah < 1) ? 'Habis' : 'Tersedia',
                    'kategori' => $kategori,
                    'id_gudang' => $this->gudang
                );
                // }
            }

            if (!empty($data)) {
                $this->db->insert_batch('perlengkapan_peserta', $data);
                $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Client Berhasil Di Import</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Tidak ada data yang dapat diimport</div>');
            }

            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    // kantor
    public function perlengkapan_kantor()
    {
        $data['tittle'] = 'Peralatan Kantor';
        $data['produk'] = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->gudang])->result_array();
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->gudang]);
        $data['total'] = $query->row()->harga;
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang]);
        $data['total_kantor'] = $query->row()->harga;
        $data['total_alat'] = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->gudang])->num_rows();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/perlengkapan_kantor', $data);
        $this->load->view('template/footer');
    }

    public function perlengkapan_peserta()
    {
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Perlengkapan Peserta';
            $this->db->select_sum('harga');
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'peserta']);
            $data['total_assets'] = $query->row()->harga;

            $data['produk'] = $this->stok->getStok("peserta");
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'peserta'])->num_rows();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/perlengkapan_peserta', $data);
            $this->load->view('template/footer');
        } else {
            $data['tittle'] = 'Perlengkapan Peserta';
            $this->db->select_sum('harga');
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'peserta']);
            $data['total_assets'] = $query->row()->harga;
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'peserta'])->num_rows();
            $data['produk'] = $this->stok->getStokMonth($this->input->post('tanggal'), 'peserta');
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/perlengkapan_peserta', $data);
            $this->load->view('template/footer');
        }
    }

    public function perlengkapan_atk()
    {
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        if ($this->form_validation->run() == FALSE) {


            $data['tittle'] = 'Perlengkapan ATK';
            $this->db->select_sum('harga');
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'atk']);
            $data['total_assets'] = $query->row()->harga;
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'atk'])->num_rows();
            $data['produk'] = $this->stok->getStok("ATK");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/perlengkapan_atk', $data);
            $this->load->view('template/footer');
        } else {
            $data['tittle'] = 'Perlengkapan ATK';
            $this->db->select_sum('harga');
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'atk']);
            $data['total_assets'] = $query->row()->harga;
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->gudang, 'kategori' => 'atk'])->num_rows();
            $bulan = date('Y-m', strtotime($this->input->post('tanggal')));
            $data['produk'] = $this->stok->getStokMonth($bulan, "ATK");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/perlengkapan_atk', $data);
            $this->load->view('template/footer');
        }
    }

    public function cetakBulanan()
    {
        $data['produk'] = $this->stok->getStokMonth($bulan, "ATK");
    }

    public function peminjaman()
    {
        $data['tittle'] = 'Peminjaman Barang';
        // Menghitung jumlah barang yang telat
        $this->db->select_sum('detail_peminjaman.jumlah');
        $this->db->from('peminjaman');
        $this->db->join('detail_peminjaman', 'peminjaman.id = detail_peminjaman.id_peminjaman');
        $this->db->where('peminjaman.tanggal_kembali <', date('Y-m-d'));
        $this->db->where('peminjaman.status', 'sudah dikembalikan');
        $data['telat'] = $this->db->get()->row()->jumlah;

        $data['produk'] = $this->db->get_where('peminjaman')->result_array();

        $this->db->select_sum('detail_peminjaman.jumlah');
        $this->db->from('peminjaman');
        $this->db->join('detail_peminjaman', 'peminjaman.id = detail_peminjaman.id_peminjaman');
        $this->db->where('peminjaman.status', 'sudah dikembalikan');
        $data['peminjaman'] = $this->db->get()->row()->jumlah;
        $data['kembali'] = $this->db->get_where('peminjaman', ['status' => 'sudah dikembalikan'])->num_rows();
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->gudang]);
        $data['total'] = $query->row()->harga;
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang]);
        $data['total_kantor'] = $query->row()->harga;
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/peminjaman', $data);
        $this->load->view('template/footer');
    }

    public function barang_keluar()
    {
        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->barang_kuar();
        } else {
            $data['tittle'] = 'Barang Keluar';
            // Menghitung jumlah barang yang telat
            $query = "SELECT barang_keluar.id,barang_keluar.nama, barang_keluar.status, perlengkapan_peserta.nama_barang, barang_keluar.tanggal_keluar, detail_barang_keluar.jumlah 
                        FROM barang_keluar 
                        INNER JOIN detail_barang_keluar ON barang_keluar.id = detail_barang_keluar.id_user
                        INNER JOIN perlengkapan_peserta ON detail_barang_keluar.kode_barang = perlengkapan_peserta.kode_barang";
            $bulan = date('Y-m', strtotime($this->input->post('tanggal')));
            $data['produk'] = $this->db
                ->where('id_gudang', $this->gudang)
                ->like('tanggal_keluar', $bulan)
                ->order_by('tanggal_keluar', 'ASC')
                ->get('barang_keluar')
                ->result_array();

            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->gudang]);
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang]);
            $data['total_kantor'] = $query->row()->harga;

            $this->db->select_sum('jumlah');
            $this->db->from('detail_barang_keluar');
            $this->db->join('barang_keluar', 'detail_barang_keluar.id_user = barang_keluar.id');
            $this->db->where('MONTH(barang_keluar.tanggal_keluar)', date('m')); // Add condition for current month's outgoing date

            $data['peminjaman'] = $this->db->get()->row()->jumlah;

            $data['kembali'] = $this->db->get_where('peminjaman', ['status' => 'sudah dikembalikan'])->num_rows();

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/barang_keluar', $data);
            $this->load->view('template/footer');
        }
    }

    private function barang_kuar()
    {
        $data['tittle'] = 'Barang Keluar';
        // Menghitung jumlah barang yang telat
        $query = "SELECT barang_keluar.id,barang_keluar.nama, barang_keluar.status, perlengkapan_peserta.nama_barang, barang_keluar.tanggal_keluar, detail_barang_keluar.jumlah 
                        FROM barang_keluar 
                        INNER JOIN detail_barang_keluar ON barang_keluar.id = detail_barang_keluar.id_user
                        INNER JOIN perlengkapan_peserta ON detail_barang_keluar.kode_barang = perlengkapan_peserta.kode_barang";
        $data['produk'] = $this->db->order_by('tanggal_keluar', 'ASC')->get_where('barang_keluar', ['id_gudang' => $this->gudang])->result_array();

        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->gudang]);
        $data['total'] = $query->row()->harga;
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->gudang]);
        $data['total_kantor'] = $query->row()->harga;

        $this->db->select_sum('jumlah');
        $this->db->from('detail_barang_keluar');
        $this->db->join('barang_keluar', 'detail_barang_keluar.id_user = barang_keluar.id');
        $this->db->where('MONTH(barang_keluar.tanggal_keluar)', date('m')); // Add condition for current month's outgoing date

        $data['peminjaman'] = $this->db->get()->row()->jumlah;

        $data['kembali'] = $this->db->get_where('peminjaman', ['status' => 'sudah dikembalikan'])->num_rows();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/barang_keluar', $data);
        $this->load->view('template/footer');
    }

    public function tambah_peminjaman()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('pinjam', 'PINJAM', 'required');
        $this->form_validation->set_rules('kembali', 'KEMBALI', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Tambah Peminjaman';
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['jumlah >=', 1, 'id_gudang' => $this->gudang])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_kantor');
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_praktek');
            $data['total_kantor'] = $query->row()->harga;
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/tambah_peminjaman', $data);
            $this->load->view('template/footer');
        } else {

            $data = [
                'pic' => $this->input->post('nama'),
                'tanggal_pinjam' => $this->input->post('pinjam'),
                'tanggal_kembali' => $this->input->post('kembali'),
                'status' => 'Peminjaman'
            ];

            $this->db->insert('peminjaman', $data);

            $id_pinjam = $this->db->insert_id();
            $barangs = $this->input->post('barang');
            $jumlahs = $this->input->post('jumlah');
            for ($i = 0; $i < count($barangs); $i++) {
                $detail = [
                    'id_peminjaman' => $id_pinjam,
                    'kode_barang' => $barangs[$i],
                    'jumlah' => $jumlahs[$i]
                ];
                $this->db->insert('detail_peminjaman', $detail);
            }

            $kurangi_stok = $this->stok->kurangiStok();


            foreach ($kurangi_stok as $k) {
                $this->db->set('jumlah -', $k['jumlah']);
                $this->db->whare('kode_barang', $k['kode_barang']);
                $this->db->update('pralatan_praktek');
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Berhasil Di Tambahkan</div>');
            redirect('dashboard/peminjaman');
        }
    }

    public function cek_stok()
    {

        $query = $this->db->get_where('pelatan_peserta', ['id' => $this->input->post('id')])->result_array();
        echo json_encode($query);
    }

    public function tambah_barang_keluar()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Tambah Peminjaman';
            $data['produk'] = $this->db->get_where('perlengkapan_peserta', ['jumlah >' => 1])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_kantor');
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_praktek');
            $data['total_kantor'] = $query->row()->harga;
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/tambah_barang_keluar', $data);
            $this->load->view('template/footer');
        } else {

            $data = [
                'nama' => $this->input->post('nama'),
                'tanggal_keluar' => $this->input->post('pinjam'),
                'status' => 'Sukses',
                'id_gudang' => $this->gudang
            ];

            $this->db->insert('barang_keluar', $data);

            $id_pinjam = $this->db->insert_id();
            $barangs = $this->input->post('barang');
            $jumlahs = $this->input->post('jumlah');
            for ($i = 0; $i < count($barangs); $i++) {
                $detail = [
                    'id_user' => $id_pinjam,
                    'kode_barang' => $barangs[$i],
                    'jumlah' => $jumlahs[$i]
                ];

                $this->db->insert('detail_barang_keluar', $detail);
            }



            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Berhasil Di Tambahkan</div>');
            redirect('dashboard/barang_keluar');
        }
    }

    public function tambah_barang_Masuk()
    {
        $this->form_validation->set_rules('tanggal[]', 'Tanggal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Tambah Barang Masuk';
            $data['produk'] = $this->db->get_where('perlengkapan_peserta')->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_kantor');
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_praktek');
            $data['total_kantor'] = $query->row()->harga;
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/tambah_barang_masuk', $data);
            $this->load->view('template/footer');
        } else {
            $kode = $this->input->post('barang');
            $data = [];
            for ($i = 0; $i < count($kode); $i++) {
                $data[] = [
                    'kode_barang' => $kode[$i],
                    'tanggal_masuk' => $this->input->post('tanggal')[$i],
                    'jumlah' => $this->input->post('jumlah')[$i]
                ];

                $this->db->set('masuk', 'masuk + ' . $this->input->post('jumlah')[$i], FALSE);
                $this->db->set('jumlah', 'jumlah + ' . $this->input->post('jumlah')[$i], FALSE);
                $this->db->where('kode_barang', $kode[$i]);
                $this->db->update('perlengkapan_peserta');
            }


            $this->db->insert_batch('barang_masuk', $data);

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Berhasil Di Tambahkan</div>');
            redirect('dashboard/barang_masuk');
        }
    }

    public function get_produk()
    {
        $produk = $this->db->get('perlengkapan_peserta')->result_array();
        echo json_encode($produk);
    }

    public function detail_peminjaman($id)
    {
        $this->db->select('perlengkapan_peserta.nama_barang, detail_peminjaman.jumlah');
        $this->db->from('detail_peminjaman');
        $this->db->join('perlengkapan_peserta', 'detail_peminjaman.kode_barang = perlengkapan_peserta.kode_barang');
        $this->db->where('detail_peminjaman.id_peminjaman', $id);
        $data['detail_peminjaman'] = $this->db->get()->result_array();
        $data['nama'] = $this->db->get_where('peminjaman')->row_array();
        $data['tittle'] = 'Detail Peminjaman';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/detail_peminjaman', $data);
        $this->load->view('template/footer');
    }

    public function detail_keluar($id)
    {
        $this->db->select('perlengkapan_peserta.nama_barang, detail_barang_keluar.jumlah');
        $this->db->from('detail_barang_keluar');
        $this->db->join('perlengkapan_peserta', 'detail_barang_keluar.kode_barang = perlengkapan_peserta.kode_barang', 'inner');
        $this->db->where('detail_barang_keluar.id_user', $id);
        $data['detail_peminjaman'] = $this->db->get()->result_array();

        $data['nama'] = $this->db->get_where('barang_keluar', ['id' => $id])->row_array();
        $data['tittle'] = 'Detail Barang Keluar';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/detail_peminjaman', $data);
        $this->load->view('template/footer');
    }

    public function hapus_praktek()
    {
        $id = $this->input->post('id');
        foreach ($id as $i) {
            $data = [
                'kode_barang' => $i
            ];

            $this->db->delete('pralatan_praktek', $data);
        }
        echo 'sukses';
    }

    public function hapus_barang_masuk()
    {
        $id = $this->input->post('id');
        foreach ($id as $i) {
            $hapus = $this->db->get_where('barang_masuk', ['id' => $i])->row();

            // Mengupdate data pada tabel "perlengkapan_peserta"
            $this->db->set('masuk', 'masuk - ' . $hapus->jumlah, FALSE);
            $this->db->set('jumlah', 'jumlah - ' . $hapus->jumlah, FALSE);
            $this->db->where('kode_barang', $hapus->kode_barang);
            $this->db->update('perlengkapan_peserta');

            // Menghapus data dari tabel "barang_masuk"
            $this->db->delete('barang_masuk', ['id' => $i]);
        }
        echo 'sukses';
    }


    public function hapus_barang_keluar()
    {
        $id = $this->input->post('id');
        foreach ($id as $i) {
            $hapus = $this->db->get_where('detail_barang_keluar', ['id_user' => $i])->row();

            // Mengupdate data pada tabel "perlengkapan_peserta"
            $this->db->set('jumlah_barang_keluar', 'jumlah_barang_keluar - ' . $hapus->jumlah, FALSE);
            $this->db->set('jumlah', 'jumlah + ' . $hapus->jumlah, FALSE);
            $this->db->where('kode_barang', $hapus->kode_barang);
            $this->db->update('perlengkapan_peserta');

            // Menghapus data dari tabel "barang_keluar"
            $this->db->delete('barang_keluar', ['id' => $i]);
        }
        echo json_encode($hapus);
    }


    public function hapus_pinjaman()
    {
        $id = $this->input->post('id');

        foreach ($id as $i) {
            // $data = $this->db->get_where('detail_peminjaman',['id_peminjaman' => $i])->row();

            // $this->db->set('jumlah', 'jumlah +' . $data->jumlah, FALSE);
            // $this->db->where('kode_barang', $data->kode_barang);
            // $this->db->update('pralatan_praktek');      

            // menghapus
            $this->db->delete('peminjaman', ['id' => $i]);
        }
        echo 'sukses';
    }

    public function hapus_kantor()
    {
        $id = $this->input->post('id');
        foreach ($id as $i) {
            $data = [
                'kode_barang' => $i
            ];
            $this->db->where('id_gudang', $this->gudang);
            $this->db->delete('pralatan_kantor', $data);
        }
        echo 'sukses';
    }

    public function hapus_peserta()
    {
        $id = $this->input->post('id');
        foreach ($id as $i) {
            $data = [
                'kode_barang' => $i
            ];

            $this->db->delete('perlengkapan_peserta', $data);
        }
        echo 'sukses';
    }

    public function opname_kantor()
    {
        $this->form_validation->set_rules('stok[]', 'Stok', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['tittle'] = 'Stok Opname';
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_kantor');
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get('pralatan_praktek');
            $data['total_kantor'] = $query->row()->harga;
            $selected = $this->input->post('id');
            if (isset($selected)) {
                $data['produk'] = $this->db->where_in('kode_barang', $selected)->get('pralatan_kantor')->result_array();
            } else {
                redirect('dashboard/perlengkapan_kantor');
            }
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/opname_kantor', $data);
            $this->load->view('template/footer');
        } else {
            $id = $this->input->post('id');
            $stok = $this->input->post('stok');
            $nama = $this->input->post('nama');
            $lokasi = $this->input->post('lokasi_barang');

            foreach ($id as $key => $value) {
                $this->db->set('jumlah', $stok[$key]);
                $this->db->set('nama_barang', $nama[$key]);
                $this->db->set('lokasi_barang', $lokasi[$key]);
                $this->db->where('kode_barang', $value);
                $this->db->update('pralatan_kantor');
            }

            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data berhasil diperbarui.</div>');
            redirect('dashboard/perlengkapan_kantor');
        }
    }

    public function edit()
    {
        $id = $this->input->post('id');

        $this->db->set('status', 'sudah dikembalikan');
        $this->db->where('id', $id);
        $this->db->update('peminjaman');

        $this->kurang_pinjam($id);
    }

    public function kurang_pinjam($id)
    {

        $user = $this->db->get_where('detail_peminjaman', ['id_peminjaman' => $id])->result_array();

        foreach ($user as $a) {
            $this->db->set('jumlah', 'jumlah + ' . $a['jumlah'], FALSE); // Gunakan FALSE untuk menghindari escapting dari CI
            $this->db->where('kode_barang', $a['kode_barang']);
            $this->db->update('pralatan_praktek');
        }
    }


    public function download_excel()
    {

        $spreadsheet = new Spreadsheet();

        // Add worksheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Perlengkapan Daftar' . $this->input->get('kategori'));



        // Set headers
        $sheet->setCellValue('A1', 'Kode Barang');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Stok Awal');
        $sheet->setCellValue('D1', 'Barang Masuk');
        $sheet->setCellValue('E1', 'Barang Keluar');
        $sheet->setCellValue('F1', 'Stok Akhir');


        // Get data from database
        $bulan = $this->input->get('tanggal');
        if (empty($bulan)) {
            $data = $this->stok->getStok($this->input->get('kategori'));
        } else {
            $data = $this->stok->getStokMonth($bulan, $this->input->get('kategori'));
        }

        // Loop through data and add to spreadsheet
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, strtoupper($item['kode_barang']));
            $sheet->setCellValue('B' . $row, $item['nama_barang']);
            $sheet->setCellValue('C' . $row, $item['stok_awal']);
            $sheet->setCellValue('D' . $row, $item['masuk']);
            $sheet->setCellValue('E' . $row, $item['keluar']);
            $sheet->setCellValue('F' . $row, $item['stok_awal'] + $item['masuk'] - $item['keluar']);



            $row++;
        }

        // Create file name
        $filename = 'perlengkapan_Data_' . date('Ymd_His') . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Create writer object and save spreadsheet as file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    public function rekap_bulanan()
    {
        $spreadsheet = new Spreadsheet();

        // Add worksheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Perlengkapan Daftar' . $this->input->get('waktu'));



        // Set headers
        $sheet->setCellValue('A1', 'Kode Barang');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Stok Awal');
        $sheet->setCellValue('D1', 'Barang Masuk');
        $sheet->setCellValue('E1', 'Barang Keluar');
        $sheet->setCellValue('F1', 'Stok Akhir');


        // Get data from database
        $bulan = date('Y-m', strtotime($this->input->get('waktu')));
        $ket = $this->input->get('kat');
        $data = $this->stok->getStokMonth($bulan, $ket);


        // Loop through data and add to spreadsheet
        $row = 2;
        foreach ($data as $item) {
            $sheet->setCellValue('A' . $row, strtoupper($item['kode_barang']));
            $sheet->setCellValue('B' . $row, $item['nama_barang']);
            $sheet->setCellValue('C' . $row, $item['stok_awal']);
            $sheet->setCellValue('D' . $row, $item['masuk']);
            $sheet->setCellValue('E' . $row, $item['keluar']);
            $sheet->setCellValue('F' . $row, $item['stok_awal'] + $item['masuk'] - $item['keluar']);



            $row++;
        }

        // Create file name
        $filename = 'perlengkapan_Data_' . date('Ymd_His') . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Create writer object and save spreadsheet as file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    public function download_barang_keluar()
    {
        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set the column headers
        $sheet->setCellValue('A1', 'Tanggal Keluar');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Jumlah');
        $sheet->setCellValue('E1', 'Nama');

        // Fetch the query results
        $currentMonth = date('m');
        $currentYear = date('Y');

        // Query untuk mencari data berdasarkan bulan saat ini
        $this->db->select('barang_keluar.tanggal_keluar, detail_barang_keluar.kode_barang, barang_keluar.nama, detail_barang_keluar.jumlah, perlengkapan_peserta.nama_barang');
        $this->db->from('barang_keluar');
        $this->db->join('detail_barang_keluar', 'barang_keluar.id = detail_barang_keluar.id_user');
        $this->db->join('perlengkapan_peserta', 'detail_barang_keluar.kode_barang = perlengkapan_peserta.kode_barang');
        $this->db->where('MONTH(barang_keluar.tanggal_keluar)', $currentMonth);
        $this->db->where('YEAR(barang_keluar.tanggal_keluar)', $currentYear);
        $this->db->order_by('barang_keluar.tanggal_keluar', 'desc');
        $query = $this->db->get();

        $results = $query->result();

        // Fill the Excel sheet with query results
        $row = 2;
        foreach ($results as $result) {
            $sheet->setCellValue('A' . $row, $result->tanggal_keluar);
            $sheet->setCellValue('B' . $row, strtoupper($result->kode_barang));
            $sheet->setCellValue('C' . $row, $result->nama_barang);
            $sheet->setCellValue('D' . $row, $result->jumlah);
            $sheet->setCellValue('E' . $row, $result->nama);
            $row++;
        }

        // Create a new Excel file and save it
        $writer = new Xlsx($spreadsheet);
        $filename = 'barang_keluar_' . date('M') . '.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit();
    }

    public function kurangi_stok($id, $url)
    {


        $detail_peminjaman;
        if ($url === 'barang_keluar') {
            $this->db->select('kode_barang, jumlah');
            $this->db->where('id_user', $id);
            $query = $this->db->get('detail_barang_keluar');
            $detail_peminjaman = $query->result();
        } else {
            $this->db->select('kode_barang, jumlah');
            $this->db->where('id_peminjaman', $id);
            $query = $this->db->get('detail_peminjaman');
            $detail_peminjaman = $query->result();
        }

        // Kurangi jumlah stok barang di tabel 'barang'
        foreach ($detail_peminjaman as $detail) {
            $this->db->set('jumlah', 'jumlah - ' . $detail->jumlah, FALSE);
            $this->db->set('jumlah_barang_keluar', 'jumlah_barang_keluar + ' . $detail->jumlah, FALSE);
            $this->db->where('kode_barang', $detail->kode_barang);
            $this->db->update('perlengkapan_peserta');
        }
        if ($url === 'barang_keluar') {
            $this->db->set('status', 'Sukses');
            $this->db->where('id', $id);
            $this->db->update('barang_keluar');
        } else {
            $this->db->set('konfirmasi', 'Sukses');
            $this->db->where('id', $id);
            $this->db->update('peminjaman');
        }

        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data di Konfirmasi 😁</div>');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function batal($id)
    {
        $this->db->delete('barang_keluar', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Berhasil di Batalkan 👌</div>');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function reset()
    {
        $data = array(
            'jumlah_barang_keluar' => 0,
        );
        $this->db->where('gudang', $this->gudang);
        $this->db->update('perlengkapan_peserta', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Berhasil di Reset 👌</div>');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function cetak_laporan($data)
    {

        $spreadsheet = new Spreadsheet();
        // Add worksheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Perlengkapan Daftar' . $this->input->get('Kategori'));

        // Set headers
        $sheet->setCellValue('A1', 'Nomor');
        $sheet->setCellValue('B1', 'Nama Barang');
        $sheet->setCellValue('C1', 'Barang Masuk');
        $sheet->setCellValue('D1', 'Barang Keluar');
        $sheet->setCellValue('E1', 'Stok Akhir');

        $tanggal = $this->input->post('tanggal');
        $bulan = date_format(date_create($tanggal), "m");
        $tahun = date_format(date_create($tanggal), "Y");


        // $query = $this->db->get_where('laporan_stok', ['kategori' => $data, 'data_created' => $bulan])->result_array();


        $this->db->select('
            perlengkapan_peserta.kode_barang,
            perlengkapan_peserta.nama_barang,
            perlengkapan_peserta.jumlah,
            SUM(CASE WHEN MONTH(barang_masuk.tanggal_masuk) = ' . $bulan . ' AND YEAR(barang_masuk.tanggal_masuk) = ' . $tahun . ' THEN barang_masuk.jumlah ELSE 0 END) AS jumlah_masuk,
            SUM(CASE WHEN MONTH(barang_keluar.tanggal_keluar) = ' . $bulan . ' AND YEAR(barang_keluar.tanggal_keluar) = ' . $tahun . ' THEN detail_barang_keluar.jumlah ELSE 0 END) AS jumlah_keluar
        ')
            ->from('perlengkapan_peserta')
            ->join('barang_masuk', 'perlengkapan_peserta.kode_barang = barang_masuk.kode_barang', 'left')
            ->join('detail_barang_keluar', 'perlengkapan_peserta.kode_barang = detail_barang_keluar.kode_barang', 'left')
            ->join('barang_keluar', 'detail_barang_keluar.id_user = barang_keluar.id', 'left')
            ->where('perlengkapan_peserta.kategori', 'ATK')
            ->group_by('perlengkapan_peserta.kode_barang');




        $query = $this->db->get()->result_array();



        // Loop through data and add to spreadsheet
        $row = 2;
        $no = 1;
        foreach ($query as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item['nama_barang']);
            $sheet->setCellValue('C' . $row, $item['jumlah_masuk']);
            $sheet->setCellValue('D' . $row, $item['jumlah_keluar']);
            $sheet->setCellValue('E' . $row, $item['jumlah_masuk'] - $item['jumlah_keluar']);

            $row++;
        }

        // Create file name
        $filename = 'Laporan_inventori' . $bulan . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Create writer object and save spreadsheet as file
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        exit();
    }

    public function stok()
    {
        $this->db->select('id,data_created,nama_barang, SUM(jumlah_masuk) AS masuk, SUM(jumlah_keluar) AS keluar,
        (SUM(jumlah_masuk) - SUM(jumlah_keluar)) AS stok', false);
        $this->db->from('laporan_stok');
        $this->db->group_by('nama_barang');

        $query = $this->db->get()->result_array();

        return $query;
    }

    public function laporan_stok()
    {
        $data['tittle'] = 'Laporan Stok';

        $data['produk'] = $this->stok();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/laporan_stok', $data);
        $this->load->view('template/footer');
    }

    public function daftar_laptop()
    {
        echo 'Stok Belum di Update';
    }

    public function tambahProduk()
    {
        $data = [
            'kode_barang' => 'BRG-' . substr(uniqid(), -4),
            'nama_barang' => $this->input->post('produk'),
            'jumlah' => $this->input->post('jumlah') * $this->input->post('satuan'),
            'harga' => 0,
            'lokasi' => "",
            'stok_awal' => "",
            'masuk' => "",
            'jumlah_barang_keluar' => "",
            'stok_akhir' => "",
            'kategori' => $this->input->post('kategori'),
            'id_gudang' => $this->gudang
        ];

        $this->db->insert('perlengkapan_peserta', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Berhasil di tambahkan 👌</div>');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function editProduk()
    {
        $this->db->set('nama_barang', $this->input->post('barang'));
        $this->db->where('kode_barang', $this->input->post('id'));
        $this->db->update('perlengkapan_peserta');
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Berhasil di Ubah 👌</div>');
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function list_admin()
    {
        $data['tittle'] = 'List Admin';
        // $data['user'] = $this->db->get('user')->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('auth/list_admin', $data);
        $this->load->view('template/footer');
    }
}
