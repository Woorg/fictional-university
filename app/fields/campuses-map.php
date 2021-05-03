<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


add_action( 'carbon_fields_register_fields', function () {

    Container::make( 'post_meta', __('Map location', 'sage') )
        ->where( 'post_type', '=', 'campus')
        ->add_fields([

            Field::make( 'map', 'crb_campus_location', __( 'Campus location' ) )
                ->set_help_text( __( 'drag and drop the pin on the map to select location' ) )


        ]);





});


// Load Carbon Fields

// \Carbon_Fields\Carbon_Fields::boot();
