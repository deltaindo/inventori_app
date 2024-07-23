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
                                            <form method="post" action="<?= base_url('dashboard/update_lokasi/' . $lokasi['id']); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Edit Data Lokasi
                                                    </h4>
                                                    <label for="nama_lokasi" class="text-primary fs-6 mb-1">
                                                        Nama Lokasi
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_lokasi" value="<?= $lokasi['nama_lokasi']; ?>" placeholder="Inputkan Nama lokasi" autofocus>
                                                    </div>

                                                    <label for="id_kantor" class="text-primary fs-6 mb-1">
                                                        Nama Kantor
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_kantor">
                                                            <option selected>Pilih Nama Kantor...</option>
                                                            <?php foreach ($kantor as $office) : ?>
                                                                <option value="<?= $office['id'] ?>" <?= $office['id'] == $lokasi['id_kantor'] ? 'selected' : '' ?>>
                                                                    <?= $office['nama_kantor'] ?> - <?= $office['keterangan'] ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="keterangan_lokasi" class="text-primary fs-6 mb-1">
                                                        Keterangan
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea name="keterangan_lokasi" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan Lokasi"><?= $lokasi['keterangan']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/master_lokasi'); ?>" class="btn btn-outline-secondary text-black">
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