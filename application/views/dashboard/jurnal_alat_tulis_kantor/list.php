<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 mt-2">
                <div class="home-tab">
                    <div class="d-sm-flex align-items-right justify-content-between border-bottom">
                        <div class="btn-wrapper">
                            <a href="#" class="btn btn-success text-white me-0" type="button">
                                <i class="ti-cloud-down"></i>
                                Export Excel
                            </a>
                        </div>
                    </div>
                </div>
                <div class="row tabel-produk mt-2">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <form id="bulk-delete-form" action="#" method="post">
                                <div class="card-body table-responsive">
                                    <h4 class="card-title">
                                        Jurnal Alat Tulis Kantor
                                    </h4>
                                    <?= $this->session->userdata('pesan');  ?>
                                    <a href="#" class="btn btn-primary text-white">
                                        Tambah Data
                                    </a>
                                    <div class="overflow-visible mt-3">
                                        <table class="table table-hover" id="example">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        No.
                                                    </th>
                                                    <th>
                                                        Kode Alat Tulis Kantor
                                                    </th>
                                                    <th>
                                                        Kode Barang
                                                    </th>
                                                    <th>
                                                        Nama Barang
                                                    </th>
                                                    <th>
                                                        Merek
                                                    </th>
                                                    <th>
                                                        Spesifikasi
                                                    </th>
                                                    <th>
                                                        Nama Karyawan
                                                    </th>
                                                    <th>
                                                        Divisi
                                                    </th>
                                                    <th>
                                                        Tanggal Pengambilan
                                                    </th>
                                                    <th>
                                                        Jumlah Pengambilan
                                                    </th>
                                                    <th>
                                                        Keterangan
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                    <tr>
                                                        <td>
                                                            <?= $i++ ?>
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            
                                                        </td>
                                                        <td>
                                                            <a href="#" class="btn btn-outline-secondary text-black">
                                                                Edit
                                                            </a>
                                                        </td>
                                                    </tr>
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