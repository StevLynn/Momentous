<?php
    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO data_user (username, email, nama, no_hp, tempat_lahir, tanggal_lahir, password)
                VALUES ('$username', '$email', '$nama', '$no_hp', '$tempat_lahir', '$tanggal_lahir', '$password')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Registrasi berhasil";
            header('location:login.html');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();
    }
?>