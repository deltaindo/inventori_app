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
                                            <form method="post" action="<?= base_url('dashboard/simpan_jurnal_masuk_barang'); ?>">
                                                <div class="card-body">
                                                    <h4 class="card-title">
                                                        Tambah Jurnal Barang Masuk
                                                    </h4>

                                                    <label for="id_jurnal_barang" class="text-primary fs-6 mb-1">
                                                        Nama Barang [Merek]
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="id_jurnal_barang">
                                                            <option selected>Pilih Nama Barang...</option>
                                                            <?php foreach ($jurnal_barang as $item) : ?>
                                                                <option value="<?= $item['id']; ?>">
                                                                    <?= '[' . $item['kode_barang'] . '] ' . $item['nama_barang'] . ' ' . $item['nama_merek']; ?> <?= $item['keterangan']; ?> - <?= $item['nama_lokasi']; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>

                                                    <label for="jenis_pakai" class="text-primary fs-6 mb-1">
                                                        Jenis Pakai
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="jenis_pakai">
                                                            <option selected>Pilih Jenis Pakai...</option>
                                                            <option value="Normal">Normal</option>
                                                            <option value="Inventaris">Inventaris</option>
                                                            <option value="Alat Peraga">Alat Peraga</option>
                                                            <option value="Peminjaman">Peminjaman</option>
                                                        </select>
                                                    </div>

                                                    <label for="status_barang" class="text-primary fs-6 mb-1">
                                                        Status Barang
                                                    </label>
                                                    <div class="mb-3">
                                                        <select class="form-control" name="status_barang">
                                                            <option selected>Pilih Jenis Pakai...</option>
                                                            <option value="Baik">Baik</option>
                                                            <option value="Layak Pakai">Layak Pakai</option>
                                                            <option value="Rusak">Rusak</option>
                                                        </select>
                                                    </div>

                                                    <label for="tanggal_masuk" class="text-primary fs-6 mb-1">
                                                        Tanggal Masuk
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="date" class="form-control" name="tanggal_masuk" placeholder="Inputkan Tanggal">
                                                    </div>

                                                    <label for="jumlah_masuk" class="text-primary fs-6 mb-1">
                                                        Jumlah Masuk
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="jumlah_masuk" placeholder="Inputkan Jumlah Barang" autofocus>
                                                    </div>

                                                    <label for="harga_barang" class="text-primary fs-6 mb-1">
                                                        Harga Asset Satuan <b>[Rp]</b>
                                                    </label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="harga_barang" placeholder="Inputkan Harga Asset Satuan" autofocus>
                                                    </div>
                                                </div>

                                                <div class="card-footer d-flex justify-content-end">
                                                    <div class="d-flex">
                                                        <a href="<?= base_url('dashboard/jurnal_masuk_barang'); ?>" class="btn btn-outline-secondary text-black">
                                                            Kembali
                                                        </a>
                                                        <button type="submit" class="btn btn-primary text-white mx-1">
                                                            Simpan
                                                        </button>
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