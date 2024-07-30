<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
                        <div class="btn-wrapper">
                            <a href="<?= base_url('report/report_jurnal_peminjaman_inventaris'); ?>" class="btn btn-success text-white me-0" type="button">
                                <i class="ti-cloud-down"></i>
                                Export Excel
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="#" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        Jurnal Peminjaman Inventaris
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_peminjaman_inventaris'); ?>" class="btn btn-primary text-white">
                                        Tambah Data
                                    </a>
                                    <div class="overflow-visible mt-3">
                                        <table class="table table-hover" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No.
                                                    </th>
                                                    <th>
                                                        Kode Peminjaman
                                                    </th>
                                                    <th>
                                                        Kode Barang
                                                    </th>
                                                    <th>
                                                        Nama Barang
                                                    </th>
                                                    <th>
                                                        Merek
                                                    </th>
                                                    <th>
                                                        Spesifikasi
                                                    </th>
                                                    <th>
                                                        Nama Karyawan
                                                    </th>
                                                    <th>
                                                        Divisi
                                                    </th>
                                                    <th>
                                                        Tujuan Pinjam
                                                    </th>
                                                    <th>
                                                        Tanggal Pinjam
                                                    </th>
                                                    <th>
                                                        Jumlah Pinjam
                                                    </th>
                                                    <th>
                                                        Kondisi Pinjam
                                                    </th>
                                                    <th>
                                                        Tanggal Kembali
                                                    </th>
                                                    <th>
                                                        Kondisi Kembali
                                                    </th>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <th>
                                                        Keterangan
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach($pinjam_inventaris as $pinjam) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['kode_pinjam_inventaris'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['kode_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['nama_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['nama_merek'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['spesifikasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['nama_karyawan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['nama_divisi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['tujuan_pinjam'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['tanggal_pinjam'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['jumlah_pinjam'] ?> <?= $pinjam['nama_satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['kondisi_pinjam'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['tanggal_kembali'] == Null ? '-' : $pinjam['tanggal_kembali'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['kondisi_kembali'] == Null ? '-' : $pinjam['kondisi_kembali'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['status'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $pinjam['keterangan'] ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($pinjam['status'] == "Dipinjam") : ?>
                                                                <a href="<?= base_url('dashboard/pengembalian_peminjaman_inventaris/' . $pinjam['id']); ?>" class="btn btn-primary text-white">
                                                                    Dikembalikan
                                                                </a>
                                                            <?php elseif ($pinjam['status'] == "Dikembalikan") : ?>
                                                                -
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>