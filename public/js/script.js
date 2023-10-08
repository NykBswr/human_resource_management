document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const rightNav = document.querySelector(".hidden.md\\:block");

    menuToggle.addEventListener("click", function () {
        rightNav.classList.toggle("hidden");
    });
});
