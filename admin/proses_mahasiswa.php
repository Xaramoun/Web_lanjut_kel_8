<?php
include 'koneksi.php'; // Pastikan koneksi ke database sudah terhubung dengan PDO

// Cek parameter proses
if (isset($_GET['proses'])) {
    $proses = $_GET['proses'];

    // INSERT Data
    if ($proses == 'insert') {
        try {
            $stmt = $pdo->prepare("INSERT INTO mahasiswa 
                                  (nim, nama_mhs, tgl_lahir, jekel, email, notelp, alamat, prodi_id) 
                                  VALUES (:nim, :nama, :tgl_lahir, :jekel, :email, :notelp, :alamat, :prodi_id)");
            $stmt->execute([
                ':nim' => $_POST['nim'],
                ':nama' => $_POST['nama'],
                ':tgl_lahir' => $_POST['tgl_lahir'], // Format tanggal langsung dari input type="date"
                ':jekel' => $_POST['jekel'] ?? 'L', // Default jenis kelamin jika tidak ada
                ':email' => $_POST['email'],
                ':notelp' => $_POST['notelp'],
                ':alamat' => $_POST['alamat'],
                ':prodi_id' => $_POST['prodi_id'],
            ]);
            echo "<script>alert('Data berhasil ditambahkan!'); window.location='index.php?p=mhs';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); history.go(-1);</script>";
        }
    }

    // EDIT Data
    if ($proses == 'edit') {
        try {
            $stmt = $pdo->prepare("UPDATE mahasiswa SET 
                                    nama_mhs = :nama,
                                    tgl_lahir = :tgl_lahir,
                                    jekel = :jekel,
                                    email = :email,
                                    notelp = :notelp,
                                    alamat = :alamat,
                                    prodi_id = :prodi_id
                                  WHERE nim = :nim");
            $stmt->execute([
                ':nama' => $_POST['nama'],
                ':tgl_lahir' => $_POST['tgl_lahir'], // Format tanggal langsung dari input type="date"
                ':jekel' => $_POST['jekel'] ?? 'L',
                ':email' => $_POST['email'],
                ':notelp' => $_POST['notelp'],
                ':alamat' => $_POST['alamat'],
                ':prodi_id' => $_POST['prodi_id'],
                ':nim' => $_POST['nim'],
            ]);
            echo "<script>alert('Data berhasil diperbarui!'); window.location='index.php?p=mhs';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Error: " . $e->getMessage() . "'); history.go(-1);</script>";
        }
    }

    // DELETE Data
    if ($proses == 'delete') {
        if (isset($_GET['nim'])) {
            try {
                $stmt = $pdo->prepare("DELETE FROM mahasiswa WHERE nim = :nim");
                $stmt->execute([':nim' => $_GET['nim']]);
                echo "<script>alert('Data berhasil dihapus!'); window.location='index.php?p=mhs';</script>";
            } catch (PDOException $e) {
                echo "<script>alert('Error: " . $e->getMessage() . "'); history.go(-1);</script>";
            }
        } else {
            echo "<script>alert('Parameter NIM tidak ditemukan!'); history.go(-1);</script>";
        }
    }
} else {
    echo "<script>alert('Parameter proses tidak ditemukan!'); history.go(-1);</script>";
}
?>
