<?php
// Mengambil koneksi ke database
include 'koneksi.php'; // Pastikan koneksi.php sudah ada

// Mengambil ID dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengkonversi ID ke integer

    // Validasi ID agar benar-benar ada di database
    $sql_check = "SELECT * FROM siswa WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Menghapus data dari database
        $sql_delete = "DELETE FROM siswa WHERE id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $id);
        
        if ($stmt_delete->execute()) {
            // Menampilkan pesan sukses
            echo "<p>Data berhasil dihapus.</p>";
        } else {
            echo "<p>Error: " . $stmt_delete->error . "</p>";
        }

        $stmt_delete->close();
    } else {
        echo "<p>ID tidak ditemukan di database.</p>";
    }

    $stmt_check->close();
} else {
    echo "<p>ID tidak valid.</p>";
}

// Redirect kembali ke halaman utama setelah beberapa detik
header("refresh:2;url=list.php"); // Ganti dengan URL halaman data pendaftaran Anda
echo "<p>Anda akan diarahkan kembali ke halaman daftar...</p>";

$conn->close(); // Menutup koneksi
?>
