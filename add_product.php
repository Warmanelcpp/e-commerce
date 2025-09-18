<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div style="text-align: right; margin: 10px;">
        <a href="logout.php"><button type="button">Logout</button></a>
    </div>

    <div class="menu">
        <div class="catalog-header">Add Product</div>
        <div class="view-container">
            <form action="save_product.php" method="POST" enctype="multipart/form-data">
                <label>Product Name:</label><br>
                <input type="text" name="name" required><br><br>

                <label>Description:</label><br>
                <textarea name="description" required></textarea><br><br>

                <label>Price:</label><br>
                <input type="number" name="price" min="0.01" step="0.01" required><br><br>

                <label>Image:</label><br>
                <input type="file" name="image" accept="image/*" required><br><br>

                <button type="submit">Save Product</button>
            </form>

            <div style="margin-top:10px;">
                <a href="index.php"><button type="button">Back to Catalog</button></a>
            </div>
        </div>
    </div>
</body>
</html>
