<?php
// Sertakan file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';

// Menentukan tanggal yang ingin ditampilkan (dapat diubah atau ditambahkan form untuk memilih tanggal)
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date("Y-m-d"); // Default ke tanggal hari ini

// Query untuk mengambil data absensi berdasarkan tanggal
$query = $conn->prepare("SELECT absensi.id, siswa.nama, absensi.tanggal, absensi.waktu_masuk, absensi.status_masuk, absensi.waktu_pulang, absensi.status_pulang
                        FROM absensi
                        JOIN siswa ON absensi.id_siswa = siswa.id
                        WHERE absensi.tanggal = ?");
$query->bind_param("s", $tanggal);
$query->execute();
$result = $query->get_result();

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Absensi - <?php echo $tanggal; ?></title>
    <!-- Link ke Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h2 class="text-2xl font-bold mb-4">Daftar Absensi Siswa pada Tanggal: <?php echo $tanggal; ?></h2>

        <form method="GET" action="" class="mb-4">
            <label for="tanggal" class="mr-2">Pilih Tanggal: </label>
            <input type="date" id="tanggal" name="tanggal" value="<?php echo $tanggal; ?>" required class="border rounded p-2">
            <button type="submit" class="bg-blue-500 text-white rounded px-4 py-2 ml-2">Tampilkan Absensi</button>
        </form>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">No.</th>
                    <th class="border px-4 py-2">Nama Siswa</th>
                    <th class="border px-4 py-2">Tanggal</th>
                    <th class="border px-4 py-2">Waktu Masuk</th>
                    <th class="border px-4 py-2">Status Masuk</th>
                    <th class="border px-4 py-2">Waktu Pulang</th>
                    <th class="border px-4 py-2">Status Pulang</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='border px-4 py-2'>" . $no++ . "</td>";
                        echo "<td class='border px-4 py-2'>" . ($row['nama']) . "</td>";
                        echo "<td class='border px-4 py-2'>" . $row['tanggal'] . "</td>";
                        echo "<td class='border px-4 py-2'>" . ($row['waktu_masuk'] ? $row['waktu_masuk'] : '-') . "</td>";
                        echo "<td class='border px-4 py-2'>" . ($row['status_masuk']) . "</td>";
                        echo "<td class='border px-4 py-2'>" . ($row['waktu_pulang'] ? $row['waktu_pulang'] : '-') . "</td>";
                        echo "<td class='border px-4 py-2'>" . ($row['status_pulang']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='border px-4 py-2 text-center italic'>Tidak ada data absensi untuk tanggal ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>

<?php
// Menutup koneksi
$conn->close();
?>