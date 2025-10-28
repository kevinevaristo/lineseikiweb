<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Line Seiki Asia Pacific Service</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  


  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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

    /* ===== NAVBAR STYLES ===== */
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
    
    section img {
      width: 100%;
      border-radius: 16px;
      transition: var(--transition);
      transform: translateY(0);
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
    
    .section-light-orange {
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

    /* ===== TYPES GRID STYLES ===== */
    .container-one {
      max-width: 1200px;
      margin: 0 auto;
      text-align: center;
    }
    
    .container-one h2 {
      text-align: center;
      margin-bottom: 40px;
      color: var(--primary-blue);
      font-weight: 700;
      position: relative;
    }
    
    .container-one h2::after {
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
    
    .types-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 40px;
    }
    
    .type-card {
      background: #fff;
      padding: 30px 25px;
      border-radius: 16px;
      transition: var(--transition);
      text-align: center;
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .type-card:hover {
      transform: translateY(-8px);
    }
    
    .type-card img {
      width: 80px;
      height: 80px;
      margin-bottom: 20px;
      object-fit: contain;
    }
    
    .type-card h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--primary-blue);
    }
    
    .type-card p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .type-card .see-more {
      display: inline-block;
      padding: 8px 20px;
      background: var(--primary-blue);
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-weight: 500;
      transition: var(--transition);
    }
    
    .type-card .see-more:hover {
      background: var(--newblue);
      transform: translateY(-2px);
    }

    /* ===== CASE STUDIES STYLES ===== */
    .case-studies {
      padding: 80px 0;
    }
    
    .case-studies .container {
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .case-studies h2 {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--primary-blue);
      margin-bottom: 15px;
      text-align: center;
      position: relative;
    }
    
    .case-studies h2::after {
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
    
    .subtitle {
      font-size: 1.1rem;
      color: #495057;
      margin-bottom: 60px;
      text-align: center;
      max-width: 700px;
      margin-left: auto;
      margin-right: auto;
    }
    
    .case-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 30px;
    }
    
    .case-card {
      background: #fff;
      border-radius: 16px;
      overflow: hidden;
      transition: var(--transition);
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .case-card:hover {
      transform: translateY(-8px);
    }
    
    .case-card img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-bottom: 3px solid var(--primary-blue);
    }
    
    .card-content {
      padding: 25px;
    }
    
    .card-content h3 {
      font-size: 1.3rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--primary-blue);
    }
    
    .card-content p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .card-content a {
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--primary-blue);
      text-decoration: none;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
    }
    
    .card-content a:hover {
      color: var(--newblue);
    }
    
    .card-content a::after {
      content: '→';
      margin-left: 5px;
      transition: var(--transition);
    }
    
    .card-content a:hover::after {
      transform: translateX(3px);
    }

    /* ===== UPLOAD SECTION STYLES ===== */
    .portal-wrapper {
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
    }
    
    .upload-section {
      background-color: #ffffff;
      border-radius: 16px;
      padding: 40px 30px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      text-align: center;
      max-width: 450px;
      width: 100%;
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .icon-header {
      font-size: 3.5rem;
      color: var(--primary-blue);
      margin-bottom: 20px;
    }
    
    .upload-section h2 {
      font-size: 1.8rem;
      color: var(--primary-blue);
      margin-bottom: 15px;
      font-weight: 600;
    }
    
    .upload-section .description {
      font-size: 1rem;
      color: #495057;
      margin-bottom: 30px;
      line-height: 1.6;
    }
    
    .custom-file-upload {
      display: inline-block;
      background: var(--primary-blue);
      color: white;
      padding: 12px 25px;
      border-radius: 8px;
      cursor: pointer;
      transition: var(--transition);
      margin-bottom: 20px;
      font-weight: 500;
      border: none;
    }
    
    .custom-file-upload:hover {
      background: var(--primary-blue-dark);
      transform: translateY(-2px);
    }
    
    .selected-file-name {
      display: block;
      font-size: 0.9rem;
      color: #6c757d;
      margin-bottom: 30px;
    }
    
    .submit-project-btn {
      background: var(--newblue);
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 8px;
      font-size: 1.05rem;
      cursor: pointer;
      transition: var(--transition);
      width: 100%;
      font-weight: 600;
    }
    
    .submit-project-btn:hover {
      background: var(--newblue2);
      transform: translateY(-2px);
    }

    /* ===== CTA CARD STYLES ===== */
    .cta-card {
      background: var(--newblue2);
      color: #fff;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      max-width: 600px;
      width: 100%;
      padding: 50px 40px;
      text-align: center;
      transition: var(--transition);
    }
    
    .cta-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }
    
    .cta-title {
      font-size: 2.2rem;
      font-weight: 700;
      margin-bottom: 20px;
      color: #fff !important;
    }
    
    .cta-subtitle {
      font-size: 1.1rem;
      opacity: 0.9;
      margin-bottom: 40px;
      color: #fff !important;
      line-height: 1.6;
    }
    
    .cta-buttons {
      display: flex;
      gap: 20px;
      justify-content: center;
      flex-wrap: wrap;
    }
    
    .cta-title::after {
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

    /* ===== FOOTER STYLES ===== */
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

    /* ===== CAPABILITIES SECTION STYLES ===== */
    .capabilities-section {
      padding: 100px 0;
      background: linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%), url('<?= base_url('assets_system/images/simulation10.jpg') ?>');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
      overflow: hidden;
    }
    
    .capabilities-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: inherit;
      z-index: 0;
    }
    
    .capabilities-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      position: relative;
      z-index: 1;
    }
    
    .capabilities-title {
      text-align: center;
      margin-bottom: 60px;
      color: white;
      font-weight: 700;
      position: relative;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }
    
    .capabilities-title::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, #ffffff, #e7f1ff);
      border-radius: 2px;
    }
    
    .capabilities-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 40px;
    }
    
    .capability-category {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 16px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
    }
    
    .capability-category:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
      background: rgba(255, 255, 255, 0.98);
    }
    
    .capability-category h3 {
      color: var(--primary-blue);
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--light-blue);
    }
    
    .capability-items {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
    }
    
    .capability-item {
      background: var(--light-blue);
      color: var(--primary-blue);
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: var(--transition);
    }
    
    .capability-item:hover {
      background: var(--primary-blue);
      color: white;
      transform: translateY(-2px);
    }

    /* ===== BENEFITS SECTION STYLES ===== */
    .benefits-section {
      padding: 100px 0;
      background: #fff;
    }
    
    .benefits-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .benefits-title {
      text-align: center;
      margin-bottom: 60px;
      color: var(--primary-blue);
      font-weight: 700;
      position: relative;
    }
    
    .benefits-title::after {
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
    
    .benefits-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 40px;
    }
    
    .benefit-card {
      background: #fff;
      border-radius: 16px;
      padding: 40px 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      border: 1px solid rgba(13, 110, 253, 0.1);
      text-align: center;
    }
    
    .benefit-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }
    
    .benefit-card h3 {
      color: var(--primary-blue);
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 20px;
    }
    
    .benefit-card p {
      color: #495057;
      font-size: 1rem;
      line-height: 1.6;
      margin: 0;
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

    /* ===== SPECIAL SECTION WHITE STYLES ===== */
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
      background: 
        linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
        url('<?= base_url('assets_system/images/simulation3.jpg') ?>');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      z-index: 0;
    }


    .section-white h1,
    .section-white h4,
    .section-white h5,                                                      
    .section-white p {
      color: white;
      text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .section-white h1::after {
      background: linear-gradient(90deg, #ffffff, #e7f1ff);
    }
    .section-white .col-lg-6:last-child img[src*="simulation9.png"] {
        box-shadow: none !important;
        border: none !important;
        border-radius: 0 !important;
        background: transparent !important;
        max-width: 85% !important;
        height: auto !important;
        display: block;
        margin-left: auto;
        transform: none !important;
    }

    /* Remove hover effects for this specific image */
    .section-white .col-lg-6:last-child img[src*="simulation9.png"]:hover {
        transform: none !important;
        box-shadow: none !important;
    }

    /* Adjust text alignment and spacing */
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

    /* Add consultation button styling */
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

    /* Remove background from Section 3 and Section 5 only */
    section.section-white:nth-of-type(3),
    section.section-white:nth-of-type(5) {
      background: none !important;
    }

    section.section-white:nth-of-type(3)::before,
    section.section-white:nth-of-type(5)::before {
      background: none !important;
    }

    /* ===== WHAT WE DO SECTION STYLES ===== */
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
    }
    
    .what-we-do-title::after {
      content: '';
      position: absolute;
      left: 0;
      bottom: -10px;
      width: 60px;
      height: 4px;
      background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
      border-radius: 2px;
    }
    
    .what-we-do-text {
      font-size: 1.1rem;
      color: #495057;
      line-height: 1.7;
      max-width: 100%;
    }

    /* ===== RESPONSIVE STYLES ===== */
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
      
      .types-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      }
      
      .case-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      }
      
      .capabilities-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      }
      
      .benefits-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      }
      
      .section-white .col-lg-6:first-child {
        padding-right: 0;
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
      
      .cta-buttons {
        flex-direction: column;
        align-items: center;
      }
      
      .cta-buttons .btn {
        width: 100%;
        max-width: 250px;
      }
      
      .capabilities-grid {
        grid-template-columns: 1fr;
      }
      
      .benefits-grid {
        grid-template-columns: 1fr;
      }
      
      .section-white .col-lg-6:first-child h1 {
        font-size: 2.5rem;
      }
    }
    .cta-title::after {
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
/* Add this to your existing CSS */
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
  background: 
    linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
    url('<?= base_url('assets_system/images/simulation3.jpg') ?>');
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
  background: linear-gradient(90deg, #ffffff, #e7f1ff);
}
.section-white .col-lg-6:last-child img[src*="simulation9.png"] {
    box-shadow: none !important;
    border: none !important;
    border-radius: 0 !important;
    background: transparent !important;
}

/* Optional: If you want to make it look more natural */
.section-white .col-lg-6:last-child img[src*="simulation9.png"] {
    max-width: 100%;
    height: auto;
    display: block;
}

/* Adjust simulation8.png size and positioning */
.section-white .col-lg-6:last-child img[src*="simulation9.png"] {
    box-shadow: none !important;
    border: none !important;
    border-radius: 0 !important;
    background: transparent !important;
    max-width: 85% !important;
    height: auto !important;
    display: block;
    margin-left: auto;
    transform: none !important;
}

/* Remove hover effects for this specific image */
.section-white .col-lg-6:last-child img[src*="simulation9.png"]:hover {
    transform: none !important;
    box-shadow: none !important;
}

/* Adjust text alignment and spacing */
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

/* Add consultation button styling */
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
.reduced-cost-section {
  background-color: #fff;
}

.reduced-cost-section .main-gif {
  width: 100%;
  border-radius: 10px;
}

.benefit-item i {
  color: #0d6efd; /* Bootstrap primary blue */
}

.benefit-item h5 {
  color: #000;
}

.benefit-item p {
  color: #444;
  font-size: 0.95rem;
}

@media (max-width: 768px) {
  .reduced-cost-section .col-md-7 {
    margin-bottom: 2rem;
  }
}
.simulation-section {
  background-color: #fff;
}

.simulation-section h2 {
  font-size: 2rem;
}

.simulation-section .underline {
  width: 50px;
  height: 3px;
  background-color: #0d6efd;
  border: none;
  margin: 10px 0 20px;
}

.simulation-section .btn-primary {
  background-color: #0d6efd;
  border: none;
}

.simulation-card {
  background-color: #004c91;
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.simulation-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.simulation-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

.simulation-card .card-body {
  padding: 20px;
}

.simulation-card h5 {
  color: #fff;
  margin-bottom: 10px;
}

.simulation-card p {
  color: #d9e4f5;
  margin-bottom: 10px;
}

.simulation-card .read-more {
  text-decoration: none;
}

.simulation-card .read-more:hover {
  text-decoration: underline;
}

.simulation-section {
  background-color: #fff;
  position: relative;
}

.simulation-section h2 {
  font-size: 2rem;
}

.simulation-section .underline {
  width: 50px;
  height: 3px;
  background-color: #0d6efd;
  border: none;
  margin: 10px 0 20px;
}

.simulation-section .btn-primary {
  background-color: #0d6efd;
  border: none;
}

.simulation-card {
  background-color: #004c91;
  border-radius: 10px;
  overflow: hidden;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.simulation-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.simulation-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
}

.simulation-card .card-body {
  padding: 20px;
}

.simulation-card h5 {
  color: #fff;
  margin-bottom: 10px;
}

.simulation-card p {
  color: #d9e4f5;
  margin-bottom: 10px;
}

.simulation-card .read-more {
  text-decoration: none;
}

.simulation-card .read-more:hover {
  text-decoration: underline;
}

/* --- Carousel Control Buttons (Outside version) --- */
.carousel-controls-outside {
  position: absolute;
  bottom: 10px;
  right: 10px;
  display: flex;
  gap: 8px;
}

.carousel-control-prev,
.carousel-control-next {
  position: static;
  background-color: #0d6efd;
  border: none;
  border-radius: 50%;
  width: 35px;
  height: 35px;
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
.process-section {
  background-color: #fff;
}

.process-section .underline {
  width: 50px;
  height: 3px;
  background-color: #0d6efd;
  border: none;
  margin-bottom: 30px;
}

.process-icon {
  width: 80px;
  height: 80px;
  border-radius: 15px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.process-section i {
  font-size: 2rem;
}

@media (max-width: 768px) {
  .process-section .col-md-1 {
    display: none;
  }
}

/* Remove gridlines from Section 5 and 6 */
.simulation-section .row,
.process-section .row {
    border: none !important;
    outline: none !important;
}

.simulation-section [class*="col-"],
.process-section [class*="col-"] {
    border: none !important;
    outline: none !important;
    box-shadow: none !important;
}

/* Remove any potential borders from carousel items */
.simulation-section .carousel-item .row,
.simulation-section .carousel-item [class*="col-"] {
    border: none !important;
    outline: none !important;
}

/* Remove borders from process section arrows and icons */
.process-section .col-md-1,
.process-section .process-icon {
    border: none !important;
    outline: none !important;
}
</style>
  </style>
</head>
<body>

 <!-- ✅ Fixed Navbar -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top">
  <div class="container-fluid">
    <!-- Logo on the LEFT -->
    <a class="navbar-brand" href="<?= base_url() ?>">
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
        <li class="nav-item"><a class="nav-link" href="<?= base_url('index/about_us') ?>">About Us</a></li>

        <!-- Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
            Product and Services
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="<?= base_url('index/ps_prod') ?>">Products</a></li>

            <!-- Submenu -->
            <li class="dropdown-submenu">
              <a class="dropdown-item dropdown-toggle active" href="#">Services</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item active" href="<?= base_url('index/ps_serv_simulation') ?>">Simulation Analysis</a></li>
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

 <!-- Section 1 (white) -->
<section class="section-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <h1>Validate. Optimize. Innovate.</h1>
                <p>We help engineers and manufacturers reduce design <br> errors, speed up development, and bring better products <br> to market—through virtual testing and engineering<br> simulation.</p>
                <a href="#consultation" class="consultation-btn">Schedule a Consultation</a>
            </div>
            <div class="col-lg-6 fade-in delay-1">
                <img src="<?= base_url('assets_system/images/simul1bg.png') ?>" alt="Simulation Analysis">
            </div>
        </div>
    </div>
</section>

 <!-- What We Do Section -->
<section class="what-we-do-section">
  <div class="what-we-do-container">
    <h1 class="what-we-do-title fade-in">What We Do</h1>
    <div class="what-we-do-text fade-in">
      <p>Line Seiki offers Computer-Aided Engineering (CAE) Simulation Analysis services that help manufacturers and product designers evaluate performance, reliability, and safety—before physical prototyping begins.</p>
      <p>Through advanced simulation and virtual testing, our engineers analyze factors such as stress, heat, vibration, and fatigue to predict how a design will behave under real-world conditions. Backed by decades of engineering experience and a strong foundation in manufacturing, Line Seiki supports industries such as automotive, semiconductor, consumer electronics, and general manufacturing in achieving smarter, data-driven product development.</p>
    </div>
  </div>
</section>

 <!-- Capabilities Section -->
<section class="capabilities-section">
  <div class="capabilities-container">
    <h1 class="capabilities-title fade-in">Our Capabilities</h1>
    
    <div class="capabilities-grid">
      <!-- Structural and Durability -->
      <div class="capability-category fade-in">
        <h3>Structural and Durability</h3>
        <div class="capability-items">
          <span class="capability-item">Static</span>
          <span class="capability-item">Composites</span>
          <span class="capability-item">Vibration</span>
          <span class="capability-item">Explicit</span>
          <span class="capability-item">Buckling</span>
          <span class="capability-item">Fatigue</span>
          <span class="capability-item">Heat Transfer</span>
          <span class="capability-item">Dynamics</span>
        </div>
      </div>
      
      <!-- Manufacturing -->
      <div class="capability-category fade-in delay-1">
        <h3>Manufacturing</h3>
        <div class="capability-items">
          <span class="capability-item">Machining</span>
          <span class="capability-item">Thermomechanical</span>
          <span class="capability-item">Elastomers</span>
          <span class="capability-item">Metal</span>
        </div>
      </div>
      
      <!-- Electronics, Electromagnetics, Optimization & Oil and Gas -->
      <div class="capability-category fade-in delay-2">
        <h3>Electronics, Electromagnetics, Optimization & Oil and Gas</h3>
        <div class="capability-items">
          <span class="capability-item">PCB</span>
          <span class="capability-item">Low Frequency</span>
          <span class="capability-item">Induction</span>
          <span class="capability-item">Circuit</span>
          <span class="capability-item">Piping</span>
          <span class="capability-item">Parametic</span>
          <span class="capability-item">Non-Parametric</span>
          <span class="capability-item">Pressure vessels</span>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="reduced-cost-section container py-5">
  <div class="row align-items-center">
    <!-- Left side (GIF + 2 images) -->
    <div class="col-md-7 text-center"><br><br><br><br>
      <img src="<?= base_url('assets_system/images/newsimgif.gif') ?>" alt="Simulation GIF" class="img-fluid rounded shadow main-gif mb-3">
      <div class="row">
        <div class="col-6">
          <img src="<?= base_url('assets_system/images/newsim1.png') ?>" alt="Model Image 1" class="img-fluid rounded shadow">
        </div>
        <div class="col-6">
          <img src="<?= base_url('assets_system/images/newsim2.png') ?>" alt="Model Image 2" class="img-fluid rounded shadow"><br><br><br><br>
        </div>
      </div>
    </div>

    <!-- Right side (Text + icons) -->
    <div class="col-md-5 text-start ps-md-4">
      <div class="benefit-item d-flex align-items-start mb-4">
        <div class="icon me-3 text-primary">
          <i class="bi bi-clock-history fs-1"></i>
        </div>
        <div>
          <h5 class="fw-bold">Reduced Cost and Time</h5>
          <p class="mb-0">Minimize physical prototyping and rework through accurate virtual testing.</p>
        </div>
      </div>

      <div class="benefit-item d-flex align-items-start mb-4">
        <div class="icon me-3 text-primary">
          <i class="bi bi-shield-check fs-1"></i>
        </div>
        <div>
          <h5 class="fw-bold">Enhanced Reliability</h5>
          <p class="mb-0">Predict real-world performance and prevent failures before production.</p>
        </div>
      </div>

      <div class="benefit-item d-flex align-items-start">
        <div class="icon me-3 text-primary">
          <i class="bi bi-cash-coin fs-1"></i>
        </div>
        <div>
          <h5 class="fw-bold">Cost Savings</h5>
          <p class="mb-0">Lower material waste, shorten testing cycles, and reduce overall development expenses through efficient design validation.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="simulation-section container py-5 position-relative">
  <div class="row align-items-center">
    <!-- Left Text Section -->
    <div class="col-md-4 mb-4 mb-md-0">
      <h1 class="fw-bold text-primary">Simulation <br> in Action</h1>
      <hr class="underline">
      <p class="text-muted">
        A showcase of simulation-driven insights demonstrating how Line Seiki applies 
        Computer-Aided Engineering to solve complex design and manufacturing problems.
      </p>
      <button class="btn btn-primary px-4 py-2 rounded-pill">Talk to Experts</button>
    </div>

    <!-- Right Carousel Section -->
    <div class="col-md-8">
      <div id="simulationCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
          
          <!-- Slide 1 -->
          <div class="carousel-item active">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="simulation-card h-100 shadow-sm"><br>
                  <img src="<?= base_url('assets_system/images/cs1.png') ?>" 
                       class="card-img-top" alt="Simulation 1">
                  <div class="card-body">
                    <h5 class="fw-bold">Structural Analysis of a Gear Jig During Process Setup</h5>
                    <p class="text-light small">
                      This study presents a structural contact stress analysis to investigate part deformation 
                      and gear-jig interaction during process setup...
                    </p>
                    <a href="#" class="read-more text-light fw-semibold">Read more</a>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="simulation-card h-100 shadow-sm"><br>
                  <img src="<?= base_url('assets_system/images/cs2.png') ?>" 
                       class="card-img-top" alt="Simulation 2">
                  <div class="card-body">
                    <h5 class="fw-bold">Buckling Analysis of a Consumer Electronics Enclosure</h5>
                    <p class="text-light small">
                      This analysis evaluates the stability of an enclosure cover under elevated temperature. 
                      Simulation predicted deformation and...
                    </p>
                    <a href="#" class="read-more text-light fw-semibold">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item">
            <div class="row g-4">
              <div class="col-md-6">
                <div class="simulation-card h-100 shadow-sm"><br>
                  <img src="<?= base_url('assets_system/images/cs3.png') ?>" 
                       class="card-img-top" alt="Simulation 3">
                  <div class="card-body">
                    <h5 class="fw-bold">Thermal Simulation of Metal Components</h5>
                    <p class="text-light small">
                      A finite element thermal analysis evaluating heat distribution across machined steel 
                      parts during sustained operation...
                    </p>
                    <a href="#" class="read-more text-light fw-semibold">Read more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
<br>
      <!-- Carousel Controls (Now outside the card area) -->
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
<br><br><br>
<section class="process-section py-5 text-center">
  <div class="container">
    <h1 class="fw-bold text-primary mb-2">Process & Requirements</h1>
    <hr class="underline mx-auto">
    <p class="text-muted mb-5">
      Each project includes a comprehensive report with visual results, data, and recommendations.
    </p>

    <div class="row justify-content-center align-items-center text-center g-4">
      <!-- Step 1 -->
      <div class="col-md-3">
        <div class="process-icon bg-primary text-white mx-auto mb-3">
          <i class="bi-diagram-3 fs-1"></i>
        </div>
        <h5 class="fw-bold">Model Development</h5>
        <p class="text-muted small">
          Provide us with some information necessary for analysis (CAD, Materials, Boundary Condition, etc.)
        </p>
      </div>

      <!-- Arrow -->
      <div class="col-md-1 d-none d-md-block">
        <i class="bi-arrow-right fs-2 text-secondary opacity-50"></i>
      </div>

      <!-- Step 2 -->
      <div class="col-md-3">
        <div class="process-icon bg-primary text-white mx-auto mb-3">
          <i class="bi-graph-up fs-1"></i>
        </div>
        <h5 class="fw-bold">Solving (Simulation)</h5>
        <p class="text-muted small">
          Analysis is performed from various aspects.
        </p>
      </div>

      <!-- Arrow -->
      <div class="col-md-1 d-none d-md-block">
        <i class="bi-arrow-right fs-2 text-secondary opacity-50"></i>
      </div>

      <!-- Step 3 -->
      <div class="col-md-3">
        <div class="process-icon bg-primary text-white mx-auto mb-3">
          <i class="bi-person-check fs-1"></i>
        </div>
        <h5 class="fw-bold">Results</h5>
        <p class="text-muted small">
          The report of analysis will be submitted to you.
        </p>
      </div>
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
      
      // File upload functionality
      document.getElementById('file-upload').addEventListener('change', function() {
        const fileName = this.files.length > 0 ? this.files[0].name : 'No file selected';
        document.getElementById('file-name').textContent = fileName;
      });
    });
  </script>
</body>
</html>