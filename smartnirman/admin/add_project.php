<!doctype html>
<html>
<head>
  <title>Add Project – Admin</title>
  <link rel="stylesheet" href="admin.css">
</head>
<body>

<header class="top">
  <div class="brand">Add New Project</div>
  <nav class="nav">
    <a href="index.php">Dashboard</a>
  </nav>
</header>

<main class="wrap">

<div class="card">
  <form id="project-form" class="stack-col">
    <label>Project Title
      <input type="text" name="title" class="input" required>
    </label>

    <label>Location
      <input type="text" name="location" class="input">
    </label>

    <label>Contractor Name
      <input type="text" name="contractor_name" class="input">
    </label>

    <label>Budget Total (NPR)
      <input type="number" name="budget_total" class="input">
    </label>

    <label>Status
      <select name="status" class="input">
        <option>Ongoing</option>
        <option>Completed</option>
        <option>Not Started</option>
      </select>
    </label>

    <label>Description
      <textarea class="input" name="desc"></textarea>
    </label>

    <button class="btn" type="submit">Save Project</button>
    <div id="msg" class="muted"></div>
  </form>
</div>

</main>

<script src="project_form.js"></script>
</body>
</html>
