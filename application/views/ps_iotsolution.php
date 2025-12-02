<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>IoT Solution - Line Seiki Asia Pacific</title>
  
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

    /* =========================
       🎯 MODERN IOT SECTIONS
    ========================= */

    /* Modern GEMBA Overview Section with Background Image */
.iot-hero {
  background:
    linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
    url('<?= base_url('assets_system/images/Hero-gemba.jpg') ?>') center/cover no-repeat;
  color: white;
  padding: 150px 0 120px;
  position: relative;
  overflow: hidden;
  min-height: 85vh;
  display: flex;
  align-items: center;
  margin-top: -20px;
}

/* Keeps overlay ready for future animations */
.iot-hero::before {
  content: '';
  position: absolute;
  inset: 0;
  z-index: 1;
}

.iot-hero-content {
  position: relative;
  z-index: 2;
}

/* MAIN TITLE */
.iot-hero h2 {
  font-size: 3.2rem;
  font-weight: 800;
  color: white;
  text-transform: uppercase;
  letter-spacing: -1px;
  margin-bottom: 40px;
  position: relative;
  line-height: 1.2;
  text-shadow: 0 3px 15px rgba(0,0,0,0.35);
}

/* TITLE UNDERLINE (AFTER LINE) */
.iot-hero h2::after {
  content: "";
  display: block;
  width: 120px;
  height: 3px;
  background: #42B9FF; /* Modern blue accent */
  margin-top: 18px;
  border-radius: 5px;
}

/* SUBTEXT */
.iot-hero p {
  font-size: 1.25rem;
  opacity: 0.95;
  max-width: 580px;
  text-shadow: 0 2px 6px rgba(0,0,0,0.25);
  margin-bottom: 30px;
}

.iot-demo-btn {
  padding: 12px 28px;
  font-size: 1.1rem;
  font-weight: 600;
  border-radius: 50px;
  margin-top: 20px;
  display: inline-block;
}

    /* Modern Image Hover */
    .img-hover {
      transition: var(--transition);
      
      overflow: hidden;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .img-hover img {
      transition: var(--transition);
      border-radius: 20px;
      width: 100%;
    }
    
    .img-hover:hover img {
      transform: scale(1.05);
    }

    /* =========================================
   OVERRIDE — Make Hero Image Bigger
   ========================================= */
.iot-hero .img-hover img {
  width: 143%;          
  max-width: none;      
  
}

@media (max-width: 992px) {
  .iot-hero .img-hover img {
    width: 100%;
    transform: none;
  }
}
    /* Buttons */
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
      color: var(--newblue2);
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


/* ===============================
   MODERN "OUR SOLUTION" SECTION
=================================*/
/* OPTION 3: ANGLED SLASH DESIGN */
.our-solution {
  padding: 100px 0;
  position: relative;
  background: white;
  overflow: hidden;
}

.our-solution::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  width: 60%; /* Covers the right side */
  height: 100%;
  /* Creates a diagonal blue shape */
  background: linear-gradient(to bottom, #dff0ff, #bfe0ff);
  transform: skewX(-50deg) translateX(10%); /* Slants the shape */
  z-index: 0;
  border-left: 1px solid rgba(13, 110, 253, 0.1);
}

/* Styling for the Title */
.solution-title {
  font-size: 2.8rem;
  font-weight: 700;
  color: var(--newblue2);
  margin-bottom: 10px;
}

/* Styling for the Underline */
.solution-underline {
  width: 70px;
  height: 4px;
  background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
  margin-top: 8px;
  border-radius: 3px;
  margin-bottom: 30px; /* Added space below title */
}

/* Image Styling (Optional: Adds a slight hover float) */
.solution-img-original {
  max-width: 100%;
  height: auto;
  margin-top: 20px;
  border-radius: 16px;
  transition: transform 0.5s ease, box-shadow 0.5s ease;
}

.solution-img-original:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(13, 110, 253, 0.15);
}

/* --- The Text Cards --- */

/* The "Problem" Text */
.problem-box {
  border-left: 4px solid #adb5bd;
  padding-left: 25px;
  margin-bottom: 30px;
}

.problem-box p {
  font-size: 1.15rem;
  color: black; /* Muted text for the 'problem' */
  font-style: italic;
  line-height: 1.8;
}

/* The "Solution" Text (Highlight) */
.solution-box {
  background: white;
  border-radius: 20px;
  padding: 35px;
  box-shadow: 0 15px 40px rgba(23, 162, 220, 0.15); 
  border: 1px solid rgba(23, 162, 220, 0.2);
  position: relative;
  transition: transform 0.3s ease;
}

.solution-box:hover {
  transform: translateY(-5px);
}

