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
                    <h1 class="text-3xl font-bold text-slate-900">Home Page Editor</h1>
                    <p class="text-slate-500 mt-1">Manage landing page content and unique carousel slides.</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo base_url(); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview Site
                    </a>
                    <button type="submit" id="saveAllChanges" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
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
        <form id="homeCmsForm" enctype="multipart/form-data">
            <div class="space-y-8">
            
                <!-- Hero Carousel Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center">🖼️ Hero Carousel Configuration</h3>
                        <button type="button" id="addSlideBtn" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-all">
                            + Add New Slide
                        </button>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex border-b border-slate-200 overflow-x-auto no-scrollbar" id="carouselTabs"></div>
                        <div id="carouselTabContent" class="mt-6"></div>
                        <input type="hidden" name="carousel_count" id="carousel_count" value="1">
                    </div>
                </section>

                <!-- Legacy Content Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">🏆 Legacy Content</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Badge & Header</label>
                                <input name="trusted_badge" type="text" class="w-full mt-1 p-2 border rounded-lg mb-2" value="<?php echo isset($cms_data['trusted_badge']['content']) ? $cms_data['trusted_badge']['content'] : ''; ?>">
                                <input name="legacy_header" type="text" class="w-full p-2 border rounded-lg" value="<?php echo isset($cms_data['legacy_header']['content']) ? $cms_data['legacy_header']['content'] : ''; ?>">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Legacy Intro Text</label>
                                <textarea name="legacy_text" class="w-full mt-1 p-2 border rounded-lg" rows="3"><?php echo isset($cms_data['legacy_text']['content']) ? $cms_data['legacy_text']['content'] : ''; ?></textarea>
                            </div>
                        </div>
                        
                        <!-- Timeline Configuration (from tbl_cms) -->
                        <div class="border-t pt-6 mt-6">
                            <label class="text-xs font-bold text-slate-500 uppercase mb-4 block">Timeline Configuration</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-slate-600 mb-1 block">Timeline Years</label>
                                    <input name="timeline_years" type="text" class="w-full p-2 border rounded-lg" value="<?php echo isset($cms_data['timeline_years']['content']) ? $cms_data['timeline_years']['content'] : '70+'; ?>" placeholder="70+">
                                </div>
                                <div>
                                    <label class="text-xs text-slate-600 mb-1 block">Timeline Label</label>
                                    <input name="timeline_label" type="text" class="w-full p-2 border rounded-lg" value="<?php echo isset($cms_data['timeline_label']['content']) ? $cms_data['timeline_label']['content'] : 'Years of Excellence'; ?>" placeholder="Years of Excellence">
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Achievements Section (NEW) -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-8">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center">🏆 Company Achievements</h3>
                        <button type="button" id="addAchievementBtn" class="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-xs font-bold hover:bg-green-100 transition-all">
                            + Add Achievement
                        </button>
                    </div>
                    <div class="p-6">
                        <div id="achievementsContainer" class="space-y-4">
                            <?php if(!empty($achievements)): ?>
                                <?php foreach($achievements as $achievement): ?>
                                <div class="achievement-item p-4 border rounded-lg bg-slate-50" data-id="<?php echo $achievement['id']; ?>">
                                    <div class="grid grid-cols-12 gap-3">
                                        <div class="col-span-10">
                                            <input type="hidden" name="achievement_id[]" value="<?php echo $achievement['id']; ?>">
                                            
                                            <div class="grid grid-cols-2 gap-3 mb-3">
                                                <div>
                                                    <label class="text-xs text-slate-600 mb-1 block">Title</label>
                                                    <input type="text" name="achievement_title_<?php echo $achievement['id']; ?>" 
                                                           class="achievement-title w-full p-2 border rounded text-sm" 
                                                           value="<?php echo htmlspecialchars($achievement['title']); ?>" 
                                                           placeholder="e.g., Foundation">
                                                </div>
                                                <div>
                                                    <label class="text-xs text-slate-600 mb-1 block">Year</label>
                                                    <input type="text" name="achievement_year_<?php echo $achievement['id']; ?>" 
                                                           class="achievement-year w-full p-2 border rounded text-sm" 
                                                           value="<?php echo htmlspecialchars($achievement['year']); ?>" 
                                                           placeholder="e.g., 1953">
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="text-xs text-slate-600 mb-1 block">Content</label>
                                                <textarea name="achievement_content_<?php echo $achievement['id']; ?>" 
                                                          class="achievement-content w-full p-2 border rounded text-sm" 
                                                          rows="2" 
                                                          placeholder="Achievement description"><?php echo htmlspecialchars($achievement['content']); ?></textarea>
                                            </div>
                                            
                                            <!-- Sort Order -->
                                            <div class="mb-3" style="display: none">
                                                <label class="text-xs text-slate-600 mb-1 block">Sort Order</label>
                                                <input type="number" name="achievement_sort_<?php echo $achievement['id']; ?>" 
                                                       class="achievement-sort w-24 p-2 border rounded text-sm" 
                                                       value="<?php echo $achievement['sort_order'] ?? 0; ?>" 
                                                       placeholder="0">
                                            </div>
                                            
                                            <!-- Image Upload -->
                                            <div class="mt-2">
                                                <label class="text-xs text-slate-600 mb-1 block">Achievement Image</label>
                                                <div class="space-y-2">
                                                    <!-- Current Image Display -->
                                                    <div id="currentAchievementImageContainer_<?php echo $achievement['id']; ?>" class="<?php echo empty($achievement['image']) ? 'hidden' : ''; ?>">
                                                        <div class="border rounded-lg p-3 mb-2">
                                                            <div class="flex items-center gap-3">
                                                                <?php if(!empty($achievement['image'])): ?>
                                                                <img src="<?php echo base_url('assets_system/images/' . $achievement['image']); ?>" 
                                                                     alt="Achievement Image" 
                                                                     class="w-16 h-16 object-cover rounded border">
                                                                <?php endif; ?>
                                                                <div>
                                                                    <input type="hidden" name="existing_achievement_image_<?php echo $achievement['id']; ?>" 
                                                                           value="<?php echo !empty($achievement['image']) ? $achievement['image'] : ''; ?>">
                                                                    <button type="button" 
                                                                            class="change-achievement-image-btn px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-200"
                                                                            data-achievement-id="<?php echo $achievement['id']; ?>">
                                                                        <i class="fas fa-upload mr-1"></i>Change image
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Upload Field -->
                                                    <div id="achievementImageUploadContainer_<?php echo $achievement['id']; ?>" class="<?php echo empty($achievement['image']) ? '' : 'hidden'; ?>">
                                                        <input type="file" name="achievement_image_file_<?php echo $achievement['id']; ?>" 
                                                               class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                               accept="image/*">
                                                        <?php if (!empty($achievement['image'])): ?>
                                                        <div class="flex justify-end mt-2">
                                                            <button type="button" 
                                                                    class="cancel-achievement-upload-btn px-3 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition-all"
                                                                    data-achievement-id="<?php echo $achievement['id']; ?>">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Icon Upload (optional fallback) -->
                                            <div class="mt-2" style="display: none">
                                                <label class="text-xs text-slate-600 mb-1 block">Icon (Optional)</label>
                                                <div class="space-y-2">
                                                    <div id="currentAchievementIconContainer_<?php echo $achievement['id']; ?>" class="<?php echo empty($achievement['icon']) ? 'hidden' : ''; ?>">
                                                        <div class="border rounded-lg p-3 mb-2">
                                                            <div class="flex items-center gap-3">
                                                                <?php if(!empty($achievement['icon'])): ?>
                                                                <img src="<?php echo base_url('assets_system/images/' . $achievement['icon']); ?>" 
                                                                     alt="Achievement Icon" 
                                                                     class="w-12 h-12 object-cover rounded border">
                                                                <?php endif; ?>
                                                                <div>
                                                                    <input type="hidden" name="existing_achievement_icon_<?php echo $achievement['id']; ?>" 
                                                                           value="<?php echo !empty($achievement['icon']) ? $achievement['icon'] : ''; ?>">
                                                                    <button type="button" 
                                                                            class="change-achievement-icon-btn px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-200"
                                                                            data-achievement-id="<?php echo $achievement['id']; ?>">
                                                                        <i class="fas fa-upload mr-1"></i>Change icon
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="achievementIconUploadContainer_<?php echo $achievement['id']; ?>" class="<?php echo empty($achievement['icon']) ? '' : 'hidden'; ?>">
                                                        <input type="file" name="achievement_icon_file_<?php echo $achievement['id']; ?>" 
                                                               class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                               accept="image/*">
                                                        <?php if (!empty($achievement['icon'])): ?>
                                                        <div class="flex justify-end mt-2">
                                                            <button type="button" 
                                                                    class="cancel-achievement-icon-upload-btn px-3 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition-all"
                                                                    data-achievement-id="<?php echo $achievement['id']; ?>">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Active Status -->
                                            <div class="mt-3 flex items-center">
                                                <label class="flex items-center cursor-pointer">
                                                    <input type="checkbox" name="achievement_active_<?php echo $achievement['id']; ?>" 
                                                           class="achievement-active w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                                           <?php echo ($achievement['is_active'] ?? 1) ? 'checked' : ''; ?>>
                                                    <span class="ml-2 text-xs text-slate-600">Active</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex items-end justify-end">
                                            <button type="button" class="delete-achievement-btn px-3 py-2 bg-red-100 text-red-600 rounded text-sm font-semibold hover:bg-red-200" data-id="<?php echo $achievement['id']; ?>">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="button" id="saveAchievementsBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-all">
                                Save Achievements
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Dynamic Categories Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center">📦 Product Categories</h3>
                        <button type="button" id="addCategoryBtn" class="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-xs font-bold hover:bg-green-100 transition-all">
                            + Add Category
                        </button>
                    </div>
                    <div class="p-6">
                        <div id="categoriesContainer" class="space-y-4">
                            <?php if(!empty($categories)): ?>
                                <?php foreach($categories as $category): ?>
                                <div class="category-item p-4 border rounded-lg bg-slate-50">
                                    <div class="grid grid-cols-12 gap-3">
                                        <div class="col-span-10">
                                            <input type="hidden" name="category_id[]" value="<?php echo $category['id']; ?>">
                                            <input type="text" name="category_title[]" class="w-full p-2 border rounded mb-2" value="<?php echo htmlspecialchars($category['title']); ?>" placeholder="Category Title">
                                            <textarea name="category_text[]" class="w-full p-2 border rounded text-sm" rows="2" placeholder="Category description"><?php echo htmlspecialchars($category['text']); ?></textarea>
                                            
                                            <!-- ADD THIS: Icon upload section -->
                                            <div class="mt-2">
                                                <label class="text-xs text-slate-600 mb-1 block">Category Icon</label>
                                                <div class="space-y-2">
                                                    <!-- Current Icon Display -->
                                                    <div id="currentCategoryIconContainer_<?php echo $category['id']; ?>" class="<?php echo empty($category['icon']) ? 'hidden' : ''; ?>">
                                                        <div class="border rounded-lg p-3 mb-2">
                                                            <div class="flex items-center gap-3">
                                                                <?php if(!empty($category['icon'])): ?>
                                                                <img src="<?php echo base_url('assets_system/images/' . $category['icon']); ?>" 
                                                                     alt="Category Icon" 
                                                                     class="w-12 h-12 object-cover rounded border">
                                                                <?php endif; ?>
                                                                <div>
                                                                    <input type="hidden" name="existing_category_icon_<?php echo $category['id']; ?>" 
                                                                           value="<?php echo !empty($category['icon']) ? $category['icon'] : ''; ?>">
                                                                    <button type="button" 
                                                                            class="change-category-icon-btn px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-200"
                                                                            data-category-id="<?php echo $category['id']; ?>">
                                                                        <i class="fas fa-upload mr-1"></i>Change icon
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Upload Field -->
                                                    <div id="categoryIconUploadContainer_<?php echo $category['id']; ?>" class="<?php echo empty($category['icon']) ? '' : 'hidden'; ?>">
                                                        <input type="file" name="category_icon_file_<?php echo $category['id']; ?>" 
                                                               class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                               accept="image/*">
                                                        <?php if (!empty($category['icon'])): ?>
                                                        <div class="flex justify-end mt-2">
                                                            <button type="button" 
                                                                    class="cancel-category-upload-btn px-3 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition-all"
                                                                    data-category-id="<?php echo $category['id']; ?>">
                                                                Cancel
                                                            </button>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex items-end">
                                            <button type="button" class="delete-category-btn px-3 py-2 bg-red-100 text-red-600 rounded text-sm font-semibold hover:bg-red-200" data-id="<?php echo $category['id']; ?>">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback to old static categories if dynamic categories are empty -->
                                <?php for($i=1; $i<=4; $i++): ?>
                                <div class="category-item p-4 border rounded-lg bg-slate-50">
                                    <input type="hidden" name="category_id[]" value="">
                                    <div class="grid grid-cols-12 gap-3">
                                        <div class="col-span-10">
                                            <input type="text" name="category_title[]" class="w-full p-2 border rounded mb-2" value="<?php echo isset($cms_data['category_title_'.$i]['content']) ? $cms_data['category_title_'.$i]['content'] : ''; ?>" placeholder="Category Title">
                                            <textarea name="category_text[]" class="w-full p-2 border rounded text-sm" rows="2" placeholder="Category description"><?php echo isset($cms_data['category_text_'.$i]['content']) ? $cms_data['category_text_'.$i]['content'] : ''; ?></textarea>
                                            
                                            <!-- ADD THIS: Icon upload section for static categories -->
                                            <div class="mt-2">
                                                <label class="text-xs text-slate-600 mb-1 block">Category Icon</label>
                                                <div class="space-y-2">
                                                    <div id="categoryIconUploadContainer_static_<?php echo $i; ?>">
                                                        <input type="file" name="category_icon_file_static_<?php echo $i; ?>" 
                                                               class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                               accept="image/*">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-span-2 flex items-end">
                                            <button type="button" class="delete-category-btn px-3 py-2 bg-red-100 text-red-600 rounded text-sm font-semibold hover:bg-red-200">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                        <div class="mt-4">
                            <button type="button" id="saveCategoriesBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-all">
                                Save Categories
                            </button>
                        </div>
                    </div>
                </section>

                <!-- Dynamic Statistics Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center">📊 Key Statistics</h3>
                        <button type="button" id="addStatBtn" class="px-3 py-1.5 bg-green-50 text-green-600 rounded-lg text-xs font-bold hover:bg-green-100 transition-all">
                            + Add Statistic
                        </button>
                    </div>
                    <div class="p-6">
                        <div id="statsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <?php if(!empty($stats)): ?>
                                <?php foreach($stats as $stat): ?>
                                <div class="stat-item p-4 border rounded-lg bg-slate-50">
                                    <input type="hidden" name="stat_id[]" value="<?php echo $stat['id']; ?>">
                                    <label class="text-xs text-slate-600 mb-1 block">Stat Number</label>
                                    <input type="text" name="stat_number[]" class="w-full p-2 border rounded mb-3 font-bold" value="<?php echo htmlspecialchars($stat['stat_number']); ?>" placeholder="50K+">
                                    <label class="text-xs text-slate-600 mb-1 block">Stat Label</label>
                                    <input type="text" name="stat_label[]" class="w-full p-2 border rounded text-sm" value="<?php echo htmlspecialchars($stat['stat_label']); ?>" placeholder="PRODUCTS INSTALLED">
                                    <div class="flex justify-end mt-3">
                                        <button type="button" class="delete-stat-btn px-3 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold hover:bg-red-200" data-id="<?php echo $stat['id']; ?>">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <!-- Fallback to old static stats if dynamic stats are empty -->
                                <?php for($i=1; $i<=4; $i++): ?>
                                <div class="stat-item p-4 border rounded-lg bg-slate-50">
                                    <input type="hidden" name="stat_id[]" value="">
                                    <label class="text-xs text-slate-600 mb-1 block">Stat Number</label>
                                    <input type="text" name="stat_number[]" class="w-full p-2 border rounded mb-3 font-bold" value="<?php echo isset($cms_data['stat_number_'.$i]['content']) ? $cms_data['stat_number_'.$i]['content'] : ''; ?>" placeholder="50K+">
                                    <label class="text-xs text-slate-600 mb-1 block">Stat Label</label>
                                    <input type="text" name="stat_label[]" class="w-full p-2 border rounded text-sm" value="<?php echo isset($cms_data['stat_label_'.$i]['content']) ? $cms_data['stat_label_'.$i]['content'] : ''; ?>" placeholder="PRODUCTS INSTALLED">
                                    <div class="flex justify-end mt-3">
                                        <button type="button" class="delete-stat-btn px-3 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold hover:bg-red-200">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>
                        <div class="mt-4">
                            <button type="button" id="saveStatsBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-all">
                                Save Statistics
                            </button>
                        </div>
                    </div>
                </section>
                
                <!-- Services Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">🛠️ Services Section</h3>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <!-- Services Tagline -->
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Services Tagline</label>
                            <input type="text" name="services_tagline" id="services_tagline" 
                                   class="w-full mt-1 p-2 border rounded-lg" 
                                   value="<?php echo isset($services['tagline']) ? htmlspecialchars($services['tagline']) : 'Beyond Measurement — We Engineer Possibilities'; ?>" 
                                   placeholder="Enter tagline text">
                        </div>
                        
                        <!-- Fixed Services List (3 services) -->
                        <div class="border-t pt-6">
                            <label class="text-xs font-bold text-slate-500 uppercase mb-4 block">Services (Fixed 3 Services)</label>
                            
                            <div id="servicesContainer" class="space-y-4">
                                <!-- Service 1: Simulation Analysis -->
                                <div class="service-item border border-slate-200 rounded-xl p-4 bg-slate-50/50">
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="text-sm font-semibold text-slate-700">Service 1: Simulation Analysis</span>
                                        <!--<span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">Featured</span>-->
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Service Title</label>
                                                <input type="text" name="service_title_1" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][0]['title']) ? htmlspecialchars($services['services'][0]['title']) : 'Simulation Analysis Service'; ?>" 
                                                       placeholder="e.g., Simulation Analysis Service">
                                            </div>
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Badge Text</label>
                                                <input type="text" name="service_badge_1" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][0]['badge']) ? htmlspecialchars($services['services'][0]['badge']) : 'Advanced Engineering'; ?>" 
                                                       placeholder="e.g., Advanced Engineering">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Description</label>
                                            <textarea name="service_description_1" 
                                                      class="w-full p-2 border rounded-lg" 
                                                      rows="3" 
                                                      placeholder="Service description text here..."><?php echo isset($services['services'][0]['description']) ? htmlspecialchars($services['services'][0]['description']) : 'Backed by our expertise in research and development, we provide engineering simulation analysis to validate product designs before physical testing, reducing development time and costs.'; ?></textarea>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Link Label</label>
                                                <input type="text" name="service_link_label_1" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][0]['link_label']) ? htmlspecialchars($services['services'][0]['link_label']) : 'Explore Simulation Services'; ?>" 
                                                       placeholder="e.g., Explore Service">
                                            </div>
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Featured Badge</label>
                                                <input type="text" name="service_featured_badge_1" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][0]['featured_badge']) ? htmlspecialchars($services['services'][0]['featured_badge']) : 'Most Popular'; ?>" 
                                                       placeholder="e.g., Most Popular">
                                            </div>
                                        </div>
                                        
                                        <!-- Features -->
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Features (one per line) (max 4)</label>
                                            <textarea name="service_features_1" 
                                                      class="w-full p-2 border rounded-lg" 
                                                      rows="3" 
                                                      placeholder="Feature 1&#10;Feature 2&#10;Feature 3"><?php 
                                                if (isset($services['services'][0]['features']) && is_array($services['services'][0]['features'])) {
                                                    echo htmlspecialchars(implode("\n", $services['services'][0]['features']));
                                                } else {
                                                    echo "Finite Element Analysis (FEA)\nComputational Fluid Dynamics (CFD)\nThermal Analysis\nStructural Optimization";
                                                }
                                            ?></textarea>
                                        </div>
                                        
                                        <!-- Image Upload -->
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Service Icon Image</label>
                                            <div class="space-y-2">
                                                <!-- Current Image Display -->
                                                <div id="currentServiceImageContainer_1" class="<?php echo empty($services['services'][0]['image']) ? 'hidden' : ''; ?>">
                                                    <div class="border rounded-lg p-3 mb-2">
                                                        <div class="flex items-center gap-3">
                                                            <img src="<?php echo !empty($services['services'][0]['image']) ? base_url('assets_system/images/' . $services['services'][0]['image']) : base_url('assets_system/images/icon_simul.png'); ?>" 
                                                                 alt="Service Icon" 
                                                                 class="w-16 h-16 object-cover rounded border">
                                                            <div>
                                                                <input type="hidden" name="existing_service_image_1" 
                                                                       value="<?php echo !empty($services['services'][0]['image']) ? $services['services'][0]['image'] : 'icon_simul.png'; ?>">
                                                                <button type="button" 
                                                                        class="change-service-image-btn px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-200"
                                                                        data-service-index="1">
                                                                    <i class="fas fa-upload mr-1"></i>Change image
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Upload Field -->
                                                <div id="serviceUploadContainer_1" class="<?php echo empty($services['services'][0]['image']) ? '' : 'hidden'; ?>">
                                                    <input type="file" name="service_image_file_1" 
                                                           class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                           accept="image/*">
                                                    <?php if (!empty($services['services'][0]['image'])): ?>
                                                    <div class="flex justify-end mt-2">
                                                        <button type="button" 
                                                                class="cancel-service-upload-btn px-3 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition-all"
                                                                data-service-index="1">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- Service 2: Silicone Molding -->
                                <div class="service-item border border-slate-200 rounded-xl p-4 bg-slate-50/50">
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="text-sm font-semibold text-slate-700">Service 2: Silicone Molding</span>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Service Title</label>
                                                <input type="text" name="service_title_2" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][1]['title']) ? htmlspecialchars($services['services'][1]['title']) : 'Silicone Molding & Urethane Casting'; ?>" 
                                                       placeholder="e.g., Silicone Molding & Urethane Casting">
                                            </div>
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Badge Text</label>
                                                <input type="text" name="service_badge_2" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][1]['badge']) ? htmlspecialchars($services['services'][1]['badge']) : 'Rapid Prototyping'; ?>" 
                                                       placeholder="e.g., Rapid Prototyping">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Description</label>
                                            <textarea name="service_description_2" 
                                                      class="w-full p-2 border rounded-lg" 
                                                      rows="3" 
                                                      placeholder="Service description text here..."><?php echo isset($services['services'][1]['description']) ? htmlspecialchars($services['services'][1]['description']) : 'Rapid prototyping and low-volume production solutions that accelerate your product development cycle and help you reach market validation faster.'; ?></textarea>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Link Label</label>
                                                <input type="text" name="service_link_label_2" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][1]['link_label']) ? htmlspecialchars($services['services'][1]['link_label']) : 'Learn About Molding'; ?>" 
                                                       placeholder="e.g., Explore Service">
                                            </div>
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Featured Badge (optional)</label>
                                                <input type="text" name="service_featured_badge_2" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][1]['featured_badge']) ? htmlspecialchars($services['services'][1]['featured_badge']) : ''; ?>" 
                                                       placeholder="Leave empty if not featured">
                                            </div>
                                        </div>
                                        
                                        <!-- Features -->
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Features (one per line) (max 4)</label>
                                            <textarea name="service_features_2" 
                                                      class="w-full p-2 border rounded-lg" 
                                                      rows="3" 
                                                      placeholder="Feature 1&#10;Feature 2&#10;Feature 3"><?php 
                                                if (isset($services['services'][1]['features']) && is_array($services['services'][1]['features'])) {
                                                    echo htmlspecialchars(implode("\n", $services['services'][1]['features']));
                                                } else {
                                                    echo "Quick Turnaround Times\nHigh-Quality Surface Finish\nMaterial Variety\nCost-Effective for Small Batches";
                                                }
                                            ?></textarea>
                                        </div>
                                        
                                        <!-- Image Upload -->
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Service Icon Image</label>
                                            <div class="space-y-2">
                                                <!-- Current Image Display -->
                                                <div id="currentServiceImageContainer_2" class="<?php echo empty($services['services'][1]['image']) ? 'hidden' : ''; ?>">
                                                    <div class="border rounded-lg p-3 mb-2">
                                                        <div class="flex items-center gap-3">
                                                            <img src="<?php echo !empty($services['services'][1]['image']) ? base_url('assets_system/images/' . $services['services'][1]['image']) : base_url('assets_system/images/icon_sili.png'); ?>" 
                                                                 alt="Service Icon" 
                                                                 class="w-16 h-16 object-cover rounded border">
                                                            <div>
                                                                <input type="hidden" name="existing_service_image_2" 
                                                                       value="<?php echo !empty($services['services'][1]['image']) ? $services['services'][1]['image'] : 'icon_sili.png'; ?>">
                                                                <button type="button" 
                                                                        class="change-service-image-btn px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-200"
                                                                        data-service-index="2">
                                                                    <i class="fas fa-upload mr-1"></i>Change image
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Upload Field -->
                                                <div id="serviceUploadContainer_2" class="<?php echo empty($services['services'][1]['image']) ? '' : 'hidden'; ?>">
                                                    <input type="file" name="service_image_file_2" 
                                                           class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                           accept="image/*">
                                                    <?php if (!empty($services['services'][1]['image'])): ?>
                                                    <div class="flex justify-end mt-2">
                                                        <button type="button" 
                                                                class="cancel-service-upload-btn px-3 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition-all"
                                                                data-service-index="2">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                
                                <!-- Service 3: GEMBA Monitoring -->
                                <div class="service-item border border-slate-200 rounded-xl p-4 bg-slate-50/50">
                                    <div class="flex items-center gap-2 mb-4">
                                        <span class="text-sm font-semibold text-slate-700">Service 3: GEMBA Monitoring</span>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Service Title</label>
                                                <input type="text" name="service_title_3" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][2]['title']) ? htmlspecialchars($services['services'][2]['title']) : 'GEMBA Machine Monitoring System'; ?>" 
                                                       placeholder="e.g., GEMBA Machine Monitoring System">
                                            </div>
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Badge Text</label>
                                                <input type="text" name="service_badge_3" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][2]['badge']) ? htmlspecialchars($services['services'][2]['badge']) : 'IoT Solution'; ?>" 
                                                       placeholder="e.g., IoT Solution">
                                            </div>
                                        </div>
                                        
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Description</label>
                                            <textarea name="service_description_3" 
                                                      class="w-full p-2 border rounded-lg" 
                                                      rows="3" 
                                                      placeholder="Service description text here..."><?php echo isset($services['services'][2]['description']) ? htmlspecialchars($services['services'][2]['description']) : 'Track machine status, downtime, and productivity in real time through a comprehensive dashboard that provides actionable insights for operational excellence.'; ?></textarea>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Link Label</label>
                                                <input type="text" name="service_link_label_3" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][2]['link_label']) ? htmlspecialchars($services['services'][2]['link_label']) : 'Discover GEMBA'; ?>" 
                                                       placeholder="e.g., Explore Service">
                                            </div>
                                            <div>
                                                <label class="text-xs text-slate-600 mb-1 block">Featured Badge (optional)</label>
                                                <input type="text" name="service_featured_badge_3" 
                                                       class="w-full p-2 border rounded-lg" 
                                                       value="<?php echo isset($services['services'][2]['featured_badge']) ? htmlspecialchars($services['services'][2]['featured_badge']) : ''; ?>" 
                                                       placeholder="Leave empty if not featured">
                                            </div>
                                        </div>
                                        
                                        <!-- Features -->
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Features (one per line) (max 4)</label>
                                            <textarea name="service_features_3" 
                                                      class="w-full p-2 border rounded-lg" 
                                                      rows="3" 
                                                      placeholder="Feature 1&#10;Feature 2&#10;Feature 3"><?php 
                                                if (isset($services['services'][2]['features']) && is_array($services['services'][2]['features'])) {
                                                    echo htmlspecialchars(implode("\n", $services['services'][2]['features']));
                                                } else {
                                                    echo "Real-Time Monitoring\nDowntime Analysis\nPerformance Metrics\nPredictive Maintenance";
                                                }
                                            ?></textarea>
                                        </div>
                                        
                                        <!-- Image Upload -->
                                        <div>
                                            <label class="text-xs text-slate-600 mb-1 block">Service Icon Image</label>
                                            <div class="space-y-2">
                                                <!-- Current Image Display -->
                                                <div id="currentServiceImageContainer_3" class="<?php echo empty($services['services'][2]['image']) ? 'hidden' : ''; ?>">
                                                    <div class="border rounded-lg p-3 mb-2">
                                                        <div class="flex items-center gap-3">
                                                            <img src="<?php echo !empty($services['services'][2]['image']) ? base_url('assets_system/images/' . $services['services'][2]['image']) : base_url('assets_system/images/icon_gemba.png'); ?>" 
                                                                 alt="Service Icon" 
                                                                 class="w-16 h-16 object-cover rounded border">
                                                            <div>
                                                                <input type="hidden" name="existing_service_image_3" 
                                                                       value="<?php echo !empty($services['services'][2]['image']) ? $services['services'][2]['image'] : 'icon_gemba.png'; ?>">
                                                                <button type="button" 
                                                                        class="change-service-image-btn px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-200"
                                                                        data-service-index="3">
                                                                    <i class="fas fa-upload mr-1"></i>Change image
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Upload Field -->
                                                <div id="serviceUploadContainer_3" class="<?php echo empty($services['services'][2]['image']) ? '' : 'hidden'; ?>">
                                                    <input type="file" name="service_image_file_3" 
                                                           class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                           accept="image/*">
                                                    <?php if (!empty($services['services'][2]['image'])): ?>
                                                    <div class="flex justify-end mt-2">
                                                        <button type="button" 
                                                                class="cancel-service-upload-btn px-3 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition-all"
                                                                data-service-index="3">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- CTA / Brochure Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">📥 CTA Section & Brochure</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- CTA Title -->
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">CTA Heading</label>
                            <input type="text" name="cta_heading" id="cta_heading"
                                   class="w-full mt-1 p-2 border rounded-lg"
                                   value="<?php echo isset($cms_data['cta_heading']['content']) ? htmlspecialchars($cms_data['cta_heading']['content']) : 'Ready to Transform Your Operations?'; ?>"
                                   placeholder="Ready to Transform Your Operations?">
                        </div>

                        <!-- CTA Subtitle -->
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">CTA Subtitle</label>
                            <input type="text" name="cta_subtitle" id="cta_subtitle"
                                   class="w-full mt-1 p-2 border rounded-lg"
                                   value="<?php echo isset($cms_data['cta_subtitle']['content']) ? htmlspecialchars($cms_data['cta_subtitle']['content']) : 'Let\'s discuss how our services can drive efficiency and innovation in your business'; ?>"
                                   placeholder="Let's discuss how our services can drive efficiency and innovation in your business">
                        </div>

                        <!-- Brochure Upload -->
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase mb-2 block">Brochure File (PDF)</label>
                            <p class="text-xs text-slate-400 mb-3">Upload a brochure file for the "Download Brochure" button. If no file is uploaded, the button will link to the Products page.</p>

                            <?php
                            $current_brochure = isset($cms_data['cta_brochure']['content']) ? $cms_data['cta_brochure']['content'] : '';
                            ?>

                            <!-- Current brochure display -->
                            <div id="currentBrochureInfo" class="<?= empty($current_brochure) ? 'hidden' : '' ?> mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center">
                                            <i class="fas fa-file-pdf text-red-600 text-lg"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-green-700" id="currentBrochureName"><?= !empty($current_brochure) ? htmlspecialchars(basename($current_brochure)) : '' ?></p>
                                            <a href="<?= !empty($current_brochure) ? base_url($current_brochure) : '#' ?>" target="_blank" class="text-xs text-green-600 hover:underline" id="currentBrochureLink">
                                                <i class="fas fa-external-link-alt mr-1"></i>View file
                                            </a>
                                        </div>
                                    </div>
                                    <button type="button" onclick="removeBrochure()" class="text-red-500 hover:text-red-700 text-sm">
                                        <i class="fas fa-times mr-1"></i>Remove
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="cta_brochure" id="cta_brochure_value" value="<?= htmlspecialchars($current_brochure) ?>">

                            <!-- Upload area -->
                            <div id="brochureUploadArea" class="<?= !empty($current_brochure) ? 'hidden' : '' ?>">
                                <div class="border-2 border-dashed border-slate-300 rounded-lg p-6 text-center hover:border-indigo-400 transition-colors cursor-pointer"
                                     onclick="document.getElementById('brochureFileInput').click()">
                                    <i class="fas fa-cloud-upload-alt text-slate-400 text-3xl mb-2"></i>
                                    <p class="text-sm text-slate-600">Click to upload brochure</p>
                                    <p class="text-xs text-slate-400 mt-1">PDF, DOC, DOCX, XLS, XLSX (Max 10MB)</p>
                                    <input type="file" id="brochureFileInput" class="hidden" accept=".pdf,.doc,.docx,.xls,.xlsx"
                                           onchange="uploadBrochureFile(this)">
                                </div>
                                <!-- Upload progress -->
                                <div id="brochureUploadProgress" class="hidden mt-2">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-slate-200 rounded-full h-2">
                                            <div id="brochureProgressBar" class="bg-indigo-600 h-2 rounded-full transition-all" style="width: 0%"></div>
                                        </div>
                                        <span id="brochureProgressText" class="text-xs text-slate-500">0%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Or enter URL manually -->
                            <div class="mt-3">
                                <p class="text-xs text-slate-500 mb-1">Or enter a URL directly:</p>
                                <input type="text" id="cta_brochure_url"
                                       class="w-full p-2 border rounded-lg text-sm"
                                       placeholder="e.g., assets_system/documents/company-brochure.pdf"
                                       value="<?= htmlspecialchars($current_brochure) ?>"
                                       onchange="document.getElementById('cta_brochure_value').value = this.value">
                            </div>
                        </div>

                        <!-- Button Labels -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Primary Button Label</label>
                                <input type="text" name="cta_btn_primary" id="cta_btn_primary"
                                       class="w-full mt-1 p-2 border rounded-lg"
                                       value="<?php echo isset($cms_data['cta_btn_primary']['content']) ? htmlspecialchars($cms_data['cta_btn_primary']['content']) : 'Schedule Consultation'; ?>"
                                       placeholder="Schedule Consultation">
                            </div>
                            <div>
                                <label class="text-xs font-bold text-slate-500 uppercase">Brochure Button Label</label>
                                <input type="text" name="cta_btn_brochure" id="cta_btn_brochure"
                                       class="w-full mt-1 p-2 border rounded-lg"
                                       value="<?php echo isset($cms_data['cta_btn_brochure']['content']) ? htmlspecialchars($cms_data['cta_btn_brochure']['content']) : 'Download Brochure'; ?>"
                                       placeholder="Download Brochure">
                            </div>
                        </div>
                    </div>
                </section>

                <!-- New Products Section (MOVED TO BOTTOM) -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">🆕 New Products Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Badge -->
                        <div  style="display: none;">
                            <label class="text-xs font-bold text-slate-500 uppercase">Badge Text</label>
                            <input type="text" name="new_badge" class="w-full mt-1 p-2 border rounded-lg" 
                                   value="<?php echo isset($cms_data['new_badge']['content']) ? $cms_data['new_badge']['content'] : ''; ?>" 
                                   placeholder="e.g., New & Improved">
                        </div>
                        
                        <!-- Header -->
                        <div  style="display: none;">
                            <label class="text-xs font-bold text-slate-500 uppercase">Section Header</label>
                            <input type="text" name="new_product_header" class="w-full mt-1 p-2 border rounded-lg" 
                                   value="<?php echo isset($cms_data['new_product_header']['content']) ? $cms_data['new_product_header']['content'] : ''; ?>" 
                                   placeholder="e.g., New Products">
                        </div>
                        
                        <!-- Text Content -->
                        <div style="display: none;">
                            <label class="text-xs font-bold text-slate-500 uppercase">Description Text</label>
                            <textarea name="new_product_text" class="w-full mt-1 p-2 border rounded-lg" rows="4" 
                                      placeholder="Description text here..."><?php echo isset($cms_data['new_product_text']['content']) ? $cms_data['new_product_text']['content'] : ''; ?></textarea>
                        </div>
                        
                        <!-- Button Text -->
                        <div style="display: none;">
                            <label class="text-xs font-bold text-slate-500 uppercase">Button Text</label>
                            <input type="text" name="new_product_button" class="w-full mt-1 p-2 border rounded-lg" 
                                   value="<?php echo isset($cms_data['new_product_button']['content']) ? $cms_data['new_product_button']['content'] : ''; ?>" 
                                   placeholder="e.g., Explore Safety Solutions">
                        </div>
                        
                        <!-- Main Product Image -->
                        <div class="border-t pt-6 mt-6" style="display: none">
                            <label class="text-xs font-bold text-slate-500 uppercase mb-4 block" style="display: none">Main Product Image</label>
                            <div class="space-y-4" style="display: none">
                                <!-- Current Image Display -->
                                <div id="currentMainImageContainer" class="<?php echo empty($cms_data['new_product_image']['image']) ? 'hidden' : ''; ?>">
                                    <div class="border rounded-lg p-4">
                                        <p class="text-xs text-slate-600 mb-2">Current Image:</p>
                                        <div class="flex items-center gap-4">
                                            <img src="<?php echo !empty($cms_data['new_product_image']['image']) ? base_url('assets_system/images/' . $cms_data['new_product_image']['image']) : ''; ?>" 
                                                 alt="Current New Product Image" 
                                                 class="w-32 h-32 object-contain rounded-lg border">
                                            <div>
                                                <input type="hidden" name="existing_new_product_image" 
                                                       value="<?php echo !empty($cms_data['new_product_image']['image']) ? $cms_data['new_product_image']['image'] : ''; ?>">
                                                <button type="button" 
                                                        class="change-main-image-btn px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-semibold hover:bg-indigo-100 transition-all border border-indigo-200">
                                                    <i class="fas fa-upload mr-2"></i>Change this image
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Upload Field -->
                                <div id="mainProductUploadContainer" style="display: none" class="<?php echo !empty($cms_data['new_product_image']['image']) ? 'hidden' : ''; ?>">
                                    <div class="border rounded-lg p-4">
                                        <p class="text-xs text-slate-600 mb-2">Upload New Image:</p>
                                        <input type="file" name="new_product_image_file" 
                                               class="w-full p-2 border rounded-lg file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                               accept="image/*">
                                        <p class="text-xs text-slate-500 mt-2">Upload new image (JPG, PNG, GIF - max 2MB)</p>
                                        <?php if (!empty($cms_data['new_product_image']['image'])): ?>
                                        <div class="flex justify-end mt-3">
                                            <button type="button" 
                                                    class="cancel-main-upload-btn px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-200 transition-all">
                                                Cancel
                                            </button>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Features Section -->
                        <div class="border-t pt-6 mt-6">
                            <div class="flex justify-between items-center mb-4">
                                <label class="text-xs font-bold text-slate-500 uppercase">Product Features (Maximum 4)</label>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <?php for ($i = 1; $i <= 4; $i++): ?>
                                <div class="border border-slate-200 rounded-lg p-4">
                                    <h4 class="text-sm font-semibold text-slate-700 mb-3">Feature <?php echo $i; ?></h4>
                                    
                                    <!-- Feature Title -->
                                    <div class="mb-3">
                                        <label class="text-xs text-slate-600 mb-1 block">Feature Title</label>
                                        <input type="text" name="new_prod_feat_<?php echo $i; ?>" 
                                               class="w-full p-2 border rounded-lg text-sm"
                                               value="<?php echo isset($cms_data['new_prod_feat_'.$i]['content']) ? $cms_data['new_prod_feat_'.$i]['content'] : ''; ?>"
                                               placeholder="e.g., High Durability">
                                    </div>
                                    
                                    <!-- Feature Image -->
                                    <div>
                                        <label class="text-xs text-slate-600 mb-1 block">Feature Image</label>
                                        <div class="space-y-2">
                                            <!-- Current Feature Image -->
                                            <div id="currentFeatImageContainer_<?php echo $i; ?>" class="<?php echo empty($cms_data['feat_image_'.$i]['image']) ? 'hidden' : ''; ?>">
                                                <div class="border rounded-lg p-3 mb-2">
                                                    <div class="flex items-center gap-3">
                                                        <img src="<?php echo !empty($cms_data['feat_image_'.$i]['image']) ? base_url('assets_system/images/' . $cms_data['feat_image_'.$i]['image']) : ''; ?>" 
                                                             alt="Feature Image <?php echo $i; ?>" 
                                                             class="w-16 h-16 object-cover rounded border">
                                                        <div>
                                                            <input type="hidden" name="existing_feat_image_<?php echo $i; ?>" 
                                                                   value="<?php echo !empty($cms_data['feat_image_'.$i]['image']) ? $cms_data['feat_image_'.$i]['image'] : ''; ?>">
                                                            <button type="button" 
                                                                    class="change-feat-image-btn px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded text-xs font-semibold hover:bg-indigo-100 transition-all border border-indigo-200"
                                                                    data-feat-index="<?php echo $i; ?>">
                                                                <i class="fas fa-upload mr-1"></i>Change this image
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Upload Field for Feature -->
                                            <div id="featUploadContainer_<?php echo $i; ?>" class="<?php echo empty($cms_data['feat_image_'.$i]['image']) ? '' : 'hidden'; ?>">
                                                <input type="file" name="feat_image_<?php echo $i; ?>_file" 
                                                       class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                                       accept="image/*">
                                                <?php if (!empty($cms_data['feat_image_'.$i]['image'])): ?>
                                                <div class="flex justify-end mt-2">
                                                    <button type="button" 
                                                            class="cancel-feat-upload-btn px-3 py-1 bg-slate-100 text-slate-700 rounded text-xs font-semibold hover:bg-slate-200 transition-all"
                                                            data-feat-index="<?php echo $i; ?>">
                                                        Cancel
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        
                        <div class="border-t pt-6 mt-6">
                            <button type="button" id="saveNewProductsBtn" class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition-all">
                                Save New Products Section
                            </button>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</main>

<script src="<?php echo base_url('assets_system/vendor/jquery/jquery-3.7.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

<script>
// ============ BROCHURE UPLOAD ============
function uploadBrochureFile(input) {
    const file = input.files[0];
    if (!file) return;

    if (file.size > 10 * 1024 * 1024) {
        alert('File must be less than 10MB');
        input.value = '';
        return;
    }

    const progress = document.getElementById('brochureUploadProgress');
    const progressBar = document.getElementById('brochureProgressBar');
    const progressText = document.getElementById('brochureProgressText');
    progress.classList.remove('hidden');

    const formData = new FormData();
    formData.append('download_file', file);

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '<?= site_url("cms/upload_download_file") ?>', true);

    xhr.upload.onprogress = function(e) {
        if (e.lengthComputable) {
            const pct = Math.round((e.loaded / e.total) * 100);
            progressBar.style.width = pct + '%';
            progressText.textContent = pct + '%';
        }
    };

    xhr.onload = function() {
        progress.classList.add('hidden');
        try {
            const res = JSON.parse(xhr.responseText);
            if (res.success) {
                document.getElementById('cta_brochure_value').value = res.file_url;
                document.getElementById('cta_brochure_url').value = res.file_url;
                document.getElementById('currentBrochureName').textContent = res.original_name;
                document.getElementById('currentBrochureLink').href = '<?= base_url() ?>' + res.file_url;
                document.getElementById('currentBrochureInfo').classList.remove('hidden');
                document.getElementById('brochureUploadArea').classList.add('hidden');
            } else {
                alert('Upload failed: ' + (res.message || 'Unknown error'));
            }
        } catch(e) {
            alert('Upload failed. Please try again.');
        }
    };

    xhr.onerror = function() {
        progress.classList.add('hidden');
        alert('Upload failed. Please check your connection.');
    };

    xhr.send(formData);
}

function removeBrochure() {
    document.getElementById('cta_brochure_value').value = '';
    document.getElementById('cta_brochure_url').value = '';
    document.getElementById('currentBrochureInfo').classList.add('hidden');
    document.getElementById('brochureUploadArea').classList.remove('hidden');
    document.getElementById('brochureFileInput').value = '';
}

// ============ ACHIEVEMENTS MANAGEMENT ============

// Add new achievement
$('#addAchievementBtn').click(function() {
    const timestamp = new Date().getTime();
    const newAchievementId = 'new_' + timestamp;
    
    const newAchievement = `
        <div class="achievement-item p-4 border rounded-lg bg-slate-50 animate-fadeIn" data-id="${newAchievementId}">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-10">
                    <input type="hidden" name="achievement_id[]" value="${newAchievementId}">
                    
                    <div class="grid grid-cols-2 gap-3 mb-3">
                        <div>
                            <label class="text-xs text-slate-600 mb-1 block">Title</label>
                            <input type="text" name="achievement_title_${newAchievementId}" 
                                   class="achievement-title w-full p-2 border rounded text-sm" 
                                   value="" 
                                   placeholder="e.g., Foundation">
                        </div>
                        <div>
                            <label class="text-xs text-slate-600 mb-1 block">Year</label>
                            <input type="text" name="achievement_year_${newAchievementId}" 
                                   class="achievement-year w-full p-2 border rounded text-sm" 
                                   value="" 
                                   placeholder="e.g., 1953">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="text-xs text-slate-600 mb-1 block">Content</label>
                        <textarea name="achievement_content_${newAchievementId}" 
                                  class="achievement-content w-full p-2 border rounded text-sm" 
                                  rows="2" 
                                  placeholder="Achievement description"></textarea>
                    </div>
                    
                    <div class="mb-3" style="display: none">
                        <label class="text-xs text-slate-600 mb-1 block">Sort Order</label>
                        <input type="number" name="achievement_sort_${newAchievementId}" 
                               class="achievement-sort w-24 p-2 border rounded text-sm" 
                               value="0" 
                               placeholder="0">
                    </div>
                    
                    <!-- Image Upload -->
                    <div class="mt-2">
                        <label class="text-xs text-slate-600 mb-1 block">Achievement Image</label>
                        <div class="space-y-2">
                            <div id="achievementImageUploadContainer_${newAchievementId}">
                                <input type="file" name="achievement_image_file_${newAchievementId}" 
                                       class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                       accept="image/*">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Icon Upload -->
                    <div class="mt-2" style="display: none">
                        <label class="text-xs text-slate-600 mb-1 block">Icon (Optional)</label>
                        <div class="space-y-2">
                            <div id="achievementIconUploadContainer_${newAchievementId}">
                                <input type="file" name="achievement_icon_file_${newAchievementId}" 
                                       class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                       accept="image/*">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Active Status -->
                    <div class="mt-3 flex items-center">
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" name="achievement_active_${newAchievementId}" 
                                   class="achievement-active w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                   checked>
                            <span class="ml-2 text-xs text-slate-600">Active</span>
                        </label>
                    </div>
                </div>
                <div class="col-span-2 flex items-end justify-end">
                    <button type="button" class="delete-achievement-btn px-3 py-2 bg-red-100 text-red-600 rounded text-sm font-semibold hover:bg-red-200" data-id="${newAchievementId}">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    `;
    
    $('#achievementsContainer').append(newAchievement);
    
    // Scroll to the new achievement
    $('html, body').animate({
        scrollTop: $('.achievement-item').last().offset().top - 100
    }, 500);
});

// Delete achievement
$(document).on('click', '.delete-achievement-btn', function() {
    const $item = $(this).closest('.achievement-item');
    const achievementId = $(this).data('id');
    
    if(achievementId && !achievementId.toString().startsWith('new_')) {
        Swal.fire({
            title: 'Delete this achievement?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo base_url('cms/delete_achievement'); ?>",
                    type: "POST",
                    data: {
                        id: achievementId,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if(res.status === 'success') {
                            $item.remove();
                            Swal.fire('Deleted!', res.message, 'success');
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to delete achievement', 'error');
                    }
                });
            }
        });
    } else {
        $item.remove();
        Swal.fire('Removed!', 'Achievement removed from form.', 'success');
    }
});

// Achievement image change handlers
$(document).on('click', '.change-achievement-image-btn', function() {
    const achievementId = $(this).data('achievement-id');
    $(`#currentAchievementImageContainer_${achievementId}`).addClass('hidden');
    $(`#achievementImageUploadContainer_${achievementId}`).removeClass('hidden');
});

$(document).on('click', '.cancel-achievement-upload-btn', function() {
    const achievementId = $(this).data('achievement-id');
    $(`#achievementImageUploadContainer_${achievementId}`).addClass('hidden');
    $(`#currentAchievementImageContainer_${achievementId}`).removeClass('hidden');
    $(`input[name="achievement_image_file_${achievementId}"]`).val('');
});

// Achievement icon change handlers
$(document).on('click', '.change-achievement-icon-btn', function() {
    const achievementId = $(this).data('achievement-id');
    $(`#currentAchievementIconContainer_${achievementId}`).addClass('hidden');
    $(`#achievementIconUploadContainer_${achievementId}`).removeClass('hidden');
});

$(document).on('click', '.cancel-achievement-icon-upload-btn', function() {
    const achievementId = $(this).data('achievement-id');
    $(`#achievementIconUploadContainer_${achievementId}`).addClass('hidden');
    $(`#currentAchievementIconContainer_${achievementId}`).removeClass('hidden');
    $(`input[name="achievement_icon_file_${achievementId}"]`).val('');
});

// Save achievements
$('#saveAchievementsBtn').click(function() {
    Swal.fire({
        title: 'Saving achievements...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    const formData = new FormData();
    formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    const achievements = [];
    
    $('.achievement-item').each(function(index) {
        const $item = $(this);
        const achievementId = $item.data('id');
        
        // Collect achievement data
        const achievementData = {
            id: achievementId,
            title: $(`.achievement-title`, $item).val() || '',
            year: $(`.achievement-year`, $item).val() || '',
            content: $(`.achievement-content`, $item).val() || '',
            sort_order: $(`.achievement-sort`, $item).val() || 0,
            is_active: $(`.achievement-active`, $item).is(':checked') ? 1 : 0
        };
        
        achievements.push(achievementData);
        
        // Add to FormData
        formData.append(`achievements[${index}][id]`, achievementId);
        formData.append(`achievements[${index}][title]`, achievementData.title);
        formData.append(`achievements[${index}][year]`, achievementData.year);
        formData.append(`achievements[${index}][content]`, achievementData.content);
        formData.append(`achievements[${index}][sort_order]`, achievementData.sort_order);
        formData.append(`achievements[${index}][is_active]`, achievementData.is_active);
        
        // Handle image file
        const imageFileInput = $item.find(`input[name="achievement_image_file_${achievementId}"]`)[0];
        if (imageFileInput && imageFileInput.files[0]) {
            formData.append(`achievement_image_${achievementId}`, imageFileInput.files[0]);
        }
        
        // Handle icon file
        const iconFileInput = $item.find(`input[name="achievement_icon_file_${achievementId}"]`)[0];
        if (iconFileInput && iconFileInput.files[0]) {
            formData.append(`achievement_icon_${achievementId}`, iconFileInput.files[0]);
        }
        
        // Add existing image/icon filenames
        const existingImage = $item.find(`input[name="existing_achievement_image_${achievementId}"]`).val();
        if (existingImage) {
            formData.append(`existing_achievement_image_${achievementId}`, existingImage);
        }
        
        const existingIcon = $item.find(`input[name="existing_achievement_icon_${achievementId}"]`).val();
        if (existingIcon) {
            formData.append(`existing_achievement_icon_${achievementId}`, existingIcon);
        }
    });
    
    formData.append('achievements_json', JSON.stringify(achievements));
    
    $.ajax({
        url: "<?php echo base_url('cms/save_achievements'); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(res) {
            if(res.status === 'success') {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success!', 
                    text: res.message, 
                    timer: 2000 
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Save achievements error:', error);
            Swal.fire('Error', 'Failed to save achievements', 'error');
        }
    });
});



// ============ NEW PRODUCTS IMAGE CHANGE FUNCTIONALITY ============

// Main Product Image Change
$(document).on('click', '.change-main-image-btn', function() {
    // Hide current image container
    $('#currentMainImageContainer').addClass('hidden');
    // Show upload container
    $('#mainProductUploadContainer').removeClass('hidden');
});

// Cancel Main Image Upload
$(document).on('click', '.cancel-main-upload-btn', function() {
    // Hide upload container
    $('#mainProductUploadContainer').addClass('hidden');
    // Show current image container
    $('#currentMainImageContainer').removeClass('hidden');
    // Clear file input
    $('input[name="new_product_image_file"]').val('');
});

// Feature Image Change
$(document).on('click', '.change-feat-image-btn', function() {
    const featIndex = $(this).data('feat-index');
    
    // Hide current feature image container
    $(`#currentFeatImageContainer_${featIndex}`).addClass('hidden');
    
    // Show upload container
    $(`#featUploadContainer_${featIndex}`).removeClass('hidden');
});

// Cancel Feature Image Upload
$(document).on('click', '.cancel-feat-upload-btn', function() {
    const featIndex = $(this).data('feat-index');
    
    // Hide upload container
    $(`#featUploadContainer_${featIndex}`).addClass('hidden');
    
    // Show current feature image container
    $(`#currentFeatImageContainer_${featIndex}`).removeClass('hidden');
    
    // Clear file input
    $(`input[name="feat_image_${featIndex}_file"]`).val('');
});

// ============ SAVE NEW PRODUCTS SECTION (UPDATED) ============
$('#saveNewProductsBtn').click(function() {
    const formData = new FormData();
    
    // Add CSRF token
    formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    // Add text fields
    const textFields = [
        'new_badge',
        'new_product_header', 
        'new_product_text',
        'new_product_button'
    ];
    
    textFields.forEach(field => {
        const value = $(`[name="${field}"]`).val();
        formData.append(field, value);
    });
    
    // Add feature titles
    for (let i = 1; i <= 4; i++) {
        const value = $(`[name="new_prod_feat_${i}"]`).val();
        formData.append(`new_prod_feat_${i}`, value);
    }
    
    // Add existing images (important for database update)
    if ($('[name="existing_new_product_image"]').val()) {
        formData.append('existing_new_product_image', $('[name="existing_new_product_image"]').val());
    }
    
    // Add feature existing images
    for (let i = 1; i <= 4; i++) {
        const existingImage = $(`[name="existing_feat_image_${i}"]`).val();
        if (existingImage) {
            formData.append(`existing_feat_image_${i}`, existingImage);
        }
    }
    
    // Add main image file (THIS IS WHAT UPDATES THE DATABASE)
    const mainImageFile = $('input[name="new_product_image_file"]')[0].files[0];
    if (mainImageFile) {
        formData.append('new_product_image_file', mainImageFile);
        console.log('Main image file selected for upload:', mainImageFile.name);
    } else {
        console.log('No new main image file selected');
    }
    
    // Add feature files
    for (let i = 1; i <= 4; i++) {
        const featImageFile = $(`input[name="feat_image_${i}_file"]`)[0].files[0];
        if (featImageFile) {
            formData.append(`feat_image_${i}_file`, featImageFile);
            console.log(`Feature ${i} image file selected for upload:`, featImageFile.name);
        }
    }
    
    // Log FormData contents (for debugging)
    console.log('FormData entries:');
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ', pair[1]);
    }
    
    Swal.fire({
        title: 'Saving New Products...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    $.ajax({
        url: "<?php echo base_url('cms/save_new_products'); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(res) {
            if(res.status === 'success') {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success!', 
                    text: res.message, 
                    timer: 2000 
                }).then(() => {
                    // Refresh page after success to show updated images
                    location.reload();
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Save error:', error);
            console.error('XHR response:', xhr.responseText);
            Swal.fire('Error', 'Failed to save new products data. Check console for details.', 'error');
        }
    });
});

// ============ CAROUSEL MANAGEMENT ============
$(document).ready(function() {
    const MAX_SLIDES = 10;
    const BASE_IMG_URL = "<?= base_url('assets_system/images/'); ?>";
    
    // Load initial data from PHP
    let initialSlides = [];
    <?php if(!empty($carousel_slides)): ?>
    <?php foreach($carousel_slides as $index => $slide): ?>
        initialSlides.push({
            id: "<?= $slide['id']; ?>",
            text: "<?= addslashes($slide['hero_text']) ?>",
            subtext: "<?= addslashes($slide['hero_sub_text']) ?>",
            image: "<?= $slide['hero_image'] ?>",
            bg: "<?= $slide['hero_bg_img'] ?>"
        });
    <?php endforeach; ?>
<?php else: ?>
    initialSlides.push({id: null, text: '', subtext: '', image: '', bg: ''});
<?php endif; ?>

    function renderCarouselUI() {
        const $tabsNav = $('#carouselTabs');
        const $tabsContent = $('#carouselTabContent');
        const activeIdx = $('.tab-btn.active').data('index') || 1;

        $tabsNav.empty();
        $tabsContent.empty();

        initialSlides.forEach((slide, i) => {
            const displayIdx = i + 1;
            const isActive = displayIdx == activeIdx;

            // Render Tab
            $tabsNav.append(`
                <button type="button" data-index="${displayIdx}" class="tab-btn px-6 py-3 text-sm font-medium border-b-2 transition-all whitespace-nowrap ${isActive ? 'border-indigo-600 text-indigo-600 active' : 'border-transparent text-slate-400 hover:text-slate-600'}">
                    Slide ${displayIdx}
                </button>
            `);

            // Render Pane with Unique Text Inputs
            $tabsContent.append(`
                <div id="pane_${displayIdx}" class="tab-pane ${isActive ? '' : 'hidden'} animate-fadeIn">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-indigo-50/30 p-4 rounded-xl border border-indigo-100/50">
                            <div>
                                <label class="text-[10px] font-bold text-indigo-600 uppercase">Slide ${displayIdx} Title</label>
                                <input name="hero_text_${displayIdx}" type="text" class="w-full mt-1 p-2 border rounded-lg bg-white" value="${slide.text}" placeholder="Main Heading">
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-indigo-600 uppercase">Slide ${displayIdx} Sub-text</label>
                                <textarea name="hero_sub_text_${displayIdx}" class="w-full mt-1 p-2 border rounded-lg bg-white" rows="1" placeholder="Short description">${slide.subtext}</textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 mb-1 block uppercase">Foreground Image (PNG)</label>
                                <div class="flex items-center gap-2 mb-2">
                                    <input name="hero_image_${displayIdx}" type="text" class="w-full p-2 text-xs border rounded bg-white" value="${slide.image}" readonly>
                                    <label class="cursor-pointer bg-white hover:bg-slate-100 px-3 py-2 text-xs rounded border shadow-sm">
                                        📁 <input type="file" class="hidden upload-file" data-target="hero_image_${displayIdx}" accept="image/*">
                                    </label>
                                </div>
                                <div class="preview-container">${renderPreview(slide.image)}</div>
                            </div>
                            <div>
                                <label class="text-[10px] font-bold text-slate-500 mb-1 block uppercase">Background Image</label>
                                <div class="flex items-center gap-2 mb-2">
                                    <input name="hero_bg_img_${displayIdx}" type="text" class="w-full p-2 text-xs border rounded bg-white" value="${slide.bg}" readonly>
                                    <label class="cursor-pointer bg-white hover:bg-slate-100 px-3 py-2 text-xs rounded border shadow-sm">
                                        📁 <input type="file" class="hidden upload-file" data-target="hero_bg_img_${displayIdx}" accept="image/*">
                                    </label>
                                </div>
                                <div class="preview-container">${renderPreview(slide.bg)}</div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                           ${initialSlides.length > 1 ? `
<button type="button" class="delete-slide text-red-500 text-xs font-bold flex items-center gap-1 hover:underline" 
        data-array-index="${i}" 
        data-slide-id="${slide.id || ''}">
    <span>🗑️</span> Remove Slide ${displayIdx}
</button>` : ''}
                        </div>
                    </div>
                </div>
            `);
        });

        $('#carousel_count').val(initialSlides.length);
    }

   function renderPreview(filename) {
    if(!filename) return '<div class="h-20 flex items-center justify-center border-dashed border-2 rounded text-[10px] text-slate-300 bg-white">No Image Selected</div>';
    
    // Ensure the path is prefixed correctly
    const fullPath = "<?= base_url('assets_system/images/'); ?>/" + filename;

    return `
        <div class="mt-2">
            <div class="w-full h-20 bg-white rounded border overflow-hidden flex items-center justify-center shadow-inner">
                <img src="${fullPath}" class="max-w-full max-h-full object-contain">
            </div>
            <div class="text-[10px] text-slate-400 mt-1 truncate px-1">${filename}</div>
        </div>
    `;
}

    // Capture values before any re-render
    function syncArrayData() {
        initialSlides.forEach((slide, i) => {
            const displayIdx = i + 1;
            slide.text = $(`input[name="hero_text_${displayIdx}"]`).val() || '';
            slide.subtext = $(`textarea[name="hero_sub_text_${displayIdx}"]`).val() || '';
            slide.image = $(`input[name="hero_image_${displayIdx}"]`).val() || '';
            slide.bg = $(`input[name="hero_bg_img_${displayIdx}"]`).val() || '';
        });
    }

    // UI Events
    $(document).on('click', '.tab-btn', function() {
        $('.tab-btn').removeClass('border-indigo-600 text-indigo-600 active').addClass('border-transparent text-slate-400');
        $(this).addClass('border-indigo-600 text-indigo-600 active').removeClass('border-transparent text-slate-400');
        $('.tab-pane').addClass('hidden');
        $(`#pane_${$(this).data('index')}`).removeClass('hidden');
    });

    $('#addSlideBtn').click(function() {
        if(initialSlides.length < MAX_SLIDES) {
            syncArrayData();
            initialSlides.push({text: '', subtext: '', image: '', bg: ''});
            renderCarouselUI();
            $(`.tab-btn[data-index="${initialSlides.length}"]`).click();
        }
    });

    $(document).on('click', '.delete-slide', function() {
    const arrIdx = $(this).data('array-index');
    const slideId = $(this).data('slide-id');
    const displayIdx = arrIdx + 1;
    
    Swal.fire({
        title: 'Delete this slide?',
        text: 'This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        confirmButtonText: 'Yes, delete it'
    }).then((res) => {
        if(res.isConfirmed) {
            // Show loading
            Swal.showLoading();
            
            // Prepare data with CSRF token
            const postData = {
                slide_id: slideId,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };
            
            $.ajax({
                url: "<?= base_url('cms/delete_carousel_slide'); ?>",
                type: "POST",
                data: postData,
                dataType: "JSON",
                success: function(res) {
                    if(res.status === 'success') {
                        // I-sync at i-update ang UI
                        syncArrayData();
                        initialSlides.splice(arrIdx, 1);
                        renderCarouselUI();
                        $(`.tab-btn[data-index="1"]`).click();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: res.message || 'Slide has been removed.',
                            timer: 1500
                        });
                    } else {
                        Swal.fire('Error', res.message || 'Failed to delete slide', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    Swal.fire(
                        'Server Error',
                        'Please check console for details or contact administrator.',
                        'error'
                    );
                }
            });
        }
    });
});

    // File Upload and Form Submit logic remains the same as previous version...
    $(document).on('change', '.upload-file', function(e) {
        const targetName = $(this).data('target');
        const file = e.target.files[0];
        if (!file) return;
        const formData = new FormData();
        formData.append('image', file);
        formData.append('field_name', targetName);
        formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
        Swal.fire({ title: 'Uploading...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
        $.ajax({
            url: "<?= base_url('cms/home_upload_image'); ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            success: function(res) {
                if(res.status === 'success') {
                    $(`input[name="${targetName}"]`).val(res.filename);
                    const $previewContainer = $(`input[name="${targetName}"]`).closest('div').next();
                    $previewContainer.html(renderPreview(res.filename));
                    Swal.close();
                }
            }
        });
    });


    renderCarouselUI();
});

// ============ SERVICES IMAGE CHANGE HANDLERS ============
$(document).on('click', '.change-service-image-btn', function() {
    const serviceIndex = $(this).data('service-index');
    $(`#currentServiceImageContainer_${serviceIndex}`).addClass('hidden');
    $(`#serviceUploadContainer_${serviceIndex}`).removeClass('hidden');
});

$(document).on('click', '.cancel-service-upload-btn', function() {
    const serviceIndex = $(this).data('service-index');
    $(`#serviceUploadContainer_${serviceIndex}`).addClass('hidden');
    $(`#currentServiceImageContainer_${serviceIndex}`).removeClass('hidden');
    $(`input[name="service_image_file_${serviceIndex}"]`).val('');
});

// ============ FORM SUBMIT HANDLER ============
$(document).ready(function() {
    // Attach click handler to Save All Changes button
    $('#saveAllChanges').click(function(e) {
        e.preventDefault();
        saveAllChanges();
    });
});

function saveAllChanges() {
    // First sync carousel data
    if (typeof syncArrayData === 'function') {
        syncArrayData();
    }
    
    Swal.fire({ 
        title: 'Saving All Changes...', 
        allowOutsideClick: false, 
        didOpen: () => { Swal.showLoading(); } 
    });
    
    // Create FormData to handle file uploads
    const formData = new FormData();
    
    // Add CSRF token
    formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    // Add carousel_count
    if ($('#carousel_count').length) {
        formData.append('carousel_count', $('#carousel_count').val());
    }
    
    // Add legacy content fields
    const legacyFields = ['trusted_badge', 'legacy_header', 'legacy_text', 'timeline_years', 'timeline_label'];
    legacyFields.forEach(field => {
        if ($(`[name="${field}"]`).length) {
            formData.append(field, $(`[name="${field}"]`).val());
        }
    });
    
    // Add categories (array inputs)
    $('input[name="category_title[]"]').each(function(index) {
        formData.append('category_title[]', $(this).val());
        formData.append('category_id[]', $(this).closest('.category-item').find('input[name="category_id[]"]').val());
    });
    
    $('textarea[name="category_text[]"]').each(function(index) {
        formData.append('category_text[]', $(this).val());
    });
    
    // Add statistics (array inputs)
    $('input[name="stat_number[]"]').each(function(index) {
        formData.append('stat_number[]', $(this).val());
        formData.append('stat_id[]', $(this).closest('.stat-item').find('input[name="stat_id[]"]').val());
    });
    
    $('input[name="stat_label[]"]').each(function(index) {
        formData.append('stat_label[]', $(this).val());
    });
    
    // Add carousel data
    for (let i = 1; i <= ($('#carousel_count').val() || 1); i++) {
        if ($(`input[name="hero_text_${i}"]`).length) {
            formData.append(`hero_text_${i}`, $(`input[name="hero_text_${i}"]`).val());
            formData.append(`hero_sub_text_${i}`, $(`textarea[name="hero_sub_text_${i}"]`).val());
            formData.append(`hero_image_${i}`, $(`input[name="hero_image_${i}"]`).val());
            formData.append(`hero_bg_img_${i}`, $(`input[name="hero_bg_img_${i}"]`).val());
        }
    }
    
     console.log("=== DEBUG FEATURES ===");
    for (let i = 1; i <= 3; i++) {
        const featuresElement = $(`textarea[name="service_features_${i}"]`);
        console.log(`Service ${i} features element found:`, featuresElement.length > 0);
        console.log(`Service ${i} features value:`, featuresElement.val());
    }
    
    // Add services data
    formData.append('services_tagline', $('#services_tagline').val());
    
    // Add services data for each service (1-3)
    for (let i = 1; i <= 3; i++) {
        formData.append('service_title_' + i, $(`input[name="service_title_${i}"]`).val() || '');
        formData.append('service_badge_' + i, $(`input[name="service_badge_${i}"]`).val() || '');
        formData.append('service_description_' + i, $(`textarea[name="service_description_${i}"]`).val() || '');
        formData.append('service_link_label_' + i, $(`input[name="service_link_label_${i}"]`).val() || '');
        formData.append('service_featured_badge_' + i, $(`input[name="service_featured_badge_${i}"]`).val() || '');
        
        // ALWAYS send features (even if empty)
        const featuresTextarea = $(`textarea[name="service_features_${i}"]`);
        formData.append('service_features_' + i, featuresTextarea.val() || '');
        
        console.log(`Service ${i} features sent:`, featuresTextarea.val());
    }
    
    // Add CTA / Brochure data
    const ctaFields = ['cta_heading', 'cta_subtitle', 'cta_btn_primary', 'cta_btn_brochure'];
    ctaFields.forEach(field => {
        if ($(`#${field}`).length) {
            formData.append(field, $(`#${field}`).val() || '');
        }
    });
    formData.append('cta_brochure', $('#cta_brochure_value').val() || '');

    // Add new products data
    const newProductFields = ['new_badge', 'new_product_header', 'new_product_text', 'new_product_button'];
    newProductFields.forEach(field => {
        if ($(`[name="${field}"]`).length) {
            formData.append(field, $(`[name="${field}"]`).val() || '');
        }
    });
    
    // Add new product features
    for (let i = 1; i <= 4; i++) {
        if ($(`[name="new_prod_feat_${i}"]`).length) {
            formData.append(`new_prod_feat_${i}`, $(`[name="new_prod_feat_${i}"]`).val() || '');
        }
    }
    
    // Add service image files
    for (let i = 1; i <= 3; i++) {
        const fileInput = $(`input[name="service_image_file_${i}"]`)[0];
        if (fileInput && fileInput.files[0]) {
            formData.append(`service_image_file_${i}`, fileInput.files[0]);
        }
    }
    
    // Add new product image files
    const mainImageFile = $('input[name="new_product_image_file"]')[0];
    if (mainImageFile && mainImageFile.files[0]) {
        formData.append('new_product_image_file', mainImageFile.files[0]);
    }
    
    // Add feature image files
    for (let i = 1; i <= 4; i++) {
        const featFileInput = $(`input[name="feat_image_${i}_file"]`)[0];
        if (featFileInput && featFileInput.files[0]) {
            formData.append(`feat_image_${i}_file`, featFileInput.files[0]);
        }
    }
    
    // Add existing image filenames
    for (let i = 1; i <= 3; i++) {
        const existingImage = $(`input[name="existing_service_image_${i}"]`).val();
        if (existingImage) {
            formData.append(`existing_service_image_${i}`, existingImage);
        }
    }
    
    if ($('[name="existing_new_product_image"]').val()) {
        formData.append('existing_new_product_image', $('[name="existing_new_product_image"]').val());
    }
    
    for (let i = 1; i <= 4; i++) {
        const existingFeatImage = $(`[name="existing_feat_image_${i}"]`).val();
        if (existingFeatImage) {
            formData.append(`existing_feat_image_${i}`, existingFeatImage);
        }
    }
    
    // Debug: Log what's being sent
    console.log('Sending FormData with entries:');
    for (let pair of formData.entries()) {
        if (pair[0] !== '<?php echo $this->security->get_csrf_token_name(); ?>') {
            console.log(pair[0] + ': ', pair[1]);
        }
    }
    
    // Send AJAX request
    $.ajax({
        url: "<?= base_url('cms/save_home_changes'); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(res) {
            console.log('Response:', res);
            if(res.status === 'success') {
                // Clear file inputs after successful save
                $('input[type="file"]').val('');
                
                // Update image previews for services
                for (let i = 1; i <= 3; i++) {
                    const fileInput = $(`input[name="service_image_file_${i}"]`);
                    if (fileInput[0] && fileInput[0].files.length > 0) {
                        // If image was uploaded, show the current image container
                        $(`#currentServiceImageContainer_${i}`).removeClass('hidden');
                        $(`#serviceUploadContainer_${i}`).addClass('hidden');
                    }
                }
                
                // Update image previews for new products
                if ($('input[name="new_product_image_file"]')[0].files.length > 0) {
                    $('#currentMainImageContainer').removeClass('hidden');
                    $('#mainProductUploadContainer').addClass('hidden');
                }
                
                // Update image previews for features
                for (let i = 1; i <= 4; i++) {
                    const featFileInput = $(`input[name="feat_image_${i}_file"]`);
                    if (featFileInput[0] && featFileInput[0].files.length > 0) {
                        $(`#currentFeatImageContainer_${i}`).removeClass('hidden');
                        $(`#featUploadContainer_${i}`).addClass('hidden');
                    }
                }
                
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success!', 
                    text: res.message, 
                    timer: 2000 
                });
            } else {
                Swal.fire('Error', res.message || 'Failed to save changes', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.error('Save error:', error);
            console.error('XHR response:', xhr.responseText);
            Swal.fire('Error', 'Failed to save changes. Please try again.', 'error');
        }
    });
}

// ============ CATEGORY ICON UPLOAD HANDLERS ============
$(document).on('click', '.change-category-icon-btn', function() {
    const categoryId = $(this).data('category-id');
    $(`#currentCategoryIconContainer_${categoryId}`).addClass('hidden');
    $(`#categoryIconUploadContainer_${categoryId}`).removeClass('hidden');
});

$(document).on('click', '.cancel-category-upload-btn', function() {
    const categoryId = $(this).data('category-id');
    $(`#categoryIconUploadContainer_${categoryId}`).addClass('hidden');
    $(`#currentCategoryIconContainer_${categoryId}`).removeClass('hidden');
    $(`input[name="category_icon_file_${categoryId}"]`).val('');
});

// ============ UPDATE THE ADD CATEGORY BUTTON FUNCTION ============
$('#addCategoryBtn').click(function() {
    const timestamp = new Date().getTime();
    const newCategoryId = 'new_' + timestamp;
    
    const newCategory = `
        <div class="category-item p-4 border rounded-lg bg-slate-50 animate-fadeIn">
            <div class="grid grid-cols-12 gap-3">
                <div class="col-span-10">
                    <input type="hidden" name="category_id[]" value="${newCategoryId}">
                    <input type="text" name="category_title[]" class="w-full p-2 border rounded mb-2" placeholder="Category Title" required>
                    <textarea name="category_text[]" class="w-full p-2 border rounded text-sm" rows="2" placeholder="Category description"></textarea>
                    
                    <!-- Icon upload for new category -->
                    <div class="mt-2">
                        <label class="text-xs text-slate-600 mb-1 block">Category Icon</label>
                        <div class="space-y-2">
                            <div id="categoryIconUploadContainer_${newCategoryId}">
                                <input type="file" name="category_icon_file_${newCategoryId}" 
                                       class="w-full p-2 border rounded-lg text-sm file:mr-2 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" 
                                       accept="image/*">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-2 flex items-end">
                    <button type="button" class="delete-category-btn px-3 py-2 bg-red-100 text-red-600 rounded text-sm font-semibold hover:bg-red-200" data-id="${newCategoryId}">
                        Delete
                    </button>
                </div>
            </div>
        </div>
    `;
    $('#categoriesContainer').append(newCategory);
    
    // Scroll to the new category
    $('html, body').animate({
        scrollTop: $('.category-item').last().offset().top - 100
    }, 500);
});

$(document).on('click', '.delete-category-btn', function() {
    const $item = $(this).closest('.category-item');
    const categoryId = $(this).data('id') || $item.find('input[name="category_id[]"]').val();
    
    if(categoryId) {
        Swal.fire({
            title: 'Delete this category?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If it's a new category (not saved yet), just remove from DOM
                if (categoryId.toString().startsWith('new_')) {
                    $item.remove();
                    Swal.fire('Deleted!', 'Category removed.', 'success');
                    return;
                }
                
                // Otherwise, delete from server
                $.ajax({
                    url: "<?php echo base_url('cms/delete_card'); ?>",
                    type: "POST",
                    data: {
                        id: categoryId,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if(res.status === 'success') {
                            $item.remove();
                            Swal.fire('Deleted!', res.message, 'success');
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to delete category', 'error');
                    }
                });
            }
        });
    } else {
        $item.remove();
    }
});

$('#saveCategoriesBtn').click(function() {
    // Show loading
    Swal.fire({
        title: 'Saving categories...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    // Create FormData to handle file uploads
    const formData = new FormData();
    
    // Add CSRF token
    formData.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');
    
    // Collect category data
    const categories = [];
    $('.category-item').each(function(index) {
        const $item = $(this);
        const categoryId = $item.find('input[name="category_id[]"]').val();
        
        // Add category data to array
        categories.push({
            id: categoryId || '',
            title: $item.find('input[name="category_title[]"]').val() || '',
            text: $item.find('textarea[name="category_text[]"]').val() || ''
        });
        
        // Handle icon file upload
        let iconFileInput;
        
        // Try to find the file input by name pattern first
        const fileInputByName = $item.find(`input[name="category_icon_file_${categoryId}"]`);
        if (fileInputByName.length) {
            iconFileInput = fileInputByName[0];
        } else {
            // Fallback: find any file input in this category
            iconFileInput = $item.find('input[type="file"]')[0];
        }
        
        // Add icon file if exists
        if (iconFileInput && iconFileInput.files && iconFileInput.files[0]) {
            formData.append(`category_icon_file_${categoryId}`, iconFileInput.files[0]);
        }
        
        // Add existing icon filename if it exists
        let existingIconInput;
        const existingInputByName = $item.find(`input[name="existing_category_icon_${categoryId}"]`);
        if (existingInputByName.length) {
            existingIconInput = existingInputByName;
        } else {
            // Fallback: find any existing icon input
            existingIconInput = $item.find('input[name^="existing_category_icon_"]');
        }
        
        if (existingIconInput.length && existingIconInput.val()) {
            formData.append(`existing_category_icon_${categoryId}`, existingIconInput.val());
        }
    });
    
    // Add categories JSON data
    formData.append('categories', JSON.stringify(categories));
    
    // Debug: Log what's being sent
    console.log('Saving categories. Total categories:', categories.length);
    console.log('FormData entries:');
    for (let pair of formData.entries()) {
        if (typeof pair[1] === 'string') {
            console.log(pair[0] + ': ', pair[1].substring(0, 100) + (pair[1].length > 100 ? '...' : ''));
        } else {
            console.log(pair[0] + ': ', pair[1]);
        }
    }
    
    // Send AJAX request
    $.ajax({
        url: "<?php echo base_url('cms/save_categories'); ?>",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function(res) {
            console.log('Save categories response:', res);
            
            if(res.status === 'success') {
                // Update category IDs in the DOM
                if(res.ids && res.ids.length > 0) {
                    $('.category-item').each(function(index) {
                        if(index < res.ids.length) {
                            const oldId = $(this).find('input[name="category_id[]"]').val();
                            const newId = res.ids[index];
                            
                            // Update the category ID
                            $(this).find('input[name="category_id[]"]').val(newId);
                            
                            // Update all elements that reference this category ID
                            updateCategoryElementIds($(this), oldId, newId);
                        }
                    });
                }
                
                // Clear file inputs after successful save
                $('.category-item input[type="file"]').each(function() {
                    $(this).val('');
                });
                
                // Show success message and reload
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success!', 
                    text: res.message, 
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Reload the page to show updated icons
                    location.reload();
                });
                
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message || 'Failed to save categories'
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Save categories error:', error);
            console.error('XHR response:', xhr.responseText);
            
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Failed to save categories. Please check console for details.'
            });
        }
    });
});

// Helper function to update all IDs in a category element
function updateCategoryElementIds($categoryItem, oldId, newId) {
    if (!oldId || !newId || oldId === newId) return;
    
    // Update file input name
    const fileInput = $categoryItem.find(`input[name="category_icon_file_${oldId}"]`);
    if (fileInput.length) {
        fileInput.attr('name', `category_icon_file_${newId}`);
    }
    
    // Update existing icon input name
    const existingIconInput = $categoryItem.find(`input[name="existing_category_icon_${oldId}"]`);
    if (existingIconInput.length) {
        existingIconInput.attr('name', `existing_category_icon_${newId}`);
    }
    
    // Update change icon button data attribute
    const changeIconBtn = $categoryItem.find('.change-category-icon-btn');
    if (changeIconBtn.length && changeIconBtn.data('category-id') === oldId) {
        changeIconBtn.data('category-id', newId);
    }
    
    // Update cancel button data attribute
    const cancelBtn = $categoryItem.find('.cancel-category-upload-btn');
    if (cancelBtn.length && cancelBtn.data('category-id') === oldId) {
        cancelBtn.data('category-id', newId);
    }
    
    // Update delete button data-id attribute
    const deleteBtn = $categoryItem.find('.delete-category-btn');
    if (deleteBtn.length && deleteBtn.data('id') === oldId) {
        deleteBtn.data('id', newId);
    }
    
    // Update container IDs
    const currentContainer = $categoryItem.find(`#currentCategoryIconContainer_${oldId}`);
    if (currentContainer.length) {
        currentContainer.attr('id', `currentCategoryIconContainer_${newId}`);
    }
    
    const uploadContainer = $categoryItem.find(`#categoryIconUploadContainer_${oldId}`);
    if (uploadContainer.length) {
        uploadContainer.attr('id', `categoryIconUploadContainer_${newId}`);
    }
}

// ============ STATISTICS MANAGEMENT ============
$('#addStatBtn').click(function() {
    const newStat = `
        <div class="stat-item p-4 border rounded-lg bg-slate-50 animate-fadeIn">
            <input type="hidden" name="stat_id[]" value="">
            <label class="text-xs text-slate-600 mb-1 block">Stat Number</label>
            <input type="text" name="stat_number[]" class="w-full p-2 border rounded mb-3 font-bold" placeholder="50K+">
            <label class="text-xs text-slate-600 mb-1 block">Stat Label</label>
            <input type="text" name="stat_label[]" class="w-full p-2 border rounded text-sm" placeholder="PRODUCTS INSTALLED">
            <div class="flex justify-end items-center mt-3">
                <button type="button" class="delete-stat-btn px-3 py-1 bg-red-100 text-red-600 rounded text-xs font-semibold hover:bg-red-200">
                    Delete
                </button>
            </div>
        </div>
    `;
    $('#statsContainer').append(newStat);
});

$(document).on('click', '.delete-stat-btn', function() {
    const $item = $(this).closest('.stat-item');
    const statId = $item.find('input[name="stat_id[]"]').val();
    
    if(statId) {
        Swal.fire({
            title: 'Delete this statistic?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "<?php echo base_url('cms/delete_stat'); ?>",
                    type: "POST",
                    data: {
                        id: statId,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    },
                    dataType: "JSON",
                    success: function(res) {
                        if(res.status === 'success') {
                            $item.remove();
                            Swal.fire('Deleted!', res.message, 'success');
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Failed to delete statistic', 'error');
                    }
                });
            }
        });
    } else {
        $item.remove();
    }
});

$('#saveStatsBtn').click(function() {
    const newStats = [];
    const updateStats = [];
    
    $('.stat-item').each(function() {
        const $item = $(this);
        const id = $item.find('input[name="stat_id[]"]').val();
        const statData = {
            stat_number: $item.find('input[name="stat_number[]"]').val(),
            stat_label: $item.find('input[name="stat_label[]"]').val()
        };
        
        if (id === 'NEW' || id === '') {
            // New stat to be added
            newStats.push(statData);
        } else {
            // Existing stat to be updated
            statData.id = id;
            updateStats.push(statData);
        }
    });
    
    Swal.fire({
        title: 'Saving statistics...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });
    
    $.ajax({
        url: "<?php echo base_url('cms/save_stats'); ?>",
        type: "POST",
        data: {
            new_stats: JSON.stringify(newStats),
            update_stats: JSON.stringify(updateStats),
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        dataType: "JSON",
        success: function(res) {
            if(res.status === 'success') {
                // Update IDs for newly added stats
                if(res.new_ids && res.new_ids.length > 0) {
                    let newIndex = 0;
                    $('.stat-item').each(function() {
                        const $item = $(this);
                        const id = $item.find('input[name="stat_id[]"]').val();
                        if (id === 'NEW' || id === '') {
                            if (newIndex < res.new_ids.length) {
                                $item.find('input[name="stat_id[]"]').val(res.new_ids[newIndex]);
                                newIndex++;
                            }
                        }
                    });
                }
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Success!', 
                    text: res.message, 
                    timer: 2000 
                });
            } else {
                Swal.fire('Error', res.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Failed to save statistics', 'error');
        }
    });
});
</script>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .animate-fadeIn { animation: fadeIn 0.3s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    .hidden { display: none !important; }
</style>