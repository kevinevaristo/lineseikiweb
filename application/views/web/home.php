<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Line Seiki Asia Pacific</title>

  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">

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
* {
  box-sizing: border-box;
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
  width: 100%;
}

hr {
  background: rgba(255, 255, 255, 0.1);
  height: 1px;
}

/* ===============================
   NAVBAR (unchanged)
==================================*/
.navbar {
  background: rgba(255, 255, 255, 0.98);
  backdrop-filter: blur(10px);
  padding: 1rem 0;
  transition: var(--transition);
  border-bottom: 1px solid rgba(13, 110, 253, 0.1);
}

.navbar.scrolled { 
  padding: 0.7rem 0; 
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
  padding: 0.5rem 1rem;
  border-radius: 8px;
  margin: 0 0.2rem;
  font-size: 1rem;
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
   DROPDOWN (unchanged)
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
  font-size: 0.95rem;
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
   SECTIONS (unchanged)
==================================*/
section {
  padding: 100px 0;
  position: relative;
  width: 100%;
  overflow: hidden;
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
  line-height: 1.2;
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
  line-height: 1.7;
}

/* Color Schemes */
.section-white { 
  background: #f2f7fc; 
}

.section-light-blue { 
  background: var(--light-blue); 
  color: #333; 
}

.section-light-orange { 
  background: var(--light-orange); 
  color: #333; 
}

/* ===============================
   BUTTONS (unchanged)
==================================*/
.btn {
  padding: 0.8rem 1.8rem;
  border-radius: 8px;
  font-weight: 600;
  transition: var(--transition);
  position: relative;
  overflow: hidden;
  z-index: 1;
  font-size: 1rem;
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
   HERO CAROUSEL (unchanged)
==================================*/
#heroCarousel {
  background-color: #fff !important;
  position: relative;
  width: 100%;
  margin-top: 90px;
}

#heroCarousel .carousel-item {
  height: 85vh;
  min-height: 600px;
  max-height: 800px;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

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

.hero-slide {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 40px;
  color: white;
  position: relative;
  z-index: 2;
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.hero-text {
  flex: 1;
  max-width: 50%;
}

.hero-text h1 {
  background: white;
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-weight: 700;
  font-size: 3.2rem;
  line-height: 1.2;
  margin-bottom: 20px;
}

.hero-text h1::after {
  content: "";
  display: block;
  width: 60px;
  height: 4px;
  margin-top: 15px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
}

.hero-text p {
  color: #f0f8ff;
  font-size: 1.15rem;
  margin-top: 15px;
  line-height: 1.7;
  text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.hero-image {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.hero-image img {
  max-width: 100%;
  height: auto;
  border-radius: 12px;
  object-fit: contain;
  max-height: 450px;
  transition: transform 0.5s ease;
}

.hero-image.hero-image-big img {
  max-height: 500px;
}

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

#heroCarousel .carousel-control-prev,
#heroCarousel .carousel-control-next {
  display: none !important;
}

/* ===============================
   FOOTER (unchanged)
==================================*/
footer {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  color: white;
  padding: 80px 0 40px;
  position: relative;
  overflow: hidden;
  width: 100%;
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
  font-size: 1.8rem;
}

footer .links a {
  color: #fff;
  text-decoration: none;
  margin-right: 24px;
  position: relative;
  font-weight: 500;
  transition: var(--transition);
  font-size: 1rem;
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
==================================*/
@keyframes fadeIn {
  from { 
    opacity: 0; 
    transform: translateY(10px); 
  }
  to { 
    opacity: 1; 
    transform: translateY(0); 
  }
}

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
.delay-5 { transition-delay: 0.5s; }

/* ===============================
   LEGACY PRODUCTS SECTION (UPDATED)
   Timeline centered above 2‑column photo grid
==================================*/
.legacy-products {
  position: relative;
  background: linear-gradient(135deg, #ffffff 0%, #f8fbff 50%, #eef5ff 100%);
  overflow: hidden;
}

.legacy-products > .container {
  position: relative;
  z-index: 1;
}

.legacy-header {
  text-align: center;
  margin-bottom: 4rem;
  padding: 0 20px;
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
  font-size: 2.5rem;
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
  font-size: 1.2rem;
  line-height: 1.8;
  color: #495057;
  max-width: 800px;
  margin: 0 auto 3rem;
  text-align: center;
  padding: 0 20px;
}

/* --- Timeline (centered, standalone) --- */
.legacy-timeline {
  max-width: 400px;
  margin: 0 auto 3rem auto;  /* centered, with bottom margin */
  background: rgba(255, 255, 255, 0.8);
  border-radius: 20px;
  padding: 2rem;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  border: 1px solid rgba(23, 162, 220, 0.1);
  text-align: center;
}

.timeline-content {
  text-align: center;
  width: 100%;
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

/* --- NEW: 2‑column photo gallery (below timeline) --- */
.legacy-photo-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
  margin: 2rem 0 3rem 0;
  padding: 0 20px;
}

.legacy-photo-card {
  background: white;
  border-radius: 20px;
  padding: 1.5rem;
  box-shadow: 0 15px 35px rgba(15, 70, 123, 0.1);
  border: 1px solid rgba(23, 162, 220, 0.2);
  transition: var(--transition);
  display: flex;
  align-items: center;
  gap: 1.2rem;
}

.legacy-photo-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 25px 45px rgba(15, 70, 123, 0.2);
  border-color: var(--newblue);
}

.legacy-photo-thumb {
  width: 80px;
  height: 80px;
  border-radius: 16px;
  object-fit: cover;
  border: 3px solid rgba(255,255,255,0.5);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  flex-shrink: 0;
  background: var(--light-blue);
}

.legacy-photo-info h5 {
  font-size: 1.1rem;
  font-weight: 700;
  color: var(--newblue2);
  margin-bottom: 0.3rem;
}

.legacy-photo-info p {
  font-size: 0.9rem;
  color: #495057;
  margin-bottom: 0;
  line-height: 1.4;
}

/* Product categories grid (unchanged) */
.product-categories {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin: 4rem 0;
  align-items: stretch;
  padding: 0 20px;
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
  display: flex;
  flex-direction: column;
  height: 100%;
  min-height: 320px;
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
  min-height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.category-card:hover h4 {
  color: var(--newblue);
}

.category-card p {
  color: #6c757d;
  line-height: 1.6;
  margin-bottom: 0;
  font-size: 1rem;
  flex-grow: 1;
  display: flex;
  align-items: center;
}

/* Stats Section (unchanged) */
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

/* CTA and trust badges unchanged */
.legacy-cta {
  text-align: center;
  margin-top: 3rem;
  padding: 0 20px;
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

.trust-badges {
  display: flex;
  justify-content: center;
  gap: 3rem;
  margin-top: 3rem;
  flex-wrap: wrap;
  padding: 0 20px;
}

.trust-badge {
  text-align: center;
  opacity: 0.8;
  transition: all 0.3s ease;
  min-width: 120px;
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

/* ===============================
   SERVICES SECTION (unchanged)
==================================*/
.services-section {
  position: relative;
  background-color: #fff !important;
  overflow: hidden;
  color: white;
}

.services-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%);
  z-index: 0;
}

.services-section > .container {
  position: relative;
  z-index: 1;
}

.services-header {
  text-align: center;
  margin-bottom: 4rem;
  padding: 0 20px;
}

.services-tagline {
  color: rgba(255, 255, 255, 0.9);
  font-size: 1.4rem;
  font-weight: 600;
  margin-bottom: 1rem;
  display: block;
}

.services-section h2 {
  color: white;
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
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
  background: linear-gradient(90deg, rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.4));
  border-radius: 2px;
}

.services-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 2.5rem;
  margin: 3rem 0;
  padding: 0 20px;
}

.service-card-enhanced {
  background: rgba(255, 255, 255, 0.95);
  border-radius: 20px;
  padding: 3rem 2.5rem;
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
  position: relative;
  overflow: hidden;
  height: 100%;
  display: flex;
  flex-direction: column;
  min-height: 500px;
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
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
  border-color: rgba(255, 255, 255, 0.3);
  background: white;
}

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
  min-height: 70px;
  display: flex;
  align-items: center;
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

.service-content {
  flex: 1;
  margin-bottom: 2rem;
}

.service-description {
  color: #495057;
  line-height: 1.7;
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
  min-height: 120px;
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
  font-size: 1rem;
}

.service-features li::before {
  content: '✓';
  position: absolute;
  left: 0;
  color: var(--newblue);
  font-weight: bold;
}

.service-cta {
  margin-top: auto;
  padding-top: 1.5rem;
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

.services-cta-section {
  text-align: center;
  margin-top: 4rem;
  padding: 3rem;
  background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.1));
  border-radius: 20px;
  color: white;
  position: relative;
  overflow: hidden;
  border: 1px solid rgba(255, 255, 255, 0.2);
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

/* ===============================
   NEW PRODUCTS SECTION (unchanged)
==================================*/
.new-products {
  position: relative;
  background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
  overflow: hidden;
}

.new-products > .container {
  position: relative;
  z-index: 1;
}

.new-products .row.align-items-center {
  margin-bottom: 60px;
  padding: 0 20px;
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

.new-products p.lead {
  font-size: 1.2rem;
  line-height: 1.7;
  color: #495057;
  margin-bottom: 2rem;
  max-width: 500px;
}

.new-products .img-fluid {
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(15, 70, 123, 0.15);
  transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
  border: 1px solid rgba(23, 162, 220, 0.1);
  max-width: 100%;
  height: auto;
  max-height: 400px;
  width: auto;
  margin: 0 auto;
  display: block;
}

.new-products .img-fluid:hover {
  transform: translateY(-10px) scale(1.02);
  box-shadow: 0 30px 60px rgba(15, 70, 123, 0.25);
}

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
  height: 100%;
  min-height: 200px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
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
  min-height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.new-prod-feature:hover h6 {
  color: var(--newblue);
}

.new-prod-feature p {
  font-size: 0.9rem;
  color: #6c757d;
  margin-bottom: 0;
  line-height: 1.5;
  flex-grow: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

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

.new-products-cta {
  text-align: left;
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
  display: inline-block;
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

.img-remove-bg {
    background-color: transparent;
    mix-blend-mode: multiply;
    display: block;
    max-width: 100%;
    height: auto;
}

.margin-bottom-20 {
    margin-bottom: 90px;
}

.navbar-nav .nav-link.dropdown-toggle::after {
    display: none !important;
}

/* ===============================
   RESPONSIVE (2‑col grid on mobile)
==================================*/
@media (max-width: 767px) {
  .legacy-photo-grid {
    grid-template-columns: 1fr; /* stack on small screens */
    gap: 1rem;
  }
  .legacy-photo-card {
    flex-direction: column;
    text-align: center;
  }
  .legacy-photo-info h5 {
    justify-content: center;
  }
}
  </style>
  <style>
<?php foreach ($hero['slides'] as $index => $slide): ?>
  <?php if (!empty($slide['hero_bg_img'])): ?>
  #heroCarousel .carousel-item:nth-child(<?php echo $index + 1; ?>) {
    background-image: url('<?= base_url('assets_system/images/' . $slide['hero_bg_img']) ?>');
  }
  <?php endif; ?>
<?php endforeach; ?>
</style>
</head>
<body>

<!-- NAVBAR -->
<?php $this->load->view('web/header'); ?>

<div id="heroCarousel" class="carousel slide carousel-fade fade-in" data-bs-ride="carousel" data-bs-interval="3000">
  <!-- unchanged carousel -->
  <div class="carousel-indicators">
    <?php foreach ($hero['slides'] as $index => $slide): ?>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $index; ?>" 
            class="<?php echo $index === 0 ? 'active' : ''; ?>"></button>
    <?php endforeach; ?>
  </div>

  <div class="carousel-inner">
    <?php foreach ($hero['slides'] as $index => $slide): ?>
    <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
      <div class="hero-slide d-flex align-items-center justify-content-between">
        <div class="hero-text">
          <h1><?php echo !empty($slide['hero_text']) ? $slide['hero_text'] : 'Precision You Can Trust'; ?></h1>
          <p>
            <?php echo !empty($slide['hero_sub_text']) ? $slide['hero_sub_text'] : 'From counting devices to digital manufacturing solutions, we continue to deliver reliable instruments and technologies that help industries move with accuracy and efficiency'; ?>
          </p>
        </div>
        <div class="hero-image <?php echo in_array($index, array(1, 2, 3)) ? 'hero-image-big' : ''; ?>">
          <?php if (!empty($slide['hero_image'])): ?>
          <img src="<?php echo base_url('assets_system/images/' . $slide['hero_image']); ?>" 
               alt="Slide <?php echo $index + 1; ?>"
               class="img-fluid">
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<section class="section-white legacy-products">
  <div class="container">
    <div class="legacy-header fade-in">
      <div class="legacy-badge"><?php echo $legacy['trusted_badge'] ?: 'Trusted Since 1953'; ?></div>
      <h2 class="fw-bold"><?php echo $legacy['legacy_header'] ?: 'Our Proven Line of Counting and Measuring Instruments'; ?></h2>
      <p class="legacy-intro fade-in delay-1">
        <?php echo $legacy['legacy_text'] ?: 'For over 70 years, Line Seiki has been a trusted name in mechanical, electronic, and electromagnetic counters, tachometers, timers, and other precision measuring tools. Built for consistency, accuracy, and durability — these products remain the foundation of our customers\' success in industries around the world.'; ?>
      </p>
    </div>

    <!-- Timeline (centered, standalone) -->
    <div class="legacy-timeline fade-in delay-2">
      <div class="timeline-content">
        <div class="timeline-years"><?php echo $legacy['timeline_years'] ?: '70+'; ?></div>
        <div class="timeline-label"><?php echo $legacy['timeline_label'] ?: 'Years of Excellence'; ?></div>
      </div>
    </div>

    <!-- Achievement Grid from tbl_achievements -->
    <div class="legacy-photo-grid fade-in delay-3">
      <?php if (!empty($achievements)): ?>
        <?php foreach ($achievements as $achievement): ?>
        <div class="legacy-photo-card">
          <?php 
          // Determine which image to use
          $image_url = '';
          if (!empty($achievement['image']) && file_exists(FCPATH . 'assets_system/images/' . $achievement['image'])) {
            $image_url = base_url('assets_system/images/' . $achievement['image']);
          } elseif (!empty($achievement['icon']) && file_exists(FCPATH . 'assets_system/images/' . $achievement['icon'])) {
            $image_url = base_url('assets_system/images/' . $achievement['icon']);
          } else {
            // Create a placeholder with year or first word of title
            $placeholder_text = !empty($achievement['year']) ? $achievement['year'] : substr($achievement['title'], 0, 4);
            $image_url = 'https://via.placeholder.com/80x80/0F467B/ffffff?text=' . urlencode($placeholder_text);
          }
          ?>
          <img src="<?= $image_url ?>" 
               alt="<?= htmlspecialchars($achievement['title']) ?>" 
               class="legacy-photo-thumb"
               onerror="this.src='https://via.placeholder.com/80x80/0F467B/ffffff?text=<?= urlencode(substr($achievement['title'], 0, 4)) ?>'">
          
          <div class="legacy-photo-info">
            <h5>
              <?php if (!empty($achievement['year'])): ?>
                <span class="achievement-year"><?= htmlspecialchars($achievement['year']) ?> – </span>
              <?php endif; ?>
              <?= htmlspecialchars($achievement['title']) ?>
            </h5>
            <p><?= htmlspecialchars($achievement['content']) ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Default fallback achievements if no data in database -->
        <div class="legacy-photo-card">
          <img src="https://via.placeholder.com/80x80/0F467B/ffffff?text=1953" alt="1953 Founding" class="legacy-photo-thumb">
          <div class="legacy-photo-info">
            <h5><span class="achievement-year">1953 – </span>Foundation</h5>
            <p>Line Seiki established in Tokyo, introducing first mechanical counter.</p>
          </div>
        </div>
        <div class="legacy-photo-card">
          <img src="https://via.placeholder.com/80x80/17A2DC/ffffff?text=1975" alt="1975 Expansion" class="legacy-photo-thumb">
          <div class="legacy-photo-info">
            <h5><span class="achievement-year">1975 – </span>Asia Pacific HQ</h5>
            <p>Regional headquarters opened in Singapore, expanding global reach.</p>
          </div>
        </div>
        <div class="legacy-photo-card">
          <img src="https://via.placeholder.com/80x80/0d6efd/ffffff?text=ISO" alt="2000 ISO" class="legacy-photo-thumb">
          <div class="legacy-photo-info">
            <h5><span class="achievement-year">2000 – </span>ISO 9001</h5>
            <p>Attained ISO 9001 certification for quality management systems.</p>
          </div>
        </div>
        <div class="legacy-photo-card">
          <img src="https://via.placeholder.com/80x80/0F467B/ffffff?text=2020" alt="2020 Digital" class="legacy-photo-thumb">
          <div class="legacy-photo-info">
            <h5><span class="achievement-year">2020 – </span>Industry 4.0</h5>
            <p>Launched GEMBA IoT monitoring system for smart manufacturing.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>

    

    <!-- product categories unchanged -->
    <div class="product-categories fade-in delay-3">
    <?php if (!empty($dynamic_categories)): ?>
        <?php foreach ($dynamic_categories as $category): ?>
        <div class="category-card">
            <div class="category-icon">
                <img src="<?= base_url('assets_system/images/' . $category['icon']) ?>" alt="icon" style="width: 40px; height: 40px;">
            </div>
            <h4><?php echo htmlspecialchars($category['title']); ?></h4>
            <p><?php echo htmlspecialchars($category['text']); ?></p>
        </div>
        <?php endforeach; ?>
    <?php elseif (!empty($legacy['categories'])): ?>
        <?php foreach ($legacy['categories'] as $category): ?>
        <div class="category-card">
            <div class="category-icon">
                <i class="fas fa-cogs"></i>
            </div>
            <h4><?php echo $category['title'] ?: 'Category Title'; ?></h4>
            <p><?php echo $category['text'] ?: 'Category description text here.'; ?></p>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="category-card">
            <div class="category-icon"><i class="fas fa-cogs"></i></div>
            <h4>Mechanical Counters</h4>
            <p>Robust mechanical counting solutions for industrial applications requiring reliability and precision.</p>
        </div>
        <div class="category-card">
            <div class="category-icon"><i class="fas fa-bolt"></i></div>
            <h4>Electronic Counters</h4>
            <p>Advanced electronic counting systems with digital displays and programmable features.</p>
        </div>
        <div class="category-card">
            <div class="category-icon"><i class="fas fa-tachometer-alt"></i></div>
            <h4>Tachometers</h4>
            <p>Precision speed measurement instruments for rotational and linear motion applications.</p>
        </div>
        <div class="category-card">
            <div class="category-icon"><i class="fas fa-clock"></i></div>
            <h4>Timers & Controllers</h4>
            <p>Accurate timing devices and control systems for automated industrial processes.</p>
        </div>
    <?php endif; ?>
    </div>

    <div class="legacy-stats fade-in delay-4">
    <?php if (!empty($dynamic_stats)): ?>
        <?php foreach ($dynamic_stats as $stat): ?>
        <div class="stat-item">
            <div class="stat-number"><?php echo htmlspecialchars($stat['stat_number']); ?></div>
            <div class="stat-label"><?php echo htmlspecialchars($stat['stat_label']); ?></div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
    </div>

    <div class="trust-badges fade-in delay-4">
      <div class="trust-badge"><i class="fas fa-award"></i><span>ISO Certified</span></div>
      <div class="trust-badge"><i class="fas fa-shield-alt"></i><span>Quality Assured</span></div>
      <div class="trust-badge"><i class="fas fa-globe"></i><span>Global Reach</span></div>
      <div class="trust-badge"><i class="fas fa-history"></i><span>Proven Track Record</span></div>
    </div>

    <div class="legacy-cta fade-in delay-5">
      <a href="<?php echo base_url('index/ps_prod'); ?>" class="legacy-btn">
        <i class="fas fa-chart-line"></i> Explore Our Product Line
      </a>
    </div>
  </div>
</section>

<!-- rest of sections unchanged (services, new-products, footer) -->
<section class="section-white services-section">
  <!-- (full services section as before) -->
  <div class="container">
    <div class="services-header fade-in">
      <h2 class="fw-bold">Our Solutions</h2>
       <span class="services-tagline"><?php echo $services['tagline'] ?: 'Beyond Measurement — We Engineer Possibilities'; ?></span>
    </div>

    <div class="services-grid">
      <?php if (!empty($services['services'])): ?>
        <?php foreach ($services['services'] as $index => $service): ?>
        <div class="service-card-enhanced fade-in delay-<?php echo $index + 1; ?> <?php echo !empty($service['featured_badge']) ? 'featured' : ''; ?>">
          <?php if (!empty($service['featured_badge'])): ?>
          <div class="featured-badge"><?php echo $service['featured_badge']; ?></div>
          <?php endif; ?>
          <div class="service-header">
            <?php if (!empty($service['image'])): ?>
            <div class="service-icon-wrapper">
              <img src="<?php echo base_url('assets_system/images/' . $service['image']); ?>" alt="<?php echo $service['title'] ?: 'Service Title'; ?>" />
            </div>
            <?php endif; ?>
            <div class="service-title-wrapper">
              <?php if (!empty($service['badge'])): ?>
              <span class="service-badge"><?php echo $service['badge']; ?></span>
              <?php endif; ?>
              <h3><?php echo $service['title'] ?: 'Service Title'; ?></h3>
            </div>
          </div>
          <div class="service-content">
            <p class="service-description"><?php echo $service['description'] ?: 'Service description text here.'; ?></p>
            <?php if (!empty($service['features'])): ?>
            <ul class="service-features">
              <?php foreach ($service['features'] as $feature): ?>
              <li><?php echo $feature; ?></li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </div>
          <div class="service-cta">
            <?php if (!empty($service['link_label'])): ?>
            <a href="<?php 
              echo $index == 0 ? base_url('index/ps_serv_simulation') : 
                    ($index == 1 ? base_url('index/ps_serv_silicone') : 
                    base_url('index/ps_iotsolution')); 
            ?>" class="service-link">
              <span><?php echo $service['link_label']; ?></span>
              <i class="fas fa-arrow-right"></i>
            </a>
            <?php endif; ?>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- default cards -->
        <div class="service-card-enhanced fade-in delay-1 featured">
          <div class="featured-badge">Most Popular</div>
          <div class="service-header">
            <div class="service-icon-wrapper"><img src="<?php echo base_url('assets_system/images/icon_simul.png'); ?>" alt="Simulation" /></div>
            <div class="service-title-wrapper"><span class="service-badge">Advanced Engineering</span><h3>Simulation Analysis Service</h3></div>
          </div>
          <div class="service-content"><p class="service-description">Backed by our expertise in research and development, we provide engineering simulation analysis to validate product designs before physical testing, reducing development time and costs.</p>
            <ul class="service-features"><li>Finite Element Analysis (FEA)</li><li>Computational Fluid Dynamics (CFD)</li><li>Thermal Analysis</li><li>Structural Optimization</li></ul>
          </div>
          <div class="service-cta"><a href="<?php echo base_url('index/ps_serv_simulation'); ?>" class="service-link"><span>Explore Simulation Services</span><i class="fas fa-arrow-right"></i></a></div>
        </div>
        <div class="service-card-enhanced fade-in delay-2">
          <div class="service-header"><div class="service-icon-wrapper"><img src="<?php echo base_url('assets_system/images/icon_sili.png'); ?>" alt="Silicone Molding" /></div><div class="service-title-wrapper"><span class="service-badge">Rapid Prototyping</span><h3>Silicone Molding & Urethane Casting</h3></div></div>
          <div class="service-content"><p class="service-description">Rapid prototyping and low-volume production solutions that accelerate your product development cycle and help you reach market validation faster.</p>
            <ul class="service-features"><li>Quick Turnaround Times</li><li>High-Quality Surface Finish</li><li>Material Variety</li><li>Cost-Effective for Small Batches</li></ul>
          </div>
          <div class="service-cta"><a href="<?php echo base_url('index/ps_serv_silicone'); ?>" class="service-link"><span>Learn About Molding</span><i class="fas fa-arrow-right"></i></a></div>
        </div>
        <div class="service-card-enhanced fade-in delay-3">
          <div class="service-header"><div class="service-icon-wrapper"><img src="<?php echo base_url('assets_system/images/icon_gemba.png'); ?>" alt="GEMBA" /></div><div class="service-title-wrapper"><span class="service-badge">IoT Solution</span><h3>GEMBA Machine Monitoring System</h3></div></div>
          <div class="service-content"><p class="service-description">Track machine status, downtime, and productivity in real time through a comprehensive dashboard that provides actionable insights for operational excellence.</p>
            <ul class="service-features"><li>Real-Time Monitoring</li><li>Downtime Analysis</li><li>Performance Metrics</li><li>Predictive Maintenance</li></ul>
          </div>
          <div class="service-cta"><a href="<?php echo base_url('index/ps_iotsolution'); ?>" class="service-link"><span>Discover GEMBA</span><i class="fas fa-arrow-right"></i></a></div>
        </div>
      <?php endif; ?>
    </div>  

    <div class="services-cta-section fade-in delay-5">
      <h3><?php echo isset($cms_data['cta_heading']['content']) && !empty($cms_data['cta_heading']['content']) ? htmlspecialchars($cms_data['cta_heading']['content']) : 'Ready to Transform Your Operations?'; ?></h3>
      <p><?php echo isset($cms_data['cta_subtitle']['content']) && !empty($cms_data['cta_subtitle']['content']) ? htmlspecialchars($cms_data['cta_subtitle']['content']) : 'Let\'s discuss how our services can drive efficiency and innovation in your business'; ?></p>
      <div class="cta-button-group">
        <a href="<?php echo base_url('index/contact_us'); ?>" class="cta-btn-primary"><i class="fas fa-calendar-check me-2"></i><?php echo isset($cms_data['cta_btn_primary']['content']) && !empty($cms_data['cta_btn_primary']['content']) ? htmlspecialchars($cms_data['cta_btn_primary']['content']) : 'Schedule Consultation'; ?></a>
        <?php
        $brochure_url = isset($cms_data['cta_brochure']['content']) && !empty($cms_data['cta_brochure']['content'])
            ? base_url($cms_data['cta_brochure']['content'])
            : base_url('index/ps_prod');
        $brochure_is_file = isset($cms_data['cta_brochure']['content']) && !empty($cms_data['cta_brochure']['content']);
        $brochure_label = isset($cms_data['cta_btn_brochure']['content']) && !empty($cms_data['cta_btn_brochure']['content'])
            ? htmlspecialchars($cms_data['cta_btn_brochure']['content'])
            : 'Download Brochure';
        ?>
        <a href="<?php echo $brochure_url; ?>" class="cta-btn-secondary" <?php echo $brochure_is_file ? 'target="_blank" download' : ''; ?>><i class="fas fa-download me-2"></i><?php echo $brochure_label; ?></a>
      </div>
    </div>
  </div>
</section>

<section class="section-white new-products">
  <div class="container">
    <div class="feature-decoration feature-decoration-1"></div>
    <div class="feature-decoration feature-decoration-2"></div>
    
    <div class="row align-items-center">
      <div class="col-lg-6 fade-in">
        <?php if (!empty($new_products['badge'])): ?>
        <span class="new-badge"><?php echo $new_products['badge']; ?></span>
        <?php endif; ?>
        <h2 class="fw-bold"><?php echo $new_item->product_name ?? 'New Products'; ?></h2>
        <p class="lead"><?php echo $new_item->description ?? 'Our newest addition, <strong>Safety Switches and Relays</strong>, re-envisioning reliability.';?></p>
        <div class="new-products-cta"><a href="<?= site_url('index/product/' . ($new_item->slug ?? '')) ?>" class="cta-btn"><i class="fas fa-bolt me-2"></i><?= 'Explore ' . ($new_item->product_name ?? 'Safety Solutions'); ?></a></div>
      </div>
      <div class="col-lg-6 text-center fade-in delay-1 margin-bottom-20">
        <?php if (!empty($new_item->product_image)): ?>
        <img src="<?php echo base_url('assets_system/images/' . $new_item->product_image); ?>" alt="<?php echo $new_item->product_name ?? 'Safety Switches and Relays'; ?>" class="img-remove-bg img-fluid">
        <?php endif; ?>
      </div>
    </div>

    <div class="row text-center mt-5 fade-in delay-2">
      <?php if (!empty($new_products['features'])): ?>
        <?php foreach ($new_products['features'] as $feature): ?>
        <div class="col-md-3 col-6 mb-4">
          <div class="new-prod-feature">
            <?php if (!empty($feature['image'])): ?>
            <img src="<?php echo base_url('assets_system/images/' . $feature['image']); ?>" alt="<?php echo $feature['title']; ?>" class="img-fluid mb-3">
            <?php endif; ?>
            <h6 class="fw-semibold"><?php echo $feature['title'] ?: 'Feature Title'; ?></h6>
          </div>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="col-md-3 col-6 mb-4"><div class="new-prod-feature"><img src="<?php echo base_url('assets_system/images/high-dura.png'); ?>" alt="High Durability" class="img-fluid mb-3"><h6 class="fw-semibold">High Durability</h6></div></div>
        <div class="col-md-3 col-6 mb-4"><div class="new-prod-feature"><img src="<?php echo base_url('assets_system/images/high-relia.png'); ?>" alt="High Reliability" class="img-fluid mb-3"><h6 class="fw-semibold">High Reliability</h6></div></div>
        <div class="col-md-3 col-6 mb-4"><div class="new-prod-feature"><img src="<?php echo base_url('assets_system/images/prevent.png'); ?>" alt="Prevent Invalidation" class="img-fluid mb-3"><h6 class="fw-semibold">Prevent Invalidation</h6></div></div>
        <div class="col-md-3 col-6 mb-4"><div class="new-prod-feature"><img src="<?php echo base_url('assets_system/images/excellent.png'); ?>" alt="Dust & Waterproof" class="img-fluid mb-3"><h6 class="fw-semibold">Excellent Dust & Waterproof</h6></div></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php $this->load->view('web/footer'); ?>

<script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>

<script>
  document.addEventListener("DOMContentLoaded", function(){
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function() {
      if (window.scrollY > 50) navbar.classList.add('scrolled'); else navbar.classList.remove('scrolled');
    });
    
    const fadeElements = document.querySelectorAll('.fade-in');
    const fadeObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
    }, { threshold: 0.15 });
    fadeElements.forEach(el => fadeObserver.observe(el));

    // submenu functionality
    document.querySelectorAll('.dropdown-submenu > a').forEach(function(element){
      element.addEventListener('click', function(e){
        e.preventDefault(); e.stopPropagation();
        let submenu = this.nextElementSibling;
        if(submenu) submenu.classList.toggle('show');
        this.closest('.dropdown-menu').querySelectorAll('.show').forEach(openMenu => { if(openMenu !== submenu) openMenu.classList.remove('show'); });
      });
    });
    document.addEventListener('click', function(){
      document.querySelectorAll('.dropdown-menu .show').forEach(openMenu => openMenu.classList.remove('show'));
    });

    function adjustImages() {
      const heroImages = document.querySelectorAll('.hero-image img');
      heroImages.forEach(img => { if (window.innerWidth <= 991) img.style.maxHeight = '300px'; else img.style.maxHeight = ''; });
      const newProductImg = document.querySelector('.new-products .img-fluid');
      if (newProductImg) {
        if (window.innerWidth <= 767) newProductImg.style.maxHeight = '250px';
        else if (window.innerWidth <= 991) newProductImg.style.maxHeight = '350px';
        else newProductImg.style.maxHeight = '400px';
      }
    }
    adjustImages();
    window.addEventListener('resize', adjustImages);
  });
</script>
</body>
</html>