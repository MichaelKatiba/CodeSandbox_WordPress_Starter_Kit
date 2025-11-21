<?php

/**
 * Handles initial setup
 *
 * @package droipbase
 */

namespace DROIPBASE;

defined('ABSPATH') || exit;

/**
 * Setup class
 */
class Setup
{
	/**
	 * Register default hooks and actions for WordPress
	 */
	public function __construct()
	{
		add_action('after_setup_theme', array($this, 'setup'));
	}

	/**
	 * Theme supports and setup
	 *
	 * @return void
	 */
	public function setup()
	{

		// Load theme textdomain.
		load_theme_textdomain('droipbase', get_template_directory() . '/languages');

		add_theme_support('title-tag');
		add_theme_support('align-wide');
		add_theme_support('custom-logo');
		add_theme_support('post-thumbnails');

		// Add html5 support.
		add_theme_support(
			'html5',
			array(
				'caption',
				'gallery',
				'search-form',
				'comment-form',
				'comment-list',
				'style',
				'script',
			)
		);

		// Custom background support.
		add_theme_support(
			'custom-background',
			apply_filters(
				'droipbase_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support('automatic-feed-links');
		add_theme_support('wp-block-styles');
		add_theme_support('responsive-embeds');
		add_theme_support('custom-header', array());
	}
}
