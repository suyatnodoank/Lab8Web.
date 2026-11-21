<?php
include("koneksi.php");

// query untuk menampilkan data
$sql = 'SELECT * FROM data_barang';
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Data Barang</title>
</head>
<body>
    <div class="container wide">
        <h1>Data Barang</h1>
        <div class="main">
            <a href="tambah.php" class="btn-tambah">Tambah Barang</a>
            <table>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="gambar/<?= htmlspecialchars($row['gambar']); ?>"
                                     alt="<?= htmlspecialchars($row['nama']); ?>"
                                     width="80">
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['kategori']); ?></td>
                        <td><?= htmlspecialchars($row['harga_jual']); ?></td>
                        <td><?= htmlspecialchars($row['harga_beli']); ?></td>
                        <td><?= htmlspecialchars($row['stok']); ?></td>
                        <td class="aksi">
                            <a class="ubah" href="ubah.php?id=<?= (int)$row['id_barang']; ?>">Ubah</a>
                            <a class="hapus" href="hapus.php?id=<?= (int)$row['id_barang']; ?>"onclick="return confirm('Yakin mau hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Belum ada data</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>
</html>