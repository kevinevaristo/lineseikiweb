<!DOCTYPE html>

<html lang="en">

<head>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Line Seiki Asia Pacific Service</title>



  <!-- Bootstrap 5 CSS -->

  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">



  <!-- Font Awesome -->

  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">



  <!-- Google Fonts -->

  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter-extended.css'); ?>" rel="stylesheet">



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

    left: 50%;

    bottom: -10px;

    width: 60px;

    height: 4px;

    background: linear-gradient(135deg, var(--newblue2), var(--newblue));

    border-radius: 2px;

    transform: translateX(-50%);

}

     

     section p {

       margin-bottom: 28px;

       font-size: 1.1rem;

       color: #495057;

     }



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



    .category img {

     width: 100%;

     height: 220px;

     object-fit: cover;

     display: block;

     transition: opacity 0.4s ease;

    }



    .category:hover img {

     opacity: 0.7;

    }



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

     

     .project-card .form-control {

       border-radius: 8px;

       border: 1px solid #dee2e6;

       padding: 12px 15px;

       font-size: 0.95rem;

       transition: all 0.3s ease;

     }

     

     .project-card .form-control:focus {

       border-color: var(--primary-blue);

       box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);

       outline: none;

     }

     

     #form-message {

       padding: 15px;

       border-radius: 8px;

       font-weight: 500;

     }

     

     #form-message.success {

       background: #d4edda;

       color: #155724;

       border: 1px solid #c3e6cb;

     }

     

     #form-message.error {

       background: #f8d7da;

       color: #721c24;

       border: 1px solid #f5c6cb;

     }



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

     

     @media (max-width: 992px) {

       section { padding: 80px 0; }

       section h1 { font-size: 2.4rem; }

       section h2 { font-size: 2rem; }

       .hero-content h1 { font-size: 2.5rem; }

       .dropdown-submenu > .dropdown-menu { left: 0; margin-top: 0; }

       footer .links a { display: inline-block; margin-bottom: 12px; }

       .categories { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); }

       .case-grid { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }

     }

     

     @media (max-width: 768px) {

       section h1 { font-size: 2rem; }

       section h2 { font-size: 1.8rem; }

       .hero-content { left: 5%; text-align: center; width: 90%; }

       .hero-content h1 { font-size: 2rem; }

       footer .links a { display: block; margin-bottom: 12px; }

     }



    * {

     box-shadow: none !important;

     text-shadow: none !important;

    }



        .callout-row {

            position: relative;

            display: flex;

            flex-direction: column;

            align-items: center;

            justify-content: center;

            gap: 3rem;

        }

        

        .callout-box {

            width: 100%;

            text-align: left;

            order: 2;

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



        .illustration-center {

            width: 100%;

            max-width: 36rem;

            margin: 0 auto;

            height: 24rem;

            position: relative;

            display: flex;

            justify-content: center;

            align-items: center;

            order: 1;

        }



        .illustration-image {

            max-width: 100%;

            height: auto;

            object-fit: contain;

            position: absolute;

            left: 50%;

            transform: translateX(-50%);

        }

        

        .illustration-image:nth-child(1) { z-index: 10; top: 0rem; }

        .illustration-image:nth-child(2) { z-index: 20; top: 10rem; }

        .illustration-image:nth-child(3) { z-index: 0; top: 17rem; }



        .rotated-line {

            position: absolute;

            transform-origin: 0 0;

        }



        .rotated-line-left {

            width: 9rem;

            height: 1px;

            background-color: var(--primary-blue);

        }



        .rotated-line-right {

            width: 12rem;

            height: 1px;

            background-color: var(--primary-blue);

        }



        .rotated-dot {

            width: 0.5rem;

            height: 0.5rem;

            border-radius: 50%;

            background-color: var(--primary-blue);

            position: absolute;

            top: 50%;

            transform: translateY(-50%);

        }

        

.illustration-center {

    --close-amount: 0;

    position: relative;

    display: flex;

    flex-direction: column;

    align-items: center;

    transition: all 1s ease-out;

    perspective: 1000px;

}



.illustration-image {

    max-width: 100%;

    height: auto;

    object-fit: contain;

    position: absolute;

    left: 50%;

    transform: translateX(-50%);

    transition: all 0.3s ease-out;

    filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.2));

    will-change: transform, top, opacity;

}



.illustration-image:nth-child(1) { 

    z-index: 30;

    top: calc(0rem + (2rem - 0rem) * var(--close-amount));

    opacity: calc(1 - 0.6 * var(--close-amount));

    transform: translateX(-50%) 

               scale(calc(1 - 0.3 * var(--close-amount))) 

               rotate(calc(-3deg * var(--close-amount)));

}



.illustration-image:nth-child(2) { 

    z-index: 20;

    top: calc(10rem + (6rem - 10rem) * var(--close-amount));

    opacity: calc(1 - 0.3 * var(--close-amount));

    transform: translateX(-50%) 

               scale(calc(1 - 0.15 * var(--close-amount))) 

               rotate(calc(0deg * var(--close-amount)));

}



.illustration-image:nth-child(3) { 

    z-index: 10;

    top: calc(17rem + (10rem - 17rem) * var(--close-amount));

    opacity: calc(1 - 0 * var(--close-amount));

    transform: translateX(-50%) 

               scale(calc(1 - 0.05 * var(--close-amount))) 

               rotate(calc(3deg * var(--close-amount)));

}



.callout-lines-container {

    opacity: calc(1 - var(--close-amount));

    visibility: visible;

    transition: opacity 0.3s ease;

}



