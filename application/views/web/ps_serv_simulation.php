<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Line Seiki Asia Pacific Service</title>

  <!-- Bootstrap 5 CSS -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">

  <!-- Google Fonts -->
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">

  <style>
/* ===== CSS VARIABLES ===== */
:root {
  --primary-blue: #0d6efd;
  --primary-blue-dark: #0a58ca;
  --light-blue: #e7f1ff;
  --dark: #212529;
  --newblue: #17A2DC;
  --newblue2: #0F467B;
  --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

/* ===== BASE STYLES ===== */
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

/* ===== NAVBAR STYLES ===== */
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

/* ===== DROPDOWN STYLES ===== */
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

/* ===== SECTION STYLES ===== */
section {
  padding: 100px 0;
  position: relative;
  width: 100%;
  overflow: hidden;
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

section h1::after, section h2::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -10px;
  width: 60px;
  height: 4px;
  border-radius: 2px;
}

section p {
  margin-bottom: 28px;
  font-size: 1.1rem;
  color: #495057;
  line-height: 1.7;
}

section img {
  width: 100%;
  border-radius: 16px;
  transition: var(--transition);
  transform: translateY(0);
  max-width: 100%;
  height: auto;
}

section img:hover {
  transform: translateY(-5px);
}

/* ===== SECTION COLOR SCHEMES ===== */
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

/* ===== BUTTON STYLES ===== */
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
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
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

/* ===== HERO SECTION ===== */
.section-white {
  position: relative;
  overflow: hidden;
}

.section-white::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
              url('<?= base_url("assets_system/images/" . $content['hero_bg_img']['image']) ?>');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  z-index: 0;
}

.section-white > .container {
  position: relative;
  z-index: 1;
}

.section-white h1,
.section-white h4,
.section-white h5,
.section-white p {
  color: white;
  text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.section-white h1::after {
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
}

/* Hero image adjustments */
.section-white .col-lg-6:last-child img {
  box-shadow: none !important;
  border: none !important;
  border-radius: 0 !important;
  background: transparent !important;
  max-width: 85% !important;
  height: auto !important;
  display: block;
  margin-left: auto;
}

.section-white .col-lg-6:last-child img:hover {
  transform: none !important;
}

.section-white .col-lg-6:first-child {
  padding-right: 40px;
}

.section-white .col-lg-6:first-child h1 {
  font-size: 3.5rem;
  margin-bottom: 30px;
  line-height: 1.1;
}

.section-white .col-lg-6:first-child p {
  font-size: 1.2rem;
  line-height: 1.8;
  margin-bottom: 40px;
}

/* Consultation button styling */
.consultation-btn {
  display: inline-block;
  background: var(--newblue);
  color: white;
  padding: 15px 35px;
  border-radius: 15px;
  text-decoration: none;
  font-weight: 600;
  font-size: 1.1rem;
  transition: var(--transition);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.consultation-btn:hover {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  transform: translateY(-3px);
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
  color: white;
}

/* ===== WHAT WE DO SECTION ===== */
.what-we-do-section {
  padding: 100px 0;
  background: #fff;
}

.what-we-do-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.what-we-do-title {
  margin-bottom: 40px;
  color: var(--primary-blue);
  font-weight: 700;
  position: relative;
  text-align: center;
}

.what-we-do-title::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: -10px;
  width: 60px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
  transform: translateX(-50%);
}

.what-we-do-text {
  font-size: 1.1rem;
  color: #495057;
  line-height: 1.7;
  max-width: 100%;
}

/* ===== CAPABILITIES SECTION ===== */
.capabilities-section {
  padding: 100px 0;
  position: relative;
  overflow: hidden;
  background-color: #0b1121;
  background-image: linear-gradient(135deg, rgba(15, 70, 123, 0.85) 100%, rgba(23, 162, 220, 0.75) 100%),
                    url('<?= base_url('assets_system/images/newb.jpg') ?>');
  background-size: cover;
  background-position: center;
  background-attachment: fixed;
}

.capabilities-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  position: relative;
  z-index: 2;
}

/* Title Styling */
.capabilities-title {
  text-align: center;
  margin-bottom: 70px;
  color: #ffffff;
  font-family: 'Inter', sans-serif;
  font-weight: 700;
  font-size: 3.5rem;
  position: relative;
  padding-bottom: 20px;
}

.capabilities-title::after {
  content: '';
  position: absolute;
  left: 50%;
  bottom: 0;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, #42b9ff, #0d6efd);
  border-radius: 2px;
  box-shadow: 0 0 10px rgba(66, 185, 255, 0.6);
}

/* GRID LAYOUT */
.capabilities-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}

