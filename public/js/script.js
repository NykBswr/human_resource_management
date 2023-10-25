// Sidebar toggle
const burger = document.getElementById('burger');
const sidebar = document.getElementById('sidebar');
const navbar = document.getElementById('navbar');
const main = document.getElementById('main');
const main2 = document.getElementById('main2');
const logo = document.getElementById('logo');
const logoproFile = document.getElementById('logoprofile');
const profile = document.getElementById('profile');

burger.addEventListener('click', () => {
    sidebar.classList.add('fixed');
    sidebar.classList.remove('hidden');
    main.classList.remove('px-20');
    main2.classList.remove('px-20');
    main.style.paddingLeft = '29rem';
    main.style.paddingRight = '5rem';
    main2.classList.add('px-12');
});

main.addEventListener('click', toggleSidebar);
logo.addEventListener('click', toggleSidebar);

function toggleSidebar() {
    if (sidebar.classList.contains('fixed')) {
        sidebar.classList.remove('fixed');
        sidebar.classList.add('hidden');
        main2.classList.remove('px-12');
        main.style.removeProperty('padding-left');
        main.style.removeProperty('padding-right');
        main.classList.add('px-20');
        main2.classList.add('px-20');
    }
}
logoproFile.addEventListener('click', () => {
    if (profile.classList.contains('hidden')) {
        profile.classList.remove('hidden');
        profile.classList.add('flex');
    } else {
        profile.classList.remove('flex');
        profile.classList.add('hidden');
    }
});

profile.addEventListener('click', () => {
    profile.classList.remove('flex');
    profile.classList.add('hidden');
});

// SUCCESS ALERT
document.addEventListener('DOMContentLoaded', function () {
    const successAlert = document.getElementById('success-alert');
    const closeAlertButton = document.getElementById('close-alert');

    if (successAlert && closeAlertButton) {
        closeAlertButton.addEventListener('click', function () {
            successAlert.style.display = 'none';
        });
    }
});

// PROFILE PICTURE

function previewImage() {
    const image = document.querySelector('#image');
    const imgPreview = document.querySelector('.img-preview');

    imgPreview.style.display = 'block';

    const reader = new FileReader();
    reader.readAsDataURL(image.files[0]);

    reader.onload = function (event) {
        imgPreview.src = event.target.result;
    }
}
