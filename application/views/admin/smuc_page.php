<?php $this->load->view('admin/header'); ?>
<style>
/* Main container adjustment */
main {
    padding-top: 1rem; /* Reduce top padding since header is sticky */
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

/* Add to your existing styles */
.gallery-tab {
    transition: all 0.2s ease;
}

.gallery-content {
    transition: opacity 0.3s ease;
}

.hidden {
    display: none;
}

.block {
    display: block;
}

.status-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 0.5rem;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.status-pending { background: #fef3c7; color: #92400e; }
.status-reviewed { background: #dbeafe; color: #1e40af; }
.status-contacted { background: #d1fae5; color: #065f46; }
.status-completed { background: #e5e7eb; color: #374151; }
.status-new { background: linear-gradient(135deg, #f59e0b, #d97706); color: white; }

.stat-card {
    background: white;
    border-radius: 1rem;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
}

.request-row {
    transition: all 0.2s;
}

.request-row:hover {
    background: #f9fafb;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.modal.active {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 1rem;
    max-width: 600px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
}

.file-preview {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
}

.gallery-content {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.gallery-tab.active {
    background: white;
    color: #4f46e5;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Dynamic Features Styles */
.features-management {
    transition: all 0.3s ease;
}

.feature-item {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 0.75rem;
    position: relative;
}

.feature-item:hover {
    border-color: #6366f1;
    background: #f0f9ff;
    box-shadow: 0 2px 4px rgba(99, 102, 241, 0.1);
}

.feature-item-enter {
    animation: slideIn 0.3s ease-out;
}

.feature-item-exit {
    animation: slideOut 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-10px);
    }
}

.feature-input {
    border: 1px solid #d1d5db;
    border-radius: 0.5rem;
    padding: 0.75rem;
    font-size: 0.875rem;
    width: 100%;
    transition: all 0.2s;
    background: white;
}

.feature-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
    outline: none;
}

.sortable-handle {
    cursor: move;
    color: #6b7280;
    transition: color 0.2s;
    padding: 4px;
    border-radius: 4px;
}

.sortable-handle:hover {
    color: #4f46e5;
    background: #f3f4f6;
}

.feature-actions {
    display: flex;
    gap: 4px;
}

.feature-actions button {
    padding: 6px;
    border-radius: 6px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.feature-actions button:hover {
    background: #f3f4f6;
}

.feature-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    background: #4f46e5;
    color: white;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: 600;
    margin-right: 8px;
}

.feature-item.dragging {
    opacity: 0.5;
    background: #f0f9ff;
    border-style: dashed;
}

.empty-features-state {
    border: 2px dashed #d1d5db;
    border-radius: 0.75rem;
    padding: 3rem 1.5rem;
    text-align: center;
    background: #f9fafb;
    transition: all 0.3s;
}

.empty-features-state:hover {
    border-color: #6366f1;
    background: #f0f9ff;
}

.feature-changed {
    border-left: 4px solid #f59e0b !important;
}

.feature-new {
    border-left: 4px solid #10b981 !important;
}

.feature-to-delete {
    border-left: 4px solid #ef4444 !important;
    opacity: 0.7;
}

/* New badge animation */
@keyframes pulse-glow {
    0%, 100% { 
        opacity: 1;
        box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.7);
    }
    50% { 
        opacity: 0.9;
        box-shadow: 0 0 0 4px rgba(245, 158, 11, 0);
    }
}

.status-new {
    animation: pulse-glow 2s infinite;
}
</style>
<main class="ml-64 p-8">
    <!-- STICKY HEADER SECTION -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header mb-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">SMUC Service Editor</h1>
                    <p class="text-slate-500 mt-1">Manage Silicone Molding & Urethane Casting content.</p>
                </div>
                <div class="flex gap-3">
                    <button id="saveAllChanges" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
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
        <!-- QUOTE REQUESTS SECTION - MOVED TO TOP -->
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Quote Requests</h1>
                    <p class="text-slate-600 mt-2">Manage and review all quote requests from customers</p>
                </div>
            </div>
            
            <!-- Requests Table -->
            <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-slate-50 border-b border-slate-200">
                            <tr>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Name</th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Email</th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Company</th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Contact</th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">File</th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Date</th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Status</th>
                                <th class="text-left py-3 px-6 text-xs font-bold text-slate-600 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-12 text-slate-500">
                                    <svg class="w-16 h-16 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                    <p class="text-lg font-medium">No quote requests found</p>
                                    <p class="text-sm">Try adjusting your filters or search terms</p>
                                </td>
                            </tr>
                            <?php else: ?>
                                <?php foreach ($requests as $request): ?>
                                <tr class="request-row" id="request-<?= $request->id ?>">
                                    <td class="py-4 px-6 text-sm text-slate-900"><?= htmlspecialchars($request->name) ?></td>
                                    <td class="py-4 px-6 text-sm text-slate-600">
                                        <a href="mailto:<?= htmlspecialchars($request->email) ?>" class="text-indigo-600 hover:text-indigo-800">
                                            <?= htmlspecialchars($request->email) ?>
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-900"><?= htmlspecialchars($request->company_name) ?></td>
                                    <td class="py-4 px-6 text-sm text-slate-600">
                                        <a href="tel:<?= htmlspecialchars($request->contact_number) ?>" class="hover:text-indigo-600">
                                            <?= htmlspecialchars($request->contact_number) ?>
                                        </a>
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <?php if (!empty($request->file_name)): ?>
                                            <a href="<?= base_url('cms/download_quote_file/' . $request->id) ?>" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Download
                                            </a>
                                        <?php else: ?>
                                            <span class="text-slate-400">No file</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6 text-sm text-slate-600">
                                        <?= date('M d, Y', strtotime($request->created_at)) ?>
                                        <br>
                                        <span class="text-xs text-slate-400"><?= date('h:i A', strtotime($request->created_at)) ?></span>
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <?php 
                                        $status_class = 'status-' . ($request->status ?: 'new');
                                        $status_text = $request->status ? ucfirst($request->status) : 'New';
                                        ?>
                                        <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                                    </td>
                                    <td class="py-4 px-6 text-sm">
                                        <button type="button" onclick="viewRequest(<?= $request->id ?>)" class="text-indigo-600 hover:text-indigo-900 font-medium mr-3">
                                            View
                                        </button>
                                        <button type="button" onclick="deleteRequest(<?= $request->id ?>)" class="text-red-600 hover:text-red-900 font-medium">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- SMUC CONTENT EDITOR FORM -->
        <form id="smucForm" enctype="multipart/form-data">
            <div class="space-y-8">
                <!-- Hero Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🚀</span> Hero Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Title</label>
                                <input type="text" id="hero_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['hero_title']['content']) ? htmlspecialchars($content['hero_title']['content']) : 'Production Quality at Low Volumes' ?>">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Image</label>
                                <div class="flex items-center gap-4 mt-2">
                                    <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                        <img id="heroImagePreview" src="<?= base_url('assets_system/images/' . (isset($content['hero_image']['image']) ? $content['hero_image']['image'] : 'sm4.png')); ?>" alt="Hero Preview" class="max-w-full max-h-full object-cover rounded">
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-2">
                                            <span class="text-sm font-medium text-slate-700">Current: </span>
                                            <span class="text-sm text-slate-500"><?= isset($content['hero_image']['image']) ? $content['hero_image']['image'] : 'sm4.png'; ?></span>
                                        </div>
                                        <input type="file" id="heroImageUpload" class="hidden" accept="image/*">
                                        <button type="button" onclick="document.getElementById('heroImageUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                            Upload New Image
                                        </button>
                                        <input type="hidden" id="hero_image" value="<?= isset($content['hero_image']['image']) ? $content['hero_image']['image'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Background Image</label>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                    <img id="bgheroImagePreview" src="<?= base_url('assets_system/images/' . (isset($content['hero_bg_img']['image']) ? $content['hero_bg_img']['image'] : 'sm5.png')); ?>" alt="Hero Preview" class="max-w-full max-h-full object-cover rounded">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?= isset($content['hero_bg_img']['image']) ? $content['hero_bg_img']['image'] : 'sm5.png'; ?></span>
                                    </div>
                                    <input type="file" id="bgheroImageUpload" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('bgheroImageUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New Image
                                    </button>
                                    <input type="hidden" id="bg_hero_image" value="<?= isset($content['hero_bg_img']['image']) ? $content['hero_bg_img']['image'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Description</label>
                            <textarea id="hero_description" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?= isset($content['hero_description']['content']) ? htmlspecialchars($content['hero_description']['content']) : 'Get full-scale aesthetics and performance without fullscale tooling. Silicone Molding and Urethane Casting deliver production-grade parts for concept, validation and low-volume runs.' ?></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Button Text</label>
                            <input type="text" id="hero_button" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['hero_button']['content']) ? htmlspecialchars($content['hero_button']['content']) : 'Request a Quote' ?>">
                        </div>
                    </div>
                </section>

                <!-- What We Do Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🎯</span> What We Do Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Title</label>
                            <input type="text" id="what_we_do_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['what_we_do_title']['content']) ? htmlspecialchars($content['what_we_do_title']['content']) : 'WHAT DO WE DO' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Subtitle</label>
                            <textarea id="what_we_do_subtitle" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="2"><?= isset($content['what_we_do_subtitle']['content']) ? htmlspecialchars($content['what_we_do_subtitle']['content']) : 'Precision-crafted parts through Silicone Molding and Urethane Casting.' ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Silicone Mold -->
                            <div class="p-4 border rounded-xl border-blue-100 bg-blue-50/30 hover:bg-blue-50 transition-colors">
                                <div class="mb-4">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Silicone Mold Title</label>
                                    <input type="text" id="silicone_mold_title" class="font-bold text-blue-600 border-none bg-transparent w-full text-lg" value="<?= isset($content['silicone_mold_title']['content']) ? htmlspecialchars($content['silicone_mold_title']['content']) : 'Silicone Mold' ?>">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                    <textarea id="silicone_mold_description" class="w-full text-sm p-2 border border-blue-100 rounded-lg focus:ring-1 focus:ring-blue-500 resize-none" rows="2"><?= isset($content['silicone_mold_description']['content']) ? htmlspecialchars($content['silicone_mold_description']['content']) : 'Flexible, high-detail molds that capture even the most intricate surface textures.' ?></textarea>
                                </div>
                            </div>
                            
                            <!-- Urethane Part -->
                            <div class="p-4 border rounded-xl border-green-100 bg-green-50/30 hover:bg-green-50 transition-colors">
                                <div class="mb-4">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Urethane Part Title</label>
                                    <input type="text" id="urethane_part_title" class="font-bold text-green-600 border-none bg-transparent w-full text-lg" value="<?= isset($content['urethane_part_title']['content']) ? htmlspecialchars($content['urethane_part_title']['content']) : 'Urethane Part' ?>">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                    <textarea id="urethane_part_description" class="w-full text-sm p-2 border border-green-100 rounded-lg focus:ring-1 focus:ring-green-500 resize-none" rows="2"><?= isset($content['urethane_part_description']['content']) ? htmlspecialchars($content['urethane_part_description']['content']) : 'Durable, functional, and production-grade.' ?></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Illustration Images -->
                        <div class="space-y-4">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Illustration Images</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <?php 
                                $illustration_images = [
                                    'illustration_top_mold' => ['id' => 'illustration_top_mold', 'label' => 'Top Mold', 'default' => 'sm1.png'],
                                    'illustration_internal_part' => ['id' => 'illustration_internal_part', 'label' => 'Internal Part', 'default' => 'sm2.png'],
                                    'illustration_bottom_mold' => ['id' => 'illustration_bottom_mold', 'label' => 'Bottom Mold', 'default' => 'sm3.png']
                                ];
                                ?>
                                
                                <?php foreach ($illustration_images as $key => $img): ?>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase mb-2 block"><?= $img['label'] ?></label>
                                    <div class="flex items-center gap-3">
                                        <div class="w-20 h-20 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                            <img id="<?= $key ?>Preview" src="<?= base_url('assets_system/images/' . (isset($content[$key]['image']) ? $content[$key]['image'] : $img['default'])); ?>" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex-1">
                                            <div class="text-xs text-slate-500 mb-1 truncate">
                                                <?= isset($content[$key]['image']) ? $content[$key]['image'] : $img['default'] ?>
                                            </div>
                                            <input type="file" id="<?= $key ?>Upload" class="hidden" accept="image/*">
                                            <input type="hidden" id="<?= $key ?>" value="<?= isset($content[$key]['image']) ? $content[$key]['image'] : '' ?>">
                                            <button type="button" onclick="document.getElementById('<?= $key ?>Upload').click()" class="text-xs text-indigo-600 font-medium hover:text-indigo-800 transition-colors">
                                                Change
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Silicone Molding Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🛠️</span> Silicone Molding</h3>
                        <button type="button" onclick="addFeature('silicone_molding')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                            + Add Feature
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Title</label>
                            <input type="text" id="silicone_molding_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['silicone_molding_title']['content']) ? htmlspecialchars($content['silicone_molding_title']['content']) : 'Silicone Molding' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description</label>
                            <textarea id="silicone_molding_content" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="4"><?= isset($content['silicone_molding_content']['content']) ? htmlspecialchars($content['silicone_molding_content']['content']) : 'Silicone molding—also known as Room Temperature Vulcanizing (RTV) molding—uses a flexible silicone mold to reproduce parts with exceptional surface detail and accuracy. It\'s the ideal process for creating small-batch or low-volume parts without the high investment cost of injection molding or press dies.' ?></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Features Title</label>
                            <input type="text" id="silicone_molding_features_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['silicone_molding_features_title']['content']) ? htmlspecialchars($content['silicone_molding_features_title']['content']) : 'Key Features:' ?>">
                        </div>
                        
                        <!-- Dynamic Silicone Molding Features -->
                        <div id="siliconeMoldingFeaturesContainer" class="features-management space-y-3">
                            <?php 
                            // Get silicone molding features
                            $silicone_features = [];
                            foreach ($content as $key => $item) {
                                if (strpos($key, 'silicone_molding_feature_') === 0 && isset($item['content']) && !empty(trim($item['content']))) {
                                    $silicone_features[] = [
                                        'key' => $key,
                                        'content' => $item['content'],
                                        'id' => isset($item['id']) ? $item['id'] : null,
                                        'number' => intval(str_replace('silicone_molding_feature_', '', $key))
                                    ];
                                }
                            }
                            
                            // Sort by number
                            usort($silicone_features, function($a, $b) {
                                return $a['number'] - $b['number'];
                            });
                            ?>
                            
                            <?php if (empty($silicone_features)): ?>
                                <div class="empty-features-state">
                                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h4 class="text-lg font-medium text-slate-700 mb-2">No features added yet</h4>
                                    <p class="text-slate-500 mb-4">Click "Add Feature" to create your first feature</p>
                                    <button type="button" onclick="addFeature('silicone_molding')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                                        Add Your First Feature
                                    </button>
                                </div>
                            <?php else: ?>
                                <?php foreach ($silicone_features as $index => $feature): ?>
                                <div class="feature-item" data-id="<?= $feature['id'] ?>" data-key="<?= $feature['key'] ?>" data-index="<?= $index ?>">
                                    <div class="flex items-start gap-3">
                                        <div class="sortable-handle flex-shrink-0 mt-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="feature-number"><?= $index + 1 ?></span>
                                                <span class="text-xs font-medium text-slate-500">Feature <?= $index + 1 ?></span>
                                            </div>
                                            <input type="text" 
                                                   value="<?= htmlspecialchars($feature['content']) ?>" 
                                                   class="feature-input"
                                                   placeholder="Enter feature description..."
                                                   onchange="updateFeature('silicone_molding', this)">
                                            <input type="hidden" name="<?= $feature['key'] ?>" value="<?= htmlspecialchars($feature['content']) ?>">
                                            <?php if ($feature['id']): ?>
                                                <input type="hidden" name="<?= $feature['key'] ?>_id" value="<?= $feature['id'] ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="feature-actions flex-shrink-0">
                                            <button type="button" onclick="moveFeatureUp(this)" class="text-slate-400 hover:text-indigo-600" title="Move up">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="moveFeatureDown(this)" class="text-slate-400 hover:text-indigo-600" title="Move down">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="removeFeature(this, 'silicone_molding')" class="text-slate-400 hover:text-red-600" title="Remove">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Urethane Casting Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">💎</span> Urethane Casting</h3>
                        <button type="button" onclick="addFeature('urethane_casting')" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                            + Add Feature
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Title</label>
                            <input type="text" id="urethane_casting_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['urethane_casting_title']['content']) ? htmlspecialchars($content['urethane_casting_title']['content']) : 'Urethane Casting' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description</label>
                            <textarea id="urethane_casting_content" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="4"><?= isset($content['urethane_casting_content']['content']) ? htmlspecialchars($content['urethane_casting_content']['content']) : 'Urethane casting uses thermosetting polyurethane resins—similar to epoxy—to produce multiple copies of your master model. Combined with silicone molds, this process delivers high-detail prototypes and functional parts that can match the look, feel, and performance of injection-molded products.' ?></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Features Title</label>
                            <input type="text" id="urethane_casting_features_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['urethane_casting_features_title']['content']) ? htmlspecialchars($content['urethane_casting_features_title']['content']) : 'Key Features:' ?>">
                        </div>
                        
                        <!-- Dynamic Urethane Casting Features -->
                        <div id="urethaneCastingFeaturesContainer" class="features-management space-y-3">
                            <?php 
                            // Get urethane casting features
                            $urethane_features = [];
                            foreach ($content as $key => $item) {
                                if (strpos($key, 'urethane_casting_feature_') === 0 && isset($item['content']) && !empty(trim($item['content']))) {
                                    $urethane_features[] = [
                                        'key' => $key,
                                        'content' => $item['content'],
                                        'id' => isset($item['id']) ? $item['id'] : null,
                                        'number' => intval(str_replace('urethane_casting_feature_', '', $key))
                                    ];
                                }
                            }
                            
                            // Sort by number
                            usort($urethane_features, function($a, $b) {
                                return $a['number'] - $b['number'];
                            });
                            ?>
                            
                            <?php if (empty($urethane_features)): ?>
                                <div class="empty-features-state">
                                    <svg class="w-12 h-12 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <h4 class="text-lg font-medium text-slate-700 mb-2">No features added yet</h4>
                                    <p class="text-slate-500 mb-4">Click "Add Feature" to create your first feature</p>
                                    <button type="button" onclick="addFeature('urethane_casting')" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                        Add Your First Feature
                                    </button>
                                </div>
                            <?php else: ?>
                                <?php foreach ($urethane_features as $index => $feature): ?>
                                <div class="feature-item" data-id="<?= $feature['id'] ?>" data-key="<?= $feature['key'] ?>" data-index="<?= $index ?>">
                                    <div class="flex items-start gap-3">
                                        <div class="sortable-handle flex-shrink-0 mt-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="feature-number"><?= $index + 1 ?></span>
                                                <span class="text-xs font-medium text-slate-500">Feature <?= $index + 1 ?></span>
                                            </div>
                                            <input type="text" 
                                                   value="<?= htmlspecialchars($feature['content']) ?>" 
                                                   class="feature-input"
                                                   placeholder="Enter feature description..."
                                                   onchange="updateFeature('urethane_casting', this)">
                                            <input type="hidden" name="<?= $feature['key'] ?>" value="<?= htmlspecialchars($feature['content']) ?>">
                                            <?php if ($feature['id']): ?>
                                                <input type="hidden" name="<?= $feature['key'] ?>_id" value="<?= $feature['id'] ?>">
                                            <?php endif; ?>
                                        </div>
                                        <div class="feature-actions flex-shrink-0">
                                            <button type="button" onclick="moveFeatureUp(this)" class="text-slate-400 hover:text-green-600" title="Move up">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="moveFeatureDown(this)" class="text-slate-400 hover:text-green-600" title="Move down">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                                </svg>
                                            </button>
                                            <button type="button" onclick="removeFeature(this, 'urethane_casting')" class="text-slate-400 hover:text-red-600" title="Remove">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

                <!-- Process Steps Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">📋</span> Process Steps</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="p-4 border rounded-xl border-slate-100 bg-slate-50/50 hover:bg-white transition-colors">
                                <div class="mb-3">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Step <?= $i ?> Image</label>
                                    <div class="w-full h-32 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden mb-2">
                                        <img id="process_step_<?= $i ?>_image_preview" src="<?= base_url('assets_system/images/' . (isset($content['process_step_' . $i . '_image']['image']) ? $content['process_step_' . $i . '_image']['image'] : 'sm' . ($i+5) . '.png')); ?>" class="w-full h-full object-cover">
                                    </div>
                                    <input type="file" id="process_step_<?= $i ?>_image_upload" class="hidden" accept="image/*">
                                    <input type="hidden" id="process_step_<?= $i ?>_image" value="<?= isset($content['process_step_' . $i . '_image']['image']) ? $content['process_step_' . $i . '_image']['image'] : '' ?>">
                                    <button type="button" onclick="document.getElementById('process_step_<?= $i ?>_image_upload').click()" class="text-xs text-indigo-600 font-medium hover:text-indigo-800">
                                        Change Image
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Title</label>
                                        <input type="text" id="process_step_<?= $i ?>_title" class="w-full text-sm p-2 border border-slate-200 rounded-lg" value="<?= isset($content['process_step_' . $i . '_title']['content']) ? htmlspecialchars($content['process_step_' . $i . '_title']['content']) : '' ?>">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                        <textarea id="process_step_<?= $i ?>_description" class="w-full text-sm p-2 border border-slate-200 rounded-lg resize-none" rows="2"><?= isset($content['process_step_' . $i . '_description']['content']) ? htmlspecialchars($content['process_step_' . $i . '_description']['content']) : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </section>

                <!-- Gallery Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800">Project Gallery Manager</h3>
                        <button type="button" onclick="addGalleryItem('urethane_parts')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                            + Add Urethane Item
                        </button>
                        <button type="button" onclick="addGalleryItem('overmolding')" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                            + Add Overmolding Item
                        </button>
                    </div>
                    <div class="p-6">
                        <!-- Gallery Tabs -->
                        <div class="flex space-x-1 mb-6 bg-slate-100 p-1 rounded-lg">
                            <button type="button" id="galleryTab1" 
                                    class="gallery-tab px-4 py-2 text-sm font-medium rounded-lg transition-colors bg-white text-indigo-700 shadow-sm" 
                                    onclick="switchGalleryTab(1)">
                                Urethane Parts (<?= count($gallery_urethane) ?>)
                            </button>
                            <button type="button" id="galleryTab2" 
                                    class="gallery-tab px-4 py-2 text-sm font-medium rounded-lg transition-colors text-slate-600 hover:text-slate-900" 
                                    onclick="switchGalleryTab(2)">
                                Overmolding (<?= count($gallery_overmolding) ?>)
                            </button>
                        </div>
                        
                        <!-- Urethane Parts Gallery -->
                        <div id="galleryContent1" class="gallery-content block">
                            <div class="mb-4">
                                <div id="urethaneGalleryContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <?php foreach ($gallery_urethane as $index => $item): ?>
                                    <div class="gallery-item group relative rounded-xl border border-slate-200 overflow-hidden hover:border-indigo-300 transition-colors" data-type="urethane_parts" data-index="<?= $index ?>" data-id="<?= $item->id ?>">
                                        <div class="relative">
                                            <img id="gallery_item_<?= $index + 1 ?>_image_preview" 
                                                 src="<?= base_url('assets_system/images/' . $item->image) ?>" 
                                                 class="w-full h-32 object-cover">
                                            
                                            <!-- Image upload overlay -->
                                            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <input type="file" 
                                                       id="gallery_item_<?= $index + 1 ?>_image_upload" 
                                                       class="hidden gallery-image-upload" 
                                                       accept="image/*"
                                                       data-index="<?= $index + 1 ?>"
                                                       data-type="urethane_parts"
                                                       onchange="handleGalleryImageUpload(this)">
                                                <input type="hidden" 
                                                       id="gallery_item_<?= $index + 1 ?>_image" 
                                                       value="<?= $item->image ?>">
                                                <button type="button" 
                                                        onclick="document.getElementById('gallery_item_<?= $index + 1 ?>_image_upload').click()"
                                                        class="px-3 py-1 bg-white text-indigo-600 rounded-lg text-xs font-medium hover:bg-indigo-50 transition-colors mr-2">
                                                    Change Image
                                                </button>
                                                <button type="button" 
                                                        onclick="removeGalleryItem(this, 'urethane_parts')"
                                                        class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition-colors">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <!-- Content Area -->
                                        <div class="p-2 bg-white">
                                            <textarea 
                                                name="gallery_item_<?= $index + 1 ?>_title"
                                                class="w-full text-xs font-bold resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                                                rows="1"
                                                placeholder="Enter title..."
                                                oninput="autoResize(this)"
                                            ><?= htmlspecialchars($item->title) ?></textarea>
                                            
                                            <textarea 
                                                name="gallery_item_<?= $index + 1 ?>_description"
                                                class="w-full text-[10px] text-slate-600 mt-1 resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                                                rows="2"
                                                placeholder="Enter description..."
                                                oninput="autoResize(this)"
                                            ><?= htmlspecialchars($item->description) ?></textarea>
                                            
                                            <textarea 
                                                name="gallery_item_<?= $index + 1 ?>_tags"
                                                class="w-full text-[10px] text-indigo-500 font-bold mt-1 resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                                                rows="1"
                                                placeholder="Enter tags..."
                                                oninput="autoResize(this)"
                                            ><?= htmlspecialchars($item->tags) ?></textarea>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Overmolding Gallery -->
                        <div id="galleryContent2" class="gallery-content hidden">
                            <div id="overmoldingGalleryContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <?php foreach ($gallery_overmolding as $index => $item): ?>
                                <div class="gallery-item group relative rounded-xl border border-slate-200 overflow-hidden hover:border-indigo-300 transition-colors" data-type="overmolding" data-index="<?= $index ?>" data-id="<?= $item->id ?>">
                                    <div class="relative">
                                        <img id="gallery_overmold_<?= $index + 1 ?>_image_preview" 
                                             src="<?= base_url('assets_system/images/' . $item->image) ?>" 
                                             class="w-full h-32 object-cover">
                                        
                                        <!-- Image upload overlay -->
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <input type="file" 
                                                   id="gallery_overmold_<?= $index + 1 ?>_image_upload" 
                                                   class="hidden gallery-image-upload" 
                                                   accept="image/*"
                                                   data-index="<?= $index + 1 ?>"
                                                   data-type="overmolding"
                                                   onchange="handleGalleryImageUpload(this)">
                                            <input type="hidden" 
                                                   id="gallery_overmold_<?= $index + 1 ?>_image" 
                                                   value="<?= $item->image ?>">
                                            <button type="button" 
                                                    onclick="document.getElementById('gallery_overmold_<?= $index + 1 ?>_image_upload').click()"
                                                    class="px-3 py-1 bg-white text-indigo-600 rounded-lg text-xs font-medium hover:bg-indigo-50 transition-colors mr-2">
                                                Change Image
                                            </button>
                                            <button type="button" 
                                                    onclick="removeGalleryItem(this, 'overmolding')"
                                                    class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition-colors">
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Content Area -->
                                    <div class="p-2 bg-white">
                                        <textarea 
                                            name="gallery_overmold_<?= $index + 1 ?>_title"
                                            class="w-full text-xs font-bold resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                                            rows="1"
                                            placeholder="Enter title..."
                                            oninput="autoResize(this)"
                                        ><?= htmlspecialchars($item->title) ?></textarea>
                                        
                                        <textarea 
                                            name="gallery_overmold_<?= $index + 1 ?>_description"
                                            class="w-full text-[10px] text-slate-600 mt-1 resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                                            rows="2"
                                            placeholder="Enter description..."
                                            oninput="autoResize(this)"
                                        ><?= htmlspecialchars($item->description) ?></textarea>
                                        
                                        <textarea 
                                            name="gallery_overmold_<?= $index + 1 ?>_tags"
                                            class="w-full text-[10px] text-indigo-500 font-bold mt-1 resize-none bg-transparent border-0 p-0 focus:outline-none overflow-hidden"
                                            rows="1"
                                            placeholder="Enter tags..."
                                            oninput="autoResize(this)"
                                        ><?= htmlspecialchars($item->tags) ?></textarea>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Why Choose Us Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">⭐</span> Why Choose Us</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Small Title</label>
                            <input type="text" id="wcu_subtitle" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['wcu_subtitle']['content']) ? htmlspecialchars($content['wcu_subtitle']['content']) : 'Our Advantage' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Main Title</label>
                            <input type="text" id="wcu_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['wcu_title']['content']) ? htmlspecialchars($content['wcu_title']['content']) : 'Why Choose Line Seiki?' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description</label>
                            <textarea id="wcu_description" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?= isset($content['wcu_description']['content']) ? htmlspecialchars($content['wcu_description']['content']) : 'Combining Japanese precision engineering with rapid prototyping agility to deliver superior results.' ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="p-4 border rounded-xl border-slate-100 bg-slate-50/50 hover:bg-white transition-colors">
                                <div class="mb-3">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Card <?= $i ?> Title</label>
                                    <input type="text" id="wcu_card_<?= $i ?>_title" class="font-bold text-slate-700 border-none bg-transparent w-full text-lg" value="<?= isset($content['wcu_card_' . $i . '_title']['content']) ? htmlspecialchars($content['wcu_card_' . $i . '_title']['content']) : '' ?>">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                    <textarea id="wcu_card_<?= $i ?>_description" class="w-full text-sm p-2 border border-slate-100 rounded-lg focus:ring-1 focus:ring-slate-500 resize-none" rows="2"><?= isset($content['wcu_card_' . $i . '_description']['content']) ? htmlspecialchars($content['wcu_card_' . $i . '_description']['content']) : '' ?></textarea>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                        
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Video Background</label>
                            <div class="flex flex-col md:flex-row gap-6 mt-2">
                            
                                <!-- LEFT: Video Preview -->
                                <div class="w-full md:w-1/3">
                                    <div class="w-full h-40 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                        <video class="w-full h-full object-cover" muted loop>
                                            <source src="<?= base_url('assets_system/images/' . (isset($content['wcu_video']['image']) ? $content['wcu_video']['image'] : 'Facility Tour.mp4')) ?>" type="video/mp4">
                                        </video>
                                    </div>
                            
                                    <div class="mt-3">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500">
                                            <?= isset($content['wcu_video']['image']) ? $content['wcu_video']['image'] : 'Facility Tour.mp4'; ?>
                                        </span>
                                    </div>
                            
                                    <input type="file" id="wcuVideoUpload" class="hidden" accept="video/*">
                                    <input type="hidden" id="wcu_video" value="<?= isset($content['wcu_video']['image']) ? $content['wcu_video']['image'] : '' ?>">
                            
                                    <button type="button"
                                        onclick="document.getElementById('wcuVideoUpload').click()"
                                        class="mt-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New Video
                                    </button>
                                </div>
                            
                                <!-- RIGHT: Video Text Content -->
                                <div class="flex-1 space-y-4">
                            
                                    <!-- Header -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                            Video Header
                                        </label>
                                        <input type="text"
                                            id="video_text_header"
                                            class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                            value="<?= isset($content['video_text_header']['content']) ? htmlspecialchars($content['video_text_header']['content']) : '' ?>">
                                    </div>
                            
                                    <!-- Sub Text -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">
                                            Video Sub Text
                                        </label>
                                        <textarea
                                            id="video_text_sub"
                                            rows="3"
                                            class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"><?= isset($content['video_text_sub']['content']) ? htmlspecialchars($content['video_text_sub']['content']) : '' ?></textarea>
                                    </div>
                            
                                </div>
                            
                            </div>

                        </div>
                    </div>
                </section>

                <!-- Benefits Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">💰</span> Benefits Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Title</label>
                            <input type="text" id="benefits_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['benefits_title']['content']) ? htmlspecialchars($content['benefits_title']['content']) : 'The Benefits of SMUC' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Subtitle</label>
                            <textarea id="benefits_subtitle" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="2"><?= isset($content['benefits_subtitle']['content']) ? htmlspecialchars($content['benefits_subtitle']['content']) : 'Silicone Molding & Urethane Casting (SMUC) bridges the gap between prototyping and mass production.' ?></textarea>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php for ($i = 1; $i <= 4; $i++): ?>
                            <div class="p-4 border rounded-xl border-slate-100 bg-slate-50/50 hover:bg-white transition-colors">
                                <div class="mb-3">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Benefit <?= $i ?> Number</label>
                                    <input type="text" id="benefit_<?= $i ?>_number" class="font-bold text-slate-700 border-none bg-transparent w-full text-2xl" value="<?= isset($content['benefit_' . $i . '_number']['content']) ? htmlspecialchars($content['benefit_' . $i . '_number']['content']) : sprintf('%02d', $i) ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="text-xs font-bold text-slate-400 uppercase">Benefit Image</label>
                                    <div class="w-full h-32 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden mb-2">
                                        <img id="benefit_<?= $i ?>_image_preview" src="<?= base_url('assets_system/images/' . (isset($content['benefit_' . $i . '_image']['image']) ? $content['benefit_' . $i . '_image']['image'] : 'SMUC' . $i . '.jpg')); ?>" class="w-full h-full object-cover">
                                    </div>
                                    <input type="file" id="benefit_<?= $i ?>_image_upload" class="hidden" accept="image/*">
                                    <input type="hidden" id="benefit_<?= $i ?>_image" value="<?= isset($content['benefit_' . $i . '_image']['image']) ? $content['benefit_' . $i . '_image']['image'] : '' ?>">
                                    <button type="button" onclick="document.getElementById('benefit_<?= $i ?>_image_upload').click()" class="text-xs text-indigo-600 font-medium hover:text-indigo-800">
                                        Change Image
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Title</label>
                                        <input type="text" id="benefit_<?= $i ?>_title" class="w-full text-sm p-2 border border-slate-200 rounded-lg" value="<?= isset($content['benefit_' . $i . '_title']['content']) ? htmlspecialchars($content['benefit_' . $i . '_title']['content']) : '' ?>">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                        <textarea id="benefit_<?= $i ?>_description" class="w-full text-sm p-2 border border-slate-200 rounded-lg resize-none" rows="2"><?= isset($content['benefit_' . $i . '_description']['content']) ? htmlspecialchars($content['benefit_' . $i . '_description']['content']) : '' ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </section>

                <!-- ISO Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🏆</span> ISO Certification</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Title</label>
                            <input type="text" id="iso_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['iso_title']['content']) ? htmlspecialchars($content['iso_title']['content']) : 'Our Commitment to Quality' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Subtitle</label>
                            <input type="text" id="iso_subtitle" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['iso_subtitle']['content']) ? htmlspecialchars($content['iso_subtitle']['content']) : 'ISO 9001:2015 Certified for Excellence' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">ISO Logo</label>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="w-32 h-32 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                    <img id="isoImagePreview" src="<?= base_url('assets_system/images/' . (isset($content['iso_image']['image']) ? $content['iso_image']['image'] : 'ISO-06.png')); ?>" alt="ISO Logo" class="max-w-full max-h-full object-contain p-2">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?= isset($content['iso_image']['image']) ? $content['iso_image']['image'] : 'ISO-06.png'; ?></span>
                                    </div>
                                    <input type="file" id="isoImageUpload" class="hidden" accept="image/*">
                                    <input type="hidden" id="iso_image" value="<?= isset($content['iso_image']['image']) ? $content['iso_image']['image'] : '' ?>">
                                    <button type="button" onclick="document.getElementById('isoImageUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New Logo
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description</label>
                            <textarea id="iso_description" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="4"><?= isset($content['iso_description']['content']) ? htmlspecialchars($content['iso_description']['content']) : 'At Line Seiki Asia Pacific, quality is at the heart of everything we do. Our ISO 9001:2015 certification demonstrates our unwavering commitment to providing products and services that consistently meet customer and regulatory requirements. We are dedicated to continuous improvement, ensuring that our processes are efficient, reliable, and focused on delivering the highest level of satisfaction.' ?></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Button Text</label>
                            <input type="text" id="iso_button" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['iso_button']['content']) ? htmlspecialchars($content['iso_button']['content']) : 'Learn More About Our Quality Standards' ?>">
                        </div>
                    </div>
                </section>

                <!-- Project Submission Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">📤</span> Project Submission</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Title</label>
                            <input type="text" id="project_submission_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['project_submission_title']['content']) ? htmlspecialchars($content['project_submission_title']['content']) : 'Project Submission' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description</label>
                            <textarea id="project_submission_description" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="2"><?= isset($content['project_submission_description']['content']) ? htmlspecialchars($content['project_submission_description']['content']) : 'Upload your CAD models or design drawings to receive a detailed quote.' ?></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Button Text</label>
                            <input type="text" id="project_submission_button" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['project_submission_button']['content']) ? htmlspecialchars($content['project_submission_button']['content']) : 'Request Quote' ?>">
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</main>

<!-- View Request Modal -->
<div id="viewModal" class="modal">
    <div class="modal-content">
        <div class="p-6 border-b border-slate-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-slate-900">Quote Request Details</h2>
                <button onclick="closeModal('viewModal')" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
        <div id="modalContent" class="p-6">
            <!-- Content will be loaded dynamically -->
        </div>
    </div>
</div>

<script>
// Feature Management Functions
let siliconeMoldingFeatureCount = <?= count(array_filter(array_keys($content), function($key) { return strpos($key, 'silicone_molding_feature_') === 0; })) ?>;
let urethaneCastingFeatureCount = <?= count(array_filter(array_keys($content), function($key) { return strpos($key, 'urethane_casting_feature_') === 0; })) ?>;

function addFeature(sectionType) {
    const containerId = sectionType === 'silicone_molding' ? 'siliconeMoldingFeaturesContainer' : 'urethaneCastingFeaturesContainer';
    const container = document.getElementById(containerId);
    const prefix = sectionType === 'silicone_molding' ? 'silicone_molding_feature_' : 'urethane_casting_feature_';
    
    // Get current feature count
    const existingFeatures = container.querySelectorAll('.feature-item');
    const newIndex = existingFeatures.length + 1;
    const featureKey = prefix + newIndex;
    
    // Create new feature element
    const featureItem = document.createElement('div');
    featureItem.className = 'feature-item feature-new';
    featureItem.setAttribute('data-key', featureKey);
    featureItem.setAttribute('data-index', newIndex - 1);
    
    featureItem.innerHTML = `
        <div class="flex items-start gap-3">
            <div class="sortable-handle flex-shrink-0 mt-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                </svg>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-2 mb-2">
                    <span class="feature-number">${newIndex}</span>
                    <span class="text-xs font-medium text-slate-500">Feature ${newIndex}</span>
                </div>
                <input type="text" 
                       value="" 
                       class="feature-input"
                       placeholder="Enter feature description..."
                       onchange="updateFeature('${sectionType}', this)">
                <input type="hidden" name="${featureKey}" value="">
            </div>
            <div class="feature-actions flex-shrink-0">
                <button type="button" onclick="moveFeatureUp(this)" class="text-slate-400 hover:text-${sectionType === 'silicone_molding' ? 'indigo' : 'green'}-600" title="Move up">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                </button>
                <button type="button" onclick="moveFeatureDown(this)" class="text-slate-400 hover:text-${sectionType === 'silicone_molding' ? 'indigo' : 'green'}-600" title="Move down">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </button>
                <button type="button" onclick="removeFeature(this, '${sectionType}')" class="text-slate-400 hover:text-red-600" title="Remove">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </div>
    `;
    
    // Remove empty state if present
    const emptyState = container.querySelector('.empty-features-state');
    if (emptyState) {
        emptyState.remove();
    }
    
    // Add to container
    container.appendChild(featureItem);
    
    // Add animation
    setTimeout(() => {
        featureItem.classList.add('feature-item-enter');
    }, 10);
    
    // Focus on the new input
    const input = featureItem.querySelector('input[type="text"]');
    setTimeout(() => input.focus(), 50);
    
    // Update counter
    if (sectionType === 'silicone_molding') {
        siliconeMoldingFeatureCount++;
    } else {
        urethaneCastingFeatureCount++;
    }
    
    showNotification(`New feature added to ${sectionType.replace('_', ' ')} section`, 'success');
}

function removeFeature(button, sectionType) {
    const featureItem = button.closest('.feature-item');
    const featureId = featureItem.getAttribute('data-id');
    const featureKey = featureItem.getAttribute('data-key');
    
    if (featureId) {
        // Existing feature from database - mark for deletion
        if (!confirm('Are you sure you want to delete this feature? This action cannot be undone.')) {
            return;
        }
        
        featureItem.classList.add('feature-to-delete');
        featureItem.classList.add('feature-item-exit');
        
        // Hide the feature but keep it in DOM for backend processing
        setTimeout(() => {
            featureItem.style.display = 'none';
        }, 300);
        
        // Add a flag for backend deletion
        const hiddenInput = featureItem.querySelector('input[type="hidden"]');
        if (hiddenInput) {
            hiddenInput.name = featureKey + '_delete';
        }
        
        showNotification('Feature marked for deletion. Save to confirm.', 'warning');
    } else {
        // New feature - remove completely
        featureItem.classList.add('feature-item-exit');
        setTimeout(() => {
            featureItem.remove();
            renumberFeatures(sectionType);
            
            // Show empty state if no features left
            const containerId = sectionType === 'silicone_molding' ? 'siliconeMoldingFeaturesContainer' : 'urethaneCastingFeaturesContainer';
            const container = document.getElementById(containerId);
            const features = container.querySelectorAll('.feature-item');
            
            if (features.length === 0) {
                container.innerHTML = `
                    <div class="empty-features-state">
                        <svg class="w-12 h-12 mx-auto text-slate-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h4 class="text-lg font-medium text-slate-700 mb-2">No features added yet</h4>
                        <p class="text-slate-500 mb-4">Click "Add Feature" to create your first feature</p>
                        <button type="button" onclick="addFeature('${sectionType}')" class="px-4 py-2 ${sectionType === 'silicone_molding' ? 'bg-indigo-600' : 'bg-green-600'} text-white rounded-lg text-sm font-medium hover:${sectionType === 'silicone_molding' ? 'bg-indigo-700' : 'bg-green-700'} transition-colors">
                            Add Your First Feature
                        </button>
                    </div>
                `;
            }
        }, 300);
        
        // Update counter
        if (sectionType === 'silicone_molding') {
            siliconeMoldingFeatureCount--;
        } else {
            urethaneCastingFeatureCount--;
        }
        
        showNotification('Feature removed', 'success');
    }
}

function updateFeature(sectionType, inputElement) {
    const featureItem = inputElement.closest('.feature-item');
    const hiddenInput = featureItem.querySelector('input[type="hidden"]');
    
    if (hiddenInput) {
        hiddenInput.value = inputElement.value;
    }
    
    // Mark as changed
    if (!featureItem.classList.contains('feature-new')) {
        featureItem.classList.add('feature-changed');
    }
    
    showNotification('Feature updated', 'info');
}

function moveFeatureUp(button) {
    const featureItem = button.closest('.feature-item');
    const previousItem = featureItem.previousElementSibling;
    
    if (previousItem && !previousItem.classList.contains('empty-features-state')) {
        featureItem.parentNode.insertBefore(featureItem, previousItem);
        renumberFeatures(getSectionTypeFromContainer(featureItem.parentNode.id));
        showNotification('Feature moved up', 'info');
    }
}

function moveFeatureDown(button) {
    const featureItem = button.closest('.feature-item');
    const nextItem = featureItem.nextElementSibling;
    
    if (nextItem) {
        featureItem.parentNode.insertBefore(nextItem, featureItem);
        renumberFeatures(getSectionTypeFromContainer(featureItem.parentNode.id));
        showNotification('Feature moved down', 'info');
    }
}

function renumberFeatures(sectionType) {
    const containerId = sectionType === 'silicone_molding' ? 'siliconeMoldingFeaturesContainer' : 'urethaneCastingFeaturesContainer';
    const container = document.getElementById(containerId);
    const features = container.querySelectorAll('.feature-item:not([style*="display: none"])');
    const prefix = sectionType === 'silicone_molding' ? 'silicone_molding_feature_' : 'urethane_casting_feature_';
    
    features.forEach((feature, index) => {
        const newIndex = index + 1;
        const oldKey = feature.getAttribute('data-key');
        const newKey = prefix + newIndex;
        
        // Update index attribute
        feature.setAttribute('data-index', index);
        
        // Update feature number display
        const numberSpan = feature.querySelector('.feature-number');
        if (numberSpan) {
            numberSpan.textContent = newIndex;
        }
        
        // Update label
        const label = feature.querySelector('.text-xs.font-medium');
        if (label) {
            label.textContent = `Feature ${newIndex}`;
        }
        
        // Update data-key attribute
        feature.setAttribute('data-key', newKey);
        
        // Update hidden input name
        const hiddenInput = feature.querySelector('input[type="hidden"]');
        if (hiddenInput) {
            // Check if it's marked for deletion
            if (hiddenInput.name.includes('_delete')) {
                hiddenInput.name = newKey + '_delete';
            } else {
                hiddenInput.name = newKey;
            }
        }
        
        // Update text input onchange
        const textInput = feature.querySelector('input[type="text"]');
        if (textInput) {
            textInput.setAttribute('onchange', `updateFeature('${sectionType}', this)`);
        }
    });
}

function getSectionTypeFromContainer(containerId) {
    return containerId.includes('silicone') ? 'silicone_molding' : 'urethane_casting';
}

// Initialize drag and drop for features
document.addEventListener('DOMContentLoaded', function() {
    initFeatureSorting('siliconeMoldingFeaturesContainer');
    initFeatureSorting('urethaneCastingFeaturesContainer');
});

function initFeatureSorting(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    let draggedItem = null;
    let placeholder = null;
    
    container.querySelectorAll('.sortable-handle').forEach(handle => {
        handle.addEventListener('mousedown', startDrag);
        handle.addEventListener('touchstart', startDragTouch);
    });
    
    function startDrag(e) {
        e.preventDefault();
        draggedItem = e.target.closest('.feature-item');
        if (!draggedItem) return;
        
        initDrag();
        document.addEventListener('mousemove', onDrag);
        document.addEventListener('mouseup', stopDrag);
    }
    
    function startDragTouch(e) {
        e.preventDefault();
        draggedItem = e.target.closest('.feature-item');
        if (!draggedItem) return;
        
        initDrag();
        document.addEventListener('touchmove', onDragTouch);
        document.addEventListener('touchend', stopDrag);
    }
    
    function initDrag() {
        draggedItem.classList.add('dragging');
        draggedItem.style.opacity = '0.5';
        
        // Create placeholder
        placeholder = document.createElement('div');
        placeholder.className = 'feature-item';
        placeholder.style.height = draggedItem.offsetHeight + 'px';
        placeholder.style.border = '2px dashed #d1d5db';
        placeholder.style.borderRadius = '0.75rem';
        placeholder.style.marginBottom = '0.75rem';
        draggedItem.parentNode.insertBefore(placeholder, draggedItem.nextSibling);
    }
    
    function onDrag(e) {
        if (!draggedItem) return;
        
        const containerRect = container.getBoundingClientRect();
        const mouseY = e.clientY - containerRect.top;
        
        const features = Array.from(container.querySelectorAll('.feature-item:not(.dragging)'));
        
        let insertBefore = null;
        for (const feature of features) {
            if (feature === placeholder) continue;
            
            const rect = feature.getBoundingClientRect();
            const featureTop = rect.top - containerRect.top;
            const featureBottom = rect.bottom - containerRect.top;
            
            if (mouseY < featureTop + (rect.height / 2)) {
                insertBefore = feature;
                break;
            }
        }
        
        if (insertBefore) {
            container.insertBefore(draggedItem, insertBefore);
        } else {
            container.appendChild(draggedItem);
        }
    }
    
    function onDragTouch(e) {
        if (!draggedItem) return;
        e.preventDefault();
        
        const touch = e.touches[0];
        const containerRect = container.getBoundingClientRect();
        const touchY = touch.clientY - containerRect.top;
        
        const features = Array.from(container.querySelectorAll('.feature-item:not(.dragging)'));
        
        let insertBefore = null;
        for (const feature of features) {
            if (feature === placeholder) continue;
            
            const rect = feature.getBoundingClientRect();
            const featureTop = rect.top - containerRect.top;
            const featureBottom = rect.bottom - containerRect.top;
            
            if (touchY < featureTop + (rect.height / 2)) {
                insertBefore = feature;
                break;
            }
        }
        
        if (insertBefore) {
            container.insertBefore(draggedItem, insertBefore);
        } else {
            container.appendChild(draggedItem);
        }
    }
    
    function stopDrag() {
        if (draggedItem) {
            draggedItem.classList.remove('dragging');
            draggedItem.style.opacity = '1';
            
            // Remove placeholder
            if (placeholder && placeholder.parentNode) {
                placeholder.parentNode.removeChild(placeholder);
            }
            
            // Renumber features
            const sectionType = getSectionTypeFromContainer(containerId);
            renumberFeatures(sectionType);
            
            // Mark as changed
            if (!draggedItem.classList.contains('feature-new')) {
                draggedItem.classList.add('feature-changed');
            }
            
            showNotification('Features reordered', 'info');
        }
        
        draggedItem = null;
        placeholder = null;
        
        // Clean up event listeners
        document.removeEventListener('mousemove', onDrag);
        document.removeEventListener('mouseup', stopDrag);
        document.removeEventListener('touchmove', onDragTouch);
        document.removeEventListener('touchend', stopDrag);
    }
}

// Gallery management functions
let urethaneItemCount = <?= count($gallery_urethane) ?>;
let overmoldingItemCount = <?= count($gallery_overmolding) ?>;

function addGalleryItem(type) {
    const containerId = type === 'urethane_parts' ? 'urethaneGalleryContainer' : 'overmoldingGalleryContainer';
    const container = document.getElementById(containerId);
    const itemCount = type === 'urethane_parts' ? urethaneItemCount + 1 : overmoldingItemCount + 1;
    
    const prefix = type === 'urethane_parts' ? 'gallery_item_' : 'gallery_overmold_';
    
    const galleryItem = document.createElement('div');
    galleryItem.className = 'gallery-item group relative rounded-xl border border-slate-200 overflow-hidden hover:border-indigo-300 transition-colors';
    galleryItem.setAttribute('data-type', type);
    galleryItem.setAttribute('data-index', itemCount - 1);
    
    galleryItem.innerHTML = `
        <div class="relative">
            <img id="${prefix}${itemCount}_image_preview" 
                 src="<?= base_url('assets_system/images/placeholder.jpg') ?>" 
                 class="w-full h-32 object-cover bg-slate-100">
            
            <!-- Image upload overlay -->
            <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                <input type="file" 
                       id="${prefix}${itemCount}_image_upload" 
                       class="hidden gallery-image-upload" 
                       accept="image/*"
                       data-index="${itemCount}"
                       data-type="${type}"
                       onchange="handleGalleryImageUpload(this)">
                <input type="hidden" 
                       id="${prefix}${itemCount}_image" 
                       value="">
                <button type="button" 
                        onclick="document.getElementById('${prefix}${itemCount}_image_upload').click()"
                        class="px-3 py-1 bg-white text-indigo-600 rounded-lg text-xs font-medium hover:bg-indigo-50 transition-colors mr-2">
                    Change Image
                </button>
                <button type="button" 
                        onclick="removeGalleryItem(this, '${type}')"
                        class="px-3 py-1 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition-colors">
                    Remove
                </button>
            </div>
        </div>
        
        <!-- Content Area -->
        <div class="p-2 bg-white">
            <textarea 
                name="${prefix}${itemCount}_title"
                class="w-full text-xs font-bold resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                rows="1"
                placeholder="Enter title..."
                oninput="autoResize(this)"
            ></textarea>
            
            <textarea 
                name="${prefix}${itemCount}_description"
                class="w-full text-[10px] text-slate-600 mt-1 resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                rows="2"
                placeholder="Enter description..."
                oninput="autoResize(this)"
            ></textarea>
            
            <textarea 
                name="${prefix}${itemCount}_tags"
                class="w-full text-[10px] text-indigo-500 font-bold mt-1 resize-none bg-transparent border-0 p-0 focus:ring-0 focus:outline-none overflow-hidden"
                rows="1"
                placeholder="Enter tags..."
                oninput="autoResize(this)"
            ></textarea>
        </div>
    `;
    
    container.appendChild(galleryItem);
    
    // Update counter
    if (type === 'urethane_parts') {
        switchGalleryTab(1);
    } else {
        switchGalleryTab(2);
    }
    
    // Auto-resize textareas
    const textareas = galleryItem.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        autoResize(textarea);
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
    });
    
    showNotification(`New ${type === 'urethane_parts' ? 'Urethane Parts' : 'Overmolding'} item added`, 'success');
}

