{!! pageBanner([
  'image' => get_template_directory_uri() . '/front/images/ocean.jpg',
  'title' => get_the_title(),
  ]) !!}

  <div class="container container--narrow page-section">
    @php
        $theParent = wp_get_post_parent_id( get_the_ID() );
    @endphp

    @if ( wp_get_post_parent_id( get_the_ID() ) )
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="{{ get_the_permalink( $theParent ) }}"><i class="fa fa-home" aria-hidden="true"></i> Back to {{ get_the_title($theParent) }}</a }}</a> <span class="metabox__main">{{ the_title() }}</span></p>
    </div>

    @endif

    @if ( $theParent )

    <div class="page-links">
      <h2 class="page-links__title"><a href="{{ get_permalink( $theParent ) }}">{{ get_the_title( $theParent ) }}</a></h2>
      <ul class="min-list">
        @if ( $theParent )
            @php
                $findChildrenOf = $theParent;
            @endphp
        @else
            @php
                $findChildrenOf = get_the_ID();
            @endphp
        @endif

        {{ wp_list_pages( [
            'title_li' => null,
            'child_of' =>  $findChildrenOf
        ] ) }}

      </ul>
    </div>

    @endif

    <div class="generic-content">
      <form class="search-form" method="get" action="{{ esc_url( site_url('/') ) }}">
        <label class="headline headline--medium" for="search">Perform new search</label>

        <div class="search-form-row">
          <input id="search" class="s" type="search" name="s" placeholder="What are you you looking for?">
          <input class="search-submit" type="submit" value="Search">
        </div>

      </form>


      {{-- {{ the_content() }} --}}
    </div>

  </div>

  {{-- <div class="page-section page-section--beige">
    <div class="container container--narrow generic-content">
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>

      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
    </div>
  </div> --}}

  {{-- <div class="page-section page-section--white">

   <div class="container container--narrow">
      <h2 class="headline headline--medium">Biology Professors:</h2>

      <ul class="professor-cards">
       <li class="professor-card__list-item">
       <a href="#" class="professor-card">
           <img class="professor-card__image" src="images/barksalot.jpg">
           <span class="professor-card__name">Dr. Barksalot</span>
         </a>
       </li>
       <li class="professor-card__list-item">
       <a href="#" class="professor-card">
           <img class="professor-card__image" src="images/meowsalot.jpg">
           <span class="professor-card__name">Dr. Meowsalot</span>
         </a>
       </li>
     </ul>
     <hr class="section-break">

    <div class="row group generic-content">

      <div class="one-third">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
      </div>

      <div class="one-third">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
      </div>

      <div class="one-third">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officia voluptates vero vel temporibus aliquid possimus, facere accusamus modi. Fugit saepe et autem, laboriosam earum reprehenderit illum odit nobis, consectetur dicta. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos molestiae, tempora alias atque vero officiis sit commodi ipsa vitae impedit odio repellendus doloremque quibusdam quo, ea veniam, ad quod sed.</p>
      </div>
    </div>

  </div> --}}

</div>

