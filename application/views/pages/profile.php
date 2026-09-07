<!-- Header Title -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-regular fa-id-badge text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Account Settings</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">User Profile Management</h2>
            <p class="text-xs text-slate-400">Manage account credentials, permissions, and security settings.</p>
        </div>
    </div>

    <!-- Role Indicator Badge -->
    <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20 shadow-sm">
        <i class="fa-solid fa-shield-halved mr-1.5 text-[10px]"></i> <?= htmlspecialchars($user['access']) ?> Account
    </span>
</div>

<!-- Main Profile Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl max-w-3xl mx-auto overflow-hidden">

    <!-- Card Header Banner -->
    <div class="p-6 bg-[#0A1020] border-b border-darkBorder flex flex-col sm:flex-row items-center gap-4">
        <!-- User Avatar Initial -->
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-blue-500/20 shrink-0">
            <?= strtoupper(substr($user['name'], 0, 2)) ?>
        </div>
        <div class="text-center sm:text-left">
            <h3 class="text-lg font-bold text-white"><?= htmlspecialchars($user['name']) ?></h3>
            <p class="text-xs text-slate-400 font-mono">@<?= htmlspecialchars($user['username']) ?></p>
            <div class="mt-1 flex items-center justify-center sm:justify-start gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                <span class="text-[11px] text-slate-300">Active Profile</span>
            </div>
        </div>
    </div>

    <!-- Profile Fields Grid -->
    <form class="p-6 sm:p-8 space-y-5">

        <!-- Row 1: Full Name & Email -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-user text-sm"></i>
                    </div>
                    <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" readonly
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-default">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-at text-sm"></i>
                    </div>
                    <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-default">
                </div>
            </div>
        </div>

        <!-- Row 2: Contact Number & Username -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Contact No -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Contact No.</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-phone text-xs"></i>
                    </div>
                    <input type="text" name="contact_no" value="<?= htmlspecialchars($user['contact_no']) ?>" readonly
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 font-mono focus:outline-none focus:border-blue-500 transition cursor-default">
                </div>
            </div>

            <!-- Username -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-id-badge text-sm"></i>
                    </div>
                    <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" readonly
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-default">
                </div>
            </div>
        </div>

        <!-- Row 3: Password & Access Level -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Password with Peek Toggle -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="profilePassword" value="<?= htmlspecialchars($user['password']) ?>" readonly
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 tracking-widest focus:outline-none focus:border-blue-500 transition cursor-default">
                    <button type="button" id="toggleProfilePass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none">
                        <i class="fa-regular fa-eye-slash text-sm" id="toggleProfilePassIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Access Level -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Access</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-user-shield text-sm text-blue-400"></i>
                    </div>
                    <input type="text" value="<?= htmlspecialchars($user['access']) ?>" readonly
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 font-semibold focus:outline-none transition cursor-default">
                </div>
            </div>
        </div>

        <!-- Admin Action Buttons (Only visible to Authorized Admins as per wireframe note) -->
        <?php if (!empty($is_admin)): ?>
            <div class="pt-6 border-t border-darkBorder/60 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                <!-- Edit Profile -->
                <button type="button" onclick="alert('Editing enabled for <?= addslashes($user['name']) ?>')"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                    <i class="fa-regular fa-pen-to-square text-xs"></i> Edit Profile
                </button>

                <!-- Reset Password (links to your Auth/reset_password screen) -->
                <a href="<?= base_url('auth/reset_password') ?>"
                    class="bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2">
                    <i class="fa-solid fa-key text-xs"></i> Reset Password
                </a>

                <!-- Forgot Password? (triggers admin reset notification) -->
                <button type="button" onclick="confirm('Send a temporary password reset email to <?= $user['email'] ?>?') && alert('Reset email dispatched.');"
                    class="bg-transparent hover:bg-slate-800 text-slate-400 hover:text-white font-semibold text-xs tracking-wider uppercase px-4 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2">
                    <i class="fa-regular fa-circle-question text-xs"></i> Forgot Password?
                </button>
            </div>
        <?php endif; ?>

    </form>

    <!-- Bottom Admin Permission Note Box (from wireframe) -->
    <div class="px-6 py-4 bg-[#0A1020] border-t border-darkBorder flex items-start gap-3 text-slate-400 text-xs">
        <i class="fa-solid fa-circle-info text-blue-400 text-base mt-0.5 shrink-0"></i>
        <p class="leading-relaxed text-[11px]">
            <strong class="text-slate-300 uppercase">Note:</strong> Regular users cannot see these buttons. Only an authorized Admin will have the displayed profile management buttons visible for another user's profile.
        </p>
    </div>

</div>

<!-- Password Show/Hide Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggleProfilePass');
        const passInput = document.getElementById('profilePassword');
        const passIcon = document.getElementById('toggleProfilePassIcon');

        if (toggleBtn && passInput && passIcon) {
            toggleBtn.addEventListener('click', function() {
                if (passInput.type === 'password') {
                    passInput.type = 'text';
                    passIcon.classList.replace('fa-eye-slash', 'fa-eye');
                    toggleBtn.classList.add('text-blue-400');
                } else {
                    passInput.type = 'password';
                    passIcon.classList.replace('fa-eye', 'fa-eye-slash');
                    toggleBtn.classList.remove('text-blue-400');
                }
            });
        }
    });
</script>