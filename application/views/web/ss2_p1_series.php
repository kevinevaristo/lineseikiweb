<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Products - Line Seiki Asia Pacific</title>

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
      --text-blue: #1a365d;
      --text-gray: #4a5568;
      --bg-light: #f7fafc;
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
    }
    
    section h1 {
      font-size: 2.8rem;
      color: var(--primary-blue);
    }
    
    section h2 {
      font-size: 2.2rem;
      color: var(--primary-blue);
    }
    
    section p {
      margin-bottom: 28px;
      font-size: 1.1rem;
      color: #495057;
    }

    /* CTA Section */
    .cta {
      background: var(--light-blue);
      color: white;
      text-align: center;
      padding: 80px 10%;
    }
    
    .cta h1 {
      font-size: 2.2rem;
      margin-bottom: 20px;
      color: var(--primary-blue);
    }
    
    .cta p {
      margin-bottom: 30px;
      font-size: 1.1rem;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
      color: black
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
      .products {
        padding: 100px 5% 60px;
      }
      
      .products h1 {
        font-size: 2.2rem;
      }
      
      .categories {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
      }
      
      footer .links a {
        display: inline-block;
        margin-bottom: 12px;
      }
    }
    
    @media (max-width: 768px) {
      .products h1 {
        font-size: 2rem;
      }
      
      .categories {
        grid-template-columns: 1fr;
        max-width: 400px;
        margin: 0 auto;
      }
      
      footer .links a {
        display: block;
        margin-bottom: 12px;
      }
    }

    /* Make INQUIRE button match Contact button */
    .cta .btn-light {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue)) !important;
      color: white !important;
      border: none !important;
    }

    .cta .btn-light:hover {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2)) !important;
      transform: translateY(-3px);
    }

/* MAIN LAYOUT */
.product-container {
  width: 100%;
  padding: 50px;
  background: #ffffff;
  display: flex;
  justify-content: center;
}

.product-wrapper {
  max-width: 1200px;
  width: 100%;
  display: flex;
  gap: 50px;
}

/* LEFT IMAGE */
.product-image-section {
  width: 50%;
}

.big-image-card {
  width: 100%;
  height: 450px;
  border: 3px solid #dfe6f2;
  border-radius: 4px;
  display: flex;
  justify-content: center;
  align-items: center;
  background: #fafcff;
}

.big-image-card img {
  width: 85%;
  height: 85%;
  object-fit: contain;
}

/* RIGHT INFO AREA */
.product-info-section {
  width: 50%;
}

.product-category {
  text-transform: uppercase;
  font-size: 15px;
  font-weight: 600;
  color: #3d4c63;
  margin-bottom: 5px;
}

.product-title {
  font-size: 48px;
  font-weight: 800;
  color: #0d2a5c;
  margin-bottom: 15px;
}

/* Tags */
.product-tags span {
  display: inline-block;
  background: #f0f4f8;
  color: #0b264e;
  padding: 5px 12px;
  border-radius: 15px;
  font-size: 13px;
  margin-right: 10px;
  margin-bottom: 15px;
}

/* FEATURE BOX */
.product-feature-box {
  display: grid;
  grid-template-columns: 120px 1fr;
  border-top: 3px solid #1900ffff;
  border-bottom: 3px solid #1900ffff;
  padding: 20px 0;
  margin-bottom: 35px;
}

.feature-label {
  background: #eef2f9;
  padding: 15px;
  font-weight: 700;
  color: #0b264e;
  display: flex;
  align-items: center; /* vertical center */
  justify-content: center; /* horizontal center */
  height: 100%;
  margin-right: 10px;
}

.feature-content p {
  margin: 0 0 10px 0;
  color: #24344f;
  line-height: 1.6;
}

/* BUTTONS */
.product-buttons {
  display: flex;
  gap: 20px;
}

