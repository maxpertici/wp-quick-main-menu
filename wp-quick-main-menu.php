<?php
/*
Plugin Name: WP Quick Admin Menu
Plugin URI: https://m.pertici.fr/wp-quick-admin-menu
Description: Keep access to WordPress main menu when editing post with gutenberg fullscreen
Author: Maxime Pertici
Version: 0.2
Author URI: https://m.pertici.fr
Contributors:
License:      GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wp-qmm
Domain Path:  /languages
Copyright 2020 WP Quick Menu
*/

defined( 'ABSPATH' ) or	die();


function wp_qam_script(){

	// test + toogle css class
	$script =
		"jQuery( window ).load(function() {

			const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' );
			
			// if ( isFullscreenMode ) { wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' ); }
			
			if ( isFullscreenMode ) {

				jQuery('body').addClass('wp-qam-enable');

				jQuery('.edit-post-header .components-button.edit-post-fullscreen-mode-close').hoverIntent(
					function(){ jQuery('body').addClass('wp-qam-open'); console.log('open'); }, 100,
					function(){ jQuery('body').removeClass('wp-qam-open'); console.log('close'); }
				);

				jQuery('#adminmenumain').hover(
					function(){ jQuery('body').addClass('wp-qam-open'); },
					function(){ jQuery('body').removeClass('wp-qam-open'); }
				);

			}

						
		});";

		wp_enqueue_script( 'hoverIntent' );
		wp_add_inline_script( 'wp-blocks', $script );
	}

	add_action( 'enqueue_block_editor_assets', 'wp_qam_script' );


function wp_qam_admin_scripts( $hook ) {

    wp_enqueue_style( 'gut-qmmm-style', plugin_dir_url( __FILE__ ) . '/wp-quick-main-menu.css', array(), false, 'all' );
}

// enqueue styles
add_action( 'admin_enqueue_scripts', 'wp_qam_admin_scripts' );