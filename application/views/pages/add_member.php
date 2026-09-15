<?php
// Prepare edit values if in edit mode
$is_edit = isset($member) && !empty($member);
$m = $is_edit ? (is_array($member) ? (object)$member : $member) : null;

// Break existing card_number (e.g. 666-2026-1042) into parts if editing
$existing_suffix = '';
if ($is_edit && !empty($m->card_number)) {
    $parts = explode('-', $m->card_number);
    $existing_suffix = end($parts);
}

// Role Check: Check if currently logged in user is a Viewer
$current_role  = strtolower(trim((string)$this->session->userdata('access')));
$is_viewer     = ($current_role === 'viewer');
$disabled_attr = $is_viewer ? 'disabled' : '';
?>

<!-- Header Title -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-address-card text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Club Membership</span>
            <h2 class="text-2xl font-bold text-white tracking-tight page-title">
                <?= $is_edit ? 'Edit Member Details' : 'Add Member' ?>
            </h2>
            <p class="text-xs text-slate-400 page-subtitle">
                <?= $is_viewer ? 'Viewing member information in read-only mode.' : 'Fill in the required credentials and personal information.' ?>
            </p>
        </div>
    </div>
    <a href="<?= base_url('main/members_list') ?>" class="back-btn text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-xl hover:bg-slate-800 transition flex items-center gap-2 shadow-sm">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Members
    </a>
</div>

<!-- Flash Alerts (Error / Validation) -->
<?php if ($this->session->flashdata('error')): ?>
    <div class="max-w-5xl mx-auto mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-sm shrink-0"></i>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
<?php endif; ?>

<?php if ($is_viewer): ?>
    <div class="max-w-5xl mx-auto mb-6 p-3.5 rounded-xl bg-amber-500/10 border border-amber-500/30 text-amber-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-lock text-sm shrink-0"></i>
        <span>You are logged in with <strong>Viewer</strong> access. Adding and modifying member records is disabled.</span>
    </div>
<?php endif; ?>

