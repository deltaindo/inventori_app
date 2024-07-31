<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="row tabel-produk">
                    <div class="col-lg-8 grid-margin stretch-card">
                        <div class="card">
                            <form method="post" action="<?= base_url('dashboard/update_jurnal_barang/' . $jurnal_barang['id']); ?>">
                                <div class="card-body">
                                    <h4 class="card-title">

                                    </h4>

                                    <div class="card-footer d-flex justify-content-between">
                                        <div class="d-flex">
                                            <h4 class="card-title">
                                                Edit Jurnal Barang
                                            </h4>
                                        </div>
                                        <div class="d-flex">
                                            <a href="<?= base_url('dashboard/jurnal_barang'); ?>" class="btn btn-outline-secondary text-black">
                                                Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary text-white mx-1">
                                                Edit
                                            </button>
                                        </div>
                                    </div>

                                    <label for="id_barang" class="text-primary fs-6 mb-1">
                                        Nama Barang
                                    </label>
                                    <div class="mb-3">
                                        <select class="form-control text-black" name="id_barang">
                                            <option value="" selected>Pilih Nama Barang...</option>
                                            <?php foreach ($barang as $items) : ?>
                                                <option value="<?= $items['id'] ?>" <?= $items['id'] == $jurnal_barang['id_barang'] ? 'selected' : '' ?>>
                                                    <?= $items['nama_barang'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="id_merek" class="text-primary fs-6 mb-1">
                                        Merek Barang
                                    </label>
                                    <div class="mb-3">
                                        <select class="form-control text-black" name="id_merek">
                                            <option value="" selected>Pilih Merek Barang...</option>
                                            <?php foreach ($merek as $brand) : ?>
                                                <option value="<?= $brand['id'] ?>" <?= $brand['id'] == $jurnal_barang['id_merek'] ? 'selected' : '' ?>>
                                                    <?= $brand['nama_merek'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="id_satuan" class="text-primary fs-6 mb-1">
                                        Satuan Barang
                                    </label>
                                    <div class="mb-3">
                                        <select class="form-control text-black" name="id_satuan">
                                            <option value="" selected>Pilih Satuan Barang...</option>
                                            <?php foreach ($satuan as $unit) : ?>
                                                <option value="<?= $unit['id'] ?>" <?= $unit['id'] == $jurnal_barang['id_satuan'] ? 'selected' : '' ?>>
                                                    <?= $unit['nama_satuan'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="id_lokasi" class="text-primary fs-6 mb-1">
                                        Lokasi Barang
                                    </label>
                                    <div class="mb-3">
                                        <select class="form-control text-black" name="id_lokasi">
                                            <option value="" selected>Pilih Lokasi Barang...</option>
                                            <?php foreach ($lokasi as $location) : ?>
                                                <option value="<?= $location['id'] ?>" <?= $location['id'] == $jurnal_barang['id_lokasi'] ? 'selected' : '' ?>>
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
                                        <select class="form-control text-black" name="id_kategori">
                                            <option value="" selected>Pilih Kategori...</option>
                                            <?php foreach ($kategori as $category) : ?>
                                                <option value="<?= $category['id'] ?>" <?= $category['id'] == $jurnal_barang['id_kategori'] ? 'selected' : '' ?>>
                                                    <?= $category['nama_kategori'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                        Keterangan
                                        [
                                        <b>
                                            Jangan Pakai Enter
                                        </b>
                                        ]
                                    </label>
                                    <div class="mb-3">
                                        <textarea id="keterangan_masuk_barang" name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 75px;" placeholder="Contoh: Ideapad Slim 3, Ryzen 5 6500U, Ram 8 GB, SSD 512 GB"><?= $jurnal_barang['keterangan']; ?></textarea>
                                        <span class="text-small">
                                            <i>
                                                Jangan Pakai Enter
                                            </i>
                                        </span>
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