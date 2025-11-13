<?php
$root = dirname(__DIR__);

// load projects
$projectsFile = $root . "/data/projects.json";
$projects = file_exists($projectsFile)
  ? json_decode(file_get_contents($projectsFile), true)
  : [];

// load grievances
$grievFile = $root . "/data/grievances.json";
$grievances = file_exists($grievFile)
  ? json_decode(file_get_contents($grievFile), true)
  : [];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SmartNirman – Admin Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
      <a href="admin.php" class="admin-nav-link active">Dashboard</a>
      <a href="project_updates.php" class="admin-nav-link">Project Updates</a>
      <a href="grievances.php" class="admin-nav-link">Grievances</a>
      <a href="logout.php" class="admin-nav-link logout">Logout</a>
    </nav>
  </div>
</header>

<main class="wrap">

  <h1>Admin Panel</h1>
  <p class="muted">
    Use this page to add new projects, record expenses and view citizen grievances.
  </p>

  <!-- ========== SECTION A: ADD NEW PROJECT ========== -->
  <div class="card">
    <h2>Add New Project</h2>
    <form method="post" action="../api/add_project.php" class="stack-col">
      <label>Project Title
        <input type="text" name="title" class="input" required>
      </label>

      <label>Location
        <input type="text" name="location" class="input" placeholder="e.g., Hetauda-04">
      </label>

      <label>Contractor Name
        <input type="text" name="contractor_name" class="input">
      </label>

      <label>Total Budget (NPR)
        <input type="number" name="budget_total" class="input">
      </label>

      <label>Status
        <select name="status" class="input">
          <option value="Ongoing">Ongoing</option>
          <option value="Completed">Completed</option>
          <option value="Not Started">Not Started</option>
        </select>
      </label>

      <label>Description
        <textarea name="desc" class="input" rows="3"></textarea>
      </label>

      <button class="btn" type="submit">Save Project</button>
    </form>
  </div>

  <!-- small list of existing projects -->
  <div class="card table-wrap">
    <h3>Existing Projects</h3>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Location</th>
          <th>Contractor</th>
          <th>Budget</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($projects): ?>
        <?php foreach ($projects as $p): ?>
          <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['title']) ?></td>
            <td><?= htmlspecialchars($p['location']) ?></td>
            <td><?= htmlspecialchars($p['contractor_name']) ?></td>
            <td><?= number_format($p['budget_total']) ?></td>
            <td><?= htmlspecialchars($p['status']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6">No projects stored yet.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

  <!-- ========== SECTION B: ADD PROJECT EXPENSE / UPDATE ========== -->
  <div class="card">
    <h2>Add Project Expense / Update</h2>
    <form method="post" action="../api/add_update.php" enctype="multipart/form-data" class="stack-col">
      <label>Project ID
        <input type="number" name="project_id" class="input" required placeholder="Use ID from above table">
      </label>

      <label>Work Stage / Item
        <input type="text" name="title" class="input" required placeholder="e.g., Base course completed">
      </label>

      <label>Expense Head
        <select name="expense_head" class="input">
          <option value="Materials">Materials</option>
          <option value="Labour">Labour</option>
          <option value="Machinery">Machinery</option>
          <option value="Supervision">Supervision</option>
          <option value="Other">Other</option>
        </select>
      </label>

      <label>Description
        <textarea name="desc" class="input" rows="3"
          placeholder="Short explanation of work and expense"></textarea>
      </label>

      <label>Percent Completed (%)
        <input type="number" name="percent_complete" class="input" min="0" max="100" value="0">
      </label>

      <label>Amount Spent (NPR)
        <input type="number" name="amount_spent" class="input" min="0" value="0">
      </label>

      <label>Site Photo (image)
        <input type="file" name="photo" class="input" accept="image/*">
      </label>

      <label>Bill / VAT Invoice (PDF)
        <input type="file" name="bill" class="input" accept=".pdf,application/pdf">
      </label>

      <button class="btn" type="submit">Save Expense / Update</button>
    </form>
  </div>

  <!-- ========== SECTION C: VIEW CITIZEN GRIEVANCES ========== -->
  <div class="card table-wrap">
    <h2>Citizen Grievances</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Ward</th>
          <th>Issue</th>
          <th>Photo</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($grievances): ?>
        <?php foreach ($grievances as $g): ?>
          <tr>
            <td><?= htmlspecialchars($g['name'] ?? '') ?></td>
            <td><?= htmlspecialchars($g['ward'] ?? '') ?></td>
            <td><?= htmlspecialchars($g['desc'] ?? '') ?></td>
            <td>
              <?php if (!empty($g['photo_url'])): ?>
                <a href="<?= htmlspecialchars($g['photo_url']) ?>" target="_blank">View</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="4">No grievances recorded yet.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>

</main>

</body>
</html>
