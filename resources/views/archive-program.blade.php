@extends('layouts.app')

@section('content')

  {{ pageBanner() }}

  <div class="container container--narrow page-section">

    <ul class="link-list min-list">

    @while(have_posts()) @php the_post() @endphp

      <li><a href="{{ the_permalink() }}">{{ the_title() }}</a></li>

    @endwhile

    </ul>

    {!! paginate_links() !!}

  </div>

@endsection
