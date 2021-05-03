@extends('layouts.app')

@section('content')

  {{ pageBanner() }}

  <div class="container container--narrow page-section">

    @while(have_posts()) @php the_post() @endphp
      @php
        $today = date('Y-m-d');
        $month = get_the_time( 'M', get_the_ID() );
        $eventDateField = carbon_get_post_meta(get_the_ID(), 'crb_event_date');
        $eventDate = new DateTime($eventDateField);
        $content = get_the_content();
      @endphp

      @include('partials.event')

    @endwhile

    {!! paginate_links(  ) !!}

    <hr class="section-break">

    <p>Looking for a recap of past events? <a href="{{ site_url('/past-events') }}">Check out our past events archive</a></p>

  </div>

@endsection
