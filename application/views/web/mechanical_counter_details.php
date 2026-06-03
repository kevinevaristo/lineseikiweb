<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Products - Line Seiki Asia Pacific</title>

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

    body {
      background-color: #fff;
      color: #333;
      font-family: 'Inter', sans-serif;
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Modernized Navbar */
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
      color: var(--dark);
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
    
    .navbar-nav .nav-link::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 50%;
      background-color: var(--newblue);
      transition: var(--transition);
    }
    
    .navbar-nav .nav-link:hover::after {
      width: 70%;
      left: 15%;
    }
    
    .dropdown-menu {
      background-color: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      padding: 0.8rem 0;
      margin-top: 0.8rem;
      animation: fadeIn 0.3s ease;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .dropdown-item {
      color: var(--dark);
      padding: 0.6rem 1.5rem;
      transition: var(--transition);
      position: relative;
    }
    
    .dropdown-item:hover {
      background-color: var(--primary-blue);
      color: white;
      padding-left: 2rem;
    }
    
    .navbar-brand img {
      height: 40px;
      width: auto;
      transition: var(--transition);
    }
    
    .dropdown-submenu {
      position: relative;
    }
    
    .dropdown-submenu > .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -0.8rem;
    }

    /* Sections */
    section {
      padding: 100px 0;
      position: relative;
    }
    
    section img {
      width: 100%;
      border-radius: 16px;
      transition: var(--transition);
      transform: translateY(0);
    }
    
    section img:hover {
      transform: translateY(-5px);
    }
    
    section h1, section h2 {
      margin-bottom: 24px;
      font-weight: 700;
      position: relative;
    }
    
    section h1 {
      font-size: 2.8rem;
      color: var(--primary-blue);
    }
    
    section h2 {
      font-size: 2.2rem;
      color: var(--primary-blue);
    }
    
    section p {
      margin-bottom: 28px;
      font-size: 1.1rem;
      color: #495057;
    }

    /* CTA Section */
    .cta {
      background: var(--light-blue);
      color: white;
      text-align: center;
      padding: 80px 10%;
    }
    
    .cta h1 {
      font-size: 2.2rem;
      margin-bottom: 20px;
      color: var(--primary-blue);
    }
    
    .cta p {
      margin-bottom: 30px;
      font-size: 1.1rem;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
      color: black
    }

    /* Buttons */
    .btn {
      padding: 0.8rem 1.8rem;
      border-radius: 8px;
      font-weight: 600;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    
    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 0%;
      height: 100%;
      background: rgba(255, 255, 255, 0.1);
      transition: var(--transition);
      z-index: -1;
    }
    
    .btn:hover::before {
      width: 100%;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
      border: none;
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-blue-dark), var(--primary-blue));
      transform: translateY(-3px);
    }
    
    .btn-orange {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border: none;
      color: white;
    }
    
    .btn-orange:hover {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2));
      transform: translateY(-3px);
      color: white;
    }
    
    .btn-light {
      background: rgba(255, 255, 255, 0.9);
      border: none;
      color: var(--primary-blue);
      border-color: #000;
    }
    
    .btn-light:hover {
      background: #fff;
      color: var(--primary-blue-dark);
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
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
    
    footer .links a::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: var(--newblue2);
      transition: var(--transition);
    }
    
    footer .links a:hover {
      color: white;
    }
    
    footer .links a:hover::after {
      width: 100%;
    }
    
    footer .socials a {
      color: white;
      margin-right: 18px;
      font-size: 1.3rem;
      transition: var(--transition);
      display: inline-block;
    }
    
    footer .socials a:hover {
      color: var(--newblue2);
      transform: translateY(-3px);
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
      color: var(--newblue2);
    }
    
    hr {
      background: rgba(255, 255, 255, 0.1);
      height: 1px;
    }
    
    /* Animations */
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .fade-in {
      opacity: 0;
      transform: translateY(30px);
      transition: opacity 0.8s ease, transform 0.8s ease;
    }
    
    .fade-in.visible {
      opacity: 1;
      transform: translateY(0);
    }
    
    .delay-1 { transition-delay: 0.1s; }
    .delay-2 { transition-delay: 0.2s; }
    .delay-3 { transition-delay: 0.3s; }
    .delay-4 { transition-delay: 0.4s; }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
      .products {
        padding: 100px 5% 60px;
      }
      
      .products h1 {
        font-size: 2.2rem;
      }
      
      .categories {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
      }
      
      footer .links a {
        display: inline-block;
        margin-bottom: 12px;
      }
    }
    
    @media (max-width: 768px) {
      .products h1 {
        font-size: 2rem;
      }
      
      .categories {
        grid-template-columns: 1fr;
        max-width: 400px;
        margin: 0 auto;
      }
      
      footer .links a {
        display: block;
        margin-bottom: 12px;
      }
    }

    /* Make INQUIRE button match Contact button */
    .cta .btn-light {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue)) !important;
      color: white !important;
      border: none !important;
    }

    .cta .btn-light:hover {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2)) !important;
      transform: translateY(-3px);
    }

    /* =========================
       🎯 MODERN PRODUCT DETAILS
    ========================= */
    
    /* Modern Top Details Section */
    .top-details {
    position: relative;
    padding: 180px 0;
    color: white;
    overflow: hidden;
    
    /* 1. Add Background Image */
    background: url("<?= base_url('assets_system/images/home_main.jpg') ?>") center center/cover no-repeat;
}
    .top-details::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FFFFFF' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      z-index: 1;
    }

    .top-details h1 {
      position: relative;
      z-index: 2;
      color: white;
      font-size: 3.5rem;
      font-weight: 800;
      letter-spacing: -0.5px;
      text-transform: uppercase;
      text-align: center;
    }

    /* Modern Product Details Section */
    .product-details {
      background: linear-gradient(135deg, var(--light-blue) 0%, #fff 100%);
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }

    .product-details::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2317A2DC' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      z-index: 0;
    }

    .product-details-container {
      position: relative;
      z-index: 1;
    }

    /* Modern Product Card */
    .product-card {
      background: #fff;
      border-radius: 20px;
      padding: 50px 40px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      border: none;
      position: relative;
      overflow: hidden;
    }

    .product-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
    }

    .product-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12);
    }

    .product-title {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--newblue2);
      margin-bottom: 20px;
      position: relative;
    }

    .product-title::after {
      content: '';
      position: absolute;
      bottom: -10px;
      left: 0;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
      border-radius: 2px;
    }

    .product-description {
      font-size: 1.1rem;
      line-height: 1.8;
      color: #495057;
      margin-bottom: 30px;
    }

    .product-features {
      background: var(--light-blue);
      border-radius: 15px;
      padding: 30px;
      margin: 30px 0;
    }

    .feature-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .feature-list li {
      padding: 12px 0;
      border-bottom: 1px solid rgba(13, 110, 253, 0.1);
      position: relative;
      padding-left: 30px;
      font-weight: 500;
      color: var(--newblue2);
    }

    .feature-list li:last-child {
      border-bottom: none;
    }

    .feature-list li::before {
      content: '✓';
      position: absolute;
      left: 0;
      color: var(--newblue);
      font-weight: bold;
    }

    /* Modern Product Image */
    .product-image-container {
      position: relative;
      text-align: center;
    }

    .product-image {
      max-width: 100%;
      height: auto;
      border-radius: 20px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      transition: var(--transition);
    }

    .product-image:hover {
      transform: scale(1.02);
    }

    .image-caption {
      margin-top: 20px;
      font-style: italic;
      color: #666;
      font-size: 0.9rem;
    }

    /* Modern Action Buttons */
    .action-buttons {
      margin-top: 40px;
    }

    .btn-inquiry {
      background: linear-gradient(135deg, var(--newblue), var(--primary-blue));
      color: white;
      border: none;
      padding: 15px 30px;
      border-radius: 10px;
      font-weight: 600;
      transition: var(--transition);
      box-shadow: 0 5px 15px rgba(23, 162, 220, 0.3);
    }

    .btn-inquiry:hover {
      background: linear-gradient(135deg, var(--primary-blue), var(--newblue));
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(23, 162, 220, 0.4);
      color: white;
    }

    .btn-inquiry i {
      margin-right: 8px;
    }

    /* Modern Divider */
    .modern-divider {
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--newblue), transparent);
      margin: 40px 0;
      border: none;
    }

    /* Responsive adjustments for product details */
    @media (max-width: 768px) {
      .top-details {
        padding: 120px 0;
      }
      
      .top-details h1 {
        font-size: 2.5rem;
      }
      
      .product-card {
        padding: 30px 25px;
      }
      
      .product-title {
        font-size: 2rem;
      }
    }

    /* === Mobile responsive enhancements (added) === */
    @media (max-width: 768px) {
      section,
      .product-details {
        padding: 60px 0;
      }
      .cta {
        padding: 60px 8%;
      }
      section h1 { font-size: 2rem; }
      section h2 { font-size: 1.6rem; }
      .cta h1 { font-size: 1.8rem; }
      .product-features { padding: 20px; }
      .product-image { max-width: 100%; height: auto; }
    }

    @media (max-width: 480px) {
      section,
      .product-details {
        padding: 48px 0;
      }
      .top-details {
        padding: 90px 0;
      }
      .top-details h1 { font-size: 1.9rem; }
      .product-card { padding: 24px 18px; }
      .product-title { font-size: 1.7rem; }
      .cta { padding: 48px 6%; }
      .cta h1 { font-size: 1.6rem; }
      section h1 { font-size: 1.8rem; }
      section h2 { font-size: 1.5rem; }
      .product-description,
      section p,
      .cta p { font-size: 1rem; }
    }
  </style>
