<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Reset Password' ?></title>

    <!-- Tailwind JS & FontAwesome -->
    <script src="<?= base_url('assets/cdn/tailwindcdn.js') ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#090E1A',
                        darkCard: '#111C38',
                        darkBorder: '#1E2945',
                        brandBlue: '#2563EB'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-darkBg text-slate-200 min-h-screen flex flex-col justify-center items-center p-4 antialiased">

    <!-- Top Branding / Header -->
    <div class="flex flex-col items-center mb-6 text-center">
        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-blue-500/20 mb-3 border border-blue-400/30">
            <i class="fa-solid fa-key text-white text-xl"></i>
        </div>
        <h1 class="text-xl font-extrabold tracking-widest text-white uppercase">RESET PASSWORD</h1>
        <p class="text-xs text-slate-400 mt-1">Set New Password</p>
    </div>

    <!-- Main Card Container -->
    <div class="w-full max-w-md bg-darkCard border border-darkBorder rounded-2xl shadow-2xl overflow-hidden">
        
        <div class="p-8">
            <!-- Flash Messages -->
            <?php if ($this->session->flashdata('error')): ?>
                <div class="mb-5 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span><?= $this->session->flashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('success')): ?>
                <div class="mb-5 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i>
                    <span><?= $this->session->flashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/update_password') ?>" method="POST" class="space-y-5">

                <!-- Old Password Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Old Password:</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="old_password" name="old_password" required placeholder="Enter current password"
                               class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        <button type="button" class="toggle-pass absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none" data-target="old_password">
                            <i class="fa-regular fa-eye-slash text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- New Password Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">New Password:</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" id="new_password" name="new_password" required placeholder="Enter new password"
                               class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        <button type="button" class="toggle-pass absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none" data-target="new_password">
                            <i class="fa-regular fa-eye-slash text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Re-enter Password Field -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Re-enter Password:</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm new password"
                               class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                        <button type="button" class="toggle-pass absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-500 hover:text-slate-300 focus:outline-none" data-target="confirm_password">
                            <i class="fa-regular fa-eye-slash text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl text-xs uppercase tracking-wider transition shadow-lg shadow-blue-600/20 active:scale-[0.99] flex items-center justify-center gap-2">
                        <i class="fa-solid fa-rotate text-xs"></i> Reset Password
                    </button>
                </div>

                <!-- Back Link -->
                <div class="text-center pt-1">
                    <a href="<?= base_url('auth') ?>" class="text-xs text-slate-400 hover:text-white transition">
                        &larr; Back to Login
                    </a>
                </div>

            </form>
        </div>

        <!-- Wireframe Bottom Note Box -->
        <div class="px-6 py-3.5 bg-[#0A1020] border-t border-darkBorder flex items-start gap-2.5 text-slate-400 text-xs">
            <i class="fa-solid fa-circle-info text-blue-400 text-sm mt-0.5 shrink-0"></i>
            <p class="leading-relaxed text-[11px]">
                <strong class="text-slate-300 uppercase">Note:</strong> This will create a random password & email it to the admin email id.
            </p>
        </div>

    </div>

    <!-- Multi-Field Eye Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-pass').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const input = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                        this.classList.add('text-blue-400');
                    } else {
                        input.type = 'password';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                        this.classList.remove('text-blue-400');
                    }
                });
            });
        });
    </script>
</body>
</html>