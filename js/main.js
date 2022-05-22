function openMenu() {

    let show;

    let sidebar = document.getElementById("sidebar");
    let overlay = document.getElementById("overlay");

    if (sidebar.style.display === "none") { show = "block"; }
    else { show = "none"; }

    sidebar.style.display = show;
    overlay.style.display = show;
}

function getSelectedIds($grid_name) {

    return $.fn.yiiGridView.getChecked($grid_name, "selectedIds").toString();
}

function updateGrid($grid_name) {
    $.fn.yiiGridView.update($grid_name);
}