.solution-box::before {
  content: '';
  position: absolute;
  left: 0;
  top: 20px;
  bottom: 20px;
  width: 6px;
  background: var(--newblue);
  border-radius: 0 5px 5px 0;
}

.solution-box p {
  font-size: 1.2rem;
  color: var(--dark);
  font-weight: 500;
  margin: 0;
  line-height: 1.7;
}

/* Image Styling */
.solution-img-wrapper {
  position: relative;
  padding: 20px;
}


.solution-img-wrapper:hover .solution-img-original {
  transform: scale(1.02);
 
}

/* Responsive */
@media (max-width: 992px) {
  .solution-box {
    padding: 25px;
    margin-bottom: 40px;
  }
  .solution-img-wrapper {
    padding: 0;
  }
}

/* Our Products Showcase with Wavy Gradient */
.our-products-showcase {
  background: linear-gradient(135deg, var(--newblue2) 50%, var(--newblue) 100%);
  color: white;
  position: relative;
  overflow: hidden;
}

  /* Make the product showcase section smaller */
.our-products-showcase {
  padding: 40px 0 !important; /* was very tall before */
  overflow: visible !important; /* allow image to overflow outside */
}

/* Lift the image higher so it overlaps background */
.products-image-column {
  margin-top: -150px; /* adjust to your liking */
  margin-bottom: -150px;
}

.our-products-showcase::before {
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


/* =========================================
   TECH LINES OVERLAY - THICKER VERSION
========================================= */
.our-products-showcase::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1; 
  pointer-events: none;
  
  /* UPDATED SVG PATTERN:
     I have increased the 'stroke-width' values in the code below.
     Formerly 1.5 -> Now 2.5
     Formerly 1.0 -> Now 1.5
  */
  background-image: url("data:image/svg+xml,%3Csvg width='100%25' height='100%25' viewBox='0 0 1440 600' preserveAspectRatio='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cdefs%3E%3ClinearGradient id='lineGrad' x1='0%25' y1='0%25' x2='100%25' y2='0%25'%3E%3Cstop offset='0%25' stop-color='%2342B9FF' stop-opacity='0' /%3E%3Cstop offset='50%25' stop-color='%2342B9FF' stop-opacity='0.6' /%3E%3Cstop offset='100%25' stop-color='%2342B9FF' stop-opacity='0' /%3E%3C/linearGradient%3E%3C/defs%3E%3C!-- EXISTING LEFT --%3E%3Cpath d='M-100,400 L200,400 L250,350 L550,350' stroke='url(%23lineGrad)' stroke-width='5' fill='none' /%3E%3Ccircle cx='550' cy='350' r='3' fill='%2342B9FF' opacity='0.8' /%3E%3Cpath d='M-100,500 L150,500 L200,450 L450,450' stroke='rgba(66, 185, 255, 0.3)' stroke-width='4' fill='none' /%3E%3Ccircle cx='450' cy='450' r='2' fill='%2342B9FF' opacity='0.6' /%3E%3C!-- EXISTING RIGHT --%3E%3Cpath d='M1540,250 L1240,250 L1190,300 L890,300' stroke='url(%23lineGrad)' stroke-width='4' fill='none' /%3E%3Ccircle cx='890' cy='300' r='3' fill='%2342B9FF' opacity='0.8' /%3E%3Cpath d='M1540,150 L1290,150 L1240,200 L990,200' stroke='rgba(66, 185, 255, 0.3)' stroke-width='4' fill='none' /%3E%3Ccircle cx='990' cy='200' r='2' fill='%2342B9FF' opacity='0.6' /%3E%3C!-- NEW: TOP LEFT VERTICAL --%3E%3Cpath d='M300,-50 L300,50 L350,100 L500,100' stroke='rgba(66, 185, 255, 0.25)' stroke-width='4' fill='none' /%3E%3Ccircle cx='500' cy='100' r='2' fill='%2342B9FF' opacity='0.5' /%3E%3C!-- NEW: BOTTOM CENTER --%3E%3Cpath d='M700,650 L700,550 L750,500 L850,500' stroke='rgba(66, 185, 255, 0.3)' stroke-width='4' fill='none' /%3E%3Ccircle cx='850' cy='500' r='3' fill='%2342B9FF' opacity='0.7' /%3E%3C!-- NEW: FAR RIGHT VERTICAL --%3E%3Cpath d='M1300,-50 L1300,80 L1200,150' stroke='rgba(66, 185, 255, 0.2)' stroke-width='4' fill='none' /%3E%3Ccircle cx='1200' cy='150' r='2' fill='%2342B9FF' opacity='0.5' /%3E%3C/svg%3E");
  
  background-size: cover;
  background-position: center;
}

.our-products-showcase .container {
  position: relative;
  z-index: 2;
}

/* Product Items Styling */

.product-item-title {
  color: white;
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 20px;
  position: relative;
}