.btn1 {
  padding: 14px 25px;
  text-decoration: none;
  font-size: 15px;
  font-weight: 600;
  border-radius: 3px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.btn1.navy {
  background: #0d2a5c;
  color: white;
  border: 1px solid #0d2a5c;
}

.btn1.navy:hover {
  background: #061b3a;
}

/* ICONS */
.icon-mail::before {
  content: "✉️";
}

.icon-list::before {
  content: "📄";
}

/* Container to organize the rows and center the content */
.dropdown-container {
    padding: 30px; /* Dagdagan ang space */
    font-family: Arial, sans-serif;
    display: flex; /* Gawing flex container */
    flex-direction: column; /* Ayusin ang rows pababa */
    align-items: center; /* I-center ang rows horizontally */
    width: 100%; /* Gamitin ang buong lapad para sa centering */
    box-sizing: border-box;
}

/* Style for the row containing multiple dropdowns */
.dropdown-row {
    display: flex; 
    gap: 20px; /* Dagdagan ang space between buttons */
    margin-bottom: 20px; /* Dagdagan ang space between the two rows */
}

/* Base style for all dropdown buttons */
.dropdown-button {
    /* Dimensions and Appearance - Pinalaki */
    height: 50px; /* Ginamit ang 50px na taas */
    padding: 0 100px; /* Dagdagan ang horizontal padding */
    border-radius: 15px; /* Dinagdagan din ang rounding */
    font-size: 16px; /* Gawing mas malaki ang font */
    
    /* Text and Layout (same as before) */
    display: flex;
    align-items: center; 
    justify-content: space-between; 
    white-space: nowrap;
    cursor: pointer;
    
    /* Colors - Standard Dropdown */
    background-color: white;
    border: 2px solid #0616f5ff;
    color: #404040;
    transition: all 0.2s ease-in-out;
}

/* Style for the currently active/selected button (same as before) */
.dropdown-button.active {
    background-color: #eef1f6;
    border-color: #eef1f6;
    color: #2c2c3e;
}

/* Style for the down arrow icon (same as before) */
.dropdown-arrow {
    font-size: 12px; /* Bahagyang pinalaki */
    margin-left: 12px;
    line-height: 1;
}

/* Hover effect */
.dropdown-button:hover {
    border: 1px solid #000000ff; /* Darker blue/purple border */
    transform: translateY(-1px); /* Bahagyang umakyat para sa 3D effect */
    box-shadow: 0 3px 5px rgba(0, 0, 0, 0.1);
}

.title-header {
    margin-top: 70px;
    margin-bottom: 20px;
    padding: 15px 20px;
    background: #e6f1ff; /* light blue background */
    border-left: 4px solid #007bff; /* accent blue bar */
    border-radius: 0;
    width: 100%;
    box-sizing: border-box;
    position: relative;
    overflow: hidden; /* for sliding effect */
    transition: background 0.3s ease;
}

.title-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
    color: #000000ff;
    letter-spacing: 1px;
     /* always underlined */
    position: relative;
    z-index: 2;
}

/* New hover effect */
.title-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%; /* start outside */
    width: 100%;
    height: 100%;
    background: #007bff33; /* semi-transparent blue overlay */
    z-index: 1;
    transition: left 0.4s ease;
}

.title-header:hover::before {
    left: 0; /* slide in from left */
}

.title-header:hover {
    background: #d0e7ff; /* slightly darker blue */
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); /* subtle lift */
}

.video-container {
    margin: 20px auto; /* Para i-center ang video */
    max-width: 560px; /* Para hindi lumaki ang container base sa width ng iframe */
}

#movie-section {
    scroll-margin-top: 80px; 
    /* Maaari mo ring idagdag ang scroll-padding-top sa <body> o <html> kung gusto mo, 
       pero mas specific ang scroll-margin-top sa target element. */
}

#models-section {
    scroll-margin-top: 80px; 
    /* Maaari mo ring idagdag ang scroll-padding-top sa <body> o <html> kung gusto mo, 
       pero mas specific ang scroll-margin-top sa target element. */
}

#spec-section {
    scroll-margin-top: 80px; 
    /* Maaari mo ring idagdag ang scroll-padding-top sa <body> o <html> kung gusto mo, 
       pero mas specific ang scroll-margin-top sa target element. */
}

