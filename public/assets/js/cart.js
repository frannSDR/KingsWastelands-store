//! ----------- logica del side carrito de compras ----------- //

const CART_UPDATED_EVENT = 'cartUpdated';

document.addEventListener('DOMContentLoaded', function() {
  const cartIcon = document.getElementById('cart-icon');
  const cartSidebar = document.querySelector('.cart-sidebar');
  const cartOverlay = document.querySelector('.cart-overlay');
  const closeCartBtn = document.querySelector('.close-cart');
  const cartItems = document.querySelector('.cart-items');
  const emptyCartMessage = document.querySelector('.empty-cart-message');
  const cartFooter = document.querySelector('.cart-footer');
  const totalPriceElement = document.querySelector('.total-price');
  
  window.cart = [] // variable global unica para el carrito
  
  // funciones para actualizar el contador del carrito
  function updateCartCount() {
    // const cartCountElement = document.querySelector('.cart-item-count');
    const itemCount = window.cart.reduce((total, item) => total + item.quantity, 0);
    
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
  
  // Función manejadora para cambios en inputs de cantidad
  function handleQuantityChange() {
    const index = parseInt(this.getAttribute('data-index'));
    const newQuantity = parseInt(this.value);
    
    if (newQuantity > 0 && newQuantity <= 5) {
      window.cart[index].quantity = newQuantity;
      saveCartToLocalStorage();
      updateCartUI();
      updateCartCount();
      // Disparar evento de actualización
      document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
    } else {
      alert('La cantidad debe estar entre 1 y 5 elementos');
      this.value = window.cart[index].quantity;
    }
  }
  
  // Esta función debe ser llamada después de actualizar la interfaz
  function setupQuantityInputListeners() {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
      // Eliminar listeners anteriores si existen
      input.removeEventListener('change', handleQuantityChange);
      // Agregar el nuevo listener
      input.addEventListener('change', handleQuantityChange);
    });
  }
  
  // Configurar el evento de click una sola vez fuera de updateCartUI
  cartItems.addEventListener('click', function(e) {
    const target = e.target;
    
    // disminuye la cantidad de items en el carrito
    if (target.classList.contains('decrease')) {
      const index = parseInt(target.getAttribute('data-index'));
      if (window.cart[index].quantity > 1) {
        window.cart[index].quantity -= 1;
        saveCartToLocalStorage();
        updateCartUI();
        updateCartCount();
        // Disparar evento de actualización
        document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
      } else {
        alert('La cantidad minima es de 1 elemento');
      }
    }
    
    // aumenta la cantidad de elementos en el carrito
    if (target.classList.contains('increase')) {
      const index = parseInt(target.getAttribute('data-index'));
      if (window.cart[index].quantity < 5) {
        window.cart[index].quantity += 1;
        saveCartToLocalStorage();
        updateCartUI();
        updateCartCount();
        // Disparar evento de actualización
        document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
      }
    }
    
    // Handle remove button
    if (target.classList.contains('remove-item') || 
        (target.parentElement && target.parentElement.classList.contains('remove-item'))) {
      const button = target.classList.contains('remove-item') ? target : target.parentElement;
      const index = parseInt(button.getAttribute('data-index'));
      window.cart.splice(index, 1);
      saveCartToLocalStorage();
      updateCartUI();
      updateCartCount();
      // Disparar evento de actualización
      document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
    }
  });
  
  // funcion para actualizar la interfaz del carrito
  function updateCartUI() {
    cartItems.innerHTML = '';
    
    if (window.cart.length === 0) {
      emptyCartMessage.classList.add('active');
      cartFooter.style.display = 'none';
    } else {
      emptyCartMessage.classList.remove('active');
      cartFooter.style.display = 'block';
      
      let totalPrice = 0;
      
      window.cart.forEach((item, index) => {
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
      
      // Configurar los listeners para los inputs de cantidad
      setupQuantityInputListeners();
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
      window.cart = JSON.parse(savedCart);
      updateCartCount();
    }
  }
  
  // inicializamos el carrito y los event listeners
  function init() {
    // creamos el circulito que sirve de contador para el carrito
    // if (!document.querySelector('.cart-item-count')) {
    //   const cartCountElement = document.createElement('span');
    //   cartCountElement.classList.add('cart-item-count');
    //   cartIcon.parentNode.appendChild(cartCountElement);
    // }
    
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
    const existingItem = window.cart.find(item => item.id === productId);
    
    if (existingItem) {
      existingItem.quantity++;
    } else {
      window.cart.push({
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
    // Disparar evento de actualización
    document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
  };
  
  // inicializamos el carrito con todas sus funciones
  init();
});

//! ---------- seccion del carrito de compras ---------- //

document.addEventListener('DOMContentLoaded', function() {
  const cartItemsList = document.querySelector('.cart-items-list');
  const emptyCartMessage2 = document.querySelector('.empty-cart-message2');
  const itemsCountElement = document.querySelector('.items-count');
  const subtotalElement = document.querySelector('.subtotal');
  const totalPriceElement2 = document.querySelector('.total-price2');
  const checkoutBtn = document.querySelector('.checkout-btn');

  // usamos la variable global del carrito de compras en lugar de la local anterior, asi podemos sincronizar los eventos de ambos carritos

  // Inicializar la página del carrito
  function initCartPage() {
    // Cargar el carrito si no se cargó antes
    if (!window.cart || window.cart.length === 0) {
      const savedCart = localStorage.getItem('cart');
      if (savedCart) {
        window.cart = JSON.parse(savedCart);
      } else {
        window.cart = [];
      }
    }
    
    updateCartUI();
    updateCartCount();
    
    // Event listener para el botón de pago
    if (checkoutBtn) {
      checkoutBtn.addEventListener('click', proceedToCheckout);
    }
    
    // Escuchar el evento personalizado para actualizaciones del carrito
    document.addEventListener(CART_UPDATED_EVENT, function() {
      updateCartUI();
      updateCartCount();
    });
  }

  // Actualizar la interfaz del carrito
  function updateCartUI() {
    if (!cartItemsList) return;
    
    cartItemsList.innerHTML = '';
    
    if (!window.cart || window.cart.length === 0) {
      if (emptyCartMessage2) emptyCartMessage2.classList.add('active');
      if (checkoutBtn) checkoutBtn.disabled = true;
      
      // si el carrito esta vacio, mostramos 0.00 en el subtotal y total y desactivamos el boton de checkout
      if (subtotalElement) subtotalElement.textContent = '$0.00';
      if (totalPriceElement2) totalPriceElement2.textContent = '$0.00';
    } else {
      if (emptyCartMessage2) emptyCartMessage2.classList.remove('active');
      if (checkoutBtn) checkoutBtn.disabled = false;
      
      let subtotal = 0;
      
      window.cart.forEach((item, index) => {
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
                <button class="quantity-btn decrease" data-index="${index}">-</button>
                <input type="number" value="${item.quantity}" min="1" class="quantity-input" data-index="${index}">
                <button class="quantity-btn increase" data-index="${index}">+</button>
              </div>
              <button class="remove-item" data-index="${index}">
                <i class="bi bi-trash"></i> Eliminar
              </button>
            </div>
          </div>
        `;
        
        cartItemsList.appendChild(cartItemElement);
        subtotal += item.price * item.quantity;
      });
      
      // Actualizar totales
      if (subtotalElement) subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
      if (totalPriceElement2) totalPriceElement2.textContent = `$${subtotal.toFixed(2)}`;
      
      // Configurar event listeners para los controles de cantidad
      setupQuantityControls();
    }
  }

  // Función manejadora para cambios en inputs de cantidad
  function handleQuantityChange() {
    const index = parseInt(this.getAttribute('data-index'));
    const newQuantity = parseInt(this.value);
    
    if (newQuantity > 0 && newQuantity <= 5) {
      window.cart[index].quantity = newQuantity;
      saveCart();
      updateCartUI();
      updateCartCount();
      // Disparar evento de actualización
      document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
    } else {
      alert('La cantidad debe estar entre 1 y 5 elementos');
      this.value = window.cart[index].quantity;
    }
  }

  // Configurar controles de cantidad
  function setupQuantityControls() {
    // Disminuir cantidad
    document.querySelectorAll('.cart-items-list .decrease').forEach(btn => {
      // Eliminar listeners anteriores para evitar duplicación
      btn.removeEventListener('click', decreaseQuantity);
      btn.addEventListener('click', decreaseQuantity);
    });
    
    // Aumentar cantidad
    document.querySelectorAll('.cart-items-list .increase').forEach(btn => {
      // Eliminar listeners anteriores para evitar duplicación
      btn.removeEventListener('click', increaseQuantity);
      btn.addEventListener('click', increaseQuantity);
    });
    
    // Cambio en input de cantidad
    document.querySelectorAll('.cart-items-list .quantity-input').forEach(input => {
      // Eliminar listeners anteriores para evitar duplicación
      input.removeEventListener('change', handleQuantityChange);
      input.addEventListener('change', handleQuantityChange);
    });
    
    // Eliminar item
    document.querySelectorAll('.cart-items-list .remove-item').forEach(btn => {
      // Eliminar listeners anteriores para evitar duplicación
      btn.removeEventListener('click', removeItem);
      btn.addEventListener('click', removeItem);
    });
  }

  // Funciones auxiliares para los listeners
  function decreaseQuantity() {
    const index = parseInt(this.getAttribute('data-index'));
    if (window.cart[index].quantity > 1) {
      window.cart[index].quantity--;
      saveCart();
      updateCartUI();
      updateCartCount();
      // Disparar evento de actualización
      document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
    } else {
      alert('La cantidad mínima es 1');
    }
  }

  function increaseQuantity() {
    const index = parseInt(this.getAttribute('data-index'));
    if (window.cart[index].quantity < 5) {
      window.cart[index].quantity++;
      saveCart();
      updateCartUI();
      updateCartCount();
      // Disparar evento de actualización
      document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
    } else {
      alert('La cantidad máxima es 5');
    }
  }

  function removeItem() {
    const index = parseInt(this.getAttribute('data-index'));
    window.cart.splice(index, 1);
    saveCart();
    updateCartUI();
    updateCartCount();
    // Disparar evento de actualización
    document.dispatchEvent(new CustomEvent(CART_UPDATED_EVENT));
  }

  // Actualizar contador de items
  function updateCartCount() {
    if (!itemsCountElement) return;
    
    const itemCount = window.cart.reduce((total, item) => total + item.quantity, 0);
    itemsCountElement.textContent = itemCount;
  }

  // Guardar carrito en localStorage
  function saveCart() {
    localStorage.setItem('cart', JSON.stringify(window.cart));
  }

  // Proceder al pago
  function proceedToCheckout() {
    // Aquí puedes redirigir a la página de checkout o procesar el pago
    window.location.href = 'pago';
  }

  // Inicializar la página si estamos en la página del carrito
  if (cartItemsList) {
    initCartPage();
  }
});