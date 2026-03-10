<main class="ml-64 p-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Cookie Settings Management</h1>
                <p class="text-slate-500 mt-1">Edit cookie settings content using the visual editor below</p>
            </div>
            <div class="flex gap-3">
                <button onclick="previewPage()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl font-semibold hover:bg-slate-50 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                    </svg>
                    Preview
                </button>
                <button id="saveButton" onclick="savePage()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>

        <!-- Page Info -->
        <div class="bg-indigo-50 border border-indigo-200 rounded-xl p-4 mb-6">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-indigo-900 font-medium">About Cookie Settings</p>
                    <p class="text-sm text-indigo-700 mt-1">
                        This page allows users to manage their cookie preferences and understand what cookies are used on the website.
                    </p>
                </div>
            </div>
        </div>

        <!-- Editor Container -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <form id="pageForm">
                    <input type="hidden" name="page_slug" value="cookie_settings">
                    <input type="hidden" id="pageContent" name="data" value="">
                    
                    <label class="block text-sm font-medium text-slate-700 mb-2">Cookie Settings Content</label>
                    <!-- Quill Editor Container -->
                    <div id="pageEditor" style="height: 500px; background: white;"><?php echo $page_data->data ?? ''; ?></div>
                </form>
            </div>
        </div>

        <!-- Quick Access Links -->
        <div class="mt-6 grid grid-cols-3 gap-4">
            <a href="<?php echo base_url('cms/privacy_policy'); ?>" class="block p-4 bg-white border border-slate-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-slate-900">Privacy Policy</h4>
                        <p class="text-sm text-slate-500 mt-1">Manage privacy policy</p>
                    </div>
                    <span class="text-2xl">🛡️</span>
                </div>
            </a>
            
            <a href="<?php echo base_url('cms/terms_of_service'); ?>" class="block p-4 bg-white border border-slate-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-slate-900">Terms of Service</h4>
                        <p class="text-sm text-slate-500 mt-1">Manage terms and conditions</p>
                    </div>
                    <span class="text-2xl">📄</span>
                </div>
            </a>
            
            <a href="<?php echo base_url('cms/cookie_policy'); ?>" class="block p-4 bg-white border border-slate-200 rounded-xl hover:border-indigo-500 hover:shadow-md transition-all">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-slate-900">Cookie Policy</h4>
                        <p class="text-sm text-slate-500 mt-1">Manage cookie usage policy</p>
                    </div>
                    <span class="text-2xl">🍪</span>
                </div>
            </a>
        </div>

        <!-- Help Section -->
        <div class="mt-6 bg-slate-50 border border-slate-200 rounded-xl p-6">
            <h3 class="text-sm font-bold text-slate-800 mb-3">Editor Tips</h3>
            <ul class="space-y-2 text-sm text-slate-600">
                <li class="flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Select text and use the toolbar to <strong>Bold</strong>, <em>Italic</em>, Underline, etc.</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Press Ctrl+S (or Cmd+S on Mac) to save quickly</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <span>Use the image button in the toolbar to add images</span>
                </li>
            </ul>
        </div>
    </div>
</main>

<!-- Quill Rich Text Editor -->
<link href="<?php echo base_url('assets_system/vendor/quill/quill.snow.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets_system/vendor/quill/quill.js'); ?>"></script>

<!-- SweetAlert -->
<link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.min.css'); ?>">
<script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>

<script>
// Initialize Quill Editor
var quill = new Quill('#pageEditor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
            ['blockquote', 'code-block'],
            ['clean']
        ]
    },
    placeholder: 'Start writing your cookie settings content here...'
});

// Track changes
var hasUnsavedChanges = false;
quill.on('text-change', function() {
    hasUnsavedChanges = true;
    document.getElementById('saveButton').classList.add('ring-2', 'ring-amber-400');
});

