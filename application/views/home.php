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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
html { scroll-behavior: smooth; }

body {
  background-color: #fff;
  color: #333;
  font-family: 'Inter', sans-serif;
  line-height: 1.6;
  overflow-x: hidden;
}

hr {
  background: rgba(255, 255, 255, 0.1);
  height: 1px;
}

/* ===============================
   NAVBAR
==================================*/
.navbar {
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(10px);
  padding: 0.8rem 5%;
  transition: var(--transition);
  border-bottom: 1px solid rgba(13, 110, 253, 0.1);
}
.navbar.scrolled { padding: 0.6rem 5%; }

.navbar-brand img {
  height: 40px;
  width: auto;
  transition: var(--transition);
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

/* ===============================
   DROPDOWN
==================================*/
.dropdown-menu {
  background-color: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 12px;
  padding: 0.8rem 0;
  margin-top: 0.8rem;
  animation: fadeIn 0.3s ease;
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
.dropdown-submenu { position: relative; }
.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -0.8rem;
}

/* ===============================
   SECTIONS
==================================*/
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
section img:hover { transform: translateY(-5px); }

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
section p {
  margin-bottom: 28px;
  font-size: 1.1rem;
  color: #495057;
}

/* Color Schemes */
.section-white { background: #fff; color: #333; }
.section-light-blue { background: var(--light-blue); color: #333; }
.section-light-orange { background: var(--light-orange); color: #333; }

/* ===============================
   BUTTONS
==================================*/
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
.btn:hover::before { width: 100%; }

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
.btn-explore {
  background: transparent;
  border: 2px solid var(--primary-blue);
  color: var(--primary-blue);
}
.btn-explore:hover {
  background: var(--primary-blue);
  color: #fff;
  transform: translateY(-3px);
}
.btn-link { text-decoration: none; position: relative; }
.btn-link span { position: relative; }
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
.btn-link:hover span::after { width: 100%; }

/* ===============================
   CAROUSEL
==================================*/
#heroCarousel {
  background-color: #fff !important;
}

#heroCarousel .carousel-item {
  height: 100vh;
  min-height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #fff; /* white background */
  position: relative;
}

#heroCarousel .carousel-item::before {
  display: none; /* remove dark overlay */
}

.hero-slide {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 50px;
  color: #000; /* black text for white bg */
}

.hero-text {
  flex: 1;
  max-width: 50%;
}

.hero-text h1 {
  background: linear-gradient(90deg, var(--primary-blue), #007bff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 700;
  font-size: 2.8rem;
}

.hero-text h1::after {
  content: "";
  display: block;
  width: 60px;
  height: 4px;
  margin-top: 8px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
}

.hero-text p {
  color: #333;
  font-size: 1.1rem;
  margin-top: 15px;
  line-height: 1.6;
}

.hero-image {
  flex: 1;
  display: flex;
  justify-content: flex-end;
}

.hero-image img {
  max-width: 100%; /* ⬅️ Make image larger than its container */
  height: auto;
  border-radius: 12px;
  transform: scale(1.1); 
  object-fit: cover;
  transition: transform 0.5s ease;
}


/* ===============================
   CAROUSEL INDICATORS (BLUE)
==================================*/
#heroCarousel .carousel-indicators [data-bs-target] {
  background-color: #0d6efd; /* Blue color */
  width: 12px;
  height: 12px;
  border-radius: 50%;
  opacity: 0.5;
  transition: 0.3s ease;
  border: none;
}

#heroCarousel .carousel-indicators .active {
  opacity: 1;
  background-color: #084298; /* Darker blue for active */
  transform: scale(1.2);
}


/* Fade effect */
.carousel.carousel-fade .carousel-item {
  opacity: 0;
  transition-property: opacity;
  transition-duration: 1.5s;
  transition-timing-function: ease-in-out;
}
.carousel.carousel-fade .carousel-item.active,
.carousel.carousel-fade .carousel-item-next.carousel-item-start,
.carousel.carousel-fade .carousel-item-prev.carousel-item-end {
  opacity: 1;
}

/* Hide controls (optional) */
#heroCarousel .carousel-control-prev,
#heroCarousel .carousel-control-next {
  display: none !important;
}

