document.addEventListener('DOMContentLoaded', function () {

    /* ---------------- Utilities ---------------- */
    const qs = s => document.querySelector(s);

    let currentStep = 1;
    const maxSteps = 4;

    updateStep(1);

    // Remove success parameter
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('success')) {
        // Remove the success parameter from URL without page reload
        const cleanUrl = window.location.pathname + '?' +
            Array.from(urlParams.entries())
                .filter(([key]) => key !== 'success')
                .map(([key, val]) => `${key}=${val}`)
                .join('&');

        window.history.replaceState({}, document.title, cleanUrl);
    }

    /* ---------------- Author Select ---------------- */
    const authorSelect = qs('#author-select');
    const authorName = qs('#author-name');
    const authorEmail = qs('#author-email');
    const bookContainer = qs('#book-title-container');
    const socialLinksContainer = qs('#social-links-container');

    if (authorSelect) {
        authorSelect.addEventListener('change', function () {
            const opt = this.options[this.selectedIndex];

            authorName.value = '';
            authorEmail.value = '';
            socialLinksContainer.innerHTML = '';

            if (!this.value) return;

            authorName.value = opt.dataset.name || '';
            authorEmail.value = opt.dataset.email || '';

            // Preferred template
            const preferred = opt.dataset.preferredTemplate;
            if (preferred) {
                const radio = qs(`input[name="template"][value="${preferred}"]`);
                if (radio) {
                    radio.checked = true;
                    updateTemplateSelection();
                }
            }

            // book titles
            bookContainer.innerHTML = '';
            let books = [];
            try {
                books = JSON.parse(opt.dataset.books || '[]');
            } catch {
                books = [];
            }

            if (books.length === 0) {
                books = [''];
            }

            books.forEach((title, index) => {
                const input = document.createElement('input');
                input.type = 'text';
                input.name = 'book_titles[]';
                input.value = title;
                input.placeholder = `Book Title ${index + 1}`;
                input.className =
                    'w-full h-10 px-4 py-3 rounded-lg bg-gray-50 border-2 border-gray-200';

                bookContainer.appendChild(input);
            });

            // Social links
            if (!opt.dataset.socialLinks) return;
            let links = {};
            try {
                links = JSON.parse(opt.dataset.socialLinks);
            } catch {
                return;
            }

            Object.entries(links).forEach(([platform, url]) => {
                if (!url) return;
                const div = document.createElement('div');
                div.innerHTML = `
					<label class="block text-xs font-bold text-gray-700 capitalize mb-2">${platform}</label>
					<input type="url" name="social_links[${platform}]"
						value="${url}"
						class="w-full h-10 px-4 py-3 rounded-lg bg-gray-50 border-2 border-gray-200 text-sm">
				`;
                socialLinksContainer.appendChild(div);
            });
            clearError();
        });
    }

    /* ---------------- Template Switch ---------------- */
    document.querySelectorAll('input[name="template"]').forEach(r =>
        r.addEventListener('change', updateTemplateSelection)
    );

    /* ---------------- Navigation ---------------- */
    document.querySelectorAll('.next-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault(); // Always prevent default for next buttons

            if (validateStep()) {
                currentStep++;
                updateStep(currentStep);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });
    });

    document.querySelectorAll('.prev-btn').forEach(btn => {
        btn.addEventListener('click', e => {
            e.preventDefault();
            currentStep--;
            updateStep(currentStep);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });

    /* ---------------- Form Submit Validation ---------------- */
    const form = qs('#gkp-clone-form');
    if (form) {
        form.addEventListener('submit', function (e) {
            // Final validation before actual submit
            if (currentStep !== 4) {
                e.preventDefault();
                alert('Please complete all steps before submitting.');
                return false;
            }

            // Let the form submit naturally
            return true;
        });
    }

    /* ---------------- Color Picker Sync ---------------- */
    document.querySelectorAll('input[type="color"]').forEach(picker => {
        const text = picker.parentElement.querySelector('input[type="text"]');
        if (!text) return;

        picker.addEventListener('input', e => text.value = e.target.value);
        text.addEventListener('input', e => {
            if (/^#[0-9A-F]{6}$/i.test(e.target.value)) {
                picker.value = e.target.value;
            }
        });
    });

    /* ---------------- Step Handling ---------------- */
    function updateStep(step) {
        clearError();
        document.querySelectorAll('.form-step').forEach(s => s.classList.add('hidden'));

        if (step === 2) {
            const tpl = qs('input[name="template"]:checked')?.value;
            qs(`.form-step[data-step="2"][data-template="${tpl}"]`)
                ?.classList.remove('hidden');
        } else if (step === 4) {
            qs('#review-summary').innerHTML = buildReview();
            qs('[data-step="4"]').classList.remove('hidden');
        } else {
            qs(`[data-step="${step}"]`)?.classList.remove('hidden');
        }

        renderProgress(step);
    }

    function updateTemplateSelection() {
        if (currentStep === 2) updateStep(2);
    }

    function validateStep() {
        if (currentStep === 1) {
            if (!authorSelect.value) {
                showError('Please select an author.');
                return false;
            }
            if (!qs('input[name="template"]:checked')) {
                showError('Please select a template');
                return false;
            }
        }
        if (currentStep === 3) {
            const title = qs('input[name="branding[site_title]"]');
            if (!title || !title.value.trim()) {
                showError('Site title is required.');
                return false;
            } else {
                clearError();
            }
        }
        return true;
    }

    /* ---------------- Progress Bar ---------------- */
    function renderProgress(current) {
        const steps = [
            'Author Info',
            'Template Content',
            'Branding',
            'Review & Submit'
        ];

        let html = `
		<div class="bg-white rounded-2xl border border-gray-200 p-3 h-full flex flex-col">
			<h3 class="font-bold text-lg mb-6 text-gray-900">Progress</h3>
			<div class="relative flex-1 flex">
				<!-- Vertical line (aligned to circles) -->
				<div class="absolute left-5 top-5 bottom-5 w-px bg-gray-200"></div>
				<div class="flex flex-col justify-between flex-1">
	    `;

        steps.forEach((title, i) => {
            const idx = i + 1;
            const isDone = idx < current;
            const isActive = idx === current;

            html += `
			<div class="relative flex items-start gap-4">
				<!-- Step circle -->
				<div class="relative z-10 w-10 h-10 rounded-full flex items-center justify-center font-bold
					${isDone ? 'bg-green-600 text-white' :
                    isActive ? 'bg-blue-600 text-white' :
                        'bg-gray-200 text-gray-500'}">
					${isDone ? '✓' : idx}
				</div>

				<!-- Step text -->
				<div class="pt-1">
					<div class="text-sm font-semibold ${isActive ? 'text-blue-700' :
                    isDone ? 'text-gray-900' :
                        'text-gray-500'
                }">
						${title}
					</div>

					${isActive ? `
						<div class="text-xs text-gray-500 mt-1">
							Current step
						</div>` : ''}
				</div>
			</div>
		`;
        });

        html += `
				</div>
			</div>
		</div>
	`;

        const container = document.getElementById('progress-container');
        if (container) {
            container.innerHTML = html;
        }
    }

    /* ---------------- Review Summary ---------------- */
    function buildReview() {
        const authorNameVal = authorName?.value || '—';

        // collect all book titles
        const bookInputs = document.querySelectorAll('input[name="book_titles[]"]');
        const bookTitlesArr = [...bookInputs]
            .map(i => i.value.trim())
            .filter(Boolean);

        const bookTitleVal = bookTitlesArr.length
            ? bookTitlesArr.join(', ')
            : '—';

        const tpl = qs('input[name="template"]:checked')?.value || '—';
        const siteTitle = qs('input[name="branding[site_title]"]')?.value || '—';

        return `
            <div class="space-y-4">
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <h3 class="font-bold text-lg mb-3 text-gray-900">Author Information</h3>
                    <p class="text-sm mb-1"><strong>Name:</strong> ${authorNameVal}</p>
                    <p class="text-sm"><strong>Books:</strong> ${bookTitleVal}</p>
                </div>
                
                <div class="bg-purple-50 border border-purple-200 rounded-xl p-6">
                    <h3 class="font-bold text-lg mb-3 text-gray-900">Template</h3>
                    <p class="text-sm">
                        <strong>${tpl.charAt(0).toUpperCase() + tpl.slice(1)}</strong> template
                    </p>
                </div>
                
                <div class="bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="font-bold text-lg mb-3 text-gray-900">Branding</h3>
                    <p class="text-sm"><strong>Site Title:</strong> ${siteTitle}</p>
                </div>
            </div>
        `;
    }


    /* ---------------- Media Uploader ---------------- */
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.gkp-upload-image');
        if (!btn) return;

        e.preventDefault();

        const wrap = btn.closest('.space-y-3');
        const input = wrap?.querySelector('.gkp-image-url');

        if (!input) return;

        if (typeof wp === 'undefined' || !wp.media) {
            alert('WordPress media library not available');
            return;
        }

        const frame = wp.media({
            title: 'Select or Upload Image',
            button: { text: 'Use this image' },
            library: { type: 'image' },
            multiple: false
        });

        frame.on('select', function () {
            const img = frame.state().get('selection').first().toJSON();
            input.value = img.url;
        });

        frame.open();
    });

    // add book title
    addBooktitle()
    // add social links 
    addSocialLinks();
});

