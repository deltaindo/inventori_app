<div class="main-panel">
    <div class="content-wrapper">
        <div class="col-sm-12">
            <div class="row tabel-produk">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <form method="post" action="<?= base_url('dashboard/simpan_jurnal_peminjaman_inventaris'); ?>">
                            <div class="card-body">
                                <div class="card-footer d-flex justify-content-between">
                                    <div class="d-flex">
                                        <h4 class="card-title">
                                            Pengembalian Barang Pinjaman Inventaris
                                        </h4>
                                    </div>
                                    <div class="d-flex">
                                        <a href="<?= base_url('dashboard/jurnal_peminjaman_inventaris'); ?>" class="btn btn-outline-secondary text-black mx-1">
                                            Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary text-white">
                                            Dikembalikan
                                        </button>
                                    </div>
                                </div>

                                <label for="nama_karyawan" class="text-primary fs-6 mb-1">
                                    Nama Karyawan
                                </label>
                                <div class="mb-1">
                                    <input type="text" class="form-control" name="nama_karyawan" disabled>
                                </div>

                                <label for="nama_alat" class="text-primary fs-6 mb-1">
                                    Nama Inventaris [Tanggal Masuk Barang]
                                </label>
                                <div class="mb-1">
                                    <input type="text" class="form-control" name="nama_alat" disabled>
                                </div>

                                <label for="tujuan_pinjam" class="text-primary fs-6 mb-1">
                                    Tujuan Peminjaman
                                </label>
                                <div class="mb-1">
                                    <input type="text" class="form-control" name="tujuan_pinjam" value="<?= $pinjam_inventaris['tujuan_pinjam']; ?>" disabled>
                                </div>

                                <div class="d-flex justify-content-start">
                                    <div class="d-flex mx-1">
                                        <div class="mb-1">
                                            <label for="tanggal_pinjam" class="text-primary fs-6 mb-1">
                                                Tanggal Peminjaman
                                            </label>
                                            <input type="date" class="form-control" name="tanggal_pinjam" value="<?= $pinjam_inventaris['tanggal_pinjam']; ?>" disabled>
                                        </div>
                                    </div>
                                    <div class="d-flex mx-1">
                                        <div class="mb-1">
                                            <label for="jumlah_pinjam" class="text-primary fs-6 mb-1">
                                                Jumlah Peminjaman
                                            </label>
                                            <input type="number" class="form-control" name="jumlah_pinjam" value="<?= $pinjam_inventaris['jumlah_pinjam']; ?>" disabled>
                                        </div>
                                    </div>
                                </div>

                                <label for="kondisi_pinjam" class="text-primary fs-6 mb-1">
                                    Kondisi Pinjam
                                </label>
                                <div class="mb-1">
                                    <textarea id="keterangan_masuk_barang" name="kondisi_pinjam" cols="300" rows="10" class="form-control" style="height: 45px;" placeholder="Kondisi Inventaris saat dipinjam..." disabled><?= $pinjam_inventaris['kondisi_pinjam']; ?></textarea>
                                </div>

                                <div class="d-flex justify-content-start">
                                    <div class="d-flex mx-1">
                                        <div class="mb-1">
                                            <label for="tanggal_kembali" class="text-primary fs-6 mb-1">
                                                Tanggal Kembali
                                            </label>
                                            <input type="date" class="form-control" name="tanggal_kembali">
                                        </div>
                                    </div>
                                    <div class="d-flex mx-1">
                                        <div class="mb-1">
                                            <label for="kondisi_kembali" class="text-primary fs-6 mb-1">
                                                Keterangan Tambahan
                                            </label>
                                            <div class="mb-1">
                                                <textarea id="keterangan_masuk_barang" name="kondisi_kembali" cols="300" rows="10" class="form-control" style="height: 60px;" placeholder="Kondisi Kembali..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <label for="keterangan" class="text-primary fs-6 mb-1">
                                    Keterangan Tambahan
                                </label>
                                <div class="mb-1">
                                    <textarea id="keterangan_masuk_barang" name="keterangan" cols="300" rows="10" class="form-control" style="height: 45px;" placeholder="Keterangan Tambahan..." disabled><?= $pinjam_inventaris['keterangan']; ?></textarea>
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