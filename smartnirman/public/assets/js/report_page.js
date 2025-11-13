var form = document.getElementById("gform");
var msg  = document.getElementById("gmsg");

form.addEventListener("submit", function(e){
  e.preventDefault();
  msg.textContent = "Submitting...";

  var fd = new FormData(form);

  // Submit to server API (adjust path if your public pages are served from a different base)
  fetch('../api/add_grievance.php', {
    method: 'POST',
    body: fd
  }).then(function(res){
    return res.json();
  }).then(function(data){
    if (data && data.success) {
      msg.textContent = '✓ Thanks — we\'ve received your report.';
      form.reset();
    } else {
      msg.textContent = (data && data.message) ? data.message : 'Failed to submit.';
    }
  }).catch(function(err){
    console.error(err);
    msg.textContent = 'Failed to submit (network error).';
  });
});
