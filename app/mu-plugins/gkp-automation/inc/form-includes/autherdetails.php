<!-- STEP 1: Author Information & Template Selection -->
<div class="form-step" data-step="1">
    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-admin-users text-3xl text-white mb-2"></span>
            <h2 class="text-2xl font-bold text-white m-0">Author Information</h2>
        </div>

        <div class="p-8 space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Select Author</label>
                <select name="author_id" id="author-select" class="w-full h-10 px-4 py-3 rounded-xl border-2 border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                    <option value="">Select Author</option>
                    <?php if (!empty($authors)) : ?>
                        <?php foreach ($authors as $author) : ?>
                            <option
                                value="<?php echo esc_attr($author->id); ?>"
                                data-name="<?php echo esc_attr($author->name); ?>"
                                data-email="<?php echo esc_attr($author->email); ?>"
                                data-books='<?php echo esc_attr($author->book_title); ?>'
                                data-social-links='<?php echo esc_attr($author->social_links); ?>'
                                data-preferred-template="<?php echo esc_attr($author->preferred_template); ?>">
                                <?php echo esc_html($author->name); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Author Name</label>
                    <input type="text" name="author_name" id="author-name" placeholder="Author Name" class="w-full h-10 px-4 py-3 rounded-lg bg-gray-50 border-2 border-gray-200">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                    <input type="email" name="author_email" id="author-email" placeholder="Email" class="w-full h-10 px-4 py-3 rounded-lg bg-gray-50 border-2 border-gray-200">
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Book Titles
                </label>
                <div id="book-title-container" class="space-y-3"></div>
                <div class="mt-4">
                    <button type="button"
                        id="add-book-title"
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-gray-500 text-white hover:bg-blue-700">
                        + Add
                    </button>
                </div>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-800 mb-3">Social Links</label>
                <div id="social-links-container" class="space-y-3"></div>
                <div class="mt-4">
                    <button type="button"
                        id="add-social-link"
                        class="px-4 py-2 text-sm font-semibold rounded-lg bg-gray-500 text-white hover:bg-blue-700">
                        + Add
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden mt-8">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-layout text-3xl text-white mb-3"></span>
            <h2 class="text-2xl font-bold text-white m-0">Select Template</h2>
        </div>

        <div class="p-6 sm:p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <label class="border-2 rounded-2xl p-8 cursor-pointer hover:border-blue-500 hover:shadow-lg transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:shadow-xl">
                <div class="text-center space-y-3">
                    <input type="radio" name="template" value="simple" checked class="hidden">
                    <h3 class="font-bold text-lg">Simple</h3>
                    <p class="text-sm text-gray-600">Multi-section landing page</p>
                </div>
            </label>

            <label class="border-2 rounded-2xl p-8 cursor-pointer hover:border-blue-500 hover:shadow-lg transition-all has-[:checked]:border-blue-600 has-[:checked]:bg-blue-50 has-[:checked]:shadow-xl">
                <div class="text-center space-y-3">
                    <input type="radio" name="template" value="minimal" class="hidden">
                    <h3 class="font-bold text-lg">Minimal</h3>
                    <p class="text-sm text-gray-600">Hero, reviews & gallery</p>
                </div>
            </label>

            <div class="border-2 border-gray-200 rounded-2xl p-8 text-center opacity-50">
                <h3 class="font-bold text-lg">Clean</h3>
                <p class="text-sm text-gray-600">Coming soon</p>
            </div>

            <div class="border-2 border-gray-200 rounded-2xl p-8 text-center opacity-50">
                <h3 class="font-bold text-lg">Elegant</h3>
                <p class="text-sm text-gray-600">Coming soon</p>
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-8">
        <button type="button" class="next-btn px-8 py-4 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl font-bold text-lg hover:from-blue-700 hover:to-blue-800 shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
            Next Step →
        </button>
    </div>
</div>