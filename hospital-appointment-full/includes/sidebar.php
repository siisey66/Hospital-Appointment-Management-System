<?php // includes/sidebar.php ?>
<aside class="sidebar" aria-label="Sidebar">
  <h3>Quick links</h3>
  <ul>
    <li><a href="appointments.php">View appointments</a></li>
    <li><a href="appointment_form.php">Book appointment</a></li>
    <li><a href="register.php"> Register here</a></li>
    <li><a href="login.php"> Login here</a></li>
    <?php if (!empty($_SESSION['user']) && $_SESSION['user']['user_type'] !== 'patient'): ?>
      <li><a href="users.php">Manage users</a></li>
    <?php endif; ?>
  </ul>
  <div class="info">
    <p><strong>Session:</strong> <?php echo !empty($_SESSION['user']) ? 'Active' : 'Guest'; ?></p>
    <?php if (!empty($_SESSION['user'])): ?>
      <p><strong>User:</strong> <?php echo htmlspecialchars($_SESSION['user']['first_name'] . ' ' . $_SESSION['user']['last_name']); ?></p>
    <?php endif; ?>
  </div>
</aside>
