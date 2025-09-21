<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Line Seiki Asia Pacific</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #0d6efd; /* Bootstrap primary blue */
      --primary-light: #3d8bfd;
      --secondary: #6c757d;
      --accent: #ffb74d;  /* Modern orange */
      --light-bg: #f9fafb;
      --dark-text: #212529;
      --gray-text: #6c757d;
      --transition: all 0.3s ease;
    }

    body {
      font-family: 'Inter', sans-serif;
      color: var(--dark-text);
      background-color: #fff;
      line-height: 1.6;
    }

    /* Navbar */
    .navbar {
      background: #fff;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      padding: 0.8rem 5%;
      transition: var(--transition);
    }
    .navbar.scrolled {
      padding: 0.5rem 5%;
      box-shadow: 0 3px 15px rgba(0,0,0,0.08);
    }
    .navbar-brand img {
      height: 36px;
    }
    .navbar-nav .nav-link {
      color: var(--dark-text);
      font-weight: 500;
      margin: 0 .3rem;
      transition: var(--transition);
    }
    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--primary);
    }

    /* Sections */
    section {
      padding: 80px 0;
    }
    section h1, section h2 {
      font-weight: 700;
      margin-bottom: 20px;
    }
    section p {
      font-size: 1.05rem;
      color: var(--gray-text);
    }

    .section-light {
      background: var(--light-bg);
    }
    .section-white {
      background: #fff;
    }

    section img {
      border-radius: 12px;
      width: 100%;
      box-shadow: 0 10px 20px rgba(0,0,0,0.08);
      transition: var(--transition);
    }
    section img:hover {
      transform: translateY(-4px);
    }

    /* Buttons */
    .btn {
      border-radius: 8px;
      font-weight: 600;
      padding: 0.6rem 1.4rem;
      transition: var(--transition);
    }
    .btn-primary {
      background: var(--primary);
      border: none;
    }
    .btn-primary:hover {
      background: var(--primary-light);
    }
    .btn-outline-primary {
      border: 2px solid var(--primary);
      color: var(--primary);
    }
    .btn-outline-primary:hover {
      background: var(--primary);
      color: #fff;
    }

    /* Footer */
    footer {
      background: var(--light-bg);
      padding: 50px 10% 30px;
      color: var(--dark-text);
    }
    footer h5 {
      font-weight: 700;
      margin-bottom: 15px;
      color: var(--primary);
    }
    footer a {
      color: var(--dark-text);
      text-decoration: none;
      margin-right: 15px;
      font-weight: 500;
    }
    footer a:hover {
      color: var(--primary);
    }
    footer .socials a {
      color: var(--dark-text);
      margin-right: 15px;
      font-size: 1.2rem;
    }
    footer .socials a:hover {
      color: var(--primary);
    }
    footer .bottom {
      border-top: 1px solid #e9ecef;
      padding-top: 15px;
      margin-top: 20px;
      font-size: 0.9rem;
      color: var(--gray-text);
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
    }

    /* Mobile adjustments */
    @media (max-width: 768px) {
      section {
        padding: 60px 0;
      }
      section h1 {
        font-size: 2rem;
      }
      .navbar-nav {
        background: #fff;
        padding: 1rem;
        border-radius: 8px;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="<?= base_url('assets_system/images/header_logo.png') ?>" alt="Line Seiki Logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
      data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" 
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link active" href="<?= base_url() ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index/about_us') ?>">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index/news_event') ?>">News</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index/library') ?>">Library</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index/contact_us') ?>">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Offset -->
<div style="margin-top:80px"></div>

<!-- Section 1 -->
<section class="section-white">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <h1>Innovative Solutions for Precision Measurement</h1>
        <p>We specialize in high-quality measuring instruments and smart monitoring systems tailored to your needs.</p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="#" class="btn btn-primary">Learn More</a>
          <a href="#" class="btn btn-outline-primary">Contact</a>
        </div>
      </div>
      <div class="col-lg-6">
        <img src="<?= base_url('assets_system/images/home_main.jpg') ?>" alt="Section 1">
      </div>
    </div>
  </div>
</section>

<!-- Section 2 -->
<section class="section-light">
  <div class="container">
    <div class="row align-items-center flex-row-reverse g-4">
      <div class="col-lg-6">
        <h2>Explore Our Measuring Counters</h2>
        <p>Accurate and reliable counters for diverse industrial applications.</p>
        <a href="#" class="btn btn-primary">Explore</a>
      </div>
      <div class="col-lg-6">
        <img src="<?= base_url('assets_system/images/model.jpg') ?>" alt="Section 2">
      </div>
    </div>
  </div>
</section>

<!-- Section 3 -->
<section class="section-white">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-lg-6">
        <h2>Engineering & Silicone Molding Services</h2>
        <p>Optimize your projects with precision, speed, and innovation.</p>
      </div>
      <div class="col-lg-6">
        <img src="<?= base_url('assets_system/images/model2.jpg') ?>" alt="Section 3">
      </div>
    </div>
  </div>
</section>

<!-- Section 4 -->
<section class="section-light">
  <div class="container">
    <div class="row align-items-center flex-row-reverse g-4">
      <div class="col-lg-6">
        <h2>IoT Solutions for Industry</h2>
        <p>Empowering businesses with smarter operations and better productivity.</p>
        <a href="#" class="btn btn-outline-primary">Learn More</a>
      </div>
      <div class="col-lg-6">
        <img src="<?= base_url('assets_system/images/model3.png') ?>" alt="Section 4">
      </div>
    </div>
  </div>
</section>

<!-- Section 5 -->
<section class="section-white text-center">
  <div class="container">
    <h2>Discover Our Latest Innovations</h2>
    <p class="mb-4">Enhancing efficiency and precision for your operations.</p>
    <img src="<?= base_url('assets_system/images/model4.jpg') ?>" alt="Section 5" class="img-fluid rounded">
  </div>
</section>

<!-- Footer -->
<footer>
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
    <h5>Get in Touch</h5>
    <div class="d-flex gap-2">
      <a href="#" class="btn btn-primary">Contact</a>
      <a href="#" class="btn btn-outline-primary">Consult</a>
    </div>
  </div>
  <div class="d-flex justify-content-between flex-wrap align-items-center">
    <img src="<?= base_url('assets_system/images/header_logo.png') ?>" height="40" alt="Logo">
    <div class="links d-flex flex-wrap">
      <a href="#">Products</a>
      <a href="#">Services</a>
      <a href="#">Case Studies</a>
      <a href="#">News</a>
    </div>
    <div class="socials">
      <a href="#"><i class="fab fa-facebook-f"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-linkedin-in"></i></a>
      <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
  </div>
  <div class="bottom">
    <span>© 2025 Line Seiki Asia Pacific</span>
    <a href="#">Privacy</a>
    <a href="#">Terms</a>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) navbar.classList.add('scrolled');
    else navbar.classList.remove('scrolled');
  });
</script>
</body>
</html>
