<?php
declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Content-Security-Policy: default-src 'self'; img-src 'self' https: http: data:; script-src 'self'; style-src 'self' 'unsafe-inline'; object-src 'none'; base-uri 'self'; frame-ancestors 'none'");
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('Referrer-Policy: same-origin');

function e(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function safe_image_src(?string $s): string {
    $placeholder = '/images/placeholder.png';
    if (!$s) return $placeholder;

    $s = str_replace('\\', '/', trim($s));

    if (preg_match('#^https?://#i', $s)) {
        return $s;
    }

    if (strpos($s, '//') === 0) return $placeholder;

    if (str_contains($s, '..') || str_contains($s, ':')) {
        return $placeholder;
    }

    return '/' . ltrim($s, '/');
}

function validate_slug(string $slug): bool {
    return (bool) preg_match('/^[a-z0-9-]{1,80}$/', $slug);
}

function validate_price($p): bool {
    if (!is_numeric($p)) return false;
    return floatval($p) >= 0;
}

function csrf_token(): string {
    if (empty($_SESSION['_csrf'])) {
        $_SESSION['_csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf'];
}

function verify_csrf(string $token): bool {
    return isset($_SESSION['_csrf']) && hash_equals($_SESSION['_csrf'], $token);
}
