<?php 
require_once 'koneksi.php';

if ($_GET['proses'] == 'insert') {
    try {
        $stmt = $db->prepare("INSERT INTO matakuliah (kode_matkul, nama_matkul, semester, jenis_matkul, sks, jam, keterangan) 
                             VALUES (:kode_matkul, :nama_matkul, :semester, :jenis_matkul, :sks, :jam, :keterangan)");
        
        $stmt->execute([
            ':kode_matkul' => $_POST['kode_matkul'],
            ':nama_matkul' => $_POST['nama_matkul'],
            ':semester' => $_POST['semester'],
            ':jenis_matkul' => $_POST['jenis_matkul'],
            ':sks' => $_POST['sks'],
            ':jam' => $_POST['jam'],
            ':keterangan' => $_POST['keterangan']
        ]);
        
        header('Location: index.php?p=matakuliah');
        exit;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'edit') {
    try {
        $stmt = $db->prepare("UPDATE matakuliah SET 
                             kode_matkul = :kode_matkul,
                             nama_matkul = :nama_matkul,
                             semester = :semester,
                             jenis_matkul = :jenis_matkul,
                             sks = :sks,
                             jam = :jam,
                             keterangan = :keterangan 
                             WHERE id = :id");
        
        $stmt->execute([
            ':kode_matkul' => $_POST['kode_matkul'],
            ':nama_matkul' => $_POST['nama_matkul'],
            ':semester' => $_POST['semester'],
            ':jenis_matkul' => $_POST['jenis_matkul'],
            ':sks' => $_POST['sks'],
            ':jam' => $_POST['jam'],
            ':keterangan' => $_POST['keterangan'],
            ':id' => $_POST['id']
        ]);
        
        header('Location: index.php?p=matakuliah');
        exit;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_GET['proses'] == 'delete') {
    try {
        $stmt = $db->prepare("DELETE FROM matakuliah WHERE id = :id");
        $stmt->execute([':id' => $_GET['id']]);
        
        header('Location: index.php?p=matakuliah');
        exit;
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>