.product-item-title::after {
  content: '';
  position: absolute;
  bottom: -8px;
  left: 0;
  width: 50px;
  height: 3px;
  background: white;
  border-radius: 2px;
}

.product-item p {
  color: white;
  font-size: 1.1rem;
  line-height: 1.7;
  margin-bottom: 0;
}

/* Products Image Styling */
.products-image-column {
  position: relative;
}

.products-main-img {
  border-radius: 20px;
  position: relative;
  z-index: 2;
  transition: var(--transition);
}

.products-main-img:hover {
  transform: scale(1.02);
}

.blue-background-effect {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 80%;
  height: 80%;
  background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
  border-radius: 20px;
  z-index: 1;
  animation: pulse 4s ease-in-out infinite;
}

@keyframes pulse {
  0%, 100% {
    opacity: 0.5;
    transform: translate(-50%, -50%) scale(1);
  }
  50% {
    opacity: 0.8;
    transform: translate(-50%, -50%) scale(1.05);
  }
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
@media (max-width: 992px) {
  .our-products-showcase {
    padding: 80px 0;
  }
  
  .product-item {
    padding: 30px 25px;
  }
  
  .product-item-title {
    font-size: 1.6rem;
  }
}

/* FIX: Mobile view — reduce height and remove extreme margins */
@media (max-width: 768px) {

  .our-products-showcase {
    padding: 20px 0 !important; /* much smaller */
  }

  .products-image-column {
    margin-top: -40px !important;   /* was -150px */
    margin-bottom: -20px !important; 
  }

  .products-main-img {
    max-width: 80%;  /* optional: prevents image from being too large */
  }

  .product-item {
    padding: 15px 10px !important; /* smaller spacing */
  }

  .product-item-title {
    font-size: 1.2rem !important;
  }

  .product-item p {
    font-size: 0.95rem !important;
    line-height: 1.4;
  }
}

/* Extra small screens */
@media (max-width: 480px) {
  .products-image-column {
    margin-top: -20px !important;
    margin-bottom: -10px !important;
  }
}

@media (max-width: 480px) {
  .our-products-showcase {
    padding: 50px 0;
  }
  
  .product-item {
    padding: 20px 15px;
  }
  
  .product-item-title {
    font-size: 1.3rem;
  }
}

/* 1. Section Background */
  .system-setup-section {
    /* Light blue gradient background */
    background: #264573;
    padding: 60px 0;
    position: relative;
  }

  /* Title Styling */
.setup-title {
  font-size: 3rem;
  font-weight: 800;
  color: white; /* Dark Blue */
  margin-bottom: 60px;
  text-align: center;
  position: relative; /* Required for the line to stick to the title */
}

/* The "After" Line */
.setup-title::after {
  content: '';
  position: absolute;
  bottom: -15px; /* Distance from the text */
  left: 50%;
  transform: translateX(-50%); /* Centers the line perfectly */
  width: 80px; /* Length of the line */
  height: 4px; /* Thickness */
  /* Signature Line Seiki Gradient */
  background: white; 
  border-radius: 2px;
}
  /* 2. The Vertical Line connecting the numbers */
  .setup-accordion {
    position: relative;
  }
  
  .setup-accordion::before {
    content: '';
    position: absolute;
    top: 25px; 
    bottom: 50px;
    left: 24px; /* Aligns perfectly center with the 50px circles */
    width: 3px;
    background-color: #17A2DC; /* Light blue line */
    z-index: 0;
  }

  /* 3. Remove Default Bootstrap Accordion Styles */
  .setup-accordion .accordion-item {
    border: none;
    background: transparent;
    margin-bottom: 30px; /* Space between items */
  }

  .setup-accordion .accordion-button {
    background: transparent !important; /* Remove default white bg */
    box-shadow: none !important; /* Remove default blue glow */
    padding: 0;
    color: white;
    font-weight: 600;
    font-size: 1.3rem;
    align-items: center;
  }
  
  /* Remove the default arrow icon */
  .setup-accordion .accordion-button::after {
    display: none; 
  }

  /* 4. Style the Number Circles (1, 2, 3...) */
  .step-number {
    width: 50px;
    height: 50px;
    background: white;
    color: var(--newblue2);
    border: 2px solid var(--newblue2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    font-weight: 800;
    margin-right: 25px;
    z-index: 2; /* Sits on top of the line */
    transition: all 0.3s ease;
  }

  /* 5. ACTIVE STATE (When clicked/open) */
  
  /* Change circle to blue filled */
  .accordion-button:not(.collapsed) .step-number {
    background: var(--primary-blue);
    color: white;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 6px rgba(13, 110, 253, 0.2); /* Glowing ring effect */
    transform: scale(1.1);
  }

  /* Change text color */
  .accordion-button:not(.collapsed) {
    color: white;
    font-weight: 800;
  }

  /* 6. The Content Card (The expanded part) */
  .setup-accordion .accordion-collapse {
    /* Move it to the right of the line */
    margin-left: 75px; 
    background: rgba(85, 115, 150, 1);
    border-radius: 16px;
    box-shadow: 0 15px 40px rgba(13, 110, 253, 0.15); / Soft shadow */
    margin-top: 15px;
    border: 1px solid rgba(13, 110, 253, 0.1);
    position: relative;
  }
  /* Little arrow pointing to the number */
  .setup-accordion .accordion-collapse::before {
    content: '';
    position: absolute;
    top: -8px;
    left: 20px;
    width: 15px; 
    height: 15px;
    background: rgba(85, 115, 150, 1);
    transform: rotate(45deg);
    border-top: 1px solid rgba(13, 110, 253, 0.1);
    border-left: 1px solid rgba(13, 110, 253, 0.1);
  }

  .setup-accordion .accordion-body {
    padding: 25px;
    color: #555;
  }

  /* List Styling inside the card */
  .setup-accordion ul {
    list-style: none;
    padding-left: 0;
    margin-bottom: 0;
  }

  .setup-accordion li {
    margin-bottom: 8px;
    position: relative;
    padding-left: 25px;
    color: white;
  }

  /* Custom Checkmark Bullets */
  .setup-accordion li::before {
    content: '\f00c'; /* Font Awesome Check */
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    color: white;
    position: absolute;
    left: 0;
    top: 2px;
  }

  /* Diagram Image */
  .setup-diagram {
    border-radius: 20px;
    
    transition: transform 0.3s ease;
  }
  .setup-diagram:hover {
    transform: scale(1.02);
  }

/* =========================================
   MODERN PRODUCTION DATA STRIPS
========================================= */

/* General Strip Styling */
.production-strip {
  padding: 100px 0;
  position: relative;
  transition: all 0.4s ease;
  overflow: hidden;
}

/* 1. THE "TECH" STRIP (Light Blue Background) */
.light-blue-strip {
 background: linear-gradient(135deg, rgba(200, 225, 255, 5), rgba(150, 200, 255, 5));
  backdrop-filter: blur(12px);
  position: relative;
  border-top: none;
  padding-top: 20px;
}

/* NETWORK MESH PATTERN FOR LIGHT BLUE STRIP */
.light-blue-strip::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  pointer-events: none;

  /* SVG Contour Lines */
 
  background-size: cover;
  background-position: center;
}

/* 2. THE "CLEAN" STRIP (White Background) */
.white-strip {
  background: #264573;
  position: relative;
}



/* OPTION 2: TOPOGRAPHIC FLOW PATTERN */
.white-strip::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  pointer-events: none;

  /* CHANGED COLOR HERE: %2342B9FF */
  
  background-size: cover;
  background-position: center;
}
    
