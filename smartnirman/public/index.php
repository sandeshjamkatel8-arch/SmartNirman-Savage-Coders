<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>SmartNirman - स्मार्ट निर्माण</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- public-side CSS -->
  <link rel="stylesheet" href="./assets/css/style.css">
  <!-- icons -->
  <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>

  <!-- Top navigation -->
  <?php include('./includes/header.php'); ?>

  <!-- Hero section -->
  <section class="hero">
    <div class="hero-inner">
      <div class="hero-text">
        <p class="hero-tag">Smart Construction Governance</p>
        <h1>Transparency. Accountability. Participation.</h1>
        <p class="hero-desc">
          SmartNirman makes public construction projects visible to citizens –
          showing budgets, bills and progress photos for roads, schools and
          other local works.
        </p>
        <div class="hero-actions">
          <a href="./projects.php" class="btn hero-btn-primary">
            View Public Projects
          </a>
          <a href="./report.php" class="btn hero-btn-secondary">
            Submit a Grievance
          </a>
        </div>
      </div>

      
    </div>
  </section>

  <!-- Main content -->
  

    <!-- Citizen services -->
    <section class="services">
      <h2>Citizen Services</h2>
      <p class="muted" style="margin-bottom: 12px;">
        Use SmartNirman to follow local development work and raise your concerns.
      </p>

      <div class="services-grid">
        <a href="./projects.php" class="service-card">
          <div class="service-icon"><i class="fa-solid fa-map-location-dot"></i></div>
          <div class="service-title">Project Transparency</div>
          <div class="service-text">
            See project location, contractor and allocated budget.
          </div>
        </a>

        

        <a href="./report.php" class="service-card">
          <div class="service-icon"><i class="fa-solid fa-comments"></i></div>
          <div class="service-title">Grievance Registration</div>
          <div class="service-text">
            Report delays, poor quality or safety issues in your ward.
          </div>
        </a>

        <a href="./grievances.php" class="service-card">
          <div class="service-icon"><i class="fa-solid fa-list-check"></i></div>
          <div class="service-title">Grievance Status</div>
          <div class="service-text">
            Check which complaints are open, in progress or resolved.
          </div>
        </a>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <?php include('./includes/footer.php'); ?>

  <script src="./assets/js/main.js"></script>
</body>
</html>
