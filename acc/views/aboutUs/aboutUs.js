
window.onload = () => {
    setTheme()
}

window.addEventListener("resize", () => {
    window.matchMedia("(min-width: 900px)").matches ? headerRight.style.display = 'flex' : null
})

// open sidebar //////////////////////////////////////

let openSidebar = document.querySelector("#openSidebar"),
    closeSidebar = document.querySelector("#closeSidebar"),
    sidebar = document.querySelector(".sidebar")

openSidebar.addEventListener("click", function() {
    sidebar.style.transform = "translateX(0)"
})
closeSidebar.addEventListener("click", function() {
    sidebar.style.transform = "translateX(-100%)"
})

// hover on sidebarElement //////////////////////////////////////

let sidebarElements = document.querySelectorAll(".sidebarElement")
sidebarElements.forEach((e) => {
    e.addEventListener("mouseover", function() {
        e.style.backgroundColor = "rgba(227, 227, 255, 0.26)"
        e.querySelector("i").style.color = "#fff"
        e.querySelector("p").style.color = "#fff"
        document.querySelector(".orange i").style.color = "#fff"
        document.querySelector(".orange p").style.color = "#fff"
    })
    e.addEventListener("mouseleave", function() {
        e.style.backgroundColor = ""
        e.querySelector("i").style.color = "#8F9FBC"
        e.querySelector("p").style.color = "#8F9FBC"
        document.querySelector(".orange i").style.color = "#fff"
        document.querySelector(".orange p").style.color = "#fff"
    })
})

// darkMode //////////////////////////////////////

function setTheme() {
    if(localStorage.getItem("dark") == "false") {
        document.documentElement.style.setProperty("--body", "#ececec")
        document.documentElement.style.setProperty("--darkMode", "#003366")
        document.documentElement.style.setProperty("--lightMode", "#fff")
        document.documentElement.style.setProperty("--text", "#000")
        document.documentElement.style.setProperty("--footer", "#fff")
        document.documentElement.style.setProperty("--sidebar", "#003366")
    } else {
        document.documentElement.style.setProperty("--body", "#141414")
        document.documentElement.style.setProperty("--darkMode", "#fff")
        document.documentElement.style.setProperty("--lightMode", "#003366")
        document.documentElement.style.setProperty("--text", "#fff")
        document.documentElement.style.setProperty("--footer", "#000")
        document.documentElement.style.setProperty("--sidebar", "#000")
    }
}

lightMode.addEventListener('click', function() {
    localStorage.setItem("dark", 'false')
    setTheme()
});

darkMode.addEventListener('click', function() {
    localStorage.setItem("dark", 'true')
    setTheme()
})

// headerRight @media //////////////////////////////////////

let toggleMenuRotation = 0
const toggleMenu = document.querySelector('#menu')
const headerRight = document.querySelector('.headerRight')

document.addEventListener('DOMContentLoaded', function() {
    toggleMenu.addEventListener('click', function() {
        headerRight.style.display = headerRight.style.display === 'flex' ? 'none' : 'flex'
        toggleMenuRotation = toggleMenuRotation == 0 ? 180 : 0
        toggleMenu.style.transform = `rotate(${toggleMenuRotation}deg)`
    })
})

// logout //////////////////////////////////////