.light-blue-strip1 {
  background: #264573;  
  position: relative;
  border-top: none;
  padding-top: 20px;
}

/* =========================================
   ALTERNATING TEXT COLORS
========================================= */

/* 1. Control Page: BLACK TEXT */
.white-strip .production-data-item h3,
.white-strip .production-data-item p {
    color:  #ffffff !important;
}

/* 2. Count Dashboard: WHITE TEXT */
/* (Make sure this section has a dark background so text is visible) */
.light-blue-strip .production-data-item h3,
.light-blue-strip .production-data-item p {
    color: #212529 !important;
}

/* 3. Duration Dashboard: BLACK TEXT */
.light-blue-strip1 .production-data-item h3,
.light-blue-strip1 .production-data-item p {
    color: #ffffff !important;
}

/* 4. Overview: WHITE TEXT */
/* (Make sure this section has a dark background so text is visible) */
.white-strip1 .production-data-item h3,
.white-strip1 .production-data-item p {
    color: #212529 !important;
}


.light-blue-strip1::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  pointer-events: none;

  /* CHANGED COLOR HERE: %2342B9FF */
 
  background-size: cover;
  background-position: center;
}

.white-strip1 {
  background: linear-gradient(135deg, rgba(200, 225, 255, 5), rgba(150, 200, 255, 5));
  backdrop-filter: blur(12px);
  position: relative;
}

.white-strip1::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 0;
  pointer-events: none;

  /* SVG Contour Lines */
  
  background-size: cover;
  background-position: center;
}


/* ✅ FIX: Lifts the text/image container above the mesh pattern */
/* Lifts the text/image container above the mesh pattern */
.light-blue-strip .container,
.white-strip .container 
.white-strip1 .container
.light-blue-strip1 .container{
  position: relative;
  z-index: 2; 
}


/* HOVER EFFECT: Image lifts up and shadow glows more */
.production-strip:hover .dashboard-image {
  transform: translateY(-15px) scale(1);
}

