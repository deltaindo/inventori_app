<body>
    <!-- Fixed Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="<?= base_url('auth') ?>">Inventaris App</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?= base_url('auth') ?>">
                        Home
                        <span class="sr-only"></span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Content -->
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Detail Barang Masuk
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>Barang Masuk</th>
                        <td><?= $assets === null ? '-' : $assets['kode_barang_masuk']; ?></td>
                    </tr>
                    <tr>
                        <th>Kode Barang</th>
                        <td><?= $assets === null ? '-' : $assets['kode_barang']; ?></td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td><?= $assets === null ? '-' : $assets['nama_barang']; ?></td>
                    </tr>
                    <tr>
                        <th>Nama Merek</th>
                        <td><?= $assets === null ? '-' : $assets['nama_merek']; ?></td>
                    </tr>
                    <tr>
                        <th>Spesifikasi</th>
                        <td>
                            <?= $assets === null ? '-' : $assets['spesifikasi']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>
                            <?= $assets === null ? '-' : $assets['tanggal_masuk']; ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Jenis Pemakaian</th>
                        <td>
                            <?= $assets === null ? '-' : $assets['jenis_pakai']; ?>
                        </td>
                    </tr>
                </table>

            <div class="card mt-4">
                <div class="card-header bg-dark text-white">
                    History Detail Pengguna
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Nomor Urut</th>
                                <th>Nama Karyawan</th>
                                <th>Nama Divisi</th>
                                <th>Tanggal Assign</th>
                                <th>Catatan History</th>
                                <th>Jumlah Assets</th>
                                <th>Status Assets</th>
                                <th>Tanggal Return</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $item === null ? '-' : $item['nama_karyawan'] ?></td>
                                    <td><?= $item === null ? '-' : $item['nama_divisi'] ?></td>
                                    <td><?= $item === null ? '-' : $item['tanggal_assign'] ?></td>
                                    <td><?= $item === null ? '-' : $item['kondisi_asset'] ?></td>
                                    <td><?= $item === null ? '-' : $item['jumlah_assets'] . ' ' . $item['nama_satuan'] ?></td>
                                    <td><?= $item['status_assets'] === Null ? '-' : $item['status_assets'] ?></td>
                                    <td><?= $item['tanggal_return'] === Null ? '-' : $item['tanggal_return'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>