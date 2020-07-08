<?php
/*
Plugin Name: WP Quick Admin Main Menu
Plugin URI: https://m.pertici.fr/wp-quick-admin-main-menu
Description: Keep access to WordPress admin main menu when editing post with Gutenberg fullscreen.
Author: Maxime Pertici
Version: 0.5.0
Author URI: https://m.pertici.fr
Contributors:
License:      GPLv2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wp-qamm
Domain Path:  /languages
Copyright 2020 WP Quick Menu
*/

defined( 'ABSPATH' ) or	die();

function wp_qamm_plugin_load(){
	// Translations
	$locale = get_locale();
	$locale = apply_filters( 'plugin_locale', $locale, 'wp-qamm' );
	load_textdomain( 'wp-qamm', WP_LANG_DIR . '/plugins/wp-qamm-' . $locale . '.mo' );
	load_plugin_textdomain( 'wp-qamm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'plugins_loaded', 'wp_qamm_plugin_load' );


function wp_qamm_script(){

	// test + toogle css class
	$script =
		"jQuery( window ).load(function() {

			// launch
			jQuery('body').addClass('wp-qamm-enable');
			
			function checkForChanges(){

				// console.log(jQuery('body').hasClass('is-fullscreen-mode'));

				if( jQuery('body').hasClass('is-fullscreen-mode') ){

					jQuery('.edit-post-header .components-button.edit-post-fullscreen-mode-close').hoverIntent(
						function(){ jQuery('body').addClass('wp-qamm-open'); }, 100,
						function(){ jQuery('body').removeClass('wp-qamm-open'); }
					);

					jQuery('#adminmenumain').hover(
						function(){ jQuery('body').addClass('wp-qamm-open'); },
						function(){ jQuery('body').removeClass('wp-qamm-open'); }
					);
					
					setTimeout( checkForChanges, 500 );

				}else{
					
					jQuery('.edit-post-header .components-button.edit-post-fullscreen-mode-close').unbind();
					jQuery('#adminmenumain').unbind();

					setTimeout( checkForChanges, 500 );
				}
			}

			jQuery( checkForChanges) ;
						
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