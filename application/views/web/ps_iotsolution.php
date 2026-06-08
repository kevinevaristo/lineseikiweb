<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>IoT Solution - Line Seiki Asia Pacific</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">

  <!-- Google Fonts -->
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">

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
    
    /* Active state for scroll buttons */
    .btn-modern-pill.active {
      background: #42B9FF;
      color: white;
      border-color: #42B9FF;
      box-shadow: 0 0 15px rgba(66, 185, 255, 0.5);
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
      
      /* UPDATED SVG PATTERN */
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
      box-shadow: 0 15px 40px rgba(13, 110, 253, 0.15);
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
      background: white
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
      background-size: cover;
      background-position: center;
    }

    /* 2. THE "CLEAN" STRIP (White Background) */
    .white-strip {
      background: linear-gradient(135deg, rgba(200, 225, 255, 5), rgba(150, 200, 255, 5));
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
      background-size: cover;
      background-position: center;
    }
        
    .light-blue-strip1 {
      background: linear-gradient(135deg, rgba(200, 225, 255, 5), rgba(150, 200, 255, 5));
      position: relative;
      border-top: none;
      padding-top: 20px;
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
      background-size: cover;
      background-position: center;
    }

    .white-strip1 {
      background: white
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
      background-size: cover;
      background-position: center;
    }

    /* ✅ FIX: Lifts the text/image container above the mesh pattern */
    .light-blue-strip .container,
    .white-strip .container,
    .white-strip1 .container,
    .light-blue-strip1 .container {
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
    
    .production-data-item h3 {
      color: white !important;
    }

    .text.dark {
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
      max-width: 110%; 
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
        url('<?= base_url('assets_system/images/' . ($section_background['image'] ?? 'decisionsbg.jpg')) ?>') center/cover fixed no-repeat;
    min-height: 400px; /* Add minimum height */
    position: relative;
    z-index: 1;center/cover fixed no-repeat;
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
    .setup-diagram:hover {
      transform: scale(1.02);
    }

    .setup-diagram {
      border-radius: 20px;
      position: relative;
      z-index: 2;
      transition: var(--transition);
    }

    .img-fluid:hover {
      transform: scale(1.02);
    }

    .img-fluid {
      border-radius: 20px;
      position: relative;
      z-index: 2;
      transition: var(--transition);
      animation: float-slow 5s ease-in-out infinite;
    }

    .dashboard-image:hover {
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
      background: rgba(162, 200, 243, 1); /* Tinaasan ko pa ang opacity */
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
      color: black !important; /* Use !important to override Bootstrap's text-dark */
    }

    .text-card1 {
      /* Existing semi-transparent dark background (from previous step) */
      background-color: rgba(255, 255, 255, 1);/* Tinaasan ko pa ang opacity */
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
      color: black !important; /* Use !important to override Bootstrap's text-dark */
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

    li.nav-item.dropdown > a.nav-link.dropdown-toggle[href="#"]::after {
      display: none !important;
    }

    /* === Mobile responsive enhancements (added) === */
    @media (max-width: 768px) {
      /* Scale down oversized headings */
      .iot-hero h2 { font-size: 2rem; }
      .iot-hero p { font-size: 1.05rem; }
      .iot-hero { padding: 90px 0 70px; min-height: auto; }
      .solution-title { font-size: 2rem; }
      .setup-title { font-size: 2rem; margin-bottom: 40px; }
      .section-title { font-size: 2rem; }
      .production-header-modern h2 { font-size: 2.2rem; }
      .product-item-title { font-size: 1.5rem; }
      .make-informed-section { padding: 70px 0; }
      .our-solution { padding: 70px 0; }
      .production-strip { padding: 50px 0; }
      /* Remove negative-margin overlap that overflows when columns stack */
      .text-card,
      .text-card1 {
        margin-right: 0;
        width: 100%;
        padding: 30px 25px;
      }
      /* Keep oversized images contained */
      .iot-hero .img-hover img,
      .dashboard-image,
      .production-data-item img,
      .products-main-img {
        max-width: 100%;
        height: auto;
      }
    }

    @media (max-width: 480px) {
      .iot-hero h2 { font-size: 1.6rem; }
      .solution-title { font-size: 1.7rem; }
      .setup-title { font-size: 1.7rem; }
      .section-title { font-size: 1.7rem; }
      .production-header-modern h2 { font-size: 1.8rem; }
      .text-card,
      .text-card1 { padding: 22px 18px; }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
<?php $this->load->view('web/header'); ?>

  <!-- Offset for fixed navbar -->
  <!--<div style="margin-top: 90px;"></div>-->

  <!-- ✅ Modern IoT Sections -->
  <main>
    <!-- 1. Modern GEMBA Overview with Background Image -->
    <section class="iot-hero">
      <div class="container">
        <div class="row align-items-center">
          <!-- Left Content -->
          <div class="col-lg-7 fade-in iot-hero-content">
            <?php if (!empty($hero['title'])): ?>
              <h2><?php echo $hero['title']; ?></h2>
              <p><?php echo isset($hero['description']) ? $hero['description'] : ''; ?></p>
            <?php else: ?>
              <h2>Real-Time Machine Monitoring That Keeps You in Control</h2>
              <p>No subscription. No fixed cost. Just one setup that keeps you connected.</p>
            <?php endif; ?>
            
            <!-- ✅ Request Demo Button -->
            <a href="#contact" class="btn btn-primary iot-demo-btn">
              Request Demo
            </a>
          </div>
          
          <!-- Right Image -->
          <div class="col-lg-5 text-center fade-in delay-1">
            <div class="img-hover">
              <?php if (!empty($hero['image'])): ?>
                <img src="<?= base_url('assets_system/images/' . $hero['image']) ?>" 
                     alt="GEMBA Overview" class="img-fluid">
              <?php else: ?>
                <img src="<?= base_url('assets_system/images/new-herogemba.png') ?>" 
                     alt="GEMBA Overview" class="img-fluid">
              <?php endif; ?>
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
            
            <?php if (!empty($solution)): ?>
              <?php if (isset($solution['problem'])): ?>
                <div class="problem-box">
                  <p><?php echo $solution['problem']; ?></p>
                </div>
              <?php endif; ?>
              <?php if (isset($solution['content'])): ?>
                <div class="solution-box">
                  <p><?php echo $solution['content']; ?></p>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <div class="problem-box">
                <p>Manual recording and delayed updates make it difficult to see what's really happening on the shop floor.</p>
              </div>
              <div class="solution-box">
                <p>The GEMBA Reporter Machine Monitoring System helps eliminate blind spots by capturing machine data automatically — so you can identify downtime causes, improve efficiency, and make data-driven decisions faster.</p>
              </div>
            <?php endif; ?>
          </div>
          
          <div class="col-lg-6 text-center fade-in delay-1">
            <div class="solution-img-wrapper">
              <?php if (!empty($solution['image'])): ?>
                <img src="<?= base_url('assets_system/images/' . $solution['image']) ?>" 
                     alt="GEMBA Overview" class="img-fluid solution-img-original">
              <?php else: ?>
                <img src="<?= base_url('assets_system/images/Machine1.png') ?>" 
                     alt="GEMBA Overview" class="img-fluid solution-img-original">
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="our-products-showcase">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6 products-image-column text-center fade-in">
            <?php if (!empty($products_main_image)): ?>
              <img src="<?= base_url('assets_system/images/' . $products_main_image['image']) ?>" 
                   alt="<?php echo $products_main_image['content']; ?>" class="img-fluid products-main-img">
            <?php else: ?>
              <img src="<?= base_url('assets_system/images/Gemba-repo.png') ?>" 
                   alt="Base Station and Smart Counter" class="img-fluid products-main-img">
            <?php endif; ?>
            <div class="blue-background-effect"></div>
          </div>
          
          <div class="col-lg-6 products-description-column fade-in delay-1">
            <?php if (!empty($products)): ?>
              <!-- Base Station -->
              <div class="product-item">
                <h3 class="product-item-title"><?php echo isset($products['base_station']['title']) ? $products['base_station']['title'] : 'Base Station'; ?></h3>
                <p>
                  <?php 
                    // Use hardcoded content since database has title in content field
                    echo isset($products['base_station']['content']) ? $products['base_station']['content'] : 
                    'Acts as the control hub, receiving and storing data from up to 10 Smart Counters simultaneously. Loaded with Line Seiki\'s in-house software, it organizes the data and performs real-time analysis.';
                  ?>
                </p>
              </div>
              
              <!-- Smart Counter -->
              <div class="product-item mt-5">
                <h3 class="product-item-title"><?php echo isset($products['smart_counter']['title']) ? $products['smart_counter']['title'] : 'Smart Counter'; ?></h3>
                <p>
                  <?php 
                    // Use hardcoded content since database has title in content field
                    echo isset($products['smart_counter']['content']) ? $products['smart_counter']['content'] : 
                    'Mounted directly on your machine, it collects essential data such as production quantity, cycle time, and operating status. It wirelessly transmits all data to the Base Station — no need for complex wiring';
                  ?>
                </p>
              </div>
            <?php else: ?>
              <!-- Fallback -->
              <div class="product-item">
                <h3 class="product-item-title">Base Station</h3>
                <p>Acts as the control hub, receiving and storing data from up to 10 Smart Counters simultaneously. Loaded with Line Seiki's in-house software, it organizes the data and performs real-time analysis.</p>
              </div>
              <div class="product-item mt-5">
                <h3 class="product-item-title">Smart Counter</h3>
                <p>Mounted directly on your machine, it collects essential data such as production quantity, cycle time, and operating status. It wirelessly transmits all data to the Base Station — no need for complex wiring</p>
              </div>
            <?php endif; ?>
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
          
          <!-- DEBUG: Add this to see what data is available -->
          <div class="col-12" style="display: none;"> <!-- Change to style="display: block;" to see debug info -->
            <h3>Debug System Setup Data:</h3>
            <pre><?php print_r($system_setup); ?></pre>
          </div>
          
          <div class="col-lg-5 col-md-12 fade-in delay-1">
            <div class="accordion setup-accordion" id="systemSetupAccordion">
              <?php if (!empty($system_setup)): ?>
                <?php 
                  $setup_order = array('Smart Counter', 'Base Station', 'Factory Network', 'Data Server', 'User Device');
                  $index = 0;
                ?>
                <?php foreach ($setup_order as $item): ?>
                  <?php if (isset($system_setup[$item])): ?>
                    <?php 
                      $step_number = $index + 1;
                      $is_first = $index === 0;
                      $collapsed_class = $is_first ? '' : 'collapsed';
                      $show_class = $is_first ? 'show' : '';
                    ?>
                    <div class="accordion-item">
                      <h2 class="accordion-header">
                        <button class="accordion-button <?php echo $collapsed_class; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo $step_number; ?>" aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>" aria-controls="collapse<?php echo $step_number; ?>">
                          <span class="step-number"><?php echo $step_number; ?></span> <?php echo $item; ?>
                        </button>
                      </h2>
                      <div id="collapse<?php echo $step_number; ?>" class="accordion-collapse collapse <?php echo $show_class; ?>" data-bs-parent="#systemSetupAccordion">
                        <div class="accordion-body">
                          <!-- DEBUG: Show what items are available -->
                          <?php if (empty($system_setup[$item]['items'])): ?>
                            <p style="color: red;">No items found for <?php echo $item; ?></p>
                            <p>Available keys in system_setup: <?php echo implode(', ', array_keys($system_setup)); ?></p>
                          <?php endif; ?>
                          
                          <?php if (!empty($system_setup[$item]['items'])): ?>
                            <ul>
                              <?php foreach ($system_setup[$item]['items'] as $list_item): ?>
                                <li><?php echo $list_item; ?></li>
                              <?php endforeach; ?>
                            </ul>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                    <?php $index++; ?>
                  <?php else: ?>
                    <!-- Show if item not found -->
                    <div style="color: orange; padding: 10px;">
                      Item not found in database: <?php echo $item; ?>
                    </div>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php else: ?>
                <!-- Fallback hardcoded accordion -->
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
                <!-- ... other accordion items ... -->
              <?php endif; ?>
            </div>
          </div>
          
          <div class="col-lg-7 col-md-12 text-center fade-in delay-2">
            <div class="p-3">
              <?php
                $diagram_image = !empty($setup_diagram['image']) ? $setup_diagram['image'] : 'system-setupnobg.png';
                // Fall back to the default diagram if the referenced file is missing on disk
                // (the CMS records a filename without always saving the file, leaving broken links)
                if (!file_exists(FCPATH . 'assets_system/images/' . $diagram_image)) {
                  $diagram_image = 'system-setupnobg.png';
                }
              ?>
              <img src="<?= base_url('assets_system/images/' . $diagram_image) ?>"
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
              <h2 class="display-4"><?php echo isset($production_data['title']) ? $production_data['title'] : 'Production Data'; ?></h2>
              <p class="lead" style="color: black;">
                <?php echo isset($production_data['description']) ? $production_data['description'] : 'The GEMBA dashboard gives you a comprehensive view of your machine status.'; ?>
              </p>
              
              <div class="header-btn-group">
                <?php if (!empty($production_data_ordered)): ?>
                  <?php foreach ($production_data_ordered as $key => $data): ?>
                    <?php 
                      $anchor_id = strtolower(str_replace(' ', '-', $key));
                    ?>
                    <a href="#<?php echo $anchor_id; ?>" class="btn btn-modern-pill scroll-to-section">
                      <?php echo $key; ?>
                    </a>
                  <?php endforeach; ?>
                <?php else: ?>
                  <a href="#control-page" class="btn btn-modern-pill scroll-to-section">Control Page</a>
                  <a href="#count-dashboard" class="btn btn-modern-pill scroll-to-section">Count Dashboard</a>
                  <a href="#duration-dashboard" class="btn btn-modern-pill scroll-to-section">Duration Dashboard</a>
                  <a href="#overview" class="btn btn-modern-pill scroll-to-section">Overview</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <?php if (!empty($production_data_ordered)): ?>
        <?php 
          $index = 0;
          $ordered_items = array('Control Page', 'Count Dashboard', 'Duration Dashboard', 'Overview');
        ?>
        <?php foreach ($ordered_items as $key): ?>
          <?php if (isset($production_data_ordered[$key])): ?>
            <?php 
              $data = $production_data_ordered[$key];
              $strip_class = $index % 2 == 0 ? 'white-strip' : 'light-blue-strip';
              $order_class = $index % 2 == 0 ? 'order-lg-1' : 'order-lg-2';
              $text_card_class = $index % 2 == 0 ? 'text-card1' : 'text-card';
              $image_order = $index % 2 == 0 ? 'order-lg-2' : 'order-lg-1';
              $anchor_id = strtolower(str_replace(' ', '-', $key));
            ?>
            <div id="<?php echo $anchor_id; ?>" class="production-strip <?php echo $strip_class; ?>">
              <div class="container">
                <div class="row align-items-center production-data-item fade-in">
                  <div class="col-lg-6 <?php echo $order_class; ?>">
                    <div class="<?php echo $text_card_class; ?> p-4 p-md-5"> 
                      <h3 class="h2 fw-bold text-dark mb-3"><?php echo $key; ?></h3>
                      <p class=""><?php echo isset($data['content']) ? $data['content'] : ''; ?></p>
                    </div>
                  </div>
                  <div class="col-lg-6 <?php echo $image_order; ?> text-center mt-4 mt-lg-0">
                    <?php if (!empty($data['image'])): ?>
                      <img src="<?= base_url('assets_system/images/' . $data['image']) ?>" 
                           alt="<?php echo $key; ?> Dashboard" 
                           class="dashboard-image"
                           style="<?php echo $key == 'Overview' ? 'margin-left: -20px;' : ''; ?>">
                    <?php else: ?>
                      <!-- Fallback images based on title -->
                      <?php 
                        $fallback_image = '2xpage-nobg.png';
                        if (strpos($key, 'Count') !== false) $fallback_image = 'countdash.png';
                        if (strpos($key, 'Duration') !== false) $fallback_image = 'duration.png';
                        if (strpos($key, 'Overview') !== false) $fallback_image = 'overview.png';
                      ?>
                      <img src="<?= base_url('assets_system/images/' . $fallback_image) ?>" 
                           alt="<?php echo $key; ?> Dashboard" 
                           class="dashboard-image"
                           style="<?php echo $key == 'Overview' ? 'margin-left: -20px;' : ''; ?>">
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
            <?php $index++; ?>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php else: ?>
        <!-- Fallback hardcoded production data sections -->
        <div id="control-page" class="production-strip white-strip">
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
        
        <div id="count-dashboard" class="production-strip light-blue-strip">
          <div class="container">
            <div class="row align-items-center production-data-item fade-in">
              <div class="col-lg-6 order-lg-2">
                <div class="text-card1 p-4 p-md-5"> 
                  <h3 class="h2 fw-bold text-dark mb-3">Count Dashboard</h3>
                  <p class="">
                    Monitor real-time production counts and track daily output goals.
                  </p>
                </div>
              </div>
              <div class="col-lg-6 order-lg-1 text-center mt-4 mt-lg-0">
                <img src="<?= base_url('assets_system/images/countdash.png') ?>" alt="Count Dashboard" class="dashboard-image">
              </div>
            </div>
          </div>
        </div>
        
        <div id="duration-dashboard" class="production-strip white-strip">
          <div class="container">
            <div class="row align-items-center production-data-item fade-in">
              <div class="col-lg-6 order-lg-1">
                <div class="text-card p-4 p-md-5"> 
                  <h3 class="h2 fw-bold text-dark mb-3">Duration Dashboard</h3>
                  <p class="">
                    Analyze machine utilization and downtime patterns over time.
                  </p>
                </div>
              </div>
              <div class="col-lg-6 order-lg-2 text-center mt-4 mt-lg-0">
                <img src="<?= base_url('assets_system/images/duration.png') ?>" alt="Duration Dashboard" class="dashboard-image">
              </div>
            </div>
          </div>
        </div>
        
        <div id="overview" class="production-strip light-blue-strip">
          <div class="container">
            <div class="row align-items-center production-data-item fade-in">
              <div class="col-lg-6 order-lg-2">
                <div class="text-card1 p-4 p-md-5"> 
                  <h3 class="h2 fw-bold text-dark mb-3">Overview</h3>
                  <p class="">
                    Get a high-level summary of overall production performance.
                  </p>
                </div>
              </div>
              <div class="col-lg-6 order-lg-1 text-center mt-4 mt-lg-0">
                <img src="<?= base_url('assets_system/images/overview.png') ?>" alt="Overview Dashboard" class="dashboard-image" style="margin-left: -20px;">
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </section>

    <!-- Make Informed Decisions Section -->
<section class="make-informed-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 text-center fade-in">
        <h2 class="section-title"><?php echo isset($features['title']) ? $features['title'] : 'Make Informed Decisions'; ?></h2>
        <div class="title-underline"></div>
      </div>
    </div>
    
    <div class="row g-5">
      <div class="col-lg-6 fade-in delay-1">
        <?php if (!empty($features_ordered)): ?>
          <?php 
            $features_count = count($features_ordered);
            $half = ceil($features_count / 2);
            $first_half = array_slice($features_ordered, 0, $half);
          ?>
          <?php foreach ($first_half as $feature): ?>
            <div class="modern-feature-card">
              <div class="feature-icon-box">
                <?php 
                  // Get the icon from the features array using the feature title as key
                  $icon = '';
                  if (isset($features[$feature['title']]['icon'])) {
                    $icon = $features[$feature['title']]['icon'];
                  } elseif (isset($features[$feature['title']]['image'])) {
                    $icon = $features[$feature['title']]['image'];
                  }
                ?>
                <?php if (!empty($icon)): ?>
                  <img src="<?= base_url('assets_system/images/' . $icon) ?>" 
                       alt="<?php echo $feature['title']; ?> icon" 
                       style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
                <?php else: ?>
                  <!-- Fallback icons based on feature title -->
                  <?php 
                    $fallback_icons = [
                      'Real-Time Visibility' => 'eye.png',
                      'Wireless Installation' => 'wifi.png',
                      'Scalable' => 'move.png',
                      'Automated Records' => 'google-docs.png',
                      'Cost-Effective' => 'dollar-symbol.png',
                      'Reliable' => 'shield.png'
                    ];
                    $fallback_icon = isset($fallback_icons[$feature['title']]) ? $fallback_icons[$feature['title']] : 'eye.png';
                  ?>
                  <img src="<?= base_url('assets_system/images/' . $fallback_icon) ?>" 
                       alt="<?php echo $feature['title']; ?> icon" 
                       style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
                <?php endif; ?>
              </div>
              <div class="feature-content">
                <h4><?php echo $feature['title']; ?></h4>
                <p><?php echo isset($feature['content']) ? $feature['content'] : ''; ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Fallback hardcoded features with images -->
          <div class="modern-feature-card">
            <div class="feature-icon-box">
              <img src="<?= base_url('assets_system/images/eye.png') ?>" 
                   alt="Real-Time Visibility icon" 
                   style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
            </div>
            <div class="feature-content">
              <h4>Real-Time Visibility</h4>
              <p>Instantly know which machines are running or idle.</p>
            </div>
          </div>
          
          <div class="modern-feature-card">
            <div class="feature-icon-box">
              <img src="<?= base_url('assets_system/images/wifi.png') ?>" 
                   alt="Wireless Installation icon" 
                   style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
            </div>
            <div class="feature-content">
              <h4>Wireless Installation</h4>
              <p>No complex wiring - simple and quick setup.</p>
            </div>
          </div>
          
          <div class="modern-feature-card">
            <div class="feature-icon-box">
              <img src="<?= base_url('assets_system/images/move.png') ?>" 
                   alt="Scalable icon" 
                   style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
            </div>
            <div class="feature-content">
              <h4>Scalable</h4>
              <p>Easily expand from 1 to 100+ machines.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
      
      <div class="col-lg-6 fade-in delay-2">
        <?php if (!empty($features_ordered)): ?>
          <?php 
            $second_half = array_slice($features_ordered, $half);
          ?>
          <?php foreach ($second_half as $feature): ?>
            <div class="modern-feature-card">
              <div class="feature-icon-box">
                <?php 
                  // Get the icon from the features array using the feature title as key
                  $icon = '';
                  if (isset($features[$feature['title']]['icon'])) {
                    $icon = $features[$feature['title']]['icon'];
                  } elseif (isset($features[$feature['title']]['image'])) {
                    $icon = $features[$feature['title']]['image'];
                  }
                ?>
                <?php if (!empty($icon)): ?>
                  <img src="<?= base_url('assets_system/images/' . $icon) ?>" 
                       alt="<?php echo $feature['title']; ?> icon" 
                       style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
                <?php else: ?>
                  <!-- Fallback icons based on feature title -->
                  <?php 
                    $fallback_icons = [
                      'Real-Time Visibility' => 'eye.png',
                      'Wireless Installation' => 'wifi.png',
                      'Scalable' => 'move.png',
                      'Automated Records' => 'google-docs.png',
                      'Cost-Effective' => 'dollar-symbol.png',
                      'Reliable' => 'shield.png'
                    ];
                    $fallback_icon = isset($fallback_icons[$feature['title']]) ? $fallback_icons[$feature['title']] : 'google-docs.png';
                  ?>
                  <img src="<?= base_url('assets_system/images/' . $fallback_icon) ?>" 
                       alt="<?php echo $feature['title']; ?> icon" 
                       style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
                <?php endif; ?>
              </div>
              <div class="feature-content">
                <h4><?php echo $feature['title']; ?></h4>
                <p><?php echo isset($feature['content']) ? $feature['content'] : ''; ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <!-- Fallback hardcoded features with images -->
          <div class="modern-feature-card">
            <div class="feature-icon-box">
              <img src="<?= base_url('assets_system/images/google-docs.png') ?>" 
                   alt="Automated Records icon" 
                   style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
            </div>
            <div class="feature-content">
              <h4>Automated Records</h4>
              <p>Eliminate paper logs and manual counting errors.</p>
            </div>
          </div>
          
          <div class="modern-feature-card">
            <div class="feature-icon-box">
              <img src="<?= base_url('assets_system/images/dollar-symbol.png') ?>" 
                   alt="Cost-Effective icon" 
                   style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
            </div>
            <div class="feature-content">
              <h4>Cost-Effective</h4>
              <p>No subscription fees - one-time setup cost.</p>
            </div>
          </div>
          
          <div class="modern-feature-card">
            <div class="feature-icon-box">
              <img src="<?= base_url('assets_system/images/shield.png') ?>" 
                   alt="Reliable icon" 
                   style="width: 30px; height: 30px; filter: brightness(0) invert(1);">
            </div>
            <div class="feature-content">
              <h4>Reliable</h4>
              <p>Robust hardware designed for factory environments.</p>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>
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
  </main>

  
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

      // Smooth scroll to section when clicking buttons
      document.querySelectorAll('.scroll-to-section').forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          
          const targetId = this.getAttribute('href');
          const targetSection = document.querySelector(targetId);
          
          if (targetSection) {
            // Calculate offset for fixed navbar
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const targetPosition = targetSection.offsetTop - navbarHeight - 20;
            
            // Smooth scroll
            window.scrollTo({
              top: targetPosition,
              behavior: 'smooth'
            });
            
            // Optional: Add active class to highlight current section
            document.querySelectorAll('.scroll-to-section').forEach(btn => {
              btn.classList.remove('active');
            });
            this.classList.add('active');
          }
        });
      });

      // Optional: Update button states on scroll
      function updateActiveButtonOnScroll() {
        const sections = document.querySelectorAll('.production-strip');
        const scrollPosition = window.scrollY + document.querySelector('.navbar').offsetHeight + 100;
        
        sections.forEach(section => {
          const sectionTop = section.offsetTop;
          const sectionHeight = section.offsetHeight;
          const sectionId = section.getAttribute('id');
          
          if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            document.querySelectorAll('.scroll-to-section').forEach(btn => {
              btn.classList.remove('active');
              if (btn.getAttribute('href') === `#${sectionId}`) {
                // btn.classList.add('active');
              }
            });
          }
        });
      }

      // Listen to scroll events
      window.addEventListener('scroll', updateActiveButtonOnScroll);

      // Initial check on page load
      updateActiveButtonOnScroll();
    });
  </script>
</body>
</html>