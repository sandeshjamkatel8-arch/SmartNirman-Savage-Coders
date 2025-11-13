<?php
header('Content-Type: text/html; charset=utf-8');

$root = dirname(__DIR__);
$dataDir = $root . "/data";
$file = $dataDir . "/projects.json";

@mkdir($dataDir, 0777, true);

function field($key) {
  return isset($_POST[$key]) ? trim($_POST[$key]) : "";
}

$title = field("title");
if ($title === "") {
  echo "Title is required. <a href=\"../admin/admin.php\">Back</a>";
  exit;
}

$project = [
  "id"              => time(),
  "title"           => $title,
  "location"        => field("location"),
  "contractor_name" => field("contractor_name"),
  "budget_total"    => (int) field("budget_total"),
  "status"          => field("status"),
  "desc"            => field("desc"),
];

$list = [];
if (file_exists($file)) {
  $raw = file_get_contents($file);
  $arr = json_decode($raw, true);
  if (is_array($arr)) $list = $arr;
}

$list[] = $project;
file_put_contents($file, json_encode($list, JSON_PRETTY_PRINT));

echo "Project saved. <a href=\"../admin/admin.php\">Back to Admin</a>";
