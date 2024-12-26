<?php
include 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
?>
<section class="content">
    <div class="">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Table USER</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <a href="index.php?p=user&aksi=input" class="btn btn-success btn-lg">
                            <i class="fas fa-plus-circle"></i> Tambah USER
                        </a>
                    </div>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Email</th>
                                <th>Nama Lengkap</th>
                                <th>Level</th>
                                <th>No Telpon</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM level INNER JOIN user ON level.id = user.level_id");
                            $no = 1;
                            while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td><?= $no ?></td>
                                    <td><?= $data['email'] ?></td>
                                    <td><?= $data['nama_lengkap'] ?></td>
                                    <td><?= $data['nama_level'] ?></td>
                                    <td><?= $data['notelp'] ?></td>
                                    <td><?= $data['alamat'] ?></td>
                                    <td>
                                        <a href="index.php?p=user&aksi=edit&id=<?= $data['id'] ?>" class="btn btn-success">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="proses_user.php?proses=delete&id=<?= $data['id'] ?>" class="btn btn-danger" onclick="return confirm('Yakin dihapus?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
break;

    case 'input':
?>
<div class="container">
    <div class="row">
        <div class="col-md-5 offset-md">
            <h1 class="h2">Input User</h1>
            <form action="proses_user.php?proses=insert" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="level_id" class="form-label">Level ID</label>
                    <select name="level_id" class="form-select" id="level_id" required>
                        <option value="">-Pilih level-</option>
                        <?php
                        $stmt_level = $pdo->query("SELECT * FROM level");
                        while ($data_level = $stmt_level->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$data_level['id']}'>{$data_level['nama_level']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telpon</label>
                    <input type="tel" class="form-control" name="notelp" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" required></textarea>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-10">
                        <input type="file" name="fileToUpload" class="form-control" id="file-upload" required>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <img src="#" alt="Preview Uploaded Image" id="file-preview" width="300">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                <button type="reset" class="btn btn-secondary" name="reset">Reset</button>
            </form>
        </div>
    </div>
</div>
<script>
    const input = document.getElementById('file-upload');
    const previewPhoto = () => {
        const file = input.files;
        if (file) {
            const fileReader = new FileReader();
            const preview = document.getElementById('file-preview');
            fileReader.onload = function(event) {
                preview.setAttribute('src', event.target.result);
            }
            fileReader.readAsDataURL(file[0]);
        }
    }
    input.addEventListener("change", previewPhoto);
</script>
<?php
break;

case 'edit':
    
    include 'koneksi.php';
    $stmt = $pdo->prepare("SELECT * FROM user WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $data_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data_user) {
        echo "Data tidak ditemukan!";
        exit;
    }
?>
<div class="container">
    <div class="row">
        <div class="col-md-5 offset-md">
            <h1 class="h2">Edit User</h1>
            <form action="proses_user.php?proses=edit" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">ID</label>
                    <input type="number" class="form-control" name="id" value="<?= $data_user['id'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="<?= $data_user['email'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Isi jika ingin mengganti password">
                </div>
                <div class="mb-3">
                    <label for="level_id" class="form-label">Level ID</label>
                    <select name="level_id" class="form-select" id="level_id" required>
                        <option value="">-Pilih level-</option>
                        <?php
                        $stmt_level = $pdo->query("SELECT * FROM level");
                        while ($data_level = $stmt_level->fetch(PDO::FETCH_ASSOC)) {
                            $selected = ($data_level['id'] == $data_user['level_id']) ? 'selected' : '';
                            echo "<option value='{$data_level['id']}' $selected>{$data_level['nama_level']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" value="<?= $data_user['nama_lengkap'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telp</label>
                    <input type="tel" class="form-control" name="notelp" value="<?= $data_user['notelp'] ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea class="form-control" name="alamat" required><?= $data_user['alamat'] ?></textarea>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Photo</label>
                    <div class="col-sm-10">
                        <input type="file" name="fileToUpload" class="form-control" id="file-upload">
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10">
                        <?php if ($data_user['photo']): ?>
                            <img src="upload/<?= $data_user['photo'] ?>" alt="Preview Uploaded Image" id="file-preview" width="300">
                        <?php else: ?>
                            <img src="#" alt="Preview Uploaded Image" id="file-preview" width="300">
                        <?php endif; ?>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>
<?php
    break;
                        }
?>


