<?php
$user_name   = $this->session->userdata('name') ?? 'Staff';
$user_role   = $this->session->userdata('access') ?? 'User';
$initials    = strtoupper(substr(trim($user_name), 0, 2));
?>
<!-- Top Navbar -->
<header class="h-16 bg-darkSidebar border-b border-darkBorder flex items-center justify-between px-6 shrink-0 relative z-30 transition-colors">
    <div class="flex items-center gap-4 flex-1">
        <!-- Sidebar Toggle Button -->
        <button id="sidebarToggle" type="button" class="text-slate-400 hover:text-white px-3 py-2 border border-darkBorder rounded-lg focus:outline-none hover:bg-slate-800 transition">
            <i class="fa-solid fa-bars text-base"></i>
        </button>

        <!-- Search bar spacer -->
        <div class="relative w-72"></div>
    </div>

    <!-- Right Utilities -->
    <div class="flex items-center gap-3">

        <!-- User Pill Dropdown Wrapper -->
        <div class="relative" id="userDropdownContainer">

            <!-- Clickable User Pill Trigger -->
            <button type="button" id="userMenuBtn"
                class="flex items-center gap-2.5 bg-[#0A1020] border border-darkBorder px-3.5 py-1.5 rounded-full cursor-pointer hover:border-slate-500 transition focus:outline-none select-none">
                <span class="w-6 h-6 rounded-full bg-emerald-600 text-white text-xs flex items-center justify-center font-bold shrink-0 uppercase">
                    <?= htmlspecialchars($initials) ?>
                </span>
                <span class="text-xs font-semibold text-slate-200 truncate max-w-[130px]">
                    <?= htmlspecialchars($user_name) ?>
                </span>
                <i id="userMenuChevron" class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
            </button>

            <!-- Dropdown Box -->
            <div id="userDropdownMenu"
                class="hidden absolute right-0 mt-2 w-60 bg-darkCard border border-darkBorder rounded-2xl shadow-2xl py-2 z-50 transition-all origin-top-right">

                <!-- User Meta Header -->
                <div class="px-4 py-3 border-b border-darkBorder/60">
                    <p class="text-xs font-bold text-white truncate"><?= htmlspecialchars($user_name) ?></p>
                    <div class="flex items-center gap-2 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                        <p class="text-[11px] text-slate-400 font-medium"><?= htmlspecialchars($user_role) ?> Account</p>
                    </div>
                </div>

                <!-- Option 1: Dark/Light Mode Toggle Switch -->
                <div class="px-2 py-1.5">
                    <button type="button" id="themeToggleBtn"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs text-slate-300 hover:text-white hover:bg-slate-800/50 transition">
                        <span class="flex items-center gap-2.5">
                            <i id="themeIcon" class="fa-solid fa-moon text-blue-400 text-xs w-4 text-center"></i>
                            <span id="themeLabel" class="font-medium">Dark Mode</span>
                        </span>

                        <!-- Toggle Track & Knob -->
                        <span id="themeSwitchTrack" class="w-8 h-4 bg-blue-600 rounded-full relative inline-block transition-colors shrink-0">
                            <span id="themeSwitchThumb" class="w-3 h-3 bg-white rounded-full absolute top-0.5 right-0.5 transition-transform"></span>
                        </span>
                    </button>
                </div>

                <!-- Option 2: Logout Button -->
                <div class="pt-1.5 border-t border-darkBorder/60 px-2 pb-1">
                    <a href="<?= base_url('auth/logout') ?>"
                        class="w-full flex items-center gap-2.5 px-3 py-2 rounded-xl text-xs font-semibold text-red-400 hover:text-red-300 hover:bg-red-500/10 transition">
                        <i class="fa-solid fa-arrow-right-from-bracket text-xs w-4 text-center"></i>
                        <span>Logout</span>
                    </a>
                </div>

            </div>

        </div>

    </div>
</header>

<!-- Main Page Body Container -->
<main class="flex-1 p-8 overflow-y-auto bg-darkBg transition-colors">

    <!-- Navbar Dropdown & Theme Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userDropdownMenu = document.getElementById('userDropdownMenu');
            const userMenuChevron = document.getElementById('userMenuChevron');
            const container = document.getElementById('userDropdownContainer');

            // Toggle user dropdown
            if (userMenuBtn && userDropdownMenu) {
                userMenuBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = userDropdownMenu.classList.contains('hidden');
                    if (isHidden) {
                        userDropdownMenu.classList.remove('hidden');
                        if (userMenuChevron) userMenuChevron.classList.add('rotate-180');
                    } else {
                        userDropdownMenu.classList.add('hidden');
                        if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');
                    }
                });

                // Close on outside click
                document.addEventListener('click', function(e) {
                    if (!container.contains(e.target)) {
                        userDropdownMenu.classList.add('hidden');
                        if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');
                    }
                });

                // Close on Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        userDropdownMenu.classList.add('hidden');
                        if (userMenuChevron) userMenuChevron.classList.remove('rotate-180');
                    }
                });
            }

            // ============================================
            // Dark / Light Theme Toggle Controller
            // ============================================
            const themeBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            const themeLabel = document.getElementById('themeLabel');
            const themeSwitchTrack = document.getElementById('themeSwitchTrack');
            const themeSwitchThumb = document.getElementById('themeSwitchThumb');

            function updateThemeUI(isDark) {
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    document.documentElement.classList.remove('light');
                    if (themeLabel) themeLabel.textContent = 'Dark Mode';
                    if (themeIcon) themeIcon.className = 'fa-solid fa-moon text-blue-400 text-xs w-4 text-center';
                    if (themeSwitchTrack) themeSwitchTrack.className = 'w-8 h-4 bg-blue-600 rounded-full relative inline-block transition-colors shrink-0';
                    if (themeSwitchThumb) themeSwitchThumb.className = 'w-3 h-3 bg-white rounded-full absolute top-0.5 right-0.5 transition-transform';
                } else {
                    document.documentElement.classList.remove('dark');
                    document.documentElement.classList.add('light');
                    if (themeLabel) themeLabel.textContent = 'Light Mode';
                    if (themeIcon) themeIcon.className = 'fa-solid fa-sun text-amber-400 text-xs w-4 text-center';
                    if (themeSwitchTrack) themeSwitchTrack.className = 'w-8 h-4 bg-slate-600 rounded-full relative inline-block transition-colors shrink-0';
                    if (themeSwitchThumb) themeSwitchThumb.className = 'w-3 h-3 bg-white rounded-full absolute top-0.5 left-0.5 transition-transform';
                }
            }

            // Check current active state
            const savedTheme = localStorage.getItem('hotelcards_theme') || 'dark';
            updateThemeUI(savedTheme === 'dark');

            if (themeBtn) {
                themeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isCurrentlyDark = document.documentElement.classList.contains('dark');
                    const nextTheme = isCurrentlyDark ? 'light' : 'dark';
                    localStorage.setItem('hotelcards_theme', nextTheme);
                    updateThemeUI(nextTheme === 'dark');
                });
            }
        });
    </script>