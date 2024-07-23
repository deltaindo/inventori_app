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
        $this->kantor           = $this->session->userdata('id_kantor');
        $this->nama_kantor      = $this->db->get_where('master_kantor', ['id' => $this->kantor])->row()->nama_kantor;
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
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'keterangan' => $this->input->post('kalibrasi'), 'kategori' => 'praktik'])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor]);
            $data['total_assets'] = $query->row()->harga;


            $data['kalibrasi'] = $result->row()->total;

            $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor])->num_rows();
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
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'riksa'])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'riksa']);
            $data['total_assets'] = $query->row()->harga;


            $data['kalibrasi'] = $result->row()->total;
            $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'riksa'])->num_rows();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/pralatan_riksa_uji', $data);
            $this->load->view('template/footer');
        } else {
            $data['tittle'] = 'Pralatan Riksa Uji';
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'keterangan' => $this->input->post('kalibrasi'), 'kategori' => 'riksa'])->result_array();
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'riksa']);
            $data['total_assets'] = $query->row()->harga;


            $data['kalibrasi'] = $result->row()->total;
            $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'riksa'])->num_rows();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/pralatan_riksa_uji', $data);
            $this->load->view('template/footer');
        }
    }

    public function pralatan_praktek()
    {
        $data['tittle'] = 'Pralatan Praktik';
        $data['produk'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'praktik'])->result_array();
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'praktik']);
        $data['total_assets'] = $query->row()->harga;

        // $query = "SELECT COUNT(*) as total FROM pralatan_praktek WHERE id_gudang = $this->kantor AND keterangan = 'Habis' AND kategori = 'praktik'";
        // $result = $this->db->query($query);
        // $data['kalibrasi'] = $result->row()->total;

        $data['total_alat'] = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor, 'kategori' => 'praktik'])->num_rows();
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
                            'id_gudang'     => $this->kantor
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
                            'id_gudang'                 => $this->kantor
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
                    'id_gudang' => $this->kantor
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
        $data['produk'] = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->kantor])->result_array();
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->kantor]);
        $data['total'] = $query->row()->harga;
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor]);
        $data['total_kantor'] = $query->row()->harga;
        $data['total_alat'] = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->kantor])->num_rows();
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
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'peserta']);
            $data['total_assets'] = $query->row()->harga;

            $data['produk'] = $this->stok->getStok("peserta");
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'peserta'])->num_rows();
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/perlengkapan_peserta', $data);
            $this->load->view('template/footer');
        } else {
            $data['tittle'] = 'Perlengkapan Peserta';
            $this->db->select_sum('harga');
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'peserta']);
            $data['total_assets'] = $query->row()->harga;
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'peserta'])->num_rows();
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
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'atk']);
            $data['total_assets'] = $query->row()->harga;
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'atk'])->num_rows();
            $data['produk'] = $this->stok->getStok("ATK");
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar');
            $this->load->view('dashboard/perlengkapan_atk', $data);
            $this->load->view('template/footer');
        } else {
            $data['tittle'] = 'Perlengkapan ATK';
            $this->db->select_sum('harga');
            $query = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'atk']);
            $data['total_assets'] = $query->row()->harga;
            $data['total_alat'] = $this->db->get_where('perlengkapan_peserta', ['id_gudang' => $this->kantor, 'kategori' => 'atk'])->num_rows();
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
        $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->kantor]);
        $data['total'] = $query->row()->harga;
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor]);
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
                ->where('id_gudang', $this->kantor)
                ->like('tanggal_keluar', $bulan)
                ->order_by('tanggal_keluar', 'ASC')
                ->get('barang_keluar')
                ->result_array();

            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->kantor]);
            $data['total'] = $query->row()->harga;
            $this->db->select_sum('harga');
            $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor]);
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
        $data['produk'] = $this->db->order_by('tanggal_keluar', 'ASC')->get_where('barang_keluar', ['id_gudang' => $this->kantor])->result_array();

        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_kantor', ['id_gudang' => $this->kantor]);
        $data['total'] = $query->row()->harga;
        $this->db->select_sum('harga');
        $query = $this->db->get_where('pralatan_praktek', ['id_gudang' => $this->kantor]);
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
            $data['produk'] = $this->db->get_where('pralatan_praktek', ['jumlah >=', 1, 'id_gudang' => $this->kantor])->result_array();
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
                'id_gudang' => $this->kantor
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
            $this->db->where('id_gudang', $this->kantor);
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
        $this->db->where('gudang', $this->kantor);
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
            'id_gudang' => $this->kantor
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

    public function admin()
    {
        $data['tittle'] = 'List Data Admin | Inventori App';

        $this->db->select('user.id, user.Nama, user.email, master_kantor.nama_kantor');
        $this->db->from('user');
        $this->db->join('master_kantor', 'user.id_kantor = master_kantor.id');
        $this->db->where('user.id_kantor', $this->kantor);
        $this->db->order_by('user.id', 'DESC');
        $data['admins'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('auth/admin/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_admin()
    {
        $data['tittle'] = 'Tambah Data Admin | Inventori App';
        $data["kantor"] = $this->db->where('id', $this->kantor)
            ->get('master_kantor')
            ->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('auth/admin/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_admin()
    {
        $data = [
            'id_kantor'     => $this->input->post('id_kantor'),
            'Nama'          => $this->input->post('nama_admin'),
            'email'         => $this->input->post('email_admin'),
            'password'      => md5($this->input->post('password_admin')),
            'image'         => 'https://i.pravatar.cc/150?img=33'
        ];

        $this->db->insert('user', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Admin Berhasil di tambahkan</div>');
        redirect('dashboard/admin');
    }

    public function edit_admin($id)
    {
        $data['tittle'] = 'Edit Data Admin | Inventori App';
        $data["kantor"] = $this->db->get('master_kantor')->result_array();
        $data['admin']  = $this->db->get_where('user', ['id' => $id])->row_array();
        $data['kantor'] = $this->db->get('master_kantor')->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('auth/admin/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_admin($id)
    {
        if ($this->input->post('password_admin') == null) {
            $data = [
                'id_kantor'     => $this->input->post('id_kantor'),
                'Nama'          => $this->input->post('nama_admin'),
                'email'         => $this->input->post('email_admin'),
            ];
        } else {
            $data = [
                'id_kantor'     => $this->input->post('id_kantor'),
                'Nama'          => $this->input->post('nama_admin'),
                'email'         => $this->input->post('email_admin'),
                'password'      => md5($this->input->post('password_admin')),
            ];
        }
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Admin Berhasil di Update</div>');
        redirect('dashboard/admin');
    }

    public function delete_admin($id)
    {
        $this->db->delete('user', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Admin Berhasil di Hapus</div>');
        redirect('dashboard/admin');
    }

    public function hapus_bulk_admin()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('user', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Daftar Admin Berhasil di Hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Daftar Admin yang dipilih untuk dihapus</div>');
        }
        redirect('dashboard/admin');
    }

    public function master_kantor()
    {
        $data['tittle'] = 'List Data Kantor | Inventori App';

        $this->db->order_by('id', 'DESC');
        $data['kantor'] = $this->db->where('id', $this->kantor)
            ->get('master_kantor')
            ->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/kantor/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_kantor()
    {
        $data['tittle'] = 'Tambah Data Kantor | Inventori App';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/kantor/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_kantor()
    {
        $data = [
            'nama_kantor'   => $this->input->post('nama_kantor'),
            'keterangan'    => $this->input->post('keterangan_kantor')
        ];
        $this->db->insert('master_kantor', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Kantor Berhasil di tambahkan</div>');
        redirect('dashboard/master_kantor');
    }

    public function edit_kantor($id)
    {
        $data['tittle'] = 'Edit Data Kantor | Inventori App';
        $data['kantor'] = $this->db->get_where('master_kantor', ['id' => $id])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/kantor/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_kantor($id)
    {
        $data = [
            'nama_kantor'   => $this->input->post('nama_kantor'),
            'keterangan'    => $this->input->post('keterangan_kantor')
        ];
        $this->db->where('id', $id);
        $this->db->update('master_kantor', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Kantor Berhasil di ubah</div>');
        redirect('dashboard/master_kantor');
    }

    public function delete_office($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('master_kantor');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Kantor Berhasil di hapus</div>');
        redirect('dashboard/master_kantor');
    }

    public function hapus_bulk_kantor()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('master_kantor', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Daftar Kantor Berhasil di Hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Daftar Kantor yang dipilih untuk dihapus</div>');
        }
        redirect('dashboard/master_kantor');
    }

    public function master_lokasi()
    {
        $data['tittle'] = 'List Data Lokasi | Inventori App';

        $this->db->select('master_lokasi.id, master_kantor.nama_kantor, master_lokasi.nama_lokasi, master_lokasi.keterangan');
        $this->db->from('master_lokasi');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->order_by('master_lokasi.id', 'DESC');
        $data['lokasi'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/lokasi/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_lokasi()
    {
        $data['tittle'] = 'List Data Lokasi | Inventori App';
        $data['kantor'] = $this->db->get('master_kantor')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/lokasi/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_lokasi()
    {
        $data = [
            'id_kantor'     => $this->input->post('id_kantor'),
            'nama_lokasi'   => $this->input->post('nama_lokasi'),
            'keterangan'    => $this->input->post('keterangan_lokasi')
        ];
        $this->db->insert('master_lokasi', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Lokasi Berhasil di tambahkan</div>');
        redirect('dashboard/master_lokasi');
    }

    public function edit_lokasi($id)
    {
        $data['tittle'] = 'Edit Data Lokasi | Inventori App';
        $data['kantor'] = $this->db->get('master_kantor')->result_array();
        $data['lokasi'] = $this->db->get_where('master_lokasi', ['id' => $id])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/lokasi/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_lokasi($id)
    {
        $data = [
            'id_kantor'     => $this->input->post('id_kantor'),
            'nama_lokasi'   => $this->input->post('nama_lokasi'),
            'keterangan'    => $this->input->post('keterangan_lokasi')
        ];
        $this->db->where('id', $id);
        $this->db->update('master_lokasi', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Lokasi Berhasil di ubah</div>');
        redirect('dashboard/master_lokasi');
    }

    public function delete_lokasi($id)
    {
        $this->db->delete('master_lokasi', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Lokasi Berhasil di hapus</div>');
        redirect('dashboard/master_lokasi');
    }

    public function delete_bulk_lokasi()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('master_lokasi', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Daftar Lokasi Berhasil di Hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Daftar Lokasi yang dipilih untuk dihapus</div>');
        }
        redirect('dashboard/master_lokasi');
    }

    public function master_satuan()
    {
        $data['tittle'] = 'List Data Satuan | Inventori App';

        $this->db->order_by('id', 'DESC');
        $data['satuan'] = $this->db->get('master_satuan')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/satuan/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_satuan()
    {
        $data['tittle'] = 'Tambah Data Satuan | Inventori App';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/satuan/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_satuan()
    {
        $data = [
            'nama_satuan'   => $this->input->post('nama_satuan'),
            'keterangan'    => $this->input->post('keterangan_satuan')
        ];
        $this->db->insert('master_satuan', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Satuan Berhasil di tambahkan</div>');
        redirect('dashboard/master_satuan');
    }

    public function edit_satuan($id)
    {
        $data['tittle'] = 'Edit Data Satuan | Inventori App';
        $data['satuan'] = $this->db->get_where('master_satuan', ['id' => $id])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/satuan/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_satuan($id)
    {
        $data = [
            'nama_satuan'   => $this->input->post('nama_satuan'),
            'keterangan'    => $this->input->post('keterangan_satuan')
        ];
        $this->db->where('id', $id);
        $this->db->update('master_satuan', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Satuan Berhasil di ubah</div>');
        redirect('dashboard/master_satuan');
    }

    public function delete_satuan($id)
    {
        $this->db->delete('master_satuan', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Satuan Berhasil di hapus</div>');
        redirect('dashboard/master_satuan');
    }

    public function delete_bulk_satuan()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('master_satuan', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Daftar Satuan Berhasil di Hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Daftar Satuan yang dipilih untuk dihapus</div>');
        }
        redirect('dashboard/master_satuan');
    }

    public function master_merek()
    {
        $data['tittle'] = 'List Data Merek | Inventori App';

        $this->db->order_by('id', 'DESC');
        $data['merek'] = $this->db->get('master_merek')->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/merek/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_merek()
    {
        $data['tittle'] = 'List Data Merek | Inventori App';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/merek/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_merek()
    {
        $data = [
            'nama_merek'   => $this->input->post('nama_merek'),
            'keterangan'    => $this->input->post('keterangan_merek')
        ];
        $this->db->insert('master_merek', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Merek Berhasil di tambahkan</div>');
        redirect('dashboard/master_merek');
    }

    public function edit_merek($id)
    {
        $data['tittle'] = 'Edit Data Merek | Inventori App';
        $data['merek'] = $this->db->get_where('master_merek', ['id' => $id])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/merek/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_merek($id)
    {
        $data = [
            'nama_merek'   => $this->input->post('nama_merek'),
            'keterangan'    => $this->input->post('keterangan_merek')
        ];
        $this->db->where('id', $id);
        $this->db->update('master_merek', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Merek Berhasil di ubah</div>');
        redirect('dashboard/master_merek');
    }

    public function delete_merek($id)
    {
        $this->db->delete('master_merek', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Merek Berhasil di hapus</div>');
        redirect('dashboard/master_merek');
    }

    public function hapus_bulk_merek()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('master_merek', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Daftar Merek Berhasil di Hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Daftar Merek yang dipilih untuk dihapus</div>');
        }
        redirect('dashboard/master_merek');
    }

    public function master_kategori()
    {
        $data['tittle'] = 'List Data Kategori | Inventori App';
        $this->db->order_by('id', 'DESC');
        $data['kategori'] = $this->db->get('master_kategori')->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/kategori/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_kategori()
    {
        $data['tittle'] = 'Tambah Data Kategori | Inventori App';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/kategori/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_kategori()
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori'),
            'keterangan'    => $this->input->post('keterangan_kategori')
        ];
        $this->db->insert('master_kategori', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Kategori Berhasil di tambahkan</div>');
        redirect('dashboard/master_kategori');
    }

    public function edit_kategori($id)
    {
        $data['tittle'] = 'Edit Data Kategori | Inventori App';
        $data['kategori'] = $this->db->get_where('master_kategori', ['id' => $id])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/kategori/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_kategori($id)
    {
        $data = [
            'nama_kategori' => $this->input->post('nama_kategori'),
            'keterangan'    => $this->input->post('keterangan_kategori')
        ];
        $this->db->where('id', $id);
        $this->db->update('master_kategori', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Kategori Berhasil di ubah</div>');
        redirect('dashboard/master_kategori');
    }

    public function delete_kategori($id)
    {
        $this->db->delete('master_kategori', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Kategori Berhasil di hapus</div>');
        redirect('dashboard/master_kategori');
    }

    public function hapus_bulk_kategori()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('master_kategori', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Daftar Kategori Berhasil di Hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Daftar Kategori yang dipilih untuk dihapus</div>');
        }
        redirect('dashboard/master_kategori');
    }

    public function master_barang()
    {
        $data['tittle'] = 'List Data Barang | Inventori App';
        $this->db->order_by('id', 'DESC');
        $data['barang'] = $this->db->get('master_barang')->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/barang/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_barang()
    {
        $data['tittle'] = 'Tambah Data Barang | Inventori App';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/barang/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_barang()
    {
        $data = [
            'nama_barang' => $this->input->post('nama_barang')
        ];
        $this->db->insert('master_barang', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Barang Berhasil di tambahkan</div>');
        redirect('dashboard/master_barang');
    }

    public function edit_barang($id)
    {
        $data['tittle'] = 'Edit Data Barang | Inventori App';
        $data['barang'] = $this->db->get_where('master_barang', ['id' => $id])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/barang/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_barang($id)
    {
        $data = [
            'nama_barang' => $this->input->post('nama_barang')
        ];
        $this->db->where('id', $id);
        $this->db->update('master_barang', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Data Barang Berhasil di ubah</div>');
        redirect('dashboard/master_barang');
    }

    public function delete_barang($id)
    {
        $this->db->delete('master_barang', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Data Barang Berhasil di hapus</div>');
        redirect('dashboard/master_barang');
    }

    public function hapus_bulk_barang()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('master_barang', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Daftar Barang Berhasil di Hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Daftar Barang yang dipilih untuk dihapus</div>');
        }
        redirect('dashboard/master_barang');
    }

    public function jurnal_barang()
    {
        $data['tittle'] = 'Jurnal Barang | Inventori App';

        $this->db->select('jurnal_barang.id,jurnal_barang.kode_barang, master_barang.nama_barang, master_lokasi.nama_lokasi, master_kantor.nama_kantor, master_merek.nama_merek, master_kategori.nama_kategori, master_satuan.nama_satuan');
        $this->db->from('jurnal_barang');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_kategori', 'jurnal_barang.id_kategori = master_kategori.id');
        $this->db->join('master_satuan', 'jurnal_barang.id_satuan = master_satuan.id');
        $this->db->where('master_kantor.id', $this->kantor);
        $this->db->order_by('jurnal_barang.id', 'DESC');
        $data['jurnal_barang'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_barang/list', $data);
        $this->load->view('template/footer');
    }

    public function tambah_jurnal_barang()
    {
        $data['tittle'] = 'Tambah Jurnal Barang | Inventori App';

        $data['barang']     = $this->db->order_by('id', 'DESC')->get('master_barang')->result_array();
        $data['merek']      = $this->db->order_by('id', 'DESC')->get('master_merek')->result_array();
        $data['satuan']     = $this->db->order_by('id', 'DESC')->get('master_satuan')->result_array();
        $data['kategori']   = $this->db->order_by('id', 'DESC')->get('master_kategori')->result_array();
        $data['lokasi']     = $this->db->where('id_kantor', $this->kantor)
            ->order_by('id', 'DESC')
            ->get('master_lokasi')
            ->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_barang/add', $data);
        $this->load->view('template/footer');
    }

    public function simpan_jurnal_barang()
    {
        $config['upload_path'] = './images/barang/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto_barang')) {
            $error = $this->upload->display_errors();
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">' . $error . '</div>');
            redirect('dashboard/jurnal_barang');
        } else {
            $upload_data = $this->upload->data();
            $file_name = $upload_data['file_name'];

            $data = [
                'kode_barang'   => 'BRG-' . substr(uniqid(), -3),
                'id_barang'     => $this->input->post('id_barang'),
                'id_lokasi'     => $this->input->post('id_lokasi'),
                'id_satuan'     => $this->input->post('id_satuan'),
                'id_kategori'   => $this->input->post('id_kategori'),
                'id_merek'      => $this->input->post('id_merek'),
                'foto_barang'   => $file_name,
                'keterangan'    => $this->input->post('keterangan_barang'),
            ];

            $this->db->insert('jurnal_barang', $data);
            $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Jurnal Barang Berhasil di tambahkan</div>');
            redirect('dashboard/jurnal_barang');
        }
    }

    public function edit_jurnal_barang($id)
    {
        $data['tittle']         = 'Edit Jurnal Barang | Inventori App';
        $data['jurnal_barang']  = $this->db->get_where('jurnal_barang', ['id' => $id])->row_array();
        $data['barang']         = $this->db->order_by('id', 'DESC')->get('master_barang')->result_array();
        $data['merek']          = $this->db->order_by('id', 'DESC')->get('master_merek')->result_array();
        $data['satuan']         = $this->db->order_by('id', 'DESC')->get('master_satuan')->result_array();
        $data['kategori']       = $this->db->order_by('id', 'DESC')->get('master_kategori')->result_array();
        $data['lokasi']         = $this->db->where('id_kantor', $this->kantor)
            ->order_by('id', 'DESC')
            ->get('master_lokasi')
            ->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_barang/edit', $data);
        $this->load->view('template/footer');
    }

    public function update_jurnal_barang($id)
    {
        $data = [
            'id_barang'     => $this->input->post('id_barang'),
            'id_lokasi'     => $this->input->post('id_lokasi'),
            'id_satuan'     => $this->input->post('id_satuan'),
            'id_kategori'   => $this->input->post('id_kategori'),
            'id_merek'      => $this->input->post('id_merek'),
            'keterangan'    => $this->input->post('keterangan_barang'),
        ];
        $this->db->where('id', $id);
        $this->db->update('jurnal_barang', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Jurnal Barang Berhasil di update</div>');
        redirect('dashboard/jurnal_barang');
    }

    public function delete_jurnal_barang($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('jurnal_barang');
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Jurnal Barang Berhasil di hapus</div>');
        redirect('dashboard/jurnal_barang');
    }

    public function hapus_bulk_jurnal_barang()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('jurnal_barang', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Jurnal Barang Berhasil di hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Jurnal Barang Berhasil di hapus</div>');
        }
        redirect('dashboard/jurnal_barang');
    }

    public function jurnal_masuk_barang()
    {
        $data['tittle'] = 'Jurnal Barang Masuk | Inventori App';

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

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_masuk_barang/list');
        $this->load->view('template/footer');
    }

    public function tambah_masuk_barang()
    {
        $data['tittle'] = 'Jurnal Barang Masuk | Inventori App';

        $this->db->select('jurnal_barang.id,jurnal_barang.kode_barang,master_barang.nama_barang,master_merek.nama_merek,master_lokasi.nama_lokasi');
        $this->db->from('jurnal_barang');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->where('master_kantor.id', $this->kantor);
        $this->db->order_by('jurnal_barang.id', 'DESC');
        $data['jurnal_barang'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_masuk_barang/add');
        $this->load->view('template/footer');
    }

    public function simpan_jurnal_masuk_barang()
    {
        $data = [
            'id_jurnal_barang'  => $this->input->post('id_jurnal_barang'),
            'kode_barang_masuk' => 'JBM-' . substr(uniqid(), -5),
            'tanggal_masuk'     => $this->input->post('tanggal_masuk'),
            'jenis_pakai'       => $this->input->post('jenis_pakai'),
            'status_barang'     => $this->input->post('status_barang'),
            'jumlah_masuk'      => $this->input->post('jumlah_masuk'),
            'harga_barang'      => $this->input->post('harga_barang'),
            'total'             => $this->input->post('jumlah_masuk') * $this->input->post('harga_barang'),
            'keterangan'        => $this->input->post('keterangan'),
        ];

        $this->db->insert('jurnal_barang_masuk', $data);

        $jumlah_masuk       = $this->input->post('jumlah_masuk');
        $id_jurnal_barang   = $this->input->post('id_jurnal_barang');

        $this->db->where('id_jurnal_barang', $id_jurnal_barang);
        $query = $this->db->get('jurnal_stok_barang');

        if ($query->num_rows() > 0) {
            $data = $query->row();
            $jumlah_masuk_sekarang = $data->jumlah_masuk + (int)$jumlah_masuk;
            $stok_akhir_sekarang = $jumlah_masuk_sekarang - $data->jumlah_keluar;

            $this->db->set('jumlah_masuk', $jumlah_masuk_sekarang, FALSE);
            $this->db->set('stok_akhir', $stok_akhir_sekarang, FALSE);
            $this->db->where('id_jurnal_barang', $id_jurnal_barang);
            $this->db->update('jurnal_stok_barang');
        } else {
            $stok_akhir = $jumlah_masuk - 0;

            $data_stok = [
                'id_jurnal_barang'  => $id_jurnal_barang,
                'jumlah_masuk'      => $jumlah_masuk,
                'jumlah_keluar'     => 0,
                'stok_akhir'        => $stok_akhir
            ];
            $this->db->insert('jurnal_stok_barang', $data_stok);
        }

        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Jurnal Barang Berhasil di tambahkan</div>');
        redirect('dashboard/jurnal_masuk_barang');
    }


    public function edit_jurnal_barang_masuk($id)
    {
        $data['tittle'] = 'Edit Jurnal Barang Masuk | Inventori App';
        $data['jurnal_barang_masuk'] = $this->db->get_where('jurnal_barang_masuk', ['id' => $id])->row_array();

        $this->db->select('jurnal_barang.id,jurnal_barang.kode_barang,master_barang.nama_barang,master_merek.nama_merek,master_lokasi.nama_lokasi');
        $this->db->from('jurnal_barang');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->join('master_kantor', 'master_lokasi.id_kantor = master_kantor.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->where('master_kantor.id', $this->kantor);
        $this->db->order_by('jurnal_barang.id', 'DESC');
        $data['jurnal_barang'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_masuk_barang/edit');
        $this->load->view('template/footer');
    }

    public function update_jurnal_masuk_barang($id)
    {
        $data = [
            'id_jurnal_barang'  => $this->input->post('id_jurnal_barang'),
            'kode_barang_masuk' => 'JBM-' . substr(uniqid(), -5),
            'tanggal_masuk'     => $this->input->post('tanggal_masuk'),
            'jenis_pakai'       => $this->input->post('jenis_pakai'),
            'status_barang'     => $this->input->post('status_barang'),
            'jumlah_masuk'      => $this->input->post('jumlah_masuk_baru'),
            'harga_barang'      => $this->input->post('harga_barang'),
            'total'             => $this->input->post('jumlah_masuk_baru') * $this->input->post('harga_barang'),
            'keterangan'        => $this->input->post('keterangan'),
        ];

        $this->db->where('id', $id);
        $this->db->update('jurnal_barang_masuk', $data);

        $jumlah_masuk_lama = $this->input->post('jumlah_masuk_lama');
        $jumlah_masuk_baru = $this->input->post('jumlah_masuk_baru');
        $id_jurnal_barang  = $this->input->post('id_jurnal_barang');

        $this->db->where('id_jurnal_barang', $id_jurnal_barang);
        $query = $this->db->get('jurnal_stok_barang');
        $stok = $query->row();

        $jumlah_masuk_sekarang = ($stok->jumlah_masuk - (int)$jumlah_masuk_lama) + (int)$jumlah_masuk_baru;
        $stok_akhir_sekarang = (($stok->jumlah_masuk - (int)$jumlah_masuk_lama) + (int)$jumlah_masuk_baru) - $stok->jumlah_keluar;

        $this->db->set('jumlah_masuk', $jumlah_masuk_sekarang, FALSE);
        $this->db->set('stok_akhir', $stok_akhir_sekarang, FALSE);
        $this->db->where('id_jurnal_barang', $id_jurnal_barang);
        $this->db->update('jurnal_stok_barang');

        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Jurnal Barang Berhasil di Update</div>');
        redirect('dashboard/jurnal_masuk_barang');
    }

    public function delete_jurnal_barang_masuk($id)
    {
        $this->db->delete('jurnal_barang_masuk', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Jurnal Barang Berhasil di hapus</div>');
        redirect('dashboard/jurnal_masuk_barang');
    }

    public function hapus_bulk_jurnal_barang_masuk()
    {
        $ids = $this->input->post('id');
        if ($ids) {
            foreach ($ids as $id) {
                $this->db->delete('jurnal_barang_masuk', ['id' => $id]);
            }
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Jurnal Barang Masuk Berhasil di hapus</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning" role="alert">Tidak ada Jurnal Barang Masuk Berhasil di hapus</div>');
        }
        redirect('dashboard/jurnal_masuk_barang');
    }

    public function report_stok_barang()
    {
        $data['tittle'] = 'List Jurnal Stok Barang | Inventori App';

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
            jurnal_barang.keterangan,
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

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_stok_barang/list');
        $this->load->view('template/footer');
    }

    public function master_divisi()
    {
        $data['tittle']  = 'List Data Divisi | Inventori App';
        $this->db->order_by('id', 'DESC');
        $data['divisis'] = $this->db->where('id_kantor', $this->kantor)
            ->order_by('id')
            ->get('master_divisi')
            ->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/divisi/list');
        $this->load->view('template/footer');
    }

    public function tambah_divisi()
    {
        $data['tittle'] = 'List Data Divisi | Inventori App';
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/divisi/add');
        $this->load->view('template/footer');
    }

    public function simpan_divisi()
    {
        $data = [
            'id_kantor'     => $this->kantor,
            'nama_divisi'   => $this->input->post('nama_divisi'),
            'keterangan'    => $this->input->post('keterangan_divisi'),
        ];
        $this->db->insert('master_divisi', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Divisi Berhasil di tambahkan</div>');
        redirect('dashboard/master_divisi');
    }

    public function edit_divisi($id)
    {
        $data['tittle'] = 'Edit Divisi | Inventori App';
        $data['divisi'] = $this->db->get_where('master_divisi', ['id' => $id])->row_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/divisi/edit');
        $this->load->view('template/footer');
    }

    public function update_divisi($id)
    {
        $data = [
            'nama_divisi'   => $this->input->post('nama_divisi'),
            'keterangan'    => $this->input->post('keterangan_divisi'),
        ];
        $this->db->where('id', $id);
        $this->db->update('master_divisi', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Divisi Berhasil di ubah</div>');
        redirect('dashboard/master_divisi');
    }

    public function delete_divisi($id)
    {
        $this->db->delete('master_divisi', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Divisi Berhasil di hapus</div>');
        redirect('dashboard/master_divisi');
    }

    public function master_karyawan()
    {
        $data['tittle'] = 'List Data Karyawan | Inventori App';
        $this->db->select('master_karyawan.id, master_karyawan.nama_karyawan, master_divisi.nama_divisi');
        $this->db->from('master_karyawan');
        $this->db->join('master_divisi', 'master_karyawan.id_divisi = master_divisi.id');
        $this->db->where('master_divisi.id_kantor', $this->kantor);
        $this->db->order_by('master_karyawan.id', 'DESC');
        $data['karyawans'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/karyawan/list');
        $this->load->view('template/footer');
    }

    public function tambah_karyawan()
    {
        $data['tittle'] = 'Tambah Data Karyawan | Inventori App';
        $data['divisis'] = $this->db->order_by('id', 'DESC')
            ->get('master_divisi')
            ->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/karyawan/add');
        $this->load->view('template/footer');
    }

    public function simpan_karyawan()
    {
        $data = [
            'id_divisi'     => $this->input->post('nama_divisi'),
            'nama_karyawan' => $this->input->post('nama_karyawan'),
        ];
        $this->db->insert('master_karyawan', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Karyawan Berhasil di tambahkan</div>');
        redirect('dashboard/master_karyawan');
    }

    public function edit_karyawan($id)
    {
        $data['tittle'] = 'Edit Karyawan | Inventori App';
        $data['karyawan'] = $this->db->get_where('master_karyawan', ['id' => $id])->row_array();
        $data['divisis'] = $this->db->order_by('id', 'DESC')
            ->get('master_divisi')
            ->result_array();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/karyawan/edit');
        $this->load->view('template/footer');
    }

    public function update_karyawan($id)
    {
        $data = [
            'id_divisi'     => $this->input->post('nama_divisi'),
            'nama_karyawan' => $this->input->post('nama_karyawan'),
        ];
        $this->db->where('id', $id);
        $this->db->update('master_karyawan', $data);
        $this->session->set_flashdata('pesan', '<div class="alert alert-success" role="alert">Karyawan Berhasil di ubah</div>');
        redirect('dashboard/master_karyawan');
    }

    public function delete_karyawan($id)
    {
        $this->db->delete('master_karyawan', ['id' => $id]);
        $this->session->set_flashdata('pesan', '<div class="alert alert-danger" role="alert">Karyawan Berhasil di hapus</div>');
        redirect('dashboard/master_karyawan');
    }

    public function report_history_inventaris()
    {
        $data['tittle'] = 'Report History Inventaris | Inventori App';

        $this->db->select('
            jurnal_inventaris.id,
            master_barang.nama_barang,
            master_karyawan.nama_karyawan,
            master_divisi.nama_divisi,
            master_merek.nama_merek,
            jurnal_inventaris.tanggal_assign,
            jurnal_inventaris.tanggal_return,
            history_assets.kondisi_awal,
            history_assets.kondisi_akhir,
            jurnal_inventaris.jumlah_assets,
            jurnal_inventaris.status_assets,
            jurnal_inventaris.keterangan as keterangan_inventaris,
            jurnal_barang_masuk.jenis_pakai,
            jurnal_barang_masuk.kode_barang_masuk as kode_barang,
            jurnal_barang_masuk.keterangan as spesifikasi
        ');
        $this->db->from('jurnal_inventaris');
        $this->db->join('history_assets', 'history_assets.id_jurnal_inventaris = jurnal_inventaris.id');
        $this->db->join('master_karyawan', 'master_karyawan.id = jurnal_inventaris.id_karyawan');
        $this->db->join('master_divisi', 'master_divisi.id = master_karyawan.id_divisi');
        $this->db->join('jurnal_barang_masuk', 'jurnal_barang_masuk.id = jurnal_inventaris.id_jurnal_barang_masuk');
        $this->db->join('jurnal_barang', 'jurnal_barang.id = jurnal_barang_masuk.id_jurnal_barang');
        $this->db->join('master_barang', 'master_barang.id = jurnal_barang.id_barang');
        $this->db->join('master_merek', 'master_merek.id = jurnal_barang.id_merek');
        $this->db->join('master_lokasi', 'master_lokasi.id = jurnal_barang.id_lokasi');
        $this->db->join('master_kantor', 'master_kantor.id = master_lokasi.id_kantor');

        $this->db->where('master_kantor.id', $this->kantor);

        $this->db->order_by('jurnal_inventaris.id', 'DESC');
        $data['history_inventaris'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_history_inventaris/list');
        $this->load->view('template/footer');
    }

    public function jurnal_inventaris_barang()
    {
        $data['tittle'] = 'List Jurnal Inventaris | Inventori App';

        $this->db->select('
            jurnal_inventaris.id,
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

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_inventaris_barang/list');
        $this->load->view('template/footer');
    }

    public function tambah_inventaris_barang()
    {
        $data['tittle'] = 'Tambah Jurnal Inventaris | Inventori App';

        $this->db->select('master_karyawan.id, master_karyawan.nama_karyawan, master_divisi.nama_divisi');
        $this->db->from('master_karyawan');
        $this->db->join('master_divisi', 'master_karyawan.id_divisi = master_divisi.id');
        $this->db->where('master_divisi.id_kantor', $this->kantor);
        $this->db->order_by('master_karyawan.id', 'DESC');
        $data['employees'] = $this->db->get()->result_array();

        $this->db->select('jurnal_barang_masuk.id, jurnal_barang.kode_barang, master_barang.nama_barang, master_merek.nama_merek,jurnal_barang_masuk.tanggal_masuk,jurnal_barang_masuk.keterangan');
        $this->db->from('jurnal_barang_masuk');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->where('jurnal_barang_masuk.jenis_pakai', 'Inventaris');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->order_by('jurnal_barang_masuk.id', 'DESC');
        $data['items'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_inventaris_barang/add');
        $this->load->view('template/footer');
    }

    public function simpan_inventaris_barang()
    {
        $data = [
            'kode_inventaris'           => 'KJI-' . substr(uniqid(), -5),
            'id_jurnal_barang_masuk'    => $this->input->post('nama_inventaris'),
            'id_karyawan'               => $this->input->post('nama_karyawan'),
            'tanggal_assign'            => $this->input->post('tanggal_assign'),
            'status_assets'             => $this->input->post('status_assets'),
            'jumlah_assets'             => $this->input->post('jumlah_assets'),
            'keterangan'                => $this->input->post('keterangan_barang') ? $this->input->post('keterangan_barang') : 'Asset dalam kondisi layak digunakan',
            'created_at'                => date('Y-m-d H:i:s')
        ];

        $this->db->insert('jurnal_inventaris', $data);

        $history = [
            'id_jurnal_inventaris' => $this->db->insert_id(),
            'kondisi_awal'         => $this->input->post('keterangan_barang') ? $this->input->post('keterangan_barang') : 'Asset dalam kondisi layak digunakan',
            'created_at'           => date('Y-m-d H:i:s')
        ];

        $this->db->insert('history_assets', $history);

        $this->session->set_flashdata('pesan', '<div class="alert alert-primary" role="alert">Jurnal Inventaris Berhasil di simpan</div>');
        redirect('dashboard/jurnal_inventaris_barang');
    }

    public function return_jurnal_inventaris($id)
    {
        $data['tittle'] = 'Return Jurnal Inventaris | Inventori App';

        $this->db->select('
            jurnal_inventaris.id,
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
            jurnal_inventaris.status_assets,
            jurnal_inventaris.kondisi_asset,
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
        $this->db->where('jurnal_inventaris.id', $id);
        $data['items'] = $this->db->get()->row_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_inventaris_barang/return');
        $this->load->view('template/footer');
    }

    public function update_return_inventaris($id)
    {
        $data = [
            'tanggal_return'    => $this->input->post('tanggal_return'),
            'kondisi_asset'     => $this->input->post('kondisi_asset'),
            'updated_at'        => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        $this->db->update('jurnal_inventaris', $data);

        $history = [
            'kondisi_akhir' => $this->input->post('keterangan_barang') ? $this->input->post('keterangan_barang') : 'Asset dalam kondisi layak digunakan',
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $this->db->where('id_jurnal_inventaris', $id);
        $this->db->update('history_assets', $history);

        $this->session->set_flashdata('pesan', '<div class="alert alert-primary" role="alert">Jurnal Inventaris Berhasil di update</div>');
        redirect('dashboard/jurnal_inventaris_barang');
    }

    public function mutasi_inventaris_barang()
    {
        $data['tittle'] = 'Mutasi Inventaris | Inventori App';

        $this->db->select('master_karyawan.id, master_karyawan.nama_karyawan, master_divisi.nama_divisi');
        $this->db->from('master_karyawan');
        $this->db->join('master_divisi', 'master_karyawan.id_divisi = master_divisi.id');
        $this->db->where('master_divisi.id_kantor', $this->kantor);
        $this->db->order_by('master_karyawan.id', 'DESC');
        $data['employees'] = $this->db->get()->result_array();

        $this->db->select('jurnal_inventaris.id,jurnal_inventaris.id_jurnal_barang_masuk,master_karyawan.nama_karyawan,jurnal_inventaris.tanggal_return,master_barang.nama_barang,master_merek.nama_merek,jurnal_barang_masuk.keterangan as spesifikasi');
        $this->db->from('jurnal_inventaris');
        $this->db->join('jurnal_barang_masuk', 'jurnal_inventaris.id_jurnal_barang_masuk = jurnal_barang_masuk.id');
        $this->db->join('master_karyawan', 'jurnal_inventaris.id_karyawan = master_karyawan.id');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->join('master_lokasi', 'jurnal_barang.id_lokasi = master_lokasi.id');
        $this->db->where('master_lokasi.id_kantor', $this->kantor);
        $this->db->where('jurnal_inventaris.kondisi_asset', 'Aktif');
        $this->db->order_by('jurnal_inventaris.id', 'DESC');
        $data['items'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_inventaris_barang/mutasi');
        $this->load->view('template/footer');
    }

    public function simpan_mutasi_inventaris()
    {
        $id = $this->input->post('pengguna_lama');
        $update = [
            'kondisi_asset' => 'Tercatat',
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('jurnal_inventaris', $update);

        $data = [
            'kode_inventaris'           => 'KJI-' . substr(uniqid(), -5),
            'id_jurnal_barang_masuk'    => $this->input->post('nama_inventaris'),
            'id_karyawan'               => $this->input->post('nama_karyawan'),
            'tanggal_assign'            => $this->input->post('tanggal_assign'),
            'status_assets'             => $this->input->post('status_assets'),
            'jumlah_assets'             => $this->input->post('jumlah_assets'),
            'keterangan'                => $this->input->post('keterangan_barang') ? $this->input->post('keterangan_barang') : 'Asset dalam kondisi layak digunakan',
        ];
        $this->db->insert('jurnal_inventaris', $data);

        $history = [
            'id_jurnal_inventaris' => $this->db->insert_id(),
            'kondisi_awal'         => $this->input->post('keterangan_barang') ? $this->input->post('keterangan_barang') : 'Asset dalam kondisi layak digunakan',
            'created_at'           => date('Y-m-d H:i:s')
        ];
        $this->db->insert('history_assets', $history);

        $this->session->set_flashdata('pesan', '<div class="alert alert-primary" role="alert">Mutasi Assets Inventaris Berhasil di simpan</div>');
        redirect('dashboard/jurnal_inventaris_barang');
    }

    public function report_assets_inventaris()
    {
        $data['tittle'] = 'Report Assets Inventaris | Inventori App';

        $this->db->select('
            jurnal_barang_masuk.kode_barang_masuk,
            jurnal_barang.kode_barang,
            master_barang.nama_barang,
            master_merek.nama_merek,
            jurnal_barang_masuk.keterangan as spesifikasi,
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
        $data['assets'] = $this->db->get()->result_array();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar');
        $this->load->view('dashboard/jurnal_assets_inventaris/list');
        $this->load->view('template/footer');
    }
}