/* BASE CARD STYLE (Glassmorphism) */
.capability-card {
  background: rgba(255, 255, 255, 0.03);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border-radius: 24px;
  padding: 40px 25px;
  text-align: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  border: 1px solid rgba(255, 255, 255, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  height: 100%;
  min-height: 500px;
}

.capability-card:hover {
  transform: translateY(-10px);
}

/* Card color themes */
.card-blue {
  border-top: 1px solid rgba(66, 185, 255, 0.5);
  border-bottom: 1px solid rgba(66, 185, 255, 0.2);
  box-shadow: 0 0 20px rgba(66, 185, 255, 0.1), inset 0 0 20px rgba(66, 185, 255, 0.05);
}

.card-blue .card-icon-top,
.card-blue .list-icon {
  color: #42b9ff;
  border-color: #42b9ff;
}

.card-blue:hover {
  box-shadow: 0 0 30px rgba(66, 185, 255, 0.3), inset 0 0 20px rgba(66, 185, 255, 0.1);
}

.card-green {
  border-top: 1px solid rgba(100, 255, 150, 0.5);
  border-bottom: 1px solid rgba(100, 255, 150, 0.2);
  box-shadow: 0 0 20px rgba(100, 255, 150, 0.1), inset 0 0 20px rgba(100, 255, 150, 0.05);
}

.card-green .card-icon-top,
.card-green .list-icon {
  color: #64ff96;
  border-color: #64ff96;
}

.card-green:hover {
  box-shadow: 0 0 30px rgba(100, 255, 150, 0.3), inset 0 0 20px rgba(100, 255, 150, 0.1);
}

.card-purple {
  border-top: 1px solid rgba(180, 100, 255, 0.5);
  border-bottom: 1px solid rgba(180, 100, 255, 0.2);
  box-shadow: 0 0 20px rgba(180, 100, 255, 0.1), inset 0 0 20px rgba(180, 100, 255, 0.05);
}

.card-purple .card-icon-top,
.card-purple .list-icon {
  color: #b464ff;
  border-color: #b464ff;
}

.card-purple:hover {
  box-shadow: 0 0 30px rgba(180, 100, 255, 0.3), inset 0 0 20px rgba(180, 100, 255, 0.1);
}

.card-orange {
  background: linear-gradient(135deg, rgba(254, 215, 170, 0.1) 0%, rgba(255, 247, 237, 0.05) 100%);
  border: 1px solid rgba(249, 115, 22, 0.2);
  box-shadow: 0 10px 25px -5px rgba(249, 115, 22, 0.1);
}

.card-orange:hover {
  box-shadow: 0 20px 40px -10px rgba(249, 115, 22, 0.15);
  transform: translateY(-5px);
  border-color: rgba(249, 115, 22, 0.3);
}

.card-red {
  background: linear-gradient(135deg, rgba(254, 205, 211, 0.1) 0%, rgba(254, 242, 242, 0.05) 100%);
  border: 1px solid rgba(239, 68, 68, 0.2);
  box-shadow: 0 10px 25px -5px rgba(239, 68, 68, 0.1);
}

.card-red:hover {
  box-shadow: 0 20px 40px -10px rgba(239, 68, 68, 0.15);
  transform: translateY(-5px);
  border-color: rgba(239, 68, 68, 0.3);
}

/* TOP ICON STYLE */
.card-icon-top {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  border: 2px solid currentColor;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.8rem;
  margin-bottom: 25px;
  background: rgba(255, 255, 255, 0.05);
}

.capability-card h3 {
  color: white;
  font-size: 1.4rem;
  font-weight: 600;
  margin-bottom: 30px;
  line-height: 1.3;
  min-height: 80px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
}

/* LIST STYLES */
.cap-list {
  list-style: none;
  padding: 0;
  margin: 0;
  width: 100%;
  text-align: left;
  flex-grow: 1;
}

.cap-list li {
  display: flex;
  align-items: center;
  margin-bottom: 20px;
  color: #e0e0e0;
  font-size: 1rem;
  font-weight: 300;
}

.list-icon {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
  font-size: 0.9rem;
  flex-shrink: 0;
}

/* ===== REDUCED COST SECTION ===== */
.reduced-cost-section {
  padding: 100px 0;
  background-color: #fff;
}

.reduced-cost-section img {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
}

.reduced-cost-section .main-gif {
  width: 100%;
  border-radius: 10px;
  max-height: 300px;
  object-fit: cover;
}

/* BENEFIT CARD STYLES */
.benefit-cards-container {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.benefit-card {
  background: linear-gradient(135deg, var(--light-blue), #f8f9fa);
  border: 1px solid rgba(13, 110, 253, 0.15);
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  height: 100%;
}

.benefit-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
  border-color: rgba(13, 110, 253, 0.3);
}

.benefit-card-header {
  display: flex;
  align-items: center;
  margin-bottom: 15px;
}

.benefit-card-icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--primary-blue), var(--primary-blue-dark));
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 15px;
  color: white;
  font-size: 1.3rem;
  flex-shrink: 0;
}

.benefit-card-title {
  color: var(--primary-blue);
  font-weight: 600;
  font-size: 1.25rem;
  margin: 0;
}

.benefit-card-description {
  color: #495057;
  font-size: 0.95rem;
  line-height: 1.6;
  margin: 0;
}

/* ADDITIONAL CARD STYLE */
.additional-benefit-card {
  background: linear-gradient(135deg, rgba(254, 215, 170, 0.1), rgba(255, 247, 237, 0.05));
  border: 1px solid rgba(249, 115, 22, 0.2);
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 4px 12px rgba(249, 115, 22, 0.05);
  transition: all 0.3s ease;
  margin-top: 25px;
}

.additional-benefit-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 18px rgba(249, 115, 22, 0.08);
  border-color: rgba(249, 115, 22, 0.3);
}

