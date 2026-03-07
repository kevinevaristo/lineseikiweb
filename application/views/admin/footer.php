<style>
    .content-editor {
        transition: all 0.2s ease;
    }
    .content-editor:focus {
        background-color: #fffbeb;
        transform: scale(1.01);
    }
    .social-item {
        transition: all 0.3s ease;
        cursor: move;
    }
    .social-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    .delete-btn {
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    .social-item:hover .delete-btn {
        opacity: 1;
    }
    .dragging {
        opacity: 0.5;
        transform: scale(1.02);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .drag-over {
        border: 2px dashed #3b82f6;
        background-color: #eff6ff;
    }
</style>

<main class="ml-64 p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Footer Content</h1>
            <p class="text-gray-600">Edit your footer text and links directly</p>
        </div>

        <!-- Simple Edit Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form id="footerForm">
                <div class="space-y-8">
                    <!-- NEW: Header Text Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            Footer Header Text
                        </h2>
                        
                        <div class="space-y-4">
                            <?php 
                            // Find header text item from your database
                            $header_text_item = null;
                            $sub_text_item = null;
                            foreach ($social_items as $item) {
                                if ($item['title'] === 'footer_header') {
                                    $header_text_item = $item;
                                }
                                if ($item['title'] === 'footer_subtext') {
                                    $sub_text_item = $item;
                                }
                            }
                            ?>
                            
                            <!-- Header Text Input -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                    Header Title
                                </label>
                                <?php if ($contact_title): ?>
                                <input 
                                    type="text"
                                    name="contact_section_title"
                                    data-id="<?php echo $contact_title['id']; ?>"
                                    value="<?php echo htmlspecialchars($contact_title['content']); ?>"
                                    class="content-editor w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="e.g., Stay Connected"
                                >
                                <?php else: ?>
                                <input 
                                    type="text"
                                    name="contact_section_title"
                                    class="content-editor w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="e.g., Stay Connected"
                                >
                                <?php endif; ?>
                                <p class="text-xs text-gray-500 mt-1">Main heading for your footer section</p>
                            </div>

                            <!-- Sub Text Input -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-1 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                    </svg>
                                    Sub Text / Description
                                </label>
                                <?php if ($contact_description): ?>
                                <textarea 
                                    name="contact_section_description"
                                    data-id="<?php echo $contact_description['id']; ?>"
                                    rows="2"
                                    class="content-editor w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    placeholder="e.g., Follow us on social media for updates and news"
                                ><?php echo htmlspecialchars($contact_description['content']); ?></textarea>
                                <?php else: ?>
                                <textarea 
                                    name="contact_section_description"
                                    rows="2"
                                    class="content-editor w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                    placeholder="e.g., Follow us on social media for updates and news"
                                ></textarea>
                                <?php endif; ?>
                                <p class="text-xs text-gray-500 mt-1">Supporting text that appears below the header</p>
                            </div>
                        </div>
                    </div>

                    <!-- Social Media Links (Existing) -->
                    <div class="border-b border-gray-200 pb-8">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Social Media Links
                            </h2>
                            <button type="button" id="addSocialBtn" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold flex items-center">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Social Media
                            </button>
                        </div>
                        
                        <div id="socialItemsContainer" class="space-y-4">
                            <?php 
                            // Filter out header items from social_items
                            $filtered_social_items = array_filter($social_items, function($item) {
                                return !in_array($item['title'], ['footer_header', 'footer_subtext']);
                            });
                            ?>
                            
                            <?php if (!empty($filtered_social_items)): ?>
                                <?php foreach ($filtered_social_items as $item): 
                                    $platform = str_replace('social_', '', $item['title']);
                                    $icon_map = [
                                        'facebook' => 'fa-facebook',
                                        'twitter' => 'fa-twitter',
                                        'linkedin' => 'fa-linkedin',
                                        'instagram' => 'fa-instagram',
                                        'youtube' => 'fa-youtube',
                                        'pinterest' => 'fa-pinterest',
                                        'tiktok' => 'fa-tiktok',
                                        'whatsapp' => 'fa-whatsapp',
                                        'telegram' => 'fa-telegram',
                                        'github' => 'fa-github',
                                        'dribbble' => 'fa-dribbble',
                                        'behance' => 'fa-behance'
                                    ];
                                    $icon = isset($icon_map[$platform]) ? $icon_map[$platform] : 'fa-globe';
                                ?>
                                <div class="social-item bg-gray-50 rounded-lg p-4 border border-gray-200" data-id="<?php echo $item['id']; ?>" draggable="true">
                                    <div class="flex items-center gap-3">
                                        <div class="cursor-move text-gray-400 hover:text-gray-600 drag-handle">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                <i class="fab <?php echo $icon; ?> mr-2"></i>
                                                <span class="platform-name"><?php echo ucfirst($platform); ?></span> URL
                                            </label>
                                            <div class="flex gap-2">
                                                <input 
                                                    type="url"
                                                    name="<?php echo $item['title']; ?>"
                                                    data-id="<?php echo $item['id']; ?>"
                                                    value="<?php echo htmlspecialchars($item['content']); ?>"
                                                    class="content-editor flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="https://<?php echo $platform; ?>.com/yourpage"
                                                >
                                                <button type="button" class="delete-btn px-3 py-3 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors" onclick="deleteSocialItem(<?php echo $item['id']; ?>, this)">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                                    <p class="text-gray-500">No social media links yet. Click "Add Social Media" to get started.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Drag and drop to reorder social media links</p>
                    </div>

                    <!-- Copyright Text (Existing) -->
                    <div class="border-b border-gray-200 pb-8">
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Copyright Text
                        </h2>
                        
                        <?php if ($copyright_item): ?>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Copyright Notice
                            </label>
                            <textarea 
                                name="copyright"
                                data-id="<?php echo $copyright_item['id']; ?>"
                                rows="3"
                                class="content-editor w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                                placeholder="© <?php echo date('Y'); ?> Your Company. All rights reserved."
                            ><?php echo htmlspecialchars($copyright_item['content']); ?></textarea>
                            <p class="text-xs text-gray-500 mt-1">This text appears at the bottom of your website footer</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="mt-8 flex justify-end">
                    <button 
                        type="submit" 
                        id="saveButton"
                        class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:scale-105"
                    >
                        <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Save All Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Add Social Modal (Existing) -->
        <div id="addSocialModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg p-6 max-w-md w-full">
                <h3 class="text-xl font-bold mb-4">Add Social Media</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Select Platform</label>
                    <select id="newSocialPlatform" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                        <option value="">Select Platform</option>
                        <option value="facebook" data-icon="fa-facebook">Facebook</option>
                        <option value="twitter" data-icon="fa-twitter">Twitter / X</option>
                        <option value="linkedin" data-icon="fa-linkedin">LinkedIn</option>
                        <option value="instagram" data-icon="fa-instagram">Instagram</option>
                        <option value="youtube" data-icon="fa-youtube">YouTube</option>
                        <option value="pinterest" data-icon="fa-pinterest">Pinterest</option>
                        <option value="tiktok" data-icon="fa-tiktok">TikTok</option>
                        <option value="whatsapp" data-icon="fa-whatsapp">WhatsApp</option>
                        <option value="telegram" data-icon="fa-telegram">Telegram</option>
                        <option value="github" data-icon="fa-github">GitHub</option>
                        <option value="dribbble" data-icon="fa-dribbble">Dribbble</option>
                        <option value="behance" data-icon="fa-behance">Behance</option>
                        <option value="snapchat" data-icon="fa-snapchat">Snapchat</option>
                        <option value="reddit" data-icon="fa-reddit">Reddit</option>
                        <option value="tumblr" data-icon="fa-tumblr">Tumblr</option>
                        <option value="vimeo" data-icon="fa-vimeo">Vimeo</option>
                        <option value="soundcloud" data-icon="fa-soundcloud">SoundCloud</option>
                        <option value="spotify" data-icon="fa-spotify">Spotify</option>
                        <option value="discord" data-icon="fa-discord">Discord</option>
                        <option value="twitch" data-icon="fa-twitch">Twitch</option>
                    </select>
                </div>
                
                <!-- Icon Preview -->
                <div class="mb-4 p-4 bg-gray-50 rounded-lg text-center" id="iconPreview">
                    <p class="text-sm text-gray-500 mb-2">Icon Preview:</p>
                    <i class="fab fa-facebook text-4xl text-blue-600" id="previewIcon"></i>
                    <p class="text-sm text-gray-600 mt-2" id="previewText">Facebook</p>
                </div>
                
                <div class="flex gap-2">
                    <button type="button" onclick="addNewSocial()" class="flex-1 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg">
                        Add
                    </button>
                    <button type="button" onclick="closeModal()" class="flex-1 px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div id="successMessage" class="hidden fixed top-4 right-4 bg-green-50 border-l-4 border-green-500 text-green-900 p-4 rounded-lg shadow-lg z-50 max-w-md">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold">Success!</p>
                    <p class="text-sm text-green-700" id="successMessageText">Your changes have been saved.</p>
                </div>
            </div>
        </div>

        <!-- Error Message -->
        <div id="errorMessage" class="hidden fixed top-4 right-4 bg-red-50 border-l-4 border-red-500 text-red-900 p-4 rounded-lg shadow-lg z-50 max-w-md">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="font-semibold">Error</p>
                    <p class="text-sm text-red-700" id="errorMessageText">Please try again.</p>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Icon preview functionality
document.getElementById('newSocialPlatform').addEventListener('change', function() {
    const selected = this.options[this.selectedIndex];
    const iconClass = selected.getAttribute('data-icon') || 'fa-globe';
    const platformName = selected.text;
    
    document.getElementById('previewIcon').className = `fab ${iconClass} text-4xl text-blue-600`;
    document.getElementById('previewText').textContent = platformName;
});
</script>

<script>
const baseUrl = '<?php echo base_url(); ?>';

// Drag and Drop functionality
let draggedItem = null;

document.querySelectorAll('.social-item').forEach(item => {
    item.addEventListener('dragstart', handleDragStart);
    item.addEventListener('dragend', handleDragEnd);
    item.addEventListener('dragover', handleDragOver);
    item.addEventListener('dragenter', handleDragEnter);
    item.addEventListener('dragleave', handleDragLeave);
    item.addEventListener('drop', handleDrop);
});

function handleDragStart(e) {
    this.classList.add('dragging');
    draggedItem = this;
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
}

function handleDragEnter(e) {
    e.preventDefault();
    this.classList.add('drag-over');
}

function handleDragLeave(e) {
    this.classList.remove('drag-over');
}

function handleDragEnd(e) {
    this.classList.remove('dragging');
    document.querySelectorAll('.social-item').forEach(item => {
        item.classList.remove('drag-over');
    });
}

function handleDrop(e) {
    e.preventDefault();
    this.classList.remove('drag-over');
    
    if (draggedItem !== this) {
        const container = document.getElementById('socialItemsContainer');
        const items = [...container.children];
        const draggedIndex = items.indexOf(draggedItem);
        const droppedIndex = items.indexOf(this);
        
        if (draggedIndex < droppedIndex) {
            this.parentNode.insertBefore(draggedItem, this.nextSibling);
        } else {
            this.parentNode.insertBefore(draggedItem, this);
        }
        
        // Update sort order in database
        updateSortOrder();
    }
}

function updateSortOrder() {
    const container = document.getElementById('socialItemsContainer');
    const items = container.children;
    const order = [];
    
    for (let i = 0; i < items.length; i++) {
        const id = items[i].getAttribute('data-id');
        if (id) order.push(id);
    }
    
    // Send sort order to server
    fetch(`${baseUrl}cms/footer_update_sort_order`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'order=' + JSON.stringify(order)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Sort order updated');
        }
    })
    .catch(error => console.error('Error updating sort order:', error));
}

