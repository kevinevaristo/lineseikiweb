<?php
/**
 * Dynamic Product Detail Page - SS2-P-1 Series Design
 * Fully dynamic content based on database with HTML structure from Line Seiki reference
 */

// Extract and prepare product data
$product_name = htmlspecialchars($product->product_name ?? 'Product');
$series_name = htmlspecialchars($product->series_name ?? '');
$sub_title = htmlspecialchars($product->sub_title ?? '');
$product_desc = $product->description ?? '';
$product_image = $product->product_image ?? '';
$youtube_id = $product->youtube_embed ?? '';
$video_url = $product->video_url ?? '';
$features_list = $product->features ?? '';
$category_name = $product->category_name ?? 'Products';
$category_slug = $product->category_slug ?? '';
$type_name = $product->type_name ?? '';
$related = $related_products ?? [];

// Parse tags
$tags = [];
if (!empty($product->tags)) {
    $tags = array_filter(array_map('trim', explode(',', $product->tags)));
}

// Parse features
$features_array = [];
if (!empty($features_list)) {
    $features_array = array_filter(array_map('trim', explode("\n", $features_list)));
}

// Parse specifications (supports multiple values per key separated by |, and optional {{img:filename}})
$specs_array = [];
if (!empty($product->specifications)) {
    $lines = array_filter(array_map('trim', explode("\n", $product->specifications)));
    foreach ($lines as $line) {
        if (strpos($line, ':') !== false) {
            list($key, $value) = array_map('trim', explode(':', $line, 2));
            $raw_values = array_map('trim', explode('|', $value));
            $parsed_values = [];
            foreach ($raw_values as $rv) {
                $img = '';
                if (preg_match('/\{\{img:(.+?)\}\}/', $rv, $m)) {
                    $img = $m[1];
                    $rv = trim(str_replace($m[0], '', $rv));
                }
                $parsed_values[] = ['text' => $rv, 'image' => $img];
            }
            $specs_array[] = ['key' => $key, 'values' => $parsed_values];
        }
    }
}

// Parse models data (JSON)
$models = [];
if (!empty($product->models_data)) {
    $decoded = json_decode($product->models_data, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $models = $decoded;
    }
}

// Parse downloads data (JSON)
$downloads = [];
if (!empty($product->downloads_data)) {
    $decoded = json_decode($product->downloads_data, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $downloads = $decoded;
    }
}

