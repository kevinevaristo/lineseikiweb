<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Line Seiki Asia Pacific Service</title>

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
      background-color: var(--newblue);
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

    /* Hero Slider */
    .section-one {
      width: 100%;
      height: 100vh;
    }
    
    .slider-container {
      width: 100%;
      height: 100vh;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
      transition: background-image 1s ease-in-out;
    }
    
    .slider-container.fade {
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }
    
    .slider-indicators {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 12px;
      z-index: 10;
    }
    
    .slider-indicators span {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      transition: var(--transition);
    }
    
    .slider-indicators span.active {
      background: var(--newblue);
    }
    
    .hero-content {
      position: absolute;
      top: 50%;
      left: 10%;
      transform: translateY(-50%);
      max-width: 600px;
      z-index: 5;
      color: white;
    }
    
    .hero-content h1 {
      font-size: 3.2rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 20px;
      color: white;
    }
    
    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      opacity: 0.9;
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
      box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
    }
    
    .btn-primary:hover {
      background: linear-gradient(135deg, var(--primary-blue-dark), var(--primary-blue));
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
    }
    
    .btn-orange {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border: none;
      color: white;
      box-shadow: 0 5px 15px rgba(253, 126, 20, 0.3);
    }
    
    .btn-orange:hover {
      background: linear-gradient(135deg, var(--newblue2), var(--));
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(253, 126, 20, 0.4);
      color: white;
    }
    
    .btn-explore {
      background: transparent;
      border: 2px solid var(--primary-blue);
      color: var(--primary-blue);
    }
    
    .btn-explore:hover {
      background: var(--primary-blue);
      color: #fff;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
    }
    
    .btn-link {
      text-decoration: none;
      position: relative;
    }
    
    .btn-link span {
      position: relative;
    }
    
    .btn-link span::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: currentColor;
      transition: var(--transition);
    }
    
    .btn-link:hover span::after {
      width: 100%;
    }

    
    /* Sections */
    section {
      padding: 100px 0;
      position: relative;
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
    
    section h1::after, section h2::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -10px;
      width: 60px;
      height: 4px;
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border-radius: 2px;
    }
    
    section p {
      margin-bottom: 28px;
      font-size: 1.1rem;
      color: #495057;
    }

    /* Color schemes */
    .section-white {
      background: var(--light-blue);
      color: #333;
    }
    
    .section-light-blue {
      background: var(--light-blue);
      color: #333;
      position: relative;
      overflow: hidden;
    }
    
    .section-light-orange {
      background: var(--newblue);
      color: #333;
      position: relative;
      overflow: hidden;
    }

    /* Products Section */
    .products {
      padding: 100px 5% 80px;
      text-align: center;
    }
    
    .products h1 {
      font-size: 2.5rem;
      margin-bottom: 40px;
      color: var(--primary-blue);
      font-weight: 700;
      position: relative;
    }
    
    .products h1::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border-radius: 2px;
    }
    
    .categories {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
    }
    
    /* Individual Product Cards */
.category {
  border-radius: 16px;
  overflow: hidden;
  cursor: pointer;
  background: #fff;
  transition: var(--transition);
  position: relative;
}

.category:hover {
  transform: translateY(-8px);
}

/* Product image styling */
.category img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  display: block;
  transition: opacity 0.4s ease;
}

/* Slight transparent effect on hover */
.category:hover img {
  opacity: 0.7;
}

/* Category title below image (no hover color) */
.category-title {
  padding: 15px 10px;
  background: transparent;
  color: var(--dark);
  font-size: 1.1rem;
  font-weight: 600;
  text-align: center;
  transition: none;
}

