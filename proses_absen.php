<?php
// Sertakan file koneksi.php untuk menghubungkan ke database
include 'koneksi.php';
include 'notif_absensi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST['rfid'];
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s"); // Dapatkan waktu sekarang

    // Ambil pengaturan waktu masuk dan pulang dari tabel setting
    $query_setting = $conn->prepare("SELECT waktu_masuk, waktu_pulang FROM setting LIMIT 1");
    $query_setting->execute();
    $result_setting = $query_setting->get_result();

    if ($result_setting->num_rows > 0) {
        // Ambil waktu masuk dan pulang dari pengaturan
        $setting = $result_setting->fetch_assoc();
        $waktu_masuk = $setting['waktu_masuk'];
        $waktu_pulang = $setting['waktu_pulang'];

        // Cek apakah siswa dengan RFID tersebut ada menggunakan prepared statement
        $query_siswa = $conn->prepare("SELECT id, nama, telepon FROM siswa WHERE rfid = ?");
        $query_siswa->bind_param("s", $rfid); // 's' indicates string
        $query_siswa->execute();
        $result_siswa = $query_siswa->get_result();

        if ($result_siswa->num_rows > 0) {
            $siswa = $result_siswa->fetch_assoc();
            $id_siswa = $siswa['id'];
            $nama_siswa = $siswa['nama'] ?? 'Tidak ada nama'; // Menghindari undefined array key
            $tlpn_siswa = $siswa['telepon'] ?? 'Tidak ada telepon'; // Menghindari undefined array key

            // Cek apakah sudah absen masuk hari ini
            $query_absen = $conn->prepare("SELECT * FROM absensi WHERE id_siswa = ? AND tanggal = ?");
            $query_absen->bind_param("is", $id_siswa, $tanggal); // 'i' indicates integer, 's' for string
            $query_absen->execute();
            $result_absen = $query_absen->get_result();

            if ($result_absen->num_rows == 0) {
                // Menentukan status masuk berdasarkan waktu
                $status_masuk = ($waktu > $waktu_masuk) ? 'Terlambat' : 'Hadir';

                // Insert absen masuk dengan status sesuai
                $insert_query = $conn->prepare("INSERT INTO absensi (id_siswa, tanggal, waktu_masuk, status_masuk) VALUES (?, ?, ?, ?)");
                $insert_query->bind_param("isss", $id_siswa, $tanggal, $waktu, $status_masuk);
                if ($insert_query->execute()) {
                    // Kirim notifikasi absen masuk
                    $pesan = "$nama_siswa telah melakukan absen masuk pada $tanggal pukul $waktu. Status: $status_masuk.";
                    kirimNotifikasi($tlpn_siswa, $pesan);

                    // Redirect ke list_absen.php setelah sukses
                    header("Location: list_absensi.php");
                    exit; // Pastikan script berhenti setelah redirect
                } else {
                    echo "Error: " . $conn->error;
                }
            } else {
                // Jika sudah absen masuk, cek absensi pulang
                $update_query = null;

                // Jika waktu sudah lebih besar atau sama dengan waktu pulang
                if ($waktu >= $waktu_pulang) {
                    // Menentukan status pulang
                    $status_pulang = ($waktu > $waktu_pulang) ? 'Pulang' : 'Pulang';

                    // Update status pulang
                    $update_query = $conn->prepare("UPDATE absensi SET waktu_pulang = ?, status_pulang = ? WHERE id_siswa = ? AND tanggal = ?");
                    $update_query->bind_param("ssis", $waktu, $status_pulang, $id_siswa, $tanggal);
                    if ($update_query->execute()) {
                        // Kirim notifikasi absen pulang
                        $pesan = "$nama_siswa telah melakukan absen pulang pada $tanggal pukul $waktu. Status: $status_pulang.";
                        kirimNotifikasi($tlpn_siswa, $pesan);

                        // Redirect ke list_absensi.php setelah sukses
                        header("Location: list_absensi.php");
                        exit; // Pastikan script berhenti setelah redirect
                    } else {
                        echo "Error update: " . $conn->error;
                    }
                } else {
                    // Jika waktu belum sesuai dengan jam pulang yang diatur
                    echo "Absensi pulang gagal: Waktu belum sesuai dengan jam pulang yang diatur.";
                }
            }
        } else {
            echo "RFID tidak ditemukan.";
        }
    } else {
        echo "Pengaturan waktu masuk dan pulang tidak ditemukan.";
    }
}
?>
