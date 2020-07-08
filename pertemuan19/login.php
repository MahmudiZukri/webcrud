<?php 
session_start();
require 'functions.php';

//cek apakah masih ada cookienya
 if ( isset($_COOKIE['id']) && isset($_COOKIE['key']) ) { // $_cookie['id'] dan key di dapat dari syntax cookie di baris ke 42 dan 43
 	$id = $_COOKIE['id'];
 	$key = $_COOKIE['key'];

 	// ambil username berdasarkan id
 	$result = mysqli_query($conn, "SELECT username FROM akun WHERE id = $id");
 	$cokname = mysqli_fetch_assoc($result); // cokname isinya adalah username dari database

 	//cek cookie dan username
 	if( $key === hash('sha256', $cokname['username']) ){ //$key adalah username yang sudah di acak, di cek apakah sama dena  username di tabel database yang juga diacak
 		$_SESSION['login'] = true; //jika hasil diatas sama, maka ke session
 	}
}

// cek apakah masih ada session loginnya
// jika session true maka akan ke index.php
if ( isset($_SESSION["login"]) ) {
	header("Location: index.php");
	exit;
}



if ( isset($_POST["login"]) ) {
	
	$username = $_POST["username"];
	$password = $_POST["password"];

	$result = mysqli_query($conn, "SELECT * FROM AKUN WHERE username = '$username' "); // $username disini maksudnya yang sama dengan $usernamenya, jadi dia hanya mencari yang usernamnenya sama dengan $username

	//cek username 
	if( mysqli_num_rows($result) === 1 ) { //untuk menghitung ada berapa baris yang ditemukan dari query sebelumnya di tabel database

		//cek password didatabase
		$tabel = mysqli_fetch_assoc($result);
		if( password_verify($password, $tabel["password"]) ) { //membandingkan password yang di input dan di databse
			// set session
			$_SESSION["login"] = true; // jika session true di halaman yang lain, maka sebelumnya sudah login

			//JIKA PASSWORD SUDAH BENAR, MAKA DI CEK APAKAH MAU PAKAI REMEMBER ME ATAU TIDAK
			// CEK REMEMBER ME
			if ( isset($_POST['remember']) ) { // cek apakah checkbox remember di centang, jika iya kita buat cookienya
				//buat cookie nya
				setcookie('id', $tabel['id'], time()+360);// nama cookienya id(boleh lain agar tidak terdeteksi hacker, karena jika yang sebenarnya cukup riskan) dan isinya adalah id tang di ambil dari $tabel yang sudah fetch dari database dan waktunya 360detik
				setcookie('key', hash('sha256', $tabel['username']), time()+360); //key adalah nama cookienya, dan isinya sekalian di generate acak dengan algoritma sha256 yang adalah username dari database
			}

			header("Location: index.php");
			exit;
		}
	} 
	$error = true;
}

 ?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

<h1>Halaman Login</h1>

<?php if( isset($error) ) : ?>
	<p style="color: red; font-style: italic;">Username / Password anda salah</p>
<?php endif ?>


<form action="" method="post">
	
	<ul>
		<li>
			<label for="username">USERNAME :</label>
			<input type="text" name="username" id="username">
		</li>
		<li>
			<label for="password">PASSWORD :</label>
			<input type="password" name="password" id="password">
		</li>
		<li>
			<input type="checkbox" name="remember" id="remember">
			<label for="remember">Remember me</label>
		</li>
		<li>
			<button type="submit" name="login">LOGIN</button>
		</li>
	</ul>

</form>

</body>
</html>