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
                                            <form method="post" action="<?= base_url('dashboard/simpan_inventaris_barang'); ?>" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Tambah Jurnal Inventaris
                                                    </h4>

                                                    <label for="nama_karyawan" class="text-primary fs-6 mb-1">
                                                        Nama Karyawan
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="nama_karyawan">
                                                            <option selected>Pilih Nama Karyawan...</option>
                                                        </select>
                                                    </div>

                                                    <label for="nama_barang" class="text-primary fs-6 mb-1">
                                                        Nama Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="nama_barang">
                                                            <option selected>Pilih Nama Barang...</option>
                                                        </select>
                                                    </div>

                                                    <label for="tanggal_assign" class="text-primary fs-6 mb-1">
                                                        Tanggal Assign
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="date" class="form-control" name="tanggal_assign" placeholder="Inputkan Tanggal">
                                                    </div>

                                                    <label for="status_assets" class="text-primary fs-6 mb-1">
                                                        Status Asset
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="status_assets">
                                                            <option selected>Pilih Status Asset...</option>
                                                            <option value="Baru">Baru</option>
                                                            <option value="Bekas">Bekas</option>
                                                        </select>
                                                    </div>

                                                    <label for="jumlah_assets" class="text-primary fs-6 mb-1">
                                                        Jumlah Assets
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="jumlah_assets" placeholder="Inputkan Tanggal">
                                                    </div>

                                                    <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                                        Keterangan
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan Inventaris"></textarea>
                                                        <span class="text-small">
                                                            <i>
                                                                Contoh: Asset dalam kondisi layak digunakan.
                                                            </i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/jurnal_inventaris_barang'); ?>" class="btn btn-outline-secondary text-black">
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