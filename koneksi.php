<?php
//time
date_default_timezone_set(timezoneId:'asia/jakarta');
$host = "localhost"; // atau alamat server database Anda
$username = "root"; // ganti dengan username database Anda
$password = ""; // ganti dengan password database Anda
$database = "register_wa"; // menggunakan nama database yang baru dibuat

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
} else {
  //  echo "Koneksi berhasil";
}
?>