.additional-benefit-card-icon {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background: linear-gradient(135deg, #f97316, #ea580c);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 15px;
  color: white;
  font-size: 1.3rem;
}

.additional-benefit-card-title {
  color: #f97316;
  font-weight: 600;
  font-size: 1.25rem;
  margin-bottom: 10px;
}

.additional-benefit-card-description {
  color: #495057;
  font-size: 0.95rem;
  line-height: 1.6;
  margin-bottom: 15px;
}

.additional-benefit-card-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.additional-benefit-card-list li {
  display: flex;
  align-items: center;
  margin-bottom: 8px;
  color: #444;
  font-size: 0.9rem;
}

.additional-benefit-card-list li i {
  color: #f97316;
  margin-right: 8px;
  font-size: 0.8rem;
}

/* ===== SIMULATION SECTION ===== */
.simulation-section {
  background-color: #fff;
  position: relative;
  padding: 100px 0;
}

.simulation-section h1 {
  font-size: 2.8rem;
  color: var(--primary-blue);
  margin-bottom: 20px;
}

.simulation-section .underline {
  width: 50px;
  height: 3px;
  background-color: var(--newblue2);
  border: none;
  margin: 10px 0 20px;
}

.simulation-card {
  background-color: #004c91;
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.simulation-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.simulation-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-bottom: 3px solid var(--primary-blue);
}

.simulation-card .card-body {
  padding: 20px;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.simulation-card h5 {
  color: #fff;
  margin-bottom: 10px;
  font-size: 1.2rem;
}

.simulation-card p {
  color: #d9e4f5;
  margin-bottom: 10px;
  flex-grow: 1;
}

.simulation-card .read-more {
  text-decoration: none;
  color: #fff;
  font-weight: 600;
  margin-top: auto;
}

.simulation-card .read-more:hover {
  text-decoration: underline;
}

/* Carousel Controls */
.carousel-controls-outside {
  position: static;
  display: flex;
  gap: 8px;
  justify-content: center;
  margin-top: 20px;
}

.carousel-control-prev,
.carousel-control-next {
  position: static;
  background-color: #0d6efd;
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0.9;
  transition: background-color 0.3s ease, opacity 0.3s ease;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
  background-color: #0a58ca;
  opacity: 1;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
  background-size: 50% 50%;
  filter: invert(1);
}

/* ===== PROCESS SECTION ===== */
.process-section {
  text-align: center;
  padding: 100px 0;
  background: #fff;
}

.process-section .underline {
  border: none;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  width: 60px;
  height: 4px;
  margin: 10px auto 30px;
  border-radius: 2px;
}

.process-icon {
  width: 80px;
  height: 80px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  background: var(--primary-blue);
  color: white;
}

.process-section i {
  font-size: 2rem;
}

.process-section h5 {
  font-size: 1.3rem;
  font-weight: 600;
  margin-top: 15px;
  color: var(--primary-blue);
}

.process-section p {
  color: #495057;
  font-size: 1rem;
  line-height: 1.6;
}

/* ===== WEBINAR SECTION ===== */
.webinar-section {
  padding: 100px 0;
  background: #fff;
  position: relative;
  overflow: visible;
}

.webinar-inner {
  display: grid;
  grid-template-columns: 1fr;
  gap: 48px;
  margin: 0 auto;
}

.webinar-content {
  position: relative;
  text-align: center;
}

.webinar-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(15, 70, 123, 0.08);
  padding: 7px 18px;
  border-radius: 50px;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 2px;
  margin-bottom: 24px;
  color: var(--newblue2);
}

.webinar-badge i {
  font-size: 0.4rem;
  color: var(--newblue);
  animation: webinar-pulse 2s ease-in-out infinite;
}

@keyframes webinar-pulse {
  0%, 100% { opacity: 0.4; }
  50% { opacity: 1; }
}

.webinar-content h2 {
  font-size: 2.6rem;
  font-weight: 800;
  line-height: 1.15;
  margin: 0 0 0;
  color: var(--newblue2);
}

.webinar-content h2::after {
  display: none;
}

.webinar-accent {
  display: block;
  width: 50px;
  height: 3px;
  background: linear-gradient(90deg, var(--newblue), var(--newblue2));
  border-radius: 2px;
  margin: 20px auto;
}

.webinar-content p {
  font-size: 1rem;
  line-height: 1.8;
  margin-bottom: 32px;
  color: #555;
}

.webinar-cta {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: var(--newblue2);
  color: #fff;
  padding: 14px 32px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.95rem;
  text-decoration: none;
  transition: var(--transition);
  border: none;
}

.webinar-cta:hover {
  background: var(--newblue);
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(15, 70, 123, 0.25);
}

.webinar-cta i {
  transition: transform 0.3s ease;
  font-size: 0.85rem;
}

.webinar-cta:hover i {
  transform: translateX(5px);
}

.webinar-cta-wrap {
  text-align: center;
  display: flex;
  justify-content: center;
  gap: 16px;
  flex-wrap: wrap;
}

.webinar-cta-register {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  background: #fff;
  color: var(--newblue2);
  border: 2px solid var(--newblue2);
  padding: 12px 32px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.95rem;
  text-decoration: none;
  transition: all 0.3s ease;
}

.webinar-cta-register:hover {
  background: var(--newblue2);
  color: #fff;
  transform: translateY(-3px);
  box-shadow: 0 10px 30px rgba(15, 70, 123, 0.25);
}

.webinar-cta-register i {
  transition: transform 0.3s ease;
  font-size: 0.85rem;
}

.webinar-cta-register:hover i {
  transform: translateX(5px);
}

/* Framed image */
.webinar-img-wrap {
  position: relative;
  padding: 14px;
  background: #fff;
  border: 2px solid #e2e8f0;
  border-radius: 20px;
  box-shadow: 0 20px 60px rgba(15, 70, 123, 0.1), 0 4px 12px rgba(0, 0, 0, 0.04);
  transition: var(--transition);
}

.webinar-img-wrap:hover {
  box-shadow: 0 25px 70px rgba(15, 70, 123, 0.15), 0 6px 16px rgba(0, 0, 0, 0.06);
  transform: translateY(-4px);
}

.webinar-img-wrap img {
  width: 100%;
  height: auto;
  display: block;
  border-radius: 12px;
  transition: transform 0.6s ease;
}

.webinar-img-wrap:hover img {
  transform: scale(1.02);
}

/* Corner accent dots on frame */
.webinar-img-wrap::before,
.webinar-img-wrap::after {
  content: '';
  position: absolute;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: var(--newblue);
  opacity: 0.4;
}

.webinar-img-wrap::before {
  top: -4px;
  left: -4px;
}

.webinar-img-wrap::after {
  bottom: -4px;
  right: -4px;
}

/* ===== NEW TESTIMONIAL SECTION ===== */
.testimonial-section {
  padding: 80px 0;
  background: var(--light-blue);
  position: relative;
  overflow: hidden;
}

.testimonial-container {
  max-width: 1200px;
  margin: 0;
  padding: 0 20px;
}

.testimonial-title {
  text-align: center;
  margin-bottom: 60px;
  color: var(--primary-blue);
  font-weight: 700;
  font-size: 2.5rem;
  position: relative;
}

.testimonial-title::after {
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

.testimonial-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}

.testimonial-card {
  background: white;
  border-radius: 20px;
  padding: 30px 25px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
  transition: var(--transition);
  border: 1px solid rgba(13, 110, 253, 0.1);
  position: relative;
}

.testimonial-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(13, 110, 253, 0.15);
  border-color: rgba(13, 110, 253, 0.2);
}

.quote-icon {
  color: var(--primary-blue);
  font-size: 2rem;
  opacity: 0.2;
  position: absolute;
  top: 20px;
  right: 25px;
}

.testimonial-text {
  font-size: 1rem;
  line-height: 1.7;
  color: #495057;
  margin-bottom: 25px;
  font-style: italic;
  padding-right: 20px;
}

.testimonial-author {
  display: flex;
  align-items: center;
  gap: 15px;
}

.author-avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--newblue), var(--primary-blue));
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.8rem;
  font-weight: 600;
  flex-shrink: 0;
  overflow: hidden; /* for image fit */
}

.author-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}

.author-info h6 {
  color: var(--primary-blue);
  font-weight: 700;
  font-size: 1.1rem;
  margin-bottom: 4px;
}

.author-info p {
  color: #6c757d;
  font-size: 0.9rem;
  margin-bottom: 0;
}

/* ===== SPACING BEFORE FOOTER ===== */
.spacing-before-footer {
  padding: 60px 0;
  background: #fff;
}

