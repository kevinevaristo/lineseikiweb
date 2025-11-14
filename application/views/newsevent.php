<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professional News & Events</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <style>
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

    body {
      background-color: #fff;
      color: #333;
      font-family: 'Inter', sans-serif;
      line-height: 1.6;
      overflow-x: hidden;
    }

    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Modernized Navbar */
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
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
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
    
    .navbar-brand img {
      height: 40px;
      width: auto;
      transition: var(--transition);
    }
    
    .dropdown-submenu {
      position: relative;
    }
    
    .dropdown-submenu > .dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -0.8rem;
    }

    /* Sections */
    section {
      padding: 100px 0;
      position: relative;
    }
    
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
    
    section h2::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
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

    /* Color schemes */
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
    
    /* Section Light Orange with Wavy Gradient */
.section-light-orange {
  background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
  color: white;
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.section-light-orange::before {
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

/* Floating circles for section light orange */
.section-light-orange::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  animation: float 20s ease-in-out infinite;
}

.section-light-orange .container {
  position: relative;
  z-index: 2;
}


    /* News & Events Cards */
    .content-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .news-card {
      background-color: #fff;
      color: #333;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .news-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .news-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    
    .news-card-content {
      padding: 25px;
      text-align: left;
    }
    
    .news-card h3 {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--primary-blue);
    }
    
    .news-card p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .news-card a {
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--primary-blue);
      text-decoration: none;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
    }
    
    .news-card a:hover {
      color: var(--newblue2);
    }
    
    .news-card a::after {
      content: '→';
      margin-left: 5px;
      transition: var(--transition);
    }
    
    .news-card a:hover::after {
      transform: translateX(3px);
    }

    /* Buttons */
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

    /* Footer */
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
    
    hr {
      background: rgba(255, 255, 255, 0.1);
      height: 1px;
    }
    
    /* Animations */
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
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
      section {
        padding: 80px 0;
      }
      
      section h1 {
        font-size: 2.4rem;
      }
      
      section h2 {
        font-size: 2rem;
      }
      
      .dropdown-submenu > .dropdown-menu {
        left: 0;
        margin-top: 0;
      }
      
      footer .links a {
        display: inline-block;
        margin-bottom: 12px;
      }
      
      .content-container {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      }
    }
    
    @media (max-width: 768px) {
      section h1 {
        font-size: 2rem;
      }
      
      section h2 {
        font-size: 1.8rem;
      }
      
      footer .links a {
        display: block;
        margin-bottom: 12px;
      }
    }
/* Remove the spacer div under the navbar */
body > div[style*="margin-top: 90px"] {
  display: none !important;
}

/* =========================================================
   📰 ENHANCED NEWS & EVENTS STYLES
========================================================= */

/* Hero Section with Background Image & Blue Overlay */
.news-hero {
  background: 
    /* Blue overlay */
    linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
    /* Background image */
    url('<?= base_url('assets_system/images/new4.jpg') ?>') center/cover no-repeat;
  color: white;
  padding: 150px 0 80px;
  text-align: center;
  position: relative;
  overflow: hidden;
  min-height: 70vh;
  display: flex;
  align-items: center;
}

.news-hero::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    radial-gradient(circle at 20% 80%, rgba(23, 162, 220, 0.2) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(15, 70, 123, 0.15) 0%, transparent 50%);
  z-index: 1;
}

.news-hero .container {
  position: relative;
  z-index: 2;
}

.news-hero h1 {
  font-size: 3.5rem;
  font-weight: 800;
  margin-bottom: 1rem;
  color: white;
  text-transform: uppercase;
  letter-spacing: -0.5px;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.news-hero p {
  font-size: 1.3rem;
  max-width: 600px;
  margin: 0 auto;
  opacity: 0.95;
  text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
  color: white;
}

/* Responsive adjustments for hero */
@media (max-width: 992px) {
  .news-hero {
    padding: 120px 0 60px;
    min-height: 60vh;
  }
  
  .news-hero h1 {
    font-size: 2.8rem;
  }
  
  .news-hero p {
    font-size: 1.2rem;
  }
}

@media (max-width: 768px) {
  .news-hero {
    padding: 100px 0 50px;
    min-height: 50vh;
  }
  
  .news-hero h1 {
    font-size: 2.2rem;
  }
  
  .news-hero p {
    font-size: 1.1rem;
  }
}

@media (max-width: 480px) {
  .news-hero {
    padding: 80px 0 40px;
    min-height: 40vh;
  }
  
  .news-hero h1 {
    font-size: 2rem;
  }
  
  .news-hero p {
    font-size: 1rem;
  }
}
/* Filter Section */
.news-filter {
  background: white;
  padding: 2rem 0;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
  position: sticky;
  top: 80px;
  z-index: 100;
}

.filter-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  flex-wrap: wrap;
}

