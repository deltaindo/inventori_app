<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-sm-12">
        <div class="home-tab">
          <div class="d-sm-flex align-items-center justify-content-between border-bottom">
            <ul class="nav nav-tabs" role="tablist">
              <li class="nav-item">
                <a class="nav-link active ps-0 inventori" href="<?= base_url('dashboard/perlengkapan_peserta'); ?>" role="tab" aria-controls="overview" aria-selected="true">
                  Perlengkapan Peserta
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link active ps-0 inventori" href="<?= base_url('dashboard/perlengkapan_atk'); ?>" role="tab" aria-controls="overview" aria-selected="true">
                  Perlengkapan ATK
                </a>
              </li>
              <li class="nav-item ml-auto">
                <p class="nav-link text-primary">
                  Total Seluruh Aset : <?= ($total_assets == 0) ? '0' : 'Rp ' . number_format($total_assets, 0, ',', '.'); ?>
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
                <a href="<?php echo base_url('dashboard/download_excel') . '?keterangan=' . $this->input->post('keterangan') . '&kategori=peserta'; ?>" class="btn btn-otline-dark"><i class="icon-printer"></i> Print</a>
                <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="icon-download"></i>Import</a>
              </div>
            </div>
          </div>
          <div class="tab-content tab-content-basic">
            <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview"></div>
            <div class="row">
              <div class="col-lg-4 info-pengeluaran">
                <div class="card">
                  <div class="card-body">
                    <form action="<?= base_url('dashboard/perlengkapan_peserta'); ?>" method="post">
                      <select class="form-select form-select-sm" aria-label="Default select example" name="keterangan">
                        <option selected>Pilih</option>
                        <option value="Habis">Habis</option>
                        <option value="Tersedia">Tersedia</option>
                      </select>
                      <button type="submit" class="btn btn-primary text-white mt-2">
                        cari
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 info-pengeluaran">
                <div class="card">
                  <div class="card-body">
                    <form action="<?php echo base_url('dashboard/perlengkapan_peserta'); ?>" method="post">
                      <div class="form-group">
                        <label for="exampleInputPassword1">
                          Cetak Laporan Bulanan
                        </label>
                        <input type="date" name="tanggal" class="form-control" id="exampleInputPassword1">
                      </div>
                      </select>
                      <button type="submit" class="btn btn-primary text-white mt-2">
                        Cetak
                      </button>
                    </form>
                  </div>
                </div>
              </div>
              <!-- Tabel Kategori -->
              <?= $this->session->flashdata('pesan'); ?>
              <div class="row tabel-produk mt-2">
                <div class="col-lg-12 grid-margin stretch-card">
                  <div class="card">
                    <div class="card-body">
                      <h4 class="card-title">Daftar <?= $tittle; ?></h4>
                      <form action="<?= base_url('dashboard/opname_peserta'); ?>" method="post">
                        <button class="btn btn-primary btn-sm text-white" type="submit">
                          Stok Opname
                        </button>
                        <a href="tambah_produk.html" class="btn btn-danger text-white" id="hapus-peserta" data-url="<?= base_url('dashboard/hapus_peserta') ?>">
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
                                  Stok Awal
                                </th>
                                <th>
                                  Barang Masuk
                                </th>
                                <th>
                                  Jumlah Barang Keluar
                                </th>
                                <th>
                                  Stok Akhir
                                </th>
                                <th>
                                  Keterangan
                                </th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php if (isset($produk)) : ?>
                                <?php foreach ($produk as $p) : ?>
                                  <tr>
                                    <td>
                                      <input type="checkbox" id="check" name="id[]" value="<?= $p['kode_barang']; ?>" class="form-check-input check" aria-checked="false" /><i class="input-helper"></i>
                                    </td>
                                    <td style="text-transform: uppercase;">
                                      <?= $p['kode_barang']; ?>
                                    </td>
                                    <td>
                                      <?= $p['nama_barang']; ?>
                                    </td>
                                    <td>
                                      <?= $p['stok_awal']; ?>
                                    </td>
                                    <td>
                                      <?= $p['masuk']; ?>
                                    </td>
                                    <td>
                                      <?= $p['keluar']; ?>
                                    </td>

                                    <?php $jumlah = $p['stok_awal'] + $p['masuk'] - $p['keluar']; ?>
                                    <td>
                                      <?= $jumlah; ?>
                                    </td>
                                    <?php $keterangan = ($jumlah < 1) ? 'Habis' : 'Tersedia'; ?>
                                    <td class="text-danger">
                                      <?= $keterangan; ?>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                              <?php endif; ?>
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
            <form action="<?= base_url('dashboard/import_peserta'); ?>" method="post" enctype="multipart/form-data">
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