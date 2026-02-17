<?php
if (! defined('ABSPATH')) exit;

/**
 * Placeholder → payload key mapping
 */
function gkp_placeholder_map()
{

	$intake_data = get_option('gkp_intake_data');
	$template_data = get_option('gkp_template_data');
	$data = [$intake_data, $template_data];
	$content_data = json_encode($data, JSON_PRETTY_PRINT);
	$decoded = json_decode($content_data, true);
	$book_arr = $decoded[0]['book_title'] ?? '';
	$book_list = json_encode($book_arr);
	
	return [
		'{{GKP_TEMPLATE}}'         => $decoded[1]['style'] ?? '',
		'{{GKP_AUTHOR_NAME}}'      => $decoded[0]['author_name'] ?? '',
		'{{GKP_AUTHOR_TAGLINE}}'   => 'do not have any tagline',
		'{{GKP_BOOK_TITLE}}'       => $book_list ?? '',
		'{{GKP_CONTACT_EMAIL}}'    => $decoded[0]['contact_email'] ?? '',

		// Social placeholders
		'{{GKP_SOCIAL_INSTAGRAM}}' => $decoded[0]['social_instagram'] ?? '',
		'{{GKP_SOCIAL_FACEBOOK}}'  => $decoded[0]['social_facebook'] ?? '',
		'{{GKP_SOCIAL_TWITTER}}'   => $decoded[0]['social_twitter'] ?? '',
		'{{GKP_SOCIAL_LINKEDIN}}'  => $decoded[0]['social_linkedin'] ?? '',
		'{{GKP_SOCIAL_YOUTUBE}}'   => $decoded[0]['social_youtube'] ?? '',
		'{{GKP_SOCIAL_WEBSITE}}'   => $decoded[0]['social_website'] ?? '',

		// Branding Placeholder

		'{{GKP_SITE_TITLE}}' => $decoded[0]['site_title'] ?? '',
		'{{GKP_SITE_TAGLINE}}' => $decoded[0]['site_tagline'] ?? '',
		'{{GKP_SITE_LOGO}}' => $decoded[0]['logo'] ?? '',
		'{{GKP_SITE_PRIMARY_COLOR}}' => $decoded[0]['primary_color'] ?? '',
		'{{GKP_SITE_SECONDARY_COLOR}}' => $decoded[0]['secondary_color'] ?? '',
		'{{GKP_SITE_TITLE_FONT}}' => $decoded[0]['title_font'] ?? '',
		'{{GKP_SITE_BODY_FONT}}' => $decoded[0]['body_font'] ?? '',



		// Simple Template Placeholders

		'{{GKP_SIMPLE_MEDIA_1}}' => $decoded[1]['content'][1]['media'] ?? '',
		'{{GKP_SIMPLE_TITLE_1}}' => $decoded[1]['content'][1]['title'] ?? '',
		'{{GKP_SIMPLE_CONTENT_1}}' => $decoded[1]['content'][1]['content'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_TEXT_1}}' => $decoded[1]['content'][1]['cta_primary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_LINK_1}}' => $decoded[1]['content'][1]['cta_primary_link'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_TEXT_1}}' => $decoded[1]['content'][1]['cta_secondary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_LINK_1}}' => $decoded[1]['content'][1]['cta_secondary_link'] ?? '',

		'{{GKP_SIMPLE_MEDIA_2}}' => $decoded[1]['content'][2]['media'] ?? '',
		'{{GKP_SIMPLE_TITLE_2}}' => $decoded[1]['content'][2]['title'] ?? '',
		'{{GKP_SIMPLE_CONTENT_2}}' => $decoded[1]['content'][2]['content'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_TEXT_2}}' => $decoded[1]['content'][2]['cta_primary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_LINK_2}}' => $decoded[1]['content'][2]['cta_primary_link'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_TEXT_2}}' => $decoded[1]['content'][2]['cta_secondary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_LINK_2}}' => $decoded[1]['content'][2]['cta_secondary_link'] ?? '',

		'{{GKP_SIMPLE_MEDIA_3}}' => $decoded[1]['content'][3]['media'] ?? '',
		'{{GKP_SIMPLE_TITLE_3}}' => $decoded[1]['content'][3]['title'] ?? '',
		'{{GKP_SIMPLE_CONTENT_3}}' => $decoded[1]['content'][3]['content'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_TEXT_3}}' => $decoded[1]['content'][3]['cta_primary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_LINK_3}}' => $decoded[1]['content'][3]['cta_primary_link'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_TEXT_3}}' => $decoded[1]['content'][3]['cta_secondary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_LINK_3}}' => $decoded[1]['content'][3]['cta_secondary_link'] ?? '',

		'{{GKP_SIMPLE_MEDIA_4}}' => $decoded[1]['content'][4]['media'] ?? '',
		'{{GKP_SIMPLE_TITLE_4}}' => $decoded[1]['content'][4]['title'] ?? '',
		'{{GKP_SIMPLE_CONTENT_4}}' => $decoded[1]['content'][4]['content'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_TEXT_4}}' => $decoded[1]['content'][4]['cta_primary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_PRIMARY_LINK_4}}' => $decoded[1]['content'][4]['cta_primary_link'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_TEXT_4}}' => $decoded[1]['content'][4]['cta_secondary_text'] ?? '',
		'{{GKP_SIMPLE_CTA_SECONDARY_LINK_4}}' => $decoded[1]['content'][4]['cta_secondary_link'] ?? '',

		// Mininal Template Placeholder

		'{{GKP_MINIMAL_HOME_MEDIA}}' => $decoded[1]['content']['home']['section1']['media'] ?? '',
		'{{GKP_MINIMAL_HOME_TITLE}}' => $decoded[1]['content']['home']['section1']['title'] ?? '',
		'{{GKP_MINIMAL_HOME_SUBTITLE}}' => $decoded[1]['content']['home']['section1']['subtitle'] ?? '',
		'{{GKP_MINIMAL_HOME_CONTENT}}' => $decoded[1]['content']['home']['section1']['content'] ?? '',
		'{{GKP_MINIMAL_HOME_CTA1_TEXT}}' => $decoded[1]['content']['home']['section2']['cta1_text'] ?? '',
		'{{GKP_MINIMAL_HOME_CTA1_LINK}}' => $decoded[1]['content']['home']['section2']['cta1_text'] ?? '',
		'{{GKP_MINIMAL_HOME_CTA2_TEXT}}' => $decoded[1]['content']['home']['section2']['cta2_text'] ?? '',
		'{{GKP_MINIMAL_HOME_CTA2_LINK}}' => $decoded[1]['content']['home']['section2']['cta2_text'] ?? '',
		'{{GKP_MINIMAL_HOME_CTA3_TEXT}}' => $decoded[1]['content']['home']['section2']['cta3_text'] ?? '',
		'{{GKP_MINIMAL_HOME_CTA3_LINK}}' => $decoded[1]['content']['home']['section2']['cta3_text'] ?? '',

		'{{GKP_MINIMAL_REVIEW1_TITLE}}' => $decoded[1]['content']['home']['section3']['review1']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW1_RATING}}' => $decoded[1]['content']['home']['section3']['review1']['rating'] ?? '',
		'{{GKP_MINIMAL_REVIEW1_CONTENT}}' => $decoded[1]['content']['home']['section3']['review1']['content'] ?? '',

		'{{GKP_MINIMAL_REVIEW2_TITLE}}' => $decoded[1]['content']['home']['section3']['review2']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW2_RATING}}' => $decoded[1]['content']['home']['section3']['review2']['rating'] ?? '',
		'{{GKP_MINIMAL_REVIEW2_CONTENT}}' => $decoded[1]['content']['home']['section3']['review2']['content'] ?? '',

		'{{GKP_MINIMAL_REVIEW3_TITLE}}' => $decoded[1]['content']['home']['section3']['review3']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW3_RATING}}' => $decoded[1]['content']['home']['section3']['review3']['rating'] ?? '',
		'{{GKP_MINIMAL_REVIEW3_CONTENT}}' => $decoded[1]['content']['home']['section3']['review3']['content'] ?? '',

		'{{GKP_MINIMAL_REVIEW4_TITLE}}' => $decoded[1]['content']['home']['section3']['review4']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW4_RATING}}' => $decoded[1]['content']['home']['section3']['review4']['rating'] ?? '',
		'{{GKP_MINIMAL_REVIEW4_CONTENT}}' => $decoded[1]['content']['home']['section3']['review4']['content'] ?? '',

		'{{GKP_MINIMAL_REVIEW5_TITLE}}' => $decoded[1]['content']['home']['section3']['review5']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW5_RATING}}' => $decoded[1]['content']['home']['section3']['review5']['rating'] ?? '',
		'{{GKP_MINIMAL_REVIEW5_CONTENT}}' => $decoded[1]['content']['home']['section3']['review5']['content'] ?? '',

		'{{GKP_MINIMAL_REVIEW6_TITLE}}' => $decoded[1]['content']['home']['section3']['review6']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW6_RATING}}' => $decoded[1]['content']['home']['section3']['review6']['rating'] ?? '',
		'{{GKP_MINIMAL_REVIEW6_CONTENT}}' => $decoded[1]['content']['home']['section3']['review6']['content'] ?? '',

		'{{GKP_MINIMAL_REVIEW1_NO_RATING_TITLE}}' => $decoded[1]['content']['home']['section4']['review1']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW1_NO_RATING_CONTENT}}' => $decoded[1]['content']['home']['section4']['review1']['content'] ?? '',

		'{{GKP_MINIMAL_REVIEW2_NO_RATING_TITLE}}' => $decoded[1]['content']['home']['section4']['review2']['title'] ?? '',
		'{{GKP_MINIMAL_REVIEW2_NO_RATING_CONTENT}}' => $decoded[1]['content']['home']['section4']['review2']['content'] ?? '',

		'{{GKP_MINIMAL_ABOUT_PRESS_PHOTO}}' => $decoded[1]['content']['about_press']['title'] ?? '',
		'{{GKP_MINIMAL_ABOUT_PRESS_CONTENT}}' => $decoded[1]['content']['about_press']['content'] ?? '',

		'{{GKP_MINIMAL_GALLERY_IMAGE1}}' => $decoded[1]['content']['gallery']['content1']['image'] ?? '',
		'{{GKP_MINIMAL_GALLERY_IMAGE1_CAP}}' => $decoded[1]['content']['gallery']['content1']['caption'] ?? '',

		'{{GKP_MINIMAL_GALLERY_IMAGE2}}' => $decoded[1]['content']['gallery']['content2']['image'] ?? '',
		'{{GKP_MINIMAL_GALLERY_IMAGE2_CAP}}' => $decoded[1]['content']['gallery']['content2']['caption'] ?? '',
	];
}





// function gkp_placeholder_map_shortcode()
// {

// 	$map = gkp_placeholder_map();
// 	$output = '';

// 	foreach ($map as $key => $value) {
// 		$output .= '<p><strong>' . esc_html($key) . '</strong>: ' . esc_html($value) . '</p>';
// 	}

// 	return $output;
// }

// add_shortcode('hello', 'gkp_placeholder_map_shortcode');


function gkp_render_placeholders($content)
{
	$map = gkp_placeholder_map();

	if (empty($map)) {
		return $content;
	}

	foreach ($map as $placeholder => $value) {
		$content = str_replace(
			$placeholder,
			esc_html($value),
			$content
		);
	}

	return $content;
}
add_filter('the_content', 'gkp_render_placeholders');
