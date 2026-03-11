<?php
  $current = $this->uri->segment(2);
  $ps_pages = ['ps_prod', 'ps_serv_simulation', 'ps_serv_silicone', 'ps_iotsolution'];
?>
<!-- Fixed Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container">
    <!-- Logo on the LEFT -->
    <a class="navbar-brand" href="<?= base_url('index') ?>">
      <img src="<?= base_url('assets_system/images/header_logo.png') ?>" alt="Line Seiki Logo">
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation items -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link <?= (empty($current) || $current == 'index') ? 'active' : '' ?>" href="<?= base_url() ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link <?= ($current == 'about_us') ? 'active' : '' ?>" href="<?= base_url('index/about_us') ?>">About Us</a></li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle <?= in_array($current, $ps_pages) ? 'active' : '' ?>" href=" " id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            Product and Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item <?= ($current == 'ps_prod') ? 'active' : '' ?>" href="<?= base_url('index/ps_prod') ?>">Products</a></li>

            <!-- Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle" href="#">Services</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item <?= ($current == 'ps_serv_simulation') ? 'active' : '' ?>" href="<?= base_url('index/ps_serv_simulation') ?>">Simulation Analysis</a></li>
                <li><a class="dropdown-item <?= ($current == 'ps_serv_silicone') ? 'active' : '' ?>" href="<?= base_url('index/ps_serv_silicone') ?>">Silicone Molding & Urethane Casting</a></li>
              </ul>
            </li>

            <li><a class="dropdown-item <?= ($current == 'ps_iotsolution') ? 'active' : '' ?>" href="<?= base_url('index/ps_iotsolution') ?>">IoT Solution</a></li>
          </ul>
        </li>

        <li class="nav-item"><a class="nav-link <?= ($current == 'news_event') ? 'active' : '' ?>" href="<?= base_url('index/news_event') ?>">News and Events</a></li>
        <li class="nav-item"><a class="nav-link <?= ($current == 'library') ? 'active' : '' ?>" href="<?= base_url('index/library') ?>">Library</a></li>
        <li class="nav-item"><a class="nav-link <?= ($current == 'contact_us') ? 'active' : '' ?>" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>

        <!-- Search Toggle -->
        <li class="nav-item ms-2">
          <button class="btn nav-search-toggle" type="button" id="searchToggleBtn" aria-label="Search">
            <i class="fas fa-search"></i>
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Search Overlay -->
<div class="search-overlay" id="searchOverlay">
  <div class="search-overlay-inner">
    <form action="<?= base_url('index/search') ?>" method="get" class="search-form" id="globalSearchForm">
      <div class="search-input-wrap">
        <i class="fas fa-search search-icon"></i>
        <input type="text" name="q" id="globalSearchInput" class="search-input" placeholder="Search products, services, news..." autocomplete="off" required minlength="2">
        <button type="submit" class="search-submit-btn">Search</button>
      </div>
    </form>
    <p class="search-hint">Press <kbd>ESC</kbd> to close</p>
  </div>
</div>

<style>
/* Search Toggle Button */
.nav-search-toggle {
  background: none;
  border: none;
  color: var(--dark);
  font-size: 1.05rem;
  padding: 0.5rem 0.7rem;
  border-radius: 8px;
  transition: var(--transition);
  cursor: pointer;
}
.nav-search-toggle:hover {
  color: var(--primary-blue);
  background: rgba(13, 110, 253, 0.08);
}

/* Search Overlay */
.search-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 70, 123, 0.92);
  backdrop-filter: blur(12px);
  z-index: 9999;
  display: flex;
  align-items: flex-start;
  justify-content: center;
  padding-top: 18vh;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}
.search-overlay.open {
  opacity: 1;
  visibility: visible;
}
.search-overlay-inner {
  width: 100%;
  max-width: 680px;
  padding: 0 20px;
  transform: translateY(-30px);
  transition: transform 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
}
.search-overlay.open .search-overlay-inner {
  transform: translateY(0);
}

/* Search Input */
.search-input-wrap {
  display: flex;
  align-items: center;
  background: rgba(255,255,255,0.12);
  border: 2px solid rgba(255,255,255,0.25);
  border-radius: 16px;
  padding: 6px 8px 6px 20px;
  transition: border-color 0.3s ease;
}
.search-input-wrap:focus-within {
  border-color: var(--newblue);
  background: rgba(255,255,255,0.18);
}
.search-icon {
  color: rgba(255,255,255,0.6);
  font-size: 1.15rem;
  margin-right: 14px;
}
.search-input {
  flex: 1;
  border: none;
  outline: none;
  background: transparent;
  color: #fff;
  font-size: 1.2rem;
  font-family: 'Inter', sans-serif;
  padding: 14px 0;
}
.search-input::placeholder {
  color: rgba(255,255,255,0.5);
}
.search-submit-btn {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  color: #fff;
  border: none;
  padding: 12px 28px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  transition: var(--transition);
}
.search-submit-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 20px rgba(23, 162, 220, 0.4);
}

/* Hint */
.search-hint {
  color: rgba(255,255,255,0.45);
  text-align: center;
  margin-top: 18px;
  font-size: 0.85rem;
}
.search-hint kbd {
  background: rgba(255,255,255,0.15);
  padding: 2px 8px;
  border-radius: 4px;
  font-size: 0.8rem;
}

/* Responsive */
@media (max-width: 767px) {
  .search-overlay { padding-top: 12vh; }
  .search-input { font-size: 1rem; }
  .search-submit-btn { padding: 10px 18px; font-size: 0.85rem; }
  .search-close-btn { top: 18px; right: 18px; }
}
</style>

<script>
(function() {
  var toggle = document.getElementById('searchToggleBtn');
  var overlay = document.getElementById('searchOverlay');
  var input = document.getElementById('globalSearchInput');

  function openSearch() {
    overlay.classList.add('open');
    setTimeout(function(){ input.focus(); }, 350);
    document.body.style.overflow = 'hidden';
  }
  function closeSearch() {
    overlay.classList.remove('open');
    document.body.style.overflow = '';
  }

  toggle.addEventListener('click', openSearch);

  overlay.addEventListener('click', function(e) {
    if (e.target === overlay) closeSearch();
  });

  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && overlay.classList.contains('open')) closeSearch();
  });
})();
</script>
