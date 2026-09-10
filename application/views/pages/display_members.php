<!-- Header Title -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-calendar-check text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Analytics & Outreach</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">Membership and Events Overview</h2>
            <p class="text-xs text-slate-400">Track upcoming member birthdays, anniversaries, and connect directly.</p>
        </div>
    </div>

    <a href="<?= base_url('main/add_member') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-4 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2 self-start sm:self-auto">
        <i class="fa-solid fa-user-plus text-xs"></i> Add Member
    </a>
</div>

<!-- SECTION 1: Stat Summary Cards (Gold & Platinum) -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

    <!-- Gold Members Card -->
    <div class="bg-darkCard border border-amber-500/30 rounded-2xl p-5 shadow-xl relative overflow-hidden flex items-center gap-5">
        <div class="w-14 h-10 rounded-lg bg-gradient-to-tr from-amber-600 to-yellow-300 flex items-center justify-center text-slate-900 shadow-md shadow-amber-500/20 shrink-0">
            <i class="fa-solid fa-credit-card text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-amber-400 tracking-wider uppercase">Gold Card Members</p>
            <h3 class="text-3xl font-extrabold text-white mt-0.5"><?= isset($gold_count) ? $gold_count : '42' ?></h3>
        </div>
        <!-- Decorative Glow -->
        <div class="absolute -right-6 -bottom-6 w-20 h-20 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
    </div>

    <!-- Platinum Members Card -->
    <div class="bg-darkCard border border-slate-400/30 rounded-2xl p-5 shadow-xl relative overflow-hidden flex items-center gap-5">
        <div class="w-14 h-10 rounded-lg bg-gradient-to-tr from-slate-500 to-slate-200 flex items-center justify-center text-slate-900 shadow-md shadow-slate-300/20 shrink-0">
            <i class="fa-solid fa-credit-card text-lg"></i>
        </div>
        <div>
            <p class="text-xs font-semibold text-slate-300 tracking-wider uppercase">Platinum Card Members</p>
            <h3 class="text-3xl font-extrabold text-white mt-0.5"><?= isset($platinum_count) ? $platinum_count : '18' ?></h3>
        </div>
        <!-- Decorative Glow -->
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
        <span class="text-xs text-slate-400">Total upcoming: <strong class="text-slate-200">8 events</strong></span>
    </div>

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
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
                <?php
                // Default mock records matching wireframe (used if controller passes empty array)
                $records = isset($events) && !empty($events) ? $events : [
                    ['name' => 'John Doe',     'type' => 'Gold',     'event' => 'Birthday',    'date' => '12-Aug-2024'],
                    ['name' => 'Jane Smith',   'type' => 'Platinum', 'event' => 'Anniversary', 'date' => '25-Sep-2024'],
                    ['name' => 'Jane Smith',   'type' => 'Platinum', 'event' => 'Anniversary', 'date' => '16-Aug-2024'],
                    ['name' => 'Jamifer Doe',  'type' => 'Platinum', 'event' => 'Birthday',    'date' => '12-Sep-2024'],
                    ['name' => 'John Haim',    'type' => 'Gold',     'event' => 'Birthday',    'date' => '12-Sep-2024'],
                    ['name' => 'Joney Gratn',  'type' => 'Platinum', 'event' => 'Anniversary', 'date' => '15-Sep-2024'],
                    ['name' => 'Jane Smith',   'type' => 'Gold',     'event' => 'Anniversary', 'date' => '25-Sep-2024'],
                    ['name' => 'Janna Smith',  'type' => 'Platinum', 'event' => 'Anniversary', 'date' => '25-Sep-2024']
                ];

                foreach ($records as $row):
                ?>
                    <tr class="hover:bg-slate-800/40 transition">
                        <!-- Member Name -->
                        <td class="py-4 px-6 font-semibold text-white">
                            <div class="flex items-center gap-3">
                                <span class="w-8 h-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-slate-300">
                                    <?= strtoupper(substr($row['name'], 0, 1)) ?>
                                </span>
                                <span><?= htmlspecialchars($row['name']) ?></span>
                            </div>
                        </td>

                        <!-- Card Type Badge -->
                        <td class="py-4 px-6">
                            <?php if (strtolower($row['type']) === 'gold'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                    <i class="fa-solid fa-crown text-[10px] mr-1.5"></i> Gold
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-400/10 text-slate-300 border border-slate-400/30">
                                    <i class="fa-solid fa-gem text-[10px] mr-1.5"></i> Platinum
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
                            <?= htmlspecialchars($row['date']) ?>
                        </td>

                        <!-- Action Button -->
                        <td class="py-4 px-6 text-center">
                            <button type="button"
                                onclick="alert('Connecting with <?= addslashes($row['name']) ?>')"
                                class="bg-slate-800 hover:bg-blue-600 text-slate-300 hover:text-white border border-slate-700 hover:border-blue-500 text-xs font-semibold px-4 py-1.5 rounded-lg transition shadow-sm">
                                Connect
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Export Action Footer -->
    <div class="p-6 bg-[#0A1020] border-t border-darkBorder flex justify-center">
        <button type="button" onclick="window.print()" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs tracking-wider uppercase px-8 py-3 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-lg">
            <i class="fa-solid fa-file-arrow-down text-sm"></i> Export
        </button>
    </div>

</div>