<?php
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
    <div class="menu">
        <div class="catalog-header">Product Catalog</div>
        <div style="text-align: center; margin: 10px;">
            <a href="add_product.php"><button>Add Product</button></a>
        </div>
        <div class="container">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img class="photos" src="<?= htmlspecialchars($product["image"]) ?>">
                    <p><?= htmlspecialchars($product["name"]) ?></p>
                    <p class="price">$<?= htmlspecialchars($product["price"]) ?></p>
                    <form method="GET" action="view.php">
                        <input type="hidden" name="slug" value="<?= htmlspecialchars($product['slug']) ?>">
                        <button type="submit">View Product</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
