<?php
// users.php
require_once 'config.php';
require_once 'includes/auth.php';
require_role(['admin']);

$action = $_GET['action'] ?? '';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($action === 'delete' && $id) {
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: users.php?deleted=1");
    exit;
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<section class="content">
  <h2>Manage users</h2>
  <?php if (isset($_GET['deleted'])): ?><div class="alert success">User deleted.</div><?php endif; ?>
  <table class="table">
    <thead><tr><th>ID</th><th>Name</th><th>Username</th><th>Type</th><th>Status</th><th>Actions</th></tr></thead>
    <tbody>
      <?php
      foreach ($pdo->query("SELECT id, first_name, last_name, username, user_type, status FROM users ORDER BY id DESC") as $u): ?>
        <tr>
          <td><?php echo $u['id']; ?></td>
          <td><?php echo htmlspecialchars($u['first_name'] . ' ' . $u['last_name']); ?></td>
          <td><?php echo htmlspecialchars($u['username']); ?></td>
          <td><?php echo htmlspecialchars($u['user_type']); ?></td>
          <td><?php echo htmlspecialchars($u['status']); ?></td>
          <td>
            <a class="btn small" href="profile.php?id=<?php echo $u['id']; ?>">View</a>
            <a class="btn small danger" href="users.php?action=delete&id=<?php echo $u['id']; ?>" onclick="return confirm('Delete user?')">Delete</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>
<?php include 'includes/footer.php'; ?>
