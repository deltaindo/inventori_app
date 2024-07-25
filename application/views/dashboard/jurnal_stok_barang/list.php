<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                        <div class="btn-wrapper">
                            <a href="<?= base_url('report/report_jurnal_stok_barang'); ?>" class="btn btn-success text-white me-0" type="button">
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
                                                            <?= $stok['nama_lokasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['nama_kantor'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $stok['tanggal_update'] ?>
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