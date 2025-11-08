<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Line Seiki Asia Pacific Service</title>

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
      background-color: var(--newblue);
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

    /* Hero Slider */
    .section-one {
      width: 100%;
      height: 100vh;
    }
    
    .slider-container {
      width: 100%;
      height: 100vh;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      position: relative;
      transition: background-image 1s ease-in-out;
    }
    
    .slider-container.fade {
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }
    
    .slider-indicators {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 12px;
      z-index: 10;
    }
    
    .slider-indicators span {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
      cursor: pointer;
      transition: var(--transition);
    }
    
    .slider-indicators span.active {
      background: var(--newblue);
    }
    
    .hero-content {
      position: absolute;
      top: 50%;
      left: 10%;
      transform: translateY(-50%);
      max-width: 600px;
      z-index: 5;
      color: white;
    }
    
    .hero-content h1 {
      font-size: 3.2rem;
      font-weight: 700;
      line-height: 1.2;
      margin-bottom: 20px;
      color: white;
    }
    
    .hero-content p {
      font-size: 1.2rem;
      margin-bottom: 30px;
      opacity: 0.9;
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
      box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
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
      box-shadow: 0 5px 15px rgba(253, 126, 20, 0.3);
    }
    
    .btn-orange:hover {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(253, 126, 20, 0.4);
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
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
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

    
    /* Sections */
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
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border-radius: 2px;
    }
    
    section p {
      margin-bottom: 28px;
      font-size: 1.1rem;
      color: #495057;
    }

    /* Color schemes */
    .section-white {
      background: var(--light-blue);
      color: #333;
    }
    
    .section-light-blue {
      background: var(--light-blue);
      color: #333;
      position: relative;
      overflow: hidden;
    }
    
    .section-light-orange {
      background: var(--newblue);
      color: #333;
      position: relative;
      overflow: hidden;
    }

    /* Products Section */
    .products {
      padding: 100px 5% 80px;
      text-align: center;
    }
    
    .products h1 {
      font-size: 2.5rem;
      margin-bottom: 40px;
      color: var(--primary-blue);
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
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
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
  background: #fff;
  transition: var(--transition);
  position: relative;
}

.category:hover {
  transform: translateY(-8px);
}

/* Product image styling */
.category img {
  width: 100%;
  height: 220px;
  object-fit: cover;
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
  color: var(--dark);
  font-size: 1.1rem;
  font-weight: 600;
  text-align: center;
  transition: none;
}