.production-data-item p {
  color: white;
  font-size: 1.15rem;
  line-height: 1.8;
  font-weight: 400;
}
.production-data-item h3{
  color: white !important;
}

.text.dark{
  color: white;
}

/* Responsive Fixes */
@media (max-width: 992px) {
  .production-strip {
    padding: 40px 0;
  }
  .production-data-item h3 {
    font-size: 2rem;
  }
}

/* --- NEW Image Styling for all Dashboard Images --- */
.dashboard-image, 
.production-data-item img { 
    /* Ensures image is responsive and fits the column width (equivalent to img-fluid) */
    max-width: 100%; 
    height: auto;
    display: block;
    filter: brightness(1) saturate(2.0);
    }



/* =========================================
   MODERN "MAKE INFORMED DECISIONS" STYLES
========================================= */
.make-informed-section {
  background: 
    linear-gradient(135deg, rgba(15, 70, 123, 0.25) 50%, rgba(23, 162, 220, 0.20) 100%),
    url('<?= base_url('assets_system/images/decisionsbg.jpg') ?>') center/cover fixed no-repeat;
  padding: 120px 0;
  color: white;
  position: relative;
  overflow: hidden;
  border: solid rgba(15, 70, 123, 0.85) 1px;
}

/* Section Title */
.section-title {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 15px;
  text-align: center;
  color: white;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.title-underline {
  width: 100px;
  height: 4px;
  background: #42B9FF;
  border-radius: 2px;
  margin: 0 auto 60px;
  box-shadow: 0 0 10px rgba(66, 185, 255, 0.5);
}

/* Modern Horizontal Card */
.modern-feature-card {
  display: flex;
  align-items: flex-start;
  background: rgba(255, 255, 255, 0.05); /* Glass effect */
  border: 1px solid rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(10px);
  padding: 25px;
  margin-bottom: 25px;
  border-radius: 16px;
  transition: all 0.3s ease;
}

.modern-feature-card:hover {
  background: rgba(255, 255, 255, 0.15);
  transform: translateX(10px); /* Slide effect on hover */
  border-color: rgba(255, 255, 255, 0.3);
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

/* Icon Styling */
.feature-icon-box {
  flex-shrink: 0;
  width: 60px;
  height: 60px;
  background: linear-gradient(135deg, #17A2DC, #0d6efd);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  color: white;
  margin-right: 20px;
  box-shadow: 0 5px 15px rgba(23, 162, 220, 0.3);
}

/* Text Styling */
.feature-content h4 {
  font-size: 1.25rem;
  font-weight: 700;
  margin-bottom: 5px;
  color: white;
}

.feature-content p {
  color: rgba(255, 255, 255, 0.8);
  font-size: 0.95rem;
  line-height: 1.5;
  margin: 0;
}

/* Responsive: Stack on mobile */
@media (max-width: 992px) {
  .modern-feature-card:hover {
    transform: translateY(-5px); /* Move up instead of right on tablet */
  }
}

/* Hover every images */
.setup-diagram:hover{
	transform: scale(1.02);
}

.setup-diagram {
  border-radius: 20px;
  position: relative;
  z-index: 2;
  transition: var(--transition);
}

.img-fluid:hover{
	transform: scale(1.02);
}

.img-fluid {
  border-radius: 20px;
  position: relative;
  z-index: 2;
  transition: var(--transition);
  animation: float-slow 5s ease-in-out infinite;
}

.dashboard-image:hover{
	transform: scale(1.02);
}

.dashboard-image {
  border-radius: 20px;
  position: relative;
  z-index: 2;
  transition: var(--transition);
}


/* =========================================
   MODERN HEADER (Light Blue + Network Pattern)
========================================= */

.production-header-modern {
  position: relative;
  /* Soft Light Blue Gradient matching your image */
  background: linear-gradient(to bottom, #84c4f1a8, #689ae6ff);
  padding: 50px 0 50px;
  text-align: center;
  overflow: hidden;
  
  
}

/* NETWORK PATTERN - LEFT & RIGHT ONLY */
.production-header-modern::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  pointer-events: none;
  z-index: 0;
  
  /* 1. WE LIST THE IMAGE URL TWICE (Comma separated) */
 
  /* 2. POSITION ONE LEFT, ONE RIGHT */
  background-position: left center, right center;
  
  /* 3. SET NO REPEAT */
  background-repeat: no-repeat;
  
  /* 4. SIZE THEM (Adjust height to fit nicely on sides, e.g. 50% width) */
  background-size: 50% 100%; 
  
  opacity: 0.8; 
}
/* Typography - Dark Blue to contrast with light bg */
.production-header-modern h2 {
  font-size: 3.5rem;
  font-weight: 800;
  color: #0F467B; /* Deep Blue */
  margin-bottom: 15px;
  position: relative;
  display: inline-block;
}

.text-card {
        /* Existing semi-transparent dark background (from previous step) */
        background-color: rgba(44, 62, 80, 0.85); /* Tinaasan ko pa ang opacity */
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px); 
        border-radius: 15px; 
        border: 1px solid rgba(255, 255, 255, 0.1); 
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4); 
        color: #ffffff;
        
        /* KEY: Negative Margin to create the overlap effect */
        margin-right: -100px; /* Itutulak nito ang card papasok sa space ng image ng 100px */
        
        /* Optional: Para mas malaki pa, dagdagan ang width */
        width: calc(100% + 100px); /* Gawin ang width na 100% + 100px ng overlap */
        padding: 50px 70px;
       
    }

/* Also, ensure your headings and paragraphs inside text-card are white */
.text-card h3,
.text-card p {
    color: #ffffff !important; /* Use !important to override Bootstrap's text-dark */
}

.text-card1 {
        /* Existing semi-transparent dark background (from previous step) */
        background-color: rgba(141, 194, 247, 0.85); /* Tinaasan ko pa ang opacity */
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px); 
        border-radius: 15px; 
        border: 1px solid rgba(255, 255, 255, 0.1); 
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4); 
        color: #ffffff;
        
        /* KEY: Negative Margin to create the overlap effect */
        margin-right: -100px; /* Itutulak nito ang card papasok sa space ng image ng 100px */
        
        /* Optional: Para mas malaki pa, dagdagan ang width */
        width: calc(100% + 100px); /* Gawin ang width na 100% + 100px ng overlap */
        padding: 50px 70px; /* Dagdagan ang padding para lumaki pa */
    }

