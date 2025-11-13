<?php
session_start();

$data = "../data/grievances.json";
$list = file_exists($data) ? json_decode(file_get_contents($data), true) : [];

// Handle status change (acknowledge / resolve)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && isset($_POST['id'])) {
  $action = $_POST['action'];
  $id = $_POST['id'];

  foreach ($list as &$g) {
    if ((string)$g['id'] === (string)$id) {
      if ($action === 'ack') {
        $g['status'] = 'in_progress';
        $g['acknowledged_at'] = date('Y-m-d H:i:s');
      } elseif ($action === 'resolve') {
        $g['status'] = 'resolved';
        $g['resolved_at'] = date('Y-m-d H:i:s');
      } elseif ($action === 'reopen') {
        $g['status'] = 'open';
      }
      break;
    }
  }
  unset($g);

  // Save back
  file_put_contents($data, json_encode($list, JSON_PRETTY_PRINT));
  // Reload to show updated list
  header('Location: grievances.php');
  exit;
}
?>
<!doctype html>
<html>
<head>
  <title>Grievances – Admin</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<header class="admin-header">
  <div class="admin-header-inner">
    <a href="admin.php" class="admin-logo">
      <div class="admin-brand">
        <div class="admin-brand-name">SmartNirman</div>
        <div class="admin-brand-subtitle">Admin Panel</div>
      </div>
    </a>
    
    <nav class="admin-nav">
      <a href="admin.php" class="admin-nav-link">Dashboard</a>
      <a href="project_updates.php" class="admin-nav-link">Project Updates</a>
      <a href="grievances.php" class="admin-nav-link active">Grievances</a>
      <a href="logout.php" class="admin-nav-link logout">Logout</a>
    </nav>
  </div>
</header>

<main class="wrap">
<h2>Citizen Complaints</h2>

<div class="card table-wrap">
<table class="table">
  <thead>
    <tr>
      <th>Name</th><th>Ward</th><th>Subject</th><th>Created</th><th>Status</th><th>Photo</th><th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($list as $g): ?>
    <tr>
      <td><?=htmlspecialchars(isset($g["name"]) ? $g["name"] : '')?></td>
      <td><?=htmlspecialchars(isset($g["ward"]) ? $g["ward"] : '')?></td>
      <td><?=htmlspecialchars(isset($g["subject"]) ? $g["subject"] : (isset($g["desc"]) ? $g["desc"] : ''))?></td>
      <td><?=htmlspecialchars(isset($g["created_at"]) ? $g["created_at"] : '')?></td>
      <td><?=htmlspecialchars(isset($g["status"]) ? $g["status"] : 'open')?></td>
      <td>
        <?php if (!empty($g["photo_url"])): ?>
          <a href="<?=$g["photo_url"]?>" target="_blank">View</a>
        <?php endif; ?>
      </td>
      <td>
        <form method="post" style="display:inline">
          <input type="hidden" name="id" value="<?=htmlspecialchars($g['id'])?>">
          <?php $st = isset($g['status']) ? $g['status'] : 'open'; ?>
          <?php if ($st === 'open'): ?>
            <button class="btn btn-secondary" name="action" value="ack" type="submit">Acknowledge</button>
          <?php elseif ($st === 'in_progress'): ?>
            <button class="btn" name="action" value="resolve" type="submit">Mark Resolved</button>
          <?php else: ?>
            <button class="btn btn-secondary" name="action" value="reopen" type="submit">Re-open</button>
          <?php endif; ?>
        </form>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
</main>

</body>
</html>
