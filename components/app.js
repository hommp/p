   // Menangani pengiriman form
   document.getElementById('absensiForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Mencegah pengiriman form secara default

    const nfcId = document.getElementById('').value;

    // Validasi input
    if (nfcId.trim() === '') {
        alert('Silakan masukkan NFC atau Barcode Anda.');
    } else {
        // Menampilkan pesan konfirmasi
        document.getElementById('confirmationMessage').innerText = 'Terima kasih, absensi Anda telah dicatat!';
        document.getElementById('confirmationMessage').style.display = 'block';

        // Reset form setelah 3 detik
        setTimeout(() => {
            document.getElementById('absensiForm').reset();
            document.getElementById('confirmationMessage').style.display = 'none';
        }, 3000);
    }
});