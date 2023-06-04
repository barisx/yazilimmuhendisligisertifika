<?php
/**
 * Plugin Name: Custom PDF Downloads
 * Description: Allows users to search and download PDF files.
 * Version: 1.0.0
 * Author: Baris 'barisx' Senyerli
 * Author URI: https://linkedin.barisx.com
 * Text Domain: custom-pdf-downloads
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @package Custom_PDF_Downloads
 */

// Register a custom endpoint for PDF downloads
function custom_pdf_downloads_init() {
    add_rewrite_endpoint( 'pdf-download', EP_ROOT );
}
add_action( 'init', 'custom_pdf_downloads_init' );

// Handle the PDF download request
function custom_pdf_downloads_handler() {
    if ( ! isset( $_GET['pdf_id'] ) ) {
        return;
    }

    $pdf_id = $_GET['pdf_id'];
    $pdf_path = WP_CONTENT_DIR . '/sertifika/' . $pdf_id . '.pdf';

    if ( file_exists( $pdf_path ) ) {
        header( 'Content-Type: application/pdf' );
        header( 'Content-Disposition: attachment; filename="' . $pdf_id . '.pdf"' );
        readfile( $pdf_path );
        exit;
    } else {
        wp_die( 'PDF not found.' );
    }
}
add_action( 'template_redirect', 'custom_pdf_downloads_handler' );
