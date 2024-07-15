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
                                            <form method="post" action="#">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Edit Jurnal Barang Masuk
                                                    </h4>

                                                    <label for="id_jurnal_barang" class="text-primary fs-6 mb-1">
                                                        Nama Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_jurnal_barang">
                                                            <option selected>Pilih Nama Barang...</option>
                                                            <?php foreach ($kategori as $category) : ?>
                                                                <option value="<?= $category['id'] ?>" <?= $category['id'] == $jurnal_barang['id_kategori'] ? 'selected' : '' ?>>
                                                                    <?= $category['nama_kategori'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="tanggal_masuk" class="text-primary fs-6 mb-1">
                                                        Tanggal Masuk
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="date" class="form-control" name="tanggal_masuk" placeholder="Inputkan Tanggal">
                                                    </div>

                                                    <label for="jumlah_masuk" class="text-primary fs-6 mb-1">
                                                        Jumlah Masuk
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="jumlah_masuk" placeholder="Inputkan Jumlah Barang" autofocus>
                                                    </div>

                                                    <label for="keterangan" class="text-primary fs-6 mb-1">
                                                        Keterangan
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea name="keterangan" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/jurnal_masuk_barang'); ?>" class="btn btn-outline-secondary text-black">
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