.category:hover .category-title {
  color: none;
}
    .overlay h3 {
      font-size: 1.4rem;
      margin-bottom: 12px;
      color: #fff;
    }
    
    .overlay p {
      font-size: 0.95rem;
      max-width: 250px;
    }

    /* Case Studies */
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
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
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
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .case-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
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

    /* News Section */
    .news-section {
      padding: 80px 5%;
      background: white;
    }
    
    .news-section h2 {
      text-align: center;
      margin-bottom: 50px;
      color: var(--primary-blue);
      position: relative;
    }
    
    .news-section h2::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
      width: 60px;
      height: 4px;
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border-radius: 2px;
    }
    
    .content-container {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }
    
    .news-card {
      background-color: #fff;
      color: #333;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      transition: var(--transition);
      display: flex;
      flex-direction: column;
      text-align: left;
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .news-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .news-card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      background: #ccc;
    }
    
    .news-card-content {
      padding: 25px;
    }
    
    .news-card-content h3 {
      font-size: 1.2rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--primary-blue);
    }
    
    .news-card-content p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
    }
    
    .news-card-content a {
      font-size: 0.95rem;
      font-weight: 600;
      color: var(--primary-blue);
      text-decoration: none;
      transition: var(--transition);
    }
    
    .news-card-content a:hover {
      color: var(--newblue);
    }

    /* Project Submission */
    .project-submission {
      padding: 100px 5%;
      background: var(--light-blue);
      display: flex;
      justify-content: center;
      align-items: center;
    }
    
    .project-card {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
      padding: 40px;
      text-align: center;
      max-width: 450px;
      width: 100%;
      border: 1px solid rgba(13, 110, 253, 0.1);
      transition: var(--transition);
    }
    
    .project-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }
    
    .project-card .icon {
      font-size: 3.5rem;
      color: var(--primary-blue);
      margin-bottom: 20px;
    }
    
    .project-card h4 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--primary-blue);
    }
    
    .project-card p {
      font-size: 1rem;
      color: #495057;
      margin-bottom: 30px;
    }
    
    .project-card .btn-outline-primary {
      border: 2px solid var(--primary-blue);
      color: var(--primary-blue);
      padding: 10px 20px;
      border-radius: 8px;
      font-weight: 500;
      transition: var(--transition);
    }
    
    .project-card .btn-outline-primary:hover {
      background: var(--primary-blue);
      color: white;
    }
    
    .project-card .file-name {
      font-size: 0.9rem;
      color: #6c757d;
      margin: 15px 0;
    }
    
    .project-card .btn-success {
      background: var(--newblue);
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-weight: 600;
      width: 100%;
      transition: var(--transition);
    }
    
    .project-card .btn-success:hover {
      background: var(--newblue2);
      transform: translateY(-2px);
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
      
      .hero-content h1 {
        font-size: 2.5rem;
      }
      
      .dropdown-submenu > .dropdown-menu {
        left: 0;
        margin-top: 0;
      }
      
      footer .links a {
        display: inline-block;
        margin-bottom: 12px;
      }
      
      .categories {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      }
      
      .case-grid {
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      }
    }
    
    @media (max-width: 768px) {
      section h1 {
        font-size: 2rem;
      }
      
      section h2 {
        font-size: 1.8rem;
      }
      
      .hero-content {
        left: 5%;
        text-align: center;
        width: 90%;
      }
      
      .hero-content h1 {
        font-size: 2rem;
      }
      
      footer .links a {
        display: block;
        margin-bottom: 12px;
      }
    }
    /* Remove all shadows globally */
