function getNextPost() {
    // todo add ajax request here
    document.querySelector('#post').insertAdjacentHTML('afterend', '<p>test</p>');
}

window.addEventListener('scroll', () => {
    if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight) {
        getNextPost();
    }
})

getNextPost();