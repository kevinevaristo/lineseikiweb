<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Line Seiki Asia Pacific</title>

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
=================================*/
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
=================================*/
html {
  scroll-behavior: smooth;
}
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
=================================*/
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
.navbar-brand img {
  height: 40px;
  width: auto;
  transition: var(--transition);
}

/* Dropdown */
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
.dropdown-submenu {
  position: relative;
}
.dropdown-submenu > .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -0.8rem;
}

/* ===============================
   SECTIONS
=================================*/
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
section h1,
section h2 {
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
section h1::after,
section h2::after {
  content: '';
  position: absolute;
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

/* Section Colors */
.section-white {
  background: #fff;
  color: #333;
}
.section-light-blue,
.section-light-orange {
  background: var(--light-blue);
  color: #333;
  position: relative;
  overflow: hidden;
}

/* ===============================
   BUTTONS
=================================*/
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

/* ===============================
   PARTNER LOGOS
=================================*/
.partner-logos img {
  max-height: 100px;
  max-width: 200px;
  margin: 20px 30px;
  object-fit: contain;
  filter: grayscale(0%);
  transition: var(--transition);
}
.partner-logos img:hover {
  filter: grayscale(0%);
  transform: scale(1.05);
}

/* ===============================
   FOOTER
=================================*/
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
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' ... %3E");
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

/* ===============================
   ANIMATIONS
=================================*/
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
   UTILITIES / FIXES
=================================*/
/* Center heading underlines */
section h1::after,
section h2::after,
footer h2::after {
  left: 50% !important;
  transform: translateX(-50%);
}
/* Remove navbar spacer */
body > div[style*="height: 90px"] {
  display: none !important;
}
/* Center only Integrated Production heading */
.section-white h1 {
  text-align: center !important;
}

/* ===============================
   MEDIA QUERIES
=================================*/
@media (max-width: 992px) {
  section { padding: 80px 0; }
  section h1 { font-size: 2.4rem; }
  section h2 { font-size: 2rem; }
  .dropdown-submenu > .dropdown-menu {
    left: 0;
    margin-top: 0;
  }
  footer .links a {
    display: inline-block;
    margin-bottom: 12px;
  }
}
@media (max-width: 768px) {
  section h1 { font-size: 2rem; }
  section h2 { font-size: 1.8rem; }
  footer .links a {
    display: block;
    margin-bottom: 12px;
  }
}
/* HERO SECTION */
.hero-section {
  position: relative;
  height: 50vh;
  background: url("<?= base_url('assets_system/images/Hero.jpg') ?>") center center/cover no-repeat;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 100px 80px;
  color: white;
  opacity: 0;
  animation: heroFadeIn 1.5s ease-in-out forwards;
}

@keyframes heroFadeIn {
  0% {
    opacity: 0;
    transform: scale(1.03);
  }
  100% {
    opacity: 1;
    transform: scale(1);
  }
}

.hero-overlay {
  padding: 30px 40px;
  border-radius: 10px;
  margin-left: 325px;
  animation: fadeUpHero 0.4s ease forwards 0.4s;
  opacity: 0;
}

@keyframes fadeUpHero {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-section h1 {
  font-size: 3.5rem;
  font-weight: 800;
  text-transform: uppercase;
  margin: 0;
  margin-top: 100px;
}

  .hero-overlay {
  margin-left: 0;
}

.hero-section {
  padding-left: 250px; /* Adjust this to control how far from the left the H1 starts */
}

/* Make it responsive */
@media (max-width: 768px) {
  .hero-section {
    padding: 80px 30px;
    height: 50vh;
  }
  .hero-overlay {
    margin-left: 20px;
    padding: 20px 25px;
  }
  .hero-section h1 {
    font-size: 2.2rem;
  }
}

/* Remove hero after lines */
.hero-section h1::before,
.hero-section h1::after,
.hero-section .no-after::before,
.hero-section .no-after::after {
  content: none !important;
  display: none !important;
}



/* ===============================
   CONCEPT SECTION
=================================*/
.section-white {
  background: #fff;
  padding: 100px 0;
}

.section-white h2 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 20px;
  color: var(--primary-blue);
}

.section-white p.lead {
  color: #555;
  max-width: 800px;
  margin: 0 auto 50px auto;
  font-size: 1.1rem;
  line-height: 1.7;
}

/* Concept Boxes */
.concept-boxes {
  display: flex;
  justify-content: center;
  align-items: stretch;
  gap: 20px;
  flex-wrap: wrap; 
}

.concept-box {
  background-color: #E3F2FD; /* section-light-blue */
  border-radius: 15px;
  padding: 30px 25px;
  width: 280px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}


.concept-box h4 {
  color: var(--primary-blue);
  font-weight: 700;
  margin-bottom: 10px;
}

.concept-box p {
  color: var(--primary-blue);
  font-size: 0.95rem;
  line-height: 1.5;
}

/* Responsive layout */
@media (max-width: 768px) {
  .concept-box {
    width: 100%;
  }
}

  /* Delete the after line in concept boxes */
  .concept-box h1::before,
  .concept-box h1::after,
  .concept-box .no-after::before,
  .concept-box .no-after::after {
  content: none !important;
  display: none !important;
  background: none !important;
  border: none !important;
  height: 0 !important;
  width: 0 !important;
}


  .mission-vision-section {
  position: relative;
  background: url("<?= base_url('assets_system/images/m-and-v.jpg') ?>") center center/cover no-repeat;
  color: #333;
  padding: 120px 0;
  overflow: hidden;
}

.mission-vision-section::before {
  content: "";
  position: absolute;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(255, 255, 255, 0.75);
  backdrop-filter: blur(1px);
  z-index: 0;
}

.mission-vision-overlay {
  position: relative;
  z-index: 1;
}

.mission-vision-section h2 {
  color: black;
  font-weight: 700;
  margin-bottom: 15px;
}

.mission-vision-section p {
  color: black;
  font-size: 1.1rem;
  max-width: 700px;
}


.mission-vision-section h2::after {
  content: none !important;
}

/* Responsive */
@media (max-width: 768px) {
  .mission-vision-section {
    text-align: center;
    background-attachment: scroll;
  }
  .mission-vision-section p {
    max-width: 100%;
  }
}
  
.section-light-blue h1,
.section-white h1 {
  text-align: left !important;
}

.section-light-blue h1::after,
.section-white h1::after {
  left: 0 !important;
  transform: none !important;
}


.concept-box h1 {
  text-align: center !important;
  margin: 0 auto;
  display: block;
}

/* margin */
.row {
  margin-bottom: 150px !important; 
}

.row:last-of-type { 
  margin-bottom: 0 !important;
}


/* === Combined Section (Enhanced Gradient Design) === */
#combined-section {
  position: relative;
  color: #fff;
  padding: 120px 0;
  border-radius: 15px;
  overflow: hidden;

  /* === Gradient Background (Updated Colors) === */
  background: 
    radial-gradient(circle at top right, rgba(66, 134, 244, 0.3), transparent 40%), /* soft glow */
    linear-gradient(135deg, #0F467B 40%, #4286f4 100%), /* main gradient */
    linear-gradient(0deg, rgba(255,255,255,0.05) 1px, transparent 1px), /* subtle grid lines */
    linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px); /* subtle grid lines */
  
  background-size: 
    cover, 
    cover, 
    40px 40px, 
    40px 40px;

  background-blend-mode: overlay;
}

#combined-section::after {
  content: "";
  position: absolute;
  inset: 10px;
  border: 2px solid rgba(255,255,255,0.2);
  border-radius: 15px;
  z-index: 1;
}