* {
  box-shadow: none !important;
  text-shadow: none !important;
}
/* 3. Callout Row (Mobile-first: Column Layout) */
        .callout-row {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3rem; /* space-y-12 */
        }
        
        .callout-box {
            width: 100%;
            text-align: left;
            order: 2; /* order-2 */
        }
        
        .callout-box h2 {
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }
        
        .callout-box p {
            color: var(--gray-700);
        }

        /* 4. Illustration Center */
        .illustration-center {
            width: 100%;
            max-width: 36rem; /* max-w-xl */
            margin: 0 auto;
            height: 24rem; /* h-[24rem] */
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            order: 1; /* order-1 */
        }

        .illustration-image {
            max-width: 100%;
            height: auto;
            object-fit: contain;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .illustration-image:nth-child(1) { z-index: 10; top: 0rem; } /* Top Mold */
        .illustration-image:nth-child(2) { z-index: 20; top: 10rem; } /* Internal Part */
        .illustration-image:nth-child(3) { z-index: 0; top: 17rem; } /* Bottom Mold */


        /* 5. Callout Lines (Desktop Only) */
        .rotated-line {
            position: absolute;
            transform-origin: 0 0;
        }

        /* Left Line (Silicone Mold) */
        .rotated-line-left {
            width: 9rem; /* w-36 */
            height: 1px;
            background-color: var(--primary-blue);
            /* These styles are applied via media query below */
        }

        /* Right Line (Urethane Part) */
        .rotated-line-right {
            width: 12rem; /* w-48 */
            height: 1px;
            background-color: var(--primary-blue);
            /* These styles are applied via media query below */
        }

        .rotated-dot {
            width: 0.5rem; /* w-2 */
            height: 0.5rem; /* h-2 */
            border-radius: 50%; /* rounded-full */
            background-color: var(--primary-blue);
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        /* 6. Desktop Styles (md: Breakpoint) */
        @media (min-width: 768px) {
            .callout-row {
                flex-direction: row; /* md:flex-row */
                gap: 3rem; /* md:space-x-12 (approx) */
            }

            .left-callout-box {
                width: 33.3333%; /* md:w-1/3 */
                order: 1; /* md:order-1 */
                align-self: flex-start; /* self-start */
                margin-top: 4rem; /* Custom alignment to match the line's top position */
                text-align: right; /* md:text-right */
                padding-right: 3rem; /* md:pr-12 */
            }

            .right-callout-box {
                width: 33.3333%; /* md:w-1/3 */
                order: 3; /* order-3 */
                align-self: flex-start; /* self-start */
                margin-top: 10rem; /* Custom alignment to match the line's top position */
                padding-left: 3rem; /* md:pl-12 */
            }

            .illustration-center {
                order: 2; /* md:order-2 */
            }

            /* Show callout lines */
            .callout-lines-container {
                display: block !important;
            }

            /* Left Line Position */
            .rotated-line-left {
                top: 13rem;
                left: -4rem;
                transform: rotate(-10deg);
            }
            .rotated-line-left .rotated-dot {
                right: 0;
                transform: translate(50%, -50%);
            }

            /* Right Line Position - FIX APPLIED HERE */
            .rotated-line-right {
                top: 21rem; /* Adjusted from 11rem to 10.5rem for better visual alignment with the text and image */
                right: -3.5rem;
                transform: rotate(5deg);
            }
            .rotated-line-right .rotated-dot {
                left: 0;
                transform: translate(-50%, -50%);
            }
        }
         .main-wrapper {
            max-width: 80rem; /* max-w-5xl (approx) */
            margin: 0 auto; /* mx-auto */
        }

        /* Center the headings and remove blue line */
        .main-heading {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            color: var(--primary-blue);
            margin-bottom: 0.5rem;
        }
        
        .sub-heading {
            text-align: center;
            color: var(--gray-600);
            font-size: 1.125rem;
            margin-bottom: 2rem;
        }

        /* Remove the blue underline from the main heading */
        .main-heading::after {
            display: none;
        }
        
        /* Add this CSS to make the callout headings match the main heading style */
#callout-left h3, 
#callout-right h3 {
    font-size: 2rem !important;
    font-weight: 800 !important;
    color: var(--primary-blue) !important;
    text-align: center;
    margin-bottom: 0.5rem;
}
.section-white {
    background: #fff;
    color: #333;
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
        url('<?= base_url('assets_system/images/sm5.png') ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    z-index: 0;
}
.section-white h1,
.section-white p {
    color: white;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

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
.section-white .col-lg-6:last-child img[src*="sm4.png"] {
    box-shadow: none !important;
    border: none !important;
    border-radius: 0 !important;
    background: transparent !important;
    max-width: 50rem !important;
    height: auto !important;
    display: block;
    margin-left: auto;
    transform: none !important;
}

.section-white .col-lg-6:last-child img[src*="sm4.png"]:hover {
    transform: none !important;
    box-shadow: none !important;
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
/* Make Section 3 background match Section 5 */
.case-studies.section-white {
    background: var(--light-blue) !important;
}

.case-studies.section-white::before {
    display: none !important;
}
/* ===== Molding & Casting Section ===== */
#molding-casting-section {
  background-color: #f2f7fc;
  padding: 5rem 0;
  font-family: 'Poppins', sans-serif;
}

.molding-casting {
  display: grid;
  grid-template-columns: 1fr;
  gap: 4rem;
  max-width: 80rem;
  margin: 0 auto;
}

.process-box {
  color: var(--gray-700);
  background: transparent;
}

/* ===== Title (Silicone / Urethane) ===== */
.process-box h2 {
  font-size: 2.5rem;          /* same as image */
  color: var(--primary-blue);
  margin-bottom: 1.25rem;
}

/* ===== Paragraph ===== */
.process-box p {
  font-size: 1.2rem;          /* matches image text */
  color: var(--gray-700);
  line-height: 1.75;
  margin-bottom: 1.75rem;
  max-width: 95%;
}

/* ===== Subheading ===== */
.process-box h3 {
  font-size: 1.2rem;
  font-weight: 700;
  color: var(--gray-700);
  margin-bottom: 0.75rem;
}

/* ===== Bullet List ===== */
.process-box ul {
  list-style-type: disc;
  padding-left: 1.5rem;
  margin: 0;
}

.process-box li {
  font-size: 1.15rem;
  color: var(--gray-700);
  margin-bottom: 0.5rem;
  line-height: 1.7;
}

/* ===== Responsive Layout ===== */
@media (min-width: 992px) {
  .molding-casting {
    grid-template-columns: repeat(2, 1fr);
    gap: 4rem;
  }

  #molding-casting-section {
    padding: 6rem 0;
  }

  .process-box p {
    max-width: 100%;
  }
}
.process-box h2::after {
  content: none !important;
  display: none !important;
  border: none !important;
}
#process-section {
  background-color: #f7fbff;
  padding: 5rem 0;
  font-family: 'Poppins', sans-serif;
}

.process-flow {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  flex-wrap: wrap;
  text-align: center;
  position: relative;
  max-width: 2000px;
  margin: 0 auto;
}

.process-step {
  flex: 1 1 20%;
  max-width: 240px;
  margin: 0 auto;
  color: var(--gray-700);
}

.process-step img {
  width: 200px;
  height: auto;
  margin-bottom: 1.25rem;
}

.process-step h3 {
  font-size: 1.50rem;
  font-weight: 700;
  color: black;
  margin-bottom: 0.75rem;
}

.process-step p {
  font-size: 1.1rem;
  color: var(--gray-700);
  line-height: 1.6;
  margin: 0 auto;
  max-width: 90%;
}

/* Connector line between steps */
.process-line {
  flex: 0 0 60px;
  height: 3px;
  background-color: #3fb4f9;
  align-self: center;
  margin: 2.5rem 0;
}

/* Responsive layout */
@media (max-width: 992px) {
  .process-flow {
    flex-direction: column;
    align-items: center;
  }

  .process-line {
    width: 60px;
    height: 2px;
    margin: 1.5rem 0;
  }

  .process-step {
    max-width: 300px;
  }
}
.project-gallery {
  background-color: #0b3a67;
  color: white;
  text-align: center;
  padding: 60px 20px;
  font-family: 'Helvetica Neue', Arial, sans-serif;
}

.project-gallery h1 {
  font-size: 3rem;
  margin-bottom: 10px;
  font-weight: bold;
  color: white;
}

.project-gallery p {
  max-width: 700px;
  margin: 0 auto 40px;
  line-height: 1.6;
  color: #d8e3f0;
}

.gallery-section {
  margin-bottom: 50px;
}

.gallery-title {
  text-align: center !important;
  font-size: 1.5rem !important;
  margin-bottom: 25px !important;
  color: white !important;
  font-weight: 600 !important;
  width: 100%;
}

/* Carousel Styles */
.carousel-container {
  position: relative;
  max-width: 1200px;
  margin: 0 auto;
  overflow: hidden;
}

.carousel-wrapper {
  overflow: hidden;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
}

.carousel-track {
  display: flex;
  transition: transform 0.5s ease-in-out;
  will-change: transform;
}

.carousel-slide {
  flex: 0 0 33.333%;
  padding: 10px;
  box-sizing: border-box;
}

.carousel-slide img {
  width: 100%;
  height: 300px;
  object-fit: cover;
  border-radius: 8px;
  background-color: white;
  transition: transform 0.3s ease;
}

.carousel-slide img:hover {
  transform: scale(1.03);
}

/* Carousel Navigation Buttons */
.carousel-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 255, 255, 0.9);
  border: none;
  border-radius: 50%;
  width: 50px;
  height: 50px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 10;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.carousel-btn:hover {
  background: white;
  transform: translateY(-50%) scale(1.1);
}

