<?php
header('Content-Type: text/html; charset=utf-8');

$root       = dirname(__DIR__);
$dataDir    = $root . "/data";
$uploadsDir = $root . "/uploads";
$photosDir  = $uploadsDir . "/photos";
$billsDir   = $uploadsDir . "/bills";

@mkdir($dataDir, 0777, true);
@mkdir($uploadsDir, 0777, true);
@mkdir($photosDir, 0777, true);
@mkdir($billsDir, 0777, true);

function field($key) {
  return isset($_POST[$key]) ? trim($_POST[$key]) : "";
}

$project_id       = field("project_id");
$title            = field("title");
$expense_head     = field("expense_head");
$desc             = field("desc");
$percent_complete = (int) field("percent_complete");
$amount_spent     = (int) field("amount_spent");

if ($project_id === "" || $title === "") {
  echo "Project ID and Work Stage are required. <a href=\"../admin/admin.php\">Back</a>";
  exit;
}

if ($percent_complete < 0) $percent_complete = 0;
if ($percent_complete > 100) $percent_complete = 100;
if ($amount_spent < 0) $amount_spent = 0;

// photo upload
$photo_url = "";
if (!empty($_FILES["photo"]["name"]) && is_uploaded_file($_FILES["photo"]["tmp_name"])) {
  $safeName = time() . "_" . preg_replace("/[^A-Za-z0-9_\.-]/", "_", $_FILES["photo"]["name"]);
  $dest = $photosDir . "/" . $safeName;
  if (move_uploaded_file($_FILES["photo"]["tmp_name"], $dest)) {
    $photo_url = "/smartnirman/uploads/photos/" . $safeName;
  }
}

// bill upload
$bill_filename = "";
if (!empty($_FILES["bill"]["name"]) && is_uploaded_file($_FILES["bill"]["tmp_name"])) {
  $safeBill = time() . "_" . preg_replace("/[^A-Za-z0-9_\.-]/", "_", $_FILES["bill"]["name"]);
  $destB = $billsDir . "/" . $safeBill;
  if (move_uploaded_file($_FILES["bill"]["tmp_name"], $destB)) {
    $bill_filename = $safeBill;
  }
}

// save to updates.json
$file = $dataDir . "/updates.json";
$list = [];
if (file_exists($file)) {
  $raw = file_get_contents($file);
  $arr = json_decode($raw, true);
  if (is_array($arr)) $list = $arr;
}

$new = [
  "id"               => time(),
  "project_id"       => $project_id,
  "title"            => $title,
  "expense_head"     => $expense_head,
  "desc"             => $desc,
  "percent_complete" => $percent_complete,
  "amount_spent"     => $amount_spent,
  "photo_url"        => $photo_url,
  "bill_filename"    => $bill_filename,
  "created_at"       => date("Y-m-d"),
];

$list[] = $new;
file_put_contents($file, json_encode($list, JSON_PRETTY_PRINT));

echo "Update saved. <a href=\"../admin/admin.php\">Back to Admin</a>";
