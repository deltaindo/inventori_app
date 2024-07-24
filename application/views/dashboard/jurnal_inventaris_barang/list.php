<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
                        <div>
                            <div class="btn-wrapper">
                                <a href="<?= base_url('report/report_inventaris_barang'); ?>" class="btn btn-success text-white me-0" type="button">
                                    <i class="ti-cloud-down"></i>
                                    Export Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="#" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        Jurnal Inventaris Barang
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_inventaris_barang'); ?>" class="btn btn-primary text-white">
                                        Tambah Data
                                    </a>
                                    <a href="<?= base_url('dashboard/mutasi_inventaris_barang'); ?>" class="btn btn-info text-black">
                                        Mutasi Inventaris
                                    </a>
                                    <div class="overflow-visible mt-3">
                                        <table class="table table-hover" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No.
                                                    </th>
                                                    <th>
                                                        Kode Inventaris
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
                                                        Masuk Assets
                                                    </th>
                                                    <th>
                                                        Karyawan
                                                    </th>
                                                    <th>
                                                        Divisi
                                                    </th>
                                                    <th>
                                                        Tanggal Assign
                                                    </th>
                                                    <th>
                                                        Jumlah Assets
                                                    </th>
                                                    <th>
                                                        Keterangan Inventaris
                                                    </th>
                                                    <th>
                                                        Tanggal Return
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($inventaris as $asset) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['kode_inventaris'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['kode_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_merek'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['spesifikasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['tanggal_masuk'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_karyawan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_divisi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['tanggal_assign'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['jumlah_assets'] . ' ' . $asset['nama_satuan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['keterangan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['tanggal_return'] == Null ? '-' : $asset['tanggal_return'] ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($asset['tanggal_return'] == Null) : ?>
                                                                <a href="<?= base_url('dashboard/return_jurnal_inventaris/' . $asset['id']) ?>" class="btn btn-primary text-white">
                                                                    Return
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