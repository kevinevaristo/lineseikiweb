<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Privacy Policy - Line Seiki Asia Pacific</title>

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
    
    .navbar .dropdown-toggle::after {
    display: none;
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
    
    section h1::after, section h2::after {
      content: '';
      position: absolute;
      left: ;
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

    /* Color schemes */
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
      background: linear-gradient(135deg, var(--newblue2), var(--));
      transform: translateY(-3px);
      
      color: white;
    }
    
    .btn-explore {
      background: transparent;
      border: 2px solid var(--primary-blue);
      color: var(--primary-blue);
    }
    
    .btn-explore:hover {
      background: var(--primary-blue);
      color: #fff;
      transform: translateY(-3px);
      
    }
    
    .btn-link {
      text-decoration: none;
      position: relative;
    }
    
    .btn-link span {
      position: relative;
    }
    
    .btn-link span::after {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: -4px;
      left: 0;
      background-color: currentColor;
      transition: var(--transition);
    }
    
    .btn-link:hover span::after {
      width: 100%;
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

    }
    /*Center all heading underlines */
    section h1::after,
    section h2::after,
    footer h2::after {
    left: 50% !important;
    transform: translateX(-50%);
    }
/* Remove the artificial spacer under navbar */
body > div[style*="height: 90px"] {
  display: none !important;
}
/* Only target the Integrated Production heading */
.section-white h1 {
  text-align: center !important;
}


  </style>
</head>
<body>

  <!-- ✅ Fixed Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <div class="container-fluid">
      <!-- Logo on the LEFT -->
      <a class="navbar-brand" href="#">
        <img src=<?= base_url('assets_system/images/header_logo.png') ?> alt="Line Seiki Logo">
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
            <a class="nav-link dropdown-toggle" href=" " id="navbarDropdown" role="button" data-bs-toggle="dropdown">
              Product and Services
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?= base_url('index/ps_prod') ?>">Products</a></li>

              <!-- Submenu -->
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

  <!-- Header Section -->
 <section class="section-white text-center">
    <div class="container">
      <br><br><br><br>
      <h1 class="fade-in">Privacy Policy</h1>
    </div>

    <div class="container text-start mt-5">
        <?php if(isset($privacy_content) && !empty($privacy_content)): ?>
            <?php 
            // Group content by sections for better organization
            $current_section = '';
            $in_list = false;
            $in_sub_list = false;
            ?>
            
            <?php foreach($privacy_content as $item): ?>
                <?php 
                // Check if this is a main section
                $title = $item['title'];
                $content = $item['content'];
                
                // Handle main headings
                if(strpos($title, 'Privacy Policy Introduction') !== false): ?>
                    <p><strong>Privacy Policy</strong></p>
                    <hr>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(strpos($title, 'Personal Data Definition') !== false): ?>
                    <hr>
                    <h5>1. Personal Data</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(in_array($title, ['Contact Details', 'Technical information collected automatically on our websites', 'Your purchase information', 'Your communication data'])): ?>
                    <?php if(strpos($title, 'Contact Details') !== false): ?>
                        <ol type="a">
                    <?php endif; ?>
                    
                    <?php if($title == 'Contact Details'): ?>
                        <li><?php echo $title; ?></li>
                        <p><?php echo $content; ?></p>
                    <?php elseif($title == 'Technical information collected automatically on our websites'): ?>
                        <li><?php echo $title; ?></li>
                        <p><?php echo $content; ?></p>
                    <?php elseif($title == 'Your purchase information'): ?>
                        <li><?php echo $title; ?></li>
                        <p><?php echo $content; ?></p>
                    <?php elseif($title == 'Your communication data'): ?>
                        <li><?php echo $title; ?></li>
                        <p><?php echo $content; ?></p>
                        </ol>
                    <?php endif; ?>
                
                <?php elseif(strpos($title, 'Purpose Of Personal Data Introduction') !== false): ?>
                    <hr>
                    <h5>2. Purpose Of Personal Data</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(strpos($title, 'Purpose ') !== false && strpos($title, ' - ') !== false): ?>
                    <?php if(strpos($title, 'Purpose 1') !== false): ?>
                        <ol type="a">
                    <?php endif; ?>
                    
                    <li><?php echo substr(strstr($title, ' - '), 3); ?></li>
                    
                    <?php if(strpos($title, 'Purpose 6') !== false): ?>
                        </ol>
                    <?php endif; ?>
                
                <?php elseif(strpos($title, 'Joint Use Introduction') !== false): ?>
                    <hr>
                    <h5>3. Joint Use</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(strpos($title, 'Joint Use - ') !== false): ?>
                    <?php if(strpos($title, 'Joint Use - Line Seiki Group companies') !== false): ?>
                        <ol type="a">
                    <?php endif; ?>
                    
                    <li><?php echo substr(strstr($title, ' - '), 3); ?></li>
                    
                    <?php if(strpos($title, 'Joint Use - Third parties for legal requirements') !== false): ?>
                        </ol>
                    <?php endif; ?>
                
                <?php elseif(strpos($title, 'Retention') !== false): ?>
                    <hr>
                    <h5>4. Retention</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(strpos($title, 'Your Rights') !== false): ?>
                    <?php if(strpos($title, 'Your Rights - Deletion right') !== false): ?>
                        <hr>
                        <h5>5. Your Rights</h5>
                        <ol type="a">
                    <?php endif; ?>
                    
                    <li><?php echo $content; ?></li>
                    
                    <?php if(strpos($title, 'Your Rights - Consent withdrawal') !== false): ?>
                        </ol>
                    <?php endif; ?>
                
                <?php elseif(strpos($title, 'Security') !== false): ?>
                    <hr>
                    <h5>6. Security</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(strpos($title, 'Links To Other Website') !== false): ?>
                    <hr>
                    <h5>7. Links To Other Website</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(strpos($title, 'Changes To Policy') !== false): ?>
                    <hr>
                    <h5>8. Changes To Policy</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php elseif(strpos($title, 'Contact Us') !== false): ?>
                    <hr>
                    <h5>9. Contact Us</h5>
                    <ul>
                        <li><?php echo $content; ?></li>
                    </ul>
                
                <?php else: ?>
                    <!-- Fallback for any unhandled content -->
                    <div class="privacy-item">
                        <h5><?php echo htmlspecialchars($title); ?></h5>
                        <p><?php echo htmlspecialchars($content); ?></p>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            
        <?php else: ?>
            <div class="alert alert-warning">
                <p>Privacy policy content is not available at the moment.</p>
            </div>
        <?php endif; ?>
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