<?php 

/*	-koneksi ke database
	-Disarankan menggunakan variabel untuk pengkoneksian ke database
	 agar lebih mudah dipanggil, $conn yang disarankan oleh php.net */
$conn = mysqli_connect("localhost", "root", "", "belajarphp7");

function query($query){
	global $conn; //agar variabel conn bisa di gunakan didalam function
	$result = mysqli_query($conn, $query); // mengambil data dari tabel didatabase
	$wadah = []; // sebagai array kosong yang akan di isi dari hasil looping 
	while ($isi = mysqli_fetch_assoc($result) ){ // perulangan dan mengambil object yang ada ditabel
		$wadah[] = $isi;  // hasil perulangan while akan dimasukkan kedalam array associative di $wadah
	}
return $wadah; // dikembalikan 
}


// function tambah ini menerima inputan berupa data dari $_POST
function tambah($data){  
	global $conn;

		//fungsi htmlspecialchars agar tidak membaca inputan dari user yang berupa perintah html agar tidak dijalanka, namun hanya akan menjadi inputan biasa
		$nama = mysqli_real_escape_string($conn, htmlspecialchars($data["nama"])); // mysqli_real_escape_string agar memberi kutip dua ("") diinputan agar karakter seperti kutip 1 (') bisa dibaca, contoh jum'at
		$kode = htmlspecialchars($data["kode"]); 
		$merk = htmlspecialchars($data["merk"]);
		$warna = htmlspecialchars($data["warna"]);
		$harga = htmlspecialchars($data["harga"]);

		//upload gambar
		$gambar = upload();
		if( !$gambar ) { // !$gambar itu sama kaya $gambar === false
			return false;
		}
		  

	//pembuatan query insert data
	$query = "INSERT INTO handphone VALUES ('', 
										'$nama',
										'$kode', 
										'$merk', 
										'$warna', 
										'$harga',
										'$gambar') ";
	//pengquery-an data
	mysqli_query($conn, $query);
		

/* -Cek apakah berhasil atau tidak, ini bisa jadi bagian function tambah
	 	-Fungsi mysqli_affected_rows adalah jika ada yang bertambah hasilnya 1 jika 	gagal 	hasilnya -1, */	
return mysqli_affected_rows($conn); //dikembalikan


// 	echo mysqli_error($conn); /*mysqli_error(koneksidatabase); akan memunculkan
}


function upload(){
	//isi array ini didapatkan dari cek melalui var_dump($_FILES);
	$namaFile = $_FILES['gambar']['name']; 
	$ukuranFile = $_FILES['gambar']['size'];
	$error = $_FILES['gambar']['error'];
	$tmpName = $_FILES['gambar']['tmp_name'];

	// cek apakah tidak ada gambar yang di upload
	if( $error === 4 ) { // error 4 adalah user tidak menginput foto, ada beberapa nilai kesahalan errornya, cari tau sendiri contoh error === 1, dst
		echo "<script>
				alert('pilih gambar terlebih dahulu!');
			  </script>";
	return false; // supaya jika function uploadnya gagal, maka function tambahnya akan gagal menginput data
	}

	// cek apakah yang di upload adalah gambar atau bukan melalui ekstensi filenya
	$ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
	$ekstensiGambar = explode('.', $namaFile);  //fungsi explode untuk memecah sebuah string menjadi array,memecahnya dengan cara delimiliter diisi dengan 												katakter apa yang ada di string  contohnya .(titik)
	$ekstensiGambar = strtolower(end($ekstensiGambar)); //fungsi end adalah agar mengambil array yang terakhir, karena extensi file selalu di akhir nama file. dan strtolower agar semua array yang dipilih menjadi huruf kecil
	// jika !in_array = false akan tampil echo dibawahnya
	if( !in_array($ekstensiGambar, $ekstensiGambarValid) ){ // in_array untuk mengecek sebuah string didalam array, apakah ada string yang sama di dalam array $ekstensiGambar dari $ekstensiGambarValid dan hasilnya true jika ada, false jika tidak ada.
		echo "<script>
				alert('Yang anda masukkan bukan gambar!');
			  </script>";
		return false; 
		}


	// cek jika ukurannya terlalu besar
	if( $ukuranFile > 1000000) { //jika ukuran file lebih besar 1juta byte atau 1mb kira kiranya
		echo "<script>
				alert('Ukuran gambar terlalu besar!');
			  </script>";
	}

	// setelah lolos dari 3 pengecekan di atas, gambar siap di upload
	// untuk memindahkan file yang sudah diupload ke tempat tujuan
	// generate nama gambar baru
	$namaFileBaru = uniqid(); //ini akan membangkitkan string random
	$namaFileBaru .= '.';  //digabungkan .
	$namaFileBaru .= $ekstensiGambar;  //digabungkan ekstensi gambar
	move_uploaded_file($tmpName, 'img/' . $namaFileBaru); 

	return $namaFileBaru;


}





