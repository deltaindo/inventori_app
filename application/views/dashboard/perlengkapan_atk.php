<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
                  <div
                    class="d-sm-flex align-items-center justify-content-between border-bottom"
                  >
                    <ul class="nav nav-tabs" role="tablist">
                      <li class="nav-item">
                        <a
                          class="nav-link active ps-0 inventori"
                         
                          href="<?= base_url('dashboard/perlengkapan_peserta'); ?>"
                          role="tab"
                          aria-controls="overview"
                          aria-selected="true"
                          >Perlengkapan Peserta</a
                        >
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link active ps-0 inventori"
                         
                          href="<?= base_url('dashboard/perlengkapan_atk'); ?>"
                          role="tab"
                          aria-controls="overview"
                          aria-selected="true"
                          >Perlengkapan ATK</a
                        >
                      </li>
                     
                      <li class="nav-item ml-auto">
                        <p class="nav-link text-primary">Total Seluruh Aset : <?= ($total_assets == 0) ? '0' : 'Rp '. number_format($total_assets,0,',','.'); ?></p>
                      </li>
                      <li class="nav-item ml-auto">
                        <p class="nav-link text-primary">Total Alat : <?= ($total_alat == 0) ? '0' : $total_alat; ?></p>
                      </li>
                      
                    </ul>
                    <div>
                      <div class="btn-wrapper">
                        
                      <a href="<?php echo base_url('dashboard/download_excel') . '?keterangan=' . $this->input->post('keterangan') . '&kategori=atk'; ?>" class="btn btn-otline-dark"
                          ><i class="icon-printer"></i> Print</a
                        >
                        <a href="#" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#exampleModal"
                          ><i class="icon-download"></i>Import</a
                        >
                      </div>
                    </div>
                  </div>
                  <div class="tab-content tab-content-basic">
                    <div
                      class="tab-pane fade show active"
                      id="overview"
                      role="tabpanel"
                      aria-labelledby="overview"
                    >
                    
                      
                    </div>
                    <div class="row">
                      <div class="col-lg-4 info-pengeluaran">
                        <div class="card">
                        <div class="card-body">
                          <form action="<?= base_url('dashboard/perlengkapan_atk'); ?>" method="post">
                          
                          <select class="form-select form-select-sm" aria-label="Default select example" name="keterangan">
                              <option selected>Pilih</option>
                              <option value="Habis">Habis</option>
                              <option value="Tersedia">Tersedia</option>
                              
                            </select>
                            <button type="submit" class="btn btn-primary text-white mt-2">cari</button>
                          </form>
                        </div>
                      </div>

                      
                      </div>
                      <div class="col-lg-4 info-pengeluaran">
                        
                        <div class="card">
                        <div class="card-body">
                         
                        <form action="<?php echo base_url('dashboard/perlengkapan_atk'); ?>" method="post">

                          
                          <div class="form-group">
                            <label for="exampleInputPassword1">Cetak Laporan Bulanan</label>
                            <input type="date" name="tanggal" class="form-control" id="exampleInputPassword1">
                          </div>
                              
                            </select>
                            <button type="submit" class="btn btn-primary text-white mt-2">Cetak</button>
                            <a href="<?php echo base_url('dashboard/rekap_bulanan') . '?waktu=' . $this->input->post('tanggal'). '&kat=ATK'?>" class="btn btn-otline-dark"
                          ><i class="icon-printer"></i> Print</a
                        >
                          </form>
                        </div>
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
                  <!-- <a href="tambah_produk.html" class="btn btn-primary text-white  "  id="sidebar">+ Produk</a> -->
                  <button class="btn btn-primary btn-sm text-white" type="submit">Stok Opname</button>
                  <button type="button" class="btn btn-primary" id="btnEdit">Edit Produk Terpilih</button>
                  <button type="button" class="btn btn-primary text-white" data-bs-toggle="modal" data-bs-target="#produk1">
                    Tambah Produk
                  </button>
                  
                   <a href="tambah_produk.html" class="btn btn-danger text-white" id="hapus-peserta" data-url="<?= base_url('dashboard/hapus_peserta') ?>" >Hapus</a>
                   
                  <div class="table-responsive">
                    <table class="table table-hover" id="example">
                      <thead>
                        <tr>
                          <th>
                          <input
                                  type="checkbox"
                                  id="check-all"

                                  class="form-check-input check"
                                  aria-checked="false" /><i
                                  class="input-helper"
                                ></i
                              >
                            </th>
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Stok Awal</th>
                          <th>Masuk</th>
                          <th>Keluar</th>
                          <th>Stok Akhir</th>
                         
                          <th>Keterangan</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(isset($produk)) : ?>
                        <?php foreach($produk as $p) : ?>
                        <tr>
                          <td> 
                            <input
                                  type="checkbox"
                                  id="check"
                                  name="id[]"
                                  value="<?= $p['kode_barang']; ?>"
                                  class="form-check-input check"
                                  aria-checked="false" /><i
                                  class="input-helper"
                                ></i
                              >
                            </td>
                            
                          <td style="text-transform: uppercase;"><?= $p['kode_barang']; ?></td>
                          <td><?= $p['nama_barang']; ?></td>
                          <td><?= $p['stok_awal']; ?></td>
                          <td><?= $p['masuk']; ?></td>
                          <td><?= $p['keluar']; ?></td>
                          <?php 
                           $jumlah = $p['stok_awal'] + $p['masuk'] - $p['keluar'];
                          ?>
                          <td><?= $jumlah; ?></td>
                          <?php $keterangan = ($jumlah < 1) ? 'Habis' : 'Tersedia'; ?>
                          <td class="text-danger"><?= $keterangan; ?></td>
                            
                         
                        
                          
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
        <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="<?= base_url('dashboard/import_peserta'); ?>" method="post" enctype="multipart/form-data">
        <label for="exampleInputEmail1" class="form-label">Import File</label>
        <input type="file" name="file" class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp">
        <button type="submit" class="btn btn-primary btn-sm mt-3"><i class="icon-download"></i>Import</button>
      </form>
      </div>
      <div class="modal-footer">
       
       
      </div>
    </div>
  </div>
</div>

<!-- tambah produk -->
<!-- Modal -->
<div class="modal fade" id="produk1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('dashboard/tambahProduk'); ?>" method="post">
        <input type="hidden" name="kategori" value="ATK">
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Nama Barang</label>
            <input type="text" name="produk" class="form-control" id="exampleFormControlInput1">
          </div>
          <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" id="exampleFormControlInput1">
          </div>
          <select class="form-select form-select-sm" aria-label="Default select example" name="satuan">
            <option selected>Satuan</option>
            <option value="1">Pcs</option>
            <option value="1">Box</option>
            <option value="1">Rim</option>
            
            <option value="12">Lusin</option>
          </select>
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- edit produk -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Form untuk mengedit data -->
        <form id="editForm" method="post" action="<?= base_url('dashboard/editProduk'); ?>">
          <div class="form-group">
            <label for="editId">ID Produk</label>
            <input type="text" class="form-control" name="id" id="editId" readonly>
          </div>
          <div class="form-group">
            <label for="editNama">Nama Produk</label>
            <input type="text" class="form-control" name="barang" id="editNama">
          </div>
          <!-- Tambahkan field lain sesuai dengan kebutuhan -->
          <!-- Contoh: -->
          <!-- <div class="form-group">
            <label for="editField">Field Lain</label>
            <input type="text" class="form-control" id="editField">
          </div> -->
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
      </div>
    </div>
  </div>
</div>