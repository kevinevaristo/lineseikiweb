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
      --primary-blue: #0d6efd;
      --primary-blue-dark: #0a58ca;
      --light-blue: #e7f1ff;
      --light-orange: #fff3e8;
      --light-gray: #f8f9fa;
      --dark: #212529;
      --newblue: #17A2DC;
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

    /* Library specific buttons */
    .btn-lib-action {
      width: 100%;
      padding: 8px 12px;
      border-radius: 8px;
      border: 2px solid transparent;
      font-weight: 600;
      background: rgba(23, 162, 220, 0.1);
      color: var(--newblue2);
      transition: var(--transition);
      font-size: 0.9rem;
    }

    .btn-lib-action:hover {
      background: var(--newblue);
      color: #fff;
      box-shadow: 0 5px 15px rgba(23, 162, 220, 0.25);
    }
    
    .btn-lib-video {
      background: rgba(23, 162, 220, 0.1); 
      color: var(--newblue);
      width: 100%;
      padding: 8px 12px;
      border-radius: 8px;
      border: 2px solid transparent;
      font-weight: 600;
      transition: var(--transition);
      font-size: 0.9rem;
    }
    
    .btn-lib-video:hover {
      background: var(--newblue);
      color: #fff;
      box-shadow: 0 5px 15px rgba(23, 162, 220, 0.25);
    }

    /* =======================================================
       ✨ STYLES FOR UNIFIED LAYOUT
    ======================================================= */
    
    /* Search Bar Styling */
    .vid-search-wrapper {
      position: relative;
    }
    .vid-search-input {
      border-radius: 50px;
      padding: 12px 25px 12px 50px;
      border: 1px solid #eee;
      box-shadow: 0 2px 10px rgba(0,0,0,0.02);
    }
    .vid-search-input:focus {
      border-color: var(--newblue);
      box-shadow: 0 0 0 3px rgba(23, 162, 220, 0.1);
    }
    .vid-search-icon {
      position: absolute;
      left: 20px;
      top: 50%;
      transform: translateY(-50%);
      color: #aaa;
    }

    /* Filter Pills */
    .vid-filter-btn {
      border: none;
      background: #f0f2f5;
      color: #666;
      border-radius: 20px;
      padding: 6px 16px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: var(--transition);
      margin-right: 5px;
      margin-bottom: 5px;
    }
    /* Active state uses blue background */
    .vid-filter-btn.active {
      background: var(--newblue2);
      color: #fff;
    }
    .vid-filter-btn:hover {
      background: var(--newblue2);
      color: #fff;
    }

    /* Featured Video Card (FIXED HEIGHT) */
    .featured-vid-card {
      background: linear-gradient(145deg, var(--newblue2), #0a3d6b);
      border-radius: 20px;
      color: white;
      height: 340px; /* Fixed height */
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 30px;
      position: relative;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(15, 70, 123, 0.2);
    }
    .featured-vid-card::before {
      content: ''; position: absolute; top:0; right:0; width: 100%; height: 100%;
      background: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23FFFFFF' fill-opacity='0.05' d='M44.7,-76.4C58.9,-69.2,71.8,-59.1,81.6,-46.6C91.4,-34.1,98.1,-19.2,95.8,-4.9C93.5,9.3,82.2,22.9,71,34.3C59.8,45.7,48.7,54.9,36.6,63.1C24.5,71.3,11.4,78.5,-0.8,79.9C-13,81.3,-24.8,76.9,-36.2,70.1C-47.6,63.3,-58.6,54.1,-67.2,42.8C-75.8,31.5,-82,18.1,-83.4,4.2C-84.9,-9.7,-81.6,-24.1,-73.4,-36.4C-65.2,-48.7,-52.1,-58.9,-38.6,-66.4C-25.1,-73.9,-11.2,-78.7,1.9,-82C15,-85.3,29.9,-87.1,44.7,-76.4Z' transform='translate(100 100)' /%3E%3C/svg%3E") no-repeat center center;
      background-size: cover;
      opacity: 0.5;
    }
    .featured-play-btn {
      font-size: 3.5rem;
      color: white;
      margin-bottom: 15px;
      transition: transform 0.3s;
      cursor: pointer;
      text-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }
    .featured-play-btn:hover {
      transform: scale(1.1);
      color: var(--newblue);
    }
    
    /* Compact Grid Card (Used for All Resources) */
    .compact-card {
      background: #fff;
      border-radius: 15px;
      border: 1px solid #f0f0f0;
      overflow: hidden;
      transition: var(--transition);
      height: 100%;
      display: flex;
      flex-direction: column;
    }
    .compact-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.08);
      border-color: rgba(23, 162, 220, 0.3);
    }
    .compact-thumb {
      height: 120px;
      background: #f8f9fa;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--newblue);
      font-size: 2rem;
      position: relative;
      flex-shrink: 0;
    }
    
    /* Tag style for duration or type */
    .compact-thumb::after {
      content: attr(data-tag);
      position: absolute;
      bottom: 10px; right: 10px;
      background: rgba(0,0,0,0.7);
      color: white;
      font-size: 0.75rem;
      padding: 2px 8px;
      border-radius: 4px;
      text-transform: uppercase;
      font-weight: 600;
    }

    .compact-body {
      padding: 15px;
      flex-grow: 1;
      display: flex;
      flex-direction: column;
    }
    .compact-body h6 {
      font-weight: 700;
      color: var(--newblue2);
      margin-bottom: 5px;
      font-size: 1rem;
    }
    .compact-body p {
      font-size: 0.8rem;
      color: #666;
      margin-bottom: 15px;
      line-height: 1.4;
      flex-grow: 1;
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
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">Product and Services</a>
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
        <p class="text-muted" style="max-width: 700px; margin: 0 auto;">Access technical documentation, case studies, and video tutorials.</p>
      </div>

      <div class="row g-4 fade-in-up delay-1">
        
        <div class="col-lg-5">
          <div class="featured-vid-card mb-4">
             <div class="position-relative z-2">
               <h6 class="text-uppercase mb-2" style="opacity: 0.8; letter-spacing: 1px; font-size: 0.85rem;">Featured Video</h6>
               <h2 class="mb-3" style="font-weight: 800; line-height: 1.2; font-size: 1.8rem;">Getting Started with G20 Series</h2>
               <div class="featured-play-btn" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                 <i class="fas fa-play-circle"></i>
               </div>
               <button class="btn btn-primary rounded-pill px-4 mt-2" style="background: var(--newblue); border:none;" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                 <i class="fas fa-play me-2"></i> Watch Now
               </button>
             </div>
          </div>

          <h5 class="mb-3 text-secondary" style="font-weight:700; border-left: 4px solid var(--newblue); padding-left:12px;">Up Next</h5>
          <div class="d-flex flex-column gap-3">
            
            <div class="compact-card" style="flex-direction: row; height: auto;">
              <div class="compact-thumb" data-tag="4:15" style="width: 120px; height: auto; min-height: 90px;">
                <i class="fas fa-sliders-h" style="font-size: 1.5rem;"></i>
              </div>
              <div class="compact-body d-flex flex-column justify-content-center p-3">
                <h6 class="mb-1" style="font-size: 0.95rem;">Advanced Settings</h6>
                <p class="small text-muted mb-2" style="font-size: 0.8rem;">Deep dive into configuration.</p>
                <button class="btn btn-sm btn-lib-video py-1 px-2" style="width: fit-content;" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                  <i class="fas fa-play me-1"></i> Watch
                </button>
              </div>
            </div>

            <div class="compact-card" style="flex-direction: row; height: auto;">
              <div class="compact-thumb" data-tag="6:30" style="width: 120px; height: auto; min-height: 90px;">
                <i class="fas fa-microchip" style="font-size: 1.5rem;"></i>
              </div>
              <div class="compact-body d-flex flex-column justify-content-center p-3">
                <h6 class="mb-1" style="font-size: 0.95rem;">Sensor Integration</h6>
                <p class="small text-muted mb-2" style="font-size: 0.8rem;">Connecting external sensors.</p>
                <button class="btn btn-sm btn-lib-video py-1 px-2" style="width: fit-content;" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                  <i class="fas fa-play me-1"></i> Watch
                </button>
              </div>
            </div>

            <div class="compact-card" style="flex-direction: row; height: auto;">
              <div class="compact-thumb" data-tag="3:45" style="width: 120px; height: auto; min-height: 90px;">
                <i class="fas fa-database" style="font-size: 1.5rem;"></i>
              </div>
              <div class="compact-body d-flex flex-column justify-content-center p-3">
                <h6 class="mb-1" style="font-size: 0.95rem;">Data Logging</h6>
                <p class="small text-muted mb-2" style="font-size: 0.8rem;">Exporting counts to PC.</p>
                <button class="btn btn-sm btn-lib-video py-1 px-2" style="width: fit-content;" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                  <i class="fas fa-play me-1"></i> Watch
                </button>
              </div>
            </div>

          </div>
        </div>

        <div class="col-lg-7">
          
          <div class="mb-4">
            <div class="vid-search-wrapper mb-3">
              <i class="fas fa-search vid-search-icon"></i>
              <input type="text" class="form-control vid-search-input" id="resourceSearch" placeholder="Search resources...">
            </div>
            <div class="d-flex flex-wrap" id="filter-buttons">
              <button class="vid-filter-btn active" data-filter="video">Videos</button>
              <button class="vid-filter-btn" data-filter="case">Case Studies</button>
              <button class="vid-filter-btn" data-filter="brochure">Brochures</button>
            </div>
          </div>

          <div class="row g-3" id="resource-grid">
            
            <div class="col-md-6 mix-item" data-category="video">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="5:32">
                  <i class="fas fa-video"></i>
                </div>
                <div class="compact-body">
                  <h6>Electronic Counters Setup</h6>
                  <p>Setup guide for G20 Series electronic counters.</p>
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="video">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="5:38">
                  <i class="fas fa-cogs"></i>
                </div>
                <div class="compact-body">
                  <h6>Mechanical Installation</h6>
                  <p>Installation tutorial for heavy-duty counters.</p>
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="video">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="5:32">
                  <i class="fas fa-tachometer-alt"></i>
                </div>
                <div class="compact-body">
                  <h6>Tachometer Usage Guide</h6>
                  <p>How to use handheld tachometers accurately.</p>
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="case">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="PDF">
                  <i class="fas fa-chart-line"></i>
                </div>
                <div class="compact-body">
                  <h6>Case Study 1</h6>
                  <p>Efficiency improvement analysis and results.</p>
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="case-study-1.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="case">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="PDF">
                  <i class="fas fa-industry"></i>
                </div>
                <div class="compact-body">
                  <h6>Case Study 2</h6>
                  <p>Implementation in heavy industry sectors.</p>
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="case-study-2.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="brochure">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="Brochure">
                  <i class="fas fa-building"></i>
                </div>
                <div class="compact-body">
                  <h6>Company Profile</h6>
                  <p>Learn about Line Seiki's history and mission.</p>
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="company-profile.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="brochure">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="Catalog">
                  <i class="fas fa-book-open"></i>
                </div>
                <div class="compact-body">
                  <h6>Products & Services</h6>
                  <p>Comprehensive catalog of our offerings.</p>
                  <button class="btn btn-lib-action" data-bs-toggle="modal" data-bs-target="#downloadModal" data-file="products-services.pdf">
                    <i class="fas fa-download me-2"></i> Download PDF
                  </button>
                </div>
              </div>
            </div>
            
            <div class="col-md-6 mix-item" data-category="video">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="5:30">
                  <i class="fas fa-tools"></i>
                </div>
                <div class="compact-body">
                  <h6>Maintenance Tips</h6>
                  <p>Routine maintenance for long-lasting devices.</p>
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="video">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="4:45">
                  <i class="fas fa-broadcast-tower"></i>
                </div>
                <div class="compact-body">
                  <h6>Remote Monitoring</h6>
                  <p>Monitoring production lines from anywhere.</p>
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="video">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="6:10">
                  <i class="fas fa-bolt"></i>
                </div>
                <div class="compact-body">
                  <h6>Power Efficiency</h6>
                  <p>Optimizing power consumption in counters.</p>
                  <button class="btn btn-lib-video" data-bs-toggle="modal" data-bs-target="#videoModal" data-video-url="https://www.youtube.com/@lineseikichannel7777">
                    <i class="fas fa-play me-2"></i> Watch Now
                  </button>
                </div>
              </div>
            </div>

            <div class="col-md-6 mix-item" data-category="video">
              <div class="compact-card">
                <div class="compact-thumb" data-tag="3:20">
                  <i class="fas fa-sync-alt"></i>
                </div>
                <div class="compact-body">
                  <h6>Firmware Update</h6>
                  <p>How to safely update your device firmware.</p>
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
      
      // === FILTERING LOGIC (Connects Video, Cases, Brochures) ===
      const filterBtns = document.querySelectorAll('.vid-filter-btn');
      const gridItems = document.querySelectorAll('.mix-item');

      filterBtns.forEach(btn => {
        btn.addEventListener('click', () => {
          // Remove active class from all buttons
          filterBtns.forEach(b => b.classList.remove('active'));
          // Add active class to clicked button
          btn.classList.add('active');

          const filterValue = btn.getAttribute('data-filter');

          gridItems.forEach(item => {
            if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
              item.classList.remove('d-none');
              // Add a small fade animation class if desired
              item.classList.add('fade-in-up');
            } else {
              item.classList.add('d-none');
            }
          });
        });
      });

      // === INITIALIZE FILTER (Show "video" by default) ===
      const activeBtn = document.querySelector('.vid-filter-btn.active');
      if(activeBtn) {
        // Trigger the click logic to hide non-video items on load
        const filterValue = activeBtn.getAttribute('data-filter');
        gridItems.forEach(item => {
            if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
              item.classList.remove('d-none');
            } else {
              item.classList.add('d-none');
            }
        });
      }

      // === SEARCH LOGIC ===
      const searchInput = document.getElementById('resourceSearch');
      if(searchInput){
        searchInput.addEventListener('keyup', function(){
          const value = this.value.toLowerCase();
          gridItems.forEach(item => {
            const text = item.textContent.toLowerCase();
            if(text.indexOf(value) > -1){
              item.classList.remove('d-none');
            } else {
              item.classList.add('d-none');
            }
          });
        });
      }
      
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