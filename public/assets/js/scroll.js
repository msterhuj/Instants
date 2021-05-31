let offset = 0;

function getNextPost() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", '/api/post/' + offset, true);

    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200)
                document.querySelector('#post').insertAdjacentHTML('beforeend', this.responseText);
            else alert("Error Getting Posts")
        }
    }
    xhr.send();

    offset = offset + 5;
}

window.addEventListener('scroll', () => {
    if (window.scrollY + window.innerHeight >= document.documentElement.scrollHeight) {
        getNextPost();
    }
})

getNextPost();