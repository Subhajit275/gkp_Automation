document.addEventListener('DOMContentLoaded', () => {

	const selectWrapper = document.querySelector('.gkp-author-select');
	if (!selectWrapper) return;

	const select = selectWrapper.querySelector('select');
	if (!select) return;

	// Create loader
	const loader = document.createElement('span');
	loader.className = 'gkp-loader';
	loader.innerHTML = 'Loading author data...';
	loader.style.display = 'none';
	loader.style.marginTop = '8px';

	selectWrapper.appendChild(loader);

	function showLoader() {
		loader.style.display = 'inline-block';
		select.disabled = true;
		selectWrapper.classList.add('gkp-loading');
	}

	function hideLoader() {
		loader.style.display = 'none';
		select.disabled = false;
		selectWrapper.classList.remove('gkp-loading');
	}

	fetch(GKP_API.root + 'authors',
		{
			credentials: 'same-origin',
			headers: {
				'X-WP-Nonce': GKP_API.nonce
			}
		})
		.then(res => res.json())
		.then(authors => {
			select.innerHTML = '<option value="">Select Author</option>';
			authors.forEach(a => {
				select.innerHTML += `<option value="${a.id}">${a.name}</option>`;
			});
		});

	select.addEventListener('change', () => {
		if (!select.value) return;
		showLoader();

		fetch(GKP_API.root + `author/${select.value}`, 
			{
				credentials: 'same-origin',
				headers: {
					'X-WP-Nonce': GKP_API.nonce
				}
			})
			.then(res => res.json())
			.then(author => {
				setField('.gkp-author-name input', author.name);
				setField('.gkp-book-title input', author.book_title);
				setField('.gkp-author-email input', author.email);
				setField('.gkp-template-style select', author.preferred_template);
			})
			.catch(() => {
				alert('Failed to load author details');
			})
			.finally(() => {
				hideLoader();
			});
	});

	function setField(selector, value) {
		const el = document.querySelector(selector);
		if (el && value) {
			el.value = value;
			el.dispatchEvent(new Event('change'));
		}
	}
});
