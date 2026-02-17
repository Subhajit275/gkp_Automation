<!-- STEP 3: Branding -->
<div class="form-step hidden" data-step="3">
	<div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
		<div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6 flex items-center gap-4">
			<span class="dashicons dashicons-admin-appearance text-3xl text-white mb-2"></span>
			<h2 class="text-2xl font-bold text-white m-0">Branding & Design</h2>
		</div>
		<div class="p-8 space-y-6">
			<!-- Site Identity -->
			<div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
				<h3 class="text-xl font-bold text-gray-900 mb-6 m-0">Site Identity</h3>
				<div class="mb-6">
					<label class="block font-semibold text-gray-800 mb-2 text-sm">Site Title <span class="text-red-600">*</span></label>
					<input type="text" name="branding[site_title]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required placeholder="Author Name - Book Title">
				</div>
				<div class="mb-6">
					<label class="block font-semibold text-gray-800 mb-2 text-sm">Site Tagline</label>
					<input type="text" name="branding[site_tagline]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Your book's tagline or slogan">
				</div>
				<div>
					<label class="block font-semibold text-gray-800 mb-2 text-sm">Logo URL</label>
					<div class="space-y-3">
						<input type="url" onblur="validateUrlField(this)"
							name="branding[logo]"
							class="gkp-image-url w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
							placeholder="https://example.com/logo.png">

						<button type="button"
							class="gkp-upload-image inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
							<span class="dashicons dashicons-upload"></span>
							Upload / Select Image
						</button>

						<p class="mt-2 text-xs text-gray-600">Recommended size: 250x80px (PNG or SVG)</p>
					</div>
				</div>
			</div>

			<!-- Color Scheme -->
			<div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
				<h3 class="text-xl font-bold text-gray-900 mb-6 m-0">Color Scheme</h3>
				<div class="grid grid-cols-2 gap-6">
					<div>
						<label class="block font-semibold text-gray-800 mb-2 text-sm">Primary Color</label>
						<div class="flex gap-3 items-center">
							<input type="color" name="branding[primary_color]" value="#2271b1" class="w-16 h-12 border-2 border-gray-300 rounded-lg cursor-pointer">
							<input type="text" value="#2271b1" class="flex-1 h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="#2271b1">
						</div>
						<p class="mt-2 text-xs text-gray-600">Used for buttons, links, and accents</p>
					</div>
					<div>
						<label class="block font-semibold text-gray-800 mb-2 text-sm">Secondary Color</label>
						<div class="flex gap-3 items-center">
							<input type="color" name="branding[secondary_color]" value="#72aee6" class="w-16 h-12 border-2 border-gray-300 rounded-lg cursor-pointer">
							<input type="text" value="#72aee6" class="flex-1 h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="#72aee6">
						</div>
						<p class="mt-2 text-xs text-gray-600">Used for hover states and secondary elements</p>
					</div>
				</div>
			</div>

			<!-- Typography -->
			<div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
				<h3 class="text-xl font-bold text-gray-900 mb-6 m-0">Typography</h3>
				<div class="grid grid-cols-2 gap-6">
					<div>
						<label class="block font-semibold text-gray-800 mb-2 text-sm">Title Font</label>
						<select name="branding[title_font]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
							<option value="Playfair Display">Playfair Display</option>
							<option value="Merriweather">Merriweather</option>
							<option value="Lora">Lora</option>
							<option value="Roboto Slab">Roboto Slab</option>
							<option value="Montserrat">Montserrat</option>
							<option value="Open Sans">Open Sans</option>
						</select>
					</div>
					<div>
						<label class="block font-semibold text-gray-800 mb-2 text-sm">Body Font</label>
						<select name="branding[body_font]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
							<option value="Open Sans">Open Sans</option>
							<option value="Roboto">Roboto</option>
							<option value="Lato">Lato</option>
							<option value="Source Sans Pro">Source Sans Pro</option>
							<option value="Raleway">Raleway</option>
							<option value="PT Sans">PT Sans</option>
						</select>
					</div>
				</div>
				<p class="mt-4 text-xs text-gray-600 m-0">Fonts will be loaded from Google Fonts</p>
			</div>
		</div>
	</div>

	<div class="flex justify-between items-center mt-8">
		<button type="button" class="prev-btn inline-flex items-center gap-3 px-8 py-4 bg-white text-gray-800 border-2 border-gray-300 rounded-xl font-bold text-lg hover:bg-gray-50 hover:border-gray-400 shadow-md hover:shadow-lg transition-all">
			<span class="dashicons dashicons-arrow-left-alt2 text-xl mb-1"></span> Back
		</button>
		<button type="button" class="next-btn inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold text-lg hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
			Next: Review & Submit <span class="dashicons dashicons-arrow-right-alt2 text-xl"></span>
		</button>
	</div>
</div>