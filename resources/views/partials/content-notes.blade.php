<li data-id="{{ the_ID() }}" >
  <input class="note-title-field" type="text" value="{{ str_replace('Private:', '', esc_attr( get_the_title() )) }}" readonly>
  <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
  <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
  <textarea class="note-body-field" readonly>{!! esc_textarea(get_the_excerpt()) !!}</textarea>
  <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
</li>


