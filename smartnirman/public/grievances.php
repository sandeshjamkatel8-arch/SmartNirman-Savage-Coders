<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Grievances • SmartNirman</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./assets/css/style.css" rel="stylesheet">
</head>
<body>
  <?php include('./includes/header.php'); ?>

  <main class="wrap">
    <h1>Grievances</h1>
    <p class="muted">Public reports submitted by citizens. <a href="./report.php">Report a new grievance</a>.</p>

    <div class="card">
      <div class="stack">
        <input id="gq" class="input" type="text" placeholder="Search subject / ward / project id">
        <button id="gclear" class="btn">Clear</button>
      </div>
    </div>

    <div id="glist"></div>
  </main>

  <?php include('./includes/footer.php'); ?>

  <script src="./assets/js/grievances_page.js"></script>
</body>
</html>
