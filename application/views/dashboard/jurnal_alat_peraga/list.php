<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
                        <div class="btn-wrapper">
                            <a href="<?= base_url('report/report_jurnal_alat_peraga'); ?>" class="btn btn-success text-white me-0" type="button">
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
                                        Jurnal Alat Peraga
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="#" class="btn btn-primary text-white">
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
                                                        Kode Alat Peraga
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
                                                        Alokasi Tujuan
                                                    </th>
                                                    <th>
                                                        Tanggal Beli
                                                    </th>
                                                    <th>
                                                        Tanggal Kalibrasi
                                                    </th>
                                                    <th>
                                                        Masa Kalibrasi
                                                    </th>
                                                    <th>
                                                        Jumlah
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
                                                <?php foreach ($alat_peraga as $jurnal_alat_peraga) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['kode_alat_peraga'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['kode_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['nama_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['nama_merek'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['spesifikasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['alokasi_tujuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['tanggal_beli'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['tanggal_kalibrasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['masa_berlaku_kalibrasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['jumlah'] ?> <?= $jurnal_alat_peraga['nama_satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $jurnal_alat_peraga['keterangan'] ?>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="btn btn-outline-secondary text-black">
                                                                Edit
                                                            </a>
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