<?php
    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST['email'];
        $nama = $_POST['nama'];
        $no_hp = $_POST['no_hp'];
        $password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
    
        $sql = "INSERT INTO data_user (email, nama, no_hp, password)
                VALUES ('$email', '$nama', '$no_hp', '$password')";
    
        if ($conn->query($sql) === TRUE) {
            echo "Registrasi berhasil";
            header('location:login.html');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    
        $conn->close();

    }
?>