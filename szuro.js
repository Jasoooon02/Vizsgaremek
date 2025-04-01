document.addEventListener("DOMContentLoaded", function () {
    const cars = document.querySelectorAll('.car-item');
    const filterBtn = document.getElementById('filter-btn');
    const resetBtn = document.getElementById('reset-btn');
    const minPriceInput = document.getElementById('min-price');
    const maxPriceInput = document.getElementById('max-price');
    
    let currentCategory = 'all'; 

    
    const categoryLinks = document.querySelectorAll('.category-menu li');
    categoryLinks.forEach(link => {
        link.addEventListener('click', () => {
            const category = link.getAttribute('data-category');
            currentCategory = category; 
            updateCarDisplay();
        });
    });

    
    filterBtn.addEventListener('click', () => {
        updateCarDisplay();
    });

    
    resetBtn.addEventListener('click', () => {
        minPriceInput.value = '';
        maxPriceInput.value = '';
        updateCarDisplay(); 
    });

    
    function updateCarDisplay() {
        const minPrice = parseInt(minPriceInput.value) || 0;
        const maxPrice = parseInt(maxPriceInput.value) || 10000000000;

        cars.forEach(car => {
            const carCategory = car.getAttribute('data-category');
            const carPrice = parseInt(car.getAttribute('data-price'));

            
            if ((currentCategory === 'all' || carCategory === currentCategory) &&
                carPrice >= minPrice && carPrice <= maxPrice) {
                car.style.display = 'block';
            } else {
                car.style.display = 'none';
            }
        });
    }

    
    updateCarDisplay();
});