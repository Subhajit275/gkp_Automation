<div class="wrap mx-auto px-4 py-2">

    <h1 class="text-3xl font-bold text-red-900">
        Submission #<?php echo esc_html($submission->id); ?>
        ( Template: <?php echo esc_html($submission->template); ?> )
    </h1>

    <div class="text-lg font-semibold mt-6">Clone Status / Error:</div>
    <div class="w-full h-32 flex gap-3 bg-white border rounded-lg p-6 mb-3">
        <?php
        global $wpdb;
        $table = $wpdb->base_prefix . 'gkp_site_requests';
        $clone_row = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM {$table} WHERE entry_id = %d LIMIT 1",
                $submission->id
            )
        );
        ?>
        <div class="w-1/2">
            <p><strong>Status:</strong> <?php echo esc_html($clone_row->status ?? '_'); ?></p>
            <p><strong>Created At:</strong> <?php echo esc_html($clone_row->created_at ?? '_'); ?></p>
            <p><strong>Updated At:</strong> <?php echo esc_html($clone_row->processed_at ?? '_'); ?></p>
        </div>
        <div class="w-1/2">
            <strong>Error: </strong><?php echo esc_html($clone_row->error ?? '_'); ?>
        </div>
    </div>
    <hr>
    <div class="mt-5">
        <strong class="text-lg font-semibold">Submission Details:</strong>
        <div class="flex flex-col md:flex-row gap-3 w-full mt-1">
            <!-- AUTHOR -->
            <div class="bg-white border rounded-lg p-6 mb-6 flex-1">
                <h2 class="text-lg font-semibold mb-2">Author</h2>
                <p><strong>Name:</strong> <?php echo esc_html($submission->author_name); ?></p>
                <p><strong>Email:</strong> <?php echo esc_html($submission->author_email); ?></p>
            </div>

            <!-- BOOKS -->
            <div class="bg-white border rounded-lg p-6 mb-6 flex-1">
                <h2 class="text-lg font-semibold mb-2">Books</h2>
                <?php if ($common_view_data['books']) : ?>
                    <ul class="list-disc pl-5">
                        <?php foreach ($common_view_data['books'] as $book) : ?>
                            <li><?php echo esc_html($book); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <p class="text-sm text-gray-500">No books</p>
                <?php endif; ?>
            </div>

            <!-- SOCIAL LINKS -->
            <div class="bg-white border rounded-lg p-6 mb-6 flex-1">
                <h2 class="font-semibold mb-3">Social Links</h2>
                <?php foreach ($common_view_data['social_links'] as $platform => $url) :
                    if (!$url) continue; ?>
                    <div class="flex gap-3">
                        <a href="<?php echo esc_url($url); ?>" target="_blank" class="block text-blue-600">
                            <?php echo esc_html(ucfirst($platform)); ?>
                        </a>
                        <p><strong>Link: </strong><?php echo esc_html($url); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- BRANDING -->
        <div class="bg-white border rounded-lg p-6 mb-6">
            <h2 class="text-lg font-bold mb-3 text-center mb-3 text-blue-900">Branding</h2>
            <div class="flex gap-3 justify-between">
                <div class="m-2">
                    <p class="m-2"><strong>Site Title:</strong> <?php echo esc_html($common_view_data['branding']['site_title'] ?? '—'); ?></p>
                    <p class="m-2"><strong>Tagline:</strong> <?php echo esc_html($common_view_data['branding']['site_tagline'] ?? '—'); ?></p>
                    <div class="flex gap-3">
                        <p class="m-2"><strong>Primary Color:</strong> <?php echo esc_html($common_view_data['branding']['primary_color'] ?? '—'); ?></p>
                        <input disabled type="color" class="m-2" value="<?php echo esc_html($common_view_data['branding']['primary_color']); ?>">
                    </div>
                    <div class="flex gap-3">
                        <p class="m-2"><strong>Secondary Color:</strong> <?php echo esc_html($common_view_data['branding']['secondary_color'] ?? '—'); ?></p>
                        <input disabled type="color" class="m-2" value="<?php echo esc_html($common_view_data['branding']['secondary_color']); ?>">
                    </div>
                </div>
                <div class="m-2">
                    <p><strong>Logo:</strong></p>
                    <?php if (!empty($common_view_data['branding']['logo'])) : ?>
                        <img src="<?php echo esc_url($common_view_data['branding']['logo']); ?>" class="mb-3 max-w-md" width="200" height="200">
                    <?php endif; ?>
                    <a
                        href="<?php echo esc_url($common_view_data['branding']['logo']); ?>"
                        class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:text-white hover:bg-gray-700"
                        target="_blank">
                        Open in New Tab
                    </a>
                </div>
            </div>
        </div>

        <!-- TEMPLATE BLOCKS -->
        <?php foreach ($template_view_data as $block) : ?>

            <?php switch ($block['type']):

                case 'hero': ?>
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="mb-2 text-lg font-bold mb-3 text-center text-blue-900">Hero</h2>
                        <div class="flex gap-3 justify-between">
                            <div class="m-2">
                                <p class="font-medium m-2"><strong>Title: </strong> <?php echo esc_html($block['data']['title'] ?? ''); ?></p>
                                <p class="font-medium m-2"><strong>Sub Title: </strong> <?php echo esc_html($block['data']['subtitle'] ?? ''); ?></p>
                                <p class="text-sm m-2"><strong>Content: </strong> <?php echo esc_html($block['data']['content'] ?? ''); ?></p>
                            </div>
                            <div class="m-2">
                                <?php if (!empty($block['data']['media'])) : ?>
                                    <img src="<?php echo esc_url($block['data']['media']); ?>" class="mb-3 max-w-md" width="200" height="200">
                                <?php endif; ?>
                                <a
                                    href="<?php echo esc_url($block['data']['media']); ?>"
                                    class="inline-block px-4 py-2 bg-gray-500 text-white rounded hover:text-white hover:bg-gray-700"
                                    target="_blank">
                                    Open in New Tab
                                </a>
                            </div>
                        </div>
                    </div>
                <?php break;

                case 'cta_group': ?>
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-bold mb-3 text-center mb-3 text-blue-900">CTAs</h2>
                        <div class="flex width-full justify-between">
                            <?php for ($i = 1; $i <= 3; $i++) :
                                $t = $block['data']["cta{$i}_text"] ?? '';
                                $l = $block['data']["cta{$i}_link"] ?? '';
                                if ($t && $l) : ?>
                                    <div class="h-20 text-center flex flex-col justify-center w-1/3 m-2 bg-gray-100 border border-gray-200 rounded-lg">
                                        <p class="font-medium m-2"><strong>Text: </strong> <?php echo esc_html($t); ?></p>
                                        <p class="text-sm m-2"><strong>Link: </strong> <?php echo esc_url($l); ?></p>
                                    </div>
                            <?php endif;
                            endfor; ?>
                        </div>
                    </div>
                <?php break;

                case 'reviews_with_rating': ?>
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-bold mb-3 text-center mb-3 text-blue-900">Reviews with Rating</h2>
                        <?php foreach ($block['data'] as $review) :
                            if (!array_filter($review)) continue; ?>
                            <div class="border p-3 mb-3 flex gap-3 justify-between rounded-xl">
                                <div class="m-2">
                                    <p class="font-medium m-2"><strong>Title: </strong> <?php echo esc_html($review['title'] ?? ''); ?></p>
                                    <p class="text-sm m-2"><strong>Rating: </strong> <?php echo esc_html($review['rating'] ?? ''); ?>/5</p>
                                </div>
                                <div class="m-2 w-1/2">
                                    <p class="text-sm m-2"><strong>Content: </strong><?php echo esc_html($review['content'] ?? ''); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php break;

                case 'reviews_plain': ?>
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-bold mb-3 text-center mb-3 text-blue-900">Reviews (Plain)</h2>
                        <div class="flex gap-3">
                            <?php foreach ($block['data'] as $review) :
                                if (!array_filter($review)) continue; ?>
                                <div class="w-1/2 border p-3 mb-3 rounded-xl">
                                    <p class="font-medium m-2"><strong>Title: </strong> <?php echo esc_html($review['title'] ?? ''); ?></p>
                                    <p class="text-sm m-2"><strong>Content: </strong><?php echo esc_html($review['content'] ?? ''); ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php break;
                case 'about_author': ?>
                    <?php if ($block['type'] == 'about_author') : ?>

                        <div class="bg-white border rounded-lg p-6 mb-6">

                            <h2 class="text-lg font-bold text-center text-blue-900 mb-4">
                                About Author
                            </h2>
                            <!-- Section 1 : Author Info -->
                            <?php if (!empty($block['data']['section1'])) : ?>
                                <div class=" mb-6 flex gap-3">

                                    <div class="w-1/2 p-2 border rounded-xl">
                                        <strong>Content:</strong>
                                        <?php if (!empty($block['data']['section1']['content'])) : ?>
                                            <p class="text-sm">
                                                <?php echo esc_html($block['data']['section1']['content']); ?>
                                            </p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="w-1/2 border rounded-xl p-5 flex justify-between">
                                        <div class="mt-2">
                                            <strong>Youtube Video:</strong>
                                            <!-- Section 2 : YouTube Video -->
                                            <?php if (!empty($block['data']['section2']['youtube_url'])) : ?>
                                                <div class="rounded-lg overflow-hidden">
                                                    <a href="<?php echo esc_url($block['data']['section2']['youtube_url']); ?>" class="text-blue-500 underline"><?php echo esc_url($block['data']['section2']['youtube_url']); ?></a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Author Photo:</strong>
                                            <?php if (!empty($block['data']['section1']['photo'])) : ?>
                                                <img
                                                    src="<?php echo esc_url($block['data']['section1']['photo']); ?>"
                                                    class="mb-4 mt-4 h-[200px] w-[200px] object-cover"
                                                    alt="Author Photo">
                                                <a
                                                    href="<?php echo esc_url($block['data']['section1']['photo']); ?>"
                                                    class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:text-white hover:bg-gray-800"
                                                    target="_blank">
                                                    Open in New Tab
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                        </div>
                    <?php endif; ?>

                <?php break;
                case 'about_press': ?>

                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-bold mb-3 text-center mb-3 text-blue-900">
                            About Press
                        </h2>
                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- TEXT -->
                            <div class="flex-1">
                                <p><span class="font-bold m-2">Title : </span> <?php echo esc_html($block['data']['title'] ?? ''); ?></p>
                                <div class="m-2">
                                    <span class="font-bold">Content : </span>
                                    <p class="w-full h-[150px]" rows="3" readonly>
                                        <?php echo esc_html($block['data']['content'] ?? ''); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php break;
                case 'gallery': ?>

                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-bold mb-3 text-center mb-3 text-blue-900">
                            Gallery
                        </h2>
                        <div class="flex flex-col md:flex-row gap-4 justify-between">
                            <div class="flex w-full flex-col md:flex-row gap-4 rounded-lg border border-gray-200 p-4">
                                <!-- TEXT -->
                                <div class="flex-1">
                                    <span class="font-bold">Caption : </span>
                                    <p><?php echo esc_html($block['data']['content1']['caption'] ?? ''); ?></p>

                                </div>
                                <!-- MEDIA -->
                                <div class="flex-1 md:text-right">
                                    <?php if (!empty($block['data']['content1']['image'])) : ?>
                                        <img
                                            src="<?php echo esc_url($block['data']['content1']['image']); ?>"
                                            class="mb-3 max-w-full md:max-w-md ml-auto"
                                            alt="" width="200" height="200">
                                        <a
                                            href="<?php echo esc_url($block['data']['content1']['image']); ?>"
                                            class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:text-white hover:bg-gray-800"
                                            target="_blank">
                                            Open in New Tab
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="flex w-full flex-col md:flex-row gap-4 rounded-lg border border-gray-200 p-4">
                                <!-- TEXT -->
                                <div class="flex-1">
                                    <span class="font-bold">Caption : </span>
                                    <p><?php echo esc_html($block['data']['content2']['caption'] ?? ''); ?></p>

                                </div>
                                <!-- MEDIA -->
                                <div class="flex-1 md:text-right">
                                    <?php if (!empty($block['data']['content2']['image'])) : ?>
                                        <img
                                            src="<?php echo esc_url($block['data']['content2']['image']); ?>"
                                            class="mb-3 max-w-full md:max-w-md ml-auto"
                                            alt="" width="200" height="200">
                                        <a
                                            href="<?php echo esc_url($block['data']['content1']['image']); ?>"
                                            class="inline-block px-4 py-2 bg-gray-600 text-white rounded hover:text-white hover:bg-gray-800"
                                            target="_blank">
                                            Open in New Tab
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php break;

                case 'simple_section': ?>
                    <div class="bg-white border rounded-lg p-6 mb-6">
                        <h2 class="text-lg font-bold mb-3 text-center mb-3 text-blue-900">
                            Section <?php echo esc_html($block['index']); ?>
                        </h2>

                        <div class="flex flex-col md:flex-row gap-4">
                            <!-- TEXT -->
                            <div class="flex-1">
                                <p><span class="font-bold m-2">Title : </span> <?php echo esc_html($block['data']['title'] ?? ''); ?></p>
                                <div class="m-2">
                                    <span class="font-bold">Content : </span>
                                    <textarea class="w-full h-[150px]" rows="3" readonly>
                                    <?php echo esc_html($block['data']['content'] ?? ''); ?>
                                </textarea>
                                </div>
                            </div>
                            <!-- MEDIA -->
                            <div class="flex-1 md:text-right">
                                <?php if (!empty($block['data']['media'])) : ?>
                                    <img
                                        src="<?php echo esc_url($block['data']['media']); ?>"
                                        class="mb-3 max-w-full md:max-w-md ml-auto"
                                        alt="" width="200" height="200">
                                    <a
                                        href="<?php echo esc_url($block['data']['media']); ?>"
                                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:text-white hover:bg-gray-600"
                                        target="_blank">
                                        Open in New Tab
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

            <?php break;

            endswitch; ?>

        <?php endforeach; ?>
    </div>
</div>