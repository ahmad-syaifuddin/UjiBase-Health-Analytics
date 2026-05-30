<?php
// app/controllers/UserController.php

function indexUsers($pdo, $basePath) {
    try {
        $stmt = $pdo->query("SELECT id, nama_lengkap, username, role, created_at FROM users ORDER BY id DESC");
        $users = $stmt->fetchAll();
    } catch (PDOException $e) { $users = []; }
    require 'views/admin/users/index.php';
}

function storeUser($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama_lengkap = trim($_POST['nama_lengkap']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $role = $_POST['role'];

        try {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (nama_lengkap, username, password, role) VALUES (:nama_lengkap, :username, :password, :role)");
            $stmt->execute([
                'nama_lengkap' => $nama_lengkap,
                'username' => $username,
                'password' => $hashed_password,
                'role' => $role
            ]);
            $_SESSION['success'] = "Pengguna berhasil ditambahkan!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal menambah pengguna. Username mungkin sudah digunakan.";
        }
    }
    header("Location: " . $basePath . "/admin/users");
    exit;
}

function editUser($pdo, $basePath) {
    if (!isset($_GET['id'])) { header("Location: " . $basePath . "/admin/users"); exit; }
    $stmt = $pdo->prepare("SELECT id, nama_lengkap, username, role FROM users WHERE id = :id");
    $stmt->execute(['id' => $_GET['id']]);
    $user_edit = $stmt->fetch();
    require 'views/admin/users/edit.php';
}

function updateUser($pdo, $basePath) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nama_lengkap = trim($_POST['nama_lengkap']);
        $username = trim($_POST['username']);
        $password_baru = $_POST['password'];

        try {
            // Role TIDAK disertakan dalam perintah update demi keamanan sistem. 
            // Role hanya bisa ditetapkan saat awal pembuatan akun.
            if (!empty($password_baru)) {
                $hashed_password = password_hash($password_baru, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = :nama_lengkap, username = :username, password = :password WHERE id = :id");
                $stmt->execute(['nama_lengkap' => $nama_lengkap, 'username' => $username, 'password' => $hashed_password, 'id' => $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET nama_lengkap = :nama_lengkap, username = :username WHERE id = :id");
                $stmt->execute(['nama_lengkap' => $nama_lengkap, 'username' => $username, 'id' => $id]);
            }
            $_SESSION['success'] = "Data pengguna berhasil diperbarui!";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Gagal memperbarui pengguna.";
        }
    }
    header("Location: " . $basePath . "/admin/users");
    exit;
}

function deleteUser($pdo, $basePath) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Proteksi agar user yang sedang login tidak bisa menghapus akunnya sendiri
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "Anda tidak dapat menghapus akun Anda sendiri saat sedang login.";
        } else {
            try {
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
                $stmt->execute(['id' => $id]);
                $_SESSION['success'] = "Pengguna berhasil dihapus!";
            } catch (PDOException $e) {
                $_SESSION['error'] = "Gagal menghapus! Pengguna ini sudah terkait dengan riwayat transaksi.";
            }
        }
    }
    header("Location: " . $basePath . "/admin/users");
    exit;
}
?>