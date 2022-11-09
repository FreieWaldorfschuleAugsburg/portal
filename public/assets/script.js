const button = document.getElementById('nav-button')
let hidden = true;

button.addEventListener('click', (e) => {
    const navbar = document.getElementById('navbar');
    hidden = !hidden;
    if (hidden) {
        navbar.classList.add('hidden');
    } else {
        navbar.classList.remove('hidden');
    }
})