<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
                        <div>
                            <div class="btn-wrapper">
                                <a href="" class="btn btn-primary text-white me-0">
                                    <i class="ti-cloud-down"></i>
                                    Download Excel
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="#" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        Report History Inventaris
                                    </h4>
                                    <div class="overflow-visible mt-3">
                                        <table class="table table-hover" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No.
                                                    </th>
                                                    <th>
                                                        Kode Barang Masuk
                                                    </th>
                                                    <th>
                                                        Nama Barang
                                                    </th>
                                                    <th>
                                                        Nama Merek
                                                    </th>
                                                    <th>
                                                        Spesifikasi
                                                    </th>
                                                    <th>
                                                        Karyawan
                                                    </th>
                                                    <th>
                                                        Divisi
                                                    </th>
                                                    <th>
                                                        Tanggal Assign
                                                    </th>
                                                    <th>
                                                        Kondisi Awal
                                                    </th>
                                                    <th>
                                                        Jumlah Assets
                                                    </th>
                                                    <th>
                                                        Status Assets
                                                    </th>
                                                    <th>
                                                        Keterangan Inventaris
                                                    </th>
                                                    <th>
                                                        Jenis Pakai
                                                    </th>
                                                    <th>
                                                        Tanggal Return
                                                    </th>
                                                    <th>
                                                        Kondisi Akhir
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <?php foreach ($history_inventaris as $asset) : ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['kode_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_barang'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_merek'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['spesifikasi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_karyawan'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['nama_divisi'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['tanggal_assign'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['kondisi_awal'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['jumlah_assets'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['status_assets'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['keterangan_inventaris'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['jenis_pakai'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['tanggal_return'] == Null ? '-' : $asset['tanggal_return'] ?>
                                                        </td>
                                                        <td>
                                                            <?= $asset['kondisi_akhir'] == Null ? '-' : $asset['kondisi_akhir'] ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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