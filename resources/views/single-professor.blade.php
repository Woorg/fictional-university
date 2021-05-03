@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp


    {!! pageBanner() !!}

    <div class="container container--narrow page-section">
      <article @php post_class('post-item') @endphp>

        <div class="generic-content entry-content">
          <div class="row group">
            <div class="one-third">{{ the_post_thumbnail('profPortrait') }}</div>
            <div class="two-third">

              @php
                $like_count = new WP_Query([
                  'post_type'  => 'like',
                  'meta_query' => [
                    [
                      'key'     => 'crb_liked_professor_id',
                      'compare' => '=',
                      'value'   => get_the_ID(),
                    ],
                  ]
                ]);


                $exist_status = 'no';


                $exist_query = new WP_Query([
                  'author'     => get_current_user_id(),
                  'post_type'  => 'like',
                  'meta_query' => [
                    [
                      'key'     => 'crb_liked_professor_id',
                      'compare' => '=',
                      'value'   => get_the_ID(),
                    ],
                  ]
                ]);

              @endphp

              @if ( $exist_query->found_posts )

                @php
                  $exist_status = 'yes';
                @endphp

              @endif

              <span class="like-box" data-exists="{{ $exist_status }}">
                <i class="fa fa-heart-o" aria-hidden="true"></i>
                <i class="fa fa-heart" aria-hidden="true"></i>
                <span class="like-count">{{ $like_count->found_posts }}</span>
              </span>
              {!! the_content() !!}
            </div>
          </div>
        </div>

        @php
          $relatedPrograms = carbon_get_post_meta( get_the_ID(), 'crb_related_program' );
          $relatedProgramId = wp_list_pluck($relatedPrograms, 'id');

          $relatedProgramQuery = new Wp_Query([
            'post_type'=> 'program',
            'post__in' => $relatedProgramId,
          ]);

        @endphp


        @if ($relatedProgramQuery->have_posts())
          <hr class="section-break" />
          <h2 class="headline headline--medium">Related program(s)</h2>
          <ul class="link-list min-list">

            @while ( $relatedProgramQuery->have_posts() ) @php $relatedProgramQuery->the_post(); @endphp

              <li><a href="{{ the_permalink() }}">{{ the_title() }}</a></li>

            @endwhile @php wp_reset_postdata(); @endphp
          </ul>
        @endif

        <footer>
          {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
        </footer>

        {{-- @php comments_template('/partials/comments.blade.php') @endphp --}}
      </article>

    </div>

  @endwhile
@endsection
