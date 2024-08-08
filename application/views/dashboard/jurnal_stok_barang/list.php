<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <form action="<?= base_url('report/report_jurnal_stok_barang'); ?>" method="post">
                    <div class="row border-bottom">
                        <div class="col-auto mb-1">
                            <input type="date" id="tanggal_awal" name="tanggal_awal" class="form-control">
                        </div>
                        <div class="col-auto mb-1">
                            <input type="date" id="tanggal_akhir" name="tanggal_akhir" class="form-control">
                        </div>
                        <div class="col-auto mb-1">
                            <button type="submit" class="btn btn-sm btn-success text-white">
                                <i class="ti-cloud-down"></i>
                                Export Excel
                            </button>
                        </div>
                    </div>
                </form>
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="#" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        Report Jurnal Stok Barang
                                    </h4>
                                    <div class="overflow-visible mt-3">
                                        <table class="table table-hover" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No.
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
                                                        Jenis Assets
                                                    </th>
                                                    <th>
                                                        Lokasi
                                                    </th>
                                                    <th>
                                                        Kantor
                                                    </th>
                                                    <th>
                                                        Tanggal Update
                                                    </th>
                                                    <th>
                                                        Jumlah Masuk
                                                    </th>
                                                    <th>
                                                        Jumlah Keluar
                                                    </th>
                                                    <th>
                                                        Stok Akhir
                                                    </th>
                                                    <th>
                                                        Keterangan
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($jurnal_stok as $stok) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['kode_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['nama_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['nama_merek'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['nama_kategori'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['nama_lokasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['nama_kantor'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['tanggal_update'] == null ? '-' : $stok['tanggal_update'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['jumlah_masuk'] ?> <?= $stok['nama_satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['jumlah_keluar'] ?> <?= $stok['nama_satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['stok_akhir'] ?> <?= $stok['nama_satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['keterangan'] ?>
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