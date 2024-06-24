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
                          id="home-tab"
                          data-bs-toggle="tab"
                          href="#overview"
                          role="tab"
                          aria-controls="overview"
                          aria-selected="true"
                          >Pralatan Praktik</a
                        >
                      </li>
                      <li class="nav-item">
                        <a
                          class="nav-link active ps-0 inventori"
                          id=""
                          
                          href="<?= base_url('dashboard/pralatan_riksa_uji'); ?>"
                          role="tab"
                          aria-controls="overview"
                          aria-selected="true"
                          > Pralatan Riksa Uji</a
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
                        
                        <a href="#" class="btn btn-otline-dark"
                          ><i class="icon-printer"></i> Download</a
                        >
                        <a href="<?= base_url('dashboard/import_praktek'); ?>" class="btn btn-primary text-white me-0" data-bs-toggle="modal" data-bs-target="#exampleModal"
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
                          <form action="<?= base_url('dashboard/daftar_produk'); ?>" method="post">
                          
                          <select class="form-select form-select-sm" aria-label="Default select example" name="kalibrasi">
                              <option selected>Pilih</option>
                              <option value="Aktif">Aktif</option>
                              <option value="Habis">Expired</option>
                              
                            </select>
                            <button type="submit" class="btn btn-primary text-white mt-2">cari</button>
                          </form>
                        </div>
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
                  <form action="<?= base_url('dashboard/opname_peralatan'); ?>" method="post">
                  <!-- <a href="tambah_produk.html" class="btn btn-primary text-white  "  id="sidebar">+ Produk</a> -->
                  
                  <button class="btn btn-primary btn-sm text-white" type="submit">Stok Opname</button>
                   <a href="#" class="btn btn-danger btn-sm text-white" id="hapus-praktek" data-url="<?= base_url('dashboard/hapus_praktek'); ?>">Hapus</a>
                  <div class="table-responsive mt-3">
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
                          <th>Nama</th>
                          <th>Stok</th>
                     
                      
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
                          <td><?= $p['kode_barang'] ?></td>
                          <td><?= $p['nama_barang'] ?></td>
                          <td><?= $p['jumlah'] ?></td>
                          
                          
                          <?php 
                             $date_format = 'Y-m-d'; // format tanggal
                             $masa_berlaku_kalibrasi = $p['masa_berlaku_kalibrasi'];
                             $masa_berlaku_kalibrasi_timestamp = strtotime($masa_berlaku_kalibrasi); // konversi tanggal masa berlaku kalibrasi ke format timestamp
                             if (!$masa_berlaku_kalibrasi_timestamp) {
                                 $keterangan = 'Invalid date'; // error handling jika tanggal tidak valid
                             } else {
                                 $today_timestamp = strtotime('today'); // konversi tanggal saat ini ke format timestamp
                                 $keterangan = ($masa_berlaku_kalibrasi_timestamp > $today_timestamp) ? 'Aktif': 'Habis'; // bandingkan kedua tanggal dan atur nilai $keterangan
                             }
                          ?>
                          <td class="text-danger">
                            <?= ($p['jumlah'] < 1) ? 'Habis' : 'Tersedia'; ?>
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
      <form action="<?= base_url('dashboard/import_praktek'); ?>" method="post" enctype="multipart/form-data">
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