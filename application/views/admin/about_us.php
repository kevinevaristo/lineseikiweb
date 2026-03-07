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
</style>
<main class="ml-64 p-8">
    <!-- STICKY HEADER SECTION -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header mb-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">About Us Editor</h1>
                    <p class="text-slate-500 mt-1">Modify your company story, commitments, and mission/vision statements.</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo base_url('about-us'); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview Page
                    </a>
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
        <form id="aboutUsForm" enctype="multipart/form-data">
            <div class="space-y-8">
            
                <!-- Hero Image Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🖼️</span> Hero Section</h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-6">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Hero Background Image</label>
                            <div class="flex items-center gap-4">
                                <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                    <img id="heroImagePreview" src="<?php echo base_url('assets_system/images/' . ($content['hero_about_img']['image'] ?? 'Hero.jpg')); ?>" alt="Hero Preview" class="max-w-full max-h-full object-cover rounded">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?php echo $content['hero_about_img']['image'] ?? 'Hero.jpg'; ?></span>
                                    </div>
                                    <input type="file" id="heroImageUpload" class="hidden" accept="image/*">
                                    <button type="button" onclick="document.getElementById('heroImageUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New Image
                                    </button>
                                    <input type="hidden" id="heroImageValue" value="<?php echo $content['hero_about_img']['image'] ?? ''; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Introduction & Stats Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex items-center">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">📊</span> Dynamic Statistics Boxes</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">MAIN HEADING</label>
                            <input type="text" id="header" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?php echo htmlspecialchars($content['header']['content'] ?? 'Line Seiki Asia Pacific Inc.'); ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">INTRODUCTION LEAD TEXT</label>
                            <textarea id="header_text" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="4"><?php echo htmlspecialchars($content['header_text']['content'] ?? 'At Line Seiki Asia Pacific, Inc. (LSA), we bridge innovation from Japan to industries across the Asia-Pacific region. As the official sales arm of Line Seiki Co., Ltd., we bring decades of expertise in measurement technology, automation, and smart manufacturing solutions closer to our partners and customers.'); ?></textarea>
                        </div>
                        
                        <div class="pt-4">
                            <div class="flex items-center justify-between mb-4">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">STAT BOXES</label>
                                <!-- Add Stat Button moved here -->
                                <button onclick="showAddStatModal()" class="px-3 py-1.5 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700 transition-colors flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add Stat Box
                                </button>
                            </div>
                            
                            <div id="stats-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <?php if (!empty($stats)): ?>
                                    <?php foreach ($stats as $stat): ?>
                                    <div class="stat-box p-4 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white transition-colors group relative" data-stat-id="<?php echo $stat->id; ?>">
                                        <!-- Delete Button (top right corner) -->
                                        <button onclick="showDeleteStatConfirmation(<?php echo $stat->id; ?>)" class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <div class="p-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200 transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                        
                                        <!-- Stat Content -->
                                        <div class="space-y-2">
                                            <div>
                                                <label class="text-[10px] font-bold text-slate-400 uppercase">VALUE</label>
                                                <input type="text" 
                                                       data-field="value" 
                                                       class="w-full font-bold text-lg bg-transparent border-none p-0 focus:ring-0 text-indigo-600 stat-value" 
                                                       value="<?php echo htmlspecialchars($stat->stat_value); ?>"
                                                       onblur="updateStatField(<?php echo $stat->id; ?>, 'value', this.value)"
                                                       placeholder="e.g., 1999">
                                            </div>
                                            <div>
                                                <label class="text-[10px] font-bold text-slate-400 uppercase">LABEL</label>
                                                <input type="text" 
                                                       data-field="label" 
                                                       class="w-full text-sm text-slate-600 bg-transparent border-none p-0 focus:ring-0 stat-label" 
                                                       value="<?php echo htmlspecialchars($stat->stat_label); ?>"
                                                       onblur="updateStatField(<?php echo $stat->id; ?>, 'label', this.value)"
                                                       placeholder="e.g., Year Established">
                                            </div>
                                            <div class="pt-2">
                                                <label class="text-[10px] font-bold text-slate-400 uppercase">ORDER</label>
                                                <input type="number" 
                                                       data-field="order" 
                                                       class="w-20 text-xs text-slate-500 bg-slate-100 border border-slate-200 rounded px-2 py-1 stat-order" 
                                                       value="<?php echo $stat->stat_order; ?>"
                                                       onchange="updateStatField(<?php echo $stat->id; ?>, 'order', this.value)"
                                                       min="0">
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-span-4 text-center py-8 border-2 border-dashed border-slate-300 rounded-xl bg-slate-50/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                        <h4 class="text-lg font-medium text-slate-600 mb-2">No Statistics Yet</h4>
                                        <p class="text-slate-500 mb-4">Add your first statistic box to showcase your achievements</p>
                                        <button onclick="showAddStatModal()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Add First Statistic
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Regional Commitment & Collaboration Sections -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🤝</span> Regional Commitment & Collaboration</h3>
                    </div>
                    <div class="p-6 space-y-8">
                        <?php for ($i = 1; $i <= 3; $i++): ?>
                        <div class="flex flex-col md:flex-row gap-6 p-4 border rounded-xl border-slate-200 hover:border-indigo-200 transition-colors">
                            <div class="flex-1 space-y-3">
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Section <?php echo $i; ?> Header</label>
                                    <input type="text" id="section_header_<?php echo $i; ?>" class="w-full font-bold text-slate-800 border-none p-0 focus:ring-0 text-lg" value="<?php echo htmlspecialchars($content["section_header_$i"]['content'] ?? ''); ?>">
                                </div>
                                <div>
                                    <label class="text-xs font-bold text-slate-400 uppercase">Section <?php echo $i; ?> Text</label>
                                    <textarea id="section_text_<?php echo $i; ?>" class="w-full text-sm text-slate-600 border-none p-0 focus:ring-0" rows="4"><?php echo htmlspecialchars($content["section_text_$i"]['content'] ?? ''); ?></textarea>
                                </div>
                            </div>
                            <div class="w-full md:w-48 lg:w-64">
                                <label class="text-xs font-bold text-slate-400 uppercase mb-1 block">Section <?php echo $i; ?> Image</label>
                                <div class="mt-1 aspect-video bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                    <img id="section_img_<?php echo $i; ?>_preview" src="<?php echo !empty($content["section_img_$i"]['image']) ? base_url('assets_system/images/' . $content["section_img_$i"]['image']) : base_url('assets_system/images/placeholder.jpg'); ?>" alt="Preview" class="w-full h-full object-cover">
                                </div>
                                <div class="mt-2 text-xs text-slate-500 truncate"><?php echo $content["section_img_$i"]['image'] ?? 'No image selected'; ?></div>
                                <input type="file" id="section_img_<?php echo $i; ?>_upload" class="hidden" accept="image/*">
                                <input type="hidden" id="section_img_<?php echo $i; ?>" value="<?php echo $content["section_img_$i"]['image'] ?? ''; ?>">
                                <button type="button" onclick="document.getElementById('section_img_<?php echo $i; ?>_upload').click()" class="mt-2 text-xs text-indigo-600 font-bold hover:text-indigo-800 transition-colors">
                                    Change Image
                                </button>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </section>

                <!-- Mission & Vision Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🎯</span> Mission & Vision</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mission Background Image</label>
                            <div class="flex items-center gap-4 mt-2">
                                <div class="w-48 h-32 bg-slate-100 rounded-lg border border-slate-200 overflow-hidden">
                                    <img id="missionBgPreview" src="<?php echo base_url('assets_system/images/' . ($content['mission_bg']['image'] ?? 'm-and-v.jpg')); ?>" alt="Mission BG Preview" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="mb-2">
                                        <span class="text-sm font-medium text-slate-700">Current: </span>
                                        <span class="text-sm text-slate-500"><?php echo $content['mission_bg']['image'] ?? 'm-and-v.jpg'; ?></span>
                                    </div>
                                    <input type="file" id="missionBgUpload" class="hidden" accept="image/*">
                                    <input type="hidden" id="mission_bg" value="<?php echo $content['mission_bg']['image'] ?? ''; ?>">
                                    <button type="button" onclick="document.getElementById('missionBgUpload').click()" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        Upload New Image
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Our Mission</label>
                                <textarea id="mission" class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition min-h-[120px]" rows="4"><?php echo htmlspecialchars($content['mission']['content'] ?? ''); ?></textarea>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 block">Our Vision</label>
                                <textarea id="vision" class="w-full p-4 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition min-h-[120px]" rows="4"><?php echo htmlspecialchars($content['vission']['content'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Partners Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center"><span class="mr-2">🤝</span> Partners & Associations</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Partners Section Header</label>
                            <input type="text" id="partner_header" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" value="<?php echo htmlspecialchars($content['partner_header']['content'] ?? ''); ?>">
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Partners Description</label>
                            <textarea id="partner_text" class="w-full mt-1 p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" rows="3"><?php echo htmlspecialchars($content['partner_text']['content'] ?? ''); ?></textarea>
                        </div>
                        
                        <div class="pt-4">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4 block">Partner Companies</label>
                            
                            <!-- Add New Partner Button with SweetAlert -->
                            <div class="mb-6">
                                <button type="button" onclick="showAddPartnerConfirmation()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors flex items-center gap-2 shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Add New Partner
                                </button>
                            </div>
                            
                            <!-- Add New Partner Form (Hidden) -->
                            <form id="add-partner-form" action="<?php echo site_url('cms/partners_add'); ?>" method="POST" class="hidden">
                            </form>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="partners-container">
                                <?php if (!empty($partners)): ?>
                                    <?php foreach ($partners as $partner): ?>
                                    <div class="p-4 border border-slate-200 rounded-xl bg-slate-50/50 hover:bg-white transition-colors hover:shadow-sm" id="partner-<?php echo $partner->id; ?>">
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="font-bold text-slate-700 truncate"><?php echo htmlspecialchars($partner->partner_name); ?></h4>
                                            <div class="flex items-center gap-2">
                                                
                                                <!-- Delete Button with SweetAlert -->
                                                <button type="button" 
                                                        onclick="showDeleteConfirmation(<?php echo $partner->id; ?>, '<?php echo htmlspecialchars(addslashes($partner->partner_name)); ?>')"
                                                        class="text-xs px-3 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition-colors flex items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="space-y-4">
                                            <!-- Update Partner Name Form -->
                                            <form class="update-name-form" data-partner-id="<?php echo $partner->id; ?>">
                                                <div>
                                                    <label class="text-xs font-bold text-slate-400 uppercase mb-1 block">Partner Name</label>
                                                    <div class="flex gap-2">
                                                        <input type="text" 
                                                               name="partner_name" 
                                                               class="flex-1 p-2 border border-slate-200 rounded-lg focus:ring-1 focus:ring-indigo-500 outline-none transition"
                                                               value="<?php echo htmlspecialchars($partner->partner_name); ?>"
                                                               placeholder="Enter partner name"
                                                               required>
                                                        <button type="submit" 
                                                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm flex items-center gap-1 whitespace-nowrap">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            Save
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            
                                            <!-- Logo Section -->
                                            <div>
                                                <label class="text-xs font-bold text-slate-400 uppercase mb-2 block">Logo Image</label>
                                                <div class="flex items-start gap-4">
                                                    <!-- Logo Preview -->
                                                    <div class="w-24 h-20 bg-white border border-slate-200 rounded-lg overflow-hidden flex items-center justify-center">
                                                        <?php if (!empty($partner->partner_logo)): ?>
                                                            <img src="<?php echo base_url('assets_system/images/' . $partner->partner_logo); ?>?t=<?php echo time(); ?>" 
                                                                 alt="<?php echo htmlspecialchars($partner->partner_name); ?> Logo" 
                                                                 class="max-w-full max-h-full object-contain p-2"
                                                                 onerror="this.src='<?php echo base_url('assets_system/images/placeholder-logo.png'); ?>'">
                                                        <?php else: ?>
                                                            <div class="text-center text-gray-400 p-2">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mx-auto mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                <span class="text-xs">No Logo</span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    
                                                    <!-- Logo Upload -->
                                                    <div class="flex-1">
                                                        <div class="text-xs text-slate-500 mb-2">
                                                            <?php if (!empty($partner->partner_logo)): ?>
                                                                Current: <span class="font-medium"><?php echo $partner->partner_logo; ?></span>
                                                            <?php else: ?>
                                                                No logo selected
                                                            <?php endif; ?>
                                                        </div>
                                                        
                                                        <!-- Logo Upload Form -->
                                                        <form class="upload-logo-form" data-partner-id="<?php echo $partner->id; ?>">
                                                            <div class="flex gap-2">
                                                                <input type="file" 
                                                                       name="logo" 
                                                                       id="logo_<?php echo $partner->id; ?>" 
                                                                       class="hidden"
                                                                       accept="image/*">
                                                                <button type="button" 
                                                                        onclick="document.getElementById('logo_<?php echo $partner->id; ?>').click()" 
                                                                        class="flex-1 px-4 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition-colors text-sm flex items-center justify-center gap-2">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                                    </svg>
                                                                    Upload Logo
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="col-span-2 text-center py-12 border-2 border-dashed border-slate-300 rounded-xl bg-slate-50/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <h4 class="text-lg font-medium text-slate-600 mb-2">No Partners Yet</h4>
                                        <p class="text-slate-500 mb-4">Add your first partner company to get started</p>
                                        <button onclick="showAddPartnerConfirmation()" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 00-1 1v5H4a1 1 0 100 2h5v5a1 1 0 102 0v-5h5a1 1 0 100-2h-5V4a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Add First Partner
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</main>

<?php foreach ($partners as $partner): ?>
<form id="delete-form-<?php echo $partner->id; ?>" action="<?php echo site_url('cms/partners_delete/' . $partner->id); ?>" method="POST" class="hidden">
    <input type="hidden" name="csrf_token" value="<?php echo $this->security->get_csrf_hash(); ?>">
</form>
<?php endforeach; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// SweetAlert Functions
function showAddPartnerConfirmation() {
    Swal.fire({
        title: 'Add New Partner?',
        text: 'A new partner entry will be created with the name "New Partner".',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Add It!',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a temporary form to ensure submission
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = '<?php echo site_url("cms/partners_add"); ?>';
            tempForm.style.display = 'none';
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo $this->security->get_csrf_hash(); ?>';
            
            // Add a default partner name (optional)
            const nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'partner_name';
            nameInput.value = 'New Partner';
            
            tempForm.appendChild(csrfInput);
            tempForm.appendChild(nameInput);
            document.body.appendChild(tempForm);
            
            // Show loading briefly
            Swal.fire({
                title: 'Adding Partner...',
                text: 'Please wait',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                    // Submit the form
                    setTimeout(() => {
                        tempForm.submit();
                    }, 500);
                }
            });
        }
    });
}

