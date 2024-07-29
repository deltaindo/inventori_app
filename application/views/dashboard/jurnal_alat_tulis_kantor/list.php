<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
                        <div class="btn-wrapper">
                            <a href="<?= base_url('report/report_jurnal_alat_tulis_kantor'); ?>" class="btn btn-success text-white me-0" type="button">
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
                                        Jurnal Alat Tulis Kantor
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_alat_tulis_kantor'); ?>" class="btn btn-primary text-white">
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
                                                        Kode Alat Tulis Kantor
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
                                                        Tanggal Pengambilan
                                                    </th>
                                                    <th>
                                                        Jumlah Pengambilan
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
                                                <?php foreach($alat_tulis_kantor as $alat_tulis) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['kode_alat_tulis_kantor']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['kode_barang']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['nama_barang']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['nama_merek']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['spesifikasi']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['nama_karyawan']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['nama_divisi']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['tanggal_pengambilan']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['jumlah_pengambilan']; ?> <?= $alat_tulis['nama_satuan']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $alat_tulis['keterangan']; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('dashboard/edit_alat_tulis_kantor/'.$alat_tulis['id']); ?>" class="btn btn-outline-secondary text-black">
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