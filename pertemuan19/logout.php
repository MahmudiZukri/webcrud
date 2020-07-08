<?php 
session_start();
$_SESSION = []; 	// agar yakin sessionnya hilang, di isi array kosong
session_unset();	// 	untuk memastikan session terhapus
session_destroy(); 	// 	menghapus session

//cara menghapus cookie
setcookie('id', '', time()-3600); //isi nama cookienya dan kosongkan saja isinya, dan juga buat waktunya -mines, saran 1 jam
setcookie('key', '', time()-3600);

header("Location: login.php");
exit;
 ?>