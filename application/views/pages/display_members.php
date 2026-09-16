<?php
// Role and permission check
$user_role = strtolower(trim((string)$this->session->userdata('access')));
$is_viewer = ($user_role === 'viewer');
?>

<!-- Header Title -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-calendar-check text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Analytics & Outreach</span>
            <h2 class="text-2xl font-bold text-white tracking-tight page-title">Membership and Events Overview</h2>
            <p class="text-xs text-slate-400 page-subtitle">Track upcoming member birthdays, anniversaries, and connect directly via WhatsApp.</p>
        </div>
    </div>

    <!-- Add Member Button (Hidden for Viewers, High-contrast styling) -->
    <?php if (!$is_viewer): ?>
        <a href="<?= base_url('main/add_member') ?>"
            class="btn-add-member bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs tracking-wider uppercase px-4 py-2.5 rounded-xl transition shadow-md shadow-blue-600/25 flex items-center gap-2 self-start sm:self-auto active:scale-[0.98]">
            <i class="fa-solid fa-user-plus text-xs"></i>
            <span>Add Member</span>
        </a>
    <?php endif; ?>
</div>

<!-- SECTION 1: Stat Summary Cards (Toggle Filters) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    <!-- Gold Members Filter Card -->
    <div id="card-filter-gold"
        onclick="toggleCardFilter('gold')"
        role="button"
        tabindex="0"
        title="Click to toggle Gold members filter"
        class="filter-card cursor-pointer select-none bg-darkCard border-2 border-amber-500/30 hover:border-amber-500 rounded-2xl p-5 shadow-xl relative overflow-hidden flex items-center gap-5 transition-all duration-200">
        <div class="w-14 h-10 rounded-lg bg-gradient-to-tr from-amber-600 to-yellow-300 flex items-center justify-center text-slate-900 shadow-md shadow-amber-500/20 shrink-0">
            <i class="fa-solid fa-credit-card text-lg"></i>
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-amber-400 tracking-wider uppercase">Gold Card Members</p>
                <span id="badge-gold" class="hidden text-[10px] px-1.5 py-0.5 rounded bg-amber-500/20 text-amber-300 font-bold uppercase tracking-wider">Active</span>
            </div>
            <h3 class="text-3xl font-extrabold text-white mt-0.5"><?= isset($gold_count) ? $gold_count : 0 ?></h3>
        </div>
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
    </div>

    <!-- Platinum Members Filter Card -->
    <div id="card-filter-platinum"
        onclick="toggleCardFilter('platinum')"
        role="button"
        tabindex="0"
        title="Click to toggle Platinum members filter"
        class="filter-card cursor-pointer select-none bg-darkCard border-2 border-slate-400/30 hover:border-slate-300 rounded-2xl p-5 shadow-xl relative overflow-hidden flex items-center gap-5 transition-all duration-200">
        <div class="w-14 h-10 rounded-lg bg-gradient-to-tr from-slate-500 to-slate-200 flex items-center justify-center text-slate-900 shadow-md shadow-slate-300/20 shrink-0">
            <i class="fa-solid fa-credit-card text-lg"></i>
        </div>
        <div class="flex-1">
            <div class="flex items-center justify-between">
                <p class="text-xs font-semibold text-slate-300 tracking-wider uppercase">Platinum Card Members</p>
                <span id="badge-platinum" class="hidden text-[10px] px-1.5 py-0.5 rounded bg-slate-300/20 text-slate-200 font-bold uppercase tracking-wider">Active</span>
            </div>
            <h3 class="text-3xl font-extrabold text-white mt-0.5"><?= isset($platinum_count) ? $platinum_count : 0 ?></h3>
        </div>
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-slate-400/10 rounded-full blur-xl pointer-events-none"></div>
    </div>

</div>

