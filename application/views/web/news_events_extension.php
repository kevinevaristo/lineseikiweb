<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= isset($event['title']) ? htmlspecialchars($event['title']) : 'News and Events' ?> - Line Seiki Asia Pacific</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">

  <!-- Google Fonts -->
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">

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
  text-transform: uppercase;
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
  object-fit: cover;
}

.event-content {
  margin-top: 30px;
  line-height: 1.8;
  color: #333;
}

.event-content p {
  margin-bottom: 20px;
}

.event-image-full {
  width: 100%;
  max-width: 800px;
  margin: 30px auto;
  display: block;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

          <li class="nav-item"><a class="nav-link active" href="<?= base_url('index/news_event') ?>">News and Events</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/library') ?>">Library</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

<div class="fade-in">
 <div class="news-detail"><br><br><br><br>
    <!-- Event Badge and Date -->
    <div>
      <?php if (!empty($event['badge_text'])): ?>
        <span class="notice-tag"><?= htmlspecialchars($event['badge_text']) ?></span>
      <?php else: ?>
        <span class="notice-tag"><?= ucfirst(htmlspecialchars($event['category'])) ?></span>
      <?php endif; ?>
      <span class="date"><?= date('Y.m.d', strtotime($event['event_date'])) ?></span>
    </div>

    <!-- Event Title -->
    <h1><?= htmlspecialchars($event['title']) ?></h1>

    <!-- Event Featured Image and Description Box -->
    <?php if (!empty($event['image']) || !empty($event['meta_description'])): ?>
    <div class="detail-box">
      <div>
        <?php if (!empty($event['meta_description'])): ?>
          <h5><?= htmlspecialchars($event['title']) ?></h5>
          <p><?= nl2br(htmlspecialchars($event['meta_description'])) ?></p>
        <?php endif; ?>
      </div>
      <?php if (!empty($event['image'])): ?>
        <img src="<?= base_url('assets_system/images/' . htmlspecialchars($event['image'])) ?>"
             alt="<?= htmlspecialchars($event['title']) ?>"
             onerror="this.src='<?= base_url('assets_system/images/no-image.png') ?>'">
      <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Event Content -->
    <?php if (!empty($event['content'])): ?>
    <div class="event-content">
      <?= $event['content'] ?>
    </div>
    <?php endif; ?>

    <!-- Back Button -->
    <a href="<?= base_url('index/news_event') ?>" class="back-btn">
      <i class="fas fa-arrow-left"></i> Back to News
    </a>
  </div>
</div>

  <!-- ✅ Footer -->
<?php $this->load->view('web/footer'); ?>


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
