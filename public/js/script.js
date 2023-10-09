document.addEventListener("DOMContentLoaded", function () {
    const menuToggle = document.getElementById("menu-toggle");
    const rightNav = document.querySelector(".hidden.md\\:block");

    menuToggle.addEventListener("click", function () {
        rightNav.classList.toggle("hidden");
    });
});

// Sidebar toggle
const burger = document.getElementById('burger');
const sidebar = document.getElementById('sidebar');
const navbar = document.getElementById('navbar');
const main = document.getElementById('main');
const main2 = document.getElementById('main2');
const logo = document.getElementById('logo');
const logoprofile = document.getElementById('logoprofile');
const profile = document.getElementById('profile');

burger.addEventListener('click', () => {
    sidebar.classList.add('fixed');
    sidebar.classList.remove('hidden');
    main.classList.remove('px-20');
    main2.classList.remove('px-20');
    main.classList.add('pl-[29rem]');
    main.classList.add('pr-20');
    main2.classList.add('px-12');
});

main.addEventListener('click', toggleSidebar);
logo.addEventListener('click', toggleSidebar);

function toggleSidebar() {
    if (sidebar.classList.contains('fixed')) {
        sidebar.classList.remove('fixed');
        sidebar.classList.add('hidden');
        main.classList.remove('pl-[29rem]');
        main2.classList.remove('px-12');
        main.classList.remove('pr-20');
        main.classList.add('px-20');
        main2.classList.add('px-20');
    }
}

logoprofile.addEventListener('click', () => {
    profile.classList.remove('hidden');
    profile.classList.add('flex');
});

profile.addEventListener('click', () => {
    profile.classList.remove('flex');
    profile.classList.add('hidden');
});
