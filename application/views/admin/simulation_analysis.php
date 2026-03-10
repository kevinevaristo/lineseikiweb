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

/* Notification toast */
.notification-toast {
    animation: slideIn 0.3s ease-out;
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

/* Drag and drop styles */
.capability-card {
    transition: transform 0.2s ease, opacity 0.2s ease;
}

.capability-card:hover {
    transform: translateY(-2px);
}

.capability-card.dragging {
    opacity: 0.5;
    cursor: move;
}

.drag-handle {
    cursor: move;
    opacity: 0.5;
    transition: opacity 0.2s;
}

.drag-handle:hover {
    opacity: 1;
}

/* Upload progress modal */
.upload-progress {
    transition: opacity 0.3s ease;
}

.upload-progress.hidden {
    opacity: 0;
    pointer-events: none;
}
</style>
<main class="ml-64 p-8">
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-800">Simulation Analysis Editor</h1>
                    <p class="text-slate-600 mt-1">Modify simulation capabilities, case studies, and webinar content.</p>
                </div>
                <div class="flex gap-3">
                    <button id="saveAllChanges" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
                        <svg id="saveIcon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        <span>Save All Changes</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Scroll Progress Bar -->
        <div class="scroll-progress"></div>
    </div>

        <div class="space-y-8">
            
            <!-- Hero & Introduction Section -->
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                    <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🚀</span> Hero & Introduction</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Main Heading</label>
                            <input type="text" id="hero_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['hero_title']['content']) ? htmlspecialchars($content['hero_title']['content']) : 'Validate. Optimize. Innovate.' ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Image</label>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                    <img id="heroImagePreview" src="<?= base_url('assets_system/images/' . (isset($content['hero_image']['image']) ? $content['hero_image']['image'] : 'simul1bg.png')); ?>" alt="Hero Preview" class="max-w-full max-h-full object-cover rounded">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?= isset($content['hero_image']['image']) ? $content['hero_image']['image'] : 'simul1bg.png'; ?></span>
                                    </div>
                                    <input type="file" id="heroImageUpload" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('heroImageUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New Image
                                    </button>
                                    <input type="hidden" id="hero_image" value="<?= isset($content['hero_image']['image']) ? $content['hero_image']['image'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Background Image</label>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                    <img id="bgheroImagePreview" src="<?= base_url('assets_system/images/' . (isset($content['hero_bg_img']['image']) ? $content['hero_bg_img']['image'] : 'simul1bg.png')); ?>" alt="Hero Preview" class="max-w-full max-h-full object-cover rounded">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?= isset($content['hero_bg_img']['image']) ? $content['hero_bg_img']['image'] : 'newb.jpg'; ?></span>
                                    </div>
                                    <input type="file" id="bgheroImageUpload" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('bgheroImageUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New Image
                                    </button>
                                    <input type="hidden" id="hero_bg_img" value="<?= isset($content['hero_bg_img']['image']) ? $content['hero_bg_img']['image'] : ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Hero Description</label>
                        <textarea id="hero_description" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?= isset($content['hero_description']['content']) ? htmlspecialchars($content['hero_description']['content']) : '' ?></textarea>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">"What We Do" Description</label>
                        <textarea id="what_we_do_text" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="6"><?= isset($content['what_we_do_text']['content']) ? htmlspecialchars($content['what_we_do_text']['content']) : '' ?></textarea>
                    </div>
                </div>
            </section>

<!-- Technical Capabilities Section -->
<section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-bold text-slate-800 flex items-center">
            <span class="mr-2">🛠️</span> Technical Capabilities
        </h3>
        <button 
            onclick="addNewCapability()" 
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors flex items-center"
        >
            <span class="mr-2">+</span> Add Capability
        </button>
    </div>
    <div class="p-6">
        <div id="capabilities-container" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php 
            $color_classes = [
                'blue' => ['border' => 'border-blue-100', 'bg' => 'bg-blue-50/30', 'hover' => 'hover:bg-blue-50', 'text' => 'text-blue-600', 'ring' => 'focus:ring-blue-500', 'input_border' => 'border-blue-100'],
                'green' => ['border' => 'border-green-100', 'bg' => 'bg-green-50/30', 'hover' => 'hover:bg-green-50', 'text' => 'text-green-600', 'ring' => 'focus:ring-green-500', 'input_border' => 'border-green-100'],
                'purple' => ['border' => 'border-purple-100', 'bg' => 'bg-purple-50/30', 'hover' => 'hover:bg-purple-50', 'text' => 'text-purple-600', 'ring' => 'focus:ring-purple-500', 'input_border' => 'border-purple-100'],
                'orange' => ['border' => 'border-orange-100', 'bg' => 'bg-orange-50/30', 'hover' => 'hover:bg-orange-50', 'text' => 'text-orange-600', 'ring' => 'focus:ring-orange-500', 'input_border' => 'border-orange-100'],
                'red' => ['border' => 'border-red-100', 'bg' => 'bg-red-50/30', 'hover' => 'hover:bg-red-50', 'text' => 'text-red-600', 'ring' => 'focus:ring-red-500', 'input_border' => 'border-red-100']
            ];
            
            foreach ($capabilities as $capability): 
                $color = $color_classes[$capability->color_scheme ?? 'blue'];
            ?>
            <div 
                class="p-4 border rounded-xl <?= $color['border'] ?> <?= $color['bg'] ?> <?= $color['hover'] ?> transition-colors capability-card"
                data-capability-id="<?= $capability->id ?>"
            >
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <label class="text-xs font-bold text-slate-400 uppercase">Capability Title</label>
                        <textarea 
                            class="font-bold <?= $color['text'] ?> border-none bg-transparent w-full text-lg resize-none capability-title"
                            rows="2"
                            onchange="saveCapability(<?= $capability->id ?>, this)"
                            data-field="capability_name"
                        ><?= htmlspecialchars($capability->capability_name) ?></textarea>
                    </div>
                    <div class="ml-4 flex space-x-2">
                        <select 
                            class="text-xs border rounded p-1 color-selector"
                            onchange="saveCapabilityColor(<?= $capability->id ?>, this)"
                            data-field="color_scheme"
                        >
                            <option value="blue" <?= ($capability->color_scheme == 'blue') ? 'selected' : '' ?>>Blue</option>
                            <option value="green" <?= ($capability->color_scheme == 'green') ? 'selected' : '' ?>>Green</option>
                            <option value="purple" <?= ($capability->color_scheme == 'purple') ? 'selected' : '' ?>>Purple</option>
                            <option value="orange" <?= ($capability->color_scheme == 'orange') ? 'selected' : '' ?>>Orange</option>
                            <option value="red" <?= ($capability->color_scheme == 'red') ? 'selected' : '' ?>>Red</option>
                        </select>
                        <button 
                            onclick="deleteCapability(<?= $capability->id ?>)" 
                            class="text-red-500 hover:text-red-700"
                            title="Delete Capability"
                        >
                            🗑️
                        </button>
                    </div>
                </div>
                
                <div class="space-y-3 items-container">
                    <div class="flex justify-between items-center">
                        <label class="text-xs font-bold text-slate-400 uppercase">Items</label>
                        <button 
                            onclick="addNewItem(<?= $capability->id ?>)" 
                            class="text-xs text-blue-500 hover:text-blue-700"
                        >
                            + Add Item
                        </button>
                    </div>
                    
                    <?php foreach ($capability->items as $index => $item): ?>
                    <div class="flex items-center space-x-2 item-row" data-item-id="<?= $item->id ?>">
                        <input 
                            type="text" 
                            class="w-full text-sm p-2 border <?= $color['input_border'] ?> rounded-lg focus:ring-1 <?= $color['ring'] ?> item-input"
                            value="<?= htmlspecialchars($item->item_name) ?>"
                            onchange="saveCapabilityItem(<?= $item->id ?>, <?= $capability->id ?>, this)"
                        >
                        <button 
                            onclick="deleteItem(<?= $item->id ?>)" 
                            class="text-red-400 hover:text-red-600"
                            title="Delete Item"
                        >
                            ×
                        </button>
                    </div>
                    <?php endforeach; ?>
                    
                    <!-- Template for new items -->
                    <div id="new-item-template-<?= $capability->id ?>" style="display: none;">
                        <div class="flex items-center space-x-2 item-row" data-item-id="new">
                            <input 
                                type="text" 
                                class="w-full text-sm p-2 border <?= $color['input_border'] ?> rounded-lg focus:ring-1 <?= $color['ring'] ?> item-input"
                                placeholder="New item..."
                                onchange="saveNewItem(<?= $capability->id ?>, this)"
                            >
                            <button 
                                onclick="removeNewItem(this)" 
                                class="text-red-400 hover:text-red-600"
                            >
                                ×
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Add new capability modal (simplified inline version) -->
<div id="new-capability-modal" style="display: none;" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 w-96">
        <h3 class="font-bold text-lg mb-4">Add New Capability</h3>
        <input type="text" id="new-capability-name" placeholder="Capability Name" class="w-full p-2 border rounded-lg mb-4">
        <select id="new-capability-color" class="w-full p-2 border rounded-lg mb-4">
            <option value="blue">Blue</option>
            <option value="green">Green</option>
            <option value="purple">Purple</option>
            <option value="orange">Orange</option>
            <option value="red">Red</option>
        </select>
        <div class="flex justify-end space-x-2">
            <button onclick="closeNewCapabilityModal()" class="px-4 py-2 border rounded-lg">Cancel</button>
            <button onclick="saveNewCapability()" class="px-4 py-2 bg-blue-500 text-white rounded-lg">Save</button>
        </div>
    </div>
</div>

            <!-- Benefits Section -->
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                    <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">💰</span> Benefits & Advantages</h3>
                    <div class="ml-auto">
                        <button type="button" id="save-all-benefits" 
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                            Save All Benefits
                        </button>
                        <button type="button" id="add-new-benefit" 
                                class="ml-2 bg-green-500 hover:bg-green-600 text-white text-sm font-medium py-2 px-4 rounded-lg transition-colors">
                            + Add Benefit
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Messages -->
                    <div id="benefits-message" class="mb-4 hidden"></div>
                    
                    <!-- Benefits Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="benefits-container">
                        <?php 
                        // Fetch benefits from database
                        $this->load->model('simulation_model');
                        $benefits = $this->simulation_model->get_all_benefits();
                        $colors = [
                            ['border' => 'border-orange-100', 'bg' => 'bg-orange-50/30', 'hover' => 'hover:bg-orange-50', 'text' => 'text-orange-600', 'focus' => 'focus:ring-orange-500'],
                            ['border' => 'border-teal-100', 'bg' => 'bg-teal-50/30', 'hover' => 'hover:bg-teal-50', 'text' => 'text-teal-600', 'focus' => 'focus:ring-teal-500'],
                            ['border' => 'border-rose-100', 'bg' => 'bg-rose-50/30', 'hover' => 'hover:bg-rose-50', 'text' => 'text-rose-600', 'focus' => 'focus:ring-rose-500']
                        ];
                        
                        // Define path for icons
                        $iconPath = 'assets_system/images/';
                        $fullIconPath = FCPATH . $iconPath;
                        
                        if (!empty($benefits)): 
                            $counter = 0;
                            foreach ($benefits as $benefit): 
                                $color = $colors[$counter % count($colors)];
                                $counter++;
                                
                                // Check if icon exists
                                $iconFile = $benefit['icon'];
                                $hasIcon = false;
                                $iconUrl = '';
                                
                                if (!empty($iconFile)) {
                                    $iconFullPath = $fullIconPath . $iconFile;
                                    if (file_exists($iconFullPath)) {
                                        $hasIcon = true;
                                        $iconUrl = base_url($iconPath . $iconFile);
                                    }
                                }
                        ?>
                                <!-- Benefit Card -->
                                <div class="p-4 border rounded-xl <?= $color['border'] ?> <?= $color['bg'] ?> <?= $color['hover'] ?> transition-colors benefit-card" data-id="<?= $benefit['id'] ?>">
                                    <div class="mb-4">
                                        <label class="text-xs font-bold text-slate-400 uppercase">Benefit <?= $counter ?> Title</label>
                                        <input type="text" 
                                               name="benefits[<?= $benefit['id'] ?>][title]" 
                                               class="font-bold <?= $color['text'] ?> border border-transparent bg-transparent w-full text-lg focus:border-<?= str_replace('text-', '', $color['text']) ?>-300 focus:ring-1 <?= $color['focus'] ?> p-1 rounded benefit-title" 
                                               value="<?= html_escape($benefit['title']) ?>">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                        <textarea name="benefits[<?= $benefit['id'] ?>][description]" 
                                                  class="w-full text-sm p-2 border <?= $color['border'] ?> rounded-lg focus:ring-1 <?= $color['focus'] ?> resize-none benefit-description" 
                                                  rows="3"><?= html_escape($benefit['description']) ?></textarea>
                                    </div>
                                    
                                    <!-- Icon Upload Section -->
                                    <div class="mt-3">
                                        <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Icon</label>
                                        
                                        <!-- Icon Preview -->
                                        <div class="mb-2 icon-preview-container" id="icon-preview-<?= $benefit['id'] ?>">
                                            <?php if ($hasIcon): ?>
                                                <div class="flex items-center space-x-3 mb-2">
                                                    <img src="<?= $iconUrl ?>" 
                                                         alt="Benefit Icon" 
                                                         class="w-12 h-12 object-cover rounded-lg border border-slate-200">
                                                    <div>
                                                        <div class="text-sm text-slate-600">Current icon</div>
                                                        <div class="text-xs text-slate-500 truncate max-w-[100px]"><?= $iconFile ?></div>
                                                    </div>
                                                    <button type="button" 
                                                            class="remove-icon-btn text-xs bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded transition-colors"
                                                            data-id="<?= $benefit['id'] ?>"
                                                            data-filename="<?= $iconFile ?>">
                                                        Remove
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-sm text-slate-500 mb-2 italic">No icon uploaded</div>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Upload Controls -->
                                        <div class="flex items-center space-x-2">
                                            <label class="cursor-pointer">
                                                <input type="file" 
                                                       name="icon_file_<?= $benefit['id'] ?>" 
                                                       class="icon-file-input hidden" 
                                                       data-id="<?= $benefit['id'] ?>"
                                                       accept="image/*,.svg">
                                                <span class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium py-2 px-3 rounded-lg transition-colors inline-block">
                                                    <?= $hasIcon ? 'Change Icon' : 'Upload Icon' ?>
                                                </span>
                                            </label>
                                            <span class="text-xs text-slate-500">PNG, JPG, SVG up to 2MB</span>
                                        </div>
                                        
                                        <!-- Hidden field for icon filename -->
                                        <input type="hidden" 
                                               name="benefits[<?= $benefit['id'] ?>][icon]" 
                                               id="icon-input-<?= $benefit['id'] ?>"
                                               class="icon-filename-input" 
                                               value="<?= $hasIcon ? html_escape($iconFile) : '' ?>">
                                    </div>
                                    
                                    <!-- Hidden fields -->
                                    <input type="hidden" name="benefits[<?= $benefit['id'] ?>][id]" value="<?= $benefit['id'] ?>">
                                    
                                    <!-- Actions -->
                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="text-xs text-slate-500">
                                            ID: <?= $benefit['id'] ?>
                                        </div>
                                        <button type="button" 
                                                class="delete-benefit text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition-colors"
                                                data-id="<?= $benefit['id'] ?>">
                                            Delete Benefit
                                        </button>
                                    </div>
                                </div>
                        <?php 
                            endforeach; 
                        else: 
                            // No benefits - show empty state
                            for ($i = 0; $i < 3; $i++): 
                                $color = $colors[$i];
                        ?>
                                <div class="p-4 border rounded-xl <?= $color['border'] ?> <?= $color['bg'] ?> <?= $color['hover'] ?> transition-colors benefit-card" data-index="new_<?= $i ?>">
                                    <div class="mb-4">
                                        <label class="text-xs font-bold text-slate-400 uppercase">Benefit <?= $i + 1 ?> Title</label>
                                        <input type="text" 
                                               name="benefits[new_<?= $i ?>][title]" 
                                               class="font-bold <?= $color['text'] ?> border border-transparent bg-transparent w-full text-lg focus:border-<?= str_replace('text-', '', $color['text']) ?>-300 focus:ring-1 <?= $color['focus'] ?> p-1 rounded benefit-title" 
                                               placeholder="Enter benefit title">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                        <textarea name="benefits[new_<?= $i ?>][description]" 
                                                  class="w-full text-sm p-2 border <?= $color['border'] ?> rounded-lg focus:ring-1 <?= $color['focus'] ?> resize-none benefit-description" 
                                                  rows="3"
                                                  placeholder="Enter benefit description"></textarea>
                                    </div>
                                    <div class="mt-3">
                                        <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Icon (Optional)</label>
                                        
                                        <!-- Icon Preview for new benefits -->
                                        <div class="mb-2 icon-preview-container" id="icon-preview-new_<?= $i ?>">
                                            <div class="text-sm text-slate-500 mb-2 italic">No icon uploaded</div>
                                        </div>
                                        
                                        <!-- Upload for new benefits -->
                                        <div class="flex items-center space-x-2">
                                            <label class="cursor-pointer">
                                                <input type="file" 
                                                       name="icon_file_new_<?= $i ?>" 
                                                       class="icon-file-input hidden" 
                                                       data-index="new_<?= $i ?>"
                                                       accept="image/*,.svg">
                                                <span class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium py-2 px-3 rounded-lg transition-colors inline-block">
                                                    Upload Icon
                                                </span>
                                            </label>
                                            <span class="text-xs text-slate-500">PNG, JPG, SVG</span>
                                        </div>
                                        
                                        <!-- Hidden field for icon filename -->
                                        <input type="hidden" 
                                               name="benefits[new_<?= $i ?>][icon]" 
                                               id="icon-input-new_<?= $i ?>"
                                               class="icon-filename-input" 
                                               value="">
                                    </div>
                                </div>
                        <?php endfor; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
            
            <!-- Upload Progress Modal -->
            <div id="upload-progress" class="upload-progress fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-sm w-full mx-4">
        <div class="text-center">
            <div class="mb-4">
                <div class="w-16 h-16 border-4 border-blue-500 border-t-transparent rounded-full animate-spin mx-auto"></div>
            </div>
            <h3 class="text-lg font-semibold text-slate-800 mb-2">Uploading Icon</h3>
            <p class="text-sm text-slate-600">Please wait...</p>
        </div>
    </div>
</div>

            <!-- Reduced Cost Visuals Section -->
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                    <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🎬</span> Reduced Cost Visuals</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 block">Animation GIF for Reduced Cost Section</label>
                            <div class="flex items-center gap-6">
                                <div class="w-64 h-36 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                    <img id="reducedCostGifPreview" src="<?= base_url('assets_system/images/' . (isset($content['reduced_cost_gif']['image']) ? $content['reduced_cost_gif']['image'] : 'newsimgif.gif')); ?>" alt="Reduced Cost GIF Preview" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current GIF: </span>
                                        <span class="text-sm text-slate-500"><?= isset($content['reduced_cost_gif']['image']) ? $content['reduced_cost_gif']['image'] : 'newsimgif.gif'; ?></span>
                                    </div>
                                    <input type="file" id="reducedCostGifUpload" class="hidden" accept=".gif,image/gif">
                                    <button type="button" onclick="document.getElementById('reducedCostGifUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New GIF
                                    </button>
                                    <p class="text-xs text-slate-400 mt-2">Supports .gif format only</p>
                                    <input type="hidden" id="reduced_cost_gif" value="<?= isset($content['reduced_cost_gif']['image']) ? $content['reduced_cost_gif']['image'] : ''; ?>">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Reduced Cost Image 1 -->
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Reduced Cost Image 1</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                        <img id="reducedCostImage1Preview" src="<?= base_url('assets_system/images/' . (isset($content['reduced_cost_image_1']['image']) ? $content['reduced_cost_image_1']['image'] : 'newsim1.png')); ?>" alt="Image 1 Preview" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-2">
                                            <span class="text-sm font-medium text-slate-700">Current: </span>
                                            <span class="text-sm text-slate-500"><?= isset($content['reduced_cost_image_1']['image']) ? $content['reduced_cost_image_1']['image'] : 'newsim1.png'; ?></span>
                                        </div>
                                        <input type="file" id="reducedCostImage1Upload" class="hidden" accept="image/*">
                                        <button type="button" onclick="document.getElementById('reducedCostImage1Upload').click()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                                            Change Image
                                        </button>
                                        <input type="hidden" id="reduced_cost_image_1" value="<?= isset($content['reduced_cost_image_1']['image']) ? $content['reduced_cost_image_1']['image'] : ''; ?>">
                                    </div>
                                </div>
                            </div>

                            <!-- Reduced Cost Image 2 -->
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Reduced Cost Image 2</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                        <img id="reducedCostImage2Preview" src="<?= base_url('assets_system/images/' . (isset($content['reduced_cost_image_2']['image']) ? $content['reduced_cost_image_2']['image'] : 'newsim2.png')); ?>" alt="Image 2 Preview" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-2">
                                            <span class="text-sm font-medium text-slate-700">Current: </span>
                                            <span class="text-sm text-slate-500"><?= isset($content['reduced_cost_image_2']['image']) ? $content['reduced_cost_image_2']['image'] : 'newsim2.png'; ?></span>
                                        </div>
                                        <input type="file" id="reducedCostImage2Upload" class="hidden" accept="image/*">
                                        <button type="button" onclick="document.getElementById('reducedCostImage2Upload').click()" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200 transition-colors">
                                            Change Image
                                        </button>
                                        <input type="hidden" id="reduced_cost_image_2" value="<?= isset($content['reduced_cost_image_2']['image']) ? $content['reduced_cost_image_2']['image'] : ''; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Carousel Section -->
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                    <h3 class="font-bold text-slate-800 flex items-center">
                        <span class="mr-2">🎥</span> Simulation in Action (Carousel)
                    </h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Section Title and Description -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Title</label>
                            <input type="text" id="simulation_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['simulation_title']['content']) ? htmlspecialchars($content['simulation_title']['content']) : 'Simulation in Action' ?>">
                            <p class="text-xs text-slate-400 mt-1">Title for the carousel section</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Description</label>
                            <textarea id="simulation_description" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?= isset($content['simulation_description']['content']) ? htmlspecialchars($content['simulation_description']['content']) : '' ?></textarea>
                        </div>
                    </div>
                    
                    <!-- Button Text -->
                    <div>
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Button Text</label>
                        <input type="text" id="simulation_button" class="w-full md:w-1/2 mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['simulation_button']['content']) ? htmlspecialchars($content['simulation_button']['content']) : 'Talk to Experts' ?>">
                    </div>
                    
                    <!-- Carousel Items -->
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Carousel Items</label>
                            <div class="flex gap-2">
                                <button onclick="window.location.href='/cms/add_main_content'" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                                    <span class="mr-2">+</span> Add Item
                                </button>
                                <button onclick="saveCarousel()" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Save Carousel
                                </button>
                            </div>
                        </div>
                        
                        <!-- Sortable Carousel Container -->
                        <div id="carousel-items-container" class="space-y-4 sortable-container">
                            <?php 
                            // Use the new carousel items from separate table
                            $carousel_counter = 1;
                            foreach ($carousel_items as $item): 
                            ?>
                            <div class="border border-slate-200 rounded-xl p-6 hover:bg-slate-50/50 transition-colors carousel-item" data-db-id="<?= $item->id ?>">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="cursor-move text-slate-400 hover:text-slate-600 drag-handle">
                                            ☰
                                        </div>
                                        <h4 class="font-bold text-slate-700">Carousel Item <?= $carousel_counter ?></h4>
                                    </div>
                                    <div class="flex gap-2">
                                        <button onclick="deleteCarouselItem(this, <?= $item->id ?>)" class="px-3 py-1 bg-red-100 text-red-600 text-sm rounded hover:bg-red-200 transition-colors">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Title and Description -->
                                    <div class="lg:col-span-2 space-y-4">
                                        <div>
                                            <label class="text-xs font-bold text-slate-400 uppercase">Title</label>
                                            <input type="text" 
                                                   class="carousel-title w-full mt-1 p-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                                                   value="<?= htmlspecialchars($item->title) ?>" 
                                                   placeholder="Enter carousel item title">
                                        </div>
                                        <div>
                                            <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                            <textarea class="carousel-description w-full mt-1 p-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                                                      rows="4" 
                                                      placeholder="Enter carousel item description"><?= htmlspecialchars($item->abstract) ?></textarea>
                                        </div>
                                        <div style="display: none">
                                            <label class="text-xs font-bold text-slate-400 uppercase">Link URL</label>
                                            <input type="text" 
                                                   class="carousel-link w-full mt-1 p-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                                                   value="<?= htmlspecialchars($item->title) ?>" 
                                                   placeholder="e.g., index/ps_contents">
                                        </div>
                                        <div>
                                             <button onclick="window.location.href='/cms/edit_main_content/<?php echo $item->id; ?>'" class="px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors flex items-center">
                                                 Edit Main Content
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <!-- Image Upload -->
                                    <div>
                                        <label class="text-xs font-bold text-slate-400 uppercase">Image</label>
                                        <div class="mt-1">
                                            <div class="w-full h-48 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden mb-3">
                                                <img class="carousel-image-preview w-full h-full object-cover" 
                                                     src="<?= base_url('assets_system/images/' . $item->main_image) ?>" 
                                                     alt="Carousel Image"
                                                     onerror="this.src='<?= base_url('assets_system/images/placeholder.png') ?>'">
                                            </div>
                                            <div class="text-xs text-slate-500 mb-2 truncate">
                                                Current: <?= $item->main_image ?>
                                            </div>
                                            <input type="file" class="carousel-image-upload hidden" accept="image/*">
                                            <input type="hidden" class="carousel-image" value="<?= $item->main_image ?>">
                                            <button type="button" onclick="uploadCarouselImage(this)" class="w-full py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-200 transition-colors">
                                                Change Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $carousel_counter++;
                            endforeach; 
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Process & Requirements Section -->
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                    <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">📋</span> Process & Requirements</h3>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Section Title</label>
                        <input type="text" id="process_title" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?= isset($content['process_title']['content']) ? htmlspecialchars($content['process_title']['content']) : 'Process & Requirements' ?>">
                    </div>
                    <div class="mb-6">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description</label>
                        <textarea id="process_description" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="2"><?= isset($content['process_description']['content']) ? htmlspecialchars($content['process_description']['content']) : '' ?></textarea>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Step 1 -->
                        <div class="p-4 border rounded-xl border-slate-100 bg-slate-50/50 hover:bg-white transition-colors">
                            <div class="mb-3">
                                <label class="text-xs font-bold text-slate-400 uppercase">Step 1 Title</label>
                                <input type="text" id="process_step_1_title" class="font-bold text-slate-700 border-none bg-transparent w-full" value="<?= isset($content['process_step_1_title']['content']) ? htmlspecialchars($content['process_step_1_title']['content']) : 'Model Development' ?>">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                <textarea id="process_step_1_description" class="w-full text-sm p-2 border border-slate-100 rounded-lg focus:ring-1 focus:ring-slate-500 resize-none" rows="3"><?= isset($content['process_step_1_description']['content']) ? htmlspecialchars($content['process_step_1_description']['content']) : '' ?></textarea>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="p-4 border rounded-xl border-slate-100 bg-slate-50/50 hover:bg-white transition-colors">
                            <div class="mb-3">
                                <label class="text-xs font-bold text-slate-400 uppercase">Step 2 Title</label>
                                <input type="text" id="process_step_2_title" class="font-bold text-slate-700 border-none bg-transparent w-full" value="<?= isset($content['process_step_2_title']['content']) ? htmlspecialchars($content['process_step_2_title']['content']) : 'Solving (Simulation)' ?>">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                <textarea id="process_step_2_description" class="w-full text-sm p-2 border border-slate-100 rounded-lg focus:ring-1 focus:ring-slate-500 resize-none" rows="3"><?= isset($content['process_step_2_description']['content']) ? htmlspecialchars($content['process_step_2_description']['content']) : '' ?></textarea>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="p-4 border rounded-xl border-slate-100 bg-slate-50/50 hover:bg-white transition-colors">
                            <div class="mb-3">
                                <label class="text-xs font-bold text-slate-400 uppercase">Step 3 Title</label>
                                <input type="text" id="process_step_3_title" class="font-bold text-slate-700 border-none bg-transparent w-full" value="<?= isset($content['process_step_3_title']['content']) ? htmlspecialchars($content['process_step_3_title']['content']) : 'Results' ?>">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                                <textarea id="process_step_3_description" class="w-full text-sm p-2 border border-slate-100 rounded-lg focus:ring-1 focus:ring-slate-500 resize-none" rows="3"><?= isset($content['process_step_3_description']['content']) ? htmlspecialchars($content['process_step_3_description']['content']) : '' ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Webinar Series Section -->
            <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">📺</span> Webinar Series Update</h3>
                </div>
                <div class="p-6 flex flex-col md:flex-row gap-8">
                    <div class="flex-1 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Main Title</label>
                            <input 
                                type="text" 
                                id="webinar_title" 
                                class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" 
                                value="<?= isset($content['webinar_title']['content']) ? htmlspecialchars($content['webinar_title']['content']) : 'Webinar<br>Series' ?>"
                            >
                            <p class="text-xs text-slate-400 mt-1">Use <code>&lt;br&gt;</code> to create line breaks</p>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description Line 1</label>
                            <textarea id="webinar_description_1" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?= isset($content['webinar_description_1']['content']) ? htmlspecialchars($content['webinar_description_1']['content']) : '' ?></textarea>
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Description Line 2</label>
                            <textarea id="webinar_description_2" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?= isset($content['webinar_description_2']['content']) ? htmlspecialchars($content['webinar_description_2']['content']) : '' ?></textarea>
                        </div>
                    </div>
                    <div class="w-full md:w-64">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Webinar Promo Image</label>
                        <div class="aspect-video bg-slate-100 rounded-xl flex items-center justify-center border-2 border-dashed border-slate-200 overflow-hidden">
                            <img id="webinarImagePreview" src="<?= base_url('assets_system/images/' . (isset($content['webinar_image']['image']) ? $content['webinar_image']['image'] : 'newsim4.png')) ?>" alt="Webinar Preview" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-2">
                            <div class="text-xs text-slate-500 mb-2 truncate">
                                <?= isset($content['webinar_image']['image']) ? $content['webinar_image']['image'] : 'newsim4.png' ?>
                            </div>
                            <input type="file" id="webinarImageUpload" class="hidden" accept="image/*">
                            <input type="hidden" id="webinar_image" value="<?= isset($content['webinar_image']['image']) ? $content['webinar_image']['image'] : '' ?>">
                            <button type="button" onclick="document.getElementById('webinarImageUpload').click()" class="w-full py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-200 transition-colors">
                                Change Image
                            </button>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</main>

<!-- CSRF Token (if enabled) -->
<?php if (function_exists('csrf_token')): ?>
<input type="hidden" id="csrf_token_name" value="<?= csrf_token() ?>">
<input type="hidden" id="csrf_hash" value="<?= csrf_hash() ?>">
<?php endif; ?>

<script>
// Global variables
let uploadProgress = document.getElementById('upload-progress');
let draggedElement = null;

// ==================== UTILITY FUNCTIONS ====================

// Show notification
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
        'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span class="mr-3">${type === 'success' ? '✓' : type === 'error' ? '✗' : 'ℹ'}</span>
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

// Alias for showNotification
function showMessage(message, type) {
    showNotification(message, type);
}

// Get CSRF tokens for AJAX requests
function getCsrfData() {
    const csrfName = document.getElementById('csrf_token_name')?.value;
    const csrfHash = document.getElementById('csrf_hash')?.value;
    
    if (csrfName && csrfHash) {
        return {
            [csrfName]: csrfHash
        };
    }
    return {};
}

// ==================== SCROLL PROGRESS ====================

function updateScrollProgress() {
    const scrollProgress = document.querySelector('.scroll-progress');
    const stickyHeader = document.querySelector('.sticky-header');
    
    if (scrollProgress) {
        const scrollTop = window.pageYOffset;
        const docHeight = document.documentElement.scrollHeight - window.innerHeight;
        const scrollPercent = scrollTop / docHeight;
        
        scrollProgress.style.width = `${scrollPercent * 100}%`;
        
        // Add shadow when scrolled
        if (scrollTop > 10) {
            stickyHeader.classList.add('scrolled');
        } else {
            stickyHeader.classList.remove('scrolled');
        }
    }
}

// ==================== IMAGE HANDLING ====================

function handleImageUpload(inputId, previewId, hiddenInputId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const hiddenInput = document.getElementById(hiddenInputId);
    
    if (input && preview && hiddenInput) {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type and size
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                const maxSize = 5 * 1024 * 1024; // 5MB
                
                if (!validTypes.includes(file.type)) {
                    showNotification('Please upload only JPG, PNG, or GIF files', 'error');
                    input.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    showNotification('File size should be less than 5MB', 'error');
                    input.value = '';
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
                
                // Update the corresponding hidden input
                if (hiddenInput) {
                    hiddenInput.value = file.name;
                }
                
                // Show upload status
                showNotification(`Ready to upload: ${file.name}`, 'info');
            }
        });
    }
}

// Upload image file via AJAX
function uploadImageFile(file, fieldName, endpoint) {
    const formData = new FormData();
    formData.append('image', file);
    formData.append('field_name', fieldName);
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    // Show loading
    showNotification('Uploading image...', 'info');
    
    fetch(endpoint, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update hidden input with new filename
            document.getElementById(fieldName).value = data.filename;
            showNotification(data.message || 'Image uploaded successfully!', 'success');
        } else {
            showNotification(data.message || 'Error uploading image', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Upload failed. Please try again.', 'error');
    });
}

// ==================== CAPABILITIES DRAG AND DROP ====================

function getDragAfterElement(container, x) {
    const draggableElements = [...container.querySelectorAll('.capability-card:not(.dragging)')];
    
    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = x - box.left - box.width / 2;
        
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

function updateSortOrder() {
    const capabilityIds = Array.from(document.querySelectorAll('.capability-card'))
        .map(card => card.dataset.capabilityId);
    
    const formData = new FormData();
    formData.append('capabilities', JSON.stringify(capabilityIds));
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    fetch('<?= base_url("cms/update_sort") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Order updated', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// ==================== CAPABILITY CRUD ====================

function saveCapability(capabilityId, element) {
    const field = element.dataset.field;
    const value = element.value;
    
    // Get the capability card
    const capabilityCard = document.querySelector(`.capability-card[data-capability-id="${capabilityId}"]`);
    
    // Get current color scheme from the select element
    const colorSelect = capabilityCard.querySelector('.color-selector');
    const currentColor = colorSelect ? colorSelect.value : 'blue';
    
    const formData = new FormData();
    formData.append('capability_id', capabilityId);
    formData.append(field, value);
    
    // Always include color_scheme when saving capability name
    if (field === 'capability_name') {
        formData.append('color_scheme', currentColor);
    }
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    fetch('<?= base_url("cms/save_capability") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Capability updated!', 'success');
        } else {
            showNotification('Error saving capability', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    });
}

function saveCapabilityColor(capabilityId, element) {
    const field = element.dataset.field;
    const value = element.value;
    
    // Get the capability name
    const capabilityNameElement = document.querySelector(
        `.capability-card[data-capability-id="${capabilityId}"] .capability-title`
    );
    
    const formData = new FormData();
    formData.append('capability_id', capabilityId);
    formData.append(field, value);
    
    // Always send capability_name along with color update
    if (capabilityNameElement) {
        formData.append('capability_name', capabilityNameElement.value);
    }
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    // Show loading notification
    showNotification('Saving color change...', 'info');
    
    fetch('<?= base_url("cms/save_capability") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Color updated successfully! Reloading...', 'success');
            // Reload the page after a short delay
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showNotification('Error saving color', 'error');
            // Revert the select to original value if there's an error
            element.value = element.dataset.originalValue || '';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
        // Revert the select to original value
        element.value = element.dataset.originalValue || '';
    });
}

function addNewCapability() {
    document.getElementById('new-capability-modal').style.display = 'flex';
}

function closeNewCapabilityModal() {
    document.getElementById('new-capability-modal').style.display = 'none';
    document.getElementById('new-capability-name').value = '';
    document.getElementById('new-capability-color').value = 'blue';
}

function saveNewCapability() {
    const name = document.getElementById('new-capability-name').value;
    const color = document.getElementById('new-capability-color').value;
    
    if (!name.trim()) {
        alert('Please enter a capability name');
        return;
    }
    
    const formData = new FormData();
    formData.append('capability_name', name);
    formData.append('color_scheme', color);
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    fetch('<?= base_url("cms/save_capability") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Capability added! Reloading...', 'success');
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            showNotification('Error saving capability', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    });
    
    closeNewCapabilityModal();
}

