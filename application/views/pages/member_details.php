<!-- Header Title & Back Navigation -->
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-regular fa-id-badge text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Profile Overview</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">Member Details</h2>
        </div>
    </div>
    <a href="<?= base_url('main/members_list') ?>" class="text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-lg hover:bg-slate-800 transition flex items-center gap-2">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Members
    </a>
</div>

<!-- Flash Message (Success / Error) -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-sm"></i>
        <span><?= $this->session->flashdata('success') ?></span>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-sm"></i>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- SECTION 1: Member Information Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-8 shadow-xl mb-8">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-darkBorder">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-user-check text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Member Information</h3>
        </div>

        <!-- Card Type Badge -->
        <?php
        $cType = strtolower($member['card_type'] ?? 'gold');
        if ($cType === 'gold'):
        ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                <i class="fa-solid fa-crown text-[10px] mr-1.5"></i> Gold Member
            </span>
        <?php elseif ($cType === 'platinum'): ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-400/15 text-slate-200 border border-slate-400/30">
                <i class="fa-solid fa-gem text-[10px] mr-1.5 text-sky-400"></i> Platinum Member
            </span>
        <?php else: ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-500/10 text-slate-300 border border-slate-500/20">
                <i class="fa-solid fa-id-card text-[10px] mr-1.5"></i> <?= htmlspecialchars($member['card_type']) ?> Member
            </span>
        <?php endif; ?>
    </div>

    <!-- 2-Column Key/Value Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Card No:</span>
            <span class="font-mono text-white font-semibold bg-[#0A1020] px-3 py-1 rounded-lg border border-darkBorder"><?= htmlspecialchars($member['card_number']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Card Type:</span>
            <span class="font-semibold text-slate-200"><?= htmlspecialchars($member['card_type']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">First Name:</span>
            <span class="font-semibold text-white"><?= htmlspecialchars($member['first_name']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Last Name:</span>
            <span class="font-semibold text-white"><?= htmlspecialchars($member['last_name']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Company Name:</span>
            <span class="font-medium text-slate-200"><?= !empty($member['company_name']) ? htmlspecialchars($member['company_name']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Designation:</span>
            <span class="font-medium text-slate-200"><?= !empty($member['designation']) ? htmlspecialchars($member['designation']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Contact No:</span>
            <span class="font-medium text-slate-200 font-mono"><?= !empty($member['contact_no']) ? htmlspecialchars($member['contact_no']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Email Id:</span>
            <span class="font-medium text-blue-400"><?= !empty($member['email']) ? htmlspecialchars($member['email']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Address:</span>
            <span class="font-medium text-slate-300 text-right"><?= !empty($member['address']) ? htmlspecialchars($member['address']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Anniversary:</span>
            <span class="font-mono text-slate-300"><?= (!empty($member['anniversary']) && $member['anniversary'] !== '0000-00-00') ? date('d-M-Y', strtotime($member['anniversary'])) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">DOB:</span>
            <span class="font-mono text-slate-300"><?= (!empty($member['dob']) && $member['dob'] !== '0000-00-00') ? date('d-M-Y', strtotime($member['dob'])) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Notes:</span>
            <span class="text-slate-400 text-xs italic"><?= !empty($member['notes']) ? htmlspecialchars($member['notes']) : 'None' ?></span>
        </div>

    </div>
</div>

<!-- SECTION 2: Visitor Details Table -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-clock-rotate-left text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Visitor Details</h3>
        </div>
        <div class="flex items-center gap-4 text-xs">
            <span class="text-slate-400">Total PAX: <strong class="text-slate-200"><?= isset($summary['total_pax']) ? $summary['total_pax'] : 0 ?></strong></span>
            <span class="text-slate-400">Total Visits: <strong class="text-white"><?= count($visits ?? []) ?></strong></span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/60 border-b border-darkBorder font-bold">
                <tr>
                    <th scope="col" class="py-3.5 px-6">Visit Date</th>
                    <th scope="col" class="py-3.5 px-6">No of Pax</th>
                    <th scope="col" class="py-3.5 px-6">APC (Average Per Cover)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder">
                <?php if (!empty($visits)): ?>
                    <?php foreach ($visits as $v): ?>
                        <?php
                        $v = (object)$v;
                        $rawDate = !empty($v->visit_date) ? $v->visit_date : (!empty($v->date) ? $v->date : '');
                        $formattedDate = (!empty($rawDate) && $rawDate !== '0000-00-00') ? date('d-M-Y', strtotime($rawDate)) : 'N/A';
                        $pax = isset($v->no_of_pax) ? $v->no_of_pax : (isset($v->pax) ? $v->pax : '0');
                        $apc = isset($v->apc) ? number_format((float)$v->apc, 2) : '0.00';
                        ?>
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-6 font-mono text-xs text-white">
                                <?= htmlspecialchars($formattedDate) ?>
                            </td>
                            <td class="py-3.5 px-6 font-medium text-slate-200">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-users text-slate-500 text-xs"></i>
                                    <?= htmlspecialchars($pax) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-emerald-400">
                                <?= htmlspecialchars($apc) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="py-8 text-center text-xs text-slate-500">
                            <i class="fa-solid fa-calendar-xmark text-xl mb-2 block"></i>
                            No visitor details recorded for this member yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Actions & Conditional Pagination Bar -->
    <div class="p-5 bg-[#0A1020] border-t border-darkBorder flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Open Modal Button -->
        <button type="button" id="openVisitModalBtn"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Add visit details
        </button>

        <!-- Pagination (Shown only if records exceed 10) -->
        <?php if (!empty($visits) && count($visits) > 10): ?>
            <nav class="flex items-center gap-2 text-xs text-slate-400">
                <span class="text-white font-bold px-2 py-0.5 rounded bg-blue-600">1</span>
                <span class="text-slate-500">Showing <?= count($visits) ?> records</span>
            </nav>
        <?php endif; ?>
    </div>
</div>

<!-- ======================================================= -->
<!-- MODAL: Add visit Details                                -->
<!-- ======================================================= -->
<div id="visitModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 transition-all">
    <div class="w-full max-w-md bg-darkCard border border-darkBorder rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-200" id="modalCard">

        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between">
            <h3 class="text-base font-bold text-white tracking-wide flex items-center gap-2">
                <i class="fa-solid fa-calendar-plus text-blue-400"></i> Add Visit Details
            </h3>
            <button type="button" id="closeModalCross" class="text-slate-400 hover:text-white text-lg focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form action="<?= base_url('main/add_visit') ?>" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="member_id" value="<?= $member['id'] ?>">

            <!-- Date -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Visit Date</label>
                <input type="date" name="visit_date" required value="<?= date('Y-m-d') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-pointer">
            </div>

            <!-- No of Pax (Max 25) -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">No of Pax</label>
                    <span class="text-[10px] text-slate-400">Limit: 1 to 25</span>
                </div>
                <input type="number" name="no_of_pax" required min="1" max="25" value="1" placeholder="1 - 25"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- APC -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">APC (Average Per Cover)</label>
                <input type="number" step="0.01" min="0" name="apc" required placeholder="0.00"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- Modal Action Buttons -->
            <div class="pt-4 border-t border-darkBorder flex items-center justify-end gap-3">
                <button type="button" id="closeModalBtn"
                    class="bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-semibold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-darkBorder transition">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20 transition">
                    Save Visit
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Modal Open / Close Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('visitModal');
        const modalCard = document.getElementById('modalCard');
        const openBtn = document.getElementById('openVisitModalBtn');
        const closeCross = document.getElementById('closeModalCross');
        const closeBtn = document.getElementById('closeModalBtn');

        function openModal() {
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalCard.classList.remove('scale-95');
                modalCard.classList.add('scale-100');
            }, 10);
        }

        function closeModal() {
            modalCard.classList.remove('scale-100');
            modalCard.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 150);
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeCross) closeCross.addEventListener('click', closeModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);

        // Close when clicking the backdrop outside the card
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    });
</script>