.carousel-btn:active {
  transform: translateY(-50%) scale(0.95);
}

.carousel-prev {
  left: 15px;
}

.carousel-next {
  right: 15px;
}

.carousel-btn i {
  font-size: 1.2rem;
  color: #0b3a67;
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .carousel-slide {
    flex: 0 0 50%;
  }
  
  .carousel-slide img {
    height: 250px;
  }
}

@media (max-width: 768px) {
  .carousel-slide {
    flex: 0 0 100%;
  }
  
  .carousel-slide img {
    height: 200px;
  }
  
  .carousel-btn {
    width: 40px;
    height: 40px;
  }
  
  .gallery-title {
    font-size: 1.3rem !important;
  }
  
  .project-gallery h1 {
    font-size: 2.5rem;
  }
}
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
                <li><a class="dropdown-item" href="<?= base_url('index/ps_serv_simulation') ?>">Simulation Analysis</a></li>
                <li><a class="dropdown-item active" href="<?= base_url('index/ps_serv') ?>">Silicone Molding & Urethane Casting</a></li>
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
<br><br><br><section class="section-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 fade-in">
                <h1>Production Quality <br>at Low Volumes</h1>
                <p>Get full-scale aesthetics and performance without fullscale tooling. Silicone Molding and Urethane Casting
