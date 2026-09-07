<?php
// Fallback sample data if DB returns empty
$m = isset($member) && !empty($member) ? (object)$member : (object)[
    'id'           => 1,
    'card_number'  => '1234-5678-9012',
    'card_type'    => 'Platinum',
    'first_name'   => 'John',
    'last_name'    => 'Smith',
    'company_name' => 'TechCorp Inc.',
    'designation'  => 'Senior Engineer',
    'contact_no'   => '+1-555-0199',
    'email'        => 'john.smith@techcorp.com',
    'address'      => '123 Main St, Anytown, CA',
    'anniversary'  => '20-Oct-2010',
    'dob'          => '15-May-1985',
    'notes'        => 'Special handling for large parties'
];

$visit_records = isset($visits) && !empty($visits) ? $visits : [
    ['date' => '01-Feb-2024', 'pax' => 4, 'apc' => '25.50'],
    ['date' => '15-Mar-2024', 'pax' => 2, 'apc' => '30.10'],
    ['date' => '10-Apr-2024', 'pax' => 6, 'apc' => '22.80'],
    ['date' => '05-May-2024', 'pax' => 3, 'apc' => '28.90'],
];
?>

<!-- Page Header -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-id-card-clip text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Profile Overview</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">View Member Details</h2>
            <p class="text-xs text-slate-400">Complete membership record and visit history logs.</p>
        </div>
    </div>
    <a href="<?= base_url('main/members_list') ?>" class="text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-lg hover:bg-slate-800 transition flex items-center gap-2">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Members
    </a>
</div>

<!-- SECTION 1: Member Information Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-7 shadow-xl mb-8 max-w-5xl mx-auto">
    <div class="flex items-center justify-between pb-4 border-b border-darkBorder mb-6">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
            <i class="fa-regular fa-user text-blue-400"></i> Member Information
        </h3>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-400/10 text-slate-300 border border-slate-400/30">
            <i class="fa-solid fa-gem text-[10px] mr-1.5 text-blue-400"></i> <?= htmlspecialchars($m->card_type) ?>
        </span>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 text-sm">

        <!-- Row 1 -->
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Card No:</span>
            <span class="font-mono text-white font-semibold">[<?= htmlspecialchars($m->card_number) ?>]</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Card Type:</span>
            <span class="text-white font-medium">[<?= htmlspecialchars($m->card_type) ?>]</span>
        </div>

        <!-- Row 2 -->
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">First Name:</span>
            <span class="text-white font-medium">[<?= htmlspecialchars($m->first_name) ?>]</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Last Name:</span>
            <span class="text-white font-medium">[<?= htmlspecialchars($m->last_name) ?>]</span>
        </div>

        <!-- Row 3 -->
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Company Name:</span>
            <span class="text-white font-medium">[<?= htmlspecialchars($m->company_name) ?>]</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Designation:</span>
            <span class="text-white font-medium">[<?= htmlspecialchars($m->designation) ?>]</span>
        </div>

        <!-- Row 4 -->
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Contact No:</span>
            <span class="text-white font-medium font-mono">[<?= htmlspecialchars($m->contact_no) ?>]</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Email Id:</span>
            <span class="text-white font-medium">[<?= htmlspecialchars($m->email) ?>]</span>
        </div>

        <!-- Row 5 -->
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Address:</span>
            <span class="text-white font-medium text-right">[<?= htmlspecialchars($m->address) ?>]</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Anniversary:</span>
            <span class="text-white font-medium font-mono">[<?= htmlspecialchars($m->anniversary) ?>]</span>
        </div>

        <!-- Row 6 -->
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">DOB:</span>
            <span class="text-white font-medium font-mono">[<?= htmlspecialchars($m->dob) ?>]</span>
        </div>
        <div class="flex justify-between py-1.5 border-b border-darkBorder/40">
            <span class="text-xs font-semibold text-slate-400 uppercase">Notes:</span>
            <span class="text-amber-300 font-medium text-right">[<?= htmlspecialchars($m->notes) ?>]</span>
        </div>

    </div>
</div>

