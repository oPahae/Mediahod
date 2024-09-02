let openSidebar = document.querySelector(".toggleSidebar"),
    sidebar = document.querySelector(".sidebar"),
    opened = true

window.onload = () => {
    sidebar.style.transform = "translate(-100%, -10px)"
}

openSidebar.addEventListener("click", function() {
    sidebar.style.transform = opened ? "translate(0, -10px)" : "translate(-100%, -10px)"
    opened = !opened
})