function removeGalleryItem(button, type) {
    if (!confirm('Are you sure you want to delete this gallery item?')) {
        return;
    }
    
    const galleryItem = button.closest('.gallery-item');
    const itemId = galleryItem.getAttribute('data-id');
    
    if (!itemId) {
        showNotification('Cannot delete: Item ID not found', 'error');
        return;
    }
    
    // Show loading
    button.innerHTML = 'Deleting...';
    button.disabled = true;
    
    // Simple AJAX call
    const formData = new FormData();
    formData.append('item_id', itemId);
    
    fetch('<?= base_url("cms/delete_gallery_item"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove from UI
            galleryItem.remove();
            
            // Update counter
            if (type === 'urethane_parts') {
                urethaneItemCount--;
                document.getElementById('galleryTab1').textContent = `Urethane Parts (${urethaneItemCount})`;
            } else {
                overmoldingItemCount--;
                document.getElementById('galleryTab2').textContent = `Overmolding (${overmoldingItemCount})`;
            }
            
            // Renumber items
            renumberGalleryItems(type);
            
            showNotification('Gallery item deleted successfully', 'success');
        } else {
            button.innerHTML = 'Remove';
            button.disabled = false;
            showNotification(data.message || 'Failed to delete', 'error');
        }
    })
    .catch(error => {
        button.innerHTML = 'Remove';
        button.disabled = false;
        showNotification('Network error', 'error');
        console.error('Error:', error);
    });
}

