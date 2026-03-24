<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Professional News & Events</title>

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
      padding-top: 80px;
    }

    /* Smooth scrolling */
    html {
      scroll-behavior: smooth;
    }

    /* Modernized Navbar */
    .navbar {
      z-index: 1030;
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      padding: 0.8rem 5%;
      transition: var(--transition);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
      border-bottom: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .navbar-collapse {
      z-index: 1050;
    }
    
    .navbar .dropdown-menu {
      position: absolute;
      z-index: 1000;
    }
    
    .navbar-nav > li:nth-child(3) > .dropdown-toggle::after {
      display: none !important;
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
      text-align: center;
    }
    
    section h2::after {
      content: '';
      position: absolute;
      left: 50%;
      bottom: -15px;
      transform: translateX(-50%);
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
    
    /* Section Light Orange with Wavy Gradient */
    .section-light-orange {
      background: linear-gradient(135deg, var(--newblue2) 0%, var(--newblue) 100%);
      color: white;
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }

    .section-light-orange::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z' fill='%23ffffff' fill-opacity='0.1'%3E%3C/path%3E%3C/svg%3E"),
        url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 120' preserveAspectRatio='none'%3E%3Cpath d='M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z' fill='%23ffffff' fill-opacity='0.05'%3E%3C/path%3E%3C/svg%3E");
      background-repeat: no-repeat;
      z-index: 1;
      animation: waveMove 15s ease-in-out infinite alternate;
    }

    .section-light-orange .container {
      position: relative;
      z-index: 2;
    }

    /* UNIFORM NEWS CARDS - ALL SAME SIZE */
    .content-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
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
      border: 1px solid rgba(13, 110, 253, 0.1);
    }
    
    .news-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .news-image {
      width: 100%;
      height: 220px;
      overflow: hidden;
      position: relative;
      flex-shrink: 0;
      background: #f0f4f8;
    }
    
    .news-image img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    
    .news-card:hover .news-image img {
      transform: scale(1.05);
    }
    
    .news-badge {
      position: absolute;
      top: 15px;
      left: 15px;
      background: var(--newblue);
      color: white;
      padding: 0.5rem 1rem;
      border-radius: 50px;
      font-size: 0.75rem;
      font-weight: 600;
      z-index: 2;
      letter-spacing: 0.5px;
      text-transform: uppercase;
    }
    
    .news-badge.event {
      background: linear-gradient(135deg, #fd7e14, #e67300);
    }
    
    .news-badge.featured {
      background: linear-gradient(135deg, #ff6b6b, #ee5a24);
    }
    
    .news-badge.product {
      background: linear-gradient(135deg, #20c997, #17a2b8);
    }
    
    .news-badge.news {
      background: linear-gradient(135deg, #6f42c1, #6610f2);
    }
    
    .news-badge.webinars {
      background: linear-gradient(135deg, #17a2b8, #138496);
    }
    
    .news-card-content {
      padding: 25px;
      flex: 1;
      display: flex;
      flex-direction: column;
      overflow: hidden;
    }
    
    .news-date {
      color: var(--newblue);
      font-size: 0.85rem;
      font-weight: 600;
      margin-bottom: 10px;
      display: block;
      flex-shrink: 0;
    }
    
    .news-card h3 {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 12px;
      color: var(--newblue2);
      line-height: 1.4;
      flex-shrink: 0;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .news-card p {
      font-size: 0.95rem;
      color: #495057;
      margin-bottom: 20px;
      line-height: 1.6;
      flex: 1;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
    }
    
    /* Event Countdown - FIXED HEIGHT */
    .event-countdown {
      background: rgba(23, 162, 220, 0.1);
      border-radius: 12px;
      padding: 1rem;
      margin: 0.5rem 0;
      border: 1px solid rgba(23, 162, 220, 0.2);
      flex-shrink: 0;
      min-height: 110px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .countdown-title {
      font-size: 0.85rem;
      margin-bottom: 0.8rem;
      color: var(--newblue2);
      font-weight: 600;
      text-align: center;
    }
    
    .countdown-timer {
      display: flex;
      gap: 0.8rem;
      justify-content: center;
    }
    
    .countdown-item {
      text-align: center;
      background: white;
      border-radius: 8px;
      padding: 0.6rem;
      min-width: 55px;
      box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    
    .countdown-number {
      font-size: 1.3rem;
      font-weight: 700;
      display: block;
      color: var(--newblue2);
      line-height: 1.2;
    }
    
    .countdown-label {
      font-size: 0.65rem;
      color: #666;
      text-transform: uppercase;
      font-weight: 600;
      margin-top: 0.2rem;
    }
    
    .countdown-expired {
      text-align: center;
      color: var(--newblue2);
      font-weight: 600;
      font-size: 0.9rem;
      padding: 0.5rem;
    }
    
    .news-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: auto;
      padding-top: 15px;
      border-top: 1px solid rgba(0, 0, 0, 0.1);
      flex-shrink: 0;
    }
    
    .news-category {
      background: var(--light-blue);
      color: var(--newblue2);
      padding: 0.3rem 0.8rem;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .news-read-more {
      color: var(--newblue);
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      transition: var(--transition);
      font-size: 0.9rem;
    }
    
    .news-read-more:hover {
      color: var(--newblue2);
      gap: 0.8rem;
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
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
    }
    
    .btn-orange {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      border: none;
      color: white;
    }
    
    .btn-orange:hover {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
      transform: translateY(-3px);
      box-shadow: 0 8px 20px rgba(13, 110, 253, 0.4);
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

    /* Hero Section with Background Image & Blue Overlay */
    .news-hero {
      background: 
        linear-gradient(135deg, rgba(15, 70, 123, 0.85) 50%, rgba(23, 162, 220, 0.75) 100%),
        url('<?= base_url('assets_system/images/new4.jpg') ?>') center/cover no-repeat;
      color: white;
      padding: 150px 0 80px;
      text-align: center;
      position: relative;
      overflow: hidden;
      min-height: 70vh;
      display: flex;
      align-items: center;
    }

    .news-hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: 
        radial-gradient(circle at 20% 80%, rgba(23, 162, 220, 0.2) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(15, 70, 123, 0.15) 0%, transparent 50%);
      z-index: 1;
    }

    .news-hero .container {
      position: relative;
      z-index: 2;
    }

    .news-hero h1 {
      font-size: 3.5rem;
      font-weight: 800;
      margin-bottom: 1rem;
      color: white;
      text-transform: uppercase;
      letter-spacing: -0.5px;
      text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .news-hero p {
      font-size: 1.3rem;
      max-width: 600px;
      margin: 0 auto;
      opacity: 0.95;
      text-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      color: white;
    }

    /* Filter Section */
    .news-filter {
      background: white;
      padding: 2rem 0;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      position: sticky;
      top: 80px;
      position: relative;
      z-index: 1;
      margin-top: 20px;
    }

    .filter-buttons {
      display: flex;
      gap: 1rem;
      justify-content: center;
      flex-wrap: wrap;
    }

    .filter-btn {
      background: transparent;
      border: 2px solid var(--newblue);
      color: var(--newblue);
      padding: 0.7rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      transition: var(--transition);
    }

    .filter-btn:hover,
    .filter-btn.active {
      background: var(--newblue);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(23, 162, 220, 0.3);
    }

    /* Newsletter Section */
    .newsletter-section {
      background: 
        linear-gradient(135deg, rgba(255, 255, 255, 0.4) 50%, rgba(255, 255, 255, 0.3) 100%),
        url('<?= base_url('assets_system/images/newsletter-bg.jpg') ?>') center/cover no-repeat;
      color: white;
      padding: 80px 0;
      text-align: center;
      border-radius: 20px;
      position: relative;
      overflow: hidden;
    }

    .newsletter-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(15, 70, 123, 0.1);
      z-index: 1;
    }

    .newsletter-section .container {
      position: relative;
      z-index: 2;
    }

    .newsletter-section h2 {
      font-size: 3rem;
      font-weight: 800;
      margin-bottom: 25px;
      text-align: center;
      background: linear-gradient(95deg, var(--newblue2) 0%, var(--newblue2) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    .newsletter-section p {
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 40px;
      text-align: center;
      color: var(--newblue2)
    }

    /* Newsletter Message Alert */
    #newsletter-message {
      max-width: 500px;
      margin: 0 auto 20px;
      border-radius: 50px;
      padding: 1rem 1.5rem;
      font-weight: 500;
      animation: slideDown 0.5s ease;
    }

    @keyframes slideDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .alert-success {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
      border: none;
      box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }

    .alert-info {
      background: linear-gradient(135deg, #17a2b8, #138496);
      color: white;
      border: none;
      box-shadow: 0 5px 15px rgba(23, 162, 184, 0.3);
    }

    .alert-danger {
      background: linear-gradient(135deg, #dc3545, #c82333);
      color: white;
      border: none;
      box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
    }

    .newsletter-form {
      max-width: 500px;
      margin: 2rem auto 0;
      display: flex;
      gap: 1rem;
      position: relative;
      z-index: 2;
    }

    .newsletter-form .form-control {
      flex: 1;
      border: none;
      border-radius: 50px;
      padding: 1rem 1.5rem;
      font-size: 1rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      background: rgba(255, 255, 255, 0.95);
    }

    .newsletter-form .form-control:focus {
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.3);
      background: white;
      outline: none;
    }

    .newsletter-form .btn {
      border-radius: 50px;
      padding: 1rem 2rem;
      white-space: nowrap;
      background: linear-gradient(135deg, var(--newblue), var(--newblue2));
      border: none;
      font-weight: 700;
      transition: var(--transition);
    }

    .newsletter-form .btn:hover:not(:disabled) {
      background: linear-gradient(135deg, var(--newblue), var(--newblue2));
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(23, 162, 220, 0.4);
    }

    .newsletter-form .btn:disabled {
      opacity: 0.7;
      cursor: not-allowed;
    }

    /* Pagination */
    .news-pagination {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin: 3rem 0;
    }

    .page-link {
      border: 2px solid var(--light-blue);
      color: var(--newblue2);
      padding: 0.7rem 1.2rem;
      border-radius: 8px;
      text-decoration: none;
      font-weight: 600;
      transition: var(--transition);
    }

    .page-link:hover,
    .page-link.active {
      background: var(--newblue);
      color: white;
      border-color: var(--newblue);
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
    .delay-5 { transition-delay: 0.5s; }
    
    /* Wave animation */
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
    
    /* No events message */
    .no-events-message {
      grid-column: 1 / -1;
      text-align: center;
      padding: 4rem;
      color: #666;
      font-size: 1.2rem;
      background: white;
      border-radius: 16px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }

    /* Flash Messages */
    .flash-message {
      position: fixed;
      top: 100px;
      right: 20px;
      z-index: 9999;
      padding: 1rem 2rem;
      border-radius: 50px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      animation: slideInRight 0.5s ease;
    }

    @keyframes slideInRight {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    .flash-success {
      background: linear-gradient(135deg, #28a745, #20c997);
      color: white;
    }

    .flash-error {
      background: linear-gradient(135deg, #dc3545, #c82333);
      color: white;
    }

    .flash-info {
      background: linear-gradient(135deg, #17a2b8, #138496);
      color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
      .content-container {
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
      }
    }
    
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
      
      .content-container {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      }
      
      .news-hero {
        padding: 120px 0 60px;
        min-height: 60vh;
      }
      
      .news-hero h1 {
        font-size: 2.8rem;
      }
      
      .news-hero p {
        font-size: 1.2rem;
      }
      
      .newsletter-section h2 {
        font-size: 2.4rem;
      }
      
      .newsletter-section p {
        font-size: 1.1rem;
      }
      
      .event-countdown {
        min-height: 100px;
        padding: 0.8rem;
      }
      
      .countdown-item {
        min-width: 50px;
        padding: 0.5rem;
      }
      
      .countdown-number {
        font-size: 1.2rem;
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
      
      .news-hero {
        padding: 100px 0 50px;
        min-height: 50vh;
      }
      
      .news-hero h1 {
        font-size: 2.2rem;
      }
      
      .news-hero p {
        font-size: 1.1rem;
      }
      
      .newsletter-form {
        flex-direction: column;
        max-width: 400px;
      }
      
      .newsletter-form .btn {
        width: 100%;
      }
      
      .filter-buttons {
        justify-content: flex-start;
        overflow-x: auto;
        padding-bottom: 0.5rem;
      }
      
      .filter-btn {
        white-space: nowrap;
      }
      
      .event-countdown {
        min-height: 90px;
      }
      
      .countdown-timer {
        gap: 0.5rem;
      }
      
      .countdown-item {
        min-width: 45px;
        padding: 0.4rem;
      }
      
      .countdown-number {
        font-size: 1.1rem;
      }
      
      .countdown-label {
        font-size: 0.6rem;
      }
    }
    
    @media (max-width: 576px) {
      .content-container {
        grid-template-columns: 1fr;
      }
      
      .newsletter-form {
        max-width: 300px;
      }
      
      .news-hero {
        padding: 80px 0 40px;
        min-height: 40vh;
      }
      
      .news-hero h1 {
        font-size: 2rem;
      }
      
      .news-hero p {
        font-size: 1rem;
      }
      
      .newsletter-section h2 {
        font-size: 2rem;
      }
      
      .newsletter-section p {
        font-size: 1rem;
      }
      
      .section-light-orange,
      .newsletter-section {
        padding: 60px 0;
      }
      
      .news-card-content {
        padding: 20px;
      }
      
      .event-countdown {
        min-height: 85px;
        padding: 0.7rem;
      }
      
      .countdown-timer {
        gap: 0.4rem;
      }
      
      .countdown-item {
        min-width: 40px;
        padding: 0.3rem;
      }
      
      .countdown-number {
        font-size: 1rem;
      }
    }
    
    /* Remove the spacer div under the navbar */
    body > div[style*="margin-top: 90px"] {
      display: none !important;
    }
  </style>
</head>
<body>
  <!-- Flash Messages -->
  <?php if ($this->session->flashdata('success')): ?>
  <div class="flash-message flash-success">
    <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success') ?>
  </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('error')): ?>
  <div class="flash-message flash-error">
    <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error') ?>
  </div>
  <?php endif; ?>

  <?php if ($this->session->flashdata('info')): ?>
  <div class="flash-message flash-info">
    <i class="fas fa-info-circle me-2"></i> <?= $this->session->flashdata('info') ?>
  </div>
  <?php endif; ?>

  <!-- NAVBAR -->
<?php $this->load->view('web/header'); ?>

  <!-- Hero Section -->
  <section class="news-hero fade-in">
    <div class="container">
      <h1>News & Events</h1>
      <p>Stay updated with the latest developments, exhibitions, and innovations from Line Seiki</p>
    </div>
  </section>

  <!-- Filter Section -->
  <div class="news-filter fade-in delay-1">
    <div class="container">
      <div class="filter-buttons">
        <button class="filter-btn <?= $active_filter === 'all' ? 'active' : '' ?>" data-filter="all">
          All Updates (<?= $category_counts['all'] ?>)
        </button>
        <button class="filter-btn <?= $active_filter === 'news' ? 'active' : '' ?>" data-filter="news">
          Company News (<?= $category_counts['news'] ?>)
        </button>
        <button class="filter-btn <?= $active_filter === 'events' ? 'active' : '' ?>" data-filter="events">
          Events & Exhibitions (<?= $category_counts['events'] ?>)
        </button>
        <button class="filter-btn <?= $active_filter === 'product' ? 'active' : '' ?>" data-filter="product">
          Product Updates (<?= $category_counts['product'] ?>)
        </button>
      </div>
    </div>
  </div>

  <!-- News and Updates Section -->
  <section class="section-light-blue">
    <div class="container">
      <h2 class="fade-in text-center">Latest News & Updates</h2>
      <div class="content-container pt-4">
        <?php 
        $counter = 1;
        foreach ($events as $event): 
          $delay_class = 'delay-' . $counter;
          $counter++;
          $isFutureEvent = strtotime($event['event_date']) > time();
        ?>
        <div class="news-card fade-in <?= $delay_class ?>" data-category="<?= $event['category'] ?>">
          <div class="news-image">
            <?php if (!empty($event['image'])): ?>
            <img src="<?= base_url('assets_system/images/' . $event['image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>"
                 onerror="this.src='<?= base_url('assets_system/images/no-image.png') ?>'">
            <?php else: ?>
            <img src="<?= base_url('assets_system/images/no-image.png') ?>" alt="<?= htmlspecialchars($event['title']) ?>">
            <?php endif; ?>
            <?php if ($event['badge_text']): ?>
            <span class="news-badge <?= $event['category'] ?> <?= $event['is_featured'] ? 'featured' : '' ?>">
              <?= $event['badge_text'] ?>
            </span>
            <?php endif; ?>
          </div>
          <div class="news-card-content">
            <span class="news-date">
              <i class="far fa-calendar-alt me-1"></i><?= date('F j, Y', strtotime($event['event_date'])) ?>
            </span>
            <h3><?= htmlspecialchars($event['title']) ?></h3>
            <p><?= character_limiter(strip_tags($event['content']), 150) ?></p>
            
            <?php if ($event['category'] == 'events'): ?>
              <?php if ($isFutureEvent): ?>
              <!-- Countdown for future events -->
              <div class="event-countdown" data-date="<?= $event['event_date'] ?>">
                <div class="countdown-title">Event Starts In:</div>
                <div class="countdown-timer">
                  <div class="countdown-item">
                    <span class="countdown-number days" data-days="<?= date('Y-m-d', strtotime($event['event_date'])) ?>">00</span>
                    <span class="countdown-label">Days</span>
                  </div>
                  <div class="countdown-item">
                    <span class="countdown-number hours">00</span>
                    <span class="countdown-label">Hours</span>
                  </div>
                  <div class="countdown-item">
                    <span class="countdown-number minutes">00</span>
                    <span class="countdown-label">Minutes</span>
                  </div>
                </div>
              </div>
              <?php else: ?>
              <!-- Message for past events -->
              <div class="event-countdown">
                <div class="countdown-expired">
                  <i class="fas fa-check-circle me-1"></i> Event Completed
                </div>
              </div>
              <?php endif; ?>
            <?php endif; ?>
            
            <div class="news-meta">
              <span class="news-category">
                <?= ucfirst($event['category']) ?>
              </span>
              <a href="<?= base_url('index/news_events_extension/' . $event['id']) ?>" class="news-read-more">
                Learn More <i class="fas fa-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        
        <?php if (empty($events)): ?>
        <div class="no-events-message text-center fade-in">
          <p>No events found in this category.</p>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <!-- Newsletter Section -->
  <section class="section-light-orange">
    <div class="container">
      <div class="newsletter-section">
        <h2>Stay Updated</h2>
        <p>Subscribe to our newsletter for the latest news, events, and product updates</p>
        
        <!-- Newsletter Message Container -->
        <div id="newsletter-message" class="alert" style="display: none;"></div>
        
        <form class="newsletter-form" id="newsletter-form">
          <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
          <button type="submit" class="btn btn-orange" id="subscribe-btn">
            <span class="btn-text">Subscribe</span>
            <span class="btn-loader" style="display: none;"><i class="fas fa-spinner fa-spin"></i></span>
          </button>
        </form>
        
        <!-- Unsubscribe link -->
        
      </div>
    </div>
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

      // News filtering functionality
      const filterButtons = document.querySelectorAll('.filter-btn');
      const newsCards = document.querySelectorAll('.news-card');
      
      filterButtons.forEach(button => {
        button.addEventListener('click', function() {
          // Remove active class from all buttons
          filterButtons.forEach(btn => btn.classList.remove('active'));
          // Add active class to clicked button
          this.classList.add('active');
          
          const filterValue = this.getAttribute('data-filter');
          
          newsCards.forEach(card => {
            if (filterValue === 'all' || card.getAttribute('data-category') === filterValue) {
              card.style.display = 'flex';
            } else {
              card.style.display = 'none';
            }
          });
        });
      });

      // Enhanced Countdown timer for events
      function updateCountdowns() {
        document.querySelectorAll('.event-countdown').forEach(countdown => {
          const dateAttr = countdown.getAttribute('data-date');
          if (!dateAttr) return;
          
          const eventDate = new Date(dateAttr + 'T00:00:00').getTime();
          const now = new Date().getTime();
          const distance = eventDate - now;
          
          const daysElement = countdown.querySelector('.days');
          const hoursElement = countdown.querySelector('.hours');
          const minutesElement = countdown.querySelector('.minutes');
          
          if (distance > 0) {
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            
            if (daysElement) daysElement.textContent = days.toString().padStart(2, '0');
            if (hoursElement) hoursElement.textContent = hours.toString().padStart(2, '0');
            if (minutesElement) minutesElement.textContent = minutes.toString().padStart(2, '0');
          } else {
            // Event has passed - update UI
            if (daysElement && hoursElement && minutesElement) {
              countdown.innerHTML = '<div class="countdown-expired"><i class="fas fa-check-circle me-1"></i> Event Completed</div>';
            }
          }
        });
      }
      
      // Update countdown immediately and then every minute
      updateCountdowns();
      setInterval(updateCountdowns, 60000);

        // Newsletter form submission with AJAX
        const newsletterForm = document.getElementById('newsletter-form');
        const newsletterMessage = document.getElementById('newsletter-message');
        const subscribeBtn = document.getElementById('subscribe-btn');
        const btnText = subscribeBtn ? subscribeBtn.querySelector('.btn-text') : null;
        const btnLoader = subscribeBtn ? subscribeBtn.querySelector('.btn-loader') : null;

        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const email = this.querySelector('input[type="email"]').value;
                const formData = new FormData();
                formData.append('email', email);
                
                // Show loading state
                if (subscribeBtn) {
                    subscribeBtn.disabled = true;
                    if (btnText) btnText.style.display = 'none';
                    if (btnLoader) btnLoader.style.display = 'inline-block';
                }
                
                // Hide any previous messages
                if (newsletterMessage) {
                    newsletterMessage.style.display = 'none';
                    newsletterMessage.className = 'alert';
                }
                
                // Send AJAX request
                fetch('<?= base_url("index/subscribe_newsletter") ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    // Check if response is OK
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text(); // Get as text first to debug
                })
                .then(text => {
                    try {
                        // Try to parse as JSON
                        const data = JSON.parse(text);
                        return data;
                    } catch (e) {
                        console.error('Invalid JSON response:', text);
                        throw new Error('Server returned invalid JSON');
                    }
                })
                .then(data => {
                    // Show message
                    if (newsletterMessage) {
                        newsletterMessage.textContent = data.message;
                        newsletterMessage.classList.add(
                            data.status === 'success' ? 'alert-success' : 
                            data.status === 'info' ? 'alert-info' : 'alert-danger'
                        );
                        newsletterMessage.style.display = 'block';
                        
                        // Clear form on success
                        if (data.status === 'success') {
                            newsletterForm.reset();
                        }
                        
                        // Auto-hide message after 5 seconds
                        setTimeout(() => {
                            if (newsletterMessage) {
                                newsletterMessage.style.display = 'none';
                            }
                        }, 5000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (newsletterMessage) {
                        newsletterMessage.textContent = 'An error occurred. Please try again.';
                        newsletterMessage.classList.add('alert-danger');
                        newsletterMessage.style.display = 'block';
                    }
                })
                .finally(() => {
                    // Reset button state
                    if (subscribeBtn) {
                        subscribeBtn.disabled = false;
                        if (btnText) btnText.style.display = 'inline-block';
                        if (btnLoader) btnLoader.style.display = 'none';
                    }
                });
            });
        }

      // Auto-hide flash messages after 5 seconds
      setTimeout(function() {
        document.querySelectorAll('.flash-message').forEach(function(msg) {
          msg.style.opacity = '0';
          msg.style.transition = 'opacity 0.5s ease';
          setTimeout(function() {
            if (msg && msg.parentNode) {
              msg.parentNode.removeChild(msg);
            }
          }, 500);
        });
      }, 5000);
      
      // Pre-load countdown values on page load
      setTimeout(updateCountdowns, 100);
    });
  </script>
</body>
</html>