function showDeleteConfirmation(partnerId, partnerName) {
    Swal.fire({
        title: 'Delete Partner?',
        html: `<div class="text-left">
                  <p class="mb-3">Are you sure you want to delete:</p>
                  <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                      <p class="font-bold text-red-700">${partnerName}</p>
                      <p class="text-sm text-red-600">ID: ${partnerId}</p>
                  </div>
                  <p class="text-sm text-slate-600">This action cannot be undone.</p>
               </div>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, Delete It!',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        showClass: {
            popup: 'animate__animated animate__shakeX'
        },
        hideClass: {
            popup: 'animate__animated animate__fadeOutUp'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show deleting animation
            Swal.fire({
                title: 'Deleting...',
                text: 'Removing partner from database',
                allowOutsideClick: false,
                allowEscapeKey: false,
                timer: 1500,
                didOpen: () => {
                    Swal.showLoading();
                },
                willClose: () => {
                    // Submit the delete form
                    document.getElementById('delete-form-' + partnerId).submit();
                }
            });
        }
    });
}

// Update partner name with SweetAlert
document.addEventListener('DOMContentLoaded', function() {
    // Handle name update forms
    document.querySelectorAll('.update-name-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const partnerId = this.getAttribute('data-partner-id');
            const input = this.querySelector('input[name="partner_name"]');
            const newName = input.value.trim();
            const oldName = input.defaultValue;
            
            if (newName === oldName) {
                showNoChangeAlert();
                return;
            }
            
            if (!newName) {
                Swal.fire({
                    title: 'Empty Name!',
                    text: 'Partner name cannot be empty',
                    icon: 'error',
                    confirmButtonColor: '#4f46e5'
                });
                return;
            }
            
            showUpdateConfirmation(partnerId, newName, this);
        });
    });
    
    // Handle logo upload forms
    document.querySelectorAll('.upload-logo-form input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const partnerId = this.closest('.upload-logo-form')?.getAttribute('data-partner-id') ||
                             this.closest('[data-partner-id]')?.getAttribute('data-partner-id') ||
                             this.getAttribute('data-partner-id');
                const fileName = this.files[0].name;
                const fileSize = (this.files[0].size / 1024 / 1024).toFixed(2); // MB
                
                if (fileSize > 2) {
                    Swal.fire({
                        title: 'File Too Large!',
                        text: 'Maximum file size is 2MB',
                        icon: 'error',
                        confirmButtonColor: '#4f46e5'
                    });
                    this.value = '';
                    return;
                }
                
                showUploadConfirmation(partnerId, fileName, this);
            }
        });
    });
});

function showUpdateConfirmation(partnerId, newName, formElement) {
    Swal.fire({
        title: 'Update Partner Name?',
        html: `<div class="text-left">
                  <p class="mb-2">Change partner name to:</p>
                  <div class="bg-green-50 border border-green-200 rounded-lg p-3 mb-3">
                      <p class="font-bold text-green-700">${newName}</p>
                  </div>
               </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#059669',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Update Name',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a temporary form to submit
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = `<?php echo site_url('cms/partners_update/'); ?>/${partnerId}`;
            tempForm.style.display = 'none';
            
            const nameInput = document.createElement('input');
            nameInput.type = 'hidden';
            nameInput.name = 'partner_name';
            nameInput.value = newName;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo $this->security->get_csrf_hash(); ?>';
            
            tempForm.appendChild(nameInput);
            tempForm.appendChild(csrfInput);
            document.body.appendChild(tempForm);
            
            // Show loading
            Swal.fire({
                title: 'Updating...',
                text: 'Saving changes to database',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Submit the form
            tempForm.submit();
        }
    });
}

function showUploadConfirmation(partnerId, fileName, fileInput) {
    Swal.fire({
        title: 'Upload Logo?',
        html: `<div class="text-left">
                  <p class="mb-2">Upload this file as logo:</p>
                  <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3 mb-3">
                      <p class="font-bold text-indigo-700 truncate">${fileName}</p>
                  </div>
               </div>`,
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#4f46e5',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Upload Logo',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Create a temporary form to submit
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = `<?php echo site_url('cms/partners_upload_logo'); ?>/${partnerId}`;
            tempForm.enctype = 'multipart/form-data';
            tempForm.style.display = 'none';
            console.log(tempForm.action);
            // Clone the file input
            const newFileInput = fileInput.cloneNode(true);
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo $this->security->get_csrf_hash(); ?>';
            
            tempForm.appendChild(newFileInput);
            tempForm.appendChild(csrfInput);
            document.body.appendChild(tempForm);
            
            // Show uploading animation
            Swal.fire({
                title: 'Uploading...',
                html: `<div class="text-left">
                          <p class="mb-2">Uploading logo file:</p>
                          <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-3">
                              <p class="font-medium text-indigo-700 truncate">${fileName}</p>
                              <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                  <div class="upload-progress bg-indigo-600 h-2 rounded-full" style="width: 0%"></div>
                              </div>
                          </div>
                       </div>`,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    // Simulate progress bar (in real app, use actual upload progress)
                    const progressBar = document.querySelector('.upload-progress');
                    let width = 0;
                    const interval = setInterval(() => {
                        if (width >= 100) {
                            clearInterval(interval);
                            progressBar.textContent = 'Processing...';
                        } else {
                            width += 10;
                            progressBar.style.width = width + '%';
                        }
                    }, 100);
                }
            });
            
            // Submit the form
            setTimeout(() => {
                tempForm.submit();
            }, 1500);
        } else {
            // Reset file input if cancelled
            fileInput.value = '';
        }
    });
}

