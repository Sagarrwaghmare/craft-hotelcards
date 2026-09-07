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
        Total Records: <strong class="text-white font-bold">142</strong>
    </div>
</div>

<!-- SECTION 1: Advanced Filter Bar Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-5 mb-6 shadow-xl">
    <form action="<?= base_url('main/members_list') ?>" method="GET" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-12 gap-4 items-end">

        <!-- Field Name / Search -->
        <div class="xl:col-span-3">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Member Name</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input type="text" name="search" placeholder="Enter member name..."
                    value="<?= $this->input->get('search') ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-9 pr-3 py-2 text-xs text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
            </div>
        </div>

        <!-- Membership Type -->
        <div class="xl:col-span-2">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Type</label>
            <div class="relative">
                <select name="type" class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3 py-2 text-xs text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
                    <option value="">Select Type</option>
                    <option value="Full">Full</option>
                    <option value="Associate">Associate</option>
                    <option value="Student">Student</option>
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
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
                <input type="date" name="dob_to" title="To DOB"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
            </div>
        </div>

        <!-- Anniversary Range (From - To) -->
        <div class="xl:col-span-3">
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Anniversary Range</label>
            <div class="grid grid-cols-2 gap-2">
                <input type="date" name="anniv_from" title="From Anniversary"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
                <input type="date" name="anniv_to" title="To Anniversary"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-2.5 py-1.5 text-xs text-slate-300 focus:outline-none focus:border-blue-500 transition cursor-pointer">
            </div>
        </div>

        <!-- Apply Filter Button -->
        <div class="xl:col-span-1">
            <button type="submit" class="w-full bg-slate-800 hover:bg-blue-600 text-slate-200 hover:text-white font-semibold text-xs py-2 px-3 rounded-xl border border-darkBorder hover:border-blue-500 transition flex items-center justify-center gap-1 shadow-md">
                <i class="fa-solid fa-filter text-[10px]"></i>
                <span>Filter</span>
            </button>
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
                    <th scope="col" class="py-3.5 px-6">Name</th>
                    <th scope="col" class="py-3.5 px-6">Type</th>
                    <th scope="col" class="py-3.5 px-6">DOB</th>
                    <th scope="col" class="py-3.5 px-6">Anniversary</th>
                    <th scope="col" class="py-3.5 px-6 text-center w-28">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder font-normal">
                <?php
                // Default fallback mock members matching wireframe
                $members_list = isset($members) && !empty($members) ? $members : [
                    ['id' => 1, 'name' => 'Annor Name',     'type' => 'Full',      'dob' => '15-Mar-1988', 'anniversary' => '20-Jun-2015'],
                    ['id' => 2, 'name' => 'Julin Kuriran',   'type' => 'Associate', 'dob' => '15-Mar-1988', 'anniversary' => '20-Jun-2015'],
                    ['id' => 3, 'name' => 'Martiss Studio',  'type' => 'Associate', 'dob' => '15-Mar-1988', 'anniversary' => '20-Jun-2015'],
                    ['id' => 4, 'name' => 'Eiday Stenren',   'type' => 'Full',      'dob' => '15-Mar-1988', 'anniversary' => '20-Jun-2015'],
                    ['id' => 5, 'name' => 'Anvin Brenk',     'type' => 'Full',      'dob' => '15-Mar-1988', 'anniversary' => '20-Jun-2015'],
                    ['id' => 6, 'name' => 'Manam Denan',    'type' => 'Associate', 'dob' => '15-Mar-1988', 'anniversary' => '20-Jun-2015'],
                    ['id' => 7, 'name' => 'Suph Eimma',     'type' => 'Student',   'dob' => '15-Mar-1988', 'anniversary' => '20-Jun-2015']
                ];

                foreach ($members_list as $index => $row):
                ?>
                    <tr class="hover:bg-slate-800/40 transition">
                        <!-- Sr.No -->
                        <td class="py-3.5 px-5 text-center font-mono text-xs text-slate-500">
                            <?= $index + 1 ?>
                        </td>

                        <!-- Member Name -->
                        <td class="py-3.5 px-6 font-semibold text-white">
                            <?= htmlspecialchars($row['name']) ?>
                        </td>

                        <!-- Type Badge -->
                        <td class="py-3.5 px-6">
                            <?php if ($row['type'] === 'Full'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    Full
                                </span>
                            <?php elseif ($row['type'] === 'Associate'): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                    Associate
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-500/10 text-slate-300 border border-slate-500/20">
                                    Student
                                </span>
                            <?php endif; ?>
                        </td>

                        <!-- DOB -->
                        <td class="py-3.5 px-6 font-mono text-xs text-slate-300">
                            <?= htmlspecialchars($row['dob']) ?>
                        </td>

                        <!-- Anniversary -->
                        <td class="py-3.5 px-6 font-mono text-xs text-slate-300">
                            <?= !empty($row['anniversary']) ? htmlspecialchars($row['anniversary']) : '<span class="text-slate-600">-</span>' ?>
                        </td>

                        <!-- Action: View Button (Linked to your Main controller view($id) method) -->
                        <td class="py-3.5 px-6 text-center">
                            <a href="<?= base_url('main/view/' . $row['id']) ?>"
                                class="inline-flex items-center gap-1.5 bg-[#0A1020] hover:bg-blue-600 text-slate-300 hover:text-white border border-darkBorder hover:border-blue-500 text-xs font-medium px-3 py-1.5 rounded-lg transition shadow-sm">
                                <i class="fa-regular fa-eye text-[11px]"></i>
                                <span>View</span>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Bar -->
    <div class="px-6 py-4 border-t border-darkBorder bg-[#0A1020] flex items-center justify-end">
        <nav class="flex items-center gap-1 text-xs font-medium">
            <span class="px-3 py-1.5 rounded-lg bg-blue-600 text-white font-bold">1</span>
            <a href="#" class="px-3 py-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">2</a>
            <a href="#" class="px-3 py-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">3</a>
            <span class="px-2 py-1.5 text-slate-600">...</span>
            <a href="#" class="px-3 py-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">10</a>
            <a href="#" class="px-3 py-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">Next &rarr;</a>
        </nav>
    </div>

    <!-- SECTION 3: Bottom Actions Bar (Add, Edit, Remove, Export) -->
    <div class="p-5 border-t border-darkBorder bg-darkCard flex flex-wrap items-center justify-between gap-4">

        <!-- Left: Management Action Buttons -->
        <div class="flex items-center gap-2.5">
            <!-- Add Member -->
            <a href="<?= base_url('main/add_member') ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Add
            </a>

            <!-- Edit Selected -->
            <button type="button" onclick="alert('Select a member row to edit')"
                class="bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2">
                <i class="fa-regular fa-pen-to-square text-xs"></i> Edit
            </button>

            <!-- Remove Selected -->
            <button type="button" onclick="if(confirm('Are you sure you want to remove the selected member?')) alert('Member removed');"
                class="bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold text-xs tracking-wider uppercase px-5 py-2.5 rounded-xl border border-red-500/30 transition flex items-center gap-2">
                <i class="fa-regular fa-trash-can text-xs"></i> Remove
            </button>
        </div>

        <!-- Right: Export Button -->
        <div>
            <button type="button" onclick="window.print()"
                class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-md">
                <i class="fa-solid fa-file-arrow-down text-sm"></i>
                <span>Export</span>
            </button>
        </div>

    </div>

</div>