<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="menu">
        <div class="catalog-header">Product Details</div>
        <div class="container">
            <div class="product" style="grid-column: span 2;">
                <img class="photos" src="<?php echo $_GET['image']; ?>">
                <p><?php echo $_GET['name']; ?></p>
                <p class="price">$<?php echo $_GET['price']; ?></p>
                <p style="margin: 5px;"><?php echo $_GET['description']; ?></p>
                <a href="index.php"><button>Back to Catalog</button></a>
            </div>
        </div>
    </div>
</body>
</html>
