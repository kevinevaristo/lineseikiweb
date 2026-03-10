<?php $this->load->view('admin/header'); ?>

<main class="ml-64 p-8 pb-24">
    <div class="max-w-7xl mx-auto">
        <!-- Main form for existing switches -->
        <form id="safetySwitchesForm" enctype="multipart/form-data">
            
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Safety Switches Editor</h1>
                    <p class="text-slate-500 mt-1">Manage all safety switches content and images.</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?php echo base_url('safety-switches'); ?>" target="_blank" 
                       class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all">
                        <i class="fas fa-eye mr-2"></i>Preview Page
                    </a>
                    <button type="button" id="addSwitchBtn" 
                            class="px-5 py-2.5 bg-green-600 text-white rounded-xl font-semibold shadow-md shadow-green-100 hover:bg-green-700 transition-all">
                        <i class="fas fa-plus mr-2"></i>Add New Switch
                    </button>
                    <button type="submit" 
                            class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all">
                        <i class="fas fa-save mr-2"></i>Save All Changes
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8">
                <!-- Main Tabs Navigation -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 flex items-center">
                            <i class="fas fa-cogs mr-2"></i>Safety Switches Management
                        </h3>
                        <div class="text-sm text-slate-500">
                            Total: <span class="font-bold" id="totalSwitches"><?php echo count($switches); ?></span> switches
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Category Tabs -->
                        <div class="flex border-b border-slate-200 mb-6">
                            <button type="button" id="allProductsTab" 
                                    class="px-6 py-3 text-sm font-medium border-b-2 border-indigo-600 text-indigo-600 transition-all whitespace-nowrap active">
                                All Products
                            </button>
                            <button type="button" id="nonContactTab" 
                                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all whitespace-nowrap">
                                Non-contact Safety Switch
                            </button>
                            <button type="button" id="safetyRelayTab" 
                                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-slate-400 hover:text-slate-600 transition-all whitespace-nowrap">
                                Safety Relay Unit
                            </button>
                            <button type="button" id="newTabBtn" 
                                    class="px-6 py-3 text-sm font-medium border-b-2 border-transparent text-green-600 hover:text-green-700 transition-all whitespace-nowrap">
                                <i class="fas fa-plus mr-1"></i>New Switch
                            </button>
                        </div>

                        <!-- All Products Tab Content -->
                        <div id="allProductsContent" class="tab-content">
                            <!-- Tabs for individual switches -->
                            <div class="flex border-b border-slate-200 overflow-x-auto no-scrollbar mb-6" id="switchTabs">
                                <?php if (!empty($switches)): ?>
                                    <?php foreach($switches as $index => $switch): ?>
                                    <?php 
                                    // Determine category
                                    $isSafetyRelay = strpos($switch->title, 'Safety Relay Unit') !== false || strpos($switch->content, 'Safety Relay Unit') !== false;
                                    $isNonContact = strpos($switch->title, 'SS2-P-') !== false || strpos($switch->content, 'Non-contact Safety Switch') !== false;
                                    $categoryClass = $isSafetyRelay ? 'bg-blue-50 text-blue-700 border-blue-200' : ($isNonContact ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-50 text-gray-700 border-gray-200');
                                    ?>
                                    <button type="button" data-index="<?php echo $switch->id; ?>" 
                                            class="tab-btn px-4 py-2 text-sm font-medium border rounded-lg transition-all whitespace-nowrap mr-2 mb-2 <?php echo $categoryClass; ?> <?php echo $index == 0 ? 'ring-2 ring-indigo-500' : ''; ?>">
                                        <?php echo $switch->id == 1 ? 'Main Switch' : htmlspecialchars(substr($switch->title, 0, 20)) . (strlen($switch->title) > 20 ? '...' : ''); ?>
                                        <?php if($switch->id == 1): ?>
                                        <span class="ml-2 px-2 py-1 text-xs bg-indigo-100 text-indigo-800 rounded">Main</span>
                                        <?php endif; ?>
                                        <?php if($isSafetyRelay): ?>
                                        <span class="ml-2 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded">Relay</span>
                                        <?php elseif($isNonContact): ?>
                                        <span class="ml-2 px-2 py-1 text-xs bg-green-100 text-green-800 rounded">Switch</span>
                                        <?php endif; ?>
                                    </button>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Individual Switch Content -->
                            <div id="switchTabContent" class="mt-6">
                                <?php if (!empty($switches)): ?>
                                    <?php foreach($switches as $index => $switch): ?>
                                    <?php 
                                    $isSafetyRelay = strpos($switch->title, 'Safety Relay Unit') !== false || strpos($switch->content, 'Safety Relay Unit') !== false;
                                    $isNonContact = strpos($switch->title, 'SS2-P-') !== false || strpos($switch->content, 'Non-contact Safety Switch') !== false;
                                    ?>
                                    <div id="pane_<?php echo $switch->id; ?>" class="tab-pane <?php echo $index == 0 ? '' : 'hidden'; ?> animate-fadeIn">
                                        <!-- Category Badge -->
                                        <div class="mb-4">
                                            <?php if($isSafetyRelay): ?>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                                <i class="fas fa-bolt mr-1"></i>Safety Relay Unit
                                            </span>
                                            <?php elseif($isNonContact): ?>
                                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm font-medium rounded-full">
                                                <i class="fas fa-toggle-on mr-1"></i>Non-contact Safety Switch
                                            </span>
                                            <?php else: ?>
                                            <span class="px-3 py-1 bg-gray-100 text-gray-800 text-sm font-medium rounded-full">
                                                <i class="fas fa-cog mr-1"></i>General
                                            </span>
                                            <?php endif; ?>
                                        </div>
                                        
                                        <!-- Switch Editor Form -->
                                        <div class="space-y-6">
                                            <!-- Hidden ID Field -->
                                            <input type="hidden" name="id_<?php echo $switch->id; ?>" value="<?php echo $switch->id; ?>">
                                            
                                            <!-- Header -->
                                            <div class="flex justify-between items-center p-4 <?php echo $isSafetyRelay ? 'bg-blue-50/30 border-blue-100/50' : ($isNonContact ? 'bg-green-50/30 border-green-100/50' : 'bg-indigo-50/30 border-indigo-100/50'); ?> rounded-xl border">
                                                
                                                <?php if($switch->id != 1): ?>
                                                <button type="button" class="delete-switch-btn px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors text-sm font-medium"
                                                        data-id="<?php echo $switch->id; ?>" 
                                                        data-title="<?php echo htmlspecialchars($switch->title); ?>">
                                                    <i class="fas fa-trash mr-1"></i>Delete
                                                </button>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Title & Content -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                                <div>
                                                    <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Title *</label>
                                                    <input type="text" name="title_<?php echo $switch->id; ?>" 
                                                           class="w-full p-3 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                                           value="<?php echo htmlspecialchars($switch->title); ?>"
                                                           placeholder="Enter switch title"
                                                           required>
                                                </div>
                                                <div>
                                                    <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Content *</label>
                                                    <textarea name="content_<?php echo $switch->id; ?>" 
                                                              class="w-full p-3 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"
                                                              rows="4"
                                                              placeholder="Enter switch content"
                                                              required><?php echo htmlspecialchars($switch->content); ?></textarea>
                                                </div>
                                            </div>

                                            <!-- Features -->
                                            <div class="p-4 rounded-xl <?php echo $isSafetyRelay ? 'bg-blue-50 border-blue-100' : ($isNonContact ? 'bg-green-50 border-green-100' : 'bg-indigo-50 border-indigo-100'); ?>">
                                                <label class="text-xs font-bold <?php echo $isSafetyRelay ? 'text-blue-600' : ($isNonContact ? 'text-green-600' : 'text-indigo-600'); ?> mb-2 block uppercase">
                                                    Features (comma separated)
                                                    <span class="<?php echo $isSafetyRelay ? 'text-blue-400' : ($isNonContact ? 'text-green-400' : 'text-indigo-400'); ?> font-normal">Will appear as tags</span>
                                                </label>
                                                <textarea name="features_<?php echo $switch->id; ?>" 
                                                          class="w-full p-3 border <?php echo $isSafetyRelay ? 'border-blue-200' : ($isNonContact ? 'border-green-200' : 'border-indigo-200'); ?> rounded-lg bg-white focus:ring-2 <?php echo $isSafetyRelay ? 'focus:ring-blue-500 focus:border-blue-500' : ($isNonContact ? 'focus:ring-green-500 focus:border-green-500' : 'focus:ring-indigo-500 focus:border-indigo-500'); ?> outline-none transition"
                                                          rows="2"
                                                          placeholder="Plastic, Stand-alone, Safety Relay Combinable per Condition"><?php echo htmlspecialchars($switch->features); ?></textarea>
                                                <p class="text-xs <?php echo $isSafetyRelay ? 'text-blue-500' : ($isNonContact ? 'text-green-500' : 'text-indigo-500'); ?> mt-2">Separate each feature with a comma.</p>
                                            </div>

                                            <!-- Image Upload -->
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
                                                <div>
                                                    <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Current Image</label>
                                                    <div class="preview-container mt-2" id="previewContainer_<?php echo $switch->id; ?>">
                                                        <?php if (!empty($switch->image)): ?>
                                                        <div class="w-full h-64 bg-slate-50 rounded-lg border overflow-hidden flex items-center justify-center shadow-inner">
                                                            <img src="<?php echo base_url('assets_system/images/' . $switch->image); ?>" 
                                                                 class="max-w-full max-h-full object-contain"
                                                                 alt="<?php echo htmlspecialchars($switch->title); ?>">
                                                        </div>
                                                        <div class="text-xs text-slate-400 mt-2 truncate px-1">
                                                            <?php echo $switch->image; ?>
                                                        </div>
                                                        <?php else: ?>
                                                        <div class="h-64 flex flex-col items-center justify-center border-2 border-dashed border-slate-300 rounded-lg bg-white">
                                                            <i class="fas fa-image text-4xl text-slate-300 mb-3"></i>
                                                            <p class="text-sm text-slate-400">No image uploaded</p>
                                                        </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                
                                                <div>
                                                    <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Upload New Image</label>
                                                    <div class="space-y-4">
                                                        <div class="flex items-center gap-2 mb-4">
                                                            <input type="text" name="current_image_<?php echo $switch->id; ?>" 
                                                                   class="w-full p-2 text-sm border rounded bg-slate-50" 
                                                                   value="<?php echo !empty($switch->image) ? $switch->image : ''; ?>" 
                                                                   readonly>
                                                        </div>
                                                        
                                                        <div class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center hover:border-indigo-400 transition-colors">
                                                            <div class="mb-4">
                                                                <i class="fas fa-cloud-upload-alt text-3xl text-slate-400"></i>
                                                            </div>
                                                            <p class="text-slate-600 font-medium mb-2">Upload new image</p>
                                                            <p class="text-slate-500 text-xs mb-4">JPG, PNG, GIF, WebP or SVG (Max. 2MB)</p>
                                                            
                                                            <label class="cursor-pointer inline-block">
                                                                <span class="px-5 py-2.5 <?php echo $isSafetyRelay ? 'bg-blue-600 hover:bg-blue-700' : ($isNonContact ? 'bg-green-600 hover:bg-green-700' : 'bg-indigo-600 hover:bg-indigo-700'); ?> text-white rounded-lg transition-colors inline-flex items-center gap-2">
                                                                    <i class="fas fa-upload"></i>
                                                                    Choose File
                                                                </span>
                                                                <input type="file" class="hidden switch-image-upload" 
                                                                       data-switch-id="<?php echo $switch->id; ?>"
                                                                       accept="image/*">
                                                            </label>
                                                        </div>
                                                        
                                                        <div class="text-xs text-slate-500">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Image will replace the current one
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Empty State -->
                                    <div id="pane_empty" class="tab-pane animate-fadeIn">
                                        <div class="text-center py-16">
                                            <i class="fas fa-inbox text-5xl text-slate-300 mb-4"></i>
                                            <h4 class="text-lg font-medium text-slate-600 mb-2">No Safety Switches Yet</h4>
                                            <p class="text-slate-500 mb-6">Add your first safety switch to get started</p>
                                            <button type="button" id="addFirstSwitchBtn" 
                                                    class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center gap-2">
                                                <i class="fas fa-plus"></i>
                                                Add First Safety Switch
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Non-contact Safety Switch Tab Content -->
                        <div id="nonContactContent" class="tab-content hidden">
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-green-800 mb-4 flex items-center">
                                    <i class="fas fa-toggle-on mr-2"></i>Non-contact Safety Switches
                                </h3>
                                <?php 
                                $nonContactSwitches = array_filter($switches, function($switch) {
                                    return strpos($switch->title, 'SS2-P-') !== false || 
                                           strpos($switch->content, 'Non-contact Safety Switch') !== false;
                                });
                                ?>
                                <?php if (!empty($nonContactSwitches)): ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <?php foreach($nonContactSwitches as $switch): ?>
                                        <div class="bg-white border border-green-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded">
                                                    ID: <?php echo $switch->id; ?>
                                                </span>
                                                <button type="button" class="edit-switch-quick px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors"
                                                        data-id="<?php echo $switch->id; ?>">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                </button>
                                            </div>
                                            <h4 class="font-bold text-slate-800 mb-2 truncate"><?php echo htmlspecialchars($switch->title); ?></h4>
                                            <?php if (!empty($switch->image)): ?>
                                            <div class="h-32 bg-slate-50 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                                                <img src="<?php echo base_url('assets_system/images/' . $switch->image); ?>" 
                                                     class="max-w-full max-h-full object-contain"
                                                     alt="<?php echo htmlspecialchars($switch->title); ?>">
                                            </div>
                                            <?php else: ?>
                                            <div class="h-32 bg-slate-100 rounded-lg mb-3 flex items-center justify-center">
                                                <i class="fas fa-image text-2xl text-slate-300"></i>
                                            </div>
                                            <?php endif; ?>
                                            <div class="text-xs text-slate-500 mb-3">
                                                <?php echo substr($switch->content, 0, 100) . (strlen($switch->content) > 100 ? '...' : ''); ?>
                                            </div>
                                            <?php if (!empty($switch->features)): ?>
                                            <div class="flex flex-wrap gap-1">
                                                <?php 
                                                $features = explode(',', $switch->features);
                                                foreach(array_slice($features, 0, 3) as $feature):
                                                    $feature = trim($feature);
                                                    if (!empty($feature)):
                                                ?>
                                                <span class="px-2 py-1 bg-green-50 text-green-700 text-xs rounded border border-green-100">
                                                    <?php echo htmlspecialchars($feature); ?>
                                                </span>
                                                <?php 
                                                    endif;
                                                endforeach; 
                                                ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-12 border-2 border-dashed border-green-200 rounded-xl bg-green-50">
                                        <i class="fas fa-toggle-off text-4xl text-green-300 mb-4"></i>
                                        <h4 class="text-lg font-medium text-green-700 mb-2">No Non-contact Safety Switches</h4>
                                        <p class="text-green-600 mb-4">Add non-contact safety switches from the "New Switch" tab</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Safety Relay Unit Tab Content -->
                        <div id="safetyRelayContent" class="tab-content hidden">
                            <div class="mb-6">
                                <h3 class="text-lg font-bold text-blue-800 mb-4 flex items-center">
                                    <i class="fas fa-bolt mr-2"></i>Safety Relay Units
                                </h3>
                                <?php 
                                $safetyRelaySwitches = array_filter($switches, function($switch) {
                                    return strpos($switch->title, 'Safety Relay Unit') !== false || 
                                           strpos($switch->content, 'Safety Relay Unit') !== false;
                                });
                                ?>
                                <?php if (!empty($safetyRelaySwitches)): ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                        <?php foreach($safetyRelaySwitches as $switch): ?>
                                        <div class="bg-white border border-blue-200 rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded">
                                                    ID: <?php echo $switch->id; ?>
                                                </span>
                                                <button type="button" class="edit-switch-quick px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700 transition-colors"
                                                        data-id="<?php echo $switch->id; ?>">
                                                    <i class="fas fa-edit mr-1"></i>Edit
                                                </button>
                                            </div>
                                            <h4 class="font-bold text-slate-800 mb-2 truncate"><?php echo htmlspecialchars($switch->title); ?></h4>
                                            <?php if (!empty($switch->image)): ?>
                                            <div class="h-32 bg-slate-50 rounded-lg mb-3 overflow-hidden flex items-center justify-center">
                                                <img src="<?php echo base_url('assets_system/images/' . $switch->image); ?>" 
                                                     class="max-w-full max-h-full object-contain"
                                                     alt="<?php echo htmlspecialchars($switch->title); ?>">
                                            </div>
                                            <?php else: ?>
                                            <div class="h-32 bg-slate-100 rounded-lg mb-3 flex items-center justify-center">
                                                <i class="fas fa-image text-2xl text-slate-300"></i>
                                            </div>
                                            <?php endif; ?>
                                            <div class="text-xs text-slate-500 mb-3">
                                                <?php echo substr($switch->content, 0, 100) . (strlen($switch->content) > 100 ? '...' : ''); ?>
                                            </div>
                                            <?php if (!empty($switch->features)): ?>
                                            <div class="flex flex-wrap gap-1">
                                                <?php 
                                                $features = explode(',', $switch->features);
                                                foreach(array_slice($features, 0, 3) as $feature):
                                                    $feature = trim($feature);
                                                    if (!empty($feature)):
                                                ?>
                                                <span class="px-2 py-1 bg-blue-50 text-blue-700 text-xs rounded border border-blue-100">
                                                    <?php echo htmlspecialchars($feature); ?>
                                                </span>
                                                <?php 
                                                    endif;
                                                endforeach; 
                                                ?>
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-12 border-2 border-dashed border-blue-200 rounded-xl bg-blue-50">
                                        <i class="fas fa-bolt text-4xl text-blue-300 mb-4"></i>
                                        <h4 class="text-lg font-medium text-blue-700 mb-2">No Safety Relay Units</h4>
                                        <p class="text-blue-600 mb-4">Add safety relay units from the "New Switch" tab</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- New Switch Form (Separate from main form) -->
                        <div id="pane_new" class="tab-content hidden">
                            <!-- This is a separate form, not part of the main form -->
                            <div class="space-y-6" id="newSwitchForm">
                                <!-- Header -->
                                <div class="p-4 bg-green-50/30 rounded-xl border border-green-100/50">
                                    <h4 class="font-bold text-green-800">Create New Safety Switch</h4>
                                    <p class="text-sm text-green-600">Fill in the details below to add a new safety switch</p>
                                </div>

                                <!-- Category Selection -->
                                <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
                                    <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Category *</label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <label class="relative">
                                            <input type="radio" name="new_category" value="non-contact" class="hidden peer">
                                            <div class="p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-green-400 peer-checked:border-green-500 peer-checked:bg-green-50 transition-all">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full border-2 border-slate-300 flex items-center justify-center mr-3 peer-checked:border-green-500 peer-checked:bg-green-100">
                                                        <div class="w-4 h-4 rounded-full bg-white peer-checked:bg-green-500"></div>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-medium text-slate-800">Non-contact Safety Switch</h5>
                                                        <p class="text-xs text-slate-500">For SS2-P series switches</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <label class="relative">
                                            <input type="radio" name="new_category" value="safety-relay" class="hidden peer">
                                            <div class="p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-blue-400 peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full border-2 border-slate-300 flex items-center justify-center mr-3 peer-checked:border-blue-500 peer-checked:bg-blue-100">
                                                        <div class="w-4 h-4 rounded-full bg-white peer-checked:bg-blue-500"></div>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-medium text-slate-800">Safety Relay Unit</h5>
                                                        <p class="text-xs text-slate-500">Safety relay products</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                        <label class="relative">
                                            <input type="radio" name="new_category" value="general" class="hidden peer" checked>
                                            <div class="p-4 border-2 border-slate-200 rounded-xl cursor-pointer hover:border-indigo-400 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-full border-2 border-slate-300 flex items-center justify-center mr-3 peer-checked:border-indigo-500 peer-checked:bg-indigo-100">
                                                        <div class="w-4 h-4 rounded-full bg-white peer-checked:bg-indigo-500"></div>
                                                    </div>
                                                    <div>
                                                        <h5 class="font-medium text-slate-800">General</h5>
                                                        <p class="text-xs text-slate-500">Other safety products</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Title & Content -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 rounded-xl bg-slate-50 border border-slate-100">
                                    <div>
                                        <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Title *</label>
                                        <input type="text" id="new_title" 
                                               class="w-full p-3 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                                               placeholder="Enter switch title">
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Content *</label>
                                        <textarea id="new_content" 
                                                  class="w-full p-3 border border-slate-300 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                                                  rows="4"
                                                  placeholder="Enter switch content"></textarea>
                                    </div>
                                </div>

                                <!-- Features -->
                                <div class="p-4 rounded-xl bg-green-50 border border-green-100">
                                    <label class="text-xs font-bold text-green-600 mb-2 block uppercase">
                                        Features (comma separated)
                                        <span class="text-green-400 font-normal">Will appear as tags</span>
                                    </label>
                                    <textarea id="new_features" 
                                              class="w-full p-3 border border-green-200 rounded-lg bg-white focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition"
                                              rows="2"
                                              placeholder="Plastic, Stand-alone, Safety Relay Combinable per Condition"></textarea>
                                </div>

                                <!-- Image Upload -->
                                <div class="p-4 rounded-xl bg-white border border-slate-200 shadow-sm">
                                    <label class="text-xs font-bold text-slate-500 mb-2 block uppercase">Upload Image</label>
                                    <div class="border-2 border-dashed border-slate-300 rounded-xl p-8 text-center hover:border-green-400 transition-colors">
                                        <div class="mb-6" id="newImagePreviewContainer">
                                            <img id="newImagePreview" src="" alt="Preview" 
                                                 class="mx-auto max-h-48 object-contain rounded-lg hidden">
                                        </div>
                                        
                                        <div id="newUploadArea">
                                            <div class="mb-4">
                                                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                                    <i class="fas fa-cloud-upload-alt text-2xl text-green-600"></i>
                                                </div>
                                                <p class="text-slate-700 font-medium mb-1">Click to upload product image</p>
                                                <p class="text-slate-500 text-sm">JPG, PNG, GIF, WebP or SVG (Max. 2MB)</p>
                                            </div>
                                            
                                            <div class="flex items-center justify-center gap-4">
                                                <label class="cursor-pointer">
                                                    <span class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors inline-flex items-center gap-2">
                                                        <i class="fas fa-image"></i>
                                                        Choose File
                                                    </span>
                                                    <input type="file" id="new_image" 
                                                           class="hidden" accept="image/*">
                                                </label>
                                                <button type="button" onclick="clearNewImage()" 
                                                        class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-lg hover:bg-slate-300 transition-colors">
                                                    Clear
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div id="newFileInfo" class="mt-4 hidden">
                                            <p class="text-sm text-slate-600">
                                                Selected: <span id="newFileName" class="font-medium"></span>
                                                <span id="newFileSize" class="text-slate-500"></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Create Button -->
                                <div class="flex justify-end pt-4">
                                    <button type="button" id="createNewSwitchBtn" 
                                            class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium flex items-center gap-2">
                                        <i class="fas fa-plus"></i>
                                        Create Safety Switch
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </form>
    </div>
</main>

<!-- Separate JavaScript includes -->
<script src="<?php echo base_url('assets_system/vendor/jquery/jquery-3.7.1.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
<script src="<?php echo base_url('assets_system/vendor/fontawesome-6.0.0/js/all.min.js'); ?>"></script>

<script>
$(document).ready(function() {
    const BASE_URL = "<?php echo base_url(); ?>";
    const ADMIN_URL = "<?php echo base_url('cms/'); ?>";
    const IMAGES_URL = "<?php echo base_url('assets_system/images/'); ?>";
    
    // Category Tabs functionality
    $('#allProductsTab').click(function() {
        $('.tab-content').addClass('hidden');
        $('#allProductsContent').removeClass('hidden');
        $(this).addClass('border-indigo-600 text-indigo-600').removeClass('border-transparent text-slate-400');
        $('#nonContactTab, #safetyRelayTab').removeClass('border-indigo-600 text-indigo-600').addClass('border-transparent text-slate-400');
    });
    
    $('#nonContactTab').click(function() {
        $('.tab-content').addClass('hidden');
        $('#nonContactContent').removeClass('hidden');
        $(this).addClass('border-green-600 text-green-600').removeClass('border-transparent text-slate-400');
        $('#allProductsTab, #safetyRelayTab').removeClass('border-indigo-600 text-indigo-600 border-green-600 text-green-600 border-blue-600 text-blue-600').addClass('border-transparent text-slate-400');
    });
    
    $('#safetyRelayTab').click(function() {
        $('.tab-content').addClass('hidden');
        $('#safetyRelayContent').removeClass('hidden');
        $(this).addClass('border-blue-600 text-blue-600').removeClass('border-transparent text-slate-400');
        $('#allProductsTab, #nonContactTab').removeClass('border-indigo-600 text-indigo-600 border-green-600 text-green-600').addClass('border-transparent text-slate-400');
    });
    
    // New Tab button
    $('#newTabBtn, #addSwitchBtn, #addFirstSwitchBtn').click(function() {
        $('.tab-content').addClass('hidden');
        $('#pane_new').removeClass('hidden');
        $('.tab-content').prev().find('button').removeClass('border-indigo-600 text-indigo-600 border-green-600 text-green-600 border-blue-600 text-blue-600').addClass('border-transparent text-slate-400');
    });
    
    // Individual switch tab functionality
    $(document).on('click', '.tab-btn', function() {
        const switchId = $(this).data('index');
        
        $('.tab-btn').removeClass('ring-2 ring-indigo-500');
        $(this).addClass('ring-2 ring-indigo-500');
        
        $('.tab-pane').addClass('hidden');
        $(`#pane_${switchId}`).removeClass('hidden');
    });
    
    // Quick edit from category tabs
    $(document).on('click', '.edit-switch-quick', function() {
        const switchId = $(this).data('id');
        
        // Switch to All Products tab
        $('.tab-content').addClass('hidden');
        $('#allProductsContent').removeClass('hidden');
        $('#allProductsTab').addClass('border-indigo-600 text-indigo-600').removeClass('border-transparent text-slate-400');
        $('#nonContactTab, #safetyRelayTab').removeClass('border-indigo-600 text-indigo-600').addClass('border-transparent text-slate-400');
        
        // Activate the specific switch tab
        $('.tab-btn').removeClass('ring-2 ring-indigo-500');
        $(`.tab-btn[data-index="${switchId}"]`).addClass('ring-2 ring-indigo-500');
        
        // Show the specific switch pane
        $('.tab-pane').addClass('hidden');
        $(`#pane_${switchId}`).removeClass('hidden');
        
        // Scroll to the pane
        $('html, body').animate({
            scrollTop: $(`#pane_${switchId}`).offset().top - 100
        }, 500);
    });
    
    // Image upload for existing switches
    $(document).on('change', '.switch-image-upload', function(e) {
        const switchId = $(this).data('switch-id');
        const file = e.target.files[0];
        
        if (!file) return;
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            Swal.fire('Error', 'File size must be less than 2MB', 'error');
            return;
        }
        
        // Validate file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        if (!validTypes.includes(file.type)) {
            Swal.fire('Error', 'Please upload only image files (JPG, PNG, GIF, WebP, SVG)', 'error');
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Uploading...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        const formData = new FormData();
        formData.append('image', file);
        
        $.ajax({
            url: ADMIN_URL + '/upload_image_only/' + switchId,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                Swal.close();
                
                if (res.success) {
                    // Update the image preview
                    const previewContainer = $('#previewContainer_' + switchId);
                    previewContainer.html(`
                        <div class="w-full h-64 bg-slate-50 rounded-lg border overflow-hidden flex items-center justify-center shadow-inner">
                            <img src="${res.image_url}" class="max-w-full max-h-full object-contain">
                        </div>
                        <div class="text-xs text-slate-400 mt-2 truncate px-1">${res.file_name}</div>
                    `);
                    
                    // Update the hidden input
                    $(`input[name="current_image_${switchId}"]`).val(res.file_name);
                    
                    Swal.fire('Success', 'Image uploaded successfully!', 'success');
                } else {
                    Swal.fire('Error', res.message || 'Upload failed', 'error');
                }
            },
            error: function() {
                Swal.close();
                Swal.fire('Error', 'Network error. Please try again.', 'error');
            }
        });
    });
    
    // Create new switch
    $('#createNewSwitchBtn').click(function() {
        const title = $('#new_title').val().trim();
        const content = $('#new_content').val().trim();
        const features = $('#new_features').val().trim();
        const imageFile = $('#new_image')[0].files[0];
        const category = $('input[name="new_category"]:checked').val();
        
        // Clear previous validation
        $('#new_title').removeClass('border-red-500');
        $('#new_content').removeClass('border-red-500');
        
        // Validation
        let isValid = true;
        if (!title) {
            $('#new_title').addClass('border-red-500');
            isValid = false;
        }
        if (!content) {
            $('#new_content').addClass('border-red-500');
            isValid = false;
        }
        
        if (!isValid) {
            Swal.fire('Validation Error', 'Please fill in Title and Content fields', 'warning');
            return;
        }
        
        // Show loading
        Swal.fire({
            title: 'Creating...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });
        
        const formData = new FormData();
        formData.append('title', title);
        formData.append('content', content);
        formData.append('features', features);
        formData.append('category', category);
        
        if (imageFile) {
            formData.append('image', imageFile);
        }
        
        $.ajax({
            url: ADMIN_URL + '/save_switch',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload(); // Reload to show new switch
                    });
                } else {
                    Swal.fire('Error', res.message || 'Creation failed', 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Network error. Please try again.', 'error');
            }
        });
    });
    
    // Delete switch
    $(document).on('click', '.delete-switch-btn', function() {
        const switchId = $(this).data('id');
        const switchTitle = $(this).data('title');
        
        Swal.fire({
            title: 'Delete Safety Switch?',
            html: `<div class="text-left">
                      <p>Are you sure you want to delete:</p>
                      <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-3">
                          <p class="font-bold text-red-700">${switchTitle}</p>
                          <p class="text-sm text-red-600">ID: ${switchId}</p>
                      </div>
                      <p class="text-sm text-slate-600">This action cannot be undone!</p>
                   </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, Delete It!',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show deleting animation
                Swal.fire({
                    title: 'Deleting...',
                    text: 'Please wait',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                });
                
                $.ajax({
                    url: ADMIN_URL + '/delete_switch/' + switchId,
                    type: 'POST',
                    dataType: 'json',
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message || 'Deletion failed', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Network error. Please try again.', 'error');
                    }
                });
            }
        });
    });
    
    // Save all changes (existing switches)
    // Alternative: Save all switches in one request
$('#safetySwitchesForm').on('submit', function(e) {
    e.preventDefault();
    
    // Validate all forms before submitting
    let isValid = true;
    const errorMessages = [];
    
    $('input[name^="title_"]').each(function() {
        if ($(this).val().trim() === '') {
            isValid = false;
            $(this).addClass('border-red-500');
            const switchId = $(this).attr('name').replace('title_', '');
            errorMessages.push(`Switch ID ${switchId}: Title is required`);
        } else {
            $(this).removeClass('border-red-500');
        }
    });
    
    $('textarea[name^="content_"]').each(function() {
        if ($(this).val().trim() === '') {
            isValid = false;
            $(this).addClass('border-red-500');
            const switchId = $(this).attr('name').replace('content_', '');
            errorMessages.push(`Switch ID ${switchId}: Content is required`);
        } else {
            $(this).removeClass('border-red-500');
        }
    });
    
    if (!isValid) {
        Swal.fire({
            title: 'Validation Error',
            html: `<div class="text-left">
                      <p class="font-bold text-red-700 mb-2">Please fix the following errors:</p>
                      <ul class="list-disc pl-4 text-red-600">
                          ${errorMessages.map(msg => `<li>${msg}</li>`).join('')}
                      </ul>
                   </div>`,
            icon: 'error'
        });
        return;
    }
    
    // Show loading
    Swal.fire({
        title: 'Saving Changes...',
        allowOutsideClick: false,
        didOpen: () => Swal.showLoading()
    });
    
    // Collect all data into a single object
    const allData = {};
    
    $('input[name^="id_"]').each(function() {
        const switchId = $(this).val();
        allData[switchId] = {
            id: switchId,
            title: $(`input[name="title_${switchId}"]`).val(),
            content: $(`textarea[name="content_${switchId}"]`).val(),
            features: $(`textarea[name="features_${switchId}"]`).val() || '',
            current_image: $(`input[name="current_image_${switchId}"]`).val() || ''
        };
    });
    
    // Send all data at once
    $.ajax({
        url: ADMIN_URL + '/save_all_switches',
        type: 'POST',
        data: {
            switches: JSON.stringify(allData)
        },
        dataType: 'json',
        success: function(res) {
            Swal.close();
            if (res.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: res.message || 'All changes saved successfully!',
                    confirmButtonText: 'OK'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: res.message || 'Failed to save changes.',
                    confirmButtonText: 'OK'
                });
            }
        },
        error: function(xhr, status, error) {
            Swal.close();
            Swal.fire({
                icon: 'error',
                title: 'Network Error',
                text: 'Failed to save changes. Please check your connection.',
                confirmButtonText: 'OK'
            });
        }
    });
});
    
    // New image preview
    $('#new_image').on('change', function(e) {
        const file = e.target.files[0];
        const preview = $('#newImagePreview');
        const uploadArea = $('#newUploadArea');
        const fileInfo = $('#newFileInfo');
        const fileName = $('#newFileName');
        const fileSize = $('#newFileSize');
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire('Error', 'File size must be less than 2MB', 'error');
                this.value = '';
                return;
            }
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
            if (!validTypes.includes(file.type)) {
                Swal.fire('Error', 'Please upload only image files (JPG, PNG, GIF, WebP, SVG)', 'error');
                this.value = '';
                return;
            }
            
            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.attr('src', e.target.result);
                preview.removeClass('hidden');
                uploadArea.addClass('hidden');
                fileInfo.removeClass('hidden');
                
                // Show file info
                fileName.text(file.name);
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);
                fileSize.text(`(${sizeInMB} MB)`);
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Clear new image
    window.clearNewImage = function() {
        $('#new_image').val('');
        $('#newImagePreview').attr('src', '').addClass('hidden');
        $('#newUploadArea').removeClass('hidden');
        $('#newFileInfo').addClass('hidden');
    };
    
    // Initialize first tab as active if exists
    if ($('.tab-btn').length > 0) {
        $('.tab-btn').first().click();
    }
    
    // Fix for form validation: prevent browser validation for new form
    $('#newSwitchForm input, #newSwitchForm textarea').on('invalid', function(e) {
        e.preventDefault();
    });
});
</script>

<style>
.no-scrollbar::-webkit-scrollbar { 
    display: none; 
}
.no-scrollbar { 
    -ms-overflow-style: none; 
    scrollbar-width: none; 
}
.animate-fadeIn { 
    animation: fadeIn 0.3s ease-in-out; 
}
@keyframes fadeIn { 
    from { 
        opacity: 0; 
        transform: translateY(5px); 
    } 
    to { 
        opacity: 1; 
        transform: translateY(0); 
    } 
}
.hidden {
    display: none;
}
</style>
