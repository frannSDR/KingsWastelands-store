//! ----------- logica del side carrito de compras ----------- //

document.addEventListener('DOMContentLoaded', function() {
    const cartIcon = document.getElementById('cart-icon');
    const cartSidebar = document.querySelector('.cart-sidebar');
    const cartOverlay = document.querySelector('.cart-overlay');
    const closeCartBtn = document.querySelector('.close-cart');
    const cartItems = document.querySelector('.cart-items');
    const emptyCartMessage = document.querySelector('.empty-cart-message');
    const cartFooter = document.querySelector('.cart-footer');
    const totalPriceElement = document.querySelector('.total-price');
    
    let cart = []; // hacemos esto para que el carrito arranque vacio
    
    // funciones para actualizar el contador del carrito
    function updateCartCount() {
      const cartCountElement = document.querySelector('.cart-item-count');
      const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
      
      if (cartCountElement) {
        cartCountElement.textContent = itemCount;
        cartCountElement.style.display = itemCount > 0 ? 'flex' : 'none';
      }
      
      // Also update mobile cart count (called via MutationObserver in menu code)
      const mobileCartCount = document.querySelector('.mobile-cart-count');
      if (mobileCartCount) {
        mobileCartCount.textContent = itemCount;
        mobileCartCount.style.display = itemCount > 0 ? 'inline-block' : 'none';
      }
    }
    
    // funcion para abrir el carrito
    function openCart() {
      cartSidebar.classList.add('active');
      cartOverlay.classList.add('active');
      document.body.style.overflow = 'hidden';
      updateCartUI();
    }
    
    // Make openCart available globally
    window.openCart = openCart;
    
    // funcion para cerrar el carrito
    function closeCart() {
      cartSidebar.classList.remove('active');
      cartOverlay.classList.remove('active');
      document.body.style.overflow = '';
    }
    
    // funcion para actualizar la interfaz del carrito
    function updateCartUI() {
      cartItems.innerHTML = '';
      
      if (cart.length === 0) {
        emptyCartMessage.classList.add('active');
        cartFooter.style.display = 'none';
      } else {
        emptyCartMessage.classList.remove('active');
        cartFooter.style.display = 'block';
        
        let totalPrice = 0;
        
        cart.forEach((item, index) => {
          const cartItemElement = document.createElement('div');
          cartItemElement.classList.add('cart-item');
          
          cartItemElement.innerHTML = `
            <div class="item-image">
              <img src="${item.image}" alt="${item.name}">
            </div>
            <div class="item-details">
              <h3>${item.name}</h3>
              <p class="item-price">$${item.price}</p>
            </div>
            <div class="item-quantity">
              <button class="quantity-btn decrease" data-index="${index}">-</button>
              <input type="number" value="${item.quantity}" min="1" class="quantity-input" data-index="${index}">
              <button class="quantity-btn increase" data-index="${index}">+</button>
            </div>
            <button class="remove-item" data-index="${index}"><i class="bi bi-trash"></i></button>
          `;
          cartItems.appendChild(cartItemElement);
          totalPrice += item.price * item.quantity;
        });
        
        totalPriceElement.textContent = `$${totalPrice.toFixed(2)}`;
        
        // Use event delegation for cart item interactions
        cartItems.addEventListener('click', function(e) {
          const target = e.target;
          
          // Handle decrease button
          if (target.classList.contains('decrease')) {
            const index = parseInt(target.getAttribute('data-index'));
            if (cart[index].quantity > 1) {
              cart[index].quantity--;
              updateCartUI();
              updateCartCount();
              saveCartToLocalStorage();
            }
          }
          
          // Handle increase button
          if (target.classList.contains('increase')) {
            const index = parseInt(target.getAttribute('data-index'));
            cart[index].quantity++;
            updateCartUI();
            updateCartCount();
            saveCartToLocalStorage();
          }
          
          // Handle remove button
          if (target.classList.contains('remove-item') || 
              (target.parentElement && target.parentElement.classList.contains('remove-item'))) {
            const button = target.classList.contains('remove-item') ? target : target.parentElement;
            const index = parseInt(button.getAttribute('data-index'));
            cart.splice(index, 1);
            updateCartUI();
            updateCartCount();
            saveCartToLocalStorage();
          }
        });
        
        // Handle quantity input changes
        const quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(input => {
          input.addEventListener('change', function() {
            const index = parseInt(this.getAttribute('data-index'));
            const value = parseInt(this.value);
            
            if (value > 0) {
              cart[index].quantity = value;
            } else {
              this.value = 1;
              cart[index].quantity = 1;
            }
            
            updateCartUI();
            updateCartCount();
            saveCartToLocalStorage();
          });
        });
      }
    }
    
    // hacemos esto para que el contenido del carrito persista de manera local
    function saveCartToLocalStorage() {
      localStorage.setItem('cart', JSON.stringify(cart));
    }
    
    // cargamos el contenido almacenado en el carrito
    function loadCartFromLocalStorage() {
      const savedCart = localStorage.getItem('cart');
      if (savedCart) {
        cart = JSON.parse(savedCart);
        updateCartCount();
      }
    }
    
    // inicializamos el carrito y los event listeners
    function init() {
      // creamos el circulito que sirve de contador para el carrito
      if (!document.querySelector('.cart-item-count')) {
        const cartCountElement = document.createElement('span');
        cartCountElement.classList.add('cart-item-count');
        cartIcon.parentNode.appendChild(cartCountElement);
      }
      
      loadCartFromLocalStorage();
  
      // event listeners
      if (cartIcon) {
        cartIcon.addEventListener('click', function(e) {
          e.preventDefault();
          openCart();
        });
      }
      
      if (closeCartBtn) {
        closeCartBtn.addEventListener('click', closeCart);
      }
      
      if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCart);
      }
      
      // boton para continuar con la comprar
      const buyNowBtn = document.querySelector('.buy-now-btn');
      if (buyNowBtn) {
        buyNowBtn.addEventListener('click', function() {
          window.location.href = 'cart';
          setTimeout(closeCart, 1000);
        });
      }
    }
    
    // funcion para agregar productos al carrito
    window.addToCart = function(productId, name, price, image = 'assets/img/dslogo.png') {
      const existingItem = cart.find(item => item.id === productId);
      
      if (existingItem) {
        existingItem.quantity++;
      } else {
        cart.push({
          id: productId,
          name: name,
          price: price,
          image: image,
          quantity: 1
        });
      }
      
      updateCartCount();
      saveCartToLocalStorage();
      openCart();
    };
    
    // inicializamos el carrito con todas sus funciones
    init();
});

