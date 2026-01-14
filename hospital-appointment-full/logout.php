<?php
// logout.php
require_once 'config.php';
session_unset();
session_destroy();
setcookie('remember_me', '', time() - 3600, '/', '', isset($_SERVER['HTTPS']), true);
header("Location: login.php");
exit;
