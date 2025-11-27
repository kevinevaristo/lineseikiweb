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
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
    left: 50%; /* Moves the start of the line to the center */
    bottom: -10px;
    width: 60px;
    height: 4px;
    background: linear-gradient(135deg, var(--newblue2), var(--newblue));
    border-radius: 2px;
    transform: translateX(-50%); /* Shifts the line back by half its width to perfectly center it */
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

    /* =========================================
       UPGRADED "WHY CHOOSE US" SECTION
       Style: Clean, Grid-based, Technical
    ========================================= */
    .why-choose-us-section {
        padding: 100px 5%;
        background-color: #f8faff;
        /* Technical dot pattern background */
        background-image: radial-gradient(#dbeafe 1.5px, transparent 1.5px);
        background-size: 24px 24px;
        position: relative;
    }

    .wcu-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    .wcu-header {
        margin-bottom: 3rem;
        position: relative;
        z-index: 2;
    }

    .wcu-header h2 {
        font-size: 3rem;
        font-weight: 800;
        color: var(--dark);
        line-height: 1.1;
    }

    .wcu-header .highlight {
        color: var(--primary-blue);
        position: relative;
        display: inline-block;
    }
    
    /* Underline effect for title */
    .wcu-header .highlight::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 8px;
        background: rgba(13, 110, 253, 0.15);
        z-index: -1;
        transform: skewX(-15deg);
    }

    /* Grid Layout for Features */
    .wcu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
        margin-bottom: 50px;
    }

    .wcu-card {
        background: #fff;
        border: 1px solid rgba(13, 110, 253, 0.08);
        border-radius: 16px;
        padding: 30px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }

    /* Hover Effect: Lift and Glow */
    .wcu-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(13, 110, 253, 0.12);
        border-color: rgba(13, 110, 253, 0.3);
    }

    /* Decorative Circle on hover */
    .wcu-card::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 100px;
        height: 100px;
        background: var(--light-blue);
        border-radius: 50%;
        transition: 0.5s;
        opacity: 0;
    }

    .wcu-card:hover::before {
        opacity: 0.5;
        transform: scale(1.5);
    }

    .wcu-icon-wrapper {
        width: 60px;
        height: 60px;
        background: var(--light-blue);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--primary-blue);
        margin-bottom: 20px;
        transition: 0.3s;
    }

    .wcu-card:hover .wcu-icon-wrapper {
        background: var(--primary-blue);
        color: #fff;
        transform: rotateY(180deg);
    }

    .wcu-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: var(--dark);
    }

    .wcu-card p {
        font-size: 0.95rem;
        color: #64748b;
        margin: 0;
        line-height: 1.6;
    }

    /* Visual Side (Image/Video) */
    .wcu-visual-container {
        position: relative;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        height: 100%;
        min-height: 500px;
    }

    .wcu-visual-bg {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }
    
    .wcu-visual-container:hover .wcu-visual-bg {
        transform: scale(1.05);
    }

    .wcu-overlay-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        padding: 40px 30px;
        color: white;
    }

    .play-button-wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(5px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: 0.3s;
        border: 1px solid rgba(255,255,255,0.4);
        z-index: 10;
    }

    .play-button-wrapper:hover {
        background: var(--primary-blue);
        transform: translate(-50%, -50%) scale(1.1);
        border-color: var(--primary-blue);
    }

    .play-button-wrapper i {
        font-size: 1.8rem;
        color: white;
        margin-left: 5px; /* Visual alignment fix for play icon */
    }


    /* =========================================
       UPGRADED "BENEFITS OF SMUC" SECTION
       Style: Dark, Glassmorphism, Numbered
    ========================================= */
    .benefits-section {
        padding: 100px 5%;
        background: radial-gradient(circle at top right, #174a85, #0F467B);
        color: white;
        position: relative;
        overflow: hidden;
    }

    /* Grid lines overlay */
    .benefits-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: 
            linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        pointer-events: none;
    }

    .benefits-header {
        text-align: center;
        margin-bottom: 70px;
        position: relative;
        z-index: 2;
    }

    .benefits-header h2 {
        font-size: 2.8rem;
        font-weight: 800;
        color: white;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    
    .benefits-header p {
        color: rgba(255,255,255,0.7);
        max-width: 600px;
        margin: 0 auto;
    }

    .benefit-card-new {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        display: flex;
        gap: 25px;
        align-items: center;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
    }

    /* Hover Glow Effect */
    .benefit-card-new:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }
    
    /* Blue accent line on left */
    .benefit-card-new::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--newblue);
        opacity: 0;
        transition: 0.3s;
    }
    
    .benefit-card-new:hover::before {
        opacity: 1;
    }

    /* Background Large Number (01, 02) */
    .benefit-number {
        position: absolute;
        top: -20px;
        right: 10px;
        font-size: 6rem;
        font-weight: 900;
        color: rgba(255, 255, 255, 0.03);
        transition: 0.4s;
        z-index: 0;
    }

    .benefit-card-new:hover .benefit-number {
        color: rgba(255, 255, 255, 0.1);
        transform: translateY(10px);
    }

    .benefit-img-box {
        width: 140px;
        height: 140px;
        flex-shrink: 0;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.1);
        z-index: 1;
        background: #000;
    }

    .benefit-img-box img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: 0.5s;
    }
    
    .benefit-card-new:hover .benefit-img-box img {
        transform: scale(1.1);
    }

    .benefit-text {
        z-index: 1;
    }

    .benefit-text h4 {
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 10px;
        color: white;
    }

    .benefit-text p {
        font-size: 0.95rem;
        color: rgba(255, 255, 255, 0.75);
        margin: 0;
        line-height: 1.6;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .wcu-grid {
            grid-template-columns: 1fr;
        }
        .wcu-header h2 {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 768px) {
        .benefit-card-new {
            flex-direction: column;
            text-align: center;
            padding: 40px 20px;
        }
        .benefit-img-box {
            margin-bottom: 15px;
            width: 120px;
            height: 120px;
        }
        .benefit-number {
            font-size: 4rem;
            top: 10px;
            right: 20px;
        }
        .wcu-header h2 {
            font-size: 2rem;
        }
    }
    /* =========================================
   UPGRADED PROJECT GALLERY SECTION
   Style: Modern, Interactive, Dark Theme
========================================= */
.project-gallery-upgraded {
    padding: 100px 5%;
    background: linear-gradient(135deg, #0F467B 0%, #174a85 50%, #0b3a67 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

/* Grid pattern overlay */
.project-gallery-upgraded::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: 
        linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
    background-size: 40px 40px;
    pointer-events: none;
}

/* Header Styles */
.gallery-header {
    position: relative;
    z-index: 2;
}

.gallery-main-title {
    font-size: 3.2rem;
    font-weight: 800;
    color: white;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.gallery-subtitle {
    font-size: 1.2rem;
    color: rgba(255, 255, 255, 0.8);
    max-width: 700px;
    margin: 0 auto;
    line-height: 1.6;
}

/* Gallery Tabs */
.gallery-tabs .nav-pills {
    background: rgba(255, 255, 255, 0.08);
    border-radius: 50px;
    padding: 8px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.gallery-tabs .nav-link {
    color: rgba(255, 255, 255, 0.7);
    background: transparent;
    border: none;
    border-radius: 30px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    margin: 0 4px;
}

.gallery-tabs .nav-link:hover {
    color: white;
    background: rgba(255, 255, 255, 0.1);
}

.gallery-tabs .nav-link.active {
    color: white;
    background: linear-gradient(135deg, var(--newblue), var(--newblue2));
    box-shadow: 0 4px 15px rgba(23, 162, 220, 0.3);
}

/* Gallery Grid Layout */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

/* Gallery Card */
.gallery-card {
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    backdrop-filter: blur(10px);
    position: relative;
}

.gallery-card:hover {
    transform: translateY(-10px);
    background: rgba(255, 255, 255, 0.08);
    border-color: rgba(255, 255, 255, 0.2);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
}

/* Image Container */
.gallery-image-container {
    position: relative;
    overflow: hidden;
    height: 280px;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-card:hover .gallery-image {
    transform: scale(1.05);
}

/* Overlay with Actions */
.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to bottom, rgba(15, 70, 123, 0.8), transparent);
    display: flex;
    align-items: flex-end;
    justify-content: flex-end;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.gallery-card:hover .gallery-overlay {
    opacity: 1;
}

.gallery-actions {
    display: flex;
    gap: 10px;
}

.gallery-btn {
    width: 45px;
    height: 45px;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--newblue2);
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}

.gallery-btn:hover {
    background: white;
    transform: scale(1.1);
    color: var(--newblue);
}

/* Gallery Info */
.gallery-info {
    padding: 25px;
}

.gallery-info h4 {
    font-size: 1.3rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: white;
}

.gallery-info p {
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 15px;
    font-size: 0.95rem;
    line-height: 1.5;
}

/* Tags */
.gallery-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.gallery-tag {
    background: rgba(255, 255, 255, 0.1);
    color: rgba(255, 255, 255, 0.9);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 500;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

/* View More Button */
.gallery-view-more {
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 12px 30px;
    border-radius: 30px;
    font-weight: 600;
    transition: all 0.3s ease;
    background: transparent;
}

.gallery-view-more:hover {
    background: white;
    color: var(--newblue2);
    border-color: white;
    transform: translateY(-2px);
}

/* Lightbox Styles */
.lightbox-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.lightbox-modal.active {
    display: flex;
    opacity: 1;
}

.lightbox-content {
    position: relative;
    max-width: 90%;
    max-height: 90%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-content img {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
    border-radius: 10px;
}

.lightbox-close {
    position: absolute;
    top: -50px;
    right: 0;
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.lightbox-close:hover {
    background: rgba(255, 255, 255, 0.2);
}

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.1);
    border: none;
    color: white;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    font-size: 1.2rem;
    cursor: pointer;
    transition: background 0.3s ease;
}

.lightbox-nav:hover {
    background: rgba(255, 255, 255, 0.2);
}

.lightbox-prev {
    left: -70px;
}

.lightbox-next {
    right: -70px;
}

.lightbox-caption {
    position: absolute;
    bottom: -60px;
    left: 0;
    width: 100%;
    text-align: center;
    color: white;
}

/* Responsive Design */
@media (max-width: 992px) {
    .gallery-grid {
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .gallery-main-title {
        font-size: 2.5rem;
    }
    
    .lightbox-nav {
        width: 40px;
        height: 40px;
    }
    
    .lightbox-prev {
        left: 10px;
    }
    
    .lightbox-next {
        right: 10px;
    }
}

@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
    
    .gallery-main-title {
        font-size: 2rem;
    }
    
    .gallery-tabs .nav-link {
        padding: 10px 16px;
        font-size: 0.9rem;
    }
    
    .project-gallery-upgraded {
        padding: 60px 5%;
    }
}
/* =========================================
       NEW ISO CERTIFICATION SECTION
       Style: Professional, Trustworthy, Blue
    ========================================= */
  /* =========================================
       NEW ISO CERTIFICATION SECTION
       Style: Professional, Trustworthy, Blue Wavy Gradient
    ========================================= */
    .iso-section {
      padding: 100px 5%;
      position: relative;
      overflow: hidden;
      /* Dark Blue Base */
      background-color: #0b2545;
      /* Wavy Gradient Background */
      background-image: 
          radial-gradient(circle at 0% 0%, rgba(23, 162, 220, 0.2) 0%, transparent 50%),
          radial-gradient(circle at 100% 100%, rgba(13, 110, 253, 0.15) 0%, transparent 50%),
          linear-gradient(135deg, #0F467B 0%, #071e3d 100%);
      color: white;
      text-align: center;
    }

    /* Subtle Wave Pattern Overlay - Makes the gradient feel "wavy" */
    .iso-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1440 320'%3E%3Cpath fill='%2317A2DC' fill-opacity='0.05' d='M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,213.3C1248,203,1344,213,1392,218.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3Cpath fill='%230d6efd' fill-opacity='0.05' d='M0,96L48,112C96,128,192,160,288,186.7C384,213,480,235,576,213.3C672,192,768,128,864,128C960,128,1056,192,1152,213.3C1248,235,1344,213,1392,202.7L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z'%3E%3C/path%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center bottom;
      opacity: 1;
      pointer-events: none;
    }

    .iso-container {
      max-width: 800px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }

    .iso-header h2 {
      font-size: 2.8rem;
      font-weight: 800;
      color: white;
      margin-bottom: 1rem;
    }
    
    .iso-header h3 {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--newblue);
      margin-bottom: 3rem;
    }

    .iso-logo-container {
      margin-bottom: 40px;
      display: inline-block;
      padding: 20px;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      box-shadow: 0 0 30px rgba(23, 162, 220, 0.5);
      transition: transform 0.3s ease;
    }
    
    .iso-logo-container:hover {
      transform: scale(1.05);
    }

    .iso-logo {
      max-width: 250px;
      height: auto;
      filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.3));
    }

    .iso-description {
      font-size: 1.1rem;
      color: rgba(255, 255, 255, 0.85);
      line-height: 1.8;
      margin-bottom: 40px;
    }

    .iso-btn {
      display: inline-block;
      padding: 15px 35px;
      background: var(--newblue);
      color: white;
      font-weight: 600;
      border-radius: 12px;
      text-decoration: none;
      transition: all 0.3s ease;
      border: none;
      box-shadow: 0 5px 15px rgba(23, 162, 220, 0.4);
    }

    .iso-btn:hover {
      background: var(--newblue2);
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(15, 70, 123, 0.5);
      color: white;
    }

    @media (max-width: 768px) {
      .iso-section {
        padding: 80px 5%;
      }
      .iso-header h2 {
        font-size: 2.2rem;
      }
      .iso-header h3 {
        font-size: 1.3rem;
        margin-bottom: 2rem;
      }
      .iso-logo {
        max-width: 200px;
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

<br><br><br>
<!-- Hero Section -->
<section class="section-white">
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

<!-- ✅ UPGRADED PROJECT GALLERY SECTION -->
<section class="project-gallery-upgraded">
    <div class="container">
        <!-- Header Section -->
        <div class="gallery-header text-center mb-5 fade-in">
            <h1 class="gallery-main-title">Project Gallery</h1>
            <p class="gallery-subtitle">See how we've applied silicone molding and urethane casting across a wide variety of product types—from prototype enclosures to functional end-use parts.</p>
        </div>

        <!-- Gallery Navigation Tabs -->
        <div class="gallery-tabs mb-5 fade-in delay-1">
            <div class="nav nav-pills justify-content-center" id="galleryTab" role="tablist">
                <button class="nav-link active" id="urethane-parts-tab" data-bs-toggle="pill" data-bs-target="#urethane-parts" type="button" role="tab">
                    <i class="fas fa-cube me-2"></i>Urethane Parts
                </button>
                <button class="nav-link" id="overmolding-tab" data-bs-toggle="pill" data-bs-target="#overmolding" type="button" role="tab">
                    <i class="fas fa-layer-group me-2"></i>Urethane Casted Overmolding
                </button>
                <button class="nav-link" id="silicone-molds-tab" data-bs-toggle="pill" data-bs-target="#silicone-molds" type="button" role="tab">
                    <i class="fas fa-flask me-2"></i>Silicone Molds
                </button>
            </div>
        </div>

        <!-- Gallery Content -->
        <div class="tab-content" id="galleryTabContent">
            
            <!-- Urethane Parts Gallery -->
            <div class="tab-pane fade show active" id="urethane-parts" role="tabpanel">
                <div class="gallery-grid">
                    <div class="gallery-item fade-in delay-2">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="<?= base_url('assets_system/images/wheel1.jpg') ?>" alt="Urethane Casted Part" class="gallery-image">
                                <div class="gallery-overlay">
                                    <div class="gallery-actions">
                                        <button class="gallery-btn" onclick="openLightbox('<?= base_url('assets_system/images/wheel1.jpg') ?>', 'Urethane Casted Part')">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button class="gallery-btn" onclick="downloadImage('<?= base_url('assets_system/images/wheel1.jpg') ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="gallery-info">
                                <h4>Precision Gear Component</h4>
                                <p>High-detail urethane casting with tight tolerances</p>
                                <div class="gallery-tags">
                                    <span class="gallery-tag">Automotive</span>
                                    <span class="gallery-tag">±0.1mm</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item fade-in delay-3">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="<?= base_url('assets_system/images/wheel2.jpg') ?>" alt="Urethane Casted Part" class="gallery-image">
                                <div class="gallery-overlay">
                                    <div class="gallery-actions">
                                        <button class="gallery-btn" onclick="openLightbox('<?= base_url('assets_system/images/wheel2.jpg') ?>', 'Urethane Casted Part')">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button class="gallery-btn" onclick="downloadImage('<?= base_url('assets_system/images/wheel2.jpg') ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="gallery-info">
                                <h4>Industrial Housing</h4>
                                <p>Durable enclosure with complex geometry</p>
                                <div class="gallery-tags">
                                    <span class="gallery-tag">Industrial</span>
                                    <span class="gallery-tag">Weatherproof</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="gallery-item fade-in delay-4">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Urethane Casted Part" class="gallery-image">
                                <div class="gallery-overlay">
                                    <div class="gallery-actions">
                                        <button class="gallery-btn" onclick="openLightbox('<?= base_url('assets_system/images/wheel3.jpg') ?>', 'Urethane Casted Part')">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button class="gallery-btn" onclick="downloadImage('<?= base_url('assets_system/images/wheel3.jpg') ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="gallery-info">
                                <h4>Medical Device Component</h4>
                                <p>Biocompatible material with smooth finish</p>
                                <div class="gallery-tags">
                                    <span class="gallery-tag">Medical</span>
                                    <span class="gallery-tag">Class A</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overmolding Gallery -->
            <div class="tab-pane fade" id="overmolding" role="tabpanel">
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="<?= base_url('assets_system/images/wheel3.jpg') ?>" alt="Overmolding Example" class="gallery-image">
                                <div class="gallery-overlay">
                                    <div class="gallery-actions">
                                        <button class="gallery-btn" onclick="openLightbox('<?= base_url('assets_system/images/wheel3.jpg') ?>', 'Overmolding Example')">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button class="gallery-btn" onclick="downloadImage('<?= base_url('assets_system/images/wheel3.jpg') ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="gallery-info">
                                <h4>Tool Handle Overmold</h4>
                                <p>Soft-grip urethane over rigid core</p>
                                <div class="gallery-tags">
                                    <span class="gallery-tag">Ergonomic</span>
                                    <span class="gallery-tag">Dual-material</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add more overmolding items as needed -->
                </div>
            </div>

            <!-- Silicone Molds Gallery -->
            <div class="tab-pane fade" id="silicone-molds" role="tabpanel">
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <div class="gallery-card">
                            <div class="gallery-image-container">
                                <img src="<?= base_url('assets_system/images/wheel2.jpg') ?>" alt="Silicone Mold" class="gallery-image">
                                <div class="gallery-overlay">
                                    <div class="gallery-actions">
                                        <button class="gallery-btn" onclick="openLightbox('<?= base_url('assets_system/images/wheel2.jpg') ?>', 'Silicone Mold')">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button class="gallery-btn" onclick="downloadImage('<?= base_url('assets_system/images/wheel2.jpg') ?>')">
                                            <i class="fas fa-download"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="gallery-info">
                                <h4>High-Detail Silicone Mold</h4>
                                <p>Capturing intricate surface textures</p>
                                <div class="gallery-tags">
                                    <span class="gallery-tag">Fine Detail</span>
                                    <span class="gallery-tag">50+ Parts</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add more silicone mold items as needed -->
                </div>
            </div>
        </div>

        <!-- View More Button -->
        <div class="text-center mt-5 fade-in delay-4">
            <button class="btn btn-outline-light gallery-view-more">
                <i class="fas fa-images me-2"></i>View Complete Portfolio
            </button>
        </div>
    </div>

    <!-- Lightbox Modal -->
    <div class="lightbox-modal" id="lightboxModal">
        <div class="lightbox-content">
            <button class="lightbox-close" onclick="closeLightbox()">
                <i class="fas fa-times"></i>
            </button>
            <button class="lightbox-nav lightbox-prev" onclick="changeLightboxImage(-1)">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="lightbox-nav lightbox-next" onclick="changeLightboxImage(1)">
                <i class="fas fa-chevron-right"></i>
            </button>
            <img id="lightboxImage" src="" alt="">
            <div class="lightbox-caption">
                <h4 id="lightboxTitle"></h4>
            </div>
        </div>
    </div>
</section>

<section class="why-choose-us-section">
    <div class="wcu-container">
        
        <div class="row align-items-center">
            
            <div class="col-lg-7 pe-lg-5">
                <div class="wcu-header fade-in">
                    <span class="text-uppercase fw-bold text-primary mb-2 d-block small">Our Advantage</span>
                    <h2>Why Choose <span class="highlight">Line Seiki?</span></h2>
                    <p class="text-secondary mt-3">Combining Japanese precision engineering with rapid prototyping agility to deliver superior results.</p>
                </div>

                <div class="wcu-grid">
                    <div class="wcu-card fade-in delay-1">
                        <div class="wcu-icon-wrapper">
                            <i class="fa-solid fa-stopwatch"></i>
                        </div>
                        <h3>Fast Turnaround</h3>
                        <p>From master pattern to finished parts in days. We accelerate your time-to-market.</p>
                    </div>

                    <div class="wcu-card fade-in delay-2">
                        <div class="wcu-icon-wrapper">
                            <i class="fa-solid fa-gem"></i>
                        </div>
                        <h3>Injection Quality</h3>
                        <p>Achieve production-grade detail and texture without expensive steel tooling.</p>
                    </div>

                    <div class="wcu-card fade-in delay-3">
                        <div class="wcu-icon-wrapper">
                            <i class="fa-solid fa-piggy-bank"></i>
                        </div>
                        <h3>Cost Efficiency</h3>
                        <p>Silicone molds cost a fraction of metal tooling, making small runs highly profitable.</p>
                    </div>

                    <div class="wcu-card fade-in delay-4">
                        <div class="wcu-icon-wrapper">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <h3>Material Variety</h3>
                        <p>Access a wide range of polymers, rubber-likes, and rigid engineering plastics.</p>
                    </div>
                </div>
            </div>

           <div class="col-lg-5 mb-5 mb-lg-0 fade-in delay-2">
                <div class="wcu-visual-container">
                    
                    <video class="wcu-visual-bg" autoplay muted loop playsinline>
                        <source src="<?= base_url('assets_system/images/Facility Tour.mp4') ?>" type="video/mp4">
                    </video>
                    

                    <div class="wcu-overlay-content">
                        <h4>Precision in Action</h4>
                        <p class="mb-0 text-white-50">See how we transform digital designs into physical reality.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="benefits-section">
    <div class="container">
        <div class="benefits-header fade-in">
            <h2>The Benefits of SMUC</h2>
            <p>Silicone Molding & Urethane Casting (SMUC) bridges the gap between prototyping and mass production.</p>
        </div>
        
        <div class="row g-4">
            
            <div class="col-lg-6 fade-in delay-1">
                <div class="benefit-card-new">
                    <span class="benefit-number">01</span>
                    <div class="benefit-img-box">
                        <img src="<?= base_url('assets_system/images/SMUC2.jpg') ?>" alt="Low Volume Production">
                    </div>
                    <div class="benefit-text">
                        <h4>Low-Volume, High Quality</h4>
                        <p>Whether you need 5 or 100 pieces, benefit
from production-grade look and feel.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 fade-in delay-2">
                <div class="benefit-card-new">
                    <span class="benefit-number">02</span>
                    <div class="benefit-img-box">
                        <img src="<?= base_url('assets_system/images/SMUC3.jpg') ?>" alt="Market Validation">
                    </div>
                    <div class="benefit-text">
                        <h4>Market Validation & Testing</h4>
                        <p>Use realistic parts to conduct user testing,
refine design and iterate before committing to
full production.
</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 fade-in delay-3">
                <div class="benefit-card-new">
                    <span class="benefit-number">03</span>
                    <div class="benefit-img-box">
                        <img src="<?= base_url('assets_system/images/SMUC4.jpg') ?>" alt="Cost Efficiency">
                    </div>
                    <div class="benefit-text">
                        <h4>Cost Efficiency</h4>
                        <p>Avoid high upfront tooling costs and pay
only for what you need, when you need it.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 fade-in delay-4">
                <div class="benefit-card-new">
                    <span class="benefit-number">04</span>
                    <div class="benefit-img-box">
                        <img src="<?= base_url('assets_system/images/SMUC1.jpg') ?>" alt="Rapid Iteration">
                    </div>
                    <div class="benefit-text">
                        <h4>Rapid Iteration</h4>
                        <p>Our process supports quick changes refine
your design and re-cast faster than with
traditional tooling.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="iso-section fade-in">
  <div class="iso-container">
    <div class="iso-header">
      <h2>Our Commitment to Quality</h2>
      <h3>ISO 9001:2015 Certified for Excellence</h3>
    </div>
    
    <div class="iso-logo-container fade-in delay-1">
      <img src="<?= base_url('assets_system/images/ISO-06.png') ?>" alt="ISO 9001:2015 Certified" class="iso-logo">
    </div>
    
    <p class="iso-description fade-in delay-2">
      At Line Seiki Asia Pacific, quality is at the heart of everything we do. Our ISO 9001:2015 certification demonstrates our unwavering commitment to providing products and services that consistently meet customer and regulatory requirements. We are dedicated to continuous improvement, ensuring that our processes are efficient, reliable, and focused on delivering the highest level of satisfaction.
    </p>
    
    <a href="#" class="iso-btn fade-in delay-3">Learn More About Our Quality Standards</a>
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