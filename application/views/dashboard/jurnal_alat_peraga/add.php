<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-sm-12">
            <div class="row tabel-produk">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form method="post" action="<?= base_url('dashboard/simpan_jurnal_alat_peraga'); ?>">
                                <div class="card-body">
                                    <div class="card-footer d-flex justify-content-between">
                                        <div class="d-flex">
                                            <h4 class="card-title">
                                                Tambah Jurnal Alat Peraga
                                            </h4>
                                        </div>
                                        <div class="d-flex">
                                            <a href="<?= base_url('dashboard/jurnal_alat_peraga'); ?>" class="btn btn-outline-secondary text-black mx-1">
                                                Kembali
                                            </a>
                                            <button type="submit" class="btn btn-primary text-white">
                                                Simpan
                                            </button>
                                        </div>
                                    </div>

                                    <label for="nama_alat" class="text-primary fs-6 mb-1">
                                        Nama Alat Peraga / Praktik [Tanggal Masuk Barang]
                                    </label>
                                    <div class="mb-1">
                                        <select class="form-control" name="nama_alat">
                                            <option value="" selected>Pilih Alat Peraga...</option>
                                            <?php foreach ($items as $item) : ?>
                                                <option value="<?= $item['id']; ?>">[<?= $item['kode_barang']; ?>] <?= $item['tanggal_masuk']; ?> - <?= $item['nama_barang'] . ' ' . $item['nama_merek']; ?> - <?= $item['keterangan']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="alokasi_tujuan" class="text-primary fs-6 mb-1">
                                        Alokasi Tujuan
                                    </label>
                                    <div class="mb-1">
                                        <input type="text" class="form-control" name="alokasi_tujuan" placeholder="Inputkan Alokasi Tujuan. Misal : Nama Ruangan atau Nama Penanggung Jawab" autofocus>
                                    </div>

                                    <label for="tanggal_beli" class="text-primary fs-6 mb-1">
                                        Tanggal Beli
                                    </label>
                                    <div class="mb-1">
                                        <input type="date" class="form-control" name="tanggal_beli">
                                    </div>

                                    <label for="tanggal_kalibrasi" class="text-primary fs-6 mb-1">
                                        Tanggal Kalibrasi
                                    </label>
                                    <div class="mb-1">
                                        <input type="date" class="form-control" name="tanggal_kalibrasi">
                                    </div>

                                    <label for="masa_berlaku_kalibrasi" class="text-primary fs-6 mb-1">
                                        Masa Berlaku Kalibrasi
                                    </label>
                                    <div class="mb-1">
                                        <input type="date" class="form-control" name="masa_berlaku_kalibrasi">
                                    </div>

                                    <label for="jumlah_alat" class="text-primary fs-6 mb-1">
                                        Jumlah
                                    </label>
                                    <div class="mb-1">
                                        <input type="number" class="form-control" name="jumlah_alat" placeholder="Inputkan Jumlah Alat Peraga atau Praktik">
                                    </div>

                                    <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                        Keterangan
                                    </label>
                                    <div class="mb-1">
                                        <textarea id="keterangan_masuk_barang" name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan Alat Peraga"></textarea>
                                        <span class="text-small">
                                            <i>
                                                Contoh: Alat Peraga atau Praktik dalam kondisi layak digunakan.
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