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

const bodyBg = document.body,
    lightMode = document.querySelector('#lightMode'),
    darkMode = document.querySelector('#darkMode'),
    header = document.querySelector('header'),
    toggleDarkMode = document.querySelector('.toggleDarkMode'),
    notifications = document.querySelector('#notifications'),
    page = document.querySelector(".page"),
    title = document.querySelector(".title")

function setTheme() {
    if(localStorage.getItem("dark") == "false") {
        darkMode.style.backgroundColor = "#fff"
        darkMode.querySelector("i").style.color = "#003366"
        lightMode.style.backgroundColor = "#003366"
        lightMode.querySelector("i").style.color = "#fff"

        bodyBg.style.backgroundColor = "rgb(236, 240, 243)"
        header.style.backgroundColor = "#fff"
        headerRight.style.backgroundColor = "#fff"
        openSidebar.style.color = "black"
        sidebar.style.backgroundColor = "#003366"
        toggleMenu.style.color = "black"
        toggleDarkMode.style.border = "1px solid black"
        notifications.style.color = "black"
        title.style.color = "black"

        document.documentElement.style.setProperty("--body", "#ececec")
        document.documentElement.style.setProperty("--darkMode", "#003366")
        document.documentElement.style.setProperty("--lightMode", "#fff")
        document.documentElement.style.setProperty("--text", "#000")
        document.documentElement.style.setProperty("--footer", "#fff")
        document.documentElement.style.setProperty("--sidebar", "#003366")
    } else {
        darkMode.style.backgroundColor = "#003366"
        darkMode.querySelector("i").style.color = "#fff"
        lightMode.style.backgroundColor = "#fff"
        lightMode.querySelector("i").style.color = "#003366"

        bodyBg.style.backgroundColor = "#141414"
        header.style.backgroundColor = "rgb(10, 10, 10)"
        headerRight.style.backgroundColor = "rgb(10, 10, 10)"
        openSidebar.style.color = "#fff"
        sidebar.style.backgroundColor = "black"
        toggleMenu.style.color = "#fff"
        toggleDarkMode.style.border = "1px solid #fff"
        notifications.style.color = "#fff"
        title.style.color = "#fff"

        document.documentElement.style.setProperty("--body", "#141414")
        document.documentElement.style.setProperty("--darkMode", "#fff")
        document.documentElement.style.setProperty("--lightMode", "#003366")
        document.documentElement.style.setProperty("--text", "#fff")
        document.documentElement.style.setProperty("--footer", "#000")
        document.documentElement.style.setProperty("--sidebar", "#000")
    }
}

lightMode.addEventListener('click', function() {
    localStorage.setItem("theme", false)
    setTheme()
});

darkMode.addEventListener('click', function() {
    localStorage.setItem("theme", true)
    setTheme()
})

// headerRight @media //////////////////////////////////////

// let toggleMenuRotation = 0
// const toggleMenu = document.querySelector('#menu')
// const headerRight = document.querySelector('.headerRight')

// document.addEventListener('DOMContentLoaded', function() {
//     toggleMenu.addEventListener('click', function() {
//         headerRight.style.display = headerRight.style.display === 'flex' ? 'none' : 'flex'
//         toggleMenuRotation = toggleMenuRotation == 0 ? 180 : 0
//         toggleMenu.style.transform = `rotate(${toggleMenuRotation}deg)`
//     })
// })

// window.addEventListener("resize", () => {
//     window.matchMedia("(min-width: 900px)").matches ? headerRight.style.display = 'flex' : null
// })