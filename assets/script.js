$(".js-example-basic-single").select2();
$("#check-all").click(function () {
	if ($(this).is(":checked")) {
		$(".check").prop("checked", true);
	} else {
		$(".check").prop("checked", false);
	}
});
// Ambil elemen tombol "Tambah"

$(".hapus").click(function () {
	$(".row.mb-3:last-of-type").remove();
});

$(".tambah").click(function () {
	// Buat template elemen baru untuk form barang dan jumlah
	var id = $(this).data("aji");

	const newForm = `
    <div class="row mb-3">
      <div class="col-6">
        <label class="form-label">Nama Barang</label>
        <select class="form-select form-select-sm js-example-basic-single" aria-label="Default select example" name="barang[]">
        </select>
      </div>
      <div class="col-6">
        <label class="form-label">Jumlah</label>
        <input type="text" class="form-control" name="jumlah[]">
      </div>
    </div>
  `;

	// Sisipkan elemen baru setelah elemen form barang yang terakhir
	$(".row.mb-3:last-of-type").after(newForm);

	// Ambil data barang dari backend menggunakan AJAX
	$.ajax({
		url: id,
		method: "GET",
		dataType: "json",
		success: function (data) {
			// Tampilkan data barang dalam opsi dropdown
			$.each(data, function (key, value) {
				$(".js-example-basic-single:last").append(
					"<option value='" +
						value.kode_barang +
						"'>" +
						value.nama_barang +
						"</option>"
				);
			});

			// Inisialisasi plugin Select2 pada opsi dropdown
			$(".js-example-basic-single:last").select2();
		},
	});
});

$("#hapus-praktek").click(function (e) {
	e.preventDefault();
	var url = $(this).data("url");
	var id = [];
	$('input[name="id[]"]:checked').each(function () {
		id.push($(this).val());
	});
	deleteData(id, url);
});

$("#hapus-peserta").click(function (e) {
	e.preventDefault();
	var url = $(this).data("url");
	var id = [];
	$('input[name="id[]"]:checked').each(function () {
		id.push($(this).val());
	});
	deleteData(id, url);
});

$("#hapus-kantor").click(function (e) {
	e.preventDefault();
	var url = $(this).data("url");
	var id = [];
	$('input[name="id[]"]:checked').each(function () {
		id.push($(this).val());
	});

	deleteData(id, url);
});

$("#hapus-pinjaman").click(function (e) {
	e.preventDefault();
	var url = $(this).data("url");
	var id = [];

	$('input[name="id[]"]:checked').each(function () {
		id.push($(this).val());
	});

	deleteData(id, url);
});
$("#hapus-barang").click(function (e) {
	e.preventDefault();
	var url = $(this).data("url");
	var id = [];

	$('input[name="id[]"]:checked').each(function () {
		id.push($(this).val());
	});

	deleteData(id, url);
});

$("#hapus-barang-masuk").click(function (e) {
	e.preventDefault();
	var url = $(this).data("url");
	var id = [];

	$('input[name="id[]"]:checked').each(function () {
		id.push($(this).val());
	});

	deleteData(id, url);
});

function deleteData(id, url) {
	if (id.length > 0) {
		$.ajax({
			url: url,
			method: "post",
			data: { id: id },
			success: function (response) {
				alert("Data Berhasil Di Hapus");
				location.reload();
			},
		});
	}
}

$(".tombol").click(function () {
	var id = $(this).data("id");
	var url = $(this).data("url");
	$.ajax({
		url: url,
		method: "post",
		data: { id: id },
		success: function (response) {
			alert("Data Berhasil Di Update");
			location.reload();
		},
	});
});

$("#btnEdit").click(function () {
	// Ambil checkbox yang di-check
	var checkedCheckbox = $(".check:checked");

	// Jika tidak ada checkbox yang di-check, tampilkan peringatan atau lakukan aksi sesuai kebutuhan
	if (checkedCheckbox.length === 0) {
		alert("Pilih setidaknya satu produk untuk diedit.");
		return;
	}

	// Ambil data dari checkbox pertama yang di-check
	var id = checkedCheckbox.eq(0).val();
	var nama = checkedCheckbox.eq(0).closest("tr").find("td:eq(2)").text(); // Ubah indeks sesuai dengan kolom yang berisi nama produk

	// Isi nilai pada form di dalam modal
	$("#editId").val(id);
	$("#editNama").val(nama);

	// Tampilkan modal
	$("#editModal").modal("show");
});
