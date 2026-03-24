<?php $this->load->view('admin/header'); ?>

<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <?php if($this->session->flashdata('success')): ?>
        <div class="mb-6 p-4 bg-green-100 border border-green-300 text-green-700 rounded-xl">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded-xl">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
        <?php endif; ?>
        
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Resource Library CMS</h1>
                <p class="text-slate-500 mt-1">Manage technical videos, PDF brochures, and lead-capture forms.</p>
            </div>
            <div class="flex gap-3">
                <a href="<?php echo site_url('cms/library_create'); ?>" class="px-5 py-2.5 bg-sky-600 text-white rounded-xl font-semibold shadow-md hover:bg-sky-700 transition-all flex items-center">
                    <i class="fas fa-upload mr-2 text-xs"></i> Add New Resource
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <div class="space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <h3 class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-widest">Asset Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Total Resources</span>
                            <span class="font-bold text-slate-900"><?php echo $total_items; ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">Videos</span>
                            <span class="font-bold text-slate-900"><?php echo $total_videos; ?></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-slate-600">PDF Documents</span>
                            <span class="font-bold text-slate-900"><?php echo $total_pdfs; ?></span>
                        </div>
                    </div>
                </div>

                <!-- Webinar Management Section (moved here for visibility) -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest">Webinar Series</h3>
                        <a href="<?= site_url('cms/webinar_create') ?>" class="text-xs bg-emerald-600 text-white px-3 py-1.5 rounded-lg font-semibold hover:bg-emerald-700 transition-colors">
                            <i class="fas fa-plus mr-1"></i> Add
                        </a>
                    </div>
                    <?php
                    $webinars_list = isset($webinars) ? $webinars : $this->db->order_by('id', 'ASC')->get('tbl_webinar')->result_array();
                    if (!empty($webinars_list)):
                    ?>
                    <div class="space-y-2">
                        <?php foreach($webinars_list as $wb): ?>
                        <div class="flex items-center justify-between p-3 <?= (!empty($wb['is_featured']) && $wb['is_featured'] == 1) ? 'bg-amber-50 border-amber-200' : 'bg-slate-50 border-slate-100' ?> rounded-lg border hover:bg-slate-100 transition-colors group">
                            <div class="flex items-center gap-3 min-w-0">
                                <?php if(!empty($wb['main_image'])): ?>
                                <img src="<?= base_url('assets_system/images/' . $wb['main_image']) ?>" class="w-10 h-10 rounded-lg object-cover border border-slate-200 flex-shrink-0" alt="">
                                <?php else: ?>
                                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-video text-emerald-600 text-xs"></i>
                                </div>
                                <?php endif; ?>
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-slate-700 truncate"><?= htmlspecialchars($wb['webinar_title']) ?></p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] text-slate-400">ID: <?= $wb['id'] ?></span>
                                        <?php if(!empty($wb['is_featured']) && $wb['is_featured'] == 1): ?>
                                        <span class="inline-flex items-center gap-0.5 px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded text-[9px] font-bold">
                                            <i class="fas fa-star text-[8px]"></i> Featured
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <?php if(empty($wb['is_featured']) || $wb['is_featured'] != 1): ?>
                                <a href="<?= site_url('cms/webinar_set_featured/' . $wb['id']) ?>"
                                   onclick="return confirm('Set this webinar as featured on the Simulation page?')"
                                   class="w-7 h-7 flex items-center justify-center rounded-lg bg-slate-100 text-slate-400 hover:bg-amber-100 hover:text-amber-600 transition-colors" title="Set as Featured">
                                    <i class="far fa-star text-[10px]"></i>
                                </a>
                                <?php else: ?>
                                <a href="<?= site_url('cms/webinar_set_featured/' . $wb['id']) ?>"
                                   onclick="return confirm('Remove this webinar from featured?')"
                                   class="w-7 h-7 flex items-center justify-center rounded-lg bg-amber-400 text-white hover:bg-amber-500 transition-colors" title="Remove from Featured">
                                    <i class="fas fa-star text-[10px]"></i>
                                </a>
                                <?php endif; ?>
                                <a href="<?= site_url('cms/webinar_edit/' . $wb['id']) ?>" class="w-7 h-7 flex items-center justify-center rounded-lg bg-indigo-100 text-indigo-600 hover:bg-indigo-200 transition-colors" title="Edit">
                                    <i class="fas fa-pen text-[10px]"></i>
                                </a>
                                <a href="<?= site_url('cms/webinar_delete/' . $wb['id']) ?>"
                                   onclick="return confirm('Delete this webinar? Resources linked to it will be unlinked.')"
                                   class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-100 text-red-600 hover:bg-red-200 transition-colors" title="Delete">
                                    <i class="fas fa-trash text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-6">
                        <i class="fas fa-video text-slate-300 text-2xl mb-2"></i>
                        <p class="text-xs text-slate-400">No webinars yet</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="bg-slate-900 rounded-2xl p-5 shadow-xl text-white">
                    <h3 class="text-xs font-bold text-sky-400 uppercase mb-4">Featured Resource</h3>
                    <div class="p-3 bg-white/5 rounded-xl border border-white/10">
                        <p class="text-[10px] text-slate-400">Current Featured Video:</p>
                        <p class="text-sm font-bold mt-1"><?php echo isset($featured_resource['title']) ? $featured_resource['title'] : 'Not Set'; ?></p>
                        <button class="mt-3 text-xs text-sky-400 font-bold underline" data-modal-toggle="featuredModal">
                            Change Featured
                        </button>
                    </div>
                </div>
                
                <!-- Place this in your admin sidebar or dashboard -->
                <div class="mb-6">
                    <a href="<?= base_url('cms/video_submissions') ?>" class="block">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-500 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Video Submissions</h3>
                                        <p class="text-blue-50">Manage user video submissions</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>
                
                <!-- Alternative: Simpler PDF icon -->
                <div class="mb-6">
                    <a href="<?= base_url('cms/download_submissions') ?>" class="block">
                        <div class="bg-gradient-to-r from-blue-400 to-blue-500 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="bg-white/20 p-3 rounded-lg backdrop-blur-sm">
                                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Download Submissions</h3>
                                        <p class="text-blue-50">Manage user download submissions</p>
                                    </div>
                                </div>
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                </svg>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
<?php
$current_type = $this->input->get('type') ?: 'all';
?>
            <div class="lg:col-span-3">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <div class="flex gap-4">
                            <form method="GET" action="<?php echo site_url('cms/library_search'); ?>" class="flex gap-4">
                                <select name="type" class="text-xs border-slate-200 rounded-lg px-3 py-1.5 focus:ring-sky-500" onchange="this.form.submit()">
                                    <option value="all" <?php echo $current_type == 'all' ? 'selected' : ''; ?>>All Resource Types</option>
                                    <option value="videos" <?php echo $current_type == 'videos' ? 'selected' : ''; ?>>Videos</option>
                                    <option value="brochure" <?php echo $current_type == 'brochure' ? 'selected' : ''; ?>>PDF</option>
                                </select>
                            </form>
                        </div>
                        <form method="GET" action="<?php echo site_url('cms/library_search'); ?>">
                            <input type="text" name="search" placeholder="Search resources..." 
                                   value="<?php echo $this->input->get('search'); ?>"
                                   class="text-xs border-slate-200 rounded-lg px-4 py-1.5 w-64">
                        </form>
                    </div>

                    <div class="p-0">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100 text-[10px] uppercase font-bold text-slate-400">
                                <tr>
                                    <th class="px-6 py-3">ID</th>
                                    <th class="px-6 py-3">Preview</th>
                                    <th class="px-6 py-3">Title & Info</th>
                                    <th class="px-6 py-3">Type</th>
                                    <th class="px-6 py-3 text-center">Created</th>
                                    <th class="px-6 py-3 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php if(!empty($resources)): ?>
                                    <?php foreach($resources as $resource): 
                                        // Determine resource type
                                        if($resource['id'] == 2) continue;
                                        $type = 'PDF';
                                        $type_class = 'bg-sky-100 text-sky-700';
                                        $icon = 'fas fa-file-pdf';
                                        
                                        if(stripos($resource['resource_type'], 'video') !== false) {
                                            $type = 'Video';
                                            $type_class = 'bg-green-100 text-green-700';
                                            $icon = 'fas fa-video';
                                        }
                                        
                                        if(stripos($resource['resource_type'], 'case') !== false) {
                                            $type = 'Case Study';
                                            $type_class = 'bg-purple-100 text-purple-700';
                                            $icon = 'fas fa-chart-line';
                                        }
                                    ?>
                                    <tr class="hover:bg-slate-50/50 transition-colors">
                                        <td class="px-6 py-4 text-xs text-slate-400">#<?php echo $resource['id']; ?></td>
                                        <td class="px-6 py-4">
                                            <?php if(!empty($resource['image'])): ?>
                                                <div class="w-20 h-12 bg-slate-200 rounded overflow-hidden relative">
                                                    <img src="<?php echo base_url('assets_system/images/' . $resource['image']); ?>" 
                                                         class="object-cover w-full h-full opacity-80">
                                                    <i class="fas fa-play absolute inset-0 m-auto text-[10px] text-white w-fit h-fit"></i>
                                                </div>
                                            <?php else: ?>
                                                <!-- Show PDF icon image for PDF resources, otherwise show the type icon -->
                                                <?php if($resource['resource_type'] == 'brochure'): ?>
                                                    <div class="w-20 h-12 bg-red-50 border border-red-200 rounded flex items-center justify-center">
                                                        <img src="<?php echo base_url('assets_system/images/pdf.png'); ?>" 
                                                             alt="PDF Icon" 
                                                             class="w-8 h-8 object-contain">
                                                    </div>
                                                <?php else: ?>
                                                    <div class="w-20 h-12 <?php echo $type_class; ?> rounded flex items-center justify-center">
                                                        <i class="<?php echo $icon; ?>"></i>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-bold text-slate-800"><?php echo $resource['title']; ?></div>
                                            <div class="text-[10px] text-slate-500">
                                                <?php
                                                echo strlen($resource['content']) > 100 ?
                                                    substr($resource['content'], 0, 100) . '...' :
                                                    $resource['content'];
                                                ?>
                                            </div>
                                            <?php if(!empty($resource['webinar_id'])):
                                                $wb_title = $this->db->select('webinar_title')->where('id', $resource['webinar_id'])->get('tbl_webinar')->row();
                                            ?>
                                            <span class="inline-flex items-center gap-1 mt-1 px-2 py-0.5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded text-[9px] font-bold">
                                                <i class="fas fa-video text-[8px]"></i>
                                                <?= $wb_title ? htmlspecialchars($wb_title->webinar_title) : 'Webinar #' . $resource['webinar_id'] ?>
                                            </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 <?php echo $type_class; ?> rounded text-[9px] font-bold">
                                                <?php echo $type; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center text-xs text-slate-500">
                                            <?php echo date('M d, Y', strtotime($resource['created_at'])); ?>
                                        </td>
                                        <td class="px-6 py-4 text-right space-x-3">
                                            <a href="<?php echo site_url('cms/library_edit/' . $resource['id']); ?>" 
                                               class="text-xs font-bold text-sky-600 hover:underline">
                                                Edit
                                            </a>
                                            <a href="<?php echo site_url('cms/library_delete/' . $resource['id']); ?>" 
                                               class="text-xs font-bold text-red-600 hover:underline"
                                               onclick="return confirm('Are you sure you want to delete this resource?');">
                                                Delete
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-slate-400">
                                            <i class="fas fa-inbox text-3xl mb-2"></i>
                                            <p>No resources found.</p>
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
</main>