#download-section {
    scroll-margin-top: 80px; 
    /* Maaari mo ring idagdag ang scroll-padding-top sa <body> o <html> kung gusto mo, 
       pero mas specific ang scroll-margin-top sa target element. */
}

#application-section {
    scroll-margin-top: 80px; 
    /* Maaari mo ring idagdag ang scroll-padding-top sa <body> o <html> kung gusto mo, 
       pero mas specific ang scroll-margin-top sa target element. */
}

/* 1. Container Styling (Wrapper) */
.modern-table-container {
    max-width: 1950px; 
    margin: 50px auto; /* Para i-center at bigyan ng space */
    padding: 0;
    
    /* Modern Look: Soft Shadow at Rounded Corners */
    background: #fff;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); 
    overflow: hidden; /* Mahalaga para maganda ang corners sa header */
}

/* 2. Base Table Styling */
#modern-product-table {
    border-collapse: collapse;
    width: 100%;
    font-family: 'Segoe UI', Roboto, Arial, sans-serif; /* Modern Font Stack */
    color: #333;
    /* Alisin ang lahat ng border sa buong table */
    border: none; 
}

/* 3. Header Styling (Dark, Flat) */
#modern-product-table thead th {
    background-color: #4669ad3b;
    color: white;
    padding: 30px 20px; 
    text-align: left;
    font-size: 15px;
    font-weight: 600; /* Semi-bold */
    border-right: 1px solid #1000f1ff;
    border-left: 1px solid #1000f1ff;
    border-top: 1px solid #1000f1ff;
    border-bottom: 1px solid #1000f1ff;
    color: black;
    text-align: center;
}

/* 4. Body Cells Styling (Clean Look) */
#modern-product-table tbody td {
    padding-top: 35px;
    padding-bottom: 35px;
    padding-right: 70px;
    padding-left: 50px;
    border-right: 1px solid #1000f1ff;
    border-left: 1px solid #1000f1ff;
    border-top: 1px solid #1000f1ff;
    border-bottom: 1px solid #1000f1ff;
    border-left: none;
    font-size: 14px;
    vertical-align: middle; 
}

/* 5. Centering Content for Rowspan Cells (Relay & Polyamide) */
#modern-product-table td[rowspan="3"] {
    text-align: center;
    background-color: #f8f9fa; /* Very subtle light gray background for emphasis */
    font-weight: 500;
}



/* 7. Special Alignment para sa Models Column (Kung gusto mong i-align sa gitna ang Models) */
#modern-product-table tbody tr td:first-child {
    text-align: center;
    background-color: #fcfcfc;
    border-left: 1px solid #1000f1ff;
}

/* Container: Limitahan ang lapad at i-center */
/* Table container — PALAPAD */
.spec-table-container {
    max-width: 1200px; 
    margin: 30px auto;
    border: 1px solid #1000f1ff;
    border-radius: 4px;
    overflow: hidden;
}

/* Base Table */
.spec-table {
    width: 100%;
    border-collapse: collapse;
    color: #333;
    font-family: Arial, sans-serif;
    font-size: 16px; /* Slightly increased font size to match large padding */
    table-layout: fixed;
}

/* Row Borders */
.spec-table tr {
    border-bottom: 1px solid #1000f1ff;
}

/* Cell Spacing and Text - Increased Padding for Large Spacing */
.spec-table td,
.spec-table th {
    padding: 30px 50px; /* ***LARGE PADDING APPLIED HERE*** */
    line-height: 1.5;
    text-align: left; 
}

/* Header cell */
.spec-table .feature-header {
    width: 30%;
    background: #4669ad3b;
    font-weight: bold;
    color: #213955;
    border-right: 1px solid #1000f1ff;
}

/* Value cells */
.spec-table .feature-value {
    background: #fff;
    /* Add a border to ALL feature-value cells */   
}

.spec-table .feature-value3 {
    background: #fff;
    /* Add a border to ALL feature-value cells */
    border-right: 1px solid #1000f1ff;
}

