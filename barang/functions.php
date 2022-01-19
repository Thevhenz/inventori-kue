<?php

// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori") or die ("Connection failed!!");


function query($query) {
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
	}
	return $rows;
}


function tambah($data) {
	global $conn;

	$id_barang = htmlspecialchars($data["id_barang"]);
	$barang = htmlspecialchars($data["barang"]);
	$jumlah = htmlspecialchars($data["jumlah"]);
	$satuan = htmlspecialchars($data["satuan"]);
	$harga = htmlspecialchars($data["harga"]);
	$keterangan = htmlspecialchars($data["keterangan"]);

	// upload gambar
	$gambar = upload();
	if( !$gambar ) {
		return false;
	}

	$query = "INSERT INTO `barang` VALUES ('$id_barang', '$barang', '$satuan', '$harga', '$jumlah', '$gambar', '$keterangan')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}


function upload() {

	$namaFile = $_FILES['gambar']['name'];
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang diupload
	if( $error === 4 ) {
		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			  </script>";
		return false;
	}

	// cek apakah yang diupload adalah gambar
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);
	$ekstensiGambar = strtolower(end($ekstensiGambar));
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ) {
		echo "<script>
				alert('yang anda upload bukan gambar!');
			  </script>";
		return false;
	}

	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 1000000 ) {
		echo "<script>
				alert('ukuran gambar terlalu besar!');
			  </script>";
		return false;
	}

	// lolos pengecekan, gambar siap diupload
	// generate nama gambar baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiGambar;

	move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

	return $namaFileBaru;
}




function hapus($id_barang) {
	global $conn;
	mysqli_query($conn, "DELETE FROM barang WHERE id_barang = $id_barang");
	return mysqli_affected_rows($conn);
}


function ubah($data) {
	global $conn;

	$id_barang = $data["id_barang"];
	$barang = htmlspecialchars($data["barang"]);
	$jumlah = htmlspecialchars($data["jumlah"]);
	$satuan = htmlspecialchars($data["satuan"]);
	$harga = htmlspecialchars($data["harga"]);
	$gambarLama = htmlspecialchars($data["gambarLama"]);
	$keterangan = htmlspecialchars($data["keterangan"]);
	
	// cek apakah user pilih gambar baru atau tidak
	if( $_FILES['gambar']['error'] === 4 ) {
		$gambar = $gambarLama;
	} else {
		$gambar = upload();
	}
	

	$query = "UPDATE `barang` SET `barang` = '$barang', `satuan` = '$satuan', `harga` = '$harga', `jumlah` = '$jumlah', `gambar` = '$gambar', `keterangan` = '$keterangan' WHERE `barang`.`id_barang` = id_barang";
			


	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);	
}


function cari($keyword) {
	$query = "SELECT * FROM barang
				WHERE
			  barang LIKE '%$keyword%' OR
			  jumlah LIKE '%$keyword%' OR
			  satuan LIKE '%$keyword%' OR
			  harga LIKE '%$keyword%' OR
			  keterangan LIKE '%$keyword%'
			";
	return query($query);
}

?>