<?php
require 'db.php';

if (!isset($_GET['slug']) || empty($_GET['slug'])) {
    echo "No product specified.";
    exit;
}

$slug = trim($_GET['slug']);

$stmt = $pdo->prepare("SELECT * FROM products WHERE slug = :slug LIMIT 1");
$stmt->execute(['slug' => $slug]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found.<br>";
    echo "Slug you searched: <strong>" . htmlspecialchars($slug) . "</strong><br>";
    echo "Available slugs in DB:<br>";

    $all = $pdo->query("SELECT slug FROM products")->fetchAll();
    foreach ($all as $row) {
        echo htmlspecialchars($row['slug']) . "<br>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <div class="catalog-header">Product Details</div>
        <div class="container">
            <div class="product" style="grid-column: span 2;">
                <img class="photos" src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <p><?= htmlspecialchars($product['name']) ?></p>
                <p class="price">$<?= htmlspecialchars($product['price']) ?></p>
                <p style="margin: 5px;"><?= htmlspecialchars($product['description']) ?></p>
                <a href="index.php"><button>Back to Catalog</button></a>
            </div>
        </div>
    </div>
</body>
</html>
