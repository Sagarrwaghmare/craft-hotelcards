<!-- Sidebar -->
<aside id="mainSidebar" class="w-64 bg-darkSidebar border-r border-darkBorder flex flex-col shrink-0 min-h-screen transition-all duration-300 ease-in-out">
    <!-- Brand / Logo -->
    <div class="h-16 flex items-center px-6 gap-3 border-b border-darkBorder/40">
        <div class="w-9 h-9 rounded-lg bg-blue-600 flex items-center justify-center font-bold text-white shadow-md">
            H
        </div>
        <div>
            <h1 class="text-sm font-bold text-white tracking-wide">adminHMD</h1>
            <p class="text-[11px] text-slate-400">Admin Template</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-4 space-y-1">
        <a href="<?= base_url() ?>"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-solid fa-gauge-high w-5 text-center"></i>
            <span>Dashboard</span>
        </a>

        <a href="#"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-solid fa-users w-5 text-center"></i>
            <span>Users</span>
        </a>

        <!-- Highlighted Active Link -->
        <a href="<?= base_url() ?>"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= (isset($active_menu) && $active_menu === 'add_user') ? 'bg-slate-800/80 text-white border border-slate-700/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?>">
            <i class="fa-solid fa-user-plus w-5 text-center text-blue-400"></i>
            <span>Add User</span>
        </a>

        <a href="<?= base_url('main/profile') ?>"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition <?= (isset($active_menu) && $active_menu === 'profile') ? 'bg-slate-800/80 text-white border border-slate-700/50' : 'text-slate-400 hover:text-white hover:bg-slate-800/40' ?>">
            <i class="fa-regular fa-id-badge w-5 text-center"></i>
            <span>Profile</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-solid fa-chart-simple w-5 text-center"></i>
            <span>Charts</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-solid fa-table-cells w-5 text-center"></i>
            <span>Tables</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-solid fa-table-columns w-5 text-center"></i>
            <span>Forms</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-solid fa-cubes w-5 text-center"></i>
            <span>Components</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-solid fa-triangle-exclamation w-5 text-center"></i>
            <span>Alerts</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-slate-400 hover:text-white hover:bg-slate-800/40">
            <i class="fa-regular fa-window-maximize w-5 text-center"></i>
            <span>Modals</span>
        </a>
    </nav>
</aside>

<!-- Right Side Content Container -->
<div class="flex-1 flex flex-col min-w-0">