<footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Premium
      <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a>
      from BootstrapDash.</span>
    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Copyright © 2021. All rights reserved.</span>
  </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="<?= base_url('assets/vendors/js/vendor.bundle.base.js'); ?>"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
<script src="<?= base_url('assets/vendors/chart.js/Chart.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?= base_url('assets/vendors/progressbar.js/progressbar.min.js'); ?>"></script>

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="<?= base_url('assets/js/off-canvas.js'); ?>"></script>
<script src="<?= base_url('assets/js/hoverable-collapse.js'); ?>"></script>
<script src="<?= base_url('assets/js/template.js'); ?>"></script>
<script src="<?= base_url('assets/js/settings.js'); ?>"></script>
<script src="<?= base_url('assets/js/todolist.js'); ?>"></script>
<!-- endinject -->
<!-- Custom js for this page-->

<script src="<?= base_url('assets/js/dashboard.js'); ?>"></script>
<script src="<?= base_url('assets/js/Chart.roundedBarCharts.js'); ?>"></script>
<!-- End custom js for this page-->
<!-- databael -->

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.11.0/dist/sweetalert2.all.min.js"></script>
<script src="<?= base_url('assets/script.js'); ?>"></script>

<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>

<script>
  $(document).ready(function() {
    $('.jumlah').on('keyup', function() {
      const jumlah = $('.jumlah').val();
      const id = $(this).data('id');
    })
  })
</script>

<script>
  function deleteOffice(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          showConfirmButton: false,
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
          timer: 2000
        });
        window.location.href = `<?= base_url('/dashboard/delete_office/') ?>${id}`;
      }
    });
  }
</script>

<script>
  function deleteBulkKantor() {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('bulk-delete-form').submit();
      }
    });
  }

  document.getElementById('check-all').addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.form-check-input.check');
    for (let checkbox of checkboxes) {
      checkbox.checked = this.checked;
    }
  });
</script>

<script>
  function deleteAdmin(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          showConfirmButton: false,
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
          timer: 2000
        });
        window.location.href = `<?= base_url('/dashboard/delete_admin/') ?>${id}`;
      }
    });
  }
</script>

<script>
  function deleteBulkAdmin() {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('bulk-delete-form').submit();
      }
    });
  }

  document.getElementById('check-all').addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.form-check-input.check');
    for (let checkbox of checkboxes) {
      checkbox.checked = this.checked;
    }
  });
</script>

<script>
  function deleteLokasi(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          showConfirmButton: false,
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
          timer: 2000
        });
        window.location.href = `<?= base_url('/dashboard/delete_lokasi/') ?>${id}`;
      }
    });
  }
</script>

<script>
  function deleteBulkLokasi() {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('bulk-delete-form').submit();
      }
    });
  }

  document.getElementById('check-all').addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.form-check-input.check');
    for (let checkbox of checkboxes) {
      checkbox.checked = this.checked;
    }
  });
</script>

<script>
  function deleteSatuan(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          showConfirmButton: false,
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
          timer: 2000
        });
        window.location.href = `<?= base_url('/dashboard/delete_satuan/') ?>${id}`;
      }
    });
  }
</script>

<script>
  function bulkDeleteSatuan() {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('bulk-delete-form').submit();
      }
    });
  }

  document.getElementById('check-all').addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.form-check-input.check');
    for (let checkbox of checkboxes) {
      checkbox.checked = this.checked;
    }
  });
</script>

<script>
  function deleteMerek(id) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          showConfirmButton: false,
          title: "Deleted!",
          text: "Your file has been deleted.",
          icon: "success",
          timer: 2000
        });
        window.location.href = `<?= base_url('/dashboard/delete_merek/') ?>${id}`;
      }
    });
  }
</script>

<script>
  function deleteBulkMerek() {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Yes, delete it!"
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById('bulk-delete-form').submit();
      }
    });
  }

  document.getElementById('check-all').addEventListener('click', function() {
    let checkboxes = document.querySelectorAll('.form-check-input.check');
    for (let checkbox of checkboxes) {
      checkbox.checked = this.checked;
    }
  });
</script>
</body>

</html>