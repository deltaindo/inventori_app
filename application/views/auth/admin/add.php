<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="tab-content tab-content-basic">
                                <?= $this->session->flashdata('message'); ?>
                                <div class="row tabel-produk mt-2">
                                    <div class="col-lg-8 grid-margin stretch-card">
                                        <div class="card">
                                            <form method="post" action="<?= base_url('dashboard/simpan_admin'); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Tambah Admin
                                                    </h4>

                                                    <label for="nama_admin" class="text-primary fs-6 mb-1">
                                                        Username Admin
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_admin" placeholder="Username Admin..." autofocus>
                                                    </div>

                                                    <label for="nama_lengkap" class="text-primary fs-6 mb-1">
                                                        Nama Lengkap Admin
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap Admin..." autofocus>
                                                    </div>

                                                    <label for="email_admin" class="text-primary fs-6 mb-1">
                                                        Email Admin
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="email_admin" placeholder="Email Admin..." autofocus>
                                                    </div>

                                                    <label for="password_admin" class="text-primary fs-6 mb-1">
                                                        Password Admin
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control" name="password_admin" placeholder="Password Admin..." autofocus>
                                                    </div>

                                                    <label for="id_kantor" class="text-primary fs-6 mb-1">
                                                        Nama Kantor
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control text-black" name="id_kantor">
                                                            <option value="" selected>Pilih Nama Kantor...</option>
                                                            <?php foreach ($kantor as $office) : ?>
                                                                <option value="<?= $office['id']; ?>"><?= $office['nama_kantor']; ?> - <?= $office['keterangan']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/admin'); ?>" class="btn btn-outline-secondary text-black">
                                                        Kembali
                                                    </a>
                                                    <button type="submit" class="btn btn-primary text-white">
                                                        Simpan
                                                    </button>
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
        </div>
    </div>
</div>
</div>