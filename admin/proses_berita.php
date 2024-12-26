<?php
session_start();
$target_dir = "upload/";
$nama_file = rand() . '-' . basename($_FILES["fileToUpload"]["name"]);
$target_file = $target_dir . $nama_file;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

include 'koneksi.php'; 

if (isset($_GET['proses'])) {
    $proses = $_GET['proses'];
    $uploadOk = 1;
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . (basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                error_log("Error moving uploaded file to $target_file. Check file permissions and path.");
            }
        }
    } else {
        if ($proses == 'edit') {
            $nama_file = $_POST['file_lama']; 
        } else {
            echo "No file uploaded or there was an error uploading the file.";
            $uploadOk = 0;
        }
    }

    if ($uploadOk) {
        try {
            if ($proses == 'insert') {
                if (isset($_SESSION['user_id'])) {
                    $user_id = $_SESSION['user_id'];
                } else {
                    echo "User is not logged in.";
                    exit;
                }

                $stmt = $pdo->prepare("INSERT INTO berita (user_id, kategori_id, judul, file_upload, isi_berita, created_at) 
                                      VALUES (:user_id, :kategori_id, :judul, :file_upload, :isi_berita, NOW())");
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':kategori_id', $_POST['kategori_id']);
                $stmt->bindParam(':judul', $_POST['judul']);
                $stmt->bindParam(':file_upload', $nama_file);
                $stmt->bindParam(':isi_berita', $_POST['isi_berita']);

                if ($stmt->execute()) {
                    echo "<script>window.location='index.php?p=berita'</script>";
                } else {
                    echo "Error: " . $stmt->errorInfo()[2];
                }
            }

            if ($proses == 'edit') {
                $stmt = $pdo->prepare("UPDATE berita SET
                                      user_id      = :user_id,
                                      kategori_id  = :kategori_id,
                                      judul        = :judul,
                                      file_upload  = :file_upload,
                                      isi_berita   = :isi_berita,
                                      created_at   = NOW()
                                      WHERE id = :id");

                $stmt->bindParam(':user_id', $_SESSION['user_id']);
                $stmt->bindParam(':kategori_id', $_POST['kategori_id']);
                $stmt->bindParam(':judul', $_POST['judul']);
                $stmt->bindParam(':file_upload', $nama_file);
                $stmt->bindParam(':isi_berita', $_POST['isi_berita']);
                $stmt->bindParam(':id', $_POST['id']);

                if ($stmt->execute()) {
                    echo "<script>window.location='index.php?p=berita'</script>";
                } else {
                    echo "Error: " . $stmt->errorInfo()[2];
                }
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    if ($proses == 'delete') {
        try {
            $stmt = $pdo->prepare("DELETE FROM berita WHERE id = :id");
            $stmt->bindParam(':id', $_GET['id']);
            if ($stmt->execute()) {
                unlink('upload/' . $_GET['file']);
                header('Location: index.php?p=berita');
                exit;
            } else {
                echo "Error: " . $stmt->errorInfo()[2];
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Proses tidak ditemukan.";
}
?>