.category:hover .category-title {
  color: none;
}
    .overlay h3 {
      font-size: 1.4rem;
      margin-bottom: 12px;
      color: #fff;
    }
    
    .overlay p {
      font-size: 0.95rem;
      max-width: 250px;
    }

    /* Case Studies */
    .case-studies {
      padding: 80px 0;
    }
    
    .case-studies .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .case-studies h2 {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--primary-blue);
      margin-bottom: 15px;
      text-align: center;
      position: relative;
    }
    
    .case-studies h2::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border-radius: 2px;
    }
    
    .subtitle {
      font-size: 1.1rem;
      color: #495057;
      margin-bottom: 60px;
      text-align: center;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }
    
    .case-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 30px;
    }
    
    .case-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .case-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .case-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 3px solid var(--primary-blue);
    }
    
    .card-content {
      padding: 25px;
    }
    
    .card-content h3 {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--primary-blue);
    }
    
    .card-content p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .card-content a {
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--primary-blue);
      text-decoration: none;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
    }
    
    .card-content a:hover {
      color: var(--newblue);
    }
    
    .card-content a::after {
      content: '→';
      margin-left: 5px;
      transition: var(--transition);
    }
    
    .card-content a:hover::after {
      transform: translateX(3px);
    }

    /* News Section */
    .news-section {
      padding: 80px 5%;
      background: white;
    }
    
    .news-section h2 {
      text-align: center;
      margin-bottom: 50px;
      color: var(--primary-blue);
      position: relative;
    }
    
    .news-section h2::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border-radius: 2px;
    }
    
    .content-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .news-card {
      background-color: #fff;
      color: #333;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      text-align: left;
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .news-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .news-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      background: #ccc;
    }
    
    .news-card-content {
      padding: 25px;
    }
    
    .news-card-content h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--primary-blue);
    }
    
    .news-card-content p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .news-card-content a {
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--primary-blue);
      text-decoration: none;
      transition: var(--transition);
    }
    
    .news-card-content a:hover {
      color: var(--newblue);
    }

    /* Project Submission */
    .project-submission {
      padding: 100px 5%;
      background: var(--light-blue);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .project-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      padding: 40px;
      text-align: center;
      max-width: 450px;
      width: 100%;
      border: 1px solid rgba(13, 110, 253, 0.1);
      transition: var(--transition);
    }
    
    .project-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .project-card .icon {
      font-size: 3.5rem;
      color: var(--primary-blue);
      margin-bottom: 20px;
    }
    
    .project-card h4 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--primary-blue);
    }
    
    .project-card p {
      font-size: 1rem;
      color: #495057;
      margin-bottom: 30px;
    }
    
    .project-card .btn-outline-primary {
      border: 2px solid var(--primary-blue);
      color: var(--primary-blue);
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 500;
      transition: var(--transition);
    }
    
    .project-card .btn-outline-primary:hover {
      background: var(--primary-blue);
      color: white;
    }
    
    .project-card .file-name {
      font-size: 0.9rem;
      color: #6c757d;
      margin: 15px 0;
    }
    
    .project-card .btn-success {
      background: var(--newblue);
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-weight: 600;
      width: 100%;
      transition: var(--transition);
    }
    
    .project-card .btn-success:hover {
      background: var(--newblue2);
      transform: translateY(-2px);
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
      section {
        padding: 80px 0;
      }
      
      section h1 {
        font-size: 2.4rem;
      }
      
      section h2 {
        font-size: 2rem;
      }
      
      .hero-content h1 {
        font-size: 2.5rem;
      }
      
      .dropdown-submenu > .dropdown-menu {
        left: 0;
        margin-top: 0;
      }
      
      footer .links a {
        display: inline-block;
        margin-bottom: 12px;
      }
      
      .categories {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      }
      
      .case-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      }
    }
    
    @media (max-width: 768px) {
      section h1 {
        font-size: 2rem;
      }
      
      section h2 {
        font-size: 1.8rem;
      }
      
      .hero-content {
        left: 5%;
        text-align: center;
        width: 90%;
      }
      
      .hero-content h1 {
        font-size: 2rem;
      }
      
      footer .links a {
        display: block;
        margin-bottom: 12px;
      }
    }
    /* Remove all shadows globally */
* {
  box-shadow: none !important;
  text-shadow: none !important;
}
  </style>
</head>
<body>

 <!-- ✅ Fixed Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container-fluid">
    <!-- Logo on the LEFT -->
    <a class="navbar-brand" href="<?= base_url() ?>">
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
        <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index/about_us') ?>">About Us</a></li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            Product and Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('index/ps_prod') ?>">Products</a></li>

            <!-- Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle active" href="#">Services</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= base_url('index/ps_serv_simulation') ?>">Simulation Analysis</a></li>
                <li><a class="dropdown-item active" href="<?= base_url('index/ps_serv_silicone') ?>">Silicone Molding & Urethane Casting</a></li>
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

<!-- Offset for fixed navbar -->
<div style="margin-top:90px"></div>

<!-- ✅ Hero Slider Section -->
<div class="section-one"> 
  <div class="slider-container">
    <div class="hero-content fade-in">
      <h1>Silicone Molding and Urethane Casting</h1>
      <p>Overview of our low-volume prototyping service using silicone molds and urethane casting.</p>
    </div>
    <div class="slider-indicators"></div>
  </div>
</div>