/* ===== FOOTER STYLES ===== */
footer {
  background: linear-gradient(135deg, var(--newblue2), var(--newblue));
  color: white;
  padding: 80px 20px 40px;
  position: relative;
  overflow: hidden;
  width: 100%;
  margin-top: 0;
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

/* ===== ANIMATIONS ===== */
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

/* ===== RESPONSIVE STYLES ===== */

/* Large screens (1200px and above) */
@media (min-width: 1200px) {
  .capabilities-grid {
    grid-template-columns: repeat(3, 1fr);
  }
  
  .simulation-card img {
    height: 220px;
  }
  
  .spacing-before-footer {
    padding: 60px 0;
  }
}

/* Medium screens (992px to 1199px) */
@media (max-width: 1199px) {
  section {
    padding: 80px 0;
  }
  
  section h1 {
    font-size: 2.4rem;
  }
  
  section h2 {
    font-size: 2rem;
  }
  
  .capabilities-title {
    font-size: 3rem;
  }
  
  .capability-card {
    min-height: 450px;
    padding: 30px 20px;
  }
  
  .simulation-section h1 {
    font-size: 2.4rem;
  }
  
  .webinar-content h2 {
    font-size: 2.2rem;
  }

  .webinar-inner {
    gap: 40px;
  }

  
  .capabilities-grid {
    grid-template-columns: repeat(2, 1fr);
  }
  
  .spacing-before-footer {
    padding: 50px 0;
  }
  
  .benefit-card {
    padding: 20px;
  }
}

/* Tablet screens (768px to 991px) */
@media (max-width: 991px) {
  section {
    padding: 70px 0;
  }
  
  section h1 {
    font-size: 2.2rem;
  }
  
  section h2 {
    font-size: 1.8rem;
  }
  
  section p {
    font-size: 1rem;
  }
  
  .section-white .col-lg-6:first-child {
    padding-right: 0;
    margin-bottom: 40px;
  }
  
  .section-white .col-lg-6:first-child h1 {
    font-size: 2.8rem;
  }
  
  .section-white .col-lg-6:first-child p {
    font-size: 1.1rem;
  }
  
  .section-white .col-lg-6:last-child img {
    max-width: 70%;
    margin: 0 auto;
  }
  
  .capabilities-title {
    font-size: 2.5rem;
  }
  
  .capability-card {
    min-height: 400px;
    padding: 25px 15px;
  }
  
  .capability-card h3 {
    font-size: 1.2rem;
    min-height: 60px;
  }
  
  .cap-list li {
    font-size: 0.95rem;
    margin-bottom: 15px;
  }
  
  .reduced-cost-section {
    padding: 70px 0;
  }
  
  .reduced-cost-section .main-gif {
    max-height: 250px;
  }
  
  .benefit-card {
    padding: 18px;
  }
  
  .benefit-card-icon {
    width: 45px;
    height: 45px;
    font-size: 1.2rem;
  }
  
  .benefit-card-title {
    font-size: 1.1rem;
  }
  
  .additional-benefit-card {
    padding: 18px;
  }
  
  .additional-benefit-card-icon {
    width: 45px;
    height: 45px;
    font-size: 1.2rem;
  }
  
  .additional-benefit-card-title {
    font-size: 1.1rem;
  }
  
  .simulation-section {
    padding: 70px 0;
  }
  
  .simulation-section h1 {
    font-size: 2.2rem;
  }
  
  .simulation-card img {
    height: 180px;
  }
  
  .simulation-card h5 {
    font-size: 1.1rem;
  }
  
  .process-section {
    padding: 70px 0;
  }
  
  .webinar-section {
    padding: 80px 0;
  }

  .webinar-inner {
    gap: 36px;
  }

  .webinar-content h2 {
    font-size: 2rem;
  }

  
  .dropdown-submenu > .dropdown-menu {
    left: 0;
    margin-top: 0;
  }
  
  .spacing-before-footer {
    padding: 40px 0;
  }
  
  footer {
    padding: 60px 20px 30px;
  }
  
  .testimonial-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

/* Mobile screens (576px to 767px) */
@media (max-width: 767px) {
  section {
    padding: 60px 0;
  }
  
  section h1 {
    font-size: 2rem;
  }
  
  section h2 {
    font-size: 1.6rem;
  }
  
  .section-white .col-lg-6:first-child h1 {
    font-size: 2.2rem;
  }
  
  .section-white .col-lg-6:first-child p {
    font-size: 1rem;
  }
  
  .consultation-btn {
    padding: 12px 25px;
    font-size: 1rem;
  }
  
  .what-we-do-title {
    font-size: 2rem;
  }
  
  .capabilities-title {
    font-size: 2.2rem;
    margin-bottom: 50px;
  }
  
  .capabilities-grid {
    grid-template-columns: 1fr;
    gap: 20px;
  }
  
  .capability-card {
    min-height: 350px;
    max-width: 400px;
    margin: 0 auto;
  }
  
  .reduced-cost-section {
    padding: 60px 0;
  }
  
  .reduced-cost-section .row {
    flex-direction: column;
  }
  
  .reduced-cost-section .col-md-7 {
    margin-bottom: 30px;
  }
  
  .reduced-cost-section .main-gif {
    max-height: 200px;
  }
  
  .benefit-cards-container {
    gap: 20px;
  }
  
  .benefit-card {
    padding: 15px;
  }
  
  .benefit-card-icon {
    width: 40px;
    height: 40px;
    font-size: 1.1rem;
    margin-right: 12px;
  }
  
  .benefit-card-title {
    font-size: 1rem;
  }
  
  .benefit-card-description {
    font-size: 0.9rem;
  }
  
  .additional-benefit-card {
    padding: 15px;
    margin-top: 20px;
  }
  
  .additional-benefit-card-icon {
    width: 40px;
    height: 40px;
    font-size: 1.1rem;
  }
  
  .additional-benefit-card-title {
    font-size: 1rem;
  }
  
  .additional-benefit-card-description {
    font-size: 0.9rem;
  }
  
  .additional-benefit-card-list li {
    font-size: 0.85rem;
  }
  
  .simulation-section {
    padding: 60px 0;
  }
  
  .simulation-section .row {
    flex-direction: column;
  }
  
  .simulation-section .col-md-4 {
    margin-bottom: 30px;
    text-align: center;
  }
  
  .simulation-section h1 {
    font-size: 2rem;
  }
  
  .simulation-card {
    margin-bottom: 20px;
  }
  
  .simulation-card img {
    height: 160px;
  }
  
  .process-section {
    padding: 60px 0;
  }
  
  .process-section h1 {
    font-size: 2rem;
  }
  
  .process-icon {
    width: 70px;
    height: 70px;
  }
  
  .process-section i {
    font-size: 1.8rem;
  }
  
  .process-section h5 {
    font-size: 1.2rem;
  }
  
  .webinar-section {
    padding: 60px 0;
  }

  .webinar-inner {
    gap: 30px;
  }

  .webinar-content h2 {
    font-size: 1.8rem;
  }

  .webinar-content p {
    font-size: 0.95rem;
  }

  .webinar-cta {
    padding: 13px 28px;
    font-size: 0.9rem;
  }

  
  .navbar-nav .nav-link {
    padding: 0.5rem 0.8rem;
    font-size: 0.95rem;
  }
  
  .spacing-before-footer {
    padding: 30px 0;
  }
  
  footer {
    padding: 50px 15px 25px;
  }
  
  footer h2 {
    font-size: 1.6rem;
  }
  
  footer .links a {
    display: block;
    margin-bottom: 12px;
    margin-right: 0;
  }
  
  footer .socials a {
    margin-right: 12px;
    font-size: 1.2rem;
  }
  
  .testimonial-grid {
    grid-template-columns: 1fr;
  }
  
  .testimonial-title {
    font-size: 2rem;
  }
}

/* Small mobile screens (below 576px) */
@media (max-width: 575px) {
  section {
    padding: 50px 0;
  }
  
  section h1 {
    font-size: 1.8rem;
  }
  
  section h2 {
    font-size: 1.4rem;
  }
  
  .section-white .col-lg-6:first-child h1 {
    font-size: 1.8rem;
  }
  
  .section-white .col-lg-6:first-child p {
    font-size: 0.95rem;
  }
  
  .consultation-btn {
    padding: 10px 20px;
    font-size: 0.95rem;
  }
  
  .what-we-do-title {
    font-size: 1.8rem;
  }
  
  .what-we-do-text {
    font-size: 1rem;
  }
  
  .capabilities-title {
    font-size: 1.8rem;
    margin-bottom: 40px;
  }
  
  .capability-card {
    min-height: 300px;
    padding: 20px 15px;
  }
  
  .capability-card h3 {
    font-size: 1.1rem;
    min-height: 50px;
    margin-bottom: 20px;
  }
  
  .card-icon-top {
    width: 50px;
    height: 50px;
    font-size: 1.5rem;
    margin-bottom: 20px;
  }
  
  .cap-list li {
    font-size: 0.9rem;
    margin-bottom: 12px;
  }
  
  .list-icon {
    width: 28px;
    height: 28px;
    font-size: 0.8rem;
    margin-right: 10px;
  }
  
  .reduced-cost-section {
    padding: 50px 0;
  }
  
  .reduced-cost-section .main-gif {
    max-height: 180px;
  }
  
  .benefit-cards-container {
    gap: 15px;
  }
  
  .benefit-card {
    padding: 12px;
  }
  
  .benefit-card-icon {
    width: 35px;
    height: 35px;
    font-size: 1rem;
    margin-right: 10px;
  }
  
  .benefit-card-title {
    font-size: 0.95rem;
  }
  
  .benefit-card-description {
    font-size: 0.85rem;
  }
  
  .additional-benefit-card {
    padding: 12px;
    margin-top: 15px;
  }
  
  .additional-benefit-card-icon {
    width: 35px;
    height: 35px;
    font-size: 1rem;
    margin-bottom: 10px;
  }
  
  .additional-benefit-card-title {
    font-size: 0.95rem;
  }
  
  .additional-benefit-card-description {
    font-size: 0.85rem;
  }
  
  .additional-benefit-card-list li {
    font-size: 0.8rem;
  }
  
  .simulation-section {
    padding: 50px 0;
  }
  
  .simulation-section h1 {
    font-size: 1.8rem;
  }
  
  .simulation-card img {
    height: 140px;
  }
  
  .simulation-card h5 {
    font-size: 1rem;
  }
  
  .simulation-card p {
    font-size: 0.9rem;
  }
  
  .process-section {
    padding: 50px 0;
  }
  
  .process-section h1 {
    font-size: 1.8rem;
  }
  
  .process-icon {
    width: 60px;
    height: 60px;
  }
  
  .process-section i {
    font-size: 1.5rem;
  }
  
  .process-section h5 {
    font-size: 1.1rem;
  }
  
  .process-section p {
    font-size: 0.95rem;
  }
  
  .webinar-section {
    padding: 50px 0;
  }

  .webinar-content h2 {
    font-size: 1.5rem;
  }

  .webinar-content p {
    font-size: 0.9rem;
    margin-bottom: 24px;
  }

  .webinar-badge {
    font-size: 0.62rem;
    padding: 5px 12px;
    margin-bottom: 18px;
  }

  .webinar-cta {
    padding: 12px 24px;
    font-size: 0.85rem;
  }

  .webinar-img-wrap {
    padding: 10px;
  }

  
  .btn {
    padding: 0.7rem 1.5rem;
    font-size: 0.95rem;
  }
  
  .spacing-before-footer {
    padding: 20px 0;
  }
  
  footer {
    padding: 40px 15px 20px;
  }
  
  footer h2 {
    font-size: 1.4rem;
  }
  
  footer .links a {
    margin-bottom: 10px;
  }
  
  footer .socials a {
    margin-right: 10px;
    font-size: 1.1rem;
  }
  
  footer .bottom {
    font-size: 0.8rem;
    gap: 15px;
  }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<?php $this->load->view('web/header'); ?>

<!-- Offset for fixed navbar -->
<div style="margin-top:90px"></div>

<!-- Section 1 (white) -->
<section class="section-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <h1><?php echo isset($content['hero_title']['content']) ? htmlspecialchars($content['hero_title']['content']) : 'Validate. Optimize. Innovate.'; ?></h1>
                <p><?php echo isset($content['hero_description']['content']) ? nl2br(htmlspecialchars($content['hero_description']['content'])) : 'We help engineers and manufacturers reduce design <br> errors, speed up development, and bring better products <br> to market—through virtual testing and engineering<br> simulation.'; ?></p>
                <a href="#consultation" class="consultation-btn">
                    <?php echo isset($content['consultation_button']['content']) ? htmlspecialchars($content['consultation_button']['content']) : 'Schedule a Consultation'; ?>
                </a>
            </div>
            <div class="col-lg-6 fade-in delay-1">
                <img src="<?php echo base_url('assets_system/images/' . (isset($content['hero_image']['image']) ? $content['hero_image']['image'] : 'simul1bg.png')); ?>" 
                     alt="Simulation Analysis" 
                     class="img-fluid">
            </div>
        </div>
    </div>
</section>

<!-- What We Do Section -->
<section class="what-we-do-section">
    <div class="what-we-do-container">
        <h1 class="what-we-do-title fade-in"><?php echo isset($content['what_we_do_title']['content']) ? htmlspecialchars($content['what_we_do_title']['content']) : 'What We Do'; ?></h1>
        <div class="what-we-do-text fade-in">
            <p><?php echo isset($content['what_we_do_text']['content']) ? nl2br(htmlspecialchars($content['what_we_do_text']['content'])) : 'Line Seiki offers Computer-Aided Engineering (CAE) Simulation Analysis services that help manufacturers and product designers evaluate performance, reliability, and safety—before physical prototyping begins.'; ?></p>
        </div>
    </div>
</section>

<section class="capabilities-section">
    <div class="capabilities-container">
        <h1 class="capabilities-title fade-in"><?php echo isset($content['capabilities_title']['content']) ? htmlspecialchars($content['capabilities_title']['content']) : 'Our Capabilities'; ?></h1>
        
        <div class="capabilities-grid">
            <?php 
            // Define CSS classes for each color scheme
            $card_classes = [
                'blue' => 'card-blue',
                'green' => 'card-green', 
                'purple' => 'card-purple',
                'orange' => 'card-orange',
                'red' => 'card-red'
            ];
            
            $text_colors = [
                'blue' => 'text-blue-600',
                'green' => 'text-green-600',
                'purple' => 'text-purple-600', 
                'orange' => 'text-orange-600',
                'red' => 'text-red-600'
            ];
            
            // Icon mapping based on color scheme
            $icons = [
                'blue' => 'bi bi-diagram-3',
                'green' => 'bi bi-gear-wide-connected',
                'purple' => 'bi bi-cpu',
                'orange' => 'bi bi-lightning-charge',
                'red' => 'bi bi-graph-up-arrow'
            ];
            
            $list_icons = [
                'blue' => 'bi bi-shield-check',
                'green' => 'bi bi-tools',
                'purple' => 'bi bi-motherboard',
                'orange' => 'bi bi-arrow-right-circle',
                'red' => 'bi bi-check-circle'
            ];
            
            foreach ($capabilities as $index => $capability): 
                // Get color scheme from database, default to blue if not set
                $color_scheme = $capability->color_scheme ?? 'blue';
                
                // Get classes based on actual color scheme
                $card_class = $card_classes[$color_scheme] ?? 'card-blue';
                $text_color = $text_colors[$color_scheme] ?? 'text-blue-600';
                $icon = $icons[$color_scheme] ?? 'bi bi-diagram-3';
                $list_icon = $list_icons[$color_scheme] ?? 'bi bi-shield-check';
                
                // Animation delay
                $delay_class = ($index == 0) ? 'fade-in' : (($index == 1) ? 'fade-in delay-1' : 'fade-in delay-2');
            ?>
            
            <div class="capability-card <?= $card_class ?> <?= $delay_class ?>">
                <div class="card-icon-top">
                    <i class="<?= $icon ?>"></i>
                </div>
                
                <h3 class="<?= $text_color ?>">
                    <?= nl2br(htmlspecialchars($capability->capability_name)) ?>
                </h3>
                
                <ul class="cap-list">
                    <?php if (!empty($capability->items)): ?>
                        <?php foreach ($capability->items as $item): ?>
                        <li>
                            <div class="list-icon"><i class="<?= $list_icon ?>"></i></div>
                            <span><?= htmlspecialchars($item->item_name) ?></span>
                        </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li>
                            <div class="list-icon"><i class="<?= $list_icon ?>"></i></div>
                            <span>No items added yet</span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="reduced-cost-section container py-5">
    <div class="row align-items-center">
        <!-- Images Section -->
        <div class="col-md-7 text-center">
            <img src="<?php echo base_url('assets_system/images/' . (isset($content['reduced_cost_gif']['image']) ? $content['reduced_cost_gif']['image'] : 'newsimgif.gif')); ?>" 
                 alt="Simulation GIF" 
                 class="img-fluid rounded main-gif mb-3">
            <div class="row">
                <div class="col-6">
                    <img src="<?php echo base_url('assets_system/images/' . (isset($content['reduced_cost_image_1']['image']) ? $content['reduced_cost_image_1']['image'] : 'newsim1.png')); ?>" 
                         alt="Model Image 1" 
                         class="img-fluid rounded">
                </div>
                <div class="col-6">
                    <img src="<?php echo base_url('assets_system/images/' . (isset($content['reduced_cost_image_2']['image']) ? $content['reduced_cost_image_2']['image'] : 'newsim2.png')); ?>" 
                         alt="Model Image 2" 
                         class="img-fluid rounded">
                </div>
            </div>
        </div>
        
        <!-- Benefits Text Section - NOW WITH CARDS -->
        <div class="col-md-5 text-start ps-md-4">
            <div class="benefit-cards-container">
                <?php foreach ($benefits as $index => $benefit): ?>
                    <div class="benefit-card fade-in <?php echo $index == 1 ? 'delay-1' : ($index == 2 ? 'delay-2' : ''); ?>">
                        <div class="benefit-card-header">
                            <div class="benefit-card-icon">
                                <?php
                                    // Use icon from DB if exists, else fallback
                                    $icon = !empty($benefit['icon']) ? $benefit['icon'] : 'default.png';
                                ?>
                                <img 
                                  src="<?= base_url('assets_system/images/' . $icon) ?>" 
                                  style="width:24px; height:24px; filter: brightness(0) invert(1);"
                                >
                            </div>
                            <h5 class="benefit-card-title">
                                <?= htmlspecialchars($benefit['title']) ?>
                            </h5>
                        </div>
                        <p class="benefit-card-description">
                            <?= htmlspecialchars($benefit['description']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<!-- Simulation in Action Section -->
<section class="simulation-section container py-5 position-relative">
    <div class="row align-items-center">
        <!-- Left Text Section -->
        <div class="col-md-4 mb-4 mb-md-0">
            <h1><?php echo isset($content['simulation_title']['content']) ? htmlspecialchars($content['simulation_title']['content']) : 'Simulation <br> in Action'; ?></h1>
            <p class="text-muted">
                <?php echo isset($content['simulation_description']['content']) ? htmlspecialchars($content['simulation_description']['content']) : 'A showcase of simulation-driven insights demonstrating how Line Seiki applies Computer-Aided Engineering to solve complex design and manufacturing problems.'; ?>
            </p>
            <button class="btn btn-primary px-4 py-2 rounded-pill">
                <?php echo isset($content['simulation_button']['content']) ? htmlspecialchars($content['simulation_button']['content']) : 'Talk to Experts'; ?>
            </button>
        </div>

        <!-- Right Carousel Section -->
        <div class="col-md-8">
            <div id="simulationCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php 
                    // Get carousel items from database
                    $carousel_items = $this->simulation_model->get_carousel_items();
                    $slides = array_chunk($carousel_items, 2);
                    
                    foreach ($slides as $slide_index => $slide_items):
                    ?>
                    <div class="carousel-item <?php echo $slide_index === 0 ? 'active' : ''; ?>">
                        <div class="row g-4">
                            <?php foreach ($slide_items as $item): ?>
                            <div class="col-md-6">
                                <div class="simulation-card h-100 shadow-sm">
                                    <?php if(!empty($item->main_image)): ?>
                                    <img src="<?php echo base_url('assets_system/images/' . $item->main_image); ?>"
                                         class="card-img-top" alt="<?php echo htmlspecialchars($item->title); ?>"
                                         onerror="this.src='<?php echo base_url('assets_system/images/no-image.png'); ?>'">
                                    <?php else: ?>
                                    <img src="<?php echo base_url('assets_system/images/no-image.png'); ?>"
                                         class="card-img-top" alt="<?php echo htmlspecialchars($item->title); ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="fw-bold"><?php echo htmlspecialchars($item->title); ?></h5>
                                        <p class="text-light small">
                                            <?php echo htmlspecialchars($item->abstract); ?>
                                        </p>
                                       <a href="<?php echo base_url('index/ps_contents/' . $item->id); ?>" class="read-more text-light fw-semibold">Read more</a>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <br>
            <!-- Carousel Controls -->
            <div class="carousel-controls-outside">
                <button class="carousel-control-prev" type="button" data-bs-target="#simulationCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#simulationCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="process-section py-5 text-center">
    <div class="container">
        <h1 class="fw-bold text-primary mb-2 capabilities-title">
            <?php echo isset($content['process_title']['content']) ? htmlspecialchars($content['process_title']['content']) : 'Process & Requirements'; ?>
        </h1>
        <hr class="underline mx-auto">
        <p class="text-muted mb-5">
            <?php echo isset($content['process_description']['content']) ? htmlspecialchars($content['process_description']['content']) : 'Each project includes a comprehensive report with visual results, data, and recommendations.'; ?>
        </p>

        <div class="d-flex justify-content-center align-items-stretch flex-wrap">
            <?php
            $default_icons = array(1 => 'bi-diagram-3', 2 => 'bi-graph-up', 3 => 'bi-person-check');
            for ($i = 1; $i <= 3; $i++):
                $step_icon = isset($content["process_step_{$i}_icon"]['content']) && !empty($content["process_step_{$i}_icon"]['content'])
                    ? $content["process_step_{$i}_icon"]['content']
                    : $default_icons[$i];
            ?>
            <!-- Step <?php echo $i; ?> -->
            <div class="col-12 col-md-3 d-flex flex-column px-3 mb-4">
                <div class="process-step-card h-100 d-flex flex-column">
                    <div class="process-icon bg-primary text-white mx-auto mb-3">
                        <i class="<?php echo htmlspecialchars($step_icon); ?> fs-1"></i>
                    </div>
                    <h5 class="fw-bold">
                        <?php echo isset($content["process_step_{$i}_title"]['content']) ? htmlspecialchars($content["process_step_{$i}_title"]['content']) : 'Step ' . $i; ?>
                    </h5>
                    <p class="text-muted small flex-grow-1">
                        <?php echo isset($content["process_step_{$i}_description"]['content']) ? htmlspecialchars($content["process_step_{$i}_description"]['content']) : 'Description for step ' . $i; ?>
                    </p>
                </div>
            </div>

            <!-- Arrow (except after last step) -->
            <?php if ($i < 3): ?>
            <div class="col-12 col-md-1 d-none d-md-flex align-items-center justify-content-center">
                <i class="bi-arrow-right fs-2 text-secondary opacity-50"></i>
            </div>
            <?php endif; ?>
            
            <?php endfor; ?>
        </div>
    </div>
</section>

<?php
// Support both old single and new multiple featured webinars
$featured_list = array();
if (isset($featured_webinars) && !empty($featured_webinars)) {
    $featured_list = $featured_webinars;
} elseif (isset($featured_webinar) && !empty($featured_webinar)) {
    $featured_list = array($featured_webinar);
}
?>
<?php if(!empty($featured_list)): ?>
<?php foreach($featured_list as $fw): ?>
<section class="webinar-section">
    <div class="container">
        <div class="webinar-inner">
            <div class="webinar-content">
                <span class="webinar-badge">
                    <i class="fas fa-circle"></i>
                    <?php echo isset($content['webinar_small_text']['content']) ? htmlspecialchars($content['webinar_small_text']['content']) : 'FEATURED'; ?>
                </span>
                <h2><?php echo htmlspecialchars($fw['webinar_title']); ?></h2>
                <span class="webinar-accent"></span>
                <?php if(isset($fw['description_1']) && !empty($fw['description_1'])): ?>
                <p><?php echo htmlspecialchars($fw['description_1']); ?></p>
                <?php endif; ?>
                <?php if(isset($fw['description_2']) && !empty($fw['description_2'])): ?>
                <p><?php echo htmlspecialchars($fw['description_2']); ?></p>
                <?php endif; ?>
            </div>
            <div class="webinar-img-wrap">
                <?php if(!empty($fw['main_image'])): ?>
                <img src="<?php echo base_url('assets_system/images/' . $fw['main_image']); ?>" alt="<?php echo htmlspecialchars($fw['webinar_title']); ?>">
                <?php else: ?>
                <img src="<?php echo base_url('assets_system/images/' . (isset($content['webinar_image']['image']) ? $content['webinar_image']['image'] : 'newsim4.png')); ?>" alt="Webinar Image">
                <?php endif; ?>
            </div>
            <div class="webinar-cta-wrap">
                <a href="<?php echo base_url('index/library?filter=webinars&wid=' . $fw['id'] . '&wname=' . urlencode($fw['webinar_title'])); ?>" class="webinar-cta">
                    Browse Webinar Series <i class="fas fa-arrow-right"></i>
                </a>
                <a href="https://docs.google.com/forms/d/e/1FAIpQLSf8yEyeQa9vCQuV9o40frTqXtjT-o6OcCw9-UJFBG7805VicA/viewform" target="_blank" rel="noopener noreferrer" class="webinar-cta-register">
                    Register <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endforeach; ?>
<?php endif; ?>

<!-- ===== NEW TESTIMONIAL SECTION (with images from DB) ===== -->
<?php
// Fetch testimonials from database (assuming $testimonials is passed from controller)
// If not set, create sample data with image filenames (in real scenario these come from tbl_testimonial)
if (!isset($testimonials) || empty($testimonials)) {
    // Sample data with image field - images should exist in assets_system/images/
    $testimonials = [
        ['name' => 'James Wong', 'position' => 'Engineering Manager, TechPrecise', 'content' => 'Line Seiki’s simulation analysis helped us cut prototyping costs by 30% and accelerated our time-to-market significantly. Their team’s expertise in CAE is exceptional.', 'image' => 'eye.png'],
        ['name' => 'Dr. Ananya Sharma', 'position' => 'R&D Lead, AeroInnovate', 'content' => 'The thermal and structural simulations provided deep insights that physical testing alone could not achieve. Highly professional and reliable partner.', 'image' => 'avatar2.jpg'],
        ['name' => 'Michael Chen', 'position' => 'Product Designer, FormFab', 'content' => 'We were impressed by the accuracy of the FEA results. The detailed report and recommendations made design optimization straightforward.', 'image' => 'avatar3.jpg'],
        ['name' => 'Siti Nurhaliza', 'position' => 'Operations Director, M&E Solutions', 'content' => 'Outstanding service from start to finish. The team understood our requirements perfectly and delivered actionable simulation data.', 'image' => 'avatar4.jpg'],
    ];
}
?>
<?php if (isset($testimonials) && !empty($testimonials)): ?>
<section class="testimonial-section">
    <div class="testimonial-container">
        <h2 class="testimonial-title fade-in">What Our Clients Say</h2>
        <div class="testimonial-grid">
            <?php foreach ($testimonials as $index => $testimonial): 
                $delay = $index == 0 ? 'fade-in' : ($index == 1 ? 'fade-in delay-1' : ($index == 2 ? 'fade-in delay-2' : 'fade-in delay-3'));
                $avatar_image = !empty($testimonial->image) ? base_url('assets_system/images/' . $testimonial->image) : null;
                $initial = strtoupper(substr($testimonial->name, 0, 1));
            ?>
            <div class="testimonial-card <?= $delay ?>">
                <div class="testimonial-card-content">
                    <i class="bi bi-quote quote-icon"></i>
                    <p class="testimonial-text"><?= htmlspecialchars($testimonial->content) ?></p>
                    <div class="testimonial-author">
                        <div class="author-avatar-large">
                            <?php if ($avatar_image): ?>
                                <img src="<?= $avatar_image ?>" alt="<?= htmlspecialchars($testimonial->name) ?>">
                            <?php else: ?>
                                <span class="initials-large"><?= $initial ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="author-info">
                            <h6><?= htmlspecialchars($testimonial->name) ?></h6>
                            <p><?= htmlspecialchars($testimonial->position) ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
/* Testimonial Section Styles */
.testimonial-section {
    padding: 80px 0;
    background: var(--light-blue);
    position: relative;
    overflow: hidden;
}

.testimonial-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.testimonial-title {
    text-align: center;
    margin-bottom: 60px;
    color: var(--primary-blue);
    font-weight: 700;
    font-size: 2.5rem;
    position: relative;
}

.testimonial-title::after {
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

.testimonial-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    align-items: stretch; /* This makes all cards equal height */
}

.testimonial-card {
    background: white;
    border-radius: 20px;
    padding: 0; /* Remove padding, will be handled by inner content */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    transition: var(--transition);
    border: 1px solid rgba(13, 110, 253, 0.1);
    position: relative;
    display: flex;
    height: 100%; /* Take full height of grid cell */
}

.testimonial-card-content {
    display: flex;
    flex-direction: column;
    padding: 35px 30px;
    width: 100%;
    position: relative;
}

.testimonial-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(13, 110, 253, 0.15);
    border-color: rgba(13, 110, 253, 0.2);
}

.quote-icon {
    color: var(--primary-blue);
    font-size: 2.5rem;
    opacity: 0.15;
    position: absolute;
    top: 25px;
    right: 30px;
    z-index: 1;
}

.testimonial-text {
    font-size: 1rem;
    line-height: 1.7;
    color: #495057;
    margin-bottom: 25px;
    font-style: italic;
    flex: 1; /* This makes text area grow to fill available space */
    min-height: 100px; /* Minimum height to maintain consistency */
    position: relative;
    z-index: 2;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-top: auto; /* Pushes author section to bottom */
    padding-top: 15px;
    border-top: 1px solid rgba(13, 110, 253, 0.1);
    position: relative;
    z-index: 2;
}

/* Larger Avatar Styles */
.author-avatar-large {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--newblue), var(--primary-blue));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 600;
    flex-shrink: 0;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    border: 3px solid white;
    transition: var(--transition);
}

.author-avatar-large img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.author-avatar-large:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.4);
}

