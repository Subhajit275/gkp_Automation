<!-- STEP 4: Review & Submit -->
<div class="form-step hidden" data-step="4">
    <div class="bg-white rounded-2xl shadow-lg mb-8 overflow-hidden border border-gray-200">
        <div class="bg-gradient-to-r from-green-600 to-green-700 px-8 py-6 flex items-center gap-4">
            <span class="dashicons dashicons-yes-alt text-3xl text-white mb-2"></span>
            <h2 class="text-2xl font-bold text-white m-0">Review Your Configuration</h2>
        </div>
        <div class="p-8" id="review-summary">
            <!-- Summary will be dynamically inserted by JavaScript -->
        </div>

        <!-- Custom Domain Setup -->
        <?php
        $server_ip = $_SERVER['SERVER_ADDR'] ?? '127.0.0.1';
        ?>
        <div class="mx-8 mt-2 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start gap-4">
                <span class="dashicons dashicons-info-outline text-3xl text-blue-600 mb-2"></span>
                <div>
                    <h4 class="font-bold text-blue-800 text-lg mb-2">
                        Custom Domain Setup (Optional)
                    </h4>

                    <p class="text-gray-700 mb-4 leading-relaxed">
                        If you plan to use your own custom domain, please update your domain’s DNS
                        settings <strong>after the site is created</strong>.
                    </p>

                    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4">
                        <p class="font-semibold text-gray-800 mb-2">DNS Configuration</p>

                        <ul class="text-gray-700 space-y-2 text-sm m-3">
                            <li>
                                • <strong>Record Type:</strong> A
                            </li>
                            <li>
                                • <strong>Host / Name:</strong> @ or your subdomain
                            </li>
                            <li>
                                • <strong>IP Address:</strong>
                                <span class="font-mono bg-gray-100 px-2 py-1 rounded">
                                    <?php echo esc_html($server_ip); ?>
                                </span>
                            </li>
                            <li>
                                • <strong>TTL:</strong> Auto / Default
                            </li>
                        </ul>
                        <hr>
                        <ul class="text-gray-700 space-y-2 text-sm m-3">
                            <li>
                                • <strong>Record Type:</strong> A
                            </li>
                            <li>
                                • <strong>Host / Name:</strong> www or www.subdomain
                            </li>
                            <li>
                                • <strong>IP Address:</strong>
                                <span class="font-mono bg-gray-100 px-2 py-1 rounded">
                                    <?php echo esc_html($server_ip); ?>
                                </span>
                            </li>
                            <li>
                                • <strong>TTL:</strong> Auto / Default
                            </li>
                        </ul>
                    </div>

                    <p class="text-sm text-gray-600">
                        DNS changes may take up to <strong>24 hours</strong> to fully propagate.
                        Once updated, your site will automatically start working with the custom domain.
                    </p>
                </div>
            </div>
        </div>
        <div class="flex bg-yellow-50 border border-yellow-200 rounded-xl p-6 mx-8 my-3 gap-1">
            <span class="dashicons dashicons-yes-alt text-green-600 text-xl mb-2"></span>
            <p class="font-semibold text-gray-900 pt-1">
                Ready to clone this site
            </p>
        </div>
    </div>

    <div class="flex justify-between items-center mt-8">
        <button type="button" class="prev-btn inline-flex items-center gap-3 px-8 py-4 bg-white text-gray-800 border-2 border-gray-300 rounded-xl font-bold text-lg hover:bg-gray-50 hover:border-gray-400 shadow-md hover:shadow-lg transition-all">
            <span class="dashicons dashicons-arrow-left-alt2 text-xl mb-1"></span> Back
        </button>
        <button type="submit" id="review-submit" class="inline-flex items-center gap-3 px-10 py-5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl font-bold text-xl hover:from-green-700 hover:to-green-800 shadow-2xl hover:shadow-3xl transition-all transform hover:-translate-y-1">
            <span class="dashicons dashicons-admin-multisite text-2xl mb-2"></span> Submit
        </button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('gkp-clone-form');
        const submitBtn = document.getElementById('review-submit');

        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                // Disable button immediately
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

                // Optional: change button text to show loading
                submitBtn.innerHTML = '<span class="dashicons dashicons-admin-multisite text-2xl mb-2"></span> Submitting...';
            });
        }
    });
</script>