.callout-lines-container.hidden {

    visibility: hidden;

}



        @media (min-width: 768px) {

            .callout-row {

                flex-direction: row;

                gap: 3rem;

            }



            .left-callout-box {

                width: 33.3333%;

                order: 1;

                align-self: flex-start;

                margin-top: 4rem;

                text-align: right;

                padding-right: 3rem;

            }



            .right-callout-box {

                width: 33.3333%;

                order: 3;

                align-self: flex-start;

                margin-top: 10rem;

                padding-left: 3rem;

            }



            .callout-lines-container {

                display: block !important;

            }



            .rotated-line-left {

                top: 13rem;

                left: -4rem;

                transform: rotate(-10deg);

            }

            .rotated-line-left .rotated-dot {

                right: 0;

                transform: translate(50%, -50%);

            }



            .rotated-line-right {

                top: 21rem;

                right: -3.5rem;

                transform: rotate(5deg);

            }

            .rotated-line-right .rotated-dot {

                left: 0;

                transform: translate(-50%, -50%);

            }

        }

         .main-wrapper {

            max-width: 80rem;

            margin: 0 auto;

        }



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



        .main-heading::after {

            display: none;

        }

        

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

         url("<?= base_url('assets_system/images/' . $content['hero_bg_img']['image']) ?>");

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



    .case-studies.section-white {

     background: var(--light-blue) !important;

    }



    .case-studies.section-white::before {

     display: none !important;

    }



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



    .process-box h2 {

     font-size: 2.5rem;

     color: var(--primary-blue);

     margin-bottom: 1.25rem;

    }



    .process-box p {

     font-size: 1.2rem;

     color: var(--gray-700);

     line-height: 1.75;

     margin-bottom: 1.75rem;

     max-width: 95%;

    }



    .process-box h3 {

     font-size: 1.2rem;

     font-weight: 700;

     color: var(--gray-700);

     margin-bottom: 0.75rem;

    }



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



    .process-line {

     flex: 0 0 60px;

     height: 3px;

     background-color: #3fb4f9;

     align-self: center;

     margin: 2.5rem 0;

    }



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



    .carousel-prev { left: 15px; }

    .carousel-next { right: 15px; }



    .carousel-btn i {

     font-size: 1.2rem;

     color: #0b3a67;

    }



    @media (max-width: 992px) {

     .carousel-slide { flex: 0 0 50%; }

     .carousel-slide img { height: 250px; }

    }



    @media (max-width: 768px) {

     .carousel-slide { flex: 0 0 100%; }

     .carousel-slide img { height: 200px; }

     .carousel-btn { width: 40px; height: 40px; }

     .gallery-title { font-size: 1.3rem !important; }

     .project-gallery h1 { font-size: 2.5rem; }

    }



    .why-choose-us-section {

        padding: 100px 5%;

        background-color: #f8faff;

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



    .wcu-card:hover {

        transform: translateY(-8px);

        box-shadow: 0 15px 35px rgba(13, 110, 253, 0.12);

        border-color: rgba(13, 110, 253, 0.3);

    }



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

        background: linear-gradient(to top, rgba(0, 102, 255, 0.9), rgba(255, 255, 255, 0.8));

        padding: 40px 30px;

        color: black;

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

        margin-left: 5px;

    }



    .benefits-section {

        padding: 100px 5%;

        background: radial-gradient(circle at top right, #174a85, #0F467B);

        color: white;

        position: relative;

        overflow: hidden;

    }



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



    .benefit-card-new:hover {

        background: rgba(255, 255, 255, 0.08);

        border-color: rgba(255, 255, 255, 0.3);

        transform: translateY(-5px);

        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);

    }

    

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



    @media (max-width: 992px) {

        .wcu-grid { grid-template-columns: 1fr; }

        .wcu-header h2 { font-size: 2.2rem; }

    }



    @media (max-width: 768px) {

        .benefit-card-new {

            flex-direction: column;

            text-align: center;

            padding: 40px 20px;

        }

        .benefit-img-box { margin-bottom: 15px; width: 120px; height: 120px; }

        .benefit-number { font-size: 4rem; top: 10px; right: 20px; }

        .wcu-header h2 { font-size: 2rem; }

    }



.project-gallery-upgraded {

    padding: 100px 5%;

    background: linear-gradient(135deg, #0F467B 0%, #174a85 50%, #2473bdff 100%);

    color: white;

    position: relative;

    overflow: hidden;

}



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



.gallery-grid {

    display: grid;

    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));

    gap: 30px;

    margin-top: 40px;

}



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



.smaller-hero-image {

    max-width: 85%;

    height: auto;

    display: block;

    margin-left: auto;

}



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



.lightbox-prev { left: -70px; }

.lightbox-next { right: -70px; }



.lightbox-caption {

    position: absolute;

    bottom: -60px;

    left: 0;

    width: 100%;

    text-align: center;

    color: white;

}



@media (max-width: 992px) {

    .gallery-grid { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; }

    .gallery-main-title { font-size: 2.5rem; }

    .lightbox-nav { width: 40px; height: 40px; }

    .lightbox-prev { left: 10px; }

    .lightbox-next { right: 10px; }

}



@media (max-width: 768px) {

    .gallery-grid { grid-template-columns: 1fr; }

    .gallery-main-title { font-size: 2rem; }

    .gallery-tabs .nav-link { padding: 10px 16px; font-size: 0.9rem; }

    .project-gallery-upgraded { padding: 60px 5%; }

}



    /* =========================================

       ISO CERTIFICATION SECTION — REDESIGNED

       Style: Premium White, Gold Spotlight, Logo Hero

       Replaces old dark navy background to make

       the ISO logo truly stand out as a centrepiece

    ========================================= */

    .iso-section {

      padding: 120px 5%;

      position: relative;

      overflow: hidden;

      /* Clean pearl-white base */

      background-color: #fafbff;

      /* Layered soft radial gradients: blue brand corners + warm gold center spotlight */

      background-image:

          radial-gradient(ellipse 80% 60% at 0% 0%,    rgba(23, 162, 220, 0.08) 0%, transparent 60%),

          radial-gradient(ellipse 60% 70% at 50% 55%,  rgba(255, 200, 80, 0.12)  0%, transparent 65%),

          radial-gradient(ellipse 70% 50% at 100% 100%, rgba(15, 70, 123, 0.06) 0%, transparent 60%);

      text-align: center;

    }



    /* Precision dot-grid texture — signals quality & engineering */

    .iso-section::before {

      content: '';

      position: absolute;

      inset: 0;

      background-image: radial-gradient(circle, rgba(15, 70, 123, 0.065) 1px, transparent 1px);

      background-size: 28px 28px;

      pointer-events: none;

      z-index: 0;

    }



    /* Brand-coloured gradient rule at very top of section */

    .iso-section::after {

      content: '';

      position: absolute;

      top: 0;

      left: 0;

      width: 100%;

      height: 5px;

      background: linear-gradient(

        90deg,

        transparent 0%,

        var(--newblue2) 20%,

        var(--newblue) 50%,

        var(--newblue2) 80%,

        transparent 100%

      );

      z-index: 1;

    }



    .iso-container {

      max-width: 800px;

      margin: 0 auto;

      position: relative;

      z-index: 2;

    }



    /* Heading now uses brand navy so it reads clearly on white */

    .iso-header h2 {

      font-size: 2.8rem;

      font-weight: 800;

      color: var(--newblue2);

      margin-bottom: 0.75rem;

    }



    .iso-header h3 {

      font-size: 1.4rem;

      font-weight: 600;

      color: var(--newblue);

      margin-bottom: 3rem;

      letter-spacing: 0.02em;

    }



    /* =============================================

       ISO LOGO — FULLY TRANSPARENT, NO CARD

       ============================================= */

    .iso-logo-container {

      margin-bottom: 44px;

      display: inline-block;

      padding: 0;

      background: transparent;

      border-radius: 0;

      border: none;

      box-shadow: none !important;

      transition: transform 0.35s ease;

      position: relative;

    }



    /* No pseudo-elements needed */

    .iso-logo-container::before,

    .iso-logo-container::after {

      display: none;

    }



    /* Hover: gentle lift only */

    .iso-logo-container:hover {

      transform: translateY(-6px) scale(1.04);

      box-shadow: none !important;

    }



    .iso-logo {

      max-width: 240px;

      height: auto;

      opacity: 1;

      filter: none;

      display: block;

    }



    /* Thin gradient divider between logo card and description text */

    .iso-divider {

      width: 60px;

      height: 3px;

      background: linear-gradient(90deg, var(--newblue2), var(--newblue));

      border-radius: 2px;

      margin: 0 auto 28px;

    }



    /* Description text switches from white to dark for readability on light bg */

    .iso-description {

      font-size: 1.1rem;

      color: #4a5568;

      line-height: 1.85;

      margin-bottom: 40px;

      max-width: 680px;

      margin-left: auto;

      margin-right: auto;

    }



    .iso-btn {

      display: inline-block;

      padding: 15px 35px;

      background: linear-gradient(135deg, var(--newblue2), var(--newblue));

      color: white;

      font-weight: 600;

      border-radius: 12px;

      text-decoration: none;

      transition: all 0.3s ease;

      border: none;

      box-shadow: 0 5px 20px rgba(15, 70, 123, 0.30) !important;

    }



    .iso-btn:hover {

      background: linear-gradient(135deg, var(--newblue), var(--newblue2));

      transform: translateY(-3px);

      box-shadow: 0 10px 28px rgba(15, 70, 123, 0.40) !important;

      color: white;

    }



    @media (max-width: 768px) {

      .iso-section { padding: 80px 5%; }

      .iso-header h2 { font-size: 2.2rem; }

      .iso-header h3 { font-size: 1.3rem; margin-bottom: 2rem; }

      .iso-logo { max-width: 200px; }

      .iso-logo-container { padding: 20px 28px; }

    }



