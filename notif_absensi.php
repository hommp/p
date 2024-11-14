<?php
function kirimNotifikasi($no_hp, $pesan)
{
    $token = "#8-1@NkP!Q6tn!7aaPmy"; // Ganti dengan token Fonnte kamu
    $url = "https://api.fonnte.com/send";

    $data = [
        'target' => $no_hp, // Nomor HP tujuan (gunakan format internasional, misal: 628xxxxxxxxxx)
        'message' => $pesan, // Pesan yang akan dikirim
        'countryCode' => 'ID', // Kode negara (untuk Indonesia: ID)
    ];

    $header = [
        "Authorization: " . $token
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}
