<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Dashboard' ?></title>

    <!-- Tailwind JS -->
    <script src="<?= base_url('assets/cdn/tailwindcdn.js') ?>"></script>

    <!-- FontAwesome: Local + CDN Fallback to guarantee icons render -->
    <link rel="stylesheet" href="<?= base_url('assets/cdn/fontawesome/css/all.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        darkBg: '#090E1A',
                        darkSidebar: '#0B132B',
                        darkCard: '#111C38',
                        darkBorder: '#1E2945',
                        brandBlue: '#2563EB'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-darkBg text-slate-200 flex min-h-screen antialiased overflow-x-hidden">