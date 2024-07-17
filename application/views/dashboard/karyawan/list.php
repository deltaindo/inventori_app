<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="#" method="post">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        List Data Karyawan
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_karyawan'); ?>" class="btn btn-primary text-white">
                                        Tambah Data
                                    </a>
                                    <div class="table-responsive overflow-visible mt-3">
                                        <table class="table table-hover" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No.
                                                    </th>
                                                    <th>
                                                        Nama Karyawan
                                                    </th>
                                                    <th>
                                                        Nama Divisi
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($karyawans as $employee) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++; ?>
                                                        </td>
                                                        <td>
                                                            <?= $employee['nama_karyawan']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $employee['nama_divisi']; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('dashboard/edit_karyawan/' . $employee['id']) ?>" class="btn btn-lg btn-outline-primary">
                                                                Edit
                                                            </a>
                                                            <button class="btn btn-lg btn-danger" type="button" onclick="deleteKaryawan(<?= $employee['id']; ?>)">
                                                                Hapus
                                                            </button>
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