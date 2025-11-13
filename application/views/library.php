<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library - Line Seiki Asia Pacific</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* =========================
   🎨 Variables
========================= */
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

/* =========================
   📌 Base Styles
========================= */
html {
  scroll-behavior: smooth;
}

body {
  background-color: #fff;
  color: #333;
  font-family: 'Inter', sans-serif;
  line-height: 1.6;
  overflow-x: hidden;
  padding-top: 90px;
}

hr {
  background: rgba(255, 255, 255, 0.1);
  height: 1px;
}

/* =========================
   🟦 Navbar
========================= */
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

/* =========================
   🔽 Dropdown
========================= */
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

/* =========================
   📚 Modern Library Section
========================= */
.library {
  padding: 80px 5%;
  background: linear-gradient(135deg, var(--light-blue) 0%, #fff 100%);
  position: relative;
  overflow: hidden;
}

.library::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2317A2DC' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  z-index: 0;
}

.library-container {
  position: relative;
  z-index: 1;
}

.library h1 {
  text-align: center;
  font-size: 3rem;
  margin-bottom: 50px;
  color: var(--newblue2);
  font-weight: 800;
  position: relative;
  text-transform: uppercase;
  letter-spacing: -0.5px;
}

.library h1::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: -15px;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
}

.library-section {
  margin-bottom: 100px;
  position: relative;
}

.library-section h2 {
  font-size: 2.2rem;
  color: var(--newblue2);
  margin-bottom: 25px;
  text-align: center;
  position: relative;
  font-weight: 700;
}

.library-section h2::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: -10px;
  transform: translateX(-50%);
  width: 60px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
}

.library-section p {
  text-align: center;
  color: #495057;
  margin-bottom: 50px;
  font-size: 1.1rem;
  max-width: 700px;
  margin-left: auto;
  margin-right: auto;
}

/* Modern Download Cards */
.download-card {
  background: #fff;
  border-radius: 20px;
  padding: 40px 30px;
  text-align: center;
  transition: var(--transition);
  border: none;
  height: 100%;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
}

.download-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s ease;
}

.download-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
}

.download-card:hover::before {
  transform: scaleX(1);
}

.download-card h5 {
  margin-bottom: 20px;
  font-weight: 700;
  color: var(--newblue2);
  font-size: 1.4rem;
  position: relative;
}

.download-icon {
  font-size: 3rem;
  color: var(--newblue);
  margin-bottom: 25px;
  transition: var(--transition);
}

.download-card:hover .download-icon {
  transform: scale(1.1);
  color: var(--primary-blue);
}

