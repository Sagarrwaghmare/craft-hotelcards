<!-- Header Title -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-users-gear text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Administration</span>
            <h2 class="text-2xl font-bold text-white tracking-tight page-title">User Management</h2>
            <p class="text-xs text-slate-400 page-subtitle">View, assign roles, and manage internal system access.</p>
        </div>
    </div>

    <!-- Top Add User Button -->
    <a href="<?= base_url('main/add_user') ?>"
        class="btn-add-user bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-4 py-2.5 rounded-xl transition shadow-md shadow-blue-600/25 flex items-center gap-2 self-start sm:self-auto active:scale-[0.98]">
        <i class="fa-solid fa-user-plus text-xs"></i> Add User
    </a>
</div>

<!-- Flash Alerts -->
<?php if ($this->session->flashdata('success')): ?>
    <div class="max-w-5xl mx-auto mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-check text-sm shrink-0"></i>
        <span><?= $this->session->flashdata('success') ?></span>
    </div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
    <div class="max-w-5xl mx-auto mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-sm shrink-0"></i>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Main Table Card wrapped in a Form for batch deletion -->
<form id="usersActionForm" action="<?= base_url('main/delete_users') ?>" method="POST">
    <div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden max-w-5xl mx-auto">

        <!-- Table Sub-header -->
        <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between table-subhead">
            <div class="flex items-center gap-2.5">
                <i class="fa-solid fa-table-list text-blue-400 text-sm"></i>
                <h3 class="text-sm font-bold text-white tracking-wide subhead-title">Registered Users</h3>
            </div>
            <span class="text-xs text-slate-400 font-mono subhead-counter">
                Total Records: <strong class="text-white subhead-count"><?= isset($total_count) ? $total_count : count($users ?? []) ?></strong>
            </span>
        </div>

        <!-- Table Responsive Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="users-table-head text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/70 border-b border-darkBorder font-bold">
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
                        <th scope="col" class="py-3.5 px-6 w-40">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-lock text-xs"></i>
                                <span>Access Level</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-darkBorder font-normal">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="4" class="py-10 text-center text-slate-500 text-xs">
                                <i class="fa-solid fa-users-slash text-2xl mb-2 block"></i>
                                No users registered in the database yet.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php
                        $sr_offset = isset($current_page) && isset($per_page) ? ($current_page - 1) * $per_page : 0;
                        foreach ($users as $index => $u):
                            $access_level = !empty($u['access']) ? $u['access'] : (!empty($u['role']) ? $u['role'] : 'Viewer');
                            $userData = htmlspecialchars(json_encode([
                                'id'         => $u['id'],
                                'name'       => $u['name'],
                                'email'      => $u['email'],
                                'username'   => $u['username'],
                                'contact_no' => $u['contact_no'] ?? '',
                                'access'     => $access_level
                            ]), ENT_QUOTES, 'UTF-8');
                        ?>
                            <tr class="user-row hover:bg-slate-800/40 transition" data-user='<?= $userData ?>'>
                                <!-- Row Checkbox -->
                                <td class="py-4 px-5 text-center">
                                    <input type="checkbox" name="selected_users[]" value="<?= $u['id'] ?>"
                                        class="row-checkbox w-4 h-4 rounded bg-[#0A1020] border-slate-700 text-blue-600 focus:ring-blue-500 focus:ring-offset-0 cursor-pointer">
                                </td>

                                <!-- Sr.No. -->
                                <td class="py-4 px-4 text-center font-mono text-xs text-slate-500 user-sr">
                                    <?= $sr_offset + $index + 1 ?>
                                </td>

                                <!-- User (Name + Email + Username) -->
                                <td class="py-4 px-6 font-medium">
                                    <div class="flex items-center gap-3">
                                        <div class="user-avatar-badge w-8 h-8 rounded-full bg-[#0A1020] border border-darkBorder flex items-center justify-center text-slate-300 font-bold text-xs shrink-0 uppercase shadow-sm">
                                            <?= substr($u['name'], 0, 1) ?>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="user-name font-semibold text-white"><?= htmlspecialchars($u['name']) ?></span>
                                                <?php if (!empty($u['username'])): ?>
                                                    <span class="user-username text-[11px] font-mono text-slate-400">@<?= htmlspecialchars($u['username']) ?></span>
                                                <?php endif; ?>
                                            </div>
                                            <span class="user-email text-xs text-slate-400 font-mono"><?= htmlspecialchars($u['email']) ?></span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Access Level Badge -->
                                <td class="py-4 px-6">
                                    <?php if (strtolower($access_level) === 'admin'): ?>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-500/10 text-red-400 border border-red-500/20">
                                            <i class="fa-solid fa-shield-halved text-[10px] mr-1.5"></i> Admin
                                        </span>
                                    <?php elseif (strtolower($access_level) === 'editor'): ?>
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
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar (10 rows per page) -->
        <?php if (isset($total_pages) && $total_pages > 1): ?>
            <?php
            $queryParams = $_GET;
            unset($queryParams['page']);
            $baseQuery = http_build_query($queryParams);
            $queryPrefix = !empty($baseQuery) ? '?' . $baseQuery . '&page=' : '?page=';
            ?>
            <div id="usersPaginationBar" class="px-6 py-4 border-t border-darkBorder bg-[#0A1020] flex items-center justify-between">
                <span class="text-xs text-slate-500" id="usersPageInfo">
                    Showing page <strong class="text-slate-300"><?= $current_page ?></strong> of <strong class="text-slate-300"><?= $total_pages ?></strong> (10 records/page)
                </span>

                <nav class="flex items-center gap-1 text-xs font-medium">
                    <?php if ($current_page > 1): ?>
                        <a href="<?= base_url('main/users' . $queryPrefix . ($current_page - 1)) ?>"
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
                            <a href="<?= base_url('main/users' . $queryPrefix . $p) ?>"
                                class="px-3 py-1.5 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition"><?= $p ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($current_page < $total_pages): ?>
                        <a href="<?= base_url('main/users' . $queryPrefix . ($current_page + 1)) ?>"
                            class="px-3 py-1.5 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">Next &rarr;</a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>

        <!-- Bottom Action Buttons: Add User, Edit, Delete -->
        <div class="p-6 bg-[#0A1020] border-t border-darkBorder flex items-center justify-center gap-3 users-action-footer">
            <!-- Add User Button -->
            <a href="<?= base_url('main/add_user') ?>"
                class="btn-add-user bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl transition shadow-md shadow-blue-600/25 flex items-center gap-2 active:scale-[0.98]">
                <i class="fa-solid fa-plus text-xs"></i> Add User
            </a>

            <!-- Edit Selected Button -->
            <button type="button" id="editSelectedBtn"
                class="action-btn-edit bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl border border-darkBorder transition flex items-center gap-2 shadow-sm">
                <i class="fa-regular fa-pen-to-square text-xs"></i> Edit
            </button>

            <!-- Delete Selected Button -->
            <button type="button" id="deleteSelectedBtn"
                class="action-btn-delete bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl border border-red-500/30 transition flex items-center gap-2 shadow-sm">
                <i class="fa-regular fa-trash-can text-xs"></i> Delete
            </button>
        </div>

    </div>