.modern-carousel-wrapper {

    position: relative;

    width: 100%;

    padding: 0 15px;

}



.modern-carousel {

    display: flex;

    overflow-x: auto;

    scroll-behavior: smooth; 

    scroll-snap-type: x mandatory; 

    gap: 30px;

    padding-bottom: 30px;

    padding-top: 10px;

    scrollbar-width: none;

    -ms-overflow-style: none;

}



.modern-carousel::-webkit-scrollbar {

    display: none;

}



.carousel-item-card {

    flex: 0 0 350px;

    width: 350px;

    scroll-snap-align: start;

}



.carousel-nav-btn {

    position: absolute;

    top: 45%;

    transform: translateY(-50%);

    width: 50px;

    height: 50px;

    border-radius: 50%;

    background: white;

    border: 1px solid rgba(13, 110, 253, 0.1);

    color: var(--primary-blue);

    font-size: 1.2rem;

    display: flex;

    align-items: center;

    justify-content: center;

    cursor: pointer;

    z-index: 10;

    box-shadow: 0 4px 15px rgba(0,0,0,0.1);

    transition: all 0.3s ease;

}



.carousel-nav-btn:hover {

    background: var(--primary-blue);

    color: white;

    box-shadow: 0 8px 25px rgba(13, 110, 253, 0.3);

}



.carousel-nav-btn.prev { left: -20px; }

.carousel-nav-btn.next { right: -20px; }



@media (max-width: 768px) {

    .carousel-item-card { flex: 0 0 280px; width: 280px; }

    .carousel-nav-btn { width: 40px; height: 40px; }

    .carousel-nav-btn.prev { left: -10px; }

    .carousel-nav-btn.next { right: -10px; }

}

  </style>

</head>

<body>



 <!-- NAVBAR -->
<?php $this->load->view('web/header'); ?>



<br><br><br>



<section class="section-white">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-6 fade-in">

                <h1><?= isset($content['hero_title']['content']) ? strip_tags($content['hero_title']['content']) : 'Production Quality <br>at Low Volumes' ?></h1>

                <p><?= isset($content['hero_description']['content']) ? $content['hero_description']['content'] : 'Get full-scale aesthetics and performance without fullscale tooling. Silicone Molding and Urethane Casting deliver production-grade parts for concept, validation and low-volume runs.' ?></p>

                <a href="#consultation" class="consultation-btn"><?= isset($content['hero_button']['content']) ? htmlspecialchars($content['hero_button']['content']) : 'Request a Quote' ?></a>

            </div>

            <div class="col-lg-6 fade-in delay-1 d-flex align-items-center justify-content-center">

    <div style="width: 130%;">

        <img src="<?= base_url('assets_system/images/' . (isset($content['hero_image']['image']) ? $content['hero_image']['image'] : 'sm4.png')) ?>" 

             alt="Simulation Analysis"

             style="width: 100%; height: auto;">

    </div>

</div>

        </div>

    </div>

</section>



<div class="main-wrapper">

 <section id="our-process-section">

        <div class="text-center">

            <h1 class="main-heading">

                <?= isset($content['what_we_do_title']['content']) ? htmlspecialchars($content['what_we_do_title']['content']) : 'WHAT DO WE DO' ?>

            </h1>

            <p class="sub-heading">

                <?= isset($content['what_we_do_subtitle']['content']) ? $content['what_we_do_subtitle']['content'] : 'Precision-crafted parts through Silicone Molding and Urethane Casting.' ?>

            </p>

        </div>



        <div class="callout-row">

            

            <div class="callout-box left-callout-box">

                <div id="callout-left">

                    <br><br><br><h3><?= isset($content['silicone_mold_title']['content']) ? htmlspecialchars($content['silicone_mold_title']['content']) : 'Silicone Mold' ?></h3>

                    <p><?= isset($content['silicone_mold_description']['content']) ? $content['silicone_mold_description']['content'] : 'Flexible, high-detail molds that capture even the most intricate surface textures.' ?></p>

                </div>

            </div>



            <div id="illustration-center" class="illustration-center">

                

                <img src="<?= base_url('assets_system/images/' . (isset($content['illustration_top_mold']['image']) ? $content['illustration_top_mold']['image'] : 'sm1.png')) ?>" 

                     alt="Top half of the silicone mold" 

                     class="illustration-image">



                <img src="<?= base_url('assets_system/images/' . (isset($content['illustration_internal_part']['image']) ? $content['illustration_internal_part']['image'] : 'sm2.png')) ?>" 

                     alt="The finished urethane part" 

                     class="illustration-image">



                <img src="<?= base_url('assets_system/images/' . (isset($content['illustration_bottom_mold']['image']) ? $content['illustration_bottom_mold']['image'] : 'sm3.png')) ?>" 

                     alt="Bottom half of the silicone mold" 

                     class="illustration-image">



                <div class="callout-lines-container hidden">

                    

                    <div class="rotated-line rotated-line-left">

                        <div class="rotated-dot"></div>

                    </div>



                    <div class="rotated-line rotated-line-right">

                        <div class="rotated-dot"></div>

                    </div>

                </div>



            </div>

            

            <div class="callout-box right-callout-box">

                <div id="callout-right">

                    <br><br><br><br><br><br><h3><?= isset($content['urethane_part_title']['content']) ? htmlspecialchars($content['urethane_part_title']['content']) : 'Urethane Part' ?></h3>

                    <p><?= isset($content['urethane_part_description']['content']) ? $content['urethane_part_description']['content'] : 'Durable, functional, and production-grade.' ?></p>

                </div>

            </div>



        </div>

     </section>

    </div>

<br><br><br><br>

