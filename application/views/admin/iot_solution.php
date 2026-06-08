<?php $this->load->view('admin/header'); ?>
<style>
/* Main container adjustment */
main {
    padding-top: 1rem;
}

/* Sticky header animation */
.sticky-header {
    transition: all 0.3s ease;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

/* Scroll indicator */
.scroll-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 2px;
    background: linear-gradient(90deg, #4f46e5, #7c3aed);
    transition: width 0.3s ease;
}

/* Shadow on scroll */
.sticky-header.scrolled {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Save button animation */
#saveAllChanges:active {
    transform: scale(0.98);
}

/* Loading animation for save button */
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

#saveAllChanges.saving {
    animation: pulse 1.5s ease-in-out infinite;
}

/* Feature icon upload styles - FIXED LAYOUT */
.feature-icon-wrapper {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 16px;
    margin-bottom: 16px;
}

.feature-icon-preview {
    width: 64px;
    height: 64px;
    background: rgba(6, 182, 212, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 2px solid rgba(255, 255, 255, 0.2);
    flex-shrink: 0;
}

.feature-icon-preview img {
    width: 32px;
    height: 32px;
    object-fit: contain;
    filter: brightness(0) invert(1);
}

.feature-icon-preview i {
    color: #38bdf8;
    font-size: 2rem;
}

.feature-icon-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.feature-icon-upload-btn,
.feature-icon-delete-btn {
    background: #334155;
    color: white;
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 6px;
    cursor: pointer;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.feature-icon-upload-btn {
    background: #0284c7;
}

.feature-icon-delete-btn {
    background: #dc2626;
}

.feature-icon-upload-btn:hover {
    background: #0369a1;
}

.feature-icon-delete-btn:hover {
    background: #b91c1c;
}

/* Feature card layout - FIXED */
.feature-card {
    padding: 20px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 16px;
    margin-bottom: 16px;
    height: auto;
    overflow: visible;
}

.feature-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: white;
    margin-bottom: 12px;
}

.feature-description {
    width: 100%;
    margin-top: 12px;
}

/* Notification toast */
.notification-toast {
    animation: slideIn 0.3s ease;
    z-index: 9999;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

/* Form elements */
.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
}

.form-input:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    transition: all 0.2s ease;
    resize: vertical;
}

.form-textarea:focus {
    outline: none;
    border-color: #0ea5e9;
    box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
}

/* Image preview */
.image-preview {
    width: 192px;
    height: 128px;
    background: #f1f5f9;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-preview.small {
    width: 128px;
    height: 80px;
}

/* Upload button */
.upload-btn {
    padding: 0.5rem 1rem;
    background: #f0f9ff;
    color: #0284c7;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    font-weight: 500;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    display: inline-block;
}

.upload-btn:hover {
    background: #e0f2fe;
}

/* Section styles */
.section-card {
    background: white;
    border-radius: 1rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    overflow: hidden;
    margin-bottom: 2rem;
}

.section-header {
    padding: 1.5rem;
    border-bottom: 1px solid #f1f5f9;
    background: #f8fafc;
}

.section-title {
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.section-body {
    padding: 1.5rem;
}

/* Dark section for features */
.dark-section {
    background: #0f172a;
    border-radius: 1rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 2rem;
}

.dark-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(255, 255, 255, 0.05);
}

