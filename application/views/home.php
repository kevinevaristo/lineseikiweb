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
.section-white { background: #f2f7fc }
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
   CAROUSEL BACKGROUND WITH OVERLAY
==================================*/
#heroCarousel {
  background-color: #fff !important;
  position: relative;
}

#heroCarousel .carousel-item {
  height: 100vh;
  min-height: 600px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

/* Add blue overlay to each carousel item */
#heroCarousel .carousel-item::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%);
  z-index: 1;
}

/* Individual slide backgrounds */
#heroCarousel .carousel-item:nth-child(1) {
  background-image: url('<?= base_url('assets_system/images/m-and-v.jpg') ?>');
}

#heroCarousel .carousel-item:nth-child(2) {
  background-image: url('<?= base_url('assets_system/images/Hero.jpg') ?>');
}

#heroCarousel .carousel-item:nth-child(3) {
  background-image: url('<?= base_url('assets_system/images/simulation2.jpg') ?>');
}

#heroCarousel .carousel-item:nth-child(4) {
  background-image: url('<?= base_url('assets_system/images/strict.jpg') ?>');
}

/* Ensure content stays above overlay */
.hero-slide {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 50px;
  color: white; /* Change text to white for better contrast */
  position: relative;
  z-index: 2;
}

.hero-text {
  flex: 1;
  max-width: 50%;
}

.hero-text h1 {
  background: white; /* Light gradient for white text */
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 700;
  font-size: 3.2rem;
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
  color: #f0f8ff; /* Light blue-white for better readability */
  font-size: 1.1rem;
  margin-top: 15px;
  line-height: 1.6;
  text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.hero-image {
  flex: 1;
  display: flex;
  justify-content: flex-end;
}

.hero-image img {
  max-width: 100%;
  height: auto;
  border-radius: 12px;
  transform: scale(1.1); 
  object-fit: cover;
  transition: transform 0.5s ease;
}

/* Make carousel indicators more visible against dark background */
#heroCarousel .carousel-indicators [data-bs-target] {
  background-color: #ffffff;
  width: 25px;
  height: 5px;
  border-radius: 10%;
  opacity: 0.6;
  transition: 0.3s ease;
  border: none;
}

#heroCarousel .carousel-indicators .active {
  opacity: 1;
  background-color: var(--newblue);
  transform: scale(1.2);
}

/* Responsive adjustments */
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
   CAROUSEL INDICATORS (BLUE)
==================================*


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
/* ===============================
   UPGRADED NEW PRODUCTS SECTION
==================================*/
.new-products {
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
}

.new-products::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    radial-gradient(circle at 20% 80%, rgba(23, 162, 220, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(15, 70, 123, 0.03) 0%, transparent 50%);
  z-index: 0;
}

.new-products > .container {
  position: relative;
  z-index: 1;
}

/* Main Content Styling */
.new-products .row.align-items-center {
  margin-bottom: 60px;
}

.new-products h2 {
  position: relative;
  display: inline-block;
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

.new-products h2::after {
  content: "";
  position: absolute;
  bottom: -15px;
  left: 0;
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue2), var(--newblue));
  border-radius: 2px;
}

.new-products p {
  font-size: 1.2rem;
  line-height: 1.7;
  color: #495057;
  margin-bottom: 2rem;
  max-width: 500px;
}

/* Product Image Enhancement */
.new-products .img-fluid {
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(15, 70, 123, 0.15);
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
  border: 1px solid rgba(23, 162, 220, 0.1);
}

.new-products .img-fluid:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 30px 60px rgba(15, 70, 123, 0.25);
}

/* Feature Boxes Enhancement */
.new-prod-feature {
  background: white;
  border-radius: 16px;
  padding: 2rem 1.5rem;
  text-align: center;
  transition: all 0.3s ease;
  border: 1px solid rgba(23, 162, 220, 0.1);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
  position: relative;
  overflow: hidden;
}

.new-prod-feature::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(23, 162, 220, 0.05), transparent);
  transition: left 0.6s ease;
}

.new-prod-feature:hover::before {
  left: 100%;
}

.new-prod-feature:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(15, 70, 123, 0.15);
  border-color: rgba(23, 162, 220, 0.3);
}