<!-- Main Form Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-8 shadow-xl max-w-5xl mx-auto">
    <form action="<?= base_url('main/save_member' . ($is_edit ? '/' . $m->id : '')) ?>" method="POST" id="memberForm" class="space-y-6">

        <!-- SECTION 1: Membership Card Details -->
        <div class="p-5 bg-[#0A1020] border border-darkBorder rounded-xl grid grid-cols-1 md:grid-cols-2 gap-5 items-center section-box">

            <!-- Card Type (Gold / Platinum only) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Card Type <?php if (!$is_viewer): ?><span class="text-red-400">*</span><?php endif; ?>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-credit-card text-sm"></i>
                    </div>
                    <select name="card_type" id="cardTypeSelect" required <?= $disabled_attr ?>
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none cursor-pointer <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
                        <option value="Gold" <?= ($is_edit && $m->card_type === 'Gold') ? 'selected' : (!isset($m) ? 'selected' : '') ?>>Gold (Prefix 666)</option>
                        <option value="Platinum" <?= ($is_edit && $m->card_type === 'Platinum') ? 'selected' : '' ?>>Platinum (Prefix 999)</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Card Number with Dynamic Type Prefix & Year Badge -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Card Number <?php if (!$is_viewer): ?><span class="text-red-400">*</span><?php endif; ?>
                </label>
                <div class="flex items-center gap-2.5">
                    <!-- Hidden fields submitted with form -->
                    <input type="hidden" name="card_prefix" id="hiddenCardPrefix" value="666">
                    <input type="hidden" name="card_year" id="hiddenCardYear" value="<?= date('Y') ?>">

                    <!-- Dynamic Card Type Prefix Badge (666 for Gold, 999 for Platinum) -->
                    <span id="cardPrefixBadge"
                        class="card-prefix-badge badge-gold px-3.5 py-2.5 font-mono text-xs rounded-xl font-bold select-none transition-all shadow-sm">
                        666
                    </span>

                    <!-- Unchangeable Current Year Badge -->
                    <span id="cardYearBadge"
                        class="card-year-badge px-3.5 py-2.5 font-mono text-xs rounded-xl font-bold select-none shadow-sm"
                        title="Current Registration Year">
                        <?= date('Y') ?>
                    </span>

                    <!-- Dynamic User-defined Remaining Suffix -->
                    <input type="text" name="card_suffix" id="cardSuffixInput" required placeholder="e.g. 0042" maxlength="10"
                        value="<?= htmlspecialchars($existing_suffix) ?>" <?= $disabled_attr ?>
                        class="flex-1 bg-[#111C38] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-mono transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
                </div>
                <span class="text-[11px] text-slate-500 mt-1.5 block preview-label">
                    Full Card No Preview: <strong id="cardPreview" class="text-slate-200 font-mono">666-<?= date('Y') ?>-XXXX</strong>
                </span>
            </div>
        </div>

        <!-- SECTION 2: Personal Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- First Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    First Name <?php if (!$is_viewer): ?><span class="text-red-400">*</span><?php endif; ?>
                </label>
                <input type="text" name="first_name" required placeholder="Enter first name" <?= $disabled_attr ?>
                    value="<?= $is_edit ? htmlspecialchars($m->first_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Last Name <?php if (!$is_viewer): ?><span class="text-red-400">*</span><?php endif; ?>
                </label>
                <input type="text" name="last_name" required placeholder="Enter last name" <?= $disabled_attr ?>
                    value="<?= $is_edit ? htmlspecialchars($m->last_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
            </div>

            <!-- Company Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Company Name
                </label>
                <input type="text" name="company_name" placeholder="Enter company name" <?= $disabled_attr ?>
                    value="<?= $is_edit && !empty($m->company_name) ? htmlspecialchars($m->company_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
            </div>

            <!-- Designation -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Designation
                </label>
                <input type="text" name="designation" placeholder="e.g. Senior Manager" <?= $disabled_attr ?>
                    value="<?= $is_edit && !empty($m->designation) ? htmlspecialchars($m->designation) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
            </div>

            <!-- Contact No -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Contact No <?php if (!$is_viewer): ?><span class="text-red-400">*</span><?php endif; ?>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-phone text-xs"></i>
                    </div>
                    <input type="tel" name="contact_no" required placeholder="Enter contact number" <?= $disabled_attr ?>
                        value="<?= $is_edit && !empty($m->contact_no) ? htmlspecialchars($m->contact_no) : '' ?>"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 font-mono transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
                </div>
            </div>

            <!-- Email Id -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Email ID <?php if (!$is_viewer): ?><span class="text-red-400">*</span><?php endif; ?>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-envelope text-xs"></i>
                    </div>
                    <input type="email" name="email" required placeholder="Enter email address" <?= $disabled_attr ?>
                        value="<?= $is_edit && !empty($m->email) ? htmlspecialchars($m->email) : '' ?>"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
                </div>
            </div>
        </div>

        <!-- SECTION 3: Address -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Address</label>
            <textarea name="address" rows="2" placeholder="Enter complete residential or office address" <?= $disabled_attr ?>
                class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>"><?= $is_edit && !empty($m->address) ? htmlspecialchars($m->address) : '' ?></textarea>
        </div>

        <!-- SECTION 4: DOB, Marital Status & Anniversary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-5 bg-[#0A1020] border border-darkBorder rounded-xl section-box">
            <!-- Date of Birth (DOB) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Date of Birth (DOB) <?php if (!$is_viewer): ?><span class="text-red-400">*</span><?php endif; ?>
                </label>
                <input type="date" name="dob" required <?= $disabled_attr ?>
                    value="<?= $is_edit && !empty($m->dob) ? htmlspecialchars($m->dob) : '' ?>"
                    class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-pointer <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
            </div>

            <!-- Marital Status -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">
                    Marital Status
                </label>
                <div class="relative">
                    <select name="marital_status" id="maritalStatusSelect" <?= $disabled_attr ?>
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
                        <option value="Single" <?= (!$is_edit || $m->marital_status === 'Single') ? 'selected' : '' ?>>Single</option>
                        <option value="Married" <?= ($is_edit && $m->marital_status === 'Married') ? 'selected' : '' ?>>Married</option>
                        <option value="Divorced" <?= ($is_edit && $m->marital_status === 'Divorced') ? 'selected' : '' ?>>Divorced</option>
                        <option value="Widowed" <?= ($is_edit && $m->marital_status === 'Widowed') ? 'selected' : '' ?>>Widowed</option>
                        <option value="Other" <?= ($is_edit && $m->marital_status === 'Other') ? 'selected' : '' ?>>Other</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Anniversary -->
            <div id="anniversaryContainer">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 flex items-center justify-between form-label">
                    <span>Anniversary</span>
                    <span id="anniversaryBadge" class="text-[10px] text-slate-500 lowercase font-normal">(locked)</span>
                </label>
                <div class="relative">
                    <input type="date" name="anniversary" id="anniversaryInput" <?= $disabled_attr ?>
                        value="<?= $is_edit && !empty($m->anniversary) ? htmlspecialchars($m->anniversary) : '' ?>"
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>">
                </div>
            </div>
        </div>

        <!-- SECTION 5: Notes -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 form-label">Notes</label>
            <textarea name="notes" rows="3" placeholder="Enter any specific preferences, remarks or membership notes" <?= $disabled_attr ?>
                class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition <?= $is_viewer ? 'opacity-60 cursor-not-allowed' : '' ?>"><?= $is_edit && !empty($m->notes) ? htmlspecialchars($m->notes) : '' ?></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="pt-5 border-t border-darkBorder/60 flex items-center justify-between action-footer">
            <div class="flex items-center gap-3">
                <?php if (!$is_viewer): ?>
                    <!-- High-contrast Save/Update Member Button -->
                    <button type="submit"
                        class="save-member-btn bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs tracking-wider uppercase px-8 py-3 rounded-xl transition shadow-lg shadow-blue-600/25 active:scale-[0.99] flex items-center gap-2">
                        <i class="fa-solid fa-check text-xs"></i>
                        <span><?= $is_edit ? 'Update Member' : 'Save Member' ?></span>
                    </button>
                <?php else: ?>
                    <!-- Read-Only Badge for Viewers -->
                    <span class="inline-flex items-center px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-800 text-slate-400 border border-darkBorder cursor-not-allowed select-none">
                        <i class="fa-solid fa-lock mr-2 text-xs text-slate-500"></i> Read Only Mode
                    </span>
                <?php endif; ?>

                <!-- Cancel Button -->
                <a href="<?= base_url('main/members_list') ?>"
                    class="cancel-btn bg-transparent hover:bg-slate-800 text-slate-300 font-semibold text-xs tracking-wider uppercase px-6 py-3 rounded-xl border border-darkBorder transition shadow-sm">
                    <?= $is_viewer ? 'Back to Members' : 'Cancel' ?>
                </a>
            </div>

            <!-- Information Hint -->
            <?php if (!$is_viewer): ?>
                <span class="text-[11px] text-slate-500 italic hidden sm:inline-block hint-text">
                    * Fields marked with red are mandatory.
                </span>
            <?php else: ?>
                <span class="text-[11px] text-amber-500/90 italic hidden sm:inline-block">
                    <i class="fa-solid fa-circle-info mr-1"></i> You do not have permissions to modify records.
                </span>
            <?php endif; ?>
        </div>

    </form>
</div>

<!-- Scoped Light Mode Adjustments for Add/Edit Member Screen -->
<style>
    /* Default (Dark Mode) Badge Colors */
    .card-prefix-badge.badge-gold {
        background-color: rgba(245, 158, 11, 0.12);
        border: 1px solid rgba(245, 158, 11, 0.35);
        color: #fbbf24;
    }

    .card-prefix-badge.badge-platinum {
        background-color: rgba(148, 163, 184, 0.15);
        border: 1px solid rgba(148, 163, 184, 0.3);
        color: #e2e8f0;
    }

    .card-year-badge {
        background-color: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(51, 65, 85, 0.9);
        color: #60a5fa;
    }

    /* Light Mode Overrides */
    html.light .page-title {
        color: #0f172a !important;
    }

    html.light .page-subtitle {
        color: #64748b !important;
    }

    html.light .form-label {
        color: #334155 !important;
    }

    html.light .hint-text {
        color: #64748b !important;
    }

    html.light .preview-label {
        color: #64748b !important;
    }

    html.light #cardPreview {
        color: #0f172a !important;
    }

    /* 666 / 999 Badges in Light Mode */
    html.light .card-prefix-badge.badge-gold {
        background-color: #fef3c7 !important;
        border: 1px solid #fcd34d !important;
        color: #b45309 !important;
        /* Deep, legible amber */
    }

    html.light .card-prefix-badge.badge-platinum {
        background-color: #f1f5f9 !important;
        border: 1px solid #cbd5e1 !important;
        color: #334155 !important;
        /* Dark legible slate */
    }

    /* Year Badge in Light Mode */
    html.light .card-year-badge {
        background-color: #eff6ff !important;
        border: 1px solid #bfdbfe !important;
        color: #1d4ed8 !important;
        /* Crisp blue text */
    }

    /* Action Buttons in Light Mode */
    html.light .save-member-btn {
        background-color: #2563eb !important;
        color: #ffffff !important;
        box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25) !important;
    }

    html.light .save-member-btn:hover {
        background-color: #1d4ed8 !important;
    }

    html.light .cancel-btn,
    html.light .back-btn {
        background-color: #ffffff !important;
        color: #1e293b !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    html.light .cancel-btn:hover,
    html.light .back-btn:hover {
        background-color: #f8fafc !important;
        border-color: #94a3b8 !important;
        color: #0f172a !important;
    }

    /* Section Sub-Boxes in Light Mode */
    html.light .section-box {
        background-color: #f8fafc !important;
        border-color: #e2e8f0 !important;
    }
</style>

<!-- Interactive JS for Dynamic Card Prefixes & Marital Status -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isViewer = <?= $is_viewer ? 'true' : 'false' ?>;

        const cardTypeSelect = document.getElementById('cardTypeSelect');
        const cardPrefixBadge = document.getElementById('cardPrefixBadge');
        const hiddenPrefix = document.getElementById('hiddenCardPrefix');
        const currentYear = "<?= date('Y') ?>";
        const suffixInput = document.getElementById('cardSuffixInput');
        const previewDisplay = document.getElementById('cardPreview');

        function updateCardPrefix() {
            const selectedType = cardTypeSelect.value || 'Gold';

            if (selectedType === 'Gold') {
                cardPrefixBadge.textContent = '666';
                hiddenPrefix.value = '666';
                cardPrefixBadge.className = 'card-prefix-badge badge-gold px-3.5 py-2.5 font-mono text-xs rounded-xl font-bold select-none transition-all shadow-sm';
            } else {
                cardPrefixBadge.textContent = '999';
                hiddenPrefix.value = '999';
                cardPrefixBadge.className = 'card-prefix-badge badge-platinum px-3.5 py-2.5 font-mono text-xs rounded-xl font-bold select-none transition-all shadow-sm';
            }

            updatePreview();
        }

        function updatePreview() {
            const code = hiddenPrefix.value || '666';
            const suffix = suffixInput.value.trim() || 'XXXX';
            previewDisplay.textContent = `${code}-${currentYear}-${suffix}`;
        }

        if (!isViewer) {
            cardTypeSelect.addEventListener('change', updateCardPrefix);
            suffixInput.addEventListener('input', updatePreview);
        }

        // Initialize state
        updateCardPrefix();

        // ----------------------------------------------------
        // Marital Status & Anniversary Logic
        // ----------------------------------------------------
        const maritalSelect = document.getElementById('maritalStatusSelect');
        const annivInput = document.getElementById('anniversaryInput');
        const annivBadge = document.getElementById('anniversaryBadge');

        function toggleAnniversary() {
            if (isViewer) {
                annivInput.disabled = true;
                return;
            }

            if (maritalSelect.value === 'Married') {
                annivInput.disabled = false;
                annivInput.classList.remove('opacity-30', 'cursor-not-allowed');
                annivBadge.textContent = '(required if married)';
                annivBadge.classList.replace('text-slate-500', 'text-blue-400');
            } else {
                annivInput.disabled = true;
                annivInput.value = '';
                annivInput.classList.add('opacity-30', 'cursor-not-allowed');
                annivBadge.textContent = '(not married - locked)';
                annivBadge.classList.replace('text-blue-400', 'text-slate-500');
            }
        }

        toggleAnniversary();
        if (!isViewer) {
            maritalSelect.addEventListener('change', toggleAnniversary);
        }
    });
</script>