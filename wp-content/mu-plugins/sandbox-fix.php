<?php
/*
Plugin Name: CodeSandbox Loopback Fix
Description: Fixes REST API, Site Health, and Cron 401 errors by forcing internal requests to localhost.
Author: CodeSandbox Starter
Version: 1.0
*/

// Hook into the HTTP API to fix the "Loopback" and "401" errors
add_action( 'http_api_curl', function( $handle, $r, $url ) {
    // Get the current site domain (e.g., abc-8001.csb.app)
    $site_host = parse_url( get_site_url(), PHP_URL_HOST );
    $request_host = parse_url( $url, PHP_URL_HOST );

    // If WordPress is trying to talk to itself...
    if ( $site_host && $request_host && $site_host === $request_host ) {
        // 1. Force cURL to resolve the domain to 127.0.0.1 (Localhost) on Port 80
        // This bypasses the external CodeSandbox Proxy entirely.
        curl_setopt( $handle, CURLOPT_RESOLVE, array( "{$site_host}:80:127.0.0.1" ) );

        // 2. Force the connection to be HTTP (since the internal container uses port 80, not 443)
        // We replace "https://" with "http://" effectively for the internal request.
        curl_setopt( $handle, CURLOPT_URL, str_replace( 'https:', 'http:', $url ) );

        // 3. Disable SSL verification (Since we are routing internally to IP, SSL won't match)
        curl_setopt( $handle, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $handle, CURLOPT_SSL_VERIFYHOST, false );
    }
}, 10, 3 );

// Force WordPress to recognize the environment is HTTPS (Fixes mixed content errors)
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}