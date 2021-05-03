@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    {!! pageBanner() !!}

    <div class="container container--narrow page-section">
      <article @php post_class('post-item') @endphp>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p><a class="metabox__blog-home-link" href="{!! get_post_type_archive_link('campus') !!}"><i class="fa fa-home" aria-hidden="true"></i> All campuses </a }}</a> <span class="metabox__main">{{ the_title() }}</span></p>
        </div>


        <div class="generic-content entry-content">
          @php the_content() @endphp
        </div>

        @php

          $relatedPrograms = new Wp_Query([
            'posts_per_page' => -1,
            'post_type' => 'program',
            'meta_query' => [
              [
                'key' => 'crb_related_campus',
                'value'    => get_the_ID(),
                'compare'  => 'LIKE',
              ]
            ],
            'orderby'  => 'title',
            'order'    => 'ASC',
            // 'no_found_rows' => true,

          ]);
        @endphp

        @if ( $relatedPrograms->have_posts() )

          <hr class="section-break" />

          <h2 class="headline headline--medium">Related {{ the_title() }} program's</h2>

          <ul class="link-list min-list">


          @while ( $relatedPrograms->have_posts() )
            @php
              $relatedPrograms->the_post();

              $content = get_the_content();
            @endphp

            <li><a href="{{ the_permalink() }}">{{ the_title() }}</a></li>

          @endwhile

          </ul>

        @php wp_reset_postdata(); @endphp

        @endif


        @php

          $today = date('Y-m-d');

          $homePageEvents = new Wp_Query([
            'posts_per_page' => 2,
            'post_type' => 'event',
            'meta_query' => [
              [
                'key' => 'crb_event_date',
                'value'    => $today,
                'compare'  => '>=',
              ],
              [
                'key' => 'crb_related_campus',
                'value'    => get_the_ID(),
                'compare'  => 'LIKE',
              ],
            ],
            'orderby'  => 'crb_event_date',
            'order'    => 'ASC',
            'no_found_rows' => true,
          ]);
        @endphp

        @if ( $homePageEvents->have_posts() )

          <hr class="section-break" />

          <h2 class="headline headline--medium">Upcoming events</h2>

          @while ( $homePageEvents->have_posts() )
            @php
              $homePageEvents->the_post();

              $today = date('Y-m-d');
              $month = get_the_time( 'M', get_the_ID() );
              $eventDateField = carbon_get_post_meta(get_the_ID(), 'crb_event_date');
              $eventDate = new DateTime($eventDateField);
              $content = get_the_content();
            @endphp

            @include('partials.event')

          @endwhile @php wp_reset_postdata(); @endphp

        @endif


        <hr class="section-break" />

        <div class="acf-map">

          @php
            $campus_location = carbon_get_post_meta( get_the_ID(), 'crb_campus_location' );
          @endphp

          <div class="marker" data-lat="{{ $campus_location['lat'] }}" data-lng="{{ $campus_location['lng'] }}">
            <h3>{{ the_title() }}</h3>
            {{ $campus_location['address'] }}
          </div>

        </div>


        <footer>
          {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
        </footer>

        {{-- @php comments_template('/partials/comments.blade.php') @endphp --}}
      </article>

    </div>

  @endwhile
@endsection