<section id="molding-casting-section">

  <div class="container molding-casting">

    <div class="process-box">

      <h2><?= isset($content['silicone_molding_title']['content']) ? htmlspecialchars($content['silicone_molding_title']['content']) : 'Silicone Molding' ?></h2>

      <p>

        <?= isset($content['silicone_molding_content']['content']) ? $content['silicone_molding_content']['content'] : 'Silicone molding—also known as Room Temperature Vulcanizing (RTV) molding—uses a flexible silicone mold to reproduce parts with exceptional surface detail and accuracy. It\'s the ideal process for creating small-batch or low-volume parts without the high investment cost of injection molding or press dies.' ?>

      </p>

      <?php if (isset($content['silicone_molding_features_title']['content'])): ?>

      <h3><?= htmlspecialchars($content['silicone_molding_features_title']['content']) ?></h3>

      <?php endif; ?>

      <ul>

        <?php 

        $silicone_features = [];

        foreach ($content as $key => $item) {

            if (strpos($key, 'silicone_molding_feature_') === 0 && isset($item['content']) && !empty(trim($item['content']))) {

                $number = intval(str_replace('silicone_molding_feature_', '', $key));

                $silicone_features[$number] = $item['content'];

            }

        }

        ksort($silicone_features);

        if (!empty($silicone_features)):

            foreach ($silicone_features as $feature_content):

        ?>

        <li><?= htmlspecialchars($feature_content) ?></li>

        <?php 

            endforeach;

        else:

            for ($i = 1; $i <= 5; $i++):

                if (isset($content['silicone_molding_feature_' . $i]['content']) && !empty(trim($content['silicone_molding_feature_' . $i]['content']))):

        ?>

        <li><?= htmlspecialchars($content['silicone_molding_feature_' . $i]['content']) ?></li>

        <?php 

                endif;

            endfor;

        endif;

        ?>

      </ul>

    </div>



    <div class="process-box">

      <h2><?= isset($content['urethane_casting_title']['content']) ? htmlspecialchars($content['urethane_casting_title']['content']) : 'Urethane Casting' ?></h2>

      <p>

        <?= isset($content['urethane_casting_content']['content']) ? $content['urethane_casting_content']['content'] : 'Urethane casting uses thermosetting polyurethane resins—similar to epoxy—to produce multiple copies of your master model. Combined with silicone molds, this process delivers high-detail prototypes and functional parts that can match the look, feel, and performance of injection-molded products.' ?>

      </p>

      <?php if (isset($content['urethane_casting_features_title']['content'])): ?>

      <h3><?= htmlspecialchars($content['urethane_casting_features_title']['content']) ?></h3>

      <?php endif; ?>

      <ul>

        <?php 

        $urethane_features = [];

        foreach ($content as $key => $item) {

            if (strpos($key, 'urethane_casting_feature_') === 0 && isset($item['content']) && !empty(trim($item['content']))) {

                $number = intval(str_replace('urethane_casting_feature_', '', $key));

                $urethane_features[$number] = $item['content'];

            }

        }

        ksort($urethane_features);

        if (!empty($urethane_features)):

            foreach ($urethane_features as $feature_content):

        ?>

        <li><?= htmlspecialchars($feature_content) ?></li>

        <?php 

            endforeach;

        else:

            for ($i = 1; $i <= 8; $i++):

                if (isset($content['urethane_casting_feature_' . $i]['content']) && !empty(trim($content['urethane_casting_feature_' . $i]['content']))):

        ?>

        <li><?= htmlspecialchars($content['urethane_casting_feature_' . $i]['content']) ?></li>

        <?php 

                endif;

            endfor;

        endif;

        ?>

      </ul>

    </div>

  </div>

</section>



<section id="process-section">

  <div class="container">

    <div class="process-flow">

      <?php for ($i = 1; $i <= 4; $i++): ?>

      <?php if ($i > 1): ?>

      <div class="process-line"></div>

      <?php endif; ?>

      

      <div class="process-step">

        <img src="<?= base_url('assets_system/images/' . (isset($content['process_step_' . $i . '_image']['image']) ? $content['process_step_' . $i . '_image']['image'] : 'sm' . ($i+5) . '.png')) ?>" 

             alt="<?= isset($content['process_step_' . $i . '_title']['content']) ? htmlspecialchars($content['process_step_' . $i . '_title']['content']) : '' ?>">

        <h3><?= isset($content['process_step_' . $i . '_title']['content']) ? htmlspecialchars($content['process_step_' . $i . '_title']['content']) : '' ?></h3>

        <p><?= isset($content['process_step_' . $i . '_description']['content']) ? $content['process_step_' . $i . '_description']['content'] : '' ?></p>

      </div>

      <?php endfor; ?>

    </div>

  </div>

</section>



<!-- ✅ UPGRADED PROJECT GALLERY SECTION -->

