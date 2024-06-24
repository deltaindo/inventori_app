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
                      
                      
                    </div>

        <!-- Tabel Kategori -->
        <?= $this->session->flashdata('pesan'); ?>
        <div class="row tabel-produk mt-2">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Daftar Pralatan Praktek</h4>
                  
                  <div class="table-responsive">
                    <table class="table table-hover" id="example">
                      <thead>
                        <tr>
                          
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Jumlah</th>
                          
                        
                       
                          
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($produk as $p) : ?>
                        <tr>
                          
                          <td><?= $p['kode_barang']; ?></td>
                          <td><?= $p['nama_barang']; ?></td>
                          <td><?= $p['jumlah']; ?></td>
                         
                          
                          
                          
                        </tr>    
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Form Barang Masuk</h4>
                  <form action="<?= base_url('dashboard/tambah_barang_masuk'); ?>" method="post">
                  
                  <div class="row mb-3">
                    <div class="col-6">
                    <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal[]" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    
                  </div>
                  <!-- barang -->
                  <div class="row mb-3">
                    <div class="col-6">
                      <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
                      <select class="form-select form-select-sm js-example-basic-single" aria-label="Default select example" name="barang[]">
                        <?php foreach($produk as $p) : ?>
                          <option value="<?= $p['kode_barang'] ?>"><?= $p['nama_barang']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                    <div class="col-6">
                      <label for="exampleInputEmail1" class="form-label">Jumlah</label>
                      <input type="text" name="jumlah[]" class="form-control jumlah" id="exampleInputEmail1" aria-describedby="emailHelp"> 
                    </div>
                  </div>
                  <a href="#" class="btn btn-primary text-white tambah" data-aji="<?= base_url('dashboard/get_produk'); ?>">+ Tambah</a>
                  <a href="#" class="btn btn-danger text-white hapus">Hapus</a>
                  <button type="submit" class="btn btn-primary text-white">Simpan</button>
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
       