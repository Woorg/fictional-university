<article class="event-summary">
  <a class="event-summary__date t-center" href="{{ the_permalink() }}">
    <span class="event-summary__month">{{ $eventDate->format('M') }}</span>
    <span class="event-summary__day">{{ $eventDate->format('d') }}</span>
  </a>
  <div class="event-summary__content">
    <h5 class="event-summary__title headline headline--tiny"><a href="{{ the_permalink() }}">{{ the_title() }}</a></h5>
    <p>{!! wp_trim_words( $content , 18, null ) !!} <a href="{{ the_permalink() }}" class="nu gray">Learn more</a></p>
  </div>
</article>