/* =========================
   🔘 Modern Buttons
========================= */
.btn {
  padding: 0.8rem 1.8rem;
  border-radius: 10px;
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

.btn-download {
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  color: #fff;
  border: none;
  padding: 12px 25px;
  border-radius: 10px;
  font-weight: 600;
  transition: var(--transition);
  position: relative;
  overflow: hidden;
  z-index: 1;
  box-shadow: 0 5px 15px rgba(23, 162, 220, 0.3);
}

.btn-download::before {
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

.btn-download:hover::before {
  width: 100%;
}

.btn-download:hover {
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(23, 162, 220, 0.4);
}

.btn-success {
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border: none;
  transition: var(--transition);
  border-radius: 10px;
  padding: 12px 25px;
  font-weight: 600;
}

.btn-success:hover {
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(23, 162, 220, 0.3);
}

/* =========================
   🪟 Modern Modal
========================= */
.modal-header {
  background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
  color: #fff;
  border-top-left-radius: 16px;
  border-top-right-radius: 16px;
  padding: 20px 25px;
}

.modal-title {
  font-weight: 700;
  font-size: 1.4rem;
}

.modal-content {
  border-radius: 16px;
  border: none;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
  overflow: hidden;
}

.modal-footer .btn {
  min-width: 120px;
  border-radius: 10px;
  font-weight: 600;
  padding: 12px 25px;
}

/* =========================
   📝 Forms
========================= */
.form-control {
  border-radius: 10px;
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
  transition: var(--transition);
  font-size: 1rem;
}

.form-control:focus {
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.form-label {
  font-weight: 600;
  color: var(--newblue2);
  margin-bottom: 8px;
}

/* =========================
   ✨ Animations
========================= */
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

/* Card animation */
@keyframes cardFadeIn {
  from {
    opacity: 0;
    transform: translateY(20px) scale(0.95);
  }
  to {
    opacity: 1;
    transform: translateY(0) scale(1);
  }
}

.download-card {
  animation: cardFadeIn 0.6s ease forwards;
}

.download-card:nth-child(1) { animation-delay: 0.1s; }
.download-card:nth-child(2) { animation-delay: 0.2s; }
.download-card:nth-child(3) { animation-delay: 0.3s; }
.download-card:nth-child(4) { animation-delay: 0.4s; }

/* =========================
   ⬇️ Footer
========================= */
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

/* =========================
   📱 Responsive
========================= */
@media (max-width: 992px) {
  .library {
    padding: 60px 5%;
  }

  .library h1 {
    font-size: 2.4rem;
  }

  .library-section h2 {
    font-size: 2rem;
  }

  .dropdown-submenu > .dropdown-menu {
    left: 0;
    margin-top: 0;
  }
}

@media (max-width: 768px) {
  .library h1 {
    font-size: 2rem;
  }

  .library-section h2 {
    font-size: 1.8rem;
  }

  footer .links a {
    display: block;
    margin-bottom: 12px;
  }
  
  .download-card {
    padding: 30px 20px;
  }
  
  .download-icon {
    font-size: 2.5rem;
  }
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
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
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
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('index/library') ?>">Library</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- ✅ Modern Library Section -->
  <section class="library">
    <div class="library-container">
      <h1 class="fade-in">Resource Library</h1>

      <!-- Case Studies -->
      <div class="library-section fade-in delay-1">
        <h2>Case Studies</h2>
        <p>Explore our detailed case studies showcasing successful implementations and measurable results.</p>
        <div class="row g-4 justify-content-center">
          <div class="col-md-4">
            <div class="download-card">
              <div class="download-icon">
                <i class="fas fa-chart-line"></i>
              </div>
              <h5>Case Study 1</h5>
              <button class="btn-download" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="case-study-1.pdf">Download</button>
            </div>
          </div>
          <div class="col-md-4">
            <div class="download-card">
              <div class="download-icon">
                <i class="fas fa-industry"></i>
              </div>
              <h5>Case Study 2</h5>
              <button class="btn-download" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="case-study-2.pdf">Download</button>
            </div>
          </div>
        </div>
      </div>

      <!-- Brochures -->
      <div class="library-section fade-in delay-2">
        <h2>Brochures</h2>
        <p>Download our comprehensive brochures to learn more about our products and services.</p>
        <div class="row g-4 justify-content-center">
          <div class="col-md-4">
            <div class="download-card">
              <div class="download-icon">
                <i class="fas fa-building"></i>
              </div>
              <h5>Company Profile</h5>
              <button class="btn-download" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="company-profile.pdf">Download</button>
            </div>
          </div>
          <div class="col-md-4">
            <div class="download-card">
              <div class="download-icon">
                <i class="fas fa-cogs"></i>
              </div>
              <h5>Products & Services</h5>
              <button class="btn-download" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="products-services.pdf">Download</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ✅ Modal Form -->
  <div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Fill out the form to download</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="fileToDownload">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Company</label>
            <input type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Position</label>
            <input type="text" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Submit & Download</button>
        </div>
      </form>
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
    document.addEventListener('DOMContentLoaded', () => {
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
      
      // Capture which file to download
      let selectedFile = "";
      const modal = document.getElementById("downloadModal");
      modal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;
        selectedFile = button.getAttribute("data-file");
        document.getElementById("fileToDownload").value = selectedFile;
      });

      // Handle form submission
      document.querySelector("#downloadModal form").addEventListener("submit", function(e){
        e.preventDefault();
        const file = document.getElementById("fileToDownload").value;
        // ✅ trigger file download
        window.location.href = "downloads/" + file; // <-- adjust folder path
        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
        this.reset();
      });
    });
  </script>
</body>
</html>