<!-- ✅ Materials Section -->
<section class="products">
  <h1 class="fade-in">List of Materials</h1>
    <div class="categories">
  <div class="category fade-in delay-1">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/safetyswitches.jpg')?> alt="Safety Switches">
    </a>
    <div class="category-title">Safety Switches</div>
  </div>

  <div class="category fade-in delay-2">
    <a href="<?= base_url('index/electronic_counter_details') ?>">
    <img src=<?= base_url('assets_system/images/electroniccounter.jpg')?> alt="Electronic Counters">
    </a>
    <div class="category-title">Electronic Counters</div>
  </div>

  <div class="category fade-in delay-3">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/timer.jpg')?> alt="Timers">
    </a>
    <div class="category-title">Timers</div>
  </div>

  <div class="category fade-in delay-4">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/mechanicalcounter.jpg')?> alt="Mechanical Counters">
    </a>
    <div class="category-title">Mechanical Counters</div>
  </div>

  <div class="category fade-in delay-1">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/slidelimitnobg.png')?> alt="Slide Limit Counters">
    </a>
    <div class="category-title">Slide Limit Counters</div>
  </div>

  <div class="category fade-in delay-2">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/limitswitches.jpg')?> alt="Limit Switches">
    </a>
    <div class="category-title">Limit Switches</div>
  </div>

  <div class="category fade-in delay-3">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/countersensor.jpg')?> alt="Length Counters & Sensors">
    </a>
    <div class="category-title">Length Counters & Sensors</div>
  </div>

  <div class="category fade-in delay-4">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/rotary.jpg')?> alt="Rotary Encoders">
    </a>
    <div class="category-title">Rotary Encoders</div>
  </div>

  <div class="category fade-in delay-1">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/tachometer.jpg')?> alt="Tachometers">
    </a>
    <div class="category-title">Tachometers</div>
  </div>

  <div class="category fade-in delay-2">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/thermometers1.jpg')?> alt="Thermometers">
    </a>
    <div class="category-title">Thermometers</div>
  </div>

  <div class="category fade-in delay-3">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/measuring.jpg')?> alt="Measuring Instruments">
    </a>
    <div class="category-title">Measuring Instruments</div>
  </div>

  <div class="category fade-in delay-4">
    <a href="<?= base_url('index/products_details') ?>">
    <img src=<?= base_url('assets_system/images/tallycounter.png')?> alt="Tally Counters">
    </a>
    <div class="category-title">Tally Counters</div>
  </div>
</div>
  </div>
</section>

<!-- ✅ Technical Specs Section -->
<section class="case-studies section-white">
  <div class="container">
    <h2 class="fade-in">Technical Specs</h2><br>
    <div class="case-grid">
      <div class="case-card fade-in delay-1">
        <img src="<?= base_url('assets_system/images/simulation6.png') ?>" alt="Silicone">
        <div class="card-content">
          <h3>Silicone</h3>
          <p>Provides technical details such as maximum part size, minimum wall thickness, tolerances, and available post-processing options like over-molding and painting</p>
          <a href="<?= base_url('index/technical_specs') ?>">Read More</a>
        </div>
      </div>
      <div class="case-card fade-in delay-2">
        <img src="<?= base_url('assets_system/images/simulation5.png') ?>" alt="Urethane">
        <div class="card-content">
          <h3>Urethane</h3>
          <p>Provides technical details such as maximum part size, minimum wall thickness, tolerances, and available post-processing options like over-molding and painting</p>
          <a href="<?= base_url('index/technical_specs') ?>">Read More</a>
        </div>
      </div>
      <div class="case-card fade-in delay-3">
        <img src="<?= base_url('assets_system/images/simulation7.png') ?>" alt="Materials">
        <div class="card-content">
          <h3>Specialty Materials</h3>
          <p>Provides technical details such as maximum part size, minimum wall thickness, tolerances, and available post-processing options like over-molding and painting</p>
          <a href="<?= base_url('index/technical_specs') ?>">Read More</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ✅ Industry Section -->
<section class="news-section">
  <h2 class="fade-in">Industry</h2>
  <div class="content-container">
    <div class="news-card fade-in delay-1">
      <img src="https://placehold.co/400x200/cccccc/333333?text=Latest+News" alt="Latest news article.">
      <div class="news-card-content">
        <h3>Company Announcements</h3>
        <p>Stay up-to-date with our official announcements, product releases, and company news.</p>
        <a href="<?= base_url('index/technical_specs') ?>">Read more</a>
      </div>
    </div>
    <div class="news-card fade-in delay-2">
      <img src="https://placehold.co/400x200/cccccc/333333?text=Product+Launch" alt="New product launch.">
      <div class="news-card-content">
        <h3>New Product Launch</h3>
        <p>Discover our latest innovation designed to enhance efficiency and precision in your operations.</p>
        <a href="<?= base_url('index/technical_specs') ?>">Explore</a>
      </div>
    </div>
    <div class="news-card fade-in delay-3">
      <img src="https://placehold.co/400x200/cccccc/333333?text=Industry+Insights" alt="Industry insights.">
      <div class="news-card-content">
        <h3>Industry Insights</h3>
        <p>Read our latest articles and insights on industry trends and technological advancements.</p>
        <a href="<?= base_url('index/technical_specs') ?>">Learn more</a>
      </div>
    </div>
  </div>
