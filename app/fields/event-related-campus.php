<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


add_action( 'carbon_fields_register_fields', function () {

    Container::make( 'post_meta', __('Related campuses', 'sage') )
        ->where( 'post_type' , '=', 'event')
        ->add_fields([

            Field::make( 'association', 'crb_related_campus', __('Related campuses', 'sage'))
                ->set_types([
                    [
                        'type' => 'post',
                        'post_type' => 'campus'

                    ]
                ])
                ->set_visible_in_rest_api( $visible = true )

        ]);
});


// Load Carbon Fields

// \Carbon_Fields\Carbon_Fields::boot();
