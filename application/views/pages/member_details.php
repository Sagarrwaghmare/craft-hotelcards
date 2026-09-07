<!-- Header Title & Back Navigation -->
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-regular fa-id-badge text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Profile Overview</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">View Member Details</h2>
        </div>
    </div>
    <a href="<?= base_url('main/members_list') ?>" class="text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-lg hover:bg-slate-800 transition flex items-center gap-2">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Members
    </a>
</div>

<!-- SECTION 1: Member Information Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-8 shadow-xl mb-8">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-darkBorder">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-user-check text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Member Information</h3>
        </div>
        <!-- Card Type Badge -->
        <?php if (strtolower($member['card_type']) === 'gold'): ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                <i class="fa-solid fa-crown text-[10px] mr-1.5"></i> Gold Member
            </span>
        <?php else: ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-400/15 text-slate-200 border border-slate-400/30">
                <i class="fa-solid fa-gem text-[10px] mr-1.5 text-sky-400"></i> Platinum Member
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
            <span class="font-medium text-slate-200"><?= htmlspecialchars($member['company_name']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Designation:</span>
            <span class="font-medium text-slate-200"><?= htmlspecialchars($member['designation']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Contact No:</span>
            <span class="font-medium text-slate-200 font-mono"><?= htmlspecialchars($member['contact_no']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Email Id:</span>
            <span class="font-medium text-blue-400"><?= htmlspecialchars($member['email']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Address:</span>
            <span class="font-medium text-slate-300 text-right"><?= htmlspecialchars($member['address']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Anniversary:</span>
            <span class="font-mono text-slate-300"><?= !empty($member['anniversary']) ? htmlspecialchars($member['anniversary']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">DOB:</span>
            <span class="font-mono text-slate-300"><?= htmlspecialchars($member['dob']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Notes:</span>
            <span class="text-slate-400 text-xs italic"><?= htmlspecialchars($member['notes']) ?></span>
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
        <span class="text-xs text-slate-400">Total Visits: <strong class="text-white"><?= count($visits) ?></strong></span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/60 border-b border-darkBorder font-bold">
                <tr>
                    <th scope="col" class="py-3.5 px-6">Date</th>
                    <th scope="col" class="py-3.5 px-6">No of Pax</th>
                    <th scope="col" class="py-3.5 px-6">APC</th>
                    <th scope="col" class="py-3.5 px-6 text-center w-28">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder">
                <?php if (!empty($visits)): ?>
                    <?php foreach ($visits as $v): ?>
                        <?php
                        // Safely convert to object (handles both array and DB object)
                        $v = (object)$v;

                        // Handles both column names: 'visit_date' or 'date'
                        $date = !empty($v->visit_date) ? $v->visit_date : (!empty($v->date) ? $v->date : 'N/A');

                        // Handles both column names: 'no_of_pax' or 'pax'
                        $pax = isset($v->no_of_pax) ? $v->no_of_pax : (isset($v->pax) ? $v->pax : '0');

                        // Handles 'apc'
                        $apc = isset($v->apc) ? $v->apc : '0.00';
                        ?>
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-6 font-mono text-xs text-white">
                                [<?= htmlspecialchars($date) ?>]
                            </td>
                            <td class="py-3.5 px-6 font-medium text-slate-200">
                                [<?= htmlspecialchars($pax) ?>]
                            </td>
                            <td class="py-3.5 px-6 font-mono text-emerald-400">
                                $[<?= htmlspecialchars($apc) ?>]
                            </td>
                            <td class="py-3.5 px-6 text-center">
                                <button type="button"
                                    class="inline-flex items-center gap-1.5 bg-[#0A1020] hover:bg-blue-600 text-slate-300 hover:text-white border border-darkBorder hover:border-blue-500 text-xs font-medium px-3 py-1 rounded-lg transition shadow-sm">
                                    <i class="fa-regular fa-eye text-[11px]"></i>
                                    <span>View</span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="py-6 text-center text-xs text-slate-500">
                            No visitor details recorded for this member yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination & Modal Trigger -->
    <div class="p-5 bg-[#0A1020] border-t border-darkBorder flex flex-col sm:flex-row items-center justify-between gap-4">
        <!-- Open Modal Button -->
        <button type="button" id="openVisitModalBtn"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Add visit details
        </button>

        <!-- Pagination -->
        <nav class="flex items-center gap-2 text-xs text-slate-400">
            <span class="text-white font-bold px-2 py-0.5 rounded bg-blue-600">1</span>
            <a href="#" class="hover:text-white transition px-1">2</a>
            <a href="#" class="hover:text-white transition px-1">3</a>
            <span class="text-slate-600">...</span>
            <a href="#" class="hover:text-white transition px-1">10</a>
            <a href="#" class="hover:text-white transition">Next</a>
        </nav>
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
                <i class="fa-solid fa-calendar-plus text-blue-400"></i> Add visit Details
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
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Date</label>
                <div class="relative">
                    <input type="date" name="visit_date" required
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-pointer">
                </div>
            </div>

            <!-- No of Pax -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">No of Pax</label>
                <input type="number" name="pax" required min="1" value="1" placeholder="1"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- APC -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">APC (Average Per Cover)</label>
                <input type="text" name="apc" required placeholder="Enter Amount (e.g. 25.50)"
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
                    Add
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

        // Close on clicking the backdrop outside the card
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    });
</script>