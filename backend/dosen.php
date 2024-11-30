<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="app/plugins/fontawesome-free/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="app/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="app/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="app/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="app/dist/css/adminlte.min.css">
<?php
include 'koneksi.php';

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch($aksi) {
    case 'list':
?>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dosen</h1>
      </div>

            <div class="col-3 mb-3">
                <a href="index.php?p=dosen&aksi=input" class="btn btn-primary"><i class="bi bi-plus-circle-fill"></i> Tambah Dosen</a>
            </div>

            <div class="card">
              <div class="card-header">
              </div>
              <!-- /.card-header -->
            <div class="card-body">
            <table class="table table-bordered table table-striped table-sm" id="example1">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Dosen</th>
                    <th>Email</th>
                    <th>Prodi</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>

                <?php
                    $stmt = $dbh->query("SELECT * FROM prodi INNER JOIN dosen WHERE prodi.id=dosen.prodi_id");
                    $no = 1;
                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>

                <tr>
                    <td><?= $no?></td>
                    <td><?= $data['nik']?></td>
                    <td><?= $data['nama_dosen']?></td>
                    <td><?= $data['email']?></td>
                    <td><?= $data['nama_prodi']?></td>
                    <td><?= $data['notelp']?></td>
                    <td><?= $data['alamat']?></td>
                    <td>
                        <a href="index.php?p=dosen&aksi=edit&id=<?= $data['id']?>" class="btn btn-success"><i class="bi bi-pencil"></i> Edit</a>
                        <a href="proses_dosen.php?proses=delete&id=<?= $data['id']?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus data?')"><i class="bi bi-trash"></i> Delete</a>
                    </td>
                </tr>

                <?php
                    $no++;
                    }
                ?>
            
            </table>
            </div>
                </div>
        </div>

<?php    
    break;

    case 'input';

?>        

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Input Dosen</h1>
      </div>

    <form action="proses_dosen.php?proses=insert" method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label for="nik" class="form-label">NIP</label>
            <input type="number" class="form-control" id="nik" name="nik" required autofocus>
        </div>

        <div class="mb-3">
            <label for="nama_dosen" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required>
        </div>

        <div class="mb-3">
            <label for="prodi_id" class="form-label">Prodi ID</label>
            <select name="prodi_id" class="form-select" id="prodi_id" name="prodi_id" required>
                <option value="">-Pilih Prodi-</option>
                <?php
                $stmt = $dbh->query("SELECT * FROM prodi");
                while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<option value='".$data_prodi['id']."'>".$data_prodi['nama_prodi']."</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="notelp" class="form-label">No telepon</label>
            <input type="text" class="form-control" id="notelp" name="notelp" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>       

        <div class="mb-3">
            <button type="submit" class="btn btn-primary " name="submit">Simpan</button>
            <button type="reset" class="btn btn-warning " name="reset">Reset</button>
        </div>
    </form>
    </div>

    <?php
    break;

    case 'edit':
        try {
            $stmt = $dbh->prepare("SELECT * FROM dosen WHERE id = :id");
            $stmt->execute(['id' => $_GET['id']]);
            $data_dosen = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data_dosen) {
                die("Data dosen tidak ditemukan");
            }
?>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Dosen</h1>
        </div>

        <form action="proses_dosen.php?proses=edit" method="POST" class="bg-white p-4 rounded shadow-sm">
            <input type="hidden" name="id" value="<?= $data_dosen['id'] ?>">
            
            <div class="mb-3">
                <label for="nik" class="form-label">NIP</label>
                <input type="number" class="form-control" id="nik" name="nik" value="<?= $data_dosen['nik'] ?>" readonly>
            </div>

            <div class="mb-3">
                <label for="nama_dosen" class="form-label">Nama Dosen</label>
                <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="<?= $data_dosen['nama_dosen'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $data_dosen['email'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="prodi_id" class="form-label">Prodi</label>
                <select class="form-select" id="prodi_id" name="prodi_id" required>
                    <option value="">-Pilih Prodi-</option>
                    <?php
                    $stmt_prodi = $dbh->query("SELECT * FROM prodi");
                    while ($data_prodi = $stmt_prodi->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($data_prodi['id'] == $data_dosen['prodi_id']) ? 'selected' : '';
                        echo "<option value='".$data_prodi['id']."' $selected>".$data_prodi['nama_prodi']."</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="notelp" class="form-label">No Telepon</label>
                <input type="text" class="form-control" id="notelp" name="notelp" value="<?= $data_dosen['notelp'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= $data_dosen['alamat'] ?></textarea>
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit">Update</button>
                <a href="index.php?p=dosen" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
<?php
    } catch(PDOException $e) {
        die("Error: " . $e->getMessage());
    }
break;

}
?>
<!-- jQuery -->
<script src="app/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="app/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="app/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="app/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="app/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="app/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="app/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="app/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="app/plugins/jszip/jszip.min.js"></script>
<script src="app/plugins/pdfmake/pdfmake.min.js"></script>
<script src="app/plugins/pdfmake/vfs_fonts.js"></script>
<script src="app/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="app/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="app/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="app/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="app/dist/js/demo.js"></script>
<!-- Page specific script -->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>