function deleteCapability(id) {
    if (confirm('Are you sure you want to delete this capability?')) {
        const formData = new FormData();
        formData.append('id', id);
        
        // Add CSRF if available
        const csrfData = getCsrfData();
        for (let key in csrfData) {
            formData.append(key, csrfData[key]);
        }
        
        fetch('<?= base_url("cms/delete_capability") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Capability deleted! Reloading...', 'success');
                setTimeout(() => {
                    location.reload();
                }, 1000);
            } else {
                showNotification('Error deleting capability', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error. Please try again.', 'error');
        });
    }
}

// ==================== ITEM CRUD ====================

function saveCapabilityItem(itemId, capabilityId, element) {
    const value = element.value;
    
    const formData = new FormData();
    formData.append('item_id', itemId);
    formData.append('capability_id', capabilityId);
    formData.append('item_name', value);
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    fetch('<?= base_url("cms/save_capability_item") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Item saved!', 'success');
            if (data.item_id) {
                element.closest('.item-row').dataset.itemId = data.item_id;
            }
        } else {
            showNotification('Error saving item', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    });
}

function refreshCapabilityItems(capabilityId) {
    // Reload the capability items via AJAX
    fetch(`<?= base_url("cms/get_capability_items/") ?>${capabilityId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the items in the DOM
            const container = document.querySelector(`[data-capability-id="${capabilityId}"] .items-container`);
            if (container && data.items) {
                // Remove existing items except the template
                const existingItems = container.querySelectorAll('.item-row:not([style*="display: none"])');
                existingItems.forEach(item => {
                    if (item.dataset.itemId !== 'new') {
                        item.remove();
                    }
                });
                
                // Add updated items
                data.items.forEach(item => {
                    const colorClasses = container.closest('.capability-card').querySelector('.color-selector').value;
                    const colorMap = {
                        'blue': 'border-blue-100 focus:ring-blue-500',
                        'green': 'border-green-100 focus:ring-green-500',
                        'purple': 'border-purple-100 focus:ring-purple-500',
                        'orange': 'border-orange-100 focus:ring-orange-500',
                        'red': 'border-red-100 focus:ring-red-500'
                    };
                    const inputBorder = colorMap[colorClasses] || 'border-blue-100 focus:ring-blue-500';
                    
                    const itemHtml = `
                        <div class="flex items-center space-x-2 item-row" data-item-id="${item.id}">
                            <input 
                                type="text" 
                                class="w-full text-sm p-2 border ${inputBorder.split(' ')[0]} rounded-lg focus:ring-1 ${inputBorder.split(' ')[1]} item-input"
                                value="${item.item_name}"
                                onchange="saveCapabilityItem(${item.id}, ${capabilityId}, this)"
                            >
                            <button 
                                onclick="deleteItem(${item.id})" 
                                class="text-red-400 hover:text-red-600"
                                title="Delete Item"
                            >
                                ×
                            </button>
                        </div>
                    `;
                    
                    container.insertAdjacentHTML('beforeend', itemHtml);
                });
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function saveNewItem(capabilityId, element) {
    const value = element.value;
    
    if (!value.trim()) {
        element.parentElement.remove();
        return;
    }
    
    const formData = new FormData();
    formData.append('capability_id', capabilityId);
    formData.append('item_name', value);
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    fetch('<?= base_url("cms/save_capability_item") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Item added!', 'success');
            // Update the data-item-id from 'new' to actual ID
            element.parentElement.dataset.itemId = data.item_id;
            element.onchange = function() {
                saveCapabilityItem(data.item_id, capabilityId, this);
            };
            
            // Refresh the items list to show proper order
            setTimeout(() => {
                refreshCapabilityItems(capabilityId);
            }, 500);
        } else {
            showNotification('Error saving item', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    });
}

function addNewItem(capabilityId) {
    const template = document.getElementById(`new-item-template-${capabilityId}`);
    const newItem = template.cloneNode(true);
    newItem.style.display = 'block';
    newItem.id = '';
    
    const container = document.querySelector(`[data-capability-id="${capabilityId}"] .items-container`);
    container.appendChild(newItem);
    
    // Focus the new input
    const input = newItem.querySelector('input');
    input.focus();
}

function removeNewItem(button) {
    button.parentElement.remove();
}

function deleteItem(itemId) {
    if (confirm('Are you sure you want to delete this item?')) {
        const formData = new FormData();
        formData.append('id', itemId);
        
        // Add CSRF if available
        const csrfData = getCsrfData();
        for (let key in csrfData) {
            formData.append(key, csrfData[key]);
        }
        
        fetch('<?= base_url("cms/delete_capability_item") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`[data-item-id="${itemId}"]`).remove();
                showNotification('Item deleted!', 'success');
            } else {
                showNotification('Error deleting item', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error. Please try again.', 'error');
        });
    }
}

// ==================== BENEFITS FUNCTIONS ====================

function saveAllBenefits() {
    const benefitCards = document.querySelectorAll('.benefit-card');
    const benefitsData = [];
    
    benefitCards.forEach(card => {
        const id = card.dataset.id || card.dataset.index;
        const title = card.querySelector('.benefit-title').value;
        const description = card.querySelector('.benefit-description').value;
        const icon = card.querySelector('.icon-filename-input').value;
        
        benefitsData.push({
            id: id,
            title: title,
            description: description,
            icon: icon
        });
    });
    
    const formData = new FormData();
    formData.append('benefits', JSON.stringify(benefitsData));
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    // Show loading
    const saveBtn = document.getElementById('save-all-benefits');
    const originalText = saveBtn.textContent;
    saveBtn.textContent = 'Saving...';
    saveBtn.disabled = true;
    
    fetch('<?= base_url("cms/save_all_benefits") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Benefits saved successfully!', 'success');
            if (data.reload) {
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        } else {
            showNotification('Error saving benefits', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error. Please try again.', 'error');
    })
    .finally(() => {
        saveBtn.textContent = originalText;
        saveBtn.disabled = false;
    });
}

function addNewBenefit() {
    const container = document.getElementById('benefits-container');
    const colors = [
        { border: 'border-orange-100', bg: 'bg-orange-50/30', hover: 'hover:bg-orange-50', text: 'text-orange-600', focus: 'focus:ring-orange-500' },
        { border: 'border-teal-100', bg: 'bg-teal-50/30', hover: 'hover:bg-teal-50', text: 'text-teal-600', focus: 'focus:ring-teal-500' },
        { border: 'border-rose-100', bg: 'bg-rose-50/30', hover: 'hover:bg-rose-50', text: 'text-rose-600', focus: 'focus:ring-rose-500' }
    ];
    
    const newIndex = Date.now(); // Unique identifier
    const color = colors[container.children.length % colors.length];
    
    const newCard = document.createElement('div');
    newCard.className = `p-4 border rounded-xl ${color.border} ${color.bg} ${color.hover} transition-colors benefit-card`;
    newCard.dataset.index = `new_${newIndex}`;
    
    newCard.innerHTML = `
        <div class="mb-4">
            <label class="text-xs font-bold text-slate-400 uppercase">New Benefit Title</label>
            <input type="text" 
                   class="font-bold ${color.text} border border-transparent bg-transparent w-full text-lg focus:border-${color.text.replace('text-', '')}-300 focus:ring-1 ${color.focus} p-1 rounded benefit-title" 
                   placeholder="Enter benefit title">
        </div>
        <div>
            <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
            <textarea class="w-full text-sm p-2 border ${color.border} rounded-lg focus:ring-1 ${color.focus} resize-none benefit-description" 
                      rows="3"
                      placeholder="Enter benefit description"></textarea>
        </div>
        <div class="mt-3">
            <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Icon (Optional)</label>
            
            <!-- Icon Preview -->
            <div class="mb-2 icon-preview-container" id="icon-preview-new_${newIndex}">
                <div class="text-sm text-slate-500 mb-2 italic">No icon uploaded</div>
            </div>
            
            <!-- Upload Controls -->
            <div class="flex items-center space-x-2">
                <label class="cursor-pointer">
                    <input type="file" 
                           class="icon-file-input hidden" 
                           data-index="new_${newIndex}"
                           accept="image/*,.svg">
                    <span class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-medium py-2 px-3 rounded-lg transition-colors inline-block">
                        Upload Icon
                    </span>
                </label>
                <span class="text-xs text-slate-500">PNG, JPG, SVG</span>
            </div>
            
            <!-- Hidden field for icon filename -->
            <input type="hidden" 
                   id="icon-input-new_${newIndex}"
                   class="icon-filename-input" 
                   value="">
        </div>
        <div class="mt-4 flex justify-end">
            <button type="button" 
                    class="remove-benefit text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded transition-colors">
                Remove Benefit
            </button>
        </div>
    `;
    
    container.appendChild(newCard);
    showNotification('New benefit added', 'success');
}

function deleteBenefit(benefitId, element) {
    if (confirm('Are you sure you want to delete this benefit?')) {
        const formData = new FormData();
        formData.append('id', benefitId);
        
        // Add CSRF if available
        const csrfData = getCsrfData();
        for (let key in csrfData) {
            formData.append(key, csrfData[key]);
        }
        
        fetch('<?= base_url("cms/delete_benefit") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                element.closest('.benefit-card').remove();
                showNotification('Benefit deleted!', 'success');
            } else {
                showNotification('Error deleting benefit', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error. Please try again.', 'error');
        });
    }
}

function removeBenefitIcon(benefitId, filename, button) {
    if (confirm('Are you sure you want to remove this icon?')) {
        const formData = new FormData();
        formData.append('id', benefitId);
        formData.append('filename', filename);
        
        // Add CSRF if available
        const csrfData = getCsrfData();
        for (let key in csrfData) {
            formData.append(key, csrfData[key]);
        }
        
        fetch('<?= base_url("cms/remove_benefit_icon") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update preview
                const previewDiv = document.getElementById(`icon-preview-${benefitId}`);
                if (previewDiv) {
                    previewDiv.innerHTML = '<div class="text-sm text-slate-500 mb-2 italic">No icon uploaded</div>';
                }
                
                // Clear hidden input
                document.getElementById(`icon-input-${benefitId}`).value = '';
                
                showNotification('Icon removed', 'success');
            } else {
                showNotification('Error removing icon', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error. Please try again.', 'error');
        });
    }
}

// ==================== CAROUSEL FUNCTIONS ====================

let carouselItemCounter = <?= count($carousel_items) + 1 ?>;

function addNewCarouselItem() {
    const container = document.getElementById('carousel-items-container');
    
    const newItem = document.createElement('div');
    newItem.className = 'border border-slate-200 rounded-xl p-6 hover:bg-slate-50/50 transition-colors carousel-item';
    newItem.setAttribute('data-db-id', '0'); // 0 for new items
    
    newItem.innerHTML = `
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3">
                <div class="cursor-move text-slate-400 hover:text-slate-600 drag-handle">
                    ☰
                </div>
                <h4 class="font-bold text-slate-700">New Carousel Item</h4>
            </div>
            <button onclick="deleteCarouselItem(this, 0)" class="px-3 py-1 bg-red-100 text-red-600 text-sm rounded hover:bg-red-200 transition-colors">
                Remove
            </button>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-4">
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Title</label>
                    <input type="text" class="carousel-title w-full mt-1 p-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="Enter carousel item title">
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Description</label>
                    <textarea class="carousel-description w-full mt-1 p-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="4" placeholder="Enter carousel item description"></textarea>
                </div>
                <div>
                    <label class="text-xs font-bold text-slate-400 uppercase">Link URL</label>
                    <input type="text" class="carousel-link w-full mt-1 p-3 border border-slate-200 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="e.g., index/ps_contents">
                </div>
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-400 uppercase">Image</label>
                <div class="mt-1">
                    <div class="w-full h-48 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden mb-3">
                        <img class="carousel-image-preview w-full h-full object-cover" src="<?= base_url('assets_system/images/placeholder.png') ?>" alt="Carousel Image">
                    </div>
                    <div class="text-xs text-slate-500 mb-2 truncate">
                        Current: placeholder.png
                    </div>
                    <input type="file" class="carousel-image-upload hidden" accept="image/*">
                    <input type="hidden" class="carousel-image" value="">
                    <button type="button" onclick="uploadCarouselImage(this)" class="w-full py-2 bg-slate-100 text-slate-700 text-xs font-bold rounded-lg hover:bg-slate-200 transition-colors">
                        Change Image
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(newItem);
    setupImageUploadForCarouselItem(newItem);
    setupCarouselDragAndDrop();
    showNotification('New carousel item added', 'success');
}

function deleteCarouselItem(button, dbId) {
    const item = button.closest('.carousel-item');
    
    if (dbId > 0) {
        if (confirm('Are you sure you want to delete this carousel item?')) {
            const formData = new FormData();
            formData.append('id', dbId);
            
            // Add CSRF if available
            const csrfData = getCsrfData();
            for (let key in csrfData) {
                formData.append(key, csrfData[key]);
            }
            
            fetch('<?= base_url("cms/delete_carousel_item") ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    item.remove();
                    showNotification('Carousel item deleted', 'success');
                    // Refresh the page to renumber items
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showNotification('Error deleting item: ' + data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Network error. Please try again.', 'error');
            });
        }
    } else {
        item.remove();
        showNotification('Carousel item removed', 'success');
    }
}

function uploadCarouselImage(button) {
    const item = button.closest('.carousel-item');
    const fileInput = item.querySelector('.carousel-image-upload');
    
    // Reset the file input to allow re-uploading the same file
    fileInput.value = '';
    
    fileInput.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validate file
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (!validTypes.includes(file.type)) {
                showNotification('Please upload only JPG, PNG, GIF, or WebP files', 'error');
                return;
            }
            
            if (file.size > maxSize) {
                showNotification('File size should be less than 5MB', 'error');
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = item.querySelector('.carousel-image-preview');
                preview.src = e.target.result;
                
                // Update the filename display
                const filenameDisplay = item.querySelector('.text-xs.text-slate-500.mb-2.truncate');
                if (filenameDisplay) {
                    filenameDisplay.textContent = 'New: ' + file.name;
                }
                
                // Store filename in hidden input
                const hiddenInput = item.querySelector('.carousel-image');
                hiddenInput.value = file.name;
            };
            reader.readAsDataURL(file);
        }
    };
    
    fileInput.click();
}

