<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Search Results - Line Seiki Asia Pacific</title>

  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">

  <style>
/* ===============================
   VARIABLES
==================================*/
:root {
  --primary-blue: #0d6efd;
  --primary-blue-dark: #0a58ca;
  --primary-orange: #fd7e14;
  --primary-orange-dark: #e67300;
  --light-blue: #e7f1ff;
  --light-orange: #fff3e8;
  --light-gray: #f8f9fa;
  --dark: #212529;
  --newblue: #17A2DC;
  --newblue2: #0F467B;
  --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

/* ===============================
   BASE STYLES
==================================*/
* { box-sizing: border-box; }
html { scroll-behavior: smooth; }
body {
  background-color: #fff;
  color: #333;
  font-family: 'Inter', sans-serif;
  line-height: 1.6;
  overflow-x: hidden;
}
hr { background: rgba(255,255,255,0.1); height: 1px; }

/* ===============================
   NAVBAR
==================================*/
.navbar {
  background: rgba(255,255,255,0.98);
  backdrop-filter: blur(10px);
  padding: 1rem 0;
  transition: var(--transition);
  border-bottom: 1px solid rgba(13,110,253,0.1);
}
.navbar.scrolled { padding: 0.7rem 0; }
.navbar-brand img { height: 40px; width: auto; transition: var(--transition); }
.navbar-nav .nav-link {
  color: var(--dark); font-weight: 500; transition: var(--transition);
  position: relative; padding: 0.5rem 1rem; border-radius: 8px;
  margin: 0 0.2rem; font-size: 1rem;
}
.navbar-nav .nav-link:hover,
.navbar-nav .nav-link.active {
  color: var(--primary-blue);
  background: rgba(13,110,253,0.08);
}
.navbar-nav .nav-link::after {
  content: ''; position: absolute; width: 0; height: 2px; bottom: 0;
  left: 50%; background-color: var(--newblue); transition: var(--transition);
}
.navbar-nav .nav-link:hover::after { width: 70%; left: 15%; }

/* ===============================
   DROPDOWN
==================================*/
.dropdown-menu {
  background-color: rgba(255,255,255,0.98); backdrop-filter: blur(10px);
  border: 1px solid rgba(0,0,0,0.1); border-radius: 12px;
  padding: 0.8rem 0; margin-top: 0.8rem; animation: fadeIn 0.3s ease;
}
.dropdown-item { color: var(--dark); padding: 0.6rem 1.5rem; transition: var(--transition); font-size: 0.95rem; }
.dropdown-item:hover { background-color: var(--primary-blue); color: white; padding-left: 2rem; }
.dropdown-submenu { position: relative; }
.dropdown-submenu > .dropdown-menu { top: 0; left: 100%; margin-top: -0.8rem; }

/* ===============================
   SEARCH RESULTS PAGE
==================================*/
.search-hero {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  padding: 140px 0 60px;
  color: #fff;
  position: relative;
  overflow: hidden;
}
.search-hero::before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='1' fill='%23FFFFFF' opacity='0.05'/%3E%3C/svg%3E");
  pointer-events: none;
}
.search-hero h1 {
  font-size: 2.2rem;
  font-weight: 700;
  margin-bottom: 8px;
  color: #fff;
}
.search-hero p {
  font-size: 1.05rem;
  opacity: 0.8;
  margin: 0;
}

/* Inline Search Bar */
.search-bar-inline {
  max-width: 600px;
  margin: 28px auto 0;
}
.search-bar-inline .input-group {
  border-radius: 14px;
  overflow: hidden;
  box-shadow: 0 8px 30px rgba(0,0,0,0.15);
}
.search-bar-inline input {
  border: none;
  padding: 16px 22px;
  font-size: 1.05rem;
  font-family: 'Inter', sans-serif;
}
.search-bar-inline input:focus {
  box-shadow: none;
  outline: none;
}
.search-bar-inline .btn {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  border: none;
  padding: 16px 30px;
  font-weight: 600;
  color: #fff;
  transition: var(--transition);
}
.search-bar-inline .btn:hover {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
}