.dark-title {
    font-weight: 700;
    color: white;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.dark-subtitle {
    color: rgba(255, 255, 255, 0.5);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.dark-body {
    padding: 1.5rem;
}

/* Grid layouts */
.grid-2 {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
}

@media (max-width: 768px) {
    .grid-2 {
        grid-template-columns: 1fr;
    }
}

/* Product card */
.product-card {
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.25rem;
    background: #f8fafc;
    transition: all 0.2s ease;
    height: fit-content;
}

.product-card:hover {
    background: white;
}

.product-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    background: #e0f2fe;
    color: #0369a1;
    border-radius: 0.25rem;
    font-weight: 600;
}

/* Setup step card */
.setup-step-card {
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    padding: 1.25rem;
    background: #f8fafc;
    transition: all 0.2s ease;
    margin-bottom: 1rem;
}

.setup-step-card:hover {
    background: white;
}

.step-number {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0284c7;
    color: white;
    border-radius: 9999px;
    font-weight: 700;
    font-size: 0.75rem;
    flex-shrink: 0;
}

/* Items list */
.items-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.setup-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.setup-item-input {
    flex: 1;
    padding: 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    font-size: 0.875rem;
}

.setup-item-input:focus {
    outline: none;
    border-color: #0284c7;
    box-shadow: 0 0 0 2px rgba(2, 132, 199, 0.1);
}

.delete-btn {
    padding: 0.5rem;
    color: #ef4444;
    background: none;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    flex-shrink: 0;
}

.delete-btn:hover {
    background: #fee2e2;
    color: #dc2626;
}

.add-item-btn {
    width: 100%;
    padding: 0.5rem;
    border: 2px dashed #cbd5e1;
    border-radius: 0.5rem;
    background: none;
    color: #64748b;
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
    margin-top: 0.5rem;
}

.add-item-btn:hover {
    border-color: #0284c7;
    color: #0284c7;
    background: #f0f9ff;
}

/* Hidden class */
.hidden {
    display: none;
}

/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Spacing utilities */
.mb-2 {
    margin-bottom: 0.5rem;
}
.mb-4 {
    margin-bottom: 1rem;
}
.mt-2 {
    margin-top: 0.5rem;
}
.mt-4 {
    margin-top: 1rem;
}
.ml-12 {
    margin-left: 3rem;
}
</style>

<main class="ml-64 p-8">
    <!-- STICKY HEADER SECTION -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header mb-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">IoT Solution (GEMBA) Editor</h1>
                    <p class="text-slate-500 mt-1">Manage machine monitoring content, system setup steps, and dashboard previews.</p>
                </div>
                <div class="flex gap-3">
                    <button id="saveAllChanges" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl font-semibold shadow-md shadow-sky-100 hover:bg-sky-700 transition-all flex items-center">
                        <svg id="saveIcon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </div>
        </div>
        <!-- Scroll Progress Bar -->
        <div class="scroll-progress"></div>
    </div>

    <div class="max-w-6xl mx-auto">
        <form id="iotGembaForm" enctype="multipart/form-data">
            <!-- Hero Section -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">
                        <span>📢</span> Hero Section
                    </h3>
                </div>
                <div class="section-body">
                    <div class="space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Hero Title</label>
                            <input type="text" id="hero_title" class="form-input" 
                                   value="<?php echo htmlspecialchars($hero['title'] ?? 'Real-Time Machine Monitoring That Keeps You in Control'); ?>">
                            <input type="hidden" id="hero_title_id" value="<?php echo $hero_title['id'] ?? ''; ?>">
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Hero Description</label>
                            <textarea id="hero_description" class="form-textarea" rows="3"><?php echo htmlspecialchars($hero['description'] ?? 'No subscription. No fixed cost. Just one setup that keeps you connected.'); ?></textarea>
                            <input type="hidden" id="hero_content_id" value="<?php echo $hero_content['id'] ?? ''; ?>">
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Hero Image</label>
                            <div class="flex items-start gap-4">
                                <div class="image-preview">
                                    <img id="heroImagePreview" src="<?php echo base_url('assets_system/images/' . ($hero['image'] ?? 'new-herogemba.png')); ?>" alt="Hero Preview">
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?php echo $hero['image'] ?? 'new-herogemba.png'; ?></span>
                                    </div>
                                    <input type="file" id="heroImageUpload" class="hidden" accept="image/*" onchange="handleImageUpload(this, 'heroImagePreview', 'hero_image')">
                                    <input type="hidden" id="hero_image" name="hero_image" value="<?php echo $hero['image'] ?? 'new-herogemba.png'; ?>">
                                    <button type="button" onclick="document.getElementById('heroImageUpload').click()" class="upload-btn">
                                        Upload New Image
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Solution Section -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">
                        <span>💡</span> Problem & Solution
                    </h3>
                </div>
                <div class="section-body">
                    <div class="space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Problem Statement</label>
                            <textarea id="problem" class="form-textarea" rows="3"><?php echo htmlspecialchars($solution['problem'] ?? 'Manual recording and delayed updates make it difficult to see what\'s really happening on the shop floor.'); ?></textarea>
                            <input type="hidden" id="problem_id" value="<?php echo $solution_problem['id'] ?? ''; ?>">
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Solution Description</label>
                            <textarea id="solution_content" class="form-textarea" rows="4"><?php echo htmlspecialchars($solution['content'] ?? 'The GEMBA Reporter Machine Monitoring System helps eliminate blind spots by capturing machine data automatically — so you can identify downtime causes, improve efficiency, and make data-driven decisions faster.'); ?></textarea>
                            <input type="hidden" id="solution_id" value="<?php echo $solution_content['id'] ?? ''; ?>">
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Solution Image</label>
                            <div class="flex items-start gap-4">
                                <div class="image-preview">
                                    <img id="solutionImagePreview" src="<?php echo base_url('assets_system/images/' . ($solution['image'] ?? 'Machine1.png')); ?>" alt="Solution Preview">
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?php echo $solution['image'] ?? 'Machine1.png'; ?></span>
                                    </div>
                                    <input type="file" id="solutionImageUpload" class="hidden" accept="image/*" onchange="handleImageUpload(this, 'solutionImagePreview', 'solution_image')">
                                    <input type="hidden" id="solution_image" name="solution_image" value="<?php echo $solution['image'] ?? 'Machine1.png'; ?>">
                                    <button type="button" onclick="document.getElementById('solutionImageUpload').click()" class="upload-btn">
                                        Upload New Image
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">
                        <span>🔧</span> Products
                    </h3>
                </div>
                <div class="section-body">
                    <div class="space-y-8">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Products Main Image</label>
                            <div class="flex items-start gap-4">
                                <div class="image-preview">
                                    <img id="productsImagePreview" src="<?php echo base_url('assets_system/images/' . ($products_main_image['image'] ?? 'Gemba-repo.png')); ?>" alt="Products Preview">
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?php echo $products_main_image['image'] ?? 'Gemba-repo.png'; ?></span>
                                    </div>
                                    <input type="file" id="productsImageUpload" class="hidden" accept="image/*" onchange="handleImageUpload(this, 'productsImagePreview', 'products_main_image')">
                                    <input type="hidden" id="products_main_image_id" name="products_main_image_id" value="<?php echo $products_main_image['id'] ?? ''; ?>">
                                    <input type="hidden" id="products_main_image" name="products_main_image" value="<?php echo $products_main_image['image'] ?? 'Gemba-repo.png'; ?>">
                                    <button type="button" onclick="document.getElementById('productsImageUpload').click()" class="upload-btn">
                                        Upload New Image
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid-2">
                            <!-- Base Station -->
                            <div class="product-card">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-bold text-slate-700">Base Station</h4>
                                    <span class="product-badge">Product 1</span>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Title</label>
                                        <input type="text" id="base_station_title" class="form-input mt-1" 
                                               value="<?php echo htmlspecialchars($products['base_station']['title'] ?? 'Base Station'); ?>">
                                        <input type="hidden" id="base_station_title_id" value="<?php echo $base_station_title['id'] ?? ''; ?>">
                                    </div>
                                    
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                        <textarea id="base_station_content" class="form-textarea mt-1" rows="4"><?php echo htmlspecialchars($products['base_station']['content'] ?? 'Acts as the control hub, receiving and storing data from up to 10 Smart Counters simultaneously. Loaded with Line Seiki\'s in-house software, it organizes the data and performs real-time analysis.'); ?></textarea>
                                        <input type="hidden" id="base_station_content_id" value="<?php echo $base_station_content['id'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Smart Counter -->
                            <div class="product-card">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="font-bold text-slate-700">Smart Counter</h4>
                                    <span class="product-badge">Product 2</span>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Title</label>
                                        <input type="text" id="smart_counter_title" class="form-input mt-1" 
                                               value="<?php echo htmlspecialchars($products['smart_counter']['title'] ?? 'Smart Counter'); ?>">
                                        <input type="hidden" id="smart_counter_title_id" value="<?php echo $smart_counter_title['id'] ?? ''; ?>">
                                    </div>
                                    
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                        <textarea id="smart_counter_content" class="form-textarea mt-1" rows="4"><?php echo htmlspecialchars($products['smart_counter']['content'] ?? 'Mounted directly on your machine, it collects essential data such as production quantity, cycle time, and operating status. It wirelessly transmits all data to the Base Station — no need for complex wiring'); ?></textarea>
                                        <input type="hidden" id="smart_counter_content_id" value="<?php echo $smart_counter_content['id'] ?? ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Setup Section with Dynamic Items -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">
                        <span>⚙️</span> System Setup Steps
                    </h3>
                </div>
                <div class="section-body">
                    <div class="space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1 block">Setup Diagram Image</label>
                            <div class="flex items-start gap-4">
                                <div class="image-preview">
                                    <img id="setupDiagramPreview" src="<?php echo base_url('assets_system/images/' . ($setup_diagram['image'] ?? 'system-setupnobg.png')); ?>" alt="Setup Diagram Preview">
                                </div>
                                <div>
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?php echo $setup_diagram['image'] ?? 'system-setupnobg.png'; ?></span>
                                    </div>
                                    <input type="file" id="setupDiagramUpload" class="hidden" accept="image/*" onchange="handleImageUpload(this, 'setupDiagramPreview', 'setup_diagram_image')">
                                    <input type="hidden" id="setup_diagram_id" name="setup_diagram_id" value="<?php echo $setup_diagram['id'] ?? ''; ?>">
                                    <input type="hidden" id="setup_diagram_image" name="setup_diagram_image" value="<?php echo $setup_diagram['image'] ?? 'system-setupnobg.png'; ?>">
                                    <button type="button" onclick="document.getElementById('setupDiagramUpload').click()" class="upload-btn">
                                        Upload New Image
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Dynamic Setup Steps Container -->
                        <div id="setupStepsContainer">
                            <?php 
                            $setup_order = ['Smart Counter', 'Base Station', 'Factory Network', 'Data Server', 'User Device'];
                            foreach($setup_order as $index => $step): 
                                $step_data = isset($system_setup[$step]) ? $system_setup[$step] : null;
                            ?>
                            <div class="setup-step-card" data-step-index="<?= $index ?>">
                                <div class="flex items-center gap-4 mb-4">
                                    <span class="step-number"><?= $index + 1 ?></span>
                                    <div class="flex-1">
                                        <input type="hidden" id="setup_title_id_<?= $index ?>" value="<?php echo isset($step_data['id']) ? $step_data['id'] : ''; ?>">
                                        <input type="text" id="setup_title_<?= $index ?>" value="<?php echo htmlspecialchars($step); ?>" class="w-full bg-transparent border-none font-bold text-slate-700 focus:ring-0 p-0" readonly>
                                    </div>
                                </div>
                                
                                <div class="ml-12">
                                    <!-- Dynamic Items List -->
                                    <div class="items-list" data-parent-index="<?= $index ?>">
                                        <?php 
                                        $items = isset($step_data['items']) ? $step_data['items'] : [];
                                        $item_ids = isset($step_data['item_ids']) ? $step_data['item_ids'] : [];
                                        
                                        if (empty($items)) {
                                            $items = [''];
                                            $item_ids = [''];
                                        }
                                        
                                        foreach($items as $item_index => $item):
                                        ?>
                                        <div class="setup-item" data-item-index="<?= $item_index ?>">
                                            <span class="text-slate-400 w-4">•</span>
                                            <input type="hidden" class="item-id" id="setup_item_id_<?= $index ?>_<?= $item_index ?>" value="<?php echo isset($item_ids[$item_index]) ? $item_ids[$item_index] : ''; ?>">
                                            <input type="text" class="setup-item-input" id="setup_item_<?= $index ?>_<?= $item_index ?>" value="<?php echo htmlspecialchars($item); ?>" placeholder="Enter item description">
                                            <button type="button" onclick="removeSetupItem(<?= $index ?>, <?= $item_index ?>)" class="delete-btn" title="Delete item">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    
                                    <!-- Add New Item Button -->
                                    <button type="button" onclick="addSetupItem(<?= $index ?>)" class="add-item-btn">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Add Item
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Production Data Section -->
            <div class="section-card">
                <div class="section-header">
                    <h3 class="section-title">
                        <span>📊</span> Production Dashboard Previews
                    </h3>
                </div>
                <div class="section-body">
                    <div class="space-y-6">
                        <?php 
                        $production_order = ['Control Page', 'Count Dashboard', 'Duration Dashboard', 'Overview'];
                        foreach($production_order as $index => $item): 
                            $data = isset($production_data[$item]) ? $production_data[$item] : null;
                            $strip_type = $index % 2 == 0 ? 'WHITE STRIP' : 'BLUE STRIP';
                        ?>
                        <div class="product-card">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-6 h-6 flex items-center justify-center bg-slate-200 text-slate-700 rounded-full font-bold text-xs"><?= $index + 1 ?></span>
                                    <h4 class="font-bold text-slate-700"><?php echo $item; ?></h4>
                                </div>
                                <span class="text-xs px-2 py-1 <?php echo $strip_type == 'WHITE STRIP' ? 'bg-slate-200 text-slate-700' : 'bg-sky-100 text-sky-700'; ?> rounded font-bold">
                                    <?= $strip_type ?>
                                </span>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                    <textarea id="production_content_<?= $index ?>" class="form-textarea mt-1" rows="3"><?php echo isset($data['content']) ? htmlspecialchars($data['content']) : ''; ?></textarea>
                                    <input type="hidden" id="production_content_id_<?= $index ?>" value="<?php echo isset($data['content_id']) ? $data['content_id'] : ''; ?>">
                                </div>
                                
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Dashboard Image</label>
                                    <div class="mt-2 flex items-start gap-4">
                                        <div class="image-preview small">
                                            <img id="production_image_<?= $index ?>_preview" src="<?php echo isset($data['image']) && !empty($data['image']) ? base_url('assets_system/images/' . $data['image']) : base_url('assets_system/images/dashboard-placeholder.jpg'); ?>" alt="Preview">
                                        </div>
                                        <div>
                                            <div class="text-xs text-slate-500 mb-1">
                                                <?php echo isset($data['image']) ? $data['image'] : 'No image selected'; ?>
                                            </div>
                                            <input type="file" id="production_image_<?= $index ?>_upload" class="hidden" accept="image/*" onchange="handleProductionImageUpload(this, <?= $index ?>)">
                                            <input type="hidden" id="production_image_<?= $index ?>" name="production_image_<?= $index ?>" value="<?php echo isset($data['image']) ? $data['image'] : ''; ?>">
                                            <input type="hidden" id="production_title_id_<?= $index ?>" value="<?php echo isset($data['title_id']) ? $data['title_id'] : ''; ?>">
                                            <button type="button" onclick="document.getElementById('production_image_<?= $index ?>_upload').click()" class="upload-btn">
                                                Upload Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Features Section with Icon Upload and Background Image -->
            <div class="dark-section">
                <div class="dark-header">
                    <h3 class="dark-title">
                        <span>✨</span> Feature Decision Cards
                    </h3>
                    <p class="dark-subtitle">Upload icons (PNG, JPG) - Buttons are always visible</p>
                </div>
                
                <!-- Background Image for Features Section -->
                <div class="px-6 pt-4 pb-2 border-b border-white/10 bg-white/5">
                    <label class="text-xs font-bold text-white/70 uppercase tracking-wider mb-2 block">Section Background Image</label>
                    <div class="flex items-start gap-4">
                        <div class="w-48 h-32 bg-slate-800 rounded-lg border border-white/10 overflow-hidden">
                            <img id="featuresBgPreview" src="<?php echo base_url('assets_system/images/' . ($section_background['image'] ?? 'decisionsbg.jpg')); ?>" alt="Features Background Preview" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="mb-2">
                                <span class="text-sm font-medium text-white/70">Current: </span>
                                <span class="text-sm text-white/50"><?php echo $section_background['image'] ?? 'decisionsbg.jpg'; ?></span>
                            </div>
                            <input type="file" id="featuresBgUpload" class="hidden" accept="image/*" onchange="handleFeaturesBgUpload(this)">
                            <input type="hidden" id="features_background_image" name="features_background_image" value="<?php echo $section_background['image'] ?? 'decisionsbg.jpg'; ?>">
                            <input type="hidden" id="features_background_id" name="features_background_id" value="<?php echo $section_background['id'] ?? ''; ?>">
                            <button type="button" onclick="document.getElementById('featuresBgUpload').click()" class="upload-btn">
                                Upload Background Image
                            </button>
                            <p class="text-xs text-white/30 mt-2">Recommended size: 1920x1080px or larger</p>
                        </div>
                    </div>
                </div>
                
                <div class="dark-body">
                    <div class="grid-2">
                        <?php 
                        $features_order = [
                            ['key' => 'Real-Time Visibility', 'icon' => 'fa-eye'],
                            ['key' => 'Wireless Installation', 'icon' => 'fa-wifi'],
                            ['key' => 'Scalable', 'icon' => 'fa-expand-arrows-alt'],
                            ['key' => 'Automated Records', 'icon' => 'fa-file-alt'],
                            ['key' => 'Cost-Effective', 'icon' => 'fa-dollar-sign'],
                            ['key' => 'Reliable', 'icon' => 'fa-shield-alt']
                        ];
                        
                        foreach($features_order as $index => $feature): 
                            $feature_data = isset($features[$feature['key']]) ? $features[$feature['key']] : null;
                            $current_icon = isset($feature_data['icon']) && !empty($feature_data['icon']) ? $feature_data['icon'] : '';
                            $title_id = isset($feature_data['title_id']) ? $feature_data['title_id'] : '';
                            $content_id = isset($feature_data['content_id']) ? $feature_data['content_id'] : '';
                            $content = isset($feature_data['content']) ? $feature_data['content'] : '';
                        ?>
                        <div class="feature-card" id="feature_card_<?= $index ?>">
                            <!-- Icon and Actions Row -->
                            <div class="feature-icon-wrapper">
                                <div class="feature-icon-preview" id="feature_icon_preview_container_<?= $index ?>">
                                    <?php if (!empty($current_icon)): ?>
                                        <img id="feature_icon_img_<?= $index ?>" 
                                             src="<?= base_url('assets_system/images/' . $current_icon) ?>" 
                                             alt="<?= $feature['key'] ?> icon">
                                    <?php else: ?>
                                        <i class="fas <?= $feature['icon'] ?>" id="feature_icon_fa_<?= $index ?>"></i>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Buttons Always Visible -->
                                <div class="feature-icon-actions">
                                    <button type="button" 
                                            class="feature-icon-upload-btn"
                                            onclick="document.getElementById('feature_icon_file_<?= $index ?>').click()">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                        </svg>
                                        Upload
                                    </button>
                                    
                                    <?php if (!empty($current_icon)): ?>
                                    <button type="button" 
                                            class="feature-icon-delete-btn"
                                            onclick="deleteFeatureIcon(<?= $index ?>, '<?= $feature['key'] ?>', '<?= $feature['icon'] ?>')">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Delete
                                    </button>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Hidden File Input -->
                                <input type="file" 
                                       id="feature_icon_file_<?= $index ?>" 
                                       class="hidden" 
                                       accept="image/*"
                                       onchange="uploadFeatureIcon(this, <?= $index ?>, '<?= $feature['key'] ?>', '<?= $feature['icon'] ?>')">
                            </div>
                            
                            <!-- Feature Content -->
                            <div class="feature-description">
                                <input type="hidden" id="feature_title_id_<?= $index ?>" name="feature_title_id_<?= $index ?>" value="<?= $title_id ?>">
                                <input type="hidden" id="feature_icon_<?= $index ?>" name="feature_icon_<?= $index ?>" value="<?= $current_icon ?>">
                                
                                <div class="feature-title"><?= htmlspecialchars($feature['key']) ?></div>
                                
                                <input type="hidden" id="feature_content_id_<?= $index ?>" name="feature_content_id_<?= $index ?>" value="<?= $content_id ?>">
                                <textarea id="feature_content_<?= $index ?>" 
                                          name="feature_content_<?= $index ?>"
                                          class="w-full bg-white/5 border border-white/10 rounded p-2 text-white text-sm focus:ring-1 focus:ring-sky-500 focus:border-sky-500 outline-none" 
                                          rows="2"
                                          placeholder="Feature description..."><?= htmlspecialchars($content) ?></textarea>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

<script>
// Global counter for unique IDs
let setupItemCounter = 1000;

/**
 * Add new item to a setup step
 */
function addSetupItem(stepIndex) {
    const itemsList = document.querySelector(`.items-list[data-parent-index="${stepIndex}"]`);
    if (!itemsList) return;
    
    const currentItems = itemsList.querySelectorAll('.setup-item');
    const newItemIndex = currentItems.length;
    
    const newItemDiv = document.createElement('div');
    newItemDiv.className = 'setup-item';
    newItemDiv.setAttribute('data-item-index', newItemIndex);
    newItemDiv.innerHTML = `
        <span class="text-slate-400 w-4">•</span>
        <input type="hidden" class="item-id" id="setup_item_id_${stepIndex}_${newItemIndex}" value="">
        <input type="text" class="setup-item-input" id="setup_item_${stepIndex}_${newItemIndex}" value="" placeholder="Enter item description">
        <button type="button" onclick="removeSetupItem(${stepIndex}, ${newItemIndex})" class="delete-btn" title="Delete item">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </button>
    `;
    
    itemsList.appendChild(newItemDiv);
    
    const newInput = document.getElementById(`setup_item_${stepIndex}_${newItemIndex}`);
    if (newInput) {
        newInput.focus();
    }
    
    showNotification('New item added. Remember to save changes!', 'info');
}

/**
 * Remove item from a setup step
 */
function removeSetupItem(stepIndex, itemIndex) {
    const itemsList = document.querySelector(`.items-list[data-parent-index="${stepIndex}"]`);
    if (!itemsList) return;
    
    const items = itemsList.querySelectorAll('.setup-item');
    
    if (items.length <= 1) {
        showNotification('Cannot remove the last item. At least one item is required.', 'error');
        return;
    }
    
    if (!confirm('Are you sure you want to delete this item?')) {
        return;
    }
    
    const itemToRemove = itemsList.querySelector(`.setup-item[data-item-index="${itemIndex}"]`);
    if (itemToRemove) {
        itemToRemove.style.opacity = '0';
        itemToRemove.style.transform = 'translateX(-10px)';
        itemToRemove.style.transition = 'all 0.3s ease';
        
        setTimeout(() => {
            itemToRemove.remove();
            reindexSetupItems(stepIndex);
            showNotification('Item removed. Remember to save changes!', 'info');
        }, 300);
    }
}

/**
 * Re-index items after deletion
 */
function reindexSetupItems(stepIndex) {
    const itemsList = document.querySelector(`.items-list[data-parent-index="${stepIndex}"]`);
    if (!itemsList) return;
    
    const items = itemsList.querySelectorAll('.setup-item');
    items.forEach((item, index) => {
        item.setAttribute('data-item-index', index);
        
        const itemIdInput = item.querySelector('.item-id');
        const itemContentInput = item.querySelector('.setup-item-input');
        const deleteButton = item.querySelector('.delete-btn');
        
        if (itemIdInput) {
            itemIdInput.id = `setup_item_id_${stepIndex}_${index}`;
        }
        
        if (itemContentInput) {
            itemContentInput.id = `setup_item_${stepIndex}_${index}`;
        }
        
        if (deleteButton) {
            deleteButton.setAttribute('onclick', `removeSetupItem(${stepIndex}, ${index})`);
        }
    });
}

/**
 * Handle image upload for regular images
 */
function handleImageUpload(input, previewId, hiddenInputId) {
    if (!input || !input.files || !input.files[0]) return;
    
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const hiddenInput = document.getElementById(hiddenInputId);
    
    if (!file.type.match('image.*')) {
        showNotification('Please select an image file (PNG, JPG, GIF)', 'error');
        input.value = '';
        return;
    }
    
    if (file.size > 2 * 1024 * 1024) {
        showNotification('Image size should be less than 2MB', 'error');
        input.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        if (preview) {
            preview.src = e.target.result;
        }
        // Note: the hidden field keeps the existing saved filename. The actual
        // file is uploaded in saveAllChanges(); the server rewrites the filename
        // only after the file is successfully moved to disk.
    };
    reader.readAsDataURL(file);
}

/**
 * Handle features background image upload
 */
function handleFeaturesBgUpload(input) {
    if (!input || !input.files || !input.files[0]) return;
    
    const file = input.files[0];
    const preview = document.getElementById('featuresBgPreview');
    const hiddenInput = document.getElementById('features_background_image');
    
    if (!file.type.match('image.*')) {
        showNotification('Please select an image file (PNG, JPG, GIF)', 'error');
        input.value = '';
        return;
    }
    
    if (file.size > 5 * 1024 * 1024) { // 5MB for background images
        showNotification('Background image size should be less than 5MB', 'error');
        input.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        if (preview) {
            preview.src = e.target.result;
        }
        if (hiddenInput) {
            hiddenInput.value = file.name;
        }
        
        // Create a separate file input for the background upload
        let bgFileInput = document.getElementById('features_background_file');
        if (!bgFileInput) {
            bgFileInput = document.createElement('input');
            bgFileInput.type = 'file';
            bgFileInput.id = 'features_background_file';
            bgFileInput.name = 'features_background_file';
            bgFileInput.className = 'hidden';
            document.getElementById('iotGembaForm').appendChild(bgFileInput);
        }
        
        // Copy the file to the new input
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        bgFileInput.files = dataTransfer.files;
    };
    reader.readAsDataURL(file);
}

/**
 * Handle production image upload
 */
function handleProductionImageUpload(input, index) {
    if (!input || !input.files || !input.files[0]) return;
    
    const file = input.files[0];
    const preview = document.getElementById(`production_image_${index}_preview`);
    const hiddenInput = document.getElementById(`production_image_${index}`);
    
    if (!file.type.match('image.*')) {
        showNotification('Please select an image file (PNG, JPG, GIF)', 'error');
        input.value = '';
        return;
    }
    
    if (file.size > 2 * 1024 * 1024) {
        showNotification('Image size should be less than 2MB', 'error');
        input.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        if (preview) {
            preview.src = e.target.result;
        }
        // Note: the hidden field keeps the existing saved filename. The actual
        // file is uploaded in saveAllChanges(); the server rewrites the filename
        // only after the file is successfully moved to disk.
    };
    reader.readAsDataURL(file);
}

/**
 * Upload feature icon
 */
function uploadFeatureIcon(input, index, featureName, defaultIcon) {
    if (!input || !input.files || !input.files[0]) return;
    
    const file = input.files[0];
    const previewContainer = document.getElementById(`feature_icon_preview_container_${index}`);
    const hiddenInput = document.getElementById(`feature_icon_${index}`);
    const card = document.getElementById(`feature_card_${index}`);
    
    if (!file.type.match('image.*')) {
        showNotification('Please select an image file (PNG, JPG, GIF)', 'error');
        input.value = '';
        return;
    }
    
    if (file.size > 2 * 1024 * 1024) {
        showNotification('Image size should be less than 2MB', 'error');
        input.value = '';
        return;
    }
    
    const reader = new FileReader();
    reader.onload = function(e) {
        // Clear the preview container
        previewContainer.innerHTML = '';
        
        // Create new image element
        const img = document.createElement('img');
        img.id = `feature_icon_img_${index}`;
        img.src = e.target.result;
        img.alt = `${featureName} icon`;
        previewContainer.appendChild(img);
        
        // Update hidden input
        hiddenInput.value = file.name;
        
        // Check if delete button exists, if not add it
        const actionContainer = card.querySelector('.feature-icon-actions');
        if (actionContainer) {
            const existingDeleteBtn = actionContainer.querySelector('.feature-icon-delete-btn');
            if (!existingDeleteBtn) {
                const deleteBtn = document.createElement('button');
                deleteBtn.type = 'button';
                deleteBtn.className = 'feature-icon-delete-btn';
                deleteBtn.setAttribute('onclick', `deleteFeatureIcon(${index}, '${featureName}', '${defaultIcon}')`);
                deleteBtn.innerHTML = '<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg> Delete';
                actionContainer.appendChild(deleteBtn);
            }
        }
        
        showNotification('Icon uploaded successfully!', 'success');
    };
    
    reader.readAsDataURL(file);
}

/**
 * Delete feature icon
 */
function deleteFeatureIcon(index, featureName, defaultIcon) {
    if (!confirm('Are you sure you want to delete this icon?')) {
        return;
    }
    
    const previewContainer = document.getElementById(`feature_icon_preview_container_${index}`);
    const hiddenInput = document.getElementById(`feature_icon_${index}`);
    const card = document.getElementById(`feature_card_${index}`);
    
    // Clear preview container
    previewContainer.innerHTML = '';
    
    // Add default Font Awesome icon
    const faIcon = document.createElement('i');
    faIcon.id = `feature_icon_fa_${index}`;
    faIcon.className = `fas ${defaultIcon}`;
    previewContainer.appendChild(faIcon);
    
    // Clear hidden input
    hiddenInput.value = '';
    
    // Remove delete button
    const actionContainer = card.querySelector('.feature-icon-actions');
    if (actionContainer) {
        const deleteBtn = actionContainer.querySelector('.feature-icon-delete-btn');
        if (deleteBtn) {
            deleteBtn.remove();
        }
    }
    
    showNotification('Icon removed. Default icon restored.', 'info');
}

/**
 * Save all changes
 */
function saveAllChanges() {
    const saveBtn = document.getElementById('saveAllChanges');
    const originalText = saveBtn.innerHTML;
    
    saveBtn.innerHTML = '<span class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';
    saveBtn.disabled = true;
    
    const formData = new FormData(document.getElementById('iotGembaForm'));
    formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    // Add hero section
    formData.append('hero_title_id', document.getElementById('hero_title_id').value);
    formData.append('hero_title', document.getElementById('hero_title').value);
    formData.append('hero_content_id', document.getElementById('hero_content_id').value);
    formData.append('hero_description', document.getElementById('hero_description').value);
    
    // Add solution section
    formData.append('problem_id', document.getElementById('problem_id').value);
    formData.append('problem', document.getElementById('problem').value);
    formData.append('solution_id', document.getElementById('solution_id').value);
    formData.append('solution_content', document.getElementById('solution_content').value);
    
    // Add products section
    formData.append('base_station_title_id', document.getElementById('base_station_title_id').value);
    formData.append('base_station_title', document.getElementById('base_station_title').value);
    formData.append('base_station_content_id', document.getElementById('base_station_content_id').value);
    formData.append('base_station_content', document.getElementById('base_station_content').value);
    
    formData.append('smart_counter_title_id', document.getElementById('smart_counter_title_id').value);
    formData.append('smart_counter_title', document.getElementById('smart_counter_title').value);
    formData.append('smart_counter_content_id', document.getElementById('smart_counter_content_id').value);
    formData.append('smart_counter_content', document.getElementById('smart_counter_content').value);
    
    // Add system setup
    const setupSteps = document.querySelectorAll('.setup-step-card');
    setupSteps.forEach((stepCard, stepIndex) => {
        const titleId = stepCard.querySelector(`#setup_title_id_${stepIndex}`);
        const titleInput = stepCard.querySelector(`#setup_title_${stepIndex}`);
        
        if (titleId && titleInput) {
            formData.append(`setup_title_id_${stepIndex}`, titleId.value);
            formData.append(`setup_title_${stepIndex}`, titleInput.value);
        }
        
        const itemsList = stepCard.querySelector('.items-list');
        if (itemsList) {
            const items = itemsList.querySelectorAll('.setup-item');
            formData.append(`setup_item_count_${stepIndex}`, items.length);
            
            items.forEach((item, itemIndex) => {
                const itemId = item.querySelector('.item-id');
                const itemContent = item.querySelector('.setup-item-input');
                
                if (itemId && itemContent) {
                    formData.append(`setup_item_id_${stepIndex}_${itemIndex}`, itemId.value);
                    formData.append(`setup_item_${stepIndex}_${itemIndex}`, itemContent.value);
                }
            });
        }
    });
    
    // Add production data
    for (let i = 0; i < 4; i++) {
        const titleId = document.getElementById(`production_title_id_${i}`);
        const contentId = document.getElementById(`production_content_id_${i}`);
        const content = document.getElementById(`production_content_${i}`);
        const image = document.getElementById(`production_image_${i}`);
        
        if (titleId) formData.append(`production_title_id_${i}`, titleId.value);
        if (contentId) formData.append(`production_content_id_${i}`, contentId.value);
        if (content) formData.append(`production_content_${i}`, content.value);
        if (image) formData.append(`production_image_${i}`, image.value);
    }
    
    // Add features
    for (let i = 0; i < 6; i++) {
        const titleId = document.getElementById(`feature_title_id_${i}`);
        const contentId = document.getElementById(`feature_content_id_${i}`);
        const content = document.getElementById(`feature_content_${i}`);
        const icon = document.getElementById(`feature_icon_${i}`);
        
        if (titleId) formData.append(`feature_title_id_${i}`, titleId.value);
        if (contentId) formData.append(`feature_content_id_${i}`, contentId.value);
        if (content) formData.append(`feature_content_${i}`, content.value);
        if (icon) formData.append(`feature_icon_${i}`, icon.value);
        
        const fileInput = document.getElementById(`feature_icon_file_${i}`);
        if (fileInput && fileInput.files.length > 0) {
            formData.append(`feature_icon_file_${i}`, fileInput.files[0]);
        }
    }
    
    // Add features background if uploaded
    const bgFileInput = document.getElementById('features_background_file');
    if (bgFileInput && bgFileInput.files.length > 0) {
        formData.append('features_background_file', bgFileInput.files[0]);
    }

    // Add section image files if newly selected (server moves them to disk)
    const sectionImageInputs = {
        'hero_image_file': 'heroImageUpload',
        'solution_image_file': 'solutionImageUpload',
        'products_main_image_file': 'productsImageUpload',
        'setup_diagram_image_file': 'setupDiagramUpload'
    };
    Object.keys(sectionImageInputs).forEach(function(fieldName) {
        const fi = document.getElementById(sectionImageInputs[fieldName]);
        if (fi && fi.files.length > 0) {
            formData.append(fieldName, fi.files[0]);
        }
    });

    // Add production image files if newly selected
    for (let i = 0; i < 4; i++) {
        const prodFile = document.getElementById(`production_image_${i}_upload`);
        if (prodFile && prodFile.files.length > 0) {
            formData.append(`production_image_file_${i}`, prodFile.files[0]);
        }
    }

    fetch('<?php echo base_url("cms/save_iotsolution"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification('All changes saved successfully!', 'success');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Error saving changes', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    })
    .finally(() => {
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

/**
 * Show notification
 */
function showNotification(message, type = 'info') {
    const existingNotification = document.querySelector('.notification-toast');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
        'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ'}</span>
            <span>${message}</span>
            <button class="ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.parentElement.remove()">×</button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Initialize on document load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('saveAllChanges').addEventListener('click', saveAllChanges);
    
    // Add scroll effect to header
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.sticky-header');
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        // Update scroll progress
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        document.querySelector('.scroll-progress').style.width = scrolled + '%';
    });
});
</script>