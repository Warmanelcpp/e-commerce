<?php
require 'security.php';
require 'db.php';

$stmt = $pdo->query("SELECT id, name, slug, price, image FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Catalog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div style="text-align: right; margin: 10px;">
        <?php if (isset($_SESSION['user'])): ?>
            <a href="logout.php"><button type="button">Logout</button></a>
        <?php else: ?>
            <a href="login.php"><button type="button">Login</button></a>
        <?php endif; ?>
    </div>

    <div class="menu">
        <div class="catalog-header">Product Catalog</div>

        <div style="text-align: center; margin: 10px;">
            <?php if (isset($_SESSION['user'])): ?>
                <a href="add_product.php"><button>Add Product</button></a>
            <?php endif; ?>
        </div>

        <div class="container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product">
                        <img class="photos"
                             src="<?= e(safe_image_src($product['image'])) ?>"
                             alt="<?= e($product['name']) ?>">

                        <p><?= e($product['name']) ?></p>
                        <p class="price">$<?= e(number_format((float)$product['price'], 2, '.', '')) ?></p>

                        <a href="view.php?slug=<?= urlencode($product['slug']) ?>">
                            <button type="button">View Product</button>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
