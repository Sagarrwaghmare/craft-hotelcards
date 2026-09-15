<!-- Header Title -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-regular fa-id-badge text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Account Settings</span>
            <h2 class="text-2xl font-bold text-white tracking-tight profile-title">User Profile Management</h2>
            <p class="text-xs text-slate-400 profile-subtitle">Manage account credentials, permissions, and security settings.</p>
        </div>
    </div>

    <!-- Role Indicator Badge -->
    <?php
    $user_access = $user['access'] ?? 'Viewer';
    if (strtolower($user_access) === 'admin'):
    ?>
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20 shadow-sm">
            <i class="fa-solid fa-shield-halved mr-1.5 text-[10px]"></i> Admin Account
        </span>
    <?php elseif (strtolower($user_access) === 'editor'): ?>
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 shadow-sm">
            <i class="fa-solid fa-pen-to-square mr-1.5 text-[10px]"></i> Editor Account
        </span>
    <?php else: ?>
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-slate-500/10 text-slate-300 border border-slate-500/20 shadow-sm">
            <i class="fa-regular fa-eye mr-1.5 text-[10px]"></i> Viewer Account
        </span>
    <?php endif; ?>
</div>

<!-- Flash Alerts -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="max-w-3xl mx-auto mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-sm shrink-0"></i>
        <span><?= $this->session->flashdata('success') ?></span>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="max-w-3xl mx-auto mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-sm shrink-0"></i>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Main Profile Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl max-w-3xl mx-auto overflow-hidden">

    <!-- Card Header Banner -->
    <div class="p-6 bg-[#0A1020] border-b border-darkBorder flex flex-col sm:flex-row items-center gap-4 profile-card-header">
        <!-- User Avatar Initial -->
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center text-white text-xl font-bold shadow-lg shadow-blue-500/25 shrink-0">
            <?= strtoupper(substr($user['name'], 0, 2)) ?>
        </div>
        <div class="text-center sm:text-left">
            <h3 class="text-lg font-bold text-white profile-user-name"><?= htmlspecialchars($user['name']) ?></h3>
            <p class="text-xs text-slate-400 font-mono">@<?= htmlspecialchars($user['username']) ?></p>
            <div class="mt-1 flex items-center justify-center sm:justify-start gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[11px] text-slate-300 profile-status">Active Profile</span>
            </div>
        </div>
    </div>

    <!-- Profile Fields Display -->
    <div class="p-6 sm:p-8 space-y-5">

        <!-- Row 1: Full Name & Email -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-user text-sm"></i>
                    </div>
                    <input type="text" value="<?= htmlspecialchars($user['name']) ?>" readonly
                        class="profile-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 focus:outline-none cursor-default">
                </div>
            </div>

            <!-- Email -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-at text-sm"></i>
                    </div>
                    <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly
                        class="profile-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 focus:outline-none cursor-default">
                </div>
            </div>
        </div>

        <!-- Row 2: Contact Number & Username -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Contact No -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Contact No.</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-phone text-xs"></i>
                    </div>
                    <input type="text" value="<?= !empty($user['contact_no']) ? htmlspecialchars($user['contact_no']) : 'Not provided' ?>" readonly
                        class="profile-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 font-mono focus:outline-none cursor-default">
                </div>
            </div>

            <!-- Username -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Username</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-id-badge text-sm"></i>
                    </div>
                    <input type="text" value="<?= htmlspecialchars($user['username']) ?>" readonly
                        class="profile-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 font-mono focus:outline-none cursor-default">
                </div>
            </div>
        </div>

        <!-- Row 3: Password & Access Level -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Password Placeholder -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="profilePassword" value="••••••••••••" readonly
                        class="profile-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-400 tracking-widest focus:outline-none cursor-default">
                    <button type="button" id="toggleProfilePass" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none">
                        <i class="fa-regular fa-eye-slash text-sm" id="toggleProfilePassIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Access Level -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Access</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-user-shield text-sm text-blue-400"></i>
                    </div>
                    <input type="text" value="<?= htmlspecialchars($user['access']) ?>" readonly
                        class="profile-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 font-semibold focus:outline-none cursor-default">
                </div>
            </div>
        </div>

        <!-- Action Buttons (Restyled for high contrast in light & dark) -->
        <div class="pt-6 border-t border-darkBorder/60 flex flex-wrap items-center justify-center sm:justify-start gap-3 profile-actions-bar">
            <!-- Edit Profile Button (Opens Modal) -->
            <button type="button" id="openEditProfileModalBtn"
                class="btn-edit-profile bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl transition shadow-md shadow-blue-600/25 flex items-center gap-2 active:scale-[0.98]">
                <i class="fa-regular fa-pen-to-square text-xs"></i> Edit Profile
            </button>

            <!-- Change Password Button -->
            <a href="<?= base_url('auth/reset_password') ?>"
                class="btn-change-password bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-key text-xs"></i> Change Password
            </a>

            <!-- Sign Out Button -->
            <a href="<?= base_url('auth/logout') ?>"
                class="btn-profile-logout bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold text-xs tracking-wider uppercase px-4 py-2.5 rounded-xl border border-red-500/30 transition flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i> Logout
            </a>
        </div>

    </div>