/* Remove the border from the value cell that spans all columns (the consolidated rows) */
.spec-table .feature-value3[colspan="3"] {
    width: 70%;
    border-right: none; 
}

.spec-table .feature-value[colspan] {
    width: 100%;
    border-right: none;
}

/* Remove the border from the last feature-value cell in any row (for 3-column rows) */
.spec-table tr:not(:last-child) .feature-value:last-child {
    border-right: none;
}

/* Last row no bottom border */
.spec-table tbody tr:last-child {
    border-bottom: none;
}

.top-details {
    position: relative;
    padding: 180px 0;
    color: white;
    overflow: hidden;
    
    /* 1. Add Background Image */
    background: 
    url("<?= base_url('assets_system/images/home_main.jpg') ?>") center center/cover no-repeat;
    }
    .top-details::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    .top-details h1 {
      position: relative;
      z-index: 2;
      color: white;
      font-size: 3.5rem;
      font-weight: 800;
      letter-spacing: -0.5px;
      text-transform: uppercase;
      text-align: center;
    }

.catalog-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 50px;
  max-width: 2100px;
  margin: 50px auto;
}

.catalog-btn {
  background: #0054fc3d;
  border-right: 1px solid #020202ff;
  border-left: 1px solid #020202ff;;
  border-top: 1px solid #020202ff;;
  border-bottom: 1px solid #020202ff;;
  color: #fff;
  padding: 25px 63px; /* MALAKING PADDING */
  text-decoration: none;
  font-size: 1.05rem;
  font-weight: 500;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  transition: all 0.25s ease;
  color: black;
}

/* Hover effect – subtle like image */
.catalog-btn:hover {
  background: #243f73;
  transform: translateY(-2px);
  color: white;
}

/* Icons */
.catalog-btn .icon {
  font-size: 1.1rem;
  opacity: 0.9;
}

/* Last button (wide) */
.catalog-btn.wide {
  grid-column: span 1;
}

/* Responsive */
@media (max-width: 900px) {
  .catalog-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 600px) {
  .catalog-grid {
    grid-template-columns: 1fr;
  }
}

/* ===== CASES SECTION ===== */
.cases-section {
  background: #f6f9fc;
  padding: 60px 80px;
  font-family: Arial, sans-serif;
}

/* Header */
.cases-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 40px;
}

.cases-header h2 {
  font-size: 36px;
  letter-spacing: 2px;
  margin: 0;
  color: #0b2c5f;
}

.cases-header p {
  margin-top: 8px;
  color: #555;
}

.show-all {
  color: #0b2c5f;
  text-decoration: none;
  font-size: 14px;
  border-bottom: 1px solid #0b2c5f;
  padding-bottom: 3px;
}

/* Grid */
.cases-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 30px;
}

/* Card */
.case-card {
  
  padding: 25px;
  position: relative;
  border-radius: 4px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.case-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.08);
}

/* Image */
.case-card img {
  width: 100%;
  height: 180px;
  object-fit: contain;
  margin-bottom: 20px;
}

/* Title */
.case-card h3 {
  font-size: 16px;
  color: #222;
  line-height: 1.4;
}

/* Badge */
.badge {
  position: absolute;
  bottom: 70px;
  right: 20px;
  background: #000;
  color: #fff;
  font-size: 12px;
  padding: 6px 14px;
  border-radius: 2px;
}

/* Responsive */
@media (max-width: 992px) {
  .cases-grid {
    grid-template-columns: 1fr 1fr;
  }
}

@media (max-width: 576px) {
  .cases-section {
    padding: 40px 20px;
  }
  .cases-grid {
    grid-template-columns: 1fr;
  }
}


    </style>
</head>
<body>

  <!-- ✅ Fixed Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= base_url() ?>">
        <img src=<?= base_url('assets_system/images/header_logo.png') ?> alt="Line Seiki Logo">
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
              <li><a class="dropdown-item active" href="<?= base_url('index/ps_prod') ?>">Products</a></li>
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

