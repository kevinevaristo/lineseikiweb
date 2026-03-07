<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Terms Of Service - Line Seiki Asia Pacific</title>

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
      <h1 class="fade-in">Terms Of Service</h1>
    </div>

    <div class="container text-start mt-5">
      <p><strong>Line Seiki Terms and Conditions of Website Use</strong></p>

      <p>Welcome to the Line Seiki (“Line Seiki”) Website. We are continuously working to make our Website informative and useful, and would appreciate your feedback on how we can make it even better. In return for access to the information we have provided, please abide by the legal terms and conditions stated below. Please read these terms and conditions carefully, because by using a Line Seiki Website, you are acknowledging and agreeing to them. If you do not agree with these terms and conditions, you may not use this site.</p>

      <p><strong>Copyright Information</strong><br>
      Copyright © 2023 Line Seiki Co., Ltd.. All rights reserved.<br><br>
      All names, logos, trademarks or service marks contained in this Website are owned or licensed by Line Seiki or its affiliates and may not be used without Line Seiki’s prior written approval. The trademarks of Line Seiki belong exclusively to Line Seiki or its licensors and are protected by Japanese and international trademark laws and treaties.</p>

      <hr>
      <h5>Limited License to Use Materials</h5>
      <p>Line Seiki grants you the right to display and reproduce material on this Website for your personal use only, provided that:</p>
      <ul>
        <li>The material is used for educational or informational purposes only and is not sold or distributed for commercial gain, and</li>
        <li>The copyright information listed above appears on every copy of the material and any portion thereof.</li>
      </ul>
      <p>Except as noted above, no right or license is granted under any copyright, patent, or trademark of Line Seiki to any other party.</p>

      <hr>
      <h5>Disclaimer of Warranty</h5>
      <ul>
        <li>Line Seiki provides the information on this Website free of charge, subject to these terms and conditions.
        While Line Seiki makes reasonable efforts to ensure the information is accurate and up-to-date, Line Seiki makes no warranties or representations, express or implied, as to the accuracy, completeness, or any other aspect of the information on this Website and assumes no liability in connection with any use of this information.
        Nothing herein shall be construed as a recommendation or license to use any information found on this Website that conflicts with any patent, trademark or copyright of Line Seiki or others, and Line Seiki makes no representations or warranties, express or implied that any use of this information will not infringe any such patent, trademark or copyright.</li><br>
        <li>THIS WEBSITE, AND ALL INFORMATION AND MATERIALS CONTAINED HEREIN, ARE PROVIDED TO YOU “AS IS” AND WITHOUT ANY WARRANTY OF ANY KIND, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE, TITLE OR NON-INFRINGEMENT.</li>
      </ul>

      <hr>
      <h5>Limitation of Liability</h5>
      <ul>
        <li>NEITHER LINE SEIKI NOR ANY PARTY INVOLVED IN CREATING, PRODUCING OR DELIVERING THIS WEBSITE WILL BE LIABLE FOR ANY DAMAGES OR INJURY THAT ACCOMPANY OR RESULT FROM YOUR ACCESS TO AND USE OF THIS WEBSITE, OR YOUR INABILITY TO ACCESS AND USE THIS WEBSITE, OR FROM DOWNLOADING ANY MATERIAL CONTAINED ON THIS SITE.
        NOR WILL ANY SUCH PARTY BE LIABLE FOR ANY DIRECT, INCIDENTAL, CONSEQUENTIAL, INDIRECT, OR PUNITIVE DAMAGES, OR ANY OTHER LOSSES, COSTS, OR EXPENSES OF ANY KIND WHICH MAY ARISE, DIRECTLY, OR INDIRECTLY FROM YOUR USE OF, OR INABILITY TO USE, THIS SITE, INCLUDING BUT NOT LIMITED TO, ANYTHING CAUSED BY: A) INCOMPLETE OR INACCURATE INFORMATION; B) COMPUTER VIRUSES; C) SOFTWARE BUGS; D) HUMAN ACTION OR INACTION; E) ANY COMPUTER SYSTEM, PHONE LINE, HARDWARE, SOFTWARE OR PROGRAM MALFUNCTIONS; OR F) ANY OTHER ERRORS, FAILURE OR DELAYS IN COMPUTER TRANSMISSION OR NETWORK CONNECTIONS.</li>
      </ul>

      <hr>
      <h5>Submission of Materials</h5>
      <ul>
        <li>All comments, suggestions, ideas, graphics, or other information that you transmit to Line Seiki through this Website become and will remain Line Seiki’s property and may be used by Line Seiki anywhere, anytime and for any reason whatsoever.
        Any materials or information submitted to Line Seiki will be treated as non-confidential and non-proprietary, and Line Seiki will not have any obligation to use or evaluate any information it receives from you.
        In addition, Line Seiki will not be under any obligation to respond in any way or reveal to you any information about Line Seiki.
        Line Seiki will not have to pay you or anyone else for using any ideas or other materials that you may transmit to Line Seiki in connection with the use of this Website.
        You should rely solely on your rights under the patent, trademark, and copyright laws.
        The receipt or consideration of your information by Line Seiki shall in no way impair Line Seiki’s right to contest the validity of your patent, trademark, or copyright.
        Of course, you are not to transmit to this Website any material which is unlawful, threatening, violent, abusive, harassive, degrading, defamatory, libelous, deceptive, fraudulent, or which may give rise to civil or criminal liability, infringe a third party’s intellectual property rights or otherwise violate any law or regulation.
        Even though Line Seiki may monitor and review transmissions, we assume no responsibility or liability which may arise from the content thereof, including, but not limited to, claims for defamation, libel, slander, obscenity, pornography, profanity, or misrepresentation.</li>
      </ul>

      <hr>
      <h5>Hyperlinks and Frames</h5>
      <ul>
        <li>This Website may include hyperlinks to other independent websites.
        Line Seiki is not responsible for the content posted on these independent websites and does not endorse or approve any products or information offered at these websites.
        Line Seiki may permit links to its Website, as long as they do not imply endorsement, sponsorship or affiliation.
        We do require, however, that you get our prior written consent before creating any kind of hyperlink to this Website.
        You may frame this Website only with the prior written consent of Line Seiki.</li>
      </ul>

      <hr>
      <h5>Use of Website; Compliance with Laws</h5>
      <ul>
        <li>Unless otherwise specified, the material on this Website is intended to provide information about Line Seiki and its products.
        Line Seiki controls and operates its Website from the Company’s headquarters in Manila, Philippines. We do not imply that the materials published on Line Seiki’s Website are designed or appropriate for use outside of the Philippines or Japan.
        If you access our Website from outside of the Philippines or Japan, please be aware you are responsible for compliance with any applicable local laws.
        To the extent any applicable local laws prohibit your viewing and use of this Website, you may not view or use this Website.</li>
      </ul>

      <hr>
      <h5>Export Controls</h5>
      <ul>
        <li>You may not export or re-export any information or products received on a Line Seiki Website except in full compliance with all Japanese and Philippine export laws and regulations. Use contrary to those laws is prohibited.
        Neither the products, nor any information acquired through the use of a Line Seiki Website, may be acquired for, shipped, transferred, or re-exported, directly or indirectly, to proscribed or embargoed countries or their nationals or residents, nor may the products of information be used for nuclear activities, missile projects, chemical or biological weapons, or terrorist activities.
        You are responsible for complying with any local laws in your country, which may impact your right to import, export or use the information or products found on Line Seiki Websites.</li>
      </ul>

      <hr>
      <h5>Jurisdiction, Choice of Law and Forum</h5>
      <ul>
        <li>These terms and conditions and your use of this Website shall be governed by and construed in accordance with the laws of Japan and the Republic of the Philippines, excluding its conflicts of law rules.
        You expressly agree that the exclusive jurisdiction for any claim or action arising out of or relating to these terms and conditions or your use of this Website shall be the Tokyo District Courts, and you further agree and submit to the exercise of personal jurisdiction of such courts for the purpose of litigating any such claim or action.
        Neither the existence of this Website nor the accessibility of content of this Website is intended to establish any new or additional jurisdictional or tax contacts or relationships for or between Line Seiki or its affiliates within any country or jurisdiction in which Line Seiki or any affiliate does not already conduct business.</li>
      </ul>

      <hr>
      <h5>Severability and Integration</h5>
      <ul>
        <li>These terms and conditions constitute the entire agreement between you and Line Seiki with respect to this Website.
        If any part of these terms and conditions is held to be invalid or unenforceable, the remaining parts shall remain in full force and effect.</li>
      </ul>

      <hr>
      <h5>Revisions and Consents</h5>
      <ul>
        <li>Line Seiki reserves the right to revise this legal information at any time and for any reason.
        We also reserve the right to make changes at any time, without notice or obligation, to any of the information contained on this Website.
        By entering this Website, you acknowledge and agree that you shall be bound by any such revisions.
        Accordingly, you should periodically visit this page to review these terms and conditions.</li>
      </ul>

      <hr>
      <h5>Disclaimer</h5><br>
      <h5>Copyrights and Protection of Identification/Trademarks</h5>
      <ul>
        <li>Line Seiki endeavors to observe the copyrights of the contents of the website, including but not limited to logos, articles/texts in all publications, pictures, visuals, designs, or any visual or written materials, graphics, to use its logos, articles/texts in all publications, pictures, visuals, designs, or any visual or written materials, graphics, or to have recourse to logos, articles/texts in all publications, pictures, visuals, designs, or any visual or written materials, graphics requiring no license.</li>
        <li>All the trademarks named in this website and, where applicable, those protected by third persons, are subject without restriction to the legal provisions of the respectively valid right to protected identification/trademarks and the rights of ownership of the respective registered owners. The fact that a trademark has merely been named shall not imply that trademarks are not protected by the rights of third persons.</li>
        <li>The copyright for any published items produced by Line Seiki itself shall remain solely with Line Seiki. Duplication or utilization of such logos, articles/texts in all publications, pictures, visuals, designs, or any visual or written materials, graphics shall be prohibited unless Line Seiki has granted it explicit consent.</li>
      </ul>

      <hr>
      <h5>References and Links</h5>
      <ul>
        <li>Where direct or indirect references to other Websites (hyperlinks) are concerned, which lie beyond the sphere of responsibility of Line Seiki, an obligation to assume liability would take effect exclusively in the case of Line Seiki having knowledge of the content, and it having been technically feasible and reasonable for it to have prevented its use in the case of it having unlawful content.</li>
        <li>Line Seiki herewith explicitly declares that at the time of setting the link, no unlawful content could be detected on the pages linked.
        Line Seiki shall have no influence whatsoever on the current and future creative design, contents or copyright of the linked pages.
        It therefore explicitly disassociates itself herewith from all the content of all the linked pages that have been changed after setting the links.
        This statement shall be valid for all the links and references set within the scope of Line Seiki’s website and also for entries by third persons in the website set up by Line Seiki.</li>
        <li>Where unlawful, erroneous, or incomplete content is concerned, especially damages arising from the usage or non-usage of the information offered, the provider of the page to which the reference is made shall be solely liable, and not the party who merely makes reference to the respective publication via links.</li>
      </ul>

      <hr>
      <h5>Content of Online Offer</h5>
      <ul>
        <li>Line Seiki does not assume any liability concerning the topicality, correctness, completeness or quality of the information provided.
        Any liability claims against Line Seiki, which refer to material or non-material damage, and which may be caused by the usage or non-usage of the information provided or, respectively, by the usage of any incorrect or incomplete information, is generally excluded unless in cases of evidenced willful or gross negligence on Line Seiki’s side.</li>
        <li>All offers are non-binding and non-obligatory. Line Seiki expressly reserves the right to modifications, amendments, or cancellations of the offer, in whole or in part, or to the temporary or final discontinuation of this publication without any prior notice.</li>
      </ul>

      <hr>
      <h5>Legal Validity of the Exemption from Liability (Disclaimer)</h5>
      <ul>
        <li>This exemption from liability (disclaimer) shall be deemed as a part of the website.
        If any parts or individual formulations of this text should fail to conform to the valid legal situation, or be no longer or not fully in conformity therewith, this shall not affect the content or validity of the remaining parts of the document.</li>
      </ul>
    </div>
  </section>


  <!-- Footer -->
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
      <img src=<?= base_url('assets_system/images/footer_logo.png') ?> height="40" alt="Logo">
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