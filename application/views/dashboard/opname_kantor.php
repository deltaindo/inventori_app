<div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-6">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-tittle">List Produk Opname</h4>
                  <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Cari Invoice atau Nomor Resi" aria-label="Search">
                        <button class="btn btn-outline-success btn-sm" type="submit">Cari</button>
                    </form>
                <form action="<?= base_url('dashboard/opname_kantor'); ?>" method="post">    
                <ul class="list-group mt-3">
                 <?php foreach($produk as $p) : ?> 
                    <input type="hidden" value="<?= $p['kode_barang'];  ?>" name="id[]"> 
                  <li class="list-group-item mt-3">
                        <div class="row">
                        <div class="col-lg-6">
                            <p><?= $p['nama_barang']; ?></p>
                        <span class="text-danger">Stok Saat ini : <?= $p['jumlah']; ?></span><br>       
                        </div>
                        </div>  
                        <div class="row">
                            <div class="col-4">
                            <label for="exampleInputPassword1" class="form-label">Stok Terbaru</label>
                            <input type="text" class="form-control" name="stok[]" id="exampleInputPassword1">
                            </div>
                            <div class="col-4">
                            <label for="exampleInputPassword1" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" name="nama[]" value="<?= $p['nama_barang'] ?>" id="exampleInputPassword1">
                            </div>
                            <div class="col-4">
                            <label for="exampleInputPassword1" class="form-label">Lokasi Barang</label>
                            <input type="text" class="form-control" name="lokasi_barang[]" value="<?= $p['lokasi_barang']; ?>" id="exampleInputPassword1">
                            </div>
                           
                        </div> 
                    </li>    
                   <?php endforeach; ?>  
                </ul>
                <button type="submit" class="btn btn-primary mt-3">Update</button>
                </form>
                <a href="<?= base_url('dashboard/perlengkapan_peserta'); ?>"><button class="btn btn-primary mt-3">Kembali</button></a>
                
                
                </div>
                
              </div>
              
            </div>
            
          </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div
              class="d-sm-flex justify-content-center justify-content-sm-between"
            >
              <span
                class="text-muted text-center text-sm-left d-block d-sm-inline-block"
                >Premium
                <a href="https://www.bootstrapdash.com/" target="_blank"
                  >Bootstrap admin template</a
                >
                from BootstrapDash.</span
              >
              <span
                class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"
                >Copyright © 2021. All rights reserved.</span
              >
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>