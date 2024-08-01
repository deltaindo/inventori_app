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
                                            <form method="post" action="<?= base_url('dashboard/simpan_karyawan'); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Tambah Data Karyawan
                                                    </h4>
                                                    <label for="nama_karyawan" class="text-primary fs-6 mb-1">
                                                        Nama Karyawan
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_karyawan" placeholder="Nama Karyawan" autofocus>
                                                    </div>

                                                    <label for="nama_divisi" class="text-primary fs-6 mb-1">
                                                        Nama Divisi
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control text-black" name="nama_divisi">
                                                            <option value="" selected>Pilih Nama Divisi...</option>
                                                            <?php foreach ($divisis as $divisi) : ?>
                                                                <option value="<?= $divisi['id']; ?>"><?= $divisi['nama_divisi']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/master_karyawan'); ?>" class="btn btn-outline-secondary text-black">
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