.initials-large {
    font-size: 2.5rem;
    font-weight: 600;
    color: white;
}

.author-info {
    flex: 1;
    min-width: 0; /* Prevents text overflow */
}

.author-info h6 {
    font-size: 1.2rem;
    margin-bottom: 5px;
    color: var(--primary-blue);
    font-weight: 700;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.author-info p {
    font-size: 0.95rem;
    color: #6c757d;
    margin-bottom: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .testimonial-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .testimonial-card-content {
        padding: 30px 25px;
    }
    
    .author-avatar-large {
        width: 90px;
        height: 90px;
        font-size: 2.2rem;
    }
    
    .initials-large {
        font-size: 2.2rem;
    }
}

@media (max-width: 767px) {
    .testimonial-grid {
        grid-template-columns: 1fr;
        gap: 25px;
    }
    
    .testimonial-card-content {
        padding: 25px 20px;
    }
    
    .author-avatar-large {
        width: 80px;
        height: 80px;
        font-size: 2rem;
    }
    
    .initials-large {
        font-size: 2rem;
    }
    
    .testimonial-author {
        gap: 15px;
    }
    
    .author-info h6 {
        font-size: 1.1rem;
    }
    
    .author-info p {
        font-size: 0.9rem;
    }
}

@media (max-width: 575px) {
    .testimonial-section {
        padding: 60px 0;
    }
    
    .testimonial-title {
        font-size: 2rem;
        margin-bottom: 40px;
    }
    
    .testimonial-card-content {
        padding: 20px 15px;
    }
    
    .author-avatar-large {
        width: 70px;
        height: 70px;
        font-size: 1.8rem;
    }
    
    .initials-large {
        font-size: 1.8rem;
    }
    
    .testimonial-author {
        gap: 12px;
    }
    
    .quote-icon {
        font-size: 2rem;
        top: 15px;
        right: 20px;
    }
    
    .testimonial-text {
        font-size: 0.95rem;
        min-height: 80px;
    }
}
</style>
<?php endif; ?>


<!-- Footer -->
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
    
    // Image size adjustments
    function adjustImageSizes() {
      // Hero image
      const heroImage = document.querySelector('.section-white .col-lg-6:last-child img');
      if (heroImage) {
        if (window.innerWidth <= 767) {
          heroImage.style.maxWidth = '90%';
        } else if (window.innerWidth <= 991) {
          heroImage.style.maxWidth = '70%';
        } else {
          heroImage.style.maxWidth = '85%';
        }
      }
      
      // Capability cards
      const capabilityCards = document.querySelectorAll('.capability-card');
      capabilityCards.forEach(card => {
        if (window.innerWidth <= 767) {
          card.style.minHeight = '300px';
        } else if (window.innerWidth <= 991) {
          card.style.minHeight = '400px';
        } else {
          card.style.minHeight = '500px';
        }
      });
      
      // Simulation carousel images
      const simulationImages = document.querySelectorAll('.simulation-card img');
      simulationImages.forEach(img => {
        if (window.innerWidth <= 767) {
          img.style.height = '140px';
        } else if (window.innerWidth <= 991) {
          img.style.height = '180px';
        } else {
          img.style.height = '200px';
        }
      });
      
      // Reduced cost GIF
      const reducedCostGif = document.querySelector('.reduced-cost-section .main-gif');
      if (reducedCostGif) {
        if (window.innerWidth <= 767) {
          reducedCostGif.style.maxHeight = '180px';
        } else if (window.innerWidth <= 991) {
          reducedCostGif.style.maxHeight = '250px';
        } else {
          reducedCostGif.style.maxHeight = '300px';
        }
      }
    }
    
    // Initial adjustment
    adjustImageSizes();
    
    // Adjust on resize
    window.addEventListener('resize', adjustImageSizes);
  });
</script>
</body>
</html>