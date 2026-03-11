<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS Admin | Light Edition</title>
    <script src="<?php echo base_url('assets_system/vendor/tailwindcss/tailwind.min.js'); ?>"></script>
    <link href="<?php echo base_url('assets_system/vendor/google-fonts/inter/inter.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets_system/vendor/fontawesome-6.5.0/css/all.min.css'); ?>">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        /* Notification Badge */
        .notification-badge {
            position: absolute;
            top: 50%;
            right: 8px;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
            animation: pulse-badge 2s infinite;
        }

        @keyframes pulse-badge {
            0%, 100% {
                transform: translateY(-50%) scale(1);
                box-shadow: 0 2px 4px rgba(239, 68, 68, 0.3);
            }
            50% {
                transform: translateY(-50%) scale(1.1);
                box-shadow: 0 2px 8px rgba(239, 68, 68, 0.5);
            }
        }

        .nav-item-with-badge {
            position: relative;
        }

        .active-link {
            background-color: #f1f5f9;
            color: #4f46e5;
            border-right: 4px solid #4f46e5;
            font-weight: 600;
        }

        /* Custom scrollbar styling */
        .scrollable-nav::-webkit-scrollbar {
            width: 4px;
        }

        .scrollable-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollable-nav::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 2px;
        }

        .scrollable-nav::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* For Firefox */
        .scrollable-nav {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }
    </style>
