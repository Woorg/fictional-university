@extends('layouts.app')

@section('content')
  @while(have_posts()) @php the_post() @endphp

    {!! pageBanner([
      'title' => get_the_title()
      ]) !!}

    <div class="container container--narrow page-section">
      <article @php post_class('post-item') @endphp>
        <div class="metabox metabox--position-up metabox--with-home-link">
          <p><a class="metabox__blog-home-link" href="{{ site_url( '/blog' ) }}"><i class="fa fa-home" aria-hidden="true"></i> Blog home </a }}</a> <span class="metabox__main"><span class="byline author vcard">Posted {{ __('By', 'sage') }} <a href="{{ get_author_posts_url(get_the_author_meta('ID')) }}" rel="author" class="fn">{{ get_the_author() }}</a> on <time class="updated" datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time></span></span></p>
        </div>


        <div class="generic-content entry-content">
          @php the_content() @endphp
        </div>

        <footer>
          {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
        </footer>

        @php comments_template('/partials/comments.blade.php') @endphp
      </article>

    </div>

  @endwhile
@endsection
