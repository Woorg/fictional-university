@php
  $today = date('Y-m-d');
  $month = get_the_time( 'M', get_the_ID() );
  $eventDateField = carbon_get_post_meta(get_the_ID(), 'crb_event_date');
  $eventDate = new DateTime($eventDateField);
  $content = get_the_content();
@endphp

<article class="post-item event-summary">
  <a class="event-summary__date t-center" href="{{ the_permalink() }}">
    <span class="event-summary__month">{{ $eventDate->format('M') }}</span>
    <span class="event-summary__day">{{ $eventDate->format('d') }}</span>
  </a>
  <div class="event-summary__content">
    <h5 class="event-summary__title headline headline--tiny"><a href="{{ the_permalink() }}">{{ the_title() }}</a></h5>
    <p>{!! wp_trim_words( $content , 18, null ) !!} <a href="{{ the_permalink() }}" class="nu gray">Learn more</a></p>
  </div>
</article>