.new-prod-feature img {
  width: 80px;
  height: 80px;
  object-fit: contain;
  border-radius: 16px;
  background: linear-gradient(135deg, var(--light-blue), #ffffff);
  padding: 15px;
  margin-bottom: 1.5rem;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.new-prod-feature:hover img {
  transform: scale(1.1) rotate(5deg);
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  border-color: rgba(23, 162, 220, 0.2);
}

.new-prod-feature h6 {
  font-size: 1.1rem;
  font-weight: 600;
  color: var(--newblue2);
  margin-bottom: 0.5rem;
  transition: color 0.3s ease;
}

.new-prod-feature:hover h6 {
  color: var(--newblue);
}

.new-prod-feature p {
  font-size: 0.9rem;
  color: #6c757d;
  margin-bottom: 0;
  line-height: 1.5;
}

/* Add decorative elements */
.feature-decoration {
  position: absolute;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  background: linear-gradient(135deg, rgba(23, 162, 220, 0.1), rgba(15, 70, 123, 0.05));
  filter: blur(40px);
  z-index: 0;
}

.feature-decoration-1 {
  top: 10%;
  left: 5%;
}

.feature-decoration-2 {
  bottom: 10%;
  right: 5%;
}

/* Call to Action Button */
.new-products-cta {
  text-align: center;
  margin-top: 3rem;
}

.cta-btn {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  color: white;
  border: none;
  padding: 1rem 2.5rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1.1rem;
  transition: all 0.3s ease;
  box-shadow: 0 10px 25px rgba(15, 70, 123, 0.3);
  position: relative;
  overflow: hidden;
}

.cta-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.6s ease;
}

.cta-btn:hover::before {
  left: 100%;
}

.cta-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 35px rgba(15, 70, 123, 0.4);
}

/* Badge for "New" */
.new-badge {
  background: linear-gradient(135deg, #ff6b6b, #ee5a24);
  color: white;
  padding: 0.3rem 1rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  display: inline-block;
  margin-bottom: 1rem;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}

/* Responsive Design */
@media (max-width: 768px) {
  .new-products h2 {
    font-size: 2rem;
    text-align: center;
  }
  
  .new-products h2::after {
    left: 50%;
    transform: translateX(-50%);
  }
  
  .new-prod-feature {
    padding: 1.5rem 1rem;
    margin-bottom: 1rem;
  }
  
  .new-prod-feature img {
    width: 60px;
    height: 60px;
  }
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
/* ===============================
   UPGRADED LEGACY PRODUCTS SECTION
==================================*/
.legacy-products {
  position: relative;
  background: linear-gradient(135deg, #ffffff 0%, #f8fbff 50%, #eef5ff 100%);
  overflow: hidden;
}

.legacy-products::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    radial-gradient(circle at 10% 20%, rgba(15, 70, 123, 0.03) 0%, transparent 50%),
    radial-gradient(circle at 90% 80%, rgba(23, 162, 220, 0.02) 0%, transparent 50%);
  z-index: 0;
}

.legacy-products > .container {
  position: relative;
  z-index: 1;
}

/* Main Content Styling */
.legacy-header {
  text-align: center;
  margin-bottom: 4rem;
}

.legacy-badge {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 25px;
  font-size: 0.9rem;
  font-weight: 600;
  display: inline-block;
  margin-bottom: 1.5rem;
  box-shadow: 0 5px 15px rgba(15, 70, 123, 0.3);
}

.legacy-products h2 {
  font-size: 2.8rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  background: linear-gradient(135deg, var(--newblue2), var(--primary-blue));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  position: relative;
  display: inline-block;
}

.legacy-products h2::after {
  content: "";
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  width: 100px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue2), var(--newblue));
  border-radius: 2px;
}

.legacy-intro {
  font-size: 1.3rem;
  line-height: 1.8;
  color: #495057;
  max-width: 800px;
  margin: 0 auto 3rem;
  text-align: center;
}

/* Timeline/History Element */
.legacy-timeline {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 3rem auto;
  padding: 2rem;
  background: rgba(255, 255, 255, 0.8);
  border-radius: 20px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(23, 162, 220, 0.1);
  max-width: 400px;
}

.timeline-content {
  text-align: center;
}

.timeline-years {
  font-size: 3rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  line-height: 1;
  margin-bottom: 0.5rem;
}

.timeline-label {
  font-size: 1.1rem;
  color: var(--newblue2);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 1px;
}

/* Product Categories Grid */
.product-categories {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  margin: 4rem 0;
}