<!-- SECTION 2: Visitor Details Card & Table -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden max-w-5xl mx-auto">

    <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between">
        <h3 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
            <i class="fa-solid fa-clock-rotate-left text-blue-400"></i> Visitor Details
        </h3>
        <span class="text-xs text-slate-400">Recent Member Visits</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/60 border-b border-darkBorder font-semibold">
                <tr>
                    <th scope="col" class="py-3.5 px-6">Date</th>
                    <th scope="col" class="py-3.5 px-6">No of Pax</th>
                    <th scope="col" class="py-3.5 px-6">APC</th>
                    <th scope="col" class="py-3.5 px-6 text-center w-28">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder">
                <?php foreach ($visit_records as $v): ?>
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="py-3.5 px-6 font-mono text-xs text-white">
                            [<?= htmlspecialchars($v['date']) ?>]
                        </td>
                        <td class="py-3.5 px-6 font-medium text-slate-200">
                            [<?= htmlspecialchars($v['pax']) ?>]
                        </td>
                        <td class="py-3.5 px-6 font-mono text-emerald-400">
                            $[<?= htmlspecialchars($v['apc']) ?>]
                        </td>
                        <td class="py-3.5 px-6 text-center">
                            <button type="button" onclick="alert('Viewing visit details for <?= $v['date'] ?>')"
                                class="inline-flex items-center gap-1.5 bg-[#0A1020] hover:bg-blue-600 text-slate-300 hover:text-white border border-darkBorder hover:border-blue-500 text-xs font-medium px-3 py-1 rounded-lg transition shadow-sm">
                                <i class="fa-regular fa-eye text-[11px]"></i>
                                <span>View</span>
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Table Footer Bar with Pagination -->
    <div class="px-6 py-3 border-t border-darkBorder bg-[#0A1020] flex items-center justify-end">
        <nav class="inline-flex items-center gap-2 text-xs text-slate-400 select-none">
            <span class="text-white font-bold px-2 py-0.5 rounded bg-blue-600">1</span>
            <a href="#" class="hover:text-white transition px-1">2</a>
            <a href="#" class="hover:text-white transition px-1">3</a>
            <span class="text-slate-600">...</span>
            <a href="#" class="hover:text-white transition px-1">10</a>
            <a href="#" class="hover:text-white transition ml-1">Next &rarr;</a>
        </nav>
    </div>

    <!-- Add Visit Details Button Bar -->
    <div class="p-5 border-t border-darkBorder bg-darkCard flex justify-center">
        <button type="button" id="openVisitModalBtn"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-7 py-3 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Add visit details
        </button>
    </div>

</div>

<!-- SECTION 3: Add Visit Details Modal -->
<div id="visitModal" class="fixed inset-0 z-50 hidden bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-darkCard border border-darkBorder rounded-2xl w-full max-w-md shadow-2xl overflow-hidden transform transition-all">

        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-darkBorder flex items-center justify-between bg-[#0A1020]">
            <h3 class="text-base font-bold text-white tracking-wide flex items-center gap-2">
                <i class="fa-regular fa-calendar-plus text-blue-400"></i> Add visit Details
            </h3>
            <button type="button" id="closeVisitModalBtn" class="text-slate-400 hover:text-white transition text-lg focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form Body -->
        <form action="<?= base_url('main/add_visit') ?>" method="POST" class="p-6 space-y-5">
            <input type="hidden" name="member_id" value="<?= htmlspecialchars($m->id) ?>">

            <!-- Date -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Date</label>
                <div class="relative">
                    <input type="date" name="visit_date" required
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 cursor-pointer">
                </div>
            </div>

            <!-- No of Pax -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">No of Pax</label>
                <input type="number" name="no_of_pax" min="1" value="1" required
                    placeholder="[1]"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500">
            </div>

            <!-- APC (Average per Cover / Spend) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">APC (Average Cost)</label>
                <input type="number" step="0.01" name="apc" required
                    placeholder="Enter Amount (e.g. 25.50)"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 font-mono">
            </div>

            <!-- Modal Action Buttons (Add / Cancel) -->
            <div class="pt-4 border-t border-darkBorder flex items-center justify-end gap-3">
                <button type="button" id="cancelVisitModalBtn"
                    class="bg-transparent hover:bg-slate-800 text-slate-300 font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-darkBorder transition">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20">
                    Add
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Modal Toggle Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('visitModal');
        const openBtn = document.getElementById('openVisitModalBtn');
        const closeBtn = document.getElementById('closeVisitModalBtn');
        const cancelBtn = document.getElementById('cancelVisitModalBtn');

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        if (openBtn) openBtn.addEventListener('click', openModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        if (cancelBtn) cancelBtn.addEventListener('click', closeModal);

        // Close on clicking backdrop
        window.addEventListener('click', function(e) {
            if (e.target === modal) {
                closeModal();
            }
        });
    });
</script>