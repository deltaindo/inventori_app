<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <form action="<?= base_url('report/report_jurnal_barang'); ?>" method="post">
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
                            <form id="bulk-delete-form" action="<?= base_url('dashboard/hapus_bulk_jurnal_barang'); ?>" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        List Jurnal Barang
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_jurnal_barang'); ?>" class="btn btn-primary text-white">
                                        Tambah Data
                                    </a>
                                    <button class="btn btn-danger text-white" type="button" onclick="bulkDeleteJurnalBarang()">
                                        Hapus Bulk
                                    </button>
                                    <div class="overflow-visible mt-3">
                                        <table class="table table-hover" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" id="check-all" class="form-check-input check" aria-checked="false" />
                                                        <i class="input-helper"></i>
                                                    </th>
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
                                                        Satuan
                                                    </th>
                                                    <th>
                                                        Kategori
                                                    </th>
                                                    <th>
                                                        Spesifikasi
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($jurnal_barang as $jurbar) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" id="check" name="id[]" value="<?= $jurbar['id']; ?>" class="form-check-input check" aria-checked="false" />
                                                            <i class="input-helper"></i>
                                                        </td>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["kode_barang"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["nama_barang"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["nama_merek"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["nama_lokasi"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["nama_kantor"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["nama_satuan"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["nama_kategori"] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurbar["keterangan"] ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('dashboard/edit_jurnal_barang/' . $jurbar['id']); ?>" class="btn btn-lg btn-outline-primary">
                                                                Edit
                                                            </a>
                                                            <button class="btn btn-lg btn-danger" type="button" onclick="deleteJurnalBarang(<?= $jurbar['id']; ?>)">
                                                                Hapus
                                                            </button>
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