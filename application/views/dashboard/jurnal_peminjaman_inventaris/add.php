<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-sm-12">
            <div class="row tabel-produk">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <form method="post" action="#">
                            <div class="card-body">
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="d-flex">
                                        <h4 class="card-title">
                                            Tambah Jurnal Peminjaman Inventaris
                                        </h4>
                                    </div>
                                    <div class="d-flex">
                                        <a href="<?= base_url('dashboard/jurnal_peminjaman_inventaris'); ?>" class="btn btn-outline-secondary text-black mx-1">
                                            Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary text-white">
                                            Simpan
                                        </button>
                                    </div>
                                </div>

                                <label for="nama_karyawan" class="text-primary fs-6 mb-1">
                                    Nama Karyawan
                                </label>
                                <div class="mb-1">
                                    <select class="form-control text-black" name="nama_karyawan">
                                        <option value="" selected>Pilih Karyawan...</option>
                                            <?php foreach ($employees as $employee) : ?>
                                                <option value="<?= $employee['id']; ?>"><?= $employee['nama_karyawan']; ?> - <?= $employee['nama_divisi']; ?></option>
                                            <?php endforeach; ?>
                                    </select>
                                </div>

                                <label for="nama_alat" class="text-primary fs-6 mb-1">
                                    Nama Inventaris [Tanggal Masuk Barang]
                                </label>
                                <div class="mb-1">
                                    <select class="form-control text-black" name="nama_alat">
                                        <option value="" selected>Pilih Alat Peserta...</option>
                                        <?php foreach ($items as $item) : ?>
                                            <option value="<?= $item['id']; ?>">[<?= $item['kode_barang']; ?>] <?= $item['tanggal_masuk']; ?> - <?= $item['nama_barang'] . ' ' . $item['nama_merek']; ?> - <?= $item['keterangan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <label for="tujuan_pinjam" class="text-primary fs-6 mb-1">
                                    Tujuan Peminjaman
                                </label>
                                <div class="mb-1">
                                    <input type="text" class="form-control" name="tujuan_pinjam" placeholder="Tujuan Peminjaman..." autofocus>
                                </div>

                                <label for="tanggal_pinjam" class="text-primary fs-6 mb-1">
                                    Tanggal Peminjaman
                                </label>
                                <div class="mb-1">
                                    <input type="date" class="form-control" name="tanggal_pinjam">
                                </div>

                                <label for="jumlah_pinjam" class="text-primary fs-6 mb-1">
                                    Jumlah Peminjaman
                                </label>
                                <div class="mb-1">
                                    <input type="number" class="form-control" name="jumlah_pinjam" placeholder="Jumlah Peminjaman...">
                                </div>

                                <label for="kondisi_pinjam" class="text-primary fs-6 mb-1">
                                    Keterangan
                                </label>
                                <div class="mb-1">
                                    <textarea id="keterangan_masuk_barang" name="kondisi_pinjam" cols="300" rows="10" class="form-control" style="height: 60px;" placeholder="Kondisi Inventaris saat dipinjam..."></textarea>
                                    <span class="text-small">
                                        <i>
                                            Contoh: Barang dalam keadaan layak digunakan.
                                        </i>
                                    </span>
                                </div>

                                <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                    Keterangan
                                </label>
                                <div class="mb-1">
                                    <textarea id="keterangan_masuk_barang" name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Keterangan Alat Perlengkapan Peserta"></textarea>
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