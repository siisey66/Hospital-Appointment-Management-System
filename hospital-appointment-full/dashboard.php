<?php
// dashboard.php
require_once 'config.php';
require_once 'includes/auth.php';
require_login();

include 'includes/header.php';
include 'includes/sidebar.php';

$appointments_count = $pdo->query("SELECT COUNT(*) AS c FROM appointments")->fetch()['c'];
$users_count = $pdo->query("SELECT COUNT(*) AS c FROM users")->fetch()['c'];
$my_upcoming = 0;

if ($_SESSION['user']['user_type'] === 'patient') {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM appointments WHERE patient_id = ? AND appointment_date >= NOW() AND status='scheduled'");
    $stmt->execute([$_SESSION['user']['id']]);
    $my_upcoming = $stmt->fetch()['c'];
} elseif ($_SESSION['user']['user_type'] === 'doctor') {
    $stmt = $pdo->prepare("SELECT COUNT(*) AS c FROM appointments WHERE doctor_id = ? AND appointment_date >= NOW() AND status='scheduled'");
    $stmt->execute([$_SESSION['user']['id']]);
    $my_upcoming = $stmt->fetch()['c'];
}
?>
<section class="content">
  <h2>Dashboard</h2>
  <div class="cards">
    <div class="card"><h3>Total users</h3><p><?php echo (int)$users_count; ?></p></div>
    <div class="card"><h3>Total appointments</h3><p><?php echo (int)$appointments_count; ?></p></div>
    <div class="card"><h3>My upcoming</h3><p><?php echo (int)$my_upcoming; ?></p></div>
  </div>

  <h3>Recent appointments</h3>
  <table class="table">
    <thead><tr><th>ID</th><th>Title</th><th>Date</th><th>Status</th><th>Patient</th><th>Doctor</th></tr></thead>
    <tbody>
      <?php
      $sql = "SELECT a.*, p.first_name AS pfn, p.last_name AS pln, d.first_name AS dfn, d.last_name AS dln
              FROM appointments a
              JOIN users p ON p.id = a.patient_id
              JOIN users d ON d.id = a.doctor_id
              ORDER BY a.created_at DESC LIMIT 10";
      foreach ($pdo->query($sql) as $row): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['title']); ?></td>
          <td><?php echo htmlspecialchars($row['appointment_date']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td><?php echo htmlspecialchars($row['pfn'] . ' ' . $row['pln']); ?></td>
          <td><?php echo htmlspecialchars($row['dfn'] . ' ' . $row['dln']); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php include 'includes/footer.php'; ?>