<section class="project-gallery-upgraded">

    <div class="container">

        <div class="gallery-header text-center mb-5 fade-in">

            <h1 class="gallery-main-title"><?= isset($content['gallery_title']['content']) ? htmlspecialchars($content['gallery_title']['content']) : 'Project Gallery' ?></h1>

            <p class="gallery-subtitle"><?= isset($content['gallery_subtitle']['content']) ? $content['gallery_subtitle']['content'] : 'Swipe or click to explore our silicone molding and urethane casting projects.' ?></p>

        </div>



        <div class="gallery-tabs mb-5 fade-in delay-1">

            <div class="nav nav-pills justify-content-center" id="galleryTab" role="tablist">

                <button class="nav-link active" id="urethane-parts-tab" data-bs-toggle="pill" data-bs-target="#urethane-parts" type="button" role="tab">

                    <i class="fas fa-cube me-2"></i><?= isset($content['gallery_tab_1']['content']) ? htmlspecialchars($content['gallery_tab_1']['content']) : 'Urethane Casted Parts' ?> (<?= count($gallery_urethane) ?>)

                </button>

                <button class="nav-link" id="overmolding-tab" data-bs-toggle="pill" data-bs-target="#overmolding" type="button" role="tab">

                    <i class="fas fa-layer-group me-2"></i><?= isset($content['gallery_tab_2']['content']) ? htmlspecialchars($content['gallery_tab_2']['content']) : 'Urethane Casted Overmolding' ?> (<?= count($gallery_overmolding) ?>)

                </button>

            </div>

        </div>



        <div class="tab-content fade-in delay-2" id="galleryTabContent">

            

            <div class="tab-pane fade show active" id="urethane-parts" role="tabpanel">

                <?php if (!empty($gallery_urethane)): ?>

                <div class="modern-carousel-wrapper">

                    <button class="carousel-nav-btn prev" onclick="scrollCarousel('urethane-slider', -1)"><i class="fas fa-chevron-left"></i></button>

                    <button class="carousel-nav-btn next" onclick="scrollCarousel('urethane-slider', 1)"><i class="fas fa-chevron-right"></i></button>

                    

                    <div class="modern-carousel" id="urethane-slider">

                        

                        <?php foreach ($gallery_urethane as $index => $item): ?>

                        <div class="carousel-item-card">

                            <div class="gallery-card">

                                <div class="gallery-image-container">

                                    <img src="<?= base_url('assets_system/images/' . htmlspecialchars($item->image)) ?>" 

                                         alt="<?= htmlspecialchars($item->title) ?>" 

                                         class="gallery-image"

                                         loading="lazy">

                                    <div class="gallery-overlay">

                                        <div class="gallery-actions">

                                            <button class="gallery-btn" 

                                                    onclick="openLightbox('<?= base_url('assets_system/images/' . htmlspecialchars($item->image)) ?>', 

                                                    '<?= htmlspecialchars($item->title) ?>')">

                                                <i class="fas fa-expand"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <div class="gallery-info">

                                    <h4><?= htmlspecialchars($item->title) ?></h4>

                                    <p><?= htmlspecialchars($item->description) ?></p>

                                    <?php if (!empty($item->tags)): ?>

                                    <div class="gallery-tags">

                                        <?php 

                                        $tags = explode(',', $item->tags);

                                        foreach ($tags as $tag):

                                            $trimmedTag = trim($tag);

                                            if (!empty($trimmedTag)):

                                        ?>

                                        <span class="gallery-tag"><?= htmlspecialchars($trimmedTag) ?></span>

                                        <?php 

                                            endif;

                                        endforeach; 

                                        ?>

                                    </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                        <?php endforeach; ?>



                    </div>

                </div>

                <?php else: ?>

                <div class="text-center py-5">

                    <div class="empty-gallery-message">

                        <i class="fas fa-images fa-3x mb-3 text-muted"></i>

                        <h5>No Urethane Parts Available</h5>

                        <p class="text-muted">No gallery items have been added yet.</p>

                    </div>

                </div>

                <?php endif; ?>

            </div>



            <div class="tab-pane fade" id="overmolding" role="tabpanel">

                <?php if (!empty($gallery_overmolding)): ?>

                <div class="modern-carousel-wrapper">

                    <button class="carousel-nav-btn prev" onclick="scrollCarousel('overmold-slider', -1)"><i class="fas fa-chevron-left"></i></button>

                    <button class="carousel-nav-btn next" onclick="scrollCarousel('overmold-slider', 1)"><i class="fas fa-chevron-right"></i></button>

                    

                    <div class="modern-carousel" id="overmold-slider">

                        

                        <?php foreach ($gallery_overmolding as $index => $item): ?>

                        <div class="carousel-item-card">

                            <div class="gallery-card">

                                <div class="gallery-image-container">

                                    <img src="<?= base_url('assets_system/images/' . htmlspecialchars($item->image)) ?>" 

                                         alt="<?= htmlspecialchars($item->title) ?>" 

                                         class="gallery-image"

                                         loading="lazy">

                                    <div class="gallery-overlay">

                                        <div class="gallery-actions">

                                            <button class="gallery-btn" 

                                                    onclick="openLightbox('<?= base_url('assets_system/images/' . htmlspecialchars($item->image)) ?>', 

                                                    '<?= htmlspecialchars($item->title) ?>')">

                                                <i class="fas fa-expand"></i>

                                            </button>

                                        </div>

                                    </div>

                                </div>

                                <div class="gallery-info">

                                    <h4><?= htmlspecialchars($item->title) ?></h4>

                                    <p><?= htmlspecialchars($item->description) ?></p>

                                    <?php if (!empty($item->tags)): ?>

                                    <div class="gallery-tags">

                                        <?php 

                                        $tags = explode(',', $item->tags);

                                        foreach ($tags as $tag):

                                            $trimmedTag = trim($tag);

                                            if (!empty($trimmedTag)):

                                        ?>

                                        <span class="gallery-tag"><?= htmlspecialchars($trimmedTag) ?></span>

                                        <?php 

                                            endif;

                                        endforeach; 

                                        ?>

                                    </div>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                        <?php endforeach; ?>



                    </div>

                </div>

                <?php else: ?>

                <div class="text-center py-5">

                    <div class="empty-gallery-message">

                        <i class="fas fa-layer-group fa-3x mb-3 text-muted"></i>

                        <h5>No Overmolding Items Available</h5>

                        <p class="text-muted">No overmolding gallery items have been added yet.</p>

                    </div>

                </div>

                <?php endif; ?>

            </div>



        </div>

    </div>



    <div class="lightbox-modal" id="lightboxModal">

        <div class="lightbox-content">

            <button class="lightbox-close" onclick="closeLightbox()"><i class="fas fa-times"></i></button>

            <img id="lightboxImage" src="" alt="">

            <div class="lightbox-caption"><h4 id="lightboxTitle"></h4></div>

        </div>

    </div>

</section>





<section class="why-choose-us-section">

    <div class="wcu-container">

        

        <div class="row align-items-center">

            

            <div class="col-lg-7 pe-lg-5">

                <div class="wcu-header fade-in">

                    <span class="text-uppercase fw-bold text-primary mb-2 d-block small"><?= isset($content['wcu_subtitle']['content']) ? htmlspecialchars($content['wcu_subtitle']['content']) : 'Our Advantage' ?></span>

                    <h2><?= isset($content['wcu_title']['content']) ? str_replace('Line Seiki?', '<span class="highlight">Line Seiki?</span>', htmlspecialchars($content['wcu_title']['content'])) : 'Why Choose <span class="highlight">Line Seiki?</span>' ?></h2>

                    <p class="text-secondary mt-3"><?= isset($content['wcu_description']['content']) ? $content['wcu_description']['content'] : 'Combining Japanese precision engineering with rapid prototyping agility to deliver superior results.' ?></p>

                </div>



                <div class="wcu-grid">

                    <?php for ($i = 1; $i <= 4; $i++): ?>

                    <div class="wcu-card fade-in delay-<?= $i ?>">

                        <div class="wcu-icon-wrapper">

                            <i class="fa-solid <?= 

                                $i == 1 ? 'fa-stopwatch' : 

                                ($i == 2 ? 'fa-gem' : 

                                ($i == 3 ? 'fa-piggy-bank' : 'fa-layer-group')) 

                            ?>"></i>

                        </div>

                        <h3><?= isset($content['wcu_card_' . $i . '_title']['content']) ? htmlspecialchars($content['wcu_card_' . $i . '_title']['content']) : '' ?></h3>

                        <p><?= isset($content['wcu_card_' . $i . '_description']['content']) ? $content['wcu_card_' . $i . '_description']['content'] : '' ?></p>

                    </div>

                    <?php endfor; ?>

                </div>

            </div>



           <div class="col-lg-5 mb-5 mb-lg-0 fade-in delay-2">

                <div class="wcu-visual-container">

                    

                    <?php if (isset($content['wcu_video']['image'])): ?>

                    <video class="wcu-visual-bg" autoplay muted loop playsinline>

                        <source src="<?= base_url('assets_system/images/' . $content['wcu_video']['image']) ?>" type="video/mp4">

                    </video>

                    <?php else: ?>

                    <video class="wcu-visual-bg" autoplay muted loop playsinline>

                        <source src="<?= base_url('assets_system/images/Facility Tour.mp4') ?>" type="video/mp4">

                    </video>

                    <?php endif; ?>

                    



                    <div class="wcu-overlay-content">

                       <?php echo '<h4>' . $content['video_text_header']['content'] . '</h4>'; ?>

                        <p class="mb-0 text-black">

                            <?= htmlspecialchars($content['video_text_sub']['content']); ?>

                        </p>

                    </div>

                </div>

            </div>



        </div>

    </div>

</section>



