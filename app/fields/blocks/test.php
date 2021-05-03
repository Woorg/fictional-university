<?php
    use Carbon_Fields\Block;
    use Carbon_Fields\Field;

    add_action( 'carbon_fields_register_fields', function () {
        Block::make( __( 'My Shiny Gutenberg Block' ) )
            ->add_fields([
                Field::make( 'text', 'heading', __( 'Block Heading' ) ),
                Field::make( 'image', 'image', __( 'Block Image' ) ),
                Field::make( 'rich_text', 'content', __( 'Block Content' ) ),
            ])
            ->set_category( 'custom', __( 'Custom blocks' ), 'admin-page' )
            ->set_inner_blocks( true )
            ->set_inner_blocks_position( 'below' )
            ->set_render_callback( function ( $arg ) {
                 echo get_block_template('test', $arg);
            });

    });
