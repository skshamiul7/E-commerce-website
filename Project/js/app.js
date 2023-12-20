//cart
let openShopping = document.querySelector('.cartlis');
let closeShopping = document.querySelector('.cartXmark');
let body = document.getElementById('cart-id');

openShopping.addEventListener('click', (e) => {
  e.preventDefault();
  body.classList.add('active');
});

closeShopping.addEventListener('click', () => {
  body.classList.remove('active');
});

document.addEventListener("DOMContentLoaded", function () {
  var addToCartButtons = document.querySelectorAll('.card-btn');
  var checkoutButton = document.getElementById('checkoutButton');
  var quantityDisplay = document.querySelector('.quantity');
  var cartQuantity = 0;

  addToCartButtons.forEach(function (button) {
    button.addEventListener('click', function () {
      var productCard = button.closest('.product-card');
      var productName = productCard.querySelector('.product-brand').innerText;
      var productPrice = productCard.querySelector('.price').innerText;

      var newItem = document.createElement('li');
      newItem.classList.add('cart-item');

      newItem.innerHTML = '<span>' + productName + '</span><span>' + productPrice + '</span>' +
        '<button class="clear-btn">Clear</button>';
      var cart = document.querySelector('.cart-card .addcart-list');
      cart.insertBefore(newItem, cart.firstChild);
      updateTotal();

      cartQuantity++;
      quantityDisplay.innerText = cartQuantity;

      var clearButton = newItem.querySelector('.clear-btn');
      clearButton.addEventListener('click', function () {
        cart.removeChild(newItem);
        updateTotal();

        cartQuantity--;
        quantityDisplay.innerText = cartQuantity;
      });
    });
  });

  function updateTotal() {
    var total = 0;
    var prices = document.querySelectorAll('.cart-item span:nth-child(2)');

    prices.forEach(function (price) {
      total += parseInt(price.innerText.replace('TK ', '').replace(',', '').trim());
    });

    document.querySelector('.cart-card .total').innerText = 'Total: TK ' + total.toLocaleString();
  }

  checkoutButton.addEventListener('click', function () {
    var cartItems = document.querySelector('.cart-card .addcart-list').children;

    if (cartItems.length > 0) {
      var total = calculateTotal();
      window.location.href = `payment.html?totalAmount=${total}`;

      document.querySelector('.cart-card .addcart-list').innerHTML = '';
      updateTotal();

      alert('Redirecting to payment page...');
    } else {
      alert('Your cart is empty. Add items before checking out.');
    }
  });

  function calculateTotal() {
    var total = 0;
    var prices = document.querySelectorAll('.cart-item span:nth-child(2)');

    prices.forEach(function (price) {
      total += parseInt(price.innerText.replace('TK ', '').replace(',', '').trim());
    });

    return total;
  }
});
