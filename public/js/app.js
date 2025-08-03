console.log('Hello from app.js!');

document.addEventListener('DOMContentLoaded', function() {
    const heading = document.querySelector('h1');
    if (heading) {
        heading.style.color = 'blue';
    }
});