<!-- Featured Resource Modal -->
<div id="featuredModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-slate-900">Set Featured Resource</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <p class="text-sm text-slate-600 mb-4">Select a video resource to feature on the main page:</p>
        
        <div class="space-y-3 max-h-60 overflow-y-auto">
            <?php foreach($resources as $resource): 
                if($resource['resource_type'] != "videos") continue;
                if($resource['id'] == 2) continue;
            ?>
            <div class="flex items-center justify-between p-3 border border-slate-200 rounded-lg">
                <div class="flex items-center space-x-3">
                    <?php if(!empty($resource['image'])): ?>
                        <img src="<?php echo base_url('assets_system/images/' . $resource['image']); ?>" 
                             class="w-10 h-8 object-cover rounded">
                    <?php else: ?>
                        <div class="w-10 h-8 bg-sky-100 rounded flex items-center justify-center">
                            <i class="fas fa-video text-sky-600 text-sm"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="text-sm font-medium text-slate-800"><?php echo $resource['title']; ?></p>
                        <p class="text-xs text-slate-500">ID: #<?php echo $resource['id']; ?></p>
                    </div>
                </div>
                <a href="<?php echo site_url('cms/library_set_featured/' . $resource['id']); ?>" 
                   class="text-xs bg-sky-600 text-white px-3 py-1 rounded-lg hover:bg-sky-700">
                    Set Featured
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-6 flex justify-end">
            <button onclick="closeModal()" class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-slate-800">
                Cancel
            </button>
        </div>
    </div>
</div>

<script>
    // Modal functions
    function openModal() {
        document.getElementById('featuredModal').classList.remove('hidden');
        document.getElementById('featuredModal').classList.add('flex');
    }
    
    function closeModal() {
        document.getElementById('featuredModal').classList.remove('flex');
        document.getElementById('featuredModal').classList.add('hidden');
    }
    
    // Add click event to Change Featured button
    document.querySelector('[data-modal-toggle="featuredModal"]').addEventListener('click', openModal);
</script>