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
                                            <form method="post" action="<?= base_url('dashboard/update_jurnal_masuk_barang/' . $jurnal_barang_masuk['id']); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Edit Jurnal Barang Masuk
                                                    </h4>

                                                    <label for="id_jurnal_barang" class="text-primary fs-6 mb-1">
                                                        Nama Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_jurnal_barang">
                                                            <option selected>Pilih Nama Barang...</option>
                                                            <?php foreach ($jurnal_barang as $jurnal_item) : ?>
                                                                <option value="<?= $jurnal_item['id'] ?>" <?= $jurnal_item['id'] == $jurnal_barang_masuk['id_jurnal_barang'] ? 'selected' : '' ?>>
                                                                    <?= '[' . $jurnal_item['kode_barang'] . '] ' . $jurnal_item['nama_barang'] . ' ' . $jurnal_item['nama_merek']; ?> - <?= $jurnal_item['nama_lokasi']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="jenis_pakai" class="text-primary fs-6 mb-1">
                                                        Jenis Pakai
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="jenis_pakai">
                                                            <option>Pilih Jenis Pakai...</option>
                                                            <option value="Normal" <?= $jurnal_barang_masuk['jenis_pakai'] == 'Normal' ? 'selected' : '' ?>>Normal</option>
                                                            <option value="Inventaris" <?= $jurnal_barang_masuk['jenis_pakai'] == 'Inventaris' ? 'selected' : '' ?>>Inventaris</option>
                                                            <option value="Peminjaman" <?= $jurnal_barang_masuk['jenis_pakai'] == 'Peminjaman' ? 'selected' : '' ?>>Peminjaman</option>
                                                        </select>
                                                    </div>

                                                    <label for="status_barang" class="text-primary fs-6 mb-1">
                                                        Status Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="status_barang">
                                                            <option selected>Pilih Jenis Pakai...</option>
                                                            <option value="Baik" <?= $jurnal_barang_masuk['status_barang'] == 'Baik' ? 'selected' : '' ?>>Baik</option>
                                                            <option value="Layak Pakai" <?= $jurnal_barang_masuk['status_barang'] == 'Layak Pakai' ? 'selected' : '' ?>>Layak Pakai</option>
                                                            <option value="Rusak" <?= $jurnal_barang_masuk['status_barang'] == 'Rusak' ? 'selected' : '' ?>>Rusak</option>
                                                        </select>
                                                    </div>

                                                    <label for="tanggal_masuk" class="text-primary fs-6 mb-1">
                                                        Tanggal Masuk
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="date" class="form-control" name="tanggal_masuk" value="<?= $jurnal_barang_masuk['tanggal_masuk']; ?>" placeholder="Inputkan Tanggal">
                                                    </div>

                                                    <label for="jumlah_masuk_lama" class="text-primary fs-6 mb-1">
                                                        Jumlah Masuk (Data Lama)
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="jumlah_masuk_lama" value="<?= $jurnal_barang_masuk['jumlah_masuk']; ?>" placeholder="Inputkan Jumlah Barang" readonly>
                                                    </div>

                                                    <label for="jumlah_masuk" class="text-primary fs-6 mb-1">
                                                        Jumlah Masuk (Data Baru)
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="jumlah_masuk_baru" placeholder="Inputkan Data Baru Jumlah Barang" autofocus>
                                                    </div>

                                                    <label for="harga_barang" class="text-primary fs-6 mb-1">
                                                        Harga Asset Satuan <b>[Rp]</b>
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="harga_barang" placeholder="Inputkan Harga Asset Satuan" value="<?= $jurnal_barang_masuk['harga_barang']; ?>">
                                                    </div>

                                                    <label for="keterangan" class="text-primary fs-6 mb-1">
                                                        Keterangan
                                                        [
                                                        <b>
                                                            Jangan Pakai Enter
                                                        </b>
                                                        ]
                                                    </label>
                                                    <div class="mb-3">
                                                        <textarea id="keterangan_masuk_barang" name="keterangan" cols="300" rows="10" class="form-control" style="height: 100px;" placeholder="Contoh: Ideapad Slim 3, Ryzen 5 6500U, Ram 8 GB, SSD 512 GB"><?= $jurnal_barang_masuk['keterangan']; ?></textarea>
                                                        <span class="text-small">
                                                            <i>
                                                                Jangan Pakai Enter
                                                            </i>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="<?= base_url('dashboard/jurnal_masuk_barang'); ?>" class="btn btn-outline-secondary text-black">
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