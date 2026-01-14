<?php
// register.php
require_once 'config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last  = trim($_POST['last_name'] ?? '');
    $sex   = $_POST['sex'] ?? '';
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $user_type = $_POST['user_type'] ?? 'patient';
    $status = $_POST['status'] ?? 'active';

    if ($first === '' || $last === '' || $username === '' || $password === '' || $email === '') {
        $errors[] = "Required fields are missing.";
    }
    if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email.";
    }
    if (!in_array($sex, ['Male','Female','Other'], true)) {
        $errors[] = "Invalid sex.";
    }
    if (!in_array($user_type, ['admin','doctor','patient'], true)) {
        $errors[] = "Invalid user type.";
    }
    if (!in_array($status, ['active','not_active'], true)) {
        $errors[] = "Invalid status.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    // Handle profile picture safely
    $profile_path = null;
    if (!empty($_FILES['profile_picture']['name'])) {
        $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['profile_picture']['tmp_name']);
        finfo_close($finfo);

        if (!isset($allowed[$mime])) {
            $errors[] = "Profile picture must be JPG or PNG.";
        } elseif ($_FILES['profile_picture']['size'] > 2 * 1024 * 1024) {
            $errors[] = "Profile picture must be under 2MB.";
        } else {
            $ext = $allowed[$mime];
            if (!is_dir('uploads/profiles')) {
                mkdir('uploads/profiles', 0775, true);
            }
            $profile_path = 'uploads/profiles/' . uniqid('pf_', true) . '.' . $ext;
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $profile_path);
        }
    }

    if (!$errors) {
        $stmt = $pdo->prepare("INSERT INTO users (first_name,last_name,sex,username,password_hash,phone,email,profile_picture,user_type,status)
                               VALUES (?,?,?,?,?,?,?,?,?,?)");
        try {
            $stmt->execute([
                $first, $last, $sex, $username,
                password_hash($password, PASSWORD_BCRYPT),
                $phone, $email, $profile_path, $user_type, $status
            ]);
            header("Location: login.php?registered=1");
            exit;
        } catch (PDOException $e) {
            $errors[] = "Username or email already exists.";
        }
    }
}

include 'includes/header.php';
include 'includes/sidebar.php';
?>
<section class="content">
  <h2>User registration</h2>
  <?php if ($errors): ?>
    <div class="alert error"><?php echo implode('<br>', array_map('htmlspecialchars', $errors)); ?></div>
  <?php endif; ?>
  <form class="form" method="post" enctype="multipart/form-data" novalidate>
    <div class="grid-2">
      <label>First name<input type="text" name="first_name" required></label>
      <label>Last name<input type="text" name="last_name" required></label>
    </div>
    <div class="grid-2">
      <label>Sex
        <select name="sex" required>
          <option>Male</option><option>Female</option><option>Other</option>
        </select>
      </label>
      <label>Username<input type="text" name="username" required></label>
    </div>
    <div class="grid-2">
      <label>Password<input type="password" name="password" required></label>
      <label>Phone<input type="text" name="phone"></label>
    </div>
    <div class="grid-2">
      <label>Email<input type="email" name="email" required></label>
      <label>Profile picture<input type="file" name="profile_picture" accept=".jpg,.jpeg,.png"></label>
    </div>
    <div class="grid-2">
      <label>User type
        <select name="user_type">
          <option value="patient">Patient</option>
          <option value="doctor">Doctor</option>
          <option value="admin">Admin</option>
        </select>
      </label>
      <label>Status
        <select name="status">
          <option value="active">Active</option>
          <option value="not_active">Not active</option>
        </select>
      </label>
    </div>
    <div class="actions">
      <button type="reset" class="btn secondary">Reset</button>
      <button type="submit" class="btn">Submit</button>
    </div>
  </form>
</section>
<?php include 'includes/footer.php'; ?>
