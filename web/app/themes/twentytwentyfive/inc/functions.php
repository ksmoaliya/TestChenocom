<?php
// ========================
// Charger font-awesome css
// ========================
function mytheme_enqueue_fontawesome() {
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_fontawesome');
add_action('enqueue_block_editor_assets', 'mytheme_enqueue_fontawesome');

// ========================
// Charger CPT
// ========================
require_once get_template_directory() . '/inc/post-types/agenda.php';

// ========================
// Charger ACF Fields
// ========================
require_once get_template_directory() . '/inc/acf/AgendaFields.php';

// ========================
// Charger le JS du bloc Gutenberg
// ========================
function mytheme_enqueue_agenda_block() {
    // On ne charge que dans l'éditeur
    wp_enqueue_script(
        'mytheme-agenda-block',
        get_template_directory_uri() . '/blocks/agenda/agenda.js',
        array(
            'wp-blocks',            // registerBlockType
            'wp-element',           // createElement
            'wp-block-editor',      // InspectorControls + components modernes
            'wp-components',        // PanelBody, RangeControl
            'wp-server-side-render' // indispensable pour render_callback PHP
        ),
        filemtime(get_template_directory() . '/blocks/agenda/agenda.js'),
        true
    );

}
add_action('enqueue_block_editor_assets', 'mytheme_enqueue_agenda_block');

// ========================
// Charger les blocs
// ========================
require_once get_template_directory() . '/inc/blocks/RegisterBlocks.php';

// ========================
// Helper : formatage date
// ========================
if (!function_exists('format_agenda_date')) {
    /**
     * Formate une date ACF ou string
     *
     * @param string $date Date brute (Y-m-d ou d/m/Y)
     * @param string $format Format PHP/WordPress date_i18n
     * @return string
     */
    function format_agenda_date($date, $format = 'j M.')
    {
        if (empty($date)) return '';

        // 1️⃣ ACF date standard (Y-m-d)
        $d = DateTime::createFromFormat('Y-m-d', $date);

        // 2️⃣ Format européen (d/m/Y)
        if (!$d) {
            $d = DateTime::createFromFormat('d/m/Y', $date);
        }

        // 3️⃣ Fallback avec strtotime
        if (!$d) {
            $timestamp = strtotime($date);
            if (!$timestamp) return '';
            return date_i18n($format, $timestamp);
        }

        // Retour final formaté
        return date_i18n($format, $d->getTimestamp());
    }
}