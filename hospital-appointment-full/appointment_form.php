<?php
// appointment_form.php
require_once 'config.php';
require_once 'includes/auth.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$errors = [];
$title = $description = $appointment_date = '';
$doctor_id = null;

$doctors = $pdo->query("SELECT id, first_name, last_name FROM users WHERE user_type='doctor' AND status='active' ORDER BY first_name")->fetchAll();

if ($id) {
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
    $stmt->execute([$id]);
    $ap = $stmt->fetch();
    if (!$ap) {
        die("Appointment not found.");
    }
    if ($_SESSION['user']['user_type'] === 'patient' && $ap['patient_id'] != $_SESSION['user']['id']) {
        header("HTTP/1.1 403 Forbidden");
        die("Not allowed.");
    }
    $title = $ap['title'];
    $description = $ap['description'];
    $appointment_date = date('Y-m-d\TH:i', strtotime($ap['appointment_date']));
    $doctor_id = $ap['doctor_id'];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $appointment_date = $_POST['appointment_date'] ?? '';
    $doctor_id = (int)($_POST['doctor_id'] ?? 0);

    if ($title === '' || $appointment_date === '' || !$doctor_id) {
        $errors[] = "Title, date, and doctor are required.";
    }
    if (strtotime($appointment_date) < time()) {
        $errors[] = "Appointment date must be in the future.";
    }

    if (!$errors) {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE appointments SET title=?, description=?, appointment_date=?, doctor_id=? WHERE id=?");
            $stmt->execute([$title, $description, $appointment_date, $doctor_id, $id]);
            header("Location: appointments.php?updated=1");
            exit;
        } else {
            $stmt = $pdo->prepare("INSERT INTO appointments (patient_id, doctor_id, title, description, appointment_date) VALUES (?,?,?,?,?)");
            $stmt->execute([$_SESSION['user']['id'], $doctor_id, $title, $description, $appointment_date]);
            header("Location: appointments.php?created=1");
            exit;
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<section class="content">
  <h2><?php echo $id ? 'Edit appointment' : 'Create appointment'; ?></h2>
  <?php if ($errors): ?>
    <div class="alert error"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
  <?php endif; ?>
  <form class="form" method="post" novalidate>
    <label>Title<input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required></label>
    <label>Description<textarea name="description"><?php echo htmlspecialchars($description); ?></textarea></label>
    <div class="grid-2">
      <label>Doctor
        <select name="doctor_id" required>
          <option value="">Select doctor</option>
          <?php foreach ($doctors as $d): ?>
            <option value="<?php echo $d['id']; ?>" <?php echo ($doctor_id == $d['id']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($d['first_name'] . ' ' . $d['last_name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </label>
      <label>Date & time
        <input type="datetime-local" name="appointment_date" value="<?php echo htmlspecialchars($appointment_date); ?>" required>
      </label>
    </div>
    <div class="actions">
      <a class="btn secondary" href="appointments.php">Cancel</a>
      <button type="submit" class="btn"><?php echo $id ? 'Update' : 'Create'; ?></button>
    </div>
  </form>
</section>
<?php include 'includes/footer.php'; ?>