<!-- SECTION 2: Membership & Events Table Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden">

    <!-- Table Header Bar -->
    <div class="px-6 py-4 border-b border-darkBorder flex items-center justify-between bg-[#0A1020] table-subhead">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-bullhorn text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider subhead-title">Upcoming Events Schedule</h3>
        </div>
        <div class="flex items-center gap-3">
            <span id="filter-reset-btn" onclick="resetFilters()" class="hidden text-xs text-blue-400 hover:text-blue-300 cursor-pointer underline">
                Clear Filter
            </span>
            <span class="text-xs text-slate-400 subhead-counter">Total upcoming: <strong id="visible-count" class="text-slate-200 subhead-count"><?= count($events ?? []) ?> events</strong></span>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300" id="eventsTable">
            <thead class="events-table-head text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/60 border-b border-darkBorder font-semibold">
                <tr>
                    <th scope="col" class="py-3.5 px-6">Member</th>
                    <th scope="col" class="py-3.5 px-6">Subscription Type</th>
                    <th scope="col" class="py-3.5 px-6">Event</th>
                    <th scope="col" class="py-3.5 px-6">Date</th>
                    <th scope="col" class="py-3.5 px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder">
                <?php if (empty($events)): ?>
                    <tr id="empty-state-row">
                        <td colspan="5" class="py-10 text-center text-slate-500">
                            <i class="fa-solid fa-calendar-xmark text-2xl mb-2 block"></i>
                            No upcoming birthdays or anniversaries found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($events as $row):
                        $clean_phone = preg_replace('/[^0-9]/', '', $row['contact_no'] ?? '');
                        $greetMessage = "Dear {$row['name']}, warm greetings from our hotel! 🎉 Wishing you a very Happy {$row['event']} in advance! To celebrate this special occasion with us, we are pleased to offer you an exclusive 20% discount on your next dine-in with your {$row['type']} Membership card. We look forward to welcoming you!";
                        $wa_url = !empty($clean_phone)
                            ? "https://wa.me/{$clean_phone}?text=" . rawurlencode($greetMessage)
                            : "";
                        $daysText = ($row['days_left'] == 0) ? 'Today' : 'in ' . $row['days_left'] . ' days';
                    ?>
                        <tr class="event-row hover:bg-slate-800/40 transition"
                            data-type="<?= strtolower($row['type']) ?>"
                            data-name="<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>"
                            data-phone="<?= htmlspecialchars($row['contact_no'] ?? '-', ENT_QUOTES) ?>"
                            data-card="<?= htmlspecialchars($row['type'], ENT_QUOTES) ?>"
                            data-event="<?= htmlspecialchars($row['event'], ENT_QUOTES) ?>"
                            data-date="<?= htmlspecialchars($row['date'], ENT_QUOTES) ?>"
                            data-days="<?= htmlspecialchars($daysText, ENT_QUOTES) ?>">

                            <!-- Member Name & Clean Avatar -->
                            <td class="py-4 px-6 font-semibold text-white">
                                <div class="flex items-center gap-3">
                                    <span class="member-avatar w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-slate-300 shrink-0">
                                        <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                    </span>
                                    <div>
                                        <span class="row-name font-semibold text-white"><?= htmlspecialchars($row['name']) ?></span>
                                        <?php if (!empty($row['contact_no'])): ?>
                                            <div class="row-phone text-[11px] font-normal text-slate-400 font-mono"><?= htmlspecialchars($row['contact_no']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>

                            <!-- Card Type Badge (Gold / Platinum only) -->
                            <td class="py-4 px-6">
                                <?php if (strtolower($row['type']) === 'gold'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/30">
                                        <i class="fa-solid fa-crown text-[10px] mr-1.5"></i> Gold
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-400/15 text-slate-300 border border-slate-400/30">
                                        <i class="fa-solid fa-gem text-[10px] mr-1.5"></i> Platinum
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Event Badge -->
                            <td class="py-4 px-6">
                                <?php if (strtolower($row['event']) === 'birthday'): ?>
                                    <span class="inline-flex items-center gap-2 text-xs font-medium text-pink-400">
                                        <span class="text-base leading-none">🎂</span> Birthday
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-2 text-xs font-medium text-sky-400">
                                        <span class="text-base leading-none">💍</span> Anniversary
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-6 font-mono text-xs text-slate-300">
                                <div class="row-date"><?= htmlspecialchars($row['date']) ?></div>
                                <span class="row-days text-[10px] text-slate-500"><?= $daysText ?></span>
                            </td>

                            <!-- WhatsApp Link -->
                            <td class="py-4 px-6 text-center">
                                <?php if (!empty($clean_phone)): ?>
                                    <a href="<?= $wa_url ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="wa-btn inline-flex items-center gap-1.5 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-300 hover:text-white border border-emerald-500/40 hover:border-emerald-500 text-xs font-semibold px-3.5 py-1.5 rounded-lg transition shadow-sm">
                                        <i class="fa-brands fa-whatsapp text-sm"></i> Connect
                                    </a>
                                <?php else: ?>
                                    <button type="button"
                                        onclick="alert('No contact number registered for <?= addslashes($row['name']) ?>.')"
                                        class="inline-flex items-center gap-1.5 bg-slate-800 text-slate-500 border border-slate-700 text-xs font-semibold px-3.5 py-1.5 rounded-lg opacity-60 cursor-not-allowed">
                                        <i class="fa-solid fa-phone-slash text-xs"></i> No Phone
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- 10 Events Per Page Pagination Bar -->
    <div id="eventsPaginationBar" class="px-6 py-4 border-t border-darkBorder bg-[#0A1020] flex items-center justify-between">
        <span class="text-xs text-slate-500" id="eventsPageInfo">
            Showing 10 records per page
        </span>
        <nav class="flex items-center gap-1 text-xs font-medium" id="eventsPageNav"></nav>
    </div>

    <!-- Direct CSV Export Button (No Modal, Instant Download) -->
    <div class="p-6 bg-[#0A1020] border-t border-darkBorder flex justify-center">
        <button type="button" onclick="exportToCSV()"
            class="export-btn bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs tracking-wider uppercase px-8 py-3 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-lg hover:border-blue-500/50 active:scale-[0.99]">
            <i class="fa-solid fa-file-csv text-sm text-emerald-400"></i>
            <span>Export CSV</span>
        </button>
    </div>

</div>

<!-- Scoped Light Mode Adjustments for Dashboard -->
<style>
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
</style>

<!-- JavaScript: Toggle Filtering, Pagination, & Direct CSV Export -->
<script>
    let currentFilter = 'all'; // 'all', 'gold', or 'platinum'
    let currentPage = 1;
    const pageSize = 10; // Exactly 10 records per page

    function toggleCardFilter(type) {
        if (currentFilter === type) {
            resetFilters();
            return;
        }
        currentFilter = type;
        currentPage = 1;
        applyFilterAndPagination();
    }

    function resetFilters() {
        currentFilter = 'all';
        currentPage = 1;
        applyFilterAndPagination();
    }

    function changePage(newPage) {
        currentPage = newPage;
        applyFilterAndPagination();
    }

    function applyFilterAndPagination() {
        const rows = Array.from(document.querySelectorAll('.event-row'));
        const goldCard = document.getElementById('card-filter-gold');
        const platCard = document.getElementById('card-filter-platinum');
        const goldBadge = document.getElementById('badge-gold');
        const platBadge = document.getElementById('badge-platinum');
        const resetBtn = document.getElementById('filter-reset-btn');
        const countDisplay = document.getElementById('visible-count');
        const pageInfo = document.getElementById('eventsPageInfo');
        const pageNav = document.getElementById('eventsPageNav');

        // Reset visual card styling
        goldCard.classList.remove('ring-2', 'ring-amber-400', 'bg-amber-950/20');
        platCard.classList.remove('ring-2', 'ring-slate-300', 'bg-slate-800/50');
        goldBadge.classList.add('hidden');
        platBadge.classList.add('hidden');

        if (currentFilter === 'gold') {
            goldCard.classList.add('ring-2', 'ring-amber-400', 'bg-amber-950/20');
            goldBadge.classList.remove('hidden');
            resetBtn.classList.remove('hidden');
        } else if (currentFilter === 'platinum') {
            platCard.classList.add('ring-2', 'ring-slate-300', 'bg-slate-800/50');
            platBadge.classList.remove('hidden');
            resetBtn.classList.remove('hidden');
        } else {
            resetBtn.classList.add('hidden');
        }

        // Filter rows by card type
        const matchingRows = rows.filter(row => {
            const rowType = row.getAttribute('data-type');
            return (currentFilter === 'all' || rowType === currentFilter);
        });

        const totalMatching = matchingRows.length;
        const totalPages = Math.max(1, Math.ceil(totalMatching / pageSize));

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = startIndex + pageSize;

        rows.forEach(row => {
            row.style.display = 'none';
        });

        matchingRows.forEach((row, idx) => {
            if (idx >= startIndex && idx < endIndex) {
                row.style.display = '';
            }
        });

        if (countDisplay) {
            countDisplay.innerText = totalMatching + ' events';
        }

        if (pageInfo) {
            pageInfo.innerHTML = `Showing page <strong class="text-slate-300">${currentPage}</strong> of <strong class="text-slate-300">${totalPages}</strong> (${totalMatching} total events)`;
        }

        if (pageNav) {
            if (totalPages <= 1) {
                pageNav.innerHTML = '';
            } else {
                let navHtml = '';
                if (currentPage > 1) {
                    navHtml += `<button type="button" onclick="changePage(${currentPage - 1})" class="px-2.5 py-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">&larr; Prev</button>`;
                }
                for (let p = 1; p <= totalPages; p++) {
                    if (p === currentPage) {
                        navHtml += `<span class="px-2.5 py-1 rounded-lg bg-blue-600 text-white font-bold">${p}</span>`;
                    } else {
                        navHtml += `<button type="button" onclick="changePage(${p})" class="px-2.5 py-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">${p}</button>`;
                    }
                }
                if (currentPage < totalPages) {
                    navHtml += `<button type="button" onclick="changePage(${currentPage + 1})" class="px-2.5 py-1 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">Next &rarr;</button>`;
                }
                pageNav.innerHTML = navHtml;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        applyFilterAndPagination();
    });

    // ========================================================
    // DIRECT CSV EXPORT (With Excel Phone Formula Fix)
    // ========================================================
    function exportToCSV() {
        const rows = document.querySelectorAll('#eventsTable tbody tr.event-row');
        let csvContent = "\uFEFFMember Name,Contact No,Card Type,Event,Date,Schedule\n";
        let count = 0;

        rows.forEach(row => {
            const rowType = row.getAttribute('data-type');
            if (currentFilter !== 'all' && rowType !== currentFilter) return;

            const name = `"${(row.dataset.name || '').replace(/"/g, '""')}"`;

            // Excel Phone Formula Fix:
            // Prevents Excel from calculating "+1-555-0188" as "= 1 - 555 - 188 = -742"
            const rawPhone = (row.dataset.phone || '').trim();
            let phone = '""';
            if (rawPhone && rawPhone !== '-') {
                phone = `"=""${rawPhone.replace(/"/g, '""')}"""`;
            } else {
                phone = '"-"';
            }

            const card = `"${(row.dataset.card  || '').replace(/"/g, '""')}"`;
            const event = `"${(row.dataset.event || '').replace(/"/g, '""')}"`;
            const date = `"${(row.dataset.date  || '').replace(/"/g, '""')}"`;
            const days = `"${(row.dataset.days  || '').replace(/"/g, '""')}"`;

            csvContent += `${name},${phone},${card},${event},${date},${days}\n`;
            count++;
        });

        if (count === 0) {
            alert('No records available to export.');
            return;
        }

        const blob = new Blob([csvContent], {
            type: 'text/csv;charset=utf-8;'
        });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        const today = new Date().toISOString().slice(0, 10);
        a.href = url;
        a.download = `Membership_Events_${today}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        URL.revokeObjectURL(url);
    }
</script>