/* Responsive layout */
@media (max-width: 992px) {
  .hero-slide {
    flex-direction: column;
    text-align: center;
  }

  .hero-text,
  .hero-image {
    max-width: 100%;
  }

  .hero-image {
    justify-content: center;
    margin-top: 30px;
  }

  .hero-text h1 {
    font-size: 2rem;
  }
}


/* ===============================
   FOOTER
==================================*/
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
footer h2 { color: white; font-weight: 700; }

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
footer .links a:hover { color: white; }
footer .links a:hover::after { width: 100%; }

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
footer .bottom a:hover { color: var(--newblue2); }

/* ===============================
   ANIMATIONS
==================================*/
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
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

/* ===============================
   RESPONSIVE
==================================*/
@media (max-width: 992px) {
  section { padding: 80px 0; }
  section h1 { font-size: 2.4rem; }
  section h2 { font-size: 2rem; }
  .dropdown-submenu > .dropdown-menu { left: 0; margin-top: 0; }
  footer .links a { display: inline-block; margin-bottom: 12px; }
}
@media (max-width: 768px) {
  section h1 { font-size: 2rem; }
  section h2 { font-size: 1.8rem; }
  footer .links a { display: block; margin-bottom: 12px; }
}

/* ===============================
   SPECIAL FIXES
==================================*/
.cta-title::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: -15px;
  transform: translateX(-50%);
  width: 60px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue2), var(--newblue));
  border-radius: 2px;
}
section h2::after {
  left: 50% !important;
  transform: translateX(-50%);
  background: linear-gradient(90deg, var(--newblue2), var(--newblue)) !important;
}
body > div[style*="margin-top:90px"] { display: none !important; }

  .section-white .btn-orange {
  margin-top: 20px;
}


.service-card {
  background: #fff;
  border-radius: 16px;
  transition: all 0.3s ease;
  border: 1px solid #e9ecef;
}
.service-icon-img img {
  width: 60px;
  height: 60px;
  border-radius: 12px;
  background: rgba(13, 110, 253, 0.08);
  object-fit: cover;
}
.btn-link {
  color: var(--primary-blue);
  font-weight: 600;
  text-decoration: none;
}

  /* ===============================
   NEW PRODUCTS SECTION
==================================*/
.new-products h2 {
  position: relative;
  display: inline-block; 
}

.new-products h2::after {
  content: "";
  position: absolute;
  bottom: -10px;
  left: 0; 
  width: 80px;
  height: 3px;
  background: linear-gradient(90deg, var(--newblue2), var(--newblue));
  border-radius: 2px;
}

.new-products h2::after {
  left: 0 !important;
  transform: none !important;
  background: linear-gradient(90deg, var(--newblue2), var(--newblue));
}

.new-products p {
  font-size: 1.1rem;
  color: black;
  max-width: 500px;
}
.new-prod-feature img {
  width: 90px;
  height: 90px;
  object-fit: cover;
  border-radius: 12px;
  background: #f8f9fa;
  padding: 10px;
  transition: transform 0.3s ease;
}
.new-prod-feature img:hover {
  transform: scale(1.05);
}
.new-prod-feature h6 {
  font-size: 1rem;
  color: var(--newblue2);
}

/* Reduce gap between Our Services and New Products sections */
.section-white + .new-products {
  margin-top: -50px; /* adjust value as needed */
}

  /* ✅ Align Learn More buttons horizontally in Our Services */
.service-card {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.service-card p {
  flex-grow: 1; /* pushes the button to the bottom */
}

.service-card .btn-link {
  display: inline-block;
  margin-top: auto;
  color: var(--primary-blue);
  font-weight: 600;
  text-decoration: none;
}

.service-card .btn-link span::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: -4px;
  left: 0;
  background-color: currentColor;
  transition: var(--transition);
}

.service-card .btn-link:hover span::after {
  width: 100%;
}


</style>

</head>

