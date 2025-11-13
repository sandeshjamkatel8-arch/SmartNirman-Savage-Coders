var all = [];
var box = document.getElementById("glist");
var q = document.getElementById("gq");
var clear = document.getElementById("gclear");

function cardHTML(c){
  var badgeColor = c.status === "resolved" ? "#15803d"
                 : c.status === "in_progress" ? "#b45309" : "#dc2626";
  var badgeBg = c.status === "resolved" ? "#e7f7eb"
               : c.status === "in_progress" ? "#fff7e6" : "#fee2e2";
  return (
    '<div class="card">' +
      '<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;">' +
        '<div style="font-weight:700;">' + (c.subject||"(no subject)") + '</div>' +
        '<span class="badge" style="background:'+badgeBg+';color:'+badgeColor+';border-color:#e5e7eb;">' + c.status + '</span>' +
      '</div>' +
      '<div style="font-size:13px;color:#6b7280;margin-bottom:4px;">' +
        (c.name ? ('By '+c.name+' • ') : '') +
        (c.contact ? (c.contact+' • ') : '') +
        (c.ward ? ('Ward: '+c.ward) : '') +
      '</div>' +
      '<div class="muted" style="font-size:14px;margin-bottom:6px;">' +
        (c.project_id ? ('Project: <a href="./project.html?id='+c.project_id+'">'+c.project_id+'</a> • ') : '') +
        'Date: ' + (c.created_at || '') +
      '</div>' +
      '<div style="font-size:14px;margin-bottom:6px;">' + (c.details||'') + '</div>' +
      (c.photo_url ? ('<div><img src="'+c.photo_url+'" alt="photo" style="max-width:260px;border:1px solid #e5e7eb;border-radius:4px;"></div>') : '') +
    '</div>'
  );
}

function render(list){
  box.innerHTML = list.length ? list.map(cardHTML).join("") : '<div class="card">No grievances yet.</div>';
}

function filter(text){
  var s = (text||"").toLowerCase();
  if (!s) return all;
  return all.filter(function(c){
    return (c.subject||"").toLowerCase().includes(s) ||
           (c.ward||"").toLowerCase().includes(s) ||
           String(c.project_id||"").toLowerCase().includes(s);
  });
}

function updateSummary(list){
  var total=list.length,
      open=list.filter(c=>c.status==='open').length,
      prog=list.filter(c=>c.status==='in_progress').length,
      res=list.filter(c=>c.status==='resolved').length;
  var t=document.getElementById("countTotal"),
      o=document.getElementById("countOpen"),
      p=document.getElementById("countInProgress"),
      r=document.getElementById("countResolved");
  if (t) t.textContent=total;
  if (o) o.textContent=open;
  if (p) p.textContent=prog;
  if (r) r.textContent=res;
}

(function init(){
  all = (window.DEMO_COMPLAINTS || []).slice().sort(function(a,b){
    var ax=a.created_at||'', bx=b.created_at||''; return ax<bx?1:ax>bx?-1:0;
  });
  render(all);
  updateSummary(all);

  if (q) q.addEventListener("input", function(){ render(filter(q.value)); });
  if (clear) clear.addEventListener("click", function(){ q.value=""; render(all); q && q.focus(); });

  // Optional filter buttons (only if you added them in HTML)
  var fltAll=document.getElementById("fltAll"),
      fltOpen=document.getElementById("fltOpen"),
      fltProg=document.getElementById("fltProg"),
      fltRes=document.getElementById("fltRes");
  if (fltAll) fltAll.addEventListener("click", ()=>render(all));
  if (fltOpen) fltOpen.addEventListener("click", ()=>render(all.filter(c=>c.status==="open")));
  if (fltProg) fltProg.addEventListener("click", ()=>render(all.filter(c=>c.status==="in_progress")));
  if (fltRes) fltRes.addEventListener("click", ()=>render(all.filter(c=>c.status==="resolved")));
})();
