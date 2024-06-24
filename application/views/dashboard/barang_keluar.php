<div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              
              <div class="col-sm-12 mt-2">
                <div class="home-tab">
                  <div
                    class="d-sm-flex align-items-center justify-content-between border-bottom"
                  >
                    <ul class="nav nav-tabs" role="tablist">
                      
                      
                    </ul>
                    <div>
                      <div class="btn-wrapper">
                        <a
                          href="#"
                          class="btn btn-otline-dark align-items-center"
                          ><i class="icon-share"></i> Share</a
                        >
                        <a href="<?= base_url('dashboard/download_barang_keluar'); ?>" class="btn btn-otline-dark"
                          ><i class="icon-printer"></i> Print</a
                        >
                        <a href="" class="btn btn-primary text-white me-0"
                          ><i class="icon-download"></i> Export</a
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
                    <div class="row">
                      <div class="col-lg-4 info-pengeluaran">
                        <div class="card">
                        <div class="card-body">
                          <i class="mdi mdi-cash fs-1 text-primary"></i>
                          <P>Total Barang Keluar Bulan <?= date('Y-F-d'); ?>: <span class="text-success"><?= $peminjaman; ?></span></P>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-4 info-pengeluaran">
                        
                        <div class="card">
                        <div class="card-body">
                         
                        <form action="<?php echo base_url('dashboard/barang_keluar') ?>" method="post">

                          
                          <div class="form-group">
                            <label for="exampleInputPassword1">Filter Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" id="exampleInputPassword1">
                          </div>
                              
                            </select>
                            <button type="submit" class="btn btn-primary text-white mt-2">Cari</button>
                          </form>
                        </div>
                      </div>

                      
                      </div>
                      
                      </div>
                      </div>
                      
                    </div>
                    
                    </div>
                    <div class="row tabel-produk mt-2">
                        <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Barang Keluar</h4>
                  <?= $this->session->userdata('pesan');  ?>
                  <a href="<?= base_url('dashboard/tambah_barang_keluar'); ?>" class="btn btn-primary btn-sm text-white">+ Tambah</a>
                  <a href="#" class="btn btn-danger text-white btn-sm" id="hapus-barang" data-url="<?= base_url('dashboard/hapus_barang_keluar'); ?>">Hapus</a>
                  <div class="table-responsive overflow-visible mt-3">
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
                          <th>Nama</th>
                        
                          <th>Tanggal Keluar</th>
                          <th>Konfirmasi</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($produk as $p) : ?>
                        <tr>
                        <td> 
                            <input
                                  type="checkbox"
                                  id="check"
                                  name="id[]"
                                  value="<?= $p['id']; ?>"
                                  class="form-check-input check"
                                  aria-checked="false" /><i
                                  class="input-helper"
                                ></i
                              >
                            </td>
                          <td><?= $p['nama']; ?></td>
                         
                          <td><?= $p['tanggal_keluar']; ?></td>
                          
                          <?php if(!$p['status']) : ?>
                            <td><a href="<?= base_url('dashboard/kurangi_stok/'.$p['id'].'/'.$this->uri->segment(2)); ?>" class="btn btn-success">Acc</a> | <a href="<?= base_url('dashboard/batal/'.$p['id']); ?>" class="btn btn-danger">Batal</a> </td>
                            <?php else: ?>
                              <td class="text-success">Sukses</td>  
                              <?php endif; ?>
                          
                          <td class="text-primary">
                           <div class="dropup">
  
                                <i class="ti-settings" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate3d(0px, -33px, 0px); overflow: visible;">
                                <li><a class="dropdown-item" href="<?= base_url('dashboard/detail_keluar/'.$p['id']); ?>">Rincian Produk</a></li>
                               
                            </ul>
                            </div> 
                        </td>
                        </tr>
                        <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
