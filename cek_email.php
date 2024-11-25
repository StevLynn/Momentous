<?php
include 'connection.php';

// Cek jika parameter 'email' ada
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Query untuk mencari apakah email sudah ada di database
    $query = "SELECT * FROM data_user WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika email ditemukan, kirimkan 'exists'
    if ($result->num_rows > 0) {
        echo "exists";
    } else {
        echo "available";
    }

    $stmt->close();
    $conn->close();
}
?>