function setupImageUploadForCarouselItem(item) {
    const button = item.querySelector('button[onclick^="uploadCarouselImage"]');
    button.onclick = function() {
        uploadCarouselImage(this);
    };
}

function setupCarouselDragAndDrop() {
    const container = document.querySelector('.sortable-container');
    if (!container) return;
    
    const items = container.querySelectorAll('.carousel-item');
    
    items.forEach(item => {
        const handle = item.querySelector('.drag-handle');
        if (handle) {
            handle.setAttribute('draggable', 'true');
            
            handle.addEventListener('dragstart', function(e) {
                setTimeout(() => item.classList.add('opacity-50'), 0);
                e.dataTransfer.setData('text/plain', item.dataset.dbId);
            });
            
            handle.addEventListener('dragend', function() {
                setTimeout(() => item.classList.remove('opacity-50'), 0);
            });
        }
    });
    
    container.addEventListener('dragover', function(e) {
        e.preventDefault();
        const afterElement = getDragAfterElementCarousel(container, e.clientY);
        const draggable = document.querySelector('.carousel-item.opacity-50');
        
        if (afterElement == null) {
            container.appendChild(draggable);
        } else {
            container.insertBefore(draggable, afterElement);
        }
    });
    
    container.addEventListener('dragend', function() {
        updateCarouselOrder();
    });
}

