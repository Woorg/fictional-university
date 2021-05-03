@extends('layouts.app')

@section('content')

  {{ pageBanner() }}

  {{-- <div class="page-banner">
      <div class="page-banner__bg-image" style="background-image: url( {{ get_template_directory_uri() . '/front/' }}images/ocean.jpg);"></div>
      <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title">{{ the_title() }}</h1>
      <div class="page-banner__intro">
        <p>A recap of our past events</p>
      </div>
    </div>
  </div> --}}

  <div class="container container--narrow page-section">

    @php
        $today = date('Y-m-d');

        $pastEvents = new WP_Query([
          'paged' => get_query_var('paged', 1),
          'posts_per_page' => 2,
          'post_type' => 'event',
          'meta_query' => [
            [
              'key' => 'crb_event_date',
              'value'    => $today,
              'compare'  => '<',
            ]
          ],
          'orderby'  => 'crb_event_date',
          'order'    => 'ASC',
          // 'no_found_rows' => true,

        ]);
    @endphp

    @while( $pastEvents->have_posts() ) @php $pastEvents->the_post() @endphp
      @php
        $today = date('Y-m-d');
        $month = get_the_time( 'M', get_the_ID() );
        $eventDateField = carbon_get_post_meta(get_the_ID(), 'crb_event_date');
        $eventDate = new DateTime($eventDateField);
        $content = get_the_content();
      @endphp

      @include('partials.event')


    @endwhile

    @php
      wp_reset_postdata();
    @endphp


    {!! paginate_links([
      'total' => $pastEvents->max_num_pages
    ]) !!}




  </div>

@endsection
