<h2>Data Mahasiswa</h2>
<table id="example" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Email</th>
            <th>Prodi Id</th>
            <th>Nama Prodi</th>
            <th>No Telp</th>
            <th>Alamat</th>
        </tr>
    </thead>
    <tbody>
        <?php
            try {
                include 'admin/koneksi.php';
                $stmt = $pdo->prepare("SELECT * FROM prodi,mahasiswa WHERE prodi.id=mahasiswa.prodi_id");
                $stmt->execute();
                $no = 1;
                while ($data_mhs = $stmt->fetch(PDO::FETCH_ASSOC)){
        ?>
        <tr>
            <td><?= htmlspecialchars($no++) ?></td>
            <td><?= htmlspecialchars($data_mhs['nim']) ?></td>
            <td><?= htmlspecialchars($data_mhs['nama_mhs']) ?></td>
            <td><?= htmlspecialchars($data_mhs['email']) ?></td>
            <td><?= htmlspecialchars($data_mhs['prodi_id']) ?></td>
            <td><?= htmlspecialchars($data_mhs['nama_prodi']) ?></td>
            <td><?= htmlspecialchars($data_mhs['notelp']) ?></td>
            <td><?= htmlspecialchars($data_mhs['alamat']) ?></td>
        </tr>
        <?php
                }
            } catch(PDOException $e) {
                echo "<tr><td colspan='8' class='text-danger'>Error: " . $e->getMessage() . "</td></tr>";
            }
        ?>
    </tbody>
</table>