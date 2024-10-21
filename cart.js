const cartBtn = document.getElementById('cart-btn');
const cartModal = document.getElementById('cart-modal');
const closeBtn = document.querySelector('.close-btn');
const addToCartBtn = document.getElementById('add-to-cart-btn');
const cartItemsList = document.getElementById('cart-items');


let cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
window.onload = function() {
    updateCart();
};


cartBtn.addEventListener('click', () => {
    cartModal.style.display = 'block';
});


closeBtn.addEventListener('click', () => {
    cartModal.style.display = 'none';
});


addToCartBtn.addEventListener('click', () => {
    const color = document.getElementById('color').value;
    const engine = document.getElementById('engine').value;

    
    const carName = document.querySelector('.car-details h1').textContent;
    const carImageSrc = document.querySelector('.car-image img').src; 
    
    const carDetails = `${carName} - Szín: ${color}, Motor: ${engine}`;
    
    
    cartItems.push({ details: carDetails, image: carImageSrc });

    
    updateCart();
    saveCart();
});


function updateCart() {
    cartItemsList.innerHTML = ''; 

    cartItems.forEach((item, index) => {
        
        const li = document.createElement('li');
        
        
        const carText = document.createElement('p');
        carText.textContent = item.details;

        
        const img = document.createElement('img');
        img.src = item.image;
        img.alt = item.details;
        img.style.width = '100px'; 

        
        const deleteBtn = document.createElement('button');
        deleteBtn.textContent = 'Törlés';
        deleteBtn.style.marginLeft = '10px';
        deleteBtn.style.backgroundColor = '#ff4d4d';
        deleteBtn.style.color = 'white';
        deleteBtn.style.border = 'none';
        deleteBtn.style.padding = '5px 10px';
        deleteBtn.style.cursor = 'pointer';

        
        deleteBtn.addEventListener('click', () => {
            removeFromCart(index);
        });

        
        li.appendChild(img);
        li.appendChild(carText);
        li.appendChild(deleteBtn);

       
        cartItemsList.appendChild(li);
    });
}


function saveCart() {
    localStorage.setItem('cartItems', JSON.stringify(cartItems));
}


function removeFromCart(index) {
    cartItems.splice(index, 1);
    updateCart(); 
    saveCart(); 
}

window.onclick = function(event) {
    if (event.target == cartModal) {
        cartModal.style.display = 'none';
    }
}
