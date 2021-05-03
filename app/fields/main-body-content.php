<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


add_action( 'carbon_fields_register_fields', function () {

    Container::make( 'post_meta', __('Main Content', 'sage') )
        ->where( 'post_type' , '=', 'program')
        ->add_fields([

            Field::make('rich_text', 'crb_main_content', __( 'Main Content' ))
                ->set_visible_in_rest_api( $visible = true )

        ]);

});


// Load Carbon Fields

// \Carbon_Fields\Carbon_Fields::boot();
