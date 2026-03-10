<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library · Line Seiki Asia Pacific</title>

  <!-- Bootstrap 5 & Font Awesome -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">
  <!-- Google Fonts (Inter) – clean and modern -->
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter-opsz.css'); ?>" rel="stylesheet">

  <style>
    /* =========================
       🎨 ORIGINAL NAVBAR STYLES (from first code block, unchanged)
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

    /* Base styles (only those needed for navbar, rest for library are separate) */
    html { scroll-behavior: smooth; }
    body {
      background-color: #fff;
      color: #333;
      font-family: 'Inter', sans-serif;
      line-height: 1.6;
      overflow-x: hidden;
      padding-top: 90px; /* space for fixed navbar */
    }

    /* =========================
       🟦 ORIGINAL NAVBAR (exactly as first code)
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
    
    .navbar-nav > li:nth-child(3) > .dropdown-toggle::after {
      display: none !important;
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

    /* Animation */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* =========================
       🎨 YOUTUBE-STYLE LIBRARY (navy & white) – scoped, no effect on navbar/footer
    ========================= */
    :root {
      --navy: #0a2647;        /* deep navy */
      --navy-light: #1e3a6f;  /* medium navy */
      --navy-soft: #eef3fc;   /* very light navy tint */
      --white: #ffffff;
      --gray-border: #e2e8f0;
      --text-muted: #4b5565;
    }

    /* Library section wrapper – all new styles apply only inside .library-yt */
    .library-yt .tech-bg {
      background: var(--white);
      padding: 32px 5% 60px;
    }

    .library-yt .page-header h1 {
      font-weight: 700;
      font-size: 2.5rem;
      color: var(--navy);
      letter-spacing: -0.02em;
    }
    .library-yt .page-header p {
      color: var(--text-muted);
      max-width: 600px;
      margin: 0 auto;
      font-size: 1.1rem;
    }

    /* SEARCH BAR */
    .library-yt .yt-search-wrapper {
      display: flex;
      align-items: center;
      background: var(--white);
      border: 1px solid var(--gray-border);
      border-radius: 40px;
      padding: 0 16px;
      max-width: 600px;
      margin: 28px auto 24px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .library-yt .yt-search-wrapper i {
      color: var(--navy-light);
      font-size: 1.1rem;
    }
    .library-yt .yt-search-input {
      background: transparent;
      border: none;
      padding: 12px 12px 12px 16px;
      color: var(--navy);
      font-size: 1rem;
      width: 100%;
    }
    .library-yt .yt-search-input:focus { outline: none; }
    .library-yt .yt-search-input::placeholder { color: #9aa9bb; }

    /* FILTER PILLS */
    .library-yt .filter-pills {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      justify-content: center;
      margin-bottom: 32px;
    }
    .library-yt .pill-btn {
      background: var(--navy-soft);
      border: 1px solid transparent;
      color: var(--navy);
      border-radius: 32px;
      padding: 8px 20px;
      font-size: 0.9rem;
      font-weight: 500;
      transition: 0.2s;
      cursor: pointer;
    }
    .library-yt .pill-btn.active {
      background: var(--navy);
      color: white;
      border-color: var(--navy);
    }
    .library-yt .pill-btn:hover {
      background: #dbe6f5;
    }

    /* FEATURED VIDEO CARD */
    .library-yt .featured-vid-card {
      background: var(--white);
      border-radius: 24px;
      overflow: hidden;
      display: flex;
      flex-direction: row;
      border: 1px solid var(--gray-border);
      box-shadow: 0 12px 25px -8px rgba(10,38,71,0.12);
      margin-bottom: 40px;
    }
    .library-yt .featured-thumb {
      width: 45%;
      background-size: cover;
      background-position: center;
      position: relative;
      min-height: 240px;
      background-color: var(--navy-soft);
    }
    .library-yt .featured-thumb .play-badge {
      position: absolute;
      bottom: 16px; left: 16px;
      background: rgba(10,38,71,0.9);
      color: white;
      padding: 6px 16px;
      border-radius: 40px;
      font-size: 0.85rem;
      font-weight: 600;
      backdrop-filter: blur(4px);
    }
    .library-yt .featured-content {
      width: 55%;
      padding: 28px 32px;
      display: flex;
      flex-direction: column;
    }
    .library-yt .featured-label {
      color: var(--navy-light);
      font-weight: 600;
      font-size: 0.8rem;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
    .library-yt .featured-content h2 {
      font-size: 1.9rem;
      font-weight: 700;
      color: var(--navy);
      margin: 8px 0 12px;
      line-height: 1.2;
    }
    .library-yt .featured-content p {
      color: var(--text-muted);
      font-size: 0.98rem;
      margin-bottom: 24px;
    }
    .library-yt .featured-actions {
      display: flex;
      gap: 16px;
      margin-top: auto;
    }
    .library-yt .featured-actions .btn {
      border-radius: 40px;
      padding: 10px 28px;
      font-weight: 600;
      border: none;
    }
    .library-yt .featured-actions .btn-primary {
      background: var(--navy);
      color: white;
    }
    .library-yt .featured-actions .btn-outline {
      background: transparent;
      color: var(--navy);
      border: 1.5px solid var(--gray-border);
    }
    .library-yt .featured-actions .btn-outline:hover {
      background: var(--navy-soft);
    }

    /* VIDEO GRID */
    .library-yt .video-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
      gap: 24px 18px;
      margin-top: 20px;
    }
    .library-yt .video-card {
      background: var(--white);
      border-radius: 18px;
      transition: 0.15s;
      cursor: pointer;
      border: 1px solid var(--gray-border);
      padding: 10px 10px 16px 10px;
      box-shadow: 0 4px 12px rgba(10,38,71,0.02);
    }
    .library-yt .video-card:hover {
      border-color: var(--navy-light);
      box-shadow: 0 16px 24px -10px rgba(10,38,71,0.15);
    }
    .library-yt .video-thumb {
      position: relative;
      width: 100%;
      aspect-ratio: 16 / 9;
      background: #e2eaf5;
      border-radius: 14px;
      overflow: hidden;
      margin-bottom: 12px;
    }
    .library-yt .video-thumb img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .library-yt .thumb-duration {
      position: absolute;
      bottom: 8px; right: 8px;
      background: rgba(10,38,71,0.85);
      color: white;
      font-size: 0.75rem;
      padding: 3px 8px;
      border-radius: 5px;
      font-weight: 600;
    }
    .library-yt .video-info {
      display: flex;
      gap: 12px;
      padding: 0 6px;
    }
    .library-yt .video-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--navy-soft);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--navy);
      flex-shrink: 0;
      font-size: 1.1rem;
    }
    .library-yt .video-details h6 {
      font-weight: 600;
      color: var(--navy);
      margin-bottom: 4px;
      font-size: 1rem;
      line-height: 1.3;
    }
    .library-yt .video-meta {
      color: var(--text-muted);
      font-size: 0.8rem;
    }
    /* PDF card adjustment */
    .library-yt .pdf-card .video-thumb {
      background: #f0f5fe;
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--navy);
      font-size: 3rem;
    }
    .library-yt .pdf-badge {
      position: absolute;
      top: 8px; left: 8px;
      background: var(--navy);
      color: white;
      padding: 2px 10px;
      border-radius: 30px;
      font-size: 0.7rem;
      font-weight: 700;
    }

    /* WEBINAR CARD */
    .library-yt .webinar-card {
      background: var(--white);
      border-radius: 22px;
      border: 1px solid var(--gray-border);
      display: flex;
      margin-bottom: 20px;
      overflow: hidden;
      transition: 0.2s;
    }
    .library-yt .webinar-card:hover {
      border-color: var(--navy);
      box-shadow: 0 12px 22px -10px rgba(10,38,71,0.2);
    }
    .library-yt .webinar-thumb {
      width: 260px;
      background-size: cover;
      background-position: center;
      position: relative;
      background-color: #dbe6f5;
    }
    .library-yt .webinar-thumb .badge {
      position: absolute;
      top: 16px; right: 16px;
      background: var(--navy);
      color: white;
      font-weight: 600;
      padding: 4px 16px;
      border-radius: 30px;
      font-size: 0.8rem;
    }
    .library-yt .webinar-content {
      padding: 24px;
      flex: 1;
    }
    .library-yt .webinar-content h4 {
      color: var(--navy);
      font-weight: 700;
    }
    .library-yt .webinar-content p {
      color: var(--text-muted);
    }
    .library-yt .webinar-btn {
      background: var(--navy-soft);
      color: var(--navy);
      border: none;
      border-radius: 30px;
      padding: 8px 24px;
      font-weight: 600;
      margin-top: 10px;
    }
    .library-yt .webinar-btn:hover {
      background: #cedef2;
    }

    /* WEBINAR INDICATOR */
    .library-yt .webinar-indicator {
      background: var(--navy-soft);
      border-radius: 40px;
      padding: 10px 24px;
      display: inline-flex;
      align-items: center;
      gap: 16px;
      border: 1px solid var(--gray-border);
      margin: 12px 0;
      color: var(--navy);
    }
    .library-yt .btn-clear {
      background: #cbd9ed;
      border: none;
      color: var(--navy);
      border-radius: 50%;
      width: 28px; height: 28px;
    }

    /* MODALS (navy & white) */
    .modal-content {
      background: var(--white);
      border: 1px solid var(--gray-border);
      border-radius: 28px;
    }
    .modal-header {
      background: #f5f9ff;
      border-bottom: 1px solid var(--gray-border);
      color: var(--navy);
    }
    .adv-form-control {
      background: #fbfdff;
      border: 1px solid var(--gray-border);
      color: var(--navy);
      border-radius: 12px;
      padding: 12px;
    }
    .adv-form-control:focus {
      background: white;
      border-color: var(--navy);
      box-shadow: 0 0 0 3px rgba(10,38,71,0.15);
    }

    /* UTILITIES */
    .library-yt .hidden-section { display: none; }
    .library-yt .visible-section { display: block; }
    .library-yt .fade-in-up {
      animation: fadeInUp 0.5s ease forwards;
    }
    @keyframes fadeInUp {
      0% { opacity: 0; transform: translateY(12px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 700px) {
      .library-yt .featured-vid-card { flex-direction: column; }
      .library-yt .featured-thumb { width: 100%; min-height: 200px; }
      .library-yt .featured-content { width: 100%; }
      .library-yt .webinar-card { flex-direction: column; }
      .library-yt .webinar-thumb { width: 100%; height: 200px; }
    }

    /* =========================
       ⬇️ ORIGINAL FOOTER (unchanged)
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

    /* Small fix for body padding (already set) */
  </style>
</head>
<body>

<!-- ORIGINAL NAVBAR (exactly as first code, with original classes) -->
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

<!-- MAIN SECTION – YOUTUBE STYLE LIBRARY (navy/white) with library-yt wrapper -->
<section class="library-yt">
  <div class="tech-bg">
    <div class="container-fluid px-lg-4">

      <!-- HEADER -->
      <div class="page-header text-center fade-in-up">
        <h1><?= isset($main_header['title']) ? htmlspecialchars($main_header['title']) : 'Resource Library' ?></h1>
        <p><?= isset($main_header['content']) ? htmlspecialchars($main_header['content']) : 'Technical docs, case studies, and video tutorials' ?></p>
      </div>

      <!-- SEARCH + FILTER (youtube style) -->
      <div class="yt-search-wrapper">
        <i class="fas fa-search"></i>
        <input type="text" class="yt-search-input" id="resourceSearch" placeholder="Search resources...">
      </div>
      <div class="filter-pills" id="filter-buttons">
        <span class="pill-btn active" data-filter="all">All</span>
        <span class="pill-btn" data-filter="video">Videos</span>
        <span class="pill-btn" data-filter="brochure">PDFs</span>
        <span class="pill-btn" id="webinarsFilterBtn" data-filter="webinars"><i class="fas fa-video me-1"></i> Webinars</span>
      </div>

      <!-- ACTIVE WEBINAR INDICATOR -->
      <div id="activeWebinarIndicator" class="webinar-indicator d-none">
        <i class="fas fa-tag" style="color:var(--navy);"></i> <span>Showing: <span id="selectedWebinarTitle"></span></span>
        <button class="btn-clear" id="clearWebinarFilter"><i class="fas fa-times"></i></button>
      </div>

      <!-- WEBINARS SECTION (hidden by default) -->
      <div id="webinarsSection" class="hidden-section my-4">
        <h4 class="fw-bold mb-3" style="color:var(--navy);"><i class="fas fa-video me-2"></i>Available webinars</h4>
        <div class="webinars-list">
          <?php if(isset($webinars) && !empty($webinars)): ?>
            <?php foreach($webinars as $webinar): ?>
            <div class="webinar-card" onclick="filterByWebinar(<?= $webinar['id'] ?>, '<?= htmlspecialchars($webinar['webinar_title']) ?>')">
              <div class="webinar-thumb" style="background-image: url('<?= base_url('assets_system/images/'.$webinar['main_image']) ?>')">
                <span class="badge">WEBINAR</span>
              </div>
              <div class="webinar-content">
                <h4><?= htmlspecialchars($webinar['webinar_title']) ?></h4>
                <p><?= htmlspecialchars(substr($webinar['description_1'],0,120)) ?>...</p>
                <button class="webinar-btn"><i class="fas fa-eye me-2"></i>View resources</button>
              </div>
            </div>
            <?php endforeach; ?>
          <?php else: ?>
            <div class="text-center py-5"><i class="fas fa-video fa-3x text-muted"></i><p class="mt-2">No webinars</p></div>
          <?php endif; ?>
        </div>
      </div>

      <!-- FEATURED VIDEO (youtube hero) -->
      <?php if(isset($featured_video) && !empty($featured_video)): ?>
      <div class="featured-vid-card fade-in-up">
        <div class="featured-thumb" style="background-image: url('<?= base_url('assets_system/images/'.$featured_video['image']) ?>');">
          <span class="play-badge"><i class="fas fa-play me-1"></i> featured</span>
        </div>
        <div class="featured-content">
          <span class="featured-label">🔥 must watch</span>
          <h2><?= htmlspecialchars($featured_video['title']) ?></h2>
          <p><?= htmlspecialchars($featured_video['content']) ?></p>
          <div class="featured-actions">
            <a href="<?= htmlspecialchars($featured_video['video_url']) ?>" target="_blank" class="btn btn-primary"><i class="fas fa-play me-2"></i>Watch</a>
            <button class="btn btn-outline" disabled>Later</button>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <!-- RESOURCE GRID (VIDEO / PDF) -->
      <div id="resourcesSection">
        <div class="video-grid" id="resource-grid">

          <!-- VIDEO ITEMS (dynamic) -->
          <?php if(isset($video_items) && !empty($video_items)):
            foreach($video_items as $item):
              if($item['id'] <= 5) continue;
              $description = $item['content'];
              if (strpos($description, '-') !== false) {
                $parts = explode('-', $description);
                $description = trim($parts[1] ?? $description);
              }
              $webinar_id = $item['webinar_id'] ?? 0;
          ?>
          <div class="video-card mix-item" data-category="video" data-webinar-id="<?= $webinar_id ?>">
            <div class="video-thumb">
              <?php if(!empty($item['image'])): ?>
                <img src="<?= base_url('assets_system/images/'.$item['image']) ?>" alt="">
              <?php else: ?>
                <div style="width:100%;height:100%; background:var(--navy-soft); display:flex; align-items:center; justify-content:center; color:var(--navy);"><i class="fas fa-play-circle fa-3x"></i></div>
              <?php endif; ?>
              <span class="thumb-duration">Video</span>
            </div>
            <div class="video-info">
              <div class="video-avatar"><i class="fas fa-microchip"></i></div>
              <div class="video-details">
                <h6><?= htmlspecialchars($item['title']) ?></h6>
                <div class="video-meta"><?= htmlspecialchars(substr($description,0,50)) ?>…</div>
              </div>
            </div>
            <?php if (!empty($item['video_url'])): ?>
              <?php if ($item['is_gated'] == 1): ?>
                <button class="btn btn-sm mt-2 w-100" style="background:var(--navy-soft); color:var(--navy); border-radius:30px;"
                  data-bs-toggle="modal" data-bs-target="#videoModal"
                  data-video-url="<?= htmlspecialchars($item['video_url'], ENT_QUOTES) ?>"
                  data-video-title="<?= htmlspecialchars($item['title']) ?>">
                  <i class="fas fa-lock me-2"></i>Watch (gated)
                </button>
              <?php else: ?>
                <a href="<?= htmlspecialchars($item['video_url']) ?>" target="_blank" class="btn btn-sm mt-2 w-100" style="background:var(--navy); color:white; border-radius:30px;"><i class="fas fa-play me-2"></i>Watch</a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <?php endforeach; endif; ?>

          <!-- PDF ITEMS (dynamic) -->
          <?php if(isset($pdf_items) && !empty($pdf_items)):
            foreach($pdf_items as $item):
              $description = $item['content'];
              if (strpos($description, '-') !== false) {
                $parts = explode('-', $description);
                $description = trim($parts[1] ?? $description);
              }
              $pdf_filename = !empty($item['pdf_file']) ? $item['pdf_file'] : strtolower(str_replace(' ', '-', $item['title'])) . '.pdf';
              $webinar_id = $item['webinar_id'] ?? 0;
          ?>
          <div class="video-card pdf-card mix-item" data-category="brochure" data-webinar-id="<?= $webinar_id ?>">
            <div class="video-thumb">
              <i class="fas fa-file-pdf" style="font-size:3.5rem; color:var(--navy);"></i>
              <?php if($webinar_id > 0): ?><span class="pdf-badge"><i class="fas fa-video me-1"></i>webinar</span><?php endif; ?>
            </div>
            <div class="video-info">
              <div class="video-avatar"><i class="fas fa-download"></i></div>
              <div class="video-details">
                <h6><?= htmlspecialchars($item['title']) ?></h6>
                <div class="video-meta">PDF</div>
              </div>
            </div>
            <?php if (!empty($pdf_filename)): ?>
              <?php if ($item['is_gated'] == 1): ?>
                <button class="btn btn-sm mt-2 w-100" style="background:var(--navy-soft); color:var(--navy); border-radius:30px;"
                  data-bs-toggle="modal" data-bs-target="#downloadModal"
                  data-file="<?= htmlspecialchars($pdf_filename) ?>"
                  data-file-title="<?= htmlspecialchars($item['title']) ?>">
                  <i class="fas fa-lock me-2"></i>Download (gated)
                </button>
              <?php else: ?>
                <a href="<?= base_url('assets_system/documents/'.$pdf_filename) ?>" download class="btn btn-sm mt-2 w-100" style="background:var(--navy); color:white; border-radius:30px;"><i class="fas fa-download me-2"></i>Download</a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <?php endforeach; endif; ?>

        </div> <!-- end video-grid -->
      </div> <!-- end resourcesSection -->

    </div> <!-- container-fluid -->
  </div> <!-- tech-bg -->
</section>

<!-- DOWNLOAD MODAL (with contact) – navy style -->
<div class="modal fade" id="downloadModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-download me-2" style="color:var(--navy);"></i>Fill to download</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="fileToDownload">
        <input type="hidden" id="fileTitle">
        <div class="mb-3"><label class="form-label">Full name</label><input type="text" class="form-control adv-form-control" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control adv-form-control" required></div>
        <!-- CONTACT NUMBER FIELD -->
        <div class="mb-3"><label class="form-label">Contact number</label><input type="tel" class="form-control adv-form-control" required></div>
        <div class="row">
          <div class="col-6 mb-3"><label class="form-label">Company</label><input class="form-control adv-form-control" required></div>
          <div class="col-6 mb-3"><label class="form-label">Position</label><input class="form-control adv-form-control" required></div>
        </div>
        <button type="submit" class="btn w-100" style="background:var(--navy); color:white;">Submit & download</button>
      </div>
    </form>
  </div>
</div>

<!-- VIDEO MODAL (gated) with CONTACT NUMBER -->
<div class="modal fade" id="videoModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <form class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><i class="fas fa-play me-2" style="color:var(--navy);"></i>Watch gated video</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="videoUrlToWatch">
        <input type="hidden" id="videoTitle">
        <div class="mb-3"><label class="form-label">Full name</label><input type="text" class="form-control adv-form-control" required></div>
        <div class="mb-3"><label class="form-label">Email</label><input type="email" class="form-control adv-form-control" required></div>
        <!-- CONTACT NUMBER FIELD -->
        <div class="mb-3"><label class="form-label">Contact number</label><input type="tel" class="form-control adv-form-control" required></div>
        <div class="row">
          <div class="col-6 mb-3"><label class="form-label">Company</label><input class="form-control adv-form-control" required></div>
          <div class="col-6 mb-3"><label class="form-label">Position</label><input class="form-control adv-form-control" required></div>
        </div>
        <button type="submit" class="btn w-100" style="background:var(--navy); color:white;">Submit & watch</button>
      </div>
    </form>
  </div>
</div>

<?php $this->load->view('web/footer'); ?>

<script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Original navbar submenu functionality (from first code)
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

  // Navbar scroll effect
  const navbar = document.querySelector('.navbar');
  window.addEventListener('scroll', function() {
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled');
    } else {
      navbar.classList.remove('scrolled');
    }
  });

  // ---------- filter logic (youtube style) ----------
  const filterBtns = document.querySelectorAll('.pill-btn[data-filter]:not(#webinarsFilterBtn)');
  const webinarBtn = document.getElementById('webinarsFilterBtn');
  const gridItems = document.querySelectorAll('.mix-item');
  const webinarsSection = document.getElementById('webinarsSection');
  const resourcesSection = document.getElementById('resourcesSection');
  const indicator = document.getElementById('activeWebinarIndicator');
  const selectedTitle = document.getElementById('selectedWebinarTitle');
  const clearBtn = document.getElementById('clearWebinarFilter');
  let currentWebinar = 0;

  window.filterByWebinar = function(id, name) {
    currentWebinar = id;
    selectedTitle.innerText = name;
    indicator.classList.remove('d-none');
    webinarsSection.classList.add('hidden-section');
    resourcesSection.style.display = 'block';
    document.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
    document.querySelector('.pill-btn[data-filter="all"]').classList.add('active');
    applyFilters();
  };

  function applyFilters() {
    const active = document.querySelector('.pill-btn.active')?.getAttribute('data-filter') || 'all';
    const search = document.getElementById('resourceSearch').value.toLowerCase();
    gridItems.forEach(item => {
      const cat = item.dataset.category;
      const webinar = parseInt(item.dataset.webinarId || '0');
      const matchesCat = active === 'all' || cat === active;
      const matchesWeb = (currentWebinar === 0) || (webinar === currentWebinar);
      const text = item.innerText.toLowerCase();
      const matchesSearch = search === '' || text.includes(search);
      item.style.display = (matchesCat && matchesWeb && matchesSearch) ? 'block' : 'none';
    });
  }

  filterBtns.forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      currentWebinar = 0;
      indicator.classList.add('d-none');
      webinarsSection.classList.add('hidden-section');
      resourcesSection.style.display = 'block';
      applyFilters();
    });
  });

  webinarBtn.addEventListener('click', function() {
    document.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    resourcesSection.style.display = 'none';
    webinarsSection.classList.remove('hidden-section');
    currentWebinar = 0;
    indicator.classList.add('d-none');
  });

  document.getElementById('resourceSearch').addEventListener('keyup', applyFilters);
  if(clearBtn) clearBtn.addEventListener('click', function() {
    currentWebinar = 0;
    indicator.classList.add('d-none');
    applyFilters();
  });

  // ---------- modal data transfer ----------
  const downloadModal = document.getElementById('downloadModal');
  if(downloadModal) {
    downloadModal.addEventListener('show.bs.modal', function (e) {
      const btn = e.relatedTarget;
      document.getElementById('fileToDownload').value = btn.dataset.file || '';
      document.getElementById('fileTitle').value = btn.dataset.fileTitle || '';
    });
    document.querySelector('#downloadModal form').addEventListener('submit', function(e) {
      e.preventDefault();
      bootstrap.Modal.getInstance(downloadModal).hide();
      this.reset();
      alert('Thank you! Your download will start shortly. (Demo)');
    });
  }

  const videoModal = document.getElementById('videoModal');
  if(videoModal) {
    videoModal.addEventListener('show.bs.modal', function (e) {
      const btn = e.relatedTarget;
      document.getElementById('videoUrlToWatch').value = btn.dataset.videoUrl || '';
      document.getElementById('videoTitle').value = btn.dataset.videoTitle || '';
    });
    document.querySelector('#videoModal form').addEventListener('submit', function(e) {
      e.preventDefault();
      bootstrap.Modal.getInstance(videoModal).hide();
      this.reset();
      alert('Thank you! The video will open in a new tab. (Demo)');
    });
  }
});
</script>

</body>
</html>