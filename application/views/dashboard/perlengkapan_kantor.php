<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-12">
        <div class="home-tab">
          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active ps-0 inventori" id="home-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">
                  PERLENGKAPAN KANTOR
                </a>
              </li>
              <li class="nav-item ml-auto">
                <p class="nav-link text-primary">
                  Total Seluruh Aset : <?= ($total == 0) ? '0' : 'Rp ' . number_format($total, 0, ',', '.'); ?>
                </p>
              </li>
              <li class="nav-item ml-auto">
                <p class="nav-link text-primary">
                  Total Alat : <?= ($total_alat == 0) ? '0' : $total_alat; ?>
                </p>
              </li>
            </ul>
            <div>
              <div class="btn-wrapper">
                <a href="#" class="btn btn-otline-dark"><i class="icon-printer"></i>
                  Print
                </a>
                <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  <i class="icon-download"></i>
                  Import
                </a>
              </div>
            </div>
          </div>
          <div class="tab-content tab-content-basic">
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"></div>
            <?= $this->session->flashdata('pesan'); ?>
            <div class="row tabel-produk mt-2">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">
                      Daftar <?= $tittle; ?> <?= ($this->kantor == 1) ? 'DIP' : 'DNP'; ?>
                    </h4>
                    <form action="<?= base_url('dashboard/opname_kantor'); ?>" method="post">
                      <button class="btn btn-primary btn-sm text-white" type="submit">
                        Stok Opname
                      </button>
                      <a href="tambah_produk.html" class="btn btn-danger text-white" id="hapus-kantor" data-url="<?= base_url('dashboard/hapus_kantor') ?>">
                        Hapus
                      </a>
                      <div class="table-responsive">
                        <table class="table table-hover" id="example">
                          <thead>
                            <tr>
                              <th>
                                <input type="checkbox" id="check-all" class="form-check-input check" aria-checked="false" /><i class="input-helper"></i>
                              </th>
                              <th>
                                Kode Barang
                              </th>
                              <th>
                                Nama Barang
                              </th>
                              <th>
                                Jumlah
                              </th>
                              <th>
                                Lokasi Barang
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php foreach ($produk as $p) : ?>
                              <tr>
                                <td>
                                  <input type="checkbox" id="check" name="id[]" value="<?= $p['kode_barang']; ?>" class="form-check-input check" aria-checked="false" />
                                  <i class="input-helper"></i>
                                </td>
                                <td><?= $p['kode_barang'] ?></td>
                                <td><?= $p['nama_barang'] ?></td>
                                <td><?= $p['jumlah'] ?></td>
                                <td><?= $p['lokasi_barang'] ?></td>
                              </tr>
                            <?php endforeach; ?>
                          </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- content-wrapper ends -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">
            Import Excel
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="<?= base_url('dashboard/import'); ?>" method="post" enctype="multipart/form-data">
            <label for="exampleInputEmail1" class="form-label">
              Import File
            </label>
            <input type="file" name="file" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp">
            <button type="submit" class="btn btn-primary btn-sm mt-3">
              <i class="icon-download"></i>
              Import
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>