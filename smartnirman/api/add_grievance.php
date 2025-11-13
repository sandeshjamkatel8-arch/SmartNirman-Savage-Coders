<?php
header('Content-Type: text/html; charset=utf-8');

$root       = dirname(__DIR__);
$dataDir    = $root . "/data";
$uploadsDir = $root . "/uploads";
$photosDir  = $uploadsDir . "/photos";

@mkdir($dataDir, 0777, true);
@mkdir($uploadsDir, 0777, true);
@mkdir($photosDir, 0777, true);

function field($key) {
  return isset($_POST[$key]) ? trim($_POST[$key]) : "";
}

$name = field('name');
$contact = field('contact');
$ward = field('ward');
$project_id = field('project_id');
$subject = field('subject');
$details = field('details');

if ($ward === '' || $subject === '' || $details === '') {
  http_response_code(400);
  echo json_encode(["success" => false, "message" => "Ward, issue title, and details are required."]);
  exit;
}

$photo_url = "";
if (!empty($_FILES['photo']['name']) && is_uploaded_file($_FILES['photo']['tmp_name'])) {
  $safeName = time() . "_" . preg_replace("/[^A-Za-z0-9_\.-]/", "_", $_FILES['photo']['name']);
  $dest = $photosDir . "/" . $safeName;
  if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) {
    // URL used by public pages (adjust if you serve from a different base)
    $photo_url = "/SMARTNIRMAN/uploads/photos/" . $safeName;
  }
}

$file = $dataDir . "/grievances.json";
$list = [];
if (file_exists($file)) {
  $raw = file_get_contents($file);
  $arr = json_decode($raw, true);
  if (is_array($arr)) $list = $arr;
}

$new = [
  "id" => time(),
  "name" => $name,
  "contact" => $contact,
  "ward" => $ward,
  "project_id" => $project_id === '' ? null : $project_id,
  "subject" => $subject,
  "details" => $details,
  "photo_url" => $photo_url,
  "status" => "open",
  "created_at" => date("Y-m-d H:i:s")
];

array_unshift($list, $new);
file_put_contents($file, json_encode($list, JSON_PRETTY_PRINT));

echo json_encode(["success" => true, "message" => "Report received.", "item" => $new]);