/* Results Section */
.search-results-section {
  padding: 50px 0 80px;
  min-height: 50vh;
}
.results-summary {
  font-size: 0.95rem;
  color: #6c757d;
  margin-bottom: 30px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e9ecef;
}
.results-summary strong {
  color: var(--dark);
}

/* Result Card */
.result-card {
  background: #fff;
  border: 1px solid #e9ecef;
  border-radius: 14px;
  padding: 24px 28px;
  margin-bottom: 16px;
  transition: var(--transition);
  text-decoration: none;
  display: block;
  color: inherit;
}
.result-card:hover {
  border-color: var(--newblue);
  box-shadow: 0 6px 24px rgba(23,162,220,0.12);
  transform: translateY(-2px);
  color: inherit;
  text-decoration: none;
}
.result-card .result-page {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--newblue2);
  margin-bottom: 6px;
  display: flex;
  align-items: center;
  gap: 8px;
}
.result-card .result-page i {
  font-size: 0.85rem;
  color: var(--newblue);
}
.result-card:hover .result-page {
  color: var(--newblue);
}
.result-card .result-snippet {
  color: #555;
  font-size: 0.95rem;
  line-height: 1.7;
  margin: 0;
}
.result-card .result-snippet mark {
  background: rgba(23,162,220,0.15);
  color: var(--newblue2);
  padding: 1px 4px;
  border-radius: 3px;
  font-weight: 600;
}
.result-card .result-url {
  font-size: 0.8rem;
  color: #adb5bd;
  margin-top: 8px;
  display: flex;
  align-items: center;
  gap: 5px;
}

/* No Results */
.no-results {
  text-align: center;
  padding: 80px 20px;
}
.no-results i {
  font-size: 4rem;
  color: #dee2e6;
  margin-bottom: 20px;
}
.no-results h3 {
  font-weight: 700;
  color: var(--dark);
  margin-bottom: 10px;
}
.no-results p {
  color: #6c757d;
  max-width: 420px;
  margin: 0 auto;
}

/* Pagination */
.search-pagination {
  display: flex;
  justify-content: center;
  gap: 6px;
  margin-top: 40px;
  flex-wrap: wrap;
}
.search-pagination a,
.search-pagination span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 42px;
  height: 42px;
  padding: 0 14px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 0.9rem;
  text-decoration: none;
  transition: var(--transition);
}
.search-pagination a {
  background: #f8f9fa;
  color: var(--dark);
  border: 1px solid #e9ecef;
}
.search-pagination a:hover {
  background: var(--newblue);
  color: #fff;
  border-color: var(--newblue);
  transform: translateY(-2px);
}
.search-pagination span.current {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  color: #fff;
  border: 1px solid transparent;
  box-shadow: 0 4px 12px rgba(23,162,220,0.3);
}
.search-pagination span.dots {
  background: none;
  border: none;
  color: #adb5bd;
}

@media (max-width: 767px) {
  .search-hero { padding: 120px 0 40px; }
  .search-hero h1 { font-size: 1.6rem; }
  .result-card { padding: 18px 20px; }
}
  </style>
</head>
<body>

<?php $this->load->view('web/header'); ?>

<!-- Search Hero -->
<section class="search-hero">
  <div class="container text-center">
    <h1><i class="fas fa-search"></i> Search Results</h1>
    <?php if (!empty($keyword)): ?>
      <p>Showing results for "<strong><?= htmlspecialchars($keyword) ?></strong>"</p>
    <?php endif; ?>

    <!-- Inline search bar to refine -->
    <div class="search-bar-inline">
      <form action="<?= base_url('index/search') ?>" method="get">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search again..." value="<?= htmlspecialchars($keyword) ?>">
          <button class="btn" type="submit"><i class="fas fa-search me-1"></i> Search</button>
        </div>
      </form>
    </div>
  </div>
</section>

