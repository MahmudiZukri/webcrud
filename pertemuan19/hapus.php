<?php 
session_start();

if ( isset($_SESSION["login"]) === false ) {
	header("Location: login.php");
	exit; 
}

require'functions.php';

$id = $_GET["id"];

if( hapus($id) > 0){
	echo "	<script>
					alert('Data berhasil Dihapus!')
					document.location.href = 'index.php';
				</script>";
} else{
	echo "	<script>
					alert('Data Dihapus!')
				</script>";
		echo mysqli_error($conn);
}

 ?>