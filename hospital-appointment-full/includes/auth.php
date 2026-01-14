<?php // includes/auth.php
function require_login(): void {
    if (empty($_SESSION['user'])) {
        header("Location: login.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function require_role(array $roles): void {
    require_login();
    if (!in_array($_SESSION['user']['user_type'], $roles, true)) {
        header("HTTP/1.1 403 Forbidden");
        die("Access denied.");
    }
}
