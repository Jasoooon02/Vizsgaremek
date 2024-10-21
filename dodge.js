const cartBtn = document.getElementById('cart-btn');
const cartModal = document.getElementById('cart-modal');
const closeBtn = document.querySelector('.close-btn');
const addToCartBtn = document.getElementById('add-to-cart-btn');
const cartItemsList = document.getElementById('cart-items');
const totalPriceElement = document.getElementById('total-price');
const priceElement = document.getElementById('car-price');

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
    const carImage = document.querySelector('.car-image img').src;
    const carPrice = priceElement.innerText.replace(/\D/g, "");

    const color = document.getElementById('color').value;
    const engine = document.getElementById('engine').value;

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
    
    const formattedPrice = price ? `${price.replace(/\B(?=(\d{3})+(?!\d))/g, " ")} Ft` : 'N/A';
    priceElement.innerText = formattedPrice;
}

function updateCartDisplay() {
    cartItemsList.innerHTML = '';
    let totalPrice = 0;

    cartItems.forEach((item, index) => {
        const li = document.createElement('li');
        li.innerHTML = `
            <img src="${item.image}" alt="${item.name}" style="width: 100px;">
            <span>${item.name} (${item.color}, ${item.engine}) - ${item.price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")} Ft</span>
            <button onclick="removeItem(${index})">Törlés</button>
        `;
        cartItemsList.appendChild(li);
        totalPrice += item.price;
    });

    totalPriceElement.innerText = `Összesen: ${totalPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ")} Ft`;
}

function removeItem(index) {
    cartItems.splice(index, 1);
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
    updateCartDisplay();
}
