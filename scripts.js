document.addEventListener('DOMContentLoaded', function () {
    const categoryLinks = document.querySelectorAll('.category-menu li');
    const cars = document.querySelectorAll('.car-item');

    categoryLinks.forEach(link => {
        link.addEventListener('click', () => {
            const selectedCategory = link.getAttribute('data-category');

            
            categoryLinks.forEach(link => link.classList.remove('selected'));
            link.classList.add('selected');

            
            cars.forEach(car => {
                const carCategory = car.getAttribute('data-category');
                if (selectedCategory === 'all' || carCategory === selectedCategory) {
                    car.style.display = 'block';
                } else {
                    car.style.display = 'none';
                }
            });
        });
    });

    
    document.querySelector('[data-category="all"]').click();
});