<section class="benefits-section">

    <div class="container">

        <div class="benefits-header fade-in">

            <h2><?= isset($content['benefits_title']['content']) ? htmlspecialchars($content['benefits_title']['content']) : 'The Benefits of SMUC' ?></h2>

            <p><?= isset($content['benefits_subtitle']['content']) ? $content['benefits_subtitle']['content'] : 'Silicone Molding & Urethane Casting (SMUC) bridges the gap between prototyping and mass production.' ?></p>

        </div>

        

        <div class="row g-4">

            

            <?php for ($i = 1; $i <= 4; $i++): ?>

            <div class="col-lg-6 fade-in delay-<?= $i ?>">

                <div class="benefit-card-new">

                    <span class="benefit-number"><?= isset($content['benefit_' . $i . '_number']['content']) ? htmlspecialchars($content['benefit_' . $i . '_number']['content']) : sprintf('%02d', $i) ?></span>

                    <div class="benefit-img-box">

                        <img src="<?= base_url('assets_system/images/' . (isset($content['benefit_' . $i . '_image']['image']) ? $content['benefit_' . $i . '_image']['image'] : 'SMUC' . $i . '.jpg')) ?>" 

                             alt="<?= isset($content['benefit_' . $i . '_title']['content']) ? htmlspecialchars($content['benefit_' . $i . '_title']['content']) : '' ?>">

                    </div>

                    <div class="benefit-text">

                        <h4><?= isset($content['benefit_' . $i . '_title']['content']) ? htmlspecialchars($content['benefit_' . $i . '_title']['content']) : '' ?></h4>

                        <p><?= isset($content['benefit_' . $i . '_description']['content']) ? $content['benefit_' . $i . '_description']['content'] : '' ?></p>

                    </div>

                </div>

            </div>

            <?php endfor; ?>



        </div>

    </div>

</section>



<!-- ✅ ISO CERTIFICATION SECTION — REDESIGNED

     Background: Pearl white + warm gold spotlight center

     The ISO logo is now the clear hero of this section.

-->

<section class="iso-section">

  <div class="iso-container">

    <div class="iso-header">

      <h2><?= isset($content['iso_title']['content']) ? htmlspecialchars($content['iso_title']['content']) : 'Our Commitment to Quality' ?></h2>

      <h3><?= isset($content['iso_subtitle']['content']) ? htmlspecialchars($content['iso_subtitle']['content']) : 'ISO 9001:2015 Certified for Excellence' ?></h3>

    </div>



    <!-- Gold spotlight card wrapping the logo -->

    <div class="iso-logo-container delay-1">

      <img src="<?= base_url('assets_system/images/' . (isset($content['iso_image']['image']) ? $content['iso_image']['image'] : 'ISO-06.png')) ?>"

           alt="ISO 9001:2015 Certified" class="iso-logo">

    </div>



    <!-- Gradient divider -->

    <div class="iso-divider"></div>



    <p class="iso-description fade-in delay-2">

      <?= isset($content['iso_description']['content']) ? $content['iso_description']['content'] : 'At Line Seiki Asia Pacific, quality is at the heart of everything we do. Our ISO 9001:2015 certification demonstrates our unwavering commitment to providing products and services that consistently meet customer and regulatory requirements. We are dedicated to continuous improvement, ensuring that our processes are efficient, reliable, and focused on delivering the highest level of satisfaction.' ?>

    </p>



    <!--<a href="#" class="iso-btn fade-in delay-3"><?= isset($content['iso_button']['content']) ? htmlspecialchars($content['iso_button']['content']) : 'Learn More About Our Quality Standards' ?></a>-->

  </div>

</section>



<!-- ✅ Project Submission Section -->

<section class="project-submission">

  <div class="project-card fade-in">

    <div class="icon">

      <i class="fas fa-file-upload"></i>

    </div>

    <h4><?= isset($content['project_submission_title']['content']) ? htmlspecialchars($content['project_submission_title']['content']) : 'Project Submission' ?></h4>

    <p><?= isset($content['project_submission_description']['content']) ? $content['project_submission_description']['content'] : 'Upload your CAD models or design drawings to receive a detailed quote.' ?></p>

    

    <form id="quote-form" method="post" enctype="multipart/form-data" action="<?= base_url('index/submit_quote_request') ?>">

      <div class="mb-3">

        <input type="text" class="form-control" name="name" placeholder="Full Name" required>

      </div>

      <div class="mb-3">

        <input type="email" class="form-control" name="email" placeholder="Email Address" required>

      </div>

      <div class="mb-3">

        <input type="text" class="form-control" name="contact_number" placeholder="Contact Number" required>

      </div>

      <div class="mb-3">

        <input type="text" class="form-control" name="company_name" placeholder="Company Name" required>

      </div>

      <label for="file-upload" class="btn btn-outline-primary">

        <i class="fas fa-paperclip me-2"></i> Select File

      </label>

      <input id="file-upload" name="project_file" type="file" hidden>

      <div id="file-name" class="file-name">No file selected</div>

      <button type="submit" class="btn btn-success"><?= isset($content['project_submission_button']['content']) ? htmlspecialchars($content['project_submission_button']['content']) : 'Request Quote' ?></button>

    </form>

    

    <div id="form-message" class="mt-3" style="display: none;"></div>

  </div>

</section>



<?php if (isset($testimonials) && !empty($testimonials)): ?>

<section class="testimonial-section">

    <div class="testimonial-container">

        <h2 class="testimonial-title fade-in">What Our Clients Say</h2>

        <div class="testimonial-grid">

            <?php foreach ($testimonials as $index => $testimonial): 

                $delay = $index == 0 ? 'fade-in' : ($index == 1 ? 'fade-in delay-1' : ($index == 2 ? 'fade-in delay-2' : 'fade-in delay-3'));

                $avatar_image = !empty($testimonial->image) ? base_url('assets_system/images/' . $testimonial->image) : null;

                $initial = strtoupper(substr($testimonial->name, 0, 1));

            ?>

            <div class="testimonial-card <?= $delay ?>">

                <div class="testimonial-card-content">

                    <i class="bi bi-quote quote-icon"></i>

                    <p class="testimonial-text"><?= htmlspecialchars($testimonial->content) ?></p>

                    <div class="testimonial-author">

                        <div class="author-avatar-large">

                            <?php if ($avatar_image): ?>

                                <img src="<?= $avatar_image ?>" alt="<?= htmlspecialchars($testimonial->name) ?>">

                            <?php else: ?>

                                <span class="initials-large"><?= $initial ?></span>

                            <?php endif; ?>

                        </div>

                        <div class="author-info">

                            <h6><?= htmlspecialchars($testimonial->name) ?></h6>

                            <p><?= htmlspecialchars($testimonial->position) ?></p>

                        </div>

                    </div>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

</section>



<style>

.testimonial-section {

    padding: 80px 0;

    background: var(--light-blue);

    position: relative;

    overflow: hidden;

}



.testimonial-container {

    max-width: 1200px;

    margin: 0 auto;

    padding: 0 20px;

}



.testimonial-title {

    text-align: center;

    margin-bottom: 60px;

    color: var(--primary-blue);

    font-weight: 700;

    font-size: 2.5rem;

    position: relative;

}



