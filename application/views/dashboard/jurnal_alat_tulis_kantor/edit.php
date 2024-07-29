<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-sm-12">
            <div class="row tabel-produk">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <form method="post" action="<?= base_url('dashboard/update_jurnal_alat_tulis_kantor/' . $alat_tulis_kantor['id']); ?>">
                            <div class="card-body">
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="d-flex">
                                        <h4 class="card-title">
                                            Edit Jurnal Alat Tulis Kantor
                                        </h4>
                                    </div>
                                    <div class="d-flex">
                                        <a href="<?= base_url('dashboard/jurnal_alat_tulis_kantor'); ?>" class="btn btn-outline-secondary text-black mx-1">
                                            Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary text-white">
                                            Edit
                                        </button>
                                    </div>
                                </div>

                                <label for="nama_karyawan" class="text-primary fs-6 mb-1">
                                    Nama Karyawan
                                </label>
                                <div class="mb-1">
                                    <select class="form-control" name="nama_karyawan">
                                        <option value="" selected>Pilih Karyawan...</option>
                                            <?php foreach ($employees as $employee) : ?>
                                            <option value="<?= $employee['id']; ?>" <?= $employee['id'] == $alat_tulis_kantor['id_karyawan'] ? 'selected' : '' ?>>
                                                <?= $employee['nama_karyawan']; ?> - <?= $employee['nama_divisi']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <label for="nama_alat" class="text-primary fs-6 mb-1">
                                    Nama Alat Tulis Kantor [Tanggal Masuk Barang]
                                </label>
                                <div class="mb-1">
                                    <select class="form-control" name="nama_alat">
                                        <option value="" selected>Pilih Alat Peserta...</option>
                                        <?php foreach ($items as $item) : ?>
                                            <option value="<?= $item['id']; ?>" <?= $item['id'] == $alat_tulis_kantor['id_jurnal_barang_masuk'] ? 'selected' : '' ?>>
                                                [<?= $item['kode_barang']; ?>] <?= $item['tanggal_masuk']; ?> - <?= $item['nama_barang'] . ' ' . $item['nama_merek']; ?> - <?= $item['keterangan']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <label for="tanggal_pengambilan" class="text-primary fs-6 mb-1">
                                    Tanggal Pengambilan
                                </label>
                                <div class="mb-1">
                                    <input type="date" class="form-control" name="tanggal_pengambilan" value="<?= $alat_tulis_kantor['tanggal_pengambilan']; ?>">
                                </div>

                                <label for="jumlah_pengambilan_lama" class="text-primary fs-6 mb-1">
                                    Jumlah Pengambilan (Data Lama)
                                </label>
                                <div class="mb-1">
                                    <input type="number" class="form-control" name="jumlah_pengambilan_lama" value="<?= $alat_tulis_kantor['jumlah_pengambilan']; ?>" readonly>
                                </div>

                                <label for="jumlah_pengambilan_baru" class="text-primary fs-6 mb-1">
                                    Jumlah Pengambilan (Data Baru)
                                </label>
                                <div class="mb-1">
                                    <input type="number" class="form-control" name="jumlah_pengambilan_baru" placeholder="Jumlah Pengambilan (Data Baru)" autofocus>
                                </div>

                                <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                    Keterangan
                                </label>
                                <div class="mb-1">
                                    <textarea id="keterangan_masuk_barang" name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Keterangan Alat Tulis Kantor"><?= $alat_tulis_kantor['keterangan']; ?></textarea>
                                    <span class="text-small">
                                        <i>
                                            Contoh: Buku Tulis digunakan untuk keperluan kerja.
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