<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Page'; ?> - Line Seiki Asia Pacific</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Quill CSS for styling -->
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

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
    
    .dropdown-menu {
      background-color: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      border: 1px solid rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      padding: 0.8rem 0;
      margin-top: 0.8rem;
    }
    
    .dropdown-item {
      color: var(--dark);
      padding: 0.6rem 1.5rem;
      transition: var(--transition);
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

    section {
      padding: 100px 0;
    }
    
    section h1 {
      font-size: 2.8rem;
      color: var(--primary-blue);
      margin-bottom: 40px;
      font-weight: 700;
      text-align: center;
    }

    /* Content styling */
    .page-content {
      max-width: 1000px;
      margin: 0 auto;
      padding: 40px 20px;
    }

    /* Quill editor content styling */
    .ql-editor {
      padding: 0 !important;
      font-size: 1.05rem;
      line-height: 1.8;
    }

    .ql-editor h1 { 
      font-size: 2.2em; 
      font-weight: 700; 
      color: var(--primary-blue);
      margin: 1.5em 0 0.8em; 
    }
    
    .ql-editor h2 { 
      font-size: 1.8em; 
      font-weight: 700; 
      color: var(--primary-blue-dark);
      margin: 1.3em 0 0.7em; 
    }
    
    .ql-editor h3 { 
      font-size: 1.5em; 
      font-weight: 600; 
      color: var(--newblue2);
      margin: 1.2em 0 0.6em; 
    }
    
    .ql-editor h4 { 
      font-size: 1.3em; 
      font-weight: 600; 
      margin: 1em 0 0.5em; 
    }
    
    .ql-editor p { 
      margin: 1em 0; 
      color: #495057;
    }
    
    .ql-editor ul, 
    .ql-editor ol { 
      margin: 1em 0; 
      padding-left: 2.5em; 
    }
    
    .ql-editor li { 
      margin: 0.5em 0; 
      color: #495057;
    }
    
    .ql-editor a { 
      color: var(--primary-blue); 
      text-decoration: underline;
      transition: var(--transition);
    }
    
    .ql-editor a:hover { 
      color: var(--primary-blue-dark);
    }
    
    .ql-editor img { 
      max-width: 100%; 
      height: auto; 
      margin: 2em 0;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .ql-editor strong { 
      font-weight: 700; 
      color: var(--dark);
    }
    
    .ql-editor em { 
      font-style: italic; 
    }
    
    .ql-editor blockquote { 
      border-left: 4px solid var(--primary-blue); 
      padding-left: 1.5em; 
      margin: 1.5em 0; 
      color: #6b7280; 
      font-style: italic;
      background: var(--light-blue);
      padding: 1em 1.5em;
      border-radius: 0 8px 8px 0;
    }

    .ql-editor table {
      border-collapse: collapse;
      width: 100%;
      margin: 2em 0;
    }

    .ql-editor table td,
    .ql-editor table th {
      border: 1px solid #ddd;
      padding: 12px;
    }

    .ql-editor table th {
      background-color: var(--primary-blue);
      color: white;
      font-weight: 600;
    }

    .ql-editor table tr:nth-child(even) {
      background-color: var(--light-gray);
    }

    /* Footer */
    footer {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      color: white;
      padding: 80px 10% 40px;
      position: relative;
      overflow: hidden;
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
    
    footer .links a:hover {
      color: var(--newblue2);
    }
    
    footer .socials a {
      color: white;
      margin-right: 18px;
      font-size: 1.3rem;
      transition: var(--transition);
      display: inline-block;
    }
    
    footer .socials a:hover {
      transform: translateY(-3px);
    }

    /* Responsive */
    @media (max-width: 992px) {
      section {
        padding: 80px 0;
      }
      
      section h1 {
        font-size: 2.2rem;
      }
      
      .dropdown-submenu > .dropdown-menu {
        left: 0;
        margin-top: 0;
      }
    }
    
    @media (max-width: 768px) {
      section h1 {
        font-size: 1.8rem;
      }
    }

    /* Empty state */
    .empty-content {
      text-align: center;
      padding: 60px 20px;
      color: #6c757d;
    }

    .empty-content i {
      font-size: 4rem;
      color: #dee2e6;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

  <!-- Fixed Navbar -->
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
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/library') ?>">Library</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Spacer for fixed navbar -->
  <div style="height: 90px;"></div>

  <!-- Page Content Section -->
  <section class="section-white">
    <div class="container">
      <h1 class="fade-in"><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'Page'; ?></h1>
      
      <div class="page-content">
        <?php if(!empty($page_content)): ?>
          <div class="ql-editor">
            <?php echo $page_content; ?>
          </div>
        <?php else: ?>
          <div class="empty-content">
            <i class="fas fa-file-alt"></i>
            <h3>Content Not Available</h3>
            <p>This page content is currently being updated. Please check back later.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php $this->load->view('web/footer'); ?>

  <!-- Bootstrap JS -->
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

      // Fade in animation
      const fadeElements = document.querySelectorAll('.fade-in');
      const fadeObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, { threshold: 0.15 });
      
      fadeElements.forEach(el => fadeObserver.observe(el));
    });
  </script>

</body>
</html>