<!-- MAIN PRODUCT SECTION -->
<div class="product-container">
  <div class="product-wrapper">

    <!-- LEFT IMAGE AREA -->
    <div class="product-image-section">
      <div class="big-image-card">
        <img src="<?= base_url('assets_system/images/ss2_p1_series.png')?>">
      </div>
    </div>

    <!-- RIGHT INFO AREA -->
    <div class="product-info-section">

      <!-- Category / Tags -->
      <div class="product-category">Non-contact Safety Switch</div>
      <h1 class="product-title">SS2-P-1 series</h1>

      <!-- Tags -->
      <div class="product-tags">
        <span>Plastic</span>
        <span>Stand-alone</span>
      </div>

      <!-- Feature Box -->
      <div class="product-feature-box">
        <div class="feature-label">Features</div>
        <div class="feature-content">
          <p>PLd per ISO 13849-1 in stand-alone applications</p>
          <p>Cross monitoring between two channels</p>
          <p>Multiple units can be connected to one safety relay unit</p>
        </div>
      </div>

      <!-- Buttons -->
      <div class="product-buttons">
        <a href="<?= base_url('index/products_details') ?>" class="btn1 navy"><span class="icon-mail"></span>Back to Products</a>
      </div>

    </div>
  </div>
</div>


<div class="dropdown-container">
    <div class="dropdown-row">
        <button class="dropdown-button" id="scroll-to-movie">
            Movie
            <span class="dropdown-arrow">&#9662;</span>
        </button>

        <button class="dropdown-button" id="scroll-to-models">
            Models
            <span class="dropdown-arrow">&#9662;</span>
        </button>
        <button class="dropdown-button" id="scroll-to-spec">
            Specifications
            <span class="dropdown-arrow">&#9662;</span>
        </button>
        <button class="dropdown-button" id="scroll-to-download">
            Download
            <span class="dropdown-arrow">&#9662;</span>
        </button>
    </div>
    
    <div class="dropdown-row single-button" id="scroll-to-application">
        <button class="dropdown-button">
            Applications
            <span class="dropdown-arrow">&#9662;</span>
        </button>
    </div>
    <div class="title-header" id="movie-section">
        <h2>Movie</h2>
        </div>
        <div class="video-container">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/nNI2By9m0hI?si=62oO771ZGd6Ma9LC" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="title-header" id="models-section">
        <h2>Models</h2>
        </div>
       <div class="modern-table-container">
    <table id="modern-product-table">
        <thead>
            <tr>
                <th>Models</th>
                <th colspan="2">Safety Output</th>
                <th>Auxiliary Output</th>
                <th>Enclosure Material</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SS2-P-110</td>
                <td rowspan="3">Relay</td>
                <td rowspan="3">N.O. Contact x 1</td>
                <td>N.C. (SSR Output) x 1</td>
                <td rowspan="3">Polyamide 66 (PA66)</td>
            </tr>
            <tr>
                <td>SS2-P-120</td>
                <td>N.C. (PNP Open Collector Output) x 1</td>
            </tr>
            <tr>
                <td>SS2-P-130</td>
                <td>N.C. (NPN Open Collector Output) x 1</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="title-header" id="spec-section">
        <h2>Specifications</h2>
        </div>
        <div class="spec-table-container">
    <table class="spec-table">
        <tbody>
            <tr>
                <td class="feature-header">Power Supply Voltage</td>
                <td class="feature-value">DC24V (-15%/+10%)</td>
            </tr>
            
            <tr>
                <td class="feature-header">Operating Distances</td>
                <td class="feature-value">
                    Rated Operating Distance: 12mm<br>
                    Assured Switch ON Distance: 10mm<br>
                    Assured Switch OFF Distance: 15mm<br>
                    Hysteresis: 2mm Repeat Accuracy: < 5%
                </td>
            </tr>
            
            <tr>
                <td class="feature-header">Safety Output Protection</td>
                <td class="feature-value">Internal Fuse 2A</td>
            </tr>
            
            <tr>
                <td class="feature-header">Operating Temperature</td>
                <td class="feature-value">-25 ~ +60°C</td>
            </tr>

            <tr>
                <td class="feature-header">Type Coding Level (ISO 14119)</td>
                <td class="feature-value">4 / Low</td>
            </tr>

            <tr>
                <td class="feature-header">MTTFd</td>
                <td class="feature-value">＞100 years</td>
            </tr>

            <tr>
                <td class="feature-header">Complied Standards</td>
                <td class="feature-value">ISO 13849-1, ISO 14119, IEC 60204-1, IEC 61508-1, IEC 61508-2, IEC 62061, IEC 60947-5-3, UL 60947-1, UL 60947-5-2, CSA C22.2 No. 60947-1, CSA C22.2 No. 60947-5-2, CE, RoHS</td>
            </tr>
            
            </tbody>
    </table>
