<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
                        <div class="btn-wrapper">
                            <a href="<?= base_url('report/report_jurnal_alat_peserta'); ?>" class="btn btn-success text-white me-0" type="button">
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
                                        Jurnal Alat Peserta
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_jurnal_alat_peserta'); ?>" class="btn btn-primary text-white">
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
                                                        Jurnal Alat Peserta
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
                                                        Tujuan Barang Keluar
                                                    </th>
                                                    <th>
                                                        Tanggal Keluar
                                                    </th>
                                                    <th>
                                                        Jumlah Keluar
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
                                                <?php foreach ($alat_peserta as $alat) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['kode_alat_peserta'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['kode_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['nama_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['nama_merek'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['spesifikasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['tujuan_barang_keluar'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['tanggal_keluar'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['jumlah'] ?> <?= $alat['nama_satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat['keterangan'] ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('dashboard/edit_jurnal_alat_peserta/' . $alat['id']); ?>" class="btn btn-outline-secondary text-black">
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