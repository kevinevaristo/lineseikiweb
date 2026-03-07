

<main class="ml-64 p-8">
    <!-- Sticky Header -->
    <div class="sticky top-0 z-40 bg-slate-50 -mx-8 px-8 py-4 mb-8">
        <div class="max-w-7xl mx-auto">
            <!-- Simple Back Button Row -->
            <div class="flex items-center mb-4">
                <a href="<?= base_url('cms/messages') ?>" 
                   class="inline-flex items-center text-indigo-600 hover:text-indigo-800 group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="font-medium">Back to Messages Dashboard</span>
                </a>
            </div>
            
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">View Message</h1>
                    <p class="text-slate-500 mt-1">Message #<?= $message->id ?> - <?= htmlspecialchars($message->subject) ?></p>
                </div>
                
                <div class="flex gap-3">
                    <a href="mailto:<?= htmlspecialchars($message->email) ?>" class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                        Reply via Email
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Message Content -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                        <div class="flex justify-between items-start">
                            <h3 class="font-bold text-slate-800 flex items-center">
                                <span class="mr-2">📧</span> Message Details
                            </h3>
                            <span class="px-3 py-1 text-sm font-medium rounded-full <?php
                                $statusColors = [
                                    'new' => 'bg-red-100 text-red-800',
                                    'read' => 'bg-yellow-100 text-yellow-800',
                                    'replied' => 'bg-green-100 text-green-800',
                                    'archived' => 'bg-slate-100 text-slate-800'
                                ];
                                echo $statusColors[$message->status] ?? 'bg-slate-100 text-slate-800';
                            ?>">
                                <?= ucfirst($message->status) ?>
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <!-- Sender Info -->
                        <div class="bg-slate-50 rounded-xl p-4 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">From</label>
                                    <p class="text-slate-900 font-medium"><?= htmlspecialchars($message->name) ?></p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</label>
                                    <p class="text-indigo-600">
                                        <a href="mailto:<?= htmlspecialchars($message->email) ?>" class="hover:underline">
                                            <?= htmlspecialchars($message->email) ?>
                                        </a>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Submitted</label>
                                    <p class="text-slate-900">
                                        <?= date('F d, Y', strtotime($message->submitted_at)) ?> at 
                                        <?= date('h:i A', strtotime($message->submitted_at)) ?>
                                    </p>
                                </div>
                                <div>
                                    <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Last Updated</label>
                                    <p class="text-slate-900">
                                        <?= date('F d, Y', strtotime($message->updated_at)) ?> at 
                                        <?= date('h:i A', strtotime($message->updated_at)) ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="mb-4">
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 block">Subject</label>
                            <div class="bg-indigo-50 text-indigo-900 px-4 py-3 rounded-xl font-medium">
                                <?= htmlspecialchars($message->subject) ?>
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div>
                            <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2 block">Message</label>
                            <div class="bg-slate-50 p-6 rounded-xl whitespace-pre-wrap text-slate-700 leading-relaxed">
                                <?= nl2br(htmlspecialchars($message->message)) ?>
                            </div>
                        </div>

                        <!-- Technical Details (Collapsible) -->
                        <?php if (!empty($message->ip_address) || !empty($message->user_agent)): ?>
                        <div class="mt-6 pt-6 border-t border-slate-200">
                            <details class="group">
                                <summary class="flex items-center text-sm font-medium text-slate-700 cursor-pointer list-none">
                                    <svg class="w-5 h-5 mr-2 text-slate-400 group-open:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    Technical Details
                                </summary>
                                <div class="mt-4 grid grid-cols-1 gap-3 text-sm">
                                    <?php if (!empty($message->ip_address)): ?>
                                    <div>
                                        <span class="font-medium text-slate-600">IP Address:</span>
                                        <span class="text-slate-500 ml-2"><?= htmlspecialchars($message->ip_address) ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($message->user_agent)): ?>
                                    <div>
                                        <span class="font-medium text-slate-600">User Agent:</span>
                                        <span class="text-slate-500 ml-2 break-all"><?= htmlspecialchars($message->user_agent) ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </details>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Status Update Form -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                        <h4 class="font-semibold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Update Status
                        </h4>
                    </div>
                    <div class="p-4">
                        <form action="<?= base_url('cms/update_message/'.$message->id) ?>" method="post">
                            <select name="status" class="w-full px-4 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 mb-3">
                                <option value="new" <?= $message->status == 'new' ? 'selected' : '' ?>>New</option>
                                <option value="read" <?= $message->status == 'read' ? 'selected' : '' ?>>Read</option>
                                <option value="replied" <?= $message->status == 'replied' ? 'selected' : '' ?>>Replied</option>
                                <option value="archived" <?= $message->status == 'archived' ? 'selected' : '' ?>>Archived</option>
                            </select>
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                                Update Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Admin Notes -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                        <h4 class="font-semibold text-slate-800 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Admin Notes
                        </h4>
                    </div>
                    <div class="p-4">
                        <form action="<?= base_url('cms/update_notes/'.$message->id) ?>" method="post">
                            <textarea name="notes" rows="6" class="w-full px-4 py-3 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 mb-3" placeholder="Add private notes about this message..."><?= htmlspecialchars($message->notes ?? '') ?></textarea>
                            <button type="submit" class="w-full px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                                Save Notes
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Quick Actions -->
                <!--<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">-->
                <!--    <div class="p-4 border-b border-slate-100 bg-slate-50/50">-->
                <!--        <h4 class="font-semibold text-slate-800 flex items-center">-->
                <!--            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
                <!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>-->
                <!--            </svg>-->
                <!--            Quick Actions-->
                <!--        </h4>-->
                <!--    </div>-->
                <!--    <div class="p-4 space-y-2">-->
                <!--        <a href="mailto:<?= htmlspecialchars($message->email) ?>?subject=Re: <?= urlencode($message->subject) ?>" -->
                <!--           class="flex items-center w-full px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition-colors">-->
                <!--            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
                <!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>-->
                <!--            </svg>-->
                <!--            Reply via Email-->
                <!--        </a>-->
                <!--        <button onclick="window.print()" -->
                <!--                class="flex items-center w-full px-4 py-2 bg-slate-50 text-slate-700 rounded-lg hover:bg-slate-100 transition-colors">-->
                <!--            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">-->
                <!--                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>-->
                <!--            </svg>-->
                <!--            Print Message-->
                <!--        </button>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
    </div>
</main>

<script>
function showNotification(message, type = 'info') {
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
    
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 3000);
}

// Check for flash messages
<?php if ($this->session->flashdata('success')): ?>
    showNotification('<?= $this->session->flashdata('success') ?>', 'success');
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    showNotification('<?= $this->session->flashdata('error') ?>', 'error');
<?php endif; ?>
</script>

<style>
/* Notification toast */
.notification-toast {
    animation: slideIn 0.3s ease-out;
    max-width: 400px;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Print styles */
@media print {
    .ml-64 {
        margin-left: 0;
    }
    .sticky {
        display: none;
    }
    .lg\\:col-span-1 {
        display: none;
    }
    .bg-slate-50 {
        background-color: white !important;
    }
}
</style>