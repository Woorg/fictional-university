class Search {

  // init object

  constructor() {
    this.body = document.querySelector('body')
    this.openButton = document.querySelector('.search-trigger')
    this.closeButton = document.querySelector('.search-overlay__close')
    this.searchOverlay = document.querySelector('.search-overlay')
    this.searchField = document.querySelector('#search-term')
    this.results = document.querySelector('#search-results')
    this.anyField = document.querySelectorAll('input, textarea')
    this.events()
    this.isOverlayOpen = false
    this.isSpinnerVisible = false
    this.previousValue
    this.typingTimer
  }

  // Events

  events() {
    this.openButton.addEventListener("click", (e) => {
      e.preventDefault()
      this.openOverlay()
    })
    this.closeButton.addEventListener("click", () => this.closeOverlay())
    this.body.addEventListener('keydown', (e) =>  this.keyPressDispatcher(e))
    this.searchField.addEventListener('keyup', () => this.typingLogic(), true)

  }

  // Methods

  typingLogic() {
    if ( this.searchField.value !== this.previousValue ) {

      clearTimeout(this.typingTimer)

      if ( !this.searchField.value ) {
        this.results.innerHTML = ''
        this.isSpinnerVisible = false
      } else if ( this.searchField.value ) {

        if ( !this.isSpinnerVisible ) {
          this.results.innerHTML = '<div class="' + 'spinner-loader"></div>'
          this.isSpinnerVisible = true
        }

        this.typingTimer = setTimeout( () => this.getResults() , 300)

      }

    }

    this.previousValue = this.searchField.value

  }

  getResults() {

    fetch( fictionalUniversityData.rootUrl + '/wp-json/university/v1/search?term=' + this.searchField.value )
      .then((response) => { return response.json() })
      .then((results) => {
        this.results.innerHTML = `
          <div class="row">
            <div class="one-third">
              <h2 class="search-overlay__section-title">General info</h2>

              ${ results.generalInfo.length > 0 ?
                '<ul class="link-list min-list">' : '<p>No general information matches that search</p>'
              }

              ${ results.generalInfo.map(item =>
                `<li>
                  <a href="${item.permalink}">${item.title}</a>
                  ${ item.postType === 'post' ? `by ${item.authorName}` : ''}
                </li>`).join('')}

              ${ results.generalInfo.length > 0 ? '</ul>' : '' }

            </div>
            <div class="one-third">
              <h2 class="search-overlay__section-title">Programs</h2>

              ${ results.programs.length > 0 ?
                '<ul class="link-list min-list">' :
                `<p>No program match that search.
                  <a href="${fictionalUniversityData.rootUrl}/programs">View all Programs</a>
                </p>`
              }

              ${ results.programs.map(item =>
                `<li>
                  <a href="${item.permalink}">${item.title}</a>
                </li>`).join('')}

              ${ results.programs.length > 0 ? '</ul>' : '' }

              <h2 class="search-overlay__section-title">Professors</h2>

              ${ results.professors.length > 0 ?
                '<ul class="professor-cards">' :
                `<p>No Professors match that search.</p>`
              }

              ${ results.professors.map(item =>
                `<li class="professor-card__list-item">
                  <a class="professor-card" href="${item.permalink}">
                    ${item.image}
                    <span class="professor-card__name">${item.title}</span>

                  </a>
                </li>`).join('')}

              ${ results.professors.length > 0 ? '</ul>' : '' }

            </div>
            <div class="one-third">
              <h2 class="search-overlay__section-title">Campuses</h2>

              ${ results.campuses.length > 0 ?
                '<ul class="link-list min-list">' :
                `<p>No Campus match that search.
                  <a href="${fictionalUniversityData.rootUrl}/campuses">View all Campuses</a>
                </p>`
              }

              ${ results.campuses.map(item =>
                `<li>
                  <a href="${item.permalink}">${item.title}</a>
                </li>`).join('')}

              ${ results.campuses.length > 0 ? '</ul>' : '' }

              <h2 class="search-overlay__section-title">Events</h2>

              ${ results.events.length > 0 ?
                '' :
                `<p>No events match that search.
                  <a href="${fictionalUniversityData.rootUrl}/events">View all events</a>
                </p>`
              }

              ${ results.events.map(item =>
                `<div class="event-summary">

                    <a class="event-summary__date t-center" href="${item.permalink}">
                      <span class="event-summary__month">${item.month}</span>
                      <span class="event-summary__day">${item.day}</span>
                    </a>
                    <div class="event-summary__content">
                      <h5 class="event-summary__title headline headline--tiny">
                        <a href="${item.permalink}">${item.title}</a>
                      </h5>
                      <p>${item.excerpt}</p>
                    </div>

                  </div>`
                ).join('') }


            </div>
          </div>
        `
        this.isSpinnerVisible = false
      })
      .catch( error => console.log('Request pages failed', error))

  }

  // Refactor that code later

  keyPressDispatcher(e) {

    // if ( e.keyCode === 83 && !this.isOverlayOpen ) {
    //   this.openOverlay()

    // } else if ( e.keyCode === 27 && this.isOverlayOpen ) {
    //   this.closeOverlay()
    // }

    if ( e.keyCode === 27 && this.isOverlayOpen ) {
      this.closeOverlay()
    }

  }

  openOverlay() {
    this.searchOverlay.classList.add('search-overlay--active')
    this.body.classList.add('body-no-scroll')
    this.searchField.value = ''
    setTimeout(() => this.searchField.focus(), 301)
    this.isOverlayOpen = true
    // e.preventDefault()
    return false
  }

  closeOverlay() {
    this.searchOverlay.classList.remove('search-overlay--active')
    this.body.classList.remove('body-no-scroll')
    this.isOverlayOpen = false
  }

}

export default Search
