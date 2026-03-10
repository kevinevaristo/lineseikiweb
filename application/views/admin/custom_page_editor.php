<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title ?? 'Page Editor'); ?> | Admin</title>
    
    <!-- Tailwind CSS -->
    <script src="<?php echo base_url('assets_system/vendor/tailwindcss/tailwind.min.js'); ?>"></script>
    
    <style>
        textarea {
            resize: vertical;
            min-height: 500px;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', 'Consolas', monospace;
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Simple HTML formatting helper */
        .format-buttons {
            display: flex;
            gap: 5px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }
        
        .format-btn {
            padding: 5px 10px;
            background: #f3f4f6;
            border: 1px solid #d1d5db;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .format-btn:hover {
            background: #e5e7eb;
        }
        
        .editor-help {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin-top: 15px;
            font-size: 13px;
        }
    </style>
</head>
<body class="bg-gray-50">
    
<!-- Include your admin sidebar/header -->
<div class="ml-64 p-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <?php echo htmlspecialchars($page_title ?? 'Edit Page'); ?>
                </h1>
                <p class="text-gray-500 mt-1">Edit HTML content directly in the textarea below</p>
            </div>
            
            <div class="flex gap-3">
                <a href="<?php echo base_url($page_slug); ?>" target="_blank" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Page
                </a>
                
                <button type="submit" form="pageForm" class="px-5 py-2.5 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition-all flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Save Changes
                </button>
            </div>
        </div>
        
        <!-- Flash Messages -->
        <?php if($this->session->flashdata('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if($this->session->flashdata('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Page Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <div class="flex-1">
                    <p class="text-sm text-blue-900 font-medium">Page Information</p>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <div>
                            <p class="text-xs text-blue-700">Page Slug:</p>
                            <code class="text-sm bg-white px-2 py-1 rounded border">
                                <?php echo htmlspecialchars($page_slug ?? ''); ?>
                            </code>
                        </div>
                        <div>
                            <p class="text-xs text-blue-700">Live URL:</p>
                            <a href="<?php echo base_url($page_slug); ?>" target="_blank" class="text-sm text-blue-600 hover:underline">
                                <?php echo base_url($page_slug); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Editor Container -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="p-6">
                <form id="pageForm" method="POST" action="<?php echo site_url('cms/save_custom_page'); ?>">
                    <input type="hidden" name="page_slug" value="<?php echo htmlspecialchars($page_slug ?? ''); ?>">
                    
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        HTML Content Editor
                    </label>
                    
                    <!-- Simple Formatting Buttons -->
                    <div class="format-buttons mb-4">
                        <span class="text-xs text-gray-500 mr-3">Quick insert:</span>
                        <button type="button" onclick="insertAtCursor('pageContent', '<p></p>')" class="format-btn">Paragraph</button>
                        <button type="button" onclick="insertAtCursor('pageContent', '<h1></h1>')" class="format-btn">H1</button>
                        <button type="button" onclick="insertAtCursor('pageContent', '<h2></h2>')" class="format-btn">H2</button>
                        <button type="button" onclick="insertAtCursor('pageContent', '<h3></h3>')" class="format-btn">H3</button>
                        <button type="button" onclick="insertAtCursor('pageContent', '<strong></strong>')" class="format-btn">Bold</button>
                        <button type="button" onclick="insertAtCursor('pageContent', '<em></em>')" class="format-btn">Italic</button>
                        <button type="button" onclick="insertAtCursor('pageContent', '<ul>\n<li></li>\n</ul>')" class="format-btn">List</button>
                        
                        <button type="button" onclick="insertAtCursor('pageContent', '<br>')" class="format-btn">Line Break</button>
                    </div>
                    
                    <!-- Textarea Editor -->
                    <textarea 
                        id="pageContent" 
                        name="content" 
                        class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        rows="25"
                    ><?php echo htmlspecialchars($page_content ?? ''); ?></textarea>
                    
                    <div class="editor-help">
                        <p class="font-medium text-amber-900 mb-1">HTML Tips:</p>
                        <ul class="text-amber-800 text-xs space-y-1">
                            <li>• Use <code>&lt;p&gt;</code> for paragraphs</li>
                            <li>• Use <code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code> for headings</li>
                            <li>• Use <code>&lt;ul&gt;</code> and <code>&lt;li&gt;</code> for lists</li>
                            <li>• Use <code>&lt;strong&gt;</code> for bold and <code>&lt;em&gt;</code> for italic</li>
                            <li>• Use <code>&lt;a href="URL"&gt;Link Text&lt;/a&gt;</code> for links</li>
                            <li>• Content will be saved exactly as HTML</li>
                        </ul>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Character Count & Info -->
        <div class="mt-4 flex justify-between items-center text-sm text-gray-500">
            <div>
                Characters: <span id="charCount">0</span>
                | Words: <span id="wordCount">0</span>
            </div>
            <div>
                Last updated: <?php echo isset($page->updated_at) ? date('M d, Y H:i', strtotime($page->updated_at)) : 'Never'; ?>
            </div>
        </div>
        
    </div>
</div>

<script>
// Character counter
function updateCounters() {
    const textarea = document.getElementById('pageContent');
    const text = textarea.value;
    
    // Character count
    document.getElementById('charCount').textContent = text.length;
    
    // Word count (simple)
    const words = text.trim().split(/\s+/).filter(word => word.length > 0);
    document.getElementById('wordCount').textContent = words.length;
}

// Insert text at cursor position
function insertAtCursor(textareaId, textToInsert) {
    const textarea = document.getElementById(textareaId);
    const startPos = textarea.selectionStart;
    const endPos = textarea.selectionEnd;
    const selectedText = textarea.value.substring(startPos, endPos);
    
    // Insert the text
    textarea.value = textarea.value.substring(0, startPos) + 
                     textToInsert.replace('></', '>' + selectedText + '</') + 
                     textarea.value.substring(endPos);
    
    // Move cursor inside the new tags
    const newCursorPos = startPos + textToInsert.indexOf('>') + 1;
    if (selectedText.length === 0) {
        textarea.selectionStart = newCursorPos;
        textarea.selectionEnd = newCursorPos;
    } else {
        textarea.selectionStart = startPos;
        textarea.selectionEnd = startPos + textToInsert.length;
    }
    
    textarea.focus();
    updateCounters();
}

// Initialize counters
document.addEventListener('DOMContentLoaded', function() {
    const textarea = document.getElementById('pageContent');
    
    // Set initial counts
    updateCounters();
    
    // Update on input
    textarea.addEventListener('input', updateCounters);
    
    // Auto-resize textarea
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
    
    // Tab key support
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            e.preventDefault();
            const start = this.selectionStart;
            const end = this.selectionEnd;
            
            // Insert tab
            this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);
            
            // Move cursor
            this.selectionStart = this.selectionEnd = start + 4;
        }
    });
    
    // Keyboard shortcut: Ctrl+S to save
    textarea.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            document.getElementById('pageForm').submit();
        }
    });
    
    // Focus on textarea
    textarea.focus();
});

// Confirm before leaving if there are changes
let originalContent = document.getElementById('pageContent').value;
window.addEventListener('beforeunload', function(e) {
    const currentContent = document.getElementById('pageContent').value;
    if (originalContent !== currentContent) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
    }
});

// Update original content on form submit
document.getElementById('pageForm').addEventListener('submit', function() {
    originalContent = document.getElementById('pageContent').value;
});
</script>

</body>
</html>