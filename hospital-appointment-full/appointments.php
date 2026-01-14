<?php
// appointments.php
require_once 'config.php';
require_once 'includes/auth.php';
require_login();

$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($action === 'delete' && $id) {
    $stmt = $pdo->prepare("SELECT patient_id FROM appointments WHERE id = ?");
    $stmt->execute([$id]);
    $ap = $stmt->fetch();
    if ($ap && ($_SESSION['user']['user_type'] === 'admin' || $ap['patient_id'] == $_SESSION['user']['id'])) {
        $pdo->prepare("DELETE FROM appointments WHERE id = ?")->execute([$id]);
        header("Location: appointments.php?deleted=1");
        exit;
    } else {
        header("HTTP/1.1 403 Forbidden");
        die("Not allowed.");
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';

$where = '';
$params = [];
if ($_SESSION['user']['user_type'] === 'patient') {
    $where = "WHERE a.patient_id = ?";
    $params[] = $_SESSION['user']['id'];
} elseif ($_SESSION['user']['user_type'] === 'doctor') {
    $where = "WHERE a.doctor_id = ?";
    $params[] = $_SESSION['user']['id'];
}

$sql = "SELECT a.*, p.first_name AS pfn, p.last_name AS pln, d.first_name AS dfn, d.last_name AS dln
        FROM appointments a
        JOIN users p ON p.id = a.patient_id
        JOIN users d ON d.id = a.doctor_id
        $where
        ORDER BY a.appointment_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
?>
<section class="content">
  <h2>Appointments</h2>
  <div class="actions">
    <a class="btn" href="appointment_form.php">Create appointment</a>
  </div>
  <?php if (isset($_GET['deleted'])): ?><div class="alert success">Appointment deleted.</div><?php endif; ?>
  <table class="table">
    <thead><tr><th>ID</th><th>Title</th><th>Date</th><th>Status</th><th>Patient</th><th>Doctor</th><th>Actions</th></tr></thead>
    <tbody>
      <?php foreach ($rows as $r): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['title']); ?></td>
          <td><?php echo htmlspecialchars($r['appointment_date']); ?></td>
          <td><?php echo htmlspecialchars($r['status']); ?></td>
          <td><?php echo htmlspecialchars($r['pfn'] . ' ' . $r['pln']); ?></td>
          <td><?php echo htmlspecialchars($r['dfn'] . ' ' . $r['dln']); ?></td>
          <td>
            <a class="btn small" href="appointment_form.php?id=<?php echo $r['id']; ?>">Edit</a>
            <a class="btn small danger" href="appointments.php?action=delete&id=<?php echo $r['id']; ?>" onclick="return confirm('Delete appointment?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php include 'includes/footer.php'; ?>