</div>

<!-- ======================================================= -->
<!-- MODAL: Edit Profile                                     -->
<!-- ======================================================= -->
<div id="editProfileModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 transition-all">
    <div class="w-full max-w-md bg-darkCard border border-darkBorder rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-200" id="profileModalCard">

        <!-- Header -->
        <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between">
            <h3 class="text-base font-bold text-white tracking-wide flex items-center gap-2">
                <i class="fa-regular fa-pen-to-square text-blue-400"></i> Edit Profile Information
            </h3>
            <button type="button" id="closeProfileModalCross" class="text-slate-400 hover:text-white text-lg focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Form -->
        <form action="<?= base_url('main/update_profile') ?>" method="POST" class="p-6 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Full Name</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($user['name']) ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Email Address</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition font-mono text-xs">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Contact Number</label>
                <input type="text" name="contact_no" value="<?= htmlspecialchars($user['contact_no']) ?>" placeholder="+1-555-0100"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition font-mono text-xs">
            </div>

            <div class="pt-4 border-t border-darkBorder flex items-center justify-end gap-3">
                <button type="button" id="closeProfileModalBtn"
                    class="modal-cancel-btn bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-semibold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-darkBorder transition">
                    Cancel
                </button>
                <button type="submit"
                    class="modal-save-btn bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20 transition">
                    Save Changes
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Scoped Light Mode Theme Styles for Profile -->
<style>
    /* Titles & Subtitles */
    html.light .profile-title,
    html.light .profile-user-name {
        color: #0f172a !important;
    }

    html.light .profile-subtitle,
    html.light .form-label,
    html.light .profile-status {
        color: #64748b !important;
    }

    /* Profile Inputs in Light Mode */
    html.light .profile-input {
        background-color: #f8fafc !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
    }

    html.light #profilePassword {
        color: #475569 !important;
    }

    /* Edit Profile Button (Solid Primary Blue) */
    html.light .btn-edit-profile {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border: 1px solid #2563eb !important;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25) !important;
    }

    html.light .btn-edit-profile:hover {
        background-color: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
    }

    /* Change Password Button in Light Mode (Clean White Card Button) */
    html.light .btn-change-password {
        background-color: #ffffff !important;
        color: #1e293b !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    html.light .btn-change-password:hover {
        background-color: #f8fafc !important;
        border-color: #94a3b8 !important;
        color: #0f172a !important;
    }

    /* Logout Button in Light Mode (Readable Crimson Red) */
    html.light .btn-profile-logout {
        background-color: #fef2f2 !important;
        color: #dc2626 !important;
        border: 1px solid #fecaca !important;
        box-shadow: 0 1px 2px 0 rgba(220, 38, 38, 0.05) !important;
    }

    html.light .btn-profile-logout:hover {
        background-color: #fee2e2 !important;
        border-color: #fca5a5 !important;
        color: #b91c1c !important;
    }

    /* Modal Buttons in Light Mode */
    html.light .modal-cancel-btn {
        background-color: #ffffff !important;
        color: #1e293b !important;
        border: 1px solid #cbd5e1 !important;
    }

    html.light .modal-cancel-btn:hover {
        background-color: #f8fafc !important;
        color: #0f172a !important;
    }
</style>

<!-- Scripts for peek and profile modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Peek script
        const toggleBtn = document.getElementById('toggleProfilePass');
        const passInput = document.getElementById('profilePassword');
        const passIcon = document.getElementById('toggleProfilePassIcon');

        if (toggleBtn && passInput && passIcon) {
            toggleBtn.addEventListener('click', function() {
                if (passInput.type === 'password') {
                    passInput.type = 'text';
                    passInput.value = '(Hidden for security)';
                    passIcon.classList.replace('fa-eye-slash', 'fa-eye');
                    toggleBtn.classList.add('text-blue-400');
                } else {
                    passInput.type = 'password';
                    passInput.value = '••••••••••••';
                    passIcon.classList.replace('fa-eye', 'fa-eye-slash');
                    toggleBtn.classList.remove('text-blue-400');
                }
            });
        }

        // Modal scripts
        const modal = document.getElementById('editProfileModal');
        const card = document.getElementById('profileModalCard');
        const openBtn = document.getElementById('openEditProfileModalBtn');
        const closeCross = document.getElementById('closeProfileModalCross');
        const closeBtn = document.getElementById('closeProfileModalBtn');

        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            card.classList.remove('scale-100');
            card.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeCross) closeCross.addEventListener('click', closeModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });
    });
</script>