<?php

namespace App\Fields;

use StoutLogic\AcfBuilder\FieldsBuilder;

class AgendaFields
{
    public static function register()
    {
        add_action('acf/init', [self::class, 'fields']);
    }

    public static function fields()
    {
        $agenda = new FieldsBuilder('agenda_fields', [
            'title' => 'Agenda',
        ]);

        $agenda
            ->setLocation('post_type', '==', 'agenda')

            ->addDatePicker('date_debut', [
                'label' => 'Date début',
                'required' => 1,
                'display_format' => 'd/m/Y',
                'return_format'  => 'Y-m-d', // 🔥 important pour tri
            ])

            ->addDatePicker('date_fin', [
                'label' => 'Date fin',
                'required' => 1,
                'display_format' => 'd/m/Y',
                'return_format'  => 'Y-m-d',
            ])

            ->addDatePicker('prochaine_date', [
                'label' => 'Prochaine date',
                'display_format' => 'd/m/Y',
                'return_format'  => 'Y-m-d',
            ])

            ->addText('lieu', [
                'label' => 'Lieu',
                'required' => 1,
            ])

            ->addText('ville', [
                'label' => 'Ville',
                'required' => 1,
            ])

            ->addWysiwyg('description', [
                'label' => 'Description',
                'tabs' => 'visual',
                'media_upload' => 0,
            ])

            ->addImage('image', [
                'label' => 'Image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ])

            ->addTrueFalse('featured_post', [
                'label' => 'Mettre en avant',
                'ui' => 1, // ✅ switch UI
                'ui_on_text' => 'Oui',
                'ui_off_text' => 'Non',
                'default_value' => 0,
            ]);

        acf_add_local_field_group($agenda->build());
    }
}

AgendaFields::register();