function renumberGalleryItems(type) {
    const prefix = type === 'urethane_parts' ? 'gallery_item_' : 'gallery_overmold_';
    const containerId = type === 'urethane_parts' ? 'urethaneGalleryContainer' : 'overmoldingGalleryContainer';
    const container = document.getElementById(containerId);
    const items = container.querySelectorAll('.gallery-item');
    
    items.forEach((item, index) => {
        const newIndex = index + 1;
        
        // Update all IDs in the item
        item.querySelectorAll('[id]').forEach(el => {
            const oldId = el.id;
            if (oldId.includes(prefix)) {
                const newId = oldId.replace(new RegExp(prefix + '\\d+'), prefix + newIndex);
                el.id = newId;
                
                // Update onclick handlers
                if (el.tagName === 'BUTTON') {
                    const oldOnclick = el.getAttribute('onclick');
                    if (oldOnclick && oldOnclick.includes(prefix)) {
                        const newOnclick = oldOnclick.replace(new RegExp(prefix + '\\d+', 'g'), prefix + newIndex);
                        el.setAttribute('onclick', newOnclick);
                    }
                }
                
                // Update data attributes
                if (el.hasAttribute('data-index')) {
                    el.setAttribute('data-index', newIndex);
                }
            }
        });
        
        // Update all names in the item
        item.querySelectorAll('[name]').forEach(el => {
            const oldName = el.name;
            if (oldName.includes(prefix)) {
                const newName = oldName.replace(new RegExp(prefix + '\\d+'), prefix + newIndex);
                el.name = newName;
            }
        });
        
        // Update the container's data-index
        item.setAttribute('data-index', index);
    });
}

