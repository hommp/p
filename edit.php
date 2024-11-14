<?php
// Mengambil koneksi ke database
include 'koneksi.php'; // Pastikan koneksi.php sudah ada

// Mengambil ID dari URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Mengkonversi ID ke integer
    
    // Mengambil data siswa berdasarkan ID
    $sql_select = "SELECT * FROM siswa WHERE id = ?";
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
} else {
    // Jika ID tidak valid, redirect atau tampilkan pesan error
    echo "ID tidak valid.";
    exit();
}

// Jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn = htmlspecialchars($_POST['nisn']);
    $nama = htmlspecialchars($_POST['nama']);
    $absen = htmlspecialchars($_POST['absen']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $email = htmlspecialchars($_POST['email']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $tanggal_daftar = $_POST['tanggal_daftar'];
    $rfid = htmlspecialchars($_POST['rfid']);

    // Update data siswa
    $sql_update = "UPDATE siswa SET nisn=?, nama=?, absen=?, kelas=?, email=?, alamat=?, telepon=?, tanggal_daftar=?, rfid=? WHERE id=?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("sssssssssi", $nisn, $nama, $absen, $kelas, $email, $alamat, $telepon, $tanggal_daftar, $rfid, $id);
    
    if ($stmt->execute()) {
        header("Location: list.php"); // Kembali ke halaman utama setelah update
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close(); // Menutup koneksi
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftaran</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Pendaftaran</h2>
        <form method="post">
            <div class="form-group">
                <label>NISN</label>
                <input type="text" name="nisn" class="form-control" value="<?php echo htmlspecialchars($row['nisn']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="<?php echo htmlspecialchars($row['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nomor Absen</label>
                <input type="text" name="absen" class="form-control" value="<?php echo htmlspecialchars($row['absen']); ?>" required>
            </div>
            <div class="form-group">
                <label>Kelas</label>
                <input type="text" name="kelas" class="form-control" value="<?php echo htmlspecialchars($row['kelas']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <input type="text" name="alamat" class="form-control" value="<?php echo htmlspecialchars($row['alamat']); ?>" required>
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="telepon" class="form-control" value="<?php echo htmlspecialchars($row['telepon']); ?>" required>
            </div>
            <div class="form-group">
                <label>Tanggal Daftar</label>
                <input type="date" name="tanggal_daftar" class="form-control" value="<?php echo htmlspecialchars($row['tanggal_daftar']); ?>" required>
            </div>
            <div class="form-group">
                <label>No RFID</label>
                <input type="text" name="rfid" class="form-control" value="<?php echo htmlspecialchars($row['rfid']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="list.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
