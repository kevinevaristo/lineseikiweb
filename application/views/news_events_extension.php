<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>News and Events - Line Seiki Asia Pacific</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* =========================================================
   🌐 GLOBAL VARIABLES & BASE STYLES
========================================================= */
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

/* =========================================================
   🔹 NAVBAR
========================================================= */
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
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
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

/* =========================================================
   🧩 SECTION STYLES
========================================================= */
section {
  padding: 100px 0;
  position: relative;
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

section h2::after {
  content: '';
  position: absolute;
  bottom: -10px;
  left: 50% !important;
  transform: translateX(-50%) !important;
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

/* Section backgrounds */
.section-white { background: #fff; color: #333; }
.section-light-blue,
.section-light-orange {
  background: var(--light-blue);
  color: #333;
  position: relative;
  overflow: hidden;
}

/* =========================================================
   🔘 BUTTONS
========================================================= */
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

/* Button colors */
.btn-primary {
  background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
  border: none;
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
}

.btn-orange:hover {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
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

/* CTA buttons */
.cta-buttons {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.cta-buttons .btn {
  flex: 1;
  min-width: 180px;
  text-align: center;
}

.cta-buttons .btn-request-demo {
  background: transparent;
  border: 2px solid var(--primary-blue);
  color: var(--primary-blue);
}

.cta-buttons .btn-request-demo:hover {
  background: var(--primary-blue);
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
}

/* =========================================================
   🖼️ IMAGES & FORMS
========================================================= */
.img-hover {
  transition: var(--transition);
  border-radius: 16px;
  overflow: hidden;
}

.img-hover img {
  transition: var(--transition);
  border-radius: 16px;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.img-hover:hover img {
  transform: scale(1.05);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
}

/* Form */
.form-control {
  border-radius: 8px;
  padding: 12px 16px;
  border: 1px solid #ced4da;
  transition: var(--transition);
}

.form-control:focus {
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
}

.form-label {
  font-weight: 500;
  margin-bottom: 8px;
  color: var(--dark);
}

/* =========================================================
   🧾 NEWS DETAIL PAGE
========================================================= */
.news-detail {
  max-width: 1000px;
  margin: 80px auto;
  padding: 0 20px;
}

.notice-tag {
  border: 1px solid #002060;
  color: #002060;
  font-weight: bold;
  padding: 3px 10px;
  font-size: 0.9rem;
  display: inline-block;
  border-radius: 3px;
}

.date {
  color: #888;
  font-size: 0.9rem;
  margin-left: 15px;
}

h1 {
  font-weight: 700;
  margin-top: 20px;
  margin-bottom: 30px;
}

.detail-box {
  display: grid;
  grid-template-columns: 1fr 300px;
  gap: 20px;
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 20px;
}

.detail-box h5 {
  font-weight: bold;
  color: #002060;
  margin-bottom: 10px;
}

.detail-box p {
  color: #333;
  font-size: 0.95rem;
  margin-bottom: 0;
}

.detail-box img {
  width: 100%;
  border-radius: 5px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 30px;
}

table td {
  border: 1px solid #ddd;
  padding: 12px 15px;
  vertical-align: top;
  font-size: 0.95rem;
  color: #333;
}

table td:first-child {
  width: 150px;
  font-weight: bold;
  color: #002060;
}

.links a {
  color: #0047AB;
  text-decoration: none;
}

.back-btn {
  display: inline-block;
  margin-top: 40px;
  color: #002060;
  font-weight: bold;
  text-decoration: none;
}

.back-btn:hover {
  text-decoration: underline;
}

/* =========================================================
   🧭 FOOTER
========================================================= */
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

footer .links a:hover {
  color: white;
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
footer .links a::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: -4px;
  left: 0;
  background-color: var(--newblue2);  /* ← This is the blue line */
  transition: var(--transition);
}

footer .links a:hover::after {
  width: 100%;
}


/* =========================================================
   ✨ ANIMATIONS
========================================================= */
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

/* =========================================================
   📱 RESPONSIVE
========================================================= */
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

  .detail-box { grid-template-columns: 1fr; }

  .cta-buttons {
    flex-direction: column;
    gap: 15px;
  }

  footer .links a {
    display: block;
    margin-bottom: 12px;
  }
}

/* =========================================================
   🧹 CLEANUP
========================================================= */
body > div[style*="margin-top: 90px"] {
  display: none !important;
}
footer {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  color: white;
  padding: 80px 10% 40px;
  position: relative;
  overflow: hidden;
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


  </style>
</head>
<body>

  <!-- ✅ Navbar -->
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

          <!-- Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Product and Services
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= base_url('index/ps_prod') ?>">Products</a></li>
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
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>
<div class="fade-in">
 <div class="news-detail"><br><br><br><br>
    <div>
      <span class="notice-tag">Notice</span>
      <span class="date">2025.08.04</span>
    </div>

    <h1>Line Seiki to exhibit at JAPAN PACK 2025.</h1>

    <div class="detail-box">
      <div>
        <h5>JAPAN PACK 2025</h5>
        <p>Line Seiki Co., Ltd. will be exhibiting at JAPAN PACK 2025, Tokyo Japan. We will showcase our latest measuring instruments, sensors, and IoT solutions.</p>
      </div>
      <img src="https://placehold.co/600x400/002060/ffffff?text=JAPAN+PACK+2025" alt="Japan Pack 2025">
    </div>

    <table>
      <tr>
        <td>Date</td>
        <td>October 7 to 10, 2025</td>
      </tr>
      <tr>
        <td>Location</td>
        <td>Tokyo Big Sight</td>
      </tr>
      <tr>
        <td>Booth</td>
        <td>5-122 (East Exhibition Hall E5)</td>
      </tr>
      <tr class="links">
        <td>Website</td>
        <td>
          <a href="https://www.japanpack.jp/en/" target="_blank">https://www.japanpack.jp/en/</a><br>
          <a href="https://www.japanpack.jp/en/exhibitor/detail/?id=161" target="_blank">Exhibitor Detail</a>
        </td>
      </tr>
    </table>

    <a href="<?= base_url('index/news_event') ?>" class="back-btn">← Back to News</a>
  </div>
</div>
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