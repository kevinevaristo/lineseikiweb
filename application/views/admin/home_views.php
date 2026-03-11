<main class="ml-64 p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Dashboard Overview</h1>
                <p class="text-slate-500 mt-1">Welcome back! Here's what's happening with your website.</p>
            </div>
            <a href="<?php echo base_url(); ?>" target="_blank" 
               class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold shadow-md shadow-indigo-100 hover:bg-indigo-700 transition-all flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                </svg>
                Preview Website
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Visitors -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-indigo-50 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-1 rounded-full">+12.5%</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1" id="totalVisitors">Loading...</h3>
                <p class="text-sm text-slate-500">Total Visitors</p>
            </div>

            <!-- Today's Visitors -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-blue-600 bg-blue-50 px-2 py-1 rounded-full">Today</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1" id="todayVisitors">Loading...</h3>
                <p class="text-sm text-slate-500">Visitors Today</p>
            </div>

            <!-- Unique Visitors -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-50 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">Unique</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1" id="uniqueVisitors">Loading...</h3>
                <p class="text-sm text-slate-500">Unique Visitors</p>
            </div>

            <!-- Last Update -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md transition-all">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 mb-1" id="lastUpdate">Loading...</h3>
                <p class="text-sm text-slate-500">Last Updated</p>
            </div>
        </div>

        <!-- Visitor Chart -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Visitor Analytics</h3>
                    <p class="text-sm text-slate-500 mt-1">Last 30 days visitor trend</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">7D</button>
                    <button class="px-3 py-1.5 text-sm font-medium bg-indigo-50 text-indigo-600 rounded-lg">30D</button>
                    <button class="px-3 py-1.5 text-sm font-medium text-slate-600 hover:bg-slate-50 rounded-lg transition-colors">90D</button>
                </div>
            </div>
            <div class="h-80">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>

        <!-- Additional Analytics -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <!-- Device Statistics -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Device Types</h3>
                <div id="deviceStats" class="space-y-3">
                    <div class="flex items-center justify-center h-32 text-slate-400">
                        <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Browser Statistics -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Top Browsers</h3>
                <div id="browserStats" class="space-y-3">
                    <div class="flex items-center justify-center h-32 text-slate-400">
                        <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Referrer -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h3 class="text-lg font-bold text-slate-800 mb-4">Referrer</h3>
                <div id="referrerStats" class="space-y-3">
                    <div class="flex items-center justify-center h-32 text-slate-400">
                        <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Visitor's Location -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-800">Visitor's Location</h3>
                    <span id="totalCountriesBadge" class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full hidden"></span>
                </div>
                <div id="visitorLocations" class="space-y-3">
                    <div class="flex items-center justify-center h-32 text-slate-400">
                        <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="mb-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4">Quick Access</h3>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php 
            $quick_links = [
                ['title' => 'Home Page', 'icon' => '🏠', 'slug' => 'home', 'desc' => 'Edit homepage content'],
                ['title' => 'About Us', 'icon' => '👥', 'slug' => 'about_us', 'desc' => 'Manage about section'],
                ['title' => 'Products', 'icon' => '📦', 'slug' => 'products', 'desc' => 'Product categories'],
                ['title' => 'Safety Switches', 'icon' => '🔒', 'slug' => 'product_1', 'desc' => 'Safety switches page'],
                ['title' => 'Simulation', 'icon' => '🧪', 'slug' => 'simulation_analysis', 'desc' => 'Simulation content'],
                ['title' => 'SMUC Page', 'icon' => '🔧', 'slug' => 'smuc_page', 'desc' => 'SMUC services'],
                ['title' => 'IoT Solution', 'icon' => '🌐', 'slug' => 'iot_solution', 'desc' => 'IoT solutions page'],
                ['title' => 'News & Events', 'icon' => '📰', 'slug' => 'news_and_events', 'desc' => 'Manage events'],
                ['title' => 'Library', 'icon' => '📚', 'slug' => 'library', 'desc' => 'Resource library'],
                ['title' => 'Contact Us', 'icon' => '📧', 'slug' => 'contact_us', 'desc' => 'Contact information'],
                ['title' => 'Footer', 'icon' => '⬇️', 'slug' => 'footer', 'desc' => 'Footer content'],
                ['title' => 'Images', 'icon' => '🖼️', 'slug' => 'image_management', 'desc' => 'Manage images'],
            ];

            foreach($quick_links as $item): ?>
            <a href="<?php echo base_url('cms/'.$item['slug']); ?>" 
               class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group p-6 block">
                <div class="flex items-start justify-between mb-3">
                    <div class="text-3xl"><?php echo $item['icon']; ?></div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400 group-hover:text-indigo-600 transition-colors" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h4 class="text-base font-bold text-slate-800 mb-1 group-hover:text-indigo-600 transition-colors"><?php echo $item['title']; ?></h4>
                <p class="text-sm text-slate-500"><?php echo $item['desc']; ?></p>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<!-- Chart.js -->
