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
  padding: 200px 0 120px;
  position: relative;
  overflow: hidden;
  min-height: 85vh;
  display: flex;
  align-items: center;
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


    /* Modern System Components Section */
    .components-section {
      background: linear-gradient(135deg, var(--light-blue) 0%, #fff 100%);
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }

    .components-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2317A2DC' fill-opacity='0.03'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
      z-index: 0;
    }

    .components-container {
      position: relative;
      z-index: 1;
    }

    .components-section h2 {
      font-size: 3rem;
      color: var(--newblue2);
      font-weight: 800;
      margin-bottom: 60px;
      text-align: center;
      position: relative;
    }

    .components-section h2::after {
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

    /* Modern Component Cards */
    .component-card {
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

    .component-card::before {
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

    .component-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .component-card:hover::before {
      transform: scaleX(1);
    }

    .component-card i {
      font-size: 3.5rem;
      color: var(--newblue);
      margin-bottom: 25px;
      transition: var(--transition);
    }

    .component-card:hover i {
      transform: scale(1.1);
      color: var(--primary-blue);
    }

    .component-card h5 {
      color: var(--newblue2);
      font-weight: 700;
      margin-bottom: 20px;
      font-size: 1.4rem;
    }

    .component-card p {
      color: #495057;
      margin-bottom: 0;
      font-size: 1.1rem;
      line-height: 1.6;
    }

    /* Modern Production Data Section */
    .production-section {
      background: #fff;
      padding: 100px 0;
      position: relative;
    }

    .production-section h2 {
      font-size: 3rem;
      color: var(--newblue2);
      font-weight: 800;
      margin-bottom: 50px;
      text-align: center;
      position: relative;
    }

    .production-section h2::after {
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

    .production-section p {
      text-align: center;
      font-size: 1.2rem;
      margin-bottom: 50px;
      color: #495057;
    }

    /* Modern Data List */
    .data-list {
      background: white;
      border-radius: 20px;
      padding: 40px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    .data-item {
      padding: 15px 0;
      border-bottom: 1px solid rgba(13, 110, 253, 0.1);
      display: flex;
      align-items: center;
      transition: var(--transition);
    }

    .data-item:last-child {
      border-bottom: none;
    }

    .data-item:hover {
      transform: translateX(10px);
    }

    .data-item i {
      color: var(--newblue);
      font-size: 1.3rem;
      margin-right: 15px;
      transition: var(--transition);
    }

    .data-item:hover i {
      color: var(--primary-blue);
      transform: scale(1.2);
    }

    .data-item span {
      color: var(--newblue2);
      font-weight: 600;
      font-size: 1.1rem;
    }

    /* Modern Demo Section */
    .demo-section {
      background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
      color: white;
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }

    .demo-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    .demo-container {
      position: relative;
      z-index: 2;
    }

    .demo-section h2 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 25px;
      color: white;
      text-align: center;
    }

    .demo-section p {
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 40px;
      text-align: center;
    }

    /* Modern Form Styling */
    .demo-form {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 20px;
      padding: 50px 40px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    .form-control {
      border-radius: 12px;
      padding: 15px 20px;
      border: 1px solid #e0e0e0;
      transition: var(--transition);
      font-size: 1rem;
    }

    .form-control:focus {
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }

    .form-label {
      font-weight: 600;
      margin-bottom: 10px;
      color: var(--newblue2);
      font-size: 1rem;
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
    
    .btn-outline-blue {
      background: transparent;
      border: 2px solid var(--primary-blue);
      color: var(--primary-blue);
    }
    
    .btn-outline-blue:hover {
      background: var(--primary-blue);
      color: #fff;
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
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

    .component-card {
      animation: cardFadeIn 0.6s ease forwards;
    }

    .component-card:nth-child(1) { animation-delay: 0.1s; }
    .component-card:nth-child(2) { animation-delay: 0.2s; }
    .component-card:nth-child(3) { animation-delay: 0.3s; }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .iot-hero { padding: 120px 0 80px; min-height: 60vh; }
      .iot-hero h2 { font-size: 2.8rem; }
      .components-section h2,
      .production-section h2,
      .demo-section h2 { font-size: 2.4rem; }
      .dropdown-submenu > .dropdown-menu { left: 0; margin-top: 0; }
      footer .links a { display: inline-block; margin-bottom: 12px; }
    }
    
    @media (max-width: 768px) {
      .iot-hero { min-height: 50vh; }
      .iot-hero h2 { font-size: 2.2rem; }
      .components-section h2,
      .production-section h2,
      .demo-section h2 { font-size: 2rem; }
      footer .links a { display: block; margin-bottom: 12px; }
      .component-card { padding: 30px 20px; }
      .demo-form { padding: 30px 25px; }
      .data-list { padding: 30px 25px; }
    }

    /* Fixes */
    body > div[style*="margin-top: 90px"] { display: none !important; }


    /* Modern Demo Section with Wavy Gradient */
.demo-section {
  background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
  color: white;
  padding: 100px 0;
  position: relative;
  overflow: hidden;
}

.demo-section::before {
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

.demo-section::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: 
    /* Floating circles */
    radial-gradient(circle at 20% 80%, rgba(255,255,255,0.1) 0%, transparent 50%),
    radial-gradient(circle at 80% 20%, rgba(255,255,255,0.05) 0%, transparent 50%),
    radial-gradient(circle at 40% 40%, rgba(255,255,255,0.08) 0%, transparent 50%);
  z-index: 1;
  animation: float 13s ease-in-out infinite;
}

.demo-container {
  position: relative;
  z-index: 2;
}

.demo-section h2 {
  font-size: 3rem;
  font-weight: 800;
  margin-bottom: 25px;
  color: white;
  text-align: center;
  text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
}

.demo-section p {
  font-size: 1.2rem;
  opacity: 0.9;
  margin-bottom: 40px;
  text-align: center;
  text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
}

/* Animations */
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

@keyframes float {
  0%, 100% {
    transform: translateY(0px) rotate(0deg);
  }
  50% {
    transform: translateY(-20px) rotate(180deg);
  }
}

/* Modern Form Styling */
.demo-form {
  background: rgba(255, 255, 255, 0.95);
  backdrop-filter: blur(10px);
  border-radius: 20px;
  padding: 50px 40px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.2);
  position: relative;
  z-index: 2;
}

.form-control {
  border-radius: 12px;
  padding: 15px 20px;
  border: 1px solid #e0e0e0;
  transition: var(--transition);
  font-size: 1rem;
  background: rgba(255, 255, 255, 0.8);
}

.form-control:focus {
  border-color: var(--primary-blue);
  box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
  background: white;
}

.form-label {
  font-weight: 600;
  margin-bottom: 10px;
  color: var(--newblue2);
  font-size: 1rem;
}

.our-solution {
  padding: 80px 0;
}

.solution-title {
  font-size: 2.8rem;
  font-weight: 700;
  color: #1f2a37;
}

.solution-underline {
  width: 70px;
  height: 4px;
  background-color: #00a6e8; /* blue line like image */
  margin-top: 8px;
  border-radius: 3px;
}

.solution-img {
  max-width: 100%;
  height: auto;
  margin-top: 20px;
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

/* Floating circles for products showcase */
.our-products-showcase::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1;
  animation: float 20s ease-in-out infinite;
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

/* --- System Setup Section --- */
.system-setup-section {
  background-color: #f8f9fa; /* Light background for contrast */
  padding: 80px 0;
}

.setup-title {
  font-size: 3rem;
  color: var(--newblue2);
  font-weight: 800;
  margin-bottom: 60px;
  text-align: center;
  position: relative;
}

.setup-title::after {
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

/* Accordion Styling */
.setup-accordion {
  border: none;
}

.setup-item {
  border: none;
  margin-bottom: 10px;
  border-radius: 10px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.accordion-header .accordion-button {
  background-color: white;
  color: var(--newblue2);
  font-size: 1.5rem;
  font-weight: 600;
  padding: 1.2rem 1.5rem;
  border-radius: 10px;
  transition: var(--transition);
  border: 1px solid rgba(0, 0, 0, 0.05);
}

.accordion-header .accordion-button:not(.collapsed) {
  color: var(--primary-blue);
  background-color: var(--light-blue);
  border-bottom-left-radius: 0;
  border-bottom-right-radius: 0;
  border-color: var(--primary-blue);
}

.accordion-header .accordion-button:focus {
  box-shadow: none;
}

.accordion-body {
  padding: 1rem 1.5rem;
  background-color: white;
  border-bottom-left-radius: 10px;
  border-bottom-right-radius: 10px;
  border: 1px solid var(--primary-blue);
  border-top: none;
  color: #555;
  font-size: 1rem;
}

.accordion-body ul, 
.accordion-body p {
  margin-bottom: 0;
  padding-left: 20px;
}

.step-number {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 30px;
  height: 30px;
  background-color: var(--primary-blue);
  color: white;
  border-radius: 50%;
  font-size: 1rem;
  font-weight: 700;
  margin-right: 15px;
  flex-shrink: 0;
}

.accordion-button.collapsed .step-number {
  background-color: var(--newblue2);
}

/* Diagram Image Styling */
.setup-diagram {
  max-width: 90%;
  height: auto;
  padding: 20px;
  border-radius: 15px;
  background-color: white;
  margin-top: 50px; /* Space from title on desktop */
}

/* Responsive adjustment for image on smaller screens */
@media (max-width: 991.98px) {
  .setup-diagram {
    max-width: 100%;
    margin-top: 30px;
  }
  .setup-title {
    margin-bottom: 30px;
  }
}

/* Custom Styles for Production Data Section */
.production-data-section {
    /* Set overall background to white and remove default padding */
    background-color: white; 
    padding: 0; 
}

/* --- New: Styling for the full-width alternating strips --- */
.production-strip {
    /* Use padding to separate the items vertically */
    padding: 80px 0; 
}

.production-strip.light-blue-strip {
    /* Light blue background for Control Page and Duration Dashboard */
    background-color: var(--light-blue, #e7f1ff); 
}

.production-strip.white-strip {
    /* White background for Count Dashboard and Overview */
    background-color: white;
}

/* --- Existing Header and Text Styles --- */
.production-data-section h2.display-4 {
    color: var(--newblue2);
    font-weight: 800;
    position: relative;
    padding-bottom: 20px;
}

.production-data-section h2.display-4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, var(--newblue), var(--primary-blue));
    border-radius: 2px;
}

.production-data-section p.lead {
    color: #555;
    font-size: 1.15rem;
}

/* --- Unified Button Styles (Per Request) --- */
.production-data-section .btn {
    padding: 0.75rem 1.5rem;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
}

/* Unified Button Style */
.production-data-section .btn-info,
.production-data-section .btn-secondary,
.production-data-section .btn {
    /* Base color: #495057 (Dark Gray) */
    background-color: #495057; 
    border-color: #495057;
    color: white;
    box-shadow: none !important; 
}

/* Unified Hover Style */
.production-data-section .btn-info:hover,
.production-data-section .btn-secondary:hover,
.production-data-section .btn:hover {
    /* Hover color: var(--primary-blue-dark) */
    background-color: var(--primary-blue-dark);
    border-color: var(--primary-blue-dark);
    color: white;
}

/* Ensure no 'active' styling changes the color */
.production-data-section .btn.active {
    background-color: #495057 !important;
    border-color: #495057 !important;
    color: white !important;
}

/* --- Individual Data Item Styling --- */
.production-data-item {
    margin-bottom: 0; 
}

.production-data-item h3 {
    color: var(--newblue2);
    font-weight: 700;
    font-size: 2.2rem;
}

.production-data-item p {
    color: #6c757d;
    font-size: 1.1rem;
    line-height: 1.8;
}



/* --- Responsive adjustments for ordering --- */
@media (max-width: 991.98px) {
    .production-data-item .col-lg-6 {
        order: unset !important;
        text-align: center;
    }
    .production-data-item .col-lg-6:first-child {
        margin-bottom: 20px;
    }
    .production-data-item h3 {
        font-size: 1.8rem;
    }
    .production-data-item p {
        font-size: 1rem;
    }
    .production-strip {
        padding: 40px 0;
    }
    .production-data-section h2.display-4 {
        font-size: 2.5rem;
    }
    .production-data-section p.lead {
        font-size: 1rem;
    }
}

@media (max-width: 767.98px) {
    .production-data-section h2.display-4 {
        font-size: 2rem;
    }
    .production-data-section .btn {
        font-size: 0.9rem;
        padding: 0.6rem 1.2rem;
    }
}

/* --- Fade-in animation for elements --- */
.fade-in {
    opacity: 0;
    transform: translateY(20px);
    transition: opacity 0.8s ease-out, transform 0.8s ease-out;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}

/* --- NEW Image Styling for all Dashboard Images --- */
.dashboard-image, 
.production-data-item img { 
    /* Ensures image is responsive and fits the column width (equivalent to img-fluid) */
    max-width: 100%; 
    height: auto;
    display: block;
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


<section class="section-white our-solution">
  <div class="container">
    <div class="row align-items-center">

      <div class="col-lg-6 fade-in">
        <h2 class="solution-title">Our Solution</h2>
        <div class="solution-underline"></div>

        <p class="mt-4">
          Manual recording and delayed updates make it difficult
          to see what’s really happening on the shop floor.
        </p>

        <p>
          The GEMBA Reporter Machine Monitoring System helps
          eliminate blind spots by capturing machine data automatically —
          so you can identify downtime causes, improve efficiency,
          and make data-driven decisions faster.
        </p>
      </div>

      <div class="col-lg-6 text-center fade-in delay-1">
        <img src="<?= base_url('assets_system/images/Machine1.png') ?>" 
             alt="GEMBA Overview" class="img-fluid solution-img-original">
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

      <div class="col-12 text-center fade-in">
        <h2 class="setup-title">System Set-Up</h2>
      </div>

      <div class="col-lg-6 col-md-12 fade-in delay-1">
        <div class="accordion setup-accordion" id="systemSetupAccordion">

          <div class="accordion-item setup-item">
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

          <div class="accordion-item setup-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                <span class="step-number">2</span> Base Station
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
                <ul>
                  <li> Connects with up to 10 machines</li>
                  <li> Receives data wirelessly</li>
                  <li>Sends data to the Data Server through LAN</li>
                  <li> Acts as the “hub” for a group of machines</li>
                </ul>
              </div>
            </div>
          </div>

          <div class="accordion-item setup-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <span class="step-number">3</span> Factory Network
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
               <ul>
                  <li> Router/switch connects everything</li>
                  <li>Data Server + Base Stations must use LAN cables</li>
                  <li>Your PC or tablet just needs to be on the same network as GEMBA system (access via network) OR in the wifi range of Dataserver (if accessing wirelessly).</li>
                </ul>
              </div>
            </div>
          </div>
          
          <div class="accordion-item setup-item">
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
                  <li> Supports up to 12 Base Stations (120 machines)</li>
                </ul>
              </div>
            </div>
          </div>
          
          <div class="accordion-item setup-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                <span class="step-number">5</span> User Device
              </button>
            </h2>
            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#systemSetupAccordion">
              <div class="accordion-body">
                <ul>
                  <li> No software installation</li>
                  <li>Works on PC, laptop, or tablet</li>
                  <li> View machine status, downtime, records, and reports</li>
                  <li> Export data to Excel with one click</li>
                </ul>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="col-lg-6 col-md-12 text-center fade-in delay-2">
        <img src="<?= base_url('assets_system/images/system-setupnobg.png') ?>" 
             alt="GEMBA System Setup Diagram" class="img-fluid setup-diagram">
      </div>

    </div>
  </div>
</section>

    <section id="production-data" class="production-data-section">
    <div class="container pt-5">
        <div class="row text-center mb-5 fade-in">
            <div class="col-12">
                <h2 class="display-4 fw-bold text-primary mb-3">Production Data</h2>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    The GEMBA dashboard gives you a comprehensive view of your machine status.
                </p>
                <div class="d-flex justify-content-center flex-wrap gap-2 mb-4">
                    <a href="#" class="btn btn-info">Control Page</a>
                    <a href="#" class="btn btn-secondary">Count Dashboard</a>
                    <a href="#" class="btn btn-secondary">Duration Dashboard</a>
                    <a href="#" class="btn btn-secondary">Overview</a>
                </div>
            </div>
        </div>
    </div>

    <div class="production-strip light-blue-strip">
    <div class="container">
        <div class="row align-items-center production-data-item fade-in">
            <div class="col-lg-6 order-lg-1">
                <h3 class="h2 fw-bold text-dark mb-3">Control Page</h3>
                <p class="lead text-muted">
                    Input and monitor essential machine job details in one place.
                </p>
            </div>
            <div class="col-lg-6 order-lg-2 text-center mt-4 mt-lg-0">
                <img src="<?= base_url('assets_system/images/2xpage-nobg.png') ?>" alt="Control Page Dashboard" class="dashboard-image">
            </div>
        </div>
    </div>
</div>

    <div class="production-strip white-strip">
        <div class="container">
            <div class="row align-items-center production-data-item fade-in">
                <div class="col-lg-6 order-lg-2">
                    <h3 class="h2 fw-bold text-dark mb-3">Count Dashboard</h3>
                    <p class="lead text-muted">
                        Track actual output versus target quantity for every machine. Easily visualize progress percentages and ensure production goals are being met in real time.
                    </p>
                </div>
                <div class="col-lg-6 order-lg-1 text-center mt-4 mt-lg-0">
                    <img src="<?= base_url('assets_system/images/2xpage-nobg.png') ?>" alt="Count Dashboard" class="dashboard-image">
                </div>
            </div>
        </div>
    </div>

    <div class="production-strip light-blue-strip">
        <div class="container">
            <div class="row align-items-center production-data-item fade-in">
                <div class="col-lg-6 order-lg-1">
                    <h3 class="h2 fw-bold text-dark mb-3">Duration Dashboard</h3>
                    <p class="lead text-muted">
                        This page shows the running time and downtime of multiple machines. You can easily see how long each machine has been working or idle.
                    </p>
                </div>
                <div class="col-lg-6 order-lg-2 text-center mt-4 mt-lg-0">
                    <img src="<?= base_url('assets_system/images/2xpage-nobg.png') ?>" alt="Duration Dashboard" class="dashboard-image">
                </div>
            </div>
        </div>
    </div>

    <div class="production-strip white-strip">
        <div class="container">
            <div class="row align-items-center production-data-item fade-in">
                <div class="col-lg-6 order-lg-2">
                    <h3 class="h2 fw-bold text-dark mb-3">Overview</h3>
                    <p class="lead text-muted">
                        Gives you a quick snapshot of all machines in one view — making it easy to check the overall production status at a glance.
                    </p>
                </div>
                <div class="col-lg-6 order-lg-1 text-center mt-4 mt-lg-0">
                    <img src="<?= base_url('assets_system/images/2xpage-nobg.png') ?>" alt="Overview Dashboard" class="dashboard-image">
                </div>
            </div>
        </div>
    </div>

    
</section>

    <!-- 2. Modern System Components -->
    <section class="components-section">
      <div class="components-container">
        <div class="container fade-in">
          <h2>MODERN</h2>
          <div class="row mt-4">
            <div class="col-md-4 mb-4">
              <div class="component-card">
                <i class="fas fa-microchip"></i>
                <h5>Smart Counter</h5>
                <p>Input device that collects machine data.</p>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="component-card">
                <i class="fas fa-server"></i>
                <h5>Base Station</h5>
                <p>Data receiver that aggregates information from counters.</p>
              </div>
            </div>
            <div class="col-md-4 mb-4">
              <div class="component-card">
                <i class="fas fa-chart-line"></i>
                <h5>Gemba Reporter</h5>
                <p>Software platform to analyze and view production data.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 3. Modern  -->
    <section class="production-section">
      <div class="container fade-in">
        <h2>GEMBA</h2>
        <p>GEMBA collects critical production information to enhance decision-making:</p>
        <div class="row mt-4 justify-content-center">
          <div class="col-lg-8">
            <div class="data-list">
              <div class="row">
                <div class="col-md-6">
                  <div class="data-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Machine status (running, idle, stopped)</span>
                  </div>
                  <div class="data-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Downtime causes and frequency</span>
                  </div>
                  <div class="data-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Production efficiency analysis</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="data-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Throughput analysis</span>
                  </div>
                  <div class="data-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Real-time performance metrics</span>
                  </div>
                  <div class="data-item">
                    <i class="fas fa-check-circle"></i>
                    <span>Historical data trends</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 4. Modern Request Demo -->
    <section class="demo-section">
      <div class="demo-container">
        <div class="container fade-in">
          <div class="row justify-content-center">
            <div class="col-lg-8">
              <h2>Request a Demo</h2>
              <p>Interested in experiencing GEMBA in action? Request a demo or inquire about testing GEMBA on your machines.</p>
              <div class="demo-form">
                <form>
                  <div class="row">
                    <div class="col-md-6 mb-4">
                      <label class="form-label">Name</label>
                      <input type="text" class="form-control" placeholder="Your Name">
                    </div>
                    <div class="col-md-6 mb-4">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" placeholder="Your Email">
                    </div>
                  </div>
                  <div class="mb-4">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" rows="4" placeholder="Your Inquiry"></textarea>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-lg">Submit Request</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

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