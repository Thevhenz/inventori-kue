<?php
session_start();

if( !isset($_SESSION["login"]) ) {
	header("Location: ../login.php");
	exit;
}

require 'functions.php';

// ambil data di URL
$id_barang = $_GET["id"];

// query data barang berdasarkan id
$brg = query("SELECT * FROM barang WHERE id_barang = $id_barang")[0];


// cek apakah tombol submit sudah ditekan atau belum
if( isset($_POST["submit"]) ) {
	
	// cek apakah data berhasil diubah atau tidak
	if( ubah($_POST) > 0 ) {
		echo "
			<script>
				alert('data berhasil diubah!');
				document.location.href = 'read.php';
			</script>
		";
	} else {
		echo "
			<script>
				alert('data gagal diubah!');
				document.location.href = 'read.php';
			</script>
		";
	}


}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Ubah data barang</title>
</head>
<body>
	<h1>Ubah data barang</h1>

	<form action="" method="post" enctype="multipart/form-data">
		<input type="hidden" name="id_barang" value="<?= $brg["id_barang"]; ?>">
		<input type="hidden" name="gambarLama" value="<?= $brg["gambar"]; ?>">
		<ul>
			<li>
				<label for="barang">Barang : </label>
				<input type="text" name="barang" id="barang" required value="<?= $brg["barang"]; ?>">
			</li>
			<li>
				<label for="jumlah">Jumlah : </label>
				<input type="text" name="jumlah" id="jumlah" value="<?= $brg["jumlah"]; ?>">
			</li>
			<li>
				<label for="satuan">Satuan :</label>
				<input type="text" name="satuan" id="satuan" value="<?= $brg["satuan"]; ?>">
			</li>
			<li>
				<label for="harga">Harga :</label>
				<input type="text" name="harga" id="harga" value="<?= $brg["harga"]; ?>">
			</li>
			<li>
				<label for="gambar">Gambar :</label> <br>
				<img src="img/<?= $brg['gambar']; ?>" width="40"> <br>
				<input type="file" name="gambar" id="gambar">
			</li>
			<li>
				<label for="keterangan">Keterangan :</label>
				<input type="text" name="keterangan" id="keterangan" value="<?= $brg["keterangan"]; ?>">
			</li>
			<li>
				<button type="submit" name="submit">Ubah Data!</button>
			</li>
		</ul>

	</form>
</body>
</html>