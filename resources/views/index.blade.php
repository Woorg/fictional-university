@extends('layouts.app')

@section('content')

  {{ pageBanner() }}

    <div class="container container--narrow page-section">
      @while (have_posts()) @php the_post() @endphp
        @include('partials.content-single')
      @endwhile

      {!! paginate_links() !!}
    </div>

@endsection

