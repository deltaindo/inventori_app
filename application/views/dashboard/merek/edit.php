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
                                            <form method="post" action="<?= base_url('dashboard/update_merek/' . $merek['id']); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Edit Data Merek
                                                    </h4>
                                                    <label for="nama_merek" class="text-primary fs-6 mb-1">
                                                        Nama Merek
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_merek" placeholder="Nama Merek..." value="<?= $merek['nama_merek']; ?>" autofocus>
                                                    </div>
                                                    <label for="keterangan_merek" class="text-primary fs-6 mb-1">
                                                        Keterangan Merek
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea name="keterangan_merek" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Keterangan Merek..."><?= $merek['keterangan']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/master_merek'); ?>" class="btn btn-outline-secondary text-black">
                                                        Kembali
                                                    </a>
                                                    <button type="submit" class="btn btn-primary text-white">
                                                        Edit
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