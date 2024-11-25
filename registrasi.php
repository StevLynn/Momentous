<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil dan membersihkan data input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $nama = htmlspecialchars($_POST['nama']); // Untuk menghindari XSS
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    // Validasi email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Format email tidak valid.";
        header('Location: registrasi.html');
        exit;
    }

    // Validasi kecocokan password
    if ($password1 !== $password2) {
        $_SESSION['error'] = "Password tidak cocok.";
        header('Location: registrasi.html');
        exit;
    }

    // Cek apakah email sudah terdaftar
    $checkEmailQuery = $conn->prepare("SELECT * FROM data_user WHERE email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $result = $checkEmailQuery->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Email sudah terdaftar. Silakan gunakan email lain.";
        header('Location: registrasi.html');
        exit;
    }

    // Mengenkripsi password
    $password = password_hash($password1, PASSWORD_DEFAULT);

    // Menyimpan data ke database
    $sql = $conn->prepare("INSERT INTO data_user (email, nama, no_hp, password) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $email, $nama, $no_hp, $password);

    if ($sql->execute()) {
        $_SESSION['success'] = "Registrasi berhasil. Silakan login.";
        header('Location: login.html');
        exit;
    } else {
        $_SESSION['error'] = "Terjadi kesalahan saat registrasi. Silakan coba lagi.";
        header('Location: registrasi.html');
        exit;
    }

    $conn->close();
}
?>