.category-card {
  background: white;
  padding: 2.5rem 2rem;
  border-radius: 16px;
  text-align: center;
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
  border: 1px solid rgba(23, 162, 220, 0.1);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
  position: relative;
  overflow: hidden;
}

.category-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(23, 162, 220, 0.05), transparent);
  transition: left 0.6s ease;
}

.category-card:hover::before {
  left: 100%;
}

.category-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(15, 70, 123, 0.15);
  border-color: rgba(23, 162, 220, 0.3);
}

.category-icon {
  width: 80px;
  height: 80px;
  margin: 0 auto 1.5rem;
  background: linear-gradient(135deg, var(--light-blue), #ffffff);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  border: 2px solid transparent;
}

.category-card:hover .category-icon {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  transform: scale(1.1) rotate(5deg);
}

.category-icon i {
  font-size: 2rem;
  color: var(--newblue2);
  transition: all 0.3s ease;
}

.category-card:hover .category-icon i {
  color: white;
}

.category-card h4 {
  font-size: 1.3rem;
  font-weight: 600;
  color: var(--newblue2);
  margin-bottom: 1rem;
  transition: color 0.3s ease;
}

.category-card:hover h4 {
  color: var(--newblue);
}

.category-card p {
  color: #6c757d;
  line-height: 1.6;
  margin-bottom: 0;
}

/* Stats Section */
.legacy-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 2rem;
  margin: 4rem 0;
  padding: 3rem;
  background: linear-gradient(135deg, rgba(15, 70, 123, 0.05), rgba(23, 162, 220, 0.03));
  border-radius: 20px;
  border: 1px solid rgba(23, 162, 220, 0.1);
}

.stat-item {
  text-align: center;
  padding: 1.5rem;
}

.stat-number {
  font-size: 3rem;
  font-weight: 800;
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  line-height: 1;
  margin-bottom: 0.5rem;
}

.stat-label {
  font-size: 1rem;
  color: var(--newblue2);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

/* Enhanced CTA Button */
.legacy-cta {
  text-align: center;
  margin-top: 3rem;
}

.legacy-btn {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  color: white;
  border: none;
  padding: 1.2rem 3rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1.2rem;
  transition: all 0.4s ease;
  box-shadow: 0 10px 30px rgba(15, 70, 123, 0.3);
  position: relative;
  overflow: hidden;
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
}

.legacy-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.6s ease;
}

.legacy-btn:hover::before {
  left: 100%;
}

.legacy-btn:hover {
  transform: translateY(-5px) scale(1.05);
  box-shadow: 0 20px 40px rgba(15, 70, 123, 0.4);
}

/* Trust Badges */
.trust-badges {
  display: flex;
  justify-content: center;
  gap: 3rem;
  margin-top: 3rem;
  flex-wrap: wrap;
}

.trust-badge {
  text-align: center;
  opacity: 0.8;
  transition: all 0.3s ease;
}

.trust-badge:hover {
  opacity: 1;
  transform: scale(1.1);
}

.trust-badge i {
  font-size: 2.5rem;
  color: var(--newblue);
  margin-bottom: 0.5rem;
}

.trust-badge span {
  display: block;
  font-size: 0.9rem;
  color: var(--newblue2);
  font-weight: 600;
}

/* Responsive Design */
@media (max-width: 768px) {
  .legacy-products h2 {
    font-size: 2.2rem;
  }
  
  .legacy-intro {
    font-size: 1.1rem;
  }
  
  .timeline-years {
    font-size: 2.5rem;
  }
  
  .product-categories {
    grid-template-columns: 1fr;
    gap: 1.5rem;
  }
  
  .category-card {
    padding: 2rem 1.5rem;
  }
  
  .legacy-stats {
    grid-template-columns: repeat(2, 1fr);
    padding: 2rem;
    gap: 1.5rem;
  }
  
  .stat-number {
    font-size: 2.5rem;
  }
  
  .trust-badges {
    gap: 2rem;
  }
}
/* ===============================
   UPGRADED OUR SERVICES SECTION
==================================*/
.services-section {
  position: relative;
  background: linear-gradient(135deg, #f8fbff 0%, #ffffff 50%, #f0f7ff 100%);
  overflow: hidden;
}

.services-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    radial-gradient(circle at 20% 30%, rgba(23, 162, 220, 0.05) 0%, transparent 50%),
    radial-gradient(circle at 80% 70%, rgba(15, 70, 123, 0.03) 0%, transparent 50%);
  z-index: 0;
}

