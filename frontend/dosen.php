<h2>Data Dosen</h2>
<table id="example2" class="table table-striped table-bordered">
    <thead>
        <tr>
        <th>No</th>
        <th>NIK</th>
        <th>Nama Dosen</th>
        <th>Email</th>
        <th>Prodi ID</th>
        <th>Nama Prodi</th>
        <th>No Telp</th>
        <th>Alamat</th>
        
        </tr>
    </thead>
    <tbody>
<?php
try {
    include 'admin/koneksi.php';
    $query = "SELECT * FROM prodi,dosen WHERE prodi.id=dosen.prodi_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $no = 1;
    while ($data_dosen = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
        <td><?= $no++ ?></td>
        <td><?= $data_dosen['nik'] ?></td>
        <td><?= $data_dosen['nama_dosen'] ?></td>
        <td><?= $data_dosen['email'] ?></td>
        <td><?= $data_dosen['prodi_id'] ?></td>
        <td><?= $data_dosen['nama_prodi'] ?></td>
        <td><?= $data_dosen['notelp'] ?></td>
        <td><?= $data_dosen['alamat'] ?></td>
        
  </tr>
  <?php
}

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
</tbody>
</table>