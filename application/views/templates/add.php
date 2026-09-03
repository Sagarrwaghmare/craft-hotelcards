<!-- Header Title -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-user-plus text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">User Management</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">New User Details</h2>
            <p class="text-xs text-slate-400">Fill in the information below to create a new user account.</p>
        </div>
    </div>
    <a href="<?= base_url() ?>" class="text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-lg hover:bg-slate-800 transition flex items-center gap-2">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back
    </a>
</div>

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Left 2 Cols: The Add User Form -->
    <div class="lg:col-span-2 bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-8 shadow-xl">
        <form action="<?= base_url('users/store') ?>" method="POST" id="addUserForm" class="space-y-6">

            <!-- Row 1: Name & Username -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Name Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Full Name <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-regular fa-user text-sm"></i>
                        </div>
                        <input type="text" name="name" required placeholder="Enter name"
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                </div>

                <!-- Username Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Username <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-regular fa-id-badge text-sm"></i>
                        </div>
                        <input type="text" name="username" required placeholder="Enter unique username"
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                </div>
            </div>

            <!-- Row 2: Email & Contact Number -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Email Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Email Address <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-at text-sm"></i>
                        </div>
                        <input type="email" name="email" required placeholder="Enter email address"
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                </div>

                <!-- Contact No Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Contact Number
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-phone text-xs"></i>
                        </div>
                        <input type="text" name="contact_no" placeholder="Enter contact number"
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                </div>
            </div>

            <!-- Row 3: Password & Access Role -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Password Field with Toggle Eye -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Password <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="userPassword" name="password" required placeholder="••••••••"
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        <!-- Show / Hide Button -->
                        <button type="button" id="togglePasswordBtn" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none">
                            <i class="fa-regular fa-eye-slash text-sm" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Access / Role Select -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                        Access Level <span class="text-red-400">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <select name="access" required
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none cursor-pointer">
                            <option value="" disabled selected>Select Role</option>
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                            <option value="viewer">Viewer</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-darkBorder/60 flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-6 py-3 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add User
                </button>
                <a href="<?= base_url() ?>" class="bg-transparent hover:bg-slate-800/80 text-slate-300 font-semibold text-xs tracking-wider uppercase px-6 py-3 rounded-xl border border-darkBorder transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Right 1 Col: Role Privileges & Info Card -->
    <div class="bg-darkCard border border-darkBorder rounded-2xl p-6 shadow-xl h-fit">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-darkBorder/60">
            <i class="fa-solid fa-layer-group text-blue-400"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Role Permissions</h3>
        </div>

        <ul class="space-y-4">
            <li class="p-3 bg-[#0A1020] border border-darkBorder rounded-xl">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                    <h4 class="text-xs font-bold text-white uppercase">Admin</h4>
                </div>
                <p class="text-[11px] text-slate-400 leading-relaxed">Complete system control, role assignment, and user deletion privileges.</p>
            </li>

            <li class="p-3 bg-[#0A1020] border border-darkBorder rounded-xl">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <h4 class="text-xs font-bold text-white uppercase">Editor</h4>
                </div>
                <p class="text-[11px] text-slate-400 leading-relaxed">Can add and edit regular records, but cannot manage other users or system settings.</p>
            </li>

            <li class="p-3 bg-[#0A1020] border border-darkBorder rounded-xl">
                <div class="flex items-center gap-2 mb-1">
                    <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                    <h4 class="text-xs font-bold text-white uppercase">Viewer</h4>
                </div>
                <p class="text-[11px] text-slate-400 leading-relaxed">Read-only access across the dashboard with export privileges.</p>
            </li>
        </ul>
    </div>

</div>

<!-- Password Eye Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('userPassword');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                }
            });
        }
    });
</script>