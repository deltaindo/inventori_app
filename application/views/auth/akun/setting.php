<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-10">
                <div class="row tabel-produk">
                    <div class="col-lg-10 grid-margin stretch-card">
                        <div class="card">
                            <div class="tab-content tab-content-basic">
                                <?= $this->session->flashdata('message'); ?>
                                <div class="row tabel-produk">
                                    <div class="col-lg-12 grid-margin stretch-card">
                                        <div class="card">
                                            <form method="post" action="<?= base_url('auth/update_akun'); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Update Akun Saya
                                                    </h4>

                                                    <label for="nama_akun" class="text-primary fs-6 mb-1">
                                                        Nama Akun
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_akun" placeholder="Nama Akun..." value="<?= $profil['Nama']; ?>" autocomplete="off" autofocus>
                                                    </div>

                                                    <label for="nama_lengkap" class="text-primary fs-6 mb-1">
                                                        Nama Lengkap
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_lengkap" placeholder="Nama Lengkap..." value="<?= $profil['nama_lengkap']; ?>" autocomplete="off">
                                                    </div>

                                                    <label for="email_akun" class="text-primary fs-6 mb-1">
                                                        Email Akun
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="email" class="form-control" name="email_akun" autocomplete="off" value="<?= $profil['email']; ?>" placeholder="Alamat Email...">
                                                    </div>

                                                    <label for="password_akun" class="text-primary fs-6 mb-1">
                                                        Password
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="password" class="form-control" name="password_akun" placeholder="Password Akun..." autocomplete="off">
                                                    </div>
                                                </div>

                                                <div class="card-footer d-flex justify-content-end">
                                                    <div class="d-flex">
                                                        <a href="<?= base_url('dashboard/report_stok_barang'); ?>" class="btn btn-outline-secondary text-black">
                                                            Kembali
                                                        </a>
                                                        <button type="submit" class="btn btn-primary text-white mx-1">
                                                            Update
                                                        </button>
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
        </div>
    </div>
</div>
</div>