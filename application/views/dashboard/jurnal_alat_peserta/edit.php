<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-sm-12">
            <div class="row tabel-produk">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <form method="post" action="<?= base_url('dashboard/update_jurnal_alat_peserta/' . $alat_peserta['id']); ?>">
                            <div class="card-body">
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="d-flex">
                                        <h4 class="card-title">
                                            Edit Jurnal Alat Peserta
                                        </h4>
                                    </div>
                                    <div class="d-flex">
                                        <a href="<?= base_url('dashboard/jurnal_alat_peserta'); ?>" class="btn btn-outline-secondary text-black mx-1">
                                            Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary text-white">
                                            Edit
                                        </button>
                                    </div>
                                </div>

                                <label for="nama_alat" class="text-primary fs-6 mb-1">
                                    Nama Perlengkapan / Alat Peserta [Tanggal Masuk Barang]
                                </label>
                                <div class="mb-1">
                                    <select class="form-control text-black" disabled>
                                        <option value="" selected>Pilih Alat Peserta...</option>
                                        <?php foreach ($items as $item) : ?>
                                            <option value="<?= $item['id']; ?>" <?= $item['id'] == $alat_peserta['id_jurnal_barang_masuk'] ? 'selected' : '' ?>>
                                                [<?= $item['kode_barang']; ?>] <?= $item['tanggal_masuk']; ?> - <?= $item['nama_barang'] . ' ' . $item['nama_merek']; ?> - <?= $item['keterangan']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="text" class="form-control" name="nama_alat" value="<?= $alat_peserta['id_jurnal_barang_masuk']; ?>" hidden>
                                </div>

                                <label for="tujuan_barang_keluar" class="text-primary fs-6 mb-1">
                                    Tujuan Barang Keluar
                                </label>
                                <div class="mb-1">
                                    <input type="text" class="form-control" name="tujuan_barang_keluar" value="<?= $alat_peserta['tujuan_barang_keluar']; ?>" placeholder="Tujuan Barang Keluar. Misal : Nama Pelatihan dan Nama Client..." autofocus>
                                </div>

                                <label for="tanggal_keluar" class="text-primary fs-6 mb-1">
                                    Tanggal Keluar
                                </label>
                                <div class="mb-1">
                                    <input type="date" class="form-control" name="tanggal_keluar" value="<?= $alat_peserta['tanggal_keluar']; ?>">
                                </div>

                                <label for="jumlah_lama" class="text-primary fs-6 mb-1">
                                    Jumlah (Data Lama)
                                </label>
                                <div class="mb-1">
                                    <input type="number" class="form-control" name="jumlah_lama" value="<?= $alat_peserta['jumlah']; ?>" readonly>
                                </div>

                                <label for="jumlah_baru" class="text-primary fs-6 mb-1">
                                    Jumlah (Data Baru)
                                </label>
                                <div class="mb-1">
                                    <input type="number" class="form-control" name="jumlah_baru" placeholder="Jumlah Alat Perlengkapan Peserta (Data Baru)...">
                                    <span class="text-small">
                                        <i>
                                            * Tidak Wajib diisi. Jika akan mengubah Jumlah Perlengkapan Peserta, silahkan inputkan data baru.
                                        </i>
                                    </span>
                                </div>

                                <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                    Keterangan
                                </label>
                                <div class="mb-1">
                                    <textarea id="keterangan_masuk_barang" name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Keterangan Alat Perlengkapan Peserta..."><?= $alat_peserta['keterangan']; ?></textarea>
                                    <span class="text-small">
                                        <i>
                                            Contoh: Buku Agenda digunakan untuk keperluan mencatat materi.
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