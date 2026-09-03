<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Software Login' ?></title>

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

    <!-- Top Branding / Logo Header -->
    <div class="flex flex-col items-center mb-6 text-center">
        <!-- Logo Placeholder (Swap out when ready) -->
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg shadow-blue-500/20 mb-3 border border-blue-400/30">
            <i class="fa-solid fa-shapes text-white text-2xl"></i>
        </div>
        <h1 class="text-xl font-extrabold tracking-widest text-white uppercase">SOFTWARE LOGIN</h1>
    </div>

    <!-- Login Card Container -->
    <div class="w-full max-w-md bg-darkCard border border-darkBorder rounded-2xl p-8 shadow-2xl">

        <!-- Flash Message Notification -->
        <?php if ($this->session->flashdata('error')): ?>
            <div class="mb-5 p-3 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span><?= $this->session->flashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('auth/authenticate') ?>" method="POST" class="space-y-5">

            <!-- Username Field -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Username:</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-user text-sm"></i>
                    </div>
                    <input type="text" name="username" required placeholder="Enter username"
                           class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-3 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>
            </div>

            <!-- Password Field with Show/Hide Toggle -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-2">Password:</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-lock text-sm"></i>
                    </div>
                    <input type="password" id="loginPassword" name="password" required placeholder="Enter password"
                           class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-20 py-3 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                    
                    <!-- Toggle Show/Hide Button with Eye Icon -->
                    <button type="button" id="togglePasswordBtn" class="absolute inset-y-0 right-0 pr-3.5 flex items-center gap-1.5 text-xs text-slate-400 hover:text-white transition focus:outline-none">
                        <span id="toggleText">Show</span>
                        <i class="fa-regular fa-eye" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Log In Button -->
            <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-xl text-sm uppercase tracking-wider transition shadow-lg shadow-blue-600/20 active:scale-[0.99]">
                Log In
            </button>

            <!-- Navigation Links -->
            <div class="flex items-center justify-between text-xs pt-1 text-slate-400">
                <a href="#" class="hover:text-blue-400 hover:underline transition">Forgot Password?</a>
                <div>
                    Don't have an account? 
                    <a href="#" class="text-white font-semibold hover:text-blue-400 hover:underline ml-1 transition">Sign Up</a>
                </div>
            </div>

            <!-- Divider -->
            <div class="relative flex py-2 items-center">
                <div class="flex-grow border-t border-darkBorder"></div>
                <span class="flex-shrink mx-4 text-xs text-slate-500 uppercase tracking-wider font-medium">Or log in with</span>
                <div class="flex-grow border-t border-darkBorder"></div>
            </div>

            <!-- Google Social Login (GitHub removed as requested) -->
            <div>
                <a href="#" class="w-full flex items-center justify-center gap-3 bg-[#0A1020] hover:bg-slate-800/80 border border-darkBorder hover:border-slate-600 text-slate-200 font-medium py-2.5 px-4 rounded-xl text-sm transition">
                    <!-- Google SVG Icon -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Google</span>
                </a>
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