<?php

/**
 * Validate IMAP IP access
 *
 * @param string $host
 * @param int $port
 * @param string $username
 * @param string $password
 * @param bool $ssl
 * @return bool|string If bool true then credentials are valid. If bool false then the reason for validation failure could not be determined. Else if string, a web login url was returned
 */
function validateIMAPIPAccess($host, $port, $username, $password, $ssl = true)
{
    if (!defined('CURLE_LOGIN_DENIED')) {
        define('CURLE_LOGIN_DENIED', 67);
    }

    // Format credentials
    $credentials = urlencode($username) . ':' . urlencode($password);
    // Build url
    $url = vsprintf('imap%s://%s@%s', [$ssl ? 's' : '', $credentials, $host]);

    $ch = curl_init();

    // Start output buffer
    ob_start();
    $out = fopen('php://output', 'w');

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PORT, $port);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_STDERR, $out);

    // Fetch response
    curl_exec($ch);

    fclose($out);
    $debug = ob_get_clean();
    $errorNo = curl_errno($ch);

    // Close curl handle
    curl_close($ch);

    if ($errorNo === CURLE_LOGIN_DENIED && preg_match('/WEBALERT (https:\/\/.*)] Web login required/i', $debug, $matches) && isset($matches[1])) {
        return $matches[1];
    } elseif ($errorNo === CURLE_OK) {
        return true;
    }

    return false;
}