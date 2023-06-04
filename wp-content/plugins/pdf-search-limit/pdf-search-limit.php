<?php
/**
 * Plugin Name: PDF Search Limit
 * Description: Limits the number of searches for PDF files.
 * Version: 1.0.0
 * Author: Baris 'barisx' Senyerli
 * Author URI: https://linkedin.barisx.com
 * Text Domain: pdf-search-limit
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package PDF_Search_Limit
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin code goes here.
add_action('wp_ajax_increase_search_count', 'increase_search_count_callback');
add_action('wp_ajax_nopriv_increase_search_count', 'increase_search_count_callback');
function increase_search_count_callback() {
    session_start();

    // Increase the search count for the current user
    if (!isset($_SESSION['search_count'])) {
        $_SESSION['search_count'] = 0;
    }
    $_SESSION['search_count']++;

    wp_die();
}