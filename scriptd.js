let cart = [];
let total = 0;

function addToCart(item, price) {
    cart.push({ item, price });
    total += price;
    updateCart();
}

function updateCart() {
    const cartItems = document.getElementById('cart-items');
    cartItems.innerHTML = ''; 

    cart.forEach((cartItem, carr) => {
        const li = document.createElement('li');
        li.textContent = `${cartItem.item} - $${cartItem.price.toFixed(2)}`;
        cartItems.appendChild(li);
    });

    document.getElementById('total').textContent = total.toFixed(2);
}

function checkout() {
    alert(`Gracias por su compra! Total: $${total.toFixed(2)}`);
    cart = [];
    total = 0;
    updateCart();
}
