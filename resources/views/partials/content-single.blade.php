{{-- <h1>some</h1> --}}

<article @php post_class('post-item') @endphp>
  <header>
    <h2 class="headline headline--medium headline--post-title entry-title"><a href="{{ the_permalink() }}">{!! get_the_title() !!}</a></h2>
    <div class="metabox">
      @include('partials/entry-meta')
    </div>
  </header>
  <div class="generic-content entry-content">
    @php the_excerpt() @endphp
  </div>
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
