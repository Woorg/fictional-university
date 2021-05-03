<article @php post_class('post-item') @endphp>
  <h2 class="headline headline--medium headline--post-title"><a href="{{ the_permalink() }}">{{ the_title() }}</a></h2>

  <div class="generic-content">
    {{ the_excerpt() }}
  </div>

</article>




