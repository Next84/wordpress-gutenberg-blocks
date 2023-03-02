<?php

/**
 * Plugin Name:       My First Dynamic Block
 * Description:       Example static block scaffolded with Create Block tool.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-first-dynamic-block
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_my_first_dynamic_block_block_init()
{
	// Add the block to the allowed blocks list
	add_filter(
		'mh.gutenberg.allowed-blocks-list',
		static function ($blocks) {
			is_array($blocks) and $blocks[] = 'create-block/my-first-dynamic-block';
			return $blocks;
		}
	);

	register_block_type(
		__DIR__ . '/build',
		array(
			'render_callback' => 'render_content_on_the_fly'
		)
	);
}
add_action('init', 'create_block_my_first_dynamic_block_block_init');

function render_content_on_the_fly()
{
	$recent_posts = wp_get_recent_posts(array(
		'numberposts' => 1,
		'post_status' => 'publish',
	));
	if (count($recent_posts) === 0) {
		return '<div>No posts</div>';
	}
	$post = $recent_posts[0];
	$post_id = $post['ID'];

	return sprintf(
		'<div class="wp-block-create-block-my-first-dynamic-block">' .
			'<h2>Last post published</h2>' .
			'<a href="%1$s">%2$s</a>',
		esc_url(get_permalink($post_id)),
		esc_html(get_the_title($post_id)) .
			'</div>'
	);
}
