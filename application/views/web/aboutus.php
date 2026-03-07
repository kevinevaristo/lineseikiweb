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
   NAVBAR
=================================*/
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

.navbar-nav > li:nth-child(3) > .dropdown-toggle::after {
  display: none !important;
}

/* ===============================
   SECTIONS
=================================*/
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

section h1,
section h2 {
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
   HERO SECTION
=================================*/
.hero-section {
  position: relative;
  height: 50vh;
  min-height: 400px;
  background: linear-gradient(135deg, rgba(15, 70, 123, 0.85) 0%, rgba(23, 162, 220, 0.75) 100%),
              url("<?= base_url('assets_system/images/Hero.jpg') ?>") center center/cover no-repeat;
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 0 20px;
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
  color: white !important;
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
  background-color: #E3F2FD;
  border-radius: 15px;
  padding: 30px 25px;
  width: 280px;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  cursor: default;
  min-height: 200px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  text-align: center;
}

/* HOVER EFFECT */
.concept-box:hover {
  transform: translateY(-10px);
  box-shadow: 0 20px 40px rgba(13, 110, 253, 0.2);
  background-color: var(--primary-blue);
}

.concept-box h1 {
  margin: 0 auto 10px auto;
  color: var(--primary-blue);
  font-weight: 800;
  transition: color 0.3s ease;
  font-size: 2.5rem;
}

.concept-box p {
  color: var(--primary-blue);
  font-size: 0.95rem;
  line-height: 1.5;
  font-weight: 500;
  transition: color 0.3s ease;
  margin-bottom: 0;
}

/* Change text to white on hover */
.concept-box:hover h1,
.concept-box:hover p {
  color: #ffffff !important;
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

/* ===============================
   COMBINED SECTION
=================================*/
#combined-section {
  position: relative;
  color: #fff;
  padding: 120px 0;
  border-radius: 15px;
  overflow: hidden;
  background: radial-gradient(circle at top right, rgba(66, 134, 244, 0.3), transparent 40%),
              linear-gradient(135deg, #0F467B 40%, #4286f4 100%),
              linear-gradient(0deg, rgba(255,255,255,0.05) 1px, transparent 1px),
              linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
  background-size: cover, cover, 40px 40px, 40px 40px;
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

#combined-section img {
  max-height: 400px;
  width: auto;
  margin: 0 auto;
  display: block;
  border-radius: 12px;
}

/* ===============================
   MISSION VISION SECTION
=================================*/
.mission-vision-section {
  position: relative;
  background: url("<?= base_url('assets_system/images/m-and-v.jpg') ?>") center center/cover no-repeat;
  color: #333;
  padding: 120px 0;
  overflow: hidden;
  min-height: 500px;
}

.mission-vision-section::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
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
  font-size: 2rem;
}

.mission-vision-section p {
  color: black;
  font-size: 1.1rem;
  max-width: 700px;
  line-height: 1.7;
}

.mission-vision-section h2::after {
  content: none !important;
}

/* ===============================
   PARTNERS SECTION
=================================*/
.partners-section {
  background: linear-gradient(135deg, var(--light-blue) 0%, #fff 100%);
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.partners-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2317A2DC' fill-opacity='0.05'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  z-index: 0;
}

.partners-container {
  position: relative;
  z-index: 1;
}

.partners-header {
  text-align: center;
  margin-bottom: 60px;
  padding: 0 20px;
}

.partners-header h2 {
  font-size: 2.5rem;
  color: var(--newblue2);
  margin-bottom: 15px;
  position: relative;
  display: inline-block;
}

.partners-header h2::after {
  content: '';
  position: absolute;
  bottom: -15px;
  left: 50%;
  transform: translateX(-50%);
  width: 80px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  border-radius: 2px;
}

.partners-header p {
  color: #666;
  max-width: 600px;
  margin: 30px auto 0;
  font-size: 1.1rem;
  line-height: 1.7;
}

.partners-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 30px;
  margin-top: 50px;
  padding: 0 20px;
}

.partner-card {
  background: white;
  border-radius: 16px;
  padding: 30px 20px;
  text-align: center;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  transition: var(--transition);
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 180px;
  min-height: 180px;
}

.partner-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  transform: scaleX(0);
  transform-origin: left;
  transition: transform 0.4s ease;
}

