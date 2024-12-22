<h2>Data Prodi</h2>
<table id="example1" class="table table-striped table-bordered ">
<thead>
        <tr>
        <th>No.</th>
        <th>ID</th>
        <th>Nama Prodi</th>
        <th>Jenjang</th>
       
        </tr>
</thead>
<tbody>
<?php
try {
    include 'admin/koneksi.php';
    $stmt = $pdo->prepare("SELECT * FROM prodi");
    $stmt->execute();
    $no = 1;
    while ($data_prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <tr>
        <td><?= htmlspecialchars($no++) ?></td>
        <td><?= htmlspecialchars($data_prodi['id']) ?></td>
        <td><?= htmlspecialchars($data_prodi['nama_prodi']) ?></td>
        <td><?= htmlspecialchars($data_prodi['jenjang_std']) ?></td>
    </tr>
    <?php
    }
} catch(PDOException $e) {
    echo "<tr><td colspan='4' class='text-danger'>Error: " . $e->getMessage() . "</td></tr>";
}
?>
</tbody>
</table>