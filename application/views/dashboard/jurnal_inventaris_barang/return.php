<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="tab-content tab-content-basic">
                                <?= $this->session->flashdata('message'); ?>
                                <div class="row tabel-produk">
                                    <div class="col-lg-12 grid-margin stretch-card">
                                        <div class="card">
                                            <form method="post" action="<?= base_url('dashboard/update_return_inventaris/' . $items['id']); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Return Inventaris
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
                                                        Nama Karyawan
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="nama_karyawan" value="<?= $items['nama_karyawan']; ?>" disabled>
                                                    </div>

                                                    <label for="nama_inventaris" class="text-primary fs-6 mb-1">
                                                        Nama Inventaris [Tanggal Masuk Barang]
                                                    </label>

                                                    <div class="mb-3">
                                                        <textarea name="spesifikasi" class="form-control" style="height: 100px;" readonly>[<?= $items['kode_barang']; ?>] <?= $items['tanggal_masuk']; ?> - <?= $items['nama_barang'] . ' ' . $items['nama_merek']; ?> - <?= $items['spesifikasi']; ?></textarea>
                                                        <input type="text" class="form-control" name="id_jurnal_barang_masuk" value="<?= $items['id_jurnal_barang_masuk']; ?>" hidden>
                                                    </div>

                                                    <label for="tanggal_assign" class="text-primary fs-6 mb-1">
                                                        Tanggal Assign
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="date" class="form-control" name="tanggal_assign" value="<?= $items['tanggal_assign']; ?>" disabled>
                                                    </div>

                                                    <label for="tanggal_return" class="text-primary fs-6 mb-1">
                                                        Tanggal Return
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="date" class="form-control" name="tanggal_return">
                                                    </div>

                                                    <label for="kondisi_asset" class="text-primary fs-6 mb-1">
                                                        Kondisi Asset
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="kondisi_asset">
                                                            <option value="" selected>Pilih Kondisi Asset...</option>
                                                            <option value="Aktif">Aktif</option>
                                                            <option value="Tidak Aktif">Tidak Aktif</option>
                                                        </select>

                                                        <span class="text-small">
                                                            <i>
                                                                Jika Asset sudah dikembalikan / Return maka pilih "Aktif" .
                                                            </i>
                                                            <br>
                                                            <i>
                                                                Jika Asset sudah tidak layak pakai maka pilih "Tidak Aktif" .
                                                            </i>
                                                        </span>
                                                    </div>

                                                    <label for="keterangan_barang" class="text-primary fs-6 mb-1">
                                                        Keterangan [Kondisi Akhir]
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea id="keterangan_masuk_barang" name="keterangan_barang" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Inputkan Keterangan Inventaris atau Kondisi Akhir"></textarea>
                                                        <span class="text-small">
                                                            <i>
                                                                Contoh: Asset dalam kondisi layak digunakan.
                                                            </i>
                                                        </span>
                                                    </div>

                                                    <label for="status_assets" class="text-primary fs-6 mb-1">
                                                        Status Asset
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="status_assets" value="<?= $items['status_assets']; ?>" disabled>
                                                    </div>

                                                    <label for="jumlah_assets" class="text-primary fs-6 mb-1">
                                                        Jumlah Assets
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="jumlah_assets" value="<?= $items['jumlah_assets']; ?>" readonly>
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