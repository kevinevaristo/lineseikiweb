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
    }

    body {
  background-color: #fff;
  color: #333;
  font-family: 'Inter', sans-serif;
  line-height: 1.6;
  overflow-x: hidden;
  background: 
    /* Blue overlay */
    linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
    /* Background image */
    url('<?= base_url('assets_system/images/stockroom.jpg') ?>') center/cover no-repeat;
  background-size: cover;
  background-position: center;
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

/* Products Section */
.products {
  padding: 120px 5% 80px;
  text-align: center;
}

.products h1 {
  font-size: 2.5rem;
  margin-bottom: 40px;
  color: white;
  font-weight: 700;
  position: relative;
}

.products h1::after {
    content: '';
    position: absolute;
    left: 50%;
    bottom: -15px;
    transform: translateX(-50%);
    width: 60px;
    height: 4px;
    background: white;
    border-radius: 2px;
}

.categories {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 25px;
}

/* Individual Product Cards */
.category {
  border-radius: 16px;
  overflow: hidden;
  cursor: pointer;
  transition: var(--transition);
  position: relative;
}

.category:hover {
  transform: translateY(-8px);
}

/* Product image styling */
.category img {
  width: 100%;
  height: 250px;
  display: block;
  transition: opacity 0.4s ease;
}

/* Slight transparent effect on hover */
.category:hover img {
  opacity: 0.7;
}

/* Category title below image (no hover color) */
.category-title {
  padding: 15px 10px;
  background: transparent;
  color: white;
  font-size: 1.1rem;
  font-weight: 600;
  text-align: center;
  transition: none;
}

.category:hover .category-title {
  color: none;
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
      background: linear-gradient(135deg, var(--newblue2), var(--));
      transform: translateY(-3px);
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

  </style>
</head>
<body>

<!-- NAVBAR -->
<?php $this->load->view('web/header'); ?>

  <!-- Spacer for fixed navbar -->
  <div style="height: 90px;"></div>

  <!-- ✅ Products Section -->
  <section class="products">
    <h1 class="fade-in">Our Product Categories</h1>
    <div class="categories">
        <?php
        // Load categories from tbl_product_category
        $this->load->database();
        $query = $this->db->order_by('id', 'ASC')->get('tbl_product_category');
        $categories = $query->result();
        
        if (!empty($categories)): 
            $counter = 0;
        ?>
            <?php foreach ($categories as $category): 
                $counter++;
                $delay = ($counter % 4) + 1; // Creates delay-1, delay-2, delay-3, delay-4
                
                // Create link to category products page
                $link = base_url('index/category_products/' . $category->id);
                
                // Check if image exists
                $image_url = !empty($category->product_image) ? 
                    base_url('assets_system/images/' . $category->product_image) : 
                    base_url('assets_system/images/placeholder-category.png');
            ?>
            <div class="category fade-in delay-<?php echo $delay; ?>">
                <a href="<?php echo $link; ?>" title="<?php echo htmlspecialchars($category->category_name); ?>">
                    <img src="<?php echo $image_url; ?>" 
                         alt="<?php echo htmlspecialchars($category->category_name); ?>"
                         onerror="this.src='<?php echo base_url('assets_system/images/placeholder-category.png'); ?>'">
                </a>
                <div class="category-title"><?php echo htmlspecialchars($category->category_name); ?></div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback content if no categories in database -->
            <div class="col-12 text-center py-5">
                <p class="text-white">No product categories available at this time.</p>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA Section -->
<section class="cta">
    <h1 class="fade-in">Looking for the Right Measuring Solution?</h1>
    <p class="fade-in delay-1">Contact us today to discuss your requirements and find the perfect product for your needs.</p>
    <a href="<?php echo base_url('index/contact_us'); ?>" class="btn btn-light fade-in delay-2">INQUIRE</a>
</section>

  <!-- Footer -->
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
    });
  </script>
</body>
</html>
