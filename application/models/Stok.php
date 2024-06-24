<?php
class Stok extends CI_Model {
    public function getStok($kat)
    {
        $query = $this->db->select('perlengkapan_peserta.kode_barang, perlengkapan_peserta.nama_barang, perlengkapan_peserta.stok_awal,
        IFNULL(SUM(barang_masuk.jumlah), 0) as masuk, IFNULL(SUM(detail_barang_keluar.jumlah), 0) as keluar')
        ->from('perlengkapan_peserta')
        ->join('barang_masuk', 'barang_masuk.kode_barang = perlengkapan_peserta.kode_barang', 'left')
        ->join('detail_barang_keluar', 'detail_barang_keluar.kode_barang = perlengkapan_peserta.kode_barang', 'left')
        ->where("perlengkapan_peserta.kategori", $kat)
        ->group_by('perlengkapan_peserta.kode_barang')
        ->get();
        $hasil = $query->result_array();
            foreach($hasil as $h) {
                $stok = $h['stok_awal'] + $h['masuk'] - $h['keluar'];
                $this->db->set('jumlah', $stok);
                $this->db->where('kode_barang', $h['kode_barang']);
                $this->db->update('perlengkapan_peserta');
            }

        return $hasil;
    }

    public function getStokMonth($bulan, $kat)
    {
            $query = $this->db->select('perlengkapan_peserta.kode_barang, perlengkapan_peserta.nama_barang, perlengkapan_peserta.stok_awal,
            COALESCE(SUM(masuk.jumlah), 0) as masuk, COALESCE(SUM(keluar.jumlah), 0) as keluar')
            ->from('perlengkapan_peserta')
            ->join('(SELECT kode_barang, SUM(jumlah) as jumlah FROM barang_masuk WHERE DATE_FORMAT(tanggal_masuk, "%Y-%m") = "' . $bulan . '" GROUP BY kode_barang) as masuk', 'masuk.kode_barang = perlengkapan_peserta.kode_barang', 'left')
            ->join('(SELECT kode_barang, SUM(jumlah) as jumlah FROM detail_barang_keluar 
                    JOIN barang_keluar ON detail_barang_keluar.id_user = barang_keluar.id
                    WHERE DATE_FORMAT(tanggal_keluar, "%Y-%m") = "' . $bulan . '" GROUP BY kode_barang) as keluar', 'keluar.kode_barang = perlengkapan_peserta.kode_barang', 'left')
            ->where("perlengkapan_peserta.kategori", $kat)
            ->group_by('perlengkapan_peserta.kode_barang')
            ->get();
    
        // $hasil =  $query->result_array();
        // foreach($hasil as $h) {
        //     $stok = $h['stok_awal'] + $h['masuk'] - $h['keluar'];
        //     $this->db->set('jumlah', $stok);
        //     $this->db->where('kode_barang', $h['kode_barang']);
        //     $this->db->update('perlengkapan_peserta');
        // }
        return $query->result_array();
    }

    public function kurangiStok()
    {
        $this->db->select('peminjaman.id, detail_peminjaman.kode_barang, detail_peminjaman.jumlah');
        $this->db->from('peminjaman');
        $this->db->join('detail_peminjaman', 'peminjaman.id = detail_peminjaman.id');
        $this->db->where('peminjaman.status', 'Peminjaman');
        $query = $this->db->get();
        return $query->result_array();
    }
}
