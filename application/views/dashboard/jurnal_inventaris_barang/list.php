<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
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
                            <form id="bulk-delete-form" action="#" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        Jurnal Inventaris Barang
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_inventaris_barang'); ?>" class="btn btn-primary text-white">
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
                                                        Kode Barang
                                                    </th>
                                                    <th>
                                                        Nama Barang
                                                    </th>
                                                    <th>
                                                        Spesifikasi
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <tr>
                                                    <td>
                                                        <?= $i++ ?>
                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
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