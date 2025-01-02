<?php
include 'koneksi.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['submit'])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO dosen (nik, nama_dosen, email, prodi_id, notelp, alamat) 
                                 VALUES (:nik, :nama_dosen, :email, :prodi_id, :notelp, :alamat)");
            
            $stmt->execute([
                ':nik' => $_POST['nik'],
                ':nama_dosen' => $_POST['nama_dosen'],
                ':email' => $_POST['email'],
                ':prodi_id' => $_POST['prodi_id'],
                ':notelp' => $_POST['notelp'],
                ':alamat' => $_POST['alamat']
            ]);

            header('Location: index.php?p=dosen');
            exit();
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'edit') {
    if (isset($_POST['submit'])) {
        try {
            $stmt = $pdo->prepare("UPDATE dosen 
                                 SET nik = :nik,
                                     nama_dosen = :nama_dosen,
                                     email = :email,
                                     prodi_id = :prodi_id,
                                     notelp = :notelp,
                                     alamat = :alamat
                                 WHERE id = :id");
            
            $params = [
                ':id' => $_POST['id'],
                ':nik' => $_POST['nik'],
                ':nama_dosen' => $_POST['nama_dosen'],
                ':email' => $_POST['email'],
                ':prodi_id' => $_POST['prodi_id'],
                ':notelp' => $_POST['notelp'],
                ':alamat' => $_POST['alamat']
            ];
            
            $stmt->execute($params);
            header('Location: index.php?p=dosen');
            exit();
            
        } catch(PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $pdo->prepare("DELETE FROM dosen WHERE id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        
        header('location:index.php?p=dosen');
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
