@extends('layouts.app')

@section('content')

  {{ pageBanner([
    'subtitle' => get_the_archive_description()
    ]) }}

  <div class="container container--narrow page-section">

    @while(have_posts()) @php the_post() @endphp

      <article @php post_class('post-item') @endphp>
        <h2 class="headline headline--medium headline--post-title entry-title"><a href="{{ the_permalink() }}">{!! get_the_title() !!}</a></h2>

        <div class="metabox">
          @include('partials/entry-meta')
        </div>

        <div class="generic-content entry-content">
          @php the_content() @endphp
        </div>

        <footer>
          {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
        </footer>

      </article>

    @endwhile

    {!! paginate_links(  ) !!}

  </div>

@endsection
