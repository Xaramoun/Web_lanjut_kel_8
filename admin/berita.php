<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Berita</title>
</head>
<body>
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Berita</h1>
    </div>

    <?php
    include 'koneksi.php'; 
    $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

    switch ($aksi) {
        case 'list':
            ?>
            <div class="row">
                <div class="col-2 mb-3">
                    <a href="index.php?p=berita&aksi=input" class="btn btn-primary">
                        <i class="fas fa-user-plus"></i> Tambah Berita
                    </a>
                </div>

                <div class="card-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>User</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            try {
                                $stmt = $pdo->prepare("SELECT user.*, kategori.*, berita.* 
                                    FROM berita 
                                    INNER JOIN user ON user.id = berita.user_id 
                                    INNER JOIN kategori ON kategori.id = berita.kategori_id");
                                $stmt->execute();
                                $no = 1;

                                while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($data['judul']) ?></td>
                                        <td><?= htmlspecialchars($data['nama_kategori']) ?></td>
                                        <td><?= htmlspecialchars($data['email']) ?></td>
                                        <td><?= htmlspecialchars($data['created_at']) ?></td>
                                        <td>
                                            <a href="index.php?p=berita&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="proses_berita.php?proses=delete&id=<?= $data['id'] ?>&file=<?= htmlspecialchars($data['file_upload']) ?>" class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } catch (PDOException $e) {
                                echo "Error: " . $e->getMessage();
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            break;

        case 'input':
            ?>

            <div class="row">
                <div class="col-6 mx-auto">
                    <h2>Form Tambah Berita</h2>
                    <form action="proses_berita.php?proses=insert" method="post" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                try {
                                    $stmt = $pdo->prepare("SELECT * FROM kategori");
                                    $stmt->execute();
                                    while ($data_kategori = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value=\"{$data_kategori['id']}\">{$data_kategori['nama_kategori']}</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Upload</label>
                            <input type="file" class="form-control" name="fileToUpload" id="file-upload" accept="image/*" required>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Preview Image</label>
                            <img src="#" alt="Preview Uploaded Image" id="file-preview" width="300" style="display: none;">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Berita</label>
                            <textarea class="form-control" rows="5" name="isi_berita" required></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                            <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php
            break;

        case 'edit':
            try {
                $stmt = $pdo->prepare("SELECT * FROM berita WHERE id = :id");
                $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);
                $stmt->execute();
                $data_berita = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            ?>

            <div class="row">
                <div class="col-6 mx-auto">
                    <h2>Edit Data Berita</h2>
                    <form action="proses_berita.php?proses=edit" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $data_berita['id'] ?>">
                        <div class="mb-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($data_berita['judul']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                try {
                                    $stmt = $pdo->prepare("SELECT * FROM kategori");
                                    $stmt->execute();
                                    while ($data_kategori = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        $selected = ($data_berita['kategori_id'] == $data_kategori['id']) ? 'selected' : '';
                                        echo "<option value=\"{$data_kategori['id']}\" $selected>{$data_kategori['nama_kategori']}</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">File Upload</label>
                            <input type="file" class="form-control" name="fileToUpload" id="file-upload" accept="image/*">
                            <small>File saat ini: <?= htmlspecialchars($data_berita['file_upload']) ?></small>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Preview Image</label>
                            <img src="upload/<?= htmlspecialchars($data_berita['file_upload']) ?>" alt="Preview Upload Image" id="file-preview" width="300">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Berita</label>
                            <textarea class="form-control" rows="5" name="isi_berita" required><?= htmlspecialchars($data_berita['isi_berita']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>
                        <hr>
                    </form>
                </div>
            </div>
            <?php
            break;
    }
    ?>
    <script>
        const input = document.getElementById('file-upload');
        const preview = document.getElementById('file-preview');
        
        const previewPhoto = () => {
            const file = input.files[0];
            if (file) {
                const fileReader = new FileReader();
                fileReader.onload = function (event) {
                    preview.src = event.target.result;
                    preview.style.display = "block"; 
                }
                fileReader.readAsDataURL(file);
            }
        }

        input.addEventListener("change", previewPhoto);
    </script>
</div>
</body>
</html>
