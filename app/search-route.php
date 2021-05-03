<?php

add_action('rest_api_init', 'fictional_register_search');

function fictional_register_search() {

    register_rest_route('university/v1', 'search', [
        'methods' => WP_REST_SERVER::READABLE,
        'callback' => 'universitySearchResults'
    ]);

    function universitySearchResults( $data ) {

        $mainQuery = new WP_Query([
            // 'posts_per_page' => -1,
            'post_type' => [
                'post',
                'page',
                'event',
                'campus',
                'program',
                'professor'
            ],
            's' => sanitize_text_field( $data['term'] ),
        ]);

        $results = [
            'generalInfo' => [],
            'professors'  => [],
            'programs'    => [],
            'events'      => [],
            'campuses'    => [],
        ];

        while ( $mainQuery->have_posts() ):
            $mainQuery->the_post();

            if (
                get_post_type() === 'post' ||
                get_post_type() === 'page' ):

                array_push( $results['generalInfo'], [
                    'title'      => get_the_title(),
                    'permalink'  => get_the_permalink(),
                    'postType'   => get_post_type(),
                    'authorName' => get_the_author(),
                ]);

            endif;

            if ( get_post_type() === 'professor' ):


                array_push( $results['professors'], [
                    'title'     => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'image'     => get_the_post_thumbnail(
                        get_the_ID(),
                        'profLandscape',
                        [ 'class' => 'professor-card__image' ]
                    ),

                    // 'content'   => get_the_content(),
                ]);

            endif;

            if ( get_post_type() === 'program' ):

                $relatedCampuses = carbon_get_post_meta( get_the_ID(), 'crb_related_campus' );

                $relatedCampusesId = wp_list_pluck($relatedCampuses, 'id');

                if ( $relatedCampuses ) {

                    $relatedCampusesQuery = new Wp_Query([
                        'post_type' => 'campus',
                        'post__in'  => $relatedCampusesId,
                    ]);

                    while ( $relatedCampusesQuery->have_posts() ) {

                        $relatedCampusesQuery->the_post();

                        array_push( $results['campuses'], [
                            'title'     => get_the_title(),
                            'permalink' => get_the_permalink(),
                        ]);

                    } wp_reset_postdata();

                }


                array_push( $results['programs'], [
                    'id'        => get_the_ID(),
                    'title'     => get_the_title(),
                    'permalink' => get_the_permalink(),
                    // 'content'   => get_the_content(),
                ]);

            endif;

            if ( get_post_type() === 'event' ):

                $eventDateField = carbon_get_post_meta(get_the_ID(), 'crb_event_date');
                $eventDate = new DateTime($eventDateField);

                array_push( $results['events'], [
                    'title'     => get_the_title(),
                    'permalink' => get_the_permalink(),
                    'month'     => $eventDate->format('M'),
                    'day'       => $eventDate->format('d'),
                    'excerpt'   => wp_trim_words(
                        get_the_content() ,
                        18,
                        null
                    ),
                ]);

            endif;

            if ( get_post_type() === 'campus' ):

                array_push( $results['campuses'], [
                    'title'     => get_the_title(),
                    'permalink' => get_the_permalink(),
                    // 'content'   => get_the_content(),
                ]);

            endif;

        endwhile;




        if ( $results['programs'] ) {

            $programsMetaQuery = [ 'relation' => 'OR' ];

            foreach ( $results['programs'] as $item ):
                array_push( $programsMetaQuery, [
                    'key' => 'crb_related_program',
                    'value'    => $item['id'],
                    'compare'  => 'LIKE',
                ] );

            endforeach;


            $programRelationalshipQuery = new WP_Query([
                'post_type' => [
                    'professor',
                    'event'
                ],
                'meta_query' => $programsMetaQuery,
            ]);


            while ( $programRelationalshipQuery->have_posts() ):
                $programRelationalshipQuery->the_post();

                $eventDateField = carbon_get_post_meta(get_the_ID(), 'crb_event_date');
                $eventDate = new DateTime($eventDateField);

                if ( get_post_type() === 'professor' ):

                    array_push( $results['professors'], [
                        'title'     => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'image'     => get_the_post_thumbnail(
                            get_the_ID(),
                            'profLandscape',
                            [ 'class' => 'professor-card__image' ]
                        ),

                    ]);

                endif;

                if ( get_post_type() === 'event' ):

                    array_push( $results['events'], [
                        'title'     => get_the_title(),
                        'permalink' => get_the_permalink(),
                        'month'     => $eventDate->format('M'),
                        'day'       => $eventDate->format('d'),
                        'excerpt'   => wp_trim_words(
                            get_the_content() ,
                            18,
                            null
                        ),

                    ]);

                endif;

            endwhile;

            $results['professors'] = array_unique(
                $results['professors'],
                SORT_REGULAR
            );

            $results['events'] = array_unique(
                $results['events'],
                SORT_REGULAR
            );

            $results['campuses'] = array_unique(
                $results['campuses'],
                SORT_REGULAR
            );


        }


        return $results;

    }

}
