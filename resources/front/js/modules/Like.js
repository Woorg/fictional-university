class Like {

    constructor() {

    }


    events() {
        $likeBox = document.querySelector('.like-box')

        $likeBox.addEventListener( 'click', (e) => {
            this.clickDispatcher()
        })

    }


    clickDispatcher() {
        console.log('click')

    }


}


export default Like