.filter-btn {
  background: transparent;
  border: 2px solid var(--newblue);
  color: var(--newblue);
  padding: 0.7rem 1.5rem;
  border-radius: 50px;
  font-weight: 600;
  transition: var(--transition);
}

.filter-btn:hover,
.filter-btn.active {
  background: var(--newblue);
  color: white;
  transform: translateY(-2px);
  box-shadow: 0 5px 15px rgba(23, 162, 220, 0.3);
}

/* Enhanced News Cards */
.news-card {
  position: relative;
}

.news-badge {
  position: absolute;
  top: 1rem;
  left: 1rem;
  background: var(--newblue);
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 50px;
  font-size: 0.8rem;
  font-weight: 600;
  z-index: 2;
}

.news-badge.event {
  background: var(--primary-orange);
}

.news-badge.featured {
  background: linear-gradient(135deg, #ff6b6b, #ee5a24);
}

.news-date {
  color: var(--newblue);
  font-size: 0.9rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
  display: block;
}

.news-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1rem;
}

.news-category {
  background: var(--light-blue);
  color: var(--newblue2);
  padding: 0.3rem 0.8rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
}

.news-read-more {
  color: var(--newblue);
  font-weight: 600;
  text-decoration: none;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  transition: var(--transition);
}

.news-read-more:hover {
  color: var(--newblue2);
  gap: 0.8rem;
}

/* Featured News Card */
.featured-news {
  grid-column: span 2;
  display: flex;
}

.featured-news .news-image {
  flex: 1;
  min-height: 300px;
}

.featured-news .news-card-content {
  flex: 1;
  padding: 2.5rem;
}

/* Event Countdown */
.event-countdown {
  background: rgba(255, 255, 255, 0.1);
  border-radius: 12px;
  padding: 1.5rem;
  margin-top: 1.5rem;
  backdrop-filter: blur(10px);
}

.countdown-title {
  font-size: 1rem;
  margin-bottom: 1rem;
  opacity: 0.9;
}

.countdown-timer {
  display: flex;
  gap: 1rem;
  justify-content: center;
}

.countdown-item {
  text-align: center;
  background: rgba(255, 255, 255, 0.2);
  border-radius: 8px;
  padding: 0.8rem;
  min-width: 60px;
}

.countdown-number {
  font-size: 1.5rem;
  font-weight: 700;
  display: block;
}

.countdown-label {
  font-size: 0.7rem;
  opacity: 0.8;
  text-transform: uppercase;
}

/* Newsletter Section with Background Image */
.newsletter-section {
  background: 
    /* Blue overlay */
    linear-gradient(135deg, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.3) 100%)
,
    /* Background image */
    url('<?= base_url('assets_system/images/.jpg') ?>') center/cover no-repeat;
  color: white;
  padding: 100px 0;
  text-align: center;
  border-radius: 20px;
  position: relative;
  overflow: hidden;
}

.newsletter-section::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(15, 70, 123, 0.1);
  z-index: 1;
}

.newsletter-section .container {
  position: relative;
  z-index: 2;
}

.newsletter-section h2 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 25px;
  text-align: center;
  text-shadow: none; /* Remove shadow (optional, but makes gradient cleaner) */

  /* Gradient text */
  background: linear-gradient(95deg, var(--newblue2) 0%, var(--newblue2) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}


.newsletter-section p {
  font-size: 1.2rem;
  opacity: 0.9;
  margin-bottom: 40px;
  text-align: center;
  text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
  color: var(--newblue2)
}

.newsletter-form {
  max-width: 500px;
  margin: 2rem auto 0;
  display: flex;
  gap: 1rem;
  position: relative;
  z-index: 2;
}

.newsletter-form .form-control {
  flex: 1;
  border: none;
  border-radius: 50px;
  padding: 1rem 1.5rem;
  font-size: 1rem;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  background: rgba(255, 255, 255, 0.95);
}

.newsletter-form .form-control:focus {
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.3);
  background: white;
}

.newsletter-form .btn {
  border-radius: 50px;
  padding: 1rem 2rem;
  white-space: nowrap;
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  border: none;
  font-weight: 700;
  
  transition: var(--transition);
}

.newsletter-form .btn:hover {
  background: linear-gradient(135deg, var(--newblue), var(--newblue2));
  transform: translateY(-2px);
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

/* Floating animation */
@keyframes float {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(180deg);
  }
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .section-light-orange,
  .newsletter-section {
    padding: 80px 0;
  }
  
  .section-light-orange h2,
  .newsletter-section h2 {
    font-size: 2.4rem;
  }
  
  .section-light-orange p,
  .newsletter-section p {
    font-size: 1.1rem;
  }
  
  .newsletter-form {
    flex-direction: column;
    max-width: 400px;
  }
  
  .newsletter-form .btn {
    width: 100%;
  }
}

