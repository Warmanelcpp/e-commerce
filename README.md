# 🛍️ Product Catalog (E-Commerce Mini Project)

This project is a simple yet secure **PHP-based product catalog** system that allows users to **add**, **view**, and **list** products with image uploads.  
It follows secure coding practices such as **CSRF protection**, **XSS prevention**, **prepared SQL statements**, and **.env configuration** for database credentials.

---

## 🚀 Features

- **User Authentication** (Login / Logout)
- **Product Management**
  - Add new products with name, description, price, and image
  - Auto-generated unique **slug** for each product
  - URL-encoded redirection to the product page after creation
- **Image Upload**
  - Validates file MIME types (`JPG`, `PNG`, `GIF`, `WEBP`)
  - Prevents arbitrary file uploads
- **Security**
  - CSRF protection for all forms
  - XSS prevention with output escaping
  - `.env` configuration for database credentials
  - PDO prepared statements for SQL injection protection
- **Responsive UI** with clean **HTML & CSS**

---

## 🗂️ Project Structure

```plaintext
e-commerce/
│
├── index.php             # Product listing page
├── add_product.php       # Add new product form (with slug + redirect)
├── view.php              # View individual product by slug
├── db.php                # Database connection via .env
├── security.php          # CSRF + session protection helpers
├── style.css             # Basic styling
├── uploads/              # Uploaded product images
├── vendor/               # Composer dependencies (phpdotenv)
├── .env                  # Environment variables (NOT pushed to GitHub)
├── .gitignore            # Hides sensitive files (vendor/, .env, composer.lock)
└── README.md             # Project documentation

---

🚀 Features
git clone https://github.com/<yourusername>/e-commerce.git
cd e-commerce

---

⚙️ Step 2: Install Dependencies

Make sure you have Composer installed.
Then, install required PHP packages:

    composer install