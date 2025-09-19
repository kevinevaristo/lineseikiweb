<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Homepage</title>
<style>
/* Reset */
* {margin:0; padding:0; box-sizing:border-box;}
body {font-family: 'Segoe UI', Arial, sans-serif; color:#333; line-height:1.6; background:#fff;}
/*RESPONSIVE STYLES/*
/* Tablets (≤ 992px) */
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
/* Mobile (≤ 600px) */
@media (max-width: 600px) {
header nav {
flex-direction: column;
text-align: center;
}
header nav ul {
flex-direction: column;
gap: 10px;
}
.hero h1 {
font-size: 1.6rem;
}
.hero p {
font-size: 1rem;
}
.hero-btn, .cta-btn, button {
width: 100%; /* buttons stretch full width */
text-align: center;
padding: 14px;
}
.testimonial {
flex: 0 0 100%; /* 1 per row */
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
}
/* Navbar */
header {
background: linear-gradient(90deg, #0d1b2a, #1b263b);
display:flex;
justify-content:space-between;
align-items:center;
padding:15px 50px;
position:sticky;
top:0;
z-index:1000;
box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}
.logo img {height:40px;}
nav ul {display:flex; list-style:none;}
nav ul li {margin-left:25px; position:relative;}
nav ul li a {
text-decoration:none;
color:#fff;
font-weight:600;
transition:all 0.3s;
font-size:15px;
}
nav ul li a:hover {color:#f39c12;}
.btn-nav {
background:#f39c12;
color:#fff;
padding:10px 20px;
border-radius:30px;
font-weight:600;
text-decoration:none;
transition: all 0.3s;
}
.btn-nav:hover {background:#ffd60a; color:#0d1b2a;}
/* Dropdown */
nav ul li ul {
display:none;
position:absolute;
top:100%;
left:0;
background:#fff;
list-style:none;
min-width:180px;
border-radius:6px;
box-shadow:0 8px 15px rgba(0,0,0,0.2);
}
nav ul li ul li {margin:0;}
nav ul li ul li a {
display:block;
padding:12px 18px;
color:#333;
}
nav ul li ul li a:hover {background:#f39c12; color:#fff;}
nav ul li:hover ul {display:block;}
/* Hero */
.hero {
position: relative;
height: 85vh;
display:flex;
align-items:center;
color:#fff;
padding-left:120px;
text-align:left;
}
.hero-content {
z-index:2;
background:rgba(0,0,0,0.55);
padding:40px;
border-radius:12px;
max-width:600px;
animation: fadeInUp 1.2s ease;
}
.hero h1 {
font-size:52px;
margin-bottom:20px;
font-weight:700;
color:#ffd60a;
}
.hero p {font-size:18px; margin-bottom:25px; color:#fff;}
.hero-btn {
display:inline-block;
background:#f39c12;
color:#fff;
padding:12px 28px;
border-radius:30px;
text-decoration:none;
font-weight:600;
transition: all 0.3s;
}
.hero-btn:hover {background:#ffd60a; color:#0d1b2a;}
/* Hero bg slides */
.slide {
position:absolute;
top:0;
left:0;
width:100%;
height:100%;
background-size:cover;
background-position:center;
opacity:0;
animation:fade 12s infinite;
}
.slide1 {background-image:url('eg_img/LS.jpg'); animation-delay:0s;}
.slide2 {background-image:url('eg_img/LS2.jpg'); animation-delay:3s;}
.slide3 {background-image:url('eg_img/LS3.jpg'); animation-delay:6s;}
.slide4 {background-image:url('eg_img/gemba2.png'); animation-delay:9s;}
@keyframes fade {0%,100%{opacity:0;} 10%,30%{opacity:1;}}
/* Sections */
section {padding:90px 60px; text-align:center;}
section h2 {font-size:34px; margin-bottom:20px; font-weight:700;}
section p {max-width:800px; margin:0 auto 30px; font-size:17px; color:#555;}
/* About */
#about {background:#f9f9f9;}
#about h2 {color:#0d1b2a;}
/* Services / Cards */
#services .cards {
display:grid;
grid-template-columns:repeat(auto-fit, minmax(280px,1fr));
gap:25px;
margin-top:50px;
}
.card {
background:#fff;
padding:30px;
border-radius:12px;
box-shadow:0 6px 16px rgba(0,0,0,0.1);
text-align:left;
transition:all 0.3s;
}
.card h3 {color:#0d1b2a; margin-bottom:15px; font-size:20px;}
.card p {color:#555; font-size:15px;}
.card:hover {
transform: translateY(-8px);
box-shadow:0 12px 25px rgba(0,0,0,0.15);
}
/* Steps */
#how {background:#f9f9f9;}
.steps {display:flex; flex-wrap:wrap; gap:25px; justify-content:center; margin-top:40px;}
.step {
flex:1 1 280px;
background:#fff;
padding:25px;
border-radius:12px;
box-shadow:0 6px 16px rgba(0,0,0,0.1);
transition:all 0.3s;
}
.step h3 {color:#0d1b2a; margin-bottom:10px;}
.step:hover {transform:translateY(-8px);}
/* Testimonials */
#testimonials {
background:#f9f9f9;
padding:90px 60px;
text-align:center;
}
#testimonials h2 {
font-size:34px;
margin-bottom:40px;
font-weight:700;
color:#0d1b2a;
}
.testimonial-slider {
position:relative;
max-width:700px;
margin:0 auto;
overflow:hidden;
}
.testimonial p {
font-size:18px;
color:#555;
margin-bottom:15px;
font-style:italic;
}
.testimonial .stars {
color:#f39c12;
font-size:20px;
margin-bottom:10px;
}
.testimonial h4 {
font-weight:600;
color:#0d1b2a;
}
@keyframes fadeIn {
from {opacity:0; transform:translateY(20px);}
to {opacity:1; transform:translateY(0);}
}
/* Footer */
.site-footer {
background: #0d1b2a;
color: #fff;
padding: 50px 60px 20px;
font-size: 15px;
}
.footer-container {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
gap: 40px;
margin-bottom: 30px;
}
.footer-col h3, .footer-col h4 {
color: #ffd60a;
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
}
.footer-col ul li a:hover {
color: #f39c12;
}
.company-info p {
margin-bottom: 8px;
color: #ccc;
}
.footer-bottom {
border-top: 1px solid rgba(255,255,255,0.2);
padding-top: 15px;
display: flex;
flex-wrap: wrap;
justify-content: space-between;
align-items: center;
}
.footer-social a {
color: #f39c12;
text-decoration: none;
margin: 0 5px;
}
.footer-social a:hover {
color: #ffd60a;
}
/* Responsive */
@media (max-width: 768px) {
.footer-bottom {
flex-direction: column;
text-align: center;
gap: 10px;
}
}
/* Animations */
@keyframes fadeInUp {
from {opacity:0; transform:translateY(40px);}
to {opacity:1; transform:translateY(0);}
}
/* Partners Section */
#partners {
background:#fff;
padding:90px 60px;
text-align:center;
}
#partners h2 {
font-size:34px;
margin-bottom:20px;
font-weight:700;
color:#0d1b2a;
}
#partners p {
max-width:700px;
margin:0 auto 50px;
font-size:17px;
color:#555;
}
.partners-logos {
display:grid;
grid-template-columns:repeat(auto-fit, minmax(150px,1fr));
gap:30px;
align-items:center;
justify-content:center;
}
.partner img {
max-width:140px;
margin:auto;
transition:all 0.3s ease;
filter:grayscale(0%);
}
.partner img:hover {
transform:scale(1.1);
filter:grayscale(0%);
}
/* Signup Form */
.signup {
position: relative;
padding: 60px;
background: url("eg_img/1234.png") no-repeat center center/cover; /* your image */
color: #fff;
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
z-index: 1; /* keeps inputs, labels & button above overlay */
}
#signup h2 {
font-size:32px;
color:#0d1b2a;
margin-bottom:15px;
}
#signup p {
margin-bottom:30px;
font-size:16px;
color:#555;
}
.signup-form {
max-width:500px;
margin:0 auto;
display:flex;
flex-direction:column;
gap:20px;
}
.signup-form .form-group input {
width:100%;
padding:14px;
border:1px solid #ccc;
border-radius:8px;
font-size:15px;
outline:none;
transition: border 0.3s;
}
.signup-form .form-group input:focus {
border-color:#f39c12;
}
.signup-btn {
background:#f39c12;
color:#fff;
padding:14px;
border:none;
border-radius:30px;
font-size:16px;
font-weight:600;
cursor:pointer;
transition: all 0.3s;
}
.signup-btn:hover {
background:#ffd60a;
color:#0d1b2a;
}
/* Show Password Checkbox */
.show-pass {
display: flex;
align-items: center;
justify-content: flex-start;
font-size: 14px;
color: #333;
gap: 4px; /* keep text closer to checkbox */
margin-top: -10px; /* optional: pull it up a little */
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
/* --- EXTRA DESIGN POLISH --- */
/* Smooth scroll effect */
html {
scroll-behavior: smooth;
}
/* Navbar hover underline */
nav ul li a {
position: relative;
}
nav ul li a::after {
content: "";
position: absolute;
left: 0;
bottom: -6px;
width: 0%;
height: 2px;
background: #f39c12;
transition: width 0.3s;
}
nav ul li a:hover::after {
width: 100%;
}
/* Hero content glow */
.hero-content {
box-shadow: 0 8px 25px rgba(0,0,0,0.4);
backdrop-filter: blur(4px);
}
/* Hero button pulse animation */
.hero-btn {
position: relative;
overflow: hidden;
}
.hero-btn::before {
content: "";
position: absolute;
top: 0;
left: -100%;
width: 100%;
height: 100%;
background: rgba(255,255,255,0.3);
transform: skewX(-20deg);
transition: all 0.5s;
}
.hero-btn:hover::before {
left: 100%;
}
/* Service cards hover effect */
.card {
border-top: 4px solid transparent;
}
.card:hover {
border-top: 4px solid #f39c12;
}
/* Step icons circle effect */
.step {
position: relative;
}
.step::before {
content: "✔";
position: absolute;
top: -15px;
left: 15px;
background: #f39c12;
color: #fff;
width: 30px;
height: 30px;
border-radius: 50%;
display:flex;
align-items:center;
justify-content:center;
font-size: 14px;
box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
/* Testimonials */
#testimonials {
background:#f9f9f9;
padding:90px 60px;
text-align:center;
}
#testimonials h2 {
font-size:34px;
margin-bottom:40px;
font-weight:700;
color:#0d1b2a;
}
/* Slider container */
.testimonial-slider {
display: flex;
gap: 20px;
overflow-x: auto;
scroll-snap-type: x mandatory;
padding-bottom: 20px;
scrollbar-width: none; /* hide scrollbar Firefox */
}
.testimonial-slider::-webkit-scrollbar {
display: none; /* hide scrollbar Chrome */
}
/* Testimonial cards */
#testimonials {
padding: 80px 20px;
text-align: center;
background: #f8f8f8;
}
#testimonials h2 {
margin-bottom: 30px;
font-size: 2rem;
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
scrollbar-width: none;
}
.testimonial-slider::-webkit-scrollbar {display: none;}
.testimonial {
flex: 0 0 calc(33.333% - 20px);
background: #fff;
padding: 25px;
border-radius: 12px;
box-shadow: 0 6px 16px rgba(0,0,0,0.1);
scroll-snap-align: start;
text-align: left;
min-height: 180px;
}
.testimonial h4 {
margin-top: 15px;
color: #555;
font-weight: 600;
}
.testimonial-btn {
position: absolute;
top: 50%;
transform: translateY(-50%);
background: #f39c12;
color: #fff;
border: none;
width: 40px; /* fixed width */
height: 40px; /* fixed height */
border-radius: 50%; /* make circular */
font-size: 18px; /* arrow size */
font-weight: bold;
display: flex;
align-items: center;
justify-content: center;
cursor: pointer;
box-shadow: 0 4px 10px rgba(0,0,0,0.2);
transition: background 0.3s;
z-index: 10;
padding: 0; /* prevent stretching */
}
.testimonial-btn:hover {
background: #d35400;
}
/* Adjust position for small screens */
.testimonial-btn.prev {
left: -20px;
}
.testimonial-btn.next {
right: -20px;
}
@media (max-width: 600px) {
.testimonial-btn.prev {
left: 5px;
}
.testimonial-btn.next {
right: 5px;
}
}
/* Partners logo grayscale hover */
.partner img {
filter: grayscale(0%);
}
.partner img:hover {
filter: grayscale(0%) drop-shadow(0 4px 8px rgba(0,0,0,0.2));
}
/* Signup form floating labels style */
.signup-form .form-group {
position: relative;
}
.signup-form .form-group input:focus::placeholder {
color: transparent;
}
.signup-form .form-group input:focus {
box-shadow: 0 0 0 3px rgba(243,156,18,0.3);
}
/* Footer link hover glow */
footer a {
position: relative;
transition: color 0.3s;
}
footer a::after {
content: "";
position: absolute;
left: 0;
bottom: -5px;
height: 2px;
width: 0%;
background: #ffd60a;
transition: width 0.3s;
}
footer a:hover::after {
width: 100%;
}
/* Footer */
footer {
background: linear-gradient(90deg, #0d1b2a, #1b263b);
color:#fff;
padding:30px 20px;
text-align:center;
}
/* FAQ Section */
#faq {
background: #f9f9f9;
padding:90px 60px;
text-align:center;
}
#faq h2 {
font-size:34px;
margin-bottom:20px;
font-weight:700;
color:#f39c12;
}
.faq-container {
max-width:800px;
margin:40px auto 0;
text-align:left;
}
.faq-item {
border-bottom:1px solid #ddd;
padding:15px 0;
}
.faq-question {
background:none;
border:none;
width:100%;
text-align:left;
font-size:18px;
font-weight:600;
cursor:pointer;
color:#0d1b2a;
display:flex;
justify-content:space-between;
align-items:center;
}
.faq-answer {
display:none;
margin-top:10px;
font-size:16px;
color:#555;
}
/* FAQ Section */
#faq {
position: relative;
padding: 90px 60px;
text-align: center;
color: #ffd60a; /* make text white for readability */
background: url("eg_img/LS.jpg") no-repeat center center/cover; /* your image */
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
z-index: 1; /* keeps text above overlay */
color: #ffd60a;
}
/* CTA Section */
#cta {
background: linear-gradient(90deg, #0d1b2a, #1b263b);
color:#fff;
padding:80px 40px;
text-align:center;
}
#cta h2 {
font-size:36px;
margin-bottom:20px;
font-weight:700;
}
#cta p {
font-size:18px;
margin-bottom:30px;
color:#ddd;
}
.cta-btn {
display:inline-block;
background:#f39c12;
color:#fff;
padding:14px 34px;
border-radius:30px;
font-weight:600;
text-decoration:none;
transition:all 0.3s;
}
.cta-btn:hover {
background:#ffd60a;
color:#0d1b2a;
}
section::after {
content: "";
display: block;
height: 60px;
background: url("wave.svg") no-repeat center bottom;
}
#blog {
background: #f9f9f9;
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
background: #fff;
padding: 20px;
border-radius: 12px;
box-shadow: 0 6px 16px rgba(0,0,0,0.1);
text-align: left;
}
.blog-card h3 {
margin-bottom: 10px;
color: #0d1b2a;
}
.blog-card p {
font-size: 15px;
color: #555;
}
.floating-btn {
position: fixed;
bottom: 20px;
right: 20px;
background: #f39c12;
color: #fff;
padding: 14px 20px;
border-radius: 50px;
font-weight: 600;
text-decoration: none;
box-shadow: 0 4px 10px rgba(0,0,0,0.3);
transition: all 0.3s;
z-index: 2000;
}
.floating-btn:hover {
background: #ffd60a;
color: #0d1b2a;
}
/* Floating Contact Button */
.floating-btn {
position: fixed;
right: 20px;
bottom: 80px; /* increase this value (e.g., 80px) to move button higher */
background: #f39c12;
color: #fff;
border: none;
padding: 12px 20px;
border-radius: 30px;
cursor: pointer;
font-weight: bold;
box-shadow: 0 4px 6px rgba(0,0,0,0.3);
transition: background 0.3s;
}
.contact-btn:hover {
background: #e67e22;
}
/* Hide hamburger by default */
.hamburger {
display: none;
font-size: 28px;
background: none;
border: none;
cursor: pointer;
color: #333;
z-index: 2000;
}
/* Mobile nav styles */
@media (max-width: 768px) {
nav ul {
display: none; /* hide menu by default */
flex-direction: column;
background: #fff;
position: absolute;
top: 60px; /* below header */
right: 20px;
width: 200px;
padding: 15px;
box-shadow: 0 4px 12px rgba(0,0,0,0.2);
border-radius: 12px;
}
nav ul.show {
display: flex; /* show when toggled */
}
nav ul li a {
color: #0d1b2a; /* ✅ make text dark so it’s visible */
}
nav ul li a:hover {
color: #f39c12; /* ✅ hover effect consistent with desktop */
}
.hamburger {
display: block; /* show hamburger */
color: #fff; /* keep icon white to match header */
}
}
@media (max-width: 768px) {
nav ul li {
position: relative;
}
nav ul li ul {
position: static; /* remove absolute positioning */
background: none; /* remove white box */
box-shadow: none; /* remove floating shadow */
padding-left: 15px; /* indent child items */
display: none; /* hide by default */
}
nav ul li.show-submenu > ul {
display: flex;
flex-direction: column;
}
nav ul li a {
display: block;
padding: 10px 0;
}
}
footer {
background: #222;
color: #fff;
text-align: center;
padding: 20px;
}
.footer-logo img {
max-width: 120px; /* adjust size */
margin-bottom: 10px;
}
html {
scroll-behavior: smooth;
}
.features {
display: grid;
grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
gap: 1rem;
}
:root {
--primary-color: #0077cc;
--secondary-color: #f4f4f4;
--font-main: 'Segoe UI', Arial, sans-serif;
}
body {
font-family: var(--font-main);
color: var(--primary-color);
}
/* Testimonial profile pictures */
.profile-pic {
width: 70px;
height: 70px;
border-radius: 50%;
object-fit: cover;
margin-bottom: 15px;
box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
/* About Section */
#about {
background:#f9f9f9;
padding:90px 60px;
}
.about-container {
display:flex;
align-items:center;
justify-content:space-between;
gap:40px;
max-width:1100px;
margin:auto;
flex-wrap:wrap;
}
.about-text {
flex:1;
text-align:left;
}
.about-text h2 {
color:#0d1b2a;
font-size:34px;
margin-bottom:20px;
}
.about-text p {
color:#555;
font-size:16px;
line-height:1.6;
margin-bottom:15px;
}
.about-img {
flex:1;
text-align:center;
}
.about-img img {
max-width:100%;
border-radius:12px;
box-shadow:0 6px 16px rgba(0,0,0,0.1);
transition: transform 0.3s ease;
}
.about-img img:hover {
transform:scale(1.05);
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
<li><a href="#contact">Contact</a></li>
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
<a href="#about" class="hero-btn">Learn More</a> <p>At Line Seiki Asia Pacific, we specialize in delivering high-quality measuring instruments and smart monitoring systems tailored to your needs.</p>
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
<div class="step"><h3>Step 1</h3><p>Sign up for an account.</p></div>
<div class="step"><h3>Step 2</h3><p>Choose the service you need.</p></div>
<div class="step"><h3>Step 3</h3><p>Enjoy the results delivered quickly.</p></div>
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
</section>
<section id="blog">
<h2>Latest Insights</h2>
<div class="blog-cards">
<div class="blog-card"><h3>How Technology Shapes Business</h3><p>Learn how innovation drives growth in modern companies.</p></div>
<div class="blog-card"><h3>Top 5 Web Trends in 2025</h3><p>Stay updated with the latest design and tech movements.</p></div>
<div class="blog-card"><h3>Improving Efficiency with AI</h3><p>Discover how automation can transform workflows.</p></div>
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
const togglePassword = document.getElementById('togglePassword');
const password = document.getElementById('password');
const confirmPassword = document.getElementById('confirm-password');
togglePassword.addEventListener('change', function() {
const type = this.checked ? 'text' : 'password';
password.type = type;
confirmPassword.type = type;
});
// FAQ accordion toggle
document.querySelectorAll(".faq-question").forEach(button => {
button.addEventListener("click", () => {
const answer = button.nextElementSibling;
const isOpen = answer.style.display === "block";
// Close all other answers
document.querySelectorAll(".faq-answer").forEach(a => a.style.display = "none");
// Toggle current answer
answer.style.display = isOpen ? "none" : "block";
});
});
const slider = document.querySelector(".testimonial-slider");
const prevBtn = document.querySelector(".testimonial-btn.prev");
const nextBtn = document.querySelector(".testimonial-btn.next");
function scrollAmount() {
return slider.querySelector(".testimonial").offsetWidth + 20; // card width + gap
}
nextBtn.addEventListener("click", () => {
slider.scrollBy({ left: scrollAmount(), behavior: "smooth" });
});
prevBtn.addEventListener("click", () => {
slider.scrollBy({ left: -scrollAmount(), behavior: "smooth" });
});
// Optional: allow swipe with mouse drag
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
if(!isDown) return;
e.preventDefault();
const x = e.pageX - slider.offsetLeft;
const walk = (x - startX) * 1.5;
slider.scrollLeft = scrollLeft - walk;
});
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
</script>
</body>
</html>