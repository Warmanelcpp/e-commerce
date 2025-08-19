<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $file_name = $_FILES['image']['name'];
        $tmp_path = $_FILES['image']['tmp_name'];

        $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($ext !== 'png' && $ext !== 'jpg' && $ext !== 'jpeg') {
            die("Error: Only PNG, JPG, or JPEG files are allowed.");
        }

        if (!is_dir('images')) {
            mkdir('images', 0755, true);
        }

        $new_file_name = uniqid('img_') . '.' . $ext;
        $upload_path = 'images/' . $new_file_name;

        if (!move_uploaded_file($tmp_path, $upload_path)) {
            die("Failed to upload image.");
        }

        $stmt = $pdo->prepare("
            INSERT INTO products (name, description, price, image) 
            VALUES (:name, :description, :price, :image)
        ");

        $stmt->execute([
            'name' => $_POST['name'],
            'description' => $_POST['description'],
            'price' => $_POST['price'],
            'image' => $upload_path,
        ]);

        $product = [
            "name" => $_POST['name'],
            "description" => $_POST['description'],
            "price" => $_POST['price'],
            "image" => $upload_path
        ];

    } else {
        die("Error: No file uploaded or upload error.");
    }
} else {
    die("Invalid request.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Saved</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <div class="catalog-header">Product Saved</div>
        <div class="container" style="grid-template-columns: 1fr;">
            <div class="product">
                <img class="photos" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <p><strong><?= htmlspecialchars($product['name']) ?></strong></p>
                <p class="price">$<?= htmlspecialchars($product['price']) ?></p>
                <p style="margin: 5px;"><?= htmlspecialchars($product['description']) ?></p>
                <a href="index.php"><button>Back to Catalog</button></a>
            </div>
        </div>
    </div>
</body>
</html>
