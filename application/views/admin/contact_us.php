<?php
/**
 * Group content items by title for easy access.
 * Each item: id, title, content, image
 */
$items_by_title = array();
foreach ($content_items as $item) {
    $items_by_title[$item['title']] = $item;
}

// Helper to get an item's data
function ci($items, $title) {
    return isset($items[$title]) ? $items[$title] : array('id' => '', 'title' => $title, 'content' => '', 'image' => '');
}

// Define sections and their fields
$hero_title   = ci($items_by_title, 'Contact Hero Title');
$hero_desc    = ci($items_by_title, 'Contact Hero Description');

$info_title       = ci($items_by_title, 'Contact Information Section Title');
$office_title     = ci($items_by_title, 'Office Address Title');
$office_content   = ci($items_by_title, 'Office Address Content');
$phone_title      = ci($items_by_title, 'Phone Title');
$phone_content    = ci($items_by_title, 'Phone Content');
$email_title      = ci($items_by_title, 'Email Title');
$email_content    = ci($items_by_title, 'Email Content');
$hours_title      = ci($items_by_title, 'Operating Hours Title');
$hours_content    = ci($items_by_title, 'Operating Hours Content');

$map_title    = ci($items_by_title, 'Map Section Title');
$map_desc     = ci($items_by_title, 'Map Section Description');
$map_embed    = ci($items_by_title, 'Map Embed URL');

