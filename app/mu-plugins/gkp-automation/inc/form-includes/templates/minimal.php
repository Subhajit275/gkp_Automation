<!-- STEP 2: Template Content (Minimal) -->
<div class="form-step hidden" data-step="2" data-template="minimal">
    <!-- Home Page -->
    <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-admin-home text-3xl text-white mb-4"></span>
            <h2 class="text-2xl font-bold text-white m-0 flex-1">Home Page</h2>
            <span class="px-4 py-2 bg-white/20 backdrop-blur-sm text-white rounded-full text-sm font-bold uppercase tracking-wide">Minimal Template</span>
        </div>
        <div class="p-8 space-y-6">
            <!-- Hero Section -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-gray-300">
                    <span class="bg-gradient-to-br from-blue-600 to-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg">1</span>
                    <h3 class="text-xl font-bold text-gray-900 m-0">Hero Section</h3>
                </div>
                <div class="grid grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 text-sm">Media URL</label>
                        <div class="space-y-3">
                            <input type="url" onblur="validateUrlField(this)"
                                name="minimal[home][section1][media]"
                                class="gkp-image-url w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                placeholder="https://example.com/media.png">

                            <button type="button"
                                class="gkp-upload-image inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                                <span class="dashicons dashicons-upload"></span>
                                Upload / Select
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-gray-800 mb-2 text-sm">Title</label>
                        <input type="text" name="minimal[home][section1][title]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2 text-sm">Sub Title</label>
                    <input type="text" name="minimal[home][section1][subtitle]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 text-sm">Content</label>
                    <textarea name="minimal[home][section1][content]" rows="4" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                </div>
            </div>

            <!-- CTAs Section -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-gray-300">
                    <span class="bg-gradient-to-br from-blue-600 to-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg">2</span>
                    <h3 class="text-xl font-bold text-gray-900 m-0">Call To Actions</h3>
                </div>
                <div class="grid grid-cols-3 gap-6">
                    <?php for ($cta = 1; $cta <= 3; $cta++) : ?>
                        <div class="space-y-3 border-2 border-gray-300 rounded-lg p-4">
                            <label class="block font-semibold text-gray-800 mb-2 text-sm">CTA <?php echo $cta; ?></label>
                            <input type="text" name="minimal[home][section2][cta<?php echo $cta; ?>_text]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Button Text">
                            <input type="url" onblur="validateUrlField(this)" name="minimal[home][section2][cta<?php echo $cta; ?>_link]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Button Link ex: https://example.com">
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <!-- Reviews with Ratings -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-gray-300">
                    <span class="bg-gradient-to-br from-blue-600 to-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg">3</span>
                    <h3 class="text-xl font-bold text-gray-900 m-0">Reviews (with Ratings)</h3>
                </div>
                <?php for ($i = 1; $i <= 6; $i++) : ?>
                    <div class="bg-white border-2 border-gray-200 rounded-lg p-3 mb-4 hover:shadow-md transition-shadow">
                        <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-4 m-0">Review <?php echo $i; ?></h4>
                        <div class="grid grid-cols-12 gap-6 mb-4 items-start">
                            <!-- Left Column: Title + Rating -->
                            <div class="col-span-5 space-y-4">
                                <div class="">
                                    <label class="block font-semibold text-gray-800 mb-2 text-sm">Review Title</label>
                                    <input type="text" name="minimal[home][section3][review<?php echo $i; ?>][title]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                </div>
                                <div>
                                    <label class="block font-semibold text-gray-800 mb-2 text-sm">Rating</label>
                                    <select name="minimal[home][section3][review<?php echo $i; ?>][rating]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                                        <option value="">Select rating</option>
                                        <option value="5">(5 stars)</option>
                                        <option value="4.5">(4.5 stars)</option>
                                        <option value="4">(4 stars)</option>
                                        <option value="3.5">(3.5 stars)</option>
                                        <option value="3">(3 stars)</option>
                                        <option value="2.5">(2.5 stars)</option>
                                        <option value="2">(2 stars)</option>
                                        <option value="1.5">(1.5 stars)</option>
                                        <option value="1">(1 star)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column: Content -->
                            <div class="col-span-7">
                                <label class="block font-semibold text-gray-800 mb-2 text-sm">Review Content</label>
                                <textarea name="minimal[home][section3][review<?php echo $i; ?>][content]" rows="4" class="w-full px-4 py-3 h-[125px]  border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                            </div>
                        </div>

                    </div>
                <?php endfor; ?>
            </div>

            <!-- Reviews without Ratings -->
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-gray-300">
                    <span class="bg-gradient-to-br from-blue-600 to-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg">4</span>
                    <h3 class="text-xl font-bold text-gray-900 m-0">Reviews (without Ratings)</h3>
                </div>
                <?php for ($i = 1; $i <= 2; $i++) : ?>
                    <div class="bg-white border-2 border-gray-200 rounded-lg p-5 mb-4 hover:shadow-md transition-shadow">
                        <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-4 m-0">Review <?php echo $i; ?></h4>
                        <div class="mb-4">
                            <label class="block font-semibold text-gray-800 mb-2 text-sm">Review Title</label>
                            <input type="text" name="minimal[home][section4][review<?php echo $i; ?>][title]" class="w-full h-10  px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block font-semibold text-gray-800 mb-2 text-sm">Review Content</label>
                            <textarea name="minimal[home][section4][review<?php echo $i; ?>][content]" rows="3" class="w-full h-[150px]  px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </div>

    <!-- About the Author (continuation from minimal template) -->
    <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-businessman text-3xl text-white mb-3"></span>
            <h2 class="text-2xl font-bold text-white m-0">About the Author Page</h2>
        </div>
        <div class="p-8 space-y-6">
            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-gray-300">
                    <span class="bg-gradient-to-br from-blue-600 to-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg">1</span>
                    <h3 class="text-xl font-bold text-gray-900 m-0">Author Bio Section</h3>
                </div>
                <div class="mb-6">
                    <label class="block font-semibold text-gray-800 mb-2 text-sm">Author Photo URL</label>
                    <div class="space-y-3">
                        <input type="url" onblur="validateUrlField(this)"
                            name="minimal[about_author][section1][photo]"
                            class="gkp-image-url w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="https://example.com/image.png">

                        <button type="button"
                            class="gkp-upload-image inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold hover:bg-blue-700 transition">
                            <span class="dashicons dashicons-upload"></span>
                            Upload / Select Image
                        </button>
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 text-sm">Content</label>
                    <textarea name="minimal[about_author][section1][content]" rows="6" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                </div>
            </div>

            <div class="bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200 rounded-xl p-6">
                <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-gray-300">
                    <span class="bg-gradient-to-br from-blue-600 to-blue-700 text-white w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-lg">2</span>
                    <h3 class="text-xl font-bold text-gray-900 m-0">Video Section</h3>
                </div>
                <div>
                    <label class="block font-semibold text-gray-800 mb-2 text-sm">YouTube Video URL</label>
                    <input type="url" onblur="validateUrlField(this)"name="minimal[about_author][section2][youtube_url]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" placeholder="https://youtube.com/watch?v=...">
                </div>
            </div>
        </div>
    </div>

    <!-- About the Press -->
    <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-media-document text-3xl text-white mb-3"></span>
            <h2 class="text-2xl font-bold text-white m-0">About the Press Page</h2>
        </div>
        <div class="p-8">
            <div class="mb-6">
                <label class="block font-semibold text-gray-800 mb-2 text-sm">Title</label>
                <input type="text" name="minimal[about_press][title]" class="w-full h-10 px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
            </div>
            <div>
                <label class="block font-semibold text-gray-800 mb-2 text-sm">Content</label>
                <textarea name="minimal[about_press][content]" rows="8" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
            </div>
        </div>
    </div>

    <!-- Gallery -->
    <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-pink-600 to-pink-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-format-gallery text-3xl text-white mb-2"></span>
            <h2 class="text-2xl font-bold text-white m-0">Gallery Page</h2>
        </div>

        <div class="p-6">
            <?php for ($i = 1; $i <= 2; $i++) : ?>
                <div class="bg-gray-50 border border-gray-200 rounded-md p-5 mb-5">

                    <div class="flex items-center gap-3 mb-5">
                        <h3 class="text-lg text-gray-900 m-0">
                            Gallery Item <?php echo $i; ?>
                        </h3>
                    </div>

                    <!-- Image field -->
                    <div class="mb-5 space-y-3">
                        <label class="block font-semibold text-gray-900 mb-2 text-sm">
                            Image
                        </label>

                        <input
                            type="text"
                            name="minimal[gallery][content<?php echo $i; ?>][image]"
                            class="gkp-image-url w-full h-10 px-3.5 py-2.5 border border-gray-300 rounded bg-gray-100 text-sm"
                            placeholder="Image URL will appear here">

                        <button
                            type="button"
                            class="gkp-upload-image inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded text-sm font-semibold hover:bg-blue-700 transition">
                            <span class="dashicons dashicons-upload"></span>
                            Upload / Select Image
                        </button>
                    </div>

                    <!-- Caption -->
                    <div>
                        <label class="block font-semibold text-gray-900 mb-2 text-sm">
                            Caption
                        </label>
                        <input
                            type="text"
                            name="minimal[gallery][content<?php echo $i; ?>][caption]"
                            class="w-full h-10 px-3.5 py-2.5 border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-sm"
                            placeholder="Optional caption text">
                    </div>

                </div>
            <?php endfor; ?>
        </div>

    </div>

    <!-- Contact Page -->
    <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-teal-600 to-teal-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-email text-3xl text-white mb-2"></span>
            <h2 class="text-2xl font-bold text-white m-0">Contact Page</h2>
        </div>
        <div class="p-8">
            <div class="bg-blue-50 border-2 border-blue-200 border-l-4 border-l-blue-600 rounded-xl p-5 flex gap-4">
                <span class="dashicons dashicons-info text-blue-600 text-2xl flex-shrink-0 mb-2"></span>
                <div>
                    <strong class="block mb-2 text-gray-900 text-lg">Contact Form</strong>
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