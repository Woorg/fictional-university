<?php

namespace App;

use Carbon_Fields\Container;
use Carbon_Fields\Field;


add_action( 'carbon_fields_register_fields', function () {

    Container::make( 'post_meta', __('Page banner', 'sage') )
        ->where( 'post_type', '=', 'post')
        ->or_where( 'post_type', '!=', 'post' )
        ->add_fields([

            Field::make( 'textarea', 'crb_page_banner_subtitle', __( 'Page banner subtitle', 'sage' ) )
                ->set_rows( 4 ),

            Field::make( 'image', 'crb_page_banner_image', __( 'Page banner Image', 'sage' ) )


        ]);


    Container::make( 'theme_options', __('Event archive options', 'sage') )
        ->set_page_parent( 'edit.php?post_type=event' )


        ->add_fields([

            Field::make( 'textarea', 'crb_event_banner_subtitle', __( 'Page banner subtitle', 'sage' ) )
                ->set_rows( 4 ),

            Field::make( 'image', 'crb_event_banner_image', __( 'Page banner Image', 'sage' ) )

        ]);


    Container::make( 'theme_options', __('Program archive options', 'sage') )
        ->set_page_parent( 'edit.php?post_type=program' )


        ->add_fields([

            Field::make( 'textarea', 'crb_program_banner_subtitle', __( 'Page banner subtitle', 'sage' ) )
                ->set_rows( 4 ),

            Field::make( 'image', 'crb_program_banner_image', __( 'Page banner Image', 'sage' ) )

        ]);


    Container::make( 'theme_options', __('Professor archive options', 'sage') )
        ->set_page_parent( 'edit.php?post_type=professor' )


        ->add_fields([

            Field::make( 'textarea', 'crb_professor_banner_subtitle', __( 'Page banner subtitle', 'sage' ) )
                ->set_rows( 4 ),

            Field::make( 'image', 'crb_professor_banner_image', __( 'Page banner Image', 'sage' ) )

        ]);

    Container::make( 'theme_options', __('Blog archive options', 'sage') )
        ->set_page_parent( 'edit.php' )

        ->add_fields([

            Field::make( 'text', 'crb_block_banner_title', __( 'Page banner title' ) ),

            Field::make( 'textarea', 'crb_block_banner_subtitle', __( 'Page banner subtitle', 'sage' ) )
                ->set_rows( 4 ),

            Field::make( 'image', 'crb_block_banner_image', __( 'Page banner Image', 'sage' ) )

        ]);


    Container::make( 'theme_options', __('Campuses archive options', 'sage') )
        ->set_page_parent( 'edit.php?post_type=campus' )

        ->add_fields([

            Field::make( 'text', 'crb_campus_banner_title', __( 'Page banner title' ) ),

            Field::make( 'textarea', 'crb_campus_banner_subtitle', __( 'Page banner subtitle', 'sage' ) )
                ->set_rows( 4 ),

            Field::make( 'image', 'crb_campus_banner_image', __( 'Page banner Image', 'sage' ) )

        ]);



});


// Load Carbon Fields

// \Carbon_Fields\Carbon_Fields::boot();
