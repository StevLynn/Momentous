<?php
    session_start();
    include 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql_user = "SELECT username, password FROM data_user WHERE username = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("s", $username);
        $stmt_user->execute();
        $stmt_user->store_result();
        $stmt_user->bind_result($db_username_user, $hashed_password_user);
        
        $sql_admin = "SELECT username, password FROM admin WHERE username = ?";
        $stmt_admin = $conn->prepare($sql_admin);
        $stmt_admin->bind_param("s", $username);
        $stmt_admin->execute();
        $stmt_admin->store_result();
        $stmt_admin->bind_result($db_username_admin, $password_admin);

        if ($stmt_user->fetch() && password_verify($password, $hashed_password_user)) {
            $_SESSION['username'] = $db_username_user;
            header("Location: Home.php");
            exit();
        } elseif ($stmt_admin->fetch() && $password == $password_admin) {
            $_SESSION['username'] = $db_username_admin;
            header("Location: Dashboard_admin.php");
            exit();
        } else {
            echo "Username atau password salah.";
        }

        $stmt_user->close();
        $stmt_admin->close();
        $conn->close();
    }
?>