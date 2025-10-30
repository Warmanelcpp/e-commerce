<?php
require 'security.php';
require 'db.php';

if (empty($_GET['slug'])) {
    http_response_code(400);
    echo "No product specified.";
    exit;
}

$slug = trim((string)$_GET['slug']);
if (!validate_slug($slug)) {
    http_response_code(400);
    echo "Invalid slug.";
    exit;
}

$stmt = $pdo->prepare("SELECT id, name, slug, price, image, description FROM products WHERE slug = :slug LIMIT 1");
$stmt->execute(['slug' => $slug]);
$product = $stmt->fetch();

if (!$product) {
    http_response_code(404);
    echo "Product not found.<br>";
    echo "Slug you searched: <strong>" . e($slug) . "</strong><br>";
    echo "Available slugs in DB:<br>";
    $all = $pdo->query("SELECT slug FROM products ORDER BY id DESC")->fetchAll();
    foreach ($all as $row) {
        echo e($row['slug']) . "<br>";
    }
    exit;
}

$priceFormatted = number_format((float)$product['price'], 2, '.', '');
$imgSrc = safe_image_src($product['image']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= e($product['name']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <div class="catalog-header">Product Details</div>
        <div class="container">
            <div class="product" style="grid-column: span 2;">
                <img class="photos"
                     src="<?= e($imgSrc) ?>"
                     alt="<?= e($product['name']) ?>">

                <p><?= e($product['name']) ?></p>
                <p class="price">$<?= e($priceFormatted) ?></p>

                <p style="margin: 5px;">
                    <?= e($product['description'] ?? '') ?>
                </p>

                <a href="index.php"><button>Back to Catalog</button></a>
            </div>
        </div>
    </div>
</body>
</html>
