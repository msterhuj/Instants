const container = document.querySelector('.posts');

function getNextPost() {
    // todo add ajax request here
    const p = document.createElement('p')
    p.textContent = "this is a post"
    container.appendChild(p)
}

window.addEventListener('scroll', () => {
    if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight) {
        getNextPost()
    }
})

getNextPost()