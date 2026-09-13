<?php
// Role and permission determinations
$user_role  = strtolower(trim((string)$this->session->userdata('access')));
$is_admin   = ($user_role === 'admin');
$is_editor  = ($user_role === 'editor');
$is_viewer  = ($user_role === 'viewer');

$can_edit   = ($is_admin || $is_editor);
$can_delete = $is_admin;
?>

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

<!-- Flash Alerts -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-sm shrink-0"></i>
        <span><?= $this->session->flashdata('success') ?></span>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-sm shrink-0"></i>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
<?php endif; ?>

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

        <!-- Membership Type (Only Gold & Platinum) -->
        <div class="xl:col-span-2">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Card Type</label>
            <div class="relative">
                <select name="type" class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
                    <option value="">All Types</option>
                    <option value="Gold" <?= ($this->input->get('type') === 'Gold') ? 'selected' : '' ?>>Gold</option>
                    <option value="Platinum" <?= ($this->input->get('type') === 'Platinum') ? 'selected' : '' ?>>Platinum</option>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-chevron-down text-[10px]"></i>
                </div>
            </div>
        </div>

        <!-- DOB Range (Month & Day Only: MM-DD) -->
        <div class="xl:col-span-3">
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">DOB Range</label>
                <span class="text-[10px] text-slate-400 font-mono">MM-DD</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <input type="text" name="dob_from" placeholder="From 01-15" maxlength="5"
                    value="<?= htmlspecialchars($this->input->get('dob_from') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition font-mono">
                <input type="text" name="dob_to" placeholder="To 12-31" maxlength="5"
                    value="<?= htmlspecialchars($this->input->get('dob_to') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition font-mono">
            </div>
        </div>

        <!-- Anniversary Range (Month & Day Only: MM-DD) -->
        <div class="xl:col-span-3">
            <div class="flex items-center justify-between mb-2">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Anniversary Range</label>
                <span class="text-[10px] text-slate-400 font-mono">MM-DD</span>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <input type="text" name="anniv_from" placeholder="From 01-15" maxlength="5"
                    value="<?= htmlspecialchars($this->input->get('anniv_from') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition font-mono">
                <input type="text" name="anniv_to" placeholder="To 12-31" maxlength="5"
                    value="<?= htmlspecialchars($this->input->get('anniv_to') ?? '') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition font-mono">
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
<form id="membersBatchForm" action="<?= base_url('main/delete_members') ?>" method="POST">
    <div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden">

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="text-[11px] uppercase tracking-wider text-slate-400 bg-[#0A1020] border-b border-darkBorder font-bold">
                    <tr>
                        <!-- Select All Checkbox (Admin & Editor only) -->
                        <?php if ($can_edit || $can_delete): ?>
                            <th scope="col" class="py-3.5 px-4 w-12 text-center">
                                <input type="checkbox" id="selectAllMembersCheckbox"
                                    class="w-4 h-4 rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                            </th>
                        <?php endif; ?>

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
                            <td colspan="<?= ($can_edit || $can_delete) ? 8 : 7 ?>" class="py-12 text-center text-slate-500">
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
                            <tr class="member-row hover:bg-slate-800/40 transition">
                                <!-- Checkbox (Admin & Editor only) -->
                                <?php if ($can_edit || $can_delete): ?>
                                    <td class="py-3.5 px-4 text-center">
                                        <input type="checkbox" name="selected_members[]" value="<?= $row['id'] ?>"
                                            class="member-checkbox w-4 h-4 rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                                    </td>
                                <?php endif; ?>

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

                                <!-- Type Badge (Gold / Platinum only) -->
                                <td class="py-3.5 px-6">
                                    <?php if (strtolower($row['card_type']) === 'gold'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                                            <i class="fa-solid fa-crown text-[10px] mr-1"></i> Gold
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-400/10 text-slate-300 border border-slate-400/30">
                                            <i class="fa-solid fa-gem text-[10px] mr-1"></i> Platinum
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

                                <!-- Action: View Button -->
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

        <!-- Pagination Bar (Default: 10 rows per page) -->
        <?php if (isset($total_pages) && $total_pages > 1): ?>
            <?php
            $queryParams = $_GET;
            unset($queryParams['page']);
            $baseQuery = http_build_query($queryParams);
            $queryPrefix = !empty($baseQuery) ? '?' . $baseQuery . '&page=' : '?page=';
            ?>
            <div class="px-6 py-4 border-t border-darkBorder bg-[#0A1020] flex items-center justify-between">
                <span class="text-xs text-slate-500">
                    Showing page <strong class="text-slate-300"><?= $current_page ?></strong> of <strong class="text-slate-300"><?= $total_pages ?></strong> (10 records/page)
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

        <!-- SECTION 3: Bottom Actions Bar -->
        <div class="p-5 border-t border-darkBorder bg-darkCard flex flex-wrap items-center justify-between gap-4">

            <!-- Left: Management Action Buttons -->
            <div class="flex items-center gap-2.5">
                <?php if (!$is_viewer): ?>
                    <!-- Add Member -->
                    <a href="<?= base_url('main/add_member') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                        <i class="fa-solid fa-plus text-xs"></i> Add
                    </a>

                    <!-- Edit Button -->
                    <button type="button" id="editMembersBtn"
                        class="bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-sm">
                        <i class="fa-regular fa-pen-to-square text-xs"></i> Edit
                    </button>
                <?php endif; ?>

                <?php if ($can_delete): ?>
                    <!-- Remove Selected (Admin Only) -->
                    <button type="button" id="deleteMembersBtn"
                        class="bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-red-500/30 transition flex items-center gap-2 shadow-sm">
                        <i class="fa-regular fa-trash-can text-xs"></i> Remove
                    </button>
                <?php endif; ?>

                <?php if ($is_viewer): ?>
                    <span class="inline-flex items-center text-xs text-slate-500 italic">
                        <i class="fa-solid fa-lock text-[10px] mr-1.5"></i> Read-only access enabled
                    </span>
                <?php endif; ?>
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
</form>

<!-- ======================================================= -->
<!-- MODAL: Bulk Edit Members (Only Gold & Platinum)         -->
<!-- ======================================================= -->
<?php if ($can_edit): ?>
    <div id="bulkEditModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 transition-all">
        <div class="w-full max-w-lg bg-darkCard border border-darkBorder rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-200" id="bulkModalCard">

            <!-- Header -->
            <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-white tracking-wide flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-blue-400"></i> Bulk Edit Members
                    </h3>
                    <p class="text-xs text-slate-400 mt-0.5" id="bulkModalSubtitle">Updating selected members simultaneously</p>
                </div>
                <button type="button" id="closeBulkModalCross" class="text-slate-400 hover:text-white text-lg focus:outline-none">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Form -->
            <form action="<?= base_url('main/bulk_update_members') ?>" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="bulk_member_ids" id="bulk_member_ids">

                <!-- Field 1: Card Type (Gold / Platinum only) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Card Type</label>
                    <div class="relative">
                        <select name="bulk_card_type"
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
                            <option value="">-- Keep Existing Card Types --</option>
                            <option value="Gold">Gold</option>
                            <option value="Platinum">Platinum</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Field 2: Company Name -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Company Name</label>
                        <label class="inline-flex items-center gap-1 text-[11px] text-blue-400 cursor-pointer">
                            <input type="checkbox" name="apply_company" value="1" id="apply_company" class="rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-0 text-xs">
                            <span>Apply Change</span>
                        </label>
                    </div>
                    <input type="text" name="bulk_company_name" placeholder="Enter new company or leave empty"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
                </div>

                <!-- Field 3: Designation -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Designation</label>
                        <label class="inline-flex items-center gap-1 text-[11px] text-blue-400 cursor-pointer">
                            <input type="checkbox" name="apply_designation" value="1" id="apply_designation" class="rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-0 text-xs">
                            <span>Apply Change</span>
                        </label>
                    </div>
                    <input type="text" name="bulk_designation" placeholder="Enter new designation or leave empty"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
                </div>

                <!-- Field 4: Marital Status -->
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Marital Status</label>
                    <div class="relative">
                        <select name="bulk_marital_status"
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
                            <option value="">-- Keep Existing Status --</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <!-- Field 5: Notes -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">Notes / Remarks</label>
                        <label class="inline-flex items-center gap-1 text-[11px] text-blue-400 cursor-pointer">
                            <input type="checkbox" name="apply_notes" value="1" id="apply_notes" class="rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-0 text-xs">
                            <span>Apply Change</span>
                        </label>
                    </div>
                    <textarea name="bulk_notes" rows="2" placeholder="Overwrite remarks for selected members"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition"></textarea>
                </div>

                <!-- Modal Action Buttons -->
                <div class="pt-4 border-t border-darkBorder flex items-center justify-end gap-3">
                    <button type="button" id="closeBulkModalBtn"
                        class="bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-semibold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-darkBorder transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20 transition">
                        Update Selected
                    </button>
                </div>
            </form>

        </div>
    </div>
<?php endif; ?>

<!-- Checkbox Selection, Single Edit, Bulk Edit, & Delete Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllMembersCheckbox');
        const rowCheckboxes = document.querySelectorAll('.member-checkbox');
        const batchForm = document.getElementById('membersBatchForm');
        const editBtn = document.getElementById('editMembersBtn');
        const deleteBtn = document.getElementById('deleteMembersBtn');

        const bulkModal = document.getElementById('bulkEditModal');
        const bulkCard = document.getElementById('bulkModalCard');
        const closeCross = document.getElementById('closeBulkModalCross');
        const closeBtn = document.getElementById('closeBulkModalBtn');
        const bulkIdsInput = document.getElementById('bulk_member_ids');
        const bulkSubtitle = document.getElementById('bulkModalSubtitle');

        function openBulkModal(ids) {
            if (!bulkModal) return;
            bulkIdsInput.value = ids.join(',');
            if (bulkSubtitle) {
                bulkSubtitle.textContent = `Updating ${ids.length} selected member record(s)`;
            }
            bulkModal.classList.remove('hidden');
            setTimeout(() => {
                bulkCard.classList.remove('scale-95');
                bulkCard.classList.add('scale-100');
            }, 10);
        }

        function closeBulkModal() {
            if (!bulkModal) return;
            bulkCard.classList.remove('scale-100');
            bulkCard.classList.add('scale-95');
            setTimeout(() => {
                bulkModal.classList.add('hidden');
            }, 150);
        }

        if (closeCross) closeCross.addEventListener('click', closeBulkModal);
        if (closeBtn) closeBtn.addEventListener('click', closeBulkModal);
        if (bulkModal) {
            bulkModal.addEventListener('click', function(e) {
                if (e.target === bulkModal) closeBulkModal();
            });
        }

        // Master select / unselect all
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                    toggleRowHighlight(cb);
                });
            });
        }

        // Row checkbox toggle
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                toggleRowHighlight(this);
                if (!this.checked && selectAll) {
                    selectAll.checked = false;
                }
            });
        });

        function toggleRowHighlight(checkbox) {
            const row = checkbox.closest('tr');
            if (checkbox.checked) {
                row.classList.add('bg-blue-600/10');
            } else {
                row.classList.remove('bg-blue-600/10');
            }
        }

        // Edit button click logic:
        // 1 selected -> Navigates to full single member edit screen
        // >1 selected -> Opens the Bulk Edit Modal
        if (editBtn) {
            editBtn.addEventListener('click', function() {
                const checked = document.querySelectorAll('.member-checkbox:checked');
                if (checked.length === 0) {
                    alert('Please select at least one member to edit.');
                    return;
                }

                if (checked.length === 1) {
                    const singleId = checked[0].value;
                    window.location.href = '<?= base_url("main/add_member/") ?>' + singleId;
                } else {
                    const ids = Array.from(checked).map(cb => cb.value);
                    openBulkModal(ids);
                }
            });
        }

        // Delete button click logic (Admin Only)
        if (deleteBtn) {
            deleteBtn.addEventListener('click', function() {
                const checked = document.querySelectorAll('.member-checkbox:checked');
                if (checked.length === 0) {
                    alert('Please select at least one member to delete.');
                    return;
                }

                if (confirm(`Are you sure you want to delete ${checked.length} selected member(s)? This will also remove their visit logs.`)) {
                    batchForm.submit();
                }
            });
        }
    });
</script>