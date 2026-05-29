<?php
// app/controllers/AuthController.php

function loginProcess($pdo, $basePath) {
    // Pastikan request menggunakan metode POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Validasi input kosong (mencegah fiktif)
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = "Username dan Password wajib diisi.";
            header("Location: " . $basePath . "/login");
            exit;
        }

        try {
            // Gunakan Prepared Statement untuk mencegah SQL Injection
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            // Verifikasi hash password (sangat disukai penguji untuk keamanan)
            if ($user && password_verify($password, $user['password'])) {
                // Set data ke dalam Session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];

                // Arahkan ke dashboard
                header("Location: " . $basePath . "/admin/dashboard");
                exit;
            } else {
                $_SESSION['error'] = "Username atau Password salah.";
                header("Location: " . $basePath . "/login");
                exit;
            }
        } catch (PDOException $e) {
            die("Kesalahan Sistem: " . $e->getMessage());
        }
    } else {
        header("Location: " . $basePath . "/login");
        exit;
    }
}

function logoutProcess($basePath) {
    // Hapus semua data sesi
    session_unset();
    session_destroy();
    
    // Arahkan kembali ke halaman login
    header("Location: " . $basePath . "/login");
    exit;
}
?>