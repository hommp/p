<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = htmlspecialchars($_POST['nama']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $absen = htmlspecialchars($_POST['absen']);
    $email = htmlspecialchars($_POST['email']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $tanggal_daftar = htmlspecialchars($_POST['tanggal_daftar']);
    $rfid = htmlspecialchars($_POST['rfid']);

    // Inisialisasi cURL
    $curl = curl_init();

    // Pengaturan cURL
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $telepon,
            'message' => "Nama Anda: " . $nama . ",\nKelas: " . $kelas . ",\nAbsen: " . $absen . ",\nEmail: " . $email . ",\nTelepon: " . $telepon . ",\nAlamat: " . $alamat . ",\nTanggal Daftar: " . $tanggal_daftar . ",\nNo rfid: " . $rfid,
            'countryCode' => '62', // optional
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization:#8-1@NkP!Q6tn!7aaPmy' // Ganti dengan token Anda yang sebenarnya
        ),
    ));

    // Eksekusi cURL
    $response = curl_exec($curl);

    // Tutup cURL
    curl_close($curl);

    // Tampilkan respons
    echo $response;
} else {
    header("location: register.html");
    exit();
}