function hapus($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM handphone WHERE id = $id");
		return mysqli_affected_rows($conn);
}
	 

function ubah($data){
global $conn;

		//fungsi htmlspecialchars agar tidak membaca inputan dari user yang berupa codingan menjadi dijalanka, namun hanya akan menjadi tampilan biasa
		$id = $data["id"];
		$nama = htmlspecialchars($data["nama"]);
		$kode = htmlspecialchars($data["kode"]);
		$merk = htmlspecialchars($data["merk"]);
		$warna = htmlspecialchars($data["warna"]);
		$harga = htmlspecialchars($data["harga"]);
		$gambarLama = htmlspecialchars($data["gambarLama"]);

			//CEK APAKAH USER MEMILIH GAMBAR BARU ATAU TIDAK, ATAU MENEKAN TOMBOL PILIH FILE
		if( $_FILES['gambar']['error'] === 4) {
			$gambar = $gambarLama;
		}else{
			$gambar = upload();
		}


	//pembuatan query insert data
	$query = "UPDATE handphone SET
					nama = '$nama',
					kode = '$kode',
					merk = '$merk',
					warna = '$warna',
					harga = '$harga',
					gambar = '$gambar' 
					WHERE id = $id ";
	//pengquery-an data
	mysqli_query($conn, $query);

/* -Cek apakah berhasil atau tidak, ini bisa jadi bagian function tambah
	 	-Fungsi mysqli_affected_rows adalah jika ada yang bertambah hasilnya 1 jika 	gagal 	hasilnya -1, */	
return mysqli_affected_rows($conn); //dikembalikan

}

function cari($keyword){
	$quuery ="SELECT * FROM handphone WHERE 
				nama LIKE '%$keyword%' OR 
				merk LIKE '%$keyword%' OR
				warna LIKE '%$keyword%' OR
				kode LIKE '%$keyword%' 	"; //query mencari dan menampilkan 
	return query($quuery);

	/* fungsi LIKE sama seperti = namun jika dengan like hasil inputan tidak harus sama persis didatabase, contoh nama didatabase xiaomi redmi, kita hanya perlu mengetik redmi dan semua data berdasarkan nama redmi akan muncul, Tapi harus menggunakan tanda % didepan atau belakang variabel atau parameters si function */
}



function registrasi($data) {
	global $conn;

	$username = strtolower(stripcslashes($data["username"])); //strtolower agar memaksa user menginput dengan huruf kecil, stripclashes untuk membersihkan menghilangkan jika user menginput / atau karakter tertentu
	$password = mysqli_real_escape_string($conn, $data["password"]);
	$password2 = mysqli_real_escape_string($conn, $data["password2"]);

	// cek username sudah ada atau belum
	// mengecek data username di tabel akun apakah sama dengan $username yang baru ditambahkan
	$result = mysqli_query($conn, "SELECT username FROM akun WHERE username = '$username' "); 
	if( mysqli_fetch_assoc($result) ){
		echo "<script>
				alert('Username Sudah Terdaftar!');
			  </script>";
	 	return false;
	 }


	// cek konfirmasi password sama atau tidak
	if ( $password !== $password2 ) { // !== artinya tidak sama dengan
		echo "<script>
				alert('konfirmasi password tidak sesuai!');
			  </script>";
		return false;
	}

	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT); // GUNAKAN password_hash JANGAN MD5 KARENA GAMPANG DI BUKA HASIL ENKRIPSINYA

	//TAMBAHKAN USER BARU KE DATABASE
	mysqli_query($conn, "INSERT INTO akun VALUES('', '$username', '$password')");

	return mysqli_affected_rows($conn); 



}














 ?>