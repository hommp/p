<?php
include 'koneksi.php';

// Ambil data waktu masuk dan pulang saat ini
$query = "SELECT * FROM setting WHERE id = 1";
$result = mysqli_query($conn, $query);
$current_setting = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $waktu_masuk = $_POST['waktu_masuk'];
    $waktu_pulang = $_POST['waktu_pulang'];

    // Pastikan waktu masuk dan waktu pulang dalam format HH:MM
    // Menggunakan strtotime untuk memastikan format yang benar (HH:MM)
    $waktu_masuk = date("H:i", strtotime($waktu_masuk));
    $waktu_pulang = date("H:i", strtotime($waktu_pulang));

    // Cek apakah pengaturan waktu sudah ada
    if ($current_setting) {
        // Update pengaturan waktu jika sudah ada
        $update_query = $conn->prepare("UPDATE setting SET waktu_masuk = ?, waktu_pulang = ? WHERE id = 1");
        $update_query->bind_param("ss", $waktu_masuk, $waktu_pulang); // Menggunakan parameter binding untuk keamanan
        if ($update_query->execute()) {
            echo "Pengaturan waktu berhasil disimpan!";
        } else {
            echo "Error: " . $update_query->error;
        }
    } else {
        // Insert jika belum ada pengaturan
        $insert_query = $conn->prepare("INSERT INTO setting (waktu_masuk, waktu_pulang) VALUES (?, ?)");
        $insert_query->bind_param("ss", $waktu_masuk, $waktu_pulang); // Menggunakan parameter binding untuk keamanan
        if ($insert_query->execute()) {
            echo "Pengaturan waktu berhasil disimpan!";
        } else {
            echo "Error: " . $insert_query->error;
        }
    }

    // Cek apakah waktu masuk terlambat atau tidak
    $waktu_batas = $current_setting['waktu_masuk']; // Waktu batas yang diambil dari database

    // Misalkan waktu sekarang adalah waktu masuk siswa
    if ($waktu_masuk > $waktu_batas) {
        echo "Terlambat";
    } elseif ($waktu_masuk == $waktu_batas) {
        echo "Tepat waktu";
    } else {
        echo "Masuk lebih awal";
    }
}
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Pengaturan Waktu Masuk dan Pulang</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <h2 class="text-2xl font-bold mb-4">Pengaturan Waktu Masuk dan Pulang</h2>

    <?php
    if (isset($_SESSION['message'])) {
        echo "<p class='text-red-500'>{$_SESSION['message']}</p>";
        unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
    }
    ?>

    <form method="POST" class="bg-white p-6 rounded shadow-md">
        <div class="mb-4">
            <label class="block text-gray-700">Waktu Masuk:</label>
            <input type="time" name="waktu_masuk" value="<?php echo htmlspecialchars($current_setting['waktu_masuk'] ?? ''); ?>" required class="border border-gray-300 rounded p-2 w-full">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Waktu Pulang:</label>
            <input type="time" name="waktu_pulang" value="<?php echo htmlspecialchars($current_setting['waktu_pulang'] ?? ''); ?>" required class="border border-gray-300 rounded p-2 w-full">
        </div>

        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Simpan</button>
    </form>
</body>

</html>