<!-- Results -->
<section class="search-results-section">
  <div class="container" style="max-width: 820px;">

    <?php if (!empty($keyword)): ?>
      <div class="results-summary">
        Found <strong><?= $total ?></strong> result<?= $total !== 1 ? 's' : '' ?> for "<strong><?= htmlspecialchars($keyword) ?></strong>"
        <?php if ($total_pages > 1): ?>
          &mdash; Page <?= $current_page ?> of <?= $total_pages ?>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if (empty($keyword)): ?>
      <!-- No keyword entered -->
      <div class="no-results">
        <i class="fas fa-search"></i>
        <h3>Enter a search term</h3>
        <p>Type a keyword above to search across our products, services, news, library, and more.</p>
      </div>

    <?php elseif (empty($results)): ?>
      <!-- No results -->
      <div class="no-results">
        <i class="fas fa-exclamation-circle"></i>
        <h3>No results found</h3>
        <p>We couldn't find anything matching "<strong><?= htmlspecialchars($keyword) ?></strong>". Try a different keyword or browse our pages.</p>
      </div>

    <?php else: ?>
      <!-- Result cards -->
      <?php foreach ($results as $result): ?>
        <a href="<?= base_url($result['url']) ?>" class="result-card">
          <div class="result-page">
            <i class="fas fa-file-alt"></i>
            <?= htmlspecialchars($result['page_name']) ?>
          </div>
          <?php if (!empty($result['snippet'])): ?>
            <p class="result-snippet"><?= $result['snippet'] ?></p>
          <?php endif; ?>
          <div class="result-url">
            <i class="fas fa-link"></i>
            <?= base_url($result['url']) ?>
          </div>
        </a>
      <?php endforeach; ?>

      <!-- Pagination -->
      <?php if ($total_pages > 1): ?>
        <div class="search-pagination">
          <?php
            $q = urlencode($keyword);

            // Previous
            if ($current_page > 1): ?>
              <a href="<?= base_url('index/search?q=' . $q . '&page=' . ($current_page - 1)) ?>">
                <i class="fas fa-chevron-left"></i>
              </a>
            <?php endif;

            // Page numbers with smart range
            $range = 2;
            $start_page = max(1, $current_page - $range);
            $end_page = min($total_pages, $current_page + $range);

            if ($start_page > 1): ?>
              <a href="<?= base_url('index/search?q=' . $q . '&page=1') ?>">1</a>
              <?php if ($start_page > 2): ?>
                <span class="dots">...</span>
              <?php endif;
            endif;

            for ($i = $start_page; $i <= $end_page; $i++):
              if ($i == $current_page): ?>
                <span class="current"><?= $i ?></span>
              <?php else: ?>
                <a href="<?= base_url('index/search?q=' . $q . '&page=' . $i) ?>"><?= $i ?></a>
              <?php endif;
            endfor;

            if ($end_page < $total_pages):
              if ($end_page < $total_pages - 1): ?>
                <span class="dots">...</span>
              <?php endif; ?>
              <a href="<?= base_url('index/search?q=' . $q . '&page=' . $total_pages) ?>"><?= $total_pages ?></a>
            <?php endif;

            // Next
            if ($current_page < $total_pages): ?>
              <a href="<?= base_url('index/search?q=' . $q . '&page=' . ($current_page + 1)) ?>">
                <i class="fas fa-chevron-right"></i>
              </a>
            <?php endif; ?>
        </div>
      <?php endif; ?>

    <?php endif; ?>

  </div>
</section>

<?php $this->load->view('web/footer'); ?>

<script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>

<script>
document.addEventListener("DOMContentLoaded", function(){
  // Navbar scroll
  var navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) navbar.classList.add('scrolled');
    else navbar.classList.remove('scrolled');
  });

  // Submenu
  document.querySelectorAll('.dropdown-submenu > a').forEach(function(el){
    el.addEventListener('click', function(e){
      e.preventDefault(); e.stopPropagation();
      var sub = this.nextElementSibling;
      if(sub) sub.classList.toggle('show');
      this.closest('.dropdown-menu').querySelectorAll('.show').forEach(function(m){ if(m !== sub) m.classList.remove('show'); });
    });
  });
  document.addEventListener('click', function(){
    document.querySelectorAll('.dropdown-menu .show').forEach(function(m){ m.classList.remove('show'); });
  });
});
</script>
</body>
</html>