function handleGalleryImageUpload(inputElement) {
    const file = inputElement.files[0];
    if (file) {
        const index = inputElement.getAttribute('data-index');
        const type = inputElement.getAttribute('data-type');
        const prefix = type === 'overmolding' ? 'gallery_overmold_' : 'gallery_item_';
        const previewId = `${prefix}${index}_image_preview`;
        const hiddenInputId = `${prefix}${index}_image`;
        
        const preview = document.getElementById(previewId);
        const hiddenInput = document.getElementById(hiddenInputId);
        
        if (preview && hiddenInput) {
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
            
            // Update hidden input
            hiddenInput.value = file.name;
            
            // Show notification
            showNotification(`Ready to upload: ${file.name}`, 'info');
        }
    }
}

function autoResize(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = (textarea.scrollHeight) + 'px';
}

// Gallery tab switching
function switchGalleryTab(tabNumber) {
    // Remove active state from all tabs
    document.querySelectorAll('.gallery-tab').forEach(tab => {
        tab.classList.remove('bg-white', 'text-indigo-700', 'shadow-sm');
        tab.classList.add('text-slate-600');
    });
    
    // Add active state to clicked tab
    const activeTab = document.getElementById('galleryTab' + tabNumber);
    if (activeTab) {
        activeTab.classList.remove('text-slate-600');
        activeTab.classList.add('bg-white', 'text-indigo-700', 'shadow-sm');
    }
    
    // Hide all gallery content
    document.querySelectorAll('.gallery-content').forEach(content => {
        content.classList.add('hidden');
        content.classList.remove('block');
    });
    
    // Show selected gallery content
    const activeContent = document.getElementById('galleryContent' + tabNumber);
    if (activeContent) {
        activeContent.classList.remove('hidden');
        activeContent.classList.add('block');
    }
    
    // Auto-resize textareas in the active tab
    if (activeContent) {
        const textareas = activeContent.querySelectorAll('textarea');
        textareas.forEach(textarea => {
            autoResize(textarea);
        });
    }
}

