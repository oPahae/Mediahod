
window.onload = () => {
    setTheme()
}

window.addEventListener("resize", () => {
    window.matchMedia("(min-width: 900px)").matches ? headerRight.style.display = 'flex' : null
})

// open sidebar //////////////////////////////////////

let sidebarOpened = true,
    openSidebar = document.querySelector("#openSidebar"),
    sidebar = document.querySelector(".sidebar")

openSidebar.addEventListener("click", function() {
    sidebar.style.width = sidebarOpened ? "0" : "260px"
    sidebarOpened = !sidebarOpened
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
    cart = document.querySelector(".cart")

function setTheme() {
    if(localStorage.getItem("theme") == "0") {
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
        page.style.backgroundColor = "#fff"
        cart.style.backgroundColor = "#fff"
    } else {
        darkMode.style.backgroundColor = "#003366"
        darkMode.querySelector("i").style.color = "#fff"
        lightMode.style.backgroundColor = "#fff"
        lightMode.querySelector("i").style.color = "#003366"

        bodyBg.style.backgroundColor = "rgb(10, 10, 10)"
        header.style.backgroundColor = "rgb(10, 10, 10)"
        headerRight.style.backgroundColor = "rgb(10, 10, 10)"
        openSidebar.style.color = "#fff"
        sidebar.style.backgroundColor = "black"
        toggleMenu.style.color = "#fff"
        toggleDarkMode.style.border = "1px solid #fff"
        notifications.style.color = "#fff"
        page.style.backgroundColor = "rgb(10, 10, 10)"
        cart.style.backgroundColor = "black"
    }
}

lightMode.addEventListener('click', function() {
    localStorage.setItem("theme", 0)
    setTheme()
});

darkMode.addEventListener('click', function() {
    localStorage.setItem("theme", 1)
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

// cart functions //////////////////////////////////////

function incrementQuantity(button) {
    let input = button.previousElementSibling;
    input.value = parseInt(input.value) + 1;
}

function decrementQuantity(button) {
    let input = button.nextElementSibling;
    if (input.value > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

function removeItem(icon) {
    icon.parentElement.remove();
}