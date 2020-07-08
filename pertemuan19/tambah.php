<?php 
session_start();

if ( isset($_SESSION["login"]) === false ) {
	header("Location: login.php");
	exit; 
}

require'functions.php';

//CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN ATAU BELUM
if (isset($_POST["submit"])) {

	//apakah data berhasil ditambahkan atau tidak
	// $_POST mengambil data dari $data di function data
	if ( tambah($_POST) > 0) { //
		echo "	<script>
					alert('Data berhasil Ditambahkan!')
					document.location.href = 'index.php';
				</script>";
	} else{
		echo "	<script>
					alert('Data Gagal Ditambahkan!')
				</script>";
		echo mysqli_error($conn);
	}

	
 
	
	
}



 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Tambah Data</title>
</head>
<body>

<h1>Tambahkan Data Handphone</h1>

<form action="" method="post" enctype="multipart/form-data"> <!-- enctype untuk mengolah file dengan $_FILES -->
	<ul>
		<li>
			<label for="nama">Nama :</label>   
			<input type="text" name="nama" id="nama" required> <!-- Fungsi required adalah untuk memberi tahu user bahwa ada kolom yang kosong harus di isi -->
		</li>
		<li>
			<label for="kode">Kode :</label>
			<input type="text" name="kode" id="kode" required>
		</li>
		<li>
			<label for="merk">Merk :</label>
			<input type="text" name="merk" id="merk" required>
		</li>
		<li>
			<label for="warna">Warna :</label>
			<input type="text" name="warna" id="warna" required>
		</li>
		<li>
			<label for="harga">Harga :</label>
			<input type="text" name="harga" id="harga" required>
		</li>
		<li>
			<label for="gambar">Gambar :</label>
			<input type="file" name="gambar" id="gambar"> <!--type file karena yang di inputkan dan di olah nanti adalah gambar yang berupa file -->
		</li>
		<li>
			<button type="submit" name="submit">Masukkan Data!</button>
		</li>
	</ul>
</form>


<a href="index.php">Kembali kehalaman awal</a>
</body>
</html>