// Handle image upload previews
function handleImageUpload(inputId, previewId, hiddenInputId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const hiddenInput = document.getElementById(hiddenInputId);
    
    if (input && preview && hiddenInput) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
                
                // Update hidden input with file name
                hiddenInput.value = file.name;
                
                // Show notification
                showNotification(`Ready to upload: ${file.name}`, 'info');
            }
        });
    }
}

// Save all changes function (updated for dynamic features)
function saveAllChanges() {
    const saveBtn = document.getElementById('saveAllChanges');
    const originalText = saveBtn.textContent;
    
    // Show loading state
    saveBtn.innerHTML = '<span class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';
    saveBtn.disabled = true;
    
    // Collect all data with FormData
    const formData = new FormData();
    
    // Define all file upload fields
    const fileUploads = [
        // Hero section
        { inputId: 'heroImageUpload', formField: 'hero_image_upload', dbField: 'hero_image' },
        { inputId: 'bgheroImageUpload', formField: 'bghero_image_upload', dbField: 'bg_hero_image' },
        
        // Illustration images
        { inputId: 'illustration_top_moldUpload', formField: 'illustration_top_mold_upload', dbField: 'illustration_top_mold' },
        { inputId: 'illustration_internal_partUpload', formField: 'illustration_internal_part_upload', dbField: 'illustration_internal_part' },
        { inputId: 'illustration_bottom_moldUpload', formField: 'illustration_bottom_mold_upload', dbField: 'illustration_bottom_mold' },
        
        // Process step images
        ...Array.from({length: 4}, (_, i) => ({
            inputId: `process_step_${i+1}_image_upload`,
            formField: `process_step_${i+1}_image_upload`,
            dbField: `process_step_${i+1}_image`
        })),
        
        // Benefit images
        ...Array.from({length: 4}, (_, i) => ({
            inputId: `benefit_${i+1}_image_upload`,
            formField: `benefit_${i+1}_image_upload`,
            dbField: `benefit_${i+1}_image`
        })),
        
        // ISO image
        { inputId: 'isoImageUpload', formField: 'iso_image_upload', dbField: 'iso_image' },
        
        // WCU video
        { inputId: 'wcuVideoUpload', formField: 'wcu_video_upload', dbField: 'wcu_video' },
    ];
    
    // Append uploaded files
    fileUploads.forEach(({ inputId, formField }) => {
        const input = document.getElementById(inputId);
        if (input && input.files[0]) {
            formData.append(formField, input.files[0]);
        }
    });
    
    // Collect dynamic features data
    collectFeaturesData(formData, 'silicone_molding');
    collectFeaturesData(formData, 'urethane_casting');
    
    // Append gallery images
    collectGalleryData('urethane_parts');
    collectGalleryData('overmolding');
    
    function collectFeaturesData(formData, sectionType) {
        const containerId = sectionType === 'silicone_molding' ? 'siliconeMoldingFeaturesContainer' : 'urethaneCastingFeaturesContainer';
        const container = document.getElementById(containerId);
        const features = container.querySelectorAll('.feature-item:not([style*="display: none"])');
        
        features.forEach((feature, index) => {
            const featureIndex = index + 1;
            const key = sectionType === 'silicone_molding' ? 'silicone_molding_feature_' : 'urethane_casting_feature_';
            const fullKey = key + featureIndex;
            const input = feature.querySelector('input[type="text"]');
            const hiddenInput = feature.querySelector('input[type="hidden"]');
            const dbId = feature.getAttribute('data-id');
            
            if (input) {
                // Add content
                formData.append(fullKey, input.value);
                
                // Add DB ID if exists (for updates)
                if (dbId) {
                    formData.append(fullKey + '_id', dbId);
                }
                
                // Check if marked for deletion
                if (hiddenInput && hiddenInput.name.includes('_delete')) {
                    formData.append(fullKey + '_delete', '1');
                }
            }
        });
    }
    
    function collectGalleryData(type) {
        const prefix = type === 'urethane_parts' ? 'gallery_item_' : 'gallery_overmold_';
        const containerId = type === 'urethane_parts' ? 'urethaneGalleryContainer' : 'overmoldingGalleryContainer';
        const container = document.getElementById(containerId);
        const items = container.querySelectorAll('.gallery-item');
        
        items.forEach((item, index) => {
            const itemIndex = index + 1;
            const titleEl = item.querySelector(`textarea[name="${prefix}${itemIndex}_title"]`);
            const descEl = item.querySelector(`textarea[name="${prefix}${itemIndex}_description"]`);
            const tagsEl = item.querySelector(`textarea[name="${prefix}${itemIndex}_tags"]`);
            const imageEl = document.getElementById(`${prefix}${itemIndex}_image`);
            const fileInputEl = document.getElementById(`${prefix}${itemIndex}_image_upload`);
            
            // Add text data
            if (titleEl) formData.append(`${prefix}${itemIndex}_title`, titleEl.value);
            if (descEl) formData.append(`${prefix}${itemIndex}_description`, descEl.value);
            if (tagsEl) formData.append(`${prefix}${itemIndex}_tags`, tagsEl.value);
            if (imageEl) formData.append(`${prefix}${itemIndex}_image`, imageEl.value);
            
            // Add file if uploaded
            if (fileInputEl && fileInputEl.files[0]) {
                formData.append(`${prefix}${itemIndex}_image_upload`, fileInputEl.files[0]);
            }
        });
    }
    
    // Append all other text fields
    // Hero Section
    formData.append('hero_title', document.getElementById('hero_title').value);
    formData.append('hero_description', document.getElementById('hero_description').value);
    formData.append('hero_button', document.getElementById('hero_button').value);
    formData.append('hero_image', document.getElementById('hero_image').value);
    formData.append('bg_hero_image', document.getElementById('bg_hero_image').value);
    
    // What We Do Section
    formData.append('what_we_do_title', document.getElementById('what_we_do_title').value);
    formData.append('what_we_do_subtitle', document.getElementById('what_we_do_subtitle').value);
    formData.append('silicone_mold_title', document.getElementById('silicone_mold_title').value);
    formData.append('silicone_mold_description', document.getElementById('silicone_mold_description').value);
    formData.append('urethane_part_title', document.getElementById('urethane_part_title').value);
    formData.append('urethane_part_description', document.getElementById('urethane_part_description').value);
    
    // Illustration Images
    formData.append('illustration_top_mold', document.getElementById('illustration_top_mold').value);
    formData.append('illustration_internal_part', document.getElementById('illustration_internal_part').value);
    formData.append('illustration_bottom_mold', document.getElementById('illustration_bottom_mold').value);
    
    // Silicone Molding
    formData.append('silicone_molding_title', document.getElementById('silicone_molding_title').value);
    formData.append('silicone_molding_content', document.getElementById('silicone_molding_content').value);
    formData.append('silicone_molding_features_title', document.getElementById('silicone_molding_features_title').value);
    
    // Urethane Casting
    formData.append('urethane_casting_title', document.getElementById('urethane_casting_title').value);
    formData.append('urethane_casting_content', document.getElementById('urethane_casting_content').value);
    formData.append('urethane_casting_features_title', document.getElementById('urethane_casting_features_title').value);
    
    // Process Steps
    for (let i = 1; i <= 4; i++) {
        formData.append(`process_step_${i}_title`, document.getElementById(`process_step_${i}_title`).value);
        formData.append(`process_step_${i}_description`, document.getElementById(`process_step_${i}_description`).value);
        formData.append(`process_step_${i}_image`, document.getElementById(`process_step_${i}_image`).value);
    }
    
    // Why Choose Us
    formData.append('wcu_subtitle', document.getElementById('wcu_subtitle').value);
    formData.append('wcu_title', document.getElementById('wcu_title').value);
    formData.append('wcu_description', document.getElementById('wcu_description').value);
    formData.append('video_text_header', document.getElementById('video_text_header').value);
    formData.append('video_text_sub', document.getElementById('video_text_sub').value);
    for (let i = 1; i <= 4; i++) {
        formData.append(`wcu_card_${i}_title`, document.getElementById(`wcu_card_${i}_title`).value);
        formData.append(`wcu_card_${i}_description`, document.getElementById(`wcu_card_${i}_description`).value);
    }
    formData.append('wcu_video', document.getElementById('wcu_video').value);
    
    // Benefits
    formData.append('benefits_title', document.getElementById('benefits_title').value);
    formData.append('benefits_subtitle', document.getElementById('benefits_subtitle').value);
    for (let i = 1; i <= 4; i++) {
        formData.append(`benefit_${i}_number`, document.getElementById(`benefit_${i}_number`).value);
        formData.append(`benefit_${i}_title`, document.getElementById(`benefit_${i}_title`).value);
        formData.append(`benefit_${i}_description`, document.getElementById(`benefit_${i}_description`).value);
        formData.append(`benefit_${i}_image`, document.getElementById(`benefit_${i}_image`).value);
    }
    
    // ISO Section
    formData.append('iso_title', document.getElementById('iso_title').value);
    formData.append('iso_subtitle', document.getElementById('iso_subtitle').value);
    formData.append('iso_description', document.getElementById('iso_description').value);
    formData.append('iso_button', document.getElementById('iso_button').value);
    formData.append('iso_image', document.getElementById('iso_image').value);
    
    // Project Submission
    formData.append('project_submission_title', document.getElementById('project_submission_title').value);
    formData.append('project_submission_description', document.getElementById('project_submission_description').value);
    formData.append('project_submission_button', document.getElementById('project_submission_button').value);
    
    // Add timestamp
    formData.append('timestamp', new Date().getTime());
    
    // Send to server
    fetch('<?= base_url("cms/save_smuc_page"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message || 'Changes saved successfully!', 'success');
            
            // Clear file inputs after successful save
            fileUploads.forEach(({ inputId }) => {
                const input = document.getElementById(inputId);
                if (input) input.value = '';
            });
            
            // Clear gallery file inputs
            document.querySelectorAll('.gallery-image-upload').forEach(input => {
                input.value = '';
            });
            
            // Remove change markers from features
            document.querySelectorAll('.feature-changed, .feature-new').forEach(feature => {
                feature.classList.remove('feature-changed', 'feature-new');
            });
            
            // Remove features marked for deletion
            document.querySelectorAll('.feature-to-delete').forEach(feature => {
                feature.remove();
            });
            
            // Reload page after successful save to get updated IDs
            setTimeout(() => {
                window.location.reload();
            }, 1500);
            
        } else {
            showNotification(data.message || 'Error saving changes', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button state
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// Show notification function
function showNotification(message, type = 'info') {
    // Remove existing notification
    const existingNotification = document.querySelector('.notification-toast');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-lg border transform transition-all duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
        type === 'warning' ? 'bg-yellow-50 border-yellow-200 text-yellow-800' :
        'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : type === 'error' ? '✗' : type === 'warning' ? '⚠' : 'ℹ'}</span>
            <span>${message}</span>
            <button class="ml-4 text-slate-400 hover:text-slate-600" onclick="this.parentElement.parentElement.remove()">
                ×
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Initialize image upload handlers
document.addEventListener('DOMContentLoaded', function() {
    // Hero image
    handleImageUpload('heroImageUpload', 'heroImagePreview', 'hero_image');
    handleImageUpload('bgheroImageUpload', 'bgheroImagePreview', 'bg_hero_image');
    
    // Illustration images
    handleImageUpload('illustration_top_moldUpload', 'illustration_top_moldPreview', 'illustration_top_mold');
    handleImageUpload('illustration_internal_partUpload', 'illustration_internal_partPreview', 'illustration_internal_part');
    handleImageUpload('illustration_bottom_moldUpload', 'illustration_bottom_moldPreview', 'illustration_bottom_mold');
    
    // Process step images
    for (let i = 1; i <= 4; i++) {
        handleImageUpload(`process_step_${i}_image_upload`, `process_step_${i}_image_preview`, `process_step_${i}_image`);
    }
    
    // Benefit images
    for (let i = 1; i <= 4; i++) {
        handleImageUpload(`benefit_${i}_image_upload`, `benefit_${i}_image_preview`, `benefit_${i}_image`);
    }
    
    // ISO image
    handleImageUpload('isoImageUpload', 'isoImagePreview', 'iso_image');
    
    // WCU video
    document.getElementById('wcuVideoUpload').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            document.getElementById('wcu_video').value = file.name;
            showNotification(`Ready to upload video: ${file.name}`, 'info');
        }
    });
    
    // Auto-resize all textareas
    document.querySelectorAll('textarea').forEach(textarea => {
        autoResize(textarea);
        textarea.addEventListener('input', function() {
            autoResize(this);
        });
    });
    
    // Save all changes button
    document.getElementById('saveAllChanges').addEventListener('click', function() {
        saveAllChanges();
    });
    
    // Add keyboard shortcut (Ctrl + S)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            saveAllChanges();
        }
    });
});