</div>


<div class="spec-table-container">
    <table class="spec-table">
        <tbody>
            <tr>
                <td class="feature-header">Models</td>
                <td class="feature-value3">SS2-P-210</td>
                <td class="feature-value3">SS2-P-210</td>
                <td class="feature-value3">SS2-P-210</td>
            </tr>
            
            <tr>
                <td class="feature-header">Safety Output</td>
                <td class="feature-value" colspan="3">
                    N.O. Contact x 2 (AC48V 2A (AC General Use) /
                    DC30V 2A (DC Resistive) / DC5V 10mA Min.)
                </td>
            </tr>
            
            <tr>
                <td class="feature-header">Auxiliary Output (x1)</td>
                <td class="feature-value3">N.C. x 1 (SSR Output)</td>
                <td class="feature-value3">N.C. x 1 (PNP Open Collector Output)</td>
                <td class="feature-value3">N.C. x 1 (NPN Open Collector Output)</td>
            </tr>
            
            <tr>
                <td class="feature-header">Contact Configuration</td>
                <td class="feature-value">  <img src=<?= base_url('assets_system/images/ss2_p1_config.gif') ?> alt="Line Seiki Logo"> </td>
                <td class="feature-value">  <img src=<?= base_url('assets_system/images/ss2_p1_config.gif') ?> alt="Line Seiki Logo"> </td>
                <td class="feature-value">  <img src=<?= base_url('assets_system/images/ss2_p1_config.gif') ?> alt="Line Seiki Logo"> </td>
            </tr>

            <tr>
                <td class="feature-header">Operating Current</td>
                <td class="feature-value3">60 mA</td>
                <td class="feature-value3">215 mA</td>
                <td class="feature-value3">60 mA</td>
            </tr>

            <tr>
                <td class="feature-header">Safety Relay Unit</td>
                <td class="feature-value" colspan="3">Cannot be used in combination with safety relay unit</td>
            </tr>

            <tr>
                <td class="feature-header">Dimensions</td>
                <td class="feature-value" colspan="3">Transmitter Unit : 92 x 25 x 17 mm Receiver Unit : 92 x 25 x 24.5 mm</td>
            </tr>

            <tr>
                <td class="feature-header">Weight</td>
                <td class="feature-value" colspan="3">
                  Transmitter Unit : <br>
                  80ｇ Receiver Unit (including cable) : 230ｇ
                </td>
            </tr>

             <tr>
                <td class="feature-header">Protection Glass</td>
                <td class="feature-value" colspan="3">IP68</td>
            </tr>
            
            <tr>
                <td class="feature-header">PL</td>
                <td class="feature-value" colspan="2">
                  PLd (Safety Cat.3), SIL 2: Stand-alone use only *Up to 25 safety switches can be connected in series
                </td>
            </tr>
            
            </tbody>
    </table>
</div>
<div class="title-header" id="download-section">
        <h2>Download</h2>
        </div>