</head>
<body>

  <!-- ✅ Fixed Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= base_url() ?>">
        <img src=<?= base_url('assets_system/images/header_logo.png') ?> alt="Line Seiki Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/about_us') ?>">About Us</a></li>

          <!-- Dropdown -->
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

  <!-- Spacer for fixed navbar -->
  <div style="height: 90px;"></div>

  <!-- Modern Top Details Section -->
  <section class="top-details">
    <div class="container">
      <h1 class="fade-in">Product Details</h1>
    </div>
  </section>

  <!-- Modern Product Details Section -->
  <section class="product-details">
    <div class="container product-details-container">
      <div class="product-card fade-in">
        <div class="row align-items-center">
          
          <!-- Left: Text Content -->
          <div class="col-lg-6 order-2 order-lg-1">
            <h2 class="product-title">Mechanical Counter</h2>
            
            <hr class="modern-divider">

            <!-- Product Description -->
            <div class="product-description">
              <p>
                Our Mechanical Counters require no power supply and count by sensing the rotation or tilt of a shaft through a combination of gears. 
Selectable from Ratchet, Revolution or Rotary/Direct Drive count methods, available with different sizes and mounting styles.
              </p>
              
              <div class="product-features">
                <h5 class="mb-3" style="color: var(--newblue2); font-weight: 600;">Key Features:</h5>
                <ul class="feature-list">
                  <li>No power needed</li>
                  <li>Multiple count methods</li>
                  <li>Durable gear-driven design</li>
                  <li>Flexible mounting options</li>
                </ul>
              </div>

              <div class="note-box p-3 rounded" style="background: rgba(253, 126, 20, 0.1); border-left: 4px solid var(--primary-orange);">
                <p class="mb-0" style="color: var(--primary-orange-dark); font-weight: 500;">
                  <strong>Note:</strong> We kindly ask our valued customers to evaluate Performance Level of entire system for the use of safety relay unit of third party.
                </p>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
              <a href="#" class="btn btn-inquiry">
                <i class="fas fa-envelope"></i> Send Inquiry
              </a>
            </div>
          </div>
          
          <!-- Right: Product Image -->
          <div class="col-lg-6 order-1 order-lg-2">
            <div class="product-image-container">
              <img src="<?= base_url('assets_system/images/mechanicalcounter.png')?>"
                alt="Safety Switches Product Image"
                class="product-image">
              <p class="image-caption">Advanced Mechanical Counters for Industrial Applications</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="cta">
    <h1 class="fade-in">Looking for the Right Measuring Solution?</h1>
    <p class="fade-in delay-1">Contact us today to discuss your requirements and find the perfect product for your needs.</p>
    <a href="<?= base_url('index/contact_us') ?>" class="btn btn-light fade-in delay-2">INQUIRE</a>
  </section>

  <!-- Footer -->
  <?php $this->load->view('footer'); ?>

  <!-- Bootstrap 5 JS -->
  <script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function(){
      // Navbar scroll effect
      const navbar = document.querySelector('.navbar');
      window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
      });
      
      // Fade-in animation on scroll
      const fadeElements = document.querySelectorAll('.fade-in');
      
      const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, { threshold: 0.15 });
      
      fadeElements.forEach(el => {
        fadeObserver.observe(el);
      });

      // Submenu functionality
      document.querySelectorAll('.dropdown-submenu > a').forEach(function(element){
        element.addEventListener('click', function(e){
          e.preventDefault();
          e.stopPropagation();

          let submenu = this.nextElementSibling;

          if(submenu){
            submenu.classList.toggle('show');
          }

          // close other open submenus
          this.closest('.dropdown-menu').querySelectorAll('.show').forEach(function(openMenu){
            if(openMenu !== submenu){
              openMenu.classList.remove('show');
            }
          });
        });
      });

      // close all on click outside
      document.addEventListener('click', function(){
        document.querySelectorAll('.dropdown-menu .show').forEach(function(openMenu){
          openMenu.classList.remove('show');
        });
      });
    });
  </script>
</body>
</html>