<div class="py-3">
    <div class="mx-auto">
        <!-- Header -->
        <div class="mb-3 flex justify-center">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 mb-1">Clone Submissions</h1>
                <p class="text-sm text-gray-600">All submitted author site clone requests</p>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Template</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Clone Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Submitted</th>
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">
                        <?php if (empty($submissions)) : ?>
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No clone submissions found.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($submissions as $row) : ?>
                                <?php
                                global $wpdb;

                                $table = $wpdb->base_prefix . 'gkp_site_requests';

                                $clone_row = $wpdb->get_row(
                                    $wpdb->prepare(
                                        "SELECT * FROM {$table} WHERE entry_id = %d LIMIT 1",
                                        $row->id
                                    )
                                );
                                $clone_status = '_';
                                if ($clone_row) {
                                    $clone_status = $clone_row->status ?? '_'; // completed
                                }

                                ?>
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                        #<?php echo esc_html($row->id); ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">
                                            <?php echo esc_html($row->author_name); ?>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php echo esc_html($row->author_email); ?>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                <?php echo $row->template === 'minimal'
                                                    ? 'bg-purple-100 text-purple-700'
                                                    : 'bg-blue-100 text-blue-700'; ?>">
                                            <?php echo esc_html(ucfirst($row->template)); ?>
                                        </span>
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                <?php echo $row->status === 'approved'
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-yellow-100 text-yellow-800'; ?>">
                                            <?php echo esc_html(ucfirst($row->status)); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                                <?php echo $row->status === 'approved'
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-yellow-100 text-yellow-800'; ?>">
                                            <?php echo esc_html(ucfirst($clone_status)); ?>
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <?php echo esc_html(date('M d, Y H:i', strtotime($row->created_at))); ?>
                                    </td>

                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="<?php echo network_admin_url('admin.php?page=gkp-clone-view&id=' . $row->id); ?>"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md
                                                      bg-blue-600 text-white hover:text-white hover:bg-gray-700 transition" target="_blank">
                                            View
                                        </a>

                                        <!-- <a href="<?php echo wp_nonce_url(
                                                            network_admin_url('admin.php?page=gkp-clone-submissions&delete=' . $row->id),
                                                            'gkp_delete_submission_' . $row->id
                                                        ); ?>"
                                            onclick="return confirm('Are you sure you want to delete this submission?');"
                                            class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-md
                                                      bg-red-600 text-white transition">
                                            Delete
                                        </a> -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>