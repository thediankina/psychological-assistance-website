function openMenu() {

    let show;

    let sidebar = document.getElementById("sidebar");
    let overlay = document.getElementById("overlay");

    if (sidebar.style.display === "none") { show = "block"; }
    else { show = "none"; }

    sidebar.style.display = show;
    overlay.style.display = show;
}
