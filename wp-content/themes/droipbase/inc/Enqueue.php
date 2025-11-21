<?php

/**
 * Handles enqueueing all scripts and styles
 *
 * @package droipbase
 */

namespace DROIPBASE;

defined('ABSPATH') || exit;

/**
 * Enqueue class
 */
class Enqueue
{

	/**
	 * Register default hooks and actions for WordPress
	 */
	public function __construct()
	{
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
	}

	/**
	 * Enqueue general scripts.
	 */
	public function enqueue_scripts()
	{
		// css.
		wp_enqueue_style('droipbase-main', get_template_directory_uri() . '/assets/css/style.min.css', array(), filemtime(DROIPBASE_ASSETS_PATH . '/css/style.min.css'), 'all');

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}
	}


	/**
	 * Add inline data in scripts
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public static function scripts_data()
	{
		$data = array(
			'ajax_url'    => admin_url('admin-ajax.php'),
			'nonce_value' => wp_create_nonce('droipbase_nonce'),
		);
		return apply_filters('droipbase_inline_script_data', $data);
	}
}
