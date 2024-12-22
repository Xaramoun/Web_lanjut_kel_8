<h2>Data Matakuliah</h2>
<table id="example2" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>ID</th>
            <th>Kode Matakuliah</th>
            <th>Nama Matakuliah</th>
            <th>Semester</th>
            <th>Jenis Matakuliah</th>
            <th>SKS</th>
            <th>Jam</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
<?php
try {
    include 'admin/koneksi.php';
    $stmt = $pdo->prepare("SELECT * FROM matakuliah");
    $stmt->execute();
    $no = 1;
    while ($data_matkul = $stmt->fetch(PDO::FETCH_ASSOC)) {
        ?>
        <tr>
            <td><?= htmlspecialchars($no) ?></td>
            <td><?= htmlspecialchars($data_matkul['id']) ?></td>
            <td><?= htmlspecialchars($data_matkul['kode_matakuliah']) ?></td>
            <td><?= htmlspecialchars($data_matkul['nama_matakuliah']) ?></td>
            <td><?= htmlspecialchars($data_matkul['semester']) ?></td>
            <td><?= htmlspecialchars($data_matkul['jenis_matakuliah']) ?></td>
            <td><?= htmlspecialchars($data_matkul['sks']) ?></td>
            <td><?= htmlspecialchars($data_matkul['jam']) ?></td>
            <td><?= htmlspecialchars($data_matkul['keterangan']) ?></td>
        </tr>
        <?php
        $no++;
    }
} catch(PDOException $e) {
    echo "<tr><td colspan='9' class='text-danger'>Error: " . $e->getMessage() . "</td></tr>";
}
?>
    </tbody>
</table>