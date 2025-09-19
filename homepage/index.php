<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Homepage</title>
    <style>
        /*
         * ========================================
         * GLOBAL STYLES
         * ========================================
         */
        
        /* --- Reset & Base --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #0d1b2a;
            --secondary-color: #1b263b;
            --accent-color: #f39c12;
            --light-accent: #ffd60a;
            --text-color: #333;
            --light-text: #fff;
            --subtle-text: #555;
            --bg-light: #f9f9f9;
            --shadow: rgba(0, 0, 0, 0.1);
            --font-main: 'Segoe UI', Arial, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-main);
            color: var(--text-color);
            line-height: 1.6;
            background: var(--light-text);
        }
        
        /* --- Section Defaults --- */
        section {
            padding: 90px 60px;
            text-align: center;
        }

        section h2 {
            font-size: 34px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        section p {
            max-width: 800px;
            margin: 0 auto 30px;
            font-size: 17px;
            color: var(--subtle-text);
        }

        /*
         * ========================================
         * HEADER & NAVBAR
         * ========================================
         */
        header {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 50px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .logo img {
            height: 40px;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin-left: 25px;
            position: relative;
        }

        nav ul li a {
            text-decoration: none;
            color: var(--light-text);
            font-weight: 600;
            transition: all 0.3s;
            font-size: 15px;
            position: relative;
        }

        nav ul li a:hover {
            color: var(--accent-color);
        }

        nav ul li a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -6px;
            width: 0%;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s;
        }

        nav ul li a:hover::after {
            width: 100%;
        }

        .btn-nav {
            background: var(--accent-color);
            color: var(--light-text);
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-nav:hover {
            background: var(--light-accent);
            color: var(--primary-color);
        }

        /* --- Dropdown Menu --- */
        nav ul li ul {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background: var(--light-text);
            list-style: none;
            min-width: 180px;
            border-radius: 6px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        nav ul li ul li {
            margin: 0;
        }

        nav ul li ul li a {
            display: block;
            padding: 12px 18px;
            color: var(--text-color);
        }

        nav ul li ul li a:hover {
            background: var(--accent-color);
            color: var(--light-text);
        }

        nav ul li:hover ul {
            display: block;
        }

        /* --- Hamburger Menu --- */
        .hamburger {
            display: none;
            font-size: 28px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--light-text);
            z-index: 2000;
        }

        /*
         * ========================================
         * HERO SECTION
         * ========================================
         */
        .hero {
            position: relative;
            height: 85vh;
            display: flex;
            align-items: center;
            color: var(--light-text);
            padding-left: 120px;
            text-align: left;
        }

        .hero-content {
            z-index: 2;
            background: rgba(0, 0, 0, 0.55);
            padding: 40px;
            border-radius: 12px;
            max-width: 600px;
            animation: fadeInUp 1.2s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
        }

        .hero h1 {
            font-size: 52px;
            margin-bottom: 20px;
            font-weight: 700;
            color: var(--light-accent);
        }

        .hero p {
            font-size: 18px;
            margin-bottom: 25px;
            color: var(--light-text);
        }

        .hero-btn {
            display: inline-block;
            background: var(--accent-color);
            color: var(--light-text);
            padding: 12px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .hero-btn:hover {
            background: var(--light-accent);
            color: var(--primary-color);
        }

        .hero-btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.3);
            transform: skewX(-20deg);
            transition: all 0.5s;
        }
        
        .hero-btn:hover::before {
            left: 100%;
        }

        /* --- Hero Background Slideshow --- */
        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            opacity: 0;
            animation: fade 12s infinite;
        }

        .slide1 { background-image: url('eg_img/LS.jpg'); animation-delay: 0s; }
        .slide2 { background-image: url('eg_img/LS2.jpg'); animation-delay: 3s; }
        .slide3 { background-image: url('eg_img/LS3.jpg'); animation-delay: 6s; }
        .slide4 { background-image: url('eg_img/gemba2.png'); animation-delay: 9s; }
        
        @keyframes fade {
            0%, 100% { opacity: 0; }
            10%, 30% { opacity: 1; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /*
         * ========================================
         * ABOUT SECTION
         * ========================================
         */
        #about {
            background: var(--bg-light);
            padding: 90px 60px;
        }

        .about-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
            max-width: 1100px;
            margin: auto;
            flex-wrap: wrap;
        }

        .about-text {
            flex: 1;
            text-align: left;
        }

        .about-text h2 {
            color: var(--primary-color);
        }

        .about-text p {
            color: var(--subtle-text);
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .about-img {
            flex: 1;
            text-align: center;
        }

        .about-img img {
            max-width: 100%;
            border-radius: 12px;
            box-shadow: 0 6px 16px var(--shadow);
            transition: transform 0.3s ease;
        }

        .about-img img:hover {
            transform: scale(1.05);
        }
        
        /*
         * ========================================
         * SERVICES & CARDS
         * ========================================
         */
        #services h2 {
            color: var(--primary-color);
        }
        
        #services .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 50px;
        }

        .card {
            background: var(--light-text);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 16px var(--shadow);
            text-align: left;
            transition: all 0.3s;
            border-top: 4px solid transparent;
        }

        .card h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            font-size: 20px;
        }

        .card p {
            color: var(--subtle-text);
            font-size: 15px;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
            border-top: 4px solid var(--accent-color);
        }
        
        /*
         * ========================================
         * HOW IT WORKS
         * ========================================
         */
        #how {
            background: var(--bg-light);
        }

        .steps {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            justify-content: center;
            margin-top: 40px;
        }

        .step {
            flex: 1 1 280px;
            background: var(--light-text);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 16px var(--shadow);
            transition: all 0.3s;
            position: relative;
        }

        .step h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .step:hover {
            transform: translateY(-8px);
        }

        .step::before {
            content: "✔";
            position: absolute;
            top: -15px;
            left: 15px;
            background: var(--accent-color);
            color: var(--light-text);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        /*
         * ========================================
         * TESTIMONIALS SECTION
         * ========================================
         */
        #testimonials {
            padding: 80px 20px;
            text-align: center;
            background: var(--bg-light);
        }

        #testimonials h2 {
            margin-bottom: 30px;
            font-size: 2rem;
            color: var(--primary-color);
        }

        .testimonial-wrapper {
            position: relative;
            max-width: 1100px;
            margin: auto;
        }

        .testimonial-slider {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-snap-type: x mandatory;
            padding: 20px 10px;
            scrollbar-width: none; /* hide scrollbar Firefox */
        }
        
        .testimonial-slider::-webkit-scrollbar {
            display: none; /* hide scrollbar Chrome */
        }

        .testimonial {
            flex: 0 0 calc(33.333% - 20px);
            background: var(--light-text);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 16px var(--shadow);
            scroll-snap-align: start;
            text-align: left;
            min-height: 180px;
        }

        .testimonial p {
            font-size: 18px;
            color: var(--subtle-text);
            margin-bottom: 15px;
            font-style: italic;
        }
        
        .testimonial .stars {
            color: var(--accent-color);
            font-size: 20px;
            margin-bottom: 10px;
        }

        .testimonial h4 {
            font-weight: 600;
            color: var(--primary-color);
            margin-top: 15px;
        }

        .profile-pic {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
        
        .testimonial-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: var(--accent-color);
            color: var(--light-text);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            transition: background 0.3s;
            z-index: 10;
            padding: 0;
        }

        .testimonial-btn:hover {
            background: #d35400;
        }

        .testimonial-btn.prev { left: -20px; }
        .testimonial-btn.next { right: -20px; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /*
         * ========================================
         * BLOG SECTION
         * ========================================
         */
        #blog {
            background: var(--bg-light);
            padding: 90px 60px;
            text-align: center;
        }

        .blog-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .blog-card {
            background: var(--light-text);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 16px var(--shadow);
            text-align: left;
        }

        .blog-card h3 {
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        .blog-card p {
            font-size: 15px;
            color: var(--subtle-text);
        }

        /*
         * ========================================
         * PARTNERS SECTION
         * ========================================
         */
        #partners {
            background: var(--light-text);
            padding: 90px 60px;
            text-align: center;
        }

        #partners h2 {
            color: var(--primary-color);
        }

        #partners p {
            max-width: 700px;
            margin: 0 auto 50px;
        }

        .partners-logos {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 30px;
            align-items: center;
            justify-content: center;
        }

        .partner img {
            max-width: 140px;
            margin: auto;
            transition: all 0.3s ease;
            filter: grayscale(0%);
        }

        .partner img:hover {
            transform: scale(1.1);
            filter: grayscale(0%) drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        /*
         * ========================================
         * SIGNUP FORM
         * ========================================
         */
        .signup {
            position: relative;
            padding: 60px;
            background: url("eg_img/1234.png") no-repeat center center/cover;
            color: var(--light-text);
            text-align: center;
        }

        .signup::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        
        .signup * {
            position: relative;
            z-index: 1;
        }

        #signup h2 {
            font-size: 32px;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        #signup p {
            margin-bottom: 30px;
            font-size: 16px;
            color: var(--subtle-text);
        }

        .signup-form {
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .signup-form .form-group {
            position: relative;
        }

        .signup-form .form-group input {
            width: 100%;
            padding: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: border 0.3s;
        }

        .signup-form .form-group input:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.3);
        }

        .signup-form .form-group input:focus::placeholder {
            color: transparent;
        }

        .signup-btn {
            background: var(--accent-color);
            color: var(--light-text);
            padding: 14px;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .signup-btn:hover {
            background: var(--light-accent);
            color: var(--primary-color);
        }
        
        .show-pass {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            font-size: 14px;
            color: var(--text-color);
            gap: 4px;
            margin-top: -10px;
        }

        .show-pass input[type="checkbox"] {
            margin: 0;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .show-pass label {
            cursor: pointer;
        }

        /*
         * ========================================
         * FAQ SECTION
         * ========================================
         */
        #faq {
            position: relative;
            padding: 90px 60px;
            text-align: center;
            background: url("eg_img/LS.jpg") no-repeat center center/cover;
        }

        #faq::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(13, 27, 42, 0.7); /* dark overlay */
            z-index: 0;
        }
        
        #faq h2, #faq p, #faq .faq-question, #faq .faq-answer {
            position: relative;
            z-index: 1;
            color: var(--light-accent);
        }

        .faq-container {
            max-width: 800px;
            margin: 40px auto 0;
            text-align: left;
        }

        .faq-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .faq-question {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            color: var(--primary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-answer {
            display: none;
            margin-top: 10px;
            font-size: 16px;
            color: var(--subtle-text);
        }
        
        /*
         * ========================================
         * CTA SECTION
         * ========================================
         */
        #cta {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--light-text);
            padding: 80px 40px;
            text-align: center;
        }

        #cta h2 {
            font-size: 36px;
            margin-bottom: 20px;
            font-weight: 700;
        }

        #cta p {
            font-size: 18px;
            margin-bottom: 30px;
            color: #ddd;
        }

        .cta-btn {
            display: inline-block;
            background: var(--accent-color);
            color: var(--light-text);
            padding: 14px 34px;
            border-radius: 30px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
        }

        .cta-btn:hover {
            background: var(--light-accent);
            color: var(--primary-color);
        }

        /*
         * ========================================
         * FLOATING BUTTON
         * ========================================
         */
        .floating-btn {
            position: fixed;
            right: 20px;
            bottom: 80px;
            background: var(--accent-color);
            color: var(--light-text);
            border: none;
            padding: 12px 20px;
            border-radius: 30px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: background 0.3s;
            z-index: 2000;
            text-decoration: none;
        }

        .floating-btn:hover {
            background: var(--light-accent);
            color: var(--primary-color);
            
        }

        /*
         * ========================================
         * FOOTER
         * ========================================
         */
        .site-footer {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--light-text);
            padding: 50px 60px 20px;
            font-size: 15px;
        }

        .footer-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-col h3,
        .footer-col h4 {
            color: var(--light-accent);
            margin-bottom: 15px;
            font-size: 18px;
        }

        .footer-col ul {
            list-style: none;
        }

        .footer-col ul li {
            margin-bottom: 8px;
        }

        .footer-col ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
            position: relative;
        }
        
        .footer-col ul li a:hover {
            color: var(--accent-color);
        }

        .footer-col ul li a::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -5px;
            height: 2px;
            width: 0%;
            background: var(--light-accent);
            transition: width 0.3s;
        }

        .footer-col ul li a:hover::after {
            width: 100%;
        }

        .company-info p {
            margin-bottom: 8px;
            color: #ccc;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 15px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .footer-social a {
            color: var(--accent-color);
            text-decoration: none;
            margin: 0 5px;
        }

        .footer-social a:hover {
            color: var(--light-accent);
        }
        .footer-logo img {
        height: 40px;
        width: auto; /* maintain aspect ratio */
        }


        /*
         * ========================================
         * RESPONSIVE STYLES
         * ========================================
         */
        /* --- Tablets (≤ 992px) --- */
        @media (max-width: 992px) {
            header nav ul {
                flex-direction: column;
                gap: 15px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .testimonial {
                flex: 0 0 calc(50% - 20px); /* 2 per row */
            }

            .faq-item {
                font-size: 0.95rem;
            }

            form {
                width: 90%;
            }
        }

        /* --- Mobile (≤ 768px) --- */
        @media (max-width: 768px) {
            /* General */
            header {
                padding: 15px 20px;
            }
            
            header nav {
                flex-direction: column;
                text-align: center;
            }
            
            /* Hamburger Menu */
            .hamburger {
                display: block;
            }
            
            nav ul {
                display: none; /* hide menu by default */
                flex-direction: column;
                background: var(--light-text);
                position: absolute;
                top: 60px; /* below header */
                right: 20px;
                width: 200px;
                padding: 15px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
                border-radius: 12px;
            }

            nav ul.show {
                display: flex; /* show when toggled */
            }
            
            nav ul li a {
                color: var(--primary-color);
            }
            
            nav ul li a:hover {
                color: var(--accent-color);
            }

            /* Mobile Dropdown */
            nav ul li {
                position: relative;
            }
            
            nav ul li ul {
                position: static;
                background: none;
                box-shadow: none;
                padding-left: 15px;
                display: none;
            }
            
            nav ul li.show-submenu > ul {
                display: flex;
                flex-direction: column;
            }
            
            nav ul li a {
                display: block;
                padding: 10px 0;
            }

            /* Other Sections */
            .hero h1 {
                font-size: 1.6rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .hero-btn,
            .cta-btn,
            button {
                width: 100%;
                text-align: center;
                padding: 14px;
            }
            
            .testimonial {
                flex: 0 0 100%;
            }
            
            #faq h2, #cta h2 {
                font-size: 1.4rem;
            }

            #cta p {
                font-size: 1rem;
            }
            
            form {
                width: 100%;
                padding: 20px;
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .testimonial-btn.prev { left: 5px; }
            .testimonial-btn.next { right: 5px; }
        }
    </style>
</head>
<body>

    <header>
        <button class="hamburger" id="hamburger"> ☰ </button>
        <div class="logo">
            <img src="eg_img/header_logo.png" alt="My Website Logo">
        </div>
        <nav>
            <ul>
                <li><a href="#hero">Home</a></li>
                <li class="dropdown">
                    <a href="#about">About ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="#about">Who We Are</a></li>
                        <li><a href="#about">Our Mission</a></li>
                        <li><a href="#about">Team</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#services">Services ▾</a>
                    <ul class="dropdown-menu">
                        <li><a href="#services">Web Design</a></li>
                        <li><a href="#services">Development</a></li>
                        <li><a href="#services">Marketing</a></li>
                    </ul>
                </li>
                <li><a href="#how">How it Works</a></li>
                <li><a href="#signup">Contact</a></li>
            </ul>
        </nav>
        <a href="#contact" class="btn-nav">Get Started</a>
    </header>

    <section class="hero" id="hero">
        <div class="slide slide1"></div>
        <div class="slide slide2"></div>
        <div class="slide slide3"></div>
        <div class="slide slide4"></div>
        <div class="hero-content">
            <h1>Welcome to Line Seiki Web</h1>
            <p>At Line Seiki Asia Pacific, we specialize in delivering high-quality measuring instruments and smart monitoring systems tailored to your needs.</p>
            <a href="#about" class="hero-btn">Learn More</a>
        </div>
    </section>

    <section id="about">
        <div class="about-container">
            <div class="about-text">
                <h2>About Us</h2>
                <p>We are dedicated to providing high-quality services to help you achieve your goals. Our mission is to deliver excellence with every project.</p>
                <p>With years of experience and a passionate team, we strive to exceed expectations and build long-term partnerships.</p>
            </div>
            <div class="about-img">
                <img src="eg_img/team.jpg" alt="Our Team">
            </div>
        </div>
    </section>

    <section id="services">
        <h2>Our Services</h2>
        <p>Explore the range of services we provide to make your life easier.</p>
        <div class="cards">
            <div class="card">
                <h3>Simulation Analysis Service</h3>
                <p>Advanced simulation technology utilizing the latest analysis algorithms and high-speed processing capabilities.</p>
            </div>
            <div class="card">
                <h3>Fatigue Simulation (Nastran/Patran/Apex)</h3>
                <p>Analyze fluid flow, heat transfer, and related phenomena for optimal design.</p>
            </div>
            <div class="card">
                <h3>Silicone Molding and Urethrane Casting</h3>
                <p>Overview of our low-volume prototyping service using silicone molds and urethane casting.</p>
            </div>
        </div>
    </section>

    <section id="how">
        <h2>How it Works</h2>
        <p>Our simple 3-step process ensures you get the best results.</p>
        <div class="steps">
            <div class="step">
                <h3>Step 1</h3>
                <p>Sign up for an account.</p>
            </div>
            <div class="step">
                <h3>Step 2</h3>
                <p>Choose the service you need.</p>
            </div>
            <div class="step">
                <h3>Step 3</h3>
                <p>Enjoy the results delivered quickly.</p>
            </div>
        </div>
    </section>

    <section id="testimonials">
        <h2>What Our Clients Say</h2>
        <div class="testimonial-wrapper">
            <button class="testimonial-btn prev">❮</button>
            <div class="testimonial-slider">
                <div class="testimonial">
                    <img src="eg_img/johnd.jpg" alt="John D." class="profile-pic">
                    <p>"This company transformed our business!"</p>
                    <h4>- John D.</h4>
                </div>
                <div class="testimonial">
                    <img src="eg_img/sarah.jpg" alt="Sarah W." class="profile-pic">
                    <p>"Excellent support and amazing results."</p>
                    <h4>- Sarah W.</h4>
                </div>
                <div class="testimonial">
                    <img src="eg_img/michael.jpg" alt="Michael T." class="profile-pic">
                    <p>"Truly professional and reliable team."</p>
                    <h4>- Michael T.</h4>
                </div>
                <div class="testimonial">
                    <img src="eg_img/anna.jpg" alt="Anna P." class="profile-pic">
                    <p>"They delivered more than we expected!"</p>
                    <h4>- Anna P.</h4>
                </div>
            </div>
            <button class="testimonial-btn next">❯</button>
        </div>
    </section>

    <section id="blog">
        <h2>Latest Insights</h2>
        <div class="blog-cards">
            <div class="blog-card">
                <h3>How Technology Shapes Business</h3>
                <p>Learn how innovation drives growth in modern companies.</p>
            </div>
            <div class="blog-card">
                <h3>Top 5 Web Trends in 2025</h3>
                <p>Stay updated with the latest design and tech movements.</p>
            </div>
            <div class="blog-card">
                <h3>Improving Efficiency with AI</h3>
                <p>Discover how automation can transform workflows.</p>
            </div>
        </div>
    </section>

    <section id="partners">
        <h2>Our Partners & Associates</h2>
        <p>We are proud to work with industry leaders and trusted associates worldwide.</p>
        <div class="partners-logos">
            <div class="partner"><img src="eg_img/gamma.png" alt="Partner 1"></div>
            <div class="partner"><img src="eg_img/mitel.png" alt="Partner 2"></div>
            <div class="partner"><img src="eg_img/mcdo.png" alt="Partner 3"></div>
            <div class="partner"><img src="eg_img/canon.jpg" alt="Partner 4"></div>
            <div class="partner"><img src="eg_img/ring.png" alt="Partner 5"></div>
        </div>
    </section>

    <section class="signup" id="signup">
        <h2>Create Your Account</h2>
        <p>Sign up now and get started with our services.</p>
        <form class="signup-form">
            <div class="form-group">
                <input type="text" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <input type="password" id="password" placeholder="Password" required>
            </div>
            <div class="form-group">
                <input type="password" id="confirm-password" placeholder="Confirm Password" required>
            </div>
            <div class="show-pass">
                <input type="checkbox" id="togglePassword">
                <label for="togglePassword">Show Password</label>
            </div>
            <button type="submit" class="signup-btn">Sign Up</button>
        </form>
    </section>

    <section id="faq">
        <h2>Frequently Asked Questions</h2>
        <p>Find answers to some of the most common questions below.</p>
        <div class="faq-container">
            <div class="faq-item">
                <button class="faq-question">What services do you provide? ▾</button>
                <div class="faq-answer">
                    <p>We specialize in web design, development, and digital marketing tailored to your business needs.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">How can I get started? ▾</button>
                <div class="faq-answer">
                    <p>Simply sign up through our website or contact us directly for a free consultation.</p>
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">Do you offer customer support? ▾</button>
                <div class="faq-answer">
                    <p>Yes! We provide ongoing customer support to ensure everything runs smoothly.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="cta">
        <div class="cta-content">
            <h2>Ready to Take Your Business to the Next Level?</h2>
            <p>Contact us today and let’s build something great together.</p>
            <a href="#contact" class="cta-btn">Get in Touch</a>
        </div>
    </section>

    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-col company-info">
                <div class="footer-logo">
                    <img src="eg_img/header_logo.png" alt="My Logo">
                </div>
                <p>123 Business Street,<br>Tokyo 152-0001, JAPAN</p>
                <p>TEL: +63 12 345 6789</p>
                <p>Email: info@mycompany.com</p>
            </div>
            <div class="footer-col">
                <h4>Products & Services</h4>
                <ul>
                    <li><a href="#">Web Design</a></li>
                    <li><a href="#">Development</a></li>
                    <li><a href="#">Marketing</a></li>
                    <li><a href="#">Consulting</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Solutions</h4>
                <ul>
                    <li><a href="#">IoT</a></li>
                    <li><a href="#">AI Automation</a></li>
                    <li><a href="#">Data Analytics</a></li>
                    <li><a href="#">Cloud Hosting</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Company</h4>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Line Seiki. All rights reserved.</p>
            <div class="footer-social">
                <a href="#">Facebook</a> | <a href="#">Twitter</a> | <a href="#">Instagram</a> | <a href="#">LinkedIn</a>
            </div>
        </div>
    </footer>

    <a href="#signup" class="floating-btn">✉ Contact</a>

    <script>
        // Hamburger menu toggle
        const hamburger = document.getElementById("hamburger");
        const navMenu = document.querySelector("nav ul");
        hamburger.addEventListener("click", () => {
            navMenu.classList.toggle("show");
        });

        // Dropdown toggle for mobile
        document.querySelectorAll("nav ul li.dropdown > a").forEach(link => {
            link.addEventListener("click", (e) => {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const parent = link.parentElement;
                    parent.classList.toggle("show-submenu");
                }
            });
        });

        // Show/Hide password toggle
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm-password');

        if (togglePassword) {
            togglePassword.addEventListener('change', function() {
                const type = this.checked ? 'text' : 'password';
                if (password) password.type = type;
                if (confirmPassword) confirmPassword.type = type;
            });
        }
        
        // FAQ accordion toggle
        document.querySelectorAll(".faq-question").forEach(button => {
            button.addEventListener("click", () => {
                const answer = button.nextElementSibling;
                const isOpen = answer.style.display === "block";
                
                // Close all other answers
                document.querySelectorAll(".faq-answer").forEach(a => {
                    if (a !== answer) {
                        a.style.display = "none";
                    }
                });
                
                // Toggle current answer
                answer.style.display = isOpen ? "none" : "block";
            });
        });

        // Testimonial slider functionality
        const slider = document.querySelector(".testimonial-slider");
        const prevBtn = document.querySelector(".testimonial-btn.prev");
        const nextBtn = document.querySelector(".testimonial-btn.next");

        if (slider && prevBtn && nextBtn) {
            function getScrollAmount() {
                const firstCard = slider.querySelector(".testimonial");
                return firstCard ? firstCard.offsetWidth + 20 : 0; // card width + gap
            }
            
            nextBtn.addEventListener("click", () => {
                slider.scrollBy({ left: getScrollAmount(), behavior: "smooth" });
            });
            
            prevBtn.addEventListener("click", () => {
                slider.scrollBy({ left: -getScrollAmount(), behavior: "smooth" });
            });
            
            // Mouse drag functionality for slider
            let isDown = false;
            let startX;
            let scrollLeft;
            
            slider.addEventListener("mousedown", (e) => {
                isDown = true;
                slider.classList.add("active");
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener("mouseleave", () => {
                isDown = false;
            });
            
            slider.addEventListener("mouseup", () => {
                isDown = false;
            });
            
            slider.addEventListener("mousemove", (e) => {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1.5;
                slider.scrollLeft = scrollLeft - walk;
            });
        }
    </script>
</body>
</html>