<!DOCTYPE html>
<html lang="en" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Dashboard' ?></title>

    <!-- Immediate Theme Application (Runs before HTML renders to eliminate flicker) -->
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

    <!-- Tailwind JS -->
    <script src="<?= base_url('assets/cdn/tailwindcdn.js') ?>"></script>

    <!-- FontAwesome: Local + CDN Fallback -->
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

    <!-- Global Font Scaling & Light Mode Theme Overrides -->
    <style>
        /* =========================================================
           GLOBAL FONT SIZE SCALING
           Browser default is 16px. 
           Change 17.5px to 18px or 19px if you want it even bigger!
           ========================================================= */
        html {
            font-size: 17.5px !important;
        }

        /* Scale arbitrary micro-font classes proportionally */
        .text-\[10px\] {
            font-size: 0.72rem !important;
            /* ~12.6px */
        }

        .text-\[11px\] {
            font-size: 0.78rem !important;
            /* ~13.6px */
        }

        /* =========================================================
           SEAMLESS LIGHT MODE THEME OVERRIDES
           ========================================================= */
        html.light body {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }

        html.light .bg-darkBg,
        html.light main {
            background-color: #f8fafc !important;
            color: #0f172a !important;
        }

        html.light .bg-darkSidebar,
        html.light aside,
        html.light header {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        html.light .bg-darkCard,
        html.light .bg-\[\#0A1020\],
        html.light .bg-\[\#111C38\],
        html.light .bg-\[\#080E1E\] {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.04) !important;
        }

        html.light .border-darkBorder,
        html.light .border-darkBorder\/40,
        html.light .border-darkBorder\/50,
        html.light .border-darkBorder\/60 {
            border-color: #e2e8f0 !important;
        }

        /* Text Contrast in Light Mode */
        html.light .text-white,
        html.light .row-name {
            color: #0f172a !important;
        }

        html.light .text-slate-200,
        html.light .text-slate-300,
        html.light .row-date {
            color: #334155 !important;
        }

        html.light .text-slate-400,
        html.light .row-phone,
        html.light .row-days {
            color: #64748b !important;
        }

        /* Sidebar Item States in Light Mode */
        html.light .sidebar-active {
            background-color: #eff6ff !important;
            color: #2563eb !important;
            border: 1px solid #bfdbfe !important;
            font-weight: 600 !important;
            box-shadow: none !important;
        }

        html.light .sidebar-active i {
            color: #2563eb !important;
        }

        html.light .sidebar-inactive {
            color: #64748b !important;
        }

        html.light .sidebar-inactive:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        /* Table Components in Light Mode */
        html.light .events-table-head {
            background-color: #f1f5f9 !important;
            border-bottom-color: #e2e8f0 !important;
        }

        html.light .events-table-head th {
            color: #475569 !important;
            background-color: #f1f5f9 !important;
        }

        html.light .event-row:hover {
            background-color: #f8fafc !important;
        }

        html.light .member-avatar {
            background-color: #f1f5f9 !important;
            border-color: #cbd5e1 !important;
            color: #1e293b !important;
        }

        /* WhatsApp Button in Light Mode */
        html.light .wa-btn {
            background-color: #ecfdf5 !important;
            border-color: #a7f3d0 !important;
            color: #065f46 !important;
        }

        html.light .wa-btn:hover {
            background-color: #059669 !important;
            border-color: #059669 !important;
            color: #ffffff !important;
        }

        /* Export Button in Light Mode */
        html.light .export-btn {
            background-color: #ffffff !important;
            border: 1px solid #cbd5e1 !important;
            color: #1e293b !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.06) !important;
        }

        html.light .export-btn:hover {
            background-color: #f8fafc !important;
            border-color: #2563eb !important;
            color: #2563eb !important;
        }

        /* Top Add Member Button in Light Mode */
        html.light .btn-add-member {
            background-color: #2563eb !important;
            color: #ffffff !important;
            border: 1px solid #2563eb !important;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25) !important;
        }

        html.light .btn-add-member:hover {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
        }

        /* Pagination Controls in Light Mode */
        html.light #eventsPaginationBar {
            background-color: #ffffff !important;
            border-top-color: #e2e8f0 !important;
        }

        html.light #eventsPageInfo {
            color: #64748b !important;
        }

        html.light #eventsPageInfo strong {
            color: #0f172a !important;
        }

        html.light #eventsPageNav button {
            color: #475569 !important;
        }

        html.light #eventsPageNav button:hover {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
        }

        html.light .divide-darkBorder> :not([hidden])~ :not([hidden]) {
            border-color: #e2e8f0 !important;
        }
    </style>
</head>

<body class="bg-darkBg text-slate-200 flex min-h-screen antialiased overflow-x-hidden transition-colors">