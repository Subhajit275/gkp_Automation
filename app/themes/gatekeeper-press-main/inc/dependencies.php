<?php
/**
 * Theme Dependencies
 *
 * Ensures required plugins are installed for automation workflows.
 * Currently validates NS Cloner for multisite site provisioning.
 *
 * @package Gatekeeper_Press
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'gkp_check_required_plugins' ) ) :
	/**
	 * Check required plugins for Gatekeeper Press
	 *
	 * @since Gatekeeper Press 1.0
	 *
	 * @return bool
	 */
	
	function gkp_check_required_plugins() {

		// NS Cloner function check (safe & reliable)
		$ns_cloner_active = function_exists( 'ns_cloner_request' );

		if ( ! $ns_cloner_active ) {

			add_action( 'admin_notices', function () {
				?>
				<div class="notice notice-error">
					<p>
						<strong>Gatekeeper Press Theme</strong><br>
						This theme requires the <strong>NS Cloner</strong> plugin
						for automated site creation and template cloning.
					</p>
					<p>
						<a href="<?php echo esc_url( admin_url( 'plugin-install.php?s=NS+Cloner&tab=search&type=term' ) ); ?>"
						class="button button-primary">
							Install NS Cloner
						</a>
					</p>
				</div>
				<?php
			} );

			return false;
		}

		return true;
	}
endif;

// Run dependency check early in admin
add_action( 'admin_init', 'gkp_check_required_plugins' );