.services-section > .container {
  position: relative;
  z-index: 1;
}

/* Header Styling */
.services-header {
  text-align: center;
  margin-bottom: 4rem;
}

.services-tagline {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-size: 1.4rem;
  font-weight: 600;
  margin-bottom: 1rem;
  display: block;
}

.services-section h2 {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  background: linear-gradient(135deg, var(--newblue2), var(--primary-blue));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  position: relative;
  display: inline-block;
}

.services-section h2::after {
  content: "";
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  width: 120px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue2), var(--newblue));
  border-radius: 2px;
}

/* Enhanced Service Cards */
.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 2.5rem;
  margin: 3rem 0;
}

.service-card-enhanced {
  background: white;
  border-radius: 20px;
  padding: 3rem 2.5rem;
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
  border: 1px solid rgba(23, 162, 220, 0.1);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  position: relative;
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.service-card-enhanced::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(23, 162, 220, 0.05), transparent);
  transition: left 0.6s ease;
}

.service-card-enhanced:hover::before {
  left: 100%;
}

.service-card-enhanced:hover {
  transform: translateY(-12px);
  box-shadow: 0 25px 50px rgba(15, 70, 123, 0.15);
  border-color: rgba(23, 162, 220, 0.3);
}

/* Service Header with Icon */
.service-header {
  display: flex;
  align-items: flex-start;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.service-icon-wrapper {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--light-blue), #ffffff);
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
  transition: all 0.3s ease;
  border: 2px solid transparent;
  position: relative;
  overflow: hidden;
}

.service-card-enhanced:hover .service-icon-wrapper {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  transform: scale(1.1) rotate(5deg);
}

.service-icon-wrapper img {
  width: 40px;
  height: 40px;
  object-fit: contain;
  transition: all 0.3s ease;
}

.service-card-enhanced:hover .service-icon-wrapper img {
  filter: brightness(0) invert(1);
}

.service-title-wrapper {
  flex: 1;
}

.service-card-enhanced h3 {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--newblue2);
  margin-bottom: 0.5rem;
  transition: color 0.3s ease;
}

.service-card-enhanced:hover h3 {
  color: var(--newblue);
}

.service-badge {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  color: white;
  padding: 0.3rem 1rem;
  border-radius: 15px;
  font-size: 0.8rem;
  font-weight: 600;
  display: inline-block;
  margin-bottom: 0.5rem;
}

/* Service Content */
.service-content {
  flex: 1;
  margin-bottom: 2rem;
}

.service-description {
  color: #495057;
  line-height: 1.7;
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
}

.service-features {
  list-style: none;
  padding: 0;
  margin: 0;
}

.service-features li {
  padding: 0.5rem 0;
  color: #6c757d;
  position: relative;
  padding-left: 1.5rem;
}

.service-features li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: var(--newblue);
  font-weight: bold;
}

/* Enhanced CTA Button */
.service-cta {
  margin-top: auto;
}

.service-link {
  display: inline-flex;
  align-items: center;
  gap: 0.8rem;
  color: var(--newblue2);
  font-weight: 600;
  text-decoration: none;
  padding: 0.8rem 1.5rem;
  border: 2px solid var(--newblue);
  border-radius: 50px;
  transition: all 0.3s ease;
  background: transparent;
  position: relative;
  overflow: hidden;
}

.service-link::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(23, 162, 220, 0.1), transparent);
  transition: left 0.6s ease;
}

.service-link:hover::before {
  left: 100%;
}

.service-link:hover {
  background: var(--newblue);
  color: white;
  transform: translateX(8px);
  box-shadow: 0 8px 20px rgba(23, 162, 220, 0.3);
}

.service-link i {
  transition: transform 0.3s ease;
}

.service-link:hover i {
  transform: translateX(4px);
}

/* Special Highlights */
.service-card-enhanced.featured {
  border: 2px solid var(--newblue);
  background: linear-gradient(135deg, #ffffff, #f8fbff);
}

.featured-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  background: linear-gradient(135deg, #ff6b6b, #ee5a24);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
}

/* CTA Section */
.services-cta-section {
  text-align: center;
  margin-top: 4rem;
  padding: 3rem;
  background: linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%);
  border-radius: 20px;
  color: white;
  position: relative;
  overflow: hidden;
}

