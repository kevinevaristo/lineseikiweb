<!-- application/views/admin/product_pages_list.php -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Dynamic Product Pages Management</h3>
                    <a href="<?php echo base_url('cms/add_product_page'); ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Product Page
                    </a>
                </div>
                <div class="card-body">
                    <?php if ($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <?php echo $this->session->flashdata('success'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <?php endif; ?>
                    
                    <?php if ($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo $this->session->flashdata('error'); ?>
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                    </div>
                    <?php endif; ?>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="productsTable">
                            <thead>
                                <tr>
                                    <th width="80">Image</th>
                                    <th>Product Name</th>
                                    <th>Slug</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Featured</th>
                                    <th>Order</th>
                                    <th>Created</th>
                                    <th width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td>
                                            <?php if ($product->thumbnail_image): ?>
                                            <img src="<?php echo base_url('assets_system/images/thumbnails/' . $product->thumbnail_image); ?>" 
                                                 alt="<?php echo $product->product_name; ?>" 
                                                 style="max-width: 60px; max-height: 60px;">
                                            <?php elseif ($product->banner_image): ?>
                                            <img src="<?php echo base_url('assets_system/images/banners/' . $product->banner_image); ?>" 
                                                 alt="<?php echo $product->product_name; ?>" 
                                                 style="max-width: 60px; max-height: 60px;">
                                            <?php else: ?>
                                            <div style="width: 60px; height: 60px; background: #e0e0e0; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-image" style="font-size: 24px; color: #999;"></i>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <strong><?php echo $product->product_name; ?></strong>
                                            <?php if ($product->subtitle): ?>
                                            <br><small class="text-muted"><?php echo $product->subtitle; ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <code><?php echo $product->slug; ?></code>
                                            <br>
                                            <a href="<?php echo base_url('product/' . $product->slug); ?>" 
                                               target="_blank" class="btn btn-sm btn-link p-0">
                                                <i class="fa fa-external-link"></i> View
                                            </a>
                                        </td>
                                        <td>
                                            <?php if ($product->category): ?>
                                            <span class="badge badge-info"><?php echo ucfirst($product->category); ?></span>
                                            <?php else: ?>
                                            <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($product->is_active): ?>
                                            <span class="badge badge-success">Active</span>
                                            <?php else: ?>
                                            <span class="badge badge-secondary">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($product->is_featured): ?>
                                            <i class="fa fa-star text-warning" title="Featured"></i>
                                            <?php else: ?>
                                            <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center"><?php echo $product->display_order; ?></td>
                                        <td>
                                            <small><?php echo date('M d, Y', strtotime($product->created_at)); ?></small>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?php echo base_url('cms/edit_product_page/' . $product->id); ?>" 
                                                   class="btn btn-warning" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-danger" 
                                                        onclick="deleteProduct(<?php echo $product->id; ?>, '<?php echo addslashes($product->product_name); ?>')"
                                                        title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <p class="text-muted my-4">No products found. <a href="<?php echo base_url('cms/add_product_page'); ?>">Add your first product</a></p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function deleteProduct(id, name) {
    if (confirm('Are you sure you want to delete "' + name + '"? This action cannot be undone.')) {
        window.location.href = '<?php echo base_url('cms/delete_product_page/'); ?>' + id;
    }
}

// Initialize DataTables if available
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#productsTable').DataTable({
            "order": [[6, "asc"]], // Sort by display order
            "pageLength": 25,
            "columnDefs": [
                { "orderable": false, "targets": [0, 8] } // Disable sorting on image and actions columns
            ]
        });
    }
});
</script>

<style>
.table td { vertical-align: middle; }
.btn-group-sm .btn { padding: 0.25rem 0.5rem; }
</style>
