<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="home-tab">
                    <div class="tab-content tab-content-basic">
                        <?= $this->session->flashdata('message'); ?>
                        <div class="row tabel-produk mt-2">
                            <div class="col-lg-8 grid-margin stretch-card">
                                <div class="card">
                                    <form method="post" action="<?= base_url('dashboard/update_kantor/' . $kantor['id']); ?>">
                                        <div class="card-body">
                                            <h4 class="card-title">
                                                Edit Data Kantor
                                            </h4>
                                            <label for="nama_kantor" class="text-primary fs-6 mb-1">
                                                Nama Kantor
                                            </label>
                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="nama_kantor" value="<?= $kantor['nama_kantor']; ?>" placeholder="Inputkan Nama Kantor" autofocus>
                                            </div>
                                            <label for="keterangan_kantor" class="text-primary fs-6 mb-1">
                                                Keterangan
                                            </label>
                                            <div class="mb-3">
                                                <textarea name="keterangan_kantor" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan Kantor"><?= $kantor['keterangan']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?= base_url('dashboard/master_kantor'); ?>" class="btn btn-outline-secondary text-black">
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