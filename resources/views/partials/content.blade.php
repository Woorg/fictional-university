<div class="page-banner">
  <div class="page-banner__bg-image" style="background-image: url( {{ get_template_directory_uri() . '/front/images/library-hero.jpg' }} ); "></div>
  <div class="page-banner__content container t-center c-white">
    <h1 class="headline headline--large">Welcome!</h1>
    <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
    <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
    <a href="{{ get_post_type_archive_link( 'program' ) }}" class="btn btn--large btn--blue">Find Your Major</a>
  </div>
</div>

<div class="full-width-split group">

  <div class="full-width-split__one">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

      @php

        $today = date('Y-m-d');

        $homePageEvents = new Wp_Query([
          'posts_per_page' => 2,
          'post_type' => 'event',
          'meta_query' => [
            [
              'crb_event_date' => [
                'key' => 'crb_event_date',
                'value'    => $today,
                'compare'  => '>=',
              ]
            ]
          ],
          'orderby'  => 'crb_event_date',
          'order'    => 'ASC',
          'no_found_rows' => true,
        ]);
      @endphp

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

      @endwhile

      @php
        wp_reset_postdata();
      @endphp

      <p class="t-center no-margin"><a href="{!! get_post_type_archive_link( 'event' ) !!}" class="btn btn--blue">View All Events</a></p>
    </div>
  </div>

  <div class="full-width-split__two">
    <div class="full-width-split__inner">
      <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>

      @php
        $homePagePosts = new Wp_Query([
          'posts_per_page' => 2
        ]);
      @endphp

      @while ( $homePagePosts->have_posts() ) @php $homePagePosts->the_post(); @endphp

      <div class="event-summary">
        <a class="event-summary__date event-summary__date--beige t-center" href="{{ the_permalink() }}">
          @php
            $month = get_the_time( 'M', get_the_ID() );
            $day = get_the_time( 'j', get_the_ID() );
            $content = get_the_content();

          @endphp

          <span class="event-summary__month">{{ $month }}</span>
          <span class="event-summary__day">{{ $day }}</span>
        </a>
        <div class="event-summary__content">
          <h5 class="event-summary__title headline headline--tiny"><a href="{{ the_permalink() }}">{{ the_title() }}</a></h5>
          <p>{!! wp_trim_words( $content , 18, null ) !!} <a href="{{ the_permalink() }}" class="nu gray">Read more</a></p>
        </div>
      </div>


      @endwhile

      @php
        wp_reset_postdata();
      @endphp

      <p class="t-center no-margin"><a href="{{ site_url( '/blog' ) }}" class="btn btn--yellow">View All Blog Posts</a></p>
    </div>
  </div>
</div>

<div class="hero-slider">
  <div data-glide-el="track" class="glide__track">
    <div class="glide__slides">
      <div class="hero-slider__slide" style="background-image: url( {{ get_template_directory_uri() . '/front/images/bus.jpg' }} );">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Transportation</h2>
            <p class="t-center">All students have free unlimited bus fare.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url( {{ get_template_directory_uri() . '/front/images/apples.jpg' }} );">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
            <p class="t-center">Our dentistry program recommends eating apples.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
      <div class="hero-slider__slide" style="background-image: url( {{ get_template_directory_uri() . '/front/images/bread.jpg' }} );">
        <div class="hero-slider__interior container">
          <div class="hero-slider__overlay">
            <h2 class="headline headline--medium t-center">Free Food</h2>
            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
          </div>
        </div>
      </div>
    </div>
    <div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
  </div>
</div>
