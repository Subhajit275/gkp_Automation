<!-- STEP 2: Template Content (Simple) -->
<div class="form-step hidden" data-step="2" data-template="simple">
    <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-admin-home text-3xl text-white mb-4"></span>
            <h2 class="text-2xl font-bold text-white m-0 flex-1">Home Page Content</h2>
            <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-bold uppercase tracking-wide">Simple Template</span>
        </div>
        <div class="p-8 space-y-6">
            <?php for ($i = 1; $i <= 5; $i++) : ?>
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-gray-300">
                        <span class="bg-gradient-to-br from-blue-600 to-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold text-lg shadow-lg"><?php echo $i; ?></span>
                        <h3 class="text-xl font-bold text-gray-900 m-0">Section <?php echo $i; ?></h3>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2 text-sm">Media URL</label>
                            <div class="space-y-3">
                                <input type="url" onblur="validateUrlField(this)"
                                    name="simple[<?php echo $i; ?>][media]"
                                    class="gkp-image-url w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                    placeholder="https://example.com/image.jpg">

                                <button type="button"
                                    class="gkp-upload-image inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                    <span class="dashicons dashicons-upload"></span>
                                    Upload / Select
                                </button>
                            </div>
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2 text-sm">Section Title</label>
                            <input type="text" name="simple[<?php echo $i; ?>][title]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Enter section title">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold text-gray-800 mb-2 text-sm">Content</label>
                        <textarea name="simple[<?php echo $i; ?>][content]" rows="4" class="h-[125px] w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Enter section content..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="block font-semibold text-gray-800 mb-2 text-sm">Primary CTA</label>
                            <input type="text" name="simple[<?php echo $i; ?>][cta_primary_text]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Button Text (e.g., Buy Now)">
                            <input type="url" onblur="validateUrlField(this)" name="simple[<?php echo $i; ?>][cta_primary_link]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Button Link (e.g., https://...)">
                        </div>
                        <div class="space-y-3">
                            <label class="block font-semibold text-gray-800 mb-2 text-sm">Secondary CTA</label>
                            <input type="text" name="simple[<?php echo $i; ?>][cta_secondary_text]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Button Text (e.g., Learn More)">
                            <input type="url" onblur="validateUrlField(this)" name="simple[<?php echo $i; ?>][cta_secondary_link]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Button Link (e.g., https://...)">
                        </div>
                    </div>
                </div>
            <?php endfor; ?>

            <div class="bg-blue-50 border-2 border-blue-200 border-l-4 border-l-blue-600 rounded-xl p-5 flex gap-4">
                <span class="dashicons dashicons-email text-blue-600 text-2xl flex-shrink-0"></span>
                <div>
                    <strong class="block mb-2 text-gray-900 text-lg">Get In Touch Section</strong>
                    <p class="text-sm text-gray-700 m-0">Contact form will be automatically added (no input required)</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mt-8">
        <button type="button" class="prev-btn inline-flex items-center gap-3 px-8 py-4 bg-white text-gray-800 border-2 border-gray-300 rounded-xl font-bold text-lg hover:bg-gray-50 hover:border-gray-400 shadow-md hover:shadow-lg transition-all">
            <span class="dashicons dashicons-arrow-left-alt2 text-xl mb-1"></span> Back
        </button>
        <button type="button" class="next-btn inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold text-lg hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
            Next: Branding <span class="dashicons dashicons-arrow-right-alt2 text-xl"></span>
        </button>
    </div>
</div>
