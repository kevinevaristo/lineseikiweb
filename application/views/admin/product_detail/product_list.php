<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | Admin Panel</title>
    
    <!-- Bootstrap 5 -->
    <link href="<?php echo base_url('assets_system/vendor/bootstrap-5.3.0/css/bootstrap.min.css'); ?>" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.4.0/css/all.min.css'); ?>">
    
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/datatables/css/dataTables.bootstrap5.min.css'); ?>">
    
    <style>
        :root {
            --primary-blue: #17A2DC;
            --primary-dark: #0F467B;
            --sidebar-width: 260px;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
        }
        
        .admin-header {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-blue));
            color: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .admin-header h1 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 600;
        }
        
        .content-wrapper {
            padding: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-left: 4px solid var(--primary-blue);
        }
        
        .stat-card h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
        }
        
        .stat-card p {
            color: #6c757d;
            margin: 0.5rem 0 0 0;
            font-size: 0.9rem;
        }
        
        .stat-card i {
            font-size: 2.5rem;
            color: var(--primary-blue);
            opacity: 0.3;
            float: right;
        }
        
        .card-custom {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border: none;
        }
        
        .card-custom .card-header {
            background: white;
            border-bottom: 2px solid #e9ecef;
            padding: 1.5rem;
        }
        
        .card-custom .card-body {
            padding: 1.5rem;
        }
        
        .btn-primary-custom {
            background: var(--primary-blue);
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 162, 220, 0.3);
        }
        
        .table-custom {
            border-collapse: separate;
            border-spacing: 0 0.5rem;
        }
        
        .table-custom thead th {
            background: linear-gradient(135deg, var(--primary-dark), var(--primary-blue));
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem;
            font-size: 0.9rem;
        }
        
        .table-custom tbody tr {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s;
        }
        
        .table-custom tbody tr:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .table-custom tbody td {
            padding: 1rem;
            vertical-align: middle;
            border: none;
        }
        
        .badge-custom {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        
        .badge-active {
            background: #d4edda;
            color: #155724;
        }
        
        .badge-inactive {
            background: #f8d7da;
            color: #721c24;
        }
        
        .badge-featured {
            background: #fff3cd;
            color: #856404;
        }
        
        .badge-new {
            background: #cce5ff;
            color: #004085;
        }
        
        .product-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .action-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            border: none;
            font-size: 0.85rem;
            margin: 0 0.2rem;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
        }
        
        .btn-edit {
            background: #17a2dc;
            color: white;
        }
        
        .btn-edit:hover {
            background: #138fbe;
        }
        
        .btn-delete {
            background: #dc3545;
            color: white;
        }
        
        .btn-delete:hover {
            background: #c82333;
        }
        
        .btn-duplicate {
            background: #ffc107;
            color: #000;
        }
        
        .btn-duplicate:hover {
            background: #e0a800;
        }
        
        .filter-section {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        
        .alert-custom {
            border-radius: 8px;
            border: none;
            padding: 1rem 1.5rem;
        }
        
        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        
        .breadcrumb-custom .breadcrumb-item a {
            color: var(--primary-blue);
            text-decoration: none;
        }
        
        .breadcrumb-custom .breadcrumb-item.active {
            color: #6c757d;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="admin-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-boxes me-2"></i> Product Management</h1>
                <small>Manage your product catalog</small>
            </div>
            <div>
                <a href="<?= base_url('panel_72c81/home') ?>" class="btn btn-light btn-sm">
                    <i class="fas fa-home me-1"></i> Dashboard
                </a>
                <a href="<?= base_url('panel_72c81') ?>" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="content-wrapper">
        
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-custom">
                <li class="breadcrumb-item"><a href="<?= base_url('panel_72c81/home') ?>">Dashboard</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>

        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success alert-custom alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger alert-custom alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="stats-cards">
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <h3><?= $stats['total_products'] ?? 0 ?></h3>
                <p>Total Products</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-check-circle"></i>
                <h3><?= $stats['active_products'] ?? 0 ?></h3>
                <p>Active Products</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-layer-group"></i>
                <h3><?= $stats['total_categories'] ?? 0 ?></h3>
                <p>Categories</p>
            </div>
            <div class="stat-card">
                <i class="fas fa-tags"></i>
                <h3><?= $stats['total_types'] ?? 0 ?></h3>
                <p>Product Types</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-4">
            <div class="btn-group">
                <a href="<?= base_url('product_detail_admin/create') ?>" class="btn btn-primary-custom">
                    <i class="fas fa-plus me-2"></i> Add New Product
                </a>
                <a href="<?= base_url('product_detail_admin/categories') ?>" class="btn btn-outline-primary ms-2">
                    <i class="fas fa-layer-group me-2"></i> Manage Categories
                </a>
                <a href="<?= base_url('product_detail_admin/types') ?>" class="btn btn-outline-primary ms-2">
                    <i class="fas fa-tags me-2"></i> Manage Types
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-section">
            <form method="get" action="" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Category</label>
                        <select name="category" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat->id ?>" <?= ($filters['category_id'] == $cat->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat->category_name) ?> (<?= $cat->product_count ?>)
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" onchange="document.getElementById('filterForm').submit()">
                            <option value="">All Status</option>
                            <option value="1" <?= ($filters['is_active'] === '1') ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= ($filters['is_active'] === '0') ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Search</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="Search product name, model..." 
                               value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary-custom w-100">
                            <i class="fas fa-search me-2"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Products Table -->
        <div class="card-custom">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    <i class="fas fa-list me-2"></i> Products List
                </h5>
                <span class="badge bg-primary"><?= count($products) ?> items</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-custom" id="productsTable">
                        <thead>
                            <tr>
                                <th width="5%">ID</th>
                                <th width="8%">Image</th>
                                <th width="20%">Product Name</th>
                                <th width="12%">Category</th>
                                <th width="12%">Type</th>
                                <th width="10%">Model</th>
                                <th width="8%">Status</th>
                                <th width="10%">Updated</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($products)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">No products found</p>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach($products as $product): ?>
                                <tr>
                                    <td><?= $product->id ?></td>
                                    <td>
                                        <?php if($product->product_image): ?>
                                        <img src="<?= base_url('assets_system/images/' . $product->product_image) ?>" 
                                             class="product-thumb" alt="Product">
                                        <?php else: ?>
                                        <div class="product-thumb bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars($product->product_name) ?></strong>
                                        <?php if($product->series_name): ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($product->series_name) ?></small>
                                        <?php endif; ?>
                                        <br>
                                        <?php if($product->is_featured): ?>
                                        <span class="badge badge-custom badge-featured">FEATURED</span>
                                        <?php endif; ?>
                                        <?php if($product->is_new): ?>
                                        <span class="badge badge-custom badge-new">NEW</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($product->category_name ?? '-') ?></td>
                                    <td><?= htmlspecialchars($product->type_name ?? '-') ?></td>
                                    <td><?= htmlspecialchars($product->model_number ?? '-') ?></td>
                                    <td>
                                        <?php if($product->is_active): ?>
                                        <span class="badge badge-custom badge-active">Active</span>
                                        <?php else: ?>
                                        <span class="badge badge-custom badge-inactive">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <small><?= date('M d, Y', strtotime($product->updated_at)) ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="<?= base_url('panel_72c81/product_detail_admin/edit/' . $product->id) ?>" 
                                               class="action-btn btn-edit" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button onclick="duplicateProduct(<?= $product->id ?>)" 
                                                    class="action-btn btn-duplicate" title="Duplicate">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                            <button onclick="deleteProduct(<?= $product->id ?>, '<?= htmlspecialchars($product->product_name) ?>')" 
                                                    class="action-btn btn-delete" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="<?php echo base_url('assets_system/vendor/jquery/jquery-3.7.0.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets_system/vendor/bootstrap-5.3.0/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets_system/vendor/datatables/js/jquery.dataTables.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets_system/vendor/datatables/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

    <script>
        $(document).ready(function() {
            $('#productsTable').DataTable({
                pageLength: 25,
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [1, 8] }
                ],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ products",
                    infoEmpty: "No products available",
                    infoFiltered: "(filtered from _MAX_ total products)"
                }
            });
        });

        function deleteProduct(id, name) {
            Swal.fire({
                title: 'Delete Product?',
                html: `Are you sure you want to delete <strong>${name}</strong>?<br><small class="text-danger">This action cannot be undone!</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("panel_72c81/product_detail_admin/delete/") ?>' + id;
                }
            });
        }

        function duplicateProduct(id) {
            Swal.fire({
                title: 'Duplicate Product?',
                text: 'This will create a copy of the product.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#17a2dc',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, duplicate it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '<?= base_url("panel_72c81/product_detail_admin/duplicate/") ?>' + id;
                }
            });
        }
    </script>

</body>
</html>
