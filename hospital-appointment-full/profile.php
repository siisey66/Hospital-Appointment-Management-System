<?php
// profile.php
require_once 'config.php';
require_once 'includes/auth.php';
require_login();

$view_id = isset($_GET['id']) ? (int)$_GET['id'] : $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$view_id]);
$user = $stmt->fetch();
if (!$user) die("User not found.");

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<section class="content">
  <h2>Profile</h2>
  <div class="profile">
    <img class="avatar" src="<?php echo $user['profile_picture'] ? htmlspecialchars($user['profile_picture']) : 'assets/logo.png'; ?>" alt="Profile">
    <ul class="list">
      <li><strong>Name:</strong> <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></li>
      <li><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></li>
      <li><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></li>
      <li><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></li>
      <li><strong>Sex:</strong> <?php echo htmlspecialchars($user['sex']); ?></li>
      <li><strong>Type:</strong> <?php echo htmlspecialchars($user['user_type']); ?></li>
      <li><strong>Status:</strong> <?php echo htmlspecialchars($user['status']); ?></li>
    </ul>
  </div>
</section>
<?php include 'includes/footer.php'; ?>
