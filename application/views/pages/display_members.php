<!-- Header Title -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-calendar-check text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Analytics & Outreach</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">Membership and Events Overview</h2>
            <p class="text-xs text-slate-400">Track upcoming member birthdays, anniversaries, and connect directly via WhatsApp.</p>
        </div>
    </div>

    <a href="<?= base_url('main/add_member') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-4 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2 self-start sm:self-auto">
        <i class="fa-solid fa-user-plus text-xs"></i> Add Member
    </a>
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
    <div class="px-6 py-4 border-b border-darkBorder flex items-center justify-between bg-[#0A1020]">
        <div class="flex items-center gap-2">
            <i class="fa-solid fa-bullhorn text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Upcoming Events Schedule</h3>
        </div>
        <div class="flex items-center gap-3">
            <span id="filter-reset-btn" onclick="resetFilters()" class="hidden text-xs text-blue-400 hover:text-blue-300 cursor-pointer underline">
                Clear Filter
            </span>
            <span class="text-xs text-slate-400">Total upcoming: <strong id="visible-count" class="text-slate-200"><?= count($events ?? []) ?> events</strong></span>
        </div>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300" id="eventsTable">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/60 border-b border-darkBorder font-semibold">
                <tr>
                    <th scope="col" class="py-3.5 px-6">Member</th>
                    <th scope="col" class="py-3.5 px-6">Type</th>
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

                            <!-- Member Name -->
                            <td class="py-4 px-6 font-semibold text-white">
                                <div class="flex items-center gap-3">
                                    <span class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-slate-300">
                                        <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                    </span>
                                    <div>
                                        <span><?= htmlspecialchars($row['name']) ?></span>
                                        <?php if (!empty($row['contact_no'])): ?>
                                            <div class="text-[11px] font-normal text-slate-400 font-mono"><?= htmlspecialchars($row['contact_no']) ?></div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>

                            <!-- Card Type Badge -->
                            <td class="py-4 px-6">
                                <?php if (strtolower($row['type']) === 'gold'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                        <i class="fa-solid fa-crown text-[10px] mr-1.5"></i> Gold
                                    </span>
                                <?php elseif (strtolower($row['type']) === 'platinum'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-400/10 text-slate-300 border border-slate-400/30">
                                        <i class="fa-solid fa-gem text-[10px] mr-1.5"></i> Platinum
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-500/10 text-gray-300 border border-gray-500/30">
                                        <?= htmlspecialchars($row['type']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Event Badge -->
                            <td class="py-4 px-6">
                                <?php if (strtolower($row['event']) === 'birthday'): ?>
                                    <span class="inline-flex items-center gap-2 text-xs font-medium text-pink-300">
                                        <span class="text-base leading-none">🎂</span> Birthday
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-2 text-xs font-medium text-sky-300">
                                        <span class="text-base leading-none">💍</span> Anniversary
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Date -->
                            <td class="py-4 px-6 font-mono text-xs text-slate-300">
                                <div><?= htmlspecialchars($row['date']) ?></div>
                                <span class="text-[10px] text-slate-500"><?= $daysText ?></span>
                            </td>

                            <!-- WhatsApp Link -->
                            <td class="py-4 px-6 text-center">
                                <?php if (!empty($clean_phone)): ?>
                                    <a href="<?= $wa_url ?>"
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 bg-emerald-600/20 hover:bg-emerald-600 text-emerald-300 hover:text-white border border-emerald-500/40 hover:border-emerald-500 text-xs font-semibold px-3.5 py-1.5 rounded-lg transition shadow-sm">
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

    <!-- Export Action Footer -->
    <div class="p-6 bg-[#0A1020] border-t border-darkBorder flex justify-center">
        <button type="button" onclick="openExportModal()" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs tracking-wider uppercase px-8 py-3 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-lg hover:border-blue-500/50">
            <i class="fa-solid fa-file-arrow-down text-sm text-blue-400"></i> Export Schedule
        </button>
    </div>

    <!-- EXPORT FORMAT MODAL -->
    <div id="exportModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4">
        <div class="bg-[#0f172a] border border-slate-700 w-full max-w-md rounded-2xl shadow-2xl p-6 relative animate-in fade-in zoom-in duration-150">

            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-500/15 border border-blue-500/30 text-blue-400 flex items-center justify-center">
                        <i class="fa-solid fa-download text-sm"></i>
                    </div>
                    <h3 class="text-base font-bold text-white">Export Schedule</h3>
                </div>
                <button type="button" onclick="closeExportModal()" class="text-slate-400 hover:text-white p-1 rounded-lg transition">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <p class="text-xs text-slate-400 mt-3 mb-5">
                Choose your preferred file format to download the upcoming events schedule:
            </p>

            <!-- Format Options Grid -->
            <div class="grid grid-cols-2 gap-4">

                <!-- Option 1: CSV -->
                <button type="button" onclick="exportToCSV()" class="group bg-slate-900/80 hover:bg-emerald-950/30 border border-slate-800 hover:border-emerald-500/50 rounded-xl p-4 flex flex-col items-center text-center transition">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/15 text-emerald-400 border border-emerald-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <i class="fa-solid fa-file-csv text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-white">CSV Spreadsheet</span>
                    <span class="text-[11px] text-slate-400 mt-1">Excel & Sheets ready</span>
                </button>

                <!-- Option 2: PDF -->
                <button type="button" onclick="exportToPDF()" class="group bg-slate-900/80 hover:bg-rose-950/30 border border-slate-800 hover:border-rose-500/50 rounded-xl p-4 flex flex-col items-center text-center transition">
                    <div class="w-12 h-12 rounded-xl bg-rose-500/15 text-rose-400 border border-rose-500/30 flex items-center justify-center mb-3 group-hover:scale-110 transition">
                        <i class="fa-solid fa-file-pdf text-2xl"></i>
                    </div>
                    <span class="text-sm font-semibold text-white">PDF Document</span>
                    <span class="text-[11px] text-slate-400 mt-1">Printable report</span>
                </button>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="button" onclick="closeExportModal()" class="px-4 py-2 text-xs font-semibold text-slate-400 hover:text-white transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>

</div>

<!-- JavaScript: Toggle Filtering Logic -->
<script>
    let currentFilter = 'all'; // 'all', 'gold', or 'platinum'

    function toggleCardFilter(type) {
        // If already selected, reset to all
        if (currentFilter === type) {
            resetFilters();
            return;
        }

        currentFilter = type;
        applyFilter();
    }

    function resetFilters() {
        currentFilter = 'all';
        applyFilter();
    }

    function applyFilter() {
        const rows = document.querySelectorAll('.event-row');
        const goldCard = document.getElementById('card-filter-gold');
        const platCard = document.getElementById('card-filter-platinum');
        const goldBadge = document.getElementById('badge-gold');
        const platBadge = document.getElementById('badge-platinum');
        const resetBtn = document.getElementById('filter-reset-btn');
        const countDisplay = document.getElementById('visible-count');

        let visibleCount = 0;

        // Reset visual styles on cards
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

        // Show/Hide table rows
        rows.forEach(row => {
            const rowType = row.getAttribute('data-type');
            if (currentFilter === 'all' || rowType === currentFilter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        if (countDisplay) {
            countDisplay.innerText = visibleCount + ' events';
        }
    }
</script>

<!-- html2pdf.js CDN for direct PDF downloads -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<script>
    // Modal controls
    function openExportModal() {
        const modal = document.getElementById('exportModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeExportModal() {
        const modal = document.getElementById('exportModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close on backdrop click or ESC key
    document.getElementById('exportModal').addEventListener('click', function(e) {
        if (e.target === this) closeExportModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeExportModal();
    });

    // 1. EXPORT TO CSV
    function exportToCSV() {
        closeExportModal();

        const rows = document.querySelectorAll('#eventsTable tbody tr.event-row');
        // Prepend UTF-8 BOM (\uFEFF) so Excel opens all characters and names properly
        let csvContent = "\uFEFFMember Name,Contact No,Card Type,Event,Date,Schedule\n";
        let count = 0;

        rows.forEach(row => {
            // Respect active Gold/Platinum filters
            if (row.style.display === 'none') return;

            const name = `"${(row.dataset.name  || '').replace(/"/g, '""')}"`;
            const phone = `"${(row.dataset.phone || '').replace(/"/g, '""')}"`;
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

    // 2. EXPORT TO PDF (Matches the exact clean corporate report layout)
    function exportToPDF() {
        closeExportModal();

        const rows = document.querySelectorAll('#eventsTable tbody tr.event-row');
        const visibleRows = [];

        rows.forEach(row => {
            if (row.style.display !== 'none') {
                visibleRows.push({
                    name: row.dataset.name || '',
                    phone: row.dataset.phone || '-',
                    card: row.dataset.card || '',
                    event: row.dataset.event || '',
                    date: row.dataset.date || '',
                    days: row.dataset.days || ''
                });
            }
        });

        if (visibleRows.length === 0) {
            alert('No records available to export.');
            return;
        }

        // Format current date matching report header (e.g., "Jan 01, 2026")
        const now = new Date();
        const formattedDate = now.toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: '2-digit'
        });

        // Build table rows HTML
        let tableRowsHtml = '';
        visibleRows.forEach(item => {
            tableRowsHtml += `
                <tr>
                    <td style="border: 1px solid #D1D5DB; padding: 10px 14px; font-weight: 500; color: #111827;">${item.name}</td>
                    <td style="border: 1px solid #D1D5DB; padding: 10px 14px; color: #374151;">${item.phone}</td>
                    <td style="border: 1px solid #D1D5DB; padding: 10px 14px; color: #374151;">${item.card}</td>
                    <td style="border: 1px solid #D1D5DB; padding: 10px 14px; color: #374151;">${item.event}</td>
                    <td style="border: 1px solid #D1D5DB; padding: 10px 14px; color: #374151;">${item.date}</td>
                    <td style="border: 1px solid #D1D5DB; padding: 10px 14px; color: #374151;">${item.days}</td>
                </tr>
            `;
        });

        // Build the clean offscreen report matching the screenshot
        const printContainer = document.createElement('div');
        printContainer.style.position = 'fixed';
        printContainer.style.left = '-9999px';
        printContainer.style.top = '0';
        printContainer.style.width = '1000px';
        printContainer.style.padding = '32px 40px';
        printContainer.style.backgroundColor = '#ffffff';
        printContainer.style.fontFamily = 'Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif';
        printContainer.style.color = '#111827';

        printContainer.innerHTML = `
            <div style="margin-bottom: 24px;">
                <h1 style="font-size: 26px; font-weight: 700; color: #111827; margin: 0 0 6px 0; letter-spacing: -0.02em;">
                    Membership & Events Report
                </h1>
                <div style="font-size: 14px; color: #374151; margin: 0;">
                    ${formattedDate} &bull; Hotel Cards Overview
                </div>
            </div>

            <table style="width: 100%; border-collapse: collapse; font-size: 13px; text-align: left;">
                <thead>
                    <tr style="background-color: #E5E7EB;">
                        <th style="border: 1px solid #D1D5DB; padding: 10px 14px; font-weight: 600; color: #111827;">Member Name</th>
                        <th style="border: 1px solid #D1D5DB; padding: 10px 14px; font-weight: 600; color: #111827;">Contact No</th>
                        <th style="border: 1px solid #D1D5DB; padding: 10px 14px; font-weight: 600; color: #111827;">Card Type</th>
                        <th style="border: 1px solid #D1D5DB; padding: 10px 14px; font-weight: 600; color: #111827;">Event</th>
                        <th style="border: 1px solid #D1D5DB; padding: 10px 14px; font-weight: 600; color: #111827;">Date</th>
                        <th style="border: 1px solid #D1D5DB; padding: 10px 14px; font-weight: 600; color: #111827;">Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    ${tableRowsHtml}
                </tbody>
                <tfoot>
                    <tr style="font-weight: 700; background-color: #ffffff;">
                        <td style="border: 1px solid #D1D5DB; padding: 12px 14px; color: #111827;">Total</td>
                        <td style="border: 1px solid #D1D5DB; padding: 12px 14px; color: #6B7280;">--</td>
                        <td style="border: 1px solid #D1D5DB; padding: 12px 14px; color: #6B7280;">--</td>
                        <td style="border: 1px solid #D1D5DB; padding: 12px 14px; color: #6B7280;">--</td>
                        <td style="border: 1px solid #D1D5DB; padding: 12px 14px; color: #6B7280;">--</td>
                        <td style="border: 1px solid #D1D5DB; padding: 12px 14px; color: #111827;">${visibleRows.length} Events</td>
                    </tr>
                </tfoot>
            </table>
        `;

        document.body.appendChild(printContainer);

        const todaySlug = now.toISOString().slice(0, 10);
        const opt = {
            margin: [10, 10, 10, 10],
            filename: `Membership_Events_Report_${todaySlug}.pdf`,
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2,
                useCORS: true,
                backgroundColor: '#ffffff'
            },
            jsPDF: {
                unit: 'mm',
                format: 'a4',
                orientation: 'portrait'
            }
        };

        html2pdf().set(opt).from(printContainer).save().then(() => {
            document.body.removeChild(printContainer);
        }).catch(err => {
            console.error('PDF generation error:', err);
            document.body.removeChild(printContainer);
        });
    }
</script>