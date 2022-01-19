<?php
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: ../login.php");
	exit;
}

require 'functions.php';

// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
	
	// cek apakah data berhasil di tambahkan atau tidak
	if( tambah($_POST) > 0 ) {
		echo "
			<script>
				alert('data berhasil ditambahkan!');
				document.location.href = 'read.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal ditambahkan!');
				document.location.href = 'read.php';
			</script>
		";
	}


}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tambah data barang</title>
</head>
<body>
	<h1>Tambah data barang</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<ul>
			<input type="hidden" name="id_barang" value="<?= rand(0000,9999); ?>">
			<li>
				<label for="barang">Nama Barang : </label>
				<input type="text" name="barang" id="barang" required>
			</li>
			<li>
				<label for="jumlah">Jumlah : </label>
				<input type="number" name="jumlah" id="jumlah" required>
			</li>
			<li>
				<label for="satuan">Satuan : </label>
				<input type="text" name="satuan" id="satuan" required>
			</li>
			<li>
				<label for="harga">Harga : </label>
				<input type="text" name="harga" id="harga" required>
			</li>
			<li>
				<label for="gambar">Gambar :</label>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<label for="keterangan">Keterangan : </label>
				<textarea name="keterangan" id="keterangan" cols="30" rows="10"></textarea>
			</li>
			<li>
				<button type="submit" name="submit">Tambah Data!</button>
			</li>
		</ul>

	</form>
</body>
</html>