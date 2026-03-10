<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us - Line Seiki Asia Pacific</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">

  <!-- Google Fonts -->
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">

  <style>
/* =========================
   Root Variables
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
   Base Styles
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
}

hr {
  background: rgba(255, 255, 255, 0.1);
  height: 1px;
}

/* =========================
   Navbar
========================= */
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

.navbar-nav > li:nth-child(3) > .dropdown-toggle::after {
    display: none !important;
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

/* =========================
   MODERN CONTACT SECTIONS
========================= */

/* Modern Header Section with Background Image */
.contact-hero {
  background: 
    /* Blue overlay */
    linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
    /* Background image */
    url('<?= base_url('assets_system/images/newlaunch4.jpg') ?>') center/cover no-repeat;
  color: white;
  padding: 150px 0 100px;
  position: relative;
  overflow: hidden;
  min-height: 70vh;
  display: flex;
  align-items: center;
}

.contact-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
}

.contact-hero-content {
  position: relative;
  z-index: 2;
}

.contact-hero h1 {
  font-size: 3.5rem;
  font-weight: 800;
  margin-bottom: 25px;
  color: white;
  text-transform: uppercase;
  letter-spacing: -0.5px;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.contact-hero .lead {
  font-size: 1.3rem;
  opacity: 0.95;
  text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  max-width: 800px;
  margin: 0 auto;
}

/* Modern Contact Information Section */
.contact-info-section {
  background: linear-gradient(135deg, var(--light-blue) 0%, #fff 100%);
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.contact-info-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2317A2DC' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  z-index: 0;
}

.contact-info-container {
  position: relative;
  z-index: 1;
}

.contact-info-section h2 {
  font-size: 3rem;
  color: var(--newblue2);
  font-weight: 800;
  margin-bottom: 60px;
  text-align: center;
  position: relative;
}

.contact-info-section h2::after {
  content: '';
  position: absolute;
  bottom: -20px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
}

/* Modern Contact Cards */
.contact-info-card {
  background: white;
  border-radius: 20px;
  padding: 40px 30px;
  text-align: center;
  transition: var(--transition);
  height: 100%;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
  border: none;
  position: relative;
  overflow: hidden;
}

.contact-info-card::before {
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

.contact-info-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
}

.contact-info-card:hover::before {
  transform: scaleX(1);
}

.contact-info-card i {
  font-size: 3rem;
  color: var(--newblue);
  margin-bottom: 25px;
  transition: var(--transition);
}

.contact-info-card:hover i {
  transform: scale(1.1);
  color: var(--primary-blue);
}

.contact-info-card h5 {
  color: var(--newblue2);
  font-weight: 700;
  margin-bottom: 20px;
  font-size: 1.4rem;
}

.contact-info-card p {
  color: #495057;
  margin-bottom: 0;
  font-size: 1.1rem;
  line-height: 1.6;
}




/* =========================
   WAVY BACKGROUND + GLASS FORM MIX
========================= */

/* --- 1. RESTORED WAVY BACKGROUND STYLES --- */
.contact-form-section {
  /* Original Blue Gradient */
  background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
  color: white;
  padding: 100px 0;
  position: relative;
  overflow: hidden;
  min-height: 700px;
  display: flex;
  align-items: center;
}

/* The Wavy SVGs */
.contact-form-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff' fill-opacity='0.1'%3E%3C/path%3E%3C/svg%3E"),
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%23ffffff' fill-opacity='0.05'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  z-index: 1;
  animation: waveMove 15s ease-in-out infinite alternate;
}

/* The Floating Circles */
.contact-form-section::after{
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(255,255,255,0.08) 0%, transparent 50%);
  z-index: 1;
  /* Ensure float animation is defined elsewhere in your CSS, or re-add it here */
}

.contact-form-container {
  position: relative;
  z-index: 2; /* Ensures form sits above the waves */
  width: 100%;
}

