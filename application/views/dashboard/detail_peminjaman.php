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
                          ><?= $tittle; ?></a
                        >
                      </li>
                     
                      <li class="nav-item ml-auto">
                        <p class="nav-link text-primary">Total Seluruh Aset : Rp.0</p>
                      </li>
                      
                    </ul>
                    <div>
                      <div class="btn-wrapper">
                        
                        <a href="#" class="btn btn-otline-dark"
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
                      <!-- <div class="row filter-produk">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-2">
                                    <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2" checked>
                                        Semua Stok
                                    </label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
                                        Stok Menipis
                                    </label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
                                        Stok Habis
                                    </label>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="optionsRadios" id="optionsRadios2" value="option2">
                                        Stok Tersedia
                                    </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                      </div> -->
                      
                    </div>

        <!-- Tabel Kategori -->
        <?= $this->session->flashdata('pesan'); ?>
        <div class="row tabel-produk mt-2">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"><?= $tittle ?> <?= $nama['nama']; ?></h4>
                  <ul class="list-group list-group-flush">
                    <?php foreach($detail_peminjaman as $p) : ?>
                    <li class="list-group-item"><?= $p['nama_barang']; ?> | Jumlah: <?= $p['jumlah']; ?> </li>
                    <?php endforeach; ?>
                  </ul>
                  <?php if($this->uri->segment('2') === 'detail_keluar') : ?>
                    <a href="<?= base_url('dashboard/barang_keluar'); ?>" class="btn btn-primary text-white mt-3">Kembali</a>  
                    <?php else: ?>
                      <a href="<?= base_url('dashboard/peminjaman'); ?>" class="btn btn-primary text-white mt-3">Kembali</a>  
                      <?php endif; ?>
                  
                </div>
              </div>
              
            </div>
            
            
        
        </div>
        
                  </div>
                </div>
              </div>
            </div>
          </div>
       