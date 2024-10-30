<?php
/**
 * Plugin Name:     Click To Tweet Block
 * Plugin URI:		https://wordpress.org/plugins/click-to-tweeet-block/
 * Description:     Gutenberg block to add a quote for visitors to tweet via Twitter.
 * Version:         1.0.0
 * Author:          Achal Jain
 * License:         GPL-2.0-or-later
 * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:     ib-click-to-tweet
 */

/**
 * Registers all block assets so that they can be enqueued through the block editor
 * in the corresponding context.
 *
 * @see https://developer.wordpress.org/block-editor/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function ideabox_click_to_tweet_block_init() {
	$dir = dirname( __FILE__ );

	$script_asset_path = "$dir/build/index.asset.php";
	if ( ! file_exists( $script_asset_path ) ) {
		throw new Error(
			'You need to run `npm start` or `npm run build` for the "ideabox/click-to-tweet" block first.'
		);
	}
	$index_js     = 'build/index.js';
	$script_asset = require( $script_asset_path );
	wp_register_script(
		'ideabox-click-to-tweet-block-editor',
		plugins_url( $index_js, __FILE__ ),
		$script_asset['dependencies'],
		$script_asset['version']
	);
	wp_set_script_translations( 'ideabox-click-to-tweet-block-editor', 'ib-click-to-tweet' );

	$editor_css = 'build/index.css';
	wp_register_style(
		'ideabox-click-to-tweet-block-editor',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'build/style-index.css';
	wp_register_style(
		'ideabox-click-to-tweet-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'ideabox/click-to-tweet', array(
		'editor_script' => 'ideabox-click-to-tweet-block-editor',
		'editor_style'  => 'ideabox-click-to-tweet-block-editor',
		'style'         => 'ideabox-click-to-tweet-block',
	) );
}
add_action( 'init', 'ideabox_click_to_tweet_block_init' );