deliver production-grade parts for concept, validation and
low-volume runs.
</p>
                <a href="#consultation" class="consultation-btn">Request a Quote</a>
            </div>
            <div class="col-lg-6 fade-in delay-1">
                <img src="<?= base_url('assets_system/images/sm4.png') ?>" alt="Simulation Analysis">
            </div>
        </div>
    </div>
</section>



<div class="main-wrapper">
 <section id="our-process-section">
        <!-- Header Section -->
        <div class="text-center">
            <h1 class="main-heading">
                WHAT DO WE DO
            </h1>
            <p class="sub-heading">
                Precision-crafted parts through Silicone Molding and Urethane Casting.
            </p>
        </div>

        <!-- Main Illustration and Callout Container -->
        <div class="callout-row">
            
            <!-- Left Callout Box (Silicone Mold) -->
            <div class="callout-box left-callout-box">
                <div id="callout-left">
                    <br><br><br><h3>Silicone Mold</h3>
                    <p>Flexible, high-detail molds that capture even the most intricate surface textures.</p>
                </div>
            </div>

            <!-- Central Illustration Stack -->
            <div id="illustration-center" class="illustration-center">
                
                <!-- 1. Top Mold Image -->
                <img src="<?= base_url('assets_system/images/sm1.png')?>" 
                     alt="Top half of the silicone mold" 
                     class="illustration-image">

                <!-- 2. Internal Urethane Part Image -->
                <img src="<?= base_url('assets_system/images/sm2.png')?>" 
                     alt="The finished urethane part" 
                     class="illustration-image">

                <!-- 3. Bottom Mold Image -->
                <img src="<?= base_url('assets_system/images/sm3.png')?>" 
                     alt="Bottom half of the silicone mold" 
                     class="illustration-image">


                <!-- The Visual Callout Lines (Desktop Only) -->
                <div class="callout-lines-container hidden">
                    
                    <!-- Line 1: Left Callout to TOP MOLD -->
                    <div class="rotated-line rotated-line-left">
                        <div class="rotated-dot"></div>
                    </div>

                    <!-- Line 2: Right Callout to INTERNAL PART -->
                    <div class="rotated-line rotated-line-right">
                        <div class="rotated-dot"></div>
                    </div>
                </div>

            </div>
            
            <!-- Right Callout Box (Urethane Part) -->
            <div class="callout-box right-callout-box">
                <div id="callout-right">
                    <br><br><br><br><br><br><h3>Urethane Part</h3>
                    <p>Durable, functional, and production-grade.</p>
                </div>
            </div>

        </div>
     </section>
    </div>
