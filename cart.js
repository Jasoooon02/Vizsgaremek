document.addEventListener("DOMContentLoaded", function () {
    const cartBtn = document.getElementById('cart-btn');
    const cartModal = document.getElementById('cart-modal');
    const closeBtn = document.querySelector('.close-btn');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const cartItemsList = document.getElementById('cart-items');
    const totalPriceElement = document.getElementById('total-price');
    const priceElement = document.getElementById('car-price');
    const colorSelect = document.getElementById("color");
    const carSlides = document.querySelectorAll(".car-slide");

    let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];

    
    window.onload = function() {
        updateCartDisplay();
        updatePrice();
    };

   
    cartBtn.addEventListener('click', () => {
        updateCartDisplay();
        cartModal.style.display = 'flex';
    });

    
    closeBtn.addEventListener('click', () => {
        cartModal.style.display = 'none';
    });

    
    addToCartBtn.addEventListener('click', () => {
        const carName = document.querySelector('.car-details h1').innerText;
        const carPrice = priceElement.innerText.replace(/\D/g, ""); 

        
        const color = colorSelect.value;
        const engine = document.getElementById('engine').value;

        
        const activeSlide = Array.from(carSlides).find(slide => slide.getAttribute("data-color") === color);
        const carImage = activeSlide ? activeSlide.src : '';

        const cartItem = {
            name: carName,
            image: carImage,
            price: parseInt(carPrice),
            color: color,
            engine: engine
        };

        
        cartItems.push(cartItem);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCartDisplay();
    });

    
    document.getElementById('engine').addEventListener('change', updatePrice);

    function updatePrice() {
        const engineSelect = document.getElementById('engine');
        const selectedOption = engineSelect.options[engineSelect.selectedIndex];
        const price = selectedOption.getAttribute('data-price');
        
        priceElement.innerText = price ? `${price.replace(/\B(?=(\d{3})+(?!\d))/g, " ")} Ft` : 'N/A';
    }

    
    function updateCartDisplay() {
        cartItemsList.innerHTML = '';
        let totalPrice = 0;

        cartItems.forEach((item, index) => {
            const li = document.createElement('li');
            li.innerHTML = `
                <img src="${item.image}" alt="${item.name}" style="width: 100px;">
                <span>${item.name} (${item.color}, ${item.engine}) - ${item.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")} Ft</span>
                <button class="remove-item" data-index="${index}">Törlés</button>
            `;
            cartItemsList.appendChild(li);
            totalPrice += item.price;
        });

        totalPriceElement.innerText = `Összesen: ${totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")} Ft`;

        
        const removeButtons = document.querySelectorAll('.remove-item');
        removeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = button.getAttribute('data-index');
                removeItem(index);
            });
        });
    }

   
    function removeItem(index) {
        cartItems.splice(index, 1);
        localStorage.setItem('cartItems', JSON.stringify(cartItems));
        updateCartDisplay();
    }

    
    colorSelect.addEventListener("change", function () {
        const selectedColor = colorSelect.value;

        carSlides.forEach(slide => slide.classList.remove("active"));

        const activeSlide = Array.from(carSlides).find(
            slide => slide.getAttribute("data-color") === selectedColor
        );

        if (activeSlide) {
            activeSlide.classList.add("active");
        }
    });
});