.services-cta-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='1' fill='%23FFFFFF' opacity='0.1'/%3E%3C/svg%3E");
}

.services-cta-section h3 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 1rem;
  position: relative;
  z-index: 1;
}

.services-cta-section p {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  opacity: 0.9;
  position: relative;
  z-index: 1;
  color: white;
}

.cta-button-group {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
  position: relative;
  z-index: 1;
}

.cta-btn-primary {
  background: white;
  color: var(--newblue2);
  border: none;
  padding: 1rem 2.5rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1.1rem;
  transition: all 0.3s ease;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
}

.cta-btn-primary:hover {
  transform: translateY(-3px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
}

.cta-btn-secondary {
  background: transparent;
  color: white;
  border: 2px solid white;
  padding: 1rem 2.5rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1.1rem;
  transition: all 0.3s ease;
}

.cta-btn-secondary:hover {
  background: white;
  color: var(--newblue2);
  transform: translateY(-3px);
}

/* Responsive Design */
@media (max-width: 768px) {
  .services-section h2 {
    font-size: 2.2rem;
  }
  
  .services-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .service-card-enhanced {
    padding: 2rem 1.5rem;
  }
  
  .service-header {
    flex-direction: column;
    text-align: center;
    gap: 1rem;
  }
  
  .service-icon-wrapper {
    margin: 0 auto;
  }
  
  .cta-button-group {
    flex-direction: column;
    align-items: center;
  }
  
  .cta-btn-primary,
  .cta-btn-secondary {
    width: 100%;
    max-width: 300px;
  }
}
/* ===============================
   UPGRADED OUR SERVICES SECTION
==================================*/
.services-section {
  position: relative;
  background-color: #fff !important;
  overflow: hidden;
  color: white;
}

/* Add background image and overlay like the hero section */
.services-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    /* Background image - you can change this URL */
    url('<?= base_url('assets_system/images/simulation2.jpg') ?>'),
    /* Blue overlay */
    linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  background-blend-mode: overlay;
  z-index: 0;
}

/* Alternative: If you want multiple background images like the carousel */
.services-section.alternative-bg::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%);
  z-index: 0;
}

.services-section > .container {
  position: relative;
  z-index: 1;
}

/* Update text colors for better contrast on blue background */
.services-section .services-tagline {
  color: rgba(255, 255, 255, 0.9);
  -webkit-text-fill-color: rgba(255, 255, 255, 0.9);
}

.services-section h2 {
  color: white;
  -webkit-text-fill-color: white;
}

.services-section h2::after {
  background: linear-gradient(90deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.4)) !important;
}

