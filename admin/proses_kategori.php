<?php
include 'koneksi.php'; // Menghubungkan ke database

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query untuk menyisipkan data
            $stmt = $pdo->prepare("INSERT INTO kategori (nama_kategori, keterangan) VALUES (:nama_kategori, :keterangan)");
            $stmt->bindParam(':nama_kategori', $_POST['nama_kategori'], PDO::PARAM_STR);
            $stmt->bindParam(':keterangan', $_POST['keterangan'], PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo "<script>window.location='index.php?p=kategori'</script>";
            }
        } catch (PDOException $e) {
            echo "Gagal menambahkan data: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'edit') {
    if (isset($_POST['submit'])) {
        try {
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Query untuk memperbarui data
            $stmt = $pdo->prepare("UPDATE kategori 
                                   SET nama_kategori = :nama_kategori, 
                                       keterangan = :keterangan 
                                   WHERE id = :id");
            $stmt->bindParam(':nama_kategori', $_POST['nama_kategori'], PDO::PARAM_STR);
            $stmt->bindParam(':keterangan', $_POST['keterangan'], PDO::PARAM_STR);
            $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo "<script>window.location='index.php?p=kategori'</script>";
            }
        } catch (PDOException $e) {
            echo "Gagal memperbarui data: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Query untuk menghapus data
        $stmt = $pdo->prepare("DELETE FROM kategori WHERE id = :id");
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            header('Location: index.php?p=kategori'); // Redirect
        }
    } catch (PDOException $e) {
        echo "Gagal menghapus data: " . $e->getMessage();
    }
}
?>