// Save page function
function savePage() {
    const saveBtn = document.getElementById('saveButton');
    const originalHTML = saveBtn.innerHTML;
    
    // Show loading
    saveBtn.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Saving...</span>
    `;
    saveBtn.disabled = true;
    
    // Get content from Quill
    const content = quill.root.innerHTML;
    
    // Update hidden field
    document.getElementById('pageContent').value = content;
    
    const formData = new FormData(document.getElementById('pageForm'));
    
    console.log('Saving to:', '<?php echo base_url('cms/save_custom_page'); ?>');
    console.log('Content length:', content.length);
    console.log('Page slug:', formData.get('page_slug'));
    
    // Save to server
    fetch('<?php echo base_url('cms/save_custom_page'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        
        // Try to get response as text first
        return response.text();
    })
    .then(text => {
        console.log('Response text:', text);
        
        // Try to parse as JSON
        try {
            const data = JSON.parse(text);
            console.log('Parsed JSON:', data);
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Saved!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Remove save indicator
                hasUnsavedChanges = false;
                saveBtn.classList.remove('ring-2', 'ring-amber-400');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message,
                    confirmButtonColor: '#dc2626'
                });
            }
        } catch (e) {
            console.error('JSON parse error:', e);
            Swal.fire({
                icon: 'error',
                title: 'Server Error',
                text: 'Server returned invalid response. Check console for details.',
                confirmButtonColor: '#dc2626'
            });
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Network Error',
            text: 'Failed to save page: ' + error.message + '. Check console for details.',
            confirmButtonColor: '#dc2626'
        });
    })
    .finally(() => {
        // Restore button
        saveBtn.innerHTML = originalHTML;
        saveBtn.disabled = false;
    });
}

// Preview page function
function previewPage() {
    const content = quill.root.innerHTML;
    const previewWindow = window.open('', 'Preview', 'width=1024,height=768');
    
    previewWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Cookie Settings - Preview</title>
            <script src="<?php echo base_url('assets_system/vendor/tailwindcss/tailwind.min.js'); ?>"><\/script>
            <link href="<?php echo base_url('assets_system/vendor/quill/quill.snow.css'); ?>" rel="stylesheet">
            <style>
                body { 
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; 
                }
                .ql-editor {
                    padding: 0;
                    line-height: 1.6;
                }
                .ql-editor h1 { font-size: 2em; font-weight: bold; margin: 1em 0 0.5em; }
                .ql-editor h2 { font-size: 1.5em; font-weight: bold; margin: 1em 0 0.5em; }
                .ql-editor h3 { font-size: 1.25em; font-weight: bold; margin: 1em 0 0.5em; }
                .ql-editor p { margin: 0.5em 0; }
                .ql-editor ul, .ql-editor ol { margin: 0.5em 0; padding-left: 2em; }
                .ql-editor li { margin: 0.25em 0; }
                .ql-editor a { color: #4f46e5; text-decoration: underline; }
                .ql-editor img { max-width: 100%; height: auto; margin: 1em 0; }
                .ql-editor strong { font-weight: bold; }
                .ql-editor em { font-style: italic; }
                .ql-editor blockquote { 
                    border-left: 4px solid #e5e7eb; 
                    padding-left: 1em; 
                    margin: 1em 0; 
                    color: #6b7280; 
                }
            </style>
        </head>
        <body class="bg-slate-50">
            <div class="max-w-4xl mx-auto py-12 px-6">
                <div class="bg-white rounded-2xl shadow-sm p-8">
                    <h1 class="text-3xl font-bold text-slate-900 mb-6">Cookie Settings</h1>
                    <div class="ql-editor">
                        ${content}
                    </div>
                </div>
            </div>
        </body>
        </html>
    `);
    
    previewWindow.document.close();
}

// Warn before leaving with unsaved changes
window.addEventListener('beforeunload', function(e) {
    if (hasUnsavedChanges) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        return e.returnValue;
    }
});

// Keyboard shortcut: Ctrl+S to save
document.addEventListener('keydown', function(e) {
    if ((e.ctrlKey || e.metaKey) && e.key === 's') {
        e.preventDefault();
        savePage();
    }
});
</script>

</body>
</html>
