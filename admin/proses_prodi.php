<?php
include 'koneksi.php'; 

try {
    if (isset($_GET['proses']) && $_GET['proses'] == 'insert') {
        if (isset($_POST['nama_prodi'], $_POST['jenjang_std'])) {
            $nama_prodi = $_POST['nama_prodi'];
            $jenjang_std = $_POST['jenjang_std']; 

            $sql = $pdo->prepare("INSERT INTO prodi (nama_prodi, jenjang_std) VALUES (:nama_prodi, :jenjang_std)");
            $sql->bindParam(':nama_prodi', $nama_prodi);
            $sql->bindParam(':jenjang_std', $jenjang_std);

            if ($sql->execute()) {
                echo "<script>window.location='index.php?p=prodi'</script>"; 
            } else {
                echo "Error: Gagal menambahkan data.";
            }
        }
    }
    if (isset($_GET['proses']) && $_GET['proses'] == 'edit') {
        if (isset($_POST['id'], $_POST['nama_prodi'], $_POST['jenjang_std'])) {
            $id = $_POST['id'];
            $nama_prodi = $_POST['nama_prodi'];
            $jenjang_std = $_POST['jenjang_std']; 
            $sql = $pdo->prepare("UPDATE prodi SET nama_prodi = :nama_prodi, jenjang_std = :jenjang_std WHERE id = :id");
            $sql->bindParam(':nama_prodi', $nama_prodi);
            $sql->bindParam(':jenjang_std', $jenjang_std); 
            $sql->bindParam(':id', $id, PDO::PARAM_INT);
            if ($sql->execute()) {
                echo "<script>window.location='index.php?p=prodi'</script>"; 
            } else {
                echo "Error: Gagal mengubah data.";
            }
        }
    }
    if (isset($_GET['proses']) && $_GET['proses'] == 'delete') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $pdo->beginTransaction();
                $sql_prodi = $pdo->prepare("DELETE FROM prodi WHERE id = :id");
                $sql_prodi->bindParam(':id', $id, PDO::PARAM_INT);

                if ($sql_prodi->execute()) {
                    $pdo->commit();
                    header('Location: index.php?p=prodi'); 
                } else {
                    $pdo->rollBack();
                    echo "Error: Gagal menghapus data prodi.";
                }
            } catch (PDOException $e) {
                $pdo->rollBack(); 
                echo "Error: " . $e->getMessage(); 
            }
        }
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage(); 
}
?>
