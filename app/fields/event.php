<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


add_action( 'carbon_fields_register_fields', function () {

    Container::make( 'post_meta', __('Event', 'sage') )
        ->where( 'post_type' , '=', 'event')
        ->add_fields([
            // CREATE HERE YOUR THEME OPTIONS FIELDS:
            Field::make( 'date', 'crb_event_date', __('Event date', 'sage'))
                // ->set_storage_format( 'Ymd' )
                ->set_visible_in_rest_api( $visible = true ),

            Field::make( 'association', 'crb_related_program', __('Related program', 'sage'))
                ->set_types([
                    [
                        'type' => 'post',
                        'post_type' => 'program'

                    ]
                ])
                ->set_visible_in_rest_api( $visible = true )

        ]);

});


// Load Carbon Fields

// \Carbon_Fields\Carbon_Fields::boot();