</form>

<!-- ======================================================= -->
<!-- MODAL: Edit User                                        -->
<!-- ======================================================= -->
<div id="editUserModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 transition-all">
    <div class="w-full max-w-lg bg-darkCard border border-darkBorder rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-200" id="modalCard">

        <!-- Modal Header -->
        <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between">
            <h3 class="text-base font-bold text-white tracking-wide flex items-center gap-2">
                <i class="fa-solid fa-user-pen text-blue-400"></i> Edit User Details
            </h3>
            <button type="button" id="closeEditModalCross" class="text-slate-400 hover:text-white text-lg focus:outline-none">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form action="<?= base_url('main/update_user') ?>" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="user_id" id="edit_user_id">

            <!-- Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Full Name <span class="text-red-400">*</span></label>
                <input type="text" name="name" id="edit_name" required
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- Email & Username -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" id="edit_email" required
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition font-mono text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Username <span class="text-red-400">*</span></label>
                    <input type="text" name="username" id="edit_username" required
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition font-mono text-xs">
                </div>
            </div>

            <!-- Contact No & Access Level -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Contact No</label>
                    <input type="text" name="contact_no" id="edit_contact_no" placeholder="+1-555-0100"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition font-mono text-xs">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Access Level <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="access" id="edit_access" required
                            class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
                            <option value="Viewer">Viewer</option>
                            <option value="Editor">Editor</option>
                            <option value="Admin">Admin</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-500">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Optional New Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider">New Password</label>
                    <span class="text-[11px] text-slate-500 italic">Leave empty to keep unchanged</span>
                </div>
                <input type="password" name="password" placeholder="Enter new password (optional)"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 placeholder-slate-600 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- Modal Action Buttons -->
            <div class="pt-4 border-t border-darkBorder flex items-center justify-end gap-3">
                <button type="button" id="closeEditModalBtn"
                    class="bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-semibold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-darkBorder transition">
                    Cancel
                </button>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-xl shadow-lg shadow-blue-600/20 transition">
                    Save Changes
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Scoped Light Mode Theme Styles for Users List -->
<style>
    /* Table Header in Light Mode */
    html.light .users-table-head {
        background-color: #f1f5f9 !important;
        border-bottom-color: #e2e8f0 !important;
    }

    html.light .users-table-head th {
        color: #334155 !important;
        background-color: #f1f5f9 !important;
    }

    /* Subhead and Text Colors */
    html.light .page-title,
    html.light .subhead-title,
    html.light .user-name {
        color: #0f172a !important;
    }

    html.light .page-subtitle,
    html.light .subhead-counter,
    html.light .user-sr,
    html.light .user-username,
    html.light .user-email {
        color: #64748b !important;
    }

    html.light .subhead-count {
        color: #0f172a !important;
    }

    /* User Avatar Circle Badge in Light Mode */
    html.light .user-avatar-badge {
        background-color: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
        color: #1e293b !important;
    }

    /* Both Add User Buttons (Top & Bottom) in Light Mode */
    html.light .btn-add-user {
        background-color: #2563eb !important;
        color: #ffffff !important;
        border: 1px solid #2563eb !important;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25) !important;
    }

    html.light .btn-add-user:hover {
        background-color: #1d4ed8 !important;
        border-color: #1d4ed8 !important;
    }

    /* Edit Button in Light Mode (Clean White Card Button) */
    html.light .action-btn-edit {
        background-color: #ffffff !important;
        color: #1e293b !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    html.light .action-btn-edit:hover {
        background-color: #f8fafc !important;
        border-color: #94a3b8 !important;
        color: #0f172a !important;
    }

    /* Delete Button in Light Mode (Readable Crimson Red) */
    html.light .action-btn-delete {
        background-color: #fef2f2 !important;
        color: #dc2626 !important;
        border: 1px solid #fecaca !important;
        box-shadow: 0 1px 2px 0 rgba(220, 38, 38, 0.05) !important;
    }

    html.light .action-btn-delete:hover {
        background-color: #fee2e2 !important;
        border-color: #fca5a5 !important;
        color: #b91c1c !important;
    }

    /* Pagination in Light Mode */
    html.light #usersPaginationBar {
        background-color: #ffffff !important;
        border-top-color: #e2e8f0 !important;
    }

    html.light #usersPageInfo {
        color: #64748b !important;
    }

    html.light #usersPageInfo strong {
        color: #0f172a !important;
    }

    html.light #usersPaginationBar nav a {
        color: #475569 !important;
    }

    html.light #usersPaginationBar nav a:hover {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }
</style>

<!-- Scripts for Selection & Modal Logic -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.row-checkbox');
        const form = document.getElementById('usersActionForm');

        const modal = document.getElementById('editUserModal');
        const modalCard = document.getElementById('modalCard');
        const closeCross = document.getElementById('closeEditModalCross');
        const closeBtn = document.getElementById('closeEditModalBtn');

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

        if (closeCross) closeCross.addEventListener('click', closeModal);
        if (closeBtn) closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });

        // Master select/unselect all
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

        // Edit button click: opens modal and loads data
        document.getElementById('editSelectedBtn').addEventListener('click', function() {
            const checked = document.querySelectorAll('.row-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select a user to edit.');
            } else if (checked.length > 1) {
                alert('Please select only one user to edit at a time.');
            } else {
                const tr = checked[0].closest('tr');
                const rawData = tr.getAttribute('data-user');
                if (rawData) {
                    const u = JSON.parse(rawData);
                    document.getElementById('edit_user_id').value = u.id;
                    document.getElementById('edit_name').value = u.name;
                    document.getElementById('edit_email').value = u.email;
                    document.getElementById('edit_username').value = u.username;
                    document.getElementById('edit_contact_no').value = u.contact_no || '';
                    document.getElementById('edit_access').value = u.access;
                    openModal();
                }
            }
        });

        // Delete button click
        document.getElementById('deleteSelectedBtn').addEventListener('click', function() {
            const checked = document.querySelectorAll('.row-checkbox:checked');
            if (checked.length === 0) {
                alert('Please select at least one user to delete.');
            } else {
                if (confirm(`Are you sure you want to delete ${checked.length} selected user(s)? This cannot be undone.`)) {
                    form.submit();
                }
            }
        });
    });
</script>