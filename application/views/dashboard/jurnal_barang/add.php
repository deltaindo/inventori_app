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
                                            <form method="post" action="<?= base_url('dashboard/simpan_jurnal_barang'); ?>" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Tambah Jurnal Barang
                                                    </h4>

                                                    <label for="id_barang" class="text-primary fs-6 mb-1">
                                                        Nama Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_barang">
                                                            <option selected>Pilih Nama Barang...</option>
                                                            <?php foreach ($barang as $item) : ?>
                                                                <option value="<?= $item['id']; ?>">
                                                                    <?= $item['nama_barang']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="id_merek" class="text-primary fs-6 mb-1">
                                                        Merek Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_merek">
                                                            <option selected>Pilih Merek Barang...</option>
                                                            <?php foreach ($merek as $brand) : ?>
                                                                <option value="<?= $brand['id']; ?>">
                                                                    <?= $brand['nama_merek']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="id_satuan" class="text-primary fs-6 mb-1">
                                                        Satuan Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_satuan">
                                                            <option selected>Pilih Satuan Barang...</option>
                                                            <?php foreach ($satuan as $satuan_item) : ?>
                                                                <option value="<?= $satuan_item['id']; ?>">
                                                                    <?= $satuan_item['nama_satuan']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="id_lokasi" class="text-primary fs-6 mb-1">
                                                        Lokasi Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_lokasi">
                                                            <option selected>Pilih Satuan Barang...</option>
                                                            <?php foreach ($lokasi as $location) : ?>
                                                                <option value="<?= $location['id']; ?>">
                                                                    <?= $location['nama_lokasi']; ?>
                                                                    <?= $location['keterangan'] != null ? ' - ' . $location['keterangan'] : '' ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="id_kategori" class="text-primary fs-6 mb-1">
                                                        Kategori
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_kategori">
                                                            <option selected>Pilih Kategori...</option>
                                                            <?php foreach ($kategori as $category) : ?>
                                                                <option value="<?= $category['id']; ?>">
                                                                    <?= $category['nama_kategori']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="foto_barang" class="text-primary fs-6 mb-1">
                                                        Foto
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="file" name="foto_barang" class="form-control-sm">
                                                    </div>

                                                    <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                                        Keterangan
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan Barang"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/jurnal_barang'); ?>" class="btn btn-outline-secondary text-black">
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