#combined-section h1,
#combined-section p {
  color: white !important;
  position: relative;
  z-index: 2;
}

#combined-section h1::after {
  content: "";
  display: block;
  width: 60px;
  height: 4px;
  margin-top: 8px;
  background: #00b3ff !important; 
  border-radius: 2px;
  position: relative;
  z-index: 2;
}

/* === Optional subtle animation (glow pulse) === */
#combined-section::before {
  content: "";
  position: absolute;
  width: 400px;
  height: 400px;
  top: -100px;
  right: -100px;
  background: radial-gradient(circle, rgba(255,255,255,0.15), transparent 70%);
  animation: glow 8s ease-in-out infinite alternate;
  z-index: 0;
}

@keyframes glow {
  from { opacity: 0.2; transform: scale(1); }
  to { opacity: 0.4; transform: scale(1.1); }
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
          <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('index/about_us') ?>">About Us</a></li>

          <!-- Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href=" " id="navbarDropdown" role="button" data-bs-toggle="dropdown">
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

  <!-- Spacer for fixed navbar -->
  <div style="height: 90px;"></div>

  <!-- Header Section -->
  <section class="hero-section">
  <div class="hero-overlay">
    <h1>ABOUT US</h1>
  </div>
</section>


  <!-- Concept -->
  <section class="section-white">
    <div class="container text-center">
      <h2 class="fade-in"> Line Seiki Asia Pacific Inc. </h2>
          <p class="lead fade-in delay-1">
             At Line Seiki Asia Pacific, Inc. (LSA), we bridge innovation from Japan to industries across the
            Asia-Pacific region. As the official sales arm of Line Seiki Co., Ltd., we bring decades of
            expertise in measurement technology, automation, and smart manufacturing solutions closer to
            our partners and customers.
          </p>
        <!-- ✅ New Boxes Section -->
    <div class="concept-boxes">
      <div class="concept-box">
        <h1>1999</h1>
        <p>Year Established</p>
      </div>
      <div class="concept-box">
        <h1>+40</h1>
        <p>Global Distributor</p>
      </div>
      <div class="concept-box">
        <h1>4</h1>
        <p>Regional Offices</p>
      </div>
       <div class="concept-box">
        <h1>70+</h1>
        <p>Expertise in Measuring 
          & Industrial Solutions</p>
      </div>
    </div>
    </div>
  </section>

    <!-- Combined Section: New Businesses Challenge + Integrated Production + Strict Inspection for Quality -->
<section id="combined-section" class="section-light-blue">
  <div class="container">

    <!-- First Row -->
    <div class="row align-items-center mb-5">
      <div class="col-lg-6 text-center text-lg-start">
        <h1 class="fade-in">Our Regional Commitment</h1>
        <p class="lead fade-in delay-1">
          Connecting Customers and Solutions. We serve as the direct link between Line Seiki Japan and industries across Asia Pacific. From inquiry to delivery, our team ensures that customers receive the right products, technical support, and guidance tailored to their specific applications.
        </p>
      </div>
      <div class="col-lg-6 text-center">
        <img src=<?= base_url('assets_system/images/newb.jpg') ?> alt="New Businesses Challenge" class="fade-in delay-2 img-fluid rounded shadow">
      </div>
    </div>

    

    <!-- Second Row -->
    <div class="row align-items-center flex-lg-row-reverse mb-5">
      <div class="col-lg-6 text-center text-lg-start">
        <h1 class="fade-in">Collaboration Across Borders</h1>
        <p class="lead fade-in delay-1">
          Working closely with our headquarters and distributors, we help expand the reach of Line Seiki’s technologies throughout the region. Through partnerships, training, and joint initiatives, we strengthen communication between engineers, manufacturers, and end users.
        </p>
      </div>
      <div class="col-lg-6 text-center">
        <img src=<?= base_url('assets_system/images/integrated.jpg') ?> alt="Integrated Production" class="fade-in delay-2 img-fluid rounded shadow">
      </div>
    </div>

   

    <!-- Third Row -->
    <div class="row align-items-center">
      <div class="col-lg-6 text-center text-lg-start">
        <h1 class="fade-in">Delivering Reliable Support</h1>
        <p class="lead fade-in delay-1">
          Our role goes beyond sales — we provide after-sales assistance, technical coordination, and product demonstrations to ensure our customers get lasting value from every Line Seiki solution. By maintaining close collaboration with Japan, we ensure consistent quality and service wherever our customers are.
        </p>
      </div>
      <div class="col-lg-6 text-center">
        <img src=<?= base_url('assets_system/images/strict.jpg') ?> alt="Strict Inspection for Quality" class="fade-in delay-2 img-fluid rounded shadow">
      </div>
    </div>

  </div>
</section>

  <!-- Mission and Vision -->
  <section class="mission-vision-section">
  <div class="mission-vision-overlay">
    <div class="container text-start">
      <h2 class="fade-in">Mission</h2>
      <p class="mb-5 fade-in delay-1">
        To deliver accurate, reliable, and innovative measurement and monitoring
        solutions that empower manufacturers to achieve operational excellence and
        sustainable growth.
      </p>
      <h2 class="fade-in">Vision</h2>
      <p class="fade-in delay-2">
        To be the preferred partner in Southeast Asia for industrial process monitoring,
        enabling smarter, more connected, and more efficient manufacturing
        environments
      </p>
    </div>
  </div>
</section>

  <!-- Partner / Association Logos -->
  <section class="section-white text-center">
    <div class="container">
      <h2 class="fade-in">Our Partners and Associations</h2>
      <div class="d-flex justify-content-center flex-wrap partner-logos">
        <img src=<?= base_url('assets_system/images/MIAP.png') ?> alt="Partner 5" class="fade-in delay-5">
        <img src=<?= base_url('assets_system/images/PDMA.png') ?> alt="Partner 6" class="fade-in delay-6">
        <img src=<?= base_url('assets_system/images/AIAP.jpg') ?> alt="Partner 6" class="fade-in delay-7">
        <img src=<?= base_url('assets_system/images/Violet-White.png') ?> alt="Partner 6" class="fade-in delay-8">
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="section-light-orange text-center">
    <div class="container">
      <h2 class="fade-in">Get in Touch</h2>
      <p class="mb-4 fade-in delay-1">
        Interested in our products or services? Connect with us today and let's build solutions together.  
      </p>
      <a href="<?= base_url('index/contact_us') ?>" class="btn btn-primary btn-lg fade-in delay-2">Contact Us</a>
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

  <!-- Bootstrap JS -->
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