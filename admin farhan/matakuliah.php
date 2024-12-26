<?php
require_once 'koneksi.php';
$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';
switch ($aksi) {
    case 'list':
        ?>
        <!-- Content Header -->

        <!-- Main content -->
        <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                        <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-list"></i> Matakuliah</h3>
                        </div>
                
                  </div>
                </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th><i class="fas fa-key"></i> ID</th>
                                    <th><i class="fas fa-barcode"></i> Kode Matakuliah</th>
                                    <th><i class="fas fa-book"></i> Nama Matakuliah</th>
                                    <th><i class="fas fa-calendar-alt"></i> Semester</th>
                                    <th><i class="fas fa-tags"></i> Jenis Matakuliah</th>
                                    <th><i class="fas fa-award"></i> SKS</th>
                                    <th><i class="fas fa-clock"></i> Jam</th>
                                    <th><i class="fas fa-sticky-note"></i> Keterangan</th>
                                    <th><i class="fas fa-cogs"></i> Aksi</th>
                                </tr>

                                <?php
                                try {
                                    $query = "SELECT * FROM matakuliah";
                                    $stmt = $pdo->prepare($query);
                                    $stmt->execute();
                                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($data['id']) ?></td>
                                            <td><?= htmlspecialchars($data['kode_matkul']) ?></td>
                                            <td><?= htmlspecialchars($data['nama_matkul']) ?></td>
                                            <td><?= htmlspecialchars($data['semester']) ?></td>
                                            <td><?= htmlspecialchars($data['jenis_matkul']) ?></td>
                                            <td><?= htmlspecialchars($data['sks']) ?></td>
                                            <td><?= htmlspecialchars($data['jam']) ?></td>
                                            <td><?= htmlspecialchars($data['keterangan']) ?></td>
                                            <td>
                                                <a href="index.php?p=matakuliah&aksi=edit&id=<?= htmlspecialchars($data['id']) ?>" 
                                                   class="btn btn-success btn-sm">
                                                   <i class="fas fa-edit"></i> Edit
                                                </a>
                                                <a href="proses_matkul.php?proses=delete&id=<?= htmlspecialchars($data['id']) ?>" 
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Yakin mau dihapus?')">
                                                   <i class="fas fa-trash"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } catch(Exception $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                ?>

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
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                   
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
        <div class="row">
                <div class="col-6 mx-auto">
                    <div class="card">
                        <div class="card-header">
                        <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-user-plus"></i> Tambah Matakuliah</h3>
                        </div>
                    <div class="card-body">
                        <form action="proses_matkul.php?proses=insert" method="post">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                </div>
                                <input type="text" class="form-control" name="kode_matkul" placeholder="Kode Matakuliah">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                                </div>
                                <input type="text" class="form-control" name="nama_matkul" placeholder="Nama Matakuliah">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" name="semester" placeholder="Semester">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="jenis_matkul" placeholder="Jenis Matakuliah">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                </div>
                                <input type="number" class="form-control" name="sks" placeholder="SKS">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                </div>
                                <input type="text" class="form-control" name="jam" placeholder="Jam">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                </div>
                                <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan"></textarea>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                                <button type="reset" class="btn btn-warning" name="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
        break;

    case 'edit':
        $id = $_GET['id'];
        try {
            $query = "SELECT * FROM matakuliah WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $data_matakuliah = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data_matakuliah) {
                echo "Data tidak ditemukan";
                exit;
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        ?>
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-edit"></i> Edit Matakuliah</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-pen"></i> Form Edit Matakuliah</h3>
                    </div>
                    <div class="card-body">
                        <form action="proses_matkul.php?proses=edit" method="post">
                            <input type="hidden" class="form-control" name="id" value="<?= htmlspecialchars($data_matakuliah['id']) ?>">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-code"></i></span>
                                </div>
                                <input type="text" class="form-control" name="kode_matkul" 
                                       value="<?= htmlspecialchars($data_matakuliah['kode_matkul']) ?>" placeholder="Kode Matakuliah">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-book"></i></span>
                                </div>
                                <input type="text" class="form-control" name="nama_matkul" 
                                       value="<?= htmlspecialchars($data_matakuliah['nama_matkul']) ?>" placeholder="Nama Matakuliah">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                </div>
                                <input type="text" class="form-control" name="semester" 
                                       value="<?= htmlspecialchars($data_matakuliah['semester']) ?>" placeholder="Semester">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                </div>
                                <input type="text" class="form-control" name="jenis_matkul" 
                                       value="<?= htmlspecialchars($data_matakuliah['jenis_matkul']) ?>" placeholder="Jenis Matakuliah">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                </div>
                                <input type="number" class="form-control" name="sks" 
                                       value="<?= htmlspecialchars($data_matakuliah['sks']) ?>" placeholder="SKS">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                </div>
                                <input type="text" class="form-control" name="jam" 
                                       value="<?= htmlspecialchars($data_matakuliah['jam']) ?>" placeholder="Jam">
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-comment-dots"></i></span>
                                </div>
                                <textarea class="form-control" rows="3" name="keterangan" placeholder="Keterangan"><?= htmlspecialchars($data_matakuliah['keterangan']) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-warning" name="submit">Update</button>
                                <button type="reset" class="btn btn-default" name="reset">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
        break;
}
?>
