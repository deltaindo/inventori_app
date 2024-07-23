<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <div>
                            <div class="btn-wrapper">
                                <a href="" class="btn btn-primary text-white me-0">
                                    <i class="ti-cloud-down"></i>
                                    Download Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="<?= base_url('dashboard/hapus_bulk_jurnal_barang_masuk'); ?>" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        Jurnal Barang Masuk
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_masuk_barang'); ?>" class="btn btn-primary text-white">
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
                                                        Barang Masuk
                                                    </th>
                                                    <th>
                                                        Barang
                                                    </th>
                                                    <th>
                                                        Merek
                                                    </th>
                                                    <th>
                                                        Keterangan [Spesifikasi]
                                                    </th>
                                                    <th>
                                                        Lokasi
                                                    </th>
                                                    <th>
                                                        Kantor
                                                    </th>
                                                    <th>
                                                        Tanggal Masuk
                                                    </th>
                                                    <th>
                                                        Jenis Pakai
                                                    </th>
                                                    <th>
                                                        Kategori
                                                    </th>
                                                    <th>
                                                        Status Barang
                                                    </th>
                                                    <th>
                                                        Jumlah Masuk
                                                    </th>
                                                    <th>
                                                        Harga Asset
                                                    </th>
                                                    <th>
                                                        Total Harga Asset
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($jurnal_barang_masuk as $barang_masuk) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['kode_barang_masuk']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['nama_barang']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['nama_merek']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['keterangan']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['nama_lokasi']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['nama_kantor']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['tanggal_masuk']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['jenis_pakai']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['nama_kategori']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['status_barang']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $barang_masuk['jumlah_masuk']; ?> <?= $barang_masuk['nama_satuan']; ?>
                                                        </td>
                                                        <td>
                                                            <?= 'Rp ' . number_format($barang_masuk['harga_barang'], 0, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                            <?= 'Rp ' . number_format($barang_masuk['total'], 0, ',', '.'); ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('dashboard/edit_jurnal_barang_masuk/' . $barang_masuk['id']); ?>" class="btn btn-lg btn-outline-primary">
                                                                Edit
                                                            </a>
                                                        </td>
                                                    </tr>
                                            </tbody>
                                        <?php endforeach; ?>
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