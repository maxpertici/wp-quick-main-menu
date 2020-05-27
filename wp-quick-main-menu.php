<?php
/*
Plugin Name: WP Quick Admin Main Menu
Plugin URI: https://m.pertici.fr/wp-quick-admin-main-menu
Description: Keep access to WordPress admin main menu when editing post with Gutenberg fullscreen.
Author: Maxime Pertici
Version: 0.3
Author URI: https://m.pertici.fr
Contributors:
License:      GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wp-qmm
Domain Path:  /languages
Copyright 2020 WP Quick Menu
*/

defined( 'ABSPATH' ) or	die();


function wp_qamm_script(){

	// test + toogle css class
	$script =
		"jQuery( window ).load(function() {

			const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' );
			
			if ( isFullscreenMode ) {

				jQuery('body').addClass('wp-qamm-enable');
				
				jQuery('.edit-post-header .components-button.edit-post-fullscreen-mode-close').hoverIntent(
					function(){ jQuery('body').addClass('wp-qamm-open'); }, 100,
					function(){ jQuery('body').removeClass('wp-qamm-open'); }
				);

				jQuery('#adminmenumain').hover(
					function(){ jQuery('body').addClass('wp-qamm-open'); },
					function(){ jQuery('body').removeClass('wp-qamm-open'); }
				);

			}

						
		});";

		wp_enqueue_script( 'hoverIntent' );
		wp_add_inline_script( 'wp-blocks', $script );
	}

	add_action( 'enqueue_block_editor_assets', 'wp_qamm_script' );


function wp_qamm_admin_scripts( $hook ) {

    wp_enqueue_style( 'gut-qmmm-style', plugin_dir_url( __FILE__ ) . '/wp-quick-main-menu.css', array(), false, 'all' );
}

// enqueue styles
add_action( 'admin_enqueue_scripts', 'wp_qamm_admin_scripts' );