/* Title Styling */
.contact-form-section h2 {
  font-size: 2.8rem;
  font-weight: 700;
  margin-bottom: 40px;
  color: #fff;
  text-align: center;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

/* --- 2. NEW GLASS CARD STYLES (From Target Image) --- */
.contact-form {
  /* Highly transparent white */
  background: rgba(255, 255, 255, 0.1);
  /* The blur effect */
  backdrop-filter: blur(20px);
  -webkit-backdrop-filter: blur(20px);
  border-radius: 20px;
  padding: 50px 40px;
  /* Subtle borders to look like glass edges */
  border-top: 1px solid rgba(255, 255, 255, 0.5);
  border-left: 1px solid rgba(255, 255, 255, 0.2);
  border-right: 1px solid rgba(255, 255, 255, 0.2);
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
  position: relative;
  overflow: hidden;
}

/* Top shiny light effect on the card */
.contact-form::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
  z-index: 3;
}

/* LABELS */
.form-label {
  font-weight: 600;
  margin-bottom: 8px;
  color: rgba(255, 255, 255, 0.9); /* White text for labels */
  font-size: 0.95rem;
  letter-spacing: 0.5px;
}

/* INPUT FIELDS (Solid White) */
.form-control {
  background: #ffffff;
  border: 2px solid transparent;
  border-radius: 10px;
  padding: 12px 20px;
  font-size: 1rem;
  color: #333;
  transition: all 0.3s ease;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.form-control::placeholder {
  color: #aaa;
}

/* THE GLOWING FOCUS EFFECT (Cyan/Teal from target image) */
.form-control:focus {
  background: #fff;
  border-color: #00f2ff; /* Cyan border */
  box-shadow: 0 0 15px rgba(0, 242, 255, 0.5); /* Cyan Glow */
  outline: none;
}

/* SUBMIT BUTTON (Purple/Blue Gradient from target image) */
.btn-submit-custom {
  background: linear-gradient(135deg, #2b57f5, #a34ef7); /* Blue to Purple */
  border: none;
  color: white;
  padding: 12px 60px;
  border-radius: 10px;
  font-weight: 600;
  font-size: 1.1rem;
  letter-spacing: 1px;
  text-transform: uppercase;
  transition: all 0.3s ease;
  box-shadow: 0 10px 20px rgba(43, 87, 245, 0.3);
  margin-top: 20px;
}

/* Title Styling with Underline */
.contact-form-section h2 {
  font-size: 2.8rem;
  font-weight: 700;
  margin-bottom: 60px; /* Increased margin to make room for the line */
  color: #fff;
  text-align: center;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  position: relative; /* Required for the line to stick to the title */
}

/* The "After" Line */
.contact-form-section h2::after {
  content: '';
  position: absolute;
  bottom: -20px; /* Distance from text */
  left: 50%;
  transform: translateX(-50%); /* Centers the line */
  width: 80px; /* Length of the line */
  height: 4px; /* Thickness */
  
  /* White color to contrast with the blue background */
  background: #ffffff; 
  border-radius: 2px;
  
  /* Optional: Adds a subtle glow to match the glass effect */
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); 
}

.btn-submit-custom:hover {
  transform: translateY(-2px);
  box-shadow: 0 15px 30px rgba(163, 78, 247, 0.4);
  background: linear-gradient(90deg, #2b57f5, #a34ef7);
}
/* Update button to stand out on white form */
.contact-form .btn-primary {
  background: linear-gradient(90deg, #2b57f5, #a34ef7);
  border: none;
  color: white;
}

.contact-form .btn-primary:hover {
  background: linear-gradient(90deg, #2b57f5, #a34ef7);
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .contact-form-section {
    padding: 80px 0;
  }
  
  .contact-form-section h2 {
    font-size: 2.4rem;
  }
  
  .contact-form {
    padding: 30px 25px;
  }
}

@media (max-width: 480px) {
  .contact-form-section {
    padding: 60px 0;
  }
  
  .contact-form-section h2 {
    font-size: 2rem;
  }
}

/* Modern Map Section */
.map-section {
  background: linear-gradient(135deg, var(--light-blue) 0%, #fff 100%);
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.map-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2317A2DC' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  z-index: 0;
}

.map-container {
  position: relative;
  z-index: 1;
}

.map-section h2 {
  font-size: 3rem;
  color: var(--newblue2);
  font-weight: 800;
  margin-bottom: 50px;
  text-align: center;
  position: relative;
}

.map-section h2::after {
  content: '';
  position: absolute;
  bottom: -20px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
}

.map-wrapper {
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  border: none;
}

.map-wrapper iframe {
  display: block;
  width: 100%;
  border: none;
}

/* Modern CTA Section */
.cta-section {
  background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
  color: white;
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.cta-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
}

.cta-content {
  position: relative;
  z-index: 2;
}

.cta-section h2 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 25px;
  color: white;
  text-align: center;
}

.cta-section p {
  font-size: 1.2rem;
  opacity: 0.9;
  margin-bottom: 40px;
  text-align: center;
}

/* =========================
   Buttons
========================= */
.btn {
  padding: 0.8rem 1.8rem;
  border-radius: 12px;
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
  box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
}

.btn-orange {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  border: none;
  color: white;
}

.btn-orange:hover {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
  color: white;
}

.btn-light {
  background: rgba(255, 255, 255, 0.9);
  border: none;
  color: var(--primary-blue);
  border-color: #000;
}

.btn-light:hover {
  background: #fff;
  color: var(--primary-blue-dark);
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
}

/* CTA Buttons */
.cta-buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.cta-buttons .btn {
  flex: 1;
  min-width: 200px;
  text-align: center;
  padding: 15px 25px;
  font-size: 1.1rem;
  font-weight: 700;
}

.cta-buttons .btn-request-demo {
  background: transparent;
  border: 2px solid white;
  color: white;
}

.cta-buttons .btn-request-demo:hover {
  background: white;
  color: var(--newblue2);
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
}

/* =========================
   Animations
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

/* Card Animation */
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

.contact-info-card {
  animation: cardFadeIn 0.6s ease forwards;
}

.contact-info-card:nth-child(1) { animation-delay: 0.1s; }
.contact-info-card:nth-child(2) { animation-delay: 0.2s; }
.contact-info-card:nth-child(3) { animation-delay: 0.3s; }
.contact-info-card:nth-child(4) { animation-delay: 0.4s; }

/* =========================
   Footer
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
   Responsive
========================= */
@media (max-width: 992px) {
  .contact-hero { padding: 120px 0 80px; min-height: 60vh; }
  .contact-hero h1 { font-size: 2.8rem; }
  .contact-info-section h2,
  .contact-form-section h2,
  .map-section h2,
  .cta-section h2 { font-size: 2.4rem; }
  .dropdown-submenu > .dropdown-menu { left: 0; margin-top: 0; }
  footer .links a { display: inline-block; margin-bottom: 12px; }
}

@media (max-width: 768px) {
  .contact-hero { min-height: 50vh; }
  .contact-hero h1 { font-size: 2.2rem; }
  .contact-info-section h2,
  .contact-form-section h2,
  .map-section h2,
  .cta-section h2 { font-size: 2rem; }
  footer .links a { display: block; margin-bottom: 12px; }
  .cta-buttons { flex-direction: column; gap: 15px; }
  .contact-form { padding: 30px 25px; }
  .contact-info-card { padding: 30px 20px; }
}

/* =========================
   Fixes
========================= */
body > div[style*="margin-top: 90px"] { display: none !important; }


  /* ===============================
   MODERN CTA SECTION WITH MOVING WAVY GRADIENT
========================= */
.cta-section {
  background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
  color: white;
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.cta-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    /* Wavy pattern overlay */
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff' fill-opacity='0.1'%3E%3C/path%3E%3C/svg%3E"),
    /* Second wavy layer */
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%23ffffff' fill-opacity='0.05'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  z-index: 1;
  animation: waveMove 15s ease-in-out infinite alternate;
}

.cta-content {
  position: relative;
  z-index: 2;
}

.cta-section h2 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 25px;
  color: white;
  text-align: center;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.cta-section p {
  font-size: 1.2rem;
  opacity: 0.9;
  margin-bottom: 40px;
  text-align: center;
  text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
}

/* Wave animation */
@keyframes waveMove {
  0% {
    background-position: 
      bottom center,
      top center;
  }
  100% {
    background-position: 
      bottom 10px center,
      top -10px center;
  }
}

/* CTA Buttons */
.cta-buttons {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.cta-buttons .btn {
  flex: 1;
  min-width: 200px;
  text-align: center;
  padding: 15px 25px;
  font-size: 1.1rem;
  font-weight: 700;
  position: relative;
  z-index: 2;
}

.cta-buttons .btn-primary {
  background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
  border: none;
}

.cta-buttons .btn-primary:hover {
  background: linear-gradient(135deg, var(--primary-blue-dark), var(--primary-blue));
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
}

.cta-buttons .btn-request-demo {
  background: transparent;
  border: 2px solid white;
  color: white;
}

.cta-buttons .btn-request-demo:hover {
  background: white;
  color: var(--newblue2);
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(255, 255, 255, 0.3);
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .cta-section {
    padding: 80px 0;
  }
  
  .cta-section h2 {
    font-size: 2.4rem;
  }
  
  .cta-section p {
    font-size: 1.1rem;
  }
  
  .cta-buttons {
    flex-direction: column;
    gap: 15px;
  }
  
  .cta-buttons .btn {
    min-width: 250px;
  }
}

@media (max-width: 480px) {
  .cta-section {
    padding: 60px 0;
  }
  
  .cta-section h2 {
    font-size: 2rem;
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

  <!-- Offset for fixed navbar -->
  <div style="margin-top: 90px;"></div>

  <!-- ✅ Modern Contact Sections -->
     <main>
        <!-- 1. Modern Header with Background Image -->
        <section class="contact-hero" <?php echo !empty($contact_hero_title['image']) ? 'style="background-image: url(/assets_system/images/' . $contact_hero_title['image'] . ')"' : ''; ?>>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8 mx-auto text-center fade-in contact-hero-content">
                        <h1><?php echo htmlspecialchars($contact_hero_title); ?></h1>
                        <p class="lead"><?php echo htmlspecialchars($contact_hero_desc); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Modern Contact Information -->
        <section class="contact-info-section">
            <div class="contact-info-container">
                <div class="container fade-in">
                    <h2><?php echo htmlspecialchars($contact_info_title); ?></h2>
                    <div class="row">
                        <?php 
                        if (!empty($contact_info_cards)) {
                            $icon_map = array(
                                'Office Address' => 'fa-map-marker-alt',
                                'Phone' => 'fa-phone',
                                'Email' => 'fa-envelope',
                                'Operating Hours' => 'fa-clock'
                            );
                            
                            foreach ($contact_info_cards as $key => $card) {
                                ?>
                                <div class="col-md-6 col-lg-3 mb-4">
                                    <div class="contact-info-card">
                                        <i class="fas <?php echo isset($icon_map[$key]) ? $icon_map[$key] : 'fa-info-circle'; ?>"></i>
                                        <h5><?php echo htmlspecialchars($card['title']); ?></h5>
                                        <p><?php echo htmlspecialchars($card['content']); ?></p>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3. Modern Contact Form -->
        <section class="contact-form-section">
            <div class="contact-form-container">
                <div class="container fade-in">
                    <div class="row">
                        <div class="col-lg-8 mx-auto">
                            <h2><?php echo htmlspecialchars($contact_form_title); ?></h2>
                            <div class="contact-form">
                                <form id="contactMessageForm" method="post">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label"><?php echo htmlspecialchars($form_labels['name']); ?></label>
                                            <input type="text" class="form-control" name="name" id="contact_name" placeholder="<?php echo htmlspecialchars($form_placeholders['name']); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-4">
                                            <label class="form-label"><?php echo htmlspecialchars($form_labels['email']); ?></label>
                                            <input type="email" class="form-control" name="email" id="contact_email" placeholder="<?php echo htmlspecialchars($form_placeholders['email']); ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label">Contact Number</label>
                                        <input type="text"
                                               class="form-control"
                                               name="contact_number"
                                               id="contact_number"
                                               placeholder="09XXXXXXXXX"
                                               maxlength="11"
                                               required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label"><?php echo htmlspecialchars($form_labels['subject']); ?></label>
                                        <input type="text" class="form-control" name="subject" id="contact_subject" placeholder="<?php echo htmlspecialchars($form_placeholders['subject']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label class="form-label"><?php echo htmlspecialchars($form_labels['message']); ?></label>
                                        <textarea class="form-control" name="message" id="contact_message" rows="5" placeholder="<?php echo htmlspecialchars($form_placeholders['message']); ?>" required></textarea>
                                    </div>
                                    
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-submit-custom" id="submitContactBtn">
                                            <span id="submitBtnText"><?php echo htmlspecialchars($submit_button); ?></span>
                                            <span id="submitBtnSpinner" class="d-none">
                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                Sending...
                                            </span>
                                        </button>
                                    </div>
                                    
                                    <!-- Response message area -->
                                    <div id="contactFormMessage" class="mt-3 d-none">
                                        <div class="alert" role="alert" id="contactAlertBox"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 4. Modern Location / Map -->
        <section class="map-section">
            <div class="map-container">
                <div class="container fade-in">
                    <h2><?php echo htmlspecialchars($map_section_title); ?></h2>
                    <p class="text-center mb-5">
                        <?php echo htmlspecialchars($map_section_desc); ?>
                    </p>
                    <div class="map-wrapper">
                        <div class="ratio ratio-16x9">
                            <iframe 
                                src="https://www.google.com/maps?q=Line+Seiki+Philippines+Inc+Cavite+Economic+Zone&hl=en&z=18&output=embed"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- 5. Modern CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content text-center fade-in">
                    <h2><?php echo htmlspecialchars($cta_title); ?></h2>
                    <p><?php echo htmlspecialchars($cta_desc); ?></p>
                    
                    <!-- CTA Buttons -->
                    <div class="cta-buttons">
                        <a href="#" class="btn btn-primary"><?php echo htmlspecialchars($cta_buttons['schedule']); ?></a>
                        <a href="#" class="btn btn-request-demo"><?php echo htmlspecialchars($cta_buttons['demo']); ?></a>
                    </div>
                </div>
            </div>
        </section>
    </main>

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
      
      // Contact Form Submission
      const contactForm = document.getElementById('contactMessageForm');
      if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
          e.preventDefault();
          
          // Get form data
          const formData = new FormData(contactForm);
          
          // Show loading state
          const submitBtn = document.getElementById('submitContactBtn');
          const btnText = document.getElementById('submitBtnText');
          const btnSpinner = document.getElementById('submitBtnSpinner');
          
          submitBtn.disabled = true;
          btnText.classList.add('d-none');
          btnSpinner.classList.remove('d-none');
          
          // Submit via AJAX
          fetch('<?= base_url('index/submit_contact_message') ?>', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            // Hide loading state
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
            
            // Show response message
            const messageDiv = document.getElementById('contactFormMessage');
            const alertBox = document.getElementById('contactAlertBox');
            
            messageDiv.classList.remove('d-none');
            
            if (data.success) {
              alertBox.className = 'alert alert-success';
              alertBox.innerHTML = '<strong>Success!</strong> ' + data.message;
              
              // Reset form
              contactForm.reset();
              
              // Hide message after 5 seconds
              setTimeout(() => {
                messageDiv.classList.add('d-none');
              }, 5000);
            } else {
              alertBox.className = 'alert alert-danger';
              alertBox.innerHTML = '<strong>Error!</strong> ' + data.message;
            }
            
            // Scroll to message
            messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
          })
          .catch(error => {
            console.error('Error:', error);
            
            // Hide loading state
            submitBtn.disabled = false;
            btnText.classList.remove('d-none');
            btnSpinner.classList.add('d-none');
            
            // Show error message
            const messageDiv = document.getElementById('contactFormMessage');
            const alertBox = document.getElementById('contactAlertBox');
            
            messageDiv.classList.remove('d-none');
            alertBox.className = 'alert alert-danger';
            alertBox.innerHTML = '<strong>Error!</strong> An unexpected error occurred. Please try again.';
          });
        });
      }
    });
  </script>
  <script>
document.getElementById("contact_number").addEventListener("input", function (e) {
    // Remove all non-numeric characters
    this.value = this.value.replace(/[^0-9]/g, '');

    // Limit to 11 digits
    if (this.value.length > 11) {
        this.value = this.value.slice(0, 11);
    }
});
</script>
</body>
</html>