// Modal functions
function openModal() {
    document.getElementById('addSocialModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('addSocialModal').classList.add('hidden');
    document.getElementById('newSocialPlatform').value = '';
}

document.getElementById('addSocialBtn').addEventListener('click', openModal);

function addNewSocial() {
    const select = document.getElementById('newSocialPlatform');
    const platform = select.value;
    const selectedOption = select.options[select.selectedIndex];
    const iconClass = selectedOption.getAttribute('data-icon') || 'fa-globe';
    
    if (!platform) {
        alert('Please select a platform');
        return;
    }
    
    const addBtn = event.target;
    const originalText = addBtn.innerHTML;
    addBtn.innerHTML = 'Adding...';
    addBtn.disabled = true;
    
    // Create form data
    const formData = new URLSearchParams();
    formData.append('platform', platform);
    formData.append('icon_class', iconClass);
    
    fetch(`${baseUrl}cms/footer_add_social`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        credentials: 'same-origin',
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const container = document.getElementById('socialItemsContainer');
            
            // Remove empty message if it exists
            const emptyMessage = container.querySelector('.text-center');
            if (emptyMessage) {
                emptyMessage.remove();
            }
            
            const newItem = createSocialItemElement(platform, data.id, data.title, iconClass);
            container.appendChild(newItem);
            
            // Initialize drag and drop for new item
            initializeDragDrop(newItem);
            
            closeModal();
            showSuccessMessage('Social media added successfully!');
        } else {
            alert('Failed to add social media: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding social media');
    })
    .finally(() => {
        addBtn.innerHTML = originalText;
        addBtn.disabled = false;
    });
}

