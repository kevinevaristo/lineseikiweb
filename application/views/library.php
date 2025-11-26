<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library - Line Seiki Asia Pacific</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    /* =========================
       🎨 Variables
    ========================= */
    :root {
      /* Orange variables kept for reference but unused in this version */
      --primary-orange: #fd7e14;
      --primary-orange-dark: #e67300;
      
      --primary-blue: #0d6efd;
      --primary-blue-dark: #0a58ca;
      --light-blue: #e7f1ff;
      --light-orange: #fff3e8;
      --light-gray: #f8f9fa;
      --dark: #212529;
      /* Target Blues */
      --newblue: #17A2DC; /* RGB: 23, 162, 220 */
      --newblue2: #0F467B;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    /* =========================
       📌 Base Styles
    ========================= */
    html { scroll-behavior: smooth; }
    body {
      background-color: #fff;
      color: #333;
      font-family: 'Inter', sans-serif;
      line-height: 1.6;
      overflow-x: hidden;
      padding-top: 90px;
    }
    hr { background: rgba(255, 255, 255, 0.1); height: 1px; }

    /* =========================
       🟦 Navbar
    ========================= */
    .navbar {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      padding: 0.8rem 5%;
      transition: var(--transition);
      border-bottom: 1px solid rgba(13, 110, 253, 0.1);
    }
    .navbar.scrolled { padding: 0.6rem 5%; }
    .navbar-brand img { height: 40px; width: auto; transition: var(--transition); }
    .navbar-nav .nav-link {
      color: var(--dark);
      font-weight: 500;
      transition: var(--transition);
      position: relative;
      padding: 0.5rem 0.8rem;
      border-radius: 8px;
      margin: 0 0.1rem;
    }
    .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
      color: var(--primary-blue);
      background: rgba(13, 110, 253, 0.08);
    }
    .navbar-nav .nav-link::after {
      content: ''; position: absolute; width: 0; height: 2px;
      bottom: 0; left: 50%; background-color: var(--newblue); transition: var(--transition);
    }
    .navbar-nav .nav-link:hover::after { width: 70%; left: 15%; }
    
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
    .dropdown-item { color: var(--dark); padding: 0.6rem 1.5rem; transition: var(--transition); }
    .dropdown-item:hover { background-color: var(--primary-blue); color: white; padding-left: 2rem; }
    .dropdown-submenu { position: relative; }
    .dropdown-submenu > .dropdown-menu { top: 0; left: 100%; margin-top: -0.8rem; }

    /* =========================
       🔘 Buttons
    ========================= */
    .btn {
      padding: 0.8rem 1.8rem;
      border-radius: 10px;
      font-weight: 600;
      transition: var(--transition);
      position: relative;
      overflow: hidden;
      z-index: 1;
    }
    .btn::before {
      content: ''; position: absolute; top: 0; left: 0; width: 0%; height: 100%;
      background: rgba(255, 255, 255, 0.1); transition: var(--transition); z-index: -1;
    }
    .btn:hover::before { width: 100%; }
    .btn-orange {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border: none; color: white;
    }
    .btn-orange:hover {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2));
      transform: translateY(-3px); color: white;
    }
    .btn-light {
      background: #f8f9fa; border: 1px solid #ddd; color: #333;
    }
    .btn-light:hover {
      background: #e2e6ea; transform: translateY(-3px);
    }

    /* =========================
       ⬇️ Footer
    ========================= */
    footer {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      color: white;
      padding: 80px 10% 40px;
      position: relative;
      overflow: hidden;
    }
    footer::before {
      content: ''; position: absolute; width: 100%; height: 100%; top: 0; left: 0;
      background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='50' cy='50' r='1' fill='%23FFFFFF' opacity='0.05'/%3E%3C/svg%3E");
      pointer-events: none;
    }
    footer h2 { color: white; font-weight: 700; }
    footer .links a {
      color: #fff; text-decoration: none; margin-right: 24px; position: relative;
      font-weight: 500; transition: var(--transition);
    }
    footer .links a::after {
      content: ''; position: absolute; width: 0; height: 2px;
      bottom: -4px; left: 0; background-color: var(--newblue2); transition: var(--transition);
    }
    footer .links a:hover { color: white; }
    footer .links a:hover::after { width: 100%; }
    footer .socials a {
      color: white; margin-right: 18px; font-size: 1.3rem;
      transition: var(--transition); display: inline-block;
    }
    footer .socials a:hover { color: var(--newblue2); transform: translateY(-3px); }
    footer .bottom {
      margin-top: 40px; font-size: 0.85rem; display: flex; flex-wrap: wrap;
      justify-content: center; gap: 24px;
    }
    footer .bottom a { color: #ccc; text-decoration: none; transition: var(--transition); }
    footer .bottom a:hover { color: var(--newblue2); }

    /* =======================================================
       🚀 ADVANCED LIBRARY STYLES
    ======================================================= */
    
    .tech-bg {
      background-color: #f8faff;
      background-image: 
        linear-gradient(rgba(23, 162, 220, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(23, 162, 220, 0.05) 1px, transparent 1px);
      background-size: 40px 40px;
      padding: 80px 5%;
      position: relative;
    }

    .tech-bg::after {
      content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 500px;
      background: radial-gradient(circle at 50% 0%, rgba(23, 162, 220, 0.1), transparent 70%);
      pointer-events: none;
    }

    /* Advanced Tab Navigation (Pills) */
    .lib-nav-pills {
      background: #fff;
      display: inline-flex;
      padding: 5px;
      border-radius: 50px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.05);
      margin-bottom: 50px;
      border: 1px solid rgba(0,0,0,0.05);
      position: relative;
      z-index: 2;
    }
    
    .lib-nav-pills .nav-link {
      color: #666;
      border-radius: 40px;
      padding: 10px 30px;
      font-weight: 600;
      transition: all 0.3s ease;
      background: transparent;
      border: none;
    }

    .lib-nav-pills .nav-link.active {
      background: linear-gradient(90deg, var(--newblue2), var(--newblue));
      color: #fff;
      box-shadow: 0 4px 15px rgba(23, 162, 220, 0.3);
    }

    /* Advanced Glassmorphism Cards */
    .adv-card {
      background: #fff;
      border-radius: 20px;
      border: 1px solid #eef2f6;
      overflow: hidden;
      height: 100%;
      position: relative;
      transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      box-shadow: 0 10px 30px rgba(0,0,0,0.03);
      display: flex;
      flex-direction: column;
    }

    .adv-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 40px rgba(23, 162, 220, 0.15);
      border-color: rgba(23, 162, 220, 0.3);
    }

    .adv-card-body {
      padding: 40px 30px;
      text-align: center;
      flex-grow: 1;
      position: relative;
      z-index: 1;
    }

    .adv-icon {
      width: 70px; height: 70px;
      background: rgba(23, 162, 220, 0.05);
      color: var(--newblue);
      border-radius: 50%;
      display: flex;
      align-items: center; justify-content: center;
      font-size: 1.8rem;
      margin: 0 auto 25px;
      transition: var(--transition);
    }

    .adv-card:hover .adv-icon {
      background: var(--newblue);
      color: #fff;
      transform: scale(1.1) rotate(10deg);
    }

    .adv-card h5 {
      color: var(--newblue2);
      font-weight: 700;
      margin-bottom: 10px;
    }

    .adv-card p {
      color: #777;
      font-size: 0.95rem;
    }

    .adv-card-footer {
      padding: 20px;
      border-top: 1px solid #f0f0f0;
      background: #fafbfc;
    }

    /* Library specific buttons */
    .btn-lib-action {
      width: 100%;
      padding: 10px;
      border-radius: 12px;
      border: 2px solid transparent;
      font-weight: 600;
      background: rgba(23, 162, 220, 0.1);
      color: var(--newblue2);
      transition: var(--transition);
    }

    .btn-lib-action:hover {
      background: var(--newblue);
      color: #fff;
      box-shadow: 0 5px 15px rgba(23, 162, 220, 0.25);
    }
    
    /* UPDATED: Video button now uses newblue */
    .btn-lib-video {
      background: rgba(23, 162, 220, 0.1); /* newblue with opacity */
      color: var(--newblue);
      width: 100%;
      padding: 10px;
      border-radius: 12px;
      border: 2px solid transparent;
      font-weight: 600;
      transition: var(--transition);
    }
    
    .btn-lib-video:hover {
      background: var(--newblue);
      color: #fff;
      box-shadow: 0 5px 15px rgba(23, 162, 220, 0.25);
    }

    /* Modal Form Styling */
    .adv-modal-header {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      color: white;
    }
    .adv-form-control {
      background: #f9f9f9;
      border: 1px solid #eee;
      padding: 12px;
      border-radius: 8px;
    }
    .adv-form-control:focus {
      background: #fff;
      border-color: var(--newblue);
      box-shadow: 0 0 0 3px rgba(23, 162, 220, 0.1);
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .fade-in-up { animation: fadeIn 0.8s ease forwards; opacity: 0; }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.3s; }

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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
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
          <li class="nav-item"><a class="nav-link active" href="<?= base_url('index/library') ?>">Library</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <section class="tech-bg">
    <div class="container">
      
      <div class="text-center mb-5 fade-in-up">
        <h1 style="color: var(--newblue2); font-weight: 800; font-size: 3rem;">Resource Library</h1>
        <p class="text-muted" style="max-width: 700px; margin: 0 auto;">Access technical documentation, case studies, and video tutorials designed to empower your engineering solutions.</p>
      </div>

      <div class="text-center mb-5 fade-in-up delay-1">
        <div class="lib-nav-pills" role="tablist">
          <button class="nav-link active" id="tab-case" data-bs-toggle="pill" data-bs-target="#content-case" type="button" role="tab">Case Studies</button>
          <button class="nav-link" id="tab-brochure" data-bs-toggle="pill" data-bs-target="#content-brochure" type="button" role="tab">Brochures</button>
          <button class="nav-link" id="tab-video" data-bs-toggle="pill" data-bs-target="#content-video" type="button" role="tab">Videos</button>
        </div>
      </div>

      <div class="tab-content fade-in-up delay-2">
        
        <div class="tab-pane fade show active" id="content-case" role="tabpanel">
          <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon"><i class="fas fa-chart-line"></i></div>
                  <h5>Case Study 1</h5>
                  <p>Efficiency improvement analysis and results.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="case-study-1.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon"><i class="fas fa-industry"></i></div>
                  <h5>Case Study 2</h5>
                  <p>Implementation in heavy industry sectors.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="case-study-2.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="content-brochure" role="tabpanel">
          <div class="row g-4 justify-content-center">
            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon"><i class="fas fa-building"></i></div>
                  <h5>Company Profile</h5>
                  <p>Learn about Line Seiki's history and mission.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="company-profile.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon"><i class="fas fa-cogs"></i></div>
                  <h5>Products & Services</h5>
                  <p>Comprehensive catalog of our offerings.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="products-services.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="content-video" role="tabpanel">
          <div class="row g-4 justify-content-center">

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-play-circle"></i>
                  </div>
                  <h5>Electronic Counters</h5>
                  <p>Setup guide for G20 Series electronic counters.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-video"></i>
                  </div>
                  <h5>Mechanical Series</h5>
                  <p>Installation tutorial for heavy-duty counters.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-tachometer-alt"></i>
                  </div>
                  <h5>Tachometer Usage</h5>
                  <p>How to use handheld tachometers accurately.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-wifi"></i>
                  </div>
                  <h5>IoT Solution Setup</h5>
                  <p>Connecting your counters to the IoT network.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-ruler-combined"></i>
                  </div>
                  <h5>Length Measuring</h5>
                  <p>Calibration guide for length measuring counters.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-tools"></i>
                  </div>
                  <h5>Maintenance Tips</h5>
                  <p>Routine maintenance for long-lasting devices.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-laptop-code"></i>
                  </div>
                  <h5>Software Integration</h5>
                  <p>Using the data logging software features.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-industry"></i>
                  </div>
                  <h5>Factory Automation</h5>
                  <p>Case study: Improving assembly line speed.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-thermometer-half"></i>
                  </div>
                  <h5>Thermometers</h5>
                  <p>Precision temperature measurement demo.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4">
              <div class="adv-card">
                <div class="adv-card-body">
                  <div class="adv-icon" style="color: var(--newblue); background: rgba(23, 162, 220, 0.05);">
                    <i class="fas fa-check-circle"></i>
                  </div>
                  <h5>Quality Control</h5>
                  <p>Ensuring accuracy in high-speed counting.</p>
                </div>
                <div class="adv-card-footer">
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>
    </div>
  </section>

  <div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
        <div class="modal-header adv-modal-header">
          <h5 class="modal-title">Fill out the form to download</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" id="fileToDownload">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control adv-form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control adv-form-control" required>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <label class="form-label">Company</label>
              <input type="text" class="form-control adv-form-control" required>
            </div>
            <div class="col-6 mb-3">
              <label class="form-label">Position</label>
              <input type="text" class="form-control adv-form-control" required>
            </div>
          </div>
          <div class="d-grid mt-2">
            <button type="submit" class="btn btn-success" style="background: var(--newblue2); border: none; padding: 12px;">Submit & Download</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <form class="modal-content" style="border-radius: 20px; border: none; overflow: hidden;">
        <div class="modal-header adv-modal-header">
          <h5 class="modal-title">Fill out the form to watch</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" id="videoUrlToWatch">
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control adv-form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" class="form-control adv-form-control" required>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
               <label class="form-label">Company</label>
               <input type="text" class="form-control adv-form-control" required>
            </div>
            <div class="col-6 mb-3">
               <label class="form-label">Position</label>
               <input type="text" class="form-control adv-form-control" required>
            </div>
          </div>
          <div class="d-grid mt-2">
            <button type="submit" class="btn btn-success" style="background: var(--newblue2); border: none; padding: 12px;">Submit & Watch</button>
          </div>
        </div>
      </form>
    </div>
  </div>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Navbar scroll effect
      const navbar = document.querySelector('.navbar');
      window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
          navbar.classList.add('scrolled');
        } else {
          navbar.classList.remove('scrolled');
        }
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
          this.closest('.dropdown-menu').querySelectorAll('.show').forEach(function(openMenu){
            if(openMenu !== submenu){
              openMenu.classList.remove('show');
            }
          });
        });
      });

      document.addEventListener('click', function(){
        document.querySelectorAll('.dropdown-menu .show').forEach(function(openMenu){
          openMenu.classList.remove('show');
        });
      });
      
      // Download Modal Logic
      const downloadModal = document.getElementById("downloadModal");
      if(downloadModal) {
        downloadModal.addEventListener("show.bs.modal", function (event) {
          const button = event.relatedTarget;
          const file = button.getAttribute("data-file");
          document.getElementById("fileToDownload").value = file;
        });

        document.querySelector("#downloadModal form").addEventListener("submit", function(e){
          e.preventDefault();
          const file = document.getElementById("fileToDownload").value;
          // Simulate download
          window.location.href = "downloads/" + file; 
          bootstrap.Modal.getInstance(downloadModal).hide();
          this.reset();
        });
      }

      // Video Modal Logic
      const videoModal = document.getElementById("videoModal");
      if(videoModal) {
        videoModal.addEventListener("show.bs.modal", function (event) {
          const button = event.relatedTarget;
          const url = button.getAttribute("data-video-url");
          document.getElementById("videoUrlToWatch").value = url;
        });

        document.querySelector("#videoModal form").addEventListener("submit", function(e){
          e.preventDefault();
          const url = document.getElementById("videoUrlToWatch").value;
          window.open(url, '_blank');
          bootstrap.Modal.getInstance(videoModal).hide();
          this.reset();
        });
      }
    });
  </script>
</body>
</html>