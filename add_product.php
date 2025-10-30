<?php
require 'security.php';
require 'db.php';

if (empty($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['_csrf'] ?? '';
    if (!verify_csrf($token)) {
        $errors[] = "Invalid request (CSRF).";
    } else {
        $name        = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $price       = $_POST['price'] ?? '';

        if ($name === '' || mb_strlen($name) > 120) {
            $errors[] = "Product name required.";
        }
        if (!validate_price($price) || (float)$price < 0.01) {
            $errors[] = "Price must be at least 0.01.";
        }
        if (mb_strlen($description) > 2000) {
            $errors[] = "Description too long.";
        }

        if (empty($errors)) {
            if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Image upload failed.";
            } else {
                $tmp = $_FILES['image']['tmp_name'];

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime  = finfo_file($finfo, $tmp);
                finfo_close($finfo);

                $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mime, $allowedMimes, true)) {
                    $errors[] = "Invalid image type. Allowed: JPG, PNG, GIF, WEBP.";
                } else {
                    if (!is_dir('uploads')) {
                        mkdir('uploads', 0755, true);
                    }

                    $ext = match($mime) {
                        'image/jpeg' => 'jpg',
                        'image/png'  => 'png',
                        'image/gif'  => 'gif',
                        'image/webp' => 'webp',
                        default      => 'bin'
                    };

                    $filename    = uniqid('img_', true) . '.' . $ext;
                    $destination = 'uploads/' . $filename;

                    if (!move_uploaded_file($tmp, $destination)) {
                        $errors[] = "Failed to save image file.";
                    }
                }
            }
        }

        if (empty($errors)) {
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));

            $stmt = $pdo->prepare("
                INSERT INTO products (name, description, price, image, slug)
                VALUES (:name, :description, :price, :image, :slug)
            ");
            $stmt->execute([
                'name'        => $name,
                'description' => $description,
                'price'       => number_format((float)$price, 2, '.', ''),
                'image'       => $destination,
                'slug'        => $slug
            ]);

            header("Location: view.php?slug=" . urlencode($slug));
            exit;
        }
    }
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
            <form method="POST" enctype="multipart/form-data" novalidate>
                <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">

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

            <?php if (!empty($errors)): ?>
                <div style="color:red; margin-top:10px;">
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?= e($err) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div style="margin-top:10px;">
                <a href="index.php"><button type="button">Back to Catalog</button></a>
            </div>
        </div>
    </div>
</body>
</html>
