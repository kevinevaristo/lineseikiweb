<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($item->product_name); ?> - Line Seiki Asia Pacific</title>

  <!-- Bootstrap 5 CSS -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">

  <!-- Google Fonts -->
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">

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

    /* Breadcrumb */
    .breadcrumb-section {
      background: white;
      padding: 20px 5%;
      margin-top: 80px;
      border-bottom: 1px solid #e0e0e0;
    }

    .breadcrumb-custom {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
    }

    .breadcrumb-custom a {
      color: var(--primary-blue);
      text-decoration: none;
      transition: var(--transition);
    }

    .breadcrumb-custom a:hover {
      opacity: 0.7;
    }

    .breadcrumb-custom span {
      color: #666;
    }

    /* Product Hero Section */
    .product-hero {
      background: white;
      padding: 60px 5%;
    }

    .product-container {
      max-width: 1400px;
      margin: 0 auto;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 60px;
      align-items: start;
    }

    .product-image-section {
      position: sticky;
      top: 100px;
    }

    .product-image-card {
      background: #f8f9fa;
      border-radius: 16px;
      padding: 40px;
      text-align: center;
    }

    .product-image-card img {
      max-width: 100%;
      max-height: 400px;
      object-fit: contain;
    }

    .product-info-section h1 {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--newblue2);
      margin-bottom: 15px;
    }

    .product-subtitle {
      font-size: 1.2rem;
      color: #666;
      margin-bottom: 20px;
    }

    .product-type-badge {
      display: inline-block;
      background: rgba(13, 110, 253, 0.1);
      color: var(--primary-blue);
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 0.9rem;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .product-description {
      color: #495057;
      font-size: 1.05rem;
      line-height: 1.8;
      margin-bottom: 30px;
    }

    .btn-back {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
    }

    .btn-back:hover {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2));
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(15, 70, 123, 0.3);
      color: white;
    }

    /* Content Section */
    .content-section {
      background: white;
      padding: 60px 5%;
    }

    .content-wrapper {
      max-width: 1400px;
      margin: 0 auto;
    }

    .section-title {
      font-size: 2rem;
      font-weight: 700;
      color: var(--newblue2);
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 3px solid var(--primary-blue);
    }

    /* Related Products */
    .related-products {
      background: #f8f9fa;
      padding: 80px 5%;
    }

    .related-title {
      text-align: center;
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--newblue2);
      margin-bottom: 50px;
    }

    .products-grid {
      max-width: 1400px;
      margin: 0 auto;
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

    .product-desc {
      color: #666;
      font-size: 0.95rem;
      line-height: 1.6;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }

    /* CTA Section */
    .cta-section {
      background: #e7f1ff;
      text-align: center;
      padding: 80px 5%;
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

    .btn-primary {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border: none;
      color: white;
      padding: 14px 32px;
      border-radius: 8px;
      font-weight: 600;
      transition: var(--transition);
      text-decoration: none;
      display: inline-block;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2));
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(15, 70, 123, 0.3);
      color: white;
    }

    /* Footer */
    footer {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      color: white;
      padding: 80px 10% 40px;
    }
    
    footer h2 {
      color: white;
      font-weight: 700;
    }
    
    footer .links a {
      color: #fff;
      text-decoration: none;
      margin-right: 24px;
      font-weight: 500;
      transition: var(--transition);
    }
    
    footer .links a:hover {
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
      .product-container {
        grid-template-columns: 1fr;
        gap: 40px;
      }

      .product-image-section {
        position: relative;
        top: 0;
      }

      .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
      }
    }

    @media (max-width: 768px) {
      .product-info-section h1 {
        font-size: 2rem;
      }

      .products-grid {
        grid-template-columns: 1fr;
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

  <!-- Breadcrumb -->
  <div class="breadcrumb-section">
    <div class="breadcrumb-custom">
      <a href="<?= base_url() ?>"><i class="fas fa-home"></i> Home</a>
      <span>/</span>
      <a href="<?= base_url('index/ps_prod') ?>">Products</a>
      <span>/</span>
      <a href="<?= base_url('index/category_products/' . $category->id) ?>"><?php echo htmlspecialchars($category->category_name); ?></a>
      <span>/</span>
      <span><?php echo htmlspecialchars($item->product_name); ?></span>
    </div>
  </div>

  <!-- Product Hero -->
  <section class="product-hero">
    <div class="product-container">
      <!-- Product Image -->
      <div class="product-image-section">
        <div class="product-image-card">
          <?php if (!empty($item->product_image)): ?>
            <img src="<?php echo base_url('assets_system/images/' . $item->product_image); ?>" 
                 alt="<?php echo htmlspecialchars($item->product_name); ?>">
          <?php else: ?>
            <i class="fas fa-box" style="font-size: 8rem; color: #ccc;"></i>
          <?php endif; ?>
        </div>
      </div>

      <!-- Product Info -->
      <div class="product-info-section">
        <?php if (!empty($item->type_name)): ?>
          <div class="product-type-badge"><?php echo htmlspecialchars($item->type_name); ?></div>
        <?php endif; ?>
        
        <h1><?php echo htmlspecialchars($item->product_name); ?></h1>
        
        <?php if (!empty($item->description)): ?>
          <div class="product-description">
            <?php echo nl2br(htmlspecialchars($item->description)); ?>
          </div>
        <?php endif; ?>

        <a href="<?php echo base_url('index/category_products/' . $category->id); ?>" class="btn-back">
          <i class="fas fa-arrow-left"></i>
          Back to <?php echo htmlspecialchars($category->category_name); ?>
        </a>
      </div>
    </div>
  </section>

  <!-- Related Products -->
  <?php if (!empty($related_items)): ?>
  <section class="related-products">
    <h2 class="related-title">Related Products</h2>
    <div class="products-grid">
      <?php foreach ($related_items as $related): ?>
        <a href="<?php echo base_url('index/product_detail/' . $category->id . '/' . $related->id); ?>" class="product-card-link">
          <div class="product-card">
            <div class="product-image <?php echo empty($related->product_image) ? 'no-image' : ''; ?>">
              <?php if (!empty($related->product_image)): ?>
                <img src="<?php echo base_url('assets_system/images/' . $related->product_image); ?>" 
                     alt="<?php echo htmlspecialchars($related->product_name); ?>">
              <?php else: ?>
                <i class="fas fa-box"></i>
              <?php endif; ?>
            </div>
            <div class="product-info">
              <h3 class="product-name"><?php echo htmlspecialchars($related->product_name); ?></h3>
              <?php if (!empty($related->description)): ?>
                <p class="product-desc"><?php echo htmlspecialchars($related->description); ?></p>
              <?php endif; ?>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </section>
  <?php endif; ?>

  <!-- CTA Section -->
  <section class="cta-section">
    <h2>Need More Information?</h2>
    <p>Contact us today to discuss your requirements and find the perfect solution for your needs.</p>
    <a href="<?php echo base_url('index/contact_us'); ?>" class="btn-primary">
      <i class="fas fa-envelope"></i> Contact Us
    </a>
  </section>

  <!-- Footer -->
  <?php $this->load->view('web/footer'); ?>

  <!-- Bootstrap 5 JS -->
  <script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>

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
