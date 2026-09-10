<?php
// Helper variable for cleaner active/inactive styling
$active_menu = isset($active_menu) ? $active_menu : '';

function menu_class($current, $active)
{
    if ($current === $active) {
        return 'bg-slate-800/90 text-white border border-slate-700/60 shadow-sm font-semibold';
    }
    return 'text-slate-400 hover:text-white hover:bg-slate-800/40 font-medium';
}
?>

<!-- Sidebar -->
<aside id="mainSidebar" class="w-64 bg-darkSidebar border-r border-darkBorder flex flex-col shrink-0 min-h-screen transition-all duration-300 ease-in-out">

    <!-- Brand / Logo -->
    <div class="h-16 flex items-center px-6 gap-3 border-b border-darkBorder/40">
        <div class="w-9 h-9 rounded-xl bg-blue-600 flex items-center justify-center font-bold text-white shadow-md shadow-blue-600/30">
            H
        </div>
        <div>
            <h1 class="text-sm font-bold text-white tracking-wide">adminHMD</h1>
            <p class="text-[11px] text-slate-400">Membership System</p>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 px-3 py-5 space-y-6 overflow-y-auto">

        <!-- SECTION: MEMBERSHIP -->
        <div>
            <span class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">
                Membership
            </span>
            <div class="space-y-1">
                <!-- Events Overview -->
                <a href="<?= base_url('main/members') ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition <?= menu_class('members', $active_menu) ?>">
                    <i class="fa-solid fa-gauge-high w-4 text-center text-blue-400"></i>
                    <span>Events Overview</span>
                </a>

                <!-- Members Directory -->
                <a href="<?= base_url('main/members_list') ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition <?= menu_class('members_list', $active_menu) ?>">
                    <i class="fa-solid fa-users w-4 text-center text-indigo-400"></i>
                    <span>Members List</span>
                </a>

                <!-- Add Member -->
                <a href="<?= base_url('main/add_member') ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition <?= menu_class('add_member', $active_menu) ?>">
                    <i class="fa-solid fa-address-card w-4 text-center text-emerald-400"></i>
                    <span>Add Member</span>
                </a>
            </div>
        </div>

        <!-- SECTION: USER MANAGEMENT -->
        <div>
            <span class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">
                System Access
            </span>
            <div class="space-y-1">
                <!-- Users List -->
                <a href="<?= base_url('main/users') ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition <?= menu_class('users', $active_menu) ?>">
                    <i class="fa-solid fa-users-gear w-4 text-center text-amber-400"></i>
                    <span>User Management</span>
                </a>

                <!-- Add User -->
                <a href="<?= base_url('main/add_user') ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition <?= menu_class('add_user', $active_menu) ?>">
                    <i class="fa-solid fa-user-plus w-4 text-center text-sky-400"></i>
                    <span>Add User</span>
                </a>
            </div>
        </div>

        <!-- SECTION: ACCOUNT & SETTINGS -->
        <div>
            <span class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-widest block mb-2">
                Account
            </span>
            <div class="space-y-1">
                <!-- User Profile -->
                <a href="<?= base_url('main/profile') ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition <?= menu_class('profile', $active_menu) ?>">
                    <i class="fa-regular fa-id-badge w-4 text-center text-purple-400"></i>
                    <span>User Profile</span>
                </a>

                <!-- Reset Password -->
                <a href="<?= base_url('auth/reset_password') ?>"
                    class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs transition <?= menu_class('reset_password', $active_menu) ?>">
                    <i class="fa-solid fa-key w-4 text-center text-slate-400"></i>
                    <span>Reset Password</span>
                </a>
            </div>
        </div>

    </nav>

    <!-- Bottom User Info & Logout -->
    <div class="p-3 border-t border-darkBorder/50 bg-[#080E1E]">
        <div class="flex items-center justify-between px-2 py-1.5 rounded-xl">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-blue-600/20 text-blue-400 border border-blue-500/30 flex items-center justify-center font-bold text-xs">
                    JD
                </div>
                <div class="truncate">
                    <p class="text-xs font-semibold text-white leading-tight">Jane Doe</p>
                    <p class="text-[10px] text-slate-400">Admin</p>
                </div>
            </div>
            <!-- Logout Link -->
            <a href="<?= base_url('auth/logout') ?>" title="Log Out" class="text-slate-400 hover:text-red-400 p-1.5 transition">
                <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
            </a>
        </div>
    </div>

</aside>

<!-- Right Side Content Container -->
<div class="flex-1 flex flex-col min-w-0">