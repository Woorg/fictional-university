@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    {!! pageBanner() !!}

    <div class="container container--narrow page-section">
      <article @php post_class('post-item') @endphp>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p><a class="metabox__blog-home-link" href="{!! get_post_type_archive_link('program') !!}"><i class="fa fa-home" aria-hidden="true"></i> All programs </a }}</a> <span class="metabox__main">{{ the_title() }}</span></p>
        </div>


        <div class="generic-content entry-content">
          @php
            $main_content = apply_filters(
              'the_content', carbon_get_the_post_meta( 'crb_main_content' )
            );
          @endphp

          {!! $main_content !!}

        </div>


        @php
          $relatedProfessors = new Wp_Query([
            'posts_per_page' => -1,
            'post_type' => 'professor',
            'meta_query' => [
              [

                'key' => 'crb_related_program',
                'value'    => get_the_ID(),
                'compare'  => 'LIKE',
              ]
            ],
            'orderby'  => 'title',
            'order'    => 'ASC',
            // 'no_found_rows' => true,
          ]);
        @endphp

        @if ( $relatedProfessors->have_posts() )

          <hr class="section-break" />

          <h2 class="headline headline--medium">Related {{ the_title() }} professor's</h2>

          <ul class="link-list min-list">

          @while ( $relatedProfessors->have_posts() )
            @php
              $relatedProfessors->the_post();

              $content = get_the_content();
            @endphp

            <li class="professor-card__list-item">
              <a class="professor-card" href="{{ the_permalink() }}">
                {{ the_post_thumbnail('profLandscape', ['class' => 'professor-card__image']) }}
                <span class="professor-card__name">{{ the_title() }}</span>
              </a>
            </li>

          @endwhile @php wp_reset_postdata(); @endphp

          </ul>

        @endif

        @php
          $relatedCampuses = carbon_get_post_meta( get_the_ID(), 'crb_related_campus' );
          $relatedCampusesId = wp_list_pluck($relatedCampuses, 'id');

        @endphp

        @if ( $relatedCampusesId )
          @php
            $relatedCampusesQuery = new Wp_Query([
              'post_type'=> 'campus',
              'post__in' => $relatedCampusesId,
            ]);

          @endphp

            @if ($relatedCampusesQuery->have_posts())
              <hr class="section-break" />
              <h2 class="headline headline--medium">{{ the_title() }} is available at this campuses</h2>
              <ul class="link-list min-list">

                @while ( $relatedCampusesQuery->have_posts() )
                  @php
                    $relatedCampusesQuery->the_post(  );
                  @endphp

                  <li><a href="{{ the_permalink( ) }}">{{ the_title( ) }}</a></li>

                @endwhile
                @php
                  wp_reset_postdata();
                @endphp
              </ul>
            @endif

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
                'key' => 'crb_related_program',
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

          <h2 class="headline headline--medium">Upcoming {{ the_title() }} events</h2>

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

        <footer>
          {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
        </footer>

        {{-- @php comments_template('/partials/comments.blade.php') @endphp --}}

      </article>

    </div>

  @endwhile
@endsection
