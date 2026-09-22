<?php
// Role and permission determinations
$user_role = strtolower(trim((string)$this->session->userdata('access')));
$can_edit  = in_array($user_role, ['admin', 'editor']);
$member_full_name = trim(($member['first_name'] ?? '') . ' ' . ($member['last_name'] ?? ''));
?>

<!-- Header Title & Action Navigation -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-regular fa-id-badge text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Profile Overview</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">Member Details</h2>
        </div>
    </div>

    <!-- Action Buttons (Edit Member + Back Navigation) -->
    <div class="flex items-center gap-2.5 self-start sm:self-auto">
        <?php if ($can_edit): ?>
            <!-- Edit Member Button -->
            <a href="<?= base_url('main/add_member/' . $member['id']) ?>"
                class="btn-edit-member bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-4 py-2 rounded-xl transition shadow-md shadow-blue-600/20 flex items-center gap-2">
                <i class="fa-regular fa-pen-to-square text-xs"></i> Edit Member
            </a>
        <?php endif; ?>

        <a href="<?= base_url('main/members_list') ?>"
            class="btn-back text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-xl hover:bg-slate-800 transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Members
        </a>
    </div>
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
<div class="bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-8 shadow-xl mb-8 info-card">
    <div class="flex items-center justify-between pb-4 mb-6 border-b border-darkBorder">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-user-check text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider card-heading">Member Information</h3>
        </div>

        <?php if (strtolower($member['card_type'] ?? 'gold') === 'gold'): ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-500 border border-amber-500/30">
                <i class="fa-solid fa-crown text-[10px] mr-1.5"></i> Gold Member
            </span>
        <?php else: ?>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-400/15 text-slate-300 border border-slate-400/30">
                <i class="fa-solid fa-gem text-[10px] mr-1.5 text-sky-400"></i> Platinum Member
            </span>
        <?php endif; ?>
    </div>

    <!-- 2-Column Key/Value Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-4 text-sm">
        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Card No:</span>
            <span class="font-mono text-white font-semibold bg-[#0A1020] px-3 py-1 rounded-lg border border-darkBorder card-badge-no"><?= htmlspecialchars($member['card_number']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Card Type:</span>
            <span class="font-semibold text-slate-200 field-val"><?= htmlspecialchars($member['card_type']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">First Name:</span>
            <span class="font-semibold text-white field-val"><?= htmlspecialchars($member['first_name']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Last Name:</span>
            <span class="font-semibold text-white field-val"><?= htmlspecialchars($member['last_name']) ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Company Name:</span>
            <span class="font-medium text-slate-200 field-val"><?= !empty($member['company_name']) ? htmlspecialchars($member['company_name']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Designation:</span>
            <span class="font-medium text-slate-200 field-val"><?= !empty($member['designation']) ? htmlspecialchars($member['designation']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Contact No:</span>
            <span class="font-medium text-slate-200 font-mono field-val"><?= !empty($member['contact_no']) ? htmlspecialchars($member['contact_no']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Email Id:</span>
            <span class="font-medium text-blue-400 field-val"><?= !empty($member['email']) ? htmlspecialchars($member['email']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Address:</span>
            <span class="font-medium text-slate-300 text-right field-val"><?= !empty($member['address']) ? htmlspecialchars($member['address']) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Anniversary:</span>
            <span class="font-mono text-slate-300 field-val"><?= (!empty($member['anniversary']) && $member['anniversary'] !== '0000-00-00') ? date('d-M-Y', strtotime($member['anniversary'])) : 'N/A' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">DOB:</span>
            <span class="font-mono text-slate-300 field-val"><?= (!empty($member['dob']) && $member['dob'] !== '0000-00-00') ? date('d-M-Y', strtotime($member['dob'])) : '-' ?></span>
        </div>

        <div class="flex items-center justify-between py-2 border-b border-darkBorder/40">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Notes:</span>
            <span class="text-slate-400 text-xs italic field-val"><?= !empty($member['notes']) ? htmlspecialchars($member['notes']) : 'None' ?></span>
        </div>
    </div>
</div>

<!-- ========================================================================= -->
<!-- SECTION 2: Co-Members / Family Details Table                              -->
<!-- ========================================================================= -->
<form id="coMemberBatchForm" action="<?= base_url('main/delete_batch_co_members') ?>" method="POST" class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden mb-8 table-card">
    <input type="hidden" name="member_id" value="<?= $member['id'] ?>">

    <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 card-topbar">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-people-roof text-indigo-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider card-heading">Co-Members / Family</h3>
            <span class="text-xs bg-indigo-500/10 text-indigo-400 border border-indigo-500/30 px-2 py-0.5 rounded-full font-mono font-semibold count-pill">
                <?= $total_comembers ?? count($comembers ?? []) ?>
            </span>
        </div>

        <div class="flex items-center gap-2">
            <?php if ($can_edit): ?>
                <!-- Batch Delete Button -->
                <button type="submit" id="deleteBatchCoBtn" onclick="return confirm('Are you sure you want to delete the selected co-members?');"
                    class="hidden bg-red-600/20 hover:bg-red-600 text-red-300 hover:text-white border border-red-500/30 font-semibold text-xs px-3.5 py-1.5 rounded-xl transition flex items-center gap-1.5">
                    <i class="fa-solid fa-trash-can text-[11px]"></i> Delete Selected (<span id="selectedCoCount">0</span>)
                </button>

                <!-- Add Co-Member Button -->
                <button type="button" id="openAddCoMemberBtn"
                    class="btn-add-comember bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-xs tracking-wider uppercase px-4 py-2 rounded-xl transition shadow-md shadow-indigo-600/20 flex items-center gap-1.5">
                    <i class="fa-solid fa-user-plus text-[11px]"></i> Add Co-Member
                </button>
            <?php endif; ?>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="details-table-head text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/60 border-b border-darkBorder font-bold">
                <tr>
                    <?php if ($can_edit): ?>
                        <th scope="col" class="py-3.5 px-4 w-10 text-center">
                            <input type="checkbox" id="selectAllCoMembers" class="table-checkbox rounded border-slate-700 bg-[#0A1020] text-indigo-600 focus:ring-0 cursor-pointer">
                        </th>
                    <?php endif; ?>
                    <th scope="col" class="py-3.5 px-4 w-16">Sr.No</th>
                    <th scope="col" class="py-3.5 px-6">Name & Relation Description</th>
                    <th scope="col" class="py-3.5 px-4">Relation</th>
                    <th scope="col" class="py-3.5 px-6">Contact No</th>
                    <th scope="col" class="py-3.5 px-6">DOB</th>
                    <?php if ($can_edit): ?>
                        <th scope="col" class="py-3.5 px-6 text-right">Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody class="divide-y divide-darkBorder">
                <?php if (!empty($comembers)): ?>
                    <?php
                    $sr = ($c_current_page - 1) * $c_per_page + 1;
                    foreach ($comembers as $c):
                        $c = (array)$c;
                        $formatted_dob = (!empty($c['dob']) && $c['dob'] !== '0000-00-00') ? date('d-M-Y', strtotime($c['dob'])) : '-';
                    ?>
                        <tr class="details-table-row hover:bg-slate-800/40 transition">
                            <?php if ($can_edit): ?>
                                <td class="py-3.5 px-4 text-center">
                                    <input type="checkbox" name="selected_co_members[]" value="<?= $c['id'] ?>" class="co-checkbox table-checkbox rounded border-slate-700 bg-[#0A1020] text-indigo-600 focus:ring-0 cursor-pointer">
                                </td>
                            <?php endif; ?>
                            <td class="py-3.5 px-4 font-mono text-xs text-slate-500"><?= $sr++ ?></td>
                            <td class="py-3.5 px-6">
                                <div class="font-semibold text-white field-val">
                                    <?= htmlspecialchars($c['name']) ?>
                                    <span class="text-xs font-normal text-slate-400 ml-1 relation-subtext">
                                        (<?= htmlspecialchars($c['relationship']) ?> of <?= htmlspecialchars($member_full_name) ?>)
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="relation-badge inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-800 text-slate-300 border border-slate-700">
                                    <?= htmlspecialchars($c['relationship']) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-xs text-slate-200 field-val">
                                <?= !empty($c['contact_no']) ? htmlspecialchars($c['contact_no']) : '-' ?>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-xs text-slate-300 field-val">
                                <?= $formatted_dob ?>
                            </td>
                            <?php if ($can_edit): ?>
                                <td class="py-3.5 px-6 text-right">
                                    <div class="inline-flex items-center gap-1.5">
                                        <!-- Edit Co-Member -->
                                        <button type="button"
                                            class="btn-row-action btn-row-edit edit-co-member-btn text-slate-400 hover:text-blue-400 bg-slate-800/60 hover:bg-slate-800 p-2 rounded-lg border border-darkBorder transition"
                                            title="Edit Co-Member"
                                            data-id="<?= $c['id'] ?>"
                                            data-name="<?= htmlspecialchars($c['name'], ENT_QUOTES) ?>"
                                            data-relationship="<?= htmlspecialchars($c['relationship'], ENT_QUOTES) ?>"
                                            data-contact="<?= htmlspecialchars($c['contact_no'] ?? '', ENT_QUOTES) ?>"
                                            data-dob="<?= htmlspecialchars($c['dob'] ?? '', ENT_QUOTES) ?>">
                                            <i class="fa-regular fa-pen-to-square text-xs"></i>
                                        </button>

                                        <!-- Delete Co-Member -->
                                        <a href="<?= base_url('main/delete_co_member/' . $c['id'] . '/' . $member['id']) ?>"
                                            onclick="return confirm('Are you sure you want to remove this co-member?');"
                                            class="btn-row-action btn-row-delete text-slate-400 hover:text-red-400 bg-slate-800/60 hover:bg-slate-800 p-2 rounded-lg border border-darkBorder transition"
                                            title="Delete Co-Member">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $can_edit ? 7 : 5 ?>" class="py-8 text-center text-xs text-slate-500">
                            <i class="fa-solid fa-user-group text-xl mb-2 block"></i>
                            No co-members or family details registered for this member yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Co-Members Pagination Bar -->
    <?php if (isset($c_total_pages) && $c_total_pages > 1): ?>
        <div class="p-4 bg-[#0A1020] border-t border-darkBorder flex items-center justify-between text-xs card-bottombar">
            <span class="text-slate-500 pagination-info">
                Page <strong class="text-slate-300"><?= $c_current_page ?></strong> of <strong class="text-slate-300"><?= $c_total_pages ?></strong>
            </span>
            <nav class="flex items-center gap-1 font-medium">
                <?php
                $vparam = !empty($v_current_page) ? '&vpage=' . $v_current_page : '';
                ?>
                <?php if ($c_current_page > 1): ?>
                    <a href="<?= base_url('main/member_details/' . $member['id'] . '?cpage=' . ($c_current_page - 1) . $vparam) ?>"
                        class="page-link px-2.5 py-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">&larr; Prev</a>
                <?php endif; ?>

                <?php for ($p = 1; $p <= $c_total_pages; $p++): ?>
                    <?php if ($p == $c_current_page): ?>
                        <span class="px-2.5 py-1 rounded-lg bg-indigo-600 text-white font-bold"><?= $p ?></span>
                    <?php else: ?>
                        <a href="<?= base_url('main/member_details/' . $member['id'] . '?cpage=' . $p . $vparam) ?>"
                            class="page-link px-2.5 py-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition"><?= $p ?></a>
                    <?php endif; ?>
                <?php endfor; ?>

                <?php if ($c_current_page < $c_total_pages): ?>
                    <a href="<?= base_url('main/member_details/' . $member['id'] . '?cpage=' . ($c_current_page + 1) . $vparam) ?>"
                        class="page-link px-2.5 py-1 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">Next &rarr;</a>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>
</form>

<!-- ========================================================================= -->
<!-- SECTION 3: Visitor Details Table                                          -->
<!-- ========================================================================= -->
<div class="bg-darkCard border border-darkBorder rounded-2xl shadow-xl overflow-hidden mb-6 table-card">
    <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between card-topbar">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-clock-rotate-left text-blue-400 text-sm"></i>
            <h3 class="text-sm font-bold text-white uppercase tracking-wider card-heading">Visitor Details</h3>
        </div>
        <div class="flex items-center gap-4 text-xs">
            <span class="text-slate-400 header-stat">Total PAX: <strong class="text-slate-200"><?= isset($summary['total_pax']) ? $summary['total_pax'] : 0 ?></strong></span>
            <span class="text-slate-400 header-stat">Total Visits: <strong class="text-white"><?= isset($total_visits) ? $total_visits : count($visits ?? []) ?></strong></span>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-300">
            <thead class="details-table-head text-[11px] uppercase tracking-wider text-slate-400 bg-slate-900/60 border-b border-darkBorder font-bold">
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
                        <tr class="details-table-row hover:bg-slate-800/40 transition">
                            <td class="py-3.5 px-6 font-mono text-xs text-white field-val">
                                <?= htmlspecialchars($formattedDate) ?>
                            </td>
                            <td class="py-3.5 px-6 font-medium text-slate-200 field-val">
                                <span class="inline-flex items-center gap-1.5">
                                    <i class="fa-solid fa-users text-slate-500 text-xs"></i>
                                    <?= htmlspecialchars($pax) ?>
                                </span>
                            </td>
                            <td class="py-3.5 px-6 font-mono text-emerald-400 font-semibold">
                                $<?= htmlspecialchars($apc) ?>
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

    <!-- Actions & Pagination Bar (10 Visits Per Page) -->
    <div class="p-5 bg-[#0A1020] border-t border-darkBorder flex flex-col sm:flex-row items-center justify-between gap-4 card-bottombar">
        <?php if ($can_edit): ?>
            <!-- Add Visit Details Button -->
            <button type="button" id="openVisitModalBtn"
                class="btn-add-visit bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs tracking-wider uppercase px-6 py-2.5 rounded-xl transition shadow-md shadow-blue-600/20 flex items-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Add visit details
            </button>
        <?php else: ?>
            <span class="text-xs text-slate-500 italic">
                <i class="fa-solid fa-lock text-[10px] mr-1"></i> Visit logging restricted to Editor & Admin
            </span>
        <?php endif; ?>

        <?php if (isset($v_total_pages) && $v_total_pages > 1): ?>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-500 pagination-info">
                    Page <strong class="text-slate-300"><?= $v_current_page ?></strong> of <strong class="text-slate-300"><?= $v_total_pages ?></strong>
                </span>
                <nav class="flex items-center gap-1 text-xs font-medium">
                    <?php
                    $cparam = !empty($c_current_page) ? '&cpage=' . $c_current_page : '';
                    ?>
                    <?php if ($v_current_page > 1): ?>
                        <a href="<?= base_url('main/member_details/' . $member['id'] . '?vpage=' . ($v_current_page - 1) . $cparam) ?>"
                            class="page-link px-2.5 py-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition">&larr; Prev</a>
                    <?php endif; ?>

                    <?php for ($p = 1; $p <= $v_total_pages; $p++): ?>
                        <?php if ($p == $v_current_page): ?>
                            <span class="px-2.5 py-1 rounded-lg bg-blue-600 text-white font-bold"><?= $p ?></span>
                        <?php else: ?>
                            <a href="<?= base_url('main/member_details/' . $member['id'] . '?vpage=' . $p . $cparam) ?>"
                                class="page-link px-2.5 py-1 rounded-lg text-slate-400 hover:text-white hover:bg-slate-800 transition"><?= $p ?></a>
                        <?php endif; ?>
                    <?php endfor; ?>

                    <?php if ($v_current_page < $v_total_pages): ?>
                        <a href="<?= base_url('main/member_details/' . $member['id'] . '?vpage=' . ($v_current_page + 1) . $cparam) ?>"
                            class="page-link px-2.5 py-1 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">Next &rarr;</a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- ========================================================================= -->
<!-- MODAL: Add / Edit Co-Member (Admin & Editor only)                         -->
<!-- ========================================================================= -->
<?php if ($can_edit): ?>
    <div id="coMemberModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 transition-all">
        <div class="w-full max-w-md bg-darkCard border border-darkBorder rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-200 modal-box" id="coModalCard">

            <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between modal-header">
                <h3 id="coModalTitle" class="text-base font-bold text-white tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-indigo-400"></i> <span>Add Co-Member</span>
                </h3>
                <button type="button" id="closeCoModalCross" class="text-slate-400 hover:text-white text-lg focus:outline-none modal-close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="<?= base_url('main/save_co_member') ?>" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="member_id" value="<?= $member['id'] ?>">
                <input type="hidden" name="co_member_id" id="co_member_id" value="">

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Name *</label>
                    <input type="text" name="name" id="co_name" required placeholder="Full Name"
                        class="form-control w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Relationship *</label>
                    <select name="relationship" id="co_relationship" required
                        class="form-control w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition">
                        <option value="Wife">Wife</option>
                        <option value="Husband">Husband</option>
                        <option value="Son">Son</option>
                        <option value="Daughter">Daughter</option>
                        <option value="Father">Father</option>
                        <option value="Mother">Mother</option>
                        <option value="Others" selected>Others</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Contact No</label>
                    <input type="text" name="contact_no" id="co_contact" placeholder="+1-555-0199"
                        class="form-control w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Date of Birth</label>
                    <input type="date" name="dob" id="co_dob"
                        class="form-control w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-indigo-500 transition cursor-pointer">
                </div>

                <div class="pt-4 border-t border-darkBorder flex items-center justify-end gap-3 modal-footer">
                    <button type="button" id="closeCoModalBtn"
                        class="btn-modal-cancel bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-semibold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-darkBorder transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="btn-save-comember bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-xl shadow-md shadow-indigo-600/20 transition">
                        Save Co-Member
                    </button>
                </div>
            </form>

        </div>
    </div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- MODAL: Add Visit Details (Admin & Editor only)                             -->
<!-- ========================================================================= -->
<?php if ($can_edit): ?>
    <div id="visitModal" class="fixed inset-0 bg-black/75 backdrop-blur-sm z-50 flex items-center justify-center hidden p-4 transition-all">
        <div class="w-full max-w-md bg-darkCard border border-darkBorder rounded-2xl shadow-2xl overflow-hidden transform transition-all scale-95 duration-200 modal-box" id="modalCard">

            <div class="px-6 py-4 border-b border-darkBorder bg-[#0A1020] flex items-center justify-between modal-header">
                <h3 class="text-base font-bold text-white tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-calendar-plus text-blue-400"></i> Add Visit Details
                </h3>
                <button type="button" id="closeModalCross" class="text-slate-400 hover:text-white text-lg focus:outline-none modal-close-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <form action="<?= base_url('main/add_visit') ?>" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="member_id" value="<?= $member['id'] ?>">

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Visit Date</label>
                    <input type="date" name="visit_date" required value="<?= date('Y-m-d') ?>"
                        class="form-control w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-pointer">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider form-label">No of Pax</label>
                        <span class="text-[10px] text-slate-400">Limit: 1 to 25</span>
                    </div>
                    <input type="number" name="no_of_pax" required min="1" max="25" value="1" placeholder="1 - 25"
                        class="form-control w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">APC (Average Per Cover)</label>
                    <input type="number" step="0.01" min="0" name="apc" required placeholder="0.00"
                        class="form-control w-full bg-[#0A1020] border border-darkBorder rounded-xl px-3.5 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
                </div>

                <div class="pt-4 border-t border-darkBorder flex items-center justify-end gap-3 modal-footer">
                    <button type="button" id="closeModalBtn"
                        class="btn-modal-cancel bg-transparent hover:bg-slate-800 text-slate-300 text-xs font-semibold uppercase tracking-wider px-5 py-2.5 rounded-xl border border-darkBorder transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="btn-save-visit bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold uppercase tracking-wider px-6 py-2.5 rounded-xl shadow-md shadow-blue-600/20 transition">
                        Save Visit
                    </button>
                </div>
            </form>

        </div>
    </div>
<?php endif; ?>

<!-- ========================================================================= -->
<!-- SCOPED LIGHT MODE STYLING OVERRIDES                                       -->
<!-- ========================================================================= -->
<style>
    /* Table Headers */
    html.light .details-table-head {
        background-color: #f1f5f9 !important;
        border-bottom-color: #e2e8f0 !important;
    }

    html.light .details-table-head th {
        color: #475569 !important;
        background-color: #f1f5f9 !important;
    }

    /* Table Rows Hover & Values */
    html.light .details-table-row:hover {
        background-color: #f8fafc !important;
    }

    html.light .field-val {
        color: #0f172a !important;
    }

    html.light .relation-subtext {
        color: #64748b !important;
    }

    html.light .card-badge-no {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        color: #0f172a !important;
    }

    /* Relation Pill Badges */
    html.light .relation-badge {
        background-color: #f1f5f9 !important;
        border-color: #cbd5e1 !important;
        color: #334155 !important;
    }

    /* Action Buttons (Edit / Delete inside Table) */
    html.light .btn-row-action {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        color: #475569 !important;
    }

    html.light .btn-row-edit:hover {
        background-color: #eff6ff !important;
        border-color: #bfdbfe !important;
        color: #2563eb !important;
    }

    html.light .btn-row-delete:hover {
        background-color: #fef2f2 !important;
        border-color: #fecaca !important;
        color: #dc2626 !important;
    }

    /* Top Action Buttons */
    html.light .btn-edit-member {
        background-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25) !important;
    }

    html.light .btn-edit-member:hover {
        background-color: #1d4ed8 !important;
    }

    html.light .btn-add-comember {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.25) !important;
    }

    html.light .btn-add-comember:hover {
        background-color: #4338ca !important;
    }

    html.light .btn-add-visit {
        background-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25) !important;
    }

    html.light .btn-add-visit:hover {
        background-color: #1d4ed8 !important;
    }

    html.light .btn-back {
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #334155 !important;
    }

    html.light .btn-back:hover {
        background-color: #f8fafc !important;
        color: #0f172a !important;
    }

    /* Modals & Form Controls in Light Mode */
    html.light .modal-box {
        background-color: #ffffff !important;
        border-color: #e2e8f0 !important;
    }

    html.light .modal-header,
    html.light .modal-footer {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
    }

    html.light .modal-close-btn {
        color: #64748b !important;
    }

    html.light .modal-close-btn:hover {
        color: #0f172a !important;
    }

    html.light .form-label {
        color: #334155 !important;
    }

    html.light .form-control {
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #0f172a !important;
    }

    html.light .form-control:focus {
        border-color: #4f46e5 !important;
    }

    html.light .btn-modal-cancel {
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
        color: #475569 !important;
    }

    html.light .btn-modal-cancel:hover {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }

    html.light .btn-save-comember {
        background-color: #4f46e5 !important;
        color: #ffffff !important;
    }

    html.light .btn-save-comember:hover {
        background-color: #4338ca !important;
    }

    html.light .btn-save-visit {
        background-color: #2563eb !important;
        color: #ffffff !important;
    }

    html.light .btn-save-visit:hover {
        background-color: #1d4ed8 !important;
    }

    /* Checkbox & Pagination in Light Mode */
    html.light .table-checkbox {
        background-color: #ffffff !important;
        border-color: #cbd5e1 !important;
    }

    html.light .page-link {
        color: #475569 !important;
    }

    html.light .page-link:hover {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }

    html.light .pagination-info {
        color: #64748b !important;
    }

    html.light .pagination-info strong {
        color: #0f172a !important;
    }

    html.light .header-stat {
        color: #64748b !important;
    }

    html.light .header-stat strong {
        color: #0f172a !important;
    }
</style>

<!-- ========================================================================= -->
<!-- JAVASCRIPT: Co-Member Multi-select, Add/Edit Modal & Visit Modal          -->
<!-- ========================================================================= -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($can_edit): ?>
            // --- Co-Member Modal Control ---
            const coModal = document.getElementById('coMemberModal');
            const coModalCard = document.getElementById('coModalCard');
            const openAddCoBtn = document.getElementById('openAddCoMemberBtn');
            const closeCoCross = document.getElementById('closeCoModalCross');
            const closeCoBtn = document.getElementById('closeCoModalBtn');
            const coModalTitle = document.getElementById('coModalTitle');

            const inputCoId = document.getElementById('co_member_id');
            const inputCoName = document.getElementById('co_name');
            const selectCoRel = document.getElementById('co_relationship');
            const inputCoContact = document.getElementById('co_contact');
            const inputCoDob = document.getElementById('co_dob');

            function openCoModal(isEdit = false, data = {}) {
                if (isEdit) {
                    coModalTitle.innerHTML = '<i class="fa-regular fa-pen-to-square text-indigo-400"></i> <span>Edit Co-Member</span>';
                    inputCoId.value = data.id || '';
                    inputCoName.value = data.name || '';
                    selectCoRel.value = data.relationship || 'Others';
                    inputCoContact.value = data.contact || '';
                    inputCoDob.value = data.dob || '';
                } else {
                    coModalTitle.innerHTML = '<i class="fa-solid fa-user-plus text-indigo-400"></i> <span>Add Co-Member</span>';
                    inputCoId.value = '';
                    inputCoName.value = '';
                    selectCoRel.value = 'Others';
                    inputCoContact.value = '';
                    inputCoDob.value = '';
                }

                coModal.classList.remove('hidden');
                setTimeout(() => {
                    coModalCard.classList.remove('scale-95');
                    coModalCard.classList.add('scale-100');
                }, 10);
            }

            function closeCoModal() {
                coModalCard.classList.remove('scale-100');
                coModalCard.classList.add('scale-95');
                setTimeout(() => {
                    coModal.classList.add('hidden');
                }, 150);
            }

            if (openAddCoBtn) openAddCoBtn.addEventListener('click', () => openCoModal(false));
            if (closeCoCross) closeCoCross.addEventListener('click', closeCoModal);
            if (closeCoBtn) closeCoBtn.addEventListener('click', closeCoModal);
            if (coModal) {
                coModal.addEventListener('click', function(e) {
                    if (e.target === coModal) closeCoModal();
                });
            }

            // Inline edit buttons
            document.querySelectorAll('.edit-co-member-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    openCoModal(true, {
                        id: this.dataset.id,
                        name: this.dataset.name,
                        relationship: this.dataset.relationship,
                        contact: this.dataset.contact,
                        dob: this.dataset.dob
                    });
                });
            });

            // --- Checkbox & Batch Delete Toggle ---
            const selectAllCo = document.getElementById('selectAllCoMembers');
            const coCheckboxes = document.querySelectorAll('.co-checkbox');
            const deleteBatchCoBtn = document.getElementById('deleteBatchCoBtn');
            const selectedCoCountSpan = document.getElementById('selectedCoCount');

            function updateCoBatchState() {
                const checkedCount = document.querySelectorAll('.co-checkbox:checked').length;
                if (checkedCount > 0) {
                    deleteBatchCoBtn.classList.remove('hidden');
                    selectedCoCountSpan.textContent = checkedCount;
                } else {
                    deleteBatchCoBtn.classList.add('hidden');
                }

                if (selectAllCo) {
                    selectAllCo.checked = (coCheckboxes.length > 0 && checkedCount === coCheckboxes.length);
                }
            }

            if (selectAllCo) {
                selectAllCo.addEventListener('change', function() {
                    coCheckboxes.forEach(cb => cb.checked = selectAllCo.checked);
                    updateCoBatchState();
                });
            }

            coCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateCoBatchState);
            });

            // --- Visit Modal Control ---
            const visitModal = document.getElementById('visitModal');
            const visitModalCard = document.getElementById('modalCard');
            const openVisitBtn = document.getElementById('openVisitModalBtn');
            const closeVisitCross = document.getElementById('closeModalCross');
            const closeVisitBtn = document.getElementById('closeModalBtn');

            function openVisitModal() {
                visitModal.classList.remove('hidden');
                setTimeout(() => {
                    visitModalCard.classList.remove('scale-95');
                    visitModalCard.classList.add('scale-100');
                }, 10);
            }

            function closeVisitModal() {
                visitModalCard.classList.remove('scale-100');
                visitModalCard.classList.add('scale-95');
                setTimeout(() => {
                    visitModal.classList.add('hidden');
                }, 150);
            }

            if (openVisitBtn) openVisitBtn.addEventListener('click', openVisitModal);
            if (closeVisitCross) closeVisitCross.addEventListener('click', closeVisitModal);
            if (closeVisitBtn) closeVisitBtn.addEventListener('click', closeVisitModal);
            if (visitModal) {
                visitModal.addEventListener('click', function(e) {
                    if (e.target === visitModal) closeVisitModal();
                });
            }
        <?php endif; ?>
    });
</script>