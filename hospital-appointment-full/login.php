<?php
// login.php
require_once 'config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = !empty($_POST['remember']);

    if ($username === '' || $password === '') {
        $errors[] = "Username and password are required.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? AND status = 'active'");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'user_type' => $user['user_type'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
            ];
            $_SESSION['LAST_ACTIVITY'] = time();

            if ($remember) {
                setcookie('remember_me', $user['username'], time() + (86400 * 7), '/', '', isset($_SERVER['HTTPS']), true);
            }

            $redirect = $_GET['redirect'] ?? 'dashboard.php';
            header("Location: " . $redirect);
            exit;
        } else {
            $errors[] = "Invalid credentials or inactive account.";
        }
    }
}

$remembered = $_COOKIE['remember_me'] ?? '';

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<section class="content">
  <h2>Login</h2>
  <?php if (isset($_GET['expired'])): ?>
    <div class="alert warning">Your session expired. Please log in again.</div>
  <?php endif; ?>
  <?php if (isset($_GET['registered'])): ?>
    <div class="alert success">Registration successful. Please log in.</div>
  <?php endif; ?>
  <?php if ($errors): ?>
    <div class="alert error"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
  <?php endif; ?>
  <form class="form" method="post" novalidate>
    <label>Username<input type="text" name="username" value="<?php echo htmlspecialchars($remembered); ?>" required></label>
    <label>Password<input type="password" name="password" required></label>
    <div class="form-row">
      <label><input type="checkbox" name="remember"> Remember me</label>
      <a class="link" href="#" onclick="alert('Ask admin to reset your password.')">Forgot password?</a>
    </div>
    <div class="actions">
      <button type="submit" class="btn">Login</button>
      <a class="btn secondary" href="register.php">Sign up</a>
    </div>
  </form>
</section>
<?php include 'includes/footer.php'; ?>
