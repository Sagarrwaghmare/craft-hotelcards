<!-- Header Title -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-users text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Directory</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">Members</h2>
            <p class="text-xs text-slate-400">Search, filter, and manage all registered members.</p>
        </div>
    </div>

    <!-- Quick Count Badge -->
    <div class="flex items-center gap-2 bg-darkCard border border-darkBorder px-4 py-2 rounded-xl text-xs text-slate-300 self-start sm:self-auto">
        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
        Total Records: <strong class="text-white font-bold"><?= isset($total_count) ? $total_count : 0 ?></strong>
    </div>
</div>

<!-- SECTION 1: Advanced Filter Bar Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-5 mb-6 shadow-xl">
    <form action="<?= base_url('main/members_list') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-4 items-end">

        <!-- Field Name / Search -->
        <div class="xl:col-span-3">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Member Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" placeholder="Name, Card No, Phone..."
                    value="<?= htmlspecialchars($this->input->get('search') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-9 pr-3 py-2 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
            </div>
        </div>

        <!-- Membership Type (Matches DB enum: Gold, Platinum, Silver) -->
        <div class="xl:col-span-2">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Type</label>
            <div class="relative">
                <select name="type" class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
                    <option value="">All Types</option>
                    <option value="Gold" <?= ($this->input->get('type') === 'Gold') ? 'selected' : '' ?>>Gold</option>
                    <option value="Platinum" <?= ($this->input->get('type') === 'Platinum') ? 'selected' : '' ?>>Platinum</option>
                    <option value="Silver" <?= ($this->input->get('type') === 'Silver') ? 'selected' : '' ?>>Silver</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>
        </div>

        <!-- DOB Range (From - To) -->
        <div class="xl:col-span-3">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">DOB Range</label>
            <div class="grid grid-cols-2 gap-2">
                <input type="date" name="dob_from" title="From DOB"
                    value="<?= htmlspecialchars($this->input->get('dob_from') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
                <input type="date" name="dob_to" title="To DOB"
                    value="<?= htmlspecialchars($this->input->get('dob_to') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
            </div>
        </div>

        <!-- Anniversary Range (From - To) -->
        <div class="xl:col-span-3">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Anniversary Range</label>
            <div class="grid grid-cols-2 gap-2">
                <input type="date" name="anniv_from" title="From Anniversary"
                    value="<?= htmlspecialchars($this->input->get('anniv_from') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
                <input type="date" name="anniv_to" title="To Anniversary"
                    value="<?= htmlspecialchars($this->input->get('anniv_to') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
            </div>
        </div>

        <!-- Action Buttons (Filter & Clear) -->
        <div class="xl:col-span-1 flex items-center gap-1.5">
            <button type="submit" title="Apply Filter" class="flex-1 bg-slate-800 hover:bg-blue-600 text-slate-200 hover:text-white font-semibold text-xs py-2 px-2.5 rounded-xl border border-darkBorder hover:border-blue-500 transition flex items-center justify-center gap-1 shadow-md">
                <i class="fa-solid fa-filter text-[10px]"></i>
                <span>Filter</span>
            </button>
            <?php if (!empty(array_filter($this->input->get() ?? []))): ?>
                <a href="<?= base_url('main/members_list') ?>" title="Reset Filters" class="bg-red-500/10 hover:bg-red-500/20 text-red-400 border border-red-500/30 p-2 rounded-xl transition text-xs flex items-center justify-center">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            <?php endif; ?>
        </div>

    </form>
</div>

