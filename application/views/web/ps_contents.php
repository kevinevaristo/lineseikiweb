<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title ?> - Engineering Simulations</title>

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

    .text-and-image {
      display: flex;
      justify-content: space-between;
      align-items: stretch;
      flex-wrap: wrap;
    }

    .case-images {
      flex: 0 0 30%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
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

    .back-button {
      margin-bottom: 20px;
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
  <div class="container">
    <div class="back-button">
      <button type="button" onclick="history.back();" class="btn btn-outline-primary btn-sm">
        ← Back
      </button>
    </div>

    <?php if (!empty($simulation)): ?>
    <div class="container case-study">
      <h5 class="fw-bold">Case Study Details</h5>

      <h6 class="case-title"><?= htmlspecialchars($simulation->title) ?></h6>

      <div class="case-abstract">
        <strong>Abstract:</strong>
        <p><?= nl2br(htmlspecialchars($simulation->abstract)) ?></p>
        <a href="#" class="read-more">Read more →</a>
      </div>

      <!-- Text and images side by side -->
      <div class="text-and-image">
        <!-- Left Text -->
        <div class="case-details flex-grow-1" style="flex: 1.5;">
          <p><strong>Client :</strong> <?= htmlspecialchars($simulation->client) ?></p>
          <p><strong>Problem :</strong> <?= htmlspecialchars($simulation->problem) ?></p>
          <p><strong>Study :</strong> <?= htmlspecialchars($simulation->study) ?></p>
          <p><strong>Analysis Type :</strong> <?= htmlspecialchars($simulation->analysis_type) ?></p>
          <p><strong>Root Cause :</strong> <?= htmlspecialchars($simulation->root_cause) ?></p>
          <p><strong>Solution :</strong> <?= htmlspecialchars($simulation->solution) ?></p>

          <!-- Table below text -->
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
                <td><?= htmlspecialchars($simulation->prototype_without) ?></td>
                <td><?= htmlspecialchars($simulation->prototype_with) ?></td>
                <td><?= htmlspecialchars($simulation->prototype_reduction) ?></td>
              </tr>
              <tr>
                <td>Testing</td>
                <td><?= htmlspecialchars($simulation->testing_without) ?></td>
                <td><?= htmlspecialchars($simulation->testing_with) ?></td>
                <td><?= htmlspecialchars($simulation->testing_reduction) ?></td>
              </tr>
              <tr>
                <td>Development</td>
                <td><?= htmlspecialchars($simulation->development_without) ?></td>
                <td><?= htmlspecialchars($simulation->development_with) ?></td>
                <td><?= htmlspecialchars($simulation->development_reduction) ?></td>
              </tr>
            </tbody>
          </table>

          <div class="benefits mt-3">
            <p><strong>Qualitative Benefits:</strong></p>
            <p><?= htmlspecialchars($simulation->qualitative_benefits) ?></p>
          </div>
        </div>

        <!-- Right Images - ITO ANG NAAYOS -->
        <div class="case-images text-center ms-lg-4">
          <?php if (!empty($simulation->actual_image_filename)): ?>
          <div>
            <img src="<?= base_url('assets_system/images/' . $simulation->actual_image_filename) ?>" alt="Actual <?= htmlspecialchars($simulation->analysis_type) ?>">
            <div class="img-caption">Actual component</div>
          </div>
          <?php endif; ?>
          
          <?php if (!empty($simulation->simulation_image_filename)): ?>
          <div>
            <img src="<?= base_url('assets_system/images/' . $simulation->simulation_image_filename) ?>" alt="Simulation Result">
            <div class="img-caption">Simulation result</div>
          </div>
          <?php endif; ?>
          
          <!-- Fallback kung walang images -->
          <?php if (empty($simulation->actual_image_filename) && empty($simulation->simulation_image_filename)): ?>
          <div class="alert alert-light text-center">
            <p class="text-muted mb-0">No images available</p>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="alert alert-danger">
      Case study not found.
    </div>
    <?php endif; ?>
  </div>
</body>
</html>