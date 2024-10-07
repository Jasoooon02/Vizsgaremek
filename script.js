// Add event listeners to the navigation links
document.querySelectorAll('header nav a').forEach(link => {
    link.addEventListener('click', event => {
        event.preventDefault();
        const targetId = link.getAttribute('href').slice(1);
        document.querySelector(`#${targetId}`).scrollIntoView({ behavior: 'smooth' });
    });
});