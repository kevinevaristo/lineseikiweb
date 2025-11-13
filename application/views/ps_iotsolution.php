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
        /* Blue overlay */
        linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
        /* Background image */
        url('<?= base_url('assets_system/images/new3.jpg') ?>') center/cover no-repeat;
      color: white;
      padding: 150px 0 100px;
      position: relative;
      overflow: hidden;
      min-height: 70vh;
      display: flex;
      align-items: center;
    }

    .iot-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 1;
    }

    .iot-hero-content {
      position: relative;
      z-index: 2;
    }

    .iot-hero h2 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 30px;
      color: white;
      text-transform: uppercase;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .iot-hero p {
      font-size: 1.3rem;
      opacity: 0.95;
      margin-bottom: 30px;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* Modern Image Hover */
    .img-hover {
      transition: var(--transition);
      border-radius: 20px;
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
  animation: float 20s ease-in-out infinite;
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
            <h2>GEMBA Machine Monitoring System</h2>
            <p>
              The GEMBA Machine Monitoring System provides real-time visibility into your
              manufacturing operations. It empowers businesses to track machine performance,
              identify downtime causes, and improve efficiency.
            </p>
          </div>

          <!-- Right Image -->
          <div class="col-lg-5 text-center fade-in delay-1">
            <div class="img-hover">
              <img src="<?= base_url('assets_system/images/new-gemba.png') ?>" 
                  alt="GEMBA Overview" class="img-fluid">
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- 2. Modern System Components -->
    <section class="components-section">
      <div class="components-container">
        <div class="container fade-in">
          <h2>System Components</h2>
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

    <!-- 3. Modern Production Data -->
    <section class="production-section">
      <div class="container fade-in">
        <h2>Production Data</h2>
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