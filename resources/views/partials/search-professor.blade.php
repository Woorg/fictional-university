<article class="professor-card__list-item">
  <a class="professor-card" href="{{ the_permalink() }}">
    {{ the_post_thumbnail('profLandscape', ['class' => 'professor-card__image']) }}
    <span class="professor-card__name">{{ the_title() }}</span>
  </a>
</article>