function addSocialLinks() {
    const addSocialBtn = document.getElementById('add-social-link');

    if (addSocialBtn) {
        addSocialBtn.addEventListener('click', () => {
            addCustomSocialField();
        });
    }

    function addCustomSocialField(platform = '', url = '') {
        const container = document.getElementById('social-links-container');
        if (!container) return;

        const key = platform || `custom_${Date.now()}`;

        const wrapper = document.createElement('div');
        wrapper.className = 'space-y-2 border border-gray-200 rounded-xl p-4 relative';

        wrapper.innerHTML = `
       <button
            type="button"
            class="absolute top-2 right-2 remove-social
                    inline-flex items-center rounded-full
                    border border-red-300 px-3 mr-2 py-1
                    text-sm font-medium text-red-600
                    hover:bg-red-50 hover:text-red-700
                    transition focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-1"
            >
            Remove
        </button>

        <label class="text-xs font-bold text-gray-700">Platform Name</label>
        <input type="text"
            class="w-full h-9 px-3 rounded-lg border border-gray-300 text-sm social-platform"
            placeholder="e.g. threads, mastodon, github"
            value="${platform}">

        <label class="text-xs font-bold text-gray-700">Profile URL</label>
        <input type="url"
            class="w-full h-9 px-3 rounded-lg border border-gray-300 text-sm social-url"
            placeholder="https://"
            value="${url}">
    `;

        container.appendChild(wrapper);

        syncSocialInputs(wrapper);
    }

    /* Keep name="social_links[key]" in sync */
    function syncSocialInputs(wrapper) {
        const platformInput = wrapper.querySelector('.social-platform');
        const urlInput = wrapper.querySelector('.social-url');

        function updateName() {
            const key = platformInput.value
                .toLowerCase()
                .replace(/[^a-z0-9_]/g, '');

            urlInput.name = key ? `social_links[${key}]` : '';
        }

        platformInput.addEventListener('input', updateName);
        updateName();

        wrapper.querySelector('.remove-social').addEventListener('click', () => {
            wrapper.remove();
        });
    }

}