<br><br><br><br>
<section id="molding-casting-section">
  <div class="container molding-casting">
    <div class="process-box">
      <h2>Silicone Molding</h2>
      <p>
        Silicone molding—also known as Room Temperature Vulcanizing (RTV) molding—uses a flexible silicone mold
        to reproduce parts with exceptional surface detail and accuracy. It’s the ideal process for creating
        small-batch or low-volume parts without the high investment cost of injection molding or press dies.
      </p>
      <h3>Key Features:</h3>
      <ul>
        <li>Produces up to 10–50 parts per mold, depending on design and material.</li>
        <li>Captures fine surface textures — even details as small as fingerprint marks.</li>
        <li>Supports insert molding and over-molding applications.</li>
        <li>Maximum casting size: 450 × 450 × 450 mm.</li>
        <li>Minimum guaranteed wall thickness: 1.5 mm.</li>
      </ul>
    </div>

    <div class="process-box">
      <h2>Urethane Casting</h2>
      <p>
        Urethane casting uses thermosetting polyurethane resins—similar to epoxy—to produce multiple copies of
        your master model. Combined with silicone molds, this process delivers high-detail prototypes and
        functional parts that can match the look, feel, and performance of injection-molded products.
      </p>
      <h3>Key Features:</h3>
      <ul>
        <li>Tight dimensional tolerance of ±0.15 mm per 100 mm.</li>
        <li>Fine feature replication down to 0.5 mm width and depth.</li>
        <li>Cast-in color options (blue, green, yellow, red) to reduce post-painting time.</li>
        <li>Supports post-processing such as machining, painting, and assembly.</li>
        <li>UL- and RoHS-compliant materials available.</li>
        <li>Suitable for final product components and functional testing.</li>
        <li>More cost-efficient than 3D printing for quantities above 10 pcs.</li>
        <li>Ideal alternative to injection molding for runs under 1,000 pcs.</li>
      </ul>
    </div>
  </div>
</section>

<section id="process-section">
  <div class="container">
    <div class="process-flow">
      <div class="process-step">
        <img src="<?= base_url('assets_system/images/sm9.png') ?>" alt="Silicone Molding">
        <h3>Silicone Molding</h3>
        <p>Liquid silicone is poured around the master pattern to form a flexible mold.</p>
      </div>

      <div class="process-line"></div>

      <div class="process-step">
        <img src="<?= base_url('assets_system/images/sm6.png') ?>" alt="Mold Removal">
        <h3>Mold Removal</h3>
        <p>The cured silicone mold is carefully cut and separated from the master pattern.</p>
      </div>

      <div class="process-line"></div>

      <div class="process-step">
        <img src="<?= base_url('assets_system/images/sm7.png') ?>" alt="Urethane Casting">
        <h3>Urethane Casting</h3>
        <p>Urethane resin is poured into the silicone mold to replicate the master part.</p>
      </div>

      <div class="process-line"></div>

      <div class="process-step">
        <img src="<?= base_url('assets_system/images/sm8.png') ?>" alt="Copies of Prototype">
        <h3>Copies of Prototype</h3>
        <p>Multiple casted parts are produced with high accuracy and surface detail.</p>
      </div>
    </div>
  </div>
</section>

