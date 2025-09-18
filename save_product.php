<?php
session_start();
require 'db.php';

// Login yoxlamasi
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);

    // Sekil upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $tmp = $_FILES['image']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($ext, $allowed)) {
            die("Invalid image type.");
        }

        // uploads folderi yoxlanilir yoxdursa yaradilir
        if (!is_dir('uploads')) mkdir('uploads', 0777, true);

        $filename = uniqid() . "." . $ext;
        $destination = "uploads/" . $filename;

        if (!move_uploaded_file($tmp, $destination)) {
            die("Failed to move uploaded file.");
        }
    } else {
        die("Image upload error.");
    }

    // Slug yaradilir
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

    // Mehsulu DB-e elave et
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image, slug) VALUES (:name, :description, :price, :image, :slug)");
    $stmt->execute([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'image' => $destination,
        'slug' => $slug
    ]);

    // Mehsul detallarina yonlendirme
    header("Location: view.php?slug=$slug");
    exit;
}