<script src="<?php echo base_url('assets_system/vendor/chartjs/chart.umd.min.js'); ?>"></script>

<script>
// Initialize visitor data (you'll need to fetch this from your backend)
document.addEventListener('DOMContentLoaded', function() {
    // Fetch visitor statistics
    fetchVisitorStats();
    
    // Fetch additional analytics
    fetchAdditionalAnalytics();
    
    // Initialize chart
    initVisitorChart();
});

function fetchVisitorStats() {
    // Fetch real data from backend
    fetch('<?php echo base_url('home/get_visitor_stats'); ?>')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const stats = result.data;
                document.getElementById('totalVisitors').textContent = stats.total_visitors.toLocaleString();
                document.getElementById('todayVisitors').textContent = stats.today_visitors.toLocaleString();
                document.getElementById('uniqueVisitors').textContent = stats.unique_visitors.toLocaleString();
                document.getElementById('lastUpdate').textContent = stats.last_update;
            }
        })
        .catch(error => {
            console.error('Error fetching visitor stats:', error);
            // Use fallback mock data
            document.getElementById('totalVisitors').textContent = '0';
            document.getElementById('todayVisitors').textContent = '0';
            document.getElementById('uniqueVisitors').textContent = '0';
            document.getElementById('lastUpdate').textContent = '2 hours ago';
        });
}

function fetchAdditionalAnalytics() {
    fetch('<?php echo base_url('home/get_visitor_stats'); ?>')
        .then(response => response.json())
        .then(result => {
            console.log('Full Response:', result);
            if (result.success && result.data) {
                const data = result.data;
                
                // Render device statistics
                if (data.device_stats) {
                    renderDeviceStats(data.device_stats);
                }
                
                // Render browser statistics
                if (data.browser_stats) {
                    renderBrowserStats(data.browser_stats);
                }
                
                // Render referrer statistics
                if (data.referrer_stats) {
                    renderReferrerStats(data.referrer_stats);
                }
                
                // Render visitor locations
                if (data.location_stats !== undefined) {
                    renderVisitorLocations(data.location_stats, data.city_stats, data.total_countries, data.total_visitors);
                }
            }
        })
        .catch(error => {
            console.error('Error fetching additional analytics:', error);
        });
}

