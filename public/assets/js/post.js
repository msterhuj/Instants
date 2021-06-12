function request(url, method, data, callback) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    if (data) xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                callback(this.responseText)
            } else alert('Il y a eu un problème avec la requête.');
        }
    }
    if (data) xhr.send(data)
    else xhr.send()
}

function newPost() {
    request("/api/post",
        "POST",
        "content=" + document.querySelector("#post-data").value,
        (result) => {document.location.reload()})
}

function newReply(id) {
    request("/api/post",
        "POST",
        "content=" + document.querySelector("#post-data-reply-"+id).value + "&reply=" + id,
        (result) => {document.location.reload()})
}

function like(postId) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/api/like/' + postId, true);
    xhr.onreadystatechange = function () {
        if (this.readyState === XMLHttpRequest.DONE) {
            if (this.status === 200) {
                alert(this.responseText)
            } else {
                alert("Error for like")
            }
        }
    }
    xhr.send();
}