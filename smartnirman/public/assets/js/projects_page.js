// public/assets/js/projects_page.js

function npr(x) {
  var n = typeof x === "number" ? x : parseInt(x, 10);
  if (isNaN(n)) return x;
  return n.toLocaleString("en-IN");
}

var listEl = document.getElementById("project-list");
if (listEl) {
  listEl.textContent = "Loading projects...";
}

// fetch projects.json
fetch("../data/projects.json", { cache: "no-store" })
  .then(function(res) {
    if (!res.ok) throw new Error("failed");
    return res.json();
  })
  .then(function(data) {
    if (!listEl) return;
    if (!Array.isArray(data) || !data.length) {
      listEl.textContent = "No projects available yet.";
      return;
    }

    // newest first
    data.sort(function(a, b) {
      return (b.id || 0) - (a.id || 0);
    });

    var html = "";
    data.forEach(function(p) {
      html +=
        '<div class="card">' +
          '<div class="stack-col">' +
            '<div style="font-weight:600;font-size:16px;">' +
              (p.title || "") +
            '</div>' +
            '<div class="meta">' +
              '<strong>Location:</strong> ' + (p.location || "N/A") +
              ' • <strong>Contractor:</strong> ' + (p.contractor_name || "N/A") +
            '</div>' +
            '<div class="meta">' +
              '<strong>Budget:</strong> NPR ' + npr(p.budget_total || 0) +
              ' • <strong>Status:</strong> ' + (p.status || "N/A") +
            '</div>' +
            (p.desc
              ? '<div class="muted" style="font-size:14px;">' +
                  p.desc +
                '</div>'
              : ''
            ) +
            '<div>' +
              '<a class="btn" href="./project.html?id=' + (p.id || "") + '">View Details</a>' +
            '</div>' +
          '</div>' +
        '</div>';
    });

    listEl.innerHTML = html;
  })
  .catch(function() {
    if (listEl) listEl.textContent = "Failed to load projects.";
  });