function renderDeviceStats(devices) {
    const container = document.getElementById('deviceStats');
    
    if (!devices || devices.length === 0) {
        container.innerHTML = '<p class="text-sm text-slate-400 text-center py-8">No device data available</p>';
        return;
    }
    
    const total = devices.reduce((sum, item) => sum + parseInt(item.count), 0);
    
    const icons = {
        'Desktop': '🖥️',
        'Mobile': '📱',
        'Tablet': '📱',
        'Bot': '🤖'
    };
    
    const colors = {
        'Desktop': 'bg-blue-500',
        'Mobile': 'bg-green-500',
        'Tablet': 'bg-purple-500',
        'Bot': 'bg-gray-500'
    };
    
    let html = '';
    devices.forEach(device => {
        const percentage = ((device.count / total) * 100).toFixed(1);
        const icon = icons[device.device_type] || '💻';
        const color = colors[device.device_type] || 'bg-slate-500';
        
        html += `
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="text-xl">${icon}</span>
                    <span class="text-sm font-medium text-slate-700">${device.device_type}</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-24 bg-slate-100 rounded-full h-2">
                        <div class="${color} h-2 rounded-full" style="width: ${percentage}%"></div>
                    </div>
                    <span class="text-sm font-semibold text-slate-600 w-12 text-right">${percentage}%</span>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function renderBrowserStats(browsers) {
    const container = document.getElementById('browserStats');
    
    if (!browsers || browsers.length === 0) {
        container.innerHTML = '<p class="text-sm text-slate-400 text-center py-8">No browser data available</p>';
        return;
    }
    
    const total = browsers.reduce((sum, item) => sum + parseInt(item.count), 0);
    
    let html = '';
    browsers.slice(0, 5).forEach((browser, index) => {
        const percentage = ((browser.count / total) * 100).toFixed(1);
        const colors = ['bg-indigo-500', 'bg-blue-500', 'bg-cyan-500', 'bg-teal-500', 'bg-green-500'];
        const color = colors[index] || 'bg-slate-500';
        
        // Extract browser name (remove version)
        const browserName = browser.browser.split(' ')[0];
        
        html += `
            <div class="flex items-center justify-between">
                <span class="text-sm font-medium text-slate-700 truncate" style="max-width: 120px;" title="${browser.browser}">${browserName}</span>
                <div class="flex items-center gap-3">
                    <div class="w-20 bg-slate-100 rounded-full h-2">
                        <div class="${color} h-2 rounded-full" style="width: ${percentage}%"></div>
                    </div>
                    <span class="text-sm font-semibold text-slate-600 w-12 text-right">${percentage}%</span>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function getReferrerInfo(referrer) {
    const r = referrer.toLowerCase();
    const knownSources = [
        { keywords: ['facebook', 'fb.com', 'fbcdn'],    name: 'Facebook',  icon: 'fab fa-facebook-f',    color: '#1877F2' },
        { keywords: ['instagram', 'ig.com'],             name: 'Instagram', icon: 'fab fa-instagram',     color: '#E4405F' },
        { keywords: ['twitter', 't.co', 'x.com'],        name: 'X (Twitter)', icon: 'fab fa-x-twitter',  color: '#000000' },
        { keywords: ['linkedin'],                         name: 'LinkedIn',  icon: 'fab fa-linkedin-in',  color: '#0A66C2' },
        { keywords: ['youtube', 'youtu.be'],              name: 'YouTube',   icon: 'fab fa-youtube',      color: '#FF0000' },
        { keywords: ['tiktok'],                            name: 'TikTok',    icon: 'fab fa-tiktok',       color: '#000000' },
        { keywords: ['pinterest'],                         name: 'Pinterest', icon: 'fab fa-pinterest-p',  color: '#E60023' },
        { keywords: ['reddit'],                            name: 'Reddit',    icon: 'fab fa-reddit-alien', color: '#FF4500' },
        { keywords: ['whatsapp'],                          name: 'WhatsApp',  icon: 'fab fa-whatsapp',     color: '#25D366' },
        { keywords: ['telegram', 't.me'],                  name: 'Telegram',  icon: 'fab fa-telegram-plane', color: '#26A5E4' },
        { keywords: ['google'],                            name: 'Google',    icon: 'fab fa-google',       color: '#4285F4' },
        { keywords: ['bing'],                              name: 'Bing',      icon: 'fab fa-microsoft',    color: '#008373' },
        { keywords: ['yahoo'],                             name: 'Yahoo',     icon: 'fab fa-yahoo',        color: '#6001D2' },
        { keywords: ['baidu'],                             name: 'Baidu',     icon: 'fas fa-search',       color: '#2319DC' },
        { keywords: ['github'],                            name: 'GitHub',    icon: 'fab fa-github',       color: '#181717' },
    ];

    for (const source of knownSources) {
        if (source.keywords.some(kw => r.includes(kw))) {
            return { name: source.name, icon: source.icon, color: source.color };
        }
    }

    // Fallback: extract clean domain name
    let domain = referrer;
    try {
        const url = new URL(referrer);
        domain = url.hostname.replace('www.', '').replace(/\.(com|net|org|io|co|me)$/i, '');
        domain = domain.charAt(0).toUpperCase() + domain.slice(1);
    } catch(e) {
        domain = referrer;
    }
    return { name: domain, icon: 'fas fa-globe', color: '#64748b' };
}

function renderReferrerStats(referrers) {
    const container = document.getElementById('referrerStats');

    if (!referrers || referrers.length === 0) {
        container.innerHTML = '<p class="text-sm text-slate-400 text-center py-8">No referrer data available</p>';
        return;
    }

    // Group referrers by detected name (merge same sources)
    const grouped = {};
    referrers.forEach(ref => {
        const info = getReferrerInfo(ref.referrer);
        if (!grouped[info.name]) {
            grouped[info.name] = { count: 0, icon: info.icon, color: info.color, urls: [] };
        }
        grouped[info.name].count += parseInt(ref.count);
        grouped[info.name].urls.push(ref.referrer);
    });

    // Sort by count descending
    const sorted = Object.entries(grouped)
        .sort((a, b) => b[1].count - a[1].count)
        .slice(0, 5);

    const total = sorted.reduce((sum, item) => sum + item[1].count, 0);

    let html = '';
    sorted.forEach(([name, data]) => {
        const percentage = ((data.count / total) * 100).toFixed(1);

        html += `
            <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0">
                <div class="flex items-center gap-2 flex-1 min-w-0">
                    <i class="${data.icon} flex-shrink-0" style="color: ${data.color}; font-size: 1rem; width: 18px; text-align: center;"></i>
                    <span class="text-sm text-slate-700 truncate" style="max-width: 120px;" title="${data.urls.join('\n')}">${name}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-16 bg-slate-100 rounded-full h-1.5">
                        <div class="h-1.5 rounded-full" style="width: ${percentage}%; background-color: ${data.color};"></div>
                    </div>
                    <span class="text-xs font-semibold text-slate-600 w-8 text-right">${data.count.toLocaleString()}</span>
                </div>
            </div>
        `;
    });

    container.innerHTML = html;
}

function renderVisitorLocations(locations, cities, totalCountries, totalVisitors) {
    const container = document.getElementById('visitorLocations');
    const badge = document.getElementById('totalCountriesBadge');
    
    if (totalCountries > 0) {
        badge.textContent = totalCountries + (totalCountries === 1 ? ' country' : ' countries');
        badge.classList.remove('hidden');
    }
    
    if (!locations || locations.length === 0) {
        container.innerHTML = '<p class="text-sm text-slate-400 text-center py-8">No location data yet.<br><span class="text-xs">Data populates on new visits.</span></p>';
        return;
    }
    
    const total = totalVisitors || locations.reduce((sum, item) => sum + parseInt(item.count), 0);
    
    // Country flag emoji helper (basic)
    function countryFlag(name) {
        const flags = {
            'Philippines': '🇵🇭', 'United States': '🇺🇸', 'Japan': '🇯🇵',
            'China': '🇨🇳', 'Singapore': '🇸🇬', 'Australia': '🇦🇺',
            'United Kingdom': '🇬🇧', 'Germany': '🇩🇪', 'France': '🇫🇷',
            'Canada': '🇨🇦', 'India': '🇮🇳', 'South Korea': '🇰🇷',
            'Indonesia': '🇮🇩', 'Malaysia': '🇲🇾', 'Thailand': '🇹🇭',
            'Vietnam': '🇻🇳', 'Taiwan': '🇹🇼', 'Hong Kong': '🇭🇰',
            'Local': '🏠'
        };
        return flags[name] || '🌍';
    }
    
    let html = '';
    locations.slice(0, 6).forEach(loc => {
        const pct = total > 0 ? ((loc.count / total) * 100).toFixed(1) : 0;
        html += `
            <div>
                <div class="flex items-center justify-between mb-1">
                    <div class="flex items-center gap-1.5">
                        <span>${countryFlag(loc.country)}</span>
                        <span class="text-sm font-medium text-slate-700 truncate" style="max-width:110px" title="${loc.country}">${loc.country}</span>
                    </div>
                    <span class="text-xs text-slate-500 ml-2">${parseInt(loc.count).toLocaleString()}</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-indigo-500 h-1.5 rounded-full" style="width:${pct}%"></div>
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

function initVisitorChart() {
    const ctx = document.getElementById('visitorChart');
    
    // Fetch real visitor trend data
    fetch('<?php echo base_url('home/get_visitor_trend?days=30'); ?>')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                const trendData = result.data;
                const labels = trendData.map(item => {
                    const date = new Date(item.date);
                    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
                });
                const data = trendData.map(item => item.count);
                
                createChart(ctx, labels, data);
            }
        })
        .catch(error => {
            console.error('Error fetching visitor trend:', error);
            // Fallback to mock data
            const last30Days = [];
            const visitorData = [];
            
            for (let i = 29; i >= 0; i--) {
                const date = new Date();
                date.setDate(date.getDate() - i);
                last30Days.push(date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }));
                visitorData.push(Math.floor(Math.random() * 200) + 150);
            }
            
            createChart(ctx, last30Days, visitorData);
        });
}

function createChart(ctx, labels, data) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Visitors',
                data: data,
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: 'rgb(99, 102, 241)',
                pointHoverBorderColor: 'white',
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    titleFont: {
                        size: 13,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 14,
                        weight: '700'
                    },
                    callbacks: {
                        label: function(context) {
                            return 'Visitors: ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 0,
                        autoSkipPadding: 20,
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 11
                        },
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            },
            interaction: {
                mode: 'nearest',
                axis: 'x',
                intersect: false
            }
        }
    });
}
</script>
