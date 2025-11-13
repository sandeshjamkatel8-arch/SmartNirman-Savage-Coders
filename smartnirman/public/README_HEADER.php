<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>How to Use Header Component - SmartNirman</title>
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
</head>
<body>

  <!-- USAGE: Include the header component -->
  <?php include('./includes/header.php'); ?>

  <main class="wrap">
    <h1>Header & Logo Implementation Guide</h1>
    
    <div class="card">
      <h2>✓ What's New</h2>
      <ul style="margin-left: 20px; line-height: 1.8;">
        <li><strong>New Header Component:</strong> <code>public/includes/header.php</code></li>
        <li><strong>Logo File:</strong> <code>public/assets/img/logo.svg</code> (40x40px SVG)</li>
        <li><strong>Enhanced CSS:</strong> Updated styling for better header design</li>
      </ul>
    </div>

    <div class="card">
      <h2>📝 How to Use</h2>
      <p>To add the header to any PHP file, include this line at the top of your &lt;body&gt;:</p>
      <pre style="background: #f3f4f6; padding: 12px; border-radius: 4px; overflow-x: auto;">
&lt;?php include('./includes/header.php'); ?&gt;</pre>
    </div>

    <div class="card">
      <h2>🎨 Logo Design</h2>
      <p>The logo features:</p>
      <ul style="margin-left: 20px; line-height: 1.8;">
        <li>Gradient background (Red to Blue) representing Nepal's flag colors</li>
        <li>Three buildings of varying heights representing construction projects</li>
        <li>Colored windows (Red and Blue) in each building</li>
        <li>A road at the base representing infrastructure</li>
        <li>SVG format - scalable and lightweight</li>
      </ul>
    </div>

    <div class="card">
      <h2>📂 File Structure</h2>
      <pre style="background: #f3f4f6; padding: 12px; border-radius: 4px; overflow-x: auto; font-size: 13px;">
public/
  ├── includes/
  │   ├── header.php      ← New header component
  │   └── footer.php      ← New footer component
  ├── assets/
  │   ├── css/
  │   │   └── style.css   ← Updated with logo styling
  │   └── img/
  │       └── logo.svg    ← New logo file
  └── *.html files        ← Update these to use header.php
      </pre>
    </div>

    <div class="card">
      <h2>🔄 Migration Steps</h2>
      <ol style="margin-left: 20px; line-height: 1.8;">
        <li>Replace the &lt;header&gt; section in each HTML file with the PHP include</li>
        <li>Convert HTML files to PHP (rename .html to .php)</li>
        <li>Update all href links if file extensions change</li>
        <li>Test in your browser to ensure everything displays correctly</li>
      </ol>
    </div>
  </main>

  <!-- USAGE: Include the footer component -->
  <?php include('./includes/footer.php'); ?>

</body>
</html>