// Parse applications data (JSON)
$applications = [];
if (!empty($product->applications_data)) {
    $decoded = json_decode($product->applications_data, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $applications = $decoded;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($product->meta_title ?? ($series_name ?: $product_name) . ' - Line Seiki') ?></title>
  
  <?php if (!empty($product->meta_description)): ?>
  <meta name="description" content="<?= htmlspecialchars($product->meta_description) ?>">
  <?php endif; ?>
  
  <?php if (!empty($product->meta_keywords)): ?>
  <meta name="keywords" content="<?= htmlspecialchars($product->meta_keywords) ?>">
  <?php endif; ?>

  <!-- Bootstrap 5 CSS -->
  <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.3/css/bootstrap.min.css'); ?>" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">
  
  <!-- Google Fonts -->
  <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter-roboto.css'); ?>" rel="stylesheet">

  <style>
    :root {
      --primary-blue: #0d6efd;
      --primary-blue-dark: #0a58ca;
      --newblue: #17A2DC;
      --newblue2: #0F467B;
      --text-primary: #212529;
      --text-secondary: #6c757d;
      --border-color: #dee2e6;
      --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
      --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
      --shadow-lg: 0 8px 32px rgba(0, 0, 0, 0.15);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
      line-height: 1.6;
      color: var(--text-primary);
      background: #ffffff;
      overflow-x: hidden;
    }

    html {
      scroll-behavior: smooth;
    }

    /* Navbar Styles */
    .navbar {
      background: #ffffff;
      padding: 1rem 5%;
      box-shadow: 0 2px 10px rgba(0,0,0,0.08);
      position: sticky;
      top: 0;
      z-index: 1000;
    }

    .navbar-brand img {
      height: 45px;
      width: auto;
    }

    .navbar-nav .nav-link {
      color: var(--text-primary);
      font-weight: 500;
      padding: 0.5rem 1rem;
      transition: var(--transition);
      border-radius: 6px;
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--newblue);
      background: rgba(23, 162, 220, 0.08);
    }

    /* Breadcrumb Section */
    .c-breadcrumb {
      background: #f8f9fa;
      padding: 15px 5%;
      border-bottom: 1px solid var(--border-color);
    }

    .c-breadcrumb__inner {
      display: flex;
      align-items: center;
      gap: 8px;
      font-size: 0.9rem;
      flex-wrap: wrap;
      margin: 0;
    }

    .c-breadcrumb__inner a {
      color: var(--newblue);
      text-decoration: none;
      transition: var(--transition);
    }

    .c-breadcrumb__inner a:hover {
      color: var(--newblue2);
      text-decoration: underline;
    }

    .c-breadcrumb__inner .is-arrow {
      color: var(--text-secondary);
      margin: 0 4px;
    }

    .c-breadcrumb__inner .breadcrumb_last {
      color: var(--text-secondary);
    }

    /* Product Header Section */
    .l-section {
      background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
      padding: 50px 5% 40px;
    }

    .l-container {
      max-width: 1400px;
      margin: 0 auto;
    }

    .c-block-product-page__inner {
      display: grid;
      grid-template-columns: 400px 1fr;
      gap: 60px;
      align-items: start;
    }

    .c-block-product-page__image {
      position: sticky;
      top: 100px;
    }

    .bg-img {
      background: #ffffff;
      border-radius: 16px;
      padding: 40px;
      box-shadow: var(--shadow-md);
      text-align: center;
      border: 1px solid var(--border-color);
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 400px;
    }

    .c-block-product-page__content h1.c-heading {
      font-size: 2.2rem;
      font-weight: 700;
      color: var(--newblue2);
      margin-bottom: 10px;
      line-height: 1.3;
    }

    .c-heading .is-sub {
      display: block;
      font-size: 1.1rem;
      color: var(--text-secondary);
      margin-bottom: 10px;
      font-weight: 500;
    }

    .c-heading .is-main {
      display: block;
      font-weight: 700;
    }

    .c-block-product-page__tag {
      display: flex;
      gap: 10px;
      margin: 25px 0;
      flex-wrap: wrap;
      list-style: none;
      padding: 0;
    }

    .c-block-product-page__tag li span {
      display: inline-block;
      background: rgba(23, 162, 220, 0.1);
      color: var(--newblue);
      padding: 6px 16px;
      border-radius: 20px;
      font-size: 0.85rem;
      font-weight: 600;
      border: 1px solid rgba(23, 162, 220, 0.3);
    }

    .c-block-product-page__table {
      background: #ffffff;
      border-radius: 12px;
      overflow: hidden;
      margin-bottom: 25px;
      border: 1px solid var(--border-color);
    }

    .c-table-sm {
      width: 100%;
      margin: 0;
      border-collapse: collapse;
    }

    .c-table-sm th {
      background: #f8f9fa;
      padding: 15px 20px;
      font-weight: 700;
      color: var(--newblue2);
      text-align: left;
      font-size: 0.95rem;
      border-bottom: 2px solid var(--border-color);
    }

    .c-table-sm td {
      padding: 15px 20px;
      color: var(--text-primary);
      line-height: 1.8;
      font-size: 0.95rem;
    }

    /* Action Buttons */
    .c-block-product-page__blocks {
      display: flex;
      gap: 15px;
      margin-top: 30px;
      flex-wrap: wrap;
    }

    .c-button {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      padding: 14px 28px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.95rem;
      text-decoration: none;
      transition: var(--transition);
      border: 2px solid;
    }

    .c-button.is-primary {
      background: var(--newblue);
      color: #ffffff;
      border-color: var(--newblue);
    }

    .c-button.is-primary:hover {
      background: var(--newblue2);
      border-color: var(--newblue2);
      transform: translateY(-2px);
      box-shadow: var(--shadow-md);
      color: #ffffff;
    }

    .c-button img {
      width: 18px;
      height: 18px;
      filter: brightness(0) invert(1);
    }

    /* Anchor Navigation */
    .c-anchor-nav {
      background: #ffffff;
      padding: 20px 5%;
      box-shadow: 0 2px 10px rgba(0,0,0,0.06);
      position: sticky;
      top: 76px;
      z-index: 999;
      border-bottom: 1px solid var(--border-color);
    }

    .c-anchor-nav__buttons {
      max-width: 1400px;
      margin: 0 auto;
      display: flex;
      gap: 15px;
      overflow-x: auto;
      scrollbar-width: thin;
    }

    .c-anchor-nav__buttons::-webkit-scrollbar {
      height: 4px;
    }

    .c-anchor-nav__buttons::-webkit-scrollbar-thumb {
      background: var(--newblue);
      border-radius: 4px;
    }

    .c-button.is-nav {
      flex-shrink: 0;
      padding: 10px 20px;
      background: #f8f9fa;
      color: var(--text-primary);
      text-decoration: none;
      border-radius: 6px;
      font-weight: 600;
      font-size: 0.9rem;
      transition: var(--transition);
      white-space: nowrap;
      border: none;
    }

    .c-button.is-nav:hover {
      background: var(--newblue);
      color: #ffffff;
    }

    /* Content Sections */
    .l-block__margin-large {
      padding: 60px 0;
    }

    .c-heading.is-xs {
      font-size: 1.8rem;
      font-weight: 700;
      color: var(--newblue2);
      margin-bottom: 35px;
      padding-bottom: 12px;
      border-bottom: 3px solid var(--newblue);
      display: inline-block;
    }

    /* Video Section */
    .c-movies__blocks {
      display: grid;
      gap: 30px;
    }

    .c-movies__block {
      position: relative;
      padding-bottom: 56.25%;
      height: 0;
      overflow: hidden;
      border-radius: 12px;
      box-shadow: var(--shadow-md);
      background: #000000;
    }

    .c-movies__block iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: 0;
    }

    /* Models Table */
    .js-responsive-table-wrapper {
      overflow-x: auto;
      border-radius: 12px;
      box-shadow: var(--shadow-sm);
      background: #ffffff;
    }

    .c-table-xlg {
      width: 100%;
      border-collapse: collapse;
      margin: 0;
    }

    .c-table-xlg thead {
      background: linear-gradient(135deg, var(--newblue2), var(--newblue));
    }

    .c-table-xlg thead td {
      padding: 16px 20px;
      color: #ffffff;
      font-weight: 600;
      font-size: 0.9rem;
      text-align: left;
      white-space: nowrap;
    }

    .c-table-xlg tbody tr {
      border-bottom: 1px solid var(--border-color);
      transition: var(--transition);
    }

    .c-table-xlg tbody tr:hover {
      background: #f8f9fa;
    }

    .c-table-xlg tbody tr:last-child {
      border-bottom: none;
    }

    .c-table-xlg tbody td, .c-table-xlg tbody th {
      padding: 16px 20px;
      color: var(--text-primary);
      font-size: 0.9rem;
    }

    .c-table-xlg tbody th {
      background: #f8f9fa;
      font-weight: 700;
      color: var(--newblue2);
      text-align: left;
    }

    .c-table-xlg tbody td img {
      max-width: 150px;
      height: auto;
      display: block;
      margin: 5px 0;
    }

    /* Specifications */
    .l-post-content {
      margin-top: 20px;
    }

    /* Downloads Section */
    .c-relation__buttons {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
    }

    .c-relation__button a {
      background: #ffffff;
      border: 2px solid var(--border-color);
      border-radius: 12px;
      padding: 18px 24px;
      text-align: left;
      text-decoration: none;
      transition: var(--transition);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      color: var(--newblue2);
      font-weight: 600;
    }

    .c-relation__button a:hover {
      border-color: var(--newblue);
      box-shadow: var(--shadow-md);
      transform: translateY(-4px);
      color: var(--newblue);
    }

    .c-relation__button a img {
      width: 24px;
      height: 24px;
      flex-shrink: 0;
    }

    /* Applications Section */
    .l-section.is-bg-color {
      background: #f8f9fa;
      padding: 70px 5%;
    }

    .c-card__inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 50px;
      flex-wrap: wrap;
      gap: 20px;
    }

    .c-card__head {
      font-size: 2.2rem;
      font-weight: 800;
      color: var(--newblue2);
      margin: 0;
    }

    .c-card__head .is-eng {
      display: block;
      font-size: 2.5rem;
    }

    .c-card__head .is-ja {
      display: block;
      font-size: 1rem;
      font-weight: 400;
      color: var(--text-secondary);
      margin-top: 5px;
    }

    .c-button.is-sm {
      padding: 10px 24px;
      font-size: 0.9rem;
    }

    .c-card__blocks {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 30px;
    }

    .c-card__block {
      background: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      box-shadow: var(--shadow-sm);
      transition: var(--transition);
      text-decoration: none;
      color: inherit;
      border: 1px solid var(--border-color);
      display: block;
    }

    .c-card__block:hover {
      box-shadow: var(--shadow-lg);
      transform: translateY(-6px);
    }

    .c-card__image {
      width: 100%;
      height: 200px;
      position: relative;
      overflow: hidden;
    }

    .c-card__image .bg-img {
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      transition: var(--transition);
      padding: 0;
      border-radius: 0;
      box-shadow: none;
      border: none;
    }

    .c-card__block:hover .c-card__image .bg-img {
      transform: scale(1.08);
    }

    .c-label {
      position: absolute;
      top: 12px;
      left: 12px;
      background: var(--newblue);
      color: #ffffff;
      padding: 6px 14px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .c-card__content {
      padding: 20px;
    }

    .c-card__text {
      font-size: 1.1rem;
      font-weight: 700;
      color: var(--newblue2);
      margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 992px) {
      .c-block-product-page__inner {
        grid-template-columns: 1fr;
        gap: 30px;
      }

      .c-block-product-page__image {
        position: relative;
        top: 0;
      }

      .c-block-product-page__content h1.c-heading {
        font-size: 1.9rem;
      }

      .c-card__blocks {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .navbar {
        padding: 1rem 4%;
      }

      .c-breadcrumb,
      .l-section,
      .l-section.is-bg-color {
        padding-left: 4%;
        padding-right: 4%;
      }

      .bg-img {
        padding: 25px;
        min-height: 300px;
      }

      .c-block-product-page__content h1.c-heading {
        font-size: 1.7rem;
      }

      .c-heading.is-xs {
        font-size: 1.6rem;
      }

      .c-anchor-nav {
        padding: 15px 4%;
      }

      .c-relation__buttons,
      .c-card__blocks {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 576px) {
      .c-block-product-page__content h1.c-heading {
        font-size: 1.5rem;
      }

      .c-block-product-page__blocks {
        flex-direction: column;
      }

      .c-button {
        width: 100%;
        justify-content: center;
      }

      .c-table-xlg thead td,
      .c-table-xlg tbody td,
      .c-table-xlg tbody th,
      .c-table-sm th,
      .c-table-sm td {
        padding: 12px 14px;
        font-size: 0.85rem;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= base_url() ?>">
        <img src="<?= base_url('assets_system/images/header_logo.png') ?>" alt="Line Seiki Logo">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/about_us') ?>">About Us</a></li>
          <li class="nav-item">
            <a class="nav-link active" href="<?= base_url('index/ps_prod') ?>">Products & Services</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/news_event') ?>">News & Events</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/library') ?>">Library</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= base_url('index/contact_us') ?>">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Breadcrumb -->
  <div class="c-breadcrumb is-relative">
    <div class="c-breadcrumb__inner">
      <span>
        <span><a href="<?= base_url() ?>">Home</a></span>
        <span class="is-arrow">/</span>
        <span><a href="<?= base_url('index/ps_prod') ?>">Products & Services</a></span>
        <?php if ($category_name): ?>
        <span class="is-arrow">/</span>
        <span><a href="<?= base_url('index/category_products/' . $category_slug) ?>"><?= htmlspecialchars($category_name) ?></a></span>
        <?php endif; ?>
        <span class="is-arrow">/</span>
        <span class="breadcrumb_last" aria-current="page"><?= $series_name ?: $product_name ?></span>
      </span>
    </div>
  </div>

  <!-- Product Header Section -->
  <main class="l-main">
    <section class="l-section is-md is-relative">
      <div class="l-container">
        <div class="c-block-product-page">
          <div class="c-block-product-page__inner">
            <!-- Product Image -->
            <div class="c-block-product-page__image">
              <?php if ($product_image): ?>
                <div class="bg-img" style="background-image: url('<?= base_url('assets_system/images/' . $product_image) ?>')"></div>
              <?php else: ?>
                <div class="bg-img" style="display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-box" style="font-size: 8rem; color: #dee2e6;"></i>
                </div>
              <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="c-block-product-page__content">
              <h1 class="c-block-product-page__title c-heading is-product is-color-primary">
                <?php if ($sub_title): ?>
                  <span class="is-sub"><?= $sub_title ?></span>
                <?php endif; ?>
                <b class="is-main"><?= $series_name ?: $product_name ?></b>
              </h1>

              <?php if (!empty($tags)): ?>
              <ul class="c-block-product-page__tag">
                <?php foreach ($tags as $tag): ?>
                  <li><span><?= htmlspecialchars($tag) ?></span></li>
                <?php endforeach; ?>
              </ul>
              <?php endif; ?>

              <?php if (!empty($features_array)): ?>
              <div class="c-block-product-page__table">
                <table class="c-table-sm">
                  <tbody>
                    <tr>
                      <th>Features</th>
                      <td>
                        <?php 
                        foreach ($features_array as $index => $feature): 
                          echo htmlspecialchars($feature);
                          if ($index < count($features_array) - 1) {
                            echo '<br>';
                          }
                        endforeach; 
                        ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <?php endif; ?>

              <div class="c-block-product-page__blocks">
                <div class="c-block-product-page__button">
                  <a class="c-button is-xlg is-primary" href="<?= base_url('index/contact_us') ?>">
                    <img src="<?= base_url('assets_system/images/icon-button-03.svg') ?>" alt="">
                    Send Inquiry
                  </a>
                </div>
                <div class="c-block-product-page__button">
                  <a class="c-button is-xlg is-primary" href="<?= base_url('index/contact_us') ?>">
                    <img src="<?= base_url('assets_system/images/icon-button-04.svg') ?>" alt="">
                    Distributors List
                  </a>
                </div>
              </div>
            </div>
          </div>

          <!-- Anchor Navigation -->
          <div class="c-anchor-nav u-mbs is-md is-top">
            <div class="c-anchor-nav__buttons">
              <?php if ($youtube_id || $video_url): ?>
              <div class="c-anchor-nav__button">
                <a class="c-button is-nav js-anchor" href="#block01">Movie</a>
              </div>
              <?php endif; ?>
              <?php if (!empty($models)): ?>
              <div class="c-anchor-nav__button">
                <a class="c-button is-nav js-anchor" href="#block02">Models</a>
              </div>
              <?php endif; ?>
              <?php if (!empty($specs_array)): ?>
              <div class="c-anchor-nav__button">
                <a class="c-button is-nav js-anchor" href="#block03">Specifications</a>
              </div>
              <?php endif; ?>
              <?php if (!empty($downloads)): ?>
              <div class="c-anchor-nav__button">
                <a class="c-button is-nav js-anchor" href="#block04">Download</a>
              </div>
              <?php endif; ?>
              <?php if (!empty($applications)): ?>
              <div class="c-anchor-nav__button">
                <a class="c-button is-nav js-anchor" href="#block05">Applications</a>
              </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Movie Section -->
          <?php if ($youtube_id || $video_url): ?>
          <div class="l-block__margin-large" id="block01">
            <h2 class="c-heading is-xs is-mg-50">Movie</h2>
            <div class="c-movies">
              <div class="c-movies__blocks">
                <div class="c-movies__block">
                  <?php if ($youtube_id): ?>
                    <iframe width="1280" height="720" 
                            src="https://www.youtube.com/embed/<?= htmlspecialchars($youtube_id) ?>" 
                            title="Product Video" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in