@media (max-width: 480px) {
  .section-light-orange,
  .newsletter-section {
    padding: 60px 0;
  }
  
  .section-light-orange h2,
  .newsletter-section h2 {
    font-size: 2rem;
  }
  
  .section-light-orange p,
  .newsletter-section p {
    font-size: 1rem;
  }
  
  .newsletter-form {
    max-width: 300px;
  }
}
/* Pagination */
.news-pagination {
  display: flex;
  justify-content: center;
  gap: 0.5rem;
  margin: 3rem 0;
}

.page-link {
  border: 2px solid var(--light-blue);
  color: var(--newblue2);
  padding: 0.7rem 1.2rem;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 600;
  transition: var(--transition);
}

.page-link:hover,
.page-link.active {
  background: var(--newblue);
  color: white;
  border-color: var(--newblue);
}

/* Responsive adjustments for news page */
@media (max-width: 992px) {
  .featured-news {
    grid-column: span 1;
    flex-direction: column;
  }
  
  .news-hero h1 {
    font-size: 2.8rem;
  }
}

@media (max-width: 768px) {
  .news-hero h1 {
    font-size: 2.2rem;
  }
  
  .newsletter-form {
    flex-direction: column;
  }
  
  .filter-buttons {
    justify-content: flex-start;
    overflow-x: auto;
    padding-bottom: 0.5rem;
  }
  
  .filter-btn {
    white-space: nowrap;
  }
}


  </style>
</head>
<body>
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
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Product and Services
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" href="<?= base_url('index/ps_prod') ?>">Products</a></li>
              <li class="dropdown-submenu dropend">
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

  <!-- Offset for fixed navbar -->
  <div style="margin-top: 90px;"></div>

  <!-- Hero Section -->
  <section class="news-hero fade-in">
    <div class="container">
      <h1>News & Events</h1>
      <p>Stay updated with the latest developments, exhibitions, and innovations from Line Seiki</p>
    </div>
  </section>

  <!-- Filter Section -->
  <div class="news-filter fade-in delay-1">
    <div class="container">
      <div class="filter-buttons">
        <button class="filter-btn active" data-filter="all">All Updates</button>
        <button class="filter-btn" data-filter="news">Company News</button>
        <button class="filter-btn" data-filter="events">Events & Exhibitions</button>
        <button class="filter-btn" data-filter="product">Product Updates</button>
        <button class="filter-btn" data-filter="webinars">Webinars</button>
      </div>
    </div>
  </div>

  <!-- News and Updates Section -->
  <section class="section-light-blue">
    <div class="container">
      <h2 class="fade-in text-center">Latest News & Updates</h2>
      <div class="content-container pt-4">
        <!-- Featured News -->
        <div class="news-card featured-news fade-in delay-1" data-category="events">
          <div class="news-image">
            <img src="<?= base_url('assets_system/images/event1.jpg') ?>" alt="Japan Pack 2025">
            <span class="news-badge featured">Featured Event</span>
          </div>
          <div class="news-card-content">
            <span class="news-date">October 7-10, 2025</span>
            <h3>Line Seiki to Exhibit at JAPAN PACK 2025</h3>
            <p>Join us at Tokyo Big Sight as we showcase our latest measuring instruments, sensors, and IoT solutions. Visit booth 5-122 to see live demonstrations and meet our technical experts.</p>
            
            <div class="event-countdown">
              <div class="countdown-title">Event Starts In:</div>
              <div class="countdown-timer">
                <div class="countdown-item">
                  <span class="countdown-number" id="days">00</span>
                  <span class="countdown-label">Days</span>
                </div>
                <div class="countdown-item">
                  <span class="countdown-number" id="hours">00</span>
                  <span class="countdown-label">Hours</span>
                </div>
                <div class="countdown-item">
                  <span class="countdown-number" id="minutes">00</span>
                  <span class="countdown-label">Minutes</span>
                </div>
              </div>
            </div>
            
            <div class="news-meta">
              <span class="news-category">Exhibition</span>
              <a href="<?= base_url('index/news_events_extension') ?>" class="news-read-more">
                Learn More <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <!-- Regular News Cards -->
        <div class="news-card fade-in delay-2" data-category="product">
          <div class="news-image">
            <img src="<?= base_url('assets_system/images/newlaunch1.jpg') ?>" alt="New Product Launch">
            <span class="news-badge">New Release</span>
          </div>
          <div class="news-card-content">
            <span class="news-date">August 15, 2025</span>
            <h3>Introducing Our Next-Gen Safety Switches</h3>
            <p>Discover our latest safety switches and relays designed for smarter, safer manufacturing environments with enhanced durability and reliability.</p>
            <div class="news-meta">
              <span class="news-category">Product Update</span>
              <a href="<?= base_url('index/news_events_extension') ?>" class="news-read-more">
                Read More <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="news-card fade-in delay-3" data-category="news">
          <div class="news-image">
            <img src="<?= base_url('assets_system/images/newlaunch4.jpg') ?>" alt="Strategic Partnership">
            <span class="news-badge">Announcement</span>
          </div>
          <div class="news-card-content">
            <span class="news-date">July 28, 2025</span>
            <h3>Line Seiki Announces Strategic Partnership</h3>
            <p>We're excited to announce our new partnership with leading automation companies to expand our IoT solutions portfolio across Asia Pacific.</p>
            <div class="news-meta">
              <span class="news-category">Company News</span>
              <a href="<?= base_url('index/news_events_extension') ?>" class="news-read-more">
                Read More <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="news-card fade-in delay-2" data-category="webinars">
          <div class="news-image">
            <img src="<?= base_url('assets_system/images/webinar4.jpg') ?>" alt="Webinar on IoT solutions">
            <span class="news-badge event">Webinar</span>
          </div>
          <div class="news-card-content">
            <span class="news-date">September 5, 2025</span>
            <h3>Smart IoT Solutions for Modern Manufacturing</h3>
            <p>Join our expert-led webinar on integrating smart solutions for seamless operational control and data-driven decision making.</p>
            <div class="news-meta">
              <span class="news-category">Online Event</span>
              <a href="<?= base_url('index/news_events_extension') ?>" class="news-read-more">
                Register Now <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="news-card fade-in delay-3" data-category="news">
          <div class="news-image">
            <img src="<?= base_url('assets_system/images/newlaunch3.jpg') ?>" alt="Industry Report">
            <span class="news-badge">Insight</span>
          </div>
          <div class="news-card-content">
            <span class="news-date">June 12, 2025</span>
            <h3>2025 Manufacturing Technology Trends</h3>
            <p>Our latest industry report analyzes emerging trends in precision measurement and automation technologies shaping the future of manufacturing.</p>
            <div class="news-meta">
              <span class="news-category">Industry Insight</span>
              <a href="<?= base_url('index/news_events_extension') ?>" class="news-read-more">
                Read More <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>

        <div class="news-card fade-in delay-4" data-category="events">
          <div class="news-image">
            <img src="<?= base_url('assets_system/images/event3.jpg') ?>" alt="Technical Seminar">
            <span class="news-badge event">Seminar</span>
          </div>
          <div class="news-card-content">
            <span class="news-date">November 15, 2025</span>
            <h3>Technical Seminar: Advanced Measurement Techniques</h3>
            <p>A series of talks by our engineers on the latest advancements in industrial measurement and precision instruments.</p>
            <div class="news-meta">
              <span class="news-category">Live Event</span>
              <a href="<?= base_url('index/news_events_extension') ?>" class="news-read-more">
                View Schedule <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Pagination -->
      <div class="news-pagination fade-in delay-5">
        <a href="#" class="page-link active">1</a>
        <a href="#" class="page-link">2</a>
        <a href="#" class="page-link">3</a>
        <a href="#" class="page-link">Next <i class="fas fa-chevron-right"></i></a>
      </div>
    </div>
  </section>

  <!-- Newsletter Section -->
