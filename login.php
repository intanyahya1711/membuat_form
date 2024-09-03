<?php
    session_start();

    // Koneksi ke database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "contoh_login";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    
    // Ambil data dari form
    $user = $_POST['username'];
    $pass = $_POST['password'];
    
    // Cari user di database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $user;
            echo "Login berhasil! Selamat datang, " . $user;
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username tidak ditemukan!";
    }
    
    $stmt->close();
    $conn->close();
?>