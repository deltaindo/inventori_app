<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="row tabel-produk">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="tab-content tab-content-basic">
                                <?= $this->session->flashdata('message'); ?>
                                <div class="row tabel-produk">
                                    <div class="col-lg-12 grid-margin stretch-card">
                                        <div class="card">
                                            <form method="post" action="<?= base_url('dashboard/simpan_mutasi_inventaris'); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Mutasi Inventaris
                                                    </h4>

                                                    <div class="modal-footer">
                                                        <a href="<?= base_url('dashboard/jurnal_inventaris_barang'); ?>" class="btn btn-outline-secondary text-black">
                                                            Kembali
                                                        </a>
                                                        <button type="submit" class="btn btn-primary text-white">
                                                            Submit
                                                        </button>
                                                    </div>

                                                    <label for="nama_karyawan" class="text-primary fs-6 mb-1">
                                                        Pengguna Baru
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="nama_karyawan">
                                                            <option selected>Pilih Karyawan...</option>
                                                            <?php foreach ($employees as $employee) : ?>
                                                                <option value="<?= $employee['id']; ?>"><?= $employee['nama_karyawan']; ?> - <?= $employee['nama_divisi']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="pengguna_lama" class="text-primary fs-6 mb-1">
                                                        [Tanggal Return Asset] Pengguna Lama
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="pengguna_lama">
                                                            <option selected>Pilih Pengguna Lama...</option>
                                                            <?php foreach ($items as $item) : ?>
                                                                <option value="<?= $item['id']; ?>">[<?= $item['tanggal_return']; ?>] <?= $item['nama_karyawan']; ?> - <?= $item['nama_barang'] . ' ' . $item['nama_merek']; ?> - <?= $item['spesifikasi']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="nama_inventaris" class="text-primary fs-6 mb-1">
                                                        [Tanggal Return Asset] Nama Inventaris
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="nama_inventaris">
                                                            <option selected>Pilih Nama Inventaris...</option>
                                                            <?php foreach ($items as $item) : ?>
                                                                <option value="<?= $item['id_jurnal_barang_masuk']; ?>">[<?= $item['tanggal_return']; ?>] - <?= $item['nama_barang'] . ' ' . $item['nama_merek']; ?> - <?= $item['spesifikasi']; ?></option>
                                                            <?php endforeach; ?>
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
                                                        <input type="number" class="form-control" name="jumlah_assets" placeholder="Inputkan Jumlah Asset">
                                                    </div>

                                                    <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                                        Keterangan [Kondisi Awal]
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea id="keterangan_masuk_barang" name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan Inventaris atau Kondisi Awal"></textarea>
                                                        <span class="text-small">
                                                            <i>
                                                                Contoh: Asset dalam kondisi layak digunakan.
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
        </div>
    </div>
</div>
</div>