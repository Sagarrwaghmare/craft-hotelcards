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
?>

<!-- Header Title -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-address-card text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Club Membership</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                <?= $is_edit ? 'Edit Member Details' : 'Add Member' ?>
            </h2>
            <p class="text-xs text-slate-400">Fill in the required credentials and personal information.</p>
        </div>
    </div>
    <a href="<?= base_url('main/members_list') ?>" class="text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-lg hover:bg-slate-800 transition flex items-center gap-2">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to Members
    </a>
</div>

<!-- Flash Alerts (Error / Validation) -->
<?php if ($this->session->flashdata('error')): ?>
    <div class="max-w-5xl mx-auto mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs flex items-center gap-3">
        <i class="fa-solid fa-circle-exclamation text-sm"></i>
        <span><?= $this->session->flashdata('error') ?></span>
    </div>
<?php endif; ?>

<!-- Main Form Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-8 shadow-xl max-w-5xl mx-auto">
    <form action="<?= base_url('main/save_member' . ($is_edit ? '/' . $m->id : '')) ?>" method="POST" id="memberForm" class="space-y-6">

        <!-- SECTION 1: Membership Card Details -->
        <div class="p-4 bg-[#0A1020] border border-darkBorder rounded-xl grid grid-cols-1 md:grid-cols-2 gap-5 items-center">

            <!-- Card Type -->
            <div class="mb-5">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Card Type <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-credit-card text-sm"></i>
                    </div>
                    <select name="card_type" id="cardTypeSelect" required
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none cursor-pointer">
                        <option value="Gold" <?= ($is_edit && $m->card_type === 'Gold') ? 'selected' : (!isset($m) ? 'selected' : '') ?>>Gold (Prefix 666)</option>
                        <option value="Platinum" <?= ($is_edit && $m->card_type === 'Platinum') ? 'selected' : '' ?>>Platinum (Prefix 999)</option>
                        <!-- <option value="Silver" <?= ($is_edit && $m->card_type === 'Silver') ? 'selected' : '' ?>>Silver (Prefix 333)</option> -->
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Card Number with Dynamic Type Prefix & Year Badge -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Card Number <span class="text-red-400">*</span>
                </label>
                <div class="flex items-center gap-2">
                    <!-- Hidden fields submitted with form -->
                    <input type="hidden" name="card_prefix" id="hiddenCardPrefix" value="666">
                    <input type="hidden" name="card_year" id="hiddenCardYear" value="<?= date('Y') ?>">

                    <!-- Dynamic Card Type Prefix Badge (666 for Gold, 999 for Platinum, 333 for Silver) -->
                    <span id="cardPrefixBadge"
                        class="px-3.5 py-2.5 bg-amber-500/10 border border-amber-500/30 text-amber-400 font-mono text-xs rounded-xl font-bold select-none transition-all">
                        666
                    </span>

                    <!-- Unchangeable Current Year Badge -->
                    <span id="cardYearBadge"
                        class="px-3 py-2.5 bg-slate-800/80 border border-slate-700 text-blue-400 font-mono text-xs rounded-xl font-bold select-none"
                        title="Current Registration Year">
                        <?= date('Y') ?>
                    </span>

                    <!-- Dynamic User-defined Remaining Suffix -->
                    <input type="text" name="card_suffix" id="cardSuffixInput" required placeholder="e.g. 0042" maxlength="10"
                        value="<?= htmlspecialchars($existing_suffix) ?>"
                        class="flex-1 bg-[#111C38] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-mono transition">
                </div>
                <span class="text-[11px] text-slate-500 mt-1 block">Full Card No Preview: <strong id="cardPreview" class="text-slate-300 font-mono">666-<?= date('Y') ?>-XXXX</strong></span>
            </div>
        </div>

        <!-- SECTION 2: Personal Details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- First Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    First Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="first_name" required placeholder="Enter first name"
                    value="<?= $is_edit ? htmlspecialchars($m->first_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Last Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="last_name" required placeholder="Enter last name"
                    value="<?= $is_edit ? htmlspecialchars($m->last_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <!-- Company Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Company Name
                </label>
                <input type="text" name="company_name" placeholder="Enter company name"
                    value="<?= $is_edit && !empty($m->company_name) ? htmlspecialchars($m->company_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- Designation -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Designation
                </label>
                <input type="text" name="designation" placeholder="e.g. Senior Manager"
                    value="<?= $is_edit && !empty($m->designation) ? htmlspecialchars($m->designation) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- Contact No -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Contact No <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-phone text-xs"></i>
                    </div>
                    <input type="tel" name="contact_no" required placeholder="Enter contact number"
                        value="<?= $is_edit && !empty($m->contact_no) ? htmlspecialchars($m->contact_no) : '' ?>"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition font-mono">
                </div>
            </div>

            <!-- Email Id -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Email ID <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-envelope text-xs"></i>
                    </div>
                    <input type="email" name="email" required placeholder="Enter email address"
                        value="<?= $is_edit && !empty($m->email) ? htmlspecialchars($m->email) : '' ?>"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- SECTION 3: Address -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Address</label>
            <textarea name="address" rows="2" placeholder="Enter complete residential or office address"
                class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition"><?= $is_edit && !empty($m->address) ? htmlspecialchars($m->address) : '' ?></textarea>
        </div>

        <!-- SECTION 4: DOB, Marital Status & Anniversary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-4 bg-[#0A1020] border border-darkBorder rounded-xl">
            <!-- Date of Birth (DOB) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Date of Birth (DOB) <span class="text-red-400">*</span>
                </label>
                <input type="date" name="dob" required
                    value="<?= $is_edit && !empty($m->dob) ? htmlspecialchars($m->dob) : '' ?>"
                    class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-pointer">
            </div>

            <!-- Marital Status (Matches DB enum: Single, Married, Divorced, Widowed, Other) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Marital Status
                </label>
                <div class="relative">
                    <select name="marital_status" id="maritalStatusSelect"
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
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

            <!-- Anniversary (Disabled if not Married) -->
            <div id="anniversaryContainer">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 flex items-center justify-between">
                    <span>Anniversary</span>
                    <span id="anniversaryBadge" class="text-[10px] text-slate-500 lowercase font-normal">(locked)</span>
                </label>
                <div class="relative">
                    <input type="date" name="anniversary" id="anniversaryInput"
                        value="<?= $is_edit && !empty($m->anniversary) ? htmlspecialchars($m->anniversary) : '' ?>"
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- SECTION 5: Notes -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Notes</label>
            <textarea name="notes" rows="3" placeholder="Enter any specific preferences, remarks or membership notes"
                class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition"><?= $is_edit && !empty($m->notes) ? htmlspecialchars($m->notes) : '' ?></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-darkBorder/60 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs tracking-wider uppercase px-8 py-3 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i> <?= $is_edit ? 'Update Member' : 'Save Member' ?>
                </button>
                <a href="<?= base_url('main/members_list') ?>" class="bg-transparent hover:bg-slate-800 text-slate-300 font-semibold text-xs tracking-wider uppercase px-6 py-3 rounded-xl border border-darkBorder transition">
                    Cancel
                </a>
            </div>

            <!-- Wireframe Hint -->
            <span class="text-[11px] text-slate-500 italic hidden sm:inline-block">
                * Fields marked with red are mandatory.
            </span>
        </div>

    </form>
</div>

<!-- Interactive JS for Dynamic Card Prefixes & Marital Status -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cardTypeSelect = document.getElementById('cardTypeSelect');
        const cardPrefixBadge = document.getElementById('cardPrefixBadge');
        const hiddenPrefix = document.getElementById('hiddenCardPrefix');
        const currentYear = "<?= date('Y') ?>";
        const suffixInput = document.getElementById('cardSuffixInput');
        const previewDisplay = document.getElementById('cardPreview');

        const prefixMap = {
            'Gold': {
                code: '666',
                border: 'border-amber-500/30',
                bg: 'bg-amber-500/10',
                text: 'text-amber-400'
            },
            'Platinum': {
                code: '999',
                border: 'border-slate-400/30',
                bg: 'bg-slate-400/10',
                text: 'text-slate-200'
            },
            'Silver': {
                code: '333',
                border: 'border-blue-400/30',
                bg: 'bg-blue-500/10',
                text: 'text-blue-300'
            }
        };

        function updateCardPrefix() {
            const selectedType = cardTypeSelect.value || 'Gold';
            const cfg = prefixMap[selectedType] || prefixMap['Gold'];

            // Update badge text and value
            cardPrefixBadge.textContent = cfg.code;
            hiddenPrefix.value = cfg.code;

            // Reset class stylings
            cardPrefixBadge.className = `px-3.5 py-2.5 ${cfg.bg} border ${cfg.border} ${cfg.text} font-mono text-xs rounded-xl font-bold select-none transition-all`;

            updatePreview();
        }

        function updatePreview() {
            const code = hiddenPrefix.value || '666';
            const suffix = suffixInput.value.trim() || 'XXXX';
            previewDisplay.textContent = `${code}-${currentYear}-${suffix}`;
        }

        cardTypeSelect.addEventListener('change', updateCardPrefix);
        suffixInput.addEventListener('input', updatePreview);

        // Initial trigger
        updateCardPrefix();

        // ----------------------------------------------------
        // Marital Status & Anniversary Logic
        // ----------------------------------------------------
        const maritalSelect = document.getElementById('maritalStatusSelect');
        const annivInput = document.getElementById('anniversaryInput');
        const annivBadge = document.getElementById('anniversaryBadge');

        function toggleAnniversary() {
            if (maritalSelect.value === 'Married') {
                annivInput.disabled = false;
                annivInput.classList.remove('opacity-30', 'cursor-not-allowed');
                annivBadge.textContent = '(required if married)';
                annivBadge.classList.replace('text-slate-500', 'text-blue-400');
            } else {
                annivInput.disabled = true;
                annivInput.value = ''; // Clear value if not married
                annivInput.classList.add('opacity-30', 'cursor-not-allowed');
                annivBadge.textContent = '(not married - locked)';
                annivBadge.classList.replace('text-blue-400', 'text-slate-500');
            }
        }

        toggleAnniversary();
        maritalSelect.addEventListener('change', toggleAnniversary);
    });
</script>