/* Also, ensure your headings and paragraphs inside text-card are white */
.text-card1 h3,
.text-card1 p {
    color: #ffffff !important; /* Use !important to override Bootstrap's text-dark */
}

/* Blue Underline under Title */
.production-header-modern h2::after {
  content: '';
  display: block;
  width: 80px;
  height: 4px;
  background: #42B9FF;
  margin: 10px auto 0;
  border-radius: 2px;
}

.production-header-modern p.lead {
  color: #555;
  font-size: 1.15rem;
  max-width: 700px;
  margin: 0 auto 40px;
  position: relative;
  z-index: 1;
}

/* 3. Modern White Pill Buttons */
.btn-modern-pill {
  background: white;
  color: #333; 
  border: 1px solid var(--primary-blue);
  padding: 12px 35px;
  border-radius: 50px; /* Pill Shape */
  font-weight: 600;
  font-size: 0.95rem;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  box-shadow: 0 4px 10px rgba(0,0,0,0.05);
  min-width: 160px;
}

/* Hover State: Border turns blue, text turns blue, lifts up */
.btn-modern-pill:hover {
  border-color: #42B9FF;
  color: white;
  background: #0F467B;
  transform: translateY(-3px);
  box-shadow: 0 8px 20px rgba(66, 185, 255, 0.2);
}