function showNoChangeAlert() {
    Swal.fire({
        title: 'No Changes',
        text: 'The partner name is the same as before',
        icon: 'info',
        confirmButtonColor: '#4f46e5',
        timer: 2000,
        showConfirmButton: false
    });
}

// Success message on page load if there's a success parameter
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const action = urlParams.get('action');
    
    if (success === 'true') {
        let message = 'Operation completed successfully!';
        let icon = 'success';
        
        switch(action) {
            case 'add':
                message = 'New partner added successfully!';
                break;
            case 'update':
                message = 'Partner updated successfully!';
                break;
            case 'delete':
                message = 'Partner deleted successfully!';
                icon = 'success';
                break;
            case 'upload':
                message = 'Logo uploaded successfully!';
                break;
        }
        
        Swal.fire({
            title: 'Success!',
            text: message,
            icon: icon,
            confirmButtonColor: '#4f46e5',
            timer: 3000,
            showConfirmButton: true
        });
        
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});
</script>
<script>
// Handle image upload previews
function handleImageUpload(inputId, previewId, hiddenInputId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const hiddenInput = document.getElementById(hiddenInputId);
    
    input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                // In a real application, you would upload the file to the server
                // and update the hidden input with the new filename
            }
            reader.readAsDataURL(file);
            
            // For demo purposes, we'll set a fake filename
            hiddenInput.value = file.name;
        }
    });
}