<section class="project-gallery">
  <h1>Project Gallery</h1>
  <p>See how we've applied silicone molding and urethane casting across a wide variety of product types—from prototype enclosures to functional end-use parts.</p>

  <div class="gallery-section">
    <h3 class="gallery-title">Urethane Parts</h3>
    <div class="carousel-container">
      <div class="carousel-wrapper">
        <div class="carousel-track" id="carousel-track-1">
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Part">
          </div>
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel2.jpg') ?>" alt="Urethane Casted Part">
          </div>
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel1.jpg') ?>" alt="Urethane Casted Part">
          </div>
          <!-- Duplicate slides for seamless looping -->
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Part">
          </div>
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel2.jpg') ?>" alt="Urethane Casted Part">
          </div>
        </div>
      </div>
      <button class="carousel-btn carousel-prev" onclick="moveSlide('carousel-track-1', -1)">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="carousel-btn carousel-next" onclick="moveSlide('carousel-track-1', 1)">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </div>

  <div class="gallery-section">
    <h3 class="gallery-title">Urethane Casted Overmolding</h3>
    <div class="carousel-container">
      <div class="carousel-wrapper">
        <div class="carousel-track" id="carousel-track-2">
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Overmolding">
          </div>
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Overmolding">
          </div>
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Overmolding">
          </div>
          <!-- Duplicate slides for seamless looping -->
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Overmolding">
          </div>
          <div class="carousel-slide">
            <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Overmolding">
          </div>
        </div>
      </div>
      <button class="carousel-btn carousel-prev" onclick="moveSlide('carousel-track-2', -1)">
        <i class="fas fa-chevron-left"></i>
      </button>
      <button class="carousel-btn carousel-next" onclick="moveSlide('carousel-track-2', 1)">
        <i class="fas fa-chevron-right"></i>
      </button>
    </div>
  </div>
</section>

<!-- ✅ Project Submission Section -->
<section class="project-submission">
  <div class="project-card fade-in">
    <div class="icon">
      <i class="fas fa-file-upload"></i>
    </div>
    <h4>Project Submission</h4>
    <p>Upload your CAD models or design drawings to receive a detailed quote.</p>
    <label for="file-upload" class="btn btn-outline-primary">
      <i class="fas fa-paperclip me-2"></i> Select File
    </label>
    <input id="file-upload" type="file" hidden>
    <div id="file-name" class="file-name">No file selected</div>
    <button class="btn btn-success">Request Quote</button>
  </div>
</section>

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

    // Carousel functionality
let currentIndex = {
  'carousel-track-1': 0,
  'carousel-track-2': 0
};

function moveSlide(trackId, direction) {
  const track = document.getElementById(trackId);
  const slides = track.querySelectorAll('.carousel-slide');
  const totalSlides = slides.length / 2; // Original slides (excluding duplicates)
  
  currentIndex[trackId] += direction;
  
  // Handle looping
  if (currentIndex[trackId] >= totalSlides) {
    currentIndex[trackId] = 0;
    // Reset position instantly without animation
    track.style.transition = 'none';
    track.style.transform = `translateX(0)`;
    // Force reflow
    track.offsetHeight;
    // Re-enable transition
    track.style.transition = 'transform 0.5s ease-in-out';
  } else if (currentIndex[trackId] < 0) {
    currentIndex[trackId] = totalSlides - 1;
    track.style.transition = 'none';
    track.style.transform = `translateX(-${(totalSlides - 1) * 100}%)`;
    track.offsetHeight;
    track.style.transition = 'transform 0.5s ease-in-out';
  }
  
  // Move the track
  const slideWidth = 100 / (slides.length / 2); // Calculate percentage based on original slides
  track.style.transform = `translateX(-${currentIndex[trackId] * slideWidth}%)`;
}

// Auto-advance carousels
function startAutoCarousel() {
  setInterval(() => {
    moveSlide('carousel-track-1', 1);
  }, 4000);
  
  setInterval(() => {
    moveSlide('carousel-track-2', 1);
  }, 4500);
}

// Start auto-advance when page loads
document.addEventListener('DOMContentLoaded', startAutoCarousel);
</script>
</body>
</html>