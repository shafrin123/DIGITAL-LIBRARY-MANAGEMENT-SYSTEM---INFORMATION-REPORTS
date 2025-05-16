document.addEventListener("DOMContentLoaded", function() {
    const sidebarToggle = document.querySelector(".sidebar-toggle");
    const sidebar = document.querySelector(".sidebar");
    const dashboard = document.querySelector(".dashboard");

    sidebarToggle.addEventListener("click", function() {
        sidebar.classList.toggle("shrink");
        dashboard.classList.toggle("shrink");
    });
});