// Set up image upload handlers for all sections
document.addEventListener('DOMContentLoaded', function() {
    // Hero image
    handleImageUpload('heroImageUpload', 'heroImagePreview', 'heroImageValue');
    
    // Mission background
    handleImageUpload('missionBgUpload', 'missionBgPreview', 'mission_bg');
    
    // Section images
    for (let i = 1; i <= 3; i++) {
        handleImageUpload(`section_img_${i}_upload`, `section_img_${i}_preview`, `section_img_${i}`);
    }
    
    // Save all changes
    document.getElementById('saveAllChanges').addEventListener('click', function() {
        saveAllChanges();
    });
});

function saveAllChanges() {
    const saveBtn = document.getElementById('saveAllChanges');
    const originalText = saveBtn.textContent;
    
    // Show loading state
    saveBtn.innerHTML = '<span class="inline-flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Saving...</span>';
    saveBtn.disabled = true;
    
    // Collect all data
    const formData = new FormData();
    
    // Text fields
    formData.append('header', document.getElementById('header').value);
    formData.append('header_text', document.getElementById('header_text').value);
    
    // Concept boxes
    const statBoxes = document.querySelectorAll('.stat-box');
    statBoxes.forEach((box, index) => {
        const statId = box.getAttribute('data-stat-id');
        const statValue = box.querySelector('.stat-value').value;
        const statLabel = box.querySelector('.stat-label').value;
        const statOrder = box.querySelector('.stat-order').value;
        
        // Append each stat to formData
        formData.append(`stats[${index}][id]`, statId);
        formData.append(`stats[${index}][value]`, statValue);
        formData.append(`stats[${index}][label]`, statLabel);
        formData.append(`stats[${index}][order]`, statOrder);
    });
    
    // Sections
    for (let i = 1; i <= 3; i++) {
        formData.append(`section_header_${i}`, document.getElementById(`section_header_${i}`).value);
        formData.append(`section_text_${i}`, document.getElementById(`section_text_${i}`).value);
        formData.append(`section_img_${i}`, document.getElementById(`section_img_${i}`).value);
    }
    
    // Mission & Vision
    formData.append('mission', document.getElementById('mission').value);
    formData.append('vision', document.getElementById('vision').value);
    formData.append('mission_bg', document.getElementById('mission_bg').value);
    formData.append('hero_about_img', document.getElementById('heroImageValue').value);
    
    // Partners
    formData.append('partner_header', document.getElementById('partner_header').value);
    formData.append('partner_text', document.getElementById('partner_text').value);
    
    
    // Send to server (you'll need to implement the backend endpoint)
    fetch('<?php echo base_url("cms/save_about_us"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            showNotification('Changes saved successfully!', 'success');
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
        saveBtn.textContent = originalText;
        saveBtn.disabled = false;
    });
}