</head>
<body class="text-slate-800">

    <aside class="fixed inset-y-0 left-0 bg-white w-64 border-r border-slate-200 z-20 shadow-sm flex flex-col">
        <div class="p-6 mb-4">
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight flex items-center">
                <span class="w-8 h-8 bg-indigo-600 rounded-lg mr-2 flex items-center justify-center text-white text-xs">C</span>
                CMS Admin
            </h1>
        </div>

        <!-- Scrollable navigation area -->
        <nav class="px-3 space-y-0.5 flex-1 overflow-y-auto scrollable-nav">
            <p class="text-[10px] uppercase font-bold text-slate-400 px-3 mb-1.5 tracking-widest">Dashboard</p>

            <?php $isOverview = ($this->uri->segment(1) == 'home' && !$this->uri->segment(2)); ?>
            <a href="<?= base_url('home'); ?>" class="flex items-center px-3 py-1.5 text-xs font-medium rounded-md transition-all <?= $isOverview ? 'active-link' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' ?>">
                <span class="mr-2.5 text-base">📊</span> Overview
            </a>

            <div class="my-4 border-t border-slate-100"></div>

            <p class="text-[10px] uppercase font-bold text-slate-400 px-3 mb-1.5 tracking-widest">Website Pages</p>

            <?php
            // Get pending quote requests count for notification badge
            $this->load->database();
            $pending_count = $this->db->where('status', 'new')
                                      ->from('tbl_request_quote')
                                      ->count_all_results();
            
            // Get new messages count for contact us badge
            $new_messages_count = $this->db->where('status', 'new')
                                          ->from('tbl_send_us_message')
                                          ->count_all_results();
            
            $pages = [
                'home'                => ['Home', '🏠'],
                'about_us'            => ['About Us', '👥'],
                'products'            => ['Products', '📦'],
                'simulation_analysis' => ['Simulation Analysis', '🧪'],
                'smuc_page'           => ['SMUC Page', '🎓'],
                'iot_solution'        => ['IOT Solution', '🌐'],
                'news_and_events'     => ['News & Events', '📰'],
                'library'             => ['Library', '📚'],
                'contact_us'          => ['Contact Us', '📞'],
                'subscribers'   => ['Email Subscribers', '📧']
            ];

            foreach ($pages as $function_name => $meta):
                $isActive = ($this->uri->segment(1) == 'cms' && $this->uri->segment(2) == $function_name);
                $show_badge = false;
                $badge_count = 0;
                
                if ($function_name == 'smuc_page' && $pending_count > 0) {
                    $show_badge = true;
                    $badge_count = $pending_count;
                }
            ?>
                <a href="<?= base_url('cms/' . $function_name); ?>"
                    class="flex items-center px-3 py-1.5 text-xs font-medium rounded-md transition-all <?= $isActive ? 'active-link' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' ?> <?= $show_badge ? 'nav-item-with-badge' : '' ?>">
                    <span class="mr-2.5 text-base"><?= $meta[1]; ?></span>
                    <?= $meta[0]; ?>
                    <?php if ($show_badge): ?>
                        <span class="notification-badge" title="<?= $badge_count ?> pending quote request<?= $badge_count > 1 ? 's' : '' ?>">
                            <?= $badge_count > 99 ? '99+' : $badge_count ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endforeach; ?>

            <div class="my-4 border-t border-slate-100"></div>
            <p class="text-[10px] uppercase font-bold text-slate-400 px-3 mb-1.5 tracking-widest">Management</p>

            <?php 
            $isImageManagement = ($this->uri->segment(1) == 'cms' && $this->uri->segment(2) == 'image_management');
            ?>
            <a href="<?= base_url('cms/image_management'); ?>" 
               class="flex items-center px-3 py-1.5 text-xs font-medium rounded-md transition-all <?= $isImageManagement ? 'active-link' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' ?>">
                <span class="mr-2.5 text-base">🖼️</span>
                Image Management
            </a>

            <!-- Contact Us Messages Link with Badge -->
            <?php 
            $isMessages = ($this->uri->segment(1) == 'messages');
            ?>
            <a href="<?= base_url('cms/messages'); ?>" 
               class="flex items-center px-3 py-1.5 text-xs font-medium rounded-md transition-all <?= $isMessages ? 'active-link' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' ?> <?= ($new_messages_count > 0) ? 'nav-item-with-badge' : '' ?>">
                <span class="mr-2.5 text-base">💬</span>
                Contact Us Messages
                <?php if ($new_messages_count > 0): ?>
                    <span class="notification-badge" title="<?= $new_messages_count ?> new message<?= $new_messages_count > 1 ? 's' : '' ?>">
                        <?= $new_messages_count > 99 ? '99+' : $new_messages_count ?>
                    </span>
                <?php endif; ?>
            </a>

            <div class="my-4 border-t border-slate-100"></div>
            <p class="text-[10px] uppercase font-bold text-slate-400 px-3 mb-1.5 tracking-widest">Others Group</p>

            <?php 
            $others = [
                'privacy_policy'   => ['Privacy Policy', '🛡️'],
                'terms_of_service' => ['Terms of Service', '📄'],
                'cookie_policy'  => ['Cookie Settings', '🍪'],
                'footer'           => ['Footer', '🦶']
            ];

            foreach ($others as $function_name => $meta): 
                $isActive = ($this->uri->segment(1) == 'cms' && $this->uri->segment(2) == $function_name);
            ?>
                <a href="<?= base_url('cms/' . $function_name); ?>"
                class="flex items-center px-3 py-1.5 text-xs font-medium rounded-md transition-all <?= $isActive ? 'active-link' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' ?>">
                <span class="mr-2.5 text-base"><?= $meta[1]; ?></span>
                <?= $meta[0]; ?>
                </a>
            <?php endforeach; ?>
        </nav>

        <!-- Logout section stays fixed at bottom -->
        <div class="p-4 border-t border-slate-100 mt-auto">
            <a href="<?= base_url('cms/logout'); ?>"
                onclick="return confirm('Are you sure you want to logout?')"
                class="flex items-center px-3 py-1.5 text-xs font-bold text-red-500 hover:bg-red-50 rounded-lg transition-all group">
                <span class="mr-2.5 text-base transition-transform group-hover:-translate-x-1">🚪</span>
                Logout
            </a>
        </div>
    </aside>

    <header class="ml-64 h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-8 sticky top-0 z-10">
        <div class="text-sm font-medium text-slate-500">
            System / <span class="text-slate-900 capitalize"><?= str_replace('_', ' ', $this->uri->segment(2) ?? 'Dashboard'); ?></span>
        </div>

        <div class="flex items-center gap-4">
            <!--<?php if ($new_messages_count > 0): ?>-->
            <!--<div class="relative">-->
            <!--    <a href="<?= base_url('cms/messages'); ?>" class="flex items-center text-xs font-semibold px-4 py-2 rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-all">-->
            <!--        <span class="mr-2">💬</span>-->
            <!--        New Messages-->
            <!--        <span class="ml-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full"><?= $new_messages_count ?></span>-->
            <!--    </a>-->
            <!--</div>-->
            <!--<?php endif; ?>-->
            
            <a href="<?= base_url(); ?>" target="_blank" class="text-xs font-semibold px-4 py-2 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-200 transition-all">
                View Site ↗
            </a>
            <div class="h-8 w-8 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs">
                A
            </div>
        </div>
    </header>

    <script src="<?php echo base_url('assets_system/vendor/jquery/jquery-3.7.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets_system/vendor/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
    
    <script>
    // Optional: Auto-refresh badge counts every 30 seconds
    $(document).ready(function() {
        setInterval(function() {
            $.ajax({
                url: '<?= base_url("cms/get_new_count"); ?>',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.count > 0) {
                        updateBadge(response.count);
                    }
                }
            });
        }, 30000); // Refresh every 30 seconds
    });
    
    function updateBadge(count) {
        // Update sidebar badge
        let $messageLink = $('a[href="<?= base_url("messages"); ?>"]');
        let $badge = $messageLink.find('.notification-badge');
        
        if (count > 0) {
            if ($badge.length === 0) {
                $messageLink.addClass('nav-item-with-badge');
                $messageLink.append('<span class="notification-badge" title="' + count + ' new message' + (count > 1 ? 's' : '') + '">' + (count > 99 ? '99+' : count) + '</span>');
            } else {
                $badge.text(count > 99 ? '99+' : count).attr('title', count + ' new message' + (count > 1 ? 's' : ''));
            }
            
            // Update header button
            if ($('.header-messages-btn').length === 0) {
                let $headerBtn = $('<div class="relative header-messages-btn">' +
                    '<a href="<?= base_url("messages"); ?>" class="flex items-center text-xs font-semibold px-4 py-2 rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition-all">' +
                    '<span class="mr-2">💬</span>' +
                    'New Messages' +
                    '<span class="ml-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">' + (count > 99 ? '99+' : count) + '</span>' +
                    '</a></div>');
                
                $('.flex.items-center.gap-4').prepend($headerBtn);
            } else {
                $('.header-messages-btn span.ml-2').text(count > 99 ? '99+' : count);
            }
        } else {
            $badge.remove();
            $messageLink.removeClass('nav-item-with-badge');
            $('.header-messages-btn').remove();
        }
    }
    </script>
</body>
</html>