<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Case Study - Buckling Analysis</title>

  <!-- Bootstrap 5 -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">

  <style>
    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background-color: #fff;
      color: #000;
      line-height: 1.6;
      padding: 40px 0;
    }

    .case-study {
      max-width: 1100px;
      margin: 0 auto;
    }

    .case-title {
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 0.5rem;
    }

    .case-abstract {
      margin-bottom: 1.5rem;
    }

    .case-abstract p {
      margin-bottom: 0;
    }

    .case-details p {
      margin-bottom: 0.25rem;
    }

    .read-more {
      color: #0d6efd;
      font-weight: 500;
      text-decoration: none;
    }

    /* Make the text and images align better */
    .text-and-image {
      display: flex;
      justify-content: space-between;
      align-items: stretch; /* stretch both columns equally */
      flex-wrap: wrap;
    }

    /* Make the image section same height as text section */
    .case-images {
      flex: 0 0 30%;
      display: flex;
      flex-direction: column;
      justify-content: space-between; /* distribute vertically */
      max-width: 320px;
    }

    .case-images img {
      width: 100%;
      height: auto;
      border-radius: 4px;
      box-shadow: 0 0 3px rgba(0,0,0,0.15);
    }

    .img-caption {
      font-size: 0.85rem;
      color: #1a237e;
      text-align: center;
      margin-bottom: 1rem;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      margin-top: 20px;
      max-width: 650px;
    }

    th, td {
      border: 1px solid #000;
      padding: 10px;
      font-size: 1rem;
    }

    th {
      background-color: #0b2e46;
      color: #fff;
      font-weight: 600;
    }

    th:nth-child(2), th:nth-child(3) {
      color: #ffeb3b;
    }

    tr:nth-child(even) td {
      background-color: #e8f0fa;
    }

    .benefits {
      margin-top: 20px;
    }

    .benefits p {
      margin: 0;
    }

    @media (max-width: 992px) {
      .text-and-image {
        flex-direction: column;
      }

      .case-images {
        margin-top: 20px;
        max-width: 100%;
        flex-direction: row;
        justify-content: center;
        gap: 10px;
      }

      .case-images div {
        flex: 1;
      }
    }
  </style>
</head>
<body>
  <div class="container case-study">
    <h5 class="fw-bold">Case Studies Content</h5>

    <h6 class="case-title">Structural Analysis of a Gear Jig During Process Setup</h6>

    <div class="case-abstract">
      <strong>Abstract:</strong>
      <p>
        This study presents a structural contact stress analysis to investigate part deformation and gear–jig interaction during process setup. The
simulation identified zones of excessive local stress, guiding jig redesign and eliminating repeated fabrications.
      </p>
      <a href="#" class="read-more">Read more →</a>
    </div>

    <!-- Text and images side by side -->
    <div class="text-and-image">
      <!-- Left Text -->
      <div class="case-details flex-grow-1" style="flex: 1.5;">
        <p><strong>Client :</strong> Manufacturing</p>
        <p><strong>Problem :</strong> Part deformation during process setup</p>
        <p><strong>Study :</strong> Simulate process and gear–jig contact</p>
        <p><strong>Analysis Type :</strong> Contact Stress</p>
        <p><strong>Root Cause :</strong> Damage gear tooth due to excessive local stress</p>
        <p><strong>Solution :</strong> Simulation identified the high contact stress zones, guiding jig redesign and cutting repeated fabrications.</p>

        <!-- Table below text -->
        <div class="table-responsive">
        <table>
          <thead>
            <tr>
              <th>Metric</th>
              <th>WITHOUT Simulation</th>
              <th>WITH Simulation</th>
              <th>Reduction</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Prototype</td>
              <td>$720</td>
              <td>$90</td>
              <td>-88%</td>
            </tr>
            <tr>
              <td>Testing</td>
              <td>$2,496</td>
              <td>$936</td>
              <td>-63%</td>
            </tr>
            <tr>
              <td>Development</td>
              <td>12 weeks</td>
              <td>3 weeks</td>
              <td>-75%</td>
            </tr>
          </tbody>
        </table>
        </div>

        <div class="benefits mt-3">
          <p><strong>Qualitative Benefits:</strong></p>
          <p>Prevent shipment delays & potential customer loss.</p>
        </div>
      </div>

      <!-- Right Images -->
      <div class="case-images text-center ms-lg-4">
        <div>
          <img src="<?= base_url('assets_system/images/image3.png') ?>" alt="Actual Cover">
          <div class="img-caption">Actual cover</div>
        </div>
        <div>
          <img src="<?= base_url('assets_system/images/image4.png') ?>" alt="Simulation Result">
          <div class="img-caption">Simulation result</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