function getDragAfterElementCarousel(container, y) {
    const draggableElements = [...container.querySelectorAll('.carousel-item:not(.opacity-50)')];
    
    return draggableElements.reduce((closest, child) => {
        const box = child.getBoundingClientRect();
        const offset = y - box.top - box.height / 2;
        
        if (offset < 0 && offset > closest.offset) {
            return { offset: offset, element: child };
        } else {
            return closest;
        }
    }, { offset: Number.NEGATIVE_INFINITY }).element;
}

function updateCarouselOrder() {
    const items = Array.from(document.querySelectorAll('.carousel-item'));
    const itemIds = items.map(item => item.dataset.dbId).filter(id => id > 0);
    
    if (itemIds.length > 0) {
        const formData = new FormData();
        formData.append('items', JSON.stringify(itemIds));
        
        // Add CSRF if available
        const csrfData = getCsrfData();
        for (let key in csrfData) {
            formData.append(key, csrfData[key]);
        }
        
        fetch('<?= base_url("cms/update_carousel_order") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Order updated', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function saveCarousel() {
    const items = Array.from(document.querySelectorAll('.carousel-item'));
    const carouselData = [];
    
    // Collect form data
    const formData = new FormData();
    
    // Collect carousel items data
    items.forEach((item, index) => {
        const dbId = parseInt(item.dataset.dbId) || 0;
        const data = {
            id: index + 1,
            db_id: dbId,
            title: item.querySelector('.carousel-title').value,
            description: item.querySelector('.carousel-description').value,
            link: item.querySelector('.carousel-link').value,
            image: item.querySelector('.carousel-image').value,
            order: index + 1
        };
        
        carouselData.push(data);
        
        // Add image file if uploaded
        const fileInput = item.querySelector('.carousel-image-upload');
        if (fileInput && fileInput.files[0]) {
            // Use a consistent naming convention
            formData.append('carousel_image_' + (index + 1), fileInput.files[0]);
        }
    });
    
    // Add carousel data as JSON
    formData.append('carousel_data', JSON.stringify(carouselData));
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    // Show loading
    const saveBtn = document.querySelector('button[onclick="saveCarousel()"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.innerHTML = '<span class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';
    saveBtn.disabled = true;
    
    // Send to server
    fetch('<?= base_url("cms/save_carousel") ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            
            // Update db_ids for new items
            if (data.items && data.items.length > 0) {
                data.items.forEach((item, index) => {
                    if (items[index]) {
                        items[index].dataset.dbId = item.db_id;
                        // Update hidden image input
                        const hiddenInput = items[index].querySelector('.carousel-image');
                        if (hiddenInput && item.image) {
                            hiddenInput.value = item.image;
                        }
                        // Update preview if there's a new image
                        if (item.image && item.image !== data.old_image) {
                            const preview = items[index].querySelector('.carousel-image-preview');
                            if (preview) {
                                preview.src = '<?= base_url("assets_system/images/") ?>' + item.image;
                            }
                        }
                    }
                });
            }
            
            // Clear file inputs
            document.querySelectorAll('.carousel-image-upload').forEach(input => {
                input.value = '';
            });
            
            setTimeout(() => {
                location.reload();
            }, 800);
            
        } else {
            showNotification(data.message || 'Error saving carousel', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Network error: ' + error.message, 'error');
    })
    .finally(() => {
        // Reset button
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// ==================== SAVE ALL CHANGES ====================

function saveAllChanges() {
    const saveBtn = document.getElementById('saveAllChanges');
    const saveIcon = document.getElementById('saveIcon');
    const originalText = saveBtn.innerHTML;
    
    // Show loading state
    saveBtn.innerHTML = '<span class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';
    saveBtn.disabled = true;
    
    // Collect all data with FormData
    const formData = new FormData();
    
    // Handle file uploads
    const imageUploads = [
        'heroImageUpload',
        'bgheroImageUpload',
        'reducedCostGifUpload', 
        'reducedCostImage1Upload',
        'reducedCostImage2Upload',
        'webinarImageUpload'
    ];
    
    // Append uploaded files
    imageUploads.forEach(uploadId => {
        const input = document.getElementById(uploadId);
        if (input && input.files[0]) {
            const fieldName = uploadId.replace('Upload', '').toLowerCase() + '_image';
            formData.append(fieldName, input.files[0]);
        }
    });
    
    // Append text data
    // Hero Section
    formData.append('hero_title', document.getElementById('hero_title').value);
    formData.append('hero_description', document.getElementById('hero_description').value);
    formData.append('what_we_do_text', document.getElementById('what_we_do_text').value);
    
    // Add existing image filenames
    formData.append('hero_image', document.getElementById('hero_image').value);
    formData.append('hero_bg_img', document.getElementById('hero_bg_img').value);
    formData.append('reduced_cost_gif', document.getElementById('reduced_cost_gif').value);
    formData.append('reduced_cost_image_1', document.getElementById('reduced_cost_image_1').value);
    formData.append('reduced_cost_image_2', document.getElementById('reduced_cost_image_2').value);
    formData.append('webinar_image', document.getElementById('webinar_image').value);
    
    // Simulation in Action Section
    formData.append('simulation_title', document.getElementById('simulation_title').value);
    formData.append('simulation_description', document.getElementById('simulation_description').value);
    formData.append('simulation_button', document.getElementById('simulation_button').value);
    
    // Process & Requirements Section
    formData.append('process_title', document.getElementById('process_title').value);
    formData.append('process_description', document.getElementById('process_description').value);
    formData.append('process_step_1_title', document.getElementById('process_step_1_title').value);
    formData.append('process_step_1_description', document.getElementById('process_step_1_description').value);
    formData.append('process_step_2_title', document.getElementById('process_step_2_title').value);
    formData.append('process_step_2_description', document.getElementById('process_step_2_description').value);
    formData.append('process_step_3_title', document.getElementById('process_step_3_title').value);
    formData.append('process_step_3_description', document.getElementById('process_step_3_description').value);
    
    // Webinar Section
    formData.append('webinar_title', document.getElementById('webinar_title').value);
    formData.append('webinar_description_1', document.getElementById('webinar_description_1').value);
    formData.append('webinar_description_2', document.getElementById('webinar_description_2').value);
    
    // Add CSRF if available
    const csrfData = getCsrfData();
    for (let key in csrfData) {
        formData.append(key, csrfData[key]);
    }
    
    // Add a timestamp to prevent caching issues
    formData.append('timestamp', new Date().getTime());
    
    // Debug: Log what's being sent
    console.log('FormData contents:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }
    
    // Send to server
    fetch('<?= base_url("cms/save_all"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);
        if (data.success) {
            showNotification(data.message || 'Changes saved successfully!', 'success');
            
            // Update hidden inputs with new filenames if provided by server
            if (data.filenames) {
                // Update all filenames returned by server
                for (const [field, filename] of Object.entries(data.filenames)) {
                    const element = document.getElementById(field);
                    if (element) {
                        element.value = filename;
                    }
                }
            }
            
            // Clear file inputs after successful save
            imageUploads.forEach(uploadId => {
                const input = document.getElementById(uploadId);
                if (input) input.value = '';
            });
            
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

// ==================== INITIALIZATION ====================

document.addEventListener('DOMContentLoaded', function() {
    // Store original color values
    document.querySelectorAll('.color-selector').forEach(select => {
        select.dataset.originalValue = select.value;
    });
    
    // Hero image
    handleImageUpload('heroImageUpload', 'heroImagePreview', 'hero_image');
    handleImageUpload('bgheroImageUpload', 'bgheroImagePreview', 'hero_bg_img');
    
    // Reduced cost visuals
    handleImageUpload('reducedCostGifUpload', 'reducedCostGifPreview', 'reduced_cost_gif');
    handleImageUpload('reducedCostImage1Upload', 'reducedCostImage1Preview', 'reduced_cost_image_1');
    handleImageUpload('reducedCostImage2Upload', 'reducedCostImage2Preview', 'reduced_cost_image_2');
    
    // Webinar image
    handleImageUpload('webinarImageUpload', 'webinarImagePreview', 'webinar_image');
    
    // Carousel images - dynamically find all carousel upload inputs
    document.querySelectorAll('[id^="carousel_"][id$="_upload"]').forEach(input => {
        const baseId = input.id.replace('_upload', '');
        handleImageUpload(input.id, `${baseId}_preview`, `${baseId}_image`);
    });
    
    // Setup carousel drag and drop
    setupCarouselDragAndDrop();
    
    // Setup image upload for existing carousel items
    document.querySelectorAll('.carousel-item').forEach(item => {
        setupImageUploadForCarouselItem(item);
    });
    
    // Save all changes button
    document.getElementById('saveAllChanges').addEventListener('click', function() {
        saveAllChanges();
    });
    
    // Save all benefits button
    document.getElementById('save-all-benefits').addEventListener('click', function() {
        saveAllBenefits();
    });
    
    // Add new benefit button
    document.getElementById('add-new-benefit').addEventListener('click', function() {
        addNewBenefit();
    });
    
    // Delete benefit buttons (event delegation)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('delete-benefit')) {
            const benefitId = e.target.dataset.id;
            deleteBenefit(benefitId, e.target);
        }
        
        if (e.target.classList.contains('remove-benefit')) {
            e.target.closest('.benefit-card').remove();
            showNotification('Benefit removed', 'success');
        }
    });
    
    // Remove icon buttons (event delegation)
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-icon-btn')) {
            const benefitId = e.target.dataset.id;
            const filename = e.target.dataset.filename;
            removeBenefitIcon(benefitId, filename, e.target);
        }
    });
    
    // Add keyboard shortcut (Ctrl + S)
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            const saveButton = document.getElementById('saveAllChanges');
            saveButton.classList.add('ring-2', 'ring-indigo-500', 'ring-offset-2');
            setTimeout(() => {
                saveButton.classList.remove('ring-2', 'ring-indigo-500', 'ring-offset-2');
            }, 300);
            saveAllChanges();
        }
    });
    
    // Setup capabilities drag and drop
    const container = document.getElementById('capabilities-container');
    if (container) {
        // Make capability cards draggable
        document.querySelectorAll('.capability-card').forEach(card => {
            card.setAttribute('draggable', 'true');
            
            card.addEventListener('dragstart', function(e) {
                draggedElement = this;
                setTimeout(() => this.classList.add('dragging'), 0);
            });
            
            card.addEventListener('dragend', function() {
                setTimeout(() => {
                    this.classList.remove('dragging');
                    draggedElement = null;
                    updateSortOrder();
                }, 0);
            });
        });
        
        container.addEventListener('dragover', function(e) {
            e.preventDefault();
            const afterElement = getDragAfterElement(container, e.clientX);
            const draggable = draggedElement;
            
            if (afterElement == null) {
                container.appendChild(draggable);
            } else {
                container.insertBefore(draggable, afterElement);
            }
        });
    }
    
    // Scroll progress
    window.addEventListener('scroll', updateScrollProgress);
    updateScrollProgress(); // Initialize
    
    // Update save button text on scroll for mobile
    let lastScrollTop = 0;
    const saveButton = document.getElementById('saveAllChanges');
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Hide/show save button text on small screens when scrolling
        if (window.innerWidth < 768) {
            if (scrollTop > lastScrollTop) {
                // Scrolling down
                if (saveButton.querySelector('span')) {
                    saveButton.querySelector('span').style.opacity = '0';
                    saveButton.querySelector('span').style.width = '0';
                    saveButton.classList.add('px-3');
                }
            } else {
                // Scrolling up
                if (saveButton.querySelector('span')) {
                    saveButton.querySelector('span').style.opacity = '1';
                    saveButton.querySelector('span').style.width = 'auto';
                    saveButton.classList.remove('px-3');
                }
            }
        }
        
        lastScrollTop = scrollTop;
    });
});