.testimonial-title::after {

    content: '';

    position: absolute;

    left: 50%;

    bottom: -15px;

    transform: translateX(-50%);

    width: 80px;

    height: 4px;

    background: linear-gradient(90deg, var(--newblue), var(--primary-blue));

    border-radius: 2px;

}



.testimonial-grid {

    display: grid;

    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));

    gap: 30px;

    align-items: stretch;

}



.testimonial-card {

    background: white;

    border-radius: 20px;

    padding: 0;

    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);

    transition: var(--transition);

    border: 1px solid rgba(13, 110, 253, 0.1);

    position: relative;

    display: flex;

    height: 100%;

}



.testimonial-card-content {

    display: flex;

    flex-direction: column;

    padding: 35px 30px;

    width: 100%;

    position: relative;

}



.testimonial-card:hover {

    transform: translateY(-10px);

    box-shadow: 0 20px 40px rgba(13, 110, 253, 0.15);

    border-color: rgba(13, 110, 253, 0.2);

}



.quote-icon {

    color: var(--primary-blue);

    font-size: 2.5rem;

    opacity: 0.15;

    position: absolute;

    top: 25px;

    right: 30px;

    z-index: 1;

}



.testimonial-text {

    font-size: 1rem;

    line-height: 1.7;

    color: #495057;

    margin-bottom: 25px;

    font-style: italic;

    flex: 1;

    min-height: 100px;

    position: relative;

    z-index: 2;

}



.testimonial-author {

    display: flex;

    align-items: center;

    gap: 20px;

    margin-top: auto;

    padding-top: 15px;

    border-top: 1px solid rgba(13, 110, 253, 0.1);

    position: relative;

    z-index: 2;

}



.author-avatar-large {

    width: 100px;

    height: 100px;

    border-radius: 50%;

    background: linear-gradient(135deg, var(--newblue), var(--primary-blue));

    display: flex;

    align-items: center;

    justify-content: center;

    color: white;

    font-size: 2.5rem;

    font-weight: 600;

    flex-shrink: 0;

    overflow: hidden;

    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);

    border: 3px solid white;

    transition: var(--transition);

}



.author-avatar-large img {

    width: 100%;

    height: 100%;

    object-fit: cover;

    border-radius: 50%;

}



.author-avatar-large:hover {

    transform: scale(1.05);

    box-shadow: 0 6px 16px rgba(13, 110, 253, 0.4);

}



.initials-large {

    font-size: 2.5rem;

    font-weight: 600;

    color: white;

}



.author-info {

    flex: 1;

    min-width: 0;

}



.author-info h6 {

    font-size: 1.2rem;

    margin-bottom: 5px;

    color: var(--primary-blue);

    font-weight: 700;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}



.author-info p {

    font-size: 0.95rem;

    color: #6c757d;

    margin-bottom: 0;

    white-space: nowrap;

    overflow: hidden;

    text-overflow: ellipsis;

}



@media (max-width: 991px) {

    .testimonial-grid { grid-template-columns: repeat(2, 1fr); }

    .testimonial-card-content { padding: 30px 25px; }

    .author-avatar-large { width: 90px; height: 90px; font-size: 2.2rem; }

    .initials-large { font-size: 2.2rem; }

}



@media (max-width: 767px) {

    .testimonial-grid { grid-template-columns: 1fr; gap: 25px; }

    .testimonial-card-content { padding: 25px 20px; }

    .author-avatar-large { width: 80px; height: 80px; font-size: 2rem; }

    .initials-large { font-size: 2rem; }

    .testimonial-author { gap: 15px; }

    .author-info h6 { font-size: 1.1rem; }

    .author-info p { font-size: 0.9rem; }

}



@media (max-width: 575px) {

    .testimonial-section { padding: 60px 0; }

    .testimonial-title { font-size: 2rem; margin-bottom: 40px; }

    .testimonial-card-content { padding: 20px 15px; }

    .author-avatar-large { width: 70px; height: 70px; font-size: 1.8rem; }

    .initials-large { font-size: 1.8rem; }

    .testimonial-author { gap: 12px; }

    .quote-icon { font-size: 2rem; top: 15px; right: 20px; }

    .testimonial-text { font-size: 0.95rem; min-height: 80px; }

}

</style>

<?php endif; ?>



<script>

class SectionIllustrationScroll {

    constructor() {

        this.illustrationCenter = document.getElementById('illustration-center');

        if (!this.illustrationCenter) return;

        

        this.section = document.getElementById('our-process-section');

        if (!this.section) {

            this.section = this.illustrationCenter.closest('section');

        }

        

        this.isAnimating = false;

        this.currentProgress = 0;

        this.animationDistance = 400;

        this.ticking = false;

        

        this.init();

    }

    

    init() {

        this.illustrationCenter.style.setProperty('--close-amount', '0');

        window.addEventListener('scroll', () => this.requestTick());

        this.addSectionMarker();

    }

    

    requestTick() {

        if (!this.ticking) {

            requestAnimationFrame(() => this.update());

            this.ticking = true;

        }

    }

    

    update() {

        if (!this.section) return;

        

        const sectionRect = this.section.getBoundingClientRect();

        const windowHeight = window.innerHeight;

        

        const sectionTop = sectionRect.top;

        const sectionBottom = sectionRect.bottom;

        

        if (sectionTop < windowHeight && sectionBottom > 0) {

            this.isAnimating = true;

            let progress = (-sectionTop) / this.animationDistance;

            progress = Math.max(0, Math.min(1, progress));

            this.currentProgress = progress;

        } else {

            if (this.isAnimating) {

                this.isAnimating = false;

            }

        }

        

        this.updateAnimation(this.currentProgress);

        this.ticking = false;

    }

    

    updateAnimation(progress) {

        this.illustrationCenter.style.setProperty('--close-amount', progress);

        

        const calloutLines = this.illustrationCenter.querySelector('.callout-lines-container');

        if (calloutLines) {

            calloutLines.style.opacity = 1 - progress;

            calloutLines.style.visibility = progress > 0.9 ? 'hidden' : 'visible';

        }

    }

    

    addSectionMarker() {

        const marker = document.createElement('div');

        marker.id = 'section-marker';

        marker.style.cssText = `

            position: fixed;

            top: 50%;

            left: 20px;

            background: rgba(13, 110, 253, 0.8);

            color: white;

            padding: 10px 15px;

            border-radius: 10px;

            font-size: 12px;

            z-index: 9999;

            opacity: 0.7;

            transition: opacity 0.3s;

            pointer-events: none;

        `;

        marker.textContent = 'Scroll in this section';

        document.body.appendChild(marker);

        

        const checkMarker = () => {

            if (!this.section) return;

            

            const rect = this.section.getBoundingClientRect();

            const inView = rect.top < window.innerHeight && rect.bottom > 0;

            

            if (inView) {

                marker.style.opacity = '0.7';

                marker.textContent = `Animating: ${Math.round(this.currentProgress * 100)}%`;

            } else {

                marker.style.opacity = '0.2';

                marker.textContent = 'Scroll to illustration section';

            }

            

            requestAnimationFrame(checkMarker);

        };

        

        checkMarker();

    }

}



document.addEventListener('DOMContentLoaded', () => {

    new SectionIllustrationScroll();

});



