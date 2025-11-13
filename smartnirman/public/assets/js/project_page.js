// public/assets/js/project_page.js

// Use absolute URLs so path is always correct under Apache
var PROJECTS_URL = "/smartnirman/data/projects.json";
var UPDATES_URL  = "/smartnirman/data/updates.json";

function qparam(name) {
  return new URLSearchParams(location.search).get(name);
}

function npr(x) {
  var n = typeof x === "number" ? x : parseInt(x, 10);
  if (isNaN(n)) return x;
  return n.toLocaleString("en-IN");
}

var titleEl   = document.getElementById("p-title");
var metaEl    = document.getElementById("p-meta");
var updatesEl = document.getElementById("p-updates");

if (titleEl) titleEl.textContent = "Loading project...";

var projectId = qparam("id");

// render meta info box
function renderMeta(project, updatesForThis) {
  if (!metaEl) return;

  var spent = 0;
  var maxPercent = 0;
  updatesForThis.forEach(function(u) {
    var amt = parseInt(u.amount_spent, 10);
    if (!isNaN(amt)) spent += amt;
    var p = parseInt(u.percent_complete, 10);
    if (!isNaN(p) && p > maxPercent) maxPercent = p;
  });

  var total = parseInt(project.budget_total, 10) || 0;
  if (total > 0 && spent > total) spent = total;

  var percentDisplay = total > 0
    ? Math.round((spent / total) * 100)
    : maxPercent;

  if (percentDisplay < 0) percentDisplay = 0;
  if (percentDisplay > 100) percentDisplay = 100;

  metaEl.innerHTML =
    '<div class="stack-col">' +
      '<div class="meta">' +
        '<strong>Location:</strong> ' + (project.location || "N/A") +
        ' • <strong>Status:</strong> ' + (project.status || "N/A") +
        ' • <strong>Contractor:</strong> ' + (project.contractor_name || "N/A") +
      '</div>' +
      '<div class="meta">' +
        '<strong>Budget:</strong> NPR ' + npr(total) +
        ' • <strong>Spent (recorded):</strong> NPR ' + npr(spent) +
        ' (' + percentDisplay + '%)' +
      '</div>' +
      '<div class="progress">' +
        '<div class="progress-bar" style="width:' + percentDisplay + '%"></div>' +
      '</div>' +
    '</div>';
}

// render list of updates
function renderUpdates(updates) {
  if (!updatesEl) return;

  if (!Array.isArray(updates) || !updates.length) {
    updatesEl.textContent = "No expenses or updates recorded yet.";
    return;
  }

  // newest first
  updates.sort(function(a, b) {
    var ax = a.created_at || "";
    var bx = b.created_at || "";
    if (ax < bx) return 1;
    if (ax > bx) return -1;
    return 0;
  });

  var html = "";
  updates.forEach(function(u) {
    var percent = parseInt(u.percent_complete, 10) || 0;
    var amount  = parseInt(u.amount_spent, 10) || 0;

    var imgHtml = "";
    if (u.photo_url) {
      imgHtml =
        '<div class="stack" style="margin-top:6px;">' +
          '<img src="' + u.photo_url + '" alt="Site photo" ' +
          ' style="max-width:260px;border:1px solid #e5e7eb;border-radius:4px;">' +
        '</div>';
    }

    var billHtml = "";
    if (u.bill_filename) {
      billHtml =
        '<div style="margin-top:6px;">' +
          '<a class="btn" href="/smartnirman/uploads/bills/' + u.bill_filename + '" target="_blank">' +
            'View Bill / VAT Invoice' +
          '</a>' +
        '</div>';
    }

    html +=
      '<div class="card">' +
        '<div style="font-weight:600;margin-bottom:2px;">' + (u.title || "") + '</div>' +
        '<div class="muted" style="font-size:14px;margin-bottom:4px;">' +
          (u.expense_head ? (u.expense_head + " • ") : "") +
          percent + '% • NPR ' + npr(amount) +
        '</div>' +
        (u.desc
          ? '<div style="font-size:14px;margin-bottom:4px;">' + u.desc + '</div>'
          : ''
        ) +
        imgHtml +
        billHtml +
        '<div class="muted" style="font-size:12px;margin-top:4px;">' +
          (u.created_at || "") +
        '</div>' +
      '</div>';
  });

  updatesEl.innerHTML = html;
}

// load everything
if (!projectId) {
  if (titleEl) titleEl.textContent = "Project not found.";
  if (metaEl) metaEl.textContent = "";
  if (updatesEl) updatesEl.textContent = "";
} else {
  Promise.all([
    fetch(PROJECTS_URL, { cache: "no-store" }).then(function(r){ return r.json(); }),
    fetch(UPDATES_URL,  { cache: "no-store" }).then(function(r){ return r.json(); })
  ]).then(function(results) {
    var projects = Array.isArray(results[0]) ? results[0] : [];
    var updates  = Array.isArray(results[1]) ? results[1] : [];

    var idNum = parseInt(projectId, 10);
    var project = projects.find(function(p) {
      return parseInt(p.id, 10) === idNum;
    });

    if (!project) {
      if (titleEl) titleEl.textContent = "Project not found.";
      if (metaEl) metaEl.textContent = "";
      if (updatesEl) updatesEl.textContent = "";
      return;
    }

    if (titleEl) titleEl.textContent = project.title || "Project";

    var updatesForThis = updates.filter(function(u) {
      return String(u.project_id) === String(project.id);
    });

    renderMeta(project, updatesForThis);
    renderUpdates(updatesForThis);
  }).catch(function(err) {
    console.log("Project load error:", err);
    if (titleEl) titleEl.textContent = "Failed to load project.";
    if (metaEl) metaEl.textContent = "";
    if (updatesEl) updatesEl.textContent = "";
  });
}
