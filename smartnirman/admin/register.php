<?php
session_start();
require 'db_config.php';

// Simple admin registration
$error = "";
$success = "";
$username = "";
$email = "";
$password = "";
$confirm_password = "";

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Validation
    if (empty($username)) {
        $error = "Username is required.";
    } elseif (strlen($username) < 3) {
        $error = "Username must be at least 3 characters.";
    } elseif (empty($password)) {
        $error = "Password is required.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (empty($email)) {
        $error = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            $success = "Account created — sign in to continue.";
            $username = "";
            $email = "";
            $password = "";
            $confirm_password = "";
        } else {
            if (strpos($stmt->error, 'Duplicate entry') !== false) {
                if (strpos($stmt->error, 'username') !== false) {
                    $error = "That username is taken.";
                } else {
                    $error = "That email is already registered.";
                }
            } else {
                $error = "Something went wrong. Try again.";
            }
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Registration • SmartNirman</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="admin.css" rel="stylesheet">
</head>
<body>

  <div class="login-wrap">
    <div class="login-card">
      <h1>Create Admin Account</h1>
      <p class="register-subtitle">Sign up for admin access</p>
      
      <form method="post" class="stack-col">
        <label>Username
          <input class="input" type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required autocomplete="username">
          <small>3+ characters</small>
        </label>

        <label>Email
          <input class="input" type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required autocomplete="email">
        </label>

        <label>Password
          <input class="input" type="password" name="password" required autocomplete="new-password">
          <small>6+ characters</small>
        </label>

        <label>Confirm Password
          <input class="input" type="password" name="confirm_password" required autocomplete="new-password">
        </label>

        <button class="btn" type="submit">Create Account</button>

        <?php if ($error): ?>
          <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
          <div class="success"><?php echo htmlspecialchars($success); ?></div>
          <a href="login.php" class="btn btn-secondary" style="display: block; text-align: center;">Back to Sign In</a>
        <?php endif; ?>
      </form>

      <div class="register-footer">
        <p>Already registered? <a href="login.php">Sign in</a></p>
      </div>
    </div>
  </div>

</body>
</html>
