<?php
if (! defined('ABSPATH')) exit;

function gkp_get_db_tables()
{
	global $wpdb;

	$charset = $wpdb->get_charset_collate();
	$base = $wpdb->base_prefix;

	return [

		"{$base}gkp_authors" => "
			CREATE TABLE {$base}gkp_authors (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				external_id VARCHAR(100) NOT NULL,
				source VARCHAR(50) DEFAULT 'api',
				name VARCHAR(255) NOT NULL,
				email VARCHAR(255) DEFAULT NULL,
				book_title VARCHAR(255) DEFAULT NULL,
				tagline VARCHAR(255) DEFAULT NULL,
				social_links LONGTEXT DEFAULT NULL,
				preferred_template VARCHAR(50) DEFAULT 'clean',
				branding LONGTEXT DEFAULT NULL,
				raw_payload LONGTEXT NOT NULL,
				status VARCHAR(50) DEFAULT 'pending',
				created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
				updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				PRIMARY KEY (id),
				UNIQUE KEY external_id (external_id),
				KEY status (status)
			) $charset;
		",

		"{$base}gkp_site_requests" => "
			CREATE TABLE {$base}gkp_site_requests (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				entry_id BIGINT UNSIGNED NOT NULL,
				template_style VARCHAR(50),
				enable_animations TINYINT(1),
				payload LONGTEXT NOT NULL,
				status VARCHAR(20) DEFAULT 'pending',
				site_id BIGINT UNSIGNED NULL,
				error TEXT NULL,
				created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
				processed_at DATETIME NULL,
				PRIMARY KEY (id)
			) $charset;
		",

		"{$base}gkp_clone_submissions" => "
			CREATE TABLE {$base}gkp_clone_submissions (
				id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
				author_id VARCHAR(100) DEFAULT NULL,
				author_name VARCHAR(255) DEFAULT NULL,
				author_email VARCHAR(255) DEFAULT NULL,
				book_title VARCHAR(255) DEFAULT NULL,
				social_links LONGTEXT DEFAULT NULL,
				template VARCHAR(50) DEFAULT NULL,
				template_content LONGTEXT DEFAULT NULL,
				branding LONGTEXT DEFAULT NULL,
				status VARCHAR(20) DEFAULT 'pending',
				site_id BIGINT(20) UNSIGNED DEFAULT NULL,
				site_url VARCHAR(500) DEFAULT NULL,
				error TEXT DEFAULT NULL,
				created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
				processed_at DATETIME DEFAULT NULL,
				PRIMARY KEY (id),
				KEY author_id (author_id),
				KEY status (status)
			) $charset;
		",
	];
}
