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
