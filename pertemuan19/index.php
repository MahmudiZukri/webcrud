<?php 
session_start();

if ( isset($_SESSION["login"]) === false ) {
	header("Location: login.php");
	exit; 
}

require'functions.php'; // mengambil data dari file functions.php agar tidak terlalu banyak disini
$handphone = query("SELECT * FROM handphone ORDER BY id ASC"); //array associative yang valuenya udah dari database

//tombol cari ditekan
if( isset($_POST["cari"]) ){
	$handphone = cari($_POST["keyword"]);
}

 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Admin</title>
	<style>
		table{
			margin: auto;
			text-align: center;
			width: 1000px;}

		form {
			float: right;
			padding-bottom: 5px;
		}
		.table{
			width: 1000px;
			margin:auto;
		}
		</style>
</head>
<body>
<h1>Daftar Handphone</h1>

<a href="tambah.php">Tambah Data </a> | 
<a href="logout.php">Logout</a>


<div class="table">
	
	<div class="seacrh">
		<form action="" method="post">
			<input type="text" name="keyword" size="30" autofocus placeholder="cari disini" autocomplete="off"> <!--fungsi size ukuran dari input, autofocus agar langsung fokus ke input, placeholder untuk mengisi kata di textfield, autocomplete untuk riwayat agar hilang jika off-->
			<button type="submit" name="cari">Cari</button>
		</form>
	</div>	


	<table border="5px;" cellpadding="5px;" cellspacing="2px;">
		<tr>
			<th>No.</th>
			<th>Aksi</th>
			<th>Gambar</th>
			<th>Kode Barang</th>
			<th>Nama</th>
			<th>Merk</th>
			<th>Warna</th>
			<th>Harga</th>
		</tr>
		<?php $i="1"; ?> 
		<?php foreach( $handphone as $hp): ?>
		<tr>
			<td><?= $i; ?>.</td>
			<td><a href="ubah.php?id=<?= $hp["id"]; ?>">Ubah</a> | 
				<a href="hapus.php?id=<?= $hp["id"]; ?>" onclick="return confirm('Apakah Anda Ingin Menghapus?');">Hapus</a></td>
			
			<td><img src="img/<?= $hp["gambar"]; ?>"></td>
			<td><?= $hp["kode"]; ?></td>
			<td><?= $hp["nama"]; ?></td>
			<td><?= $hp["merk"]; ?></td>
			<td><?= $hp["warna"]; ?></td>
			<td>Rp.<?= $hp["harga"]; ?>,-</td>
		</tr>
		<?php $i++; ?>
		<?php endforeach ?>
	</table>
</div>

<script src="js/script.js"></script>
</body>
</html>