<body>

 <!-- ✅ Fixed Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container-fluid">
    <!-- Logo on the LEFT -->
    <a class="navbar-brand" href="#">
      <img src=<?= base_url('assets_system/images/header_logo.png') ?> alt="Line Seiki Logo">
    </a>

    <!-- Toggler for mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navigation items -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="<?= base_url() ?>">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index/about_us') ?>">About Us</a></li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            Product and Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('index/ps_prod') ?>">Products</a></li>

            <!-- Submenu -->
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

  <!-- Offset for fixed navbar -->
  <div style="margin-top:90px"></div>

<!-- ✅ Carousel (fixed) -->
<div id="heroCarousel" class="carousel slide carousel-fade fade-in" data-bs-ride="carousel" data-bs-interval="5000">

  <!-- Indicators -->
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
  </div>

  <!-- Slides -->
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active">
      <div class="container hero-slide d-flex align-items-center justify-content-between">
        <div class="hero-text">
          <h1>Precision You Can Trust</h1>
          <p>
             From counting devices to digital manufacturing
            solutions, we continue to deliver reliable instruments and
            technologies that help industries move with accuracy
            and efficiency
          </p>
        </div>
        <div class="hero-image">
          <img src=<?= base_url('assets_system/images/Legacy2.png') ?> alt="Slide 1">
        </div>
      </div>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item">
      <div class="container hero-slide d-flex align-items-center justify-content-between">
        <div class="hero-text">
          <h1>Precision You Can Trust</h1>
          <p>
            From counting devices to digital manufacturing
              solutions, we continue to deliver reliable instruments and
            technologies that help industries move with accuracy
            and efficiency
          </p>
        </div>
        <div class="hero-image">
          <img src=<?= base_url('assets_system/images/simul1bg.png') ?> alt="Slide 2">
        </div>
      </div>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item">
      <div class="container hero-slide d-flex align-items-center justify-content-between">
        <div class="hero-text">
          <h1>Precision You Can Trust</h1>
          <p>
             From counting devices to digital manufacturing
            solutions, we continue to deliver reliable instruments and
            technologies that help industries move with accuracy
            and efficiency
          </p>
        </div>
        <div class="hero-image">
          <img src=<?= base_url('assets_system/images/Gemba-hero2.png') ?> alt="Slide 3">
        </div>
      </div>
    </div>

    <!-- Slide 4 -->
    <div class="carousel-item">
      <div class="container hero-slide d-flex align-items-center justify-content-between">
        <div class="hero-text">
          <h1>Precision You Can Trust</h1>
          <p>
             From counting devices to digital manufacturing
            solutions, we continue to deliver reliable instruments and
            technologies that help industries move with accuracy
            and efficiency
          </p>
        </div>
        <div class="hero-image">
          <img src=<?= base_url('assets_system/images/Asc-hero.png') ?> alt="Slide 4">
        </div>
      </div>
    </div>
  </div>

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>


  <!-- Section 5 (white) -->
  <section class="section-white">
    <div class="container text-center">
      <h2 class="fade-in">Discover Our Latest Innovations in Industrial Measurement</h2><br>
      <p class="mb-4 fade-in delay-1">Explore our newest products designed to enhance efficiency and precision in your operations.</p>
      <img src=<?= base_url('assets_system/images/new5.jpg') ?> alt="Section 5" class="img-fluid rounded fade-in delay-2">
    </div>
  </section>

    <!-- Legacy Product -->
    <section class="section-white">
  <div class="container text-center">
    <h2 class="fade-in">Our Proven Line of Counting and Measuring Instruments</h2>
    <p class="mb-4 fade-in delay-1" style="color:black;">
      For over 70 years, Line Seiki has been a trusted name in mechanical, electronic, and electromagnetic counters,
      tachometers, timers, and other precision measuring tools. Built for consistency, accuracy, and durability — these
      products remain the foundation of our customers’ success in industries around the world.
    </p>
    <a href="<?= base_url('index/ps_prod') ?>" class="btn btn-orange fade-in delay-2">Learn More</a>
  </div>
