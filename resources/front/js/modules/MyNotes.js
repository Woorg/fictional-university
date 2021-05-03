class MyNotes {

    constructor() {
        this.events()

    }

    // events

    events() {

        // const $notesList = document.querySelector('#my-notes')

        const $createNotes = document.querySelectorAll('.submit-note')
        const $editNotes   = document.querySelectorAll('.edit-note')
        const $updateNotes = document.querySelectorAll('.update-note')
        const $deleteNotes = document.querySelectorAll('.delete-note')

        $deleteNotes.forEach( item => {

            item.addEventListener( 'click', (e) => {
                this.deleteNote(e)
            })

        })


        $editNotes.forEach( item => {

            item.addEventListener( 'click', (e) => {
                this.editNote(e)
            }, false)

        })


        $updateNotes.forEach( item => {

            item.addEventListener( 'click', (e) => {
                this.updateNote(e)
            })

        })


        $createNotes.forEach( item => {

            item.addEventListener( 'click', (e) => {
                this.createNote(e)
            })

        })


    }


    // methods

    editNote(e) {

        let $thisNote = e.target.parentNode

        if ( $thisNote.dataset.state == 'editable' ) {
            this.makeNoteReadOnly($thisNote)
        } else {
            this.makeNoteEditable($thisNote)

        }

        const url = fictionalUniversityData.rootUrl + '/wp-json/wp/v2/note/' + $thisNote.dataset.id

    }


    makeNoteEditable($thisNote) {

        let $titleField  = $thisNote.querySelector('.note-title-field')
        let $bodyField   = $thisNote.querySelector('.note-body-field')
        let $saveButton  = $thisNote.querySelector('.update-note')
        let $editbutton  = $thisNote.querySelector('.edit-note')

        if ($thisNote) {
            $thisNote.dataset.state = 'editable'
        }

        if ($titleField) {
            $titleField.removeAttribute('readonly')
            $titleField.classList.add('note-active-field')
        }
        if ($bodyField) {
            $bodyField.removeAttribute('readonly')
            $bodyField.classList.add('note-active-field')
        }
        if ($saveButton) {
            $saveButton.classList.add('update-note--visible')
        }
        if ($editbutton) {
              $editbutton.innerHTML = '<i class="fa fa-times" aria-hidden="true"></i> Cancel'
        }

    }


    makeNoteReadOnly($thisNote) {

        let $titleField  = $thisNote.querySelector('.note-title-field')
        let $bodyField   = $thisNote.querySelector('.note-body-field')
        let $saveButton  = $thisNote.querySelector('.update-note')
        let $editbutton  = $thisNote.querySelector('.edit-note')

        if ($thisNote) {
            $thisNote.dataset.state = 'noneditable'
        }

        if ($titleField) {
            $titleField.setAttribute('readonly', 'readonly')
            $titleField.classList.remove('note-active-field')
        }
        if ($bodyField) {
            $bodyField.setAttribute('readonly', 'readonly')
            $bodyField.classList.remove('note-active-field')
        }
        if ($saveButton) {
            $saveButton.classList.remove('update-note--visible')
        }
        if ($editbutton) {
              $editbutton.innerHTML = '<i class="fa fa-pencil" aria-hidden="true"></i> Edit'
        }
    }

    async createNote(e) {

        let $notesList   = document.querySelector('#my-notes')
        let $titleField  = document.querySelector('.new-note-title')
        let $bodyField   = document.querySelector('.new-note-body')

        let createdPost = {
            'title' : $titleField.value,
            'content' : $bodyField.value,
            'status' : 'publish',
        }

        if ( $titleField.value && $bodyField.value ) {


            const url = fictionalUniversityData.rootUrl + '/wp-json/wp/v2/note/'


            try {
                let response = await fetch(url, {
                    method: 'POST', // *GET, POST, PUT, DELETE, etc.
                    headers: {
                      'X-WP-Nonce': fictionalUniversityData.nonce,
                      'Content-Type': 'application/json'
                    },
                    mode: 'same-origin',
                    body: JSON.stringifycreatedPost,
                })

                let item = await response.json() // parses JSON response into native JavaScript objects

                if ( item.noteCount >=4 ) {
                    document.querySelector('.note-limit-message').classList.add('active');
                } else {
                    document.querySelector('.note-limit-message').classList.remove('active');
                }

                console.log( 'Success:', response.json() )

                $titleField.value = ''
                $bodyField.value = ''

                $notesList.insertAdjacentHTML(
                    'afterBegin',

                    `<li data-id="${item.id}">
                        <input class="note-title-field" type="text" value="${item.title.raw}" readonly>
                            <span class="edit-note"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</span>
                            <span class="delete-note"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</span>
                        <textarea class="note-body-field" readonly>${item.content.raw}</textarea>
                        <span class="update-note btn btn--blue btn--small"><i class="fa fa-arrow-right" aria-hidden="true"></i> Save</span>
                    </li>`

                )


                document.querySelector(".delete-note").addEventListener( 'click', (e) => {
                    this.deleteNote(e)
                })

                document.querySelector(".edit-note").addEventListener( 'click', (e) => {
                    this.editNote(e)
                }, false)

                document.querySelector(".update-note").addEventListener( 'click', (e) => {
                    this.updateNote(e)
                })

                document.querySelector(".submit-note").addEventListener( 'click', (e) => {
                    this.createNote(e)
                })



            } catch (error) {

                console.log('Возникла проблема с вашим fetch запросом: ', error)

            }
        }



    }


    async updateNote(e) {

        let $thisNote = e.target.parentNode

        let $titleField  = $thisNote.querySelector('.note-title-field')
        let $bodyField   = $thisNote.querySelector('.note-body-field')

        // console.log($titleField.value, $bodyField.value)

        let updatedPost = {
            'title' : $titleField.value,
            'content' : $bodyField.value,
        }

        const url = fictionalUniversityData.rootUrl + '/wp-json/wp/v2/note/' + $thisNote.dataset.id

        try {
            const response = await fetch(url, {
                method: 'POST', // *GET, POST, PUT, DELETE, etc.
                headers: {
                  'X-WP-Nonce': fictionalUniversityData.nonce,
                  'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedPost),
            })

            const json = await response.json() // parses JSON response into native JavaScript objects

            console.log('Success:', json)

            this.makeNoteReadOnly($thisNote)

        } catch (error) {

            console.error('Error:', error)

        }

    }



    async deleteNote(e) {
        let $thisNote = e.target.parentNode

        const url = fictionalUniversityData.rootUrl + '/wp-json/wp/v2/note/' + $thisNote.dataset.id

        try {
            const response = await fetch(url, {
                method: 'DELETE', // *GET, POST, PUT, DELETE, etc.
                headers: {
                  'X-WP-Nonce': fictionalUniversityData.nonce,
                },
            })

            const json = await response.json() // parses JSON response into native JavaScript objects
            console.group('Success:', json)
            $thisNote.remove()

        } catch (error) {
            console.error('Error:', error)
        }
    }



}


export default MyNotes
