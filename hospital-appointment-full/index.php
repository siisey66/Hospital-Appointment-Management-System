<?php
// index.php
require_once 'config.php';
include 'includes/header.php';
include 'includes/sidebar.php';
?>
<section class="content">
  <h2>Welcome</h2>
  <p>Patients can book appointments, doctors manage schedules, and admins oversee users.</p>
  <div class="cards">
    <div class="card">
      <h3>Book an appointment</h3>
      <p>Choose a doctor and time that works for you.</p>
      <a class="btn" href="appointment_form.php">Get started</a>
    </div>
    <div class="card">
      <h3>Manage your account</h3>
      <p>Update your profile and view your bookings.</p>
      <a class="btn" href="profile.php">Profile</a>
    </div>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