</section>

<!-- ✅ Project Submission Section -->
<section class="project-submission">
  <div class="project-card fade-in">
    <div class="icon">
      <i class="fas fa-file-upload"></i>
    </div>
    <h4>Project Submission</h4>
    <p>Upload your CAD models or design drawings to receive a detailed quote.</p>
    <label for="file-upload" class="btn btn-outline-primary">
      <i class="fas fa-paperclip me-2"></i> Select File
    </label>
    <input id="file-upload" type="file" hidden>
    <div id="file-name" class="file-name">No file selected</div>
    <button class="btn btn-success">Request Quote</button>
  </div>
</section>

<!-- ✅ Footer -->
<footer>
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
    <h2>Get in Touch with Us</h2>
    <div>
      <a href="<?= base_url('index/contact_us') ?>" class="btn btn-orange">Contact</a>
      <a href="<?= base_url('index/contact_us') ?>" class="btn btn-light">Consult</a>
    </div>
  </div>
  <p>We're here to assist with your inquiries and needs.</p>
  <hr class="my-4">
  <div class="d-flex justify-content-between flex-wrap align-items-center">
    <img src="<?= base_url('assets_system/images/footer_logo.png') ?>" height="40" alt="Logo">
    <div class="links">
      <a href="<?= base_url() ?>">Home</a>
      <a href="<?= base_url('index/about_us') ?>">About Us</a>
      <a href="<?= base_url('index/ps_prod') ?>">Products</a>
      <a href="<?= base_url('index/ps_serv_simulation') ?>">Services</a>
      <a href="<?= base_url('index/ps_iotsolution') ?>">IoT Solution</a>
      <a href="<?= base_url('index/news_event') ?>">News and Events</a>
      <a href="<?= base_url('index/library') ?>">Library</a>
      <a href="<?= base_url('index/contact_us') ?>">Contact Us</a>
    </div>
    <div class="socials">
        <a href="https://www.facebook.com/lineseikiofficial"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.linkedin.com/company/line-seiki-co.-ltd./about/"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.youtube.com/@lineseikichannel7777"><i class="fab fa-youtube"></i></a>
      </div>
  </div>
  <div class="bottom mt-4">
    <span>© 2025 Line Seiki Asia Pacific. All rights reserved.</span>
    <a href="<?= base_url('index/privacy_policy') ?>">Privacy Policy</a>
    <a href="<?= base_url('index/termsof_service') ?>">Terms of Service</a>
    <a href="<?= base_url('index/cookies_setting')?>">Cookie Settings</a>
  </div>
</footer>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const sliderContainer = document.querySelector('.slider-container');
    const indicatorsContainer = document.querySelector('.slider-indicators');

    const images = [
        '<?= base_url('assets_system/images/siliconemolding7.jpg') ?>',
        '<?= base_url('assets_system/images/siliconemolding8.jpg') ?>',
        '<?= base_url('assets_system/images/siliconemolding9.jpg') ?>',
        '<?= base_url('assets_system/images/siliconemolding10.jpg') ?>',
    ];

    let currentIndex = 0;

    // Create dots dynamically
    images.forEach((_, index) => {
        const dot = document.createElement('span');
        if (index === 0) dot.classList.add('active');
        dot.addEventListener('click', () => {
            currentIndex = index;
            updateSlide();
        });
        indicatorsContainer.appendChild(dot);
    });

    function updateSlide() {
        sliderContainer.style.backgroundImage = `url('${images[currentIndex]}')`;
        document.querySelectorAll('.slider-indicators span').forEach((dot, idx) => {
            dot.classList.toggle('active', idx === currentIndex);
        });
    }

    function changeBackground() {
        currentIndex = (currentIndex + 1) % images.length;
        updateSlide();
    }

    // Initial setup
    updateSlide();

    // Auto change every 5 seconds
    setInterval(changeBackground, 5000);

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
    
    // File upload functionality
    document.getElementById('file-upload').addEventListener('change', function() {
      const fileName = this.files.length > 0 ? this.files[0].name : 'No file selected';
      document.getElementById('file-name').textContent = fileName;
    });
  });
</script>
</body>
</html>