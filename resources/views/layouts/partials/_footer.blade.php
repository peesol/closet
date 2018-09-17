<div class="footer-nav">
  <button onclick='document.location.href="{{ route('home') }}"' class="dropdown-btn" name="button">
    <span class="icon-home"></span>
  </button>
  <button onclick='document.location.href="{{ route('trending') }}"' class="dropdown-btn" name="button">
    <span class="icon-fire"></span>
  </button>
  <button onclick='document.location.href="{{ route('categoryMain') }}"' class="dropdown-btn" name="button">
    <span class="icon-category"></span>
  </button>
  <notification-icon element="footer"></notification-icon>
  <cart-icon element="footer"></cart-icon>
</div>