$cta_title    = ci($items_by_title, 'CTA Section Title');
$cta_desc     = ci($items_by_title, 'CTA Section Description');
$cta_schedule = ci($items_by_title, 'Schedule Consultation Button');
$cta_demo     = ci($items_by_title, 'Request Demo Button');
?>
<style>
main { padding-top: 1rem; }
.sticky-header { transition: all 0.3s ease; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }
.scroll-progress { position: absolute; bottom: 0; left: 0; height: 2px; background: linear-gradient(90deg, #4f46e5, #7c3aed); transition: width 0.3s ease; }
.sticky-header.scrolled { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
#saveAllChanges:active { transform: scale(0.98); }
@keyframes pulse { 0%,100%{opacity:1} 50%{opacity:0.7} }
#saveAllChanges.saving { animation: pulse 1.5s ease-in-out infinite; }
</style>

<main class="ml-64 p-8">
    <!-- STICKY HEADER -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 sticky-header mb-8">
        <div class="max-w-6xl mx-auto">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Contact Us Page Editor</h1>
                    <p class="text-slate-500 mt-1">Manage all content for the Contact Us page.</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?= base_url('index/contact_us'); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Preview Site
                    </a>
                    <button type="button" id="saveAllChanges" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center">
                        <svg id="saveIcon" class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </div>
        </div>
        <div class="scroll-progress"></div>
    </div>

    <div class="max-w-6xl mx-auto">
        <form id="contactCmsForm" enctype="multipart/form-data">
            <div class="space-y-8">

                <!-- 1. Hero Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">🖼️ Hero Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Hero Title -->
                        <?php if (!empty($hero_title['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hero Title</label>
                            <input type="hidden" name="items[0][id]" value="<?= $hero_title['id']; ?>">
                            <input type="text" name="items[0][content]" value="<?= htmlspecialchars($hero_title['content']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="e.g., Contact Us">
                        </div>
                        <?php endif; ?>

                        <!-- Hero Background Image -->
                        <?php if (!empty($hero_title['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hero Background Image</label>
                            <div class="flex items-start gap-6">
                                <!-- Current Image Preview -->
                                <div class="w-48 h-28 bg-slate-100 rounded-xl overflow-hidden flex-shrink-0 border border-slate-200">
                                    <?php if (!empty($hero_title['image'])): ?>
                                        <img id="heroImgPreview" src="<?= base_url('assets_system/images/' . $hero_title['image']); ?>" alt="Hero BG" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div id="heroImgPreview" class="w-full h-full flex items-center justify-center text-slate-400">
                                            <i class="fas fa-image text-3xl"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="flex-1">
                                    <div class="border-2 border-dashed border-slate-200 rounded-xl p-4 text-center hover:border-indigo-300 transition-colors cursor-pointer" onclick="document.getElementById('image_file_<?= $hero_title['id']; ?>').click()">
                                        <div class="flex flex-col items-center justify-center gap-1">
                                            <div class="w-10 h-10 bg-indigo-50 rounded-full flex items-center justify-center">
                                                <i class="fas fa-cloud-upload-alt text-indigo-500"></i>
                                            </div>
                                            <p class="text-sm font-medium text-slate-700">Click to upload new image</p>
                                            <p class="text-xs text-slate-500">JPG, PNG, GIF, WebP (Max 2MB)</p>
                                        </div>
                                        <input type="file" id="image_file_<?= $hero_title['id']; ?>" name="image_file_<?= $hero_title['id']; ?>" class="hidden" accept=".jpg,.jpeg,.png,.gif,.webp" onchange="previewHeroImage(this)">
                                    </div>
                                    <?php if (!empty($hero_title['image'])): ?>
                                        <p class="text-xs text-slate-500 mt-2">Current: <?= $hero_title['image']; ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Hero Description -->
                        <?php if (!empty($hero_desc['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Hero Description</label>
                            <input type="hidden" name="items[1][id]" value="<?= $hero_desc['id']; ?>">
                            <textarea name="items[1][content]" rows="3" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="Hero subtitle text..."><?= htmlspecialchars($hero_desc['content']); ?></textarea>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- 2. Contact Information Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">📋 Contact Information Cards</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Section Title -->
                        <?php if (!empty($info_title['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Section Title</label>
                            <input type="hidden" name="items[2][id]" value="<?= $info_title['id']; ?>">
                            <input type="text" name="items[2][content]" value="<?= htmlspecialchars($info_title['content']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                        <?php endif; ?>

                        <!-- Contact Cards Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php
                            $cards = array(
                                array('icon' => 'fa-map-marker-alt', 'label' => 'Office Address', 'title_item' => $office_title, 'content_item' => $office_content),
                                array('icon' => 'fa-phone',          'label' => 'Phone',          'title_item' => $phone_title,  'content_item' => $phone_content),
                                array('icon' => 'fa-envelope',       'label' => 'Email',          'title_item' => $email_title,  'content_item' => $email_content),
                                array('icon' => 'fa-clock',          'label' => 'Operating Hours', 'title_item' => $hours_title, 'content_item' => $hours_content),
                            );
                            $idx = 3;
                            foreach ($cards as $card):
                            ?>
                            <div class="border border-slate-200 rounded-xl p-5 space-y-4 hover:border-indigo-200 transition-colors">
                                <div class="flex items-center gap-2 mb-1">
                                    <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center">
                                        <i class="fas <?= $card['icon']; ?> text-indigo-500 text-sm"></i>
                                    </div>
                                    <span class="text-sm font-bold text-slate-800"><?= $card['label']; ?></span>
                                </div>

                                <?php if (!empty($card['title_item']['id'])): ?>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Card Title</label>
                                    <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $card['title_item']['id']; ?>">
                                    <input type="text" name="items[<?= $idx; ?>][content]" value="<?= htmlspecialchars($card['title_item']['content']); ?>" class="w-full p-2.5 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                                </div>
                                <?php $idx++; endif; ?>

                                <?php if (!empty($card['content_item']['id'])): ?>
                                <div>
                                    <label class="block text-xs font-medium text-slate-500 mb-1">Card Content</label>
                                    <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $card['content_item']['id']; ?>">
                                    <textarea name="items[<?= $idx; ?>][content]" rows="2" class="w-full p-2.5 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"><?= htmlspecialchars($card['content_item']['content']); ?></textarea>
                                </div>
                                <?php $idx++; endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </section>

                <!-- 3. Map Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">🗺️ Map Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <?php if (!empty($map_title['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Map Section Title</label>
                            <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $map_title['id']; ?>">
                            <input type="text" name="items[<?= $idx++; ?>][content]" value="<?= htmlspecialchars($map_title['content']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($map_desc['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Map Section Description</label>
                            <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $map_desc['id']; ?>">
                            <textarea name="items[<?= $idx++; ?>][content]" rows="3" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"><?= htmlspecialchars($map_desc['content']); ?></textarea>
                        </div>
                        <?php endif; ?>

                        <!-- Map Embed URL -->
                        <?php if (!empty($map_embed['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Google Maps Embed URL</label>
                            <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $map_embed['id']; ?>">
                            <input type="text" id="mapEmbedInput" name="items[<?= $idx++; ?>][content]" value="<?= htmlspecialchars($map_embed['content']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition" placeholder="https://www.google.com/maps?q=...&output=embed">
                            <div class="flex items-start gap-2 mt-2">
                                <i class="fas fa-info-circle text-indigo-400 mt-0.5 text-xs"></i>
                                <p class="text-xs text-slate-500">Paste the Google Maps embed URL here. Go to <a href="https://www.google.com/maps" target="_blank" class="text-indigo-500 hover:underline">Google Maps</a> → Search location → Share → Embed a map → Copy the <strong>src</strong> URL from the iframe code.</p>
                            </div>
                        </div>

                        <!-- Map Preview -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-semibold text-slate-700">Map Preview</label>
                                <button type="button" id="refreshMapBtn" class="text-xs font-medium text-indigo-600 hover:text-indigo-700 flex items-center gap-1 transition-colors">
                                    <i class="fas fa-sync-alt text-[10px]"></i> Refresh Preview
                                </button>
                            </div>
                            <div class="border border-slate-200 rounded-xl overflow-hidden">
                                <iframe id="mapPreviewFrame" src="<?= htmlspecialchars($map_embed['content']); ?>" width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" class="block"></iframe>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- 4. CTA Section -->
                <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <h3 class="font-bold text-slate-800 flex items-center">📢 Call to Action Section</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <?php if (!empty($cta_title['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">CTA Title</label>
                            <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $cta_title['id']; ?>">
                            <input type="text" name="items[<?= $idx++; ?>][content]" value="<?= htmlspecialchars($cta_title['content']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                        </div>
                        <?php endif; ?>

                        <?php if (!empty($cta_desc['id'])): ?>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">CTA Description</label>
                            <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $cta_desc['id']; ?>">
                            <textarea name="items[<?= $idx++; ?>][content]" rows="3" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition"><?= htmlspecialchars($cta_desc['content']); ?></textarea>
                        </div>
                        <?php endif; ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php if (!empty($cta_schedule['id'])): ?>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Schedule Button Text</label>
                                <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $cta_schedule['id']; ?>">
                                <input type="text" name="items[<?= $idx++; ?>][content]" value="<?= htmlspecialchars($cta_schedule['content']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>
                            <?php endif; ?>

                            <?php if (!empty($cta_demo['id'])): ?>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Demo Button Text</label>
                                <input type="hidden" name="items[<?= $idx; ?>][id]" value="<?= $cta_demo['id']; ?>">
                                <input type="text" name="items[<?= $idx++; ?>][content]" value="<?= htmlspecialchars($cta_demo['content']); ?>" class="w-full p-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition">
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>

            </div>
        </form>
    </div>
</main>

<script>
// Hero image preview
function previewHeroImage(input) {
    if (input.files && input.files[0]) {
        // Validate size
        if (input.files[0].size > 2 * 1024 * 1024) {
            Swal.fire('Error', 'File size exceeds 2MB limit.', 'error');
            input.value = '';
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            var preview = document.getElementById('heroImgPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.outerHTML = '<img id="heroImgPreview" src="' + e.target.result + '" alt="Hero BG" class="w-full h-full object-cover">';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Map preview refresh
var refreshMapBtn = document.getElementById('refreshMapBtn');
var mapInput = document.getElementById('mapEmbedInput');
var mapFrame = document.getElementById('mapPreviewFrame');

if (refreshMapBtn && mapInput && mapFrame) {
    refreshMapBtn.addEventListener('click', function() {
        var url = mapInput.value.trim();
        if (url) {
            mapFrame.src = url;
            // Spin icon briefly
            var icon = this.querySelector('i');
            icon.classList.add('fa-spin');
            setTimeout(function() { icon.classList.remove('fa-spin'); }, 1000);
        } else {
            Swal.fire('Warning', 'Please enter a Google Maps embed URL first.', 'warning');
        }
    });
}

// Scroll progress bar
window.addEventListener('scroll', function() {
    var scrollTop = window.scrollY;
    var docHeight = document.documentElement.scrollHeight - window.innerHeight;
    var progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
    var bar = document.querySelector('.scroll-progress');
    if (bar) bar.style.width = progress + '%';

    var header = document.querySelector('.sticky-header');
    if (header) {
        if (scrollTop > 10) header.classList.add('scrolled');
        else header.classList.remove('scrolled');
    }
});

// Save All Changes
document.getElementById('saveAllChanges').addEventListener('click', function() {
    var btn = this;
    var form = document.getElementById('contactCmsForm');
    var formData = new FormData(form);

    // Disable button & show loading
    btn.disabled = true;
    btn.classList.add('saving');
    var icon = document.getElementById('saveIcon');
    icon.innerHTML = '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>';
    icon.classList.add('animate-spin');

    fetch('<?= base_url('cms/contact_us_save_all'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(function(response) { return response.json(); })
    .then(function(result) {
        btn.disabled = false;
        btn.classList.remove('saving');
        icon.classList.remove('animate-spin');
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>';

        if (result.success) {
            Swal.fire({
                icon: 'success',
                title: 'Saved!',
                text: result.message,
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            Swal.fire('Error', result.message || 'Failed to save changes.', 'error');
        }
    })
    .catch(function(error) {
        btn.disabled = false;
        btn.classList.remove('saving');
        icon.classList.remove('animate-spin');
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>';
        Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
        console.error('Save error:', error);
    });
});
</script>
