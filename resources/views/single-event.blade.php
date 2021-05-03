@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    {!! pageBanner() !!}

    <div class="container container--narrow page-section">
      <article @php post_class('post-item') @endphp>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p><a class="metabox__blog-home-link" href="{!! get_post_type_archive_link('event') !!}"><i class="fa fa-home" aria-hidden="true"></i> Events home </a }}</a> <span class="metabox__main">{{ the_title() }}</span></p>
        </div>

        <div class="generic-content entry-content">
          @php the_content() @endphp
        </div>

        @php
          $relatedPrograms = carbon_get_post_meta( get_the_ID(), 'crb_related_program' );
          $relatedProgramId = wp_list_pluck($relatedPrograms, 'id');

          $relatedProgramQuery = new Wp_Query([
            'post_type'=> 'program',
            'post__in' => $relatedProgramId,
          ]);

        @endphp

        @php
          $relatedCampuses = carbon_get_post_meta( get_the_ID(), 'crb_related_campus' );
          $relatedCampusesId = wp_list_pluck($relatedCampuses, 'id');

          $relatedCampusesQuery = new Wp_Query([
            'post_type'=> 'campus',
            'post__in' => $relatedCampusesId,
          ]);

        @endphp

        @if ($relatedCampusesQuery->have_posts())
          <hr class="section-break" />
          <h2 class="headline headline--medium">{{ the_title() }} is available at this campuses</h2>
          <ul class="link-list min-list">

            @while ( $relatedCampusesQuery->have_posts() ) @php $relatedCampusesQuery->the_post(); @endphp

              <li><a href="{{ the_permalink() }}">{{ the_title() }}</a></li>

            @endwhile @php wp_reset_postdata(); @endphp
          </ul>
        @endif

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
