<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($category->category_name); ?> - Line Seiki Asia Pacific</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary-blue: #0d6efd;
      --primary-blue-dark: #0a58ca;
      --newblue: #17A2DC;
      --newblue2: #0F467B;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    body {
      background-color: #f8f9fa;
      color: #333;
      font-family: 'Inter', sans-serif;
      line-height: 1.6;
      overflow-x: hidden;
    }

    html {
      scroll-behavior: smooth;
    }

    /* Navbar */
    .navbar {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      padding: 0.8rem 5%;
      transition: var(--transition);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
      border-bottom: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .navbar.scrolled {
      padding: 0.6rem 5%;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .navbar-nav .nav-link {
      color: #212529;
      font-weight: 500;
      transition: var(--transition);
      position: relative;
      padding: 0.5rem 0.8rem;
      border-radius: 8px;
      margin: 0 0.1rem;
    }
    
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--primary-blue);
      background: rgba(13, 110, 253, 0.08);
    }
    
    .navbar-brand img {
      height: 40px;
      width: auto;
      transition: var(--transition);
    }
    
    .dropdown-menu {
      background-color: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      padding: 0.8rem 0;
      margin-top: 0.8rem;
    }
    
    .dropdown-item {
      color: #212529;
      padding: 0.6rem 1.5rem;
      transition: var(--transition);
    }
    
    .dropdown-item:hover {
      background-color: var(--primary-blue);
      color: white;
      padding-left: 2rem;
    }
    
    .dropdown-submenu {
      position: relative;
    }
    
    .dropdown-submenu > .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -0.8rem;
    }

    /* Hero Section */
    .category-hero {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      padding: 140px 5% 80px;
      text-align: center;
      color: white;
      position: relative;
      overflow: hidden;
    }

    .category-hero::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='1' fill='%23FFFFFF' opacity='0.05'/%3E%3C/svg%3E");
      pointer-events: none;
    }

    .category-hero h1 {
      font-size: 3rem;
      font-weight: 700;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .category-hero p {
      font-size: 1.2rem;
      max-width: 700px;
      margin: 0 auto 30px;
      opacity: 0.9;
      position: relative;
      z-index: 1;
    }

    .breadcrumb-custom {
      background: rgba(255, 255, 255, 0.1);
      padding: 12px 24px;
      border-radius: 50px;
      display: inline-flex;
      align-items: center;
      gap: 12px;
      position: relative;
      z-index: 1;
    }

    .breadcrumb-custom a {
      color: white;
      text-decoration: none;
      transition: var(--transition);
    }

    .breadcrumb-custom a:hover {
      opacity: 0.8;
    }

    .breadcrumb-custom span {
      opacity: 0.6;
    }

    /* Main Content */
    .content-section {
      padding: 80px 5%;
      max-width: 1400px;
      margin: 0 auto;
    }

    /* Type Filter Tabs */
    .type-filters {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin-bottom: 40px;
      justify-content: center;
    }

    .type-filter-btn {
      padding: 12px 24px;
      border: 2px solid #e0e0e0;
      background: white;
      border-radius: 50px;
      font-weight: 600;
      cursor: pointer;
      transition: var(--transition);
      color: #666;
    }

    .type-filter-btn:hover,
    .type-filter-btn.active {
      background: var(--primary-blue);
      border-color: var(--primary-blue);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .type-filter-btn .count {
      display: inline-block;
      background: rgba(0, 0, 0, 0.1);
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 0.85rem;
      margin-left: 8px;
    }

    .type-filter-btn.active .count {
      background: rgba(255, 255, 255, 0.2);
    }

    /* Type Sections */
    .type-section {
      margin-bottom: 60px;
      display: none;
    }

    .type-section.active {
      display: block;
      animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .type-header {
      display: flex;
      align-items: center;
      gap: 15px;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 3px solid var(--primary-blue);
    }

    .type-header h2 {
      font-size: 2rem;
      font-weight: 700;
      color: var(--newblue2);
      margin: 0;
    }

    .type-header .count-badge {
      background: var(--primary-blue);
      color: white;
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 600;
    }

    /* Products Grid */
    .products-grid {
      margin-bottom: 50px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 30px;
    }

    .product-card-link {
      text-decoration: none;
      color: inherit;
      display: block;
    }

    .product-card {
      background: white;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      cursor: pointer;
    }

    .product-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }

    .product-image {
      width: 100%;
      height: 240px;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      position: relative;
    }

    .product-image img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
      padding: 20px;
      transition: var(--transition);
    }

    .product-card:hover .product-image img {
      transform: scale(1.05);
    }

    .product-image.no-image {
      background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
    }

    .product-image.no-image i {
      font-size: 4rem;
      color: #ccc;
    }

    .product-info {
      padding: 20px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }

    .product-name {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--newblue2);
      margin-bottom: 12px;
    }

    .product-description {
      color: #666;
      font-size: 0.95rem;
      line-height: 1.6;
      margin-bottom: 15px;
      flex-grow: 1;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    .product-type-badge {
      display: inline-block;
      background: rgba(13, 110, 253, 0.1);
      color: var(--primary-blue);
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 12px;
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: 80px 20px;
      color: #999;
    }

    .empty-state i {
      font-size: 5rem;
      margin-bottom: 20px;
      opacity: 0.5;
    }

    .empty-state h3 {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: #666;
    }

    .empty-state p {
      color: #999;
    }

    /* CTA Section */
    .cta-section {
      background: #e7f1ff;
      text-align: center;
      padding: 80px 5%;
      margin-top: 60px;
    }
    
    .cta-section h2 {
      font-size: 2.2rem;
      margin-bottom: 20px;
      color: var(--primary-blue);
      font-weight: 700;
    }
    
    .cta-section p {
      margin-bottom: 30px;
      font-size: 1.1rem;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
      color: #333;
    }

    .btn {
      padding: 0.8rem 1.8rem;
      border-radius: 8px;
      font-weight: 600;
      transition: var(--transition);
      text-decoration: none;
      display: inline-block;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border: none;
      color: white;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2));
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(15, 70, 123, 0.3);
      color: white;
    }

    .btn-outline {
      background: white;
      border: 2px solid var(--primary-blue);
      color: var(--primary-blue);
    }
    
    .btn-outline:hover {
      background: var(--primary-blue);
      color: white;
      transform: translateY(-3px);
    }

    /* Footer */
    footer {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      color: white;
      padding: 80px 10% 40px;
      position: relative;
      overflow: hidden;
    }
    
    footer::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='1' fill='%23FFFFFF' opacity='0.05'/%3E%3C/svg%3E");
      pointer-events: none;
    }
    
    footer h2 {
      color: white;
      font-weight: 700;
    }
    
    footer .links a {
      color: #fff;
      text-decoration: none;
      margin-right: 24px;
      position: relative;
      font-weight: 500;
      transition: var(--transition);
    }
    
    footer .links a:hover {
      color: white;
      opacity: 0.8;
    }
    
    footer .socials a {
      color: white;
      margin-right: 18px;
      font-size: 1.3rem;
      transition: var(--transition);
      display: inline-block;
    }
    
    footer .socials a:hover {
      transform: translateY(-3px);
      opacity: 0.8;
    }

    footer .bottom {
      margin-top: 40px;
      font-size: 0.85rem;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 24px;
    }
    
    footer .bottom a {
      color: #ccc;
      text-decoration: none;
      transition: var(--transition);
    }
    
    footer .bottom a:hover {
      color: white;
    }

    /* Responsive */
    @media (max-width: 992px) {
      .category-hero h1 {
        font-size: 2.5rem;
      }

      .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
      }

      .type-header h2 {
        font-size: 1.6rem;
      }
    }

    @media (max-width: 768px) {
      .category-hero {
        padding: 120px 5% 60px;
      }

      .category-hero h1 {
        font-size: 2rem;
      }

      .products-grid {
        grid-template-columns: 1fr;
      }

      .type-filters {
        justify-content: flex-start;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= base_url() ?>">
        <img src="<?= base_url('assets_system/images/header_logo.png') ?>" alt="Line Seiki Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/about_us') ?>">About Us</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
              Product and Services
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item active" href="<?= base_url('index/ps_prod') ?>">Products</a></li>
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">Services</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="<?= base_url('index/ps_serv_simulation') ?>">Simulation Analysis</a></li>
                  <li><a class="dropdown-item" href="<?= base_url('index/ps_serv_silicone') ?>">Silicone Molding & Urethane Casting</a></li>
                </ul>
              </li>
              <li><a class="dropdown-item" href="<?= base_url('index/ps_iotsolution') ?>">IoT Solution</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/news_event') ?>">News and Events</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/library') ?>">Library</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="category-hero">
    <div class="breadcrumb-custom">
      <a href="<?= base_url() ?>">Home</a>
      <span>/</span>
      <a href="<?= base_url('index/ps_prod') ?>">Products</a>
      <span>/</span>
      <span><?php echo htmlspecialchars($category->category_name); ?></span>
    </div>
    <h1><?php echo htmlspecialchars($category->category_name); ?></h1>
    <p>Explore our comprehensive range of <?php echo htmlspecialchars($category->category_name); ?> products</p>
  </section>

  <!-- Main Content -->
  <section class="content-section">
    <?php if (!empty($types) && count(array_filter($types, function($t) { return $t->item_count > 0; })) > 0): ?>
      
      <!-- Type Filter Tabs -->
      <div class="type-filters">
        <button class="type-filter-btn active" data-type="all">
          All Products
          <span class="count"><?php echo array_sum(array_column($types, 'item_count')); ?></span>
        </button>
        <?php foreach ($types as $type): ?>
          <?php if ($type->item_count > 0): ?>
            <button class="type-filter-btn" data-type="<?php echo $type->id; ?>">
              <?php echo htmlspecialchars($type->type_name); ?>
              <span class="count"><?php echo $type->item_count; ?></span>
            </button>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

      <!-- Product Sections -->
      <div id="all-products" class="type-section active">
        <?php foreach ($types as $type): ?>
          <?php if ($type->item_count > 0 && isset($items_by_type[$type->id])): ?>
            <div class="type-header">
              <h2><?php echo htmlspecialchars($type->type_name); ?></h2>
              <span class="count-badge"><?php echo count($items_by_type[$type->id]); ?> Products</span>
            </div>
            <div class="products-grid">
              <?php foreach ($items_by_type[$type->id] as $item): ?>
                <a href="<?php echo base_url('index/product/' . $item->slug); ?>" class="product-card-link">
                <div class="product-card">
                  <div class="product-image <?php echo empty($item->product_image) ? 'no-image' : ''; ?>">
                    <?php if (!empty($item->product_image)): ?>
                      <img src="<?php echo base_url('assets_system/images/' . $item->product_image); ?>" 
                           alt="<?php echo htmlspecialchars($item->product_name); ?>"
                           onerror="this.parentElement.innerHTML='<i class=\'fas fa-box\'></i>'">
                    <?php else: ?>
                      <i class="fas fa-box"></i>
                    <?php endif; ?>
                  </div>
                  <div class="product-info">
                    <div class="product-type-badge"><?php echo htmlspecialchars($type->type_name); ?></div>
                    <h3 class="product-name"><?php echo htmlspecialchars($item->product_name); ?></h3>
                    <?php if (!empty($item->description)): ?>
                      <p class="product-description"><?php echo htmlspecialchars($item->description); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
                </a>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>

      <!-- Individual Type Sections -->
      <?php foreach ($types as $type): ?>
        <?php if ($type->item_count > 0 && isset($items_by_type[$type->id])): ?>
          <div id="type-<?php echo $type->id; ?>" class="type-section">
            <div class="type-header">
              <h2><?php echo htmlspecialchars($type->type_name); ?></h2>
              <span class="count-badge"><?php echo count($items_by_type[$type->id]); ?> Products</span>
            </div>
            <div class="products-grid">
              <?php foreach ($items_by_type[$type->id] as $item): ?>
                <a href="<?php echo base_url('index/product_detail/' . $category->id . '/' . $item->id); ?>" class="product-card-link">
                <div class="product-card">
                  <div class="product-image <?php echo empty($item->product_image) ? 'no-image' : ''; ?>">
                    <?php if (!empty($item->product_image)): ?>
                      <img src="<?php echo base_url('assets_system/images/' . $item->product_image); ?>" 
                           alt="<?php echo htmlspecialchars($item->product_name); ?>"
                           onerror="this.parentElement.innerHTML='<i class=\'fas fa-box\'></i>'">
                    <?php else: ?>
                      <i class="fas fa-box"></i>
                    <?php endif; ?>
                  </div>
                  <div class="product-info">
                    <div class="product-type-badge"><?php echo htmlspecialchars($type->type_name); ?></div>
                    <h3 class="product-name"><?php echo htmlspecialchars($item->product_name); ?></h3>
                    <?php if (!empty($item->description)): ?>
                      <p class="product-description"><?php echo htmlspecialchars($item->description); ?></p>
                    <?php endif; ?>
                  </div>
                </div>
                </a>
              <?php endforeach; ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>

    <?php else: ?>
      <!-- Empty State -->
      <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <h3>No Products Available</h3>
        <p>Products for this category are coming soon. Please check back later.</p>
        <a href="<?= base_url('index/ps_prod') ?>" class="btn btn-primary" style="margin-top: 20px;">
          <i class="fas fa-arrow-left"></i> Back to All Categories
        </a>
      </div>
    <?php endif; ?>
  </section>

  <!-- CTA Section -->
  <section class="cta-section">
    <h2>Need Help Finding the Right Product?</h2>
    <p>Our team is ready to assist you in selecting the perfect solution for your specific requirements.</p>
    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
      <a href="<?php echo base_url('index/contact_us'); ?>" class="btn btn-primary">
        <i class="fas fa-envelope"></i> Contact Us
      </a>
      <a href="<?php echo base_url('index/ps_prod'); ?>" class="btn btn-outline">
        <i class="fas fa-th"></i> Browse All Categories
      </a>
    </div>
  </section>

  <!-- Footer -->
  <?php $this->load->view('web/footer'); ?>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Navbar scroll effect
      const navbar = document.querySelector('.navbar');
      window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      });

      // Type filter functionality
      const filterBtns = document.querySelectorAll('.type-filter-btn');
      const typeSections = document.querySelectorAll('.type-section');

      filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
          const typeId = this.dataset.type;

          // Update active button
          filterBtns.forEach(b => b.classList.remove('active'));
          this.classList.add('active');

          // Show/hide sections
          typeSections.forEach(section => {
            section.classList.remove('active');
          });

          if (typeId === 'all') {
            document.getElementById('all-products').classList.add('active');
          } else {
            document.getElementById('type-' + typeId).classList.add('active');
          }

          // Smooth scroll to content
          document.querySelector('.content-section').scrollIntoView({ 
            behavior: 'smooth',
            block: 'start'
          });
        });
      });

      // Submenu functionality
      document.querySelectorAll('.dropdown-submenu > a').forEach(function(element) {
        element.addEventListener('click', function(e) {
          e.preventDefault();
          e.stopPropagation();

          let submenu = this.nextElementSibling;
          if (submenu) {
            submenu.classList.toggle('show');
          }

          this.closest('.dropdown-menu').querySelectorAll('.show').forEach(function(openMenu) {
            if (openMenu !== submenu) {
              openMenu.classList.remove('show');
            }
          });
        });
      });

      // Close dropdowns on outside click
      document.addEventListener('click', function() {
        document.querySelectorAll('.dropdown-menu .show').forEach(function(openMenu) {
          openMenu.classList.remove('show');
        });
      });
    });
  </script>
</body>
</html>
