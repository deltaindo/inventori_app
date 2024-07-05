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
                                            <form method="post" action="<?= base_url('dashboard/simpan_barang'); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Tambah Data Barang
                                                    </h4>
                                                    <label for="nama_barang" class="text-primary fs-6 mb-1">
                                                        Nama Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_barang" placeholder="Inputkan Nama Barang" autofocus>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/master_barang'); ?>" class="btn btn-outline-secondary text-black">
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