document.addEventListener('DOMContentLoaded', () => {

    const sliderIds = ['urethane-slider', 'overmold-slider', 'silicone-slider'];

    sliderIds.forEach(id => setupCarouselListeners(id));

    

    new IllustrationScrollAnimator();

});





function scrollCarousel(sliderId, direction) {

    const slider = document.getElementById(sliderId);

    const scrollAmount = 300;

    slider.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });

}



function openLightbox(imageSrc, title) {

    const lightbox = document.getElementById('lightboxModal');

    const lightboxImage = document.getElementById('lightboxImage');

    const lightboxTitle = document.getElementById('lightboxTitle');

    

    lightboxImage.src = imageSrc;

    lightboxTitle.textContent = title;

    lightbox.style.display = 'flex';

    document.body.style.overflow = 'hidden';

}



function closeLightbox() {

    const lightbox = document.getElementById('lightboxModal');

    lightbox.style.display = 'none';

    document.body.style.overflow = 'auto';

}



document.addEventListener('keydown', function(e) {

    if (e.key === 'Escape') {

        closeLightbox();

    }

});



document.getElementById('lightboxModal').addEventListener('click', function(e) {

    if (e.target === this) {

        closeLightbox();

    }

});



document.getElementById('file-upload').addEventListener('change', function(e) {

    const fileName = e.target.files[0] ? e.target.files[0].name : 'No file selected';

    document.getElementById('file-name').textContent = fileName;

});

</script>





<!-- ✅ Footer -->

<?php $this->load->view('web/footer'); ?>



<script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js'); ?>"></script>



<script>

    const navbar = document.querySelector('.navbar');

    window.addEventListener('scroll', function() {

        if (window.scrollY > 50) navbar.classList.add('scrolled');

        else navbar.classList.remove('scrolled');

    });



    const fadeElements = document.querySelectorAll('.fade-in');

    const fadeObserver = new IntersectionObserver((entries) => {

        entries.forEach(entry => {

            if (entry.isIntersecting) entry.target.classList.add('visible');

        });

    }, { threshold: 0.15 });

    fadeElements.forEach(el => fadeObserver.observe(el));



    document.querySelectorAll('.dropdown-submenu > a').forEach(function(element) {

        element.addEventListener('click', function(e) {

            e.preventDefault();

            e.stopPropagation();

            let submenu = this.nextElementSibling;

            if (submenu) submenu.classList.toggle('show');

        });

    });



    document.addEventListener('click', function() {

        document.querySelectorAll('.dropdown-menu .show').forEach(function(openMenu) {

            openMenu.classList.remove('show');

        });

    });



    document.getElementById('file-upload').addEventListener('change', function() {

        const fileName = this.files.length > 0 ? this.files[0].name : 'No file selected';

        document.getElementById('file-name').textContent = fileName;

    });

    

    const quoteForm = document.getElementById('quote-form');

    if (quoteForm) {

        quoteForm.addEventListener('submit', function(e) {

            e.preventDefault();

            

            const formData = new FormData(this);

            const submitBtn = this.querySelector('button[type="submit"]');

            const originalText = submitBtn.innerHTML;

            

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';

            submitBtn.disabled = true;

            

            fetch(this.action, {

                method: 'POST',

                body: formData

            })

            .then(response => {

    return response.text(); // ✅ text muna para makita yung raw output

})

.then(text => {

    console.log('Raw response:', text); // ✅ makikita yung exact PHP output

    if (!text) {

        console.log('Empty response!');

        return;

    }

    const data = JSON.parse(text);

    

    const messageDiv = document.getElementById('form-message');

    messageDiv.style.display = 'block';

    

    if (data.success) {

        messageDiv.className = 'success';

        messageDiv.textContent = data.message;

        quoteForm.reset();

        document.getElementById('file-name').textContent = 'No file selected';

    } else {

        messageDiv.className = 'error';

        messageDiv.textContent = data.message;

    }

    

    submitBtn.innerHTML = originalText;

    submitBtn.disabled = false;

})

            .catch(error => {

                console.log('Fetch error:', error); // ✅ idagdag

                const messageDiv = document.getElementById('form-message');

                messageDiv.style.display = 'block';

                messageDiv.className = 'error';

                messageDiv.textContent = 'An error occurred. Please try again.';

                submitBtn.innerHTML = originalText;

                submitBtn.disabled = false;

            });

        });

    }



    const SCROLL_GAP = 30;

    const CARD_WIDTH = 350;

    const SCROLL_STEP = CARD_WIDTH + SCROLL_GAP;

    const AUTO_SLIDE_DELAY = 3000;



    let autoSlideIntervals = {};



    function scrollCarousel(containerId, direction) {

        const container = document.getElementById(containerId);

        if(!container) return;



        const currentScroll = container.scrollLeft;

        const maxScroll = container.scrollWidth - container.clientWidth;



        let targetScroll;



        if (direction === 1) {

            if (currentScroll >= maxScroll - 10) {

                targetScroll = 0;

                container.scrollTo({ left: 0, behavior: 'smooth' });

                return;

            } else {

                targetScroll = SCROLL_STEP;

            }

        } else {

            targetScroll = -SCROLL_STEP;

        }



        container.scrollBy({

            left: targetScroll,

            behavior: 'smooth'

        });

    }



    function startAutoSlide(id) {

        if (autoSlideIntervals[id]) clearInterval(autoSlideIntervals[id]);

        

        autoSlideIntervals[id] = setInterval(() => {

            scrollCarousel(id, 1);

        }, AUTO_SLIDE_DELAY);

    }



    function stopAutoSlide(id) {

        if (autoSlideIntervals[id]) clearInterval(autoSlideIntervals[id]);

    }



    function setupCarouselListeners(id) {

        const container = document.getElementById(id);

        if(!container) return;

        const wrapper = container.parentElement;



        startAutoSlide(id);



        wrapper.addEventListener('mouseenter', () => stopAutoSlide(id));

        wrapper.addEventListener('touchstart', () => stopAutoSlide(id));

        wrapper.addEventListener('mouseleave', () => startAutoSlide(id));

        wrapper.addEventListener('touchend', () => startAutoSlide(id));

    }



    document.addEventListener('DOMContentLoaded', () => {

        const sliderIds = ['urethane-slider', 'overmold-slider', 'silicone-slider'];

        sliderIds.forEach(id => setupCarouselListeners(id));

    });



    const lightboxModal = document.getElementById('lightboxModal');

    const lightboxImage = document.getElementById('lightboxImage');

    const lightboxTitle = document.getElementById('lightboxTitle');



    function openLightbox(src, title) {

        lightboxImage.src = src;

        lightboxTitle.textContent = title;

        lightboxModal.classList.add('active');

        Object.keys(autoSlideIntervals).forEach(stopAutoSlide);

    }



    function closeLightbox() {

        lightboxModal.classList.remove('active');

        const sliderIds = ['urethane-slider', 'overmold-slider', 'silicone-slider'];

        sliderIds.forEach(id => startAutoSlide(id));

    }



    lightboxModal.addEventListener('click', (e) => {

        if (e.target === lightboxModal) closeLightbox();

    });



</script>

</body>

</html>