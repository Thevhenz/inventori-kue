<?php 
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: ../login.php");
	exit;
}

require 'functions.php';

// pagination
// konfigurasi
$jumlahDataPerHalaman = 2;
$jumlahData = count(query("SELECT * FROM barang"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = ( isset($_GET["halaman"]) ) ? $_GET["halaman"] : 1;
$awalData = ( $jumlahDataPerHalaman * $halamanAktif ) - $jumlahDataPerHalaman;

$barang = query("SELECT * FROM barang LIMIT $awalData, $jumlahDataPerHalaman");

// tombol cari ditekan
if( isset($_POST["cari"]) ) {
	$barang = cari($_POST["keyword"]);
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Barang</title>
</head>
<body>

<a href="logout.php">Logout</a>

<h1>Daftar Barang</h1>

<a href="tambah.php">Tambah data barang</a>
<br><br>

<form action="" method="post">

	<input type="text" name="keyword" size="40" autofocus placeholder="masukkan keyword pencarian.." autocomplete="off">
	<button type="submit" name="cari">Cari!</button>
	
</form>
<br><br>

<!-- navigasi -->
<a href="?halaman=1">awal</a>

<?php if( $halamanAktif > 1 ) : ?>
	<a href="?halaman=<?= $halamanAktif - 1; ?>">&laquo;</a>
<?php endif; ?>

<?php for( $i = 1; $i <= $jumlahHalaman; $i++ ) : ?>
	<?php if( $i == $halamanAktif ) : ?>
		<a href="?halaman=<?= $i; ?>" style="font-weight: bold; color: red;"><?= $i; ?></a>
	<?php else : ?>
		<a href="?halaman=<?= $i; ?>"><?= $i; ?></a>
	<?php endif; ?>
<?php endfor; ?>

<?php if( $halamanAktif < $jumlahHalaman ) : ?>
	<a href="?halaman=<?= $halamanAktif + 1; ?>">&raquo;</a>
<?php endif; ?>

<a href="?halaman=<?= $jumlahHalaman; ?>">akhir</a>

<br>
<table border="1" cellpadding="10" cellspacing="0">

	<tr>
		<th>No.</th>
		<th>Gambar</th>
		<th>Barang</th>
		<th>Jumlah</th>
		<th>Satuan</th>
		<th>Harga</th>
		<th>Keterangan</th>
		<th>Aksi</th>
	</tr>

	<?php $i = 1; ?>
	<?php foreach( $barang as $row ) : ?>
	<tr>
		<td><?= $i; ?></td>
		<td><img src="img/<?= $row["gambar"]; ?>" width="50"></td>
		<td><?= $row["barang"]; ?></td>
		<td><?= $row["jumlah"]; ?></td>
		<td><?= $row["satuan"]; ?></td>
		<td><?= $row["harga"]; ?></td>
		<td><?= $row["keterangan"]; ?></td>
		<td>
			<a href="ubah.php?id=<?= $row["id_barang"]; ?>">ubah</a> |
			<a href="hapus.php?id=<?= $row["id_barang"]; ?>" onclick="return confirm('yakin?');">hapus</a>
		</td>
	</tr>
	<?php $i++; ?>
	<?php endforeach; ?>
	
</table>

</body>
</html>