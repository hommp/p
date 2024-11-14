<?php
include 'koneksi.php'; // Mengambil koneksi ke database
include 'notif_wa.php'; // Jika notifikasi WhatsApp diperlukan

// Hapus data jika tombol delete ditekan
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $sql_delete = "DELETE FROM siswa WHERE id = ?";
    
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        header("Location: list.php"); // Redirect ke list.php setelah menghapus data
        exit();
    } else {
        echo "Error deleting record: " . $stmt->error;
    }
    $stmt->close();
}

// Proses pendaftaran
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil dan membersihkan input
    $nisn = htmlspecialchars($_POST['nisn']);
    $nama = htmlspecialchars($_POST['nama']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $absen = htmlspecialchars($_POST['absen']);
    $email = htmlspecialchars($_POST['email']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $tanggal_daftar = date('Y-m-d');
    $rfid = htmlspecialchars($_POST['rfid']);

    // Menyimpan data termasuk tanggal daftar menggunakan prepared statements
    $sql = "INSERT INTO siswa (nisn, nama, absen, kelas, email, telepon, alamat, tanggal_daftar, rfid) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssss", $nisn, $nama, $absen, $kelas, $email, $telepon, $alamat, $tanggal_daftar, $rfid);

    if ($stmt->execute()) {
        // Redirect setelah berhasil menyimpan data
        header("Location: list.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close(); // Menutup koneksi
?>