<div class="catalog-grid">
  <a href="#" class="catalog-btn">Catalog (EN) <span class="icon">⬇</span></a>
  <a href="#" class="catalog-btn">Catalog (North America) <span class="icon">⬇</span></a>
  <a href="#" class="catalog-btn">Catalog (KO) <span class="icon">⬇</span></a>

  <a href="#" class="catalog-btn">Catalog (ZH-CN) <span class="icon">⬇</span></a>
  <a href="#" class="catalog-btn">Catalog (ZH-TW) <span class="icon">⬇</span></a>
  <a href="#" class="catalog-btn">Catalog (DE) <span class="icon">⬇</span></a>

  <a href="#" class="catalog-btn">Catalog (FR) <span class="icon">⬇</span></a>
  <a href="#" class="catalog-btn">Catalog (ES) <span class="icon">⬇</span></a>
  <a href="#" class="catalog-btn">Catalog (PT) <span class="icon">⬇</span></a>

  <a href="#" class="catalog-btn wide">
    Manual · CAD (Registration required)
    <span class="icon">⧉</span>
  </a>
</div>

<div class="title-header" id="application-section">
        <h2>Applications</h2>
        </div>
<section class="cases-section">
  <div class="cases-header">
    <div>
      <h2>CASES</h2>
      <p>Application examples of this solution.</p>
    </div>
    <a href="#" class="show-all">Show All →</a>
  </div>

  <div class="cases-grid">
    <!-- Card 1 -->
    <div class="case-card">
      <span class="badge">Safety</span>
      <img src=<?= base_url('assets_system/images/safety.png') ?> height="40" alt="Logo">
      <h3>Door of Food Processing Machinery</h3>
    </div>

    <!-- Card 2 -->
    <div class="case-card">
      <span class="badge">Safety</span>
      <img src=<?= base_url('assets_system/images/safety.png') ?> height="40" alt="Logo">
      <h3>Semiconductor Material Handling System</h3>
    </div>

    <!-- Card 3 -->
    <div class="case-card">
      <span class="badge">Safety</span>
      <img src=<?= base_url('assets_system/images/safety.png') ?> height="40" alt="Logo">
      <h3>Door of Semiconductor Equipment</h3>
    </div>
  </div>
</section>

        </div>
  

  <!-- CTA Section -->
  <section class="cta">
    <h1 class="fade-in">Looking for the Right Measuring Solution?</h1>
    <p class="fade-in delay-1">Contact us today to discuss your requirements and find the perfect product for your needs.</p>
    <a href="<?= base_url('index/contact_us') ?>" class="btn btn-light fade-in delay-2">INQUIRE</a>
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
  <script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>

  <script>
    document.getElementById('scroll-to-movie').addEventListener('click', function() {
    
    const targetElement = document.getElementById('movie-section');
    
    // I-scroll ang view papunta sa target element
        targetElement.scrollIntoView({
            behavior: 'smooth' // Ito ang nagbibigay ng smooth scrolling effect
        });
    });

    document.getElementById('scroll-to-models').addEventListener('click', function() {
    
    const targetElement = document.getElementById('models-section');
    
    // I-scroll ang view papunta sa target element
        targetElement.scrollIntoView({
            behavior: 'smooth' // Ito ang nagbibigay ng smooth scrolling effect
        });
    });

    document.getElementById('scroll-to-spec').addEventListener('click', function() {
    
    const targetElement = document.getElementById('spec-section');
    
    // I-scroll ang view papunta sa target element
        targetElement.scrollIntoView({
            behavior: 'smooth' // Ito ang nagbibigay ng smooth scrolling effect
        });
    });

    document.getElementById('scroll-to-download').addEventListener('click', function() {
    
    const targetElement = document.getElementById('download-section');
    
    // I-scroll ang view papunta sa target element
        targetElement.scrollIntoView({
            behavior: 'smooth' // Ito ang nagbibigay ng smooth scrolling effect
        });
    });

    document.getElementById('scroll-to-application').addEventListener('click', function() {
    
    const targetElement = document.getElementById('application-section');
    
    // I-scroll ang view papunta sa target element
        targetElement.scrollIntoView({
            behavior: 'smooth' // Ito ang nagbibigay ng smooth scrolling effect
        });
    });

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