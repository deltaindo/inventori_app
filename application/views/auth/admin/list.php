<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="<?= base_url('dashboard/hapus_bulk_admin'); ?>" method="post">
                                <div class="card-body">
                                    <h4 class="card-title">
                                        List Data Admin
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="<?= base_url('dashboard/tambah_admin'); ?>" class="btn btn-primary text-white">
                                        Tambah Data
                                    </a>
                                    <button class="btn btn-danger text-white" type="button" onclick="deleteBulkAdmin()">
                                        Hapus Bulk
                                    </button>
                                    <div class="table-responsive overflow-visible mt-3">
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
                                                        Nama Admin
                                                    </th>
                                                    <th>
                                                        Email Admin
                                                    </th>
                                                    <th>
                                                        Nama Kantor
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($admins as $admin) : ?>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox" id="check" name="id[]" value="<?= $admin['id']; ?>" class="form-check-input check" aria-checked="false" />
                                                            <i class="input-helper"></i>
                                                        </td>
                                                        <td>
                                                            <?= $i++; ?>
                                                        </td>
                                                        <td>
                                                            <?= $admin['Nama']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $admin['email']; ?>
                                                        </td>
                                                        <td>
                                                            <?= $admin['nama_kantor']; ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('dashboard/edit_admin/') . $admin['id']; ?>" class="btn btn-lg btn-outline-primary">
                                                                Edit
                                                            </a>
                                                            <button class="btn btn-lg btn-danger" type="button" onclick="deleteAdmin(<?= $admin['id']; ?>)">
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