.partner-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.partner-card:hover::before {
  transform: scaleX(1);
}

.partner-logo {
  max-height: 80px;
  max-width: 160px;
  object-fit: contain;
  opacity: 0.8;
  transition: var(--transition);
}

.partner-card:hover .partner-logo {
  opacity: 1;
  transform: scale(1.05);
}

.partner-name {
  margin-top: 15px;
  font-weight: 600;
  color: var(--newblue2);
  font-size: 0.9rem;
  opacity: 0;
  transform: translateY(10px);
  transition: var(--transition);
}

.partner-card:hover .partner-name {
  opacity: 1;
  transform: translateY(0);
}

/* Placeholder for missing logos */
.partner-logo.placeholder {
  width: 80px;
  height: 80px;
  background: linear-gradient(135deg, var(--light-blue), #ffffff);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.partner-initials {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--newblue2);
}

/* Animation for logos */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.partner-card {
  animation: fadeInUp 0.6s ease forwards;
}

.partner-card:nth-child(1) { animation-delay: 0.1s; }
.partner-card:nth-child(2) { animation-delay: 0.2s; }
.partner-card:nth-child(3) { animation-delay: 0.3s; }
.partner-card:nth-child(4) { animation-delay: 0.4s; }
.partner-card:nth-child(5) { animation-delay: 0.5s; }
.partner-card:nth-child(6) { animation-delay: 0.6s; }

/* ===============================
   CTA SECTION
=================================*/
.cta-wavenet-style {
  background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
  color: white;
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.cta-wavenet-style::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff' fill-opacity='0.1'%3E%3C/path%3E%3C/svg%3E"),
              url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%23ffffff' fill-opacity='0.05'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  z-index: 1;
  animation: waveMove 15s ease-in-out infinite alternate;
}

.cta-container {
  position: relative;
  z-index: 2;
  padding: 0 20px;
}

.cta-wavenet-style h2 {
  font-size: 2.5rem;
  font-weight: 700;
  margin-bottom: 25px;
  color: white;
  text-align: center;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
  line-height: 1.3;
}

.cta-wavenet-style p {
  font-size: 1.2rem;
  opacity: 0.9;
  margin-bottom: 40px;
  text-align: center;
  text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
}

@keyframes waveMove {
  0% {
    background-position: bottom center, top center;
  }
  100% {
    background-position: bottom 10px center, top -10px center;
  }
}

/* Button styling */
.btn-wavenet-cta {
  background-color: var(--newblue) !important;
  color: white !important;
  font-weight: 700 !important;
  transition: transform 0.3s ease;
  position: relative;
  z-index: 2;
  display: inline-block;
  padding: 1rem 2.5rem;
  font-size: 1.1rem;
}

.btn-wavenet-cta:hover {
  background-color: var(--newblue) !important;
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
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
section h2::after {
  left: 0 !important;
  transform: none !important;
}

section h2.text-center::after {
  left: 50% !important;
  transform: translateX(-50%) !important;
}

/* Spacing utilities */
.mb-5 {
  margin-bottom: 3rem !important;
}

/* ===============================
   RESPONSIVE DESIGN
=================================*/

/* Large screens (1200px and above) */
@media (min-width: 1200px) {
  .hero-section {
    padding-left: 250px;
  }
  
  .hero-section h1 {
    font-size: 3.5rem;
  }
  
  .partners-grid {
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  }
  
  #combined-section img {
    max-height: 450px;
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
  
  .hero-section {
    padding: 0 50px;
  }
  
  .hero-section h1 {
    font-size: 3rem;
  }
  
  .concept-box {
    width: 240px;
  }
  
  .concept-box h1 {
    font-size: 2.2rem;
  }
  
  .partners-header h2 {
    font-size: 2.2rem;
  }
  
  .cta-wavenet-style h2 {
    font-size: 2.2rem;
  }
  
  #combined-section img {
    max-height: 350px;
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
  
  .hero-section {
    padding: 0 30px;
    height: 40vh;
    min-height: 350px;
    justify-content: center;
    text-align: center;
  }
  
  .hero-section h1 {
    font-size: 2.5rem;
  }
  
  .hero-overlay {
    padding: 20px 25px;
  }
  
  .concept-boxes {
    gap: 15px;
  }
  
  .concept-box {
    width: calc(50% - 15px);
    min-height: 180px;
    padding: 25px 20px;
  }
  
  .concept-box h1 {
    font-size: 2rem;
  }
  
  #combined-section {
    padding: 80px 0;
  }
  
  #combined-section img {
    max-height: 300px;
    margin-bottom: 30px;
  }
  
  .mission-vision-section {
    padding: 80px 0;
    min-height: 400px;
  }
  
  .mission-vision-section h2 {
    font-size: 1.8rem;
  }
  
  .partners-section {
    padding: 80px 0;
  }
  
  .partners-header h2 {
    font-size: 2rem;
  }
  
  .partners-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }
  
  .partner-card {
    height: 160px;
    min-height: 160px;
    padding: 20px 15px;
  }
  
  .partner-logo {
    max-height: 70px;
    max-width: 140px;
  }
  
  .cta-wavenet-style {
    padding: 80px 0;
  }
  
  .cta-wavenet-style h2 {
    font-size: 2rem;
  }
  
  .cta-wavenet-style p {
    font-size: 1.1rem;
  }
  
  .dropdown-submenu > .dropdown-menu {
    left: 0;
    margin-top: 0;
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
  
  .hero-section {
    padding: 0 20px;
    height: 35vh;
    min-height: 300px;
  }
  
  .hero-section h1 {
    font-size: 2rem;
  }
  
  .hero-overlay {
    padding: 15px 20px;
  }
  
  .concept-boxes {
    gap: 15px;
  }
  
  .concept-box {
    width: 100%;
    min-height: 160px;
    padding: 20px 15px;
  }
  
  .concept-box h1 {
    font-size: 1.8rem;
  }
  
  .concept-box p {
    font-size: 0.9rem;
  }
  
  #combined-section {
    padding: 60px 0;
  }
  
  #combined-section h1 {
    font-size: 1.8rem;
  }
  
  #combined-section img {
    max-height: 250px;
  }
  
  .mission-vision-section {
    padding: 60px 0;
    min-height: 350px;
  }
  
  .mission-vision-section h2 {
    font-size: 1.6rem;
  }
  
  .mission-vision-section p {
    font-size: 1rem;
  }
  
  .partners-section {
    padding: 60px 0;
  }
  
  .partners-header h2 {
    font-size: 1.8rem;
  }
  
  .partners-header p {
    font-size: 1rem;
  }
  
  .partners-grid {
    grid-template-columns: 1fr;
    gap: 15px;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
  }
  
  .partner-card {
    height: 140px;
    min-height: 140px;
  }
  
  .partner-logo {
    max-height: 60px;
    max-width: 120px;
  }
  
  .cta-wavenet-style {
    padding: 60px 0;
  }
  
  .cta-wavenet-style h2 {
    font-size: 1.8rem;
  }
  
  .cta-wavenet-style p {
    font-size: 1rem;
  }
  
  .btn-wavenet-cta {
    padding: 0.9rem 2rem;
    font-size: 1rem;
  }
  
  .navbar-nav .nav-link {
    padding: 0.5rem 0.8rem;
    font-size: 0.95rem;
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
  
  .hero-section {
    height: 30vh;
    min-height: 250px;
  }
  
  .hero-section h1 {
    font-size: 1.8rem;
  }
  
  .concept-box {
    min-height: 140px;
    padding: 15px 10px;
  }
  
  .concept-box h1 {
    font-size: 1.6rem;
  }
  
  .concept-box p {
    font-size: 0.85rem;
  }
  
  #combined-section {
    padding: 50px 0;
  }
  
  #combined-section h1 {
    font-size: 1.6rem;
  }
  
  #combined-section img {
    max-height: 200px;
  }
  
  .mission-vision-section {
    padding: 50px 0;
    min-height: 300px;
  }
  
  .mission-vision-section h2 {
    font-size: 1.4rem;
  }
  
  .mission-vision-section p {
    font-size: 0.95rem;
  }
  
  .partners-section {
    padding: 50px 0;
  }
  
  .partners-header h2 {
    font-size: 1.6rem;
  }
  
  .partner-card {
    height: 120px;
    min-height: 120px;
    padding: 15px 10px;
  }
  
  .partner-logo {
    max-height: 50px;
  }
  
  .partner-name {
    font-size: 0.8rem;
  }
  
  .cta-wavenet-style {
    padding: 50px 0;
  }
  
  .cta-wavenet-style h2 {
    font-size: 1.6rem;
    line-height: 1.2;
  }
  
  .btn {
    padding: 0.7rem 1.5rem;
    font-size: 0.95rem;
  }
}
</style>
</head>
<body>

