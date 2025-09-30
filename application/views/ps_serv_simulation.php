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
      
      border-bottom: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .navbar.scrolled {
      padding: 0.6rem 5%;
      
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
      color: #000;
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
    
    section h1::after, section h2::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -10px;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
      border-radius: 2px;
    }
    
    section h4, section h5 {
      color: var(--dark);
      margin-bottom: 15px;
    }
    
    section p {
      margin-bottom: 28px;
      font-size: 1.1rem;
      color: #495057;
    }

    /* Color schemes */
    .section-white {
      background: #fff;
      color: #333;
    }
    
    .section-light-blue {
      background: var(--light-blue);
      color: #333;
      position: relative;
      overflow: hidden;
    }
    
    .section-light-orange {
      background: var(--light-blue);
      color: #333;
      position: relative;
      overflow: hidden;
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
      background: linear-gradient(135deg, var(--newblue2), var(--));
      transform: translateY(-3px);
      
      color: white;
    }
    
    .btn-outline-blue {
      background: transparent;
      border: 2px solid var(--primary-blue);
      color: var(--primary-blue);
    }
    
    .btn-outline-blue:hover {
      background: var(--primary-blue);
      color: #fff;
      transform: translateY(-3px);
      
    }
    
    /* Types Grid */
    .container-one {
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }
    
    .container-one h2 {
      text-align: center;
      margin-bottom: 40px;
      color: var(--primary-blue);
      font-weight: 700;
      position: relative;
    }
    
    .container-one h2::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
      border-radius: 2px;
    }
    
    .types-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }
    
    .type-card {
      background: #fff;
      padding: 30px 25px;
      border-radius: 16px;
      
      transition: var(--transition);
      text-align: center;
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .type-card:hover {
      transform: translateY(-8px);
      
    }
    
    .type-card img {
      width: 80px;
      height: 80px;
      margin-bottom: 20px;
      object-fit: contain;
    }
    
    .type-card h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--primary-blue);
    }
    
    .type-card p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .type-card .see-more {
      display: inline-block;
      padding: 8px 20px;
      background: var(--primary-blue);
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: var(--transition);
    }
    
    .type-card .see-more:hover {
      background: var(--newblue);
      transform: translateY(-2px);
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
      background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
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
      
      transition: var(--transition);
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .case-card:hover {
      transform: translateY(-8px);
      
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
    
    /* Upload Section */
    .portal-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
    }
    
    .upload-section {
      background-color: #ffffff;
      border-radius: 16px;
      padding: 40px 30px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 450px;
      width: 100%;
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .icon-header {
      font-size: 3.5rem;
      color: var(--primary-blue);
      margin-bottom: 20px;
    }
    
    .upload-section h2 {
      font-size: 1.8rem;
      color: var(--primary-blue);
      margin-bottom: 15px;
      font-weight: 600;
    }
    
    .upload-section .description {
      font-size: 1rem;
      color: #495057;
      margin-bottom: 30px;
      line-height: 1.6;
    }
    
    .custom-file-upload {
      display: inline-block;
      background: var(--primary-blue);
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      cursor: pointer;
      transition: var(--transition);
      margin-bottom: 20px;
      font-weight: 500;
      border: none;
    }
    
    .custom-file-upload:hover {
      background: var(--primary-blue-dark);
      transform: translateY(-2px);
    }
    
    .selected-file-name {
      display: block;
      font-size: 0.9rem;
      color: #6c757d;
      margin-bottom: 30px;
    }
    
    .submit-project-btn {
      background: var(--newblue);
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 8px;
      font-size: 1.05rem;
      cursor: pointer;
      transition: var(--transition);
      width: 100%;
      font-weight: 600;
    }
    
    .submit-project-btn:hover {
      background: var(--newblue2);
      transform: translateY(-2px);
    }
    
    /* CTA Card */
    .cta-card {
      background: var(--newblue2);
      color: #fff;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      max-width: 600px;
      width: 100%;
      padding: 50px 40px;
      text-align: center;
      transition: var(--transition);
    }
    
    .cta-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }
    
    .cta-title {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 20px;
      color: #fff !important;
    }
    
    .cta-subtitle {
      font-size: 1.1rem;
      opacity: 0.9;
      margin-bottom: 40px;
      color: #fff !important;
      line-height: 1.6;
    }
    
    .cta-buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
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
      
      .dropdown-submenu > .dropdown-menu {
        left: 0;
        margin-top: 0;
      }
      
      footer .links a {
        display: inline-block;
        margin-bottom: 12px;
      }
      
      .types-grid {
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
      
      footer .links a {
        display: block;
        margin-bottom: 12px;
      }
      
      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .cta-buttons .btn {
        width: 100%;
        max-width: 250px;
      }
    }
    .cta-title::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: -15px;
  transform: translateX(-50%);
  width: 60px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
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
                <li><a class="dropdown-item active" href="<?= base_url('index/ps_serv_simulation') ?>">Simulation Analysis</a></li>
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

  <!-- Offset for fixed navbar -->
  <div style="margin-top:90px"></div>

  <!-- Section 1 (white) -->
  <section class="section-white">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 fade-in">
          <h1>Simulation Analysis Service</h1>
          <h4>Features</h4>
          <h5>
            <p>Advanced simulation technology<br>
            Utilizing the latest analysis algorithms and high-speed processing capabilities.</p>
            <p>High-precision analysis<br>
            Detailed and meticulous analysis for product design and process improvement</p>
            <p>Applicability across various industries<br>
            Usable in a wide range of fields, including automotive, aerospace, and electronics.</p>
            <p>Customizable analysis options<br>
            Analysis settings that can be adjusted to meet the needs of customers.</p>
          </h5>                                                       
        </div>
        <div class="col-lg-6 fade-in delay-1">
          <img src="<?= base_url('assets_system/images/simulation gif.gif') ?>" alt="Simulation Analysis">
        </div>
      </div>
    </div>
  </section>  

  <!-- Section 2 (light blue) -->
  <section class="section-light-blue">
    <div class="container-one">
      <h2 class="fade-in">Types of Simulation</h2>
      <div class="types-grid">
        <div class="type-card fade-in delay-1">
          <img src="<?= base_url('assets_system/images/simulation2.png') ?>" alt="Structural Simulation">
          <h3>Structural/Static Simulation (Nastran/Patran/Apex)</h3>
          <p>Evaluate the strength, stiffness, and stability of a component under various loads.</p>
          <a href="#" class="see-more">Learn more</a>
        </div>
        <div class="type-card fade-in delay-2">
          <img src="<?= base_url('assets_system/images/simulation3.png') ?>" alt="Fatigue Simulation">
          <h3>Fatigue Simulation (Nastran/Patran/Apex)</h3>
          <p>Analyze fluid flow, heat transfer, and related phenomena for optimal design.</p>
          <a href="#" class="see-more">Learn more</a>
        </div>
        <div class="type-card fade-in delay-3">
          <img src="<?= base_url('assets_system/images/simulation4.png') ?>" alt="Vibration Simulation">
          <h3>Vibration & Dynamics Simulation (Nastran/Patran/Apex)</h3>
          <p>Predict heat flow and temperature distribution to prevent thermal issues.</p>
          <a href="#" class="see-more">Learn more</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 3 (white) -->
  <section class="section-white">
    <div class="case-studies">
      <div class="container">
        <h2 class="fade-in">Case Studies</h2><br>
        <p class="subtitle fade-in delay-1">Real-world examples from past clients</p>

        <div class="case-grid">
          <!-- Case Study 1 -->
          <div class="case-card fade-in delay-1">
            <img src="<?= base_url('assets_system/images/simulation6.png') ?>" alt="Case Study 1">
            <div class="card-content">
              <h3>Cover Thermal Buckling Analysis</h3>
              <p>We helped an automotive company reduce drag by 12% using advanced CFD simulations.</p>
              <a href="#">Read More</a>
            </div>
          </div>

          <!-- Case Study 2 -->
          <div class="case-card fade-in delay-2">
            <img src="<?= base_url('assets_system/images/simulation5.png') ?>" alt="Case Study 2">
            <div class="card-content">
              <h3>Pinion Failure Analysis</h3>
              <p>FEA simulations helped reduce material costs while maintaining durability and strength.</p>
              <a href="#">Read More</a>
            </div>
          </div>

          <!-- Case Study 3 -->
          <div class="case-card fade-in delay-3">
            <img src="<?= base_url('assets_system/images/simulation7.png') ?>" alt="Case Study 3">
            <div class="card-content">
              <h3>Screw Boss Failure Analysis</h3>
              <p>Enhanced blade design increased energy output by 15% through simulation analysis.</p>
              <a href="#">Read More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 4 (light orange) -->
  <section class="section-light-orange">
    <div class="container-one">
      <div class="portal-wrapper">
        <div class="upload-section fade-in">
          <div class="icon-header">
            <i class="fas fa-file-upload"></i>
          </div>
          <h2>Project Submission</h2><br>
          <p class="description">Upload your CAD models or design drawings to receive a detailed quote.</p>
          <label for="file-upload" class="custom-file-upload">
            <i class="fas fa-paperclip"></i> Select File
          </label>
          <input id="file-upload" type="file" style="display: none;">
          <span id="file-name" class="selected-file-name">No file selected</span>
          <button class="submit-project-btn">Request Quote</button>
        </div>
      </div>
    </div>
  </section>

  <!-- Section 5 (white) -->
  <section class="section-white">
    <div class="container d-flex justify-content-center">
      <div class="cta-card fade-in">
        <h2 class="cta-title">Your Next Project Awaits</h2>
        <p class="cta-subtitle">
          Let's collaborate to create something truly exceptional.<br> Our team is ready to help you bring your vision to life.
        </p>
        <div class="cta-buttons">
          <a href="<?= base_url('index/contact_us') ?>" class="btn btn-orange">INQUIRE</a>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
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
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
        <a href="#"><i class="fab fa-x-twitter"></i></a>
        <a href="#"><i class="fab fa-linkedin-in"></i></a>
        <a href="#"><i class="fab fa-youtube"></i></a>
      </div>
    </div>
    <div class="bottom mt-4">
      <span>© 2025 Line Seiki Asia Pacific. All rights reserved.</span>
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Cookie Settings</a>
    </div>
  </footer>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
      
      // File upload functionality
      document.getElementById('file-upload').addEventListener('change', function() {
        const fileName = this.files.length > 0 ? this.files[0].name : 'No file selected';
        document.getElementById('file-name').textContent = fileName;
      });
    });
  </script>
</body>
</html>