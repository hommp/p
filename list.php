<?php
// Menghubungkan ke file koneksi.php
include 'koneksi.php';

// Mengambil data pendaftaran dari database
$sql_select = "SELECT * FROM siswa";
$result = $conn->query($sql_select);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10">
        <h2 class="text-2xl font-bold text-center mb-5">Data Pendaftaran</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="py-3 px-4 uppercase font-semibold text-sm">NISN</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Nama</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Nomor Absen</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Kelas</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Email</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Alamat</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Nomor Telepon</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Tanggal Daftar</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">No RFID</th>
                        <th class="py-3 px-4 uppercase font-semibold text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='hover:bg-gray-100'>
                                    <td class='py-3 px-4 border-b'>{$row['nisn']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['nama']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['absen']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['kelas']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['email']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['alamat']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['telepon']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['tanggal_daftar']}</td>
                                    <td class='py-3 px-4 border-b'>{$row['rfid']}</td>
                                    <td class='py-3 px-4 border-b'>
                                        <a href='edit.php?id={$row['id']}' class='bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600'>Edit</a>
                                        <a href='delete.php?id={$row['id']}' class='bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='10' class='text-center py-3'>Tidak ada data pendaftaran.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-5 text-center">
            <a href="index.html" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">Back to Register</a>
        </div>
    </div>
</body>

</html>

<?php
$conn->close(); // Menutup koneksi
?>