/* Update service cards for better visibility on blue background */
.service-card-enhanced {
  background: rgba(255, 255, 255, 0.95);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.service-card-enhanced:hover {
  background: white;
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
}

/* Update CTA section for better contrast */
.services-cta-section {
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.services-cta-section::before {
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='1' fill='%23FFFFFF' opacity='0.2'/%3E%3C/svg%3E");
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
<div id="heroCarousel" class="carousel slide carousel-fade fade-in" data-bs-ride="carousel" data-bs-interval="3000">

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
          <img src=<?= base_url('assets_system/images/Legacy2new.png') ?> alt="Slide 1">
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
          <img src=<?= base_url('assets_system/images/Gemba-hero2new.png') ?> alt="Slide 3">
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



   <!-- Enhanced Legacy Products Section -->
<section class="section-white legacy-products">
  <div class="container">
    <!-- Header Section -->
    <div class="legacy-header fade-in">
      <div class="legacy-badge">Trusted Since 1953</div>
      <h2 class="fw-bold">Our Proven Line of Counting and Measuring Instruments</h2>
      <p class="legacy-intro fade-in delay-1">
        For over 70 years, Line Seiki has been a trusted name in mechanical, electronic, and electromagnetic counters, 
        tachometers, timers, and other precision measuring tools. Built for consistency, accuracy, and durability — 
        these products remain the foundation of our customers' success in industries around the world.
      </p>
    </div>

    <!-- Timeline Element -->
    <div class="legacy-timeline fade-in delay-2">
      <div class="timeline-content">
        <div class="timeline-years">70+</div>
        <div class="timeline-label">Years of Excellence</div>
      </div>
    </div>

    <!-- Product Categories -->
    <div class="product-categories fade-in delay-3">
      <div class="category-card">
        <div class="category-icon">
          <i class="fas fa-cogs"></i>
        </div>
        <h4>Mechanical Counters</h4>
        <p>Robust mechanical counting solutions for industrial applications requiring reliability and precision.</p>
      </div>

      <div class="category-card">
        <div class="category-icon">
          <i class="fas fa-bolt"></i>
        </div>
        <h4>Electronic Counters</h4>
        <p>Advanced electronic counting systems with digital displays and programmable features.</p>
      </div>

      <div class="category-card">
        <div class="category-icon">
          <i class="fas fa-tachometer-alt"></i>
        </div>
        <h4>Tachometers</h4>
        <p>Precision speed measurement instruments for rotational and linear motion applications.</p>
      </div>

      <div class="category-card">
        <div class="category-icon">
          <i class="fas fa-clock"></i>
        </div>
        <h4>Timers & Controllers</h4>
        <p>Accurate timing devices and control systems for automated industrial processes.</p>
      </div>
    </div>

    <!-- Statistics -->
    <div class="legacy-stats fade-in delay-4">
      <div class="stat-item">
        <div class="stat-number">50K+</div>
        <div class="stat-label">Products Installed</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">100+</div>
        <div class="stat-label">Countries Served</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">99.7%</div>
        <div class="stat-label">Customer Satisfaction</div>
      </div>
      <div class="stat-item">
        <div class="stat-number">24/7</div>
        <div class="stat-label">Global Support</div>
      </div>
    </div>

    <!-- Trust Badges -->
    <div class="trust-badges fade-in delay-4">
      <div class="trust-badge">
        <i class="fas fa-award"></i>
        <span>ISO Certified</span>
      </div>
      <div class="trust-badge">
        <i class="fas fa-shield-alt"></i>
        <span>Quality Assured</span>
      </div>
      <div class="trust-badge">
        <i class="fas fa-globe"></i>
        <span>Global Reach</span>
      </div>
      <div class="trust-badge">
        <i class="fas fa-history"></i>
        <span>Proven Track Record</span>
      </div>
    </div>

    <!-- Call to Action -->
    <div class="legacy-cta fade-in delay-5">
      <a href="<?= base_url('index/ps_prod') ?>" class="legacy-btn">
        <i class="fas fa-chart-line"></i>
        Explore Our Product Line
      </a>
    </div>
  </div>
</section>
     <!-- Enhanced Our Services Section -->
<section class="section-white services-section">
  <div class="container">
    <!-- Header -->
    <div class="services-header fade-in">
      <h2 class="fw-bold">Our Services</h2>
       <span class="services-tagline">Beyond Measurement — We Engineer Possibilities</span>
    </div>

    <!-- Services Grid -->
    <div class="services-grid">
      <!-- Simulation Analysis Service -->
      <div class="service-card-enhanced fade-in delay-1 featured">
        <div class="featured-badge">Most Popular</div>
        <div class="service-header">
          <div class="service-icon-wrapper">
            <img src="<?= base_url('assets_system/images/icon_simul.png') ?>" alt="Simulation Analysis" />
          </div>
          <div class="service-title-wrapper">
            <span class="service-badge">Advanced Engineering</span>
            <h3>Simulation Analysis Service</h3>
          </div>
        </div>
        <div class="service-content">
          <p class="service-description">
            Backed by our expertise in research and development, we provide engineering simulation analysis 
            to validate product designs before physical testing, reducing development time and costs.
          </p>
          <ul class="service-features">
            <li>Finite Element Analysis (FEA)</li>
            <li>Computational Fluid Dynamics (CFD)</li>
            <li>Thermal Analysis</li>
            <li>Structural Optimization</li>
          </ul>
        </div>
        <div class="service-cta">
          <a href="<?= base_url('index/ps_serv_simulation') ?>" class="service-link">
            <span>Explore Simulation Services</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- Silicone Molding Service -->
      <div class="service-card-enhanced fade-in delay-2">
        <div class="service-header">
          <div class="service-icon-wrapper">
            <img src="<?= base_url('assets_system/images/icon_sili.png') ?>" alt="Silicone Molding" />
          </div>
          <div class="service-title-wrapper">
            <span class="service-badge">Rapid Prototyping</span>
            <h3>Silicone Molding & Urethane Casting</h3>
          </div>
        </div>
        <div class="service-content">
          <p class="service-description">
            Rapid prototyping and low-volume production solutions that accelerate your product development 
            cycle and help you reach market validation faster.
          </p>
          <ul class="service-features">
            <li>Quick Turnaround Times</li>
            <li>High-Quality Surface Finish</li>
            <li>Material Variety</li>
            <li>Cost-Effective for Small Batches</li>
          </ul>
        </div>
        <div class="service-cta">
          <a href="<?= base_url('index/ps_serv_silicone') ?>" class="service-link">
            <span>Learn About Molding</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>

      <!-- GEMBA Monitoring System -->
      <div class="service-card-enhanced fade-in delay-3">
        <div class="service-header">
          <div class="service-icon-wrapper">
            <img src="<?= base_url('assets_system/images/icon_gemba.png') ?>" alt="GEMBA Monitoring" />
          </div>
          <div class="service-title-wrapper">
            <span class="service-badge">IoT Solution</span>
            <h3>GEMBA Machine Monitoring System</h3>
          </div>
        </div>
        <div class="service-content">
          <p class="service-description">
            Track machine status, downtime, and productivity in real time through a comprehensive dashboard 
            that provides actionable insights for operational excellence.
          </p>
          <ul class="service-features">
            <li>Real-Time Monitoring</li>
            <li>Downtime Analysis</li>
            <li>Performance Metrics</li>
            <li>Predictive Maintenance</li>
          </ul>
        </div>
        <div class="service-cta">
          <a href="<?= base_url('index/ps_iotsolution') ?>" class="service-link">
            <span>Discover GEMBA</span>
            <i class="fas fa-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>  

    <!-- CTA Section -->
    <div class="services-cta-section fade-in delay-5">
      <h3>Ready to Transform Your Operations?</h3>
      <p>Let's discuss how our services can drive efficiency and innovation in your business</p>
      <div class="cta-button-group">
        <a href="<?= base_url('index/contact_us') ?>" class="cta-btn-primary">
          <i class="fas fa-calendar-check me-2"></i>Schedule Consultation
        </a>
        <a href="<?= base_url('index/ps_prod') ?>" class="cta-btn-secondary">
          <i class="fas fa-download me-2"></i>Download Brochure
        </a>
      </div>
    </div>
  </div>
</section>

<!-- Enhanced New Products Section -->
<section class="section-white new-products">
  <div class="container">
    <!-- Decorative Elements -->
    <div class="feature-decoration feature-decoration-1"></div>
    <div class="feature-decoration feature-decoration-2"></div>
    
    <div class="row align-items-center">
      <!-- Left text content -->
      <div class="col-lg-6 fade-in">
        <span class="new-badge">NEW ARRIVAL</span>
        <h2 class="fw-bold">New Products</h2>
        <p class="lead">
          Our newest addition, <strong>Safety Switches and Relays</strong>, reinforces our commitment
          to smarter and safer manufacturing environments with cutting-edge technology and uncompromising reliability.
        </p>
        <div class="new-products-cta">
          <button class="cta-btn">
            <i class="fas fa-bolt me-2"></i>Explore Safety Solutions
          </button>
        </div>
      </div>
      
      <!-- Right image content -->
      <div class="col-lg-6 text-center fade-in delay-1">
        <img src="<?= base_url('assets_system/images/new_prod.png') ?>" alt="Safety Switches and Relays" class="img-fluid rounded shadow">
      </div>
    </div>

    <!-- Enhanced Feature Boxes -->
    <div class="row text-center mt-5 fade-in delay-2">
      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src="<?= base_url('assets_system/images/high-dura.png') ?>" alt="High Durability" class="img-fluid mb-3">
          <h6 class="fw-semibold">High Durability</h6>
          
        </div>
      </div>

      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src="<?= base_url('assets_system/images/high-relia.png') ?>" alt="High Reliability" class="img-fluid mb-3">
          <h6 class="fw-semibold">High Reliability</h6>
          
        </div>
      </div>

      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src="<?= base_url('assets_system/images/prevent.png') ?>" alt="Prevent Invalidation" class="img-fluid mb-3">
          <h6 class="fw-semibold">Prevent Invalidation</h6>
        
        </div>
      </div>

      <div class="col-md-3 col-6 mb-4">
        <div class="new-prod-feature">
          <img src="<?= base_url('assets_system/images/excellent.png') ?>" alt="Dust & Waterproof" class="img-fluid mb-3">
          <h6 class="fw-semibold">Excellent Dust & Waterproof</h6>
      
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