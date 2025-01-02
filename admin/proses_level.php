<?php
include 'koneksi.php';

$proses = $_GET['proses'];

switch ($proses) {
    case 'insert':
        try {
            $stmt = $pdo->prepare("INSERT INTO level (nama_level, keterangan) VALUES (?, ?)");
            $stmt->execute([$_POST['nama_level'], $_POST['keterangan']]);
            
            header("Location: index.php?p=level&aksi=list");
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        break;

    case 'edit':
        try {
            $stmt = $pdo->prepare("UPDATE level SET nama_level = ?, keterangan = ? WHERE id = ?");
            $stmt->execute([$_POST['nama_level'], $_POST['keterangan'], $_POST['id']]);
            
            header("Location: index.php?p=level&aksi=list");
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        break;

    case 'delete':
        try {
            $stmt = $pdo->prepare("DELETE FROM level WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            
            header("Location: index.php?p=level&aksi=list");
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        break;
}
?>
