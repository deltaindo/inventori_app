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
                        <a href="#" class="btn btn-otline-dark"
                          ><i class="icon-printer"></i> Print</a
                        >
                        <a href="#" class="btn btn-primary text-white me-0"
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
                          <P>Total Barang Di Pinjam : <span class="text-success"><?= $peminjaman; ?></span></P>
                        </div>
                      </div>
                      </div>
                      <div class="col-lg-4 info-pengeluaran">
                        <div class="card">
                        <div class="card-body">
                          <i class="mdi mdi-truck-delivery fs-1 text-primary"></i>
                          <P>Total Barang Di kembalikan : <span class="text-success"><?= $kembali; ?></span></P>
                        </div>
                      </div>
                      </div>
                       <div class="col-lg-4 info-pengeluaran">
                        <div class="card">
                        <div class="card-body">
                          <i class="mdi mdi-truck-delivery fs-1 text-primary"></i>
                          <P>Total Barang Jatuh Tempo : <span class="text-success"><?= ($telat < 1) ? '0' : $telat; ?></span></P>
                        </div>
                      </div>
                      </div>
                      
                    </div>
                    
                    </div>
                    <div class="row tabel-produk mt-2">
                        <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Peminjaman</h4>
                  <?= $this->session->userdata('pesan');  ?>
                  <a href="<?= base_url('dashboard/tambah_peminjaman'); ?>" class="btn btn-primary text-white">+ Tambah</a>
                  <a href="#" class="btn btn-danger text-white" id="hapus-pinjaman" data-url="<?= base_url('dashboard/hapus_pinjaman'); ?>">Hapus</a>
                  <div class="table-responsive overflow-visible">
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
                          <th>Nama Peminjam</th>
                          <th>Tanggal Peminjaman</th>
                          <th>Tanggal Pengembalian</th>
                          <th>Telat</th>
                     
                          <th>Status
                          
                          </th
                          >
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
                          <td><?= $p['pic']; ?></td>
                          <td><?= $p['tanggal_pinjam']; ?></td>
                          <td><?= $p['tanggal_kembali']; ?></td>
                          <?php 
                            $selisih = strtotime(date('Y-m-d')) - strtotime($p['tanggal_kembali']);
                            $telat = floor($selisih / (60*60*24));
                            $telat = ($telat < 0) ? 0 : $telat;
                          ?>
                          <td><?= $telat ?> Hari</td>
                         
                          <td><?= $p['status']; ?>
                          <div class="drop down">
                                  <i
                                    class="mdi mdi-arrow-down-drop-circle text-primary fs-6"
                                    role="button"
                                    id="dropdownMenuLink"
                                    data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                  ></i>
                                  <ul
                                    class="dropdown-menu"
                                    aria-labelledby="dropdownMenuButton1"
                                  >
                                    <li>
                                      <a class="dropdown-item tombol" data-id="<?= $p['id']; ?>" data-status="2" data-url="<?= base_url('dashboard/edit'); ?>"
                                        >di Kembalikan</a
                                      >
                                    </li>
                                   
                                  </ul>
                                </div>
                          </td>
                          
                          <td class="text-primary">
                           <div class="dropup">
  
                                <i class="ti-settings" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="position: absolute; inset: auto 0px 0px auto; margin: 0px; transform: translate3d(0px, -33px, 0px); overflow: visible;">
                                <li><a class="dropdown-item" href="<?= base_url('dashboard/detail_peminjaman/'.$p['id']); ?>">Rincian Produk</a></li>
                                <li><a class="dropdown-item" href="#">Atur Retur</a></li>
                                <li><a class="dropdown-item" href="#">Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#">Hapus</a></li>
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