</section>
      <!-- Our Services-->
     <section class="section-white">
  <div class="container text-center">
    <h2 class="fade-in">Our Services</h2>
    <p class="mb-5 fade-in delay-1" style="color:black;">Beyond Measurement — We Engineer Possibilities</p>

    <div class="row justify-content-center g-4 fade-in delay-2">
      <!-- Card 1 -->
      <div class="col-md-4">
        <div class="service-card p-4 h-100 shadow-sm text-start">
          <div class="d-flex align-items-center mb-3">
            <div class="service-icon-img me-3">
              <img src=<?= base_url('assets_system/images/icon_simul.png') ?> alt="Simulation Icon" />
            </div>
            <h5 class="fw-bold mb-0">Simulation Analysis Service</h5>
          </div>
          <p style="color: black;">
            Backed by our expertise in research and development, we provide engineering simulation analysis to validate product designs before physical testing.
          </p>
          <a href="<?= base_url('index/ps_serv_simulation') ?>" class="btn-link"><span>Learn more</span></a>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="col-md-4">
        <div class="service-card p-4 h-100 shadow-sm text-start">
          <div class="d-flex align-items-center mb-3">
            <div class="service-icon-img me-3">
              <img src=<?= base_url('assets_system/images/icon_sili.png') ?> alt="Molding Icon" />
            </div>
            <h5 class="fw-bold mb-0">Silicone Molding & Urethane Casting</h5>
          </div>
          <p style="color: black;">
            Rapid prototyping and low-volume production for faster market validation.
          </p>
          <a href="<?= base_url('index/ps_serv_silicone') ?>" class="btn-link"><span>Learn more</span></a>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="col-md-4">
        <div class="service-card p-4 h-100 shadow-sm text-start">
          <div class="d-flex align-items-center mb-3">
            <div class="service-icon-img me-3">
              <img src=<?= base_url('assets_system/images/icon_gemba.png') ?> alt="GEMBA Icon" />
            </div>
            <h5 class="fw-bold mb-0">GEMBA Machine Monitoring System</h5>
          </div>
          <p style="color: black;">
            Track machine status, downtime, and productivity in real time — all from a single dashboard.
          </p>
          <a href="<?= base_url('index/ps_iotsolution') ?>" class="btn-link"><span>Learn more</span></a>
        </div>
      </div>
    </div>
  </div>
</section>

    <!-- New Products-->
      <section class="section-white new-products">
  <div class="container">
    <div class="row align-items-center">
      <!-- Left text content -->
      <div class="col-lg-6 fade-in">
        <h2 class="fw-bold text-primary">New Products</h2>
        <p>
          Our newest addition, <strong>Safety Switches and Relays</strong>, reinforces our commitment
          to smarter and safer manufacturing environments.
        </p>
      </div>
      <div class="col-lg-6 text-center fade-in delay-1">
        <img src=<?= base_url('assets_system/images/new_prod.png') ?> alt="New Product" class="img-fluid rounded shadow">
      </div>
    </div>

    <!-- Four bottom feature boxes -->
    <div class="row text-center mt-5 fade-in delay-2">
      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src=<?= base_url('assets_system/images/high-dura.png') ?> alt="Durability" class="img-fluid mb-3">
          <h6 class="fw-semibold text-primary">High Durability</h6>
        </div>
      </div>

      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src=<?= base_url('assets_system/images/high-relia.png') ?> alt="Reliability" class="img-fluid mb-3">
          <h6 class="fw-semibold text-primary">High Reliability</h6>
        </div>
      </div>

      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src=<?= base_url('assets_system/images/prevent.png') ?> alt="Prevention" class="img-fluid mb-3">
          <h6 class="fw-semibold text-primary">Prevent Invalidation</h6>
        </div>
      </div>

      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src=<?= base_url('assets_system/images/excellent.png') ?> alt="Performance" class="img-fluid mb-3">
          <h6 class="fw-semibold text-primary">Excellent Dust & Waterproof Performance</h6>
        </div>
      </div>
    </div>
  </div>
</section>


  


  <!-- Footer -->
  <footer>
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
      <h2>Get in Touch with Us</h2>
      <div>
        <button class="btn btn-orange">Contact</button>
        <button class="btn btn-light">Consult</button>
      </div>
    </div>
    <p>We're here to assist with your inquiries and needs.</p>
    <hr class="my-4">
    <div class="d-flex justify-content-between flex-wrap align-items-center">
      <img src=<?= base_url('assets_system/images/footer_logo.png') ?> height="40" alt="Logo">
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