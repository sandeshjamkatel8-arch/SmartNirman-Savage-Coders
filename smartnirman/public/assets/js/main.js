function npr(x){ return typeof x==="number" ? x.toLocaleString("en-IN") : x; }

function projectCard(p) {
  var div = document.createElement("div");
  div.className = "card";
  var percent = 0;
  if (p.budget_total > 0) {
    percent = Math.round((p.budget_spent / p.budget_total) * 100);
    if (percent < 0) percent = 0;
    if (percent > 100) percent = 100;
  }
  div.innerHTML =
    '<div style="font-weight:700; margin-bottom:4px;">' + p.title + '</div>' +
    '<div class="muted" style="font-size:14px; margin-bottom:6px;">' +
      'Location: ' + p.location + ' • Contractor: ' + p.contractor_name +
    '</div>' +
    '<div style="font-size:14px; margin-bottom:6px;">' +
      'Budget: NPR ' + npr(p.budget_total) + ' | Spent: NPR ' + npr(p.budget_spent) +
      ' (' + percent + '%)' +
    '</div>' +
    '<div class="progress"><div class="progress-bar" style="width:'+percent+'%"></div></div>' +
    '<a class="btn" href="./project.html?id=' + p.id + '">Open</a>';
  return div;
}

(function initHome(){
  var listEl = document.getElementById("project-list");
  if (!listEl) return;
  var projects = (window.DEMO_PROJECTS || []).slice().sort(function(a,b){
    var ax=a.updated_at||"", bx=b.updated_at||""; return ax<bx?1:ax>bx?-1:0;
  });
  listEl.innerHTML = "";
  projects.forEach(function(p){ listEl.appendChild(projectCard(p)); });
})();
