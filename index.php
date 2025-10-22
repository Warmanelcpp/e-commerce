<?php
session_start();

require 'db.php';

$products = $pdo->query("SELECT * FROM products")->fetchAll();
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
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img class="photos" src="<?= htmlspecialchars($product["image"]) ?>" alt="<?= htmlspecialchars($product["name"]) ?>">
                    <p><?= htmlspecialchars($product["name"]) ?></p>
                    <p class="price">$<?= htmlspecialchars($product["price"]) ?></p>
                    <a href="view.php?slug=<?= urlencode($product['slug']) ?>">
                        <button type="button">View Product</button>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
