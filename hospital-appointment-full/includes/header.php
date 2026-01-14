<?php // includes/header.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Hospital Appointment System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="site-header">
  <div class="brand">
    <img src="C:\xampp\htdocs\hospital-appointment-full\logo\logo.png
" alt="Hospital logo" />
    <div>
      <h1>Hospital Appointment System</h1>
      <p class="subtitle">Book, manage, and track appointments</p>
    </div>
  </div>
  <nav class="top-nav" aria-label="Main navigation">
    <a href="index.php">Home</a>
    <a href="appointments.php">Appointments</a>
    <?php if (!empty($_SESSION['user'])): ?>
      <a href="dashboard.php">Dashboard</a>
      <a href="profile.php">Profile</a>
      <a class="logout" href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a>
         <a href="dashboard.php">Dashboard</a>
      <a href="register.php">Register</a>
      <a class="signup" href="register.php">Sign Up</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