<!-- ✅ Fixed Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container">
    <!-- Logo on the LEFT -->
    <a class="navbar-brand" href="<?= base_url('index') ?>">
      <img src="<?= base_url('assets_system/images/header_logo.png') ?>" alt="Line Seiki Logo">
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
    <h2 class="fade-in"><?php echo $header ?: 'Line Seiki Asia Pacific Inc.'; ?></h2>
    <p class="lead fade-in delay-1">
      <?php echo $header_text ?: 'At Line Seiki Asia Pacific, Inc. (LSA), we bridge innovation from Japan to industries across the Asia-Pacific region. As the official sales arm of Line Seiki Co., Ltd., we bring decades of expertise in measurement technology, automation, and smart manufacturing solutions closer to our partners and customers.'; ?>
    </p>
    
    <!-- ✅ New Boxes Section -->
    <div class="concept-boxes">
      <?php if (!empty($stats)): ?>
        <?php foreach ($stats as $stat): ?>
        <div class="concept-box">
          <h1><?php echo htmlspecialchars($stat->stat_value); ?></h1>
          <p><?php echo htmlspecialchars($stat->stat_label); ?></p>
        </div>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback boxes if no data -->
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
          <p>Expertise in Measuring & Industrial Solutions</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- Combined Section: New Businesses Challenge + Integrated Production + Strict Inspection for Quality -->
