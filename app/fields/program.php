<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


add_action( 'carbon_fields_register_fields', function () {

    Container::make( 'post_meta', __('Professor extra fields', 'sage') )
        ->where( 'post_type' , '=', 'professor')
        ->add_fields([

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
