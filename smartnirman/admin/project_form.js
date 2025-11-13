document.getElementById("project-form").addEventListener("submit", async function (e) {
    e.preventDefault();

    var msg = document.getElementById("msg");
    msg.textContent = "Saving...";

    var form = new FormData(this);

    let res = await fetch("../api/add_project.php", {
        method: "POST",
        body: form
    });

    let data = await res.json();
    if (data.ok) {
        msg.textContent = "Project saved successfully!";
        this.reset();
    } else {
        msg.textContent = "Error: " + data.error;
    }
});
