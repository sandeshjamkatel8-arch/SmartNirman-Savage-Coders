<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Report a Grievance • SmartNirman</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="./assets/css/style.css" rel="stylesheet">
</head>
<body>
  <?php include('./includes/header.php'); ?>
  <main class="wrap">
    <h1>Report a Problem</h1>
    <p class="muted">Submit your issue regarding infrastructure, public works, or local problems.</p>

    <div class="card">
      <form id="gform" class="stack-col" enctype="multipart/form-data">
        <label>Name (optional)
          <input class="input" type="text" name="name" placeholder="Your name (optional)">
        </label>

        <label>Contact (optional)
          <input class="input" type="text" name="contact" placeholder="Phone or Email (optional)">
        </label>

        <label>Ward / Area
          <input class="input" type="text" name="ward" placeholder="e.g., Hetauda-5">
        </label>

        <label>Related Project ID (optional)
          <input class="input" type="number" name="project_id" placeholder="Leave blank if not related">
        </label>

        <label>Subject *
          <input class="input" type="text" name="subject" required placeholder="Short summary of the problem">
        </label>

        <label>Details *
          <textarea class="input" name="details" rows="4" required placeholder="Describe the issue clearly"></textarea>
        </label>

        <label>Photo Evidence (optional)
          <input class="input" type="file" name="photo" accept="image/*">
        </label>

        <button class="btn" type="submit">Submit Grievance</button>
        <div id="gmsg" class="muted"></div>
      </form>
    </div>
  </main>

  <?php include('./includes/footer.php'); ?>

  <script src="./assets/js/data.js"></script>
  <script src="./assets/js/report_page.js"></script>
</body>
</html>
