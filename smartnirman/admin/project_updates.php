<?php
// Show runtime errors during debugging (can be disabled later)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once __DIR__ . '/db_config.php';

// Require admin login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
		header('Location: login.php');
		exit;
}

// Ensure updates table exists
$create_updates = "CREATE TABLE IF NOT EXISTS updates (
		id INT AUTO_INCREMENT PRIMARY KEY,
		title VARCHAR(255) NOT NULL,
		body TEXT NOT NULL,
		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
if (!$conn->query($create_updates)) {
		die('Error creating updates table: ' . $conn->error);
}

$error = '';
$success = '';

// Handle new update submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$title = isset($_POST['title']) ? trim($_POST['title']) : '';
		$body = isset($_POST['body']) ? trim($_POST['body']) : '';

		if ($title === '' || $body === '') {
				$error = 'Title and body are required.';
		} else {
				$stmt = $conn->prepare("INSERT INTO updates (title, body) VALUES (?, ?)");
				$stmt->bind_param('ss', $title, $body);
				if ($stmt->execute()) {
						$success = 'Update posted successfully.';
				} else {
						$error = 'Failed to post update: ' . $stmt->error;
				}
				$stmt->close();
		}
}

// Fetch updates
$updates = [];
$res = $conn->query("SELECT id, title, body, created_at FROM updates ORDER BY created_at DESC");
if ($res) {
		while ($row = $res->fetch_assoc()) {
				$updates[] = $row;
		}
		$res->close();
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Project Updates • Admin</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="admin.css" rel="stylesheet">
	<style>
		.updates-wrap{max-width:1000px;margin:28px auto;padding:0 16px}
		.updates-card{background:#fff;padding:18px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,.04)}
		.updates-list{margin-top:18px}
		.update-item{border-left:4px solid #b91c1c;padding:12px 14px;margin-bottom:12px;background:#fff}
		.small-muted{color:#6b7280;font-size:13px}
		.form-row{margin-bottom:12px}
	</style>
</head>
<body>

	<div class="updates-wrap">
		<div class="updates-card">
			<h1>Project Updates</h1>
			<p class="small-muted">Post and view project updates.</p>

			<form method="post" class="stack-col" style="margin-top:16px">
				<label class="form-row">Title
					<input class="input" type="text" name="title" required>
				</label>

				<label class="form-row">Update
					<textarea class="input" name="body" rows="5" required></textarea>
				</label>

				<button class="btn" type="submit">Post Update</button>

				<?php if ($error): ?>
					<div class="error"><?php echo htmlspecialchars($error); ?></div>
				<?php endif; ?>

				<?php if ($success): ?>
					<div class="success"><?php echo htmlspecialchars($success); ?></div>
				<?php endif; ?>
			</form>

			<div class="updates-list">
				<?php if (count($updates) === 0): ?>
					<p class="small-muted">No updates yet.</p>
				<?php else: ?>
					<?php foreach ($updates as $u): ?>
						<div class="update-item">
							<strong><?php echo htmlspecialchars($u['title']); ?></strong>
							<div class="small-muted"><?php echo htmlspecialchars($u['created_at']); ?></div>
							<p style="margin-top:8px"><?php echo nl2br(htmlspecialchars($u['body'])); ?></p>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<p style="margin-top:18px"><a href="admin.php">Back to Dashboard</a> | <a href="logout.php">Logout</a></p>
		</div>
	</div>

</body>
</html>
