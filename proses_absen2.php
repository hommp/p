<?php
include 'koneksi.php';
include 'notif_absensi.php';

// Cek apakah data setting ada di database
$sql = "SELECT waktu_masuk, waktu_pulang FROM setting WHERE id = 1";
$result = $conn->query($sql);
if (!$result) {
    die("Error mengambil data setting: " . $conn->error);
}

$setting = $result->fetch_assoc();
$waktu_masuk_setting = $setting['waktu_masuk'];
$waktu_pulang_setting = $setting['waktu_pulang'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST['rfid'];
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s"); // Dapatkan waktu sekarang

    // Debugging untuk melihat apakah waktu ditangkap dengan benar
    echo "Waktu yang diambil: $waktu";

    // Cek apakah siswa dengan RFID tersebut ada menggunakan prepared statement
    $query_siswa = $conn->prepare("SELECT id, nama, tlpn FROM register_tabel WHERE rfid = ?");
    $query_siswa->bind_param("s", $rfid); // 's' indicates string
    $query_siswa->execute();
    $result_siswa = $query_siswa->get_result();

    if ($result_siswa->num_rows > 0) {
        $siswa = $result_siswa->fetch_assoc();
        $id_siswa = $siswa['id'];
        $nama_siswa = $siswa['nama'] ?? 'Tidak ada nama'; // Menghindari undefined array key
        $tlpn_siswa = $siswa['tlpn'] ?? 'Tidak ada telepon'; // Menghindari undefined array key

        // Cek apakah sudah absen masuk hari ini
        $query_absen = $conn->prepare("SELECT * FROM absensi WHERE id_siswa = ? AND tanggal = ?");
        $query_absen->bind_param("is", $id_siswa, $tanggal); // 'i' indicates integer, 's' for string
        $query_absen->execute();
        $result_absen = $query_absen->get_result();

        // Cek jika waktu absensi berada dalam rentang jam masuk dan pulang yang diatur
        if ($waktu < $waktu_masuk_setting || $waktu > $waktu_pulang_setting) {
            // Jika waktu absensi di luar jam yang diizinkan
            echo "Absensi gagal: Waktu tidak sesuai dengan jam yang diatur.";
        } else {
            if ($result_absen->num_rows == 0) {
                // Jika belum ada absen masuk, catat absensi masuk dengan waktu yang sesuai setting
                $insert_query = $conn->prepare("INSERT INTO absensi (id_siswa, tanggal, waktu_masuk, status_masuk) 
                                                VALUES (?, ?, ?, 'Hadir')");
                $insert_query->bind_param("iss", $id_siswa, $tanggal, $waktu_masuk_setting); // Gunakan waktu_masuk_setting
                if ($insert_query->execute()) {
                    echo "Absensi masuk berhasil tercatat pada $waktu_masuk_setting.";

                    // Kirim notifikasi absen masuk
                    $pesan = "Halo, $nama_siswa telah melakukan absen masuk pada $tanggal pukul $waktu_masuk_setting.";
                    kirimNotifikasi($tlpn_siswa, $pesan);
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                // Jika sudah ada absen masuk, perbarui waktu pulang dengan waktu yang sesuai setting
                $update_query = $conn->prepare("UPDATE absensi SET waktu_pulang = ?, status_pulang = 'Pulang' WHERE id_siswa = ? AND tanggal = ?");
                $update_query->bind_param("sis", $waktu_pulang_setting, $id_siswa, $tanggal); // Gunakan waktu_pulang_setting
                if ($update_query->execute()) {
                    echo "Absensi pulang berhasil tercatat pada $waktu_pulang_setting.";

                    // Kirim notifikasi absen pulang
                    $pesan = "Halo, $nama_siswa telah melakukan absen pulang pada $tanggal pukul $waktu_pulang_setting.";
                    kirimNotifikasi($tlpn_siswa, $pesan);
                } else {
                    echo "Error update: " . $conn->error;
                }
            }
        }
    } else {
        echo "RFID tidak ditemukan.";
    }
}
?>