.header-btn-group {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 20px;
  position: relative;
  z-index: 2;
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
            <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown">
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
              <li><a class="dropdown-item active" href="<?= base_url('index/ps_iotsolution') ?>">IoT Solution</a></li>
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
  <div style="margin-top: 90px;"></div>

  <!-- ✅ Modern IoT Sections -->
  <main>
    <!-- 1. Modern GEMBA Overview with Background Image -->
<section class="iot-hero">
  <div class="container">
    <div class="row align-items-center">

      <!-- Left Content -->
      <div class="col-lg-7 fade-in iot-hero-content">
        <h2> Real-Time Machine
          Monitoring That Keeps
          You in Control </h2>

        <p>
          No subscription. No fixed cost. Just one setup that keeps
          you connected.
        </p>

        <!-- ✅ Request Demo Button -->
        <a href="#contact" class="btn btn-primary iot-demo-btn">
          Request Demo
        </a>
      </div>

      <!-- Right Image -->
      <div class="col-lg-5 text-center fade-in delay-1">
        <div class="img-hover">
          <img src="<?= base_url('assets_system/images/new-herogemba.png') ?>" 
              alt="GEMBA Overview" class="img-fluid">
        </div>
      </div>

    </div>
  </div>
</section>


<section class="our-solution">
  <div class="container solution-container">
    <div class="row align-items-center">

      <div class="col-lg-6 fade-in">
        
        <div class="solution-header">
          <h2 class="solution-title">Our <span>Solution</span></h2>
          <div class="solution-underline"></div>
        </div>

        <div class="problem-box">
          <p>
            Manual recording and delayed updates make it difficult
            to see what’s really happening on the shop floor.
          </p>
        </div>

        <div class="solution-box">
          <p>
            The GEMBA Reporter Machine Monitoring System helps
            eliminate blind spots by capturing machine data automatically —
            so you can identify downtime causes, improve efficiency,
            and make data-driven decisions faster.
          </p>
        </div>

      </div>

      <div class="col-lg-6 text-center fade-in delay-1">
        <div class="solution-img-wrapper">
          <img src="<?= base_url('assets_system/images/Machine1.png') ?>" 
               alt="GEMBA Overview" class="img-fluid solution-img-original">
        </div>
      </div>

    </div>
  </div>
</section>


<section class="our-products-showcase">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg-6 products-image-column text-center fade-in">
        <img src="<?= base_url('assets_system/images/Gemba-repo.png') ?>" 
             alt="Base Station and Smart Counter" class="img-fluid products-main-img">
        <div class="blue-background-effect"></div>
      </div>

      <div class="col-lg-6 products-description-column fade-in delay-1">
        <div class="product-item">
          <h3 class="product-item-title"> Base Station</h3>
          <p> Acts as the control hub, receiving and storing data from up to 10
 Smart Counters simultaneously. Loaded with Line Seiki’s in-house
 software, it organizes the data and performs real-time analysis.</p>
        </div>

        <div class="product-item mt-5">
          <h3 class="product-item-title">Smart Counter</h3>
          <p>Smart Counter- Mounted directly on your machine, it collects
 essential data such as production quantity, cycle time, and
 operating status. It wirelessly transmits all data to the Base Station
 — no need for complex wiring</p>
        </div>
      </div>

    </div>
  </div>
</section>


<section class="system-setup-section">
  <div class="container">
    
    <div class="row align-items-center">
      <div class="col-12 text-center fade-in mb-5">
        <h2 class="setup-title">System Set-Up</h2>
      </div>

      <div class="col-lg-5 col-md-12 fade-in delay-1">
        <div class="accordion setup-accordion" id="systemSetupAccordion">

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                <span class="step-number">1</span> Smart Counter
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
                <ul>
                  <li>Counts production</li>
                  <li>Detects machine up/down status</li>
                  <li>Sends data wirelessly</li>
                  <li>One Smart Counter per machine</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <span class="step-number">2</span> Base Station
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
                <ul>
                  <li>Connects with up to 10 machines</li>
                  <li>Receives data wirelessly</li>
                  <li>Sends data to Data Server via LAN</li>
                  <li>Acts as the “hub” for a group of machines</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <span class="step-number">3</span> Factory Network
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
                <ul>
                  <li>Router/switch connects everything</li>
                  <li>Data Server + Base Stations must use LAN cables</li>
                  <li>Access via PC or tablet on the same network</li>
                </ul>
              </div>
            </div>
          </div>
          
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                <span class="step-number">4</span> Data Server
              </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
                <ul>
                  <li>Saves all production data</li>
                  <li>Shows real-time dashboards</li>
                  <li>Runs the GEMBA Reporter software</li>
                  <li>Supports up to 12 Base Stations (120 machines)</li>
                </ul>
              </div>
            </div>
          </div>
          
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                <span class="step-number">5</span> User Device
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
                <ul>
                  <li>No software installation</li>
                  <li>Works on PC, laptop, or tablet</li>
                  <li>View machine status, downtime, records, and reports</li>
                  <li>Export data to Excel with one click</li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-lg-7 col-md-12 text-center fade-in delay-2">
        <div class="p-3">
            <img src="<?= base_url('assets_system/images/system-setupnobg.png') ?>" 
     alt="GEMBA System Setup Diagram" 
     class="img-fluid setup-diagram"
      style="filter: saturate(3.5);">
        </div>
      </div>

    </div>
  </div>
</section>

    <section id="production-data" class="production-data-section">
  
  <div class="production-header-modern">
    <div class="container">
      <div class="row">
        <div class="col-12">
          
          <h2 class="display-4">Production Data</h2>
          <p class="lead" style="color: black;">
            The GEMBA dashboard gives you a comprehensive view of your machine status.
          </p>
          
          <div class="header-btn-group">
            <a href="#" class="btn btn-modern-pill">Control Page</a>
            <a href="#" class="btn btn-modern-pill">Count Dashboard</a>
            <a href="#" class="btn btn-modern-pill">Duration Dashboard</a>
            <a href="#" class="btn btn-modern-pill">Overview</a>
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="production-strip white-strip">
    <div class="container">
      <div class="row align-items-center production-data-item fade-in">
        <div class="col-lg-6 order-lg-1">
          <div class="text-card p-4 p-md-5"> 
            <h3 class="h2 fw-bold text-dark mb-3">Control Page</h3>
            <p class="">
              Input and monitor essential machine job details in one place.
            </p>
          </div>
        </div>
        <div class="col-lg-6 order-lg-2 text-center mt-4 mt-lg-0">
          <img src="<?= base_url('assets_system/images/2xpage-nobg.png') ?>" alt="Control Page Dashboard" class="dashboard-image">
        </div>
      </div>
    </div>
  </div>

  <div class="production-strip light-blue-strip">
    <div class="container">
      <div class="row align-items-center production-data-item fade-in">
        <div class="col-lg-6 order-lg-2">
          <div class="text-card1 p-4 p-md-5"> 
            <h3 class="h2 fw-bold text-dark mb-3">Count Dashboard</h3>
            <p class="">
              Track actual output versus target quantity for every machine. Easily visualize progress percentages and ensure production goals are being met in real time.
            </p>
          </div>
        </div>
        <div class="col-lg-6 order-lg-1 text-center mt-4 mt-lg-0">
          <img src="<?= base_url('assets_system/images/countdash.png') ?>" alt="Count Dashboard" class="dashboard-image">
        </div>
      </div>
    </div>
  </div>

  <div class="production-strip light-blue-strip1">
    <div class="container">
      <div class="row align-items-center production-data-item fade-in">
        <div class="col-lg-6 order-lg-1">
          <div class="text-card p-4 p-md-5"> 
            <h3 class="h2 fw-bold text-dark mb-3">Duration Dashboard</h3>
            <p class="">
              This page shows the running time and downtime of multiple machines. You can easily see how long each machine has been working or idle.
            </p>
          </div>
        </div>
        <div class="col-lg-6 order-lg-2 text-center mt-4 mt-lg-0">
          <img src="<?= base_url('assets_system/images/duration.png') ?>" alt="Duration Dashboard" class="dashboard-image">
        </div>
      </div>
    </div>
  </div>

  <div class="production-strip white-strip1">
    <div class="container">
      <div class="row align-items-center production-data-item fade-in">
        <div class="col-lg-6 order-lg-2">
          <div class="text-card1 p-4 p-md-5"> 
            <h3 class="h2 fw-bold text-dark mb-3">Overview</h3>
            <p class="">
              Gives you a quick snapshot of all machines in one view — making it easy to check the overall production status at a glance.
            </p>
          </div>
        </div>
        <div class="col-lg-6 order-lg-1 text-center mt-4 mt-lg-0">
          <img src="<?= base_url('assets_system/images/overview.png') ?>" alt="Overview Dashboard" class="dashboard-image">
        </div>
      </div>
    </div>
  </div>
</section>
  <!-- Make Informed Decisions Section -->
<section class="make-informed-section">
  <div class="container">
    
    <div class="row justify-content-center">
      <div class="col-12 text-center fade-in">
        <h2 class="section-title">Make Informed Decisions</h2>
        <div class="title-underline"></div>
      </div>
    </div>
    
    <div class="row g-5">
      
      <div class="col-lg-6 fade-in delay-1">
        
        <div class="modern-feature-card">
          <div class="feature-icon-box">
            <i class="fas fa-eye"></i>
          </div>
          <div class="feature-content">
            <h4>Real-Time Visibility</h4>
            <p>Instantly know which machines are running or idle.</p>
          </div>
        </div>

        <div class="modern-feature-card">
          <div class="feature-icon-box">
            <i class="fas fa-wifi"></i>
          </div>
          <div class="feature-content">
            <h4>Wireless Installation</h4>
            <p>Quick setup, minimal disruption to existing machines.</p>
          </div>
        </div>

        <div class="modern-feature-card">
          <div class="feature-icon-box">
            <i class="fas fa-expand-arrows-alt"></i>
          </div>
          <div class="feature-content">
            <h4>Scalable</h4>
            <p>Easily expand your setup by connecting up to 10 Smart Counters per Base Station.</p>
          </div>
        </div>

      </div>

      <div class="col-lg-6 fade-in delay-2">
        
        <div class="modern-feature-card">
          <div class="feature-icon-box">
            <i class="fas fa-file-alt"></i>
          </div>
          <div class="feature-content">
            <h4>Automated Records</h4>
            <p>Eliminate paper logs and manual counting errors.</p>
          </div>
        </div>

        <div class="modern-feature-card">
          <div class="feature-icon-box">
            <i class="fas fa-dollar-sign"></i>
          </div>
          <div class="feature-content">
            <h4>Cost-Effective</h4>
            <p>One-time setup cost — no monthly fees or subscriptions.</p>
          </div>
        </div>

        <div class="modern-feature-card">
          <div class="feature-icon-box">
            <i class="fas fa-shield-alt"></i>
          </div>
          <div class="feature-content">
            <h4>Reliable</h4>
            <p>Line Seiki, a trusted name in precision measurement.</p>
          </div>
        </div>

      </div>

    </div>
  </div>
</section>

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