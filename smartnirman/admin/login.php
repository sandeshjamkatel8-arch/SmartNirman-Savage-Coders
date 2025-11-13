<?php
session_start();
require 'db_config.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        // Query user from database
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify password using bcrypt hash
            if (password_verify($password, $user['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                header("Location: admin.php");
                exit;
            } else {
                $error = "Username or password not correct.";
            }
        } else {
            $error = "Username or password not correct.";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login • SmartNirman</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="admin.css" rel="stylesheet">
</head>
<body>

  <div class="login-wrap">
    <div class="login-card">
      <h1>Admin Login</h1>
      <form method="post" class="stack-col">
        <label>Username
          <input class="input" type="text" name="username" required autocomplete="username">
        </label>
        <label>Password
          <input class="input" type="password" name="password" required autocomplete="current-password">
        </label>
        <button class="btn" type="submit">Sign In</button>
        <?php if ($error): ?>
          <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
      </form>

      <div class="register-footer">
        <p>Don't have an account? <a href="register.php">Register here</a></p>
      </div>
    </div>
  </div>

</body>
</html>
