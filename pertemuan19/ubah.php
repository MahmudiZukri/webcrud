<?php 
session_start();

if ( isset($_SESSION["login"]) === false ) {
	header("Location: login.php");
	exit; 
}

require'functions.php';

// ambil data di URL
$id = $_GET["id"];
// query data mahasiswa berdasarkan id nya
$hape = query("SELECT * FROM handphone WHERE id = $id")[0];



//CEK APAKAH TOMBOL SUBMIT SUDAH DITEKAN ATAU BELUM
if (isset($_POST["submit"])) {

	//apakah data berhasil diubah atau tidak
	// $_POST mengambil data dari $data di function data
	if ( ubah($_POST) > 0) { //itu ubah adalah Function
		echo "	<script>
					alert('Data berhasil Diubah!')
					document.location.href = 'index.php';
				</script>";
	} else{
		echo "	<script>
					alert('Data Gagal Diubah!')
				</script>";
		echo mysqli_error($conn);
	}
}



 ?>

<!DOCTYPE html>
<html>
<head>
	<title>Ubah Data</title>
</head>
<body>

<h1>Ubah Data Handphone</h1>

<form action="" method="post" enctype="multipart/form-data">
	<!-- fungsi type hidden adalah agar tidak dilihat oleh user tapi untuk developer -->
	<input type="hidden" name="id" value="<?= $hape["id"]; ?>">
	<input type="hidden" name="gambarLama" value="<?= $hape["gambar"]; ?>">
	<ul>
		<li>
			<label for="nama">Nama :</label>   
			<input type="text" name="nama" id="nama" required value="<?= $hape["nama"]; ?>"> <!-- Fungsi required adalah untuk memberi tahu user bahwa ada kolom yang kosong harus di isi -->
		</li>
		<li>
			<label for="kode">Kode :</label>
			<input type="text" name="kode" id="kode" required value="<?= $hape["kode"]; ?>">
		</li>
		<li>
			<label for="merk">Merk :</label>
			<input type="text" name="merk" id="merk" required value="<?= $hape["merk"]; ?>">
		</li>
		<li>
			<label for="warna">Warna :</label>
		  	<input type="text" name="warna" id="warna" required value="<?= $hape["warna"]; ?>">
		</li>
		<li>
			<label for="harga">Harga :</label>
			<input type="text" name="harga" id="harga" required value="<?= $hape["harga"]; ?>">
		</li>
		<li>
			<label for="gambar">Gambar :</label><br>
			<img src="img/<?= $hape["gambar"];?>"><br>
			<input type="file" name="gambar" id="gambar">
		</li>
		<li>
			<button type="submit" name="submit"  onclick="return confirm('Apakah Data Anda Yakin Ingin Mengubahnya?');">Ubah Data!</button>
		</li>
	</ul>
</form>


<a href="index.php">Kembali kehalaman awal</a>
</body>
</html>