// Quote request functions
function filterByStatus(status) {
    const searchTerm = document.getElementById('searchInput').value;
    window.location.href = '<?= base_url("cms/quote_requests") ?>?status=' + status + '&search=' + encodeURIComponent(searchTerm);
}

function handleSearch(event) {
    if (event.key === 'Enter') {
        const status = document.getElementById('statusFilter').value;
        const searchTerm = event.target.value;
        window.location.href = '<?= base_url("cms/quote_requests") ?>?status=' + status + '&search=' + encodeURIComponent(searchTerm);
    }
}

function viewRequest(id) {
    Swal.fire({
        title: 'Loading...',
        text: 'Please wait',
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    // Fetch request details
    fetch('<?= base_url() ?>cms/get_quote_request_details', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        Swal.close();
        if (data.success) {
            const request = data.request;
            const content = `
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Customer Information</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-slate-500">Name</label>
                                <p class="text-slate-900">${request.name}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500">Email</label>
                                <p class="text-slate-900"><a href="mailto:${request.email}" class="text-indigo-600 hover:text-indigo-800">${request.email}</a></p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500">Company</label>
                                <p class="text-slate-900">${request.company_name}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-slate-500">Contact Number</label>
                                <p class="text-slate-900"><a href="tel:${request.contact_number}" class="hover:text-indigo-600">${request.contact_number}</a></p>
                            </div>
                        </div>
                    </div>

                    <!-- File Attachment -->
                    ${request.file_name ? `
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Attached File</h3>
                        <a href="<?= base_url('cms/download_quote_file/') ?>/${request.id}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Download ${request.file_name}
                        </a>
                    </div>
                    ` : '<p class="text-slate-500">No file attached</p>'}

                    <!-- Notes -->
                    <div>
                        <h3 class="text-lg font-semibold text-slate-900 mb-4">Internal Notes</h3>
                        <textarea id="requestNotes" rows="4" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Add internal notes about this request...">${request.notes || ''}</textarea>
                        <button onclick="saveNotes(${request.id})" class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                            Save Notes
                        </button>
                    </div>

                    <!-- Request Date -->
                    <div>
                        <label class="text-sm font-medium text-slate-500">Submitted On</label>
                        <p class="text-slate-900">${new Date(request.created_at).toLocaleString()}</p>
                    </div>
                </div>
            `;
            
            document.getElementById('modalContent').innerHTML = content;

            // Auto-update status to 'reviewed' if currently 'new', then show modal
            if (!request.status || request.status === 'new') {
                fetch('<?= base_url() ?>cms/update_quote_status', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id=' + request.id + '&status=reviewed'
                })
                .then(res => res.json())
                .then(statusData => {
                    if (statusData.success) {
                        // Update badge in table
                        const row = document.getElementById('request-' + request.id);
                        if (row) {
                            const badge = row.querySelector('.status-badge');
                            if (badge) {
                                badge.classList.remove('status-new', 'status-pending', 'status-reviewed', 'status-contacted', 'status-completed');
                                badge.classList.add('status-reviewed');
                                badge.textContent = 'Reviewed';
                            }
                        }
                    }
                    document.getElementById('viewModal').classList.add('active');
                })
                .catch(() => {
                    document.getElementById('viewModal').classList.add('active');
                });
            } else {
                document.getElementById('viewModal').classList.add('active');
            }
        } else {
            alert('Failed to load request details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while loading request details');
    });
}

function updateStatus(id, status) {
    fetch('<?= base_url() ?>cms/update_quote_status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&status=' + status
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Status updated successfully', 'success');
            // Update the status badge in the table
            const row = document.getElementById('request-' + id);
            if (row) {
                const badge = row.querySelector('.status-badge');
                if (badge) {
                    // Remove all status classes
                    badge.classList.remove('status-new', 'status-pending', 'status-reviewed', 'status-contacted', 'status-completed');
                    // Add new status class
                    badge.classList.add('status-' + status);
                    badge.textContent = status.charAt(0).toUpperCase() + status.slice(1);
                }
            }
            location.reload();
        } else {
            showNotification('Failed to update status', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function saveNotes(id) {
    const notes = document.getElementById('requestNotes').value;
    
    fetch('<?= base_url() ?>cms/update_quote_notes', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id + '&notes=' + encodeURIComponent(notes)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Notes saved successfully', 'success');
        } else {
            showNotification('Failed to save notes', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function deleteRequest(id) {
    if (!confirm('Are you sure you want to delete this quote request? This action cannot be undone.')) {
        return;
    }
    
    fetch('<?= base_url() ?>cms/delete_quote_request', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Request deleted successfully', 'success');
            // Remove the row from the table
            const row = document.getElementById('request-' + id);
            if (row) {
                row.remove();
            }
            // Reload page if table is now empty
            setTimeout(() => {
                const tbody = document.querySelector('tbody');
                if (tbody && tbody.querySelectorAll('tr').length === 0) {
                    location.reload();
                }
            }, 1000);
        } else {
            showNotification('Failed to delete request', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred', 'error');
    });
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('active');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
});
</script>

</body>
</html>