//! ---------- seccion del carrito de compras ---------- //

const cartItemsList = document.querySelector('.cart-items-list');
const emptyCartMessage2 = document.querySelector('.empty-cart-message2');
const itemsCountElement = document.querySelector('.items-count');
const subtotalElement = document.querySelector('.subtotal');
const totalPriceElement2 = document.querySelector('.total-price2');
const checkoutBtn = document.querySelector('.checkout-btn');

let cart = JSON.parse(localStorage.getItem('cart')) || [];

// Inicializar la página del carrito
function initCartPage() {
    updateCartUI();
    updateCartCount();
    
    // Event listener para el botón de pago
    checkoutBtn.addEventListener('click', proceedToCheckout);
}

// Actualizar la interfaz del carrito
function updateCartUI() {
    cartItemsList.innerHTML = '';
    
    if (cart.length === 0) {
        emptyCartMessage2.classList.add('active');
        checkoutBtn.disabled = true;
    } else {
        emptyCartMessage2.classList.remove('active');
        checkoutBtn.disabled = false;
        
        let subtotal = 0;
        
        cart.forEach((item, index) => {
            const cartItemElement = document.createElement('div');
            cartItemElement.classList.add('cart-item2');
            
            cartItemElement.innerHTML = `
                <div class="item-image2">
                    <img src="${item.image}" alt="${item.name}">
                </div>
                <div class="item-details2">
                    <h3>${item.name}</h3>
                    <p class="item-price2">$${item.price.toFixed(2)}</p>
                    <div class="item-actions">
                        <div class="item-quantity2">
                            <button class="quantity-btn2 decrease" data-index="${index}">-</button>
                            <input type="number" value="${item.quantity}" min="1" class="quantity-input2" data-index="${index}">
                            <button class="quantity-btn2 increase" data-index="${index}">+</button>
                        </div>
                        <button class="remove-item2" data-index="${index}">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                </div>
            `;
            
            cartItemsList.appendChild(cartItemElement);
            subtotal += item.price * item.quantity;
        });
        
        // Actualizar totales
        subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
        totalPriceElement2.textContent = `$${subtotal.toFixed(2)}`;
        
        // Configurar event listeners para los controles de cantidad
        setupQuantityControls();
    }
}

// Configurar controles de cantidad
function setupQuantityControls() {
    // Disminuir cantidad
    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            if (cart[index].quantity > 1) {
                cart[index].quantity--;
                saveCart();
                updateCartUI();
            }
        });
    });
    
    // Aumentar cantidad
    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            cart[index].quantity++;
            saveCart();
            updateCartUI();
        });
    });
    
    // Cambio en input de cantidad
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const index = parseInt(this.getAttribute('data-index'));
            const newQuantity = parseInt(this.value);
            
            if (newQuantity > 0) {
                cart[index].quantity = newQuantity;
                saveCart();
                updateCartUI();
            } else {
                this.value = cart[index].quantity;
            }
        });
    });
    
    // Eliminar item
    document.querySelectorAll('.remove-item2').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            cart.splice(index, 1);
            saveCart();
            updateCartUI();
        });
    });
}

// Actualizar contador de items
function updateCartCount() {
    const itemCount = cart.reduce((total, item) => total + item.quantity, 0);
    itemsCountElement.textContent = itemCount;
}

// Guardar carrito en localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartCount();
}

// Proceder al pago
function proceedToCheckout() {
    // Aquí puedes redirigir a la página de checkout o procesar el pago
    window.location.href = 'pago';
}

// Inicializar la página
initCartPage();