// Handle icon file uploads
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('icon-file-input')) {
        const file = e.target.files[0];
        const targetId = e.target.getAttribute('data-id') || e.target.getAttribute('data-index');
        const isNew = targetId.startsWith('new_');
        
        if (!file) return;
        
        // Validate file size (2MB max)
        if (file.size > 2 * 1024 * 1024) {
            showMessage('File size must be less than 2MB', 'error');
            e.target.value = '';
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml', 'image/gif'];
        if (!validTypes.includes(file.type)) {
            showMessage('Only JPG, PNG, SVG, and GIF files are allowed', 'error');
            e.target.value = '';
            return;
        }
        
        // With this:
if (uploadProgress) {
    uploadProgress.classList.remove('hidden');
    uploadProgress.classList.add('flex');
}

// When hiding:

        
        // Create FormData
        const formData = new FormData();
        formData.append('icon_file', file);
        formData.append('target_id', targetId);
        
        // Add CSRF if available
        const csrfData = getCsrfData();
        for (let key in csrfData) {
            formData.append(key, csrfData[key]);
        }
        
        // Upload file
        fetch('<?= site_url("cms/upload_icon_benefit") ?>', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Hide upload progress
            if (uploadProgress) {
                uploadProgress.classList.add('hidden');
            }
            
            if (data.success) {
                // Update the hidden input
                const iconInput = document.getElementById(`icon-input-${targetId}`);
                if (iconInput) {
                    iconInput.value = data.filename;
                }
                
                // Update preview
                const previewDiv = document.getElementById(`icon-preview-${targetId}`);
                if (previewDiv) {
                    previewDiv.innerHTML = `
                        <div class="flex items-center space-x-3 mb-2">
                            <img src="${data.url}" 
                                 alt="Benefit Icon" 
                                 class="w-12 h-12 object-cover rounded-lg border border-slate-200">
                            <div>
                                <div class="text-sm text-slate-600">New icon</div>
                                <div class="text-xs text-slate-500 truncate max-w-[100px]">${data.filename}</div>
                            </div>
                            <button type="button" 
                                    class="remove-icon-btn text-xs bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded transition-colors"
                                    data-id="${targetId}"
                                    data-filename="${data.filename}">
                                Remove
                            </button>
                        </div>
                    `;
                }
                
                showMessage('Icon uploaded successfully!', 'success');
            } else {
                showMessage(data.message || 'Upload failed', 'error');
                e.target.value = '';
            }
        })
        .catch(error => {
            // Hide upload progress
            if (uploadProgress) {
                uploadProgress.classList.add('hidden');
            }
            console.error('Upload error:', error);
            showMessage('Upload failed. Please try again.', 'error');
            e.target.value = '';
        });
    }
});
</script>
</body>
</html>