function initializeDragDrop(element) {
    if (!element) return;
    
    // Make element draggable
    element.setAttribute('draggable', 'true');
    
    // Add event listeners
    element.addEventListener('dragstart', handleDragStart);
    element.addEventListener('dragend', handleDragEnd);
    element.addEventListener('dragover', handleDragOver);
    element.addEventListener('dragenter', handleDragEnter);
    element.addEventListener('dragleave', handleDragLeave);
    element.addEventListener('drop', handleDrop);
}

function createSocialItemElement(platform, id, title, iconClass) {
    const platformName = platform.charAt(0).toUpperCase() + platform.slice(1);
    
    const div = document.createElement('div');
    div.className = 'social-item bg-gray-50 rounded-lg p-4 border border-gray-200';
    div.setAttribute('draggable', 'true');
    div.setAttribute('data-id', id);
    
    div.innerHTML = `
        <div class="flex items-center gap-3">
            <div class="cursor-move text-gray-400 hover:text-gray-600 drag-handle">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fab ${iconClass} mr-2"></i>
                    <span class="platform-name">${platformName}</span> URL
                    <span class="ml-2 text-xs text-gray-400">(${iconClass})</span>
                </label>
                <div class="flex gap-2">
                    <input 
                        type="url"
                        name="${title}"
                        data-id="${id}"
                        value=""
                        class="content-editor flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="https://${platform}.com/yourpage"
                    >
                    <button type="button" class="delete-btn px-3 py-3 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors" onclick="deleteSocialItem(${id}, this)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    return div;
}

function deleteSocialItem(id, button) {
    if (!confirm('Are you sure you want to delete this social media link?')) {
        return;
    }
    
    // Show loading state
    const originalHtml = button.innerHTML;
    button.innerHTML = '<svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
    button.disabled = true;
    
    fetch(`${baseUrl}cms/footer_delete_social`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'id=' + id
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove the item from DOM
            const socialItem = button.closest('.social-item');
            socialItem.remove();
            showSuccessMessage('Social media deleted successfully!');
            
            // Show empty message if no items left
            const container = document.getElementById('socialItemsContainer');
            if (container.children.length === 0) {
                container.innerHTML = '<div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200"><p class="text-gray-500">No social media links yet. Click "Add Social Media" to get started.</p></div>';
            }
        } else {
            alert('Failed to delete social media');
            button.innerHTML = originalHtml;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error deleting social media');
        button.innerHTML = originalHtml;
        button.disabled = false;
    });
}

document.getElementById('footerForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const saveButton = document.getElementById('saveButton');
    const originalHtml = saveButton.innerHTML;
    
    // Show loading state
    saveButton.innerHTML = `
        <svg class="animate-spin h-5 w-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Saving...
    `;
    saveButton.disabled = true;
    
    // Collect all form data
    const formData = new FormData();
    
    // Get all inputs and textareas
    const fields = this.querySelectorAll('input, textarea');
    fields.forEach(field => {
        const itemId = field.getAttribute('data-id');
        const value = field.value;
        
        if (itemId) {
            // If it has data-id, use item_ID format (what your controller expects)
            formData.append(`item_${itemId}`, value);
        } else {
            // If no data-id, use the field name (for new fields)
            formData.append(field.name, value);
        }
    });
    
    fetch(`${baseUrl}cms/footer_save_all`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        saveButton.innerHTML = originalHtml;
        saveButton.disabled = false;
        
        if (data.success) {
            showSuccessMessage('Changes saved successfully!');
            
            // Add visual feedback to all fields
            fields.forEach(field => {
                field.classList.add('border-green-500', 'bg-green-50');
                setTimeout(() => {
                    field.classList.remove('border-green-500', 'bg-green-50');
                }, 2000);
            });
        } else {
            showErrorMessage(data.message || 'Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        saveButton.innerHTML = originalHtml;
        saveButton.disabled = false;
        showErrorMessage('Network error. Please check your connection.');
    });
});

function showSuccessMessage(message) {
    const successMsg = document.getElementById('successMessage');
    document.getElementById('successMessageText').textContent = message;
    successMsg.classList.remove('hidden');
    setTimeout(() => {
        successMsg.classList.add('hidden');
    }, 4000);
}

function showErrorMessage(message) {
    const errorMsg = document.getElementById('errorMessage');
    document.getElementById('errorMessageText').textContent = message;
    errorMsg.classList.remove('hidden');
    setTimeout(() => {
        errorMsg.classList.add('hidden');
    }, 4000);
}

// Keyboard shortcut: Ctrl/Cmd + S to save
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        document.getElementById('saveButton').click();
    }
});

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('addSocialModal');
    if (event.target == modal) {
        closeModal();
    }
}
</script>