<section id="combined-section" class="section-light-blue">
  <div class="container">
    <?php if (!empty($sections)): ?>
      <?php foreach ($sections as $index => $section): ?>
      <!-- Row <?php echo $index + 1; ?> -->
      <div class="row align-items-center mb-5 <?php echo $index % 2 == 1 ? 'flex-lg-row-reverse' : ''; ?>">
        <div class="col-lg-6 text-center text-lg-start">
          <h1 class="fade-in"><?php echo $section['header'] ?: 'Section Header'; ?></h1>
          <p class="lead fade-in delay-1">
            <?php echo $section['text'] ?: 'Section text content here.'; ?>
          </p>
        </div>
        <div class="col-lg-6 text-center">
          <?php if (!empty($section['image'])): ?>
          <img src="<?php echo base_url('assets_system/images/' . $section['image']); ?>" 
               alt="<?php echo $section['header']; ?>" 
               class="fade-in delay-2 img-fluid">
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    <?php else: ?>
      <!-- Fallback sections if no data -->
      <!-- First Row -->
      <div class="row align-items-center mb-5">
        <div class="col-lg-6 text-center text-lg-start">
          <h1 class="fade-in">Our Regional Commitment</h1>
          <p class="lead fade-in delay-1">
            Connecting Customers and Solutions. We serve as the direct link between Line Seiki Japan and industries across Asia Pacific. From inquiry to delivery, our team ensures that customers receive the right products, technical support, and guidance tailored to their specific applications.
          </p>
        </div>
        <div class="col-lg-6 text-center">
          <img src="<?php echo base_url('assets_system/images/newb.jpg'); ?>" alt="New Businesses Challenge" class="fade-in delay-2 img-fluid">
        </div>
      </div>

      <!-- Second Row -->
      <div class="row align-items-center flex-lg-row-reverse mb-5">
        <div class="col-lg-6 text-center text-lg-start">
          <h1 class="fade-in">Collaboration Across Borders</h1>
          <p class="lead fade-in delay-1">
            Working closely with our headquarters and distributors, we help expand the reach of Line Seiki's technologies throughout the region. Through partnerships, training, and joint initiatives, we strengthen communication between engineers, manufacturers, and end users.
          </p>
        </div>
        <div class="col-lg-6 text-center">
          <img src="<?php echo base_url('assets_system/images/integrated.jpg'); ?>" alt="Integrated Production" class="fade-in delay-2 img-fluid">
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
          <img src="<?php echo base_url('assets_system/images/strict.jpg'); ?>" alt="Strict Inspection for Quality" class="fade-in delay-2 img-fluid">
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Mission and Vision -->
<section class="mission-vision-section">
  <div class="mission-vision-overlay">
    <div class="container text-start">
      <h2 class="fade-in">Mission</h2>
      <p class="mb-5 fade-in delay-1">
        <?php echo $mission ?: 'To deliver accurate, reliable, and innovative measurement and monitoring solutions that empower manufacturers to achieve operational excellence and sustainable growth.'; ?>
      </p>
      <h2 class="fade-in">Vision</h2>
      <p class="fade-in delay-2">
        <?php echo $vision ?: 'To be the preferred partner in Southeast Asia for industrial process monitoring, enabling smarter, more connected, and more efficient manufacturing environments'; ?>
      </p>
    </div>
  </div>
