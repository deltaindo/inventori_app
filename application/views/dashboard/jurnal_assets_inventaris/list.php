<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <form action="<?= base_url('report/report_assets_inventaris'); ?>" method="post">
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
                                        Report Assets Inventaris
                                    </h4>
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
                                                        Kode Barang
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
                                                        Tanggal Masuk
                                                    </th>
                                                    <th>
                                                        Jenis Pakai
                                                    </th>
                                                    <th>
                                                        Status Barang
                                                    </th>
                                                    <th>
                                                        Jumlah Masuk
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($assets as $asset) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["kode_barang_masuk"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["kode_barang"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["nama_barang"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["nama_merek"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["spesifikasi"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["tanggal_masuk"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["jenis_pakai"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["status_barang"]; ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset["jumlah_masuk"] . ' ' . $asset["nama_satuan"]; ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($asset['jenis_pakai'] === 'Inventaris') : ?>
                                                                <a href="<?= base_url('dashboard/download_qrcode/' . $asset['id']); ?>" class="btn btn-lg btn-primary">
                                                                QRCode
                                                            </a>
                                                            <?php else : ?>
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