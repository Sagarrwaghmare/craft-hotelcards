<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Software Login' ?></title>

    <!-- Immediate Theme Application (Prevents screen flicker on load) -->
    <script>
        (function() {
            const theme = localStorage.getItem('hotelcards_theme') || 'dark';
            if (theme === 'light') {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
            } else {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            }
        })();
    </script>

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

    <!-- Scoped Light Mode Overrides for Login -->
    <style>
        html.light body {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }

        html.light .auth-card {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.03) !important;
        }

        html.light .auth-brand-title {
            color: #0f172a !important;
        }

        html.light .auth-brand-subtitle {
            color: #64748b !important;
        }

        html.light .auth-label {
            color: #334155 !important;
        }

        html.light .auth-input {
            background-color: #f8fafc !important;
            border-color: #cbd5e1 !important;
            color: #0f172a !important;
        }

        html.light .auth-input::placeholder {
            color: #94a3b8 !important;
        }

        html.light .auth-input:focus {
            background-color: #ffffff !important;
            border-color: #2563eb !important;
        }

        html.light .auth-submit-btn {
            background-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25) !important;
        }

        html.light .auth-submit-btn:hover {
            background-color: #1d4ed8 !important;
        }

        html.light .auth-link {
            color: #64748b !important;
        }

        html.light .auth-link:hover {
            color: #2563eb !important;
        }
    </style>
</head>

<body class="bg-darkBg text-slate-200 min-h-screen flex flex-col justify-center items-center p-4 antialiased transition-colors">

    <!-- Top Branding / Logo Header -->
    <div class="flex flex-col items-center mb-6 text-center">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-blue-500/20 mb-3 border border-blue-400/30">
            <i class="fa-solid fa-shapes text-white text-2xl"></i>
        </div>
        <h1 class="auth-brand-title text-xl font-extrabold tracking-widest text-white uppercase">HOTEL MEMBERSHIP SYSTEM</h1>
        <p class="auth-brand-subtitle text-xs text-slate-400 mt-1">Sign in to manage members, cards, and staff logs</p>
    </div>

    <!-- Login Card Container -->
    <div class="auth-card w-full max-w-md bg-darkCard border border-darkBorder rounded-2xl p-8 shadow-2xl transition-all">

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-5 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-sm shrink-0"></i>
                <span><?= $this->session->flashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if ($this->session->flashdata('success')): ?>
            <div class="mb-5 p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-sm shrink-0"></i>
                <span><?= $this->session->flashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/authenticate') ?>" method="POST" class="space-y-5">

            <!-- Username or Email Field -->
            <div>
                <label class="auth-label block text-xs font-semibold text-slate-300 mb-2">Username or Email:</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-user text-sm"></i>
                    </div>
                    <input type="text" name="username" required placeholder="Enter username or email"
                        class="auth-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-3 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition font-mono text-xs">
                </div>
            </div>

            <!-- Password Field with Show/Hide Toggle -->
            <div>
                <label class="auth-label block text-xs font-semibold text-slate-300 mb-2">Password:</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="loginPassword" name="password" required placeholder="Enter password"
                        class="auth-input w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-20 py-3 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">

                    <!-- Toggle Show/Hide Button -->
                    <button type="button" id="togglePasswordBtn" class="absolute inset-y-0 right-0 pr-3.5 flex items-center gap-1.5 text-xs text-slate-400 hover:text-white transition focus:outline-none">
                        <span id="toggleText">Show</span>
                        <i class="fa-regular fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Log In Button -->
            <button type="submit"
                class="auth-submit-btn w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl text-sm uppercase tracking-wider transition shadow-lg shadow-blue-600/25 active:scale-[0.99] flex items-center justify-center gap-2">
                <i class="fa-solid fa-right-to-bracket text-xs"></i>
                <span>Log In</span>
            </button>

            <!-- Navigation Links -->
            <div class="flex items-center justify-between text-xs pt-1 text-slate-400">
                <a href="<?= base_url('auth/reset_password') ?>" class="auth-link hover:text-blue-500 hover:underline transition">Forgot Password?</a>
                <span class="auth-brand-subtitle text-[11px] text-slate-500">Hotel Staff Portal</span>
            </div>

        </form>
    </div>

    <!-- Password Show/Hide Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('togglePasswordBtn');
            const passwordInput = document.getElementById('loginPassword');
            const toggleText = document.getElementById('toggleText');
            const toggleIcon = document.getElementById('toggleIcon');

            if (toggleBtn && passwordInput) {
                toggleBtn.addEventListener('click', function() {
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        toggleText.textContent = 'Hide';
                        toggleIcon.classList.remove('fa-eye');
                        toggleIcon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        toggleText.textContent = 'Show';
                        toggleIcon.classList.remove('fa-eye-slash');
                        toggleIcon.classList.add('fa-eye');
                    }
                });
            }
        });
    </script>
</body>

</html>