@extends('layouts.app-logged-in')

@section('content')
    {!! pageBanner([
      'image' => get_template_directory_uri() . '/front/images/ocean.jpg',
      'title' => get_the_title(),
    ]) !!}
  <div class="container container--narrow page-section">

    <div class="create-note">
      <h2 class="headline headline--medium">Create new note</h2>

      <input class="new-note-title" type="text" value="" placeholder="Title">
      <textarea class="new-note-body" placeholder="Your note here" ></textarea>
      <span class="submit-note">Create Note</span>
      <span class="note-limit-message">Note limit reached</span>

    </div>

    <ul id="my-notes" class="min-list link-list">

      @php
        $userNotes = new WP_Query([
          'post_type' => 'note',
          'posts_per_page' => -1,
          'author' => get_current_user_id(),
        ]);
      @endphp

      @while ( $userNotes->have_posts() )
        @php
          $userNotes->the_post();
        @endphp

        @include('partials.content-notes')


      @endwhile

      @php
        wp_reset_postdata();
      @endphp


    </ul>



  </div>
@endsection
