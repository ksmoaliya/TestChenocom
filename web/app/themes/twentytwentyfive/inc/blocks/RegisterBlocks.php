<?php

// Register block + style
add_action('init', function () {

    $style_path = get_template_directory() . '/blocks/agenda/style.css';
    $style_uri  = get_template_directory_uri() . '/blocks/agenda/style.css';
    wp_register_style(
        'mytheme-agenda-style',
        $style_uri,
        [],
        file_exists($style_path) ? filemtime($style_path) : false
    );

    // Register block
    register_block_type('mytheme/agenda', [
        'attributes' => [
            'number' => [
                'type'    => 'number',
                'default' => 5
            ],
            'title' => [
                'type'    => 'string',
                'default' => ''
            ]
        ],
        'render_callback' => 'mytheme_render_agenda_block',
        'style'        => 'mytheme-agenda-style',
        'editor_style' => 'mytheme-agenda-style',
    ]);
});


// Render callback
function mytheme_render_agenda_block($attributes)
{
    $number = !empty($attributes['number']) ? intval($attributes['number']) : 5;
    $title  = !empty($attributes['title']) ? sanitize_text_field($attributes['title']) : '';

    $template = locate_template('blocks/agenda/render.php');

    if (!$template) {
        return '<p>Template agenda introuvable</p>';
    }

    ob_start();

    $data = [
        'number' => $number,
        'title'  => $title,
    ];

    extract($data);

    include $template;

    return ob_get_clean();
}