<!-- SECTION 2: Members Directory Table Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden">

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 bg-[#0A1020] border-b border-darkBorder font-bold">
                <tr>
                    <th scope="col" class="py-3.5 px-5 w-16 text-center">Sr.No</th>
                    <th scope="col" class="py-3.5 px-6">Card No</th>
                    <th scope="col" class="py-3.5 px-6">Name</th>
                    <th scope="col" class="py-3.5 px-6">Type</th>
                    <th scope="col" class="py-3.5 px-6">DOB</th>
                    <th scope="col" class="py-3.5 px-6">Anniversary</th>
                    <th scope="col" class="py-3.5 px-6 text-center w-28">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder font-normal">
                <?php if (empty($members)): ?>
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-500">
                            <i class="fa-solid fa-users-slash text-3xl mb-2 block"></i>
                            No members found matching your search and filter criteria.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php
                    $sr_offset = isset($current_page) && isset($per_page) ? ($current_page - 1) * $per_page : 0;
                    foreach ($members as $index => $row):
                        $full_name = trim($row['first_name'] . ' ' . $row['last_name']);
                        $dob_formatted = (!empty($row['dob']) && $row['dob'] !== '0000-00-00') ? date('d-M-Y', strtotime($row['dob'])) : '-';
                        $anni_formatted = (!empty($row['anniversary']) && $row['anniversary'] !== '0000-00-00') ? date('d-M-Y', strtotime($row['anniversary'])) : '-';
                    ?>
                        <tr class="hover:bg-slate-800/40 transition">
                            <!-- Sr.No -->
                            <td class="py-3.5 px-5 text-center font-mono text-xs text-slate-500">
                                <?= $sr_offset + $index + 1 ?>
                            </td>

                            <!-- Card Number -->
                            <td class="py-3.5 px-6 font-mono text-xs text-blue-400 font-semibold">
                                <?= htmlspecialchars($row['card_number']) ?>
                            </td>

                            <!-- Member Name & Contact -->
                            <td class="py-3.5 px-6 font-semibold text-white">
                                <div><?= htmlspecialchars($full_name) ?></div>
                                <?php if (!empty($row['contact_no'])): ?>
                                    <span class="text-[11px] font-normal text-slate-400 font-mono"><?= htmlspecialchars($row['contact_no']) ?></span>
                                <?php endif; ?>
                            </td>

                            <!-- Type Badge -->
                            <td class="py-3.5 px-6">
                                <?php if (strtolower($row['card_type']) === 'gold'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                        <i class="fa-solid fa-crown text-[10px] mr-1"></i> Gold
                                    </span>
                                <?php elseif (strtolower($row['card_type']) === 'platinum'): ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-400/10 text-slate-300 border border-slate-400/30">
                                        <i class="fa-solid fa-gem text-[10px] mr-1"></i> Platinum
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-500/10 text-slate-300 border border-slate-500/20">
                                        <?= htmlspecialchars($row['card_type']) ?>
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- DOB -->
                            <td class="py-3.5 px-6 font-mono text-xs text-slate-300">
                                <?= $dob_formatted ?>
                            </td>

                            <!-- Anniversary -->
                            <td class="py-3.5 px-6 font-mono text-xs text-slate-300">
                                <?= $anni_formatted ?>
                            </td>

                            <!-- Action: View Button (Navigates to individual member_details) -->
                            <td class="py-3.5 px-6 text-center">
                                <a href="<?= base_url('main/member_details/' . $row['id']) ?>"
                                    class="inline-flex items-center gap-1.5 bg-[#0A1020] hover:bg-blue-600 text-slate-300 hover:text-white border border-darkBorder hover:border-blue-500 text-xs font-medium px-3 py-1.5 rounded-lg transition shadow-sm">
                                    <i class="fa-regular fa-eye text-[11px]"></i>
                                    <span>View</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Bar -->
    <?php if (isset($total_pages) && $total_pages > 1): ?>
        <?php
        $queryParams = $_GET;
        unset($queryParams['page']);
        $baseQuery = http_build_query($queryParams);
        $queryPrefix = !empty($baseQuery) ? '?' . $baseQuery . '&page=' : '?page=';
        ?>
        <div class="px-6 py-4 border-t border-darkBorder bg-[#0A1020] flex items-center justify-between">
            <span class="text-xs text-slate-500">
                Showing page <strong class="text-slate-300"><?= $current_page ?></strong> of <strong class="text-slate-300"><?= $total_pages ?></strong>
            </span>

            <nav class="flex items-center gap-1 text-xs font-medium">
                <?php if ($current_page > 1): ?>
                    <a href="<?= base_url('main/members_list' . $queryPrefix . ($current_page - 1)) ?>"
                        class="px-3 py-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">&larr; Prev</a>
                <?php endif; ?>

                <?php
                $start = max(1, $current_page - 2);
                $end = min($total_pages, $current_page + 2);
                for ($p = $start; $p <= $end; $p++):
                ?>
                    <?php if ($p == $current_page): ?>
                        <span class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold"><?= $p ?></span>
                    <?php else: ?>
                        <a href="<?= base_url('main/members_list' . $queryPrefix . $p) ?>"
                            class="px-3 py-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($current_page < $total_pages): ?>
                    <a href="<?= base_url('main/members_list' . $queryPrefix . ($current_page + 1)) ?>"
                        class="px-3 py-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">Next &rarr;</a>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>

    <!-- SECTION 3: Bottom Actions Bar (Add, Edit Disabled, Remove Disabled, Export CSV) -->
    <div class="p-5 border-t border-darkBorder bg-darkCard flex flex-wrap items-center justify-between gap-4">

        <!-- Left: Management Action Buttons -->
        <div class="flex items-center gap-2.5">
            <!-- Add Member -->
            <a href="<?= base_url('main/add_member') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Add
            </a>

            <!-- Edit Selected (Disabled) -->
            <button type="button" disabled
                title="Edit action currently disabled"
                class="bg-slate-800/40 text-slate-500 font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2 cursor-not-allowed opacity-50 select-none">
                <i class="fa-regular fa-pen-to-square text-xs"></i> Edit
            </button>

            <!-- Remove Selected (Disabled) -->
            <button type="button" disabled
                title="Remove action currently disabled"
                class="bg-red-500/5 text-red-400/40 font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-red-500/10 transition flex items-center gap-2 cursor-not-allowed opacity-50 select-none">
                <i class="fa-regular fa-trash-can text-xs"></i> Remove
            </button>
        </div>

        <!-- Right: Export CSV Button -->
        <div>
            <?php
            $exportQuery = !empty($_GET) ? '?' . http_build_query($_GET) : '';
            ?>
            <a href="<?= base_url('main/export_members_csv' . $exportQuery) ?>"
                class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-file-arrow-down text-sm text-emerald-400"></i>
                <span>Export CSV</span>
            </a>
        </div>

    </div>

</div>