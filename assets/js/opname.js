$(document).ready(function () {
  $(".tambah").one("click", function () {
    $(".no-produk").addClass("d-none");
    $(".konten").append(`
    <h5>Laptop Vivobool Pro 14 Oled</h5>
    <p class="text-danger">stok : 1</p>
                      <div class="form-group">
                      <label for="exampleInputEmail1">Stok Saat Ini</label>
                      <input type="number" class="form-control" id="stok">
                    </div>
                    <div class="form-group">
                  <label for="exampleInputEmail1">Tulis alasan perubah stok</label>
                    <input type="text" class="form-control" id="stok"> 
                </div>
                <hr>
      `);
  });
});

// penambahan pembelian form pembelian
$(document).ready(function () {
  $(".tambah-produk").click(function (e) {
    e.preventDefault();

    $(".list-produk").append(`
                          <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Produk</label>
                                 <div class="form-group">
                                    <select class="js-example-basic-single form-control-lg" name="produk" style="width: 100%;">
                                    <option selected>Pilih Produk</option>
                                    <option value="">MD Gudang</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Harga Beli /Pcs</label>
                                <input type="number" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Stok</label>
                                <input type="number" class="form-control" value="0">
                            </div>
                        </div>
    `);
    $(".js-example-basic-single").select2();
  });
});

// daftar kategori
$(document).ready(function () {
  $(".kategori").click(function () {
    $(".tabel-produk").attr("hidden", true);
    $(".filter-produk").attr("hidden", true);
    $(".kategori-produk").removeAttr("hidden");
  });

  $(".inventori").click(function () {
    $(".tabel-produk").removeAttr("hidden");
    $(".filter-produk").removeAttr("hidden");
    $(".kategori-produk").attr("hidden", true);
  });
});