function showNotification(message, type = 'info') {
    Swal.fire({
        icon: type, // success | error | info | warning
        title:
            type === 'success' ? 'Success!' :
            type === 'error' ? 'Error!' :
            'Notice',
        text: message,
        timer: 1500,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
}

// Stats Management Functions
function showAddStatModal() {
    Swal.fire({
        title: 'Add New Statistic Box',
        html: `
            <div class="text-left space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Stat Value</label>
                    <input type="text" id="newStatValue" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="e.g., 100+ or 95%">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Stat Label</label>
                    <input type="text" id="newStatLabel" class="w-full p-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500" placeholder="e.g., Happy Clients">
                </div>
            </div>
        `,
        showCancelButton: true,
        confirmButtonText: 'Add Statistic',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
        preConfirm: () => {
            const value = document.getElementById('newStatValue').value.trim();
            const label = document.getElementById('newStatLabel').value.trim();
            
            if (!value || !label) {
                Swal.showValidationMessage('Please fill in both value and label fields');
                return false;
            }
            
            return { value, label, order: document.getElementById('newStatOrder').value };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            addNewStat(result.value);
        }
    });
}

function addNewStat(data) {
    Swal.fire({
        title: 'Adding Statistic...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    const formData = new FormData();
    formData.append('stat_value', data.value);
    formData.append('stat_label', data.label);
    formData.append('stat_order', data.order);
    formData.append('csrf_token', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    fetch('<?php echo site_url("cms/add_stat"); ?>', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Success!',
                text: 'Statistic added successfully',
                icon: 'success',
                confirmButtonColor: '#10b981',
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: data.message || 'Failed to add statistic',
                icon: 'error',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            title: 'Error!',
            text: 'Network error. Please try again.',
            icon: 'error',
            confirmButtonColor: '#ef4444'
        });
    });
}

function updateStatField(statId, field, value) {
    const originalValue = document.querySelector(`[data-stat-id="${statId}"] input[data-field="${field}"]`).defaultValue;
    
    if (value === originalValue) return;
    
    const formData = new FormData();
    formData.append('stat_' + field, value);
    formData.append('csrf_token', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    fetch(`<?php echo site_url("cms/update_stat"); ?>/${statId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Statistic updated!', 'success');
        }
    });
}

function showDeleteStatConfirmation(statId) {
    Swal.fire({
        title: 'Delete Statistic?',
        text: 'This will remove this statistic box from the page.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteStat(statId);
        }
    });
}

function deleteStat(statId) {
    Swal.fire({
        title: 'Deleting...',
        text: 'Please wait',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    const formData = new FormData();
    formData.append('csrf_token', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    fetch(`<?php echo site_url("cms/delete_stat"); ?>/${statId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                title: 'Deleted!',
                text: 'Statistic removed successfully',
                icon: 'success',
                confirmButtonColor: '#10b981',
                timer: 1500
            }).then(() => {
                document.querySelector(`[data-stat-id="${statId}"]`).remove();
            });
        }
    });
}

// Initialize drag and drop for reordering
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('stats-container');
    
    if (container) {
        new Sortable(container, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: function(evt) {
                const order = {};
                document.querySelectorAll('.stat-box').forEach((box, index) => {
                    const statId = box.getAttribute('data-stat-id');
                    order[index] = statId;
                });
                
                saveStatsOrder(order);
            }
        });
    }
});

function saveStatsOrder(order) {
    const formData = new FormData();
    formData.append('order', JSON.stringify(order));
    formData.append('csrf_token', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    fetch('<?php echo site_url("cms/reorder_stats"); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Order updated!', 'success');
        }
    });
}
</script>

    </div> </body>
</html>