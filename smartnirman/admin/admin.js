// admin/admin_page.js
var API_BASE = "/smartnirman/api/";

function nprAdmin(x) {
  var n = typeof x === "number" ? x : parseInt(x, 10);
  if (isNaN(n)) return x;
  return n.toLocaleString("en-IN");
}

// render table of already uploaded updates
function renderUpdatesTable(list) {
  var body = document.getElementById("updates-rows");
  if (!body) return;

  if (!Array.isArray(list) || !list.length) {
    body.innerHTML = '<tr><td colspan="9">No updates yet.</td></tr>';
    return;
  }

  // newest first
  list.sort(function(a, b) {
    var ax = a.created_at || "";
    var bx = b.created_at || "";
    if (ax < bx) return 1;
    if (ax > bx) return -1;
    return 0;
  });

  var html = "";
  list.forEach(function(u) {
    var percent = u.percent_complete || 0;
    var amount  = u.amount_spent || 0;

    var photoLink = u.photo_url
      ? '<a href="' + u.photo_url + '" target="_blank">View</a>'
      : '';

    var billLink = u.bill_filename
      ? '<a href="/smartnirman/uploads/bills/' + u.bill_filename + '" target="_blank">Bill</a>'
      : '';

    html +=
      "<tr>" +
        "<td>" + (u.id || "") + "</td>" +
        "<td>" + (u.project_id || "") + "</td>" +
        "<td>" + (u.title || "") + "</td>" +
        "<td>" + (u.expense_head || "") + "</td>" +
        "<td>" + percent + "%</td>" +
        "<td>NPR " + nprAdmin(amount) + "</td>" +
        "<td>" + photoLink + "</td>" +
        "<td>" + billLink + "</td>" +
        "<td>" + (u.created_at || "") + "</td>" +
      "</tr>";
  });

  body.innerHTML = html;
}

// load existing updates
function loadUpdates() {
  var body = document.getElementById("updates-rows");
  if (body) body.innerHTML = '<tr><td colspan="9">Loading...</td></tr>';

  fetch(API_BASE + "updates_list.php", { cache: "no-store" })
    .then(function(res) {
      if (!res.ok) throw new Error("network");
      return res.json();
    })
    .then(function(data) {
      renderUpdatesTable(data || []);
    })
    .catch(function() {
      if (body) body.innerHTML = '<tr><td colspan="9">Failed to load.</td></tr>';
    });
}

// handle form submit
function attachUpdateFormHandler() {
  var form = document.getElementById("update-form");
  var msg  = document.getElementById("admin-msg");
  if (!form || !msg) return;

  form.addEventListener("submit", function(e) {
    e.preventDefault();
    msg.textContent = "Saving...";

    var fd = new FormData(form);

    fetch(API_BASE + "add_update.php", {
      method: "POST",
      body: fd
    })
      .then(function(res) {
        if (!res.ok) throw new Error("network");
        return res.json();
      })
      .then(function(data) {
        if (data && data.ok) {
          msg.textContent = "Update saved successfully.";
          form.reset();
          loadUpdates();
        } else {
          msg.textContent = (data && data.error) ? data.error : "Failed to save.";
        }
      })
      .catch(function() {
        msg.textContent = "Network error.";
      });
  });
}

(function initAdmin() {
  loadUpdates();
  attachUpdateFormHandler();
})();
