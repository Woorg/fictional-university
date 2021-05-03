<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


add_action( 'carbon_fields_register_fields', function () {

    Container::make( 'post_meta', __('Liked Professor', 'sage') )
        ->where( 'post_type' , '=', 'like')
        ->add_fields([

            Field::make( 'text', 'crb_liked_professor_id', __( 'Liked Professor ID' ) )
                ->set_attribute( 'type', 'number' )
                // ->set_visible_in_rest_api( $visible = true )

        ]);

});


