<?php

namespace App\PostTypes;

class AgendaPostType
{
    public static function register()
    {
        // Labels CPT
        $labels = [
            'name'               => 'Agenda',
            'singular_name'      => 'Événement',
            'add_new'            => 'Ajouter',
            'add_new_item'       => 'Ajouter un événement',
            'edit_item'          => 'Modifier l’événement',
            'new_item'           => 'Nouvel événement',
            'view_item'          => 'Voir l’événement',
            'search_items'       => 'Rechercher un événement',
            'not_found'          => 'Aucun événement trouvé',
            'menu_name'          => 'Agenda',
        ];

        // Custom Post Type
        register_post_type('agenda', [
            'labels'             => $labels,
            'public'             => true,
            'menu_icon'          => 'dashicons-calendar',
            'supports'           => ['title', 'thumbnail'],
            'show_in_rest'       => true,
            'has_archive'        => true,
            'rewrite'            => ['slug' => 'agenda'],
            'menu_position'      => 5,
            'publicly_queryable' => true,
            'show_ui'            => true,
        ]);

        // Labels taxonomy
        $taxonomy_labels = [
            'name'              => 'Catégories Agenda',
            'singular_name'     => 'Catégorie Agenda',
            'search_items'      => 'Rechercher',
            'all_items'         => 'Toutes les catégories',
            'parent_item'       => 'Catégorie parent',
            'parent_item_colon' => 'Catégorie parent :',
            'edit_item'         => 'Modifier',
            'update_item'       => 'Mettre à jour',
            'add_new_item'      => 'Ajouter une catégorie',
            'new_item_name'     => 'Nouvelle catégorie',
            'menu_name'         => 'Catégories',
        ];

        // Taxonomy
        register_taxonomy('agenda_category', ['agenda'], [
            'labels'            => $taxonomy_labels,
            'public'            => true,
            'hierarchical'      => true,
            'show_in_rest'      => true,
            'show_admin_column' => true,
            'rewrite'           => ['slug' => 'agenda-category'],
            'show_ui'           => true,
        ]);
    }
}

add_action('init', [AgendaPostType::class, 'register']);