</section>

<!-- Partner / Association Logos - MODERN DESIGN -->
<section class="partners-section">
  <div class="container partners-container">
    <div class="partners-header">
      <h2 class="fade-in"><?php echo $partner_header ?: 'Our Valued Partners & Associations'; ?></h2>
      <p class="fade-in delay-1">
        <?php echo $partner_text ?: "We're proud to collaborate with industry leaders and organizations that share our commitment to innovation, quality, and excellence in manufacturing technology."; ?>
      </p>
    </div>
    
    <div class="partners-grid">
      <?php foreach ($partners as $partner): ?>
      <div class="partner-card fade-in">
        <?php if (!empty($partner->partner_logo) && file_exists(FCPATH . 'assets_system/images/' . $partner->partner_logo)): ?>
          <img src="<?php echo base_url('assets_system/images/' . $partner->partner_logo); ?>" 
               alt="<?php echo htmlspecialchars($partner->partner_name); ?>" 
               class="partner-logo"
               loading="lazy">
        <?php else: ?>
          <!-- Show placeholder or initials -->
          <div class="partner-logo placeholder">
            <span class="partner-initials">
              <?php 
              // Show first letter of each word
              $words = explode(' ', $partner->partner_name);
              $initials = '';
              foreach ($words as $word) {
                $initials .= strtoupper(substr($word, 0, 1));
                if (strlen($initials) >= 2) break;
              }
              echo $initials ?: 'P';
              ?>
            </span>
          </div>
        <?php endif; ?>
        <div class="partner-name"><?php echo htmlspecialchars($partner->partner_name); ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-wavenet-style text-center">
  <div class="cta-container">
    <div class="container">
      <h2 class="fade-in">
        Interested in our products or services?<br>Connect with us today and let's build solutions together.  
      </h2>
      <a href="<?php echo base_url('index/contact_us'); ?>" class="btn btn-lg btn-wavenet-cta fade-in delay-2">
        Get in Touch 
      </a>
    </div>
  </div>
</section>

<!-- Footer -->
<?php $this->load->view('web/footer'); ?>

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
    
    // Image size adjustments
    function adjustImageSizes() {
      // Combined section images
      const combinedImages = document.querySelectorAll('#combined-section img');
      combinedImages.forEach(img => {
        if (window.innerWidth <= 767) {
          img.style.maxHeight = '250px';
        } else if (window.innerWidth <= 991) {
          img.style.maxHeight = '300px';
        } else {
          img.style.maxHeight = '400px';
        }
      });
      
      // Partner logos
      const partnerLogos = document.querySelectorAll('.partner-logo');
      partnerLogos.forEach(logo => {
        if (window.innerWidth <= 767) {
          logo.style.maxHeight = '50px';
          logo.style.maxWidth = '120px';
        } else if (window.innerWidth <= 991) {
          logo.style.maxHeight = '70px';
          logo.style.maxWidth = '140px';
        } else {
          logo.style.maxHeight = '80px';
          logo.style.maxWidth = '160px';
        }
      });
    }
    
    // Initial adjustment
    adjustImageSizes();
    
    // Adjust on resize
    window.addEventListener('resize', adjustImageSizes);
  });
</script>

</body>
</html>