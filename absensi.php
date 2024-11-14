<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-100 to-blue-300 flex items-center justify-center min-h-screen">
    <div class="bg-white p-10 rounded-2xl shadow-2xl w-96 transition-transform transform hover:scale-105">
        <h1 class="font-bold text-4xl mb-6 text-center text-blue-600">Form Absensi</h1>
        <form action="proses_absen.php" method="POST">
            <label for="rfid" class="block text-lg font-medium mb-2 text-gray-700">Scan Kartu:</label>
            <input type="text" id="rfid" name="rfid" placeholder="Masukan kode RFID" required autofocus class="border border-gray-300 p-3 w-full rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent mb-4 transition duration-200 ease-in-out transform hover:scale-105">
            <input type="submit" value="Submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-600 transition duration-200 transform hover:scale-105">
        </form>
    </div>
    <script src="components/app.js"></script>
</body>

</html>