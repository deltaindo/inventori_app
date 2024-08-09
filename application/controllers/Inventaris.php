<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventaris extends CI_Controller
{
    public function detail($id)
    {
        $data['tittle'] = 'Detail Inventaris';

        $this->db->select('
            jurnal_barang_masuk.id,
            jurnal_barang_masuk.kode_barang_masuk, 
            jurnal_barang.kode_barang,
            master_barang.nama_barang,
            master_merek.nama_merek,
            jurnal_barang.keterangan as spesifikasi,
            jurnal_barang_masuk.tanggal_masuk,
            jurnal_barang_masuk.jenis_pakai
        ');

        $this->db->from('jurnal_barang_masuk');
        $this->db->join('jurnal_barang', 'jurnal_barang_masuk.id_jurnal_barang = jurnal_barang.id');
        $this->db->join('master_barang', 'jurnal_barang.id_barang = master_barang.id');
        $this->db->join('master_merek', 'jurnal_barang.id_merek = master_merek.id');
        $this->db->where('jurnal_barang_masuk.id', $id);
        $this->db->group_start();
        $this->db->where('jurnal_barang_masuk.jenis_pakai', 'Inventaris');
        $this->db->group_end();
        $this->db->order_by('jurnal_barang_masuk.id', 'DESC');
        $data['assets'] = $this->db->get()->row_array();
        
        $this->db->select('
            jurnal_inventaris.id,
            jurnal_inventaris.id_jurnal_barang_masuk,
            master_satuan.nama_satuan,
            master_karyawan.nama_karyawan,
            master_divisi.nama_divisi,
            jurnal_inventaris.tanggal_assign,
            jurnal_inventaris.tanggal_return,
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

        $this->db->where('jurnal_inventaris.id_jurnal_barang_masuk', $id);
        $data['items'] = $this->db->get()->result_array();

        $this->load->view('inventaris/header', $data);
        $this->load->view('inventaris/detail');
    }
}