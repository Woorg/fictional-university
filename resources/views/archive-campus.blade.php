@extends('layouts.app')

@section('content')

  {{ pageBanner() }}

  <div class="container container--narrow page-section">

    <div class="acf-map">

      @while(have_posts()) @php the_post() @endphp
        @php
          $campus_location = carbon_get_post_meta( get_the_ID(), 'crb_campus_location' );
        @endphp


        <div class="marker" data-lat="{{ $campus_location['lat'] }}" data-lng="{{ $campus_location['lng'] }}">
          <h3><a href="{{ the_permalink() }}">{{ the_title() }}</a></h3>
          {{ $campus_location['address'] }}
        </div>

        {{-- @dump($campus_location) --}}


      @endwhile

    </div>

    {{-- {!! paginate_links() !!} --}}

  </div>

@endsection
