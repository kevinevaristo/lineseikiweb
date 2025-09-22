<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reimbursement List</title>

  <!-- Latest Bootstrap 5.3.3 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body { background-color: #f8f9fa; }
    h2 { font-weight: 600; color: #fff; }
    .table thead th {
      vertical-align: middle;
      text-align: center;
      position: sticky;
      top: 0;
      z-index: 2;
      background-color: #212529;
      color: #fff;
    }
    .table tbody td { vertical-align: middle; }
    .badge { font-size: 0.85rem; padding: 0.4em 0.7em; }
    
    /* Status badge colors */
    .status-for-reimbursement { background-color: #dc3545; }
    .status-reimbursed { background-color: #198754; }
    .status-direct { background-color: #198754; }
    .status-approval { background-color: #ffc107; color: #000; }
    .status-pending { background-color: #6c757d; }
    
    /* Row background colors based on status */
    .row-for-reimbursement { background-color: #f8d7da !important; } /* Pink for "For Reimbursement" */
    .row-reimbursed { background-color: #d1edff !important; } /* Light blue for reimbursed */
    .row-direct { background-color: #d1f0d9 !important; } /* Light green for direct */
    .row-approval { background-color: #fff3cd !important; } /* Light yellow for approval */
    .row-pending { background-color: #e9ecef !important; } /* Light gray for pending */

    /* Mobile optimization */
    @media (max-width: 768px) {
      .table thead {
        display: none;
      }
      .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
      }
      .table tr {
        margin-bottom: 1rem;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        padding: 0.8rem;
        cursor: pointer;
      }
      .table td {
        border: none !important;
        text-align: left;
        padding: 0.3rem 0;
      }
      .modal-dialog {
        margin: 0;
        width: 100%;
        max-width: 100%;
      }
      .modal-content {
        height: 100vh;
        border-radius: 0;
      }
      
      /* Mobile specific row colors */
      .table tr.row-for-reimbursement { background-color: #f8d7da !important; }
      .table tr.row-reimbursed { background-color: #d1edff !important; }
      .table tr.row-direct { background-color: #d1f0d9 !important; }
      .table tr.row-approval { background-color: #fff3cd !important; }
      .table tr.row-pending { background-color: #e9ecef !important; }
    }
  </style>
</head>
<body>
<div class="container-fluid my-3">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-dark text-white text-center rounded-top-4">
      <h2 class="my-2">💰 Reimbursement Table</h2>
    </div>
    <div class="card-body p-2">
      <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-center w-100">
          <thead>
            <tr>
              <th>Date</th>
              <th>Applied By</th>
              <th>Project</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($reimburse_list)): ?>
              <?php foreach ($reimburse_list as $r): ?>
                <?php 
                // Determine CSS class based on status
                $status_class = '';
                $row_class = '';
                switch(strtolower($r->status)) {
                  case 'for reimbursement':
                    $status_class = 'status-for-reimbursement';
                    $row_class = 'row-for-reimbursement';
                    break;
                  case 'reimbursed':
                    $status_class = 'status-reimbursed';
                    $row_class = 'row-reimbursed';
                    break;
                  case 'direct':
                    $status_class = 'status-direct';
                    $row_class = 'row-direct';
                    break;
                  case 'for approval':
                    $status_class = 'status-approval';
                    $row_class = 'row-approval';
                    break;
                  case 'pending':
                    $status_class = 'status-pending';
                    $row_class = 'row-pending';
                    break;
                  default:
                    $status_class = 'status-pending';
                    $row_class = 'row-pending';
                }
                ?>
                <tr class="<?php echo $row_class; ?>" data-bs-toggle="modal" data-bs-target="#detailsModal<?php echo $r->id; ?>">
                  <td data-label="Date"><?php echo $r->reimbursement_date; ?></td>
                  <td data-label="Applied By"><?php echo $r->applied_by; ?></td>
                  <td data-label="Project"><?php echo $r->project; ?></td>
                  <td data-label="Amount"><strong>₱<?php echo number_format($r->amount, 2); ?></strong></td>
                  <td data-label="Status">
                    <span class="badge <?php echo $status_class; ?>"><?php echo $r->status; ?></span>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="text-center text-muted">No reimbursements found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modals placed outside the table structure -->
<?php if (!empty($reimburse_list)): ?>
  <?php foreach ($reimburse_list as $r): ?>
    <!-- Details Modal -->
    <div class="modal fade" id="detailsModal<?php echo $r->id; ?>" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title">Reimbursement Details (#<?php echo $r->id; ?>)</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="row g-3">
              <div class="col-md-6">
                <p><strong>Date:</strong> <?php echo $r->reimbursement_date; ?></p>
                <p><strong>Applied By:</strong> <?php echo $r->applied_by; ?></p>
                <p><strong>Type:</strong> <?php echo $r->type; ?></p>
                <p><strong>Project:</strong> <?php echo $r->project; ?></p>
              </div>
              <div class="col-md-6">
                <p><strong>Amount:</strong> ₱<?php echo number_format($r->amount, 2); ?></p>
                <p><strong>Sales Invoice:</strong> <?php echo $r->sales_invoice; ?></p>
                <p><strong>Remarks:</strong> <?php echo $r->remarks; ?></p>
                <p><strong>Status:</strong> 
                  <?php 
                  $status_class = '';
                  switch(strtolower($r->status)) {
                    case 'for reimbursement': $status_class = 'status-for-reimbursement'; break;
                    case 'reimbursed': $status_class = 'status-reimbursed'; break;
                    case 'direct': $status_class = 'status-direct'; break;
                    case 'for approval': $status_class = 'status-approval'; break;
                    case 'pending': $status_class = 'status-pending'; break;
                    default: $status_class = 'status-pending';
                  }
                  ?>
                  <span class="badge <?php echo $status_class; ?>"><?php echo $r->status; ?></span>
                </p>
              </div>
            </div>

            <hr>
            <h6>Attachments</h6>
            <div class="mb-3">
              <?php if (!empty($r->attachments)): ?>
                <?php $files = explode('|', $r->attachments); ?>
                <?php foreach ($files as $file): ?>
                  <a href="<?php echo base_url('uploads/reimbursements/'.$file); ?>" 
                     target="_blank" 
                     class="btn btn-sm btn-outline-primary mb-1">📎 <?php echo $file; ?></a><br>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-muted">No attachments uploaded.</p>
              <?php endif; ?>
            </div>

            <h6>Proofs</h6>
            <div id="proof-list-<?php echo $r->id; ?>">
              <?php if (!empty($r->proofs)): ?>
                <?php $proofs = explode('|', $r->proofs); ?>
                <?php foreach ($proofs as $file): ?>
                  <a href="<?php echo base_url('uploads/proofs/'.$file); ?>" 
                     target="_blank" 
                     class="btn btn-sm btn-outline-success mb-1">📄 <?php echo $file; ?></a><br>
                <?php endforeach; ?>
              <?php else: ?>
                <p class="text-muted">No proofs uploaded.</p>
              <?php endif; ?>
            </div>

            <hr>
            <h6>Upload New Proof</h6>
            <form action="<?php echo site_url('reimbursement/upload_proof/'.$r->id); ?>" method="post" enctype="multipart/form-data">
              <input type="file" name="proof_file" class="form-control form-control-lg mb-3" accept="image/*" required>
              <button type="submit" class="btn btn-success w-100">⬆ Upload Proof</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<!-- Latest Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>