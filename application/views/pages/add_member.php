<!-- Header Title -->
<div class="flex items-center justify-between mb-8">
    <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-600/15 border border-blue-500/20 text-blue-400 flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-address-card text-base"></i>
        </div>
        <div>
            <span class="text-[11px] font-bold text-blue-400 tracking-wider uppercase">Club Membership</span>
            <h2 class="text-2xl font-bold text-white tracking-tight">
                <?= isset($member) ? 'Edit Member Details' : 'Add Member' ?>
            </h2>
            <p class="text-xs text-slate-400">Fill in the required credentials and personal information.</p>
        </div>
    </div>
    <a href="<?= base_url() ?>" class="text-xs text-slate-300 border border-darkBorder px-3.5 py-2 rounded-lg hover:bg-slate-800 transition flex items-center gap-2">
        <i class="fa-solid fa-arrow-left text-[10px]"></i> Back to List
    </a>
</div>

<!-- Main Form Card -->
<div class="bg-darkCard border border-darkBorder rounded-2xl p-6 lg:p-8 shadow-xl max-w-5xl mx-auto">
    <form action="<?= isset($member) ? base_url('members/update/' . $member->id) : base_url('members/store') ?>" method="POST" id="memberForm" class="space-y-6">

        <!-- SECTION 1: Membership Card Details -->
        <div class="p-4 bg-[#0A1020] border border-darkBorder rounded-xl grid grid-cols-1 md:grid-cols-2 gap-5 items-center">
            <!-- Card Type -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Card Type <span class="text-red-400">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-regular fa-credit-card text-sm"></i>
                    </div>
                    <select name="card_type" required
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl pl-10 pr-10 py-2.5 text-sm text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition appearance-none cursor-pointer">
                        <option value="" disabled <?= !isset($member) ? 'selected' : '' ?>>Select Type</option>
                        <option value="Gold" <?= (isset($member) && $member->card_type == 'Gold') ? 'selected' : '' ?>>Gold</option>
                        <option value="Platinum" <?= (isset($member) && $member->card_type == 'Platinum') ? 'selected' : '' ?>>Platinum</option>
                        <option value="Silver" <?= (isset($member) && $member->card_type == 'Silver') ? 'selected' : '' ?>>Silver</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Card Number with Prefix Badges -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Card Number <span class="text-red-400">*</span>
                </label>
                <div class="flex items-center gap-2">
                    <!-- Prefix Pills (from wireframe [4242] [1314]) -->
                    <span class="px-3 py-2 bg-slate-800/80 border border-slate-700 text-blue-400 font-mono text-xs rounded-xl font-bold select-none">4242</span>
                    <span class="px-3 py-2 bg-slate-800/80 border border-slate-700 text-blue-400 font-mono text-xs rounded-xl font-bold select-none">1314</span>

                    <!-- Dynamic Remaining Input -->
                    <input type="text" name="card_number" required placeholder="Enter remaining digits" maxlength="8"
                        value="<?= isset($member->card_number) ? htmlspecialchars($member->card_number) : '' ?>"
                        class="flex-1 bg-[#111C38] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 font-mono transition">
                </div>
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
                    value="<?= isset($member->first_name) ? htmlspecialchars($member->first_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Last Name <span class="text-red-400">*</span>
                </label>
                <input type="text" name="last_name" required placeholder="Enter last name"
                    value="<?= isset($member->last_name) ? htmlspecialchars($member->last_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
            </div>

            <!-- Company Name -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Company Name
                </label>
                <input type="text" name="company_name" placeholder="Enter company name"
                    value="<?= isset($member->company_name) ? htmlspecialchars($member->company_name) : '' ?>"
                    class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition">
            </div>

            <!-- Designation -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Designation
                </label>
                <input type="text" name="designation" placeholder="e.g. Senior Manager"
                    value="<?= isset($member->designation) ? htmlspecialchars($member->designation) : '' ?>"
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
                        value="<?= isset($member->contact_no) ? htmlspecialchars($member->contact_no) : '' ?>"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
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
                        value="<?= isset($member->email) ? htmlspecialchars($member->email) : '' ?>"
                        class="w-full bg-[#0A1020] border border-darkBorder rounded-xl pl-10 pr-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- SECTION 3: Address -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Address</label>
            <textarea name="address" rows="2" placeholder="Enter complete residential or office address"
                class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition"><?= isset($member->address) ? htmlspecialchars($member->address) : '' ?></textarea>
        </div>

        <!-- SECTION 4: DOB, Marital Status & Anniversary -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-4 bg-[#0A1020] border border-darkBorder rounded-xl">
            <!-- Date of Birth (DOB) -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Date of Birth (DOB) <span class="text-red-400">*</span>
                </label>
                <input type="date" name="dob" required
                    value="<?= isset($member->dob) ? htmlspecialchars($member->dob) : '' ?>"
                    class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition cursor-pointer">
            </div>

            <!-- Marital Status -->
            <div>
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">
                    Marital Status
                </label>
                <div class="relative">
                    <select name="marital_status" id="maritalStatusSelect"
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition appearance-none cursor-pointer">
                        <option value="unmarried" <?= (!isset($member) || (isset($member) && $member->marital_status != 'married')) ? 'selected' : '' ?>>Unmarried / Single</option>
                        <option value="married" <?= (isset($member) && $member->marital_status == 'married') ? 'selected' : '' ?>>Married</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-500">
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Anniversary (Disabled if Unmarried) -->
            <div id="anniversaryContainer">
                <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2 flex items-center justify-between">
                    <span>Anniversary</span>
                    <span id="anniversaryBadge" class="text-[10px] text-slate-500 lowercase font-normal">(locked)</span>
                </label>
                <div class="relative">
                    <input type="date" name="anniversary" id="anniversaryInput"
                        value="<?= isset($member->anniversary) ? htmlspecialchars($member->anniversary) : '' ?>"
                        class="w-full bg-[#111C38] border border-darkBorder rounded-xl px-3.5 py-2 text-sm text-slate-200 focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>
        </div>

        <!-- SECTION 5: Notes -->
        <div>
            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-2">Notes</label>
            <textarea name="notes" rows="3" placeholder="Enter any specific preferences, remarks or membership notes"
                class="w-full bg-[#0A1020] border border-darkBorder rounded-xl px-4 py-2.5 text-sm text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 transition"><?= isset($member->notes) ? htmlspecialchars($member->notes) : '' ?></textarea>
        </div>

        <!-- Action Buttons -->
        <div class="pt-4 border-t border-darkBorder/60 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs tracking-wider uppercase px-8 py-3 rounded-xl transition shadow-lg shadow-blue-600/20 flex items-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i> <?= isset($member) ? 'Update Member' : 'Add Member' ?>
                </button>
                <a href="<?= base_url() ?>" class="bg-transparent hover:bg-slate-800 text-slate-300 font-semibold text-xs tracking-wider uppercase px-6 py-3 rounded-xl border border-darkBorder transition">
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

<!-- Interactive JS for Marital Status / Anniversary -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const maritalSelect = document.getElementById('maritalStatusSelect');
        const annivInput = document.getElementById('anniversaryInput');
        const annivBadge = document.getElementById('anniversaryBadge');

        function toggleAnniversary() {
            if (maritalSelect.value === 'married') {
                annivInput.disabled = false;
                annivInput.classList.remove('opacity-30', 'cursor-not-allowed');
                annivBadge.textContent = '(required if applicable)';
                annivBadge.classList.replace('text-slate-500', 'text-blue-400');
            } else {
                annivInput.disabled = true;
                annivInput.value = ''; // Clears value if unmarried
                annivInput.classList.add('opacity-30', 'cursor-not-allowed');
                annivBadge.textContent = '(unmarried - locked)';
                annivBadge.classList.replace('text-blue-400', 'text-slate-500');
            }
        }

        // Initialize state on page load (handles edit state)
        toggleAnniversary();

        // Listen for dropdown changes
        maritalSelect.addEventListener('change', toggleAnniversary);
    });
</script>