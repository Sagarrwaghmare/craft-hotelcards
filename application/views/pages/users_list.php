<!-- Header Title -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-users-gear text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Administration</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">User Management</h2>
            <p class="text-xs text-slate-400">View, assign roles, and manage internal system access.</p>
        </div>
    </div>

    <!-- Direct Add User Link -->
    <a href="<?= base_url() ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-4 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2 self-start sm:self-auto">
        <i class="fa-solid fa-user-plus text-xs"></i> Add User
    </a>
</div>

<!-- Main Table Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden max-w-5xl mx-auto">

    <!-- Table Sub-header -->
    <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-table-list text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white tracking-wide">Table: Users</h3>
        </div>
        <span class="text-xs text-slate-400 font-mono">Showing 5 active users</span>
    </div>

    <!-- Table Responsive Wrapper -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/70 border-b border-darkBorder font-bold">
                <tr>
                    <!-- Select All Checkbox -->
                    <th scope="col" class="py-3.5 px-5 w-20 text-center">
                        <div class="flex items-center justify-center gap-1.5 cursor-pointer">
                            <input type="checkbox" id="selectAllCheckbox"
                                class="w-4 h-4 rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                            <label for="selectAllCheckbox" class="cursor-pointer select-none">Select</label>
                        </div>
                    </th>
                    <th scope="col" class="py-3.5 px-4 w-16 text-center">Sr.No.</th>
                    <th scope="col" class="py-3.5 px-6">
                        <div class="flex items-center gap-2">
                            <i class="fa-regular fa-user text-xs"></i>
                            <span>User</span>
                        </div>
                    </th>
                    <th scope="col" class="py-3.5 px-6 w-36">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-lock text-xs"></i>
                            <span>Access</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder font-normal">
                <?php
                // Default mock records matching wireframe (used if no DB data is passed)
                $user_records = isset($users) && !empty($users) ? $users : [
                    ['id' => 1, 'name' => 'John Doe',     'email' => 'jdoe@example.com',     'role' => 'Admin'],
                    ['id' => 2, 'name' => 'Jane Smith',   'email' => 'jsmith@example.com',   'role' => 'Editor'],
                    ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mjohnson@example.com', 'role' => 'Viewer'],
                    ['id' => 4, 'name' => 'Sarah Lee',    'email' => 'slee@example.com',     'role' => 'Editor'],
                    ['id' => 5, 'name' => 'David Brown',  'email' => 'dbrown@example.com',   'role' => 'Admin'],
                ];

                foreach ($user_records as $index => $u):
                ?>
                    <tr class="user-row hover:bg-slate-800/40 transition">
                        <!-- Checkbox -->
                        <td class="py-4 px-5 text-center">
                            <input type="checkbox" name="selected_users[]" value="<?= $u['id'] ?>"
                                class="row-checkbox w-4 h-4 rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                        </td>

                        <!-- Sr.No. -->
                        <td class="py-4 px-4 text-center font-mono text-xs text-slate-500">
                            <?= $index + 1 ?>
                        </td>

                        <!-- User (Name + Email) -->
                        <td class="py-4 px-6 text-white font-medium">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#0A1020] border border-darkBorder flex items-center justify-center text-slate-400 text-xs shrink-0">
                                    <i class="fa-regular fa-user"></i>
                                </div>
                                <div>
                                    <span class="font-semibold text-white"><?= htmlspecialchars($u['name']) ?></span>
                                    <span class="text-xs text-slate-400 ml-1">(<?= htmlspecialchars($u['email']) ?>)</span>
                                </div>
                            </div>
                        </td>

                        <!-- Access / Role Badge -->
                        <td class="py-4 px-6">
                            <?php if (strtolower($u['role']) === 'admin'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                    <i class="fa-solid fa-shield-halved text-[10px] mr-1.5"></i> Admin
                                </span>
                            <?php elseif (strtolower($u['role']) === 'editor'): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                    <i class="fa-solid fa-pen-to-square text-[10px] mr-1.5"></i> Editor
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-500/10 text-slate-300 border border-slate-500/20">
                                    <i class="fa-regular fa-eye text-[10px] mr-1.5"></i> Viewer
                                </span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bottom Action Buttons: Add User, Edit, Delete -->
    <div class="p-6 bg-[#0A1020] border-t border-darkBorder flex items-center justify-center gap-3">
        <a href="<?= base_url() ?>"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Add User
        </a>

        <button type="button" id="editSelectedBtn"
            class="bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2">
            <i class="fa-regular fa-pen-to-square text-xs"></i> Edit
        </button>

        <button type="button" id="deleteSelectedBtn"
            class="bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl border border-red-500/30 transition flex items-center gap-2">
            <i class="fa-regular fa-trash-can text-xs"></i> Delete
        </button>
    </div>

    <!-- Simple Pagination Bar (Previous | 1 | 2 | 3 | Next) -->
    <div class="py-3.5 px-6 border-t border-darkBorder/60 bg-darkCard text-center">
        <nav class="inline-flex items-center gap-2 text-xs text-slate-400 select-none">
            <a href="#" class="hover:text-white transition">Previous</a>
            <span class="text-slate-600">|</span>
            <span class="text-white font-bold px-1.5 py-0.5 rounded bg-blue-600">1</span>
            <span class="text-slate-600">|</span>
            <a href="#" class="hover:text-white transition px-1">2</a>
            <span class="text-slate-600">|</span>
            <a href="#" class="hover:text-white transition px-1">3</a>
            <span class="text-slate-600">|</span>
            <a href="#" class="hover:text-white transition">Next</a>
        </nav>
    </div>

</div>

<!-- Checkbox Selection & Batch Action Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');

        // Master select / unselect all
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => {
                    cb.checked = selectAll.checked;
                    toggleRowHighlight(cb);
                });
            });
        }

        // Highlight row on individual checkbox toggle
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                toggleRowHighlight(this);
                // Uncheck master if any row is manually unchecked
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

        // Edit button click
        document.getElementById('editSelectedBtn').addEventListener('click', function() {
            const checked = document.querySelectorAll('.row-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select a user to edit.');
            } else if (checked.length > 1) {
                alert('Please select only one user to edit at a time.');
            } else {
                alert('Editing user ID: ' + checked[0].value);
            }
        });

        // Delete button click
        document.getElementById('deleteSelectedBtn').addEventListener('click', function() {
            const checked = document.querySelectorAll('.row-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one user to delete.');
            } else {
                if (confirm(`Are you sure you want to delete ${checked.length} selected user(s)?`)) {
                    alert('Selected user(s) removed.');
                }
            }
        });
    });
</script>