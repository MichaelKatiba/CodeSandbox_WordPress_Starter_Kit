<?php

/**
 * Handles all the classes initialization
 *
 * @package droipbase
 */

namespace DROIPBASE;

defined('ABSPATH') || exit;

/**
 * Init class
 *
 * @package droipbase
 */
final class Init
{

	/**
	 * Store all the classes inside an array.
	 *
	 * @return void
	 */
	public function __construct()
	{
		new Setup();
		new Enqueue();
	}
}
