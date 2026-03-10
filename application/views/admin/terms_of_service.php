<!-- TinyMCE Editor -->
<script src="<?php echo base_url('assets_system/vendor/tinymce/tinymce.min.js'); ?>" referrerpolicy="origin"></script>

<main class="ml-64 p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Terms of Service Management</h1>
                    <p class="text-gray-600">Manage your website's terms and conditions</p>
                </div>
                <button id="saveBtn" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
            
            <!-- Info Card -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-600 text-xl mr-3 mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-blue-900 mb-1">About Terms of Service</h3>
                        <p class="text-sm text-blue-800">
                            Use the rich text editor below to create and format your terms of service. This content will be displayed on your website's terms and conditions page.
                            Make sure to include all rules, regulations, and legal terms that govern the use of your services.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editor Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-bold text-gray-800">Terms of Service Content</h3>
                        <p class="text-sm text-gray-500 mt-1">Use the WYSIWYG editor to format your content</p>
                    </div>
                    <?php if (!empty($page_data)): ?>
                        <span class="text-sm text-gray-500">
                            Last updated: <?php echo !empty($page_data['updated_at']) ? date('M d, Y', strtotime($page_data['updated_at'])) : 'Never'; ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="p-6">
                <form id="termsForm">
                    <input type="hidden" name="id" value="<?php echo !empty($page_data) ? $page_data['id'] : ''; ?>">
                    <input type="hidden" name="page" value="terms_of_service">
                    
                    <div class="mb-6">
                        <label for="termsContent" class="block text-sm font-medium text-gray-700 mb-2">
                            Terms of Service Content
                        </label>
                        <textarea id="termsContent" name="data" class="w-full border border-gray-300 rounded-lg p-4 min-h-[500px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"><?php echo !empty($page_data) ? htmlspecialchars($page_data['data']) : ''; ?></textarea>
                    </div>
                    
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <div class="text-sm text-gray-500">
                            <i class="fas fa-lightbulb mr-1"></i>
                            Tip: Use headings, lists, and formatting to make your terms easy to read
                        </div>
                        <div class="flex gap-3">
                            <button type="button" id="previewBtn" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                <i class="fas fa-eye mr-2"></i> Preview
                            </button>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Access Links -->
        <div class="mt-6 grid grid-cols-2 gap-4">
            <a href="<?php echo base_url('cms/privacy_policy'); ?>" class="block p-4 bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">Privacy Policy</h4>
                        <p class="text-sm text-gray-500 mt-1">Manage privacy policy</p>
                    </div>
                    <i class="fas fa-shield-alt text-2xl text-gray-400"></i>
                </div>
            </a>
            
            <a href="<?php echo base_url('cms/cookie_policy'); ?>" class="block p-4 bg-white border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-gray-900">Cookie Policy</h4>
                        <p class="text-sm text-gray-500 mt-1">Manage cookie usage policy</p>
                    </div>
                    <i class="fas fa-cookie-bite text-2xl text-gray-400"></i>
                </div>
            </a>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Terms of Service Preview</h3>
                <button onclick="closePreview()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div class="p-6 overflow-y-auto" style="max-height: calc(90vh - 120px);">
                <div id="previewContent" class="prose max-w-none"></div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <button onclick="closePreview()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                    Close Preview
                </button>
            </div>
        </div>
    </div>
</main>

<!-- Notification Container -->
<div id="notificationContainer" class="fixed top-4 right-4 z-50"></div>

<script>
    const baseUrl = '<?php echo base_url(); ?>';

    // Initialize TinyMCE
    tinymce.init({
        selector: '#termsContent',
        height: 600,
        menubar: true,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount'
        ],
        toolbar: 'undo redo | formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | removeformat | code | fullscreen',
        content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; font-size: 14px; line-height: 1.6; }',
        branding: false,
        promotion: false
    });

    // Show notification
    function showNotification(message, type = 'success') {
        const container = document.getElementById('notificationContainer');
        const notification = document.createElement('div');
        
        const bgColor = type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
                       type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
                       'bg-blue-50 border-blue-200 text-blue-800';
        
        notification.className = `mb-3 px-6 py-4 rounded-lg border ${bgColor} shadow-lg animate-slide-in`;
        notification.innerHTML = `
            <div class="flex items-center">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : type === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle'} mr-3"></i>
                <span class="flex-1">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        container.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 5000);
    }

    // Handle form submission
    document.getElementById('termsForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = this.querySelector('button[type="submit"]');
        const saveBtn = document.getElementById('saveBtn');
        const originalHtml = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';
        submitBtn.disabled = true;
        saveBtn.disabled = true;
        
        const content = tinymce.get('termsContent').getContent();
        const formData = new FormData(this);
        formData.set('data', content);
        
        fetch(baseUrl + 'cms/save_custom_page', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
            } else {
                showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Network error. Please try again.', 'error');
        })
        .finally(() => {
            submitBtn.innerHTML = originalHtml;
            submitBtn.disabled = false;
            saveBtn.disabled = false;
        });
    });

    document.getElementById('saveBtn').addEventListener('click', function() {
        document.getElementById('termsForm').dispatchEvent(new Event('submit'));
    });

    document.getElementById('previewBtn').addEventListener('click', function() {
        const content = tinymce.get('termsContent').getContent();
        document.getElementById('previewContent').innerHTML = content;
        document.getElementById('previewModal').classList.remove('hidden');
    });

    function closePreview() {
        document.getElementById('previewModal').classList.add('hidden');
    }

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            document.getElementById('saveBtn').click();
        }
        if (e.key === 'Escape') {
            closePreview();
        }
    });
</script>

<style>
    @keyframes slide-in {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
</style>

</body>
</html>
