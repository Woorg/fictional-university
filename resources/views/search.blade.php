@extends('layouts.app')

@section('content')

  {{ pageBanner([
    'title' => 'Search results',
    'subtitle' => 'you searched for ‘' . esc_html( get_search_query() ) . '‘'
  ]) }}

    <div class="container container--narrow page-section">
      @while (have_posts()) @php the_post() @endphp
        @include('partials.search-' . get_post_type() )
      @endwhile

      {!! paginate_links() !!}
    </div>

@endsection