<section class="section-light-orange">
  <div class="container">
    <div class="newsletter-section">
      <h2>Stay Updated</h2>
      <p>Subscribe to our newsletter for the latest news, events, and product updates</p>
      <form class="newsletter-form">
        <input type="email" class="form-control" placeholder="Enter your email address" required>
        <button type="submit" class="btn btn-orange">Subscribe</button>
      </form>
    </div>
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

      // News filtering functionality
      const filterButtons = document.querySelectorAll('.filter-btn');
      const newsCards = document.querySelectorAll('.news-card');
      
      filterButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Remove active class from all buttons
          filterButtons.forEach(btn => btn.classList.remove('active'));
          // Add active class to clicked button
          this.classList.add('active');
          
          const filterValue = this.getAttribute('data-filter');
          
          newsCards.forEach(card => {
            if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
              card.style.display = 'block';
            } else {
              card.style.display = 'none';
            }
          });
        });
      });

      // Countdown timer for featured event
      function updateCountdown() {
        const eventDate = new Date('October 7, 2025 09:00:00').getTime();
        const now = new Date().getTime();
        const distance = eventDate - now;
        
        if (distance > 0) {
          const days = Math.floor(distance / (1000 * 60 * 60 * 24));
          const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
          const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
          
          document.getElementById('days').textContent = days.toString().padStart(2, '0');
          document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
          document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        }
      }
      
      // Update countdown immediately and then every minute
      updateCountdown();
      setInterval(updateCountdown, 60000);
    });
  </script>
</body>
</html>