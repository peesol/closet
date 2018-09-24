<div class="footer-nav">
  <button onclick='document.location.href="{{ route('home') }}"' class="dropdown-btn" name="button">
    <span class="fas fa-home"></span>
  </button>
  <button onclick='document.location.href="{{ route('trending') }}"' class="dropdown-btn" name="button">
    <span class="fas fa-fire"></span>
  </button>
  <button onclick='document.location.href="{{ route('categoryMain') }}"' class="dropdown-btn" name="button">
    <span class="fas fa-th-large"></span>
  </button>
  <notification-icon element="footer"></notification-icon>
  <cart-icon element="footer"></cart-icon>
</div>
