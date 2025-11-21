<?php

/**
 * Handles loading all the necessary files
 *
 * @package droipbase
 */

defined('ABSPATH') || exit;

/**
 * Require all constants variable
 *
 * @package droipbase
 */
require_once __DIR__ . '/constants.php';

/**
 * droipbase spl_autoloader
 *
 * @param String $class_name description.
 *
 * @return void
 */
function droipbase_spl_autoloader($class_name)
{
	if (! class_exists($class_name)) {
		$class_name = preg_replace(
			array('/([a-z])([A-Z])/', '/\\\/'),
			array('$1$2', DIRECTORY_SEPARATOR),
			$class_name
		);
		$class_name = str_replace('DROIPBASE' . DIRECTORY_SEPARATOR, '/inc' . DIRECTORY_SEPARATOR, $class_name);
		$file_name  = DROIPBASE_PATH . $class_name . '.php';

		if (file_exists($file_name)) {
			require_once $file_name;
		}
	}
}

spl_autoload_register('droipbase_spl_autoloader');

add_filter('pre_set_site_transient_update_themes', 'droipbase_check_for_update');
function droipbase_check_for_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }

    $theme_slug = 'droipbase'; // Folder name of your theme
    $current_version = wp_get_theme($theme_slug)->get('Version');

    $response = wp_remote_get('https://droip.s3.us-east-1.amazonaws.com/dist/droipbase-builds/package.json');

    if (!is_wp_error($response)) {
        $remote = json_decode(wp_remote_retrieve_body($response));

        if (
            version_compare($current_version, $remote->version, '<') &&
            isset($remote->download_url)
        ) {
            $transient->response[$theme_slug] = array(
                'theme'       => $theme_slug,
                'new_version' => $remote->version,
                'url'         => $remote->homepage ?? '',
                'package'     => $remote->download_url,
            );
        }
    }

    return $transient;
}

new DROIPBASE\Init();