function addBooktitle() {
    const addBookBtn = document.getElementById('add-book-title');

    if (addBookBtn) {
        addBookBtn.addEventListener('click', () => {
            addBookTitleField();
        });
    }

    function addBookTitleField(value = '') {
        const container = document.getElementById('book-title-container');
        if (!container) return;

        const wrapper = document.createElement('div');
        wrapper.className = 'flex items-center gap-2 mb-2'; // flex row, gap between input & button

        wrapper.innerHTML = `
            <input type="text"
                name="book_titles[]"
                value="${value}"
                placeholder="Book Title"
                class="flex-1 h-10 px-4 py-3 rounded-lg bg-gray-50 border-2 border-gray-200">
            <button
                type="button"
                class="remove-book 
                       inline-flex items-center rounded-full h-10 px-4 py-3
                       border border-red-300 px-3 py-1
                       text-sm font-medium text-red-600
                       hover:bg-red-50 hover:text-red-700
                       transition focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-1"
            >
                Remove
            </button>
        `;

        wrapper.querySelector('.remove-book').addEventListener('click', () => {
            wrapper.remove();
        });

        container.appendChild(wrapper);
    }

}


function showError(message) {
    const errorBox = document.getElementById('form-error');
    if (!errorBox) return;

    errorBox.textContent = message;
    errorBox.classList.remove('hidden');

    errorBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function clearError() {
    console.log('clearError');
    const errorBox = document.getElementById('form-error');
    if (!errorBox) return;

    errorBox.textContent = '';
    errorBox.classList.add('hidden');
}

// input url validation
function validateUrlField(input) {
    const value = input.value.trim();
    // allow empty fields
    if (!value) {
        return true;
    }

    const urlPattern = /^(https?:\/\/)([a-z0-9-]+\.)+[a-z]{2,}(\/.*)?$/i;

    if (!urlPattern.test(value)) {
        alert('Please enter a valid URL (e.g. https://example.com)');
        return false;
    }

    return true;
}